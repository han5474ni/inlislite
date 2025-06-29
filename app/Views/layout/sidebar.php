<!-- Mobile overlay -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar-wrapper">
    <div class="sidebar-header">
        <a href="<?= site_url('dashboard') ?>" class="sidebar-brand">
            <i class="fa-solid fa-star fa-lg sidebar-brand-icon"></i>
            <div class="sidebar-brand-text">
                <h5 class="mb-0">INLISLite</h5>
                <small class="text-muted">v3.0 Dashboard</small>
            </div>
        </a>
        <!-- Mobile close button -->
        <button class="btn btn-sm sidebar-close-btn d-md-none" id="sidebar-close">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
    
    <ul class="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>" data-tooltip="Dashboard">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'user-management') ? 'active' : '' ?>" href="<?= site_url('user-management') ?>" data-tooltip="Manajemen User">
                <i class="fa-solid fa-users"></i>
                <span>Manajemen User</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'registration') ? 'active' : '' ?>" href="<?= site_url('registration') ?>" data-tooltip="Registrasi">
                <i class="fa-solid fa-book-open-reader"></i>
                <span>Registrasi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'profile') ? 'active' : '' ?>" href="<?= site_url('profile') ?>" data-tooltip="Profile">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span>
            </a>
        </li>
    </ul>

    <!-- Desktop collapse button -->
    <button class="btn btn-sm toggle-btn d-none d-md-flex" id="menu-toggle">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
</aside>