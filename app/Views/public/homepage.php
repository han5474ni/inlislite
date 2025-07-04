<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'INLISLite v3 - Sistem Otomasi Perpustakaan' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero-section {
            background: var(--primary-gradient);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.1)" points="0,1000 1000,0 1000,1000"/></svg>');
            background-size: cover;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .btn-hero {
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: 2px solid white;
            background: transparent;
            color: white;
        }
        
        .btn-hero:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .feature-card {
            background: white;
            border: none;
            border-radius: 20px;
            padding: 2rem;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin: 0 auto 1.5rem;
        }
        
        .feature-icon.primary { background: var(--primary-gradient); }
        .feature-icon.secondary { background: var(--secondary-gradient); }
        .feature-icon.success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .feature-icon.warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        
        .stats-section {
            background: #f8f9fa;
            padding: 5rem 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 2rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: #667eea;
            display: block;
        }
        
        .stat-label {
            font-size: 1.1rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
        
        .footer {
            background: #2c3e50;
            color: white;
            padding: 3rem 0 1rem;
        }
        
        .footer-section {
            margin-bottom: 2rem;
        }
        
        .footer-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #ecf0f1;
        }
        
        .footer-link {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-link:hover {
            color: #3498db;
        }
        
        .login-btn-footer {
            background: var(--primary-gradient);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .login-btn-footer:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: rgba(44, 62, 80, 0.95); backdrop-filter: blur(10px);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
                <i class="bi bi-book me-2"></i>
                INLISLite v3
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('/') ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('tentang') ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('panduan') ?>">Guide</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('aplikasi') ?>">Applications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('patch') ?>">Updates</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title">INLISLite v3</h1>
                        <p class="hero-subtitle">
                            Sistem Otomasi Perpustakaan Modern yang Powerful, User-Friendly, dan Terintegrasi
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="<?= base_url('panduan') ?>" class="btn btn-hero">
                                <i class="bi bi-book me-2"></i>
                                Pelajari Lebih Lanjut
                            </a>
                            <a href="<?= base_url('aplikasi') ?>" class="btn btn-hero">
                                <i class="bi bi-download me-2"></i>
                                Download Aplikasi
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <i class="bi bi-laptop" style="font-size: 15rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold mb-3">Fitur Unggulan</h2>
                    <p class="lead text-muted">Solusi lengkap untuk kebutuhan manajemen perpustakaan modern</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center">
                        <div class="feature-icon primary">
                            <i class="bi bi-book"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Katalogisasi</h4>
                        <p class="text-muted">Sistem katalogisasi yang mendukung standar MARC21 dengan fitur import/export yang mudah.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center">
                        <div class="feature-icon secondary">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Sirkulasi</h4>
                        <p class="text-muted">Manajemen peminjaman dan pengembalian dengan sistem denda otomatis dan notifikasi.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center">
                        <div class="feature-icon success">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Keanggotaan</h4>
                        <p class="text-muted">Sistem manajemen anggota dengan kartu digital dan kategori yang fleksibel.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center">
                        <div class="feature-icon warning">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Pelaporan</h4>
                        <p class="text-muted">Dashboard analitik dan laporan komprehensif dengan export ke berbagai format.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">1000+</span>
                        <div class="stat-label">Perpustakaan Aktif</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">50K+</span>
                        <div class="stat-label">Pengguna Terdaftar</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">2M+</span>
                        <div class="stat-label">Koleksi Dikelola</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">99.9%</span>
                        <div class="stat-label">Uptime Server</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call to Action Section -->
    <section class="py-5" style="background: var(--primary-gradient);">
        <div class="container">
            <div class="row text-center text-white">
                <div class="col-12">
                    <h2 class="display-6 fw-bold mb-3">Siap Memulai?</h2>
                    <p class="lead mb-4">Bergabunglah dengan ribuan perpustakaan yang telah mempercayai INLISLite</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="<?= base_url('panduan') ?>" class="btn btn-light btn-lg px-4">
                            <i class="bi bi-book me-2"></i>
                            Panduan Instalasi
                        </a>
                        <a href="<?= base_url('aplikasi') ?>" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-download me-2"></i>
                            Download Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">
                            <i class="bi bi-book me-2"></i>
                            INLISLite v3
                        </h5>
                        <p class="text-muted">
                            Sistem otomasi perpustakaan modern yang dirancang untuk memenuhi kebutuhan perpustakaan masa kini dengan teknologi terdepan.
                        </p>
                        <div class="mt-3">
                            <a href="<?= base_url('admin/login') ?>" class="login-btn-footer">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Admin Login
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">Produk</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="<?= base_url('tentang') ?>" class="footer-link">Tentang</a></li>
                            <li class="mb-2"><a href="<?= base_url('panduan') ?>" class="footer-link">Panduan</a></li>
                            <li class="mb-2"><a href="<?= base_url('aplikasi') ?>" class="footer-link">Aplikasi</a></li>
                            <li class="mb-2"><a href="<?= base_url('patch') ?>" class="footer-link">Update</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">Dukungan</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="footer-link">Dokumentasi</a></li>
                            <li class="mb-2"><a href="#" class="footer-link">Forum Komunitas</a></li>
                            <li class="mb-2"><a href="#" class="footer-link">Kontak Support</a></li>
                            <li class="mb-2"><a href="#" class="footer-link">FAQ</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">Kontak</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-envelope me-2"></i>
                                <a href="mailto:support@inlislite.com" class="footer-link">support@inlislite.com</a>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-telephone me-2"></i>
                                <span class="text-muted">+62-xxx-xxxx-xxxx</span>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-geo-alt me-2"></i>
                                <span class="text-muted">Jakarta, Indonesia</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <hr class="my-4" style="border-color: #34495e;">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        &copy; 2024 INLISLite v3. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex justify-content-md-end gap-3">
                        <a href="#" class="footer-link">Privacy Policy</a>
                        <a href="#" class="footer-link">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(44, 62, 80, 0.98)';
            } else {
                navbar.style.background = 'rgba(44, 62, 80, 0.95)';
            }
        });
        
        // Counter animation
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            const speed = 200;
            
            counters.forEach(counter => {
                const updateCount = () => {
                    const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
                    const count = parseInt(counter.getAttribute('data-count') || 0);
                    const increment = target / speed;
                    
                    if (count < target) {
                        counter.setAttribute('data-count', Math.ceil(count + increment));
                        const suffix = counter.textContent.replace(/[\d]/g, '');
                        counter.textContent = Math.ceil(count + increment) + suffix;
                        setTimeout(updateCount, 1);
                    } else {
                        counter.textContent = counter.textContent;
                    }
                };
                updateCount();
            });
        }
        
        // Trigger counter animation when stats section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            observer.observe(statsSection);
        }
    </script>
</body>
</html>