<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'User Manajemen - INLISlite v3.0' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/user_management.css') ?>" rel="stylesheet">
    
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
                <a href="<?= base_url('admin/users') ?>" class="nav-link active">
                    <i data-feather="users" class="nav-icon"></i>
                    <span class="nav-text">Manajemen User</span>
                </a>
                <div class="nav-tooltip">Manajemen User</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/registration') ?>" class="nav-link">
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
        <div class="page-container">
            <!-- Page Header -->
            <div class="page-header">
                <div class="header-top">
                    <div class="header-left">
                        <div class="header-icon">
                            <i class="bi bi-users"></i>
                        </div>
                        <div>
                            <h1 class="page-title">User Manajemen</h1>
                            <p class="page-subtitle">Kelola pengguna sistem dan hak aksesnya</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Statistics Chart Section -->
            <div class="statistics-section">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-bar-chart-fill me-2"></i>
                            User Statistics by Year
                        </h5>
                        <div class="chart-controls">
                            <select class="form-select form-select-sm" id="yearFilter" style="width: auto;">
                                <option value="all">All Years</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="userChart" width="400" height="200"></canvas>
                        </div>
                        <div class="chart-legend mt-3">
                            <div class="row">
                                <div class="col-6 col-md-3">
                                    <div class="legend-item">
                                        <span class="legend-color" style="background-color: #004AAD;"></span>
                                        <span class="legend-label">Super Admin</span>
                                        <span class="legend-count" id="superAdminCount">0</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="legend-item">
                                        <span class="legend-color" style="background-color: #1C6EC4;"></span>
                                        <span class="legend-label">Admin</span>
                                        <span class="legend-count" id="adminCount">0</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="legend-item">
                                        <span class="legend-color" style="background-color: #2DA84D;"></span>
                                        <span class="legend-label">Pustakawan</span>
                                        <span class="legend-count" id="pustakawaCount">0</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="legend-item">
                                        <span class="legend-color" style="background-color: #0B8F1C;"></span>
                                        <span class="legend-label">Staff</span>
                                        <span class="legend-count" id="staffCount">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="search-section">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Search</label>
                        <input type="text" class="form-control" id="searchInput" placeholder="Search users...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Role</label>
                        <select class="form-select" id="roleFilter">
                            <option value="">All Roles</option>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin">Admin</option>
                            <option value="Pustakawan">Pustakawan</option>
                            <option value="Staff">Staff</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="Aktif">Active</option>
                            <option value="Non-aktif">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success w-100" id="exportBtn">
                            <i class="bi bi-download me-2"></i>
                            Export Data
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= base_url('admin/users-edit') ?>" class="btn btn-primary w-100">
                            <i class="bi bi-plus-lg me-2"></i>
                            Manage Users
                        </a>
                    </div>
                </div>
            </div>

            <!-- User List Section -->
            <div class="user-list-section">
                <div class="section-header">
                    <h2 class="section-title">User (<span id="userCount">0</span>)</h2>
                    <p class="section-subtitle">Daftar seluruh pengguna sistem beserta informasinya</p>
                </div>
                
                <div class="table-container" id="tableContainer">
                    <table class="table users-table">
                        <thead>
                            <tr>
                                <th class="sortable" data-sort="nama_lengkap">
                                    User <i class="bi bi-arrow-down-up"></i>
                                </th>
                                <th class="sortable" data-sort="role">
                                    Role <i class="bi bi-arrow-down-up"></i>
                                </th>
                                <th class="sortable" data-sort="status">
                                    Status <i class="bi bi-arrow-down-up"></i>
                                </th>
                                <th class="sortable" data-sort="last_login">
                                    Last Login <i class="bi bi-arrow-down-up"></i>
                                </th>
                                <th class="sortable" data-sort="created_at">
                                    Created <i class="bi bi-arrow-down-up"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <!-- Data will be loaded dynamically -->
                        </tbody>
                    </table>
                    
                    <!-- Loading Spinner -->
                    <div id="loadingSpinner" class="text-center py-4" style="display: none;">
                        <div class="loading-spinner mx-auto"></div>
                        <p class="mt-2 text-muted">Memuat data...</p>
                    </div>
                    
                    <!-- No Data Message -->
                    <div id="noDataMessage" class="text-center py-4" style="display: none;">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="mt-2 text-muted">Tidak ada data pengguna</p>
                    </div>
                </div>
            </div>
        </div>

            </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- User Sync JS -->
    <script src="<?= base_url('assets/js/admin/user-sync.js') ?>"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url('assets/js/admin/user_management.js') ?>"></script>
    
    <style>
        /* Logout button styling - matching login button style */
        .logout-item {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1rem;
        }

        .logout-link {
            background: transparent !important;
            color: rgba(255, 255, 255, 0.8) !important;
            border-radius: 0.25rem;
            margin: 0.25rem;
            transition: all 0.3s ease;
            text-transform: none;
            letter-spacing: normal;
            font-weight: 400;
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }

        .logout-link:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            transform: none;
            box-shadow: none;
        }

        .logout-link:hover .nav-icon {
            transform: translateX(3px);
        }

        /* Ensure sidebar nav takes full height and logout stays at bottom */
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 120px);
            overflow: hidden;
        }

        .sidebar-nav .nav-item:not(.logout-item) {
            flex-shrink: 0;
        }

        /* Sortable table headers */
        .sortable {
            cursor: pointer;
            user-select: none;
            transition: background-color 0.2s ease;
            position: relative;
        }

        .sortable:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }

        .sortable i {
            margin-left: 0.5rem;
            opacity: 0.6;
            transition: opacity 0.2s ease;
        }

        .sortable:hover i {
            opacity: 1;
        }

        .sortable.asc i,
        .sortable.desc i {
            opacity: 1;
            color: #007bff;
        }

        /* Table row animations */
        .users-table tbody tr {
            transition: all 0.3s ease;
        }

        .users-table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }
    </style>

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