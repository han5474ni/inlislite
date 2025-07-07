<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Demo Katalogisasi - INLISlite v3.0' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="bi bi-book me-2"></i>
                            Demo Katalogisasi
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Halaman demo katalogisasi sedang dalam pengembangan.
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Statistik Koleksi</h5>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total Buku</span>
                                        <span class="badge bg-primary"><?= $sample_data['total_books'] ?? 0 ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total Kategori</span>
                                        <span class="badge bg-secondary"><?= $sample_data['total_categories'] ?? 0 ?></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Tambahan Terbaru</h5>
                                <?php if (isset($sample_data['recent_additions'])): ?>
                                    <?php foreach ($sample_data['recent_additions'] as $book): ?>
                                        <div class="card mb-2">
                                            <div class="card-body p-3">
                                                <h6 class="card-title"><?= esc($book['title']) ?></h6>
                                                <p class="card-text small">
                                                    <strong>Penulis:</strong> <?= esc($book['author']) ?><br>
                                                    <strong>ISBN:</strong> <?= esc($book['isbn']) ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="<?= base_url('admin/demo') ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Kembali ke Demo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>