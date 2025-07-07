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

                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- Support Content -->
                <div class="support-content">
                    <!-- Bagian 1: Tim Sistem Informasi -->
                    <div class="support-section mb-5">
                        <div class="support-card main-card" data-card-id="tim-sistem-informasi">
                            <div class="card-header d-flex justify-content-between align-items-start">
                                <div class="header-info">
                                    <div class="header-icon-wrapper">
                                        <i class="bi bi-headset"></i>
                                    </div>
                                    <div class="header-details">
                                        <h3 class="card-title editable" data-field="title">Tim Sistem Informasi</h3>
                                        <p class="card-subtitle editable" data-field="subtitle">Pusat Data dan Informasi – Perpustakaan Nasional Republik Indonesia</p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                                        <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item toggle-card" href="#"><i class="bi bi-eye-slash me-2"></i>Hide</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="contact-grid">
                                    <div class="contact-card editable-contact" data-contact-id="phone">
                                        <div class="contact-icon">
                                            <i class="bi bi-telephone"></i>
                                        </div>
                                        <div class="contact-info">
                                            <h6 class="contact-label editable" data-field="label">Telepon</h6>
                                            <p class="contact-value editable" data-field="value">(021) 3103554</p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-card editable-contact" data-contact-id="email">
                                        <div class="contact-icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                        <div class="contact-info">
                                            <h6 class="contact-label editable" data-field="label">Email</h6>
                                            <p class="contact-value editable" data-field="value">info@perpusnas.go.id</p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-card editable-contact" data-contact-id="hours">
                                        <div class="contact-icon">
                                            <i class="bi bi-clock"></i>
                                        </div>
                                        <div class="contact-info">
                                            <h6 class="contact-label editable" data-field="label">Jam Layanan</h6>
                                            <p class="contact-value editable" data-field="value">Senin–Jumat 08:00–16:00 WIB</p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-card editable-contact" data-contact-id="address">
                                        <div class="contact-icon">
                                            <i class="bi bi-geo-alt"></i>
                                        </div>
                                        <div class="contact-info">
                                            <h6 class="contact-label editable" data-field="label">Alamat</h6>
                                            <p class="contact-value editable" data-field="value">Jl. Medan Merdeka Selatan No. 11, Jakarta Pusat 10110</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian 2: Layanan Dukungan yang Tersedia -->
                    <div class="support-section mb-5">
                        <div class="support-card" data-card-id="layanan-dukungan">
                            <div class="card-header d-flex justify-content-between align-items-start">
                                <div class="header-info">
                                    <div class="header-icon-wrapper green">
                                        <i class="bi bi-tools"></i>
                                    </div>
                                    <div class="header-details">
                                        <h3 class="card-title editable" data-field="title">Layanan Dukungan yang Tersedia</h3>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                                        <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item toggle-card" href="#"><i class="bi bi-eye-slash me-2"></i>Hide</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="services-list">
                                    <div class="service-item editable-service" data-service-id="installation">
                                        <div class="service-bullet"></div>
                                        <div class="service-content">
                                            <h6 class="service-title editable" data-field="title">Dukungan Instalasi</h6>
                                            <p class="service-description editable" data-field="description">Bantuan dalam instalasi dan konfigurasi perangkat lunak</p>
                                        </div>
                                    </div>
                                    
                                    <div class="service-item editable-service" data-service-id="troubleshooting">
                                        <div class="service-bullet"></div>
                                        <div class="service-content">
                                            <h6 class="service-title editable" data-field="title">Pemecahan Masalah Teknis</h6>
                                            <p class="service-description editable" data-field="description">Diagnosa dan penyelesaian masalah teknis</p>
                                        </div>
                                    </div>
                                    
                                    <div class="service-item editable-service" data-service-id="training">
                                        <div class="service-bullet"></div>
                                        <div class="service-content">
                                            <h6 class="service-title editable" data-field="title">Pelatihan Pengguna</h6>
                                            <p class="service-description editable" data-field="description">Sesi pelatihan untuk administrator sistem</p>
                                        </div>
                                    </div>
                                    
                                    <div class="service-item editable-service" data-service-id="remote">
                                        <div class="service-bullet"></div>
                                        <div class="service-content">
                                            <h6 class="service-title editable" data-field="title">Bantuan Jarak Jauh</h6>
                                            <p class="service-description editable" data-field="description">Dukungan teknis jarak jauh melalui remote desktop</p>
                                        </div>
                                    </div>
                                    
                                    <div class="service-item editable-service" data-service-id="documentation">
                                        <div class="service-bullet"></div>
                                        <div class="service-content">
                                            <h6 class="service-title editable" data-field="title">Dokumentasi & Panduan</h6>
                                            <p class="service-description editable" data-field="description">Dokumen dan buku panduan pengguna</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian 3: Cara Meminta Bantuan Teknis -->
                    <div class="support-section">
                        <div class="support-card request-card" data-card-id="cara-meminta-bantuan">
                            <div class="card-header blue-header d-flex justify-content-between align-items-start">
                                <div class="header-info">
                                    <div class="header-icon-wrapper blue">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                    <div class="header-details">
                                        <h3 class="card-title editable" data-field="title">Cara Meminta Bantuan Teknis</h3>
                                        <p class="card-subtitle editable" data-field="subtitle">Ikuti langkah-langkah berikut untuk mendapatkan dukungan teknis yang Anda butuhkan</p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                                        <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item toggle-card" href="#"><i class="bi bi-eye-slash me-2"></i>Hide</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="request-grid">
                                    <!-- Card 1: Dukungan Langsung -->
                                    <div class="request-card editable-request" data-request-id="direct">
                                        <div class="request-header">
                                            <div class="request-icon red">
                                                <i class="bi bi-telephone-fill"></i>
                                            </div>
                                            <h5 class="request-title editable" data-field="title">Untuk Dukungan Langsung</h5>
                                        </div>
                                        <div class="request-steps">
                                            <div class="step-item editable-step" data-step-id="direct-1">
                                                <div class="step-number">1</div>
                                                <p class="step-text editable" data-field="text">Hubungi nomor telepon (021) 3103554 pada jam kerja</p>
                                            </div>
                                            <div class="step-item editable-step" data-step-id="direct-2">
                                                <div class="step-number">2</div>
                                                <p class="step-text editable" data-field="text">Jelaskan masalah yang Anda hadapi dengan detail</p>
                                            </div>
                                            <div class="step-item editable-step" data-step-id="direct-3">
                                                <div class="step-number">3</div>
                                                <p class="step-text editable" data-field="text">Siapkan informasi sistem dan versi INLISLite yang digunakan</p>
                                            </div>
                                            <div class="step-item editable-step" data-step-id="direct-4">
                                                <div class="step-number">4</div>
                                                <p class="step-text editable" data-field="text">Tim teknis akan memberikan solusi atau jadwal kunjungan</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card 2: Dukungan Email -->
                                    <div class="request-card editable-request" data-request-id="email">
                                        <div class="request-header">
                                            <div class="request-icon red">
                                                <i class="bi bi-envelope-fill"></i>
                                            </div>
                                            <h5 class="request-title editable" data-field="title">Untuk Dukungan Email</h5>
                                        </div>
                                        <div class="request-steps">
                                            <div class="step-item editable-step" data-step-id="email-1">
                                                <div class="step-number">1</div>
                                                <p class="step-text editable" data-field="text">Kirim email ke info@perpusnas.go.id</p>
                                            </div>
                                            <div class="step-item editable-step" data-step-id="email-2">
                                                <div class="step-number">2</div>
                                                <p class="step-text editable" data-field="text">Sertakan detail lembaga dan kontak</p>
                                            </div>
                                            <div class="step-item editable-step" data-step-id="email-3">
                                                <div class="step-number">3</div>
                                                <p class="step-text editable" data-field="text">Jelaskan jenis bantuan yang dibutuhkan</p>
                                            </div>
                                            <div class="step-item editable-step" data-step-id="email-4">
                                                <div class="step-number">4</div>
                                                <p class="step-text editable" data-field="text">Tunggu respon 1–2 hari kerja</p>
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

    <!-- Add Card Modal -->
    <div class="modal fade" id="addCardModal" tabindex="-1" aria-labelledby="addCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCardModalLabel">Add New Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCardForm">
                        <div class="mb-3">
                            <label for="cardType" class="form-label">Card Type</label>
                            <select class="form-select" id="cardType" required>
                                <option value="">Select card type...</option>
                                <option value="contact">Contact Information</option>
                                <option value="service">Service Item</option>
                                <option value="support">Support Section</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="cardTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="cardTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="cardSubtitle" class="form-label">Subtitle (optional)</label>
                            <input type="text" class="form-control" id="cardSubtitle">
                        </div>
                        <div class="mb-3">
                            <label for="cardContent" class="form-label">Content</label>
                            <textarea class="form-control" id="cardContent" rows="4" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveNewCard">Add Card</button>
                </div>
            </div>
        </div>
    </div>

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