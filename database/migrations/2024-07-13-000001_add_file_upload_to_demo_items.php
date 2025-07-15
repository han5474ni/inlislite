<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFileUploadToDemoItems extends Migration
{
    public function up()
    {
        $fields = [
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'demo_type',
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'after' => 'file_name',
            ],
            'file_size' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'file_path',
            ],
            'file_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'file_size',
            ],
        ];
        $this->forge->addColumn('demo_items', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('demo_items', ['file_name', 'file_path', 'file_size', 'file_type']);
    }
} 