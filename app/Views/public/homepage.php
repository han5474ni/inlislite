<?= view('public/layout/header', ['page_title' => 'Home']) ?>

<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(180deg, #6FD09A 0%, #046BB5 100%); min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; margin-top: 76px; padding: 2.5rem 1.5rem;">
    <!-- Subtle Background Pattern -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"%3E%3Ccircle cx=\"50\" cy=\"50\" r=\"1\" fill=\"rgba(255,255,255,0.1)\"/%3E%3C/svg%3E'); background-size: 50px 50px; opacity: 0.3; pointer-events: none;"></div>
    
    <div class="container" style="position: relative; z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="text-center">
                    <!-- Hero Content Container -->
                    <div class="hero-card" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); border-radius: 1.5rem; padding: 4rem 3rem; border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), 0 2px 8px rgba(255, 255, 255, 0.1) inset; max-width: 100%; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                        
                        <!-- Welcome Text -->
                        <div class="hero-headline mb-4">
                            <h1 class="hero-title-welcome" style="font-size: 3rem; font-weight: 600; color: #FFFFFF; margin-bottom: 0.5rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.3); animation: slideUp 0.8s ease-out; line-height: 1.2; font-family: 'Poppins', sans-serif;">
                                Selamat datang di
                            </h1>
                            <h1 class="hero-title-main" style="font-size: 4rem; font-weight: 700; color: #FFFFFF; margin-bottom: 2rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); animation: slideUp 0.8s ease-out 0.1s both; line-height: 1.1; font-family: 'Poppins', sans-serif;">
                                InlisLite V3
                            </h1>
                        </div>
                        
                        <!-- Description Text -->
                        <div class="hero-body">
                            <p class="hero-description" style="font-size: 1.25rem; color: #F0F0F0; margin-bottom: 0; animation: slideUp 0.8s ease-out 0.2s both; line-height: 1.6; font-weight: 400; text-shadow: 1px 1px 2px rgba(0,0,0,0.2); font-family: 'Poppins', sans-serif;">
                                Sebuah sistem otomasi perpustakaan yang modern, terintegrasi, dan bersifat open-source, dikembangkan oleh Perpustakaan Nasional Republik Indonesia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kenapa InlisLite Section -->
<section class="features-section" style="background: linear-gradient(180deg, #046BB5 0%, #024D96 100%); padding: 5rem 1.5rem; position: relative; overflow: hidden; margin-top: 0;">
    <!-- Clean Background Pattern -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 60 60\"%3E%3Cpath d=\"M30 30m-2 0a2 2 0 1 1 4 0a2 2 0 1 1 -4 0\" fill=\"rgba(255,255,255,0.05)\"/%3E%3C/svg%3E'); background-size: 60px 60px; opacity: 0.4; pointer-events: none;"></div>
    
    <div class="container" style="position: relative; z-index: 2;">
        <!-- Section Title -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="features-title" style="text-align: center; font-size: 3rem; font-weight: 700; margin-bottom: 3rem; color: #FFFFFF; text-shadow: 1px 1px 3px rgba(0,0,0,0.3); animation: slideUp 0.8s ease-out; font-family: 'Poppins', sans-serif;">
                    Kenapa InlisLite?
                </h2>
            </div>
        </div>
        
        <!-- Feature Cards Grid -->
        <div class="row g-4 justify-content-center">
            <!-- Card 1: Otomasi & Digitalisasi Terpadu -->
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="feature-card animate-on-scroll" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); border-radius: 1.5rem; padding: 3rem 2rem; text-align: center; height: 100%; border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1), 0 1px 4px rgba(255, 255, 255, 0.1) inset; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                    
                    <!-- Icon Container -->
                    <div class="feature-icon" style="width: 80px; height: 80px; margin: 0 auto 2rem; background: linear-gradient(135deg, #6FD09A 0%, #046BB5 100%); border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 16px rgba(111, 208, 154, 0.3); transition: all 0.3s ease;">
                        <i class="bi bi-laptop" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    
                    <!-- Card Content -->
                    <div>
                        <h4 class="feature-title" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #FFFFFF; line-height: 1.3; text-shadow: 1px 1px 2px rgba(0,0,0,0.2); font-family: 'Poppins', sans-serif;">
                            Otomasi & Digitalisasi Terpadu
                        </h4>
                        <p class="feature-description" style="color: #F0F0F0; line-height: 1.6; margin-bottom: 0; font-size: 0.95rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.1); font-family: 'Poppins', sans-serif;">
                            Sistem terintegrasi yang mengotomatisasi seluruh proses perpustakaan dengan teknologi digital terdepan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Gratis, Opensource & Fleksibel -->
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="feature-card animate-on-scroll" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); border-radius: 1.5rem; padding: 3rem 2rem; text-align: center; height: 100%; border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1), 0 1px 4px rgba(255, 255, 255, 0.1) inset; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                    
                    <!-- Icon Container -->
                    <div class="feature-icon" style="width: 80px; height: 80px; margin: 0 auto 2rem; background: linear-gradient(135deg, #6FD09A 0%, #046BB5 100%); border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 16px rgba(111, 208, 154, 0.3); transition: all 0.3s ease;">
                        <i class="bi bi-code-slash" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    
                    <!-- Card Content -->
                    <div>
                        <h4 class="feature-title" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #FFFFFF; line-height: 1.3; text-shadow: 1px 1px 2px rgba(0,0,0,0.2); font-family: 'Poppins', sans-serif;">
                            Gratis, Opensource & Fleksibel
                        </h4>
                        <p class="feature-description" style="color: #F0F0F0; line-height: 1.6; margin-bottom: 0; font-size: 0.95rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.1); font-family: 'Poppins', sans-serif;">
                            Solusi perpustakaan yang dapat disesuaikan dengan kebutuhan tanpa biaya lisensi yang mahal.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 3: Penggunaan & Modifikasi Etis -->
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="feature-card animate-on-scroll" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); border-radius: 1.5rem; padding: 3rem 2rem; text-align: center; height: 100%; border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1), 0 1px 4px rgba(255, 255, 255, 0.1) inset; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                    
                    <!-- Icon Container -->
                    <div class="feature-icon" style="width: 80px; height: 80px; margin: 0 auto 2rem; background: linear-gradient(135deg, #6FD09A 0%, #046BB5 100%); border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 16px rgba(111, 208, 154, 0.3); transition: all 0.3s ease;">
                        <i class="bi bi-shield-check" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    
                    <!-- Card Content -->
                    <div>
                        <h4 class="feature-title" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #FFFFFF; line-height: 1.3; text-shadow: 1px 1px 2px rgba(0,0,0,0.2); font-family: 'Poppins', sans-serif;">
                            Penggunaan & Modifikasi Etis
                        </h4>
                        <p class="feature-description" style="color: #F0F0F0; line-height: 1.6; margin-bottom: 0; font-size: 0.95rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.1); font-family: 'Poppins', sans-serif;">
                            Dikembangkan dengan standar etika tinggi dan dapat dimodifikasi sesuai kebutuhan institusi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Feature Cards Hover Effects */
.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2), 0 2px 8px rgba(255, 255, 255, 0.15) inset;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.feature-card:hover .feature-icon {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(111, 208, 154, 0.4);
}

.feature-card:hover .feature-icon i {
    transform: scale(1.05);
}

/* Hero card hover effect */
.hero-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15), 0 3px 12px rgba(255, 255, 255, 0.15) inset;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Animation for scroll-triggered elements */
.animate-on-scroll {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
}

.animate-on-scroll.fade-in {
    opacity: 1;
    transform: translateY(0);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title-welcome {
        font-size: 2.2rem !important;
    }
    
    .hero-title-main {
        font-size: 2.8rem !important;
        margin-bottom: 1.5rem !important;
    }
    
    .hero-description {
        font-size: 1.1rem !important;
    }
    
    .hero-card {
        padding: 3rem 2rem !important;
    }
    
    .features-title {
        font-size: 2.5rem !important;
    }
    
    .feature-card {
        padding: 2.5rem 1.5rem !important;
    }
    
    .feature-icon {
        width: 70px !important;
        height: 70px !important;
    }
    
    .feature-icon i {
        font-size: 2rem !important;
    }
    
    .feature-title {
        font-size: 1.1rem !important;
    }
    
    .feature-description {
        font-size: 0.9rem !important;
    }
}

@media (max-width: 576px) {
    .hero-title-welcome {
        font-size: 1.8rem !important;
        margin-bottom: 0.25rem !important;
    }
    
    .hero-title-main {
        font-size: 2.2rem !important;
        margin-bottom: 1.5rem !important;
    }
    
    .hero-description {
        font-size: 1rem !important;
    }
    
    .hero-card {
        padding: 2rem 1.5rem !important;
        border-radius: 1rem !important;
    }
    
    .features-title {
        font-size: 2rem !important;
        margin-bottom: 2rem !important;
    }
    
    .feature-card {
        padding: 2rem 1.5rem !important;
    }
    
    .feature-icon {
        width: 60px !important;
        height: 60px !important;
        margin-bottom: 1.5rem !important;
    }
    
    .feature-icon i {
        font-size: 1.8rem !important;
    }
    
    .feature-title {
        font-size: 1rem !important;
    }
    
    .feature-description {
        font-size: 0.85rem !important;
    }
}

/* Extra small devices */
@media (max-width: 480px) {
    .hero-title-welcome {
        font-size: 1.5rem !important;
    }
    
    .hero-title-main {
        font-size: 1.9rem !important;
    }
    
    .hero-description {
        font-size: 0.95rem !important;
    }
    
    .hero-card {
        padding: 1.5rem 1rem !important;
    }
    
    .features-title {
        font-size: 1.8rem !important;
    }
    
    .feature-card {
        padding: 1.5rem 1rem !important;
    }
    
    .feature-icon {
        width: 50px !important;
        height: 50px !important;
    }
    
    .feature-icon i {
        font-size: 1.5rem !important;
    }
    
    .feature-title {
        font-size: 0.95rem !important;
    }
    
    .feature-description {
        font-size: 0.8rem !important;
    }
}

/* Disable hover effects on touch devices */
@media (hover: none) {
    .feature-card:hover {
        transform: none;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .feature-card:hover .feature-icon {
        transform: none;
    }
    
    .feature-card:hover .feature-icon i {
        transform: none;
    }
    
    .feature-card:hover > div:first-child {
        opacity: 0.1;
        transform: none;
    }
}

/* Additional styling for better visual hierarchy */
.container {
    padding: 0 1rem;
}

/* Ensure cards have equal height on desktop */
@media (min-width: 992px) {
    .row.g-4 {
        display: flex;
        align-items: stretch;
    }
}
</style>

<?= view('public/layout/footer') ?>