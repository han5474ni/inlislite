-- Create profile table migration
-- This table will store extended user profile information

CREATE TABLE IF NOT EXISTS `profile` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `foto` varchar(255) DEFAULT NULL,
    `nama` varchar(255) NOT NULL,
    `nama_lengkap` varchar(255) DEFAULT NULL,
    `username` varchar(100) NOT NULL,
    `nama_pengguna` varchar(100) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `kata_sandi` varchar(255) NOT NULL,
    `role` enum('Super Admin','Admin','Pustakawan','Staff') NOT NULL DEFAULT 'Staff',
    `status` enum('Aktif','Non-Aktif','Ditangguhkan') NOT NULL DEFAULT 'Aktif',
    `phone` varchar(20) DEFAULT NULL,
    `address` text DEFAULT NULL,
    `bio` text DEFAULT NULL,
    `last_login` datetime DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_user_id` (`user_id`),
    UNIQUE KEY `unique_username` (`username`),
    UNIQUE KEY `unique_nama_pengguna` (`nama_pengguna`),
    UNIQUE KEY `unique_email` (`email`),
    KEY `idx_username` (`username`),
    KEY `idx_email` (`email`),
    KEY `idx_status` (`status`),
    KEY `idx_role` (`role`),
    CONSTRAINT `fk_profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create triggers to synchronize profile table with users table

DELIMITER $$

-- Trigger to create profile when user is created
CREATE TRIGGER `sync_profile_on_user_insert` 
AFTER INSERT ON `users` 
FOR EACH ROW 
BEGIN
    INSERT INTO `profile` (
        `user_id`, 
        `nama`, 
        `nama_lengkap`, 
        `username`, 
        `nama_pengguna`, 
        `email`, 
        `password`, 
        `kata_sandi`, 
        `role`, 
        `status`,
        `created_at`,
        `updated_at`
    ) VALUES (
        NEW.`id`,
        NEW.`nama_lengkap`,
        NEW.`nama_lengkap`,
        NEW.`nama_pengguna`,
        NEW.`nama_pengguna`,
        NEW.`email`,
        NEW.`kata_sandi`,
        NEW.`kata_sandi`,
        NEW.`role`,
        NEW.`status`,
        NEW.`created_at`,
        NEW.`updated_at`
    );
END$$

-- Trigger to update profile when user is updated
CREATE TRIGGER `sync_profile_on_user_update` 
AFTER UPDATE ON `users` 
FOR EACH ROW 
BEGIN
    UPDATE `profile` SET
        `nama` = NEW.`nama_lengkap`,
        `nama_lengkap` = NEW.`nama_lengkap`,
        `username` = NEW.`nama_pengguna`,
        `nama_pengguna` = NEW.`nama_pengguna`,
        `email` = NEW.`email`,
        `password` = NEW.`kata_sandi`,
        `kata_sandi` = NEW.`kata_sandi`,
        `role` = NEW.`role`,
        `status` = NEW.`status`,
        `updated_at` = NEW.`updated_at`
    WHERE `user_id` = NEW.`id`;
END$$

-- Trigger to delete profile when user is deleted
CREATE TRIGGER `sync_profile_on_user_delete` 
AFTER DELETE ON `users` 
FOR EACH ROW 
BEGIN
    DELETE FROM `profile` WHERE `user_id` = OLD.`id`;
END$$

DELIMITER ;

-- Sync existing users to profile table
INSERT INTO `profile` (
    `user_id`, 
    `nama`, 
    `nama_lengkap`, 
    `username`, 
    `nama_pengguna`, 
    `email`, 
    `password`, 
    `kata_sandi`, 
    `role`, 
    `status`,
    `created_at`,
    `updated_at`
)
SELECT 
    `id`,
    `nama_lengkap`,
    `nama_lengkap`,
    `nama_pengguna`,
    `nama_pengguna`,
    `email`,
    `kata_sandi`,
    `kata_sandi`,
    `role`,
    `status`,
    `created_at`,
    `updated_at`
FROM `users` 
WHERE `id` NOT IN (SELECT `user_id` FROM `profile` WHERE `user_id` IS NOT NULL);