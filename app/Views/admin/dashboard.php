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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                    <img src="<?= base_url('assets/images/inlislite.png') ?>" alt="INLISLite Logo" style="width: 24px; height: 24px;">
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
                <a href="<?= base_url('admin/registration') ?>" class="nav-link">
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
            
            <!-- Logout Button -->
            <div class="nav-item logout-item">
                <a href="<?= base_url('admin/secure-logout') ?>" class="nav-link logout-link" onclick="return confirmLogout()">
                    <i data-feather="log-out" class="nav-icon"></i>
                    <span class="nav-text">Logout</span>
                </a>
                <div class="nav-tooltip">Logout</div>
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
            <a href="<?= base_url('admin/tentang') ?>" class="feature-card loading" style="text-decoration: none; color: inherit;">
                <div class="card-icon">
    <img src="<?= base_url('assets/images/ikon inlislite.svg') ?>" alt="Ikon Tentang InlisLite" style="width: 40px; height: 40px;">
</div>

                <h3 class="card-title">Tentang InlisLite</h3>
                <p class="card-description">Sistem manajemen perpustakaan modern dengan fitur terbaru dan teknologi terdepan.</p>
            </a>

            <!-- Card 2: Features & Program Modules -->
            <a href="<?= base_url('admin/fitur') ?>" class="feature-card loading" style="text-decoration: none; color: inherit;">
                <div class="card-icon">
                    <img src="<?= base_url('assets/images/logo animation.svg') ?>" alt="Ikon Tentang InlisLite" style="width: 40px; height: 40px;">
                </div>
                <h3 class="card-title">Features & Program Modules</h3>
                <p class="card-description">Akses ke semua modul dan fitur lengkap sistem perpustakaan.</p>
                <span class="card-badge modules">15 Modul</span>
            </a>

            <!-- Card 3: Installer -->
            <a href="<?= base_url('admin/installer') ?>" class="feature-card loading" style="text-decoration: none; color: inherit;">
                <div class="card-icon">
                    <i data-feather="download"></i>
                </div>
                <h3 class="card-title">Installer</h3>
                <p class="card-description">Panduan instalasi sistem langkah demi langkah yang mudah diikuti.</p>
            </a>

            <!-- Card 4: Patch dan Updater -->
            <a href="<?= base_url('admin/patch') ?>" class="feature-card loading" style="text-decoration: none; color: inherit;">
                <div class="card-icon">
                    <i data-feather="arrow-up-circle"></i>
                </div>
                <h3 class="card-title">Patch dan Updater</h3>
                <p class="card-description">Sistem pembaruan otomatis untuk menjaga aplikasi tetap terkini.</p>
                <span class="card-badge auto">Auto Update</span>
            </a>

            <!-- Card 5: Aplikasi Pendukung -->
            <a href="<?= base_url('admin/aplikasi') ?>" class="feature-card loading" style="text-decoration: none; color: inherit;">
                <div class="card-icon">
                    <i data-feather="tool"></i>
                </div>
                <h3 class="card-title">Aplikasi Pendukung</h3>
                <p class="card-description">Koleksi aplikasi dan tools pendukung untuk meningkatkan produktivitas.</p>
                <span class="card-badge support">Dukungan 24/7</span>
            </a>

            <!-- Card 6: Panduan -->
            <a href="<?= base_url('admin/panduan') ?>" class="feature-card loading" style="text-decoration: none; color: inherit;">
                <div class="card-icon">
                    <i data-feather="help-circle"></i>
                </div>
                <h3 class="card-title">Panduan</h3>
                <p class="card-description">Dokumentasi lengkap dan panduan penggunaan sistem perpustakaan.</p>
            </a>

            <!-- Card 7: Dukungan Teknis -->
            <a href="<?= base_url('admin/dukungan') ?>" class="feature-card loading" style="text-decoration: none; color: inherit;">
                <div class="card-icon">
                    <i data-feather="headphones"></i>
                </div>
                <h3 class="card-title">Dukungan Teknis</h3>
                <p class="card-description">Tim ahli siap membantu menyelesaikan masalah teknis Anda.</p>
            </a>

            <!-- Card 8: Bimbingan Teknis -->
            <a href="<?= base_url('admin/bimbingan') ?>" class="feature-card loading" style="text-decoration: none; color: inherit;">
                <div class="card-icon">
                    <i data-feather="zap"></i>
                </div>
                <h3 class="card-title">Bimbingan Teknis</h3>
                <p class="card-description">Tools dan utilities untuk pengembangan dan kustomisasi sistem.</p>
            </a>

            <!-- Card 9: Demo Program -->
            <a href="<?= base_url('admin/demo_program') ?>" class="feature-card loading" style="text-decoration: none; color: inherit;">
                <div class="card-icon">
                    <i data-feather="bar-chart-2"></i>
                </div>
                <h3 class="card-title">Demo Program</h3>
                <p class="card-description">Demo interaktif untuk memahami fitur-fitur sistem perpustakaan.</p>
            </a>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    
    <style>
        /* Logout button styling - matching login button style */
        .logout-item {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1rem;
        }

        .logout-link {
            background: transparent !important;
            color: rgba(255, 255, 255, 0.8) !important;
            border-radius: 0.25rem;
            margin: 0.25rem;
            transition: all 0.3s ease;
            text-transform: none;
            letter-spacing: normal;
            font-weight: 400;
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }

        .logout-link:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            transform: none;
            box-shadow: none;
        }

        .logout-link:hover .nav-icon {
            transform: translateX(3px);
        }

        /* Ensure sidebar nav takes full height and logout stays at bottom */
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 120px);
            overflow: hidden;
        }

        .sidebar-nav .nav-item:not(.logout-item) {
            flex-shrink: 0;
        }
    </style>

    <script>
        // Logout confirmation function
        function confirmLogout() {
            return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
        }

        // Mark that user has visited an admin page
        sessionStorage.setItem('admin_page_visited', 'true');
        
        // Initialize Feather icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</body>
</html>