<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Installer - INLISLite v3.0</title>
    
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
    <link href="<?= base_url('assets/css/admin/installer-edit.css') ?>" rel="stylesheet">
    
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
                        <h1 class="header-title mb-1">Manajemen Installer</h1>
                        <p class="header-subtitle mb-0">Kelola paket installer dan file instalasi sistem</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/installer') ?>" class="btn btn-outline-light">
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
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalInstallers">0</h3>
                            <p class="stat-label">Total Installer</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="activeInstallers">0</h3>
                            <p class="stat-label">Installer Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="bi bi-gear"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="sourcePackages">0</h3>
                            <p class="stat-label">Source Code</p>
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
                        <button class="nav-link active" id="installers-tab" data-bs-toggle="tab" data-bs-target="#installers-panel" type="button" role="tab">
                            <i class="bi bi-collection me-2"></i>Kelola Installer
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="managementTabsContent">
                    <!-- Installers Management Panel -->
                    <div class="tab-pane fade show active" id="installers-panel" role="tabpanel">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="panel-title">Manajemen Paket Installer</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInstallerModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Installer
                                </button>
                            </div>
                        </div>
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table class="table table-hover" id="installersTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Icon</th>
                                            <th>Paket</th>
                                            <th>Tipe</th>
                                            <th>Versi</th>
                                            <th>Ukuran</th>
                                            <th>Status</th>
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

    <!-- Add Installer Modal -->
    <div class="modal fade" id="addInstallerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Installer Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addInstallerForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="packageName" class="form-label">Nama Paket *</label>
                                    <input type="text" class="form-control" id="packageName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="packageSubtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="packageSubtitle">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="packageDescription" class="form-label">Deskripsi *</label>
                            <textarea class="form-control" id="packageDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="packageType" class="form-label">Tipe Paket *</label>
                                    <select class="form-select" id="packageType" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="source">Source Code</option>
                                        <option value="installer">Installer</option>
                                        <option value="database">Database</option>
                                        <option value="documentation">Dokumentasi</option>
                                        <option value="addon">Add-on</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="packageIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" id="packageIcon" placeholder="bi-box-seam">
                                    <div class="form-text">Contoh: bi-box-seam, bi-gear, bi-download</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Preview Icon</label>
                                    <div class="icon-preview" id="packageIconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="packageVersion" class="form-label">Versi</label>
                                    <input type="text" class="form-control" id="packageVersion" placeholder="3.0.0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="packageSize" class="form-label">Ukuran File</label>
                                    <input type="text" class="form-control" id="packageSize" placeholder="25 MB">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="packageStatus" class="form-label">Status</label>
                                    <select class="form-select" id="packageStatus">
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
                                    <label for="packageReleaseDate" class="form-label">Tanggal Rilis</label>
                                    <input type="date" class="form-control" id="packageReleaseDate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="packageSortOrder" class="form-label">Urutan Tampil</label>
                                    <input type="number" class="form-control" id="packageSortOrder" min="1" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="packageDownloadUrl" class="form-label">URL Download</label>
                            <input type="url" class="form-control" id="packageDownloadUrl" placeholder="https://example.com/installer.zip">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="defaultUsername" class="form-label">Username Default</label>
                                    <input type="text" class="form-control" id="defaultUsername" placeholder="admin">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="defaultPassword" class="form-label">Password Default</label>
                                    <input type="text" class="form-control" id="defaultPassword" placeholder="admin123">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Persyaratan Sistem</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="reqPhp">
                                        <label class="form-check-label" for="reqPhp">
                                            File aplikasi PHP
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="reqDatabase">
                                        <label class="form-check-label" for="reqDatabase">
                                            Struktur database
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="reqDocs">
                                        <label class="form-check-label" for="reqDocs">
                                            Dokumentasi dan panduan
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="reqConfig">
                                        <label class="form-check-label" for="reqConfig">
                                            Template konfigurasi
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveInstaller()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Installer Modal -->
    <div class="modal fade" id="editInstallerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Installer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editInstallerForm">
                        <input type="hidden" id="editInstallerId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editPackageName" class="form-label">Nama Paket</label>
                                    <input type="text" class="form-control" id="editPackageName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editPackageSubtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="editPackageSubtitle">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editPackageDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editPackageDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editPackageType" class="form-label">Tipe Paket</label>
                                    <select class="form-select" id="editPackageType" required>
                                        <option value="source">Source Code</option>
                                        <option value="installer">Installer</option>
                                        <option value="database">Database</option>
                                        <option value="documentation">Dokumentasi</option>
                                        <option value="addon">Add-on</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editPackageIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" id="editPackageIcon">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Preview Icon</label>
                                    <div class="icon-preview" id="editPackageIconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editPackageVersion" class="form-label">Versi</label>
                                    <input type="text" class="form-control" id="editPackageVersion">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editPackageSize" class="form-label">Ukuran File</label>
                                    <input type="text" class="form-control" id="editPackageSize">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editPackageStatus" class="form-label">Status</label>
                                    <select class="form-select" id="editPackageStatus">
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
                                    <label for="editPackageReleaseDate" class="form-label">Tanggal Rilis</label>
                                    <input type="date" class="form-control" id="editPackageReleaseDate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editPackageSortOrder" class="form-label">Urutan Tampil</label>
                                    <input type="number" class="form-control" id="editPackageSortOrder" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editPackageDownloadUrl" class="form-label">URL Download</label>
                            <input type="url" class="form-control" id="editPackageDownloadUrl">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editDefaultUsername" class="form-label">Username Default</label>
                                    <input type="text" class="form-control" id="editDefaultUsername">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editDefaultPassword" class="form-label">Password Default</label>
                                    <input type="text" class="form-control" id="editDefaultPassword">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Persyaratan Sistem</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="editReqPhp">
                                        <label class="form-check-label" for="editReqPhp">
                                            File aplikasi PHP
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="editReqDatabase">
                                        <label class="form-check-label" for="editReqDatabase">
                                            Struktur database
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="editReqDocs">
                                        <label class="form-check-label" for="editReqDocs">
                                            Dokumentasi dan panduan
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="editReqConfig">
                                        <label class="form-check-label" for="editReqConfig">
                                            Template konfigurasi
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="updateInstaller()">Update</button>
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
    <script src="<?= base_url('assets/js/admin/installer-edit.js') ?>"></script>
</body>
</html>