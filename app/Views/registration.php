<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="theme-color" content="#2DA84D">
    <title>Manajemen Registrasi - INLISLite v3.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/user_management.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/registration.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/registration-extra.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive.css') ?>">
</head>
<body>
    <div id="wrapper" class="d-flex">
        <?= $this->include('layout/sidebar') ?>

        <!-- Page Content -->
        <main id="page-content-wrapper">
            <div class="container-fluid p-4">
                <header class="page-header-um">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm mobile-menu-toggle d-md-none me-3" id="mobile-menu-toggle">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <a href="<?= site_url('dashboard') ?>" class="back-arrow">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div class="icon-box-um">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <div class="header-text">
                        <h1 class="h3 fw-bold">Manajemen Registrasi</h1>
                        <p class="text-muted mb-0">Kelola data registrasi penggunaan sistem aplikasi INLISLite</p>
                    </div>
                </header>

                <!-- Statistics Section -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card stat-card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-primary text-white me-3">
                                    <i class="fa-solid fa-building-columns"></i>
                                </div>
                                <div>
                                    <h5 class="card-title fw-bold">Total Registrasi</h5>
                                    <p class="card-text fs-4 fw-bold"><?= isset($stats['total']) ? number_format($stats['total']) : '0' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-success text-white me-3">
                                    <i class="fa-solid fa-check-circle"></i>
                                </div>
                                <div>
                                    <h5 class="card-title fw-bold">Terverifikasi</h5>
                                    <p class="card-text fs-4 fw-bold"><?= isset($stats['verified']) ? number_format($stats['verified']) : '0' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-warning text-dark me-3">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div>
                                    <h5 class="card-title fw-bold">Menunggu Verifikasi</h5>
                                    <p class="card-text fs-4 fw-bold"><?= isset($stats['pending']) ? number_format($stats['pending']) : '0' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title mb-0 me-3">Statistik Registrasi Bulanan</h5>
                                    <button id="debugBtn" class="btn btn-sm btn-outline-secondary me-2">Debug</button>
                                </div>
                                <select id="yearSelector" class="form-select w-auto">
                                    <option value="">Loading...</option>
                                </select>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="registrationChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                             <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-search"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" placeholder="Cari berdasarkan nama perpustakaan atau provinsi...">
                            </div>
                        </div>
                        <div class="d-flex">
                            <?php if (($stats['total'] ?? 0) == 0): ?>
                                <a href="<?= site_url('setup/create-registrations-table') ?>" class="btn btn-success me-2">
                                    <i class="fa-solid fa-database me-2"></i>Setup Database
                                </a>
                            <?php endif; ?>
                            <div class="dropdown me-2">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-download me-2"></i>Download Data
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" id="downloadCSV">
                                        <i class="fa-solid fa-file-csv me-2"></i>Download CSV
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" id="downloadExcel">
                                        <i class="fa-solid fa-file-excel me-2"></i>Download Excel
                                    </a></li>
                                </ul>
                            </div>
                            <button class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#registrationModal">Registrasi Baru</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="sortable" data-sort="library">
                                            <span class="d-none d-md-inline">Nama Perpustakaan</span>
                                            <span class="d-md-none">Perpustakaan</span>
                                            <i class="fa-solid fa-sort"></i>
                                        </th>
                                        <th scope="col" class="sortable d-none d-sm-table-cell" data-sort="province">
                                            Provinsi <i class="fa-solid fa-sort"></i>
                                        </th>
                                        <th scope="col" class="sortable" data-sort="status">Status <i class="fa-solid fa-sort"></i></th>
                                        <th scope="col" class="sortable d-none d-lg-table-cell" data-sort="date">
                                            <span class="d-none d-xl-inline">Tanggal Registrasi</span>
                                            <span class="d-xl-none">Tanggal</span>
                                            <i class="fa-solid fa-sort"></i>
                                        </th>
                                        <th scope="col" class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="registrationTableBody">
                                    <?php if (empty($registrations)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                Belum ada data registrasi. Silakan tambah registrasi baru.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($registrations as $registration): ?>
                                        <tr data-id="<?= $registration['id'] ?>">
                                            <td>
                                                <div class="fw-semibold"><?= esc($registration['library_name']) ?></div>
                                                <div class="d-sm-none text-muted small">
                                                    <?= esc($registration['province']) ?> • <?= esc($registration['city']) ?>
                                                </div>
                                                <div class="d-lg-none text-muted small mt-1">
                                                    <?= date('d/m/Y', strtotime($registration['created_at'])) ?>
                                                </div>
                                            </td>
                                            <td class="d-none d-sm-table-cell"><?= esc($registration['province']) ?></td>
                                            <td>
                                                <select class="form-select form-select-sm status-dropdown" data-id="<?= $registration['id'] ?>" style="width: 140px;">
                                                    <option value="pending" <?= $registration['status'] === 'pending' ? 'selected' : '' ?>>
                                                        <span class="d-none d-md-inline">Menunggu Verifikasi</span>
                                                        <span class="d-md-none">Menunggu</span>
                                                    </option>
                                                    <option value="verified" <?= $registration['status'] === 'verified' ? 'selected' : '' ?>>
                                                        Terverifikasi
                                                    </option>
                                                    <option value="rejected" <?= $registration['status'] === 'rejected' ? 'selected' : '' ?>>
                                                        Ditolak
                                                    </option>
                                                </select>
                                            </td>
                                            <td class="d-none d-lg-table-cell">
                                                <span class="d-none d-xl-inline"><?= date('Y-m-d H:i:s', strtotime($registration['created_at'])) ?></span>
                                                <span class="d-xl-none"><?= date('d/m/Y', strtotime($registration['created_at'])) ?></span>
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php if ($registration['status'] === 'pending'): ?>
                                                        <li><a class="dropdown-item verify-btn" href="#" data-id="<?= $registration['id'] ?>">
                                                            <i class="fa-solid fa-check me-2"></i>Verifikasi
                                                        </a></li>
                                                        <li><a class="dropdown-item reject-btn" href="#" data-id="<?= $registration['id'] ?>">
                                                            <i class="fa-solid fa-times me-2"></i>Tolak
                                                        </a></li>
                                                        <?php endif; ?>
                                                        <li><a class="dropdown-item delete-btn text-danger" href="#" data-id="<?= $registration['id'] ?>">
                                                            <i class="fa-solid fa-trash me-2"></i>Hapus
                                                        </a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Registration Modal -->
    <div class="modal fade" id="registrationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title h5">Registrasi Perpustakaan Baru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registrationForm">
                        <div class="mb-3">
                            <label for="libraryName" class="form-label">Nama Perpustakaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="libraryName" name="library_name" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="province" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                    <select class="form-select" id="province" name="province" required>
                                        <option value="">Pilih Provinsi</option>
                                        <option value="DKI Jakarta">DKI Jakarta</option>
                                        <option value="Jawa Barat">Jawa Barat</option>
                                        <option value="Jawa Tengah">Jawa Tengah</option>
                                        <option value="Jawa Timur">Jawa Timur</option>
                                        <option value="DI Yogyakarta">DI Yogyakarta</option>
                                        <option value="Bali">Bali</option>
                                        <option value="Sumatera Utara">Sumatera Utara</option>
                                        <option value="Sumatera Barat">Sumatera Barat</option>
                                        <option value="Sumatera Selatan">Sumatera Selatan</option>
                                        <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                                        <option value="Sulawesi Utara">Sulawesi Utara</option>
                                        <option value="Kalimantan Timur">Kalimantan Timur</option>
                                        <option value="Kalimantan Barat">Kalimantan Barat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="city" name="city" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveRegistration">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-refresh indicator -->
    <div id="autoRefreshIndicator" class="auto-refresh-indicator">
        <i class="fa-solid fa-sync-alt me-1"></i>
        Auto-refresh aktif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
    <script src="<?= base_url('assets/js/registration.js') ?>"></script>
</body>
</html>