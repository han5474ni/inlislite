/**
 * INLISLite Admin Sidebar JavaScript
 * Handles sidebar functionality, mobile menu, and dropdown interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const sidebar = document.getElementById('adminSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    // Use the actual main content container used by layout.php
    const mainContainer = document.querySelector('.enhanced-main-content');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    // Initialize sidebar state from localStorage
    const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (sidebarCollapsed && sidebar) {
        sidebar.classList.add('collapsed');
        if (mainContainer) {
            mainContainer.classList.add('sidebar-collapsed');
        }
        if (sidebarToggle) {
            const icon = sidebarToggle.querySelector('i');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
        }
    }
    
    // Toggle sidebar collapse
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const isCollapsed = sidebar.classList.toggle('collapsed');
            
            if (mainContainer) {
                mainContainer.classList.toggle('sidebar-collapsed');
            }
            
            // Update toggle icon
            const icon = this.querySelector('i');
            if (icon) {
                if (isCollapsed) {
                    icon.className = 'bi bi-chevron-right';
                } else {
                    icon.className = 'bi bi-chevron-left';
                }
            }
            
            // Save state to localStorage
            localStorage.setItem('sidebarCollapsed', isCollapsed);
            
            console.log('Sidebar collapsed state:', isCollapsed);
            
            // Force repaint to ensure smooth transition
            sidebar.style.display = 'none';
            setTimeout(() => {
                sidebar.style.display = '';
            }, 5);
        });
    }
    }
    
    // Mobile menu toggle with debug - Bootstrap 5 compatible
    if (mobileMenuBtn) {
        console.log('🔧 Setting up mobile menu button event listener');
        mobileMenuBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default button behavior
            console.log('📱 Mobile menu button clicked in sidebar.js');
            console.log('Sidebar before toggle:', sidebar.className);
            
            if (sidebar) {
                sidebar.classList.toggle('mobile-open');
                if (sidebarOverlay) {
                    sidebarOverlay.classList.toggle('show');
                }
                document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
                
                console.log('Sidebar after toggle:', sidebar.className);
                console.log('Overlay classes:', sidebarOverlay ? sidebarOverlay.className : 'not found');
            } else {
                console.error('❌ Sidebar element not found when mobile menu button clicked');
            }
        });
    } else {
        console.log('❌ Mobile menu button not found in sidebar.js');
    }
    
    // Close mobile menu when clicking overlay
    if (sidebarOverlay) {
        console.log('🔧 Setting up overlay click listener');
        sidebarOverlay.addEventListener('click', function() {
            console.log('📱 Overlay clicked - closing mobile menu');
            sidebar.classList.remove('mobile-open');
            this.classList.remove('show');
            document.body.style.overflow = '';
        });
    } else {
        console.log('❌ Sidebar overlay not found');
    }
    
    // Handle dropdown toggles - Bootstrap 5 compatible
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('data-bs-target');
            const targetDropdown = document.querySelector(targetId);
            const icon = this.querySelector('.dropdown-arrow');
            
            if (targetDropdown) {
                console.log('Dropdown clicked:', targetId);
                console.log('Dropdown element found:', targetDropdown);
                
                // Use Bootstrap 5 collapse functionality
                const bsCollapse = new bootstrap.Collapse(targetDropdown, {
                    toggle: true
                });
                
                // Check if dropdown is showing after Bootstrap toggle
                const isShowing = targetDropdown.classList.contains('show');
                console.log('Dropdown toggled, isShowing:', isShowing);
                
                if (icon) {
                    // Rotate arrow icon based on dropdown state
                    icon.style.transform = isShowing ? 'rotate(180deg)' : 'rotate(0deg)';
                    
                    if (isShowing) {
                        console.log('Dropdown opened, using Bootstrap 5');
                    } else {
                        console.log('Dropdown closed, using Bootstrap 5');
                    }
                }
            } else {
                console.error('Dropdown element not found for target:', targetId);
            }
        });
    });
    
    // Initialize all dropdowns with Bootstrap 5
    document.querySelectorAll('.collapse').forEach(collapseEl => {
        // Create collapse instance for each dropdown
        new bootstrap.Collapse(collapseEl, {
            toggle: false
        });
    });
    
    // Auto-expand fitur menu if we're on a fitur page
    const currentPath = window.location.pathname;
    const fiturPages = ['tentang', 'fitur', 'aplikasi', 'panduan', 'dukungan', 'bimbingan', 'demo', 'patch', 'installer'];
    const isOnFiturPage = fiturPages.some(page => currentPath.includes(`/admin/${page}`));
    
    if (isOnFiturPage) {
        const fiturDropdown = document.getElementById('fiturDropdown');
        const dropdownToggle = document.querySelector('[data-bs-target="#fiturDropdown"]');
        if (fiturDropdown) {
            fiturDropdown.classList.add('show');
            if (dropdownToggle) {
                const icon = dropdownToggle.querySelector('.dropdown-arrow');
                if (icon) {
                    icon.style.transform = 'rotate(180deg)';
                }
            }
        }
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            // Desktop view
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
    
    // Add smooth scrolling to sidebar
    if (sidebar) {
        sidebar.style.scrollBehavior = 'smooth';
    }

    // Add active state management
    const navLinks = document.querySelectorAll('.nav-link, .dropdown-item');
    navLinks.forEach(link => {
        if (link.href === window.location.href) {
            link.classList.add('active');

            // If it's a dropdown item, also expand the parent dropdown
            const parentDropdown = link.closest('.collapse');
            if (parentDropdown) {
                parentDropdown.classList.add('show');
                const parentToggle = document.querySelector(`[data-bs-target="#${parentDropdown.id}"]`);
                if (parentToggle) {
                    const icon = parentToggle.querySelector('.dropdown-arrow');
                    if (icon) {
                        icon.style.transform = 'rotate(180deg)';
                    }
                }
            }
        }
    });

    // ===============================
    // Floating Edge Toggle (sticky)
    // ===============================
    try {
        // Inject minimal CSS override so collapsed sidebar doesn't slide off-screen
        const edgeStyle = document.createElement('style');
        edgeStyle.textContent = `
            /* Ensure collapsed state doesn't translate off-canvas */
            #adminSidebar.collapsed { transform: none !important; }

            /* Base styles for the edge toggle button */
            #sidebarEdgeToggle {
                position: fixed;
                top: 50%;
                transform: translate(-50%, -50%);
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: #3b82f6; /* blue */
                color: #fff;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 6px 16px rgba(0,0,0,.25);
                z-index: 1040; /* above sidebar */
                cursor: pointer;
            }
            #sidebarEdgeToggle i { font-size: 16px; line-height: 1; }
            #sidebarEdgeToggle:hover { filter: brightness(1.05); }

            /* Optional: hide on small screens when mobile menu is open */
            @media (max-width: 768px) {
                #sidebarEdgeToggle { display: none; }
            }
        `;
        document.head.appendChild(edgeStyle);

        // Inject "Neo Sidebar" look & feel (rail + panel) while keeping palette
        const neoStyle = document.createElement('style');
        neoStyle.textContent = `
            :root {
                --rail-width: 64px;
                --panel-radius: 18px;
                --panel-gap: 16px; /* margin around card */
                --panel-bg: #f7fafc; /* light panel */
                --rail-bg: #0b1e3b; /* dark rail, adjust to match palette */
                /* map to existing variables if present */
                --accent: var(--bs-primary, #2F80ED);
            }

            /* Card-like panel with inner padding to clear the rail */
            #adminSidebar {
                top: var(--panel-gap) !important;
                left: var(--panel-gap) !important;
                height: calc(100vh - (var(--panel-gap) * 2)) !important;
                width: var(--sidebar-width, 280px) !important;
                background: var(--panel-bg) !important;
                border: 0 !important;
                border-radius: var(--panel-radius) !important;
                box-shadow: 0 18px 40px rgba(2, 6, 23, 0.22) !important;
                padding: 16px 16px 16px calc(var(--rail-width) + 16px) !important;
                overflow: auto;
            }

            /* Left dark rail */
            #adminSidebar::before {
                content: '';
                position: absolute;
                left: var(--panel-gap);
                top: var(--panel-gap);
                width: var(--rail-width);
                height: calc(100vh - (var(--panel-gap) * 2));
                background: var(--rail-bg);
                border-radius: var(--panel-radius);
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.04);
                z-index: -1;
            }

            /* Header tidy */
            #adminSidebar .sidebar-header {
                padding: 8px 8px 16px 8px;
                border-bottom: none;
            }
            #adminSidebar .sidebar-logo { color: #0f172a; }
            #adminSidebar .sidebar-subtitle { color: #64748b; }

            /* Nav links with clean icon container */
            #adminSidebar .nav-link {
                color: #0f172a !important;
                border-radius: 12px !important;
                padding: 10px 12px !important;
            }
            #adminSidebar .nav-link:hover { background: rgba(2, 132, 199, 0.06) !important; }

            #adminSidebar .nav-icon {
                width: 36px; height: 36px; margin-right: 12px; text-align: center;
                display: inline-grid; place-items: center; border-radius: 12px;
                color: var(--accent);
                background: rgba(47, 128, 237, 0.08);
            }
            #adminSidebar .nav-link.active .nav-icon {
                background: var(--accent); color: #fff;
            }
            #adminSidebar .nav-link.active {
                background: rgba(47,128,237,0.10) !important;
                font-weight: 600;
            }

            /* Submenu card */
            #adminSidebar .collapse.show {
                background: #ffffff;
                border-radius: 12px;
                box-shadow: 0 8px 20px rgba(2, 6, 23, 0.08);
                padding: 8px;
                margin: 6px 0 6px 48px;
            }
            #adminSidebar .collapse .nav-link { border-radius: 10px !important; }

            /* Collapsed mode: keep only the rail */
            #adminSidebar.collapsed {
                width: var(--sidebar-collapsed-width, 96px) !important;
                padding-left: calc(var(--rail-width) + 8px) !important;
            }
            #adminSidebar.collapsed .nav-text { display: none !important; }
            #adminSidebar.collapsed .dropdown-arrow { display: none !important; }

            /* Main container margins respect new widths using existing classes */
            .main-container { margin-left: calc(var(--sidebar-width, 280px) + (var(--panel-gap) * 2)) !important; }
            .main-container.sidebar-collapsed { margin-left: calc(var(--sidebar-collapsed-width, 96px) + (var(--panel-gap) * 2)) !important; }

            /* Make scrollbar subtle */
            #adminSidebar::-webkit-scrollbar { width: 6px; }
            #adminSidebar::-webkit-scrollbar-thumb { background: rgba(2, 6, 23, 0.18); border-radius: 3px; }
        `;
        /* neoStyle injection disabled per design feedback (keep original dropdown background, avoid white contrast) */
        // document.head.appendChild(neoStyle);

        // Create the floating button if not exists
        let edgeToggle = document.getElementById('sidebarEdgeToggle');
        if (!edgeToggle) {
            edgeToggle = document.createElement('button');
            edgeToggle.id = 'sidebarEdgeToggle';
            edgeToggle.type = 'button';
            edgeToggle.setAttribute('aria-label', 'Toggle sidebar');
            edgeToggle.innerHTML = '<i class="bi bi-chevron-left"></i>';
            document.body.appendChild(edgeToggle);
        }

        // Helper to set position to stick on sidebar's right edge
        function positionEdgeToggle() {
            if (!sidebar || !edgeToggle) return;
            const rect = sidebar.getBoundingClientRect();
            // Place it at the right edge of the current sidebar width (absolute from viewport)
            const btnWidth = edgeToggle.offsetWidth || 36;
            const left = rect.right - (btnWidth / 2); // half-overlap flush with edge
            edgeToggle.style.left = left + 'px';
            edgeToggle.style.top = '50%';
        }

        // Helper to sync icon direction and main content margin
        function syncEdgeState() {
            const isCollapsed = sidebar.classList.contains('collapsed');
            const icon = edgeToggle.querySelector('i');
            if (icon) {
                icon.className = isCollapsed ? 'bi bi-chevron-right' : 'bi bi-chevron-left';
            }
            // Delay positioning until after width transition completes
            if (getComputedStyle(sidebar).transitionDuration !== '0s') {
                setTimeout(positionEdgeToggle, 160);
            } else {
                positionEdgeToggle();
            }
        }

        // Initial sync from localStorage state
        (function initEdgeFromState() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed && !sidebar.classList.contains('collapsed')) {
                sidebar.classList.add('collapsed');
                if (mainContainer) mainContainer.classList.add('sidebar-collapsed');
            }
            syncEdgeState();
        })();

        // Toggle logic on click
        edgeToggle.addEventListener('click', function (e) {
            e.preventDefault();
            const isCollapsed = sidebar.classList.toggle('collapsed');
            if (mainContainer) {
                mainContainer.classList.toggle('sidebar-collapsed', isCollapsed);
            }
            localStorage.setItem('sidebarCollapsed', isCollapsed);
            // Wait for width change then reposition
            syncEdgeState();
        });

        // Reposition on resize and after transitions
        window.addEventListener('resize', positionEdgeToggle);
        sidebar.addEventListener('transitionend', positionEdgeToggle);
        // Also adjust once after a short delay for layout settling
        setTimeout(positionEdgeToggle, 50);
    } catch (err) {
        console.warn('Edge toggle init error:', err);
    }
});

/**
 * Logout function with confirmation and animation
 */
function logout() {
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        // Add loading state
        const originalContent = logoutBtn.innerHTML;
        logoutBtn.innerHTML = '<i class="bi bi-arrow-clockwise" style="margin-right: 8px; animation: spin 1s linear infinite;"></i><span>Logging out...</span>';
        logoutBtn.style.opacity = '0.8';
        logoutBtn.disabled = true;
        
        // Add spin animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
        
        setTimeout(() => {
            if (confirm('Are you sure you want to logout?')) {
                // Proceed with logout
                window.location.href = '/admin/logout';
            } else {
                // Restore button if cancelled
                logoutBtn.innerHTML = originalContent;
                logoutBtn.style.opacity = '1';
                logoutBtn.disabled = false;
                document.head.removeChild(style);
            }
        }, 500);
    }
}

/**
 * Utility function to show notifications
 */
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = `
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    `;
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

/**
 * Initialize tooltips for collapsed sidebar
 */
function initializeTooltips() {
    if (window.bootstrap && window.bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
}