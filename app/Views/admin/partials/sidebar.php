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
    log_message('debug', 'Sidebar - Current Path: ' . $currentPath);
    log_message('debug', 'Sidebar - Current Segments: ' . implode('/', $currentSegments));
}

// Define menu items with their routes and icons
$menuItems = [
    [
        'title' => 'Dashboard',
        'icon' => 'home',
        'url' => 'admin/dashboard',
        'active_patterns' => ['admin/dashboard', 'admin$', 'dashboard']
    ],
    [
        'title' => 'Manajemen User',
        'icon' => 'users',
        'url' => 'admin/users',
        'active_patterns' => ['admin/users', 'admin/user_management', 'usermanagement', 'user-management', 'user_management']
    ],
    [
        'title' => 'Registrasi',
        'icon' => 'book',
        'url' => 'admin/registration',
        'active_patterns' => ['admin/registration', 'registration']
    ],
    [
        'title' => 'Profile',
        'icon' => 'user',
        'url' => 'admin/profile',
        'active_patterns' => ['admin/profile', 'profile']
    ],
    [
        'title' => 'Database Replication',
        'icon' => 'database',
        'url' => 'admin/replication',
        'active_patterns' => ['admin/replication', 'replication']
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
?>

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
        <?php foreach ($menuItems as $item): ?>
            <?php 
            $isActive = isMenuActive($item['active_patterns'], $currentPath);
            // Debug output for development
            if (ENVIRONMENT === 'development') {
                echo "<!-- Debug: {$item['title']} - Current Path: $currentPath, Is Active: " . ($isActive ? 'true' : 'false') . " -->";
            }
            ?>
            <div class="nav-item">
                <a href="<?= base_url($item['url']) ?>" 
                   class="nav-link <?= $isActive ? 'active' : '' ?>" 
                   data-page="<?= $item['url'] ?>" 
                   data-patterns="<?= implode(',', $item['active_patterns']) ?>"
                   data-title="<?= $item['title'] ?>">
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
/* Enhanced Sidebar Styles */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 280px;
    background: linear-gradient(135deg, #2DA84D 0%, #0B8F1C 100%);
    color: white;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.sidebar.collapsed {
    width: 70px;
}

.sidebar-header {
    padding: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 80px;
}

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    color: white;
    transition: all 0.3s ease;
}

.sidebar-logo:hover {
    color: white;
    transform: scale(1.02);
}

.sidebar-logo-icon {
    flex-shrink: 0;
}

.sidebar-title {
    font-weight: 600;
    font-size: 1rem;
    line-height: 1.2;
    white-space: nowrap;
    opacity: 1;
    transition: opacity 0.3s ease;
}

.sidebar.collapsed .sidebar-title {
    opacity: 0;
    width: 0;
    overflow: hidden;
}

.sidebar-toggle {
    background: none;
    border: none;
    color: white;
    padding: 0.5rem;
    border-radius: 0.25rem;
    transition: all 0.3s ease;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sidebar-toggle:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: scale(1.1);
}

.sidebar-nav {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 80px);
    overflow-y: auto;
    overflow-x: hidden;
    padding: 1rem 0;
}

.nav-item {
    position: relative;
    margin: 0.25rem 0;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
    border-radius: 0;
    margin: 0 0.5rem;
    border-radius: 0.5rem;
    position: relative;
    overflow: hidden;
}

.nav-link:hover {
    color: white;
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
}

.nav-link.active {
    color: white;
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.nav-link.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: white;
    border-radius: 0 2px 2px 0;
}

.nav-icon {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    transition: transform 0.3s ease;
}

.nav-link:hover .nav-icon {
    transform: scale(1.1);
}

.nav-text {
    white-space: nowrap;
    opacity: 1;
    transition: opacity 0.3s ease;
    font-weight: 500;
}

.sidebar.collapsed .nav-text {
    opacity: 0;
    width: 0;
    overflow: hidden;
}

.nav-tooltip {
    position: absolute;
    left: 70px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.5rem 0.75rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1001;
    pointer-events: none;
}

.sidebar.collapsed .nav-item:hover .nav-tooltip {
    opacity: 1;
    visibility: visible;
}

/* Logout button styling */
.logout-item {
    margin-top: auto;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 1rem;
}

.logout-link {
    background: transparent !important;
    color: rgba(255, 255, 255, 0.8) !important;
    transition: all 0.3s ease;
    font-weight: 400;
    margin: 0 0.5rem !important;
    border-radius: 0.5rem !important;
}

.logout-link:hover {
    background: rgba(255, 255, 255, 0.1) !important;
    color: white !important;
    transform: translateX(5px) !important;
}

.logout-link:hover .nav-icon {
    transform: translateX(3px) scale(1.1);
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        width: 280px;
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
    
    .sidebar.collapsed {
        width: 280px;
    }
}

/* Scrollbar styling */
.sidebar-nav::-webkit-scrollbar {
    width: 4px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style>

<script>
// Enhanced sidebar navigation with proper error handling
document.addEventListener('DOMContentLoaded', function() {
    initializeSidebarNavigation();
});

function initializeSidebarNavigation() {
    const navLinks = document.querySelectorAll('.nav-link:not(.logout-link)');
    const currentPath = window.location.pathname;
    
    console.log('Initializing sidebar navigation for path:', currentPath);
    
    // Function to set active menu item
    function setActiveMenuItem(targetPath) {
        // Remove active class from all links
        navLinks.forEach(link => {
            link.classList.remove('active');
        });
        
        // Find and activate the correct menu item
        let activeFound = false;
        
        navLinks.forEach(link => {
            const linkPath = link.getAttribute('data-page');
            const patterns = link.getAttribute('data-patterns');
            const title = link.getAttribute('data-title');
            
            if (!linkPath || !patterns) return;
            
            const patternArray = patterns.split(',');
            
            // Check if any pattern matches the current path
            const isMatch = patternArray.some(pattern => {
                const normalizedPattern = pattern.trim().replace(/^\/+|\/+$/g, '');
                const normalizedPath = targetPath.replace(/^\/+|\/+$/g, '');
                
                // Exact match
                if (normalizedPath === normalizedPattern) {
                    return true;
                }
                
                // Path starts with pattern
                if (normalizedPath.startsWith(normalizedPattern + '/') || 
                    normalizedPath.startsWith(normalizedPattern)) {
                    return true;
                }
                
                // Special cases
                if (normalizedPattern === 'admin' && normalizedPath === 'admin') {
                    return true;
                }
                
                return false;
            });
            
            if (isMatch && !activeFound) {
                link.classList.add('active');
                activeFound = true;
                console.log(`Activated menu: ${title} for path: ${targetPath}`);
                
                // Store active menu in sessionStorage
                sessionStorage.setItem('activeMenu', linkPath);
            }
        });
        
        // If no match found, try to activate dashboard for admin root
        if (!activeFound && (targetPath === '/admin' || targetPath === '/admin/')) {
            const dashboardLink = document.querySelector('[data-page="admin/dashboard"]');
            if (dashboardLink) {
                dashboardLink.classList.add('active');
                sessionStorage.setItem('activeMenu', 'admin/dashboard');
                console.log('Activated dashboard as fallback');
            }
        }
    }
    
    // Set active menu on page load
    setActiveMenuItem(currentPath);
    
    // Handle navigation clicks
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Don't prevent default - let the navigation happen
            
            // Remove active class from all links
            navLinks.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Store active menu in sessionStorage
            const targetPage = this.getAttribute('data-page');
            if (targetPage) {
                sessionStorage.setItem('activeMenu', targetPage);
                console.log('Stored active menu:', targetPage);
            }
        });
    });
    
    // Restore active menu from sessionStorage if available and no active menu found
    const storedActiveMenu = sessionStorage.getItem('activeMenu');
    if (storedActiveMenu && !document.querySelector('.nav-link.active')) {
        const storedLink = document.querySelector(`[data-page="${storedActiveMenu}"]`);
        if (storedLink) {
            storedLink.classList.add('active');
            console.log('Restored active menu from storage:', storedActiveMenu);
        }
    }
}

// Logout confirmation function
function confirmLogout() {
    return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
}

// Initialize feather icons when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});
</script>