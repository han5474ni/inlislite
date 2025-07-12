/**
 * INLISLite v3.0 User Management JavaScript
 * Modern user management with sidebar integration and modal functionality
 */

// Global variables
let users = [];
let filteredUsers = [];
let currentEditUserId = null;
let userChart = null;
let userStatistics = {};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 User Management System Initializing...');
    
    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    // Setup event listeners
    setupEventListeners();
    
    // Load users
    loadUsers();
    
    // Initialize chart
    initializeChart();
    
    console.log('✅ User Management System Ready');
});

/**
 * Setup event listeners
 */
function setupEventListeners() {
    console.log('📡 Setting up event listeners...');
    
    // Sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle && sidebar) {
        const toggleIcon = sidebarToggle.querySelector('i');
        
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.setAttribute('data-feather', 'chevron-right');
            } else {
                toggleIcon.setAttribute('data-feather', 'chevron-left');
            }
            
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    }

    // Mobile menu
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    if (mobileMenuBtn && sidebar) {
        mobileMenuBtn.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }

    // Search and filters
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce(filterUsers, 300));
    }
    
    if (roleFilter) {
        roleFilter.addEventListener('change', filterUsers);
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterUsers);
    }

    // Add User Button
    const addUserBtn = document.querySelector('.btn-add-user');
    if (addUserBtn) {
        addUserBtn.addEventListener('click', function() {
            console.log('🆕 Opening Add User Modal...');
            showToast('Opening add user form...', 'info');
        });
    }

    // Modal events
    const addUserModal = document.getElementById('addUserModal');
    const editUserModal = document.getElementById('editUserModal');
    
    if (addUserModal) {
        addUserModal.addEventListener('hidden.bs.modal', function() {
            console.log('🔄 Resetting add user form...');
            const form = document.getElementById('addUserForm');
            if (form) {
                form.reset();
                clearFormErrors();
            }
        });
        
        addUserModal.addEventListener('shown.bs.modal', function() {
            console.log('👁️ Add user modal opened');
            const firstInput = addUserModal.querySelector('.modern-input');
            if (firstInput) {
                firstInput.focus();
            }
        });
    }

    if (editUserModal) {
        editUserModal.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('editUserForm');
            if (form) {
                form.reset();
                clearFormErrors();
            }
            currentEditUserId = null;
        });
    }

    // Form submission
    const addUserForm = document.getElementById('addUserForm');
    if (addUserForm) {
        addUserForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitAddUser();
        });
    }

    const editUserForm = document.getElementById('editUserForm');
    if (editUserForm) {
        editUserForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitEditUser();
        });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768 && sidebar) {
            if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sidebar) {
            sidebar.classList.remove('show');
        }
    });

    // Enhanced form interactions
    setupFormEnhancements();
}

/**
 * Setup form enhancements
 */
function setupFormEnhancements() {
    // Add floating label effect
    document.addEventListener('focus', function(e) {
        if (e.target.classList.contains('modern-input') || e.target.classList.contains('modern-select')) {
            e.target.parentNode.classList.add('focused');
        }
    }, true);

    document.addEventListener('blur', function(e) {
        if (e.target.classList.contains('modern-input') || e.target.classList.contains('modern-select')) {
            if (!e.target.value) {
                e.target.parentNode.classList.remove('focused');
            }
        }
    }, true);

    // Real-time validation
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('modern-input')) {
            validateFieldRealTime(e.target);
        }
    });
}

/**
 * Real-time field validation
 */
function validateFieldRealTime(field) {
    const value = field.value.trim();
    const name = field.name;
    
    // Remove previous validation classes
    field.classList.remove('is-valid', 'is-invalid');
    
    // Basic validation
    if (field.hasAttribute('required') && value === '') {
        return;
    }
    
    // Email validation
    if (name === 'email' && value) {
        if (isValidEmail(value)) {
            field.classList.add('is-valid');
        } else {
            field.classList.add('is-invalid');
        }
    }
    
    // Password validation
    if (name === 'password' && value) {
        if (value.length >= 6) {
            field.classList.add('is-valid');
        } else {
            field.classList.add('is-invalid');
        }
    }
    
    // Other fields
    if (name !== 'email' && name !== 'password' && value) {
        field.classList.add('is-valid');
    }
}

/**
 * Load users from database or mock data
 */
async function loadUsers() {
    console.log('📊 Loading users...');
    
    try {
        // Try to load from CodeIgniter endpoint first
        const response = await fetch(getBaseUrl() + 'admin/users/ajax/list');
        const result = await response.json();
        
        if (result.success && result.data) {
            users = result.data.map(user => ({
                ...user,
                avatar_initials: getInitials(user.nama_lengkap),
                last_login_formatted: formatLastLogin(user.last_login),
                created_at_formatted: formatDate(user.created_at)
            }));
            console.log('✅ Users loaded from API');
        } else {
            throw new Error('API response not successful');
        }
    } catch (error) {
        console.log('⚠️ Loading mock data due to:', error.message);
        // Fallback to mock data
        loadMockUsers();
    }
    
    filteredUsers = [...users];
    renderUsersTable();
    updateUserCount();
    
    // Refresh chart after loading users
    if (userChart) {
        refreshChart();
    }
}

/**
 * Load mock users for demo
 */
function loadMockUsers() {
    users = [
        {
            id: 1,
            nama_lengkap: 'System Administrator',
            nama_pengguna: 'admin',
            email: 'admin@inlislite.local',
            role: 'Super Admin',
            status: 'Aktif',
            last_login: '2025-01-01 14:00:00',
            created_at: '2024-01-15',
            avatar_initials: 'SA',
            last_login_formatted: '2 jam yang lalu',
            created_at_formatted: '15 Jan 2024'
        },
        {
            id: 2,
            nama_lengkap: 'Test Pustakawan',
            nama_pengguna: 'pustakawan',
            email: 'pustakawan@inlislite.local',
            role: 'Pustakawan',
            status: 'Aktif',
            last_login: '2024-12-31 10:00:00',
            created_at: '2024-01-10',
            avatar_initials: 'TP',
            last_login_formatted: '1 hari yang lalu',
            created_at_formatted: '10 Jan 2024'
        },
        {
            id: 3,
            nama_lengkap: 'Test Staff',
            nama_pengguna: 'staff',
            email: 'staff@inlislite.local',
            role: 'Staff',
            status: 'Aktif',
            last_login: '2024-12-29 16:00:00',
            created_at: '2024-01-08',
            avatar_initials: 'TS',
            last_login_formatted: '3 hari yang lalu',
            created_at_formatted: '8 Jan 2024'
        },
        {
            id: 4,
            nama_lengkap: 'Test Admin',
            nama_pengguna: 'testadmin',
            email: 'testadmin@inlislite.local',
            role: 'Admin',
            status: 'Non-Aktif',
            last_login: null,
            created_at: '2024-01-05',
            avatar_initials: 'TA',
            last_login_formatted: 'Belum pernah',
            created_at_formatted: '5 Jan 2024'
        }
    ];
    console.log('✅ Mock users loaded');
}

/**
 * Filter users based on search and filters
 */
function filterUsers() {
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    
    const search = searchInput ? searchInput.value.toLowerCase() : '';
    const role = roleFilter ? roleFilter.value : '';
    const status = statusFilter ? statusFilter.value : '';

    filteredUsers = users.filter(user => {
        const matchesSearch = search === '' || 
            user.nama_lengkap.toLowerCase().includes(search) ||
            user.nama_pengguna.toLowerCase().includes(search) ||
            user.email.toLowerCase().includes(search);
        
        const matchesRole = role === '' || user.role === role;
        const matchesStatus = status === '' || user.status === status;

        return matchesSearch && matchesRole && matchesStatus;
    });

    renderUsersTable();
    updateUserCount();
    
    console.log(`🔍 Filtered users: ${filteredUsers.length}/${users.length}`);
}

/**
 * Render users table
 */
function renderUsersTable() {
    const tbody = document.getElementById('usersTableBody');
    if (!tbody) return;
    
    if (filteredUsers.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4">
                    <div class="text-muted">
                        <i data-feather="inbox" style="width: 48px; height: 48px; margin-bottom: 1rem; display: block; margin: 0 auto 1rem;"></i>
                        <p>Tidak ada pengguna yang ditemukan</p>
                    </div>
                </td>
            </tr>
        `;
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        return;
    }

    tbody.innerHTML = filteredUsers.map(user => `
        <tr class="fade-in">
            <td>
                <div class="user-info">
                    <div class="user-avatar">${user.avatar_initials}</div>
                    <div class="user-details">
                        <h6>${escapeHtml(user.nama_lengkap)}</h6>
                        <small>${escapeHtml(user.email)}</small>
                    </div>
                </div>
            </td>
            <td>
                <span class="badge badge-role ${getRoleClass(user.role)}">${escapeHtml(user.role)}</span>
            </td>
            <td>
                <span class="badge badge-status ${getStatusClass(user.status)}">${escapeHtml(user.status)}</span>
            </td>
            <td>${escapeHtml(user.last_login_formatted)}</td>
            <td>${escapeHtml(user.created_at_formatted)}</td>
            <td>
                <div class="dropdown">
                    <button class="action-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#" onclick="editUser(${user.id})">
                                <i class="bi bi-pencil me-2"></i>
                                Edit User
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="deleteUser(${user.id}, '${escapeHtml(user.nama_lengkap)}')">
                                <i class="bi bi-trash me-2"></i>
                                Hapus User
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    `).join('');

    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

/**
 * Submit add user form
 */
async function submitAddUser() {
    console.log('📝 Submitting add user form...');
    
    const form = document.getElementById('addUserForm');
    if (!form) {
        console.error('❌ Add user form not found');
        return;
    }
    
    const submitBtn = form.querySelector('.btn-add-user-submit');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menambahkan...';
    
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    // Validate form
    if (!validateForm(data)) {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        return;
    }

    try {
        // Make real API call to add user
        const response = await fetch(getBaseUrl() + 'admin/users/ajax/create', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Add new user to local array
            const newUser = {
                ...result.data,
                avatar_initials: getInitials(result.data.nama_lengkap || result.data.nama_pengguna),
                last_login_formatted: formatLastLogin(result.data.last_login),
                created_at_formatted: formatDate(result.data.created_at)
            };
            
            users.push(newUser);
            
            showToast(result.message || 'User berhasil ditambahkan!', 'success');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            if (modal) {
                modal.hide();
            }
            
            // Refresh table and chart
            filterUsers();
            refreshChart();
            
            console.log('✅ User added successfully:', newUser);
        } else {
            // Handle validation errors
            if (result.errors) {
                const errorMessages = Object.values(result.errors).join('<br>');
                showToast(errorMessages, 'error');
            } else {
                showToast(result.message || 'Gagal menambahkan user', 'error');
            }
        }
        
    } catch (error) {
        console.error('❌ Error adding user:', error);
        showToast('Error menambahkan user: ' + error.message, 'error');
    } finally {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
}

/**
 * Submit edit user form
 */
async function submitEditUser() {
    console.log('📝 Submitting edit user form...');
    
    const form = document.getElementById('editUserForm');
    if (!form) {
        console.error('❌ Edit user form not found');
        return;
    }
    
    const submitBtn = document.getElementById('updateUserBtn');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memperbarui...';
    
    // Get form data, but ensure disabled fields are included
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    // Make sure email field is included (it might be disabled)
    const emailField = document.getElementById('editEmail');
    if (emailField && emailField.disabled) {
        data.email = emailField.value;
    }

    // Validate form (edit mode)
    if (!validateForm(data, true)) {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        return;
    }

    try {
        // Make real API call to update user
        const response = await fetch(getBaseUrl() + `admin/users/ajax/update/${currentEditUserId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Update user in local array
            const userIndex = users.findIndex(u => u.id == currentEditUserId);
            if (userIndex !== -1) {
                users[userIndex] = {
                    ...result.data,
                    avatar_initials: getInitials(result.data.nama_lengkap || result.data.nama_pengguna),
                    last_login_formatted: formatLastLogin(result.data.last_login),
                    created_at_formatted: formatDate(result.data.created_at)
                };
            }
            
            showToast(result.message || 'User berhasil diperbarui!', 'success');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            if (modal) {
                modal.hide();
            }
            
            // Refresh table and chart
            filterUsers();
            refreshChart();
            
            console.log('✅ User updated successfully:', result.data);
        } else {
            // Handle validation errors
            if (result.errors) {
                const errorMessages = Object.values(result.errors).join('<br>');
                showToast(errorMessages, 'error');
            } else {
                showToast(result.message || 'Gagal memperbarui user', 'error');
            }
        }
        
    } catch (error) {
        console.error('❌ Error updating user:', error);
        showToast('Error memperbarui user: ' + error.message, 'error');
    } finally {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
}

/**
 * Edit user
 */
function editUser(userId) {
    console.log(`✏️ Editing user: ${userId}`);
    const user = users.find(u => u.id == userId);
    if (!user) {
        showToast('User tidak ditemukan', 'error');
        return;
    }

    // Set current edit user ID
    currentEditUserId = userId;

    // Populate edit form with user data
    document.getElementById('editUserId').value = user.id;
    document.getElementById('editNamaLengkap').value = user.nama_lengkap;
    document.getElementById('editNamaPengguna').value = user.nama_pengguna;
    
    // Disable email field and set its value (admin can't edit email)
    const emailField = document.getElementById('editEmail');
    emailField.value = user.email;
    emailField.disabled = true;
    emailField.classList.add('bg-light');
    
    document.getElementById('editPassword').value = ''; // Always empty for security
    document.getElementById('editRole').value = user.role;
    document.getElementById('editStatus').value = user.status;

    // Show edit modal
    const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
    editModal.show();

    console.log('✅ Edit modal opened for user:', user.nama_lengkap);
}

/**
 * Delete user
 */
async function deleteUser(userId, userName) {
    if (!confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?`)) {
        return;
    }

    console.log(`🗑️ Deleting user: ${userId}`);

    try {
        // Make real API call to delete user
        const response = await fetch(getBaseUrl() + `admin/users/ajax/delete/${userId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Remove from users array
            users = users.filter(u => u.id != userId);
            
            showToast(result.message || `User "${userName}" berhasil dihapus!`, 'success');
            
            // Refresh table and chart
            filterUsers();
            refreshChart();
            
            console.log('✅ User deleted successfully');
        } else {
            showToast(result.message || 'Gagal menghapus user', 'error');
        }
        
    } catch (error) {
        console.error('❌ Error deleting user:', error);
        showToast('Error menghapus user: ' + error.message, 'error');
    }
}

/**
 * Validate form
 */
function validateForm(data, isEdit = false) {
    const errors = [];

    if (!data.nama_lengkap) errors.push('Nama lengkap wajib diisi');
    if (!data.nama_pengguna) errors.push('Nama pengguna wajib diisi');
    if (!isEdit && !data.email) errors.push('Email wajib diisi');
    if (!isEdit && !data.password) errors.push('Kata sandi wajib diisi');
    if (!data.role) errors.push('Role wajib diisi');
    if (!data.status) errors.push('Status wajib diisi');

    // Only validate email format in add mode (not edit mode)
    if (!isEdit && data.email && !isValidEmail(data.email)) {
        errors.push('Format email tidak valid');
    }

    // In edit mode, password is optional, but if provided, must be at least 6 characters
    if (data.password && data.password.length > 0 && data.password.length < 6) {
        errors.push('Kata sandi minimal 6 karakter');
    }

    if (errors.length > 0) {
        showToast(errors.join('<br>'), 'error');
        return false;
    }

    return true;
}

/**
 * Clear form errors
 */
function clearFormErrors() {
    document.querySelectorAll('.is-invalid').forEach(element => {
        element.classList.remove('is-invalid');
    });
    document.querySelectorAll('.is-valid').forEach(element => {
        element.classList.remove('is-valid');
    });
    document.querySelectorAll('.invalid-feedback').forEach(element => {
        element.remove();
    });
}

/**
 * Get role CSS class
 */
function getRoleClass(role) {
    const roleClasses = {
        'Super Admin': 'badge-super-admin',
        'Admin': 'badge-admin',
        'Pustakawan': 'badge-pustakawan',
        'Librarian': 'badge-pustakawan',
        'Staff': 'badge-staff'
    };
    return roleClasses[role] || 'badge-staff';
}

/**
 * Get status CSS class
 */
function getStatusClass(status) {
    const statusClasses = {
        'Aktif': 'badge-aktif',
        'Non-Aktif': 'badge-nonaktif',
        'Tidak Aktif': 'badge-nonaktif',
        'Ditangguhkan': 'badge-nonaktif'
    };
    return statusClasses[status] || 'badge-nonaktif';
}

/**
 * Update user count
 */
function updateUserCount() {
    const countElement = document.getElementById('userCount');
    if (countElement) {
        countElement.textContent = filteredUsers.length;
    }
}

/**
 * Get initials from name
 */
function getInitials(name) {
    if (!name) return 'U';
    return name
        .split(' ')
        .map(word => word.charAt(0).toUpperCase())
        .join('')
        .substring(0, 2);
}

/**
 * Format last login
 */
function formatLastLogin(lastLogin) {
    if (!lastLogin) return 'Belum pernah';
    
    try {
        const loginDate = new Date(lastLogin);
        const now = new Date();
        const diffMs = now - loginDate;
        const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
        const diffDays = Math.floor(diffHours / 24);
        
        if (diffDays > 0) {
            return `${diffDays} hari yang lalu`;
        } else if (diffHours > 0) {
            return `${diffHours} jam yang lalu`;
        } else {
            return 'Baru saja';
        }
    } catch (error) {
        return 'Belum pernah';
    }
}

/**
 * Format date
 */
function formatDate(dateString) {
    if (!dateString) return '-';
    
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        });
    } catch (error) {
        return dateString;
    }
}

/**
 * Validate email
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Show toast notification
 */
function showToast(message, type = 'info') {
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
    
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = `toast align-items-center text-white ${bgClass} border-0`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    const bootstrapToast = new bootstrap.Toast(toast);
    bootstrapToast.show();
    
    // Remove toast from DOM after hiding
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
    
    console.log(`📢 Toast shown: ${type} - ${message}`);
}

/**
 * Get base URL
 */
function getBaseUrl() {
    // Try to get base URL from meta tag or use current location
    const baseElement = document.querySelector('base');
    if (baseElement) {
        return baseElement.href;
    }
    
    // Fallback to current location
    const path = window.location.pathname;
    const segments = path.split('/');
    
    // Remove the last segment if it's not empty
    if (segments[segments.length - 1] !== '') {
        segments.pop();
    }
    
    return window.location.origin + segments.join('/') + '/';
}

/**
 * Escape HTML to prevent XSS
 */
function escapeHtml(text) {
    if (!text) return '';
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

/**
 * Debounce function
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

/**
 * Export functions for global access
 */
window.UserManagementJS = {
    editUser,
    deleteUser,
    submitAddUser,
    submitEditUser,
    showToast,
    loadUsers,
    filterUsers
};

/**
 * Initialize Chart
 */
function initializeChart() {
    console.log('📊 Initializing user statistics chart...');
    
    const ctx = document.getElementById('userChart');
    if (!ctx) {
        console.warn('⚠️ Chart canvas not found');
        return;
    }

    // Destroy existing chart if it exists
    if (userChart) {
        userChart.destroy();
    }

    // Generate chart data
    const chartData = generateChartData();
    
    userChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.years,
            datasets: [
                {
                    label: 'Super Admin',
                    data: chartData.superAdmin,
                    backgroundColor: '#004AAD',
                    borderColor: '#004AAD',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                },
                {
                    label: 'Admin',
                    data: chartData.admin,
                    backgroundColor: '#1C6EC4',
                    borderColor: '#1C6EC4',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                },
                {
                    label: 'Pustakawan',
                    data: chartData.pustakawan,
                    backgroundColor: '#2DA84D',
                    borderColor: '#2DA84D',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                },
                {
                    label: 'Staff',
                    data: chartData.staff,
                    backgroundColor: '#0B8F1C',
                    borderColor: '#0B8F1C',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // We use custom legend
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#ddd',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        title: function(context) {
                            return `Year ${context[0].label}`;
                        },
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y} users`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6c757d',
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f3f4',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6c757d',
                        font: {
                            size: 12
                        },
                        stepSize: 1
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Update legend counts
    updateLegendCounts(chartData);
    
    // Setup year filter
    setupYearFilter(chartData.years);
    
    console.log('✅ Chart initialized successfully');
}

/**
 * Generate chart data from users
 */
function generateChartData() {
    const currentYear = new Date().getFullYear();
    const years = [];
    const roleData = {
        'Super Admin': [],
        'Admin': [],
        'Pustakawan': [],
        'Staff': []
    };

    // Generate years (current year and 4 previous years)
    for (let i = 4; i >= 0; i--) {
        years.push(currentYear - i);
    }

    // Initialize data arrays
    years.forEach(() => {
        roleData['Super Admin'].push(0);
        roleData['Admin'].push(0);
        roleData['Pustakawan'].push(0);
        roleData['Staff'].push(0);
    });

    // Process users data
    users.forEach(user => {
        if (user.created_at) {
            const userYear = new Date(user.created_at).getFullYear();
            const yearIndex = years.indexOf(userYear);
            
            if (yearIndex !== -1 && roleData[user.role]) {
                roleData[user.role][yearIndex]++;
            }
        }
    });

    // Add some mock data if no real data exists
    if (users.length === 0) {
        // Generate sample data for demonstration
        years.forEach((year, index) => {
            roleData['Super Admin'][index] = Math.floor(Math.random() * 3) + 1;
            roleData['Admin'][index] = Math.floor(Math.random() * 5) + 2;
            roleData['Pustakawan'][index] = Math.floor(Math.random() * 8) + 3;
            roleData['Staff'][index] = Math.floor(Math.random() * 12) + 5;
        });
    }

    return {
        years: years,
        superAdmin: roleData['Super Admin'],
        admin: roleData['Admin'],
        pustakawan: roleData['Pustakawan'],
        staff: roleData['Staff']
    };
}

/**
 * Update legend counts
 */
function updateLegendCounts(chartData) {
    const totalCounts = {
        superAdmin: chartData.superAdmin.reduce((a, b) => a + b, 0),
        admin: chartData.admin.reduce((a, b) => a + b, 0),
        pustakawan: chartData.pustakawan.reduce((a, b) => a + b, 0),
        staff: chartData.staff.reduce((a, b) => a + b, 0)
    };

    // Update legend count elements
    const superAdminCount = document.getElementById('superAdminCount');
    const adminCount = document.getElementById('adminCount');
    const pustakawaCount = document.getElementById('pustakawaCount');
    const staffCount = document.getElementById('staffCount');

    if (superAdminCount) superAdminCount.textContent = totalCounts.superAdmin;
    if (adminCount) adminCount.textContent = totalCounts.admin;
    if (pustakawaCount) pustakawaCount.textContent = totalCounts.pustakawan;
    if (staffCount) staffCount.textContent = totalCounts.staff;
}

/**
 * Setup year filter dropdown
 */
function setupYearFilter(years) {
    const yearFilter = document.getElementById('yearFilter');
    if (!yearFilter) return;

    // Clear existing options except "All Years"
    yearFilter.innerHTML = '<option value="all">All Years</option>';
    
    // Add year options
    years.forEach(year => {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearFilter.appendChild(option);
    });

    // Add event listener for year filter
    yearFilter.addEventListener('change', function() {
        filterChartByYear(this.value);
    });
}

/**
 * Filter chart by year
 */
function filterChartByYear(selectedYear) {
    if (!userChart) return;

    const chartData = generateChartData();
    
    if (selectedYear === 'all') {
        // Show all years
        userChart.data.labels = chartData.years;
        userChart.data.datasets[0].data = chartData.superAdmin;
        userChart.data.datasets[1].data = chartData.admin;
        userChart.data.datasets[2].data = chartData.pustakawan;
        userChart.data.datasets[3].data = chartData.staff;
    } else {
        // Show only selected year
        const yearIndex = chartData.years.indexOf(parseInt(selectedYear));
        if (yearIndex !== -1) {
            userChart.data.labels = [selectedYear];
            userChart.data.datasets[0].data = [chartData.superAdmin[yearIndex]];
            userChart.data.datasets[1].data = [chartData.admin[yearIndex]];
            userChart.data.datasets[2].data = [chartData.pustakawan[yearIndex]];
            userChart.data.datasets[3].data = [chartData.staff[yearIndex]];
        }
    }

    userChart.update('active');
    updateLegendCounts(chartData);
}

/**
 * Refresh chart data
 */
function refreshChart() {
    if (userChart) {
        const chartData = generateChartData();
        userChart.data.labels = chartData.years;
        userChart.data.datasets[0].data = chartData.superAdmin;
        userChart.data.datasets[1].data = chartData.admin;
        userChart.data.datasets[2].data = chartData.pustakawan;
        userChart.data.datasets[3].data = chartData.staff;
        userChart.update();
        updateLegendCounts(chartData);
    }
}

console.log('📦 User Management JavaScript loaded successfully');
