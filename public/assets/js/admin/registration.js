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
    
    // Load data from existing table
    loadDataFromTable();
    
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

    
    // Edit Registration button (for detail page)
    const editRegistrationBtn = document.getElementById('editRegistrationBtn');
    if (editRegistrationBtn) {
        editRegistrationBtn.addEventListener('click', function() {
            navigateToEditRegistration();
        });
    }
}

/**
 * Load data from existing table in the DOM
 */
function loadDataFromTable() {
    console.log('📊 Loading data from existing table...');
    
    const tableBody = document.getElementById('registrationTableBody');
    if (!tableBody) {
        console.error('❌ Registration table body not found');
        return;
    }
    
    const rows = tableBody.querySelectorAll('tr');
    registrations = [];
    
    rows.forEach((row, index) => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 5) {
            const libraryInfo = cells[0].querySelector('.library-info');
            const libraryName = libraryInfo ? libraryInfo.querySelector('h6').textContent.trim() : '';
            const location = libraryInfo ? libraryInfo.querySelector('small').textContent.trim() : '';
            
            const typeSpan = cells[1].querySelector('.badge');
            const statusSpan = cells[2].querySelector('.badge');
            
            const registration = {
                id: index + 1,
                library_name: libraryName,
                library_type: typeSpan ? typeSpan.textContent.trim() : '',
                status: statusSpan ? statusSpan.textContent.trim() : '',
                location: location,
                registration_date: cells[3].textContent.trim(),
                last_update: cells[4].textContent.trim(),
                row_element: row // Store reference to the actual DOM row
            };
            
            registrations.push(registration);
        }
    });
    
    filteredRegistrations = [...registrations];
    updateRegistrationCount();
    
    console.log(`✅ Loaded ${registrations.length} registrations from table`);
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

    const tableBody = document.getElementById('registrationTableBody');
    if (!tableBody) {
        console.error('❌ Table body not found');
        return;
    }

    const rows = tableBody.querySelectorAll('tr');
    let visibleCount = 0;

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length < 5) return; // Skip if not a data row

        // Get row data
        const libraryInfo = cells[0].querySelector('.library-info');
        const libraryName = libraryInfo ? libraryInfo.querySelector('h6').textContent.trim().toLowerCase() : '';
        const location = libraryInfo ? libraryInfo.querySelector('small').textContent.trim().toLowerCase() : '';
        
        const typeSpan = cells[1].querySelector('.badge');
        const statusSpan = cells[2].querySelector('.badge');
        const rowType = typeSpan ? typeSpan.textContent.trim() : '';
        const rowStatus = statusSpan ? statusSpan.textContent.trim() : '';

        // Check filters
        const matchesSearch = search === '' || 
            libraryName.includes(search) ||
            location.includes(search);
        
        const matchesStatus = status === '' || rowStatus === status;
        const matchesType = type === '' || rowType === type;

        // Show/hide row
        if (matchesSearch && matchesStatus && matchesType) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    updateRegistrationCount(visibleCount);
    
    console.log(`🔍 Filtered registrations: ${visibleCount}/${rows.length} visible`);
}

/**
 * Sort table by column
 */
function sortTable(sortBy) {
    console.log(`🔄 Sorting table by: ${sortBy}`);
    
    const tableBody = document.getElementById('registrationTableBody');
    if (!tableBody) {
        console.error('❌ Table body not found');
        return;
    }
    
    const currentHeader = document.querySelector(`[data-sort="${sortBy}"]`);
    const isAscending = !currentHeader.classList.contains('asc');
    
    // Remove all sort classes and reset icons
    document.querySelectorAll('.sortable').forEach(header => {
        header.classList.remove('asc', 'desc');
        const icon = header.querySelector('i');
        if (icon) {
            icon.className = 'bi bi-arrow-down-up';
        }
    });
    
    // Add sort class to current header
    currentHeader.classList.add(isAscending ? 'asc' : 'desc');
    const icon = currentHeader.querySelector('i');
    if (icon) {
        icon.className = isAscending ? 'bi bi-sort-up' : 'bi bi-sort-down';
    }
    
    // Get all rows and convert to array
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    
    // Sort rows based on the column
    rows.sort((rowA, rowB) => {
        let valueA, valueB;
        
        // Get values based on column
        switch(sortBy) {
            case 'library_name':
                valueA = rowA.querySelector('.library-info h6').textContent.trim();
                valueB = rowB.querySelector('.library-info h6').textContent.trim();
                break;
            case 'library_type':
                valueA = rowA.querySelectorAll('td')[1].querySelector('.badge').textContent.trim();
                valueB = rowB.querySelectorAll('td')[1].querySelector('.badge').textContent.trim();
                break;
            case 'status':
                valueA = rowA.querySelectorAll('td')[2].querySelector('.badge').textContent.trim();
                valueB = rowB.querySelectorAll('td')[2].querySelector('.badge').textContent.trim();
                break;
            case 'registration_date':
            case 'last_update':
                const colIndex = sortBy === 'registration_date' ? 3 : 4;
                valueA = rowA.querySelectorAll('td')[colIndex].textContent.trim();
                valueB = rowB.querySelectorAll('td')[colIndex].textContent.trim();
                // Convert to Date for proper sorting
                valueA = new Date(valueA);
                valueB = new Date(valueB);
                break;
            default:
                valueA = '';
                valueB = '';
        }
        
        // Handle string comparison
        if (typeof valueA === 'string') {
            valueA = valueA.toLowerCase();
            valueB = valueB.toLowerCase();
        }
        
        // Sort comparison
        if (isAscending) {
            return valueA > valueB ? 1 : valueA < valueB ? -1 : 0;
        } else {
            return valueA < valueB ? 1 : valueA > valueB ? -1 : 0;
        }
    });
    
    // Clear table body and append sorted rows
    tableBody.innerHTML = '';
    rows.forEach(row => tableBody.appendChild(row));
    
    console.log(`✅ Table sorted by ${sortBy} (${isAscending ? 'ascending' : 'descending'})`);
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
 * Navigate to add registration page
 */
function navigateToAddRegistration() {
    console.log('🆕 Navigating to add registration page...');
    showToast('Navigating to add registration form...', 'info');
    
    // Navigate to add registration page
    setTimeout(() => {
        window.location.href = '/admin/registration/add';
    }, 500);
}

/**
 * Navigate to edit registration page
 */
function navigateToEditRegistration(libraryId = null) {
    console.log('✏️ Navigating to edit registration page...');
    showToast('Navigating to edit registration form...', 'info');
    
    // Navigate to edit registration page
    setTimeout(() => {
        window.location.href = `/admin/registration/edit/${libraryId || 1}`;
    }, 500);
}

/**
 * View registration details
 */
function viewRegistration(libraryName) {
    console.log(`👁️ Viewing registration: ${libraryName}`);
    const registration = registrations.find(r => r.library_name === libraryName);
    if (registration) {
        showToast('Navigating to registration details...', 'info');
        
        // Navigate to view registration page
        setTimeout(() => {
            window.location.href = `/admin/registration/view/${registration.id}`;
        }, 500);
    }
}

/**
 * Edit registration
 */
function editRegistration(libraryName) {
    console.log(`✏️ Editing registration: ${libraryName}`);
    const registration = registrations.find(r => r.library_name === libraryName);
    if (registration) {
        navigateToEditRegistration(registration.id);
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
        generateCSVDownload();
        
        // Reset button state
        downloadBtn.innerHTML = originalText;
        downloadBtn.disabled = false;
        
        showToast('Data downloaded successfully!', 'success');
    }, 1000);
}

/**
 * Generate CSV download from current table data
 */
function generateCSVDownload() {
    const tableBody = document.getElementById('registrationTableBody');
    if (!tableBody) {
        console.error('❌ Table body not found');
        return;
    }

    // CSV headers
    const headers = [
        'Library Name',
        'Library Type', 
        'Status',
        'Location',
        'Registration Date',
        'Last Update'
    ];
    
    // Convert table data to CSV format
    let csvContent = headers.join(',') + '\n';
    
    // Get visible rows only
    const visibleRows = tableBody.querySelectorAll('tr:not([style*="display: none"])');
    
    visibleRows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 5) {
            const libraryInfo = cells[0].querySelector('.library-info');
            const libraryName = libraryInfo ? libraryInfo.querySelector('h6').textContent.trim() : '';
            const location = libraryInfo ? libraryInfo.querySelector('small').textContent.trim() : '';
            
            const typeSpan = cells[1].querySelector('.badge');
            const statusSpan = cells[2].querySelector('.badge');
            const libraryType = typeSpan ? typeSpan.textContent.trim() : '';
            const status = statusSpan ? statusSpan.textContent.trim() : '';
            
            const registrationDate = cells[3].textContent.trim();
            const lastUpdate = cells[4].textContent.trim();
            
            const row = [
                `"${libraryName.replace(/"/g, '""')}"`,
                libraryType,
                status,
                `"${location.replace(/"/g, '""')}"`,
                registrationDate,
                lastUpdate
            ];
            csvContent += row.join(',') + '\n';
        }
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
function updateRegistrationCount(count = null) {
    const registrationCountElement = document.getElementById('registrationCount');
    if (registrationCountElement) {
        if (count !== null) {
            registrationCountElement.textContent = count;
        } else {
            // Count visible rows
            const tableBody = document.getElementById('registrationTableBody');
            if (tableBody) {
                const visibleRows = tableBody.querySelectorAll('tr:not([style*="display: none"])');
                registrationCountElement.textContent = visibleRows.length;
            }
        }
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

/**
 * Handle registration form submission
 */
function handleRegistrationFormSubmit() {
    const registrationForm = document.getElementById('registrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitRegistrationForm();
        });
    }
}

/**
 * Submit registration form
 */
function submitRegistrationForm() {
    console.log('📝 Submitting registration form...');
    
    const form = document.getElementById('registrationForm');
    if (!form) {
        console.error('❌ Registration form not found');
        return;
    }
    
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Show loading state
    if (submitBtn) {
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        
        // Simulate form submission
        setTimeout(() => {
            // Get form data
            const registrationData = {
                library_name: formData.get('library_name'),
                library_type: formData.get('library_type'),
                status: formData.get('status'),
                library_code: formData.get('library_code'),
                province: formData.get('province'),
                city: formData.get('city'),
                address: formData.get('address'),
                postal_code: formData.get('postal_code'),
                coordinates: formData.get('coordinates'),
                contact_name: formData.get('contact_name'),
                contact_position: formData.get('contact_position'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                website: formData.get('website'),
                fax: formData.get('fax'),
                established_year: formData.get('established_year'),
                collection_count: formData.get('collection_count'),
                member_count: formData.get('member_count'),
                notes: formData.get('notes')
            };
            
            console.log('📊 Registration data:', registrationData);
            
            // Show success message
            showToast('Registrasi berhasil disimpan!', 'success');
            
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            
            // Navigate back to registration list
            setTimeout(() => {
                showToast('Kembali ke daftar registrasi...', 'info');
                window.location.href = '/registration';
            }, 2000);
            
        }, 2000);
    }
}

/**
 * Initialize form-specific functionality
 */
function initializeFormFeatures() {
    // Handle registration form submission
    handleRegistrationFormSubmit();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize dynamic form features
    initializeDynamicFormFeatures();
}

/**
 * Initialize form validation
 */
function initializeFormValidation() {
    const form = document.getElementById('registrationForm');
    if (!form) return;
    
    // Add real-time validation
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
}

/**
 * Validate individual field
 */
function validateField(field) {
    const value = field.value.trim();
    const isValid = field.checkValidity() && value !== '';
    
    if (isValid) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
    } else {
        field.classList.remove('is-valid');
        field.classList.add('is-invalid');
    }
    
    return isValid;
}

/**
 * Initialize dynamic form features
 */
function initializeDynamicFormFeatures() {
    // Auto-generate library code based on name and type
    const libraryNameField = document.querySelector('[name="library_name"]');
    const libraryTypeField = document.querySelector('[name="library_type"]');
    const libraryCodeField = document.querySelector('[name="library_code"]');
    
    if (libraryNameField && libraryTypeField && libraryCodeField) {
        function generateLibraryCode() {
            const name = libraryNameField.value.trim();
            const type = libraryTypeField.value;
            
            if (name && type && !libraryCodeField.value) {
                const nameCode = name.substring(0, 3).toUpperCase();
                const typeCode = type.substring(0, 3).toUpperCase();
                const randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                
                libraryCodeField.value = `${typeCode}-${nameCode}-${randomNum}`;
            }
        }
        
        libraryNameField.addEventListener('blur', generateLibraryCode);
        libraryTypeField.addEventListener('change', generateLibraryCode);
    }
    
    // Format phone numbers
    const phoneFields = document.querySelectorAll('[type="tel"]');
    phoneFields.forEach(field => {
        field.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.startsWith('62')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = '+62' + value.substring(1);
            }
            this.value = value;
        });
    });
}

// Initialize form features when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeFormFeatures();
});

// Export functions for global access
window.RegistrationManagement = {
    filterRegistrations,
    sortTable,
    viewRegistration,
    editRegistration,
    deleteRegistration,
    downloadData,
    showToast,
    navigateToAddRegistration,
    navigateToEditRegistration,
    submitRegistrationForm
};

console.log('📦 Registration Management JavaScript loaded successfully');