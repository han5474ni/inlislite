<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Bimbingan Teknis - INLISlite v3.0' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/bimbingan.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i data-feather="menu"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <i data-feather="star"></i>
                </div>
                <div class="sidebar-title">
                    INLISlite v3.0<br>
                    <small style="font-size: 0.85rem; opacity: 0.8;">Dashboard</small>
                </div>
            </a>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i data-feather="chevrons-left"></i>
            </button>
        </div>
        
        <div class="sidebar-nav">
            <div class="nav-item">
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
                    <i data-feather="home" class="nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="nav-tooltip">Dashboard</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/users') ?>" class="nav-link">
                    <i data-feather="users" class="nav-icon"></i>
                    <span class="nav-text">Manajemen User</span>
                </a>
                <div class="nav-tooltip">Manajemen User</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('registration') ?>" class="nav-link">
                    <i data-feather="book" class="nav-icon"></i>
                    <span class="nav-text">Registrasi</span>
                </a>
                <div class="nav-tooltip">Registrasi</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/profile') ?>" class="nav-link">
                    <i data-feather="user" class="nav-icon"></i>
                    <span class="nav-text">Profile</span>
                </a>
                <div class="nav-tooltip">Profile</div>
            </div>
            
            <!-- Logout Button -->
            <div class="nav-item logout-item">
                <a href="<?= base_url('admin/secure-logout') ?>" class="nav-link logout-link" onclick="return confirmLogout()">
                    <i data-feather="log-out" class="nav-icon"></i>
                    <span class="nav-text">Logout</span>
                </a>
                <div class="nav-tooltip">Logout</div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navigation -->
        <nav class="top-nav sticky-top">
            <div class="container-fluid">
                <div class="nav-content">
                    <div class="nav-left">
                        <a href="<?= base_url('admin/dashboard') ?>" class="back-btn" title="Kembali ke Dashboard">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div class="logo-section">
                            <div class="logo-icon">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <div class="nav-text">
                                <h1 class="nav-title">Bimbingan Teknis</h1>
                                <p class="nav-subtitle">Program pelatihan dan pendampingan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="page-content">
            <div class="container-fluid">
                <!-- Header Section -->
                <div class="header-section">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="text-center mb-5">
                                <div class="header-icon">
                                    <i class="bi bi-mortarboard"></i>
                                </div>
                                <h1 class="header-title">Bimbingan Teknis INLISLite Versi 3</h1>
                                <p class="header-subtitle">Bimbingan teknis terkait program aplikasi INLISLite versi 3 bagi pengelola perpustakaan di seluruh Indonesia dapat diperoleh melalui:</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- Bimbingan Content -->
                <div class="bimbingan-content" id="bimbinganContent">
                    <!-- Card 1: Program Supervisi -->
                    <div class="bimbingan-card card" data-card-id="1">
                        <div class="card-header d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                <div class="card-icon me-3">
                                    <i class="bi bi-book-half"></i>
                                </div>
                                <div class="card-title-section">
                                    <h3 class="card-title mb-1">Program Supervisi / Bimbingan Teknis / Pendidikan dan Pelatihan</h3>
                                    <p class="card-subtitle text-muted mb-0">Kegiatan resmi Perpustakaan Nasional RI</p>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                                    <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <p class="card-description">Kegiatan resmi yang diselenggarakan oleh Perpustakaan Nasional Republik Indonesia</p>
                                
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="info-content">
                                            <strong>Diselenggarakan oleh:</strong>
                                            <span>Perpustakaan Nasional Republik Indonesia</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                        <div class="info-content">
                                            <strong>Format:</strong>
                                            <span>Berdasarkan undangan resmi</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Ini adalah kegiatan resmi yang diselenggarakan oleh Perpustakaan Nasional Republik Indonesia (berdasarkan undangan resmi).
                                </div>
                            </div>
                            <div class="card-edit-form d-none">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Title</label>
                                    <input type="text" class="form-control edit-title" value="Program Supervisi / Bimbingan Teknis / Pendidikan dan Pelatihan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Subtitle</label>
                                    <input type="text" class="form-control edit-subtitle" value="Kegiatan resmi Perpustakaan Nasional RI">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Content</label>
                                    <textarea class="form-control edit-content" rows="8">Kegiatan resmi yang diselenggarakan oleh Perpustakaan Nasional Republik Indonesia

• Diselenggarakan oleh: Perpustakaan Nasional Republik Indonesia
• Format: Berdasarkan undangan resmi

Ini adalah kegiatan resmi yang diselenggarakan oleh Perpustakaan Nasional Republik Indonesia (berdasarkan undangan resmi).</textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary save-card">
                                        <i class="bi bi-check-lg me-2"></i>Save
                                    </button>
                                    <button class="btn btn-secondary cancel-edit">
                                        <i class="bi bi-x-lg me-2"></i>Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Magang -->
                    <div class="bimbingan-card card" data-card-id="2">
                        <div class="card-header d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                <div class="card-icon me-3">
                                    <i class="bi bi-person-workspace"></i>
                                </div>
                                <div class="card-title-section">
                                    <h3 class="card-title mb-1">Magang di Perpustakaan Nasional Republik Indonesia</h3>
                                    <p class="card-subtitle text-muted mb-0">Program magang resmi untuk pengelola perpustakaan</p>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                                    <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <p class="card-description">Kegiatan resmi magang terkait aplikasi INLISLite v3</p>
                                
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="info-content">
                                            <strong>Terbuka untuk:</strong>
                                            <span>Pengelola perpustakaan di Indonesia</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="bi bi-clock"></i>
                                        </div>
                                        <div class="info-content">
                                            <strong>Jadwal:</strong>
                                            <span>Senin–Jumat, 09.00–15.00 WIB, disesuaikan materi</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Layanan pembimbingan tidak dipungut biaya. Biaya transportasi, akomodasi, ATK, dan keperluan lainnya ditanggung oleh peserta magang.
                                </div>
                            </div>
                            <div class="card-edit-form d-none">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Title</label>
                                    <input type="text" class="form-control edit-title" value="Magang di Perpustakaan Nasional Republik Indonesia">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Subtitle</label>
                                    <input type="text" class="form-control edit-subtitle" value="Program magang resmi untuk pengelola perpustakaan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Content</label>
                                    <textarea class="form-control edit-content" rows="8">Kegiatan resmi magang terkait aplikasi INLISLite v3

• Terbuka untuk: Pengelola perpustakaan di Indonesia
• Jadwal: Senin–Jumat, 09.00–15.00 WIB, disesuaikan materi

Layanan pembimbingan tidak dipungut biaya. Biaya transportasi, akomodasi, ATK, dan keperluan lainnya ditanggung oleh peserta magang.</textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary save-card">
                                        <i class="bi bi-check-lg me-2"></i>Save
                                    </button>
                                    <button class="btn btn-secondary cancel-edit">
                                        <i class="bi bi-x-lg me-2"></i>Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Workshop -->
                    <div class="bimbingan-card card" data-card-id="3">
                        <div class="card-header d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                <div class="card-icon me-3">
                                    <i class="bi bi-tools"></i>
                                </div>
                                <div class="card-title-section">
                                    <h3 class="card-title mb-1">Workshop / Bimbingan Teknis Inisiatif</h3>
                                    <p class="card-subtitle text-muted mb-0">Workshop yang diinisiasi institusi perpustakaan</p>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                                    <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <p class="card-description">Workshop/bimbingan teknis yang diinisiasi oleh institusi perpustakaan</p>
                                
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="info-content">
                                            <strong>Diselenggarakan oleh:</strong>
                                            <span>Institusi perpustakaan</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="bi bi-person-badge"></i>
                                        </div>
                                        <div class="info-content">
                                            <strong>Narasumber:</strong>
                                            <span>Tim teknis dari Perpustakaan Nasional Republik Indonesia</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Seluruh biaya (transportasi, akomodasi, dll.) untuk narasumber ditanggung oleh pihak penyelenggara. Penyelenggara tidak diperkenankan memungut biaya keikutsertaan dari peserta yang diundang.
                                </div>
                            </div>
                            <div class="card-edit-form d-none">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Title</label>
                                    <input type="text" class="form-control edit-title" value="Workshop / Bimbingan Teknis Inisiatif">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Subtitle</label>
                                    <input type="text" class="form-control edit-subtitle" value="Workshop yang diinisiasi institusi perpustakaan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Content</label>
                                    <textarea class="form-control edit-content" rows="8">Workshop/bimbingan teknis yang diinisiasi oleh institusi perpustakaan

• Diselenggarakan oleh: Institusi perpustakaan
• Narasumber: Tim teknis dari Perpustakaan Nasional Republik Indonesia

Seluruh biaya (transportasi, akomodasi, dll.) untuk narasumber ditanggung oleh pihak penyelenggara. Penyelenggara tidak diperkenankan memungut biaya keikutsertaan dari peserta yang diundang.</textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary save-card">
                                        <i class="bi bi-check-lg me-2"></i>Save
                                    </button>
                                    <button class="btn btn-secondary cancel-edit">
                                        <i class="bi bi-x-lg me-2"></i>Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Syarat dan Ketentuan -->
                    <div class="bimbingan-card card" data-card-id="4">
                        <div class="card-header d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                <div class="card-icon me-3">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div class="card-title-section">
                                    <h3 class="card-title mb-1">Syarat dan Ketentuan</h3>
                                    <p class="card-subtitle text-muted mb-0">Persyaratan lengkap untuk pengajuan magang dan workshop</p>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                                    <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <div class="row">
                                    <!-- Syarat Magang -->
                                    <div class="col-lg-6 mb-4">
                                        <div class="requirement-section">
                                            <h5 class="requirement-title">
                                                <span class="requirement-number">1️⃣</span>
                                                Syarat dan Ketentuan Magang
                                            </h5>
                                            <ul class="requirement-list">
                                                <li>Kirim surat permohonan resmi dari lembaga</li>
                                                <li>
                                                    <div class="contact-info">
                                                        <i class="bi bi-geo-alt text-primary me-2"></i>
                                                        <div>
                                                            <strong>Alamat tujuan:</strong><br>
                                                            Perpustakaan Nasional Republik Indonesia<br>
                                                            Jl. Salemba Raya No. 28A, Jakarta Pusat 10440
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="contact-info">
                                                        <i class="bi bi-envelope text-primary me-2"></i>
                                                        <div>
                                                            <strong>Email:</strong>
                                                            <a href="mailto:info@perpusnas.go.id" class="text-primary">info@perpusnas.go.id</a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Pengajuan minimal 7 hari sebelum pelaksanaan</li>
                                                <li>Biaya transportasi, akomodasi, dan keperluan lainnya ditanggung peserta</li>
                                                <li>Jadwal disesuaikan dengan ketersediaan narasumber</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Syarat Workshop -->
                                    <div class="col-lg-6 mb-4">
                                        <div class="requirement-section">
                                            <h5 class="requirement-title">
                                                <span class="requirement-number">2️⃣</span>
                                                Syarat dan Ketentuan Workshop
                                            </h5>
                                            <ul class="requirement-list">
                                                <li>Kirim surat permohonan narasumber resmi</li>
                                                <li>
                                                    <div class="contact-info">
                                                        <i class="bi bi-geo-alt text-primary me-2"></i>
                                                        <div>
                                                            <strong>Alamat tujuan:</strong><br>
                                                            Perpustakaan Nasional Republik Indonesia<br>
                                                            Jl. Salemba Raya No. 28A, Jakarta Pusat 10440
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="contact-info">
                                                        <i class="bi bi-envelope text-primary me-2"></i>
                                                        <div>
                                                            <strong>Email:</strong>
                                                            <a href="mailto:info@perpusnas.go.id" class="text-primary">info@perpusnas.go.id</a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Sertakan detail materi yang diinginkan</li>
                                                <li>Tentukan jumlah narasumber yang dibutuhkan</li>
                                                <li>Pengajuan minimal 7 hari sebelum acara</li>
                                                <li>Biaya narasumber ditanggung penyelenggara</li>
                                                <li>Tidak diperkenankan memungut biaya dari peserta</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-edit-form d-none">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Title</label>
                                    <input type="text" class="form-control edit-title" value="Syarat dan Ketentuan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Subtitle</label>
                                    <input type="text" class="form-control edit-subtitle" value="Persyaratan lengkap untuk pengajuan magang dan workshop">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Content</label>
                                    <textarea class="form-control edit-content" rows="12">Syarat dan Ketentuan Magang:
• Kirim surat permohonan resmi dari lembaga
• Alamat tujuan: Perpustakaan Nasional Republik Indonesia, Jl. Salemba Raya No. 28A, Jakarta Pusat 10440
• Email: info@perpusnas.go.id
• Pengajuan minimal 7 hari sebelum pelaksanaan
• Biaya transportasi, akomodasi, dan keperluan lainnya ditanggung peserta
• Jadwal disesuaikan dengan ketersediaan narasumber

Syarat dan Ketentuan Workshop:
• Kirim surat permohonan narasumber resmi
• Alamat tujuan: Perpustakaan Nasional Republik Indonesia, Jl. Salemba Raya No. 28A, Jakarta Pusat 10440
• Email: info@perpusnas.go.id
• Sertakan detail materi yang diinginkan
• Tentukan jumlah narasumber yang dibutuhkan
• Pengajuan minimal 7 hari sebelum acara
• Biaya narasumber ditanggung penyelenggara
• Tidak diperkenankan memungut biaya dari peserta</textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary save-card">
                                        <i class="bi bi-check-lg me-2"></i>Save
                                    </button>
                                    <button class="btn btn-secondary cancel-edit">
                                        <i class="bi bi-x-lg me-2"></i>Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5: Informasi Kontak -->
                    <div class="contact-card card" data-card-id="5">
                        <div class="card-header d-flex justify-content-between align-items-start">
                            <div class="card-title-section">
                                <h3 class="card-title mb-1">Informasi Kontak</h3>
                                <p class="card-subtitle text-muted mb-0">Hubungi kami untuk pertanyaan dan pengajuan</p>
                            </div>
                            <div class="dropdown">
                                <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                                    <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-content text-center">
                                <div class="contact-icon">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <h5 class="contact-title">Informasi Kontak</h5>
                                <p class="contact-text">
                                    Untuk seluruh pertanyaan dan pengajuan, silakan hubungi:
                                    <br>
                                    <a href="mailto:info@perpusnas.go.id" class="contact-email">info@perpusnas.go.id</a>
                                </p>
                            </div>
                            <div class="card-edit-form d-none">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Title</label>
                                    <input type="text" class="form-control edit-title" value="Informasi Kontak">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Subtitle</label>
                                    <input type="text" class="form-control edit-subtitle" value="Hubungi kami untuk pertanyaan dan pengajuan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Content</label>
                                    <textarea class="form-control edit-content" rows="4">Untuk seluruh pertanyaan dan pengajuan, silakan hubungi:

Email: info@perpusnas.go.id</textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary save-card">
                                        <i class="bi bi-check-lg me-2"></i>Save
                                    </button>
                                    <button class="btn btn-secondary cancel-edit">
                                        <i class="bi bi-x-lg me-2"></i>Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url('assets/js/admin/bimbingan.js') ?>"></script>
    
    <script>
        // Logout confirmation function
        function confirmLogout() {
            return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
        }

        // Initialize Feather icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</body>
</html>