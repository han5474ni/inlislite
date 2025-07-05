/**
 * Panduan Page JavaScript - INLISLite v3
 * Handles documentation management functionality
 */

document.addEventListener('DOMContentLoaded', function () {
    // Initialize components
    initializeModals();
    initializeSearch();
    initializeEventListeners();
    
    console.log('Panduan page initialized successfully');
});

// ========================================
// MODAL INITIALIZATION
// ========================================

let addDocModal, editDocModal;

function initializeModals() {
    // Initialize Bootstrap modals
    const addDocModalElement = document.getElementById('addDocModal');
    const editDocModalElement = document.getElementById('editDocModal');
    
    if (addDocModalElement) {
        addDocModal = new bootstrap.Modal(addDocModalElement);
    }
    
    if (editDocModalElement) {
        editDocModal = new bootstrap.Modal(editDocModalElement);
    }
    
    // Reset forms when modals are hidden
    if (addDocModalElement) {
        addDocModalElement.addEventListener('hidden.bs.modal', function () {
            resetForm('addDocForm');
        });
    }
    
    if (editDocModalElement) {
        editDocModalElement.addEventListener('hidden.bs.modal', function () {
            resetForm('editDocForm');
        });
    }
}

// ========================================
// SEARCH FUNCTIONALITY
// ========================================

function initializeSearch() {
    const searchInput = document.getElementById('searchDocs');
    
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value.trim());
            }, 300);
        });
        
        // Clear search on escape key
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                performSearch('');
            }
        });
    }
}

function performSearch(query) {
    const docItems = document.querySelectorAll('.doc-item');
    const docCount = document.getElementById('docCount');
    let visibleCount = 0;
    
    docItems.forEach(item => {
        const title = item.getAttribute('data-title') || '';
        const description = item.getAttribute('data-description') || '';
        const searchText = (title + ' ' + description).toLowerCase();
        
        if (query === '' || searchText.includes(query.toLowerCase())) {
            item.style.display = 'flex';
            visibleCount++;
            
            // Highlight search terms
            if (query !== '') {
                highlightSearchTerms(item, query);
            } else {
                removeHighlights(item);
            }
        } else {
            item.style.display = 'none';
        }
    });
    
    // Update document count
    if (docCount) {
        docCount.textContent = visibleCount;
    }
    
    // Show no results message if needed
    showNoResultsMessage(visibleCount === 0 && query !== '');
}

function highlightSearchTerms(item, query) {
    const titleElement = item.querySelector('.doc-title');
    const descriptionElement = item.querySelector('.doc-description');
    
    if (titleElement) {
        titleElement.innerHTML = highlightText(titleElement.textContent, query);
    }
    
    if (descriptionElement) {
        descriptionElement.innerHTML = highlightText(descriptionElement.textContent, query);
    }
}

function removeHighlights(item) {
    const titleElement = item.querySelector('.doc-title');
    const descriptionElement = item.querySelector('.doc-description');
    
    if (titleElement) {
        titleElement.innerHTML = titleElement.textContent;
    }
    
    if (descriptionElement) {
        descriptionElement.innerHTML = descriptionElement.textContent;
    }
}

function highlightText(text, query) {
    if (!query) return text;
    
    const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
    return text.replace(regex, '<span class="search-highlight">$1</span>');
}

function showNoResultsMessage(show) {
    const documentationList = document.getElementById('documentationList');
    let noResultsElement = document.querySelector('.no-results');
    
    if (show) {
        if (!noResultsElement) {
            noResultsElement = document.createElement('div');
            noResultsElement.className = 'no-results';
            noResultsElement.innerHTML = `
                <i class="bi bi-search"></i>
                <h5>Tidak ada dokumen yang ditemukan</h5>
                <p>Coba gunakan kata kunci yang berbeda</p>
            `;
            documentationList.appendChild(noResultsElement);
        }
    } else {
        if (noResultsElement) {
            noResultsElement.remove();
        }
    }
}

// ========================================
// EVENT LISTENERS
// ========================================

function initializeEventListeners() {
    // Form submissions
    const addDocForm = document.getElementById('addDocForm');
    const editDocForm = document.getElementById('editDocForm');
    
    if (addDocForm) {
        addDocForm.addEventListener('submit', handleAddDocument);
    }
    
    if (editDocForm) {
        editDocForm.addEventListener('submit', handleEditDocument);
    }
    
    // Document actions (using event delegation)
    document.addEventListener('click', handleDocumentActions);
    
    // File input validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', validateFileInput);
    });
}

function handleDocumentActions(e) {
    const target = e.target.closest('button');
    if (!target) return;
    
    // Download button
    if (target.classList.contains('download-btn')) {
        e.preventDefault();
        const docId = target.getAttribute('data-doc-id') || getDocIdFromParent(target);
        handleDownload(docId, target);
    }
    
    // Edit button
    if (target.classList.contains('edit-btn')) {
        e.preventDefault();
        const docId = target.getAttribute('data-doc-id') || getDocIdFromParent(target);
        handleEdit(docId);
    }
    
    // Delete button
    if (target.classList.contains('delete-btn')) {
        e.preventDefault();
        const docId = target.getAttribute('data-doc-id') || getDocIdFromParent(target);
        handleDelete(docId, target);
    }
}

function getDocIdFromParent(element) {
    const docItem = element.closest('.doc-item');
    return docItem ? docItem.getAttribute('data-id') : null;
}

// ========================================
// DOCUMENT MANAGEMENT FUNCTIONS
// ========================================

function handleAddDocument(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const submitBtn = e.target.querySelector('button[type="submit"]') || 
                     document.querySelector('button[form="addDocForm"]');
    
    // Validate form
    if (!validateDocumentForm(formData)) {
        return;
    }
    
    // Show loading state
    setButtonLoading(submitBtn, true, 'Menambah...');
    
    // Simulate API call (replace with actual endpoint)
    setTimeout(() => {
        try {
            // Get form data
            const title = formData.get('title');
            const description = formData.get('description');
            const version = formData.get('version') || 'v3.0';
            const file = formData.get('file');
            
            // Create new document item
            const newDocId = Date.now(); // Temporary ID
            const fileSize = file ? formatFileSize(file.size) : '0 MB';
            
            addDocumentToList({
                id: newDocId,
                title: title,
                description: description,
                version: version,
                file_size: fileSize
            });
            
            // Show success message
            showAlert('Dokumen berhasil ditambahkan!', 'success');
            
            // Hide modal and reset form
            addDocModal.hide();
            resetForm('addDocForm');
            
            // Update document count
            updateDocumentCount();
            
        } catch (error) {
            console.error('Error adding document:', error);
            showAlert('Terjadi kesalahan saat menambah dokumen', 'danger');
        } finally {
            setButtonLoading(submitBtn, false, 'Tambah Dokumen');
        }
    }, 1000);
}

function handleEditDocument(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const submitBtn = e.target.querySelector('button[type="submit"]') || 
                     document.querySelector('button[form="editDocForm"]');
    const docId = formData.get('doc_id');
    
    // Validate form
    if (!validateDocumentForm(formData)) {
        return;
    }
    
    // Show loading state
    setButtonLoading(submitBtn, true, 'Menyimpan...');
    
    // Simulate API call
    setTimeout(() => {
        try {
            const title = formData.get('title');
            const description = formData.get('description');
            const version = formData.get('version');
            
            // Update document in list
            updateDocumentInList(docId, {
                title: title,
                description: description,
                version: version
            });
            
            showAlert('Dokumen berhasil diperbarui!', 'success');
            editDocModal.hide();
            resetForm('editDocForm');
            
        } catch (error) {
            console.error('Error updating document:', error);
            showAlert('Terjadi kesalahan saat memperbarui dokumen', 'danger');
        } finally {
            setButtonLoading(submitBtn, false, 'Simpan Perubahan');
        }
    }, 1000);
}

function handleDownload(docId, button) {
    if (!docId) {
        showAlert('ID dokumen tidak valid', 'warning');
        return;
    }
    
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="bi bi-download me-1"></i>Mengunduh...';
    button.disabled = true;
    
    // Simulate download
    setTimeout(() => {
        showAlert('Download dimulai! File akan segera tersedia.', 'success');
        
        // Reset button
        button.innerHTML = originalText;
        button.disabled = false;
    }, 1500);
}

function handleEdit(docId) {
    if (!docId) {
        showAlert('ID dokumen tidak valid', 'warning');
        return;
    }
    
    // Find document data
    const docItem = document.querySelector(`[data-doc-id="${docId}"]`)?.closest('.doc-item');
    if (!docItem) {
        showAlert('Dokumen tidak ditemukan', 'warning');
        return;
    }
    
    // Extract document data
    const title = docItem.querySelector('.doc-title')?.textContent || '';
    const description = docItem.querySelector('.doc-description')?.textContent || '';
    const versionBadge = docItem.querySelector('.badge-version')?.textContent || '';
    const version = versionBadge.replace('v', '');
    
    // Populate edit form
    document.getElementById('editDocId').value = docId;
    document.getElementById('editDocTitle').value = title;
    document.getElementById('editDocDescription').value = description;
    document.getElementById('editDocVersion').value = version;
    
    // Show edit modal
    editDocModal.show();
}

function handleDelete(docId, button) {
    if (!docId) {
        showAlert('ID dokumen tidak valid', 'warning');
        return;
    }
    
    const docItem = button.closest('.doc-item');
    const docTitle = docItem?.querySelector('.doc-title')?.textContent || 'dokumen ini';
    
    if (confirm(`Apakah Anda yakin ingin menghapus "${docTitle}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
        // Show loading state
        button.innerHTML = '<i class="bi bi-spinner-border spinner-border-sm"></i>';
        button.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            try {
                // Remove from DOM
                if (docItem) {
                    docItem.style.opacity = '0';
                    docItem.style.transform = 'translateX(-100%)';
                    
                    setTimeout(() => {
                        docItem.remove();
                        updateDocumentCount();
                        renumberDocuments();
                    }, 300);
                }
                
                showAlert('Dokumen berhasil dihapus!', 'success');
                
            } catch (error) {
                console.error('Error deleting document:', error);
                showAlert('Terjadi kesalahan saat menghapus dokumen', 'danger');
                
                // Reset button
                button.innerHTML = '<i class="bi bi-trash"></i>';
                button.disabled = false;
            }
        }, 1000);
    }
}

// ========================================
// UTILITY FUNCTIONS
// ========================================

function addDocumentToList(docData) {
    const documentationList = document.getElementById('documentationList');
    const docCount = documentationList.children.length + 1;
    
    const docElement = document.createElement('div');
    docElement.className = 'doc-item';
    docElement.setAttribute('data-title', docData.title.toLowerCase());
    docElement.setAttribute('data-description', docData.description.toLowerCase());
    docElement.setAttribute('data-id', docData.id);
    
    docElement.innerHTML = `
        <div class="doc-number">
            <span>${docCount}</span>
        </div>
        <div class="doc-content">
            <h6 class="doc-title">${escapeHtml(docData.title)}</h6>
            <p class="doc-description">${escapeHtml(docData.description)}</p>
            <div class="doc-badges">
                <span class="badge badge-pdf">PDF</span>
                <span class="badge badge-size">${escapeHtml(docData.file_size)}</span>
                <span class="badge badge-version">${escapeHtml(docData.version)}</span>
            </div>
        </div>
        <div class="doc-actions">
            <button class="btn btn-outline-secondary btn-sm download-btn" title="Unduh" data-doc-id="${docData.id}">
                <i class="bi bi-download me-1"></i>
                Unduh
            </button>
            <button class="btn btn-link btn-sm edit-btn" title="Edit" data-doc-id="${docData.id}">
                <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-link btn-sm text-danger delete-btn" title="Hapus" data-doc-id="${docData.id}">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    
    documentationList.appendChild(docElement);
    
    // Add animation
    setTimeout(() => {
        docElement.style.opacity = '1';
        docElement.style.transform = 'translateY(0)';
    }, 100);
}

function updateDocumentInList(docId, docData) {
    const docItem = document.querySelector(`[data-doc-id="${docId}"]`)?.closest('.doc-item');
    if (!docItem) return;
    
    // Update title and description
    const titleElement = docItem.querySelector('.doc-title');
    const descriptionElement = docItem.querySelector('.doc-description');
    const versionElement = docItem.querySelector('.badge-version');
    
    if (titleElement) {
        titleElement.textContent = docData.title;
        docItem.setAttribute('data-title', docData.title.toLowerCase());
    }
    
    if (descriptionElement) {
        descriptionElement.textContent = docData.description;
        docItem.setAttribute('data-description', docData.description.toLowerCase());
    }
    
    if (versionElement && docData.version) {
        versionElement.textContent = docData.version;
    }
    
    // Add update animation
    docItem.style.backgroundColor = '#d4edda';
    setTimeout(() => {
        docItem.style.backgroundColor = '';
    }, 1000);
}

function updateDocumentCount() {
    const docCount = document.getElementById('docCount');
    const visibleDocs = document.querySelectorAll('.doc-item:not([style*="display: none"])').length;
    
    if (docCount) {
        docCount.textContent = visibleDocs;
    }
}

function renumberDocuments() {
    const docItems = document.querySelectorAll('.doc-item:not([style*="display: none"])');
    
    docItems.forEach((item, index) => {
        const numberElement = item.querySelector('.doc-number span');
        if (numberElement) {
            numberElement.textContent = index + 1;
        }
    });
}

function validateDocumentForm(formData) {
    const title = formData.get('title');
    
    if (!title || title.trim() === '') {
        showAlert('Judul dokumen harus diisi!', 'warning');
        return false;
    }
    
    if (title.length > 100) {
        showAlert('Judul dokumen terlalu panjang (maksimal 100 karakter)!', 'warning');
        return false;
    }
    
    return true;
}

function validateFileInput(e) {
    const file = e.target.files[0];
    if (!file) return;
    
    const maxSize = 10 * 1024 * 1024; // 10MB
    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    
    if (file.size > maxSize) {
        showAlert('Ukuran file terlalu besar! Maksimal 10MB.', 'warning');
        e.target.value = '';
        return;
    }
    
    if (!allowedTypes.includes(file.type)) {
        showAlert('Format file tidak didukung! Gunakan PDF, DOC, atau DOCX.', 'warning');
        e.target.value = '';
        return;
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function resetForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
        
        // Clear validation states
        const inputs = form.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.classList.remove('is-valid', 'is-invalid');
        });
    }
}

function setButtonLoading(button, loading, text) {
    if (!button) return;
    
    if (loading) {
        button.disabled = true;
        button.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>${text}`;
    } else {
        button.disabled = false;
        button.innerHTML = text;
    }
}

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
        success: 'bi-check-circle',
        danger: 'bi-exclamation-triangle',
        warning: 'bi-exclamation-triangle',
        info: 'bi-info-circle',
    };

    alertDiv.innerHTML = `
        <i class="bi ${iconMap[type]} me-2"></i>${message}
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

function escapeRegex(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

// ========================================
// KEYBOARD SHORTCUTS
// ========================================

document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K for search focus
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.getElementById('searchDocs');
        if (searchInput) {
            searchInput.focus();
            searchInput.select();
        }
    }
    
    // Ctrl/Cmd + N for new document
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        const addBtn = document.querySelector('.add-doc-btn');
        if (addBtn) {
            addBtn.click();
        }
    }
});

// ========================================
// EXPORT FUNCTIONS (for external use)
// ========================================

window.PanduanManager = {
    search: performSearch,
    addDocument: addDocumentToList,
    updateDocument: updateDocumentInList,
    showAlert: showAlert,
    updateCount: updateDocumentCount
};