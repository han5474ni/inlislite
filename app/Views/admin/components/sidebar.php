<?php
/**
 * Admin Sidebar Component - Revised
 * Modern sidebar with dropdown functionality and mobile responsiveness
 */

// Load auth helper for role checking
helper('auth');

// Get current URI to determine active menu
$current_uri = uri_string();
$current_segment = service('uri')->getSegment(2); // Get second segment (admin/[segment])
$current_path = '/' . ltrim($current_uri, '/');
?>

<style>
/* Sidebar Styles */
.admin-sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: 280px;
    background: #2F80ED;
    color: #FFFFFF;
    font-family: 'Poppins', sans-serif;
    z-index: 1000;
    transition: transform 0.3s ease;
    box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
}

.admin-sidebar.collapsed {
    transform: translateX(-280px);
}

.sidebar-header {
    padding: 24px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    text-align: center;
}

.sidebar-logo {
    font-size: 1.5rem;
    font-weight: 700;
    color: #FFFFFF;
    text-decoration: none;
    display: block;
}

.sidebar-subtitle {
    font-size: 0.875rem;
    opacity: 0.8;
    margin-top: 4px;
}

.sidebar-nav {
    padding: 16px 0;
}

.nav-item {
    margin: 4px 16px;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 16px 20px;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    position: relative;
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #FFFFFF;
}

.nav-link.active {
    background: #56CCF2;
    font-weight: bold;
    color: #FFFFFF;
}

.nav-icon {
    font-size: 1.25rem;
    margin-right: 12px;
    width: 24px;
    text-align: center;
}

.nav-text {
    flex: 1;
}

.dropdown-toggle::after {
    content: '▼';
    font-size: 0.75rem;
    margin-left: auto;
    transition: transform 0.3s ease;
}

.dropdown-toggle.expanded::after {
    transform: rotate(180deg);
}

.submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin: 4px 0;
}

.submenu.expanded {
    max-height: 500px;
}

.submenu-item {
    padding-left: 20px;
}

.submenu .nav-link {
    padding: 12px 20px;
    font-size: 0.875rem;
    margin: 0;
    border-radius: 8px;
}

/* Mobile Toggle */
.mobile-toggle {
    display: none;
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1001;
    background: #2F80ED;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.25rem;
}

/* Main content adjustment */
.main-content {
    margin-left: 280px;
    transition: margin-left 0.3s ease;
}

.main-content.sidebar-collapsed {
    margin-left: 0;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .admin-sidebar {
        transform: translateX(-280px);
    }
    
    .admin-sidebar.mobile-open {
        transform: translateX(0);
    }
    
    .mobile-toggle {
        display: block;
    }
    
    .main-content {
        margin-left: 0;
    }
}

/* Overlay for mobile */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

.sidebar-overlay.active {
    display: block;
}
</style>

<!-- Mobile Toggle Button -->
<button class="mobile-toggle" id="mobileToggle">
    <span class="nav-icon">☰</span>
</button>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<nav class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-logo">
            📚 Inlislite V3
        </a>
        <div class="sidebar-subtitle">Admin Panel</div>
    </div>
    
    <div class="sidebar-nav">
        <!-- Dashboard -->
        <div class="nav-item">
            <a href="<?= base_url('admin/dashboard') ?>" 
               class="nav-link <?= ($current_segment === 'dashboard' || $current_segment === '') ? 'active' : '' ?>">
                <span class="nav-icon">📊</span>
                <span class="nav-text">Dashboard</span>
            </a>
        </div>

        <!-- Fitur (Dropdown) -->
        <div class="nav-item">
            <a href="#" class="nav-link dropdown-toggle" id="fiturDropdown">
                <span class="nav-icon">🧩</span>
                <span class="nav-text">Fitur</span>
            </a>
            <div class="submenu" id="fiturSubmenu">
                <div class="submenu-item">
                    <a href="<?= base_url('fitur/tentang-kami') ?>" 
                       class="nav-link <?= strpos($current_path, '/fitur/tentang-kami') !== false ? 'active' : '' ?>">
                        <span class="nav-text">Tentang Kami</span>
                    </a>
                </div>
                <div class="submenu-item">
                    <a href="<?= base_url('fitur/modul') ?>" 
                       class="nav-link <?= strpos($current_path, '/fitur/modul') !== false ? 'active' : '' ?>">
                        <span class="nav-text">Fitur dan Program Modul</span>
                    </a>
                </div>
                <div class="submenu-item">
                    <a href="<?= base_url('fitur/installer') ?>" 
                       class="nav-link <?= strpos($current_path, '/fitur/installer') !== false ? 'active' : '' ?>">
                        <span class="nav-text">Installer</span>
                    </a>
                </div>
                <div class="submenu-item">
                    <a href="<?= base_url('fitur/patch-updater') ?>" 
                       class="nav-link <?= strpos($current_path, '/fitur/patch-updater') !== false ? 'active' : '' ?>">
                        <span class="nav-text">Patch dan Updater</span>
                    </a>
                </div>
                <div class="submenu-item">
                    <a href="<?= base_url('fitur/aplikasi-pendukung') ?>" 
                       class="nav-link <?= strpos($current_path, '/fitur/aplikasi-pendukung') !== false ? 'active' : '' ?>">
                        <span class="nav-text">Aplikasi Pendukung</span>
                    </a>
                </div>
                <div class="submenu-item">
                    <a href="<?= base_url('fitur/panduan') ?>" 
                       class="nav-link <?= strpos($current_path, '/fitur/panduan') !== false ? 'active' : '' ?>">
                        <span class="nav-text">Panduan</span>
                    </a>
                </div>
                <div class="submenu-item">
                    <a href="<?= base_url('fitur/dukungan-teknis') ?>" 
                       class="nav-link <?= strpos($current_path, '/fitur/dukungan-teknis') !== false ? 'active' : '' ?>">
                        <span class="nav-text">Dukungan Teknis</span>
                    </a>
                </div>
                <div class="submenu-item">
                    <a href="<?= base_url('fitur/bimbingan-teknis') ?>" 
                       class="nav-link <?= strpos($current_path, '/fitur/bimbingan-teknis') !== false ? 'active' : '' ?>">
                        <span class="nav-text">Bimbingan Teknis</span>
                    </a>
                </div>
                <div class="submenu-item">
                    <a href="<?= base_url('fitur/demo-program') ?>" 
                       class="nav-link <?= strpos($current_path, '/fitur/demo-program') !== false ? 'active' : '' ?>">
                        <span class="nav-text">Demo Program</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Manajemen Pengguna -->
        <?php if (function_exists('can_view_users') && can_view_users()): ?>
        <div class="nav-item">
            <a href="<?= base_url('admin/users') ?>" 
               class="nav-link <?= ($current_segment === 'users' || $current_segment === 'users-edit') ? 'active' : '' ?>">
                <span class="nav-icon">👥</span>
                <span class="nav-text">Manajemen Pengguna</span>
            </a>
        </div>
        <?php endif; ?>

        <!-- Registrasi -->
        <div class="nav-item">
            <a href="<?= base_url('admin/registration') ?>" 
               class="nav-link <?= ($current_segment === 'registration') ? 'active' : '' ?>">
                <span class="nav-icon">📝</span>
                <span class="nav-text">Registrasi</span>
            </a>
        </div>

        <!-- Profile -->
        <div class="nav-item">
            <a href="<?= base_url('admin/profile') ?>" 
               class="nav-link <?= ($current_segment === 'profile') ? 'active' : '' ?>">
                <span class="nav-icon">👤</span>
                <span class="nav-text">Profile</span>
            </a>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('adminSidebar');
    const mobileToggle = document.getElementById('mobileToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const fiturDropdown = document.getElementById('fiturDropdown');
    const fiturSubmenu = document.getElementById('fiturSubmenu');
    const mainContent = document.querySelector('.main-content') || document.body;

    // Mobile toggle functionality
    function toggleSidebar() {
        sidebar.classList.toggle('mobile-open');
        sidebarOverlay.classList.toggle('active');
    }

    if (mobileToggle) {
        mobileToggle.addEventListener('click', toggleSidebar);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', toggleSidebar);
    }

    // Fitur dropdown toggle
    if (fiturDropdown && fiturSubmenu) {
        fiturDropdown.addEventListener('click', function(e) {
            e.preventDefault();
            
            const isExpanded = fiturSubmenu.classList.contains('expanded');
            
            // Close all other dropdowns (accordion style)
            document.querySelectorAll('.submenu.expanded').forEach(submenu => {
                if (submenu !== fiturSubmenu) {
                    submenu.classList.remove('expanded');
                    submenu.previousElementSibling.classList.remove('expanded');
                }
            });
            
            // Toggle current dropdown
            if (isExpanded) {
                fiturSubmenu.classList.remove('expanded');
                fiturDropdown.classList.remove('expanded');
            } else {
                fiturSubmenu.classList.add('expanded');
                fiturDropdown.classList.add('expanded');
            }
        });
    }

    // Auto-expand fitur menu if current page is a fitur page
    const currentPath = window.location.pathname;
    if (currentPath.includes('/fitur/')) {
        if (fiturSubmenu && fiturDropdown) {
            fiturSubmenu.classList.add('expanded');
            fiturDropdown.classList.add('expanded');
        }
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
        }
    });
});
</script>
