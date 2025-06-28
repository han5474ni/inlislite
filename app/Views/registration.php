<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Registrasi - INLISLite v3.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/user_management.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/registration.css') ?>">
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
                                    <p class="card-text fs-4 fw-bold">1,250</p>
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
                                    <p class="card-text fs-4 fw-bold">1,100</p>
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
                                    <p class="card-text fs-4 fw-bold">150</p>
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
                            <button class="btn btn-outline-secondary me-2"><i class="fa-solid fa-download me-2"></i>Download Data</button>
                            <button class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#registrationModal">Registrasi Baru</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="sortable" data-sort="library">Nama Perpustakaan <i class="fa-solid fa-sort"></i></th>
                                        <th scope="col" class="sortable" data-sort="province">Provinsi <i class="fa-solid fa-sort"></i></th>
                                        <th scope="col" class="sortable" data-sort="status">Status <i class="fa-solid fa-sort"></i></th>
                                        <th scope="col" class="sortable" data-sort="date">Tanggal Registrasi <i class="fa-solid fa-sort"></i></th>
                                        <th scope="col" class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Placeholder Data -->
                                    <tr>
                                        <td>Perpustakaan Nasional RI</td>
                                        <td>DKI Jakarta</td>
                                        <td><span class="badge bg-success">Terverifikasi</span></td>
                                        <td>2024-01-15</td>
                                        <td class="text-end"><button class="btn btn-sm btn-icon"><i class="fa-solid fa-ellipsis-vertical"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>Perpustakaan Universitas Indonesia</td>
                                        <td>Jawa Barat</td>
                                        <td><span class="badge bg-success">Terverifikasi</span></td>
                                        <td>2024-02-20</td>
                                        <td class="text-end"><button class="btn btn-sm btn-icon"><i class="fa-solid fa-ellipsis-vertical"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>Perpustakaan Daerah Jawa Timur</td>
                                        <td>Jawa Timur</td>
                                        <td><span class="badge bg-warning text-dark">Menunggu Verifikasi</span></td>
                                        <td>2024-03-10</td>
                                        <td class="text-end"><button class="btn btn-sm btn-icon"><i class="fa-solid fa-ellipsis-vertical"></i></button></td>
                                    </tr>
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
                    <!-- Form goes here -->
                    <p>Formulir registrasi perpustakaan akan ditempatkan di sini.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
    <script src="<?= base_url('assets/js/registration.js') ?>"></script>
</body>
</html>