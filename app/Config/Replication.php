<?php

namespace Config;

/**
 * MySQL Replication Configuration
 * 
 * This file contains configuration settings for MySQL database replication
 * in the INLISLite application.
 */
class Replication
{
    /**
     * Enable or disable replication functionality
     */
    public bool $enabled = false;
    
    /**
     * Replication mode: 'master-slave' or 'master-master'
     */
    public string $mode = 'master-slave';
    
    /**
     * Master server configuration
     */
    public array $master = [
        'hostname'     => 'localhost', // Change to master server hostname/IP
        'username'     => 'root',
        'password'     => 'yani12345',
        'database'     => 'inlislite',
        'DBDriver'     => 'MySQLi',
        'port'         => 3306,
        'server_id'    => 1,           // Unique server ID for master
    ];
    
    /**
     * Slave server configuration(s)
     * You can add multiple slave servers as needed
     */
    public array $slaves = [
        [
            'hostname'     => 'slave-server', // Change to slave server hostname/IP
            'username'     => 'root',
            'password'     => 'yani12345',
            'database'     => 'inlislite',
            'DBDriver'     => 'MySQLi',
            'port'         => 3306,
            'server_id'    => 2,           // Unique server ID for slave
            'read_only'    => true,        // Slave should be read-only
        ],
        // Add more slave configurations as needed
    ];
    
    /**
     * Tables to replicate
     * Leave empty to replicate all tables
     */
    public array $tables = [
        'users',
        'registrations',
        'documents',
        'profile',
        // Add other tables as needed
    ];
    
    /**
     * Tables to exclude from replication
     */
    public array $excludeTables = [
        'sessions',
        'logs',
        'activity_logs',
        // Add other tables to exclude as needed
    ];
    
    /**
     * Replication sync interval in seconds
     * Only used if automatic sync is enabled
     */
    public int $syncInterval = 300; // 5 minutes
    
    /**
     * Enable automatic synchronization check
     */
    public bool $autoSync = true;
}