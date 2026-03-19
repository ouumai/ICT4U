<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// --------------------------------------------------------------------
// 1. PUBLIC ROUTES (SHIELD AUTH & RESET PASSWORD)
// --------------------------------------------------------------------

// Daftarkan semua route automatic Shield (Login, Register, dsb)
service('auth')->routes($routes);

$routes->get('test-mail', 'Home::testEmail');

/**
 * Route Reset Password (Public)
 */
$routes->get('reset-password', static function() {
    return view('auth/reset_password');
});
$routes->post('reset-password', 'Dashboard\DashboardController::updatePassword');

/**
 * Route Magic Link Verify
 */
$routes->get('login/magic-link/verify', '\CodeIgniter\Shield\Controllers\MagicLinkController::verify', ['as' => 'magic-link-verify']);

// --------------------------------------------------------------------
// 2. PROTECTED ROUTES (WAJIB LOGIN - SESSION FILTER)
// --------------------------------------------------------------------
$routes->group('', ['filter' => 'session'], static function ($routes) {

    // --- Utama & Redirect ---
    // User masuk localhost:8080/ terus hantar ke /dashboard
    $routes->addRedirect('/', 'dashboard'); 

    // Dashboard
    $routes->get('dashboard', 'Dashboard\DashboardController::index', ['as' => 'dashboard']);

    /**
     * Profile Management
     */
    $routes->get('profile', '\App\Controllers\Auth::profile', ['as' => 'profile']); 
    $routes->post('profile/update', '\App\Controllers\Auth::updateProfile');
    $routes->post('profile/update-password', '\App\Controllers\Auth::updatePassword');
    $routes->get('profile/delete-pic', '\App\Controllers\Auth::deleteProfilePic');

    /**
     * Pengesahan Dokumen (Mapping URL Baru)
     */
    $routes->group('pengesahandokumen', ['namespace' => 'App\Controllers'], function($routes) {
        $routes->get('/', 'ApprovalDokumenController::index', ['as' => 'pengesahan_dokumen']);
        $routes->get('getAll', 'ApprovalDokumenController::getAll');
        $routes->get('getDokumen/(:num)', 'ApprovalDokumenController::getDokumen/$1');
        $routes->post('changeStatus/(:num)/(:any)', 'ApprovalDokumenController::changeStatus/$1/$2');
        $routes->get('viewFile/(:num)/(:any)', 'ApprovalDokumenController::viewFile/$1/$2');
    });

    /**
     * Pengurusan Dokumen (Mapping URL Baru)
     */
    $routes->group('pengurusandokumen', ['namespace' => 'App\Controllers'], function($routes) {
        $routes->get('/', 'DokumenController::index', ['as' => 'pengurusan_dokumen']);
        $routes->get('getDokumen/(:num)', 'DokumenController::getDokumen/$1');
        $routes->get('getDokumenDetail/(:num)', 'DokumenController::getDokumenDetail/$1');
        $routes->post('tambah', 'DokumenController::tambah');
        $routes->get('edit/(:num)', 'DokumenController::edit/$1'); 
        $routes->post('kemaskini/(:num)', 'DokumenController::kemaskini/$1');
        $routes->post('hapus/(:num)', 'DokumenController::hapus/$1');
        $routes->get('viewFile/(:num)/(:any)', 'DokumenController::viewFile/$1/$2');
    });

    /**
     * Perincian Modul
     */
    $routes->group('perincianmodul', ['namespace' => 'App\Controllers'], function($routes) {
        $routes->get('/', 'PerincianModulController::index', ['as' => 'perincian_modul']);
        $routes->get('getServis/(:num)', 'PerincianModulController::getServis/$1');
        $routes->post('save', 'PerincianModulController::save');
        $routes->get('delete/(:num)', 'PerincianModulController::delete/$1');
    });

    /**
     * Tambahan Perincian Modul
     */
    $routes->get('tambahanperincian', 'TambahanPerincianController::index', ['as' => 'tambahan_perincian']);
    $routes->get('tambahanperincian/getAll', 'TambahanPerincianController::getAll');
    $routes->post('tambahanperincian/saveServis', 'TambahanPerincianController::saveServis');
    $routes->post('tambahanperincian/deleteServis', 'TambahanPerincianController::deleteServis');

    /**
     * FAQ Management (Single Page)
     */
    $routes->group('faq', function($routes){
        $routes->get('/', 'FaqController::index', ['as' => 'faq']); 
        $routes->get('(:num)', 'FaqController::index/$1');
        $routes->post('store', 'FaqController::store');
        $routes->post('update/(:num)', 'FaqController::update/$1');
        $routes->delete('delete/(:num)', 'FaqController::delete/$1');
        $routes->get('ajax/(:num)', 'FaqController::ajax/$1');
    });

    /**
     * User Management
     */
    $routes->group('users', ['namespace' => 'App\Controllers'], function($routes){
        $routes->get('/', 'UserController::index', ['as' => 'user_list']);
        $routes->get('getAll', 'UserController::getAll');
        $routes->post('add', 'UserController::add');
        $routes->post('update/(:num)', 'UserController::update/$1');
        $routes->post('delete/(:num)', 'UserController::delete/$1');
    });

    /**
     * Auth Clean Links (Custom Mapping)
     */
    $routes->get('login', 'Login::index', ['as' => 'login']);
    $routes->post('login', 'Login::attemptLogin'); 
    $routes->get('register', 'Register::index', ['as' => 'register']);
    $routes->get('tukarkatalaluan', 'Login::magic_link', ['as' => 'tukarkatalaluan']);

});