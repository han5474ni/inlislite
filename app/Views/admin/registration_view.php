<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'View Registration - INLISlite v3.0' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <!-- Registration View CSS -->
    <link href="<?= base_url('assets/css/admin/registration_view.css') ?>" rel="stylesheet">
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
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="INLISLite Logo" style="width: 24px; height: 24px;">
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
                <a href="<?= base_url('admin/registration') ?>" class="nav-link active">
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
        <div class="page-container" data-registration-id="<?= $registration['id'] ?? '' ?>">
            <!-- Page Header -->
            <div class="page-header">
                <div class="header-top">
                    <div class="header-left">
                        <div class="header-icon">
                            <i class="bi bi-book"></i>
                        </div>
                        <div>
                            <h1 class="page-title">Registrasi Inlislite</h1>
                            <p class="page-subtitle">Kelola pengguna sistem dan hak aksesnya</p>
                        </div>
                    </div>
                    <div class="header-right">
                        <a href="<?= base_url('admin/registration') ?>" class="back-btn">
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Library Main Card -->
            <div class="library-main-card">
                <div class="library-card-content">
                    <div class="library-info">
                        <h2 class="library-name"><?= esc($registration['library_name'] ?? 'Library Name') ?></h2>
                        <p class="library-province"><?= esc($registration['province'] ?? 'Province') ?></p>
                    </div>
                    <div class="library-badges">
                        <span class="badge badge-type badge-<?= strtolower($registration['library_type'] ?? 'public') ?>">
                            <?= esc($registration['library_type'] ?? 'Perpustakaan Publik') ?>
                        </span>
                        <span class="badge badge-status badge-<?= strtolower($registration['status'] ?? 'active') ?>">
                            <?php 
                            $status = $registration['status'] ?? 'Active';
                            echo $status === 'Active' ? 'Aktif' : 'Nonaktif';
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Information Sections -->
            <div class="info-sections">
                <!-- Informasi Perpustakaan Section -->
                <div class="info-card">
                    <div class="info-header">
                        <i class="bi bi-building"></i>
                        <h3>Informasi Perpustakaan</h3>
                    </div>
                    <div class="info-content">
                        <div class="info-field">
                            <label>Nama Perpustakaan</label>
                            <div class="field-display"><?= esc($registration['library_name'] ?? 'N/A') ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-field">
                                <label>Tipe</label>
                                <div class="field-display"><?= esc($registration['library_type'] ?? 'N/A') ?></div>
                            </div>
                            <div class="info-field">
                                <label>Status</label>
                                <div class="field-display">
                                    <span class="status-indicator status-<?= strtolower($registration['status'] ?? 'active') ?>">
                                        <?php 
                                        $status = $registration['status'] ?? 'Active';
                                        echo $status === 'Active' ? 'Aktif' : 'Nonaktif';
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lokasi dan Linimasa Section -->
                <div class="info-card">
                    <div class="info-header">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Lokasi dan Linimasa</h3>
                    </div>
                    <div class="info-content">
                        <div class="info-row">
                            <div class="info-field">
                                <label><i class="bi bi-geo-alt-fill me-2"></i>Lokasi</label>
                                <div class="field-display"><?= esc($registration['city'] ?? 'N/A') ?></div>
                            </div>
                            <div class="info-field">
                                <label><i class="bi bi-map me-2"></i>Provinsi</label>
                                <div class="field-display"><?= esc($registration['province'] ?? 'N/A') ?></div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-field">
                                <label><i class="bi bi-calendar-plus me-2"></i>Tanggal Registrasi</label>
                                <div class="field-display">
                                    <?php if (isset($registration['created_at'])): ?>
                                        <?= date('d M Y', strtotime($registration['created_at'])) ?>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="info-field">
                                <label><i class="bi bi-clock me-2"></i>Update Terakhir</label>
                                <div class="field-display">
                                    <?php if (isset($registration['updated_at'])): ?>
                                        <?= date('d M Y', strtotime($registration['updated_at'])) ?>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Kontak Section -->
                <div class="info-card">
                    <div class="info-header">
                        <i class="bi bi-person-lines-fill"></i>
                        <h3>Informasi Kontak</h3>
                    </div>
                    <div class="info-content">
                        <div class="contact-list">
                            <div class="contact-item">
                                <i class="bi bi-person-fill"></i>
                                <div>
                                    <label>Penanggung Jawab</label>
                                    <span><?= esc($registration['contact_name'] ?? 'N/A') ?></span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="bi bi-envelope-fill"></i>
                                <div>
                                    <label>Email</label>
                                    <span>
                                        <?php if (!empty($registration['email'])): ?>
                                            <a href="mailto:<?= esc($registration['email']) ?>"><?= esc($registration['email']) ?></a>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="bi bi-telephone-fill"></i>
                                <div>
                                    <label>Telepon</label>
                                    <span>
                                        <?php if (!empty($registration['phone'])): ?>
                                            <a href="tel:<?= esc($registration['phone']) ?>"><?= esc($registration['phone']) ?></a>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                            <?php if (!empty($registration['contact_position'])): ?>
                            <div class="contact-item">
                                <i class="bi bi-briefcase-fill"></i>
                                <div>
                                    <label>Jabatan</label>
                                    <span><?= esc($registration['contact_position']) ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($registration['website'])): ?>
                            <div class="contact-item">
                                <i class="bi bi-globe"></i>
                                <div>
                                    <label>Website</label>
                                    <span><a href="<?= esc($registration['website']) ?>" target="_blank"><?= esc($registration['website']) ?></a></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($registration['fax'])): ?>
                            <div class="contact-item">
                                <i class="bi bi-printer"></i>
                                <div>
                                    <label>Fax</label>
                                    <span><?= esc($registration['fax']) ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Informasi Detail Section -->
                <div class="info-card">
                    <div class="info-header">
                        <i class="bi bi-info-circle-fill"></i>
                        <h3>Informasi Detail</h3>
                    </div>
                    <div class="info-content">
                        <div class="info-row">
                            <div class="info-field">
                                <label>Kode Perpustakaan</label>
                                <div class="field-display"><?= esc($registration['library_code'] ?? 'N/A') ?></div>
                            </div>
                            <?php if (!empty($registration['established_year'])): ?>
                            <div class="info-field">
                                <label>Tahun Berdiri</label>
                                <div class="field-display"><?= esc($registration['established_year']) ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($registration['address'])): ?>
                        <div class="info-field">
                            <label>Alamat Lengkap</label>
                            <div class="field-display"><?= esc($registration['address']) ?></div>
                        </div>
                        <?php endif; ?>
                        <div class="info-row">
                            <?php if (!empty($registration['postal_code'])): ?>
                            <div class="info-field">
                                <label>Kode Pos</label>
                                <div class="field-display"><?= esc($registration['postal_code']) ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($registration['coordinates'])): ?>
                            <div class="info-field">
                                <label>Koordinat</label>
                                <div class="field-display"><?= esc($registration['coordinates']) ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($registration['collection_count']) || !empty($registration['member_count'])): ?>
                        <div class="info-row">
                            <?php if (!empty($registration['collection_count'])): ?>
                            <div class="info-field">
                                <label>Jumlah Koleksi</label>
                                <div class="field-display"><?= number_format($registration['collection_count']) ?> item</div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($registration['member_count'])): ?>
                            <div class="info-field">
                                <label>Jumlah Anggota</label>
                                <div class="field-display"><?= number_format($registration['member_count']) ?> orang</div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($registration['notes'])): ?>
                        <div class="info-field">
                            <label>Catatan</label>
                            <div class="field-display"><?= nl2br(esc($registration['notes'])) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS (for sidebar functionality) -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- Registration View JS -->
    <script src="<?= base_url('assets/js/admin/registration_view.js') ?>"></script>
</body>
</html>