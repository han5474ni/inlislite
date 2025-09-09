<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<!-- Page CSS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-table-theme.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-fixes.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/installer-edit.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Manajemen Installer',
    'subtitle' => 'Kelola paket installer dan file instalasi sistem',
    'icon' => 'box-seam',
    'backUrl' => base_url('admin'),
    'bg' => 'green',
    'actionUrl' => base_url('admin/installer'),
    'actionText' => 'Lihat',
    'actionIcon' => 'eye',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Installers Management (tabs removed) -->
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
            <table class="table table-hover table-striped table-sm align-middle table-admin table-theme-green" id="installersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Paket</th>
                        <th>Tipe</th>
                        <th>Versi</th>
                        <th>Ukuran</th>
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
                                        PHP 8.1 atau lebih baru
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="reqMysql">
                                    <label class="form-check-label" for="reqMysql">
                                        MySQL/MariaDB
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="reqComposer">
                                    <label class="form-check-label" for="reqComposer">
                                        Composer
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
                    <input type="hidden" id="editId">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editPackageName" class="form-label">Nama Paket *</label>
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
                        <label for="editPackageDescription" class="form-label">Deskripsi *</label>
                        <textarea class="form-control" id="editPackageDescription" rows="4" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editPackageType" class="form-label">Tipe Paket *</label>
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
                                <input type="text" class="form-control" id="editPackageVersion" placeholder="3.0.0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editPackageSize" class="form-label">Ukuran File</label>
                                <input type="text" class="form-control" id="editPackageSize" placeholder="25 MB">
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
                                <input type="number" class="form-control" id="editPackageSortOrder" min="1" value="1">
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
                                        PHP 8.1 atau lebih baru
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editReqMysql">
                                    <label class="form-check-label" for="editReqMysql">
                                        MySQL/MariaDB
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editReqComposer">
                                    <label class="form-check-label" for="editReqComposer">
                                        Composer
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
  window.baseUrl = "<?= base_url() ?>";
</script>
<script src="<?= base_url('assets/js/admin/installer-edit.js') ?>"></script>
<?= $this->endSection() ?>
