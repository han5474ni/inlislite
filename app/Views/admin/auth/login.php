<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login - INLISLite v3.0' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(180deg, #2DA84D 0%, #004AAD 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
        }
        
        /* Top Navigation Bar */
        .top-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .back-arrow {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            margin-right: 1rem;
            padding: 0.5rem;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }
        
        .back-arrow:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .nav-title {
            color: white;
            font-size: 1.25rem;
            font-weight: bold;
            margin: 0;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6rem 1rem 2rem;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            width: 100%;
            max-width: 350px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .login-title {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: contain;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
            outline: none;
        }
        
        .form-control::placeholder {
            color: #6c757d;
        }
        
        .password-field {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            font-size: 1.1rem;
        }
        
        .password-toggle:hover {
            color: #495057;
        }
        
        .login-btn {
            background: #333333;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }
        
        .login-btn:hover {
            background: #222222;
            transform: translateY(-1px);
        }
        
        .login-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        
        .register-text {
            text-align: center;
            color: white;
            font-size: 14px;
        }
        
        .register-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link:hover {
            text-decoration: underline;
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 14px;
        }
        
        .invalid-feedback {
            display: block;
            color: #ff6b6b;
            font-size: 12px;
            margin-top: 0.25rem;
        }
        
        /* Responsive Design */
        @media (max-width: 576px) {
            .main-content {
                padding: 5rem 1rem 1rem;
            }
            
            .login-card {
                padding: 1.5rem;
            }
            
            .login-title {
                font-size: 20px;
            }
            
            .top-nav {
                padding: 0.75rem 1rem;
            }
            
            .nav-title {
                font-size: 1.1rem;
            }
        }
        
        /* Loading spinner */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <div class="top-nav">
        <button class="back-arrow" onclick="history.back()" title="Back">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h1 class="nav-title">Login</h1>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="login-card">
            <h2 class="login-title">Silahkan Login</h2>
            
            <!-- Logo -->
            <div class="logo-container">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="INLISLite Logo" class="logo">
            </div>
            
            <!-- Error/Success Messages -->
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
            
            <!-- Login Form -->
            <form action="<?= base_url('admin/login/authenticate') ?>" method="post" id="loginForm" novalidate>
                <?= csrf_field() ?>
                
                <!-- Username Field -->
                <div class="form-group">
                    <input type="text" 
                           class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" 
                           id="username" 
                           name="username" 
                           placeholder="Username atau Email"
                           value="<?= old('username') ?>"
                           required
                           autocomplete="username">
                    <?php if (isset($validation) && $validation->hasError('username')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('username') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Password Field -->
                <div class="form-group">
                    <div class="password-field">
                        <input type="password" 
                               class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                               id="password" 
                               name="password" 
                               placeholder="Password"
                               required
                               autocomplete="current-password">
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    <?php if (isset($validation) && $validation->hasError('password')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('password') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Login Button -->
                <button type="submit" class="login-btn" id="loginBtn">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" id="loginSpinner" style="display: none;"></span>
                    Login
                </button>
            </form>
            
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
            
            // Form submission handling - simplified
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const loginSpinner = document.getElementById('loginSpinner');
            
            loginForm.addEventListener('submit', function(e) {
                // Show loading state
                loginBtn.disabled = true;
                loginSpinner.style.display = 'inline-block';
                loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Logging in...';
                
                // Let form submit normally without validation
                console.log('Form submitting to:', loginForm.action);
            });
            
            function resetLoginButton() {
                loginBtn.disabled = false;
                loginSpinner.style.display = 'none';
                loginBtn.innerHTML = 'Login';
            }
            
            function showAlert(message, type) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
                alertDiv.innerHTML = `
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                const loginCard = document.querySelector('.login-card');
                loginCard.insertBefore(alertDiv, loginCard.querySelector('form'));
                
                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
            
            // Auto-focus username field
            document.getElementById('username').focus();
            
            // Handle Enter key navigation
            document.getElementById('username').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('password').focus();
                }
            });
            
            document.getElementById('password').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    loginForm.submit();
                }
            });
        });
    </script>
</body>
</html>