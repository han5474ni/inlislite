/**
 * INLISLite v3.0 Public Installer Edit Page
 * CRUD management for installer packages with DataTables integration
 */

// Global variables
let packagesTable;
let currentEditId = null;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

/**
 * Initialize the application
 */
function initializeApp() {
    initializeDataTable();
    initializeEventListeners();
    loadStatistics();
    loadPackages();
}

/**
 * Initialize DataTables
 */
function initializeDataTable() {
    packagesTable = $('#packagesTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']], // Sort by ID
        columnDefs: [
            { orderable: false, targets: [1, 7] }, // Disable sorting for icon and actions
            { searchable: false, targets: [1, 7] }, // Disable search for icon and actions
            { width: "60px", targets: [0] }, // ID column width
            { width: "80px", targets: [1] }, // Icon column width
            { width: "100px", targets: [4] }, // Type column width
            { width: "100px", targets: [5] }, // Size column width
            { width: "100px", targets: [6] }, // Status column width
            { width: "120px", targets: [7] } // Actions column width
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        drawCallback: function() {
            // Re-initialize tooltips after table redraw
            initializeTooltips();
        }
    });
}

/**
 * Initialize event listeners
 */
function initializeEventListeners() {
    // Form submissions
    document.getElementById('addPackageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        savePackage();
    });
    
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updatePackage();
    });
    
    // Modal events
    document.getElementById('addPackageModal').addEventListener('hidden.bs.modal', function() {
        resetAddForm();
    });
    
    document.getElementById('editModal').addEventListener('hidden.bs.modal', function() {
        resetEditForm();
    });
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

/**
 * Load statistics
 */
async function loadStatistics() {
    try {
        // Sample statistics - replace with actual API call
        const stats = {
            total_packages: 5,
            active_packages: 4,
            total_downloads: 1250,
            installer_packages: 2
        };
        
        updateStatistics(stats);
        
    } catch (error) {
        console.error('Error loading statistics:', error);
        showError('Gagal memuat statistik');
    }
}

/**
 * Update statistics display
 */
function updateStatistics(stats) {
    document.getElementById('totalPackages').textContent = stats.total_packages || 0;
    document.getElementById('activePackages').textContent = stats.active_packages || 0;
    document.getElementById('totalDownloads').textContent = stats.total_downloads || 0;
    document.getElementById('installerPackages').textContent = stats.installer_packages || 0;
}

/**
 * Load packages data
 */
async function loadPackages() {
    try {
        showLoading();
        
        // Sample data - replace with actual API call
        const samplePackages = [
            {
                id: 1,
                name: "Paket Source Code",
                version: "3.2",
                description: "File sumber PHP lengkap dengan dokumentasi dan panduan instalasi.",
                type: "source",
                size: "25 MB",
                icon: "bi-code-slash",
                color: "blue",
                status: "active",
                url: "#",
                created_at: "2024-01-15 10:30:00"
            },
            {
                id: 2,
                name: "Paket Installer Windows",
                version: "3.2",
                description: "Installer otomatis untuk sistem operasi Windows dengan wizard instalasi.",
                type: "installer",
                size: "45 MB",
                icon: "bi-windows",
                color: "green",
                status: "active",
                url: "#",
                created_at: "2024-01-15 10:35:00"
            },
            {
                id: 3,
                name: "Source Code PHP",
                version: "3.2",
                description: "File sumber lengkap aplikasi PHP untuk pengembangan dan kustomisasi.",
                type: "source",
                size: "20 MB",
                icon: "bi-filetype-php",
                color: "purple",
                status: "active",
                url: "#",
                created_at: "2024-01-15 10:40:00"
            },
            {
                id: 4,
                name: "Database Kosong",
                version: "3.2",
                description: "File SQL database kosong untuk instalasi fresh.",
                type: "database",
                size: "2 MB",
                icon: "bi-database",
                color: "orange",
                status: "active",
                url: "#",
                created_at: "2024-01-15 10:45:00"
            },
            {
                id: 5,
                name: "Dokumentasi",
                version: "3.2",
                description: "Panduan lengkap instalasi, konfigurasi, dan penggunaan sistem.",
                type: "documentation",
                size: "15 MB",
                icon: "bi-book",
                color: "blue",
                status: "inactive",
                url: "#",
                created_at: "2024-01-15 10:50:00"
            }
        ];
        
        populateTable(samplePackages);
        
    } catch (error) {
        console.error('Error loading packages:', error);
        showError('Gagal memuat data paket');
    } finally {
        hideLoading();
    }
}

/**
 * Populate DataTable with packages data
 */
function populateTable(packages) {
    packagesTable.clear();
    
    packages.forEach(pkg => {
        const row = [
            pkg.id,
            `<div class="text-center">
                <i class="${pkg.icon}" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
            </div>`,
            `<div>
                <div class="fw-semibold">${pkg.name}</div>
                <small class="text-muted">${pkg.description.substring(0, 50)}...</small>
            </div>`,
            pkg.version,
            `<span class="type-badge ${pkg.type}">${getTypeLabel(pkg.type)}</span>`,
            pkg.size,
            `<span class="status-badge ${pkg.status}">${getStatusLabel(pkg.status)}</span>`,
            `<div class="d-flex justify-content-center">
                <button class="btn-action edit" onclick="editPackage(${pkg.id})" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-action delete" onclick="deletePackage(${pkg.id})" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>`
        ];
        
        packagesTable.row.add(row);
    });
    
    packagesTable.draw();
}

/**
 * Get type label
 */
function getTypeLabel(type) {
    const labels = {
        'installer': 'Installer',
        'source': 'Source Code',
        'database': 'Database',
        'documentation': 'Dokumentasi'
    };
    return labels[type] || type;
}

/**
 * Get status label
 */
function getStatusLabel(status) {
    const labels = {
        'active': 'Aktif',
        'inactive': 'Tidak Aktif'
    };
    return labels[status] || status;
}

/**
 * Add feature input
 */
function addFeature(button) {
    const featuresContainer = document.querySelector('.features-input');
    const newFeatureInput = document.createElement('div');
    newFeatureInput.className = 'input-group mb-2';
    newFeatureInput.innerHTML = `
        <input type="text" class="form-control feature-input" placeholder="Masukkan fitur paket">
        <button class="btn btn-outline-danger" type="button" onclick="removeFeature(this)">
            <i class="bi bi-trash"></i>
        </button>
    `;
    featuresContainer.appendChild(newFeatureInput);
}

/**
 * Remove feature input
 */
function removeFeature(button) {
    button.parentElement.remove();
}

/**
 * Save new package
 */
async function savePackage() {
    try {
        const features = Array.from(document.querySelectorAll('.feature-input'))
            .map(input => input.value.trim())
            .filter(value => value !== '');
        
        const formData = {
            name: document.getElementById('packageName').value,
            version: document.getElementById('packageVersion').value,
            description: document.getElementById('packageDescription').value,
            type: document.getElementById('packageType').value,
            size: document.getElementById('packageSize').value,
            icon: document.getElementById('packageIcon').value,
            color: document.getElementById('packageColor').value,
            status: document.getElementById('packageStatus').value,
            url: document.getElementById('packageUrl').value,
            features: features
        };
        
        // Validate required fields
        if (!formData.name || !formData.version || !formData.description || !formData.type) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        // Ensure icon has bi- prefix
        if (formData.icon && !formData.icon.startsWith('bi-')) {
            formData.icon = `bi-${formData.icon}`;
        }
        
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Saving package:', formData);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Close modal and refresh data
        const modal = bootstrap.Modal.getInstance(document.getElementById('addPackageModal'));
        modal.hide();
        
        showSuccess('Paket berhasil ditambahkan');
        loadPackages();
        loadStatistics();
        
    } catch (error) {
        console.error('Error saving package:', error);
        showError('Gagal menyimpan paket');
    } finally {
        hideLoading();
    }
}

/**
 * Edit package
 */
function editPackage(id) {
    // Sample data - replace with actual API call
    const samplePackages = [
        {
            id: 1,
            name: "Paket Source Code",
            version: "3.2",
            description: "File sumber PHP lengkap dengan dokumentasi dan panduan instalasi.",
            type: "source",
            size: "25 MB",
            icon: "bi-code-slash",
            color: "blue",
            status: "active",
            url: "#"
        },
        {
            id: 2,
            name: "Paket Installer Windows",
            version: "3.2",
            description: "Installer otomatis untuk sistem operasi Windows dengan wizard instalasi.",
            type: "installer",
            size: "45 MB",
            icon: "bi-windows",
            color: "green",
            status: "active",
            url: "#"
        },
        {
            id: 3,
            name: "Source Code PHP",
            version: "3.2",
            description: "File sumber lengkap aplikasi PHP untuk pengembangan dan kustomisasi.",
            type: "source",
            size: "20 MB",
            icon: "bi-filetype-php",
            color: "purple",
            status: "active",
            url: "#"
        },
        {
            id: 4,
            name: "Database Kosong",
            version: "3.2",
            description: "File SQL database kosong untuk instalasi fresh.",
            type: "database",
            size: "2 MB",
            icon: "bi-database",
            color: "orange",
            status: "active",
            url: "#"
        },
        {
            id: 5,
            name: "Dokumentasi",
            version: "3.2",
            description: "Panduan lengkap instalasi, konfigurasi, dan penggunaan sistem.",
            type: "documentation",
            size: "15 MB",
            icon: "bi-book",
            color: "blue",
            status: "inactive",
            url: "#"
        }
    ];
    
    const pkg = samplePackages.find(p => p.id === id);
    
    if (!pkg) {
        showError('Paket tidak ditemukan');
        return;
    }
    
    // Populate edit form
    currentEditId = id;
    document.getElementById('editId').value = id;
    document.getElementById('editName').value = pkg.name;
    document.getElementById('editVersion').value = pkg.version;
    document.getElementById('editDescription').value = pkg.description;
    document.getElementById('editType').value = pkg.type;
    document.getElementById('editSize').value = pkg.size;
    document.getElementById('editIcon').value = pkg.icon;
    document.getElementById('editColor').value = pkg.color;
    document.getElementById('editStatus').value = pkg.status;
    document.getElementById('editUrl').value = pkg.url;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}

/**
 * Update package
 */
async function updatePackage() {
    try {
        const formData = {
            id: currentEditId,
            name: document.getElementById('editName').value,
            version: document.getElementById('editVersion').value,
            description: document.getElementById('editDescription').value,
            type: document.getElementById('editType').value,
            size: document.getElementById('editSize').value,
            icon: document.getElementById('editIcon').value,
            color: document.getElementById('editColor').value,
            status: document.getElementById('editStatus').value,
            url: document.getElementById('editUrl').value
        };
        
        // Validate required fields
        if (!formData.name || !formData.version || !formData.description || !formData.type) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        // Ensure icon has bi- prefix
        if (formData.icon && !formData.icon.startsWith('bi-')) {
            formData.icon = `bi-${formData.icon}`;
        }
        
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Updating package:', formData);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Close modal and refresh data
        const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
        modal.hide();
        
        showSuccess('Paket berhasil diperbarui');
        loadPackages();
        loadStatistics();
        
    } catch (error) {
        console.error('Error updating package:', error);
        showError('Gagal memperbarui paket');
    } finally {
        hideLoading();
    }
}

/**
 * Delete package
 */
async function deletePackage(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus paket ini?')) {
        return;
    }
    
    try {
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Deleting package:', id);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        showSuccess('Paket berhasil dihapus');
        loadPackages();
        loadStatistics();
        
    } catch (error) {
        console.error('Error deleting package:', error);
        showError('Gagal menghapus paket');
    } finally {
        hideLoading();
    }
}

/**
 * Save settings
 */
async function saveSettings() {
    try {
        const settingsData = {
            installer_version: document.getElementById('installerVersion').value,
            revision_date: document.getElementById('revisionDate').value,
            description: document.getElementById('installerDescription').value,
            default_username: document.getElementById('defaultUsername').value,
            default_password: document.getElementById('defaultPassword').value
        };
        
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Saving settings:', settingsData);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        showSuccess('Pengaturan berhasil disimpan');
        
    } catch (error) {
        console.error('Error saving settings:', error);
        showError('Gagal menyimpan pengaturan');
    } finally {
        hideLoading();
    }
}

/**
 * Reset add form
 */
function resetAddForm() {
    document.getElementById('addPackageForm').reset();
    
    // Reset features inputs to just one
    const featuresContainer = document.querySelector('.features-input');
    featuresContainer.innerHTML = `
        <div class="input-group mb-2">
            <input type="text" class="form-control feature-input" placeholder="Masukkan fitur paket">
            <button class="btn btn-outline-secondary" type="button" onclick="addFeature(this)">
                <i class="bi bi-plus"></i>
            </button>
        </div>
    `;
}

/**
 * Reset edit form
 */
function resetEditForm() {
    document.getElementById('editForm').reset();
    currentEditId = null;
}

/**
 * Show loading spinner
 */
function showLoading() {
    const spinner = document.getElementById('loadingSpinner');
    if (spinner) {
        spinner.style.display = 'flex';
    }
}

/**
 * Hide loading spinner
 */
function hideLoading() {
    const spinner = document.getElementById('loadingSpinner');
    if (spinner) {
        spinner.style.display = 'none';
    }
}

/**
 * Show success message
 */
function showSuccess(message) {
    showToast(message, 'success');
}

/**
 * Show error message
 */
function showError(message) {
    showToast(message, 'error');
}

/**
 * Show toast notification
 */
function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <i class="bi bi-x"></i>
        </button>
    `;
    
    // Add styles if not already added
    if (!document.querySelector('#toast-styles')) {
        const style = document.createElement('style');
        style.id = 'toast-styles';
        style.textContent = `
            .toast-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
                background: white;
                border-radius: 8px;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                padding: 1rem;
                display: flex;
                align-items: center;
                gap: 1rem;
                min-width: 300px;
                animation: slideInRight 0.3s ease-out;
                border-left: 4px solid #6b7280;
            }
            .toast-success { border-left-color: #059669; }
            .toast-error { border-left-color: #dc2626; }
            .toast-content {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                flex: 1;
            }
            .toast-close {
                background: none;
                border: none;
                color: #6b7280;
                cursor: pointer;
                padding: 0.25rem;
                border-radius: 4px;
            }
            .toast-close:hover {
                background-color: #f3f4f6;
            }
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Add to DOM
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.animation = 'slideInRight 0.3s ease-out reverse';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
}

// Export functions for global access
window.savePackage = savePackage;
window.editPackage = editPackage;
window.updatePackage = updatePackage;
window.deletePackage = deletePackage;
window.saveSettings = saveSettings;
window.addFeature = addFeature;
window.removeFeature = removeFeature;