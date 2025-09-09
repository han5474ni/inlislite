/**
 * User History Page JavaScript
 * Handles filtering, animations, and interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    initializeUserHistory();
});

function initializeUserHistory() {
    initializeActivityFilter();
    initializeToggleDetails();
    initializeAnimations();
    calculateSummaryCounts();
}

/**
 * Initialize activity filter functionality
 */
function initializeActivityFilter() {
    const filterSelect = document.getElementById('activityFilter');
    const timelineItems = document.querySelectorAll('.timeline-item');
    
    if (!filterSelect || timelineItems.length === 0) {
        return;
    }
    
    filterSelect.addEventListener('change', function() {
        const filterValue = this.value;
        
        timelineItems.forEach(item => {
            const activityType = item.getAttribute('data-activity-type');
            const shouldShow = shouldShowActivity(activityType, filterValue);
            
            if (shouldShow) {
                showTimelineItem(item);
            } else {
                hideTimelineItem(item);
            }
        });
        
        // Update date separators visibility after filtering
        setTimeout(() => {
            updateDateSeparators();
        }, 350);
    });
}

/**
 * Determine if activity should be shown based on filter
 */
function shouldShowActivity(activityType, filterValue) {
    switch(filterValue) {
        case 'all':
            return true;
        case 'login':
            return activityType === 'login' || activityType === 'logout';
        case 'profile':
            return activityType.includes('update') || activityType.includes('profile');
        case 'security':
            return activityType === 'password_change' || activityType.includes('security');
        case 'system':
            return activityType === 'system_access' || activityType.includes('system');
        default:
            return true;
    }
}

/**
 * Show timeline item with animation
 */
function showTimelineItem(item) {
    item.classList.remove('filtering-out');
    item.style.display = 'flex';
    
    // Trigger reflow for animation
    item.offsetHeight;
    
    setTimeout(() => {
        item.style.opacity = '1';
        item.style.transform = 'translateY(0)';
    }, 50);
}

/**
 * Hide timeline item with animation
 */
function hideTimelineItem(item) {
    item.classList.add('filtering-out');
    item.style.opacity = '0';
    item.style.transform = 'translateY(-10px)';
    
    setTimeout(() => {
        item.style.display = 'none';
    }, 300);
}

/**
 * Update visibility of date separators based on visible items
 */
function updateDateSeparators() {
    const dateSeparators = document.querySelectorAll('.timeline-date-separator');
    
    dateSeparators.forEach(separator => {
        const nextItems = getNextTimelineItems(separator);
        const hasVisibleItems = nextItems.some(item => isItemVisible(item));
        
        separator.style.display = hasVisibleItems ? 'block' : 'none';
    });
}

/**
 * Get timeline items that follow a date separator
 */
function getNextTimelineItems(separator) {
    const nextItems = [];
    let nextElement = separator.nextElementSibling;
    
    while (nextElement && !nextElement.classList.contains('timeline-date-separator')) {
        if (nextElement.classList.contains('timeline-item')) {
            nextItems.push(nextElement);
        }
        nextElement = nextElement.nextElementSibling;
    }
    
    return nextItems;
}

/**
 * Check if timeline item is visible
 */
function isItemVisible(item) {
    return item.style.display !== 'none' && !item.classList.contains('filtering-out');
}

/**
 * Initialize toggle details functionality
 */
function initializeToggleDetails() {
    const toggleButtons = document.querySelectorAll('.toggle-details');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('i');
            
            // Add smooth rotation animation
            if (icon) {
                setTimeout(() => {
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    icon.style.transform = isExpanded ? 'rotate(180deg)' : 'rotate(0deg)';
                }, 100);
            }
        });
        
        // Handle collapse events for better UX
        const targetId = button.getAttribute('data-bs-target');
        if (targetId) {
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.addEventListener('shown.bs.collapse', function() {
                    // Scroll into view if needed
                    const rect = this.getBoundingClientRect();
                    const viewportHeight = window.innerHeight;
                    
                    if (rect.bottom > viewportHeight) {
                        this.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'end' 
                        });
                    }
                });
            }
        }
    });
}

/**
 * Initialize various animations and interactions
 */
function initializeAnimations() {
    // Add hover effects to activity cards
    const activityCards = document.querySelectorAll('.activity-card');
    
    activityCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add loading animation for statistics cards
    const statCards = document.querySelectorAll('.stat-card');
    
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Add stagger animation for timeline items
    const timelineItems = document.querySelectorAll('.timeline-item');
    
    timelineItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.5s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 500 + (index * 100));
    });
}

/**
 * Utility function to format dates
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffTime = Math.abs(now - date);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    if (diffDays === 1) {
        return 'Yesterday';
    } else if (diffDays < 7) {
        return `${diffDays} days ago`;
    } else {
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }
}

/**
 * Export activity data (if needed)
 */
function exportActivityData() {
    const activities = [];
    const timelineItems = document.querySelectorAll('.timeline-item:not([style*="display: none"])');
    
    timelineItems.forEach(item => {
        const title = item.querySelector('.activity-title h6')?.textContent;
        const type = item.getAttribute('data-activity-type');
        const time = item.querySelector('.activity-meta small')?.textContent;
        const ip = item.querySelector('.info-item strong')?.textContent;
        
        if (title && type) {
            activities.push({
                title,
                type,
                time,
                ip
            });
        }
    });
    
    return activities;
}

/**
 * Print functionality
 */
function printHistory() {
    window.print();
}

/**
 * Calculate and display summary counts
 */
function calculateSummaryCounts() {
    const timelineItems = document.querySelectorAll('.timeline-item');
    const now = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    const weekStart = new Date(today);
    weekStart.setDate(today.getDate() - today.getDay());
    const monthStart = new Date(now.getFullYear(), now.getMonth(), 1);
    
    let todayCount = 0;
    let weekCount = 0;
    let monthCount = 0;
    
    timelineItems.forEach(item => {
        const dateElements = item.closest('.activity-timeline').querySelectorAll('.timeline-date-separator .date-label');
        let itemDate = null;
        
        // Find the date for this item
        let currentElement = item.previousElementSibling;
        while (currentElement) {
            if (currentElement.classList.contains('timeline-date-separator')) {
                const dateText = currentElement.querySelector('.date-label')?.textContent;
                if (dateText) {
                    itemDate = parseActivityDate(dateText);
                }
                break;
            }
            currentElement = currentElement.previousElementSibling;
        }
        
        if (itemDate) {
            if (itemDate >= today) {
                todayCount++;
            }
            if (itemDate >= weekStart) {
                weekCount++;
            }
            if (itemDate >= monthStart) {
                monthCount++;
            }
        }
    });
    
    // Update the counts with animation
    animateCount('todayCount', todayCount);
    animateCount('weekCount', weekCount);
    animateCount('monthCount', monthCount);
}

/**
 * Parse activity date from text
 */
function parseActivityDate(dateText) {
    // Handle different date formats
    const now = new Date();
    
    if (dateText.includes('Today') || dateText === new Date().toLocaleDateString('en-GB', {day: '2-digit', month: 'short', year: 'numeric'})) {
        return new Date(now.getFullYear(), now.getMonth(), now.getDate());
    }
    
    // Try to parse the date
    const parts = dateText.split(' ');
    if (parts.length >= 3) {
        const day = parseInt(parts[0]);
        const month = parts[1];
        const year = parseInt(parts[2]);
        
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                           'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const monthIndex = monthNames.indexOf(month);
        
        if (monthIndex !== -1) {
            return new Date(year, monthIndex, day);
        }
    }
    
    return new Date(dateText);
}

/**
 * Animate count numbers
 */
function animateCount(elementId, targetCount) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    const startCount = 0;
    const duration = 1000;
    const startTime = performance.now();
    
    function updateCount(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        const currentCount = Math.floor(startCount + (targetCount - startCount) * progress);
        element.textContent = currentCount;
        
        if (progress < 1) {
            requestAnimationFrame(updateCount);
        }
    }
    
    requestAnimationFrame(updateCount);
}

/**
 * Refresh history page
 */
function refreshHistory() {
    const refreshBtn = document.querySelector('button[onclick="refreshHistory()"] i');
    
    if (refreshBtn) {
        refreshBtn.classList.add('fa-spin');
        refreshBtn.style.animation = 'spin 1s linear infinite';
    }
    
    setTimeout(() => {
        window.location.reload();
    }, 500);
}

// Add CSS for spin animation
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);

// Make functions available globally if needed
window.UserHistory = {
    exportActivityData,
    printHistory,
    formatDate
};

// Make refresh function global
window.refreshHistory = refreshHistory;