<?php
/**
 * Simple Database Setup Script for INLISLite v3
 */

// Database configuration
$hostname = 'localhost';
$username = 'root';
$password = 'yani12345';
$database = 'inlislite';

echo "=== INLISLite v3 Database Setup ===\n\n";

try {
    // Connect to MySQL without specifying database first
    $pdo = new PDO("mysql:host=$hostname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "1. Testing database connection...\n";
    echo "   ✓ MySQL connection successful\n\n";
    
    // Create database if it doesn't exist
    echo "2. Creating database '$database'...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "   ✓ Database '$database' created/verified\n\n";
    
    // Connect to the specific database
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "3. Creating required tables...\n";
    
    // Create users table
    echo "   - Creating 'users' table...\n";
    $sql_users = "
    CREATE TABLE IF NOT EXISTS `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `nama_lengkap` varchar(255) NOT NULL,
      `nama_pengguna` varchar(50) NOT NULL UNIQUE,
      `email` varchar(255) NOT NULL UNIQUE,
      `kata_sandi` varchar(255) NOT NULL,
      `role` enum('Super Admin','Admin','Pustakawan','Staff') NOT NULL DEFAULT 'Staff',
      `status` enum('Aktif','Non-Aktif','Ditangguhkan') NOT NULL DEFAULT 'Aktif',
      `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `idx_username` (`nama_pengguna`),
      KEY `idx_email` (`email`),
      KEY `idx_status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql_users);
    echo "     ✓ 'users' table created\n";
    
    // Create registrations table
    echo "   - Creating 'registrations' table...\n";
    $sql_registrations = "
    CREATE TABLE IF NOT EXISTS `registrations` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `library_name` varchar(255) NOT NULL,
      `province` varchar(100) NOT NULL,
      `city` varchar(100) NOT NULL,
      `email` varchar(255) NOT NULL,
      `phone` varchar(20) NULL,
      `status` enum('pending', 'verified', 'rejected') NOT NULL DEFAULT 'pending',
      `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `verified_at` datetime NULL,
      PRIMARY KEY (`id`),
      KEY `idx_status` (`status`),
      KEY `idx_created_at` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql_registrations);
    echo "     ✓ 'registrations' table created\n";
    
    // Create documents table
    echo "   - Creating 'documents' table...\n";
    $sql_documents = "
    CREATE TABLE IF NOT EXISTS `documents` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `description` text,
      `file_name` varchar(255) NOT NULL,
      `file_path` varchar(500) NOT NULL,
      `file_size` int(11) NOT NULL,
      `file_type` varchar(10) NOT NULL,
      `version` varchar(50) DEFAULT NULL,
      `download_count` int(11) DEFAULT 0,
      `status` enum('active','inactive') NOT NULL DEFAULT 'active',
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `idx_file_type` (`file_type`),
      KEY `idx_status` (`status`),
      KEY `idx_created_at` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql_documents);
    echo "     ✓ 'documents' table created\n";
    
    // Create patches table
    echo "   - Creating 'patches' table...\n";
    $sql_patches = "
    CREATE TABLE IF NOT EXISTS `patches` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `description` text,
      `version` varchar(50) NOT NULL,
      `release_date` date NOT NULL,
      `file_name` varchar(255) NOT NULL,
      `file_path` varchar(500) NOT NULL,
      `file_size` int(11) NOT NULL,
      `download_count` int(11) DEFAULT 0,
      `status` enum('active','inactive') NOT NULL DEFAULT 'active',
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `idx_version` (`version`),
      KEY `idx_status` (`status`),
      KEY `idx_release_date` (`release_date`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql_patches);
    echo "     ✓ 'patches' table created\n\n";
    
    echo "4. Inserting sample data...\n";
    
    // Insert admin user
    echo "   - Adding default admin user...\n";
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE nama_pengguna = 'admin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("
            INSERT INTO users (nama_lengkap, nama_pengguna, email, kata_sandi, role, status) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute(['Administrator', 'admin', 'admin@inlislite.com', $adminPassword, 'Super Admin', 'Aktif']);
        echo "     ✓ Admin user created (username: admin, password: admin123)\n";
    } else {
        echo "     ⚠ Admin user already exists\n";
    }
    
    // Insert sample registrations
    echo "   - Adding sample registrations...\n";
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM registrations");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $sampleRegistrations = [
            ['Perpustakaan Umum Jakarta', 'DKI Jakarta', 'Jakarta Pusat', 'jakarta@perpus.go.id', '021-12345678', 'verified'],
            ['Perpustakaan Kota Surabaya', 'Jawa Timur', 'Surabaya', 'surabaya@perpus.go.id', '031-87654321', 'pending'],
            ['Perpustakaan Daerah Bandung', 'Jawa Barat', 'Bandung', 'bandung@perpus.go.id', '022-98765432', 'verified']
        ];
        
        $stmt = $pdo->prepare("
            INSERT INTO registrations (library_name, province, city, email, phone, status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        
        foreach ($sampleRegistrations as $reg) {
            $stmt->execute($reg);
        }
        echo "     ✓ Sample registrations added\n";
    } else {
        echo "     ⚠ Registration data already exists\n";
    }
    
    // Insert sample documents
    echo "   - Adding sample documents...\n";
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM documents");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $sampleDocuments = [
            [
                'title' => 'Panduan Pengguna INLISLite v3 - Modul Lengkap',
                'description' => 'Panduan komprehensif yang mencakup semua modul dan fitur INLISLite v3',
                'file_name' => 'panduan_lengkap_v3.2.1.pdf',
                'file_path' => 'uploads/documents/panduan_lengkap_v3.2.1.pdf',
                'file_size' => 12582912,
                'file_type' => 'PDF',
                'version' => 'V3.2.1',
                'status' => 'active'
            ],
            [
                'title' => 'Panduan Praktis - Pengaturan Administrasi',
                'description' => 'Panduan langkah demi langkah untuk mengonfigurasi pengaturan administratif',
                'file_name' => 'panduan_admin_v3.2.0.pdf',
                'file_path' => 'uploads/documents/panduan_admin_v3.2.0.pdf',
                'file_size' => 1887436,
                'file_type' => 'PDF',
                'version' => 'V3.2.0',
                'status' => 'active'
            ]
        ];
        
        $stmt = $pdo->prepare("
            INSERT INTO documents (title, description, file_name, file_path, file_size, file_type, version, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($sampleDocuments as $doc) {
            $stmt->execute($doc);
        }
        echo "     ✓ Sample documents added\n";
    } else {
        echo "     ⚠ Document data already exists\n";
    }
    
    echo "\n5. Verifying setup...\n";
    
    // Verify data
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    $userCount = $stmt->fetchColumn();
    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM registrations");
    $stmt->execute();
    $regCount = $stmt->fetchColumn();
    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM documents");
    $stmt->execute();
    $docCount = $stmt->fetchColumn();
    
    echo "   ✓ Users: {$userCount}\n";
    echo "   ✓ Registrations: {$regCount}\n";
    echo "   ✓ Documents: {$docCount}\n\n";
    
    echo "=== Database Setup Complete! ===\n";
    echo "You can now access the application at: http://localhost:8080\n";
    echo "Default admin login:\n";
    echo "  Username: admin\n";
    echo "  Password: admin123\n\n";
    
} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
    echo "\nPlease check your database configuration.\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
