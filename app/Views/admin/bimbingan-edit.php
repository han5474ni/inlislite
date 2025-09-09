<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<!-- Page CSS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-fixes.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/bimbingan-edit.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Manajemen Bimbingan Teknis',
    'subtitle' => 'Kelola program pelatihan dan bimbingan teknis',
    'icon' => 'mortarboard',
    'backUrl' => base_url('admin/bimbingan'),
    'bg' => 'green',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div class="container-fluid px-0 page-bimbingan">
    <!-- Statistics Cards removed -->

    <!-- Simplified: remove tabs header and borders -->
    <div class="panel-content">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="panel-title m-0">Manajemen Program Bimbingan</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTrainingModal">
                <i class="bi bi-plus-circle me-2"></i>Tambah Bimbingan
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-sm align-middle table-admin table-theme-green" id="trainingTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Program</th>
                        <th>Kategori</th>
                        <th>Tipe</th>
                        <th>Jadwal</th>
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
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Bimbingan Edit page loaded');
    });
</script>
<?= $this->endSection() ?>