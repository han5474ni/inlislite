<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================================
// PUBLIC ROUTES
// ============================================================================

// Homepage - Public access
$routes->get('/', 'Public\PublicController::index');
$routes->get('home', 'Public\PublicController::index');

// Public pages
$routes->get('tentang', 'Public\PublicController::tentang');
$routes->get('tentang-aplikasi', 'Public\PublicController::tentang');
$routes->get('about', 'Public\PublicController::tentang');
$routes->get('panduan', function() {
    return redirect()->to(base_url('admin/panduan'));
});
$routes->get('guide', function() {
    return redirect()->to(base_url('admin/panduan'));
});
$routes->get('aplikasi', 'Public\PublicController::aplikasi');
$routes->get('supporting-apps', 'Public\PublicController::aplikasi');
$routes->get('patch', 'Public\PublicController::patch');
$routes->get('updates', 'Public\PublicController::patch');

// Demo routes (Public for testing - REMOVE IN PRODUCTION)
$routes->get('modern-dashboard', 'Admin\AdminController::modernDashboard');
$routes->get('user-management-demo', 'Admin\UserManagement::index');
$routes->get('profile-demo', 'Home::profile');

// Test registration view (REMOVE IN PRODUCTION)
$routes->get('test-registration-view/(:num)', 'Home::viewRegistration/$1');

// Debug routes (REMOVE IN PRODUCTION)
$routes->get('test-user-management-debug', function() {
    return file_get_contents(FCPATH . 'test_user_management_debug.php');
});

// Temporary upload routes for testing (REMOVE IN PRODUCTION)
$routes->get('test-upload-photo', 'ProfileController::index');
$routes->post('test-upload-photo', 'ProfileController::uploadPhoto');

// ============================================================================
// LOGIN & AUTHENTICATION ROUTES (Public accessible)
// ============================================================================

// Main login routes - using secure authentication
$routes->get('login', 'Admin\AuthController::login');
$routes->post('login/authenticate', 'Admin\AuthController::authenticate');
$routes->get('logout', 'Admin\AuthController::logout');
$routes->post('check-password-strength', 'Admin\AuthController::checkPasswordStrength');

// Legacy login page routes (redirect to main login)
$routes->get('loginpage', function() {
    return redirect()->to(base_url('login'));
});

// Admin group routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    // Login routes (accessible without authentication)
    $routes->get('login', 'AuthController::login');
    $routes->post('login/authenticate', 'AuthController::authenticate');
    $routes->get('logout', 'AuthController::logout');
    $routes->post('logout', 'AuthController::logout');
    $routes->post('check-password-strength', 'AuthController::checkPasswordStrength');
    
    // Registration routes (accessible without authentication)
    $routes->get('registration', '\App\Controllers\Home::registration');
    
    // Legacy secure routes (redirect to main login)
    $routes->get('secure-login', function() {
        return redirect()->to(base_url('admin/login'));
    });
    $routes->get('secure-logout', function() {
        return redirect()->to(base_url('admin/logout'));
    });
});

// ============================================================================
// PROTECTED ADMIN ROUTES (Require authentication)
// ============================================================================

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'adminauth'], function($routes) {
    // Admin Dashboard
    $routes->get('/', 'AdminController::index');
    $routes->get('dashboard', 'AdminController::index');
    $routes->get('modern-dashboard', 'AdminController::modernDashboard');
    // About page
    $routes->get('tentang', 'AdminController::tentang');
    // Panduan page
    $routes->get('panduan', 'AdminController::panduan');
    // Dukungan page
    $routes->get('dukungan', 'AdminController::dukungan');
    // Bimbingan page
    $routes->get('bimbingan', 'AdminController::bimbingan');
    // Patch page
    $routes->get('patch', 'AdminController::patch_updater');
    $routes->get('patch_updater', function() {
        return redirect()->to(base_url('admin/patch'));
    });
    // User Management
    $routes->group('users', function($routes) {
        $routes->get('/', 'UserManagement::index');
        $routes->get('create', 'UserManagement::create');
        $routes->post('store', 'UserManagement::store');
        $routes->get('edit/(:num)', 'UserManagement::edit/$1');
        $routes->post('update/(:num)', 'UserManagement::update/$1');
        $routes->get('delete/(:num)', 'UserManagement::delete/$1');
        
        // Secure user management
        $routes->get('add-secure', 'SecureUserController::addUser');
        $routes->post('store-secure', 'SecureUserController::storeSecure');
        $routes->post('check-password-strength', 'SecureUserController::checkPasswordStrength');
        $routes->post('generate-password', 'SecureUserController::generatePassword');
        
        // AJAX endpoints
        $routes->get('ajax/(:num)', 'UserManagement::getUser/$1');
        $routes->post('ajax/create', 'UserManagement::addUserAjax');
        $routes->post('ajax/update/(:num)', 'UserManagement::editUserAjax/$1');
        $routes->post('ajax/delete/(:num)', 'UserManagement::deleteUserAjax/$1');
        $routes->get('ajax/list', 'UserManagement::getUsersAjax');
        $routes->get('reloadUsers', 'UserManagement::reloadUsers');
    });
    
    // Profile Management
    $routes->get('profile', 'AdminController::profile');
    $routes->post('profile/update', 'AdminController::updateProfile');
    $routes->post('profile/change-password', 'AdminController::changePassword');
    $routes->post('profile/upload-photo', '\App\Controllers\ProfileController::uploadPhoto');
    
    // Patch Management
    $routes->group('patches', function($routes) {
        $routes->get('/', 'PatchController::index');
        $routes->get('create', 'PatchController::create');
        $routes->post('store', 'PatchController::store');
        $routes->get('edit/(:num)', 'PatchController::edit/$1');
        $routes->post('update/(:num)', 'PatchController::update/$1');
        $routes->get('delete/(:num)', 'PatchController::delete/$1');
        $routes->get('download/(:num)', 'PatchController::download/$1');
        $routes->post('toggle/(:num)', 'PatchController::toggle/$1');
    });
    
    // Application Management
    $routes->get('aplikasi', 'AplikasiPendukung::index');
    $routes->group('applications', function($routes) {
        $routes->get('/', 'AplikasiPendukung::index');
        $routes->get('detail/(:segment)', 'AplikasiPendukung::detail/$1');
        $routes->get('download/(:segment)', 'AplikasiPendukung::download/$1');
        $routes->post('ajax', 'AplikasiPendukung::ajaxHandler');
    });
    
    // Registration Management
    $routes->group('registration', function($routes) {
        $routes->get('/', '\App\Controllers\Home::registration');
        $routes->get('add', '\App\Controllers\Home::addRegistrationForm');
        $routes->post('add', '\App\Controllers\Home::addRegistration');
        $routes->get('edit/(:num)', '\App\Controllers\Home::editRegistrationForm/$1');
        $routes->post('edit/(:num)', '\App\Controllers\Home::updateRegistration/$1');
        $routes->get('view/(:num)', '\App\Controllers\Home::viewRegistration/$1');
        $routes->get('delete/(:num)', '\App\Controllers\Home::deleteRegistration/$1');
    });
    
    // Demo Program
    $routes->get('demo_program', 'DemoController::demo_program');
    $routes->group('demo', function($routes) {
        $routes->get('/', 'DemoController::index');
        $routes->get('cataloging', 'DemoController::cataloging');
        $routes->get('circulation', 'DemoController::circulation');
        $routes->get('membership', 'DemoController::membership');
        $routes->get('reporting', 'DemoController::reporting');
        $routes->get('opac', 'DemoController::opac');
        $routes->post('generate-sample', 'DemoController::generateSampleData');
    });
});

// ============================================================================
// INSTALLER ROUTES
// ============================================================================
$routes->group('installer', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'InstallerController::index');
    $routes->get('requirements', 'InstallerController::requirements');
    $routes->get('database', 'InstallerController::database');
    $routes->post('test-database', 'InstallerController::testDatabase');
    $routes->post('install', 'InstallerController::install');
    $routes->get('complete', 'InstallerController::complete');
});

// ============================================================================
// LEGACY ROUTES (for backward compatibility)
// ============================================================================

// Legacy Home routes - PROTECTED
$routes->get('dashboard', 'Home::dashboard', ['filter' => 'adminauth']);

// Legacy user management routes - PROTECTED
$routes->get('user-management', 'Home::userManagement', ['filter' => 'adminauth']);
$routes->get('usermanagement', 'Admin\UserManagement::index', ['filter' => 'adminauth']);
$routes->post('usermanagement/addUser', 'Admin\UserManagement::addUser', ['filter' => 'adminauth']);
$routes->post('usermanagement/editUser/(:num)', 'Admin\UserManagement::editUser/$1', ['filter' => 'adminauth']);
$routes->get('usermanagement/deleteUser/(:num)', 'Admin\UserManagement::deleteUser/$1', ['filter' => 'adminauth']);

// AJAX user management routes
$routes->get('usermanagement/getUser/(:num)', 'Admin\UserManagement::getUser/$1', ['filter' => 'adminauth']);
$routes->post('usermanagement/addUserAjax', 'Admin\UserManagement::addUserAjax', ['filter' => 'adminauth']);
$routes->post('usermanagement/editUserAjax/(:num)', 'Admin\UserManagement::editUserAjax/$1', ['filter' => 'adminauth']);
$routes->post('usermanagement/deleteUserAjax/(:num)', 'Admin\UserManagement::deleteUserAjax/$1', ['filter' => 'adminauth']);
$routes->get('usermanagement/getUsersAjax', 'Admin\UserManagement::getUsersAjax', ['filter' => 'adminauth']);

// Registration routes
$routes->get('registration', 'Home::registration');
$routes->get('registration-stats', 'Home::getRegistrationStats');
$routes->get('registration-data', 'Home::getRegistrationData');
$routes->get('registration-years', 'Home::getAvailableYears');
$routes->post('registration/add', 'Home::addRegistration');
$routes->get('registration/get/(:num)', 'Home::getRegistration/$1');
$routes->post('registration/update/(:num)', 'Home::updateRegistration/$1');
$routes->post('registration/update-status', 'Home::updateRegistrationStatus');
$routes->get('registration/delete/(:num)', 'Home::deleteRegistration/$1');
$routes->get('setup/create-registrations-table', 'Setup::createRegistrationsTable');
$routes->get('debug-database', 'Home::debugDatabase');

// Document management routes (removed - using admin routes instead)

// Profile routes
$routes->get('profile', 'Home::profile', ['filter' => 'adminauth']);
$routes->post('profile/update', 'Home::updateProfile', ['filter' => 'adminauth']);

// ============================================================================
// LOAD ENVIRONMENT AND SYSTEM ROUTES
// ============================================================================

// Load environment-specific routes
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}



// Database Sync Testing Routes
$routes->get('test_database_sync', function() {
    return file_get_contents(FCPATH . 'test_database_sync.php');
});
$routes->get('test_new_user_management', function() {
    return file_get_contents(FCPATH . 'test_new_user_management.html');
});
$routes->get('fix_user_sync', function() {
    return file_get_contents(FCPATH . 'fix_user_sync.php');
});

// Load the system's routing file
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}


// Additional admin routes (moved to admin group above)
