<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero-section" style="--hero-bg-url: url('<?= base_url('assets/images/hero.jpeg') ?>');">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <div class="container-fluid px-md-5 hero-content">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 col-xl-10 d-flex flex-column flex-md-row align-items-center gap-4">

                <!-- Logo kiri -->
                <div class="text-md-start text-center fade-in-up hero-logo">
                    <img src="<?= base_url('assets/images/inlislite.png') ?>" alt="Logo InlisLite">
                </div>

                <!-- Teks kanan -->
                <div class="text-center text-md-center fade-in-up hero-text">
                    <h1 class="hero-title">INLISLite v3</h1>
                    <p class="hero-subtitle">
                        Sistem otomasi perpustakaan yang modern, sederhana, dan mudah digunakan.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Why Choose INLISLite - Simple Card Grid -->
<section class="why-choose-section">
    <div class="container">
        <div class="why-header text-center">
            <h2 class="why-title">Mengapa memilih INLISLite?</h2>
            <p class="why-subtitle">Fokus pada yang penting: cepat, stabil, dan gratis.</p>
        </div>

        <div class="why-cards-grid">
            <!-- Card: Teknologi Modern -->
            <div class="why-card">
                <div class="icon-badge badge-blue">
                    <i class="bi bi-cpu"></i>
                </div>
                <h3 class="why-card-title">Teknologi Modern</h3>
                <p class="why-card-text">Dibangun di atas framework modern dengan performa yang andal.</p>
            </div>

            <!-- Card: Open Source -->
            <div class="why-card">
                <div class="icon-badge badge-green">
                    <i class="bi bi-code-slash"></i>
                </div>
                <h3 class="why-card-title">Open Source</h3>
                <p class="why-card-text">Gratis, dapat dimodifikasi, dan didukung komunitas.</p>
            </div>

            <!-- Card: Aman & Terpercaya -->
            <div class="why-card">
                <div class="icon-badge badge-cyan">
                    <i class="bi bi-shield"></i>
                </div>
                <h3 class="why-card-title">Aman & Terpercaya</h3>
                <p class="why-card-text">Dikembangkan dengan standar keamanan yang baik.</p>
            </div>

            <!-- Card: Mudah Dioperasikan -->
            <div class="why-card">
                <div class="icon-badge badge-yellow">
                    <i class="bi bi-gear"></i>
                </div>
                <h3 class="why-card-title">Mudah Dioperasikan</h3>
                <p class="why-card-text">Antarmuka yang bersih dan alur kerja sederhana.</p>
            </div>

            <!-- Card: Skalabel -->
            <div class="why-card">
                <div class="icon-badge badge-pink">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <h3 class="why-card-title">Skalabel</h3>
                <p class="why-card-text">Siap digunakan dari perpustakaan kecil hingga besar.</p>
            </div>

            <!-- Card: Siap Cloud -->
            <div class="why-card">
                <div class="icon-badge badge-gray">
                    <i class="bi bi-cloud"></i>
                </div>
                <h3 class="why-card-title">Siap Cloud</h3>
                <p class="why-card-text">Dapat di-deploy di server lokal maupun cloud.</p>
            </div>
        </div>
    </div>
</section>

<style>
    /* Why Choose INLISLite - Card Grid Styles */
    .why-choose-section { background:#f3f4f6; padding: 3rem 0 2.5rem; }
    .why-header { margin-bottom: 1.25rem; }
    .why-title { font-weight:800; font-size:2rem; color:#111827; margin:0; }
    .why-subtitle { color:#6b7280; margin-top:.25rem; }
    .why-cards-grid { display:grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 1.25rem; margin-top:1rem; }
    @media (max-width: 992px) { .why-cards-grid { grid-template-columns: repeat(2,minmax(0,1fr)); } }
    @media (max-width: 576px) { .why-cards-grid { grid-template-columns: 1fr; } }

    .why-card { position:relative; background:#ffffff; border:1px solid #e5e7eb; border-radius:18px; padding:1.5rem; padding-top:2.25rem; box-shadow: 0 10px 0 rgba(0,0,0,0.12), 0 10px 18px rgba(0,0,0,0.12); transition: transform .2s ease, box-shadow .2s ease; }
    .why-card:hover { transform: translateY(-2px); box-shadow: 0 12px 0 rgba(0,0,0,0.16), 0 16px 30px rgba(0,0,0,0.16); }

    .icon-badge { position:absolute; top:-18px; left:18px; width:56px; height:56px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#0f172a; background:#e5e7eb; border:1px solid rgba(0,0,0,0.05); filter: drop-shadow(0 10px 10px rgba(0,0,0,0.25)); }
    .icon-badge i { font-size: 1.4rem; color:#0f172a; }

    .badge-blue { background: linear-gradient(135deg,#93c5fd,#60a5fa); }
    .badge-green { background: linear-gradient(135deg,#86efac,#34d399); }
    .badge-cyan { background: linear-gradient(135deg,#a5f3fc,#67e8f9); }
    .badge-yellow { background: linear-gradient(135deg,#fde68a,#fbbf24); }
    .badge-pink { background: linear-gradient(135deg,#fbcfe8,#f472b6); }
    .badge-gray { background: linear-gradient(135deg,#e5e7eb,#cbd5e1); }

    .why-card-title { font-size:1.05rem; font-weight:700; color:#111827; margin:0 0 .25rem; }
    .why-card-text { font-size:.95rem; color:#6b7280; margin:0; }
</style>
<style>
  /* Hide blue wave/gradient blob area */
  .gradient-waves, .gradient-bg, .morphing-shapes, .particles-container, .combined-features-section { display: none !important; }
</style>



<!-- Custom Style -->
<style>
/* Dropdown effect */
.dropdown-menu { 

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
        rgb(30, 58, 138) 0%, 
        rgb(29, 78, 216) 25%, 
        rgb(37, 99, 235) 50%, 
        rgb(59, 130, 246) 75%, 
        rgb(15, 23, 42) 100%);
    animation: gradientShift 8s ease-in-out infinite;
}

@keyframes gradientShift {
    0%, 100% { 
        background: linear-gradient(45deg, 
            rgb(30, 58, 138) 0%, 
            rgb(29, 78, 216) 25%, 
            rgb(37, 99, 235) 50%, 
            rgb(59, 130, 246) 75%, 
            rgb(15, 23, 42) 100%);
    }
    50% { 
        background: linear-gradient(225deg, 
            rgb(15, 23, 42) 0%, 
            rgb(59, 130, 246) 25%, 
            rgb(37, 99, 235) 50%, 
            rgb(29, 78, 216) 75%, 
            rgb(30, 58, 138) 100%);
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
    background: rgb(255, 255, 255);
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
        opacity: 1;
    }
    25% { 
        transform: translateY(-20px) translateX(10px) scale(1.2);
        opacity: 1;
    }
    50% { 
        transform: translateY(-40px) translateX(-10px) scale(0.8);
        opacity: 1;
    }
    75% { 
        transform: translateY(-20px) translateX(15px) scale(1.1);
        opacity: 1;
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
    text-shadow: 0 4px 20px rgb(0, 0, 0);
    letter-spacing: -0.02em;
}

.section-subtitle {
    font-size: 1.25rem;
    color: rgb(255, 255, 255);
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
    background: rgb(255, 255, 255);
    backdrop-filter: blur(20px);
    border: 1px solid rgb(255, 255, 255);
    border-radius: 24px;
    padding: 2.5rem;
    display: flex;
    align-items: center;
    gap: 2rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px rgb(0, 0, 0);
}

.glass-card::before {  

/* Card Icon */
.card-icon {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgb(59, 130, 246), rgb(147, 197, 253));
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgb(255, 255, 255);
    transition: all 0.3s ease;
}

.card-icon i { 

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
    color: rgb(255, 255, 255);
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
        opacity: 1;
    }
    25% { 
        transform: rotate(90deg) scale(1.2);
        opacity: 1;
    }
    50% { 
        transform: rotate(180deg) scale(0.8);
        opacity: 1;
    }
    75% { 
        transform: rotate(270deg) scale(1.1);
        opacity: 1;
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
        opacity: 1;
    }
    50% { 
        transform: translateX(-50px);
        opacity: 1;
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
    text-shadow: 0 4px 20px rgb(0, 0, 0);
    letter-spacing: -0.02em;
}

.section-subtitle-why {
    font-size: 1.3rem;
    color: rgb(255, 255, 255);
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
    background: rgb(255, 255, 255);
    backdrop-filter: blur(25px);
    border: 1px solid rgb(255, 255, 255);
    border-radius: 32px;
    padding: 4rem;
    display: flex;
    align-items: center;
    gap: 3rem;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 40px rgb(0, 0, 0);
    width: 100%;
    max-width: 100%;
}

.full-width-card::before {  

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
    background: linear-gradient(135deg, rgb(59, 130, 246), rgb(147, 197, 253));
    border-radius: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgb(255, 255, 255);
    transition: all 0.4s ease;
}

.card-icon-large i { 

.card-illustration { 

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
    color: rgb(255, 255, 255);
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

.benefit-item i {
    color: #10b981;
    font-size: 1.2rem;
    filter: drop-shadow(0 2px 4px rgb(0, 0, 0));
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


<!-- Enhanced Glassmorphism Feature Tags -->
<style/* Enhanced Glassmorphism Feature Tags Override */
.feature-tag {
    /* Glassmorphism Background */
    background: linear-gradient(135deg, 
        rgb(16, 185, 129) 0%, 
        rgb(5, 150, 105) 50%, 
        rgb(4, 120, 87) 100%) !important;
    
    /* Backdrop Blur Effect */
    backdrop-filter: blur(15px) !important;
    -webkit-backdrop-filter: blur(15px) !important;
    
    /* Soft Green Border with Transparency */
    border: 1px solid rgb(16, 185, 129) !important;
    border-radius: 18px !important;
    
    /* Enhanced Typography for Better Readability */
    color: #ffffff !important;
    font-size: 0.75rem !important;
    font-weight: 700 !important;
    letter-spacing: 0.03em !important;
    text-shadow: 
        0 1px 3px rgb(0, 0, 0),
        0 0 8px rgb(16, 185, 129) !important;
    
    /* Spacing */
    padding: 0.5rem 1rem !important;
    
    /* Enhanced Shadows for Better Depth */
    box-shadow: 
        0 6px 16px rgb(16, 185, 129),
        0 3px 8px rgb(0, 0, 0),
        inset 0 1px 0 rgb(255, 255, 255),
        inset 0 -1px 0 rgb(16, 185, 129) !important;
    
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
        rgb(255, 255, 255), 
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
        rgb(16, 185, 129) 0%, 
        rgb(5, 150, 105) 50%, 
        rgb(4, 120, 87) 100%) !important;
    
    /* Stronger Border */
    border-color: rgb(16, 185, 129) !important;
    
    /* Enhanced Shadows */
    box-shadow: 
        0 8px 24px rgb(16, 185, 129),
        0 4px 12px rgb(0, 0, 0),
        inset 0 1px 0 rgb(255, 255, 255) !important;
    
    /* Lift Effect */
    transform: translateY(-3px) scale(1.02) !important;
    
    /* Brighter Text */
    color: rgb(255, 255, 255) !important;
    text-shadow: 0 2px 4px rgb(0, 0, 0) !important;
}

.glass-card:hover .feature-tag {
    /* Subtle Enhancement when Parent is Hovered */
    border-color: rgb(16, 185, 129) !important;
    box-shadow: 
        0 6px 18px rgb(16, 185, 129),
        0 3px 8px rgb(0, 0, 0),
        inset 0 1px 0 rgb(255, 255, 255) !important;
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

<!-- Override & polish cards layout for better proportions -->
<style>
/* Features grid: 3 cols on large, 2 on medium, 1 on small */
.features-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); align-items: stretch; }
@media (max-width: 992px) { .features-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 576px) { .features-grid { grid-template-columns: 1fr; } }

/* Glass cards: lighter glass, subtler shadow, consistent height */
.features-grid .glass-card { 
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.18);
    box-shadow: 0 6px 24px rgba(0,0,0,0.25);
    padding: 2rem;
    height: 100%;
}
.features-grid .glass-card .card-icon i { color:#fff; font-size:1.6rem; }

/* Full-width cards: use same glass style so text putih tetap terbaca */
.full-width-card {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.18);
    box-shadow: 0 10px 36px rgba(0,0,0,0.35);
}
.card-illustration { width: 160px; height:auto; }

/* Tighten vertical spacing */
.section-header { margin-bottom: 3rem; }
.vertical-features { gap: 2.5rem; }
</style>

<!-- Animasi CSS -->
<style>
@keyframes fadeInUp {
    0% {
        opacity: 1;
        transform: translateY(40px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    opacity: 1;
    animation: fadeInUp 1.1s ease-out 0.3s forwards;
}
</style>

<?= $this->endSection() ?>

