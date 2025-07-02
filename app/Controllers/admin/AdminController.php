<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
        // Add authentication check here when implemented
    }
    
    public function index()
    {
        $data = [
            'title' => 'Admin Dashboard - INLISLite v3',
            'page_title' => 'Admin Dashboard',
            'page_subtitle' => 'Kelola sistem perpustakaan Anda'
        ];
        
        return view('admin/dashboard', $data);
    }
    
    public function modernDashboard()
    {
        $data = [
            'title' => 'INLISLite v3.0 Dashboard - Sistem Perpustakaan Modern',
            'page_title' => 'Selamat Datang di InlisLite!',
            'page_subtitle' => 'Kelola sistem perpustakaan Anda dengan alat dan analitik yang lengkap.'
        ];
        
        return view('admin/modern_dashboard', $data);
    }
    
    public function login()
    {
        $data = [
            'title' => 'Admin Login - INLISLite v3'
        ];
        
        return view('admin/login', $data);
    }
    
    public function logout()
    {
        // Implement logout logic
        $this->session->destroy();
        return redirect()->to('/admin/login');
    }
    
    public function tentang()
    {
        $data = [
            'title' => 'About INLISLite Version 3 - INLISlite v3.0',
            'page_title' => 'About INLISLite Version 3',
            'page_subtitle' => 'Detailed information about the library automation system'
        ];
        
        return view('admin/tentang', $data);
    }
}