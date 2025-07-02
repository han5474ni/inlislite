<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'INLISLite v3.0 - Sistem Perpustakaan Digital' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #007bff 0%, #34a853 100%);
            --sidebar-gradient: linear-gradient(180deg, #34a853 0%, #0f9d58 100%);
            --text-dark: #212529;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
            --shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
        }
        
        /* Navigation Styles */
        .main-navbar {
            background: rgba(44, 62, 80, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .main-navbar.scrolled {
            background: rgba(44, 62, 80, 0.98);
            box-shadow: var(--shadow-lg);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: white !important;
            text-decoration: none;
        }
        
        .navbar-brand:hover {
            color: #3498db !important;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: white !important;
            transform: translateY(-1px);
        }
        
        .nav-link.active {
            color: #3498db !important;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 2px;
            background: #3498db;
            border-radius: 1px;
        }
        
        .btn-login {
            background: var(--primary-gradient);
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
            color: white;
        }
        
        /* Breadcrumb Styles */
        .breadcrumb-section {
            background: #f8f9fa;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item {
            font-size: 0.9rem;
        }
        
        .breadcrumb-item a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .breadcrumb-item a:hover {
            color: #007bff;
        }
        
        .breadcrumb-item.active {
            color: var(--text-dark);
            font-weight: 500;
        }
        
        /* Page Header */
        .page-header {
            background: white;
            padding: 2rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
        }
        
        /* Quick Actions */
        .quick-actions {
            background: white;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .quick-action-btn {
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .quick-action-btn:hover {
            border-color: #007bff;
            color: #007bff;
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }
        
        .quick-action-btn.primary {
            background: #007bff;
            border-color: #007bff;
            color: white;
        }
        
        .quick-action-btn.primary:hover {
            background: #0056b3;
            border-color: #0056b3;
            color: white;
        }
        
        /* Footer */
        .main-footer {
            background: #2c3e50;
            color: white;
            padding: 2rem 0 1rem;
            margin-top: auto;
        }
        
        .footer-link {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-link:hover {
            color: #3498db;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }
            
            .quick-actions {
                text-align: center;
            }
            
            .quick-action-btn {
                width: 100%;
                justify-content: center;
                margin-right: 0;
            }
        }
    </style>
    
    <?= $this->renderSection('additional_css') ?>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark main-navbar fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <i class="bi bi-star-fill me-2"></i>
                INLISLite v3.0
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= (current_url() == base_url('/') || current_url() == base_url('home')) ? 'active' : '' ?>" 
                           href="<?= base_url('/') ?>">
                            <i class="bi bi-house me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos(current_url(), 'tentang') !== false) ? 'active' : '' ?>" 
                           href="<?= base_url('tentang') ?>">
                            <i class="bi bi-info-circle me-1"></i>About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos(current_url(), 'panduan') !== false) ? 'active' : '' ?>" 
                           href="<?= base_url('panduan') ?>">
                            <i class="bi bi-book me-1"></i>Guide
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos(current_url(), 'aplikasi') !== false) ? 'active' : '' ?>" 
                           href="<?= base_url('aplikasi') ?>">
                            <i class="bi bi-download me-1"></i>Apps
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos(current_url(), 'patch') !== false) ? 'active' : '' ?>" 
                           href="<?= base_url('patch') ?>">
                            <i class="bi bi-arrow-up-circle me-1"></i>Updates
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if (session()->get('admin_logged_in')): ?>
                        <!-- Admin is logged in -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>
                                <?= session()->get('admin_nama_lengkap') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/dashboard') ?>">
                                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/users') ?>">
                                        <i class="bi bi-people me-2"></i>User Management
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/secure-logout') ?>">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Admin not logged in -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/secure-login') ?>" class="btn-login">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                Admin Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Spacer for fixed navbar -->
    <div style="height: 76px;"></div>
    
    <!-- Breadcrumb Section -->
    <?php if (isset($breadcrumbs) && !empty($breadcrumbs)): ?>
    <section class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/') ?>">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <?php foreach ($breadcrumbs as $breadcrumb): ?>
                        <?php if (isset($breadcrumb['url'])): ?>
                            <li class="breadcrumb-item">
                                <a href="<?= $breadcrumb['url'] ?>"><?= $breadcrumb['title'] ?></a>
                            </li>
                        <?php else: ?>
                            <li class="breadcrumb-item active"><?= $breadcrumb['title'] ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Page Header -->
    <?php if (isset($show_page_header) && $show_page_header): ?>
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="page-title"><?= $page_title ?? 'Page Title' ?></h1>
                    <?php if (isset($page_subtitle)): ?>
                        <p class="page-subtitle"><?= $page_subtitle ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <?= $this->renderSection('page_actions') ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Quick Actions -->
    <?php if (isset($quick_actions) && !empty($quick_actions)): ?>
    <section class="quick-actions">
        <div class="container">
            <div class="d-flex flex-wrap">
                <?php foreach ($quick_actions as $action): ?>
                    <a href="<?= $action['url'] ?>" 
                       class="quick-action-btn <?= $action['class'] ?? '' ?>">
                        <?php if (isset($action['icon'])): ?>
                            <i class="<?= $action['icon'] ?>"></i>
                        <?php endif; ?>
                        <?= $action['title'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="flex-grow-1">
        <?= $this->renderSection('content') ?>
    </main>
    
    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-star-fill me-2" style="color: #ffd700; font-size: 1.5rem;"></i>
                        <h5 class="mb-0">INLISLite v3.0</h5>
                    </div>
                    <p class="text-muted">
                        Sistem otomasi perpustakaan modern untuk kebutuhan perpustakaan masa kini.
                    </p>
                </div>
                <div class="col-lg-3">
                    <h6 class="mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= base_url('tentang') ?>" class="footer-link">About</a></li>
                        <li class="mb-2"><a href="<?= base_url('panduan') ?>" class="footer-link">User Guide</a></li>
                        <li class="mb-2"><a href="<?= base_url('aplikasi') ?>" class="footer-link">Applications</a></li>
                        <li class="mb-2"><a href="<?= base_url('patch') ?>" class="footer-link">Updates</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="mb-3">Admin Area</h6>
                    <ul class="list-unstyled">
                        <?php if (session()->get('admin_logged_in')): ?>
                            <li class="mb-2"><a href="<?= base_url('admin/dashboard') ?>" class="footer-link">Dashboard</a></li>
                            <li class="mb-2"><a href="<?= base_url('admin/users') ?>" class="footer-link">User Management</a></li>
                            <li class="mb-2"><a href="<?= base_url('admin/secure-logout') ?>" class="footer-link">Logout</a></li>
                        <?php else: ?>
                            <li class="mb-2"><a href="<?= base_url('admin/secure-login') ?>" class="footer-link">Admin Login</a></li>
                            <li class="mb-2"><a href="<?= base_url('admin/forgot-password') ?>" class="footer-link">Forgot Password</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <hr style="border-color: #34495e; margin: 2rem 0 1rem;">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        &copy; 2024 INLISLite v3.0. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        Version 3.0.0 | Build <?= date('Y.m.d') ?>
                    </small>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.main-navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('alert-success') || alert.classList.contains('alert-info')) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);
    </script>
    
    <?= $this->renderSection('additional_js') ?>
</body>
</html>