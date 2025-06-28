<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Panduan - INLISLite v3') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/panduan.css') ?>">
</head>
<body style="background-color: #f8f9fa;">
    <div class="d-flex" id="wrapper">
        <?= $this->include('layout/sidebar') ?>

        <!-- Page Content -->
        <main id="page-content-wrapper" style="background-color: #f8f9fa;">
            <header class="page-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-sm mobile-menu-toggle d-md-none me-3" id="mobile-menu-toggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div>
                        <h1 class="h2 font-weight-bold"><?= esc($page_title ?? 'Panduan') ?></h1>
                        <p class="text-muted"><?= esc($page_subtitle ?? 'Paket unduhan dan instalasi') ?></p>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-primary me-3">
                        <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="darkModeSwitch">
                        <label class="form-check-label" for="darkModeSwitch"><i class="fa-solid fa-moon"></i></label>
                    </div>
                </div>
            </header>

            <div class="container-fluid px-4">
                <!-- Header with back arrow and title -->
                <div class="d-flex align-items-center mb-4">
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-link p-0 me-3 text-decoration-none text-dark">
                        <i class="fa-solid fa-arrow-left fs-4"></i>
                    </a>
                    <div class="d-flex align-items-center">
                        <div class="bg-info text-white rounded p-2 me-3" style="background-color: #17a2b8 !important;">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <div>
                            <h2 class="mb-0 fw-bold">Panduan</h2>
                            <small class="text-muted">Paket unduhan dan instalasi</small>
                        </div>
                    </div>
                </div>

                <hr class="mb-5">

                <!-- Main Content Area -->
                <div class="text-center mb-5">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="fa-solid fa-file-text fs-1"></i>
                    </div>
                    <h1 class="fw-bold mb-3">Panduan Penggunaan INLISLite Versi 3 PHP Opensource.</h1>
                    <p class="text-muted lead">
                        Dokumentasi resmi dan panduan praktis untuk membantu Anda menggunakan semua fitur 
                        sistem manajemen perpustakaan INLISLite v3 secara efektif.
                    </p>
                </div>

                <!-- Search and Add Document Section -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari dokumen..." id="searchInput">
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                            <i class="fa-solid fa-plus me-2"></i>Tambah Dokumen
                        </button>
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="text-success me-3">
                                <i class="fa-solid fa-download fs-4"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">Dokumentasi Tersedia <span class="text-muted">(6)</span></h3>
                                <small class="text-muted">Protokol Instalasi Arsip Terbuka untuk Pengembangan Metadata</small>
                            </div>
                        </div>

                        <!-- Document List -->
                        <div id="documentList">
                            <?php
                            $documents = [
                                [
                                    'id' => 1,
                                    'title' => 'Panduan Pengguna Revisi 16062016 – Modul Lengkap',
                                    'description' => 'Panduan komprehensif yang mencakup semua modul dan fitur INLISLite v3',
                                    'size' => '12 MB',
                                    'version' => 'V3.2.1',
                                    'type' => 'PDF'
                                ],
                                [
                                    'id' => 2,
                                    'title' => 'Panduan Praktis – Pengaturan Administrasi di INLISLite v3',
                                    'description' => 'Panduan langkah demi langkah untuk mengonfigurasi pengaturan administratif',
                                    'size' => '1.8 MB',
                                    'version' => 'V3.2.0',
                                    'type' => 'PDF'
                                ],
                                [
                                    'id' => 3,
                                    'title' => 'Panduan Praktis – Manajemen Bahan Pustaka di INLISLite v3',
                                    'description' => 'Panduan langkah demi langkah untuk mengonfigurasi pengaturan administratif',
                                    'size' => '1.8 MB',
                                    'version' => 'V3.2.0',
                                    'type' => 'PDF'
                                ],
                                [
                                    'id' => 4,
                                    'title' => 'Panduan Praktis – Manajemen Keanggotaan di INLISLite v3',
                                    'description' => 'Manual pengguna untuk mengelola akun dan profil anggota perpustakaan',
                                    'size' => '1.7 MB',
                                    'version' => 'V3.2.0',
                                    'type' => 'PDF'
                                ],
                                [
                                    'id' => 5,
                                    'title' => 'Panduan Praktis – Manajemen Keanggotaan di INLISLite v3',
                                    'description' => 'Manual pengguna untuk mengelola akun dan profil anggota perpustakaan',
                                    'size' => '1.7 MB',
                                    'version' => 'V3.2.0',
                                    'type' => 'PDF'
                                ],
                                [
                                    'id' => 6,
                                    'title' => 'Panduan Praktis – Pembuatan Survei di INLISLite v3',
                                    'description' => 'Panduan untuk membuat dan mengelola survei serta umpan balik perpustakaan',
                                    'size' => '1.4 MB',
                                    'version' => 'V3.1.5',
                                    'type' => 'PDF'
                                ]
                            ];

                            foreach ($documents as $index => $doc) : ?>
                                <div class="document-item border-bottom py-3" data-document-id="<?= $doc['id'] ?>">
                                    <div class="row align-items-center">
                                        <div class="col-md-1">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <span class="fw-bold"><?= $index + 1 ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <h5 class="fw-bold mb-1"><?= $doc['title'] ?></h5>
                                            <p class="text-muted mb-2 small"><?= $doc['description'] ?></p>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-success me-2"><?= $doc['type'] ?></span>
                                                <small class="text-muted me-3"><?= $doc['size'] ?></small>
                                                <small class="text-muted"><?= $doc['version'] ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <button class="btn btn-outline-secondary btn-sm me-2" onclick="downloadDocument(<?= $doc['id'] ?>)">
                                                <i class="fa-solid fa-download me-1"></i>Unduh
                                            </button>
                                            <button class="btn btn-outline-primary btn-sm me-2" onclick="editDocument(<?= $doc['id'] ?>)">
                                                <i class="fa-solid fa-edit me-1"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="deleteDocument(<?= $doc['id'] ?>)">
                                                <i class="fa-solid fa-trash me-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Additional Resources Section -->
                <div class="card shadow-sm border-0 bg-white mt-5 mb-5">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-primary me-3">
                                <i class="fa-solid fa-edit fs-4"></i>
                            </div>
                            <h3 class="mb-0 fw-bold">Sumber Daya Tambahan</h3>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="text-primary me-3 mt-1">
                                        <i class="fa-solid fa-download"></i>
                                    </div>
                                    <div>
                                        <strong>Petunjuk Instalasi:</strong><br>
                                        <span class="text-muted">Untuk petunjuk instalasi secara lengkap, silakan kunjungi: </span> 
                                        <a href="#" class="text-primary">Installer > Platform PHP (Opensource)</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="text-primary me-3 mt-1">
                                        <i class="fa-solid fa-sync"></i>
                                    </div>
                                    <div>
                                        <strong>Petunjuk Pembaruan:</strong><br>
                                        <span class="text-muted">Untuk petunjuk penerapan pembaruan, silakan kunjungi: </span> 
                                        <a href="#" class="text-primary">Patch & Updater > Platform PHP (Opensource)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Document Modal -->
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content custom-modal">
                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title" id="addDocumentModalLabel">Tambah Dokumen Baru</h5>
                    <button type="button" class="custom-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
                <div class="modal-body custom-modal-body">
                    <form id="addDocumentForm">
                        <div class="mb-3">
                            <label for="documentTitle" class="form-label custom-label">Judul Dokumen</label>
                            <input type="text" class="form-control custom-input" id="documentTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentDescription" class="form-label custom-label">Deskripsi</label>
                            <textarea class="form-control custom-textarea" id="documentDescription" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="documentVersion" class="form-label custom-label">Versi</label>
                                    <input type="text" class="form-control custom-input" id="documentVersion" placeholder="V3.2.0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="documentType" class="form-label custom-label">Tipe File</label>
                                    <select class="form-select custom-select" id="documentType" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="PDF">PDF</option>
                                        <option value="DOC">DOC</option>
                                        <option value="DOCX">DOCX</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="documentFile" class="form-label custom-label">Upload File</label>
                            <input type="file" class="form-control custom-input" id="documentFile" accept=".pdf,.doc,.docx" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer custom-modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-save" onclick="saveDocument()">Simpan Dokumen</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
    <script src="<?= base_url('assets/js/panduan.js') ?>"></script>
</body>
</html>
