<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? ($mode === 'edit' ? 'Edit Registrasi' : 'Tambah Registrasi') . ' - INLISlite v3.0' ?></title>
    
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
    <link href="<?= base_url('assets/css/admin/registration.css') ?>" rel="stylesheet">
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
                <a href="<?= base_url('registration') ?>" class="nav-link active">
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
        <!-- Top App Bar -->
        <div class="top-app-bar">
            <div class="container-fluid">
                <div class="app-bar-content">
                    <div class="app-bar-left">
                        <a href="<?= base_url('registration') ?>" class="back-arrow-btn" title="Kembali ke Registrasi">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div class="app-bar-logo">
                            <div class="logo-icon">
                                <i class="bi bi-book-half"></i>
                            </div>
                            <div class="logo-text">
                                <h1 class="app-title">Registrasi Inlislite</h1>
                                <p class="app-subtitle">Kelola pengguna sistem dan hak aksesnya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            <div class="container-fluid">
                <!-- Form Header -->
                <div class="form-header">
                    <h2 class="form-title">
                        <?= $mode === 'edit' ? 'Edit Registrasi Perpustakaan' : 'Tambah Registrasi Perpustakaan' ?>
                    </h2>
                    <p class="form-subtitle">
                        <?= $mode === 'edit' ? 'Perbarui informasi registrasi perpustakaan' : 'Daftarkan perpustakaan baru ke sistem INLISLite' ?>
                    </p>
                </div>

                <!-- Registration Form -->
                <form id="registrationForm" class="registration-form">
                    <div class="form-sections">
                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Informasi Dasar
                                </h3>
                                <p class="section-subtitle">Informasi umum tentang perpustakaan</p>
                            </div>
                            <div class="section-content">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label required">Nama Perpustakaan</label>
                                        <input type="text" class="form-control" name="library_name" 
                                               value="<?= $mode === 'edit' ? 'Perpustakaan Medan' : '' ?>" 
                                               placeholder="Masukkan nama perpustakaan" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label required">Jenis Perpustakaan</label>
                                        <select class="form-select" name="library_type" required>
                                            <option value="">Pilih Jenis</option>
                                            <option value="Public" <?= $mode === 'edit' ? 'selected' : '' ?>>Perpustakaan Umum</option>
                                            <option value="Academic">Perpustakaan Akademik</option>
                                            <option value="School">Perpustakaan Sekolah</option>
                                            <option value="Special">Perpustakaan Khusus</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required">Status</label>
                                        <select class="form-select" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Active" <?= $mode === 'edit' ? 'selected' : '' ?>>Aktif</option>
                                            <option value="Inactive">Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kode Perpustakaan</label>
                                        <input type="text" class="form-control" name="library_code" 
                                               value="<?= $mode === 'edit' ? 'LIB-MDN-001' : '' ?>" 
                                               placeholder="Kode unik perpustakaan">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location Information Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    Informasi Lokasi
                                </h3>
                                <p class="section-subtitle">Alamat dan lokasi perpustakaan</p>
                            </div>
                            <div class="section-content">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label required">Provinsi</label>
                                        <select class="form-select" name="province" required>
                                            <option value="">Pilih Provinsi</option>
                                            <option value="Sumatera Utara" <?= $mode === 'edit' ? 'selected' : '' ?>>Sumatera Utara</option>
                                            <option value="DKI Jakarta">DKI Jakarta</option>
                                            <option value="Jawa Barat">Jawa Barat</option>
                                            <option value="Jawa Tengah">Jawa Tengah</option>
                                            <option value="Jawa Timur">Jawa Timur</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required">Kota/Kabupaten</label>
                                        <input type="text" class="form-control" name="city" 
                                               value="<?= $mode === 'edit' ? 'Medan' : '' ?>" 
                                               placeholder="Masukkan kota/kabupaten" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label required">Alamat Lengkap</label>
                                        <textarea class="form-control" name="address" rows="3" 
                                                  placeholder="Masukkan alamat lengkap perpustakaan" required><?= $mode === 'edit' ? 'Jl. Sisingamangaraja No. 24, Medan, Sumatera Utara 20212' : '' ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kode Pos</label>
                                        <input type="text" class="form-control" name="postal_code" 
                                               value="<?= $mode === 'edit' ? '20212' : '' ?>" 
                                               placeholder="Kode pos">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Koordinat (Opsional)</label>
                                        <input type="text" class="form-control" name="coordinates" 
                                               value="<?= $mode === 'edit' ? '3.5952, 98.6722' : '' ?>" 
                                               placeholder="Latitude, Longitude">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="bi bi-person-lines-fill me-2"></i>
                                    Informasi Kontak
                                </h3>
                                <p class="section-subtitle">Kontak person dan informasi komunikasi</p>
                            </div>
                            <div class="section-content">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label required">Nama Penanggung Jawab</label>
                                        <input type="text" class="form-control" name="contact_name" 
                                               value="<?= $mode === 'edit' ? 'Dr. Ahmad Rahman' : '' ?>" 
                                               placeholder="Nama lengkap penanggung jawab" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="contact_position" 
                                               value="<?= $mode === 'edit' ? 'Kepala Perpustakaan' : '' ?>" 
                                               placeholder="Jabatan penanggung jawab">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required">Email</label>
                                        <input type="email" class="form-control" name="email" 
                                               value="<?= $mode === 'edit' ? 'ahmad@perpustakaanmedan.go.id' : '' ?>" 
                                               placeholder="alamat@email.com" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required">Nomor Telepon</label>
                                        <input type="tel" class="form-control" name="phone" 
                                               value="<?= $mode === 'edit' ? '+62-21-3928484' : '' ?>" 
                                               placeholder="+62-xxx-xxxx-xxxx" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Website</label>
                                        <input type="url" class="form-control" name="website" 
                                               value="<?= $mode === 'edit' ? 'https://perpustakaanmedan.go.id' : '' ?>" 
                                               placeholder="https://website-perpustakaan.com">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Fax</label>
                                        <input type="tel" class="form-control" name="fax" 
                                               value="<?= $mode === 'edit' ? '+62-21-3928485' : '' ?>" 
                                               placeholder="+62-xxx-xxxx-xxxx">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="bi bi-file-text me-2"></i>
                                    Informasi Tambahan
                                </h3>
                                <p class="section-subtitle">Informasi operasional dan catatan</p>
                            </div>
                            <div class="section-content">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Tahun Berdiri</label>
                                        <input type="number" class="form-control" name="established_year" 
                                               value="<?= $mode === 'edit' ? '1985' : '' ?>" 
                                               placeholder="YYYY" min="1900" max="2024">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Jumlah Koleksi</label>
                                        <input type="number" class="form-control" name="collection_count" 
                                               value="<?= $mode === 'edit' ? '25000' : '' ?>" 
                                               placeholder="Jumlah buku/koleksi" min="0">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Jumlah Anggota</label>
                                        <input type="number" class="form-control" name="member_count" 
                                               value="<?= $mode === 'edit' ? '1500' : '' ?>" 
                                               placeholder="Jumlah anggota aktif" min="0">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Catatan</label>
                                        <textarea class="form-control" name="notes" rows="3" 
                                                  placeholder="Catatan tambahan tentang perpustakaan"><?= $mode === 'edit' ? 'Perpustakaan umum terbesar di Sumatera Utara dengan koleksi lengkap dan fasilitas modern.' : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-outline-secondary" onclick="history.back()">
                            <i class="bi bi-x-lg me-2"></i>
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>
                            <?= $mode === 'edit' ? 'Simpan Perubahan' : 'Simpan Registrasi' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url('assets/js/admin/registration.js') ?>"></script>
    
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