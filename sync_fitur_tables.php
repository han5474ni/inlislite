<?php
/**
 * Database Synchronization Script
 * This script ensures synchronization between fitur, features, and modules tables
 */

try {
    $db = new PDO('mysql:host=localhost;dbname=inlislite', 'root', 'yani12345');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== FITUR TABLE SYNCHRONIZATION SCRIPT ===\n";
    echo "Starting synchronization process...\n\n";
    
    // 1. Sync from fitur table to features and modules tables
    echo "1. Syncing from fitur table to features and modules tables...\n";
    
    $fiturData = $db->query('SELECT * FROM fitur WHERE status = "active"')->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($fiturData as $row) {
        $baseData = [
            'title' => $row['title'],
            'description' => $row['description'],
            'icon' => $row['icon'],
            'color' => $row['color'],
            'status' => $row['status'],
            'sort_order' => $row['sort_order'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ];
        
        if ($row['type'] === 'feature') {
            // Check if feature already exists
            $existingFeature = $db->prepare('SELECT id FROM features WHERE title = ? AND description = ?');
            $existingFeature->execute([$row['title'], $row['description']]);
            
            if (!$existingFeature->fetch()) {
                $stmt = $db->prepare('INSERT INTO features (title, description, icon, color, status, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute(array_values($baseData));
                echo "  - Added feature: {$row['title']}\n";
            }
        } else {
            // Check if module already exists
            $existingModule = $db->prepare('SELECT id FROM modules WHERE title = ? AND description = ?');
            $existingModule->execute([$row['title'], $row['description']]);
            
            if (!$existingModule->fetch()) {
                $moduleData = array_merge($baseData, ['module_type' => $row['module_type'] ?? 'application']);
                $stmt = $db->prepare('INSERT INTO modules (title, description, icon, color, module_type, status, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute(array_values($moduleData));
                echo "  - Added module: {$row['title']}\n";
            }
        }
    }
    
    // 2. Sync from features table back to fitur table
    echo "\n2. Syncing from features table back to fitur table...\n";
    
    $featuresData = $db->query('SELECT * FROM features WHERE status = "active"')->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($featuresData as $row) {
        $existingFitur = $db->prepare('SELECT id FROM fitur WHERE title = ? AND type = "feature"');
        $existingFitur->execute([$row['title']]);
        
        if (!$existingFitur->fetch()) {
            $stmt = $db->prepare('INSERT INTO fitur (title, description, icon, color, type, status, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, "feature", ?, ?, ?, ?)');
            $stmt->execute([
                $row['title'],
                $row['description'],
                $row['icon'],
                $row['color'],
                $row['status'],
                $row['sort_order'],
                $row['created_at'],
                $row['updated_at']
            ]);
            echo "  - Added to fitur: {$row['title']} (feature)\n";
        }
    }
    
    // 3. Sync from modules table back to fitur table
    echo "\n3. Syncing from modules table back to fitur table...\n";
    
    $modulesData = $db->query('SELECT * FROM modules WHERE status = "active"')->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($modulesData as $row) {
        $existingFitur = $db->prepare('SELECT id FROM fitur WHERE title = ? AND type = "module"');
        $existingFitur->execute([$row['title']]);
        
        if (!$existingFitur->fetch()) {
            $stmt = $db->prepare('INSERT INTO fitur (title, description, icon, color, type, module_type, status, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, "module", ?, ?, ?, ?, ?)');
            $stmt->execute([
                $row['title'],
                $row['description'],
                $row['icon'],
                $row['color'],
                $row['module_type'],
                $row['status'],
                $row['sort_order'],
                $row['created_at'],
                $row['updated_at']
            ]);
            echo "  - Added to fitur: {$row['title']} (module)\n";
        }
    }
    
    // 4. Fix sort orders to be sequential
    echo "\n4. Fixing sort orders...\n";
    
    // Fix features sort order
    $features = $db->query('SELECT * FROM features ORDER BY sort_order ASC, id ASC')->fetchAll(PDO::FETCH_ASSOC);
    foreach ($features as $index => $feature) {
        $newOrder = $index + 1;
        $stmt = $db->prepare('UPDATE features SET sort_order = ? WHERE id = ?');
        $stmt->execute([$newOrder, $feature['id']]);
    }
    
    // Fix modules sort order
    $modules = $db->query('SELECT * FROM modules ORDER BY sort_order ASC, id ASC')->fetchAll(PDO::FETCH_ASSOC);
    foreach ($modules as $index => $module) {
        $newOrder = $index + 1;
        $stmt = $db->prepare('UPDATE modules SET sort_order = ? WHERE id = ?');
        $stmt->execute([$newOrder, $module['id']]);
    }
    
    // Fix fitur sort order
    $fitur = $db->query('SELECT * FROM fitur ORDER BY sort_order ASC, id ASC')->fetchAll(PDO::FETCH_ASSOC);
    foreach ($fitur as $index => $item) {
        $newOrder = $index + 1;
        $stmt = $db->prepare('UPDATE fitur SET sort_order = ? WHERE id = ?');
        $stmt->execute([$newOrder, $item['id']]);
    }
    
    echo "Sort orders fixed successfully!\n";
    
    // 5. Show final counts
    echo "\n5. Final synchronization results:\n";
    
    $fiturCount = $db->query('SELECT COUNT(*) FROM fitur WHERE status = "active"')->fetchColumn();
    $featuresCount = $db->query('SELECT COUNT(*) FROM features WHERE status = "active"')->fetchColumn();
    $modulesCount = $db->query('SELECT COUNT(*) FROM modules WHERE status = "active"')->fetchColumn();
    
    echo "  - fitur table: {$fiturCount} records\n";
    echo "  - features table: {$featuresCount} records\n";
    echo "  - modules table: {$modulesCount} records\n";
    
    // 6. Populate user_feature_access with default permissions
    echo "\n6. Populating user_feature_access with default permissions...\n";
    
    // Clear existing user_feature_access records
    $db->exec('DELETE FROM user_feature_access');
    
    // Get all users
    $users = $db->query('SELECT id, role FROM users WHERE status = "Aktif"')->fetchAll(PDO::FETCH_ASSOC);
    
    // Define default feature access based on roles
    $rolePermissions = [
        'Super Admin' => ['tentang', 'panduan', 'fitur', 'aplikasi', 'bimbingan', 'dukungan', 'demo', 'patch', 'installer'],
        'Admin' => ['tentang', 'panduan', 'fitur', 'aplikasi', 'bimbingan', 'dukungan', 'demo', 'patch'],
        'Pustakawan' => ['tentang', 'panduan', 'fitur', 'aplikasi', 'demo'],
        'Staff' => ['tentang', 'panduan', 'fitur', 'demo']
    ];
    
    $insertedCount = 0;
    $stmt = $db->prepare('INSERT INTO user_feature_access (user_id, feature) VALUES (?, ?)');
    
    foreach ($users as $user) {
        $userRole = $user['role'] ?? 'Staff';
        $features = $rolePermissions[$userRole] ?? $rolePermissions['Staff'];
        
        foreach ($features as $feature) {
            $stmt->execute([$user['id'], $feature]);
            $insertedCount++;
        }
        
        echo "  - Added {$userRole} permissions for user ID {$user['id']}\n";
    }
    
    echo "Total user_feature_access records created: {$insertedCount}\n";
    
    // 7. Show final user_feature_access counts
    echo "\n7. Final user_feature_access results:\n";
    
    $userFeatureCount = $db->query('SELECT COUNT(*) FROM user_feature_access')->fetchColumn();
    $usersWithAccess = $db->query('SELECT COUNT(DISTINCT user_id) FROM user_feature_access')->fetchColumn();
    
    echo "  - user_feature_access table: {$userFeatureCount} records\n";
    echo "  - users with feature access: {$usersWithAccess} users\n";
    
    // Log the synchronization to activity_logs
    $logStmt = $db->prepare('INSERT INTO activity_logs (user_id, action, description, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)');
    $logStmt->execute([
        1, // Assuming admin user ID is 1
        'sync_features',
        'Feature synchronization completed successfully',
        $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
        $_SERVER['HTTP_USER_AGENT'] ?? 'CLI'
    ]);
    
    echo "\n=== SYNCHRONIZATION COMPLETED SUCCESSFULLY ===\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    
    // Log the error
    try {
        $logStmt = $db->prepare('INSERT INTO activity_logs (user_id, action, description, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)');
        $logStmt->execute([
            1, // Assuming admin user ID is 1
            'sync_features_error',
            'Feature synchronization failed: ' . $e->getMessage(),
            $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            $_SERVER['HTTP_USER_AGENT'] ?? 'CLI'
        ]);
    } catch (Exception $logError) {
        echo "Additional error logging failed: " . $logError->getMessage() . "\n";
    }
}
