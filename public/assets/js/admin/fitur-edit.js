/**
 * INLISLite v3.0 Features & Modules Management
 * CRUD operations with DataTables integration
 */

// Global variables
let features = [];
let modules = [];
let featuresTable;
let modulesTable;

// Initialize when DOM is loaded
$(document).ready(function() {
    initializeApp();
});

/**
 * Initialize the application
 */
function initializeApp() {
    loadData();
    initializeDataTables();
    initializeEventListeners();
    initializeIconPreviews();
}

/**
 * Load initial data
 */
async function loadData() {
    try {
        showLoading();
        
        // Load sample data (replace with actual API calls)
        await loadFeatures();
        await loadModules();
        
        updateStatistics();
        
    } catch (error) {
        console.error('Error loading data:', error);
        showError('Gagal memuat data');
    } finally {
        hideLoading();
    }
}

/**
 * Load features data
 */
async function loadFeatures() {
    // Sample data - replace with actual API call
    features = [
        {
            id: 1,
            title: "Form Entri Katalog Sederhana",
            description: "Menyediakan form entri katalog berbasis MARC yang disederhanakan untuk memudahkan pustakawan dalam menginput data bibliografi dengan cepat dan akurat.",
            icon: "bi-file-text",
            color: "blue",
            type: "feature"
        },
        {
            id: 2,
            title: "Kardek Terbitan Teknologi",
            description: "Fitur back-end untuk mendukung pengelolaan koleksi berbasis teknologi dengan sistem tracking dan monitoring yang terintegrasi.",
            icon: "bi-cpu",
            color: "green",
            type: "feature"
        },
        {
            id: 3,
            title: "Sistem Sirkulasi Otomatis",
            description: "Manajemen peminjaman dan pengembalian buku secara otomatis dengan notifikasi real-time dan sistem denda terintegrasi.",
            icon: "bi-arrow-repeat",
            color: "blue",
            type: "feature"
        },
        {
            id: 4,
            title: "OPAC (Online Public Access Catalog)",
            description: "Katalog online yang memungkinkan pengguna mencari dan mengakses informasi koleksi perpustakaan dari mana saja.",
            icon: "bi-search",
            color: "orange",
            type: "feature"
        },
        {
            id: 5,
            title: "Manajemen Keanggotaan",
            description: "Sistem pengelolaan data anggota perpustakaan dengan fitur registrasi online, perpanjangan membership, dan kartu anggota digital.",
            icon: "bi-people",
            color: "purple",
            type: "feature"
        },
        {
            id: 6,
            title: "Laporan dan Statistik",
            description: "Sistem pelaporan komprehensif dengan dashboard analitik untuk monitoring aktivitas perpustakaan dan pengambilan keputusan.",
            icon: "bi-graph-up",
            color: "green",
            type: "feature"
        }
    ];
}

/**
 * Load modules data
 */
async function loadModules() {
    // Sample data - replace with actual API call
    modules = [
        {
            id: 1,
            title: "Portal Aplikasi Inlislite",
            description: "Navigasi utama ke semua modul sistem dengan dashboard terpusat dan akses cepat ke fitur-fitur utama.",
            icon: "bi-house-door",
            color: "green",
            type: "module",
            module_type: "application"
        },
        {
            id: 2,
            title: "Back Office",
            description: "Manajemen data perpustakaan internal termasuk pengaturan sistem, konfigurasi, dan administrasi pengguna.",
            icon: "bi-gear",
            color: "blue",
            type: "module",
            module_type: "application"
        },
        {
            id: 3,
            title: "Modul Katalogisasi",
            description: "Sistem katalogisasi lengkap dengan standar MARC21, Dublin Core, dan format metadata internasional lainnya.",
            icon: "bi-book",
            color: "blue",
            type: "module",
            module_type: "application"
        },
        {
            id: 4,
            title: "Database Management System",
            description: "Sistem manajemen database yang robust dengan fitur backup otomatis, replikasi, dan optimasi performa.",
            icon: "bi-database",
            color: "green",
            type: "module",
            module_type: "database"
        },
        {
            id: 5,
            title: "API Gateway",
            description: "Interface pemrograman aplikasi untuk integrasi dengan sistem eksternal dan pengembangan aplikasi pihak ketiga.",
            icon: "bi-cloud",
            color: "green",
            type: "module",
            module_type: "database"
        },
        {
            id: 6,
            title: "Mobile Application",
            description: "Aplikasi mobile untuk akses perpustakaan digital dengan fitur pencarian, peminjaman, dan notifikasi push.",
            icon: "bi-phone",
            color: "orange",
            type: "module",
            module_type: "application"
        }
    ];
}

/**
 * Initialize DataTables
 */
function initializeDataTables() {
    // Features table
    featuresTable = $('#featuresTable').DataTable({
        data: features,
        columns: [
            { data: 'id', width: '60px' },
            { 
                data: 'icon',
                width: '80px',
                render: function(data, type, row) {
                    return `<div class="icon-preview ${row.color}"><i class="${data}"></i></div>`;
                }
            },
            { data: 'title' },
            { 
                data: 'description',
                render: function(data, type, row) {
                    return data.length > 100 ? data.substring(0, 100) + '...' : data;
                }
            },
            { 
                data: 'color',
                width: '80px',
                render: function(data, type, row) {
                    return `<span class="color-badge ${data}"></span> ${data}`;
                }
            },
            { 
                data: null,
                width: '120px',
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn-action edit" onclick="editItem(${row.id}, 'feature')" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn-action delete" onclick="deleteItem(${row.id}, 'feature')" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                }
            }
        ],
        pageLength: 10,
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        }
    });

    // Modules table
    modulesTable = $('#modulesTable').DataTable({
        data: modules,
        columns: [
            { data: 'id', width: '60px' },
            { 
                data: 'icon',
                width: '80px',
                render: function(data, type, row) {
                    return `<div class="icon-preview ${row.color}"><i class="${data}"></i></div>`;
                }
            },
            { data: 'title' },
            { 
                data: 'description',
                render: function(data, type, row) {
                    return data.length > 100 ? data.substring(0, 100) + '...' : data;
                }
            },
            { 
                data: 'module_type',
                width: '120px',
                render: function(data, type, row) {
                    return `<span class="type-badge ${data}">${data}</span>`;
                }
            },
            { 
                data: 'color',
                width: '80px',
                render: function(data, type, row) {
                    return `<span class="color-badge ${data}"></span> ${data}`;
                }
            },
            { 
                data: null,
                width: '120px',
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn-action edit" onclick="editItem(${row.id}, 'module')" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn-action delete" onclick="deleteItem(${row.id}, 'module')" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                }
            }
        ],
        pageLength: 10,
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        }
    });
}

/**
 * Initialize event listeners
 */
function initializeEventListeners() {
    // Form submissions
    $('#addFeatureForm').on('submit', function(e) {
        e.preventDefault();
        saveFeature();
    });

    $('#addModuleForm').on('submit', function(e) {
        e.preventDefault();
        saveModule();
    });

    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        updateItem();
    });

    // Tab switching
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        // Redraw tables when tab is shown
        if (e.target.id === 'features-tab') {
            featuresTable.columns.adjust().draw();
        } else if (e.target.id === 'modules-tab') {
            modulesTable.columns.adjust().draw();
        }
    });
}

/**
 * Initialize icon previews
 */
function initializeIconPreviews() {
    // Feature icon preview
    $('#featureIcon').on('input', function() {
        updateIconPreview('featureIconPreview', this.value, $('#featureColor').val());
    });

    $('#featureColor').on('change', function() {
        updateIconPreview('featureIconPreview', $('#featureIcon').val(), this.value);
    });

    // Module icon preview
    $('#moduleIcon').on('input', function() {
        updateIconPreview('moduleIconPreview', this.value, $('#moduleColor').val());
    });

    $('#moduleColor').on('change', function() {
        updateIconPreview('moduleIconPreview', $('#moduleIcon').val(), this.value);
    });

    // Edit icon preview
    $('#editIcon').on('input', function() {
        updateIconPreview('editIconPreview', this.value, $('#editColor').val());
    });

    $('#editColor').on('change', function() {
        updateIconPreview('editIconPreview', $('#editIcon').val(), this.value);
    });
}

/**
 * Update icon preview
 */
function updateIconPreview(previewId, iconClass, color) {
    const preview = document.getElementById(previewId);
    if (!preview) return;

    const icon = preview.querySelector('i');
    
    // Update icon class
    icon.className = iconClass.startsWith('bi-') ? iconClass : `bi-${iconClass}`;
    
    // Update color
    preview.className = `icon-preview ${color || ''}`;
}

/**
 * Update statistics
 */
function updateStatistics() {
    document.getElementById('totalFeatures').textContent = features.length;
    document.getElementById('totalModules').textContent = modules.length;
    
    const appModules = modules.filter(m => m.module_type === 'application').length;
    const dbModules = modules.filter(m => m.module_type === 'database').length;
    
    document.getElementById('appModules').textContent = appModules;
    document.getElementById('dbModules').textContent = dbModules;
}

/**
 * Save new feature
 */
async function saveFeature() {
    try {
        const title = $('#featureTitle').val();
        const description = $('#featureDescription').val();
        const icon = $('#featureIcon').val();
        const color = $('#featureColor').val();

        if (!title || !description || !icon || !color) {
            showError('Semua field harus diisi');
            return;
        }

        showLoading();

        const newFeature = {
            id: Date.now(),
            title,
            description,
            icon: icon.startsWith('bi-') ? icon : `bi-${icon}`,
            color,
            type: 'feature'
        };

        // TODO: Replace with actual API call
        features.push(newFeature);
        
        // Update DataTable
        featuresTable.row.add(newFeature).draw();
        
        // Update statistics
        updateStatistics();

        // Close modal and reset form
        $('#addFeatureModal').modal('hide');
        $('#addFeatureForm')[0].reset();
        updateIconPreview('featureIconPreview', '', '');

        showSuccess('Fitur berhasil ditambahkan');

    } catch (error) {
        console.error('Error saving feature:', error);
        showError('Gagal menyimpan fitur');
    } finally {
        hideLoading();
    }
}

/**
 * Save new module
 */
async function saveModule() {
    try {
        const title = $('#moduleTitle').val();
        const description = $('#moduleDescription').val();
        const icon = $('#moduleIcon').val();
        const color = $('#moduleColor').val();
        const moduleType = $('#moduleType').val();

        if (!title || !description || !icon || !color || !moduleType) {
            showError('Semua field harus diisi');
            return;
        }

        showLoading();

        const newModule = {
            id: Date.now(),
            title,
            description,
            icon: icon.startsWith('bi-') ? icon : `bi-${icon}`,
            color,
            type: 'module',
            module_type: moduleType
        };

        // TODO: Replace with actual API call
        modules.push(newModule);
        
        // Update DataTable
        modulesTable.row.add(newModule).draw();
        
        // Update statistics
        updateStatistics();

        // Close modal and reset form
        $('#addModuleModal').modal('hide');
        $('#addModuleForm')[0].reset();
        updateIconPreview('moduleIconPreview', '', '');

        showSuccess('Modul berhasil ditambahkan');

    } catch (error) {
        console.error('Error saving module:', error);
        showError('Gagal menyimpan modul');
    } finally {
        hideLoading();
    }
}

/**
 * Edit item
 */
function editItem(id, type) {
    const item = type === 'feature' 
        ? features.find(f => f.id === id)
        : modules.find(m => m.id === id);

    if (!item) {
        showError('Item tidak ditemukan');
        return;
    }

    // Populate form
    $('#editId').val(id);
    $('#editType').val(type);
    $('#editTitle').val(item.title);
    $('#editDescription').val(item.description);
    $('#editIcon').val(item.icon);
    $('#editColor').val(item.color);

    // Show/hide module type field
    if (type === 'module') {
        $('#editTypeContainer').show();
        $('#editModuleType').val(item.module_type || 'application');
    } else {
        $('#editTypeContainer').hide();
    }

    // Update modal title and icon preview
    $('#editModalTitle').text(type === 'feature' ? 'Edit Fitur' : 'Edit Modul');
    updateIconPreview('editIconPreview', item.icon, item.color);

    // Show modal
    $('#editModal').modal('show');
}

/**
 * Update item
 */
async function updateItem() {
    try {
        const id = parseInt($('#editId').val());
        const type = $('#editType').val();
        const title = $('#editTitle').val();
        const description = $('#editDescription').val();
        const icon = $('#editIcon').val();
        const color = $('#editColor').val();

        if (!title || !description || !icon || !color) {
            showError('Semua field harus diisi');
            return;
        }

        showLoading();

        const updatedItem = {
            id,
            title,
            description,
            icon: icon.startsWith('bi-') ? icon : `bi-${icon}`,
            color,
            type
        };

        if (type === 'module') {
            updatedItem.module_type = $('#editModuleType').val();
        }

        // Update in arrays
        if (type === 'feature') {
            const index = features.findIndex(f => f.id === id);
            if (index !== -1) {
                features[index] = updatedItem;
                
                // Update DataTable
                featuresTable.row(function(idx, data) {
                    return data.id === id;
                }).data(updatedItem).draw();
            }
        } else {
            const index = modules.findIndex(m => m.id === id);
            if (index !== -1) {
                modules[index] = updatedItem;
                
                // Update DataTable
                modulesTable.row(function(idx, data) {
                    return data.id === id;
                }).data(updatedItem).draw();
            }
        }

        // Update statistics
        updateStatistics();

        // Close modal
        $('#editModal').modal('hide');

        showSuccess(`${type === 'feature' ? 'Fitur' : 'Modul'} berhasil diperbarui`);

    } catch (error) {
        console.error('Error updating item:', error);
        showError('Gagal memperbarui item');
    } finally {
        hideLoading();
    }
}

/**
 * Delete item
 */
async function deleteItem(id, type) {
    if (!confirm(`Apakah Anda yakin ingin menghapus ${type === 'feature' ? 'fitur' : 'modul'} ini?`)) {
        return;
    }

    try {
        showLoading();

        // Remove from arrays
        if (type === 'feature') {
            features = features.filter(f => f.id !== id);
            
            // Remove from DataTable
            featuresTable.row(function(idx, data) {
                return data.id === id;
            }).remove().draw();
        } else {
            modules = modules.filter(m => m.id !== id);
            
            // Remove from DataTable
            modulesTable.row(function(idx, data) {
                return data.id === id;
            }).remove().draw();
        }

        // Update statistics
        updateStatistics();

        showSuccess(`${type === 'feature' ? 'Fitur' : 'Modul'} berhasil dihapus`);

    } catch (error) {
        console.error('Error deleting item:', error);
        showError('Gagal menghapus item');
    } finally {
        hideLoading();
    }
}

/**
 * Show loading spinner
 */
function showLoading() {
    $('#loadingSpinner').show();
}

/**
 * Hide loading spinner
 */
function hideLoading() {
    $('#loadingSpinner').hide();
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
    const toast = $(`
        <div class="toast-notification toast-${type}">
            <div class="toast-content">
                <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
            <button class="toast-close">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `);

    // Add styles if not already added
    if (!$('#toast-styles').length) {
        $('head').append(`
            <style id="toast-styles">
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
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            </style>
        `);
    }

    // Add to DOM
    $('body').append(toast);

    // Close button functionality
    toast.find('.toast-close').on('click', function() {
        toast.remove();
    });

    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.fadeOut(300, function() {
            $(this).remove();
        });
    }, 5000);
}

// Export functions for global access
window.editItem = editItem;
window.deleteItem = deleteItem;
window.saveFeature = saveFeature;
window.saveModule = saveModule;
window.updateItem = updateItem;