<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'User Profile - INLISlite v3.0' ?></title>
    
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
    <link href="<?= base_url('assets/css/admin/profile.css') ?>" rel="stylesheet">
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
                <a href="<?= base_url('admin/users') ?>" class="nav-link">
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
                <a href="<?= base_url('admin/profile') ?>" class="nav-link active">
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
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div>
                            <h1 class="page-title">User Profile</h1>
                            <p class="page-subtitle">Manage your account information and settings</p>
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

            <!-- Profile Information Section -->
            <div class="profile-info-section">
                <div class="section-header">
                    <h2 class="section-title">Profile Information</h2>
                    <p class="section-subtitle">View and manage your account details</p>
                </div>
                
                <div class="profile-info-container">
                    <div class="row g-4">
                        <!-- Profile Photo Section -->
                        <div class="col-md-4 text-center">
                            <div class="profile-photo-section">
                                <div class="profile-avatar-container">
                                    <div class="profile-avatar" id="profileAvatar">
                                        <?php if (isset($user['foto_url']) && !empty($user['foto_url'])): ?>
                                            <img src="<?= $user['foto_url'] ?>" alt="Profile Picture" id="avatarImage">
                                        <?php else: ?>
                                            <div class="avatar-initials" id="avatarInitials">
                                                <?= $user['avatar_initials'] ?? 'AD' ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="avatar-upload-overlay" id="avatarUpload">
                                        <i class="bi bi-camera"></i>
                                        <span>Change</span>
                                    </div>
                                </div>
                                <input type="file" id="avatarInput" accept="image/*" style="display: none;">
                                <button class="btn btn-change-photo" id="changePhotoBtn">
                                    <i class="bi bi-camera me-2"></i>
                                    Change Photo
                                </button>
                            </div>
                        </div>

                        <!-- Profile Info Section -->
                        <div class="col-md-8">
                            <div class="profile-info">
                                <h4 class="profile-name"><?= esc($user['nama_lengkap'] ?? 'Administrator') ?></h4>
                                <p class="profile-username">@<?= esc($user['nama_pengguna'] ?? 'admin') ?></p>
                                <div class="profile-badges mb-3">
                                    <span class="badge badge-role badge-super-admin">
                                        <?= esc($user['role'] ?? 'Super Admin') ?>
                                    </span>
                                    <span class="badge badge-status badge-aktif">
                                        <?= esc($user['status'] ?? 'Aktif') ?>
                                    </span>
                                </div>
                                <div class="profile-details">
                                    <div class="detail-item">
                                        <i class="bi bi-envelope me-2"></i>
                                        <span><?= esc($user['email'] ?? 'admin@inlislite.com') ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="bi bi-clock me-2"></i>
                                        <span>Last login: <?= $user['last_login_formatted'] ?? 'Belum pernah login' ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Name Section -->
            <div class="edit-name-section">
                <div class="section-header">
                    <h2 class="section-title">Edit Name</h2>
                    <p class="section-subtitle">Update your display name and username</p>
                </div>
                
                <div class="edit-name-container">
                    <form id="nameForm" class="modern-form">
                        <?= csrf_field() ?>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control modern-input" name="nama_lengkap" value="<?= esc($user['nama_lengkap'] ?? '') ?>" placeholder="Enter your full name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control modern-input" name="nama_pengguna" value="<?= esc($user['nama_pengguna'] ?? '') ?>" placeholder="Enter your username" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-update-name" id="updateNameBtn">
                                <i class="bi bi-check-lg me-2"></i>
                                Update Name
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="password-section">
                <div class="section-header">
                    <h2 class="section-title">Change Password</h2>
                    <p class="section-subtitle">Update your account password for security</p>
                </div>
                
                <div class="password-container">
                    <form id="passwordForm" class="modern-form">
                        <?= csrf_field() ?>
                        <div class="form-grid">
                            <div class="form-group form-group-full">
                                <label class="form-label">Current Password</label>
                                <div class="password-input-group">
                                    <input type="password" class="form-control modern-input" id="currentPassword" name="current_password" placeholder="Enter current password" required>
                                    <button type="button" class="password-toggle" data-target="currentPassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <div class="password-input-group">
                                    <input type="password" class="form-control modern-input" id="newPassword" name="kata_sandi" placeholder="Enter new password" required>
                                    <button type="button" class="password-toggle" data-target="newPassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="password-strength" id="passwordStrength"></div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirm New Password</label>
                                <div class="password-input-group">
                                    <input type="password" class="form-control modern-input" id="confirmPassword" name="confirm_password" placeholder="Confirm new password" required>
                                    <button type="button" class="password-toggle" data-target="confirmPassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-update-password" id="updatePasswordBtn">
                                <i class="bi bi-shield-check me-2"></i>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Toast Container -->
    <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;"></div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url('assets/js/admin/profile.js') ?>"></script>
    
</body>
</html>