<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDukunganItemsTable extends Migration
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
                'constraint' => ['technical', 'general', 'installation', 'troubleshooting', 'faq', 'contact'],
                'default' => 'general',
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
            'priority' => [
                'type' => 'ENUM',
                'constraint' => ['low', 'medium', 'high', 'urgent'],
                'default' => 'medium',
                'null' => true,
            ],
            'contact_info' => [
                'type' => 'TEXT',
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
            'url' => [
                'type' => 'TEXT',
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
        $this->forge->addKey('priority');
        $this->forge->addKey('sort_order');
        $this->forge->addKey('is_featured');
        $this->forge->createTable('dukungan_items');
    }

    public function down()
    {
        $this->forge->dropTable('dukungan_items');
    }
}