<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Panduan - INLISLite v3' ?></title>
    
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
    <link href="<?= base_url('assets/css/admin/panduan.css') ?>" rel="stylesheet">
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
                                    <i class="bi bi-book"></i>
                                </div>
                                <div class="nav-text">
                                    <h1 class="nav-title">Panduan</h1>
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
                                        <i class="bi bi-file-text"></i>
                                    </div>
                                    <h1 class="header-title">Panduan Penggunaan INLISLite Versi 3 PHP Opensource</h1>
                                    <p class="header-subtitle">Dokumentasi resmi dan panduan praktis untuk membantu Anda menggunakan semua fitur sistem manajemen perpustakaan INLISLite v3 secara efektif.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Action Row -->
                    <div class="search-action-section">
                        <div class="row align-items-center mb-4">
                            <div class="col-lg-8">
                                <div class="search-container">
                                    <i class="bi bi-search search-icon"></i>
                                    <input type="text" class="form-control search-input" id="searchDocs" placeholder="Cari dokumen...">
                                </div>
                            </div>
                            <div class="col-lg-4 text-lg-end">
                                <button class="btn btn-primary add-doc-btn" data-bs-toggle="modal" data-bs-target="#addDocModal">
                                    <i class="bi bi-plus-lg me-2"></i>
                                    Tambah Dokumen
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Documentation List Card -->
                    <div class="documentation-section">
                        <div class="card documentation-card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-download me-3 header-icon-small"></i>
                                    <div>
                                        <h5 class="card-title mb-1">Dokumentasi Tersedia (<span id="docCount">6</span>)</h5>
                                        <p class="card-subtitle mb-0">Protokol Inisiatif Arsip Terbuka untuk Pengambilan Metadata.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="documentation-list" id="documentationList">
                                    <!-- Documentation Item 1 -->
                                    <div class="doc-item" data-title="panduan instalasi" data-description="langkah-langkah instalasi inlislite">
                                        <div class="doc-number">
                                            <span>1</span>
                                        </div>
                                        <div class="doc-content">
                                            <h6 class="doc-title">Panduan Instalasi INLISLite v3</h6>
                                            <p class="doc-description">Langkah-langkah lengkap instalasi sistem INLISLite v3 pada server PHP dengan konfigurasi database MySQL.</p>
                                            <div class="doc-badges">
                                                <span class="badge badge-pdf">PDF</span>
                                                <span class="badge badge-size">2.5 MB</span>
                                                <span class="badge badge-version">v3.0</span>
                                            </div>
                                        </div>
                                        <div class="doc-actions">
                                            <button class="btn btn-outline-secondary btn-sm download-btn" title="Unduh">
                                                <i class="bi bi-download me-1"></i>
                                                Unduh
                                            </button>
                                            <button class="btn btn-link btn-sm edit-btn" title="Edit" data-doc-id="1">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-link btn-sm text-danger delete-btn" title="Hapus" data-doc-id="1">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Documentation Item 2 -->
                                    <div class="doc-item" data-title="konfigurasi sistem" data-description="pengaturan konfigurasi dasar">
                                        <div class="doc-number">
                                            <span>2</span>
                                        </div>
                                        <div class="doc-content">
                                            <h6 class="doc-title">Konfigurasi Sistem dan Database</h6>
                                            <p class="doc-description">Panduan konfigurasi sistem, pengaturan database, dan optimasi performa untuk instalasi INLISLite v3.</p>
                                            <div class="doc-badges">
                                                <span class="badge badge-pdf">PDF</span>
                                                <span class="badge badge-size">1.8 MB</span>
                                                <span class="badge badge-version">v3.0</span>
                                            </div>
                                        </div>
                                        <div class="doc-actions">
                                            <button class="btn btn-outline-secondary btn-sm download-btn" title="Unduh">
                                                <i class="bi bi-download me-1"></i>
                                                Unduh
                                            </button>
                                            <button class="btn btn-link btn-sm edit-btn" title="Edit" data-doc-id="2">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-link btn-sm text-danger delete-btn" title="Hapus" data-doc-id="2">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Documentation Item 3 -->
                                    <div class="doc-item" data-title="manajemen pengguna" data-description="panduan pengelolaan user dan hak akses">
                                        <div class="doc-number">
                                            <span>3</span>
                                        </div>
                                        <div class="doc-content">
                                            <h6 class="doc-title">Manajemen Pengguna dan Hak Akses</h6>
                                            <p class="doc-description">Cara mengelola pengguna sistem, mengatur role dan permission, serta konfigurasi keamanan akses.</p>
                                            <div class="doc-badges">
                                                <span class="badge badge-pdf">PDF</span>
                                                <span class="badge badge-size">3.2 MB</span>
                                                <span class="badge badge-version">v3.0</span>
                                            </div>
                                        </div>
                                        <div class="doc-actions">
                                            <button class="btn btn-outline-secondary btn-sm download-btn" title="Unduh">
                                                <i class="bi bi-download me-1"></i>
                                                Unduh
                                            </button>
                                            <button class="btn btn-link btn-sm edit-btn" title="Edit" data-doc-id="3">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-link btn-sm text-danger delete-btn" title="Hapus" data-doc-id="3">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Documentation Item 4 -->
                                    <div class="doc-item" data-title="katalogisasi" data-description="panduan katalogisasi bahan pustaka">
                                        <div class="doc-number">
                                            <span>4</span>
                                        </div>
                                        <div class="doc-content">
                                            <h6 class="doc-title">Katalogisasi dan Metadata</h6>
                                            <p class="doc-description">Panduan lengkap katalogisasi bahan pustaka, input metadata, dan standar MARC21 dalam INLISLite v3.</p>
                                            <div class="doc-badges">
                                                <span class="badge badge-pdf">PDF</span>
                                                <span class="badge badge-size">4.1 MB</span>
                                                <span class="badge badge-version">v3.0</span>
                                            </div>
                                        </div>
                                        <div class="doc-actions">
                                            <button class="btn btn-outline-secondary btn-sm download-btn" title="Unduh">
                                                <i class="bi bi-download me-1"></i>
                                                Unduh
                                            </button>
                                            <button class="btn btn-link btn-sm edit-btn" title="Edit" data-doc-id="4">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-link btn-sm text-danger delete-btn" title="Hapus" data-doc-id="4">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Documentation Item 5 -->
                                    <div class="doc-item" data-title="sirkulasi" data-description="panduan sirkulasi peminjaman pengembalian">
                                        <div class="doc-number">
                                            <span>5</span>
                                        </div>
                                        <div class="doc-content">
                                            <h6 class="doc-title">Sirkulasi dan Peminjaman</h6>
                                            <p class="doc-description">Panduan operasional sirkulasi, peminjaman, pengembalian, dan manajemen denda dalam sistem.</p>
                                            <div class="doc-badges">
                                                <span class="badge badge-pdf">PDF</span>
                                                <span class="badge badge-size">2.9 MB</span>
                                                <span class="badge badge-version">v3.0</span>
                                            </div>
                                        </div>
                                        <div class="doc-actions">
                                            <button class="btn btn-outline-secondary btn-sm download-btn" title="Unduh">
                                                <i class="bi bi-download me-1"></i>
                                                Unduh
                                            </button>
                                            <button class="btn btn-link btn-sm edit-btn" title="Edit" data-doc-id="5">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-link btn-sm text-danger delete-btn" title="Hapus" data-doc-id="5">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Documentation Item 6 -->
                                    <div class="doc-item" data-title="laporan" data-description="panduan pembuatan laporan dan statistik">
                                        <div class="doc-number">
                                            <span>6</span>
                                        </div>
                                        <div class="doc-content">
                                            <h6 class="doc-title">Laporan dan Statistik</h6>
                                            <p class="doc-description">Cara membuat laporan, analisis statistik, dan export data dalam berbagai format untuk keperluan administrasi.</p>
                                            <div class="doc-badges">
                                                <span class="badge badge-pdf">PDF</span>
                                                <span class="badge badge-size">3.7 MB</span>
                                                <span class="badge badge-version">v3.0</span>
                                            </div>
                                        </div>
                                        <div class="doc-actions">
                                            <button class="btn btn-outline-secondary btn-sm download-btn" title="Unduh">
                                                <i class="bi bi-download me-1"></i>
                                                Unduh
                                            </button>
                                            <button class="btn btn-link btn-sm edit-btn" title="Edit" data-doc-id="6">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-link btn-sm text-danger delete-btn" title="Hapus" data-doc-id="6">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Resources Section -->
                    <div class="additional-resources-section">
                        <div class="card resources-card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="bi bi-link-45deg me-2"></i>
                                    Sumber Daya Tambahan
                                </h5>
                                <ul class="resources-list">
                                    <li>
                                        <i class="bi bi-gear me-2"></i>
                                        <span>Petunjuk instalasi lengkap tersedia di </span>
                                        <a href="<?= base_url('admin/aplikasi') ?>" class="resource-link">Aplikasi Pendukung > Platform PHP</a>
                                    </li>
                                    <li>
                                        <i class="bi bi-arrow-up-circle me-2"></i>
                                        <span>Panduan update sistem dapat ditemukan di </span>
                                        <a href="<?= base_url('admin/patch') ?>" class="resource-link">Patch & Updater > Platform PHP</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    <!-- Add Document Modal -->
    <div class="modal fade" id="addDocModal" tabindex="-1" aria-labelledby="addDocModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDocModalLabel">
                        <i class="bi bi-plus-circle me-2"></i>
                        Tambah Dokumen Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDocForm">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="docTitle" class="form-label fw-semibold">Judul Dokumen</label>
                                <input type="text" class="form-control" id="docTitle" name="title" placeholder="Masukkan judul dokumen" required>
                            </div>
                            <div class="col-12">
                                <label for="docDescription" class="form-label fw-semibold">Deskripsi</label>
                                <textarea class="form-control" id="docDescription" name="description" rows="3" placeholder="Masukkan deskripsi dokumen" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="docFile" class="form-label fw-semibold">File Dokumen</label>
                                <input type="file" class="form-control" id="docFile" name="file" accept=".pdf,.doc,.docx" required>
                                <div class="form-text">Format yang didukung: PDF, DOC, DOCX (Max: 10MB)</div>
                            </div>
                            <div class="col-md-6">
                                <label for="docVersion" class="form-label fw-semibold">Versi</label>
                                <input type="text" class="form-control" id="docVersion" name="version" placeholder="v3.0" value="v3.0">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="addDocForm" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>
                        Tambah Dokumen
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Document Modal -->
    <div class="modal fade" id="editDocModal" tabindex="-1" aria-labelledby="editDocModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDocModalLabel">
                        <i class="bi bi-pencil me-2"></i>
                        Edit Dokumen
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDocForm">
                        <input type="hidden" id="editDocId" name="doc_id">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="editDocTitle" class="form-label fw-semibold">Judul Dokumen</label>
                                <input type="text" class="form-control" id="editDocTitle" name="title" required>
                            </div>
                            <div class="col-12">
                                <label for="editDocDescription" class="form-label fw-semibold">Deskripsi</label>
                                <textarea class="form-control" id="editDocDescription" name="description" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="editDocFile" class="form-label fw-semibold">File Dokumen (Opsional)</label>
                                <input type="file" class="form-control" id="editDocFile" name="file" accept=".pdf,.doc,.docx">
                                <div class="form-text">Kosongkan jika tidak ingin mengubah file</div>
                            </div>
                            <div class="col-md-6">
                                <label for="editDocVersion" class="form-label fw-semibold">Versi</label>
                                <input type="text" class="form-control" id="editDocVersion" name="version">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="editDocForm" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url('assets/js/admin/panduan.js') ?>"></script>
    
    <style>
        /* Logout button styling - matching tentang page */
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