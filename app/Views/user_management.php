<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Manajemen - INLISLite v3.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/user_management.css') ?>">
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
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <div class="header-text">
                            <h1 class="h3 fw-bold">User Manajemen</h1>
                        <p class="text-muted mb-0">Kelola pengguna sistem dan hak aksesnya</p>
                    </div>
                </header>

                <!-- Filter Card -->
                <div class="card shadow-sm filter-card mb-4">
                    <div class="card-body">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-md-auto">
                                <h5 class="card-title fw-bold"><i class="fa-solid fa-users me-2"></i>User Manajemen</h5>
                                <p class="card-subtitle text-muted">Kelola pengguna dan izin akses mereka</p>
                            </div>
                            <div class="col-md-auto">
                                <button type="button" class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#userModal">
                                    Tambah User
                                </button>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row g-3">
                            <div class="col-lg-5 col-md-12">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-search"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0" placeholder="Cari pengguna...">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <select class="form-select">
                                    <option selected>Semua Role</option>
                                    <option value="1">Super Admin</option>
                                    <option value="2">Pustakawan</option>
                                    <option value="3">Staff</option>
                                    <option value="4">Admin</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <select class="form-select">
                                    <option selected>Semua Status</option>
                                    <option value="1">Aktif</option>
                                    <option value="2">Non-aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Table Card -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">User(4)</h5>
                        <p class="card-subtitle text-muted mb-3">Daftar seluruh pengguna sistem beserta informasinya</p>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="sortable" data-sort="name">User <i class="fa-solid fa-sort"></i></th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="sortable" data-sort="last_login">Terakhir masuk <i class="fa-solid fa-sort"></i></th>
                                        <th scope="col" class="sortable" data-sort="created">Dibuat <i class="fa-solid fa-sort"></i></th>
                                        <th scope="col" class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $users = [
                                        ['initial' => 'AS', 'name' => 'Administrator Sistem', 'email' => 'admin@inlislite.com', 'role' => 'Super Admin', 'role_color' => 'primary', 'status' => 'Aktif', 'status_color' => 'primary', 'last_login' => '2025-01-15 10:30:00', 'created' => '2024-01-01'],
                                        ['initial' => 'JS', 'name' => 'Jane Smith', 'email' => 'librarian@library.com', 'role' => 'Pustakawan', 'role_color' => 'success', 'status' => 'Aktif', 'status_color' => 'primary', 'last_login' => '2025-01-14 16:45:00', 'created' => '2024-03-15'],
                                        ['initial' => 'MJ', 'name' => 'Mike Johnson', 'email' => 'staff1@staff.com', 'role' => 'Staff', 'role_color' => 'dark-green', 'status' => 'Non-aktif', 'status_color' => 'secondary', 'last_login' => '2025-01-10 09:15:00', 'created' => '2023-06-20'],
                                        ['initial' => 'SW', 'name' => 'Sarah Wilson', 'email' => 'admin2@inlislite.com', 'role' => 'Admin', 'role_color' => 'info', 'status' => 'Aktif', 'status_color' => 'primary', 'last_login' => '2025-01-14 14:20:00', 'created' => '2023-05-10'],
                                    ];
                                    foreach ($users as $user) : ?>
                                    <tr
                                        data-name="<?= $user['name'] ?>"
                                        data-username="<?= strtolower(str_replace(' ', '', $user['name'])) ?>"
                                        data-email="<?= $user['email'] ?>"
                                        data-role="<?= $user['role'] ?>"
                                        data-status="<?= $user['status'] ?>">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-<?= strtolower(substr($user['name'], 0, 1)) ?>"><?= $user['initial'] ?></div>
                                                <div class="ms-3">
                                                    <div class="fw-bold"><?= $user['name'] ?></div>
                                                    <div class="text-muted small"><?= $user['email'] ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-role-<?= $user['role_color'] ?>"><?= $user['role'] ?></span></td>
                                        <td><span class="badge rounded-pill badge-status-<?= $user['status_color'] ?>"><?= $user['status'] ?></span></td>
                                        <td><?= $user['last_login'] ?></td>
                                        <td><?= $user['created'] ?></td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item edit-user-btn" href="#" data-bs-toggle="modal" data-bs-target="#userModal"><i class="fa-solid fa-pencil me-2"></i>Edit User</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="fa-solid fa-trash me-2"></i>Hapus User</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tbody id="no-data-row" style="display: none;">
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add/Edit User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h1 class="modal-title h5" id="userModalLabel">Tambahkan pengguna baru</h1>
                        <p class="modal-subtitle">Buat akun pengguna baru dan tetapkan izin akses.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="fullName" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="fullName">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Nama Pengguna</label>
                            <input type="text" class="form-control" id="username">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Kata Sandi</label>
                            <input type="password" class="form-control" id="password">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label fw-bold">Role</label>
                                <select id="role" class="form-select">
                                    <option>Staff</option>
                                    <option>Pustakawan</option>
                                    <option>Admin</option>
                                    <option>Super Admin</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <select id="status" class="form-select">
                                    <option>Aktif</option>
                                    <option>Non-Aktif</option>
                                    <option>Ditangguhkan</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success">Tambahkan User</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
    <script src="<?= base_url('assets/js/user_management.js') ?>"></script>
</body>
</html>