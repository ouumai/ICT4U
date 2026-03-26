<?php 
    $uri = service('uri');
    $segments = $uri->getSegments(); 
    
    // Safety check: elak error kalau URL pendek
    $seg1 = $segments[0] ?? ''; 

    // LOGIC NAV BAR:
    $isDokumenActive = ($seg1 === 'pengesahandokumen' || $seg1 === 'pengurusandokumen');
    $isTambahanActive = ($seg1 === 'tambahanperincian');
?>

<style>
    /* SIDEBAR CONTAINER */
    .main-sidebar {
        background-color: #ffffff !important;
        border-right: 1px solid #e2e8f0 !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
        height: 100vh;
        position: fixed;
        top: 0; bottom: 0; left: 0;
        display: flex;
        flex-direction: column;
    }

    /* HEADER LOGO */
    .brand-link { 
        border-bottom: 1px solid #f1f5f9 !important; 
        padding: 1.5rem 1rem !important; 
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 128px;
        transition: padding 0.3s ease, min-height 0.3s ease;
    }

    .brand-logo-img {
        height: 80px; 
        width: auto;
        max-width: 180px; 
        display: block;
        margin: 0 auto;
        transition: transform 0.3s ease;
    }

    /* SCROLLABLE AREA */
    .sidebar { 
        flex: 1; 
        overflow-y: auto; 
        padding-top: 30px !important; /* Tambah jarak supaya menu ke bawah sikit */
    }

    /* MENU ITEMS STYLE */
    .nav-pills .nav-link {
        color: #64748b !important;
        border-radius: 12px !important;
        margin: 4px 12px;
        padding: 10px 15px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .nav-link-content { 
        display: flex; 
        align-items: center; 
    }

    .nav-pills .nav-link i.nav-icon {
        color: #94a3b8;
        transition: all 0.2s;
        margin-right: 12px;
        font-size: 1.1rem;
    }

    /* ACTIVE STATE (TEMA LAVENDER BARU) */
    .nav-pills .nav-link.active {
        background-color: #f0f0fb !important; /* Soft Lavender */
        color: #624aea !important; /* Dark Lavender untuk text/icon */
    }
    .nav-pills .nav-link.active i.nav-icon { 
        color: #624aea !important; 
    }
    
    /* HOVER STATE (STYLE ASAL KAU) */
    .nav-pills .nav-link:hover:not(.active):not(.logout-btn) {
        background-color: #f8fafc !important; /* Kelabu cair style lama */
        color: #1e293b !important; /* Text gelap style lama */
    }
    .nav-pills .nav-link:hover:not(.active):not(.logout-btn) i.nav-icon { 
        color: #1e293b !important; 
    }

    /* SUB-MENU STYLING */
    .nav-treeview { 
        margin-left: 10px; 
        background: transparent; 
    }
    .nav-treeview .nav-link { 
        font-size: 0.85rem; 
        padding-left: 20px; 
    }
    
    /* LOGOUT BTN STYLE */
    .nav-link.logout-btn { margin-top: 20px; border: 1px solid #fee2e2; color: #dc2626 !important; }
    .nav-link.logout-btn i.nav-icon { color: #94a3b8 !important; }
    .nav-link.logout-btn:hover { background-color: #fee2e2 !important; color: #dc2626 !important; }
    .nav-link.logout-btn:hover i.nav-icon { color: #dc2626 !important; }
    
    /* ARROW ANIMATION */
    .nav-arrow { 
        transition: transform 0.15s ease-out; 
        font-size: 0.8rem !important; 
        color: #7B68EE; 
    }
    .nav-link.active .nav-arrow { color: #BF7ABB !important; }
    .nav-item.menu-open .nav-link .nav-arrow { transform: rotate(180deg) !important; }

    /* COLLAPSED SIDEBAR - ICON ONLY */
    body.sidebar-collapse .main-sidebar {
        width: 78px !important;
        min-width: 78px !important;
        overflow: hidden;
        z-index: 1036 !important;
    }

    body.sidebar-collapse .brand-link {
        padding: 1rem 0.5rem !important;
        min-height: 72px;
    }

    body.sidebar-collapse .brand-logo-img {
        opacity: 0;
        visibility: hidden;
        width: 0;
        height: 0;
        max-width: 0;
        transform: scale(0.8);
    }

    body.sidebar-collapse .sidebar {
        padding-top: 18px !important;
    }

    body.sidebar-collapse .nav-sidebar > .nav-item {
        width: 100%;
    }

    body.sidebar-collapse .nav-pills .nav-link {
        margin: 6px 10px !important;
        padding: 12px !important;
        justify-content: center !important;
        min-height: 48px;
    }

    body.sidebar-collapse .nav-link-content {
        justify-content: center !important;
        width: 100%;
    }

    body.sidebar-collapse .nav-pills .nav-link p,
    body.sidebar-collapse .nav-arrow,
    body.sidebar-collapse .nav-treeview {
        display: none !important;
    }

    body.sidebar-collapse .nav-pills .nav-link i.nav-icon {
        margin-right: 0 !important;
        font-size: 1.2rem;
    }

    body.sidebar-collapse .nav-link.logout-btn {
        padding: 12px !important;
    }

    body.sidebar-collapse .main-sidebar:hover .nav-pills .nav-link {
        justify-content: space-between !important;
    }

    body.sidebar-collapse .main-sidebar:hover {
        width: 270px !important;
        z-index: 1055 !important;
        overflow: visible !important;
    }

    body.sidebar-collapse .main-sidebar:hover .brand-link {
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 1.5rem 1rem !important;
        min-height: 128px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    body.sidebar-collapse .main-sidebar:hover .brand-logo-img {
        opacity: 1;
        visibility: visible;
        display: block;
        margin: 0 auto;
        width: auto;
        height: 80px;
        max-width: 180px;
        transform: scale(1);
    }

    body.sidebar-collapse .main-sidebar:hover .sidebar {
        padding-top: 30px !important;
    }

    body.sidebar-collapse .main-sidebar:hover .nav-link-content {
        justify-content: flex-start !important;
    }

    body.sidebar-collapse .main-sidebar:hover .nav-pills .nav-link p,
    body.sidebar-collapse .main-sidebar:hover .nav-arrow {
        display: block !important;
    }

    body.sidebar-collapse .main-sidebar:hover .nav-item.menu-open > .nav-treeview {
        display: block !important;
    }

    body.sidebar-collapse .main-sidebar:hover .nav-pills .nav-link i.nav-icon {
        margin-right: 12px !important;
    }
</style>

<aside class="main-sidebar elevation-0">
    <a href="<?= url_to('dashboard') ?>" class="brand-link text-center text-decoration-none">
        <img src="<?= base_url('assets/image/ICT4ULogo.svg') ?>" 
             alt="ICT4U Logo" 
             class="brand-logo-img">
    </a>

    <div class="sidebar">
        <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="<?= url_to('dashboard') ?>" 
                       class="nav-link <?= ($seg1 === 'dashboard' || $seg1 === '') ? 'active' : '' ?>">
                        <div class="nav-link-content">
                            <i class="nav-icon bi bi-grid-fill"></i>
                            <p class="mb-0">Dashboard</p>
                        </div>
                    </a>
                </li>

                <li class="nav-item <?= $isDokumenActive ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= $isDokumenActive ? 'active' : '' ?>">
                        <div class="nav-link-content">
                            <i class="nav-icon bi bi-file-earmark-text-fill"></i>
                            <p class="mb-0">Dokumen</p>
                        </div>
                        <i class="nav-arrow bi bi-chevron-down"></i>
                    </a>
                    
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= url_to('pengesahan_dokumen') ?>" 
                            class="nav-link <?= ($seg1 === 'pengesahandokumen') ? 'active' : '' ?>">
                                <div class="nav-link-content">
                                    <i class="nav-icon bi bi-check-circle"></i>
                                    <p class="mb-0">Pengesahan Dokumen</p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= url_to('pengurusan_dokumen') ?>" 
                            class="nav-link <?= ($seg1 === 'pengurusandokumen') ? 'active' : '' ?>">
                                <div class="nav-link-content">
                                    <i class="nav-icon bi bi-files"></i>
                                    <p class="mb-0">Pengurusan Dokumen</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?= url_to('perincian_modul') ?>" 
                       class="nav-link <?= $seg1 === 'perincianmodul' ? 'active' : '' ?>">
                        <div class="nav-link-content">
                            <i class="nav-icon bi bi-collection-fill"></i>
                            <p class="mb-0">Perincian Modul</p>
                        </div>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= url_to('tambahan_perincian') ?>" 
                       class="nav-link <?= $seg1 === 'tambahanperincian' ? 'active' : '' ?>">
                        <div class="nav-link-content">
                            <i class="nav-icon bi bi-folder-plus"></i>
                            <p class="mb-0">Tambahan Perincian</p>
                        </div>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= url_to('faq') ?>" class="nav-link <?= $seg1 === 'faq' ? 'active' : '' ?>">
                        <div class="nav-link-content">
                            <i class="nav-icon bi bi-question-diamond-fill"></i>
                            <p class="mb-0">FAQ</p>
                        </div>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= url_to('profile') ?>" class="nav-link <?= $seg1 === 'profile' ? 'active' : '' ?>">
                        <div class="nav-link-content">
                            <i class="nav-icon bi bi-person-bounding-box"></i>
                            <p class="mb-0">My Profile</p>
                        </div>
                    </a>
                </li>

                <li class="nav-item mt-4">
                    <a href="<?= base_url('logout') ?>" class="nav-link logout-btn">
                        <div class="nav-link-content">
                            <i class="nav-icon bi bi-box-arrow-left"></i>
                            <p class="mb-0">Sign Out</p>
                        </div>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
