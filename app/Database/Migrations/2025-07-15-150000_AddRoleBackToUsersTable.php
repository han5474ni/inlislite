<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleBackToUsersTable extends Migration
{
    public function up()
    {
        // Add role column back to users table
        $this->forge->addColumn('users', [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['Super Admin', 'Admin', 'Pustakawan', 'Staff'],
                'default' => 'Staff',
                'after' => 'status'
            ]
        ]);
        
        // Update the admin user to have Super Admin role
        $this->db->table('users')->where('nama_pengguna', 'admin')->update(['role' => 'Super Admin']);
    }

    public function down()
    {
        // Remove role column
        $this->forge->dropColumn('users', 'role');
    }
}
