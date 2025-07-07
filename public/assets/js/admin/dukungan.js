/**
 * INLISLite v3.0 Dukungan Teknis Page JavaScript
 * Simplified version without popup cards functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize the support page
    initializeSupportPage();
    
    // Initialize Feather icons
    initializeFeatherIcons();
    
    // Initialize animations
    initializeAnimations();
    
    // Initialize interactive features
    initializeInteractiveFeatures();
    
    // Handle responsive behavior
    handleResponsive();
});

/**
 * Initialize the support page functionality
 */
function initializeSupportPage() {
    console.log('Dukungan Teknis page initialized');
    
    // Add loading animation to cards
    const supportCards = document.querySelectorAll('.support-card');
    supportCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });
}

/**
 * Initialize Feather icons
 */
function initializeFeatherIcons() {
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

/**
 * Initialize animations
 */
function initializeAnimations() {
    // Staggered animation for contact cards
    const contactCards = document.querySelectorAll('.contact-card');
    contactCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Staggered animation for service items
    const serviceItems = document.querySelectorAll('.service-item');
    serviceItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Staggered animation for step items
    const stepItems = document.querySelectorAll('.step-item');
    stepItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
    });
}

/**
 * Initialize interactive features
 */
function initializeInteractiveFeatures() {
    // Add click-to-copy functionality for contact information
    initializeClickToCopy();
    
    // Add hover effects for cards
    initializeHoverEffects();
    
    // Add smooth scrolling for internal links
    initializeSmoothScrolling();
    
    // Add keyboard navigation
    initializeKeyboardNavigation();
}

/**
 * Initialize click-to-copy functionality
 */
function initializeClickToCopy() {
    const contactValues = document.querySelectorAll('.contact-value');
    
    contactValues.forEach(element => {
        element.style.cursor = 'pointer';
        element.title = 'Klik untuk menyalin';
        
        element.addEventListener('click', function() {
            const text = this.textContent.trim();
            
            // Copy to clipboard
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    showCopyNotification(this, 'Disalin!');
                }).catch(() => {
                    fallbackCopyTextToClipboard(text, this);
                });
            } else {
                fallbackCopyTextToClipboard(text, this);
            }
        });
    });
}

/**
 * Fallback copy function for older browsers
 */
function fallbackCopyTextToClipboard(text, element) {
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
        showCopyNotification(element, 'Disalin!');
    } catch (err) {
        showCopyNotification(element, 'Gagal menyalin');
    }
    
    document.body.removeChild(textArea);
}

/**
 * Show copy notification
 */
function showCopyNotification(element, message) {
    const notification = document.createElement('div');
    notification.textContent = message;
    notification.style.cssText = `
        position: absolute;
        background: #28a745;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        z-index: 1000;
        pointer-events: none;
        transform: translateX(-50%);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    `;
    
    const rect = element.getBoundingClientRect();
    notification.style.left = rect.left + rect.width / 2 + 'px';
    notification.style.top = rect.top - 40 + 'px';
    
    document.body.appendChild(notification);
    
    // Animate in
    notification.style.opacity = '0';
    notification.style.transform = 'translateX(-50%) translateY(10px)';
    notification.style.transition = 'all 0.3s ease';
    
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateX(-50%) translateY(0)';
    }, 10);
    
    // Remove after 2 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(-50%) translateY(-10px)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 2000);
}

/**
 * Initialize hover effects
 */
function initializeHoverEffects() {
    // Enhanced hover effects for contact cards
    const contactCards = document.querySelectorAll('.contact-card');
    contactCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Enhanced hover effects for service items
    const serviceItems = document.querySelectorAll('.service-item');
    serviceItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(8px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
    
    // Enhanced hover effects for step items
    const stepItems = document.querySelectorAll('.step-item');
    stepItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

/**
 * Initialize smooth scrolling
 */
function initializeSmoothScrolling() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Initialize keyboard navigation
 */
function initializeKeyboardNavigation() {
    document.addEventListener('keydown', function(e) {
        // Escape key to scroll to top
        if (e.key === 'Escape') {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Ctrl+H to focus on header
        if (e.ctrlKey && e.key === 'h') {
            e.preventDefault();
            const header = document.querySelector('.page-header');
            if (header) {
                header.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                header.focus();
            }
        }
    });
}

/**
 * Handle responsive behavior
 */
function handleResponsive() {
    const isMobile = window.innerWidth <= 768;
    const isTablet = window.innerWidth <= 992;
    
    // Adjust card layouts for mobile
    const contactGrid = document.querySelector('.contact-grid');
    const requestGrid = document.querySelector('.request-grid');
    
    if (contactGrid) {
        if (isMobile) {
            contactGrid.style.gridTemplateColumns = '1fr';
        } else if (isTablet) {
            contactGrid.style.gridTemplateColumns = 'repeat(2, 1fr)';
        } else {
            contactGrid.style.gridTemplateColumns = 'repeat(4, 1fr)';
        }
    }
    
    if (requestGrid) {
        if (isTablet) {
            requestGrid.style.gridTemplateColumns = '1fr';
        } else {
            requestGrid.style.gridTemplateColumns = 'repeat(2, 1fr)';
        }
    }
}

/**
 * Logout confirmation function
 */
function confirmLogout() {
    return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    // Add tooltips to interactive elements
    const tooltipElements = [
        { selector: '.contact-value', text: 'Klik untuk menyalin' },
        { selector: '.header-icon', text: 'Dukungan Teknis' },
        { selector: '.contact-icon', text: 'Informasi Kontak' },
        { selector: '.service-bullet', text: 'Layanan Tersedia' }
    ];
    
    tooltipElements.forEach(({ selector, text }) => {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
            if (!element.title) {
                element.title = text;
            }
        });
    });
}

/**
 * Initialize intersection observer for animations
 */
function initializeIntersectionObserver() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all support sections
    const sections = document.querySelectorAll('.support-section');
    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'all 0.6s ease';
        observer.observe(section);
    });
}

/**
 * Performance optimization
 */
function optimizePerformance() {
    // Debounce resize events
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(handleResponsive, 250);
    });
    
    // Lazy load animations
    if ('IntersectionObserver' in window) {
        initializeIntersectionObserver();
    }
}

/**
 * Accessibility improvements
 */
function enhanceAccessibility() {
    // Add ARIA labels
    const contactCards = document.querySelectorAll('.contact-card');
    contactCards.forEach((card, index) => {
        card.setAttribute('role', 'button');
        card.setAttribute('tabindex', '0');
        card.setAttribute('aria-label', `Informasi kontak ${index + 1}`);
    });
    
    // Add keyboard support for interactive elements
    const interactiveElements = document.querySelectorAll('.contact-card, .service-item');
    interactiveElements.forEach(element => {
        element.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
}

// Handle window resize
window.addEventListener('resize', handleResponsive);

// Initialize performance optimizations
document.addEventListener('DOMContentLoaded', function() {
    optimizePerformance();
    initializeTooltips();
    enhanceAccessibility();
});

/**
 * Export functions for external use
 */
window.DukunganTeknis = {
    confirmLogout,
    initializeFeatherIcons,
    handleResponsive,
    showCopyNotification
};