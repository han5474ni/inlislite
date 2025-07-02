/**
 * INLISLite v3.0 User Management JavaScript
 * Modern user management with sidebar integration
 */

// Global variables
let users = [];
let filteredUsers = [];
let currentEditUserId = null;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    // Setup event listeners
    setupEventListeners();
    
    // Load users
    loadUsers();
});

/**
 * Setup event listeners
 */
function setupEventListeners() {
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

    // Modal events
    const addUserModal = document.getElementById('addUserModal');
    const editUserModal = document.getElementById('editUserModal');
    
    if (addUserModal) {
        addUserModal.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('addUserForm');
            if (form) form.reset();
        });
    }

    if (editUserModal) {
        editUserModal.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('editUserForm');
            if (form) form.reset();
            currentEditUserId = null;
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
}

/**
 * Load users from database or mock data
 */
async function loadUsers() {
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
        } else {
            throw new Error('API response not successful');
        }
    } catch (error) {
        console.log('Loading mock data due to:', error.message);
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
                        <i data-feather="inbox" style="width: 48px; height: 48px; margin-bottom: 1rem;"></i>
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
        <tr>
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
                <span class="badge role-badge ${getRoleClass(user.role)}">${escapeHtml(user.role)}</span>
            </td>
            <td>
                <span class="badge status-badge ${getStatusClass(user.status)}">${escapeHtml(user.status)}</span>
            </td>
            <td>${escapeHtml(user.last_login_formatted)}</td>
            <td>${escapeHtml(user.created_at_formatted)}</td>
            <td>
                <div class="dropdown">
                    <button class="action-btn" data-bs-toggle="dropdown">
                        <i data-feather="more-vertical" style="width: 16px; height: 16px;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#" onclick="editUser(${user.id})">
                                <i data-feather="edit" style="width: 16px; height: 16px; margin-right: 0.5rem;"></i>
                                Edit User
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="deleteUser(${user.id}, '${escapeHtml(user.nama_lengkap)}')">
                                <i data-feather="trash-2" style="width: 16px; height: 16px; margin-right: 0.5rem;"></i>
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
 * Get role CSS class
 */
function getRoleClass(role) {
    const roleClasses = {
        'Super Admin': 'role-super-admin',
        'Admin': 'role-admin',
        'Pustakawan': 'role-pustakawan',
        'Staff': 'role-staff'
    };
    return roleClasses[role] || 'role-staff';
}

/**
 * Get status CSS class
 */
function getStatusClass(status) {
    const statusClasses = {
        'Aktif': 'status-aktif',
        'Non-Aktif': 'status-non-aktif',
        'Ditangguhkan': 'status-suspended'
    };
    return statusClasses[status] || 'status-non-aktif';
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
 * Submit add user form
 */
async function submitAddUser() {
    const form = document.getElementById('addUserForm');
    if (!form) return;
    
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    // Validate form
    if (!validateForm(data)) {
        return;
    }

    try {
        const response = await fetch(getBaseUrl() + 'admin/users/ajax/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            showToast(result.message, 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            if (modal) modal.hide();
            loadUsers(); // Reload users
        } else {
            if (result.errors) {
                showToast(Object.values(result.errors).join('<br>'), 'error');
            } else {
                showToast(result.message, 'error');
            }
        }
    } catch (error) {
        console.error('Error adding user:', error);
        showToast('Error adding user: ' + error.message, 'error');
    }
}

/**
 * Edit user
 */
function editUser(userId) {
    const user = users.find(u => u.id == userId);
    if (!user) return;

    currentEditUserId = userId;

    // Populate form
    const form = document.getElementById('editUserForm');
    if (form) {
        const elements = {
            'editUserId': user.id,
            'editNamaLengkap': user.nama_lengkap,
            'editUsername': user.nama_pengguna,
            'editEmail': user.email,
            'editRole': user.role,
            'editStatus': user.status
        };
        
        Object.entries(elements).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) element.value = value;
        });
    }

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
    modal.show();
}

/**
 * Submit edit user form
 */
async function submitEditUser() {
    const form = document.getElementById('editUserForm');
    if (!form) return;
    
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    // Validate form
    if (!validateForm(data, true)) {
        return;
    }

    try {
        const response = await fetch(getBaseUrl() + `admin/users/ajax/update/${data.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            showToast(result.message, 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            if (modal) modal.hide();
            loadUsers(); // Reload users
        } else {
            if (result.errors) {
                showToast(Object.values(result.errors).join('<br>'), 'error');
            } else {
                showToast(result.message, 'error');
            }
        }
    } catch (error) {
        console.error('Error updating user:', error);
        showToast('Error updating user: ' + error.message, 'error');
    }
}

/**
 * Delete user
 */
async function deleteUser(userId, userName) {
    if (!confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?`)) {
        return;
    }

    try {
        const response = await fetch(getBaseUrl() + `admin/users/ajax/delete/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (result.success) {
            showToast(result.message, 'success');
            loadUsers(); // Reload users
        } else {
            showToast(result.message, 'error');
        }
    } catch (error) {
        console.error('Error deleting user:', error);
        showToast('Error deleting user: ' + error.message, 'error');
    }
}

/**
 * Validate form
 */
function validateForm(data, isEdit = false) {
    const errors = [];

    if (!data.nama_lengkap) errors.push('Nama lengkap wajib diisi');
    if (!data.username) errors.push('Username wajib diisi');
    if (!data.email) errors.push('Email wajib diisi');
    if (!isEdit && !data.password) errors.push('Password wajib diisi');
    if (!data.role) errors.push('Role wajib diisi');
    if (!data.status) errors.push('Status wajib diisi');

    if (data.email && !isValidEmail(data.email)) {
        errors.push('Format email tidak valid');
    }

    if (data.password && data.password.length < 6) {
        errors.push('Password minimal 6 karakter');
    }

    if (errors.length > 0) {
        showToast(errors.join('<br>'), 'error');
        return false;
    }

    return true;
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
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = `toast align-items-center text-white bg-${type === 'error' ? 'danger' : type} border-0`;
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
    loadUsers
};