<?php

namespace App\Controllers;

use App\Models\ProfileModel;
use App\Models\ActivityLogModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    protected $profileModel;
    protected $activityLogModel;
    protected $session;

    public function __construct()
    {
        $this->profileModel = new ProfileModel();
        $this->activityLogModel = new ActivityLogModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Display profile page
     */
    public function index(): string
    {
        try {
            // Get current logged-in user ID from session
            $userId = $this->session->get('admin_user_id') ?? $this->session->get('admin_id');
            
            if (!$userId) {
                // If no session, redirect to login
                return redirect()->to(base_url('admin/login'))->with('error', 'Please login to access your profile');
            }
            
            // Get user data from users table
            $userModel = new \App\Models\UserModel();
            $user = $userModel->find($userId);
            
            if (!$user) {
                return redirect()->to(base_url('admin/login'))->with('error', 'User not found');
            }
            
            // Get or create profile for this user
            $profile = $this->profileModel->getByUserId($userId);
            
            if (!$profile) {
                // Create profile from user data
                $this->profileModel->createFromUser($userId);
                $profile = $this->profileModel->getByUserId($userId);
            }
            
            // Get formatted profile data
            $formattedProfile = $this->profileModel->getFormattedProfile($profile['id']);
            
            // Get recent activities
            $recentActivities = $this->activityLogModel->getFormattedUserActivities($userId, 10);
            
            // Get activity statistics
            $activityStats = $this->activityLogModel->getActivityStats($userId, 30);
            
            // Log profile access
            $this->activityLogModel->logActivity($userId, 'profile_access', 'User accessed profile page');
            
            $data = [
                'title' => 'User Profile - INLISlite v3.0',
                'user' => $formattedProfile,
                'recent_activities' => $recentActivities,
                'activity_stats' => $activityStats
            ];
            
            return view('admin/profile', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Profile page error: ' . $e->getMessage());
            
            // Get basic user info from session for fallback
            $userData = [
                'nama' => $this->session->get('admin_nama_lengkap') ?? 'Administrator',
                'nama_lengkap' => $this->session->get('admin_nama_lengkap') ?? 'Administrator',
                'nama_pengguna' => $this->session->get('admin_username') ?? 'admin',
                'username' => $this->session->get('admin_username') ?? 'admin',
                'email' => $this->session->get('admin_email') ?? 'admin@inlislite.com',
                'role' => $this->session->get('admin_role') ?? 'Super Admin',
                'status' => 'Aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'last_login_formatted' => 'Belum pernah login',
                'avatar_initials' => $this->getInitials($this->session->get('admin_nama_lengkap') ?? 'Administrator')
            ];

            $data = [
                'title' => 'User Profile - INLISlite v3.0',
                'user' => $userData,
                'recent_activities' => [],
                'activity_stats' => []
            ];
            
            return view('admin/profile', $data);
        }
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
     * Update profile information
     */
    public function updateProfile()
    {
        try {
            // Get current logged-in user ID from session
            $userId = $this->session->get('admin_user_id') ?? $this->session->get('admin_id');
            
            if (!$userId) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User tidak terautentikasi'
                ]);
            }
            
            $validation = \Config\Services::validation();
            
            $rules = [
                'nama_lengkap' => 'permit_empty|min_length[3]|max_length[255]',
                'email' => 'permit_empty|valid_email',
                'nama_pengguna' => 'permit_empty|min_length[3]|max_length[100]',
                'phone' => 'permit_empty|max_length[20]',
                'address' => 'permit_empty|max_length[500]',
                'bio' => 'permit_empty|max_length[1000]',
                'current_password' => 'permit_empty',
                'kata_sandi' => 'permit_empty|min_length[6]',
                'confirm_password' => 'permit_empty|matches[kata_sandi]'
            ];
            
            $messages = [
                'nama_lengkap' => [
                    'min_length' => 'Full name must be at least 3 characters',
                    'max_length' => 'Full name cannot exceed 255 characters'
                ],
                'email' => [
                    'valid_email' => 'Please enter a valid email address'
                ],
                'nama_pengguna' => [
                    'min_length' => 'Username must be at least 3 characters',
                    'max_length' => 'Username cannot exceed 100 characters'
                ],
                'phone' => [
                    'max_length' => 'Phone number cannot exceed 20 characters'
                ],
                'address' => [
                    'max_length' => 'Address cannot exceed 500 characters'
                ],
                'bio' => [
                    'max_length' => 'Bio cannot exceed 1000 characters'
                ],
                'kata_sandi' => [
                    'min_length' => 'Password must be at least 6 characters'
                ],
                'confirm_password' => [
                    'matches' => 'Password confirmation must match the new password'
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            // Get current profile
            $currentProfile = $this->profileModel->getByUserId($userId);
            if (!$currentProfile) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Profile tidak ditemukan'
                ]);
            }
            
            $data = [];
            
            // Handle name update
            $namaLengkap = $this->request->getPost('nama_lengkap');
            $namaPengguna = $this->request->getPost('nama_pengguna');
            
            if (!empty($namaLengkap)) {
                $data['nama'] = $namaLengkap;
                $data['nama_lengkap'] = $namaLengkap;
            }
            
            // Check if user can edit username (only Super Admin)
            if (!empty($namaPengguna) && $namaPengguna !== $currentProfile['nama_pengguna']) {
                if ($currentProfile['role'] !== 'Super Admin') {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Hanya Super Admin yang dapat mengubah username'
                    ]);
                }
                
                // Check if username is already taken by another user
                $existingProfile = $this->profileModel->where('nama_pengguna', $namaPengguna)
                                                    ->where('id !=', $currentProfile['id'])
                                                    ->first();
                if ($existingProfile) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Username sudah digunakan oleh pengguna lain'
                    ]);
                }
                
                $data['username'] = $namaPengguna;
                $data['nama_pengguna'] = $namaPengguna;
            }
            
            // Handle other fields - Check if user can edit email (only Super Admin)
            $email = $this->request->getPost('email');
            if (!empty($email) && $email !== $currentProfile['email']) {
                if ($currentProfile['role'] !== 'Super Admin') {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Hanya Super Admin yang dapat mengubah email'
                    ]);
                }
                
                // Check if email is already taken by another user
                $existingProfile = $this->profileModel->where('email', $email)
                                                    ->where('id !=', $currentProfile['id'])
                                                    ->first();
                if ($existingProfile) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Email sudah digunakan oleh pengguna lain'
                    ]);
                }
                
                $data['email'] = $email;
            }
            
            $phone = $this->request->getPost('phone');
            if (!empty($phone)) {
                $data['phone'] = $phone;
            }
            
            $address = $this->request->getPost('address');
            if (!empty($address)) {
                $data['address'] = $address;
            }
            
            $bio = $this->request->getPost('bio');
            if ($bio !== null) { // Changed from !empty to !== null to allow empty string
                $data['bio'] = $bio;
            }

            // Handle password change
            $newPassword = $this->request->getPost('kata_sandi');
            $currentPassword = $this->request->getPost('current_password');
            
            if (!empty($newPassword)) {
                // Verify current password if provided
                if (!empty($currentPassword)) {
                    if (!$this->profileModel->verifyPassword($currentProfile['id'], $currentPassword)) {
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => 'Password saat ini tidak benar'
                        ]);
                    }
                }
                
                $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
                $data['kata_sandi'] = password_hash($newPassword, PASSWORD_DEFAULT);
                
                // Log password change
                $this->activityLogModel->logActivity(
                    $userId, 
                    'password_change', 
                    'User changed their password',
                    null,
                    null
                );
            }
            
            if (empty($data)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tidak ada data yang diubah'
                ]);
            }

            // Log data being sent for debugging
            log_message('debug', 'Profile update data: ' . json_encode($data));
            log_message('debug', 'Profile ID: ' . $currentProfile['id']);
            
            // Update profile using sync method
            $result = $this->profileModel->updateProfileAndSync($currentProfile['id'], $data);
            
            if ($result) {
                // Log profile update
                $this->activityLogModel->logActivity(
                    $userId, 
                    'profile_update', 
                    'User updated profile information: ' . implode(', ', array_keys($data)),
                    $currentProfile,
                    $data
                );
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Profile berhasil diupdate!'
                ]);
            } else {
                // Get detailed error information
                $profileErrors = $this->profileModel->errors() ? $this->profileModel->errors() : [];
                $dbError = $this->profileModel->db->error();
                
                // Log the failure for debugging
                log_message('error', 'Profile update failed for profile ID: ' . $currentProfile['id']);
                log_message('error', 'Profile model errors: ' . json_encode($profileErrors));
                log_message('error', 'Database error: ' . json_encode($dbError));
                log_message('error', 'Update data: ' . json_encode($data));
                
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate profile',
                    'error_details' => [
                        'model_errors' => $profileErrors,
                        'db_error' => $dbError,
                        'profile_id' => $currentProfile['id']
                    ]
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Upload profile photo
     */
    public function uploadPhoto()
    {
        try {
            // Get current logged-in user ID from session
            $userId = $this->session->get('admin_user_id') ?? $this->session->get('admin_id');
            
            if (!$userId) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User tidak terautentikasi'
                ]);
            }
            
            $file = $this->request->getFile('profile_photo');
            
            if (!$file->isValid()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File tidak valid'
                ]);
            }
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tipe file tidak diizinkan. Gunakan JPG, PNG, atau GIF'
                ]);
            }
            
            // Validate file size (max 2MB)
            if ($file->getSize() > 2 * 1024 * 1024) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ukuran file terlalu besar. Maksimal 2MB'
                ]);
            }
            
            // Create upload directory if not exists
            $uploadPath = ROOTPATH . 'archive/Images/profile';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Generate unique filename
            $extension = $file->getClientExtension();
            $filename = 'profile_' . $userId . '_' . time() . '.' . $extension;
            
            // Move file
            if ($file->move($uploadPath, $filename)) {
                // Get current profile to delete old photo
                $currentProfile = $this->profileModel->getByUserId($userId);
                if ($currentProfile && $currentProfile['foto']) {
                    $oldPhotoPath = $uploadPath . '/' . $currentProfile['foto'];
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }
                
                // Update profile with new photo
                $result = $this->profileModel->updatePhoto($currentProfile['id'], $filename);
                
                if ($result) {
                    // Log photo upload
                    $this->activityLogModel->logActivity(
                        $userId, 
                        'photo_upload', 
                        'User uploaded new profile photo: ' . $filename
                    );
                    
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Foto profil berhasil diupload!',
                        'photo_url' => base_url('images/profile/' . $filename)
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal menyimpan foto ke database'
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupload file'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get profile data (API endpoint)
     */
    public function getProfile($profileId = null)
    {
        try {
            if ($profileId) {
                $profile = $this->profileModel->getFormattedProfile($profileId);
            } else {
                $userId = $this->session->get('admin_id') ?? 1;
                $profile = $this->profileModel->getByUserId($userId);
                if ($profile) {
                    $profile = $this->profileModel->getFormattedProfile($profile['id']);
                }
            }
            
            if ($profile) {
                return $this->response->setJSON([
                    'success' => true,
                    'profile' => $profile
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Profile tidak ditemukan'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get activity history
     */
    public function getActivityHistory()
    {
        try {
            $userId = $this->session->get('admin_id') ?? 1;
            $page = $this->request->getGet('page') ?? 1;
            $limit = 20;
            $offset = ($page - 1) * $limit;
            
            $activities = $this->activityLogModel->getFormattedUserActivities($userId, $limit, $offset);
            
            return $this->response->setJSON([
                'success' => true,
                'activities' => $activities,
                'page' => $page
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Check profile synchronization status
     */
    public function checkSyncStatus()
    {
        try {
            $syncStatus = $this->profileModel->checkSyncStatus();
            
            return $this->response->setJSON([
                'success' => true,
                'sync_status' => $syncStatus
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Fix synchronization issues
     */
    public function fixSynchronization()
    {
        try {
            $fixed = $this->profileModel->fixSynchronization();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => "Synchronization fixed. $fixed issues resolved.",
                'fixed_count' => $fixed
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}