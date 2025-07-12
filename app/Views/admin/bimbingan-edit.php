<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Bimbingan Teknis - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/bimbingan-edit.css') ?>" rel="stylesheet">
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
                        <h1 class="header-title mb-1">Manajemen Bimbingan Teknis</h1>
                        <p class="header-subtitle mb-0">Kelola program pelatihan dan bimbingan teknis</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/bimbingan') ?>" class="btn btn-outline-light">
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
                        <div class="stat-icon purple">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalTraining">0</h3>
                            <p class="stat-label">Total Bimbingan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="activeTraining">0</h3>
                            <p class="stat-label">Bimbingan Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="scheduledTraining">0</h3>
                            <p class="stat-label">Terjadwal</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="bi bi-star"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="featuredTraining">0</h3>
                            <p class="stat-label">Unggulan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Tabs -->
            <div class="management-tabs">
                <ul class="nav nav-tabs" id="managementTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="training-tab" data-bs-toggle="tab" data-bs-target="#training-panel" type="button" role="tab">
                            <i class="bi bi-collection me-2"></i>Kelola Bimbingan
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="managementTabsContent">
                    <!-- Training Management Panel -->
                    <div class="tab-pane fade show active" id="training-panel" role="tabpanel">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="panel-title">Manajemen Program Bimbingan</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTrainingModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Bimbingan
                                </button>
                            </div>
                        </div>
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table class="table table-hover" id="trainingTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Icon</th>
                                            <th>Program</th>
                                            <th>Kategori</th>
                                            <th>Tipe</th>
                                            <th>Status</th>
                                            <th>Jadwal</th>
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
            console.log('Bimbingan Edit page loaded');
        });
    </script>
</body>
</html>