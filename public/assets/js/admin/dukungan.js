/**
 * INLISLite v3.0 Dukungan Teknis Page JavaScript
 * Modern, interactive functionality for technical support page
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
    
    // Initialize card toggle functionality
    initializeCardToggle();
    
    // Initialize global edit toggle
    initializeGlobalEditToggle();
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
 * Add loading states
 */
function addLoadingStates() {
    const interactiveElements = document.querySelectorAll('.contact-card, .service-item, .step-item');
    
    interactiveElements.forEach(element => {
        element.addEventListener('click', function() {
            this.style.opacity = '0.7';
            this.style.pointerEvents = 'none';
            
            setTimeout(() => {
                this.style.opacity = '1';
                this.style.pointerEvents = 'auto';
            }, 300);
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
 * Add search functionality (if needed in future)
 */
function initializeSearch() {
    // Placeholder for future search functionality
    const searchableElements = document.querySelectorAll('.service-title, .contact-label, .step-text');
    
    // Store original content for search
    window.searchableContent = Array.from(searchableElements).map(el => ({
        element: el,
        text: el.textContent.toLowerCase()
    }));
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

// Handle window resize
window.addEventListener('resize', handleResponsive);

/**
 * Initialize global edit toggle functionality
 */
function initializeGlobalEditToggle() {
    const globalToggle = document.getElementById('globalEditToggle');
    if (!globalToggle) return;
    
    let isGlobalEditMode = false;
    
    globalToggle.addEventListener('click', function() {
        isGlobalEditMode = !isGlobalEditMode;
        
        const allCards = document.querySelectorAll('.support-card');
        const toggleText = this.querySelector('.toggle-text');
        const toggleIcon = this.querySelector('i');
        
        if (isGlobalEditMode) {
            // Enable edit mode for all cards
            allCards.forEach(card => {
                card.classList.add('edit-mode');
            });
            
            // Update button appearance
            this.classList.remove('btn-primary');
            this.classList.add('btn-success');
            toggleIcon.className = 'bi bi-check-square me-2';
            toggleText.textContent = 'Disable Edit Mode';
            
            showNotification('Global edit mode enabled. Click any text to edit it.', 'success');
        } else {
            // Disable edit mode for all cards
            allCards.forEach(card => {
                card.classList.remove('edit-mode');
                
                // Cancel any active editing
                const editingElements = card.querySelectorAll('.editing');
                editingElements.forEach(el => cancelEditableElement(el));
            });
            
            // Update button appearance
            this.classList.remove('btn-success');
            this.classList.add('btn-primary');
            toggleIcon.className = 'bi bi-pencil-square me-2';
            toggleText.textContent = 'Enable Edit Mode';
            
            showNotification('Global edit mode disabled.', 'info');
        }
    });
}

/**
 * Initialize card toggle functionality
 */
function initializeCardToggle() {
    // Handle all card actions
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-card')) {
            e.preventDefault();
            const card = e.target.closest('.support-card');
            toggleEditMode(card);
        }
        
        if (e.target.closest('.add-card')) {
            e.preventDefault();
            const card = e.target.closest('.support-card');
            showAddCardModal(card);
        }
        
        if (e.target.closest('.toggle-card')) {
            e.preventDefault();
            const card = e.target.closest('.support-card');
            toggleCardVisibility(card);
        }
        
        if (e.target.closest('.delete-card')) {
            e.preventDefault();
            const card = e.target.closest('.support-card');
            deleteCard(card);
        }
        
        if (e.target.closest('.refresh-card')) {
            e.preventDefault();
            const card = e.target.closest('.support-card');
            refreshCard(card);
        }
        
        // Handle editable element clicks in edit mode
        if (e.target.closest('.editable') && e.target.closest('.support-card.edit-mode')) {
            e.preventDefault();
            makeElementEditable(e.target.closest('.editable'));
        }
        
        // Handle save new card button
        if (e.target.id === 'saveNewCard') {
            e.preventDefault();
            saveNewCard();
        }
    });
    
    // Handle keyboard events for editing
    document.addEventListener('keydown', function(e) {
        // Save on Enter, cancel on Escape
        if (e.target.classList.contains('editing')) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                saveEditableElement(e.target);
            } else if (e.key === 'Escape') {
                e.preventDefault();
                cancelEditableElement(e.target);
            }
        }
    });
    
    // Handle blur events for editing
    document.addEventListener('blur', function(e) {
        if (e.target.classList.contains('editing')) {
            saveEditableElement(e.target);
        }
    }, true);
}

/**
 * Toggle edit mode for a card
 */
function toggleEditMode(card) {
    if (card.classList.contains('edit-mode')) {
        // Exit edit mode
        card.classList.remove('edit-mode');
        
        // Remove any active editing states
        const editingElements = card.querySelectorAll('.editing');
        editingElements.forEach(el => cancelEditableElement(el));
        
        showNotification('Edit mode disabled', 'info');
    } else {
        // Enter edit mode
        card.classList.add('edit-mode');
        showNotification('Edit mode enabled. Click text elements to edit them.', 'info');
    }
}

/**
 * Make an element editable
 */
function makeElementEditable(element) {
    if (element.classList.contains('editing')) return;
    
    const originalText = element.textContent;
    element.setAttribute('data-original-text', originalText);
    element.classList.add('editing');
    
    if (element.tagName.toLowerCase() === 'input') {
        element.focus();
        element.select();
    } else {
        element.contentEditable = true;
        element.focus();
        
        // Select all text
        const range = document.createRange();
        range.selectNodeContents(element);
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }
}

/**
 * Save editable element
 */
function saveEditableElement(element) {
    if (!element.classList.contains('editing')) return;
    
    const newText = element.tagName.toLowerCase() === 'input' ? element.value : element.textContent;
    const originalText = element.getAttribute('data-original-text');
    
    element.classList.remove('editing');
    element.contentEditable = false;
    element.removeAttribute('data-original-text');
    
    if (newText !== originalText) {
        showNotification('Text updated successfully', 'success');
        
        // Add visual feedback
        element.style.background = 'rgba(40, 167, 69, 0.1)';
        element.style.transition = 'background 0.3s ease';
        setTimeout(() => {
            element.style.background = '';
        }, 1000);
    }
}

/**
 * Cancel editable element
 */
function cancelEditableElement(element) {
    if (!element.classList.contains('editing')) return;
    
    const originalText = element.getAttribute('data-original-text');
    
    if (element.tagName.toLowerCase() === 'input') {
        element.value = originalText;
    } else {
        element.textContent = originalText;
    }
    
    element.classList.remove('editing');
    element.contentEditable = false;
    element.removeAttribute('data-original-text');
}

/**
 * Show add card modal
 */
function showAddCardModal(parentCard) {
    const modal = document.getElementById('addCardModal');
    if (!modal) return;
    
    // Store reference to parent card
    modal.setAttribute('data-parent-card', parentCard.getAttribute('data-card-id'));
    
    // Reset form
    document.getElementById('addCardForm').reset();
    
    // Show modal
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}

/**
 * Save new card
 */
function saveNewCard() {
    const modal = document.getElementById('addCardModal');
    const form = document.getElementById('addCardForm');
    
    const cardType = document.getElementById('cardType').value;
    const cardTitle = document.getElementById('cardTitle').value;
    const cardSubtitle = document.getElementById('cardSubtitle').value;
    const cardContent = document.getElementById('cardContent').value;
    
    if (!cardType || !cardTitle || !cardContent) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }
    
    // Create new card based on type
    let newCardHtml = '';
    const cardId = 'card-' + Date.now();
    
    switch (cardType) {
        case 'contact':
            newCardHtml = createContactCard(cardId, cardTitle, cardContent);
            break;
        case 'service':
            newCardHtml = createServiceItem(cardId, cardTitle, cardContent);
            break;
        case 'support':
            newCardHtml = createSupportCard(cardId, cardTitle, cardSubtitle, cardContent);
            break;
    }
    
    if (newCardHtml) {
        // Add to page
        const supportContent = document.querySelector('.support-content');
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newCardHtml;
        
        const newCard = tempDiv.firstElementChild;
        supportContent.appendChild(newCard);
        
        // Animate in
        newCard.style.opacity = '0';
        newCard.style.transform = 'translateY(20px)';
        setTimeout(() => {
            newCard.style.transition = 'all 0.6s ease';
            newCard.style.opacity = '1';
            newCard.style.transform = 'translateY(0)';
        }, 100);
        
        // Close modal
        const bsModal = bootstrap.Modal.getInstance(modal);
        bsModal.hide();
        
        showNotification('New card added successfully', 'success');
    }
}

/**
 * Create contact card HTML
 */
function createContactCard(cardId, title, content) {
    return `
        <div class="support-section mb-5">
            <div class="support-card" data-card-id="${cardId}">
                <div class="card-header d-flex justify-content-between align-items-start">
                    <div class="header-info">
                        <div class="header-icon-wrapper">
                            <i class="bi bi-info-circle"></i>
                        </div>
                        <div class="header-details">
                            <h3 class="card-title editable" data-field="title">${title}</h3>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                            <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                            <li><a class="dropdown-item toggle-card" href="#"><i class="bi bi-eye-slash me-2"></i>Hide</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="contact-grid">
                        <div class="contact-card editable-contact" data-contact-id="new-contact">
                            <div class="contact-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <div class="contact-info">
                                <h6 class="contact-label editable" data-field="label">Information</h6>
                                <p class="contact-value editable" data-field="value">${content}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

/**
 * Create service item HTML
 */
function createServiceItem(cardId, title, content) {
    return `
        <div class="support-section mb-5">
            <div class="support-card" data-card-id="${cardId}">
                <div class="card-header d-flex justify-content-between align-items-start">
                    <div class="header-info">
                        <div class="header-icon-wrapper green">
                            <i class="bi bi-gear"></i>
                        </div>
                        <div class="header-details">
                            <h3 class="card-title editable" data-field="title">${title}</h3>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                            <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                            <li><a class="dropdown-item toggle-card" href="#"><i class="bi bi-eye-slash me-2"></i>Hide</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="services-list">
                        <div class="service-item editable-service" data-service-id="new-service">
                            <div class="service-bullet"></div>
                            <div class="service-content">
                                <h6 class="service-title editable" data-field="title">${title}</h6>
                                <p class="service-description editable" data-field="description">${content}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

/**
 * Create support card HTML
 */
function createSupportCard(cardId, title, subtitle, content) {
    return `
        <div class="support-section mb-5">
            <div class="support-card" data-card-id="${cardId}">
                <div class="card-header d-flex justify-content-between align-items-start">
                    <div class="header-info">
                        <div class="header-icon-wrapper blue">
                            <i class="bi bi-question-circle"></i>
                        </div>
                        <div class="header-details">
                            <h3 class="card-title editable" data-field="title">${title}</h3>
                            ${subtitle ? `<p class="card-subtitle editable" data-field="subtitle">${subtitle}</p>` : ''}
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                            <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                            <li><a class="dropdown-item toggle-card" href="#"><i class="bi bi-eye-slash me-2"></i>Hide</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="support-content">
                        <p class="editable" data-field="content">${content}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

/**
 * Delete card
 */
function deleteCard(card) {
    const cardTitle = card.querySelector('.card-title').textContent;
    
    if (confirm(`Are you sure you want to delete the card "${cardTitle}"? This action cannot be undone.`)) {
        // Add deletion animation
        card.style.transition = 'all 0.3s ease';
        card.style.opacity = '0';
        card.style.transform = 'translateY(-20px) scale(0.95)';
        
        setTimeout(() => {
            const section = card.closest('.support-section');
            if (section) {
                section.remove();
            } else {
                card.remove();
            }
            showNotification(`Card "${cardTitle}" deleted successfully`, 'success');
        }, 300);
    }
}

/**
 * Toggle card visibility
 */
function toggleCardVisibility(card) {
    const toggleBtn = card.querySelector('.toggle-card');
    const icon = toggleBtn.querySelector('i');
    
    if (card.classList.contains('hidden')) {
        // Show card
        card.classList.remove('hidden');
        icon.className = 'bi bi-eye-slash me-2';
        toggleBtn.innerHTML = '<i class="bi bi-eye-slash me-2"></i>Hide';
        showNotification('Card is now visible', 'success');
    } else {
        // Hide card
        card.classList.add('hidden');
        icon.className = 'bi bi-eye me-2';
        toggleBtn.innerHTML = '<i class="bi bi-eye me-2"></i>Show';
        showNotification('Card is now hidden', 'info');
    }
}

/**
 * Refresh card content
 */
function refreshCard(card) {
    const cardId = card.getAttribute('data-card-id');
    
    // Add loading state
    card.style.opacity = '0.6';
    card.style.pointerEvents = 'none';
    
    // Simulate refresh (replace with actual API call)
    setTimeout(() => {
        card.style.opacity = '1';
        card.style.pointerEvents = 'auto';
        
        // Add refresh animation
        card.style.transform = 'scale(1.02)';
        setTimeout(() => {
            card.style.transform = 'scale(1)';
        }, 200);
        
        showNotification(`Card "${cardId}" refreshed successfully`, 'success');
    }, 1000);
}

/**
 * Show notification
 */
function showNotification(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    // Remove existing alerts
    alertContainer.innerHTML = '';
    
    // Create alert element
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        <i class="bi bi-${getNotificationIcon(type)} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    // Add to container
    alertContainer.appendChild(alert);
    
    // Auto-dismiss after 3 seconds
    setTimeout(() => {
        if (alert && alert.parentNode) {
            alert.classList.remove('show');
            setTimeout(() => {
                if (alert && alert.parentNode) {
                    alert.remove();
                }
            }, 150);
        }
    }, 3000);
}

/**
 * Get notification icon based on type
 */
function getNotificationIcon(type) {
    switch (type) {
        case 'success':
            return 'check-circle';
        case 'danger':
        case 'error':
            return 'exclamation-triangle';
        case 'warning':
            return 'exclamation-triangle';
        case 'info':
        default:
            return 'info-circle';
    }
}

/**
 * Analytics and tracking (placeholder)
 */
function trackUserInteraction(action, element) {
    // Placeholder for analytics tracking
    console.log(`User interaction: ${action} on`, element);
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

// Initialize performance optimizations
document.addEventListener('DOMContentLoaded', function() {
    optimizePerformance();
    initializeTooltips();
    addLoadingStates();
    initializeSearch();
    enhanceAccessibility();
});

/**
 * Export functions for external use
 */
window.DukunganTeknis = {
    confirmLogout,
    initializeFeatherIcons,
    handleResponsive,
    showCopyNotification,
    toggleEditMode,
    toggleCardVisibility,
    refreshCard,
    showNotification
};