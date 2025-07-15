/**
 * INLISLite v3.0 Public Demo Page JavaScript
 * Handles demo interactions and functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    initializeDemoPage();
});

/**
 * Initialize demo page functionality
 */
function initializeDemoPage() {
    initializeCopyButtons();
    initializeDemoButtons();
    initializeAnimations();
    initAccessDemoButton();
}

/**
 * Initialize access demo button
 */
function initAccessDemoButton() {
    const accessBtn = document.getElementById('accessDemoBtn');
    if (accessBtn) {
        accessBtn.addEventListener('click', function() {
            const demoUrl = this.getAttribute('data-url');
            if (demoUrl) {
                // Track demo access
                fetch('/public/demo/track-access', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ url: demoUrl })
                }).catch(error => console.error('Error tracking demo access:', error));
                
                // Open demo in new tab
                window.open(demoUrl, '_blank');
            } else {
                showToast('URL demo tidak tersedia', 'warning');
            }
        });
    }
}

/**
 * Initialize copy to clipboard functionality
 */
function initializeCopyButtons() {
    const copyButtons = document.querySelectorAll('.copy-btn');
    
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const textToCopy = this.getAttribute('data-copy');
            
            navigator.clipboard.writeText(textToCopy).then(() => {
                // Show success feedback
                const originalIcon = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check"></i>';
                this.classList.add('btn-success');
                this.classList.remove('btn-outline-secondary');
                
                setTimeout(() => {
                    this.innerHTML = originalIcon;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-secondary');
                }, 1000);
                
                showToast(`${textToCopy} berhasil disalin!`, 'success');
            }).catch(() => {
                showToast('Gagal menyalin teks', 'error');
            });
        });
    });
}

/**
 * Initialize demo access tracking
 */
function initializeDemoButtons() {
    document.querySelectorAll('.demo-btn').forEach(button => {
        button.addEventListener('click', function() {
            const demoId = this.getAttribute('data-demo-id');
            // Track demo access analytics
            console.log(`Demo ${demoId} accessed`);
            showToast('Membuka demo di tab baru...', 'info');
        });
    });
}

/**
 * Initialize scroll animations
 */
function initializeAnimations() {
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        animatedElements.forEach(element => {
            observer.observe(element);
        });
    } else {
        // Fallback for browsers without Intersection Observer
        animatedElements.forEach(element => {
            element.classList.add('animate-fade-in');
        });
    }
}

/**
 * Format file size in bytes to human-readable format
 * @param {number} bytes - File size in bytes
 * @returns {string} Formatted file size
 */
function formatFileSize(bytes) {
    if (!bytes || isNaN(bytes)) return '0 Bytes';
    
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(1024));
    
    return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
}

/**
 * Show demo details modal
 * @param {number} demoId - Demo ID
 */
function showDemoDetails(demoId) {
    const modal = new bootstrap.Modal(document.getElementById('demoDetailsModal'));
    document.getElementById('demoDetailsModalLabel').textContent = `Detail Demo Program ${demoId}`;
    
    // Show loading
    document.getElementById('demoDetailsContent').innerHTML = `
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memuat detail demo...</p>
        </div>
    `;
    
    modal.show();
    
    // Fetch demo details
    fetch(`/public/demo/details/${demoId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.demo) {
                document.getElementById('demoDetailsContent').innerHTML = generateDemoDetailsContent(data.demo);
                
                // Update access demo button URL if available
                const accessBtn = document.getElementById('accessDemoBtn');
                if (accessBtn && data.demo.url) {
                    accessBtn.setAttribute('data-url', data.demo.url);
                    accessBtn.style.display = 'block';
                } else if (accessBtn) {
                    accessBtn.style.display = 'none';
                }
            } else {
                document.getElementById('demoDetailsContent').innerHTML = generateDemoDetailsContent();
                showToast('Gagal memuat detail demo', 'danger');
            }
        })
        .catch(error => {
            console.error('Error fetching demo details:', error);
            document.getElementById('demoDetailsContent').innerHTML = generateDemoDetailsContent();
            showToast('Terjadi kesalahan saat memuat detail demo', 'danger');
        });
}

/**
 * Generate demo details content
 * @param {Object} demo - Demo data
 * @returns {string} HTML content
 */
function generateDemoDetailsContent(demo = null) {
    // If no demo data is provided, use placeholder content
    if (!demo) {
        demo = {
            title: 'Demo Program',
            description: 'Informasi demo tidak tersedia',
            features: 'Katalogisasi,Sirkulasi,Keanggotaan,Pelaporan,OPAC,Administrasi'
        };
    }
    
    // Parse features if available
    const features = demo.features ? demo.features.split(',').map(f => f.trim()) : [];
    
    // Generate file download section if file is available
    const fileDownloadSection = demo.file_path && demo.file_name ? `
        <div class="mt-4 p-3 bg-light rounded">
            <h6><i class="bi bi-file-earmark-arrow-down me-2"></i>File Demo</h6>
            <div class="d-flex align-items-center">
                <div>
                    <p class="mb-1">${demo.file_name}</p>
                    <small class="text-muted">${formatFileSize(demo.file_size || 0)}</small>
                </div>
                <a href="/public/demo/download/${demo.id}" class="btn btn-sm btn-primary ms-auto">
                    <i class="bi bi-download me-1"></i> Download
                </a>
            </div>
        </div>
    ` : '';
    
    return `
        <div class="row">
            <div class="col-md-8">
                <h6>Screenshot Demo</h6>
                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <div class="bg-light p-4 rounded text-center" style="height: 200px;">
                            <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Dashboard Screenshot</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light p-4 rounded text-center" style="height: 200px;">
                            <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Katalogisasi Screenshot</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light p-4 rounded text-center" style="height: 200px;">
                            <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Sirkulasi Screenshot</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light p-4 rounded text-center" style="height: 200px;">
                            <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">OPAC Screenshot</p>
                        </div>
                    </div>
                </div>
                ${fileDownloadSection}
            </div>
            <div class="col-md-4">
                <h6>Informasi Demo</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><strong>Platform:</strong> Web-based</li>
                    <li class="mb-2"><strong>Browser:</strong> Chrome, Firefox, Safari</li>
                    <li class="mb-2"><strong>Akses:</strong> 24/7</li>
                    <li class="mb-2"><strong>Data Reset:</strong> Setiap 24 jam</li>
                    <li class="mb-2"><strong>Concurrent Users:</strong> Unlimited</li>
                </ul>
                
                <h6 class="mt-4">Fitur yang Dapat Dicoba</h6>
                <ul class="list-unstyled">
                    ${features.length > 0 ? 
                        features.map(feature => `<li class="mb-1"><i class="bi bi-check text-success me-2"></i>${feature}</li>`).join('') :
                        `<li class="mb-1"><i class="bi bi-check text-success me-2"></i>Katalogisasi</li>
                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Sirkulasi</li>
                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Keanggotaan</li>
                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Pelaporan</li>
                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>OPAC</li>
                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Administrasi</li>`
                    }
                </ul>
            </div>
        </div>
    `;
}

/**
 * Show toast notification
 * @param {string} message - Toast message
 * @param {string} type - Toast type (success, error, info, warning)
 */
function showToast(message, type = 'info') {
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    // Initialize Bootstrap toast
    if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
        const bootstrapToast = new bootstrap.Toast(toast);
        bootstrapToast.show();
        
        // Remove toast from DOM after hiding
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    } else {
        // Fallback: show toast without Bootstrap
        toast.style.display = 'block';
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }
}

// Export functions for global access
window.showDemoDetails = showDemoDetails;