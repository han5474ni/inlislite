<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Supporting Applications - INLISlite v3.0' ?></title>
    
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
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/aplikasi.css') ?>" rel="stylesheet">
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
                <a href="<?= base_url('registration') ?>" class="nav-link">
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
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-container">
            <!-- Page Header -->
            <div class="page-header">
                <div class="header-top">
                    <div class="header-left">
                        <div class="header-icon">
                            <i class="bi bi-tools"></i>
                        </div>
                        <div>
                            <h1 class="page-title">Supporting Applications</h1>
                            <p class="page-subtitle">Download and install supporting tools and modules</p>
                        </div>
                    </div>
                    <a href="<?= base_url('admin/dashboard') ?>" class="back-btn">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            <div id="alertContainer"></div>

    <!-- Applications Content -->
            <div class="applications-content" id="applicationsContent">
            <!-- OAI-PMH Service -->
                <div class="application-card card" data-app-id="1">
                    <div class="card-header d-flex justify-content-between align-items-start">
                        <div class="card-title-section">
                            <div class="d-flex align-items-center mb-2">
                                <div class="app-icon-circle bg-primary">
                                    <i class="bi bi-network-widescreen"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="card-title mb-1">OAI-PMH Service</h3>
                                    <p class="card-subtitle text-muted mb-0">Open Archives Initiative Protocol for Metadata Harvesting</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item edit-app" href="#" data-id="1"><i class="bi bi-pencil me-2"></i>Edit Application</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item delete-app text-danger" href="#" data-id="1"><i class="bi bi-trash me-2"></i>Delete Application</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <p class="mb-4">Lightweight service module for data communication through harvesting protocol. Enables INLISLite users to share library data online to central catalog platforms like Indonesia OneSearch and National Union Catalog.</p>
                            
                            <div class="technical-details mb-4">
                                <h6 class="section-title">
                                    <i class="bi bi-gear me-2"></i>Technical Details
                                </h6>
                                <ul class="detail-list">
                                    <li>Based on MARCXML format</li>
                                    <li>Integrated directly within INLISLite version 3</li>
                                    <li>Compatible with Indonesia OneSearch</li>
                                    <li>Supports National Union Catalog integration</li>
                                </ul>
                            </div>

                            <div class="requirements-section mb-4">
                                <h6 class="section-title">
                                    <i class="bi bi-check-circle me-2"></i>Requirements
                                </h6>
                                <ul class="requirements-list">
                                    <li>INLISLite v3.0 or higher</li>
                                    <li>Web server with PHP support</li>
                                    <li>Active internet connection</li>
                                    <li>MARCXML compatible data</li>
                                </ul>
                            </div>

                            <div class="download-options">
                                <h6 class="section-title">
                                    <i class="bi bi-download me-2"></i>Download Options
                                </h6>
                                <div class="download-buttons">
                                    <button class="btn btn-download" data-file="oai-pmh-service.zip" data-size="2.1 MB">
                                        <i class="bi bi-download me-2"></i>
                                        Download Module
                                        <span class="file-size">2.1 MB</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Edit Form (Hidden by default) -->
                        <div class="card-edit-form d-none">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Application Title</label>
                                <input type="text" class="form-control edit-title" value="OAI-PMH Service">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea class="form-control edit-description" rows="4">Lightweight service module for data communication through harvesting protocol. Enables INLISLite users to share library data online to central catalog platforms like Indonesia OneSearch and National Union Catalog.</textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary save-app">
                                    <i class="bi bi-check-lg me-2"></i>Save
                                </button>
                                <button class="btn btn-secondary cancel-edit">
                                    <i class="bi bi-x-lg me-2"></i>Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- SMS Gateway Service -->
                <div class="application-card card" data-app-id="2">
                    <div class="card-header d-flex justify-content-between align-items-start">
                        <div class="card-title-section">
                            <div class="d-flex align-items-center mb-2">
                                <div class="app-icon-circle bg-success">
                                    <i class="bi bi-chat-dots"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="card-title mb-1">SMS Gateway Service</h3>
                                    <p class="card-subtitle text-muted mb-0">Automated SMS notifications using Gammu SMS Gateway</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item edit-app" href="#" data-id="2"><i class="bi bi-pencil me-2"></i>Edit Application</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item delete-app text-danger" href="#" data-id="2"><i class="bi bi-trash me-2"></i>Delete Application</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <p class="mb-4">Send scheduled SMS notifications manually such as overdue reminders or library announcements. SMS Gateway service integrated with INLISLite to provide automated communication with library members through Gammu 1.33.0.</p>
                            
                            <div class="technical-details mb-4">
                                <h6 class="section-title">
                                    <i class="bi bi-gear me-2"></i>Technical Details
                                </h6>
                                <ul class="detail-list">
                                    <li>Based on Gammu 1.33.0 library</li>
                                    <li>Supports GSM modem integration</li>
                                    <li>Automated notification system</li>
                                    <li>Customizable message templates</li>
                                </ul>
                            </div>

                            <div class="requirements-section mb-4">
                                <h6 class="section-title">
                                    <i class="bi bi-check-circle me-2"></i>Requirements
                                </h6>
                                <ul class="requirements-list">
                                    <li>Windows/Linux operating system</li>
                                    <li>GSM modem or mobile phone</li>
                                    <li>Active SIM card with SMS credits</li>
                                    <li>Gammu 1.33.0 or higher</li>
                                </ul>
                            </div>

                            <div class="download-options">
                                <h6 class="section-title">
                                    <i class="bi bi-download me-2"></i>Download Options
                                </h6>
                                <div class="download-buttons">
                                    <button class="btn btn-download" data-file="gammu-windows-32bit.zip" data-size="4.0 MB">
                                        <i class="bi bi-download me-2"></i>
                                        Windows 32-bit
                                        <span class="file-size">4.0 MB</span>
                                    </button>
                                    <button class="btn btn-download" data-file="gammu-windows-64bit.zip" data-size="4.0 MB">
                                        <i class="bi bi-download me-2"></i>
                                        Windows 64-bit
                                        <span class="file-size">4.0 MB</span>
                                    </button>
                                    <button class="btn btn-download" data-file="gammu-linux.tar.gz" data-size="4.0 MB">
                                        <i class="bi bi-download me-2"></i>
                                        Linux
                                        <span class="file-size">4.0 MB</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Edit Form (Hidden by default) -->
                        <div class="card-edit-form d-none">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Application Title</label>
                                <input type="text" class="form-control edit-title" value="SMS Gateway Service">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea class="form-control edit-description" rows="4">Send scheduled SMS notifications manually such as overdue reminders or library announcements. SMS Gateway service integrated with INLISLite to provide automated communication with library members through Gammu 1.33.0.</textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary save-app">
                                    <i class="bi bi-check-lg me-2"></i>Save
                                </button>
                                <button class="btn btn-secondary cancel-edit">
                                    <i class="bi bi-x-lg me-2"></i>Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- RFID Gateway Service -->
                <div class="application-card card" data-app-id="3">
                    <div class="card-header d-flex justify-content-between align-items-start">
                        <div class="card-title-section">
                            <div class="d-flex align-items-center mb-2">
                                <div class="app-icon-circle bg-info">
                                    <i class="bi bi-wifi"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="card-title mb-1">RFID Gateway Service</h3>
                                    <p class="card-subtitle text-muted mb-0">Connect INLISLite database with RFID-based self-service terminals using SIP2 protocol</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item edit-app" href="#" data-id="3"><i class="bi bi-pencil me-2"></i>Edit Application</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item delete-app text-danger" href="#" data-id="3"><i class="bi bi-trash me-2"></i>Delete Application</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <p class="mb-4">Connect INLISLite database with RFID-based self-service terminals using SIP2 protocol. Tested with RFID terminals from 3M and Fe Technologies to ensure smooth automated circulation operations.</p>
                            
                            <div class="technical-details mb-4">
                                <h6 class="section-title">
                                    <i class="bi bi-gear me-2"></i>Technical Details
                                </h6>
                                <ul class="detail-list">
                                    <li>SIP2 protocol support</li>
                                    <li>RFID terminal integration</li>
                                    <li>Self-service circulation</li>
                                    <li>Real-time database connectivity</li>
                                </ul>
                            </div>

                            <div class="requirements-section mb-4">
                                <h6 class="section-title">
                                    <i class="bi bi-check-circle me-2"></i>Requirements
                                </h6>
                                <ul class="requirements-list">
                                    <li>Windows operating system only</li>
                                    <li>RFID terminal hardware</li>
                                    <li>SIP2 protocol support</li>
                                    <li>Network connectivity</li>
                                </ul>
                            </div>

                            <div class="download-options">
                                <h6 class="section-title">
                                    <i class="bi bi-download me-2"></i>Download Options
                                </h6>
                                <div class="download-buttons">
                                    <button class="btn btn-download" data-file="rfid-gateway.rar" data-size="179 KB">
                                        <i class="bi bi-download me-2"></i>
                                        Windows (RAR)
                                        <span class="file-size">179 KB</span>
                                    </button>
                                    <button class="btn btn-download" data-file="rfid-gateway.zip" data-size="208 KB">
                                        <i class="bi bi-download me-2"></i>
                                        Windows (ZIP)
                                        <span class="file-size">208 KB</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Edit Form (Hidden by default) -->
                        <div class="card-edit-form d-none">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Application Title</label>
                                <input type="text" class="form-control edit-title" value="RFID Gateway Service">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea class="form-control edit-description" rows="4">Connect INLISLite database with RFID-based self-service terminals using SIP2 protocol. Tested with RFID terminals from 3M and Fe Technologies to ensure smooth automated circulation operations.</textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary save-app">
                                    <i class="bi bi-check-lg me-2"></i>Save
                                </button>
                                <button class="btn btn-secondary cancel-edit">
                                    <i class="bi bi-x-lg me-2"></i>Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Migrator -->
                <div class="application-card card" data-app-id="4">
                    <div class="card-header d-flex justify-content-between align-items-start">
                        <div class="card-title-section">
                            <div class="d-flex align-items-center mb-2">
                                <div class="app-icon-circle bg-warning">
                                    <i class="bi bi-arrow-repeat"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="card-title mb-1">Data Migrator</h3>
                                    <p class="card-subtitle text-muted mb-0">Migrate data from INLISLite v2.1.2 to v3.0</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item edit-app" href="#" data-id="4"><i class="bi bi-pencil me-2"></i>Edit Application</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item delete-app text-danger" href="#" data-id="4"><i class="bi bi-trash me-2"></i>Delete Application</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <p class="mb-4">Desktop utility to migrate data from INLISLite version 2.1.2 to version 3. Ensures complete data integrity during the upgrade process with comprehensive database schema conversion.</p>
                            
                            <div class="technical-details mb-4">
                                <h6 class="section-title">
                                    <i class="bi bi-gear me-2"></i>Technical Details
                                </h6>
                                <ul class="detail-list">
                                    <li>Complete database schema conversion</li>
                                    <li>Data integrity preservation</li>
                                    <li>Includes PDF guide in archive</li>
                                    <li>Automated migration process</li>
                                </ul>
                            </div>

                            <div class="requirements-section mb-4">
                                <h6 class="section-title">
                                    <i class="bi bi-check-circle me-2"></i>Requirements
                                </h6>
                                <ul class="requirements-list">
                                    <li>Windows operating system</li>
                                    <li>INLISLite v2.1.2 database</li>
                                    <li>Administrator access rights</li>
                                    <li>Backup storage media</li>
                                </ul>
                            </div>

                            <div class="download-options">
                                <h6 class="section-title">
                                    <i class="bi bi-download me-2"></i>Download Options
                                </h6>
                                <div class="download-buttons">
                                    <button class="btn btn-download" data-file="data-migrator.7z" data-size="179 KB">
                                        <i class="bi bi-download me-2"></i>
                                        Windows Migrator
                                        <span class="file-size">179 KB</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Edit Form (Hidden by default) -->
                        <div class="card-edit-form d-none">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Application Title</label>
                                <input type="text" class="form-control edit-title" value="Data Migrator">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea class="form-control edit-description" rows="4">Desktop utility to migrate data from INLISLite version 2.1.2 to version 3. Ensures complete data integrity during the upgrade process with comprehensive database schema conversion.</textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary save-app">
                                    <i class="bi bi-check-lg me-2"></i>Save
                                </button>
                                <button class="btn btn-secondary cancel-edit">
                                    <i class="bi bi-x-lg me-2"></i>Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Record Indexing -->
                <div class="application-card card" data-app-id="5">
                    <div class="card-header d-flex justify-content-between align-items-start">
                        <div class="card-title-section">
                            <div class="d-flex align-items-center mb-2">
                                <div class="app-icon-circle bg-dark">
                                    <i class="bi bi-search"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="card-title mb-1">Record Indexing</h3>
                                    <p class="card-subtitle text-muted mb-0">Enhanced OPAC search speed through ElasticSearch engine</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item edit-app" href="#" data-id="5"><i class="bi bi-pencil me-2"></i>Edit Application</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item delete-app text-danger" href="#" data-id="5"><i class="bi bi-trash me-2"></i>Delete Application</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <p class="mb-4">Enhance OPAC search speed through ElasticSearch engine. Provides powerful search capabilities for large databases with advanced indexing and full-text search functionality.</p>
                            
                            <div class="technical-details mb-4">
                                <h6 class="section-title">
                                    <i class="bi bi-gear me-2"></i>Technical Details
                                </h6>
                                <ul class="detail-list">
                                    <li>ElasticSearch 6.2.2 engine</li>
                                    <li>Java Runtime Environment 8</li>
                                    <li>Full-text search capabilities</li>
                                    <li>Advanced indexing system</li>
                                </ul>
                            </div>

                            <div class="requirements-section mb-4">
                                <h6 class="section-title">
                                    <i class="bi bi-check-circle me-2"></i>Requirements
                                </h6>
                                <ul class="requirements-list">
                                    <li>Windows 64-bit</li>
                                    <li>Java Runtime Environment 8</li>
                                    <li>ElasticSearch 6.2.2</li>
                                    <li>Adequate system resources</li>
                                </ul>
                            </div>

                            <div class="download-options">
                                <h6 class="section-title">
                                    <i class="bi bi-download me-2"></i>Download Options
                                </h6>
                                <div class="download-buttons">
                                    <button class="btn btn-download" data-file="elasticsearch-indexer.7z" data-size="68.8 MB">
                                        <i class="bi bi-download me-2"></i>
                                        ElasticSearch Indexer
                                        <span class="file-size">68.8 MB</span>
                                    </button>
                                    <button class="btn btn-download" data-file="elasticsearch-6.2.2.msi" data-size="33.4 MB">
                                        <i class="bi bi-download me-2"></i>
                                        ElasticSearch Engine
                                        <span class="file-size">33.4 MB</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Edit Form (Hidden by default) -->
                        <div class="card-edit-form d-none">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Application Title</label>
                                <input type="text" class="form-control edit-title" value="Record Indexing">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea class="form-control edit-description" rows="4">Enhance OPAC search speed through ElasticSearch engine. Provides powerful search capabilities for large databases with advanced indexing and full-text search functionality.</textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary save-app">
                                    <i class="bi bi-check-lg me-2"></i>Save
                                </button>
                                <button class="btn btn-secondary cancel-edit">
                                    <i class="bi bi-x-lg me-2"></i>Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this application? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="bi bi-trash me-2"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets/js/admin/dashboard.js') ?>"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url('assets/js/admin/aplikasi.js') ?>"></script>
    
    <script>
        // Initialize Feather icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            
            // Clear any active menu state since applications page doesn't have active menu in sidebar
            sessionStorage.removeItem('activeMenu');
            
            // Remove active class from all sidebar links since this page is not in the main navigation
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
        });
    </script>
</body>
</html>
