<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        // Load helper email & auth sekali
        helper(['url', 'form', 'session', 'email', 'auth']);
    }

    /* =========================
       MAIN PAGE
    ========================= */
    public function index()
    {
        return view('users/index', $this->getDashboardCounts());
    }

    /* =========================
       GET ALL USERS FOR DATATABLE
    ========================= */
    public function getAll(): ResponseInterface
    {
        $users = $this->userModel
            ->select('id, fullname, email, role, status')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->response->setJSON(['data' => $users]);
    }

    /* =========================
       GET SINGLE USER (EDIT MODAL)
    ========================= */
    public function show($id): ResponseInterface
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON(['status' => false, 'message' => 'User not found']);
        }

        return $this->response->setJSON([
            'id'       => $user['id'],
            'fullname' => $user['fullname'],
            'email'    => $user['email'],
            'role'     => $user['role'],
            'status'   => $user['status'],
            'csrfHash' => csrf_hash()
        ]);
    }

    /* =========================
       ADD USER
    ========================= */
    public function add(): ResponseInterface
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'fullname' => 'required|min_length[3]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,uploader]',
            'status'   => 'required|in_list[active,inactive]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['status' => false, 'message' => $validation->listErrors(), 'csrfHash' => csrf_hash()]);
        }

        $data = [
            'fullname' => trim($this->request->getPost('fullname')),
            'email'    => trim($this->request->getPost('email')),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
            'status'   => $this->request->getPost('status'),
        ];

        $this->userModel->insert($data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'User berjaya ditambah',
            'csrfHash' => csrf_hash()
        ]);
    }

    /* =========================
       UPDATE USER (UNTUK ADMIN)
    ========================= */
    public function update($id): ResponseInterface
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setStatusCode(404)
                ->setJSON(['status' => false, 'message' => 'User not found', 'csrfHash' => csrf_hash()]);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'fullname' => 'required|min_length[3]|max_length[100]',
            'email'    => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'     => 'required|in_list[admin,uploader]',
            'status'   => 'required|in_list[active,inactive]',
            'password' => 'permit_empty|min_length[6]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['status' => false, 'message' => $validation->listErrors(), 'csrfHash' => csrf_hash()]);
        }

        $data = [
            'fullname' => trim($this->request->getPost('fullname')),
            'email'    => trim($this->request->getPost('email')),
            'role'     => $this->request->getPost('role'),
            'status'   => $this->request->getPost('status'),
        ];

        $passwordUpdated = false;
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $passwordUpdated = true;
        }

        if ($this->userModel->update($id, $data)) {
            // Jika password diubah oleh admin, hantar emel alert ke user tersebut
            if ($passwordUpdated) {
                $this->sendSecurityAlert($data['email'], $data['fullname']);
            }

            return $this->response->setJSON([
                'status' => true,
                'message' => 'User berjaya dikemaskini',
                'csrfHash' => csrf_hash()
            ]);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'Gagal update database']);
    }

    /* ============================================================
        UPDATE PASSWORD (KHAS UNTUK PROFILE USER SENDIRI)
    ============================================================ */
    public function updatePassword()
    {
        // Guna Shield untuk dapatkan user object
        $user = auth()->user(); 

        $currentPw = $this->request->getPost('current_password');
        $newPw     = $this->request->getPost('new_password');

        // Verify password lama guna Shield check()
        $credentials = [
            'email'    => $user->email,
            'password' => $currentPw
        ];

        if (! auth()->check($credentials)->isOK()) {
            return redirect()->back()->with('error_pw', 'Kata laluan lama anda salah.');
        }

        // Update password baru melalui Shield Identity
        $user->fill(['password' => $newPw]);
        
        if ($this->userModel->save($user)) {
            // Trigger email notifikasi dinamik
            $this->sendSecurityAlert($user->email, $user->fullname ?? $user->username);

            return redirect()->to(base_url('profile'))->with('success', 'Kata laluan berjaya dikemaskini.');
        }

        return redirect()->back()->with('error_pw', 'Gagal mengemaskini kata laluan.');
    }

    /* =========================
       ENGINE HANTAR EMEL (PRIVATE)
    ========================= */
    private function sendSecurityAlert($penerimaEmail, $namaPenuh)
    {
        $email = \Config\Services::email();
        
        // Mesti sama dengan SMTPUser di .env
        $email->setFrom('n.umairahsabri@gmail.com', 'ICT4U Security');
        $email->setTo($penerimaEmail); 
        $email->setSubject('Sekuriti ICT4U: Password Dikemaskini');
        
        $emailData = [
            'fullname'   => $namaPenuh,
            'updateTime' => date('d M Y, h:i A')
        ];

        $body = view('auth/email/password_changed', $emailData);
        $email->setMessage($body);

        return $email->send();
    }

    /* =========================
       DELETE USER
    ========================= */
    public function delete($id): ResponseInterface
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setStatusCode(404)
                ->setJSON(['status' => false, 'message' => 'User not found', 'csrfHash' => csrf_hash()]);
        }

        $this->userModel->delete($id);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'User berjaya dipadam',
            'csrfHash' => csrf_hash()
        ]);
    }

    /* =========================
       DASHBOARD COUNTS
    ========================= */
    private function getDashboardCounts(): array
    {
        return [
            'totalUsers'    => $this->userModel->countAll(),
            'totalAdmin'    => $this->userModel->where('role', 'admin')->countAllResults(),
            'totalUploader' => $this->userModel->where('role', 'uploader')->countAllResults()
        ];
    }
}