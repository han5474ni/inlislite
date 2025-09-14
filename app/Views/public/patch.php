<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<header class="page-header page-header--image page-header--with-overlay page-header--bg-fixed" style="--header-bg-url: url('<?= base_url('assets/images/hero.jpeg') ?>');">
    <div class="page-header__overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center py-4">
                    <div class="page-icon mb-3">
                        <i class="bi bi-arrow-clockwise"></i>
                    </div>
                    <h1 class="page-title page-title--md fw-bold mb-2">Patch & Updater</h1>
                    <p class="page-subtitle page-subtitle--md">Download patch dan update terbaru untuk INLISLite v3. Dapatkan fitur terbaru, perbaikan bug, dan peningkatan keamanan</p>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Patch & Updater</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <!-- Version Status -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h2 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Status Versi
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-6">
                                <div class="version-info p-4 border rounded">
                                    <i class="bi bi-laptop" style="font-size: 3rem; color: #6c757d;"></i>
                                    <h4 class="mt-3 mb-2">Versi Saat Ini</h4>
                                    <h2 class="text-muted"><?= $current_version ?? '3.0.5' ?></h2>
                                    <p class="text-muted">Versi yang terinstall</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="version-info p-4 border rounded border-success">
                                    <i class="bi bi-cloud-download" style="font-size: 3rem; color: #28a745;"></i>
                                    <h4 class="mt-3 mb-2">Versi Terbaru</h4>
                                    <h2 class="text-success"><?= $latest_version ?? '3.0.8' ?></h2>
                                    <p class="text-success">Update tersedia!</p>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (($latest_version ?? '3.0.8') > ($current_version ?? '3.0.5')): ?>
                        <div class="alert alert-info text-center mt-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Update Tersedia!</strong> Versi terbaru <?= $latest_version ?? '3.0.8' ?> telah tersedia dengan fitur baru dan perbaikan.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Patch List -->
        <div class="row">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header">
                        <h3 class="mb-0">
                            <i class="bi bi-list-ul me-2"></i>
                            Daftar Update & Patch
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($patches) && is_array($patches)): ?>
                            <?php foreach ($patches as $index => $patch): ?>
                                <?php
                                    // Map and fallback keys to avoid undefined index notices
                                    $status = $patch['status'] ?? ($index === 0 ? 'latest' : 'stable');
                                    $version = $patch['version'] ?? $patch['versi'] ?? 'N/A';
                                    $type = $patch['type'] ?? $patch['tipe'] ?? 'patch';
                                    $description = $patch['description'] ?? $patch['deskripsi'] ?? '';
                                    $releaseDate = $patch['release_date'] ?? $patch['tanggal_rilis'] ?? null;
                                    $size = $patch['size'] ?? $patch['ukuran'] ?? '';
                                    $features = $patch['features'] ?? $patch['fitur'] ?? [];
                                    if (is_string($features)) {
                                        $features = array_filter(array_map('trim', preg_split('/[\r\n]+/', $features)));
                                    }
                                    $downloadUrl = $patch['download_url'] ?? $patch['url_download'] ?? '#';
                                ?>
                                <div class="patch-item border rounded p-4 mb-4 animate-on-scroll" style="animation-delay: <?= $index * 0.1 ?>s;">
                                    <div class="row align-items-center">
                                        <div class="col-lg-8">
                                            <div class="d-flex align-items-start">
                                                <div class="patch-icon me-3">
                                                    <?php if ($status === 'latest'): ?>
                                                        <i class="bi bi-star-fill text-warning" style="font-size: 1.5rem;"></i>
                                                    <?php else: ?>
                                                        <i class="bi bi-check-circle text-success" style="font-size: 1.5rem;"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="patch-info">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <h4 class="mb-0 me-3">Version <?= esc($version) ?></h4>
                                                        <span class="badge <?= $status === 'latest' ? 'bg-warning' : 'bg-success' ?> me-2">
                                                            <?= $status === 'latest' ? 'Terbaru' : 'Stabil' ?>
                                                        </span>
                                                        <span class="badge bg-secondary">
                                                            <?= esc($type) ?>
                                                        </span>
                                                    </div>
                                                    <p class="text-muted mb-2"><?= esc($description) ?></p>
                                                    <div class="patch-meta">
                                                        <small class="text-muted">
                                                            <i class="bi bi-calendar me-1"></i>
                                                            <?= $releaseDate ? date('d M Y', strtotime($releaseDate)) : '-' ?>
                                                            <span class="mx-2">•</span>
                                                            <i class="bi bi-download me-1"></i>
                                                            <?= esc($size) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Features List -->
                                            <div class="mt-3">
                                                <h6 class="mb-2">Fitur & Perbaikan:</h6>
                                                <ul class="list-unstyled">
                                                    <?php foreach ($features as $feature): ?>
                                                        <li class="mb-1">
                                                            <i class="bi bi-check text-success me-2"></i>
                                                            <?= esc($feature) ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 text-lg-end">
                                            <div class="patch-actions">
                                                <a href="<?= esc($downloadUrl) ?>" class="btn btn-primary-gradient btn-lg mb-2 w-100">
                                                    <i class="bi bi-download me-2"></i>
                                                    Download
                                                </a>
                                                <button class="btn btn-outline-secondary w-100" onclick="showPatchDetails('<?= esc($version) ?>')">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Installation Guide -->
        <div class="row mt-5">
            <div class="col-lg-6">
                <div class="content-card h-100 animate-on-scroll">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-gear me-2"></i>
                            Cara Install Update
                        </h4>
                    </div>
                    <div class="card-body">
                        <ol class="list-group list-group-numbered list-group-flush">
                            <li class="list-group-item border-0 px-0">
                                <strong>Backup Data</strong><br>
                                <small class="text-muted">Lakukan backup database dan file sistem sebelum update</small>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <strong>Download Patch</strong><br>
                                <small class="text-muted">Download file patch sesuai versi yang diinginkan</small>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <strong>Extract File</strong><br>
                                <small class="text-muted">Extract file patch ke direktori instalasi INLISLite</small>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <strong>Jalankan Updater</strong><br>
                                <small class="text-muted">Akses halaman admin dan jalankan proses update</small>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <strong>Verifikasi</strong><br>
                                <small class="text-muted">Pastikan sistem berjalan normal setelah update</small>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="content-card h-100 animate-on-scroll">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Peringatan Penting
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="bi bi-shield-exclamation me-2"></i>
                            <strong>Backup Wajib!</strong> Selalu lakukan backup sebelum update.
                        </div>
                        
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Kompatibilitas:</strong> Pastikan server memenuhi system requirements
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Maintenance Mode:</strong> Aktifkan mode maintenance selama update
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Testing:</strong> Test di environment staging terlebih dahulu
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Rollback Plan:</strong> Siapkan rencana rollback jika terjadi masalah
                            </li>
                        </ul>
                        
                        <div class="mt-3">
                            <a href="<?= base_url('panduan') ?>" class="btn btn-outline-primary">
                                <i class="bi bi-book me-2"></i>
                                Panduan Lengkap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-body text-center">
                        <h3 class="mb-3">Butuh Bantuan?</h3>
                        <p class="lead mb-4">
                            Tim support kami siap membantu proses update dan mengatasi masalah yang mungkin terjadi.
                        </p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="<?= base_url('dukungan') ?>" class="btn btn-primary-gradient">
                                <i class="bi bi-headset me-2"></i>
                                Dukungan Teknis
                            </a>
                            <a href="<?= base_url('bimbingan') ?>" class="btn btn-secondary-gradient">
                                <i class="bi bi-mortarboard me-2"></i>
                                Bimbingan Teknis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Patch Details Modal -->
<div class="modal fade" id="patchDetailsModal" tabindex="-1" aria-labelledby="patchDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patchDetailsModalLabel">Detail Patch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="patchDetailsContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary-gradient" id="downloadPatchBtn">
                    <i class="bi bi-download me-2"></i>
                    Download
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showPatchDetails(version) {
    // Show modal with patch details
    const modal = new bootstrap.Modal(document.getElementById('patchDetailsModal'));
    document.getElementById('patchDetailsModalLabel').textContent = `Detail Patch Version ${version}`;
    
    // Load patch details (this would typically be an AJAX call)
    document.getElementById('patchDetailsContent').innerHTML = `
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memuat detail patch...</p>
        </div>
    `;
    
    modal.show();
    
    // Simulate loading patch details
    setTimeout(() => {
        document.getElementById('patchDetailsContent').innerHTML = `
            <h6>Informasi Patch Version ${version}</h6>
            <p>Detail lengkap tentang patch ini akan ditampilkan di sini, termasuk:</p>
            <ul>
                <li>Changelog lengkap</li>
                <li>File yang diubah</li>
                <li>Instruksi instalasi khusus</li>
                <li>Known issues</li>
                <li>Compatibility notes</li>
            </ul>
        `;
    }, 1000);
}
</script>

<?= $this->endSection() ?>