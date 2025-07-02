/**
 * User Management JavaScript - INLISlite v3.0
 * Modern, responsive user management with Bootstrap 5
 */

// Global variables
let users = [];
let filteredUsers = [];

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 User Management System Initializing...');
    
    // Setup event listeners
    setupEventListeners();
    
    // Load initial data
    loadInitialData();
    
    console.log('✅ User Management System Ready');
});

/**
 * Setup all event listeners
 */
function setupEventListeners() {
    console.log('📡 Setting up event listeners...');
    
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
    if (addUserModal) {
        addUserModal.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('addUserForm');
            if (form) {
                form.reset();
                clearFormErrors();
            }
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
}

/**
 * Load initial sample data
 */
function loadInitialData() {
    console.log('📊 Loading initial data...');
    
    // Sample users data
    users = [
        {
            id: 1,
            nama_lengkap: 'John Doe',
            email: 'john.doe@example.com',
            role: 'Super Admin',
            status: 'Aktif',
            last_login: '2 Jan 2024',
            last_login_time: '14:30',
            created_at: '15 Des 2023',
            avatar_initials: 'JD'
        },
        {
            id: 2,
            nama_lengkap: 'Alice Smith',
            email: 'alice.smith@example.com',
            role: 'Pustakawan',
            status: 'Aktif',
            last_login: '1 Jan 2024',
            last_login_time: '09:15',
            created_at: '10 Des 2023',
            avatar_initials: 'AS'
        },
        {
            id: 3,
            nama_lengkap: 'Bob Johnson',
            email: 'bob.johnson@example.com',
            role: 'Staff',
            status: 'Non-aktif',
            last_login: '28 Des 2023',
            last_login_time: '16:45',
            created_at: '5 Des 2023',
            avatar_initials: 'BJ'
        },
        {
            id: 4,
            nama_lengkap: 'Carol Davis',
            email: 'carol.davis@example.com',
            role: 'Admin',
            status: 'Aktif',
            last_login: '31 Des 2023',
            last_login_time: '11:20',
            created_at: '1 Des 2023',
            avatar_initials: 'CD'
        }
    ];
    
    filteredUsers = [...users];
    renderUsersTable();
    updateUserCount();
    
    console.log('✅ Initial data loaded');
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
            (user.nama_lengkap && user.nama_lengkap.toLowerCase().includes(search)) ||
            (user.email && user.email.toLowerCase().includes(search));
        
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
    if (!tbody) {
        console.error('❌ Users table body not found');
        return;
    }
    
    if (filteredUsers.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4">
                    <div class="text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        <p>Tidak ada pengguna yang ditemukan</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = filteredUsers.map(user => `
        <tr class="fade-in" data-role="${user.role}" data-status="${user.status}">
            <td>
                <div class="user-info">
                    <div class="user-avatar">${user.avatar_initials}</div>
                    <div class="user-details">
                        <h6>${user.nama_lengkap}</h6>
                        <small>${user.email}</small>
                    </div>
                </div>
            </td>
            <td>
                <span class="badge badge-role ${getRoleClass(user.role)}">${user.role}</span>
            </td>
            <td>
                <span class="badge badge-status ${getStatusClass(user.status)}">${user.status}</span>
            </td>
            <td>
                <div>${user.last_login}</div>
                <small class="text-muted">${user.last_login_time}</small>
            </td>
            <td>${user.created_at}</td>
            <td>
                <div class="dropdown">
                    <button class="action-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#" onclick="editUser(${user.id})">
                                <i class="bi bi-pencil me-2"></i>
                                Edit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="viewUser(${user.id})">
                                <i class="bi bi-eye me-2"></i>
                                Lihat
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="deleteUser(${user.id}, '${user.nama_lengkap}')">
                                <i class="bi bi-trash me-2"></i>
                                Hapus
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    `).join('');
}

/**
 * Submit add user form
 */
function submitAddUser() {
    console.log('📝 Submitting add user form...');
    
    const form = document.getElementById('addUserForm');
    if (!form) {
        console.error('❌ Add user form not found');
        return;
    }
    
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Show loading state
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    }
    
    clearFormErrors();

    // Simulate form submission
    setTimeout(() => {
        const userData = {
            id: users.length + 1,
            nama_lengkap: formData.get('nama_lengkap'),
            email: formData.get('email'),
            role: formData.get('role'),
            status: formData.get('status'),
            last_login: '-',
            last_login_time: 'Belum login',
            created_at: formatDate(new Date()),
            avatar_initials: getInitials(formData.get('nama_lengkap'))
        };

        // Add to users array
        users.push(userData);
        
        // Show success message
        showToast('User berhasil ditambahkan!', 'success');
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
        if (modal) {
            modal.hide();
        }
        
        // Refresh table
        filterUsers();
        
        console.log('✅ User added successfully');
        
        // Reset button state
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-plus-lg me-2"></i>Tambah User';
        }
    }, 1000);
}

/**
 * Edit user
 */
function editUser(userId) {
    console.log(`✏️ Editing user ID: ${userId}`);
    const user = users.find(u => u.id === userId);
    if (user) {
        showToast(`Edit user: ${user.nama_lengkap}`, 'info');
    }
}

/**
 * View user
 */
function viewUser(userId) {
    console.log(`👁️ Viewing user ID: ${userId}`);
    const user = users.find(u => u.id === userId);
    if (user) {
        showToast(`Lihat detail: ${user.nama_lengkap}`, 'info');
    }
}

/**
 * Delete user
 */
function deleteUser(userId, userName) {
    if (!confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?`)) {
        return;
    }

    console.log(`🗑️ Deleting user ID: ${userId}`);

    // Remove from users array
    users = users.filter(u => u.id !== userId);
    
    showToast(`User ${userName} berhasil dihapus!`, 'success');
    
    // Refresh table
    filterUsers();
    
    console.log('✅ User deleted successfully');
}

/**
 * Utility Functions
 */

// Get role CSS class
function getRoleClass(role) {
    const roleClasses = {
        'Super Admin': 'badge-super-admin',
        'Admin': 'badge-admin',
        'Pustakawan': 'badge-pustakawan',
        'Staff': 'badge-staff'
    };
    return roleClasses[role] || 'badge-staff';
}

// Get status CSS class
function getStatusClass(status) {
    const statusClasses = {
        'Aktif': 'badge-aktif',
        'Non-aktif': 'badge-nonaktif'
    };
    return statusClasses[status] || 'badge-nonaktif';
}

// Update user count
function updateUserCount() {
    const userCountElement = document.getElementById('userCount');
    if (userCountElement) {
        userCountElement.textContent = filteredUsers.length;
    }
}

// Get initials from name
function getInitials(name) {
    if (!name) return 'U';
    
    return name
        .split(' ')
        .map(word => word.charAt(0).toUpperCase())
        .join('')
        .substring(0, 2);
}

// Format date
function formatDate(date) {
    return date.toLocaleDateString('id-ID', {
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
window.UserManagement = {
    filterUsers,
    editUser,
    viewUser,
    deleteUser,
    showToast
};

console.log('📦 User Management JavaScript loaded successfully');