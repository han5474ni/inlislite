<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInstallerCardsTable extends Migration
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
            'package_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment' => 'Name of the installer package'
            ],
            'version' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'comment' => 'Version of the package'
            ],
            'release_date' => [
                'type' => 'DATE',
                'null' => true,
                'comment' => 'Release or revision date'
            ],
            'file_size' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'comment' => 'File size in human readable format'
            ],
            'download_link' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'comment' => 'Download URL for the package'
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Package description'
            ],
            'requirements' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'System requirements as JSON array'
            ],
            'default_username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Default login username'
            ],
            'default_password' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Default login password'
            ],
            'card_type' => [
                'type' => 'ENUM',
                'constraint' => ['source', 'installer', 'database', 'documentation'],
                'default' => 'source',
                'comment' => 'Type of installer card'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
                'comment' => 'Card status'
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
                'comment' => 'Display order'
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
        $this->forge->addKey('card_type');
        $this->forge->addKey('status');
        $this->forge->addKey('sort_order');
        $this->forge->addKey(['status', 'sort_order']);
        
        $this->forge->createTable('installer_cards');

        // Insert default installer cards
        $defaultCards = [
            [
                'package_name' => 'Paket Source Code',
                'version' => '3.2',
                'release_date' => '2021-02-10',
                'file_size' => '25 MB',
                'download_link' => '#',
                'description' => 'File sumber PHP lengkap dengan dokumentasi dan panduan instalasi',
                'requirements' => json_encode(['php', 'docs', 'config', 'database']),
                'default_username' => 'inlislite',
                'default_password' => 'inlislite',
                'card_type' => 'source',
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'package_name' => 'Paket Basis Data Kosong',
                'version' => '3.2',
                'release_date' => '2021-02-10',
                'file_size' => '2 MB',
                'download_link' => '#',
                'description' => 'File SQL database kosong untuk instalasi fresh',
                'requirements' => json_encode(['database']),
                'default_username' => null,
                'default_password' => null,
                'card_type' => 'database',
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'package_name' => 'Dokumentasi Instalasi',
                'version' => '3.2',
                'release_date' => '2021-02-10',
                'file_size' => '5 MB',
                'download_link' => '#',
                'description' => 'Panduan lengkap instalasi dan konfigurasi sistem',
                'requirements' => json_encode(['docs']),
                'default_username' => null,
                'default_password' => null,
                'card_type' => 'documentation',
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('installer_cards')->insertBatch($defaultCards);
    }

    public function down()
    {
        $this->forge->dropTable('installer_cards');
    }
}