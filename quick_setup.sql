-- Quick Database Setup for INLISLite v3
-- Run this script in phpMyAdmin or MySQL command line

-- Use the inlislite database
USE `inlislite`;

-- Drop table if exists (for fresh install)
DROP TABLE IF EXISTS `documents`;

-- Create documents table
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

-- Insert sample data
INSERT INTO `documents` (`title`, `description`, `file_name`, `file_path`, `file_size`, `file_type`, `version`, `download_count`, `status`) VALUES
('Panduan Pengguna Revisi 16062016 – Modul Lengkap', 'Panduan komprehensif yang mencakup semua modul dan fitur INLISLite v3', 'panduan_lengkap_v3.2.1.pdf', 'uploads/documents/panduan_lengkap_v3.2.1.pdf', 12582912, 'PDF', 'V3.2.1', 0, 'active'),
('Panduan Praktis – Pengaturan Administrasi di INLISLite v3', 'Panduan langkah demi langkah untuk mengonfigurasi pengaturan administratif', 'panduan_admin_v3.2.0.pdf', 'uploads/documents/panduan_admin_v3.2.0.pdf', 1887436, 'PDF', 'V3.2.0', 0, 'active'),
('Panduan Praktis – Manajemen Bahan Pustaka di INLISLite v3', 'Panduan untuk mengelola koleksi bahan pustaka secara efektif', 'panduan_bahan_pustaka_v3.2.0.pdf', 'uploads/documents/panduan_bahan_pustaka_v3.2.0.pdf', 1887436, 'PDF', 'V3.2.0', 0, 'active'),
('Panduan Praktis – Manajemen Keanggotaan di INLISLite v3', 'Manual pengguna untuk mengelola akun dan profil anggota perpustakaan', 'panduan_keanggotaan_v3.2.0.pdf', 'uploads/documents/panduan_keanggotaan_v3.2.0.pdf', 1782579, 'PDF', 'V3.2.0', 0, 'active'),
('Panduan Praktis – Sistem Sirkulasi di INLISLite v3', 'Panduan untuk mengelola peminjaman dan pengembalian buku', 'panduan_sirkulasi_v3.2.0.pdf', 'uploads/documents/panduan_sirkulasi_v3.2.0.pdf', 1782579, 'PDF', 'V3.2.0', 0, 'active'),
('Panduan Praktis – Pembuatan Survei di INLISLite v3', 'Panduan untuk membuat dan mengelola survei serta umpan balik perpustakaan', 'panduan_survei_v3.1.5.pdf', 'uploads/documents/panduan_survei_v3.1.5.pdf', 1468006, 'PDF', 'V3.1.5', 0, 'active');

-- Verify the data
SELECT COUNT(*) as total_documents FROM `documents`;

-- Show the created table structure
DESCRIBE `documents`;

-- Show sample data
SELECT id, title, file_type, version, download_count, status, created_at FROM `documents` ORDER BY created_at DESC;
