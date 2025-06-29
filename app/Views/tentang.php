<?php
// Tentang Inlislite Versi 3
$page_title = "Tentang Inlislite Versi 3";
$page_subtitle = "Informasi lengkap tentang sistem otomasi perpustakaan";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc($title ?? $page_title); ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/tentang.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Header Navigation -->
    <header class="header-nav bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <div class="row align-items-center py-3">
                <div class="col-auto">
                    <button class="btn btn-link text-decoration-none p-0" id="backBtn">
                        <i class="bi bi-arrow-left fs-4 text-primary"></i>
                    </button>
                </div>
                <div class="col text-center">
                    <h1 class="header-title mb-0"><?php echo esc($page_title ?? 'Tentang Inlislite Versi 3'); ?></h1>
                    <p class="header-subtitle text-muted mb-0"><?php echo esc($page_subtitle ?? 'Informasi lengkap tentang sistem otomasi perpustakaan'); ?></p>
                </div>
                <div class="col-auto">
                    <!-- Spacer for center alignment -->
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mt-4 pb-5">
        <div class="row g-4">
            <!-- Card 1: Inlislite Versi 3 -->
            <div class="col-12 col-lg-6">
                <div class="card h-100 shadow-sm rounded-3 border-0 info-card">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="icon-wrapper mx-auto mb-3">
                                <i class="bi bi-book fs-1 text-primary"></i>
                            </div>
                            <h3 class="card-title fw-bold text-primary mb-2">Inlislite Versi 3</h3>
                            <p class="card-subtitle text-muted">Sistem Otomasi Perpustakaan Modern</p>
                        </div>
                        <div class="card-content">
                            <p class="text-muted lh-lg">
                                INLISLite Versi 3 merupakan pengembangan lanjutan dari perangkat lunak aplikasi otomasi 
                                perpustakaan INLISLite Versi 2.1.2 yang telah dibangun dan dikembangkan oleh 
                                Perpustakaan Nasional Republik Indonesia (Perpustakaan Nasional RI) sejak tahun 2011.
                            </p>
                            <p class="text-muted lh-lg">
                                INLISLite Versi 3 dikembangkan sebagai solusi perangkat lunak satu pintu bagi pengelola 
                                perpustakaan untuk menerapkan otomasi perpustakaan serta mengembangkan 
                                perpustakaan digital / mengelola dan menyediakan koleksi digital.
                            </p>
                            <p class="text-muted lh-lg">
                                INLISLite secara resmi dibangun dan dikembangkan oleh Perpustakaan Nasional 
                                Indonesia untuk menghimpun koleksi nasional dalam jaringan Perpustakaan Digital 
                                Nasional Indonesia. Selain itu, sistem ini juga bertujuan untuk mendukung 
                                pengembangan pengelolaan dan layanan perpustakaan berbasis teknologi informasi 
                                dan komunikasi di seluruh Indonesia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Kerangka Hukum -->
            <div class="col-12 col-lg-6">
                <div class="card h-100 shadow-sm rounded-3 border-0 info-card">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="icon-wrapper mx-auto mb-3">
                                <i class="bi bi-file-earmark-text fs-1 text-success"></i>
                            </div>
                            <h3 class="card-title fw-bold text-success mb-2">Kerangka Hukum</h3>
                            <p class="card-subtitle text-muted">Landasan Hukum Perpustakaan</p>
                        </div>
                        <div class="card-content">
                            <ul class="legal-list list-unstyled">
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="text-muted">Undang-Undang Republik Indonesia Nomor 43 Tahun 2007 tentang Perpustakaan</span>
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="text-muted">Peraturan Pemerintah Nomor 24 Tahun 2014 tentang Pelaksanaan UU Perpustakaan</span>
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="text-muted">Peraturan Menteri Pendidikan dan Kebudayaan tentang Standar Nasional Perpustakaan</span>
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="text-muted">Surat Keputusan Kepala Perpustakaan Nasional tentang Standar Kompetensi Pustakawan</span>
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="text-muted">Peraturan Daerah tentang Penyelenggaraan Perpustakaan Umum</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Karakteristik Section -->
        <div class="mt-5">
            <div class="card shadow-sm rounded-3 border-0 section-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-wrapper-small me-3">
                            <i class="bi bi-gear fs-4 text-info"></i>
                        </div>
                        <div>
                            <h3 class="section-title mb-1">Karakteristik Inlislite Versi 3.0</h3>
                            <p class="section-subtitle text-muted mb-0">Fitur lengkap yang dirancang untuk manajemen perpustakaan modern</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="card h-100 feature-card border">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start">
                                        <div class="feature-icon bg-primary text-white rounded-circle me-3">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-2">Standar MARC</h6>
                                            <p class="text-muted mb-0 small">
                                                Mengikuti standar metadata MARC (MAchine Readable Cataloging) dalam 
                                                pembuatan katalog digital.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card h-100 feature-card border">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start">
                                        <div class="feature-icon bg-success text-white rounded-circle me-3">
                                            <i class="bi bi-globe"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-2">Aplikasi berbasis web</h6>
                                            <p class="text-muted mb-0 small">
                                                Beroperasi melalui browser internet yang umum digunakan dengan 
                                                arsitektur server-client.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card h-100 feature-card border">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start">
                                        <div class="feature-icon bg-info text-white rounded-circle me-3">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-2">Dukungan Multi-user</h6>
                                            <p class="text-muted mb-0 small">
                                                Mendukung pengoperasian multi-pengguna secara simultan melalui 
                                                koneksi LAN, WAN, atau Internet.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card h-100 feature-card border">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start">
                                        <div class="feature-icon bg-success text-white rounded-circle me-3">
                                            <i class="bi bi-percent"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-2">Gratis dan Open source</h6>
                                            <p class="text-muted mb-0 small">
                                                Sepenuhnya gratis digunakan dan tersedia dalam format open-source 
                                                untuk aksesibilitas maksimal.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Section -->
        <div class="mt-4">
            <div class="card shadow-sm rounded-3 border-0 section-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-wrapper-small me-3">
                            <i class="bi bi-laptop fs-4 text-secondary"></i>
                        </div>
                        <div>
                            <h3 class="section-title mb-1">Pilihan Platform</h3>
                            <p class="section-subtitle text-muted mb-0">INLISLite Versi 3 dikembangkan dalam dua platform bahasa pemrograman</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="card platform-card border">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold mb-1">DotNet Framework</h6>
                                            <p class="text-muted mb-0 small">
                                                Dapat diinstal pada komputer dengan sistem operasi Windows
                                            </p>
                                        </div>
                                        <span class="badge bg-primary px-3 py-2">Windows</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card platform-card border">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold mb-1">PHP Open Source</h6>
                                            <p class="text-muted mb-0 small">
                                                Dapat diinstal pada komputer dengan sistem operasi Windows maupun Linux
                                            </p>
                                        </div>
                                        <span class="badge bg-info px-3 py-2">Cross-Platform</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ketentuan Penggunaan Section -->
        <div class="mt-4">
            <div class="card shadow-sm rounded-3 border-0 section-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-wrapper-small me-3">
                            <i class="bi bi-shield-check fs-4 text-warning"></i>
                        </div>
                        <div>
                            <h3 class="section-title mb-1">Ketentuan Penggunaan dan Distribusi INLIS Lite Versi 3</h3>
                        </div>
                    </div>

                    <div class="terms-list">
                        <div class="term-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="term-icon bg-success text-white rounded-circle me-3">
                                    <i class="bi bi-check"></i>
                                </div>
                                <p class="term-text mb-0">
                                    Semua institusi dan individu yang membutuhkan diperbolehkan untuk menyalin, 
                                    menginstal, dan menggunakan perangkat lunak aplikasi INLISLite Versi 3.
                                </p>
                            </div>
                        </div>

                        <div class="term-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="term-icon bg-success text-white rounded-circle me-3">
                                    <i class="bi bi-check"></i>
                                </div>
                                <p class="term-text mb-0">
                                    Semua institusi dan individu juga diperbolehkan untuk mengunduh dan 
                                    menginstal patch serta pembaruan yang tersedia.
                                </p>
                            </div>
                        </div>

                        <div class="term-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="term-icon bg-danger text-white rounded-circle me-3">
                                    <i class="bi bi-x"></i>
                                </div>
                                <p class="term-text mb-0">
                                    Dilarang keras memperjualbelikan paket instalasi, patch, atau komponen 
                                    pembaruan dari INLISLite Versi 3.
                                </p>
                            </div>
                        </div>

                        <div class="term-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="term-icon bg-primary text-white rounded-circle me-3">
                                    <i class="bi bi-info"></i>
                                </div>
                                <p class="term-text mb-0">
                                    Dukungan teknis akan diberikan oleh Perpustakaan Nasional Indonesia kepada 
                                    pengguna yang mematuhi syarat dan ketentuan yang berlaku.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="d-flex align-items-start">
                                <div class="term-icon bg-primary text-white rounded-circle me-3">
                                    <i class="bi bi-info"></i>
                                </div>
                                <p class="term-text mb-0">
                                    Pelatihan teknis juga akan diberikan oleh Perpustakaan Nasional Indonesia 
                                    dengan syarat dan ketentuan yang sama.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ketentuan Modifikasi Section -->
        <div class="mt-4">
            <div class="card shadow-sm rounded-3 border-0 section-card">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h3 class="section-title mb-2">Ketentuan Modifikasi INLIS Lite Versi 3 PHP (Opensource)</h3>
                        <p class="section-description text-muted">
                            Semua pihak dengan niat baik dipersilakan untuk berkontribusi dengan memodifikasi 
                            sebagian tampilan dan/atau fungsi dari perangkat lunak INLISLite Versi 3 PHP (Open Source), 
                            dengan tetap mematuhi aturan berikut:
                        </p>
                    </div>

                    <div class="terms-list">
                        <div class="term-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="term-icon bg-warning text-dark rounded-circle me-3">
                                    <i class="bi bi-exclamation"></i>
                                </div>
                                <p class="term-text mb-0">
                                    Dilarang menghapus logo atau tulisan INLISLite dari modul atau halaman manapun.
                                </p>
                            </div>
                        </div>

                        <div class="term-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="term-icon bg-warning text-dark rounded-circle me-3">
                                    <i class="bi bi-exclamation"></i>
                                </div>
                                <p class="term-text mb-0">
                                    Dilarang mengubah atau menghapus pernyataan hak cipta: "© Perpustakaan Nasional Indonesia."
                                </p>
                            </div>
                        </div>

                        <div class="term-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="term-icon bg-danger text-white rounded-circle me-3">
                                    <i class="bi bi-x"></i>
                                </div>
                                <p class="term-text mb-0">
                                    Dilarang mengubah standar metadata MARC, yang merupakan ciri utama dari sistem 
                                    katalog digital pada INLISLite Versi 3.
                                </p>
                            </div>
                        </div>

                        <div class="term-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="term-icon bg-primary text-white rounded-circle me-3">
                                    <i class="bi bi-info"></i>
                                </div>
                                <p class="term-text mb-0">
                                    Perpustakaan Nasional Indonesia dan komunitas pengguna INLISLite berhak untuk 
                                    diberitahu mengenai setiap modifikasi pada perangkat lunak INLISLite Versi 3 PHP.
                                </p>
                            </div>
                        </div>

                        <div class="term-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="term-icon bg-primary text-white rounded-circle me-3">
                                    <i class="bi bi-info"></i>
                                </div>
                                <p class="term-text mb-0">
                                    Semua pihak yang memodifikasi perangkat lunak INLISLite wajib membagikan kode 
                                    sumber lengkap hasil modifikasinya kepada Perpustakaan Nasional Indonesia.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="d-flex align-items-start">
                                <div class="term-icon bg-success text-white rounded-circle me-3">
                                    <i class="bi bi-check"></i>
                                </div>
                                <p class="term-text mb-0">
                                    Memperjualbelikan perangkat lunak aplikasi INLISLite atau versi modifikasinya dilarang keras.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/tentang.js') ?>"></script>
</body>
</html>
