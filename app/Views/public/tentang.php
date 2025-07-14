<?= view('public/layout/header', ['page_title' => $page_title ?? 'Tentang INLISLite Versi 3']) ?>

<!-- Page Header -->
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
        
        <!-- Section: INLISLite Versi 3 -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-book me-2"></i>
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

        <!-- Section: Kerangka Hukum -->
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

        <!-- Section: Karakteristik INLISLite Versi 3.0 -->
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

        <!-- Section: Pilihan Platform -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-laptop me-2"></i>
                                Pilihan Platform
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="platform-card">
                                        <div class="platform-icon">
                                            <i class="bi bi-microsoft text-primary"></i>
                                        </div>
                                        <h5>DotNet Framework</h5>
                                        <p class="mb-0">Dapat diinstal pada komputer dengan sistem operasi Windows</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="platform-card">
                                        <div class="platform-icon">
                                            <i class="bi bi-code text-success"></i>
                                        </div>
                                        <h5>PHP Open Source</h5>
                                        <p class="mb-0">Dapat diinstal pada komputer dengan sistem operasi Windows maupun Linux</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Section: Ketentuan Penggunaan dan Distribusi -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-shield-check me-2"></i>
                                Ketentuan Penggunaan dan Distribusi INLISLite Versi 3
                            </h2>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Semua institusi dan individu yang membutuhkan diperbolehkan untuk menyimpan, menginstal, dan menggunakan perangkat lunak aplikasi INLISLite Versi 3.
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Semua institusi dan individu juga diperbolehkan untuk mengunduh dan mengambil paket serta pembaruan yang tersedia.
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-x-circle text-danger me-2"></i>
                                    Dilarang keras memperjualbelikan paket instalasi, patch, atau komponen pendukung dari INLISLite Versi 3.
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-info-circle text-info me-2"></i>
                                    Dukungan sistem dan distribusi oleh Perpustakaan Nasional Indonesia kepada pengguna yang terdaftar akan diberikan sesuai dengan ketentuan.
                                </li>
                                <li class="mb-0">
                                    <i class="bi bi-info-circle text-info me-2"></i>
                                    Pelatihan teknis juga akan diberikan oleh Perpustakaan Nasional Indonesia dengan syarat dan ketentuan yang sama.
                                </li>
                            </ul>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Section: Ketentuan Modifikasi -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-tools me-2"></i>
                                Ketentuan Modifikasi INLISLite Versi 3 PHP (Opensource)
                            </h2>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="bi bi-x-circle text-danger me-2"></i>
                                    Dilarang menghapus logo atau tulisan INLISLite dari modul atau halaman manapun.
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-x-circle text-danger me-2"></i>
                                    Dilarang menghapus informasi identitas penyusun hak cipta "© Perpustakaan Nasional RI".
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-x-circle text-danger me-2"></i>
                                    Dilarang mengubah standar metadata MARC, yang merupakan inti dan standar sistem otomasi.
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                    Setiap perubahan/modifikasi kode sumber wajib dilaporkan ke Perpustakaan Nasional RI.
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-x-circle text-danger me-2"></i>
                                    Dilarang mendistribusikan hasil modifikasi produk perangkat lunak INLISLite versi 3 PHP ke institusi/organisasi lain tanpa persetujuan dari Perpustakaan Nasional RI.
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                    Semua laporan modifikasi perangkat lunak INLISLite wajib membubuhkan sumber lengkap hasil modifikasi dan diserahkan kepada Perpustakaan Nasional Indonesia.
                                </li>
                                <li class="mb-0">
                                    <i class="bi bi-x-circle text-danger me-2"></i>
                                    Modifikasi hanya pada perangkat lunak aplikasi INLISLite atau versi modifikasinya dilarang keras.
                                </li>
                            </ul>
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

.platform-card {
    text-align: center;
    padding: 2rem 1rem;
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.platform-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.platform-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.platform-card h5 {
    margin-bottom: 0.5rem;
    font-weight: 600;
}
</style>
<style>
/* Tambahkan ini ke existing style */
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
</style>


<?= view('public/layout/footer') ?>