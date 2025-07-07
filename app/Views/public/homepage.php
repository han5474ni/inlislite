<?= view('public/layout/header', ['page_title' => 'Home']) ?>

<!-- Hero Section -->
<section style="background: var(--primary-gradient); color: white; min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; margin-top: 76px;">
    <div style="content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1000 1000\"%3E%3Cpolygon fill=\"rgba(255,255,255,0.1)\" points=\"0,1000 1000,0 1000,1000\"/%3E%3C/svg%3E'); background-size: cover;"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div style="position: relative; z-index: 2;">
                    <h1 style="font-size: 2.5rem; font-weight: 600; margin-bottom: 1rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.2); animation: slideUp 0.8s ease-out; line-height: 1.2;">INLISLite v3</h1>
                    <p style="font-size: 1.1rem; margin-bottom: 1.5rem; opacity: 0.95; animation: slideUp 0.8s ease-out 0.2s both; line-height: 1.6; font-weight: 400;">
                        Sistem Otomasi Perpustakaan Modern yang Powerful, User-Friendly, dan Terintegrasi
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <img src="<?= base_url('assets/images/inlislite.png') ?>" alt="INLISLite Logo" style="max-width: 350px; width: 100%; height: auto; opacity: 0.9; animation: slideUp 0.8s ease-out 0.3s both;">
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design - More Friendly Sizes */
@media (max-width: 768px) {
    .hero-section h1 {
        font-size: 2rem !important;
    }
    
    .hero-section p {
        font-size: 1rem !important;
    }
    
    .hero-section img {
        max-width: 280px !important;
    }
}

@media (max-width: 576px) {
    .hero-section h1 {
        font-size: 1.8rem !important;
        margin-bottom: 0.8rem !important;
    }
    
    .hero-section p {
        font-size: 0.95rem !important;
        margin-bottom: 1rem !important;
    }
    
    .hero-section img {
        max-width: 250px !important;
    }
}

/* Additional friendly styling */
.container {
    padding: 0 1rem;
}
</style>

<?= view('public/layout/footer') ?>