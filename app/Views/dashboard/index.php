<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --soft-lilac: #f5f3ff;
        --deep-lilac: #8b5cf6;
        --soft-emerald: #ecfdf5;
        --emerald-green: #10b981;
        --dashboard-panel-height: 650px;
    }

    /* 1. Global Setup */
    body, .content-wrapper, h1, h2, h3, h4, h5, h6, p, span, div, strong {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    /* Remove Default AdminLTE/Layout Headers */
    .content-header,
    .breadcrumb,
    .content-wrapper > .container-fluid > .d-md-flex.align-items-center.justify-content-between.mb-5 {
        display: none !important;
    }

    /* 2. UI Styles */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }

    .stat-card {
        border: none;
        border-radius: 28px;
        padding: 1.8rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 30px -10px rgba(0,0,0,0.1) !important;
    }

    .icon-box {
        width: 55px;
        height: 55px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 1.2rem;
        background: white;
    }

    /* 3. Equal Height Panel Logic */
    .dashboard-panels {
        display: flex;
        flex-wrap: wrap;
    }

    .dashboard-panels > [class*="col-"] {
        display: flex;
        flex-direction: column;
    }

    .chart-card, .activity-card {
        border-radius: 30px;
        border: 1px solid #e2e8f0;
        background: white;
        padding: 2.5rem;
        height: var(--dashboard-panel-height);
        width: 100%;
        display: flex;
        flex-direction: column;
        margin-top: 0 !important;
    }

    @media (max-width: 991.98px) {
        .chart-card, .activity-card {
            height: auto;
        }
    }

    .activity-list {
        flex: 1;
        max-height: 480px;
        overflow-y: auto;
        padding-right: 8px;
    }

    /* Custom Scrollbar */
    .activity-list::-webkit-scrollbar {
        width: 4px;
    }

    .activity-list::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }

    .activity-item {
        display: flex;
        gap: 1rem;
        padding: 1.35rem 1.4rem;
        border: 1px solid #f1f5f9;
        background: #f8fafc;
        border-radius: 20px;
        margin-bottom: 1rem;
        transition: all 0.2s;
    }

    .activity-item:hover {
        background: #f1f5f9;
        border-color: #e2e8f0;
    }

    .activity-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: white;
        color: #6366f1;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        flex-shrink: 0;
        font-size: 1.05rem;
    }

    .activity-title {
        font-size: 1.08rem;
        line-height: 1.25;
    }

    .activity-meta {
        font-size: 0.92rem;
    }

    .activity-time {
        font-size: 0.82rem;
    }

    /* Date Stamp */
    .date-stamp {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .fw-800 { font-weight: 800 !important; }
    .fw-700 { font-weight: 700 !important; }
</style>

<div class="container-fluid py-1">
    
    <div class="glass-card rounded-3xl p-8 mb-8 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center gap-6">
             <div class="bg-indigo-100 p-3 rounded-2xl">
                <i class="bi bi-grid-fill text-3xl text-indigo-600"></i>
            </div>
            <div>
                <h1 class="text-3xl fw-800 text-slate-900 mb-1">Dashboard</h1>
                <p class="text-gray-500 font-medium mb-0">Ringkasan status permohonan dan statistik sistem terkini</p>
            </div>
        </div>
        
        <div class="mt-4 md:mt-0">
            <div class="date-stamp shadow-sm">
                <i class="bi bi-calendar-event"></i>
                <span id="currentDateTime"><?= date('M d 2026, H:i:s') ?></span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-8">
        <div class="col-md-3">
            <div class="stat-card shadow-sm" style="background: var(--deep-lilac); color: white;">
                <div class="icon-box bg-white bg-opacity-20 text-white border-0">
                    <i class="bi bi-patch-check"></i>
                </div>
                <h6 class="fw-700 small text-uppercase opacity-75 mb-1">Servis Kelulusan</h6>
                <h2 class="fw-800 mb-0" style="font-size: 2.2rem;"><?= number_format($totalServisKelulusan) ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card shadow-sm" style="background: var(--emerald-green); color: white;">
                <div class="icon-box bg-white bg-opacity-20 text-white border-0">
                    <i class="bi bi-file-earmark-check"></i>
                </div>
                <h6 class="fw-700 small text-uppercase opacity-75 mb-1 text-white">Dokumen Lulus</h6>
                <h2 class="fw-800 mb-0" style="font-size: 2.2rem;"><?= number_format($dokApproved) ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card shadow-sm border" style="background: var(--soft-emerald);">
                <div class="icon-box text-success shadow-sm">
                    <i class="bi bi-folder2-open"></i>
                </div>
                <h6 class="fw-700 small text-uppercase mb-1 opacity-75" style="color: var(--emerald-green);">Jumlah Dokumen</h6>
                <h2 class="fw-800 mb-0" style="font-size: 2.2rem; color: #10b981;"><?= number_format($totalDokumen) ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card shadow-sm border" style="background: var(--soft-lilac);">
                <div class="icon-box text-purple shadow-sm">
                    <i class="bi bi-ui-checks-grid"></i>
                </div>
                <h6 class="fw-700 small text-uppercase mb-1 opacity-75" style="color: var(--deep-lilac);">Perincian Modul</h6>
                <h2 class="fw-800 mb-0" style="font-size: 2.2rem; color: var(--deep-lilac);"><?= number_format($totalPerincianModul) ?></h2>
            </div>
        </div>
    </div>

    <div class="row g-4 dashboard-panels">
        <div class="col-lg-5">
            <div class="chart-card shadow-sm">
                <h5 class="fw-800 mb-6 text-dark">Analisis Status Keseluruhan</h5>
                <div style="height: 250px; position: relative;" class="mb-4">
                    <canvas id="statusChart"></canvas>
                </div>
                
                <div class="mt-8 space-y-4">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm fw-700 text-amber-600">Pending</span>
                            <span class="text-sm fw-800 text-slate-700"><?= $dokPending ?></span>
                        </div>
                        <div class="progress rounded-pill shadow-sm" style="height: 10px; background: #f1f5f9;">
                            <div class="progress-bar bg-warning" style="width: <?= ($totalDokumen > 0) ? ($dokPending/$totalDokumen)*100 : 0 ?>%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm fw-700 text-success">Approved</span>
                            <span class="text-sm fw-800 text-slate-700"><?= $dokApproved ?></span>
                        </div>
                        <div class="progress rounded-pill shadow-sm" style="height: 10px; background: #f1f5f9;">
                            <div class="progress-bar bg-success" style="width: <?= ($totalDokumen > 0) ? ($dokApproved/$totalDokumen)*100 : 0 ?>%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm fw-700 text-danger">Rejected</span>
                            <span class="text-sm fw-800 text-slate-700"><?= $dokRejected ?></span>
                        </div>
                        <div class="progress rounded-pill shadow-sm" style="height: 10px; background: #f1f5f9;">
                            <div class="progress-bar bg-danger" style="width: <?= ($totalDokumen > 0) ? ($dokRejected/$totalDokumen)*100 : 0 ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="activity-card shadow-sm">
                <div class="mb-6">
                    <h5 class="fw-800 mb-1 text-dark">Aktiviti Terkini</h5>
                    <p class="text-slate-500 mb-0">Jejak audit aktiviti pengguna dalam sistem</p>
                </div>

                <?php if (!empty($recentActivities)): ?>
                    <div class="activity-list">
                        <?php foreach ($recentActivities as $activity): ?>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="bi bi-pencil-square"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-2">
                                        <div>
                                            <h6 class="fw-700 text-dark mb-1 activity-title"><?= esc($activity['subject'] ?? 'Aktiviti Sistem') ?></h6>
                                            <p class="text-slate-500 mb-0 activity-meta">
                                                Oleh <span class="font-bold text-indigo-600"><?= esc($activity['username'] ?? 'Sistem') ?></span>
                                            </p>
                                        </div>
                                        <span class="text-slate-400 font-semibold whitespace-nowrap bg-white px-3 py-1 rounded-lg border activity-time">
                                            <?= !empty($activity['created_at']) ? date('d M Y, H:i', strtotime($activity['created_at'])) : '-' ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="activity-empty flex-1 flex flex-col items-center justify-center text-center p-8 bg-slate-50 rounded-3xl border border-dashed border-slate-300">
                        <i class="bi bi-journal-x text-4xl text-slate-300 mb-3"></i>
                        <h6 class="fw-700 text-slate-500">Tiada Aktiviti Terkini</h6>
                        <p class="text-slate-400 small mb-0">Segala aktiviti log pengguna akan dipaparkan di sini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Real-time Clock Update
        setInterval(() => {
            const now = new Date();
            const options = { month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            const timeStr = now.toLocaleString('en-US', options).replace(',', '');
            const el = document.getElementById('currentDateTime');
            if (el) el.innerText = timeStr;
        }, 1000);

        // Donut Chart Initialization
        const ctx = document.getElementById('statusChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Approved', 'Rejected'],
                    datasets: [{
                        data: [<?= $dokPending ?>, <?= $dokApproved ?>, <?= $dokRejected ?>],
                        backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                        borderWidth: 0,
                        hoverOffset: 12
                    }]
                },
                options: {
                    cutout: '75%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right',
                            labels: {
                                usePointStyle: true,
                                padding: 25,
                                font: { size: 13, weight: '700', family: "'Plus Jakarta Sans'" }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>
