/**
 * INLISLite v3.0 Demo Program Page JavaScript
 * Interactive functionality for demo program page
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initializeDemoButtons();
    initializeCopyButtons();
    initializeTabSwitching();
    initializeAnimations();
    
    /**
     * Initialize demo program buttons
     */
    function initializeDemoButtons() {
        const demoButtons = document.querySelectorAll('.btn-demo');
        
        demoButtons.forEach(button => {
            button.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                
                if (url) {
                    // Add loading state
                    this.classList.add('loading');
                    this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Membuka Demo...';
                    
                    // Show confirmation alert
                    showAlert('Demo program akan dibuka di tab baru. Pastikan popup blocker tidak aktif.', 'info');
                    
                    // Open demo in new tab
                    setTimeout(() => {
                        window.open(url, '_blank', 'noopener,noreferrer');
                        
                        // Reset button state
                        this.classList.remove('loading');
                        this.innerHTML = '<i class="bi bi-play-circle me-2"></i>Demo Program';
                        
                        showAlert('Demo program berhasil dibuka di tab baru!', 'success');
                    }, 1000);
                } else {
                    showAlert('URL demo tidak tersedia.', 'warning');
                }
            });
        });
    }
    
    /**
     * Initialize copy to clipboard functionality
     */
    function initializeCopyButtons() {
        const copyButtons = document.querySelectorAll('.copy-btn');
        
        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const textToCopy = this.getAttribute('data-copy');
                
                if (textToCopy) {
                    // Use modern clipboard API if available
                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(textToCopy).then(() => {
                            showCopySuccess(this);
                        }).catch(err => {
                            console.error('Failed to copy text: ', err);
                            fallbackCopyTextToClipboard(textToCopy, this);
                        });
                    } else {
                        // Fallback for older browsers
                        fallbackCopyTextToClipboard(textToCopy, this);
                    }
                }
            });
        });
    }
    
    /**
     * Fallback copy method for older browsers
     */
    function fallbackCopyTextToClipboard(text, button) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        
        // Avoid scrolling to bottom
        textArea.style.top = '0';
        textArea.style.left = '0';
        textArea.style.position = 'fixed';
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                showCopySuccess(button);
            } else {
                showAlert('Gagal menyalin teks. Silakan salin manual.', 'warning');
            }
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
            showAlert('Gagal menyalin teks. Silakan salin manual.', 'warning');
        }
        
        document.body.removeChild(textArea);
    }
    
    /**
     * Show copy success feedback
     */
    function showCopySuccess(button) {
        const originalClass = button.className;
        const originalContent = button.innerHTML;
        
        // Add success styling
        button.classList.add('copy-success');
        button.innerHTML = '<i class="bi bi-check"></i>';
        
        // Show success message
        showAlert('Teks berhasil disalin ke clipboard!', 'success', 2000);
        
        // Reset button after 2 seconds
        setTimeout(() => {
            button.className = originalClass;
            button.innerHTML = originalContent;
        }, 2000);
    }
    
    /**
     * Initialize tab switching functionality
     */
    function initializeTabSwitching() {
        const tabButtons = document.querySelectorAll('[data-bs-toggle="pill"]');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-bs-target');
                
                // Add fade-in animation to tab content
                setTimeout(() => {
                    const targetContent = document.querySelector(targetTab);
                    if (targetContent) {
                        targetContent.classList.add('fade-in');
                        
                        // Remove animation class after animation completes
                        setTimeout(() => {
                            targetContent.classList.remove('fade-in');
                        }, 500);
                    }
                }, 150);
                
                // Track tab switching
                if (targetTab === '#atur-demo') {
                    showAlert('Fitur pengaturan demo sedang dalam pengembangan.', 'info');
                }
            });
        });
    }
    
    /**
     * Initialize scroll animations
     */
    function initializeAnimations() {
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);
        
        // Observe demo cards
        const demoCards = document.querySelectorAll('.demo-card');
        demoCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
        
        // Observe setting items
        const settingItems = document.querySelectorAll('.setting-item');
        settingItems.forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'all 0.6s ease';
            observer.observe(item);
        });
    }
    
    /**
     * Enhanced alert system with auto-dismiss and icons
     */
    function showAlert(message, type = 'info', duration = 5000) {
        const alertContainer = document.getElementById('alertContainer');
        const alertId = 'alert-' + Date.now();
        
        const alertHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert" id="${alertId}">
                <i class="bi bi-${getAlertIcon(type)} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        alertContainer.insertAdjacentHTML('beforeend', alertHTML);
        
        // Auto-dismiss
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, duration);
    }
    
    /**
     * Get appropriate icon for alert type
     */
    function getAlertIcon(type) {
        const icons = {
            success: 'check-circle-fill',
            danger: 'exclamation-triangle-fill',
            warning: 'exclamation-triangle-fill',
            info: 'info-circle-fill'
        };
        return icons[type] || 'info-circle-fill';
    }
    
    /**
     * Initialize keyboard shortcuts
     */
    function initializeKeyboardShortcuts() {
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + D to open first demo
            if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                e.preventDefault();
                const firstDemoButton = document.querySelector('.btn-demo');
                if (firstDemoButton) {
                    firstDemoButton.click();
                }
            }
            
            // Ctrl/Cmd + C to copy first username
            if ((e.ctrlKey || e.metaKey) && e.key === 'c' && e.shiftKey) {
                e.preventDefault();
                const firstCopyButton = document.querySelector('.copy-btn');
                if (firstCopyButton) {
                    firstCopyButton.click();
                }
            }
        });
    }
    
    /**
     * Initialize tooltips for better UX
     */
    function initializeTooltips() {
        // Add tooltips to demo buttons
        const tooltips = [
            { selector: '.btn-demo', title: 'Buka demo program di tab baru (Ctrl+D)' },
            { selector: '.copy-btn', title: 'Salin ke clipboard' }
        ];
        
        tooltips.forEach(tooltip => {
            document.querySelectorAll(tooltip.selector).forEach(element => {
                element.setAttribute('title', tooltip.title);
                element.setAttribute('data-bs-toggle', 'tooltip');
            });
        });
        
        // Initialize Bootstrap tooltips
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }
    
    /**
     * Handle demo card hover effects
     */
    function initializeHoverEffects() {
        const demoCards = document.querySelectorAll('.demo-card');
        
        demoCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.classList.add('pulse');
            });
            
            card.addEventListener('mouseleave', function() {
                this.classList.remove('pulse');
            });
        });
    }
    
    /**
     * Initialize demo statistics (if needed)
     */
    function initializeDemoStats() {
        // This could be used to track demo usage statistics
        const demoButtons = document.querySelectorAll('.btn-demo');
        
        demoButtons.forEach((button, index) => {
            button.addEventListener('click', function() {
                // Track demo access
                console.log(`Demo ${index + 1} accessed at ${new Date().toISOString()}`);
                
                // Could send analytics data here
                // trackDemoAccess(index + 1);
            });
        });
    }
    
    /**
     * Initialize responsive behavior
     */
    function initializeResponsiveBehavior() {
        function handleResize() {
            const width = window.innerWidth;
            const demoCards = document.querySelectorAll('.demo-card');
            
            if (width < 768) {
                // Mobile optimizations
                demoCards.forEach(card => {
                    card.classList.add('mobile-optimized');
                });
            } else {
                // Desktop optimizations
                demoCards.forEach(card => {
                    card.classList.remove('mobile-optimized');
                });
            }
        }
        
        // Initial check
        handleResize();
        
        // Listen for resize events
        window.addEventListener('resize', handleResize);
    }
    
    // Initialize additional features
    initializeKeyboardShortcuts();
    initializeTooltips();
    initializeHoverEffects();
    initializeDemoStats();
    initializeResponsiveBehavior();
    
    console.log('Demo Program INLISLite v3.0 - Interactive functionality loaded successfully');
});