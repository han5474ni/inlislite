/**
 * JavaScript untuk halaman Panduan INLISLite v3 - CRUD Implementation
 * Complete AJAX implementation for document management
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize components
    initializeBackButton();
    initializeSearch();
    initializeDocumentActions();
    initializeModal();
    
    console.log('Panduan INLISLite v3 CRUD - Script loaded successfully');
});

// Global variables
const baseUrl = window.location.origin;
let isEditMode = false;
let currentEditId = null;

/**
 * Initialize back button functionality
 */
function initializeBackButton() {
    const backBtn = document.getElementById('backBtn');
    
    if (backBtn) {
        backBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Add click animation
            this.style.transform = 'translateX(-4px)';
            
            setTimeout(() => {
                this.style.transform = 'translateX(0)';
            }, 150);
            
            // Navigate back
            if (window.history.length > 1) {
                window.history.back();
            } else {
                // Fallback to dashboard
                window.location.href = window.location.origin + '/dashboard';
            }
        });
        
        // Keyboard support
        backBtn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    }
}

/**
 * Initialize search functionality with AJAX
 */
function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.trim();
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            // Debounce search to avoid too many requests
            searchTimeout = setTimeout(() => {
                searchDocuments(searchTerm);
            }, 500);
        });
        
        // Add focus effects
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    }
}

/**
 * Search documents via AJAX
 */
function searchDocuments(keyword) {
    fetch(`${baseUrl}/documents/search`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ keyword: keyword })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            renderDocuments(data.data);
            updateDocumentCount(data.count);
        } else {
            showNotification('Gagal mencari dokumen: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Search error:', error);
        showNotification('Terjadi kesalahan saat mencari dokumen', 'error');
    });
}

/**
 * Initialize document action buttons
 */
function initializeDocumentActions() {
    // Add event delegation for dynamic content
    document.addEventListener('click', function(e) {
        const target = e.target.closest('.btn-action');
        if (!target) return;
        
        e.preventDefault();
        
        // Add loading state
        addLoadingState(target);
        
        // Determine action type
        if (target.classList.contains('btn-download')) {
            handleDownload(target);
        } else if (target.classList.contains('btn-edit')) {
            handleEdit(target);
        } else if (target.classList.contains('btn-delete')) {
            handleDelete(target);
        }
    });
}

/**
 * Handle document download with real implementation
 */
function handleDownload(button) {
    const documentId = button.closest('.document-item')?.dataset.documentId;
    const documentTitle = button.closest('.document-item')?.querySelector('.document-title')?.textContent;
    const downloadCountElement = button.closest('.document-item')?.querySelector('.document-downloads');
    
    if (!documentId) {
        showNotification('ID dokumen tidak ditemukan', 'error');
        return;
    }
    
    // Show loading state
    addLoadingState(button);
    
    // Create download URL and trigger download
    const downloadUrl = `${baseUrl}/documents/download/${documentId}`;
    
    // Create invisible iframe for download to avoid page navigation
    const downloadFrame = document.createElement('iframe');
    downloadFrame.style.display = 'none';
    downloadFrame.src = downloadUrl;
    document.body.appendChild(downloadFrame);
    
    // Remove loading state after short delay
    setTimeout(() => {
        removeLoadingState(button);
        document.body.removeChild(downloadFrame);
        
        // Update download count immediately with animation
        if (downloadCountElement) {
            const currentCount = parseInt(downloadCountElement.textContent.match(/\d+/)[0]) || 0;
            const newCount = currentCount + 1;
            
            // Animate the download count change
            downloadCountElement.style.transform = 'scale(1.1)';
            downloadCountElement.style.color = '#28a745';
            downloadCountElement.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                downloadCountElement.textContent = `${newCount} unduhan`;
                setTimeout(() => {
                    downloadCountElement.style.transform = 'scale(1)';
                    downloadCountElement.style.color = '';
                }, 200);
            }, 150);
        }
        
        showNotification(`✓ File berhasil diunduh: ${documentTitle}`, 'success');
    }, 2000); // 2 second delay to ensure download starts
}

/**
 * Handle document edit with AJAX
 */
function handleEdit(button) {
    const documentId = button.closest('.document-item')?.dataset.documentId;
    
    if (!documentId) {
        showNotification('ID dokumen tidak ditemukan', 'error');
        return;
    }
    
    // Fetch document data via AJAX
    fetch(`${baseUrl}/documents/${documentId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        removeLoadingState(button);
        
        if (data.success) {
            // Set edit mode
            isEditMode = true;
            currentEditId = documentId;
            
            // Populate modal with data
            populateEditModal(data.data);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('addDocumentModal'));
            modal.show();
        } else {
            showNotification('Gagal mengambil data dokumen: ' + data.message, 'error');
        }
    })
    .catch(error => {
        removeLoadingState(button);
        console.error('Edit error:', error);
        showNotification('Terjadi kesalahan saat mengambil data dokumen', 'error');
    });
}

/**
 * Handle document delete with AJAX
 */
function handleDelete(button) {
    const documentId = button.closest('.document-item')?.dataset.documentId;
    const documentTitle = button.closest('.document-item')?.querySelector('.document-title')?.textContent;
    
    if (!documentId) {
        showNotification('ID dokumen tidak ditemukan', 'error');
        return;
    }
    
    removeLoadingState(button);
    
    // Show confirmation dialog
    if (confirm(`Apakah Anda yakin ingin menghapus dokumen "${documentTitle}"?`)) {
        const documentItem = button.closest('.document-item');
        
        // Show loading on delete
        addLoadingState(button);
        
        // Delete via AJAX
        fetch(`${baseUrl}/documents/delete/${documentId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            removeLoadingState(button);
            
            if (data.success) {
                // Add fade out animation
                documentItem.style.opacity = '0';
                documentItem.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    documentItem.remove();
                    updateDocumentCount();
                    reorderDocumentNumbers(); // Auto-reorder numbers
                    showNotification(data.message, 'success');
                }, 300);
            } else {
                showNotification('Gagal menghapus dokumen: ' + data.message, 'error');
            }
        })
        .catch(error => {
            removeLoadingState(button);
            console.error('Delete error:', error);
            showNotification('Terjadi kesalahan saat menghapus dokumen', 'error');
        });
    }
}

/**
 * Initialize modal functionality
 */
function initializeModal() {
    const addDocumentModal = document.getElementById('addDocumentModal');
    const addDocumentForm = document.getElementById('addDocumentForm');
    const saveBtn = document.getElementById('saveDocumentBtn');
    
    if (addDocumentModal) {
        addDocumentModal.addEventListener('shown.bs.modal', function() {
            // Focus on first input
            const firstInput = this.querySelector('input[type="text"]');
            if (firstInput) {
                firstInput.focus();
            }
        });
        
        addDocumentModal.addEventListener('hidden.bs.modal', function() {
            // Reset modal state
            resetModal();
        });
    }
    
    // Save button click handler
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            saveDocument();
        });
    }
    
    // Add real-time validation
    if (addDocumentForm) {
        const inputs = addDocumentForm.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateField(this);
                }
            });
        });
    }
}

/**
 * Reset modal to add mode
 */
function resetModal() {
    const form = document.getElementById('addDocumentForm');
    const modalLabel = document.getElementById('addDocumentModalLabel');
    const saveBtn = document.getElementById('saveDocumentBtn');
    const fileHelpText = document.getElementById('fileHelpText');
    const documentFile = document.getElementById('documentFile');
    const currentFileDisplay = document.getElementById('currentFileDisplay');
    
    // Reset form
    if (form) {
        form.reset();
        clearValidationStates();
        clearMessages();
    }
    
    // Reset modal title and button
    if (modalLabel) modalLabel.textContent = 'Tambah Dokumen Baru';
    if (saveBtn) saveBtn.querySelector('.btn-text').textContent = 'Simpan Dokumen';
    
    // Reset file input requirement
    if (documentFile) {
        documentFile.required = true;
    }
    
    // Hide file help text and current file display
    if (fileHelpText) {
        fileHelpText.style.display = 'none';
    }
    
    if (currentFileDisplay) {
        currentFileDisplay.classList.add('d-none');
    }
    
    // Reset global variables
    isEditMode = false;
    currentEditId = null;
}

/**
 * Save document (add/edit) with AJAX
 */
function saveDocument() {
    const form = document.getElementById('addDocumentForm');
    const saveBtn = document.getElementById('saveDocumentBtn');
    const btnText = saveBtn.querySelector('.btn-text');
    const btnSpinner = saveBtn.querySelector('.btn-spinner');
    
    if (!form || !saveBtn) return;
    
    // Clear previous messages
    clearMessages();
    
    // Basic validation
    if (!validateForm(form)) {
        showFormMessage('Mohon lengkapi semua field yang diperlukan', 'error');
        return;
    }
    
    // Show loading state
    btnText.classList.add('d-none');
    btnSpinner.classList.remove('d-none');
    saveBtn.disabled = true;
    
    // Prepare form data
    const formData = new FormData(form);
    
    // Determine URL based on mode
    const url = isEditMode 
        ? `${baseUrl}/documents/update/${currentEditId}`
        : `${baseUrl}/documents/add`;
    
    // Send AJAX request
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification(data.message, 'success');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addDocumentModal'));
            modal.hide();
            
            // Reload documents list
            setTimeout(() => {
                window.location.reload();
            }, 1000);
            
        } else {
            if (data.errors) {
                // Show validation errors
                let errorHtml = '';
                for (const [field, error] of Object.entries(data.errors)) {
                    errorHtml += `<li>${error}</li>`;
                }
                showFormMessage(`<ul class="mb-0">${errorHtml}</ul>`, 'error');
            } else {
                showFormMessage(data.message || 'Terjadi kesalahan', 'error');
            }
        }
    })
    .catch(error => {
        console.error('Save error:', error);
        showFormMessage('Terjadi kesalahan saat menyimpan dokumen', 'error');
    })
    .finally(() => {
        // Reset button state
        btnText.classList.remove('d-none');
        btnSpinner.classList.add('d-none');
        saveBtn.disabled = false;
    });
}

/**
 * Add document to list
 */
function addDocumentToList(documentData) {
    const documentList = document.getElementById('documentList');
    if (!documentList) return;
    
    const existingDocs = documentList.querySelectorAll('.document-item');
    const newId = Date.now(); // Simple ID generation
    const newNumber = existingDocs.length + 1;
    
    const newDocumentHTML = `
        <div class="document-item fade-in" data-document-id="${newId}">
            <div class="d-flex align-items-start">
                <div class="document-number me-3">
                    <span class="number">${newNumber}</span>
                </div>
                <div class="document-content flex-grow-1">
                    <h5 class="document-title mb-2">${documentData.title}</h5>
                    <p class="document-description text-muted mb-2">${documentData.description}</p>
                    <div class="document-meta d-flex align-items-center gap-3">
                        <span class="document-badge">${documentData.type}</span>
                        <span class="document-size">${documentData.file ? (documentData.file.size / 1024 / 1024).toFixed(1) + ' MB' : 'N/A'}</span>
                        <span class="document-version">${documentData.version}</span>
                    </div>
                </div>
                <div class="document-actions">
                    <button class="btn-action btn-download" onclick="downloadDocument(${newId})" title="Unduh">
                        <i class="bi bi-download"></i>
                        Unduh
                    </button>
                    <button class="btn-action btn-edit" onclick="editDocument(${newId})" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn-action btn-delete" onclick="deleteDocument(${newId})" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    documentList.insertAdjacentHTML('beforeend', newDocumentHTML);
    updateDocumentCount();
}

/**
 * Utility functions
 */
function addLoadingState(button) {
    if (!button) return;
    
    button.classList.add('loading');
    button.disabled = true;
    
    const originalContent = button.innerHTML;
    button.dataset.originalContent = originalContent;
    
    // Add spinner
    const spinner = '<i class="bi bi-arrow-clockwise" style="animation: spin 1s linear infinite;"></i>';
    button.innerHTML = spinner + ' Loading...';
}

function removeLoadingState(button) {
    if (!button) return;
    
    button.classList.remove('loading');
    button.disabled = false;
    
    if (button.dataset.originalContent) {
        button.innerHTML = button.dataset.originalContent;
        delete button.dataset.originalContent;
    }
}

function updateDocumentCount(count) {
    const countElement = document.querySelector('.documents-count');
    if (countElement) {
        if (count !== undefined) {
            countElement.textContent = count;
        } else {
            const visibleDocs = document.querySelectorAll('.document-item:not([style*="display: none"])');
            countElement.textContent = visibleDocs.length;
        }
    }
}

function toggleNoResults(show) {
    let noResultsEl = document.getElementById('noResults');
    
    if (show && !noResultsEl) {
        const documentList = document.getElementById('documentList');
        if (documentList) {
            noResultsEl = document.createElement('div');
            noResultsEl.id = 'noResults';
            noResultsEl.className = 'text-center p-5';
            noResultsEl.innerHTML = `
                <div class="text-muted">
                    <i class="bi bi-search fs-1 mb-3 d-block"></i>
                    <h5>Tidak ada dokumen yang ditemukan</h5>
                    <p>Coba gunakan kata kunci yang berbeda</p>
                </div>
            `;
            documentList.appendChild(noResultsEl);
        }
    } else if (!show && noResultsEl) {
        noResultsEl.remove();
    }
}

function validateField(field) {
    const value = field.value.trim();
    const isValid = field.type === 'file' ? field.files.length > 0 : value.length > 0;
    
    field.classList.toggle('is-valid', isValid);
    field.classList.toggle('is-invalid', !isValid);
    
    return isValid;
}

function validateForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    return isValid;
}

function clearValidationStates() {
    const form = document.getElementById('addDocumentForm');
    if (form) {
        const fields = form.querySelectorAll('.is-valid, .is-invalid');
        fields.forEach(field => {
            field.classList.remove('is-valid', 'is-invalid');
        });
    }
}

function populateEditModal(documentData) {
    // Populate form fields with fetched data
    const titleInput = document.getElementById('documentTitle');
    const descInput = document.getElementById('documentDescription');
    const versionInput = document.getElementById('documentVersion');
    const typeSelect = document.getElementById('documentType');
    const documentFile = document.getElementById('documentFile');
    const fileHelpText = document.getElementById('fileHelpText');
    const currentFileDisplay = document.getElementById('currentFileDisplay');
    const currentFileName = document.getElementById('currentFileName');
    
    if (titleInput) titleInput.value = documentData.title || '';
    if (descInput) descInput.value = documentData.description || '';
    if (versionInput) versionInput.value = documentData.version || '';
    if (typeSelect) typeSelect.value = documentData.file_type || '';
    
    // Make file input optional for edit
    if (documentFile) {
        documentFile.required = false;
        documentFile.value = ''; // Clear previous file selection
    }
    
    // Show current file info
    if (currentFileDisplay && currentFileName && documentData.file_name) {
        currentFileName.textContent = documentData.file_name;
        currentFileDisplay.classList.remove('d-none');
    }
    
    // Show file help text
    if (fileHelpText) {
        fileHelpText.style.display = 'block';
    }
    
    // Change modal title and button
    const modalLabel = document.getElementById('addDocumentModalLabel');
    const saveBtn = document.getElementById('saveDocumentBtn');
    
    if (modalLabel) modalLabel.textContent = 'Edit Dokumen';
    if (saveBtn) saveBtn.querySelector('.btn-text').textContent = 'Update Dokumen';
}

/**
 * Render documents list
 */
function renderDocuments(documents) {
    const documentList = document.getElementById('documentList');
    if (!documentList) return;
    
    if (documents.length === 0) {
        documentList.innerHTML = `
            <div class="no-documents text-center py-5">
                <i class="bi bi-file-earmark-x fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada dokumen</h5>
                <p class="text-muted">Klik tombol "Tambah Dokumen" untuk menambahkan dokumen baru.</p>
            </div>
        `;
        return;
    }
    
    let html = '';
    documents.forEach((doc, index) => {
        html += buildDocumentHTML(doc, index + 1);
    });
    
    documentList.innerHTML = html;
}

/**
 * Build document HTML
 */
function buildDocumentHTML(doc, number) {
    const fileSize = formatFileSize(doc.file_size);
    const downloadCount = doc.download_count || 0;
    
    return `
        <div class="document-item" data-document-id="${doc.id}">
            <div class="d-flex align-items-start">
                <div class="document-number me-3">
                    <span class="number">${number}</span>
                </div>
                <div class="document-content flex-grow-1">
                    <h5 class="document-title mb-2">${escapeHtml(doc.title)}</h5>
                    <p class="document-description text-muted mb-2">${escapeHtml(doc.description || '')}</p>
                    <div class="document-meta d-flex align-items-center gap-3">
                        <span class="document-badge">${escapeHtml(doc.file_type)}</span>
                        <span class="document-size">${fileSize}</span>
                        <span class="document-version">${escapeHtml(doc.version || '')}</span>
                        <span class="document-downloads">${downloadCount} unduhan</span>
                    </div>
                </div>
                <div class="document-actions">
                    <button class="btn-action btn-download" title="Unduh">
                        <i class="bi bi-download"></i>
                        Unduh
                    </button>
                    <button class="btn-action btn-edit" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn-action btn-delete" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
}

/**
 * Show form messages
 */
function showFormMessage(message, type) {
    const errorDiv = document.getElementById('form-errors');
    const successDiv = document.getElementById('form-success');
    
    // Clear previous messages
    errorDiv.classList.add('d-none');
    successDiv.classList.add('d-none');
    
    if (type === 'error') {
        errorDiv.innerHTML = message;
        errorDiv.classList.remove('d-none');
    } else {
        successDiv.innerHTML = message;
        successDiv.classList.remove('d-none');
    }
}

/**
 * Clear form messages
 */
function clearMessages() {
    const errorDiv = document.getElementById('form-errors');
    const successDiv = document.getElementById('form-success');
    
    if (errorDiv) errorDiv.classList.add('d-none');
    if (successDiv) successDiv.classList.add('d-none');
}

/**
 * Format file size
 */
function formatFileSize(bytes) {
    if (bytes >= 1073741824) {
        return (bytes / 1073741824).toFixed(2) + ' GB';
    } else if (bytes >= 1048576) {
        return (bytes / 1048576).toFixed(2) + ' MB';
    } else if (bytes >= 1024) {
        return (bytes / 1024).toFixed(2) + ' KB';
    } else {
        return bytes + ' bytes';
    }
}

/**
 * Escape HTML
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Reorder document numbers after delete with animation
 */
function reorderDocumentNumbers() {
    const documentItems = document.querySelectorAll('.document-item:not(.no-documents)');
    documentItems.forEach((item, index) => {
        const numberElement = item.querySelector('.document-number .number');
        if (numberElement) {
            // Add highlight animation for changed numbers
            const currentNumber = parseInt(numberElement.textContent);
            const newNumber = index + 1;
            
            if (currentNumber !== newNumber) {
                // Animate the number change
                numberElement.style.transform = 'scale(1.2)';
                numberElement.style.color = '#007bff';
                numberElement.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    numberElement.textContent = newNumber;
                    
                    setTimeout(() => {
                        numberElement.style.transform = 'scale(1)';
                        numberElement.style.color = '';
                    }, 150);
                }, 150);
            } else {
                numberElement.textContent = newNumber;
            }
        }
    });
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
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

// Global functions for onclick handlers
window.downloadDocument = function(documentId) {
    const button = document.querySelector(`[data-document-id="${documentId}"] .btn-download`);
    if (button) {
        button.click();
    }
};

window.editDocument = function(documentId) {
    const button = document.querySelector(`[data-document-id="${documentId}"] .btn-edit`);
    if (button) {
        button.click();
    }
};

window.deleteDocument = function(documentId) {
    const button = document.querySelector(`[data-document-id="${documentId}"] .btn-delete`);
    if (button) {
        button.click();
    }
};

window.saveDocument = saveDocument;

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .is-invalid {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    }
    
    .is-valid {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
    }
`;
document.head.appendChild(style);
