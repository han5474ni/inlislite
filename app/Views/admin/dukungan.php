<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dukungan Teknis - INLISLite v3' ?></title>
    
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
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/dukungan.css') ?>" rel="stylesheet">
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
                <a href="<?= base_url('admin/logout') ?>" class="nav-link logout-link" onclick="return confirmLogout()">
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
                        <a href="<?= base_url('admin/dashboard') ?>" class="back-btn" title="Back to Dashboard">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div class="logo-section">
                            <div class="logo-icon">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div class="nav-text">
                                <h1 class="nav-title">Dukungan Teknis</h1>
                                <p class="nav-subtitle">Bantuan teknis profesional</p>
                            </div>
                        </div>
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
                                    <i class="bi bi-headset"></i>
                                </div>
                                <h1 class="header-title">Dukungan Teknis INLISLite v3</h1>
                                <p class="header-subtitle">Dapatkan bantuan teknis profesional dari Tim Sistem Informasi Pusat Data dan Informasi untuk sistem manajemen perpustakaan INLISLite versi 3.</p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <!-- Support Content -->
                <div class="support-content">
                    <!-- Tim Sistem Informasi -->
                    <div class="support-section mb-5">
                        <div class="support-card">
                            <div class="card-header">
                                <div class="header-info">
                                    <div class="header-icon-wrapper">
                                        <i class="bi bi-headset"></i>
                                    </div>
                                    <div class="header-details">
                                        <h3 class="card-title">Tim Sistem Informasi</h3>
                                        <p class="card-subtitle">Pusat Data dan Informasi – Perpustakaan Nasional Republik Indonesia</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="contact-grid">
                                    <div class="contact-card">
                                        <div class="contact-icon">
                                            <i class="bi bi-telephone"></i>
                                        </div>
                                        <div class="contact-info">
                                            <h6 class="contact-label">Telepon</h6>
                                            <p class="contact-value">(021) 3103554</p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-card">
                                        <div class="contact-icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                        <div class="contact-info">
                                            <h6 class="contact-label">Email</h6>
                                            <p class="contact-value">info@perpusnas.go.id</p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-card">
                                        <div class="contact-icon">
                                            <i class="bi bi-clock"></i>
                                        </div>
                                        <div class="contact-info">
                                            <h6 class="contact-label">Jam Layanan</h6>
                                            <p class="contact-value">Senin–Jumat 08:00–16:00 WIB</p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-card">
                                        <div class="contact-icon">
                                            <i class="bi bi-geo-alt"></i>
                                        </div>
                                        <div class="contact-info">
                                            <h6 class="contact-label">Alamat</h6>
                                            <p class="contact-value">Jl. Medan Merdeka Selatan No. 11, Jakarta Pusat 10110</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Layanan Dukungan yang Tersedia -->
                    <div class="support-section mb-5">
                        <div class="support-card">
                            <div class="card-header">
                                <div class="header-info">
                                    <div class="header-icon-wrapper green">
                                        <i class="bi bi-tools"></i>
                                    </div>
                                    <div class="header-details">
                                        <h3 class="card-title">Layanan Dukungan yang Tersedia</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="services-list">
                                    <div class="service-item">
                                        <div class="service-bullet"></div>
                                        <div class="service-content">
                                            <h6 class="service-title">Dukungan Instalasi</h6>
                                            <p class="service-description">Bantuan dalam instalasi dan konfigurasi perangkat lunak</p>
                                        </div>
                                    </div>
                                    
                                    <div class="service-item">
                                        <div class="service-bullet"></div>
                                        <div class="service-content">
                                            <h6 class="service-title">Pemecahan Masalah Teknis</h6>
                                            <p class="service-description">Diagnosa dan penyelesaian masalah teknis</p>
                                        </div>
                                    </div>
                                    
                                    <div class="service-item">
                                        <div class="service-bullet"></div>
                                        <div class="service-content">
                                            <h6 class="service-title">Pelatihan Pengguna</h6>
                                            <p class="service-description">Sesi pelatihan untuk administrator sistem</p>
                                        </div>
                                    </div>
                                    
                                    <div class="service-item">
                                        <div class="service-bullet"></div>
                                        <div class="service-content">
                                            <h6 class="service-title">Bantuan Jarak Jauh</h6>
                                            <p class="service-description">Dukungan teknis jarak jauh melalui remote desktop</p>
                                        </div>
                                    </div>
                                    
                                    <div class="service-item">
                                        <div class="service-bullet"></div>
                                        <div class="service-content">
                                            <h6 class="service-title">Dokumentasi & Panduan</h6>
                                            <p class="service-description">Dokumen dan buku panduan pengguna</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cara Meminta Bantuan Teknis -->
                    <div class="support-section">
                        <div class="support-card request-card">
                            <div class="card-header blue-header">
                                <div class="header-info">
                                    <div class="header-icon-wrapper blue">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                    <div class="header-details">
                                        <h3 class="card-title">Cara Meminta Bantuan Teknis</h3>
                                        <p class="card-subtitle">Ikuti langkah-langkah berikut untuk mendapatkan dukungan teknis yang Anda butuhkan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="request-grid">
                                    <!-- Dukungan Langsung -->
                                    <div class="request-card">
                                        <div class="request-header">
                                            <div class="request-icon red">
                                                <i class="bi bi-telephone-fill"></i>
                                            </div>
                                            <h5 class="request-title">Untuk Dukungan Langsung</h5>
                                        </div>
                                        <div class="request-steps">
                                            <div class="step-item">
                                                <div class="step-number">1</div>
                                                <p class="step-text">Hubungi nomor telepon (021) 3103554 pada jam kerja</p>
                                            </div>
                                            <div class="step-item">
                                                <div class="step-number">2</div>
                                                <p class="step-text">Jelaskan masalah yang Anda hadapi dengan detail</p>
                                            </div>
                                            <div class="step-item">
                                                <div class="step-number">3</div>
                                                <p class="step-text">Siapkan informasi sistem dan versi INLISLite yang digunakan</p>
                                            </div>
                                            <div class="step-item">
                                                <div class="step-number">4</div>
                                                <p class="step-text">Tim teknis akan memberikan solusi atau jadwal kunjungan</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dukungan Email -->
                                    <div class="request-card">
                                        <div class="request-header">
                                            <div class="request-icon red">
                                                <i class="bi bi-envelope-fill"></i>
                                            </div>
                                            <h5 class="request-title">Untuk Dukungan Email</h5>
                                        </div>
                                        <div class="request-steps">
                                            <div class="step-item">
                                                <div class="step-number">1</div>
                                                <p class="step-text">Kirim email ke info@perpusnas.go.id</p>
                                            </div>
                                            <div class="step-item">
                                                <div class="step-number">2</div>
                                                <p class="step-text">Sertakan detail lembaga dan kontak</p>
                                            </div>
                                            <div class="step-item">
                                                <div class="step-number">3</div>
                                                <p class="step-text">Jelaskan jenis bantuan yang dibutuhkan</p>
                                            </div>
                                            <div class="step-item">
                                                <div class="step-number">4</div>
                                                <p class="step-text">Tunggu respon 1–2 hari kerja</p>
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
    <script src="<?= base_url('assets/js/admin/dukungan.js') ?>"></script>
    
    <style>
        /* Logout button styling - matching panduan page */
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

        // Initialize Feather icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</body>
</html>