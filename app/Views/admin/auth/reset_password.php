<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Reset Password - INLISLite v3' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .reset-container {
            max-width: 400px;
            width: 100%;
        }
        
        .reset-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .reset-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            border-radius: 20px 20px 0 0;
        }
        
        .reset-header h3 {
            margin: 0;
            font-weight: 600;
        }
        
        .reset-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        .reset-body {
            padding: 2rem;
        }
        
        .form-floating {
            margin-bottom: 1rem;
        }
        
        .form-floating > .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 1rem 0.75rem;
            height: auto;
            transition: all 0.3s ease;
        }
        
        .form-floating > .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .form-floating > label {
            padding: 1rem 0.75rem;
            color: #6c757d;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            z-index: 10;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .password-toggle:hover {
            color: #495057;
        }
        
        .password-strength {
            margin-top: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .strength-meter {
            height: 4px;
            background-color: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }
        
        .strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .strength-text {
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .btn-reset {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .alert {
            border: none;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        
        .invalid-feedback {
            display: block;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }
        
        .back-to-login {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .back-to-login:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        @media (max-width: 576px) {
            .reset-container {
                margin: 1rem;
            }
            
            .reset-header,
            .reset-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="reset-container">
                    <div class="card reset-card">
                        <div class="reset-header">
                            <div class="logo">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <h3>Reset Password</h3>
                            <p>Enter your new password</p>
                        </div>
                        
                        <div class="reset-body">
                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success" role="alert">
                                    <i class="bi bi-check-circle me-2"></i>
                                    <?= session()->getFlashdata('success') ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <p class="text-muted">
                                    Please enter your new password. Make sure it's strong and secure.
                                </p>
                            </div>
                            
                            <?= form_open('/reset-password/update', ['id' => 'resetForm', 'novalidate' => true]) ?>
                                <?= csrf_field() ?>
                                <input type="hidden" name="token" value="<?= $token ?>">
                                
                                <!-- New Password Field -->
                                <div class="form-floating position-relative">
                                    <input type="password" 
                                           class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                                           id="password" 
                                           name="password" 
                                           placeholder="New Password"
                                           required
                                           style="padding-right: 45px;">
                                    <label for="password">
                                        <i class="bi bi-lock me-2"></i>New Password
                                    </label>
                                    <button type="button" class="password-toggle" id="togglePassword">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                    <?php if ($validation->hasError('password')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('password') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Password Strength Meter -->
                                <div class="password-strength" id="passwordStrength" style="display: none;">
                                    <div class="strength-meter">
                                        <div class="strength-bar" id="strengthBar"></div>
                                    </div>
                                    <div class="strength-text" id="strengthText">Enter a password</div>
                                </div>
                                
                                <!-- Confirm Password Field -->
                                <div class="form-floating position-relative">
                                    <input type="password" 
                                           class="form-control <?= $validation->hasError('password_confirm') ? 'is-invalid' : '' ?>" 
                                           id="password_confirm" 
                                           name="password_confirm" 
                                           placeholder="Confirm New Password"
                                           required
                                           style="padding-right: 45px;">
                                    <label for="password_confirm">
                                        <i class="bi bi-lock me-2"></i>Confirm New Password
                                    </label>
                                    <button type="button" class="password-toggle" id="togglePasswordConfirm">
                                        <i class="bi bi-eye" id="toggleIconConfirm"></i>
                                    </button>
                                    <?php if ($validation->hasError('password_confirm')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('password_confirm') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Reset Button -->
                                <button type="submit" class="btn btn-primary btn-reset w-100" id="resetBtn">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" id="resetSpinner" style="display: none;"></span>
                                    <i class="bi bi-check-circle me-2" id="resetIcon"></i>
                                    Update Password
                                </button>
                            <?= form_close() ?>
                            
                            <!-- Back to Login Link -->
                            <div class="text-center mt-3">
                                <a href="/loginpage" class="back-to-login">
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Back to Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const passwordConfirmInput = document.getElementById('password_confirm');
            const toggleIconConfirm = document.getElementById('toggleIconConfirm');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'password') {
                    toggleIcon.className = 'bi bi-eye';
                } else {
                    toggleIcon.className = 'bi bi-eye-slash';
                }
            });
            
            togglePasswordConfirm.addEventListener('click', function() {
                const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmInput.setAttribute('type', type);
                
                if (type === 'password') {
                    toggleIconConfirm.className = 'bi bi-eye';
                } else {
                    toggleIconConfirm.className = 'bi bi-eye-slash';
                }
            });
            
            // Password strength checker
            const passwordStrength = document.getElementById('passwordStrength');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                
                if (password.length === 0) {
                    passwordStrength.style.display = 'none';
                    return;
                }
                
                passwordStrength.style.display = 'block';
                checkPasswordStrength(password);
            });
            
            function checkPasswordStrength(password) {
                let score = 0;
                let feedback = [];
                
                // Length check
                if (password.length >= 8) {
                    score += 1;
                } else {
                    feedback.push('At least 8 characters');
                }
                
                // Lowercase check
                if (/[a-z]/.test(password)) {
                    score += 1;
                } else {
                    feedback.push('One lowercase letter');
                }
                
                // Uppercase check
                if (/[A-Z]/.test(password)) {
                    score += 1;
                } else {
                    feedback.push('One uppercase letter');
                }
                
                // Number check
                if (/[0-9]/.test(password)) {
                    score += 1;
                } else {
                    feedback.push('One number');
                }
                
                // Special character check
                if (/[@#$%^&*()[\]{}]/.test(password)) {
                    score += 1;
                } else {
                    feedback.push('One special character (@#$%^&*()[]{})');
                }
                
                // Common password check
                const weakPasswords = ['123456', '123456789', 'qwerty', 'password', 'admin', 'administrator'];
                if (weakPasswords.includes(password.toLowerCase())) {
                    score = Math.max(0, score - 2);
                    feedback.push('Avoid common passwords');
                }
                
                updateStrengthMeter(score, feedback);
            }
            
            function updateStrengthMeter(score, feedback) {
                const percentage = (score / 5) * 100;
                const strengthLevels = [
                    { text: 'Very Weak', class: 'text-danger', color: '#dc3545' },
                    { text: 'Weak', class: 'text-warning', color: '#fd7e14' },
                    { text: 'Fair', class: 'text-info', color: '#0dcaf0' },
                    { text: 'Good', class: 'text-primary', color: '#0d6efd' },
                    { text: 'Strong', class: 'text-success', color: '#198754' },
                    { text: 'Very Strong', class: 'text-success', color: '#198754' }
                ];
                
                const level = strengthLevels[Math.min(score, 5)];
                
                strengthBar.style.width = percentage + '%';
                strengthBar.style.backgroundColor = level.color;
                strengthText.textContent = level.text;
                strengthText.className = 'strength-text ' + level.class;
                
                if (feedback.length > 0 && score < 4) {
                    strengthText.textContent += ' - Need: ' + feedback.slice(0, 2).join(', ');
                }
            }
            
            // Form submission handling
            const resetForm = document.getElementById('resetForm');
            const resetBtn = document.getElementById('resetBtn');
            const resetSpinner = document.getElementById('resetSpinner');
            const resetIcon = document.getElementById('resetIcon');
            
            resetForm.addEventListener('submit', function(e) {
                // Show loading state
                resetBtn.disabled = true;
                resetSpinner.style.display = 'inline-block';
                resetIcon.style.display = 'none';
                resetBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Updating...';
                
                // Basic client-side validation
                const password = passwordInput.value;
                const passwordConfirm = passwordConfirmInput.value;
                
                if (!password || !passwordConfirm) {
                    e.preventDefault();
                    showAlert('Please fill in all required fields.', 'danger');
                    resetResetButton();
                    return;
                }
                
                if (password.length < 8) {
                    e.preventDefault();
                    showAlert('Password must be at least 8 characters long.', 'danger');
                    resetResetButton();
                    return;
                }
                
                if (password !== passwordConfirm) {
                    e.preventDefault();
                    showAlert('Password confirmation does not match.', 'danger');
                    resetResetButton();
                    return;
                }
                
                // Check password complexity
                if (!isPasswordComplex(password)) {
                    e.preventDefault();
                    showAlert('Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.', 'danger');
                    resetResetButton();
                    return;
                }
            });
            
            function isPasswordComplex(password) {
                const hasLower = /[a-z]/.test(password);
                const hasUpper = /[A-Z]/.test(password);
                const hasNumber = /[0-9]/.test(password);
                const hasSpecial = /[@#$%^&*()[\]{}]/.test(password);
                
                return hasLower && hasUpper && hasNumber && hasSpecial;
            }
            
            function resetResetButton() {
                resetBtn.disabled = false;
                resetSpinner.style.display = 'none';
                resetIcon.style.display = 'inline-block';
                resetBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Update Password';
            }
            
            function showAlert(message, type) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
                alertDiv.innerHTML = `
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                const resetBody = document.querySelector('.reset-body');
                resetBody.insertBefore(alertDiv, resetBody.firstChild);
                
                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
            
            // Auto-focus password field
            passwordInput.focus();
        });
    </script>
</body>
</html>