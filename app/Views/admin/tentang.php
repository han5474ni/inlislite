<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang INLISLite - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/tentang.css') ?>" rel="stylesheet">
    
    <style>
    body {
        background: linear-gradient(135deg, #1C6EC4 0%, #2DA84D 100%);
        min-height: 100vh;
    }
    </style>
</head>
<body>
    <!-- Include Enhanced Sidebar -->
    <?= $this->include('admin/partials/sidebar') ?>
    
    <!-- Main Content -->
    <main class="enhanced-main-content">
        <div class="dashboard-container">
            <div class="header-card">
                <div class="content-header">
                    <h1 class="main-title">Tentang INLISLite</h1>
                    <p class="main-subtitle">Informasi lengkap tentang sistem otomasi perpustakaan</p>
                </div>
            </div>
            

        <div class="container">
            <!-- Page Banner Card -->
            <div class="banner-card mb-5">
                <div class="banner-icon">
                    <i class="bi bi-info-circle"></i>
                </div>
                <div class="banner-content">
                    <h2 class="banner-title">Tentang INLISLite</h2>
                    <h3 class="banner-subtitle">Versi 3 PHP Opensource</h3>
                    <p class="banner-description">
                        Informasi lengkap tentang sistem otomasi perpustakaan modern dengan teknologi terdepan 
                        dan fitur-fitur canggih untuk mengelola perpustakaan secara digital.
                    </p>
                </div>
            </div>

            <!-- Search and Action Section -->
            <div class="search-action-section mb-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="search-box">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari informasi...">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <a href="<?= base_url('admin/tentang-edit') ?>" class="btn btn-success me-2">
                            <i class="bi bi-gear me-2"></i>Kelola Data
                        </a>
                        <button class="btn btn-info" onclick="refreshContent()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <section class="content-section">
                <div class="section-header mb-4">
                    <h2 class="section-title">Informasi Sistem</h2>
                    <p class="section-subtitle">
                        Dokumentasi lengkap tentang INLISLite v3 dan komponen-komponen sistem perpustakaan
                    </p>
                </div>
                
                <div class="row g-4" id="contentContainer">
                    <!-- Content cards will be loaded here from database -->
                    <div class="col-12 text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Memuat konten...</span>
                        </div>
                        <p class="mt-2 text-muted">Memuat konten dari database...</p>
                    </div>
                </div>
            </section>
        </div>
        </div>
    </main>

    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/admin/tentang.js') ?>"></script>
</body>
</html>