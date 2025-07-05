/**
 * INLISLite v3.0 Bimbingan Teknis Page JavaScript
 * Enhanced card editing, adding, deleting, and interactive functionality
 * Includes improved animations, validation, and user experience features
 */

document.addEventListener('DOMContentLoaded', function() {
    let cardCounter = 5; // Start from 6 since we have 5 initial cards
    let isEditMode = false;
    let autoSaveInterval;
    
    // Initialize all functionality
    initializeCardActions();
    initializeAnimations();
    initializeKeyboardShortcuts();
    initializeTooltips();
    
    /**
     * Initialize card action handlers with improved event delegation
     */
    function initializeCardActions() {
        const bimbinganContent = document.getElementById('bimbinganContent');
        
        // Event delegation for dynamic content
        bimbinganContent.addEventListener('click', function(e) {
            const target = e.target.closest('a') || e.target.closest('button');
            if (!target) return;
            
            e.preventDefault();
            
            // Add loading state
            if (!target.classList.contains('cancel-edit')) {
                target.classList.add('loading');
                setTimeout(() => target.classList.remove('loading'), 300);
            }
            
            if (target.classList.contains('add-card')) {
                handleAddCard(target);
            } else if (target.classList.contains('edit-card')) {
                handleEditCard(target);
            } else if (target.classList.contains('delete-card')) {
                handleDeleteCard(target);
            } else if (target.classList.contains('save-card')) {
                handleSaveCard(target);
            } else if (target.classList.contains('cancel-edit')) {
                handleCancelEdit(target);
            }
        });
        
        // Handle card hover effects
        bimbinganContent.addEventListener('mouseenter', function(e) {
            if (e.target.classList.contains('bimbingan-card') || e.target.classList.contains('contact-card')) {
                e.target.style.transform = 'translateY(-4px)';
            }
        }, true);
        
        bimbinganContent.addEventListener('mouseleave', function(e) {
            if ((e.target.classList.contains('bimbingan-card') || e.target.classList.contains('contact-card')) && !e.target.classList.contains('edit-mode')) {
                e.target.style.transform = 'translateY(0)';
            }
        }, true);
    }
    
    /**
     * Handle adding a new card with enhanced animation
     */
    function handleAddCard(button) {
        const currentCard = button.closest('.bimbingan-card') || button.closest('.contact-card');
        const newCard = createNewCard();
        
        // Insert after current card with fade-in effect
        currentCard.insertAdjacentElement('afterend', newCard);
        
        // Animate the new card
        newCard.classList.add('new-card', 'pulse');
        
        // Remove pulse after animation
        setTimeout(() => {
            newCard.classList.remove('pulse');
        }, 2000);
        
        // Scroll to and focus on the new card
        setTimeout(() => {
            newCard.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center',
                inline: 'nearest'
            });
            
            const titleInput = newCard.querySelector('.edit-title');
            if (titleInput) {
                titleInput.focus();
                titleInput.select();
            }
        }, 100);
        
        // Automatically enter edit mode
        setTimeout(() => {
            enterEditMode(newCard);
            startAutoSave(newCard);
        }, 300);
        
        showAlert('New card added successfully! Start editing to customize it.', 'success');
        updateCardCounter();
    }
    
    /**
     * Handle editing a card with improved UX
     */
    function handleEditCard(button) {
        const card = button.closest('.bimbingan-card') || button.closest('.contact-card');
        
        // Check if another card is in edit mode
        if (isEditMode) {
            showAlert('Please save or cancel the current edit before editing another card.', 'warning');
            return;
        }
        
        enterEditMode(card);
        startAutoSave(card);
        showAlert('Edit mode activated. Use Ctrl+S to save or Esc to cancel.', 'info');
    }
    
    /**
     * Handle deleting a card with confirmation and animation
     */
    function handleDeleteCard(button) {
        const card = button.closest('.bimbingan-card') || button.closest('.contact-card');
        const cardTitle = card.querySelector('.card-title').textContent;
        
        // Enhanced confirmation dialog
        const confirmDelete = confirm(
            `⚠️ Delete Card\n\nAre you sure you want to delete "${cardTitle}"?\n\nThis action cannot be undone.`
        );
        
        if (confirmDelete) {
            // Add delete animation
            card.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            card.style.opacity = '0';
            card.style.transform = 'translateY(-20px) scale(0.95)';
            card.style.maxHeight = card.offsetHeight + 'px';
            
            setTimeout(() => {
                card.style.maxHeight = '0';
                card.style.padding = '0';
                card.style.margin = '0';
            }, 200);
            
            setTimeout(() => {
                card.remove();
                showAlert(`Card "${cardTitle}" deleted successfully!`, 'success');
                updateCardCounter();
            }, 400);
        }
    }
    
    /**
     * Handle saving card changes with validation
     */
    function handleSaveCard(button) {
        const card = button.closest('.bimbingan-card') || button.closest('.contact-card');
        const editForm = card.querySelector('.card-edit-form');
        
        // Get form values
        const newTitle = editForm.querySelector('.edit-title').value.trim();
        const newSubtitle = editForm.querySelector('.edit-subtitle').value.trim();
        const newContent = editForm.querySelector('.edit-content').value.trim();
        
        // Enhanced validation
        const validation = validateCardData(newTitle, newSubtitle, newContent);
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
            // Update card content
            updateCardContent(card, newTitle, newSubtitle, newContent);
            
            // Exit edit mode
            exitEditMode(card);
            stopAutoSave();
            
            // Save to localStorage
            saveCardToStorage(card);
            
            showAlert('Card updated successfully!', 'success');
            
            // Reset button
            button.innerHTML = '<i class="bi bi-check-lg me-2"></i>Save';
            button.disabled = false;
        }, 500);
    }
    
    /**
     * Handle canceling edit with confirmation
     */
    function handleCancelEdit(button) {
        const card = button.closest('.bimbingan-card') || button.closest('.contact-card');
        
        // Check if there are unsaved changes
        if (hasUnsavedChanges(card)) {
            const confirmCancel = confirm(
                '⚠️ Unsaved Changes\n\nYou have unsaved changes. Are you sure you want to cancel?'
            );
            if (!confirmCancel) return;
        }
        
        // If this is a new card (no original content), remove it
        if (card.dataset.isNew === 'true') {
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '0';
            card.style.transform = 'translateY(-10px)';
            
            setTimeout(() => {
                card.remove();
                showAlert('New card creation cancelled.', 'info');
                updateCardCounter();
            }, 300);
            return;
        }
        
        // Otherwise, just exit edit mode
        exitEditMode(card);
        stopAutoSave();
        showAlert('Edit cancelled. Changes discarded.', 'info');
    }
    
    /**
     * Create a new card element with enhanced structure
     */
    function createNewCard() {
        cardCounter++;
        const newCard = document.createElement('div');
        newCard.className = 'bimbingan-card card';
        newCard.dataset.cardId = cardCounter;
        newCard.dataset.isNew = 'true';
        
        newCard.innerHTML = `
            <div class="card-header d-flex justify-content-between align-items-start">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <div class="card-title-section">
                        <h3 class="card-title mb-1">New Bimbingan Section</h3>
                        <p class="card-subtitle text-muted mb-0">Add your subtitle here</p>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Card Actions">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item add-card" href="#"><i class="bi bi-plus-circle me-2"></i>Add</a></li>
                        <li><a class="dropdown-item edit-card" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item delete-card text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="card-content">
                    <p class="card-description">Add your content here. You can include information about technical guidance, requirements, or any other relevant details.</p>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <div class="info-content">
                                <strong>Information:</strong>
                                <span>Add your information here</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-edit-form d-none">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control edit-title" value="New Bimbingan Section" maxlength="100" required>
                        <div class="form-text">Maximum 100 characters</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subtitle</label>
                        <input type="text" class="form-control edit-subtitle" value="Add your subtitle here" maxlength="150">
                        <div class="form-text">Maximum 150 characters (optional)</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                        <textarea class="form-control edit-content" rows="6" required>Add your content here. You can include information about technical guidance, requirements, or any other relevant details.

• Information: Add your information here</textarea>
                        <div class="form-text">Use • for bullet points. Separate paragraphs with empty lines.</div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary save-card">
                            <i class="bi bi-check-lg me-2"></i>Save
                        </button>
                        <button class="btn btn-secondary cancel-edit">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        return newCard;
    }
    
    /**
     * Enter edit mode for a card with enhanced UX
     */
    function enterEditMode(card) {
        const cardContent = card.querySelector('.card-content');
        const editForm = card.querySelector('.card-edit-form');
        const titleElement = card.querySelector('.card-title');
        const subtitleElement = card.querySelector('.card-subtitle');
        
        // Set global edit mode flag
        isEditMode = true;
        
        // Populate edit form with current values
        const currentTitle = titleElement.textContent;
        const currentSubtitle = subtitleElement.textContent;
        const currentContent = getCardContentAsText(cardContent);
        
        editForm.querySelector('.edit-title').value = currentTitle;
        editForm.querySelector('.edit-subtitle').value = currentSubtitle;
        editForm.querySelector('.edit-content').value = currentContent;
        
        // Show edit form, hide content
        card.classList.add('edit-mode');
        cardContent.classList.add('d-none');
        editForm.classList.remove('d-none');
        
        // Add edit mode styling
        card.style.boxShadow = '0 8px 24px rgba(28, 110, 196, 0.2)';
        
        // Focus on title input
        setTimeout(() => {
            const titleInput = editForm.querySelector('.edit-title');
            titleInput.focus();
            titleInput.setSelectionRange(0, titleInput.value.length);
        }, 100);
        
        // Add character counters
        addCharacterCounters(editForm);
    }
    
    /**
     * Exit edit mode for a card
     */
    function exitEditMode(card) {
        const cardContent = card.querySelector('.card-content');
        const editForm = card.querySelector('.card-edit-form');
        
        // Clear global edit mode flag
        isEditMode = false;
        
        // Show content, hide edit form
        card.classList.remove('edit-mode');
        cardContent.classList.remove('d-none');
        editForm.classList.add('d-none');
        
        // Remove edit mode styling
        card.style.boxShadow = '';
        
        // Remove new card flag
        delete card.dataset.isNew;
        
        // Clear validation states
        editForm.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }
    
    /**
     * Update card content with new values and enhanced formatting
     */
    function updateCardContent(card, title, subtitle, content) {
        const titleElement = card.querySelector('.card-title');
        const subtitleElement = card.querySelector('.card-subtitle');
        const contentElement = card.querySelector('.card-content');
        
        // Update title and subtitle with animation
        titleElement.style.opacity = '0';
        subtitleElement.style.opacity = '0';
        
        setTimeout(() => {
            titleElement.textContent = title;
            subtitleElement.textContent = subtitle;
            titleElement.style.opacity = '1';
            subtitleElement.style.opacity = '1';
        }, 150);
        
        // Update content with enhanced formatting
        contentElement.innerHTML = formatContentToHTML(content);
        
        // Add update timestamp
        card.dataset.lastUpdated = new Date().toISOString();
    }
    
    /**
     * Enhanced content validation
     */
    function validateCardData(title, subtitle, content) {
        if (!title) {
            return {
                isValid: false,
                message: 'Title is required and cannot be empty.',
                focusElement: document.querySelector('.edit-title')
            };
        }
        
        if (title.length > 100) {
            return {
                isValid: false,
                message: 'Title must be 100 characters or less.',
                focusElement: document.querySelector('.edit-title')
            };
        }
        
        if (subtitle && subtitle.length > 150) {
            return {
                isValid: false,
                message: 'Subtitle must be 150 characters or less.',
                focusElement: document.querySelector('.edit-subtitle')
            };
        }
        
        if (!content) {
            return {
                isValid: false,
                message: 'Content is required and cannot be empty.',
                focusElement: document.querySelector('.edit-content')
            };
        }
        
        if (content.length > 5000) {
            return {
                isValid: false,
                message: 'Content must be 5000 characters or less.',
                focusElement: document.querySelector('.edit-content')
            };
        }
        
        return { isValid: true };
    }
    
    /**
     * Check for unsaved changes
     */
    function hasUnsavedChanges(card) {
        const editForm = card.querySelector('.card-edit-form');
        if (!editForm || editForm.classList.contains('d-none')) return false;
        
        const currentTitle = card.querySelector('.card-title').textContent;
        const currentSubtitle = card.querySelector('.card-subtitle').textContent;
        const currentContent = getCardContentAsText(card.querySelector('.card-content'));
        
        const formTitle = editForm.querySelector('.edit-title').value.trim();
        const formSubtitle = editForm.querySelector('.edit-subtitle').value.trim();
        const formContent = editForm.querySelector('.edit-content').value.trim();
        
        return currentTitle !== formTitle || 
               currentSubtitle !== formSubtitle || 
               currentContent !== formContent;
    }
    
    /**
     * Get card content as plain text with improved parsing
     */
    function getCardContentAsText(contentElement) {
        let text = '';
        const children = contentElement.children;
        
        for (let i = 0; i < children.length; i++) {
            const child = children[i];
            
            if (child.tagName === 'P') {
                text += child.textContent + '\n\n';
            } else if (child.tagName === 'UL') {
                const listItems = child.querySelectorAll('li');
                listItems.forEach(li => {
                    text += '• ' + li.textContent + '\n';
                });
                text += '\n';
            } else if (child.tagName === 'OL') {
                const listItems = child.querySelectorAll('li');
                listItems.forEach((li, index) => {
                    text += `${index + 1}. ${li.textContent}\n`;
                });
                text += '\n';
            } else if (child.classList && child.classList.contains('info-grid')) {
                const infoItems = child.querySelectorAll('.info-item');
                infoItems.forEach(item => {
                    const content = item.querySelector('.info-content');
                    if (content) {
                        const strong = content.querySelector('strong');
                        const span = content.querySelector('span');
                        if (strong && span) {
                            text += `• ${strong.textContent} ${span.textContent}\n`;
                        }
                    }
                });
                text += '\n';
            } else if (child.classList && child.classList.contains('alert')) {
                text += child.textContent.trim() + '\n\n';
            }
        }
        
        return text.trim();
    }
    
    /**
     * Enhanced content formatting to HTML
     */
    function formatContentToHTML(text) {
        const lines = text.split('\n');
        let html = '';
        let inList = false;
        let listType = 'ul';
        let currentParagraph = '';
        
        for (let i = 0; i < lines.length; i++) {
            const line = lines[i].trim();
            
            if (line === '') {
                // Empty line - end current paragraph or list
                if (currentParagraph) {
                    html += `<p class="card-description">${formatInlineContent(currentParagraph)}</p>`;
                    currentParagraph = '';
                }
                if (inList) {
                    html += `</div>`;
                    inList = false;
                }
                continue;
            }
            
            // Check for bullet points
            if (line.match(/^[•\-\*]\s/)) {
                if (currentParagraph) {
                    html += `<p class="card-description">${formatInlineContent(currentParagraph)}</p>`;
                    currentParagraph = '';
                }
                if (!inList) {
                    html += '<div class="info-grid">';
                    inList = true;
                }
                const listText = line.substring(1).trim();
                const parts = listText.split(':');
                if (parts.length >= 2) {
                    const label = parts[0].trim();
                    const value = parts.slice(1).join(':').trim();
                    html += `
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <div class="info-content">
                                <strong>${formatInlineContent(label)}:</strong>
                                <span>${formatInlineContent(value)}</span>
                            </div>
                        </div>
                    `;
                } else {
                    html += `
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="info-content">
                                <span>${formatInlineContent(listText)}</span>
                            </div>
                        </div>
                    `;
                }
            }
            else {
                // Regular text
                if (inList) {
                    html += `</div>`;
                    inList = false;
                }
                if (currentParagraph) {
                    currentParagraph += ' ' + line;
                } else {
                    currentParagraph = line;
                }
            }
        }
        
        // Close any remaining elements
        if (currentParagraph) {
            html += `<p class="card-description">${formatInlineContent(currentParagraph)}</p>`;
        }
        if (inList) {
            html += `</div>`;
        }
        
        return html;
    }
    
    /**
     * Format inline content (bold, italic, etc.)
     */
    function formatInlineContent(text) {
        return text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/`(.*?)`/g, '<code>$1</code>');
    }
    
    /**
     * Add character counters to form inputs
     */
    function addCharacterCounters(editForm) {
        const titleInput = editForm.querySelector('.edit-title');
        const subtitleInput = editForm.querySelector('.edit-subtitle');
        const contentTextarea = editForm.querySelector('.edit-content');
        
        // Add counter for title
        addCounter(titleInput, 100);
        addCounter(subtitleInput, 150);
        addCounter(contentTextarea, 5000);
    }
    
    function addCounter(element, maxLength) {
        const counter = document.createElement('div');
        counter.className = 'character-counter text-muted small mt-1';
        counter.style.textAlign = 'right';
        
        const updateCounter = () => {
            const remaining = maxLength - element.value.length;
            counter.textContent = `${element.value.length}/${maxLength}`;
            
            if (remaining < 20) {
                counter.style.color = '#D77936';
            } else {
                counter.style.color = '#6c757d';
            }
        };
        
        element.addEventListener('input', updateCounter);
        element.parentNode.appendChild(counter);
        updateCounter();
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
     * Initialize enhanced animations and observers
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
        const cards = document.querySelectorAll('.bimbingan-card, .contact-card');
        cards.forEach(card => {
            observer.observe(card);
        });
        
        // Re-observe new cards when they're added
        const bimbinganContent = document.getElementById('bimbinganContent');
        const mutationObserver = new MutationObserver(function(mutations) {
            mutations.forEach(mutation => {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1 && (node.classList.contains('bimbingan-card') || node.classList.contains('contact-card'))) {
                        observer.observe(node);
                    }
                });
            });
        });
        
        mutationObserver.observe(bimbinganContent, { childList: true });
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
                    const saveButton = editMode.querySelector('.save-card');
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
            
            // Ctrl/Cmd + N to add new card
            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                e.preventDefault();
                const lastCard = document.querySelector('.bimbingan-card:last-of-type, .contact-card:last-of-type');
                if (lastCard) {
                    const addButton = lastCard.querySelector('.add-card');
                    if (addButton) {
                        addButton.click();
                    }
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
            { selector: '.add-card', title: 'Add new card below (Ctrl+N)' },
            { selector: '.edit-card', title: 'Edit this card' },
            { selector: '.delete-card', title: 'Delete this card' },
            { selector: '.save-card', title: 'Save changes (Ctrl+S)' },
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
     * Auto-save functionality
     */
    function startAutoSave(card) {
        stopAutoSave(); // Clear any existing auto-save
        
        autoSaveInterval = setInterval(() => {
            if (card.classList.contains('edit-mode')) {
                saveCardToStorage(card, true); // Auto-save flag
            }
        }, 30000); // Auto-save every 30 seconds
    }
    
    function stopAutoSave() {
        if (autoSaveInterval) {
            clearInterval(autoSaveInterval);
            autoSaveInterval = null;
        }
    }
    
    /**
     * Save card data to localStorage
     */
    function saveCardToStorage(card, isAutoSave = false) {
        try {
            const cardId = card.dataset.cardId;
            const cardData = {
                id: cardId,
                title: card.querySelector('.card-title').textContent,
                subtitle: card.querySelector('.card-subtitle').textContent,
                content: getCardContentAsText(card.querySelector('.card-content')),
                lastUpdated: new Date().toISOString(),
                isAutoSave: isAutoSave
            };
            
            localStorage.setItem(`inlislite_bimbingan_card_${cardId}`, JSON.stringify(cardData));
            
            if (isAutoSave) {
                console.log(`Auto-saved bimbingan card ${cardId}`);
            }
        } catch (error) {
            console.error('Failed to save card to localStorage:', error);
        }
    }
    
    /**
     * Update card counter display
     */
    function updateCardCounter() {
        const cardCount = document.querySelectorAll('.bimbingan-card, .contact-card').length;
        console.log(`Total bimbingan cards: ${cardCount}`);
    }
    
    /**
     * Load saved cards from localStorage on page load
     */
    function loadSavedCards() {
        try {
            const cards = document.querySelectorAll('.bimbingan-card, .contact-card');
            cards.forEach(card => {
                const cardId = card.dataset.cardId;
                const savedData = localStorage.getItem(`inlislite_bimbingan_card_${cardId}`);
                
                if (savedData) {
                    const data = JSON.parse(savedData);
                    if (data.isAutoSave) {
                        console.log(`Found auto-saved data for bimbingan card ${cardId}`);
                        // Could restore auto-saved data here if needed
                    }
                }
            });
        } catch (error) {
            console.error('Failed to load saved cards:', error);
        }
    }
    
    // Initialize saved cards
    loadSavedCards();
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        stopAutoSave();
    });
    
    console.log('Bimbingan Teknis INLISLite v3.0 - Enhanced interactive functionality loaded successfully');
});