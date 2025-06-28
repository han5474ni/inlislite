<?php
/**
 * Test koneksi database untuk Laragon
 * Jalankan file ini di browser: http://localhost/inlislite/database/test_connection.php
 */

// Konfigurasi database
$hostname = 'localhost';
$username = 'root';
$password = 'yani12345';
$database = 'inlislite';
$port = 3306;

echo "<h2>🔧 Test Koneksi Database INLISLite</h2>";
echo "<hr>";

try {
    // Test koneksi MySQL
    echo "<h3>📡 Testing MySQL Connection...</h3>";
    
    $dsn = "mysql:host={$hostname};port={$port};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ <strong>MySQL Connection:</strong> SUCCESS<br>";
    echo "📍 <strong>Host:</strong> {$hostname}:{$port}<br>";
    echo "👤 <strong>Username:</strong> {$username}<br>";
    echo "🔐 <strong>Password:</strong> " . str_repeat('*', strlen($password)) . "<br><br>";
    
    // Test database existence
    echo "<h3>🗄️ Testing Database...</h3>";
    
    $stmt = $pdo->query("SHOW DATABASES LIKE '{$database}'");
    $dbExists = $stmt->rowCount() > 0;
    
    if ($dbExists) {
        echo "✅ <strong>Database '{$database}':</strong> EXISTS<br>";
        
        // Connect to specific database
        $dsn = "mysql:host={$hostname};port={$port};dbname={$database};charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "✅ <strong>Database Connection:</strong> SUCCESS<br><br>";
        
        // Test users table
        echo "<h3>👥 Testing Users Table...</h3>";
        
        $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
        $tableExists = $stmt->rowCount() > 0;
        
        if ($tableExists) {
            echo "✅ <strong>Users Table:</strong> EXISTS<br>";
            
            // Get table structure
            $stmt = $pdo->query("DESCRIBE users");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<strong>📋 Table Structure:</strong><br>";
            echo "<table border='1' cellpadding='5' cellspacing='0' style='margin: 10px 0;'>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
            
            foreach ($columns as $column) {
                echo "<tr>";
                echo "<td>{$column['Field']}</td>";
                echo "<td>{$column['Type']}</td>";
                echo "<td>{$column['Null']}</td>";
                echo "<td>{$column['Key']}</td>";
                echo "<td>{$column['Default']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Count users
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<strong>👤 Total Users:</strong> {$result['total']}<br>";
            
            // Show sample users
            if ($result['total'] > 0) {
                echo "<br><strong>📝 Sample Users:</strong><br>";
                $stmt = $pdo->query("SELECT id, nama_lengkap, nama_pengguna, email, role, status FROM users LIMIT 5");
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo "<table border='1' cellpadding='5' cellspacing='0' style='margin: 10px 0;'>";
                echo "<tr><th>ID</th><th>Nama Lengkap</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th></tr>";
                
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>{$user['id']}</td>";
                    echo "<td>{$user['nama_lengkap']}</td>";
                    echo "<td>{$user['nama_pengguna']}</td>";
                    echo "<td>{$user['email']}</td>";
                    echo "<td>{$user['role']}</td>";
                    echo "<td>{$user['status']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            
        } else {
            echo "❌ <strong>Users Table:</strong> NOT EXISTS<br>";
            echo "💡 <strong>Solution:</strong> Run the SQL script to create the users table<br>";
        }
        
    } else {
        echo "❌ <strong>Database '{$database}':</strong> NOT EXISTS<br>";
        echo "💡 <strong>Solution:</strong> Create database '{$database}' first<br>";
    }
    
    echo "<br><h3>🚀 CodeIgniter 4 Test</h3>";
    
    // Test if we can include CodeIgniter
    $ciPath = dirname(__DIR__) . '/vendor/autoload.php';
    if (file_exists($ciPath)) {
        echo "✅ <strong>CodeIgniter 4:</strong> INSTALLED<br>";
        echo "📁 <strong>Vendor Path:</strong> {$ciPath}<br>";
    } else {
        echo "❌ <strong>CodeIgniter 4:</strong> NOT FOUND<br>";
        echo "💡 <strong>Solution:</strong> Run 'composer install' in project root<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ <strong>Connection Error:</strong> " . $e->getMessage() . "<br>";
    echo "<br><h3>🔧 Troubleshooting:</h3>";
    echo "1. Make sure Laragon is running<br>";
    echo "2. Check if MySQL service is started<br>";
    echo "3. Verify database credentials<br>";
    echo "4. Create database 'inlislite' if it doesn't exist<br>";
}

echo "<br><hr>";
echo "<h3>📋 Next Steps:</h3>";
echo "1. ✅ Make sure this test passes<br>";
echo "2. 🗄️ Run the SQL script to create tables<br>";
echo "3. 🌐 Access your application: <a href='http://localhost/inlislite/'>http://localhost/inlislite/</a><br>";
echo "4. 👥 Go to User Management: <a href='http://localhost/inlislite/user-management'>http://localhost/inlislite/user-management</a><br>";

echo "<br><small>Generated at: " . date('Y-m-d H:i:s') . "</small>";
?>
