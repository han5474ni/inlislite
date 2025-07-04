<?php
/**
 * Admin Sidebar Component
 * Shared sidebar for all admin pages with dynamic active state
 */

// Get current URI for active menu detection
$uri = service('uri');
$currentPath = $uri->getPath();
$currentSegments = $uri->getSegments();

// Debug information (remove in production)
if (ENVIRONMENT === 'development') {
    // Log current path for debugging
    log_message('debug', 'Sidebar - Current Path: ' . $currentPath);
    log_message('debug', 'Sidebar - Current Segments: ' . implode('/', $currentSegments));
}

// Define menu items with their routes and icons
$menuItems = [
    [
        'title' => 'Dashboard',
        'icon' => 'home',
        'url' => 'admin/dashboard',
        'active_patterns' => ['admin/dashboard', 'admin$']
    ],
    [
        'title' => 'Manajemen User',
        'icon' => 'users',
        'url' => 'admin/users',
        'active_patterns' => ['admin/users', 'admin/user_management', 'usermanagement', 'user-management']
    ],
    [
        'title' => 'Registrasi',
        'icon' => 'book',
        'url' => 'admin/registration',
        'active_patterns' => ['admin/registration']
    ],
    [
        'title' => 'Profile',
        'icon' => 'user',
        'url' => 'admin/profile',
        'active_patterns' => ['admin/profile']
    ]
];

// Function to check if menu item is active
function isMenuActive($patterns, $currentPath) {
    // Normalize the current path
    $currentPath = trim($currentPath, '/');
    
    foreach ($patterns as $pattern) {
        // Normalize the pattern
        $pattern = trim($pattern, '/');
        
        // Check for exact match or if current path starts with pattern
        if ($currentPath === $pattern || 
            strpos($currentPath, $pattern) === 0 ||
            preg_match('#' . preg_quote($pattern, '#') . '#i', $currentPath)) {
            return true;
        }
    }
    return false;
}
?>

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
        <?php foreach ($menuItems as $item): ?>
            <?php 
            $isActive = isMenuActive($item['active_patterns'], $currentPath);
            // Debug output for development
            if (ENVIRONMENT === 'development' && $item['title'] === 'Manajemen User') {
                echo "<!-- Debug: User Management - Current Path: $currentPath, Is Active: " . ($isActive ? 'true' : 'false') . " -->";
            }
            ?>
            <div class="nav-item">
                <a href="<?= base_url($item['url']) ?>" class="nav-link <?= $isActive ? 'active' : '' ?>" data-page="<?= $item['url'] ?>" data-patterns="<?= implode(',', $item['active_patterns']) ?>">
                    <i data-feather="<?= $item['icon'] ?>" class="nav-icon"></i>
                    <span class="nav-text"><?= $item['title'] ?></span>
                </a>
                <div class="nav-tooltip"><?= $item['title'] ?></div>
            </div>
        <?php endforeach; ?>
        
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
/* Logout button styling */
.logout-item {
    margin-top: auto;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 1rem;
}

.logout-link {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    color: white !important;
    transition: all 0.3s ease;
    font-weight: 600;
    /* Remove custom margin and border-radius to match other nav items */
    margin: 0 !important;
    border-radius: 0 !important;
    /* Remove text transformation to match other nav items */
    text-transform: none !important;
    letter-spacing: normal !important;
}

.logout-link:hover {
    background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%) !important;
    color: white !important;
    /* Remove transform to match other nav items hover behavior */
    transform: none !important;
    box-shadow: none !important;
}

.logout-link:hover .nav-icon {
    transform: translateX(3px);
}

/* Ensure sidebar nav takes full height and logout stays at bottom */
.sidebar-nav {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 120px);
    overflow-y: auto;
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

// Enhanced sidebar navigation with persistent active state
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const currentPath = window.location.pathname;
    
    // Function to set active menu item
    function setActiveMenuItem(targetPath) {
        navLinks.forEach(link => {
            link.classList.remove('active');
            const linkPath = link.getAttribute('data-page');
            
            // Check if current path matches this menu item
            if (linkPath === 'admin/users') {
                // Special handling for user management - check multiple possible URLs
                const patterns = link.getAttribute('data-patterns');
                console.log('Checking user management patterns:', patterns, 'against path:', targetPath);
                
                if (targetPath.includes('admin/users') || 
                    targetPath.includes('usermanagement') || 
                    targetPath.includes('user-management') ||
                    targetPath.includes('user_management')) {
                    link.classList.add('active');
                    console.log('User management menu activated');
                }
            } else if (linkPath === 'admin/dashboard') {
                // Dashboard handling
                if (targetPath.includes('admin/dashboard') || 
                    targetPath === '/admin' || 
                    targetPath === '/admin/' ||
                    targetPath.includes('dashboard')) {
                    link.classList.add('active');
                }
            } else if (linkPath === 'admin/registration') {
                // Registration handling
                if (targetPath.includes('admin/registration')) {
                    link.classList.add('active');
                }
            } else if (linkPath === 'admin/profile') {
                // Profile handling
                if (targetPath.includes('admin/profile') || targetPath.includes('profile')) {
                    link.classList.add('active');
                }
            } else if (targetPath.includes(linkPath)) {
                // General matching for other menu items
                link.classList.add('active');
            }
        });
    }
    
    // Set active menu on page load
    setActiveMenuItem(currentPath);
    
    // Handle navigation clicks
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove active class from all links
            navLinks.forEach(l => l.classList.remove('active'));
            // Add active class to clicked link
            this.classList.add('active');
            
            // Store active menu in sessionStorage for consistency
            const targetPage = this.getAttribute('data-page');
            sessionStorage.setItem('activeMenu', targetPage);
        });
    });
    
    // Restore active menu from sessionStorage if available
    const storedActiveMenu = sessionStorage.getItem('activeMenu');
    if (storedActiveMenu) {
        setActiveMenuItem(storedActiveMenu);
    }
});
</script>