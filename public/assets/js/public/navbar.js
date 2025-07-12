/**
 * Navbar JavaScript for InlisLite v3
 * Enhanced dropdown interactions and navbar behavior
 */

document.addEventListener('DOMContentLoaded', function() {
    initNavbarInteractions();
    initDropdownEnhancements();
    initScrollBehavior();
});

/**
 * Initialize navbar interactions
 */
function initNavbarInteractions() {
    const navbar = document.getElementById('mainNavbar');
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Add active state management
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Don't prevent default for dropdown toggles
            if (!this.classList.contains('dropdown-toggle')) {
                // Remove active class from all nav links
                navLinks.forEach(l => l.classList.remove('active'));
                // Add active class to clicked link
                this.classList.add('active');
            }
        });
    });
    
    // Mobile menu toggle enhancement
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navbarToggler && navbarCollapse) {
        navbarToggler.addEventListener('click', function() {
            // Add animation class
            navbarCollapse.classList.toggle('show-animated');
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navbar.contains(e.target) && navbarCollapse.classList.contains('show')) {
                navbarCollapse.classList.remove('show');
                navbarToggler.setAttribute('aria-expanded', 'false');
            }
        });
    }
}

/**
 * Initialize enhanced dropdown functionality
 */
function initDropdownEnhancements() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        const dropdownMenu = toggle.nextElementSibling;
        
        if (dropdownMenu) {
            // Add hover effects for desktop
            if (window.innerWidth > 768) {
                let hoverTimeout;
                
                // Show dropdown on hover
                toggle.parentElement.addEventListener('mouseenter', function() {
                    clearTimeout(hoverTimeout);
                    showDropdown(toggle, dropdownMenu);
                });
                
                // Hide dropdown on mouse leave with delay
                toggle.parentElement.addEventListener('mouseleave', function() {
                    hoverTimeout = setTimeout(() => {
                        hideDropdown(toggle, dropdownMenu);
                    }, 300);
                });
                
                // Keep dropdown open when hovering over menu
                dropdownMenu.addEventListener('mouseenter', function() {
                    clearTimeout(hoverTimeout);
                });
                
                dropdownMenu.addEventListener('mouseleave', function() {
                    hoverTimeout = setTimeout(() => {
                        hideDropdown(toggle, dropdownMenu);
                    }, 300);
                });
            }
            
            // Enhanced click behavior
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                const isOpen = dropdownMenu.classList.contains('show');
                
                // Close all other dropdowns
                closeAllDropdowns();
                
                if (!isOpen) {
                    showDropdown(toggle, dropdownMenu);
                } else {
                    hideDropdown(toggle, dropdownMenu);
                }
            });
            
            // Add keyboard navigation
            toggle.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggle.click();
                } else if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    showDropdown(toggle, dropdownMenu);
                    const firstItem = dropdownMenu.querySelector('.dropdown-item');
                    if (firstItem) firstItem.focus();
                }
            });
            
            // Dropdown item keyboard navigation
            const dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');
            dropdownItems.forEach((item, index) => {
                item.addEventListener('keydown', function(e) {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        const nextItem = dropdownItems[index + 1];
                        if (nextItem) nextItem.focus();
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        const prevItem = dropdownItems[index - 1];
                        if (prevItem) {
                            prevItem.focus();
                        } else {
                            toggle.focus();
                        }
                    } else if (e.key === 'Escape') {
                        hideDropdown(toggle, dropdownMenu);
                        toggle.focus();
                    }
                });
                
                // Add ripple effect on click
                item.addEventListener('click', function(e) {
                    createRippleEffect(e, this);
                    
                    // Close dropdown after click
                    setTimeout(() => {
                        hideDropdown(toggle, dropdownMenu);
                    }, 150);
                });
            });
        }
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            closeAllDropdowns();
        }
    });
    
    // Close dropdowns on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
        }
    });
}

/**
 * Show dropdown with animation
 */
function showDropdown(toggle, menu) {
    menu.classList.add('show');
    toggle.setAttribute('aria-expanded', 'true');
    
    // Add animation class
    menu.style.animation = 'dropdownFadeIn 0.2s ease-out';
}

/**
 * Hide dropdown with animation
 */
function hideDropdown(toggle, menu) {
    menu.classList.remove('show');
    toggle.setAttribute('aria-expanded', 'false');
}

/**
 * Close all dropdowns
 */
function closeAllDropdowns() {
    const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
    openDropdowns.forEach(menu => {
        const toggle = menu.previousElementSibling;
        hideDropdown(toggle, menu);
    });
}

/**
 * Initialize scroll behavior
 */
function initScrollBehavior() {
    const navbar = document.getElementById('mainNavbar');
    let lastScrollTop = 0;
    let scrollTimeout;
    
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        
        scrollTimeout = setTimeout(() => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Add/remove scrolled class
            if (scrollTop > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            // Hide/show navbar on scroll (optional)
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                // Scrolling down
                navbar.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        }, 10);
    });
}

/**
 * Create ripple effect
 */
function createRippleEffect(event, element) {
    const ripple = document.createElement('span');
    const rect = element.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    ripple.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        left: ${x}px;
        top: ${y}px;
        background: rgba(37, 99, 235, 0.3);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
        z-index: 1;
    `;
    
    // Ensure element has relative positioning
    const originalPosition = element.style.position;
    element.style.position = 'relative';
    element.style.overflow = 'hidden';
    
    element.appendChild(ripple);
    
    setTimeout(() => {
        ripple.remove();
        if (!originalPosition) {
            element.style.position = '';
        }
    }, 600);
}

/**
 * Handle responsive behavior
 */
function handleResponsiveNavbar() {
    function updateNavbarBehavior() {
        const isMobile = window.innerWidth <= 768;
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        
        dropdownToggles.forEach(toggle => {
            if (isMobile) {
                // Remove hover effects on mobile
                toggle.parentElement.removeEventListener('mouseenter', showDropdown);
                toggle.parentElement.removeEventListener('mouseleave', hideDropdown);
            }
        });
    }
    
    // Initial check
    updateNavbarBehavior();
    
    // Listen for resize events
    window.addEventListener('resize', debounce(updateNavbarBehavior, 250));
}

/**
 * Debounce function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize responsive behavior
handleResponsiveNavbar();

// Add CSS for animations if not already present
if (!document.querySelector('#navbar-animations')) {
    const style = document.createElement('style');
    style.id = 'navbar-animations';
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .navbar-collapse.show-animated {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-item {
            overflow: hidden;
        }
        
        .navbar-public {
            transition: transform 0.3s ease;
        }
    `;
    document.head.appendChild(style);
}