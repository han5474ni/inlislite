<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Page Header (unified with homepage hero styles) -->
<header class="page-header page-header--image page-header--with-overlay page-header--bg-fixed">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center py-4">
                    <div class="page-icon mb-3">
                        <i class="bi bi-book"></i>
                    </div>
                    <h1 class="page-title page-title--md fw-bold mb-2">Panduan</h1>
                    <p class="page-subtitle page-subtitle--md">
                        Panduan Pengguna INLISLite Versi 3 PHP Opensource
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
                <li class="breadcrumb-item active" aria-current="page">Panduan</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        
        <!-- Section: Introduction -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Dokumentasi Resmi INLISLite V3
                            </h2>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">
                                Dokumentasi resmi dan panduan praktis untuk membantu pengguna mengoperasikan semua fitur INLISLite v3. 
                                Temukan petunjuk lengkap, tutorial, dan referensi teknis untuk memaksimalkan penggunaan sistem perpustakaan Anda.
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Search and Add Document Section -->
        <section class="mb-4">
            <div class="row">
                <div class="col-12">
                    <div class="search-section bg-white p-4 rounded-3 shadow-sm border">
                        <div class="row align-items-center">
                            <div class="col-lg-8 col-md-7 mb-3 mb-md-0">
                                <div class="search-container">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari dokumen..." id="documentSearch">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5 text-md-end">
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Available Documentation Section -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <div class="section-header mb-4">
                        <h3 class="section-title">
                            <i class="bi bi-folder me-2 text-primary"></i>
                            Dokumentasi Tersedia (6)
                        </h3>
                    </div>
                    
                    <div class="row g-4">
                        <!-- Document 1 -->
                        <div class="col-lg-6 col-md-6">
                            <div class="document-card">
                                <div class="document-icon">
                                    <i class="bi bi-file-earmark-pdf text-danger"></i>
                                </div>
                                <div class="document-content">
                                    <h5 class="document-title">User Guide Revision 16062016 – Full Module</h5>
                                    <p class="document-description">
                                        Panduan lengkap penggunaan semua modul INLISLite v3 dengan fitur terbaru dan update terkini.
                                    </p>
                                    <div class="document-meta">
                                        <span class="file-type">PDF</span>
                                        <span class="file-size">12 MB</span>
                                        <span class="file-version">v3.2.1</span>
                                    </div>
                                </div>
                                <div class="document-actions">
                                    <button class="btn btn-success btn-sm">
                                        <i class="bi bi-download me-1"></i>
                                        Download
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Document 2 -->
                        <div class="col-lg-6 col-md-6">
                            <div class="document-card">
                                <div class="document-icon">
                                    <i class="bi bi-file-earmark-pdf text-danger"></i>
                                </div>
                                <div class="document-content">
                                    <h5 class="document-title">Installation Guide for PHP Platform</h5>
                                    <p class="document-description">
                                        Petunjuk instalasi lengkap INLISLite v3 pada platform PHP dengan berbagai konfigurasi server.
                                    </p>
                                    <div class="document-meta">
                                        <span class="file-type">PDF</span>
                                        <span class="file-size">8.5 MB</span>
                                        <span class="file-version">v3.2.0</span>
                                    </div>
                                </div>
                                <div class="document-actions">
                                    <button class="btn btn-success btn-sm">
                                        <i class="bi bi-download me-1"></i>
                                        Download
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Document 3 -->
                        <div class="col-lg-6 col-md-6">
                            <div class="document-card">
                                <div class="document-icon">
                                    <i class="bi bi-file-earmark-pdf text-danger"></i>
                                </div>
                                <div class="document-content">
                                    <h5 class="document-title">Cataloging Module User Manual</h5>
                                    <p class="document-description">
                                        Panduan khusus untuk modul katalogisasi dengan standar MARC dan pengolahan bahan pustaka.
                                    </p>
                                    <div class="document-meta">
                                        <span class="file-type">PDF</span>
                                        <span class="file-size">15.2 MB</span>
                                        <span class="file-version">v3.1.8</span>
                                    </div>
                                </div>
                                <div class="document-actions">
                                    <button class="btn btn-success btn-sm">
                                        <i class="bi bi-download me-1"></i>
                                        Download
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Document 4 -->
                        <div class="col-lg-6 col-md-6">
                            <div class="document-card">
                                <div class="document-icon">
                                    <i class="bi bi-file-earmark-pdf text-danger"></i>
                                </div>
                                <div class="document-content">
                                    <h5 class="document-title">Circulation System Guide</h5>
                                    <p class="document-description">
                                        Manual penggunaan sistem sirkulasi untuk peminjaman, pengembalian, dan manajemen anggota.
                                    </p>
                                    <div class="document-meta">
                                        <span class="file-type">PDF</span>
                                        <span class="file-size">9.8 MB</span>
                                        <span class="file-version">v3.2.1</span>
                                    </div>
                                </div>
                                <div class="document-actions">
                                    <button class="btn btn-success btn-sm">
                                        <i class="bi bi-download me-1"></i>
                                        Download
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Document 5 -->
                        <div class="col-lg-6 col-md-6">
                            <div class="document-card">
                                <div class="document-icon">
                                    <i class="bi bi-file-earmark-pdf text-danger"></i>
                                </div>
                                <div class="document-content">
                                    <h5 class="document-title">OPAC Configuration Manual</h5>
                                    <p class="document-description">
                                        Panduan konfigurasi dan kustomisasi OPAC (Online Public Access Catalog) untuk pengguna akhir.
                                    </p>
                                    <div class="document-meta">
                                        <span class="file-type">PDF</span>
                                        <span class="file-size">6.4 MB</span>
                                        <span class="file-version">v3.1.9</span>
                                    </div>
                                </div>
                                <div class="document-actions">
                                    <button class="btn btn-success btn-sm">
                                        <i class="bi bi-download me-1"></i>
                                        Download
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Document 6 -->
                        <div class="col-lg-6 col-md-6">
                            <div class="document-card">
                                <div class="document-icon">
                                    <i class="bi bi-file-earmark-pdf text-danger"></i>
                                </div>
                                <div class="document-content">
                                    <h5 class="document-title">System Administration Guide</h5>
                                    <p class="document-description">
                                        Panduan administrasi sistem untuk pengelolaan pengguna, backup, dan maintenance INLISLite v3.
                                    </p>
                                    <div class="document-meta">
                                        <span class="file-type">PDF</span>
                                        <span class="file-size">11.7 MB</span>
                                        <span class="file-version">v3.2.0</span>
                                    </div>
                                </div>
                                <div class="document-actions">
                                    <button class="btn btn-success btn-sm">
                                        <i class="bi bi-download me-1"></i>
                                        Download
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Additional Resources Section -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-link-45deg me-2"></i>
                                Sumber Daya Tambahan
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="resource-item">
                                        <div class="resource-icon">
                                            <i class="bi bi-download text-primary"></i>
                                        </div>
                                        <div class="resource-content">
                                            <h5 class="resource-title">Petunjuk Instalasi</h5>
                                            <p class="resource-description">Petunjuk instalasi lengkap untuk platform PHP</p>
                                            <a href="<?= base_url('installer') ?>" class="resource-link">
                                                Installer > Platform PHP <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="resource-item">
                                        <div class="resource-icon">
                                            <i class="bi bi-arrow-clockwise text-success"></i>
                                        </div>
                                        <div class="resource-content">
                                            <h5 class="resource-title">Petunjuk Update</h5>
                                            <p class="resource-description">Panduan update dan patch sistem terbaru</p>
                                            <a href="<?= base_url('patch') ?>" class="resource-link">
                                                Patch & Updater > Platform PHP <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
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
/* Search Section */
.search-section {
    border: 1px solid #e5e7eb;
}

.search-container .input-group-text {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.search-container .form-control {
    border-color: #dee2e6;
}

.search-container .form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 0.2rem rgb(37, 99, 235);
}

/* Section Header */
.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0;
}

/* Document Cards */
.document-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.5rem;
    height: 100%;
    display: flex;
    gap: 1rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.document-card::before {  

.document-icon {
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fee2e2;
    border-radius: 12px;
}

.document-icon i {
    font-size: 1.5rem;
}

.document-content {
    flex: 1;
    min-width: 0;
}

.document-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.document-description {
    color: #6b7280;
    font-size: 0.875rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.document-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1rem;
}

.document-meta span {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-weight: 500;
}

.file-type {
    background: #fee2e2;
    color: #dc2626;
}

.file-size {
    background: #dbeafe;
    color: #2563eb;
}

.file-version {
    background: #d1fae5;
    color: #059669;
}

.document-actions {
    flex-shrink: 0;
    display: flex;
    align-items: flex-end;
}

/* Resource Items */
.resource-item { 

.resource-icon {
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.resource-icon i {
    font-size: 1.25rem;
}

.resource-content {
    flex: 1;
}

.resource-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.resource-description {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 0.75rem;
}

.resource-link { 

/* Responsive Design */
@media (max-width: 768px) {
    .document-card {
        flex-direction: column;
        text-align: center;
    }
    
    .document-actions {
        align-items: center;
        justify-content: center;
    }
    
    .resource-item {
        flex-direction: column;
        text-align: center;
    }
    
    .document-meta {
        justify-content: center;
    }
}
</style>

<?= $this->endSection() ?>

