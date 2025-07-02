-- INLISlite v3.0 Database Setup
-- Create database and users table

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS `inlislite` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE `inlislite`;

-- Create users table
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama_lengkap` VARCHAR(100) NOT NULL,
    `username` VARCHAR(50) UNIQUE NOT NULL,
    `email` VARCHAR(100) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('Super Admin','Admin','Pustakawan','Staff') DEFAULT 'Staff',
    `status` ENUM('Aktif','Non-aktif') DEFAULT 'Aktif',
    `last_login` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `created_at` DATE DEFAULT CURRENT_DATE,
    INDEX `idx_username` (`username`),
    INDEX `idx_email` (`email`),
    INDEX `idx_role` (`role`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user
INSERT INTO `users` (`nama_lengkap`, `username`, `email`, `password`, `role`, `status`) 
VALUES 
('System Administrator', 'admin', 'admin@inlislite.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Super Admin', 'Aktif'),
('Test Pustakawan', 'pustakawan', 'pustakawan@inlislite.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pustakawan', 'Aktif'),
('Test Staff', 'staff', 'staff@inlislite.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Staff', 'Aktif')
ON DUPLICATE KEY UPDATE `id` = `id`;

-- Note: Default password for all users is 'password'
-- Hash generated using: password_hash('password', PASSWORD_DEFAULT)