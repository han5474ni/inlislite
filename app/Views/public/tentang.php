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

        <!-- About Content Cards from Database -->
        <div class="row g-4">
            <?php if (isset($about_content) && is_array($about_content) && count($about_content) > 0): ?>
                <?php foreach ($about_content as $index => $content): ?>
                    <div class="col-lg-6">
                        <div class="content-card h-100 animate-on-scroll" style="animation-delay: <?= $index * 0.1 ?>s;">
                            <div class="card-header">
                                <h4 class="mb-1">
                                    <i class="<?= $content['icon'] ?? 'bi-info-circle' ?> me-2"></i>
                                    <?= esc($content['title']) ?>
                                </h4>
                                <?php if (!empty($content['subtitle'])): ?>
                                    <p class="mb-0 opacity-75"><?= esc($content['subtitle']) ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="content-text">
                                    <?php 
                                    // Display HTML content from database
                                    if (!empty($content['content'])) {
                                        // Clean HTML content for safe display
                                        $allowed_tags = '<p><br><ul><li><strong><b><em><i><h1><h2><h3><h4><h5><h6>';
                                        echo strip_tags($content['content'], $allowed_tags);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback content if no database content available -->
                <div class="col-12">
                    <div class="content-card animate-on-scroll">
                        <div class="card-body text-center">
                            <i class="bi bi-info-circle" style="font-size: 3rem; color: #6c757d; margin-bottom: 1rem;"></i>
                            <h4>Konten Sedang Dimuat</h4>
                            <p class="text-muted">Informasi tentang INLISLite sedang dipersiapkan. Silakan kembali lagi nanti.</p>
                            <a href="<?= base_url('/') ?>" class="btn btn-primary">Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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