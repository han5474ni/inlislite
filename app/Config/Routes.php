<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================================
// CORE ROUTES
// ============================================================================

// Home & Dashboard Routes
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('dashboard', 'Home::dashboard');

// About/Tentang Routes
$routes->get('tentang', 'Home::tentang');
$routes->get('tentang-aplikasi', 'Home::tentang');
$routes->get('about', 'Home::tentang');

// Panduan Routes
$routes->get('panduan', 'Home::panduan');
$routes->get('guide', 'Home::panduan');

// Authentication Routes
$routes->get('logout', 'Auth::logout');

// ============================================================================
// USER MANAGEMENT ROUTES
// ============================================================================

$routes->group('users', function($routes) {
    $routes->get('new', 'UserManagement::index');
    $routes->post('addUser', 'UserManagement::addUser');
    $routes->get('edit/(:num)', 'UserManagement::edit/$1');
    $routes->post('update/(:num)', 'UserManagement::update/$1');
    $routes->get('delete/(:num)', 'UserManagement::delete/$1');
});

// Legacy user management routes (for backward compatibility)
$routes->get('user-management', 'Home::userManagement');
$routes->get('registration', 'Home::registration');

// ============================================================================
// PATCH UPDATER ROUTES
// ============================================================================

// Main patch updater routes
$routes->group('patch-updater', function($routes) {
    // Main pages
    $routes->get('/', 'PatchUpdater::index');
    $routes->get('create', 'PatchUpdater::create');
    $routes->get('edit/(:num)', 'PatchUpdater::edit/$1');
    
    // CRUD operations
    $routes->post('save', 'PatchUpdater::save');
    $routes->post('update/(:num)', 'PatchUpdater::update/$1');
    $routes->get('delete/(:num)', 'PatchUpdater::delete/$1');
    
    // Special actions
    $routes->get('download/(:num)', 'PatchUpdater::download/$1');
    $routes->get('export', 'PatchUpdater::export');
    
    // AJAX endpoints
    $routes->post('ajax', 'PatchUpdater::ajaxHandler');
    $routes->post('ajaxHandler', 'PatchUpdater::ajaxHandler'); // Alternative endpoint
});

// Legacy patch routes (for backward compatibility)
$routes->group('patch', function($routes) {
    $routes->get('/', 'PatchUpdater::index');
    $routes->post('ajax', 'PatchUpdater::ajaxHandler');
    $routes->post('ajaxHandler', 'PatchUpdater::ajaxHandler');
    $routes->get('export', 'PatchUpdater::export');
});

// ============================================================================
// APLIKASI PENDUKUNG ROUTES
// ============================================================================

// Main aplikasi pendukung routes
$routes->group('aplikasi-pendukung', function($routes) {
    // Main pages
    $routes->get('/', 'AplikasiPendukung::index');
    $routes->get('detail/(:segment)', 'AplikasiPendukung::detail/$1');
    
    // Download actions
    $routes->get('download/(:segment)', 'AplikasiPendukung::download/$1');
    $routes->post('download', 'AplikasiPendukung::handleDownload');
    
    // AJAX endpoints
    $routes->post('ajax', 'AplikasiPendukung::ajaxHandler');
});

// Alternative routes for aplikasi pendukung
$routes->get('aplikasi', 'AplikasiPendukung::index');
$routes->get('supporting-apps', 'AplikasiPendukung::index');

// ============================================================================
// API ROUTES (if needed for future development)
// ============================================================================

$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes) {
    // Future API endpoints can be added here
    // $routes->resource('patches', ['controller' => 'PatchAPI']);
    // $routes->resource('applications', ['controller' => 'ApplicationAPI']);
});

// ============================================================================
// ADMIN ROUTES (if needed for future development)
// ============================================================================

$routes->group('admin', function($routes) {
    // Future admin routes can be added here
    // $routes->get('settings', 'Admin::settings');
    // $routes->get('logs', 'Admin::logs');
});

// ============================================================================
// LOAD ENVIRONMENT AND SYSTEM ROUTES
// ============================================================================

// Load environment-specific routes
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

// Load the system's routing file
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}
