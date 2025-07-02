<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'About INLISLite Version 3 - INLISlite v3.0' ?></title>
    
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
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/tentang.css') ?>" rel="stylesheet">
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
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-container">
            <!-- Page Header -->
            <div class="page-header">
                <div class="header-top">
                    <div class="header-left">
                        <div class="header-icon">
                            <i class="bi bi-book"></i>
                        </div>
                        <div>
                            <h1 class="page-title">About INLISLite Version 3</h1>
                            <p class="page-subtitle">Detailed information about the library automation system</p>
                        </div>
                    </div>
                    <a href="<?= base_url('admin/dashboard') ?>" class="back-btn">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            <div id="alertContainer"></div>

            <!-- About Content Cards -->
            <div class="about-content" id="aboutContent">
                <!-- Card 1: INLISLite Version 3 -->
                <div class="about-card card" data-card-id="1">
                    <div class="card-header d-flex justify-content-between align-items-start">
                        <div class="card-title-section">
                            <h3 class="card-title mb-1">INLISLite Version 3</h3>
                            <p class="card-subtitle text-muted mb-0">Library Automation System Overview</p>
                        </div>
                        <div class="dropdown">
                            <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                                <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <p>INLISLite Version 3 adalah sistem otomasi perpustakaan yang dikembangkan oleh Perpustakaan Nasional Republik Indonesia. Sistem ini dirancang untuk membantu perpustakaan dalam mengelola koleksi, anggota, dan layanan perpustakaan secara digital dan terintegrasi.</p>
                            <p>Dengan teknologi terkini dan antarmuka yang user-friendly, INLISLite v3 memberikan solusi komprehensif untuk kebutuhan manajemen perpustakaan modern.</p>
                        </div>
                        <div class="card-edit-form d-none">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Title</label>
                                <input type="text" class="form-control edit-title" value="INLISLite Version 3">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Subtitle</label>
                                <input type="text" class="form-control edit-subtitle" value="Library Automation System Overview">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Content</label>
                                <textarea class="form-control edit-content" rows="6">INLISLite Version 3 adalah sistem otomasi perpustakaan yang dikembangkan oleh Perpustakaan Nasional Republik Indonesia. Sistem ini dirancang untuk membantu perpustakaan dalam mengelola koleksi, anggota, dan layanan perpustakaan secara digital dan terintegrasi.

Dengan teknologi terkini dan antarmuka yang user-friendly, INLISLite v3 memberikan solusi komprehensif untuk kebutuhan manajemen perpustakaan modern.</textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary save-card">
                                    <i class="bi bi-check-lg me-2"></i>Save
                                </button>
                                <button class="btn btn-secondary cancel-edit">
                                    <i class="bi bi-x-lg me-2"></i>Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Legal Framework -->
                <div class="about-card card" data-card-id="2">
                    <div class="card-header d-flex justify-content-between align-items-start">
                        <div class="card-title-section">
                            <h3 class="card-title mb-1">Legal Framework</h3>
                            <p class="card-subtitle text-muted mb-0">Dasar Hukum dan Regulasi</p>
                        </div>
                        <div class="dropdown">
                            <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                                <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <ul>
                                <li>Undang-Undang Nomor 43 Tahun 2007 tentang Perpustakaan</li>
                                <li>Peraturan Pemerintah Nomor 24 Tahun 2014 tentang Pelaksanaan UU Perpustakaan</li>
                                <li>Peraturan Kepala Perpustakaan Nasional RI tentang Standar Nasional Perpustakaan</li>
                                <li>Kebijakan pengembangan sistem informasi perpustakaan nasional</li>
                            </ul>
                        </div>
                        <div class="card-edit-form d-none">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Title</label>
                                <input type="text" class="form-control edit-title" value="Legal Framework">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Subtitle</label>
                                <input type="text" class="form-control edit-subtitle" value="Dasar Hukum dan Regulasi">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Content</label>
                                <textarea class="form-control edit-content" rows="6">• Undang-Undang Nomor 43 Tahun 2007 tentang Perpustakaan
• Peraturan Pemerintah Nomor 24 Tahun 2014 tentang Pelaksanaan UU Perpustakaan
• Peraturan Kepala Perpustakaan Nasional RI tentang Standar Nasional Perpustakaan
• Kebijakan pengembangan sistem informasi perpustakaan nasional</textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary save-card">
                                    <i class="bi bi-check-lg me-2"></i>Save
                                </button>
                                <button class="btn btn-secondary cancel-edit">
                                    <i class="bi bi-x-lg me-2"></i>Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Key Features -->
                <div class="about-card card" data-card-id="3">
                    <div class="card-header d-flex justify-content-between align-items-start">
                        <div class="card-title-section">
                            <h3 class="card-title mb-1">Key Features</h3>
                            <p class="card-subtitle text-muted mb-0">Fitur Utama Sistem</p>
                        </div>
                        <div class="dropdown">
                            <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                                <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <ul>
                                <li><strong>Katalogisasi:</strong> Sistem katalog digital dengan standar internasional</li>
                                <li><strong>Sirkulasi:</strong> Manajemen peminjaman dan pengembalian otomatis</li>
                                <li><strong>Keanggotaan:</strong> Pengelolaan data anggota perpustakaan</li>
                                <li><strong>Inventarisasi:</strong> Tracking dan monitoring koleksi perpustakaan</li>
                                <li><strong>Laporan:</strong> Sistem pelaporan komprehensif dan real-time</li>
                                <li><strong>OPAC:</strong> Online Public Access Catalog untuk pencarian koleksi</li>
                            </ul>
                        </div>
                        <div class="card-edit-form d-none">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Title</label>
                                <input type="text" class="form-control edit-title" value="Key Features">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Subtitle</label>
                                <input type="text" class="form-control edit-subtitle" value="Fitur Utama Sistem">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Content</label>
                                <textarea class="form-control edit-content" rows="8">• Katalogisasi: Sistem katalog digital dengan standar internasional
• Sirkulasi: Manajemen peminjaman dan pengembalian otomatis
• Keanggotaan: Pengelolaan data anggota perpustakaan
• Inventarisasi: Tracking dan monitoring koleksi perpustakaan
• Laporan: Sistem pelaporan komprehensif dan real-time
• OPAC: Online Public Access Catalog untuk pencarian koleksi</textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary save-card">
                                    <i class="bi bi-check-lg me-2"></i>Save
                                </button>
                                <button class="btn btn-secondary cancel-edit">
                                    <i class="bi bi-x-lg me-2"></i>Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: System Requirements -->
                <div class="about-card card" data-card-id="4">
                    <div class="card-header d-flex justify-content-between align-items-start">
                        <div class="card-title-section">
                            <h3 class="card-title mb-1">System Requirements</h3>
                            <p class="card-subtitle text-muted mb-0">Kebutuhan Sistem Minimum</p>
                        </div>
                        <div class="dropdown">
                            <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                                <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <p><strong>Server Requirements:</strong></p>
                            <ul>
                                <li>Operating System: Linux/Windows Server</li>
                                <li>Web Server: Apache/Nginx</li>
                                <li>Database: MySQL/PostgreSQL</li>
                                <li>PHP Version: 8.0 atau lebih tinggi</li>
                                <li>Memory: Minimum 4GB RAM</li>
                                <li>Storage: Minimum 20GB free space</li>
                            </ul>
                            <p><strong>Client Requirements:</strong></p>
                            <ul>
                                <li>Web Browser: Chrome, Firefox, Safari, Edge (versi terbaru)</li>
                                <li>JavaScript: Enabled</li>
                                <li>Internet Connection: Stable broadband</li>
                            </ul>
                        </div>
                        <div class="card-edit-form d-none">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Title</label>
                                <input type="text" class="form-control edit-title" value="System Requirements">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Subtitle</label>
                                <input type="text" class="form-control edit-subtitle" value="Kebutuhan Sistem Minimum">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Content</label>
                                <textarea class="form-control edit-content" rows="10">Server Requirements:
• Operating System: Linux/Windows Server
• Web Server: Apache/Nginx
• Database: MySQL/PostgreSQL
• PHP Version: 8.0 atau lebih tinggi
• Memory: Minimum 4GB RAM
• Storage: Minimum 20GB free space

Client Requirements:
• Web Browser: Chrome, Firefox, Safari, Edge (versi terbaru)
• JavaScript: Enabled
• Internet Connection: Stable broadband</textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary save-card">
                                    <i class="bi bi-check-lg me-2"></i>Save
                                </button>
                                <button class="btn btn-secondary cancel-edit">
                                    <i class="bi bi-x-lg me-2"></i>Cancel
                                </button>
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
    <script src="<?= base_url('assets/js/admin/tentang.js') ?>"></script>
    
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