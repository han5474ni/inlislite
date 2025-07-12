/**
 * INLISLite v3.0 Demo Program Page
 * JavaScript for content management and UI interactions
 */

// Global variables
let contentItems = [];
let filteredItems = [];

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

/**
 * Initialize the application
 */
function initializeApp() {
    loadContent();
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
    const addItemForm = document.getElementById('addItemForm');
    const editForm = document.getElementById('editForm');
    
    if (addItemForm) {
        addItemForm.addEventListener('submit', function(e) {
            e.preventDefault();
            saveItem();
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
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    }
}

/**
 * Load content from API
 */
async function loadContent() {
    try {
        showLoading();
        
        // Sample data for Demo Program
        const sampleContent = [
            {
                id: 1,
                title: "Sample Demo Program Item 1",
                subtitle: "Contoh item pertama",
                description: "Deskripsi lengkap untuk item pertama dalam kategori Demo Program. Item ini menunjukkan bagaimana konten ditampilkan dalam sistem.",
                category: "general",
                priority: "high"
            },
            {
                id: 2,
                title: "Sample Demo Program Item 2", 
                subtitle: "Contoh item kedua",
                description: "Deskripsi untuk item kedua yang memberikan informasi tambahan tentang fitur dan fungsi yang tersedia.",
                category: "technical",
                priority: "medium"
            },
            {
                id: 3,
                title: "Sample Demo Program Item 3",
                subtitle: "Contoh item ketiga",
                description: "Item ketiga ini menampilkan variasi konten yang dapat dikelola dalam sistem manajemen Demo Program.",
                category: "tutorial",
                priority: "low"
            }
        ];
        
        contentItems = sampleContent;
        filteredItems = [...contentItems];
        renderContent();
        
    } catch (error) {
        console.error('Error loading content:', error);
        showError('Gagal memuat konten');
    } finally {
        hideLoading();
    }
}

/**
 * Render content to the DOM
 */
function renderContent() {
    const container = document.getElementById('contentContainer');
    if (!container) return;
    
    if (filteredItems.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h3>Tidak ada konten ditemukan</h3>
                    <p>Belum ada konten yang tersedia atau sesuai dengan pencarian Anda.</p>
                </div>
            </div>
        `;
        return;
    }
    
    container.innerHTML = filteredItems.map(item => `
        <div class="col-lg-6 col-md-12">
            <div class="content-card animate-fade-in">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="bi bi-${getCategoryIcon(item.category)}"></i>
                    </div>
                    <div class="card-actions">
                        <button class="btn-action edit" onclick="editItem(${item.id})" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn-action delete" onclick="deleteItem(${item.id})" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <h3 class="card-title">${item.title}</h3>
                    ${item.subtitle ? `<p class="card-subtitle">${item.subtitle}</p>` : ''}
                    <div class="card-description">${item.description}</div>
                    <div class="mt-3">
                        <span class="badge bg-${getPriorityColor(item.priority)} me-2">${item.priority}</span>
                        <span class="badge bg-secondary">${item.category}</span>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

/**
 * Get icon for category
 */
function getCategoryIcon(category) {
    const icons = {
        'general': 'info-circle',
        'technical': 'gear',
        'tutorial': 'book',
        'update': 'arrow-up-circle',
        'default': 'file-text'
    };
    return icons[category] || icons.default;
}

/**
 * Get color for priority
 */
function getPriorityColor(priority) {
    const colors = {
        'high': 'danger',
        'medium': 'warning',
        'low': 'success'
    };
    return colors[priority] || 'secondary';
}

/**
 * Handle search functionality
 */
function handleSearch() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    
    filteredItems = contentItems.filter(item => 
        item.title.toLowerCase().includes(searchTerm) ||
        item.subtitle.toLowerCase().includes(searchTerm) ||
        item.description.toLowerCase().includes(searchTerm) ||
        item.category.toLowerCase().includes(searchTerm)
    );
    
    renderContent();
}

/**
 * Save new item
 */
async function saveItem() {
    try {
        const title = document.getElementById('itemTitle').value;
        const subtitle = document.getElementById('itemSubtitle').value;
        const description = document.getElementById('itemDescription').value;
        const category = document.getElementById('itemCategory').value;
        const priority = document.getElementById('itemPriority').value;
        
        if (!title || !description) {
            showError('Judul dan deskripsi harus diisi');
            return;
        }
        
        showLoading();
        
        const newItem = {
            id: Date.now(),
            title,
            subtitle,
            description,
            category,
            priority
        };
        
        contentItems.push(newItem);
        filteredItems = [...contentItems];
        renderContent();
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('addItemModal'));
        modal.hide();
        document.getElementById('addItemForm').reset();
        
        showSuccess('Item berhasil ditambahkan');
        
    } catch (error) {
        console.error('Error saving item:', error);
        showError('Gagal menyimpan item');
    } finally {
        hideLoading();
    }
}

/**
 * Edit item
 */
function editItem(id) {
    const item = contentItems.find(i => i.id === id);
    
    if (!item) {
        showError('Item tidak ditemukan');
        return;
    }
    
    document.getElementById('editId').value = id;
    document.getElementById('editTitle').value = item.title;
    document.getElementById('editSubtitle').value = item.subtitle || '';
    document.getElementById('editDescription').value = item.description;
    document.getElementById('editCategory').value = item.category;
    document.getElementById('editPriority').value = item.priority;
    
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}

/**
 * Update item
 */
async function updateItem() {
    try {
        const id = parseInt(document.getElementById('editId').value);
        const title = document.getElementById('editTitle').value;
        const subtitle = document.getElementById('editSubtitle').value;
        const description = document.getElementById('editDescription').value;
        const category = document.getElementById('editCategory').value;
        const priority = document.getElementById('editPriority').value;
        
        if (!title || !description) {
            showError('Judul dan deskripsi harus diisi');
            return;
        }
        
        showLoading();
        
        const index = contentItems.findIndex(i => i.id === id);
        if (index !== -1) {
            contentItems[index] = {
                ...contentItems[index],
                title,
                subtitle,
                description,
                category,
                priority
            };
            filteredItems = [...contentItems];
            renderContent();
        }
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
        modal.hide();
        
        showSuccess('Item berhasil diperbarui');
        
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
async function deleteItem(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) {
        return;
    }
    
    try {
        showLoading();
        
        contentItems = contentItems.filter(i => i.id !== id);
        filteredItems = [...contentItems];
        renderContent();
        
        showSuccess('Item berhasil dihapus');
        
    } catch (error) {
        console.error('Error deleting item:', error);
        showError('Gagal menghapus item');
    } finally {
        hideLoading();
    }
}

/**
 * Refresh content
 */
function refreshContent() {
    loadContent();
    showSuccess('Konten berhasil diperbarui');
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
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.animation = 'slideInRight 0.3s ease-out reverse';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
}

// Export functions for global access
window.saveItem = saveItem;
window.editItem = editItem;
window.updateItem = updateItem;
window.deleteItem = deleteItem;
window.refreshContent = refreshContent;