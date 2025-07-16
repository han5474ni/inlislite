<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=inlislite', 'root', 'yani12345');
    
    echo "=== DATABASE TABLES ===\n";
    $result = $db->query('SHOW TABLES');
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        echo $row[0] . "\n";
    }
    
    echo "\n=== FITUR TABLE STRUCTURE ===\n";
    $result = $db->query('DESCRIBE fitur');
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " | " . $row['Type'] . " | " . $row['Null'] . " | " . $row['Key'] . " | " . $row['Default'] . "\n";
    }
    
    echo "\n=== FEATURES TABLE STRUCTURE ===\n";
    $result = $db->query('DESCRIBE features');
    if ($result) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo $row['Field'] . " | " . $row['Type'] . " | " . $row['Null'] . " | " . $row['Key'] . " | " . $row['Default'] . "\n";
        }
    } else {
        echo "Features table does not exist\n";
    }
    
    echo "\n=== MODULES TABLE STRUCTURE ===\n";
    $result = $db->query('DESCRIBE modules');
    if ($result) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo $row['Field'] . " | " . $row['Type'] . " | " . $row['Null'] . " | " . $row['Key'] . " | " . $row['Default'] . "\n";
        }
    } else {
        echo "Modules table does not exist\n";
    }
    
    echo "\n=== FITUR TABLE DATA ===\n";
    $result = $db->query('SELECT COUNT(*) as count FROM fitur');
    $count = $result->fetch(PDO::FETCH_ASSOC);
    echo "Total records in fitur table: " . $count['count'] . "\n";
    
    $result = $db->query('SELECT * FROM fitur LIMIT 3');
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode($row) . "\n";
    }
    
    echo "\n=== FEATURES TABLE DATA ===\n";
    $result = $db->query('SELECT COUNT(*) as count FROM features');
    $count = $result->fetch(PDO::FETCH_ASSOC);
    echo "Total records in features table: " . $count['count'] . "\n";
    
    $result = $db->query('SELECT * FROM features LIMIT 3');
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode($row) . "\n";
    }
    
    echo "\n=== MODULES TABLE DATA ===\n";
    $result = $db->query('SELECT COUNT(*) as count FROM modules');
    $count = $result->fetch(PDO::FETCH_ASSOC);
    echo "Total records in modules table: " . $count['count'] . "\n";
    
    $result = $db->query('SELECT * FROM modules LIMIT 3');
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode($row) . "\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
