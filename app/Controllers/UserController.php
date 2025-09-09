<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Display the main user management page
     */
    public function index()
    {
        $data = [
            'title' => 'User Management - INLISlite v3.0',
            'page_title' => 'User Management',
            'page_subtitle' => 'Kelola pengguna sistem dan hak aksesnya'
        ];

        return redirect()->to(base_url('admin/users'));
    }

    /**
     * Return JSON data for DataTables
     */
    public function json()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Access denied']);
        }

        // Get DataTables parameters
        $draw = $this->request->getPost('draw') ?? 1;
        $start = $this->request->getPost('start') ?? 0;
        $length = $this->request->getPost('length') ?? 10;
        $searchValue = $this->request->getPost('search')['value'] ?? '';
        
        // Get order parameters
        $orderColumnIndex = $this->request->getPost('order')[0]['column'] ?? 0;
        $orderDir = $this->request->getPost('order')[0]['dir'] ?? 'asc';
        
        // Map column index to database column
        $columns = ['id', 'nama_pengguna', 'email', 'role', 'status', 'created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'id';

        try {
            // Get data from model
            $result = $this->userModel->getUsersForDataTable($start, $length, $searchValue, $orderColumn, $orderDir);
            
            // Format data for DataTables
            $data = [];
            foreach ($result['data'] as $user) {
                $data[] = [
                    'id' => $user['id'],
                    'user_info' => [
                        'avatar_initials' => $user['avatar_initials'],
                        'nama_lengkap' => $user['nama_lengkap'] ?: $user['nama_pengguna'],
                        'nama_pengguna' => $user['nama_pengguna'],
                        'email' => $user['email']
                    ],
                    'role' => $user['role'],
                    'status' => $user['status'],
                    'last_login' => $user['last_login_formatted'],
                    'created_at' => $user['created_at_formatted'],
                    'actions' => $user['id'] // Will be formatted in JavaScript
                ];
            }

            return $this->response->setJSON([
                'draw' => intval($draw),
                'recordsTotal' => $result['recordsTotal'],
                'recordsFiltered' => $result['recordsFiltered'],
                'data' => $data
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error fetching users data: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Internal server error',
                'message' => 'Failed to fetch users data'
            ]);
        }
    }

    /**
     * Store a new user
     */
    public function store()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back()->with('error', 'Invalid request method');
        }

        // Get form data - handle both field naming conventions
        $data = [
            'nama_pengguna' => $this->request->getPost('nama_pengguna') ?: $this->request->getPost('username'),
            'username' => $this->request->getPost('username') ?: $this->request->getPost('nama_pengguna'),
            'email' => $this->request->getPost('email'),
            'kata_sandi' => $this->request->getPost('kata_sandi') ?: $this->request->getPost('password'),
            'password' => $this->request->getPost('password') ?: $this->request->getPost('kata_sandi'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap')
        ];

        // Validate data
        if (!$this->userModel->validate($data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $this->userModel->errors()
            ]);
        }

        try {
            // Create user
            $userId = $this->userModel->createUser($data);
            
            if ($userId) {
                // Get the created user data
                $newUser = $this->userModel->find($userId);
                
                // Remove password from response
                unset($newUser['kata_sandi'], $newUser['password']);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User berhasil ditambahkan!',
                    'data' => $newUser
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan user'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error creating user: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get user data for editing
     */
    public function show($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Access denied']);
        }

        try {
            $user = $this->userModel->find($id);
            
            if (!$user) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ]);
            }

            // Remove password from response
            unset($user['kata_sandi'], $user['password']);

            return $this->response->setJSON([
                'success' => true,
                'data' => $user
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error fetching user: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ]);
        }
    }

    /**
     * Update user data
     */
    public function update($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back()->with('error', 'Invalid request method');
        }

        // Get form data - handle both field naming conventions
        $data = [
            'nama_pengguna' => $this->request->getPost('nama_pengguna') ?: $this->request->getPost('username'),
            'username' => $this->request->getPost('username') ?: $this->request->getPost('nama_pengguna'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap')
        ];

        // Only include password if provided - handle both field names
        $password = $this->request->getPost('kata_sandi') ?: $this->request->getPost('password');
        if (!empty($password)) {
            $data['kata_sandi'] = $password;
            $data['password'] = $password;
        }

        try {
            // Update validation rules for existing user
            $this->userModel->setValidationRule('nama_pengguna', 'required|min_length[3]|max_length[50]|is_unique[users.nama_pengguna,id,' . $id . ']');
            $this->userModel->setValidationRule('email', 'required|valid_email|is_unique[users.email,id,' . $id . ']');
            
            // Make password optional for updates
            if (empty($password)) {
                $this->userModel->setValidationRule('kata_sandi', 'permit_empty|min_length[6]');
            }

            // Validate data
            if (!$this->userModel->validate($data)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $this->userModel->errors()
                ]);
            }

            // Update user
            $result = $this->userModel->updateUser($id, $data);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User berhasil diperbarui!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui user'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error updating user: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete user
     */
    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Access denied']);
        }

        try {
            $user = $this->userModel->find($id);
            
            if (!$user) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ]);
            }

            // Prevent deletion of current user (if session exists)
            $currentUserId = session()->get('admin_user_id');
            if ($currentUserId && $currentUserId == $id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus user yang sedang login'
                ]);
            }

            $result = $this->userModel->delete($id);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User berhasil dihapus!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus user'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error deleting user: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }
}