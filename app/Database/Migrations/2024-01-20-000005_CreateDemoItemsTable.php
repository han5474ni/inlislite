<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDemoItemsTable extends Migration
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
                'constraint' => ['cataloging', 'circulation', 'membership', 'reporting', 'opac', 'administration'],
                'default' => 'cataloging',
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
            'demo_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'demo_type' => [
                'type' => 'ENUM',
                'constraint' => ['interactive', 'video', 'screenshot', 'live'],
                'default' => 'interactive',
                'null' => true,
            ],
            'features' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'requirements' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'version' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'access_level' => [
                'type' => 'ENUM',
                'constraint' => ['public', 'registered', 'admin'],
                'default' => 'public',
                'null' => true,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'is_featured' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'view_count' => [
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
        $this->forge->addKey('demo_type');
        $this->forge->addKey('sort_order');
        $this->forge->addKey('is_featured');
        $this->forge->createTable('demo_items');
    }

    public function down()
    {
        $this->forge->dropTable('demo_items');
    }
}