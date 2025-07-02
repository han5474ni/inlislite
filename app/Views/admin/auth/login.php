<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Login - INLISLite v3' ?></title>
    
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
        
        .login-container {
            max-width: 400px;
            width: 100%;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            border-radius: 20px 20px 0 0;
        }
        
        .login-header h3 {
            margin: 0;
            font-weight: 600;
        }
        
        .login-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        .login-body {
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
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .form-check {
            margin: 1.5rem 0;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
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
        
        .forgot-password-link {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .forgot-password-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        @media (max-width: 576px) {
            .login-container {
                margin: 1rem;
            }
            
            .login-header,
            .login-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="login-container">
                    <div class="card login-card">
                        <div class="login-header">
                            <div class="logo">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <h3>Admin Login</h3>
                            <p>INLISLite v3 Administration</p>
                        </div>
                        
                        <div class="login-body">
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
                                    <small>Reset link: <a href="<?= session()->getFlashdata('reset_link') ?>" target="_blank"><?= session()->getFlashdata('reset_link') ?></a></small>
                                </div>
                            <?php endif; ?>
                            
                            <form action="/loginpage/authenticate" method="post" id="loginForm" novalidate>
                                <?= csrf_field() ?>
                                
                                <!-- Username/Email Field -->
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" 
                                           id="username" 
                                           name="username" 
                                           placeholder="Username or Email"
                                           value="<?= old('username') ?>"
                                           required
                                           autocomplete="username">
                                    <label for="username">
                                        <i class="bi bi-person me-2"></i>Username or Email
                                    </label>
                                    <?php if (isset($validation) && $validation->hasError('username')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('username') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Password Field -->
                                <div class="form-floating position-relative">
                                    <input type="password" 
                                           class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Password"
                                           required
                                           autocomplete="current-password"
                                           style="padding-right: 45px;">
                                    <label for="password">
                                        <i class="bi bi-lock me-2"></i>Password
                                    </label>
                                    <button type="button" class="password-toggle" id="togglePassword">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                    <?php if (isset($validation) && $validation->hasError('password')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('password') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Remember Me -->
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="rememberMe" 
                                           name="remember_me" 
                                           value="1">
                                    <label class="form-check-label" for="rememberMe">
                                        Remember me for 30 days
                                    </label>
                                </div>
                                
                                <!-- Login Button -->
                                <button type="submit" class="btn btn-primary btn-login w-100" id="loginBtn">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" id="loginSpinner" style="display: none;"></span>
                                    <i class="bi bi-box-arrow-in-right me-2" id="loginIcon"></i>
                                    Sign In
                                </button>
                            </form>
                            
                            <!-- Forgot Password Link -->
                            <div class="text-center mt-3">
                                <a href="/forgot-password" class="forgot-password-link">
                                    <i class="bi bi-key me-1"></i>
                                    Forgot your password?
                                </a>
                            </div>
                            
                            <!-- Additional Links -->
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Admin access only. Contact system administrator for support.
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
            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'password') {
                    toggleIcon.className = 'bi bi-eye';
                } else {
                    toggleIcon.className = 'bi bi-eye-slash';
                }
            });
            
            // Form submission handling
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const loginSpinner = document.getElementById('loginSpinner');
            const loginIcon = document.getElementById('loginIcon');
            
            loginForm.addEventListener('submit', function(e) {
                // Show loading state
                loginBtn.disabled = true;
                loginSpinner.style.display = 'inline-block';
                loginIcon.style.display = 'none';
                loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Signing In...';
                
                // Basic client-side validation
                const username = document.getElementById('username').value.trim();
                const password = document.getElementById('password').value;
                
                if (!username || !password) {
                    e.preventDefault();
                    showAlert('Please fill in all required fields.', 'danger');
                    resetLoginButton();
                    return;
                }
                
                if (username.length < 3) {
                    e.preventDefault();
                    showAlert('Username or Email must be at least 3 characters long.', 'danger');
                    resetLoginButton();
                    return;
                }
                
                if (password.length < 8) {
                    e.preventDefault();
                    showAlert('Password must be at least 8 characters long.', 'danger');
                    resetLoginButton();
                    return;
                }
            });
            
            function resetLoginButton() {
                loginBtn.disabled = false;
                loginSpinner.style.display = 'none';
                loginIcon.style.display = 'inline-block';
                loginBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Sign In';
            }
            
            function showAlert(message, type) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
                alertDiv.innerHTML = `
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                const loginBody = document.querySelector('.login-body');
                loginBody.insertBefore(alertDiv, loginBody.firstChild);
                
                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
            
            // Auto-focus username field
            document.getElementById('username').focus();
            
            // Handle Enter key in username field
            document.getElementById('username').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('password').focus();
                }
            });
        });
    </script>
</body>
</html>