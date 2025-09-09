<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContentTables extends Migration
{
    public function up()
    {
        // Create tentang_cards table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'subtitle' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'color' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type'      => 'TIMESTAMP',
                'default'   => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('status');
        $this->forge->addKey('sort_order');
        $this->forge->createTable('tentang_cards');

        // Create fitur table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'color' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['feature', 'module'],
                'default'    => 'feature',
            ],
            'module_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type'      => 'TIMESTAMP',
                'default'   => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('type');
        $this->forge->addKey('status');
        $this->forge->addKey('sort_order');
        $this->forge->createTable('fitur');

        // Create aplikasi table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_aplikasi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'versi' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'platform' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'download_url' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
            ],
            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type'      => 'TIMESTAMP',
                'default'   => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('status');
        $this->forge->addKey('sort_order');
        $this->forge->createTable('aplikasi');

        // Create other content tables with similar structure
        $tables = ['panduan', 'dukungan', 'bimbingan', 'demo', 'patch'];
        
        foreach ($tables as $table) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'title' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => false,
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'content' => [
                    'type' => 'LONGTEXT',
                    'null' => true,
                ],
                'icon' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                ],
                'sort_order' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 0,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['active', 'inactive'],
                    'default'    => 'active',
                ],
                'created_at' => [
                    'type'    => 'TIMESTAMP',
                    'default' => 'CURRENT_TIMESTAMP',
                ],
                'updated_at' => [
                    'type'      => 'TIMESTAMP',
                    'default'   => 'CURRENT_TIMESTAMP',
                    'on_update' => 'CURRENT_TIMESTAMP',
                ],
            ]);
            $this->forge->addPrimaryKey('id');
            $this->forge->addKey('status');
            $this->forge->addKey('sort_order');
            $this->forge->createTable($table);
        }

        // Create installer_cards table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_paket' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'versi' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'ukuran' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'download_url' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type'      => 'TIMESTAMP',
                'default'   => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('status');
        $this->forge->addKey('sort_order');
        $this->forge->createTable('installer_cards');
    }

    public function down()
    {
        $tables = ['tentang_cards', 'fitur', 'aplikasi', 'panduan', 'dukungan', 'bimbingan', 'demo', 'patch', 'installer_cards'];
        
        foreach ($tables as $table) {
            $this->forge->dropTable($table);
        }
    }
}