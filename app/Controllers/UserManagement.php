<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class UserManagement extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Load the form view
        return view('user_management_form');
    }

    public function addUser()
    {
        $request = $this->request;

        // Validate input
        $rules = [
            'nama_lengkap'  => 'required|min_length[3]|max_length[255]',
            'nama_pengguna' => 'required|min_length[3]|max_length[50]|is_unique[users.nama_pengguna]',
            'email'         => 'required|valid_email|is_unique[users.email]',
            'kata_sandi'    => 'required|min_length[8]',
            'role'          => 'required|in_list[Admin,Pustakawan]',
            'status'        => 'required|in_list[Aktif,Non-Aktif]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get form data
        $namaLengkap  = $request->getPost('nama_lengkap');
        $namaPengguna = $request->getPost('nama_pengguna');
        $email        = $request->getPost('email');
        $kataSandi    = $request->getPost('kata_sandi');
        $role         = $request->getPost('role');
        $status       = $request->getPost('status');

        // Hash the password
        $hashedPassword = password_hash($kataSandi, PASSWORD_DEFAULT);

        // Prepare data for insertion
        $data = [
            'nama_lengkap'  => $namaLengkap,
            'nama_pengguna' => $namaPengguna,
            'email'         => $email,
            'kata_sandi'    => $hashedPassword,
            'role'          => $role,
            'status'        => $status,
        ];

        // Insert data into the database
        try {
            $builder = $this->db->table('users');
            $builder->insert($data);

            return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Log the error for debugging (optional)
            // log_message('error', $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
        }
    }
}
