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
