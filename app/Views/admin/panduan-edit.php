<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Panduan - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/panduan-edit.css') ?>" rel="stylesheet">
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
                        <h1 class="header-title mb-1">Manajemen Panduan</h1>
                        <p class="header-subtitle mb-0">Kelola dokumentasi dan panduan sistem</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/panduan') ?>" class="btn btn-outline-light">
                            <i class="bi bi-eye me-2"></i>Lihat Halaman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-book"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalGuides">0</h3>
                            <p class="stat-label">Total Panduan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="activeGuides">0</h3>
                            <p class="stat-label">Panduan Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="bi bi-star"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="featuredGuides">0</h3>
                            <p class="stat-label">Panduan Unggulan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="bi bi-download"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalDownloads">0</h3>
                            <p class="stat-label">Total Unduhan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Tabs -->
            <div class="management-tabs">
                <ul class="nav nav-tabs" id="managementTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="guides-tab" data-bs-toggle="tab" data-bs-target="#guides-panel" type="button" role="tab">
                            <i class="bi bi-collection me-2"></i>Kelola Panduan
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="managementTabsContent">
                    <!-- Guides Management Panel -->
                    <div class="tab-pane fade show active" id="guides-panel" role="tabpanel">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="panel-title">Manajemen Dokumen Panduan</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGuideModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Panduan
                                </button>
                            </div>
                        </div>
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table class="table table-hover" id="guidesTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Icon</th>
                                            <th>Panduan</th>
                                            <th>Kategori</th>
                                            <th>Versi</th>
                                            <th>Status</th>
                                            <th>Unduhan</th>
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

    <!-- Add Guide Modal -->
    <div class="modal fade" id="addGuideModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Panduan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addGuideForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="guideTitle" class="form-label">Judul Panduan *</label>
                                    <input type="text" class="form-control" id="guideTitle" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="guideSubtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="guideSubtitle">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="guideDescription" class="form-label">Deskripsi *</label>
                            <textarea class="form-control" id="guideDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="guideCategory" class="form-label">Kategori *</label>
                                    <select class="form-select" id="guideCategory" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="installation">Installation</option>
                                        <option value="configuration">Configuration</option>
                                        <option value="user_guide">User Guide</option>
                                        <option value="technical">Technical</option>
                                        <option value="api">API Documentation</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="guideFileType" class="form-label">Tipe File</label>
                                    <select class="form-select" id="guideFileType">
                                        <option value="pdf">PDF</option>
                                        <option value="doc">DOC</option>
                                        <option value="docx">DOCX</option>
                                        <option value="html">HTML</option>
                                        <option value="video">Video</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="guideLanguage" class="form-label">Bahasa</label>
                                    <select class="form-select" id="guideLanguage">
                                        <option value="id">Indonesia</option>
                                        <option value="en">English</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="guideIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" id="guideIcon" placeholder="bi-book">
                                    <div class="form-text">Contoh: bi-book, bi-file-text, bi-play</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Preview Icon</label>
                                    <div class="icon-preview" id="guideIconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="guideStatus" class="form-label">Status</label>
                                    <select class="form-select" id="guideStatus">
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="guideVersion" class="form-label">Versi</label>
                                    <input type="text" class="form-control" id="guideVersion" placeholder="3.0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="guideFileSize" class="form-label">Ukuran File</label>
                                    <input type="text" class="form-control" id="guideFileSize" placeholder="2.5 MB">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="guideSortOrder" class="form-label">Urutan Tampil</label>
                                    <input type="number" class="form-control" id="guideSortOrder" min="1" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="guideFileUrl" class="form-label">URL File</label>
                            <input type="url" class="form-control" id="guideFileUrl" placeholder="https://example.com/guide.pdf">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="guideFeatured">
                                <label class="form-check-label" for="guideFeatured">
                                    Jadikan panduan unggulan
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveGuide()">Simpan</button>
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
    <script src="<?= base_url('assets/js/admin/panduan-edit.js') ?>"></script>
</body>
</html>