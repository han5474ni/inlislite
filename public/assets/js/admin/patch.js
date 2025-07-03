/**
 * INLISLite v3.0 Patch and Updater JavaScript
 * Enhanced patch management with modern UI interactions
 * Consistent with other admin pages functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    let isEditMode = false;
    let autoSaveInterval;
    
    // Initialize all functionality
    initializePatchActions();
    initializeSearchAndFilter();
    initializeAnimations();
    initializeKeyboardShortcuts();
    initializeTooltips();
    setDefaultDate();
    
    /**
     * Initialize patch action handlers
     */
    function initializePatchActions() {
        const patchesGrid = document.getElementById('patchesGrid');
        
        // Event delegation for dynamic content
        patchesGrid.addEventListener('click', function(e) {
            const target = e.target.closest('a') || e.target.closest('button');
            if (!target) return;
            
            e.preventDefault();
            
            // Add loading state
            if (!target.classList.contains('cancel-edit')) {
                target.classList.add('loading');
                setTimeout(() => target.classList.remove('loading'), 300);
            }
            
            if (target.classList.contains('btn-edit')) {
                handleEditPatch(target);
            } else if (target.classList.contains('delete-patch')) {
                handleDeletePatch(target);
            } else if (target.classList.contains('btn-download')) {
                handleDownloadPatch(target);
            } else if (target.classList.contains('save-patch')) {
                handleSavePatch(target);
            } else if (target.classList.contains('cancel-edit')) {
                handleCancelEdit(target);
            }
        });
        
        // Add Package form submission
        const addForm = document.getElementById('addPatchForm');
        if (addForm) {
            addForm.addEventListener('submit', handleAddPatch);
        }
        
        // Modal events
        const addModal = document.getElementById('addPatchModal');
        if (addModal) {
            addModal.addEventListener('hidden.bs.modal', () => resetForm(addForm));
        }
    }
    
    /**
     * Handle editing a patch
     */
    function handleEditPatch(button) {
        const patchCard = button.closest('.patch-card');
        
        // Check if another card is in edit mode
        if (isEditMode) {
            showAlert('Please save or cancel the current edit before editing another patch.', 'warning');
            return;
        }
        
        enterEditMode(patchCard);
        showAlert('Edit mode activated. Use Ctrl+S to save or Esc to cancel.', 'info');
    }
    
    /**
     * Handle deleting a patch
     */
    function handleDeletePatch(button) {
        const patchCard = button.closest('.patch-card');
        const patchTitle = patchCard.querySelector('.patch-title').textContent;
        
        // Enhanced confirmation dialog
        const confirmDelete = confirm(
            `⚠️ Delete Patch\n\nAre you sure you want to delete "${patchTitle}"?\n\nThis action cannot be undone.`
        );
        
        if (confirmDelete) {
            // Add delete animation
            patchCard.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            patchCard.style.opacity = '0';
            patchCard.style.transform = 'translateY(-20px) scale(0.95)';
            
            setTimeout(() => {
                patchCard.remove();
                showAlert(`Patch "${patchTitle}" deleted successfully!`, 'success');
                updatePatchCounter();
            }, 400);
        }
    }
    
    /**
     * Handle downloading a patch
     */
    function handleDownloadPatch(button) {
        const patchId = button.dataset.id;
        const patchCard = button.closest('.patch-card');
        const patchTitle = patchCard.querySelector('.patch-title').textContent;
        
        // Show loading state
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Downloading...';
        
        // Simulate download process
        setTimeout(() => {
            // Update download count
            const downloadStat = patchCard.querySelector('.stat-item:first-child span');
            const currentCount = parseInt(downloadStat.textContent.replace(/[^\d]/g, '')) || 0;
            downloadStat.textContent = `${(currentCount + 1).toLocaleString()} downloads`;
            
            // Restore button
            button.disabled = false;
            button.innerHTML = originalText;
            
            showAlert(`Download started for "${patchTitle}"`, 'success');
            
            // Simulate file download
            triggerDownload(`patch_${patchId}.zip`, patchTitle);
        }, 1500);
    }
    
    /**
     * Handle saving patch changes
     */
    function handleSavePatch(button) {
        const patchCard = button.closest('.patch-card');
        const editForm = patchCard.querySelector('.patch-edit-form');
        
        // Get form values
        const newTitle = editForm.querySelector('.edit-nama').value.trim();
        const newVersion = editForm.querySelector('.edit-versi').value.trim();
        const newPriority = editForm.querySelector('.edit-prioritas').value;
        const newSize = editForm.querySelector('.edit-ukuran').value.trim();
        const newDate = editForm.querySelector('.edit-tanggal').value;
        const newDescription = editForm.querySelector('.edit-deskripsi').value.trim();
        
        // Enhanced validation
        const validation = validatePatchData(newTitle, newVersion, newPriority, newSize, newDate, newDescription);
        if (!validation.isValid) {
            showAlert(validation.message, 'danger');
            validation.focusElement.focus();
            validation.focusElement.classList.add('is-invalid');
            
            // Remove invalid class after 3 seconds
            setTimeout(() => {
                validation.focusElement.classList.remove('is-invalid');
            }, 3000);
            return;
        }
        
        // Add success animation
        button.innerHTML = '<i class="bi bi-check-lg me-2"></i>Saving...';
        button.disabled = true;
        
        setTimeout(() => {
            // Update patch content
            updatePatchContent(patchCard, newTitle, newVersion, newPriority, newSize, newDate, newDescription);
            
            // Exit edit mode
            exitEditMode(patchCard);
            
            showAlert('Patch updated successfully!', 'success');
            
            // Reset button
            button.innerHTML = '<i class="bi bi-check-lg me-2"></i>Save';
            button.disabled = false;
        }, 500);
    }
    
    /**
     * Handle canceling edit
     */
    function handleCancelEdit(button) {
        const patchCard = button.closest('.patch-card');
        
        // Check if there are unsaved changes
        if (hasUnsavedChanges(patchCard)) {
            const confirmCancel = confirm(
                '⚠️ Unsaved Changes\n\nYou have unsaved changes. Are you sure you want to cancel?'
            );
            if (!confirmCancel) return;
        }
        
        // Exit edit mode
        exitEditMode(patchCard);
        showAlert('Edit cancelled. Changes discarded.', 'info');
    }
    
    /**
     * Handle adding a new patch
     */
    function handleAddPatch(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Validate form
        if (!validateForm(form)) {
            showAlert('Please check the form data and try again.', 'danger');
            return;
        }
        
        // Show loading state
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Adding...';
        submitBtn.disabled = true;
        
        // Get form data
        const formData = new FormData(form);
        const patchData = {
            nama_paket: formData.get('nama_paket'),
            versi: formData.get('versi'),
            prioritas: formData.get('prioritas'),
            ukuran: formData.get('ukuran'),
            tanggal_rilis: formData.get('tanggal_rilis'),
            deskripsi: formData.get('deskripsi')
        };
        
        setTimeout(() => {
            // Create new patch card
            const newPatchCard = createNewPatchCard(patchData);
            
            // Add to grid
            const patchesGrid = document.getElementById('patchesGrid');
            const emptyState = patchesGrid.querySelector('.empty-state');
            if (emptyState) {
                emptyState.remove();
            }
            
            patchesGrid.appendChild(newPatchCard);
            
            // Animate new card
            newPatchCard.classList.add('new-patch');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addPatchModal'));
            modal.hide();
            
            // Reset form
            resetForm(form);
            
            // Restore button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            
            showAlert('New patch package added successfully!', 'success');
            updatePatchCounter();
            
            // Scroll to new card
            setTimeout(() => {
                newPatchCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);
        }, 1000);
    }
    
    /**
     * Enter edit mode for a patch card
     */
    function enterEditMode(patchCard) {
        const cardBody = patchCard.querySelector('.patch-card-body');
        const editForm = patchCard.querySelector('.patch-edit-form');
        
        // Set global edit mode flag
        isEditMode = true;
        
        // Show edit form, hide content
        patchCard.classList.add('edit-mode');
        cardBody.classList.add('d-none');
        editForm.classList.remove('d-none');
        
        // Focus on first input
        setTimeout(() => {
            const firstInput = editForm.querySelector('input');
            if (firstInput) {
                firstInput.focus();
                firstInput.select();
            }
        }, 100);
    }
    
    /**
     * Exit edit mode for a patch card
     */
    function exitEditMode(patchCard) {
        const cardBody = patchCard.querySelector('.patch-card-body');
        const editForm = patchCard.querySelector('.patch-edit-form');
        
        // Clear global edit mode flag
        isEditMode = false;
        
        // Show content, hide edit form
        patchCard.classList.remove('edit-mode');
        cardBody.classList.remove('d-none');
        editForm.classList.add('d-none');
        
        // Clear validation states
        editForm.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }
    
    /**
     * Update patch content with new values
     */
    function updatePatchContent(patchCard, title, version, priority, size, date, description) {
        // Update title and description
        const titleElement = patchCard.querySelector('.patch-title');
        const descElement = patchCard.querySelector('.patch-description');
        
        titleElement.style.opacity = '0';
        descElement.style.opacity = '0';
        
        setTimeout(() => {
            titleElement.textContent = title;
            descElement.textContent = description;
            titleElement.style.opacity = '1';
            descElement.style.opacity = '1';
        }, 150);
        
        // Update badges
        const versionBadge = patchCard.querySelector('.version-badge');
        const priorityBadge = patchCard.querySelector('.priority-badge');
        
        versionBadge.textContent = `v${version}`;
        priorityBadge.textContent = priority;
        priorityBadge.className = `badge priority-badge priority-${priority.toLowerCase()}`;
        
        // Update stats
        const sizeElement = patchCard.querySelector('.stat-item:nth-child(2) span');
        const dateElement = patchCard.querySelector('.stat-item:nth-child(3) span');
        
        sizeElement.textContent = size;
        dateElement.textContent = formatDate(date);
        
        // Update data attribute
        patchCard.dataset.priority = priority;
        patchCard.dataset.lastUpdated = new Date().toISOString();
    }
    
    /**
     * Create a new patch card element
     */
    function createNewPatchCard(data) {
        const patchCard = document.createElement('div');
        patchCard.className = 'patch-card';
        patchCard.dataset.priority = data.prioritas;
        
        const cardId = Date.now(); // Simple ID generation
        
        patchCard.innerHTML = `
            <div class="patch-card-header">
                <div class="patch-info">
                    <h6 class="patch-title">${data.nama_paket}</h6>
                    <p class="patch-description">${data.deskripsi}</p>
                </div>
                <div class="dropdown">
                    <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item btn-edit" href="#" data-id="${cardId}"><i class="bi bi-pencil me-2"></i>Edit Package</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item delete-patch text-danger" href="#" data-id="${cardId}"><i class="bi bi-trash me-2"></i>Delete</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="patch-card-body">
                <div class="patch-badges">
                    <span class="badge version-badge">v${data.versi}</span>
                    <span class="badge priority-badge priority-${data.prioritas.toLowerCase()}">${data.prioritas}</span>
                </div>
                
                <div class="patch-stats">
                    <div class="stat-item">
                        <i class="bi bi-download"></i>
                        <span>0 downloads</span>
                    </div>
                    <div class="stat-item">
                        <i class="bi bi-hdd"></i>
                        <span>${data.ukuran}</span>
                    </div>
                    <div class="stat-item">
                        <i class="bi bi-calendar"></i>
                        <span>${formatDate(data.tanggal_rilis)}</span>
                    </div>
                </div>
                
                <div class="patch-actions">
                    <button class="btn btn-primary btn-download" data-id="${cardId}">
                        <i class="bi bi-download me-2"></i>Download
                    </button>
                </div>
            </div>
            
            <!-- Edit Form (Hidden by default) -->
            <div class="patch-edit-form d-none">
                <form class="edit-patch-form" data-id="${cardId}">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Package Name</label>
                        <input type="text" class="form-control edit-nama" value="${data.nama_paket}" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Version</label>
                            <input type="text" class="form-control edit-versi" value="${data.versi}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Priority</label>
                            <select class="form-select edit-prioritas" required>
                                <option value="High" ${data.prioritas === 'High' ? 'selected' : ''}>High</option>
                                <option value="Medium" ${data.prioritas === 'Medium' ? 'selected' : ''}>Medium</option>
                                <option value="Low" ${data.prioritas === 'Low' ? 'selected' : ''}>Low</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Size</label>
                            <input type="text" class="form-control edit-ukuran" value="${data.ukuran}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Release Date</label>
                            <input type="date" class="form-control edit-tanggal" value="${data.tanggal_rilis}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control edit-deskripsi" rows="3" required>${data.deskripsi}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary save-patch">
                            <i class="bi bi-check-lg me-2"></i>Save
                        </button>
                        <button type="button" class="btn btn-secondary cancel-edit">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </button>
                    </div>
                </form>
            </div>
        `;
        
        return patchCard;
    }
    
    /**
     * Initialize search and filter functionality
     */
    function initializeSearchAndFilter() {
        const searchInput = document.getElementById('searchInput');
        const priorityFilter = document.getElementById('priorityFilter');
        
        if (searchInput) {
            searchInput.addEventListener('input', debounce(filterPatches, 300));
        }
        
        if (priorityFilter) {
            priorityFilter.addEventListener('change', filterPatches);
        }
    }
    
    /**
     * Filter patches based on search and priority
     */
    function filterPatches() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
        const selectedPriority = document.getElementById('priorityFilter').value;
        
        document.querySelectorAll('.patch-card').forEach(card => {
            const patchTitle = card.querySelector('.patch-title').textContent.toLowerCase();
            const patchDesc = card.querySelector('.patch-description').textContent.toLowerCase();
            const patchPriority = card.dataset.priority;
            
            const matchesSearch = !searchTerm || patchTitle.includes(searchTerm) || patchDesc.includes(searchTerm);
            const matchesPriority = !selectedPriority || patchPriority === selectedPriority;
            
            card.style.display = matchesSearch && matchesPriority ? '' : 'none';
        });
        
        updatePatchCounter();
    }
    
    /**
     * Update patch counter
     */
    function updatePatchCounter() {
        const visiblePatches = document.querySelectorAll('.patch-card:not([style*="display: none"])').length;
        const counter = document.getElementById('patchCount');
        if (counter) {
            counter.textContent = visiblePatches;
        }
    }
    
    /**
     * Enhanced validation for patch data
     */
    function validatePatchData(title, version, priority, size, date, description) {
        if (!title) {
            return {
                isValid: false,
                message: 'Package name is required and cannot be empty.',
                focusElement: document.querySelector('.edit-nama')
            };
        }
        
        if (title.length < 3) {
            return {
                isValid: false,
                message: 'Package name must be at least 3 characters long.',
                focusElement: document.querySelector('.edit-nama')
            };
        }
        
        if (!version) {
            return {
                isValid: false,
                message: 'Version is required.',
                focusElement: document.querySelector('.edit-versi')
            };
        }
        
        if (!/^[0-9]+(\.[0-9]+)*$/.test(version)) {
            return {
                isValid: false,
                message: 'Version format is invalid (example: 1.0.0).',
                focusElement: document.querySelector('.edit-versi')
            };
        }
        
        if (!priority) {
            return {
                isValid: false,
                message: 'Priority is required.',
                focusElement: document.querySelector('.edit-prioritas')
            };
        }
        
        if (!size) {
            return {
                isValid: false,
                message: 'File size is required.',
                focusElement: document.querySelector('.edit-ukuran')
            };
        }
        
        if (!date) {
            return {
                isValid: false,
                message: 'Release date is required.',
                focusElement: document.querySelector('.edit-tanggal')
            };
        }
        
        if (!description) {
            return {
                isValid: false,
                message: 'Description is required.',
                focusElement: document.querySelector('.edit-deskripsi')
            };
        }
        
        if (description.length < 10) {
            return {
                isValid: false,
                message: 'Description must be at least 10 characters long.',
                focusElement: document.querySelector('.edit-deskripsi')
            };
        }
        
        return { isValid: true };
    }
    
    /**
     * Check for unsaved changes
     */
    function hasUnsavedChanges(patchCard) {
        const editForm = patchCard.querySelector('.patch-edit-form');
        if (!editForm || editForm.classList.contains('d-none')) return false;
        
        const currentTitle = patchCard.querySelector('.patch-title').textContent;
        const currentDesc = patchCard.querySelector('.patch-description').textContent;
        
        const formTitle = editForm.querySelector('.edit-nama').value.trim();
        const formDesc = editForm.querySelector('.edit-deskripsi').value.trim();
        
        return currentTitle !== formTitle || currentDesc !== formDesc;
    }
    
    /**
     * Validate form
     */
    function validateForm(form) {
        let isValid = true;
        
        const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        return isValid;
    }
    
    /**
     * Reset form to initial state
     */
    function resetForm(form) {
        if (form) {
            form.reset();
            
            // Remove validation classes
            const fields = form.querySelectorAll('.is-invalid, .is-valid');
            fields.forEach(field => field.classList.remove('is-invalid', 'is-valid'));
            
            // Reset date to today
            setDefaultDate();
        }
    }
    
    /**
     * Set default date to today
     */
    function setDefaultDate() {
        const dateInput = document.getElementById('tanggal_rilis');
        if (dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
        }
    }
    
    /**
     * Format date for display
     */
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric' 
        });
    }
    
    /**
     * Trigger file download
     */
    function triggerDownload(filename, title) {
        // Create a temporary download link
        const link = document.createElement('a');
        link.href = '#'; // In real implementation, this would be the actual file URL
        link.download = filename;
        link.style.display = 'none';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        console.log(`Download triggered for: ${title} (${filename})`);
    }
    
    /**
     * Initialize animations and observers
     */
    function initializeAnimations() {
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observe existing cards
        const cards = document.querySelectorAll('.patch-card');
        cards.forEach(card => {
            observer.observe(card);
        });
        
        // Re-observe new cards when they're added
        const patchesGrid = document.getElementById('patchesGrid');
        if (patchesGrid) {
            const mutationObserver = new MutationObserver(function(mutations) {
                mutations.forEach(mutation => {
                    mutation.addedNodes.forEach(node => {
                        if (node.nodeType === 1 && node.classList.contains('patch-card')) {
                            observer.observe(node);
                        }
                    });
                });
            });
            
            mutationObserver.observe(patchesGrid, { childList: true });
        }
    }
    
    /**
     * Initialize keyboard shortcuts
     */
    function initializeKeyboardShortcuts() {
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S to save when in edit mode
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                const editMode = document.querySelector('.edit-mode');
                if (editMode) {
                    e.preventDefault();
                    const saveButton = editMode.querySelector('.save-patch');
                    if (saveButton && !saveButton.disabled) {
                        saveButton.click();
                    }
                }
            }
            
            // Escape to cancel edit mode
            if (e.key === 'Escape') {
                const editMode = document.querySelector('.edit-mode');
                if (editMode) {
                    const cancelButton = editMode.querySelector('.cancel-edit');
                    if (cancelButton) {
                        cancelButton.click();
                    }
                }
            }
            
            // Ctrl/Cmd + N to add new patch
            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                e.preventDefault();
                const addButton = document.querySelector('[data-bs-target="#addPatchModal"]');
                if (addButton) {
                    addButton.click();
                }
            }
        });
    }
    
    /**
     * Initialize tooltips for better UX
     */
    function initializeTooltips() {
        // Add tooltips to action buttons
        const tooltips = [
            { selector: '.btn-edit', title: 'Edit this patch package' },
            { selector: '.delete-patch', title: 'Delete this patch package' },
            { selector: '.btn-download', title: 'Download patch package' },
            { selector: '.save-patch', title: 'Save changes (Ctrl+S)' },
            { selector: '.cancel-edit', title: 'Cancel editing (Esc)' }
        ];
        
        tooltips.forEach(tooltip => {
            document.querySelectorAll(tooltip.selector).forEach(element => {
                element.setAttribute('title', tooltip.title);
                element.setAttribute('data-bs-toggle', 'tooltip');
            });
        });
        
        // Initialize Bootstrap tooltips
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }
    
    /**
     * Enhanced alert system with auto-dismiss and icons
     */
    function showAlert(message, type = 'info', duration = 5000) {
        const alertContainer = document.getElementById('alertContainer');
        const alertId = 'alert-' + Date.now();
        
        const alertHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert" id="${alertId}">
                <i class="bi bi-${getAlertIcon(type)} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        alertContainer.insertAdjacentHTML('beforeend', alertHTML);
        
        // Auto-dismiss
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, duration);
    }
    
    /**
     * Get appropriate icon for alert type
     */
    function getAlertIcon(type) {
        const icons = {
            success: 'check-circle-fill',
            danger: 'exclamation-triangle-fill',
            warning: 'exclamation-triangle-fill',
            info: 'info-circle-fill'
        };
        return icons[type] || 'info-circle-fill';
    }
    
    /**
     * Debounce function to limit function calls
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Initialize patch counter on load
    updatePatchCounter();
    
    console.log('Patch and Updater - Enhanced interactive functionality loaded successfully');
});