/**
 * INLISLite v3.0 Installer Edit Page
 * CRUD management for installer packages with DataTables integration
 */

// Global variables
let installersTable;
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
    loadInstallers();
}

/**
 * Initialize DataTables
 */
function initializeDataTable() {
    installersTable = $('#installersTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']], // Sort by ID column
        columnDefs: [
            { orderable: false, targets: [1, 6] }, // Disable sorting for icon and actions
            { searchable: false, targets: [1, 6] }, // Disable search for icon and actions
            { width: "60px", targets: [0] }, // ID column width
            { width: "80px", targets: [1] }, // Icon column width
            { width: "100px", targets: [3] }, // Type column width
            { width: "120px", targets: [6] } // Actions column width
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
    // Icon preview functionality
    document.getElementById('packageIcon').addEventListener('input', function() {
        updateIconPreview(this.value, 'packageIconPreview');
    });
    
    document.getElementById('editPackageIcon').addEventListener('input', function() {
        updateIconPreview(this.value, 'editPackageIconPreview');
    });
    
    // Form submissions
    document.getElementById('addInstallerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveInstaller();
    });
    
    document.getElementById('editInstallerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updateInstaller();
    });
    
    // Modal events
    document.getElementById('addInstallerModal').addEventListener('hidden.bs.modal', function() {
        resetAddForm();
    });
    
    document.getElementById('editInstallerModal').addEventListener('hidden.bs.modal', function() {
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
            total_installers: 6,
            active_installers: 5,
            source_packages: 2,
            total_downloads: 1247
        };
        
        updateStatistics(stats);
        
    } catch (error) {
        // console.error('Error loading statistics:', error);
        // showError('Gagal memuat statistik');
    }
}

/**
 * Update statistics display
 */
function updateStatistics(stats) {
    document.getElementById('totalInstallers').textContent = stats.total_installers || 0;
    document.getElementById('activeInstallers').textContent = stats.active_installers || 0;
    document.getElementById('sourcePackages').textContent = stats.source_packages || 0;
    document.getElementById('totalDownloads').textContent = stats.total_downloads || 0;
}

/**
 * Load installers data
 */
async function loadInstallers() {
    try {
        showLoading();
        
        // Load data from API
        const response = await fetch(`${window.baseUrl || ''}/admin/installer/data`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json();
        let installers = [];

        if (result.success) {
            installers = result.data || [];
        } else {
            console.error('Failed to load installers:', result.message);
            // Fallback to sample data
            installers = [
            {
                id: 1,
                package_name: "INLISLite v3.0 Full Package",
                subtitle: "Complete Installation Package",
                description: "Paket lengkap instalasi INLISLite v3.0 dengan semua fitur dan dokumentasi",
                package_type: "installer",
                icon: "bi-box-seam",
                version: "3.0.0",
                file_size: "25 MB",
                status: "active",
                release_date: "2024-01-15",
                download_url: "https://example.com/inlislite-v3-full.zip",
                default_username: "admin",
                default_password: "admin123",
                requirements: ["php", "database", "docs", "config"],
                sort_order: 1,
                created_at: "2024-01-15 10:30:00"
            },
            {
                id: 2,
                package_name: "INLISLite v3.0 Source Code",
                subtitle: "Source Code Only",
                description: "Source code INLISLite v3.0 untuk developer dan customization",
                package_type: "source",
                icon: "bi-code-slash",
                version: "3.0.0",
                file_size: "15 MB",
                status: "active",
                release_date: "2024-01-15",
                download_url: "https://example.com/inlislite-v3-source.zip",
                default_username: "",
                default_password: "",
                requirements: ["php", "config"],
                sort_order: 2,
                created_at: "2024-01-15 10:35:00"
            },
            {
                id: 3,
                package_name: "Database Structure",
                subtitle: "Database Schema & Sample Data",
                description: "Struktur database dan data sample untuk INLISLite v3.0",
                package_type: "database",
                icon: "bi-database",
                version: "3.0.0",
                file_size: "5 MB",
                status: "active",
                release_date: "2024-01-15",
                download_url: "https://example.com/inlislite-v3-db.sql",
                default_username: "",
                default_password: "",
                requirements: ["database"],
                sort_order: 3,
                created_at: "2024-01-15 10:40:00"
            },
            {
                id: 4,
                package_name: "Documentation Package",
                subtitle: "Complete User Manual",
                description: "Dokumentasi lengkap penggunaan dan instalasi INLISLite v3.0",
                package_type: "documentation",
                icon: "bi-book",
                version: "3.0.0",
                file_size: "8 MB",
                status: "active",
                release_date: "2024-01-15",
                download_url: "https://example.com/inlislite-v3-docs.pdf",
                default_username: "",
                default_password: "",
                requirements: ["docs"],
                sort_order: 4,
                created_at: "2024-01-15 10:45:00"
            },
            {
                id: 5,
                package_name: "OPAC Add-on",
                subtitle: "Enhanced OPAC Module",
                description: "Modul OPAC tambahan dengan fitur pencarian advanced",
                package_type: "addon",
                icon: "bi-search",
                version: "1.2.0",
                file_size: "3 MB",
                status: "active",
                release_date: "2024-01-20",
                download_url: "https://example.com/opac-addon.zip",
                default_username: "",
                default_password: "",
                requirements: ["php"],
                sort_order: 5,
                created_at: "2024-01-20 14:20:00"
            },
            {
                id: 6,
                package_name: "Legacy Installer v2.5",
                subtitle: "Previous Version",
                description: "Installer untuk INLISLite versi 2.5 (legacy support)",
                package_type: "installer",
                icon: "bi-archive",
                version: "2.5.0",
                file_size: "20 MB",
                status: "inactive",
                release_date: "2023-12-01",
                download_url: "https://example.com/inlislite-v2.5.zip",
                default_username: "admin",
                default_password: "admin",
                requirements: ["php", "database"],
                sort_order: 6,
                created_at: "2023-12-01 09:15:00"
            }
            ];
        }
        
        populateTable(installers);
        
    } catch (error) {
        console.error('Error loading installers:', error);
        showError('Gagal memuat data installer');
    } finally {
        hideLoading();
    }
}

/**
 * Populate DataTable with installers data
 */
function populateTable(installers) {
    installersTable.clear();
    
    installers.forEach(installer => {
        const row = [
            installer.id,
            `<div class="text-center">
                <i class="${installer.icon}" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
            </div>`,
            `<div>
                <div class="fw-semibold">${installer.package_name}</div>
                ${installer.subtitle ? `<small class="text-muted">${installer.subtitle}</small>` : ''}
            </div>`,
            `<span class="type-badge ${installer.package_type}">${getTypeLabel(installer.package_type)}</span>`,
            installer.version || '-',
            installer.file_size || '-',
            `<div class="d-flex justify-content-center">
                <button class="btn-action edit" onclick="editInstaller(${installer.id})" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-action delete" onclick="deleteInstaller(${installer.id})" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>`
        ];
        
        installersTable.row.add(row);
    });
    
    installersTable.draw();
}

/**
 * Get type label
 */
function getTypeLabel(type) {
    const labels = {
        'source': 'Source Code',
        'installer': 'Installer',
        'database': 'Database',
        'documentation': 'Dokumentasi',
        'addon': 'Add-on'
    };
    return labels[type] || type;
}

/**
 * Get status label
 */
function getStatusLabel(status) {
    const labels = {
        'active': 'Aktif',
        'inactive': 'Tidak Aktif',
        'maintenance': 'Maintenance'
    };
    return labels[status] || status;
}

/**
 * Update icon preview
 */
function updateIconPreview(iconClass, previewId) {
    const preview = document.getElementById(previewId);
    const iconElement = preview.querySelector('i');
    
    if (iconClass && iconClass.trim()) {
        // Ensure bi- prefix
        const formattedIcon = iconClass.startsWith('bi-') ? iconClass : `bi-${iconClass}`;
        iconElement.className = formattedIcon;
        preview.classList.add('valid');
    } else {
        iconElement.className = 'bi bi-question-circle';
        preview.classList.remove('valid');
    }
}

/**
 * Save new installer
 */
async function saveInstaller() {
    try {
        const formData = {
            package_name: document.getElementById('packageName').value,
            subtitle: document.getElementById('packageSubtitle').value,
            description: document.getElementById('packageDescription').value,
            package_type: document.getElementById('packageType').value,
            icon: document.getElementById('packageIcon').value,
            version: document.getElementById('packageVersion').value,
            file_size: document.getElementById('packageSize').value,
            status: document.getElementById('packageStatus').value,
            release_date: document.getElementById('packageReleaseDate').value,
            download_url: document.getElementById('packageDownloadUrl').value,
            default_username: document.getElementById('defaultUsername').value,
            default_password: document.getElementById('defaultPassword').value,
            sort_order: parseInt(document.getElementById('packageSortOrder').value),
            requirements: getSelectedRequirements()
        };
        
        // Validate required fields
        if (!formData.package_name || !formData.description || !formData.package_type) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        // Ensure icon has bi- prefix
        if (formData.icon && !formData.icon.startsWith('bi-')) {
            formData.icon = `bi-${formData.icon}`;
        }
        
        showLoading();
        
        // Save to database via API
        const response = await fetch(`${window.baseUrl || ''}/admin/installer/store`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(formData)
        });

        const result = await response.json();

        if (!result.success) {
            throw new Error(result.message || 'Gagal menyimpan installer');
        }
        
        // Close modal and refresh data
        const modal = bootstrap.Modal.getInstance(document.getElementById('addInstallerModal'));
        modal.hide();
        
        showSuccess('Installer berhasil ditambahkan');
        loadInstallers();
        loadStatistics();
        
    } catch (error) {
        console.error('Error saving installer:', error);
        showError('Gagal menyimpan installer');
    } finally {
        hideLoading();
    }
}

/**
 * Get selected requirements
 */
function getSelectedRequirements() {
    const requirements = [];
    if (document.getElementById('reqPhp').checked) requirements.push('php');
    if (document.getElementById('reqDatabase').checked) requirements.push('database');
    if (document.getElementById('reqDocs').checked) requirements.push('docs');
    if (document.getElementById('reqConfig').checked) requirements.push('config');
    return requirements;
}

/**
 * Edit installer
 */
function editInstaller(id) {
    // Sample data - replace with actual API call
    const sampleInstallers = [
        {
            id: 1,
            package_name: "INLISLite v3.0 Full Package",
            subtitle: "Complete Installation Package",
            description: "Paket lengkap instalasi INLISLite v3.0 dengan semua fitur dan dokumentasi",
            package_type: "installer",
            icon: "bi-box-seam",
            version: "3.0.0",
            file_size: "25 MB",
            status: "active",
            release_date: "2024-01-15",
            download_url: "https://example.com/inlislite-v3-full.zip",
            default_username: "admin",
            default_password: "admin123",
            requirements: ["php", "database", "docs", "config"],
            sort_order: 1
        },
        {
            id: 2,
            package_name: "INLISLite v3.0 Source Code",
            subtitle: "Source Code Only",
            description: "Source code INLISLite v3.0 untuk developer dan customization",
            package_type: "source",
            icon: "bi-code-slash",
            version: "3.0.0",
            file_size: "15 MB",
            status: "active",
            release_date: "2024-01-15",
            download_url: "https://example.com/inlislite-v3-source.zip",
            default_username: "",
            default_password: "",
            requirements: ["php", "config"],
            sort_order: 2
        }
    ];
    
    const installer = sampleInstallers.find(i => i.id === id);
    
    if (!installer) {
        showError('Installer tidak ditemukan');
        return;
    }
    
    // Populate edit form
    currentEditId = id;
    document.getElementById('editInstallerId').value = id;
    document.getElementById('editPackageName').value = installer.package_name;
    document.getElementById('editPackageSubtitle').value = installer.subtitle || '';
    document.getElementById('editPackageDescription').value = installer.description;
    document.getElementById('editPackageType').value = installer.package_type;
    document.getElementById('editPackageIcon').value = installer.icon;
    document.getElementById('editPackageVersion').value = installer.version || '';
    document.getElementById('editPackageSize').value = installer.file_size || '';
    document.getElementById('editPackageStatus').value = installer.status;
    document.getElementById('editPackageReleaseDate').value = installer.release_date || '';
    document.getElementById('editPackageDownloadUrl').value = installer.download_url || '';
    document.getElementById('editDefaultUsername').value = installer.default_username || '';
    document.getElementById('editDefaultPassword').value = installer.default_password || '';
    document.getElementById('editPackageSortOrder').value = installer.sort_order;
    
    // Set requirements checkboxes
    document.getElementById('editReqPhp').checked = installer.requirements.includes('php');
    document.getElementById('editReqDatabase').checked = installer.requirements.includes('database');
    document.getElementById('editReqDocs').checked = installer.requirements.includes('docs');
    document.getElementById('editReqConfig').checked = installer.requirements.includes('config');
    
    // Update icon preview
    updateIconPreview(installer.icon, 'editPackageIconPreview');
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editInstallerModal'));
    modal.show();
}

/**
 * Update installer
 */
async function updateInstaller() {
    try {
        const formData = {
            id: currentEditId,
            package_name: document.getElementById('editPackageName').value,
            subtitle: document.getElementById('editPackageSubtitle').value,
            description: document.getElementById('editPackageDescription').value,
            package_type: document.getElementById('editPackageType').value,
            icon: document.getElementById('editPackageIcon').value,
            version: document.getElementById('editPackageVersion').value,
            file_size: document.getElementById('editPackageSize').value,
            status: document.getElementById('editPackageStatus').value,
            release_date: document.getElementById('editPackageReleaseDate').value,
            download_url: document.getElementById('editPackageDownloadUrl').value,
            default_username: document.getElementById('editDefaultUsername').value,
            default_password: document.getElementById('editDefaultPassword').value,
            sort_order: parseInt(document.getElementById('editPackageSortOrder').value),
            requirements: getSelectedEditRequirements()
        };
        
        // Validate required fields
        if (!formData.package_name || !formData.description || !formData.package_type) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        // Ensure icon has bi- prefix
        if (formData.icon && !formData.icon.startsWith('bi-')) {
            formData.icon = `bi-${formData.icon}`;
        }
        
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Updating installer:', formData);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Close modal and refresh data
        const modal = bootstrap.Modal.getInstance(document.getElementById('editInstallerModal'));
        modal.hide();
        
        showSuccess('Installer berhasil diperbarui');
        loadInstallers();
        loadStatistics();
        
    } catch (error) {
        console.error('Error updating installer:', error);
        showError('Gagal memperbarui installer');
    } finally {
        hideLoading();
    }
}

/**
 * Get selected edit requirements
 */
function getSelectedEditRequirements() {
    const requirements = [];
    if (document.getElementById('editReqPhp').checked) requirements.push('php');
    if (document.getElementById('editReqDatabase').checked) requirements.push('database');
    if (document.getElementById('editReqDocs').checked) requirements.push('docs');
    if (document.getElementById('editReqConfig').checked) requirements.push('config');
    return requirements;
}

/**
 * Delete installer
 */
async function deleteInstaller(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus installer ini?')) {
        return;
    }
    
    try {
        showLoading();
        
        // Delete via API
        const response = await fetch(`${window.baseUrl || ''}/admin/installer/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (!result.success) {
            throw new Error(result.message || 'Gagal menghapus installer');
        }
        
        showSuccess('Installer berhasil dihapus');
        loadInstallers();
        loadStatistics();
        
    } catch (error) {
        console.error('Error deleting installer:', error);
        showError('Gagal menghapus installer');
    } finally {
        hideLoading();
    }
}

/**
 * Reset add form
 */
function resetAddForm() {
    document.getElementById('addInstallerForm').reset();
    document.getElementById('packageSortOrder').value = 1;
    updateIconPreview('', 'packageIconPreview');
    
    // Reset checkboxes
    document.getElementById('reqPhp').checked = false;
    document.getElementById('reqDatabase').checked = false;
    document.getElementById('reqDocs').checked = false;
    document.getElementById('reqConfig').checked = false;
}

/**
 * Reset edit form
 */
function resetEditForm() {
    document.getElementById('editInstallerForm').reset();
    currentEditId = null;
    updateIconPreview('', 'editPackageIconPreview');
    
    // Reset checkboxes
    document.getElementById('editReqPhp').checked = false;
    document.getElementById('editReqDatabase').checked = false;
    document.getElementById('editReqDocs').checked = false;
    document.getElementById('editReqConfig').checked = false;
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
window.saveInstaller = saveInstaller;
window.editInstaller = editInstaller;
window.updateInstaller = updateInstaller;
window.deleteInstaller = deleteInstaller;