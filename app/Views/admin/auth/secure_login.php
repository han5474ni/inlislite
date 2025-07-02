<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #34a853;
            --primary-blue: #007bff;
            --gradient-bg: linear-gradient(135deg, #007bff 0%, #34a853 100%);
            --text-dark: #212529;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
            --shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            --border-radius: 0.5rem;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--gradient-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
        }

        .login-card {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .login-header {
            background: var(--gradient-bg);
            color: white;
            padding: 2.5rem 2rem 2rem;
            text-align: center;
        }

        .logo-container {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: #ffd700;
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }

        .login-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: var(--transition);
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 0.25rem;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary-blue);
            background: rgba(0, 123, 255, 0.1);
        }

        .password-strength {
            margin-top: 0.5rem;
            padding: 0.75rem;
            border-radius: var(--border-radius);
            background: #f8f9fa;
            border: 1px solid var(--border-color);
            display: none;
        }

        .password-strength.show {
            display: block;
        }

        .strength-meter {
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            margin-bottom: 0.5rem;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            transition: var(--transition);
            border-radius: 3px;
        }

        .strength-very-weak { background: #dc3545; }
        .strength-weak { background: #fd7e14; }
        .strength-fair { background: #ffc107; }
        .strength-good { background: #20c997; }
        .strength-strong { background: #28a745; }

        .strength-text {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .strength-requirements {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .requirement {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .requirement.met {
            color: var(--primary-green);
        }

        .requirement.not-met {
            color: #dc3545;
        }

        .btn-login {
            background: var(--gradient-bg);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            width: 100%;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--primary-green);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .forgot-password {
            text-align: center;
            margin-top: 1.5rem;
        }

        .forgot-password a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .loading-spinner {
            display: none;
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-container {
                margin: 1rem;
            }
            
            .login-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .login-body {
                padding: 1.5rem;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-container">
                    <i class="bi bi-star-fill"></i>
                </div>
                <h1 class="login-title">INLISLite v3.0</h1>
                <p class="login-subtitle">Admin Login - Sistem Perpustakaan Digital</p>
            </div>
            
            <div class="login-body">
                <!-- Alert Messages -->
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
                
                <form id="loginForm" action="<?= base_url('admin/secure-login/authenticate') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <!-- Username Field -->
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <i class="bi bi-person me-2"></i>Username
                        </label>
                        <div class="input-wrapper">
                            <input type="text" 
                                   class="form-control" 
                                   id="username" 
                                   name="username" 
                                   placeholder="Masukkan username Anda"
                                   value="<?= old('username') ?>"
                                   required
                                   autocomplete="username">
                        </div>
                    </div>
                    
                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock me-2"></i>Password
                        </label>
                        <div class="password-wrapper">
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Masukkan password Anda"
                                   required
                                   autocomplete="current-password">
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        
                        <!-- Password Strength Indicator (for new password) -->
                        <div class="password-strength" id="passwordStrength">
                            <div class="strength-meter">
                                <div class="strength-bar" id="strengthBar"></div>
                            </div>
                            <div class="strength-text" id="strengthText">Masukkan password</div>
                            <div class="strength-requirements">
                                <div class="requirement not-met" id="req-length">
                                    <i class="bi bi-x-circle"></i>
                                    <span>Minimal 8 karakter</span>
                                </div>
                                <div class="requirement not-met" id="req-lowercase">
                                    <i class="bi bi-x-circle"></i>
                                    <span>Huruf kecil (a-z)</span>
                                </div>
                                <div class="requirement not-met" id="req-uppercase">
                                    <i class="bi bi-x-circle"></i>
                                    <span>Huruf besar (A-Z)</span>
                                </div>
                                <div class="requirement not-met" id="req-number">
                                    <i class="bi bi-x-circle"></i>
                                    <span>Angka (0-9)</span>
                                </div>
                                <div class="requirement not-met" id="req-special">
                                    <i class="bi bi-x-circle"></i>
                                    <span>Karakter khusus (@#$%^&*()[]{})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Remember Me -->
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe" name="remember_me" value="1">
                            <label class="form-check-label" for="rememberMe">
                                Ingat saya selama 30 hari
                            </label>
                        </div>
                    </div>
                    
                    <!-- Login Button -->
                    <button type="submit" class="btn btn-login" id="loginBtn">
                        <span class="spinner-border spinner-border-sm loading-spinner" role="status"></span>
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Masuk
                    </button>
                </form>
                
                <!-- Forgot Password Link -->
                <div class="forgot-password">
                    <a href="<?= base_url('admin/forgot-password') ?>">
                        <i class="bi bi-key me-1"></i>
                        Lupa password?
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const toggleIcon = document.getElementById('toggleIcon');
            const passwordStrength = document.getElementById('passwordStrength');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const loadingSpinner = document.querySelector('.loading-spinner');
            
            // Password toggle functionality
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'password') {
                    toggleIcon.className = 'bi bi-eye';
                } else {
                    toggleIcon.className = 'bi bi-eye-slash';
                }
            });
            
            // Password strength checker (only show when typing new password)
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                
                if (password.length > 0) {
                    passwordStrength.classList.add('show');
                    checkPasswordStrength(password);
                } else {
                    passwordStrength.classList.remove('show');
                }
            });
            
            // Hide password strength on focus out if empty
            passwordInput.addEventListener('blur', function() {
                if (this.value.length === 0) {
                    passwordStrength.classList.remove('show');
                }
            });
            
            // Form submission
            loginForm.addEventListener('submit', function(e) {
                const username = document.getElementById('username').value.trim();
                const password = document.getElementById('password').value;
                
                if (!username || !password) {
                    e.preventDefault();
                    showAlert('Username dan password harus diisi', 'danger');
                    return;
                }
                
                // Show loading state
                loginBtn.disabled = true;
                loadingSpinner.style.display = 'inline-block';
                loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
            });
            
            // Password strength checker function
            function checkPasswordStrength(password) {
                let score = 0;
                const requirements = {
                    length: password.length >= 8,
                    lowercase: /[a-z]/.test(password),
                    uppercase: /[A-Z]/.test(password),
                    number: /[0-9]/.test(password),
                    special: /[@#$%^&*()[\]{}]/.test(password)
                };
                
                // Update requirement indicators
                Object.keys(requirements).forEach(req => {
                    const element = document.getElementById(`req-${req}`);
                    const icon = element.querySelector('i');
                    
                    if (requirements[req]) {
                        element.classList.remove('not-met');
                        element.classList.add('met');
                        icon.className = 'bi bi-check-circle';
                        score++;
                    } else {
                        element.classList.remove('met');
                        element.classList.add('not-met');
                        icon.className = 'bi bi-x-circle';
                    }
                });
                
                // Check for common weak passwords
                const weakPasswords = [
                    'password', '123456', '123456789', 'qwerty', 'abc123',
                    'password123', 'admin', 'administrator', '12345678',
                    'welcome', 'login', 'root', 'toor', 'pass'
                ];
                
                const isWeak = weakPasswords.some(weak => 
                    password.toLowerCase().includes(weak.toLowerCase())
                );
                
                if (isWeak) score = Math.max(0, score - 2);
                
                // Check for repeated characters
                if (/(.)\1{2,}/.test(password)) score = Math.max(0, score - 1);
                
                // Check for sequential characters
                if (/123|abc|qwe/i.test(password)) score = Math.max(0, score - 1);
                
                // Update strength bar and text
                updateStrengthDisplay(score, password.length);
            }
            
            function updateStrengthDisplay(score, length) {
                const strengthLevels = [
                    { text: 'Sangat Lemah', class: 'strength-very-weak', width: 20 },
                    { text: 'Lemah', class: 'strength-weak', width: 40 },
                    { text: 'Cukup', class: 'strength-fair', width: 60 },
                    { text: 'Baik', class: 'strength-good', width: 80 },
                    { text: 'Kuat', class: 'strength-strong', width: 100 }
                ];
                
                const level = Math.min(score, strengthLevels.length - 1);
                const strength = strengthLevels[level];
                
                strengthBar.className = `strength-bar ${strength.class}`;
                strengthBar.style.width = `${strength.width}%`;
                strengthText.textContent = `Password ${strength.text}`;
                
                if (length === 0) {
                    strengthText.textContent = 'Masukkan password';
                    strengthBar.style.width = '0%';
                    strengthBar.className = 'strength-bar';
                }
            }
            
            function showAlert(message, type) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type}`;
                alertDiv.innerHTML = `
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    ${message}
                `;
                
                const loginBody = document.querySelector('.login-body');
                loginBody.insertBefore(alertDiv, loginBody.firstChild);
                
                setTimeout(() => {
                    alertDiv.remove();
                }, 5000);
            }
            
            // Auto-focus username field
            document.getElementById('username').focus();
        });
    </script>
</body>
</html>