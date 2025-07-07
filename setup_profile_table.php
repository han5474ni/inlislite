<?php
/**
 * Setup Profile Table for INLISLite
 * This script creates the profile table and inserts sample data
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'inlislite';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Setting up Profile Table for INLISLite</h2>\n";
    
    // Drop existing profile table if it exists
    $pdo->exec("DROP TABLE IF EXISTS `profile`");
    echo "✓ Dropped existing profile table (if any)<br>\n";
    
    // Create profile table
    $createTableSQL = "
    CREATE TABLE `profile` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `foto` varchar(255) DEFAULT NULL,
        `nama` varchar(255) NOT NULL,
        `username` varchar(100) NOT NULL,
        `email` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `role` enum('Super Admin','Admin','Pustakawan','Staff') NOT NULL DEFAULT 'Staff',
        `status` enum('Aktif','Non-aktif','Ditangguhkan') NOT NULL DEFAULT 'Aktif',
        `last_login` datetime DEFAULT NULL,
        `nama_lengkap` varchar(255) DEFAULT NULL,
        `nama_pengguna` varchar(100) DEFAULT NULL,
        `kata_sandi` varchar(255) DEFAULT NULL,
        `phone` varchar(20) DEFAULT NULL,
        `address` text DEFAULT NULL,
        `bio` text DEFAULT NULL,
        `created_at` datetime DEFAULT NULL,
        `updated_at` datetime DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_username` (`username`),
        UNIQUE KEY `unique_email` (`email`),
        KEY `idx_username` (`username`),
        KEY `idx_email` (`email`),
        KEY `idx_status` (`status`),
        KEY `idx_role` (`role`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $pdo->exec($createTableSQL);
    echo "✓ Created profile table<br>\n";
    
    // Insert sample data
    $sampleData = [
        [
            'foto' => null,
            'nama' => 'Administrator Sistem',
            'username' => 'admin',
            'email' => 'admin@inlislite.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'Super Admin',
            'status' => 'Aktif',
            'last_login' => date('Y-m-d H:i:s'),
            'nama_lengkap' => 'Administrator Sistem',
            'nama_pengguna' => 'admin',
            'kata_sandi' => password_hash('admin123', PASSWORD_DEFAULT),
            'phone' => null,
            'address' => null,
            'bio' => 'System Administrator for INLISLite v3.0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'foto' => null,
            'nama' => 'Jane Smith',
            'username' => 'librarian',
            'email' => 'librarian@library.com',
            'password' => password_hash('librarian123', PASSWORD_DEFAULT),
            'role' => 'Pustakawan',
            'status' => 'Aktif',
            'last_login' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'nama_lengkap' => 'Jane Smith',
            'nama_pengguna' => 'librarian',
            'kata_sandi' => password_hash('librarian123', PASSWORD_DEFAULT),
            'phone' => '+62812345678',
            'address' => 'Jl. Perpustakaan No. 123, Jakarta',
            'bio' => 'Experienced librarian with 5+ years in library management',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'foto' => null,
            'nama' => 'Mike Johnson',
            'username' => 'staff1',
            'email' => 'staff1@staff.com',
            'password' => password_hash('staff123', PASSWORD_DEFAULT),
            'role' => 'Staff',
            'status' => 'Non-aktif',
            'last_login' => date('Y-m-d H:i:s', strtotime('-5 days')),
            'nama_lengkap' => 'Mike Johnson',
            'nama_pengguna' => 'staff1',
            'kata_sandi' => password_hash('staff123', PASSWORD_DEFAULT),
            'phone' => '+62823456789',
            'address' => 'Jl. Staff No. 456, Bandung',
            'bio' => 'Library staff member specializing in cataloging',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'foto' => null,
            'nama' => 'Sarah Wilson',
            'username' => 'admin2',
            'email' => 'admin2@inlislite.com',
            'password' => password_hash('admin456', PASSWORD_DEFAULT),
            'role' => 'Admin',
            'status' => 'Aktif',
            'last_login' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            'nama_lengkap' => 'Sarah Wilson',
            'nama_pengguna' => 'admin2',
            'kata_sandi' => password_hash('admin456', PASSWORD_DEFAULT),
            'phone' => '+62834567890',
            'address' => 'Jl. Admin No. 789, Surabaya',
            'bio' => 'System administrator and technical support specialist',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]
    ];
    
    $insertSQL = "INSERT INTO `profile` (
        `foto`, `nama`, `username`, `email`, `password`, `role`, `status`, `last_login`,
        `nama_lengkap`, `nama_pengguna`, `kata_sandi`, `phone`, `address`, `bio`,
        `created_at`, `updated_at`
    ) VALUES (
        :foto, :nama, :username, :email, :password, :role, :status, :last_login,
        :nama_lengkap, :nama_pengguna, :kata_sandi, :phone, :address, :bio,
        :created_at, :updated_at
    )";
    
    $stmt = $pdo->prepare($insertSQL);
    
    foreach ($sampleData as $data) {
        $stmt->execute($data);
    }
    
    echo "✓ Inserted " . count($sampleData) . " sample profiles<br>\n";
    
    // Create uploads directory for profile photos
    $uploadsDir = __DIR__ . '/public/uploads/profiles';
    if (!is_dir($uploadsDir)) {
        if (mkdir($uploadsDir, 0755, true)) {
            echo "✓ Created uploads/profiles directory<br>\n";
        } else {
            echo "⚠ Failed to create uploads/profiles directory<br>\n";
        }
    } else {
        echo "✓ uploads/profiles directory already exists<br>\n";
    }
    
    // Display created profiles
    $stmt = $pdo->query("SELECT id, nama, username, email, role, status FROM profile ORDER BY id");
    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Created Profiles:</h3>\n";
    echo "<table border='1' cellpadding='5' cellspacing='0'>\n";
    echo "<tr><th>ID</th><th>Name</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th></tr>\n";
    
    foreach ($profiles as $profile) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($profile['id']) . "</td>";
        echo "<td>" . htmlspecialchars($profile['nama']) . "</td>";
        echo "<td>" . htmlspecialchars($profile['username']) . "</td>";
        echo "<td>" . htmlspecialchars($profile['email']) . "</td>";
        echo "<td>" . htmlspecialchars($profile['role']) . "</td>";
        echo "<td>" . htmlspecialchars($profile['status']) . "</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
    
    echo "<h3>Setup Complete!</h3>\n";
    echo "<p>✓ Profile table created successfully</p>\n";
    echo "<p>✓ Sample data inserted</p>\n";
    echo "<p>✓ Upload directory created</p>\n";
    echo "<p><strong>You can now access the profile page at: <a href='/admin/profile'>/admin/profile</a></strong></p>\n";
    echo "<p><strong>Login credentials:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Username: admin, Password: admin123 (Super Admin)</li>\n";
    echo "<li>Username: librarian, Password: librarian123 (Pustakawan)</li>\n";
    echo "<li>Username: staff1, Password: staff123 (Staff)</li>\n";
    echo "<li>Username: admin2, Password: admin456 (Admin)</li>\n";
    echo "</ul>\n";
    
} catch (PDOException $e) {
    echo "<h3>Error:</h3>\n";
    echo "<p style='color: red;'>Database error: " . $e->getMessage() . "</p>\n";
    echo "<p>Please check your database configuration and try again.</p>\n";
} catch (Exception $e) {
    echo "<h3>Error:</h3>\n";
    echo "<p style='color: red;'>General error: " . $e->getMessage() . "</p>\n";
}
?>