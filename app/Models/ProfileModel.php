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
        'foto', 'nama', 'username', 'email', 'password', 'role', 'status', 'last_login', 
        'nama_lengkap', 'nama_pengguna', 'kata_sandi', 'phone', 'address', 'bio'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama' => 'required|min_length[3]|max_length[255]',
        'username' => 'required|min_length[3]|max_length[100]|is_unique[profile.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[profile.email,id,{id}]',
        'role' => 'required|in_list[Super Admin,Admin,Pustakawan,Staff]',
        'status' => 'required|in_list[Aktif,Non-aktif,Ditangguhkan]'
    ];

    protected $validationMessages = [
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
                $profile['foto_url'] = base_url('uploads/profiles/' . $profile['foto']);
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
}