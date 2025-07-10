<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInstallerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'package_type' => [
                'type' => 'ENUM',
                'constraint' => ['source', 'php', 'sql'],
                'null' => false,
                'comment' => 'Type of package downloaded'
            ],
            'filename' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment' => 'Downloaded file name'
            ],
            'file_size' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'comment' => 'File size in human readable format'
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Package description'
            ],
            'download_date' => [
                'type' => 'DATETIME',
                'null' => false,
                'comment' => 'When the download occurred'
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Browser user agent string'
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
                'comment' => 'IP address of downloader (supports IPv6)'
            ],
            'download_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 1,
                'comment' => 'Number of times downloaded by same IP'
            ],
            'session_id' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => true,
                'comment' => 'Session identifier'
            ],
            'referrer' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'comment' => 'HTTP referrer'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('package_type');
        $this->forge->addKey('download_date');
        $this->forge->addKey('ip_address');
        $this->forge->addKey(['package_type', 'download_date']);
        $this->forge->addKey(['ip_address', 'package_type']);
        
        $this->forge->createTable('installer_downloads');

        // Create installer settings table for configuration
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'setting_key' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'comment' => 'Setting identifier'
            ],
            'setting_value' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Setting value (JSON or plain text)'
            ],
            'setting_type' => [
                'type' => 'ENUM',
                'constraint' => ['string', 'integer', 'boolean', 'json', 'array'],
                'default' => 'string',
                'comment' => 'Data type of the setting'
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Setting description'
            ],
            'is_editable' => [
                'type' => 'BOOLEAN',
                'default' => true,
                'comment' => 'Whether setting can be edited via UI'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('setting_key');
        $this->forge->addKey('setting_type');
        
        $this->forge->createTable('installer_settings');

        // Insert default installer settings
        $defaultSettings = [
            [
                'setting_key' => 'installer_version',
                'setting_value' => '3.2',
                'setting_type' => 'string',
                'description' => 'Current installer version',
                'is_editable' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'installer_revision_date',
                'setting_value' => '10 Februari 2021',
                'setting_type' => 'string',
                'description' => 'Installer revision date',
                'is_editable' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'source_package_size',
                'setting_value' => '25 MB',
                'setting_type' => 'string',
                'description' => 'Source code package size',
                'is_editable' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'php_package_size',
                'setting_value' => '20 MB',
                'setting_type' => 'string',
                'description' => 'PHP source package size',
                'is_editable' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'sql_package_size',
                'setting_value' => '2 MB',
                'setting_type' => 'string',
                'description' => 'SQL database package size',
                'is_editable' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'download_stats',
                'setting_value' => '{"source": 0, "php": 0, "sql": 0}',
                'setting_type' => 'json',
                'description' => 'Download statistics counter',
                'is_editable' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'system_requirements',
                'setting_value' => '{"os": "Windows 7/8/10/11 atau Linux", "processor": "Intel Pentium 4 atau setara", "memory": "Minimal 2 GB RAM", "storage": "Rekomendasi 500 MB ruang kosong", "browser": "Chrome, Firefox, Safari, Edge (latest)"}',
                'setting_type' => 'json',
                'description' => 'System requirements configuration',
                'is_editable' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'default_credentials',
                'setting_value' => '{"username": "inlislite", "password": "inlislite"}',
                'setting_type' => 'json',
                'description' => 'Default admin login credentials',
                'is_editable' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'installation_steps',
                'setting_value' => '[{"step": 1, "title": "Ekstrak File ZIP", "description": "Ekstrak file ZIP ke direktori yang diinginkan"}, {"step": 2, "title": "Jalankan Installer", "description": "Jalankan file installer (.exe) sebagai Administrator"}, {"step": 3, "title": "Ikuti Wizard", "description": "Ikuti petunjuk pada wizard instalasi"}, {"step": 4, "title": "Pilih Direktori", "description": "Pilih direktori instalasi (default: C:\\\\INLISLite)"}, {"step": 5, "title": "Tunggu Proses", "description": "Tunggu hingga proses instalasi selesai"}, {"step": 6, "title": "Akses Browser", "description": "Akses aplikasi melalui browser"}, {"step": 7, "title": "Login Sistem", "description": "Login dengan kredensial bawaan"}]',
                'setting_type' => 'json',
                'description' => 'Installation steps configuration',
                'is_editable' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('installer_settings')->insertBatch($defaultSettings);
    }

    public function down()
    {
        $this->forge->dropTable('installer_downloads');
        $this->forge->dropTable('installer_settings');
    }
}