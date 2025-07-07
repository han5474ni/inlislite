/**
 * Registration View Page JavaScript - INLISlite v3.0
 * Clean, focused functionality for registration detail view
 * 
 * This file contains only the essential functionality for the registration view page:
 * - Registration ID extraction
 * - Copy to clipboard functionality
 * - Basic page animations
 * - AJAX data loading
 * 
 * Shared utilities (showToast, sidebar) are handled by dashboard.js
 */

// Global variables
let registrationId = null;
let registrationData = null;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Registration View Page Initializing...');
    
    // Get registration ID from URL or data attribute
    extractRegistrationId();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize page features
    initializePageFeatures();
    
    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    console.log('✅ Registration View Page Ready');
});

/**
 * Extract registration ID from URL or data attributes
 */
function extractRegistrationId() {
    // Try to get from URL path
    const pathParts = window.location.pathname.split('/');
    const viewIndex = pathParts.indexOf('view');
    if (viewIndex !== -1 && pathParts[viewIndex + 1]) {
        registrationId = pathParts[viewIndex + 1];
    }
    
    // Try to get from data attribute
    const container = document.querySelector('[data-registration-id]');
    if (container) {
        registrationId = container.getAttribute('data-registration-id');
    }
    
    console.log('Registration ID:', registrationId);
}

/**
 * Setup all event listeners
 */
function setupEventListeners() {
    console.log('📡 Setting up event listeners...');
    
    // Back button functionality
    setupBackButton();
    
    // Copy to clipboard functionality
    setupCopyFunctionality();
}

/**
 * Setup back button
 */
function setupBackButton() {
    const backBtn = document.querySelector('.back-btn');
    if (backBtn) {
        backBtn.addEventListener('click', function(e) {
            console.log('Navigating back to registration list...');
            // Add smooth transition effect
            document.body.style.opacity = '0.8';
            setTimeout(() => {
                window.location.href = this.href;
            }, 200);
        });
    }
}

/**
 * Setup copy functionality for contact information
 */
function setupCopyFunctionality() {
    // Add copy buttons to contact information
    const emailField = document.querySelector('a[href^="mailto:"]');
    if (emailField) {
        addCopyButton(emailField, 'email');
    }
    
    const phoneField = document.querySelector('a[href^="tel:"]');
    if (phoneField) {
        addCopyButton(phoneField, 'phone');
    }
}

/**
 * Add copy button to a field
 */
function addCopyButton(element, type) {
    const copyBtn = document.createElement('button');
    copyBtn.className = 'btn btn-sm btn-outline-secondary ms-2';
    copyBtn.innerHTML = '<i class="bi bi-copy"></i>';
    copyBtn.title = `Copy ${type}`;
    copyBtn.style.fontSize = '0.75rem';
    copyBtn.style.padding = '0.25rem 0.5rem';
    
    copyBtn.addEventListener('click', function(e) {
        e.preventDefault();
        copyToClipboard(element.textContent, type);
    });
    
    element.parentNode.appendChild(copyBtn);
}


/**
 * Initialize page features
 */
function initializePageFeatures() {
    // Add fade-in animation to info cards
    const infoCards = document.querySelectorAll('.info-card');
    infoCards.forEach((card, index) => {
        card.classList.add('fade-in');
        card.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Add fade-in animation to main library card
    const libraryCard = document.querySelector('.library-main-card');
    if (libraryCard) {
        libraryCard.classList.add('fade-in');
    }
    
    // Load additional registration data if needed
    loadRegistrationData();
    
    // Setup status indicator interactions
    setupStatusIndicators();
}


/**
 * Load registration data via AJAX
 */
function loadRegistrationData() {
    if (!registrationId) return;
    
    fetch(`/admin/registration/get/${registrationId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            registrationData = data.registration;
            console.log('Registration data loaded:', registrationData);
        }
    })
    .catch(error => {
        console.error('Error loading registration data:', error);
    });
}

/**
 * Setup status indicator interactions
 */
function setupStatusIndicators() {
    const statusIndicators = document.querySelectorAll('.status-indicator');
    statusIndicators.forEach(indicator => {
        indicator.addEventListener('click', function() {
            const status = this.textContent.trim();
            showToast(`Status: ${status}`, 'info');
        });
    });
}


/**
 * Copy text to clipboard
 */
function copyToClipboard(text, type) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} copied to clipboard!`, 'success');
        }).catch(err => {
            console.error('Failed to copy text: ', err);
            showToast('Failed to copy to clipboard', 'error');
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} copied to clipboard!`, 'success');
        } catch (err) {
            console.error('Failed to copy text: ', err);
            showToast('Failed to copy to clipboard', 'error');
        }
        document.body.removeChild(textArea);
    }
}

/**
 * Show toast notification using dashboard utility
 */
function showToast(message, type = 'info') {
    // Use the dashboard showToast function if available
    if (window.DashboardJS && window.DashboardJS.showToast) {
        window.DashboardJS.showToast(message, type);
    } else {
        // Fallback implementation
        console.log(`📢 Toast: ${type} - ${message}`);
        alert(message);
    }
}

/**
 * Logout confirmation function
 */
function confirmLogout() {
    return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
}


// Export functions for global access
window.RegistrationView = {
    copyToClipboard,
    confirmLogout,
    loadRegistrationData,
    extractRegistrationId
};

console.log('📦 Registration View JavaScript loaded successfully');