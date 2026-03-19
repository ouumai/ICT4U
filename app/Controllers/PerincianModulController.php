<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ServisModel;
use App\Models\ModulDescModel;
use App\Models\PerincianModulModel;

class PerincianModulController extends BaseController
{
    protected $servisModel;
    protected $descModel;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->servisModel = new ServisModel();
        $this->descModel = new \App\Models\PerincianModulModel();
    }

    // Papar halaman utama 
    public function index()
    {
        // Mengambil semua servis
        $servis = $this->servisModel->orderBy('namaservis', 'ASC')->findAll();
        
        // Hantar data ke view. 
        // Pastikan di dalam view 'perincianapp', anda menggunakan foreach($servisList as $s)
        return view('dashboard/pages/perincianapp', [
            'servisList' => $servis
        ]);
    }

    // Ambil data servis + description melalui AJAX (untuk Reset & Populate Form)

    public function getServis($idservis)
    {
        $servis = $this->servisModel->find($idservis);

        if (!$servis) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Servis tidak ditemui.'
            ]);
        }

        // Ambil description dari table modul_desc (menggunakan idservis sebagai foreign key)
        $desc = $this->descModel->where('idservis', $idservis)->first();
        $dokumenModel = model('App\Models\ApprovalDokumenModel');
        $dokumen = $dokumenModel->where('id', $idservis)->findAll();

        $statusSummary = [
            'pending' => 0,
            'approved' => 0,
            'rejected' => 0,
            'total' => count($dokumen)
        ];

        foreach($dokumen as $d){
            if(isset($statusSummary[$d['status']])) $statusSummary[$d['status']]++;
        }

        return $this->response->setJSON([
            'status'         => true,
            'servis'         => $servis,
            'desc'           => $desc,
            'dokumen_status' => $statusSummary,
            'namaservis'     => $servis['namaservis']
        ]);
    }

    // Simpan atau Kemaskini data (Action dari Form)
    public function save()
    {
        $idservis    = $this->request->getPost('idservis');
        $namaservis  = trim($this->request->getPost('namaservis'));
        $infourl     = trim($this->request->getPost('infourl'));
        $mohonurl    = trim($this->request->getPost('mohonurl'));
        $description = trim(strip_tags($this->request->getPost('description')));
        $errors = [];

        // 1. VALIDASI ID SERVIS
        if (!$idservis || !$this->servisModel->find($idservis)) {
            $errors[] = 'ID Servis tidak sah atau tidak dipilih.';
        }

        // 2. VALIDASI NAMA SERVIS
        $keyboardRegex = '/^[\x20-\x7E]*$/'; 

        if (empty($namaservis)) {
            // Kalau nama servis kosong (sebab user ter-reset), 
            // kita tarik balik nama asal dari DB guna $idservis supaya validasi tak fail
            $current = $this->servisModel->find($idservis);
            if ($current) {
                $namaservis = $current['namaservis']; 
            } else {
                $errors[] = 'Nama servis wajib diisi.';
            }
        } elseif (mb_strlen($namaservis) > 145) {
            $errors[] = 'Nama servis tidak boleh melebihi 145 aksara.';
        } elseif (!preg_match($keyboardRegex, $namaservis)) {
            $errors[] = 'Nama servis mengandungi aksara yang tidak dibenarkan.';
        }

        // 3. VALIDASI URL (Optional - Check kalau tak kosong)
        $urlRegex = '/^(https?|ftp):\/\/[^\s\/$.?#].[^\s]*$/i';

        if (!empty($infourl) && !preg_match($urlRegex, $infourl)) {
            $errors[] = 'Format Info URL tidak sah.';
        }

        if (!empty($mohonurl) && !preg_match($urlRegex, $mohonurl)) {
            $errors[] = 'Format Mohon URL tidak sah.';
        }

        // 4. VALIDASI DESCRIPTION (Dah benarkan kosong atas permintaan Mai)
        $description = $description ?: ''; 

        // Jika ada ralat validasi, hantar balik ke form dengan mesej ralat
        if (!empty($errors)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $errors));
        }

        // ===== PROSES KEMASKINI DATABASE =====
        try {
            // A. Update Table Servis (Hanya jika namaservis tidak kosong)
            if (!empty($namaservis)) {
                $this->servisModel->update($idservis, [
                    'namaservis' => $namaservis,
                    'infourl'    => $infourl ?: null,
                    'mohonurl'   => $mohonurl ?: null
                ]);
            }

            // B. Update/Insert Table Perincian (INI BAHAGIAN UNTUK CLEAR DESCRIPTION)
            $existingDesc = $this->descModel->where('idservis', $idservis)->first();
            
            if ($existingDesc) {
                // Kita paksa update description kepada nilai yang dihantar (walaupun kosong '')
                $this->descModel->update($existingDesc['id'], [ 
                    'description' => $description // Jika reset, $description akan jadi ''
                ]);
            } else {
                $this->descModel->insert([
                    'idservis'    => $idservis,
                    'description' => $description
                ]);
            }

            session()->setFlashdata('success', 'Maklumat servis berjaya dikemaskini.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ralat Sistem: ' . $e->getMessage());
        }
        // Redirect balik ke index supaya page refresh dan baca flashdata
        return redirect()->to('/perincianmodul');
    }

    // Padam servis 
    public function delete($idservis)
    {
        if (!$idservis || !$this->servisModel->find($idservis)) {
            return redirect()->back()->with('error', 'Servis tidak ditemui.');
        }

        // Padam servis & description (Jika model guna SoftDelete, ia akan ikut rules model)
        $this->servisModel->delete($idservis);
        $this->descModel->where('idservis', $idservis)->delete();

        return redirect()->back()->with('success', 'Servis berjaya dipadam.');
    }
}