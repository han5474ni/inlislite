<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<!-- Page CSS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-table-theme.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-fixes.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/panduan-edit.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Manajemen Panduan',
    'subtitle' => 'Kelola dokumentasi dan panduan sistem',
    'icon' => 'book',
    'backUrl' => base_url('admin/panduan'),
    'bg' => 'green',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div class="container-fluid px-0 page-panduan">
    <!-- Statistics Cards removed as requested -->

    <!-- Simplified content: remove tabs header and borders -->
    <div class="panel-content">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="panel-title m-0">Manajemen Dokumen Panduan</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGuideModal">
                <i class="bi bi-plus-circle me-2"></i>Tambah Panduan
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-sm align-middle table-admin table-theme-green" id="guidesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Panduan</th>
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

<!-- Add Guide Modal -->
<div class="modal fade" id="addGuideModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Panduan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addGuideForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="guideTitle" class="form-label">Judul Panduan *</label>
                                <input type="text" class="form-control" id="guideTitle" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="guideSubtitle" class="form-label">Subtitle</label>
                                <input type="text" class="form-control" id="guideSubtitle">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="guideDescription" class="form-label">Deskripsi *</label>
                        <textarea class="form-control" id="guideDescription" rows="4" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="guideCategory" class="form-label">Kategori *</label>
                                <select class="form-select" id="guideCategory" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="installation">Installation</option>
                                    <option value="configuration">Configuration</option>
                                    <option value="user_guide">User Guide</option>
                                    <option value="technical">Technical</option>
                                    <option value="api">API Documentation</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="guideFileType" class="form-label">Tipe File</label>
                                <select class="form-select" id="guideFileType">
                                    <option value="pdf">PDF</option>
                                    <option value="doc">DOC</option>
                                    <option value="docx">DOCX</option>
                                    <option value="html">HTML</option>
                                    <option value="video">Video</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="guideLanguage" class="form-label">Bahasa</label>
                                <select class="form-select" id="guideLanguage">
                                    <option value="id">Indonesia</option>
                                    <option value="en">English</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="guideIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                <input type="text" class="form-control" id="guideIcon" placeholder="bi-book">
                                <div class="form-text">Contoh: bi-book, bi-file-text, bi-play</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Preview Icon</label>
                                <div class="icon-preview" id="guideIconPreview">
                                    <i class="bi bi-question-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="guideStatus" class="form-label">Status</label>
                                <select class="form-select" id="guideStatus">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="guideVersion" class="form-label">Versi</label>
                                <input type="text" class="form-control" id="guideVersion" placeholder="3.0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="guideFileSize" class="form-label">Ukuran File</label>
                                <input type="text" class="form-control" id="guideFileSize" placeholder="2.5 MB">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="guideSortOrder" class="form-label">Urutan Tampil</label>
                                <input type="number" class="form-control" id="guideSortOrder" min="1" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="guideFileUrl" class="form-label">URL File</label>
                        <input type="url" class="form-control" id="guideFileUrl" placeholder="https://example.com/guide.pdf">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveGuide()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Guide Modal -->
<div class="modal fade" id="editGuideModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Panduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editGuideForm">
                    <input type="hidden" id="editGuideId">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editGuideTitle" class="form-label">Judul Panduan</label>
                                <input type="text" class="form-control" id="editGuideTitle" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editGuideSubtitle" class="form-label">Subtitle</label>
                                <input type="text" class="form-control" id="editGuideSubtitle">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editGuideDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editGuideDescription" rows="4" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editGuideCategory" class="form-label">Kategori</label>
                                <select class="form-select" id="editGuideCategory" required>
                                    <option value="installation">Installation</option>
                                    <option value="configuration">Configuration</option>
                                    <option value="user_guide">User Guide</option>
                                    <option value="technical">Technical</option>
                                    <option value="api">API Documentation</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editGuideFileType" class="form-label">Tipe File</label>
                                <select class="form-select" id="editGuideFileType">
                                    <option value="pdf">PDF</option>
                                    <option value="doc">DOC</option>
                                    <option value="docx">DOCX</option>
                                    <option value="html">HTML</option>
                                    <option value="video">Video</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editGuideLanguage" class="form-label">Bahasa</label>
                                <select class="form-select" id="editGuideLanguage">
                                    <option value="id">Indonesia</option>
                                    <option value="en">English</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editGuideIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                <input type="text" class="form-control" id="editGuideIcon">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Preview Icon</label>
                                <div class="icon-preview" id="editGuideIconPreview">
                                    <i class="bi bi-question-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editGuideStatus" class="form-label">Status</label>
                                <select class="form-select" id="editGuideStatus">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editGuideVersion" class="form-label">Versi</label>
                                <input type="text" class="form-control" id="editGuideVersion">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editGuideFileSize" class="form-label">Ukuran File</label>
                                <input type="text" class="form-control" id="editGuideFileSize">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editGuideSortOrder" class="form-label">Urutan Tampil</label>
                                <input type="number" class="form-control" id="editGuideSortOrder" min="1" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editGuideFileUrl" class="form-label">URL File</label>
                        <input type="url" class="form-control" id="editGuideFileUrl">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateGuide()">Update</button>
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
<script src="<?= base_url('assets/js/admin/panduan-edit.js') ?>"></script>
<?= $this->endSection() ?>