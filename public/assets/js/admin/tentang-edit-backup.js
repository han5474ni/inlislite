/**
 * INLISLite v3.0 Tentang Edit Page
 * CRUD management for tentang cards with DataTables integration
 */

// Global variables
let cardsTable;
let currentEditId = null;

// CSRF token management for CodeIgniter 4
function getCSRFToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

function getCSRFHash() {
    const meta = document.querySelector('meta[name="csrf-hash"]');
    return meta ? meta.getAttribute('content') : '';
}

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
    loadCards();
}

/**
 * Initialize DataTables
 */
function initializeDataTable() {
    cardsTable = $('#cardsTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']], // Sort by ID column
        columnDefs: [
            { orderable: false, targets: [1, 5] }, // Disable sorting for icon and actions
            { searchable: false, targets: [1, 5] }, // Disable search for icon and actions
            { width: "60px", targets: [0] }, // ID column width
            { width: "80px", targets: [1] }, // Icon column width
            { width: "100px", targets: [4] }, // Status column width
            { width: "120px", targets: [5] } // Actions column width
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
    document.getElementById('cardIcon').addEventListener('input', function() {
        updateIconPreview(this.value, 'cardIconPreview');
    });
    
    document.getElementById('editIcon').addEventListener('input', function() {
        updateIconPreview(this.value, 'editIconPreview');
    });
    
    // Form submissions
    document.getElementById('addCardForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveCard();
    });
    
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updateCard();
    });
    
    // Modal events
    document.getElementById('addCardModal').addEventListener('hidden.bs.modal', function() {
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
        const response = await fetch('/admin/tentang/getCards', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            const cards = data.cards || [];
            const stats = {
                total_cards: cards.length,
                active_cards: cards.filter(card => card.is_active == 1).length,
                features_cards: cards.filter(card => card.card_type === 'feature').length,
                technical_cards: cards.filter(card => card.card_type === 'technical').length
            };
            
            updateStatistics(stats);
        } else {
            throw new Error(data.message || 'Failed to load statistics');
        }
        
    } catch (error) {
        console.error('Error loading statistics:', error);
        showError('Gagal memuat statistik');
    }
}

/**
 * Update statistics display
 */
function updateStatistics(stats) {
    document.getElementById('totalCards').textContent = stats.total_cards || 0;
    document.getElementById('activeCards').textContent = stats.active_cards || 0;
    document.getElementById('featuresCards').textContent = stats.features_cards || 0;
    document.getElementById('technicalCards').textContent = stats.technical_cards || 0;
}

/**
 * Load cards data
 */
async function loadCards() {
    try {
        showLoading();
        
        const response = await fetch('/admin/tentang/getCards', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            populateTable(data.cards || []);
        } else {
            throw new Error(data.message || 'Failed to load cards');
        }
        
    } catch (error) {
        console.error('Error loading cards:', error);
        showError('Gagal memuat data kartu');
        
        // Show empty table on error
        populateTable([]);
    } finally {
        hideLoading();
    }
}

/**
 * Populate DataTable with cards data
 */
function populateTable(cards) {
    cardsTable.clear();
    
    cards.forEach(card => {
        const row = [
            card.id,
            `<div class="text-center">
                <i class="${card.icon || 'bi-info-circle'}" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
            </div>`,
            `<div>
                <div class="fw-semibold">${card.title}</div>
                ${card.subtitle ? `<small class="text-muted">${card.subtitle}</small>` : ''}
            </div>`,
            `<span class="category-badge ${card.card_type || 'info'}">${getCategoryLabel(card.card_type || 'info')}</span>`,
            `<span class="status-badge ${card.is_active == 1 ? 'active' : 'inactive'}">${getStatusLabel(card.is_active == 1 ? 'active' : 'inactive')}</span>`,
            `<div class="d-flex justify-content-center">
                <button class="btn-action edit" onclick="editCard(${card.id})" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-action delete" onclick="deleteCard(${card.id})" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>`
        ];
        
        cardsTable.row.add(row);
    });
    
    cardsTable.draw();
}

/**
 * Get category label
 */
function getCategoryLabel(category) {
    const labels = {
        'info': 'Info',
        'feature': 'Feature',
        'contact': 'Contact',
        'technical': 'Technical'
    };
    return labels[category] || category;
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
 * Save new card
 */
async function saveCard() {
    try {
        const formData = {
            title: document.getElementById('cardTitle').value,
            subtitle: document.getElementById('cardSubtitle').value,
            content: document.getElementById('cardContent').value,
            category: document.getElementById('cardCategory').value,
            icon: document.getElementById('cardIcon').value,
            status: document.getElementById('cardStatus').value,
            sort_order: 1
        };
        
        // Validate required fields
        if (!formData.title || !formData.content) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        // Ensure icon has bi- prefix
        if (formData.icon && !formData.icon.startsWith('bi-')) {
            formData.icon = `bi-${formData.icon}`;
        }
        
        showLoading();
        
        // Add CSRF token to form data
        const csrfHash = getCSRFHash();
        if (csrfHash) {
            formData['csrf_test_name'] = csrfHash;
        }
        
        const response = await fetch('/admin/tentang/createCard', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(formData)
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            // Close modal and refresh data
            const modal = bootstrap.Modal.getInstance(document.getElementById('addCardModal'));
            modal.hide();
            
            showSuccess(data.message || 'Kartu berhasil ditambahkan');
            loadCards();
            loadStatistics();
        } else {
            throw new Error(data.message || 'Failed to save card');
        }
        
    } catch (error) {
        console.error('Error saving card:', error);
        showError(error.message || 'Gagal menyimpan kartu');
    } finally {
        hideLoading();
    }
}

/**
 * Edit card - fetch real data from API
 */
async function editCard(id) {
    try {
        showLoading();
        
        // Fetch card data from API
        const response = await fetch('/admin/tentang/getCards', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            const card = data.cards.find(c => c.id == id);
            
            if (!card) {
                showError('Kartu tidak ditemukan');
                return;
            }
            
            // Populate edit form with real data
            currentEditId = id;
            document.getElementById('editId').value = id;
            document.getElementById('editTitle').value = card.title || '';
            document.getElementById('editSubtitle').value = card.subtitle || '';
            document.getElementById('editContent').value = card.content || '';
            document.getElementById('editCategory').value = card.card_type || 'info';
            document.getElementById('editIcon').value = card.icon || '';
            document.getElementById('editStatus').value = card.is_active == 1 ? 'active' : 'inactive';
                        
            // Update icon preview
            updateIconPreview(card.icon || '', 'editIconPreview');
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        } else {
            throw new Error(data.message || 'Failed to load card data');
        }
        
    } catch (error) {
        console.error('Error loading card for edit:', error);
        showError('Gagal memuat data kartu untuk diedit');
    } finally {
        hideLoading();
    }
}

/**
 * Update card
 */
async function updateCard() {
    try {
        const formData = {
            id: currentEditId,
            title: document.getElementById('editTitle').value,
            subtitle: document.getElementById('editSubtitle').value,
            content: document.getElementById('editContent').value,
            category: document.getElementById('editCategory').value,
            icon: document.getElementById('editIcon').value,
            status: document.getElementById('editStatus').value,
            sort_order: 1
        };
        
        // Validate required fields
        if (!formData.title || !formData.content || !formData.category) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        // Ensure icon has bi- prefix
        if (formData.icon && !formData.icon.startsWith('bi-')) {
            formData.icon = `bi-${formData.icon}`;
        }
        
        showLoading();
        
        // Add CSRF token to form data
        const csrfHash = getCSRFHash();
        if (csrfHash) {
            formData['csrf_test_name'] = csrfHash;
        }
        
        const response = await fetch('/admin/tentang/updateCard', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(formData)
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            // Close modal and refresh data
            const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
            modal.hide();
            
            showSuccess(data.message || 'Kartu berhasil diperbarui');
            loadCards();
            loadStatistics();
        } else {
            throw new Error(data.message || 'Failed to update card');
        }
        
    } catch (error) {
        console.error('Error updating card:', error);
        showError('Gagal memperbarui kartu');
    } finally {
        hideLoading();
    }
}

/**
 * Delete card
 */
async function deleteCard(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus kartu ini?')) {
        return;
    }
    
    try {
        showLoading();
        
        const formData = {
            id: id
        };
        
        // Add CSRF token to form data
        const csrfHash = getCSRFHash();
        if (csrfHash) {
            formData['csrf_test_name'] = csrfHash;
        }
        
        const response = await fetch('/admin/tentang/deleteCard', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(formData)
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            showSuccess(data.message || 'Kartu berhasil dihapus');
            loadCards();
            loadStatistics();
        } else {
            throw new Error(data.message || 'Failed to delete card');
        }
        
    } catch (error) {
        console.error('Error deleting card:', error);
        showError('Gagal menghapus kartu');
    } finally {
        hideLoading();
    }
}

/**
 * Reset add form
 */
function resetAddForm() {
    document.getElementById('addCardForm').reset();
    updateIconPreview('', 'cardIconPreview');
}

/**
 * Reset edit form
 */
function resetEditForm() {
    document.getElementById('editForm').reset();
    currentEditId = null;
    updateIconPreview('', 'editIconPreview');
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
window.saveCard = saveCard;
window.editCard = editCard;
window.updateCard = updateCard;
window.deleteCard = deleteCard;