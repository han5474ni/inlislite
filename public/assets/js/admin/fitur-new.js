/**
 * INLISLite v3.0 Features & Modules Management (New UI)
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
    const editForm = document.getElementById('editForm');
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="${feature.icon} text-white text-lg"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">${feature.title}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-3">${feature.description}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            <span class="text-xs font-medium text-green-600">Aktif</span>
                        </div>
                        <a href="/admin/fitur-edit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                    </div>
                </div>
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="${module.icon} text-white text-lg"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">${module.title}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-3">${module.description}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            <span class="text-xs font-medium text-green-600">Aktif</span>
                        </div>
                        <a href="/admin/fitur-edit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                    </div>
                </div>
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
window.refreshContent = refreshContent;

