<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Patch and Updater') ?> - INLISLite v3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/patch.css') ?>">
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
                        <h5 class="mb-0 fw-bold">Patch and Updater</h5>
                        <small class="text-muted">Paket unduhan dan instalasi</small>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid py-4">
        <!-- Alert Messages -->
        <?php if (session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?= esc(session('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session('error') || isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i><?= esc(session('error') ?? $error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Information Section -->
        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
            <div class="d-flex align-items-start">
                <div class="info-icon me-3">
                    <i class="bi bi-shield-check text-primary"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="fw-bold mb-2">Paket Updater INLISLite versi 3 PHP-Opensource</h5>
                    <p class="text-muted mb-0">
                        Unduh dan terapkan pembaruan kumulatif untuk INLISLite v3. Updater ini ditujukan untuk memutakhirkan paket instalasi sebelumnya.
                    </p>
                </div>
            </div>

            <!-- Warning Box -->
            <div class="alert alert-warning d-flex align-items-start mt-4 mb-4">
                <i class="bi bi-exclamation-triangle-fill text-warning me-3 mt-1"></i>
                <div>
                    <strong>Penting:</strong> Jika Anda sedang melakukan migrasi data dari v2.1.2 atau aplikasi lain ke INLISLite v3, jangan terapkan updater kumulatif ini. Terapkan updater ini hanya setelah proses migrasi selesai, karena terdapat perubahan struktur basis data yang belum didukung oleh alat migrasi.
                </div>
            </div>

            <!-- Update Instructions -->
            <div class="update-instructions">
                <h6 class="text-primary fw-bold mb-3">Update Instructions</h6>
                <ol class="instruction-list">
                    <li>Backup instalasi INLISLite Anda saat ini.</li>
                    <li>Buka arsip 7z yang telah diunduh menggunakan 7zip atau WinRAR.</li>
                    <li>Ekstrak folder inlislite3 ke direktori C:/xampp/htdocs/ dan timpa (overwrite) file yang sudah ada.</li>
                    <li>Jalankan aplikasi INLISLite dan login ke modul backoffice.</li>
                    <li>Arahkan ke Administration → General Settings → Update Settings, lalu klik tombol Update.</li>
                </ol>
                <p class="text-muted small mb-0">
                    <strong>Catatan:</strong> Gunakan 7zip atau WinRAR untuk mengekstrak file terkompresi .7z.
                </p>
            </div>
        </div>

        <!-- Patches Management Section -->
        <div class="bg-white rounded-3 shadow-sm p-4">
            <!-- Header with Search and Filter -->
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="d-flex align-items-center">
                    <div class="patch-icon me-3">
                        <i class="bi bi-gear-fill text-primary"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Perbarui Paket</h5>
                        <p class="text-muted mb-0">Kelola patch, pembaruan, dan rilis INLISLite</p>
                    </div>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatchModal">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Paket
                </button>
            </div>

            <!-- Search and Filter -->
            <div class="row g-3 mb-4">
                <div class="col-md-8">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="searchInput" class="form-control ps-5" placeholder="Cari paket..." value="<?= esc($search ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-relative">
                        <i class="bi bi-funnel position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <select id="priorityFilter" class="form-select ps-5">
                            <option value="">Semua Prioritas</option>
                            <option value="High" <?= ($priority ?? '') === 'High' ? 'selected' : '' ?>>High</option>
                            <option value="Medium" <?= ($priority ?? '') === 'Medium' ? 'selected' : '' ?>>Medium</option>
                            <option value="Low" <?= ($priority ?? '') === 'Low' ? 'selected' : '' ?>>Low</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Patches Table Section -->
            <div class="mb-4">
                <h5 class="fw-bold mb-1">Pembaruan Tersedia (<span id="patchCount"><?= count($patches ?? []) ?></span>)</h5>
                <p class="text-muted mb-0">Jelajahi dan unduh paket pembaruan INLISLite</p>
            </div>

            <?php if (!empty($patches)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="fw-semibold">Detail Paket</th>
                                <th scope="col" class="fw-semibold text-center">Versi</th>
                                <th scope="col" class="fw-semibold text-center">Prioritas</th>
                                <th scope="col" class="fw-semibold text-center">Unduhan</th>
                                <th scope="col" class="fw-semibold text-center">Ukuran</th>
                                <th scope="col" class="fw-semibold text-center">Rilis</th>
                                <th scope="col" class="fw-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="patchTableBody">
                            <?php foreach ($patches as $patch): ?>
                                <tr class="patch-row" data-priority="<?= esc($patch['prioritas']) ?>">
                                    <td>
                                        <div class="patch-details">
                                            <h6 class="fw-bold mb-1 text-dark"><?= esc($patch['nama_paket']) ?></h6>
                                            <p class="text-muted small mb-0 lh-sm"><?= esc($patch['deskripsi']) ?></p>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border">v<?= esc($patch['versi']) ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge priority-badge bg-<?= $patch['prioritas'] == 'High' ? 'danger' : ($patch['prioritas'] == 'Medium' ? 'warning text-dark' : 'secondary') ?>">
                                            <?= esc($patch['prioritas']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted"><?= number_format($patch['jumlah_unduhan'] ?? 0) ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted"><?= esc($patch['ukuran']) ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted"><?= esc(date('Y-m-d', strtotime($patch['tanggal_rilis']))) ?></span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-primary btn-sm btn-download" data-id="<?= $patch['id'] ?>" title="Unduh Patch">
                                                <i class="bi bi-download me-1"></i>Unduh
                                            </button>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown" title="Opsi Lainnya">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item btn-edit" data-id="<?= $patch['id'] ?>">
                                                            <i class="bi bi-pencil me-2"></i>Edit
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-danger btn-delete" data-id="<?= $patch['id'] ?>">
                                                            <i class="bi bi-trash me-2"></i>Hapus
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted opacity-50"></i>
                    <h5 class="text-muted mt-3">Tidak ada patch tersedia</h5>
                    <p class="text-muted">Belum ada patch yang ditambahkan ke sistem.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Patch Modal -->
    <div class="modal fade" id="addPatchModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title text-dark fw-bold">
                        Tambah Paket
                    </h5>
                    <button type="button" class="btn-close custom-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addPatchForm">
                    <?= csrf_field() ?>
                    <div class="modal-body custom-modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="versi" class="form-label custom-label">Versi</label>
                                <input type="text" class="form-control custom-input" id="versi" name="versi" placeholder="3.2.1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_rilis" class="form-label custom-label">Tanggal Rilis</label>
                                <input type="date" class="form-control custom-input" id="tanggal_rilis" name="tanggal_rilis" required>
                            </div>
                            <div class="col-12">
                                <label for="nama_paket" class="form-label custom-label">Nama Paket</label>
                                <input type="text" class="form-control custom-input" id="nama_paket" name="nama_paket" placeholder="INLISLite v3.2 Cumulative Updater" required>
                            </div>
                            <div class="col-12">
                                <label for="deskripsi" class="form-label custom-label">Deskripsi</label>
                                <textarea class="form-control custom-textarea" id="deskripsi" name="deskripsi" rows="4" placeholder="Updater ini ditujukan untuk memperbaharui paket instalasi INLISLite v3 sebelumnya..." required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="prioritas" class="form-label custom-label">Prioritas</label>
                                <select class="form-select custom-select" id="prioritas" name="prioritas" required>
                                    <option value="">Pilih Prioritas</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="ukuran" class="form-label custom-label">Ukuran</label>
                                <input type="text" class="form-control custom-input" id="ukuran" name="ukuran" placeholder="15.2 MB" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer custom-modal-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-save">
                            Simpan Paket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Patch Modal -->
    <div class="modal fade" id="editPatchModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title text-dark fw-bold">
                        Edit Paket
                    </h5>
                    <button type="button" class="btn-close custom-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editPatchForm">
                    <?= csrf_field() ?>
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body custom-modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="edit_versi" class="form-label custom-label">Versi</label>
                                <input type="text" class="form-control custom-input" id="edit_versi" name="versi" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_tanggal_rilis" class="form-label custom-label">Tanggal Rilis</label>
                                <input type="date" class="form-control custom-input" id="edit_tanggal_rilis" name="tanggal_rilis" required>
                            </div>
                            <div class="col-12">
                                <label for="edit_nama_paket" class="form-label custom-label">Nama Paket</label>
                                <input type="text" class="form-control custom-input" id="edit_nama_paket" name="nama_paket" required>
                            </div>
                            <div class="col-12">
                                <label for="edit_deskripsi" class="form-label custom-label">Deskripsi</label>
                                <textarea class="form-control custom-textarea" id="edit_deskripsi" name="deskripsi" rows="4" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_prioritas" class="form-label custom-label">Prioritas</label>
                                <select class="form-select custom-select" id="edit_prioritas" name="prioritas" required>
                                    <option value="">Pilih Prioritas</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_ukuran" class="form-label custom-label">Ukuran</label>
                                <input type="text" class="form-control custom-input" id="edit_ukuran" name="ukuran" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer custom-modal-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-update">
                            Update Paket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Global variables for JavaScript
        window.patchConfig = {
            baseUrl: '<?= base_url("patch-updater/ajaxHandler") ?>',
            csrfToken: '<?= csrf_token() ?>',
            csrfHash: '<?= csrf_hash() ?>'
        };
    </script>
    <script src="<?= base_url('assets/js/admin/patch.js') ?>"></script>
</body>
</html>
