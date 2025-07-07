<?php
/**
 * Create Profile Database Table
 * This script creates the profile table for INLISLite v3.0
 */

// Database configuration
$host = 'localhost';
$dbname = 'inlislite';
$username = 'root';
$password = '';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Creating Profile Database Table ===\n\n";
    
    // Check if profile table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'profile'");
    if ($stmt->rowCount() > 0) {
        echo "⚪ Profile table already exists.\n";
        
        // Check existing columns
        $stmt = $pdo->query("DESCRIBE profile");
        $existingColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "Existing columns: " . implode(', ', $existingColumns) . "\n\n";
    } else {
        // Create profile table
        $sql = "CREATE TABLE profile (
            id INT AUTO_INCREMENT PRIMARY KEY,
            foto VARCHAR(255) NULL COMMENT 'Profile photo filename',
            nama VARCHAR(255) NOT NULL COMMENT 'Full name',
            username VARCHAR(100) NOT NULL UNIQUE COMMENT 'Username for login',
            email VARCHAR(255) NOT NULL UNIQUE COMMENT 'Email address',
            password VARCHAR(255) NOT NULL COMMENT 'Hashed password',
            role ENUM('Super Admin', 'Admin', 'Pustakawan', 'Staff') DEFAULT 'Staff',
            status ENUM('Aktif', 'Non-aktif', 'Ditangguhkan') DEFAULT 'Aktif',
            last_login DATETIME NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        echo "✅ Profile table created successfully!\n\n";
    }
    
    // Create activity_log table for logging activities
    $stmt = $pdo->query("SHOW TABLES LIKE 'activity_log'");
    if ($stmt->rowCount() > 0) {
        echo "⚪ Activity log table already exists.\n";
    } else {
        $sql = "CREATE TABLE activity_log (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            activity_type VARCHAR(50) NOT NULL COMMENT 'Type of activity (login, profile_update, etc.)',
            activity_description TEXT NOT NULL COMMENT 'Description of the activity',
            ip_address VARCHAR(45) NULL COMMENT 'User IP address',
            user_agent TEXT NULL COMMENT 'Browser user agent',
            old_values JSON NULL COMMENT 'Previous values before change',
            new_values JSON NULL COMMENT 'New values after change',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user_id (user_id),
            INDEX idx_activity_type (activity_type),
            INDEX idx_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        echo "✅ Activity log table created successfully!\n\n";
    }
    
    // Check if default admin profile exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM profile WHERE username = ?");
    $stmt->execute(['admin']);
    
    if ($stmt->fetchColumn() == 0) {
        // Create default admin profile
        $stmt = $pdo->prepare("INSERT INTO profile (foto, nama, username, email, password, role, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            null,
            'Administrator',
            'admin',
            'admin@inlislite.com',
            password_hash('admin123', PASSWORD_DEFAULT),
            'Super Admin',
            'Aktif'
        ]);
        
        echo "✅ Default admin profile created!\n";
        echo "   Username: admin\n";
        echo "   Password: admin123\n";
        echo "   Email: admin@inlislite.com\n\n";
    } else {
        echo "⚪ Admin profile already exists.\n\n";
    }
    
    // Create uploads directory for profile photos
    $uploadDir = __DIR__ . '/../public/uploads/profiles';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
        echo "✅ Created profile photos directory: $uploadDir\n";
    } else {
        echo "⚪ Profile photos directory already exists.\n";
    }
    
    // Test the database connection and show sample data
    echo "\n=== Testing Database ===\n";
    $stmt = $pdo->query("SELECT id, nama, username, email, role, status, created_at FROM profile LIMIT 5");
    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total profiles: " . count($profiles) . "\n";
    foreach ($profiles as $profile) {
        echo "- {$profile['nama']} (@{$profile['username']}) - {$profile['role']}\n";
    }
    
    echo "\n=== Setup Complete ===\n";
    echo "✅ Profile database is ready!\n";
    echo "✅ You can now access: http://localhost:8080/admin/profile\n\n";
    
} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>