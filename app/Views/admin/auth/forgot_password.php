<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Forgot Password - INLISLite v3' ?></title>
    
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
        
        .forgot-container {
            max-width: 400px;
            width: 100%;
        }
        
        .forgot-card {
            background: rgb(255, 255, 255);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgb(0, 0, 0);
            overflow: hidden;
        }
        
        .forgot-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            border-radius: 20px 20px 0 0;
        }
        
        .forgot-header h3 {
            margin: 0;
            font-weight: 600;
        }
        
        .forgot-header p {
            margin: 0.5rem 0 0 0;
            opacity: 1;
            font-size: 0.9rem;
        }
        
        .forgot-body {
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
            box-shadow: 0 0 0 0.2rem rgb(102, 126, 234);
        }
        
        .form-floating > label {
            padding: 1rem 0.75rem;
            color: #6c757d;
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
            background: rgb(255, 255, 255);
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
        

        
        @media (max-width: 576px) {
            .forgot-container {
                margin: 1rem;
            }
            
            .forgot-header,
            .forgot-body {
                padding: 1.5rem;
            }
        } 
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="forgot-container">
                    <div class="card forgot-card">
                        <div class="forgot-header">
                            <div class="logo">
                                <i class="bi bi-key"></i>
                            </div>
                            <h3>Forgot Password</h3>
                            <p>Reset your admin password</p>
                        </div>
                        
                        <div class="forgot-body">
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
                            
                            <?php if (session()->getFlashdata('reset_link') && ENVIRONMENT === 'development'): ?>
                                <div class="alert alert-info" role="alert">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Development Mode:</strong><br>
                                    <small>Reset link: <a href="<?= session()->getFlashdata('reset_link') ?>" target="_blank" class="text-break"><?= session()->getFlashdata('reset_link') ?></a></small>
                                </div>
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <p class="text-muted">
                                    Enter your email address and we'll send you a link to reset your password.
                                </p>
                            </div>
                            
                            <?= form_open('/forgot-password/send', ['id' => 'forgotForm', 'novalidate' => true]) ?>
                                <?= csrf_field() ?>
                                
                                <!-- Email Field -->
                                <div class="form-floating">
                                    <input type="email" 
                                           class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                                           id="email" 
                                           name="email" 
                                           placeholder="Email Address"
                                           value="<?= old('email') ?>"
                                           required
                                           autocomplete="email">
                                    <label for="email">
                                        <i class="bi bi-envelope me-2"></i>Email Address
                                    </label>
                                    <?php if ($validation->hasError('email')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('email') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Reset Button -->
                                <button type="submit" class="btn btn-primary btn-reset w-100" id="resetBtn">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" id="resetSpinner" style="display: none;"></span>
                                    <i class="bi bi-send me-2" id="resetIcon"></i>
                                    Send Reset Link
                                </button>
                            <?= form_close() ?>
                            
                            <!-- Back to Login Link -->
                            <div class="text-center mt-3">
                                <a href="/loginpage" class="back-to-login">
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Back to Login
                                </a>
                            </div>
                            
                            <!-- Additional Info -->
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Only admin accounts can reset passwords.
                                </small>
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
            // Form submission handling
            const forgotForm = document.getElementById('forgotForm');
            const resetBtn = document.getElementById('resetBtn');
            const resetSpinner = document.getElementById('resetSpinner');
            const resetIcon = document.getElementById('resetIcon');
            
            forgotForm.addEventListener('submit', function(e) {
                // Show loading state
                resetBtn.disabled = true;
                resetSpinner.style.display = 'inline-block';
                resetIcon.style.display = 'none';
                resetBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending...';
                
                // Basic client-side validation
                const email = document.getElementById('email').value.trim();
                
                if (!email) {
                    e.preventDefault();
                    showAlert('Please enter your email address.', 'danger');
                    resetResetButton();
                    return;
                }
                
                if (!isValidEmail(email)) {
                    e.preventDefault();
                    showAlert('Please enter a valid email address.', 'danger');
                    resetResetButton();
                    return;
                }
            });
            
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
            
            function resetResetButton() {
                resetBtn.disabled = false;
                resetSpinner.style.display = 'none';
                resetIcon.style.display = 'inline-block';
                resetBtn.innerHTML = '<i class="bi bi-send me-2"></i>Send Reset Link';
            }
            
            function showAlert(message, type) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
                alertDiv.innerHTML = `
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                const forgotBody = document.querySelector('.forgot-body');
                forgotBody.insertBefore(alertDiv, forgotBody.firstChild);
                
                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
            
            // Auto-focus email field
            document.getElementById('email').focus();
        });
    </script>
</body>
</html>
