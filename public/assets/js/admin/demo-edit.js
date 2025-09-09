/**
 * INLISLite v3.0 Demo Edit JavaScript
 * CRUD functionality for demo management
 */

$(document).ready(function() {
    console.log('🚀 Demo Edit System Initializing...');
    
    // Initialize DataTable
    initializeDataTable();
    
    // Load demo data
    loadDemoData();
    
    // Update statistics
    updateStatistics();
    
    console.log('✅ Demo Edit System Ready');
});

let demoTable;
let demoData = [];

/**
 * Initialize DataTable
 */
function initializeDataTable() {
    demoTable = $('#demoTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[0, 'desc']],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            emptyTable: "Tidak ada data yang tersedia",
            zeroRecords: "Tidak ada data yang cocok"
        },
        columnDefs: [
            { orderable: false, targets: [5] }, // Actions columns
            { className: "text-center", targets: [0, 3] }
        ]
    });
}

/**
 * Load demo data from API
 */
async function loadDemoData() {
    showLoading();
    
    try {
        const response = await fetch(`${window.location.origin}/admin/demo/data`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        console.log('📥 Demo data received:', result);
        
        if (result.success && result.data) {
            demoData = result.data;
            
            // Process file information for each demo
            demoData.forEach(demo => {
                if (demo.file_path && demo.file_name) {
                    console.log(`File info for demo ${demo.id}: ${demo.file_name} (${formatFileSize(demo.file_size)})`);
                }
            });
            
            populateTable(demoData);
            console.log('✅ Demo data loaded successfully:', demoData.length);
        } else {
            console.warn('⚠️ No demo data received, using empty array');
            demoData = [];
            populateTable(demoData);
        }
        
    } catch (error) {
        console.error('❌ Error loading demo data:', error);
        showAlert('Error loading demo data: ' + error.message, 'danger');
        demoData = [];
        populateTable(demoData);
    } finally {
        hideLoading();
    }
}

/**
 * Populate DataTable with demo data
 */
function populateTable(data) {
    // Clear existing data
    demoTable.clear();
    
    // Add new data
    data.forEach((demo) => {
        const categoryBadge = getCategoryBadge(demo.category);
        const typeBadge = getTypeBadge(demo.demo_type || 'interactive');
        
        // File information display
        const fileInfo = demo.file_name ? 
            `<div class="file-info">
                <i class="bi bi-file-earmark"></i> ${escapeHtml(demo.file_name)}
                <small class="text-muted d-block">${formatFileSize(demo.file_size)}</small>
            </div>` : 
            `<span class="text-muted">No file</span>`;
        
        demoTable.row.add([
            demo.id,
            `<div class="demo-info">
                <strong>${escapeHtml(demo.title)}</strong>
                ${demo.subtitle ? `<br><small class="text-muted">${escapeHtml(demo.subtitle)}</small>` : ''}
                ${demo.description ? `<br><small>${escapeHtml(demo.description).substring(0, 100)}${demo.description.length > 100 ? '...' : ''}</small>` : ''}
            </div>`,
            categoryBadge,
            typeBadge,
            fileInfo,
            `
                <button class="btn-action edit" onclick="editDemo(${demo.id})" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-action delete" onclick="deleteDemo(${demo.id}, '${escapeHtml(demo.title)}')" title="Delete">
                    <i class="bi bi-trash"></i>
                </button>
            `
        ]);
    });
    
    // Redraw table
    demoTable.draw();
    
    console.log(`📊 Table populated with ${data.length} demos`);
}
    });
    
    // Redraw table
    demoTable.draw();
    
    console.log(`📊 Table populated with ${data.length} demos`);
}

/**
 * Update statistics cards
 */
async function updateStatistics() {
    try {
        const response = await fetch(`${window.location.origin}/admin/demo/statistics`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            const result = await response.json();
            if (result.success && result.statistics) {
                const stats = result.statistics;
                document.getElementById('totalDemo').textContent = stats.total || 0;
                document.getElementById('activeDemo').textContent = stats.active || 0;
                
                // Calculate featured and total views from demoData
                const featuredCount = demoData.filter(demo => demo.is_featured == 1).length;
                const totalViews = demoData.reduce((sum, demo) => sum + (parseInt(demo.view_count) || 0), 0);
                
                document.getElementById('featuredDemo').textContent = featuredCount;
                document.getElementById('totalViews').textContent = totalViews;
            }
        }
    } catch (error) {
        console.error('❌ Error updating statistics:', error);
    }
}

/**
 * Save new demo
 */
async function saveDemo() {
    const form = document.getElementById('addDemoForm');
    const formData = new FormData(form);
    
    // Add form fields that might not be captured by FormData
    formData.append('title', document.getElementById('demoTitle').value.trim());
    formData.append('subtitle', document.getElementById('demoSubtitle')?.value?.trim() || '');
    formData.append('description', document.getElementById('demoDescription').value.trim());
    formData.append('category', document.getElementById('demoCategory').value);
    formData.append('demo_type', document.getElementById('demoType').value);
    formData.append('status', document.getElementById('demoStatus').value);
    formData.append('demo_url', document.getElementById('demoUrl').value.trim());
    formData.append('version', document.getElementById('demoVersion').value.trim());
    formData.append('icon', document.getElementById('demoIcon').value.trim());
    formData.append('features', document.getElementById('demoFeatures').value.trim());
    formData.append('access_level', document.getElementById('demoAccessLevel').value);
    formData.append('sort_order', parseInt(document.getElementById('demoSortOrder').value) || 1);
    formData.append('is_featured', document.getElementById('demoFeatured').checked ? 1 : 0);
    
    // Validate form
    if (!formData.get('title') || !formData.get('description') || !formData.get('category')) {
        showAlert('Judul, deskripsi, dan kategori harus diisi', 'danger');
        return;
    }
    
    showLoading();
    
    try {
        const response = await fetch(`${window.location.origin}/admin/demo/store`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Reload data to get updated file information
            await loadDemoData();
            updateStatistics();
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addDemoModal'));
            if (modal) modal.hide();
            
            // Reset form
            form.reset();
            
            showAlert('Demo berhasil ditambahkan', 'success');
        } else {
            showDemoError(result.message || 'Gagal menyimpan demo.');
        }
    } catch (e) {
        console.error('Error:', e);
        showDemoError(e.message || 'Terjadi kesalahan saat menyimpan demo.');
    } finally {
        hideLoading();
    }
}

function showDemoError(msg) {
    let errorBox = document.getElementById('demoErrorBox');
    if (!errorBox) {
        errorBox = document.createElement('div');
        errorBox.id = 'demoErrorBox';
        errorBox.className = 'alert alert-danger';
        errorBox.style.marginTop = '10px';
        const form = document.getElementById('addDemoForm');
        form.parentNode.insertBefore(errorBox, form);
    }
    errorBox.textContent = msg;
}

/**
 * Edit demo
 */
function editDemo(demoId) {
    const demo = demoData.find(d => d.id == demoId);
    if (!demo) {
        showAlert('Demo tidak ditemukan', 'danger');
        return;
    }
    
    // Populate edit form
    document.getElementById('editDemoId').value = demo.id;
    document.getElementById('editDemoTitle').value = demo.title;
    if (document.getElementById('editDemoSubtitle')) {
        document.getElementById('editDemoSubtitle').value = demo.subtitle || '';
    }
    document.getElementById('editDemoDescription').value = demo.description;
    document.getElementById('editDemoCategory').value = demo.category || '';
    document.getElementById('editDemoType').value = demo.demo_type || 'interactive';
    document.getElementById('editDemoStatus').value = demo.status;
    document.getElementById('editDemoUrl').value = demo.demo_url || '';
    document.getElementById('editDemoVersion').value = demo.version || '';
    document.getElementById('editDemoIcon').value = demo.icon || '';
    document.getElementById('editDemoFeatures').value = demo.features || '';
    document.getElementById('editDemoAccessLevel').value = demo.access_level || 'public';
    document.getElementById('editDemoSortOrder').value = demo.sort_order || 1;
    document.getElementById('editDemoFeatured').checked = demo.is_featured == 1;
    
    // Handle file information
    const currentFileInfo = document.getElementById('currentFileInfo');
    if (demo.file_name && demo.file_path) {
        document.getElementById('currentFileName').textContent = demo.file_name;
        document.getElementById('currentFileSize').textContent = formatFileSize(demo.file_size);
        currentFileInfo.classList.remove('d-none');
    } else {
        currentFileInfo.classList.add('d-none');
    }
    
    // Reset remove file checkbox
    document.getElementById('removeFile').checked = false;
    document.getElementById('editDemoAccessLevel').value = demo.access_level || 'public';
    document.getElementById('editDemoFeatured').checked = demo.is_featured == 1;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editDemoModal'));
    modal.show();
    
    console.log('✏️ Editing demo:', demo.title);
}

/**
 * Update demo
 */
async function updateDemo() {
    const demoId = document.getElementById('editDemoId').value;
    const form = document.getElementById('editDemoForm');
    const formData = new FormData(form);
    
    // Add form fields that might not be captured by FormData
    formData.append('title', document.getElementById('editDemoTitle').value.trim());
    formData.append('subtitle', document.getElementById('editDemoSubtitle')?.value?.trim() || '');
    formData.append('description', document.getElementById('editDemoDescription').value.trim());
    formData.append('category', document.getElementById('editDemoCategory').value);
    formData.append('demo_type', document.getElementById('editDemoType').value);
    formData.append('status', document.getElementById('editDemoStatus').value);
    formData.append('demo_url', document.getElementById('editDemoUrl').value.trim());
    formData.append('version', document.getElementById('editDemoVersion').value.trim());
    formData.append('icon', document.getElementById('editDemoIcon').value.trim());
    formData.append('features', document.getElementById('editDemoFeatures').value.trim());
    formData.append('access_level', document.getElementById('editDemoAccessLevel').value);
    formData.append('sort_order', parseInt(document.getElementById('editDemoSortOrder').value) || 1);
    formData.append('is_featured', document.getElementById('editDemoFeatured').checked ? 1 : 0);
    
    // Handle file removal if checkbox is checked
    if (document.getElementById('removeFile').checked) {
        formData.append('remove_file', '1');
    }
    
    // Validate form
    if (!formData.get('title') || !formData.get('description') || !formData.get('category')) {
        showAlert('Judul, deskripsi, dan kategori harus diisi', 'danger');
        return;
    }
    
    showLoading();
    
    try {
        const response = await fetch(`${window.location.origin}/admin/demo/update/${demoId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Reload data to get updated file information
            await loadDemoData();
            updateStatistics();
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editDemoModal'));
            if (modal) {
                modal.hide();
            }
            
            showAlert(result.message || 'Demo berhasil diperbarui!', 'success');
            console.log('✅ Demo updated successfully');
        } else {
            showAlert(result.message || 'Gagal memperbarui demo', 'danger');
        }
    } catch (error) {
        console.error('❌ Error updating demo:', error);
        showAlert('Error memperbarui demo: ' + error.message, 'danger');
    } finally {
        hideLoading();
    }
}

/**
 * Delete demo
 */
async function deleteDemo(demoId, demoTitle) {
    if (!confirm(`Apakah Anda yakin ingin menghapus demo "${demoTitle}"?`)) {
        return;
    }
    
    showLoading();
    
    try {
        const response = await fetch(`${window.location.origin}/admin/demo/delete/${demoId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Remove from local data
            demoData = demoData.filter(d => d.id != demoId);
            populateTable(demoData);
            updateStatistics();
            
            showAlert(result.message || `Demo "${demoTitle}" berhasil dihapus!`, 'success');
            console.log('✅ Demo deleted successfully');
        } else {
            showAlert(result.message || 'Gagal menghapus demo', 'danger');
        }
    } catch (error) {
        console.error('❌ Error deleting demo:', error);
        showAlert('Error menghapus demo: ' + error.message, 'danger');
    } finally {
        hideLoading();
    }
}

/**
 * Get status CSS class
 */
function getStatusClass(status) {
    const statusClasses = {
        'active': 'aktif',
        'inactive': 'non-aktif',
        'maintenance': 'maintenance'
    };
    return statusClasses[status] || 'non-aktif';
}

/**
 * Get category badge
 */
function getCategoryBadge(category) {
    const categories = {
        'cataloging': 'Katalogisasi',
        'circulation': 'Sirkulasi',
        'membership': 'Keanggotaan',
        'reporting': 'Laporan',
        'opac': 'OPAC',
        'administration': 'Administrasi'
    };
    return `<span class="badge bg-primary">${categories[category] || category}</span>`;
}

/**
 * Get type badge
 */
function getTypeBadge(type) {
    const types = {
        'interactive': 'Interaktif',
        'video': 'Video',
        'screenshot': 'Screenshot',
        'live': 'Live'
    };
    const colors = {
        'interactive': 'success',
        'video': 'info',
        'screenshot': 'warning',
        'live': 'danger'
    };
    return `<span class="badge bg-${colors[type] || 'secondary'}">${types[type] || type}</span>`;
}

/**
 * Escape HTML to prevent XSS
 */
function escapeHtml(text) {
    if (!text) return '';
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

/**
 * Show loading spinner
 */
function showLoading() {
    document.getElementById('loadingSpinner').style.display = 'block';
}

/**
 * Hide loading spinner
 */
function hideLoading() {
    document.getElementById('loadingSpinner').style.display = 'none';
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
 * Show alert message
 */
function showAlert(message, type = 'info') {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <div>${message}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert at the top of main content
    const mainContent = document.querySelector('.enhanced-main-content .container');
    if (mainContent) {
        mainContent.insertBefore(alertDiv, mainContent.firstChild);
    }
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

console.log('📦 Demo Edit JavaScript loaded successfully');
