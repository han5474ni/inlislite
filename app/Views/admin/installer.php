<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<link href="<?= base_url('assets/css/admin/installer.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Installer INLISLite',
    'subtitle' => 'Paket unduhan dan instalasi sistem perpustakaan',
    'icon' => 'download',
    'backUrl' => base_url('admin'),
    'bg' => 'green',
    'actionUrl' => base_url('admin/installer-edit'),
    'actionText' => 'Kelola',
    'actionIcon' => 'sliders',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-container">
    <div class="container">




        <!-- Content Section -->
        <section class="content-section">

            <div class="row g-4" id="contentContainer">
                <!-- Example cards kept from original content (trimmed for brevity) -->
                <div class="col-lg-6 col-md-6">
                    <div class="content-card">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div class="card-actions">
                                <button class="btn-action edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn-action delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">INLISLite v3.0 Full Package</h3>
                            <p class="card-subtitle">Complete Installation Package • 25 MB • v3.0.0</p>
                            <p class="card-description">
                                Paket lengkap instalasi INLISLite v3.0 dengan semua fitur dan dokumentasi lengkap untuk instalasi baru sistem perpustakaan.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="content-card">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="bi bi-code-slash"></i>
                            </div>
                            <div class="card-actions">
                                <button class="btn-action edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn-action delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">INLISLite v3.0 Source Code</h3>
                            <p class="card-subtitle">Source Code Only • 15 MB • v3.0.0</p>
                            <p class="card-description">
                                Source code INLISLite v3.0 untuk developer dan customization tanpa installer. Cocok untuk pengembangan dan modifikasi sistem.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/admin/installer.js') ?>"></script>
<?= $this->endSection() ?>
