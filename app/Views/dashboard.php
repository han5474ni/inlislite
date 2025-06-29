<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="theme-color" content="#2DA84D">
    <title><?= esc($title ?? 'INLISLite v3.0 Dashboard') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive.css') ?>">
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
                        <h1 class="h2 font-weight-bold"><?= esc($page_title ?? 'Selamat Datang di InlisLite!') ?></h1>
                        <p class="text-muted"><?= esc($page_subtitle ?? 'Kelola sistem perpustakaan Anda dengan alat dan analitik yang lengkap.') ?></p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <!-- Debug button (only visible in development) -->
                    <button id="debugMobileBtn" class="btn btn-sm btn-outline-light d-md-none" style="display: none;">
                        <i class="fa-solid fa-bug"></i> Debug
                    </button>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="darkModeSwitch">
                        <label class="form-check-label" for="darkModeSwitch"><i class="fa-solid fa-moon"></i></label>
                    </div>
                </div>
            </header>

            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                    <?php
                    $cards = [
                        ['icon' => 'fa-book-open', 'title' => 'Tentang Inlislite', 'text' => 'Pelajari fitur terbaru dan peningkatan yang ada di versi 3.', 'link' => 'Versi Terbaru', 'badge' => 'Baru', 'color' => 'primary', 'url' => base_url('tentang')],
                        ['icon' => 'fa-cogs', 'title' => 'Features & Program Modules', 'text' => '15 Modul', 'link' => '&nbsp;', 'color' => 'success', 'url' => '#'],
                        ['icon' => 'fa-download', 'title' => 'Installer', 'text' => 'Instruksi instalasi langkah demi langkah.', 'link' => 'Setup', 'color' => 'info', 'url' => '#'],
                        ['icon' => 'fa-cloud-arrow-up', 'title' => 'Patch and Updater', 'text' => 'Jaga sistem Anda tetap terbaru dengan patch terbaru.', 'link' => 'Auto Update', 'color' => 'success', 'url' => base_url('patch-updater'), 'id' => 'patch-updater'],
                        ['icon' => 'fa-book-bookmark', 'title' => 'Aplikasi Pendukung', 'text' => 'Dapatkan bantuan dan dukungan untuk aplikasi Anda.', 'link' => 'Dukungan 24/7', 'color' => 'primary', 'url' => base_url('aplikasi-pendukung'), 'id' => 'aplikasi-pendukung'],
                        ['icon' => 'fa-question-circle', 'title' => 'Panduan', 'text' => 'Panduan lengkap untuk menggunakan sistem.', 'link' => 'Panduan Lengkap', 'color' => 'success', 'url' => base_url('panduan')],
                        ['icon' => 'fa-headset', 'title' => 'Dukungan Teknis', 'text' => 'Bantuan teknis dan pemecahan masalah.', 'link' => 'Pertolongan ahli', 'color' => 'primary', 'url' => '#'],
                        ['icon' => 'fa-bolt', 'title' => 'Dukungan Teknis', 'text' => 'Sumber daya untuk pengembang dan tim teknis.', 'link' => 'Alat Pengembang', 'color' => 'success', 'url' => '#'],
                        ['icon' => 'fa-chart-line', 'title' => 'Demo Program', 'text' => 'Coba sistem dengan data contoh.', 'link' => 'Demo Interaktif', 'color' => 'secondary', 'url' => '#']
                    ];

                    foreach ($cards as $card) : ?>
                        <div class="col">
                            <div class="card h-100 module-card" 
                                 <?= isset($card['id']) ? 'id="' . $card['id'] . '"' : '' ?>
                                 <?= isset($card['url']) ? 'data-url="' . $card['url'] . '"' : '' ?>
                                 style="cursor: pointer;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="icon-box bg-<?= $card['color'] ?>-subtle text-<?= $card['color'] ?>">
                                            <i class="fa-solid <?= $card['icon'] ?>"></i>
                                        </div>
                                        <?php if (!empty($card['badge'])) : ?>
                                            <span class="badge text-bg-<?= $card['color'] ?>"><?= $card['badge'] ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <h5 class="card-title fw-bold"><?= $card['title'] ?></h5>
                                    <p class="card-text text-muted"><?= $card['text'] ?></p>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                     <a href="<?= $card['url'] ?>" class="card-link fw-bold text-decoration-none text-<?= $card['color'] ?>"><?= $card['link'] ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
</body>
</html>
