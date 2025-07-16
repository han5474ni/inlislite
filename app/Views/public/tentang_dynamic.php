<?= view('public/layout/header', ['page_title' => $page_title ?? 'Tentang INLISLite Versi 3']) ?>

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
                        <img src="<?= base_url('assets/images/inlislite.png') ?>" alt="INLISLite Logo" style="height: 80px; max-width: 100%;">
                    </div>
                    <h1 class="page-title" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">
                        Tentang INLISLite Versi 3
                    </h1>
                    <p class="page-subtitle" style="font-size: 1.125rem; max-width: 700px; margin: 0 auto; opacity: 0.85;">
                        Halaman ini berisi informasi lengkap tentang sistem otomasi perpustakaan berbasis web dan open source.
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
                <li class="breadcrumb-item active" aria-current="page">Tentang</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        
        <!-- Dynamic Content from TentangCardModel -->
        <?php if (!empty($about_content)): ?>
            <?php foreach ($about_content as $index => $card): ?>
                <section class="mb-5">
                    <div class="row">
                        <div class="col-12">
                            <article class="content-card animate-on-scroll">
                                <div class="card-header">
                                    <h2 class="mb-0">
                                        <i class="bi <?= $card['icon'] ?? 'bi-info-circle' ?> me-2"></i>
                                        <?= esc($card['title']) ?>
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($card['subtitle'])): ?>
                                        <p class="text-muted mb-3">
                                            <em><?= esc($card['subtitle']) ?></em>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <div class="content-text">
                                        <?= $card['content'] ?>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback content if no dynamic content is available -->
            <section class="mb-5">
                <div class="row">
                    <div class="col-12">
                        <article class="content-card animate-on-scroll">
                            <div class="card-header">
                                <h2 class="mb-0">
                                    <i class="bi bi-info-circle me-2"></i>
                                    INLISLite Versi 3
                                </h2>
                            </div>
                            <div class="card-body">
                                <p class="mb-3">
                                    INLISLite Versi 3 merupakan pengembangan lanjutan dari perangkat lunak aplikasi otomasi perpustakaan INLISLite Versi 2.1 yang telah dibangun dan dikembangkan oleh Perpustakaan Nasional Republik Indonesia (Perpustakaan Nasional RI) sejak tahun 2011.
                                </p>
                                <p class="mb-3">
                                    INLISLite Versi 3 dikembangkan sebagai solusi perangkat lunak otomasi perpustakaan terpadu untuk mengelola dan memudahkan proses pengelolaan data perpustakaan digital / mengelola dan menyampaikan koleksi digital.
                                </p>
                                <p class="mb-0">
                                    INLISLite secara resmi dibangun dan dikembangkan oleh Perpustakaan Nasional Indonesia sebagai bagian dari dukungan dalam program Pengembangan Digital Nasional Indonesia. Selain itu, selain itu juga bertujuan untuk mendukung interoperabilitas dan integrasi sistem informasi perpustakaan berbasis teknologi informasi dan komunikasi di seluruh Indonesia.
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        
        <!-- Static Legal Framework Section (Always Show) -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-file-text me-2"></i>
                                Kerangka Hukum
                            </h2>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Undang-Undang Republik Indonesia Nomor 43 Tahun 2007 tentang Perpustakaan
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Peraturan Pemerintah Nomor 24 Tahun 2014 tentang Pelaksanaan Undang-Undang Nomor 43 Tahun 2007
                                </li>
                                <li class="mb-0">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Undang-Undang Nomor 4 Tahun 1990 tentang Serah Simpan Karya Cetak dan Karya Rekam
                                </li>
                            </ul>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- System Characteristics Section -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-gear me-2"></i>
                                Karakteristik INLISLite Versi 3.0
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="feature-item">
                                        <div class="feature-icon">
                                            <i class="bi bi-database text-primary"></i>
                                        </div>
                                        <div class="feature-content">
                                            <h5>Standar MARC</h5>
                                            <p class="mb-0">Mengikuti standar metadata MARC untuk interoperabilitas dan integrasi</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-item">
                                        <div class="feature-icon">
                                            <i class="bi bi-globe text-success"></i>
                                        </div>
                                        <div class="feature-content">
                                            <h5>Aplikasi berbasis web</h5>
                                            <p class="mb-0">Dapat diakses melalui peramban internet tanpa instalasi khusus</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-item">
                                        <div class="feature-icon">
                                            <i class="bi bi-people text-info"></i>
                                        </div>
                                        <div class="feature-content">
                                            <h5>Dukungan Multi-user</h5>
                                            <p class="mb-0">Dapat digunakan oleh banyak pengguna dalam satu jaringan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-item">
                                        <div class="feature-icon">
                                            <i class="bi bi-code-slash text-warning"></i>
                                        </div>
                                        <div class="feature-content">
                                            <h5>Gratis dan Open Source</h5>
                                            <p class="mb-0">Aplikasi bersifat bebas digunakan dan dapat dimodifikasi sesuai kebutuhan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

    </div>
</main>

<style>
.feature-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.feature-icon {
    font-size: 2rem;
    flex-shrink: 0;
}

.feature-content h5 {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.content-text {
    line-height: 1.6;
}

.content-text p {
    margin-bottom: 1rem;
}

.content-text ul {
    padding-left: 1.5rem;
}

.content-text li {
    margin-bottom: 0.5rem;
}

.section-blur-bg {
    position: relative;
    overflow: hidden;
    z-index: 0;
}

.section-blur-bg::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url('https://i.pinimg.com/736x/cd/66/6a/cd666a84ab3c739f356c8b5b366731bb.jpg') center/cover no-repeat;
    filter: blur(8px) brightness(0.7);
    z-index: -1;
    transform: scale(1.05); /* Hindari tepi blur */
}

/* Tambahkan warna background ke card-header bergantian */
.content-card .card-header {
    padding: 1rem 1.5rem;
    border-radius: 0.5rem 0.5rem 0 0;
    color: #fff;
    transition: background-color 0.3s ease-in-out;
}

/* Card ganjil - biru */
.content-card:nth-of-type(odd) .card-header {
    background-color: #2563eb;
}

/* Card genap - hijau */
.content-card:nth-of-type(even) .card-header {
    background-color: #22c55e;
}

/* Animation for scroll */
.animate-on-scroll {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease-out;
}

.animate-on-scroll.show {
    opacity: 1;
    transform: translateY(0);
}
</style>

<script>
// Animate cards on scroll
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.animate-on-scroll');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    });
    
    cards.forEach(card => {
        observer.observe(card);
    });
});
</script>

<?= view('public/layout/footer') ?>
