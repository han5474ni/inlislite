/**
 * INLISLite v3.0 Installer Edit Page JavaScript
 * Handles CRUD operations for installer cards
 */

class InstallerCardManager {
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
            
            const response = await fetch(`${window.location.origin}/admin/installer/getCards`, {
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
        const iconClass = this.getCardIconClass(card.card_type);
        const statusBadge = card.status === 'active' ? 
            '<span class="status-badge active">Aktif</span>' : 
            '<span class="status-badge inactive">Tidak Aktif</span>';

        return `
            <tr data-card-id="${card.id}" class="slide-in">
                <td data-label="Kartu">
                    <div class="card-entry">
                        <div class="card-entry-icon ${card.card_type}">
                            <i class="bi ${iconClass}"></i>
                        </div>
                        <div class="card-entry-info">
                            <div class="card-entry-name">${this.escapeHtml(card.package_name)}</div>
                            <div class="card-entry-description">${this.escapeHtml(card.description || '')}</div>
                        </div>
                    </div>
                </td>
                <td data-label="Versi">
                    <span class="version-badge">${this.escapeHtml(card.version)}</span>
                </td>
                <td data-label="Ukuran">
                    <span class="file-size">${this.escapeHtml(card.file_size || '-')}</span>
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
        document.getElementById('cardModalLabel').textContent = 'Tambah Card Installer';
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
        document.getElementById('cardModalLabel').textContent = 'Edit Card Installer';
        this.cardModal.show();
    }

    populateForm(card) {
        document.getElementById('cardId').value = card.id;
        document.getElementById('packageName').value = card.package_name;
        document.getElementById('version').value = card.version;
        document.getElementById('releaseDate').value = card.release_date || '';
        document.getElementById('fileSize').value = card.file_size || '';
        document.getElementById('downloadLink').value = card.download_link || '';
        document.getElementById('description').value = card.description || '';
        document.getElementById('defaultUsername').value = card.default_username || '';
        document.getElementById('defaultPassword').value = card.default_password || '';
        document.getElementById('cardType').value = card.card_type || 'source';
        document.getElementById('status').value = card.status || 'active';

        // Handle requirements checkboxes
        const requirements = card.requirements ? JSON.parse(card.requirements) : [];
        document.querySelectorAll('input[name="requirements[]"]').forEach(checkbox => {
            checkbox.checked = requirements.includes(checkbox.value);
        });
    }

    resetForm() {
        document.getElementById('cardForm').reset();
        document.getElementById('cardId').value = '';
        this.currentCardId = null;
        
        // Uncheck all requirements
        document.querySelectorAll('input[name="requirements[]"]').forEach(checkbox => {
            checkbox.checked = false;
        });
    }

    async saveCard() {
        const form = document.getElementById('cardForm');
        const formData = new FormData(form);
        
        // Validate required fields
        if (!this.validateForm()) {
            return;
        }

        // Collect requirements
        const requirements = [];
        document.querySelectorAll('input[name="requirements[]"]:checked').forEach(checkbox => {
            requirements.push(checkbox.value);
        });

        const cardData = {
            id: this.currentCardId,
            package_name: formData.get('package_name'),
            version: formData.get('version'),
            release_date: formData.get('release_date'),
            file_size: formData.get('file_size'),
            download_link: formData.get('download_link'),
            description: formData.get('description'),
            requirements: JSON.stringify(requirements),
            default_username: formData.get('default_username'),
            default_password: formData.get('default_password'),
            card_type: formData.get('card_type'),
            status: formData.get('status')
        };

        try {
            this.setLoadingState(document.getElementById('saveCardBtn'), true);

            const url = this.currentCardId ? 
                `${window.location.origin}/admin/installer/updateCard` : 
                `${window.location.origin}/admin/installer/createCard`;

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

            const response = await fetch(`${window.location.origin}/admin/installer/deleteCard`, {
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
        const packageName = document.getElementById('packageName').value.trim();
        const version = document.getElementById('version').value.trim();

        if (!packageName) {
            this.showError('Nama paket harus diisi');
            document.getElementById('packageName').focus();
            return false;
        }

        if (!version) {
            this.showError('Versi harus diisi');
            document.getElementById('version').focus();
            return false;
        }

        return true;
    }

    getCardIconClass(cardType) {
        const iconMap = {
            source: 'bi-code-slash',
            installer: 'bi-box-seam',
            database: 'bi-database',
            documentation: 'bi-file-text'
        };
        return iconMap[cardType] || 'bi-box';
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
const InstallerEditUtils = {
    formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return new Intl.DateTimeFormat('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(date);
    },

    validateUrl(url) {
        try {
            new URL(url);
            return true;
        } catch {
            return false;
        }
    },

    generateSlug(text) {
        return text
            .toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
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
    window.installerCardManager = new InstallerCardManager();
    
    // Add global error handler
    window.addEventListener('error', function(e) {
        console.error('Installer edit page error:', e.error);
    });
    
    // Add unhandled promise rejection handler
    window.addEventListener('unhandledrejection', function(e) {
        console.error('Unhandled promise rejection:', e.reason);
    });
    
    console.log('Installer edit page initialized successfully');
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { InstallerCardManager, InstallerEditUtils };
}