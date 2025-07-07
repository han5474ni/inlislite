/*
 * INLISLite v3.0 Public JavaScript - Modern Functionality
 * Clean, responsive, and interactive public interface
 * Synchronized with admin UI functionality
 */

(function() {
    'use strict';

    // Global variables
    let isLoading = false;
    let toastContainer = null;

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 INLISLite v3.0 Public Interface Initializing...');
        
        initializeNavigation();
        initializeAnimations();
        initializeToasts();
        initializeForms();
        initializeUtilities();
        
        console.log('✅ INLISLite v3.0 Public Interface Ready');
    });

    /**
     * Initialize navigation functionality
     */
    function initializeNavigation() {
        const navbar = document.getElementById('mainNavbar');
        if (!navbar) return;

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 100; // Account for fixed navbar
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Mobile menu handling
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');
        
        if (navbarToggler && navbarCollapse) {
            // Close mobile menu when clicking on a link
            document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (navbarCollapse.classList.contains('show')) {
                        navbarToggler.click();
                    }
                });
            });
        }
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

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements with animation class
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });

        // Counter animation for statistics
        initializeCounters();

        // Back to top button
        createBackToTopButton();
    }

    /**
     * Initialize counter animations
     */
    function initializeCounters() {
        const counters = document.querySelectorAll('.stat-number');
        if (counters.length === 0) return;

        const animateCounters = () => {
            const speed = 200;
            
            counters.forEach(counter => {
                const updateCount = () => {
                    const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
                    const count = parseInt(counter.getAttribute('data-count') || 0);
                    const increment = target / speed;
                    
                    if (count < target) {
                        counter.setAttribute('data-count', Math.ceil(count + increment));
                        const suffix = counter.textContent.replace(/[\d]/g, '');
                        counter.textContent = Math.ceil(count + increment) + suffix;
                        setTimeout(updateCount, 1);
                    } else {
                        counter.textContent = counter.textContent;
                    }
                };
                updateCount();
            });
        };

        // Trigger counter animation when stats section is visible
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    statsObserver.unobserve(entry.target);
                }
            });
        });

        const statsSection = document.querySelector('.stat-item');
        if (statsSection) {
            statsObserver.observe(statsSection.closest('section') || statsSection);
        }
    }

    /**
     * Create back to top button
     */
    function createBackToTopButton() {
        const backToTopBtn = document.createElement('button');
        backToTopBtn.innerHTML = '<i class="bi bi-arrow-up"></i>';
        backToTopBtn.className = 'btn btn-primary-gradient position-fixed';
        backToTopBtn.style.cssText = `
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        `;

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        backToTopBtn.addEventListener('mouseenter', () => {
            backToTopBtn.style.transform = 'scale(1.1)';
        });

        backToTopBtn.addEventListener('mouseleave', () => {
            backToTopBtn.style.transform = 'scale(1)';
        });

        document.body.appendChild(backToTopBtn);

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.style.display = 'block';
                setTimeout(() => {
                    backToTopBtn.style.opacity = '1';
                }, 10);
            } else {
                backToTopBtn.style.opacity = '0';
                setTimeout(() => {
                    backToTopBtn.style.display = 'none';
                }, 300);
            }
        });
    }

    /**
     * Initialize toast notifications
     */
    function initializeToasts() {
        createToastContainer();
    }

    /**
     * Create toast container
     */
    function createToastContainer() {
        if (toastContainer) return toastContainer;
        
        toastContainer = document.createElement('div');
        toastContainer.id = 'toastContainer';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '1055';
        document.body.appendChild(toastContainer);
        return toastContainer;
    }

    /**
     * Show toast notification
     */
    function showToast(message, type = 'info', duration = 5000) {
        const container = toastContainer || createToastContainer();
        
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        const toastId = 'toast_' + Date.now();
        toast.id = toastId;
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-${getToastIcon(type)} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        container.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast, {
            delay: duration
        });
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });

        return toast;
    }

    /**
     * Get appropriate icon for toast type
     */
    function getToastIcon(type) {
        const icons = {
            'success': 'check-circle',
            'error': 'exclamation-triangle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle',
            'primary': 'info-circle',
            'secondary': 'info-circle',
            'danger': 'exclamation-triangle'
        };
        return icons[type] || 'info-circle';
    }

    /**
     * Initialize form functionality
     */
    function initializeForms() {
        // Bootstrap form validation
        const forms = document.querySelectorAll('.needs-validation');
        
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    
                    // Focus on first invalid field
                    const firstInvalid = form.querySelector(':invalid');
                    if (firstInvalid) {
                        firstInvalid.focus();
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
                form.classList.add('was-validated');
            }, false);
        });

        // Real-time validation
        document.querySelectorAll('.form-control, .form-select').forEach(field => {
            field.addEventListener('blur', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });

            field.addEventListener('input', function() {
                if (this.classList.contains('was-validated') || this.classList.contains('is-invalid')) {
                    if (this.checkValidity()) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    }
                }
            });
        });

        // File input styling
        document.querySelectorAll('input[type="file"]').forEach(fileInput => {
            fileInput.addEventListener('change', function() {
                const fileName = this.files[0]?.name || 'No file chosen';
                const label = this.nextElementSibling;
                if (label && label.classList.contains('form-text')) {
                    label.textContent = fileName;
                }
            });
        });
    }

    /**
     * Initialize utility functions
     */
    function initializeUtilities() {
        // Copy to clipboard functionality
        initializeClipboard();
        
        // Loading states
        initializeLoadingStates();
        
        // Tooltips and popovers
        initializeBootstrapComponents();
        
        // External link handling
        initializeExternalLinks();
    }

    /**
     * Initialize clipboard functionality
     */
    function initializeClipboard() {
        document.addEventListener('click', function(e) {
            if (e.target.matches('.copy-btn') || e.target.closest('.copy-btn')) {
                const button = e.target.matches('.copy-btn') ? e.target : e.target.closest('.copy-btn');
                const textToCopy = button.getAttribute('data-copy');
                
                if (textToCopy) {
                    copyToClipboard(textToCopy, button);
                }
            }
        });
    }

    /**
     * Copy text to clipboard
     */
    function copyToClipboard(text, button = null) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                showCopySuccess(button, text);
            }).catch(() => {
                fallbackCopyToClipboard(text, button);
            });
        } else {
            fallbackCopyToClipboard(text, button);
        }
    }

    /**
     * Fallback copy to clipboard for older browsers
     */
    function fallbackCopyToClipboard(text, button = null) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            showCopySuccess(button, text);
        } catch (err) {
            showToast('Failed to copy text', 'error');
        }
        
        document.body.removeChild(textArea);
    }

    /**
     * Show copy success feedback
     */
    function showCopySuccess(button, text) {
        if (button) {
            const originalIcon = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check"></i>';
            button.classList.add('btn-success');
            button.classList.remove('btn-outline-secondary');
            
            setTimeout(() => {
                button.innerHTML = originalIcon;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-secondary');
            }, 1000);
        }
        
        showToast(`${text} copied to clipboard!`, 'success', 2000);
    }

    /**
     * Initialize loading states
     */
    function initializeLoadingStates() {
        // Global loading indicator
        window.showLoading = function() {
            if (isLoading) return;
            
            isLoading = true;
            const loading = document.createElement('div');
            loading.id = 'globalLoading';
            loading.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
            loading.style.cssText = 'background: rgba(255,255,255,0.9); z-index: 9999; backdrop-filter: blur(5px);';
            loading.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="mt-3 fw-bold">Loading...</div>
                </div>
            `;
            document.body.appendChild(loading);
        };

        window.hideLoading = function() {
            isLoading = false;
            const loading = document.getElementById('globalLoading');
            if (loading) {
                loading.style.opacity = '0';
                setTimeout(() => {
                    loading.remove();
                }, 300);
            }
        };
    }

    /**
     * Initialize Bootstrap components
     */
    function initializeBootstrapComponents() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize popovers
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    }

    /**
     * Initialize external link handling
     */
    function initializeExternalLinks() {
        document.querySelectorAll('a[href^="http"]').forEach(link => {
            if (!link.hostname.includes(window.location.hostname)) {
                link.setAttribute('target', '_blank');
                link.setAttribute('rel', 'noopener noreferrer');
                
                // Add external link icon
                if (!link.querySelector('.bi-box-arrow-up-right')) {
                    link.innerHTML += ' <i class="bi bi-box-arrow-up-right ms-1"></i>';
                }
            }
        });
    }

    /**
     * Debounce function for performance optimization
     */
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    /**
     * Throttle function for performance optimization
     */
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    /**
     * Format date for display
     */
    function formatDate(dateString, format = 'dd/mm/yyyy') {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        
        switch (format) {
            case 'dd/mm/yyyy':
                return `${day}/${month}/${year}`;
            case 'mm/dd/yyyy':
                return `${month}/${day}/${year}`;
            case 'yyyy-mm-dd':
                return `${year}-${month}-${day}`;
            default:
                return date.toLocaleDateString();
        }
    }

    /**
     * Format file size for display
     */
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    /**
     * Validate email format
     */
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Validate phone number format
     */
    function isValidPhone(phone) {
        const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
        return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
    }

    /**
     * Global error handler
     */
    window.addEventListener('error', function(e) {
        console.error('Global error:', e.error);
        if (isLoading) {
            hideLoading();
        }
    });

    /**
     * Handle unhandled promise rejections
     */
    window.addEventListener('unhandledrejection', function(e) {
        console.error('Unhandled promise rejection:', e.reason);
        if (isLoading) {
            hideLoading();
        }
    });

    // Export functions to global scope
    window.INLISLitePublic = {
        showToast,
        copyToClipboard,
        formatDate,
        formatFileSize,
        isValidEmail,
        isValidPhone,
        debounce,
        throttle
    };

    // Make showToast globally available
    window.showToast = showToast;

    console.log('📦 INLISLite v3.0 Public JavaScript loaded successfully');

})();