<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
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
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
                'unique'     => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['Super Admin', 'Admin', 'Pustakawan', 'Staff'],
                'default'    => 'Staff',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Aktif', 'Non-aktif'],
                'default'    => 'Aktif',
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type'      => 'TIMESTAMP',
                'default'   => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('email');
        $this->forge->addKey('role');
        $this->forge->addKey('status');
        $this->forge->createTable('users');

        // Insert default admin user
        $data = [
            'nama_lengkap' => 'System Administrator',
            'username'     => 'admin',
            'email'        => 'admin@inlislite.com',
            'password'     => password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 12]),
            'role'         => 'Super Admin',
            'status'       => 'Aktif',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($data);
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}