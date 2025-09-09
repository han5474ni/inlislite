<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Dashboard - INLISLite v3',
            'page_title' => 'Selamat Datang di InlisLite!',
            'page_subtitle' => 'Kelola sistem perpustakaan Anda dengan alat dan analitik yang lengkap.'
        ];
        
        return view('admin/dashboard', $data);
    }

    public function dashboard(): string
    {
        $data = [
            'title' => 'Dashboard - INLISLite v3',
            'page_title' => 'Selamat Datang di InlisLite!',
            'page_subtitle' => 'Kelola sistem perpustakaan Anda dengan alat dan analitik yang lengkap.'
        ];
        
        return view('admin/dashboard', $data);
    }

    public function userManagement(): string
    {
        $builder = \Config\Database::connect()->table('users');
        $users = $builder->get()->getResultArray();

        $data = [
            'title' => 'User Management - INLISLite v3',
            'users' => $users
        ];
        
        return view('user_management', $data);
    }

    public function registration(): string
    {
        // Registration feature removed
        return redirect()->to('/');
    }

    public function getRegistrationStats(): string
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            $year = $this->request->getGet('year') ?? date('Y');
            
            // Debug logging
            log_message('info', 'Getting registration stats for year: ' . $year);
            
            $monthlyStats = $registrationModel->getMonthlyStats($year);
            
            // Debug logging
            log_message('info', 'Monthly stats result: ' . json_encode($monthlyStats));
            
return json_encode($monthlyStats);
        } catch (\Exception $e) {
            // Log the error
            log_message('error', 'Error getting registration stats: ' . $e->getMessage());
            
            // Return empty data if table doesn't exist
            $emptyData = [];
            for ($i = 1; $i <= 12; $i++) {
                $emptyData[] = [
                    'month' => $i,
                    'total' => 0,
                    'verified' => 0,
                    'pending' => 0
                ];
            }
            return json_encode($emptyData);
        }
    }

    public function addRegistrationForm(): string
    {
        // Registration feature removed
        return redirect()->to('/');
    }

    public function addRegistration()
    {
        // Registration feature removed
        return redirect()->to('/');
    }

    public function editRegistrationForm($id): string
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            $registration = $registrationModel->find($id);
            
            if (!$registration) {
                throw new \Exception('Registration not found');
            }
            
            $data = [
                'title' => 'Edit Registration - INLISlite v3.0',
                'page_title' => 'Edit Registration',
                'page_subtitle' => 'Update library registration information',
                'registration' => $registration
            ];
            
            return view('admin/registration_edit', $data);
        } catch (\Exception $e) {
            // Redirect back to registration list with error
            session()->setFlashdata('error', 'Registration not found: ' . $e->getMessage());
return redirect()->to(base_url('admin/registration'));
        }
    }

    public function viewRegistration($id): string
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            $registration = $registrationModel->find($id);
            
            if (!$registration) {
                throw new \Exception('Registration not found');
            }
            
            $data = [
                'title' => 'View Registration - INLISlite v3.0',
                'page_title' => 'Registration Details',
                'page_subtitle' => 'View library registration information',
                'registration' => $registration
            ];
            
            return view('admin/registration_view', $data);
        } catch (\Exception $e) {
            // Redirect back to registration list with error
            session()->setFlashdata('error', 'Registration not found: ' . $e->getMessage());
            return redirect()->to('/admin/registration');
        }
    }

    public function updateRegistrationStatus()
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            $id = $this->request->getPost('id');
            $status = $this->request->getPost('status');
            
            $data = ['status' => $status];
            if ($status === 'verified') {
                $data['verified_at'] = date('Y-m-d H:i:s');
            }
            
            $result = $registrationModel->update($id, $data);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Status berhasil diupdate!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate status'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function getRegistration($id)
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            $registration = $registrationModel->find($id);
            
            if ($registration) {
                return $this->response->setJSON([
                    'success' => true,
                    'registration' => $registration
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Registrasi tidak ditemukan'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function updateRegistration($id)
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            
            // Enhanced validation rules with better error handling
            $rules = [
                'library_name' => 'required|min_length[3]|max_length[255]',
                'library_code' => 'permit_empty|max_length[50]',
                'library_type' => 'required|in_list[Public,Academic,School,Special]',
                'province' => 'required|min_length[2]|max_length[100]',
                'city' => 'required|min_length[2]|max_length[100]',
                'address' => 'permit_empty|max_length[500]',
                'postal_code' => 'permit_empty|max_length[10]',
                'coordinates' => 'permit_empty|max_length[100]',
                'contact_name' => 'required|min_length[3]|max_length[255]',
                'contact_position' => 'permit_empty|max_length[100]',
                'email' => 'required|valid_email|max_length[255]',
                'phone' => 'required|min_length[6]|max_length[20]',
                'website' => 'permit_empty|valid_url_http|max_length[255]',
                'fax' => 'permit_empty|max_length[20]',
                'established_year' => 'permit_empty|integer|greater_than[1800]|less_than_equal_to[' . date('Y') . ']',
                'collection_count' => 'permit_empty|integer|greater_than_equal_to[0]',
                'member_count' => 'permit_empty|integer|greater_than_equal_to[0]',
                'notes' => 'permit_empty|max_length[1000]',
                'status' => 'required|in_list[Active,Inactive,Pending]'
            ];
            
            // Custom validation messages
            $messages = [
                'library_name' => [
                    'required' => 'Library name is required',
                    'min_length' => 'Library name must be at least 3 characters long',
                    'max_length' => 'Library name cannot exceed 255 characters'
                ],
                'library_type' => [
                    'required' => 'Please select a library type',
                    'in_list' => 'Library type must be one of: Public, Academic, School, Special'
                ],
                'province' => [
                    'required' => 'Province is required',
                    'min_length' => 'Province must be at least 2 characters long'
                ],
                'city' => [
                    'required' => 'City is required',
                    'min_length' => 'City must be at least 2 characters long'
                ],
                'contact_name' => [
                    'required' => 'Contact person name is required',
                    'min_length' => 'Contact name must be at least 3 characters long'
                ],
                'email' => [
                    'required' => 'Email address is required',
                    'valid_email' => 'Please enter a valid email address'
                ],
                'phone' => [
                    'required' => 'Phone number is required',
                    'min_length' => 'Phone number must be at least 6 characters long'
                ],
                'website' => [
                    'valid_url_http' => 'Please enter a valid website URL (including http:// or https://)'
                ],
                'established_year' => [
                    'integer' => 'Established year must be a valid year',
                    'greater_than' => 'Established year must be after 1800',
                    'less_than_equal_to' => 'Established year cannot be in the future'
                ],
                'collection_count' => [
                    'integer' => 'Collection count must be a number',
                    'greater_than_equal_to' => 'Collection count cannot be negative'
                ],
                'member_count' => [
                    'integer' => 'Member count must be a number',
                    'greater_than_equal_to' => 'Member count cannot be negative'
                ],
                'status' => [
                    'required' => 'Please select a status',
                    'in_list' => 'Status must be one of: Active, Inactive, Pending'
                ]
            ];
            
            if (!$this->validate($rules, $messages)) {
                $errors = $this->validator->getErrors();
                
                // Check if this is an AJAX request
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Data yang dimasukkan tidak valid: ' . implode(', ', $errors),
                        'errors' => $errors
                    ]);
                }
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data yang dimasukkan tidak valid: ' . implode(', ', $errors))
                    ->with('errors', $errors);
            }
            
            // Process form data with proper handling for empty values and data types
            $data = [
                'library_name' => trim($this->request->getPost('library_name')),
                'library_code' => $this->request->getPost('library_code') ?: null,
                'library_type' => $this->request->getPost('library_type'),
                'status' => $this->request->getPost('status'),
                'province' => trim($this->request->getPost('province')),
                'city' => trim($this->request->getPost('city')),
                'address' => $this->request->getPost('address') ?: null,
                'postal_code' => $this->request->getPost('postal_code') ?: null,
                'coordinates' => $this->request->getPost('coordinates') ?: null,
                'contact_name' => trim($this->request->getPost('contact_name')),
                'contact_position' => $this->request->getPost('contact_position') ?: null,
                'email' => trim($this->request->getPost('email')),
                'phone' => trim($this->request->getPost('phone')),
                'website' => $this->request->getPost('website') ?: null,
                'fax' => $this->request->getPost('fax') ?: null,
                'established_year' => $this->request->getPost('established_year') ? (int)$this->request->getPost('established_year') : null,
                'collection_count' => $this->request->getPost('collection_count') ? (int)$this->request->getPost('collection_count') : null,
                'member_count' => $this->request->getPost('member_count') ? (int)$this->request->getPost('member_count') : null,
                'notes' => $this->request->getPost('notes') ?: null,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Validate website URL format if provided
            if (!empty($data['website']) && !filter_var($data['website'], FILTER_VALIDATE_URL)) {
                // Try to add http:// if missing
                if (!preg_match('/^https?:\/\//', $data['website'])) {
                    $data['website'] = 'http://' . $data['website'];
                }
            }
            
            // If status is being changed to Active, add verified_at timestamp
            if ($data['status'] === 'Active') {
                $currentRegistration = $registrationModel->find($id);
                if ($currentRegistration && $currentRegistration['status'] !== 'Active') {
                    $data['verified_at'] = date('Y-m-d H:i:s');
                }
            }
            
            $result = $registrationModel->update($id, $data);
            
            if ($result) {
                // Check if this is an AJAX request
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Registrasi berhasil diupdate!'
                    ]);
                }
                
                return redirect()->to('/admin/registration')
                    ->with('success', 'Registrasi berhasil diupdate!');
            } else {
                // Check if this is an AJAX request
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal mengupdate registrasi'
                    ]);
                }
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengupdate registrasi');
            }
        } catch (\Exception $e) {
            // Check if this is an AJAX request
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function deleteRegistration($id)
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            $result = $registrationModel->delete($id);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Registrasi berhasil dihapus!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus registrasi'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function getRegistrationData()
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            
            $stats = $registrationModel->getTotalStats();
            $registrations = $registrationModel->orderBy('created_at', 'DESC')->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'stats' => $stats,
                'registrations' => $registrations
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'stats' => ['total' => 0, 'verified' => 0, 'pending' => 0],
                'registrations' => []
            ]);
        }
    }

    public function getAvailableYears()
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            $years = $registrationModel->getAvailableYears();
            
            return $this->response->setJSON([
                'success' => true,
                'years' => $years
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'years' => [date('Y')]
            ]);
        }
    }

    public function patchUpdater(): string
    {
        $data = [
            'title' => 'Patch Updater - INLISLite v3'
        ];
        
        return view('patch_updater', $data);
    }

    public function patchUpdaterSubmit(): string
    {
        $data = [
            'title' => 'Patch Updater Submit - INLISLite v3'
        ];
        
        return view('patch_updater_submit', $data);
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
            $registrationModel = new \App\Models\RegistrationModel();
            
            // Get all registrations
            $allRegistrations = $registrationModel->findAll();
            
            // Get available years
            $years = $registrationModel->getAvailableYears();
            
            // Get current year stats
            $currentYear = date('Y');
            $currentYearStats = $registrationModel->getMonthlyStats($currentYear);
            
            $debugData = [
                'total_records' => count($allRegistrations),
                'sample_records' => array_slice($allRegistrations, 0, 5),
                'available_years' => $years,
                'current_year' => $currentYear,
                'current_year_stats' => $currentYearStats
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
