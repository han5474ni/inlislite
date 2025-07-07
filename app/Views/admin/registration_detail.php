<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Detail Registrasi - INLISlite v3.0' ?></title>
    
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
    <link href="<?= base_url('assets/css/admin/registration.css') ?>" rel="stylesheet">
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
                <a href="<?= base_url('registration') ?>" class="nav-link active">
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
        <!-- Top App Bar -->
        <div class="top-app-bar">
            <div class="container-fluid">
                <div class="app-bar-content">
                    <div class="app-bar-left">
                        <a href="<?= base_url('registration') ?>" class="back-arrow-btn" title="Kembali ke Registrasi">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div class="app-bar-logo">
                            <div class="logo-icon">
                                <i class="bi bi-book-half"></i>
                            </div>
                            <div class="logo-text">
                                <h1 class="app-title">Registrasi Inlislite</h1>
                                <p class="app-subtitle">Kelola pengguna sistem dan hak aksesnya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            <div class="container-fluid">
                <!-- Main Section Card -->
                <div class="main-section-card">
                    <div class="main-card-header">
                        <div class="library-icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="library-info">
                            <h2 class="library-name">Perpustakaan Medan</h2>
                            <p class="library-location">Sumatera Utara</p>
                            <div class="library-labels">
                                <span class="label-chip library-type">Perpustakaan Publik</span>
                                <span class="label-chip library-status">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Information Cards Grid -->
                <div class="info-cards-grid">
                    <!-- Information Section -->
                    <div class="info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-info-circle me-2"></i>
                                Informasi Perpustakaan
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="info-field">
                                <label class="field-label">Nama Perpustakaan</label>
                                <div class="field-value editable-field">
                                    <input type="text" class="form-control" value="Perpustakaan Medan" readonly>
                                    <button class="edit-field-btn" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="info-labels">
                                <div class="label-group">
                                    <span class="label-title">Type:</span>
                                    <span class="status-badge type-public">Public</span>
                                </div>
                                <div class="label-group">
                                    <span class="label-title">Status:</span>
                                    <span class="status-badge status-active">Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location & Timeline Section -->
                    <div class="info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-geo-alt me-2"></i>
                                Lokasi dan Linimasa
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="timeline-item">
                                <div class="timeline-icon location">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Lokasi</h6>
                                    <p>Medan, Sumatera Utara</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon registration">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Teregistrasi</h6>
                                    <p>28 Desember 2023</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon update">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Terakhir update</h6>
                                    <p>30 Januari 2024</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Section -->
                    <div class="info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-person-lines-fill me-2"></i>
                                Informasi Kontak
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                                <div class="contact-info">
                                    <h6>Nama</h6>
                                    <p>Dr. Ahmad Rahman</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                                <div class="contact-info">
                                    <h6>Email</h6>
                                    <p>ahmad@perpustakaanmedan.go.id</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div class="contact-info">
                                    <h6>Telepon</h6>
                                    <p>+62-21-3928484</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="btn btn-outline-secondary" onclick="history.back()">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali
                    </button>
                    <button class="btn btn-primary" id="editRegistrationBtn">
                        <i class="bi bi-pencil me-2"></i>
                        Edit Registrasi
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url('assets/js/admin/registration.js') ?>"></script>
    
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