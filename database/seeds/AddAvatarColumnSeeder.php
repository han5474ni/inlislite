<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddAvatarColumnSeeder extends Seeder
{
    public function run()
    {
        // Check if avatar column exists
        $db = \Config\Database::connect();
        $fields = $db->getFieldData('users');
        
        $avatarExists = false;
        foreach ($fields as $field) {
            if ($field->name === 'avatar') {
                $avatarExists = true;
                break;
            }
        }
        
        if (!$avatarExists) {
            // Add avatar column
            $db->query("ALTER TABLE `users` ADD COLUMN `avatar` VARCHAR(255) DEFAULT NULL AFTER `status`");
            
            // Add index
            $db->query("ALTER TABLE `users` ADD KEY `idx_avatar` (`avatar`)");
            
            // Update existing users with profile data
            $db->query("
                UPDATE `users` u 
                INNER JOIN `profile` p ON u.id = p.user_id 
                SET u.avatar = p.foto 
                WHERE p.foto IS NOT NULL
            ");
            
            echo "Avatar column added successfully!\n";
        } else {
            echo "Avatar column already exists.\n";
        }
    }
}
