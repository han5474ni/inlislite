/**
 * INLISLite v3.0 Users Edit JavaScript
 * Modern user management with CRUD functionality
 */

$(document).ready(function() {
    console.log('🚀 Users Edit System Initializing...');
    
    // Initialize DataTable
    initializeDataTable();
    
    // Load users data
    loadUsers();
    
    // Update statistics
    updateStatistics();
    
    // Setup sync listeners
    setupSyncListeners();
    
    console.log('✅ Users Edit System Ready');
});

/**
 * Setup sync listeners for real-time updates
 */
function setupSyncListeners() {
    if (window.userDataSync) {
        window.userDataSync.onSync(function(syncData) {
            console.log('🔄 Sync event received in users-edit:', syncData.type);
            
            switch (syncData.type) {
                case 'userAdded':
                    handleUserAdded(syncData.data.user);
                    break;
                case 'userUpdated':
                    handleUserUpdated(syncData.data.user);
                    break;
                case 'userDeleted':
                    handleUserDeleted(syncData.data.userId);
                    break;
                case 'dataUpdated':
                case 'externalUpdate':
                    handleDataRefresh(syncData.data.users);
                    break;
            }
        });
    }
}

/**
 * Handle user added event
 */
function handleUserAdded(newUser) {
    // Add to local array if not already present
    const existingIndex = usersData.findIndex(u => u.id === newUser.id);
    if (existingIndex === -1) {
        usersData.push(newUser);
        populateTable(usersData);
        updateStatistics();
        showAlert('User baru ditambahkan dari halaman lain', 'info');
    }
}

/**
 * Handle user updated event
 */
function handleUserUpdated(updatedUser) {
    const userIndex = usersData.findIndex(u => u.id === updatedUser.id);
    if (userIndex !== -1) {
        usersData[userIndex] = updatedUser;
        populateTable(usersData);
        updateStatistics();
        showAlert('User diperbarui dari halaman lain', 'info');
    }
}

/**
 * Handle user deleted event
 */
function handleUserDeleted(userId) {
    const userIndex = usersData.findIndex(u => u.id == userId);
    if (userIndex !== -1) {
        usersData.splice(userIndex, 1);
        populateTable(usersData);
        updateStatistics();
        showAlert('User dihapus dari halaman lain', 'info');
    }
}

/**
 * Handle data refresh event
 */
function handleDataRefresh(newUsers) {
    if (newUsers && Array.isArray(newUsers)) {
        usersData = newUsers;
        populateTable(usersData);
        updateStatistics();
        console.log('🔄 Data refreshed from external source');
    }
}

let usersTable;
let usersData = [];

/**
 * Initialize DataTable
 */
function initializeDataTable() {
    usersTable = $('#usersTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[0, 'desc']],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            emptyTable: "Tidak ada data yang tersedia",
            zeroRecords: "Tidak ada data yang cocok"
        },
        columnDefs: [
            { orderable: false, targets: [1, 8] }, // Avatar and Actions columns
            { className: "text-center", targets: [0, 1, 6, 7] }
        ]
    });
}

/**
 * Load users from database with sync
 */
async function loadUsers() {
    showLoading();
    
    try {
        // Use sync system if available
        if (window.userDataSync) {
            usersData = await window.userDataSync.loadUsers();
            console.log('✅ Users loaded via sync system:', usersData.length);
        } else {
            // Fallback to direct API call
            const response = await fetch(`${window.baseUrl || ''}/admin/users/ajax/list`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                }
            });
            
            const result = await response.json();
            
            if (result.success && result.data) {
                usersData = result.data;
                console.log('✅ Users loaded successfully:', usersData.length);
            } else {
                console.warn('⚠️ No users data received, loading mock data');
                loadMockData();
            }
        }
        
        populateTable(usersData);
        updateStatistics();
    } catch (error) {
        console.error('❌ Error loading users:', error);
        showAlert('Error loading users: ' + error.message, 'danger');
        loadMockData();
    } finally {
        hideLoading();
    }
}

/**
 * Load mock data for testing
 */
function loadMockData() {
    usersData = [
        {
            id: 1,
            nama_lengkap: 'System Administrator',
            nama_pengguna: 'admin',
            email: 'admin@inlislite.local',
            role: 'Super Admin',
            status: 'Aktif',
            last_login: '2025-01-12 14:00:00',
            created_at: '2024-01-15 10:00:00',
            avatar: null,
            avatar_url: null
        },
        {
            id: 2,
            nama_lengkap: 'Test Pustakawan',
            nama_pengguna: 'pustakawan',
            email: 'pustakawan@inlislite.local',
            role: 'Pustakawan',
            status: 'Aktif',
            last_login: '2025-01-11 16:30:00',
            created_at: '2024-02-10 09:15:00',
            avatar: null,
            avatar_url: null
        },
        {
            id: 3,
            nama_lengkap: 'Test Staff',
            nama_pengguna: 'staff',
            email: 'staff@inlislite.local',
            role: 'Staff',
            status: 'Non-Aktif',
            last_login: null,
            created_at: '2024-03-05 11:20:00',
            avatar: null,
            avatar_url: null
        }
    ];
    
    populateTable(usersData);
    updateStatistics();
    console.log('✅ Mock data loaded');
}

/**
 * Populate DataTable with users data with auto-renumbering IDs
 */
function populateTable(data) {
    // Clear existing data
    usersTable.clear();
    
    // Sort data by creation date to ensure consistent ordering
    const sortedData = [...data].sort((a, b) => {
        const dateA = new Date(a.created_at || '1970-01-01');
        const dateB = new Date(b.created_at || '1970-01-01');
        return dateA - dateB;
    });
    
    // Add new data with sequential IDs
    sortedData.forEach((user, index) => {
        const sequentialId = index + 1; // Start from 1
        const avatar = user.avatar_url ? 
            `<img src="${user.avatar_url}" alt="${escapeHtml(user.nama_lengkap)}" />` : 
            getInitials(user.nama_lengkap);
        const roleClass = getRoleClass(user.role);
        const statusClass = getStatusClass(user.status);
        const lastLogin = formatLastLogin(user.last_login);
        
        usersTable.row.add([
            sequentialId, // Use sequential ID instead of database ID
            `<div class="user-avatar">${avatar}</div>`,
            escapeHtml(user.nama_lengkap),
            escapeHtml(user.nama_pengguna),
            escapeHtml(user.email),
            `<span class="role-badge ${roleClass}">${escapeHtml(user.role)}</span>`,
            `<span class="status-badge ${statusClass}">${escapeHtml(user.status)}</span>`,
            lastLogin,
            `
                <button class="btn-action edit" onclick="editUser(${user.id})" title="Edit" data-user-id="${user.id}">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-action delete" onclick="deleteUser(${user.id}, '${escapeHtml(user.nama_lengkap)}')" title="Delete" data-user-id="${user.id}">
                    <i class="bi bi-trash"></i>
                </button>
            `
        ]);
    });
    
    // Redraw table
    usersTable.draw();
    
    console.log(`📊 Table populated with ${sortedData.length} users (IDs renumbered 1-${sortedData.length})`);
}

/**
 * Update statistics cards
 */
function updateStatistics() {
    const totalUsers = usersData.length;
    const activeUsers = usersData.filter(user => user.status === 'Aktif').length;
    const adminUsers = usersData.filter(user => ['Super Admin', 'Admin'].includes(user.role)).length;
    
    // Recent users (created in last 30 days)
    const thirtyDaysAgo = new Date();
    thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
    const recentUsers = usersData.filter(user => {
        if (!user.created_at) return false;
        const createdDate = new Date(user.created_at);
        return createdDate >= thirtyDaysAgo;
    }).length;
    
    // Update DOM elements
    document.getElementById('totalUsers').textContent = totalUsers;
    document.getElementById('activeUsers').textContent = activeUsers;
    document.getElementById('adminUsers').textContent = adminUsers;
    document.getElementById('recentUsers').textContent = recentUsers;
}

/**
 * Save new user
 */
async function saveUser() {
    const form = document.getElementById('addUserForm');
    const formData = {
        nama_lengkap: document.getElementById('userNamaLengkap').value.trim(),
        nama_pengguna: document.getElementById('userNamaPengguna').value.trim(),
        email: document.getElementById('userEmail').value.trim(),
        password: document.getElementById('userPassword').value,
        role: document.getElementById('userRole').value,
        status: document.getElementById('userStatus').value
    };
    
    // Validate form
    if (!validateUserForm(formData)) {
        return;
    }
    
    showLoading();
    
    try {
        // Prepare request data with CSRF token
        let requestData = { ...formData };
        
        // Add CSRF token - try multiple methods
        if (window.csrfHash) {
            requestData.csrf_test_name = window.csrfHash;
        } else if (typeof getCSRFData === 'function') {
            try {
                const csrfData = getCSRFData();
                requestData = { ...formData, ...csrfData };
            } catch (e) {
                console.warn('CSRF function failed:', e);
            }
        }
        
        console.log('🔄 Sending user data:', requestData);
        
        const response = await fetch(`${window.baseUrl || ''}/admin/users/ajax/create`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestData)
        });
        
        console.log('📡 Response status:', response.status, response.statusText);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        console.log('📥 Response data:', result);
        
        if (result.success) {
            // Update CSRF hash if provided
            if (typeof updateCSRFHash === 'function') {
                updateCSRFHash(result);
            }
            
            // Add to local data
            const newUser = {
                id: result.data?.id || Date.now(),
                ...formData,
                created_at: new Date().toISOString(),
                last_login: null
            };
            
            usersData.push(newUser);
            populateTable(usersData);
            updateStatistics();
            
            // Update sync cache if available
            if (window.userDataSync) {
                window.userDataSync.setCachedUsers(usersData);
            }
            
            // Close modal and reset form
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            if (modal) {
                modal.hide();
            }
            form.reset();
            
            showAlert(result.message || 'User berhasil ditambahkan!', 'success');
            console.log('✅ User added successfully');
        } else {
            const errorMessage = result.errors ? 
                Object.values(result.errors).join('<br>') : 
                (result.message || 'Gagal menambahkan user');
            showAlert(errorMessage, 'danger');
            console.error('❌ Server error:', result);
        }
    } catch (error) {
        console.error('❌ Error adding user:', error);
        showAlert('Error menambahkan user: ' + error.message, 'danger');
    } finally {
        hideLoading();
    }
}

/**
 * Edit user
 */
function editUser(userId) {
    const user = usersData.find(u => u.id == userId);
    if (!user) {
        showAlert('User tidak ditemukan', 'danger');
        return;
    }
    
    // Populate edit form
    document.getElementById('editId').value = user.id;
    document.getElementById('editNamaLengkap').value = user.nama_lengkap;
    document.getElementById('editNamaPengguna').value = user.nama_pengguna;
    document.getElementById('editEmail').value = user.email;
    document.getElementById('editPassword').value = ''; // Always empty for security
    document.getElementById('editRole').value = user.role;
    document.getElementById('editStatus').value = user.status;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
    
    console.log('✏️ Editing user:', user.nama_lengkap);
}

/**
 * Update user
 */
async function updateUser() {
    const userId = document.getElementById('editId').value;
    const formData = {
        nama_lengkap: document.getElementById('editNamaLengkap').value.trim(),
        nama_pengguna: document.getElementById('editNamaPengguna').value.trim(),
        email: document.getElementById('editEmail').value.trim(),
        password: document.getElementById('editPassword').value,
        role: document.getElementById('editRole').value,
        status: document.getElementById('editStatus').value
    };
    
    // Validate form
    if (!validateUserForm(formData, true)) {
        return;
    }
    
    showLoading();
    
    try {
        // Make request (CSRF handling optional)
        let requestData = { ...formData };
        
        // Add CSRF token if available
        if (typeof getCSRFData === 'function') {
            try {
                const csrfData = getCSRFData();
                requestData = { ...formData, ...csrfData };
            } catch (e) {
                console.warn('CSRF token not available, proceeding without it');
            }
        }
        
        const response = await fetch(`${window.baseUrl || ''}/admin/users/ajax/update/${userId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Update CSRF hash
            updateCSRFHash(result);
            
            // Update local data
            const userIndex = usersData.findIndex(u => u.id == userId);
            if (userIndex !== -1) {
                usersData[userIndex] = { ...usersData[userIndex], ...formData };
                populateTable(usersData);
                updateStatistics();
            }
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
            if (modal) {
                modal.hide();
            }
            
            showAlert(result.message || 'User berhasil diperbarui!', 'success');
            console.log('✅ User updated successfully');
        } else {
            const errorMessage = result.errors ? 
                Object.values(result.errors).join('<br>') : 
                (result.message || 'Gagal memperbarui user');
            showAlert(errorMessage, 'danger');
        }
    } catch (error) {
        console.error('❌ Error updating user:', error);
        showAlert('Error memperbarui user: ' + error.message, 'danger');
    } finally {
        hideLoading();
    }
}

/**
 * Delete user
 */
async function deleteUser(userId, userName) {
    if (!confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?`)) {
        return;
    }
    
    showLoading();
    
    try {
        // Add CSRF token
        const csrfData = getCSRFData();
        
        const response = await fetch(`${window.baseUrl || ''}/admin/users/ajax/delete/${userId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(csrfData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Update CSRF hash
            updateCSRFHash(result);
            
            // Remove from local data
            usersData = usersData.filter(u => u.id != userId);
            populateTable(usersData);
            updateStatistics();
            
            showAlert(result.message || `User "${userName}" berhasil dihapus!`, 'success');
            console.log('✅ User deleted successfully');
        } else {
            showAlert(result.message || 'Gagal menghapus user', 'danger');
        }
    } catch (error) {
        console.error('❌ Error deleting user:', error);
        showAlert('Error menghapus user: ' + error.message, 'danger');
    } finally {
        hideLoading();
    }
}

/**
 * Validate user form
 */
function validateUserForm(data, isEdit = false) {
    const errors = [];
    
    if (!data.nama_lengkap) errors.push('Nama lengkap wajib diisi');
    if (!data.nama_pengguna) errors.push('Username wajib diisi');
    if (!data.email) errors.push('Email wajib diisi');
    if (!isEdit && !data.password) errors.push('Password wajib diisi');
    if (!data.role) errors.push('Role wajib diisi');
    if (!data.status) errors.push('Status wajib diisi');
    
    // Email validation
    if (data.email && !isValidEmail(data.email)) {
        errors.push('Format email tidak valid');
    }
    
    // Password validation (only for new users or when password is provided)
    if (data.password && data.password.length > 0 && data.password.length < 6) {
        errors.push('Password minimal 6 karakter');
    }
    
    if (errors.length > 0) {
        showAlert(errors.join('<br>'), 'danger');
        return false;
    }
    
    return true;
}

/**
 * Get user initials for avatar
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
 * Get role CSS class
 */
function getRoleClass(role) {
    const roleClasses = {
        'Super Admin': 'super-admin',
        'Admin': 'admin',
        'Pustakawan': 'pustakawan',
        'Staff': 'staff'
    };
    return roleClasses[role] || 'staff';
}

/**
 * Get status CSS class
 */
function getStatusClass(status) {
    const statusClasses = {
        'Aktif': 'aktif',
        'Non-Aktif': 'non-aktif'
    };
    return statusClasses[status] || 'non-aktif';
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
            return `${diffDays} hari lalu`;
        } else if (diffHours > 0) {
            return `${diffHours} jam lalu`;
        } else {
            return 'Baru saja';
        }
    } catch (error) {
        return 'Belum pernah';
    }
}

/**
 * Validate email format
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
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
 * Show loading spinner
 */
function showLoading() {
    document.getElementById('loadingSpinner').style.display = 'block';
}

/**
 * Hide loading spinner
 */
function hideLoading() {
    document.getElementById('loadingSpinner').style.display = 'none';
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <div>${message}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert at the top of main content
    const mainContent = document.querySelector('.main-content .container');
    mainContent.insertBefore(alertDiv, mainContent.firstChild);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

/**
 * Get CSRF data for requests
 */
function getCSRFData() {
    return {
        "csrf_test_name": window.csrfHash
    };
}

/**
 * Update CSRF hash after successful requests
 */
function updateCSRFHash(response) {
    if (response && response.csrf_hash) {
        window.csrfHash = response.csrf_hash;
        const metaTag = document.querySelector('meta[name="csrf-hash"]');
        if (metaTag) {
            metaTag.setAttribute('content', response.csrf_hash);
        }
    }
}

console.log('📦 Users Edit JavaScript loaded successfully');