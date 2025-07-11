<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\DatabaseReplication;

/**
 * Replication Controller
 * 
 * Controller for managing database replication in the admin panel
 */
class ReplicationController extends BaseController
{
    /**
     * @var DatabaseReplication
     */
    protected $replication;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->replication = new DatabaseReplication();
    }
    
    /**
     * Display replication dashboard
     */
    public function index()
    {
        // Check if user has permission to access this page
        if (!isAdmin()) {
            return redirect()->to('/admin/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        // Get replication status
        $data = [
            'title' => 'Database Replication',
            'replication' => $this->replication,
            'status' => $this->replication->checkStatus(),
        ];
        
        return view('admin/replication/dashboard', $data);
    }
    
    /**
     * Display replication settings
     */
    public function settings()
    {
        // Check if user has permission to access this page
        if (!isAdmin()) {
            return redirect()->to('/admin/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        // Get replication config
        $replicationConfig = new \Config\Replication();
        
        $data = [
            'title' => 'Replication Settings',
            'config' => $replicationConfig,
        ];
        
        return view('admin/replication/settings', $data);
    }
    
    /**
     * Update replication settings
     */
    public function updateSettings()
    {
        // Check if user has permission to access this page
        if (!isAdmin()) {
            return redirect()->to('/admin/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        // Validate input
        $rules = [
            'enabled' => 'required|in_list[0,1]',
            'mode' => 'required|in_list[master-slave,master-master]',
            'master_hostname' => 'required',
            'master_username' => 'required',
            'master_password' => 'required',
            'master_database' => 'required',
            'master_port' => 'required|numeric',
            'master_server_id' => 'required|numeric',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Get form data
        $enabled = $this->request->getPost('enabled') == '1';
        $mode = $this->request->getPost('mode');
        $master = [
            'hostname' => $this->request->getPost('master_hostname'),
            'username' => $this->request->getPost('master_username'),
            'password' => $this->request->getPost('master_password'),
            'database' => $this->request->getPost('master_database'),
            'DBDriver' => 'MySQLi',
            'port' => (int)$this->request->getPost('master_port'),
            'server_id' => (int)$this->request->getPost('master_server_id'),
        ];
        
        // Get slave data if provided
        $slaves = [];
        $slaveCount = (int)$this->request->getPost('slave_count');
        
        for ($i = 0; $i < $slaveCount; $i++) {
            if ($this->request->getPost('slave_' . $i . '_hostname')) {
                $slaves[] = [
                    'hostname' => $this->request->getPost('slave_' . $i . '_hostname'),
                    'username' => $this->request->getPost('slave_' . $i . '_username'),
                    'password' => $this->request->getPost('slave_' . $i . '_password'),
                    'database' => $this->request->getPost('slave_' . $i . '_database'),
                    'DBDriver' => 'MySQLi',
                    'port' => (int)$this->request->getPost('slave_' . $i . '_port'),
                    'server_id' => (int)$this->request->getPost('slave_' . $i . '_server_id'),
                    'read_only' => true,
                ];
            }
        }
        
        // Get tables to replicate/exclude
        $tables = explode(',', $this->request->getPost('tables'));
        $tables = array_map('trim', $tables);
        $tables = array_filter($tables);
        
        $excludeTables = explode(',', $this->request->getPost('exclude_tables'));
        $excludeTables = array_map('trim', $excludeTables);
        $excludeTables = array_filter($excludeTables);
        
        // Update configuration file
        $configPath = APPPATH . 'Config/Replication.php';
        $configContent = file_get_contents($configPath);
        
        // Update enabled status
        $configContent = preg_replace(
            '/public bool \$enabled = (true|false);/',
            'public bool \$enabled = ' . ($enabled ? 'true' : 'false') . ';',
            $configContent
        );
        
        // Update mode
        $configContent = preg_replace(
            '/public string \$mode = \'(.*?)\';/',
            "public string \$mode = '$mode';",
            $configContent
        );
        
        // Update master config
        $masterConfig = "public array \$master = [\n";
        $masterConfig .= "        'hostname'     => '{$master['hostname']}',\n";
        $masterConfig .= "        'username'     => '{$master['username']}',\n";
        $masterConfig .= "        'password'     => '{$master['password']}',\n";
        $masterConfig .= "        'database'     => '{$master['database']}',\n";
        $masterConfig .= "        'DBDriver'     => '{$master['DBDriver']}',\n";
        $masterConfig .= "        'port'         => {$master['port']},\n";
        $masterConfig .= "        'server_id'    => {$master['server_id']},\n";
        $masterConfig .= "    ];";
        
        $configContent = preg_replace(
            '/public array \$master = \[.*?\];/s',
            $masterConfig,
            $configContent
        );
        
        // Update slaves config
        $slavesConfig = "public array \$slaves = [\n";
        foreach ($slaves as $slave) {
            $slavesConfig .= "        [\n";
            $slavesConfig .= "            'hostname'     => '{$slave['hostname']}',\n";
            $slavesConfig .= "            'username'     => '{$slave['username']}',\n";
            $slavesConfig .= "            'password'     => '{$slave['password']}',\n";
            $slavesConfig .= "            'database'     => '{$slave['database']}',\n";
            $slavesConfig .= "            'DBDriver'     => '{$slave['DBDriver']}',\n";
            $slavesConfig .= "            'port'         => {$slave['port']},\n";
            $slavesConfig .= "            'server_id'    => {$slave['server_id']},\n";
            $slavesConfig .= "            'read_only'    => true,\n";
            $slavesConfig .= "        ],\n";
        }
        $slavesConfig .= "    ];";
        
        $configContent = preg_replace(
            '/public array \$slaves = \[.*?\];/s',
            $slavesConfig,
            $configContent
        );
        
        // Update tables config
        $tablesConfig = "public array \$tables = [\n";
        foreach ($tables as $table) {
            $tablesConfig .= "        '{$table}',\n";
        }
        $tablesConfig .= "    ];";
        
        $configContent = preg_replace(
            '/public array \$tables = \[.*?\];/s',
            $tablesConfig,
            $configContent
        );
        
        // Update exclude tables config
        $excludeTablesConfig = "public array \$excludeTables = [\n";
        foreach ($excludeTables as $table) {
            $excludeTablesConfig .= "        '{$table}',\n";
        }
        $excludeTablesConfig .= "    ];";
        
        $configContent = preg_replace(
            '/public array \$excludeTables = \[.*?\];/s',
            $excludeTablesConfig,
            $configContent
        );
        
        // Save updated config
        file_put_contents($configPath, $configContent);
        
        return redirect()->to('/admin/replication')->with('success', 'Pengaturan replikasi berhasil diperbarui.');
    }
    
    /**
     * Check replication status via AJAX
     */
    public function checkStatus()
    {
        // Check if user has permission to access this page
        if (!isAdmin()) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }
        
        $status = $this->replication->checkStatus();
        
        return $this->response->setJSON($status);
    }
    
    /**
     * Test connection to a database server
     */
    public function testConnection()
    {
        // Check if user has permission to access this page
        if (!isAdmin()) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }
        
        // Get connection details
        $hostname = $this->request->getPost('hostname');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $database = $this->request->getPost('database');
        $port = (int)$this->request->getPost('port');
        
        // Test connection
        try {
            $conn = new \mysqli($hostname, $username, $password, $database, $port);
            
            if ($conn->connect_error) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Connection failed: ' . $conn->connect_error
                ]);
            }
            
            // Get server info
            $serverInfo = [
                'version' => $conn->server_info,
                'server_id' => null,
                'binary_logging' => false,
            ];
            
            // Check server_id
            $result = $conn->query("SELECT @@server_id as server_id");
            if ($result) {
                $row = $result->fetch_assoc();
                $serverInfo['server_id'] = $row['server_id'];
            }
            
            // Check if binary logging is enabled
            $result = $conn->query("SHOW VARIABLES LIKE 'log_bin'");
            if ($result) {
                $row = $result->fetch_assoc();
                $serverInfo['binary_logging'] = ($row['Value'] === 'ON');
            }
            
            $conn->close();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Connection successful',
                'server_info' => $serverInfo
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ]);
        }
    }
}