<?php
/**
 * Feature Access Helper
 * Provides functions to get and manage user feature access.
 *
 * File name must be feature_access_helper.php to be autoloaded by helper('feature_access').
 */

use CodeIgniter\Database\BaseConnection;

if (! function_exists('get_db')) {
    /**
     * Get DB connection (wrapper for readability in helpers)
     */
    function get_db(): BaseConnection
    {
        return \Config\Database::connect();
    }
}

if (! function_exists('get_user_features')) {
    /**
     * Get list of feature keys assigned to a user.
     * Returns empty array if user id invalid or table missing.
     *
     * @param int|null $userId
     * @return array<int, string>
     */
    function get_user_features(?int $userId): array
    {
        if (empty($userId)) {
            return [];
        }

        try {
            $db = get_db();
            $rows = $db->table('user_feature_access')
                ->select('feature')
                ->where('user_id', $userId)
                ->get()
                ->getResultArray();
            return array_values(array_filter(array_map(static function ($r) {
                return $r['feature'] ?? null;
            }, $rows)));
        } catch (\Throwable $e) {
            // Table may not exist yet or other DB issue
            log_message('warning', 'get_user_features error: ' . $e->getMessage());
            return [];
        }
    }
}

if (! function_exists('sync_user_feature_access')) {
    /**
     * Ensure default feature access by role for a user.
     * Safe no-op if table missing. Customize mapping as needed.
     */
    function sync_user_feature_access(int $userId, string $role): void
    {
        // Define default features per role; adjust to your needs
        $roleDefaults = [
            'Super Admin' => ['tentang','patch','fitur','aplikasi','panduan','dukungan','bimbingan','demo','installer'],
            'Admin'       => ['tentang','patch','fitur','aplikasi','panduan','dukungan','bimbingan','demo'],
            'Pustakawan'  => ['tentang','fitur','aplikasi','panduan','dukungan','bimbingan','demo'],
            'Staff'       => ['tentang','panduan','dukungan','demo'],
        ];

        $defaults = $roleDefaults[$role] ?? [];
        if (empty($defaults)) {
            return;
        }

        try {
            $db = get_db();
            $tbl = $db->table('user_feature_access');

            // Upsert: clear and insert defaults (simple approach)
            $db->transStart();
            $tbl->where('user_id', $userId)->delete();
            $batch = [];
            foreach ($defaults as $f) {
                $batch[] = ['user_id' => $userId, 'feature' => $f];
            }
            if (! empty($batch)) {
                $tbl->insertBatch($batch);
            }
            $db->transComplete();
        } catch (\Throwable $e) {
            log_message('warning', 'sync_user_feature_access error: ' . $e->getMessage());
        }
    }
}