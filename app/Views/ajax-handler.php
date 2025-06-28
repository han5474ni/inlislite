<?php
header('Content-Type: application/json');

// Database connection (replace with your actual database configuration)
function getDbConnection() {
    // Example connection - replace with your actual database details
    try {
        $username = 'root'; // Default MySQL username
        $password = ''; // Default MySQL password
        $pdo = new PDO('mysql:host=localhost;dbname=inlislite', $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        throw new Exception("Connection failed: " . $e->getMessage());
    }
}

function sendResponse($success, $data = null, $error = null) {
    echo json_encode([
        'success' => $success,
        'data' => $data,
        'error' => $error
    ]);
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Only POST requests allowed');
    }

    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'create':
            createPatch();
            break;
        case 'get':
            getPatch();
            break;
        case 'update':
            updatePatch();
            break;
        case 'delete':
            deletePatch();
            break;
        case 'download':
            downloadPatch();
            break;
        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    sendResponse(false, null, $e->getMessage());
}

function createPatch() {
    $requiredFields = ['nama_paket', 'versi', 'prioritas', 'ukuran', 'tanggal_rilis', 'deskripsi'];
    
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Field {$field} is required");
        }
    }

    // Validate data
    $data = [
        'nama_paket' => trim($_POST['nama_paket']),
        'versi' => trim($_POST['versi']),
        'prioritas' => $_POST['prioritas'],
        'ukuran' => trim($_POST['ukuran']),
        'tanggal_rilis' => $_POST['tanggal_rilis'],
        'deskripsi' => trim($_POST['deskripsi']),
        'jumlah_unduhan' => 0
    ];

    // Validate priority
    if (!in_array($data['prioritas'], ['High', 'Medium', 'Low'])) {
        throw new Exception('Invalid priority value');
    }

    // Validate date
    if (!DateTime::createFromFormat('Y-m-d', $data['tanggal_rilis'])) {
        throw new Exception('Invalid date format');
    }

    // Insert into database
    $pdo = getDbConnection();
    $sql = "INSERT INTO patches (nama_paket, versi, prioritas, ukuran, tanggal_rilis, deskripsi, jumlah_unduhan) 
            VALUES (:nama_paket, :versi, :prioritas, :ukuran, :tanggal_rilis, :deskripsi, :jumlah_unduhan)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

    sendResponse(true, ['id' => $pdo->lastInsertId()]);
}

function getPatch() {
    $id = $_POST['id'] ?? '';
    
    if (empty($id) || !is_numeric($id)) {
        throw new Exception('Invalid patch ID');
    }

    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM patches WHERE id = :id");
    $stmt->execute(['id' => $id]);
    
    $patch = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$patch) {
        throw new Exception('Patch not found');
    }

    sendResponse(true, $patch);
}

function updatePatch() {
    $id = $_POST['id'] ?? '';
    
    if (empty($id) || !is_numeric($id)) {
        throw new Exception('Invalid patch ID');
    }

    $requiredFields = ['nama_paket', 'versi', 'prioritas', 'ukuran', 'tanggal_rilis', 'deskripsi'];
    
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Field {$field} is required");
        }
    }

    $data = [
        'id' => $id,
        'nama_paket' => trim($_POST['nama_paket']),
        'versi' => trim($_POST['versi']),
        'prioritas' => $_POST['prioritas'],
        'ukuran' => trim($_POST['ukuran']),
        'tanggal_rilis' => $_POST['tanggal_rilis'],
        'deskripsi' => trim($_POST['deskripsi'])
    ];

    // Validate priority
    if (!in_array($data['prioritas'], ['High', 'Medium', 'Low'])) {
        throw new Exception('Invalid priority value');
    }

    // Validate date
    if (!DateTime::createFromFormat('Y-m-d', $data['tanggal_rilis'])) {
        throw new Exception('Invalid date format');
    }

    $pdo = getDbConnection();
    $sql = "UPDATE patches SET nama_paket = :nama_paket, versi = :versi, prioritas = :prioritas, 
            ukuran = :ukuran, tanggal_rilis = :tanggal_rilis, deskripsi = :deskripsi 
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute($data);

    if (!$result) {
        throw new Exception('Failed to update patch');
    }

    sendResponse(true);
}

function deletePatch() {
    $id = $_POST['id'] ?? '';
    
    if (empty($id) || !is_numeric($id)) {
        throw new Exception('Invalid patch ID');
    }

    $pdo = getDbConnection();
    $stmt = $pdo->prepare("DELETE FROM patches WHERE id = :id");
    $result = $stmt->execute(['id' => $id]);

    if (!$result) {
        throw new Exception('Failed to delete patch');
    }

    sendResponse(true);
}

function downloadPatch() {
    $id = $_POST['id'] ?? '';
    
    if (empty($id) || !is_numeric($id)) {
        throw new Exception('Invalid patch ID');
    }

    $pdo = getDbConnection();
    
    // Get patch info
    $stmt = $pdo->prepare("SELECT * FROM patches WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $patch = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$patch) {
        throw new Exception('Patch not found');
    }

    // Update download count
    $updateStmt = $pdo->prepare("UPDATE patches SET jumlah_unduhan = jumlah_unduhan + 1 WHERE id = :id");
    $updateStmt->execute(['id' => $id]);

    // Generate download URL (replace with your actual file storage logic)
    $filename = $patch['nama_paket'] . '_v' . $patch['versi'] . '.7z';
    $downloadUrl = '/downloads/patches/' . $filename;

    sendResponse(true, [
        'download_url' => $downloadUrl,
        'filename' => $filename
    ]);
}
?>
