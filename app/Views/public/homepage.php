<?php echo view('public/layout/header', ['page_title' => 'Home']); ?>

<!-- Hero Section -->
<section class="hero-section" style="background: none; min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; margin-top: 76px; padding: 2.5rem 1.5rem;">
    <!-- Blur Background Image -->
    <div style="position: absolute; inset: 0; background: url('https://i.pinimg.com/736x/cd/66/6a/cd666a84ab3c739f356c8b5b366731bb.jpg') center/cover no-repeat; filter: blur(2px) brightness(0.5); z-index: 0; transform: scale(1.05);"></div>

    <div class="container-fluid px-md-5" style="position: relative; z-index: 2;">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-10 d-flex flex-column flex-md-row align-items-center gap-4">

                <!-- Logo kiri (bergerak) -->
                <div class="text-md-start text-center fade-in-up" style="flex-shrink: 0; margin-left: -30px;">
                    <img src="/assets/images/inlislite.png" alt="Logo InlisLite" style="width: 320px; max-width: 100%; height: auto;">
                </div>

                <!-- Teks kanan (bergerak) -->
                <div class="text-center text-md-center fade-in-up" style="flex: 1; color: white;">
                    <h1 style="font-size: 3.2rem; font-weight: 700; margin-bottom: 1rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.3); font-family: 'Poppins', sans-serif; color: #ffffff;">
                        Selamat datang di InlisLite V3
                    </h1>
                    <p style="font-size: 1.25rem; line-height: 1.6; max-width: 800px; margin: 0 auto; text-shadow: 1px 1px 2px rgba(0,0,0,0.2); font-family: 'Poppins', sans-serif;">
                        Sebuah sistem otomasi perpustakaan yang modern, terintegrasi, dan bersifat open-source, dikembangkan oleh Perpustakaan Nasional Republik Indonesia.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Combined Features and Why Choose InlisLite Section -->
<section class="combined-features-section" id="featuresAndWhy">
    <!-- Animated Gradient Background -->
    <div class="gradient-bg"></div>
    
    <!-- Floating Particles -->
    <div class="particles-container">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Morphing SVG Shapes -->
    <div class="morphing-shapes">
        <svg class="morph-shape" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="rgba(59, 130, 246, 0.1)" d="M40.7,-69.8C50.9,-59.4,56.3,-43.2,64.4,-27.5C72.5,-11.8,83.3,3.4,83.6,19.1C83.9,34.8,73.7,51,59.6,61.5C45.5,72,27.5,76.8,8.9,75.2C-9.7,73.6,-28.9,65.6,-43.8,54.1C-58.7,42.6,-69.3,27.6,-74.4,10.1C-79.5,-7.4,-79.1,-27.4,-71.2,-42.8C-63.3,-58.2,-47.9,-69,-31.1,-68.9C-14.3,-68.8,3.9,-57.8,22.6,-52.4C41.3,-47,60.5,-47.2,40.7,-69.8Z" transform="translate(100 100)" />
        </svg>
        
        <svg class="morph-shape morph-shape-2" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="rgba(29, 78, 216, 0.08)" d="M44.3,-76.1C56.2,-68.3,64.4,-53.4,69.8,-37.8C75.2,-22.2,77.8,-5.9,75.9,9.7C74,25.3,67.6,40.2,57.8,51.8C48,63.4,34.8,71.7,20.2,75.4C5.6,79.1,-10.4,78.2,-25.1,73.8C-39.8,69.4,-53.2,61.5,-63.4,50.2C-73.6,38.9,-80.6,24.2,-82.1,8.8C-83.6,-6.6,-79.6,-22.7,-71.8,-36.4C-64,-50.1,-52.4,-61.4,-39.2,-68.8C-26,-76.2,-11.2,-79.7,4.2,-86.4C19.6,-93.1,32.4,-83.9,44.3,-76.1Z" transform="translate(100 100)" />
        </svg>
    </div>
    
    <!-- Gradient Waves -->
    <div class="gradient-waves">
        <svg class="wave" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="rgba(37, 99, 235, 0.1)" fill-opacity="1" d="M0,96L48,122.7C96,149,192,203,288,192C384,181,480,107,576,112C672,117,768,203,864,224C960,245,1056,203,1152,176C1248,149,1344,139,1392,133.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
        
        <svg class="wave wave-2" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="rgba(29, 78, 216, 0.08)" fill-opacity="1" d="M0,160L48,176C96,192,192,224,288,213.3C384,203,480,149,576,149.3C672,149,768,203,864,208C960,213,1056,171,1152,165.3C1248,160,1344,192,1392,208L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>

    <div class="container">
        <!-- First Section Header -->
        <div class="section-header">
            <h2 class="section-title">Keunggulan Sistem InlisLite V3</h2>
            <p class="section-subtitle">Solusi perpustakaan digital yang modern, terintegrasi, dan mudah digunakan</p>
        </div>

        <!-- Feature Cards -->
        <div class="features-grid">
            <!-- Card 1: Teknologi Modern -->
            <div class="glass-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-icon">
                    <i class="bi bi-cpu"></i>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Teknologi Modern</h3>
                    <p class="card-description">
                        Dibangun dengan teknologi terdepan dan arsitektur yang scalable untuk mendukung 
                        kebutuhan perpustakaan masa depan dengan performa optimal.
                    </p>
                    <div class="card-features">
                        <span class="feature-tag">Cloud Ready</span>
                        <span class="feature-tag">API Integration</span>
                        <span class="feature-tag">Real-time Sync</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Open Source -->
            <div class="glass-card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-icon">
                    <i class="bi bi-code-slash"></i>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Open Source & Gratis</h3>
                    <p class="card-description">
                        Bebas digunakan tanpa biaya lisensi, dengan kode sumber terbuka yang memungkinkan 
                        kustomisasi sesuai kebutuhan spesifik institusi Anda.
                    </p>
                    <div class="card-features">
                        <span class="feature-tag">No License Fee</span>
                        <span class="feature-tag">Customizable</span>
                        <span class="feature-tag">Community Support</span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Dukungan Nasional -->
            <div class="glass-card" data-aos="fade-up" data-aos-delay="300">
                <div class="card-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Dukungan Nasional</h3>
                    <p class="card-description">
                        Dikembangkan dan didukung langsung oleh Perpustakaan Nasional RI dengan 
                        standar keamanan tinggi dan dokumentasi lengkap dalam bahasa Indonesia.
                    </p>
                    <div class="card-features">
                        <span class="feature-tag">Official Support</span>
                        <span class="feature-tag">Secure</span>
                        <span class="feature-tag">Bahasa Indonesia</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Section Header -->
        <div class="section-header-why">
            <h2 class="section-title-why">Kenapa Memilih InlisLite?</h2>
            <p class="section-subtitle-why">Tiga alasan utama mengapa InlisLite menjadi pilihan terbaik untuk sistem perpustakaan modern</p>
        </div>

        <!-- Vertical Feature Cards -->
        <div class="vertical-features">
            <!-- Card 1: Otomasi & Digitalisasi -->
            <div class="full-width-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-visual">
                    <div class="card-icon-large">
                        <i class="bi bi-gear-wide-connected"></i>
                    </div>
                    <img src="/assets/images/digital-canva.png" alt="Otomasi Digital" class="card-illustration">
                </div>
                <div class="card-content-full">
                    <h3 class="card-title-large">Otomasi & Digitalisasi Terdepan</h3>
                    <p class="card-description-large">
                        Menghadirkan revolusi digital dalam pengelolaan perpustakaan dengan sistem otomasi yang canggih. 
                        Proses katalogisasi, sirkulasi, dan manajemen koleksi menjadi lebih efisien dan akurat dengan 
                        teknologi terdepan yang terintegrasi sempurna.
                    </p>
                    <div class="card-benefits">
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Katalogisasi Otomatis</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Sirkulasi Digital</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Laporan Real-time</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Backup Otomatis</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Gratis & Open Source -->
            <div class="full-width-card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-visual">
                    <div class="card-icon-large">
                        <i class="bi bi-code-slash"></i>
                    </div>
                    <img src="/assets/images/book canva.png" alt="Open Source" class="card-illustration">
                </div>
                <div class="card-content-full">
                    <h3 class="card-title-large">Gratis & Open Source Selamanya</h3>
                    <p class="card-description-large">
                        Nikmati kebebasan penuh tanpa biaya lisensi yang memberatkan. Dengan sifat open source, 
                        Anda dapat mengkustomisasi sistem sesuai kebutuhan spesifik institusi, mendapat dukungan 
                        komunitas global, dan berkontribusi dalam pengembangan sistem perpustakaan masa depan.
                    </p>
                    <div class="card-benefits">
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Tanpa Biaya Lisensi</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Kustomisasi Bebas</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Dukungan Komunitas</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Update Berkelanjutan</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Etis & Dapat Dimodifikasi -->
            <div class="full-width-card" data-aos="fade-up" data-aos-delay="300">
                <div class="card-visual">
                    <div class="card-icon-large">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <img src="/assets/images/ceklis canva.png" alt="Etis dan Aman" class="card-illustration">
                </div>
                <div class="card-content-full">
                    <h3 class="card-title-large">Etis, Aman & Dapat Dimodifikasi</h3>
                    <p class="card-description-large">
                        Dikembangkan dengan standar etika tinggi dan keamanan berlapis oleh Perpustakaan Nasional RI. 
                        Sistem yang fleksibel memungkinkan adaptasi dengan workflow institusi Anda, sambil menjaga 
                        integritas data dan privasi pengguna dengan standar keamanan internasional.
                    </p>
                    <div class="card-benefits">
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Standar Keamanan Tinggi</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Privasi Terjamin</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Workflow Fleksibel</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Dukungan Resmi Perpusnas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom Style -->
<style>
/* Dropdown effect */
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

/* Combined Features Section */
.combined-features-section {
    position: relative;
    min-height: 100vh;
    padding: 6rem 0;
    overflow: hidden;
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 20%, #1d4ed8 40%, #2563eb 60%, #1e40af 80%, #0f172a 100%);
}

/* Animated Gradient Background */
.gradient-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, 
        rgba(30, 58, 138, 0.8) 0%, 
        rgba(29, 78, 216, 0.6) 25%, 
        rgba(37, 99, 235, 0.4) 50%, 
        rgba(59, 130, 246, 0.6) 75%, 
        rgba(15, 23, 42, 0.8) 100%);
    animation: gradientShift 8s ease-in-out infinite;
}

@keyframes gradientShift {
    0%, 100% { 
        background: linear-gradient(45deg, 
            rgba(30, 58, 138, 0.8) 0%, 
            rgba(29, 78, 216, 0.6) 25%, 
            rgba(37, 99, 235, 0.4) 50%, 
            rgba(59, 130, 246, 0.6) 75%, 
            rgba(15, 23, 42, 0.8) 100%);
    }
    50% { 
        background: linear-gradient(225deg, 
            rgba(15, 23, 42, 0.8) 0%, 
            rgba(59, 130, 246, 0.6) 25%, 
            rgba(37, 99, 235, 0.4) 50%, 
            rgba(29, 78, 216, 0.6) 75%, 
            rgba(30, 58, 138, 0.8) 100%);
    }
}

/* Floating Particles */
.particles-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.particle:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; animation-duration: 6s; }
.particle:nth-child(2) { top: 80%; left: 20%; animation-delay: 1s; animation-duration: 8s; }
.particle:nth-child(3) { top: 40%; left: 70%; animation-delay: 2s; animation-duration: 7s; }
.particle:nth-child(4) { top: 60%; left: 80%; animation-delay: 3s; animation-duration: 9s; }
.particle:nth-child(5) { top: 10%; left: 50%; animation-delay: 4s; animation-duration: 5s; }
.particle:nth-child(6) { top: 90%; left: 60%; animation-delay: 5s; animation-duration: 8s; }
.particle:nth-child(7) { top: 30%; left: 30%; animation-delay: 2.5s; animation-duration: 6.5s; }
.particle:nth-child(8) { top: 70%; left: 90%; animation-delay: 1.5s; animation-duration: 7.5s; }

@keyframes float {
    0%, 100% { 
        transform: translateY(0px) translateX(0px) scale(1);
        opacity: 0.6;
    }
    25% { 
        transform: translateY(-20px) translateX(10px) scale(1.2);
        opacity: 1;
    }
    50% { 
        transform: translateY(-40px) translateX(-10px) scale(0.8);
        opacity: 0.8;
    }
    75% { 
        transform: translateY(-20px) translateX(15px) scale(1.1);
        opacity: 0.9;
    }
}

/* Section Header */
.section-header {
    text-align: center;
    margin-bottom: 4rem;
    position: relative;
    z-index: 10;
}

.section-title {
    font-size: 3rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 1rem;
    font-family: 'Poppins', sans-serif;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    letter-spacing: -0.02em;
}

.section-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    font-weight: 400;
}

/* Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    position: relative;
    z-index: 10;
}

/* Glass Cards */
.glass-card {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 24px;
    padding: 2.5rem;
    display: flex;
    align-items: center;
    gap: 2rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.glass-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.6s ease;
}

.glass-card:hover::before {
    left: 100%;
}

.glass-card:hover {
    transform: translateY(-8px);
    background: rgba(255, 255, 255, 0.12);
    border-color: rgba(255, 255, 255, 0.3);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
}

/* Card Icon */
.card-icon {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(147, 197, 253, 0.3));
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.card-icon i {
    font-size: 2rem;
    color: #ffffff;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

.glass-card:hover .card-icon {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.5), rgba(147, 197, 253, 0.5));
    transform: scale(1.1);
}

/* Card Content */
.card-content {
    flex: 1;
}

.card-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 1rem;
    font-family: 'Poppins', sans-serif;
}

.card-description {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

/* Feature Tags */
.card-features {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.feature-tag {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.glass-card:hover .feature-tag {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
}

/* Morphing SVG Shapes */
.morphing-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
}

.morph-shape {
    position: absolute;
    width: 300px;
    height: 300px;
    animation: morphShape 20s ease-in-out infinite;
}

.morph-shape:nth-child(1) {
    top: 10%;
    right: 10%;
    animation-delay: 0s;
}

.morph-shape-2 {
    bottom: 10%;
    left: 10%;
    animation-delay: 10s;
}

@keyframes morphShape {
    0%, 100% { 
        transform: rotate(0deg) scale(1);
        opacity: 0.6;
    }
    25% { 
        transform: rotate(90deg) scale(1.2);
        opacity: 0.8;
    }
    50% { 
        transform: rotate(180deg) scale(0.8);
        opacity: 0.4;
    }
    75% { 
        transform: rotate(270deg) scale(1.1);
        opacity: 0.7;
    }
}

/* Gradient Waves */
.gradient-waves {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 100%;
}

.wave {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 100%;
    animation: waveMove 15s ease-in-out infinite;
}

.wave-2 {
    animation-delay: 7.5s;
    animation-duration: 18s;
}

@keyframes waveMove {
    0%, 100% { 
        transform: translateX(0px);
        opacity: 0.6;
    }
    50% { 
        transform: translateX(-50px);
        opacity: 0.8;
    }
}

/* Section Header Why */
.section-header-why {
    text-align: center;
    margin-bottom: 5rem;
    position: relative;
    z-index: 10;
}

.section-title-why {
    font-size: 3.5rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 1.5rem;
    font-family: 'Poppins', sans-serif;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    letter-spacing: -0.02em;
}

.section-subtitle-why {
    font-size: 1.3rem;
    color: rgba(255, 255, 255, 0.9);
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
    font-weight: 400;
}

/* Vertical Features */
.vertical-features {
    display: flex;
    flex-direction: column;
    gap: 3rem;
    position: relative;
    z-index: 10;
}

/* Full Width Cards */
.full-width-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 32px;
    padding: 4rem;
    display: flex;
    align-items: center;
    gap: 3rem;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    width: 100%;
    max-width: 100%;
}

.full-width-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.8s ease;
}

.full-width-card:hover::before {
    left: 100%;
}

.full-width-card:hover {
    transform: translateY(-12px);
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.4);
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.25);
}

/* Card Visual */
.card-visual {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
}

.card-icon-large {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.4), rgba(147, 197, 253, 0.4));
    border-radius: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.3);
    transition: all 0.4s ease;
}

.card-icon-large i {
    font-size: 3rem;
    color: #ffffff;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
}

.full-width-card:hover .card-icon-large {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.6), rgba(147, 197, 253, 0.6));
    transform: scale(1.1) rotate(5deg);
}

.card-illustration {
    width: 150px;
    height: auto;
    filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.2));
    transition: all 0.4s ease;
}

.full-width-card:hover .card-illustration {
    transform: scale(1.05);
}

/* Card Content Full */
.card-content-full {
    flex: 1;
}

.card-title-large {
    font-size: 2.2rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 1.5rem;
    font-family: 'Poppins', sans-serif;
    line-height: 1.2;
}

.card-description-large {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.7;
    margin-bottom: 2rem;
}

/* Card Benefits */
.card-benefits {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.benefit-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.8rem 1.2rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.benefit-item:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.benefit-item i {
    color: #10b981;
    font-size: 1.2rem;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

.benefit-item span {
    color: #ffffff;
    font-weight: 500;
    font-size: 0.95rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .combined-features-section {
        padding: 4rem 0;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
    }
    
    .glass-card {
        flex-direction: column;
        text-align: center;
        padding: 2rem;
        gap: 1.5rem;
    }
    
    .card-icon {
        width: 60px;
        height: 60px;
    }
    
    .card-icon i {
        font-size: 1.5rem;
    }
    
    .card-title {
        font-size: 1.25rem;
    }
    
    .card-description {
        font-size: 0.9rem;
    }
    
    .section-title-why {
        font-size: 2.5rem;
    }
    
    .section-subtitle-why {
        font-size: 1.1rem;
    }
    
    .full-width-card {
        flex-direction: column;
        text-align: center;
        padding: 2.5rem;
        gap: 2rem;
    }
    
    .card-icon-large {
        width: 80px;
        height: 80px;
    }
    
    .card-icon-large i {
        font-size: 2rem;
    }
    
    .card-illustration {
        width: 120px;
    }
    
    .card-title-large {
        font-size: 1.8rem;
    }
    
    .card-description-large {
        font-size: 1rem;
    }
    
    .card-benefits {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .glass-card {
        padding: 1.5rem;
    }
    
    .section-title {
        font-size: 1.75rem;
    }
    
    .feature-tag {
        font-size: 0.75rem;
        padding: 0.3rem 0.6rem;
    }
    
    .full-width-card {
        padding: 2rem;
    }
    
    .section-title-why {
        font-size: 2rem;
    }
    
    .card-title-large {
        font-size: 1.5rem;
    }
    
    .card-description-large {
        font-size: 0.9rem;
    }
    
    .benefit-item {
        padding: 0.6rem 1rem;
    }
    
    .benefit-item span {
        font-size: 0.85rem;
    }
}
</style>

<link rel="stylesheet" href="/assets/css/public/homepage.css" /<script src="/assets/js/public/homepage.js"></script>

<!-- Enhanced Glassmorphism Feature Tags -->
<style/* Enhanced Glassmorphism Feature Tags Override */
.feature-tag {
    /* Glassmorphism Background */
    background: linear-gradient(135deg, 
        rgba(16, 185, 129, 0.3) 0%, 
        rgba(5, 150, 105, 0.4) 50%, 
        rgba(4, 120, 87, 0.3) 100%) !important;
    
    /* Backdrop Blur Effect */
    backdrop-filter: blur(15px) !important;
    -webkit-backdrop-filter: blur(15px) !important;
    
    /* Soft Green Border with Transparency */
    border: 1px solid rgba(16, 185, 129, 0.4) !important;
    border-radius: 18px !important;
    
    /* Enhanced Typography for Better Readability */
    color: #ffffff !important;
    font-size: 0.75rem !important;
    font-weight: 700 !important;
    letter-spacing: 0.03em !important;
    text-shadow: 
        0 1px 3px rgba(0, 0, 0, 0.3),
        0 0 8px rgba(16, 185, 129, 0.2) !important;
    
    /* Spacing */
    padding: 0.5rem 1rem !important;
    
    /* Enhanced Shadows for Better Depth */
    box-shadow: 
        0 6px 16px rgba(16, 185, 129, 0.2),
        0 3px 8px rgba(0, 0, 0, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 0.25),
        inset 0 -1px 0 rgba(16, 185, 129, 0.1) !important;
    
    /* Smooth Transitions */
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    
    /* Positioning */
    position: relative !important;
    overflow: hidden !important;
    
    /* Prevent text selection */
    user-select: none !important;
    -webkit-user-select: none !important;
}

/* Shimmer Effect on Hover */
.feature-tag::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, 
        transparent, 
        rgba(255, 255, 255, 0.2), 
        transparent);
    transition: left 0.6s ease;
}

.feature-tag:hover::before {
    left: 100%;
}

/* Enhanced Hover Effects */
.feature-tag:hover {
    /* Enhanced Background */
    background: linear-gradient(135deg, 
        rgba(16, 185, 129, 0.4) 0%, 
        rgba(5, 150, 105, 0.5) 50%, 
        rgba(4, 120, 87, 0.4) 100%) !important;
    
    /* Stronger Border */
    border-color: rgba(16, 185, 129, 0.5) !important;
    
    /* Enhanced Shadows */
    box-shadow: 
        0 8px 24px rgba(16, 185, 129, 0.25),
        0 4px 12px rgba(0, 0, 0, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 0.3) !important;
    
    /* Lift Effect */
    transform: translateY(-3px) scale(1.02) !important;
    
    /* Brighter Text */
    color: rgba(255, 255, 255, 1) !important;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2) !important;
}

.glass-card:hover .feature-tag {
    /* Subtle Enhancement when Parent is Hovered */
    border-color: rgba(16, 185, 129, 0.4) !important;
    box-shadow: 
        0 6px 18px rgba(16, 185, 129, 0.2),
        0 3px 8px rgba(0, 0, 0, 0.12),
        inset 0 1px 0 rgba(255, 255, 255, 0.25) !important;
}

/* Enhanced Card Features Container */
.card-features {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 0.75rem !important;
    margin-top: 0.5rem !important;
}

/* Responsive Adjustments for Enhanced Tags */
@media (max-width: 768px) {
    .card-features {
        gap: 0.5rem !important;
        justify-content: center !important;
    }
    
    .feature-tag {
        font-size: 0.7rem !important;
        padding: 0.4rem 0.8rem !important;
        border-radius: 12px !important;
    }
}

@media (max-width: 480px) {
    .feature-tag {
        font-size: 0.65rem !important;
        padding: 0.35rem 0.7rem !important;
        border-radius: 10px !important;
    }
}
</style>

<!-- Animasi CSS -->
<style>
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(40px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    opacity: 0;
    animation: fadeInUp 1.1s ease-out 0.3s forwards;
}
</style>

<?= view('public/layout/footer') ?>