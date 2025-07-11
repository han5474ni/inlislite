<?php

namespace App\Libraries;

use Config\Database;
use Config\Replication;

/**
 * Database Replication Library
 * 
 * This library provides methods to work with MySQL replication
 * in the INLISLite application.
 */
class DatabaseReplication
{
    /**
     * @var \Config\Replication
     */
    protected $config;
    
    /**
     * @var \CodeIgniter\Database\BaseConnection
     */
    protected $masterConnection;
    
    /**
     * @var array of \CodeIgniter\Database\BaseConnection
     */
    protected $slaveConnections = [];
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->config = new Replication();
        
        // Only initialize if replication is enabled
        if ($this->config->enabled) {
            $this->initConnections();
        }
    }
    
    /**
     * Initialize database connections
     */
    protected function initConnections()
    {
        // Initialize master connection
        $db = \Config\Database::connect();
        $this->masterConnection = $db;
        
        // Initialize slave connections if in master-slave mode
        if ($this->config->mode === 'master-slave' && !empty($this->config->slaves)) {
            foreach ($this->config->slaves as $slaveConfig) {
                // Create a custom group for this slave
                $customGroup = 'slave_' . $slaveConfig['server_id'];
                
                // Add the configuration to the database config
                $dbConfig = new Database();
                $dbConfig->{$customGroup} = [
                    'DSN'          => '',
                    'hostname'     => $slaveConfig['hostname'],
                    'username'     => $slaveConfig['username'],
                    'password'     => $slaveConfig['password'],
                    'database'     => $slaveConfig['database'],
                    'DBDriver'     => $slaveConfig['DBDriver'],
                    'DBPrefix'     => '',
                    'pConnect'     => false,
                    'DBDebug'      => true,
                    'charset'      => 'utf8mb4',
                    'DBCollat'     => 'utf8mb4_unicode_ci',
                    'swapPre'      => '',
                    'encrypt'      => false,
                    'compress'     => false,
                    'strictOn'     => false,
                    'failover'     => [],
                    'port'         => $slaveConfig['port'],
                ];
                
                // Connect to this slave
                $this->slaveConnections[] = \Config\Database::connect($customGroup);
            }
        }
    }
    
    /**
     * Get a connection to the master database
     * 
     * @return \CodeIgniter\Database\BaseConnection
     */
    public function getMaster()
    {
        return $this->masterConnection;
    }
    
    /**
     * Get a connection to a slave database
     * Uses round-robin to distribute load among slaves
     * 
     * @return \CodeIgniter\Database\BaseConnection
     */
    public function getSlave()
    {
        if (empty($this->slaveConnections)) {
            // If no slaves configured or not in master-slave mode, return master
            return $this->masterConnection;
        }
        
        // Simple round-robin selection
        static $lastIndex = -1;
        $lastIndex = ($lastIndex + 1) % count($this->slaveConnections);
        
        return $this->slaveConnections[$lastIndex];
    }
    
    /**
     * Get a read connection
     * In master-slave mode, returns a slave connection
     * In master-master mode, returns any available master
     * 
     * @return \CodeIgniter\Database\BaseConnection
     */
    public function getReadConnection()
    {
        if ($this->config->mode === 'master-slave' && !empty($this->slaveConnections)) {
            return $this->getSlave();
        }
        
        return $this->getMaster();
    }
    
    /**
     * Get a write connection
     * Always returns the master connection
     * 
     * @return \CodeIgniter\Database\BaseConnection
     */
    public function getWriteConnection()
    {
        return $this->getMaster();
    }
    
    /**
     * Check replication status
     * 
     * @return array Status information
     */
    public function checkStatus()
    {
        $status = [
            'enabled' => $this->config->enabled,
            'mode' => $this->config->mode,
            'master' => [
                'connected' => false,
                'info' => []
            ],
            'slaves' => []
        ];
        
        // Check master status
        if ($this->masterConnection) {
            try {
                $status['master']['connected'] = true;
                
                // Get master status
                $query = $this->masterConnection->query("SHOW MASTER STATUS");
                $status['master']['info'] = $query->getRowArray();
            } catch (\Exception $e) {
                $status['master']['error'] = $e->getMessage();
            }
        }
        
        // Check slave status
        foreach ($this->slaveConnections as $index => $slave) {
            $slaveStatus = [
                'index' => $index,
                'connected' => false,
                'info' => []
            ];
            
            try {
                $slaveStatus['connected'] = true;
                
                // Get slave status
                $query = $slave->query("SHOW SLAVE STATUS");
                $slaveStatus['info'] = $query->getRowArray();
                
                // Check if slave is running properly
                $slaveStatus['running'] = (
                    isset($slaveStatus['info']['Slave_IO_Running']) && 
                    $slaveStatus['info']['Slave_IO_Running'] === 'Yes' && 
                    isset($slaveStatus['info']['Slave_SQL_Running']) && 
                    $slaveStatus['info']['Slave_SQL_Running'] === 'Yes'
                );
            } catch (\Exception $e) {
                $slaveStatus['error'] = $e->getMessage();
            }
            
            $status['slaves'][] = $slaveStatus;
        }
        
        return $status;
    }
    
    /**
     * Check if replication is enabled
     * 
     * @return bool
     */
    public function isEnabled()
    {
        return $this->config->enabled;
    }
    
    /**
     * Get replication mode
     * 
     * @return string 'master-slave' or 'master-master'
     */
    public function getMode()
    {
        return $this->config->mode;
    }
}