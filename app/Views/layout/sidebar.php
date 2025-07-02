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
                <a href="<?= site_url('registration') ?>" class="nav-link <?= (uri_string() == 'registration') ? 'active' : '' ?>" data-tooltip="Registrasi">
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
