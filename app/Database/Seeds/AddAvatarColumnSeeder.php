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
            echo "Avatar column added successfully!\n";
        } else {
            echo "Avatar column already exists.\n";
        }
    }
}
