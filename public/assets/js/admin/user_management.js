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

    // Setup sync listeners
    setupSyncListeners();
}

/**
 * Setup sync listeners for real-time updates
 */
function setupSyncListeners() {
    if (window.userDataSync) {
        window.userDataSync.onSync(function(syncData) {
            console.log('🔄 Sync event received:', syncData.type);
            
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
    const existingIndex = users.findIndex(u => u.id === newUser.id);
    if (existingIndex === -1) {
        users.push(newUser);
        filterUsers();
        refreshChart();
        showToast('User baru ditambahkan dari halaman lain', 'info');
    }
}

/**
 * Handle user updated event
 */
function handleUserUpdated(updatedUser) {
    const userIndex = users.findIndex(u => u.id === updatedUser.id);
    if (userIndex !== -1) {
        users[userIndex] = updatedUser;
        filterUsers();
        refreshChart();
        showToast('User diperbarui dari halaman lain', 'info');
    }
}

/**
 * Handle user deleted event
 */
function handleUserDeleted(userId) {
    const userIndex = users.findIndex(u => u.id == userId);
    if (userIndex !== -1) {
        users.splice(userIndex, 1);
        filterUsers();
        refreshChart();
        showToast('User dihapus dari halaman lain', 'info');
    }
}

/**
 * Handle data refresh event
 */
function handleDataRefresh(newUsers) {
    if (newUsers && Array.isArray(newUsers)) {
        users = newUsers;
        filterUsers();
        refreshChart();
        console.log('🔄 Data refreshed from external source');
    }
}

/**
 * Load users from database or mock data with sync
 */
async function loadUsers() {
    console.log('📊 Loading users with sync...');
    
    try {
        // Use sync system if available
        if (window.userDataSync) {
            users = await window.userDataSync.loadUsers();
            console.log('✅ Users loaded via sync system');
        } else {
            // Fallback to direct API call
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
                <td colspan="5" class="text-center py-4">
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