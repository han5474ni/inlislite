/**
 * Profile Page JavaScript
 * Handles profile photo upload, name update, and password change
 */

document.addEventListener('DOMContentLoaded', function() {
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
    const profileAvatar = document.getElementById('profileAvatar');

    // Trigger file input when button is clicked
    if (changePhotoBtn) {
        changePhotoBtn.addEventListener('click', function() {
            avatarInput.click();
        });
    }

    // Trigger file input when avatar overlay is clicked
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
                uploadProfilePhoto(file);
            }
        });
    }
}

/**
 * Upload profile photo
 */
function uploadProfilePhoto(file) {
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
        if (typeof showToast === 'function') {
            showToast('Tipe file tidak diizinkan. Gunakan JPG, PNG, atau GIF', 'error');
        } else {
            alert('Tipe file tidak diizinkan. Gunakan JPG, PNG, atau GIF');
        }
        return;
    }

    // Validate file size (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
        if (typeof showToast === 'function') {
            showToast('Ukuran file terlalu besar. Maksimal 2MB', 'error');
        } else {
            alert('Ukuran file terlalu besar. Maksimal 2MB');
        }
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

    // Upload file
    fetch('/admin/profile/upload-photo', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update avatar image
            const avatarImage = document.getElementById('avatarImage');
            const avatarInitials = document.getElementById('avatarInitials');
            
            if (avatarInitials) {
                avatarInitials.style.display = 'none';
            }
            
            if (avatarImage) {
                avatarImage.src = data.photo_url;
                avatarImage.style.display = 'block';
            } else {
                // Create new image element
                const newImage = document.createElement('img');
                newImage.id = 'avatarImage';
                newImage.src = data.photo_url;
                newImage.alt = 'Profile Picture';
                document.getElementById('profileAvatar').appendChild(newImage);
            }

            if (typeof showToast === 'function') {
                showToast(data.message, 'success');
            } else {
                alert(data.message);
            }
            
            // Log the successful photo upload
            console.log('Profile photo uploaded successfully:', data.photo_url);
        } else {
            if (typeof showToast === 'function') {
                showToast(data.message, 'error');
            } else {
                alert(data.message);
            }
            console.error('Photo upload failed:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof showToast === 'function') {
            showToast('Terjadi kesalahan saat mengupload foto', 'error');
        } else {
            alert('Terjadi kesalahan saat mengupload foto');
        }
    })
    .finally(() => {
        // Reset button state
        changePhotoBtn.innerHTML = originalText;
        changePhotoBtn.disabled = false;
    });
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
        if (typeof showToast === 'function') {
            showToast('Nama lengkap harus diisi', 'error');
        } else {
            alert('Nama lengkap harus diisi');
        }
        return;
    }
    
    if (!namaPengguna || namaPengguna.trim() === '') {
        if (typeof showToast === 'function') {
            showToast('Username harus diisi', 'error');
        } else {
            alert('Username harus diisi');
        }
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

            if (typeof showToast === 'function') {
                showToast(data.message, 'success');
            } else {
                alert(data.message);
            }
            
            // Log the successful update
            console.log('Profile name updated successfully:', {
                nama_lengkap: namaLengkap,
                nama_pengguna: namaPengguna
            });
        } else {
            if (data.errors) {
                displayFormErrors(form, data.errors);
            } else {
                if (typeof showToast === 'function') {
                    showToast(data.message, 'error');
                } else {
                    alert(data.message);
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof showToast === 'function') {
            showToast('Terjadi kesalahan saat mengupdate nama', 'error');
        } else {
            alert('Terjadi kesalahan saat mengupdate nama');
        }
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
                confirmPassword.setCustomValidity('Password tidak cocok');
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
    
    // Validate password confirmation
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (!currentPassword || currentPassword.trim() === '') {
        if (typeof showToast === 'function') {
            showToast('Password saat ini harus diisi', 'error');
        } else {
            alert('Password saat ini harus diisi');
        }
        return;
    }
    
    if (!newPassword || newPassword.trim() === '') {
        if (typeof showToast === 'function') {
            showToast('Password baru harus diisi', 'error');
        } else {
            alert('Password baru harus diisi');
        }
        return;
    }
    
    if (newPassword.length < 6) {
        if (typeof showToast === 'function') {
            showToast('Password baru minimal 6 karakter', 'error');
        } else {
            alert('Password baru minimal 6 karakter');
        }
        return;
    }
    
    if (newPassword !== confirmPassword) {
        if (typeof showToast === 'function') {
            showToast('Password baru dan konfirmasi password tidak cocok', 'error');
        } else {
            alert('Password baru dan konfirmasi password tidak cocok');
        }
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
            // Clear form
            form.reset();
            if (typeof showToast === 'function') {
                showToast(data.message, 'success');
            } else {
                alert(data.message);
            }
            
            // Log the successful password update
            console.log('Password updated successfully');
        } else {
            if (data.errors) {
                displayFormErrors(form, data.errors);
            } else {
                if (typeof showToast === 'function') {
                    showToast(data.message, 'error');
                } else {
                    alert(data.message);
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof showToast === 'function') {
            showToast('Terjadi kesalahan saat mengupdate password', 'error');
        } else {
            alert('Terjadi kesalahan saat mengupdate password');
        }
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
// Logout confirmation function
        function confirmLogout() {
            return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
        }

        // Initialize Feather icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });