/**
 * Profile Page JavaScript - New Implementation
 * Handles profile photo upload, name update, and password change
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Profile page loaded');
    
    // Initialize components
    initializePhotoUpload();
    initializeNameForm();
    initializePasswordForm();
    initializePasswordToggle();
});

/**
 * Initialize profile photo upload functionality
 */
function initializePhotoUpload() {
    const avatarInput = document.getElementById('avatarInput');
    const changePhotoBtn = document.getElementById('changePhotoBtn');
    const avatarUpload = document.getElementById('avatarUpload');

    // Trigger file input when button is clicked
    if (changePhotoBtn) {
        changePhotoBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Change photo button clicked');
            avatarInput.click();
        });
    }

    // Trigger file input when avatar overlay is clicked
    if (avatarUpload) {
        avatarUpload.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Avatar overlay clicked');
            avatarInput.click();
        });
    }

    // Handle file selection
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            console.log('File selected:', file);
            
            if (file) {
                uploadProfilePhoto(file);
            }
        });
    }
}

/**
 * Upload profile photo
 */
function uploadProfilePhoto(file) {
    console.log('Starting photo upload for file:', file.name);
    
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
        showAlert('File type not allowed. Please use JPG, PNG, or GIF', 'danger');
        return;
    }

    // Validate file size (max 2MB)
    const maxSize = 2 * 1024 * 1024; // 2MB
    if (file.size > maxSize) {
        showAlert('File size too large. Maximum 2MB allowed', 'danger');
        return;
    }

    // Show loading state
    const changePhotoBtn = document.getElementById('changePhotoBtn');
    const originalText = changePhotoBtn.innerHTML;
    changePhotoBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Uploading...';
    changePhotoBtn.disabled = true;

    // Create FormData
    const formData = new FormData();
    formData.append('profile_photo', file);
    
    // Add CSRF token if available
    const csrfToken = document.querySelector('input[name="csrf_token"]');
    if (csrfToken) {
        formData.append('csrf_token', csrfToken.value);
    }

    console.log('Uploading file:', {
        name: file.name,
        size: file.size,
        type: file.type,
        lastModified: file.lastModified
    });

    // Upload file (using test route for now)
    fetch('/test-upload-photo', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response received:', {
            status: response.status,
            statusText: response.statusText,
            ok: response.ok
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Upload response:', data);
        
        if (data.success) {
            // Update avatar image
            updateAvatarDisplay(data.photo_url);
            showAlert(data.message, 'success');
            console.log('Photo upload successful:', data.photo_url);
        } else {
            showAlert(data.message || 'Upload failed', 'danger');
            console.error('Upload failed:', data.message);
        }
    })
    .catch(error => {
        console.error('Upload error:', error);
        showAlert('Upload failed: ' + error.message, 'danger');
    })
    .finally(() => {
        // Reset button state
        changePhotoBtn.innerHTML = originalText;
        changePhotoBtn.disabled = false;
        
        // Clear file input
        document.getElementById('avatarInput').value = '';
    });
}

/**
 * Update avatar display with new photo
 */
function updateAvatarDisplay(photoUrl) {
    const avatarImage = document.getElementById('avatarImage');
    const avatarInitials = document.getElementById('avatarInitials');
    const profileAvatar = document.getElementById('profileAvatar');
    
    // Hide initials if they exist
    if (avatarInitials) {
        avatarInitials.style.display = 'none';
    }
    
    // Update or create image element
    if (avatarImage) {
        avatarImage.src = photoUrl + '?t=' + Date.now(); // Add timestamp to prevent caching
        avatarImage.style.display = 'block';
    } else {
        // Create new image element
        const newImage = document.createElement('img');
        newImage.id = 'avatarImage';
        newImage.src = photoUrl + '?t=' + Date.now();
        newImage.alt = 'Profile Picture';
        newImage.style.width = '100%';
        newImage.style.height = '100%';
        newImage.style.objectFit = 'cover';
        newImage.style.borderRadius = '50%';
        
        if (profileAvatar) {
            profileAvatar.appendChild(newImage);
        }
    }
}

/**
 * Initialize name form
 */
function initializeNameForm() {
    const nameForm = document.getElementById('nameForm');
    
    if (nameForm) {
        nameForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updateName();
        });
    }
}

/**
 * Update name
 */
function updateName() {
    const form = document.getElementById('nameForm');
    const formData = new FormData(form);
    const updateBtn = document.getElementById('updateNameBtn');
    
    // Validate required fields
    const namaLengkap = formData.get('nama_lengkap');
    const namaPengguna = formData.get('nama_pengguna');
    
    if (!namaLengkap || namaLengkap.trim() === '') {
        showAlert('Full name is required', 'danger');
        return;
    }
    
    if (!namaPengguna || namaPengguna.trim() === '') {
        showAlert('Username is required', 'danger');
        return;
    }
    
    // Show loading state
    const originalText = updateBtn.innerHTML;
    updateBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Updating...';
    updateBtn.disabled = true;

    fetch('/admin/profile/update', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update profile name display
            const profileName = document.querySelector('.profile-name');
            const profileUsername = document.querySelector('.profile-username');
            
            if (profileName && namaLengkap) {
                profileName.textContent = namaLengkap;
            }
            if (profileUsername && namaPengguna) {
                profileUsername.textContent = '@' + namaPengguna;
            }

            showAlert(data.message, 'success');
            console.log('Profile name updated successfully');
        } else {
            if (data.errors) {
                displayFormErrors(form, data.errors);
            } else {
                showAlert(data.message, 'danger');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Failed to update name', 'danger');
    })
    .finally(() => {
        // Reset button state
        updateBtn.innerHTML = originalText;
        updateBtn.disabled = false;
    });
}

/**
 * Initialize password form
 */
function initializePasswordForm() {
    const passwordForm = document.getElementById('passwordForm');
    
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updatePassword();
        });
    }

    // Password confirmation validation
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    
    if (confirmPassword) {
        confirmPassword.addEventListener('input', function() {
            if (newPassword.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Passwords do not match');
                confirmPassword.classList.add('is-invalid');
            } else {
                confirmPassword.setCustomValidity('');
                confirmPassword.classList.remove('is-invalid');
            }
        });
    }
}

/**
 * Update password
 */
function updatePassword() {
    const form = document.getElementById('passwordForm');
    const formData = new FormData(form);
    const updateBtn = document.getElementById('updatePasswordBtn');
    
    // Validate password fields
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (!currentPassword || currentPassword.trim() === '') {
        showAlert('Current password is required', 'danger');
        return;
    }
    
    if (!newPassword || newPassword.trim() === '') {
        showAlert('New password is required', 'danger');
        return;
    }
    
    if (newPassword.length < 6) {
        showAlert('New password must be at least 6 characters', 'danger');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        showAlert('New password and confirmation do not match', 'danger');
        return;
    }

    // Show loading state
    const originalText = updateBtn.innerHTML;
    updateBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Updating...';
    updateBtn.disabled = true;

    fetch('/admin/profile/change-password', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Clear form
            form.reset();
            showAlert(data.message, 'success');
            console.log('Password updated successfully');
        } else {
            if (data.errors) {
                displayFormErrors(form, data.errors);
            } else {
                showAlert(data.message, 'danger');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Failed to update password', 'danger');
    })
    .finally(() => {
        // Reset button state
        updateBtn.innerHTML = originalText;
        updateBtn.disabled = false;
    });
}

/**
 * Initialize password toggle functionality
 */
function initializePasswordToggle() {
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
 * Display form validation errors
 */
function displayFormErrors(form, errors) {
    // Clear previous errors
    const invalidFeedbacks = form.querySelectorAll('.invalid-feedback');
    const invalidInputs = form.querySelectorAll('.is-invalid');
    
    invalidFeedbacks.forEach(feedback => feedback.textContent = '');
    invalidInputs.forEach(input => input.classList.remove('is-invalid'));
    
    // Display new errors
    Object.keys(errors).forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        const feedback = field ? field.parentNode.querySelector('.invalid-feedback') : null;
        
        if (field && feedback) {
            field.classList.add('is-invalid');
            feedback.textContent = errors[fieldName];
        }
    });
}

/**
 * Show alert message
 */
function showAlert(message, type) {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert alert at the top of the page content
    const pageContainer = document.querySelector('.page-container');
    const pageHeader = document.querySelector('.page-header');
    
    if (pageContainer && pageHeader) {
        pageContainer.insertBefore(alertDiv, pageHeader.nextSibling);
    }
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}