<?php
/**
 * Add User API for INLISlite v3.0
 * Handles user creation with validation
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once 'db.php';

try {
    // Get POST data
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        $input = $_POST;
    }
    
    // Validate required fields
    $required_fields = ['nama_lengkap', 'username', 'email', 'password', 'role', 'status'];
    $errors = [];
    
    foreach ($required_fields as $field) {
        if (empty($input[$field])) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' wajib diisi';
        }
    }
    
    // Validate email format
    if (!empty($input['email']) && !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid';
    }
    
    // Validate password length
    if (!empty($input['password']) && strlen($input['password']) < 6) {
        $errors[] = 'Password minimal 6 karakter';
    }
    
    // Check if username already exists
    if (!empty($input['username'])) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $input['username']);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = 'Username sudah digunakan';
        }
    }
    
    // Check if email already exists
    if (!empty($input['email'])) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $input['email']);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = 'Email sudah digunakan';
        }
    }
    
    // Return validation errors
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $errors
        ]);
        exit;
    }
    
    // Hash password
    $hashedPassword = password_hash($input['password'], PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (nama_lengkap, username, email, password, role, status, created_at) VALUES (?, ?, ?, ?, ?, ?, CURDATE())");
    $stmt->bind_param("ssssss", 
        $input['nama_lengkap'],
        $input['username'],
        $input['email'],
        $hashedPassword,
        $input['role'],
        $input['status']
    );
    
    if ($stmt->execute()) {
        $newUserId = $conn->insert_id;
        
        // Get the newly created user
        $stmt = $conn->prepare("SELECT id, nama_lengkap, username, email, role, status, last_login, created_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $newUserId);
        $stmt->execute();
        $result = $stmt->get_result();
        $newUser = $result->fetch_assoc();
        
        // Format the new user data
        if ($newUser['created_at']) {
            $createdDate = new DateTime($newUser['created_at']);
            $newUser['created_at_formatted'] = $createdDate->format('d M Y');
        }
        
        $newUser['last_login_formatted'] = 'Belum pernah';
        
        // Generate avatar initials
        $nameParts = explode(' ', $newUser['nama_lengkap']);
        $initials = '';
        foreach ($nameParts as $part) {
            if (!empty($part)) {
                $initials .= strtoupper($part[0]);
            }
        }
        $newUser['avatar_initials'] = substr($initials, 0, 2);
        
        echo json_encode([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $newUser
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal menambahkan user: ' . $conn->error
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

$conn->close();
?>