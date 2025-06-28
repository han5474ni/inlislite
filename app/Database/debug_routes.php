<?php
/**
 * Debug Routes - Test semua routes yang tersedia
 * Akses: http://localhost/inlislite/database/debug_routes.php
 */

echo "<h2>🔍 Debug Routes INLISLite</h2>";
echo "<hr>";

// Test basic PHP and database connection
echo "<h3>📡 Basic Tests</h3>";

try {
    // Test database connection
    $hostname = 'localhost';
    $username = 'root';
    $password = 'yani12345';
    $database = 'inlislite';
    
    $dsn = "mysql:host={$hostname};dbname={$database};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Database Connection: SUCCESS<br>";
    
    // Count users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "👥 Total Users in DB: {$result['total']}<br>";
    
} catch (Exception $e) {
    echo "❌ Database Error: " . $e->getMessage() . "<br>";
}

echo "<br>";

// Test routes
echo "<h3>🌐 Route Tests</h3>";

$routes = [
    'Homepage' => 'http://localhost/inlislite/',
    'Dashboard' => 'http://localhost/inlislite/dashboard',
    'User Management' => 'http://localhost/inlislite/user-management',
    'Tentang' => 'http://localhost/inlislite/tentang',
    'Panduan' => 'http://localhost/inlislite/panduan',
];

foreach ($routes as $name => $url) {
    echo "<div style='margin: 10px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px;'>";
    echo "<strong>{$name}:</strong><br>";
    echo "<a href='{$url}' target='_blank'>{$url}</a><br>";
    
    // Test if route is accessible
    $headers = @get_headers($url);
    if ($headers && strpos($headers[0], '200') !== false) {
        echo "<span style='color: green;'>✅ Accessible</span>";
    } elseif ($headers && strpos($headers[0], '404') !== false) {
        echo "<span style='color: red;'>❌ 404 Not Found</span>";
    } else {
        echo "<span style='color: orange;'>⚠️ Unknown Status</span>";
    }
    echo "</div>";
}

echo "<br>";

// Test AJAX endpoints
echo "<h3>🔄 AJAX Endpoint Tests</h3>";

$ajaxRoutes = [
    'Get Users' => 'http://localhost/inlislite/user-management/users',
    'Add User (POST)' => 'http://localhost/inlislite/user-management/add',
    'Get User by ID' => 'http://localhost/inlislite/user-management/get/1',
];

foreach ($ajaxRoutes as $name => $url) {
    echo "<div style='margin: 10px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px;'>";
    echo "<strong>{$name}:</strong><br>";
    echo "<code>{$url}</code><br>";
    
    if (strpos($name, 'POST') === false) {
        // Test GET endpoints
        $headers = @get_headers($url);
        if ($headers && strpos($headers[0], '200') !== false) {
            echo "<span style='color: green;'>✅ Endpoint Available</span>";
        } else {
            echo "<span style='color: red;'>❌ Endpoint Not Available</span>";
        }
    } else {
        echo "<span style='color: blue;'>ℹ️ POST Endpoint (requires form data)</span>";
    }
    echo "</div>";
}

echo "<br>";

// CodeIgniter specific tests
echo "<h3>🚀 CodeIgniter Tests</h3>";

// Check if CodeIgniter is properly installed
$ciPath = dirname(__DIR__) . '/vendor/autoload.php';
if (file_exists($ciPath)) {
    echo "✅ CodeIgniter 4: INSTALLED<br>";
    
    // Check app folder
    $appPath = dirname(__DIR__) . '/app';
    if (is_dir($appPath)) {
        echo "✅ App Folder: EXISTS<br>";
        
        // Check controllers
        $controllerPath = $appPath . '/Controllers/UserManagement.php';
        if (file_exists($controllerPath)) {
            echo "✅ UserManagement Controller: EXISTS<br>";
        } else {
            echo "❌ UserManagement Controller: NOT FOUND<br>";
        }
        
        // Check views
        $viewPath = $appPath . '/Views/user_management.php';
        if (file_exists($viewPath)) {
            echo "✅ User Management View: EXISTS<br>";
        } else {
            echo "❌ User Management View: NOT FOUND<br>";
        }
        
    } else {
        echo "❌ App Folder: NOT FOUND<br>";
    }
    
} else {
    echo "❌ CodeIgniter 4: NOT INSTALLED<br>";
    echo "💡 Run: composer install<br>";
}

echo "<br>";

// File permissions test
echo "<h3>📁 File Permissions</h3>";

$checkPaths = [
    'Writable folder' => dirname(__DIR__) . '/writable',
    'Public folder' => dirname(__DIR__) . '/public',
    'App folder' => dirname(__DIR__) . '/app',
];

foreach ($checkPaths as $name => $path) {
    if (is_dir($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        if (is_writable($path)) {
            echo "✅ {$name}: WRITABLE (permissions: {$perms})<br>";
        } else {
            echo "⚠️ {$name}: NOT WRITABLE (permissions: {$perms})<br>";
        }
    } else {
        echo "❌ {$name}: NOT FOUND<br>";
    }
}

echo "<br>";

// Environment test
echo "<h3>⚙️ Environment</h3>";

echo "🐘 PHP Version: " . PHP_VERSION . "<br>";
echo "🌐 Server: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "📁 Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "🔗 Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";

// Check .env file
$envPath = dirname(__DIR__) . '/.env';
if (file_exists($envPath)) {
    echo "✅ .env file: EXISTS<br>";
} else {
    echo "❌ .env file: NOT FOUND<br>";
}

echo "<br><hr>";

// Quick fixes
echo "<h3>🔧 Quick Fixes</h3>";

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<h4>If you see 404 errors:</h4>";
echo "1. Make sure Laragon is running<br>";
echo "2. Check if mod_rewrite is enabled in Apache<br>";
echo "3. Verify .htaccess file exists in public/ folder<br>";
echo "4. Check if project is in correct Laragon folder<br>";
echo "</div>";

echo "<div style='background: #fff0f0; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<h4>If database connection fails:</h4>";
echo "1. Start MySQL service in Laragon<br>";
echo "2. Check database credentials in .env file<br>";
echo "3. Create 'inlislite' database if it doesn't exist<br>";
echo "4. Run the SQL setup script<br>";
echo "</div>";

echo "<div style='background: #f0fff0; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<h4>If User Management doesn't work:</h4>";
echo "1. Check if UserManagement.php controller exists<br>";
echo "2. Verify routes are properly configured<br>";
echo "3. Check JavaScript console for errors<br>";
echo "4. Ensure CSRF tokens are properly configured<br>";
echo "</div>";

echo "<br><small>Debug completed at: " . date('Y-m-d H:i:s') . "</small>";
?>
