<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Demo Sirkulasi - INLISlite v3.0' ?></title>
    
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
                            <i class="bi bi-arrow-repeat me-2"></i>
                            Demo Sirkulasi
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            Demo sistem sirkulasi peminjaman dan pengembalian buku.
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h3><?= $sample_data['active_loans'] ?? 0 ?></h3>
                                        <p>Peminjaman Aktif</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h3><?= $sample_data['overdue_items'] ?? 0 ?></h3>
                                        <p>Terlambat</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h3><?= $sample_data['returns_today'] ?? 0 ?></h3>
                                        <p>Kembali Hari Ini</p>
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