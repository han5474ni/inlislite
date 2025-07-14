<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Dukungan Teknis - INLISLite v3.0</title>
    
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
    <link href="<?= base_url('assets/css/admin/dukungan-edit.css') ?>" rel="stylesheet">
    
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

    
    <!-- Header Section -->
    <header class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn-back me-3" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <div>
                        <h1 class="header-title mb-1">Manajemen Dukungan Teknis</h1>
                        <p class="header-subtitle mb-0">Kelola layanan dukungan dan bantuan teknis</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/dukungan') ?>" class="btn btn-outline-light">
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
                            <i class="bi bi-headset"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalSupport">0</h3>
                            <p class="stat-label">Total Dukungan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="activeSupport">0</h3>
                            <p class="stat-label">Dukungan Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="bi bi-star"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="featuredSupport">0</h3>
                            <p class="stat-label">Dukungan Unggulan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon red">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="urgentSupport">0</h3>
                            <p class="stat-label">Dukungan Urgent</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Tabs -->
            <div class="management-tabs">
                <ul class="nav nav-tabs" id="managementTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="support-tab" data-bs-toggle="tab" data-bs-target="#support-panel" type="button" role="tab">
                            <i class="bi bi-collection me-2"></i>Kelola Dukungan
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="managementTabsContent">
                    <!-- Support Management Panel -->
                    <div class="tab-pane fade show active" id="support-panel" role="tabpanel">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="panel-title">Manajemen Layanan Dukungan</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupportModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Dukungan
                                </button>
                            </div>
                        </div>
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table class="table table-hover" id="supportTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Icon</th>
                                            <th>Layanan</th>
                                            <th>Kategori</th>
                                            <th>Prioritas</th>
                                            <th>Status</th>
                                            <th>Kontak</th>
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

    <!-- Add Support Modal -->
    <div class="modal fade" id="addSupportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Layanan Dukungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addSupportForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="supportTitle" class="form-label">Nama Layanan *</label>
                                    <input type="text" class="form-control" id="supportTitle" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="supportSubtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="supportSubtitle">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="supportDescription" class="form-label">Deskripsi *</label>
                            <textarea class="form-control" id="supportDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="supportCategory" class="form-label">Kategori *</label>
                                    <select class="form-select" id="supportCategory" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="technical">Technical Support</option>
                                        <option value="general">General Support</option>
                                        <option value="installation">Installation Help</option>
                                        <option value="troubleshooting">Troubleshooting</option>
                                        <option value="faq">FAQ</option>
                                        <option value="contact">Contact Info</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="supportPriority" class="form-label">Prioritas</label>
                                    <select class="form-select" id="supportPriority">
                                        <option value="low">Rendah</option>
                                        <option value="medium">Sedang</option>
                                        <option value="high">Tinggi</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="supportStatus" class="form-label">Status</label>
                                    <select class="form-select" id="supportStatus">
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="supportIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" id="supportIcon" placeholder="bi-headset">
                                    <div class="form-text">Contoh: bi-headset, bi-telephone, bi-envelope</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Preview Icon</label>
                                    <div class="icon-preview" id="supportIconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="supportSortOrder" class="form-label">Urutan Tampil</label>
                                    <input type="number" class="form-control" id="supportSortOrder" min="1" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="supportEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="supportEmail" placeholder="support@inlislite.com">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="supportPhone" class="form-label">Telepon</label>
                                    <input type="tel" class="form-control" id="supportPhone" placeholder="+62-21-1234567">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="supportUrl" class="form-label">URL</label>
                                    <input type="url" class="form-control" id="supportUrl" placeholder="https://support.inlislite.com">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="supportContactInfo" class="form-label">Informasi Kontak Tambahan</label>
                            <textarea class="form-control" id="supportContactInfo" rows="3" placeholder="Jam operasional, alamat, atau informasi kontak lainnya"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="supportFeatured">
                                <label class="form-check-label" for="supportFeatured">
                                    Jadikan layanan unggulan
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveSupport()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Support Modal -->
    <div class="modal fade" id="editSupportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Layanan Dukungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editSupportForm">
                        <input type="hidden" id="editSupportId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editSupportTitle" class="form-label">Nama Layanan</label>
                                    <input type="text" class="form-control" id="editSupportTitle" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editSupportSubtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="editSupportSubtitle">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editSupportDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editSupportDescription" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editSupportCategory" class="form-label">Kategori</label>
                                    <select class="form-select" id="editSupportCategory" required>
                                        <option value="technical">Technical Support</option>
                                        <option value="general">General Support</option>
                                        <option value="installation">Installation Help</option>
                                        <option value="troubleshooting">Troubleshooting</option>
                                        <option value="faq">FAQ</option>
                                        <option value="contact">Contact Info</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editSupportPriority" class="form-label">Prioritas</label>
                                    <select class="form-select" id="editSupportPriority">
                                        <option value="low">Rendah</option>
                                        <option value="medium">Sedang</option>
                                        <option value="high">Tinggi</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editSupportStatus" class="form-label">Status</label>
                                    <select class="form-select" id="editSupportStatus">
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editSupportIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" id="editSupportIcon">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Preview Icon</label>
                                    <div class="icon-preview" id="editSupportIconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editSupportSortOrder" class="form-label">Urutan Tampil</label>
                                    <input type="number" class="form-control" id="editSupportSortOrder" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editSupportEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="editSupportEmail">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editSupportPhone" class="form-label">Telepon</label>
                                    <input type="tel" class="form-control" id="editSupportPhone">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editSupportUrl" class="form-label">URL</label>
                                    <input type="url" class="form-control" id="editSupportUrl">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editSupportContactInfo" class="form-label">Informasi Kontak Tambahan</label>
                            <textarea class="form-control" id="editSupportContactInfo" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="editSupportFeatured">
                                <label class="form-check-label" for="editSupportFeatured">
                                    Jadikan layanan unggulan
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="updateSupport()">Update</button>
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
    <script src="<?= base_url('assets/js/admin/dukungan-edit.js') ?>"></script>
</body>
</html>