<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Patch & Updater - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/patch-edit.css') ?>" rel="stylesheet">
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
                        <h1 class="header-title mb-1">Manajemen Patch & Updater</h1>
                        <p class="header-subtitle mb-0">Kelola konten pembaruan dan perbaikan sistem</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/patch') ?>" class="btn btn-outline-light">
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
                            <i class="bi bi-arrow-up-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalPatches">0</h3>
                            <p class="stat-label">Total Patch</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="activePatches">0</h3>
                            <p class="stat-label">Patch Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="criticalPatches">0</h3>
                            <p class="stat-label">Patch Kritis</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="pendingPatches">0</h3>
                            <p class="stat-label">Patch Pending</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Tabs -->
            <div class="management-tabs">
                <ul class="nav nav-tabs" id="managementTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="patches-tab" data-bs-toggle="tab" data-bs-target="#patches-panel" type="button" role="tab">
                            <i class="bi bi-collection me-2"></i>Kelola Patch
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="versions-tab" data-bs-toggle="tab" data-bs-target="#versions-panel" type="button" role="tab">
                            <i class="bi bi-tags me-2"></i>Versi Sistem
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="managementTabsContent">
                    <!-- Patches Management Panel -->
                    <div class="tab-pane fade show active" id="patches-panel" role="tabpanel">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="panel-title">Manajemen Patch & Update</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatchModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Patch
                                </button>
                            </div>
                        </div>
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table class="table table-hover" id="patchesTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Versi</th>
                                            <th>Judul</th>
                                            <th>Kategori</th>
                                            <th>Prioritas</th>
                                            <th>Status</th>
                                            <th>Tanggal Rilis</th>
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

                    <!-- Versions Management Panel -->
                    <div class="tab-pane fade" id="versions-panel" role="tabpanel">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="panel-title">Manajemen Versi Sistem</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVersionModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Versi
                                </button>
                            </div>
                        </div>
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table class="table table-hover" id="versionsTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Versi</th>
                                            <th>Nama Rilis</th>
                                            <th>Status</th>
                                            <th>Tanggal Rilis</th>
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

    <!-- Add Patch Modal -->
    <div class="modal fade" id="addPatchModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Patch Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addPatchForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="patchVersion" class="form-label">Versi Patch *</label>
                                    <input type="text" class="form-control" id="patchVersion" placeholder="v3.0.1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="patchTitle" class="form-label">Judul Patch *</label>
                                    <input type="text" class="form-control" id="patchTitle" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="patchDescription" class="form-label">Deskripsi *</label>
                            <textarea class="form-control" id="patchDescription" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="patchChangelog" class="form-label">Changelog</label>
                            <textarea class="form-control" id="patchChangelog" rows="6" placeholder="- Perbaikan bug pada modul katalogisasi&#10;- Peningkatan performa sistem&#10;- Penambahan fitur baru"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="patchCategory" class="form-label">Kategori *</label>
                                    <select class="form-select" id="patchCategory" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="bugfix">Bug Fix</option>
                                        <option value="feature">New Feature</option>
                                        <option value="security">Security Update</option>
                                        <option value="performance">Performance</option>
                                        <option value="maintenance">Maintenance</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="patchPriority" class="form-label">Prioritas *</label>
                                    <select class="form-select" id="patchPriority" required>
                                        <option value="">Pilih Prioritas</option>
                                        <option value="low">Rendah</option>
                                        <option value="medium">Sedang</option>
                                        <option value="high">Tinggi</option>
                                        <option value="critical">Kritis</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="patchStatus" class="form-label">Status</label>
                                    <select class="form-select" id="patchStatus">
                                        <option value="draft">Draft</option>
                                        <option value="testing">Testing</option>
                                        <option value="released">Released</option>
                                        <option value="archived">Archived</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="patchReleaseDate" class="form-label">Tanggal Rilis</label>
                                    <input type="date" class="form-control" id="patchReleaseDate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="patchFileUrl" class="form-label">URL File Patch</label>
                                    <input type="url" class="form-control" id="patchFileUrl" placeholder="https://example.com/patch.zip">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="savePatch()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Patch Modal -->
    <div class="modal fade" id="editPatchModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Patch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editPatchForm">
                        <input type="hidden" id="editPatchId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editPatchVersion" class="form-label">Versi Patch</label>
                                    <input type="text" class="form-control" id="editPatchVersion" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editPatchTitle" class="form-label">Judul Patch</label>
                                    <input type="text" class="form-control" id="editPatchTitle" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editPatchDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editPatchDescription" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editPatchChangelog" class="form-label">Changelog</label>
                            <textarea class="form-control" id="editPatchChangelog" rows="6"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editPatchCategory" class="form-label">Kategori</label>
                                    <select class="form-select" id="editPatchCategory" required>
                                        <option value="bugfix">Bug Fix</option>
                                        <option value="feature">New Feature</option>
                                        <option value="security">Security Update</option>
                                        <option value="performance">Performance</option>
                                        <option value="maintenance">Maintenance</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editPatchPriority" class="form-label">Prioritas</label>
                                    <select class="form-select" id="editPatchPriority" required>
                                        <option value="low">Rendah</option>
                                        <option value="medium">Sedang</option>
                                        <option value="high">Tinggi</option>
                                        <option value="critical">Kritis</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editPatchStatus" class="form-label">Status</label>
                                    <select class="form-select" id="editPatchStatus">
                                        <option value="draft">Draft</option>
                                        <option value="testing">Testing</option>
                                        <option value="released">Released</option>
                                        <option value="archived">Archived</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editPatchReleaseDate" class="form-label">Tanggal Rilis</label>
                                    <input type="date" class="form-control" id="editPatchReleaseDate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editPatchFileUrl" class="form-label">URL File Patch</label>
                                    <input type="url" class="form-control" id="editPatchFileUrl">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="updatePatch()">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Version Modal -->
    <div class="modal fade" id="addVersionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Versi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addVersionForm">
                        <div class="mb-3">
                            <label for="versionNumber" class="form-label">Nomor Versi *</label>
                            <input type="text" class="form-control" id="versionNumber" placeholder="3.0.1" required>
                        </div>
                        <div class="mb-3">
                            <label for="versionName" class="form-label">Nama Rilis</label>
                            <input type="text" class="form-control" id="versionName" placeholder="Stable Release">
                        </div>
                        <div class="mb-3">
                            <label for="versionStatus" class="form-label">Status</label>
                            <select class="form-select" id="versionStatus">
                                <option value="development">Development</option>
                                <option value="beta">Beta</option>
                                <option value="stable">Stable</option>
                                <option value="deprecated">Deprecated</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="versionReleaseDate" class="form-label">Tanggal Rilis</label>
                            <input type="date" class="form-control" id="versionReleaseDate">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveVersion()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Version Modal -->
    <div class="modal fade" id="editVersionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Versi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editVersionForm">
                        <input type="hidden" id="editVersionId">
                        <div class="mb-3">
                            <label for="editVersionNumber" class="form-label">Nomor Versi</label>
                            <input type="text" class="form-control" id="editVersionNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="editVersionName" class="form-label">Nama Rilis</label>
                            <input type="text" class="form-control" id="editVersionName">
                        </div>
                        <div class="mb-3">
                            <label for="editVersionStatus" class="form-label">Status</label>
                            <select class="form-select" id="editVersionStatus">
                                <option value="development">Development</option>
                                <option value="beta">Beta</option>
                                <option value="stable">Stable</option>
                                <option value="deprecated">Deprecated</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editVersionReleaseDate" class="form-label">Tanggal Rilis</label>
                            <input type="date" class="form-control" id="editVersionReleaseDate">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="updateVersion()">Update</button>
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
    <script src="<?= base_url('assets/js/admin/patch-edit.js') ?>"></script>
</body>
</html>