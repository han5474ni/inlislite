<?php
/**
 * Update Database for Password Reset
 * 
 * This script adds the reset token fields to the users table.
 * Run this script to add forgot password functionality.
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
        echo "Users table does not exist. Please run create_test_admin.php first.\n";
        exit;
    }
    
    echo "Checking if reset token fields exist...\n";
    
    // Check if reset_token column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'reset_token'");
    if ($stmt->rowCount() == 0) {
        echo "Adding reset_token column...\n";
        $pdo->exec("ALTER TABLE users ADD COLUMN reset_token VARCHAR(255) DEFAULT NULL AFTER last_login");
        echo "✓ reset_token column added.\n";
    } else {
        echo "✓ reset_token column already exists.\n";
    }
    
    // Check if reset_token_expires column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'reset_token_expires'");
    if ($stmt->rowCount() == 0) {
        echo "Adding reset_token_expires column...\n";
        $pdo->exec("ALTER TABLE users ADD COLUMN reset_token_expires DATETIME DEFAULT NULL AFTER reset_token");
        echo "✓ reset_token_expires column added.\n";
    } else {
        echo "✓ reset_token_expires column already exists.\n";
    }
    
    echo "\n=== Database Update Complete ===\n";
    echo "Password reset functionality is now available!\n\n";
    
    echo "Test the forgot password flow:\n";
    echo "1. Go to: http://localhost:8080/loginpage\n";
    echo "2. Click 'Forgot your password?' link\n";
    echo "3. Enter admin email: admin@inlislite.local\n";
    echo "4. Check the logs or development alert for reset link\n";
    echo "5. Use the reset link to set a new password\n\n";
    
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