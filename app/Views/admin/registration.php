<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Inlislite Registration - INLISlite v3.0' ?></title>
    
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
    <link href="<?= base_url('assets/css/admin/registration.css') ?>" rel="stylesheet">
    <!-- Custom Header CSS -->
</head>
<body>
    <!-- Include Enhanced Sidebar -->
    <?= $this->include('admin/partials/sidebar') ?>

    <!-- Main Content -->
    <main class="enhanced-main-content">
        <div class="dashboard-container">
            <div class="header-card">
                <div class="content-header">
                    <h1 class="main-title">Registration Management</h1>
                    <p class="main-subtitle">Manage and monitor library registration data in the system</p>
                </div>
            </div>
            
            
        <div class="page-container">

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

            <!-- Statistics Section -->
            <div class="statistics-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon bg-primary">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number"><?= isset($stats['total']) ? number_format($stats['total']) : '156' ?></h3>
                                <p class="stat-label">Total Registrations</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon bg-success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number"><?= isset($stats['active']) ? number_format($stats['active']) : '142' ?></h3>
                                <p class="stat-label">Active Libraries</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon bg-secondary">
                                <i class="bi bi-x-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number"><?= isset($stats['inactive']) ? number_format($stats['inactive']) : '14' ?></h3>
                                <p class="stat-label">Inactive Libraries</p>
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
                        <input type="text" class="form-control" id="searchInput" placeholder="Search registration...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">All</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Type</label>
                        <select class="form-select" id="typeFilter">
                            <option value="">All Types</option>
                            <option value="Public">Public</option>
                            <option value="Academic">Academic</option>
                            <option value="School">School</option>
                            <option value="Special">Special</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success w-100" id="downloadBtn">
                            <i class="bi bi-download me-2"></i>
                            Download Data
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= base_url('admin/registration/add') ?>" class="btn btn-primary w-100" id="addRegistrationBtn">
                            <i class="bi bi-plus-lg me-2"></i>
                            Add Registration
                        </a>
                    </div>
                </div>
            </div>

            <!-- Registration Data Table -->
            <div class="registration-list-section">
                <div class="section-header">
                    <h2 class="section-title">Registration Data (<span id="registrationCount"><?= count($registrations ?? []) ?></span>)</h2>
                    <p class="section-subtitle">Complete list of library registrations with detailed information</p>
                </div>
                
                <div class="table-container">
                    <table class="table registration-table">
                        <thead>
                            <tr>
                                <th class="sortable" data-sort="library_name">
                                    Library Name <i class="bi bi-arrow-down-up"></i>
                                </th>
                                <th class="sortable" data-sort="library_type">
                                    Library Type <i class="bi bi-arrow-down-up"></i>
                                </th>
                                <th class="sortable" data-sort="status">
                                    Status <i class="bi bi-arrow-down-up"></i>
                                </th>
                                <th class="sortable" data-sort="registration_date">
                                    Registration Date <i class="bi bi-arrow-down-up"></i>
                                </th>
                                <th class="sortable" data-sort="last_update">
                                    Last Update <i class="bi bi-arrow-down-up"></i>
                                </th>
                                <th width="60">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="registrationTableBody">
                            <?php if (!empty($registrations)): ?>
                                <?php foreach ($registrations as $registration): ?>
                                    <tr data-library-type="<?= esc($registration['library_type']) ?>" data-status="<?= esc($registration['status']) ?>">
                                        <td>
                                            <div class="library-info">
                                                <h6><?= esc($registration['library_name']) ?></h6>
                                                <small><?= esc($registration['province']) ?></small>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-type badge-<?= strtolower($registration['library_type']) ?>"><?= esc($registration['library_type']) ?></span></td>
                                        <td><span class="badge badge-status badge-<?= strtolower($registration['status']) ?>"><?= esc($registration['status']) ?></span></td>
                                        <td><?= date('d M Y', strtotime($registration['created_at'])) ?></td>
                                        <td><?= date('d M Y', strtotime($registration['updated_at'])) ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="action-btn" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item view-registration" href="<?= base_url('admin/registration/view/' . $registration['id']) ?>"><i class="bi bi-eye me-2"></i>View</a></li>
                                                    <li><a class="dropdown-item edit-registration" href="<?= base_url('admin/registration/edit/' . $registration['id']) ?>"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger delete-registration" href="#" data-id="<?= $registration['id'] ?>"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            <p>No registration data found</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script src="<?= base_url('assets/js/admin/registration.js') ?>"></script>
    
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
        .registration-table tbody tr {
            transition: all 0.3s ease;
        }

        .registration-table tbody tr:hover {
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