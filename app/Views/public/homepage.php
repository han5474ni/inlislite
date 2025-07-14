<?php echo view('public/layout/header', ['page_title' => 'Home']); ?>

<!-- Hero Section -->
<section class="hero-section" style="background: none; min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; margin-top: 76px; padding: 2.5rem 1.5rem;">
    <!-- Blur Background Image -->
    <div style="position: absolute; inset: 0; background: url('https://i.pinimg.com/736x/cd/66/6a/cd666a84ab3c739f356c8b5b366731bb.jpg') center/cover no-repeat; filter: blur(2px) brightness(0.5); z-index: 0; transform: scale(1.05);"></div>

    <div class="container" style="position: relative; z-index: 2;">
        <div class="row align-items-center">
            <div class="col-md-12 col-lg-10">
                <div class="d-flex align-items-center flex-wrap gap-4" style="padding: 2rem 0;">
                    <!-- Logo InlisLite -->
                    <img src="/assets/images/inlislite.png" alt="Logo InlisLite" style="width: 200px; height: auto;">

                    <!-- Teks Judul -->
                    <div style="color: white;">
                        <h1 style="font-size: 3rem; font-weight: 700; margin-bottom: 0.5rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.3); font-family: 'Poppins', sans-serif;">
                            Selamat datang di InlisLite V3
                        </h1>
                        <p style="font-size: 1.25rem; line-height: 1.6; max-width: 750px; text-shadow: 1px 1px 2px rgba(0,0,0,0.2); font-family: 'Poppins', sans-serif;">
                            Sebuah sistem otomasi perpustakaan yang modern, terintegrasi, dan bersifat open-source, dikembangkan oleh Perpustakaan Nasional Republik Indonesia.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Kenapa InlisLite Section (Versi Ringkas & Modern) -->
<section class="features-section" style="background: linear-gradient(180deg, #046BB5 0%, #024D96 100%); padding: 4rem 1rem; position: relative; overflow: hidden; margin-top: 0;">
    <div style="position: absolute; inset: 0; background: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 60 60&quot;%3E%3Cpath d=&quot;M30 30m-2 0a2 2 0 1 1 4 0a2 2 0 1 1 -4 0&quot; fill=&quot;rgba(255,255,255,0.05)&quot;/%3E%3C/svg%3E'); background-size: 60px 60px; opacity: 0.3; pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 2;">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 style="font-size: 2.5rem; font-weight: 700; color: #FFFFFF; text-shadow: 1px 1px 3px rgba(0,0,0,0.3); font-family: 'Poppins', sans-serif;">
                    Kenapa InlisLite?
                </h2>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Card 1 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div style="
                    background: rgba(255, 255, 255, 0.08);
                    backdrop-filter: blur(12px);
                    border-radius: 1rem;
                    padding: 1.5rem 1rem;
                    text-align: center;
                    border: 1px solid rgba(255, 255, 255, 0.15);
                    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
                    transition: all 0.3s ease;
                ">
                    <img src="/assets/images/digital-canva.png" alt="Otomasi" style="width: 90px; height: auto; margin-bottom: 1rem;">
                    <h4 style="font-size: 1rem; font-weight: 600; color: #fff; margin-bottom: 0.5rem;">
                        Otomasi & Digitalisasi
                    </h4>
                    <p style="font-size: 0.85rem; color: #e8e8e8; line-height: 1.5; margin: 0;">
                        Mengotomatisasi proses perpustakaan dengan teknologi digital terdepan.
                    </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div style="
                    background: rgba(255, 255, 255, 0.08);
                    backdrop-filter: blur(12px);
                    border-radius: 1rem;
                    padding: 1.5rem 1rem;
                    text-align: center;
                    border: 1px solid rgba(255, 255, 255, 0.15);
                    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
                    transition: all 0.3s ease;
                ">
                    <img src="/assets/images/book canva.png" alt="Opensource" style="width: 90px; height: auto; margin-bottom: 1rem;">
                    <h4 style="font-size: 1rem; font-weight: 600; color: #fff; margin-bottom: 0.5rem;">
                        Gratis & Opensource
                    </h4>
                    <p style="font-size: 0.85rem; color: #e8e8e8; line-height: 1.5; margin: 0;">
                        Bebas digunakan dan disesuaikan tanpa biaya lisensi yang mahal.
                    </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div style="
                    background: rgba(255, 255, 255, 0.08);
                    backdrop-filter: blur(12px);
                    border-radius: 1rem;
                    padding: 1.5rem 1rem;
                    text-align: center;
                    border: 1px solid rgba(255, 255, 255, 0.15);
                    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
                    transition: all 0.3s ease;
                ">
                    <img src="/assets/images/ceklis canva.png" alt="Etis" style="width: 90px; height: auto; margin-bottom: 1rem;">
                    <h4 style="font-size: 1rem; font-weight: 600; color: #fff; margin-bottom: 0.5rem;">
                        Etis & Dapat Dimodifikasi
                    </h4>
                    <p style="font-size: 0.85rem; color: #e8e8e8; line-height: 1.5; margin: 0;">
                        Dikembangkan dengan etika tinggi dan fleksibel untuk kebutuhan institusi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Dropdown Animation CSS -->
<style>
.dropdown-menu {
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.2s ease-out, transform 0.2s ease-out;
    display: block;
    visibility: hidden;
}

.dropdown:hover .dropdown-menu {
    opacity: 1;
    transform: translateY(0);
    visibility: visible;
}
</style>

<link rel="stylesheet" href="/assets/css/public/homepage.css" />
<script src="/assets/js/public/homepage.js"></script>

<?php echo view('public/layout/footer'); ?>
