<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - InlisLite Admin</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            overflow: hidden;
            background: linear-gradient(180deg, #65C371 0%, #004AAD 100%);
            position: relative;
        }

        /* Top Navigation Bar */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: #004AAD;
            display: flex;
            align-items: center;
            padding: 0 24px;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .back-arrow {
            color: #000000;
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.2s ease;
            margin-right: 16px;
        }

        .back-arrow:hover {
            transform: translateX(-2px);
        }

        .navbar-title {
            color: #000000;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* Main Container */
        .login-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 70px 24px 24px;
        }

        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.1),
                0 8px 24px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
        }

        /* Card Header */
        .card-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .card-title {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 24px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            letter-spacing: -0.02em;
        }

        .card-logo {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 32px;
            box-shadow: 
                0 8px 24px rgba(101, 195, 113, 0.3),
                0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            padding: 16px;
        }

        .card-logo::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(101, 195, 113, 0.1), transparent);
            border-radius: 20px;
        }

        .card-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            z-index: 1;
            position: relative;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-input {
            width: 100%;
            height: 56px;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            padding: 0 20px;
            font-size: 16px;
            font-weight: 500;
            color: #1f2937;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            backdrop-filter: blur(10px);
        }

        .form-input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        .form-input:focus {
            border-color: #65C371;
            background: rgba(255, 255, 255, 1);
            box-shadow: 
                0 0 0 4px rgba(101, 195, 113, 0.1),
                0 4px 12px rgba(101, 195, 113, 0.15);
            transform: translateY(-1px);
        }

        /* Password Input with Eye Icon */
        .password-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 20px;
            cursor: pointer;
            transition: color 0.2s ease;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #65C371;
        }

        /* Login Button */
        .login-button {
            width: 100%;
            height: 56px;
            background: #000000;
            color: #ffffff;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.02em;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 16px;
            position: relative;
            overflow: hidden;
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:hover {
            background: #1f2937;
            transform: translateY(-2px);
            box-shadow: 
                0 8px 24px rgba(0, 0, 0, 0.2),
                0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .login-button:active {
            transform: translateY(0);
            transition: transform 0.1s ease;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                padding: 70px 16px 16px;
            }

            .login-card {
                padding: 32px 24px;
                border-radius: 20px;
                max-width: 100%;
            }

            .card-title {
                font-size: 24px;
                margin-bottom: 20px;
            }

            .card-logo {
                width: 80px;
                height: 80px;
                margin-bottom: 24px;
                padding: 12px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-input {
                height: 52px;
                font-size: 15px;
                padding: 0 16px;
            }

            .login-button {
                height: 52px;
                font-size: 15px;
            }

            .password-toggle {
                right: 16px;
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            .top-navbar {
                height: 60px;
                padding: 0 16px;
            }

            .navbar-title {
                font-size: 18px;
            }

            .back-arrow {
                font-size: 20px;
                margin-right: 12px;
            }

            .login-container {
                padding: 60px 12px 12px;
            }

            .login-card {
                padding: 24px 20px;
                border-radius: 16px;
            }

            .card-title {
                font-size: 22px;
            }

            .card-logo {
                width: 70px;
                height: 70px;
                padding: 10px;
            }
        }

        /* Loading Animation */
        .loading {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #ffffff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Focus Visible for Accessibility */
        .form-input:focus-visible,
        .login-button:focus-visible,
        .back-arrow:focus-visible,
        .password-toggle:focus-visible {
            outline: 2px solid #65C371;
            outline-offset: 2px;
        }

        /* Error state for form validation */
        .form-input.error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1) !important;
        }

        .form-input.success {
            border-color: #65C371 !important;
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <div class="top-navbar">
        <i class="bi bi-arrow-left back-arrow" onclick="goBack()" tabindex="0" role="button" aria-label="Kembali"></i>
        <span class="navbar-title">Login</span>
    </div>

    <!-- Main Login Container -->
    <div class="login-container">
        <div class="login-card">
            <!-- Card Header -->
            <div class="card-header">
                <h1 class="card-title">Silahkan Login</h1>
                <div class="card-logo">
                    <img src="<?= base_url('assets/images/logo-perpusnas.png') ?>" alt="Logo Perpustakaan Nasional" />
                </div>
            </div>

            <!-- Login Form -->
            <form id="loginForm" action="<?= base_url('admin/authenticate') ?>" method="POST">
                <!-- Username Field -->
                <div class="form-group">
                    <input 
                        type="text" 
                        class="form-input" 
                        id="username" 
                        name="username" 
                        placeholder="Username" 
                        required 
                        autocomplete="username"
                        aria-label="Username">
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <div class="password-group">
                        <input 
                            type="password" 
                            class="form-input" 
                            id="password" 
                            name="password" 
                            placeholder="Password" 
                            required 
                            autocomplete="current-password"
                            aria-label="Password">
                        <i class="bi bi-eye password-toggle" 
                           onclick="togglePassword()" 
                           tabindex="0" 
                           role="button" 
                           aria-label="Tampilkan/Sembunyikan Password"></i>
                    </div>
                </div>

                <!-- Login Button -->
                <button type="submit" class="login-button" id="loginBtn">
                    <span class="loading" id="loadingSpinner"></span>
                    <span id="buttonText">Login</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Password Toggle Functionality
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
                toggleIcon.setAttribute('aria-label', 'Sembunyikan Password');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
                toggleIcon.setAttribute('aria-label', 'Tampilkan Password');
            }
        }

        // Back Button Functionality
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '<?= base_url('/') ?>';
            }
        }

        // Form Submission with Loading State
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginBtn = document.getElementById('loginBtn');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const buttonText = document.getElementById('buttonText');
            
            // Show loading state
            loginBtn.disabled = true;
            loadingSpinner.style.display = 'inline-block';
            buttonText.textContent = 'Memproses...';
            
            // If you want to prevent actual submission for demo purposes, uncomment the next line
            // e.preventDefault();
        });

        // Keyboard Navigation for Password Toggle
        document.querySelector('.password-toggle').addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                togglePassword();
            }
        });

        // Keyboard Navigation for Back Arrow
        document.querySelector('.back-arrow').addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                goBack();
            }
        });

        // Auto-focus on username field when page loads
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').focus();
        });

        // Enhanced form validation with visual feedback
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.classList.add('error');
                    this.classList.remove('success');
                } else {
                    this.classList.add('success');
                    this.classList.remove('error');
                }
            });

            input.addEventListener('input', function() {
                this.classList.remove('error');
                if (this.value.trim() !== '') {
                    this.classList.add('success');
                } else {
                    this.classList.remove('success');
                }
            });
        });

        // Prevent form submission if fields are empty
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (!username || !password) {
                e.preventDefault();
                
                if (!username) {
                    document.getElementById('username').classList.add('error');
                    document.getElementById('username').focus();
                }
                if (!password) {
                    document.getElementById('password').classList.add('error');
                }
                
                // Reset loading state
                const loginBtn = document.getElementById('loginBtn');
                const loadingSpinner = document.getElementById('loadingSpinner');
                const buttonText = document.getElementById('buttonText');
                
                loginBtn.disabled = false;
                loadingSpinner.style.display = 'none';
                buttonText.textContent = 'Login';
                
                return false;
            }
        });

        // Handle image load error
        document.querySelector('.card-logo img').addEventListener('error', function() {
            // Fallback to icon if image fails to load
            this.style.display = 'none';
            const fallbackIcon = document.createElement('i');
            fallbackIcon.className = 'bi bi-book-fill';
            fallbackIcon.style.fontSize = '48px';
            fallbackIcon.style.color = '#004AAD';
            this.parentNode.appendChild(fallbackIcon);
        });
    </script>
</body>
</html>