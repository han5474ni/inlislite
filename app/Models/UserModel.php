<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_lengkap',
        'nama_pengguna', 
        'username',
        'email',
        'kata_sandi',
        'password',
        'role',
        'status',
        'last_login',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama_pengguna' => 'required|min_length[3]|max_length[50]|is_unique[users.nama_pengguna,id,{id}]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'kata_sandi' => 'required|min_length[6]',
        'role' => 'required|in_list[Super Admin,Admin,Pustakawan,Staff]',
        'status' => 'required|in_list[Aktif,Non-Aktif]'
    ];

    protected $validationMessages = [
        'nama_pengguna' => [
            'required' => 'Username wajib diisi',
            'min_length' => 'Username minimal 3 karakter',
            'max_length' => 'Username maksimal 50 karakter',
            'is_unique' => 'Username sudah digunakan'
        ],
        'email' => [
            'required' => 'Email wajib diisi',
            'valid_email' => 'Format email tidak valid',
            'is_unique' => 'Email sudah digunakan'
        ],
        'kata_sandi' => [
            'required' => 'Password wajib diisi',
            'min_length' => 'Password minimal 6 karakter'
        ],
        'role' => [
            'required' => 'Role wajib dipilih',
            'in_list' => 'Role tidak valid'
        ],
        'status' => [
            'required' => 'Status wajib dipilih',
            'in_list' => 'Status tidak valid'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Hash password before saving
     */
    protected function hashPassword(array $data)
    {
        // Handle both password field names for compatibility
        if (isset($data['data']['kata_sandi']) && !empty($data['data']['kata_sandi'])) {
            $data['data']['kata_sandi'] = password_hash($data['data']['kata_sandi'], PASSWORD_DEFAULT);
        }
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * Get all users with formatted data for DataTables
     */
    public function getUsersForDataTable($start = 0, $length = 10, $search = '', $orderColumn = 'id', $orderDir = 'asc')
    {
        $builder = $this->builder();
        
        // Check which database schema is being used
        $fields = $this->db->getFieldNames($this->table);
        $usernameField = in_array('nama_pengguna', $fields) ? 'nama_pengguna' : 'username';
        $passwordField = in_array('kata_sandi', $fields) ? 'kata_sandi' : 'password';
        
        // Search functionality - adapt to available fields
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nama_lengkap', $search)
                    ->orLike($usernameField, $search)
                    ->orLike('email', $search)
                    ->orLike('role', $search)
                    ->orLike('status', $search)
                    ->groupEnd();
        }

        // Get total records before applying limit
        $totalRecords = $builder->countAllResults(false);

        // Apply ordering and pagination
        $builder->orderBy($orderColumn, $orderDir)
                ->limit($length, $start);

        $users = $builder->get()->getResultArray();

        // Format data for display and normalize field names
        foreach ($users as &$user) {
            // Normalize username field
            if (!isset($user['nama_pengguna']) && isset($user['username'])) {
                $user['nama_pengguna'] = $user['username'];
            }
            if (!isset($user['username']) && isset($user['nama_pengguna'])) {
                $user['username'] = $user['nama_pengguna'];
            }
            
            // Normalize password field (for internal use only, never exposed)
            if (!isset($user['kata_sandi']) && isset($user['password'])) {
                $user['kata_sandi'] = $user['password'];
            }
            
            // Format dates
            $user['created_at_formatted'] = date('d M Y H:i', strtotime($user['created_at']));
            $user['last_login_formatted'] = $user['last_login'] ? date('d M Y H:i', strtotime($user['last_login'])) : 'Belum pernah';
            $user['avatar_initials'] = $this->getInitials($user['nama_lengkap'] ?: $user['nama_pengguna']);
        }

        return [
            'data' => $users,
            'recordsTotal' => $this->countAll(),
            'recordsFiltered' => $totalRecords
        ];
    }

    /**
     * Get user initials for avatar
     */
    private function getInitials($name)
    {
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
     * Create new user
     */
    public function createUser($data)
    {
        // Check which database schema is being used
        $fields = $this->db->getFieldNames($this->table);
        $usernameField = in_array('nama_pengguna', $fields) ? 'nama_pengguna' : 'username';
        $passwordField = in_array('kata_sandi', $fields) ? 'kata_sandi' : 'password';
        
        // Normalize data for database schema
        $normalizedData = [];
        
        // Handle username field
        if (isset($data['nama_pengguna'])) {
            $normalizedData[$usernameField] = $data['nama_pengguna'];
        } elseif (isset($data['username'])) {
            $normalizedData[$usernameField] = $data['username'];
        }
        
        // Handle password field
        if (isset($data['kata_sandi'])) {
            $normalizedData[$passwordField] = $data['kata_sandi'];
        } elseif (isset($data['password'])) {
            $normalizedData[$passwordField] = $data['password'];
        }
        
        // Handle other fields
        $normalizedData['nama_lengkap'] = $data['nama_lengkap'] ?? $normalizedData[$usernameField];
        $normalizedData['email'] = $data['email'];
        $normalizedData['role'] = $data['role'];
        $normalizedData['status'] = $data['status'];
        
        // Set timestamps based on schema
        if (in_array('created_at', $fields)) {
            $normalizedData['created_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->insert($normalizedData);
    }

    /**
     * Update user
     */
    public function updateUser($id, $data)
    {
        // Check which database schema is being used
        $fields = $this->db->getFieldNames($this->table);
        $usernameField = in_array('nama_pengguna', $fields) ? 'nama_pengguna' : 'username';
        $passwordField = in_array('kata_sandi', $fields) ? 'kata_sandi' : 'password';
        
        // Normalize data for database schema
        $normalizedData = [];
        
        // Handle username field
        if (isset($data['nama_pengguna'])) {
            $normalizedData[$usernameField] = $data['nama_pengguna'];
        } elseif (isset($data['username'])) {
            $normalizedData[$usernameField] = $data['username'];
        }
        
        // Handle password field - don't update if empty
        if (isset($data['kata_sandi']) && !empty($data['kata_sandi'])) {
            $normalizedData[$passwordField] = $data['kata_sandi'];
        } elseif (isset($data['password']) && !empty($data['password'])) {
            $normalizedData[$passwordField] = $data['password'];
        }
        
        // Handle other fields
        if (isset($data['nama_lengkap'])) {
            $normalizedData['nama_lengkap'] = $data['nama_lengkap'];
        }
        if (isset($data['email'])) {
            $normalizedData['email'] = $data['email'];
        }
        if (isset($data['role'])) {
            $normalizedData['role'] = $data['role'];
        }
        if (isset($data['status'])) {
            $normalizedData['status'] = $data['status'];
        }
        
        // Set timestamps based on schema
        if (in_array('updated_at', $fields)) {
            $normalizedData['updated_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->update($id, $normalizedData);
    }

    /**
     * Get user by username or email
     */
    public function getUserByUsernameOrEmail($identifier)
    {
        // Check which database schema is being used
        $fields = $this->db->getFieldNames($this->table);
        $usernameField = in_array('nama_pengguna', $fields) ? 'nama_pengguna' : 'username';
        
        return $this->where($usernameField, $identifier)
                    ->orWhere('email', $identifier)
                    ->first();
    }

    /**
     * Update last login time
     */
    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }
}