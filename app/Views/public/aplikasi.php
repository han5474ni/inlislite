<?= view('public/layout/header', ['page_title' => $page_title ?? 'Aplikasi Pendukung']) ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <div class="page-icon">
                        <i class="bi bi-app"></i>
                    </div>
                    <h1 class="page-title">Aplikasi Pendukung</h1>
                    <p class="page-subtitle">
                        Download aplikasi pendukung dan tools untuk INLISLite v3. Tingkatkan produktivitas dengan aplikasi tambahan yang terintegrasi
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Aplikasi Pendukung</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <!-- Introduction -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="content-card animate-on-scroll">
                    <div class="card-body text-center">
                        <h2 class="mb-3">Ekosistem Aplikasi INLISLite</h2>
                        <p class="lead">
                            Kumpulan aplikasi pendukung yang dirancang khusus untuk melengkapi dan meningkatkan fungsionalitas INLISLite v3. 
                            Semua aplikasi terintegrasi sempurna dengan sistem utama.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Applications Grid -->
        <div class="row g-4">
            <?php if (isset($applications) && is_array($applications)): ?>
                <?php foreach ($applications as $index => $app): ?>
                    <div class="col-lg-6">
                        <div class="content-card h-100 animate-on-scroll" style="animation-delay: <?= $index * 0.1 ?>s;">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div class="app-icon me-3">
                                        <i class="<?= $app['icon'] ?>" style="font-size: 2.5rem; color: #667eea;"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-1"><?= esc($app['name']) ?></h4>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2">v<?= esc($app['version']) ?></span>
                                            <span class="badge bg-secondary"><?= esc($app['platform']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3"><?= esc($app['description']) ?></p>
                                
                                <!-- Features -->
                                <h6 class="mb-2">Fitur Utama:</h6>
                                <ul class="list-unstyled mb-3">
                                    <?php foreach ($app['features'] as $feature): ?>
                                        <li class="mb-1">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <?= esc($feature) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                
                                <!-- App Info -->
                                <div class="app-info bg-light p-3 rounded mb-3">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <i class="bi bi-download text-primary"></i>
                                            <div class="small text-muted">Size</div>
                                            <div class="fw-bold"><?= esc($app['size']) ?></div>
                                        </div>
                                        <div class="col-4">
                                            <i class="bi bi-laptop text-success"></i>
                                            <div class="small text-muted">Platform</div>
                                            <div class="fw-bold"><?= esc($app['platform']) ?></div>
                                        </div>
                                        <div class="col-4">
                                            <i class="bi bi-star text-warning"></i>
                                            <div class="small text-muted">Version</div>
                                            <div class="fw-bold"><?= esc($app['version']) ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Download Button -->
                                <div class="d-grid gap-2">
                                    <a href="<?= esc($app['download_url']) ?>" class="btn btn-primary-gradient btn-lg">
                                        <i class="bi bi-download me-2"></i>
                                        Download Sekarang
                                    </a>
                                    <button class="btn btn-outline-secondary" onclick="showAppDetails('<?= esc($app['name']) ?>')">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Detail & Screenshot
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- System Requirements -->
        <div class="row mt-5">
            <div class="col-lg-6">
                <div class="content-card h-100 animate-on-scroll">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-cpu me-2"></i>
                            System Requirements
                        </h4>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-3">Desktop Applications:</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-windows text-primary me-2"></i>
                                <strong>Windows:</strong> 10/11 (64-bit)
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-memory text-success me-2"></i>
                                <strong>RAM:</strong> Minimum 4GB
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-hdd text-warning me-2"></i>
                                <strong>Storage:</strong> 500MB free space
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-wifi text-info me-2"></i>
                                <strong>Network:</strong> Internet connection
                            </li>
                        </ul>
                        
                        <h6 class="mb-3 mt-4">Mobile Applications:</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-android text-success me-2"></i>
                                <strong>Android:</strong> 6.0+ (API level 23)
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-apple text-dark me-2"></i>
                                <strong>iOS:</strong> 12.0+
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-memory text-primary me-2"></i>
                                <strong>RAM:</strong> Minimum 2GB
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="content-card h-100 animate-on-scroll">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-question-circle me-2"></i>
                            FAQ Aplikasi
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item border-0 mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        Apakah aplikasi gratis?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Ya, semua aplikasi pendukung INLISLite v3 dapat didownload dan digunakan secara gratis.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        Bagaimana cara instalasi?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Setiap aplikasi dilengkapi dengan installer otomatis dan panduan instalasi step-by-step.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        Apakah perlu koneksi internet?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Beberapa aplikasi dapat bekerja offline, namun untuk sinkronisasi data diperlukan koneksi internet.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                        Bagaimana cara update aplikasi?
                                    </button>
                                </h2>
                                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Aplikasi akan memberikan notifikasi otomatis ketika ada update tersedia dan dapat diupdate dengan sekali klik.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Installation Guide -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-gear me-2"></i>
                            Panduan Instalasi
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="text-center">
                                    <div class="step-icon mb-3">
                                        <i class="bi bi-download" style="font-size: 3rem; color: #667eea;"></i>
                                    </div>
                                    <h5>1. Download</h5>
                                    <p class="text-muted">Download aplikasi sesuai platform yang digunakan</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="text-center">
                                    <div class="step-icon mb-3">
                                        <i class="bi bi-gear" style="font-size: 3rem; color: #28a745;"></i>
                                    </div>
                                    <h5>2. Install</h5>
                                    <p class="text-muted">Jalankan installer dan ikuti petunjuk instalasi</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="text-center">
                                    <div class="step-icon mb-3">
                                        <i class="bi bi-link-45deg" style="font-size: 3rem; color: #ffc107;"></i>
                                    </div>
                                    <h5>3. Konfigurasi</h5>
                                    <p class="text-muted">Hubungkan dengan server INLISLite v3</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="text-center">
                                    <div class="step-icon mb-3">
                                        <i class="bi bi-check-circle" style="font-size: 3rem; color: #dc3545;"></i>
                                    </div>
                                    <h5>4. Selesai</h5>
                                    <p class="text-muted">Aplikasi siap digunakan dan terintegrasi</p>
                                </div>
                            </div>
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
                        <h3 class="mb-3">Butuh Bantuan Instalasi?</h3>
                        <p class="lead mb-4">
                            Tim support kami siap membantu proses instalasi dan konfigurasi aplikasi pendukung.
                        </p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="<?= base_url('panduan') ?>" class="btn btn-primary-gradient">
                                <i class="bi bi-book me-2"></i>
                                Panduan Lengkap
                            </a>
                            <a href="<?= base_url('dukungan') ?>" class="btn btn-secondary-gradient">
                                <i class="bi bi-headset me-2"></i>
                                Dukungan Teknis
                            </a>
                            <a href="<?= base_url('bimbingan') ?>" class="btn btn-outline-primary">
                                <i class="bi bi-mortarboard me-2"></i>
                                Pelatihan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- App Details Modal -->
<div class="modal fade" id="appDetailsModal" tabindex="-1" aria-labelledby="appDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appDetailsModalLabel">Detail Aplikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="appDetailsContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary-gradient" id="downloadAppBtn">
                    <i class="bi bi-download me-2"></i>
                    Download
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showAppDetails(appName) {
    const modal = new bootstrap.Modal(document.getElementById('appDetailsModal'));
    document.getElementById('appDetailsModalLabel').textContent = `Detail ${appName}`;
    
    // Show loading
    document.getElementById('appDetailsContent').innerHTML = `
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memuat detail aplikasi...</p>
        </div>
    `;
    
    modal.show();
    
    // Simulate loading app details
    setTimeout(() => {
        document.getElementById('appDetailsContent').innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Screenshot Aplikasi</h6>
                    <div class="bg-light p-4 rounded text-center">
                        <i class="bi bi-image" style="font-size: 4rem; color: #ccc;"></i>
                        <p class="text-muted mt-2">Screenshot akan ditampilkan di sini</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6>Informasi Detail</h6>
                    <p>Detail lengkap tentang ${appName} termasuk:</p>
                    <ul>
                        <li>Fitur lengkap dan cara penggunaan</li>
                        <li>System requirements detail</li>
                        <li>Changelog dan update history</li>
                        <li>Tutorial dan dokumentasi</li>
                        <li>Known issues dan troubleshooting</li>
                    </ul>
                    
                    <h6 class="mt-4">Statistik Download</h6>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="fw-bold text-primary">1,234</div>
                            <small class="text-muted">Downloads</small>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-success">4.8/5</div>
                            <small class="text-muted">Rating</small>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-warning">v1.2.0</div>
                            <small class="text-muted">Latest</small>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }, 1000);
}
</script>

<?= view('public/layout/footer') ?>