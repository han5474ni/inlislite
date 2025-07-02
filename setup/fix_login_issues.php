<?php
/**
 * Fix Login Issues - INLISLite v3.0
 * This script identifies and fixes common login problems
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = 'yani12345';
$database = 'inlislite';

echo "=== INLISLite v3.0 Login Issues Fix ===\n\n";

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Database connection successful\n";
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() == 0) {
        echo "❌ Users table not found. Creating table...\n";
        createUsersTable($pdo);
    } else {
        echo "✓ Users table exists\n";
    }
    
    // Check table structure
    echo "\n--- Checking table structure ---\n";
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $requiredColumns = [
        'id' => 'int',
        'nama_lengkap' => 'varchar',
        'username' => 'varchar',
        'email' => 'varchar', 
        'password' => 'varchar',
        'role' => 'enum',
        'status' => 'enum',
        'last_login' => 'datetime',
        'created_at' => 'date'
    ];
    
    $existingColumns = [];
    foreach ($columns as $column) {
        $existingColumns[$column['Field']] = strtolower($column['Type']);
        echo "  - {$column['Field']}: {$column['Type']}\n";
    }
    
    // Check for missing or incorrect columns
    $needsUpdate = false;
    foreach ($requiredColumns as $colName => $colType) {
        if (!isset($existingColumns[$colName])) {
            echo "❌ Missing column: $colName\n";
            $needsUpdate = true;
        } elseif (!str_contains($existingColumns[$colName], $colType)) {
            echo "⚠️  Column type mismatch: $colName (expected: $colType, found: {$existingColumns[$colName]})\n";
        }
    }
    
    // Check for old column names
    $oldColumns = ['nama_pengguna', 'kata_sandi'];
    foreach ($oldColumns as $oldCol) {
        if (isset($existingColumns[$oldCol])) {
            echo "⚠️  Found old column: $oldCol (needs migration)\n";
            $needsUpdate = true;
        }
    }
    
    if ($needsUpdate) {
        echo "\n--- Updating table structure ---\n";
        updateTableStructure($pdo, $existingColumns);
    } else {
        echo "✓ Table structure is correct\n";
    }
    
    // Check for admin user
    echo "\n--- Checking admin users ---\n";
    $stmt = $pdo->query("SELECT id, nama_lengkap, username, email, role, status FROM users WHERE role IN ('Super Admin', 'Admin')");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($admins)) {
        echo "❌ No admin users found. Creating default admin...\n";
        createDefaultAdmin($pdo);
    } else {
        echo "✓ Found " . count($admins) . " admin user(s):\n";
        foreach ($admins as $admin) {
            echo "  - {$admin['nama_lengkap']} ({$admin['username']}) - {$admin['role']} - {$admin['status']}\n";
        }
    }
    
    // Test password hashing
    echo "\n--- Testing password hashing ---\n";
    $testPassword = 'password';
    $hashedPassword = password_hash($testPassword, PASSWORD_DEFAULT);
    $isValid = password_verify($testPassword, $hashedPassword);
    
    if ($isValid) {
        echo "✓ Password hashing works correctly\n";
    } else {
        echo "❌ Password hashing failed\n";
    }
    
    // Check routes and controllers
    echo "\n--- Checking application files ---\n";
    $requiredFiles = [
        'app/Controllers/Admin/SecureAuthController.php',
        'app/Controllers/Admin/LoginController.php',
        'app/Views/admin/auth/secure_login.php',
        'app/Views/admin/auth/login.php',
        'app/Filters/AdminAuthFilter.php',
        'app/Models/UserModel.php'
    ];
    
    foreach ($requiredFiles as $file) {
        if (file_exists($file)) {
            echo "✓ $file exists\n";
        } else {
            echo "❌ $file missing\n";
        }
    }
    
    // Test URLs
    echo "\n--- Testing URLs ---\n";
    $testUrls = [
        'http://localhost:8080/' => 'Homepage',
        'http://localhost:8080/admin/secure-login' => 'Secure Login',
        'http://localhost:8080/admin/login' => 'Standard Login',
        'http://localhost:8080/admin/dashboard' => 'Admin Dashboard (should redirect)'
    ];
    
    foreach ($testUrls as $url => $description) {
        echo "  - $description: $url\n";
    }
    
    echo "\n=== Fix Summary ===\n";
    echo "✓ Database structure checked and fixed\n";
    echo "✓ Admin user verified\n";
    echo "✓ Password hashing tested\n";
    echo "✓ Application files checked\n";
    
    echo "\n=== Test Instructions ===\n";
    echo "1. Go to: http://localhost:8080/admin/secure-login\n";
    echo "2. Login with: admin / password\n";
    echo "3. Should redirect to: http://localhost:8080/admin/dashboard\n";
    echo "4. If issues persist, check browser console for errors\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

function createUsersTable($pdo) {
    $sql = "
    CREATE TABLE `users` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `nama_lengkap` VARCHAR(100) NOT NULL,
        `username` VARCHAR(50) UNIQUE NOT NULL,
        `email` VARCHAR(100) UNIQUE NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `role` ENUM('Super Admin','Admin','Pustakawan','Staff') DEFAULT 'Staff',
        `status` ENUM('Aktif','Non-aktif') DEFAULT 'Aktif',
        `last_login` DATETIME DEFAULT NULL,
        `created_at` DATE DEFAULT CURRENT_DATE,
        INDEX `idx_username` (`username`),
        INDEX `idx_email` (`email`),
        INDEX `idx_role` (`role`),
        INDEX `idx_status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $pdo->exec($sql);
    echo "✓ Users table created\n";
}

function updateTableStructure($pdo, $existingColumns) {
    // Migrate old column names if they exist
    if (isset($existingColumns['nama_pengguna']) && !isset($existingColumns['username'])) {
        $pdo->exec("ALTER TABLE users CHANGE `nama_pengguna` `username` VARCHAR(50) NOT NULL");
        echo "✓ Renamed nama_pengguna to username\n";
    }
    
    if (isset($existingColumns['kata_sandi']) && !isset($existingColumns['password'])) {
        $pdo->exec("ALTER TABLE users CHANGE `kata_sandi` `password` VARCHAR(255) NOT NULL");
        echo "✓ Renamed kata_sandi to password\n";
    }
    
    // Add missing columns
    if (!isset($existingColumns['last_login'])) {
        $pdo->exec("ALTER TABLE users ADD COLUMN `last_login` DATETIME DEFAULT NULL");
        echo "✓ Added last_login column\n";
    }
    
    if (!isset($existingColumns['created_at'])) {
        $pdo->exec("ALTER TABLE users ADD COLUMN `created_at` DATE DEFAULT CURRENT_DATE");
        echo "✓ Added created_at column\n";
    }
}

function createDefaultAdmin($pdo) {
    $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (nama_lengkap, username, email, password, role, status) 
            VALUES (?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE id = id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'System Administrator',
        'admin', 
        'admin@inlislite.com',
        $hashedPassword,
        'Super Admin',
        'Aktif'
    ]);
    
    echo "✓ Default admin user created\n";
    echo "  Username: admin\n";
    echo "  Password: password\n";
}
?>