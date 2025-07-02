<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'INLISLite v3.0 Dashboard - Sistem Perpustakaan Modern' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i data-feather="menu"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <i data-feather="star"></i>
                </div>
                <div class="sidebar-title">
                    INLISlite v3.0<br>
                    <small style="font-size: 0.85rem; opacity: 0.8;">Dashboard</small>
                </div>
            </a>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i data-feather="chevrons-left"></i>
            </button>
        </div>
        
        <div class="sidebar-nav">
            <div class="nav-item">
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link active">
                    <i data-feather="home" class="nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="nav-tooltip">Dashboard</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/users') ?>" class="nav-link">
                    <i data-feather="users" class="nav-icon"></i>
                    <span class="nav-text">Manajemen User</span>
                </a>
                <div class="nav-tooltip">Manajemen User</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('registration') ?>" class="nav-link">
                    <i data-feather="book" class="nav-icon"></i>
                    <span class="nav-text">Registrasi</span>
                </a>
                <div class="nav-tooltip">Registrasi</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/profile') ?>" class="nav-link">
                    <i data-feather="user" class="nav-icon"></i>
                    <span class="nav-text">Profile</span>
                </a>
                <div class="nav-tooltip">Profile</div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-header">
            <h1 class="main-title"><?= $page_title ?? 'Selamat Datang di InlisLite!' ?></h1>
            <p class="main-subtitle"><?= $page_subtitle ?? 'Kelola sistem perpustakaan Anda dengan alat dan analitik yang lengkap.' ?></p>
        </div>

        <div class="cards-grid">
            <!-- Card 1: Tentang InlisLite -->
            <div class="feature-card loading">
                <div class="card-icon">
                    <i data-feather="book"></i>
                </div>
                <h3 class="card-title">Tentang InlisLite</h3>
                <p class="card-description">Sistem manajemen perpustakaan modern dengan fitur terbaru dan teknologi terdepan.</p>
                <span class="card-badge new">Baru</span>
            </div>

            <!-- Card 2: Features & Program Modules -->
            <div class="feature-card loading">
                <div class="card-icon">
                    <i data-feather="grid"></i>
                </div>
                <h3 class="card-title">Features & Program Modules</h3>
                <p class="card-description">Akses ke semua modul dan fitur lengkap sistem perpustakaan.</p>
                <span class="card-badge modules">15 Modul</span>
            </div>

            <!-- Card 3: Installer -->
            <div class="feature-card loading">
                <div class="card-icon">
                    <i data-feather="download"></i>
                </div>
                <h3 class="card-title">Installer</h3>
                <p class="card-description">Panduan instalasi sistem langkah demi langkah yang mudah diikuti.</p>
            </div>

            <!-- Card 4: Patch dan Updater -->
            <div class="feature-card loading">
                <div class="card-icon">
                    <i data-feather="arrow-up-circle"></i>
                </div>
                <h3 class="card-title">Patch dan Updater</h3>
                <p class="card-description">Sistem pembaruan otomatis untuk menjaga aplikasi tetap terkini.</p>
                <span class="card-badge auto">Auto Update</span>
            </div>

            <!-- Card 5: Aplikasi Pendukung -->
            <div class="feature-card loading">
                <div class="card-icon">
                    <i data-feather="tool"></i>
                </div>
                <h3 class="card-title">Aplikasi Pendukung</h3>
                <p class="card-description">Koleksi aplikasi dan tools pendukung untuk meningkatkan produktivitas.</p>
                <span class="card-badge support">Dukungan 24/7</span>
            </div>

            <!-- Card 6: Panduan -->
            <div class="feature-card loading">
                <div class="card-icon">
                    <i data-feather="help-circle"></i>
                </div>
                <h3 class="card-title">Panduan</h3>
                <p class="card-description">Dokumentasi lengkap dan panduan penggunaan sistem perpustakaan.</p>
            </div>

            <!-- Card 7: Dukungan Teknis -->
            <div class="feature-card loading">
                <div class="card-icon">
                    <i data-feather="headphones"></i>
                </div>
                <h3 class="card-title">Dukungan Teknis</h3>
                <p class="card-description">Tim ahli siap membantu menyelesaikan masalah teknis Anda.</p>
            </div>

            <!-- Card 8: Alat Pengembang -->
            <div class="feature-card loading">
                <div class="card-icon">
                    <i data-feather="zap"></i>
                </div>
                <h3 class="card-title">Alat Pengembang</h3>
                <p class="card-description">Tools dan utilities untuk pengembangan dan kustomisasi sistem.</p>
            </div>

            <!-- Card 9: Demo Program -->
            <div class="feature-card loading">
                <div class="card-icon">
                    <i data-feather="bar-chart-2"></i>
                </div>
                <h3 class="card-title">Demo Program</h3>
                <p class="card-description">Demo interaktif untuk memahami fitur-fitur sistem perpustakaan.</p>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    
    <script>
        // Initialize Feather icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</body>
</html>