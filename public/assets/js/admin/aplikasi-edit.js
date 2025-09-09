/**
 * INLISLite v3.0 Aplikasi Edit Page
 * CRUD management for aplikasi pendukung with DataTables integration
 */

// Global variables
let appsTable;
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

    // Bind Add button -> open inline card
    const addBtn = document.getElementById('btnAddApp');
    const addCard = document.getElementById('addAppCard');
    const closeAddBtn = document.getElementById('btnCloseAddApp');
    const cancelAddBtn = document.getElementById('btnCancelAdd');
    const tableWrapper = document.querySelector('#appsTable')?.closest('.dataTables_wrapper') || document.querySelector('#appsTable')?.closest('.table-responsive');
    if (addBtn && addCard) {
        addBtn.addEventListener('click', () => {
            addCard.classList.remove('d-none');
            // hide table and controls while adding
            if (tableWrapper) tableWrapper.classList.add('d-none');
            // focus first field
            document.getElementById('appTitle')?.focus();
            addCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }
    // Close handlers
    [closeAddBtn, cancelAddBtn].forEach(btn => {
        btn?.addEventListener('click', () => {
            addCard?.classList.add('d-none');
            if (tableWrapper) tableWrapper.classList.remove('d-none');
            resetAddForm();
        });
    });
    // loadStatistics(); // disabled - stats section removed
    loadApps();
}

/**
 * Initialize DataTables
 */
function initializeDataTable() {
    appsTable = $('#appsTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']], // Sort by ID
        columnDefs: [
            { orderable: false, targets: [1, 5] }, // Disable sorting for icon and actions
            { searchable: false, targets: [1, 5] }, // Disable search for icon and actions
            { width: "60px", targets: [0] }, // ID
            { width: "80px", targets: [1] }, // Icon
            { width: "100px", targets: [3] }, // Version
            { width: "90px", targets: [4] }, // Downloads
            { width: "120px", targets: [5] } // Actions
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        drawCallback: function() {
            initializeTooltips();
        }
    });
}

/**
 * Initialize event listeners
 */
function initializeEventListeners() {
    // Icon preview functionality (guarded)
    const appIconEl = document.getElementById('appIcon');
    if (appIconEl) {
        appIconEl.addEventListener('input', function() {
            updateIconPreview(this.value, 'appIconPreview');
        });
    }

    const editAppIconEl = document.getElementById('editAppIcon');
    if (editAppIconEl) {
        editAppIconEl.addEventListener('input', function() {
            updateIconPreview(this.value, 'editAppIconPreview');
        });
    }
    
    // Form submissions (guarded)
    const addForm = document.getElementById('addAppForm');
    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            e.preventDefault();
            saveApp();
        });
    }
    
    const editForm = document.getElementById('editAppForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updateApp();
        });
    }
    
    // Modal events (guarded)
    const addModal = document.getElementById('addAppModal');
    if (addModal) {
        addModal.addEventListener('hidden.bs.modal', function() {
            resetAddForm();
        });
    }
    
    const editModal = document.getElementById('editAppModal');
    if (editModal) {
        editModal.addEventListener('hidden.bs.modal', function() {
            resetEditForm();
        });
    }
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
            total_apps: 8,
            active_apps: 6,
            utility_apps: 3,
            total_downloads: 1250
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
    document.getElementById('totalApps').textContent = stats.total_apps || 0;
    document.getElementById('activeApps').textContent = stats.active_apps || 0;
    document.getElementById('utilityApps').textContent = stats.utility_apps || 0;
    document.getElementById('totalDownloads').textContent = stats.total_downloads || 0;
}

/**
 * Load apps data
 */
async function loadApps() {
    try {
        showLoading();
        
        // Sample data - replace with actual API call
        const sampleApps = [
            {
                id: 1,
                title: "INLISLite Backup Tool",
                subtitle: "Database Backup Utility",
                description: "Tool untuk backup dan restore database INLISLite secara otomatis dengan scheduling.",
                category: "utility",
                icon: "bi-database",
                status: "active",
                version: "2.1.0",
                file_size: "3.2 MB",
                download_url: "https://example.com/backup-tool.zip",
                download_count: 450,
                sort_order: 1
            },
            {
                id: 2,
                title: "MARC21 Converter",
                subtitle: "Format Conversion Tool",
                description: "Konversi data katalog dari berbagai format ke MARC21 dan sebaliknya.",
                category: "tool",
                icon: "bi-arrow-left-right",
                status: "active",
                version: "1.5.2",
                file_size: "2.8 MB",
                download_url: "https://example.com/marc-converter.zip",
                download_count: 320,
                sort_order: 2
            },
            {
                id: 3,
                title: "Barcode Generator",
                subtitle: "Label & Barcode Creator",
                description: "Generate barcode dan label untuk koleksi perpustakaan dengan berbagai format.",
                category: "addon",
                icon: "bi-upc-scan",
                status: "active",
                version: "3.0.1",
                file_size: "1.9 MB",
                download_url: "https://example.com/barcode-gen.zip",
                download_count: 280,
                sort_order: 3
            }
        ];
        
        populateTable(sampleApps);
        
    } catch (error) {
        console.error('Error loading apps:', error);
        showError('Gagal memuat data aplikasi');
    } finally {
        hideLoading();
    }
}

/**
 * Populate DataTable with apps data
 */
function populateTable(apps) {
    appsTable.clear();
    
    apps.forEach(app => {
        const row = [
            app.id,
            `<div class="text-center">
                <i class="${app.icon}" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
            </div>`,
            `<div>
                <div class="fw-semibold">${app.title}</div>
                ${app.subtitle ? `<small class="text-muted">${app.subtitle}</small>` : ''}
            </div>`,
            app.version ? `<span class="version-badge">${app.version}</span>` : '-',
            app.download_count || 0,
            `<div class="d-flex justify-content-center">
                <button class="btn-action edit" onclick="editApp(${app.id})" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                ${app.download_url ? `<button class="btn-action download" onclick="downloadApp('${app.download_url}')" title="Download">
                    <i class="bi bi-download"></i>
                </button>` : ''}
                <button class="btn-action delete" onclick="deleteApp(${app.id})" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>`
        ];
        
        appsTable.row.add(row);
    });
    
    appsTable.draw();
}

/**
 * Get category label
 */
function getCategoryLabel(category) {
    const labels = {
        'utility': 'Utility',
        'addon': 'Add-on',
        'plugin': 'Plugin',
        'tool': 'Tool',
        'other': 'Lainnya'
    };
    return labels[category] || category;
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
 * Save new app
 */
async function saveApp() {
    try {
        const formData = {
            title: document.getElementById('appTitle').value,
            subtitle: document.getElementById('appSubtitle').value,
            description: document.getElementById('appDescription').value,
            category: document.getElementById('appCategory').value,
            icon: document.getElementById('appIcon').value,
            status: document.getElementById('appStatus').value,
            version: document.getElementById('appVersion').value,
            file_size: document.getElementById('appFileSize').value,
            download_url: document.getElementById('appDownloadUrl').value,
            sort_order: parseInt(document.getElementById('appSortOrder').value)
        };
        
        // Validate required fields
        if (!formData.title || !formData.description || !formData.category) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        // Ensure icon has bi- prefix
        if (formData.icon && !formData.icon.startsWith('bi-')) {
            formData.icon = `bi-${formData.icon}`;
        }
        
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Saving app:', formData);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Close modal and refresh data
        const modal = bootstrap.Modal.getInstance(document.getElementById('addAppModal'));
        modal.hide();
        
        showSuccess('Aplikasi berhasil ditambahkan');
        loadApps();
        loadStatistics();
        
    } catch (error) {
        console.error('Error saving app:', error);
        showError('Gagal menyimpan aplikasi');
    } finally {
        hideLoading();
    }
}

/**
 * Edit app
 */
function editApp(id) {
    // Sample data - replace with actual API call
    const sampleApps = [
        {
            id: 1,
            title: "INLISLite Backup Tool",
            subtitle: "Database Backup Utility",
            description: "Tool untuk backup dan restore database INLISLite secara otomatis dengan scheduling.",
            category: "utility",
            icon: "bi-database",
            status: "active",
            version: "2.1.0",
            file_size: "3.2 MB",
            download_url: "https://example.com/backup-tool.zip",
            sort_order: 1
        },
        {
            id: 2,
            title: "MARC21 Converter",
            subtitle: "Format Conversion Tool",
            description: "Konversi data katalog dari berbagai format ke MARC21 dan sebaliknya.",
            category: "tool",
            icon: "bi-arrow-left-right",
            status: "active",
            version: "1.5.2",
            file_size: "2.8 MB",
            download_url: "https://example.com/marc-converter.zip",
            sort_order: 2
        },
        {
            id: 3,
            title: "Barcode Generator",
            subtitle: "Label & Barcode Creator",
            description: "Generate barcode dan label untuk koleksi perpustakaan dengan berbagai format.",
            category: "addon",
            icon: "bi-upc-scan",
            status: "active",
            version: "3.0.1",
            file_size: "1.9 MB",
            download_url: "https://example.com/barcode-gen.zip",
            sort_order: 3
        }
    ];
    
    const app = sampleApps.find(a => a.id === id);
    
    if (!app) {
        showError('Aplikasi tidak ditemukan');
        return;
    }
    
    // Populate edit form
    currentEditId = id;
    document.getElementById('editAppId').value = id;
    document.getElementById('editAppTitle').value = app.title;
    document.getElementById('editAppSubtitle').value = app.subtitle || '';
    document.getElementById('editAppDescription').value = app.description;
    document.getElementById('editAppCategory').value = app.category;
    document.getElementById('editAppIcon').value = app.icon;
    document.getElementById('editAppStatus').value = app.status;
    document.getElementById('editAppVersion').value = app.version || '';
    document.getElementById('editAppFileSize').value = app.file_size || '';
    document.getElementById('editAppDownloadUrl').value = app.download_url || '';
    document.getElementById('editAppSortOrder').value = app.sort_order;
    
    // Update icon preview
    updateIconPreview(app.icon, 'editAppIconPreview');
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editAppModal'));
    modal.show();
}

/**
 * Update app
 */
async function updateApp() {
    try {
        const formData = {
            id: currentEditId,
            title: document.getElementById('editAppTitle').value,
            subtitle: document.getElementById('editAppSubtitle').value,
            description: document.getElementById('editAppDescription').value,
            category: document.getElementById('editAppCategory').value,
            icon: document.getElementById('editAppIcon').value,
            status: document.getElementById('editAppStatus').value,
            version: document.getElementById('editAppVersion').value,
            file_size: document.getElementById('editAppFileSize').value,
            download_url: document.getElementById('editAppDownloadUrl').value,
            sort_order: parseInt(document.getElementById('editAppSortOrder').value)
        };
        
        // Validate required fields
        if (!formData.title || !formData.description || !formData.category) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        // Ensure icon has bi- prefix
        if (formData.icon && !formData.icon.startsWith('bi-')) {
            formData.icon = `bi-${formData.icon}`;
        }
        
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Updating app:', formData);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Close modal and refresh data
        const modal = bootstrap.Modal.getInstance(document.getElementById('editAppModal'));
        modal.hide();
        
        showSuccess('Aplikasi berhasil diperbarui');
        loadApps();
        loadStatistics();
        
    } catch (error) {
        console.error('Error updating app:', error);
        showError('Gagal memperbarui aplikasi');
    } finally {
        hideLoading();
    }
}

/**
 * Delete app
 */
async function deleteApp(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus aplikasi ini?')) {
        return;
    }
    
    try {
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Deleting app:', id);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        showSuccess('Aplikasi berhasil dihapus');
        loadApps();
        loadStatistics();
        
    } catch (error) {
        console.error('Error deleting app:', error);
        showError('Gagal menghapus aplikasi');
    } finally {
        hideLoading();
    }
}

/**
 * Download app
 */
function downloadApp(url) {
    if (url) {
        window.open(url, '_blank');
    } else {
        showError('URL download tidak tersedia');
    }
}

/**
 * Reset add form
 */
function resetAddForm() {
    document.getElementById('addAppForm').reset();
    document.getElementById('appSortOrder').value = 1;
    updateIconPreview('', 'appIconPreview');
}

/**
 * Reset edit form
 */
function resetEditForm() {
    document.getElementById('editAppForm').reset();
    currentEditId = null;
    updateIconPreview('', 'editAppIconPreview');
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
window.saveApp = saveApp;
window.editApp = editApp;
window.updateApp = updateApp;
window.deleteApp = deleteApp;
window.downloadApp = downloadApp;