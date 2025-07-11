<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Kelola Kartu Tentang - INLISlite v3.0' ?></title>
    
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
    <!-- Tentang CSS for consistent header styling -->
    <link href="<?= base_url('assets/css/admin/tentang.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/tentang-edit.css') ?>" rel="stylesheet">
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
                        <a href="<?= base_url('admin/tentang') ?>" class="back-btn" title="Kembali ke Tentang">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div class="logo-section">
                            <div class="logo-icon">
                                <i class="bi bi-gear-fill"></i>
                            </div>
                            <div class="nav-text">
                                <h1 class="nav-title">Kelola Kartu Tentang</h1>
                                <p class="nav-subtitle">Tambah, edit, dan hapus kartu informasi tentang sistem</p>
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
                                    <i class="bi bi-gear-fill"></i>
                                </div>
                                <h1 class="header-title">Kelola Kartu Tentang</h1>
                                <p class="header-subtitle">Kelola semua kartu informasi yang ditampilkan di halaman tentang. Tambah, edit, atau hapus kartu sesuai kebutuhan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- Action Section -->
                <div class="row justify-content-center mb-4">
                    <div class="col-12">
                        <div class="action-section">
                            <button class="btn btn-add-card" id="btnAddCard">
                                <i class="bi bi-plus-circle me-2"></i>
                                Tambah Card Tentang
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cards List Section -->
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="cards-management-section card">
                            <div class="card-header">
                                <div class="management-header">
                                    <div class="management-icon">
                                        <i class="bi bi-collection"></i>
                                    </div>
                                    <div class="management-title-section">
                                        <h5 class="management-title">Daftar Kartu Tentang</h5>
                                        <p class="management-subtitle">Kelola semua kartu informasi yang tersedia</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Loading State -->
                                <div id="loadingState" class="text-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-3 text-muted">Memuat data kartu tentang...</p>
                                </div>

                                <!-- Cards Table -->
                                <div id="cardsTable" class="table-responsive" style="display: none;">
                                    <table class="table cards-table">
                                        <thead>
                                            <tr>
                                                <th>Kartu</th>
                                                <th>Kategori</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cardsTableBody">
                                            <!-- Dynamic content will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Empty State -->
                                <div id="emptyState" class="text-center py-5" style="display: none;">
                                    <div class="empty-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h5 class="empty-title">Belum Ada Kartu Tentang</h5>
                                    <p class="empty-description">Mulai dengan menambahkan kartu informasi pertama Anda.</p>
                                    <button class="btn btn-primary btn-add-first" id="btnAddFirstCard">
                                        <i class="bi bi-plus-circle me-2"></i>
                                        Tambah Kartu Pertama
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add/Edit Card Modal -->
    <div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cardModalLabel">Tambah Card Tentang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cardForm">
                        <input type="hidden" id="cardId" name="id">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="cardTitle" class="form-label">Judul Kartu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cardTitle" name="title" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cardSubtitle" class="form-label">Subtitle</label>
                                <input type="text" class="form-control" id="cardSubtitle" name="subtitle">
                            </div>
                            <div class="col-md-6">
                                <label for="cardCategory" class="form-label">Kategori</label>
                                <select class="form-select" id="cardCategory" name="category">
                                    <option value="overview">Overview</option>
                                    <option value="legal">Legal Framework</option>
                                    <option value="features">Features</option>
                                    <option value="technical">Technical</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="cardStatus" class="form-label">Status</label>
                                <select class="form-select" id="cardStatus" name="status">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="cardContent" class="form-label">Konten <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="cardContent" name="content" rows="8" required></textarea>
                                <div class="form-text">Gunakan HTML untuk formatting. Contoh: &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;</div>
                            </div>
                            <div class="col-md-6">
                                <label for="cardIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                <input type="text" class="form-control" id="cardIcon" name="icon" placeholder="bi-info-circle">
                                <div class="form-text">Contoh: bi-info-circle, bi-shield-check, bi-gear</div>
                            </div>
                            <div class="col-md-6">
                                <label for="sortOrder" class="form-label">Urutan Tampil</label>
                                <input type="number" class="form-control" id="sortOrder" name="sort_order" min="1" value="1">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveCardBtn">
                        <i class="bi bi-check-circle me-2"></i>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="delete-icon">
                            <i class="bi bi-exclamation-triangle text-warning"></i>
                        </div>
                        <h6 class="mt-3">Apakah Anda yakin ingin menghapus kartu ini?</h6>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="bi bi-trash me-2"></i>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url('assets/js/admin/tentang-edit.js') ?>"></script>
    
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
        });
    </script>
</body>
</html>