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
$routes->get('panduan', 'Public\PublicController::panduan');
$routes->get('guide', 'Public\PublicController::panduan');
$routes->get('aplikasi', 'Public\PublicController::aplikasi');
$routes->get('supporting-apps', 'Public\PublicController::aplikasi');
$routes->get('patch', 'Public\PublicController::patch');
$routes->get('updates', 'Public\PublicController::patch');

// Demo routes (Public for testing - REMOVE IN PRODUCTION)
$routes->get('modern-dashboard', 'Admin\AdminController::modernDashboard');
$routes->get('user-management-demo', 'Admin\UserManagement::index');
$routes->get('profile-demo', 'Home::profile');

// ============================================================================
// LOGIN & AUTHENTICATION ROUTES (Public accessible)
// ============================================================================

// Login page routes
$routes->get('loginpage', 'Admin\LoginController::index');
$routes->post('loginpage/authenticate', 'Admin\LoginController::authenticate');

// Forgot Password routes
$routes->get('forgot-password', 'Admin\LoginController::forgotPassword');
$routes->post('forgot-password/send', 'Admin\LoginController::sendResetLink');
$routes->get('reset-password/(:segment)', 'Admin\LoginController::resetPassword/$1');
$routes->post('reset-password/update', 'Admin\LoginController::updatePassword');

// Alternative admin login routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    // Login routes (accessible without authentication)
    $routes->get('login', 'LoginController::index');
    $routes->post('login/authenticate', 'LoginController::authenticate');
    $routes->get('login/test-redirect', 'LoginController::testRedirect');
    $routes->get('logout', 'LoginController::logout');
    $routes->post('logout', 'LoginController::logout');
    $routes->post('check-password-strength', 'LoginController::checkPasswordStrength');
    
    // Registration routes (accessible without authentication)
    $routes->get('registration', '\App\Controllers\Home::registration');
    
    // Secure login routes
    $routes->get('secure-login', 'SecureAuthController::login');
    $routes->post('secure-login/authenticate', 'SecureAuthController::authenticate');
    $routes->get('secure-logout', 'SecureAuthController::logout');
    $routes->post('secure-check-password-strength', 'SecureAuthController::checkPasswordStrength');
    
    // Forgot Password routes
    $routes->get('forgot-password', 'LoginController::forgotPassword');
    $routes->post('forgot-password/send', 'LoginController::sendResetLink');
    $routes->get('reset-password/(:segment)', 'LoginController::resetPassword/$1');
    $routes->post('reset-password/update', 'LoginController::updatePassword');
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
    $routes->get('profile', '\App\Controllers\Home::profile');
    $routes->post('profile/update', '\App\Controllers\Home::updateProfile');
    
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
    $routes->group('applications', function($routes) {
        $routes->get('/', 'AplikasiPendukung::index');
        $routes->get('detail/(:segment)', 'AplikasiPendukung::detail/$1');
        $routes->get('download/(:segment)', 'AplikasiPendukung::download/$1');
        $routes->post('ajax', 'AplikasiPendukung::ajaxHandler');
    });
    
    // Demo Program
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

// Document management routes
$routes->get('panduan', 'DocumentController::index');
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


// Simple login routes (for testing CSRF issues)
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('simple-login', 'SimpleLoginController::index');
    $routes->post('simple-login/authenticate', 'SimpleLoginController::authenticate');
    $routes->get('simple-logout', 'SimpleLoginController::logout');
    $routes->get('simple-dashboard', 'SimpleLoginController::dashboard');
});

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


// Additional admin routes
$routes->get('admin/patch_updater', 'Admin\AdminController::patch_updater', ['filter' => 'adminauth']);
