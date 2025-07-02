<?php
/**
 * Delete User API for INLISlite v3.0
 * Handles user deletion with validation
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once 'db.php';

try {
    // Get input data
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        $input = $_POST;
    }
    
    // Get user ID from URL parameter or POST data
    $userId = null;
    if (isset($_GET['id'])) {
        $userId = (int)$_GET['id'];
    } elseif (isset($input['id'])) {
        $userId = (int)$input['id'];
    }
    
    if (!$userId) {
        echo json_encode([
            'success' => false,
            'message' => 'ID user tidak valid'
        ]);
        exit;
    }
    
    // Check if user exists
    $stmt = $conn->prepare("SELECT id, nama_lengkap, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'User tidak ditemukan'
        ]);
        exit;
    }
    
    $user = $result->fetch_assoc();
    
    // Prevent deletion of the last Super Admin
    if ($user['role'] === 'Super Admin') {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE role = 'Super Admin'");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['count'] <= 1) {
            echo json_encode([
                'success' => false,
                'message' => 'Tidak dapat menghapus Super Admin terakhir'
            ]);
            exit;
        }
    }
    
    // Delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'User "' . $user['nama_lengkap'] . '" berhasil dihapus'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'User tidak ditemukan atau sudah dihapus'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal menghapus user: ' . $conn->error
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