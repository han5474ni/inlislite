/**
 * Enhanced Admin Sidebar JavaScript
 * Handles dropdown functionality, mobile toggle, and navigation
 */

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('enhancedSidebar');
    const mobileToggle = document.getElementById('enhancedMobileToggle');
    const sidebarOverlay = document.getElementById('enhancedSidebarOverlay');
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    // Mobile toggle functionality
    function toggleSidebar() {
        if (sidebar) {
            sidebar.classList.toggle('mobile-open');
        }
        if (sidebarOverlay) {
            sidebarOverlay.classList.toggle('active');
        }
    }

    if (mobileToggle) {
        mobileToggle.addEventListener('click', toggleSidebar);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', toggleSidebar);
    }

    // Dropdown toggle functionality
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const dropdownId = this.getAttribute('data-dropdown');
            const submenu = document.getElementById(dropdownId);
            
            if (!submenu) return;
            
            const isExpanded = submenu.classList.contains('expanded');
            
            // Close all other dropdowns (accordion style)
            dropdownToggles.forEach(otherToggle => {
                if (otherToggle !== this) {
                    const otherDropdownId = otherToggle.getAttribute('data-dropdown');
                    const otherSubmenu = document.getElementById(otherDropdownId);
                    if (otherSubmenu) {
                        otherSubmenu.classList.remove('expanded');
                        otherToggle.classList.remove('expanded');
                    }
                }
            });
            
            // Toggle current dropdown
            if (isExpanded) {
                submenu.classList.remove('expanded');
                this.classList.remove('expanded');
            } else {
                submenu.classList.add('expanded');
                this.classList.add('expanded');
            }
        });
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            if (sidebar) {
                sidebar.classList.remove('mobile-open');
            }
            if (sidebarOverlay) {
                sidebarOverlay.classList.remove('active');
            }
        }
    });

    // Auto-expand appropriate dropdowns based on current page
    const currentPath = window.location.pathname;
    
    // Auto-expand Fitur dropdown if current page is a fitur page
    if (currentPath.includes('/fitur/') || currentPath.includes('/tentang')) {
        const fiturDropdown = document.querySelector('[data-dropdown="dropdown-1"]');
        const fiturSubmenu = document.getElementById('dropdown-1');
        if (fiturDropdown && fiturSubmenu) {
            fiturSubmenu.classList.add('expanded');
            fiturDropdown.classList.add('expanded');
        }
    }

    // Handle keyboard navigation
    document.addEventListener('keydown', function(e) {
        // Close sidebar with Escape key on mobile
        if (e.key === 'Escape' && window.innerWidth <= 768) {
            if (sidebar && sidebar.classList.contains('mobile-open')) {
                toggleSidebar();
            }
        }
    });

    // Add focus management for accessibility
    const focusableElements = sidebar ? sidebar.querySelectorAll(
        'a[href], button, [tabindex]:not([tabindex="-1"])'
    ) : [];

    if (focusableElements.length > 0) {
        // Trap focus within sidebar when open on mobile
        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];

        sidebar.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        e.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        e.preventDefault();
                        firstFocusable.focus();
                    }
                }
            }
        });
    }

    // Add ripple effect to nav links
    const navLinks = document.querySelectorAll('.enhanced-sidebar .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Initialize tooltips if needed
    initializeTooltips();

    console.log('Enhanced sidebar initialized successfully');
});

// Tooltip initialization function
function initializeTooltips() {
    const navItems = document.querySelectorAll('.enhanced-sidebar .nav-item');
    
    navItems.forEach(item => {
        const link = item.querySelector('.nav-link');
        const text = item.querySelector('.nav-text');
        
        if (link && text && !item.querySelector('.nav-tooltip')) {
            const tooltip = document.createElement('div');
            tooltip.className = 'nav-tooltip';
            tooltip.textContent = text.textContent;
            item.appendChild(tooltip);
        }
    });
}

// Add CSS for ripple effect
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(2);
        opacity: 0;
    }
}

.nav-link {
    position: relative;
    overflow: hidden;
}
`;
document.head.appendChild(rippleStyle);
