<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-table-theme.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/aplikasi-edit.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<div class="container-fluid px-2 py-3">
<?= view('admin/components/page_header', [
    'title' => 'Manajemen Aplikasi Pendukung',
    'subtitle' => 'Kelola aplikasi dan tools pendukung sistem',
    'icon' => 'app-indicator',
    'backUrl' => base_url('admin/aplikasi'),
    'bg' => 'green',
]) ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">


        <div class="content-toolbar d-flex align-items-center justify-content-end gap-2 mb-2 px-2">
            <button type="button" class="btn btn-success" id="btnAddApp">
                <i class="bi bi-plus-lg me-1"></i>Tambah
            </button>
        </div>

        <!-- Tambah Aplikasi Card (hidden by default) -->
        <div id="addAppCard" class="card shadow-sm border-0 mb-3 d-none">
            <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between">
                <h6 class="mb-0">Tambah Aplikasi</h6>
                <button type="button" class="btn btn-sm btn-link text-muted" id="btnCloseAddApp">Tutup</button>
            </div>
            <div class="card-body pt-0">
                <form id="addAppForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Aplikasi *</label>
                            <input type="text" class="form-control" id="appTitle" placeholder="Contoh: INLISLite Backup Tool" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subjudul</label>
                            <input type="text" class="form-control" id="appSubtitle" placeholder="Contoh: Database Backup Utility">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Deskripsi *</label>
                            <textarea class="form-control" id="appDescription" rows="3" required placeholder="Jelaskan fungsi singkat aplikasi"></textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Kategori *</label>
                            <select class="form-select" id="appCategory" required>
                                <option value="utility">Utility</option>
                                <option value="tool">Tool</option>
                                <option value="plugin">Plugin</option>
                                <option value="addon">Add-on</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Versi</label>
                            <input type="text" class="form-control" id="appVersion" placeholder="mis. 1.0.0">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Ikon (Bootstrap Icons)</label>
                            <div class="input-group">
                                <span class="input-group-text" id="appIconPreview"><i class="bi bi-question-circle"></i></span>
                                <input type="text" class="form-control" id="appIcon" placeholder="mis. bi-database atau database">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Ukuran File</label>
                            <input type="text" class="form-control" id="appFileSize" placeholder="mis. 3.2 MB">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">URL Unduhan</label>
                            <input type="url" class="form-control" id="appDownloadUrl" placeholder="https://...">
                        </div>


                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button type="button" class="btn btn-outline-secondary" id="btnCancelAdd">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Management Tabs -->
        <div class="management-tabs">
            <!-- Panel tunggal tanpa tab/toolbar judul -->
            <div class="tab-content" id="managementTabsContent">
                <div class="tab-pane fade show active" id="apps-panel" role="tabpanel">
                    <div class="panel-content">
                        <div class="table-responsive" style="padding:0;">
                            <table class="table table-hover table-striped table-sm align-middle table-admin table-theme-green mb-0 w-100" id="appsTable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Icon</th>
                                        <th>Aplikasi</th>
                                        <th>Versi</th>
                                        <th>Unduhan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Ensure jQuery is loaded before DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url('assets/js/admin/aplikasi-edit.js') ?>"></script>
<?= $this->endSection() ?>
