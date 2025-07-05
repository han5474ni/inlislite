/**
 * Registration View Page JavaScript - INLISlite v3.0
 * Bootstrap 5 compatible scripts for registration view/detail page
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
    
    // Quick action buttons
    setupQuickActionButtons();
    
    // Status change buttons
    setupStatusChangeButtons();
    
    // Delete button
    setupDeleteButton();
    
    // Print functionality
    setupPrintFunctionality();
    
    // Copy to clipboard functionality
    setupCopyFunctionality();
}

/**
 * Setup quick action buttons
 */
function setupQuickActionButtons() {
    // Edit button
    const editBtn = document.querySelector('[href*="edit"]');
    if (editBtn) {
        editBtn.addEventListener('click', function(e) {
            console.log('Navigating to edit page...');
            showToast('Opening edit form...', 'info');
        });
    }
    
    // Back button
    const backBtn = document.querySelector('[href*="registration"]:not([href*="edit"]):not([href*="add"])');
    if (backBtn) {
        backBtn.addEventListener('click', function(e) {
            console.log('Navigating back to registration list...');
        });
    }
}

/**
 * Setup status change buttons
 */
function setupStatusChangeButtons() {
    // Mark as verified button
    const verifiedBtn = document.querySelector('[onclick*="verified"]');
    if (verifiedBtn) {
        verifiedBtn.removeAttribute('onclick');
        verifiedBtn.addEventListener('click', function() {
            changeRegistrationStatus('verified');
        });
    }
    
    // Mark as pending button
    const pendingBtn = document.querySelector('[onclick*="pending"]');
    if (pendingBtn) {
        pendingBtn.removeAttribute('onclick');
        pendingBtn.addEventListener('click', function() {
            changeRegistrationStatus('pending');
        });
    }
    
    // Mark as inactive button
    const inactiveBtn = document.querySelector('[onclick*="inactive"]');
    if (inactiveBtn) {
        inactiveBtn.removeAttribute('onclick');
        inactiveBtn.addEventListener('click', function() {
            changeRegistrationStatus('inactive');
        });
    }
}

/**
 * Setup delete button
 */
function setupDeleteButton() {
    const deleteBtn = document.querySelector('[onclick*="deleteRegistration"]');
    if (deleteBtn) {
        deleteBtn.removeAttribute('onclick');
        deleteBtn.addEventListener('click', function() {
            deleteRegistration();
        });
    }
}

/**
 * Setup print functionality
 */
function setupPrintFunctionality() {
    // Add print button if not exists
    const headerRight = document.querySelector('.header-right');
    if (headerRight && !document.querySelector('.print-btn')) {
        const printBtn = document.createElement('button');
        printBtn.className = 'btn btn-outline-secondary print-btn me-2';
        printBtn.innerHTML = '<i class="bi bi-printer me-2"></i>Print';
        printBtn.addEventListener('click', printRegistration);
        
        headerRight.insertBefore(printBtn, headerRight.firstChild);
    }
}

/**
 * Setup copy functionality
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
    
    const websiteField = document.querySelector('a[href^="http"]');
    if (websiteField) {
        addCopyButton(websiteField, 'website');
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
    copyBtn.addEventListener('click', function() {
        copyToClipboard(element.textContent, type);
    });
    
    element.parentNode.appendChild(copyBtn);
}

/**
 * Initialize page features
 */
function initializePageFeatures() {
    // Add fade-in animation to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.classList.add('fade-in');
        card.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Initialize tooltips
    initializeTooltips();
    
    // Load additional registration data if needed
    loadRegistrationData();
}

/**
 * Initialize Bootstrap tooltips
 */
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
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
 * Change registration status
 */
function changeRegistrationStatus(newStatus) {
    if (!registrationId) {
        showToast('Registration ID not found', 'error');
        return;
    }
    
    const statusText = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
    
    if (!confirm(`Are you sure you want to change status to ${statusText}?`)) {
        return;
    }
    
    console.log(`Changing status to: ${newStatus}`);
    
    // Show loading state
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    
    // Make AJAX request
    fetch('/admin/registration/update-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            id: registrationId,
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(`Status changed to ${statusText} successfully!`, 'success');
            
            // Update status badge on page
            updateStatusBadge(newStatus);
            
            // Reload page after short delay
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Failed to update status');
        }
    })
    .catch(error => {
        console.error('Error updating status:', error);
        showToast(error.message || 'Failed to update status', 'error');
        
        // Reset button state
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

/**
 * Update status badge on page
 */
function updateStatusBadge(newStatus) {
    const statusBadge = document.querySelector('.badge-status');
    if (statusBadge) {
        statusBadge.className = `badge badge-status ${newStatus.toLowerCase()}`;
        statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
    }
}

/**
 * Delete registration
 */
function deleteRegistration() {
    if (!registrationId) {
        showToast('Registration ID not found', 'error');
        return;
    }
    
    if (!confirm('Are you sure you want to delete this registration? This action cannot be undone.')) {
        return;
    }
    
    console.log('Deleting registration:', registrationId);
    
    // Show loading state
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';
    
    // Make AJAX request
    fetch(`/admin/registration/delete/${registrationId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Registration deleted successfully!', 'success');
            
            // Redirect to registration list
            setTimeout(() => {
                window.location.href = '/admin/registration';
            }, 1500);
        } else {
            throw new Error(data.message || 'Failed to delete registration');
        }
    })
    .catch(error => {
        console.error('Error deleting registration:', error);
        showToast(error.message || 'Failed to delete registration', 'error');
        
        // Reset button state
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

/**
 * Print registration details
 */
function printRegistration() {
    console.log('Printing registration details...');
    
    // Hide non-printable elements temporarily
    const nonPrintable = document.querySelectorAll('.btn, .sidebar, .mobile-menu-btn, .header-right, .quick-actions');
    nonPrintable.forEach(el => el.style.display = 'none');
    
    // Print
    window.print();
    
    // Restore elements after print
    setTimeout(() => {
        nonPrintable.forEach(el => el.style.display = '');
    }, 1000);
}

/**
 * Copy text to clipboard
 */
function copyToClipboard(text, type) {
    navigator.clipboard.writeText(text).then(() => {
        showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} copied to clipboard!`, 'success');
    }).catch(err => {
        console.error('Failed to copy text: ', err);
        showToast('Failed to copy to clipboard', 'error');
    });
}

/**
 * Show toast notification
 */
function showToast(message, type = 'info') {
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toastContainer';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    const toastId = 'toast-' + Date.now();
    const bgClass = type === 'error' ? 'bg-danger' : (type === 'success' ? 'bg-success' : 'bg-info');
    
    const toastElement = document.createElement('div');
    toastElement.id = toastId;
    toastElement.className = `toast align-items-center text-white ${bgClass} border-0`;
    toastElement.setAttribute('role', 'alert');
    toastElement.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    toastContainer.appendChild(toastElement);
    
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    
    // Remove toast from DOM after hiding
    toastElement.addEventListener('hidden.bs.toast', function() {
        toastElement.remove();
    });
    
    console.log(`📢 Toast shown: ${type} - ${message}`);
}

/**
 * Logout confirmation function
 */
function confirmLogout() {
    return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
}

/**
 * Export data functionality
 */
function exportRegistrationData(format = 'json') {
    if (!registrationData) {
        showToast('No registration data available', 'error');
        return;
    }
    
    let content, filename, mimeType;
    
    switch (format) {
        case 'json':
            content = JSON.stringify(registrationData, null, 2);
            filename = `registration_${registrationId}.json`;
            mimeType = 'application/json';
            break;
        case 'csv':
            content = convertToCSV(registrationData);
            filename = `registration_${registrationId}.csv`;
            mimeType = 'text/csv';
            break;
        default:
            showToast('Unsupported export format', 'error');
            return;
    }
    
    downloadFile(content, filename, mimeType);
    showToast(`Registration data exported as ${format.toUpperCase()}`, 'success');
}

/**
 * Convert object to CSV
 */
function convertToCSV(obj) {
    const headers = Object.keys(obj);
    const values = Object.values(obj);
    
    return headers.join(',') + '\n' + values.map(v => `"${v}"`).join(',');
}

/**
 * Download file
 */
function downloadFile(content, filename, mimeType) {
    const blob = new Blob([content], { type: mimeType });
    const url = URL.createObjectURL(blob);
    
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    link.style.display = 'none';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    URL.revokeObjectURL(url);
}

// Export functions for global access
window.RegistrationView = {
    changeRegistrationStatus,
    deleteRegistration,
    printRegistration,
    copyToClipboard,
    showToast,
    confirmLogout,
    exportRegistrationData
};

console.log('📦 Registration View JavaScript loaded successfully');