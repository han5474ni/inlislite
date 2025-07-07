<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'profile';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id', 'foto', 'nama', 'username', 'email', 'password', 'role', 'status', 'last_login', 
        'nama_lengkap', 'nama_pengguna', 'kata_sandi', 'phone', 'address', 'bio'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'user_id' => 'required|integer|is_unique[profile.user_id,id,{id}]',
        'nama' => 'required|min_length[3]|max_length[255]',
        'username' => 'required|min_length[3]|max_length[100]|is_unique[profile.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[profile.email,id,{id}]',
        'role' => 'required|in_list[Super Admin,Admin,Pustakawan,Staff]',
        'status' => 'required|in_list[Aktif,Non-Aktif,Ditangguhkan]'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID harus diisi',
            'integer' => 'User ID harus berupa angka',
            'is_unique' => 'User sudah memiliki profile'
        ],
        'nama' => [
            'required' => 'Nama harus diisi',
            'min_length' => 'Nama minimal 3 karakter',
            'max_length' => 'Nama maksimal 255 karakter'
        ],
        'username' => [
            'required' => 'Username harus diisi',
            'min_length' => 'Username minimal 3 karakter',
            'max_length' => 'Username maksimal 100 karakter',
            'is_unique' => 'Username sudah digunakan'
        ],
        'email' => [
            'required' => 'Email harus diisi',
            'valid_email' => 'Format email tidak valid',
            'is_unique' => 'Email sudah digunakan'
        ]
    ];

    /**
     * Get profile by username
     */
    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Get profile by user ID (for compatibility)
     */
    public function getByUserId($userId)
    {
        return $this->find($userId);
    }

    /**
     * Get profile by email
     */
    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Update last login
     */
    public function updateLastLogin($id)
    {
        return $this->update($id, ['last_login' => date('Y-m-d H:i:s')]);
    }

    /**
     * Update profile photo
     */
    public function updatePhoto($id, $photoFilename)
    {
        return $this->update($id, ['foto' => $photoFilename]);
    }

    /**
     * Change password
     */
    public function changePassword($id, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($id, ['password' => $hashedPassword]);
    }

    /**
     * Verify password
     */
    public function verifyPassword($id, $password)
    {
        $profile = $this->find($id);
        if ($profile && isset($profile['password'])) {
            return password_verify($password, $profile['password']);
        }
        return false;
    }

    /**
     * Get formatted profile data
     */
    public function getFormattedProfile($id)
    {
        $profile = $this->find($id);
        if ($profile) {
            // Format dates
            if ($profile['last_login']) {
                $profile['last_login_formatted'] = date('d M Y, H:i', strtotime($profile['last_login']));
            } else {
                $profile['last_login_formatted'] = 'Belum pernah login';
            }
            
            if ($profile['created_at']) {
                $profile['created_at_formatted'] = date('d M Y, H:i', strtotime($profile['created_at']));
            }
            
            // Generate avatar initials
            $profile['avatar_initials'] = $this->getInitials($profile['nama']);
            
            // Profile photo URL
            if ($profile['foto']) {
                $profile['foto_url'] = base_url('images/profile/' . $profile['foto']);
            } else {
                $profile['foto_url'] = null;
            }
        }
        
        return $profile;
    }

    /**
     * Get initials from name
     */
    private function getInitials($name)
    {
        $words = explode(' ', trim($name));
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
                if (strlen($initials) >= 2) break;
            }
        }
        
        return $initials ?: 'U';
    }

    /**
     * Get profile statistics
     */
    public function getProfileStats()
    {
        $totalProfiles = $this->countAllResults();
        $activeProfiles = $this->where('status', 'Aktif')->countAllResults();
        $inactiveProfiles = $this->where('status', 'Non-aktif')->countAllResults();
        $suspendedProfiles = $this->where('status', 'Ditangguhkan')->countAllResults();
        
        return [
            'total' => $totalProfiles,
            'active' => $activeProfiles,
            'inactive' => $inactiveProfiles,
            'suspended' => $suspendedProfiles
        ];
    }

    /**
     * Search profiles
     */
    public function searchProfiles($searchTerm = '', $role = '', $status = '', $limit = 10, $offset = 0)
    {
        $builder = $this->builder();
        
        if (!empty($searchTerm)) {
            $builder->groupStart()
                   ->like('nama', $searchTerm)
                   ->orLike('username', $searchTerm)
                   ->orLike('email', $searchTerm)
                   ->groupEnd();
        }
        
        if (!empty($role)) {
            $builder->where('role', $role);
        }
        
        if (!empty($status)) {
            $builder->where('status', $status);
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Sync profile with user data
     */
    public function syncWithUser($userId)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);
        
        if (!$user) {
            return false;
        }
        
        $profile = $this->getByUserId($userId);
        
        $profileData = [
            'user_id' => $user['id'],
            'nama' => $user['nama_lengkap'],
            'nama_lengkap' => $user['nama_lengkap'],
            'username' => $user['nama_pengguna'],
            'nama_pengguna' => $user['nama_pengguna'],
            'email' => $user['email'],
            'password' => $user['kata_sandi'],
            'kata_sandi' => $user['kata_sandi'],
            'role' => $user['role'],
            'status' => $user['status']
        ];
        
        if ($profile) {
            // Update existing profile
            return $this->update($profile['id'], $profileData);
        } else {
            // Create new profile
            return $this->insert($profileData);
        }
    }

    /**
     * Create profile from user
     */
    public function createFromUser($userId)
    {
        return $this->syncWithUser($userId);
    }

    /**
     * Update profile and sync back to user
     */
    public function updateProfileAndSync($profileId, $data)
    {
        $profile = $this->find($profileId);
        if (!$profile) {
            return false;
        }
        
        // Update profile
        $result = $this->update($profileId, $data);
        
        if ($result && isset($data['nama_lengkap']) || isset($data['email']) || isset($data['role']) || isset($data['status'])) {
            // Sync back to users table if core fields changed
            $userModel = new \App\Models\UserModel();
            $userUpdateData = [];
            
            if (isset($data['nama_lengkap'])) {
                $userUpdateData['nama_lengkap'] = $data['nama_lengkap'];
            }
            if (isset($data['nama_pengguna'])) {
                $userUpdateData['nama_pengguna'] = $data['nama_pengguna'];
            }
            if (isset($data['email'])) {
                $userUpdateData['email'] = $data['email'];
            }
            if (isset($data['kata_sandi'])) {
                $userUpdateData['kata_sandi'] = $data['kata_sandi'];
            }
            if (isset($data['role'])) {
                $userUpdateData['role'] = $data['role'];
            }
            if (isset($data['status'])) {
                $userUpdateData['status'] = $data['status'];
            }
            
            if (!empty($userUpdateData)) {
                $userModel->update($profile['user_id'], $userUpdateData);
            }
        }
        
        return $result;
    }

    /**
     * Get profile with user relationship
     */
    public function getProfileWithUser($profileId)
    {
        return $this->select('profile.*, users.created_at as user_created_at')
                   ->join('users', 'users.id = profile.user_id', 'left')
                   ->find($profileId);
    }

    /**
     * Get all profiles with user data
     */
    public function getAllProfilesWithUsers($limit = null, $offset = 0)
    {
        $builder = $this->select('profile.*, users.created_at as user_created_at')
                       ->join('users', 'users.id = profile.user_id', 'left')
                       ->orderBy('profile.created_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Check synchronization status
     */
    public function checkSyncStatus()
    {
        $db = \Config\Database::connect();
        
        // Count users
        $userCount = $db->table('users')->countAllResults();
        
        // Count profiles
        $profileCount = $this->countAllResults();
        
        // Count orphaned profiles (profiles without users)
        $orphanedProfiles = $db->table('profile')
                              ->select('profile.id')
                              ->join('users', 'users.id = profile.user_id', 'left')
                              ->where('users.id IS NULL')
                              ->countAllResults();
        
        // Count users without profiles
        $usersWithoutProfiles = $db->table('users')
                                  ->select('users.id')
                                  ->join('profile', 'profile.user_id = users.id', 'left')
                                  ->where('profile.user_id IS NULL')
                                  ->countAllResults();
        
        return [
            'user_count' => $userCount,
            'profile_count' => $profileCount,
            'orphaned_profiles' => $orphanedProfiles,
            'users_without_profiles' => $usersWithoutProfiles,
            'is_synchronized' => ($userCount == $profileCount && $orphanedProfiles == 0 && $usersWithoutProfiles == 0)
        ];
    }

    /**
     * Fix synchronization issues
     */
    public function fixSynchronization()
    {
        $db = \Config\Database::connect();
        $fixed = 0;
        
        // Create profiles for users without profiles
        $usersWithoutProfiles = $db->table('users')
                                  ->select('users.*')
                                  ->join('profile', 'profile.user_id = users.id', 'left')
                                  ->where('profile.user_id IS NULL')
                                  ->get()
                                  ->getResultArray();
        
        foreach ($usersWithoutProfiles as $user) {
            $this->createFromUser($user['id']);
            $fixed++;
        }
        
        // Remove orphaned profiles
        $orphanedProfiles = $db->table('profile')
                              ->select('profile.id')
                              ->join('users', 'users.id = profile.user_id', 'left')
                              ->where('users.id IS NULL')
                              ->get()
                              ->getResultArray();
        
        foreach ($orphanedProfiles as $profile) {
            $this->delete($profile['id']);
            $fixed++;
        }
        
        return $fixed;
    }
}