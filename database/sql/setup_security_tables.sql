-- INLISLite v3.0 Security Tables Setup
-- Create additional tables for enhanced security features

USE `inlislite`;

-- Update users table structure for enhanced security
ALTER TABLE `users` 
MODIFY COLUMN `password` VARCHAR(255) NOT NULL COMMENT 'Bcrypt hashed password',
ADD COLUMN `password_changed_at` TIMESTAMP NULL COMMENT 'Last password change timestamp',
ADD COLUMN `failed_login_attempts` INT DEFAULT 0 COMMENT 'Failed login attempt counter',
ADD COLUMN `locked_until` TIMESTAMP NULL COMMENT 'Account lock expiry time',
ADD COLUMN `two_factor_enabled` BOOLEAN DEFAULT FALSE COMMENT 'Two-factor authentication status',
ADD COLUMN `two_factor_secret` VARCHAR(32) NULL COMMENT 'Two-factor authentication secret',
ADD INDEX `idx_failed_attempts` (`failed_login_attempts`),
ADD INDEX `idx_locked_until` (`locked_until`);

-- Create user tokens table for remember me and password reset
CREATE TABLE IF NOT EXISTS `user_tokens` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `token` VARCHAR(255) NOT NULL COMMENT 'Hashed token',
    `type` ENUM('remember_me', 'password_reset', 'email_verification') NOT NULL,
    `expires_at` TIMESTAMP NOT NULL,
    `used_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_user_id` (`user_id`),
    INDEX `idx_token` (`token`),
    INDEX `idx_type` (`type`),
    INDEX `idx_expires_at` (`expires_at`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create activity logs table for security monitoring
CREATE TABLE IF NOT EXISTS `activity_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NULL COMMENT 'User ID (null for anonymous actions)',
    `action` VARCHAR(50) NOT NULL COMMENT 'Action performed',
    `description` TEXT NULL COMMENT 'Detailed description',
    `ip_address` VARCHAR(45) NOT NULL COMMENT 'IP address (supports IPv6)',
    `user_agent` TEXT NULL COMMENT 'Browser user agent',
    `session_id` VARCHAR(128) NULL COMMENT 'Session identifier',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_user_id` (`user_id`),
    INDEX `idx_action` (`action`),
    INDEX `idx_ip_address` (`ip_address`),
    INDEX `idx_created_at` (`created_at`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create password history table to prevent password reuse
CREATE TABLE IF NOT EXISTS `password_history` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_user_id` (`user_id`),
    INDEX `idx_created_at` (`created_at`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create security settings table
CREATE TABLE IF NOT EXISTS `security_settings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(100) NOT NULL UNIQUE,
    `setting_value` TEXT NOT NULL,
    `description` TEXT NULL,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `updated_by` INT NULL,
    INDEX `idx_setting_key` (`setting_key`),
    FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default security settings
INSERT INTO `security_settings` (`setting_key`, `setting_value`, `description`) VALUES
('password_min_length', '8', 'Minimum password length'),
('password_require_uppercase', '1', 'Require uppercase letters in password'),
('password_require_lowercase', '1', 'Require lowercase letters in password'),
('password_require_numbers', '1', 'Require numbers in password'),
('password_require_special', '1', 'Require special characters in password'),
('password_history_count', '5', 'Number of previous passwords to remember'),
('login_max_attempts', '5', 'Maximum failed login attempts before lockout'),
('login_lockout_duration', '900', 'Account lockout duration in seconds (15 minutes)'),
('session_timeout', '3600', 'Session timeout in seconds (1 hour)'),
('remember_me_duration', '2592000', 'Remember me duration in seconds (30 days)'),
('two_factor_enabled', '0', 'Enable two-factor authentication'),
('password_reset_token_expiry', '3600', 'Password reset token expiry in seconds (1 hour)')
ON DUPLICATE KEY UPDATE 
    `setting_value` = VALUES(`setting_value`),
    `description` = VALUES(`description`);

-- Create login attempts tracking table
CREATE TABLE IF NOT EXISTS `login_attempts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `ip_address` VARCHAR(45) NOT NULL,
    `username` VARCHAR(50) NULL,
    `success` BOOLEAN NOT NULL DEFAULT FALSE,
    `user_agent` TEXT NULL,
    `attempted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_ip_address` (`ip_address`),
    INDEX `idx_username` (`username`),
    INDEX `idx_attempted_at` (`attempted_at`),
    INDEX `idx_success` (`success`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create security events table for monitoring
CREATE TABLE IF NOT EXISTS `security_events` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `event_type` VARCHAR(50) NOT NULL COMMENT 'Type of security event',
    `severity` ENUM('low', 'medium', 'high', 'critical') NOT NULL DEFAULT 'medium',
    `user_id` INT NULL,
    `ip_address` VARCHAR(45) NOT NULL,
    `description` TEXT NOT NULL,
    `metadata` JSON NULL COMMENT 'Additional event data',
    `resolved` BOOLEAN DEFAULT FALSE,
    `resolved_by` INT NULL,
    `resolved_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_event_type` (`event_type`),
    INDEX `idx_severity` (`severity`),
    INDEX `idx_user_id` (`user_id`),
    INDEX `idx_ip_address` (`ip_address`),
    INDEX `idx_created_at` (`created_at`),
    INDEX `idx_resolved` (`resolved`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`resolved_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Update existing users to have secure password hashes
-- Note: This will require users to reset their passwords if they're using MD5
UPDATE `users` 
SET `password_changed_at` = CURRENT_TIMESTAMP 
WHERE `password_changed_at` IS NULL;

-- Create view for user security status
CREATE OR REPLACE VIEW `user_security_status` AS
SELECT 
    u.id,
    u.username,
    u.nama_lengkap,
    u.email,
    u.role,
    u.status,
    u.last_login,
    u.password_changed_at,
    u.failed_login_attempts,
    u.locked_until,
    u.two_factor_enabled,
    CASE 
        WHEN u.locked_until > NOW() THEN 'Locked'
        WHEN u.status = 'Non-Aktif' THEN 'Inactive'
        WHEN u.failed_login_attempts >= 3 THEN 'Warning'
        ELSE 'Active'
    END as security_status,
    DATEDIFF(NOW(), u.password_changed_at) as password_age_days,
    (SELECT COUNT(*) FROM login_attempts la WHERE la.username = u.username AND la.attempted_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)) as login_attempts_24h
FROM users u;

-- Create stored procedure to clean up old tokens
DELIMITER //
CREATE PROCEDURE CleanupExpiredTokens()
BEGIN
    -- Delete expired tokens
    DELETE FROM user_tokens WHERE expires_at < NOW();
    
    -- Delete old login attempts (keep only last 30 days)
    DELETE FROM login_attempts WHERE attempted_at < DATE_SUB(NOW(), INTERVAL 30 DAY);
    
    -- Delete old activity logs (keep only last 90 days)
    DELETE FROM activity_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);
    
    -- Delete old password history (keep only last 10 per user)
    DELETE ph1 FROM password_history ph1
    INNER JOIN (
        SELECT user_id, id
        FROM password_history ph2
        WHERE ph2.user_id = ph1.user_id
        ORDER BY created_at DESC
        LIMIT 10, 18446744073709551615
    ) ph3 ON ph1.id = ph3.id;
END //
DELIMITER ;

-- Create event to run cleanup daily
CREATE EVENT IF NOT EXISTS cleanup_security_data
ON SCHEDULE EVERY 1 DAY
STARTS CURRENT_TIMESTAMP
DO CALL CleanupExpiredTokens();

-- Insert sample security events for testing
INSERT INTO `security_events` (`event_type`, `severity`, `ip_address`, `description`) VALUES
('multiple_failed_logins', 'medium', '127.0.0.1', 'Multiple failed login attempts detected'),
('password_policy_violation', 'low', '127.0.0.1', 'User attempted to use weak password'),
('account_locked', 'high', '127.0.0.1', 'User account locked due to failed login attempts');

-- Create indexes for better performance
CREATE INDEX idx_users_status_role ON users(status, role);
CREATE INDEX idx_activity_logs_user_action ON activity_logs(user_id, action);
CREATE INDEX idx_login_attempts_ip_time ON login_attempts(ip_address, attempted_at);

COMMIT;