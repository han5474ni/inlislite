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
        // Fetch users from database
        $builder = $this->db->table('users');
        $users = $builder->get()->getResultArray();

        // Pass users data to the view
        return view('user_management', compact('users'));
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
            'role'          => 'required|in_list[Super Admin,Admin,Pustakawan,Staff]',
            'status'        => 'required|in_list[Aktif,Non-Aktif,Ditangguhkan]',
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

            return redirect()->to('/usermanagement')->with('success', 'Pengguna berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Log the error for debugging (optional)
            // log_message('error', $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
        }
    }

    public function editUser($id = null)
    {
        $request = $this->request;

        if ($id === null) {
            return redirect()->to('/usermanagement')->with('error', 'ID pengguna tidak valid.');
        }

        // Validate input
        $rules = [
            'nama_lengkap'  => 'required|min_length[3]|max_length[255]',
            'nama_pengguna' => "required|min_length[3]|max_length[50]|is_unique[users.nama_pengguna,id,{$id}]",
            'email'         => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'          => 'required|in_list[Super Admin,Admin,Pustakawan,Staff]',
            'status'        => 'required|in_list[Aktif,Non-Aktif,Ditangguhkan]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get form data
        $namaLengkap  = $request->getPost('nama_lengkap');
        $namaPengguna = $request->getPost('nama_pengguna');
        $email        = $request->getPost('email');
        $role         = $request->getPost('role');
        $status       = $request->getPost('status');

        // Prepare data for update
        $data = [
            'nama_lengkap'  => $namaLengkap,
            'nama_pengguna' => $namaPengguna,
            'email'         => $email,
            'role'          => $role,
            'status'        => $status,
        ];

        // Update data in the database
        try {
            $builder = $this->db->table('users');
            $builder->where('id', $id);
            $builder->update($data);

            return redirect()->to('/usermanagement')->with('success', 'Pengguna berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage());
        }
    }

    public function deleteUser($id = null)
    {
        if ($id === null) {
            return redirect()->to('/usermanagement')->with('error', 'ID pengguna tidak valid.');
        }

        try {
            $builder = $this->db->table('users');
            $builder->where('id', $id);
            $builder->delete();

            return redirect()->to('/usermanagement')->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->to('/usermanagement')->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }

    public function getUser($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($id === null) {
                return $this->response->setJSON(['success' => false, 'message' => 'ID pengguna tidak valid.']);
            }

            try {
                $builder = $this->db->table('users');
                $user = $builder->where('id', $id)->get()->getRowArray();

                if (!$user) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Pengguna tidak ditemukan.']);
                }

                return $this->response->setJSON(['success' => true, 'data' => $user]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        return redirect()->to('/usermanagement');
    }

    public function addUserAjax()
    {
        if ($this->request->isAJAX()) {
            $rules = [
                'nama_lengkap'  => 'required|min_length[3]|max_length[255]',
                'nama_pengguna' => 'required|min_length[3]|max_length[50]|is_unique[users.nama_pengguna]',
                'email'         => 'required|valid_email|is_unique[users.email]',
                'kata_sandi'    => 'required|min_length[8]',
                'role'          => 'required|in_list[Super Admin,Admin,Pustakawan,Staff]',
                'status'        => 'required|in_list[Aktif,Non-Aktif,Ditangguhkan]',
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }

            $data = [
                'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
                'nama_pengguna' => $this->request->getPost('nama_pengguna'),
                'email'         => $this->request->getPost('email'),
                'kata_sandi'    => password_hash($this->request->getPost('kata_sandi'), PASSWORD_DEFAULT),
                'role'          => $this->request->getPost('role'),
                'status'        => $this->request->getPost('status'),
                'created_at'    => date('Y-m-d H:i:s'),
            ];

            try {
                $builder = $this->db->table('users');
                $builder->insert($data);
                $newId = $this->db->insertID();

                $newUser = $builder->where('id', $newId)->get()->getRowArray();
                return $this->response->setJSON(['success' => true, 'message' => 'Pengguna berhasil ditambahkan!', 'data' => $newUser]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menambahkan pengguna: ' . $e->getMessage()]);
            }
        }

        return redirect()->to('/usermanagement');
    }

    public function editUserAjax($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($id === null) {
                return $this->response->setJSON(['success' => false, 'message' => 'ID pengguna tidak valid.']);
            }

            $rules = [
                'nama_lengkap'  => 'required|min_length[3]|max_length[255]',
                'nama_pengguna' => "required|min_length[3]|max_length[50]|is_unique[users.nama_pengguna,id,{$id}]",
                'email'         => "required|valid_email|is_unique[users.email,id,{$id}]",
                'role'          => 'required|in_list[Super Admin,Admin,Pustakawan,Staff]',
                'status'        => 'required|in_list[Aktif,Non-Aktif,Ditangguhkan]',
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }

            $data = [
                'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
                'nama_pengguna' => $this->request->getPost('nama_pengguna'),
                'email'         => $this->request->getPost('email'),
                'role'          => $this->request->getPost('role'),
                'status'        => $this->request->getPost('status'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];

            try {
                $builder = $this->db->table('users');
                $builder->where('id', $id)->update($data);

                $updatedUser = $builder->where('id', $id)->get()->getRowArray();
                return $this->response->setJSON(['success' => true, 'message' => 'Pengguna berhasil diperbarui!', 'data' => $updatedUser]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui pengguna: ' . $e->getMessage()]);
            }
        }

        return redirect()->to('/usermanagement');
    }

    public function deleteUserAjax($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($id === null) {
                return $this->response->setJSON(['success' => false, 'message' => 'ID pengguna tidak valid.']);
            }

            try {
                $builder = $this->db->table('users');
                $builder->where('id', $id)->delete();

                return $this->response->setJSON(['success' => true, 'message' => 'Pengguna berhasil dihapus!']);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus pengguna: ' . $e->getMessage()]);
            }
        }

        return redirect()->to('/usermanagement');
    }

    public function getUsersAjax()
    {
        if ($this->request->isAJAX()) {
            try {
                $builder = $this->db->table('users');
                $users = $builder->get()->getResultArray();

                return $this->response->setJSON(['success' => true, 'data' => $users]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        return redirect()->to('/usermanagement');
    }
}
