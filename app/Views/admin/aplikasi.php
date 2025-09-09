<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<link href="<?= base_url('assets/css/admin/aplikasi.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Aplikasi Pendukung',
    'subtitle' => 'Tools dan utilitas pendukung',
    'icon' => 'tools',
    'backUrl' => base_url('admin'),
    'bg' => 'green',
    'actionUrl' => base_url('admin/aplikasi-edit'),
    'actionText' => 'Kelola',
    'actionIcon' => 'sliders',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-container">
    <div class="container">




        <!-- Content Section -->
        <section class="content-section">
            <div class="row g-4" id="contentContainer"></div>
        </section>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="editTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSubtitle" class="form-label">Subtitle</label>
                        <input type="text" class="form-control" id="editSubtitle">
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editDescription" rows="4" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editCategory" class="form-label">Kategori</label>
                                <select class="form-select" id="editCategory">
                                    <option value="general">Umum</option>
                                    <option value="technical">Teknis</option>
                                    <option value="tutorial">Tutorial</option>
                                    <option value="update">Update</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editPriority" class="form-label">Prioritas</label>
                                <select class="form-select" id="editPriority">
                                    <option value="low">Rendah</option>
                                    <option value="medium">Sedang</option>
                                    <option value="high">Tinggi</option>
                                </select>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/admin/aplikasi.js') ?>"></script>
<?= $this->endSection() ?>
