<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Admin Panel' ?> - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- DataTables CSS (if needed) -->
    <?php if (isset($use_datatables) && $use_datatables): ?>
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <?php endif; ?>
    
    <!-- Dashboard CSS for sidebar -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    
    <!-- Page specific CSS -->
    <?php if (isset($page_css)): ?>
        <?php foreach ($page_css as $css): ?>
            <link href="<?= base_url($css) ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Enhanced Sidebar CSS -->
    <link href="<?= base_url('assets/css/enhanced-sidebar.css') ?>" rel="stylesheet">
    
    <!-- Additional head content -->
    <?= $this->renderSection('head') ?>
</head>
<body>
    <!-- Include Enhanced Sidebar -->
    <?= view('admin/partials/sidebar') ?>

    <!-- Main Content -->
    <main class="enhanced-main-content">
        <!-- Page Header -->
        <?php if (isset($show_header) && $show_header): ?>
        <header class="page-header">
            <div class="container">
                <div class="header-content">
                    <div class="d-flex align-items-center mb-3">
                        <button class="btn-back me-3" onclick="history.back()">
                            <i class="bi bi-arrow-left"></i>
                        </button>
                        <div>
                            <h1 class="header-title mb-1"><?= $header_title ?? $page_title ?></h1>
                            <p class="header-subtitle mb-0"><?= $header_subtitle ?? '' ?></p>
                        </div>
                        <?php if (isset($header_action)): ?>
                        <div class="ms-auto">
                            <?= $header_action ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>
        <?php endif; ?>

        <!-- Page Content -->
        <div class="page-content">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (if needed) -->
    <?php if (isset($use_jquery) && $use_jquery): ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <?php endif; ?>
    <!-- DataTables JS (if needed) -->
    <?php if (isset($use_datatables) && $use_datatables): ?>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <?php endif; ?>
    <!-- Dashboard JS for sidebar functionality -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    
    <!-- Page specific JS -->
    <?php if (isset($page_js)): ?>
        <?php foreach ($page_js as $js): ?>
            <script src="<?= base_url($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Enhanced Sidebar JavaScript -->
    <script src="<?= base_url('assets/js/enhanced-sidebar.js') ?>"></script>
    
    <!-- Initialize Feather icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
    
    <!-- Additional scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>