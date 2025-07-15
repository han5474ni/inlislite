<?php
// Debug script to check and create demo_items table
require_once '../vendor/autoload.php';

// Load CodeIgniter configuration
$config = \CodeIgniter\Config\Database::connect();

echo "<h2>Demo Items Table Debug</h2>\n";

try {
    // Check if table exists
    if ($config->tableExists('demo_items')) {
        echo "<p style='color: green;'>✅ demo_items table exists</p>\n";
        
        // Get table structure
        $fields = $config->getFieldNames('demo_items');
        echo "<h3>Table Fields:</h3>\n";
        echo "<ul>\n";
        foreach ($fields as $field) {
            echo "<li>$field</li>\n";
        }
        echo "</ul>\n";
        
        // Count records
        $count = $config->table('demo_items')->countAll();
        echo "<p>Total records: $count</p>\n";
        
        // Show sample data
        if ($count > 0) {
            $samples = $config->table('demo_items')->limit(3)->get()->getResultArray();
            echo "<h3>Sample Data:</h3>\n";
            echo "<pre>" . print_r($samples, true) . "</pre>\n";
        } else {
            echo "<p>No data found in table</p>\n";
            
            // Create sample data
            echo "<h3>Creating Sample Data...</h3>\n";
            $sampleData = [
                [
                    'title' => 'Demo Katalogisasi',
                    'subtitle' => 'Proses Katalogisasi Buku',
                    'description' => 'Demo lengkap proses katalogisasi buku dalam sistem perpustakaan',
                    'category' => 'cataloging',
                    'icon' => 'book',
                    'status' => 'active',
                    'demo_type' => 'interactive',
                    'sort_order' => 1,
                    'is_featured' => 1,
                    'view_count' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'title' => 'Demo Sirkulasi',
                    'subtitle' => 'Peminjaman dan Pengembalian',
                    'description' => 'Demo proses peminjaman dan pengembalian buku',
                    'category' => 'circulation',
                    'icon' => 'arrow-repeat',
                    'status' => 'active',
                    'demo_type' => 'video',
                    'sort_order' => 2,
                    'is_featured' => 0,
                    'view_count' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'title' => 'Demo OPAC',
                    'subtitle' => 'Pencarian Katalog Online',
                    'description' => 'Demo fitur pencarian dalam katalog online (OPAC)',
                    'category' => 'opac',
                    'icon' => 'search',
                    'status' => 'active',
                    'demo_type' => 'live',
                    'sort_order' => 3,
                    'is_featured' => 1,
                    'view_count' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ];
            
            foreach ($sampleData as $data) {
                $result = $config->table('demo_items')->insert($data);
                echo "<p>Inserted: {$data['title']} - " . ($result ? 'Success' : 'Failed') . "</p>\n";
            }
        }
        
    } else {
        echo "<p style='color: red;'>❌ demo_items table does not exist</p>\n";
        echo "<p>Run migration to create the table:</p>\n";
        echo "<code>php spark migrate</code>\n";
    }
    
} catch (\Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>\n";
}

echo "<p><a href='/admin/demo-edit'>Go to Demo Edit Page</a></p>\n";
?>
