<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installer INLISLite - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/public/installer.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn-back me-3" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <div>
                        <h1 class="header-title mb-1">Installer INLISLite</h1>
                        <p class="header-subtitle mb-0">Paket unduhan dan instalasi sistem perpustakaan</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('installer-edit') ?>" class="btn btn-outline-light">
                            <i class="bi bi-gear me-2"></i>Manajemen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Page Banner Card -->
            <div class="banner-card mb-5">
                <div class="banner-icon">
                    <i class="bi bi-download"></i>
                </div>
                <div class="banner-content">
                    <h2 class="banner-title">Installer INLISLite</h2>
                    <h3 class="banner-subtitle">Versi <?= $installer_data['main_installer']['version'] ?> - Revisi <?= $installer_data['main_installer']['revision_date'] ?></h3>
                    <p class="banner-description">
                        <?= $installer_data['main_installer']['description'] ?>
                    </p>
                </div>
            </div>

            <!-- Search and Action Section -->
            <div class="search-action-section mb-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="search-box">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari paket installer...">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <button class="btn btn-info" onclick="refreshContent()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Installer Section -->
            <section class="installer-section mb-5">
                <div class="section-header mb-4">
                    <h2 class="section-title">Paket Installer Utama</h2>
                    <p class="section-subtitle">
                        Unduh paket installer lengkap untuk instalasi baru INLISLite v3
                    </p>
                </div>
                
                <div class="row g-4" id="mainPackagesContainer">
                    <?php foreach ($installer_data['main_installer']['packages'] as $package): ?>
                    <div class="col-lg-6 col-md-12">
                        <div class="package-card animate-fade-in">
                            <div class="card-header">
                                <div class="card-icon <?= $package['color'] ?>">
                                    <i class="<?= $package['icon'] ?>"></i>
                                </div>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title"><?= $package['name'] ?></h3>
                                <p class="card-description"><?= $package['description'] ?></p>
                                
                                <div class="package-features mb-3">
                                    <?php foreach ($package['features'] as $feature): ?>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle text-success"></i>
                                        <span><?= $feature ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="package-size mb-3">
                                    <i class="bi bi-hdd"></i>
                                    <span>Ukuran file: <?= $package['size'] ?></span>
                                </div>
                                
                                <button class="btn btn-primary btn-download" data-package="<?= $package['type'] ?>" data-name="<?= $package['name'] ?>">
                                    <i class="bi bi-download me-2"></i>
                                    Unduh <?= $package['name'] ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Additional Packages Section -->
            <section class="packages-section mb-5">
                <div class="section-header mb-4">
                    <h2 class="section-title">Paket Tambahan</h2>
                    <p class="section-subtitle">
                        Source code dan komponen tambahan untuk pengembangan dan kustomisasi
                    </p>
                </div>
                
                <div class="row g-4" id="additionalPackagesContainer">
                    <?php foreach ($installer_data['additional_packages'] as $package): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="mini-package-card animate-fade-in">
                            <div class="mini-package-icon <?= $package['color'] ?>">
                                <i class="<?= $package['icon'] ?>"></i>
                            </div>
                            <div class="mini-package-content">
                                <h4 class="mini-package-title"><?= $package['name'] ?></h4>
                                <p class="mini-package-description"><?= $package['description'] ?></p>
                                <div class="mini-package-size">
                                    <i class="bi bi-hdd"></i>
                                    <span><?= $package['size'] ?></span>
                                </div>
                                <button class="btn btn-outline-primary btn-sm btn-download-mini" data-package="<?= $package['type'] ?>" data-name="<?= $package['name'] ?>">
                                    <i class="bi bi-download me-1"></i>
                                    Download
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- System Requirements Section -->
            <section class="requirements-section mb-5">
                <div class="section-header mb-4">
                    <h2 class="section-title">Persyaratan Sistem</h2>
                    <p class="section-subtitle">
                        Pastikan sistem Anda memenuhi persyaratan minimum untuk menjalankan INLISLite v3
                    </p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="requirements-card">
                            <div class="requirements-header">
                                <div class="requirements-icon">
                                    <i class="bi bi-server"></i>
                                </div>
                                <h4 class="requirements-title">Server Requirements</h4>
                            </div>
                            <div class="requirements-content">
                                <?php foreach ($installer_data['system_requirements']['server'] as $key => $value): ?>
                                <div class="requirement-item">
                                    <div class="requirement-label">
                                        <i class="bi bi-<?= $key === 'os' ? 'laptop' : ($key === 'processor' ? 'cpu' : ($key === 'memory' ? 'memory' : ($key === 'storage' ? 'hdd' : 'gear'))) ?>"></i>
                                        <span><?= ucfirst(str_replace('_', ' ', $key)) ?></span>
                                    </div>
                                    <div class="requirement-value"><?= $value ?></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="requirements-card">
                            <div class="requirements-header">
                                <div class="requirements-icon">
                                    <i class="bi bi-laptop"></i>
                                </div>
                                <h4 class="requirements-title">Client Requirements</h4>
                            </div>
                            <div class="requirements-content">
                                <?php foreach ($installer_data['system_requirements']['client'] as $key => $value): ?>
                                <div class="requirement-item">
                                    <div class="requirement-label">
                                        <i class="bi bi-<?= $key === 'browser' ? 'browser-chrome' : ($key === 'javascript' ? 'code-slash' : 'wifi') ?>"></i>
                                        <span><?= ucfirst(str_replace('_', ' ', $key)) ?></span>
                                    </div>
                                    <div class="requirement-value"><?= $value ?></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Installation Steps Section -->
            <section class="installation-section mb-5">
                <div class="section-header mb-4">
                    <h2 class="section-title">Langkah-langkah Instalasi</h2>
                    <p class="section-subtitle">
                        Ikuti panduan instalasi berikut untuk menginstall INLISLite v3 dengan benar
                    </p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="installation-steps">
                            <?php foreach ($installer_data['installation_steps'] as $step): ?>
                            <div class="step-item">
                                <div class="step-number"><?= $step['step'] ?></div>
                                <div class="step-content">
                                    <h5 class="step-title"><?= $step['title'] ?></h5>
                                    <p class="step-description"><?= $step['description'] ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="credentials-card">
                            <div class="credentials-header">
                                <i class="bi bi-key"></i>
                                <h5 class="credentials-title">Default Admin Login</h5>
                            </div>
                            <div class="credentials-content">
                                <div class="credential-row">
                                    <label class="credential-label">Username:</label>
                                    <div class="credential-value">
                                        <code class="credential-code"><?= $installer_data['default_credentials']['username'] ?></code>
                                        <button class="btn btn-sm btn-outline-secondary copy-btn" data-copy="<?= $installer_data['default_credentials']['username'] ?>" title="Copy Username">
                                            <i class="bi bi-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="credential-row">
                                    <label class="credential-label">Password:</label>
                                    <div class="credential-value">
                                        <code class="credential-code"><?= $installer_data['default_credentials']['password'] ?></code>
                                        <button class="btn btn-sm btn-outline-secondary copy-btn" data-copy="<?= $installer_data['default_credentials']['password'] ?>" title="Copy Password">
                                            <i class="bi bi-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
    <script src="<?= base_url('assets/js/public/installer.js') ?>"></script>
</body>
</html>