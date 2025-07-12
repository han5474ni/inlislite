<?php echo view('public/layout/header', ['page_title' => 'Home']); ?>

<!-- Hero Section -->
<section class="hero-section" style="background-color: #2563eb; min-height: 100vh; display: flex; align-items: center; position: relative; margin-top: 76px; padding: 2.5rem 1.5rem;">
    <div class="container" style="position: relative; z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="text-center">
                    <div class="hero-card" style="background-color: rgba(255, 255, 255, 0.95); border-radius: 24px; padding: 4rem 3rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); max-width: 100%; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
                        <div class="hero-headline mb-4">
                            <h1 class="hero-title-welcome" style="font-size: 3rem; font-weight: 600; margin-bottom: 0.5rem; animation: slideUp 0.8s ease-out; line-height: 1.2; font-family: 'Inter', 'Poppins', sans-serif; color: #374151;">
                                Selamat datang di
                            </h1>
                            <h1 class="hero-title-main" style="font-size: 4rem; font-weight: 700; margin-bottom: 2rem; animation: slideUp 0.8s ease-out 0.1s both; line-height: 1.1; font-family: 'Inter', 'Poppins', sans-serif; color: #2563eb;">
                                InlisLite V3
                            </h1>
                        </div>
                        <div class="hero-body">
                            <p class="hero-description" style="font-size: 1.25rem; color: #6b7280; margin-bottom: 0; animation: slideUp 0.8s ease-out 0.2s both; line-height: 1.6; font-weight: 400; font-family: 'Inter', 'Poppins', sans-serif;">
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
<section class="features-section" style="background-color: #f9fafb; padding: 5rem 1.5rem; position: relative; margin-top: 0;">
    <div class="container" style="position: relative; z-index: 2;">
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="features-title" style="text-align: center; font-size: 3rem; font-weight: 700; margin-bottom: 3rem; color: #1f2937; animation: slideUp 0.8s ease-out; font-family: 'Inter', 'Poppins', sans-serif;">
                    Kenapa InlisLite?
                </h2>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon" style="background-color: #2563eb;">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <h4 class="feature-title">
                        Otomasi & Digitalisasi Terpadu
                    </h4>
                    <p class="feature-description">
                        Sistem terintegrasi yang mengotomatisasi seluruh proses perpustakaan dengan teknologi digital terdepan.
                    </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon" style="background-color: #059669;">
                        <i class="bi bi-code-slash"></i>
                    </div>
                    <h4 class="feature-title">
                        Gratis, Opensource & Fleksibel
                    </h4>
                    <p class="feature-description">
                        Solusi perpustakaan yang dapat disesuaikan dengan kebutuhan tanpa biaya lisensi yang mahal.
                    </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon" style="background-color: #ea580c;">
                        <i class="bi bi-shield-check-fill"></i>
                    </div>
                    <h4 class="feature-title">
                        Penggunaan & Modifikasi Etis
                    </h4>
                    <p class="feature-description">
                        Dikembangkan dengan standar etika tinggi dan dapat dimodifikasi sesuai kebutuhan institusi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="/assets/css/public/homepage.css" />
<script src="/assets/js/public/homepage.js"></script>

<?php echo view('public/layout/footer'); ?>
