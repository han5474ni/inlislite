<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InstallerModel;
use App\Models\InstallerSettingsModel;
use App\Models\InstallerCardModel;
use Config\Database;

class InstallerController extends BaseController
{
    protected $db;
    protected $installerModel;
    protected $settingsModel;
    protected $cardModel;
    
    public function __construct()
    {
        $this->db = Database::connect();
        $this->installerModel = new InstallerModel();
        $this->settingsModel = new InstallerSettingsModel();
        $this->cardModel = new InstallerCardModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Installer - INLISlite v3.0'
        ];
        
        return view('admin/installer', $data);
    }

    /**
     * Show installer edit page
     */
    public function edit()
    {
        $data = [
            'title' => 'Kelola Kartu Installer - INLISlite v3.0'
        ];
        
        return view('admin/installer-edit', $data);
    }

    /**
     * Get installer data for the page
     */
    public function getData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            $settings = $this->settingsModel->getAllSettings();
            $downloadStats = $this->installerModel->getDownloadStats();

            $data = [
                'success' => true,
                'version' => $settings['installer_version'] ?? '3.2',
                'revisionDate' => $settings['installer_revision_date'] ?? '10 Februari 2021',
                'fileSizes' => [
                    'source' => $settings['source_package_size'] ?? '25 MB',
                    'php' => $settings['php_package_size'] ?? '20 MB',
                    'sql' => $settings['sql_package_size'] ?? '2 MB'
                ],
                'downloadStats' => $downloadStats,
                'systemRequirements' => $settings['system_requirements'] ?? [],
                'defaultCredentials' => $settings['default_credentials'] ?? [],
                'installationSteps' => $settings['installation_steps'] ?? []
            ];

            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            log_message('error', 'Failed to get installer data: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to load installer data'
            ]);
        }
    }

    /**
     * Save download record to database
     */
    public function saveDownload()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            $input = $this->request->getJSON(true);
            
            // Validate required fields
            if (!isset($input['package_type']) || !isset($input['filename'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Missing required fields'
                ]);
            }

            // Prepare download data
            $downloadData = [
                'package_type' => $input['package_type'],
                'filename' => $input['filename'],
                'file_size' => $input['file_size'] ?? null,
                'description' => $input['description'] ?? null,
                'download_date' => $input['download_date'] ?? date('Y-m-d H:i:s'),
                'user_agent' => $input['user_agent'] ?? $this->request->getUserAgent(),
                'ip_address' => $input['ip_address'] ?? $this->request->getIPAddress(),
                'session_id' => session_id(),
                'referrer' => $this->request->getServer('HTTP_REFERER')
            ];

            // Record the download
            $downloadId = $this->installerModel->recordDownload($downloadData);

            // Update download statistics
            $this->settingsModel->updateDownloadStats($input['package_type']);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Download recorded successfully',
                'download_id' => $downloadId
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Failed to save download: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to record download'
            ]);
        }
    }

    /**
     * Get download statistics
     */
    public function getDownloadStats()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            $packageType = $this->request->getGet('package_type');
            $stats = $this->installerModel->getDownloadStats($packageType);

            return $this->response->setJSON([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Failed to get download stats: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to get download statistics'
            ]);
        }
    }

    /**
     * Get recent downloads
     */
    public function getRecentDownloads()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            $limit = $this->request->getGet('limit') ?? 10;
            $downloads = $this->installerModel->getRecentDownloads($limit);

            return $this->response->setJSON([
                'success' => true,
                'downloads' => $downloads
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Failed to get recent downloads: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to get recent downloads'
            ]);
        }
    }

    /**
     * Update installer settings
     */
    public function updateSettings()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            $input = $this->request->getJSON(true);
            
            foreach ($input as $key => $value) {
                $type = 'string';
                
                // Determine data type
                if (is_array($value) || is_object($value)) {
                    $type = 'json';
                } elseif (is_bool($value)) {
                    $type = 'boolean';
                } elseif (is_numeric($value)) {
                    $type = 'integer';
                }

                $this->settingsModel->setSetting($key, $value, $type);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Settings updated successfully'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Failed to update settings: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update settings'
            ]);
        }
    }

    /**
     * Get all installer cards
     */
    public function getCards()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            $cards = $this->cardModel->orderBy('sort_order', 'ASC')
                                   ->orderBy('created_at', 'DESC')
                                   ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'cards' => $cards
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Failed to get installer cards: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to load installer cards'
            ]);
        }
    }

    /**
     * Create new installer card
     */
    public function createCard()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            $input = $this->request->getJSON(true);
            
            // Validate required fields
            if (empty($input['package_name']) || empty($input['version'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nama paket dan versi harus diisi'
                ]);
            }

            // Prepare card data
            $cardData = [
                'package_name' => $input['package_name'],
                'version' => $input['version'],
                'release_date' => $input['release_date'] ?: null,
                'file_size' => $input['file_size'] ?: null,
                'download_link' => $input['download_link'] ?: null,
                'description' => $input['description'] ?: null,
                'requirements' => $input['requirements'] ?: null,
                'default_username' => $input['default_username'] ?: null,
                'default_password' => $input['default_password'] ?: null,
                'card_type' => $input['card_type'] ?: 'source',
                'status' => $input['status'] ?: 'active'
            ];

            $cardId = $this->cardModel->insert($cardData);

            if ($cardId) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Kartu installer berhasil ditambahkan',
                    'card_id' => $cardId
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan kartu installer'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Failed to create installer card: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan kartu'
            ]);
        }
    }

    /**
     * Update installer card
     */
    public function updateCard()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            $input = $this->request->getJSON(true);
            
            // Validate required fields
            if (empty($input['id']) || empty($input['package_name']) || empty($input['version'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID, nama paket dan versi harus diisi'
                ]);
            }

            // Check if card exists
            $existingCard = $this->cardModel->find($input['id']);
            if (!$existingCard) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Kartu tidak ditemukan'
                ]);
            }

            // Prepare card data
            $cardData = [
                'package_name' => $input['package_name'],
                'version' => $input['version'],
                'release_date' => $input['release_date'] ?: null,
                'file_size' => $input['file_size'] ?: null,
                'download_link' => $input['download_link'] ?: null,
                'description' => $input['description'] ?: null,
                'requirements' => $input['requirements'] ?: null,
                'default_username' => $input['default_username'] ?: null,
                'default_password' => $input['default_password'] ?: null,
                'card_type' => $input['card_type'] ?: 'source',
                'status' => $input['status'] ?: 'active'
            ];

            $updated = $this->cardModel->update($input['id'], $cardData);

            if ($updated) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Kartu installer berhasil diperbarui'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui kartu installer'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Failed to update installer card: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui kartu'
            ]);
        }
    }

    /**
     * Delete installer card
     */
    public function deleteCard()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            $input = $this->request->getJSON(true);
            
            // Validate required fields
            if (empty($input['id'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID kartu harus diisi'
                ]);
            }

            // Check if card exists
            $existingCard = $this->cardModel->find($input['id']);
            if (!$existingCard) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Kartu tidak ditemukan'
                ]);
            }

            $deleted = $this->cardModel->delete($input['id']);

            if ($deleted) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Kartu installer berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus kartu installer'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Failed to delete installer card: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus kartu'
            ]);
        }
    }

    // Legacy installer methods for backward compatibility
    public function setup()
    {
        // Check if system is already installed
        if ($this->isSystemInstalled()) {
            return redirect()->to('/admin')->with('info', 'Sistem sudah terinstall');
        }
        
        $data = [
            'title' => 'INLISLite v3 Installer',
            'step' => 'welcome'
        ];
        
        return view('admin/installer/index', $data);
    }
    
    public function requirements()
    {
        $requirements = $this->checkSystemRequirements();
        
        $data = [
            'title' => 'System Requirements - INLISLite v3 Installer',
            'step' => 'requirements',
            'requirements' => $requirements,
            'can_proceed' => $requirements['overall_status']
        ];
        
        return view('admin/installer/requirements', $data);
    }
    
    public function database()
    {
        $data = [
            'title' => 'Database Configuration - INLISLite v3 Installer',
            'step' => 'database'
        ];
        
        return view('admin/installer/database', $data);
    }
    
    public function testDatabase()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }
        
        $config = [
            'hostname' => $this->request->getPost('hostname'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'database' => $this->request->getPost('database'),
            'port' => $this->request->getPost('port') ?: 3306
        ];
        
        try {
            $testDb = Database::connect($config);
            $testDb->query('SELECT 1');
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Koneksi database berhasil!'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Koneksi database gagal: ' . $e->getMessage()
            ]);
        }
    }
    
    public function install()
    {
        if (!$this->request->isPost()) {
            return redirect()->to('/installer');
        }
        
        try {
            // Create database tables
            $this->createTables();
            
            // Create admin user
            $this->createAdminUser();
            
            // Set installation flag
            $this->setInstallationFlag();
            
            return redirect()->to('/installer/complete')->with('success', 'Instalasi berhasil!');
        } catch (\Exception $e) {
            log_message('error', 'Installation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Instalasi gagal: ' . $e->getMessage());
        }
    }
    
    public function complete()
    {
        $data = [
            'title' => 'Installation Complete - INLISLite v3',
            'step' => 'complete'
        ];
        
        return view('admin/installer/complete', $data);
    }
    
    private function checkSystemRequirements()
    {
        $requirements = [
            'php_version' => [
                'name' => 'PHP Version (>= 8.1)',
                'required' => '8.1.0',
                'current' => PHP_VERSION,
                'status' => version_compare(PHP_VERSION, '8.1.0', '>=')
            ],
            'extensions' => [
                'intl' => [
                    'name' => 'Intl Extension',
                    'status' => extension_loaded('intl')
                ],
                'mbstring' => [
                    'name' => 'Mbstring Extension',
                    'status' => extension_loaded('mbstring')
                ],
                'mysqli' => [
                    'name' => 'MySQLi Extension',
                    'status' => extension_loaded('mysqli')
                ],
                'curl' => [
                    'name' => 'cURL Extension',
                    'status' => extension_loaded('curl')
                ],
                'json' => [
                    'name' => 'JSON Extension',
                    'status' => extension_loaded('json')
                ]
            ],
            'directories' => [
                'writable' => [
                    'name' => 'Writable Directory',
                    'path' => WRITEPATH,
                    'status' => is_writable(WRITEPATH)
                ],
                'cache' => [
                    'name' => 'Cache Directory',
                    'path' => WRITEPATH . 'cache',
                    'status' => is_writable(WRITEPATH . 'cache')
                ],
                'logs' => [
                    'name' => 'Logs Directory',
                    'path' => WRITEPATH . 'logs',
                    'status' => is_writable(WRITEPATH . 'logs')
                ]
            ]
        ];
        
        // Calculate overall status
        $allPassed = true;
        $allPassed = $allPassed && $requirements['php_version']['status'];
        
        foreach ($requirements['extensions'] as $ext) {
            $allPassed = $allPassed && $ext['status'];
        }
        
        foreach ($requirements['directories'] as $dir) {
            $allPassed = $allPassed && $dir['status'];
        }
        
        $requirements['overall_status'] = $allPassed;
        
        return $requirements;
    }
    
    private function createTables()
    {
        $forge = Database::forge();
        
        // Users table
        if (!$this->db->tableExists('users')) {
            $forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true
                ],
                'nama_lengkap' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255
                ],
                'nama_pengguna' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'unique' => true
                ],
                'email' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'unique' => true
                ],
                'kata_sandi' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255
                ],
                'role' => [
                    'type' => 'ENUM',
                    'constraint' => ['Super Admin', 'Admin', 'Pustakawan', 'Staff'],
                    'default' => 'Staff'
                ],
                'status' => [
                    'type' => 'ENUM',
                    'constraint' => ['Aktif', 'Non-Aktif', 'Ditangguhkan'],
                    'default' => 'Aktif'
                ],
                'last_login' => [
                    'type' => 'DATETIME',
                    'null' => true
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ]
            ]);
            $forge->addPrimaryKey('id');
            $forge->createTable('users');
        }
        
        // Applications table
        if (!$this->db->tableExists('applications')) {
            $forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255
                ],
                'slug' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'unique' => true
                ],
                'description' => [
                    'type' => 'TEXT'
                ],
                'version' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50
                ],
                'file_size' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true
                ],
                'file_path' => [
                    'type' => 'VARCHAR',
                    'constraint' => 500,
                    'null' => true
                ],
                'icon' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'default' => 'bi-app'
                ],
                'color' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'default' => 'primary'
                ],
                'category' => [
                    'type' => 'ENUM',
                    'constraint' => ['gateway', 'utility', 'service', 'plugin'],
                    'default' => 'utility'
                ],
                'downloads' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'default' => 0
                ],
                'is_active' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 1
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ]
            ]);
            $forge->addPrimaryKey('id');
            $forge->createTable('applications');
        }
        
        // Patches table
        if (!$this->db->tableExists('patches')) {
            $forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true
                ],
                'version' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50
                ],
                'title' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255
                ],
                'description' => [
                    'type' => 'TEXT'
                ],
                'changelog' => [
                    'type' => 'TEXT',
                    'null' => true
                ],
                'file_path' => [
                    'type' => 'VARCHAR',
                    'constraint' => 500,
                    'null' => true
                ],
                'file_size' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true
                ],
                'release_date' => [
                    'type' => 'DATE'
                ],
                'is_critical' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0
                ],
                'downloads' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'default' => 0
                ],
                'is_active' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 1
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ]
            ]);
            $forge->addPrimaryKey('id');
            $forge->createTable('patches');
        }
    }
    
    private function createAdminUser()
    {
        $userModel = new \App\Models\UserModel();
        
        $adminData = [
            'nama_lengkap' => 'Administrator',
            'nama_pengguna' => 'admin',
            'email' => 'admin@inlislite.local',
            'kata_sandi' => 'admin123', // Will be hashed by model
            'role' => 'Super Admin',
            'status' => 'Aktif'
        ];
        
        $userModel->insert($adminData);
    }
    
    private function setInstallationFlag()
    {
        $flagFile = WRITEPATH . 'installed.flag';
        file_put_contents($flagFile, date('Y-m-d H:i:s'));
    }
    
    private function isSystemInstalled()
    {
        return file_exists(WRITEPATH . 'installed.flag');
    }
}