<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    public function run()
    {
        // Get a sample user ID (try user with ID 11 first, then 1)
        $userBuilder = $this->db->table('users');
        $user = $userBuilder->where('id', 11)->get()->getRowArray();
        
        if (!$user) {
            // If no user with ID 11, try user with ID 1
            $user = $userBuilder->where('id', 1)->get()->getRowArray();
        }
        
        if (!$user) {
            // If no user with ID 1, get the first user
            $user = $userBuilder->limit(1)->get()->getRowArray();
        }
        
        if (!$user) {
            echo "No users found. Please create a user first.\n";
            return;
        }
        
        $userId = $user['id'];
        
        // Sample activity data
        $activities = [
            [
                'user_id' => $userId,
                'action' => 'login',
                'description' => 'User logged into the system',
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'old_data' => null,
                'new_data' => json_encode(['login_time' => date('Y-m-d H:i:s')]),
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            ],
            [
                'user_id' => $userId,
                'action' => 'profile_access',
                'description' => 'User accessed profile page',
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'old_data' => null,
                'new_data' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour 45 minutes')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 hour 45 minutes')),
            ],
            [
                'user_id' => $userId,
                'action' => 'profile_update',
                'description' => 'User updated profile information',
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'old_data' => json_encode([
                    'nama_lengkap' => 'Old Name',
                    'email' => 'old@example.com'
                ]),
                'new_data' => json_encode([
                    'nama_lengkap' => $user['nama_lengkap'] ?? 'New Name',
                    'email' => $user['email'] ?? 'new@example.com'
                ]),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour 30 minutes')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 hour 30 minutes')),
            ],
            [
                'user_id' => $userId,
                'action' => 'password_change',
                'description' => 'User changed password',
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'old_data' => null,
                'new_data' => json_encode(['password_changed' => true]),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            ],
            [
                'user_id' => $userId,
                'action' => 'system_access',
                'description' => 'User accessed system settings',
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'old_data' => null,
                'new_data' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 minutes')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-30 minutes')),
            ],
            [
                'user_id' => $userId,
                'action' => 'logout',
                'description' => 'User logged out from the system',
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'old_data' => null,
                'new_data' => json_encode(['logout_time' => date('Y-m-d H:i:s')]),
                'created_at' => date('Y-m-d H:i:s', strtotime('-15 minutes')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-15 minutes')),
            ],
            // Yesterday's activities
            [
                'user_id' => $userId,
                'action' => 'login',
                'description' => 'User logged into the system',
                'ip_address' => '192.168.1.101',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'old_data' => null,
                'new_data' => json_encode(['login_time' => date('Y-m-d H:i:s')]),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day -3 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day -3 hours')),
            ],
            [
                'user_id' => $userId,
                'action' => 'email_update',
                'description' => 'User updated email address',
                'ip_address' => '192.168.1.101',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'old_data' => json_encode(['email' => 'old@example.com']),
                'new_data' => json_encode(['email' => $user['email'] ?? 'new@example.com']),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day -2 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day -2 hours')),
            ],
            [
                'user_id' => $userId,
                'action' => 'logout',
                'description' => 'User logged out from the system',
                'ip_address' => '192.168.1.101',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'old_data' => null,
                'new_data' => json_encode(['logout_time' => date('Y-m-d H:i:s')]),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day -1 hour')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day -1 hour')),
            ],
        ];
        
        // Clear existing activity logs for this user (keep some existing data)
        // $this->db->table('activity_logs')->where('user_id', $userId)->delete();
        
        // Insert sample activities using direct query to avoid model timestamp issues
        foreach ($activities as $activity) {
            // Remove updated_at if it exists
            unset($activity['updated_at']);
            
            $this->db->table('activity_logs')->insert($activity);
        }
        
        echo "Activity log sample data created for user ID: {$userId}\n";
    }
}