<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitur dan Modul Program - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/fitur.css') ?>" rel="stylesheet">
    
    <style>
    body {
        background: linear-gradient(135deg, #1C6EC4 0%, #2DA84D 100%);
        min-height: 100vh;
    }
    
    /* Custom styles for modern cards */
    .modern-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        max-width: 100%;
    }
    
    .modern-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .card-icon-wrapper {
        position: relative;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-radius: 50%;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }
    
    .card-icon-wrapper.green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }
    
    .card-icon-wrapper.purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
    }
    
    .card-icon-wrapper.orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    }
    
    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 4px 12px;
        background: rgba(34, 197, 94, 0.1);
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        color: #059669;
    }
    
    .card-action-button {
        transition: all 0.2s ease;
    }
    
    .card-action-button:hover {
        transform: scale(1.05);
        background: rgba(0, 0, 0, 0.05);
    }
    
    /* Animation for cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-card {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .animate-card:nth-child(2) {
        animation-delay: 0.1s;
    }
    
    .animate-card:nth-child(3) {
        animation-delay: 0.2s;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modern-card {
            margin-bottom: 24px;
        }
        
        .card-icon-wrapper {
            width: 40px;
            height: 40px;
        }
    }
    </style>
</head>
<body>
    <!-- Include Enhanced Sidebar -->
    <?= $this->include('admin/partials/sidebar') ?>
    
    <!-- Main Content -->
    <main class="enhanced-main-content">
        <div class="dashboard-container">
            <div class="header-card">
                <div class="content-header">
                    <h1 class="main-title">Fitur dan Modul Program</h1>
                    <p class="main-subtitle">Kelola fitur dan modul sistem perpustakaan</p>
                </div>
            </div>
            
            <div class="container mx-auto px-4 py-6">
                <!-- Header Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <i class="bi bi-puzzle text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">Fitur & Modul INLISLite v3.0</h1>
                                <p class="text-gray-600">Sistem modular untuk perpustakaan modern</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="<?= base_url('admin/fitur-edit') ?>" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors flex items-center space-x-2">
                                <i class="bi bi-gear"></i>
                                <span>Kelola</span>
                            </a>
                            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors flex items-center space-x-2" onclick="refreshContent()">
                                <i class="bi bi-arrow-clockwise"></i>
                                <span>Refresh</span>
                            </button>
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700 leading-relaxed">
                            Kelola fitur-fitur canggih dan modul program yang menjadikan INLISLite v3 sebagai solusi perpustakaan yang komprehensif dan dapat disesuaikan.
                        </p>
                    </div>
                </div>

                <!-- Search Section -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Fitur Sistem</h2>
                    <div class="flex items-center space-x-2">
                        <div class="search-box relative">
                            <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" class="form-control pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="searchInput" placeholder="Cari fitur...">
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="featuresContainer">
                    <!-- Features will be loaded here -->
                </div>

                <!-- Modules Section -->
                <div class="flex items-center justify-between mb-6 mt-8">
                    <h2 class="text-xl font-bold text-gray-800">Modul Program</h2>
                    <div class="flex items-center space-x-2">
                        <div class="badge bg-success-subtle text-success px-3 py-2">
                            <i class="bi bi-puzzle-fill me-1"></i>Modul Sistem
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="modulesContainer">
                    <!-- Modules will be loaded here -->
                </div>
            </div>
        </div>
    </main>

    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        window.baseUrl = "<?= base_url() ?>";
    </script>
    <script src="<?= base_url('assets/js/admin/fitur-new.js') ?>"></script>
</body>
</html>
