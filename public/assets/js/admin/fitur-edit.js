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
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

/**
 * Initialize the application
 */
async function initializeApp() {
    showLoading();
    
    try {
        // Load data from database
        await loadFeatures();
        await loadModules();
        
        // Initialize UI components
        initializeDataTables();
        updateStats();
        initializeEventListeners();
        initializeIconPreviews();
        
        console.log('Application initialized successfully');
    } catch (error) {
        console.error('Error initializing application:', error);
        // Fallback to sample data if database fails
        loadSampleData();
        initializeDataTables();
        updateStats();
        initializeEventListeners();
        initializeIconPreviews();
    } finally {
        hideLoading();
    }
}

/**
 * Load sample data for demonstration
 */
function loadSampleData() {
    // Sample features data
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
            title: "Sistem Sirkulasi Otomatis",
            description: "Manajemen peminjaman dan pengembalian buku secara otomatis dengan notifikasi real-time dan sistem denda terintegrasi.",
            icon: "bi-arrow-repeat",
            color: "green",
            type: "feature"
        },
        {
            id: 3,
            title: "OPAC (Online Public Access Catalog)",
            description: "Katalog online yang memungkinkan pengguna mencari dan mengakses informasi koleksi perpustakaan dari mana saja.",
            icon: "bi-search",
            color: "orange",
            type: "feature"
        }
    ];
    
    // Sample modules data
    modules = [
        {
            id: 1,
            title: "Portal Aplikasi Inlislite",
            description: "Navigasi utama ke semua modul sistem dengan dashboard terpusat dan akses cepat ke fitur-fitur utama.",
            icon: "bi-house-door",
            color: "blue",
            type: "module",
            module_type: "application"
        },
        {
            id: 2,
            title: "Database Management System",
            description: "Sistem manajemen database yang robust dengan fitur backup otomatis, replikasi, dan optimasi performa.",
            icon: "bi-database",
            color: "purple",
            type: "module",
            module_type: "database"
        },
        {
            id: 3,
            title: "Backup Utility",
            description: "Utilitas backup otomatis untuk menjaga keamanan data dengan penjadwalan backup yang fleksibel.",
            icon: "bi-shield-check",
            color: "green",
            type: "module",
            module_type: "utility"
        }
    ];
}

/**
 * Load features data
 */
async function loadFeatures() {
    try {
        const response = await fetch(`${window.baseUrl || ''}/admin/fitur/data?type=feature`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const result = await response.json();
        
        if (result.success) {
            features = result.data || [];
            console.log('Features loaded successfully:', features.length, 'items');
        } else {
            console.error('Failed to load features:', result.message);
            throw new Error(result.message || 'Failed to load features');
        }
    } catch (error) {
        console.error('Error loading features:', error);
        console.log('Using fallback sample data for features');
        // Fallback to sample data
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
}

/**
 * Load modules data
 */
async function loadModules() {
    try {
        const response = await fetch(`${window.baseUrl || ''}/admin/fitur/data?type=module`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const result = await response.json();
        
        if (result.success) {
            modules = result.data || [];
            console.log('Modules loaded successfully:', modules.length, 'items');
        } else {
            console.error('Failed to load modules:', result.message);
            throw new Error(result.message || 'Failed to load modules');
        }
    } catch (error) {
        console.error('Error loading modules:', error);
        console.log('Using fallback sample data for modules');
        // Fallback to sample data
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
                width: '200px',
                render: function(data, type, row) {
                    if (!data) return '';
                    return data.length > 80 ? data.substring(0, 80) + '...' : data;
                }
            },
            { 
                data: 'color',
                width: '80px',
                render: function(data, type, row) {
                    return `<div style="display: flex; align-items: center;"><span class="color-badge ${data}"></span>${data}</div>`;
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
                width: '180px',
                render: function(data, type, row) {
                    if (!data) return '';
                    return data.length > 60 ? data.substring(0, 60) + '...' : data;
                }
            },
            { 
                data: 'module_type',
                width: '120px',
                render: function(data, type, row) {
                    if (!data) return '<span class="type-badge">-</span>';
                    return `<span class="type-badge ${data}">${data}</span>`;
                }
            },
            { 
                data: 'color',
                width: '80px',
                render: function(data, type, row) {
                    return `<div style="display: flex; align-items: center;"><span class="color-badge ${data}"></span>${data}</div>`;
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
 * Load statistics from API
 */
async function loadStatistics() {
    try {
        const response = await fetch(`${window.baseUrl || ''}/admin/fitur/statistics`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const result = await response.json();
        
        if (result.success) {
            const stats = result.data;
            document.getElementById('totalFeatures').textContent = stats.total_features || 0;
            document.getElementById('totalModules').textContent = stats.total_modules || 0;
            document.getElementById('appModules').textContent = stats.app_modules || 0;
            document.getElementById('dbModules').textContent = stats.db_modules || 0;
            console.log('Statistics loaded successfully:', stats);
        } else {
            console.error('Failed to load statistics:', result.message);
            updateStatistics(); // Fallback to local calculation
        }
    } catch (error) {
        console.error('Error loading statistics:', error);
        console.log('Using local statistics calculation');
        updateStatistics(); // Fallback to local calculation
    }
}

/**
 * Update statistics (fallback method)
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

        const featureData = {
            title,
            description,
            icon: icon.startsWith('bi-') ? icon : `bi-${icon}`,
            color,
            type: 'feature'
        };

        // Save to database via API
        const response = await fetch(`${window.baseUrl || ''}/admin/fitur/store`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams(featureData)
        });

        const result = await response.json();

        if (result.success) {
            // Add to local array and refresh table
            features.push(result.data);
            featuresTable.row.add(result.data).draw();
        } else {
            throw new Error(result.message || 'Gagal menyimpan fitur');
        }
        
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

        const moduleData = {
            title,
            description,
            icon: icon.startsWith('bi-') ? icon : `bi-${icon}`,
            color,
            type: 'module',
            module_type: moduleType
        };

        // Save to database via API
        const response = await fetch(`${window.baseUrl || ''}/admin/fitur/store`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams(moduleData)
        });

        const result = await response.json();

        if (result.success) {
            // Add to local array and refresh table
            modules.push(result.data);
            modulesTable.row.add(result.data).draw();
        } else {
            throw new Error(result.message || 'Gagal menyimpan modul');
        }
        
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
    console.log('EditItem called with ID:', id, 'Type:', type);
    console.log('Available features:', features.length, 'Available modules:', modules.length);
    
    const item = type === 'feature' 
        ? features.find(f => f.id == id)  // Use == for type coercion
        : modules.find(m => m.id == id);

    console.log('Found item:', item);

    if (!item) {
        showError('Item tidak ditemukan. ID: ' + id + ', Type: ' + type);
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

        // Update via API
        const response = await fetch(`${window.baseUrl || ''}/admin/fitur/update/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams(updatedItem)
        });

        const result = await response.json();

        if (result.success) {
            // Update in arrays
            if (type === 'feature') {
                const index = features.findIndex(f => f.id == id);  // Use == for type coercion
                if (index !== -1) {
                    features[index] = result.data;
                    
                    // Update DataTable
                    featuresTable.row(function(idx, data) {
                        return data.id == id;  // Use == for type coercion
                    }).data(result.data).draw();
                }
            } else {
                const index = modules.findIndex(m => m.id == id);  // Use == for type coercion
                if (index !== -1) {
                    modules[index] = result.data;
                    
                    // Update DataTable
                    modulesTable.row(function(idx, data) {
                        return data.id == id;  // Use == for type coercion
                    }).data(result.data).draw();
                }
            }
        } else {
            throw new Error(result.message || 'Gagal memperbarui item');
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
    console.log('DeleteItem called with ID:', id, 'Type:', type);
    
    if (!confirm(`Apakah Anda yakin ingin menghapus ${type === 'feature' ? 'fitur' : 'modul'} ini?`)) {
        return;
    }

    try {
        showLoading();

        // Delete via API
        const response = await fetch(`${window.baseUrl || ''}/admin/fitur/delete/${id}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (result.success) {
            // Remove from arrays
            if (type === 'feature') {
                features = features.filter(f => f.id != id);  // Use != for type coercion
                
                // Remove from DataTable
                featuresTable.row(function(idx, data) {
                    return data.id == id;  // Use == for type coercion
                }).remove().draw();
            } else {
                modules = modules.filter(m => m.id != id);  // Use != for type coercion
                
                // Remove from DataTable
                modulesTable.row(function(idx, data) {
                    return data.id == id;  // Use == for type coercion
                }).remove().draw();
            }

            // Update statistics
            updateStatistics();

            // Reorder items after deletion to avoid gaps in sort_order
            await reorderItems(type);

            showSuccess(result.message || `${type === 'feature' ? 'Fitur' : 'Modul'} berhasil dihapus`);
        } else {
            throw new Error(result.message || 'Gagal menghapus item');
        }

    } catch (error) {
        console.error('Error deleting item:', error);
        showError('Gagal menghapus item');
    } finally {
        hideLoading();
    }
}

/**
 * Reorder items after deletion to maintain sequential sort_order
 */
async function reorderItems(type) {
    try {
        console.log(`Reordering ${type} items...`);
        
        const currentItems = type === 'feature' ? features : modules;
        
        // Sort items by current sort_order or by id if sort_order is missing
        currentItems.sort((a, b) => {
            const aOrder = a.sort_order || a.id;
            const bOrder = b.sort_order || b.id;
            return aOrder - bOrder;
        });
        
        // Create array of items with new sequential order
        const reorderedItems = currentItems.map((item, index) => ({
            id: item.id,
            sort_order: index + 1
        }));
        
        // Only proceed if we have items to reorder
        if (reorderedItems.length === 0) {
            console.log(`No ${type} items to reorder`);
            return;
        }
        
        // Send to backend API for persistence
        const response = await fetch(`${window.baseUrl || ''}/admin/fitur/updateSortOrder`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                items: JSON.stringify(reorderedItems)
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            console.log(`Successfully reordered ${reorderedItems.length} ${type} items`);
            
            // Update local arrays with new sort_order values
            reorderedItems.forEach(reorderedItem => {
                const item = currentItems.find(i => i.id === reorderedItem.id);
                if (item) {
                    item.sort_order = reorderedItem.sort_order;
                }
            });
            
            // Refresh the DataTable to reflect new ordering
            const table = type === 'feature' ? featuresTable : modulesTable;
            table.clear().rows.add(currentItems).draw();
            
        } else {
            console.error(`Failed to reorder ${type} items:`, result.message);
            throw new Error(result.message || `Failed to reorder ${type} items`);
        }
        
    } catch (error) {
        console.error(`Error reordering ${type} items:`, error);
        // Don't show error to user as this is a background operation
        // Just log it for debugging
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

/**
 * Refresh modules data
 */
async function refreshModulesData() {
    try {
        showLoading();
        
        // Reload modules data
        await loadModules();
        
        // Update modules table
        if (modulesTable && modules.length > 0) {
            modulesTable.clear().rows.add(modules).draw();
        }
        
        // Update statistics
        await loadStatistics();
        
        showSuccess('Data modul berhasil diperbarui');
        
    } catch (error) {
        console.error('Error refreshing modules data:', error);
        showError('Gagal memperbarui data modul');
    } finally {
        hideLoading();
    }
}

/**
 * Enhanced toast notification with better styling
 */
function showToast(message, type = 'info') {
    // Create toast element with enhanced styling
    const toast = $(`
        <div class="toast-notification toast-${type} animate-fade-in">
            <div class="toast-content">
                <div class="toast-icon">
                    <i class="bi bi-${type === 'success' ? 'check-circle-fill' : type === 'error' ? 'exclamation-triangle-fill' : 'info-circle-fill'}"></i>
                </div>
                <div class="toast-message">
                    <span class="toast-title">${type === 'success' ? 'Berhasil' : type === 'error' ? 'Error' : 'Info'}</span>
                    <span class="toast-text">${message}</span>
                </div>
            </div>
            <button class="toast-close">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `);

    // Add enhanced styles if not already added
    if (!$('#enhanced-toast-styles').length) {
        $('head').append(`
            <style id="enhanced-toast-styles">
                .toast-notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 10000;
                    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                    border-radius: 12px;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                    padding: 1rem 1.5rem;
                    display: flex;
                    align-items: flex-start;
                    gap: 1rem;
                    min-width: 320px;
                    max-width: 400px;
                    animation: slideInRight 0.3s ease-out;
                    border-left: 4px solid #6b7280;
                    backdrop-filter: blur(10px);
                }
                .toast-success { border-left-color: #059669; }
                .toast-error { border-left-color: #dc2626; }
                .toast-info { border-left-color: #2563eb; }
                .toast-content {
                    display: flex;
                    align-items: flex-start;
                    gap: 0.75rem;
                    flex: 1;
                }
                .toast-icon {
                    font-size: 1.25rem;
                    margin-top: 0.125rem;
                }
                .toast-success .toast-icon { color: #059669; }
                .toast-error .toast-icon { color: #dc2626; }
                .toast-info .toast-icon { color: #2563eb; }
                .toast-message {
                    display: flex;
                    flex-direction: column;
                    gap: 0.25rem;
                }
                .toast-title {
                    font-weight: 600;
                    font-size: 0.875rem;
                    color: #374151;
                }
                .toast-text {
                    font-size: 0.875rem;
                    color: #6b7280;
                    line-height: 1.4;
                }
                .toast-close {
                    background: none;
                    border: none;
                    color: #9ca3af;
                    cursor: pointer;
                    padding: 0.25rem;
                    border-radius: 6px;
                    font-size: 1rem;
                    transition: all 0.2s ease;
                }
                .toast-close:hover {
                    background-color: #f3f4f6;
                    color: #6b7280;
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
        toast.addClass('animate-fade-out');
        setTimeout(() => toast.remove(), 300);
    });

    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.addClass('animate-fade-out');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

/**
 * Table data rendering functions
 */
function renderTableData() {
    renderFeaturesTable();
    renderModulesTable();
}

function renderFeaturesTable() {
    const tbody = document.querySelector('#featuresTable tbody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    features.forEach((feature, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="text-center">${index + 1}</td>
            <td class="text-center">
                <div class="table-icon ${feature.color}">
                    <i class="${feature.icon}"></i>
                </div>
            </td>
            <td class="fw-medium">${feature.title}</td>
            <td>
                <div class="description-text">${feature.description}</div>
            </td>
            <td class="text-center">
                <div class="color-indicator ${feature.color}"></div>
            </td>
            <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                    <button class="btn-action-compact btn-edit" onclick="editFeature(${feature.id})" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn-action-compact btn-delete" onclick="deleteFeature(${feature.id})" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function renderModulesTable() {
    const tbody = document.querySelector('#modulesTable tbody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    modules.forEach((module, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="text-center">${index + 1}</td>
            <td class="text-center">
                <div class="table-icon ${module.color}">
                    <i class="${module.icon}"></i>
                </div>
            </td>
            <td class="fw-medium">${module.title}</td>
            <td>
                <div class="description-text">${module.description}</div>
            </td>
            <td class="text-center">
                <span class="badge-compact bg-${getTypeBadgeColor(module.module_type || 'utility')}">
                    ${(module.module_type || 'utility').toUpperCase()}
                </span>
            </td>
            <td class="text-center">
                <div class="color-indicator ${module.color}"></div>
            </td>
            <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                    <button class="btn-action-compact btn-edit" onclick="editModule(${module.id})" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn-action-compact btn-delete" onclick="deleteModule(${module.id})" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function getTypeBadgeColor(type) {
    switch(type) {
        case 'database': return 'purple';
        case 'application': return 'primary';
        case 'utility': return 'warning';
        default: return 'secondary';
    }
}

function editFeature(id) {
    const feature = features.find(f => f.id === id);
    if (!feature) {
        showError('Fitur tidak ditemukan');
        return;
    }
    
    // Populate edit form
    document.getElementById('editId').value = id;
    document.getElementById('editType').value = 'feature';
    document.getElementById('editTitle').value = feature.title;
    document.getElementById('editDescription').value = feature.description;
    document.getElementById('editIcon').value = feature.icon;
    document.getElementById('editColor').value = feature.color;
    
    // Hide module type field
    document.getElementById('editTypeContainer').style.display = 'none';
    
    // Update modal title
    document.getElementById('editModalTitle').textContent = 'Edit Fitur';
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}

function editModule(id) {
    const module = modules.find(m => m.id === id);
    if (!module) {
        showError('Modul tidak ditemukan');
        return;
    }
    
    // Populate edit form
    document.getElementById('editId').value = id;
    document.getElementById('editType').value = 'module';
    document.getElementById('editTitle').value = module.title;
    document.getElementById('editDescription').value = module.description;
    document.getElementById('editIcon').value = module.icon;
    document.getElementById('editColor').value = module.color;
    document.getElementById('editModuleType').value = module.module_type || 'utility';
    
    // Show module type field
    document.getElementById('editTypeContainer').style.display = 'block';
    
    // Update modal title
    document.getElementById('editModalTitle').textContent = 'Edit Modul';
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}

function deleteFeature(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus fitur ini?')) {
        return;
    }
    
    features = features.filter(f => f.id !== id);
    renderFeaturesTable();
    updateStats();
    showSuccess('Fitur berhasil dihapus');
}

function deleteModule(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus modul ini?')) {
        return;
    }
    
    modules = modules.filter(m => m.id !== id);
    renderModulesTable();
    updateStats();
    showSuccess('Modul berhasil dihapus');
}

function updateStats() {
    const totalFeatures = document.getElementById('totalFeatures');
    const totalModules = document.getElementById('totalModules');
    const appModules = document.getElementById('appModules');
    const dbModules = document.getElementById('dbModules');
    
    if (totalFeatures) totalFeatures.textContent = features.length;
    if (totalModules) totalModules.textContent = modules.length;
    if (appModules) appModules.textContent = modules.filter(m => m.module_type === 'application').length;
    if (dbModules) dbModules.textContent = modules.filter(m => m.module_type === 'database').length;
}

// Update existing functions to use new rendering
const originalSaveFeature = saveFeature;
const originalSaveModule = saveModule;
const originalUpdateItem = updateItem;

saveFeature = function() {
    const result = originalSaveFeature.call(this);
    renderFeaturesTable();
    updateStats();
    return result;
};

saveModule = function() {
    const result = originalSaveModule.call(this);
    renderModulesTable();
    updateStats();
    return result;
};

updateItem = function() {
    const result = originalUpdateItem.call(this);
    renderTableData();
    updateStats();
    return result;
};

// Initialize table rendering on load
document.addEventListener('DOMContentLoaded', function() {
    // Add sample data for demonstration
    features = [
        {
            id: 1,
            title: "Katalog Online",
            description: "Sistem katalog online yang memungkinkan pengguna mencari dan menelusuri koleksi perpustakaan secara digital dengan interface yang user-friendly dan fitur pencarian yang canggih",
            icon: "bi-search",
            color: "blue"
        },
        {
            id: 2,
            title: "Sistem Sirkulasi",
            description: "Modul sirkulasi untuk mengelola peminjaman dan pengembalian buku dengan sistem otomatis, tracking yang akurat, dan notifikasi reminder",
            icon: "bi-arrow-repeat",
            color: "green"
        },
        {
            id: 3,
            title: "Manajemen Anggota",
            description: "Pengelolaan data anggota perpustakaan dengan sistem registrasi online, manajemen keanggotaan yang komprehensif, dan laporan statistik",
            icon: "bi-people",
            color: "orange"
        }
    ];
    
    modules = [
        {
            id: 1,
            title: "Database Engine",
            description: "Sistem database yang robust untuk menyimpan dan mengelola seluruh data perpustakaan dengan performa tinggi, keamanan optimal, dan backup otomatis",
            icon: "bi-database",
            color: "purple",
            module_type: "database"
        },
        {
            id: 2,
            title: "User Interface",
            description: "Antarmuka pengguna yang modern dan responsif untuk akses mudah ke semua fitur sistem perpustakaan dengan desain yang intuitif",
            icon: "bi-window",
            color: "blue",
            module_type: "application"
        },
        {
            id: 3,
            title: "Backup Utility",
            description: "Utilitas backup otomatis untuk menjaga keamanan data dengan penjadwalan backup yang fleksibel dan restore yang mudah",
            icon: "bi-shield-check",
            color: "green",
            module_type: "utility"
        }
    ];
    
    renderTableData();
    updateStats();
});

// Export functions for global access
window.saveFeature = saveFeature;
window.saveModule = saveModule;
window.editItem = editItem;
window.updateItem = updateItem;
window.deleteItem = deleteItem;
window.refreshContent = refreshContent;
window.editFeature = editFeature;
window.editModule = editModule;
window.deleteFeature = deleteFeature;
window.deleteModule = deleteModule;
window.refreshModulesData = function() {
    loadModules();
    showSuccess('Data modul berhasil direfresh');
};
