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
        'icon' => 'bi-speedometer2',
        'url' => 'admin/dashboard',
        'active_patterns' => ['admin/dashboard', 'admin$', 'dashboard'],
        'type' => 'link'
    ],
    [
        'title' => 'Fitur',
        'icon' => 'bi-grid',
        'url' => '#',
        'active_patterns' => ['fitur', 'tentang', 'installer', 'aplikasi', 'patch', 'panduan', 'dukungan', 'bimbingan', 'demo'],
        'type' => 'dropdown',
        'submenu' => [
            ['title' => 'Tentang Kami', 'url' => 'admin/tentang', 'icon' => 'bi-info-circle'],
            ['title' => 'Fitur dan Program Modul', 'url' => 'admin/fitur', 'icon' => 'bi-grid-3x3-gap'],
            ['title' => 'Installer', 'url' => 'admin/installer', 'icon' => 'bi-download'],
            ['title' => 'Patch dan Updater', 'url' => 'admin/patch', 'icon' => 'bi-arrow-repeat'],
            ['title' => 'Aplikasi Pendukung', 'url' => 'admin/aplikasi', 'icon' => 'bi-app-indicator'],
            ['title' => 'Panduan', 'url' => 'admin/panduan', 'icon' => 'bi-journal-text'],
            ['title' => 'Dukungan Teknis', 'url' => 'admin/dukungan', 'icon' => 'bi-life-preserver'],
            ['title' => 'Bimbingan Teknis', 'url' => 'admin/bimbingan', 'icon' => 'bi-mortarboard'],
            ['title' => 'Demo Program', 'url' => 'admin/demo', 'icon' => 'bi-play-circle']
        ]
    ],
    [
        'title' => 'Manajemen Pengguna',
        'icon' => 'bi-people',
        'url' => 'admin/users',
        'active_patterns' => ['admin/users', 'admin/user_management', 'usermanagement', 'user-management', 'user_management'],
        'type' => 'link',
        'show_for_admin' => true
    ],

    [
        'title' => 'Profile',
        'icon' => 'bi-person-circle',
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<!-- Removed enhanced-sidebar.css to restore original theme colors -->

<!-- Mobile Toggle Button -->
<!-- Removed extra hamburger toggle to avoid duplication with circular toggle -->

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
            </div>
        </div>
        <!-- Collapse Toggle Button -->
        <button class="sidebar-toggle" id="sidebarToggle" title="Collapse Sidebar" aria-label="Collapse Sidebar">
            <i class="bi bi-chevron-left" id="toggleCollapseIcon" style="line-height:1; display:inline-block;"></i>
        </button>
    </div>
    
    <div class="sidebar-nav">
        <?php foreach ($menuItems as $index => $item): ?>
            <?php 
            // Debug permission check
            if (isset($item['permission'])) {
                $permissionFunction = $item['permission'];
                $functionExists = function_exists($permissionFunction);
                $hasPermission = $functionExists ? call_user_func($permissionFunction) : false;
                
                if (ENVIRONMENT === 'development' && $item['title'] === 'Manajemen Pengguna') {
                    log_message('debug', 'Permission check for ' . $item['title'] . ':');
                    log_message('debug', '- Function: ' . $permissionFunction);
                    log_message('debug', '- Function exists: ' . ($functionExists ? 'true' : 'false'));
                    log_message('debug', '- Has permission: ' . ($hasPermission ? 'true' : 'false'));
                    log_message('debug', '- Session admin_role: ' . (session('admin_role') ?? 'none'));
                    log_message('debug', '- Session admin_logged_in: ' . (session('admin_logged_in') ? 'true' : 'false'));
                }
                
                if (!$functionExists || !$hasPermission) {
                    continue;
                }
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
                        <span class="nav-icon"><i class="bi <?= $item['icon'] ?>"></i></span>
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
                                   class="nav-link <?= $isSubmenuItemActive ? 'active' : '' ?>" title="<?= $submenuItem['title'] ?>">
                                    <span class="nav-icon"><i class="bi <?= $submenuItem['icon'] ?? 'bi-dot' ?>"></i></span>
                                    <span class="nav-text"><?= $submenuItem['title'] ?></span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url($item['url']) ?>" 
                       class="nav-link <?= $isActive ? 'active' : '' ?>" title="<?= $item['title'] ?>">
                        <span class="nav-icon"><i class="bi <?= $item['icon'] ?>"></i></span>
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
    // Mark that inline enhanced sidebar handlers are active to avoid duplicates
    window.ENHANCED_SIDEBAR_INLINE = true;

    const sidebar = document.getElementById('enhancedSidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const mainContent = document.querySelector('.enhanced-main-content') || document.querySelector('.main-content');
    const toggleIcon = document.getElementById('toggleCollapseIcon');
    
    if (!sidebar || !toggleBtn || !toggleIcon) {
        console.error('Sidebar elements not found');
        return;
    }

    // Position the circular toggle aligned at the divider line below the header title
    function positionFloatingToggle() {
        const sidebarRect = sidebar.getBoundingClientRect();
        const header = sidebar.querySelector('.sidebar-header');
        const headerRect = header ? header.getBoundingClientRect() : sidebarRect;

        // Vertical: align near the header bottom (divider line)
        const dividerOffset = 6; // slight offset below the line
        let targetY = headerRect.bottom + dividerOffset;

        // Clamp within sidebar visible area
        const SAFE_TOP = 8;
        const SAFE_BOTTOM = 24;
        const minY = sidebarRect.top + SAFE_TOP;
        const maxY = sidebarRect.bottom - SAFE_BOTTOM;
        targetY = Math.max(minY, Math.min(targetY, maxY));

        // Horizontal: center the circle on the sidebar edge (half overlap)
        const btnWidth = toggleBtn.offsetWidth || 44;
        let left = sidebarRect.right - (btnWidth / 2); // half overlaps the sidebar

        // Prevent going beyond viewport on the right side
        const maxLeft = window.innerWidth - btnWidth - 8; // 8px margin from edge
        left = Math.min(left, maxLeft);

        // Apply immediately, then adjust slightly after transitions
        toggleBtn.style.left = left + 'px';
        toggleBtn.style.top = targetY + 'px';

        // If sidebar is animating width, re-apply after a short delay
        const td = getComputedStyle(sidebar).transitionDuration;
        if (td && td !== '0s') {
            const ms = Math.ceil(parseFloat(td) * 1000) + 50;
            setTimeout(() => {
                const sr = sidebar.getBoundingClientRect();
                const bw = toggleBtn.offsetWidth || 44;
                const adjLeft = sr.right - (bw / 2);
                const maxLeft2 = window.innerWidth - bw - 8;
                toggleBtn.style.left = Math.min(adjLeft, maxLeft2) + 'px';
            }, ms);
        }
    }
    
    // Function to apply collapsed state
    function applyCollapsedState(collapsed) {
        const pageHeader = document.querySelector('.page-header');
        
        if (collapsed) {
            sidebar.classList.add('collapsed');
            if (mainContent) mainContent.classList.add('sidebar-collapsed');
            if (pageHeader) pageHeader.classList.add('sidebar-collapsed');
            toggleIcon.classList.remove('bi-chevron-left');
            toggleIcon.classList.add('bi-chevron-right');
            toggleBtn.title = 'Expand Sidebar';
            document.body.classList.add('sidebar-collapsed');
        } else {
            sidebar.classList.remove('collapsed');
            if (mainContent) mainContent.classList.remove('sidebar-collapsed');
            if (pageHeader) pageHeader.classList.remove('sidebar-collapsed');
            toggleIcon.classList.remove('bi-chevron-right');
            toggleIcon.classList.add('bi-chevron-left');
            toggleBtn.title = 'Collapse Sidebar';
            document.body.classList.remove('sidebar-collapsed');
        }
        positionFloatingToggle();
    }
    
    // Clear any conflicting localStorage keys and check saved state
    localStorage.removeItem('adminSidebarCollapsed');
    
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    applyCollapsedState(isCollapsed);
    
    // Toggle event
    toggleBtn.addEventListener('click', function() {
        const isCurrentlyCollapsed = sidebar.classList.contains('collapsed');
        const newState = !isCurrentlyCollapsed;
        
        applyCollapsedState(newState);
        localStorage.setItem('sidebarCollapsed', newState.toString());
    });

    // Reposition on resize/scroll for safety
    window.addEventListener('resize', positionFloatingToggle);
    window.addEventListener('scroll', positionFloatingToggle, { passive: true });
    setTimeout(positionFloatingToggle, 50);
    
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
    
    const setMobileState = (open) => {
        if (open) {
            sidebar.classList.add('mobile-open');
            if (sidebarOverlay) sidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            if (mobileToggle) mobileToggle.style.display = 'none';
        } else {
            sidebar.classList.remove('mobile-open');
            if (sidebarOverlay) sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
            if (mobileToggle) mobileToggle.style.display = '';
        }
    };

    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            setMobileState(!sidebar.classList.contains('mobile-open'));
        });
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            setMobileState(false);
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
    /* Ensure brand variables are defined here for all admin pages */
    --brand-green: #1FA166;
    --brand-green-dark: #0E7A52;

    /* Sidebar theme variables with safe fallbacks */
    --sidebar-primary: var(--brand-green-dark, #0E7A52);
    --sidebar-secondary: var(--brand-green, #1FA166);
    --sidebar-text: #FFFFFF;
    --sidebar-hover: rgba(255,255,255,0.08);
    --sidebar-active: rgba(255,255,255,0.12);
    --sidebar-border: rgba(255,255,255,0.25);
    --sidebar-width: 280px;
    --sidebar-collapsed-width: 80px;
    --transition-duration: 0.15s;
}

/* Enhanced Sidebar - Base Styles */
.enhanced-sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: var(--sidebar-width);
    background: linear-gradient(180deg, var(--sidebar-primary) 0%, var(--sidebar-secondary) 100%);
    color: var(--sidebar-text);
    font-family: 'Poppins', sans-serif;
    z-index: 1030; /* keep above content like in extracted CSS */
    transition: width var(--transition-duration) ease;
    box-shadow: none; /* Remove heavy shadow for minimal look */
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border-right: 1px solid rgba(255,255,255,0.25); /* subtle divider */
}

.enhanced-sidebar .sidebar-header {
    background: var(--sidebar-primary);
    border-bottom: 1px solid var(--sidebar-border);
    padding: 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
    position: relative;
    z-index: 2; /* keep above sidebar-nav scrollbar */
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

/* Hide leftover version text area spacing if any */
.sidebar-subtitle { display: none !important; }

.enhanced-sidebar .sidebar-logo {
    color: var(--sidebar-text);
    font-weight: 700;
    transition: transform 0.3s var(--transition-smooth);
}



/* Sidebar Toggle Button - small, subtle */
.sidebar-toggle {
    position: fixed; /* positioned via JS next to sidebar edge */
    left: auto;
    top: 50vh; /* initial; JS will correct */
    transform: translateY(-50%);
    width: 32px;
    height: 32px;
    background: #ffffff;
    color: var(--sidebar-primary);
    border: 1px solid rgba(0,0,0,0.15);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    z-index: 2000; /* keep above content */
    transition: background 0.15s ease, color 0.15s ease, transform 0.15s ease;
    pointer-events: auto;
}



.toggle-icon {
    font-size: 16px;
    font-weight: normal;
    line-height: 1;
}

/* Mobile fallback: keep inline inside header */
@media (max-width: 768px) {
    .sidebar-toggle {
        position: relative;
        left: 0;
        top: 0;
        transform: none;
        width: 28px;
        height: 28px;
        color: var(--sidebar-text);
        border: 1px solid rgba(0,0,0,0.15);
        box-shadow: none;
        z-index: 1;
    }

}

/* Icon and text styles */
.nav-icon {
    font-size: 1rem;
    margin-right: 8px;
    width: 20px;
    text-align: center;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.nav-text {
    display: inline-block;
    font-size: 13px; /* smaller text */
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
    display: block; /* allow submenu column in collapsed */
    background: rgba(255,255,255,0.12); /* translucent overlay on green */
    padding: 6px 4px;
    margin: 6px 6px 8px 6px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.18);
    box-shadow: none;
}

.enhanced-sidebar.collapsed .submenu .nav-text { display: none; }
.enhanced-sidebar.collapsed .submenu .nav-link { height: 36px; justify-content: center; }
.enhanced-sidebar.collapsed .submenu .nav-icon { width: 22px; font-size: 1.05rem; margin: 0; }
.enhanced-sidebar.collapsed .submenu .nav-link.active { background: rgba(255, 255, 255, 0.22); border-radius: 8px; }

.enhanced-sidebar.collapsed .dropdown-toggle::after {
    display: none;
}

.enhanced-sidebar.collapsed .sidebar-toggle {
    width: 32px;
    height: 32px;
    padding: 2px;
}

.enhanced-sidebar.collapsed .toggle-icon {
    font-size: 10px;
}

.enhanced-sidebar.collapsed .sidebar-header {
    padding: 12px 8px;
    flex-direction: column;
    gap: 8px;
    align-items: center;
}

/* Collapsed polish */
.enhanced-sidebar.collapsed .nav-item { margin: 6px; }
.enhanced-sidebar.collapsed .nav-link { justify-content: center; padding: 10px; width: 100%; height: 40px; border: 0; }
.enhanced-sidebar.collapsed .nav-link .nav-icon { width: 22px; font-size: 1.1rem; }
.enhanced-sidebar.collapsed .nav-link.active { background: rgba(255, 255, 255, 0.22); border: 0; padding: 10px; border-radius: 8px; }
.enhanced-sidebar.collapsed .dropdown-toggle .bi-caret-down-fill { display: none; }
/* Tooltip styling for collapsed state */
.enhanced-sidebar.collapsed .nav-link { 

.enhanced-sidebar .sidebar-nav {
    flex: 1;
    padding: 10px 0;
    overflow-y: auto;
    overflow-x: hidden;
    max-height: calc(100vh - 120px);
    position: relative;
    z-index: 1;
    background: rgba(255,255,255,0.08); /* subtle contrast for inner scroll area */
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



.enhanced-sidebar .nav-link.active {
    ; /* Minimal active */
    color: var(--sidebar-text);
    font-weight: 600;
    border-left: 2px solid rgb(255, 255, 255); /* subtle indicator */
    padding-left: 10px;
}

/* Dropdown functionality */
.enhanced-sidebar .dropdown-toggle::after {
    display: none !important; /* hide Bootstrap default caret */
    content: none !important;
    border: 0 !important;
}

.enhanced-sidebar .dropdown-toggle .bi-caret-down-fill { margin-left: auto; font-size: 0.9rem; opacity: .95; color: #ffffff; }
.enhanced-sidebar .dropdown-toggle.expanded .bi-caret-down-fill { transform: rotate(180deg); transition: transform .2s ease; }

.enhanced-sidebar .submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease;
    background: var(--brand-green-contrast); /* light brand green background */
    margin: 4px 12px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.18);
    box-shadow: none;
}

.enhanced-sidebar .submenu.expanded {
    max-height: 600px;
}

.enhanced-sidebar .submenu .nav-link {
    padding: 10px 12px;
    font-size: 13px;
    margin: 0;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    color: var(--brand-blue-dark); /* stronger contrast on light green */
}

.enhanced-sidebar .submenu .nav-link .nav-icon { width: 18px; font-size: .95rem; margin-right: 8px; text-align: center; color: var(--brand-blue-dark); opacity: 0.9; }



.enhanced-sidebar .submenu .nav-link:hover {
    background: rgba(255,255,255,0.35); /* lighter overlay for legibility */
}

.enhanced-sidebar .submenu .nav-link.active {
    background: rgba(255,255,255,0.55);
    color: var(--brand-blue-dark);
    font-weight: 700;
    border-left: 3px solid var(--brand-blue);
    padding-left: 9px;
}

/* Sidebar Footer Styles */
.sidebar-footer {
    padding: 15px 0;
    border-top: 1px solid rgb(255, 255, 255);
    margin-top: auto;
    flex-shrink: 0;
}

.logout-item {
    margin: 0 16px;
}

.logout-link { 

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
    background: rgb(255, 255, 255);
    border-radius: 3px;
}

.enhanced-sidebar::-webkit-scrollbar-thumb,
.enhanced-sidebar .sidebar-nav::-webkit-scrollbar-thumb { 

/* Firefox scrollbar styling */
.enhanced-sidebar,
.enhanced-sidebar .sidebar-nav {
    scrollbar-width: thin;
    scrollbar-color: rgb(255, 255, 255) transparent;
}

/* Global page layout fixes */
body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* Header adaptations for sidebar - sticky header */
.page-header {
    margin-left: 0; /* handled by main wrapper margins */
    position: sticky;
    top: 0;
    z-index: 1100; /* above content */
    background: #ffffff; /* solid background to avoid transparency while sticky */
    transition: margin-left var(--transition-duration) ease;
}

.enhanced-sidebar.collapsed ~ .page-header,
body.sidebar-collapsed .page-header {
    margin-left: 0;
}

/* Prevent page content overlap */
.enhanced-main-content,
.main-content {
    margin-left: var(--sidebar-width);
    transition: margin-left var(--transition-duration) ease;
    position: relative;
    z-index: 1;
}

/* Ensure content aligns exactly to sidebar edge */
.enhanced-main-content > .container-fluid { padding-left: 12px; padding-right: 12px; }

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
    scrollbar-color: rgb(0, 0, 0) rgb(0, 0, 0);
}

.enhanced-main-content::-webkit-scrollbar,
.main-content::-webkit-scrollbar,
.page-content::-webkit-scrollbar {
    width: 8px;
}

.enhanced-main-content::-webkit-scrollbar-track,
.main-content::-webkit-scrollbar-track,
.page-content::-webkit-scrollbar-track {
    background: rgb(0, 0, 0);
    border-radius: 4px;
}

.enhanced-main-content::-webkit-scrollbar-thumb,
.main-content::-webkit-scrollbar-thumb,
.page-content::-webkit-scrollbar-thumb { 

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-header,
    .enhanced-main-content,
    .main-content {
        margin-left: 0 !important;
    }
}
</style>


