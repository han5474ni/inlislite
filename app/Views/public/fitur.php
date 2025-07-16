<?= $this->include('public/layout/header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="page-header text-center py-5 mb-5">
                <div class="container">
                    <h1 class="display-4 fw-bold text-white mb-3">Fitur & Modul INLISLite v3</h1>
                    <p class="lead text-white-50">Sistem otomasi perpustakaan yang komprehensif dengan fitur-fitur canggih</p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="container mb-5">
                <!-- Features Section -->
                <section class="mb-5">
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <h2 class="section-title">Fitur Utama</h2>
                            <p class="section-subtitle text-muted">Fitur-fitur unggulan untuk pengelolaan perpustakaan modern</p>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <?php if (!empty($features)): ?>
                            <?php foreach ($features as $feature): ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="feature-card h-100">
                                        <div class="feature-icon <?= $feature['color'] ?? 'blue' ?>">
                                            <i class="<?= $feature['icon'] ?? 'bi-star' ?>"></i>
                                        </div>
                                        <div class="feature-content">
                                            <h3 class="feature-title"><?= esc($feature['title']) ?></h3>
                                            <p class="feature-description"><?= esc($feature['description']) ?></p>
                                        </div>
                                        <div class="feature-badge">Fitur</div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <div class="empty-state">
                                    <i class="bi bi-star display-1 text-muted"></i>
                                    <h3 class="mt-3">Belum ada fitur tersedia</h3>
                                    <p class="text-muted">Fitur-fitur akan ditampilkan di sini</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Modules Section -->
                <section class="mb-5">
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <h2 class="section-title">Modul Program</h2>
                            <p class="section-subtitle text-muted">Arsitektur modular untuk fleksibilitas dan skalabilitas</p>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <?php if (!empty($modules)): ?>
                            <?php foreach ($modules as $module): ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="module-card h-100">
                                        <div class="module-icon <?= $module['color'] ?? 'green' ?>">
                                            <i class="<?= $module['icon'] ?? 'bi-puzzle' ?>"></i>
                                        </div>
                                        <div class="module-content">
                                            <h3 class="module-title"><?= esc($module['title']) ?></h3>
                                            <p class="module-description"><?= esc($module['description']) ?></p>
                                            <?php if (isset($module['module_type'])): ?>
                                                <span class="module-type-badge <?= $module['module_type'] ?>">
                                                    <?= ucfirst($module['module_type']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="module-badge">Modul</div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <div class="empty-state">
                                    <i class="bi bi-puzzle display-1 text-muted"></i>
                                    <h3 class="mt-3">Belum ada modul tersedia</h3>
                                    <p class="text-muted">Modul-modul akan ditampilkan di sini</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- CTA Section -->
                <section class="text-center py-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <h2 class="mb-3">Siap Menggunakan INLISLite v3?</h2>
                            <p class="lead text-muted mb-4">Dapatkan sistem perpustakaan terlengkap dengan fitur-fitur modern</p>
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="<?= base_url('demo') ?>" class="btn btn-primary btn-lg">
                                    <i class="bi bi-play-circle me-2"></i>Coba Demo
                                </a>
                                <a href="<?= base_url('panduan') ?>" class="btn btn-outline-primary btn-lg">
                                    <i class="bi bi-book me-2"></i>Baca Panduan
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    background: linear-gradient(135deg, #1C6EC4 0%, #2DA84D 100%);
    margin-top: 76px;
}

.section-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.feature-card, .module-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.feature-card:hover, .module-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.feature-icon, .module-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.feature-icon i, .module-icon i {
    font-size: 1.5rem;
    color: white;
}

.feature-icon.blue, .module-icon.blue { background: linear-gradient(135deg, #4A90E2, #357ABD); }
.feature-icon.green, .module-icon.green { background: linear-gradient(135deg, #7ED321, #5BA515); }
.feature-icon.orange, .module-icon.orange { background: linear-gradient(135deg, #F5A623, #D4941E); }
.feature-icon.purple, .module-icon.purple { background: linear-gradient(135deg, #9013FE, #7C4DFF); }

.feature-title, .module-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.feature-description, .module-description {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.feature-badge, .module-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #e9ecef;
    color: #6c757d;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.module-badge {
    background: #e8f5e8;
    color: #5ba515;
}

.module-type-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    margin-top: 0.5rem;
}

.module-type-badge.application {
    background: #e3f2fd;
    color: #1976d2;
}

.module-type-badge.database {
    background: #f3e5f5;
    color: #7b1fa2;
}

.module-type-badge.utility {
    background: #fff3e0;
    color: #f57c00;
}

.empty-state {
    padding: 3rem;
    text-align: center;
}

.btn-lg {
    padding: 12px 30px;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .page-header {
        margin-top: 56px;
        padding: 3rem 0;
    }
    
    .feature-card, .module-card {
        padding: 1.5rem;
    }
    
    .d-flex.gap-3 {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-lg {
        width: 100%;
        max-width: 250px;
    }
}
</style>

<?= $this->include('public/layout/footer') ?>
