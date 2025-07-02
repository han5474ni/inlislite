<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User Baru - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
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
            --border-radius: 0.5rem;
            --transition: all 0.3s ease;
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
            transition: var(--transition);
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

        .sidebar-logo:hover {
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
            transition: var(--transition);
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
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(4px);
            text-decoration: none;
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
            transition: var(--transition);
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
            transition: var(--transition);
        }

        .sidebar.collapsed + .main-content {
            margin-left: 80px;
        }

        /* Page Header */
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
            transition: var(--transition);
        }

        .back-btn:hover {
            color: var(--primary-blue);
            transform: translateX(-2px);
            text-decoration: none;
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

        /* Form Container */
        .form-container {
            background: white;
            border-radius: 0.75rem;
            box-shadow: var(--shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f8f9fa;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Password Field */
        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 0.25rem;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary-blue);
            background: rgba(0, 123, 255, 0.1);
        }

        /* Password Strength Indicator */
        .password-strength {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: var(--border-radius);
            background: #f8f9fa;
            border: 1px solid var(--border-color);
        }

        .strength-meter {
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            margin-bottom: 0.75rem;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            transition: var(--transition);
            border-radius: 4px;
        }

        .strength-very-weak { background: #dc3545; }
        .strength-weak { background: #fd7e14; }
        .strength-fair { background: #ffc107; }
        .strength-good { background: #20c997; }
        .strength-strong { background: #28a745; }

        .strength-text {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .strength-requirements {
            font-size: 0.85rem;
        }

        .requirement {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .requirement.met {
            color: var(--success-green);
        }

        .requirement.not-met {
            color: #dc3545;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-blue);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-success {
            background: var(--success-green);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-success:hover {
            background: #1e7e34;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: var(--text-muted);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.75rem 2rem;
            font-weight: 600;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-green);
            border: 1px solid rgba(40, 167, 69, 0.2);
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
                padding: 1rem;
            }

            .sidebar.collapsed + .main-content {
                margin-left: 0;
            }

            .page-header {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .form-container {
                padding: 1.5rem;
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
            border-radius: var(--border-radius);
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
                <a href="<?= base_url('admin/users') ?>" class="nav-link active">
                    <i data-feather="users" class="nav-icon"></i>
                    <span class="nav-text">Manajemen User</span>
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
            <a href="<?= base_url('admin/users') ?>" class="back-btn">
                <i data-feather="arrow-left"></i>
                Kembali ke Manajemen User
            </a>
            <h1 class="page-title">Tambah User Baru</h1>
            <p class="page-subtitle">Buat akun pengguna baru dengan password yang aman</p>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form id="addUserForm" action="<?= base_url('admin/users/store-secure') ?>" method="post">
                <?= csrf_field() ?>
                
                <!-- Personal Information Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i data-feather="user" style="width: 20px; height: 20px; margin-right: 0.5rem;"></i>
                        Informasi Personal
                    </h3>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="namaLengkap" class="form-label">Nama Lengkap *</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="namaLengkap" 
                                   name="nama_lengkap" 
                                   value="<?= old('nama_lengkap') ?>"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="<?= old('email') ?>"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Account Information Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i data-feather="key" style="width: 20px; height: 20px; margin-right: 0.5rem;"></i>
                        Informasi Akun
                    </h3>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username *</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="username" 
                                   name="username" 
                                   value="<?= old('username') ?>"
                                   required>
                            <div class="form-text">Username harus unik dan minimal 3 karakter</div>
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role *</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="Super Admin" <?= old('role') == 'Super Admin' ? 'selected' : '' ?>>Super Admin</option>
                                <option value="Admin" <?= old('role') == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="Pustakawan" <?= old('role') == 'Pustakawan' ? 'selected' : '' ?>>Pustakawan</option>
                                <option value="Staff" <?= old('role') == 'Staff' ? 'selected' : '' ?>>Staff</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i data-feather="shield" style="width: 20px; height: 20px; margin-right: 0.5rem;"></i>
                        Keamanan Password
                    </h3>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password *</label>
                            <div class="password-wrapper">
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       required>
                                <button type="button" class="password-toggle" id="togglePassword">
                                    <i data-feather="eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="confirmPassword" class="form-label">Konfirmasi Password *</label>
                            <div class="password-wrapper">
                                <input type="password" 
                                       class="form-control" 
                                       id="confirmPassword" 
                                       name="confirm_password" 
                                       required>
                                <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                    <i data-feather="eye" id="toggleConfirmIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div class="password-strength" id="passwordStrength">
                        <div class="strength-meter">
                            <div class="strength-bar" id="strengthBar"></div>
                        </div>
                        <div class="strength-text" id="strengthText">Masukkan password untuk melihat kekuatan</div>
                        <div class="strength-requirements">
                            <div class="requirement not-met" id="req-length">
                                <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
                                <span>Minimal 8 karakter</span>
                            </div>
                            <div class="requirement not-met" id="req-lowercase">
                                <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
                                <span>Huruf kecil (a-z)</span>
                            </div>
                            <div class="requirement not-met" id="req-uppercase">
                                <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
                                <span>Huruf besar (A-Z)</span>
                            </div>
                            <div class="requirement not-met" id="req-number">
                                <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
                                <span>Angka (0-9)</span>
                            </div>
                            <div class="requirement not-met" id="req-special">
                                <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
                                <span>Karakter khusus (@#$%^&*()[]{})</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i data-feather="settings" style="width: 20px; height: 20px; margin-right: 0.5rem;"></i>
                        Status Akun
                    </h3>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Aktif" <?= old('status') == 'Aktif' ? 'selected' : '' ?> selected>Aktif</option>
                                <option value="Non-Aktif" <?= old('status') == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex gap-3 justify-content-end">
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
                        <i data-feather="x" style="width: 16px; height: 16px; margin-right: 0.5rem;"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        <i data-feather="user-plus" style="width: 16px; height: 16px; margin-right: 0.5rem;"></i>
                        Tambah User
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Feather icons
            feather.replace();
            
            // Setup event listeners
            setupEventListeners();
            
            // Initialize password strength checker
            initializePasswordStrength();
        });

        function setupEventListeners() {
            // Sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            
            if (sidebarToggle && sidebar) {
                const toggleIcon = sidebarToggle.querySelector('i');
                
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    
                    if (sidebar.classList.contains('collapsed')) {
                        toggleIcon.setAttribute('data-feather', 'chevron-right');
                    } else {
                        toggleIcon.setAttribute('data-feather', 'chevron-left');
                    }
                    
                    feather.replace();
                });
            }

            // Mobile menu
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            if (mobileMenuBtn && sidebar) {
                mobileMenuBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Password toggle functionality
            setupPasswordToggle('togglePassword', 'password', 'toggleIcon');
            setupPasswordToggle('toggleConfirmPassword', 'confirmPassword', 'toggleConfirmIcon');

            // Form submission
            const form = document.getElementById('addUserForm');
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                }
            });
        }

        function setupPasswordToggle(toggleId, inputId, iconId) {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (toggle && input && icon) {
                toggle.addEventListener('click', function() {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    
                    if (type === 'password') {
                        icon.setAttribute('data-feather', 'eye');
                    } else {
                        icon.setAttribute('data-feather', 'eye-off');
                    }
                    
                    feather.replace();
                });
            }
        }

        function initializePasswordStrength() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const strengthIndicator = document.getElementById('passwordStrength');
            
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                
                if (password.length > 0) {
                    strengthIndicator.style.display = 'block';
                    checkPasswordStrength(password);
                } else {
                    strengthIndicator.style.display = 'none';
                }
            });

            confirmPasswordInput.addEventListener('input', function() {
                checkPasswordMatch();
            });

            passwordInput.addEventListener('input', function() {
                checkPasswordMatch();
            });
        }

        function checkPasswordStrength(password) {
            let score = 0;
            const requirements = {
                length: password.length >= 8,
                lowercase: /[a-z]/.test(password),
                uppercase: /[A-Z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[@#$%^&*()[\]{}]/.test(password)
            };
            
            // Update requirement indicators
            Object.keys(requirements).forEach(req => {
                const element = document.getElementById(`req-${req}`);
                const icon = element.querySelector('i');
                
                if (requirements[req]) {
                    element.classList.remove('not-met');
                    element.classList.add('met');
                    icon.setAttribute('data-feather', 'check-circle');
                    score++;
                } else {
                    element.classList.remove('met');
                    element.classList.add('not-met');
                    icon.setAttribute('data-feather', 'x-circle');
                }
            });
            
            // Check for common weak passwords
            const weakPasswords = [
                'password', '123456', '123456789', 'qwerty', 'abc123',
                'password123', 'admin', 'administrator', '12345678',
                'welcome', 'login', 'root', 'toor', 'pass'
            ];
            
            const isWeak = weakPasswords.some(weak => 
                password.toLowerCase().includes(weak.toLowerCase())
            );
            
            if (isWeak) score = Math.max(0, score - 2);
            
            // Check for repeated characters
            if (/(.)\1{2,}/.test(password)) score = Math.max(0, score - 1);
            
            // Check for sequential characters
            if (/123|abc|qwe/i.test(password)) score = Math.max(0, score - 1);
            
            // Update strength bar and text
            updateStrengthDisplay(score, password.length);
            
            feather.replace();
        }

        function updateStrengthDisplay(score, length) {
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            const strengthLevels = [
                { text: 'Sangat Lemah', class: 'strength-very-weak', width: 20 },
                { text: 'Lemah', class: 'strength-weak', width: 40 },
                { text: 'Cukup', class: 'strength-fair', width: 60 },
                { text: 'Baik', class: 'strength-good', width: 80 },
                { text: 'Kuat', class: 'strength-strong', width: 100 }
            ];
            
            const level = Math.min(score, strengthLevels.length - 1);
            const strength = strengthLevels[level];
            
            strengthBar.className = `strength-bar ${strength.class}`;
            strengthBar.style.width = `${strength.width}%`;
            strengthText.textContent = `Password ${strength.text}`;
            
            if (length === 0) {
                strengthText.textContent = 'Masukkan password untuk melihat kekuatan';
                strengthBar.style.width = '0%';
                strengthBar.className = 'strength-bar';
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const confirmInput = document.getElementById('confirmPassword');
            
            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    confirmInput.classList.remove('is-invalid');
                    confirmInput.classList.add('is-valid');
                } else {
                    confirmInput.classList.remove('is-valid');
                    confirmInput.classList.add('is-invalid');
                }
            } else {
                confirmInput.classList.remove('is-valid', 'is-invalid');
            }
        }

        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Check password strength
            const requirements = {
                length: password.length >= 8,
                lowercase: /[a-z]/.test(password),
                uppercase: /[A-Z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[@#$%^&*()[\]{}]/.test(password)
            };
            
            const allRequirementsMet = Object.values(requirements).every(req => req);
            
            if (!allRequirementsMet) {
                alert('Password harus memenuhi semua kriteria keamanan yang ditampilkan.');
                return false;
            }
            
            // Check password match
            if (password !== confirmPassword) {
                alert('Password dan konfirmasi password tidak sama.');
                return false;
            }
            
            return true;
        }
    </script>
</body>
</html>