<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login Admin - INLISLite v3.0' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Perpusnas Branding Colors */
            --primary-blue: #004AAD;
            --primary-green: #65C371;
            --dark-blue: #003080;
            --light-blue: #1a5bb8;
            --dark-green: #4a9c54;
            --light-green: #7dd87f;
            
            /* Dark Theme Colors */
            --primary-dark: #0a1628;
            --secondary-dark: #1e293b;
            --tertiary-dark: #334155;
            
            /* Neutral Colors */
            --white: #ffffff;
            --gray-100: #f8fafc;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            
            /* Design System */
            --border-radius: 20px;
            --border-radius-small: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --glow-shadow: 0 0 30px rgba(101, 195, 113, 0.3);
            --card-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--dark-blue) 50%, var(--secondary-dark) 100%);
            position: relative;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Enhanced Blurred Background */
        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80') center/cover no-repeat;
            filter: blur(10px) brightness(0.2);
            z-index: -2;
        }

        .background-overlay::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(0, 74, 173, 0.8) 0%, 
                rgba(10, 22, 40, 0.9) 30%,
                rgba(101, 195, 113, 0.3) 70%,
                rgba(30, 41, 59, 0.9) 100%);
            z-index: 1;
        }

        /* Enhanced Animated Background Elements */
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, 
                rgba(101, 195, 113, 0.15), 
                rgba(0, 74, 173, 0.15));
            animation: float 8s ease-in-out infinite;
            box-shadow: 0 0 40px rgba(101, 195, 113, 0.2);
        }

        .floating-circle:nth-child(1) {
            width: 250px;
            height: 250px;
            top: 5%;
            left: 5%;
            animation-delay: 0s;
        }

        .floating-circle:nth-child(2) {
            width: 180px;
            height: 180px;
            top: 50%;
            right: 10%;
            animation-delay: 3s;
            background: linear-gradient(45deg, 
                rgba(0, 74, 173, 0.15), 
                rgba(101, 195, 113, 0.15));
        }

        .floating-circle:nth-child(3) {
            width: 120px;
            height: 120px;
            bottom: 15%;
            left: 15%;
            animation-delay: 6s;
        }

        .floating-circle:nth-child(4) {
            width: 200px;
            height: 200px;
            top: 70%;
            right: 60%;
            animation-delay: 2s;
            background: linear-gradient(45deg, 
                rgba(101, 195, 113, 0.1), 
                rgba(0, 74, 173, 0.1));
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) translateX(0px) rotate(0deg) scale(1);
                opacity: 0.7;
            }
            25% { 
                transform: translateY(-30px) translateX(20px) rotate(90deg) scale(1.1);
                opacity: 1;
            }
            50% { 
                transform: translateY(-60px) translateX(-20px) rotate(180deg) scale(0.9);
                opacity: 0.8;
            }
            75% { 
                transform: translateY(-30px) translateX(30px) rotate(270deg) scale(1.05);
                opacity: 0.9;
            }
        }

        /* Main Container */
        .main-container {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* Left Section */
        .left-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem 3rem;
            color: var(--white);
            text-align: center;
        }

        .logo-container {
            margin-bottom: 2rem;
        }

        .logo {
            width: 200px;
            height: 200px;
            object-fit: contain;
            filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.4));
            transition: var(--transition);
        }

        .logo:hover {
            transform: scale(1.05);
            filter: drop-shadow(0 12px 30px rgba(101, 195, 113, 0.3));
        }

        .welcome-section {
            max-width: 600px;
        }

        .welcome-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, 
                var(--white) 0%, 
                var(--light-green) 30%,
                var(--light-blue) 70%,
                var(--white) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .welcome-subtitle {
            font-size: 1.3rem;
            color: var(--gray-200);
            line-height: 1.7;
            margin-bottom: 2rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        /* Right Section - Enhanced Centering */
        .right-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            min-height: 100vh;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 3.5rem;
            width: 100%;
            max-width: 480px;
            box-shadow: 
                var(--card-shadow),
                0 0 60px rgba(101, 195, 113, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            margin: auto;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, 
                transparent, 
                var(--primary-green), 
                var(--primary-blue),
                var(--primary-green),
                transparent);
        }

        .login-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, 
                transparent, 
                rgba(101, 195, 113, 0.1), 
                transparent,
                rgba(0, 74, 173, 0.1),
                transparent);
            animation: rotate 12s linear infinite;
            z-index: -1;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .form-title {
            color: var(--white);
            font-size: 2.2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2.5rem;
            text-shadow: 0 2px 15px rgba(0, 0, 0, 0.4);
            background: linear-gradient(135deg, 
                var(--white) 0%, 
                var(--light-green) 50%,
                var(--light-blue) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Enhanced Form Styles */
        .form-group {
            margin-bottom: 2rem;
            position: relative;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1.2rem;
            color: var(--primary-green);
            font-size: 1.2rem;
            z-index: 2;
            transition: var(--transition);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(101, 195, 113, 0.3);
            border-radius: var(--border-radius-small);
            padding: 1.2rem 1.2rem 1.2rem 3.5rem;
            font-size: 1rem;
            width: 100%;
            transition: var(--transition);
            color: var(--white);
            backdrop-filter: blur(15px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-control::placeholder {
            color: var(--gray-300);
        }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 
                0 0 0 4px rgba(101, 195, 113, 0.2), 
                0 8px 25px rgba(101, 195, 113, 0.15);
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .form-control:focus + .input-icon {
            color: var(--light-green);
            transform: scale(1.1);
        }

        .password-toggle {
            position: absolute;
            right: 1.2rem;
            background: none;
            border: none;
            color: var(--primary-green);
            cursor: pointer;
            padding: 0.6rem;
            border-radius: 8px;
            transition: var(--transition);
            z-index: 2;
            font-size: 1.1rem;
        }

        .password-toggle:hover {
            color: var(--light-green);
            background: rgba(101, 195, 113, 0.1);
            transform: scale(1.1);
        }

        /* Enhanced Remember Me Checkbox */
        .remember-group {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2.5rem;
            justify-content: center;
        }

        .custom-checkbox {
            position: relative;
            display: inline-block;
            width: 24px;
            height: 24px;
        }

        .custom-checkbox input {
            opacity: 0;
            position: absolute;
            cursor: pointer;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 24px;
            width: 24px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid var(--primary-green);
            border-radius: 6px;
            transition: var(--transition);
            backdrop-filter: blur(10px);
        }

        .custom-checkbox input:checked ~ .checkmark {
            background: linear-gradient(135deg, var(--primary-green), var(--primary-blue));
            border-color: var(--light-green);
            box-shadow: 0 0 15px rgba(101, 195, 113, 0.4);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            left: 7px;
            top: 3px;
            width: 6px;
            height: 12px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }

        .custom-checkbox input:checked ~ .checkmark:after {
            display: block;
        }

        .remember-label {
            color: var(--gray-200);
            font-size: 1rem;
            cursor: pointer;
            font-weight: 500;
        }

        /* Enhanced Login Button */
        .login-btn {
            background: linear-gradient(135deg, 
                var(--primary-green) 0%, 
                var(--light-green) 30%,
                var(--primary-blue) 70%,
                var(--dark-blue) 100%);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius-small);
            padding: 1.3rem 2rem;
            font-size: 1.1rem;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 8px 25px rgba(101, 195, 113, 0.4),
                0 4px 15px rgba(0, 74, 173, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.3), 
                transparent);
            transition: left 0.8s ease;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 
                0 12px 35px rgba(101, 195, 113, 0.5),
                0 8px 25px rgba(0, 74, 173, 0.4);
            background: linear-gradient(135deg, 
                var(--light-green) 0%, 
                var(--primary-green) 30%,
                var(--light-blue) 70%,
                var(--primary-blue) 100%);
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .login-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Alert Messages */
        .alert {
            border: none;
            border-radius: var(--border-radius-small);
            margin-bottom: 2rem;
            padding: 1.2rem;
            font-size: 0.95rem;
            backdrop-filter: blur(15px);
            border-left: 4px solid;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border-left-color: #ef4444;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
        }

        .alert-success {
            background: rgba(101, 195, 113, 0.15);
            color: var(--light-green);
            border-left-color: var(--primary-green);
            box-shadow: 0 4px 15px rgba(101, 195, 113, 0.2);
        }

        /* Loading Spinner */
        .spinner-border-sm {
            width: 1.2rem;
            height: 1.2rem;
            border-width: 0.15rem;
        }

        /* Enhanced Responsive Design */
        @media (max-width: 1200px) {
            .welcome-title {
                font-size: 3rem;
            }
            
            .logo {
                width: 180px;
                height: 180px;
            }
        }

        @media (max-width: 1024px) {
            .main-container {
                flex-direction: column;
            }

            .left-section {
                padding: 3rem 2rem;
                min-height: 50vh;
            }

            .right-section {
                padding: 2rem;
                min-height: 50vh;
            }

            .welcome-title {
                font-size: 2.5rem;
            }

            .login-card {
                padding: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .left-section {
                padding: 2rem 1.5rem;
            }

            .logo {
                width: 150px;
                height: 150px;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .welcome-subtitle {
                font-size: 1.1rem;
            }

            .login-card {
                padding: 2rem;
                margin: 1rem;
            }

            .form-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 480px) {
            .logo {
                width: 120px;
                height: 120px;
            }

            .welcome-title {
                font-size: 1.75rem;
            }

            .login-card {
                padding: 1.5rem;
            }

            .form-title {
                font-size: 1.5rem;
            }

            .form-control {
                padding: 1rem 1rem 1rem 3rem;
            }
        }

        /* Enhanced Focus styles for accessibility */
        .form-control:focus,
        .login-btn:focus,
        .password-toggle:focus,
        .custom-checkbox input:focus ~ .checkmark {
            outline: 3px solid var(--primary-green);
            outline-offset: 3px;
        }
    </style>
</head>
<body>
    <!-- Enhanced Background Elements -->
    <div class="background-overlay"></div>
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section">
            <!-- Logo -->
            <div class="logo-container">
                <img src="<?= base_url('assets/images/logo-perpusnas.png') ?>" alt="Logo Perpustakaan Nasional" class="logo">
            </div>

            <!-- Welcome Message -->
            <div class="welcome-section">
                <h1 class="welcome-title">Selamat Datang, Admin!</h1>
                <p class="welcome-subtitle">
                    Akses sistem manajemen perpustakaan digital Anda. Silakan masuk untuk melanjutkan ke panel administrasi INLISLite v3.0 yang telah dipercaya oleh ribuan perpustakaan di seluruh Indonesia.
                </p>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="login-card">
                <h2 class="form-title">Login Admin</h2>

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
                        <div class="input-group">
                            <i class="bi bi-person input-icon"></i>
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
                        <div class="input-group">
                            <i class="bi bi-lock input-icon"></i>
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
                    </div>

                    <!-- Remember Me -->
                    <div class="remember-group">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="remember" id="remember">
                            <span class="checkmark"></span>
                        </label>
                        <label for="remember" class="remember-label">Ingat saya</label>
                    </div>
                    
                    <!-- Login Button -->
                    <button type="submit" class="login-btn" id="loginBtn">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" id="loginSpinner" style="display: none;"></span>
                        <span id="loginText">Login</span>
                    </button>
                </form>
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
            const loginText = document.getElementById('loginText');
            
            loginForm.addEventListener('submit', function(e) {
                // Show loading state
                loginBtn.disabled = true;
                loginSpinner.style.display = 'inline-block';
                loginText.textContent = 'Memproses...';
            });
            
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
            
            // Reset form state if there's an error
            if (document.querySelector('.alert-danger')) {
                loginBtn.disabled = false;
                loginSpinner.style.display = 'none';
                loginText.textContent = 'Login';
            }

            // Enhanced input focus effects
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                    const icon = this.parentElement.querySelector('.input-icon');
                    if (icon) {
                        icon.style.color = 'var(--light-green)';
                        icon.style.transform = 'scale(1.1)';
                    }
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                    const icon = this.parentElement.querySelector('.input-icon');
                    if (icon) {
                        icon.style.color = 'var(--primary-green)';
                        icon.style.transform = 'scale(1)';
                    }
                });
            });
        });
    </script>
</body>
</html>