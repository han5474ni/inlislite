<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'View Registration - INLISlite v3.0' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Dashboard CSS -->
    <link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
    <!-- Registration CSS -->
    <link href="<?= base_url('assets/css/admin/registration.css') ?>" rel="stylesheet">
    <!-- Registration View CSS -->
    <link href="<?= base_url('assets/css/admin/registration_view.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i data-feather="menu"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <i data-feather="star"></i>
                </div>
                <div class="sidebar-title">
                    INLISlite v3.0<br>
                    <small style="font-size: 0.85rem; opacity: 0.8;">Dashboard</small>
                </div>
            </a>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i data-feather="chevrons-left"></i>
            </button>
        </div>
        
        <div class="sidebar-nav">
            <div class="nav-item">
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
                    <i data-feather="home" class="nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="nav-tooltip">Dashboard</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/users') ?>" class="nav-link">
                    <i data-feather="users" class="nav-icon"></i>
                    <span class="nav-text">Manajemen User</span>
                </a>
                <div class="nav-tooltip">Manajemen User</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/registration') ?>" class="nav-link active">
                    <i data-feather="book" class="nav-icon"></i>
                    <span class="nav-text">Registrasi</span>
                </a>
                <div class="nav-tooltip">Registrasi</div>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('admin/profile') ?>" class="nav-link">
                    <i data-feather="user" class="nav-icon"></i>
                    <span class="nav-text">Profile</span>
                </a>
                <div class="nav-tooltip">Profile</div>
            </div>
            
            <!-- Logout Button -->
            <div class="nav-item logout-item">
                <a href="<?= base_url('admin/secure-logout') ?>" class="nav-link logout-link" onclick="return confirmLogout()">
                    <i data-feather="log-out" class="nav-icon"></i>
                    <span class="nav-text">Logout</span>
                </a>
                <div class="nav-tooltip">Logout</div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-container" data-registration-id="<?= $registration['id'] ?? '' ?>">
            <!-- Page Header -->
            <div class="page-header">
                <div class="header-top">
                    <div class="header-left">
                        <div class="header-icon">
                            <i class="bi bi-eye"></i>
                        </div>
                        <div>
                            <h1 class="page-title"><?= $page_title ?? 'Registration Details' ?></h1>
                            <p class="page-subtitle"><?= $page_subtitle ?? 'View library registration information' ?></p>
                        </div>
                    </div>
                    <div class="header-right">
                        <a href="<?= base_url('admin/registration/edit/' . ($registration['id'] ?? '')) ?>" class="btn btn-primary me-2">
                            <i class="bi bi-pencil me-2"></i>
                            Edit
                        </a>
                        <a href="<?= base_url('admin/registration') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Registration Details -->
            <div class="registration-view-section">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Basic Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-building me-2"></i>
                                    Basic Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Library Name</label>
                                        <p class="field-value"><?= esc($registration['library_name'] ?? 'N/A') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Library Code</label>
                                        <p class="field-value"><?= esc($registration['library_code'] ?? 'N/A') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Library Type</label>
                                        <p class="field-value">
                                            <?php if (isset($registration['library_type'])): ?>
                                                <span class="badge badge-type <?= strtolower($registration['library_type']) ?>"><?= esc($registration['library_type']) ?></span>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Status</label>
                                        <p class="field-value">
                                            <?php if (isset($registration['status'])): ?>
                                                <span class="badge badge-status <?= strtolower($registration['status']) ?>"><?= esc($registration['status']) ?></span>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    Location Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Province</label>
                                        <p class="field-value"><?= esc($registration['province'] ?? 'N/A') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">City</label>
                                        <p class="field-value"><?= esc($registration['city'] ?? 'N/A') ?></p>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-muted">Address</label>
                                        <p class="field-value"><?= esc($registration['address'] ?? 'N/A') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Postal Code</label>
                                        <p class="field-value"><?= esc($registration['postal_code'] ?? 'N/A') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Coordinates</label>
                                        <p class="field-value"><?= esc($registration['coordinates'] ?? 'N/A') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-person-lines-fill me-2"></i>
                                    Contact Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Contact Person</label>
                                        <p class="field-value"><?= esc($registration['contact_name'] ?? 'N/A') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Position</label>
                                        <p class="field-value"><?= esc($registration['contact_position'] ?? 'N/A') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Email</label>
                                        <p class="field-value">
                                            <?php if (!empty($registration['email'])): ?>
                                                <a href="mailto:<?= esc($registration['email']) ?>"><?= esc($registration['email']) ?></a>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Phone</label>
                                        <p class="field-value">
                                            <?php if (!empty($registration['phone'])): ?>
                                                <a href="tel:<?= esc($registration['phone']) ?>"><?= esc($registration['phone']) ?></a>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Website</label>
                                        <p class="field-value">
                                            <?php if (!empty($registration['website'])): ?>
                                                <a href="<?= esc($registration['website']) ?>" target="_blank"><?= esc($registration['website']) ?></a>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Fax</label>
                                        <p class="field-value"><?= esc($registration['fax'] ?? 'N/A') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Additional Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-muted">Established Year</label>
                                        <p class="field-value"><?= esc($registration['established_year'] ?? 'N/A') ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-muted">Collection Count</label>
                                        <p class="field-value"><?= isset($registration['collection_count']) ? number_format($registration['collection_count']) : 'N/A' ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-muted">Member Count</label>
                                        <p class="field-value"><?= isset($registration['member_count']) ? number_format($registration['member_count']) : 'N/A' ?></p>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-muted">Notes</label>
                                        <p class="field-value"><?= esc($registration['notes'] ?? 'N/A') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Registration Summary -->
                        <div class="card mb-4 registration-summary">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-calendar-check me-2"></i>
                                    Registration Summary
                                </h5>
                            </div>
                            <div class="card-body">
                                <div>
                                    <label class="form-label fw-semibold text-muted">Registration ID</label>
                                    <p class="field-value">#<?= esc($registration['id'] ?? 'N/A') ?></p>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-muted">Registration Date</label>
                                    <p class="field-value">
                                        <?php if (isset($registration['created_at'])): ?>
                                            <?= date('d M Y, H:i', strtotime($registration['created_at'])) ?>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-muted">Last Updated</label>
                                    <p class="field-value">
                                        <?php if (isset($registration['updated_at'])): ?>
                                            <?= date('d M Y, H:i', strtotime($registration['updated_at'])) ?>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <?php if (isset($registration['verified_at']) && !empty($registration['verified_at'])): ?>
                                <div>
                                    <label class="form-label fw-semibold text-muted">Verified Date</label>
                                    <p class="field-value"><?= date('d M Y, H:i', strtotime($registration['verified_at'])) ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="card quick-actions">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-lightning me-2"></i>
                                    Quick Actions
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('admin/registration/edit/' . ($registration['id'] ?? '')) ?>" class="btn btn-primary">
                                        <i class="bi bi-pencil me-2"></i>
                                        Edit Registration
                                    </a>
                                    <button class="btn btn-outline-success" onclick="changeStatus('verified')">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Mark as Verified
                                    </button>
                                    <button class="btn btn-outline-warning" onclick="changeStatus('pending')">
                                        <i class="bi bi-clock me-2"></i>
                                        Mark as Pending
                                    </button>
                                    <button class="btn btn-outline-secondary" onclick="exportRegistrationData('json')">
                                        <i class="bi bi-download me-2"></i>
                                        Export Data
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="deleteRegistration()">
                                        <i class="bi bi-trash me-2"></i>
                                        Delete Registration
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- Registration JS -->
    <script src="<?= base_url('assets/js/admin/registration.js') ?>"></script>
    <!-- Registration View JS -->
    <script src="<?= base_url('assets/js/admin/registration_view.js') ?>"></script>
</body>
</html>