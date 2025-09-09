<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<!-- Page CSS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-table-theme.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-fixes.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/dukungan-edit.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Manajemen Dukungan Teknis',
    'subtitle' => 'Kelola layanan dukungan dan bantuan teknis',
    'icon' => 'headset',
    'backUrl' => base_url('admin/dukungan'),
    'bg' => 'green',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div class="container-fluid px-0 page-dukungan">
    <!-- Statistics Cards removed as requested -->

    <!-- Simplified content: remove tabs header and borders -->
    <div class="panel-content">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="panel-title m-0">Manajemen Layanan Dukungan</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupportModal">
                <i class="bi bi-plus-circle me-2"></i>Tambah Dukungan
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-sm align-middle table-admin table-theme-green" id="supportTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Layanan</th>
                        <th>Kategori</th>
                        <th>Kontak</th>
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

<!-- Add Support Modal -->
<div class="modal fade" id="addSupportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Layanan Dukungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addSupportForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supportTitle" class="form-label">Nama Layanan *</label>
                                <input type="text" class="form-control" id="supportTitle" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supportSubtitle" class="form-label">Subtitle</label>
                                <input type="text" class="form-control" id="supportSubtitle">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="supportDescription" class="form-label">Deskripsi *</label>
                        <textarea class="form-control" id="supportDescription" rows="4" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="supportCategory" class="form-label">Kategori *</label>
                                <select class="form-select" id="supportCategory" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="technical">Technical Support</option>
                                    <option value="general">General Support</option>
                                    <option value="installation">Installation Help</option>
                                    <option value="troubleshooting">Troubleshooting</option>
                                    <option value="faq">FAQ</option>
                                    <option value="contact">Contact Info</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="supportPriority" class="form-label">Prioritas</label>
                                <select class="form-select" id="supportPriority">
                                    <option value="low">Rendah</option>
                                    <option value="medium">Sedang</option>
                                    <option value="high">Tinggi</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="supportStatus" class="form-label">Status</label>
                                <select class="form-select" id="supportStatus">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="supportIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                <input type="text" class="form-control" id="supportIcon" placeholder="bi-headset">
                                <div class="form-text">Contoh: bi-headset, bi-telephone, bi-envelope</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Preview Icon</label>
                                <div class="icon-preview" id="supportIconPreview">
                                    <i class="bi bi-question-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="supportSortOrder" class="form-label">Urutan Tampil</label>
                                <input type="number" class="form-control" id="supportSortOrder" min="1" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="supportEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="supportEmail" placeholder="support@inlislite.com">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="supportPhone" class="form-label">Telepon</label>
                                <input type="tel" class="form-control" id="supportPhone" placeholder="+62-21-1234567">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="supportUrl" class="form-label">URL</label>
                                <input type="url" class="form-control" id="supportUrl" placeholder="https://support.inlislite.com">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="supportContactInfo" class="form-label">Informasi Kontak Tambahan</label>
                        <textarea class="form-control" id="supportContactInfo" rows="3" placeholder="Jam operasional, alamat, atau informasi kontak lainnya"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="supportFeatured">
                            <label class="form-check-label" for="supportFeatured">
                                Jadikan layanan unggulan
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveSupport()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Support Modal -->
<div class="modal fade" id="editSupportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Layanan Dukungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editSupportForm">
                    <input type="hidden" id="editSupportId">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSupportTitle" class="form-label">Nama Layanan</label>
                                <input type="text" class="form-control" id="editSupportTitle" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSupportSubtitle" class="form-label">Subtitle</label>
                                <input type="text" class="form-control" id="editSupportSubtitle">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editSupportDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editSupportDescription" rows="4" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editSupportCategory" class="form-label">Kategori</label>
                                <select class="form-select" id="editSupportCategory" required>
                                    <option value="technical">Technical Support</option>
                                    <option value="general">General Support</option>
                                    <option value="installation">Installation Help</option>
                                    <option value="troubleshooting">Troubleshooting</option>
                                    <option value="faq">FAQ</option>
                                    <option value="contact">Contact Info</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editSupportPriority" class="form-label">Prioritas</label>
                                <select class="form-select" id="editSupportPriority">
                                    <option value="low">Rendah</option>
                                    <option value="medium">Sedang</option>
                                    <option value="high">Tinggi</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editSupportStatus" class="form-label">Status</label>
                                <select class="form-select" id="editSupportStatus">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editSupportIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                <input type="text" class="form-control" id="editSupportIcon">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Preview Icon</label>
                                <div class="icon-preview" id="editSupportIconPreview">
                                    <i class="bi bi-question-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editSupportSortOrder" class="form-label">Urutan Tampil</label>
                                <input type="number" class="form-control" id="editSupportSortOrder" min="1" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editSupportEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editSupportEmail">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editSupportPhone" class="form-label">Telepon</label>
                                <input type="tel" class="form-control" id="editSupportPhone">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editSupportUrl" class="form-label">URL</label>
                                <input type="url" class="form-control" id="editSupportUrl">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editSupportContactInfo" class="form-label">Informasi Kontak Tambahan</label>
                        <textarea class="form-control" id="editSupportContactInfo" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="editSupportFeatured">
                            <label class="form-check-label" for="editSupportFeatured">
                                Jadikan layanan unggulan
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateSupport()">Update</button>
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
<script src="<?= base_url('assets/js/admin/dukungan-edit.js') ?>"></script>
<?= $this->endSection() ?>