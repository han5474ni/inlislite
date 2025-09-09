<?php
/**
 * Reusable Pagination Component
 * 
 * @param array $pagination - Pagination data
 * @param array $filters - Current filters (optional)
 * @param string $baseUrl - Base URL for pagination links
 * @param array $options - Additional options
 */

// Default values
$pagination = $pagination ?? [];
$filters = $filters ?? [];
$baseUrl = $baseUrl ?? current_url();
$options = $options ?? [];

// Extract pagination data
$currentPage = $pagination['current_page'] ?? 1;
$totalPages = $pagination['total_pages'] ?? 1;
$totalRecords = $pagination['total_records'] ?? 0;
$perPage = $pagination['per_page'] ?? 10;
$startRecord = ($currentPage - 1) * $perPage + 1;
$endRecord = min($currentPage * $perPage, $totalRecords);

// Options
$showPageSize = $options['show_page_size'] ?? true;
$showResultCount = $options['show_result_count'] ?? true;
$pageSizeOptions = $options['page_size_options'] ?? [10, 25, 50, 100];
$maxVisiblePages = $options['max_visible_pages'] ?? 5;
$useAjax = $options['use_ajax'] ?? false;
$ajaxCallback = $options['ajax_callback'] ?? 'loadPage';

// Calculate visible page range
$halfVisible = floor($maxVisiblePages / 2);
$startPage = max(1, $currentPage - $halfVisible);
$endPage = min($totalPages, $startPage + $maxVisiblePages - 1);

// Adjust start page if we're near the end
if ($endPage - $startPage + 1 < $maxVisiblePages) {
    $startPage = max(1, $endPage - $maxVisiblePages + 1);
}

// Build query string helper
function buildQuery($filters, $page = null, $perPage = null) {
    $query = $filters;
    if ($page !== null) $query['page'] = $page;
    if ($perPage !== null) $query['per_page'] = $perPage;
    return http_build_query($query);
}
?>

<div class="pagination-wrapper">
    <!-- Results Info and Page Size Selector -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
        <?php if ($showResultCount): ?>
        <div class="pagination-info">
            <span class="text-muted">
                Results: <strong><?= number_format($startRecord) ?></strong> - <strong><?= number_format($endRecord) ?></strong> of <strong><?= number_format($totalRecords) ?></strong>
            </span>
        </div>
        <?php endif; ?>

        <?php if ($showPageSize): ?>
        <div class="page-size-selector">
            <div class="d-flex align-items-center gap-2">
                <label for="pageSize" class="form-label mb-0 text-muted small">Show:</label>
                <select class="form-select form-select-sm" id="pageSize" style="width: auto;" 
                        <?= $useAjax ? "onchange=\"{$ajaxCallback}(1, this.value)\"" : "onchange=\"changePage(1, this.value)\"" ?>>
                    <?php foreach ($pageSizeOptions as $size): ?>
                        <option value="<?= $size ?>" <?= $perPage == $size ? 'selected' : '' ?>><?= $size ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="text-muted small">per page</span>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pagination Navigation -->
    <?php if ($totalPages > 1): ?>
    <nav aria-label="Page navigation" class="d-flex justify-content-center">
        <ul class="pagination pagination-modern mb-0">
            <!-- Previous Button -->
            <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                <?php if ($useAjax): ?>
                    <button class="page-link page-nav" 
                            <?= $currentPage > 1 ? "onclick=\"{$ajaxCallback}(" . ($currentPage - 1) . ", {$perPage})\"" : 'disabled' ?>
                            aria-label="Previous page">
                        <i class="bi bi-chevron-left"></i>
                        <span class="d-none d-sm-inline ms-1">Previous</span>
                    </button>
                <?php else: ?>
                    <a class="page-link page-nav" 
                       href="<?= $currentPage > 1 ? $baseUrl . '?' . buildQuery($filters, $currentPage - 1, $perPage) : '#' ?>"
                       aria-label="Previous page">
                        <i class="bi bi-chevron-left"></i>
                        <span class="d-none d-sm-inline ms-1">Previous</span>
                    </a>
                <?php endif; ?>
            </li>

            <!-- First Page -->
            <?php if ($startPage > 1): ?>
                <li class="page-item">
                    <?php if ($useAjax): ?>
                        <button class="page-link" onclick="<?= $ajaxCallback ?>(1, <?= $perPage ?>)">1</button>
                    <?php else: ?>
                        <a class="page-link" href="<?= $baseUrl . '?' . buildQuery($filters, 1, $perPage) ?>">1</a>
                    <?php endif; ?>
                </li>
                <?php if ($startPage > 2): ?>
                    <li class="page-item disabled">
                        <span class="page-link page-ellipsis">...</span>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                    <?php if ($useAjax): ?>
                        <button class="page-link" 
                                <?= $i != $currentPage ? "onclick=\"{$ajaxCallback}({$i}, {$perPage})\"" : '' ?>
                                <?= $i == $currentPage ? 'aria-current="page"' : '' ?>>
                            <?= $i ?>
                        </button>
                    <?php else: ?>
                        <a class="page-link" 
                           href="<?= $i != $currentPage ? $baseUrl . '?' . buildQuery($filters, $i, $perPage) : '#' ?>"
                           <?= $i == $currentPage ? 'aria-current="page"' : '' ?>>
                            <?= $i ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endfor; ?>

            <!-- Last Page -->
            <?php if ($endPage < $totalPages): ?>
                <?php if ($endPage < $totalPages - 1): ?>
                    <li class="page-item disabled">
                        <span class="page-link page-ellipsis">...</span>
                    </li>
                <?php endif; ?>
                <li class="page-item">
                    <?php if ($useAjax): ?>
                        <button class="page-link" onclick="<?= $ajaxCallback ?>(<?= $totalPages ?>, <?= $perPage ?>)"><?= $totalPages ?></button>
                    <?php else: ?>
                        <a class="page-link" href="<?= $baseUrl . '?' . buildQuery($filters, $totalPages, $perPage) ?>"><?= $totalPages ?></a>
                    <?php endif; ?>
                </li>
            <?php endif; ?>

            <!-- Next Button -->
            <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                <?php if ($useAjax): ?>
                    <button class="page-link page-nav" 
                            <?= $currentPage < $totalPages ? "onclick=\"{$ajaxCallback}(" . ($currentPage + 1) . ", {$perPage})\"" : 'disabled' ?>
                            aria-label="Next page">
                        <span class="d-none d-sm-inline me-1">Next</span>
                        <i class="bi bi-chevron-right"></i>
                    </button>
                <?php else: ?>
                    <a class="page-link page-nav" 
                       href="<?= $currentPage < $totalPages ? $baseUrl . '?' . buildQuery($filters, $currentPage + 1, $perPage) : '#' ?>"
                       aria-label="Next page">
                        <span class="d-none d-sm-inline me-1">Next</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<!-- Pagination Styles -->
<style>
.pagination-wrapper {
    margin: 1.5rem 0;
}

.pagination-info {
    font-size: 0.875rem;
    color: #6c757d;
}

.page-size-selector .form-select {
    min-width: 70px;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.pagination-modern {
    --bs-pagination-padding-x: 0.75rem;
    --bs-pagination-padding-y: 0.5rem;
    --bs-pagination-font-size: 0.875rem;
    --bs-pagination-color: #6c757d;
    --bs-pagination-bg: #fff;
    --bs-pagination-border-width: 1px;
    --bs-pagination-border-color: #dee2e6;
    --bs-pagination-border-radius: 0.375rem;
    --bs-pagination-hover-color: #0056b3;
    --bs-pagination-hover-bg: #f8f9fa;
    --bs-pagination-hover-border-color: #dee2e6;
    --bs-pagination-focus-color: #0056b3;
    --bs-pagination-focus-bg: #f8f9fa;
    --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgb(13, 110, 253);
    --bs-pagination-active-color: #fff;
    --bs-pagination-active-bg: #007bff;
    --bs-pagination-active-border-color: #007bff;
    --bs-pagination-disabled-color: #adb5bd;
    --bs-pagination-disabled-bg: #fff;
    --bs-pagination-disabled-border-color: #dee2e6;
    gap: 0.25rem;
}

.pagination-modern .page-link {
    border-radius: 0.375rem;
    border: 1px solid var(--bs-pagination-border-color);
    color: var(--bs-pagination-color);
    background-color: var(--bs-pagination-bg);
    padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x);
    font-size: var(--bs-pagination-font-size);
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 2.5rem;
    height: 2.5rem;
}



.pagination-modern .page-link:focus {
    color: var(--bs-pagination-focus-color);
    background-color: var(--bs-pagination-focus-bg);
    box-shadow: var(--bs-pagination-focus-box-shadow);
}

.pagination-modern .page-item.active .page-link {
    color: var(--bs-pagination-active-color);
    background-color: var(--bs-pagination-active-bg);
    border-color: var(--bs-pagination-active-border-color);
    box-shadow: 0 2px 4px rgb(0, 123, 255);
    font-weight: 600;
}

.pagination-modern .page-item.disabled .page-link {
    color: var(--bs-pagination-disabled-color);
    background-color: var(--bs-pagination-disabled-bg);
    border-color: var(--bs-pagination-disabled-border-color);
    cursor: not-allowed;
    opacity: 1;
}

.pagination-modern .page-nav {
    padding: var(--bs-pagination-padding-y) 1rem;
    font-weight: 500;
}

.pagination-modern .page-ellipsis {
    ;
    border: none;
    color: var(--bs-pagination-disabled-color);
    cursor: default;
}

/* Minimal numeric pagination style */
.pagination-modern { gap: 0.75rem; }
.pagination-modern .page-link {
    border: none;
    ;
    color: #9ca3af; /* gray-400 */
    padding: 0 0.25rem;
    min-width: auto;
    height: auto;
    box-shadow: none;
}

.pagination-modern .page-item.active .page-link {
    color: #111827; /* gray-900 */
    font-weight: 700;
    text-decoration: underline;
    text-underline-offset: 3px;
    ;
    border: none;
    box-shadow: none;
}
.pagination-modern .page-item.disabled .page-link {
    color: #d1d5db; /* gray-300 */
    ;
    border: none;
    opacity: 1;
}
.pagination-modern .page-ellipsis {
    ;
    border: none;
    color: #9ca3af;
    cursor: default;
}
/* Hide text labels, show chevrons via pseudo elements */
.pagination-modern .page-nav .d-none.d-sm-inline { display: none !important; }
.pagination-modern .page-nav .bi { display: none; }
.pagination-modern li:first-child .page-link::before { content: "\00AB"; /* « */ color: #9ca3af; }
.pagination-modern li:last-child .page-link::after { content: "\00BB"; /* » */ color: #9ca3af; }
/* Hide previous at first page */
.pagination-modern li:first-child.disabled { display: none; }

/* Mobile Responsive */
@media (max-width: 576px) {
    .pagination-wrapper .d-flex {
        flex-direction: column;
        align-items: stretch !important;
        gap: 1rem;
    }
    
    .pagination-info {
        text-align: center;
    }
    
    .page-size-selector {
        align-self: center;
    }
    
    .pagination-modern {
        --bs-pagination-padding-x: 0.5rem;
        --bs-pagination-padding-y: 0.375rem;
        --bs-pagination-font-size: 0.8rem;
        gap: 0.125rem;
    }
    
    .pagination-modern .page-link {
        min-width: 2rem;
        height: 2rem;
    }
    
    .pagination-modern .page-nav {
        padding: var(--bs-pagination-padding-y) 0.75rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .pagination-modern {
        --bs-pagination-color: #adb5bd;
        --bs-pagination-bg: #212529;
        --bs-pagination-border-color: #495057;
        --bs-pagination-hover-color: #fff;
        --bs-pagination-hover-bg: #495057;
        --bs-pagination-hover-border-color: #6c757d;
        --bs-pagination-focus-color: #fff;
        --bs-pagination-focus-bg: #495057;
        --bs-pagination-active-color: #fff;
        --bs-pagination-active-bg: #0d6efd;
        --bs-pagination-active-border-color: #0d6efd;
        --bs-pagination-disabled-color: #6c757d;
        --bs-pagination-disabled-bg: #212529;
        --bs-pagination-disabled-border-color: #495057;
    }
}

/* Loading state */
.pagination-loading {
    opacity: 1;
    pointer-events: none;
}

.pagination-loading .page-link {
    cursor: wait;
}

/* Accessibility improvements */
.pagination-modern .page-link:focus-visible {
    outline: 2px solid #0d6efd;
    outline-offset: 2px;
}

.pagination-modern .page-item.active .page-link {
    position: relative;
}

.pagination-modern .page-item.active .page-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 2px;
    background-color: currentColor;
    border-radius: 1px;
}
</style>

<?php if (!$useAjax): ?>
<script>
function changePage(page, perPage) {
    const url = new URL(window.location);
    url.searchParams.set('page', page);
    if (perPage) {
        url.searchParams.set('per_page', perPage);
    }
    window.location.href = url.toString();
}
</script>
<?php endif; ?>
