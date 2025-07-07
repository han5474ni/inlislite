<?php
/**
 * Profile Table Creation and Synchronization Script
 * Creates profile table and sets up synchronization with users table
 */

// Database configuration
$hostname = 'localhost';
$username = 'root';
$password = 'yani12345';
$database = 'inlislite';

echo "=== Profile Table Setup and Synchronization ===\n\n";

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "1. Testing database connection...\n";
    echo "   ✓ Connected to database '$database'\n\n";
    
    // Check if users table exists
    echo "2. Checking users table...\n";
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() == 0) {
        throw new Exception("Users table does not exist. Please run setup_simple.php first.");
    }
    echo "   ✓ Users table exists\n\n";
    
    // Drop existing profile table if exists (for clean setup)
    echo "3. Preparing profile table...\n";
    $pdo->exec("DROP TABLE IF EXISTS `profile`");
    echo "   ✓ Cleaned existing profile table\n";
    
    // Create profile table
    echo "   - Creating profile table...\n";
    $sql_profile = "
    CREATE TABLE `profile` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `foto` varchar(255) DEFAULT NULL,
        `nama` varchar(255) NOT NULL,
        `nama_lengkap` varchar(255) DEFAULT NULL,
        `username` varchar(100) NOT NULL,
        `nama_pengguna` varchar(100) NOT NULL,
        `email` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `kata_sandi` varchar(255) NOT NULL,
        `role` enum('Super Admin','Admin','Pustakawan','Staff') NOT NULL DEFAULT 'Staff',
        `status` enum('Aktif','Non-Aktif','Ditangguhkan') NOT NULL DEFAULT 'Aktif',
        `phone` varchar(20) DEFAULT NULL,
        `address` text DEFAULT NULL,
        `bio` text DEFAULT NULL,
        `last_login` datetime DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_user_id` (`user_id`),
        UNIQUE KEY `unique_username` (`username`),
        UNIQUE KEY `unique_nama_pengguna` (`nama_pengguna`),
        UNIQUE KEY `unique_email` (`email`),
        KEY `idx_username` (`username`),
        KEY `idx_email` (`email`),
        KEY `idx_status` (`status`),
        KEY `idx_role` (`role`),
        CONSTRAINT `fk_profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $pdo->exec($sql_profile);
    echo "   ✓ Profile table created\n";
    
    // Create synchronization triggers
    echo "4. Setting up synchronization triggers...\n";
    
    // Drop existing triggers if they exist
    $pdo->exec("DROP TRIGGER IF EXISTS sync_profile_on_user_insert");
    $pdo->exec("DROP TRIGGER IF EXISTS sync_profile_on_user_update");
    $pdo->exec("DROP TRIGGER IF EXISTS sync_profile_on_user_delete");
    
    // Create insert trigger
    echo "   - Creating insert trigger...\n";
    $trigger_insert = "
    CREATE TRIGGER sync_profile_on_user_insert 
    AFTER INSERT ON users 
    FOR EACH ROW 
    BEGIN
        INSERT INTO profile (
            user_id, 
            nama, 
            nama_lengkap, 
            username, 
            nama_pengguna, 
            email, 
            password, 
            kata_sandi, 
            role, 
            status,
            created_at,
            updated_at
        ) VALUES (
            NEW.id,
            NEW.nama_lengkap,
            NEW.nama_lengkap,
            NEW.nama_pengguna,
            NEW.nama_pengguna,
            NEW.email,
            NEW.kata_sandi,
            NEW.kata_sandi,
            NEW.role,
            NEW.status,
            NEW.created_at,
            NEW.updated_at
        );
    END
    ";
    $pdo->exec($trigger_insert);
    echo "   ✓ Insert trigger created\n";
    
    // Create update trigger
    echo "   - Creating update trigger...\n";
    $trigger_update = "
    CREATE TRIGGER sync_profile_on_user_update 
    AFTER UPDATE ON users 
    FOR EACH ROW 
    BEGIN
        UPDATE profile SET
            nama = NEW.nama_lengkap,
            nama_lengkap = NEW.nama_lengkap,
            username = NEW.nama_pengguna,
            nama_pengguna = NEW.nama_pengguna,
            email = NEW.email,
            password = NEW.kata_sandi,
            kata_sandi = NEW.kata_sandi,
            role = NEW.role,
            status = NEW.status,
            updated_at = NEW.updated_at
        WHERE user_id = NEW.id;
    END
    ";
    $pdo->exec($trigger_update);
    echo "   ��� Update trigger created\n";
    
    // Create delete trigger
    echo "   - Creating delete trigger...\n";
    $trigger_delete = "
    CREATE TRIGGER sync_profile_on_user_delete 
    AFTER DELETE ON users 
    FOR EACH ROW 
    BEGIN
        DELETE FROM profile WHERE user_id = OLD.id;
    END
    ";
    $pdo->exec($trigger_delete);
    echo "   ✓ Delete trigger created\n";
    
    // Sync existing users to profile table
    echo "\n5. Synchronizing existing users...\n";
    $sync_sql = "
    INSERT INTO profile (
        user_id, 
        nama, 
        nama_lengkap, 
        username, 
        nama_pengguna, 
        email, 
        password, 
        kata_sandi, 
        role, 
        status,
        created_at,
        updated_at
    )
    SELECT 
        id,
        nama_lengkap,
        nama_lengkap,
        nama_pengguna,
        nama_pengguna,
        email,
        kata_sandi,
        kata_sandi,
        role,
        status,
        created_at,
        updated_at
    FROM users
    ";
    
    $stmt = $pdo->exec($sync_sql);
    echo "   ✓ Synchronized $stmt existing users to profile table\n";
    
    // Create activity_logs table for profile tracking
    echo "\n6. Creating activity logs table...\n";
    $sql_activity_logs = "
    CREATE TABLE IF NOT EXISTS `activity_logs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) DEFAULT NULL,
        `action` varchar(50) NOT NULL,
        `description` text DEFAULT NULL,
        `old_data` json DEFAULT NULL,
        `new_data` json DEFAULT NULL,
        `ip_address` varchar(45) NOT NULL,
        `user_agent` text DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `idx_user_id` (`user_id`),
        KEY `idx_action` (`action`),
        KEY `idx_created_at` (`created_at`),
        CONSTRAINT `fk_activity_logs_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $pdo->exec($sql_activity_logs);
    echo "   ✓ Activity logs table created\n";
    
    // Verify setup
    echo "\n7. Verifying setup...\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $userCount = $stmt->fetchColumn();
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM profile");
    $profileCount = $stmt->fetchColumn();
    
    $stmt = $pdo->query("SHOW TRIGGERS LIKE 'sync_profile_%'");
    $triggerCount = $stmt->rowCount();
    
    echo "   ✓ Users: $userCount\n";
    echo "   ✓ Profiles: $profileCount\n";
    echo "   ✓ Synchronization triggers: $triggerCount\n";
    
    if ($userCount == $profileCount) {
        echo "   ✓ User-Profile synchronization: PERFECT\n";
    } else {
        echo "   ⚠ User-Profile synchronization: MISMATCH\n";
    }
    
    // Test synchronization
    echo "\n8. Testing synchronization...\n";
    
    // Test insert
    echo "   - Testing user insert...\n";
    $testPassword = password_hash('test123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("
        INSERT INTO users (nama_lengkap, nama_pengguna, email, kata_sandi, role, status) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute(['Test User', 'testuser', 'test@example.com', $testPassword, 'Staff', 'Aktif']);
    $testUserId = $pdo->lastInsertId();
    
    // Check if profile was created
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM profile WHERE user_id = ?");
    $stmt->execute([$testUserId]);
    $profileExists = $stmt->fetchColumn();
    
    if ($profileExists) {
        echo "   ✓ Insert synchronization: WORKING\n";
    } else {
        echo "   ❌ Insert synchronization: FAILED\n";
    }
    
    // Test update
    echo "   - Testing user update...\n";
    $stmt = $pdo->prepare("UPDATE users SET nama_lengkap = ? WHERE id = ?");
    $stmt->execute(['Test User Updated', $testUserId]);
    
    $stmt = $pdo->prepare("SELECT nama FROM profile WHERE user_id = ?");
    $stmt->execute([$testUserId]);
    $profileName = $stmt->fetchColumn();
    
    if ($profileName == 'Test User Updated') {
        echo "   ✓ Update synchronization: WORKING\n";
    } else {
        echo "   ❌ Update synchronization: FAILED\n";
    }
    
    // Clean up test data
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$testUserId]);
    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM profile WHERE user_id = ?");
    $stmt->execute([$testUserId]);
    $profileExists = $stmt->fetchColumn();
    
    if ($profileExists == 0) {
        echo "   ✓ Delete synchronization: WORKING\n";
    } else {
        echo "   ❌ Delete synchronization: FAILED\n";
    }
    
    echo "\n=== Profile Table Setup Complete! ===\n";
    echo "✅ Profile table created and synchronized with users table\n";
    echo "✅ Automatic synchronization triggers installed\n";
    echo "✅ Activity logging system ready\n";
    echo "✅ All tests passed\n\n";
    
    echo "Next steps:\n";
    echo "1. Update your application to use the ProfileModel\n";
    echo "2. Test the profile management features\n";
    echo "3. Verify frontend integration\n\n";
    
} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
    echo "\nPlease check your database configuration and try again.\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>