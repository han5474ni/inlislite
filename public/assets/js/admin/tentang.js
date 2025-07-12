/**
 * INLISLite v3.0 Tentang Page
 * JavaScript for content management and UI interactions
 * Synchronized with database via API
 */

// Global variables
let contentCards = [];
let filteredCards = [];

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
 * Load content from database API
 */
async function loadContent() {
    try {
        showLoading();
        
        // Fetch data from the same API endpoint as tentang-edit
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
            // Convert database format to display format
            contentCards = data.cards.map(card => ({
                id: card.id,
                title: card.title,
                subtitle: card.subtitle,
                content: card.content,
                type: card.card_type || 'info',
                icon: card.icon,
                is_active: card.is_active,
                sort_order: card.sort_order
            }));
            
            // Filter only active cards and sort by sort_order
            contentCards = contentCards
                .filter(card => card.is_active == 1)
                .sort((a, b) => (a.sort_order || 0) - (b.sort_order || 0));
            
            filteredCards = [...contentCards];
            renderContent();
        } else {
            throw new Error(data.message || 'Failed to load content');
        }
        
    } catch (error) {
        console.error('Error loading content:', error);
        showError('Gagal memuat konten dari database');
        
        // Show empty state on error
        contentCards = [];
        filteredCards = [];
        renderContent();
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
    
    if (filteredCards.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h3>Tidak ada konten ditemukan</h3>
                    <p>Belum ada konten yang tersedia atau sesuai dengan pencarian Anda.</p>
                    <a href="/admin/tentang-edit" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Konten
                    </a>
                </div>
            </div>
        `;
        return;
    }
    
    container.innerHTML = filteredCards.map(card => `
        <div class="col-lg-6 col-md-12">
            <div class="content-card animate-fade-in">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="${card.icon || 'bi-' + getCardIcon(card.type)}"></i>
                    </div>
                    <div class="card-actions">
                        <a href="/admin/tentang-edit" class="btn-action edit" title="Kelola di Admin">
                            <i class="bi bi-gear"></i>
                        </a>
                        <button class="btn-action refresh" onclick="refreshContent()" title="Refresh">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <h3 class="card-title">${card.title}</h3>
                    ${card.subtitle ? `<p class="card-subtitle">${card.subtitle}</p>` : ''}
                    <div class="card-description">${formatContent(card.content)}</div>
                </div>
            </div>
        </div>
    `).join('');
}

/**
 * Get icon for card type
 */
function getCardIcon(type) {
    const icons = {
        'info': 'info-circle',
        'feature': 'star',
        'contact': 'person-circle',
        'technical': 'gear',
        'default': 'file-text'
    };
    return icons[type] || icons.default;
}

/**
 * Format content for display
 */
function formatContent(content) {
    if (!content) return '';
    
    // Convert HTML content to display format
    let formatted = content;
    
    // Convert <p> tags to line breaks
    formatted = formatted.replace(/<p>/g, '').replace(/<\/p>/g, '<br><br>');
    
    // Convert <ul> and <li> tags to bullet points
    formatted = formatted.replace(/<ul>/g, '').replace(/<\/ul>/g, '');
    formatted = formatted.replace(/<li>/g, '• ').replace(/<\/li>/g, '<br>');
    
    // Convert <strong> tags
    formatted = formatted.replace(/<strong>/g, '<b>').replace(/<\/strong>/g, '</b>');
    
    // Clean up extra line breaks
    formatted = formatted.replace(/<br><br><br>/g, '<br><br>');
    formatted = formatted.replace(/^<br>|<br>$/g, '');
    
    return formatted;
}

/**
 * Handle search functionality
 */
function handleSearch() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    
    // Filter content
    filteredCards = contentCards.filter(card => 
        card.title.toLowerCase().includes(searchTerm) ||
        (card.subtitle && card.subtitle.toLowerCase().includes(searchTerm)) ||
        card.content.toLowerCase().includes(searchTerm)
    );
    
    // Re-render content
    renderContent();
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
window.refreshContent = refreshContent;