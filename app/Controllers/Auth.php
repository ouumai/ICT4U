<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class Auth extends BaseController
{
    // 1. PROFILE PAGE
    public function profile()
    {
        // Guna cara Shield untuk check login
        if (!auth()->loggedIn()) {
            return redirect()->to('/login');
        }

        $user = auth()->user(); // Ambil data user yang sedang login

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
        $userModel = new \App\Models\UserModel(); // Guna model yang kita baru repair tadi

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

        // Simpan terus ke database guna ID user yang login
        if ($userModel->update($user->id, $data)) {
            return redirect()->back()->with('success', 'Profil berjaya dikemaskini.');
        }

        return redirect()->back()->with('error', 'Gagal kemaskini database.');
    }

    // 3. UPDATE PASSWORD (DARI DALAM PROFILE)
   public function updatePassword()
    {
        if (!auth()->loggedIn()) return redirect()->to('/login');

        $user = auth()->user();
        $currentPassInput = $this->request->getPost('current_password');

        // 1. Sahkan password lama (Guna helper Shield)
        $credentials = [
            'email'    => $user->email,
            'password' => $currentPassInput,
        ];

        if (! auth()->getAuthenticator()->check($credentials)) {
            return redirect()->back()->with('error_pw', 'Kata laluan semasa anda salah!');
        }

        // 2. Validation password baru
        $rules = [
            'new_password'     => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error_pw', 'Pastikan password baru minima 8 aksara & sepadan.');
        }

        // 3. Simpan password baru (Cara Shield yang betul)
        $user->password = $this->request->getPost('new_password');
        
        $userModel = new \App\Models\UserModel(); // Guna model yang kita repair tadi
        $userModel->save($user);

        return redirect()->back()->with('success', 'Kata laluan berjaya dikemaskini.');
    }

    // 4. RESET PASSWORD (STEP BY STEP)
    public function forgotStep1() { return view('form/forgot_password'); }

    public function processStep1()
    {
        $email = $this->request->getPost('email');
        $userModel = new ShieldUserModel();
        $user = $userModel->findByCredentials(['email' => $email]);

        if (!$user) {
            return redirect()->back()->with('error', 'Emel tidak dijumpai.');
        }

        $token = rand(100000, 999999);
        session()->set([
            'reset_token'      => $token,
            'reset_email'      => $email,
            'token_created_at' => time()
        ]);

        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Kod Keselamatan ICT4U');
        $emailService->setMessage("Kod anda: $token (Sah 5 minit)");

        if ($emailService->send()) {
            return redirect()->to('forgot/step2')->with('success', 'Kod dihantar!');
        }
        return redirect()->back()->with('error', 'Gagal hantar emel.');
    }

        public function attemptLogin()
        {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $remember = (bool) $this->request->getPost('remember'); // Ambil nilai checkbox

            $credentials = [
                'email'    => $email,
                'password' => $password,
            ];

            // Guna login() punya parameter ke-2 untuk 'remember'
            if (auth()->attempt($credentials, $remember)) {
                return redirect()->to('/dashboard')->with('success', 'Selamat datang semula!');
            }

            return redirect()->back()->with('error', 'Emel atau kata laluan salah.');
        }
}