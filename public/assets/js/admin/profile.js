/**
 * User Profile JavaScript - INLISlite v3.0
 * Modern, responsive user profile with Bootstrap 5
 */

// Global variables
let currentAvatarFile = null;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 User Profile System Initializing...');
    
    // Setup event listeners
    setupEventListeners();
    
    console.log('✅ User Profile System Ready');
});

/**
 * Setup all event listeners
 */
function setupEventListeners() {
    console.log('📡 Setting up event listeners...');
    
    // Avatar upload functionality
    setupAvatarUpload();
    
    // Password form functionality
    setupPasswordForm();
    
    // Password visibility toggles
    setupPasswordToggles();
    
    // Form validation
    setupFormValidation();
}

/**
 * Setup avatar upload functionality
 */
function setupAvatarUpload() {
    const avatarContainer = document.querySelector('.profile-avatar-container');
    const avatarInput = document.getElementById('avatarInput');
    const changePhotoBtn = document.getElementById('changePhotoBtn');
    const avatarUpload = document.getElementById('avatarUpload');
    
    // Click handlers for avatar upload
    if (avatarContainer) {
        avatarContainer.addEventListener('click', function() {
            avatarInput.click();
        });
    }
    
    if (changePhotoBtn) {
        changePhotoBtn.addEventListener('click', function() {
            avatarInput.click();
        });
    }
    
    if (avatarUpload) {
        avatarUpload.addEventListener('click', function() {
            avatarInput.click();
        });
    }
    
    // Handle file selection
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleAvatarUpload(file);
            }
        });
    }
}

/**
 * Handle avatar upload and preview
 */
function handleAvatarUpload(file) {
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
        showToast('Please select a valid image file (JPEG, PNG, or GIF)', 'error');
        return;
    }
    
    // Validate file size (max 5MB)
    const maxSize = 5 * 1024 * 1024; // 5MB
    if (file.size > maxSize) {
        showToast('Image file size must be less than 5MB', 'error');
        return;
    }
    
    // Store file for later upload
    currentAvatarFile = file;
    
    // Create preview
    const reader = new FileReader();
    reader.onload = function(e) {
        const avatarImage = document.getElementById('avatarImage');
        const avatarInitials = document.getElementById('avatarInitials');
        
        if (avatarImage && avatarInitials) {
            avatarImage.src = e.target.result;
            avatarImage.style.display = 'block';
            avatarInitials.style.display = 'none';
        }
        
        showToast('Image preview loaded. Click "Change Profile Picture" to save.', 'info');
    };
    reader.readAsDataURL(file);
    
    // Update button text
    const changePhotoBtn = document.getElementById('changePhotoBtn');
    if (changePhotoBtn) {
        changePhotoBtn.innerHTML = '<i class="bi bi-upload me-2"></i>Upload New Picture';
        changePhotoBtn.onclick = function() {
            uploadAvatar();
        };
    }
}

/**
 * Upload avatar to server
 */
function uploadAvatar() {
    if (!currentAvatarFile) {
        showToast('Please select an image first', 'error');
        return;
    }
    
    const changePhotoBtn = document.getElementById('changePhotoBtn');
    const originalText = changePhotoBtn.innerHTML;
    
    // Show loading state
    changePhotoBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...';
    changePhotoBtn.disabled = true;
    
    // Create FormData
    const formData = new FormData();
    formData.append('avatar', currentAvatarFile);
    
    // Simulate upload (replace with actual endpoint)
    setTimeout(() => {
        showToast('Profile picture updated successfully!', 'success');
        
        // Reset button
        changePhotoBtn.innerHTML = '<i class="bi bi-camera me-2"></i>Change Profile Picture';
        changePhotoBtn.disabled = false;
        changePhotoBtn.onclick = function() {
            document.getElementById('avatarInput').click();
        };
        
        currentAvatarFile = null;
        
        console.log('✅ Avatar uploaded successfully');
    }, 2000);
    
    // Uncomment for real implementation:
    /*
    fetch('/profile/upload-avatar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Profile picture updated successfully!', 'success');
        } else {
            showToast(data.message || 'Failed to upload image', 'error');
        }
    })
    .catch(error => {
        console.error('Error uploading avatar:', error);
        showToast('Error uploading image', 'error');
    })
    .finally(() => {
        changePhotoBtn.innerHTML = originalText;
        changePhotoBtn.disabled = false;
        currentAvatarFile = null;
    });
    */
}

/**
 * Setup password form functionality
 */
function setupPasswordForm() {
    const passwordForm = document.getElementById('passwordForm');
    const resetBtn = document.getElementById('resetPasswordForm');
    
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handlePasswordSubmit();
        });
    }
    
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            resetPasswordForm();
        });
    }
    
    // Password strength checking
    const newPasswordInput = document.getElementById('newPassword');
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            checkPasswordStrength(this.value);
        });
    }
    
    // Confirm password validation
    const confirmPasswordInput = document.getElementById('confirmPassword');
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            validatePasswordMatch();
        });
    }
}

/**
 * Setup password visibility toggles
 */
function setupPasswordToggles() {
    const toggleButtons = document.querySelectorAll('.password-toggle');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                targetInput.type = 'password';
                icon.className = 'bi bi-eye';
            }
        });
    });
}

/**
 * Setup form validation
 */
function setupFormValidation() {
    const inputs = document.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
}

/**
 * Handle password form submission
 */
function handlePasswordSubmit() {
    console.log('📝 Submitting password change form...');
    
    const form = document.getElementById('passwordForm');
    const updateBtn = document.getElementById('updatePasswordBtn');
    const originalText = updateBtn.innerHTML;
    
    // Clear previous errors
    clearAllErrors();
    
    // Validate form
    if (!validatePasswordForm()) {
        return;
    }
    
    // Show loading state
    updateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    updateBtn.disabled = true;
    
    // Get form data
    const formData = new FormData(form);
    
    // Simulate API call (replace with actual endpoint)
    setTimeout(() => {
        showToast('Password updated successfully!', 'success');
        resetPasswordForm();
        
        // Reset button
        updateBtn.innerHTML = originalText;
        updateBtn.disabled = false;
        
        console.log('✅ Password updated successfully');
    }, 2000);
    
    // Uncomment for real implementation:
    /*
    fetch('/profile/change-password', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Password updated successfully!', 'success');
            resetPasswordForm();
        } else {
            showToast(data.message || 'Failed to update password', 'error');
            if (data.errors) {
                displayFormErrors(data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error updating password:', error);
        showToast('Error updating password', 'error');
    })
    .finally(() => {
        updateBtn.innerHTML = originalText;
        updateBtn.disabled = false;
    });
    */
}

/**
 * Validate password form
 */
function validatePasswordForm() {
    let isValid = true;
    
    const currentPassword = document.getElementById('currentPassword');
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    
    // Validate current password
    if (!currentPassword.value.trim()) {
        showFieldError(currentPassword, 'Current password is required');
        isValid = false;
    }
    
    // Validate new password
    if (!newPassword.value.trim()) {
        showFieldError(newPassword, 'New password is required');
        isValid = false;
    } else if (newPassword.value.length < 6) {
        showFieldError(newPassword, 'Password must be at least 6 characters');
        isValid = false;
    }
    
    // Validate confirm password
    if (!confirmPassword.value.trim()) {
        showFieldError(confirmPassword, 'Please confirm your new password');
        isValid = false;
    } else if (newPassword.value !== confirmPassword.value) {
        showFieldError(confirmPassword, 'Passwords do not match');
        isValid = false;
    }
    
    return isValid;
}

/**
 * Check password strength
 */
function checkPasswordStrength(password) {
    const strengthIndicator = document.getElementById('passwordStrength');
    if (!strengthIndicator) return;
    
    let strength = 0;
    let feedback = '';
    
    if (password.length >= 6) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    
    switch (strength) {
        case 0:
        case 1:
            strengthIndicator.className = 'password-strength weak';
            feedback = 'Weak password';
            break;
        case 2:
        case 3:
            strengthIndicator.className = 'password-strength medium';
            feedback = 'Medium strength';
            break;
        case 4:
        case 5:
            strengthIndicator.className = 'password-strength strong';
            feedback = 'Strong password';
            break;
    }
    
    strengthIndicator.textContent = feedback;
}

/**
 * Validate password match
 */
function validatePasswordMatch() {
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    
    if (confirmPassword.value && newPassword.value !== confirmPassword.value) {
        showFieldError(confirmPassword, 'Passwords do not match');
    } else {
        clearFieldError(confirmPassword);
    }
}

/**
 * Reset password form
 */
function resetPasswordForm() {
    const form = document.getElementById('passwordForm');
    if (form) {
        form.reset();
        clearAllErrors();
        
        // Clear password strength indicator
        const strengthIndicator = document.getElementById('passwordStrength');
        if (strengthIndicator) {
            strengthIndicator.textContent = '';
            strengthIndicator.className = 'password-strength';
        }
    }
}

/**
 * Validate individual field
 */
function validateField(field) {
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    if (field.type === 'email' && value && !isValidEmail(value)) {
        showFieldError(field, 'Please enter a valid email address');
        return false;
    }
    
    clearFieldError(field);
    return true;
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    field.classList.add('is-invalid');
    field.classList.remove('is-valid');
    
    const feedback = field.parentNode.querySelector('.invalid-feedback');
    if (feedback) {
        feedback.textContent = message;
    }
}

/**
 * Clear field error
 */
function clearFieldError(field) {
    field.classList.remove('is-invalid');
    if (field.value.trim()) {
        field.classList.add('is-valid');
    } else {
        field.classList.remove('is-valid');
    }
    
    const feedback = field.parentNode.querySelector('.invalid-feedback');
    if (feedback) {
        feedback.textContent = '';
    }
}

/**
 * Clear all form errors
 */
function clearAllErrors() {
    const invalidFields = document.querySelectorAll('.is-invalid');
    invalidFields.forEach(field => {
        clearFieldError(field);
    });
}

/**
 * Display form errors from server
 */
function displayFormErrors(errors) {
    Object.keys(errors).forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            showFieldError(field, errors[fieldName]);
        }
    });
}

/**
 * Utility Functions
 */

// Validate email format
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Show toast notification
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

// Debounce function
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

// Export functions for global access
window.UserProfile = {
    handleAvatarUpload,
    uploadAvatar,
    handlePasswordSubmit,
    validatePasswordForm,
    showToast
};

console.log('📦 User Profile JavaScript loaded successfully');