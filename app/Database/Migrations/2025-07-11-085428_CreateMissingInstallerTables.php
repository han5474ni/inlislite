<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMissingInstallerTables extends Migration
{
    public function up()
    {
        // Create installer_settings table
        if (!$this->db->tableExists('installer_settings')) {
            $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'setting_key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'setting_value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'setting_type' => [
                'type' => 'ENUM',
                'constraint' => ['string', 'integer', 'boolean', 'json'],
                'default' => 'string',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('installer_settings');
        }

        // Create installer_cards table
        if (!$this->db->tableExists('installer_cards')) {
            $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'package_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'version' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'release_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'file_size' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'download_link' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'requirements' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'default_username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'default_password' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'card_type' => [
                'type' => 'ENUM',
                'constraint' => ['source', 'installer', 'database', 'documentation'],
                'default' => 'source',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('installer_cards');
        }

        // Create installer_downloads table
        if (!$this->db->tableExists('installer_downloads')) {
            $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'package_type' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'filename' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_size' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'download_date' => [
                'type' => 'DATETIME',
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'session_id' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => true,
            ],
            'referrer' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('package_type');
        $this->forge->addKey('download_date');
        $this->forge->createTable('installer_downloads');
        }

        // Create fitur table
        if (!$this->db->tableExists('fitur')) {
            $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_fitur' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => 'bi-gear',
            ],
            'warna' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'primary',
            ],
            'kategori' => [
                'type' => 'ENUM',
                'constraint' => ['core', 'addon', 'plugin', 'utility'],
                'default' => 'core',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'nonaktif', 'maintenance'],
                'default' => 'aktif',
            ],
            'versi' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => '1.0',
            ],
            'developer' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'url_dokumentasi' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'tanggal_rilis' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'is_premium' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('kategori');
        $this->forge->addKey('status');
        $this->forge->addKey('sort_order');
        $this->forge->createTable('fitur');
        }

        // Insert default data
        $this->insertDefaultData();
    }

    public function down()
    {
        $this->forge->dropTable('installer_settings');
        $this->forge->dropTable('installer_cards');
        $this->forge->dropTable('installer_downloads');
        $this->forge->dropTable('fitur');
    }

    private function insertDefaultData()
    {
        // Insert default installer settings
        $settingsData = [
            [
                'setting_key' => 'installer_version',
                'setting_value' => '3.2',
                'setting_type' => 'string',
                'description' => 'Current installer version',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'installer_revision_date',
                'setting_value' => '10 Februari 2021',
                'setting_type' => 'string',
                'description' => 'Last revision date',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'source_package_size',
                'setting_value' => '25 MB',
                'setting_type' => 'string',
                'description' => 'Source package file size',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'php_package_size',
                'setting_value' => '20 MB',
                'setting_type' => 'string',
                'description' => 'PHP package file size',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'sql_package_size',
                'setting_value' => '2 MB',
                'setting_type' => 'string',
                'description' => 'SQL package file size',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'default_credentials',
                'setting_value' => '{"username":"inlislite","password":"inlislite"}',
                'setting_type' => 'json',
                'description' => 'Default login credentials',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('installer_settings')->insertBatch($settingsData);

        // Insert default installer cards
        $cardsData = [
            [
                'package_name' => 'Paket Source Code',
                'version' => '3.2',
                'description' => 'File sumber PHP lengkap dengan dokumentasi dan panduan instalasi.',
                'card_type' => 'source',
                'file_size' => '25 MB',
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'package_name' => 'Paket Installer Windows',
                'version' => '3.2',
                'description' => 'Installer otomatis untuk sistem operasi Windows dengan wizard instalasi.',
                'card_type' => 'installer',
                'file_size' => '45 MB',
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'package_name' => 'Source Code PHP',
                'version' => '3.2',
                'description' => 'File sumber lengkap aplikasi PHP untuk pengembangan dan kustomisasi.',
                'card_type' => 'source',
                'file_size' => '20 MB',
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'package_name' => 'Database Kosong',
                'version' => '3.2',
                'description' => 'File SQL database kosong untuk instalasi fresh.',
                'card_type' => 'database',
                'file_size' => '2 MB',
                'status' => 'active',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'package_name' => 'Dokumentasi',
                'version' => '3.2',
                'description' => 'Panduan lengkap instalasi, konfigurasi, dan penggunaan sistem.',
                'card_type' => 'documentation',
                'file_size' => '15 MB',
                'status' => 'active',
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('installer_cards')->insertBatch($cardsData);

        // Insert default fitur data
        $fiturData = [
            [
                'nama_fitur' => 'Katalogisasi',
                'deskripsi' => 'Sistem manajemen katalog buku dan koleksi perpustakaan',
                'icon' => 'bi-book',
                'warna' => 'primary',
                'kategori' => 'core',
                'status' => 'aktif',
                'versi' => '3.2',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_fitur' => 'Sirkulasi',
                'deskripsi' => 'Manajemen peminjaman dan pengembalian buku',
                'icon' => 'bi-arrow-repeat',
                'warna' => 'success',
                'kategori' => 'core',
                'status' => 'aktif',
                'versi' => '3.2',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_fitur' => 'Keanggotaan',
                'deskripsi' => 'Manajemen data anggota perpustakaan',
                'icon' => 'bi-people',
                'warna' => 'info',
                'kategori' => 'core',
                'status' => 'aktif',
                'versi' => '3.2',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_fitur' => 'OPAC',
                'deskripsi' => 'Online Public Access Catalog untuk pencarian koleksi',
                'icon' => 'bi-search',
                'warna' => 'warning',
                'kategori' => 'core',
                'status' => 'aktif',
                'versi' => '3.2',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_fitur' => 'Laporan',
                'deskripsi' => 'Sistem pelaporan dan statistik perpustakaan',
                'icon' => 'bi-graph-up',
                'warna' => 'danger',
                'kategori' => 'core',
                'status' => 'aktif',
                'versi' => '3.2',
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('fitur')->insertBatch($fiturData);
    }
}