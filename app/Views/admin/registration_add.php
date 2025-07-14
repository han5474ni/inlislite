<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Add Registration - INLISlite v3.0' ?></title>
    
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
    <!-- Registration Add CSS -->
    <link href="<?= base_url('assets/css/admin/registration_add.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Include Enhanced Sidebar -->
    <?= $this->include('admin/partials/sidebar') ?>

    <!-- Main Content -->
    <main class="enhanced-main-content">
        <div class="dashboard-container">
            <div class="header-card">
                <div class="content-header">
                    <h1 class="main-title"><?= $page_title ?? 'Add New Registration' ?></h1>
                    <p class="main-subtitle"><?= $page_subtitle ?? 'Register a new library in the system' ?></p>
                </div>
            </div>
        <div class="page-container">

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Registration Form -->
            <div class="registration-form-section">
                <div class="registration-form-container">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-building me-2"></i>
                                Library Registration Form
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="registrationForm" method="POST" action="<?= base_url('admin/registration/add') ?>">
                                <?= csrf_field() ?>
                                
                                <!-- Basic Information -->
                                <div class="form-section">
                                    <h6 class="form-section-title">Basic Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Library Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="library_name" placeholder="Enter library name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Library Code</label>
                                            <input type="text" class="form-control" name="library_code" placeholder="Auto-generated or enter manually">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Library Type <span class="text-danger">*</span></label>
                                            <select class="form-select" name="library_type" required>
                                                <option value="">Select Type</option>
                                                <option value="Public">Public Library</option>
                                                <option value="Academic">Academic Library</option>
                                                <option value="School">School Library</option>
                                                <option value="Special">Special Library</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                            <select class="form-select" name="status" required>
                                                <option value="">Select Status</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <option value="Pending" selected>Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location Information -->
                                <div class="form-section">
                                    <h6 class="form-section-title">Location Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Province <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="province" placeholder="Enter province" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="city" placeholder="Enter city" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Address</label>
                                            <textarea class="form-control" name="address" rows="3" placeholder="Enter complete address"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Postal Code</label>
                                            <input type="text" class="form-control" name="postal_code" placeholder="Enter postal code">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Coordinates</label>
                                            <input type="text" class="form-control" name="coordinates" placeholder="Latitude, Longitude">
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="form-section">
                                    <h6 class="form-section-title">Contact Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Contact Person <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="contact_name" placeholder="Enter contact person name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Position</label>
                                            <input type="text" class="form-control" name="contact_position" placeholder="Enter position/title">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" placeholder="Enter email address" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" name="phone" placeholder="Enter phone number" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Website</label>
                                            <input type="url" class="form-control" name="website" placeholder="Enter website URL">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Fax</label>
                                            <input type="text" class="form-control" name="fax" placeholder="Enter fax number">
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="form-section">
                                    <h6 class="form-section-title">Additional Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Established Year</label>
                                            <input type="number" class="form-control" name="established_year" placeholder="YYYY" min="1900" max="<?= date('Y') ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Collection Count</label>
                                            <input type="number" class="form-control" name="collection_count" placeholder="Number of books/items" min="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Member Count</label>
                                            <input type="number" class="form-control" name="member_count" placeholder="Number of members" min="0">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Notes</label>
                                            <textarea class="form-control" name="notes" rows="3" placeholder="Additional notes or comments"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="form-actions">
                                    <div class="d-flex gap-3 justify-content-end">
                                        <a href="<?= base_url('admin/registration') ?>" class="btn btn-secondary">
                                            <i class="bi bi-x-lg me-2"></i>
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-lg me-2"></i>
                                            Save Registration
                                        </button>
                                    </div>
                                </div>
                            </form>
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
    <!-- Registration Add JS -->
    <script src="<?= base_url('assets/js/admin/registration_add.js') ?>"></script>
</body>
</html>