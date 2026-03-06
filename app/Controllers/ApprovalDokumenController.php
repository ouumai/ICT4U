<?php
namespace App\Controllers;

use App\Models\DokumenModel;
use App\Models\ServisModel;
use App\Models\ApprovalDokumenModel;
use App\Controllers\BaseController;

class ApprovalDokumenController extends BaseController
{
    protected $dokumenModel;
    protected $servisModel;
    protected $approvalModel;

   public function __construct()
    {
        helper(['url', 'form']);
        $this->dokumenModel  = new DokumenModel();
        $this->servisModel   = new ServisModel();
        $this->approvalModel = new ApprovalDokumenModel();
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }

    public function index()
    { 
        // Ambil data jika perlu dipaparkan di view
        $data['dokumen'] = $this->approvalModel->findAll();
        
        // Panggil view dengan path yang betul
        return view('dashboard/pages/approvaldokumen', $data); 
    }
    
    // AJAX: Dapatkan semua dokumen dengan status tertentu
    public function getAll()
    {
        $status = $this->request->getGet('status') ?? 'all';
        $page   = max(1,(int)$this->request->getGet('page'));
        $limit  = 50;
        $offset = ($page-1)*$limit;

        $builder = $this->dokumenModel;
        if($status!=='all') $builder = $builder->where('status',$status);
        $total = $builder->countAllResults(false);

        $dokumen = $builder->orderBy('created_at','DESC')->findAll($limit,$offset);

        return $this->response->setJSON([
            'status'=>true,
            'data'=>$dokumen,
            'pagination'=>['page'=>$page,'limit'=>$limit,'total'=>$total]
        ]);
    }
    // AJAX: Tukar status dokumen (approved/rejected)
    public function changeStatus(int $iddoc, string $status)
    {
        $status = strtolower($status);
        if (!in_array($status, ['approved', 'rejected'])) {
            return $this->response->setJSON(['status' => false, 'message' => 'Status tidak sah']);
        }

        $userId = session()->get('user_id') ?? 'Admin';
        $now    = date('Y-m-d H:i:s');

        $db = \Config\Database::connect();
        $db->transStart();

        // Gunakan fungsi saveStatus dalam model Mai untuk lebih clean
        $this->approvalModel->saveStatus($iddoc, [
            'status'      => $status,
            'approved_by' => $userId,
            'approved_at' => $now
        ]);

        // Kemaskini table utama
        $this->dokumenModel->update($iddoc, [
            'status'     => $status,
            'updated_at' => $now
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => false, 'message' => 'Database error!']);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => "Status dikemaskini ke " . strtoupper($status)
        ]);
    }

    // AJAX: Papar fail dokumen dalam browser
    public function getDokumen(int $iddoc)
    {
        $dokumen = $this->dokumenModel->find($iddoc);
        if(!$dokumen) return $this->response->setJSON(['status'=>false,'message'=>'Dokumen tidak dijumpai']);
        return $this->response->setJSON(['status'=>true,'data'=>$dokumen]);
    }
    // Show file in browser
    public function viewFile($idservis, $filename)
    {
        $path = WRITEPATH . "uploads/dokumen/{$idservis}/{$filename}";
        if (!file_exists($path)) {
            return $this->response->setStatusCode(404, 'File not found');
        }

        $mime = mime_content_type($path);
        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'inline; filename="'.$filename.'"')
            ->setBody(file_get_contents($path));
    }
}
