<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\AuditLogModel;
use App\Models\DokumenModel;
use App\Models\PerincianModulModel;
use App\Models\ServisModel;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class DashboardController extends BaseController
{
    protected ServisModel $servisModel;
    protected DokumenModel $dokumenModel;
    protected PerincianModulModel $perincianModulModel;
    protected AuditLogModel $recentAuditLogModel;

    public function __construct()
    {
        helper(['url', 'form', 'auth']);

        $this->servisModel = new ServisModel();
        $this->dokumenModel = new DokumenModel();
        $this->perincianModulModel = new PerincianModulModel();
        $this->recentAuditLogModel = new AuditLogModel();
    }

    public function index(): string
    {
        $data = [
            'title'               => 'Dashboard',
            'totalServisKelulusan' => $this->servisModel->countAllResults(),
            'dokApproved'         => $this->dokumenModel->where('status', 'approved')->countAllResults(),
            'dokPending'          => $this->dokumenModel->where('status', 'pending')->countAllResults(),
            'dokRejected'         => $this->dokumenModel->where('status', 'rejected')->countAllResults(),
            'totalDokumen'        => $this->dokumenModel->countAllResults(),
            'totalPerincianModul' => $this->perincianModulModel->countAllResults(),
            'recentActivities'    => $this->recentAuditLogModel->getRecentActivities(8),
        ];

        return view('dashboard/index', $data);
    }

    public function updatePassword()
    {
        $rules = [
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('error', 'Pastikan kata laluan sekurang-kurangnya 8 aksara dan sepadan.');
        }

        $email = session()->get('reset_email');

        if (empty($email)) {
            return redirect()->back()->with('error', 'Sesi set semula kata laluan tidak sah atau telah tamat.');
        }

        $userModel = new ShieldUserModel();
        $user = $userModel->findByCredentials(['email' => $email]);

        if ($user === null) {
            return redirect()->back()->with('error', 'Akaun pengguna tidak ditemui.');
        }

        $user->password = $this->request->getPost('password');
        $userModel->save($user);

        session()->remove(['reset_email', 'reset_token']);

        return redirect()->to('/login')->with('success', 'Kata laluan berjaya dikemaskini. Sila log masuk semula.');
    }
}
