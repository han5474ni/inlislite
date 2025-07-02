<?php
/**
 * Fetch Users API for INLISlite v3.0
 * Returns users data in JSON format
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'db.php';

try {
    // Get filter parameters
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $role = isset($_GET['role']) ? trim($_GET['role']) : '';
    $status = isset($_GET['status']) ? trim($_GET['status']) : '';
    
    // Build SQL query with filters
    $sql = "SELECT id, nama_lengkap, username, email, role, status, last_login, created_at FROM users WHERE 1=1";
    $params = [];
    $types = "";
    
    // Add search filter
    if (!empty($search)) {
        $sql .= " AND (nama_lengkap LIKE ? OR username LIKE ? OR email LIKE ?)";
        $searchParam = "%$search%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types .= "sss";
    }
    
    // Add role filter
    if (!empty($role)) {
        $sql .= " AND role = ?";
        $params[] = $role;
        $types .= "s";
    }
    
    // Add status filter
    if (!empty($status)) {
        $sql .= " AND status = ?";
        $params[] = $status;
        $types .= "s";
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    // Prepare and execute query
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
    $users = [];
    while ($row = $result->fetch_assoc()) {
        // Format last login
        if ($row['last_login']) {
            $lastLogin = new DateTime($row['last_login']);
            $now = new DateTime();
            $diff = $now->diff($lastLogin);
            
            if ($diff->days > 0) {
                $row['last_login_formatted'] = $diff->days . ' hari yang lalu';
            } elseif ($diff->h > 0) {
                $row['last_login_formatted'] = $diff->h . ' jam yang lalu';
            } elseif ($diff->i > 0) {
                $row['last_login_formatted'] = $diff->i . ' menit yang lalu';
            } else {
                $row['last_login_formatted'] = 'Baru saja';
            }
        } else {
            $row['last_login_formatted'] = 'Belum pernah';
        }
        
        // Format created date
        if ($row['created_at']) {
            $createdDate = new DateTime($row['created_at']);
            $row['created_at_formatted'] = $createdDate->format('d M Y');
        }
        
        // Generate avatar initials
        $nameParts = explode(' ', $row['nama_lengkap']);
        $initials = '';
        foreach ($nameParts as $part) {
            if (!empty($part)) {
                $initials .= strtoupper($part[0]);
            }
        }
        $row['avatar_initials'] = substr($initials, 0, 2);
        
        $users[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $users,
        'total' => count($users)
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

$conn->close();
?>