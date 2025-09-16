<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $page_title ?? $title ?? 'INLISLite v3' ?></title>

    <?php 
        // Detect admin route early for conditional assets
        $uri = service('uri');
        $segments = $uri->getSegments();
        $seg1 = strtolower($segments[0] ?? '');
        $seg2 = strtolower($segments[1] ?? '');
        $isAdmin = ($seg1 === 'admin');
    ?>
    <!-- Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <?php if ($isAdmin): ?>
        <!-- Admin CSS (global) -->
        <link href="<?= base_url('assets/css/admin/sidebar.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/admin/admin-base.css') ?>" rel="stylesheet">
        <!-- Page-specific admin CSS should be added via $page_css or section('head') in each view -->
    <?php else: ?>
        <!-- Public CSS -->
        <link href="<?= base_url('assets/css/public/main.css') ?>" rel="stylesheet" />
        <!-- Default hero image variable; apply when using page-header--image -->
        <style>
            :root { --header-bg-url: url('<?= base_url('assets/images/hero.jpeg') ?>'); }
            .page-header { position: relative; color: #fff; }
            .page-header.page-header--image { background: var(--header-bg-url) center/cover no-repeat; }
            .page-header.page-header--bg-fixed { background-attachment: fixed; }
            .page-header::before {
                content: '';
                position: absolute; inset: 0;
                background: linear-gradient(180deg, rgba(10,68,153,0.55) 0%, rgba(0,56,128,0.55) 60%, rgba(0,56,128,0.35) 100%);
                z-index: 1;
            }
            .page-header .container, .page-header .page-header-content { position: relative; z-index: 2; }
            .page-header .page-title, .page-header .page-subtitle, .page-header .page-icon { color: #fff; }
        </style>
    <?php endif; ?>
    
    <?php if (isset($page_css)): ?>
        <?php foreach ((array) $page_css as $css): ?>
            <link href="<?= base_url($css) ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Section: head -->
    <?= $this->renderSection('head') ?>
</head>
<?php 
    $uri = service('uri');
    // Safer: use segments array to avoid out-of-range exceptions
    $segments = $uri->getSegments();
    $seg1 = strtolower($segments[0] ?? '');
    $seg2 = strtolower($segments[1] ?? '');
    $isAdmin = ($seg1 === 'admin');
    $showAdminSidebar = $isAdmin && !in_array($seg2, ['login', 'auth']);
?>
<body class="<?= $isAdmin ? 'admin-body' : '' ?>">
    <?php if ($isAdmin): ?>
        <?php if ($showAdminSidebar): ?>
            <?= $this->include('admin/partials/sidebar') ?>
        <?php endif; ?>
        <main class="enhanced-main-content">
            <div class="container-fluid px-2 py-3">
                <?= $this->renderSection('page_header') ?>
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    <?php else: ?>
        <!-- Public Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-public" id="mainNavbar">
            <div class="container">
                <a class="navbar-brand" href="<?= base_url('/') ?>">
                    <div class="navbar-brand-icon me-2">
                        <img src="<?= base_url('assets/images/inlislite.png') ?>" alt="Logo" />
                    </div>
                    <span class="brand-title">INLISLite</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <?php
                    // Determine active menu based on first segment
                    $seg = strtolower($segments[0] ?? '');
                    $isActive = function(array $keys) use ($seg) { return in_array($seg, $keys, true); };
                ?>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= ($seg === '' ? 'active' : '') ?>" href="<?= base_url('/') ?>">Beranda</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= ($isActive(['fitur','aplikasi','patch','demo']) ? 'active' : '') ?>" href="#" role="button" data-bs-toggle="dropdown">Fitur</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= base_url('aplikasi') ?>"><i class="bi bi-app me-2"></i>Aplikasi Pendukung</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('patch') ?>"><i class="bi bi-arrow-clockwise me-2"></i>Patch & Updater</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('demo') ?>"><i class="bi bi-play-circle me-2"></i>Demo Program</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($seg === 'tentang' ? 'active' : '') ?>" href="<?= base_url('tentang') ?>">Tentang</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= ($isActive(['panduan','dukungan','bimbingan']) ? 'active' : '') ?>" href="#" role="button" data-bs-toggle="dropdown">Bantuan</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= base_url('panduan') ?>"><i class="bi bi-book me-2"></i>Panduan</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('dukungan') ?>"><i class="bi bi-headset me-2"></i>Dukungan Teknis</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('bimbingan') ?>"><i class="bi bi-mortarboard me-2"></i>Bimbingan Teknis</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($seg === 'dukungan' ? 'active' : '') ?>" href="<?= base_url('dukungan') ?>">Kontak</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Main Content -->
        <?php $isHome = ($seg1 === '' || $seg1 === null); ?>
        <main class="public-main">
            <?= $this->renderSection('page_header') ?>
            <?= $this->renderSection('content') ?>
        </main>
        <!-- Public Footer (simplified) -->
        <footer class="footer-modern">
            <div class="container py-4 position-relative">
                <div class="text-center">
                    <p class="mb-2 text-white-50">© 2016 | Perpustakaan Nasional Republik Indonesia</p>
                    <a href="<?= base_url('admin/login') ?>" class="btn btn-outline-light btn-sm"><i class="bi bi-shield-lock me-1"></i>Admin Login</a>
                </div>
            </div>
        </footer>
    <?php endif; ?>

    <!-- Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Optional vendor JS -->
    <?php if (isset($use_jquery) && $use_jquery): ?>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <?php endif; ?>
    <?php if (isset($use_datatables) && $use_datatables): ?>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <?php endif; ?>

    <!-- Project JS -->
    <?php if ($isAdmin): ?>
        <!-- Admin global JS (avoid loading page-specific JS like dashboard.js here) -->
        <script src="<?= base_url('assets/js/admin/sidebar.js') ?>"></script>
    <?php else: ?>
        <script src="<?= base_url('assets/js/public/main.js') ?>"></script>
    <?php endif; ?>

    <!-- Page specific JS -->
    <?php if (isset($page_js)): ?>
        <?php foreach ((array) $page_js as $js): ?>
            <script src="<?= base_url($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Section: scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>

