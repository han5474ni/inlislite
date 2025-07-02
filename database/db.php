<?php
/**
 * Database Connection for INLISlite v3.0
 * MySQL connection configuration
 */

$host = "localhost";
$user = "root";
$pass = "yani12345";
$db = "inlislite";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8");

// Function to create users table if not exists
function createUsersTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_lengkap VARCHAR(100) NOT NULL,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('Super Admin','Admin','Pustakawan','Staff') DEFAULT 'Staff',
        status ENUM('Aktif','Non-aktif') DEFAULT 'Aktif',
        last_login DATETIME DEFAULT CURRENT_TIMESTAMP,
        created_at DATE DEFAULT CURRENT_DATE
    )";
    
    if ($conn->query($sql) === TRUE) {
        // Insert default admin user if table is empty
        $check = $conn->query("SELECT COUNT(*) as count FROM users");
        $row = $check->fetch_assoc();
        
        if ($row['count'] == 0) {
            $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $insertAdmin = "INSERT INTO users (nama_lengkap, username, email, password, role, status) 
                           VALUES ('System Administrator', 'admin', 'admin@inlislite.com', '$defaultPassword', 'Super Admin', 'Aktif')";
            $conn->query($insertAdmin);
        }
    }
}

// Create table on connection
createUsersTable($conn);
?>