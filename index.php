<?php
/**
 * INLISLite v3.0 - Root Index
 * This file provides navigation to the organized project structure
 */

// Check if this is a direct access to root
if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/index.php') {
    // Redirect to the main application
    header('Location: /public/index.php');
    exit;
}

// If accessing specific organized directories, show navigation
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', trim($requestPath, '/'));
$baseDir = $pathParts[0] ?? '';

// Define accessible directories
$accessibleDirs = [
    'docs' => '📚 Documentation',
    'demo' => '🎮 Demo Files', 
    'setup' => '⚙️ Setup & Installation',
    'testing' => '🧪 Testing Files'
];

// If accessing an organized directory root, show index
if (in_array($baseDir, array_keys($accessibleDirs)) && count($pathParts) === 1) {
    showDirectoryIndex($baseDir, $accessibleDirs[$baseDir]);
    exit;
}

// Default: redirect to main application
header('Location: /public/index.php');
exit;

function showDirectoryIndex($directory, $title) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?> - INLISLite v3.0</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .container {
                padding: 2rem 0;
            }
            .card {
                border: none;
                border-radius: 1rem;
                box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
                backdrop-filter: blur(10px);
            }
            .card-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border-radius: 1rem 1rem 0 0 !important;
                padding: 2rem;
            }
            .list-group-item {
                border: none;
                padding: 1rem 1.5rem;
                transition: all 0.3s ease;
            }
            .list-group-item:hover {
                background: #f8f9fa;
                transform: translateX(5px);
            }
            .btn-back {
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.3);
                color: white;
                border-radius: 0.5rem;
                padding: 0.5rem 1rem;
                text-decoration: none;
                transition: all 0.3s ease;
            }
            .btn-back:hover {
                background: rgba(255, 255, 255, 0.3);
                color: white;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header text-center">
                            <h1 class="mb-3">
                                <i class="bi bi-star-fill me-2" style="color: #ffd700;"></i>
                                INLISLite v3.0
                            </h1>
                            <h2 class="h4 mb-3"><?= $title ?></h2>
                            <a href="/" class="btn-back">
                                <i class="bi bi-arrow-left me-2"></i>
                                Back to Main Application
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <?php showDirectoryContents($directory); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}

function showDirectoryContents($directory) {
    $readmePath = $directory . '/README.md';
    
    echo '<div class="list-group list-group-flush">';
    
    // Show README if exists
    if (file_exists($readmePath)) {
        echo '<a href="/' . $directory . '/README.md" class="list-group-item list-group-item-action">';
        echo '<i class="bi bi-book me-3"></i>';
        echo '<strong>README.md</strong>';
        echo '<small class="text-muted d-block">Main documentation for this section</small>';
        echo '</a>';
    }
    
    // Show directory contents
    if (is_dir($directory)) {
        $files = scandir($directory);
        $files = array_diff($files, ['.', '..', 'README.md']); // Exclude README as it's shown first
        
        foreach ($files as $file) {
            $filePath = $directory . '/' . $file;
            $isDir = is_dir($filePath);
            $icon = $isDir ? 'folder' : getFileIcon($file);
            $description = getFileDescription($file, $isDir);
            
            echo '<a href="/' . $filePath . '" class="list-group-item list-group-item-action">';
            echo '<i class="bi bi-' . $icon . ' me-3"></i>';
            echo '<strong>' . $file . '</strong>';
            if ($description) {
                echo '<small class="text-muted d-block">' . $description . '</small>';
            }
            echo '</a>';
        }
    }
    
    echo '</div>';
}

function getFileIcon($filename) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    switch ($extension) {
        case 'md': return 'file-text';
        case 'php': return 'file-code';
        case 'html': return 'file-code';
        case 'sql': return 'database';
        case 'js': return 'file-code';
        case 'css': return 'palette';
        default: return 'file-earmark';
    }
}

function getFileDescription($filename, $isDir) {
    if ($isDir) {
        return 'Directory';
    }
    
    $descriptions = [
        'setup_database.php' => 'Database setup wizard',
        'setup_simple.php' => 'Quick setup script',
        'fix_login_issues.php' => 'Login troubleshooting tool',
        'test_auth_filter.php' => 'Authentication filter testing',
        'test_login_system.php' => 'Login system testing',
        'main_index.php' => 'Main navigation hub',
        'index.html' => 'Standalone demo page'
    ];
    
    return $descriptions[$filename] ?? '';
}
?>