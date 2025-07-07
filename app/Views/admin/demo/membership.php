<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Demo Keanggotaan - INLISlite v3.0' ?></title>
    
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
                            <i class="bi bi-people me-2"></i>
                            Demo Keanggotaan
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Demo sistem manajemen anggota perpustakaan.
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h3><?= $sample_data['total_members'] ?? 0 ?></h3>
                                        <p>Total Anggota</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h3><?= $sample_data['active_members'] ?? 0 ?></h3>
                                        <p>Anggota Aktif</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h3><?= $sample_data['new_registrations'] ?? 0 ?></h3>
                                        <p>Registrasi Baru</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Kategori Anggota</h5>
                                <?php if (isset($sample_data['member_categories'])): ?>
                                    <ul class="list-group">
                                        <?php foreach ($sample_data['member_categories'] as $category => $count): ?>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span><?= esc($category) ?></span>
                                            <span class="badge bg-primary"><?= $count ?></span>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
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