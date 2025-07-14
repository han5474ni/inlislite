<?= $this->extend('admin/layout/admin_layout') ?>

<?= $this->section('head') ?>
<!-- Custom CSS for Profile Page -->
<link href="<?= base_url('assets/css/admin/profile.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="page-header">
    <div class="header-top">
        <div class="header-left">
            <div class="header-icon">
                <i class="bi bi-person-circle"></i>
            </div>
            <div>
                <h1 class="page-title">User Profile</h1>
                <p class="page-subtitle">Manage your account information and settings</p>
            </div>
        </div>
    </div>
            </div>

            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- This section has been removed to eliminate duplicate profile information -->
    </div>

    <!-- Profile Content -->
    <div class="container">
        <div class="row">
            <!-- Profile Information Section -->
            <div class="col-lg-4 mb-4">
                <div class="profile-info-section">
                    <div class="section-header">
                        <h2 class="section-title">Profile Information</h2>
                    </div>
                    <div class="profile-content p-4">
                        <!-- Profile Photo -->
                        <div class="profile-photo-container mb-4 text-center">
                            <?php if (isset($user['foto_url']) && $user['foto_url']): ?>
                                <img src="<?= $user['foto_url'] ?>" alt="Profile Photo" class="profile-photo">
                            <?php else: ?>
                                <div class="profile-avatar">
                                    <span><?= $user['avatar_initials'] ?? 'U' ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="mt-3">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="changePhotoBtn">
                                    <i class="bi bi-camera"></i> Change Photo
                                </button>
                            </div>
                        </div>
                        
                        <!-- Profile Details -->
                        <div class="profile-details-grid">
                            <div class="profile-detail-card">
                                <div class="detail-icon">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div class="detail-content">
                                    <div class="detail-label">Full Name</div>
                                    <div class="detail-value"><?= $user['nama_lengkap'] ?? $user['nama'] ?? 'Not set' ?></div>
                                </div>
                            </div>
                            
                            <div class="profile-detail-card">
                                <div class="detail-icon">
                                    <i class="bi bi-at"></i>
                                </div>
                                <div class="detail-content">
                                    <div class="detail-label">Username</div>
                                    <div class="detail-value">@<?= $user['nama_pengguna'] ?? $user['username'] ?? 'Not set' ?></div>
                                </div>
                            </div>
                            
                            <div class="profile-detail-card">
                                <div class="detail-icon">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                                <div class="detail-content">
                                    <div class="detail-label">Email</div>
                                    <div class="detail-value"><?= $user['email'] ?? 'Not set' ?></div>
                                </div>
                            </div>
                            
                            <div class="profile-detail-card">
                                <div class="detail-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div class="detail-content">
                                    <div class="detail-label">Role</div>
                                    <div class="detail-value">
                                        <?php 
                                        $roleClass = 'bg-primary';
                                        switch($user['role'] ?? 'User') {
                                            case 'Super Admin': $roleClass = 'bg-danger'; break;
                                            case 'Admin': $roleClass = 'bg-primary'; break;
                                            case 'Pustakawan': $roleClass = 'bg-success'; break;
                                            case 'Staff': $roleClass = 'bg-info'; break;
                                        }
                                        ?>
                                        <span class="badge <?= $roleClass ?>"><?= $user['role'] ?? 'User' ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="profile-detail-card">
                                <div class="detail-icon">
                                    <i class="bi bi-circle-fill <?= ($user['status'] ?? '') == 'Aktif' ? 'text-success' : 'text-secondary' ?>"></i>
                                </div>
                                <div class="detail-content">
                                    <div class="detail-label">Status</div>
                                    <div class="detail-value">
                                        <?php if (isset($user['status'])): ?>
                                            <?php if ($user['status'] == 'Aktif'): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php elseif ($user['status'] == 'Non-Aktif'): ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Suspended</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Unknown</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="profile-detail-card">
                                <div class="detail-icon">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div class="detail-content">
                                    <div class="detail-label">Last Login</div>
                                    <div class="detail-value"><?= $user['last_login_formatted'] ?? 'Belum pernah login' ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Edit Profile Section -->
            <div class="col-lg-8">
                <!-- Edit Name Section -->
                <div class="edit-name-section mb-4">
                    <div class="section-header">
                        <h2 class="section-title">Edit Profile</h2>
                    </div>
                    <div class="p-4">
                        <form id="profileForm" class="needs-validation" novalidate>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="nama_lengkap" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $user['nama_lengkap'] ?? '' ?>" required>
                                    <div class="invalid-feedback">Full name is required</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="nama_pengguna" class="form-label">
                                        Username
                                        <?php if (($user['role'] ?? '') !== 'Super Admin'): ?>
                                            <span class="text-muted small">(Only Super Admin can edit)</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" 
                                           value="<?= $user['nama_pengguna'] ?? $user['username'] ?? '' ?>" 
                                           <?= ($user['role'] ?? '') !== 'Super Admin' ? 'readonly' : 'required' ?>>
                                    <?php if (($user['role'] ?? '') === 'Super Admin'): ?>
                                        <div class="invalid-feedback">Username is required</div>
                                    <?php else: ?>
                                        <div class="form-text text-muted">
                                            <i class="bi bi-lock-fill"></i> Only Super Admin can change username
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="email" class="form-label">
                                        Email
                                        <?php if (($user['role'] ?? '') !== 'Super Admin'): ?>
                                            <span class="text-muted small">(Only Super Admin can edit)</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= $user['email'] ?? '' ?>" 
                                           <?= ($user['role'] ?? '') !== 'Super Admin' ? 'readonly' : 'required' ?>>
                                    <?php if (($user['role'] ?? '') === 'Super Admin'): ?>
                                        <div class="invalid-feedback">A valid email address is required</div>
                                    <?php else: ?>
                                        <div class="form-text text-muted">
                                            <i class="bi bi-lock-fill"></i> Only Super Admin can change email
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?= $user['phone'] ?? '' ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="2"><?= $user['address'] ?? '' ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea class="form-control" id="bio" name="bio" rows="3"><?= $user['bio'] ?? '' ?></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="saveProfileBtn">
                                    <i class="bi bi-check-circle"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Change Password Section -->
                <div class="password-section mb-4">
                    <div class="section-header">
                        <h2 class="section-title">Change Password</h2>
                    </div>
                    <div class="p-4">
                        <form id="passwordForm" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Current password is required</div>
                            </div>
                            <div class="mb-3">
                                <label for="kata_sandi" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="kata_sandi" name="kata_sandi" required minlength="6">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="kata_sandi">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">New password must be at least 6 characters</div>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Confirmation must match new password</div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="changePasswordBtn">
                                    <i class="bi bi-lock"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Photo Modal -->
    <div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadPhotoModalLabel">Upload Profile Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="photoForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="profile_photo" class="form-label">Select Photo</label>
                            <input class="form-control" type="file" id="profile_photo" name="profile_photo" accept="image/*" required>
                            <div class="form-text">Maximum file size: 2MB. Supported formats: JPG, PNG, GIF</div>
                        </div>
                        <div id="photoPreviewContainer" class="text-center mb-3" style="display: none;">
                            <img id="photoPreview" src="#" alt="Preview" style="max-width: 100%; max-height: 200px;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="uploadPhotoBtn">Upload</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="toast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-info-circle me-2"></i>
                <strong class="me-auto" id="toastTitle">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage"></div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize forms
        const profileForm = document.getElementById('profileForm');
        const passwordForm = document.getElementById('passwordForm');
        const photoForm = document.getElementById('photoForm');
        
        // Photo preview
        const photoInput = document.getElementById('profile_photo');
        const photoPreview = document.getElementById('photoPreview');
        const photoPreviewContainer = document.getElementById('photoPreviewContainer');
        
        if (photoInput) {
            photoInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                        photoPreviewContainer.style.display = 'block';
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        // Toggle password visibility
        const toggleButtons = document.querySelectorAll('.toggle-password');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
        
        // Open photo modal
        const changePhotoBtn = document.getElementById('changePhotoBtn');
        if (changePhotoBtn) {
            changePhotoBtn.addEventListener('click', function() {
                const uploadPhotoModal = new bootstrap.Modal(document.getElementById('uploadPhotoModal'));
                uploadPhotoModal.show();
            });
        }
        
        // Upload photo
        const uploadPhotoBtn = document.getElementById('uploadPhotoBtn');
        if (uploadPhotoBtn) {
            uploadPhotoBtn.addEventListener('click', function() {
                if (!photoForm.checkValidity()) {
                    photoForm.classList.add('was-validated');
                    return;
                }
                
                const formData = new FormData();
                formData.append('profile_photo', photoInput.files[0]);
                
                fetch('<?= base_url('admin/profile/upload-photo') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Success', data.message, 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showToast('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error', 'An error occurred while uploading the photo', 'error');
                });
            });
        }
        
        // Save profile changes
        if (profileForm) {
            profileForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!this.checkValidity()) {
                    this.classList.add('was-validated');
                    return;
                }
                
                const formData = new FormData(this);
                
                fetch('<?= base_url('admin/profile/update') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Success', data.message, 'success');
                    } else {
                        showToast('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error', 'An error occurred while saving profile', 'error');
                });
            });
        }
        
        // Change password
        if (passwordForm) {
            passwordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!this.checkValidity()) {
                    this.classList.add('was-validated');
                    return;
                }
                
                // Check if passwords match
                const password = document.getElementById('kata_sandi').value;
                const confirmPassword = document.getElementById('confirm_password').value;
                
                if (password !== confirmPassword) {
                    document.getElementById('confirm_password').setCustomValidity('Passwords do not match');
                    this.classList.add('was-validated');
                    return;
                }
                
                const formData = new FormData(this);
                
                fetch('<?= base_url('admin/profile/update') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Success', data.message, 'success');
                        this.reset();
                        this.classList.remove('was-validated');
                    } else {
                        showToast('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error', 'An error occurred while changing password', 'error');
                });
            });
            
            // Reset custom validity when typing
            document.getElementById('confirm_password').addEventListener('input', function() {
                this.setCustomValidity('');
            });
        }
        
        // Show toast notification
        function showToast(title, message, type = 'info') {
            const toast = document.getElementById('toast');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');
            
            // Set content
            toastTitle.textContent = title;
            toastMessage.textContent = message;
            
            // Set color based on type
            toast.classList.remove('bg-success', 'bg-danger', 'bg-info');
            if (type === 'success') {
                toast.classList.add('bg-success', 'text-white');
            } else if (type === 'error') {
                toast.classList.add('bg-danger', 'text-white');
            } else {
                toast.classList.add('bg-info', 'text-white');
            }
            
            // Show toast
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        }
    });
    
    // Confirm logout
    function confirmLogout() {
        return confirm('Are you sure you want to logout?');
    }
</script>
<?= $this->endSection() ?>

<!-- These duplicate sections have been removed as they're already included above -->
        </div>
    </main>

    <!-- Toast Container -->
    <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;"></div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url('assets/js/admin/profile.js') ?>"></script>
    
</body>
</html>