<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Installer INLISLite - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/public/installer-edit.css') ?>" rel="stylesheet">
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
                        <h1 class="header-title mb-1">Manajemen Installer INLISLite</h1>
                        <p class="header-subtitle mb-0">Kelola paket dan konten installer sistem</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('installer') ?>" class="btn btn-outline-light">
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
                            <i class="bi bi-download"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalPackages">0</h3>
                            <p class="stat-label">Total Paket</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="activePackages">0</h3>
                            <p class="stat-label">Paket Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="bi bi-cloud-download"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalDownloads">0</h3>
                            <p class="stat-label">Total Unduhan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="bi bi-file-earmark-zip"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="installerPackages">0</h3>
                            <p class="stat-label">Paket Installer</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Tabs -->
            <div class="management-tabs">
                <ul class="nav nav-tabs" id="managementTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="packages-tab" data-bs-toggle="tab" data-bs-target="#packages-panel" type="button" role="tab">
                            <i class="bi bi-box-seam me-2"></i>Kelola Paket
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings-panel" type="button" role="tab">
                            <i class="bi bi-gear me-2"></i>Pengaturan
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="managementTabsContent">
                    <!-- Packages Management Panel -->
                    <div class="tab-pane fade show active" id="packages-panel" role="tabpanel">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="panel-title">Manajemen Paket Installer</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPackageModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Paket
                                </button>
                            </div>
                        </div>
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table class="table table-hover" id="packagesTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Icon</th>
                                            <th>Nama Paket</th>
                                            <th>Versi</th>
                                            <th>Tipe</th>
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

                    <!-- Settings Panel -->
                    <div class="tab-pane fade" id="settings-panel" role="tabpanel">
                        <div class="panel-header">
                            <h3 class="panel-title">Pengaturan Installer</h3>
                        </div>
                        <div class="panel-content">
                            <form id="settingsForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="installerVersion" class="form-label">Versi Installer</label>
                                            <input type="text" class="form-control" id="installerVersion" value="3.2">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="revisionDate" class="form-label">Tanggal Revisi</label>
                                            <input type="text" class="form-control" id="revisionDate" value="10 Februari 2021">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="installerDescription" class="form-label">Deskripsi Installer</label>
                                    <textarea class="form-control" id="installerDescription" rows="3">Paket instalasi lengkap sistem manajemen perpustakaan digital terpadu untuk kebutuhan perpustakaan modern dengan teknologi terdepan.</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="defaultUsername" class="form-label">Username Default</label>
                                            <input type="text" class="form-control" id="defaultUsername" value="inlislite">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="defaultPassword" class="form-label">Password Default</label>
                                            <input type="text" class="form-control" id="defaultPassword" value="inlislite">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" onclick="saveSettings()">
                                    <i class="bi bi-check-circle me-2"></i>Simpan Pengaturan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="packageName" class="form-label">Nama Paket *</label>
                                    <input type="text" class="form-control" id="packageName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="packageVersion" class="form-label">Versi *</label>
                                    <input type="text" class="form-control" id="packageVersion" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="packageDescription" class="form-label">Deskripsi *</label>
                            <textarea class="form-control" id="packageDescription" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="packageType" class="form-label">Tipe Paket *</label>
                                    <select class="form-select" id="packageType" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="installer">Installer</option>
                                        <option value="source">Source Code</option>
                                        <option value="database">Database</option>
                                        <option value="documentation">Dokumentasi</option>
                                    </select>
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
                                    <label for="packageIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" id="packageIcon" placeholder="bi-download">
                                    <div class="form-text">Contoh: bi-download, bi-code-slash, bi-database</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="packageColor" class="form-label">Warna Tema</label>
                                    <select class="form-select" id="packageColor">
                                        <option value="blue">Biru</option>
                                        <option value="green">Hijau</option>
                                        <option value="orange">Oranye</option>
                                        <option value="purple">Ungu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="packageStatus" class="form-label">Status</label>
                                    <select class="form-select" id="packageStatus">
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="packageUrl" class="form-label">URL Download</label>
                            <input type="url" class="form-control" id="packageUrl" placeholder="https://...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fitur Paket</label>
                            <div class="features-input">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control feature-input" placeholder="Masukkan fitur paket">
                                    <button class="btn btn-outline-secondary" type="button" onclick="addFeature(this)">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editName" class="form-label">Nama Paket</label>
                                    <input type="text" class="form-control" id="editName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editVersion" class="form-label">Versi</label>
                                    <input type="text" class="form-control" id="editVersion" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDescription" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editType" class="form-label">Tipe Paket</label>
                                    <select class="form-select" id="editType" required>
                                        <option value="installer">Installer</option>
                                        <option value="source">Source Code</option>
                                        <option value="database">Database</option>
                                        <option value="documentation">Dokumentasi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editSize" class="form-label">Ukuran File</label>
                                    <input type="text" class="form-control" id="editSize">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editIcon" class="form-label">Icon</label>
                                    <input type="text" class="form-control" id="editIcon">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editColor" class="form-label">Warna Tema</label>
                                    <select class="form-select" id="editColor">
                                        <option value="blue">Biru</option>
                                        <option value="green">Hijau</option>
                                        <option value="orange">Oranye</option>
                                        <option value="purple">Ungu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editStatus" class="form-label">Status</label>
                                    <select class="form-select" id="editStatus">
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editUrl" class="form-label">URL Download</label>
                            <input type="url" class="form-control" id="editUrl">
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/public/installer-edit.js') ?>"></script>
</body>
</html>