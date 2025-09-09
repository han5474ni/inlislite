<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<!-- Page CSS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-table-theme.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-fixes.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/patch-edit.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Manajemen Patch & Updater',
    'subtitle' => 'Kelola konten pembaruan dan perbaikan sistem',
    'icon' => 'arrow-up-circle',
    'backUrl' => base_url('admin/patch'),
    'bg' => 'green',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div class="container-fluid px-0">


    <!-- Management Tabs -->
    <div class="management-tabs">


        <div class="tab-content" id="managementTabsContent">
            <!-- Patches Management Panel (tabs removed) -->
            <div class="panel-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="panel-title">Manajemen Patch & Update</h3>
                    <div class="dt-actions gap-2">
                        <button class="btn btn-outline-primary" id="openAddVersionCardBtn">
                            <i class="bi bi-box-arrow-in-up-right me-2"></i>Tambah Updater
                        </button>
                        <button class="btn btn-primary" id="openAddCardBtn">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Patch
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Add Patch Card (hidden by default) -->
            <div class="panel-content d-none" id="addPatchCard">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Tambah Patch</h5>
                            <button class="btn btn-outline-secondary btn-sm" id="closeAddCardBtn"><i class="bi bi-x"></i> Tutup</button>
                        </div>
                        <form id="addPatchCardForm" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Versi *</label>
                                <input type="text" class="form-control" id="cardPatchVersion" placeholder="v3.0.3" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Judul *</label>
                                <input type="text" class="form-control" id="cardPatchTitle" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Deskripsi *</label>
                                <textarea class="form-control" id="cardPatchDescription" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Rilis</label>
                                <input type="date" class="form-control" id="cardPatchReleaseDate">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upload File (gambar/PDF)</label>
                                <input type="file" class="form-control" id="cardPatchFile" accept="image/*,application/pdf">
                            </div>
                            <div class="col-12">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-7">
                                        <label class="form-label">Atau Link</label>
                                        <input type="url" class="form-control" id="cardPatchFileUrl" placeholder="https://example.com/patch.pdf">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Nama Link (as)</label>
                                        <input type="text" class="form-control" id="cardPatchFileLabel" placeholder="Contoh: Dokumen Patch">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Changelog</label>
                                <textarea class="form-control" id="cardPatchChangelog" rows="5" placeholder="- Perubahan 1&#10;- Perubahan 2"></textarea>
                            </div>
                            <div class="col-12 d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-secondary" id="cancelAddCardBtn">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add Updater Card (hidden by default) -->
            <div class="panel-content d-none" id="addVersionCard">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Tambah Updater</h5>
                            <button class="btn btn-outline-secondary btn-sm" id="closeAddVersionCardBtn"><i class="bi bi-x"></i> Tutup</button>
                        </div>
                        <form id="addVersionCardForm" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Nomor Versi *</label>
                                <input type="text" class="form-control" id="cardVersionNumber" placeholder="3.0.3" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nama Rilis</label>
                                <input type="text" class="form-control" id="cardVersionName">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Rilis</label>
                                <input type="date" class="form-control" id="cardVersionReleaseDate">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upload File (gambar/PDF)</label>
                                <input type="file" class="form-control" id="cardVersionFile" accept="image/*,application/pdf">
                            </div>
                            <div class="col-12">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-7">
                                        <label class="form-label">Atau Link</label>
                                        <input type="url" class="form-control" id="cardVersionFileUrl" placeholder="https://example.com/release.pdf">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Nama Link (as)</label>
                                        <input type="text" class="form-control" id="cardVersionFileLabel" placeholder="Contoh: Catatan Rilis">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-secondary" id="cancelAddVersionCardBtn">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="panel-content" id="tablePanel">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm align-middle table-admin table-theme-green" id="patchesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Versi</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>File</th>
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

            <!-- Versions Management Panel (kept markup for future; hidden by default) -->
            <div class="d-none" id="versions-panel">
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
                        <table class="table table-hover table-striped table-sm align-middle table-admin table-theme-green" id="versionsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Versi</th>
                                    <th>Nama Rilis</th>
                                    <th>File</th>
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="patchReleaseDate" class="form-label">Tanggal Rilis</label>
                                <input type="date" class="form-control" id="patchReleaseDate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Upload File (gambar/PDF) atau Link</label>
                                <div class="input-group">
                                    <input type="file" accept=".pdf,.png,.jpg,.jpeg,.gif,.webp" class="form-control" id="patchFile">
                                </div>
                                <div class="row g-2 mt-2">
                                    <div class="col-7">
                                        <input type="url" class="form-control" id="patchFileUrl" placeholder="https://example.com/patch.pdf">
                                    </div>
                                    <div class="col-5">
                                        <input type="text" class="form-control" id="patchFileLabel" placeholder="Nama Link (as)">
                                    </div>
                                </div>
                                <small class="text-muted">Jika keduanya diisi, file unggahan akan diprioritaskan. "Nama Link" akan digunakan sebagai label tampilan.</small>
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
                                <label class="form-label">Upload File (gambar/PDF) atau Link</label>
                                <div class="input-group">
                                    <input type="file" accept=".pdf,.png,.jpg,.jpeg,.gif,.webp" class="form-control" id="editPatchFile">
                                </div>
                                <div class="row g-2 mt-2">
                                    <div class="col-7">
                                        <input type="url" class="form-control" id="editPatchFileUrl" placeholder="https://example.com/patch.pdf">
                                    </div>
                                    <div class="col-5">
                                        <input type="text" class="form-control" id="editPatchFileLabel" placeholder="Nama Link (as)">
                                    </div>
                                </div>
                                <small class="text-muted">Jika keduanya diisi, file unggahan akan diprioritaskan. "Nama Link" akan digunakan sebagai label tampilan.</small>
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
                <h5 class="modal-title">Tambah Versi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addVersionForm">
                    <div class="mb-3">
                        <label for="versionNumber" class="form-label">Nomor Versi *</label>
                        <input type="text" class="form-control" id="versionNumber" placeholder="v3.0.1" required>
                    </div>
                    <div class="mb-3">
                        <label for="versionName" class="form-label">Nama Rilis</label>
                        <input type="text" class="form-control" id="versionName">
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
                    <div class="mb-3">
                        <label class="form-label">Upload File (gambar/PDF) atau Link</label>
                        <div class="input-group">
                            <input type="file" accept=".pdf,.png,.jpg,.jpeg,.gif,.webp" class="form-control" id="versionFile">
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-7">
                                <input type="url" class="form-control" id="versionFileUrl" placeholder="https://example.com/release.pdf">
                            </div>
                            <div class="col-5">
                                <input type="text" class="form-control" id="versionFileLabel" placeholder="Nama Link (as)">
                            </div>
                        </div>
                        <small class="text-muted">Jika keduanya diisi, file unggahan akan diprioritaskan. "Nama Link" akan digunakan sebagai label tampilan.</small>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url('assets/js/admin/patch-edit.js') ?>"></script>
<?= $this->endSection() ?>
