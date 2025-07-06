<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Demo Program - INLISlite v3.0' ?></title>
    
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
    <link href="<?= base_url('assets/css/admin/demo.css') ?>" rel="stylesheet">
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
                                    <i class="bi bi-play-circle"></i>
                                </div>
                                <div class="nav-text">
                                    <h1 class="nav-title">Demo Program</h1>
                                    <p class="nav-subtitle">Paket unduhan dan instalasi</p>
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
                                        <i class="bi bi-play-circle"></i>
                                    </div>
                                    <h1 class="header-title">Demo Program Inlislite Versi 3</h1>
                                    <p class="header-subtitle">Untuk menjelajahi modul dan fitur langsung yang tersedia dalam sistem manajemen perpustakaan INLISLite, Anda dapat mengakses platform demonstrasi online kami di bawah ini.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- Tabs Section -->
                <div class="tabs-section mb-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <ul class="nav nav-pills demo-tabs" id="demoTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="demo-program-tab" data-bs-toggle="pill" data-bs-target="#demo-program" type="button" role="tab" aria-controls="demo-program" aria-selected="true">
                                        <i class="bi bi-play-circle me-2"></i>
                                        Demo Program
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="atur-demo-tab" data-bs-toggle="pill" data-bs-target="#atur-demo" type="button" role="tab" aria-controls="atur-demo" aria-selected="false">
                                        <i class="bi bi-gear me-2"></i>
                                        Atur Demo
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="demoTabsContent">
                    <!-- Demo Program Tab -->
                    <div class="tab-pane fade show active" id="demo-program" role="tabpanel" aria-labelledby="demo-program-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="demo-cards-grid">
                                    <?php foreach ($demos as $demo): ?>
                                    <div class="demo-card card h-100">
                                        <div class="card-header">
                                            <div class="demo-card-icon">
                                                <i class="bi bi-laptop"></i>
                                            </div>
                                            <div class="demo-card-title-section">
                                                <h4 class="demo-card-title"><?= esc($demo['title']) ?></h4>
                                                <div class="demo-card-badges">
                                                    <span class="badge bg-primary"><?= esc($demo['platform']) ?></span>
                                                    <span class="badge bg-secondary"><?= esc($demo['version']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="demo-card-description"><?= esc($demo['description']) ?></p>
                                            
                                            <!-- Features List -->
                                            <div class="demo-features mb-3">
                                                <h6 class="features-title">Fitur Utama:</h6>
                                                <ul class="features-list">
                                                    <?php foreach ($demo['features'] as $feature): ?>
                                                    <li><i class="bi bi-check-circle text-success me-2"></i><?= esc($feature) ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>

                                            <!-- Login Information -->
                                            <div class="login-info-box">
                                                <h6 class="login-info-title">
                                                    <i class="bi bi-key me-2"></i>
                                                    Informasi Login
                                                </h6>
                                                <div class="login-credentials">
                                                    <div class="credential-item">
                                                        <label class="credential-label">Username:</label>
                                                        <div class="credential-value">
                                                            <code class="credential-code"><?= esc($demo['username']) ?></code>
                                                            <button class="btn btn-sm btn-outline-secondary copy-btn" data-copy="<?= esc($demo['username']) ?>" title="Copy Username">
                                                                <i class="bi bi-copy"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="credential-item">
                                                        <label class="credential-label">Password:</label>
                                                        <div class="credential-value">
                                                            <code class="credential-code"><?= esc($demo['password']) ?></code>
                                                            <button class="btn btn-sm btn-outline-secondary copy-btn" data-copy="<?= esc($demo['password']) ?>" title="Copy Password">
                                                                <i class="bi bi-copy"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-primary btn-demo w-100" data-url="<?= esc($demo['url']) ?>">
                                                <i class="bi bi-play-circle me-2"></i>
                                                Demo Program
                                            </button>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Atur Demo Tab -->
                    <div class="tab-pane fade" id="atur-demo" role="tabpanel" aria-labelledby="atur-demo-tab">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="demo-settings-card card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-gear me-2"></i>
                                            Pengaturan Demo
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Halaman ini akan mengarahkan ke pengaturan demo sistem. Fitur ini sedang dalam pengembangan.
                                        </div>
                                        
                                        <div class="demo-settings-options">
                                            <div class="setting-item">
                                                <div class="setting-icon">
                                                    <i class="bi bi-database"></i>
                                                </div>
                                                <div class="setting-content">
                                                    <h6 class="setting-title">Reset Data Demo</h6>
                                                    <p class="setting-description">Mengembalikan data demo ke kondisi awal</p>
                                                </div>
                                                <div class="setting-action">
                                                    <button class="btn btn-outline-warning" disabled>
                                                        <i class="bi bi-arrow-clockwise me-2"></i>
                                                        Reset
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="setting-item">
                                                <div class="setting-icon">
                                                    <i class="bi bi-clock"></i>
                                                </div>
                                                <div class="setting-content">
                                                    <h6 class="setting-title">Jadwal Maintenance</h6>
                                                    <p class="setting-description">Atur jadwal pemeliharaan sistem demo</p>
                                                </div>
                                                <div class="setting-action">
                                                    <button class="btn btn-outline-primary" disabled>
                                                        <i class="bi bi-calendar me-2"></i>
                                                        Atur
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="setting-item">
                                                <div class="setting-icon">
                                                    <i class="bi bi-shield-check"></i>
                                                </div>
                                                <div class="setting-content">
                                                    <h6 class="setting-title">Keamanan Demo</h6>
                                                    <p class="setting-description">Pengaturan keamanan dan akses demo</p>
                                                </div>
                                                <div class="setting-action">
                                                    <button class="btn btn-outline-success" disabled>
                                                        <i class="bi bi-gear me-2"></i>
                                                        Kelola
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
    <script src="<?= base_url('assets/js/admin/demo.js') ?>"></script>
    
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