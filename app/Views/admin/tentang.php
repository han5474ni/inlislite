<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<!-- Konsolidasi gaya: gunakan Bootstrap + admin-base, kurangi inline styles untuk tampilan minimalis -->
<link href="<?= base_url('assets/css/admin/tentang.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Tentang Inlislite Versi 3',
    'subtitle' => 'Informasi lengkap tentang sistem otomasi perpustakaan',
    'icon' => 'book',
    'backUrl' => base_url('admin'),
    'bg' => 'green',
    'actionUrl' => base_url('admin/tentang-edit'),
    'actionText' => 'Kelola',
    'actionIcon' => 'sliders',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-container">
    <div class="container px-3 py-4">




        <!-- System Information Section -->
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3 gap-2 flex-wrap">
                <h2 class="h5 mb-0 text-dark">Informasi Sistem</h2>

            </div>
            <div class="row g-3" id="contentContainer">
                <!-- System Info Card 1 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card-minimal p-4 h-100">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px;height:40px;background:linear-gradient(135deg,#3b82f6,#2563eb);">
                                <i class="bi bi-shield-check text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="fw-semibold small mb-2">Keamanan Data</h3>
                                <p class="text-muted small mb-3">Sistem keamanan berlapis untuk melindungi data perpustakaan dengan enkripsi dan backup otomatis.</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-success-subtle text-success">Aktif</span>
                                    </div>
                                    <button class="btn btn-link p-0 small">Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- System Info Card 2 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card-minimal p-4 h-100">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px;height:40px;background:linear-gradient(135deg,#fb923c,#f97316);">
                                <i class="bi bi-phone text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="fw-semibold small mb-2">Multi-Platform</h3>
                                <p class="text-muted small mb-3">Dapat diakses melalui desktop, tablet, dan smartphone dengan antarmuka yang responsif.</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-success-subtle text-success">Aktif</span>
                                    </div>
                                    <button class="btn btn-link p-0 small">Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- System Info Card 3 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card-minimal p-4 h-100">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px;height:40px;background:linear-gradient(135deg,#14b8a6,#0d9488);">
                                <i class="bi bi-graph-up text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="fw-semibold small mb-2">Laporan & Analitik</h3>
                                <p class="text-muted small mb-3">Dashboard analitik dengan berbagai laporan statistik dan visualisasi data perpustakaan.</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-success-subtle text-success">Aktif</span>
                                    </div>
                                    <button class="btn btn-link p-0 small">Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/admin/tentang.js') ?>"></script>
<?= $this->endSection() ?>
