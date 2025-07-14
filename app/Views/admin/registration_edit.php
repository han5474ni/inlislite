<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Edit Registration - INLISlite v3.0' ?></title>
    
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
    <!-- Registration Edit CSS -->
    <link href="<?= base_url('assets/css/admin/registration_edit.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Include Enhanced Sidebar -->
    <?= $this->include('admin/partials/sidebar') ?>

    <!-- Header Section -->
    <header class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn-back me-3" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <div>
                        <h1 class="header-title mb-1"><?= $page_title ?? 'Edit Registration' ?></h1>
                        <p class="header-subtitle mb-0"><?= $page_subtitle ?? 'Update library registration information' ?></p>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('admin/registration') ?>" class="btn btn-outline-light">
                            <i class="bi bi-eye me-2"></i>Lihat Halaman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="enhanced-main-content">
        <div class="container">

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
            
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach (session('errors') as $field => $error): ?>
                            <li><strong><?= ucfirst(str_replace('_', ' ', $field)) ?>:</strong> <?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
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
                                Edit Library Registration
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="registrationForm" method="POST" action="<?= base_url('admin/registration/edit/' . ($registration['id'] ?? '')) ?>">
                                <?= csrf_field() ?>
                                
                                <!-- Basic Information -->
                                <div class="form-section">
                                    <h6 class="form-section-title">Basic Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Library Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?= session('errors.library_name') ? 'is-invalid' : '' ?>" name="library_name" value="<?= esc(old('library_name', $registration['library_name'] ?? '')) ?>" placeholder="Enter library name" required>
                                            <?php if (session('errors.library_name')): ?>
                                                <div class="invalid-feedback"><?= esc(session('errors.library_name')) ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Library Code</label>
                                            <input type="text" class="form-control" name="library_code" value="<?= esc(old('library_code', $registration['library_code'] ?? '')) ?>" placeholder="Auto-generated or enter manually">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Library Type <span class="text-danger">*</span></label>
                                            <select class="form-select <?= session('errors.library_type') ? 'is-invalid' : '' ?>" name="library_type" id="libraryTypeSelect" required>
                                                <option value="">Select Type</option>
                                                <?php $selectedType = old('library_type', $registration['library_type'] ?? ''); ?>
                                                <option value="Public" <?= $selectedType === 'Public' ? 'selected' : '' ?>>Public Library</option>
                                                <option value="Academic" <?= $selectedType === 'Academic' ? 'selected' : '' ?>>Academic Library</option>
                                                <option value="School" <?= $selectedType === 'School' ? 'selected' : '' ?>>School Library</option>
                                                <option value="Special" <?= $selectedType === 'Special' ? 'selected' : '' ?>>Special Library</option>
                                            </select>
                                            <?php if (session('errors.library_type')): ?>
                                                <div class="invalid-feedback"><?= esc(session('errors.library_type')) ?></div>
                                            <?php else: ?>
                                                <small class="text-muted">Current: <?= esc($registration['library_type'] ?? 'Not set') ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                            <select class="form-select <?= session('errors.status') ? 'is-invalid' : '' ?>" name="status" required>
                                                <option value="">Select Status</option>
                                                <?php $selectedStatus = old('status', $registration['status'] ?? ''); ?>
                                                <option value="Active" <?= $selectedStatus === 'Active' ? 'selected' : '' ?>>Active</option>
                                                <option value="Inactive" <?= $selectedStatus === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                                <option value="Pending" <?= $selectedStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                            </select>
                                            <?php if (session('errors.status')): ?>
                                                <div class="invalid-feedback"><?= esc(session('errors.status')) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location Information -->
                                <div class="form-section">
                                    <h6 class="form-section-title">Location Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Province <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="province" value="<?= esc($registration['province'] ?? '') ?>" placeholder="Enter province" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="city" value="<?= esc($registration['city'] ?? '') ?>" placeholder="Enter city" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Address</label>
                                            <textarea class="form-control" name="address" rows="3" placeholder="Enter complete address"><?= esc($registration['address'] ?? '') ?></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Postal Code</label>
                                            <input type="text" class="form-control" name="postal_code" value="<?= esc($registration['postal_code'] ?? '') ?>" placeholder="Enter postal code">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Coordinates</label>
                                            <input type="text" class="form-control" name="coordinates" value="<?= esc($registration['coordinates'] ?? '') ?>" placeholder="Latitude, Longitude">
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="form-section">
                                    <h6 class="form-section-title">Contact Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Contact Person <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="contact_name" value="<?= esc($registration['contact_name'] ?? '') ?>" placeholder="Enter contact person name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Position</label>
                                            <input type="text" class="form-control" name="contact_position" value="<?= esc($registration['contact_position'] ?? '') ?>" placeholder="Enter position/title">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" value="<?= esc(old('email', $registration['email'] ?? '')) ?>" placeholder="Enter email address" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" name="phone" value="<?= esc(old('phone', $registration['phone'] ?? '')) ?>" placeholder="Enter phone number" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Website</label>
                                            <input type="url" class="form-control" name="website" value="<?= esc($registration['website'] ?? '') ?>" placeholder="Enter website URL">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Fax</label>
                                            <input type="text" class="form-control" name="fax" value="<?= esc($registration['fax'] ?? '') ?>" placeholder="Enter fax number">
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="form-section">
                                    <h6 class="form-section-title">Additional Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Established Year</label>
                                            <input type="number" class="form-control" name="established_year" value="<?= esc($registration['established_year'] ?? '') ?>" placeholder="YYYY" min="1900" max="<?= date('Y') ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Collection Count</label>
                                            <input type="number" class="form-control" name="collection_count" value="<?= esc($registration['collection_count'] ?? '') ?>" placeholder="Number of books/items" min="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Member Count</label>
                                            <input type="number" class="form-control" name="member_count" value="<?= esc($registration['member_count'] ?? '') ?>" placeholder="Number of members" min="0">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Notes</label>
                                            <textarea class="form-control" name="notes" rows="3" placeholder="Additional notes or comments"><?= esc($registration['notes'] ?? '') ?></textarea>
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
                                            Update Registration
                                        </button>
                                    </div>
                                </div>
                            </form>
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
    <!-- Registration Edit JS -->
    <script src="<?= base_url('assets/js/admin/registration_edit.js') ?>"></script>
    
    <!-- Debug Script -->
    <script>
        // Logout confirmation function
        function confirmLogout() {
            return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
        }

        // Debug library type select
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            
            const libraryTypeSelect = document.getElementById('libraryTypeSelect');
            if (libraryTypeSelect) {
                console.log('🔍 Library Type Select Debug:');
                console.log('- Current value:', libraryTypeSelect.value);
                console.log('- Disabled:', libraryTypeSelect.disabled);
                console.log('- ReadOnly:', libraryTypeSelect.readOnly);
                console.log('- Options:', Array.from(libraryTypeSelect.options).map(opt => ({
                    value: opt.value,
                    text: opt.text,
                    selected: opt.selected
                })));
                
                // Add change event listener
                libraryTypeSelect.addEventListener('change', function() {
                    console.log('✅ Library type changed to:', this.value);
                    
                    // Show visual feedback
                    const currentDisplay = this.parentNode.querySelector('.text-muted');
                    if (currentDisplay) {
                        currentDisplay.textContent = 'Current: ' + this.value + ' (Changed - Ready to Save)';
                        currentDisplay.style.color = '#28a745';
                        currentDisplay.style.fontWeight = 'bold';
                    }
                });
                
                // Test if select is working
                setTimeout(() => {
                    console.log('🧪 Testing select functionality...');
                    const originalValue = libraryTypeSelect.value;
                    
                    // Try to change to a different value
                    const testValue = originalValue === 'Public' ? 'Academic' : 'Public';
                    libraryTypeSelect.value = testValue;
                    
                    if (libraryTypeSelect.value === testValue) {
                        console.log('✅ Select is working - can change values programmatically');
                    } else {
                        console.log('❌ Select is NOT working - cannot change values');
                    }
                    
                    // Change it back
                    libraryTypeSelect.value = originalValue;
                }, 1000);
            } else {
                console.log('❌ Library type select not found!');
            }
        });
    </script>
</body>
</html>