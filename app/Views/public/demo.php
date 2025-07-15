<?= view('public/layout/header', ['page_title' => $page_title ?? 'Demo Program']) ?>

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
                        <i class="bi bi-play-circle" style="font-size: 4rem; color: white;"></i>
                    </div>
                    <h1 class="page-title" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">
                        Demo Program
                    </h1>
                    <p class="page-subtitle" style="font-size: 1.125rem; max-width: 800px; margin: 0 auto; opacity: 0.85;">
                        Download and Installation Package – INLISLite Version 3 Demo
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
                <li class="breadcrumb-item active" aria-current="page">Demo Program</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        
        <!-- Section: Demo Program Introduction -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-play-circle me-2"></i>
                                Demo Program INLISLite V3
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info" role="alert">
                                <h5 class="alert-heading">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Akses Demo Online
                                </h5>
                                <p class="mb-0">
                                    Untuk menjelajahi modul dan fitur yang tersedia dalam sistem manajemen perpustakaan INLISLite, 
                                    Anda dapat mengakses platform demonstrasi online kami di bawah ini.
                                </p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Section: Demo INLISLite v3 Opensource -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-code-slash text-success me-2"></i>
                                Demo INLISLite v3 Opensource
                            </h2>
                        </div>
                        <div class="card-body" style="background-color: #F9F9F9;">
                            <p class="mb-3">
                                <strong>Full-featured PHP-based open-source demo.</strong> 
                                Demonstrasi lengkap dari sistem manajemen perpustakaan berbasis PHP dengan semua fitur utama.
                            </p>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="demo-info">
                                        <h6><i class="bi bi-gear text-primary me-2"></i>Informasi Platform:</h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="bi bi-check-circle text-success me-2"></i>
                                                <strong>Platform:</strong> PHP Open Source
                                            </li>
                                            <li class="mb-2">
                                                <i class="bi bi-tag text-info me-2"></i>
                                                <strong>Version:</strong> V3.0
                                            </li>
                                            <li class="mb-0">
                                                <i class="bi bi-globe text-primary me-2"></i>
                                                <strong>Status:</strong> Aktif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="login-info">
                                        <h6><i class="bi bi-key text-warning me-2"></i>Informasi Login:</h6>
                                        <div class="login-credentials p-3 bg-white rounded border">
                                            <div class="mb-2">
                                                <strong>Username:</strong> 
                                                <code class="bg-light px-2 py-1 rounded">inlislite</code>
                                            </div>
                                            <div class="mb-0">
                                                <strong>Password:</strong> 
                                                <code class="bg-light px-2 py-1 rounded">inlislite=</code>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-center">
                                <button class="btn btn-success btn-lg me-3">
                                    <i class="bi bi-play-circle me-2"></i>
                                    Akses Demo
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-download me-2"></i>
                                    Download Package
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Section: Demo INLISLite v3 DotNet -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-microsoft text-primary me-2"></i>
                                Demo INLISLite v3 DotNet
                            </h2>
                        </div>
                        <div class="card-body" style="background-color: #F9F9F9;">
                            <p class="mb-3">
                                <strong>Modern .NET-based library management demo.</strong> 
                                Demonstrasi sistem perpustakaan berbasis teknologi Microsoft .NET dengan performa tinggi.
                            </p>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="demo-info">
                                        <h6><i class="bi bi-gear text-primary me-2"></i>Informasi Platform:</h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="bi bi-check-circle text-success me-2"></i>
                                                <strong>Platform:</strong> .NET Framework
                                            </li>
                                            <li class="mb-2">
                                                <i class="bi bi-tag text-info me-2"></i>
                                                <strong>Version:</strong> V3.0
                                            </li>
                                            <li class="mb-0">
                                                <i class="bi bi-globe text-primary me-2"></i>
                                                <strong>Status:</strong> Aktif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="login-info">
                                        <h6><i class="bi bi-key text-warning me-2"></i>Informasi Login:</h6>
                                        <div class="login-credentials p-3 bg-white rounded border">
                                            <div class="mb-2">
                                                <strong>Username:</strong> 
                                                <code class="bg-light px-2 py-1 rounded">superadmin</code>
                                            </div>
                                            <div class="mb-0">
                                                <strong>Password:</strong> 
                                                <code class="bg-light px-2 py-1 rounded">superadmin</code>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-center">
                                <button class="btn btn-primary btn-lg me-3">
                                    <i class="bi bi-play-circle me-2"></i>
                                    Akses Demo
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-download me-2"></i>
                                    Download Package
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Section: Demo INLISLite v3 Opensource (New) -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-code-slash text-success me-2"></i>
                                Demo INLISLite v3 Opensource (New)
                            </h2>
                            <span class="badge bg-success ms-2">Latest</span>
                        </div>
                        <div class="card-body" style="background-color: #F9F9F9;">
                            <p class="mb-3">
                                <strong>Latest PHP open-source version with enhanced features.</strong> 
                                Versi terbaru dengan fitur-fitur yang ditingkatkan dan performa yang lebih optimal.
                            </p>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="demo-info">
                                        <h6><i class="bi bi-gear text-primary me-2"></i>Informasi Platform:</h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="bi bi-check-circle text-success me-2"></i>
                                                <strong>Platform:</strong> PHP Open Source
                                            </li>
                                            <li class="mb-2">
                                                <i class="bi bi-tag text-info me-2"></i>
                                                <strong>Version:</strong> V3.1
                                            </li>
                                            <li class="mb-0">
                                                <i class="bi bi-globe text-primary me-2"></i>
                                                <strong>Status:</strong> Aktif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="login-info">
                                        <h6><i class="bi bi-key text-warning me-2"></i>Informasi Login:</h6>
                                        <div class="login-credentials p-3 bg-white rounded border">
                                            <div class="mb-2">
                                                <strong>Username:</strong> 
                                                <code class="bg-light px-2 py-1 rounded">inlislite</code>
                                            </div>
                                            <div class="mb-0">
                                                <strong>Password:</strong> 
                                                <code class="bg-light px-2 py-1 rounded">inlislite=</code>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-center">
                                <button class="btn btn-success btn-lg me-3">
                                    <i class="bi bi-play-circle me-2"></i>
                                    Akses Demo
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-download me-2"></i>
                                    Download Package
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Section: Demo Features -->
        <section class="mb-5">
            <div class="row">
                <div class="col-12">
                    <article class="content-card animate-on-scroll">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <i class="bi bi-list-check me-2"></i>
                                Fitur Demo yang Tersedia
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h6>Modul Utama:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Katalogisasi dan Pengolahan Bahan Pustaka
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Sirkulasi dan Peminjaman
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Manajemen Anggota
                                        </li>
                                        <li class="mb-0">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            OPAC (Online Public Access Catalog)
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Fitur Tambahan:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Laporan dan Statistik
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Manajemen Inventaris
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Sistem Notifikasi
                                        </li>
                                        <li class="mb-0">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Backup dan Restore Data
                                        </li>
                                    </ul>
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
.demo-info, .login-info {
    height: 100%;
}

.login-credentials {
    transition: all 0.3s ease;
}

.login-credentials:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.content-card {
    transition: all 0.3s ease;
}

.content-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.badge {
    font-size: 0.75rem;
}
</style>

<?= view('public/layout/footer') ?>