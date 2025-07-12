<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Aplikasi Pendukung - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/aplikasi-edit.css') ?>" rel="stylesheet">
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
                        <h1 class="header-title mb-1">Manajemen Aplikasi Pendukung</h1>
                        <p class="header-subtitle mb-0">Kelola aplikasi dan tools pendukung sistem</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/aplikasi') ?>" class="btn btn-outline-light">
                            <i class="bi bi-eye me-2"></i>Lihat Halaman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="bi bi-app-indicator"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalApps">0</h3>
                            <p class="stat-label">Total Aplikasi</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="activeApps">0</h3>
                            <p class="stat-label">Aplikasi Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="bi bi-tools"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="utilityApps">0</h3>
                            <p class="stat-label">Utility Tools</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="bi bi-download"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalDownloads">0</h3>
                            <p class="stat-label">Total Unduhan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Tabs -->
            <div class="management-tabs">
                <ul class="nav nav-tabs" id="managementTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="apps-tab" data-bs-toggle="tab" data-bs-target="#apps-panel" type="button" role="tab">
                            <i class="bi bi-collection me-2"></i>Kelola Aplikasi
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="managementTabsContent">
                    <!-- Apps Management Panel -->
                    <div class="tab-pane fade show active" id="apps-panel" role="tabpanel">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="panel-title">Manajemen Aplikasi Pendukung</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAppModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Aplikasi
                                </button>
                            </div>
                        </div>
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table class="table table-hover" id="appsTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Icon</th>
                                            <th>Aplikasi</th>
                                            <th>Kategori</th>
                                            <th>Versi</th>
                                            <th>Status</th>
                                            <th>Unduhan</th>
                                            <th>Aksi</th>
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

    <!-- Add App Modal -->
    <div class="modal fade" id="addAppModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Aplikasi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addAppForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appTitle" class="form-label">Nama Aplikasi *</label>
                                    <input type="text" class="form-control" id="appTitle" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appSubtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="appSubtitle">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="appDescription" class="form-label">Deskripsi *</label>
                            <textarea class="form-control" id="appDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="appCategory" class="form-label">Kategori *</label>
                                    <select class="form-select" id="appCategory" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="utility">Utility</option>
                                        <option value="addon">Add-on</option>
                                        <option value="plugin">Plugin</option>
                                        <option value="tool">Tool</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="appIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" id="appIcon" placeholder="bi-app">
                                    <div class="form-text">Contoh: bi-app, bi-tools, bi-gear</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Preview Icon</label>
                                    <div class="icon-preview" id="appIconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="appVersion" class="form-label">Versi</label>
                                    <input type="text" class="form-control" id="appVersion" placeholder="1.0.0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="appFileSize" class="form-label">Ukuran File</label>
                                    <input type="text" class="form-control" id="appFileSize" placeholder="2.5 MB">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="appStatus" class="form-label">Status</label>
                                    <select class="form-select" id="appStatus">
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                        <option value="maintenance">Maintenance</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appDownloadUrl" class="form-label">URL Download</label>
                                    <input type="url" class="form-control" id="appDownloadUrl" placeholder="https://example.com/app.zip">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appSortOrder" class="form-label">Urutan Tampil</label>
                                    <input type="number" class="form-control" id="appSortOrder" min="1" value="1">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveApp()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit App Modal -->
    <div class="modal fade" id="editAppModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Aplikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editAppForm">
                        <input type="hidden" id="editAppId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editAppTitle" class="form-label">Nama Aplikasi</label>
                                    <input type="text" class="form-control" id="editAppTitle" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editAppSubtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="editAppSubtitle">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editAppDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editAppDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editAppCategory" class="form-label">Kategori</label>
                                    <select class="form-select" id="editAppCategory" required>
                                        <option value="utility">Utility</option>
                                        <option value="addon">Add-on</option>
                                        <option value="plugin">Plugin</option>
                                        <option value="tool">Tool</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editAppIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" id="editAppIcon">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Preview Icon</label>
                                    <div class="icon-preview" id="editAppIconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editAppVersion" class="form-label">Versi</label>
                                    <input type="text" class="form-control" id="editAppVersion">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editAppFileSize" class="form-label">Ukuran File</label>
                                    <input type="text" class="form-control" id="editAppFileSize">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editAppStatus" class="form-label">Status</label>
                                    <select class="form-select" id="editAppStatus">
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                        <option value="maintenance">Maintenance</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editAppDownloadUrl" class="form-label">URL Download</label>
                                    <input type="url" class="form-control" id="editAppDownloadUrl">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editAppSortOrder" class="form-label">Urutan Tampil</label>
                                    <input type="number" class="form-control" id="editAppSortOrder" min="1">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="updateApp()">Update</button>
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
    <script src="<?= base_url('assets/js/admin/aplikasi-edit.js') ?>"></script>
</body>
</html>