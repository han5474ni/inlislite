<?= view('public/layout/header', ['page_title' => $page_title ?? 'Aplikasi Pendukung']) ?>

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
                        <img src="<?= base_url('assets/images/ikon aplikasi pendukung.svg') ?>" alt="Aplikasi Pendukung" style="height: 80px; max-width: 100%;">
                    </div>
                    <h1 class="page-title" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">
                        Aplikasi Pendukung
                    </h1>
                    <p class="page-subtitle" style="font-size: 1.125rem; max-width: 800px; margin: 0 auto; opacity: 0.85;">
                        Modul dan layanan penting yang memperluas fungsionalitas sistem manajemen perpustakaan INLISLite Anda. Aplikasi-aplikasi ini menyediakan fitur tambahan untuk komunikasi, integrasi data, dan peningkatan sistem.
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
                <li class="breadcrumb-item active" aria-current="page">Aplikasi Pendukung</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        
        <!-- Section: Aplikasi Pendukung Untuk INLISLite V3 -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-app me-2"></i>
                                Aplikasi Pendukung Untuk INLISLite V3
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning" role="alert">
                                <h5 class="alert-heading">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Aplikasi Pendukung Untuk Inlislite V3
                                </h5>
                                <p class="mb-0">
                                    Modul-modul ini menyediakan komunikasi, integrasi data, dan peningkatan fitur untuk INLISLite. 
                                    Setiap aplikasi dirancang untuk memperluas fungsionalitas sistem manajemen perpustakaan Anda.
                                </p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

    <!-- Section: OAI-PMH Service -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-box-arrow-down text-primary me-2"></i>
                                OAI-PMH Service
                            </h2>
                            <small class="text-muted">Protokol Inisiatif Arsip Terbuka untuk Pengambilan Metadata</small>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">
                                Modul ini digunakan untuk mengekspos metadata perpustakaan melalui protokol harvesting, 
                                memungkinkan integrasi dengan sistem katalog nasional dan internasional.
                            </p>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <h6>Informasi Teknis:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Berdasarkan format MARCXML
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-folder text-info me-2"></i>
                                            Lokasi Modul: inlislite3\opac\modules\oai
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-link text-primary me-2"></i>
                                            URL Pengujian: <small>http://localhost:8123/opac/oai?verb=ListRecords&metadataPrefix=marcxml</small>
                                        </li>
                                        <li class="mb-0">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Kompatibel dengan Indonesia OneSearch & Katalog Induk Nasional
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

    <!-- Section: SMS Gateway Service -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-chat-left-text text-success me-2"></i>
                                SMS Gateway Service
                            </h2>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">
                                Tujuan dari layanan ini adalah untuk mengirim notifikasi SMS otomatis/manual dari INLISLite menggunakan Gammu.
                            </p>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h6>Penggunaan SMS:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Pengingat jatuh tempo peminjaman
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Notifikasi denda
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Pengumuman acara perpustakaan
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Konfirmasi reservasi buku
                                        </li>
                                        <li class="mb-0">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Pemberitahuan ketersediaan koleksi
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Tentang Gammu:</h6>
                                    <p>
                                        Gammu adalah alat command-line dan library yang menyediakan abstraksi 
                                        untuk berbagai fungsi ponsel. Mendukung komunikasi SMS melalui berbagai 
                                        jenis modem dan perangkat mobile.
                                    </p>
                                </div>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col-md-4">
                                    <div class="download-card text-center p-3 border rounded">
                                        <h6>Gammu for Windows 32-bit</h6>
                                        <p class="mb-1"><strong>Gammu-1.33.0-Windows.exe</strong></p>
                                        <p class="text-muted small">Ukuran: 4MB</p>
                                        <button class="btn btn-success btn-sm">Download</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="download-card text-center p-3 border rounded">
                                        <h6>Gammu for Windows 64-bit</h6>
                                        <p class="mb-1"><strong>Gammu-1.33.0-Windows-x64.exe</strong></p>
                                        <p class="text-muted small">Ukuran: 4MB</p>
                                        <button class="btn btn-success btn-sm">Download</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="download-card text-center p-3 border rounded">
                                        <h6>Gammu for Linux</h6>
                                        <p class="mb-1"><strong>gammu-1.33.0.tar.gz</strong></p>
                                        <p class="text-muted small">Ukuran: 4MB</p>
                                        <button class="btn btn-success btn-sm">Download</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>
                                    Panduan Instalasi di Windows (PDF)
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

    <!-- Section: RFID Gateway Service -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-rss text-danger me-2"></i>
                                RFID Gateway Service (SIP2)
                            </h2>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">
                                Gateway untuk menghubungkan INLISLite ke terminal RFID mandiri menggunakan protokol SIP2 
                                untuk otomatisasi peminjaman dan pengembalian buku.
                            </p>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h6>Perangkat yang diuji:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Terminal RFID 3M
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Terminal Fe Technologies
                                        </li>
                                        <li class="mb-0">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Perangkat kompatibel SIP2 lainnya
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Persyaratan:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-gear text-info me-2"></i>
                                            Protokol SIP2
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-wifi text-info me-2"></i>
                                            Konektivitas terminal ke server
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-database text-info me-2"></i>
                                            Integrasi database INLISLite
                                        </li>
                                        <li class="mb-0">
                                            <i class="bi bi-router text-info me-2"></i>
                                            Konfigurasi jaringan yang tepat
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <div class="download-card text-center p-3 border rounded">
                                        <h6>Windows Installer (RAR)</h6>
                                        <p class="mb-1"><strong>rfid-gateway-inlislite-v3.rar</strong></p>
                                        <p class="text-muted small">Ukuran: 179KB</p>
                                        <button class="btn btn-success btn-sm">Download</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="download-card text-center p-3 border rounded">
                                        <h6>Windows Installer (ZIP)</h6>
                                        <p class="mb-1"><strong>rfid-gateway-inlislite-v3.zip</strong></p>
                                        <p class="text-muted small">Ukuran: 208KB</p>
                                        <button class="btn btn-success btn-sm">Download</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Section: Data Migrator -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-arrow-left-right text-warning me-2"></i>
                                Data Migrator (V212 to V3)
                            </h2>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">
                                Migrasi data dari INLISLite versi 2.1.2 ke versi 3. Mengkonversi skema database, 
                                mempertahankan integritas data, dan menyediakan panduan lengkap untuk proses migrasi.
                            </p>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h6>Fitur Teknis:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Konversi skema database otomatis
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Preservasi data dan relasi
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Validasi integritas data
                                        </li>
                                        <li class="mb-0">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Backup otomatis sebelum migrasi
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Persyaratan:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-windows text-info me-2"></i>
                                            Windows Operating System
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-app text-info me-2"></i>
                                            INLISLite 2.1.2 terinstal
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-shield-check text-info me-2"></i>
                                            Hak akses administrator
                                        </li>
                                        <li class="mb-0">
                                            <i class="bi bi-archive text-info me-2"></i>
                                            Backup data yang valid
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <div class="download-card text-center p-3 border rounded">
                                        <h6>Data Migrator</h6>
                                        <p class="mb-1"><strong>migrator-v212-to-v3.7z</strong></p>
                                        <p class="text-muted small">Ukuran: 2.1MB</p>
                                        <button class="btn btn-success btn-sm">Download</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="download-card text-center p-3 border rounded">
                                        <h6>Panduan Migrasi</h6>
                                        <p class="mb-1"><strong>Panduan-Migrasi-Data.pdf</strong></p>
                                        <p class="text-muted small">Dokumentasi lengkap</p>
                                        <button class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-file-earmark-pdf me-2"></i>Download PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Section: Record Indexing -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-search text-danger me-2"></i>
                                Record Indexing (ElasticSearch)
                            </h2>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">
                                Meningkatkan kecepatan pencarian OPAC via ElasticSearch. Menyediakan indexing yang cepat 
                                dan pencarian yang lebih akurat untuk koleksi perpustakaan.
                            </p>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h6>Komponen Sistem:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            ElasticSearch 6.2.2
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Java Runtime Environment 8
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Plugin indexing INLISLite
                                        </li>
                                        <li class="mb-0">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Konfigurasi mapping MARC
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Persyaratan:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-cpu text-info me-2"></i>
                                            Sistem 64-bit
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-memory text-info me-2"></i>
                                            Minimal 4GB RAM
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-arrow-right text-info me-2"></i>
                                            Instalasi berurutan (JRE → ES → Plugin)
                                        </li>
                                        <li class="mb-0">
                                            <i class="bi bi-ethernet text-info me-2"></i>
                                            Port 9200 tersedia
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col-md-4">
                                    <div class="download-card text-center p-3 border rounded">
                                        <h6>ElasticSearch MSI</h6>
                                        <p class="mb-1"><strong>elasticsearch-6.2.2.msi</strong></p>
                                        <p class="text-muted small">Ukuran: 68.5MB</p>
                                        <button class="btn btn-success btn-sm">Download</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="download-card text-center p-3 border rounded">
                                        <h6>ElasticSearch 7z</h6>
                                        <p class="mb-1"><strong>elasticsearch-6.2.2.7z</strong></p>
                                        <p class="text-muted small">Ukuran: 33.4MB</p>
                                        <button class="btn btn-success btn-sm">Download</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="download-card text-center p-3 border rounded">
                                        <h6>Plugin INLISLite</h6>
                                        <p class="mb-1"><strong>inlislite-indexer.zip</strong></p>
                                        <p class="text-muted small">Ukuran: 452KB</p>
                                        <button class="btn btn-success btn-sm">Download</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>
                                    Panduan Instalasi ElasticSearch (PDF)
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

    </div>
</main>

<style>
.download-card {
    transition: all 0.3s ease;
}

.download-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}
</style>

<?= view('public/layout/footer') ?>