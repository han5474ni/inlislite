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
    e.preventDefault();
    
    if (isFormSubmitting) {
        return;
    }
    
    console.log('📝 Submitting registration edit form...');
    
    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Validate form
    if (!validateForm(form)) {
        showToast('Please fix the errors before submitting', 'error');
        return;
    }
    
    // Show loading state
    isFormSubmitting = true;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    
    // Clear previous errors
    clearFormErrors();
    
    // Get form data
    const formData = new FormData(form);
    
    // Submit form via AJAX
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Registration updated successfully!', 'success');
            
            // Redirect after short delay
            setTimeout(() => {
                window.location.href = '/admin/registration';
            }, 1500);
        } else {
            throw new Error(data.message || 'Failed to update registration');
        }
    })
    .catch(error => {
        console.error('Error updating registration:', error);
        showToast(error.message || 'Failed to update registration', 'error');
        
        // Reset button state
        isFormSubmitting = false;
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
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
        showFieldError(phoneField, 'Please enter a valid phone number');
        isValid = false;
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
    try {
        new URL(url);
        return true;
    } catch {
        return false;
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