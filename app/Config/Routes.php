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
$routes->get('panduan', 'DocumentController::index');
$routes->get('guide', 'DocumentController::index');

// Document Management AJAX Routes
$routes->group('documents', function($routes) {
    $routes->get('/', 'DocumentController::getDocuments');
    $routes->get('(:num)', 'DocumentController::getDocument/$1');
    $routes->post('add', 'DocumentController::addDocument');
    $routes->post('update/(:num)', 'DocumentController::updateDocument/$1');
    $routes->post('delete/(:num)', 'DocumentController::deleteDocument/$1');
    $routes->get('download/(:num)', 'DocumentController::downloadDocument/$1');
    $routes->post('search', 'DocumentController::searchDocuments');
    $routes->post('setup', 'DocumentController::setupDatabase');
});

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
$routes->get('usermanagement', 'UserManagement::index');
$routes->post('usermanagement/addUser', 'UserManagement::addUser');
$routes->post('usermanagement/editUser/(:num)', 'UserManagement::editUser/$1');
$routes->get('usermanagement/deleteUser/(:num)', 'UserManagement::deleteUser/$1');

// AJAX user management routes
$routes->get('usermanagement/getUser/(:num)', 'UserManagement::getUser/$1');
$routes->post('usermanagement/addUserAjax', 'UserManagement::addUserAjax');
$routes->post('usermanagement/editUserAjax/(:num)', 'UserManagement::editUserAjax/$1');
$routes->post('usermanagement/deleteUserAjax/(:num)', 'UserManagement::deleteUserAjax/$1');
$routes->get('usermanagement/getUsersAjax', 'UserManagement::getUsersAjax');

$routes->get('registration', 'Home::registration');
$routes->get('registration-stats', 'Home::getRegistrationStats');
$routes->get('registration-data', 'Home::getRegistrationData');
$routes->get('registration-years', 'Home::getAvailableYears');
$routes->post('registration/add', 'Home::addRegistration');
$routes->post('registration/update-status', 'Home::updateRegistrationStatus');
$routes->get('registration/delete/(:num)', 'Home::deleteRegistration/$1');
$routes->get('setup/create-registrations-table', 'Setup::createRegistrationsTable');
$routes->get('debug-database', 'Home::debugDatabase');

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
