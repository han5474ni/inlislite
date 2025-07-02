<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pendukung - INLISLite v3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/aplikasi.css') ?>">
</head>
<body class="bg-light">
    <!-- Header -->
    <header class="bg-white border-bottom shadow-sm">
        <div class="container-fluid py-3">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark p-0 me-3" onclick="history.back()">
                    <i class="bi bi-arrow-left fs-4"></i>
                </button>
                <div class="d-flex align-items-center">
                    <div class="logo-container me-3">
                        <i class="bi bi-book-fill text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Aplikasi Pendukung</h5>
                        <small class="text-muted">Paket unduhan dan instalasi</small>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid py-4">
        <!-- Introduction Section -->
        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
            <h4 class="text-primary fw-bold mb-3">Aplikasi Pendukung Untuk INLISLite V3</h4>
            <p class="text-muted mb-0">
                Modul dan layanan penting yang memperluas fungsionalitas sistem manajemen perpustakaan 
                INLISLite Anda. Aplikasi-aplikasi ini menyediakan fitur tambahan untuk komunikasi, integrasi data, 
                dan peningkatan sistem.
            </p>
        </div>

        <!-- Applications Grid -->
        <div class="row g-4">
            <!-- OAI-PMH Service -->
            <div class="col-12">
                <div class="app-card bg-white rounded-3 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="app-icon bg-primary me-3">
                                <i class="bi bi-diamond-fill text-white"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">OAI-PMH Service</h5>
                                <small class="text-muted">Protokol Interoperabilitas Arsip Terbuka untuk Pengambilan Metadata</small>
                            </div>
                        </div>
                        <button class="btn btn-link text-muted p-0">
                            <i class="bi bi-three-dots"></i>
                        </button>
                    </div>

                    <p class="text-muted mb-4">
                        Modul layanan ringan untuk komunikasi data melalui protokol harvesting. Memungkinkan 
                        pengguna INLISLite membagikan data perpustakaan secara online ke platform katalog pusat 
                        seperti Indonesia OneSearch dan Katalog Induk Nasional.
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-section">
                                <h6 class="text-primary fw-bold mb-3">
                                    <i class="bi bi-diamond me-2"></i>Detail Teknis
                                </h6>
                                <ul class="detail-list">
                                    <li>Berdasarkan format MARCXML</li>
                                    <li>Modul ini terintegrasi langsung di dalam INLISLite versi 3</li>
                                    <li>Kompatibel dengan Indonesia OneSearch</li>
                                    <li>Mendukung Integrasi dengan Katalog Induk Nasional</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="location-section">
                                <h6 class="text-success fw-bold mb-3">
                                    <i class="bi bi-check-circle me-2"></i>Lokasi Modul
                                </h6>
                                <div class="location-box">
                                    <code>inlislite3\opac\modules\oai</code>
                                </div>
                                <div class="mt-3">
                                    <h6 class="fw-bold mb-2">URL Pengujian</h6>
                                    <div class="url-box">
                                        <small class="text-muted">
                                            http://localhost:8080/opac.php?verb=ListRecords&metadataPrefix=oai_marc
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SMS Gateway Service -->
            <div class="col-12">
                <div class="app-card bg-white rounded-3 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="app-icon bg-success me-3">
                                <i class="bi bi-chat-square-text-fill text-white"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">SMS Gateway Service</h5>
                                <small class="text-muted">Pemberitahuan SMS otomatis menggunakan Gammu SMS Gateway</small>
                            </div>
                        </div>
                        <button class="btn btn-link text-muted p-0">
                            <i class="bi bi-three-dots"></i>
                        </button>
                    </div>

                    <h6 class="fw-bold mb-3">Tujuan dari SMS Gateway di INLISLite</h6>
                    <p class="text-muted mb-4">
                        Mengirim notifikasi SMS terjadwal secara manual seperti batas tinggi jatuh tempo atau pengumuman 
                        perpustakaan. Layanan SMS Gateway terintegrasi dengan INLISLite untuk menyediakan 
                        komunikasi otomatis dengan anggota perpustakaan melalui Gammu 1.33.0.
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="feature-section">
                                <h6 class="text-success fw-bold mb-3">
                                    <i class="bi bi-phone me-2"></i>Penggunaan SMS
                                </h6>
                                <ul class="feature-list">
                                    <li>Pengingatkan buku yang lewat jatuh tempo</li>
                                    <li>Promosi dan acara perpustakaan</li>
                                    <li>Notifikasi ketersediaan buku</li>
                                    <li>Pengingatkan perpanjangan keanggotaan</li>
                                    <li>Pengingatkan pembayaran denda</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="about-section">
                                <h6 class="text-info fw-bold mb-3">
                                    <i class="bi bi-info-circle me-2"></i>Tentang Gammu
                                </h6>
                                <p class="small text-muted">
                                    Gammu adalah pustaka open-source yang andal serta utilitas baris perintah untuk 
                                    ponsel. Gammu menyediakan kemampuan pengiriman SMS melalui modem GSM atau 
                                    ponsel, menjadikannya alat yang ideal untuk notifikasi SMS di perpustakaan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="download-section mt-4">
                        <h6 class="fw-bold mb-3">Unduh Gammu</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="download-card">
                                    <div class="download-header">
                                        <h6 class="fw-bold mb-1">Windows 32-bit</h6>
                                        <small class="text-muted">Gammu-1.33.0-Windows.zip</small>
                                    </div>
                                    <div class="download-footer">
                                        <span class="file-size">4 MB</span>
                                        <button class="btn btn-success btn-sm">
                                            <i class="bi bi-download me-1"></i>Unduh
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="download-card">
                                    <div class="download-header">
                                        <h6 class="fw-bold mb-1">Windows 64-bit</h6>
                                        <small class="text-muted">Gammu-1.33.0-Windows-64bit.zip</small>
                                    </div>
                                    <div class="download-footer">
                                        <span class="file-size">4 MB</span>
                                        <button class="btn btn-success btn-sm">
                                            <i class="bi bi-download me-1"></i>Unduh
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="download-card">
                                    <div class="download-header">
                                        <h6 class="fw-bold mb-1">Linux</h6>
                                        <small class="text-muted">gammu-1.33.0.tar.gz</small>
                                    </div>
                                    <div class="download-footer">
                                        <span class="file-size">4 MB</span>
                                        <button class="btn btn-success btn-sm">
                                            <i class="bi bi-download me-1"></i>Unduh
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="guide-section mt-4">
                        <h6 class="fw-bold mb-3">Panduan Pengunduhan</h6>
                        <div class="guide-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">Panduan Instalasi di Windows</h6>
                                    <small class="text-muted">Instruksi instalasi lengkap untuk sistem operasi Windows</small>
                                </div>
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-file-pdf me-1"></i>Panduan PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RFID Gateway Service -->
            <div class="col-12">
                <div class="app-card bg-white rounded-3 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="app-icon bg-info me-3">
                                <i class="bi bi-wifi text-white"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">RFID Gateway Service (SIP2)</h5>
                                <small class="text-muted">Menghubungkan database INLISLite dengan terminal peminjaman mandiri berbasis RFID menggunakan protokol SIP2</small>
                            </div>
                        </div>
                        <button class="btn btn-link text-muted p-0">
                            <i class="bi bi-three-dots"></i>
                        </button>
                    </div>

                    <p class="text-muted mb-4">
                        Menghubungkan database INLISLite dengan terminal peminjaman mandiri berbasis RFID 
                        menggunakan protokol SIP2. Telah diuji dengan terminal RFID dari 3M dan Fe Technologies 
                        untuk memastikan kelancaran operasi sirkulasi otomatis.
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="hardware-section">
                                <h6 class="text-success fw-bold mb-3">
                                    <i class="bi bi-wifi me-2"></i>Perangkat Keras yang Diuji:
                                </h6>
                                <ul class="hardware-list">
                                    <li>Terminal RFID 3M</li>
                                    <li>Terminal RFID Fe Technologies</li>
                                    <li>Kompatibilitas protokol SIP2</li>
                                    <li>Integrasi terminal peminjaman mandiri</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="system-section">
                                <h6 class="text-primary fw-bold mb-3">
                                    <i class="bi bi-gear me-2"></i>Persyaratan Sistem:
                                </h6>
                                <ul class="system-list">
                                    <li>Hanya untuk Windows OS</li>
                                    <li>Dukungan protokol SIP2</li>
                                    <li>Konektivitas terminal RFID</li>
                                    <li>Integrasi dengan database</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="download-section mt-4">
                        <h6 class="fw-bold mb-3">Opsi Unduhan</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="download-card">
                                    <div class="download-header">
                                        <h6 class="fw-bold mb-1">Windows</h6>
                                        <small class="text-muted">installer_rfidsip2-gateway-inlislitev3.rar</small>
                                    </div>
                                    <div class="download-footer">
                                        <span class="file-size">179 KB</span>
                                        <button class="btn btn-success btn-sm">
                                            <i class="bi bi-download me-1"></i>Unduh
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="download-card">
                                    <div class="download-header">
                                        <h6 class="fw-bold mb-1">Windows</h6>
                                        <small class="text-muted">installer_rfidsip2-gateway-inlislitev3.zip</small>
                                    </div>
                                    <div class="download-footer">
                                        <span class="file-size">208 KB</span>
                                        <button class="btn btn-success btn-sm">
                                            <i class="bi bi-download me-1"></i>Unduh
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Migrator -->
            <div class="col-12">
                <div class="app-card bg-white rounded-3 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="app-icon bg-primary me-3">
                                <i class="bi bi-gear-fill text-white"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Data Migrator (V212 to V3)</h5>
                            </div>
                        </div>
                        <button class="btn btn-link text-muted p-0">
                            <i class="bi bi-three-dots"></i>
                        </button>
                    </div>

                    <p class="text-muted mb-4">
                        Utilitas desktop untuk memigrasi data dari INLISLite versi 2.1.2 ke versi 3. Menjamin integritas 
                        data yang lengkap selama proses upgrade.
                    </p>

                    <div class="detail-info-section mb-4">
                        <h6 class="fw-bold mb-3">Detail Teknis</h6>
                        <div class="info-box">
                            <p class="mb-0">
                                Konversi skema database lengkap dengan pelestarian data. Termasuk panduan PDF di 
                                dalam arsip.
                            </p>
                        </div>
                    </div>

                    <div class="requirements-section mb-4">
                        <h6 class="fw-bold mb-3">Persyaratan:</h6>
                        <ul class="requirements-list">
                            <li>Sistem operasi Windows</li>
                            <li>Database INLISLite versi 2.1.2</li>
                            <li>Hak akses administrator</li>
                            <li>Media penyimpanan untuk backup</li>
                        </ul>
                    </div>

                    <div class="download-section">
                        <div class="download-card single-download">
                            <div class="download-header">
                                <h6 class="fw-bold mb-1">Windows</h6>
                                <small class="text-muted">migrator_inlislite_v212_to_v3_rev03012017.7z</small>
                            </div>
                            <div class="download-footer">
                                <span class="file-size">179 KB</span>
                                <button class="btn btn-primary btn-sm">
                                    <i class="bi bi-download me-1"></i>Unduh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Record Indexing -->
            <div class="col-12">
                <div class="app-card bg-white rounded-3 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="app-icon bg-primary me-3">
                                <i class="bi bi-search text-white"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Record Indexing (ElasticSearch)</h5>
                            </div>
                        </div>
                        <button class="btn btn-link text-muted p-0">
                            <i class="bi bi-three-dots"></i>
                        </button>
                    </div>

                    <p class="text-muted mb-4">
                        Meningkatkan kecepatan pencarian OPAC melalui mesin ElasticSearch. Menyediakan 
                        kemampuan pencarian yang kuat untuk database berukuran besar.
                    </p>

                    <div class="detail-info-section mb-4">
                        <h6 class="fw-bold mb-3">Detail Teknis</h6>
                        <div class="info-box">
                            <p class="mb-0">
                                ElasticSearch 6.2.2 dengan Java Runtime Environment 8. Memerlukan instalasi 
                                khusus.
                            </p>
                        </div>
                    </div>

                    <div class="requirements-section mb-4">
                        <h6 class="fw-bold mb-3">Persyaratan:</h6>
                        <ul class="requirements-list">
                            <li>Windows 64-bit</li>
                            <li>Java Runtime Environment 8</li>
                            <li>ElasticSearch 6.2.2</li>
                            <li>Sumber daya sistem yang memadai</li>
                        </ul>
                    </div>

                    <div class="download-section">
                        <h6 class="fw-bold mb-3">Unduh:</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="download-card">
                                    <div class="download-header">
                                        <h6 class="fw-bold mb-1">Windows 64-bit</h6>
                                        <small class="text-muted">migrator_inlislite_v212_to_v3_rev03012017.7z</small>
                                    </div>
                                    <div class="download-footer">
                                        <span class="file-size">68.8 MB</span>
                                        <button class="btn btn-primary btn-sm">
                                            <i class="bi bi-download me-1"></i>Unduh
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="download-card">
                                    <div class="download-header">
                                        <h6 class="fw-bold mb-1">Windows 64-bit</h6>
                                        <small class="text-muted">elasticsearch-6.2.2.msi</small>
                                    </div>
                                    <div class="download-footer">
                                        <span class="file-size">33.4 MB</span>
                                        <button class="btn btn-primary btn-sm">
                                            <i class="bi bi-download me-1"></i>Unduh
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="download-card">
                                    <div class="download-header">
                                        <h6 class="fw-bold mb-1">Windows 64-bit</h6>
                                        <small class="text-muted">migrator_inlislite_v212_to_v3_rev03012017.7z</small>
                                    </div>
                                    <div class="download-footer">
                                        <span class="file-size">452 KB</span>
                                        <button class="btn btn-primary btn-sm">
                                            <i class="bi bi-download me-1"></i>Unduh
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/admin/aplikasi.js') ?>"></script>
</body>
</html>
