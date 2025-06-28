<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Tentang INLISLite v3') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/tentang.css') ?>">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <?= $this->include('layout/sidebar') ?>

        <!-- Page Content -->
        <main id="page-content-wrapper">
            <header class="page-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-sm mobile-menu-toggle d-md-none me-3" id="mobile-menu-toggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div>
                        <h1 class="h2 font-weight-bold"><?= esc($page_title ?? 'Tentang INLISLite Versi 3') ?></h1>
                        <p class="text-muted"><?= esc($page_subtitle ?? 'Informasi lengkap tentang sistem otomasi perpustakaan') ?></p>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-primary me-3">
                        <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="darkModeSwitch">
                        <label class="form-check-label" for="darkModeSwitch"><i class="fa-solid fa-moon"></i></label>
                    </div>
                </div>
            </header>

            <div class="container-fluid">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item text-muted">Tentang inlislite</li>
                    </ol>
                </nav>

                <!-- Header with back arrow and title -->
                <div class="d-flex align-items-center mb-4">
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-link p-0 me-3 text-decoration-none">
                        <i class="fa-solid fa-arrow-left fs-4"></i>
                    </a>
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded p-2 me-3">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <div>
                            <h2 class="mb-0 fw-bold">Tentang Inlislite Versi 3</h2>
                            <small class="text-muted">Informasi lengkap tentang sistem otomasi perpustakaan</small>
                        </div>
                    </div>
                </div>

                <hr class="mb-5">

                <!-- Karakteristik Section -->
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info text-white rounded-circle p-2 me-3">
                                <i class="fa-solid fa-cog"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">Karakteristik Inlislite Versi 3.0</h3>
                                <small class="text-muted">Fitur lengkap yang dirancang untuk manajemen perpustakaan modern</small>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <div class="card h-100 border">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-primary text-white rounded-circle p-2 me-3 flex-shrink-0">
                                                <i class="fa-solid fa-check"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-2">Standar MARC</h5>
                                                <p class="text-muted mb-0 small">
                                                    Mengikuti standar metadata MARC (MAchine Readable Cataloging) dalam 
                                                    pembuatan katalog digital.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100 border">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-success text-white rounded-circle p-2 me-3 flex-shrink-0">
                                                <i class="fa-solid fa-globe"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-2">Aplikasi berbasis web</h5>
                                                <p class="text-muted mb-0 small">
                                                    Beroperasi melalui browser internet yang umum digunakan dengan 
                                                    arsitektur server-client.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100 border">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-info text-white rounded-circle p-2 me-3 flex-shrink-0">
                                                <i class="fa-solid fa-users"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-2">Dukungan Multi-user</h5>
                                                <p class="text-muted mb-0 small">
                                                    Mendukung pengoperasian multi-pengguna secara simultan melalui 
                                                    koneksi LAN, WAN, atau Internet.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100 border">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-success text-white rounded-circle p-2 me-3 flex-shrink-0">
                                                <i class="fa-solid fa-percent"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-2">Gratis dan Open source</h5>
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

                <!-- Platform Section -->
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-secondary text-white rounded-circle p-2 me-3">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">Pilihan Platform</h3>
                                <small class="text-muted">INLISLite Versi 3 dikembangkan dalam dua platform bahasa pemrograman</small>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="card border mb-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="fw-bold mb-1">DotNet Framework</h5>
                                            <p class="text-muted mb-0 small">
                                                Dapat diinstal pada komputer dengan sistem operasi Windows
                                            </p>
                                        </div>
                                        <span class="badge bg-primary px-3 py-2">Windows</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card border">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="fw-bold mb-1">PHP Open Source</h5>
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

                <!-- About INLISLite Section -->
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">Inlislite Versi 3</h3>
                                <small class="text-muted">Informasi lengkap tentang sistem otomasi perpustakaan</small>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="mb-3">
                                INLISLite Versi 3 merupakan pengembangan lanjutan dari perangkat lunak aplikasi otomasi 
                                perpustakaan INLISLite Versi 2.1.2 yang telah dibangun dan dikembangkan oleh 
                                Perpustakaan Nasional Republik Indonesia (Perpustakaan Nasional RI) sejak tahun 2011.
                            </p>
                            
                            <p class="mb-3">
                                INLISLite Versi 3 dikembangkan sebagai solusi perangkat lunak satu pintu bagi pengelola 
                                perpustakaan untuk menerapkan otomasi perpustakaan serta mengembangkan 
                                perpustakaan digital / mengelola dan menyediakan koleksi digital.
                            </p>
                            
                            <p class="mb-0">
                                INLISLite secara resmi dibangun dan dikembangkan oleh Perpustakaan Nasional 
                                Indonesia untuk menghimpun koleksi nasional dalam jaringan Perpustakaan Digital 
                                Nasional Indonesia. Selain itu, sistem ini juga bertujuan untuk mendukung 
                                pengembangan pengelolaan dan layanan perpustakaan berbasis teknologi informasi 
                                dan komunikasi di seluruh Indonesia.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Terms Section -->
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning text-dark rounded-circle p-2 me-3">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">Ketentuan Penggunaan dan Distribusi INLIS Lite Versi 3</h3>
                            </div>
                        </div>

                        <div class="mt-4">
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-start mb-3">
                                    <span class="bg-success rounded-circle me-3 mt-1" style="width: 8px; height: 8px; display: inline-block;"></span>
                                    <span>Semua institusi dan individu yang membutuhkan diperbolehkan untuk menyalin, menginstal, dan menggunakan perangkat lunak aplikasi INLISLite Versi 3.</span>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <span class="bg-success rounded-circle me-3 mt-1" style="width: 8px; height: 8px; display: inline-block;"></span>
                                    <span>Semua institusi dan individu juga diperbolehkan untuk mengunduh dan menginstal patch pembaruan yang tersedia.</span>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <span class="bg-danger rounded-circle me-3 mt-1" style="width: 8px; height: 8px; display: inline-block;"></span>
                                    <span>Dilarang keras memperjualbelikan paket instalasi, patch, atau komponen pembaruan dari INLISLite Versi 3.</span>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <span class="bg-primary rounded-circle me-3 mt-1" style="width: 8px; height: 8px; display: inline-block;"></span>
                                    <span>Dukungan teknis akan diberikan oleh Perpustakaan Nasional Indonesia kepada pengguna yang mematuhi syarat dan ketentuan yang berlaku.</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <span class="bg-primary rounded-circle me-3 mt-1" style="width: 8px; height: 8px; display: inline-block;"></span>
                                    <span>Pelatihan teknis juga akan diberikan oleh Perpustakaan Nasional Indonesia dengan syarat dan ketentuan yang sama.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Modification Terms Section -->
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-2">Ketentuan Modifikasi INLIS Lite Versi 3 PHP (Opensource)</h3>
                        <p class="text-muted mb-4">
                            Semua pihak dengan niat baik dipersilakan untuk berkontribusi dengan memodifikasi 
                            sebagian tampilan dan/atau fungsi dari perangkat lunak INLISLite Versi 3 PHP (Open Source), 
                            dengan tetap mematuhi aturan berikut:
                        </p>

                        <ul class="list-unstyled">
                            <li class="d-flex align-items-start mb-3">
                                <span class="bg-warning rounded-circle me-3 mt-1" style="width: 8px; height: 8px; display: inline-block;"></span>
                                <span>Dilarang menghapus logo atau tulisan INLISLite dari modul atau halaman manapun.</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <span class="bg-warning rounded-circle me-3 mt-1" style="width: 8px; height: 8px; display: inline-block;"></span>
                                <span>Dilarang mengubah atau menghapus pernyataan hak cipta: "© Perpustakaan Nasional Indonesia."</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <span class="bg-warning rounded-circle me-3 mt-1" style="width: 8px; height: 8px; display: inline-block;"></span>
                                <span>Dilarang mengubah standar metadata MARC, yang merupakan ciri utama dari sistem katalog digital pada INLISLite Versi 3.</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <span class="bg-primary rounded-circle me-3 mt-1" style="width: 8px; height: 8px; display: inline-block;"></span>
                                <span>Perpustakaan Nasional Indonesia dan komunitas pengguna INLISLite berhak untuk diberitahu mengenai setiap modifikasi pada perangkat lunak INLISLite Versi 3 PHP.</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <span class="bg-primary rounded-circle me-3 mt-1" style="width: 8px; height: 8px; display: inline-block;"></span>
                                <span>Semua pihak yang memodifikasi perangkat lunak INLISLite wajib membagikan kode sumber lengkap hasil modifikasinya kepada Perpustakaan Nasional Indonesia.</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <span class="bg-success rounded-circle me-3 mt-1" style="width: 8px; height: 8px; display: inline-block;"></span>
                                <span>Memperjualbelikan perangkat lunak aplikasi INLISLite atau versi modifikasinya dilarang keras.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Legal Framework Section -->
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-secondary text-white rounded-circle p-2 me-3">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">Kerangka Hukum</h3>
                                <small class="text-muted">Berdasarkan peraturan perundang-undangan Indonesia yang berlaku</small>
                            </div>
                        </div>

                        <ul class="list-unstyled mt-4">
                            <li class="mb-2">
                                <strong>• Undang-Undang Republik Indonesia Nomor 43 Tahun 2007 tentang Perpustakaan</strong>
                            </li>
                            <li class="mb-2">
                                <strong>• Peraturan Pemerintah Nomor 24 Tahun 2014 tentang Pelaksanaan Undang-Undang Nomor 43 Tahun 2007</strong>
                            </li>
                            <li class="mb-0">
                                <strong>• Undang-Undang Nomor 4 Tahun 1990 tentang Serah Simpan Karya Cetak dan Karya Rekam</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
    <script src="<?= base_url('assets/js/tentang.js') ?>"></script>
</body>
</html>
