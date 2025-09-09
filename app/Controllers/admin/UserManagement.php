<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserManagement extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper('auth');
    }

    public function index()
    {
        // Check if user has permission to view users
        if (!can_view_users()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Access denied. You need to be logged in to view users.');
        }
        // Fetch users from database with proper field mapping
        try {
            // Check which field names exist in the database
            $fields = $this->db->getFieldNames('users');
            $usernameField = in_array('nama_pengguna', $fields) ? 'nama_pengguna' : 'username';
            $passwordField = in_array('kata_sandi', $fields) ? 'kata_sandi' : 'password';
            
            $builder = $this->db->table('users');
            
            // Check if avatar column exists
            $hasAvatar = in_array('avatar', $fields);
            $avatarField = $hasAvatar ? 'avatar' : 'NULL as avatar';
            
            $users = $builder->select("
                id,
                nama_lengkap,
                {$usernameField} as nama_pengguna,
                email,
                status,
                {$avatarField},
                last_login,
                created_at
            ")->get()->getResultArray();
            
            // Format data for display
            foreach ($users as &$user) {
                $user['created_at_formatted'] = isset($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : 'N/A';
                $user['last_login_formatted'] = isset($user['last_login']) && $user['last_login'] ? date('d M Y H:i', strtotime($user['last_login'])) : 'Belum pernah';
                $user['avatar_initials'] = $this->getInitials($user['nama_lengkap'] ?? $user['nama_pengguna'] ?? 'U');
                
                // Add avatar URL
                if (!empty($user['avatar'])) {
                    $user['avatar_url'] = base_url('images/profile/' . $user['avatar']);
                } else {
                    $user['avatar_url'] = null;
                }
            }
        } catch (\Exception $e) {
            // If table doesn't exist, use empty array
            $users = [];
            log_message('error', 'Error fetching users: ' . $e->getMessage());
        }

        $data = [
            'title' => 'User Manajemen - INLISLite v3.0',
            'users' => $users,
            'can_edit_users' => can_edit_users(), // Pass edit permission to view
            'is_edit_mode' => false
        ];

        // Render the users index (simplified columns)
        return view('admin/user_management', $data);
    }

    /**
     * User edit page with full management capabilities
     */
    public function userEdit()
    {
        // Check if user has permission to edit users (Super Admin only)
        if (!can_edit_users()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Access denied. Only Super Admin can access user management.');
        }
        
        // Fetch users from database with proper field mapping
        try {
            // Check which field names exist in the database
            $fields = $this->db->getFieldNames('users');
            $usernameField = in_array('nama_pengguna', $fields) ? 'nama_pengguna' : 'username';
            $passwordField = in_array('kata_sandi', $fields) ? 'kata_sandi' : 'password';
            
            $builder = $this->db->table('users');
            
            // Check if avatar column exists
            $hasAvatar = in_array('avatar', $fields);
            $avatarField = $hasAvatar ? 'avatar' : 'NULL as avatar';
            
            $users = $builder->select("
                id,
                nama_lengkap,
                {$usernameField} as nama_pengguna,
                email,
                role,
                status,
                {$avatarField},
                last_login,
                created_at
            ")->get()->getResultArray();
            
            // Format data for display
            foreach ($users as &$user) {
                $user['created_at_formatted'] = isset($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : 'N/A';
                $user['last_login_formatted'] = isset($user['last_login']) && $user['last_login'] ? date('d M Y H:i', strtotime($user['last_login'])) : 'Belum pernah';
                $user['avatar_initials'] = $this->getInitials($user['nama_lengkap'] ?? $user['nama_pengguna'] ?? 'U');
                
                // Add avatar URL
                if (!empty($user['avatar'])) {
                    $user['avatar_url'] = base_url('images/profile/' . $user['avatar']);
                } else {
                    $user['avatar_url'] = null;
                }
            }
        } catch (\Exception $e) {
            // If table doesn't exist, use empty array
            $users = [];
            log_message('error', 'Error fetching users: ' . $e->getMessage());
        }

        $data = [
            'title' => 'User Management - INLISLite v3.0',
            'users' => $users,
            'can_edit_users' => can_edit_users(), // Pass edit permission to view
            'is_edit_mode' => true
        ];

        // Use unified view after consolidation
        return view('admin/user_management', $data);
    }

    public function addForm()
    {
        // Only Super Admin can create users
        if (!can_edit_users()) {
            return redirect()->to(base_url('admin/users'))
                ->with('error', 'Access denied. Only Super Admin can add users.');
        }

        $data = [
            'title' => 'Tambah Pengguna - INLISLite v3.0',
            'is_add_mode' => true,
        ];

        return view('admin/user_add', $data);
    }

    public function store()
    {
        $request = $this->request;

        // Validate input according to your specifications
        $rules = [
            'nama_lengkap'  => 'required|min_length[3]|max_length[255]',
            'nama_pengguna' => 'required|min_length[3]|max_length[50]|is_unique[users.nama_pengguna]',
            'email'         => 'required|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[6]',
            'status'        => 'required|in_list[Aktif,Non-Aktif]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get form data
        $namaLengkap = $request->getPost('nama_lengkap');
        $namaPengguna = $request->getPost('nama_pengguna');
        $email       = $request->getPost('email');
        $password    = $request->getPost('password');
        $status      = $request->getPost('status');
        $features    = $request->getPost('features');

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare data for insertion using Indonesian field names
        $data = [
            'nama_lengkap'  => $namaLengkap,
            'nama_pengguna' => $namaPengguna,
            'email'         => $email,
            'kata_sandi'    => $hashedPassword,
            'status'        => $status,
            'role'          => 'Staff', // Default role for new users
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        // Insert data into the database
        try {
            $builder = $this->db->table('users');
            $builder->insert($data);

            $userId = $this->db->insertID();

            // Sync user feature access based on role
            if (function_exists('sync_user_feature_access')) {
                sync_user_feature_access($userId, 'Staff');
            }

            // Insert additional feature access if specified
            if ($features) {
                $featureData = [];
                foreach ($features as $feature) {
                    $featureData[] = [
                        'user_id' => $userId,
                        'feature' => $feature,
                    ];
                }
                $this->db->table('user_feature_access')->insertBatch($featureData);
            }

            return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Log the error for debugging
            log_message('error', 'Error adding user: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
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
            'status'        => 'required|in_list[Aktif,Non-aktif]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get form data
        $namaLengkap  = $request->getPost('nama_lengkap');
        $namaPengguna = $request->getPost('nama_pengguna');
        $email        = $request->getPost('email');
        $kataSandi    = $request->getPost('kata_sandi');
        $status       = $request->getPost('status');

        // Hash the password
        $hashedPassword = password_hash($kataSandi, PASSWORD_DEFAULT);

        // Prepare data for insertion
        $data = [
            'nama_lengkap'  => $namaLengkap,
            'nama_pengguna' => $namaPengguna,
            'email'         => $email,
            'password'      => $hashedPassword,
            'status'        => $status,
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        // Insert data into the database
        try {
            $builder = $this->db->table('users');
            $builder->insert($data);

            return redirect()->to('/admin/users')->with('success', 'Pengguna berhasil ditambahkan!');
        } catch (\Exception $e) {
            log_message('error', 'Error adding user: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
        }
    }

    public function editUser($id = null)
    {
        $request = $this->request;

        if ($id === null) {
            return redirect()->to('/admin/users')->with('error', 'ID pengguna tidak valid.');
        }

        // Validate input
        $rules = [
            'nama_lengkap'  => 'required|min_length[3]|max_length[255]',
            'nama_pengguna' => "required|min_length[3]|max_length[50]|is_unique[users.nama_pengguna,id,{$id}]",
            'email'         => "required|valid_email|is_unique[users.email,id,{$id}]",
            'status'        => 'required|in_list[Aktif,Non-aktif]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get form data
        $namaLengkap  = $request->getPost('nama_lengkap');
        $namaPengguna = $request->getPost('nama_pengguna');
        $email        = $request->getPost('email');
        $status       = $request->getPost('status');
        $features     = $request->getPost('features');

        // Prepare data for update
        $data = [
            'nama_lengkap'  => $namaLengkap,
            'nama_pengguna' => $namaPengguna,
            'email'         => $email,
            'status'        => $status,
        ];

        // Update password if provided
        $kataSandi = $request->getPost('kata_sandi');
        if (!empty($kataSandi)) {
            $data['password'] = password_hash($kataSandi, PASSWORD_DEFAULT);
        }

        // Update data in the database
        try {
            $builder = $this->db->table('users');
            $builder->where('id', $id);
            $builder->update($data);

            // Update feature access
            $featureTable = $this->db->table('user_feature_access');
            $featureTable->where('user_id', $id)->delete(); // Remove old access
            if ($features) {
                $featureData = [];
                foreach ($features as $feature) {
                    $featureData[] = [
                        'user_id' => $id,
                        'feature' => $feature,
                    ];
                }
                $featureTable->insertBatch($featureData);
            }

            return redirect()->to('/admin/users')->with('success', 'Pengguna berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage());
        }
    }

    public function deleteUser($id = null)
    {
        if ($id === null) {
            return redirect()->to('/admin/users')->with('error', 'ID pengguna tidak valid.');
        }

        try {
            $builder = $this->db->table('users');
            $builder->where('id', $id);
            $builder->delete();

            return redirect()->to('/admin/users')->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->to('/admin/users')->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
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

                // Map fields for compatibility
                $user['nama_pengguna'] = $user['username'] ?? $user['nama_pengguna'] ?? '';

                return $this->response->setJSON(['success' => true, 'data' => $user]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        return redirect()->to('/admin/users');
    }

    public function addUserAjax()
    {
        // Debug logging
        log_message('info', 'UserManagement::addUserAjax called');
        
        // Check if user has permission to add users
        if (!can_edit_users()) {
            log_message('warning', 'Access denied for user in addUserAjax');
            return $this->response->setJSON(['success' => false, 'message' => 'Access denied. Only Super Admin can manage users.']);
        }
        
        if ($this->request->isAJAX()) {
            // Get JSON input
            $input = $this->request->getJSON(true);
            log_message('info', 'Input data received: ' . json_encode($input));
            
            // Check which field names exist in the database
            $fields = $this->db->getFieldNames('users');
            $usernameField = in_array('nama_pengguna', $fields) ? 'nama_pengguna' : 'username';
            $passwordField = in_array('kata_sandi', $fields) ? 'kata_sandi' : 'password';
            
            // Validation rules
            $rules = [
                'nama_lengkap'  => 'required|min_length[3]|max_length[255]',
                'nama_pengguna' => "required|min_length[3]|max_length[50]|is_unique[users.{$usernameField}]",
                'email'         => 'required|valid_email|is_unique[users.email]',
                'password'      => 'required|min_length[6]',
                'role'          => 'required|in_list[Super Admin,Admin]',
                'status'        => 'required|in_list[Aktif,Non-Aktif]',
            ];

            if (!$this->validate($rules, $input)) {
                log_message('error', 'Validation failed: ' . json_encode($this->validator->getErrors()));
                return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }

            $data = [
                'nama_lengkap'  => $input['nama_lengkap'],
                $usernameField  => $input['nama_pengguna'],
                'email'         => $input['email'],
                $passwordField  => password_hash($input['password'], PASSWORD_DEFAULT),
                'role'          => $input['role'],
                'status'        => $input['status'],
                'created_at'    => date('Y-m-d H:i:s'),
                'last_login'    => null,
            ];

            try {
                $builder = $this->db->table('users');
                $result = $builder->insert($data);
                
                if ($result) {
                    $newId = $this->db->insertID();
                    
                    // Sync user feature access based on role
                    helper('feature_access');
                    sync_user_feature_access($newId, $input['role']);
                    
                    $newUser = $builder->where('id', $newId)->get()->getRowArray();
                    
                    // Format for frontend - normalize field names
                    $newUser['nama_pengguna'] = $newUser[$usernameField];
                    $newUser['created_at_formatted'] = date('d M Y', strtotime($newUser['created_at']));
                    $newUser['last_login_formatted'] = 'Belum pernah';
                    $newUser['avatar_initials'] = $this->getInitials($newUser['nama_lengkap']);
                    
                    // Add avatar URL if available
                    if (isset($newUser['avatar']) && !empty($newUser['avatar'])) {
                        $newUser['avatar_url'] = base_url('images/profile/' . $newUser['avatar']);
                    } else {
                        $newUser['avatar_url'] = null;
                    }
                    
                    log_message('info', 'User added successfully: ' . $newUser[$usernameField]);
                    return $this->response->setJSON(['success' => true, 'message' => 'Pengguna berhasil ditambahkan!', 'data' => $newUser]);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Gagal menyimpan data ke database']);
                }
            } catch (\Exception $e) {
                log_message('error', 'Error adding user: ' . $e->getMessage());
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menambahkan pengguna: ' . $e->getMessage()]);
            }
        }

        log_message('warning', 'addUserAjax: Not an AJAX request');
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid request - not AJAX']);
    }

    public function editUserAjax($id = null)
    {

        
        // Check if user has permission to edit users
        if (!can_edit_users()) {

            return $this->response->setJSON(['success' => false, 'message' => 'Access denied. Only Super Admin can manage users.']);
        }
        
        if ($this->request->isAJAX()) {
            if ($id === null) {
                return $this->response->setJSON(['success' => false, 'message' => 'ID pengguna tidak valid.']);
            }

            // Get JSON input
            $input = $this->request->getJSON(true);

            
            // Check which field names exist in the database
            $fields = $this->db->getFieldNames('users');
            $usernameField = in_array('nama_pengguna', $fields) ? 'nama_pengguna' : 'username';
            $passwordField = in_array('kata_sandi', $fields) ? 'kata_sandi' : 'password';

            // Get existing user data
            $builder = $this->db->table('users');
            $existingUser = $builder->where('id', $id)->get()->getRowArray();
            
            if (!$existingUser) {
                return $this->response->setJSON(['success' => false, 'message' => 'Pengguna tidak ditemukan.']);
            }

            // Admin can't edit email, so we'll use the existing email
            $input['email'] = $existingUser['email'];

            $rules = [
                'nama_lengkap'  => 'required|min_length[3]|max_length[255]',
                'nama_pengguna' => "required|min_length[3]|max_length[50]|is_unique[users.{$usernameField},id,{$id}]",
                'status'        => 'required|in_list[Aktif,Non-Aktif]',
            ];

            if (!$this->validate($rules, $input)) {
                return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }

            $data = [
                'nama_lengkap'  => $input['nama_lengkap'],
                $usernameField  => $input['nama_pengguna'],
                'status'        => $input['status'],
            ];

            // Update password if provided
            if (!empty($input['password'])) {
                $data[$passwordField] = password_hash($input['password'], PASSWORD_DEFAULT);
            }

            try {
                $builder = $this->db->table('users');
                $result = $builder->where('id', $id)->update($data);

                if ($result !== false) {
                    $updatedUser = $builder->where('id', $id)->get()->getRowArray();
                    
                    // Format for frontend - normalize field names
                    $updatedUser['nama_pengguna'] = $updatedUser[$usernameField];
                    $updatedUser['created_at_formatted'] = date('d M Y', strtotime($updatedUser['created_at']));
                    $updatedUser['last_login_formatted'] = isset($updatedUser['last_login']) && $updatedUser['last_login'] ? date('d M Y H:i', strtotime($updatedUser['last_login'])) : 'Belum pernah';
                    $updatedUser['avatar_initials'] = $this->getInitials($updatedUser['nama_lengkap']);
                    
                    log_message('info', 'User updated successfully: ' . $updatedUser[$usernameField]);
                    return $this->response->setJSON(['success' => true, 'message' => 'Pengguna berhasil diperbarui!', 'data' => $updatedUser]);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui data di database']);
                }
            } catch (\Exception $e) {
                log_message('error', 'Error updating user: ' . $e->getMessage());
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui pengguna: ' . $e->getMessage()]);
            }
        }

        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid request']);
    }

    public function deleteUserAjax($id = null)
    {
        // Check if user has permission to delete users
        if (!can_edit_users()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Access denied. Only Super Admin can manage users.']);
        }
        
        if ($this->request->isAJAX()) {
            if ($id === null) {
                return $this->response->setJSON(['success' => false, 'message' => 'ID pengguna tidak valid.']);
            }

            try {
                $builder = $this->db->table('users');
                
                // Check if user exists first
                $user = $builder->where('id', $id)->get()->getRowArray();
                if (!$user) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Pengguna tidak ditemukan.']);
                }

                $result = $builder->where('id', $id)->delete();

                if ($result) {
                    log_message('info', 'User deleted successfully: ' . ($user['username'] ?? 'ID ' . $id));
                    return $this->response->setJSON(['success' => true, 'message' => 'Pengguna berhasil dihapus!']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data dari database']);
                }
            } catch (\Exception $e) {
                log_message('error', 'Error deleting user: ' . $e->getMessage());
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus pengguna: ' . $e->getMessage()]);
            }
        }

        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid request']);
    }

    /**
     * Get user features by user ID (AJAX)
     */
    public function getUserFeatures($id)
    {
        if (!can_edit_users()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Access denied.']);
        }

        if ($this->request->isAJAX()) {
            try {
                $features = [];
                try {
                    $rows = $this->db->table('user_feature_access')->where('user_id', $id)->get()->getResultArray();
                    $features = array_column($rows, 'feature');
                } catch (\Throwable $t) {
                    // Table may not exist yet
                    log_message('warning', 'getUserFeatures: ' . $t->getMessage());
                }

                return $this->response->setJSON([
                    'success' => true,
                    'data' => [
                        'features' => $features
                    ]
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid request']);
    }

    /**
     * Update user features (AJAX)
     */
    public function updateUserFeatures($id)
    {
        if (!can_edit_users()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Access denied.']);
        }

        if ($this->request->isAJAX()) {
            $input = $this->request->getJSON(true);
            $features = $input['features'] ?? [];

            try {
                // Ensure table exists
                try {
                    $this->db->table('user_feature_access')->get(1);
                } catch (\Throwable $t) {
                    log_message('error', 'user_feature_access table missing: ' . $t->getMessage());
                    return $this->response->setJSON(['success' => false, 'message' => 'Tabel akses fitur belum tersedia. Jalankan migrasi.']);
                }

                $tbl = $this->db->table('user_feature_access');
                $this->db->transStart();
                $tbl->where('user_id', $id)->delete();

                if (!empty($features)) {
                    $batch = [];
                    foreach ($features as $f) {
                        $batch[] = [ 'user_id' => $id, 'feature' => $f ];
                    }
                    $tbl->insertBatch($batch);
                }
                $this->db->transComplete();

                return $this->response->setJSON(['success' => true, 'message' => 'Hak akses berhasil diperbarui']);
            } catch (\Exception $e) {
                $this->db->transRollback();
                return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid request']);
    }

    public function getUsersAjax()
    {
        if ($this->request->isAJAX()) {
            try {
                // Check which field names exist in the database
                $fields = $this->db->getFieldNames('users');
                $usernameField = in_array('nama_pengguna', $fields) ? 'nama_pengguna' : 'username';
                
                $builder = $this->db->table('users');
                
                // Check if avatar column exists
                $hasAvatar = in_array('avatar', $fields);
                $avatarField = $hasAvatar ? 'avatar' : 'NULL as avatar';
                
                $users = $builder->select("
                    id,
                    nama_lengkap,
                    {$usernameField} as nama_pengguna,
                    email,
                    role,
                    status,
                    {$avatarField},
                    last_login,
                    created_at
                ")->get()->getResultArray();

                // Format data for display
                foreach ($users as &$user) {
                    $user['created_at_formatted'] = isset($user['created_at']) ? date('d M Y H:i', strtotime($user['created_at'])) : 'N/A';
                    $user['last_login_formatted'] = isset($user['last_login']) && $user['last_login'] ? date('d M Y H:i', strtotime($user['last_login'])) : 'Belum pernah';
                    $user['avatar_initials'] = $this->getInitials($user['nama_lengkap'] ?? $user['nama_pengguna'] ?? 'U');
                    
                    // Add avatar URL
                    if (!empty($user['avatar'])) {
                        $user['avatar_url'] = base_url('images/profile/' . $user['avatar']);
                    } else {
                        $user['avatar_url'] = null;
                    }
                }

                return $this->response->setJSON(['success' => true, 'data' => $users]);
            } catch (\Exception $e) {
                log_message('error', 'Error fetching users: ' . $e->getMessage());
                return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        return redirect()->to('/admin/users');
    }

    /**
     * AJAX endpoint for loading users list (alias for getUsersAjax)
     */
    public function list()
    {
        return $this->getUsersAjax();
    }

    /**
     * Force reload users data with proper database synchronization
     */
    public function reloadUsers()
    {
        try {
            $builder = $this->db->table('users');
            $users = $builder->select('
                id,
                nama_lengkap,
                nama_pengguna,
                email,
                role,
                status,
                last_login,
                created_at
            ')->get()->getResultArray();
            
            // Format data for display
            foreach ($users as &$user) {
                // Handle field mapping for compatibility
                if (!isset($user['nama_lengkap']) && isset($user['username'])) {
                    $user['nama_lengkap'] = $user['username'];
                }
                if (!isset($user['nama_pengguna']) && isset($user['username'])) {
                    $user['nama_pengguna'] = $user['username'];
                }
                
                $user['created_at_formatted'] = isset($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : 'N/A';
                $user['last_login_formatted'] = isset($user['last_login']) && $user['last_login'] ? date('d M Y H:i', strtotime($user['last_login'])) : 'Belum pernah';
                $user['avatar_initials'] = $this->getInitials($user['nama_lengkap'] ?? $user['nama_pengguna'] ?? 'U');
            }

            return $this->response->setJSON([
                'success' => true, 
                'data' => $users,
                'count' => count($users),
                'message' => 'Data berhasil dimuat'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error reloading users: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Error: ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }

    /**
     * Get user statistics for chart
     */
    public function getUserStatistics()
    {
        if ($this->request->isAJAX()) {
            try {
                $builder = $this->db->table('users');
                $users = $builder->select('role, created_at')->get()->getResultArray();
                
                $currentYear = date('Y');
                $years = [];
                $statistics = [
                    'Super Admin' => [],
                    'Admin' => [],
                    'Pustakawan' => [],
                    'Staff' => []
                ];
                
                // Generate years (current year and 4 previous years)
                for ($i = 4; $i >= 0; $i--) {
                    $year = $currentYear - $i;
                    $years[] = $year;
                    
                    // Initialize counts for each role
                    foreach ($statistics as $role => &$data) {
                        $data[] = 0;
                    }
                }
                
                // Process users data
                foreach ($users as $user) {
                    if (!empty($user['created_at'])) {
                        $userYear = date('Y', strtotime($user['created_at']));
                        $yearIndex = array_search($userYear, $years);
                        
                        if ($yearIndex !== false && isset($statistics[$user['role']])) {
                            $statistics[$user['role']][$yearIndex]++;
                        }
                    }
                }
                
                return $this->response->setJSON([
                    'success' => true,
                    'data' => [
                        'years' => $years,
                        'superAdmin' => $statistics['Super Admin'],
                        'admin' => $statistics['Admin'],
                        'pustakawan' => $statistics['Pustakawan'],
                        'staff' => $statistics['Staff']
                    ]
                ]);
                
            } catch (\Exception $e) {
                log_message('error', 'Error fetching user statistics: ' . $e->getMessage());
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }
        
        return redirect()->to('/admin/users');
    }

    /**
     * Get user initials for avatar
     */
    private function getInitials($name)
    {
        if (empty($name)) return 'U';
        
        $words = explode(' ', trim($name));
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
                if (strlen($initials) >= 2) break;
            }
        }
        
        return $initials ?: 'U';
    }

    /**
     * AJAX endpoint to get users list
     */
    public function getUsersList()
    {
        // Check if user has permission to view users
        if (!can_view_users()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Access denied. You need to be logged in to view users.'
            ]);
        }

        try {
            // Fetch users from database with proper field mapping
            $fields = $this->db->getFieldNames('users');
            $usernameField = in_array('nama_pengguna', $fields) ? 'nama_pengguna' : 'username';
            
            $builder = $this->db->table('users');
            
            // Check if avatar column exists
            $hasAvatar = in_array('avatar', $fields);
            $avatarField = $hasAvatar ? 'avatar' : 'NULL as avatar';
            
            $users = $builder->select("
                id,
                nama_lengkap,
                {$usernameField} as nama_pengguna,
                email,
                role,
                status,
                {$avatarField},
                last_login,
                created_at
            ")->get()->getResultArray();
            
            // Format data for display
            foreach ($users as &$user) {
                $user['created_at_formatted'] = isset($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : 'N/A';
                $user['last_login_formatted'] = isset($user['last_login']) && $user['last_login'] ? date('d M Y H:i', strtotime($user['last_login'])) : 'Belum pernah';
                $user['avatar_initials'] = $this->getInitials($user['nama_lengkap'] ?? $user['nama_pengguna'] ?? 'U');
                
                // Add avatar URL
                if (!empty($user['avatar'])) {
                    $user['avatar_url'] = base_url('images/profile/' . $user['avatar']);
                } else {
                    $user['avatar_url'] = null;
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $users,
                'can_edit_users' => can_edit_users()
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error fetching users for AJAX: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error fetching users: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * User history page - shows all users activity logs
     */
    public function history($id = null)
    {
        // Check if user has permission to view users (only Super Admin)
        if (!can_edit_users()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Access denied. Only Super Admin can view activity logs.');
        }
        
        try {
            $activityModel = new \App\Models\ActivityLogModel();
            $request = $this->request;
            
            // Get filters from request
            $filters = [
                'date_from' => $request->getGet('date_from'),
                'date_to' => $request->getGet('date_to'),
                'activity_type' => $request->getGet('activity_type'),
                'user_id' => $request->getGet('user_id'),
                'search' => $request->getGet('search')
            ];
            
            // Pagination
            $perPage = 15;
            $page = $request->getGet('page') ?? 1;
            
            // Get logs with filters and pagination
            $logs = $activityModel->getLogs($filters, $perPage, $page);
            $totalLogs = $activityModel->getLogsCount($filters);
            
            // Get unique activity types for filter dropdown
            $activityTypes = $activityModel->getActivityTypes();
            
            // Get active users for filter dropdown
            $userBuilder = $this->db->table('users');
            $users = $userBuilder->select('id, nama_lengkap, email')
                                ->where('status', 'Aktif')
                                ->orderBy('nama_lengkap', 'ASC')
                                ->get()
                                ->getResultArray();
            
            // Calculate pagination
            $totalPages = ceil($totalLogs / $perPage);
            
            $data = [
                'title' => 'Activity History - INLISLite v3.0',
                'logs' => $logs,
                'filters' => $filters,
                'activityTypes' => $activityTypes,
                'users' => $users,
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total_pages' => $totalPages,
                    'total_records' => $totalLogs
                ]
            ];
            
            // Render history inline page inside unified management view if desired; keeping dedicated page for now
            return view('admin/user_management', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Error fetching activity history: ' . $e->getMessage());
            return redirect()->to(base_url('admin/users/edit'))->with('error', 'Error fetching activity history.');
        }
    }
    
    /**
     * Individual user history page
     */
    public function userHistory($id)
    {
        // Check if user has permission to view users
        if (!can_view_users()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Access denied. You need to be logged in to view users.');
        }
        
        try {
            // Get user information
            $builder = $this->db->table('users');
            $user = $builder->where('id', $id)->get()->getRowArray();
            
            if (!$user) {
                return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
            }
            
            // Get user activity logs
            $activityModel = new \App\Models\ActivityLogModel();
            $activities = $activityModel->getFormattedUserActivities($id, 100);
            
            $data = [
                'title' => 'User Activity History - ' . ($user['nama_lengkap'] ?? $user['nama_pengguna'] ?? 'Unknown'),
                'user' => $user,
                'activities' => $activities
            ];
            
            return view('admin/user_history', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Error fetching user history: ' . $e->getMessage());
            return redirect()->to(base_url('admin/users'))->with('error', 'Error fetching user history.');
        }
    }
    
    /**
     * Create user page
     */
    public function create()
    {
        // Check if user has permission to create users
        if (!can_edit_users()) {
            return redirect()->to(base_url('admin/users/edit'))->with('error', 'Access denied. Only Super Admin can create users.');
        }
        
        $data = [
            'title' => 'Create New User - INLISLite v3.0'
        ];
        
        return view('admin/user_management', $data);
    }
    
    /**
     * Edit user page
     */
    public function edit($id)
    {
        // Check if user has permission to edit users
        if (!can_edit_users()) {
            return redirect()->to(base_url('admin/users/edit'))->with('error', 'Access denied. Only Super Admin can edit users.');
        }
        
        try {
            // Get user information
            $builder = $this->db->table('users');
            $user = $builder->where('id', $id)->get()->getRowArray();
            
            if (!$user) {
                return redirect()->to(base_url('admin/users/edit'))->with('error', 'User not found.');
            }
            
            $data = [
                'title' => 'Edit User - ' . ($user['nama_lengkap'] ?? $user['nama_pengguna'] ?? 'Unknown'),
                'user' => $user
            ];
            
            return view('admin/user_edit', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Error fetching user for edit: ' . $e->getMessage());
            return redirect()->to(base_url('admin/users/edit'))->with('error', 'Error fetching user data.');
        }
    }
    
    /**
     * Update user method
     */
    public function update($id)
    {
        // Check if user has permission to update users
        if (!can_edit_users()) {
            return redirect()->to(base_url('admin/users/edit'))->with('error', 'Access denied. Only Super Admin can update users.');
        }
        
        $request = $this->request;
        
        // Validate input
        $rules = [
            'nama_lengkap'  => 'required|min_length[3]|max_length[255]',
            'nama_pengguna' => "required|min_length[3]|max_length[50]|is_unique[users.nama_pengguna,id,{$id}]",
            'email'         => "required|valid_email|is_unique[users.email,id,{$id}]",
            'status'        => 'required|in_list[Aktif,Non-Aktif]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Get form data
        $namaLengkap  = $request->getPost('nama_lengkap');
        $namaPengguna = $request->getPost('nama_pengguna');
        $email        = $request->getPost('email');
        $status       = $request->getPost('status');
        
        // Prepare data for update
        $data = [
            'nama_lengkap'  => $namaLengkap,
            'nama_pengguna' => $namaPengguna,
            'email'         => $email,
            'status'        => $status,
        ];
        
        // Update password if provided
        $password = $request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        // Update data in the database
        try {
            $builder = $this->db->table('users');
            $builder->where('id', $id);
            $builder->update($data);
            
            // Log the activity
            $activityModel = new \App\Models\ActivityLogModel();
            $activityModel->logActivity(
                session('user_id'),
                'user_update',
                'Updated user: ' . $namaPengguna,
                null,
                $data
            );
            
            return redirect()->to(base_url('admin/users/edit'))->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            log_message('error', 'Error updating user: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete user method
     */
    public function delete($id)
    {
        // Check if user has permission to delete users
        if (!can_edit_users()) {
            return redirect()->to(base_url('admin/users/edit'))->with('error', 'Access denied. Only Super Admin can delete users.');
        }
        
        try {
            $builder = $this->db->table('users');
            
            // Get user info for logging
            $user = $builder->where('id', $id)->get()->getRowArray();
            if (!$user) {
                return redirect()->to(base_url('admin/users/edit'))->with('error', 'User not found.');
            }
            
            // Delete user
            $builder->where('id', $id)->delete();
            
            // Log the activity
            $activityModel = new \App\Models\ActivityLogModel();
            $activityModel->logActivity(
                session('user_id'),
                'user_delete',
                'Deleted user: ' . ($user['nama_pengguna'] ?? $user['username']),
                $user,
                null
            );
            
            return redirect()->to(base_url('admin/users/edit'))->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            log_message('error', 'Error deleting user: ' . $e->getMessage());
            return redirect()->to(base_url('admin/users/edit'))->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
