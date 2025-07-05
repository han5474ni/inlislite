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
                    <i data-feather="star"></i>
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
                <a href="<?= base_url('admin/registration') ?>" class="nav-link active">
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
                            <i class="bi bi-clipboard"></i>
                        </div>
                        <div>
                            <h1 class="page-title">Inlislite Registration</h1>
                            <p class="page-subtitle">Manage and monitor library registration data in the system</p>
                        </div>
                    </div>
                </div>
            </div>

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
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addRegistrationModal">
                            <i class="bi bi-plus-lg me-2"></i>
                            Add Registration
                        </button>
                    </div>
                </div>
            </div>

            <!-- Registration Data Table -->
            <div class="registration-list-section">
                <div class="section-header">
                    <h2 class="section-title">Registration Data (<span id="registrationCount">8</span>)</h2>
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
                            <!-- Sample Data -->
                            <tr data-library-type="Public" data-status="Active">
                                <td>
                                    <div class="library-info">
                                        <h6>Jakarta Public Library</h6>
                                        <small>DKI Jakarta</small>
                                    </div>
                                </td>
                                <td><span class="badge badge-type badge-public">Public</span></td>
                                <td><span class="badge badge-status badge-active">Active</span></td>
                                <td>15 Jan 2024</td>
                                <td>2 Jan 2024</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="action-btn" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <!-- Additional sample data rows would go here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Registration Modal -->
        <div class="modal fade" id="addRegistrationModal" tabindex="-1" aria-labelledby="addRegistrationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRegistrationModalLabel">Add New Registration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addRegistrationForm">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Library Name</label>
                                    <input type="text" class="form-control" name="library_name" placeholder="Enter library name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Library Type</label>
                                    <select class="form-select" name="library_type" required>
                                        <option value="">Select Type</option>
                                        <option value="Public">Public</option>
                                        <option value="Academic">Academic</option>
                                        <option value="School">School</option>
                                        <option value="Special">Special</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Status</label>
                                    <select class="form-select" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Location</label>
                                    <input type="text" class="form-control" name="location" placeholder="Enter location" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Contact Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter contact email" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="addRegistrationForm">
                            <i class="bi bi-plus-lg me-2"></i>
                            Add Registration
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
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