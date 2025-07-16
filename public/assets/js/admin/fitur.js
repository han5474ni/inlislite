/**
 * INLISLite v3.0 Features & Modules Management
 * JavaScript for CRUD operations and UI interactions
 */

// Global variables
let features = [];
let modules = [];
let filteredFeatures = [];
let filteredModules = [];

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

/**
 * Initialize the application
 */
function initializeApp() {
    loadFeatures();
    loadModules();
    initializeEventListeners();
    initializeSearch();
}

/**
 * Initialize event listeners
 */
function initializeEventListeners() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', handleSearch);
    }
    
    // Modal form submissions
    const addFeatureForm = document.getElementById('addFeatureForm');
    const addModuleForm = document.getElementById('addModuleForm');
    const editForm = document.getElementById('editForm');
    
    if (addFeatureForm) {
        addFeatureForm.addEventListener('submit', function(e) {
            e.preventDefault();
            saveFeature();
        });
    }
    
    if (addModuleForm) {
        addModuleForm.addEventListener('submit', function(e) {
            e.preventDefault();
            saveModule();
        });
    }
    
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updateItem();
        });
    }
}

/**
 * Initialize search functionality
 */
function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        // Add search icon animation
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    }
}

/**
 * Load features from API
 */
async function loadFeatures() {
    try {
        showLoading();
        
        // Fetch features from backend API
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
        
        const data = await response.json();
        
        if (data.success) {
            features = data.data || [];
        } else {
            throw new Error(data.message || 'Failed to load features');
        }
        filteredFeatures = [...features];
        renderFeatures();
        
    } catch (error) {
        console.error('Error loading features:', error);
        showError('Gagal memuat data fitur');
        
        // Fallback to empty array
        features = [];
        filteredFeatures = [];
        renderFeatures();
    } finally {
        hideLoading();
    }
}

/**
 * Load modules from API
 */
async function loadModules() {
    try {
        showLoading();
        
        // Fetch modules from backend API
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
        
        const data = await response.json();
        
        if (data.success) {
            modules = data.data || [];
        } else {
            throw new Error(data.message || 'Failed to load modules');
        }
        filteredModules = [...modules];
        renderModules();
        
    } catch (error) {
        console.error('Error loading modules:', error);
        showError('Gagal memuat data modul');
        
        // Fallback to empty array
        modules = [];
        filteredModules = [];
        renderModules();
    } finally {
        hideLoading();
    }
}

/**
 * Render features to the DOM
 */
function renderFeatures() {
    const container = document.getElementById('featuresContainer');
    if (!container) return;
    
    if (filteredFeatures.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h3>Tidak ada fitur ditemukan</h3>
                    <p>Belum ada fitur yang tersedia atau sesuai dengan pencarian Anda.</p>
                </div>
            </div>
        `;
        return;
    }
    
    container.innerHTML = filteredFeatures.map(feature => `
        <div class="col-lg-4 col-md-6">
            <div class="feature-card animate-fade-in">
                <div class="card-header">
                    <div class="card-icon ${feature.color}">
                        <i class="${feature.icon}"></i>
                    </div>
                    <div class="card-actions">
                        <button class="btn-action edit" onclick="editItem(${feature.id}, 'feature')" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn-action delete" onclick="deleteItem(${feature.id}, 'feature')" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <h3 class="card-title">${feature.title}</h3>
                    <p class="card-description">${feature.description}</p>
                </div>
                <div class="card-badge">Fitur</div>
            </div>
        </div>
    `).join('');
}

/**
 * Render modules to the DOM
 */
function renderModules() {
    const container = document.getElementById('modulesContainer');
    if (!container) return;
    
    if (filteredModules.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h3>Tidak ada modul ditemukan</h3>
                    <p>Belum ada modul yang tersedia atau sesuai dengan pencarian Anda.</p>
                </div>
            </div>
        `;
        return;
    }
    
    container.innerHTML = filteredModules.map(module => `
        <div class="col-lg-4 col-md-6">
            <div class="module-card animate-fade-in">
                <div class="card-header">
                    <div class="card-icon ${module.color}">
                        <i class="${module.icon}"></i>
                    </div>
                    <div class="card-actions">
                        <button class="btn-action edit" onclick="editItem(${module.id}, 'module')" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn-action delete" onclick="deleteItem(${module.id}, 'module')" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <h3 class="card-title">${module.title}</h3>
                    <p class="card-description">${module.description}</p>
                </div>
                <div class="card-badge module">Modul</div>
            </div>
        </div>
    `).join('');
}

/**
 * Handle search functionality
 */
function handleSearch() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    
    // Filter features
    filteredFeatures = features.filter(feature => 
        feature.title.toLowerCase().includes(searchTerm) ||
        feature.description.toLowerCase().includes(searchTerm)
    );
    
    // Filter modules
    filteredModules = modules.filter(module => 
        module.title.toLowerCase().includes(searchTerm) ||
        module.description.toLowerCase().includes(searchTerm)
    );
    
    // Re-render both sections
    renderFeatures();
    renderModules();
}

/**
 * Save new feature
 */
async function saveFeature() {
    try {
        const title = document.getElementById('featureTitle').value;
        const description = document.getElementById('featureDescription').value;
        const icon = document.getElementById('featureIcon').value;
        const color = document.getElementById('featureColor').value;
        
        if (!title || !description || !icon || !color) {
            showError('Semua field harus diisi');
            return;
        }
        
        showLoading();
        
        const newFeature = {
            id: Date.now(), // Temporary ID, replace with API response
            title,
            description,
            icon: icon.startsWith('bi-') ? icon : `bi-${icon}`,
            color,
            type: 'feature'
        };
        
        // TODO: Replace with actual API call
        // const response = await fetch('/api/fitur', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify(newFeature)
        // });
        
        features.push(newFeature);
        filteredFeatures = [...features];
        renderFeatures();
        
        // Close modal and reset form
        const modal = bootstrap.Modal.getInstance(document.getElementById('addFeatureModal'));
        modal.hide();
        document.getElementById('addFeatureForm').reset();
        
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
        const title = document.getElementById('moduleTitle').value;
        const description = document.getElementById('moduleDescription').value;
        const icon = document.getElementById('moduleIcon').value;
        const color = document.getElementById('moduleColor').value;
        const moduleType = document.getElementById('moduleType').value;
        
        if (!title || !description || !icon || !color || !moduleType) {
            showError('Semua field harus diisi');
            return;
        }
        
        showLoading();
        
        const newModule = {
            id: Date.now(), // Temporary ID, replace with API response
            title,
            description,
            icon: icon.startsWith('bi-') ? icon : `bi-${icon}`,
            color,
            type: 'module',
            module_type: moduleType
        };
        
        // TODO: Replace with actual API call
        modules.push(newModule);
        filteredModules = [...modules];
        renderModules();
        
        // Close modal and reset form
        const modal = bootstrap.Modal.getInstance(document.getElementById('addModuleModal'));
        modal.hide();
        document.getElementById('addModuleForm').reset();
        
        showSuccess('Modul berhasil ditambahkan');
        
    } catch (error) {
        console.error('Error saving module:', error);
        showError('Gagal menyimpan modul');
    } finally {
        hideLoading();
    }
}

/**
 * Edit item (feature or module)
 */
function editItem(id, type) {
    const item = type === 'feature' 
        ? features.find(f => f.id === id)
        : modules.find(m => m.id === id);
    
    if (!item) {
        showError('Item tidak ditemukan');
        return;
    }
    
    // Populate edit form
    document.getElementById('editId').value = id;
    document.getElementById('editType').value = type;
    document.getElementById('editTitle').value = item.title;
    document.getElementById('editDescription').value = item.description;
    document.getElementById('editIcon').value = item.icon;
    document.getElementById('editColor').value = item.color;
    
    // Show/hide module type field
    const typeContainer = document.getElementById('editTypeContainer');
    const moduleTypeField = document.getElementById('editModuleType');
    
    if (type === 'module') {
        typeContainer.style.display = 'block';
        moduleTypeField.value = item.module_type || 'application';
    } else {
        typeContainer.style.display = 'none';
    }
    
    // Update modal title
    document.getElementById('editModalTitle').textContent = 
        type === 'feature' ? 'Edit Fitur' : 'Edit Modul';
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}

/**
 * Update item
 */
async function updateItem() {
    try {
        const id = parseInt(document.getElementById('editId').value);
        const type = document.getElementById('editType').value;
        const title = document.getElementById('editTitle').value;
        const description = document.getElementById('editDescription').value;
        const icon = document.getElementById('editIcon').value;
        const color = document.getElementById('editColor').value;
        
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
            updatedItem.module_type = document.getElementById('editModuleType').value;
        }
        
        // Update in local arrays
        if (type === 'feature') {
            const index = features.findIndex(f => f.id === id);
            if (index !== -1) {
                features[index] = updatedItem;
                filteredFeatures = [...features];
                renderFeatures();
            }
        } else {
            const index = modules.findIndex(m => m.id === id);
            if (index !== -1) {
                modules[index] = updatedItem;
                filteredModules = [...modules];
                renderModules();
            }
        }
        
        // TODO: Replace with actual API call
        // const response = await fetch(`/api/fitur/${id}`, {
        //     method: 'PUT',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify(updatedItem)
        // });
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
        modal.hide();
        
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
        
        // Remove from local arrays
        if (type === 'feature') {
            features = features.filter(f => f.id !== id);
            filteredFeatures = [...features];
            renderFeatures();
        } else {
            modules = modules.filter(m => m.id !== id);
            filteredModules = [...modules];
            renderModules();
        }
        
        // TODO: Replace with actual API call
        // const response = await fetch(`/api/fitur/${id}`, {
        //     method: 'DELETE'
        // });
        
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

/**
 * Utility function to debounce search
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Refresh content function
 */
function refreshContent() {
    console.log('Refreshing content...');
    
    // Clear existing data
    features = [];
    modules = [];
    filteredFeatures = [];
    filteredModules = [];
    
    // Clear search input
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
    }
    
    // Reload data
    loadFeatures();
    loadModules();
    
    showSuccess('Data berhasil direfresh');
}

// Export functions for global access
window.saveFeature = saveFeature;
window.saveModule = saveModule;
window.editItem = editItem;
window.updateItem = updateItem;
window.deleteItem = deleteItem;
window.refreshContent = refreshContent;
