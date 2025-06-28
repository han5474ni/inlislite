<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatchesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_paket' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'versi' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'prioritas' => [
                'type'       => 'ENUM',
                'constraint' => ['High', 'Medium', 'Low'],
                'default'    => 'Medium',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_rilis' => [
                'type' => 'DATE',
            ],
            'ukuran' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'jumlah_unduhan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
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
        $this->forge->createTable('patches');
    }

    public function down()
    {
        $this->forge->dropTable('patches');
    }
}