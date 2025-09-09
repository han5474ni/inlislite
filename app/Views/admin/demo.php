<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<!-- Page CSS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-fixes.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/demo-edit.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Demo Program',
    'subtitle' => 'Kelola demo program perpustakaan',
    'icon' => 'play-circle',
    'backUrl' => base_url('admin'),
    'bg' => 'green',
    'actionUrl' => base_url('admin/demo'),
    'actionText' => 'Muat Ulang',
    'actionIcon' => 'arrow-clockwise',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0 page-demo">
    <!-- Statistics Cards removed -->

    <!-- Table -->
    <div class="panel-content">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-sm align-middle table-admin table-theme-green" id="demoTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tipe</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
<script src="<?= base_url('assets/js/admin/demo-edit.js') ?>"></script>
<?= $this->endSection() ?>