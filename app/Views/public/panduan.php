<?= view('public/layout/header', ['page_title' => $page_title ?? 'Panduan']) ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <div class="page-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <h1 class="page-title">Panduan</h1>
                    <p class="page-subtitle">
                        Panduan lengkap instalasi, konfigurasi, dan penggunaan INLISLite v3. Tutorial step-by-step untuk pemula hingga advanced
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
                <li class="breadcrumb-item active" aria-current="page">Panduan</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <!-- Quick Start -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h2 class="mb-0">
                            <i class="bi bi-rocket me-2"></i>
                            Quick Start Guide
                        </h2>
                    </div>
                    <div class="card-body">
                        <p class="lead text-center mb-4">
                            Mulai menggunakan INLISLite v3 dalam 4 langkah mudah
                        </p>
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="text-center">
                                    <div class="quick-step-icon mb-3">
                                        <i class="bi bi-download" style="font-size: 2.5rem; color: #667eea;"></i>
                                    </div>
                                    <h6>1. Download</h6>
                                    <p class="small text-muted">Download installer INLISLite v3</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="text-center">
                                    <div class="quick-step-icon mb-3">
                                        <i class="bi bi-gear" style="font-size: 2.5rem; color: #28a745;"></i>
                                    </div>
                                    <h6>2. Install</h6>
                                    <p class="small text-muted">Jalankan proses instalasi</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="text-center">
                                    <div class="quick-step-icon mb-3">
                                        <i class="bi bi-sliders" style="font-size: 2.5rem; color: #ffc107;"></i>
                                    </div>
                                    <h6>3. Konfigurasi</h6>
                                    <p class="small text-muted">Setup konfigurasi dasar</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="text-center">
                                    <div class="quick-step-icon mb-3">
                                        <i class="bi bi-play-circle" style="font-size: 2.5rem; color: #dc3545;"></i>
                                    </div>
                                    <h6>4. Mulai</h6>
                                    <p class="small text-muted">Sistem siap digunakan</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="#installation" class="btn btn-primary-gradient">
                                <i class="bi bi-arrow-down me-2"></i>
                                Mulai Instalasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guide Categories -->
        <?php if (isset($guides) && is_array($guides)): ?>
            <?php foreach ($guides as $index => $category): ?>
                <div class="row mb-5" id="<?= strtolower($category['category']) ?>">
                    <div class="col-12">
                        <div class="content-card animate-on-scroll" style="animation-delay: <?= $index * 0.1 ?>s;">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div class="category-icon me-3">
                                        <i class="<?= $category['icon'] ?>" style="font-size: 2.5rem; color: #667eea;"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-1"><?= esc($category['title']) ?></h3>
                                        <p class="mb-0 opacity-75">Panduan <?= strtolower($category['title']) ?> INLISLite v3</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <?php foreach ($category['guides'] as $guide): ?>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="guide-item border rounded p-4 h-100">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <h5 class="mb-0"><?= esc($guide['title']) ?></h5>
                                                    <span class="badge <?= $guide['difficulty'] === 'Beginner' ? 'bg-success' : ($guide['difficulty'] === 'Intermediate' ? 'bg-warning' : 'bg-danger') ?>">
                                                        <?= esc($guide['difficulty']) ?>
                                                    </span>
                                                </div>
                                                <p class="text-muted mb-3"><?= esc($guide['description']) ?></p>
                                                <div class="guide-meta mb-3">
                                                    <div class="d-flex align-items-center text-muted small">
                                                        <i class="bi bi-clock me-1"></i>
                                                        <span class="me-3"><?= esc($guide['duration']) ?></span>
                                                        <i class="bi bi-bar-chart me-1"></i>
                                                        <span><?= esc($guide['difficulty']) ?></span>
                                                    </div>
                                                </div>
                                                <div class="d-grid">
                                                    <a href="<?= esc($guide['url']) ?>" class="btn btn-outline-primary">
                                                        <i class="bi bi-book me-2"></i>
                                                        Baca Panduan
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Video Tutorials -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-play-btn me-2"></i>
                            Video Tutorial
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6">
                                <div class="video-item">
                                    <div class="video-thumbnail bg-light rounded mb-3" style="height: 200px; position: relative;">
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="bi bi-play-circle" style="font-size: 4rem; color: #667eea;"></i>
                                        </div>
                                        <div class="video-duration position-absolute bottom-0 end-0 bg-dark text-white px-2 py-1 m-2 rounded">
                                            15:30
                                        </div>
                                    </div>
                                    <h6>Instalasi INLISLite v3</h6>
                                    <p class="text-muted small">Tutorial lengkap instalasi dari awal hingga selesai</p>
                                    <button class="btn btn-sm btn-outline-primary" onclick="playVideo('install')">
                                        <i class="bi bi-play me-1"></i>
                                        Tonton
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="video-item">
                                    <div class="video-thumbnail bg-light rounded mb-3" style="height: 200px; position: relative;">
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="bi bi-play-circle" style="font-size: 4rem; color: #28a745;"></i>
                                        </div>
                                        <div class="video-duration position-absolute bottom-0 end-0 bg-dark text-white px-2 py-1 m-2 rounded">
                                            22:45
                                        </div>
                                    </div>
                                    <h6>Konfigurasi Sistem</h6>
                                    <p class="text-muted small">Panduan konfigurasi dasar dan advanced setting</p>
                                    <button class="btn btn-sm btn-outline-primary" onclick="playVideo('config')">
                                        <i class="bi bi-play me-1"></i>
                                        Tonton
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="video-item">
                                    <div class="video-thumbnail bg-light rounded mb-3" style="height: 200px; position: relative;">
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="bi bi-play-circle" style="font-size: 4rem; color: #ffc107;"></i>
                                        </div>
                                        <div class="video-duration position-absolute bottom-0 end-0 bg-dark text-white px-2 py-1 m-2 rounded">
                                            18:20
                                        </div>
                                    </div>
                                    <h6>Penggunaan Dasar</h6>
                                    <p class="text-muted small">Tutorial penggunaan fitur-fitur utama sistem</p>
                                    <button class="btn btn-sm btn-outline-primary" onclick="playVideo('usage')">
                                        <i class="bi bi-play me-1"></i>
                                        Tonton
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-question-circle me-2"></i>
                            Frequently Asked Questions
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        Bagaimana cara menginstall INLISLite v3?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Untuk menginstall INLISLite v3, ikuti langkah-langkah berikut:</p>
                                        <ol>
                                            <li>Download installer dari halaman aplikasi</li>
                                            <li>Pastikan server memenuhi system requirements</li>
                                            <li>Jalankan installer dan ikuti wizard instalasi</li>
                                            <li>Konfigurasi database dan setting dasar</li>
                                            <li>Akses sistem melalui web browser</li>
                                        </ol>
                                        <a href="#installation" class="btn btn-sm btn-primary-gradient">Panduan Detail</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        Apa saja system requirements yang diperlukan?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p><strong>Server Requirements:</strong></p>
                                        <ul>
                                            <li>Operating System: Linux/Windows Server</li>
                                            <li>Web Server: Apache/Nginx</li>
                                            <li>Database: MySQL 5.7+ atau PostgreSQL 10+</li>
                                            <li>PHP: Version 8.0 atau lebih tinggi</li>
                                            <li>Memory: Minimum 4GB RAM</li>
                                            <li>Storage: Minimum 20GB free space</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        Bagaimana cara backup dan restore data?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>INLISLite v3 menyediakan fitur backup otomatis dan manual:</p>
                                        <ul>
                                            <li><strong>Backup Otomatis:</strong> Dapat dijadwalkan harian/mingguan</li>
                                            <li><strong>Backup Manual:</strong> Melalui menu Administrasi > Backup</li>
                                            <li><strong>Restore:</strong> Upload file backup melalui menu Restore</li>
                                        </ul>
                                        <p>Backup mencakup database dan file sistem.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                        Bagaimana cara migrasi dari sistem lama?
                                    </button>
                                </h2>
                                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Tersedia tool migrasi data yang mendukung:</p>
                                        <ul>
                                            <li>Import dari Excel/CSV</li>
                                            <li>Migrasi dari INLISLite versi sebelumnya</li>
                                            <li>Import dari sistem perpustakaan lain</li>
                                            <li>Validasi data otomatis</li>
                                        </ul>
                                        <a href="<?= base_url('aplikasi') ?>" class="btn btn-sm btn-outline-primary">Download Migration Tool</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                        Dimana bisa mendapat bantuan jika ada masalah?
                                    </button>
                                </h2>
                                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Anda dapat mendapat bantuan melalui:</p>
                                        <ul>
                                            <li><strong>Dukungan Teknis:</strong> Email, live chat, atau telepon</li>
                                            <li><strong>Forum Komunitas:</strong> Diskusi dengan pengguna lain</li>
                                            <li><strong>Dokumentasi:</strong> Panduan lengkap online</li>
                                            <li><strong>Pelatihan:</strong> Workshop dan bimbingan teknis</li>
                                        </ul>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <a href="<?= base_url('dukungan') ?>" class="btn btn-sm btn-primary-gradient">Dukungan Teknis</a>
                                            <a href="<?= base_url('bimbingan') ?>" class="btn btn-sm btn-outline-primary">Pelatihan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Download Resources -->
        <div class="row">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-download me-2"></i>
                            Download Resources
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-lg-3 col-md-6">
                                <div class="resource-item text-center p-4 border rounded">
                                    <i class="bi bi-file-pdf text-danger" style="font-size: 3rem;"></i>
                                    <h6 class="mt-3">Installation Guide</h6>
                                    <p class="text-muted small">Panduan instalasi lengkap format PDF</p>
                                    <a href="#" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-download me-1"></i>
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="resource-item text-center p-4 border rounded">
                                    <i class="bi bi-file-word text-primary" style="font-size: 3rem;"></i>
                                    <h6 class="mt-3">User Manual</h6>
                                    <p class="text-muted small">Manual pengguna format Word</p>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download me-1"></i>
                                        Download DOC
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="resource-item text-center p-4 border rounded">
                                    <i class="bi bi-file-slides text-warning" style="font-size: 3rem;"></i>
                                    <h6 class="mt-3">Training Slides</h6>
                                    <p class="text-muted small">Materi pelatihan PowerPoint</p>
                                    <a href="#" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-download me-1"></i>
                                        Download PPT
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="resource-item text-center p-4 border rounded">
                                    <i class="bi bi-file-zip text-success" style="font-size: 3rem;"></i>
                                    <h6 class="mt-3">Sample Data</h6>
                                    <p class="text-muted small">Data contoh untuk testing</p>
                                    <a href="#" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-download me-1"></i>
                                        Download ZIP
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Video Tutorial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ratio ratio-16x9">
                    <div id="videoPlayer" class="bg-dark d-flex align-items-center justify-content-center">
                        <div class="text-white text-center">
                            <i class="bi bi-play-circle" style="font-size: 4rem;"></i>
                            <p class="mt-2">Video akan diputar di sini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function playVideo(videoType) {
    const modal = new bootstrap.Modal(document.getElementById('videoModal'));
    const videoTitles = {
        'install': 'Tutorial Instalasi INLISLite v3',
        'config': 'Tutorial Konfigurasi Sistem',
        'usage': 'Tutorial Penggunaan Dasar'
    };
    
    document.getElementById('videoModalLabel').textContent = videoTitles[videoType] || 'Video Tutorial';
    modal.show();
}
</script>

<?= view('public/layout/footer') ?>