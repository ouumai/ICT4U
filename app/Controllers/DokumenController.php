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

    public function __construct()
    {
        helper(['url', 'form', 'filesystem']);
        $this->dokumenModel = new DokumenModel();
        $this->servisModel  = new ServisModel();
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }

    public function index()
    {
        $data['servis'] = $this->servisModel->findAll();
        return view('dashboard/pages/pengurusan_dokumen', $data);
    }

    public function getDokumen($idservis)
    {
        // Ambil data berdasarkan idservis
        $items = $this->dokumenModel->where('idservis', $idservis)->findAll();
        
        // Return dalam format JSON supaya JS boleh loop
        return $this->response->setJSON([
            'status' => true,
            'items'  => $items
        ]);
    }

    public function getDokumenDetail($iddoc) 
    {
        $data = $this->dokumenModel->find($iddoc);
        return $this->response->setJSON(['status' => !empty($data), 'data' => $data]);
    }
    
    public function tambah()
    {
        $idservis = $this->request->getPost('idservis');
        $nama     = $this->request->getPost('nama');
        $descdoc  = $this->request->getPost('descdoc');
        $file     = $this->request->getFile('file');

        // 1. Check file manual
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['status' => false, 'msg' => 'Fail tidak sah.']);
        }

        // 2. Process file
        $newName = time() . '_' . $file->getRandomName();
        $uploadPath = WRITEPATH . "uploads/dokumen/{$idservis}/";
        
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
        
        if ($file->move($uploadPath, $newName)) {
            $data = [
                'idservis'   => $idservis,
                'nama'       => $nama,
                'descdoc'    => $descdoc,
                'namafail'   => $newName,
                'mime'       => $file->getClientMimeType(),
                'status'     => 'pending'
            ];

            // 3. Guna try-catch atau check errors model
            if ($this->dokumenModel->insert($data)) {
                return $this->response->setJSON(['status' => true, 'msg' => 'Dokumen berjaya dimuat naik!']);
            } else {
                // Ni paling penting: Bagitau Mai apa ralat model tu
                $errors = $this->dokumenModel->errors();
                return $this->response->setJSON(['status' => false, 'msg' => 'Gagal simpan: ' . implode(', ', $errors)]);
            }
        }

        return $this->response->setJSON(['status' => false, 'msg' => 'Gagal pindah fail ke server.']);
    }

    public function edit($iddoc)
    {
        $data = $this->dokumenModel->find($iddoc);
        return $this->response->setJSON(['status' => !empty($data), 'data' => $data]);
    }

    public function kemaskini($iddoc)
    {
        try {
            $dokumen = $this->dokumenModel->find($iddoc);
            if (!$dokumen) return $this->response->setJSON(['status' => false, 'msg' => 'Dokumen tidak dijumpai.']);

            $updateData = [
                'nama'    => $this->request->getPost('nama'),
                'descdoc' => $this->request->getPost('descdoc'),
                'status'  => $this->request->getPost('status') ?? $dokumen['status']
            ];

            $file = $this->request->getFile('file');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getMimeType() !== 'application/pdf') {
                    return $this->response->setJSON(['status' => false, 'msg' => 'Hanya PDF sahaja dibenarkan.']);
                }

                $uploadPath = WRITEPATH . "uploads/dokumen/{$this->request->getPost('idservis')}/";
                if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);

                if (!empty($dokumen['namafail']) && file_exists($uploadPath . $dokumen['namafail'])) {
                    unlink($uploadPath . $dokumen['namafail']);
                }

                $newFileName = $iddoc . '_' . time() . '.' . $file->getExtension();
                $file->move($uploadPath, $newFileName);

                $updateData['namafail'] = $newFileName;
                $updateData['mime']     = $file->getClientMimeType();
            }

            if ($this->dokumenModel->update($iddoc, $updateData)) {
                return $this->response->setJSON(['status' => true, 'msg' => 'Dokumen berjaya dikemaskini.']);
            }

            return $this->response->setJSON(['status' => false, 'msg' => 'Tiada perubahan dilakukan.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => false, 'msg' => 'Ralat: ' . $e->getMessage()]);
        }
    }

    public function hapus($iddoc)
    {
        try {
            $dokumen = $this->dokumenModel->find($iddoc);
            if (!$dokumen) return $this->response->setJSON(['status' => false, 'msg' => 'Dokumen tidak dijumpai.']);

            $filePath = WRITEPATH . "uploads/dokumen/{$dokumen['idservis']}/{$dokumen['namafail']}";
            if (!empty($dokumen['namafail']) && file_exists($filePath)) unlink($filePath);

            if ($this->dokumenModel->delete($iddoc, true)) {
                return $this->response->setJSON(['status' => true, 'msg' => 'Dokumen dan fail telah dipadam sepenuhnya.']);
            }

            return $this->response->setJSON(['status' => false, 'msg' => 'Gagal memadam rekod pangkalan data.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => false, 'msg' => 'Ralat: ' . $e->getMessage()]);
        }
    }

    public function viewFile($idservis, $filename)
    {
        $path = WRITEPATH . "uploads/dokumen/{$idservis}/{$filename}";
        if (!file_exists($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Fail tidak wujud.");
        }
        $mimeType = mime_content_type($path);
        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody(file_get_contents($path));
    }
}