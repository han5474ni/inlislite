<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<!-- Dashboard page CSS and vendor scripts -->
<link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Admin Dashboard',
    'subtitle' => 'Kelola sistem perpustakaan Anda dengan data real-time',
    'icon' => 'speedometer2',
    'backUrl' => base_url('admin'),
    'bg' => 'green',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (isset($database_error) && $database_error): ?>
<div class="alert alert-info">
    <i class="bi bi-info-circle me-2"></i>
    <strong>Info:</strong> Beberapa fitur mungkin terbatas karena database belum sepenuhnya dikonfigurasi. 
    <a href="<?= base_url('run_migrations.php') ?>" class="alert-link">Jalankan migrasi database</a> untuk mengaktifkan semua fitur.
</div>
<?php endif; ?>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="bi bi-people"></i></div>
        <div class="stat-number"><?= $userStats['total'] ?? 0 ?></div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-person-check"></i></div>
        <div class="stat-number"><?= $userStats['active'] ?? 0 ?></div>
        <div class="stat-label">Active Users</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="bi bi-shield-check"></i></div>
        <div class="stat-number"><?= $userStats['admin'] ?? 0 ?></div>
        <div class="stat-label">Admin Users</div>
    </div>
</div>

<!-- Content Grid -->
<div class="content-grid">
    <!-- Chart Card -->
    <div class="chart-card">
        <h3 class="card-title"><i class="bi bi-bar-chart"></i> Activity Overview</h3>
        <canvas id="activityChart" width="400" height="120"></canvas>
    </div>

    <!-- Current User Card -->
    <div class="activity-card">
        <h3 class="card-title"><i class="bi bi-person-circle"></i> Current User</h3>
        <div class="text-center">
            <div class="user-avatar"><?= strtoupper(substr($currentUser['name'] ?? 'A', 0, 2)) ?></div>
            <div class="user-info">
                <div class="user-name"><?= $currentUser['name'] ?? 'Administrator' ?></div>
                <div class="user-role"><?= $currentUser['role'] ?? 'Super Admin' ?></div>
            </div>
            <div class="user-details">
                <div class="user-detail"><i class="bi bi-envelope"></i><span><?= $currentUser['email'] ?? 'admin@inlislite.com' ?></span></div>
                <div class="user-detail"><i class="bi bi-clock"></i><span>Login: <?= $currentUser['login_time'] ?? 'Just now' ?></span></div>
            </div>
            <div class="user-actions">
                <a href="<?= base_url('admin/profile') ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-person-gear me-1"></i>Manage Profile
                </a>
            </div>
        </div>
    </div>
</div>



<!-- Quick Access on gradient background -->
<section class="quick-actions">
  <div class="quick-actions-head">
    <h3 class="quick-actions-title"><i class="bi bi-grid-3x3-gap"></i><span>Quick Access</span></h3>
  </div>
  <div class="action-grid">
    <a href="<?= base_url('admin/tentang') ?>" class="action-card">
      <span class="action-badge">Baru</span>
      <div class="action-icon bg-primary"><i class="bi bi-book"></i></div>
      <div class="action-content">
        <h4>Tentang Inlislite</h4>
        <p>Pelajari fitur terbaru dan peningkatan yang ada di versi 3.</p>
        <small class="action-meta">Versi Terbaru</small>
      </div>
    </a>

    <a href="<?= base_url('admin/fitur') ?>" class="action-card">
      <div class="action-icon bg-success"><i class="bi bi-ui-checks-grid"></i></div>
      <div class="action-content">
        <h4>Features & Program Modules</h4>
        <p>Kelola fitur dan pengaturan sistem.</p>
        <small class="action-meta">15 Modul</small>
      </div>
    </a>

    <a href="<?= base_url('admin/installer') ?>" class="action-card">
      <div class="action-icon bg-info"><i class="bi bi-download"></i></div>
      <div class="action-content">
        <h4>Installer</h4>
        <p>Instruksi instalasi langkah demi langkah.</p>
        <small class="action-meta">Setup</small>
      </div>
    </a>

    <a href="<?= base_url('admin/patch') ?>" class="action-card">
      <div class="action-icon bg-warning"><i class="bi bi-cloud-arrow-up"></i></div>
      <div class="action-content">
        <h4>Patch dan Updater</h4>
        <p>Jaga sistem Anda tetap terbaru dengan patch terbaru.</p>
        <small class="action-meta">Auto Update</small>
      </div>
    </a>

    <a href="<?= base_url('admin/aplikasi') ?>" class="action-card">
      <div class="action-icon bg-purple"><i class="bi bi-app-indicator"></i></div>
      <div class="action-content">
        <h4>Aplikasi Pendukung</h4>
        <p>Dapatkan bantuan dan dukungan untuk aplikasi Anda.</p>
        <small class="action-meta">Dukungan 24/7</small>
      </div>
    </a>

    <a href="<?= base_url('admin/panduan') ?>" class="action-card">
      <div class="action-icon bg-success"><i class="bi bi-question-circle"></i></div>
      <div class="action-content">
        <h4>Panduan</h4>
        <p>Panduan lengkap untuk menggunakan sistem.</p>
        <small class="action-meta">Panduan Lengkap</small>
      </div>
    </a>

    <a href="<?= base_url('admin/dukungan') ?>" class="action-card">
      <div class="action-icon bg-primary"><i class="bi bi-headset"></i></div>
      <div class="action-content">
        <h4>Dukungan Teknis</h4>
        <p>Bantuan teknis dan pemecahan masalah.</p>
        <small class="action-meta">Pertolongan ahli</small>
      </div>
    </a>

    <a href="<?= base_url('admin/bimbingan') ?>" class="action-card">
      <div class="action-icon bg-success"><i class="bi bi-lightning-charge"></i></div>
      <div class="action-content">
        <h4>Bimbingan Teknis</h4>
        <p>Sumber daya untuk pengembangan dan tim teknis.</p>
        <small class="action-meta">Alat Pengembang</small>
      </div>
    </a>

    <a href="<?= base_url('admin/demo') ?>" class="action-card">
      <div class="action-icon bg-primary"><i class="bi bi-bar-chart"></i></div>
      <div class="action-content">
        <h4>Demo Program</h4>
        <p>Coba sistem dengan data contoh.</p>
        <small class="action-meta">Demo Interaktif</small>
      </div>
    </a>
  </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
<script>
// Initialize Chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('activityChart').getContext('2d');
    const chartData = <?= json_encode($chartData ?? ['labels' => [], 'users' => [], 'activities' => []]) ?>;
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels || ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Users',
                data: chartData.users || [0, 0, 0, 0, 0, 0, 1],
                borderColor: '#004AAD',
                backgroundColor: '#E6F0FF', // solid fill (no transparency)
                tension: 0.4,
                fill: true
            }, {
                label: 'Activities',
                data: chartData.activities || [0, 0, 0, 0, 0, 0, 1],
                borderColor: '#65C371',
                backgroundColor: '#E9F7EE', // solid fill (no transparency)
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgb(0, 0, 0)' } },
                x: { grid: { color: 'rgb(0, 0, 0)' } }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>

