<?php

namespace App\Controllers;

use App\Models\FaqModel;
use App\Models\ServisModel;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class FaqController extends BaseController
{
    use ResponseTrait;

    protected $faqModel;
    protected $servisModel;

    public function __construct()
    {
        $this->faqModel    = new FaqModel();
        $this->servisModel = new ServisModel();
        helper(['url', 'form']);
    }

    // Papar Page Utama
    public function index()
    {
        $data = [
            'servisList' => $this->servisModel->orderBy('namaservis', 'ASC')->findAll(),
            'title'      => 'Pengurusan FAQ'
        ];
        return view('faq/index', $data);
    }

    // Tarik data FAQ guna AJAX
    public function ajax($idservis)
    {
        $faqs = $this->faqModel->where('idservis', $idservis)
                               ->orderBy('created_at', 'DESC')
                               ->findAll();
        return $this->respond(['success' => true, 'faqs' => $faqs]);
    }

    // Simpan Soalan Baru
    public function store()
    {
        $data = [
            'idservis' => $this->request->getPost('idservis'),
            'question' => strip_tags($this->request->getPost('question')),
            'answer'   => $this->request->getPost('answer'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->faqModel->insert($data)) {
            return $this->respondCreated(['success' => true, 'csrf' => csrf_hash()]);
        }
        return $this->fail('Gagal simpan data.');
    }

    // Kemaskini Soalan Sedia Ada
    public function update($id)
    {
        $data = [
            'question' => strip_tags($this->request->getPost('question')),
            'answer'   => $this->request->getPost('answer'),
        ];

        if ($this->faqModel->update($id, $data)) {
            return $this->respond(['success' => true, 'csrf' => csrf_hash()]);
        }
        return $this->fail('Gagal kemaskini data.');
    }

    // Padam Soalan
    public function delete($id)
    {
        if ($this->faqModel->delete($id)) {
            return $this->respondDeleted(['success' => true, 'csrf' => csrf_hash()]);
        }
        return $this->fail('Gagal padam data.');
    }
}