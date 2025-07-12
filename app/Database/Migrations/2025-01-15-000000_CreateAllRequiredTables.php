<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAllRequiredTables extends Migration
{
    public function up()
    {
        // Create users table if not exists
        if (!$this->db->tableExists('users')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'username' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'unique' => true,
                ],
                'email' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'unique' => true,
                ],
                'password' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'nama' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'nama_lengkap' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'role' => [
                    'type' => 'ENUM',
                    'constraint' => ['admin', 'user', 'super_admin'],
                    'default' => 'user',
                ],
                'status' => [
                    'type' => 'ENUM',
                    'constraint' => ['active', 'inactive'],
                    'default' => 'active',
                ],
                'last_login' => [
                    'type' => 'DATETIME',
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
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('username');
            $this->forge->addUniqueKey('email');
            $this->forge->createTable('users');

            // Insert default admin user
            $this->db->table('users')->insert([
                'username' => 'admin',
                'email' => 'admin@inlislite.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'nama' => 'Administrator',
                'nama_lengkap' => 'Administrator Sistem',
                'role' => 'super_admin',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Create tentang_cards table if not exists
        if (!$this->db->tableExists('tentang_cards')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'title' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'subtitle' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'content' => [
                    'type' => 'TEXT',
                ],
                'category' => [
                    'type' => 'ENUM',
                    'constraint' => ['overview', 'legal', 'features', 'technical', 'other'],
                    'default' => 'overview',
                ],
                'icon' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
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
            $this->forge->addKey('id', true);
            $this->forge->createTable('tentang_cards');
        }

        // Create fitur table if not exists
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
                'kategori' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'icon' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
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
            $this->forge->addKey('id', true);
            $this->forge->createTable('fitur');
        }

        // Create installer_cards table if not exists
        if (!$this->db->tableExists('installer_cards')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'nama_paket' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'deskripsi' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'versi' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
                'ukuran' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
                'tipe' => [
                    'type' => 'ENUM',
                    'constraint' => ['installer', 'source', 'database', 'documentation'],
                    'default' => 'installer',
                ],
                'url_download' => [
                    'type' => 'VARCHAR',
                    'constraint' => 500,
                    'null' => true,
                ],
                'icon' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
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
            $this->forge->addKey('id', true);
            $this->forge->createTable('installer_cards');
        }

        // Create patches table if not exists
        if (!$this->db->tableExists('patches')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'nama_patch' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'versi' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                ],
                'deskripsi' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'ukuran' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
                'prioritas' => [
                    'type' => 'ENUM',
                    'constraint' => ['low', 'medium', 'high', 'critical'],
                    'default' => 'medium',
                ],
                'tanggal_rilis' => [
                    'type' => 'DATE',
                    'null' => true,
                ],
                'url_download' => [
                    'type' => 'VARCHAR',
                    'constraint' => 500,
                    'null' => true,
                ],
                'status' => [
                    'type' => 'ENUM',
                    'constraint' => ['active', 'inactive'],
                    'default' => 'active',
                ],
                'jumlah_unduhan' => [
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
            $this->forge->addKey('id', true);
            $this->forge->createTable('patches');
        }

        // Create aplikasi_pendukung table if not exists
        if (!$this->db->tableExists('aplikasi_pendukung')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'nama_aplikasi' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'deskripsi' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'versi' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
                'platform' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'ukuran' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
                'kategori' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'url_download' => [
                    'type' => 'VARCHAR',
                    'constraint' => 500,
                    'null' => true,
                ],
                'icon' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
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
            $this->forge->addKey('id', true);
            $this->forge->createTable('aplikasi_pendukung');
        }

        // Create panduan_documents table if not exists
        if (!$this->db->tableExists('panduan_documents')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'title' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'category' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'file_path' => [
                    'type' => 'VARCHAR',
                    'constraint' => 500,
                    'null' => true,
                ],
                'file_size' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
                'version' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
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
            $this->forge->addKey('id', true);
            $this->forge->createTable('panduan_documents');
        }

        // Create dukungan_items table if not exists
        if (!$this->db->tableExists('dukungan_items')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'title' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'category' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'contact_info' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'response_time' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'availability' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'icon' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
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
            $this->forge->addKey('id', true);
            $this->forge->createTable('dukungan_items');
        }

        // Create bimbingan_items table if not exists
        if (!$this->db->tableExists('bimbingan_items')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'title' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'duration' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'participants' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'price' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'topics' => [
                    'type' => 'TEXT',
                    'null' => true,
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
            $this->forge->addKey('id', true);
            $this->forge->createTable('bimbingan_items');
        }

        // Create demo_items table if not exists
        if (!$this->db->tableExists('demo_items')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'title' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'platform' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'version' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
                'url' => [
                    'type' => 'VARCHAR',
                    'constraint' => 500,
                    'null' => true,
                ],
                'username' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'password' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'features' => [
                    'type' => 'TEXT',
                    'null' => true,
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
            $this->forge->addKey('id', true);
            $this->forge->createTable('demo_items');
        }

        // Create activity_logs table if not exists
        if (!$this->db->tableExists('activity_logs')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'user_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                ],
                'action' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'ip_address' => [
                    'type' => 'VARCHAR',
                    'constraint' => 45,
                    'null' => true,
                ],
                'user_agent' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('user_id');
            $this->forge->createTable('activity_logs');
        }

        // Create registrations table if not exists
        if (!$this->db->tableExists('registrations')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'library_name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'library_type' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'province' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'city' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'address' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'contact_person' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'email' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'phone' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
                'status' => [
                    'type' => 'ENUM',
                    'constraint' => ['pending', 'active', 'inactive'],
                    'default' => 'pending',
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
            $this->forge->createTable('registrations');
        }
    }

    public function down()
    {
        // Drop tables in reverse order to handle foreign key constraints
        $tables = [
            'activity_logs',
            'registrations',
            'demo_items',
            'bimbingan_items',
            'dukungan_items',
            'panduan_documents',
            'aplikasi_pendukung',
            'patches',
            'installer_cards',
            'fitur',
            'tentang_cards',
            'users'
        ];

        foreach ($tables as $table) {
            if ($this->db->tableExists($table)) {
                $this->forge->dropTable($table);
            }
        }
    }
}