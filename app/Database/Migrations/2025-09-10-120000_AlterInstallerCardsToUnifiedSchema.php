<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class AlterInstallerCardsToUnifiedSchema extends Migration
{
    public function up()
    {
        $db = Database::connect();

        // Ensure table exists before altering
        if (!$db->tableExists('installer_cards')) {
            return;
        }

        $fields = array_map('strtolower', $db->getFieldNames('installer_cards'));

        // Rename Indonesian columns to unified English names
        if (in_array('nama_paket', $fields)) {
            $db->query("ALTER TABLE `installer_cards` CHANGE `nama_paket` `package_name` VARCHAR(255) NOT NULL");
        }
        if (in_array('deskripsi', $fields)) {
            $db->query("ALTER TABLE `installer_cards` CHANGE `deskripsi` `description` TEXT NULL");
        }
        if (in_array('versi', $fields)) {
            $db->query("ALTER TABLE `installer_cards` CHANGE `versi` `version` VARCHAR(50) NULL");
        }
        if (in_array('ukuran', $fields)) {
            $db->query("ALTER TABLE `installer_cards` CHANGE `ukuran` `file_size` VARCHAR(50) NULL");
        }
        if (in_array('tipe', $fields)) {
            // Rename and expand enum to include addon
            $db->query("ALTER TABLE `installer_cards` CHANGE `tipe` `card_type` ENUM('source','installer','database','documentation','addon') NOT NULL DEFAULT 'installer'");
        } else {
            // If column exists but is wrong enum, normalize it
            if (in_array('card_type', $fields)) {
                $db->query("ALTER TABLE `installer_cards` MODIFY `card_type` ENUM('source','installer','database','documentation','addon') NOT NULL DEFAULT 'installer'");
            }
        }
        if (in_array('download_url', $fields) && !in_array('download_link', $fields)) {
            $db->query("ALTER TABLE `installer_cards` CHANGE `download_url` `download_link` VARCHAR(500) NULL");
        }

        // Add missing columns if not exist
        $fields = array_map('strtolower', $db->getFieldNames('installer_cards'));

        if (!in_array('release_date', $fields)) {
            $db->query("ALTER TABLE `installer_cards` ADD `release_date` DATE NULL AFTER `version`");
        }
        if (!in_array('requirements', $fields)) {
            // Prefer JSON; if DB doesn't support JSON it will fallback to LONGTEXT at runtime error, but here we assume JSON support
            $db->query("ALTER TABLE `installer_cards` ADD `requirements` JSON NULL AFTER `description`");
        }
        if (!in_array('default_username', $fields)) {
            $db->query("ALTER TABLE `installer_cards` ADD `default_username` VARCHAR(100) NULL AFTER `requirements`");
        }
        if (!in_array('default_password', $fields)) {
            $db->query("ALTER TABLE `installer_cards` ADD `default_password` VARCHAR(100) NULL AFTER `default_username`");
        }
        if (!in_array('icon', $fields)) {
            $db->query("ALTER TABLE `installer_cards` ADD `icon` VARCHAR(100) NULL AFTER `card_type`");
        }
        if (!in_array('sort_order', $fields)) {
            $db->query("ALTER TABLE `installer_cards` ADD `sort_order` INT(11) NULL DEFAULT 0");
        }

        // Normalize status enum to include 'maintenance'
        if (in_array('status', $fields)) {
            $db->query("ALTER TABLE `installer_cards` MODIFY `status` ENUM('active','inactive','maintenance') NOT NULL DEFAULT 'active'");
        }
    }

    public function down()
    {
        // No-op (non-destructive rollback). If needed, revert enum expansions only.
        $db = Database::connect();
        if ($db->tableExists('installer_cards')) {
            // Revert enums to original minimal sets
            $db->query("ALTER TABLE `installer_cards` MODIFY `card_type` ENUM('source','installer','database','documentation') NOT NULL DEFAULT 'installer'");
            $db->query("ALTER TABLE `installer_cards` MODIFY `status` ENUM('active','inactive') NOT NULL DEFAULT 'active'");
        }
    }
}