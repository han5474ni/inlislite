<?= view('public/layout/header', ['page_title' => $page_title ?? 'Tentang Kami']) ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <div class="page-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <h1 class="page-title">Tentang Kami</h1>
                    <p class="page-subtitle">
                        Informasi lengkap tentang INLISLite v3, sistem otomasi perpustakaan modern yang dikembangkan oleh Perpustakaan Nasional RI
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
                <li class="breadcrumb-item active" aria-current="page">Tentang Kami</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <!-- Introduction Section -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h2 class="mb-0">
                            <i class="bi bi-book me-2"></i>
                            INLISLite Version 3
                        </h2>
                    </div>
                    <div class="card-body text-center">
                        <p class="lead mb-4">
                            Sistem otomasi perpustakaan yang dikembangkan oleh Perpustakaan Nasional Republik Indonesia untuk membantu perpustakaan dalam mengelola koleksi, anggota, dan layanan perpustakaan secara digital dan terintegrasi.
                        </p>
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <i class="bi bi-shield-check" style="font-size: 2rem; color: #28a745;"></i>
                                    <h5 class="mt-2">Terpercaya</h5>
                                    <p class="text-muted">Dikembangkan oleh Perpusnas RI</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <i class="bi bi-code-slash" style="font-size: 2rem; color: #007bff;"></i>
                                    <h5 class="mt-2">Open Source</h5>
                                    <p class="text-muted">Gratis dan dapat dikustomisasi</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <i class="bi bi-globe" style="font-size: 2rem; color: #6f42c1;"></i>
                                    <h5 class="mt-2">Modern</h5>
                                    <p class="text-muted">Teknologi web terdepan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Content Cards -->
        <div class="row g-4">
            <?php if (isset($about_content) && is_array($about_content)): ?>
                <?php foreach ($about_content as $index => $content): ?>
                    <div class="col-lg-6">
                        <div class="content-card h-100 animate-on-scroll" style="animation-delay: <?= $index * 0.1 ?>s;">
                            <div class="card-header">
                                <h4 class="mb-1">
                                    <i class="<?= $content['icon'] ?> me-2"></i>
                                    <?= esc($content['title']) ?>
                                </h4>
                                <p class="mb-0 opacity-75"><?= esc($content['subtitle']) ?></p>
                            </div>
                            <div class="card-body">
                                <div class="content-text">
                                    <?php 
                                    $formatted_content = str_replace('\n', "\n", $content['content']);
                                    $lines = explode("\n", $formatted_content);
                                    foreach ($lines as $line): 
                                        $line = trim($line);
                                        if (empty($line)) continue;
                                        
                                        if (strpos($line, '•') === 0): ?>
                                            <div class="d-flex align-items-start mb-2">
                                                <i class="bi bi-check-circle text-success me-2 mt-1"></i>
                                                <span><?= esc(substr($line, 1)) ?></span>
                                            </div>
                                        <?php else: ?>
                                            <p class="mb-3"><?= esc($line) ?></p>
                                        <?php endif;
                                    endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Statistics Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-graph-up me-2"></i>
                            Statistik Penggunaan
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="stat-item">
                                    <div class="stat-icon mb-3">
                                        <i class="bi bi-building" style="font-size: 3rem; color: #667eea;"></i>
                                    </div>
                                    <h3 class="stat-number text-primary">1,000+</h3>
                                    <p class="stat-label text-muted">Perpustakaan Aktif</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="stat-item">
                                    <div class="stat-icon mb-3">
                                        <i class="bi bi-people" style="font-size: 3rem; color: #28a745;"></i>
                                    </div>
                                    <h3 class="stat-number text-success">50,000+</h3>
                                    <p class="stat-label text-muted">Pengguna Terdaftar</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="stat-item">
                                    <div class="stat-icon mb-3">
                                        <i class="bi bi-book" style="font-size: 3rem; color: #ffc107;"></i>
                                    </div>
                                    <h3 class="stat-number text-warning">2,000,000+</h3>
                                    <p class="stat-label text-muted">Koleksi Dikelola</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="stat-item">
                                    <div class="stat-icon mb-3">
                                        <i class="bi bi-arrow-repeat" style="font-size: 3rem; color: #dc3545;"></i>
                                    </div>
                                    <h3 class="stat-number text-danger">99.9%</h3>
                                    <p class="stat-label text-muted">Uptime Server</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <div class="content-card animate-on-scroll">
                    <div class="card-body text-center">
                        <h3 class="mb-3">Siap Memulai dengan INLISLite v3?</h3>
                        <p class="lead mb-4">
                            Bergabunglah dengan ribuan perpustakaan yang telah mempercayai INLISLite untuk mengelola perpustakaan mereka.
                        </p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="<?= base_url('panduan') ?>" class="btn btn-primary-gradient btn-lg">
                                <i class="bi bi-book me-2"></i>
                                Panduan Instalasi
                            </a>
                            <a href="<?= base_url('aplikasi') ?>" class="btn btn-secondary-gradient btn-lg">
                                <i class="bi bi-download me-2"></i>
                                Download Aplikasi
                            </a>
                            <a href="<?= base_url('demo') ?>" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-play-circle me-2"></i>
                                Coba Demo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= view('public/layout/footer') ?>