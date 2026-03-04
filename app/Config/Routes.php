<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// --------------------------------------------------------------------
// 1. PUBLIC ROUTES (SHIELD AUTH & RESET PASSWORD)
// --------------------------------------------------------------------

// Daftarkan semua route automatic Shield (Login, Register, dsb)
service('auth')->routes($routes);

/**
 * Route Reset Password (Public)
 * Diletakkan di luar group session supaya user yang belum login boleh akses.
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

    // Default Route ICT4U
    $routes->get('/', 'Dashboard\DashboardController::index');

    /**
     * Profile Management
     * Wajib guna "\" kat depan App untuk panggil Controller Auth Mai sendiri.
     */
    $routes->get('profile', '\App\Controllers\Auth::profile'); 
    $routes->post('profile/update', '\App\Controllers\Auth::updateProfile');
    $routes->post('profile/update-password', '\App\Controllers\Auth::updatePassword');
    $routes->get('profile/delete-pic', '\App\Controllers\Auth::deleteProfilePic');

    // --- Dashboard Routes ---
    $routes->group('dashboard', ['namespace' => 'App\Controllers\Dashboard'], function($routes) {
        $routes->get('/', 'DashboardController::index');
        $routes->get('loadPage/(:segment)', 'DashboardController::loadPage/$1');
        $routes->get('getData', 'DashboardController::getData');
    });

    // --- Perincian Modul ---
    $routes->group('perincianmodul', ['namespace' => 'App\Controllers'], function($routes) {
        $routes->get('/', 'PerincianModulController::index');
        $routes->get('getServis/(:num)', 'PerincianModulController::getServis/$1');
        $routes->post('save', 'PerincianModulController::save');
        $routes->get('delete/(:num)', 'PerincianModulController::delete/$1');
    });

    // --- Tambahan Perincian Modul ---
    $routes->group('dashboard', ['namespace' => 'App\Controllers'], function ($routes) {
        $routes->get('TambahanPerincian', 'TambahanPerincianController::index');
        $routes->get('TambahanPerincian/getServis/(:num)', 'TambahanPerincianController::getServis/$1');
        $routes->post('TambahanPerincian/saveServis', 'TambahanPerincianController::saveServis');
        $routes->post('TambahanPerincian/deleteServis', 'TambahanPerincianController::deleteServis');
        $routes->get('TambahanPerincian/getAll', 'TambahanPerincianController::getAll');
    });

    // --- Dokumen Management ---
    $routes->group('dokumen', ['namespace' => 'App\Controllers'], function($routes) {
        $routes->get('/', 'DokumenController::index');
        $routes->get('getDokumen/(:num)', 'DokumenController::getDokumen/$1');
        $routes->post('tambah', 'DokumenController::tambah');
        $routes->post('kemaskini/(:num)', 'DokumenController::kemaskini/$1');
        $routes->post('hapus/(:num)', 'DokumenController::hapus/$1');
        $routes->get('viewFile/(:num)/(:any)', 'DokumenController::viewFile/$1/$2');
    });

    // --- FAQ Management ---
    $routes->group('faq', ['namespace' => 'App\Controllers'], function($routes){
        $routes->get('/', 'FaqController::index');
        $routes->get('(:num)', 'FaqController::index/$1');
        $routes->get('create/(:num)', 'FaqController::create/$1');
        $routes->post('store', 'FaqController::store');
        $routes->get('edit/(:num)', 'FaqController::edit/$1');
        $routes->post('update/(:num)', 'FaqController::update/$1');
        $routes->delete('delete/(:num)', 'FaqController::delete/$1');
        $routes->get('ajax/(:num)', 'FaqController::ajax/$1');
    });

    // --- User Management ---
    $routes->group('users', ['namespace' => 'App\Controllers'], function($routes){
        $routes->get('/', 'UserController::index');
        $routes->get('getAll', 'UserController::getAll');
        $routes->post('add', 'UserController::add');
        $routes->post('update/(:num)', 'UserController::update/$1');
        $routes->post('delete/(:num)', 'UserController::delete/$1');
    });
});