<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePanduanDocumentsTable extends Migration
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
                'constraint' => ['installation', 'configuration', 'user_guide', 'technical', 'api', 'other'],
                'default' => 'user_guide',
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive', 'draft'],
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
            'file_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'file_type' => [
                'type' => 'ENUM',
                'constraint' => ['pdf', 'doc', 'docx', 'html', 'video'],
                'default' => 'pdf',
                'null' => true,
            ],
            'language' => [
                'type' => 'ENUM',
                'constraint' => ['id', 'en'],
                'default' => 'id',
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
        $this->forge->addKey('sort_order');
        $this->forge->addKey('is_featured');
        $this->forge->createTable('panduan_documents');
    }

    public function down()
    {
        $this->forge->dropTable('panduan_documents');
    }
}