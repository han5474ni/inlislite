<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=inlislite', 'root', 'yani12345');
    
    echo "=== USERS TABLE STRUCTURE ===\n";
    $result = $db->query('DESCRIBE users');
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " | " . $row['Type'] . " | " . $row['Null'] . " | " . $row['Key'] . " | " . $row['Default'] . "\n";
    }
    
    echo "\n=== USERS TABLE DATA ===\n";
    $result = $db->query('SELECT COUNT(*) as count FROM users');
    $count = $result->fetch(PDO::FETCH_ASSOC);
    echo "Total records in users table: " . $count['count'] . "\n";
    
    $result = $db->query('SELECT * FROM users LIMIT 3');
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode($row) . "\n";
    }
    
    echo "\n=== USER_FEATURE_ACCESS TABLE STRUCTURE ===\n";
    $result = $db->query('DESCRIBE user_feature_access');
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " | " . $row['Type'] . " | " . $row['Null'] . " | " . $row['Key'] . " | " . $row['Default'] . "\n";
    }
    
    echo "\n=== USER_FEATURE_ACCESS TABLE DATA ===\n";
    $result = $db->query('SELECT COUNT(*) as count FROM user_feature_access');
    $count = $result->fetch(PDO::FETCH_ASSOC);
    echo "Total records in user_feature_access table: " . $count['count'] . "\n";
    
    $result = $db->query('SELECT * FROM user_feature_access LIMIT 5');
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode($row) . "\n";
    }
    
    echo "\n=== ACTIVITY_LOGS TABLE STRUCTURE ===\n";
    $result = $db->query('DESCRIBE activity_logs');
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " | " . $row['Type'] . " | " . $row['Null'] . " | " . $row['Key'] . " | " . $row['Default'] . "\n";
    }
    
    echo "\n=== ACTIVITY_LOGS TABLE DATA ===\n";
    $result = $db->query('SELECT COUNT(*) as count FROM activity_logs');
    $count = $result->fetch(PDO::FETCH_ASSOC);
    echo "Total records in activity_logs table: " . $count['count'] . "\n";
    
    $result = $db->query('SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT 3');
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode($row) . "\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
