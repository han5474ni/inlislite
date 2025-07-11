<?php echo view('public/layout/header', ['page_title' => 'Home']); ?>

<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(180deg, #6FD09A 0%, #046BB5 100%); min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; margin-top: 76px; padding: 2.5rem 1.5rem;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"%3E%3Ccircle cx=\"50\" cy=\"50\" r=\"1\" fill=\"rgba(255,255,255,0.1)\"/%3E%3C/svg%3E'); background-size: 50px 50px; opacity: 0.3; pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="text-center">
                    <div class="hero-card" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); border-radius: 1.5rem; padding: 4rem 3rem; border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), 0 2px 8px rgba(255, 255, 255, 0.1) inset; max-width: 100%; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                        <div class="hero-headline mb-4">
                            <h1 class="hero-title-welcome"
                             style="
                              font-size: 3rem;
                              font-weight: 600;
                            margin-bottom: 0.5rem;
                            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
                             animation: slideUp 0.8s ease-out;
                            line-height: 1.2;
                            font-family: 'Poppins', sans-serif;
                            background: linear-gradient(135deg, #002557, #004AAD, #1C6EC4);
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            ">
                            Selamat datang di
                            </h1>
                            <h1 class="hero-title-main"
                            style="
                            font-size: 4rem;
                            font-weight: 700;
                            margin-bottom: 2rem;
                            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
                            animation: slideUp 0.8s ease-out 0.1s both;
                            line-height: 1.1;
                            font-family: 'Poppins', sans-serif;
                            background: linear-gradient(135deg, #002557, #004AAD, #1C6EC4);
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            ">
                         InlisLite V3
                        </h1>
                        </div>
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
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 60 60\"%3E%3Cpath d=\"M30 30m-2 0a2 2 0 1 1 4 0a2 2 0 1 1 -4 0\" fill=\"rgba(255,255,255,0.05)\"/%3E%3C/svg%3E'); background-size: 60px 60px; opacity: 0.4; pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 2;">
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="features-title" style="text-align: center; font-size: 3rem; font-weight: 700; margin-bottom: 3rem; color: #FFFFFF; text-shadow: 1px 1px 3px rgba(0,0,0,0.3); animation: slideUp 0.8s ease-out; font-family: 'Poppins', sans-serif;">
                    Kenapa InlisLite?
                </h2>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="feature-card animate-on-scroll" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); border-radius: 1.5rem; padding: 3rem 2rem; text-align: center; height: 100%; border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1), 0 1px 4px rgba(255, 255, 255, 0.1) inset; transition: all 0.4s ease;">
                    <img src="/assets/images/digital-canva.png" alt="Otomasi" style="width: 200px; height: auto; margin-bottom, 1.6rem">
                    <h4 class="feature-title" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #FFFFFF; line-height: 1.3; text-shadow: 1px 1px 2px rgba(0,0,0,0.2); font-family: 'Poppins', sans-serif;">
                        Otomasi & Digitalisasi Terpadu
                    </h4>
                    <p class="feature-description" style="color: #F0F0F0; line-height: 1.6; font-size: 0.95rem; font-family: 'Poppins', sans-serif;">
                        Sistem terintegrasi yang mengotomatisasi seluruh proses perpustakaan dengan teknologi digital terdepan.
                    </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="feature-card animate-on-scroll" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); border-radius: 1.5rem; padding: 3rem 2rem; text-align: center; height: 100%; border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1), 0 1px 4px rgba(255, 255, 255, 0.1) inset; transition: all 0.4s ease;">
                    <img src="/assets/images/book canva.png" alt="Opensource" style="width: 200px; height: auto; margin-bottom: 1.5rem;">
                    <h4 class="feature-title" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #FFFFFF; line-height: 1.3; font-family: 'Poppins', sans-serif;">
                        Gratis, Opensource & Fleksibel
                    </h4>
                    <p class="feature-description" style="color: #F0F0F0; line-height: 1.6; font-size: 0.95rem; font-family: 'Poppins', sans-serif;">
                        Solusi perpustakaan yang dapat disesuaikan dengan kebutuhan tanpa biaya lisensi yang mahal.
                    </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="feature-card animate-on-scroll" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); border-radius: 1.5rem; padding: 3rem 2rem; text-align: center; height: 100%; border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1), 0 1px 4px rgba(255, 255, 255, 0.1) inset; transition: all 0.4s ease;">
                    <img src="/assets/images/ceklis canva.png" alt="Etis" style="width: 200px; height: auto; margin-bottom: 1.5rem;">
                    <h4 class="feature-title" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #FFFFFF; line-height: 1.3; font-family: 'Poppins', sans-serif;">
                        Penggunaan & Modifikasi Etis
                    </h4>
                    <p class="feature-description" style="color: #F0F0F0; line-height: 1.6; font-size: 0.95rem; font-family: 'Poppins', sans-serif;">
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
