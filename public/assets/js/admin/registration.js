/**
 * Registration Management JavaScript - INLISlite v3.0
 * Modern, responsive registration management with Bootstrap 5
 */

// Global variables
let registrations = [];
let filteredRegistrations = [];

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Registration Management System Initializing...');
    
    // Setup event listeners
    setupEventListeners();
    
    // Load initial data
    loadInitialData();
    
    console.log('✅ Registration Management System Ready');
});

/**
 * Setup all event listeners
 */
function setupEventListeners() {
    console.log('📡 Setting up event listeners...');
    
    // Search and filters
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const typeFilter = document.getElementById('typeFilter');
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce(filterRegistrations, 300));
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', filterRegistrations);
    }
    if (typeFilter) {
        typeFilter.addEventListener('change', filterRegistrations);
    }

    // Download button
    const downloadBtn = document.getElementById('downloadBtn');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', downloadData);
    }

    // Table sorting
    const sortableHeaders = document.querySelectorAll('.sortable');
    sortableHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const sortBy = this.dataset.sort;
            sortTable(sortBy);
        });
    });

    // Modal events
    const addRegistrationModal = document.getElementById('addRegistrationModal');
    if (addRegistrationModal) {
        addRegistrationModal.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('addRegistrationForm');
            if (form) {
                form.reset();
                clearFormErrors();
            }
        });
    }

    // Form submission
    const addRegistrationForm = document.getElementById('addRegistrationForm');
    if (addRegistrationForm) {
        addRegistrationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitAddRegistration();
        });
    }

    // Action buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.dropdown-item')) {
            const action = e.target.textContent.trim();
            const row = e.target.closest('tr');
            const libraryName = row.querySelector('.library-info h6').textContent;
            
            if (action === 'View') {
                viewRegistration(libraryName);
            } else if (action === 'Edit') {
                editRegistration(libraryName);
            } else if (action === 'Delete') {
                deleteRegistration(libraryName);
            }
        }
    });
}

/**
 * Load initial sample data
 */
function loadInitialData() {
    console.log('📊 Loading initial data...');
    
    // Sample registration data
    registrations = [
        {
            id: 1,
            library_name: 'Jakarta Public Library',
            library_type: 'Public',
            status: 'Active',
            location: 'DKI Jakarta',
            email: 'info@jakartapubliclibrary.id',
            registration_date: '2024-01-15',
            last_update: '2024-01-02'
        },
        {
            id: 2,
            library_name: 'University of Indonesia Library',
            library_type: 'Academic',
            status: 'Active',
            location: 'Jawa Barat',
            email: 'library@ui.ac.id',
            registration_date: '2024-01-12',
            last_update: '2024-01-01'
        },
        {
            id: 3,
            library_name: 'SMA Negeri 1 Bandung Library',
            library_type: 'School',
            status: 'Inactive',
            location: 'Jawa Barat',
            email: 'library@sman1bandung.sch.id',
            registration_date: '2024-01-10',
            last_update: '2023-12-28'
        },
        {
            id: 4,
            library_name: 'National Archives Library',
            library_type: 'Special',
            status: 'Active',
            location: 'DKI Jakarta',
            email: 'library@anri.go.id',
            registration_date: '2024-01-08',
            last_update: '2023-12-30'
        },
        {
            id: 5,
            library_name: 'Surabaya City Library',
            library_type: 'Public',
            status: 'Active',
            location: 'Jawa Timur',
            email: 'info@surabayalibrary.id',
            registration_date: '2024-01-05',
            last_update: '2023-12-25'
        },
        {
            id: 6,
            library_name: 'Gadjah Mada University Library',
            library_type: 'Academic',
            status: 'Inactive',
            location: 'DI Yogyakarta',
            email: 'library@ugm.ac.id',
            registration_date: '2024-01-03',
            last_update: '2023-12-20'
        },
        {
            id: 7,
            library_name: 'SMAN 3 Jakarta Library',
            library_type: 'School',
            status: 'Active',
            location: 'DKI Jakarta',
            email: 'library@sman3jakarta.sch.id',
            registration_date: '2024-01-01',
            last_update: '2023-12-15'
        },
        {
            id: 8,
            library_name: 'Medan Public Library',
            library_type: 'Public',
            status: 'Inactive',
            location: 'Sumatera Utara',
            email: 'info@medanlibrary.id',
            registration_date: '2023-12-28',
            last_update: '2023-12-10'
        }
    ];
    
    filteredRegistrations = [...registrations];
    renderRegistrationsTable();
    updateRegistrationCount();
    updateStatistics();
    
    console.log('✅ Initial data loaded');
}

/**
 * Filter registrations based on search and filters
 */
function filterRegistrations() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const typeFilter = document.getElementById('typeFilter');
    
    const search = searchInput ? searchInput.value.toLowerCase() : '';
    const status = statusFilter ? statusFilter.value : '';
    const type = typeFilter ? typeFilter.value : '';

    filteredRegistrations = registrations.filter(registration => {
        const matchesSearch = search === '' || 
            (registration.library_name && registration.library_name.toLowerCase().includes(search)) ||
            (registration.location && registration.location.toLowerCase().includes(search)) ||
            (registration.email && registration.email.toLowerCase().includes(search));
        
        const matchesStatus = status === '' || registration.status === status;
        const matchesType = type === '' || registration.library_type === type;

        return matchesSearch && matchesStatus && matchesType;
    });

    renderRegistrationsTable();
    updateRegistrationCount();
    
    console.log(`🔍 Filtered registrations: ${filteredRegistrations.length}/${registrations.length}`);
}

/**
 * Sort table by column
 */
function sortTable(sortBy) {
    const isAscending = !document.querySelector(`[data-sort="${sortBy}"]`).classList.contains('asc');
    
    // Remove all sort classes
    document.querySelectorAll('.sortable').forEach(header => {
        header.classList.remove('asc', 'desc');
        const icon = header.querySelector('i');
        if (icon) {
            icon.className = 'bi bi-arrow-down-up';
        }
    });
    
    // Add sort class to current header
    const currentHeader = document.querySelector(`[data-sort="${sortBy}"]`);
    currentHeader.classList.add(isAscending ? 'asc' : 'desc');
    const icon = currentHeader.querySelector('i');
    if (icon) {
        icon.className = isAscending ? 'bi bi-sort-up' : 'bi bi-sort-down';
    }
    
    // Sort the data
    filteredRegistrations.sort((a, b) => {
        let valueA = a[sortBy];
        let valueB = b[sortBy];
        
        // Handle date sorting
        if (sortBy.includes('date')) {
            valueA = new Date(valueA);
            valueB = new Date(valueB);
        } else {
            valueA = valueA.toString().toLowerCase();
            valueB = valueB.toString().toLowerCase();
        }
        
        if (isAscending) {
            return valueA > valueB ? 1 : -1;
        } else {
            return valueA < valueB ? 1 : -1;
        }
    });
    
    renderRegistrationsTable();
    console.log(`📊 Table sorted by ${sortBy} (${isAscending ? 'ascending' : 'descending'})`);
}

/**
 * Render registrations table
 */
function renderRegistrationsTable() {
    const tbody = document.getElementById('registrationTableBody');
    if (!tbody) {
        console.error('❌ Registration table body not found');
        return;
    }
    
    if (filteredRegistrations.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4">
                    <div class="text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        <p>No registrations found</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = filteredRegistrations.map(registration => `
        <tr class="fade-in" data-library-type="${registration.library_type}" data-status="${registration.status}">
            <td>
                <div class="library-info">
                    <h6>${registration.library_name}</h6>
                    <small>${registration.location}</small>
                </div>
            </td>
            <td>
                <span class="badge badge-type ${getTypeClass(registration.library_type)}">${registration.library_type}</span>
            </td>
            <td>
                <span class="badge badge-status ${getStatusClass(registration.status)}">${registration.status}</span>
            </td>
            <td>${formatDate(registration.registration_date)}</td>
            <td>${formatDate(registration.last_update)}</td>
            <td>
                <div class="dropdown">
                    <button class="action-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-eye me-2"></i>
                                View
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-pencil me-2"></i>
                                Edit
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#">
                                <i class="bi bi-trash me-2"></i>
                                Delete
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    `).join('');
}

/**
 * Submit add registration form
 */
function submitAddRegistration() {
    console.log('📝 Submitting add registration form...');
    
    const form = document.getElementById('addRegistrationForm');
    if (!form) {
        console.error('❌ Add registration form not found');
        return;
    }
    
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Show loading state
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adding...';
    }
    
    clearFormErrors();

    // Simulate form submission
    setTimeout(() => {
        const registrationData = {
            id: registrations.length + 1,
            library_name: formData.get('library_name'),
            library_type: formData.get('library_type'),
            status: formData.get('status'),
            location: formData.get('location'),
            email: formData.get('email'),
            registration_date: new Date().toISOString().split('T')[0],
            last_update: new Date().toISOString().split('T')[0]
        };

        // Add to registrations array
        registrations.push(registrationData);
        
        // Show success message
        showToast('Registration added successfully!', 'success');
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('addRegistrationModal'));
        if (modal) {
            modal.hide();
        }
        
        // Refresh table and statistics
        filterRegistrations();
        updateStatistics();
        
        console.log('✅ Registration added successfully');
        
        // Reset button state
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-plus-lg me-2"></i>Add Registration';
        }
    }, 1000);
}

/**
 * View registration details
 */
function viewRegistration(libraryName) {
    console.log(`👁️ Viewing registration: ${libraryName}`);
    const registration = registrations.find(r => r.library_name === libraryName);
    if (registration) {
        showToast(`Viewing details for: ${registration.library_name}`, 'info');
    }
}

/**
 * Edit registration
 */
function editRegistration(libraryName) {
    console.log(`✏️ Editing registration: ${libraryName}`);
    const registration = registrations.find(r => r.library_name === libraryName);
    if (registration) {
        showToast(`Edit form for: ${registration.library_name}`, 'info');
    }
}

/**
 * Delete registration
 */
function deleteRegistration(libraryName) {
    if (!confirm(`Are you sure you want to delete "${libraryName}"?`)) {
        return;
    }

    console.log(`🗑️ Deleting registration: ${libraryName}`);

    // Remove from registrations array
    registrations = registrations.filter(r => r.library_name !== libraryName);
    
    showToast(`Registration "${libraryName}" deleted successfully!`, 'success');
    
    // Refresh table and statistics
    filterRegistrations();
    updateStatistics();
    
    console.log('✅ Registration deleted successfully');
}

/**
 * Download data as CSV
 */
function downloadData() {
    console.log('📥 Downloading registration data...');
    
    const downloadBtn = document.getElementById('downloadBtn');
    const originalText = downloadBtn.innerHTML;
    
    // Show loading state
    downloadBtn.innerHTML = '<i class="bi bi-download me-2"></i>Downloading...';
    downloadBtn.disabled = true;
    
    // Simulate download process
    setTimeout(() => {
        generateCSVDownload(filteredRegistrations);
        
        // Reset button state
        downloadBtn.innerHTML = originalText;
        downloadBtn.disabled = false;
        
        showToast('Data downloaded successfully!', 'success');
    }, 1000);
}

/**
 * Generate CSV download
 */
function generateCSVDownload(data) {
    // CSV headers
    const headers = [
        'ID',
        'Library Name',
        'Library Type',
        'Status',
        'Location',
        'Email',
        'Registration Date',
        'Last Update'
    ];
    
    // Convert data to CSV format
    let csvContent = headers.join(',') + '\n';
    
    data.forEach(registration => {
        const row = [
            registration.id,
            `"${registration.library_name.replace(/"/g, '""')}"`,
            registration.library_type,
            registration.status,
            `"${registration.location.replace(/"/g, '""')}"`,
            registration.email,
            registration.registration_date,
            registration.last_update
        ];
        csvContent += row.join(',') + '\n';
    });
    
    // Create and trigger download
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', `registration_data_${new Date().toISOString().split('T')[0]}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } else {
        alert('Your browser does not support automatic downloads');
    }
}

/**
 * Update statistics
 */
function updateStatistics() {
    const totalRegistrations = registrations.length;
    const activeLibraries = registrations.filter(r => r.status === 'Active').length;
    const inactiveLibraries = registrations.filter(r => r.status === 'Inactive').length;
    
    // Update statistics cards
    const statNumbers = document.querySelectorAll('.stat-number');
    if (statNumbers.length >= 3) {
        statNumbers[0].textContent = totalRegistrations;
        statNumbers[1].textContent = activeLibraries;
        statNumbers[2].textContent = inactiveLibraries;
    }
    
    console.log(`📊 Statistics updated: Total: ${totalRegistrations}, Active: ${activeLibraries}, Inactive: ${inactiveLibraries}`);
}

/**
 * Utility Functions
 */

// Get type CSS class
function getTypeClass(type) {
    const typeClasses = {
        'Public': 'badge-public',
        'Academic': 'badge-academic',
        'School': 'badge-school',
        'Special': 'badge-special'
    };
    return typeClasses[type] || 'badge-public';
}

// Get status CSS class
function getStatusClass(status) {
    const statusClasses = {
        'Active': 'badge-active',
        'Inactive': 'badge-inactive'
    };
    return statusClasses[status] || 'badge-inactive';
}

// Update registration count
function updateRegistrationCount() {
    const registrationCountElement = document.getElementById('registrationCount');
    if (registrationCountElement) {
        registrationCountElement.textContent = filteredRegistrations.length;
    }
}

// Format date
function formatDate(dateString) {
    if (!dateString) return 'N/A';
    
    const date = new Date(dateString);
    return date.toLocaleDateString('en-GB', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
    });
}

// Clear form errors
function clearFormErrors() {
    document.querySelectorAll('.is-invalid').forEach(element => {
        element.classList.remove('is-invalid');
    });
    document.querySelectorAll('.invalid-feedback').forEach(element => {
        element.remove();
    });
}

// Show toast notification
function showToast(message, type = 'info') {
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toastContainer';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    const toastId = 'toast-' + Date.now();
    const bgClass = type === 'error' ? 'bg-danger' : (type === 'success' ? 'bg-success' : 'bg-info');
    
    const toastElement = document.createElement('div');
    toastElement.id = toastId;
    toastElement.className = `toast align-items-center text-white ${bgClass} border-0`;
    toastElement.setAttribute('role', 'alert');
    toastElement.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    toastContainer.appendChild(toastElement);
    
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    
    // Remove toast from DOM after hiding
    toastElement.addEventListener('hidden.bs.toast', function() {
        toastElement.remove();
    });
    
    console.log(`📢 Toast shown: ${type} - ${message}`);
}

// Debounce function
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

// Export functions for global access
window.RegistrationManagement = {
    filterRegistrations,
    sortTable,
    viewRegistration,
    editRegistration,
    deleteRegistration,
    downloadData,
    showToast
};

console.log('📦 Registration Management JavaScript loaded successfully');