<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProfileTable extends Migration
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
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['Super Admin', 'Admin', 'Pustakawan', 'Staff'],
                'default'    => 'Staff',
                'null'       => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Aktif', 'Non-aktif', 'Ditangguhkan'],
                'default'    => 'Aktif',
                'null'       => false,
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'nama_pengguna' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'kata_sandi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'bio' => [
                'type' => 'TEXT',
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
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('email');
        $this->forge->addKey('status');
        $this->forge->addKey('role');
        $this->forge->createTable('profile');

        // Insert default admin profile
        $data = [
            'foto' => null,
            'nama' => 'Administrator Sistem',
            'username' => 'admin',
            'email' => 'admin@inlislite.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'Super Admin',
            'status' => 'Aktif',
            'last_login' => date('Y-m-d H:i:s'),
            'nama_lengkap' => 'Administrator Sistem',
            'nama_pengguna' => 'admin',
            'kata_sandi' => password_hash('admin123', PASSWORD_DEFAULT),
            'phone' => null,
            'address' => null,
            'bio' => 'System Administrator for INLISLite v3.0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('profile')->insert($data);

        // Insert additional sample profiles
        $sampleProfiles = [
            [
                'foto' => null,
                'nama' => 'Jane Smith',
                'username' => 'librarian',
                'email' => 'librarian@library.com',
                'password' => password_hash('librarian123', PASSWORD_DEFAULT),
                'role' => 'Pustakawan',
                'status' => 'Aktif',
                'last_login' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'nama_lengkap' => 'Jane Smith',
                'nama_pengguna' => 'librarian',
                'kata_sandi' => password_hash('librarian123', PASSWORD_DEFAULT),
                'phone' => '+62812345678',
                'address' => 'Jl. Perpustakaan No. 123, Jakarta',
                'bio' => 'Experienced librarian with 5+ years in library management',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'foto' => null,
                'nama' => 'Mike Johnson',
                'username' => 'staff1',
                'email' => 'staff1@staff.com',
                'password' => password_hash('staff123', PASSWORD_DEFAULT),
                'role' => 'Staff',
                'status' => 'Non-aktif',
                'last_login' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'nama_lengkap' => 'Mike Johnson',
                'nama_pengguna' => 'staff1',
                'kata_sandi' => password_hash('staff123', PASSWORD_DEFAULT),
                'phone' => '+62823456789',
                'address' => 'Jl. Staff No. 456, Bandung',
                'bio' => 'Library staff member specializing in cataloging',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'foto' => null,
                'nama' => 'Sarah Wilson',
                'username' => 'admin2',
                'email' => 'admin2@inlislite.com',
                'password' => password_hash('admin456', PASSWORD_DEFAULT),
                'role' => 'Admin',
                'status' => 'Aktif',
                'last_login' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'nama_lengkap' => 'Sarah Wilson',
                'nama_pengguna' => 'admin2',
                'kata_sandi' => password_hash('admin456', PASSWORD_DEFAULT),
                'phone' => '+62834567890',
                'address' => 'Jl. Admin No. 789, Surabaya',
                'bio' => 'System administrator and technical support specialist',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('profile')->insertBatch($sampleProfiles);
    }

    public function down()
    {
        $this->forge->dropTable('profile');
    }
}