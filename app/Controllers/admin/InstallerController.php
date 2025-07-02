<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;

class InstallerController extends BaseController
{
    protected $db;
    
    public function __construct()
    {
        $this->db = Database::connect();
    }
    
    public function index()
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