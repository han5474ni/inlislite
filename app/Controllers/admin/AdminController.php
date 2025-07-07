<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
        // Add authentication check here when implemented
    }
    
    public function index()
    {
        $data = [
            'title' => 'Admin Dashboard - INLISLite v3',
            'page_title' => 'Admin Dashboard',
            'page_subtitle' => 'Kelola sistem perpustakaan Anda'
        ];
        
        return view('admin/dashboard', $data);
    }
    
    public function modernDashboard()
    {
        $data = [
            'title' => 'INLISLite v3.0 Dashboard - Sistem Perpustakaan Modern',
            'page_title' => 'Selamat Datang di InlisLite!',
            'page_subtitle' => 'Kelola sistem perpustakaan Anda dengan alat dan analitik yang lengkap.'
        ];
        
        return view('admin/modern_dashboard', $data);
    }
    
    public function login()
    {
        $data = [
            'title' => 'Admin Login - INLISLite v3'
        ];
        
        return view('admin/login', $data);
    }
    
    public function logout()
    {
        // Implement logout logic
        $this->session->destroy();
        return redirect()->to('/admin/login');
    }
    
    public function tentang()
    {
        $data = [
            'title' => 'About INLISLite Version 3 - INLISlite v3.0',
            'page_title' => 'About INLISLite Version 3',
            'page_subtitle' => 'Detailed information about the library automation system'
        ];
        
        return view('admin/tentang', $data);
    }
    
    public function patch_updater()
    {
        $data = [
            'title' => 'Patch and Updater - INLISlite v3.0',
            'page_title' => 'Patch and Updater',
            'page_subtitle' => 'Download and install patch packages',
            'patches' => [
                [
                    'id' => 1,
                    'nama_paket' => 'INLISLite v3.2 Cumulative Updater',
                    'versi' => '3.2.1',
                    'prioritas' => 'High',
                    'ukuran' => '15.2 MB',
                    'tanggal_rilis' => '2024-01-15',
                    'deskripsi' => 'Updater ini ditujukan untuk memperbaharui paket instalasi INLISLite v3 sebelumnya dengan fitur terbaru dan perbaikan bug.',
                    'jumlah_unduhan' => 1250
                ],
                [
                    'id' => 2,
                    'nama_paket' => 'Security Patch v3.1.8',
                    'versi' => '3.1.8',
                    'prioritas' => 'High',
                    'ukuran' => '8.7 MB',
                    'tanggal_rilis' => '2024-01-10',
                    'deskripsi' => 'Patch keamanan penting untuk memperbaiki vulnerabilitas yang ditemukan pada versi sebelumnya.',
                    'jumlah_unduhan' => 2100
                ],
                [
                    'id' => 3,
                    'nama_paket' => 'Performance Enhancement Pack',
                    'versi' => '3.1.5',
                    'prioritas' => 'Medium',
                    'ukuran' => '12.4 MB',
                    'tanggal_rilis' => '2024-01-05',
                    'deskripsi' => 'Peningkatan performa sistem dan optimasi database untuk pengalaman pengguna yang lebih baik.',
                    'jumlah_unduhan' => 890
                ],
                [
                    'id' => 4,
                    'nama_paket' => 'UI/UX Improvements',
                    'versi' => '3.1.2',
                    'prioritas' => 'Low',
                    'ukuran' => '5.8 MB',
                    'tanggal_rilis' => '2023-12-28',
                    'deskripsi' => 'Perbaikan antarmuka pengguna dan pengalaman pengguna untuk kemudahan navigasi.',
                    'jumlah_unduhan' => 650
                ]
            ]
        ];
        
        return view('admin/patch', $data);
    }
    
    public function panduan()
    {
        $data = [
            'title' => 'Panduan - INLISLite v3',
            'page_title' => 'Panduan Penggunaan',
            'page_subtitle' => 'Dokumentasi dan panduan sistem',
            'documents' => [
                [
                    'id' => 1,
                    'title' => 'Panduan Instalasi INLISLite v3',
                    'description' => 'Langkah-langkah lengkap instalasi sistem INLISLite v3 pada server PHP dengan konfigurasi database MySQL.',
                    'file_size' => '2.5 MB',
                    'version' => '3.0'
                ],
                [
                    'id' => 2,
                    'title' => 'Konfigurasi Sistem dan Database',
                    'description' => 'Panduan konfigurasi sistem, pengaturan database, dan optimasi performa untuk instalasi INLISLite v3.',
                    'file_size' => '1.8 MB',
                    'version' => '3.0'
                ],
                [
                    'id' => 3,
                    'title' => 'Manajemen Pengguna dan Hak Akses',
                    'description' => 'Cara mengelola pengguna sistem, mengatur role dan permission, serta konfigurasi keamanan akses.',
                    'file_size' => '3.2 MB',
                    'version' => '3.0'
                ],
                [
                    'id' => 4,
                    'title' => 'Katalogisasi dan Metadata',
                    'description' => 'Panduan lengkap katalogisasi bahan pustaka, input metadata, dan standar MARC21 dalam INLISLite v3.',
                    'file_size' => '4.1 MB',
                    'version' => '3.0'
                ],
                [
                    'id' => 5,
                    'title' => 'Sirkulasi dan Peminjaman',
                    'description' => 'Panduan operasional sirkulasi, peminjaman, pengembalian, dan manajemen denda dalam sistem.',
                    'file_size' => '2.9 MB',
                    'version' => '3.0'
                ],
                [
                    'id' => 6,
                    'title' => 'Laporan dan Statistik',
                    'description' => 'Cara membuat laporan, analisis statistik, dan export data dalam berbagai format untuk keperluan administrasi.',
                    'file_size' => '3.7 MB',
                    'version' => '3.0'
                ]
            ]
        ];
        
        return view('admin/panduan', $data);
    }
    
    public function dukungan()
    {
        $data = [
            'title' => 'Layanan Dukungan Teknis - INLISLite v3',
            'page_title' => 'Layanan Dukungan Teknis',
            'page_subtitle' => 'Pusat bantuan dan dukungan teknis untuk sistem INLISLite v3'
        ];
        
        return view('admin/dukungan', $data);
    }
    
    public function bimbingan()
    {
        $data = [
            'title' => 'Bimbingan Teknis - INLISLite v3',
            'page_title' => 'Bimbingan Teknis',
            'page_subtitle' => 'Tools dan utilities untuk pengembangan dan kustomisasi sistem'
        ];
        
        return view('admin/bimbingan', $data);
    }
    
    public function profile()
    {
        try {
            // Load ProfileModel
            $profileModel = new \App\Models\ProfileModel();
            
            // Get current user profile (for now, get admin profile)
            // In a real application, you would get this from session
            $currentProfile = $profileModel->getByUsername('admin');
            
            if (!$currentProfile) {
                // If no profile found, create a default one
                $currentProfile = [
                    'id' => 1,
                    'nama' => 'Administrator',
                    'nama_lengkap' => 'Administrator Sistem',
                    'nama_pengguna' => 'admin',
                    'username' => 'admin',
                    'email' => 'admin@inlislite.com',
                    'role' => 'Super Admin',
                    'status' => 'Aktif',
                    'foto' => null,
                    'last_login' => null,
                    'phone' => null,
                    'address' => null,
                    'bio' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
            
            // Format the profile data
            $formattedProfile = $profileModel->getFormattedProfile($currentProfile['id']);
            
            $data = [
                'title' => 'User Profile - INLISLite v3.0',
                'page_title' => 'User Profile',
                'page_subtitle' => 'Manage your account information and settings',
                'user' => $formattedProfile ?: $currentProfile
            ];
            
        } catch (\Exception $e) {
            // Handle database errors gracefully (e.g., table doesn't exist)
            log_message('error', 'Profile page error: ' . $e->getMessage());
            
            // Create default profile data when database is not available
            $defaultProfile = [
                'id' => 1,
                'nama' => 'Administrator',
                'nama_lengkap' => 'Administrator Sistem',
                'nama_pengguna' => 'admin',
                'username' => 'admin',
                'email' => 'admin@inlislite.com',
                'role' => 'Super Admin',
                'status' => 'Aktif',
                'foto' => null,
                'foto_url' => null,
                'last_login' => null,
                'last_login_formatted' => 'Belum pernah login',
                'phone' => null,
                'address' => null,
                'bio' => null,
                'avatar_initials' => 'AD',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at_formatted' => date('d M Y, H:i')
            ];
            
            $data = [
                'title' => 'User Profile - INLISLite v3.0',
                'page_title' => 'User Profile',
                'page_subtitle' => 'Manage your account information and settings',
                'user' => $defaultProfile,
                'database_error' => true
            ];
        }
        
        return view('admin/profile', $data);
    }
    
    public function updateProfile()
    {
        try {
            $profileModel = new \App\Models\ProfileModel();
            
            // Get current user profile
            $currentProfile = $profileModel->getByUsername('admin');
            
            if (!$currentProfile) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Profile not found'
                ]);
            }
            
            // Get form data
            $nama_lengkap = $this->request->getPost('nama_lengkap');
            $nama_pengguna = $this->request->getPost('nama_pengguna');
            
            // Validate input
            if (empty($nama_lengkap) || empty($nama_pengguna)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'All fields are required'
                ]);
            }
            
            // Check if username is unique (excluding current user)
            $existingUser = $profileModel->where('username', $nama_pengguna)
                                       ->where('id !=', $currentProfile['id'])
                                       ->first();
            
            if ($existingUser) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Username already exists'
                ]);
            }
            
            // Update profile
            $updateData = [
                'nama' => $nama_lengkap,
                'nama_lengkap' => $nama_lengkap,
                'username' => $nama_pengguna,
                'nama_pengguna' => $nama_pengguna,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $result = $profileModel->update($currentProfile['id'], $updateData);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Profile updated successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update profile'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Update profile error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Database error: Profile table not available. Please contact administrator.'
            ]);
        }
    }
    
    public function changePassword()
    {
        try {
            $profileModel = new \App\Models\ProfileModel();
            
            // Get current user profile
            $currentProfile = $profileModel->getByUsername('admin');
            
            if (!$currentProfile) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Profile not found'
                ]);
            }
            
            // Get form data
            $currentPassword = $this->request->getPost('current_password');
            $newPassword = $this->request->getPost('kata_sandi');
            $confirmPassword = $this->request->getPost('confirm_password');
            
            // Validate input
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'All password fields are required'
                ]);
            }
            
            // Check if new passwords match
            if ($newPassword !== $confirmPassword) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'New passwords do not match'
                ]);
            }
            
            // Verify current password
            if (!$profileModel->verifyPassword($currentProfile['id'], $currentPassword)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ]);
            }
            
            // Validate new password strength
            if (strlen($newPassword) < 6) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'New password must be at least 6 characters long'
                ]);
            }
            
            // Update password
            $result = $profileModel->changePassword($currentProfile['id'], $newPassword);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Password changed successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to change password'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Change password error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Database error: Profile table not available. Please contact administrator.'
            ]);
        }
    }
}