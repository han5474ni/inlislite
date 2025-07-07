<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'INLISLite v3 - Sistem Otomasi Perpustakaan' ?></title>
    <meta name="description" content="<?= $meta_description ?? 'Sistem otomasi perpustakaan modern dengan teknologi terdepan untuk mengelola perpustakaan secara digital dan terintegrasi.' ?>">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    <!-- Public CSS -->
    <link href="<?= base_url('assets/css/public/main.css') ?>" rel="stylesheet">
    
    <!-- Page specific CSS -->
    <?php if (isset($page_css)): ?>
        <link href="<?= base_url('assets/css/public/' . $page_css) ?>" rel="stylesheet">
    <?php endif; ?>
    
    <style>
        :root {
            /* Admin Color Palette - Exact Match */
            --primary-green: #0B8F1C;
            --light-green: #2DA84D;
            --medium-blue: #1C6EC4;
            --dark-blue: #004AAD;
            --orange: #D77936;
            
            /* Gradients matching admin interface */
            --primary-gradient: linear-gradient(135deg, #1C6EC4 0%, #2DA84D 100%);
            --secondary-gradient: linear-gradient(135deg, #2DA84D 0%, #0B8F1C 100%);
            --success-gradient: linear-gradient(135deg, #0B8F1C 0%, #2DA84D 100%);
            --warning-gradient: linear-gradient(135deg, #D77936 0%, #f093fb 100%);
            --info-gradient: linear-gradient(135deg, #1C6EC4 0%, #004AAD 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            
            /* Additional colors */
            --success-color: #0B8F1C;
            --warning-color: #D77936;
            --danger-color: #dc3545;
            --info-color: #1C6EC4;
            --dark-color: #2c3e50;
            
            /* Design tokens */
            --border-radius: 12px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            background: var(--primary-gradient);
            min-height: 100vh;
        }
        
        /* Navigation Styles - Matching Admin Sidebar */
        .navbar-public {
            background: var(--secondary-gradient);
            backdrop-filter: blur(10px);
            transition: var(--transition);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .navbar-public.scrolled {
            background: rgba(45, 168, 77, 0.98);
            box-shadow: 0 2px 30px rgba(0, 0, 0, 0.2);
            padding: 0.5rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
            color: white !important;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
            padding: 0.75rem 1rem !important;
            border-radius: 8px;
            margin: 0 0.25rem;
            font-size: 0.9rem;
        }
        
        .nav-link:hover,
        .nav-link.active {
            color: white !important;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            width: 0;
            height: 2px;
            background: white;
            transition: var(--transition);
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 80%;
        }
        
        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            padding: 1rem 0;
            background: white;
        }
        
        .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
            border-radius: 0;
            color: var(--dark-color);
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateX(5px);
        }
        
        /* Page Header Styles - Matching Admin */
        .page-header {
            background: var(--primary-gradient);
            color: white;
            padding: 8rem 0 4rem;
            position: relative;
            overflow: hidden;
            margin-top: 76px;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"%3E%3Cpolygon fill="rgba(255,255,255,0.1)" points="0,1000 1000,0 1000,1000"/%3E%3C/svg%3E');
            background-size: cover;
        }
        
        .page-header-content {
            position: relative;
            z-index: 2;
        }
        
        .page-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: slideUp 0.8s ease-out;
        }
        
        .page-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            animation: slideUp 0.8s ease-out 0.2s both;
        }
        
        .page-icon {
            font-size: 4rem;
            margin-bottom: 2rem;
            opacity: 0.8;
            animation: slideUp 0.8s ease-out 0.1s both;
        }
        
        /* Breadcrumb Styles */
        .breadcrumb-section {
            background: #f8f9fa;
            padding: 1rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .breadcrumb {
            background: transparent;
            margin: 0;
            padding: 0;
        }
        
        .breadcrumb-item a {
            color: var(--medium-blue);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .breadcrumb-item a:hover {
            color: var(--dark-blue);
        }
        
        .breadcrumb-item.active {
            color: #6c757d;
        }
        
        /* Content Styles */
        .main-content {
            padding: 4rem 0;
            min-height: 60vh;
            background: #f8f9fa;
        }
        
        .content-card {
            background: white;
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            overflow: hidden;
        }
        
        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .content-card .card-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1.5rem;
        }
        
        .content-card .card-body {
            padding: 2rem;
        }
        
        /* Button Styles - Matching Admin */
        .btn-primary-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 8px;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(28, 110, 196, 0.3);
        }
        
        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(28, 110, 196, 0.4);
            color: white;
            background: var(--info-gradient);
        }
        
        .btn-secondary-gradient {
            background: var(--secondary-gradient);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 8px;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(45, 168, 77, 0.3);
        }
        
        .btn-secondary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 168, 77, 0.4);
            color: white;
            background: var(--success-gradient);
        }
        
        /* Form Styles */
        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: var(--transition);
        }
        
        .form-control:focus {
            border-color: var(--medium-blue);
            box-shadow: 0 0 0 0.2rem rgba(28, 110, 196, 0.25);
        }
        
        .form-select {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: var(--transition);
        }
        
        .form-select:focus {
            border-color: var(--medium-blue);
            box-shadow: 0 0 0 0.2rem rgba(28, 110, 196, 0.25);
        }
        
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        /* Animation */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .animate-on-scroll.fade-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header {
                padding: 6rem 0 3rem;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .page-subtitle {
                font-size: 1rem;
            }
            
            .page-icon {
                font-size: 3rem;
            }
            
            .main-content {
                padding: 2rem 0;
            }
            
            .content-card .card-body {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .page-header {
                padding: 5rem 0 2rem;
            }
            
            .page-title {
                font-size: 1.75rem;
            }
            
            .content-card .card-body {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-public" id="mainNavbar">
        <div class="container"<a class="navbar-brand" href="<?= base_url('/') ?>">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="INLISLite Logo" style="width: 32px; height: 32px;">
                INLISLite v3
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($page_title === 'Home') ? 'active' : '' ?>" href="<?= base_url('/') ?>">
                            <i class="bi bi-house me-1"></i>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page_title === 'Tentang Kami') ? 'active' : '' ?>" href="<?= base_url('tentang') ?>">
                            <i class="bi bi-info-circle me-1"></i>
                            Tentang Kami
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page_title === 'Panduan') ? 'active' : '' ?>" href="<?= base_url('panduan') ?>">
                            <i class="bi bi-book me-1"></i>
                            Panduan
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-grid-3x3-gap me-1"></i>
                            Layanan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('aplikasi') ?>">
                                <i class="bi bi-app me-2"></i>Aplikasi Pendukung
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('patch') ?>">
                                <i class="bi bi-arrow-clockwise me-2"></i>Patch & Updater
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('demo') ?>">
                                <i class="bi bi-play-circle me-2"></i>Demo Program
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('dukungan') ?>">
                                <i class="bi bi-headset me-2"></i>Dukungan Teknis
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('bimbingan') ?>">
                                <i class="bi bi-mortarboard me-2"></i>Bimbingan Teknis
                            </a></li>
                        </ul>
                    </li>
                                    </ul>
            </div>
        </div>
    </nav>