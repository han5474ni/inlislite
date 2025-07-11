<?php
/**
 * MySQL Replication Setup Tool for INLISLite
 * 
 * This script helps set up MySQL replication between master and slave servers
 * for the INLISLite application.
 * 
 * Usage:
 * 1. Configure the Replication.php config file first
 * 2. Run this script on both master and slave servers
 * 3. Follow the prompts to complete setup
 */

// Load CodeIgniter instance to access configuration
require_once dirname(__FILE__, 3) . '/app/Config/Paths.php';
$paths = new \Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

// Load replication configuration
$replication = new \Config\Replication();

// Check if replication is enabled
if (!$replication->enabled) {
    echo "Error: Replication is not enabled in the configuration.\n";
    echo "Please set 'enabled' to true in app/Config/Replication.php\n";
    exit(1);
}

// Function to check MySQL version
function checkMySQLVersion($conn) {
    $result = $conn->query("SELECT VERSION() as version");
    $row = $result->fetch_assoc();
    echo "MySQL Version: " . $row['version'] . "\n";
    
    // Check if version supports GTID (MySQL 5.6+)
    $versionParts = explode('.', $row['version']);
    $majorVersion = (int)$versionParts[0];
    $minorVersion = (int)$versionParts[1];
    
    if ($majorVersion < 5 || ($majorVersion == 5 && $minorVersion < 6)) {
        echo "Warning: MySQL version below 5.6 may not fully support GTID replication.\n";
        return false;
    }
    
    return true;
}

// Function to configure master server
function configureMaster($config) {
    echo "\n=== Configuring Master Server ===\n";
    
    // Connect to master
    $conn = new mysqli(
        $config->master['hostname'],
        $config->master['username'],
        $config->master['password'],
        $config->master['database'],
        $config->master['port']
    );
    
    if ($conn->connect_error) {
        die("Connection to master failed: " . $conn->connect_error . "\n");
    }
    
    // Check MySQL version
    checkMySQLVersion($conn);
    
    // Check if server_id is set in my.cnf
    $result = $conn->query("SELECT @@server_id as server_id");
    $row = $result->fetch_assoc();
    echo "Current server_id: " . $row['server_id'] . "\n";
    
    if ($row['server_id'] == 0 || $row['server_id'] == 1) {
        echo "Warning: Default server_id detected. You should set a unique server_id in my.cnf\n";
        echo "Add the following to your my.cnf file in the [mysqld] section:\n";
        echo "server-id=" . $config->master['server_id'] . "\n";
        echo "log-bin=mysql-bin\n";
        echo "binlog-format=ROW\n";
        
        // Tables to replicate
        if (!empty($config->tables)) {
            echo "binlog-do-db=" . $config->master['database'] . "\n";
        }
        
        // Tables to exclude
        if (!empty($config->excludeTables)) {
            echo "binlog-ignore-table=" . implode(",", array_map(function($table) use ($config) {
                return $config->master['database'] . "." . $table;
            }, $config->excludeTables)) . "\n";
        }
        
        echo "\nAfter updating my.cnf, restart MySQL and run this script again.\n";
        return false;
    }
    
    // Create replication user if it doesn't exist
    echo "\nCreating replication user...\n";
    $replicationUser = 'repl_user';
    $replicationPass = generatePassword();
    
    // Drop user if exists
    $conn->query("DROP USER IF EXISTS '$replicationUser'@'%'");
    
    // Create user with replication privileges
    $createUserSql = "CREATE USER '$replicationUser'@'%' IDENTIFIED BY '$replicationPass'";
    if ($conn->query($createUserSql) === TRUE) {
        echo "Replication user created.\n";
    } else {
        echo "Error creating replication user: " . $conn->error . "\n";
        return false;
    }
    
    // Grant replication privileges
    $grantSql = "GRANT REPLICATION SLAVE ON *.* TO '$replicationUser'@'%'";
    if ($conn->query($grantSql) === TRUE) {
        echo "Replication privileges granted.\n";
    } else {
        echo "Error granting replication privileges: " . $conn->error . "\n";
        return false;
    }
    
    // Apply privileges
    $conn->query("FLUSH PRIVILEGES");
    
    // Get master status
    $result = $conn->query("SHOW MASTER STATUS");
    $masterStatus = $result->fetch_assoc();
    
    echo "\nMaster configuration complete!\n";
    echo "=== MASTER INFO (SAVE THIS) ===\n";
    echo "Master Host: " . $config->master['hostname'] . "\n";
    echo "Master Port: " . $config->master['port'] . "\n";
    echo "Replication User: $replicationUser\n";
    echo "Replication Password: $replicationPass\n";
    echo "Master Log File: " . $masterStatus['File'] . "\n";
    echo "Master Log Position: " . $masterStatus['Position'] . "\n";
    echo "==============================\n";
    
    // Save master info to a file for slave setup
    $masterInfo = [
        'host' => $config->master['hostname'],
        'port' => $config->master['port'],
        'user' => $replicationUser,
        'password' => $replicationPass,
        'log_file' => $masterStatus['File'],
        'log_pos' => $masterStatus['Position']
    ];
    
    file_put_contents(dirname(__FILE__) . '/master_info.json', json_encode($masterInfo, JSON_PRETTY_PRINT));
    echo "Master info saved to tools/database/master_info.json\n";
    
    $conn->close();
    return true;
}

// Function to configure slave server
function configureSlave($config, $slaveIndex = 0) {
    echo "\n=== Configuring Slave Server ===\n";
    
    // Check if master_info.json exists
    $masterInfoFile = dirname(__FILE__) . '/master_info.json';
    if (!file_exists($masterInfoFile)) {
        echo "Error: master_info.json not found.\n";
        echo "Please run this script on the master server first.\n";
        return false;
    }
    
    // Load master info
    $masterInfo = json_decode(file_get_contents($masterInfoFile), true);
    
    // Connect to slave
    $slaveConfig = $config->slaves[$slaveIndex];
    $conn = new mysqli(
        $slaveConfig['hostname'],
        $slaveConfig['username'],
        $slaveConfig['password'],
        $slaveConfig['database'],
        $slaveConfig['port']
    );
    
    if ($conn->connect_error) {
        die("Connection to slave failed: " . $conn->connect_error . "\n");
    }
    
    // Check MySQL version
    checkMySQLVersion($conn);
    
    // Check if server_id is set in my.cnf
    $result = $conn->query("SELECT @@server_id as server_id");
    $row = $result->fetch_assoc();
    echo "Current server_id: " . $row['server_id'] . "\n";
    
    if ($row['server_id'] == 0 || $row['server_id'] == 1) {
        echo "Warning: Default server_id detected. You should set a unique server_id in my.cnf\n";
        echo "Add the following to your my.cnf file in the [mysqld] section:\n";
        echo "server-id=" . $slaveConfig['server_id'] . "\n";
        echo "read-only=1\n";
        echo "\nAfter updating my.cnf, restart MySQL and run this script again.\n";
        return false;
    }
    
    // Stop slave if running
    $conn->query("STOP SLAVE");
    
    // Configure slave to connect to master
    $slaveSql = "CHANGE MASTER TO "
              . "MASTER_HOST='{$masterInfo['host']}', "
              . "MASTER_PORT={$masterInfo['port']}, "
              . "MASTER_USER='{$masterInfo['user']}', "
              . "MASTER_PASSWORD='{$masterInfo['password']}', "
              . "MASTER_LOG_FILE='{$masterInfo['log_file']}', "
              . "MASTER_LOG_POS={$masterInfo['log_pos']}";  
    
    if ($conn->query($slaveSql) === TRUE) {
        echo "Slave configured to connect to master.\n";
    } else {
        echo "Error configuring slave: " . $conn->error . "\n";
        return false;
    }
    
    // Start slave
    if ($conn->query("START SLAVE") === TRUE) {
        echo "Slave started.\n";
    } else {
        echo "Error starting slave: " . $conn->error . "\n";
        return false;
    }
    
    // Check slave status
    $result = $conn->query("SHOW SLAVE STATUS\G");
    $slaveStatus = $result->fetch_assoc();
    
    if ($slaveStatus['Slave_IO_Running'] == 'Yes' && $slaveStatus['Slave_SQL_Running'] == 'Yes') {
        echo "\nSlave configuration complete!\n";
        echo "Slave is running and connected to master.\n";
    } else {
        echo "\nWarning: Slave is not running properly.\n";
        echo "IO Thread Running: " . $slaveStatus['Slave_IO_Running'] . "\n";
        echo "SQL Thread Running: " . $slaveStatus['Slave_SQL_Running'] . "\n";
        echo "Last Error: " . $slaveStatus['Last_Error'] . "\n";
        return false;
    }
    
    $conn->close();
    return true;
}

// Function to generate a random password
function generatePassword($length = 16) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+;:,.?';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
}

// Main execution
echo "\n=== INLISLite MySQL Replication Setup ===\n";
echo "Replication Mode: " . $replication->mode . "\n";

// Ask user what to configure
echo "\nWhat do you want to configure?\n";
echo "1. Master Server\n";
echo "2. Slave Server\n";
echo "3. Exit\n";

$choice = readline("Enter your choice (1-3): ");

switch ($choice) {
    case '1':
        configureMaster($replication);
        break;
    case '2':
        // If multiple slaves, ask which one
        if (count($replication->slaves) > 1) {
            echo "\nMultiple slave configurations found. Which one do you want to configure?\n";
            for ($i = 0; $i < count($replication->slaves); $i++) {
                echo ($i + 1) . ". " . $replication->slaves[$i]['hostname'] . "\n";
            }
            $slaveChoice = (int)readline("Enter your choice (1-" . count($replication->slaves) . "): ");
            configureSlave($replication, $slaveChoice - 1);
        } else {
            configureSlave($replication);
        }
        break;
    case '3':
        echo "Exiting...\n";
        break;
    default:
        echo "Invalid choice. Exiting...\n";
        break;
}

echo "\nReplication setup script completed.\n";