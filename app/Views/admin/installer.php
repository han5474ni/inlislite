<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installer INLISLite - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/installer.css') ?>" rel="stylesheet">
    
    <style>
    body {
        background: linear-gradient(135deg, #1C6EC4 0%, #2DA84D 100%);
        min-height: 100vh;
    }
    </style>
</head>
<body>
    <!-- Include Enhanced Sidebar -->
    <?= $this->include('admin/partials/sidebar') ?>
    
    <!-- Main Content -->
    <main class="enhanced-main-content">
        <div class="dashboard-container">
            <div class="header-card">
                <div class="content-header">
                    <h1 class="main-title">Installer INLISLite</h1>
                    <p class="main-subtitle">Paket unduhan dan instalasi sistem perpustakaan</p>
                </div>
            </div>
            

        <div class="container">
            <!-- Page Banner Card -->
            <div class="banner-card mb-5">
                <div class="banner-icon">
                    <i class="bi bi-download"></i>
                </div>
                <div class="banner-content">
                    <h2 class="banner-title">Installer INLISLite</h2>
                    <h3 class="banner-subtitle">Versi 3.2 - Revisi 10 Februari 2021</h3>
                    <p class="banner-description">
                        Paket instalasi lengkap sistem manajemen perpustakaan digital terpadu untuk kebutuhan 
                        perpustakaan modern dengan teknologi terdepan.
                    </p>
                </div>
            </div>

            <!-- Search and Action Section -->
            <div class="search-action-section mb-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="search-box">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari paket installer...">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <a href="<?= base_url('admin/installer-edit') ?>" class="btn btn-success me-2">
                            <i class="bi bi-gear me-2"></i>Kelola Data
                        </a>
                        <button class="btn btn-info" onclick="refreshContent()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <section class="content-section">
                <div class="section-header mb-4">
                    <h2 class="section-title">Paket Installer</h2>
                    <p class="section-subtitle">
                        Unduh paket installer lengkap untuk instalasi baru INLISLite v3 dan komponen tambahan
                    </p>
                </div>
                
                <div class="row g-4" id="contentContainer">
                    <!-- Package cards using content-card class like tentang -->
                    <div class="col-lg-6 col-md-6">
                        <div class="content-card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div class="card-actions">
                                    <button class="btn-action edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn-action delete" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">INLISLite v3.0 Full Package</h3>
                                <p class="card-subtitle">Complete Installation Package • 25 MB • v3.0.0</p>
                                <p class="card-description">
                                    Paket lengkap instalasi INLISLite v3.0 dengan semua fitur dan dokumentasi lengkap untuk instalasi baru sistem perpustakaan.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6">
                        <div class="content-card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="bi bi-code-slash"></i>
                                </div>
                                <div class="card-actions">
                                    <button class="btn-action edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn-action delete" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">INLISLite v3.0 Source Code</h3>
                                <p class="card-subtitle">Source Code Only • 15 MB • v3.0.0</p>
                                <p class="card-description">
                                    Source code INLISLite v3.0 untuk developer dan customization tanpa installer. Cocok untuk pengembangan dan modifikasi sistem.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="content-card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="bi bi-database"></i>
                                </div>
                                <div class="card-actions">
                                    <button class="btn-action edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn-action delete" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">Database Structure</h3>
                                <p class="card-subtitle">Database Schema • 5 MB • v3.0.0</p>
                                <p class="card-description">
                                    Struktur database dan data sample untuk INLISLite v3.0 dengan skema terbaru.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="content-card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="bi bi-book"></i>
                                </div>
                                <div class="card-actions">
                                    <button class="btn-action edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn-action delete" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">Documentation Package</h3>
                                <p class="card-subtitle">User Manual • 8 MB • v3.0.0</p>
                                <p class="card-description">
                                    Dokumentasi lengkap penggunaan dan instalasi INLISLite v3.0 dalam format PDF.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="content-card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="bi bi-search"></i>
                                </div>
                                <div class="card-actions">
                                    <button class="btn-action edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn-action delete" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">OPAC Add-on</h3>
                                <p class="card-subtitle">Enhanced OPAC • 3 MB • v1.2.0</p>
                                <p class="card-description">
                                    Modul OPAC tambahan dengan fitur pencarian advanced dan interface yang lebih modern.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        </div>
    </main>

    <!-- Add Package Modal -->
    <div class="modal fade" id="addPackageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Paket Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addPackageForm">
                        <div class="mb-3">
                            <label for="packageTitle" class="form-label">Nama Paket</label>
                            <input type="text" class="form-control" id="packageTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="packageSubtitle" class="form-label">Subtitle</label>
                            <input type="text" class="form-control" id="packageSubtitle">
                        </div>
                        <div class="mb-3">
                            <label for="packageDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="packageDescription" rows="5" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="savePackage()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Paket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId">
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Nama Paket</label>
                            <input type="text" class="form-control" id="editTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSubtitle" class="form-label">Subtitle</label>
                            <input type="text" class="form-control" id="editSubtitle">
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDescription" rows="5" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="updatePackage()">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/admin/installer.js') ?>"></script>
</body>
</html>