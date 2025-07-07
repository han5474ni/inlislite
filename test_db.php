<?php
// Test database connection and check registrations table
$host = 'localhost';
$dbname = 'inlislite';
$username = 'root';
$password = 'yani12345';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.\n";
    
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'registrations'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Table 'registrations' exists.\n";
        
        // Check table structure
        $stmt = $pdo->query("DESCRIBE registrations");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Table structure:\n";
        foreach ($columns as $column) {
            echo "  - {$column['Field']} ({$column['Type']})\n";
        }
        
        // Check data count
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM registrations");
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "\nTotal records: {$count['count']}\n";
        
        if ($count['count'] > 0) {
            // Show first few records
            $stmt = $pdo->query("SELECT id, library_name, province, status FROM registrations LIMIT 5");
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "\nSample records:\n";
            foreach ($records as $record) {
                echo "  ID: {$record['id']}, Name: {$record['library_name']}, Province: {$record['province']}, Status: {$record['status']}\n";
            }
        }
    } else {
        echo "✗ Table 'registrations' does not exist.\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>