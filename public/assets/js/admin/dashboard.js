/**
 * INLISLite Admin Dashboard JavaScript v3.0
 * Modern, clean admin interface functionality
 * Optimized for performance and accessibility
 */

document.addEventListener('DOMContentLoaded', function() {
    // Skip sidebar initialization if enhanced sidebar is already handling it
    if (window.ENHANCED_SIDEBAR_INLINE) {
        console.log('Enhanced sidebar detected, skipping dashboard sidebar initialization');
    }
    
    // Enhanced submenu functionality with Bootstrap 5 collapse
    const handleSubmenus = () => {
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-bs-target');
                const submenu = document.querySelector(targetId);
                
                if (submenu) {
                    const bsCollapse = new bootstrap.Collapse(submenu, {
                        toggle: true
                    });
                    
                    // Update toggle state
                    this.classList.toggle('expanded');
                }
            });
        });
    };
    
    // Auto-hide alerts
    const initializeAlerts = () => {
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert?.close();
            }, 5000);
        });
    };
    
    // Loading states for forms
    const initializeFormHandlers = () => {
        const submitButtons = document.querySelectorAll('button[type="submit"], .btn-submit');
        submitButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (this.form?.checkValidity()) {
                    this.innerHTML = '<span class="spinner me-2"></span>Loading...';
                    this.disabled = true;
                }
            });
        });
        
        // Confirm delete actions
        const deleteButtons = document.querySelectorAll('.btn-delete, [data-action="delete"]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    };
    
    // Make tables responsive
    const initializeTables = () => {
        const tables = document.querySelectorAll('.table:not(.table-responsive .table)');
        tables.forEach(table => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('table-responsive');
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        });
    };
    
    // Keyboard shortcuts
    const initializeKeyboardShortcuts = () => {
        document.addEventListener('keydown', function(e) {
            // Alt + S to toggle sidebar
            if (e.altKey && e.key === 's') {
                e.preventDefault();
                sidebarToggle?.click();
            }
            
            // Escape to close mobile sidebar
            if (e.key === 'Escape' && adminSidebar?.classList.contains('mobile-show')) {
                sidebarOverlay?.click();
            }
        });
    };
    
    // Initialize all functionality (skip sidebar if enhanced sidebar is active)
    if (!window.ENHANCED_SIDEBAR_INLINE) {
        initializeSidebar();
    }
    handleSubmenus();
    initializeAlerts();
    initializeFormHandlers();
    initializeTables();
    initializeKeyboardShortcuts();
    
    // Add fade-in animation to main content
    mainContent?.classList.add('fade-in');
});