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
                <a href="<?= base_url('registration') ?>" class="nav-link">
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
                            <i class="bi bi-person"></i>
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

            <div class="row g-4">
                <!-- Profile Card Section -->
                <div class="col-lg-4">
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="profile-avatar-container">
                                <div class="profile-avatar" id="profileAvatar">
                                    <?php if (isset($user['avatar']) && !empty($user['avatar'])): ?>
                                        <img src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>" alt="Profile Picture" id="avatarImage">
                                    <?php else: ?>
                                        <div class="avatar-initials" id="avatarInitials">
                                            <?= strtoupper(substr($user['nama_lengkap'] ?? 'A', 0, 2)) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="avatar-upload-overlay" id="avatarUpload">
                                    <i class="bi bi-camera"></i>
                                    <span>Change Photo</span>
                                </div>
                                <input type="file" id="avatarInput" accept="image/*" style="display: none;">
                            </div>
                            
                            <div class="profile-info">
                                <h3 class="profile-name"><?= esc($user['nama_lengkap'] ?? 'Administrator') ?></h3>
                                <p class="profile-username">@<?= esc($user['nama_pengguna'] ?? 'admin') ?></p>
                                <div class="profile-badges">
                                    <span class="badge badge-role <?= getRoleBadgeClass($user['role'] ?? 'Super Admin') ?>">
                                        <?= esc($user['role'] ?? 'Super Admin') ?>
                                    </span>
                                    <span class="badge badge-status <?= getStatusBadgeClass($user['status'] ?? 'Aktif') ?>">
                                        <?= esc($user['status'] ?? 'Aktif') ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="profile-actions">
                            <button class="btn btn-primary w-100" id="changePhotoBtn">
                                <i class="bi bi-camera me-2"></i>
                                Change Profile Picture
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Account Information & Password Change -->
                <div class="col-lg-8">
                    <!-- Account Information Section -->
                    <div class="info-card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="bi bi-info-circle me-2"></i>
                                Account Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="info-label">Email Address</label>
                                        <div class="info-value">
                                            <i class="bi bi-envelope me-2"></i>
                                            <?= esc($user['email'] ?? 'admin@inlislite.com') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="info-label">Created Account</label>
                                        <div class="info-value">
                                            <i class="bi bi-calendar-plus me-2"></i>
                                            <?= date('d M Y', strtotime($user['created_at'] ?? date('Y-m-d'))) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="info-label">Last Login</label>
                                        <div class="info-value">
                                            <i class="bi bi-clock me-2"></i>
                                            <?= isset($user['last_login']) ? date('d M Y, H:i', strtotime($user['last_login'])) : 'Never' ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="info-label">Account Status</label>
                                        <div class="info-value">
                                            <span class="badge badge-status <?= getStatusBadgeClass($user['status'] ?? 'Aktif') ?>">
                                                <?= esc($user['status'] ?? 'Aktif') ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password Section -->
                    <div class="password-card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="bi bi-shield-lock me-2"></i>
                                Change Password
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="passwordForm">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Current Password</label>
                                        <div class="password-input-group">
                                            <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                                            <button type="button" class="password-toggle" data-target="currentPassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">New Password</label>
                                        <div class="password-input-group">
                                            <input type="password" class="form-control" id="newPassword" name="new_password" required>
                                            <button type="button" class="password-toggle" data-target="newPassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="password-strength" id="passwordStrength"></div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Confirm New Password</label>
                                        <div class="password-input-group">
                                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                                            <button type="button" class="password-toggle" data-target="confirmPassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="button" class="btn btn-secondary" id="resetPasswordForm">
                                        <i class="bi bi-arrow-clockwise me-2"></i>
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="updatePasswordBtn">
                                        <i class="bi bi-shield-check me-2"></i>
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
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
    <script src="<?= base_url('assets/js/admin/profile.js') ?>"></script>
    
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

<?php
// Helper functions for badge classes
function getRoleBadgeClass($role) {
    switch (strtolower($role)) {
        case 'super admin':
            return 'badge-super-admin';
        case 'admin':
            return 'badge-admin';
        case 'pustakawan':
        case 'librarian':
            return 'badge-librarian';
        case 'staff':
            return 'badge-staff';
        default:
            return 'badge-admin';
    }
}

function getStatusBadgeClass($status) {
    switch (strtolower($status)) {
        case 'aktif':
        case 'active':
            return 'badge-active';
        case 'non-aktif':
        case 'inactive':
            return 'badge-inactive';
        default:
            return 'badge-active';
    }
}
?>