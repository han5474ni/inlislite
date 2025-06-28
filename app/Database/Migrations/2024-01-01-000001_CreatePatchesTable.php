<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatchesTable extends Migration
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
            'nama_paket' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'versi' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'prioritas' => [
                'type' => 'ENUM',
                'constraint' => ['High', 'Medium', 'Low'],
                'default' => 'Medium',
                'null' => false,
            ],
            'tanggal_rilis' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'ukuran' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'jumlah_unduhan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => false,
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
        $this->forge->addKey('prioritas');
        $this->forge->addKey('tanggal_rilis');
        $this->forge->addKey('created_at');
        
        $this->forge->createTable('patches');
    }

    public function down()
    {
        $this->forge->dropTable('patches');
    }
}
