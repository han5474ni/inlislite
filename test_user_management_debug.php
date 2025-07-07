<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Debug - INLISLite v3.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-bug me-2"></i>User Management Debug</h4>
                    </div>
                    <div class="card-body">
                        <h5>Testing User Management Routes and Files</h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">Route Tests</h6>
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="/admin/users" target="_blank">admin/users</a>
                                        <span class="badge bg-info">Test</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="/usermanagement" target="_blank">usermanagement</a>
                                        <span class="badge bg-info">Test</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="/user-management" target="_blank">user-management</a>
                                        <span class="badge bg-info">Test</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="/admin/dashboard" target="_blank">admin/dashboard</a>
                                        <span class="badge bg-info">Test</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="col-md-6">
                                <h6 class="text-success">File Checks</h6>
                                <ul class="list-group mb-3">
                                    <?php
                                    $files_to_check = [
                                        'app/Views/admin/user_management.php',
                                        'app/Views/admin/partials/sidebar.php',
                                        'app/Controllers/admin/UserManagement.php',
                                        'public/assets/css/admin/user_management.css',
                                        'public/assets/js/admin/user_management.js',
                                        'app/Filters/AdminAuthFilter.php'
                                    ];
                                    
                                    foreach ($files_to_check as $file) {
                                        $exists = file_exists($file);
                                        $badge_class = $exists ? 'bg-success' : 'bg-danger';
                                        $status = $exists ? 'OK' : 'Missing';
                                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                                        echo "<span>" . basename($file) . "</span>";
                                        echo "<span class='badge {$badge_class}'>{$status}</span>";
                                        echo "</li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-warning">Current Environment</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Current URL:</strong></td>
                                            <td><?= $_SERVER['REQUEST_URI'] ?? 'N/A' ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Document Root:</strong></td>
                                            <td><?= $_SERVER['DOCUMENT_ROOT'] ?? 'N/A' ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Script Name:</strong></td>
                                            <td><?= $_SERVER['SCRIPT_NAME'] ?? 'N/A' ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>PHP Version:</strong></td>
                                            <td><?= phpversion() ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>CodeIgniter Check:</strong></td>
                                            <td>
                                                <?php
                                                if (file_exists('vendor/codeigniter4/framework/system/CodeIgniter.php')) {
                                                    echo '<span class="badge bg-success">Found</span>';
                                                } else {
                                                    echo '<span class="badge bg-danger">Not Found</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <h6><i class="bi bi-info-circle me-2"></i>Instructions:</h6>
                            <ol>
                                <li>Click on each route test link to see if they work</li>
                                <li>Check that all files show "OK" status</li>
                                <li>If routes fail, check if you're logged in to the admin area</li>
                                <li>If files are missing, they need to be created or restored</li>
                            </ol>
                        </div>
                        
                        <div class="text-center">
                            <a href="/admin/login" class="btn btn-primary me-2">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Admin Login
                            </a>
                            <a href="/admin/dashboard" class="btn btn-success">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>