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
            /* Modern Color Palette - Solid Colors */
            --primary-blue: #2563eb;
            --primary-blue-dark: #1d4ed8;
            --secondary-green: var(--brand-green);
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --danger-color: #dc2626;
            --success-color: #059669;
            
            /* Design System */
            --border-radius: 16px;
            --border-radius-small: 8px;
            --box-shadow-lg: 0 10px 15px -3px rgb(0, 0, 0), 0 4px 6px -2px rgb(0, 0, 0);
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            /* Background with overlay and fixed image */
            background-image: linear-gradient(rgba(17, 24, 39, 0.55), rgba(17, 24, 39, 0.55)), url('<?= base_url('assets/images/login-bg.png') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        .login-container {
            width: 100%;
            max-width: 780px; /* wider like screenshot */
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.88); /* translucent card */
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 28px; /* more rounded */
            padding: 2.5rem 2.75rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.35);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo {
            display: block;
            max-width: clamp(88px, 12vw, 140px); /* responsif sesuai lebar card */
            width: 100%;
            height: auto; /* pertahankan rasio logo */
            margin: 0 auto 1rem; /* center di atas judul */
            border-radius: 0; /* biarkan bentuk asli logo */
            opacity: .95;
        }
        
        .login-title {
            color: #0f172a; /* slate-900 */
            font-size: 2.25rem; /* bigger heading like screenshot */
            font-weight: 800;
            text-align: center;
            margin-bottom: 0.25rem;
        }
        
        .login-subtitle {
            color: #475569; /* slate-600 */
            font-size: 1rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            color: var(--gray-700);
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-control {
            background-color: #f8fafc; /* light input bg */
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 1rem 1.125rem; /* taller inputs */
            font-size: 1.05rem;
            width: 100%;
            transition: var(--transition);
            color: var(--gray-800);
        }
        
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: none; /* remove extra ring */
            outline: none;
            background-color: #fff;
        }
        
        .form-control::placeholder {
            color: var(--gray-600);
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
            color: var(--gray-600);
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 8px;
            transition: var(--transition);
        }
        

        
        .login-btn {
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
            color: var(--white);
            border: none;
            border-radius: 14px;
            padding: 1rem 1.125rem;
            font-size: 1.05rem;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
            transition: transform .08s ease, box-shadow .15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 8px 20px rgba(37, 99, 235, .35);
        }
        

        
        .login-btn:disabled {
            opacity: 1;
            cursor: not-allowed;
            transform: none;
        }
        
        .alert {
            border: none;
            border-radius: var(--border-radius-small);
            margin-bottom: 1.5rem;
            padding: 0.875rem 1rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .alert-danger {
            background-color: #fef2f2;
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }
        
        .alert-success {
            background-color: #f0fdf4;
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }
        
        .invalid-feedback {
            display: block;
            color: var(--danger-color);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .back-link {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            color: #111827;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            padding: 0.6rem 1rem;
            border-radius: 9999px;
            background: rgba(255,255,255,.8);
            backdrop-filter: blur(4px);
            transition: var(--transition);
            box-shadow: 0 6px 16px rgba(0,0,0,.15);
        } 
        
        /* Responsive Design */
        @media (max-width: 576px) {
            body {
                padding: 0.5rem;
            }
            
            .login-card {
                padding: 2rem 1.5rem;
            }
            
            .login-title {
                font-size: 1.25rem;
            }
            
            .back-link {
                top: 1rem;
                left: 1rem;
                font-size: 0.8rem;
                padding: 0.375rem 0.75rem;
            }
        }
        
        /* Loading spinner */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.125rem;
        }
        
        /* Focus styles for accessibility */
        .login-btn:focus,
        .password-toggle:focus,
        .back-link:focus {
            outline: 2px solid var(--primary-blue);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <!-- Back Link -->
    <a href="<?= base_url('/') ?>" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Kembali ke Beranda
    </a>
    
    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            <!-- Logo and Title -->
            <div class="logo-container">
                <img src="<?= base_url('assets/images/inlislite.png') ?>" alt="INLISLite Logo" class="logo">
                <h1 class="login-title">Admin Login</h1>
                <p class="login-subtitle">Masuk ke panel administrasi INLISLite</p>
            </div>
            
            <!-- Error/Success Messages -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            
            <!-- Login Form -->
            <form action="<?= base_url('admin/login/authenticate') ?>" method="post" id="loginForm" novalidate>
                <?= csrf_field() ?>
                
                <!-- Username Field -->
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" 
                           class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" 
                           id="username" 
                           name="username" 
                           placeholder="Masukkan username Anda"
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
                    <label for="password" class="form-label">Password</label>
                    <div class="password-field">
                        <input type="password" 
                               class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                               id="password" 
                               name="password" 
                               placeholder="Masukkan password Anda"
                               required
                               autocomplete="current-password">
                        <button type="button" class="password-toggle" id="togglePassword" title="Tampilkan/Sembunyikan Password">
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
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="loginSpinner" style="display: none;"></span>
                    <span id="loginText">Masuk</span>
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
                
                // Let form submit normally
                console.log('Form submitting to:', loginForm.action);
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
                loginText.textContent = 'Masuk';
            }
        });
    </script>
</body>
</html>
