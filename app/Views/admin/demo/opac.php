<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Demo OPAC - INLISlite v3.0' ?></title>
    
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
                            <i class="bi bi-search me-2"></i>
                            Demo OPAC (Online Public Access Catalog)
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-secondary">
                            <i class="bi bi-search me-2"></i>
                            Demo Online Public Access Catalog untuk pencarian katalog perpustakaan.
                        </div>
                        
                        <!-- Search Demo -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari buku, penulis, atau subjek..." value="PHP Programming">
                                    <button class="btn btn-primary" type="button">
                                        <i class="bi bi-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Search Results -->
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Hasil Pencarian</h5>
                                <?php if (isset($sample_data['search_results'])): ?>
                                    <?php foreach ($sample_data['search_results'] as $result): ?>
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h6 class="card-title"><?= esc($result['title']) ?></h6>
                                                <p class="card-text">
                                                    <strong>Penulis:</strong> <?= esc($result['author']) ?><br>
                                                    <strong>Penerbit:</strong> <?= esc($result['publisher']) ?><br>
                                                    <strong>Tahun:</strong> <?= esc($result['year']) ?>
                                                </p>
                                                <span class="badge <?= $result['availability'] === 'Tersedia' ? 'bg-success' : 'bg-warning' ?>">
                                                    <?= esc($result['availability']) ?>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <h5>Pencarian Populer</h5>
                                <?php if (isset($sample_data['popular_searches'])): ?>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php foreach ($sample_data['popular_searches'] as $search): ?>
                                            <span class="badge bg-light text-dark border"><?= esc($search) ?></span>
                                        <?php endforeach; ?>
                                    </div>
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