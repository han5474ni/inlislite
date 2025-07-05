<!-- New Vertical Sidebar Component -->
<div class="sidebar-overlay-new" id="sidebar-overlay-new"></div>

<!-- Sidebar -->
<aside class="sidebar-new" id="sidebar-new">
    <!-- Header Logo Section -->
    <div class="sidebar-header-new">
        <div class="logo-section">
            <div class="logo-image">
                <i class="fa-solid fa-star fa-2x text-white"></i>
            </div>
            <div class="logo-text">
                <h4 class="logo-title">INLISLite</h4>
                <small class="logo-subtitle">v3.0 Dashboard</small>
            </div>
        </div>
        
        <!-- Collapse/Expand Button -->
        <button class="collapse-btn" id="collapse-btn" title="Toggle Sidebar">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="sidebar-nav-new">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="<?= site_url('dashboard') ?>" class="nav-link <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : '' ?>" data-tooltip="Dashboard">
                    <i class="fa-solid fa-house nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('user-management') ?>" class="nav-link <?= (uri_string() == 'user-management') ? 'active' : '' ?>" data-tooltip="Manajemen User">
                    <i class="fa-solid fa-users nav-icon"></i>
                    <span class="nav-text">Manajemen User</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/registration') ?>" class="nav-link <?= (uri_string() == 'admin/registration') ? 'active' : '' ?>" data-tooltip="Registrasi">
                    <i class="fa-solid fa-book nav-icon"></i>
                    <span class="nav-text">Registrasi</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('profile') ?>" class="nav-link <?= (uri_string() == 'profile') ? 'active' : '' ?>" data-tooltip="Profile">
                    <i class="fa-solid fa-user nav-icon"></i>
                    <span class="nav-text">Profile</span>
                </a>
            </li>
            
            <!-- Logout Button -->
            <li class="nav-item logout-item">
                <a href="<?= site_url('admin/secure-logout') ?>" class="nav-link logout-link" data-tooltip="Logout" onclick="return confirmLogout()">
                    <i class="fa-solid fa-right-from-bracket nav-icon"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Mobile Close Button -->
    <button class="mobile-close-btn d-md-none" id="mobile-close-btn">
        <i class="fa-solid fa-times"></i>
    </button>
</aside>

<!-- Mobile Toggle Button -->
<button class="mobile-toggle-btn d-md-none" id="mobile-toggle-btn">
    <i class="fa-solid fa-bars"></i>
</button>

<style>
/* Logout button styling for new sidebar */
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
.sidebar-nav-new {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 120px);
    overflow: hidden;
}

.sidebar-nav-new .nav-list {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.sidebar-nav-new .nav-item:not(.logout-item) {
    flex-shrink: 0;
}
</style>

<script>
// Logout confirmation function
function confirmLogout() {
    return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
}
</script>
