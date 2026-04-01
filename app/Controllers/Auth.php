<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
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

        if (! auth()->getAuthenticator()->check($credentials)->isOK()) {
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
            $this->sendSecurityAlert($user->email, $user->username);

            return redirect()->back()->with('success', 'Kata laluan berjaya dikemaskini & emel notifikasi telah dihantar.');
        }

        return redirect()->back()->with('error_pw', 'Gagal mengemaskini kata laluan.');
    }

    // 4. DEACTIVATE ACCOUNT
    public function deactivateAccount()
    {
        if (! auth()->loggedIn()) {
            return redirect()->to('/login');
        }

        $user = auth()->user();
        $password = (string) $this->request->getPost('deactivate_password');

        if ($password === '') {
            return redirect()->back()->with('error_deactivate', 'Sila masukkan kata laluan semasa anda.');
        }

        $credentials = [
            'email'    => $user->email,
            'password' => $password,
        ];

        if (! auth()->getAuthenticator()->check($credentials)->isOK()) {
            return redirect()->back()->with('error_deactivate', 'Kata laluan yang dimasukkan tidak sah.');
        }

        $userModel = new UserModel();
        $deactivatedAt = date('d M Y, h:i A');
        $statusMessage = 'Akaun dinyahaktifkan oleh pengguna pada ' . $deactivatedAt . '.';
        $reactivationLink = base_url('reactivate-account?token=' . urlencode($this->generateReactivationToken($user->id)));

        if ($userModel->update($user->id, [
            'status'         => 'banned',
            'status_message' => $statusMessage,
            'active'         => 0,
        ])) {
            $this->writeAuditLog(
                'deactivate_account',
                'user',
                $user->id,
                'Nyahaktifkan Akaun Pengguna ' . ($user->fullname ?? $user->username),
                [
                    'Status: banned',
                    'Status mesej: ' . $statusMessage,
                ],
                'Pengguna "' . $this->auditValue($user->fullname ?? $user->username) . '" telah menyahaktifkan akaun sendiri.'
            );

            $this->sendDeactivationAlert(
                $user->email,
                $user->fullname ?? $user->username,
                $deactivatedAt,
                $reactivationLink
            );

            auth()->logout();
            session()->regenerate();

            return redirect()->to(base_url('login'))->with('success', 'Akaun anda telah dinyahaktifkan. Emel notifikasi telah dihantar.');
        }

        return redirect()->back()->with('error_deactivate', 'Gagal menyahaktifkan akaun. Sila cuba lagi.');
    }

    public function verifyDeactivatePassword(): ResponseInterface
    {
        if (! auth()->loggedIn()) {
            return $this->response->setStatusCode(401)->setJSON([
                'status'  => false,
                'message' => 'Sesi tidak sah. Sila log masuk semula.',
                'csrf'    => csrf_hash(),
            ]);
        }

        $user = auth()->user();
        $password = (string) $this->request->getPost('deactivate_password');

        if ($password === '') {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Kata laluan wajib diisi.',
                'csrf'    => csrf_hash(),
            ]);
        }

        $credentials = [
            'email'    => $user->email,
            'password' => $password,
        ];

        if (! auth()->getAuthenticator()->check($credentials)->isOK()) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Kata laluan semasa tidak betul.',
                'csrf'    => csrf_hash(),
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'csrf'   => csrf_hash(),
        ]);
    }

    public function reactivateAccount()
    {
        $token = (string) $this->request->getGet('token');

        $userId = $this->verifyReactivationToken($token);
        if ($userId === null) {
            return redirect()->to(base_url('login'))->with('error', 'Pautan aktif semula akaun tidak sah atau telah tamat.');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);
        if (! $user) {
            return redirect()->to(base_url('login'))->with('error', 'Akaun tidak dijumpai.');
        }

        $isDeactivated = (($user->status ?? null) === 'banned') || ((int) ($user->active ?? 0) === 0);
        if (! $isDeactivated) {
            return redirect()->to(base_url('login'))->with('success', 'Akaun anda sudah aktif. Anda boleh terus log masuk.');
        }

        if ($userModel->update($user->id, [
            'status'         => 'active',
            'status_message' => null,
            'active'         => 1,
        ])) {
            $this->writeAuditLog(
                'reactivate_account',
                'user',
                $user->id,
                'Aktifkan Semula Akaun Pengguna ' . ($user->fullname ?? $user->username),
                [
                    'Status: active',
                    'Status mesej: dikosongkan',
                ],
                'Pengguna "' . $this->auditValue($user->fullname ?? $user->username) . '" telah mengaktifkan semula akaun sendiri.'
            );

            return redirect()->to(base_url('login'))->with('success', 'Akaun anda telah diaktifkan semula. Sila log masuk.');
        }

        return redirect()->to(base_url('login'))->with('error', 'Gagal mengaktifkan semula akaun. Sila cuba lagi.');
    }

    // 5. PRIVATE FUNCTION: ENGINE HANTAR EMEL
    private function sendSecurityAlert($penerimaEmail, $namaUser)
    {
        $email = \Config\Services::email();
        
        $email->setFrom('no-reply@ict4u.com', 'ICT4U Management System');
        
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

    private function sendDeactivationAlert(string $penerimaEmail, string $namaUser, string $deactivatedAt, string $reactivationLink): bool
    {
        $email = \Config\Services::email();

        $email->setFrom('no-reply@ict4u.com', 'ICT4U Management System');
        $email->setTo($penerimaEmail);
        $email->setSubject('Sekuriti ICT4U: Akaun Dinyahaktifkan');

        $emailData = [
            'fullname'         => $namaUser,
            'deactivatedAt'    => $deactivatedAt,
            'reactivationLink' => $reactivationLink,
        ];

        $body = view('auth/email/account_deactivated', $emailData);
        $email->setMessage($body);

        return $email->send();
    }

    private function generateReactivationToken(int $userId): string
    {
        $expires = time() + 86400;
        $payload = $userId . '|' . $expires;
        $signature = hash_hmac('sha256', $payload, $this->getReactivationSecret());

        return rtrim(strtr(base64_encode($payload . '|' . $signature), '+/', '-_'), '=');
    }

    private function verifyReactivationToken(string $token): ?int
    {
        if ($token === '') {
            return null;
        }

        $normalized = strtr($token, '-_', '+/');
        $padding = strlen($normalized) % 4;
        if ($padding > 0) {
            $normalized .= str_repeat('=', 4 - $padding);
        }

        $decoded = base64_decode($normalized, true);
        if ($decoded === false) {
            return null;
        }

        $parts = explode('|', $decoded);
        if (count($parts) !== 3) {
            return null;
        }

        [$userId, $expires, $signature] = $parts;
        if (! ctype_digit($userId) || ! ctype_digit($expires)) {
            return null;
        }

        if ((int) $expires < time()) {
            return null;
        }

        $payload = $userId . '|' . $expires;
        $expected = hash_hmac('sha256', $payload, $this->getReactivationSecret());

        if (! hash_equals($expected, $signature)) {
            return null;
        }

        return (int) $userId;
    }

    private function getReactivationSecret(): string
    {
        $encryptionConfig = config('Encryption');

        return $encryptionConfig->key !== ''
            ? $encryptionConfig->key
            : hash('sha256', config('App')->baseURL . 'ict4u-reactivate-secret');
    }

    // --- RESET PASSWORD & LOGIN ATTEMPT  ---
    public function forgotStep1() { return view('form/forgot_password'); }

    public function processStep1()
    {
        $email = $this->request->getPost('email');
        
        $userModel = new \App\Models\UserModel();
        $userData = $userModel->where('email', $email)->first();

        if (!$userData) {
            return redirect()->back()->with('error', 'Emel tidak dijumpai.');
        }

        $token = (string)rand(100000, 999999);
        
        // Set data untuk dihantar ke emel
        $emailData = [
            'token'    => $token,
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
