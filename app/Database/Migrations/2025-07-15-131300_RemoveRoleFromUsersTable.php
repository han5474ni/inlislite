<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveRoleFromUsersTable extends Migration
{
    public function up()
    {
        // Check if users table exists and has role column
        if ($this->db->tableExists('users')) {
            $fields = $this->db->getFieldNames('users');
            
            if (in_array('role', $fields)) {
                // Remove the role column
                $this->forge->dropColumn('users', 'role');
                
                // Remove the role key if it exists
                try {
                    $this->forge->dropKey('users', 'role');
                } catch (\Exception $e) {
                    // Key might not exist, continue
                }
            }
        }
    }

    public function down()
    {
        // Add back the role column if needed
        if ($this->db->tableExists('users')) {
            $fields = $this->db->getFieldNames('users');
            
            if (!in_array('role', $fields)) {
                $this->forge->addColumn('users', [
                    'role' => [
                        'type' => 'ENUM',
                        'constraint' => ['Super Admin', 'Admin', 'Pustakawan', 'Staff'],
                        'default' => 'Staff',
                        'after' => 'kata_sandi'
                    ]
                ]);
                
                // Add back the key
                $this->forge->addKey('role');
            }
        }
    }
}
