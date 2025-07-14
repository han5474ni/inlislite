<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bimbingan Teknis - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/bimbingan.css') ?>" rel="stylesheet">
    
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
                    <h1 class="main-title">Bimbingan Teknis</h1>
                    <p class="main-subtitle">Pelatihan dan konsultasi</p>
                </div>
            </div>
            

        <div class="container">
            <!-- Page Banner Card -->
            <div class="banner-card mb-5">
                <div class="banner-icon">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="banner-content">
                    <h2 class="banner-title">Bimbingan Teknis</h2>
                    <h3 class="banner-subtitle">INLISLite v3</h3>
                    <p class="banner-description">
                        Layanan pelatihan dan konsultasi teknis untuk memastikan implementasi sistem berjalan optimal dan sesuai kebutuhan.
                    </p>
                </div>
            </div>

            <!-- Search and Action Section -->
            <div class="search-action-section mb-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="search-box">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari konten...">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <a href="<?= base_url('admin/bimbingan-edit') ?>" class="btn btn-success me-2">
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
                    <h2 class="section-title">Konten Bimbingan Teknis</h2>
                    <p class="section-subtitle">
                        Kelola dan atur konten Bimbingan Teknis untuk memberikan informasi terbaik kepada pengguna
                    </p>
                </div>
                
                <div class="row g-4" id="contentContainer">
                    <!-- Content will be loaded here -->
                </div>
            </section>
        </div>
        </div>
    </main>



    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId">
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="editTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSubtitle" class="form-label">Subtitle</label>
                            <input type="text" class="form-control" id="editSubtitle">
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editCategory" class="form-label">Kategori</label>
                                    <select class="form-select" id="editCategory">
                                        <option value="general">Umum</option>
                                        <option value="technical">Teknis</option>
                                        <option value="tutorial">Tutorial</option>
                                        <option value="update">Update</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editPriority" class="form-label">Prioritas</label>
                                    <select class="form-select" id="editPriority">
                                        <option value="low">Rendah</option>
                                        <option value="medium">Sedang</option>
                                        <option value="high">Tinggi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="updateItem()">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/admin/bimbingan.js') ?>"></script>
</body>
</html>