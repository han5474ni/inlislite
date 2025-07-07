/**
 * Registration Edit Page JavaScript - INLISlite v3.0
 * Bootstrap 5 compatible scripts for registration edit form
 */

// Global variables
let isFormSubmitting = false;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Registration Edit Page Initializing...');
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize form features
    initializeFormFeatures();
    
    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    console.log('✅ Registration Edit Page Ready');
});

/**
 * Setup all event listeners
 */
function setupEventListeners() {
    console.log('📡 Setting up event listeners...');
    
    // Form submission
    const registrationForm = document.getElementById('registrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', handleFormSubmit);
    }
    
    // Real-time validation
    const requiredFields = document.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
    
    // Auto-generate library code
    setupLibraryCodeGeneration();
    
    // Format phone numbers
    setupPhoneFormatting();
    
    // Setup cancel confirmation
    const cancelBtn = document.querySelector('a[href*="registration"]');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function(e) {
            if (isFormDirty()) {
                if (!confirm('You have unsaved changes. Are you sure you want to leave?')) {
                    e.preventDefault();
                }
            }
        });
    }
}

/**
 * Handle form submission
 */
function handleFormSubmit(e) {
    console.log('📝 Submitting registration edit form...');
    
    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Prevent double submission
    if (isFormSubmitting) {
        e.preventDefault();
        return;
    }
    
    // Validate form
    if (!validateForm(form)) {
        e.preventDefault();
        showToast('Please fix the errors before submitting', 'error');
        return;
    }
    
    // Clear previous errors
    clearFormErrors();
    
    // Set submitting state
    isFormSubmitting = true;
    
    // Show loading state
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    }
    
    // Add a timeout to reset the form state in case of server errors
    setTimeout(() => {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Update Registration';
        }
        isFormSubmitting = false;
    }, 10000); // 10 seconds timeout
    
    // Let the form submit normally (no preventDefault)
    // The form will submit to the server and handle redirect/response there
}

/**
 * Initialize form features
 */
function initializeFormFeatures() {
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize dynamic form features
    initializeDynamicFormFeatures();
    
    // Mark form as clean initially
    markFormAsClean();
}

/**
 * Initialize form validation
 */
function initializeFormValidation() {
    const form = document.getElementById('registrationForm');
    if (!form) return;
    
    // Add Bootstrap validation classes
    form.classList.add('needs-validation');
    form.noValidate = true;
}

/**
 * Validate entire form
 */
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    // Clear all previous errors
    clearFormErrors();
    
    // Validate required fields
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    // Additional custom validations
    const emailField = form.querySelector('[name="email"]');
    if (emailField && emailField.value && !isValidEmail(emailField.value)) {
        showFieldError(emailField, 'Please enter a valid email address');
        isValid = false;
    }
    
    const phoneField = form.querySelector('[name="phone"]');
    if (phoneField && phoneField.value && !isValidPhone(phoneField.value)) {
        showFieldError(phoneField, 'Please enter a valid phone number (minimum 6 characters)');
        isValid = false;
    }
    
    const websiteField = form.querySelector('[name="website"]');
    if (websiteField && websiteField.value && !isValidUrl(websiteField.value)) {
        showFieldError(websiteField, 'Please enter a valid website URL');
        isValid = false;
    }
    
    const libraryTypeField = form.querySelector('[name="library_type"]');
    if (libraryTypeField && !libraryTypeField.value) {
        showFieldError(libraryTypeField, 'Please select a library type');
        isValid = false;
    }
    
    const statusField = form.querySelector('[name="status"]');
    if (statusField && !statusField.value) {
        showFieldError(statusField, 'Please select a status');
        isValid = false;
    }
    
    const establishedYearField = form.querySelector('[name="established_year"]');
    if (establishedYearField && establishedYearField.value) {
        const year = parseInt(establishedYearField.value);
        const currentYear = new Date().getFullYear();
        if (isNaN(year) || year < 1800 || year > currentYear) {
            showFieldError(establishedYearField, `Please enter a valid year between 1800 and ${currentYear}`);
            isValid = false;
        }
    }
    
    const collectionCountField = form.querySelector('[name="collection_count"]');
    if (collectionCountField && collectionCountField.value) {
        const count = parseInt(collectionCountField.value);
        if (isNaN(count) || count < 0) {
            showFieldError(collectionCountField, 'Collection count must be a positive number');
            isValid = false;
        }
    }
    
    const memberCountField = form.querySelector('[name="member_count"]');
    if (memberCountField && memberCountField.value) {
        const count = parseInt(memberCountField.value);
        if (isNaN(count) || count < 0) {
            showFieldError(memberCountField, 'Member count must be a positive number');
            isValid = false;
        }
    }
    
    // Show summary if there are errors
    if (!isValid) {
        const errorCount = form.querySelectorAll('.is-invalid').length;
        showToast(`Please fix ${errorCount} error${errorCount > 1 ? 's' : ''} before submitting`, 'error');
        
        // Scroll to first error
        const firstError = form.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }
    
    return isValid;
}

/**
 * Validate individual field
 */
function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    
    // Check required fields
    if (field.hasAttribute('required') && value === '') {
        showFieldError(field, 'This field is required');
        isValid = false;
    } else {
        // Type-specific validation
        if (field.type === 'email' && value && !isValidEmail(value)) {
            showFieldError(field, 'Please enter a valid email address');
            isValid = false;
        } else if (field.type === 'tel' && value && !isValidPhone(value)) {
            showFieldError(field, 'Please enter a valid phone number');
            isValid = false;
        } else if (field.type === 'url' && value && !isValidUrl(value)) {
            showFieldError(field, 'Please enter a valid URL');
            isValid = false;
        } else {
            showFieldSuccess(field);
        }
    }
    
    return isValid;
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    field.classList.remove('is-valid');
    field.classList.add('is-invalid');
    
    // Remove existing feedback
    const existingFeedback = field.parentNode.querySelector('.invalid-feedback');
    if (existingFeedback) {
        existingFeedback.remove();
    }
    
    // Add error message
    const feedback = document.createElement('div');
    feedback.className = 'invalid-feedback';
    feedback.textContent = message;
    field.parentNode.appendChild(feedback);
}

/**
 * Show field success
 */
function showFieldSuccess(field) {
    field.classList.remove('is-invalid');
    field.classList.add('is-valid');
    
    // Remove error feedback
    const existingFeedback = field.parentNode.querySelector('.invalid-feedback');
    if (existingFeedback) {
        existingFeedback.remove();
    }
}

/**
 * Clear all form errors
 */
function clearFormErrors() {
    document.querySelectorAll('.is-invalid').forEach(element => {
        element.classList.remove('is-invalid');
    });
    document.querySelectorAll('.invalid-feedback').forEach(element => {
        element.remove();
    });
}

/**
 * Setup library code generation
 */
function setupLibraryCodeGeneration() {
    const libraryNameField = document.querySelector('[name="library_name"]');
    const libraryTypeField = document.querySelector('[name="library_type"]');
    const libraryCodeField = document.querySelector('[name="library_code"]');
    
    if (libraryNameField && libraryTypeField && libraryCodeField) {
        function generateLibraryCode() {
            const name = libraryNameField.value.trim();
            const type = libraryTypeField.value;
            
            if (name && type && !libraryCodeField.value) {
                const nameCode = name.substring(0, 3).toUpperCase();
                const typeCode = type.substring(0, 3).toUpperCase();
                const randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                
                libraryCodeField.value = `${typeCode}-${nameCode}-${randomNum}`;
            }
        }
        
        libraryNameField.addEventListener('blur', generateLibraryCode);
        libraryTypeField.addEventListener('change', generateLibraryCode);
    }
}

/**
 * Setup phone number formatting
 */
function setupPhoneFormatting() {
    const phoneFields = document.querySelectorAll('[type="tel"]');
    phoneFields.forEach(field => {
        field.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.startsWith('62')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = '+62' + value.substring(1);
            }
            this.value = value;
        });
    });
}

/**
 * Initialize dynamic form features
 */
function initializeDynamicFormFeatures() {
    // Track form changes
    const form = document.getElementById('registrationForm');
    if (form) {
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('change', markFormAsDirty);
            input.addEventListener('input', markFormAsDirty);
        });
    }
}

/**
 * Form dirty state management
 */
let formIsDirty = false;

function markFormAsDirty() {
    formIsDirty = true;
}

function markFormAsClean() {
    formIsDirty = false;
}

function isFormDirty() {
    return formIsDirty;
}

/**
 * Validation helper functions
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    const phoneRegex = /^[\+]?[0-9\-\(\)\s]+$/;
    return phoneRegex.test(phone) && phone.length >= 10;
}

function isValidUrl(url) {
    if (!url) return true; // Empty URLs are valid (optional field)
    
    // Try to validate as-is first
    try {
        new URL(url);
        return true;
    } catch {
        // If it fails, try adding http:// prefix
        try {
            new URL('http://' + url);
            return true;
        } catch {
            return false;
        }
    }
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

// Export functions for global access
window.RegistrationEdit = {
    validateField,
    validateForm,
    showToast,
    confirmLogout
};

console.log('📦 Registration Edit JavaScript loaded successfully');