<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    protected $session;
    protected $db;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Profil - INLISLite Admin',
            'page_title' => 'Profil Pengguna',
            'page_subtitle' => 'Kelola profil dan pengaturan akun Anda',
            'currentUser' => [
                'name' => $this->session->get('admin_nama_lengkap') ?? 'Administrator',
                'role' => $this->session->get('admin_role') ?? 'Super Admin',
                'email' => $this->session->get('admin_email') ?? 'admin@inlislite.com'
            ]
        ];
        
        return view('admin/profile/index', $data);
    }
}