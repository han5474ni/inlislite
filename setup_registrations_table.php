<?php
/**
 * Setup script to create registrations table
 */

// Database configuration
$host = 'localhost';
$dbname = 'inlislite';
$username = 'root';
$password = 'yani12345';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.\n";
    
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'registrations'");
    if ($stmt->rowCount() > 0) {
        echo "Table 'registrations' already exists.\n";
        exit;
    }
    
    // Create registrations table
    echo "Creating 'registrations' table...\n";
    $sql = "
        CREATE TABLE registrations (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            library_name VARCHAR(255) NOT NULL,
            library_code VARCHAR(50) NULL,
            library_type ENUM('Public', 'Academic', 'School', 'Special') NOT NULL DEFAULT 'Public',
            province VARCHAR(100) NOT NULL,
            city VARCHAR(100) NOT NULL,
            address TEXT NULL,
            postal_code VARCHAR(10) NULL,
            coordinates VARCHAR(100) NULL,
            contact_name VARCHAR(255) NULL,
            contact_position VARCHAR(100) NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(20) NULL,
            website VARCHAR(255) NULL,
            fax VARCHAR(20) NULL,
            established_year YEAR NULL,
            collection_count INT NULL,
            member_count INT NULL,
            notes TEXT NULL,
            status ENUM('Active', 'Inactive', 'Pending') NOT NULL DEFAULT 'Active',
            created_at DATETIME NULL,
            updated_at DATETIME NULL,
            verified_at DATETIME NULL,
            PRIMARY KEY (id),
            KEY idx_status (status),
            KEY idx_created_at (created_at),
            KEY idx_library_type (library_type)
        ) DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci
    ";
    
    $pdo->exec($sql);
    echo "✓ 'registrations' table created successfully.\n";
    
    // Insert sample data
    echo "Inserting sample data...\n";
    $sampleData = [
        [
            'library_name' => 'Perpustakaan Nasional RI',
            'library_code' => 'PERPUSNAS001',
            'library_type' => 'Public',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Pusat',
            'address' => 'Jl. Salemba Raya No. 28A, Jakarta Pusat',
            'postal_code' => '10430',
            'contact_name' => 'Dr. Muhammad Syarif Bando',
            'contact_position' => 'Kepala Perpustakaan',
            'email' => 'perpusnas@pnri.go.id',
            'phone' => '021-3192-6148',
            'website' => 'https://www.perpusnas.go.id',
            'established_year' => 1980,
            'collection_count' => 500000,
            'member_count' => 25000,
            'status' => 'Active',
            'created_at' => '2024-01-15 09:30:00',
            'updated_at' => '2024-01-16 10:00:00',
            'verified_at' => '2024-01-16 10:00:00'
        ],
        [
            'library_name' => 'Perpustakaan Kota Bandung',
            'library_code' => 'PERPUSKOT002',
            'library_type' => 'Public',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'address' => 'Jl. Seram No. 2, Bandung',
            'postal_code' => '40117',
            'contact_name' => 'Drs. Asep Saepudin',
            'contact_position' => 'Kepala Perpustakaan',
            'email' => 'perpuskotabdg@bandung.go.id',
            'phone' => '022-4264-4315',
            'website' => 'https://perpustakaan.bandung.go.id',
            'established_year' => 1955,
            'collection_count' => 75000,
            'member_count' => 8500,
            'status' => 'Active',
            'created_at' => '2024-02-05 08:45:00',
            'updated_at' => '2024-02-06 16:20:00',
            'verified_at' => '2024-02-06 16:20:00'
        ],
        [
            'library_name' => 'Perpustakaan Universitas Gadjah Mada',
            'library_code' => 'UGM003',
            'library_type' => 'Academic',
            'province' => 'DI Yogyakarta',
            'city' => 'Yogyakarta',
            'address' => 'Bulaksumur, Caturtunggal, Depok, Sleman',
            'postal_code' => '55281',
            'contact_name' => 'Prof. Dr. Ida Fajar Priyanto',
            'contact_position' => 'Kepala Perpustakaan',
            'email' => 'perpus@ugm.ac.id',
            'phone' => '0274-513-163',
            'website' => 'https://lib.ugm.ac.id',
            'established_year' => 1949,
            'collection_count' => 350000,
            'member_count' => 55000,
            'status' => 'Active',
            'created_at' => '2024-03-10 14:45:00',
            'updated_at' => '2024-03-10 14:45:00',
            'verified_at' => '2024-03-10 14:45:00'
        ],
        [
            'library_name' => 'Perpustakaan Universitas Indonesia',
            'library_code' => 'UI004',
            'library_type' => 'Academic',
            'province' => 'Jawa Barat',
            'city' => 'Depok',
            'address' => 'Kampus UI Depok, Pondok Cina, Beji',
            'postal_code' => '16424',
            'contact_name' => 'Dr. Luki Wijayanti',
            'contact_position' => 'Kepala Perpustakaan',
            'email' => 'perpus@ui.ac.id',
            'phone' => '021-7867-222',
            'website' => 'https://lib.ui.ac.id',
            'established_year' => 1950,
            'collection_count' => 400000,
            'member_count' => 47000,
            'status' => 'Active',
            'created_at' => '2024-04-02 09:10:00',
            'updated_at' => '2024-04-03 11:25:00',
            'verified_at' => '2024-04-03 11:25:00'
        ],
        [
            'library_name' => 'Perpustakaan Daerah Jawa Timur',
            'library_code' => 'JATIM005',
            'library_type' => 'Public',
            'province' => 'Jawa Timur',
            'city' => 'Surabaya',
            'address' => 'Jl. Menur Pumpungan No. 32, Surabaya',
            'postal_code' => '60118',
            'contact_name' => 'Dra. Siti Maryam',
            'contact_position' => 'Kepala Perpustakaan',
            'email' => 'perpusdajatim@jatimprov.go.id',
            'phone' => '031-5928-785',
            'website' => 'https://perpusda.jatimprov.go.id',
            'established_year' => 1965,
            'collection_count' => 120000,
            'member_count' => 15000,
            'status' => 'Active',
            'created_at' => '2024-05-05 08:15:00',
            'updated_at' => '2024-05-05 08:15:00',
            'verified_at' => '2024-05-05 08:15:00'
        ],
        [
            'library_name' => 'Perpustakaan SMA Negeri 1 Jakarta',
            'library_code' => 'SMAN1JKT006',
            'library_type' => 'School',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Pusat',
            'address' => 'Jl. Budi Utomo No. 7, Jakarta Pusat',
            'postal_code' => '10110',
            'contact_name' => 'Dra. Retno Wulandari',
            'contact_position' => 'Kepala Perpustakaan',
            'email' => 'perpus@sman1jakarta.sch.id',
            'phone' => '021-384-8004',
            'established_year' => 1950,
            'collection_count' => 8500,
            'member_count' => 1200,
            'status' => 'Active',
            'created_at' => '2024-06-10 10:30:00',
            'updated_at' => '2024-06-10 10:30:00',
            'verified_at' => '2024-06-10 10:30:00'
        ],
        [
            'library_name' => 'Perpustakaan Khusus LIPI',
            'library_code' => 'LIPI007',
            'library_type' => 'Special',
            'province' => 'Jawa Barat',
            'city' => 'Cibinong',
            'address' => 'Jl. Raya Jakarta-Bogor Km. 46, Cibinong',
            'postal_code' => '16911',
            'contact_name' => 'Dr. Bambang Subiyanto',
            'contact_position' => 'Kepala Perpustakaan',
            'email' => 'perpus@lipi.go.id',
            'phone' => '021-8765-4321',
            'website' => 'https://perpustakaan.lipi.go.id',
            'established_year' => 1967,
            'collection_count' => 45000,
            'member_count' => 2500,
            'status' => 'Active',
            'created_at' => '2024-07-01 14:20:00',
            'updated_at' => '2024-07-01 14:20:00',
            'verified_at' => '2024-07-01 14:20:00'
        ],
        [
            'library_name' => 'Perpustakaan Kota Medan',
            'library_code' => 'MEDAN008',
            'library_type' => 'Public',
            'province' => 'Sumatera Utara',
            'city' => 'Medan',
            'address' => 'Jl. Iskandar Muda No. 24, Medan',
            'postal_code' => '20154',
            'contact_name' => 'Drs. Ahmad Fauzi',
            'contact_position' => 'Kepala Perpustakaan',
            'email' => 'perpuskotamedan@pemkomedan.go.id',
            'phone' => '061-4567-890',
            'established_year' => 1960,
            'collection_count' => 65000,
            'member_count' => 7200,
            'status' => 'Pending',
            'created_at' => '2024-07-05 09:15:00',
            'updated_at' => '2024-07-05 09:15:00'
        ]
    ];
    
    foreach ($sampleData as $data) {
        $placeholders = ':' . implode(', :', array_keys($data));
        $columns = implode(', ', array_keys($data));
        
        $sql = "INSERT INTO registrations ($columns) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
    }
    
    echo "✓ Sample data inserted successfully.\n";
    echo "✓ Setup completed! You can now access the registration view page.\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>