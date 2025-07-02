<?php

namespace App\Controllers;

class Setup extends BaseController
{
    public function createRegistrationsTable()
    {
        $db = \Config\Database::connect();
        
        try {
            // Check if table already exists
            $query = $db->query("SHOW TABLES LIKE 'registrations'");
            if ($query->getNumRows() > 0) {
                return "Table 'registrations' already exists.";
            }
            
            // Create registrations table
            $sql = "
                CREATE TABLE registrations (
                    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    library_name VARCHAR(255) NOT NULL,
                    province VARCHAR(100) NOT NULL,
                    city VARCHAR(100) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    phone VARCHAR(20) NULL,
                    status ENUM('pending', 'verified', 'rejected') NOT NULL DEFAULT 'pending',
                    created_at DATETIME NULL,
                    updated_at DATETIME NULL,
                    verified_at DATETIME NULL,
                    PRIMARY KEY (id),
                    KEY idx_status (status),
                    KEY idx_created_at (created_at)
                ) DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci
            ";
            
            $db->query($sql);
            
            // Insert sample data
            $sampleData = [
                [
                    'library_name' => 'Perpustakaan Nasional RI',
                    'province' => 'DKI Jakarta',
                    'city' => 'Jakarta Pusat',
                    'email' => 'perpusnas@example.com',
                    'phone' => '021-1234567',
                    'status' => 'verified',
                    'created_at' => '2024-01-15 09:30:00',
                    'updated_at' => '2024-01-16 10:00:00',
                    'verified_at' => '2024-01-16 10:00:00'
                ],
                [
                    'library_name' => 'Perpustakaan Kota Bandung',
                    'province' => 'Jawa Barat',
                    'city' => 'Bandung',
                    'email' => 'perpuskotabdg@example.com',
                    'phone' => '022-1234567',
                    'status' => 'verified',
                    'created_at' => '2024-02-05 08:45:00',
                    'updated_at' => '2024-02-06 16:20:00',
                    'verified_at' => '2024-02-06 16:20:00'
                ],
                [
                    'library_name' => 'Perpustakaan Universitas Gadjah Mada',
                    'province' => 'DI Yogyakarta',
                    'city' => 'Yogyakarta',
                    'email' => 'perpus@ugm.ac.id',
                    'phone' => '0274-123456',
                    'status' => 'pending',
                    'created_at' => '2024-03-10 14:45:00',
                    'updated_at' => '2024-03-10 14:45:00',
                    'verified_at' => null
                ],
                [
                    'library_name' => 'Perpustakaan Universitas Indonesia',
                    'province' => 'Jawa Barat',
                    'city' => 'Depok',
                    'email' => 'perpus@ui.ac.id',
                    'phone' => '021-7654321',
                    'status' => 'verified',
                    'created_at' => '2024-04-02 09:10:00',
                    'updated_at' => '2024-04-03 11:25:00',
                    'verified_at' => '2024-04-03 11:25:00'
                ],
                [
                    'library_name' => 'Perpustakaan Daerah Jawa Timur',
                    'province' => 'Jawa Timur',
                    'city' => 'Surabaya',
                    'email' => 'perpusdajatim@example.com',
                    'phone' => '031-1234567',
                    'status' => 'pending',
                    'created_at' => '2024-05-05 08:15:00',
                    'updated_at' => '2024-05-05 08:15:00',
                    'verified_at' => null
                ]
            ];
            
            $builder = $db->table('registrations');
            foreach ($sampleData as $data) {
                $builder->insert($data);
            }
            
            return "Table 'registrations' created successfully with sample data!";
            
        } catch (\Exception $e) {
            return "Error creating table: " . $e->getMessage();
        }
    }
}
