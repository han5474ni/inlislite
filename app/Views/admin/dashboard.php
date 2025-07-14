<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'INLISLite v3.0 Dashboard - Sistem Perpustakaan Modern' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Include Enhanced Sidebar -->
    <?= $this->include('admin/partials/sidebar') ?>

    <!-- Main Content -->
    <main class="enhanced-main-content">
        <div class="dashboard-container">
            <div class="header-card">
                <div class="content-header">
                    <h1 class="main-title"><?= $page_title ?? 'Selamat Datang di InlisLite!' ?></h1>
                    <p class="main-subtitle"><?= $page_subtitle ?? 'Kelola sistem perpustakaan Anda dengan alat dan analitik yang lengkap.' ?></p>
                </div>
            </div>

        <!-- Dashboard Statistics Cards -->
        <div class="dashboard-stats">


        </div>

        <!-- Charts Section -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Total Users (Last 7 Days)
                    </div>
                    <div class="card-body">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Total Registrations (Last 7 Days)
                    </div>
                    <div class="card-body">
                        <canvas id="registrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="dashboard-activity">
            <div class="row">
                <!-- Recent Users -->
                <div class="col-md-6">
                    <div class="activity-card">
                        <div class="activity-header">
                            <h4><i class="bi bi-people me-2"></i>Recent Users</h4>
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="activity-list">
                            <?php if (!empty($recentUsers)): ?>
                                <?php foreach (array_slice($recentUsers, 0, 5) as $user): ?>
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="bi bi-person-plus"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-title"><?= esc($user['nama_lengkap'] ?? $user['username']) ?></div>
                                        <div class="activity-meta"><?= esc($user['role'] ?? 'User') ?> • <?= date('M j, Y', strtotime($user['created_at'])) ?></div>
                                    </div>
                                    <div class="activity-status">
                                        <span class="badge bg-<?= ($user['status'] ?? 'Non-Aktif') == 'Aktif' ? 'success' : 'secondary' ?>">
                                            <?= esc($user['status'] ?? 'Non-Aktif') ?>
                                        </span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="activity-empty">
                                    <i class="bi bi-inbox"></i>
                                    <p>No recent users found</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Registrations -->
                <div class="col-md-6">
                    <div class="activity-card">
                        <div class="activity-header">
                            <h4><i class="bi bi-clipboard-check me-2"></i>Recent Registrations</h4>
                            <a href="<?= base_url('admin/registration') ?>" class="btn btn-sm btn-outline-success">View All</a>
                        </div>
                        <div class="activity-list">
                            <?php if (!empty($recentRegistrations)): ?>
                                <?php foreach (array_slice($recentRegistrations, 0, 5) as $registration): ?>
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-title"><?= esc($registration['nama_perpustakaan'] ?? 'Library Registration') ?></div>
                                        <div class="activity-meta"><?= esc($registration['alamat'] ?? 'No address') ?> • <?= date('M j, Y', strtotime($registration['created_at'])) ?></div>
                                    </div>
                                    <div class="activity-status">
                                        <span class="badge bg-<?= ($registration['status'] ?? 'pending') == 'active' ? 'success' : 'warning' ?>">
                                            <?= ucfirst($registration['status'] ?? 'pending') ?>
                                        </span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="activity-empty">
                                    <i class="bi bi-inbox"></i>
                                    <p>No recent registrations found</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Features Section -->
        <div class="quick-actions">
            <div class="header-card">
                <div class="quick-actions-header">
                    <h3><i class="bi bi-grid-3x3-gap me-2"></i>Quick Access</h3>
                    <p>Preview dan akses cepat ke semua fitur sistem</p>
                </div>
            </div>
            <div class="action-grid">
                <a href="<?= base_url('admin/tentang') ?>" class="action-card">
                    <div class="action-icon bg-primary">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div class="action-content">
                        <h4>Tentang</h4>
                        <p>Informasi sistem dan organisasi</p>
                    </div>
                </a>
                <a href="<?= base_url('admin/fitur') ?>" class="action-card">
                    <div class="action-icon bg-success">
                        <i class="bi bi-gear"></i>
                    </div>
                    <div class="action-content">
                        <h4>Fitur</h4>
                        <p>Kelola fitur dan pengaturan sistem</p>
                    </div>
                </a>
                <a href="<?= base_url('admin/installer') ?>" class="action-card">
                    <div class="action-icon bg-info">
                        <i class="bi bi-download"></i>
                    </div>
                    <div class="action-content">
                        <h4>Installer</h4>
                        <p>Download aplikasi dan tools</p>
                    </div>
                </a>
                <a href="<?= base_url('admin/patch') ?>" class="action-card">
                    <div class="action-icon bg-warning">
                        <i class="bi bi-arrow-up-circle"></i>
                    </div>
                    <div class="action-content">
                        <h4>Patch</h4>
                        <p>Update dan perbaikan sistem</p>
                    </div>
                </a>
                <a href="<?= base_url('admin/aplikasi') ?>" class="action-card">
                    <div class="action-icon bg-purple">
                        <i class="bi bi-app-indicator"></i>
                    </div>
                    <div class="action-content">
                        <h4>Aplikasi</h4>
                        <p>Manajemen aplikasi perpustakaan</p>
                    </div>
                </a>
                <a href="<?= base_url('admin/panduan') ?>" class="action-card">
                    <div class="action-icon bg-secondary">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="action-content">
                        <h4>Panduan</h4>
                        <p>Manual dan dokumentasi pengguna</p>
                    </div>
                </a>
                <a href="<?= base_url('admin/dukungan') ?>" class="action-card">
                    <div class="action-icon bg-cyan">
                        <i class="bi bi-headset"></i>
                    </div>
                    <div class="action-content">
                        <h4>Dukungan</h4>
                        <p>Bantuan teknis dan support</p>
                    </div>
                </a>
                <a href="<?= base_url('admin/bimbingan') ?>" class="action-card">
                    <div class="action-icon bg-orange">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <div class="action-content">
                        <h4>Bimbingan</h4>
                        <p>Pelatihan dan tutorial sistem</p>
                    </div>
                </a>
                <a href="<?= base_url('admin/demo') ?>" class="action-card">
                    <div class="action-icon bg-danger">
                        <i class="bi bi-play-circle"></i>
                    </div>
                    <div class="action-content">
                        <h4>Demo</h4>
                        <p>Demo fitur dan contoh penggunaan</p>
                    </div>
                </a>
            </div>
        </div>
        </div> <!-- Close dashboard-container -->
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    
    <style>
        /* Dashboard Container */
        .dashboard-container {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .header-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid #f0f0f0;
        }

        .header-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid #f0f0f0;
        }

        /* Dashboard Stats Cards */
        .dashboard-stats {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid #f0f0f0;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-header {
            display: flex;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            margin-right: 15px;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
        }

        .stat-info p {
            margin: 0;
            font-size: 0.9rem;
            color: #666;
            font-weight: 500;
        }

        .stat-link {
            margin-left: auto;
            color: #6c757d;
            text-decoration: none;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .stat-link:hover {
            background: rgba(0, 0, 0, 0.05);
            color: #333;
        }

        .stat-details {
            display: flex;
            padding: 15px 20px 20px;
            gap: 15px;
        }

        .stat-details .stat-item {
            flex: 1;
            text-align: center;
        }

        .stat-details .value {
            display: block;
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .stat-details .label {
            font-size: 0.8rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-online {
            color: #28a745 !important;
        }

        /* Enhanced Profile Card Styles */
        .profile-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }

        .profile-header {
            display: flex;
            align-items: center;
            padding: 25px 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px 12px 0 0;
        }

        .profile-avatar {
            position: relative;
            margin-right: 15px;
        }

        .profile-photo, .profile-photo-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .profile-photo-placeholder {
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: rgba(255, 255, 255, 0.8);
        }

        .online-indicator {
            position: absolute;
            bottom: 3px;
            right: 3px;
            width: 16px;
            height: 16px;
            background: #28a745;
            border: 2px solid white;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            margin: 0 0 5px 0;
            font-size: 1.3rem;
            font-weight: 600;
            color: white;
        }

        .profile-role {
            margin: 0 0 8px 0;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .profile-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .profile-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .profile-details {
            padding: 0;
            background: rgba(255, 255, 255, 0.05);
        }

        .profile-detail-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: background 0.2s;
        }

        .profile-detail-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .profile-detail-item:last-child {
            border-bottom: none;
            border-radius: 0 0 12px 12px;
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
        }

        .detail-content {
            flex: 1;
        }

        .detail-value {
            display: block;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            margin-bottom: 2px;
        }

        .detail-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Activity Section */
        .dashboard-activity {
            margin-bottom: 30px;
        }

        .activity-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            border: 1px solid #f0f0f0;
            height: 100%;
        }

        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .activity-header h4 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
        }

        .activity-list {
            padding: 0;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #f8f9fa;
            transition: background 0.2s;
        }

        .activity-item:hover {
            background: #f8f9fa;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: #6c757d;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
            font-size: 0.9rem;
        }

        .activity-meta {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .activity-status {
            margin-left: 10px;
        }

        .activity-empty {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .activity-empty i {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }

        .profile-role {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 8px;
        }

        .profile-status {
            font-size: 0.85rem;
            color: #28a745;
            font-weight: 500;
        }

        /* Quick Actions */
        .quick-actions {
            margin-bottom: 30px;
        }

        .quick-actions-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .quick-actions-header h3 {
            margin: 0 0 8px 0;
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
        }

        .quick-actions-header p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .action-card {
            display: block;
            background: white;
            border-radius: 16px;
            padding: 30px 25px;
            text-decoration: none;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
            transition: all 0.3s;
            text-align: center;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
            text-decoration: none;
        }

        .action-card .action-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 30px;
        }

        .action-card h4 {
            margin: 0 0 12px 0;
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }

        .action-card p {
            margin: 0;
            font-size: 0.9rem;
            color: #6c757d;
            line-height: 1.5;
        }

        /* Additional color classes for new cards */
        .bg-purple {
            background: linear-gradient(135deg, #6f42c1, #8b5ac8) !important;
        }

        .bg-cyan {
            background: linear-gradient(135deg, #20c997, #3dd5a3) !important;
        }

        .bg-orange {
            background: linear-gradient(135deg, #fd7e14, #fd9a47) !important;
        }

        /* Content header adjustments */
        .content-header {
            margin-bottom: 30px;
        }

        .main-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .main-subtitle {
            font-size: 1rem;
            color: #666;
            margin-bottom: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 15px;
            }

            .dashboard-stats {
                grid-template-columns: 1fr;
            }
            
            .action-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .stat-header {
                padding: 15px;
            }

            .stat-details {
                padding: 10px 15px 15px;
            }

            .activity-header {
                padding: 15px;
            }

            .activity-item {
                padding: 12px 15px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-container {
                padding: 10px;
            }

            .action-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .action-card {
                min-height: 160px;
                padding: 25px 20px;
            }

            .action-card .action-icon {
                width: 60px;
                height: 60px;
                font-size: 26px;
                margin-bottom: 15px;
            }

            .action-card h4 {
                font-size: 1.1rem;
            }

            .action-card p {
                font-size: 0.85rem;
            }

            .stat-details {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>

    <script>
        // Mark that user has visited an admin page
        sessionStorage.setItem('admin_page_visited', 'true');
        
        // Initialize Feather icons after page load - only if not already done by sidebar
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined' && !window.featherInitialized) {
                feather.replace();
                window.featherInitialized = true;
            }
        });

        // Real-time clock update
        function updateTime() {
            const now = new Date();
            const timeString = now.toTimeString().split(' ')[0]; // Get HH:MM:SS format
            const timeElement = document.getElementById('currentTime');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        // Update time every second
        setInterval(updateTime, 1000);

        // Update last login periodically (every 5 minutes)
        function updateLastLogin() {
            fetch('<?= base_url('admin/dashboard/getLastLogin') ?>')
                .then(response => response.json())
                .then(data => {
                    if (data.last_login) {
                        const lastLoginElement = document.getElementById('lastLogin');
                        if (lastLoginElement) {
                            const loginDate = new Date(data.last_login);
                            const formattedDate = loginDate.toLocaleDateString('en-US', {
                                month: 'short',
                                day: 'numeric'
                            }) + ', ' + loginDate.toLocaleTimeString('en-US', {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false
                            });
                            lastLoginElement.textContent = formattedDate;
                        }
                    }
                })
                .catch(error => console.log('Error updating last login:', error));
        }

        // Update last login every 5 seconds
        setInterval(updateLastLogin, 5000);

        // Update immediately when page loads
        updateTime();

        // Charts
        const userCtx = document.getElementById('userChart').getContext('2d');
        new Chart(userCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode($chartData['labels']) ?>,
                datasets: [{
                    label: 'Total Users',
                    data: <?= json_encode($chartData['users']) ?>,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const registrationCtx = document.getElementById('registrationChart').getContext('2d');
        new Chart(registrationCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode($chartData['labels']) ?>,
                datasets: [{
                    label: 'Total Registrations',
                    data: <?= json_encode($chartData['registrations']) ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>