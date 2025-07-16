<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'User History - INLISLite v3.0' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Include Enhanced Sidebar -->
    <?= $this->include('admin/partials/sidebar') ?>

    <!-- Main Content -->
    <main class="enhanced-main-content">
        <div class="dashboard-container">
            <div class="header-card">
                <div class="content-header">
                    <div class="d-flex align-items-center mb-3">
                        <button class="btn btn-outline-primary me-3" onclick="history.back()">
                            <i class="bi bi-arrow-left"></i> Back
                        </button>
                        <div>
                            <h1 class="main-title">User Activity History</h1>
                            <p class="main-subtitle">Activity log for <?= esc($user['nama_lengkap'] ?? $user['nama_pengguna'] ?? 'Unknown User') ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="page-container">
                <!-- User Info Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-person-circle me-2"></i>
                            User Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <?php if (!empty($user['avatar'])): ?>
                                        <img src="<?= base_url('images/profile/' . $user['avatar']) ?>" 
                                             alt="Avatar" class="rounded-circle mb-3" 
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white mb-3 mx-auto" 
                                             style="width: 80px; height: 80px; font-size: 2rem;">
                                            <?= substr($user['nama_lengkap'] ?? $user['nama_pengguna'] ?? 'U', 0, 1) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Full Name:</strong> <?= esc($user['nama_lengkap'] ?? 'N/A') ?></p>
                                        <p><strong>Username:</strong> <?= esc($user['nama_pengguna'] ?? $user['username'] ?? 'N/A') ?></p>
                                        <p><strong>Email:</strong> <?= esc($user['email'] ?? 'N/A') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Role:</strong> 
                                            <span class="badge bg-primary"><?= esc($user['role'] ?? 'N/A') ?></span>
                                        </p>
                                        <p><strong>Status:</strong> 
                                            <span class="badge <?= ($user['status'] ?? '') === 'Aktif' ? 'bg-success' : 'bg-danger' ?>">
                                                <?= esc($user['status'] ?? 'N/A') ?>
                                            </span>
                                        </p>
                                        <p><strong>Last Login:</strong> <?= isset($user['last_login']) && $user['last_login'] ? date('d M Y H:i', strtotime($user['last_login'])) : 'Never' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Log -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-clock-history me-2"></i>
                            Activity Log
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($activities)): ?>
                            <div class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="mt-2 text-muted">No activity records found</p>
                            </div>
                        <?php else: ?>
                            <div class="timeline">
                                <?php foreach ($activities as $activity): ?>
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-<?= $activity['color'] ?? 'secondary' ?>">
                                            <i class="bi <?= $activity['icon'] ?? 'bi-activity' ?>"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-header">
                                                <h6 class="timeline-title"><?= esc($activity['description']) ?></h6>
                                                <small class="text-muted"><?= $activity['created_at_formatted'] ?></small>
                                            </div>
                                            <div class="timeline-body">
                                                <p class="mb-2"><strong>Action:</strong> <?= esc($activity['action']) ?></p>
                                                <p class="mb-2"><strong>IP Address:</strong> <?= esc($activity['ip_address']) ?></p>
                                                <?php if (!empty($activity['old_data_decoded'])): ?>
                                                    <div class="mb-2">
                                                        <strong>Old Data:</strong>
                                                        <pre class="bg-light p-2 rounded small"><?= json_encode($activity['old_data_decoded'], JSON_PRETTY_PRINT) ?></pre>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($activity['new_data_decoded'])): ?>
                                                    <div class="mb-2">
                                                        <strong>New Data:</strong>
                                                        <pre class="bg-light p-2 rounded small"><?= json_encode($activity['new_data_decoded'], JSON_PRETTY_PRINT) ?></pre>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .timeline {
            position: relative;
            padding-left: 2rem;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }
        
        .timeline-marker {
            position: absolute;
            left: -1.5rem;
            top: 0;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .timeline-content {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .timeline-header {
            display: flex;
            justify-content: between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }
        
        .timeline-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            flex: 1;
        }
    </style>
</body>
</html>
