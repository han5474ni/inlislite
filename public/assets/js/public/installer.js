/**
 * INLISLite v3.0 Public Installer Page
 * JavaScript for download functionality and UI interactions
 */

// Global variables
let downloadStats = {};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

/**
 * Initialize the application
 */
function initializeApp() {
    initializeEventListeners();
    initializeSearch();
    loadDownloadStats();
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
    
    // Download buttons
    const downloadButtons = document.querySelectorAll('.btn-download, .btn-download-mini');
    downloadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const packageType = this.getAttribute('data-package');
            const packageName = this.getAttribute('data-name');
            handleDownload(packageType, packageName, this);
        });
    });
    
    // Copy buttons for credentials
    const copyButtons = document.querySelectorAll('.copy-btn');
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const textToCopy = this.getAttribute('data-copy');
            copyToClipboard(textToCopy, this);
        });
    });
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
 * Handle search functionality
 */
function handleSearch() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    
    // Search in main packages
    const mainPackages = document.querySelectorAll('#mainPackagesContainer .package-card');
    mainPackages.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const description = card.querySelector('.card-description').textContent.toLowerCase();
        const features = Array.from(card.querySelectorAll('.feature-item span')).map(span => span.textContent.toLowerCase()).join(' ');
        
        const isVisible = title.includes(searchTerm) || 
                         description.includes(searchTerm) || 
                         features.includes(searchTerm);
        
        card.parentElement.style.display = isVisible ? 'block' : 'none';
    });
    
    // Search in additional packages
    const additionalPackages = document.querySelectorAll('#additionalPackagesContainer .mini-package-card');
    additionalPackages.forEach(card => {
        const title = card.querySelector('.mini-package-title').textContent.toLowerCase();
        const description = card.querySelector('.mini-package-description').textContent.toLowerCase();
        
        const isVisible = title.includes(searchTerm) || description.includes(searchTerm);
        
        card.parentElement.style.display = isVisible ? 'block' : 'none';
    });
}

/**
 * Handle download functionality
 */
async function handleDownload(packageType, packageName, button) {
    try {
        // Show loading state
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memproses...';
        button.disabled = true;
        
        // Record download
        const downloadData = {
            package_type: packageType,
            filename: `${packageName.replace(/\s+/g, '_').toLowerCase()}.zip`,
            file_size: getPackageSize(packageType),
            description: packageName,
            download_date: new Date().toISOString(),
            user_agent: navigator.userAgent,
            ip_address: await getClientIP()
        };
        
        // Simulate download recording (replace with actual API call)
        await recordDownload(downloadData);
        
        // Simulate file download
        simulateDownload(downloadData.filename);
        
        // Update download stats
        updateDownloadStats(packageType);
        
        // Show success message
        showSuccess(`${packageName} berhasil diunduh!`);
        
    } catch (error) {
        console.error('Download error:', error);
        showError('Gagal mengunduh file. Silakan coba lagi.');
    } finally {
        // Restore button state
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 2000);
    }
}

/**
 * Get package size based on type
 */
function getPackageSize(packageType) {
    const sizes = {
        'source': '25 MB',
        'installer': '45 MB',
        'database': '2 MB',
        'documentation': '15 MB'
    };
    return sizes[packageType] || '10 MB';
}

/**
 * Get client IP address
 */
async function getClientIP() {
    try {
        const response = await fetch('https://api.ipify.org?format=json');
        const data = await response.json();
        return data.ip;
    } catch (error) {
        return 'unknown';
    }
}

/**
 * Record download to server
 */
async function recordDownload(downloadData) {
    try {
        // Replace with actual API endpoint
        const response = await fetch('/admin/installer/saveDownload', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(downloadData)
        });
        
        if (!response.ok) {
            throw new Error('Failed to record download');
        }
        
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Failed to record download:', error);
        // Don't throw error to prevent blocking download
    }
}

/**
 * Simulate file download
 */
function simulateDownload(filename) {
    // Create a temporary link element
    const link = document.createElement('a');
    link.href = '#'; // Replace with actual download URL
    link.download = filename;
    link.style.display = 'none';
    
    // Add to DOM, click, and remove
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // In a real implementation, this would trigger an actual file download
    console.log(`Downloading: ${filename}`);
}

/**
 * Copy text to clipboard
 */
async function copyToClipboard(text, button) {
    try {
        await navigator.clipboard.writeText(text);
        
        // Show feedback
        const originalIcon = button.innerHTML;
        button.innerHTML = '<i class="bi bi-check"></i>';
        button.classList.add('text-success');
        
        setTimeout(() => {
            button.innerHTML = originalIcon;
            button.classList.remove('text-success');
        }, 2000);
        
        showSuccess('Teks berhasil disalin ke clipboard!');
        
    } catch (error) {
        console.error('Failed to copy text:', error);
        
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        
        showSuccess('Teks berhasil disalin ke clipboard!');
    }
}

/**
 * Load download statistics
 */
async function loadDownloadStats() {
    try {
        // Replace with actual API endpoint
        const response = await fetch('/admin/installer/getDownloadStats', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (response.ok) {
            const result = await response.json();
            downloadStats = result.stats || {};
        }
    } catch (error) {
        console.error('Failed to load download stats:', error);
    }
}

/**
 * Update download statistics
 */
function updateDownloadStats(packageType) {
    if (downloadStats[packageType]) {
        downloadStats[packageType]++;
    } else {
        downloadStats[packageType] = 1;
    }
}

/**
 * Refresh content
 */
function refreshContent() {
    // Clear search
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
        handleSearch();
    }
    
    // Reload download stats
    loadDownloadStats();
    
    showSuccess('Konten berhasil diperbarui');
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