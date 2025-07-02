/**
 * INLISLite v3.0 About Page JavaScript
 * Handles card editing, adding, deleting, and interactive functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    let cardCounter = 4; // Start from 5 since we have 4 initial cards
    
    // Initialize all functionality
    initializeCardActions();
    initializeAnimations();
    
    /**
     * Initialize card action handlers
     */
    function initializeCardActions() {
        const aboutContent = document.getElementById('aboutContent');
        
        // Event delegation for dynamic content
        aboutContent.addEventListener('click', function(e) {
            const target = e.target.closest('a') || e.target.closest('button');
            if (!target) return;
            
            e.preventDefault();
            
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
    }
    
    /**
     * Handle adding a new card
     */
    function handleAddCard(button) {
        const currentCard = button.closest('.about-card');
        const newCard = createNewCard();
        
        // Insert after current card
        currentCard.insertAdjacentElement('afterend', newCard);
        
        // Animate the new card
        newCard.classList.add('new-card');
        
        // Scroll to and focus on the new card
        setTimeout(() => {
            newCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            const titleInput = newCard.querySelector('.edit-title');
            if (titleInput) {
                titleInput.focus();
                titleInput.select();
            }
        }, 100);
        
        // Automatically enter edit mode
        setTimeout(() => {
            enterEditMode(newCard);
        }, 300);
        
        showAlert('New card added successfully!', 'success');
    }
    
    /**
     * Handle editing a card
     */
    function handleEditCard(button) {
        const card = button.closest('.about-card');
        enterEditMode(card);
        showAlert('Edit mode activated. Make your changes and click Save.', 'info');
    }
    
    /**
     * Handle deleting a card
     */
    function handleDeleteCard(button) {
        const card = button.closest('.about-card');
        const cardTitle = card.querySelector('.card-title').textContent;
        
        // Show confirmation dialog
        if (confirm(`Are you sure you want to delete the card "${cardTitle}"?`)) {
            // Add fade out animation
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '0';
            card.style.transform = 'translateY(-20px)';
            
            setTimeout(() => {
                card.remove();
                showAlert('Card deleted successfully!', 'success');
            }, 300);
        }
    }
    
    /**
     * Handle saving card changes
     */
    function handleSaveCard(button) {
        const card = button.closest('.about-card');
        const editForm = card.querySelector('.card-edit-form');
        
        // Get form values
        const newTitle = editForm.querySelector('.edit-title').value.trim();
        const newSubtitle = editForm.querySelector('.edit-subtitle').value.trim();
        const newContent = editForm.querySelector('.edit-content').value.trim();
        
        // Validate inputs
        if (!newTitle) {
            showAlert('Title is required!', 'danger');
            editForm.querySelector('.edit-title').focus();
            return;
        }
        
        if (!newContent) {
            showAlert('Content is required!', 'danger');
            editForm.querySelector('.edit-content').focus();
            return;
        }
        
        // Update card content
        updateCardContent(card, newTitle, newSubtitle, newContent);
        
        // Exit edit mode
        exitEditMode(card);
        
        showAlert('Card updated successfully!', 'success');
    }
    
    /**
     * Handle canceling edit
     */
    function handleCancelEdit(button) {
        const card = button.closest('.about-card');
        
        // If this is a new card (no original content), remove it
        if (card.dataset.isNew === 'true') {
            card.remove();
            showAlert('New card creation cancelled.', 'info');
            return;
        }
        
        // Otherwise, just exit edit mode
        exitEditMode(card);
        showAlert('Edit cancelled.', 'info');
    }
    
    /**
     * Create a new card element
     */
    function createNewCard() {
        cardCounter++;
        const newCard = document.createElement('div');
        newCard.className = 'about-card card';
        newCard.dataset.cardId = cardCounter;
        newCard.dataset.isNew = 'true';
        
        newCard.innerHTML = `
            <div class="card-header d-flex justify-content-between align-items-start">
                <div class="card-title-section">
                    <h3 class="card-title mb-1">New Section Title</h3>
                    <p class="card-subtitle text-muted mb-0">Add your subtitle here</p>
                </div>
                <div class="dropdown">
                    <button class="action-btn btn btn-link p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                    <p>Add your content here. You can include multiple paragraphs, lists, or any other content you need.</p>
                </div>
                <div class="card-edit-form d-none">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" class="form-control edit-title" value="New Section Title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subtitle</label>
                        <input type="text" class="form-control edit-subtitle" value="Add your subtitle here">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Content</label>
                        <textarea class="form-control edit-content" rows="4">Add your content here. You can include multiple paragraphs, lists, or any other content you need.</textarea>
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
     * Enter edit mode for a card
     */
    function enterEditMode(card) {
        const cardContent = card.querySelector('.card-content');
        const editForm = card.querySelector('.card-edit-form');
        const titleElement = card.querySelector('.card-title');
        const subtitleElement = card.querySelector('.card-subtitle');
        
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
        
        // Focus on title input
        setTimeout(() => {
            editForm.querySelector('.edit-title').focus();
        }, 100);
    }
    
    /**
     * Exit edit mode for a card
     */
    function exitEditMode(card) {
        const cardContent = card.querySelector('.card-content');
        const editForm = card.querySelector('.card-edit-form');
        
        // Show content, hide edit form
        card.classList.remove('edit-mode');
        cardContent.classList.remove('d-none');
        editForm.classList.add('d-none');
        
        // Remove new card flag
        delete card.dataset.isNew;
    }
    
    /**
     * Update card content with new values
     */
    function updateCardContent(card, title, subtitle, content) {
        const titleElement = card.querySelector('.card-title');
        const subtitleElement = card.querySelector('.card-subtitle');
        const contentElement = card.querySelector('.card-content');
        
        // Update title and subtitle
        titleElement.textContent = title;
        subtitleElement.textContent = subtitle;
        
        // Update content (convert text to HTML)
        contentElement.innerHTML = formatContentToHTML(content);
    }
    
    /**
     * Get card content as plain text
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
            }
        }
        
        return text.trim();
    }
    
    /**
     * Format text content to HTML
     */
    function formatContentToHTML(text) {
        const lines = text.split('\n');
        let html = '';
        let inList = false;
        let currentParagraph = '';
        
        for (let i = 0; i < lines.length; i++) {
            const line = lines[i].trim();
            
            if (line === '') {
                // Empty line - end current paragraph or list
                if (currentParagraph) {
                    html += `<p>${currentParagraph}</p>`;
                    currentParagraph = '';
                }
                if (inList) {
                    html += '</ul>';
                    inList = false;
                }
                continue;
            }
            
            if (line.startsWith('•') || line.startsWith('-') || line.startsWith('*')) {
                // List item
                if (currentParagraph) {
                    html += `<p>${currentParagraph}</p>`;
                    currentParagraph = '';
                }
                if (!inList) {
                    html += '<ul>';
                    inList = true;
                }
                const listText = line.substring(1).trim();
                html += `<li>${listText}</li>`;
            } else {
                // Regular text
                if (inList) {
                    html += '</ul>';
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
            html += `<p>${currentParagraph}</p>`;
        }
        if (inList) {
            html += '</ul>';
        }
        
        return html;
    }
    
    /**
     * Show alert message
     */
    function showAlert(message, type = 'info') {
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
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }
    
    /**
     * Get appropriate icon for alert type
     */
    function getAlertIcon(type) {
        switch (type) {
            case 'success': return 'check-circle';
            case 'danger': return 'exclamation-circle';
            case 'warning': return 'exclamation-triangle';
            case 'info': return 'info-circle';
            default: return 'info-circle';
        }
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
        const cards = document.querySelectorAll('.about-card');
        cards.forEach(card => {
            observer.observe(card);
        });
        
        // Re-observe new cards when they're added
        const aboutContent = document.getElementById('aboutContent');
        const mutationObserver = new MutationObserver(function(mutations) {
            mutations.forEach(mutation => {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1 && node.classList.contains('about-card')) {
                        observer.observe(node);
                    }
                });
            });
        });
        
        mutationObserver.observe(aboutContent, { childList: true });
    }
    
    /**
     * Handle keyboard shortcuts
     */
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S to save when in edit mode
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            const editMode = document.querySelector('.edit-mode');
            if (editMode) {
                e.preventDefault();
                const saveButton = editMode.querySelector('.save-card');
                if (saveButton) {
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
    });
    
    /**
     * Auto-save functionality (optional)
     */
    function initializeAutoSave() {
        let autoSaveTimeout;
        
        document.addEventListener('input', function(e) {
            if (e.target.matches('.edit-title, .edit-subtitle, .edit-content')) {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(() => {
                    // Save to localStorage
                    const card = e.target.closest('.about-card');
                    const cardId = card.dataset.cardId;
                    const formData = {
                        title: card.querySelector('.edit-title').value,
                        subtitle: card.querySelector('.edit-subtitle').value,
                        content: card.querySelector('.edit-content').value
                    };
                    
                    localStorage.setItem(`inlislite_card_${cardId}`, JSON.stringify(formData));
                }, 2000); // Auto-save after 2 seconds of inactivity
            }
        });
    }
    
    // Initialize auto-save
    initializeAutoSave();
    
    console.log('About INLISLite v3.0 - Interactive functionality loaded successfully');
});