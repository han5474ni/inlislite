<!-- Footer -->
<footer class="footer-modern" style="background: #012B5E !important;">
    <div class="container py-4 position-relative" style="padding-bottom: 4rem;">
        <!-- Top Section -->
        <div class="row g-4 mb-4 footer-animate align-items-center">
            <!-- Logo Section -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-logo-container d-flex align-items-center gap-3">
                    <!-- Book Icon in Green-Blue Square -->
                    <div class="footer-logo-icon">
                        <i class="bi bi-book-fill text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h4 class="footer-logo-text mb-0">
                                Inlis<span class="footer-logo-lite">Lite</span>
                            </h4>
                            <span class="footer-version-badge">v3</span>
                        </div>
                        <p class="footer-subtitle mb-0">
                            Sistem Manajemen Perpustakaan Digital
                        </p>
                    </div>
                </div>
            </div>

            <!-- Unit Description -->
            <div class="col-lg-8 col-md-6">
                <div class="text-center text-md-start">
                    
                </div>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="row g-4 mb-4 footer-animate">
            <div class="col-12">
                <h5 class="footer-contact-title">Informasi Kontak</h5>
            </div>
            
            <!-- Left Column - Email & Facebook -->
            <div class="col-lg-6 col-md-6">
                <div class="d-flex flex-column gap-3">
                    <!-- Email Section -->
                    <div class="footer-contact-item">
                        <i class="bi bi-envelope-fill footer-contact-icon"></i>
                        <div>
                            <span class="footer-contact-label">Email</span>
                            <a href="mailto:info@perpusnas.go.id" class="footer-contact-link">
                                info@perpusnas.go.id
                            </a>
                        </div>
                    </div>

                    <!-- Facebook Section -->
                    <div class="footer-contact-item">
                        <i class="bi bi-facebook footer-contact-icon"></i>
                        <div>
                            <p class="footer-contact-value mb-0">
                                InlisLite Perpustakaan Indonesia
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Address -->
            <div class="col-lg-6 col-md-6">
                <div class="footer-contact-item">
                    <i class="bi bi-geo-alt-fill footer-contact-icon location"></i>
                    <div>
                        <span class="footer-contact-label">Alamat</span>
                        <p class="footer-contact-value mb-0">
                            Jl. Medan Merdeka Selatan No. 11 Jakarta 10110
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Login Button (bottom-right corner) -->
        <div class="position-absolute" style="bottom: 1rem; right: 1rem; z-index: 10;">
            <a href="<?= base_url('admin/login') ?>" 
               class="btn btn-outline-light d-flex align-items-center gap-2 px-3 px-md-4 py-2 py-md-3 rounded-3 shadow-sm text-decoration-none admin-login-btn"
               role="button"
               aria-label="Admin Login">
                <i class="bi bi-shield-lock-fill fs-6 fs-md-5"></i>
                <span class="fw-semibold d-none d-sm-inline">Admin Login</span>
                <span class="fw-semibold d-sm-none">Admin</span>
            </a>
        </div>

        <!-- Bottom Bar -->
        <hr class="footer-separator">
        <div class="text-center footer-animate">
            <p class="footer-copyright mb-0">
                © 2016 | Perpustakaan Nasional Republik Indonesia
            </p>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Public JS -->
<script src="<?= base_url('assets/js/public/main.js') ?>"></script>
<script src="<?= base_url('assets/js/public/footer.js') ?>"></script>

<!-- Page specific JS -->
<?php if (isset($page_js)): ?>
    <script src="<?= base_url('assets/js/public/' . $page_js) ?>"></script>
<?php endif; ?>

<script>
    // Initialize Feather icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add fade-in animation to elements when they come into view
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements with animation class
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // Back to top button
    const backToTopBtn = document.createElement('button');
    backToTopBtn.innerHTML = '<i class="bi bi-arrow-up"></i>';
    backToTopBtn.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: none;
        border: none;
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: var(--transition);
    `;

    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    backToTopBtn.addEventListener('mouseenter', () => {
        backToTopBtn.style.transform = 'scale(1.1) translateY(-2px)';
        backToTopBtn.style.boxShadow = '0 6px 20px rgba(0,0,0,0.2)';
    });

    backToTopBtn.addEventListener('mouseleave', () => {
        backToTopBtn.style.transform = 'scale(1) translateY(0)';
        backToTopBtn.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
    });

    document.body.appendChild(backToTopBtn);

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopBtn.style.display = 'block';
        } else {
            backToTopBtn.style.display = 'none';
        }
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        const toastContainer = document.getElementById('toastContainer') || createToastContainer();

        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

        toastContainer.appendChild(toast);

        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();

        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }

    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '1055';
        document.body.appendChild(container);
        return container;
    }

    // Global error handler
    window.addEventListener('error', function(e) {
        console.error('Global error:', e.error);
    });

    // Loading indicator
    function showLoading() {
        const loading = document.createElement('div');
        loading.id = 'globalLoading';
        loading.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
        loading.style.cssText = 'background: rgba(255,255,255,0.9); z-index: 9999;';
        loading.innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2">Loading...</div>
            </div>
        `;
        document.body.appendChild(loading);
    }

    function hideLoading() {
        const loading = document.getElementById('globalLoading');
        if (loading) {
            loading.remove();
        }
    }

    // Make showToast globally available
    window.showToast = showToast;
</script>
</body>
</html>
