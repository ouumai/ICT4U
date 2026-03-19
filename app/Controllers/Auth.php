<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class Auth extends BaseController
{
    public function __construct()
    {
        // Load helper email supaya function hantar emel tak error
        helper(['url', 'form', 'session', 'email', 'auth']);
    }

    // 1. PROFILE PAGE
    public function profile()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/login');
        }

        $user = auth()->user(); 

        $data = [
            'user'  => $user,
            'title' => 'Profil Saya'
        ];

        return view('form/profile', $data); 
    }

    // 2. UPDATE PROFILE (Termasuk Gambar)
    public function updateProfile()
    {
        if (!auth()->loggedIn()) return redirect()->to('/login');

        $user = auth()->user();
        $userModel = new \App\Models\UserModel();

        $file = $this->request->getFile('profile_pic');
        $picName = $user->profile_pic; 

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $picName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/profile/', $picName);
        }

        $data = [
            'username'    => $this->request->getPost('username'),
            'profile_pic' => $picName,
        ];

        if ($userModel->update($user->id, $data)) {
            return redirect()->back()->with('success', 'Profil berjaya dikemaskini.');
        }

        return redirect()->back()->with('error', 'Gagal kemaskini database.');
    }

    // 3. UPDATE PASSWORD (DENGAN EMEL NOTIFIKASI DINAMIK)
    public function updatePassword()
    {
        if (!auth()->loggedIn()) return redirect()->to('/login');

        $user = auth()->user();
        $currentPassInput = $this->request->getPost('current_password');

        // Sahkan password lama
        $credentials = [
            'email'    => $user->email,
            'password' => $currentPassInput,
        ];

        if (! auth()->getAuthenticator()->check($credentials)) {
            return redirect()->back()->with('error_pw', 'Kata laluan semasa anda salah!');
        }

        // Validation password baru
        $rules = [
            'new_password'     => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error_pw', 'Pastikan password baru minima 8 aksara & sepadan.');
        }

        // Simpan password baru
        $user->password = $this->request->getPost('new_password');
        
        $userModel = new \App\Models\UserModel(); 
        if ($userModel->save($user)) {
            
            // --- TRIGGER EMEL NOTIFIKASI DI SINI ---
            // Kita guna $user->email supaya hantar kat "orang tu" (penerima dinamik)
            $this->sendSecurityAlert($user->email, $user->username);

            return redirect()->back()->with('success', 'Kata laluan berjaya dikemaskini & emel notifikasi telah dihantar.');
        }

        return redirect()->back()->with('error_pw', 'Gagal mengemaskini kata laluan.');
    }

    // 4. PRIVATE FUNCTION: ENGINE HANTAR EMEL
    private function sendSecurityAlert($penerimaEmail, $namaUser)
    {
        $email = \Config\Services::email();
        
        // PENGIRIM: Akaun n.umairahsabri@gmail.com
        $email->setFrom('no-reply@ict4u.com', 'ICT4U Management System');
        
        // PENERIMA: Emel user yang tengah tukar password
        $email->setTo($penerimaEmail); 
        $email->setSubject('Sekuriti ICT4U: Kata Laluan Dikemaskini');
        
        $emailData = [
            'fullname'   => $namaUser,
            'updateTime' => date('d M Y, h:i A')
        ];

        $body = view('auth/email/password_changed', $emailData);
        $email->setMessage($body);

        return $email->send();
    }

    // --- RESET PASSWORD & LOGIN ATTEMPT (Kekalkan yang asal) ---
    public function forgotStep1() { return view('form/forgot_password'); }

    public function processStep1()
    {
        $email = $this->request->getPost('email');
        
        // Kita panggil UserModel untuk cari fullname user tersebut
        $userModel = new \App\Models\UserModel();
        $userData = $userModel->where('email', $email)->first();

        if (!$userData) {
            return redirect()->back()->with('error', 'Emel tidak dijumpai.');
        }

        $token = (string)rand(100000, 999999);
        
        // Set data untuk dihantar ke emel
        $emailData = [
            'token'    => $token,
            // Pastikan ambil 'fullname' dari hasil carian database tadi
            'fullname' => $userData['fullname'] ?? $userData['username'] ?? 'User'
        ];

        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Kod Keselamatan ICT4U');
        
        // Load view dengan data yang kita dah set
        $body = view('auth/email/activation_email', $emailData);
        $emailService->setMessage($body);

        if ($emailService->send()) {
            // Simpan token dalam session untuk verify nanti
            session()->set(['reset_token' => $token, 'reset_email' => $email]);
            return redirect()->to('forgot/step2')->with('success', 'Kod dihantar!');
        }
        
        return redirect()->back()->with('error', 'Gagal hantar emel.');
    }

    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = (bool) $this->request->getPost('remember'); 

        $credentials = [
            'email'    => $email,
            'password' => $password,
        ];

        if (auth()->attempt($credentials, $remember)) {
            return redirect()->to('/dashboard')->with('success', 'Selamat datang semula!');
        }

        return redirect()->back()->with('error', 'Emel atau kata laluan salah.');
    }
}