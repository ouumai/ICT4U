<?php

namespace App\Controllers;

use App\Models\DokumenModel;
use App\Models\ServisModel;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class DokumenController extends BaseController
{
    use ResponseTrait;

    protected $dokumenModel;
    protected $servisModel;
    protected string $dokumenTable = 'aict4u106mdoc';

    public function __construct()
    {
        helper(['url', 'form', 'filesystem']);
        $this->dokumenModel = new DokumenModel();
        $this->servisModel  = new ServisModel();
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }

    private function isPdfFile($file): bool
    {
        if (!$file || !$file->isValid()) {
            return false;
        }

        $allowedMimeTypes = ['application/pdf', 'application/x-pdf'];
        $extension = strtolower($file->getClientExtension() ?? '');

        return $extension === 'pdf' && in_array($file->getMimeType(), $allowedMimeTypes, true);
    }

    private function hasDokumenColumn(string $column): bool
    {
        return $this->dokumenModel->db->fieldExists($column, $this->dokumenTable);
    }

    private function resolveFolderName(?array $dokumen = null, $idservis = null): string
    {
        if (!empty($dokumen['folder_name'])) {
            return (string) $dokumen['folder_name'];
        }

        $servisId = $idservis ?? ($dokumen['idservis'] ?? null);

        if ($servisId) {
            $servis = $this->servisModel->find($servisId);

            if (!empty($servis['namaservis'])) {
                return $this->slugify($servis['namaservis']);
            }
        }

        return (string) $servisId;
    }

    public function index()
    {
        $data['servis'] = $this->servisModel->orderBy('namaservis', 'ASC')->findAll();
        return view('dashboard/pages/pengurusan_dokumen', $data);
}

    public function getDokumen($idservis)
    {
        $items = $this->dokumenModel->where('idservis', $idservis)->findAll();
        return $this->response->setJSON([
            'status' => true,
            'items'  => $items,
            'csrf'   => csrf_hash() 
        ]);
    }

    public function getDokumenDetail($iddoc) 
    {
        $data = $this->dokumenModel->find($iddoc);
        return $this->response->setJSON([
            'status' => !empty($data), 
            'data'   => $data,
            'csrf'   => csrf_hash()
        ]);
    }

    /**
     * Helper Internal: Tapis tag HTML kosong dari CKEditor
     * Memastikan string kosong dihantar jika tiada text sebenar
     */
    private function cleanCKEditor($content)
    {
        if (empty($content)) return "";

        // 1. Decode & buang whitespace 
        $decoded = html_entity_decode($content);
        
        // 2. Buang semua tag untuk tengok ada text tak kat dalam
        $plainText = strip_tags($decoded);
        $plainText = trim(str_replace('&nbsp;', '', $plainText));

        // 3. Kalau hasil buang tag tu KOSONG, return string kosong terus
        if ($plainText === '') {
            return ""; 
        }

        // buang tag <p> dan </p> secara manual
        $noParagraphs = str_replace(['<p>', '</p>'], '', $content);
        
        return trim($noParagraphs);
}

    public function tambah()
    {
        $idservis = $this->request->getPost('idservis');
        $nama     = $this->request->getPost('nama');
        $descdoc  = $this->cleanCKEditor($this->request->getPost('descdoc'));
        $file     = $this->request->getFile('file');

        // 1. Cari Servis & Buat Folder Name
        $servis = $this->servisModel->find($idservis);
        if (!$servis) return $this->response->setJSON(['status' => false, 'msg' => 'Servis tidak sah.']);
        
        $folderName = $this->slugify($servis['namaservis']);

        if (!$file || !$file->isValid()) return $this->response->setJSON(['status' => false, 'msg' => 'Fail tidak sah.']);
        if (!$this->isPdfFile($file)) return $this->response->setJSON(['status' => false, 'msg' => 'Hanya PDF sahaja.']);

        // 2. Setup File Naming
        $originalName = $file->getClientName(); 
        $newName = time() . '_' . $file->getRandomName();
        $uploadPath = WRITEPATH . "uploads/dokumen/{$folderName}/";
        
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
        
        if ($file->move($uploadPath, $newName)) {
            $data = [
                'idservis'           => $idservis,
                'folder_name'        => $folderName,
                'nama'               => $nama,
                'namafail'           => $newName,
                'file_original_name' => $originalName,
                'mime'               => $file->getClientMimeType(),
                'descdoc'            => $descdoc,
                'status'             => 'pending',
                'uploaded_by'        => auth()->id()
            ];

            if ($this->dokumenModel->insert($data)) {
                $documentId = $this->dokumenModel->getInsertID();
                $this->writeAuditLog('create', 'dokumen', $documentId, "Tambah Dokumen {$nama}", 
                    ['Folder: ' . $folderName, 'Fail Asal: ' . $originalName], 
                    "Dokumen \"$nama\" dimuat naik ke folder $folderName"
                );
                return $this->response->setJSON(['status' => true, 'msg' => 'Dokumen berjaya dimuat naik!', 'csrf' => csrf_hash()]);
            }
        }
        return $this->response->setJSON(['status' => false, 'msg' => 'Gagal pindah fail.']);
    }

    public function kemaskini($iddoc)
    {
        try {
            $dokumen = $this->dokumenModel->find($iddoc);
            if (!$dokumen) return $this->response->setJSON(['status' => false, 'msg' => 'Dokumen tidak dijumpai.', 'csrf' => csrf_hash()]);

            $finalDesc = $this->cleanCKEditor($this->request->getPost('descdoc'));

            $updateData = [
                'nama'    => $this->request->getPost('nama'),
                'descdoc' => $finalDesc, 
                'status'  => $this->request->getPost('status') ?? $dokumen['status']
            ];

            $file = $this->request->getFile('file');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                if (!$this->isPdfFile($file)) {
                    return $this->response->setJSON(['status' => false, 'msg' => 'Hanya fail PDF dibenarkan.', 'csrf' => csrf_hash()]);
                }

                // Logic ganti fail...
                $folderName = $this->resolveFolderName($dokumen, $this->request->getPost('idservis'));
                $uploadPath = WRITEPATH . "uploads/dokumen/{$folderName}/";

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                if (!empty($dokumen['namafail']) && file_exists($uploadPath . $dokumen['namafail'])) {
                    unlink($uploadPath . $dokumen['namafail']);
                }

                $newFileName = time() . '_' . $file->getRandomName();
                $file->move($uploadPath, $newFileName);
                $updateData['namafail'] = $newFileName;
                $updateData['mime']     = $file->getClientMimeType();

                if ($this->hasDokumenColumn('file_original_name')) {
                    $updateData['file_original_name'] = $file->getClientName();
                }
            }

            if ($this->dokumenModel->update($iddoc, $updateData)) {
                $changes = $this->diffChanges($dokumen, array_merge($dokumen, $updateData), [
                    'nama' => 'Nama dokumen',
                    'descdoc' => 'Penerangan',
                    'status' => 'Status',
                    'namafail' => 'Fail PDF',
                    'mime' => 'Jenis fail',
                ]);

                $this->writeAuditLog(
                    'update',
                    'dokumen',
                    $iddoc,
                    'Kemaskini Dokumen ' . ($updateData['nama'] ?? $dokumen['nama']),
                    $changes,
                    'Maklumat untuk Dokumen "' . $this->auditValue($updateData['nama'] ?? $dokumen['nama']) . '" telah dikemaskini.'
                );

                return $this->response->setJSON(['status' => true, 'msg' => 'Dokumen berjaya dikemaskini.', 'csrf' => csrf_hash()]);
            }

            return $this->response->setJSON(['status' => true, 'msg' => 'Tiada perubahan.', 'csrf' => csrf_hash()]);

        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => false, 'msg' => 'Ralat: ' . $e->getMessage(), 'csrf' => csrf_hash()]);
        }
    }

    public function hapus($iddoc)
    {
        try {
            $dokumen = $this->dokumenModel->find($iddoc);
            if (!$dokumen) return $this->response->setJSON(['status' => false, 'msg' => 'Dokumen tidak dijumpai.', 'csrf' => csrf_hash()]);

            $folderName = $this->resolveFolderName($dokumen);
            $filePath = WRITEPATH . "uploads/dokumen/{$folderName}/{$dokumen['namafail']}";
            if (!empty($dokumen['namafail']) && file_exists($filePath)) unlink($filePath);

            if ($this->dokumenModel->delete($iddoc, true)) {
                $this->writeAuditLog(
                    'delete',
                    'dokumen',
                    $iddoc,
                    'Padam Dokumen ' . $dokumen['nama'],
                    [
                        'Nama Dokumen: ' . $this->auditValue($dokumen['nama']),
                        'Status Terakhir: ' . $this->auditValue($dokumen['status'] ?? null),
                    ],
                    'Dokumen "' . $this->auditValue($dokumen['nama']) . '" telah dipadam daripada sistem.'
                );

                return $this->response->setJSON(['status' => true, 'msg' => 'Berjaya dipadam.', 'csrf' => csrf_hash()]);
            }

            return $this->response->setJSON(['status' => false, 'msg' => 'Gagal padam.', 'csrf' => csrf_hash()]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => false, 'msg' => 'Ralat: ' . $e->getMessage(), 'csrf' => csrf_hash()]);
        }
    }

    public function viewFile($idservis, $filename)
    {
        $folderName = $this->resolveFolderName(null, $idservis);
        $path = WRITEPATH . "uploads/dokumen/{$folderName}/{$filename}";
        if (!file_exists($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $mimeType = mime_content_type($path);
        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody(file_get_contents($path));
    }

    private function slugify($text)
    {
        // Tukar simbol/space jadi underscore, pastikan lowercase
        $text = preg_replace('~[^\pL\d]+~u', '_', $text);
        $text = trim($text, '_');
        $text = strtolower($text);
        return empty($text) ? 'n_a' : $text;
    }
}
