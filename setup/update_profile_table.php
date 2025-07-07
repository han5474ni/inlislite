<?php
/**
 * Update Profile Database Table
 * This script adds additional fields to the profile table for INLISLite v3.0
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
    
    echo "=== Updating Profile Database Table ===\n\n";
    
    // Check if profile table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'profile'");
    if ($stmt->rowCount() == 0) {
        echo "❌ Profile table does not exist. Please run create_profile_database.php first.\n";
        exit;
    }
    
    // Get existing columns
    $stmt = $pdo->query("DESCRIBE profile");
    $existingColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Existing columns: " . implode(', ', $existingColumns) . "\n\n";
    
    // Define additional columns to add
    $columnsToAdd = [
        'nama_lengkap' => "VARCHAR(255) NULL COMMENT 'Full name (alternative field)'",
        'nama_pengguna' => "VARCHAR(100) NULL COMMENT 'Username (alternative field)'",
        'kata_sandi' => "VARCHAR(255) NULL COMMENT 'Password (alternative field)'",
        'phone' => "VARCHAR(20) NULL COMMENT 'Phone number'",
        'address' => "TEXT NULL COMMENT 'Address'",
        'bio' => "TEXT NULL COMMENT 'Biography'"
    ];
    
    // Add missing columns
    foreach ($columnsToAdd as $columnName => $columnDefinition) {
        if (!in_array($columnName, $existingColumns)) {
            $sql = "ALTER TABLE profile ADD COLUMN $columnName $columnDefinition";
            $pdo->exec($sql);
            echo "✅ Added column: $columnName\n";
        } else {
            echo "⚪ Column already exists: $columnName\n";
        }
    }
    
    // Update existing admin profile with additional fields
    $stmt = $pdo->prepare("SELECT * FROM profile WHERE username = ?");
    $stmt->execute(['admin']);
    $adminProfile = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($adminProfile) {
        // Update admin profile with additional data
        $updateData = [];
        $updateFields = [];
        
        if (empty($adminProfile['nama_lengkap'])) {
            $updateFields[] = "nama_lengkap = ?";
            $updateData[] = $adminProfile['nama'];
        }
        
        if (empty($adminProfile['nama_pengguna'])) {
            $updateFields[] = "nama_pengguna = ?";
            $updateData[] = $adminProfile['username'];
        }
        
        if (!empty($updateFields)) {
            $updateData[] = 'admin'; // for WHERE clause
            $sql = "UPDATE profile SET " . implode(', ', $updateFields) . " WHERE username = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($updateData);
            echo "✅ Updated admin profile with additional fields\n";
        }
    }
    
    // Show updated table structure
    echo "\n=== Updated Table Structure ===\n";
    $stmt = $pdo->query("DESCRIBE profile");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo "- {$column['Field']} ({$column['Type']}) - {$column['Comment']}\n";
    }
    
    echo "\n=== Update Complete ===\n";
    echo "✅ Profile table has been updated with additional fields!\n";
    echo "✅ All profile form fields should now save to database properly.\n\n";
    
} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>