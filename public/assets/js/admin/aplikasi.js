/**
 * INLISLite v3.0 Supporting Applications JavaScript
 * Handles interactions for supporting applications page
 */

// Logout confirmation function
function confirmLogout() {
    return confirm('Apakah Anda yakin ingin logout? Anda harus login kembali untuk mengakses halaman admin.');
}

class SupportingApplicationsManager {
    constructor() {
        this.currentEditingCard = null;
        this.deleteModal = null;
        this.init();
    }

    /**
     * Initialize the application manager
     */
    init() {
        this.setupEventListeners();
        this.setupAnimations();
        this.initializeModals();
        this.setupTooltips();
    }

    /**
     * Setup all event listeners
     */
    setupEventListeners() {
        // Edit application clicks
        document.addEventListener('click', (e) => {
            if (e.target.closest('.edit-app')) {
                e.preventDefault();
                const appId = e.target.closest('.edit-app').getAttribute('data-id');
                this.enableEditMode(appId);
            }
        });

        // Delete application clicks
        document.addEventListener('click', (e) => {
            if (e.target.closest('.delete-app')) {
                e.preventDefault();
                const appId = e.target.closest('.delete-app').getAttribute('data-id');
                this.showDeleteConfirmation(appId);
            }
        });

        // Save application clicks
        document.addEventListener('click', (e) => {
            if (e.target.closest('.save-app')) {
                e.preventDefault();
                this.saveApplication();
            }
        });

        // Cancel edit clicks
        document.addEventListener('click', (e) => {
            if (e.target.closest('.cancel-edit')) {
                e.preventDefault();
                this.cancelEdit();
            }
        });

        // Download button clicks
        document.addEventListener('click', (e) => {
            if (e.target.closest('.btn-download')) {
                e.preventDefault();
                this.handleDownload(e.target.closest('.btn-download'));
            }
        });

        // Card hover effects
        document.querySelectorAll('.application-card').forEach(card => {
            card.addEventListener('mouseenter', () => this.handleCardHover(card, true));
            card.addEventListener('mouseleave', () => this.handleCardHover(card, false));
        });

        // Confirm delete button
        document.addEventListener('click', (e) => {
            if (e.target.closest('#confirmDelete')) {
                this.confirmDelete();
            }
        });
    }

    /**
     * Setup animations for page elements
     */
    setupAnimations() {
        // Animate cards on page load
        const cards = document.querySelectorAll('.application-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';

            setTimeout(() => {
                card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 150);
        });

        // Animate header section
        const headerSection = document.querySelector('.header-section');
        if (headerSection) {
            headerSection.style.opacity = '0';
            headerSection.style.transform = 'translateY(-20px)';

            setTimeout(() => {
                headerSection.style.transition = 'all 0.5s ease';
                headerSection.style.opacity = '1';
                headerSection.style.transform = 'translateY(0)';
            }, 100);
        }
    }

    /**
     * Initialize modals
     */
    initializeModals() {
        const deleteModalElement = document.getElementById('deleteModal');
        if (deleteModalElement && window.bootstrap) {
            this.deleteModal = new bootstrap.Modal(deleteModalElement);
        }
    }

    /**
     * Setup tooltips for interactive elements
     */
    setupTooltips() {
        // Add tooltips to download buttons
        document.querySelectorAll('.btn-download').forEach(btn => {
            const fileName = btn.getAttribute('data-file');
            const fileSize = btn.getAttribute('data-size');
            btn.setAttribute('title', `Download ${fileName} (${fileSize})`);
        });

        // Add tooltips to action buttons
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.setAttribute('title', 'More options');
        });

        // Initialize Bootstrap tooltips if available
        if (window.bootstrap && bootstrap.Tooltip) {
            document.querySelectorAll('[title]').forEach(element => {
                new bootstrap.Tooltip(element);
            });
        }
    }

    /**
     * Enable edit mode for an application card
     */
    enableEditMode(appId) {
        const card = document.querySelector(`[data-app-id="${appId}"]`);
        if (!card) return;

        // Hide content and show edit form
        const content = card.querySelector('.card-content');
        const editForm = card.querySelector('.card-edit-form');
        
        if (content && editForm) {
            content.classList.add('d-none');
            editForm.classList.remove('d-none');
            this.currentEditingCard = appId;

            // Focus on the first input
            const firstInput = editForm.querySelector('input, textarea');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 100);
            }

            this.showNotification('Edit mode enabled. Make your changes and click Save.', 'info');
        }
    }

    /**
     * Save application changes
     */
    saveApplication() {
        if (!this.currentEditingCard) return;

        const card = document.querySelector(`[data-app-id="${this.currentEditingCard}"]`);
        if (!card) return;

        const editForm = card.querySelector('.card-edit-form');
        const titleInput = editForm.querySelector('.edit-title');
        const descriptionInput = editForm.querySelector('.edit-description');

        // Get new values
        const newTitle = titleInput.value.trim();
        const newDescription = descriptionInput.value.trim();

        if (!newTitle || !newDescription) {
            this.showNotification('Please fill in all required fields.', 'error');
            return;
        }

        // Update the card content
        const cardTitle = card.querySelector('.card-title');
        const cardDescription = card.querySelector('.card-content p');

        if (cardTitle) cardTitle.textContent = newTitle;
        if (cardDescription) cardDescription.textContent = newDescription;

        // Exit edit mode
        this.cancelEdit();

        this.showNotification('Application updated successfully!', 'success');
    }

    /**
     * Cancel edit mode
     */
    cancelEdit() {
        if (!this.currentEditingCard) return;

        const card = document.querySelector(`[data-app-id="${this.currentEditingCard}"]`);
        if (!card) return;

        // Show content and hide edit form
        const content = card.querySelector('.card-content');
        const editForm = card.querySelector('.card-edit-form');
        
        if (content && editForm) {
            content.classList.remove('d-none');
            editForm.classList.add('d-none');
            this.currentEditingCard = null;
        }
    }

    /**
     * Show delete confirmation modal
     */
    showDeleteConfirmation(appId) {
        this.currentEditingCard = appId;
        if (this.deleteModal) {
            this.deleteModal.show();
        }
    }

    /**
     * Confirm and execute delete
     */
    confirmDelete() {
        if (!this.currentEditingCard) return;

        const card = document.querySelector(`[data-app-id="${this.currentEditingCard}"]`);
        if (!card) return;

        // Animate card removal
        card.style.transition = 'all 0.5s ease';
        card.style.opacity = '0';
        card.style.transform = 'translateX(-100%)';

        setTimeout(() => {
            card.remove();
            this.showNotification('Application deleted successfully.', 'success');
        }, 500);

        // Hide modal
        if (this.deleteModal) {
            this.deleteModal.hide();
        }

        this.currentEditingCard = null;
    }

    /**
     * Handle download button clicks
     */
    handleDownload(button) {
        const fileName = button.getAttribute('data-file');
        const fileSize = button.getAttribute('data-size');
        const originalContent = button.innerHTML;

        // Show loading state
        button.disabled = true;
        button.innerHTML = '<span class="loading"></span>Downloading...';

        // Simulate download process
        setTimeout(() => {
            this.simulateDownload(fileName);
            this.showNotification(`Download started: ${fileName} (${fileSize})`, 'success');

            // Restore button state
            button.disabled = false;
            button.innerHTML = originalContent;
        }, 1500);
    }

    /**
     * Simulate file download
     */
    simulateDownload(fileName) {
        // Create a temporary download link
        const link = document.createElement('a');
        link.href = '#';
        link.download = fileName;
        link.style.display = 'none';

        document.body.appendChild(link);
        // Note: In a real application, this would trigger an actual download
        // link.click();
        document.body.removeChild(link);

        console.log(`Simulated download: ${fileName}`);
    }

    /**
     * Handle card hover effects
     */
    handleCardHover(card, isHovering) {
        const icon = card.querySelector('.app-icon-circle');
        if (icon) {
            if (isHovering) {
                icon.style.transform = 'scale(1.1) rotate(5deg)';
            } else {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        }
    }

    /**
     * Show notification message
     */
    showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());

        // Create notification
        const notification = document.createElement('div');
        notification.className = `notification alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1060;
            min-width: 300px;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        `;

        const iconMap = {
            success: 'bi-check-circle',
            error: 'bi-exclamation-triangle',
            warning: 'bi-exclamation-triangle',
            info: 'bi-info-circle'
        };

        notification.innerHTML = `
            <i class="bi ${iconMap[type]} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    /**
     * Get application data
     */
    getApplicationData(appId) {
        const card = document.querySelector(`[data-app-id="${appId}"]`);
        if (!card) return null;

        const title = card.querySelector('.card-title')?.textContent || '';
        const description = card.querySelector('.card-content p')?.textContent || '';
        const icon = card.querySelector('.app-icon-circle i')?.className || '';

        return {
            id: appId,
            title,
            description,
            icon
        };
    }
}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    // Clear any active menu state since applications page doesn't have active menu in sidebar
    sessionStorage.removeItem('activeMenu');
    
    // Remove active class from all sidebar links since this page is not in the main navigation
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });

    // Initialize the applications manager
    window.supportingAppsManager = new SupportingApplicationsManager();

    // Add keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        // Escape key to cancel edit mode
        if (e.key === 'Escape' && window.supportingAppsManager.currentEditingCard) {
            window.supportingAppsManager.cancelEdit();
        }

        // Ctrl/Cmd + S to save (prevent default browser save)
        if ((e.ctrlKey || e.metaKey) && e.key === 's' && window.supportingAppsManager.currentEditingCard) {
            e.preventDefault();
            window.supportingAppsManager.saveApplication();
        }
    });

    // Add smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Initialize Bootstrap tooltips if available
    if (window.bootstrap && bootstrap.Tooltip) {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(tooltip => {
            new bootstrap.Tooltip(tooltip);
        });
    }
});

// Export for potential external use
window.SupportingApplicationsManager = SupportingApplicationsManager;