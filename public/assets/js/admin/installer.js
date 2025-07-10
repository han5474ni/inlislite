/**
 * INLISLite v3.0 Installer Page JavaScript
 * Handles downloads, copy functionality, and database integration
 */

class InstallerManager {
    constructor() {
        this.init();
        this.bindEvents();
        this.loadInstallerData();
    }

    init() {
        // Add fade-in animation to cards
        this.addFadeInAnimation();
        
        // Initialize tooltips
        this.initTooltips();
        
        // Set up download tracking
        this.downloadStats = {
            source: 0,
            php: 0,
            sql: 0
        };
    }

    addFadeInAnimation() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('fade-in');
            }, index * 100);
        });
    }

    initTooltips() {
        // Initialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    bindEvents() {
        // Download buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.btn-download, .btn-download-mini')) {
                this.handleDownload(e);
            }
            
            if (e.target.closest('.copy-btn')) {
                this.handleCopy(e);
            }
        });

        // Hover effects for cards
        this.addHoverEffects();
        
        // Scroll animations
        this.addScrollAnimations();
    }

    handleDownload(e) {
        e.preventDefault();
        const button = e.target.closest('.btn-download, .btn-download-mini');
        const packageType = button.dataset.package;
        
        // Add loading state
        this.setLoadingState(button, true);
        
        // Simulate download process
        setTimeout(() => {
            this.processDownload(packageType, button);
        }, 1000);
    }

    processDownload(packageType, button) {
        const downloads = {
            source: {
                filename: 'inlislite-v3.2-source-code.zip',
                size: '25 MB',
                description: 'Source Code PHP Lengkap'
            },
            php: {
                filename: 'inlislite-v3.2-php-source.zip',
                size: '20 MB',
                description: 'File Sumber PHP'
            },
            sql: {
                filename: 'inlislite_empty_database.sql',
                size: '2 MB',
                description: 'Database Kosong'
            }
        };

        const downloadInfo = downloads[packageType];
        
        if (downloadInfo) {
            // Update download stats
            this.downloadStats[packageType]++;
            
            // Save to database
            this.saveDownloadToDatabase(packageType, downloadInfo);
            
            // Show success message
            this.showDownloadSuccess(downloadInfo);
            
            // Simulate file download
            this.simulateFileDownload(downloadInfo.filename);
        }
        
        // Remove loading state
        this.setLoadingState(button, false);
    }

    simulateFileDownload(filename) {
        // Create a temporary download link
        const link = document.createElement('a');
        link.href = '#'; // In real implementation, this would be the actual file URL
        link.download = filename;
        link.style.display = 'none';
        
        document.body.appendChild(link);
        // link.click(); // Uncomment for actual download
        document.body.removeChild(link);
        
        console.log(`Download initiated: ${filename}`);
    }

    async saveDownloadToDatabase(packageType, downloadInfo) {
        try {
            const downloadData = {
                package_type: packageType,
                filename: downloadInfo.filename,
                file_size: downloadInfo.size,
                description: downloadInfo.description,
                download_date: new Date().toISOString(),
                user_agent: navigator.userAgent,
                ip_address: await this.getUserIP()
            };

            // Send to server
            const response = await fetch(`${window.location.origin}/admin/installer/saveDownload`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(downloadData)
            });

            if (response.ok) {
                const result = await response.json();
                console.log('Download saved to database:', result);
                
                if (result.success) {
                    // Update local stats
                    this.downloadStats[packageType]++;
                }
            } else {
                console.error('Failed to save download to database');
            }
        } catch (error) {
            console.error('Error saving download:', error);
        }
    }

    async getUserIP() {
        try {
            const response = await fetch('https://api.ipify.org?format=json');
            const data = await response.json();
            return data.ip;
        } catch (error) {
            return 'Unknown';
        }
    }

    handleCopy(e) {
        e.preventDefault();
        const button = e.target.closest('.copy-btn');
        const textToCopy = button.dataset.copy;
        
        // Copy to clipboard
        navigator.clipboard.writeText(textToCopy).then(() => {
            this.showCopySuccess(button);
        }).catch(() => {
            // Fallback for older browsers
            this.fallbackCopy(textToCopy, button);
        });
    }

    fallbackCopy(text, button) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            this.showCopySuccess(button);
        } catch (err) {
            console.error('Failed to copy text: ', err);
        }
        
        document.body.removeChild(textArea);
    }

    showCopySuccess(button) {
        const originalClasses = button.className;
        const originalContent = button.innerHTML;
        
        button.classList.add('copy-success');
        button.innerHTML = '<i class="bi bi-check"></i>';
        
        setTimeout(() => {
            button.className = originalClasses;
            button.innerHTML = originalContent;
        }, 2000);
    }

    setLoadingState(button, isLoading) {
        if (isLoading) {
            button.classList.add('loading');
            button.disabled = true;
            const originalText = button.innerHTML;
            button.dataset.originalText = originalText;
            button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengunduh...';
        } else {
            button.classList.remove('loading');
            button.disabled = false;
            button.innerHTML = button.dataset.originalText || button.innerHTML;
        }
    }

    showDownloadSuccess(downloadInfo) {
        const alertHtml = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                    <div>
                        <strong>Download Berhasil!</strong><br>
                        <small>${downloadInfo.description} (${downloadInfo.filename}) - ${downloadInfo.size}</small>
                    </div>
                </div>
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
    }

    addHoverEffects() {
        // Add pulse effect to download buttons
        const downloadButtons = document.querySelectorAll('.btn-download, .btn-download-mini');
        downloadButtons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.classList.add('pulse');
            });
            
            button.addEventListener('mouseleave', () => {
                button.classList.remove('pulse');
            });
        });

        // Add hover effects to step items
        const stepItems = document.querySelectorAll('.step-item');
        stepItems.forEach((item, index) => {
            item.addEventListener('mouseenter', () => {
                item.style.transform = 'translateX(10px)';
                item.style.boxShadow = '0 8px 25px rgba(40, 167, 69, 0.15)';
            });
            
            item.addEventListener('mouseleave', () => {
                item.style.transform = 'translateX(0)';
                item.style.boxShadow = '';
            });
        });
    }

    addScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe cards and sections
        const elementsToAnimate = document.querySelectorAll('.card, .step-item, .feature-item');
        elementsToAnimate.forEach(el => {
            observer.observe(el);
        });
    }

    async loadInstallerData() {
        try {
            const response = await fetch(`${window.location.origin}/admin/installer/getData`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.updateInstallerInfo(data);
            }
        } catch (error) {
            console.error('Error loading installer data:', error);
        }
    }

    updateInstallerInfo(data) {
        // Update download counts if available
        if (data.downloadStats) {
            this.downloadStats = { ...this.downloadStats, ...data.downloadStats };
        }

        // Update version info if available
        if (data.version) {
            const versionElements = document.querySelectorAll('.version-info');
            versionElements.forEach(el => {
                el.textContent = data.version;
            });
        }

        // Update file sizes if available
        if (data.fileSizes) {
            Object.keys(data.fileSizes).forEach(packageType => {
                const sizeElement = document.querySelector(`[data-package="${packageType}"] .package-size span`);
                if (sizeElement) {
                    sizeElement.textContent = `Ukuran file: ${data.fileSizes[packageType]}`;
                }
            });
        }
    }

    // Public method to get download statistics
    getDownloadStats() {
        return this.downloadStats;
    }

    // Public method to reset download statistics
    resetDownloadStats() {
        this.downloadStats = {
            source: 0,
            php: 0,
            sql: 0
        };
    }
}

// Utility functions
const InstallerUtils = {
    formatFileSize(bytes) {
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        if (bytes === 0) return '0 Bytes';
        const i = Math.floor(Math.log(bytes) / Math.log(1024));
        return Math.round(bytes / Math.pow(1024, i) * 100) / 100 + ' ' + sizes[i];
    },

    formatDate(date) {
        return new Intl.DateTimeFormat('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }).format(new Date(date));
    },

    validateDownloadData(data) {
        const required = ['package_type', 'filename', 'file_size'];
        return required.every(field => data.hasOwnProperty(field) && data[field]);
    },

    showNotification(message, type = 'info') {
        const alertClass = `alert-${type}`;
        const iconClass = {
            success: 'bi-check-circle-fill',
            error: 'bi-exclamation-triangle-fill',
            warning: 'bi-exclamation-triangle-fill',
            info: 'bi-info-circle-fill'
        }[type] || 'bi-info-circle-fill';

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="${iconClass} me-2"></i>
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
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize installer manager
    window.installerManager = new InstallerManager();
    
    // Add global error handler
    window.addEventListener('error', function(e) {
        console.error('Installer page error:', e.error);
        InstallerUtils.showNotification('Terjadi kesalahan pada halaman installer.', 'error');
    });
    
    // Add unhandled promise rejection handler
    window.addEventListener('unhandledrejection', function(e) {
        console.error('Unhandled promise rejection:', e.reason);
        InstallerUtils.showNotification('Terjadi kesalahan dalam memproses permintaan.', 'error');
    });
    
    console.log('Installer page initialized successfully');
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { InstallerManager, InstallerUtils };
}