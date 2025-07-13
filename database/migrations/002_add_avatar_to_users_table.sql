-- Add avatar/photo column to users table and update synchronization triggers
-- This migration syncs profile photos between profile and users tables

-- Add avatar column to users table
ALTER TABLE `users` ADD COLUMN `avatar` VARCHAR(255) DEFAULT NULL AFTER `status`;

-- Add index for avatar column
ALTER TABLE `users` ADD KEY `idx_avatar` (`avatar`);

-- Update existing users table with avatar data from profile table
UPDATE `users` u 
INNER JOIN `profile` p ON u.id = p.user_id 
SET u.avatar = p.foto 
WHERE p.foto IS NOT NULL;

-- Drop existing triggers
DROP TRIGGER IF EXISTS `sync_profile_on_user_insert`;
DROP TRIGGER IF EXISTS `sync_profile_on_user_update`;
DROP TRIGGER IF EXISTS `sync_profile_on_user_delete`;

-- Recreate triggers with avatar synchronization

DELIMITER $$

-- Trigger to create profile when user is created
CREATE TRIGGER `sync_profile_on_user_insert` 
AFTER INSERT ON `users` 
FOR EACH ROW 
BEGIN
    INSERT INTO `profile` (
        `user_id`, 
        `foto`,
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
        NEW.`avatar`,
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
        `foto` = NEW.`avatar`,
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

-- Trigger to update users table when profile foto is updated
CREATE TRIGGER `sync_user_on_profile_update` 
AFTER UPDATE ON `profile` 
FOR EACH ROW 
BEGIN
    UPDATE `users` SET
        `avatar` = NEW.`foto`,
        `nama_lengkap` = NEW.`nama_lengkap`,
        `nama_pengguna` = NEW.`nama_pengguna`,
        `email` = NEW.`email`,
        `kata_sandi` = NEW.`kata_sandi`,
        `role` = NEW.`role`,
        `status` = NEW.`status`,
        `updated_at` = NEW.`updated_at`
    WHERE `id` = NEW.`user_id`;
END$$

-- Trigger to delete profile when user is deleted
CREATE TRIGGER `sync_profile_on_user_delete` 
AFTER DELETE ON `users` 
FOR EACH ROW 
BEGIN
    DELETE FROM `profile` WHERE `user_id` = OLD.`id`;
END$$

DELIMITER ;
