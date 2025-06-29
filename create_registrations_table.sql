-- Create registrations table manually
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
) DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
