<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TentangCardModel;

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
        // Load models
        $userModel = new \App\Models\UserModel();
        $registrationModel = model('RegistrationModel');
        $fiturModel = model('FiturModel'); 
        $db = \Config\Database::connect();
        
        // Get user statistics
        $totalUsers = $userModel->countAll();
        $activeUsers = $userModel->where('status', 'Aktif')->countAllResults();
        $adminUsers = $userModel->whereIn('role', ['Super Admin', 'Admin'])->countAllResults();
        $todayLogins = $userModel->where('DATE(last_login) =', date('Y-m-d'))->countAllResults();
        
        // Get registration statistics
        $totalRegistrations = 0;
        $activeRegistrations = 0;
        $thisWeekRegistrations = 0;
        $pendingRegistrations = 0;
        
        if ($db->tableExists('registrations')) {
            $totalRegistrations = $registrationModel->countAll();
            $activeRegistrations = $registrationModel->where('status', 'active')->countAllResults();
            $thisWeekStart = date('Y-m-d', strtotime('-7 days'));
            $thisWeekRegistrations = $registrationModel->where('created_at >=', $thisWeekStart)->countAllResults();
            $pendingRegistrations = $registrationModel->where('status', 'pending')->countAllResults();
        }
        
        // Get features statistics
        $totalFeatures = 0;
        $activeFeatures = 0;
        
        if ($db->tableExists('fitur')) {
            $totalFeatures = $fiturModel->countAll();
            $activeFeatures = $fiturModel->where('status', 'active')->countAllResults();
        }
        
        // Get current user info
        $session = session();
        $currentUser = [
            'name' => $session->get('admin_nama_lengkap') ?? 'Administrator',
            'role' => $session->get('admin_role') ?? 'Super Admin',
            'status' => 'Online',
            'last_login' => $session->get('admin_last_login'),
            'photo' => $session->get('admin_photo'),
            'created_at' => $session->get('admin_created_at')
        ];
        
        // Get recent registrations
        $recentRegistrations = [];
        if ($db->tableExists('registrations')) {
            $recentRegistrations = $registrationModel->orderBy('created_at', 'DESC')->limit(5)->findAll();
        }
        
        // Get recent users
        $recentUsers = $userModel->orderBy('created_at', 'DESC')->limit(5)->findAll();
        
        $chartData = $this->_getChartData();

        $data = [
            'title' => 'Admin Dashboard - INLISLite v3',
            'page_title' => 'Admin Dashboard',
            'page_subtitle' => 'Kelola sistem perpustakaan Anda dengan data real-time',
            'userStats' => [
                'total' => $totalUsers,
                'active' => $activeUsers,
                'admin' => $adminUsers,
                'today_logins' => $todayLogins
            ],
            'registrationStats' => [
                'total' => $totalRegistrations,
                'active' => $activeRegistrations,
                'this_week' => $thisWeekRegistrations,
                'pending' => $pendingRegistrations
            ],
            'featureStats' => [
                'total' => $totalFeatures,
                'active' => $activeFeatures
            ],
            'currentUser' => $currentUser,
            'recentRegistrations' => $recentRegistrations,
            'recentUsers' => $recentUsers,
            'chartData' => $chartData
        ];
        
        return view('admin/dashboard', $data);
    }

    private function _getChartData()
    {
        $userModel = new \App\Models\UserModel();
        $registrationModel = model('RegistrationModel');
        $db = \Config\Database::connect();

        $labels = [];
        $users = [];
        $registrations = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $labels[] = date('M d', strtotime($date));

            // Get user count
            $userCount = $userModel->where('DATE(created_at)', $date)->countAllResults();
            $users[] = $userCount;

            // Get registration count
            $regCount = 0;
            if ($db->tableExists('registrations')) {
                $regCount = $registrationModel->where('DATE(created_at)', $date)->countAllResults();
            }
            $registrations[] = $regCount;
        }

        return [
            'labels' => $labels,
            'users' => $users,
            'registrations' => $registrations,
        ];
    }

    public function getLastLogin()
    {
        $session = session();
        $lastLogin = $session->get('admin_last_login');

        if ($lastLogin) {
            return $this->response->setJSON(['last_login' => $lastLogin]);
        }

        return $this->response->setJSON(['last_login' => null]);
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
    
    public function patch()
    {
        return $this->patch_updater();
    }
    
    /**
     * Show patch edit page
     */
    public function patchEdit()
    {
        $data = [
            'title' => 'Manajemen Patch & Updater - INLISlite v3.0'
        ];
        
        return view('admin/patch-edit', $data);
    }
    
    /**
     * Show aplikasi edit page
     */
    public function aplikasiEdit()
    {
        $data = [
            'title' => 'Manajemen Aplikasi Pendukung - INLISlite v3.0'
        ];
        
        return view('admin/aplikasi-edit', $data);
    }
    
    /**
     * Show panduan edit page
     */
    public function panduanEdit()
    {
        $data = [
            'title' => 'Manajemen Panduan - INLISlite v3.0'
        ];
        
        return view('admin/panduan-edit', $data);
    }
    
    /**
     * Show dukungan edit page
     */
    public function dukunganEdit()
    {
        $data = [
            'title' => 'Manajemen Dukungan Teknis - INLISlite v3.0'
        ];
        
        return view('admin/dukungan-edit', $data);
    }
    
    /**
     * Show bimbingan edit page
     */
    public function bimbinganEdit()
    {
        $data = [
            'title' => 'Manajemen Bimbingan Teknis - INLISlite v3.0'
        ];
        
        return view('admin/bimbingan-edit', $data);
    }
    
    /**
     * Show demo edit page
     */
    public function demoEdit()
    {
        $data = [
            'title' => 'Manajemen Demo Program - INLISlite v3.0'
        ];
        
        return view('admin/demo-edit', $data);
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
    
    public function demo()
    {
        $data = [
            'title' => 'Demo Program - INLISlite v3.0',
            'page_title' => 'Demo Program',
            'page_subtitle' => 'Explore INLISLite features and modules through online demo'
        ];
        
        return view('admin/demo', $data);
    }
    
    public function aplikasi()
    {
        $data = [
            'title' => 'Aplikasi Pendukung - INLISlite v3.0',
            'page_title' => 'Aplikasi Pendukung',
            'page_subtitle' => 'Supporting applications and tools for INLISLite system'
        ];
        
        return view('admin/aplikasi', $data);
    }
    
    public function registration()
    {
        // Sample registration data
        $registrations = [
            [
                'id' => 1,
                'library_name' => 'Perpustakaan Nasional RI',
                'library_type' => 'National',
                'province' => 'DKI Jakarta',
                'status' => 'Active',
                'created_at' => '2024-01-15 10:30:00',
                'updated_at' => '2024-01-15 10:30:00'
            ],
            [
                'id' => 2,
                'library_name' => 'Perpustakaan Universitas Indonesia',
                'library_type' => 'Academic',
                'province' => 'Jawa Barat',
                'status' => 'Active',
                'created_at' => '2024-01-14 14:20:00',
                'updated_at' => '2024-01-14 14:20:00'
            ],
            [
                'id' => 3,
                'library_name' => 'Perpustakaan Kota Bandung',
                'library_type' => 'Public',
                'province' => 'Jawa Barat',
                'status' => 'Pending',
                'created_at' => '2024-01-13 09:15:00',
                'updated_at' => '2024-01-13 09:15:00'
            ]
        ];
        
        // Calculate statistics
        $stats = [
            'total' => count($registrations),
            'active' => count(array_filter($registrations, fn($r) => $r['status'] === 'Active')),
            'inactive' => count(array_filter($registrations, fn($r) => $r['status'] === 'Inactive')),
            'pending' => count(array_filter($registrations, fn($r) => $r['status'] === 'Pending'))
        ];
        
        $data = [
            'title' => 'Inlislite Registration - INLISlite v3.0',
            'page_title' => 'Inlislite Registration',
            'page_subtitle' => 'Manage and monitor library registration data',
            'registrations' => $registrations,
            'stats' => $stats
        ];
        
        return view('admin/registration', $data);
    }
    
    public function profile()
    {
        try {
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
                'user' => $defaultProfile
            ];
            
        } catch (\Exception $e) {
            log_message('error', 'Profile page error: ' . $e->getMessage());
            
            $data = [
                'title' => 'User Profile - INLISLite v3.0',
                'page_title' => 'User Profile',
                'page_subtitle' => 'Manage your account information and settings',
                'user' => [
                    'id' => 1,
                    'nama' => 'Administrator',
                    'email' => 'admin@inlislite.com',
                    'role' => 'Super Admin'
                ],
                'database_error' => true
            ];
        }
        
        return view('admin/profile', $data);
    }

    /**
     * Show tentang edit page
     */
    public function tentangEdit()
    {
        $data = [
            'title' => 'Kelola Kartu Tentang - INLISlite v3.0'
        ];
        
        return view('admin/tentang-edit', $data);
    }

    /**
     * Get all tentang cards
     */
    public function getTentangCards()
    {
        try {
            // Initialize TentangCardModel
            $cardModel = new TentangCardModel();
            $cards = $cardModel->orderBy('id', 'ASC')
                             ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'cards' => $cards
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Failed to get tentang cards: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to load tentang cards'
            ]);
        }
    }

    /**
     * Reorder card IDs to be sequential starting from 1
     */
    private function reorderCardIds()
    {
        try {
            $db = \Config\Database::connect();
            
            // Get all cards ordered by sort_order and created_at
            $query = $db->query("SELECT id FROM tentang_cards ORDER BY sort_order ASC, created_at ASC");
            $cards = $query->getResultArray();
            
            if (empty($cards)) {
                return true; // No cards to reorder
            }
            
            // Start transaction
            $db->transStart();
            
            // Temporarily rename IDs to avoid conflicts
            $tempOffset = 10000;
            foreach ($cards as $index => $card) {
                $tempId = $tempOffset + $index + 1;
                $db->query("UPDATE tentang_cards SET id = ? WHERE id = ?", [$tempId, $card['id']]);
            }
            
            // Now assign sequential IDs starting from 1
            foreach ($cards as $index => $card) {
                $newId = $index + 1;
                $tempId = $tempOffset + $index + 1;
                $db->query("UPDATE tentang_cards SET id = ? WHERE id = ?", [$newId, $tempId]);
            }
            
            // Reset AUTO_INCREMENT to next available ID
            $nextId = count($cards) + 1;
            $db->query("ALTER TABLE tentang_cards AUTO_INCREMENT = ?", [$nextId]);
            
            // Complete transaction
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                log_message('error', 'Failed to reorder card IDs - transaction failed');
                return false;
            }
            
            log_message('info', 'Successfully reordered card IDs');
            return true;
            
        } catch (\Exception $e) {
            log_message('error', 'Error reordering card IDs: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new tentang card with automatic ID reordering
     */
    public function createCard()
    {
        try {
            // Try multiple ways to get input data
            $input = $this->request->getJSON(true);
            if (!$input) {
                $input = $this->request->getPost();
            }
            if (!$input) {
                $input = json_decode(file_get_contents('php://input'), true);
            }
            
            // Validate required fields
            if (empty($input['title']) || empty($input['content'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Judul dan konten kartu harus diisi'
                ]);
            }

            // Map frontend fields to database fields
            $cardData = [
                'title' => $input['title'],
                'subtitle' => $input['subtitle'] ?: null,
                'content' => $input['content'],
                'card_type' => $input['category'] ?: 'info',
                'icon' => $input['icon'] ?: null,
                'is_active' => $input['status'] === 'active' ? 1 : 0,
                'sort_order' => $input['sort_order'] ?: 1,
                'card_size' => 'medium',
                'is_featured' => 0,
                'card_key' => uniqid('card_', true)
            ];

            $cardModel = new TentangCardModel();
            $cardId = $cardModel->insert($cardData);

            if ($cardId) {
                // Reorder IDs after insertion
                $this->reorderCardIds();
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Kartu berhasil ditambahkan dan ID telah diurutkan ulang',
                    'card_id' => $cardId
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan kartu tentang'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Failed to create tentang card: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan kartu'
            ]);
        }
    }

    /**
     * Update tentang card
     */
    public function updateCard()
    {
        try {
            $input = $this->request->getJSON(true);
            
            // Validate required fields
            if (empty($input['id']) || empty($input['title']) || empty($input['content'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID, judul dan konten kartu harus diisi'
                ]);
            }

            $cardModel = new TentangCardModel();
            
            // Check if card exists
            $existingCard = $cardModel->find($input['id']);
            if (!$existingCard) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Kartu tidak ditemukan'
                ]);
            }
            
            // Map frontend fields to database fields
            $cardData = [
                'title' => $input['title'],
                'subtitle' => $input['subtitle'] ?: null,
                'content' => $input['content'],
                'card_type' => $input['category'] ?: 'info',
                'icon' => $input['icon'] ?: null,
                'is_active' => $input['status'] === 'active' ? 1 : 0,
                'sort_order' => $input['sort_order'] ?: 1
            ];
            
            // Add card_key if it doesn't exist
            if (empty($existingCard['card_key'])) {
                $cardData['card_key'] = uniqid('card_', true);
                log_message('info', 'Generated new card_key for card ID: ' . $input['id']);
            }
            
            $updated = $cardModel->update($input['id'], $cardData);
            
            if ($updated) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Kartu tentang berhasil diperbarui'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui kartu tentang'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Failed to update tentang card: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui kartu'
            ]);
        }
    }

    /**
     * Delete tentang card with automatic ID reordering
     */
    public function deleteCard()
    {
        try {
            $input = $this->request->getJSON(true);
            
            // Validate required fields
            if (empty($input['id'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID kartu harus diisi'
                ]);
            }

            $cardModel = new TentangCardModel();
            
            // Check if card exists
            $existingCard = $cardModel->find($input['id']);
            if (!$existingCard) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Kartu tidak ditemukan'
                ]);
            }

            // Delete the card
            $deleted = $cardModel->delete($input['id']);

            if ($deleted) {
                // Reorder IDs after deletion
                $this->reorderCardIds();
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Kartu tentang berhasil dihapus dan ID telah diurutkan ulang'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus kartu tentang'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Failed to delete tentang card: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus kartu'
            ]);
        }
    }

    /**
     * Update tentang card (legacy method name)
     */
    public function updateTentangCard()
    {
        return $this->updateCard();
    }

    /**
     * Delete tentang card (legacy method name)
     */
    public function deleteTentangCard()
    {
        return $this->deleteCard();
    }
}