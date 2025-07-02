<?php
/**
 * Database Setup Script for INLISLite v3
 * This script will create the documents table and insert sample data
 */

// Load CodeIgniter
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap the framework
$app = \Config\Services::codeigniter();
$app->initialize();

echo "=== INLISLite v3 Database Setup ===\n\n";

try {
    // Get database connection
    $db = \Config\Database::connect();
    
    echo "1. Testing database connection...\n";
    
    // Test connection
    if (!$db->connect()) {
        throw new Exception("Failed to connect to database");
    }
    
    echo "   ✓ Database connection successful\n\n";
    
    echo "2. Creating documents table...\n";
    
    // Check if table exists
    if ($db->tableExists('documents')) {
        echo "   - Table 'documents' already exists, dropping it...\n";
        $db->query("DROP TABLE documents");
    }
    
    // Create documents table
    $sql = "
    CREATE TABLE `documents` (
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
    
    $db->query($sql);
    echo "   ✓ Table 'documents' created successfully\n\n";
    
    echo "3. Inserting sample data...\n";
    
    // Insert sample data
    $sampleData = [
        [
            'title' => 'Panduan Pengguna Revisi 16062016 – Modul Lengkap',
            'description' => 'Panduan komprehensif yang mencakup semua modul dan fitur INLISLite v3',
            'file_name' => 'panduan_lengkap_v3.2.1.pdf',
            'file_path' => 'uploads/documents/panduan_lengkap_v3.2.1.pdf',
            'file_size' => 12582912,
            'file_type' => 'PDF',
            'version' => 'V3.2.1',
            'download_count' => 0,
            'status' => 'active'
        ],
        [
            'title' => 'Panduan Praktis – Pengaturan Administrasi di INLISLite v3',
            'description' => 'Panduan langkah demi langkah untuk mengonfigurasi pengaturan administratif',
            'file_name' => 'panduan_admin_v3.2.0.pdf',
            'file_path' => 'uploads/documents/panduan_admin_v3.2.0.pdf',
            'file_size' => 1887436,
            'file_type' => 'PDF',
            'version' => 'V3.2.0',
            'download_count' => 0,
            'status' => 'active'
        ],
        [
            'title' => 'Panduan Praktis – Manajemen Bahan Pustaka di INLISLite v3',
            'description' => 'Panduan untuk mengelola koleksi bahan pustaka secara efektif',
            'file_name' => 'panduan_bahan_pustaka_v3.2.0.pdf',
            'file_path' => 'uploads/documents/panduan_bahan_pustaka_v3.2.0.pdf',
            'file_size' => 1887436,
            'file_type' => 'PDF',
            'version' => 'V3.2.0',
            'download_count' => 0,
            'status' => 'active'
        ],
        [
            'title' => 'Panduan Praktis – Manajemen Keanggotaan di INLISLite v3',
            'description' => 'Manual pengguna untuk mengelola akun dan profil anggota perpustakaan',
            'file_name' => 'panduan_keanggotaan_v3.2.0.pdf',
            'file_path' => 'uploads/documents/panduan_keanggotaan_v3.2.0.pdf',
            'file_size' => 1782579,
            'file_type' => 'PDF',
            'version' => 'V3.2.0',
            'download_count' => 0,
            'status' => 'active'
        ],
        [
            'title' => 'Panduan Praktis – Sistem Sirkulasi di INLISLite v3',
            'description' => 'Panduan untuk mengelola peminjaman dan pengembalian buku',
            'file_name' => 'panduan_sirkulasi_v3.2.0.pdf',
            'file_path' => 'uploads/documents/panduan_sirkulasi_v3.2.0.pdf',
            'file_size' => 1782579,
            'file_type' => 'PDF',
            'version' => 'V3.2.0',
            'download_count' => 0,
            'status' => 'active'
        ],
        [
            'title' => 'Panduan Praktis – Pembuatan Survei di INLISLite v3',
            'description' => 'Panduan untuk membuat dan mengelola survei serta umpan balik perpustakaan',
            'file_name' => 'panduan_survei_v3.1.5.pdf',
            'file_path' => 'uploads/documents/panduan_survei_v3.1.5.pdf',
            'file_size' => 1468006,
            'file_type' => 'PDF',
            'version' => 'V3.1.5',
            'download_count' => 0,
            'status' => 'active'
        ]
    ];
    
    $builder = $db->table('documents');
    $builder->insertBatch($sampleData);
    
    echo "   ✓ Sample data inserted successfully\n\n";
    
    echo "4. Verifying setup...\n";
    
    // Verify data
    $count = $db->table('documents')->countAll();
    echo "   ✓ Total documents in database: {$count}\n\n";
    
    echo "=== Database Setup Complete! ===\n";
    echo "You can now access the documents management at: http://localhost/panduan\n\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nPlease check your database configuration in app/Config/Database.php\n";
    exit(1);
}
?>
