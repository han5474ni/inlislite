/**
 * INLISLite v3.0 User Management JavaScript
 * Modern user management with sidebar integration and modal functionality
 */

// Global variables
let users = [];
let filteredUsers = [];
let currentEditUserId = null;

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
        // Simulate API call for demo
        await new Promise(resolve => setTimeout(resolve, 1500));
        
        // Create new user object
        const newUser = {
            id: users.length + 1,
            nama_lengkap: data.nama_lengkap,
            nama_pengguna: data.nama_pengguna,
            email: data.email,
            role: data.role,
            status: data.status,
            last_login: null,
            created_at: new Date().toISOString().split('T')[0],
            avatar_initials: getInitials(data.nama_lengkap),
            last_login_formatted: 'Belum pernah',
            created_at_formatted: formatDate(new Date().toISOString())
        };
        
        // Add to users array
        users.push(newUser);
        
        showToast('User berhasil ditambahkan!', 'success');
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
        if (modal) {
            modal.hide();
        }
        
        // Refresh table
        filterUsers();
        
        console.log('✅ User added successfully');
        
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
    
    const submitBtn = form.querySelector('.btn-edit-user-submit');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memperbarui...';
    
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    // Validate form (edit mode)
    if (!validateForm(data, true)) {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        return;
    }

    try {
        // Simulate API call for demo
        await new Promise(resolve => setTimeout(resolve, 1500));
        
        // Find and update user in array
        const userIndex = users.findIndex(u => u.id == currentEditUserId);
        if (userIndex !== -1) {
            // Update user data
            users[userIndex] = {
                ...users[userIndex],
                nama_lengkap: data.nama_lengkap,
                nama_pengguna: data.nama_pengguna,
                email: data.email,
                role: data.role,
                status: data.status,
                avatar_initials: getInitials(data.nama_lengkap)
            };
            
            // Only update password if provided
            if (data.password && data.password.trim() !== '') {
                // In real implementation, this would be handled securely on the server
                console.log('Password would be updated on server');
            }
        }
        
        showToast('User berhasil diperbarui!', 'success');
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
        if (modal) {
            modal.hide();
        }
        
        // Refresh table
        filterUsers();
        
        console.log('✅ User updated successfully');
        
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
    document.getElementById('editEmail').value = user.email;
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
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Remove from users array
        users = users.filter(u => u.id != userId);
        
        showToast(`User "${userName}" berhasil dihapus!`, 'success');
        
        // Refresh table
        filterUsers();
        
        console.log('✅ User deleted successfully');
        
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
    if (!data.email) errors.push('Email wajib diisi');
    if (!isEdit && !data.password) errors.push('Kata sandi wajib diisi');
    if (!data.role) errors.push('Role wajib diisi');
    if (!data.status) errors.push('Status wajib diisi');

    if (data.email && !isValidEmail(data.email)) {
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

console.log('📦 User Management JavaScript loaded successfully');
// ...existing code...
