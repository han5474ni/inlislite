<?php
/**
 * Update User API for INLISlite v3.0
 * Handles user updates with validation
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, PUT, OPTIONS');
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
    $required_fields = ['id', 'nama_lengkap', 'username', 'email', 'role', 'status'];
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
    
    // Validate password length if provided
    if (!empty($input['password']) && strlen($input['password']) < 6) {
        $errors[] = 'Password minimal 6 karakter';
    }
    
    // Check if username already exists (excluding current user)
    if (!empty($input['username']) && !empty($input['id'])) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $stmt->bind_param("si", $input['username'], $input['id']);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = 'Username sudah digunakan';
        }
    }
    
    // Check if email already exists (excluding current user)
    if (!empty($input['email']) && !empty($input['id'])) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $input['email'], $input['id']);
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
    
    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->bind_param("i", $input['id']);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'User tidak ditemukan'
        ]);
        exit;
    }
    
    // Prepare update query
    if (!empty($input['password'])) {
        // Update with password
        $hashedPassword = password_hash($input['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET nama_lengkap = ?, username = ?, email = ?, password = ?, role = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", 
            $input['nama_lengkap'],
            $input['username'],
            $input['email'],
            $hashedPassword,
            $input['role'],
            $input['status'],
            $input['id']
        );
    } else {
        // Update without password
        $stmt = $conn->prepare("UPDATE users SET nama_lengkap = ?, username = ?, email = ?, role = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssssi", 
            $input['nama_lengkap'],
            $input['username'],
            $input['email'],
            $input['role'],
            $input['status'],
            $input['id']
        );
    }
    
    if ($stmt->execute()) {
        // Get the updated user
        $stmt = $conn->prepare("SELECT id, nama_lengkap, username, email, role, status, last_login, created_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $input['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $updatedUser = $result->fetch_assoc();
        
        // Format the updated user data
        if ($updatedUser['last_login']) {
            $lastLogin = new DateTime($updatedUser['last_login']);
            $now = new DateTime();
            $diff = $now->diff($lastLogin);
            
            if ($diff->days > 0) {
                $updatedUser['last_login_formatted'] = $diff->days . ' hari yang lalu';
            } elseif ($diff->h > 0) {
                $updatedUser['last_login_formatted'] = $diff->h . ' jam yang lalu';
            } elseif ($diff->i > 0) {
                $updatedUser['last_login_formatted'] = $diff->i . ' menit yang lalu';
            } else {
                $updatedUser['last_login_formatted'] = 'Baru saja';
            }
        } else {
            $updatedUser['last_login_formatted'] = 'Belum pernah';
        }
        
        if ($updatedUser['created_at']) {
            $createdDate = new DateTime($updatedUser['created_at']);
            $updatedUser['created_at_formatted'] = $createdDate->format('d M Y');
        }
        
        // Generate avatar initials
        $nameParts = explode(' ', $updatedUser['nama_lengkap']);
        $initials = '';
        foreach ($nameParts as $part) {
            if (!empty($part)) {
                $initials .= strtoupper($part[0]);
            }
        }
        $updatedUser['avatar_initials'] = substr($initials, 0, 2);
        
        echo json_encode([
            'success' => true,
            'message' => 'User berhasil diupdate',
            'data' => $updatedUser
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal mengupdate user: ' . $conn->error
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