/**
 * INLISLite v3.0 Tentang Edit Page JavaScript
 * Handles CRUD operations for tentang cards
 */

class TentangCardManager {
    constructor() {
        this.currentCardId = null;
        this.cards = [];
        this.init();
        this.bindEvents();
        this.loadCards();
    }

    init() {
        // Initialize modals
        this.cardModal = new bootstrap.Modal(document.getElementById('cardModal'));
        this.deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        
        // Add fade-in animation to elements
        this.addFadeInAnimation();
    }

    addFadeInAnimation() {
        const elements = document.querySelectorAll('.card, .action-section');
        elements.forEach((element, index) => {
            setTimeout(() => {
                element.classList.add('fade-in');
            }, index * 100);
        });
    }

    bindEvents() {
        // Add card buttons
        document.getElementById('btnAddCard').addEventListener('click', () => this.showAddCardModal());
        document.getElementById('btnAddFirstCard').addEventListener('click', () => this.showAddCardModal());
        
        // Save card button
        document.getElementById('saveCardBtn').addEventListener('click', () => this.saveCard());
        
        // Confirm delete button
        document.getElementById('confirmDeleteBtn').addEventListener('click', () => this.deleteCard());
        
        // Form validation
        document.getElementById('cardForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.saveCard();
        });

        // Modal events
        document.getElementById('cardModal').addEventListener('hidden.bs.modal', () => {
            this.resetForm();
        });
    }

    async loadCards() {
        try {
            this.showLoadingState();
            
            const response = await fetch(`${window.location.origin}/admin/tentang/getCards`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const result = await response.json();
                if (result.success) {
                    this.cards = result.cards || [];
                    this.renderCards();
                } else {
                    this.showError('Gagal memuat data kartu: ' + result.message);
                }
            } else {
                this.showError('Gagal memuat data kartu');
            }
        } catch (error) {
            console.error('Error loading cards:', error);
            this.showError('Terjadi kesalahan saat memuat data');
        } finally {
            this.hideLoadingState();
        }
    }

    renderCards() {
        const tableBody = document.getElementById('cardsTableBody');
        const cardsTable = document.getElementById('cardsTable');
        const emptyState = document.getElementById('emptyState');

        if (this.cards.length === 0) {
            cardsTable.style.display = 'none';
            emptyState.style.display = 'block';
            return;
        }

        cardsTable.style.display = 'block';
        emptyState.style.display = 'none';

        tableBody.innerHTML = this.cards.map(card => this.createCardRow(card)).join('');
        
        // Add event listeners to action buttons
        this.bindCardActions();
    }

    createCardRow(card) {
        const iconClass = this.getCardIconClass(card.category);
        const statusBadge = card.status === 'active' ? 
            '<span class="status-badge active">Aktif</span>' : 
            '<span class="status-badge inactive">Tidak Aktif</span>';

        const categoryBadge = `<span class="category-badge ${card.category}">${this.getCategoryName(card.category)}</span>`;

        return `
            <tr data-card-id="${card.id}" class="slide-in">
                <td data-label="Kartu">
                    <div class="card-entry">
                        <div class="card-entry-icon ${card.category}">
                            <i class="bi ${iconClass}"></i>
                        </div>
                        <div class="card-entry-info">
                            <div class="card-entry-name">${this.escapeHtml(card.title)}</div>
                            <div class="card-entry-subtitle">${this.escapeHtml(card.subtitle || '')}</div>
                        </div>
                    </div>
                </td>
                <td data-label="Kategori">
                    ${categoryBadge}
                </td>
                <td data-label="Status">
                    ${statusBadge}
                </td>
                <td data-label="Aksi">
                    <div class="card-actions">
                        <button class="btn btn-sm btn-outline-primary btn-edit" data-card-id="${card.id}" title="Edit Kartu">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger btn-delete" data-card-id="${card.id}" title="Hapus Kartu">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    bindCardActions() {
        // Edit buttons
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const cardId = e.target.closest('.btn-edit').dataset.cardId;
                this.showEditCardModal(cardId);
            });
        });

        // Delete buttons
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const cardId = e.target.closest('.btn-delete').dataset.cardId;
                this.showDeleteConfirmation(cardId);
            });
        });
    }

    showAddCardModal() {
        this.currentCardId = null;
        this.resetForm();
        document.getElementById('cardModalLabel').textContent = 'Tambah Card Tentang';
        this.cardModal.show();
    }

    showEditCardModal(cardId) {
        const card = this.cards.find(c => c.id == cardId);
        if (!card) {
            this.showError('Kartu tidak ditemukan');
            return;
        }

        this.currentCardId = cardId;
        this.populateForm(card);
        document.getElementById('cardModalLabel').textContent = 'Edit Card Tentang';
        this.cardModal.show();
    }

    populateForm(card) {
        document.getElementById('cardId').value = card.id;
        document.getElementById('cardTitle').value = card.title;
        document.getElementById('cardSubtitle').value = card.subtitle || '';
        document.getElementById('cardCategory').value = card.category || 'overview';
        document.getElementById('cardStatus').value = card.status || 'active';
        document.getElementById('cardContent').value = card.content || '';
        document.getElementById('cardIcon').value = card.icon || '';
        document.getElementById('sortOrder').value = card.sort_order || 1;
    }

    resetForm() {
        document.getElementById('cardForm').reset();
        document.getElementById('cardId').value = '';
        this.currentCardId = null;
    }

    async saveCard() {
        const form = document.getElementById('cardForm');
        const formData = new FormData(form);
        
        // Validate required fields
        if (!this.validateForm()) {
            return;
        }

        const cardData = {
            id: this.currentCardId,
            title: formData.get('title'),
            subtitle: formData.get('subtitle'),
            category: formData.get('category'),
            status: formData.get('status'),
            content: formData.get('content'),
            icon: formData.get('icon'),
            sort_order: formData.get('sort_order') || 1
        };

        try {
            this.setLoadingState(document.getElementById('saveCardBtn'), true);

            const url = this.currentCardId ? 
                `${window.location.origin}/admin/tentang/updateCard` : 
                `${window.location.origin}/admin/tentang/createCard`;

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(cardData)
            });

            if (response.ok) {
                const result = await response.json();
                if (result.success) {
                    this.cardModal.hide();
                    this.showSuccess(this.currentCardId ? 'Kartu berhasil diperbarui' : 'Kartu berhasil ditambahkan');
                    await this.loadCards();
                } else {
                    this.showError('Gagal menyimpan kartu: ' + result.message);
                }
            } else {
                this.showError('Gagal menyimpan kartu');
            }
        } catch (error) {
            console.error('Error saving card:', error);
            this.showError('Terjadi kesalahan saat menyimpan kartu');
        } finally {
            this.setLoadingState(document.getElementById('saveCardBtn'), false);
        }
    }

    showDeleteConfirmation(cardId) {
        this.currentCardId = cardId;
        this.deleteModal.show();
    }

    async deleteCard() {
        if (!this.currentCardId) return;

        try {
            this.setLoadingState(document.getElementById('confirmDeleteBtn'), true);

            const response = await fetch(`${window.location.origin}/admin/tentang/deleteCard`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ id: this.currentCardId })
            });

            if (response.ok) {
                const result = await response.json();
                if (result.success) {
                    this.deleteModal.hide();
                    this.showSuccess('Kartu berhasil dihapus');
                    await this.loadCards();
                } else {
                    this.showError('Gagal menghapus kartu: ' + result.message);
                }
            } else {
                this.showError('Gagal menghapus kartu');
            }
        } catch (error) {
            console.error('Error deleting card:', error);
            this.showError('Terjadi kesalahan saat menghapus kartu');
        } finally {
            this.setLoadingState(document.getElementById('confirmDeleteBtn'), false);
            this.currentCardId = null;
        }
    }

    validateForm() {
        const title = document.getElementById('cardTitle').value.trim();
        const content = document.getElementById('cardContent').value.trim();

        if (!title) {
            this.showError('Judul kartu harus diisi');
            document.getElementById('cardTitle').focus();
            return false;
        }

        if (!content) {
            this.showError('Konten kartu harus diisi');
            document.getElementById('cardContent').focus();
            return false;
        }

        return true;
    }

    getCardIconClass(category) {
        const iconMap = {
            overview: 'bi-info-circle',
            legal: 'bi-shield-check',
            features: 'bi-star',
            technical: 'bi-gear',
            other: 'bi-collection'
        };
        return iconMap[category] || 'bi-info-circle';
    }

    getCategoryName(category) {
        const categoryMap = {
            overview: 'Overview',
            legal: 'Legal',
            features: 'Features',
            technical: 'Technical',
            other: 'Lainnya'
        };
        return categoryMap[category] || 'Lainnya';
    }

    showLoadingState() {
        document.getElementById('loadingState').style.display = 'block';
        document.getElementById('cardsTable').style.display = 'none';
        document.getElementById('emptyState').style.display = 'none';
    }

    hideLoadingState() {
        document.getElementById('loadingState').style.display = 'none';
    }

    setLoadingState(button, isLoading) {
        if (isLoading) {
            button.disabled = true;
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Menyimpan...';
        } else {
            button.disabled = false;
            button.innerHTML = button.dataset.originalText || button.innerHTML;
        }
    }

    showSuccess(message) {
        this.showAlert(message, 'success');
    }

    showError(message) {
        this.showAlert(message, 'danger');
    }

    showAlert(message, type) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="bi ${type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        const alertContainer = document.getElementById('alertContainer');
        alertContainer.innerHTML = alertHtml;
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            const alert = alertContainer.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);

        // Scroll to top to show alert
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Utility functions
const TentangEditUtils = {
    formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return new Intl.DateTimeFormat('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(date);
    },

    stripHtml(html) {
        const div = document.createElement('div');
        div.innerHTML = html;
        return div.textContent || div.innerText || '';
    },

    truncateText(text, maxLength = 100) {
        if (text.length <= maxLength) return text;
        return text.substring(0, maxLength) + '...';
    },

    showConfirmation(message, callback) {
        if (confirm(message)) {
            callback();
        }
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize card manager
    window.tentangCardManager = new TentangCardManager();
    
    // Add global error handler
    window.addEventListener('error', function(e) {
        console.error('Tentang edit page error:', e.error);
    });
    
    // Add unhandled promise rejection handler
    window.addEventListener('unhandledrejection', function(e) {
        console.error('Unhandled promise rejection:', e.reason);
    });
    
    console.log('Tentang edit page initialized successfully');
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { TentangCardManager, TentangEditUtils };
}