<?php

require_once 'vendor/autoload.php';

use Config\Database;
use Config\Migrations;

// Load CodeIgniter
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('SYSTEMPATH', __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR);
define('APPPATH', __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Initialize Config
$config = new \Config\App();
$config->baseURL = 'http://localhost:8080/';

// Initialize Database
$db = \Config\Database::connect();

try {
    echo "=== Migration: Separate Features and Modules Tables ===\n";
    echo "Starting migration...\n";
    
    // Run the specific migration
    $migrate = \Config\Services::migrations();
    $migrate->setNamespace('App');
    
    // Check if tables already exist
    if ($db->tableExists('features') && $db->tableExists('modules')) {
        echo "Tables 'features' and 'modules' already exist. Skipping migration.\n";
        exit(0);
    }
    
    // Load and run the migration manually
    $migration = new \App\Database\Migrations\CreateSeparateTablesForFeaturesAndModules();
    $migration->up();
    
    echo "Migration completed successfully!\n";
    
    // Fix sort orders
    echo "\n=== Fixing Sort Orders ===\n";
    fixSortOrders($db, 'features');
    fixSortOrders($db, 'modules');
    
    echo "\nAll operations completed successfully!\n";
    echo "New tables created:\n";
    echo "- features (for features data)\n";
    echo "- modules (for modules data)\n";
    echo "- Sequential sort orders have been fixed\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}

function fixSortOrders($db, $table)
{
    echo "Fixing sort orders for $table table...\n";
    
    $items = $db->table($table)
        ->orderBy('sort_order', 'ASC')
        ->orderBy('id', 'ASC')
        ->get()
        ->getResultArray();
    
    if (empty($items)) {
        echo "No items found in $table table.\n";
        return;
    }
    
    foreach ($items as $index => $item) {
        $newSortOrder = $index + 1;
        $db->table($table)
            ->where('id', $item['id'])
            ->update(['sort_order' => $newSortOrder]);
    }
    
    echo "Fixed sort orders for " . count($items) . " items in $table table.\n";
}
