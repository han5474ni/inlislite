<?= view('public/layout/header', ['page_title' => $page_title ?? 'Dukungan Teknis']) ?>

<!-- Page Header -->
<header class="page-header" style="
    position: relative;
    background: url('https://i.pinimg.com/736x/cd/66/6a/cd666a84ab3c739f356c8b5b366731bb.jpg') center/cover no-repeat;
    background-attachment: fixed;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
    overflow: hidden;
    margin-top: 76px;
">
    <!-- Overlay dan efek blur -->
    <div style="
        content: '';
        position: absolute;
        inset: 0;
        backdrop-filter: blur(2px);
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
    "></div>

    <!-- Konten header -->
    <div class="container" style="position: relative; z-index: 2;">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center" style="padding: 2rem;">
                    <div class="page-icon mb-3">
                        <i class="bi bi-headset" style="font-size: 4rem; color: white;"></i>
                    </div>
                    <h1 class="page-title" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">
                        Dukungan Teknis
                    </h1>
                    <p class="page-subtitle" style="font-size: 1.125rem; max-width: 800px; margin: 0 auto; opacity: 0.85;">
                        Paket unduhan dan instalasi
                    </p>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dukungan Teknis</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        
        <!-- Section 1: Main Card -->
        <section class="main-card-section">
            <div class="main-card">
                <div class="main-card-header">
                    <div class="main-card-title">
                        <i class="bi bi-tools text-primary me-2"></i>
                        <h2>Layanan Dukungan Teknis</h2>
                    </div>
                </div>
                <div class="main-card-body">
                    <p>Dapatkan bantuan teknis profesional dari Tim Sistem Informasi Pusat Data dan Informasi untuk sistem manajemen perpustakaan INLISLite versi 3.</p>
                </div>
            </div>
        </section>

        <!-- Section 2: Two Side-by-Side Cards -->
        <section class="two-cards-section">
            <div class="row g-4">
                <!-- Left Card: Tim Sistem Informasi -->
                <div class="col-lg-6">
                    <div class="info-card blue-border">
                        <div class="info-card-header">
                            <h3 class="info-card-title">Tim Sistem Informasi</h3>
                            <p class="info-card-subtitle">Pusat Data dan Informasi – Perpustakaan Nasional Republik Indonesia</p>
                        </div>
                        <div class="info-card-body">
                            <div class="contact-list">
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-telephone-fill text-success"></i>
                                    </div>
                                    <div class="contact-info">
                                        <strong>Telepon:</strong> (021) 3103545
                                    </div>
                                </div>
                                
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-envelope-fill text-primary"></i>
                                    </div>
                                    <div class="contact-info">
                                        <strong>Email:</strong> pdi@perpusnas.go.id
                                    </div>
                                </div>
                                
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-geo-alt-fill text-danger"></i>
                                    </div>
                                    <div class="contact-info">
                                        <strong>Alamat Kantor:</strong> Jl. Medan Merdeka Selatan No. 11 Jakarta Pusat 10110
                                    </div>
                                </div>
                                
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-clock-fill text-warning"></i>
                                    </div>
                                    <div class="contact-info">
                                        <strong>Jam Layanan:</strong> Senin – Jumat: 08:00 – 16:00 WIB
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Card: Layanan Dukungan -->
                <div class="col-lg-6">
                    <div class="info-card green-border">
                        <div class="info-card-header">
                            <h3 class="info-card-title">Layanan Dukungan yang Tersedia</h3>
                        </div>
                        <div class="info-card-body">
                            <div class="services-list">
                                <div class="service-item">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>Dukungan Instalasi</span>
                                </div>
                                <div class="service-item">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>Pemecahan Masalah Teknis</span>
                                </div>
                                <div class="service-item">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>Pelatihan Pengguna</span>
                                </div>
                                <div class="service-item">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>Bantuan Jarak Jauh</span>
                                </div>
                                <div class="service-item">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>Dokumentasi & Panduan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 3: Full Width Bottom Box -->
        <section class="bottom-box-section">
            <div class="bottom-box">
                <div class="bottom-box-header">
                    <h3 class="bottom-box-title">Cara Meminta Bantuan Teknis</h3>
                    <p class="bottom-box-subtitle">Ikuti langkah-langkah berikut untuk mendapatkan bantuan dari tim dukungan teknis kami:</p>
                </div>
                <div class="bottom-box-body">
                    <div class="row g-4">
                        <!-- Left Column: Dukungan Langsung -->
                        <div class="col-lg-6">
                            <div class="support-method">
                                <h4 class="support-method-title">Untuk Dukungan Langsung</h4>
                                <div class="support-steps">
                                    <div class="support-step">
                                        <i class="bi bi-telephone me-2 text-primary"></i>
                                        <span>Hubungi hotline dukungan kami: (021) 3103545</span>
                                    </div>
                                    <div class="support-step">
                                        <i class="bi bi-envelope me-2 text-primary"></i>
                                        <span>Kirim email ke: info@perpusnas.go.id</span>
                                    </div>
                                    <div class="support-step">
                                        <i class="bi bi-clock me-2 text-primary"></i>
                                        <span>Tersedia selama jam kerja</span>
                                    </div>
                                    <div class="support-step">
                                        <i class="bi bi-info-circle me-2 text-primary"></i>
                                        <span>Siapkan detail sistem Anda saat menghubungi</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Dukungan Lokasi -->
                        <div class="col-lg-6">
                            <div class="support-method">
                                <h4 class="support-method-title">Untuk Dukungan Lokasi</h4>
                                <div class="support-steps">
                                    <div class="support-step">
                                        <i class="bi bi-file-text me-2 text-success"></i>
                                        <span>Kirimkan surat permohonan resmi</span>
                                    </div>
                                    <div class="support-step">
                                        <i class="bi bi-building me-2 text-success"></i>
                                        <span>Sertakan detail lembaga dan informasi kontak</span>
                                    </div>
                                    <div class="support-step">
                                        <i class="bi bi-calendar-check me-2 text-success"></i>
                                        <span>Sistem akan dijadwalkan untuk dikunjungi</span>
                                    </div>
                                    <div class="support-step">
                                        <i class="bi bi-clock-history me-2 text-success"></i>
                                        <span>Waktu penjadwalan: 3–5 hari kerja</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</main>

<style>
/* Import Fonts */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap');

/* Global Styles */
body {
    font-family: 'Inter', 'Poppins', sans-serif;
}

/* Main Content */
.main-content {
    padding: 4rem 0;
    background: #f8fafc;
    min-height: calc(100vh - 200px);
}

/* Section 1: Main Card */
.main-card-section {
    margin-bottom: 2rem;
}

.main-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.main-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background: #f8fafc;
}

.main-card-title {
    display: flex;
    align-items: center;
    margin: 0;
}

.main-card-title h2 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.edit-btn {
    border-color: #9ca3af;
    color: #6b7280;
    font-size: 0.875rem;
}

.edit-btn:hover {
    border-color: #6b7280;
    color: #374151;
}

.main-card-body {
    padding: 1.5rem;
}

.main-card-body p {
    color: #6b7280;
    line-height: 1.6;
    margin: 0;
}

/* Section 2: Two Cards */
.two-cards-section {
    margin-bottom: 2rem;
}

.info-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    height: 100%;
    overflow: hidden;
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

.blue-border {
    border: 2px solid #3b82f6;
}

.green-border {
    border: 2px solid #10b981;
}

.info-card-header {
    padding: 1.5rem;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
}

.info-card-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.info-card-subtitle {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
    font-style: italic;
}

.info-card-body {
    padding: 1.5rem;
}

/* Contact List */
.contact-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.contact-icon {
    flex-shrink: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.contact-icon i {
    font-size: 1rem;
}

.contact-info {
    flex: 1;
    color: #374151;
    font-size: 0.9rem;
    line-height: 1.5;
}

.contact-info strong {
    color: #1f2937;
}

/* Services List */
.services-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.service-item {
    display: flex;
    align-items: center;
    padding: 0.75rem;
    background: #f0fdf4;
    border-radius: 8px;
    border: 1px solid #bbf7d0;
    transition: all 0.3s ease;
}

.service-item:hover {
    background: #dcfce7;
    border-color: #86efac;
}

.service-item i {
    font-size: 1rem;
}

.service-item span {
    color: #374151;
    font-weight: 500;
    font-size: 0.9rem;
}

/* Section 3: Bottom Box */
.bottom-box-section {
    margin-bottom: 2rem;
}

.bottom-box {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.bottom-box-header {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 1.5rem;
    text-align: center;
}

.bottom-box-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.bottom-box-subtitle {
    font-size: 0.95rem;
    margin: 0;
    opacity: 0.9;
}

.bottom-box-body {
    padding: 2rem;
}

/* Support Methods */
.support-method-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e5e7eb;
}

.support-steps {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.support-step {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.support-step:hover {
    background: #f1f5f9;
    border-color: #d1d5db;
}

.support-step i {
    font-size: 1rem;
    margin-top: 2px;
}

.support-step span {
    color: #374151;
    font-size: 0.9rem;
    line-height: 1.5;
}

/* Responsive Design */
@media (max-width: 768px) {
    .main-card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .info-card-header {
        padding: 1rem;
    }
    
    .info-card-body {
        padding: 1rem;
    }
    
    .bottom-box-body {
        padding: 1.5rem;
    }
    
    .contact-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .contact-icon {
        align-self: center;
    }
}

@media (max-width: 576px) {
    .main-content {
        padding: 2rem 0;
    }
    
    .main-card-body {
        padding: 1rem;
    }
    
    .bottom-box-header {
        padding: 1rem;
    }
    
    .bottom-box-body {
        padding: 1rem;
    }
    
    .support-step {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
}
</style>

<?= view('public/layout/footer') ?>