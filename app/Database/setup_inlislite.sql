-- Setup database untuk INLISLite dengan Laragon
-- Jalankan script ini di phpMyAdmin atau MySQL command line

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS `inlislite` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Gunakan database inlislite
USE `inlislite`;

-- Hapus tabel users jika sudah ada (untuk fresh install)
DROP TABLE IF EXISTS `users`;

-- Buat tabel users
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) NOT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `role` enum('Super Admin','Admin','Pustakawan','Staff') NOT NULL DEFAULT 'Staff',
  `status` enum('Aktif','Non-Aktif','Ditangguhkan') NOT NULL DEFAULT 'Aktif',
  `last_login` datetime NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_nama_pengguna` (`nama_pengguna`),
  UNIQUE KEY `unique_email` (`email`),
  KEY `idx_nama_pengguna` (`nama_pengguna`),
  KEY `idx_email` (`email`),
  KEY `idx_status` (`status`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data user default
INSERT INTO `users` (`nama_lengkap`, `nama_pengguna`, `email`, `kata_sandi`, `role`, `status`, `last_login`) VALUES
('Administrator Sistem', 'admin', 'admin@inlislite.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Super Admin', 'Aktif', '2025-01-15 10:30:00'),
('Jane Smith', 'librarian', 'librarian@library.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pustakawan', 'Aktif', '2025-01-14 16:45:00'),
('Mike Johnson', 'staff1', 'staff1@staff.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Staff', 'Non-Aktif', '2025-01-10 09:15:00'),
('Sarah Wilson', 'admin2', 'admin2@inlislite.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'Aktif', '2025-01-14 14:20:00');

-- Tampilkan data yang sudah diinsert
SELECT * FROM `users`;

-- Tampilkan struktur tabel
DESCRIBE `users`;

-- Buat tabel documents untuk menyimpan dokumen panduan
DROP TABLE IF EXISTS `documents`;

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_file_type` (`file_type`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data dokumen default
INSERT INTO `documents` (`title`, `description`, `file_name`, `file_path`, `file_size`, `file_type`, `version`) VALUES
('Panduan Pengguna Revisi 16062016 – Modul Lengkap', 'Panduan komprehensif yang mencakup semua modul dan fitur INLISLite v3', 'panduan_lengkap_v3.2.1.pdf', 'uploads/documents/panduan_lengkap_v3.2.1.pdf', 12582912, 'PDF', 'V3.2.1'),
('Panduan Praktis – Pengaturan Administrasi di INLISLite v3', 'Panduan langkah demi langkah untuk mengonfigurasi pengaturan administratif', 'panduan_admin_v3.2.0.pdf', 'uploads/documents/panduan_admin_v3.2.0.pdf', 1887436, 'PDF', 'V3.2.0'),
('Panduan Praktis – Manajemen Bahan Pustaka di INLISLite v3', 'Panduan untuk mengelola koleksi bahan pustaka secara efektif', 'panduan_bahan_pustaka_v3.2.0.pdf', 'uploads/documents/panduan_bahan_pustaka_v3.2.0.pdf', 1887436, 'PDF', 'V3.2.0'),
('Panduan Praktis – Manajemen Keanggotaan di INLISLite v3', 'Manual pengguna untuk mengelola akun dan profil anggota perpustakaan', 'panduan_keanggotaan_v3.2.0.pdf', 'uploads/documents/panduan_keanggotaan_v3.2.0.pdf', 1782579, 'PDF', 'V3.2.0'),
('Panduan Praktis – Sistem Sirkulasi di INLISLite v3', 'Panduan untuk mengelola peminjaman dan pengembalian buku', 'panduan_sirkulasi_v3.2.0.pdf', 'uploads/documents/panduan_sirkulasi_v3.2.0.pdf', 1782579, 'PDF', 'V3.2.0'),
('Panduan Praktis – Pembuatan Survei di INLISLite v3', 'Panduan untuk membuat dan mengelola survei serta umpan balik perpustakaan', 'panduan_survei_v3.1.5.pdf', 'uploads/documents/panduan_survei_v3.1.5.pdf', 1468006, 'PDF', 'V3.1.5');

-- Tampilkan data yang sudah diinsert
SELECT * FROM `documents`;

-- Tampilkan struktur tabel documents
DESCRIBE `documents`;
