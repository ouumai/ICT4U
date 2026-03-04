<?php
namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ServisModel;
use App\Models\DokumenModel;
use App\Models\PerincianModulModel;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $servisModel;
    protected $dokumenModel;
    protected $perincianModulModel;

    public function __construct()
    {
        $this->userModel           = new UserModel();
        $this->servisModel         = new ServisModel();
        $this->dokumenModel        = new DokumenModel();
        $this->perincianModulModel = new PerincianModulModel();
    }

    /**
     * =========================
     * MAIN DASHBOARD
     * =========================
     */
    public function index()
    {
        $role = session()->get('role') ?? 'viewer';

        // Dokumen status counts
        $dokumenCounts = $this->dokumenCounts();

        $data = [
            'title'                => 'Dashboard',
            'role'                 => $role,
            'totalUsers'           => $this->userModel->countAll(),
            'totalServis'          => $this->servisModel->countAll(),
            'totalDokumen'         => array_sum($dokumenCounts),
            'dokPending'           => $dokumenCounts['pending'],
            'dokApproved'          => $dokumenCounts['approved'],
            'dokRejected'          => $dokumenCounts['rejected'],
            'totalPerincianModul'  => $this->perincianModulModel->countAll(),
            'totalServisKelulusan' => $this->servisModel->countAll(), // adjust if specific
        ];

        // User-specific analytics
        if ($role !== 'admin') {
            $userId = session()->get('user_id');
            $data['analytics'] = [
                'myServisCount'  => $this->servisModel
                    ->where('created_by', $userId)
                    ->countAllResults(),
                'myDokumenCount' => $this->dokumenModel
                    ->where('created_by', $userId)
                    ->where('deleted_at', null)
                    ->countAllResults(),
            ];

            return view('dashboard/index', $data);
        }
    }

    /**
     * =========================
     * LOAD PAGE (AJAX)
     * =========================
     */
        public function loadPage($page)
    {
        $validPages = [
            'home',
            'users',
            'perincian',
            'dokumen', // masih valid untuk route, tapi kita redirect ke view baru
            'approvaldokumen',
            'serviskelulusan'
        ];

        if (!in_array($page, $validPages)) {
            return $this->response
                ->setStatusCode(404)
                ->setBody('Page not found');
        }

        $data = [];

        // Pass data spesifik untuk page tertentu
        if ($page === 'dokumen') {
            $page = 'pengurusan_dokumen'; // tukar view
            $data['servis'] = $this->servisModel->orderBy('namaservis', 'ASC')->findAll();
        }

        return view("dashboard/pages/{$page}", $data);
    }
    /**
     * =========================
     * SERVIS KELULUSAN (DOKUMEN STATUS)
     * =========================
     */
    public function servisKelulusan()
    {
        $dokumenCounts = $this->dokumenCounts();
        $totalDokumen  = array_sum($dokumenCounts);

        $data = [
            'totalDokumenPending'  => $dokumenCounts['pending'],
            'totalDokumenApproved' => $dokumenCounts['approved'],
            'totalDokumenRejected' => $dokumenCounts['rejected'],
            'totalDokumen'         => $totalDokumen,
        ];

        return view('servis/servisKelulusan', $data);
    }

    /**
     * =========================
     * DASHBOARD LIVE DATA (AJAX)
     * =========================
     */
    public function getData()
    {
        $summary = [
            'totalUsers' => $this->userModel->countAll(),
        ];

        $dokumenCounts = $this->dokumenCounts();
        $summary = array_merge($summary, [
            'totalDokumen'         => array_sum($dokumenCounts),
            'totalDokumenPending'  => $dokumenCounts['pending'],
            'totalDokumenApproved' => $dokumenCounts['approved'],
            'totalDokumenRejected' => $dokumenCounts['rejected'],
        ]);

        // Monthly Dokumen Chart
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $monthlyData = [];
        $currentYear = date('Y');

        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $this->dokumenModel
                ->where('YEAR(created_at)', $currentYear)
                ->where('MONTH(created_at)', $i)
                ->where('deleted_at', null)
                ->countAllResults();
        }

        // Dokumen Status Chart
        $statusLabels = ['Pending','Approved','Rejected'];
        $statusData = [
            $dokumenCounts['pending'],
            $dokumenCounts['approved'],
            $dokumenCounts['rejected'],
        ];

        // Latest 10 Users
        $users = $this->userModel->orderBy('id','DESC')->findAll(10);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'summary' => $summary,
                'users'   => $users,
                'charts'  => [
                    'monthly' => [
                        'labels' => $months,
                        'data'   => $monthlyData,
                    ],
                    'status' => [
                        'labels' => $statusLabels,
                        'data'   => $statusData,
                    ]
                ]
            ]
        ]);
    }

    /**
     * =========================
     * PRIVATE HELPER: DOKUMEN COUNTS
     * =========================
     */
    private function dokumenCounts(): array
    {
        return [
            'pending'  => $this->dokumenModel
                ->where('status', DokumenModel::STATUS_PENDING)
                ->where('deleted_at', null)
                ->countAllResults(),
            'approved' => $this->dokumenModel
                ->where('status', DokumenModel::STATUS_APPROVED)
                ->where('deleted_at', null)
                ->countAllResults(),
            'rejected' => $this->dokumenModel
                ->where('status', DokumenModel::STATUS_REJECTED)
                ->where('deleted_at', null)
                ->countAllResults(),
        ];
    }


    /**
     * =========================
     * UPDATE PASSWORD (RESET)
     * =========================
     */
    public function updatePassword()
    {
        // 1. Ambil data dari form reset_password.php
        $password        = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        // 2. Semak jika password dan pengesahan adalah sama
        if ($password !== $passwordConfirm) {
            return redirect()->back()->with('error', 'Kata laluan baharu dan pengesahan tidak sepadan.');
        }

        // 3. Semak panjang password (min 8 aksara)
        if (strlen($password) < 8) {
            return redirect()->back()->with('error', 'Kata laluan mestilah sekurang-kurangnya 8 aksara.');
        }

        // 4. Ambil user yang tengah login (Shield auto-login selepas klik link email)
        $user = auth()->user();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Sesi telah tamat. Sila mohon link baharu.');
        }

        // 5. Kemaskini password dalam database
        $user->fill([
            'password' => $password
        ]);

        // Guna UserModel atau Shield provider untuk simpan
        $userProvider = model(setting('Auth.userProvider'));
        $userProvider->save($user);

        // 6. Redirect ke dashboard dengan mesej berjaya
        return redirect()->to('/')->with('message', 'Kata laluan anda telah berjaya dikemaskini!');
    }

}
