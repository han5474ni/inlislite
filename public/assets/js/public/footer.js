/**
 * Footer JavaScript for InlisLite v3
 * Handles footer animations, interactions, and accessibility
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize footer animations
    initFooterAnimations();
    
    // Initialize footer interactions
    initFooterInteractions();
    
    // Initialize accessibility features
    initAccessibilityFeatures();
    
    // Initialize scroll-triggered animations
    initScrollAnimations();
});

/**
 * Initialize footer animations
 */
function initFooterAnimations() {
    const footerElements = document.querySelectorAll('.footer-animate');
    
    // Add staggered animation delays
    footerElements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Logo hover animation
    const logoIcon = document.querySelector('.footer-logo-icon');
    if (logoIcon) {
        logoIcon.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) rotate(5deg)';
        });
        
        logoIcon.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) rotate(0deg)';
        });
    }
}

/**
 * Initialize footer interactions
 */
function initFooterInteractions() {
    // Email link click tracking
    const emailLink = document.querySelector('a[href^="mailto:"]');
    if (emailLink) {
        emailLink.addEventListener('click', function() {
            // Track email click (you can integrate with analytics here)
            console.log('Email link clicked:', this.href);
        });
    }
    
    // Admin login button enhanced interaction
    const adminBtn = document.querySelector('.footer-admin-btn');
    if (adminBtn) {
        adminBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.02)';
        });
        
        adminBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
        
        // Add ripple effect on click
        adminBtn.addEventListener('click', function(e) {
            createRippleEffect(e, this);
        });
    }
    
    // Contact items hover effects
    const contactItems = document.querySelectorAll('.footer-contact-item');
    contactItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.footer-contact-icon');
            if (icon) {
                icon.style.transform = 'scale(1.1)';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.footer-contact-icon');
            if (icon) {
                icon.style.transform = 'scale(1)';
            }
        });
    });
}

/**
 * Initialize accessibility features
 */
function initAccessibilityFeatures() {
    // Add ARIA labels
    const footer = document.querySelector('.footer-modern');
    if (footer) {
        footer.setAttribute('role', 'contentinfo');
        footer.setAttribute('aria-label', 'Footer informasi kontak dan navigasi');
    }
    
    // Enhance keyboard navigation
    const focusableElements = footer.querySelectorAll('a, button, [tabindex]:not([tabindex="-1"])');
    
    focusableElements.forEach(element => {
        element.addEventListener('focus', function() {
            this.style.outline = '2px solid #10b981';
            this.style.outlineOffset = '2px';
        });
        
        element.addEventListener('blur', function() {
            this.style.outline = '';
            this.style.outlineOffset = '';
        });
    });
}

/**
 * Initialize scroll-triggered animations
 */
function initScrollAnimations() {
    const footer = document.querySelector('.footer-modern');
    if (!footer) return;
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('footer-visible');
                
                // Trigger staggered animations
                const animateElements = entry.target.querySelectorAll('.footer-animate');
                animateElements.forEach((element, index) => {
                    setTimeout(() => {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            }
        });
    }, observerOptions);
    
    observer.observe(footer);
    
    // Set initial state for animated elements
    const animateElements = footer.querySelectorAll('.footer-animate');
    animateElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    });
}

/**
 * Create ripple effect on button click
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
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    `;
    
    // Add ripple animation keyframes if not already added
    if (!document.querySelector('#ripple-styles')) {
        const style = document.createElement('style');
        style.id = 'ripple-styles';
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    element.style.position = 'relative';
    element.style.overflow = 'hidden';
    element.appendChild(ripple);
    
    setTimeout(() => {
        ripple.remove();
    }, 600);
}

/**
 * Handle responsive behavior
 */
function handleResponsiveFooter() {
    const footer = document.querySelector('.footer-modern');
    if (!footer) return;
    
    function updateFooterLayout() {
        const isMobile = window.innerWidth < 768;
        const logoContainer = footer.querySelector('.footer-logo-container');
        const unitDescription = footer.querySelector('.footer-unit-description');
        
        if (isMobile) {
            logoContainer.classList.add('justify-content-center', 'text-center');
            unitDescription.classList.add('text-center');
        } else {
            logoContainer.classList.remove('justify-content-center', 'text-center');
            unitDescription.classList.remove('text-center');
        }
    }
    
    // Initial check
    updateFooterLayout();
    
    // Listen for resize events
    window.addEventListener('resize', debounce(updateFooterLayout, 250));
}

/**
 * Debounce function for performance
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

/**
 * Initialize responsive behavior
 */
handleResponsiveFooter();

/**
 * Footer utility functions
 */
window.FooterUtils = {
    // Scroll to top function
    scrollToTop: function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    },
    
    // Copy email to clipboard
    copyEmail: function() {
        const email = 'info@perpusnas.go.id';
        if (navigator.clipboard) {
            navigator.clipboard.writeText(email).then(() => {
                this.showToast('Email berhasil disalin ke clipboard');
            });
        } else {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = email;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            this.showToast('Email berhasil disalin ke clipboard');
        }
    },
    
    // Show toast notification
    showToast: function(message) {
        const toast = document.createElement('div');
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 1000;
            animation: slideInUp 0.3s ease;
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutDown 0.3s ease';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
};

// Add toast animation styles
if (!document.querySelector('#toast-styles')) {
    const style = document.createElement('style');
    style.id = 'toast-styles';
    style.textContent = `
        @keyframes slideInUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutDown {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}