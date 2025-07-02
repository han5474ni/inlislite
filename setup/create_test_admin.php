<?php
/**
 * Create Test Admin User
 * 
 * This script creates a test admin user for testing the login system.
 * Run this script once to create the admin user.
 */

// Database configuration - Update these values according to your setup
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'inlislite_v3';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.\n\n";
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() == 0) {
        echo "Creating users table...\n";
        
        // Create users table
        $createTable = "
        CREATE TABLE `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama_lengkap` varchar(255) NOT NULL,
            `nama_pengguna` varchar(50) NOT NULL UNIQUE,
            `email` varchar(255) NOT NULL UNIQUE,
            `kata_sandi` varchar(255) NOT NULL,
            `role` enum('Super Admin','Admin','Pustakawan','Staff') NOT NULL DEFAULT 'Staff',
            `status` enum('Aktif','Non-Aktif','Ditangguhkan') NOT NULL DEFAULT 'Aktif',
            `last_login` datetime DEFAULT NULL,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        
        $pdo->exec($createTable);
        echo "Users table created successfully.\n\n";
    } else {
        echo "Users table already exists.\n\n";
    }
    
    // Check if admin user already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE nama_pengguna = ?");
    $stmt->execute(['admin']);
    
    if ($stmt->rowCount() > 0) {
        echo "Admin user already exists.\n";
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Username: " . $user['nama_pengguna'] . "\n";
        echo "Email: " . $user['email'] . "\n";
        echo "Role: " . $user['role'] . "\n";
        echo "Status: " . $user['status'] . "\n\n";
        echo "You can use these credentials to login:\n";
        echo "Username: admin\n";
        echo "Password: Admin@123\n\n";
    } else {
        echo "Creating admin user...\n";
        
        // Create admin user
        $adminData = [
            'nama_lengkap' => 'System Administrator',
            'nama_pengguna' => 'admin',
            'email' => 'admin@inlislite.local',
            'kata_sandi' => password_hash('Admin@123', PASSWORD_DEFAULT),
            'role' => 'Super Admin',
            'status' => 'Aktif'
        ];
        
        $stmt = $pdo->prepare("
            INSERT INTO users (nama_lengkap, nama_pengguna, email, kata_sandi, role, status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([
            $adminData['nama_lengkap'],
            $adminData['nama_pengguna'],
            $adminData['email'],
            $adminData['kata_sandi'],
            $adminData['role'],
            $adminData['status']
        ]);
        
        echo "Admin user created successfully!\n\n";
        echo "Login credentials:\n";
        echo "Username: admin\n";
        echo "Password: Admin@123\n\n";
        echo "You can now login at: http://localhost:8080/loginpage\n";
    }
    
    // Create additional test users if needed
    $testUsers = [
        [
            'nama_lengkap' => 'Test Librarian',
            'nama_pengguna' => 'librarian',
            'email' => 'librarian@inlislite.local',
            'kata_sandi' => password_hash('Librarian@123', PASSWORD_DEFAULT),
            'role' => 'Pustakawan',
            'status' => 'Aktif'
        ],
        [
            'nama_lengkap' => 'Test Staff',
            'nama_pengguna' => 'staff',
            'email' => 'staff@inlislite.local',
            'kata_sandi' => password_hash('Staff@123', PASSWORD_DEFAULT),
            'role' => 'Staff',
            'status' => 'Aktif'
        ]
    ];
    
    echo "Creating additional test users...\n";
    foreach ($testUsers as $userData) {
        // Check if user already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE nama_pengguna = ?");
        $stmt->execute([$userData['nama_pengguna']]);
        
        if ($stmt->rowCount() == 0) {
            $stmt = $pdo->prepare("
                INSERT INTO users (nama_lengkap, nama_pengguna, email, kata_sandi, role, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([
                $userData['nama_lengkap'],
                $userData['nama_pengguna'],
                $userData['email'],
                $userData['kata_sandi'],
                $userData['role'],
                $userData['status']
            ]);
            
            echo "- Created user: " . $userData['nama_pengguna'] . " (" . $userData['role'] . ")\n";
        } else {
            echo "- User already exists: " . $userData['nama_pengguna'] . "\n";
        }
    }
    
    echo "\n=== Setup Complete ===\n";
    echo "Test the login system:\n";
    echo "1. Go to: http://localhost:8080/\n";
    echo "2. Click 'Admin Login' button in footer\n";
    echo "3. Login with: admin / Admin@123\n";
    echo "4. You should be redirected to: http://localhost:8080/admin/dashboard\n\n";
    
    echo "Available test accounts:\n";
    echo "- admin / Admin@123 (Super Admin)\n";
    echo "- librarian / Librarian@123 (Pustakawan) - Can't access admin\n";
    echo "- staff / Staff@123 (Staff) - Can't access admin\n\n";
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
    echo "\nPlease check your database configuration:\n";
    echo "- Host: $host\n";
    echo "- Database: $database\n";
    echo "- Username: $username\n";
    echo "- Make sure the database exists and is accessible\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>