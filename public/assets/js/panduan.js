/**
 * Panduan Page JavaScript
 * Handles document management functionality
 */

document.addEventListener('DOMContentLoaded', function () {
    // Modal elements
    const addDocumentModal = new bootstrap.Modal(document.getElementById('addDocumentModal'));
    const editDocumentModal = new bootstrap.Modal(document.getElementById('editDocumentModal'));
    
    // Form elements
    const addDocumentForm = document.getElementById('addDocumentForm');
    const editDocumentForm = document.getElementById('editDocumentForm');
    const saveDocumentBtn = document.getElementById('saveDocument');
    const updateDocumentBtn = document.getElementById('updateDocument');
    
    // Search element
    const searchInput = document.getElementById('searchDocuments');
    
    // Container
    const documentsContainer = document.getElementById('documentsContainer');

    // --- Search Functionality ---
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchDocuments(this.value);
            }, 300);
        });
    }

    function searchDocuments(query) {
        const formData = new FormData();
        formData.append('query', query);
        
        fetch('documents/search', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderDocuments(data.documents);
            } else {
                console.error('Search error:', data.message);
            }
        })
        .catch(error => {
            console.error('Error searching documents:', error);
        });
    }

    // --- Add Document Functionality ---
    if (saveDocumentBtn) {
        saveDocumentBtn.addEventListener('click', function() {
            const formData = new FormData(addDocumentForm);
            
            // Validate required fields
            const title = formData.get('title');
            if (!title || title.trim() === '') {
                showAlert('Mohon isi judul dokumen!', 'warning');
                return;
            }
            
            // Show loading state
            saveDocumentBtn.disabled = true;
            saveDocumentBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
            
            fetch('documents/add', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    addDocumentModal.hide();
                    addDocumentForm.reset();
                    loadDocuments();
                } else {
                    showAlert('Error: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error adding document:', error);
                showAlert('Terjadi kesalahan saat menambah dokumen', 'danger');
            })
            .finally(() => {
                saveDocumentBtn.disabled = false;
                saveDocumentBtn.innerHTML = 'Tambah Dokumen';
            });
        });
    }

    // --- Edit Document Functionality ---
    if (updateDocumentBtn) {
        updateDocumentBtn.addEventListener('click', function() {
            const formData = new FormData(editDocumentForm);
            const id = document.getElementById('editDocumentId').value;
            
            // Validate required fields
            const title = formData.get('title');
            if (!title || title.trim() === '') {
                showAlert('Mohon isi judul dokumen!', 'warning');
                return;
            }
            
            // Show loading state
            updateDocumentBtn.disabled = true;
            updateDocumentBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
            
            fetch(`documents/update/${id}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    editDocumentModal.hide();
                    editDocumentForm.reset();
                    loadDocuments();
                } else {
                    showAlert('Error: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error updating document:', error);
                showAlert('Terjadi kesalahan saat mengupdate dokumen', 'danger');
            })
            .finally(() => {
                updateDocumentBtn.disabled = false;
                updateDocumentBtn.innerHTML = 'Simpan Perubahan';
            });
        });
    }

    // --- Document Actions Event Delegation ---
    document.addEventListener('click', function(e) {
        // Download button
        if (e.target.classList.contains('download-btn') || e.target.closest('.download-btn')) {
            e.preventDefault();
            const btn = e.target.classList.contains('download-btn') ? e.target : e.target.closest('.download-btn');
            const id = btn.dataset.id;
            downloadDocument(id);
        }
        
        // Edit button
        if (e.target.classList.contains('edit-btn') || e.target.closest('.edit-btn')) {
            e.preventDefault();
            const btn = e.target.classList.contains('edit-btn') ? e.target : e.target.closest('.edit-btn');
            const id = btn.dataset.id;
            loadDocumentForEdit(id);
        }
        
        // Delete button
        if (e.target.classList.contains('delete-btn') || e.target.closest('.delete-btn')) {
            e.preventDefault();
            const btn = e.target.classList.contains('delete-btn') ? e.target : e.target.closest('.delete-btn');
            const id = btn.dataset.id;
            
            if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
                deleteDocument(id);
            }
        }
    });

    // --- Document Functions ---
    function loadDocuments() {
        // Show loading state
        documentsContainer.innerHTML = `
            <div class="loading-state text-center py-5">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted">Memuat dokumen...</p>
            </div>
        `;
        
        fetch('documents/')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderDocuments(data.documents);
                } else {
                    console.error('Error loading documents:', data.message);
                    showEmptyState();
                }
            })
            .catch(error => {
                console.error('Error loading documents:', error);
                showEmptyState();
            });
    }

    function loadDocumentForEdit(id) {
        fetch(`documents/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.document) {
                    const document = data.document;
                    
                    // Populate edit form
                    document.getElementById('editDocumentId').value = document.id;
                    document.getElementById('editDocumentTitle').value = document.title || '';
                    document.getElementById('editDocumentDescription').value = document.description || '';
                    document.getElementById('editDocumentFileSize').value = document.file_size || '';
                    document.getElementById('editDocumentVersion').value = document.version || '';
                    
                    // Show modal
                    editDocumentModal.show();
                } else {
                    showAlert('Error: Tidak dapat memuat data dokumen', 'danger');
                }
            })
            .catch(error => {
                console.error('Error loading document:', error);
                showAlert('Terjadi kesalahan saat memuat data dokumen', 'danger');
            });
    }

    function downloadDocument(id) {
        // Add download animation
        const btn = document.querySelector(`[data-id="${id}"].download-btn`);
        if (btn) {
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i>Mengunduh...';
            btn.disabled = true;
        }
        
        fetch(`documents/download/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    // In a real application, this would trigger actual file download
                    console.log('Download document:', data.document);
                } else {
                    showAlert('Error: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error downloading document:', error);
                showAlert('Terjadi kesalahan saat mengunduh dokumen', 'danger');
            })
            .finally(() => {
                if (btn) {
                    btn.innerHTML = '<i class="fa-solid fa-download me-1"></i>Unduh';
                    btn.disabled = false;
                }
            });
    }

    function deleteDocument(id) {
        fetch(`documents/delete/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    loadDocuments();
                } else {
                    showAlert('Error: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error deleting document:', error);
                showAlert('Terjadi kesalahan saat menghapus dokumen', 'danger');
            });
    }

    function renderDocuments(documents) {
        if (!documents || documents.length === 0) {
            showEmptyState();
            return;
        }

        let html = '';
        documents.forEach((document, index) => {
            html += `
                <div class="document-item" data-id="${document.id}">
                    <div class="document-number">
                        <span>${index + 1}</span>
                    </div>
                    <div class="document-content">
                        <h6 class="document-title">${escapeHtml(document.title)}</h6>
                        <p class="document-description">${escapeHtml(document.description || '')}</p>
                        <div class="document-meta">
                            <span class="badge bg-primary">PDF</span>
                            <span class="file-size">${escapeHtml(document.file_size || '0 MB')}</span>
                            ${document.version ? `<span class="version">v${escapeHtml(document.version)}</span>` : ''}
                        </div>
                    </div>
                    <div class="document-actions">
                        <button class="btn btn-outline-success btn-sm download-btn" data-id="${document.id}">
                            <i class="fa-solid fa-download me-1"></i>Unduh
                        </button>
                        <button class="btn btn-outline-primary btn-sm edit-btn" data-id="${document.id}">
                            <i class="fa-solid fa-edit me-1"></i>Edit
                        </button>
                        <button class="btn btn-outline-danger btn-sm delete-btn" data-id="${document.id}">
                            <i class="fa-solid fa-trash me-1"></i>Hapus
                        </button>
                    </div>
                </div>
            `;
        });

        documentsContainer.innerHTML = html;
    }

    function showEmptyState() {
        documentsContainer.innerHTML = `
            <div class="empty-state text-center py-5">
                <div class="empty-icon mb-3">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h6 class="text-muted">Belum ada dokumen panduan</h6>
                <p class="text-muted small">Tambahkan dokumen panduan pertama Anda</p>
            </div>
        `;
    }

    // --- Utility Functions ---
    function showAlert(message, type = 'info') {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert-notification');
        existingAlerts.forEach(alert => alert.remove());

        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-notification`;
        alertDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1060;
            min-width: 300px;
            max-width: 400px;
        `;

        const iconMap = {
            success: 'fa-check-circle',
            danger: 'fa-exclamation-triangle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle',
        };

        alertDiv.innerHTML = `
            <i class="fa-solid ${iconMap[type]} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(alertDiv);

        // Auto remove after 4 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 4000);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // --- Setup Database Function ---
    window.setupDocuments = function() {
        if (confirm('Apakah Anda yakin ingin membuat database dan data contoh?')) {
            fetch('documents/setup', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showAlert('Error: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error setting up database:', error);
                showAlert('Terjadi kesalahan saat setup database', 'danger');
            });
        }
    };

    // --- Initialize ---
    console.log('Panduan page initialized');
});
