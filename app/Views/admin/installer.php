<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Installer - INLISlite v3.0' ?></title>
    
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
    <!-- Tentang CSS for consistent header styling -->
    <link href="<?= base_url('assets/css/admin/tentang.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/installer.css') ?>" rel="stylesheet">
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
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="INLISLite Logo" style="width: 24px; height: 24px;">
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
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
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
        <!-- Top Navigation -->
        <nav class="top-nav sticky-top">
            <div class="container-fluid">
                <div class="nav-content">
                    <div class="nav-left">
                        <a href="<?= base_url('admin/dashboard') ?>" class="back-btn" title="Kembali ke Dashboard">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div class="logo-section">
                            <div class="logo-icon">
                                <i class="bi bi-download"></i>
                            </div>
                            <div class="nav-text">
                                <h1 class="nav-title">InlisLite Installer</h1>
                                <p class="nav-subtitle">Paket unduhan dan instalasi sistem manajemen perpustakaan</p>
                            </div>
                        </div>
                    </div>
                    <div class="nav-right">
                        <a href="<?= base_url('admin/installer-edit') ?>" class="btn btn-management" title="Kelola Kartu Installer">
                            <i class="bi bi-gear-fill me-2"></i>
                            Manajemen Card
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="page-content">
            <div class="container-fluid">
                <!-- Header Section -->
                <div class="header-section">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="text-center mb-5">
                                <div class="header-icon">
                                    <i class="bi bi-download"></i>
                                </div>
                                <h1 class="header-title">InlisLite Installer</h1>
                                <p class="header-subtitle">Paket unduhan dan instalasi sistem manajemen perpustakaan digital terpadu untuk kebutuhan perpustakaan modern.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- Main Installer Section -->
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-10">
                        <div class="installer-main-card card">
                            <div class="card-header">
                                <div class="installer-header">
                                    <div class="installer-icon">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                    <div class="installer-title-section">
                                        <h4 class="installer-title">Installer INLISLite Versi 3.2 – Revisi 10 Februari 2021</h4>
                                        <p class="installer-subtitle">Paket instalasi lengkap sistem manajemen perpustakaan digital</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Warning Box -->
                                <div class="warning-box mb-4">
                                    <div class="warning-icon">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </div>
                                    <div class="warning-content">
                                        <h6 class="warning-title">Penting: Instalasi Baru</h6>
                                        <p class="warning-text">Ini adalah paket instalasi baru dan <strong>TIDAK KOMPATIBEL</strong> digunakan untuk memperbarui versi sebelumnya, silakan lakukan instalasi ulang (fresh install) untuk hasil terbaik.</p>
                                    </div>
                                </div>

                                <!-- Two Column Layout -->
                                <div class="row g-4">
                                    <!-- Left Card: Source Code Package -->
                                    <div class="col-lg-6">
                                        <div class="package-card">
                                            <div class="package-header">
                                                <div class="package-icon source-code">
                                                    <i class="bi bi-code-slash"></i>
                                                </div>
                                                <div class="package-title-section">
                                                    <h5 class="package-title">Paket Source Code</h5>
                                                    <span class="package-badge">File sumber PHP lengkap</span>
                                                </div>
                                            </div>
                                            <div class="package-content">
                                                <div class="package-features">
                                                    <div class="feature-item">
                                                        <i class="bi bi-check-circle text-success"></i>
                                                        <span>Seluruh file aplikasi PHP</span>
                                                    </div>
                                                    <div class="feature-item">
                                                        <i class="bi bi-check-circle text-success"></i>
                                                        <span>Dokumentasi dan panduan</span>
                                                    </div>
                                                    <div class="feature-item">
                                                        <i class="bi bi-check-circle text-success"></i>
                                                        <span>Template konfigurasi</span>
                                                    </div>
                                                    <div class="feature-item">
                                                        <i class="bi bi-check-circle text-success"></i>
                                                        <span>Struktur database</span>
                                                    </div>
                                                </div>
                                                <div class="package-size">
                                                    <i class="bi bi-hdd"></i>
                                                    <span>Ukuran file: ~25 MB</span>
                                                </div>
                                            </div>
                                            <div class="package-footer">
                                                <button class="btn btn-download btn-source" data-package="source">
                                                    <i class="bi bi-download me-2"></i>
                                                    Unduh Source Code
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Card: System Requirements -->
                                    <div class="col-lg-6">
                                        <div class="requirements-card">
                                            <div class="requirements-header">
                                                <div class="requirements-icon">
                                                    <i class="bi bi-gear"></i>
                                                </div>
                                                <h5 class="requirements-title">Persyaratan Sistem</h5>
                                            </div>
                                            <div class="requirements-content">
                                                <div class="requirement-item">
                                                    <div class="requirement-label">
                                                        <i class="bi bi-laptop"></i>
                                                        <span>Sistem Operasi</span>
                                                    </div>
                                                    <div class="requirement-value">Windows 7/8/10/11 atau Linux</div>
                                                </div>
                                                <div class="requirement-item">
                                                    <div class="requirement-label">
                                                        <i class="bi bi-cpu"></i>
                                                        <span>Processor</span>
                                                    </div>
                                                    <div class="requirement-value">Intel Pentium 4 atau setara</div>
                                                </div>
                                                <div class="requirement-item">
                                                    <div class="requirement-label">
                                                        <i class="bi bi-memory"></i>
                                                        <span>Memori</span>
                                                    </div>
                                                    <div class="requirement-value">Minimal 2 GB RAM</div>
                                                </div>
                                                <div class="requirement-item">
                                                    <div class="requirement-label">
                                                        <i class="bi bi-hdd"></i>
                                                        <span>Penyimpanan</span>
                                                    </div>
                                                    <div class="requirement-value">Rekomendasi 500 MB ruang kosong</div>
                                                </div>
                                                <div class="requirement-item">
                                                    <div class="requirement-label">
                                                        <i class="bi bi-browser-chrome"></i>
                                                        <span>Browser</span>
                                                    </div>
                                                    <div class="requirement-value">Chrome, Firefox, Safari, Edge (latest)</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Installation Steps Section -->
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-10">
                        <div class="installation-steps-card card">
                            <div class="card-header">
                                <div class="steps-header">
                                    <div class="steps-icon">
                                        <i class="bi bi-list-ol"></i>
                                    </div>
                                    <h5 class="steps-title">Langkah-langkah Instalasi</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-lg-8">
                                        <div class="installation-steps">
                                            <div class="step-item">
                                                <div class="step-number">1</div>
                                                <div class="step-content">
                                                    <h6 class="step-title">Ekstrak File ZIP</h6>
                                                    <p class="step-description">Ekstrak file ZIP ke direktori yang diinginkan</p>
                                                </div>
                                            </div>
                                            <div class="step-item">
                                                <div class="step-number">2</div>
                                                <div class="step-content">
                                                    <h6 class="step-title">Jalankan Installer</h6>
                                                    <p class="step-description">Jalankan file installer (.exe) sebagai Administrator</p>
                                                </div>
                                            </div>
                                            <div class="step-item">
                                                <div class="step-number">3</div>
                                                <div class="step-content">
                                                    <h6 class="step-title">Ikuti Wizard</h6>
                                                    <p class="step-description">Ikuti petunjuk pada wizard instalasi</p>
                                                </div>
                                            </div>
                                            <div class="step-item">
                                                <div class="step-number">4</div>
                                                <div class="step-content">
                                                    <h6 class="step-title">Pilih Direktori</h6>
                                                    <p class="step-description">Pilih direktori instalasi (default: C:\INLISLite)</p>
                                                </div>
                                            </div>
                                            <div class="step-item">
                                                <div class="step-number">5</div>
                                                <div class="step-content">
                                                    <h6 class="step-title">Tunggu Proses</h6>
                                                    <p class="step-description">Tunggu hingga proses instalasi selesai</p>
                                                </div>
                                            </div>
                                            <div class="step-item">
                                                <div class="step-number">6</div>
                                                <div class="step-content">
                                                    <h6 class="step-title">Akses Browser</h6>
                                                    <p class="step-description">Akses aplikasi melalui browser</p>
                                                </div>
                                            </div>
                                            <div class="step-item">
                                                <div class="step-number">7</div>
                                                <div class="step-content">
                                                    <h6 class="step-title">Login Sistem</h6>
                                                    <p class="step-description">Login dengan kredensial bawaan</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="login-credentials-box">
                                            <div class="credentials-header">
                                                <i class="bi bi-key"></i>
                                                <h6 class="credentials-title">Default Admin Login</h6>
                                            </div>
                                            <div class="credentials-content">
                                                <div class="credential-row">
                                                    <label class="credential-label">Username:</label>
                                                    <div class="credential-value">
                                                        <code class="credential-code">inlislite</code>
                                                        <button class="btn btn-sm btn-outline-secondary copy-btn" data-copy="inlislite" title="Copy Username">
                                                            <i class="bi bi-copy"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="credential-row">
                                                    <label class="credential-label">Password:</label>
                                                    <div class="credential-value">
                                                        <code class="credential-code">inlislite</code>
                                                        <button class="btn btn-sm btn-outline-secondary copy-btn" data-copy="inlislite" title="Copy Password">
                                                            <i class="bi bi-copy"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Source Code & SQL Section -->
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="additional-packages-card card">
                            <div class="card-header">
                                <div class="additional-header">
                                    <div class="additional-icon">
                                        <i class="bi bi-archive"></i>
                                    </div>
                                    <div class="additional-title-section">
                                        <h5 class="additional-title">Paket source code INLISLite versi 3.2 revisi 10 Februari 2021</h5>
                                        <p class="additional-subtitle">(untuk Windows/Linux)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mini-package-card">
                                            <div class="mini-package-icon php">
                                                <i class="bi bi-filetype-php"></i>
                                            </div>
                                            <div class="mini-package-content">
                                                <h6 class="mini-package-title">Source Code (PHP)</h6>
                                                <p class="mini-package-description">File sumber lengkap aplikasi PHP</p>
                                                <button class="btn btn-sm btn-outline-primary btn-download-mini" data-package="php">
                                                    <i class="bi bi-download me-1"></i>
                                                    Download
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mini-package-card">
                                            <div class="mini-package-icon sql">
                                                <i class="bi bi-database"></i>
                                            </div>
                                            <div class="mini-package-content">
                                                <h6 class="mini-package-title">Paket Basis Data Kosong</h6>
                                                <p class="mini-package-description">inlislite_empty_database.sql</p>
                                                <button class="btn btn-sm btn-outline-success btn-download-mini" data-package="sql">
                                                    <i class="bi bi-download me-1"></i>
                                                    Download
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url('assets/js/admin/installer.js') ?>"></script>
    
    <script>
        // Logout confirmation function
        function confirmLogout() {
            return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
        }

        // Initialize Feather icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</body>
</html>