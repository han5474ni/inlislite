<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Patch dan Updater - INLISlite v3.0' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/patch.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i data-feather="menu"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="INLISLite Logo" style="width: 24px; height: 24px;">
                </div>
                <div class="sidebar-title">
                    INLISlite v3.0<br>
                    <small style="font-size: 0.85rem; opacity: 0.8;">Dashboard</small>
                </div>
            </a>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i data-feather="chevrons-left"></i>
            </button>
        </div>
        
        <div class="sidebar-nav">
            <div class="nav-item">
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
                    <i data-feather="home" class="nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="nav-tooltip">Dashboard</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/users') ?>" class="nav-link">
                    <i data-feather="users" class="nav-icon"></i>
                    <span class="nav-text">Manajemen User</span>
                </a>
                <div class="nav-tooltip">Manajemen User</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('registration') ?>" class="nav-link">
                    <i data-feather="book" class="nav-icon"></i>
                    <span class="nav-text">Registrasi</span>
                </a>
                <div class="nav-tooltip">Registrasi</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/profile') ?>" class="nav-link">
                    <i data-feather="user" class="nav-icon"></i>
                    <span class="nav-text">Profile</span>
                </a>
                <div class="nav-tooltip">Profile</div>
            </div>
            
            <!-- Logout Button -->
            <div class="nav-item logout-item">
                <a href="<?= base_url('admin/secure-logout') ?>" class="nav-link logout-link" onclick="return confirmLogout()">
                    <i data-feather="log-out" class="nav-icon"></i>
                    <span class="nav-text">Logout</span>
                </a>
                <div class="nav-tooltip">Logout</div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
            <!-- Top Navigation -->
            <nav class="top-nav sticky-top">
                <div class="container-fluid">
                    <div class="nav-content">
                        <div class="nav-left">
                            <a href="<?= base_url('admin/dashboard') ?>" class="back-btn" title="Kembali ke Dashboard">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                            <div class="logo-section">
                                <div class="logo-icon">
                                    <i class="bi bi-download"></i>
                                </div>
                                <div class="nav-text">
                                    <h1 class="nav-title">Patch & Updater</h1>
                                    <p class="nav-subtitle">Unduh dan instalasi paket pembaruan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="page-content">
                <div class="container-fluid">
                    <!-- Header Section -->
                    <div class="header-section">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="text-center mb-5">
                                    <div class="header-icon">
                                        <i class="bi bi-download"></i>
                                    </div>
                                    <h1 class="header-title">Patch & Updater INLISLite Versi 3 PHP Opensource</h1>
                                    <p class="header-subtitle">Sistem pembaruan otomatis untuk memutakhirkan instalasi INLISLite v3 dengan fitur terbaru dan perbaikan bug secara kumulatif.</p>
                                </div>
                            </div>
                        </div>
                    </div>

            <!-- Alert Messages -->
            <div id="alertContainer">
                <?php if (session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i><?= esc(session('success')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session('error') || isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= esc(session('error') ?? $error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Information Card -->
            <div class="info-card card">
                <div class="card-header">
                    <div class="card-title-section">
                        <h3 class="card-title mb-1">Paket Updater INLISLite versi 3 PHP-Opensource</h3>
                        <p class="card-subtitle text-muted mb-0">Sistem pembaruan otomatis untuk INLISLite v3</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="info-content">
                        <p class="mb-3">Unduh dan terapkan pembaruan kumulatif untuk INLISLite v3. Updater ini ditujukan untuk memutakhirkan paket instalasi sebelumnya dengan fitur terbaru dan perbaikan bug.</p>
                        
                        <!-- Warning Alert -->
                        <div class="alert alert-warning d-flex align-items-start mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-3 mt-1"></i>
                            <div>
                                <strong>Penting:</strong> Jika Anda sedang melakukan migrasi data dari v2.1.2 atau aplikasi lain ke INLISLite v3, jangan terapkan updater kumulatif ini. Terapkan updater ini hanya setelah proses migrasi selesai, karena terdapat perubahan struktur basis data yang belum didukung oleh alat migrasi.
                            </div>
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info d-flex align-items-start mb-4">
                            <i class="bi bi-info-circle-fill me-3 mt-1"></i>
                            <div>
                                <strong>Petunjuk Update:</strong>
                                <ol class="mb-0 mt-2">
                                    <li>Backup instalasi INLISLite Anda saat ini</li>
                                    <li>Buka arsip 7z yang telah diunduh menggunakan 7zip atau WinRAR</li>
                                    <li>Ekstrak folder inlislite3 ke direktori C:/xampp/htdocs/ dan timpa (overwrite) file yang sudah ada</li>
                                    <li>Jalankan aplikasi INLISLite dan login ke modul backoffice</li>
                                    <li>Arahkan ke Administration → General Settings → Update Settings, lalu klik tombol Update</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patches Management Section -->
            <div class="patches-section card">
                <div class="card-header d-flex justify-content-between align-items-start">
                    <div class="card-title-section">
                        <h3 class="card-title mb-1">Update Packages</h3>
                        <p class="card-subtitle text-muted mb-0">Kelola patch, pembaruan, dan rilis INLISLite</p>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatchModal">
                        <i class="bi bi-plus-circle me-2"></i>Add Package
                    </button>
                </div>
                
                <div class="card-body">
                    <!-- Search and Filter -->
                    <div class="search-filter-section mb-4">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="search-input-wrapper">
                                    <i class="bi bi-search search-icon"></i>
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search package..." value="<?= esc($search ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="filter-wrapper">
                                    <i class="bi bi-funnel filter-icon"></i>
                                    <select id="priorityFilter" class="form-select">
                                        <option value="">All Priorities</option>
                                        <option value="High" <?= ($priority ?? '') === 'High' ? 'selected' : '' ?>>High</option>
                                        <option value="Medium" <?= ($priority ?? '') === 'Medium' ? 'selected' : '' ?>>Medium</option>
                                        <option value="Low" <?= ($priority ?? '') === 'Low' ? 'selected' : '' ?>>Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Results Header -->
                    <div class="results-header mb-3">
                        <h5 class="results-title">Available Updates (<span id="patchCount"><?= count($patches ?? []) ?></span>)</h5>
                        <p class="results-subtitle text-muted">Browse and download INLISLite update packages</p>
                    </div>

                    <!-- Patches Grid -->
                    <div class="patches-grid" id="patchesGrid">
                        <?php if (!empty($patches)): ?>
                            <?php foreach ($patches as $patch): ?>
                                <div class="patch-card" data-priority="<?= esc($patch['prioritas']) ?>">
                                    <div class="patch-card-header">
                                        <div class="patch-info">
                                            <h6 class="patch-title"><?= esc($patch['nama_paket']) ?></h6>
                                            <p class="patch-description"><?= esc($patch['deskripsi']) ?></p>
                                        </div>
                                        <div class="dropdown">
                                            <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item btn-edit" href="#" data-id="<?= $patch['id'] ?>"><i class="bi bi-pencil me-2"></i>Edit Package</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item delete-patch text-danger" href="#" data-id="<?= $patch['id'] ?>"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="patch-card-body">
                                        <div class="patch-badges">
                                            <span class="badge version-badge">v<?= esc($patch['versi']) ?></span>
                                            <span class="badge priority-badge priority-<?= strtolower($patch['prioritas']) ?>"><?= esc($patch['prioritas']) ?></span>
                                        </div>
                                        
                                        <div class="patch-stats">
                                            <div class="stat-item">
                                                <i class="bi bi-download"></i>
                                                <span><?= number_format($patch['jumlah_unduhan'] ?? 0) ?> downloads</span>
                                            </div>
                                            <div class="stat-item">
                                                <i class="bi bi-hdd"></i>
                                                <span><?= esc($patch['ukuran']) ?></span>
                                            </div>
                                            <div class="stat-item">
                                                <i class="bi bi-calendar"></i>
                                                <span><?= esc(date('M d, Y', strtotime($patch['tanggal_rilis']))) ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="patch-actions">
                                            <button class="btn btn-primary btn-download" data-id="<?= $patch['id'] ?>">
                                                <i class="bi bi-download me-2"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Edit Form (Hidden by default) -->
                                    <div class="patch-edit-form d-none">
                                        <form class="edit-patch-form" data-id="<?= $patch['id'] ?>">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Package Name</label>
                                                <input type="text" class="form-control edit-nama" value="<?= esc($patch['nama_paket']) ?>" required>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Version</label>
                                                    <input type="text" class="form-control edit-versi" value="<?= esc($patch['versi']) ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Priority</label>
                                                    <select class="form-select edit-prioritas" required>
                                                        <option value="High" <?= $patch['prioritas'] === 'High' ? 'selected' : '' ?>>High</option>
                                                        <option value="Medium" <?= $patch['prioritas'] === 'Medium' ? 'selected' : '' ?>>Medium</option>
                                                        <option value="Low" <?= $patch['prioritas'] === 'Low' ? 'selected' : '' ?>>Low</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Size</label>
                                                    <input type="text" class="form-control edit-ukuran" value="<?= esc($patch['ukuran']) ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Release Date</label>
                                                    <input type="date" class="form-control edit-tanggal" value="<?= esc($patch['tanggal_rilis']) ?>" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Description</label>
                                                <textarea class="form-control edit-deskripsi" rows="3" required><?= esc($patch['deskripsi']) ?></textarea>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-primary save-patch">
                                                    <i class="bi bi-check-lg me-2"></i>Save
                                                </button>
                                                <button type="button" class="btn btn-secondary cancel-edit">
                                                    <i class="bi bi-x-lg me-2"></i>Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h5>No patches available</h5>
                                <p>No patch packages have been added to the system yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </main>

    <!-- Add Patch Modal -->
    <div class="modal fade" id="addPatchModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>
                        Add New Package
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addPatchForm">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="nama_paket" class="form-label fw-semibold">Package Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_paket" name="nama_paket" placeholder="INLISLite v3.2 Cumulative Updater" required>
                            </div>
                            <div class="col-md-6">
                                <label for="versi" class="form-label fw-semibold">Version <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="versi" name="versi" placeholder="3.2.1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="prioritas" class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
                                <select class="form-select" id="prioritas" name="prioritas" required>
                                    <option value="">Select Priority</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="ukuran" class="form-label fw-semibold">File Size <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ukuran" name="ukuran" placeholder="15.2 MB" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_rilis" class="form-label fw-semibold">Release Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_rilis" name="tanggal_rilis" required>
                            </div>
                            <div class="col-12">
                                <label for="deskripsi" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Updater ini ditujukan untuk memperbaharui paket instalasi INLISLite v3 sebelumnya..." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Add Package
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- Custom JavaScript -->
    <script>
        // Global variables for JavaScript
        window.patchConfig = {
            baseUrl: '<?= base_url("admin/patches/ajax") ?>',
            csrfToken: '<?= csrf_token() ?>',
            csrfHash: '<?= csrf_hash() ?>'
        };
    </script>
    <script src="<?= base_url('assets/js/admin/patch.js') ?>"></script>
    
    <script>
        // Logout confirmation function
        function confirmLogout() {
            return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
        }

        // Initialize Feather icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            
            // Clear any active menu state since patch page doesn't have active menu in sidebar
            sessionStorage.removeItem('activeMenu');
            
            // Remove active class from all sidebar links since this page is not in the main navigation
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
        });
    </script>
</body>
</html>