<?= view('public/layout/header', ['page_title' => $page_title ?? 'Demo Program']) ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <div class="page-icon">
                        <i class="bi bi-play-circle"></i>
                    </div>
                    <h1 class="page-title">Demo Program</h1>
                    <p class="page-subtitle">
                        Coba demo INLISLite v3 secara online. Jelajahi fitur-fitur lengkap sebelum menggunakan sistem di perpustakaan Anda
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
                <li class="breadcrumb-item active" aria-current="page">Demo Program</li>
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
                        <h2 class="mb-3">Jelajahi INLISLite v3 Secara Online</h2>
                        <p class="lead">
                            Rasakan pengalaman menggunakan INLISLite v3 melalui platform demo online kami. 
                            Tidak perlu instalasi, langsung akses dan coba semua fitur yang tersedia.
                        </p>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <i class="bi bi-shield-check text-success" style="font-size: 2.5rem;"></i>
                                <h6 class="mt-2">Aman & Terpercaya</h6>
                                <p class="text-muted small">Data demo aman dan terisolasi</p>
                            </div>
                            <div class="col-md-4">
                                <i class="bi bi-clock text-primary" style="font-size: 2.5rem;"></i>
                                <h6 class="mt-2">Akses 24/7</h6>
                                <p class="text-muted small">Tersedia kapan saja</p>
                            </div>
                            <div class="col-md-4">
                                <i class="bi bi-laptop text-warning" style="font-size: 2.5rem;"></i>
                                <h6 class="mt-2">Fitur Lengkap</h6>
                                <p class="text-muted small">Semua modul tersedia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demo Programs -->
        <div class="row g-4 mb-5">
            <?php if (isset($demos) && is_array($demos)): ?>
                <?php foreach ($demos as $index => $demo): ?>
                    <div class="col-lg-6">
                        <div class="demo-card content-card h-100 animate-on-scroll" style="animation-delay: <?= $index * 0.1 ?>s;">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div class="demo-icon me-3">
                                        <i class="bi bi-laptop" style="font-size: 2.5rem; color: #667eea;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="mb-1"><?= esc($demo['title']) ?></h4>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2"><?= esc($demo['platform']) ?></span>
                                            <span class="badge bg-secondary"><?= esc($demo['version']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3"><?= esc($demo['description']) ?></p>
                                
                                <!-- Features -->
                                <h6 class="mb-2">Fitur Utama:</h6>
                                <ul class="list-unstyled mb-4">
                                    <?php foreach ($demo['features'] as $feature): ?>
                                        <li class="mb-1">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <?= esc($feature) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                
                                <!-- Login Information -->
                                <div class="login-info-box bg-light p-3 rounded mb-4">
                                    <h6 class="mb-2">
                                        <i class="bi bi-key me-2"></i>
                                        Informasi Login
                                    </h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="credential-item">
                                                <label class="small text-muted">Username:</label>
                                                <div class="d-flex align-items-center">
                                                    <code class="credential-code me-2"><?= esc($demo['username']) ?></code>
                                                    <button class="btn btn-sm btn-outline-secondary copy-btn" data-copy="<?= esc($demo['username']) ?>" title="Copy Username">
                                                        <i class="bi bi-copy"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="credential-item">
                                                <label class="small text-muted">Password:</label>
                                                <div class="d-flex align-items-center">
                                                    <code class="credential-code me-2"><?= esc($demo['password']) ?></code>
                                                    <button class="btn btn-sm btn-outline-secondary copy-btn" data-copy="<?= esc($demo['password']) ?>" title="Copy Password">
                                                        <i class="bi bi-copy"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Demo Button -->
                                <div class="d-grid gap-2">
                                    <a href="<?= esc($demo['url']) ?>" target="_blank" class="btn btn-primary-gradient btn-lg demo-btn" data-demo-id="<?= $demo['id'] ?>">
                                        <i class="bi bi-play-circle me-2"></i>
                                        Akses Demo
                                    </a>
                                    <button class="btn btn-outline-secondary" onclick="showDemoDetails(<?= $demo['id'] ?>)">
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

        <!-- Demo Features -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-grid-3x3-gap me-2"></i>
                            Modul yang Dapat Dicoba
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6">
                                <div class="feature-demo-item text-center p-4 border rounded">
                                    <i class="bi bi-book" style="font-size: 3rem; color: #667eea;"></i>
                                    <h5 class="mt-3">Katalogisasi</h5>
                                    <p class="text-muted">Input dan pengelolaan data bibliografi dengan standar MARC21</p>
                                    <ul class="list-unstyled small text-start">
                                        <li>• Input data buku manual</li>
                                        <li>• Import dari file Excel</li>
                                        <li>• Generate barcode otomatis</li>
                                        <li>• Validasi data duplikasi</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="feature-demo-item text-center p-4 border rounded">
                                    <i class="bi bi-arrow-repeat" style="font-size: 3rem; color: #28a745;"></i>
                                    <h5 class="mt-3">Sirkulasi</h5>
                                    <p class="text-muted">Sistem peminjaman dan pengembalian buku otomatis</p>
                                    <ul class="list-unstyled small text-start">
                                        <li>• Peminjaman dengan scan barcode</li>
                                        <li>• Pengembalian dan perpanjangan</li>
                                        <li>• Perhitungan denda otomatis</li>
                                        <li>• Notifikasi jatuh tempo</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="feature-demo-item text-center p-4 border rounded">
                                    <i class="bi bi-people" style="font-size: 3rem; color: #ffc107;"></i>
                                    <h5 class="mt-3">Keanggotaan</h5>
                                    <p class="text-muted">Manajemen data anggota perpustakaan</p>
                                    <ul class="list-unstyled small text-start">
                                        <li>• Registrasi anggota baru</li>
                                        <li>• Cetak kartu anggota</li>
                                        <li>• Kategori keanggotaan</li>
                                        <li>• Riwayat aktivitas anggota</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="feature-demo-item text-center p-4 border rounded">
                                    <i class="bi bi-graph-up" style="font-size: 3rem; color: #dc3545;"></i>
                                    <h5 class="mt-3">Pelaporan</h5>
                                    <p class="text-muted">Dashboard dan laporan komprehensif</p>
                                    <ul class="list-unstyled small text-start">
                                        <li>• Dashboard real-time</li>
                                        <li>• Laporan sirkulasi</li>
                                        <li>• Statistik koleksi</li>
                                        <li>• Export ke Excel/PDF</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="feature-demo-item text-center p-4 border rounded">
                                    <i class="bi bi-search" style="font-size: 3rem; color: #6f42c1;"></i>
                                    <h5 class="mt-3">OPAC</h5>
                                    <p class="text-muted">Online Public Access Catalog</p>
                                    <ul class="list-unstyled small text-start">
                                        <li>• Pencarian advanced</li>
                                        <li>• Filter berdasarkan kategori</li>
                                        <li>• Detail informasi koleksi</li>
                                        <li>• Reservasi online</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="feature-demo-item text-center p-4 border rounded">
                                    <i class="bi bi-gear" style="font-size: 3rem; color: #17a2b8;"></i>
                                    <h5 class="mt-3">Administrasi</h5>
                                    <p class="text-muted">Pengaturan dan konfigurasi sistem</p>
                                    <ul class="list-unstyled small text-start">
                                        <li>• Manajemen user dan role</li>
                                        <li>• Konfigurasi sistem</li>
                                        <li>• Backup dan restore</li>
                                        <li>• Log aktivitas sistem</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demo Guidelines -->
        <div class="row mb-5">
            <div class="col-lg-6">
                <div class="content-card h-100 animate-on-scroll">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Panduan Menggunakan Demo
                        </h4>
                    </div>
                    <div class="card-body">
                        <ol class="list-group list-group-numbered list-group-flush">
                            <li class="list-group-item border-0 px-0">
                                <strong>Pilih Platform Demo</strong><br>
                                <small class="text-muted">Pilih demo sesuai platform yang ingin dicoba</small>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <strong>Akses Demo</strong><br>
                                <small class="text-muted">Klik tombol "Akses Demo" untuk membuka platform</small>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <strong>Login ke Sistem</strong><br>
                                <small class="text-muted">Gunakan username dan password yang disediakan</small>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <strong>Jelajahi Fitur</strong><br>
                                <small class="text-muted">Coba semua modul dan fitur yang tersedia</small>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <strong>Evaluasi Sistem</strong><br>
                                <small class="text-muted">Nilai kesesuaian dengan kebutuhan perpustakaan</small>
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
                            Catatan Penting
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Data Demo:</strong> Semua data dalam demo adalah contoh dan akan direset secara berkala.
                        </div>
                        
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Akses Terbuka:</strong> Demo dapat diakses tanpa registrasi
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Fitur Lengkap:</strong> Semua modul dapat dicoba secara penuh
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Data Sample:</strong> Tersedia data contoh untuk testing
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Reset Berkala:</strong> Data direset setiap 24 jam
                            </li>
                        </ul>
                        
                        <div class="mt-3">
                            <a href="<?= base_url('panduan') ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-book me-2"></i>
                                Panduan Lengkap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demo Statistics -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-bar-chart me-2"></i>
                            Statistik Demo
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="stat-item">
                                    <i class="bi bi-eye" style="font-size: 3rem; color: #667eea;"></i>
                                    <h3 class="stat-number text-primary mt-3">25,847</h3>
                                    <p class="stat-label text-muted">Total Pengunjung Demo</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="stat-item">
                                    <i class="bi bi-clock" style="font-size: 3rem; color: #28a745;"></i>
                                    <h3 class="stat-number text-success mt-3">15 Menit</h3>
                                    <p class="stat-label text-muted">Rata-rata Waktu Eksplorasi</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="stat-item">
                                    <i class="bi bi-star" style="font-size: 3rem; color: #ffc107;"></i>
                                    <h3 class="stat-number text-warning mt-3">4.8/5</h3>
                                    <p class="stat-label text-muted">Rating Kepuasan</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="stat-item">
                                    <i class="bi bi-download" style="font-size: 3rem; color: #dc3545;"></i>
                                    <h3 class="stat-number text-danger mt-3">1,234</h3>
                                    <p class="stat-label text-muted">Download Setelah Demo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="row">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-body text-center">
                        <h3 class="mb-3">Tertarik Menggunakan INLISLite v3?</h3>
                        <p class="lead mb-4">
                            Setelah mencoba demo, siap untuk mengimplementasikan INLISLite v3 di perpustakaan Anda?
                        </p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="<?= base_url('aplikasi') ?>" class="btn btn-primary-gradient btn-lg">
                                <i class="bi bi-download me-2"></i>
                                Download Aplikasi
                            </a>
                            <a href="<?= base_url('panduan') ?>" class="btn btn-secondary-gradient btn-lg">
                                <i class="bi bi-book me-2"></i>
                                Panduan Instalasi
                            </a>
                            <a href="<?= base_url('bimbingan') ?>" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-mortarboard me-2"></i>
                                Ikut Pelatihan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Demo Details Modal -->
<div class="modal fade" id="demoDetailsModal" tabindex="-1" aria-labelledby="demoDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoDetailsModalLabel">Detail Demo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="demoDetailsContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary-gradient" id="accessDemoBtn">
                    <i class="bi bi-play-circle me-2"></i>
                    Akses Demo
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Copy to clipboard functionality
document.addEventListener('DOMContentLoaded', function() {
    const copyButtons = document.querySelectorAll('.copy-btn');
    
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const textToCopy = this.getAttribute('data-copy');
            
            navigator.clipboard.writeText(textToCopy).then(() => {
                // Show success feedback
                const originalIcon = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check"></i>';
                this.classList.add('btn-success');
                this.classList.remove('btn-outline-secondary');
                
                setTimeout(() => {
                    this.innerHTML = originalIcon;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-secondary');
                }, 1000);
                
                showToast(`${textToCopy} berhasil disalin!`, 'success');
            }).catch(() => {
                showToast('Gagal menyalin teks', 'error');
            });
        });
    });
});

// Track demo access
document.querySelectorAll('.demo-btn').forEach(button => {
    button.addEventListener('click', function() {
        const demoId = this.getAttribute('data-demo-id');
        // Track demo access analytics
        console.log(`Demo ${demoId} accessed`);
        showToast('Membuka demo di tab baru...', 'info');
    });
});

function showDemoDetails(demoId) {
    const modal = new bootstrap.Modal(document.getElementById('demoDetailsModal'));
    document.getElementById('demoDetailsModalLabel').textContent = `Detail Demo Program ${demoId}`;
    
    // Show loading
    document.getElementById('demoDetailsContent').innerHTML = `
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memuat detail demo...</p>
        </div>
    `;
    
    modal.show();
    
    // Simulate loading demo details
    setTimeout(() => {
        document.getElementById('demoDetailsContent').innerHTML = `
            <div class="row">
                <div class="col-md-8">
                    <h6>Screenshot Demo</h6>
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <div class="bg-light p-4 rounded text-center" style="height: 200px;">
                                <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-2">Dashboard Screenshot</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light p-4 rounded text-center" style="height: 200px;">
                                <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-2">Katalogisasi Screenshot</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light p-4 rounded text-center" style="height: 200px;">
                                <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-2">Sirkulasi Screenshot</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light p-4 rounded text-center" style="height: 200px;">
                                <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-2">OPAC Screenshot</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h6>Informasi Demo</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong>Platform:</strong> Web-based</li>
                        <li class="mb-2"><strong>Browser:</strong> Chrome, Firefox, Safari</li>
                        <li class="mb-2"><strong>Akses:</strong> 24/7</li>
                        <li class="mb-2"><strong>Data Reset:</strong> Setiap 24 jam</li>
                        <li class="mb-2"><strong>Concurrent Users:</strong> Unlimited</li>
                    </ul>
                    
                    <h6 class="mt-4">Fitur yang Dapat Dicoba</h6>
                    <ul class="list-unstyled">
                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Katalogisasi</li>
                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Sirkulasi</li>
                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Keanggotaan</li>
                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Pelaporan</li>
                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>OPAC</li>
                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Administrasi</li>
                    </ul>
                </div>
            </div>
        `;
    }, 1000);
}
</script>

<?= view('public/layout/footer') ?>