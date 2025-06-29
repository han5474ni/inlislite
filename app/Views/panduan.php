<?php
// Panduan INLISLite Versi 3
$page_title = "Panduan";
$page_subtitle = "Paket unduhan dan instalasi";

// Helper function for file size formatting
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc($title ?? $page_title); ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/panduan.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Header Navigation -->
    <header class="header-nav bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <div class="row align-items-center py-3">
                <div class="col-auto">
                    <button class="btn btn-link text-decoration-none p-0" id="backBtn">
                        <i class="bi bi-arrow-left fs-4 text-dark"></i>
                    </button>
                </div>
                <div class="col">
                    <div class="d-flex align-items-center">
                        <div class="header-icon me-3">
                            <i class="bi bi-book text-white"></i>
                        </div>
                        <div>
                            <h1 class="header-title mb-0"><?php echo esc($page_title); ?></h1>
                            <p class="header-subtitle text-muted mb-0"><?php echo esc($page_subtitle); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mt-4 pb-5">
        <!-- Hero Section -->
        <div class="text-center mb-5">
            <div class="hero-icon mx-auto mb-4">
                <i class="bi bi-file-earmark-text fs-1 text-white"></i>
            </div>
            <h2 class="hero-title mb-3">Panduan Penggunaan INLISLite Versi 3 PHP Opensource.</h2>
            <p class="hero-description text-muted">
                Dokumentasi resmi dan panduan praktis untuk membantu Anda menggunakan semua fitur 
                sistem manajemen perpustakaan INLISLite v3 secara efektif.
            </p>
        </div>

        <!-- Search and Add Section -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="search-wrapper">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="form-control search-input" placeholder="Cari dokumen..." id="searchInput">
                </div>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                    + Tambah Dokumen
                </button>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <?= session('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Setup Required Alert -->
        <?php if (isset($setup_required) && $setup_required): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Database Setup Required!</strong><br>
                <?= $error_message ?? 'Database table belum dibuat.' ?><br>
                <hr class="my-2">
                <p class="mb-2"><strong>Quick Fix:</strong></p>
                <button class="btn btn-warning btn-sm me-2" onclick="autoSetupDatabase()" id="autoSetupBtn">
                    <i class="bi bi-tools me-1"></i>Auto Setup Database
                </button>
                <a href="/install_db.php" class="btn btn-info btn-sm me-2" target="_blank">
                    <i class="bi bi-gear me-1"></i>Manual Setup
                </a>
                <button class="btn btn-secondary btn-sm" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise me-1"></i>Refresh Page
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Documents Section -->
        <div class="documents-container">
            <div class="documents-header mb-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-download text-success me-3 fs-4"></i>
                    <div>
                        <h3 class="mb-0 fw-bold">Dokumentasi Tersedia(<span class="documents-count"><?= $document_count ?></span>)</h3>
                        <small class="text-muted">Protokol Instalasi Arsip Terbuka untuk Pengembangan Metadata</small>
                    </div>
                </div>
            </div>

            <!-- Document List -->
            <div class="document-list" id="documentList">
                <?php if (!empty($documents)) : ?>
                    <?php foreach ($documents as $index => $doc) : ?>
                        <div class="document-item" data-document-id="<?= $doc['id'] ?>">
                            <div class="d-flex align-items-start">
                                <div class="document-number me-3">
                                    <span class="number"><?= $index + 1 ?></span>
                                </div>
                                <div class="document-content flex-grow-1">
                                    <h5 class="document-title mb-2"><?= esc($doc['title']) ?></h5>
                                    <p class="document-description text-muted mb-2"><?= esc($doc['description']) ?></p>
                                    <div class="document-meta d-flex align-items-center gap-3">
                                        <span class="document-badge"><?= esc($doc['file_type']) ?></span>
                                        <span class="document-size"><?= formatFileSize($doc['file_size']) ?></span>
                                        <span class="document-version"><?= esc($doc['version']) ?></span>
                                        <span class="document-downloads"><?= $doc['download_count'] ?? 0 ?> unduhan</span>
                                    </div>
                                </div>
                                <div class="document-actions">
                                    <button class="btn-action btn-download" onclick="downloadDocument(<?= $doc['id'] ?>)" title="Unduh">
                                        <i class="bi bi-download"></i>
                                        Unduh
                                    </button>
                                    <button class="btn-action btn-edit" onclick="editDocument(<?= $doc['id'] ?>)" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn-action btn-delete" onclick="deleteDocument(<?= $doc['id'] ?>)" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="no-documents text-center py-5">
                        <i class="bi bi-file-earmark-x fs-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada dokumen</h5>
                        <p class="text-muted">Klik tombol "Tambah Dokumen" untuk menambahkan dokumen baru.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Additional Resources Section -->
        <div class="resources-card mt-5">
            <div class="resources-card-header">
                <i class="bi bi-file-earmark-text text-primary me-3"></i>
                <h3 class="resources-title">Sumber Daya Tambahan</h3>
            </div>
            
            <div class="resources-card-body">
                <div class="resource-item-card">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-download resource-icon me-3"></i>
                        <div class="resource-content">
                            <strong class="resource-label">Petunjuk Instalasi:</strong>
                            <div class="resource-description">
                                Untuk petunjuk instalasi secara lengkap, silakan kunjungi: 
                                <a href="#" class="resource-link">Installer > Platform PHP (Opensource)</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="resource-item-card">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-arrow-repeat resource-icon me-3"></i>
                        <div class="resource-content">
                            <strong class="resource-label">Petunjuk Pembaruan:</strong>
                            <div class="resource-description">
                                Untuk petunjuk penerapan pembaruan, silakan kunjungi: 
                                <a href="#" class="resource-link">Patch & Updater > Platform PHP (Opensource)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
                    <form id="addDocumentForm" enctype="multipart/form-data">
                        <input type="hidden" id="documentId" name="document_id" value="">
                        
                        <div id="form-errors" class="alert alert-danger d-none"></div>
                        <div id="form-success" class="alert alert-success d-none"></div>
                        
                        <div class="mb-3">
                            <label for="documentTitle" class="form-label custom-label">Judul Dokumen</label>
                            <input type="text" class="form-control custom-input" id="documentTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentDescription" class="form-label custom-label">Deskripsi</label>
                            <textarea class="form-control custom-textarea" id="documentDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="documentVersion" class="form-label custom-label">Versi</label>
                                    <input type="text" class="form-control custom-input" id="documentVersion" name="version" placeholder="V3.2.0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="documentType" class="form-label custom-label">Tipe File</label>
                                    <select class="form-select custom-select" id="documentType" name="file_type" required>
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
                            
                            <!-- Current file display (for edit mode) -->
                            <div id="currentFileDisplay" class="alert alert-info d-none mb-2">
                                <i class="bi bi-file-earmark me-2"></i>
                                <strong>File saat ini:</strong> <span id="currentFileName">-</span>
                                <br><small class="text-muted">Upload file baru untuk mengganti file yang ada</small>
                            </div>
                            
                            <input type="file" class="form-control custom-input" id="documentFile" name="document_file" accept=".pdf,.doc,.docx">
                            <div class="form-text" id="fileHelpText">Biarkan kosong jika tidak ingin mengubah file (khusus untuk edit)</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer custom-modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-save" id="saveDocumentBtn">
                        <span class="btn-text">Simpan Dokumen</span>
                        <span class="btn-spinner d-none">
                            <i class="bi bi-arrow-repeat spin me-1"></i>Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/panduan.js') ?>"></script>
    
    <!-- Auto Setup Database Function -->
    <script>
    function autoSetupDatabase() {
        const btn = document.getElementById('autoSetupBtn');
        const originalHtml = btn.innerHTML;
        
        // Show loading state
        btn.innerHTML = '<i class="bi bi-arrow-clockwise fa-spin me-1"></i>Setting up...';
        btn.disabled = true;
        
        fetch('<?= base_url('documents/setup') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const alert = document.querySelector('.alert-warning');
                alert.className = 'alert alert-success alert-dismissible fade show';
                alert.innerHTML = `
                    <i class="bi bi-check-circle me-2"></i>
                    <strong>Setup Berhasil!</strong><br>
                    ${data.message}<br>
                    <hr class="my-2">
                    <button class="btn btn-success btn-sm" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reload Page
                    </button>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
            } else {
                alert('Error: ' + data.message);
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat setup database');
            btn.innerHTML = originalHtml;
            btn.disabled = false;
        });
    }
    </script>
</body>
</html>
