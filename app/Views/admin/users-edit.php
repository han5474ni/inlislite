<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User INLISLite - INLISLite v3.0</title>
    
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
    <link href="<?= base_url('assets/css/admin/users-edit.css') ?>" rel="stylesheet">
    
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <meta name="csrf-hash" content="<?= csrf_hash() ?>">
</head>
<body>
    <!-- Include Enhanced Sidebar -->
    <?= $this->include('admin/partials/sidebar') ?>
    <!-- Access Denied Modal -->
    <?php if (isset($access_denied) && $access_denied): ?>
    <div class="modal fade" id="accessDeniedModal" tabindex="-1" aria-labelledby="accessDeniedModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="accessDeniedModalLabel">
                        <i class="bi bi-shield-exclamation me-2"></i>Akses Ditolak
                    </h5>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="bi bi-lock-fill text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="fw-bold mb-3">Anda tidak memiliki akses ke halaman ini</h6>
                    <p class="text-muted mb-0"><?= $error_message ?? 'Hanya Super Admin yang dapat mengakses Manajemen Pengguna.' ?></p>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-danger" onclick="window.history.back()">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </button>
                    <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-house me-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Content -->
    <?php if (!isset($access_denied) || !$access_denied): ?>
    <!-- Header Section -->
    <header class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn-back me-3" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <div>
                        <h1 class="header-title mb-1">Manajemen User INLISLite</h1>
                        <p class="header-subtitle mb-0">Kelola pengguna sistem dan hak aksesnya</p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-light">
                            <i class="bi bi-eye me-2"></i>Dashboard
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
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="totalUsers">0</h3>
                            <p class="stat-label">Total Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="activeUsers">0</h3>
                            <p class="stat-label">Active Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="adminUsers">0</h3>
                            <p class="stat-label">Admin Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" id="recentUsers">0</h3>
                            <p class="stat-label">Recent Users</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Tabs -->
            <div class="management-tabs">
                <ul class="nav nav-tabs" id="managementTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users-panel" type="button" role="tab">
                            <i class="bi bi-people me-2"></i>Kelola Users
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="managementTabsContent">
                    <!-- Users Management Panel -->
                    <div class="tab-pane fade show active" id="users-panel" role="tabpanel">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="panel-title">Manajemen User System</h3>
                                <a href="<?= base_url('admin/users-edit/create') ?>" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah
                                </a>
                            </div>
                        </div>
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table class="table table-hover" id="usersTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Avatar</th>
                                            <th>Nama Lengkap</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Last Login</th>
                                            <th>History</th>
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
    <?php endif; ?>


    <!-- Edit User Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>Edit User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editUserForm">
                        <input type="hidden" id="editId" name="id">
                        
                        <!-- Basic Information Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-person-circle me-2"></i>Basic Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editNamaLengkap" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" id="editNamaLengkap" name="nama_lengkap" required placeholder="Enter full name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editNamaPengguna" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-at"></i></span>
                                            <input type="text" class="form-control" id="editNamaPengguna" name="nama_pengguna" required placeholder="Enter username">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editEmail" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control" id="editEmail" name="email" required placeholder="Enter email address">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editPassword" class="form-label fw-bold">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                                            <input type="password" class="form-control" id="editPassword" name="password" placeholder="Leave blank to keep current">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility('editPassword')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <small class="form-text text-muted">Leave blank to keep current password</small>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editStatus" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                            <select class="form-select" id="editStatus" name="status" required>
                                                <option value="">Select Status</option>
                                                <option value="Aktif">Active</option>
                                                <option value="Non-Aktif">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Access Features Section -->
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-gear me-2"></i>Access Features</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input feature-checkbox" type="checkbox" name="features[]" value="tentang" id="editFeatureTentang">
                                            <label class="form-check-label" for="editFeatureTentang">
                                                <i class="bi bi-info-circle me-2"></i>Tentang INLISLite
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input feature-checkbox" type="checkbox" name="features[]" value="panduan" id="editFeaturePanduan">
                                            <label class="form-check-label" for="editFeaturePanduan">
                                                <i class="bi bi-book me-2"></i>Panduan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input feature-checkbox" type="checkbox" name="features[]" value="fitur" id="editFeatureFitur">
                                            <label class="form-check-label" for="editFeatureFitur">
                                                <i class="bi bi-puzzle me-2"></i>Fitur dan Program
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input feature-checkbox" type="checkbox" name="features[]" value="aplikasi" id="editFeatureAplikasi">
                                            <label class="form-check-label" for="editFeatureAplikasi">
                                                <i class="bi bi-app-indicator me-2"></i>Aplikasi Pendukung
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input feature-checkbox" type="checkbox" name="features[]" value="bimbingan" id="editFeatureBimbingan">
                                            <label class="form-check-label" for="editFeatureBimbingan">
                                                <i class="bi bi-person-workspace me-2"></i>Bimbingan Teknis
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input feature-checkbox" type="checkbox" name="features[]" value="dukungan" id="editFeatureDukungan">
                                            <label class="form-check-label" for="editFeatureDukungan">
                                                <i class="bi bi-headset me-2"></i>Dukungan Teknis
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input feature-checkbox" type="checkbox" name="features[]" value="demo" id="editFeatureDemo">
                                            <label class="form-check-label" for="editFeatureDemo">
                                                <i class="bi bi-play-circle me-2"></i>Demo Program
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input feature-checkbox" type="checkbox" name="features[]" value="patch" id="editFeaturePatch">
                                            <label class="form-check-label" for="editFeaturePatch">
                                                <i class="bi bi-patch-check me-2"></i>Patch and Updater
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input feature-checkbox" type="checkbox" name="features[]" value="installer" id="editFeatureInstaller">
                                            <label class="form-check-label" for="editFeatureInstaller">
                                                <i class="bi bi-download me-2"></i>Installer
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Select All / Deselect All -->
                                <div class="d-flex gap-2 mt-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="selectAllFeatures()">
                                        <i class="bi bi-check-all me-1"></i>Select All
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="deselectAllFeatures()">
                                        <i class="bi bi-x-square me-1"></i>Deselect All
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary" onclick="updateUser()">
                        <i class="bi bi-check-circle me-2"></i>Update User
                    </button>
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
    <!-- User Sync JS -->
    <script src="<?= base_url('assets/js/admin/user-sync.js') ?>"></script>
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/admin/users-edit.js') ?>"></script>

    <script>
    // Enhanced CSRF token management
    window.csrfToken = "<?= csrf_token() ?>";
    window.csrfHash = "<?= csrf_hash() ?>";
    window.baseUrl = "<?= base_url() ?>";
    
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

    // Show access denied modal if access is denied
    <?php if (isset($access_denied) && $access_denied): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const accessDeniedModal = new bootstrap.Modal(document.getElementById('accessDeniedModal'));
        accessDeniedModal.show();
    });
    <?php endif; ?>
    </script>
</body>
</html>