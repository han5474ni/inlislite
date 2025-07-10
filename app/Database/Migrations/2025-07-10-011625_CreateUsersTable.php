<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
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
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'nama_pengguna' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'kata_sandi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['Super Admin', 'Admin', 'Pustakawan', 'Staff'],
                'default' => 'Staff',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif', 'Non-aktif', 'Ditangguhkan'],
                'default' => 'Aktif',
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'bio' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'reset_token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
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
        $this->forge->addUniqueKey('nama_pengguna');
        $this->forge->addUniqueKey('email');
        $this->forge->addKey('role');
        $this->forge->addKey('status');
        $this->forge->addKey('last_login');
        
        $this->forge->createTable('users');

        // Insert default admin user
        $data = [
            'nama_lengkap' => 'Administrator',
            'nama_pengguna' => 'admin',
            'email' => 'admin@inlislite.com',
            'kata_sandi' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'Super Admin',
            'status' => 'Aktif',
            'bio' => 'System Administrator',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($data);
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
