<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, #007bff 0%, #34a853 100%);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: linear-gradient(135deg, #007bff 0%, #34a853 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }
        
        .btn-logout {
            background: #dc3545;
            border: none;
            border-radius: 10px;
        }
        
        .btn-logout:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-star-fill me-2"></i>
                INLISLite v3.0 - Dashboard
            </a>
            
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Selamat datang, <?= session()->get('admin_name') ?>
                </span>
                <a href="<?= base_url('admin/simple-logout') ?>" class="btn btn-logout btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    Logout
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <!-- Alert Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard Admin
                        </h5>
                    </div>
                    <div class="card-body">
                        <h4>Login Berhasil!</h4>
                        <p class="lead">Selamat datang di dashboard admin INLISLite v3.0</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6>Informasi Session:</h6>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>ID:</strong> <?= session()->get('admin_id') ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Username:</strong> <?= session()->get('admin_username') ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Nama:</strong> <?= session()->get('admin_name') ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Email:</strong> <?= session()->get('admin_email') ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Role:</strong> <?= session()->get('admin_role') ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Login Time:</strong> <?= date('Y-m-d H:i:s', session()->get('login_time')) ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Menu Admin:</h6>
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <i class="bi bi-people me-2"></i>
                                        Manajemen User
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <i class="bi bi-book me-2"></i>
                                        Manajemen Buku
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <i class="bi bi-gear me-2"></i>
                                        Pengaturan
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <i class="bi bi-graph-up me-2"></i>
                                        Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-2"></i>
                                <strong>Login berhasil!</strong> Masalah CSRF token telah diperbaiki.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>