<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Fitur dan Modul - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/fitur-edit.css') ?>" rel="stylesheet">
    
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

    
    <!-- Header Section -->
    <header class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn-back me-3" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <div>
                        <h1 class="header-title mb-1">Manajemen Fitur dan Modul</h1>
                        <p class="header-subtitle mb-0">Kelola fitur dan modul program INLISLite v3</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/fitur') ?>" class="btn btn-outline-light">
                            <i class="bi bi-eye me-2"></i>Lihat Halaman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="enhanced-main-content">
        <div class="container">
            <!-- Statistics Cards -->
            <div class="row mb-4 animate-fade-in">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="bi bi-star"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalFeatures">0</h3>
                            <p class="stat-label">Total Fitur</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-puzzle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalModules">0</h3>
                            <p class="stat-label">Total Modul</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="bi bi-gear"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="appModules">0</h3>
                            <p class="stat-label">Modul Aplikasi</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="bi bi-database"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="dbModules">0</h3>
                            <p class="stat-label">Modul Database</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Tabs -->
            <div class="management-tabs card-enhanced">
                <ul class="nav nav-tabs" id="managementTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="features-tab" data-bs-toggle="tab" data-bs-target="#features-panel" type="button" role="tab">
                            <i class="bi bi-star me-2"></i>Kelola Fitur
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="modules-tab" data-bs-toggle="tab" data-bs-target="#modules-panel" type="button" role="tab">
                            <i class="bi bi-puzzle me-2"></i>Kelola Modul
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="managementTabsContent">
                    <!-- Features Management Panel -->
                    <div class="tab-pane fade show active" id="features-panel" role="tabpanel">
                        <div class="panel-header py-3">
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <h3 class="panel-title mb-1">Manajemen Fitur</h3>
                                    <p class="text-muted mb-0 small">Kelola fitur-fitur utama sistem perpustakaan</p>
                                </div>
                                <button class="btn btn-primary btn-sm px-3 py-2" data-bs-toggle="modal" data-bs-target="#addFeatureModal">
                                    <i class="bi bi-plus-circle me-1"></i>Tambah Fitur
                                </button>
                            </div>
                        </div>
                        <div class="panel-content p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-compact mb-0" id="featuresTable">
                                    <thead class="table-fixed-header bg-primary text-white">
                                        <tr>
                                            <th class="text-center py-2 px-2" style="width: 50px;">#</th>
                                            <th class="text-center py-2 px-2" style="width: 60px;">Icon</th>
                                            <th class="py-2 px-3" style="width: 25%;">Judul</th>
                                            <th class="py-2 px-3" style="width: 45%;">Deskripsi</th>
                                            <th class="text-center py-2 px-2" style="width: 80px;">Warna</th>
                                            <th class="text-center py-2 px-2" style="width: 100px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modules Management Panel -->
                    <div class="tab-pane fade" id="modules-panel" role="tabpanel">
                        <div class="panel-header py-3">
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <h3 class="panel-title mb-1">Manajemen Modul</h3>
                                    <p class="text-muted mb-0 small">Kelola modul-modul sistem dengan berbagai kategori</p>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-primary btn-sm px-3 py-2" onclick="refreshModulesData()">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                                    </button>
                                    <button class="btn btn-primary btn-sm px-3 py-2" data-bs-toggle="modal" data-bs-target="#addModuleModal">
                                        <i class="bi bi-plus-circle me-1"></i>Tambah Modul
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-content p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-compact mb-0" id="modulesTable">
                                    <thead class="table-fixed-header bg-success text-white">
                                        <tr>
                                            <th class="text-center py-2 px-2" style="width: 50px;">#</th>
                                            <th class="text-center py-2 px-2" style="width: 60px;">Icon</th>
                                            <th class="py-2 px-3" style="width: 20%;">Judul</th>
                                            <th class="py-2 px-3" style="width: 35%;">Deskripsi</th>
                                            <th class="text-center py-2 px-2" style="width: 100px;">Tipe</th>
                                            <th class="text-center py-2 px-2" style="width: 80px;">Warna</th>
                                            <th class="text-center py-2 px-2" style="width: 100px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="featureTitle" class="form-label">Judul Fitur *</label>
                                    <input type="text" class="form-control" id="featureTitle" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="featureIcon" class="form-label">Icon (Bootstrap Icons) *</label>
                                    <input type="text" class="form-control" id="featureIcon" placeholder="bi-star" required>
                                    <div class="form-text">Contoh: bi-star, bi-book, bi-gear</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="featureDescription" class="form-label">Deskripsi *</label>
                            <textarea class="form-control" id="featureDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="featureColor" class="form-label">Warna *</label>
                                    <select class="form-select" id="featureColor" required>
                                        <option value="">Pilih Warna</option>
                                        <option value="blue">Biru</option>
                                        <option value="green">Hijau</option>
                                        <option value="orange">Orange</option>
                                        <option value="purple">Ungu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Preview Icon</label>
                                    <div class="icon-preview" id="featureIconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="moduleTitle" class="form-label">Judul Modul *</label>
                                    <input type="text" class="form-control" id="moduleTitle" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="moduleIcon" class="form-label">Icon (Bootstrap Icons) *</label>
                                    <input type="text" class="form-control" id="moduleIcon" placeholder="bi-gear" required>
                                    <div class="form-text">Contoh: bi-gear, bi-database, bi-cloud</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="moduleDescription" class="form-label">Deskripsi *</label>
                            <textarea class="form-control" id="moduleDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="moduleType" class="form-label">Tipe Modul *</label>
                                    <select class="form-select" id="moduleType" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="application">Application-based</option>
                                        <option value="database">Database/Backend</option>
                                        <option value="utility">Utility</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="moduleColor" class="form-label">Warna *</label>
                                    <select class="form-select" id="moduleColor" required>
                                        <option value="">Pilih Warna</option>
                                        <option value="blue">Biru (Application)</option>
                                        <option value="green">Hijau (Database)</option>
                                        <option value="orange">Orange</option>
                                        <option value="purple">Ungu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Preview Icon</label>
                                    <div class="icon-preview" id="moduleIconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editTitle" class="form-label">Judul *</label>
                                    <input type="text" class="form-control" id="editTitle" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editIcon" class="form-label">Icon (Bootstrap Icons) *</label>
                                    <input type="text" class="form-control" id="editIcon" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Deskripsi *</label>
                            <textarea class="form-control" id="editDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4" id="editTypeContainer" style="display: none;">
                                <div class="mb-3">
                                    <label for="editModuleType" class="form-label">Tipe Modul</label>
                                    <select class="form-select" id="editModuleType">
                                        <option value="application">Application-based</option>
                                        <option value="database">Database/Backend</option>
                                        <option value="utility">Utility</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editColor" class="form-label">Warna *</label>
                                    <select class="form-select" id="editColor" required>
                                        <option value="blue">Biru</option>
                                        <option value="green">Hijau</option>
                                        <option value="orange">Orange</option>
                                        <option value="purple">Ungu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Preview Icon</label>
                                    <div class="icon-preview" id="editIconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <!-- Custom JS -->
    <script>
        window.baseUrl = "<?= base_url() ?>";
    </script>
    <script src="<?= base_url('assets/js/admin/fitur-edit.js') ?>"></script>
</body>
</html>