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

    <?php include APPPATH . 'Views/admin/partials/sidebar.php'; ?>

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

            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Search Section -->
            <div class="search-section">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pencarian</label>
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari pengguna...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select class="form-select" id="roleFilter">
                            <option value="">Semua Role</option>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin">Admin</option>
                            <option value="Pustakawan">Pustakawan</option>
                            <option value="Staff">Staff</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Non-aktif">Non-aktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-add-user w-100" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bi bi-plus-lg me-2"></i>
                            Tambah User
                        </button>
                    </div>
                </div>
            </div>

            <!-- User List Section -->
            <div class="user-list-section">
                <div class="section-header">
                    <h2 class="section-title">User (<span id="userCount">4</span>)</h2>
                    <p class="section-subtitle">Daftar seluruh pengguna sistem beserta informasinya</p>
                </div>
                
                <div class="table-container">
                    <table class="table users-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Created</th>
                                <th width="60">Action</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <!-- Sample Data -->
                            <tr data-role="Super Admin" data-status="Aktif">
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">JD</div>
                                        <div class="user-details">
                                            <h6>John Doe</h6>
                                            <small>john.doe@example.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-role badge-super-admin">Super Admin</span></td>
                                <td><span class="badge badge-status badge-aktif">Aktif</span></td>
                                <td>
                                    <div>2 Jan 2024</div>
                                    <small class="text-muted">14:30</small>
                                </td>
                                <td>15 Des 2023</td>
                                <td>
                                    <button class="action-btn" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>Lihat</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr data-role="Pustakawan" data-status="Aktif">
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">AS</div>
                                        <div class="user-details">
                                            <h6>Alice Smith</h6>
                                            <small>alice.smith@example.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-role badge-pustakawan">Pustakawan</span></td>
                                <td><span class="badge badge-status badge-aktif">Aktif</span></td>
                                <td>
                                    <div>1 Jan 2024</div>
                                    <small class="text-muted">09:15</small>
                                </td>
                                <td>10 Des 2023</td>
                                <td>
                                    <button class="action-btn" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>Lihat</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr data-role="Staff" data-status="Non-aktif">
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">BJ</div>
                                        <div class="user-details">
                                            <h6>Bob Johnson</h6>
                                            <small>bob.johnson@example.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-role badge-staff">Staff</span></td>
                                <td><span class="badge badge-status badge-nonaktif">Non-aktif</span></td>
                                <td>
                                    <div>28 Des 2023</div>
                                    <small class="text-muted">16:45</small>
                                </td>
                                <td>5 Des 2023</td>
                                <td>
                                    <button class="action-btn" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>Lihat</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr data-role="Admin" data-status="Aktif">
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">CD</div>
                                        <div class="user-details">
                                            <h6>Carol Davis</h6>
                                            <small>carol.davis@example.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-role badge-admin">Admin</span></td>
                                <td><span class="badge badge-status badge-aktif">Aktif</span></td>
                                <td>
                                    <div>31 Des 2023</div>
                                    <small class="text-muted">11:20</small>
                                </td>
                                <td>1 Des 2023</td>
                                <td>
                                    <button class="action-btn" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>Lihat</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Tambah User Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addUserForm">
                            <?= csrf_field() ?>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Masukkan alamat email" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Role</label>
                                    <select class="form-select" name="role" required>
                                        <option value="">Pilih Role</option>
                                        <option value="Super Admin">Super Admin</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Pustakawan">Pustakawan</option>
                                        <option value="Staff">Staff</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Status</label>
                                    <select class="form-select" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Non-aktif">Non-aktif</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-add-user" form="addUserForm">
                            <i class="bi bi-plus-lg me-2"></i>
                            Tambah User
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
    <script src="<?= base_url('assets/js/user_management.js') ?>"></script>
    
    <script>
        // Initialize Feather icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            
            // Ensure User Management menu remains active
            const userManagementLink = document.querySelector('a[data-page="admin/users"]');
            if (userManagementLink) {
                // Remove active class from all other links
                document.querySelectorAll('.nav-link').forEach(link => {
                    if (link !== userManagementLink) {
                        link.classList.remove('active');
                    }
                });
                
                // Ensure user management link is active
                userManagementLink.classList.add('active');
                
                // Store in session storage for consistency
                sessionStorage.setItem('activeMenu', 'admin/users');
            }
            
            // Debug: Log current URL and active menu detection
            console.log('Current URL:', window.location.pathname);
            console.log('User Management Link:', userManagementLink);
            console.log('Active menu stored:', sessionStorage.getItem('activeMenu'));
        });
    </script>
</body>
</html>