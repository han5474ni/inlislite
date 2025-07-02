<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="theme-color" content="#2DA84D">
    <title><?= esc($title ?? 'Panduan - INLISLite v3.0') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/panduan.css') ?>">
</head>
<body>
    <div id="wrapper" class="d-flex">
        <?= $this->include('layout/sidebar') ?>

        <!-- Page Content -->
        <main id="page-content-wrapper">
            <div class="container-fluid p-0">
                <!-- Header Section -->
                <header class="page-header-modern">
                    <div class="header-content">
                        <div class="header-top">
                            <a href="<?= site_url('dashboard') ?>" class="back-button">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                            <div class="header-icon">
                                <i class="fa-solid fa-book"></i>
                            </div>
                            <div class="header-titles">
                                <h1>Panduan</h1>
                                <p>Paket unduhan dan instalasi</p>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main Content -->
                <div class="main-content">
                    <!-- Hero Section -->
                    <div class="hero-section">
                        <div class="hero-icon">
                            <i class="fa-solid fa-file-alt"></i>
                        </div>
                        <div class="hero-content">
                            <h2>Panduan Penggunaan INLISLite Versi 3 PHP Opensource.</h2>
                            <p>Dokumentasi resmi dan panduan praktis untuk membantu Anda menggunakan semua fitur sistem manajemen perpustakaan INLISLite v3 secara efektif.</p>
                        </div>
                    </div>

                    <!-- Search and Action Bar -->
                    <div class="action-bar">
                        <div class="search-container">
                            <div class="search-box">
                                <i class="fa-solid fa-search"></i>
                                <input type="text" placeholder="Cari dokumen..." id="searchDocuments">
                            </div>
                        </div>
                        <button class="btn-add-document" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                            <i class="fa-solid fa-plus"></i>
                            Tambah Dokumen
                        </button>
                    </div>

                    <!-- Documents Section -->
                    <div class="documents-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fa-solid fa-download"></i>
                            </div>
                            <div class="section-title">
                                <h3>Dokumentasi Tersedia(<?= count($documents ?? []) ?>)</h3>
                                <p>Protokol Instalasi Arsip Terbuka untuk Pengembilan Metadata</p>
                            </div>
                        </div>

                        <div class="documents-container">
                            <?php if (empty($documents)): ?>
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fa-solid fa-folder-open"></i>
                                    </div>
                                    <h6>Belum ada dokumen panduan</h6>
                                    <p>Tambahkan dokumen panduan pertama Anda</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($documents as $index => $document): ?>
                                <div class="document-card" data-id="<?= $document['id'] ?>">
                                    <div class="document-number">
                                        <?= $index + 1 ?>
                                    </div>
                                    <div class="document-info">
                                        <h4 class="document-title"><?= esc($document['title']) ?></h4>
                                        <p class="document-description"><?= esc($document['description']) ?></p>
                                        <div class="document-meta">
                                            <span class="file-type">PDF</span>
                                            <span class="file-size"><?= esc($document['file_size'] ?? '0 MB') ?></span>
                                            <?php if (!empty($document['version'])): ?>
                                            <span class="file-version">v<?= esc($document['version']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="document-actions">
                                        <button class="btn-action btn-download" data-id="<?= $document['id'] ?>">
                                            <i class="fa-solid fa-download"></i>
                                            Unduh
                                        </button>
                                        <button class="btn-action btn-edit" data-id="<?= $document['id'] ?>">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button class="btn-action btn-delete" data-id="<?= $document['id'] ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Additional Resources Section -->
                    <div class="resources-section">
                        <div class="resources-header">
                            <div class="resources-icon">
                                <i class="fa-solid fa-plus-circle"></i>
                            </div>
                            <h3>Sumber Daya Tambahan</h3>
                        </div>
                        
                        <div class="resources-content">
                            <div class="resource-card">
                                <div class="resource-icon install">
                                    <i class="fa-solid fa-download"></i>
                                </div>
                                <div class="resource-info">
                                    <h4>Petunjuk Instalasi:</h4>
                                    <p>Untuk petunjuk instalasi secara lengkap, silakan kunjungi: 
                                        <a href="#">Installer > Platform PHP (Opensource)</a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="resource-card">
                                <div class="resource-icon update">
                                    <i class="fa-solid fa-sync-alt"></i>
                                </div>
                                <div class="resource-info">
                                    <h4>Petunjuk Pembaruan:</h4>
                                    <p>Untuk petunjuk penerapan pembaruan, silakan kunjungi: 
                                        <a href="#">Patch & Updater > Platform PHP (Opensource)</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Document Modal -->
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title h5">Tambah Dokumen Baru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-4">Tambahkan dokumen panduan penggunaan baru ke dalam koleksi.</p>
                    <form id="addDocumentForm">
                        <div class="mb-3">
                            <label for="documentTitle" class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="documentTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="documentDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="documentFileSize" class="form-label">Ukuran File</label>
                                    <input type="text" class="form-control" id="documentFileSize" name="file_size" placeholder="2.5 MB">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="documentVersion" class="form-label">Versi</label>
                                    <input type="text" class="form-control" id="documentVersion" name="version" placeholder="3.2.1">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="saveDocument">Tambah Dokumen</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Document Modal -->
    <div class="modal fade" id="editDocumentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title h5">Edit Dokumen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDocumentForm">
                        <input type="hidden" id="editDocumentId" name="id">
                        <div class="mb-3">
                            <label for="editDocumentTitle" class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editDocumentTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDocumentDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDocumentDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editDocumentFileSize" class="form-label">Ukuran File</label>
                                    <input type="text" class="form-control" id="editDocumentFileSize" name="file_size" placeholder="2.5 MB">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editDocumentVersion" class="form-label">Versi</label>
                                    <input type="text" class="form-control" id="editDocumentVersion" name="version" placeholder="3.2.1">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="updateDocument">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/admin/panduan.js') ?>"></script>
</body>
</html>
