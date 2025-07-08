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
    
    <style>
        /* Sortable Table Headers - Matching Registration Table */
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
            transition: all 0.2s ease;
            font-size: 0.8rem;
        }

        .sortable:hover i {
            opacity: 1;
        }

        .sortable.asc i,
        .sortable.desc i {
            opacity: 1;
            color: #007bff;
            font-weight: bold;
        }

        .sortable.asc i {
            transform: rotate(0deg);
        }

        .sortable.desc i {
            transform: rotate(180deg);
        }
        
        /* Loading state */
        .table-loading {
            position: relative;
        }
        
        .table-loading::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
        
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #0d6efd;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Table row animations */
        .users-table tbody tr {
            transition: all 0.3s ease;
        }

        .users-table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        /* Sort animation */
        .sortable i {
            transition: all 0.3s ease;
        }

        /* Button loading state */
        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i data-feather="menu"></i>
    </button>

    <!-- Include Shared Sidebar -->
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
                                <th width="60">Action</th>
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

        <!-- Modern Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content modern-modal">
                    <div class="modal-header modern-modal-header">
                        <div class="modal-title-section">
                            <h4 class="modal-title" id="addUserModalLabel">Tambahkan pengguna baru</h4>
                            <p class="modal-subtitle">Buat akun pengguna baru dan tetapkan izin akses.</p>
                        </div>
                        <button type="button" class="btn-close modern-btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="modal-body modern-modal-body">
                        <form id="addUserForm" class="modern-form">
                            <?= csrf_field() ?>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control modern-input" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nama Pengguna</label>
                                    <input type="text" class="form-control modern-input" name="nama_pengguna" placeholder="Masukkan nama pengguna" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control modern-input" name="email" placeholder="Masukkan alamat email" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Kata Sandi</label>
                                    <input type="password" class="form-control modern-input" name="kata_sandi" placeholder="Masukkan kata sandi" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Role</label>
                                    <select class="form-select modern-select" name="role" required>
                                        <option value="">Pilih Role</option>
                                        <option value="Staff">Staff</option>
                                        <option value="Pustakawan">Pustakawan</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Super Admin">Super Admin</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select class="form-select modern-select" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Non-aktif">Non-aktif</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer modern-modal-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-add-user-submit" form="addUserForm">
                            <i class="bi bi-plus-lg me-2"></i>
                            Tambahkan User
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content modern-modal">
                    <div class="modal-header modern-modal-header">
                        <div class="modal-title-section">
                            <h4 class="modal-title" id="editUserModalLabel">Edit pengguna</h4>
                            <p class="modal-subtitle">Perbarui informasi pengguna dan izin akses.</p>
                        </div>
                        <button type="button" class="btn-close modern-btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="modal-body modern-modal-body">
                        <form id="editUserForm" class="modern-form">
                            <?= csrf_field() ?>
                            <input type="hidden" id="editUserId" name="id">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control modern-input" id="editNamaLengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nama Pengguna</label>
                                    <input type="text" class="form-control modern-input" id="editNamaPengguna" name="nama_pengguna" placeholder="Masukkan nama pengguna" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control modern-input" id="editEmail" name="email" placeholder="Masukkan alamat email" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Kata Sandi Baru</label>
                                    <input type="password" class="form-control modern-input" id="editPassword" name="kata_sandi" placeholder="Kosongkan jika tidak ingin mengubah">
                                    <small class="form-text text-muted mt-1">Kosongkan jika tidak ingin mengubah kata sandi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Role</label>
                                    <select class="form-select modern-select" id="editRole" name="role" required>
                                        <option value="">Pilih Role</option>
                                        <option value="Staff">Staff</option>
                                        <option value="Pustakawan">Pustakawan</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Super Admin">Super Admin</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select class="form-select modern-select" id="editStatus" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Non-aktif">Non-aktif</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer modern-modal-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-edit-user-submit" form="editUserForm">
                            <i class="bi bi-check-lg me-2"></i>
                            Perbarui User
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
    <script src="<?= base_url('assets/js/admin/user_management.js') ?>"></script>
    
    <script>
        // Global variables
        let currentSort = { field: 'nama_lengkap', direction: 'asc' };
        let allUsers = [];
        let filteredUsers = [];

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            
            // Load users data
            loadUsers();
            
            // Setup event listeners
            setupEventListeners();
        });

        // Setup event listeners
        function setupEventListeners() {
            // Search input
            document.getElementById('searchInput').addEventListener('input', filterUsers);
            
            // Filter dropdowns
            document.getElementById('roleFilter').addEventListener('change', filterUsers);
            document.getElementById('statusFilter').addEventListener('change', filterUsers);
            
            // Sortable headers
            document.querySelectorAll('.sortable').forEach(header => {
                header.addEventListener('click', function() {
                    const field = this.dataset.sort;
                    sortUsers(field);
                });
            });
            
            // Form submissions
            document.getElementById('addUserForm').addEventListener('submit', handleAddUser);
            document.getElementById('editUserForm').addEventListener('submit', handleEditUser);
        }

        // Load users from database
        async function loadUsers() {
            showLoading(true);
            
            try {
                const response = await fetch('<?= base_url('admin/users/reloadUsers') ?>');
                const result = await response.json();
                
                if (result.success) {
                    allUsers = result.data || [];
                    filteredUsers = [...allUsers];
                    renderUsers();
                    updateUserCount();
                    
                    // Apply initial sort
                    sortUsers(currentSort.field);
                } else {
                    console.error('Error loading users:', result.message);
                    showNoData();
                }
            } catch (error) {
                console.error('Error loading users:', error);
                showNoData();
            } finally {
                showLoading(false);
            }
        }

        // Show/hide loading spinner
        function showLoading(show) {
            const spinner = document.getElementById('loadingSpinner');
            const table = document.querySelector('.users-table');
            const noData = document.getElementById('noDataMessage');
            
            if (show) {
                spinner.style.display = 'block';
                table.style.display = 'none';
                noData.style.display = 'none';
            } else {
                spinner.style.display = 'none';
                table.style.display = 'table';
            }
        }

        // Show no data message
        function showNoData() {
            const spinner = document.getElementById('loadingSpinner');
            const table = document.querySelector('.users-table');
            const noData = document.getElementById('noDataMessage');
            
            spinner.style.display = 'none';
            table.style.display = 'none';
            noData.style.display = 'block';
        }

        // Sort users with functional arrows
        function sortUsers(field) {
            // Update sort direction
            if (currentSort.field === field) {
                currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort.field = field;
                currentSort.direction = 'asc';
            }
            
            // Reset all headers to default state
            document.querySelectorAll('.sortable').forEach(header => {
                header.classList.remove('asc', 'desc');
                const icon = header.querySelector('i');
                if (icon) {
                    icon.className = 'bi bi-arrow-down-up';
                    icon.style.transform = 'none';
                }
            });
            
            // Update current header
            const currentHeader = document.querySelector(`[data-sort="${field}"]`);
            if (currentHeader) {
                currentHeader.classList.add(currentSort.direction);
                const currentIcon = currentHeader.querySelector('i');
                if (currentIcon) {
                    if (currentSort.direction === 'asc') {
                        currentIcon.className = 'bi bi-arrow-up';
                    } else {
                        currentIcon.className = 'bi bi-arrow-down';
                    }
                }
            }
            
            // Sort the data
            filteredUsers.sort((a, b) => {
                let aVal = a[field] || '';
                let bVal = b[field] || '';
                
                // Handle date fields
                if (field === 'created_at' || field === 'last_login') {
                    aVal = new Date(aVal || 0);
                    bVal = new Date(bVal || 0);
                } else if (typeof aVal === 'string' && typeof bVal === 'string') {
                    // Handle string comparison for text fields
                    aVal = aVal.toLowerCase();
                    bVal = bVal.toLowerCase();
                }
                
                let comparison = 0;
                if (aVal > bVal) {
                    comparison = 1;
                } else if (aVal < bVal) {
                    comparison = -1;
                }
                
                return currentSort.direction === 'asc' ? comparison : -comparison;
            });
            
            renderUsers();
        }

        // Filter users
        function filterUsers() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const roleFilter = document.getElementById('roleFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            
            filteredUsers = allUsers.filter(user => {
                const matchesSearch = !searchTerm || 
                    (user.nama_lengkap && user.nama_lengkap.toLowerCase().includes(searchTerm)) ||
                    (user.nama_pengguna && user.nama_pengguna.toLowerCase().includes(searchTerm)) ||
                    (user.email && user.email.toLowerCase().includes(searchTerm));
                
                const matchesRole = !roleFilter || user.role === roleFilter;
                const matchesStatus = !statusFilter || user.status === statusFilter;
                
                return matchesSearch && matchesRole && matchesStatus;
            });
            
            // Re-apply current sort after filtering
            if (currentSort.field) {
                sortUsers(currentSort.field);
            } else {
                renderUsers();
                updateUserCount();
            }
        }

        // Render users table
        function renderUsers() {
            const tbody = document.getElementById('usersTableBody');
            
            if (filteredUsers.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="bi bi-search" style="font-size: 2rem; color: #ccc;"></i>
                            <p class="mt-2 text-muted">Tidak ada data yang sesuai dengan filter</p>
                        </td>
                    </tr>
                `;
                return;
            }
            
            tbody.innerHTML = filteredUsers.map(user => `
                <tr data-role="${user.role || ''}" data-status="${user.status || ''}">
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">${getInitials(user.nama_lengkap || user.nama_pengguna || 'U')}</div>
                            <div class="user-details">
                                <h6>${escapeHtml(user.nama_lengkap || user.nama_pengguna || 'N/A')}</h6>
                                <small>${escapeHtml(user.email || 'N/A')}</small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-role badge-${getRoleBadgeClass(user.role)}">${escapeHtml(user.role || 'N/A')}</span></td>
                    <td><span class="badge badge-status badge-${getStatusBadgeClass(user.status)}">${escapeHtml(user.status || 'N/A')}</span></td>
                    <td>
                        <div>${formatDate(user.last_login)}</div>
                        <small class="text-muted">${formatTime(user.last_login)}</small>
                    </td>
                    <td>${formatDate(user.created_at)}</td>
                    <td>
                        <div class="dropdown">
                            <button class="action-btn" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#" onclick="editUser(${user.id})"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                <li><a class="dropdown-item" href="#" onclick="viewUser(${user.id})"><i class="bi bi-eye me-2"></i>Lihat</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteUser(${user.id})"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Update user count
        function updateUserCount() {
            document.getElementById('userCount').textContent = filteredUsers.length;
        }

        // Utility functions
        function getInitials(name) {
            if (!name) return 'U';
            return name.split(' ').map(word => word[0]).join('').toUpperCase().substring(0, 2);
        }

        function getRoleBadgeClass(role) {
            const classes = {
                'Super Admin': 'super-admin',
                'Admin': 'admin',
                'Pustakawan': 'pustakawan',
                'Staff': 'staff'
            };
            return classes[role] || 'secondary';
        }

        function getStatusBadgeClass(status) {
            return status === 'Aktif' ? 'aktif' : 'nonaktif';
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        }

        function formatTime(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // User actions with database synchronization
        async function editUser(id) {
            try {
                console.log('Fetching user data for ID:', id);
                const response = await fetch(`<?= base_url('admin/users/getUser/') ?>${id}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const result = await response.json();
                
                console.log('User data response:', result);
                
                if (result.success) {
                    const user = result.data;
                    
                    // Populate edit form
                    document.getElementById('editUserId').value = user.id;
                    document.getElementById('editNamaLengkap').value = user.nama_lengkap || '';
                    document.getElementById('editNamaPengguna').value = user.nama_pengguna || user.username || '';
                    document.getElementById('editEmail').value = user.email || '';
                    document.getElementById('editRole').value = user.role || '';
                    document.getElementById('editStatus').value = user.status || '';
                    document.getElementById('editPassword').value = '';
                    
                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
                    modal.show();
                    
                    console.log('Edit modal opened with user data');
                } else {
                    alert('❌ Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error fetching user:', error);
                alert('❌ Terjadi kesalahan saat mengambil data pengguna: ' + error.message);
            }
        }

        async function viewUser(id) {
            // Implementation for view user
            console.log('View user:', id);
        }

        async function deleteUser(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                try {
                    const response = await fetch(`<?= base_url('admin/users/deleteUserAjax/') ?>${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        alert('✅ ' + result.message);
                        loadUsers(); // Reload data
                    } else {
                        alert('❌ Error: ' + result.message);
                    }
                } catch (error) {
                    console.error('Error deleting user:', error);
                    alert('❌ Terjadi kesalahan saat menghapus pengguna: ' + error.message);
                }
            }
        }

        async function handleAddUser(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            
            // Show loading state
            const submitBtn = document.querySelector('.btn-add-user-submit');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menambahkan...';
            submitBtn.disabled = true;
            
            try {
                console.log('Adding new user with data:', Object.fromEntries(formData));
                
                const response = await fetch('<?= base_url('admin/users/addUserAjax') ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const result = await response.json();
                console.log('Add user response:', result);
                
                if (result.success) {
                    alert('✅ ' + result.message);
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
                    modal.hide();
                    
                    // Reset form
                    e.target.reset();
                    
                    // Reload data
                    await loadUsers();
                    
                    console.log('User added successfully and data reloaded');
                } else {
                    if (result.errors) {
                        let errorMessage = 'Kesalahan validasi:\n';
                        for (const field in result.errors) {
                            errorMessage += `• ${result.errors[field]}\n`;
                        }
                        alert('❌ ' + errorMessage);
                    } else {
                        alert('❌ Error: ' + result.message);
                    }
                }
            } catch (error) {
                console.error('Error adding user:', error);
                alert('❌ Terjadi kesalahan saat menambah pengguna: ' + error.message);
            } finally {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        async function handleEditUser(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const userId = document.getElementById('editUserId').value;
            
            // Show loading state
            const submitBtn = document.querySelector('.btn-edit-user-submit');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memperbarui...';
            submitBtn.disabled = true;
            
            try {
                console.log('Updating user ID:', userId);
                console.log('Form data:', Object.fromEntries(formData));
                
                const response = await fetch(`<?= base_url('admin/users/editUserAjax/') ?>${userId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const result = await response.json();
                console.log('Update response:', result);
                
                if (result.success) {
                    // Show success message
                    alert('✅ ' + result.message);
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
                    modal.hide();
                    
                    // Reload data to reflect changes
                    await loadUsers();
                    
                    console.log('User updated successfully and data reloaded');
                } else {
                    if (result.errors) {
                        let errorMessage = 'Kesalahan validasi:\n';
                        for (const field in result.errors) {
                            errorMessage += `• ${result.errors[field]}\n`;
                        }
                        alert('❌ ' + errorMessage);
                    } else {
                        alert('❌ Error: ' + result.message);
                    }
                }
            } catch (error) {
                console.error('Error updating user:', error);
                alert('❌ Terjadi kesalahan saat memperbarui pengguna: ' + error.message);
            } finally {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        // Mark that user has visited an admin page
        sessionStorage.setItem('admin_page_visited', 'true');
    </script>
</body>
</html>