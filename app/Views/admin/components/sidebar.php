<?php
/**
 * Admin Sidebar Component
 * Simplified sidebar with only 4 features like dashboard
 */

// Get current URI to determine active menu
$current_uri = uri_string();
$current_segment = service('uri')->getSegment(2); // Get second segment (admin/[segment])
?>

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
        <!-- Dashboard -->
        <div class="nav-item">
            <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= ($current_segment === 'dashboard' || $current_segment === '') ? 'active' : '' ?>">
                <i data-feather="home" class="nav-icon"></i>
                <span class="nav-text">Dashboard</span>
            </a>
            <div class="nav-tooltip">Dashboard</div>
        </div>

        <!-- Manajemen User -->
        <div class="nav-item">
            <a href="<?= base_url('admin/users') ?>" class="nav-link <?= ($current_segment === 'users') ? 'active' : '' ?>">
                <i data-feather="users" class="nav-icon"></i>
                <span class="nav-text">Manajemen User</span>
            </a>
            <div class="nav-tooltip">Manajemen User</div>
        </div>

        <!-- Registrasi -->
        <div class="nav-item">
            <a href="<?= base_url('admin/registration') ?>" class="nav-link <?= ($current_segment === 'registration') ? 'active' : '' ?>">
                <i data-feather="book" class="nav-icon"></i>
                <span class="nav-text">Registrasi</span>
            </a>
            <div class="nav-tooltip">Registrasi</div>
        </div>

        <!-- Profile -->
        <div class="nav-item">
            <a href="<?= base_url('admin/profile') ?>" class="nav-link <?= ($current_segment === 'profile') ? 'active' : '' ?>">
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
</script>