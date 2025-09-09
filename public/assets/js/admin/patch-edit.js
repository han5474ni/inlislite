/**
 * INLISLite v3.0 Patch Edit Page
 * CRUD management for patches and versions with DataTables integration
 */

// Global variables
let patchesTable;
let versionsTable;
let currentEditPatchId = null;
let currentEditVersionId = null;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

/**
 * Initialize the application
 */
function initializeApp() {
    initializeDataTables();
    initializeEventListeners();
    // loadStatistics(); // disabled because stats cards are removed
    loadPatches();
    loadVersions();
}

/**
 * Initialize DataTables
 */
function initializeDataTables() {
    try {
        // Ensure jQuery and DataTables are available to avoid breaking the page
        if (!window.jQuery) {
            console.warn('jQuery is not loaded; skipping DataTables initialization');
            return;
        }
        if (!$.fn || !$.fn.DataTable) {
            console.warn('DataTables plugin not available; skipping tables initialization');
            return;
        }

        // Initialize patches table
        patchesTable = $('#patchesTable').DataTable({
            responsive: {
                details: { type: 'inline', display: $.fn.dataTable.Responsive.display.childRowImmediate }
            },
            pageLength: 10,
            order: [[5, 'desc']], // Sort by release date (now column index 5)
            columnDefs: [
                // Disable sorting/searching where not needed
                { orderable: false, targets: [4,6] },
                { searchable: false, targets: [4,6] },
                // Responsive priorities (1 = keep visible)
                { responsivePriority: 1, targets: 6 }, // actions
                { responsivePriority: 2, targets: 2 }, // title
                { responsivePriority: 3, targets: 5 }, // release date
                { responsivePriority: 4, targets: 4 }, // file
                { responsivePriority: 5, targets: 3 }, // category
                { responsivePriority: 6, targets: 1 }, // version
                { responsivePriority: 7, targets: 0 }, // id
                // No hard widths; allow flexible layout. Keep some nowrap classes on compact cols
                { className: 'text-nowrap', targets: [0,1,5,6] }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            drawCallback: function() {
                initializeTooltips();
            },
            createdRow: function(row) {
                const fileCell = $('td', row).eq(3);
                fileCell.addClass('text-center');
            }
        });

        // Initialize versions table
        versionsTable = $('#versionsTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[4, 'desc']], // Sort by release date
            columnDefs: [
                { orderable: false, targets: [3,5] }, // Disable sorting for file and actions
                { searchable: false, targets: [3,5] }, // Disable search for file and actions
                { width: "60px", targets: [0] }, // ID column width
                { width: "100px", targets: [1] }, // Version column width
                { width: "140px", targets: [3] }, // File column width
                { width: "120px", targets: [4] }, // Release date column width
                { width: "120px", targets: [5] } // Actions column width
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            drawCallback: function() {
                initializeTooltips();
            }
        });
    } catch (error) {
        console.error('Error initializing DataTables:', error);
        // Do not rethrow; allow the rest of the page (buttons, forms) to keep working
    }
}

/**
 * Initialize event listeners
 */
function initializeEventListeners() {
    // Form submissions
    document.getElementById('addPatchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        savePatch();
    });

    // Toggle Add Patch Card
    const openAddCardBtn = document.getElementById('openAddCardBtn');
    const addPatchCard = document.getElementById('addPatchCard');
    const tablePanel = document.getElementById('tablePanel');
    const closeAddCardBtn = document.getElementById('closeAddCardBtn');
    const cancelAddCardBtn = document.getElementById('cancelAddCardBtn');

    if (openAddCardBtn) {
        openAddCardBtn.addEventListener('click', function() {
            addPatchCard.classList.remove('d-none');
            tablePanel.classList.add('d-none');
        });
    }
    if (closeAddCardBtn) {
        closeAddCardBtn.addEventListener('click', function() {
            addPatchCard.classList.add('d-none');
            tablePanel.classList.remove('d-none');
        });
    }
    if (cancelAddCardBtn) {
        cancelAddCardBtn.addEventListener('click', function() {
            addPatchCard.classList.add('d-none');
            tablePanel.classList.remove('d-none');
        });
    }

    // Submit add card form
    const addPatchCardForm = document.getElementById('addPatchCardForm');
    if (addPatchCardForm) {
        addPatchCardForm.addEventListener('submit', function(e) {
            e.preventDefault();
            savePatchFromCard();
        });
    }
    
    document.getElementById('editPatchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updatePatch();
    });

    document.getElementById('addVersionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveVersion();
    });
    
    document.getElementById('editVersionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updateVersion();
    });
    
    // Modal events
    document.getElementById('addPatchModal').addEventListener('hidden.bs.modal', function() {
        resetAddPatchForm();
    });
    
    document.getElementById('editPatchModal').addEventListener('hidden.bs.modal', function() {
        resetEditPatchForm();
    });

    document.getElementById('addVersionModal').addEventListener('hidden.bs.modal', function() {
        resetAddVersionForm();
    });
    
    document.getElementById('editVersionModal').addEventListener('hidden.bs.modal', function() {
        resetEditVersionForm();
    });

    // Toggle Add Version Card
    const openAddVersionCardBtn = document.getElementById('openAddVersionCardBtn');
    const addVersionCard = document.getElementById('addVersionCard');
    const closeAddVersionCardBtn = document.getElementById('closeAddVersionCardBtn');
    const cancelAddVersionCardBtn = document.getElementById('cancelAddVersionCardBtn');

    if (openAddVersionCardBtn) {
        openAddVersionCardBtn.addEventListener('click', function() {
            addVersionCard.classList.remove('d-none');
            document.getElementById('tablePanel').classList.add('d-none');
        });
    }
    if (closeAddVersionCardBtn) {
        closeAddVersionCardBtn.addEventListener('click', function() {
            addVersionCard.classList.add('d-none');
            document.getElementById('tablePanel').classList.remove('d-none');
        });
    }
    if (cancelAddVersionCardBtn) {
        cancelAddVersionCardBtn.addEventListener('click', function() {
            addVersionCard.classList.add('d-none');
            document.getElementById('tablePanel').classList.remove('d-none');
        });
    }

    const addVersionCardForm = document.getElementById('addVersionCardForm');
    if (addVersionCardForm) {
        addVersionCardForm.addEventListener('submit', function(e) {
            e.preventDefault();
            saveVersionFromCard();
        });
    }

    // Tab change events (guarded if tabs exist)
    const versionsTabEl = document.getElementById('versions-tab');
    if (versionsTabEl) {
        versionsTabEl.addEventListener('shown.bs.tab', function() {
            versionsTable.columns.adjust().draw();
        });
    }
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Utility: detect image vs PDF by extension
function isImageFile(url) {
    const lower = (url || '').toLowerCase();
    return lower.endsWith('.png') || lower.endsWith('.jpg') || lower.endsWith('.jpeg') || lower.endsWith('.gif') || lower.endsWith('.webp');
}

/**
 * Load statistics
 */
async function loadStatistics() {
    try {
        // Sample statistics - replace with actual API call
        const stats = {
            total_patches: 12,
            active_patches: 8,
            critical_patches: 2,
            pending_patches: 3
        };
        
        updateStatistics(stats);
        
    } catch (error) {
        // console.error('Error loading statistics:', error);
        // showError('Gagal memuat statistik');
    }
}

/**
 * Update statistics display
 */
function updateStatistics(stats) {
    if (document.getElementById('totalPatches')) document.getElementById('totalPatches').textContent = stats.total_patches || 0;
    if (document.getElementById('activePatches')) document.getElementById('activePatches').textContent = stats.active_patches || 0;
    if (document.getElementById('criticalPatches')) document.getElementById('criticalPatches').textContent = stats.critical_patches || 0;
    if (document.getElementById('pendingPatches')) document.getElementById('pendingPatches').textContent = stats.pending_patches || 0;
}

/**
 * Load patches data
 */
async function loadPatches() {
    try {
        showLoading();
        
        // Sample data - replace with actual API call
        const samplePatches = [
            {
                id: 1,
                version: "v3.0.1",
                title: "Security Update",
                description: "Perbaikan keamanan sistem login dan validasi input",
                category: "security",
                priority: "critical",
                status: "released",
                release_date: "2024-01-15",
                file_url: "https://example.com/patch-v3.0.1.zip",
                changelog: "- Perbaikan vulnerability XSS\n- Update validasi input\n- Peningkatan enkripsi password"
            },
            {
                id: 2,
                version: "v3.0.2",
                title: "Bug Fixes",
                description: "Perbaikan bug pada modul katalogisasi dan sirkulasi",
                category: "bugfix",
                priority: "high",
                status: "testing",
                release_date: "2024-01-20",
                file_url: null,
                changelog: "- Fix bug pencarian katalog\n- Perbaikan proses peminjaman\n- Update laporan sirkulasi"
            },
            {
                id: 3,
                version: "v3.1.0",
                title: "New Features",
                description: "Penambahan fitur notifikasi dan dashboard analytics",
                category: "feature",
                priority: "medium",
                status: "draft",
                release_date: "2024-02-01",
                file_url: null,
                changelog: "- Sistem notifikasi real-time\n- Dashboard analytics\n- Export data ke Excel"
            }
        ];
        
        populatePatchesTable(samplePatches);
        
    } catch (error) {
        console.error('Error loading patches:', error);
        showError('Gagal memuat data patch');
    } finally {
        hideLoading();
    }
}

/**
 * Load versions data
 */
async function loadVersions() {
    try {
        // Sample data - replace with actual API call
        const sampleVersions = [
            {
                id: 1,
                version: "3.0.0",
                name: "Initial Release",
                file_url: null,
                release_date: "2024-01-01"
            },
            {
                id: 2,
                version: "3.0.1",
                name: "Security Update",
                file_url: "https://example.com/release-3.0.1.pdf",
                release_date: "2024-01-15"
            },
            {
                id: 3,
                version: "3.1.0",
                name: "Feature Update",
                file_url: null,
                release_date: "2024-02-01"
            }
        ];
        
        populateVersionsTable(sampleVersions);
        
    } catch (error) {
        console.error('Error loading versions:', error);
        showError('Gagal memuat data versi');
    }
}

/**
 * Populate patches DataTable
 */
function populatePatchesTable(patches) {
    patchesTable.clear();
    
    patches.forEach(patch => {
        const row = [
            patch.id,
            `<span class="version-badge">${patch.version}</span>`,
            `<div>
                <div class="fw-semibold">${patch.title}</div>
                <small class="text-muted">${patch.description || ''}</small>
            </div>`,
            `<span class="badge bg-light text-dark">${(patch.type || patch.category_type || 'patch').toLowerCase() === 'updater' ? 'Updater' : 'Patch'}</span>`,
            patch.file_url
                ? (isImageFile(patch.file_url)
                    ? `<a href="${patch.file_url}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="bi bi-image"></i> ${patch.file_label ? escapeHtml(patch.file_label) : 'Lihat'}</a>`
                    : `<a href="${patch.file_url}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="bi bi-file-earmark-pdf"></i> ${patch.file_label ? escapeHtml(patch.file_label) : 'Buka'}</a>`)
                : '<span class="text-muted">-</span>',
            formatDate(patch.release_date),
            `<div class="d-flex justify-content-center">
                <button class="btn-action edit" onclick="editPatch(${patch.id})" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-action delete" onclick="deletePatch(${patch.id})" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>`
        ];
        
        patchesTable.row.add(row);
    });
    
    patchesTable.draw();
}

/**
 * Populate versions DataTable
 */
function populateVersionsTable(versions) {
    versionsTable.clear();
    
    versions.forEach(version => {
        const row = [
            version.id,
            `<span class="version-badge">${version.version}</span>`,
            version.name || '-',
            version.file_url
                ? (isImageFile(version.file_url)
                    ? `<a href="${version.file_url}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="bi bi-image"></i> ${version.file_label ? escapeHtml(version.file_label) : 'Lihat'}</a>`
                    : `<a href="${version.file_url}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="bi bi-file-earmark-pdf"></i> ${version.file_label ? escapeHtml(version.file_label) : 'Buka'}</a>`)
                : '<span class="text-muted">-</span>',
            formatDate(version.release_date),
            `<div class="d-flex justify-content-center">
                <button class="btn-action edit" onclick="editVersion(${version.id})" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-action delete" onclick="deleteVersion(${version.id})" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>`
        ];
        
        versionsTable.row.add(row);
    });
    
    versionsTable.draw();
}

/**
 * Get category label
 */
function getCategoryLabel(category) {
    const labels = {
        'bugfix': 'Bug Fix',
        'feature': 'New Feature',
        'security': 'Security Update',
        'performance': 'Performance',
        'maintenance': 'Maintenance'
    };
    return labels[category] || category;
}

/**
 * Get priority label
 */
function getPriorityLabel(priority) {
    const labels = {
        'low': 'Rendah',
        'medium': 'Sedang',
        'high': 'Tinggi',
        'critical': 'Kritis'
    };
    return labels[priority] || priority;
}

/**
 * Get status label
 */
function getStatusLabel(status) {
    const labels = {
        'draft': 'Draft',
        'testing': 'Testing',
        'released': 'Released',
        'archived': 'Archived'
    };
    return labels[status] || status;
}

/**
 * Get version status label
 */
function getVersionStatusLabel(status) {
    const labels = {
        'development': 'Development',
        'beta': 'Beta',
        'stable': 'Stable',
        'deprecated': 'Deprecated'
    };
    return labels[status] || status;
}

/**
 * Format date
 */
function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Escape HTML for safe insertion into DOM
function escapeHtml(str) {
    if (str == null) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

/**
 * Save new patch
 */
async function savePatch() {
    try {
        showLoading();
        const fileInput = document.getElementById('patchFile');
        let fileUrl = document.getElementById('patchFileUrl') ? document.getElementById('patchFileUrl').value : '';
        if (!fileUrl && fileInput && fileInput.files && fileInput.files[0]) {
            const fd = new FormData();
            fd.append('file', fileInput.files[0]);
            const res = await fetch(baseUrl + '/patches/upload', { method: 'POST', body: fd });
            const data = await res.json();
            if (!data.success) throw new Error(data.message || 'Upload gagal');
            fileUrl = data.url;
        } else if (!fileUrl && document.getElementById('patchFileUrl')) {
            fileUrl = document.getElementById('patchFileUrl').value || '';
        }

        const formData = {
            version: document.getElementById('patchVersion').value,
            title: document.getElementById('patchTitle').value,
            description: document.getElementById('patchDescription').value,
            changelog: document.getElementById('patchChangelog').value,
            release_date: document.getElementById('patchReleaseDate').value,
            file_url: fileUrl,
            file_label: (document.getElementById('patchFileLabel') ? document.getElementById('patchFileLabel').value : '')
        };
        
        if (!formData.version || !formData.title || !formData.description) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        console.log('Saving patch:', formData);
        const modal = bootstrap.Modal.getInstance(document.getElementById('addPatchModal'));
        if (modal) modal.hide();
        
        showSuccess('Patch berhasil ditambahkan');
        loadPatches();
    } catch (error) {
        console.error('Error saving patch:', error);
        showError('Gagal menyimpan patch');
    } finally {
        hideLoading();
    }
}

// Save from Add Card form
async function savePatchFromCard() {
    try {
        showLoading();
        const fileInput = document.getElementById('cardPatchFile');
        let fileUrl = '';
        if (fileInput && fileInput.files && fileInput.files[0]) {
            const fd = new FormData();
            fd.append('file', fileInput.files[0]);
            const res = await fetch(baseUrl + '/patches/upload', { method: 'POST', body: fd });
            const data = await res.json();
            if (!data.success) throw new Error(data.message || 'Upload gagal');
            fileUrl = data.url;
        } else if (document.getElementById('cardPatchFileUrl')) {
            fileUrl = document.getElementById('cardPatchFileUrl').value || '';
        }

        const formData = {
            version: document.getElementById('cardPatchVersion').value,
            title: document.getElementById('cardPatchTitle').value,
            description: document.getElementById('cardPatchDescription').value,
            release_date: document.getElementById('cardPatchReleaseDate').value,
            file_url: fileUrl,
            file_label: (document.getElementById('cardPatchFileLabel') ? document.getElementById('cardPatchFileLabel').value : ''),
            changelog: document.getElementById('cardPatchChangelog').value
        };

        if (!formData.version || !formData.title || !formData.description) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }

        console.log('Saving patch (card):', formData);
        // TODO: POST to your create API if available, else just refresh
        // await fetch(baseUrl + '/patches/store-json', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(formData) });

        // After save, go back to table and refresh
        document.getElementById('addPatchCard').classList.add('d-none');
        document.getElementById('tablePanel').classList.remove('d-none');
        showSuccess('Patch berhasil ditambahkan');
        loadPatches();
    } catch (err) {
        console.error(err);
        showError('Gagal menyimpan patch');
    } finally {
        hideLoading();
    }
}

/**
 * Edit patch
 */
function editPatch(id) {
    // Sample data - replace with actual API call
    const samplePatches = [
        {
            id: 1,
            version: "v3.0.1",
            title: "Security Update",
            description: "Perbaikan keamanan sistem login dan validasi input",
            category: "security",
            priority: "critical",
            status: "released",
            release_date: "2024-01-15",
            file_url: "https://example.com/patch-v3.0.1.zip",
            changelog: "- Perbaikan vulnerability XSS\n- Update validasi input\n- Peningkatan enkripsi password"
        },
        {
            id: 2,
            version: "v3.0.2",
            title: "Bug Fixes",
            description: "Perbaikan bug pada modul katalogisasi dan sirkulasi",
            category: "bugfix",
            priority: "high",
            status: "testing",
            release_date: "2024-01-20",
            file_url: null,
            changelog: "- Fix bug pencarian katalog\n- Perbaikan proses peminjaman\n- Update laporan sirkulasi"
        },
        {
            id: 3,
            version: "v3.1.0",
            title: "New Features",
            description: "Penambahan fitur notifikasi dan dashboard analytics",
            category: "feature",
            priority: "medium",
            status: "draft",
            release_date: "2024-02-01",
            file_url: null,
            changelog: "- Sistem notifikasi real-time\n- Dashboard analytics\n- Export data ke Excel"
        }
    ];
    
    const patch = samplePatches.find(p => p.id === id);
    
    if (!patch) {
        showError('Patch tidak ditemukan');
        return;
    }
    
    // Populate edit form
    currentEditPatchId = id;
    document.getElementById('editPatchId').value = id;
    document.getElementById('editPatchVersion').value = patch.version;
    document.getElementById('editPatchTitle').value = patch.title;
    document.getElementById('editPatchDescription').value = patch.description;
    document.getElementById('editPatchChangelog').value = patch.changelog || '';
    document.getElementById('editPatchReleaseDate').value = patch.release_date;
    document.getElementById('editPatchFileUrl').value = patch.file_url || '';
    if (document.getElementById('editPatchFileLabel')) document.getElementById('editPatchFileLabel').value = patch.file_label || '';
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editPatchModal'));
    modal.show();
}

/**
 * Update patch
 */
async function updatePatch() {
    try {
        const formData = {
            id: currentEditPatchId,
            version: document.getElementById('editPatchVersion').value,
            title: document.getElementById('editPatchTitle').value,
            description: document.getElementById('editPatchDescription').value,
            changelog: document.getElementById('editPatchChangelog').value,
            release_date: document.getElementById('editPatchReleaseDate').value,
            file_url: document.getElementById('editPatchFileUrl').value,
            file_label: (document.getElementById('editPatchFileLabel') ? document.getElementById('editPatchFileLabel').value : '')
        };
        
        // Validate required fields
        if (!formData.version || !formData.title || !formData.description) {
            showError('Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Updating patch:', formData);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Close modal and refresh data
        const modal = bootstrap.Modal.getInstance(document.getElementById('editPatchModal'));
        modal.hide();
        
        showSuccess('Patch berhasil diperbarui');
        loadPatches();
        loadStatistics();
        
    } catch (error) {
        console.error('Error updating patch:', error);
        showError('Gagal memperbarui patch');
    } finally {
        hideLoading();
    }
}

/**
 * Delete patch
 */
async function deletePatch(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus patch ini?')) {
        return;
    }
    
    try {
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Deleting patch:', id);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        showSuccess('Patch berhasil dihapus');
        loadPatches();
        loadStatistics();
        
    } catch (error) {
        console.error('Error deleting patch:', error);
        showError('Gagal menghapus patch');
    } finally {
        hideLoading();
    }
}

/**
 * Download patch
 */
function downloadPatch(url) {
    if (url) {
        window.open(url, '_blank');
    } else {
        showError('URL file tidak tersedia');
    }
}

/**
 * Save new version
 */
async function saveVersion() {
    try {
        const formData = {
            version: document.getElementById('versionNumber').value,
            name: document.getElementById('versionName').value,
            status: document.getElementById('versionStatus').value,
            release_date: document.getElementById('versionReleaseDate').value
        };
        
        // Validate required fields
        if (!formData.version) {
            showError('Nomor versi wajib diisi');
            return;
        }
        
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Saving version:', formData);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Close modal and refresh data
        const modal = bootstrap.Modal.getInstance(document.getElementById('addVersionModal'));
        modal.hide();
        
        showSuccess('Versi berhasil ditambahkan');
        loadVersions();
        
    } catch (error) {
        console.error('Error saving version:', error);
        showError('Gagal menyimpan versi');
    } finally {
        hideLoading();
    }
}

/**
 * Edit version
 */
function editVersion(id) {
    // Sample data - replace with actual API call
    const sampleVersions = [
        {
            id: 1,
            version: "3.0.0",
            name: "Initial Release",
            status: "stable",
            release_date: "2024-01-01"
        },
        {
            id: 2,
            version: "3.0.1",
            name: "Security Update",
            status: "stable",
            release_date: "2024-01-15"
        },
        {
            id: 3,
            version: "3.1.0",
            name: "Feature Update",
            status: "development",
            release_date: "2024-02-01"
        }
    ];
    
    const version = sampleVersions.find(v => v.id === id);
    
    if (!version) {
        showError('Versi tidak ditemukan');
        return;
    }
    
    // Populate edit form
    currentEditVersionId = id;
    document.getElementById('editVersionId').value = id;
    document.getElementById('editVersionNumber').value = version.version;
    document.getElementById('editVersionName').value = version.name || '';
    document.getElementById('editVersionStatus').value = version.status;
    document.getElementById('editVersionReleaseDate').value = version.release_date;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editVersionModal'));
    modal.show();
}

/**
 * Update version
 */
async function updateVersion() {
    try {
        const formData = {
            id: currentEditVersionId,
            version: document.getElementById('editVersionNumber').value,
            name: document.getElementById('editVersionName').value,
            status: document.getElementById('editVersionStatus').value,
            release_date: document.getElementById('editVersionReleaseDate').value
        };
        
        // Validate required fields
        if (!formData.version) {
            showError('Nomor versi wajib diisi');
            return;
        }
        
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Updating version:', formData);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Close modal and refresh data
        const modal = bootstrap.Modal.getInstance(document.getElementById('editVersionModal'));
        modal.hide();
        
        showSuccess('Versi berhasil diperbarui');
        loadVersions();
        
    } catch (error) {
        console.error('Error updating version:', error);
        showError('Gagal memperbarui versi');
    } finally {
        hideLoading();
    }
}

/**
 * Delete version
 */
async function deleteVersion(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus versi ini?')) {
        return;
    }
    
    try {
        showLoading();
        
        // TODO: Replace with actual API call
        console.log('Deleting version:', id);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        showSuccess('Versi berhasil dihapus');
        loadVersions();
        
    } catch (error) {
        console.error('Error deleting version:', error);
        showError('Gagal menghapus versi');
    } finally {
        hideLoading();
    }
}

/**
 * Reset add patch form
 */
function resetAddPatchForm() {
    document.getElementById('addPatchForm').reset();
}

/**
 * Reset edit patch form
 */
function resetEditPatchForm() {
    document.getElementById('editPatchForm').reset();
    currentEditPatchId = null;
}

/**
 * Reset add version form
 */
function resetAddVersionForm() {
    document.getElementById('addVersionForm').reset();
    document.getElementById('versionStatus').value = 'development';
}

/**
 * Reset edit version form
 */
function resetEditVersionForm() {
    document.getElementById('editVersionForm').reset();
    currentEditVersionId = null;
}

/**
 * Show loading spinner
 */
function showLoading() {
    const spinner = document.getElementById('loadingSpinner');
    if (spinner) {
        spinner.style.display = 'flex';
    }
}

/**
 * Hide loading spinner
 */
function hideLoading() {
    const spinner = document.getElementById('loadingSpinner');
    if (spinner) {
        spinner.style.display = 'none';
    }
}

/**
 * Show success message
 */
function showSuccess(message) {
    showToast(message, 'success');
}

/**
 * Show error message
 */
function showError(message) {
    showToast(message, 'error');
}

/**
 * Show toast notification
 */
function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <i class="bi bi-x"></i>
        </button>
    `;
    
    // Add styles if not already added
    if (!document.querySelector('#toast-styles')) {
        const style = document.createElement('style');
        style.id = 'toast-styles';
        style.textContent = `
            .toast-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
                background: white;
                border-radius: 8px;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                padding: 1rem;
                display: flex;
                align-items: center;
                gap: 1rem;
                min-width: 300px;
                animation: slideInRight 0.3s ease-out;
                border-left: 4px solid #6b7280;
            }
            .toast-success { border-left-color: #059669; }
            .toast-error { border-left-color: #dc2626; }
            .toast-content {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                flex: 1;
            }
            .toast-close {
                background: none;
                border: none;
                color: #6b7280;
                cursor: pointer;
                padding: 0.25rem;
                border-radius: 4px;
            }
            .toast-close:hover {
                background-color: #f3f4f6;
            }
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Add to DOM
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.animation = 'slideInRight 0.3s ease-out reverse';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
}

// Export functions for global access
window.savePatch = savePatch;
window.editPatch = editPatch;
window.updatePatch = updatePatch;
window.deletePatch = deletePatch;
window.downloadPatch = downloadPatch;
window.saveVersion = saveVersion;
window.editVersion = editVersion;
window.updateVersion = updateVersion;
window.deleteVersion = deleteVersion;