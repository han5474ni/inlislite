<?php
/**
 * Test Dashboard Access
 * Script untuk mengecek akses ke berbagai URL dashboard
 */

echo "<h2>🔍 Test Dashboard Access - INLISLite v3</h2>";
echo "<hr>";

$baseUrl = 'http://localhost:8080';

$dashboardUrls = [
    'Homepage' => $baseUrl . '/',
    'Dashboard (Home Controller)' => $baseUrl . '/dashboard',
    'Modern Dashboard (Public)' => $baseUrl . '/modern-dashboard',
    'Admin Dashboard (Protected)' => $baseUrl . '/admin/dashboard',
    'Admin Modern Dashboard (Protected)' => $baseUrl . '/admin/modern-dashboard',
];

echo "<h3>📋 Available Dashboard URLs:</h3>";
echo "<ul>";
foreach ($dashboardUrls as $name => $url) {
    echo "<li><strong>$name:</strong> <a href='$url' target='_blank'>$url</a></li>";
}
echo "</ul>";

echo "<h3>🎯 Recommended URLs to Test:</h3>";
echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;'>";
echo "<p><strong>1. Public Access (No Login Required):</strong></p>";
echo "<ul>";
echo "<li><a href='$baseUrl/modern-dashboard' target='_blank' style='color: #28a745; font-weight: bold;'>$baseUrl/modern-dashboard</a> - Dashboard Modern</li>";
echo "<li><a href='$baseUrl/' target='_blank' style='color: #007bff; font-weight: bold;'>$baseUrl/</a> - Homepage</li>";
echo "</ul>";

echo "<p><strong>2. Protected Access (Login Required):</strong></p>";
echo "<ul>";
echo "<li><a href='$baseUrl/admin/dashboard' target='_blank' style='color: #dc3545; font-weight: bold;'>$baseUrl/admin/dashboard</a> - Admin Dashboard</li>";
echo "<li><a href='$baseUrl/admin/modern-dashboard' target='_blank' style='color: #dc3545; font-weight: bold;'>$baseUrl/admin/modern-dashboard</a> - Admin Modern Dashboard</li>";
echo "</ul>";
echo "</div>";

echo "<h3>🔧 Troubleshooting:</h3>";
echo "<div style='background: #fff3cd; padding: 15px; border-radius: 8px; margin: 15px 0;'>";
echo "<p><strong>Jika masih melihat tampilan lama:</strong></p>";
echo "<ol>";
echo "<li>Clear browser cache (Ctrl+F5 atau Ctrl+Shift+R)</li>";
echo "<li>Pastikan mengakses URL yang benar</li>";
echo "<li>Cek apakah server PHP berjalan di port 8080</li>";
echo "<li>Restart server PHP jika perlu</li>";
echo "</ol>";
echo "</div>";

echo "<h3>📊 File Status Check:</h3>";
$files = [
    'Modern Dashboard View' => __DIR__ . '/app/Views/admin/modern_dashboard.php',
    'Regular Dashboard View' => __DIR__ . '/app/Views/admin/dashboard.php',
    'Admin Controller' => __DIR__ . '/app/Controllers/admin/AdminController.php',
    'Home Controller' => __DIR__ . '/app/Controllers/Home.php',
    'Routes Config' => __DIR__ . '/app/Config/Routes.php'
];

echo "<ul>";
foreach ($files as $name => $path) {
    $exists = file_exists($path);
    $status = $exists ? '✅ EXISTS' : '❌ MISSING';
    $color = $exists ? 'green' : 'red';
    echo "<li><strong>$name:</strong> <span style='color: $color;'>$status</span></li>";
}
echo "</ul>";

echo "<hr>";
echo "<p><strong>💡 Tip:</strong> Gunakan URL <code>$baseUrl/modern-dashboard</code> untuk melihat dashboard modern tanpa perlu login.</p>";
?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background: #f8f9fa;
}

h2 {
    color: #2c3e50;
    border-bottom: 3px solid #28a745;
    padding-bottom: 10px;
}

h3 {
    color: #495057;
    margin-top: 25px;
}

a {
    text-decoration: none;
    color: #007bff;
}

a:hover {
    text-decoration: underline;
}

code {
    background: #e9ecef;
    padding: 2px 6px;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
}

ul {
    line-height: 1.6;
}

li {
    margin: 8px 0;
}
</style>