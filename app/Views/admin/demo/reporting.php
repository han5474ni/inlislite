<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Demo Pelaporan - INLISlite v3.0' ?></title>
    
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
                            <i class="bi bi-graph-up me-2"></i>
                            Demo Pelaporan
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="bi bi-graph-up me-2"></i>
                            Demo sistem pelaporan dan statistik perpustakaan.
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Sirkulasi Bulanan</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (isset($sample_data['monthly_circulation'])): ?>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Peminjaman</span>
                                                    <span class="badge bg-primary"><?= $sample_data['monthly_circulation']['loans'] ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Pengembalian</span>
                                                    <span class="badge bg-success"><?= $sample_data['monthly_circulation']['returns'] ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Terlambat</span>
                                                    <span class="badge bg-warning"><?= $sample_data['monthly_circulation']['overdue'] ?></span>
                                                </li>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Buku Populer</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (isset($sample_data['popular_books'])): ?>
                                            <?php foreach ($sample_data['popular_books'] as $book): ?>
                                                <div class="mb-2">
                                                    <small class="text-muted"><?= esc($book['title']) ?></small>
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: <?= ($book['loans'] / 50) * 100 ?>%"></div>
                                                    </div>
                                                    <small><?= $book['loans'] ?> peminjaman</small>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Statistik Koleksi</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (isset($sample_data['collection_stats'])): ?>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Total Item</span>
                                                    <span class="badge bg-info"><?= $sample_data['collection_stats']['total_items'] ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Tersedia</span>
                                                    <span class="badge bg-success"><?= $sample_data['collection_stats']['available'] ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Dipinjam</span>
                                                    <span class="badge bg-primary"><?= $sample_data['collection_stats']['on_loan'] ?></span>
                                                </li>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>
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