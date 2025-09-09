<?php
/**
 * Unified Admin View (Single File)
 * - Consolidates layout, sidebar, and page rendering in one file
 * - Access via routes: /admin/ui or /admin/ui/{page}
 * - Allowed pages: dashboard, tentang, fitur, installer, patch, aplikasi, panduan, dukungan, bimbingan, users, profile, replication
 */

// Resolve requested page
$requestedPage = $page ?? 'dashboard';
$allowedPages = [
    'dashboard','tentang','fitur','installer','patch','aplikasi','panduan','dukungan','bimbingan','users','profile','replication'
];
if (!in_array($requestedPage, $allowedPages, true)) {
    $requestedPage = 'dashboard';
}

// Basic helpers
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

// Page title map (fallback to ucfirst of slug)
$pageTitles = [
    'dashboard' => 'Dashboard - INLISLite v3',
    'tentang' => 'Tentang - INLISLite v3',
    'fitur' => 'Fitur & Modul - INLISLite v3',
    'installer' => 'Installer - INLISLite v3',
    'patch' => 'Patch & Updater - INLISLite v3',
    'aplikasi' => 'Aplikasi Pendukung - INLISLite v3',
    'panduan' => 'Panduan - INLISLite v3',
    'dukungan' => 'Dukungan - INLISLite v3',
    'bimbingan' => 'Bimbingan Teknis - INLISLite v3',
    'users' => 'Manajemen Pengguna - INLISLite v3',
    'profile' => 'Profil Pengguna - INLISLite v3',
    'replication' => 'Replikasi Database - INLISLite v3',
];
$finalTitle = $title ?? ($pageTitles[$requestedPage] ?? (ucfirst($requestedPage) . ' - INLISLite v3'));

// --- Small renderers per page (keep minimal; extend as needed) ---
function renderDashboard(): void {
    ?>
    <div class="header-card">
        <div class="content-header">
            <h1 class="main-title">Dashboard</h1>
            <p class="main-subtitle">Selamat datang di INLISLite v3</p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-2">Quick Links</h5>
                    <ul class="mb-0">
                        <li><a href="<?= base_url('admin/ui/users') ?>">Manajemen Pengguna</a></li>
                        <li><a href="<?= base_url('admin/ui/profile') ?>">Profil</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="alert alert-info mb-0"><i class="bi bi-info-circle me-2"></i>Halaman dashboard sederhana (bisa dikembangkan).</div>
        </div>
    </div>
    <?php
}

function renderSimpleInfo(string $title, string $desc): void {
    ?>
    <div class="header-card">
        <div class="content-header">
            <h1 class="main-title"><?= e($title) ?></h1>
            <p class="main-subtitle"><?= e($desc) ?></p>
        </div>
    </div>
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            Halaman ini telah dimigrasikan ke tampilan tunggal. Silakan sesuaikan kontennya bila diperlukan.
        </div>
    </div>
    <?php
}

function renderProfileMinimal(array $user = []): void {
    $name = $user['nama_lengkap'] ?? $user['nama'] ?? 'Administrator';
    $username = $user['nama_pengguna'] ?? $user['username'] ?? 'admin';
    $email = $user['email'] ?? 'admin@inlislite.com';
    $status = $user['status'] ?? 'Aktif';
    ?>
    <div class="header-card">
        <div class="content-header">
            <h1 class="main-title">User Profile</h1>
            <p class="main-subtitle">Ringkasan akun Anda</p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:64px;height:64px;font-weight:600;">
                            <?= e(strtoupper(substr($name,0,1))) ?>
                        </div>
                        <div class="ms-3">
                            <div class="fw-semibold mb-1"><?= e($name) ?></div>
                            <div class="text-muted">@<?= e($username) ?></div>
                        </div>
                    </div>
                    <div class="small text-muted mb-2"><i class="bi bi-envelope me-2"></i><?= e($email) ?></div>
                    <span class="badge <?= $status === 'Aktif' ? 'bg-success' : 'bg-secondary' ?>"><?= e($status) ?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Edit (Demo)</h5>
                    <p class="mb-0 text-muted">Form profil lengkap dapat dipindahkan ke sini bila diperlukan.</p>
                </div>
            </div>
        </div>
    </div>
    <?php
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($finalTitle) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/admin/admin-sidebar.css') ?>" rel="stylesheet">
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Liberation Sans', sans-serif; }
        .enhanced-main-content { margin-left: 260px; transition: margin-left .2s ease; }
        .sidebar { position: fixed; top:0; left:0; bottom:0; width: 260px; background:#0d6efd; color:#fff; overflow-y:auto; }
        .sidebar a { color:#fff; text-decoration:none; }
        .sidebar .brand { padding:1rem 1.25rem; font-weight:700; border-bottom:1px solid rgb(255, 255, 255); }
        .sidebar .nav-link { display:flex; gap:.75rem; align-items:center; padding:.65rem 1.25rem; border-radius:.5rem; margin:.25rem .5rem; } 
        .header-card { background: #ffffff; color:#111827; border-radius: .75rem; padding: 1.25rem 1.25rem; border:1px solid #e5e7eb; }
        .main-title { margin: 0; font-weight:700; }
        .main-subtitle { margin: .25rem 0 0; opacity: 1; }
        @media (max-width: 992px){ .enhanced-main-content { margin-left: 0; } .sidebar{ position: static; width:100%; } }
    </style>
</head>
<body>
    <!-- Minimal Inline Sidebar -->
    <nav class="sidebar">
        <div class="brand">INLISLite Admin</div>
        <div class="py-2">
            <?php $base = base_url('admin/ui'); ?>
            <a class="nav-link <?= $requestedPage==='dashboard'?'active':'' ?>" href="<?= $base.'/dashboard' ?>"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a>
            <a class="nav-link <?= $requestedPage==='tentang'?'active':'' ?>" href="<?= $base.'/tentang' ?>"><i class="bi bi-info-circle"></i><span>Tentang</span></a>
            <a class="nav-link <?= $requestedPage==='fitur'?'active':'' ?>" href="<?= $base.'/fitur' ?>"><i class="bi bi-grid"></i><span>Fitur</span></a>
            <a class="nav-link <?= $requestedPage==='installer'?'active':'' ?>" href="<?= $base.'/installer' ?>"><i class="bi bi-download"></i><span>Installer</span></a>
            <a class="nav-link <?= $requestedPage==='patch'?'active':'' ?>" href="<?= $base.'/patch' ?>"><i class="bi bi-arrow-repeat"></i><span>Patch</span></a>
            <a class="nav-link <?= $requestedPage==='aplikasi'?'active':'' ?>" href="<?= $base.'/aplikasi' ?>"><i class="bi bi-app-indicator"></i><span>Aplikasi</span></a>
            <a class="nav-link <?= $requestedPage==='panduan'?'active':'' ?>" href="<?= $base.'/panduan' ?>"><i class="bi bi-journal-text"></i><span>Panduan</span></a>
            <a class="nav-link <?= $requestedPage==='dukungan'?'active':'' ?>" href="<?= $base.'/dukungan' ?>"><i class="bi bi-life-preserver"></i><span>Dukungan</span></a>
            <a class="nav-link <?= $requestedPage==='bimbingan'?'active':'' ?>" href="<?= $base.'/bimbingan' ?>"><i class="bi bi-mortarboard"></i><span>Bimbingan</span></a>
            <a class="nav-link <?= $requestedPage==='users'?'active':'' ?>" href="<?= $base.'/users' ?>"><i class="bi bi-people"></i><span>Users</span></a>
            <a class="nav-link <?= $requestedPage==='profile'?'active':'' ?>" href="<?= $base.'/profile' ?>"><i class="bi bi-person-circle"></i><span>Profile</span></a>
            <a class="nav-link <?= $requestedPage==='replication'?'active':'' ?>" href="<?= $base.'/replication' ?>"><i class="bi bi-diagram-3"></i><span>Replication</span></a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="enhanced-main-content">
        <div class="container-fluid p-4">
            <?php
            switch ($requestedPage) {
                case 'dashboard':
                    renderDashboard();
                    break;
                case 'profile':
                    renderProfileMinimal($user ?? []);
                    break;
                case 'tentang':
                    renderSimpleInfo('Tentang', 'Informasi mengenai INLISLite');
                    break;
                case 'fitur':
                    renderSimpleInfo('Fitur & Modul', 'Daftar fitur dan modul');
                    break;
                case 'installer':
                    renderSimpleInfo('Installer', 'Kelola paket installer');
                    break;
                case 'patch':
                    renderSimpleInfo('Patch & Updater', 'Kelola patch/update');
                    break;
                case 'aplikasi':
                    renderSimpleInfo('Aplikasi Pendukung', 'Aplikasi tambahan');
                    break;
                case 'panduan':
                    renderSimpleInfo('Panduan', 'Dokumentasi & panduan penggunaan');
                    break;
                case 'dukungan':
                    renderSimpleInfo('Dukungan', 'Dukungan teknis');
                    break;
                case 'bimbingan':
                    renderSimpleInfo('Bimbingan Teknis', 'Materi bimbingan');
                    break;
                case 'users':
                    renderSimpleInfo('Manajemen Pengguna', 'Kelola pengguna sistem');
                    break;
                case 'replication':
                    renderSimpleInfo('Replikasi Database', 'Pengaturan replikasi');
                    break;
                default:
                    renderDashboard();
            }
            ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
