<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id', 'action', 'description', 'ip_address', 
        'user_agent', 'old_data', 'new_data'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = null;

    /**
     * Log user activity
     */
    public function logActivity($userId, $action, $description, $oldData = null, $newData = null)
    {
        $request = \Config\Services::request();
        
        $data = [
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => $request->getIPAddress(),
            'user_agent' => $request->getUserAgent()->getAgentString(),
            'old_data' => $oldData ? json_encode($oldData) : null,
            'new_data' => $newData ? json_encode($newData) : null
        ];
        
        return $this->insert($data);
    }

    /**
     * Get user activities with pagination
     */
    public function getUserActivities($userId, $limit = 20, $offset = 0)
    {
        return $this->where('user_id', $userId)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit, $offset)
                   ->findAll();
    }

    /**
     * Get formatted user activities
     */
    public function getFormattedUserActivities($userId, $limit = 20, $offset = 0)
    {
        $activities = $this->getUserActivities($userId, $limit, $offset);
        
        foreach ($activities as &$activity) {
            // Format date
            $activity['created_at_formatted'] = $this->formatDate($activity['created_at']);
            
            // Decode JSON values
            if ($activity['old_data']) {
                $activity['old_data_decoded'] = json_decode($activity['old_data'], true);
            }
            if ($activity['new_data']) {
                $activity['new_data_decoded'] = json_decode($activity['new_data'], true);
            }
            
            // Add activity icon and color
            $activity['icon'] = $this->getActivityIcon($activity['action']);
            $activity['color'] = $this->getActivityColor($activity['action']);
        }
        
        return $activities;
    }

    /**
     * Get recent activities for all users (admin view)
     */
    public function getRecentActivities($limit = 50)
    {
        return $this->select('activity_logs.*, users.nama_lengkap, users.email')
                   ->join('users', 'users.id = activity_logs.user_id', 'left')
                   ->orderBy('activity_logs.created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }
    
    /**
     * Get logs with filters and pagination
     */
    public function getLogs($filters = [], $perPage = 15, $page = 1)
    {
        $builder = $this->db->table('activity_logs');
        $builder->select('activity_logs.*, users.nama_lengkap, users.email, users.nama_pengguna')
                ->join('users', 'users.id = activity_logs.user_id', 'left')
                ->orderBy('activity_logs.created_at', 'DESC');
        
        // Apply filters
        if (!empty($filters['date_from'])) {
            $builder->where('activity_logs.created_at >=', $filters['date_from'] . ' 00:00:00');
        }
        
        if (!empty($filters['date_to'])) {
            $builder->where('activity_logs.created_at <=', $filters['date_to'] . ' 23:59:59');
        }
        
        if (!empty($filters['activity_type'])) {
            $builder->where('activity_logs.action', $filters['activity_type']);
        }
        
        if (!empty($filters['user_id'])) {
            $builder->where('activity_logs.user_id', $filters['user_id']);
        }
        
        if (!empty($filters['search'])) {
            $builder->groupStart()
                    ->like('activity_logs.description', $filters['search'])
                    ->orLike('users.nama_lengkap', $filters['search'])
                    ->orLike('users.email', $filters['search'])
                    ->groupEnd();
        }
        
        // Pagination
        $offset = ($page - 1) * $perPage;
        $builder->limit($perPage, $offset);
        
        $logs = $builder->get()->getResultArray();
        
        // Format each log
        foreach ($logs as &$log) {
            $log['created_at_formatted'] = $this->formatDateDetailed($log['created_at']);
            $log['activity_icon'] = $this->getActivityIcon($log['action']);
            $log['activity_color'] = $this->getActivityColor($log['action']);
            $log['browser_info'] = $this->getBrowserInfo($log['user_agent']);
        }
        
        return $logs;
    }
    
    /**
     * Get total count of logs with filters
     */
    public function getLogsCount($filters = [])
    {
        $builder = $this->db->table('activity_logs');
        $builder->select('COUNT(*) as total')
                ->join('users', 'users.id = activity_logs.user_id', 'left');
        
        // Apply same filters as getLogs
        if (!empty($filters['date_from'])) {
            $builder->where('activity_logs.created_at >=', $filters['date_from'] . ' 00:00:00');
        }
        
        if (!empty($filters['date_to'])) {
            $builder->where('activity_logs.created_at <=', $filters['date_to'] . ' 23:59:59');
        }
        
        if (!empty($filters['activity_type'])) {
            $builder->where('activity_logs.action', $filters['activity_type']);
        }
        
        if (!empty($filters['user_id'])) {
            $builder->where('activity_logs.user_id', $filters['user_id']);
        }
        
        if (!empty($filters['search'])) {
            $builder->groupStart()
                    ->like('activity_logs.description', $filters['search'])
                    ->orLike('users.nama_lengkap', $filters['search'])
                    ->orLike('users.email', $filters['search'])
                    ->groupEnd();
        }
        
        $result = $builder->get()->getRowArray();
        return $result['total'] ?? 0;
    }
    
    /**
     * Get unique activity types for filter dropdown
     */
    public function getActivityTypes()
    {
        $builder = $this->db->table('activity_logs');
        $result = $builder->select('DISTINCT action')
                         ->where('action IS NOT NULL')
                         ->orderBy('action', 'ASC')
                         ->get()
                         ->getResultArray();
        
        return array_column($result, 'action');
    }

    /**
     * Get activity statistics
     */
    public function getActivityStats($userId = null, $days = 30)
    {
        $builder = $this->builder();
        
        if ($userId) {
            $builder->where('user_id', $userId);
        }
        
        $builder->where('created_at >=', date('Y-m-d H:i:s', strtotime("-{$days} days")));
        
        $stats = $builder->select('action, COUNT(*) as count')
                        ->groupBy('action')
                        ->get()
                        ->getResultArray();
        
        $result = [];
        foreach ($stats as $stat) {
            $result[$stat['action']] = $stat['count'];
        }
        
        return $result;
    }

    /**
     * Clean old activity logs
     */
    public function cleanOldLogs($days = 90)
    {
        $cutoffDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        return $this->where('created_at <', $cutoffDate)->delete();
    }

    /**
     * Format date for display
     */
    private function formatDate($dateString)
    {
        $date = new \DateTime($dateString);
        $now = new \DateTime();
        $diff = $now->diff($date);
        
        if ($diff->days == 0) {
            if ($diff->h == 0) {
                if ($diff->i == 0) {
                    return 'Baru saja';
                } else {
                    return $diff->i . ' menit yang lalu';
                }
            } else {
                return $diff->h . ' jam yang lalu';
            }
        } elseif ($diff->days == 1) {
            return 'Kemarin';
        } elseif ($diff->days < 7) {
            return $diff->days . ' hari yang lalu';
        } else {
            return $date->format('d M Y, H:i');
        }
    }

    /**
     * Get activity icon
     */
    private function getActivityIcon($action)
    {
        $icons = [
            'login' => 'bi-box-arrow-in-right',
            'logout' => 'bi-box-arrow-right',
            'profile_update' => 'bi-person-gear',
            'password_change' => 'bi-key',
            'photo_upload' => 'bi-camera',
            'profile_access' => 'bi-person-circle',
            'name_update' => 'bi-person-badge',
            'email_update' => 'bi-envelope-gear',
            'system_access' => 'bi-gear'
        ];
        
        return $icons[$action] ?? 'bi-activity';
    }

    /**
     * Get activity color
     */
    private function getActivityColor($action)
    {
        $colors = [
            'login' => 'success',
            'logout' => 'secondary',
            'profile_update' => 'primary',
            'password_change' => 'warning',
            'photo_upload' => 'info',
            'profile_access' => 'info',
            'name_update' => 'primary',
            'email_update' => 'primary',
            'system_access' => 'info'
        ];
        
        return $colors[$action] ?? 'secondary';
    }
    
    /**
     * Format date for detailed display
     */
    private function formatDateDetailed($dateString)
    {
        $date = new \DateTime($dateString);
        return $date->format('d M Y, H:i');
    }
    
    /**
     * Get browser info from user agent
     */
    private function getBrowserInfo($userAgent)
    {
        if (empty($userAgent)) {
            return 'Unknown Browser';
        }
        
        // Simple browser detection
        if (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            return 'Edge';
        } elseif (strpos($userAgent, 'Opera') !== false) {
            return 'Opera';
        } else {
            return 'Unknown Browser';
        }
    }
}
