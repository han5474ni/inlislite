<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Setup Test - INLISLite</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 5px 0 0; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>INLISLite Profile Setup Test</h1>
    
    <?php
    // Database configuration
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'inlislite';
    
    try {
        // Test database connection
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<p class='success'>✓ Database connection successful</p>";
        
        // Check if profile table exists
        $stmt = $pdo->query("SHOW TABLES LIKE 'profile'");
        $tableExists = $stmt->rowCount() > 0;
        
        if ($tableExists) {
            echo "<p class='success'>✓ Profile table exists</p>";
            
            // Check profile data
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM profile");
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            echo "<p class='success'>✓ Profile table has {$count} records</p>";
            
            // Display profiles
            $stmt = $pdo->query("SELECT id, nama, username, email, role, status, created_at FROM profile ORDER BY id");
            $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<h3>Current Profiles:</h3>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Created</th></tr>";
            
            foreach ($profiles as $profile) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($profile['id']) . "</td>";
                echo "<td>" . htmlspecialchars($profile['nama']) . "</td>";
                echo "<td>" . htmlspecialchars($profile['username']) . "</td>";
                echo "<td>" . htmlspecialchars($profile['email']) . "</td>";
                echo "<td>" . htmlspecialchars($profile['role']) . "</td>";
                echo "<td>" . htmlspecialchars($profile['status']) . "</td>";
                echo "<td>" . htmlspecialchars($profile['created_at']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
        } else {
            echo "<p class='warning'>⚠ Profile table does not exist</p>";
            echo "<p>You need to run the setup script to create the profile table.</p>";
        }
        
        // Check uploads directory
        $uploadsDir = __DIR__ . '/public/uploads/profiles';
        if (is_dir($uploadsDir)) {
            echo "<p class='success'>✓ Uploads directory exists: {$uploadsDir}</p>";
            if (is_writable($uploadsDir)) {
                echo "<p class='success'>✓ Uploads directory is writable</p>";
            } else {
                echo "<p class='error'>✗ Uploads directory is not writable</p>";
            }
        } else {
            echo "<p class='warning'>⚠ Uploads directory does not exist: {$uploadsDir}</p>";
        }
        
        // Check required files
        $requiredFiles = [
            'app/Models/ProfileModel.php',
            'app/Controllers/admin/AdminController.php',
            'app/Views/admin/profile.php',
            'public/assets/css/admin/profile.css',
            'public/assets/js/admin/profile-new.js'
        ];
        
        echo "<h3>Required Files Check:</h3>";
        foreach ($requiredFiles as $file) {
            $fullPath = __DIR__ . '/' . $file;
            if (file_exists($fullPath)) {
                echo "<p class='success'>✓ {$file}</p>";
            } else {
                echo "<p class='error'>✗ {$file}</p>";
            }
        }
        
    } catch (PDOException $e) {
        echo "<p class='error'>✗ Database connection failed: " . $e->getMessage() . "</p>";
    }
    ?>
    
    <h3>Actions:</h3>
    <a href="setup_profile_table.php" class="btn">Run Profile Table Setup</a>
    <a href="admin/profile" class="btn">Go to Profile Page</a>
    <a href="admin/login" class="btn">Go to Admin Login</a>
    
    <h3>Test Credentials:</h3>
    <ul>
        <li><strong>Super Admin:</strong> Username: admin, Password: admin123</li>
        <li><strong>Librarian:</strong> Username: librarian, Password: librarian123</li>
        <li><strong>Staff:</strong> Username: staff1, Password: staff123</li>
        <li><strong>Admin:</strong> Username: admin2, Password: admin456</li>
    </ul>
    
    <h3>Profile Features:</h3>
    <ul>
        <li>✓ View profile information</li>
        <li>✓ Update name and username</li>
        <li>✓ Change password</li>
        <li>✓ Upload profile photo</li>
        <li>✓ Display user role and status</li>
        <li>✓ Show last login time</li>
    </ul>
</body>
</html>