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
                
                <!-- Success/Error Messages -->
                <?php if (session()->has('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-check-circle me-2"></i>
                        <?= session('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-exclamation-circle me-2"></i>
                        <?= session('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-exclamation-circle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
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
                <div class="card filter-card mb-4">
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
                            <div class="col-lg-4 col-md-12">
                                <select id="lastLoginFilter" class="form-select">
                                    <option value="">Semua Waktu Login</option>
                                    <option value="today">Hari ini</option>
                                    <option value="week">7 hari terakhir</option>
                                    <option value="month">30 hari terakhir</option>
                                    <option value="never">Belum pernah masuk</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Table Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="card-title fw-bold mb-1">User(4)</h5>
                                <p class="card-subtitle text-muted mb-0">Daftar seluruh pengguna sistem beserta informasinya</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="fa-solid fa-download me-1"></i>Export
                                </button>
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="fa-solid fa-refresh me-1"></i>Refresh
                                </button>
                            </div>
                        </div>
                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="table align-middle">
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
                                    <?php foreach ($users as $user) : 
                                        $initial = strtoupper(substr($user['nama_lengkap'], 0, 1));
                                        $roleColors = [
                                            'Super Admin' => 'primary',
                                            'Admin' => 'info',
                                            'Pustakawan' => 'success',
                                            'Staff' => 'secondary',
                                        ];
                                        $statusColors = [
                                            'Aktif' => 'primary',
                                            'Non-Aktif' => 'secondary',
                                            'Ditangguhkan' => 'warning',
                                        ];
                                        $roleColor = $roleColors[$user['role']] ?? 'secondary';
                                        $statusColor = $statusColors[$user['status']] ?? 'secondary';
                                    ?>
                                    <tr data-id="<?= $user['id'] ?>"
                                        data-name="<?= esc($user['nama_lengkap']) ?>"
                                        data-username="<?= esc($user['nama_pengguna']) ?>"
                                        data-email="<?= esc($user['email']) ?>"
                                        data-role="<?= esc($user['role']) ?>"
                                        data-status="<?= esc($user['status']) ?>"
                                        data-last-login="<?= $user['last_login'] ?>"
                                        data-created="<?= $user['created_at'] ?>"
                                        data-created-timestamp="<?= strtotime($user['created_at']) ?>"
                                        data-last-login-timestamp="<?= $user['last_login'] ? strtotime($user['last_login']) : 0 ?>">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-<?= strtolower($initial) ?>"><?= $initial ?></div>
                                                <div class="ms-3 user-info">
                                                    <div class="user-name"><?= esc($user['nama_lengkap']) ?></div>
                                                    <div class="user-email"><?= esc($user['email']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-role-<?= $roleColor ?>"><?= esc($user['role']) ?></span></td>
                                        <td><span class="badge rounded-pill badge-status-<?= $statusColor ?>"><?= esc($user['status']) ?></span></td>
                                        <td class="date-column">
                                            <?php if ($user['last_login']): ?>
                                                <div class="date-primary" 
                                                     data-bs-toggle="tooltip" 
                                                     data-bs-placement="top" 
                                                     title="<?= date('l, d F Y H:i:s', strtotime($user['last_login'])) ?> WIB">
                                                    <?= date('d/m/Y', strtotime($user['last_login'])) ?>
                                                </div>
                                                <small class="date-time"><?= date('H:i', strtotime($user['last_login'])) ?> WIB</small>
                                            <?php else: ?>
                                                <span class="never-login" 
                                                      data-bs-toggle="tooltip" 
                                                      data-bs-placement="top" 
                                                      title="User ini belum pernah melakukan login">
                                                    Belum pernah masuk
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="date-column">
                                            <div class="fw-bold" 
                                                 data-bs-toggle="tooltip" 
                                                 data-bs-placement="top" 
                                                 title="Dibuat pada <?= date('l, d F Y H:i:s', strtotime($user['created_at'])) ?> WIB">
                                                <?= date('d/m/Y', strtotime($user['created_at'])) ?>
                                            </div>
                                            <small class="date-time"><?= date('H:i', strtotime($user['created_at'])) ?> WIB</small>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-icon dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="true" id="dropdownMenuButton<?= $user['id'] ?>" aria-haspopup="true">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-start shadow" aria-labelledby="dropdownMenuButton<?= $user['id'] ?>">
                                                    <div class="dropdown-header">Aksi</div>
                                                    <a class="dropdown-item edit-user-btn" href="#" data-bs-toggle="modal" data-bs-target="#userModal">
                                                        <i class="fa-solid fa-pencil me-2"></i>Edit User
                                                    </a>
                                                    <a class="dropdown-item text-danger delete-user-btn" href="#" data-user-id="<?= $user['id'] ?>">
                                                        <i class="fa-solid fa-trash me-2"></i>Hapus
                                                    </a>
                                                </div>
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
                    <form id="userForm" method="post" action="<?= site_url('usermanagement/addUser') ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" id="userId" name="id" value="">
                        <div id="form-errors" class="alert alert-danger d-none"></div>
                        <div id="form-success" class="alert alert-success d-none"></div>
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_pengguna" class="form-label fw-bold">Nama Pengguna</label>
                            <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3" id="passwordGroup">
                            <label for="kata_sandi" class="form-label fw-bold">Kata Sandi</label>
                            <input type="password" class="form-control" id="kata_sandi" name="kata_sandi" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label fw-bold">Role</label>
                                <select id="role" name="role" class="form-select" required>
                                    <option value="">Pilih Role</option>
                                    <option value="Super Admin">Super Admin</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Pustakawan">Pustakawan</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Non-Aktif">Non-Aktif</option>
                                    <option value="Ditangguhkan">Ditangguhkan</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" id="submitUserBtn">
                        <span class="btn-text">Tambahkan User</span>
                        <span class="btn-spinner d-none">
                            <i class="fa-solid fa-spinner fa-spin me-1"></i>Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
    <script src="<?= base_url('assets/js/user_management.js') ?>"></script>
</body>
</html>