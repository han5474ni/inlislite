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
            // Get current user ID (for now, use admin user by username)
            $profile = $this->profileModel->getByUsername('admin');
            
            if (!$profile) {
                // Create default profile if not exists
                $defaultProfile = [
                    'user_id' => 1, // Assuming admin user has ID 1
                    'foto' => null,
                    'nama' => 'Administrator',
                    'nama_lengkap' => 'Administrator',
                    'username' => 'admin',
                    'nama_pengguna' => 'admin',
                    'email' => 'admin@inlislite.com',
                    'password' => password_hash('admin123', PASSWORD_DEFAULT),
                    'kata_sandi' => password_hash('admin123', PASSWORD_DEFAULT),
                    'role' => 'Super Admin',
                    'status' => 'Aktif'
                ];
                
                $this->profileModel->insert($defaultProfile);
                $profile = $this->profileModel->getByUsername('admin');
            }
            
            // Get formatted profile data
            $formattedProfile = $this->profileModel->getFormattedProfile($profile['id']);
            
            // Get recent activities
            $recentActivities = $this->activityLogModel->getFormattedUserActivities($profile['user_id'], 10);
            
            // Get activity statistics
            $activityStats = $this->activityLogModel->getActivityStats($profile['user_id'], 30);
            
            // Log profile access
            $this->activityLogModel->logActivity($profile['user_id'], 'profile_access', 'User accessed profile page');
            
            $data = [
                'title' => 'User Profile - INLISlite v3.0',
                'user' => $formattedProfile,
                'recent_activities' => $recentActivities,
                'activity_stats' => $activityStats
            ];
            
            return view('admin/profile', $data);
            
        } catch (\Exception $e) {
            // Fallback to default data
            $userData = [
                'nama' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@inlislite.com',
                'role' => 'Super Admin',
                'status' => 'Aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'last_login_formatted' => 'Belum pernah login',
                'avatar_initials' => 'AD'
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
     * Update profile information
     */
    public function updateProfile()
    {
        try {
            $userId = $this->session->get('admin_id') ?? 1; // Default to admin user
            
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

            if (!$this->validate($rules)) {
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
            
            if (!empty($namaPengguna)) {
                $data['username'] = $namaPengguna;
                $data['nama_pengguna'] = $namaPengguna;
            }
            
            // Handle other fields
            $email = $this->request->getPost('email');
            if (!empty($email)) {
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
            if (!empty($bio)) {
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
                    'User changed password'
                );
            }

            // Only update if there's data to update
            if (empty($data)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tidak ada data yang diubah'
                ]);
            }

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
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate profile'
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
     * Upload profile photo
     */
    public function uploadPhoto()
    {
        try {
            $userId = $this->session->get('admin_id') ?? 1; // Default to admin user
            
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