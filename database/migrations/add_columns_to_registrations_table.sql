-- Add missing columns to registrations table
ALTER TABLE registrations
ADD COLUMN library_code VARCHAR(50) NULL AFTER library_name,
ADD COLUMN library_type VARCHAR(100) NULL AFTER library_code,
ADD COLUMN address TEXT NULL AFTER city,
ADD COLUMN postal_code VARCHAR(20) NULL AFTER address,
ADD COLUMN coordinates VARCHAR(100) NULL AFTER postal_code,
ADD COLUMN contact_name VARCHAR(255) NULL AFTER coordinates,
ADD COLUMN contact_position VARCHAR(100) NULL AFTER contact_name,
ADD COLUMN website VARCHAR(255) NULL AFTER phone,
ADD COLUMN fax VARCHAR(20) NULL AFTER website,
ADD COLUMN established_year INT(4) NULL AFTER fax,
ADD COLUMN collection_count INT(11) NULL AFTER established_year,
ADD COLUMN member_count INT(11) NULL AFTER collection_count,
ADD COLUMN notes TEXT NULL AFTER member_count;