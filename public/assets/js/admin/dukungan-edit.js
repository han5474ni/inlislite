/**
 * INLISLite v3.0 Dukungan Edit Page
 * CRUD management for dukungan teknis with DataTables integration
 */

// Global variables
let supportTable;
let currentEditId = null;

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
    // loadStatistics(); // disabled - stats section removed
    loadSupport();
}

/**
 * Initialize DataTables
 */
function initializeDataTable() {
    supportTable = $('#supportTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']], // Sort by ID
        columnDefs: [
            { orderable: false, targets: [1, 5] }, // Disable sorting for icon and actions
            { searchable: false, targets: [1, 5] }, // Disable search for icon and actions
            { width: "60px", targets: [0] }, // ID column width
            { width: "80px", targets: [1] }, // Icon column width
            { width: "100px", targets: [3] }, // Category column width
            { width: "150px", targets: [4] }, // Contact column width
            { width: "120px", targets: [5] } // Actions column width
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        drawCallback: function() {
            initializeTooltips();
        }
    });
}

/**
 * Initialize event listeners
 */
function initializeEventListeners() {
    // Icon preview functionality
    document.getElementById('supportIcon').addEventListener('input', function() {
        updateIconPreview(this.value, 'supportIconPreview');
    });
    
    document.getElementById('editSupportIcon').addEventListener('input', function() {
        updateIconPreview(this.value, 'editSupportIconPreview');
    });
    
    // Form submissions
    document.getElementById('addSupportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveSupport();
    });
    
    document.getElementById('editSupportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updateSupport();
    });
    
    // Modal events
    document.getElementById('addSupportModal').addEventListener('hidden.bs.modal', function() {
        resetAddForm();
    });
    
    document.getElementById('editSupportModal').addEventListener('hidden.bs.modal', function() {
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
        // Sample statistics - replace with actual API call
        const stats = {
            total_support: 6,
            active_support: 5,
            featured_support: 2,
            urgent_support: 1
        };
        
        updateStatistics(stats);
        
    } catch (error) {
        // console.error('Error loading statistics:', error);
        // showError('Gagal memuat statistik');
    }
}

/**
 * Update statistics display
 */
function updateStatistics(stats) {
    document.getElementById('totalSupport').textContent = stats.total_support || 0;
    document.getElementById('activeSupport').textContent = stats.active_support || 0;
    document.getElementById('featuredSupport').textContent = stats.featured_support || 0;
    document.getElementById('urgentSupport').textContent = stats.urgent_support || 0;
}

/**
 * Load support data
 */
async function loadSupport() {
    try {
        showLoading();
        
        // Sample data - replace with actual API call
        const sampleSupport = [
            {
                id: 1,
                title: "Technical Support 24/7",
                subtitle: "Bantuan Teknis Sepanjang Waktu",
                description: "Layanan bantuan teknis tersedia 24 jam sehari, 7 hari seminggu untuk mengatasi masalah sistem.",
                category: "technical",
                icon: "bi-headset",
                status: "active",
                priority: "high",
                email: "tech@inlislite.com",
                phone: "+62-21-1234567",
                url: "https://support.inlislite.com",
                contact_info: "Jam operasional: 24/7\nResponse time: < 2 jam",
                is_featured: 1,
                sort_order: 1
            },
            {
                id: 2,
                title: "Installation Help",
                subtitle: "Bantuan Instalasi Sistem",
                description: "Panduan lengkap dan bantuan instalasi sistem INLISLite untuk berbagai platform.",
                category: "installation",
                icon: "bi-download",
                status: "active",
                priority: "medium",
                email: "install@inlislite.com",
                phone: "+62-21-1234568",
                url: null,
                contact_info: "Jam operasional: Senin-Jumat 08:00-17:00",
                is_featured: 0,
                sort_order: 2
            },
            {
                id: 3,
                title: "FAQ & Knowledge Base",
                subtitle: "Pertanyaan yang Sering Diajukan",
                description: "Kumpulan pertanyaan dan jawaban yang sering diajukan beserta dokumentasi lengkap.",
                category: "faq",
                icon: "bi-question-circle",
                status: "active",
                priority: "low",
                email: null,
                phone: null,
                url: "https://faq.inlislite.com",
                contact_info: "Self-service 24/7",
                is_featured: 1,
                sort_order: 3
            }
        ];
        
        populateTable(sampleSupport);
        
    } catch (error) {
        console.error('Error loading support:', error);
        showError('Gagal memuat data dukungan');
    } finally {
        hideLoading();
    }
}

/**
 * Populate DataTable with support data
 */
function populateTable(support) {
    supportTable.clear();
    
    support.forEach(item => {
        const contactInfo = buildContactInfo(item);
        
        const row = [
            item.id,
            `<div class="text-center">
                <i class="${item.icon}" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
            </div>`,
            `<div>
                <div class="fw-semibold">${item.title}</div>
                ${item.subtitle ? `<small class="text-muted">${item.subtitle}</small>` : ''}
                ${item.is_featured ? '<span class="badge bg-warning text-dark ms-2">Unggulan</span>' : ''}
            </div>`,
            `<span class="category-badge ${item.category}">${getCategoryLabel(item.category)}</span>`,
            contactInfo,
            `<div class="d-flex justify-content-center">
                <button class="btn-action edit" onclick="editSupport(${item.id})" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-action delete" onclick="deleteSupport(${item.id})" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>`
        ];
        
        supportTable.row.add(row);
    });
    
    supportTable.draw();
}

/**
 * Build contact info display
 */
function buildContactInfo(item) {
    let contactHtml = '<div class="contact-info">';
    
    if (item.email) {
        contactHtml += `<div class="contact-item"><i class="bi bi-envelope"></i> ${item.email}</div>`;
    }
    
    if (item.phone) {
        contactHtml += `<div class="contact-item"><i class="bi bi-telephone"></i> ${item.phone}</div>`;
    }
    
    if (item.url) {
        contactHtml += `<div class="contact-item"><i class="bi bi-link"></i> <a href="${item.url}" target="_blank">Website</a></div>`;
    }
    
    if (!item.email && !item.phone && !item.url) {
        contactHtml += '<span class="text-muted">-</span>';
    }
    
    contactHtml += '</div>';
    return contactHtml;
}

/**
 * Get category label
 */
function getCategoryLabel(category) {
    const labels = {
        'technical': 'Technical',
        'general': 'General',
        'installation': 'Installation',
        'troubleshooting': 'Troubleshooting',
        'faq': 'FAQ',
        'contact': 'Contact'
    };
    return labels[category] || category;
}

/**
 * Get priority label
 */
function getPriorityLabel(priority) {
    const labels = {
        'low': 'Rendah',
        'medium': 'Sedang',
        'high': 'Tinggi',
        'urgent': 'Urgent'
    };
    return labels[priority] || priority;
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
 * Save new support
 */
async function saveSupport() {
    try {
        const formData = {
            title: document.getElementById('supportTitle').value,
            subtitle: document.getElementById('supportSubtitle').value,
            description: document.getElementById('supportDescription').value,
            category: document.getElementById('supportCategory').value,
            priority: document.getElementById('supportPriority').value,
            status: document.getElementById('supportStatus').value,
            icon: document.getElementById('supportIcon').value,
            email: document.getElementById('supportEmail').value,
            phone: document.getElementById('supportPhone').value,
            url: document.getElementById('supportUrl').value,
            contact_info: document.getElementById('supportContactInfo').value,
            is_featured: document.getElementById('supportFeatured').checked ? 1 : 0,
            sort_order: parseInt(document.getElementById('supportSortOrder').value)
        };
        
        // Validate required fields
        if (!formData.title || !formData.description || !formData.category) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        // Ensure icon has bi- prefix
        if (formData.icon && !formData.icon.startsWith('bi-')) {
            formData.icon = `bi-${formData.icon}`;
        }
        
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Saving support:', formData);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Close modal and refresh data
        const modal = bootstrap.Modal.getInstance(document.getElementById('addSupportModal'));
        modal.hide();
        
        showSuccess('Layanan dukungan berhasil ditambahkan');
        loadSupport();
        loadStatistics();
        
    } catch (error) {
        console.error('Error saving support:', error);
        showError('Gagal menyimpan layanan dukungan');
    } finally {
        hideLoading();
    }
}

/**
 * Edit support
 */
function editSupport(id) {
    // Sample data - replace with actual API call
    const sampleSupport = [
        {
            id: 1,
            title: "Technical Support 24/7",
            subtitle: "Bantuan Teknis Sepanjang Waktu",
            description: "Layanan bantuan teknis tersedia 24 jam sehari, 7 hari seminggu untuk mengatasi masalah sistem.",
            category: "technical",
            icon: "bi-headset",
            status: "active",
            priority: "high",
            email: "tech@inlislite.com",
            phone: "+62-21-1234567",
            url: "https://support.inlislite.com",
            contact_info: "Jam operasional: 24/7\nResponse time: < 2 jam",
            is_featured: 1,
            sort_order: 1
        },
        {
            id: 2,
            title: "Installation Help",
            subtitle: "Bantuan Instalasi Sistem",
            description: "Panduan lengkap dan bantuan instalasi sistem INLISLite untuk berbagai platform.",
            category: "installation",
            icon: "bi-download",
            status: "active",
            priority: "medium",
            email: "install@inlislite.com",
            phone: "+62-21-1234568",
            url: null,
            contact_info: "Jam operasional: Senin-Jumat 08:00-17:00",
            is_featured: 0,
            sort_order: 2
        },
        {
            id: 3,
            title: "FAQ & Knowledge Base",
            subtitle: "Pertanyaan yang Sering Diajukan",
            description: "Kumpulan pertanyaan dan jawaban yang sering diajukan beserta dokumentasi lengkap.",
            category: "faq",
            icon: "bi-question-circle",
            status: "active",
            priority: "low",
            email: null,
            phone: null,
            url: "https://faq.inlislite.com",
            contact_info: "Self-service 24/7",
            is_featured: 1,
            sort_order: 3
        }
    ];
    
    const support = sampleSupport.find(s => s.id === id);
    
    if (!support) {
        showError('Layanan dukungan tidak ditemukan');
        return;
    }
    
    // Populate edit form
    currentEditId = id;
    document.getElementById('editSupportId').value = id;
    document.getElementById('editSupportTitle').value = support.title;
    document.getElementById('editSupportSubtitle').value = support.subtitle || '';
    document.getElementById('editSupportDescription').value = support.description;
    document.getElementById('editSupportCategory').value = support.category;
    document.getElementById('editSupportPriority').value = support.priority;
    document.getElementById('editSupportStatus').value = support.status;
    document.getElementById('editSupportIcon').value = support.icon;
    document.getElementById('editSupportEmail').value = support.email || '';
    document.getElementById('editSupportPhone').value = support.phone || '';
    document.getElementById('editSupportUrl').value = support.url || '';
    document.getElementById('editSupportContactInfo').value = support.contact_info || '';
    document.getElementById('editSupportFeatured').checked = support.is_featured === 1;
    document.getElementById('editSupportSortOrder').value = support.sort_order;
    
    // Update icon preview
    updateIconPreview(support.icon, 'editSupportIconPreview');
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editSupportModal'));
    modal.show();
}

/**
 * Update support
 */
async function updateSupport() {
    try {
        const formData = {
            id: currentEditId,
            title: document.getElementById('editSupportTitle').value,
            subtitle: document.getElementById('editSupportSubtitle').value,
            description: document.getElementById('editSupportDescription').value,
            category: document.getElementById('editSupportCategory').value,
            priority: document.getElementById('editSupportPriority').value,
            status: document.getElementById('editSupportStatus').value,
            icon: document.getElementById('editSupportIcon').value,
            email: document.getElementById('editSupportEmail').value,
            phone: document.getElementById('editSupportPhone').value,
            url: document.getElementById('editSupportUrl').value,
            contact_info: document.getElementById('editSupportContactInfo').value,
            is_featured: document.getElementById('editSupportFeatured').checked ? 1 : 0,
            sort_order: parseInt(document.getElementById('editSupportSortOrder').value)
        };
        
        // Validate required fields
        if (!formData.title || !formData.description || !formData.category) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        // Ensure icon has bi- prefix
        if (formData.icon && !formData.icon.startsWith('bi-')) {
            formData.icon = `bi-${formData.icon}`;
        }
        
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Updating support:', formData);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Close modal and refresh data
        const modal = bootstrap.Modal.getInstance(document.getElementById('editSupportModal'));
        modal.hide();
        
        showSuccess('Layanan dukungan berhasil diperbarui');
        loadSupport();
        loadStatistics();
        
    } catch (error) {
        console.error('Error updating support:', error);
        showError('Gagal memperbarui layanan dukungan');
    } finally {
        hideLoading();
    }
}

/**
 * Delete support
 */
async function deleteSupport(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus layanan dukungan ini?')) {
        return;
    }
    
    try {
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Deleting support:', id);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        showSuccess('Layanan dukungan berhasil dihapus');
        loadSupport();
        loadStatistics();
        
    } catch (error) {
        console.error('Error deleting support:', error);
        showError('Gagal menghapus layanan dukungan');
    } finally {
        hideLoading();
    }
}

/**
 * Contact support
 */
function contactSupport(id) {
    // Sample data - replace with actual API call
    const sampleSupport = [
        {
            id: 1,
            email: "tech@inlislite.com",
            phone: "+62-21-1234567"
        },
        {
            id: 2,
            email: "install@inlislite.com",
            phone: "+62-21-1234568"
        }
    ];
    
    const support = sampleSupport.find(s => s.id === id);
    
    if (!support) {
        showError('Informasi kontak tidak ditemukan');
        return;
    }
    
    let contactOptions = [];
    
    if (support.email) {
        contactOptions.push(`Email: ${support.email}`);
    }
    
    if (support.phone) {
        contactOptions.push(`Telepon: ${support.phone}`);
    }
    
    if (contactOptions.length > 0) {
        alert('Informasi Kontak:\n\n' + contactOptions.join('\n'));
    } else {
        showError('Tidak ada informasi kontak tersedia');
    }
}

/**
 * Reset add form
 */
function resetAddForm() {
    document.getElementById('addSupportForm').reset();
    document.getElementById('supportPriority').value = 'medium';
    document.getElementById('supportStatus').value = 'active';
    document.getElementById('supportSortOrder').value = 1;
    document.getElementById('supportFeatured').checked = false;
    updateIconPreview('', 'supportIconPreview');
}

/**
 * Reset edit form
 */
function resetEditForm() {
    document.getElementById('editSupportForm').reset();
    currentEditId = null;
    updateIconPreview('', 'editSupportIconPreview');
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
window.saveSupport = saveSupport;
window.editSupport = editSupport;
window.updateSupport = updateSupport;
window.deleteSupport = deleteSupport;
window.contactSupport = contactSupport;