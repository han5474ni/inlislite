<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Kelola Kartu Installer - INLISlite v3.0' ?></title>
    
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
    <link href="<?= base_url('assets/css/admin/installer-edit.css') ?>" rel="stylesheet">
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
                        <a href="<?= base_url('admin/installer') ?>" class="back-btn" title="Kembali ke Installer">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div class="logo-section">
                            <div class="logo-icon">
                                <i class="bi bi-gear-fill"></i>
                            </div>
                            <div class="nav-text">
                                <h1 class="nav-title">Kelola Kartu Installer</h1>
                                <p class="nav-subtitle">Tambah, edit, dan hapus kartu installer yang tampil di halaman utama</p>
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
                                    <i class="bi bi-gear-fill"></i>
                                </div>
                                <h1 class="header-title">Kelola Kartu Installer</h1>
                                <p class="header-subtitle">Kelola semua kartu installer yang ditampilkan di halaman utama. Tambah, edit, atau hapus kartu sesuai kebutuhan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- Action Section -->
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-10">
                        <div class="action-section">
                            <button class="btn btn-add-card" id="btnAddCard">
                                <i class="bi bi-plus-circle me-2"></i>
                                Tambah Card Installer
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cards List Section -->
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="cards-management-section card">
                            <div class="card-header">
                                <div class="management-header">
                                    <div class="management-icon">
                                        <i class="bi bi-collection"></i>
                                    </div>
                                    <div class="management-title-section">
                                        <h5 class="management-title">Daftar Kartu Installer</h5>
                                        <p class="management-subtitle">Kelola semua kartu installer yang tersedia</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Loading State -->
                                <div id="loadingState" class="text-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-3 text-muted">Memuat data kartu installer...</p>
                                </div>

                                <!-- Cards Table -->
                                <div id="cardsTable" class="table-responsive" style="display: none;">
                                    <table class="table cards-table">
                                        <thead>
                                            <tr>
                                                <th>Kartu</th>
                                                <th>Versi</th>
                                                <th>Ukuran</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cardsTableBody">
                                            <!-- Dynamic content will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Empty State -->
                                <div id="emptyState" class="text-center py-5" style="display: none;">
                                    <div class="empty-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h5 class="empty-title">Belum Ada Kartu Installer</h5>
                                    <p class="empty-description">Mulai dengan menambahkan kartu installer pertama Anda.</p>
                                    <button class="btn btn-primary btn-add-first" id="btnAddFirstCard">
                                        <i class="bi bi-plus-circle me-2"></i>
                                        Tambah Kartu Pertama
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add/Edit Card Modal -->
    <div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cardModalLabel">Tambah Card Installer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cardForm">
                        <input type="hidden" id="cardId" name="id">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="packageName" class="form-label">Nama Paket <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="packageName" name="package_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="version" class="form-label">Versi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="version" name="version" required>
                            </div>
                            <div class="col-md-6">
                                <label for="releaseDate" class="form-label">Tanggal Rilis / Revisi</label>
                                <input type="date" class="form-control" id="releaseDate" name="release_date">
                            </div>
                            <div class="col-md-6">
                                <label for="fileSize" class="form-label">Ukuran File</label>
                                <input type="text" class="form-control" id="fileSize" name="file_size" placeholder="e.g., 25 MB">
                            </div>
                            <div class="col-12">
                                <label for="downloadLink" class="form-label">Link Download</label>
                                <input type="url" class="form-control" id="downloadLink" name="download_link" placeholder="https://...">
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Deskripsi Singkat</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Informasi Persyaratan</label>
                                <div class="requirements-section">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="reqPhp" name="requirements[]" value="php">
                                        <label class="form-check-label" for="reqPhp">Seluruh file aplikasi PHP</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="reqDocs" name="requirements[]" value="docs">
                                        <label class="form-check-label" for="reqDocs">Dokumentasi dan panduan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="reqConfig" name="requirements[]" value="config">
                                        <label class="form-check-label" for="reqConfig">Template konfigurasi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="reqDatabase" name="requirements[]" value="database">
                                        <label class="form-check-label" for="reqDatabase">Struktur database</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="defaultUsername" class="form-label">Username Default (opsional)</label>
                                <input type="text" class="form-control" id="defaultUsername" name="default_username">
                            </div>
                            <div class="col-md-6">
                                <label for="defaultPassword" class="form-label">Password Default (opsional)</label>
                                <input type="text" class="form-control" id="defaultPassword" name="default_password">
                            </div>
                            <div class="col-md-6">
                                <label for="cardType" class="form-label">Tipe Kartu</label>
                                <select class="form-select" id="cardType" name="card_type">
                                    <option value="source">Source Code</option>
                                    <option value="installer">Installer</option>
                                    <option value="database">Database</option>
                                    <option value="documentation">Dokumentasi</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveCardBtn">
                        <i class="bi bi-check-circle me-2"></i>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="delete-icon">
                            <i class="bi bi-exclamation-triangle text-warning"></i>
                        </div>
                        <h6 class="mt-3">Apakah Anda yakin ingin menghapus kartu ini?</h6>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="bi bi-trash me-2"></i>
                        Hapus
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
    <script src="<?= base_url('assets/js/admin/installer-edit.js') ?>"></script>
    
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