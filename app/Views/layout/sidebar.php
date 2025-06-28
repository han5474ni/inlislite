<aside class="sidebar" id="sidebar-wrapper">
    <div class="sidebar-header">
        <a href="<?= site_url('dashboard') ?>" class="sidebar-brand">
            <i class="fa-solid fa-star fa-lg me-2"></i>
            <div class="sidebar-brand-text">
                <h5 class="mb-0">INLISLite</h5>
                <small class="text-muted">v3.0 Dashboard</small>
            </div>
        </a>
    </div>
    <ul class="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'user-management') ? 'active' : '' ?>" href="<?= site_url('user-management') ?>">
                <i class="fa-solid fa-users"></i>
                <span>Manajemen User</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'registration') ? 'active' : '' ?>" href="<?= site_url('registration') ?>">
                <i class="fa-solid fa-book-open-reader"></i>
                <span>Registrasi</span>
            </a>
        </li>
    </ul>
    <button class="btn btn-sm toggle-btn" id="menu-toggle"><i class="fa-solid fa-chevron-left"></i></button>
</aside>