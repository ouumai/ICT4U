<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ServisModel;
use App\Models\PerincianModulModel;

class TambahanPerincianController extends BaseController
{
    protected $servisModel;
    protected $perincianModel;

    public function __construct()
    {
        $this->servisModel    = new ServisModel();
        $this->perincianModel = new PerincianModulModel();
        helper(['form', 'url']);
    }

    // MAIN PAGE

    public function index()
    {
        return view('dashboard/pages/TambahanPerincian', [
            'title'      => 'Pengurusan Perincian Modul',
            'servisList' => $this->servisModel
                                ->orderBy('namaservis', 'ASC')
                                ->findAll()
        ]);
    }

    // GET SINGLE SERVIS + DESCRIPTION
    public function getServis($id)
    {
        $servis = $this->servisModel->find($id);

        if (!$servis) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Servis tidak dijumpai',
                'csrf'    => csrf_hash() // Sentiasa hantar token baru
            ]);
        }

        $desc = $this->perincianModel
                     ->where('idservis', $id)
                     ->first();

        return $this->response->setJSON([
            'status'      => true,
            'servis'      => $servis,
            'perincian'   => $desc ?? null,
            'csrf'        => csrf_hash()
        ]);
    }

    // SAVE or  UPDATE SERVIS + DESCRIPTION
    public function saveServis()
    {
        $post = $this->request->getPost();

        $idservis    = $post['idservis'] ?? null;
        $existingServis = $idservis ? $this->servisModel->find($idservis) : null;
        $existingPerincian = $idservis ? $this->perincianModel->where('idservis', $idservis)->first() : null;
        
        // bersihkan tag HTML pada nama servis dan description
        $namaservis  = trim(strip_tags($post['namaservis'] ?? ''));
        $infourl     = trim($post['infourl'] ?? '');
        $mohonurl    = trim($post['mohonurl'] ?? '');
        
        // guna strip_tags untuk buang semua tag HTML.
        $description = trim(strip_tags($post['description'] ?? ''));

        // Validation Ringkas
        if ($namaservis === '') {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Nama servis diperlukan',
                'csrf'    => csrf_hash()
            ]);
        }

        // Logic Save / Update Servis
        $dataServis = [
            'namaservis' => $namaservis,
            'infourl'    => $infourl === '' ? null : $infourl,
            'mohonurl'   => $mohonurl === '' ? null : $mohonurl
        ];

        if ($idservis) {
            $this->servisModel->update($idservis, $dataServis);
        } else {
            $this->servisModel->insert($dataServis);
            $idservis = $this->servisModel->getInsertID();
        }

        // SAVE / UPDATE PERINCIAN
        $exist = $this->perincianModel->where('idservis', $idservis)->first();
        if ($exist) {
            // Simpan description yang dah bersih dari tag <p>
            $this->perincianModel->update($exist['id'], ['description' => $description]);
        } else {
            $this->perincianModel->insert([
                'idservis'    => $idservis,
                'description' => $description
            ]);
        }

        $changes = array_merge(
            $this->diffChanges($existingServis ?? [], $dataServis, [
                'namaservis' => 'Nama servis',
                'infourl'    => 'Info URL',
                'mohonurl'   => 'Mohon URL',
            ]),
            $this->diffChanges(
                ['description' => $existingPerincian['description'] ?? null],
                ['description' => $description],
                ['description' => 'Perincian modul']
            )
        );

        $this->writeAuditLog(
            $existingServis ? 'update' : 'create',
            'servis',
            $idservis,
            ($existingServis ? 'Kemaskini Servis ' : 'Tambah Servis ') . $namaservis,
            $changes,
            $existingServis
                ? 'Maklumat untuk Servis "' . $this->auditValue($namaservis) . '" telah dikemaskini.'
                : 'Servis baharu "' . $this->auditValue($namaservis) . '" telah ditambah ke dalam sistem.'
        );

        return $this->response->setJSON([
            'status'    => true,
            'message'   => 'Servis berjaya disimpan',
            'csrf'      => csrf_hash()
        ]);
    }
    
    // DELETE SERVIS + DESCRIPTION
    public function deleteServis()
    {
        $idservis = $this->request->getPost('idservis');
        $servis = $idservis ? $this->servisModel->find($idservis) : null;

        if (!$idservis) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'ID servis tidak sah',
                'csrf'    => csrf_hash()
            ]);
        }

        $this->servisModel->delete($idservis);
        $this->perincianModel->where('idservis', $idservis)->delete();

        if ($servis) {
            $this->writeAuditLog(
                'delete',
                'servis',
                $idservis,
                'Padam Servis ' . $servis['namaservis'],
                ['Nama Servis: ' . $this->auditValue($servis['namaservis'])],
                'Servis "' . $this->auditValue($servis['namaservis']) . '" telah dipadam daripada sistem.'
            );
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Servis berjaya dipadam',
            'csrf'    => csrf_hash()
        ]);
    }

    // GET ALL SERVIS + DESCRIPTION

    public function getAll()
    {
        $data = $this->servisModel->orderBy('namaservis', 'ASC')->findAll();

        foreach ($data as &$s) {
            $desc = $this->perincianModel->where('idservis', $s['idservis'])->first();
            $s['infourl']   = $s['infourl'] ?? '';
            $s['mohonurl']  = $s['mohonurl'] ?? '';
            $s['perincian'] = [
                'description' => $desc['description'] ?? ''
            ];
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data,
            'csrf'   => csrf_hash()
        ]);
    }
}
