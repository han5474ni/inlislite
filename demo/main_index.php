<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INLISLite v3.0 - Navigation Hub</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #007bff 0%, #34a853 100%);
            --sidebar-gradient: linear-gradient(180deg, #34a853 0%, #0f9d58 100%);
            --card-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            --card-shadow-hover: 0 1rem 2rem rgba(0, 0, 0, 0.2);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--primary-gradient);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .navigation-hub {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .hub-header {
            text-align: center;
            color: white;
            margin-bottom: 3rem;
        }
        
        .hub-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hub-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        .area-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            height: 100%;
            text-decoration: none;
            color: inherit;
        }
        
        .area-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--card-shadow-hover);
            color: inherit;
            text-decoration: none;
        }
        
        .area-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin: 0 auto 1.5rem;
        }
        
        .area-icon.public {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .area-icon.auth {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .area-icon.admin {
            background: var(--sidebar-gradient);
        }
        
        .area-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .area-description {
            color: #6c757d;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .area-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .area-links li {
            margin-bottom: 0.75rem;
        }
        
        .area-links a {
            color: #007bff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .area-links a:hover {
            background: rgba(0, 123, 255, 0.1);
            transform: translateX(5px);
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-public {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }
        
        .status-secure {
            background: rgba(240, 147, 251, 0.1);
            color: #f093fb;
        }
        
        .status-protected {
            background: rgba(52, 168, 83, 0.1);
            color: #34a853;
        }
        
        .quick-stats {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }
        
        .stat-item {
            text-align: center;
            color: white;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            display: block;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .system-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            color: white;
            backdrop-filter: blur(10px);
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 500;
        }
        
        .info-value {
            opacity: 0.8;
        }
        
        @media (max-width: 768px) {
            .hub-title {
                font-size: 2rem;
            }
            
            .area-card {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="navigation-hub">
        <!-- Header -->
        <div class="hub-header">
            <h1 class="hub-title">
                <i class="bi bi-star-fill me-3" style="color: #ffd700;"></i>
                INLISLite v3.0
            </h1>
            <p class="hub-subtitle">Navigation Hub - Sistem Perpustakaan Digital</p>
            <div class="status-badge status-public">System Online</div>
        </div>
        
        <!-- Quick Stats -->
        <div class="quick-stats">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">3</span>
                        <div class="stat-label">Main Areas</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">25+</span>
                        <div class="stat-label">Pages</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <div class="stat-label">Features</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">100%</span>
                        <div class="stat-label">Functional</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation Areas -->
        <div class="row g-4 mb-4">
            <!-- Public Area -->
            <div class="col-lg-4">
                <a href="/" class="area-card">
                    <div class="area-icon public">
                        <i class="bi bi-globe"></i>
                    </div>
                    <h3 class="area-title">Public Area</h3>
                    <p class="area-description">
                        Landing pages dan informasi umum yang dapat diakses oleh semua pengunjung
                    </p>
                    <div class="status-badge status-public mb-3">Open Access</div>
                    <ul class="area-links">
                        <li><a href="/"><i class="bi bi-house"></i> Homepage</a></li>
                        <li><a href="/tentang"><i class="bi bi-info-circle"></i> About System</a></li>
                        <li><a href="/panduan"><i class="bi bi-book"></i> User Guide</a></li>
                        <li><a href="/aplikasi"><i class="bi bi-download"></i> Applications</a></li>
                        <li><a href="/patch"><i class="bi bi-arrow-up-circle"></i> Updates</a></li>
                    </ul>
                </a>
            </div>
            
            <!-- Authentication Area -->
            <div class="col-lg-4">
                <a href="/admin/secure-login" class="area-card">
                    <div class="area-icon auth">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <h3 class="area-title">Authentication</h3>
                    <p class="area-description">
                        Sistem login dan keamanan dengan enkripsi tingkat enterprise
                    </p>
                    <div class="status-badge status-secure mb-3">Secure Access</div>
                    <ul class="area-links">
                        <li><a href="/admin/secure-login"><i class="bi bi-box-arrow-in-right"></i> Secure Login</a></li>
                        <li><a href="/admin/login"><i class="bi bi-key"></i> Standard Login</a></li>
                        <li><a href="/admin/forgot-password"><i class="bi bi-question-circle"></i> Forgot Password</a></li>
                        <li><a href="/loginpage"><i class="bi bi-person-check"></i> Legacy Login</a></li>
                    </ul>
                </a>
            </div>
            
            <!-- Admin Area -->
            <div class="col-lg-4">
                <a href="/admin/dashboard" class="area-card">
                    <div class="area-icon admin">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <h3 class="area-title">Admin Area</h3>
                    <p class="area-description">
                        Dashboard administrasi dan manajemen sistem perpustakaan
                    </p>
                    <div class="status-badge status-protected mb-3">Protected Access</div>
                    <ul class="area-links">
                        <li><a href="/admin/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                        <li><a href="/admin/users"><i class="bi bi-people"></i> User Management</a></li>
                        <li><a href="/admin/users/add-secure"><i class="bi bi-person-plus"></i> Add Secure User</a></li>
                        <li><a href="/admin/patches"><i class="bi bi-tools"></i> Patch Management</a></li>
                        <li><a href="/admin/demo"><i class="bi bi-play-circle"></i> Demo System</a></li>
                    </ul>
                </a>
            </div>
        </div>
        
        <!-- Demo & Testing Links -->
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="area-card">
                    <h4 class="area-title">
                        <i class="bi bi-play-circle me-2"></i>
                        Demo & Testing
                    </h4>
                    <p class="area-description">
                        Link demo untuk testing tanpa autentikasi
                    </p>
                    <ul class="area-links">
                        <li><a href="/modern-dashboard"><i class="bi bi-layout-sidebar"></i> Modern Dashboard Demo</a></li>
                        <li><a href="/user-management-demo"><i class="bi bi-people"></i> User Management Demo</a></li>
                        <li><a href="/test_modern_dashboard.html"><i class="bi bi-file-code"></i> Dashboard Test Page</a></li>
                        <li><a href="/index.html"><i class="bi bi-file-earmark"></i> Standalone Demo</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="area-card">
                    <h4 class="area-title">
                        <i class="bi bi-tools me-2"></i>
                        Development Tools
                    </h4>
                    <p class="area-description">
                        Tools dan utilities untuk development
                    </p>
                    <ul class="area-links">
                        <li><a href="/installer"><i class="bi bi-gear"></i> System Installer</a></li>
                        <li><a href="/setup_simple.php"><i class="bi bi-database"></i> Database Setup</a></li>
                        <li><a href="/test_login_system.php"><i class="bi bi-bug"></i> Login Test</a></li>
                        <li><a href="/debug-database"><i class="bi bi-search"></i> Database Debug</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- System Information -->
        <div class="system-info">
            <h4 class="mb-3">
                <i class="bi bi-info-circle me-2"></i>
                System Information
            </h4>
            <div class="info-item">
                <span class="info-label">Version</span>
                <span class="info-value">INLISLite v3.0</span>
            </div>
            <div class="info-item">
                <span class="info-label">Framework</span>
                <span class="info-value">CodeIgniter 4</span>
            </div>
            <div class="info-item">
                <span class="info-label">Database</span>
                <span class="info-value">MySQL (inlislite)</span>
            </div>
            <div class="info-item">
                <span class="info-label">Security Level</span>
                <span class="info-value">Enterprise Grade</span>
            </div>
            <div class="info-item">
                <span class="info-label">Last Updated</span>
                <span class="info-value"><?= date('d M Y H:i') ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Status</span>
                <span class="info-value">
                    <i class="bi bi-check-circle text-success me-1"></i>
                    Fully Operational
                </span>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add hover effects and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on load
            const cards = document.querySelectorAll('.area-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
            
            // Animate stats
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(stat => {
                const finalValue = stat.textContent;
                const isNumber = !isNaN(parseInt(finalValue));
                
                if (isNumber) {
                    const target = parseInt(finalValue);
                    let current = 0;
                    const increment = target / 50;
                    
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            stat.textContent = finalValue;
                            clearInterval(timer);
                        } else {
                            stat.textContent = Math.floor(current) + (finalValue.includes('%') ? '%' : '');
                        }
                    }, 30);
                }
            });
            
            // Add click tracking
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    console.log('Navigation:', this.href);
                });
            });
        });
        
        // Check system status
        function checkSystemStatus() {
            // This could be expanded to actually check system health
            const statusBadge = document.querySelector('.status-badge');
            const statusValue = document.querySelector('.info-item:last-child .info-value');
            
            // Simulate status check
            setTimeout(() => {
                statusBadge.textContent = 'System Online';
                statusBadge.className = 'status-badge status-public';
            }, 1000);
        }
        
        checkSystemStatus();
    </script>
</body>
</html>