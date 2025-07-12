<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAplikasiPendukungTable extends Migration
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
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'subtitle' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'category' => [
                'type' => 'ENUM',
                'constraint' => ['utility', 'addon', 'plugin', 'tool', 'other'],
                'default' => 'utility',
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive', 'maintenance'],
                'default' => 'active',
            ],
            'version' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'file_size' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'download_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'image_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'download_count' => [
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
        $this->forge->addKey(['status', 'category']);
        $this->forge->addKey('sort_order');
        $this->forge->createTable('aplikasi_pendukung');
    }

    public function down()
    {
        $this->forge->dropTable('aplikasi_pendukung');
    }
}