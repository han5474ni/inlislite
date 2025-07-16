<?php

/**
 * Feature Access Helper
 * 
 * This helper contains functions for checking user feature access
 * based on the new feature access system.
 */

if (!function_exists('can_access_feature')) {
    /**
     * Check if a user can access a specific feature
     * 
     * @param string $feature The feature name to check
     * @param int|null $userId The user ID (if null, uses current session user)
     * @return bool
     */
    function can_access_feature($feature, $userId = null)
    {
        // If no user ID provided, use current session user
        if ($userId === null) {
            $userId = session('user_id');
        }
        
        // If no user logged in, deny access
        if (!$userId) {
            return false;
        }
        
        // Super Admin can access everything
        if (is_super_admin()) {
            return true;
        }
        
        // Connect to database
        $db = \Config\Database::connect();
        
        try {
            // Check if user has access to the feature
            $builder = $db->table('user_feature_access');
            $access = $builder->where('user_id', $userId)
                            ->where('feature', $feature)
                            ->get()
                            ->getRowArray();
            
            return !empty($access);
        } catch (\Exception $e) {
            log_message('error', 'Error checking feature access: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('get_user_features')) {
    /**
     * Get all features that a user has access to
     * 
     * @param int|null $userId The user ID (if null, uses current session user)
     * @return array Array of feature names
     */
    function get_user_features($userId = null)
    {
        // If no user ID provided, use current session user
        if ($userId === null) {
            $userId = session('user_id');
        }
        
        // If no user logged in, return empty array
        if (!$userId) {
            return [];
        }
        
        // Super Admin can access everything
        if (is_super_admin()) {
            return [
                'tentang', 'panduan', 'fitur', 'aplikasi', 
                'bimbingan', 'dukungan', 'demo', 'patch', 'installer'
            ];
        }
        
        // Connect to database
        $db = \Config\Database::connect();
        
        try {
            // Get all features user has access to
            $builder = $db->table('user_feature_access');
            $features = $builder->where('user_id', $userId)
                              ->get()
                              ->getResultArray();
            
            return array_column($features, 'feature');
        } catch (\Exception $e) {
            log_message('error', 'Error getting user features: ' . $e->getMessage());
            return [];
        }
    }
}

if (!function_exists('can_edit_feature')) {
    /**
     * Check if a user can edit a specific feature
     * (Only users with view access can edit, but not all edit pages)
     * 
     * @param string $feature The feature name to check
     * @param int|null $userId The user ID (if null, uses current session user)
     * @return bool
     */
    function can_edit_feature($feature, $userId = null)
    {
        // For now, if user can access the feature, they can edit it
        // But this can be extended to have separate edit permissions
        return can_access_feature($feature, $userId);
    }
}

if (!function_exists('is_super_admin')) {
    /**
     * Check if current user is Super Admin
     * 
     * @return bool
     */
    function is_super_admin()
    {
        return session('admin_role') === 'Super Admin';
    }
}

if (!function_exists('can_view_module')) {
    /**
     * Check if a user can view a specific module
     * 
     * @param string $module The module name to check
     * @param int|null $userId The user ID (if null, uses current session user)
     * @return bool
     */
    function can_view_module($module, $userId = null)
    {
        // If no user ID provided, use current session user
        if ($userId === null) {
            $userId = session('admin_id');
        }
        
        // If no user logged in, deny access
        if (!$userId) {
            return false;
        }
        
        // Super Admin can access everything
        if (is_super_admin()) {
            return true;
        }
        
        // Connect to database
        $db = \Config\Database::connect();
        
        try {
            // Check if user has access to the module
            $builder = $db->table('user_feature_access');
            $access = $builder->where('user_id', $userId)
                            ->where('feature', $module)
                            ->get()
                            ->getRowArray();
            
            return !empty($access);
        } catch (\Exception $e) {
            log_message('error', 'Error checking module access: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('sync_user_feature_access')) {
    /**
     * Synchronize user feature access when a user's role changes
     * 
     * @param int $userId The user ID
     * @param string $role The new role
     * @return bool
     */
    function sync_user_feature_access($userId, $role)
    {
        // Connect to database
        $db = \Config\Database::connect();
        
        try {
            // Clear existing access
            $db->table('user_feature_access')->where('user_id', $userId)->delete();
            
            // Define default feature access based on roles
            $rolePermissions = [
                'Super Admin' => ['tentang', 'panduan', 'fitur', 'aplikasi', 'bimbingan', 'dukungan', 'demo', 'patch', 'installer'],
                'Admin' => ['tentang', 'panduan', 'fitur', 'aplikasi', 'bimbingan', 'dukungan', 'demo', 'patch'],
                'Pustakawan' => ['tentang', 'panduan', 'fitur', 'aplikasi', 'demo'],
                'Staff' => ['tentang', 'panduan', 'fitur', 'demo']
            ];
            
            $features = $rolePermissions[$role] ?? $rolePermissions['Staff'];
            
            // Insert new access records
            $accessData = [];
            foreach ($features as $feature) {
                $accessData[] = [
                    'user_id' => $userId,
                    'feature' => $feature
                ];
            }
            
            if (!empty($accessData)) {
                $db->table('user_feature_access')->insertBatch($accessData);
            }
            
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Error syncing user feature access: ' . $e->getMessage());
            return false;
        }
    }
}
