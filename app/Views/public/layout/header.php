<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $title ?? 'INLISLite v3 - Sistem Otomasi Perpustakaan' ?></title>
    <meta name="description" content="<?= $meta_description ?? 'Sistem otomasi perpustakaan modern dengan teknologi terdepan untuk mengelola perpustakaan secara digital dan terintegrasi.' ?>" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    <!-- Public CSS -->
    <link href="<?= base_url('assets/css/public/main.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/public/footer.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/public/header.css') ?>" rel="stylesheet" />
    
    <!-- Navbar JavaScript -->
    <script src="<?= base_url('assets/js/public/navbar.js') ?>" defer></script>
    
    <!-- Page specific CSS -->
    <?php if (isset($page_css)): ?>
        <link href="<?= base_url('assets/css/public/' . $page_css) ?>" rel="stylesheet" />
    <?php endif; ?>

    <!-- Custom CSS untuk hilangkan garis bawah aktif navbar -->
    <style>
.navbar-nav .nav-link.active,
.navbar-nav .nav-link.dropdown-toggle.active,
.navbar-nav .nav-link:focus,
.navbar-nav .nav-link:hover {
    border-bottom: none !important;
    box-shadow: none !important;
    text-decoration: none !important;
    background: none !important;
    outline: none !important;
}
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-public" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <div class="navbar-brand-icon me-2">
                    <img src="<?= base_url('assets/images/logo-perpusnas.png') ?>" alt="Logo" style="height: 100px; background: none; box-shadow: none;" />
                </div>

                <div class="navbar-brand-text">
                    <div class="navbar-brand-main">
                        Inlis<span class="navbar-brand-lite">Lite</span>
                    </div>
                    <div class="navbar-brand-version">v3.0</div>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($page_title === 'Home') ? 'active' : '' ?>" href="<?= base_url('/') ?>">
                            Beranda
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="fiturDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Fitur
                        </a>
                        <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="<?= base_url('aplikasi') ?>">
        <i class="bi bi-app me-2"></i>Aplikasi Pendukung
    </a></li>
    <li><a class="dropdown-item" href="<?= base_url('patch') ?>">
        <i class="bi bi-arrow-clockwise me-2"></i>Patch & Updater
    </a></li>
    <li><a class="dropdown-item" href="<?= base_url('demo') ?>">
        <i class="bi bi-play-circle me-2"></i>Demo Program
    </a></li>
    <!-- Tambahan Baru -->
    <li><a class="dropdown-item" href="<?= base_url('fitur-modul') ?>">
        <i class="bi bi-sliders me-2"></i>Fitur & Modul Program
    </a></li>
    <li><a class="dropdown-item" href="<?= base_url('installer') ?>">
        <i class="bi bi-download me-2"></i>Installer
    </a></li>
</ul>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page_title === 'Tentang') ? 'active' : '' ?>" href="<?= base_url('tentang') ?>">
                            Tentang
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="bantuanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Bantuan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('panduan') ?>">
                                <i class="bi bi-book me-2"></i>Panduan
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('dukungan') ?>">
                                <i class="bi bi-headset me-2"></i>Dukungan Teknis
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('bimbingan') ?>">
                                <i class="bi bi-mortarboard me-2"></i>Bimbingan Teknis
                            </a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page_title === 'Kontak') ? 'active' : '' ?>" href="<?= base_url('bimbingan') ?>">
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>
