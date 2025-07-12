<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patch & Updater - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/patch.css') ?>" rel="stylesheet">
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
                        <h1 class="header-title mb-1">Patch & Updater</h1>
                        <p class="header-subtitle mb-0">Pembaruan dan perbaikan sistem</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/patch-edit') ?>" class="btn btn-primary">
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
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div class="banner-content">
                    <h2 class="banner-title">Patch & Updater</h2>
                    <h3 class="banner-subtitle">INLISLite v3</h3>
                    <p class="banner-description">
                        Sistem pembaruan otomatis untuk menjaga aplikasi tetap terkini dengan fitur terbaru dan perbaikan keamanan.
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
                        <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addItemModal">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Item
                        </button>
                        <button class="btn btn-info" onclick="refreshContent()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <section class="content-section">
                <div class="section-header mb-4">
                    <h2 class="section-title">Konten Patch & Updater</h2>
                    <p class="section-subtitle">
                        Kelola dan atur konten Patch & Updater untuk memberikan informasi terbaik kepada pengguna
                    </p>
                </div>
                
                <div class="row g-4" id="contentContainer">
                    <!-- Content will be loaded here -->
                </div>
            </section>
        </div>
    </main>

    <!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Item Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addItemForm">
                        <div class="mb-3">
                            <label for="itemTitle" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="itemTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="itemSubtitle" class="form-label">Subtitle</label>
                            <input type="text" class="form-control" id="itemSubtitle">
                        </div>
                        <div class="mb-3">
                            <label for="itemDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="itemDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="itemCategory" class="form-label">Kategori</label>
                                    <select class="form-select" id="itemCategory">
                                        <option value="general">Umum</option>
                                        <option value="technical">Teknis</option>
                                        <option value="tutorial">Tutorial</option>
                                        <option value="update">Update</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="itemPriority" class="form-label">Prioritas</label>
                                    <select class="form-select" id="itemPriority">
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
                    <button type="button" class="btn btn-primary" onclick="saveItem()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

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
    <script src="<?= base_url('assets/js/admin/patch.js') ?>"></script>
</body>
</html>