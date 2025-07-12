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
                <button type="button" class="btn btn-success" id="updateUserBtn" onclick="submitEditUser(); return false;">
                    <i data-feather="save" style="width: 16px; height: 16px;"></i>
                    Perbarui User
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
    
    <!-- Fix for Bootstrap modal issues -->
    <style>
        .modal-backdrop {
            z-index: 1030 !important;
        }
        .modal-content {
            z-index: 1050 !important;
        }
        .modal-footer {
            z-index: 1060 !important;
            position: relative;
        }
        .btn {
            position: relative;
            z-index: 1070 !important;
            pointer-events: auto !important;
        }
    </style>
    
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
            
            // Add direct click handler to update button
            $(document).on('click', '#updateUserBtn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Update button clicked via document handler');
                submitEditUser();
                return false;
            });
            
            // Add click handler to edit user links in dropdown
            $(document).on('click', '.dropdown-item', function(e) {
                console.log('Dropdown item clicked:', $(this).text());
            });
            
            // Fix for Bootstrap modal issues
            $(document).on('shown.bs.modal', '#editUserModal', function() {
                console.log('Modal shown event triggered');
                
                // Ensure the button is clickable immediately
                $('#updateUserBtn').off('click').on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Update button clicked after modal shown');
                    submitEditUser();
                    return false;
                });
                console.log('Click handler attached to updateUserBtn');
                
                // Add a direct click handler to the button element
                var updateBtn = document.getElementById('updateUserBtn');
                if (updateBtn) {
                    // Remove any existing event listeners
                    var newUpdateBtn = updateBtn.cloneNode(true);
                    updateBtn.parentNode.replaceChild(newUpdateBtn, updateBtn);
                    
                    // Add new event listener
                    newUpdateBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        console.log('Native click event on updateUserBtn');
                        submitEditUser();
                        return false;
                    });
                    console.log('Native click handler attached to cloned button');
                    
                    // Add inline onclick attribute
                    newUpdateBtn.setAttribute('onclick', 'submitEditUser(); return false;');
                } else {
                    console.log('updateUserBtn element not found');
                }
                
                // Re-initialize feather icons
                feather.replace();
            });
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
            $('#editUserForm').on('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Form submit event triggered');
                submitEditUser();
                return false;
            });
            
            // Add direct click handler to update button as fallback
            $('#updateUserBtn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Update button clicked directly');
                submitEditUser();
                return false;
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
            console.log('editUser called with userId:', userId);
            
            // Set currentEditUserId immediately
            currentEditUserId = userId;
            console.log('currentEditUserId set to:', currentEditUserId);
            
            // Reset form and clear errors
            $('#editUserForm')[0].reset();
            clearFormErrors();
            
            // Set the user ID in the hidden field
            $('#editUserId').val(userId);
            
            // Show modal with loading indicator
            $('#editUserModal').modal('show');
            
            // Add loading indicator
            const modalBody = $('#editUserModal .modal-body');
            const loadingIndicator = $('<div id="loadingIndicator" class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            modalBody.find('form').hide();
            modalBody.append(loadingIndicator);
            
            // Disable update button while loading
            $('#updateUserBtn').prop('disabled', true);
            
            $.ajax({
                url: '<?= base_url(\'user/get\') ?>/' + userId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Remove loading indicator
                    $('#loadingIndicator').remove();
                    modalBody.find('form').show();
                    
                    // Enable update button
                    $('#updateUserBtn').prop('disabled', false);
                    
                    if (response.status) {
                        const user = response.data;
                        console.log('User data received:', user);
                        
                        // Populate form fields
                        $('#editUserId').val(user.ID);
                        $('#editNamaLengkap').val(user.Fullname);
                        $('#editNamaPengguna').val(user.Username);
                        $('#editEmail').val(user.Email);
                        $('#editKataSandi').val(''); // Clear password field
                        $('#editRole').val(user.Role_id);
                        $('#editStatus').val(user.IsActive === '1' ? 'Aktif' : 'Non-Aktif');
                        
                        console.log('Form populated with user data');
                        
                        // Initialize feather icons
                        feather.replace();
                        
                        // Ensure the button is properly set up with click handler
                        $('#updateUserBtn').off('click').on('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            console.log('Update button clicked');
                            submitEditUser();
                            return false;
                        });
                    } else {
                        showToast(response.message || 'Gagal mengambil data pengguna', 'error');
                        $('#editUserModal').modal('hide');
                    }
                },
                error: function(xhr, status, error) {
                    // Remove loading indicator
                    $('#loadingIndicator').remove();
                    modalBody.find('form').show();
                    
                    // Enable update button
                    $('#updateUserBtn').prop('disabled', false);
                    
                    console.error('AJAX Error:', xhr.responseText);
                    showToast('Terjadi kesalahan saat mengambil data pengguna', 'error');
                    $('#editUserModal').modal('hide');
                }
            });
        }

        // Submit edit user form
        function submitEditUser() {
            console.log('submitEditUser called');
            
            // Get user ID from hidden field
            const userId = $('#editUserId').val();
            console.log('User ID from hidden field:', userId);
            
            if (!userId) {
                console.error('No user ID found for update operation');
                showToast('ID Pengguna tidak ditemukan', 'error');
                return false;
            }
            
            // Clear previous errors
            clearFormErrors();
            
            // Show loading indicator in button
            const submitBtn = $('#updateUserBtn');
            const originalBtnText = submitBtn.html();
            submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...');
            submitBtn.prop('disabled', true);
            
            // Prepare form data
            const formData = {
                id: userId,
                nama_lengkap: $('#editNamaLengkap').val(),
                nama_pengguna: $('#editNamaPengguna').val(),
                email: $('#editEmail').val(),
                kata_sandi: $('#editKataSandi').val(),
                role: $('#editRole').val(),
                status: $('#editStatus').val()
            };
            
            console.log('Submitting form data:', formData);
            
            $.ajax({
                url: '<?= base_url('user/update') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log('Update response:', response);
                    
                    if (response.status) {
                        showToast(response.message || 'Pengguna berhasil diperbarui', 'success');
                        $('#editUserModal').modal('hide');
                        
                        // Reload DataTable
                        if (typeof userDataTable !== 'undefined') {
                            userDataTable.ajax.reload();
                        } else {
                            // Fallback: reload page if DataTable not available
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                        
                        // Reset currentEditUserId
                        currentEditUserId = null;
                    } else {
                        if (response.errors) {
                            // Display validation errors
                            $.each(response.errors, function(field, message) {
                                const inputField = $('#edit' + field.charAt(0).toUpperCase() + field.slice(1));
                                inputField.addClass('is-invalid');
                                inputField.siblings('.invalid-feedback').text(message);
                            });
                        } else {
                            showToast(response.message || 'Gagal memperbarui pengguna', 'error');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    
                    // Try to parse response if possible
                    try {
                        const errorResponse = JSON.parse(xhr.responseText);
                        showToast(errorResponse.message || 'Terjadi kesalahan saat memperbarui pengguna', 'error');
                    } catch (e) {
                        showToast('Terjadi kesalahan saat memperbarui pengguna', 'error');
                    }
                },
                complete: function() {
                    submitBtn.html(originalBtnText).prop('disabled', false);
                }
            });
            
            return false;
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
            console.log('Form errors cleared');
        }
        
        // Display form errors
            function displayFormErrors(errors, formPrefix) {
                clearFormErrors();
                
                $.each(errors, function(field, message) {
                    // Handle different field naming conventions
                    let fieldId;
                    
                    // Try different field naming patterns
                    if (field.includes('_')) {
                        // Convert snake_case to CamelCase (nama_lengkap -> NamaLengkap)
                        const fieldParts = field.split('_');
                        const capitalizedField = fieldParts.map(part => 
                            part.charAt(0).toUpperCase() + part.slice(1)
                        ).join('');
                        fieldId = formPrefix + capitalizedField;
                    } else {
                        // Try direct field name with prefix
                        fieldId = formPrefix + field.charAt(0).toUpperCase() + field.slice(1);
                    }
                    
                    // Try to find the field
                    let inputField = $('#' + fieldId);
                    
                    // If not found, try alternative naming
                    if (!inputField.length) {
                        // Try common field mappings
                        const fieldMappings = {
                            'nama_pengguna': 'NamaPengguna',
                            'nama_lengkap': 'NamaLengkap',
                            'kata_sandi': 'KataSandi',
                            'username': 'NamaPengguna',
                            'fullname': 'NamaLengkap',
                            'password': 'KataSandi',
                            'email': 'Email',
                            'role': 'Role',
                            'status': 'Status'
                        };
                        
                        if (fieldMappings[field]) {
                            inputField = $('#' + formPrefix + fieldMappings[field]);
                        }
                    }
                    
                    if (inputField.length) {
                        // Mark field as invalid
                        inputField.addClass('is-invalid');
                        
                        // Create or update feedback div
                        let feedbackDiv = inputField.siblings('.invalid-feedback');
                        if (feedbackDiv.length === 0) {
                            inputField.after('<div class="invalid-feedback"></div>');
                            feedbackDiv = inputField.siblings('.invalid-feedback');
                        }
                        feedbackDiv.text(message);
                        
                        console.log('Error displayed for field:', fieldId);
                    } else {
                        console.warn('Field not found for error:', field, 'Tried ID:', fieldId);
                    }
                });
                
                console.log('Form errors displayed');
            }

        // Show toast notification
        function showToast(message, type = 'info') {
            // Map type to Bootstrap color class and icon
            let bgClass, icon;
            switch (type) {
                case 'success':
                    bgClass = 'bg-success';
                    icon = '<i data-feather="check-circle" class="me-2"></i>';
                    break;
                case 'error':
                    bgClass = 'bg-danger';
                    icon = '<i data-feather="alert-circle" class="me-2"></i>';
                    break;
                case 'warning':
                    bgClass = 'bg-warning';
                    icon = '<i data-feather="alert-triangle" class="me-2"></i>';
                    break;
                default:
                    bgClass = 'bg-info';
                    icon = '<i data-feather="info" class="me-2"></i>';
            }
            
            const toastContainer = $('#toastContainer');
            
            const toastId = 'toast-' + Date.now();
            
            // Create toast element
            const toast = $(`
                <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body d-flex align-items-center">
                            ${icon}
                            <span>${message}</span>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `);
            
            toastContainer.append(toast);
            
            // Initialize feather icons in the toast
            feather.replace({
                'width': 18,
                'height': 18
            });
            
            // Show toast with Bootstrap
            const bootstrapToast = new bootstrap.Toast(toast[0], {
                autohide: true,
                delay: 5000
            });
            
            bootstrapToast.show();
            
            // Remove toast from DOM after hiding
            toast.on('hidden.bs.toast', function() {
                $(this).remove();
            });
            
            console.log(`Toast shown: ${type} - ${message}`);
        }
    </script>
</body>
</html>