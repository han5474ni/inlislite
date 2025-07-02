<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - INLISLite v3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">INLISLite v3 - Database Setup</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            try {
                                // Database configuration from CodeIgniter
                                $hostname = 'localhost';
                                $username = 'root';
                                $password = 'yani12345';
                                $database = 'inlislite';
                                
                                echo '<div class="alert alert-info">Connecting to database...</div>';
                                
                                // Create connection
                                $conn = new mysqli($hostname, $username, $password, $database);
                                
                                // Check connection
                                if ($conn->connect_error) {
                                    throw new Exception("Connection failed: " . $conn->connect_error);
                                }
                                
                                echo '<div class="alert alert-success">✓ Connected to database successfully</div>';
                                
                                // Drop table if exists
                                echo '<div class="alert alert-info">Dropping existing documents table (if exists)...</div>';
                                $conn->query("DROP TABLE IF EXISTS `documents`");
                                
                                // Create documents table
                                echo '<div class="alert alert-info">Creating documents table...</div>';
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
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                                ";
                                
                                if ($conn->query($sql) === TRUE) {
                                    echo '<div class="alert alert-success">✓ Table documents created successfully</div>';
                                } else {
                                    throw new Exception("Error creating table: " . $conn->error);
                                }
                                
                                // Insert sample data
                                echo '<div class="alert alert-info">Inserting sample data...</div>';
                                $insertSql = "
                                INSERT INTO `documents` (`title`, `description`, `file_name`, `file_path`, `file_size`, `file_type`, `version`, `download_count`, `status`) VALUES
                                ('Panduan Pengguna Revisi 16062016 – Modul Lengkap', 'Panduan komprehensif yang mencakup semua modul dan fitur INLISLite v3', 'panduan_lengkap_v3.2.1.pdf', 'uploads/documents/panduan_lengkap_v3.2.1.pdf', 12582912, 'PDF', 'V3.2.1', 0, 'active'),
                                ('Panduan Praktis – Pengaturan Administrasi di INLISLite v3', 'Panduan langkah demi langkah untuk mengonfigurasi pengaturan administratif', 'panduan_admin_v3.2.0.pdf', 'uploads/documents/panduan_admin_v3.2.0.pdf', 1887436, 'PDF', 'V3.2.0', 0, 'active'),
                                ('Panduan Praktis – Manajemen Bahan Pustaka di INLISLite v3', 'Panduan untuk mengelola koleksi bahan pustaka secara efektif', 'panduan_bahan_pustaka_v3.2.0.pdf', 'uploads/documents/panduan_bahan_pustaka_v3.2.0.pdf', 1887436, 'PDF', 'V3.2.0', 0, 'active'),
                                ('Panduan Praktis – Manajemen Keanggotaan di INLISLite v3', 'Manual pengguna untuk mengelola akun dan profil anggota perpustakaan', 'panduan_keanggotaan_v3.2.0.pdf', 'uploads/documents/panduan_keanggotaan_v3.2.0.pdf', 1782579, 'PDF', 'V3.2.0', 0, 'active'),
                                ('Panduan Praktis – Sistem Sirkulasi di INLISLite v3', 'Panduan untuk mengelola peminjaman dan pengembalian buku', 'panduan_sirkulasi_v3.2.0.pdf', 'uploads/documents/panduan_sirkulasi_v3.2.0.pdf', 1782579, 'PDF', 'V3.2.0', 0, 'active'),
                                ('Panduan Praktis – Pembuatan Survei di INLISLite v3', 'Panduan untuk membuat dan mengelola survei serta umpan balik perpustakaan', 'panduan_survei_v3.1.5.pdf', 'uploads/documents/panduan_survei_v3.1.5.pdf', 1468006, 'PDF', 'V3.1.5', 0, 'active')
                                ";
                                
                                if ($conn->query($insertSql) === TRUE) {
                                    echo '<div class="alert alert-success">✓ Sample data inserted successfully</div>';
                                } else {
                                    throw new Exception("Error inserting data: " . $conn->error);
                                }
                                
                                // Verify data
                                $result = $conn->query("SELECT COUNT(*) as count FROM documents");
                                $row = $result->fetch_assoc();
                                $count = $row['count'];
                                
                                echo '<div class="alert alert-success">✓ Setup completed! Total documents: ' . $count . '</div>';
                                echo '<div class="alert alert-info">
                                        <strong>Next Steps:</strong><br>
                                        1. You can now access: <a href="/panduan" target="_blank">http://localhost/panduan</a><br>
                                        2. Test CRUD functionality with the interface<br>
                                        3. Delete this install_db.php file for security
                                      </div>';
                                
                                $conn->close();
                                
                            } catch (Exception $e) {
                                echo '<div class="alert alert-danger">❌ Error: ' . $e->getMessage() . '</div>';
                                echo '<div class="alert alert-warning">
                                        <strong>Please check:</strong><br>
                                        1. Database credentials in app/Config/Database.php<br>
                                        2. MySQL service is running<br>
                                        3. Database "inlislite" exists
                                      </div>';
                            }
                        } else {
                        ?>
                            <p>This script will create the <code>documents</code> table and insert sample data for the INLISLite v3 document management system.</p>
                            
                            <div class="alert alert-warning">
                                <strong>Before running:</strong>
                                <ul class="mb-0">
                                    <li>Make sure your database "inlislite" exists</li>
                                    <li>Verify database credentials in <code>app/Config/Database.php</code></li>
                                    <li>Ensure MySQL service is running</li>
                                </ul>
                            </div>
                            
                            <form method="post">
                                <button type="submit" class="btn btn-primary btn-lg">Setup Database</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
                
                <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST') { ?>
                <div class="mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Alternative Setup Methods</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Option 1:</strong> Run the SQL script manually in phpMyAdmin:</p>
                            <ol>
                                <li>Open phpMyAdmin</li>
                                <li>Select the "inlislite" database</li>
                                <li>Go to SQL tab</li>
                                <li>Copy and paste content from <code>quick_setup.sql</code></li>
                                <li>Click "Go"</li>
                            </ol>
                            
                            <p><strong>Option 2:</strong> Use CodeIgniter migration:</p>
                            <ol>
                                <li>Open terminal in project directory</li>
                                <li>Run: <code>php spark migrate</code></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
