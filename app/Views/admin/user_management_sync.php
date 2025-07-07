<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'User Management - INLISlite v3.0' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
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
        <button class="sidebar-toggle" id="sidebarToggle">
            <i data-feather="chevron-left"></i>
        </button>
        
        <div class="sidebar-header">
            <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-logo">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="INLISLite Logo" style="width: 24px; height: 24px;">
                <div class="sidebar-title">
                    INLISlite v3.0<br>
                    <small style="font-size: 0.8rem; opacity: 0.8;">Dashboard</small>
                </div>
            </a>
        </div>
        
        <div class="sidebar-nav">
            <div class="nav-item">
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
                    <i data-feather="home" class="nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/users') ?>" class="nav-link active">
                    <i data-feather="users" class="nav-icon"></i>
                    <span class="nav-text">User Management</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('registration') ?>" class="nav-link">
                    <i data-feather="clipboard" class="nav-icon"></i>
                    <span class="nav-text">Registrasi</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/patches') ?>" class="nav-link">
                    <i data-feather="download" class="nav-icon"></i>
                    <span class="nav-text">Patch & Update</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/applications') ?>" class="nav-link">
                    <i data-feather="package" class="nav-icon"></i>
                    <span class="nav-text">Aplikasi Pendukung</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <a href="<?= base_url('admin/dashboard') ?>" class="back-btn">
                <i data-feather="arrow-left"></i>
                Kembali
            </a>
            <h1 class="page-title"><?= $page_title ?? 'User Management' ?></h1>
            <p class="page-subtitle"><?= $page_subtitle ?? 'Kelola pengguna sistem dan hak aksesnya' ?></p>
        </div>

        <!-- Alert Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i data-feather="check-circle" style="width: 16px; height: 16px; margin-right: 0.5rem;"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i data-feather="alert-circle" style="width: 16px; height: 16px; margin-right: 0.5rem;"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i data-feather="alert-circle" style="width: 16px; height: 16px; margin-right: 0.5rem;"></i>
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Pencarian Pengguna</label>
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari nama, username, atau email...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Role</label>
                    <select class="form-select" id="roleFilter">
                        <option value="">Semua</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Admin">Admin</option>
                        <option value="Pustakawan">Pustakawan</option>
                        <option value="Staff">Staff</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">Semua</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-primary btn-add-user" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i data-feather="plus" style="width: 16px; height: 16px;"></i>
                        Tambah User
                    </button>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="table-container">
            <div class="table-header">
                <div>
                    <h5 class="table-title">Daftar Pengguna (<span id="userCount">0</span>)</h5>
                    <p class="table-subtitle">Kelola semua pengguna sistem INLISlite</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table users-table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Terakhir Masuk</th>
                            <th>Tanggal Dibuat</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <!-- Users will be loaded here via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title">Tambahkan Pengguna Baru</h5>
                        <p class="modal-subtitle">Buat akun pengguna baru dan tetapkan hak akses</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" placeholder="Masukkan nama lengkap">
                                <div class="form-text">Opsional - akan menggunakan username jika kosong</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_pengguna" required minlength="3" maxlength="50" placeholder="Masukkan username">
                                <div class="form-text">Panjang 3-50 karakter, harus unik</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" required placeholder="Masukkan alamat email">
                                <div class="form-text">Format email yang valid dan unik</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Kata Sandi <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="kata_sandi" required minlength="6" placeholder="Masukkan kata sandi">
                                <div class="form-text">Minimal 6 karakter</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="Super Admin">Super Admin</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Pustakawan">Pustakawan</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Non-Aktif">Non-Aktif</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" form="addUserForm">
                        <i data-feather="plus" style="width: 16px; height: 16px;"></i>
                        Tambahkan User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title">Edit Pengguna</h5>
                        <p class="modal-subtitle">Ubah informasi dan hak akses pengguna</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <?= csrf_field() ?>
                        <input type="hidden" name="user_id" id="editUserId">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" id="editNamaLengkap">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_pengguna" id="editNamaPengguna" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="editEmail" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Kata Sandi Baru</label>
                                <input type="password" class="form-control" name="kata_sandi" id="editKataSandi">
                                <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select" name="role" id="editRole" required>
                                    <option value="">Pilih Role</option>
                                    <option value="Super Admin">Super Admin</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Pustakawan">Pustakawan</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" id="editStatus" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Non-Aktif">Non-Aktif</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="updateUserBtn">
                        <i data-feather="save" style="width: 16px; height: 16px;"></i>
                        Update User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url('assets/js/user_management.js') ?>"></script>
    
    <script>
        // Initialize Feather icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</body>
</html>