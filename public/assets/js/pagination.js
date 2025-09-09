/**
 * Enhanced Pagination JavaScript
 * INLISLite v3.0
 */

class PaginationManager {
    constructor(options = {}) {
        this.options = {
            container: '.pagination-wrapper',
            loadingClass: 'pagination-loading',
            fadeClass: 'pagination-fade-in',
            ajaxCallback: null,
            onPageChange: null,
            onPageSizeChange: null,
            enableKeyboardNavigation: true,
            enableUrlUpdate: true,
            ...options
        };
        
        this.currentPage = 1;
        this.pageSize = 10;
        this.totalPages = 1;
        this.isLoading = false;
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        if (this.options.enableKeyboardNavigation) {
            this.bindKeyboardEvents();
        }
        this.updateFromUrl();
    }
    
    bindEvents() {
        // Page size change
        document.addEventListener('change', (e) => {
            if (e.target.id === 'pageSize') {
                this.changePageSize(parseInt(e.target.value));
            }
        });
        
        // Pagination clicks
        document.addEventListener('click', (e) => {
            if (e.target.closest('.pagination-modern .page-link')) {
                e.preventDefault();
                const link = e.target.closest('.page-link');
                const pageItem = link.closest('.page-item');
                
                if (pageItem.classList.contains('disabled') || pageItem.classList.contains('active')) {
                    return;
                }
                
                const page = this.extractPageFromLink(link);
                if (page) {
                    this.goToPage(page);
                }
            }
        });
    }
    
    bindKeyboardEvents() {
        document.addEventListener('keydown', (e) => {
            // Only handle if pagination is focused or no input is focused
            if (document.activeElement.tagName === 'INPUT' || 
                document.activeElement.tagName === 'TEXTAREA' ||
                document.activeElement.tagName === 'SELECT') {
                return;
            }
            
            switch(e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    this.previousPage();
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    this.nextPage();
                    break;
                case 'Home':
                    e.preventDefault();
                    this.goToPage(1);
                    break;
                case 'End':
                    e.preventDefault();
                    this.goToPage(this.totalPages);
                    break;
            }
        });
    }
    
    extractPageFromLink(link) {
        // Try to get page from onclick attribute
        const onclick = link.getAttribute('onclick');
        if (onclick) {
            const match = onclick.match(/\((\d+),/);
            return match ? parseInt(match[1]) : null;
        }
        
        // Try to get page from href
        const href = link.getAttribute('href');
        if (href && href !== '#') {
            const url = new URL(href, window.location.origin);
            return parseInt(url.searchParams.get('page')) || null;
        }
        
        // Try to get page from text content
        const text = link.textContent.trim();
        if (/^\d+$/.test(text)) {
            return parseInt(text);
        }
        
        return null;
    }
    
    goToPage(page) {
        if (this.isLoading || page === this.currentPage || page < 1 || page > this.totalPages) {
            return;
        }
        
        this.currentPage = page;
        this.showLoading();
        
        if (this.options.ajaxCallback) {
            this.options.ajaxCallback(page, this.pageSize);
        } else if (this.options.onPageChange) {
            this.options.onPageChange(page, this.pageSize);
        } else {
            this.updateUrl();
            window.location.reload();
        }
    }
    
    changePageSize(newSize) {
        if (this.isLoading || newSize === this.pageSize) {
            return;
        }
        
        this.pageSize = newSize;
        this.currentPage = 1; // Reset to first page
        this.showLoading();
        
        if (this.options.onPageSizeChange) {
            this.options.onPageSizeChange(1, newSize);
        } else if (this.options.ajaxCallback) {
            this.options.ajaxCallback(1, newSize);
        } else {
            this.updateUrl();
            window.location.reload();
        }
    }
    
    nextPage() {
        if (this.currentPage < this.totalPages) {
            this.goToPage(this.currentPage + 1);
        }
    }
    
    previousPage() {
        if (this.currentPage > 1) {
            this.goToPage(this.currentPage - 1);
        }
    }
    
    showLoading() {
        this.isLoading = true;
        const container = document.querySelector(this.options.container);
        if (container) {
            container.classList.add(this.options.loadingClass);
        }
    }
    
    hideLoading() {
        this.isLoading = false;
        const container = document.querySelector(this.options.container);
        if (container) {
            container.classList.remove(this.options.loadingClass);
            container.classList.add(this.options.fadeClass);
            
            // Remove fade class after animation
            setTimeout(() => {
                container.classList.remove(this.options.fadeClass);
            }, 300);
        }
    }
    
    updateUrl() {
        if (!this.options.enableUrlUpdate) return;
        
        const url = new URL(window.location);
        url.searchParams.set('page', this.currentPage);
        url.searchParams.set('per_page', this.pageSize);
        
        // Update URL without reloading
        window.history.pushState({}, '', url.toString());
    }
    
    updateFromUrl() {
        const url = new URL(window.location);
        const page = parseInt(url.searchParams.get('page')) || 1;
        const pageSize = parseInt(url.searchParams.get('per_page')) || 10;
        
        this.currentPage = page;
        this.pageSize = pageSize;
        
        // Update page size selector
        const pageSizeSelect = document.getElementById('pageSize');
        if (pageSizeSelect) {
            pageSizeSelect.value = pageSize;
        }
    }
    
    updatePagination(data) {
        this.currentPage = data.current_page || 1;
        this.totalPages = data.total_pages || 1;
        this.pageSize = data.per_page || 10;
        
        this.hideLoading();
        
        // Update pagination display if needed
        this.refreshPaginationDisplay(data);
    }
    
    refreshPaginationDisplay(data) {
        // This method can be overridden to update pagination HTML
        // For now, we'll just update the URL
        if (this.options.enableUrlUpdate) {
            this.updateUrl();
        }
    }
    
    // Static method to create pagination for DataTables
    static createDataTablesPagination(table, options = {}) {
        const defaultOptions = {
            ajaxCallback: (page, pageSize) => {
                table.page.len(pageSize).draw();
                table.page(page - 1).draw('page');
            },
            onPageChange: (page, pageSize) => {
                table.page.len(pageSize).draw();
                table.page(page - 1).draw('page');
            }
        };
        
        return new PaginationManager({...defaultOptions, ...options});
    }
}

// DataTables Integration
if (typeof $ !== 'undefined' && $.fn.DataTable) {
    // Custom DataTables pagination renderer
    $.fn.dataTable.ext.renderer.pageButton.bootstrap = function (settings, host, idx, buttons, page, pages) {
        // Custom pagination rendering logic here
        // This integrates with our custom pagination component
    };
    
    // DataTables plugin for custom pagination
    $.fn.dataTable.Api.register('customPagination()', function(options = {}) {
        const table = this;
        const settings = table.settings()[0];
        
        // Hide default pagination
        $(settings.nTableWrapper).find('.dataTables_paginate').hide();
        $(settings.nTableWrapper).find('.dataTables_info').hide();
        $(settings.nTableWrapper).find('.dataTables_length').hide();
        
        // Create custom pagination
        const paginationManager = PaginationManager.createDataTablesPagination(table, options);
        
        // Update pagination on table draw
        table.on('draw', function() {
            const info = table.page.info();
            paginationManager.updatePagination({
                current_page: info.page + 1,
                total_pages: info.pages,
                per_page: info.length,
                total_records: info.recordsTotal
            });
        });
        
        return paginationManager;
    });
}

// Utility functions
const PaginationUtils = {
    // Format numbers with commas
    formatNumber: (num) => {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    },
    
    // Calculate page range
    calculatePageRange: (currentPage, totalPages, maxVisible = 5) => {
        const halfVisible = Math.floor(maxVisible / 2);
        let startPage = Math.max(1, currentPage - halfVisible);
        let endPage = Math.min(totalPages, startPage + maxVisible - 1);
        
        if (endPage - startPage + 1 < maxVisible) {
            startPage = Math.max(1, endPage - maxVisible + 1);
        }
        
        return { startPage, endPage };
    },
    
    // Generate pagination HTML
    generatePaginationHTML: (data, options = {}) => {
        const {
            currentPage = 1,
            totalPages = 1,
            totalRecords = 0,
            perPage = 10,
            baseUrl = '',
            filters = {},
            useAjax = false,
            ajaxCallback = 'loadPage'
        } = data;
        
        const { maxVisible = 5 } = options;
        const { startPage, endPage } = PaginationUtils.calculatePageRange(currentPage, totalPages, maxVisible);
        
        let html = '<div class="pagination-wrapper">';
        
        // Results info
        const startRecord = (currentPage - 1) * perPage + 1;
        const endRecord = Math.min(currentPage * perPage, totalRecords);
        
        html += `
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
                <div class="pagination-info">
                    <span class="text-muted">
                        Results: <strong>${PaginationUtils.formatNumber(startRecord)}</strong> - 
                        <strong>${PaginationUtils.formatNumber(endRecord)}</strong> of 
                        <strong>${PaginationUtils.formatNumber(totalRecords)}</strong>
                    </span>
                </div>
                <div class="page-size-selector">
                    <div class="d-flex align-items-center gap-2">
                        <label for="pageSize" class="form-label mb-0 text-muted small">Show:</label>
                        <select class="form-select form-select-sm" id="pageSize" style="width: auto;">
                            ${[10, 25, 50, 100].map(size => 
                                `<option value="${size}" ${perPage == size ? 'selected' : ''}>${size}</option>`
                            ).join('')}
                        </select>
                        <span class="text-muted small">per page</span>
                    </div>
                </div>
            </div>
        `;
        
        // Pagination navigation
        if (totalPages > 1) {
            html += '<nav aria-label="Page navigation" class="d-flex justify-content-center">';
            html += '<ul class="pagination pagination-modern mb-0">';
            
            // Previous button
            html += `
                <li class="page-item ${currentPage <= 1 ? 'disabled' : ''}">
                    <a class="page-link page-nav" href="#" data-page="${currentPage - 1}">
                        <i class="bi bi-chevron-left"></i>
                        <span class="d-none d-sm-inline ms-1">Previous</span>
                    </a>
                </li>
            `;
            
            // First page
            if (startPage > 1) {
                html += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
                if (startPage > 2) {
                    html += '<li class="page-item disabled"><span class="page-link page-ellipsis">...</span></li>';
                }
            }
            
            // Page numbers
            for (let i = startPage; i <= endPage; i++) {
                html += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            }
            
            // Last page
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    html += '<li class="page-item disabled"><span class="page-link page-ellipsis">...</span></li>';
                }
                html += `<li class="page-item"><a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a></li>`;
            }
            
            // Next button
            html += `
                <li class="page-item ${currentPage >= totalPages ? 'disabled' : ''}">
                    <a class="page-link page-nav" href="#" data-page="${currentPage + 1}">
                        <span class="d-none d-sm-inline me-1">Next</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            `;
            
            html += '</ul></nav>';
        }
        
        html += '</div>';
        
        return html;
    }
};

// Auto-initialize pagination on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize pagination if container exists
    if (document.querySelector('.pagination-wrapper')) {
        window.paginationManager = new PaginationManager();
    }
});

// Export for use in modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { PaginationManager, PaginationUtils };
}

// Global access
window.PaginationManager = PaginationManager;
window.PaginationUtils = PaginationUtils;