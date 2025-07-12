<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBimbinganItemsTable extends Migration
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
                'constraint' => ['training', 'workshop', 'webinar', 'consultation', 'certification'],
                'default' => 'training',
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive', 'scheduled', 'completed'],
                'default' => 'active',
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['online', 'offline', 'hybrid'],
                'default' => 'online',
                'null' => true,
            ],
            'duration' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'level' => [
                'type' => 'ENUM',
                'constraint' => ['beginner', 'intermediate', 'advanced'],
                'default' => 'beginner',
                'null' => true,
            ],
            'instructor' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'schedule' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'capacity' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
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
        $this->forge->addKey('schedule');
        $this->forge->addKey('sort_order');
        $this->forge->addKey('is_featured');
        $this->forge->createTable('bimbingan_items');
    }

    public function down()
    {
        $this->forge->dropTable('bimbingan_items');
    }
}