<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Tentang INLISLite - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/tentang-edit.css') ?>" rel="stylesheet">
    
    <style>
    body {
        background: linear-gradient(135deg, #1C6EC4 0%, #2DA84D 100%);
        min-height: 100vh;
    }
    </style>
    
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <meta name="csrf-hash" content="<?= csrf_hash() ?>">
</head>
<body>
    <!-- Include Enhanced Sidebar -->
    <?= $this->include('admin/partials/sidebar') ?>

    
    <!-- Header Section -->
    <header class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn-back me-3" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <div>
                        <h1 class="header-title mb-1">Manajemen Tentang INLISLite</h1>
                        <p class="header-subtitle mb-0">Kelola konten dan informasi tentang sistem</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/tentang') ?>" class="btn btn-outline-light">
                            <i class="bi bi-eye me-2"></i>Lihat Halaman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="enhanced-main-content">
        <div class="container">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="bi bi-info-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalCards">0</h3>
                            <p class="stat-label">Total Kartu</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="activeCards">0</h3>
                            <p class="stat-label">Kartu Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="bi bi-star"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="featuresCards">0</h3>
                            <p class="stat-label">Kartu Fitur</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="bi bi-gear"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="technicalCards">0</h3>
                            <p class="stat-label">Kartu Teknis</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Tabs -->
            <div class="management-tabs">
                <ul class="nav nav-tabs" id="managementTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="cards-tab" data-bs-toggle="tab" data-bs-target="#cards-panel" type="button" role="tab">
                            <i class="bi bi-collection me-2"></i>Kelola Kartu
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="managementTabsContent">
                    <!-- Cards Management Panel -->
                    <div class="tab-pane fade show active" id="cards-panel" role="tabpanel">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="panel-title">Manajemen Kartu Tentang</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCardModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Kartu
                                </button>
                            </div>
                        </div>
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table class="table table-hover" id="cardsTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Icon</th>
                                            <th>Judul</th>
                                            <th>Kategori</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Card Modal -->
    <div class="modal fade" id="addCardModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kartu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addCardForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cardTitle" class="form-label">Judul Kartu *</label>
                                    <input type="text" class="form-control" id="cardTitle" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cardSubtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="cardSubtitle">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cardContent" class="form-label">Konten *</label>
                            <textarea class="form-control" id="cardContent" rows="5" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="cardCategory" class="form-label">Kategori *</label>
                                    <select class="form-select" id="cardCategory" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="info">Info</option>
                                        <option value="feature">Feature</option>
                                        <option value="contact">Contact</option>
                                        <option value="technical">Technical</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="cardIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" id="cardIcon" placeholder="bi-info-circle">
                                    <div class="form-text">Contoh: bi-info-circle, bi-star, bi-gear</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Preview Icon</label>
                                    <div class="icon-preview" id="cardIconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="cardStatus" class="form-label">Status</label>
                                    <select class="form-select" id="cardStatus">
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveCard()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kartu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editTitle" class="form-label">Judul</label>
                                    <input type="text" class="form-control" id="editTitle" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editSubtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="editSubtitle">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editContent" class="form-label">Konten</label>
                            <textarea class="form-control" id="editContent" rows="5" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editCategory" class="form-label">Kategori</label>
                                    <select class="form-select" id="editCategory" required>
                                        <option value="info">Info</option>
                                        <option value="feature">Feature</option>
                                        <option value="contact">Contact</option>
                                        <option value="technical">Technical</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" id="editIcon">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Preview Icon</label>
                                    <div class="icon-preview" id="editIconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="editStatus" class="form-label">Status</label>
                                    <select class="form-select" id="editStatus">
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="updateCard()">Update</button>
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/admin/tentang-edit.js') ?>"></script>

    <script>
    // Enhanced CSRF token management
    window.csrfToken = "<?= csrf_token() ?>";
    window.csrfHash = "<?= csrf_hash() ?>";
    
    // Function to get fresh CSRF data
    function getCSRFData() {
        return {
            "csrf_test_name": window.csrfHash
        };
    }
    
    // Update CSRF hash after successful requests
    function updateCSRFHash(response) {
        if (response && response.csrf_hash) {
            window.csrfHash = response.csrf_hash;
            document.querySelector('meta[name="csrf-hash"]').setAttribute('content', response.csrf_hash);
        }
    }
    </script>
</body>
</html>