<?php

if (!function_exists('is_super_admin')) {
    /**
     * Check if current user is Super Admin
     */
    function is_super_admin(): bool
    {
        $session = \Config\Services::session();
        return $session->get('admin_role') === 'Super Admin';
    }
}

if (!function_exists('is_admin')) {
    /**
     * Check if current user is Admin or Super Admin
     */
    function is_admin(): bool
    {
        $session = \Config\Services::session();
        $role = $session->get('admin_role');
        return in_array($role, ['Super Admin', 'Admin']);
    }
}

if (!function_exists('is_librarian')) {
    /**
     * Check if current user is Librarian, Admin, or Super Admin
     */
    function is_librarian(): bool
    {
        $session = \Config\Services::session();
        $role = $session->get('admin_role');
        return in_array($role, ['Super Admin', 'Admin', 'Pustakawan']);
    }
}

if (!function_exists('can_edit_users')) {
    /**
     * Check if current user can edit users (only Super Admin)
     */
    function can_edit_users(): bool
    {
        return is_super_admin();
    }
}

if (!function_exists('can_view_users')) {
    /**
     * Check if current user can view users (all roles)
     */
    function can_view_users(): bool
    {
        $session = \Config\Services::session();
        return $session->get('admin_logged_in') === true;
    }
}

if (!function_exists('get_user_role')) {
    /**
     * Get current user's role
     */
    function get_user_role(): string
    {
        $session = \Config\Services::session();
        return $session->get('admin_role') ?? 'Guest';
    }
}

if (!function_exists('get_user_name')) {
    /**
     * Get current user's name
     */
    function get_user_name(): string
    {
        $session = \Config\Services::session();
        return $session->get('admin_name') ?? 'Unknown';
    }
}

if (!function_exists('get_user_id')) {
    /**
     * Get current user's ID
     */
    function get_user_id(): ?int
    {
        $session = \Config\Services::session();
        return $session->get('admin_id');
    }
}

if (!function_exists('has_permission')) {
    /**
     * Check if user has specific permission based on role
     */
    function has_permission(string $permission): bool
    {
        $role = get_user_role();
        
        $permissions = [
            'Super Admin' => [
                'user.create', 'user.read', 'user.update', 'user.delete',
                'patch.create', 'patch.read', 'patch.update', 'patch.delete',
                'app.create', 'app.read', 'app.update', 'app.delete',
                'demo.access', 'system.settings'
            ],
            'Admin' => [
                'user.read', 'patch.create', 'patch.read', 'patch.update', 'patch.delete',
                'app.create', 'app.read', 'app.update', 'app.delete',
                'demo.access'
            ],
            'Pustakawan' => [
                'user.read', 'patch.read', 'app.read', 'demo.access'
            ],
            'Staff' => [
                'user.read', 'patch.read', 'app.read', 'demo.access'
            ]
        ];
        
        return isset($permissions[$role]) && in_array($permission, $permissions[$role]);
    }
}

if (!function_exists('require_permission')) {
    /**
     * Require specific permission or redirect with error
     */
    function require_permission(string $permission, string $redirectUrl = '/admin/dashboard'): void
    {
        if (!has_permission($permission)) {
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You do not have permission to access this feature.');
            header("Location: $redirectUrl");
            exit;
        }
    }
}

if (!function_exists('role_badge_class')) {
    /**
     * Get Bootstrap badge class for user role
     */
    function role_badge_class(string $role): string
    {
        $classes = [
            'Super Admin' => 'bg-danger',
            'Admin' => 'bg-primary',
            'Pustakawan' => 'bg-success',
            'Staff' => 'bg-secondary'
        ];
        
        return $classes[$role] ?? 'bg-secondary';
    }
}