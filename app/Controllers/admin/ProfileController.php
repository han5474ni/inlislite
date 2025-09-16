<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

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
        // Get logged-in user ID from session set by AuthController
        $userId = $this->session->get('admin_user_id');

        $user = null;
        if ($userId) {
            $userModel = new UserModel();
            $user = $userModel->find($userId);
            if ($user) {
                // Normalize/augment data for the view (avatar url, initials, compatibility keys)
                $user = $userModel->processUserData($user);
            }
        }

        $data = [
            'title' => 'Profil - INLISLite Admin',
            'page_title' => 'Profil Pengguna',
            'page_subtitle' => 'Kelola profil dan pengaturan akun Anda',
            // Keep simple summary for header widgets if needed
            'currentUser' => [
                'name' => $this->session->get('admin_nama_lengkap') ?? ($user['nama_lengkap'] ?? 'Administrator'),
                'role' => $this->session->get('admin_role') ?? ($user['role'] ?? 'Admin'),
                'email' => $this->session->get('admin_email') ?? ($user['email'] ?? 'admin@inlislite.com')
            ],
            // Pass full user data expected by the view
            'user' => $user ?? [
                'nama_lengkap' => $this->session->get('admin_nama_lengkap') ?? 'Administrator',
                'nama_pengguna' => $this->session->get('admin_username') ?? 'admin',
                'email' => $this->session->get('admin_email') ?? 'admin@inlislite.com',
                'role' => $this->session->get('admin_role') ?? 'Admin',
                'avatar_initials' => 'A',
            ],
        ];
        
        return view('admin/profile', $data);
    }
}