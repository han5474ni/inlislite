<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAvatarToUsersTable extends Migration
{
    public function up()
    {
        // Add avatar column to users table
        $this->forge->addColumn('users', [
            'avatar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
                'after'      => 'status',
            ],
        ]);

        // Add index for avatar column
        $this->forge->addKey('avatar', false, false, 'idx_avatar');
        $this->forge->processIndexes('users');

        // Update existing users table with avatar data from profile table
        $this->db->query("
            UPDATE users u 
            INNER JOIN profile p ON u.id = p.user_id 
            SET u.avatar = p.foto 
            WHERE p.foto IS NOT NULL
        ");
    }

    public function down()
    {
        // Drop avatar column
        $this->forge->dropColumn('users', 'avatar');
    }
}
