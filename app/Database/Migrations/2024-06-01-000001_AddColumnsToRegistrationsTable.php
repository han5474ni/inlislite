<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsToRegistrationsTable extends Migration
{
    public function up()
    {
        // Tambahkan kolom-kolom baru ke tabel registrations
        $fields = [
            'library_code' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'library_name'
            ],
            'library_type' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'library_code'
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'city'
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'address'
            ],
            'coordinates' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'postal_code'
            ],
            'contact_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'coordinates'
            ],
            'contact_position' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'contact_name'
            ],
            'website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'phone'
            ],
            'fax' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'website'
            ],
            'established_year' => [
                'type' => 'INT',
                'constraint' => 4,
                'null' => true,
                'after' => 'fax'
            ],
            'collection_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'established_year'
            ],
            'member_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'collection_count'
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'member_count'
            ],
        ];

        $this->forge->addColumn('registrations', $fields);
    }

    public function down()
    {
        // Hapus kolom-kolom yang ditambahkan jika migrasi di-rollback
        $this->forge->dropColumn('registrations', [
            'library_code', 'library_type', 'address', 'postal_code', 'coordinates',
            'contact_name', 'contact_position', 'website', 'fax', 'established_year',
            'collection_count', 'member_count', 'notes'
        ]);
    }
}