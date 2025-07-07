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

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';

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
        return $this->select('activity_log.*, profile.nama, profile.username')
                   ->join('profile', 'profile.id = activity_log.user_id', 'left')
                   ->orderBy('activity_log.created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
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
}