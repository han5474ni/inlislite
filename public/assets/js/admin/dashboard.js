/**
 * INLISLite v3.0 Dashboard JavaScript
 * Modern dashboard functionality with sidebar state persistence
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize dashboard components
    initializeSidebar();
    initializeMobileMenu();
    initializeCards();
    initializeAnimations();
    
    // Add smooth scrolling for better UX
    document.documentElement.style.scrollBehavior = 'smooth';
    
    // Initialize feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});

/**
 * Initialize sidebar functionality with state persistence
 */
function initializeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (!sidebar || !sidebarToggle) return;
    
    // Load saved sidebar state from localStorage
    const savedState = localStorage.getItem('inlislite_sidebar_collapsed');
    if (savedState === 'true') {
        sidebar.classList.add('collapsed');
    }
    
    // Sidebar toggle functionality
    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        
        // Save state to localStorage
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('inlislite_sidebar_collapsed', isCollapsed);
        
        // Update toggle icon based on new state
        updateToggleIcon(sidebarToggle, isCollapsed);
        
        // Trigger resize event for any charts or responsive elements
        setTimeout(() => {
            window.dispatchEvent(new Event('resize'));
        }, 300);
    });
    
    // Initialize toggle icon on page load
    const isInitiallyCollapsed = sidebar.classList.contains('collapsed');
    updateToggleIcon(sidebarToggle, isInitiallyCollapsed);
    
    // Handle keyboard navigation
    sidebarToggle.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            this.click();
        }
    });
}

/**
 * Update toggle icon based on sidebar state with enhanced UI feedback
 * @param {HTMLElement} toggleButton - The toggle button element
 * @param {boolean} isCollapsed - Whether sidebar is collapsed
 */
function updateToggleIcon(toggleButton, isCollapsed) {
    const icon = toggleButton.querySelector('i[data-feather]');
    if (icon) {
        if (isCollapsed) {
            // When collapsed (narrow), show >> to indicate "expand" action
            icon.setAttribute('data-feather', 'chevrons-right');
            toggleButton.setAttribute('title', 'Expand sidebar');
            toggleButton.setAttribute('aria-label', 'Expand sidebar');
            toggleButton.classList.add('collapsed');
        } else {
            // When expanded (wide), show << to indicate "collapse" action
            icon.setAttribute('data-feather', 'chevrons-left');
            toggleButton.setAttribute('title', 'Collapse sidebar');
            toggleButton.setAttribute('aria-label', 'Collapse sidebar');
            toggleButton.classList.remove('collapsed');
        }
        
        // Add visual feedback animation
        toggleButton.style.transform = 'scale(0.9)';
        setTimeout(() => {
            toggleButton.style.transform = 'scale(1)';
        }, 150);
        
        // Re-initialize feather icons to update the display
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }
}

/**
 * Initialize mobile menu functionality
 */
function initializeMobileMenu() {
    const sidebar = document.getElementById('sidebar');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    
    if (!sidebar || !mobileMenuBtn) return;
    
    // Mobile menu functionality
    mobileMenuBtn.addEventListener('click', function() {
        sidebar.classList.toggle('show');
        
        // Update ARIA attributes for accessibility
        const isOpen = sidebar.classList.contains('show');
        this.setAttribute('aria-expanded', isOpen);
        sidebar.setAttribute('aria-hidden', !isOpen);
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                sidebar.classList.remove('show');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                sidebar.setAttribute('aria-hidden', 'true');
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('show');
            mobileMenuBtn.setAttribute('aria-expanded', 'false');
            sidebar.setAttribute('aria-hidden', 'false');
        }
    });
    
    // Handle escape key to close mobile menu
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && window.innerWidth <= 768) {
            if (sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                sidebar.setAttribute('aria-hidden', 'true');
                mobileMenuBtn.focus();
            }
        }
    });
}

/**
 * Initialize card interactions
 */
function initializeCards() {
    const cards = document.querySelectorAll('.feature-card');
    
    cards.forEach(card => {
        card.addEventListener('click', function() {
            const title = this.querySelector('.card-title')?.textContent;
            if (title) {
                handleCardClick(title, this);
            }
        });
        
        // Add keyboard navigation
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
        
        // Make cards focusable and add ARIA attributes
        card.setAttribute('tabindex', '0');
        card.setAttribute('role', 'button');
        const cardTitle = card.querySelector('.card-title')?.textContent || 'Card';
        card.setAttribute('aria-label', `Akses ${cardTitle}`);
    });
}

/**
 * Handle card click events
 * @param {string} title - Card title
 * @param {HTMLElement} cardElement - Card DOM element
 */
function handleCardClick(title, cardElement) {
    console.log(`Clicked on: ${title}`);
    
    // Add visual feedback
    cardElement.style.transform = 'scale(0.98)';
    setTimeout(() => {
        cardElement.style.transform = '';
    }, 150);
    
    // Route to appropriate pages based on card title
    switch (title) {
        case 'Tentang InlisLite':
            navigateToPage(getBaseUrl() + 'admin/tentang');
            break;
        case 'Features & Program Modules':
            navigateToPage(getBaseUrl() + 'admin/fitur');
            break;
        case 'Installer':
            navigateToPage(getBaseUrl() + 'installer');
            break;
        case 'Patch dan Updater':
            navigateToPage(getBaseUrl() + 'admin/patch');
            break;
        case 'Aplikasi Pendukung':
            navigateToPage(getBaseUrl() + 'admin/aplikasi');
            break;
        case 'Panduan':
            navigateToPage(getBaseUrl() + 'admin/panduan');
            break;
        case 'Dukungan Teknis':
            showSupportModal();
            break;
        case 'Alat Pengembang':
            showDeveloperTools();
            break;
        case 'Demo Program':
            navigateToPage(getBaseUrl() + 'admin/demo');
            break;
        case 'Bimbingan Teknis':
            navigateToPage(getBaseUrl() + 'admin/bimbingan');
            break;
        case 'Manajemen User':
            navigateToPage(getBaseUrl() + 'admin/users');
            break;
        case 'Registrasi':
            navigateToPage(getBaseUrl() + 'admin/registration');
            break;
        default:
            console.log('No specific action defined for:', title);
    }
}

/**
 * Get base URL for navigation
 */
function getBaseUrl() {
    // Try to get base URL from meta tag or construct it
    const baseElement = document.querySelector('base');
    if (baseElement) {
        return baseElement.href;
    }
    
    // Fallback: construct from current location
    const protocol = window.location.protocol;
    const host = window.location.host;
    const pathname = window.location.pathname;
    
    // Extract base path (everything before /admin or /public)
    let basePath = '/';
    if (pathname.includes('/admin')) {
        basePath = pathname.substring(0, pathname.indexOf('/admin') + 1);
    } else if (pathname.includes('/public')) {
        basePath = pathname.substring(0, pathname.indexOf('/public') + 1);
    }
    
    return `${protocol}//${host}${basePath}`;
}

/**
 * Navigate to a specific page with proper error handling
 * @param {string} url - Target URL
 */
function navigateToPage(url) {
    try {
        // Add loading state
        showLoadingState();
        
        // Store the target URL for navigation tracking
        sessionStorage.setItem('navigationTarget', url);
        
        // Navigate after short delay for better UX
        setTimeout(() => {
            window.location.href = url;
        }, 200);
    } catch (error) {
        console.error('Navigation error:', error);
        hideLoadingState();
        showToast('Terjadi kesalahan saat navigasi', 'error');
    }
}

/**
 * Show loading state
 */
function showLoadingState() {
    // Remove existing loading overlay
    const existingOverlay = document.querySelector('.loading-overlay');
    if (existingOverlay) {
        existingOverlay.remove();
    }
    
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'loading-overlay';
    loadingOverlay.innerHTML = `
        <div class="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading...</p>
        </div>
    `;
    
    // Add loading overlay styles
    loadingOverlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        backdrop-filter: blur(5px);
    `;
    
    document.body.appendChild(loadingOverlay);
}

/**
 * Hide loading state
 */
function hideLoadingState() {
    const loadingOverlay = document.querySelector('.loading-overlay');
    if (loadingOverlay) {
        loadingOverlay.remove();
    }
}

/**
 * Show support modal - Redirect to dukungan page instead of showing popup
 */
function showSupportModal() {
    // Instead of showing popup, navigate directly to dukungan page
    navigateToPage(getBaseUrl() + 'admin/dukungan');
}

/**
 * Show developer tools modal
 */
function showDeveloperTools() {
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.innerHTML = `
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-lightning me-2"></i>
                        Alat Pengembang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-code-slash" style="font-size: 2rem; color: var(--primary-blue);"></i>
                                    <h6 class="mt-2">API Documentation</h6>
                                    <p class="text-muted small">Dokumentasi API lengkap</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-database" style="font-size: 2rem; color: var(--primary-green);"></i>
                                    <h6 class="mt-2">Database Tools</h6>
                                    <p class="text-muted small">Alat manajemen database</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-bug" style="font-size: 2rem; color: #dc3545;"></i>
                                    <h6 class="mt-2">Debug Console</h6>
                                    <p class="text-muted small">Console debugging</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-gear" style="font-size: 2rem; color: #6c757d;"></i>
                                    <h6 class="mt-2">System Config</h6>
                                    <p class="text-muted small">Konfigurasi sistem</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Initialize Bootstrap modal if available
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
        
        // Remove modal from DOM after hiding
        modal.addEventListener('hidden.bs.modal', () => {
            modal.remove();
        });
    } else {
        // Fallback: show modal without Bootstrap
        modal.style.display = 'block';
        modal.classList.add('show');
        
        // Add close functionality
        modal.querySelector('.btn-close, .btn-secondary').addEventListener('click', () => {
            modal.remove();
        });
    }
}

/**
 * Initialize animations
 */
function initializeAnimations() {
    const cards = document.querySelectorAll('.feature-card');
    
    // Only initialize if Intersection Observer is supported
    if ('IntersectionObserver' in window) {
        // Animate cards on load using Intersection Observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        cards.forEach(card => {
            observer.observe(card);
        });
    } else {
        // Fallback for browsers without Intersection Observer
        cards.forEach(card => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        });
    }
}

/**
 * Utility function to show toast notifications
 * @param {string} message - Toast message
 * @param {string} type - Toast type (success, error, warning, info)
 */
function showToast(message, type = 'info') {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    // Initialize Bootstrap toast if available
    if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
        const bootstrapToast = new bootstrap.Toast(toast);
        bootstrapToast.show();
        
        // Remove toast from DOM after hiding
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    } else {
        // Fallback: show toast without Bootstrap
        toast.style.display = 'block';
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }
}

/**
 * Create toast container if it doesn't exist
 */
function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'toast-container position-fixed top-0 end-0 p-3';
    container.style.zIndex = '9999';
    document.body.appendChild(container);
    return container;
}

/**
 * Get sidebar state
 */
function getSidebarState() {
    return localStorage.getItem('inlislite_sidebar_collapsed') === 'true';
}

/**
 * Set sidebar state
 * @param {boolean} collapsed - Whether sidebar should be collapsed
 */
function setSidebarState(collapsed) {
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        if (collapsed) {
            sidebar.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
        }
        localStorage.setItem('inlislite_sidebar_collapsed', collapsed);
    }
}

/**
 * Export functions for global access
 */
window.DashboardJS = {
    showToast,
    navigateToPage,
    showSupportModal,
    showDeveloperTools,
    getSidebarState,
    setSidebarState,
    getBaseUrl
};