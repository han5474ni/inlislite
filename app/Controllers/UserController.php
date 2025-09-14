<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class UserController extends BaseController
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
        // Basic server-side feed for DataTables-like UI (can be static for now)
        $builder = $this->db->table('users');
        $users = $builder->select('id, nama_lengkap, nama_pengguna, username, email, status, last_login')
                         ->get()->getResultArray();

        $data = [
            'title' => 'Manajemen Pengguna - INLISLite Admin',
            'page_title' => 'Manajemen Pengguna',
            'page_subtitle' => 'Kelola pengguna sistem INLISLite',
            'users' => $users,
        ];
        
        return view('admin/users_index', $data);
    }
}