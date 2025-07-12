/**
 * INLISLite v3.0 User Data Synchronization
 * Ensures data consistency between /admin/users and /admin/users-edit pages
 */

class UserDataSync {
    constructor() {
        this.storageKey = 'inlislite_users_data';
        this.lastUpdateKey = 'inlislite_users_last_update';
        this.syncEventName = 'userDataSync';
        
        // Initialize sync system
        this.init();
    }

    init() {
        console.log('🔄 Initializing User Data Sync...');
        
        // Listen for storage changes from other tabs/windows
        window.addEventListener('storage', (e) => {
            if (e.key === this.storageKey || e.key === this.lastUpdateKey) {
                this.handleExternalUpdate();
            }
        });

        // Listen for custom sync events
        window.addEventListener(this.syncEventName, (e) => {
            this.handleSyncEvent(e.detail);
        });

        console.log('✅ User Data Sync initialized');
    }

    /**
     * Get cached users data
     */
    getCachedUsers() {
        try {
            const data = localStorage.getItem(this.storageKey);
            return data ? JSON.parse(data) : null;
        } catch (error) {
            console.warn('⚠️ Error reading cached users:', error);
            return null;
        }
    }

    /**
     * Cache users data
     */
    setCachedUsers(users) {
        try {
            localStorage.setItem(this.storageKey, JSON.stringify(users));
            localStorage.setItem(this.lastUpdateKey, Date.now().toString());
            
            // Trigger sync event for other components on the same page
            this.triggerSyncEvent('dataUpdated', { users });
            
            console.log('💾 Users data cached successfully');
        } catch (error) {
            console.warn('⚠️ Error caching users:', error);
        }
    }

    /**
     * Get last update timestamp
     */
    getLastUpdate() {
        const timestamp = localStorage.getItem(this.lastUpdateKey);
        return timestamp ? parseInt(timestamp) : 0;
    }

    /**
     * Check if cached data is fresh (less than 5 minutes old)
     */
    isCachedDataFresh() {
        const lastUpdate = this.getLastUpdate();
        const fiveMinutes = 5 * 60 * 1000; // 5 minutes in milliseconds
        return (Date.now() - lastUpdate) < fiveMinutes;
    }

    /**
     * Load users with caching and sync
     */
    async loadUsers(forceRefresh = false) {
        console.log('📊 Loading users with sync...');

        // Try to use cached data if fresh and not forcing refresh
        if (!forceRefresh && this.isCachedDataFresh()) {
            const cachedUsers = this.getCachedUsers();
            if (cachedUsers) {
                console.log('✅ Using cached users data');
                return cachedUsers;
            }
        }

        // Fetch fresh data from server
        try {
            const response = await fetch('/admin/users/ajax/list', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                }
            });

            const result = await response.json();

            if (result.success && result.data) {
                const users = result.data.map(user => ({
                    ...user,
                    avatar_initials: this.getInitials(user.nama_lengkap),
                    last_login_formatted: this.formatLastLogin(user.last_login),
                    created_at_formatted: this.formatDate(user.created_at)
                }));

                // Cache the fresh data
                this.setCachedUsers(users);
                
                console.log('✅ Users loaded from server and cached');
                return users;
            } else {
                throw new Error('API response not successful');
            }
        } catch (error) {
            console.error('❌ Error loading users:', error);
            
            // Fallback to cached data even if stale
            const cachedUsers = this.getCachedUsers();
            if (cachedUsers) {
                console.log('⚠️ Using stale cached data due to error');
                return cachedUsers;
            }
            
            throw error;
        }
    }

    /**
     * Add user and sync
     */
    async addUser(userData) {
        try {
            const response = await fetch('/admin/users/ajax/create', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(userData)
            });

            const result = await response.json();

            if (result.success) {
                // Update cached data
                const cachedUsers = this.getCachedUsers() || [];
                const newUser = {
                    ...result.data,
                    avatar_initials: this.getInitials(result.data.nama_lengkap || result.data.nama_pengguna),
                    last_login_formatted: this.formatLastLogin(result.data.last_login),
                    created_at_formatted: this.formatDate(result.data.created_at)
                };
                
                cachedUsers.push(newUser);
                this.setCachedUsers(cachedUsers);
                
                // Trigger sync event
                this.triggerSyncEvent('userAdded', { user: newUser });
                
                console.log('✅ User added and synced');
                return result;
            }
            
            return result;
        } catch (error) {
            console.error('❌ Error adding user:', error);
            throw error;
        }
    }

    /**
     * Update user and sync
     */
    async updateUser(userId, userData) {
        try {
            const response = await fetch(`/admin/users/ajax/update/${userId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(userData)
            });

            const result = await response.json();

            if (result.success) {
                // Update cached data
                const cachedUsers = this.getCachedUsers() || [];
                const userIndex = cachedUsers.findIndex(u => u.id == userId);
                
                if (userIndex !== -1) {
                    cachedUsers[userIndex] = {
                        ...result.data,
                        avatar_initials: this.getInitials(result.data.nama_lengkap || result.data.nama_pengguna),
                        last_login_formatted: this.formatLastLogin(result.data.last_login),
                        created_at_formatted: this.formatDate(result.data.created_at)
                    };
                    
                    this.setCachedUsers(cachedUsers);
                    
                    // Trigger sync event
                    this.triggerSyncEvent('userUpdated', { user: cachedUsers[userIndex] });
                }
                
                console.log('✅ User updated and synced');
                return result;
            }
            
            return result;
        } catch (error) {
            console.error('❌ Error updating user:', error);
            throw error;
        }
    }

    /**
     * Delete user and sync
     */
    async deleteUser(userId) {
        try {
            const response = await fetch(`/admin/users/ajax/delete/${userId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                }
            });

            const result = await response.json();

            if (result.success) {
                // Update cached data
                const cachedUsers = this.getCachedUsers() || [];
                const updatedUsers = cachedUsers.filter(u => u.id != userId);
                this.setCachedUsers(updatedUsers);
                
                // Trigger sync event
                this.triggerSyncEvent('userDeleted', { userId });
                
                console.log('✅ User deleted and synced');
                return result;
            }
            
            return result;
        } catch (error) {
            console.error('❌ Error deleting user:', error);
            throw error;
        }
    }

    /**
     * Handle external updates (from other tabs/windows)
     */
    handleExternalUpdate() {
        console.log('🔄 External update detected, refreshing data...');
        this.triggerSyncEvent('externalUpdate', { 
            users: this.getCachedUsers(),
            timestamp: this.getLastUpdate()
        });
    }

    /**
     * Handle sync events
     */
    handleSyncEvent(detail) {
        console.log('🔄 Sync event received:', detail.type);
        
        // Notify any registered listeners
        if (window.userSyncListeners) {
            window.userSyncListeners.forEach(listener => {
                if (typeof listener === 'function') {
                    listener(detail);
                }
            });
        }
    }

    /**
     * Trigger sync event
     */
    triggerSyncEvent(type, data) {
        const event = new CustomEvent(this.syncEventName, {
            detail: { type, data, timestamp: Date.now() }
        });
        window.dispatchEvent(event);
    }

    /**
     * Register sync listener
     */
    onSync(callback) {
        if (!window.userSyncListeners) {
            window.userSyncListeners = [];
        }
        window.userSyncListeners.push(callback);
    }

    /**
     * Force refresh data from server
     */
    async forceRefresh() {
        console.log('🔄 Force refreshing user data...');
        return await this.loadUsers(true);
    }

    /**
     * Clear cached data
     */
    clearCache() {
        localStorage.removeItem(this.storageKey);
        localStorage.removeItem(this.lastUpdateKey);
        console.log('🗑️ User cache cleared');
    }

    // Utility methods
    getInitials(name) {
        if (!name) return 'U';
        return name
            .split(' ')
            .map(word => word.charAt(0).toUpperCase())
            .join('')
            .substring(0, 2);
    }

    formatLastLogin(lastLogin) {
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

    formatDate(dateString) {
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
}

// Create global instance
window.userDataSync = new UserDataSync();

console.log('📦 User Data Sync loaded successfully');