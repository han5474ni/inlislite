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
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    <style>
        :root {
            --sidebar-bg: linear-gradient(180deg, #34a853 0%, #0f9d58 100%);
            --primary-blue: #007BFF;
            --success-green: #28a745;
            --text-dark: #212529;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
            --shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: var(--sidebar-bg);
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            color: white;
            text-decoration: none;
        }

        .sidebar-logo i {
            font-size: 1.5rem;
            color: #ffd700;
        }

        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.2;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-title {
            display: none;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.25rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.875rem;
        }

        .sidebar.collapsed .nav-text {
            display: none;
        }

        .sidebar.collapsed .nav-item {
            margin: 0.25rem 0.5rem;
        }

        /* Toggle Button */
        .sidebar-toggle {
            position: absolute;
            top: 1.5rem;
            right: -15px;
            width: 30px;
            height: 30px;
            background: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow);
            color: var(--success-green);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .sidebar-toggle:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed + .main-content {
            margin-left: 80px;
        }

        /* Header */
        .page-header {
            background: white;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
        }

        .back-btn {
            color: var(--text-muted);
            text-decoration: none;
            margin-bottom: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            color: var(--primary-blue);
            transform: translateX(-2px);
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 0.75rem;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .btn-add-user {
            background: var(--primary-blue);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-add-user:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* User Avatar */
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        /* Badges */
        .role-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            border-radius: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-super-admin { background: #dc3545; color: white; }
        .role-admin { background: var(--primary-blue); color: white; }
        .role-pustakawan { background: var(--success-green); color: white; }
        .role-staff { background: #fd7e14; color: white; }

        .status-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            border-radius: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-aktif {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-green);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-non-aktif {
            background: rgba(108, 117, 125, 0.1);
            color: var(--text-muted);
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        /* Modal Styles */
        .modal-content {
            border: none;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 0.75rem 0.75rem 0 0;
            padding: 2rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .modal-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border: none;
            background: #f8f9fa;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* DataTables Custom Styles */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            border-radius: 0.375rem;
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar.collapsed + .main-content {
                margin-left: 0;
            }

            .page-title {
                font-size: 2rem;
            }
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1002;
            background: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem;
            box-shadow: var(--shadow);
            color: var(--success-green);
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            .sidebar-toggle {
                display: none;
            }
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
        }

        .toast {
            border: none;
            border-radius: 0.5rem;
            box-shadow: var(--shadow-lg);
        }
    </style>
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
                <i data-feather="star"></i>
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
                <a href="<?= base_url('users') ?>" class="nav-link active">
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
            <h1 class="page-title"><?= $page_title ?></h1>
            <p class="page-subtitle"><?= $page_subtitle ?></p>
        </div>

        <!-- Users Table -->
        <div class="table-container">
            <div class="table-header">
                <div>
                    <h5 class="table-title">Daftar Pengguna</h5>
                    <p class="text-muted mb-0">Kelola semua pengguna sistem INLISlite</p>
                </div>
                <button class="btn btn-primary btn-add-user" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i data-feather="plus" style="width: 16px; height: 16px;"></i>
                    Tambah User
                </button>
            </div>
            <div class="table-responsive p-3">
                <table class="table table-hover" id="usersTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pengguna</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Terakhir Masuk</th>
                            <th>Tanggal Dibuat</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Add User Modal -->
    <?= view('user/form') ?>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title">Edit Pengguna</h5>
                        <p class="modal-subtitle mb-0">Ubah informasi dan hak akses pengguna</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" name="user_id" id="editUserId">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" id="editNamaLengkap">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="nama_pengguna" id="editNamaPengguna" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="editEmail" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Kata Sandi Baru (kosongkan jika tidak diubah)</label>
                                <input type="password" class="form-control" name="kata_sandi" id="editKataSandi">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Role</label>
                                <select class="form-select" name="role" id="editRole" required>
                                    <option value="">Pilih Role</option>
                                    <option value="Super Admin">Super Admin</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Pustakawan">Pustakawan</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
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
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Global variables
        let usersTable;
        let currentEditUserId = null;

        // Initialize when DOM is loaded
        $(document).ready(function() {
            // Initialize Feather icons
            feather.replace();
            
            // Setup event listeners
            setupEventListeners();
            
            // Initialize DataTables
            initializeDataTable();
        });

        // Setup event listeners
        function setupEventListeners() {
            // Sidebar toggle
            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('collapsed');
                const icon = $(this).find('i');
                if ($('#sidebar').hasClass('collapsed')) {
                    icon.attr('data-feather', 'chevron-right');
                } else {
                    icon.attr('data-feather', 'chevron-left');
                }
                feather.replace();
            });

            // Mobile menu
            $('#mobileMenuBtn').on('click', function() {
                $('#sidebar').toggleClass('show');
            });

            // Add user form submission
            $('#addUserForm').on('submit', function(e) {
                e.preventDefault();
                submitAddUser();
            });

            // Edit user form submission
            $('#updateUserBtn').on('click', function() {
                submitEditUser();
            });

            // Modal events
            $('#addUserModal').on('hidden.bs.modal', function() {
                $('#addUserForm')[0].reset();
                clearFormErrors();
            });

            $('#editUserModal').on('hidden.bs.modal', function() {
                $('#editUserForm')[0].reset();
                currentEditUserId = null;
                clearFormErrors();
            });
        }

        // Initialize DataTables
        function initializeDataTable() {
            usersTable = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('users/json') ?>',
                    type: 'POST',
                    error: function(xhr, error, thrown) {
                        console.error('DataTables error:', error);
                        showToast('Error loading data: ' + error, 'error');
                    }
                },
                columns: [
                    { data: 'id', visible: false },
                    { 
                        data: 'user_info',
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar">${data.avatar_initials}</div>
                                    <div>
                                        <h6 class="mb-0">${data.nama_lengkap}</h6>
                                        <small class="text-muted">${data.email}</small>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    { 
                        data: 'role',
                        render: function(data, type, row) {
                            const roleClass = getRoleClass(data);
                            return `<span class="badge role-badge ${roleClass}">${data}</span>`;
                        }
                    },
                    { 
                        data: 'status',
                        render: function(data, type, row) {
                            const statusClass = getStatusClass(data);
                            return `<span class="badge status-badge ${statusClass}">${data}</span>`;
                        }
                    },
                    { data: 'last_login' },
                    { data: 'created_at' },
                    { 
                        data: 'actions',
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                        <i data-feather="more-vertical" style="width: 16px; height: 16px;"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="editUser(${data})">
                                                <i data-feather="edit" style="width: 16px; height: 16px; margin-right: 0.5rem;"></i>
                                                Edit User
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#" onclick="deleteUser(${data}, '${row.user_info.nama_lengkap}')">
                                                <i data-feather="trash-2" style="width: 16px; height: 16px; margin-right: 0.5rem;"></i>
                                                Hapus User
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            `;
                        }
                    }
                ],
                order: [[0, 'desc']],
                pageLength: 10,
                responsive: true,
                language: {
                    processing: "Memuat data...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Tidak ada data yang tersedia",
                    zeroRecords: "Tidak ada data yang cocok"
                },
                drawCallback: function() {
                    feather.replace();
                }
            });
        }

        // Submit add user form
        function submitAddUser() {
            const form = $('#addUserForm');
            const formData = new FormData(form[0]);
            const submitBtn = form.find('button[type="submit"]');
            
            // Show loading state
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...');
            clearFormErrors();

            $.ajax({
                url: '<?= base_url('users/store') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        showToast(response.message, 'success');
                        $('#addUserModal').modal('hide');
                        usersTable.ajax.reload();
                    } else {
                        if (response.errors) {
                            displayFormErrors(response.errors, 'add');
                        } else {
                            showToast(response.message, 'error');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    showToast('Terjadi kesalahan sistem', 'error');
                },
                complete: function() {
                    // Reset button state
                    submitBtn.prop('disabled', false).html('<i data-feather="plus" style="width: 16px; height: 16px;"></i> Tambahkan User');
                    feather.replace();
                }
            });
        }

        // Edit user
        function editUser(userId) {
            $.ajax({
                url: '<?= base_url('users/show') ?>/' + userId,
                type: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        const user = response.data;
                        currentEditUserId = userId;
                        
                        // Populate form
                        $('#editUserId').val(user.id);
                        $('#editNamaLengkap').val(user.nama_lengkap);
                        $('#editNamaPengguna').val(user.nama_pengguna);
                        $('#editEmail').val(user.email);
                        $('#editRole').val(user.role);
                        $('#editStatus').val(user.status);
                        
                        // Show modal
                        $('#editUserModal').modal('show');
                    } else {
                        showToast(response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    showToast('Terjadi kesalahan sistem', 'error');
                }
            });
        }

        // Submit edit user form
        function submitEditUser() {
            if (!currentEditUserId) return;
            
            const form = $('#editUserForm');
            const formData = new FormData(form[0]);
            const submitBtn = $('#updateUserBtn');
            
            // Show loading state
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...');
            clearFormErrors();

            $.ajax({
                url: '<?= base_url('users/update') ?>/' + currentEditUserId,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        showToast(response.message, 'success');
                        $('#editUserModal').modal('hide');
                        usersTable.ajax.reload();
                    } else {
                        if (response.errors) {
                            displayFormErrors(response.errors, 'edit');
                        } else {
                            showToast(response.message, 'error');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    showToast('Terjadi kesalahan sistem', 'error');
                },
                complete: function() {
                    // Reset button state
                    submitBtn.prop('disabled', false).html('<i data-feather="save" style="width: 16px; height: 16px;"></i> Update User');
                    feather.replace();
                }
            });
        }

        // Delete user
        function deleteUser(userId, userName) {
            if (!confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?`)) {
                return;
            }

            $.ajax({
                url: '<?= base_url('users/delete') ?>/' + userId,
                type: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        showToast(response.message, 'success');
                        usersTable.ajax.reload();
                    } else {
                        showToast(response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    showToast('Terjadi kesalahan sistem', 'error');
                }
            });
        }

        // Get role CSS class
        function getRoleClass(role) {
            const roleClasses = {
                'Super Admin': 'role-super-admin',
                'Admin': 'role-admin',
                'Pustakawan': 'role-pustakawan',
                'Staff': 'role-staff'
            };
            return roleClasses[role] || 'role-staff';
        }

        // Get status CSS class
        function getStatusClass(status) {
            const statusClasses = {
                'Aktif': 'status-aktif',
                'Non-Aktif': 'status-non-aktif'
            };
            return statusClasses[status] || 'status-non-aktif';
        }

        // Display form validation errors
        function displayFormErrors(errors, formType) {
            const prefix = formType === 'edit' ? 'edit' : '';
            
            Object.keys(errors).forEach(function(field) {
                const input = $(`[name="${field}"]`, `#${prefix}UserForm`);
                input.addClass('is-invalid');
                
                // Remove existing error message
                input.siblings('.invalid-feedback').remove();
                
                // Add error message
                input.after(`<div class="invalid-feedback">${errors[field]}</div>`);
            });
        }

        // Clear form errors
        function clearFormErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        }

        // Show toast notification
        function showToast(message, type = 'info') {
            const toastContainer = $('#toastContainer');
            
            const toastId = 'toast-' + Date.now();
            const bgClass = type === 'error' ? 'bg-danger' : (type === 'success' ? 'bg-success' : 'bg-info');
            
            const toast = $(`
                <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `);
            
            toastContainer.append(toast);
            
            const bootstrapToast = new bootstrap.Toast(toast[0]);
            bootstrapToast.show();
            
            // Remove toast from DOM after hiding
            toast.on('hidden.bs.toast', function() {
                $(this).remove();
            });
        }
    </script>
</body>
</html>