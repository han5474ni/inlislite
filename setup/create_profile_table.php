<?php
/**
 * Create Profile Table and Activity Log Table
 * This script creates the profile table and activity log table for INLISLite v3.0
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Load CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

try {
    $db = \Config\Database::connect();
    $forge = \Config\Database::forge();
    
    echo "=== Creating Profile and Activity Log Tables ===\n\n";
    
    // 1. Create profiles table
    if (!$db->tableExists('profiles')) {
        echo "Creating profiles table...\n";
        
        $profileFields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'nama_pengguna' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'bio' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Profile photo filename'
            ],
            'kata_sandi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment' => 'Hashed password'
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['Super Admin', 'Admin', 'Pustakawan', 'Staff'],
                'default' => 'Staff'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif', 'Non-aktif', 'Ditangguhkan'],
                'default' => 'Aktif'
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'login_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ];
        
        $forge->addField($profileFields);
        $forge->addKey('id', true);
        $forge->addKey('user_id');
        $forge->addUniqueKey('nama_pengguna');
        $forge->addUniqueKey('email');
        $forge->createTable('profiles');
        
        echo "✅ Profiles table created successfully!\n\n";
    } else {
        echo "⚪ Profiles table already exists.\n\n";
    }
    
    // 2. Create activity_logs table
    if (!$db->tableExists('activity_logs')) {
        echo "Creating activity_logs table...\n";
        
        $activityFields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'activity_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'comment' => 'login, logout, profile_update, password_change, etc.'
            ],
            'activity_description' => [
                'type' => 'TEXT',
                'null' => false,
                'comment' => 'Detailed description of the activity'
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
                'comment' => 'User IP address'
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Browser user agent'
            ],
            'old_values' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'Previous values before change'
            ],
            'new_values' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'New values after change'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP'
            ]
        ];
        
        $forge->addField($activityFields);
        $forge->addKey('id', true);
        $forge->addKey('user_id');
        $forge->addKey('activity_type');
        $forge->addKey('created_at');
        $forge->createTable('activity_logs');
        
        echo "✅ Activity logs table created successfully!\n\n";
    } else {
        echo "⚪ Activity logs table already exists.\n\n";
    }
    
    // 3. Migrate existing users data to profiles table
    echo "Migrating existing users data to profiles table...\n";
    
    if ($db->tableExists('users')) {
        $users = $db->table('users')->get()->getResultArray();
        
        foreach ($users as $user) {
            // Check if profile already exists
            $existingProfile = $db->table('profiles')
                ->where('user_id', $user['id'])
                ->get()
                ->getRowArray();
            
            if (!$existingProfile) {
                $profileData = [
                    'user_id' => $user['id'],
                    'nama_lengkap' => $user['nama_lengkap'] ?? 'Administrator',
                    'nama_pengguna' => $user['nama_pengguna'] ?? $user['username'] ?? 'admin',
                    'email' => $user['email'] ?? 'admin@inlislite.com',
                    'phone' => $user['phone'] ?? null,
                    'address' => $user['address'] ?? null,
                    'bio' => null,
                    'foto' => null,
                    'kata_sandi' => $user['kata_sandi'] ?? $user['password'] ?? password_hash('admin123', PASSWORD_DEFAULT),
                    'role' => $user['role'] ?? 'Super Admin',
                    'status' => $user['status'] ?? 'Aktif',
                    'last_login' => $user['last_login'] ?? null,
                    'login_count' => 0,
                    'created_at' => $user['created_at'] ?? date('Y-m-d H:i:s'),
                    'updated_at' => $user['updated_at'] ?? date('Y-m-d H:i:s')
                ];
                
                $db->table('profiles')->insert($profileData);
                echo "✅ Migrated user: " . $profileData['nama_pengguna'] . "\n";
            } else {
                echo "⚪ Profile already exists for user: " . $user['nama_pengguna'] . "\n";
            }
        }
    } else {
        // Create default admin profile
        echo "Creating default admin profile...\n";
        $defaultProfile = [
            'user_id' => 1,
            'nama_lengkap' => 'Administrator',
            'nama_pengguna' => 'admin',
            'email' => 'admin@inlislite.com',
            'phone' => null,
            'address' => null,
            'bio' => 'System Administrator',
            'foto' => null,
            'kata_sandi' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'Super Admin',
            'status' => 'Aktif',
            'last_login' => null,
            'login_count' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $db->table('profiles')->insert($defaultProfile);
        echo "✅ Default admin profile created!\n";
    }
    
    // 4. Create upload directory for profile photos
    $uploadDir = FCPATH . 'uploads/profiles';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
        echo "✅ Created profile photos directory: {$uploadDir}\n";
    }
    
    // 5. Test the tables
    echo "\n=== Testing Tables ===\n";
    
    $profileCount = $db->table('profiles')->countAllResults();
    echo "Profiles count: {$profileCount}\n";
    
    $activityCount = $db->table('activity_logs')->countAllResults();
    echo "Activity logs count: {$activityCount}\n";
    
    // Show table structures
    echo "\n=== Profiles Table Structure ===\n";
    $profileFields = $db->getFieldData('profiles');
    foreach ($profileFields as $field) {
        echo "- {$field->name} ({$field->type})\n";
    }
    
    echo "\n=== Activity Logs Table Structure ===\n";
    $activityFields = $db->getFieldData('activity_logs');
    foreach ($activityFields as $field) {
        echo "- {$field->name} ({$field->type})\n";
    }
    
    echo "\n=== Setup Complete ===\n";
    echo "✅ Profile tables created and synchronized successfully!\n";
    echo "✅ Default login: admin / admin123\n";
    echo "✅ Profile page ready at: http://localhost:8080/admin/profile\n\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}