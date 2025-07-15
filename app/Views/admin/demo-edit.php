<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Demo Program - INLISLite v3.0</title>
    
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
    <link href="<?= base_url('assets/css/admin/demo-edit.css') ?>" rel="stylesheet">
    
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
                        <h1 class="header-title mb-1">Manajemen Demo Program</h1>
                        <p class="header-subtitle mb-0">Kelola demo dan showcase fitur sistem</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/demo') ?>" class="btn btn-outline-light">
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
                        <div class="stat-icon red">
                            <i class="bi bi-play-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalDemo">0</h3>
                            <p class="stat-label">Total Demo</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="activeDemo">0</h3>
                            <p class="stat-label">Demo Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="bi bi-star"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="featuredDemo">0</h3>
                            <p class="stat-label">Demo Unggulan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="bi bi-eye"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalViews">0</h3>
                            <p class="stat-label">Total Views</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Tabs -->
            <div class="management-tabs">
                <ul class="nav nav-tabs" id="managementTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="demo-tab" data-bs-toggle="tab" data-bs-target="#demo-panel" type="button" role="tab">
                            <i class="bi bi-collection me-2"></i>Kelola Demo
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="managementTabsContent">
                    <!-- Demo Management Panel -->
                    <div class="tab-pane fade show active" id="demo-panel" role="tabpanel">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="panel-title">Manajemen Demo Program</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDemoModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Demo
                                </button>
                            </div>
                        </div>
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table class="table table-hover" id="demoTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Icon</th>
                                            <th>Demo</th>
                                            <th>Kategori</th>
                                            <th>Tipe</th>
                                            <th>Status</th>
                                            <th>Views</th>
                                            <th>File</th>
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
    <script>
        // Basic initialization to prevent errors
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Demo Edit page loaded');
        });
    </script>
    
    <!-- Add Demo Modal -->
    <div class="modal fade" id="addDemoModal" tabindex="-1" aria-labelledby="addDemoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDemoModalLabel">Tambah Demo Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDemoForm" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="demoTitle" class="form-label">Judul Demo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="demoTitle" name="title" required>
                            </div>
                            <div class="col-md-6">
                                <label for="demoSubtitle" class="form-label">Subjudul</label>
                                <input type="text" class="form-control" id="demoSubtitle" name="subtitle">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="demoCategory" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="demoCategory" name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="katalogisasi">Katalogisasi</option>
                                    <option value="sirkulasi">Sirkulasi</option>
                                    <option value="keanggotaan">Keanggotaan</option>
                                    <option value="opac">OPAC</option>
                                    <option value="administrasi">Administrasi</option>
                                    <option value="pelaporan">Pelaporan</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="demoType" class="form-label">Tipe Demo <span class="text-danger">*</span></label>
                                <select class="form-select" id="demoType" name="demo_type" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="interactive">Interactive</option>
                                    <option value="video">Video</option>
                                    <option value="screenshot">Screenshot</option>
                                    <option value="tutorial">Tutorial</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="demoStatus" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="demoStatus" name="status" required>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Non-Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="demoDescription" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="demoDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="demoUrl" class="form-label">URL Demo</label>
                                <input type="url" class="form-control" id="demoUrl" name="demo_url" placeholder="https://">
                            </div>
                            <div class="col-md-6">
                                <label for="demoVersion" class="form-label">Versi</label>
                                <input type="text" class="form-control" id="demoVersion" name="version">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="demoIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                <input type="text" class="form-control" id="demoIcon" name="icon" placeholder="play-circle">
                                <small class="text-muted">Nama icon dari <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a></small>
                            </div>
                            <div class="col-md-6">
                                <label for="demoSortOrder" class="form-label">Urutan</label>
                                <input type="number" class="form-control" id="demoSortOrder" name="sort_order" value="1" min="1">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="demoFeatures" class="form-label">Fitur (dipisahkan dengan koma)</label>
                            <input type="text" class="form-control" id="demoFeatures" name="features" placeholder="Katalogisasi, Sirkulasi, OPAC">
                        </div>
                        <div class="mb-3">
                            <label for="demoAccessLevel" class="form-label">Level Akses</label>
                            <select class="form-select" id="demoAccessLevel" name="access_level">
                                <option value="public">Publik</option>
                                <option value="member">Member</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="demoFile" class="form-label">File Demo (PDF/ZIP)</label>
                            <input type="file" class="form-control" id="demoFile" name="demo_file" accept=".pdf,.zip,.rar">
                            <small class="text-muted">Upload file demo untuk diunduh pengguna (maks. 10MB)</small>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="demoFeatured" name="is_featured">
                            <label class="form-check-label" for="demoFeatured">Tampilkan sebagai Unggulan</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveDemo()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Demo Modal -->
    <div class="modal fade" id="editDemoModal" tabindex="-1" aria-labelledby="editDemoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDemoModalLabel">Edit Demo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDemoForm" enctype="multipart/form-data">
                        <input type="hidden" id="editDemoId" name="id">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editDemoTitle" class="form-label">Judul Demo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editDemoTitle" name="title" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editDemoSubtitle" class="form-label">Subjudul</label>
                                <input type="text" class="form-control" id="editDemoSubtitle" name="subtitle">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editDemoCategory" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="editDemoCategory" name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="katalogisasi">Katalogisasi</option>
                                    <option value="sirkulasi">Sirkulasi</option>
                                    <option value="keanggotaan">Keanggotaan</option>
                                    <option value="opac">OPAC</option>
                                    <option value="administrasi">Administrasi</option>
                                    <option value="pelaporan">Pelaporan</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editDemoType" class="form-label">Tipe Demo <span class="text-danger">*</span></label>
                                <select class="form-select" id="editDemoType" name="demo_type" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="interactive">Interactive</option>
                                    <option value="video">Video</option>
                                    <option value="screenshot">Screenshot</option>
                                    <option value="tutorial">Tutorial</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editDemoStatus" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="editDemoStatus" name="status" required>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Non-Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editDemoDescription" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="editDemoDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editDemoUrl" class="form-label">URL Demo</label>
                                <input type="url" class="form-control" id="editDemoUrl" name="demo_url" placeholder="https://">
                            </div>
                            <div class="col-md-6">
                                <label for="editDemoVersion" class="form-label">Versi</label>
                                <input type="text" class="form-control" id="editDemoVersion" name="version">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editDemoIcon" class="form-label">Icon (Bootstrap Icons)</label>
                                <input type="text" class="form-control" id="editDemoIcon" name="icon" placeholder="play-circle">
                                <small class="text-muted">Nama icon dari <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a></small>
                            </div>
                            <div class="col-md-6">
                                <label for="editDemoSortOrder" class="form-label">Urutan</label>
                                <input type="number" class="form-control" id="editDemoSortOrder" name="sort_order" value="1" min="1">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editDemoFeatures" class="form-label">Fitur (dipisahkan dengan koma)</label>
                            <input type="text" class="form-control" id="editDemoFeatures" name="features" placeholder="Katalogisasi, Sirkulasi, OPAC">
                        </div>
                        <div class="mb-3">
                            <label for="editDemoAccessLevel" class="form-label">Level Akses</label>
                            <select class="form-select" id="editDemoAccessLevel" name="access_level">
                                <option value="public">Publik</option>
                                <option value="member">Member</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editDemoFile" class="form-label">File Demo (PDF/ZIP)</label>
                            <input type="file" class="form-control" id="editDemoFile" name="demo_file" accept=".pdf,.zip,.rar">
                            <small class="text-muted">Upload file demo untuk diunduh pengguna (maks. 10MB)</small>
                        </div>
                        <div id="currentFileInfo" class="mb-3 d-none">
                            <div class="alert alert-info">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark me-2"></i>
                                    <div>
                                        <strong>File saat ini:</strong> <span id="currentFileName"></span>
                                        <br>
                                        <small class="text-muted">Ukuran: <span id="currentFileSize"></span></small>
                                    </div>
                                    <div class="ms-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="removeFile" name="remove_file">
                                            <label class="form-check-label" for="removeFile">Hapus file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="editDemoFeatured" name="is_featured">
                            <label class="form-check-label" for="editDemoFeatured">Tampilkan sebagai Unggulan</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="updateDemo()">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Demo Edit JS -->
    <script src="<?= base_url('assets/js/admin/demo-edit.js') ?>"></script>
</body>
</html>