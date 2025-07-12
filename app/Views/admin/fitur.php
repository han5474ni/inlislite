<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitur dan Modul Program - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/fitur.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn-back me-3" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <div>
                        <h1 class="header-title mb-1">Fitur dan Modul Program</h1>
                        <p class="header-subtitle mb-0">Informasi lengkap tentang sistem otomasi perpustakaan</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/fitur-edit') ?>" class="btn btn-primary">
                            <i class="bi bi-gear me-2"></i>Manajemen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Page Banner Card -->
            <div class="banner-card mb-5">
                <div class="banner-icon">
                    <i class="bi bi-book"></i>
                </div>
                <div class="banner-content">
                    <h2 class="banner-title">Fitur dan Modul Program</h2>
                    <h3 class="banner-subtitle">Inlislite V3</h3>
                    <p class="banner-description">
                        Dokumentasi lengkap tentang fitur-fitur canggih dan modul program yang menjadikan INLISLite v3 
                        sebagai solusi manajemen perpustakaan yang komprehensif.
                    </p>
                </div>
            </div>

            <!-- Search and Action Section -->
            <div class="search-action-section mb-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="search-box">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari fitur atau modul...">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addFeatureModal">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Fitur
                        </button>
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addModuleModal">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Modul
                        </button>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <section class="features-section mb-5">
                <div class="section-header mb-4">
                    <h2 class="section-title">Fitur-fitur Inlislite V3</h2>
                    <p class="section-subtitle">
                        Fitur-fitur canggih yang memudahkan pengelolaan perpustakaan modern dengan teknologi terdepan
                    </p>
                </div>
                
                <div class="row g-4" id="featuresContainer">
                    <!-- Features will be loaded here -->
                </div>
            </section>

            <!-- Modules Section -->
            <section class="modules-section">
                <div class="section-header mb-4">
                    <h2 class="section-title">Modul Program Inlislite V3</h2>
                    <p class="section-subtitle">
                        Arsitektur modular yang memungkinkan integrasi dan kustomisasi sesuai kebutuhan perpustakaan
                    </p>
                </div>
                
                <div class="row g-4" id="modulesContainer">
                    <!-- Modules will be loaded here -->
                </div>
            </section>
        </div>
    </main>

    <!-- Add Feature Modal -->
    <div class="modal fade" id="addFeatureModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Fitur Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addFeatureForm">
                        <div class="mb-3">
                            <label for="featureTitle" class="form-label">Judul Fitur</label>
                            <input type="text" class="form-control" id="featureTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="featureDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="featureDescription" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="featureIcon" class="form-label">Icon (Bootstrap Icons)</label>
                            <input type="text" class="form-control" id="featureIcon" placeholder="bi-book" required>
                        </div>
                        <div class="mb-3">
                            <label for="featureColor" class="form-label">Warna</label>
                            <select class="form-select" id="featureColor" required>
                                <option value="blue">Biru</option>
                                <option value="green">Hijau</option>
                                <option value="orange">Orange</option>
                                <option value="purple">Ungu</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveFeature()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Module Modal -->
    <div class="modal fade" id="addModuleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Modul Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addModuleForm">
                        <div class="mb-3">
                            <label for="moduleTitle" class="form-label">Judul Modul</label>
                            <input type="text" class="form-control" id="moduleTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="moduleDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="moduleDescription" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="moduleIcon" class="form-label">Icon (Bootstrap Icons)</label>
                            <input type="text" class="form-control" id="moduleIcon" placeholder="bi-gear" required>
                        </div>
                        <div class="mb-3">
                            <label for="moduleColor" class="form-label">Warna</label>
                            <select class="form-select" id="moduleColor" required>
                                <option value="blue">Biru (Application-based)</option>
                                <option value="green">Hijau (Database/Backend)</option>
                                <option value="orange">Orange</option>
                                <option value="purple">Ungu</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="moduleType" class="form-label">Tipe Modul</label>
                            <select class="form-select" id="moduleType" required>
                                <option value="application">Application-based</option>
                                <option value="database">Database/Backend</option>
                                <option value="utility">Utility</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveModule()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId">
                        <input type="hidden" id="editType">
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="editTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDescription" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editIcon" class="form-label">Icon (Bootstrap Icons)</label>
                            <input type="text" class="form-control" id="editIcon" required>
                        </div>
                        <div class="mb-3">
                            <label for="editColor" class="form-label">Warna</label>
                            <select class="form-select" id="editColor" required>
                                <option value="blue">Biru</option>
                                <option value="green">Hijau</option>
                                <option value="orange">Orange</option>
                                <option value="purple">Ungu</option>
                            </select>
                        </div>
                        <div class="mb-3" id="editTypeContainer" style="display: none;">
                            <label for="editModuleType" class="form-label">Tipe Modul</label>
                            <select class="form-select" id="editModuleType">
                                <option value="application">Application-based</option>
                                <option value="database">Database/Backend</option>
                                <option value="utility">Utility</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="updateItem()">Update</button>
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
    <script src="<?= base_url('assets/js/admin/fitur.js') ?>"></script>
</body>
</html>