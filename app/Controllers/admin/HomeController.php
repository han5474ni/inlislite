<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Dashboard - INLISLite v3',
            'page_title' => 'Selamat Datang di InlisLite!'
        ];
        
        return view('admin/dashboard', $data);
    }

    public function dashboard(): string
    {
        $data = [
            'title' => 'Dashboard - INLISLite v3',
            'page_title' => 'Selamat Datang di InlisLite!'
        ];
        
        return view('admin/dashboard', $data);
    }
    
    public function tailwindDashboard(): string
    {
        // Consolidated: redirect to main dashboard
        return redirect()->to(base_url('admin/dashboard'));
    }

    public function userManagement(): string
    {
        $builder = \Config\Database::connect()->table('users');
        $users = $builder->get()->getResultArray();

        $data = [
            'title' => 'User Management - INLISLite v3',
            'users' => $users
        ];
        
        return view('admin/user_management', $data);
    }
    public function patchUpdater(): string
    {
        $data = [
            'title' => 'Patch Updater - INLISLite v3'
        ];
        
        return view('admin/patch_updater', $data);
    }

    public function patchUpdaterSubmit(): string
    {
        $data = [
            'title' => 'Patch Updater Submit - INLISLite v3'
        ];
        
        return view('admin/patch_updater_submit', $data);
    }

    public function patchUpdaterSubmitProcess(): string
    {
        $data = [
            'title' => 'Patch Updater Process - INLISLite v3'
        ];
        
        return view('patch_updater_submit_process', $data);
    }

    public function tentang(): string
    {
        $data = [
            'title' => 'Tentang INLISLite v3 - Sistem Otomasi Perpustakaan',
            'page_title' => 'Tentang INLISLite Versi 3',
            'page_subtitle' => 'Informasi lengkap tentang sistem otomasi perpustakaan'
        ];
        
        return view('tentang', $data);
    }

    public function panduan(): string
    {
        // Redirect to DocumentController
return redirect()->to(base_url('panduan'));
    }

    public function debugDatabase(): string
    {
        try {
            // Registration debugging removed
            
            $debugData = [
                'message' => 'Registration feature has been removed'
            ];
            
            return json_encode($debugData);
        } catch (\Exception $e) {
            return json_encode([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function profile(): string
    {
        try {
            $profileModel = new \App\Models\ProfileModel();
            $activityLogModel = new \App\Models\ActivityLogModel();
            
            // Get current user ID (for now, use admin user by username)
            $profile = $profileModel->getByUsername('admin');
            
            if (!$profile) {
                // Create default profile if not exists
                $defaultProfile = [
                    'foto' => null,
                    'nama' => 'Administrator',
                    'username' => 'admin',
                    'email' => 'admin@inlislite.com',
                    'password' => password_hash('admin123', PASSWORD_DEFAULT),
                    'role' => 'Super Admin',
                    'status' => 'Aktif'
                ];
                
                $profileModel->insert($defaultProfile);
                $profile = $profileModel->getByUsername('admin');
            }
            
            // Get formatted profile data
            $formattedProfile = $profileModel->getFormattedProfile($profile['id']);
            
            // Get recent activities
            $recentActivities = $activityLogModel->getFormattedUserActivities($profile['id'], 10);
            
            // Get activity statistics
            $activityStats = $activityLogModel->getActivityStats($profile['id'], 30);
            
            // Log profile access
            $activityLogModel->logActivity($profile['id'], 'profile_access', 'User accessed profile page');
            
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

    public function updateProfile()
    {
        try {
            $profileModel = new \App\Models\ProfileModel();
            $activityLogModel = new \App\Models\ActivityLogModel();
            
            $userId = 1; // This should come from session in a real auth system
            
            $validation = \Config\Services::validation();
            
            $rules = [
                'nama' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email|max_length[255]',
                'phone' => 'permit_empty|max_length[20]',
                'address' => 'permit_empty|max_length[500]',
                'bio' => 'permit_empty|max_length[1000]',
                'current_password' => 'permit_empty',
                'kata_sandi' => 'permit_empty|min_length[6]',
                'confirm_password' => 'permit_empty|matches[kata_sandi]'
            ];
            
            $messages = [
                'nama' => [
                    'required' => 'Name is required',
                    'min_length' => 'Name must be at least 3 characters long',
                    'max_length' => 'Name cannot exceed 255 characters'
                ],
                'email' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address',
                    'max_length' => 'Email cannot exceed 255 characters'
                ],
                'kata_sandi' => [
                    'min_length' => 'Password must be at least 6 characters long'
                ],
                'confirm_password' => [
                    'matches' => 'Password confirmation does not match'
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            // Get current profile for comparison
            $currentProfile = $profileModel->getByUserId($userId);
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
                    if (!$profileModel->verifyPassword($userId, $currentPassword)) {
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => 'Password saat ini tidak benar'
                        ]);
                    }
                }
                
                $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
                $data['kata_sandi'] = password_hash($newPassword, PASSWORD_DEFAULT);
                
                // Log password change
                $activityLogModel->logActivity(
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

            // Update profile
            $result = $profileModel->update($currentProfile['id'], $data);
            
            if ($result) {
                // Log profile update
                $activityLogModel->logActivity(
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

    public function uploadProfilePhoto()
    {
        try {
            $profileModel = new \App\Models\ProfileModel();
            $activityLogModel = new \App\Models\ActivityLogModel();
            
            $userId = 1; // This should come from session in a real auth system
            
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
            $uploadPath = FCPATH . 'uploads/profiles';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Generate unique filename
            $extension = $file->getClientExtension();
            $filename = 'profile_' . $userId . '_' . time() . '.' . $extension;
            
            // Move file
            if ($file->move($uploadPath, $filename)) {
                // Get current profile to delete old photo
                $currentProfile = $profileModel->getByUserId($userId);
                if ($currentProfile && $currentProfile['foto']) {
                    $oldPhotoPath = $uploadPath . '/' . $currentProfile['foto'];
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }
                
                // Update profile with new photo
                $result = $profileModel->updatePhoto($userId, $filename);
                
                if ($result) {
                    // Log photo upload
                    $activityLogModel->logActivity(
                        $userId, 
                        'photo_upload', 
                        'User uploaded new profile photo: ' . $filename
                    );
                    
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Foto profil berhasil diupload!',
                        'photo_url' => base_url('uploads/profiles/' . $filename)
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

    public function getActivityHistory()
    {
        try {
            $activityLogModel = new \App\Models\ActivityLogModel();
            
            $userId = 1; // This should come from session in a real auth system
            $page = $this->request->getGet('page') ?? 1;
            $limit = 20;
            $offset = ($page - 1) * $limit;
            
            $activities = $activityLogModel->getFormattedUserActivities($userId, $limit, $offset);
            
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

    public function sidebarDemo(): string
    {
        $data = [
            'title' => 'New Sidebar Demo - INLISLite v3'
        ];
        
        return view('new_sidebar_demo', $data);
    }
}
