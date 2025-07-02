<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class SimpleLoginController extends BaseController
{
    protected $userModel;
    protected $session;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }
    
    /**
     * Display simple login form
     */
    public function index()
    {
        // If already logged in, redirect to dashboard
        if ($this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/simple-dashboard');
        }
        
        $data = [
            'title' => 'Simple Login - INLISLite v3'
        ];
        
        return view('admin/auth/simple_login', $data);
    }
    
    /**
     * Process login authentication
     */
    public function authenticate()
    {
        // Basic validation
        $rules = [
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[3]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username dan password harus diisi dengan benar');
        }
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $rememberMe = $this->request->getPost('remember_me');
        
        // Find user by username or email
        $user = $this->findUserByUsernameOrEmail($username);
        
        if (!$user) {
            log_message('warning', 'Failed login attempt for username: ' . $username);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username atau password salah');
        }
        
        // Verify password
        if (!password_verify($password, $user['kata_sandi'])) {
            log_message('warning', 'Failed login attempt for username: ' . $username);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username atau password salah');
        }
        
        // Check if user is active
        if ($user['status'] !== 'Aktif') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Akun Anda tidak aktif. Hubungi administrator.');
        }
        
        // Check if user has admin privileges
        if (!in_array($user['role'], ['Super Admin', 'Admin'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Anda tidak memiliki akses admin');
        }
        
        // Login successful - create session
        $sessionData = [
            'admin_id' => $user['id'],
            'admin_username' => $user['nama_pengguna'],
            'admin_name' => $user['nama_lengkap'],
            'admin_email' => $user['email'],
            'admin_role' => $user['role'],
            'admin_logged_in' => true,
            'login_time' => time()
        ];
        
        $this->session->set($sessionData);
        
        // Update last login time
        $this->userModel->updateLastLogin($user['id']);
        
        // Log successful login
        log_message('info', 'Successful login for username: ' . $username);
        
        // Redirect to admin dashboard
        return redirect()->to('/admin/simple-dashboard')->with('success', 'Selamat datang, ' . $user['nama_lengkap'] . '!');
    }
    
    /**
     * Logout user
     */
    public function logout()
    {
        // Log logout
        $username = $this->session->get('admin_username');
        if ($username) {
            log_message('info', 'Logout for username: ' . $username);
        }
        
        // Destroy session
        $this->session->destroy();
        
        return redirect()->to('/admin/simple-login')->with('success', 'Anda telah berhasil logout');
    }
    
    /**
     * Find user by username or email
     */
    private function findUserByUsernameOrEmail($identifier)
    {
        // Try to find by username first
        $user = $this->userModel->getUserByUsername($identifier);
        
        // If not found and identifier looks like email, try email lookup
        if (!$user && filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = $this->userModel->getUserByEmail($identifier);
        }
        
        return $user;
    }

    /**
     * Simple dashboard
     */
    public function dashboard()
    {
        // Check if user is logged in
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/simple-login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        $data = [
            'title' => 'Dashboard - INLISLite v3'
        ];
        
        return view('admin/simple_dashboard', $data);
    }

}