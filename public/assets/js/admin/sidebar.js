/**
 * New Sidebar Component JavaScript
 * Handles collapse/expand functionality, localStorage persistence, and responsive behavior
 */

class NewSidebarManager {
    constructor() {
        this.sidebar = document.getElementById('sidebar-new');
        this.collapseBtn = document.getElementById('collapse-btn');
        this.mobileToggleBtn = document.getElementById('mobile-toggle-btn');
        this.mobileCloseBtn = document.getElementById('mobile-close-btn');
        this.overlay = document.getElementById('sidebar-overlay-new');
        this.body = document.body;
        
        this.isCollapsed = false;
        this.isMobile = window.innerWidth < 768;
        
        // Debug logging
        console.log('🚀 NewSidebarManager: Initializing...', {
            sidebar: !!this.sidebar,
            collapseBtn: !!this.collapseBtn,
            mobileToggleBtn: !!this.mobileToggleBtn,
            isMobile: this.isMobile
        });
        
        this.init();
    }

    /**
     * Initialize the sidebar functionality
     */
    init() {
        this.setupEventListeners();
        this.restoreState();
        this.handleResize();
        this.addKeyboardShortcuts();
        
        console.log('🚀 New Sidebar Manager initialized');
    }

    /**
     * Setup all event listeners
     */
    setupEventListeners() {
        // Desktop collapse button
        if (this.collapseBtn) {
            this.collapseBtn.addEventListener('click', (e) => {
                e.preventDefault();
                console.log('🖱️ Collapse button clicked');
                this.toggleCollapse();
            });
            console.log('✅ Collapse button event listener added');
        } else {
            console.warn('⚠️ Collapse button not found!');
        }

        // Mobile toggle button
        if (this.mobileToggleBtn) {
            this.mobileToggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleMobile();
            });
        }

        // Mobile close button
        if (this.mobileCloseBtn) {
            this.mobileCloseBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.closeMobile();
            });
        }

        // Overlay click
        if (this.overlay) {
            this.overlay.addEventListener('click', () => {
                this.closeMobile();
            });
        }

        // Window resize
        window.addEventListener('resize', () => {
            this.handleResize();
        });

        // Navigation link clicks for mobile
        const navLinks = document.querySelectorAll('.sidebar-new .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (this.isMobile) {
                    // Small delay to see the click effect before closing
                    setTimeout(() => {
                        this.closeMobile();
                    }, 150);
                }
            });
        });
    }

    /**
     * Toggle collapse state (desktop only)
     */
    toggleCollapse() {
        if (this.isMobile) return;

        this.isCollapsed = !this.isCollapsed;
        
        if (this.isCollapsed) {
            this.body.classList.add('sidebar-collapsed');
            console.log('✅ Added sidebar-collapsed class to body');
        } else {
            this.body.classList.remove('sidebar-collapsed');
            console.log('✅ Removed sidebar-collapsed class from body');
        }

        // Debug: log current body classes
        console.log('📋 Current body classes:', this.body.className);

        // Save state to localStorage
        this.saveState();
        
        // Trigger custom event
        this.dispatchEvent('sidebar:toggle', { collapsed: this.isCollapsed });
        
        console.log(`📱 Sidebar ${this.isCollapsed ? 'collapsed' : 'expanded'}`);
        
        // Debug: check if logo is visible after a delay
        setTimeout(() => {
            const logoImage = document.querySelector('.sidebar-new .logo-image');
            if (logoImage) {
                const computedStyle = window.getComputedStyle(logoImage);
                console.log('🔍 Logo visibility debug:', {
                    display: computedStyle.display,
                    visibility: computedStyle.visibility,
                    opacity: computedStyle.opacity,
                    width: computedStyle.width,
                    height: computedStyle.height
                });
            }
        }, 100);
    }

    /**
     * Toggle mobile sidebar
     */
    toggleMobile() {
        if (!this.isMobile) return;

        const isOpen = this.body.classList.contains('sidebar-mobile-open');
        
        if (isOpen) {
            this.closeMobile();
        } else {
            this.openMobile();
        }
    }

    /**
     * Open mobile sidebar
     */
    openMobile() {
        if (!this.isMobile) return;

        this.body.classList.add('sidebar-mobile-open');
        this.body.style.overflow = 'hidden'; // Prevent body scroll
        
        // Focus trap for accessibility
        this.trapFocus();
        
        this.dispatchEvent('sidebar:mobile:open');
        console.log('📱 Mobile sidebar opened');
    }

    /**
     * Close mobile sidebar
     */
    closeMobile() {
        if (!this.isMobile) return;

        this.body.classList.remove('sidebar-mobile-open');
        this.body.style.overflow = ''; // Restore body scroll
        
        this.dispatchEvent('sidebar:mobile:close');
        console.log('📱 Mobile sidebar closed');
    }

    /**
     * Handle window resize
     */
    handleResize() {
        const wasMobile = this.isMobile;
        this.isMobile = window.innerWidth < 768;
        
        if (wasMobile !== this.isMobile) {
            // Screen size changed between mobile/desktop
            if (this.isMobile) {
                // Switched to mobile
                this.body.classList.remove('sidebar-collapsed');
                this.body.classList.remove('sidebar-mobile-open');
                this.body.style.overflow = '';
            } else {
                // Switched to desktop
                this.body.classList.remove('sidebar-mobile-open');
                this.body.style.overflow = '';
                this.restoreState(); // Restore desktop collapse state
            }
        }
    }

    /**
     * Add keyboard shortcuts
     */
    addKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + B to toggle sidebar
            if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                e.preventDefault();
                if (this.isMobile) {
                    this.toggleMobile();
                } else {
                    this.toggleCollapse();
                }
            }

            // Escape to close mobile sidebar
            if (e.key === 'Escape' && this.isMobile) {
                this.closeMobile();
            }
        });
    }

    /**
     * Save state to localStorage
     */
    saveState() {
        try {
            localStorage.setItem('sidebar-collapsed', this.isCollapsed.toString());
            localStorage.setItem('sidebar-state-timestamp', Date.now().toString());
        } catch (error) {
            console.warn('⚠️ Could not save sidebar state to localStorage:', error);
        }
    }

    /**
     * Restore state from localStorage
     */
    restoreState() {
        if (this.isMobile) return; // Don't restore state on mobile

        try {
            const saved = localStorage.getItem('sidebar-collapsed');
            const timestamp = localStorage.getItem('sidebar-state-timestamp');
            
            // Only restore if saved within last 30 days
            const thirtyDays = 30 * 24 * 60 * 60 * 1000;
            const isRecent = timestamp && (Date.now() - parseInt(timestamp)) < thirtyDays;
            
            if (saved && isRecent) {
                this.isCollapsed = saved === 'true';
                
                if (this.isCollapsed) {
                    this.body.classList.add('sidebar-collapsed');
                } else {
                    this.body.classList.remove('sidebar-collapsed');
                }
                
                console.log(`🔄 Sidebar state restored: ${this.isCollapsed ? 'collapsed' : 'expanded'}`);
            }
        } catch (error) {
            console.warn('⚠️ Could not restore sidebar state from localStorage:', error);
        }
    }

    /**
     * Trap focus for mobile accessibility
     */
    trapFocus() {
        if (!this.sidebar) return;

        const focusableElements = this.sidebar.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        if (firstElement) {
            firstElement.focus();
        }

        const handleTabKey = (e) => {
            if (e.key !== 'Tab') return;

            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else {
                if (document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        };

        document.addEventListener('keydown', handleTabKey);

        // Remove listener when sidebar closes
        const removeListener = () => {
            document.removeEventListener('keydown', handleTabKey);
        };

        // Auto-remove listener after 10 seconds or when sidebar closes
        setTimeout(removeListener, 10000);
        this.sidebar.addEventListener('sidebar:mobile:close', removeListener, { once: true });
    }

    /**
     * Dispatch custom events
     */
    dispatchEvent(eventName, detail = {}) {
        const event = new CustomEvent(eventName, {
            detail: {
                ...detail,
                timestamp: Date.now(),
                isMobile: this.isMobile,
                isCollapsed: this.isCollapsed
            }
        });
        
        document.dispatchEvent(event);
        
        if (this.sidebar) {
            this.sidebar.dispatchEvent(event);
        }
    }

    /**
     * Public API methods
     */
    
    /**
     * Programmatically collapse sidebar
     */
    collapse() {
        if (!this.isCollapsed && !this.isMobile) {
            this.toggleCollapse();
        }
    }

    /**
     * Programmatically expand sidebar
     */
    expand() {
        if (this.isCollapsed && !this.isMobile) {
            this.toggleCollapse();
        }
    }

    /**
     * Get current state
     */
    getState() {
        return {
            isCollapsed: this.isCollapsed,
            isMobile: this.isMobile,
            isOpen: this.body.classList.contains('sidebar-mobile-open')
        };
    }

    /**
     * Destroy the sidebar manager
     */
    destroy() {
        // Remove event listeners
        if (this.collapseBtn) {
            this.collapseBtn.removeEventListener('click', this.toggleCollapse);
        }
        
        // Clear localStorage
        try {
            localStorage.removeItem('sidebar-collapsed');
            localStorage.removeItem('sidebar-state-timestamp');
        } catch (error) {
            console.warn('⚠️ Could not clear sidebar localStorage:', error);
        }
        
        console.log('🗑️ Sidebar manager destroyed');
    }
}

// Auto-initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Check if sidebar exists
    if (document.getElementById('sidebar-new')) {
        window.newSidebarManager = new NewSidebarManager();
        
        // Debug mode
        if (localStorage.getItem('sidebar-debug') === 'true') {
            console.log('🐛 Sidebar Debug Mode Enabled');
            
            // Add debug buttons
            const debugPanel = document.createElement('div');
            debugPanel.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: rgba(0,0,0,0.8);
                color: white;
                padding: 10px;
                border-radius: 8px;
                font-size: 12px;
                z-index: 9999;
            `;
            debugPanel.innerHTML = `
                <div>Sidebar Debug</div>
                <button onclick="window.newSidebarManager.collapse()">Collapse</button>
                <button onclick="window.newSidebarManager.expand()">Expand</button>
                <button onclick="console.log(window.newSidebarManager.getState())">Log State</button>
            `;
            document.body.appendChild(debugPanel);
        }
    }
});

// Export for external use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = NewSidebarManager;
}
