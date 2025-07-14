<?php
/**
 * Admin Sidebar Partials - Revised
 * Enhanced sidebar with dynamic menu and dropdown functionality
 */

// Load auth helper for role checking
helper('auth');

// Get current URI for active menu detection
$uri = service('uri');
$currentPath = $uri->getPath();
$currentSegments = $uri->getSegments();

// Debug information (remove in production)
if (ENVIRONMENT === 'development') {
    log_message('debug', 'Sidebar - Current Path: ' . $currentPath);
    log_message('debug', 'Sidebar - Current Segments: ' . implode('/', $currentSegments));
}

// Menu configuration
$menuItems = [
    [
        'title' => 'Dashboard',
        'icon' => '📊',
        'url' => 'admin/dashboard',
        'active_patterns' => ['admin/dashboard', 'admin$', 'dashboard'],
        'type' => 'link'
    ],
    [
        'title' => 'Fitur',
        'icon' => '🧩',
        'url' => '#',
        'active_patterns' => ['fitur', 'tentang', 'installer', 'aplikasi', 'patch', 'panduan', 'dukungan', 'bimbingan', 'demo'],
        'type' => 'dropdown',
        'submenu' => [
            ['title' => 'Tentang Kami', 'url' => 'admin/tentang'],
            ['title' => 'Fitur dan Program Modul', 'url' => 'admin/fitur'],
            ['title' => 'Installer', 'url' => 'admin/installer'],
            ['title' => 'Patch dan Updater', 'url' => 'admin/patch'],
            ['title' => 'Aplikasi Pendukung', 'url' => 'admin/aplikasi'],
            ['title' => 'Panduan', 'url' => 'admin/panduan'],
            ['title' => 'Dukungan Teknis', 'url' => 'admin/dukungan'],
            ['title' => 'Bimbingan Teknis', 'url' => 'admin/bimbingan'],
            ['title' => 'Demo Program', 'url' => 'admin/demo']
        ]
    ],
    [
        'title' => 'Manajemen Pengguna',
        'icon' => '👥',
        'url' => 'admin/users',
        'active_patterns' => ['admin/users', 'admin/user_management', 'usermanagement', 'user-management', 'user_management'],
        'type' => 'link',
        'permission' => 'can_view_users'
    ],
    [
        'title' => 'Registrasi',
        'icon' => '📝',
        'url' => 'admin/registration',
        'active_patterns' => ['admin/registration', 'registration'],
        'type' => 'link'
    ],
    [
        'title' => 'Profile',
        'icon' => '👤',
        'url' => 'admin/profile',
        'active_patterns' => ['admin/profile', 'profile'],
        'type' => 'link'
    ]
];

// Function to check if menu item is active
function isMenuActive($patterns, $currentPath) {
    // Normalize the current path
    $currentPath = trim($currentPath, '/');
    
    foreach ($patterns as $pattern) {
        // Normalize the pattern
        $pattern = trim($pattern, '/');
        
        // Check for exact match
        if ($currentPath === $pattern) {
            return true;
        }
        
        // Check if current path starts with pattern
        if (strpos($currentPath, $pattern) === 0) {
            return true;
        }
        
        // Check for pattern matching
        if (preg_match('#^' . preg_quote($pattern, '#') . '($|/)#i', $currentPath)) {
            return true;
        }
    }
    return false;
}

// Function to check if submenu is active
function isSubmenuActive($submenu, $currentPath) {
    foreach ($submenu as $item) {
        $itemPath = trim($item['url'], '/');
        if (strpos($currentPath, $itemPath) !== false) {
            return true;
        }
    }
    return false;
}
?>

<!-- Enhanced Sidebar Styles - External CSS -->
<link href="<?= base_url('assets/css/enhanced-sidebar.css') ?>" rel="stylesheet">

<!-- Mobile Toggle Button -->
<button class="enhanced-mobile-toggle" id="enhancedMobileToggle">
    <span>☰</span>
</button>

<!-- Sidebar Overlay for Mobile -->
<div class="enhanced-sidebar-overlay" id="enhancedSidebarOverlay"></div>

<!-- Enhanced Sidebar -->
<nav class="enhanced-sidebar" id="enhancedSidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="INLISlite Logo" class="sidebar-logo-img">
            <div class="logo-text">
                <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-logo">
                    INLISlite
                </a>
                <div class="sidebar-subtitle">V3.0</div>
            </div>
        </div>
        <!-- Collapse Toggle Button -->
        <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
            <span class="toggle-icon"><<</span>
        </button>
    </div>
    
    <div class="sidebar-nav">
        <?php foreach ($menuItems as $index => $item): ?>
            <?php 
            // Skip user management menu for non-Super Admin users
            if (isset($item['permission']) && !function_exists($item['permission'])) {
                continue;
            }
            if (isset($item['permission']) && function_exists($item['permission']) && !call_user_func($item['permission'])) {
                continue;
            }
            
            $isActive = isMenuActive($item['active_patterns'], $currentPath);
            $isSubmenuActiveState = isset($item['submenu']) ? isSubmenuActive($item['submenu'], $currentPath) : false;
            
            if ($isSubmenuActiveState) {
                $isActive = true;
            }
            ?>
            
            <div class="nav-item">
                <?php if ($item['type'] === 'dropdown'): ?>
                    <a href="#" class="nav-link dropdown-toggle <?= $isActive ? 'active expanded' : '' ?>" 
                       data-dropdown="dropdown-<?= $index ?>" title="<?= $item['title'] ?>">
                        <span class="nav-icon"><?= $item['icon'] ?></span>
                        <span class="nav-text"><?= $item['title'] ?></span>
                    </a>
                    <div class="submenu <?= $isSubmenuActiveState ? 'expanded' : '' ?>" id="dropdown-<?= $index ?>">
                        <?php foreach ($item['submenu'] as $submenuItem): ?>
                            <?php 
                            $submenuPath = trim($submenuItem['url'], '/');
                            $isSubmenuItemActive = strpos($currentPath, $submenuPath) !== false;
                            ?>
                            <div class="submenu-item">
                                <a href="<?= base_url($submenuItem['url']) ?>" 
                                   class="nav-link <?= $isSubmenuItemActive ? 'active' : '' ?>">
                                    <span class="nav-text"><?= $submenuItem['title'] ?></span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url($item['url']) ?>" 
                       class="nav-link <?= $isActive ? 'active' : '' ?>" title="<?= $item['title'] ?>">
                        <span class="nav-icon"><?= $item['icon'] ?></span>
                        <span class="nav-text"><?= $item['title'] ?></span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Logout Section at Bottom -->
    <div class="sidebar-footer">
        <div class="nav-item logout-item">
            <a href="<?= base_url('admin/logout') ?>" class="nav-link logout-link" onclick="return confirmLogout();" title="Logout">
                <span class="nav-icon">🚪</span>
                <span class="nav-text">Logout</span>
            </a>
        </div>
    </div>
</nav>

<!-- Sidebar Functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('enhancedSidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const mainContent = document.querySelector('.enhanced-main-content') || document.querySelector('.main-content');
    const toggleIcon = toggleBtn?.querySelector('.toggle-icon');
    
    if (!sidebar || !toggleBtn || !toggleIcon) {
        console.error('Sidebar elements not found');
        return;
    }
    
    // Function to apply collapsed state
    function applyCollapsedState(collapsed) {
        const pageHeader = document.querySelector('.page-header');
        
        if (collapsed) {
            sidebar.classList.add('collapsed');
            if (mainContent) mainContent.classList.add('sidebar-collapsed');
            if (pageHeader) pageHeader.classList.add('sidebar-collapsed');
            toggleIcon.textContent = '>>';
            toggleBtn.title = 'Expand Sidebar';
            document.body.classList.add('sidebar-collapsed');
        } else {
            sidebar.classList.remove('collapsed');
            if (mainContent) mainContent.classList.remove('sidebar-collapsed');
            if (pageHeader) pageHeader.classList.remove('sidebar-collapsed');
            toggleIcon.textContent = '<<';
            toggleBtn.title = 'Collapse Sidebar';
            document.body.classList.remove('sidebar-collapsed');
        }
    }
    
    // Check saved state
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    applyCollapsedState(isCollapsed);
    
    // Toggle event
    toggleBtn.addEventListener('click', function() {
        const isCurrentlyCollapsed = sidebar.classList.contains('collapsed');
        const newState = !isCurrentlyCollapsed;
        
        applyCollapsedState(newState);
        localStorage.setItem('sidebarCollapsed', newState.toString());
    });
    
    // Handle dropdown functionality
    document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdownId = this.getAttribute('data-dropdown');
            const dropdown = document.getElementById(dropdownId);
            
            if (!dropdown) return;
            
            const isExpanded = this.classList.contains('expanded');
            
            if (isExpanded) {
                this.classList.remove('expanded');
                dropdown.classList.remove('expanded');
            } else {
                this.classList.add('expanded');
                dropdown.classList.add('expanded');
            }
        });
    });
    
    // Mobile menu toggle
    const mobileToggle = document.getElementById('enhancedMobileToggle');
    const sidebarOverlay = document.getElementById('enhancedSidebarOverlay');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            if (sidebarOverlay) {
                sidebarOverlay.classList.toggle('active');
            }
        });
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            this.classList.remove('active');
        });
    }
});
</script>

<!-- Logout Confirmation Script -->
<script>
function confirmLogout() {
    return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
}
</script>

<!-- Optimized Sidebar Styles -->
<style>
/* CSS Variables for Consistency */
:root {
    --sidebar-primary: #2DA84D;
    --sidebar-secondary: #2DA84D;
    --sidebar-text: #FFFFFF;
    --sidebar-hover: rgba(255, 255, 255, 0.1);
    --sidebar-active: rgba(255, 255, 255, 0.15);
    --sidebar-border: rgba(255, 255, 255, 0.1);
    --sidebar-width: 220px;
    --sidebar-collapsed-width: 70px;
    --transition-duration: 0.3s;
}

/* Enhanced Sidebar - Base Styles */
.enhanced-sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: var(--sidebar-width);
    background: var(--sidebar-primary);
    color: var(--sidebar-text);
    font-family: 'Poppins', sans-serif;
    z-index: 1000;
    transition: width var(--transition-duration) ease;
    box-shadow: 4px 0 20px rgba(45, 168, 77, 0.15);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.enhanced-sidebar .sidebar-header {
    background: var(--sidebar-primary);
    border-bottom: 1px solid var(--sidebar-border);
    padding: 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}

/* Logo Container Styles */
.logo-container {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
}

.sidebar-logo-img {
    width: 40px;
    height: 40px;
    object-fit: contain;
    border-radius: 8px;
}

.logo-text {
    display: flex;
    flex-direction: column;
}

.enhanced-sidebar .sidebar-logo {
    color: var(--sidebar-text);
    font-weight: 700;
    transition: transform 0.3s var(--transition-smooth);
}

.enhanced-sidebar .sidebar-logo:hover {
    color: var(--sidebar-text);
}

/* Sidebar Toggle Button */
.sidebar-toggle {
    background: none;
    border: none;
    color: var(--sidebar-text);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: var(--transition-duration) ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    flex-shrink: 0;
    font-size: 12px;
    font-weight: normal;
}

.sidebar-toggle:hover {
    background: rgba(255, 255, 255, 0.1);
}

.toggle-icon {
    font-size: 12px;
    font-weight: normal;
    line-height: 1;
}

/* Icon and text styles */
.nav-icon {
    font-size: 20px;
    margin-right: 12px;
    width: 24px;
    text-align: center;
    display: none; /* Hidden by default */
}

.nav-text {
    display: inline-block; /* Shown by default */
}

/* Collapsed Sidebar Styles */
.enhanced-sidebar.collapsed {
    width: var(--sidebar-collapsed-width) !important;
}

.enhanced-sidebar.collapsed .logo-text,
.enhanced-sidebar.collapsed .nav-text,
.enhanced-sidebar.collapsed .sidebar-subtitle {
    display: none !important;
}

.enhanced-sidebar.collapsed .nav-icon {
    display: block !important;
    margin-right: 0;
    width: 24px;
    text-align: center;
}

.enhanced-sidebar.collapsed .logo-container {
    justify-content: center;
    width: 100%;
}

.enhanced-sidebar.collapsed .sidebar-logo-img {
    margin: 0;
    width: 32px;
    height: 32px;
}

.enhanced-sidebar.collapsed .nav-link {
    justify-content: center;
    padding: 12px 8px;
}

.enhanced-sidebar.collapsed .submenu {
    display: none;
}

.enhanced-sidebar.collapsed .dropdown-toggle::after {
    display: none;
}

.enhanced-sidebar.collapsed .sidebar-toggle {
    width: 24px;
    height: 24px;
    padding: 0.2rem;
}

.enhanced-sidebar.collapsed .toggle-icon {
    font-size: 10px;
}

.enhanced-sidebar.collapsed .sidebar-header {
    padding: 15px 10px;
    flex-direction: column;
    gap: 10px;
    align-items: center;
}

/* Tooltip styling for collapsed state */
.enhanced-sidebar.collapsed .nav-link {
    position: relative;
}

.enhanced-sidebar.collapsed .nav-link:hover::after {
    content: attr(title);
    position: absolute;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 8px 12px;
    border-radius: 4px;
    white-space: nowrap;
    font-size: 14px;
    margin-left: 10px;
    z-index: 1000;
    pointer-events: none;
}

.enhanced-sidebar .sidebar-nav {
    flex: 1;
    padding: 10px 0;
    overflow-y: auto;
    overflow-x: hidden;
    max-height: calc(100vh - 120px);
}

.enhanced-sidebar .nav-item {
    margin: 2px 12px;
}

.enhanced-sidebar .nav-link {
    display: flex;
    align-items: center;
    padding: 10px 12px;
    color: var(--sidebar-text);
    text-decoration: none;
    border-radius: 6px;
    font-weight: 500;
    transition: background var(--transition-duration) ease;
    position: relative;
    font-size: 14px;
}

.enhanced-sidebar .nav-link:hover {
    background: var(--sidebar-hover);
    color: var(--sidebar-text);
}

.enhanced-sidebar .nav-link.active {
    background: var(--sidebar-secondary);
    color: var(--sidebar-text);
    font-weight: 700;
}

/* Dropdown functionality */
.enhanced-sidebar .dropdown-toggle::after {
    content: "▼";
    margin-left: auto;
    font-size: 12px;
    opacity: 0.8;
}

.enhanced-sidebar .dropdown-toggle.expanded::after {
    content: "▲";
}

.enhanced-sidebar .submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease;
    background: rgba(0, 0, 0, 0.15);
    margin: 2px 12px;
    border-radius: 6px;
}

.enhanced-sidebar .submenu.expanded {
    max-height: 600px;
}

.enhanced-sidebar .submenu .nav-link {
    padding: 8px 12px;
    font-size: 13px;
    margin: 0;
    border-radius: 4px;
    font-weight: 400;
}

.enhanced-sidebar .submenu .nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
}

.enhanced-sidebar .submenu .nav-link.active {
    background: rgba(45, 168, 77, 0.8);
    font-weight: 600;
}

/* Sidebar Footer Styles */
.sidebar-footer {
    padding: 15px 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    margin-top: auto;
    flex-shrink: 0;
}

.logout-item {
    margin: 0 16px;
}

.logout-link {
    background: transparent !important;
    color: var(--sidebar-text) !important;
    border-radius: 6px;
    font-weight: 500;
}

.logout-link:hover {
    background: rgba(255, 255, 255, 0.1) !important;
    color: var(--sidebar-text) !important;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .enhanced-sidebar {
        transform: translateX(-100%);
        width: 200px !important;
    }
    
    .enhanced-sidebar.collapsed {
        transform: translateX(-100%);
        width: 60px !important;
    }
    
    .enhanced-sidebar.show {
        transform: translateX(0);
    }
    
    .enhanced-main-content {
        margin-left: 0 !important;
    }
}

/* Enhanced Scrollbar styling */
.enhanced-sidebar::-webkit-scrollbar,
.enhanced-sidebar .sidebar-nav::-webkit-scrollbar {
    width: 6px;
}

.enhanced-sidebar::-webkit-scrollbar-track,
.enhanced-sidebar .sidebar-nav::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 3px;
}

.enhanced-sidebar::-webkit-scrollbar-thumb,
.enhanced-sidebar .sidebar-nav::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}

.enhanced-sidebar::-webkit-scrollbar-thumb:hover,
.enhanced-sidebar .sidebar-nav::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

/* Firefox scrollbar styling */
.enhanced-sidebar,
.enhanced-sidebar .sidebar-nav {
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
}

/* Global page layout fixes */
body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* Header adaptations for sidebar */
.page-header {
    margin-left: var(--sidebar-width);
    transition: margin-left var(--transition-duration) ease;
    position: relative;
    z-index: 2;
}

.enhanced-sidebar.collapsed ~ .page-header,
body.sidebar-collapsed .page-header {
    margin-left: var(--sidebar-collapsed-width);
}

/* Prevent page content overlap */
.enhanced-main-content,
.main-content {
    margin-left: var(--sidebar-width);
    transition: margin-left var(--transition-duration) ease;
    position: relative;
    z-index: 1;
}

.enhanced-sidebar.collapsed ~ .enhanced-main-content,
.enhanced-sidebar.collapsed ~ .main-content,
body.sidebar-collapsed .enhanced-main-content,
body.sidebar-collapsed .main-content {
    margin-left: var(--sidebar-collapsed-width);
}

/* Layout-based pages (using admin_layout.php) */
.page-content {
    padding: 0;
}

.page-content .page-header {
    margin-left: 0; /* Already handled by main content wrapper */
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 20px 30px;
}

/* Scrollbar for all content areas */
.enhanced-main-content,
.main-content,
.page-content {
    max-height: 100vh;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(0,0,0,0.3) rgba(0,0,0,0.1);
}

.enhanced-main-content::-webkit-scrollbar,
.main-content::-webkit-scrollbar,
.page-content::-webkit-scrollbar {
    width: 8px;
}

.enhanced-main-content::-webkit-scrollbar-track,
.main-content::-webkit-scrollbar-track,
.page-content::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.1);
    border-radius: 4px;
}

.enhanced-main-content::-webkit-scrollbar-thumb,
.main-content::-webkit-scrollbar-thumb,
.page-content::-webkit-scrollbar-thumb {
    background: rgba(0,0,0,0.3);
    border-radius: 4px;
}

.enhanced-main-content::-webkit-scrollbar-thumb:hover,
.main-content::-webkit-scrollbar-thumb:hover,
.page-content::-webkit-scrollbar-thumb:hover {
    background: rgba(0,0,0,0.5);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-header,
    .enhanced-main-content,
    .main-content {
        margin-left: 0 !important;
    }
}
</style>
