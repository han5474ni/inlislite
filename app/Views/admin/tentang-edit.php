<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<!-- Page CSS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-table-theme.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-fixes.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/tentang-edit.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Tentang Inlislite Versi 3',
    'subtitle' => 'Informasi lengkap tentang sistem otomasi perpustakaan',
    'icon' => 'book',
    'backUrl' => base_url('admin'),
    'bg' => 'green',
    'actionUrl' => base_url('admin/tentang'),
    'actionText' => 'Lihat',
    'actionIcon' => 'eye',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div class="container-fluid px-0">
    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover table-striped table-sm align-middle table-admin table-theme-green" id="cardsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Icon</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Add Card Modal -->
<div class="modal fade" id="addCardModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kartu Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addCardForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cardTitle" class="form-label">Judul Kartu *</label>
                                <input type="text" class="form-control" id="cardTitle" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cardSubtitle" class="form-label">Subtitle</label>
                                <input type="text" class="form-control" id="cardSubtitle">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="cardContent" class="form-label">Konten *</label>
                        <textarea class="form-control" id="cardContent" rows="5" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cardCategory" class="form-label">Kategori *</label>
                                <select class="form-select" id="cardCategory" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="info">Info</option>
                                    <option value="feature">Feature</option>
                                    <option value="contact">Contact</option>
                                    <option value="technical">Technical</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cardIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                <input type="text" class="form-control" id="cardIcon" placeholder="bi-info-circle">
                                <div class="form-text">Contoh: bi-info-circle, bi-star, bi-gear</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Preview Icon</label>
                                <div class="icon-preview" id="cardIconPreview">
                                    <i class="bi bi-question-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="cardStatus" class="form-label">Status</label>
                                <select class="form-select" id="cardStatus">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveCard()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kartu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editId">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editTitle" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="editTitle" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSubtitle" class="form-label">Subtitle</label>
                                <input type="text" class="form-control" id="editSubtitle">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editContent" class="form-label">Konten</label>
                        <textarea class="form-control" id="editContent" rows="5" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editCategory" class="form-label">Kategori</label>
                                <select class="form-select" id="editCategory" required>
                                    <option value="info">Info</option>
                                    <option value="feature">Feature</option>
                                    <option value="contact">Contact</option>
                                    <option value="technical">Technical</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                <input type="text" class="form-control" id="editIcon">
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="editStatus" class="form-label">Status</label>
                                <select class="form-select" id="editStatus">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateCard()">Update</button>
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
<script src="<?= base_url('assets/js/admin/tentang-edit.js') ?>"></script>
<?= $this->endSection() ?>
