<?php

namespace App\Validation;

class CustomRules
{
    /**
     * Validate password complexity
     * 
     * @param string $str
     * @param string $fields
     * @param array $data
     * @return bool
     */
    public function validatePasswordComplexity(string $str, string $fields, array $data): bool
    {
        // Check minimum length
        if (strlen($str) < 8) {
            return false;
        }
        
        // Check for at least one lowercase letter
        if (!preg_match('/[a-z]/', $str)) {
            return false;
        }
        
        // Check for at least one uppercase letter
        if (!preg_match('/[A-Z]/', $str)) {
            return false;
        }
        
        // Check for at least one number
        if (!preg_match('/[0-9]/', $str)) {
            return false;
        }
        
        // Check for at least one special character
        if (!preg_match('/[@#$%^&*()[\]{}]/', $str)) {
            return false;
        }
        
        // Check against common weak passwords
        $weakPasswords = [
            '123456', '123456789', 'qwerty', 'password', 'admin', 'administrator',
            '12345678', '111111', '123123', 'welcome', 'login', 'root',
            'toor', 'pass', '1234', '12345', 'admin123', 'password123',
            'qwerty123', 'abc123', '1q2w3e4r', 'iloveyou', 'welcome123'
        ];
        
        if (in_array(strtolower($str), $weakPasswords)) {
            return false;
        }
        
        // Check for repeated characters (more than 2 in a row)
        if (preg_match('/(.)\1{2,}/', $str)) {
            return false;
        }
        
        // Check for common sequences
        if (preg_match('/123|abc|qwe|asd|zxc/i', $str)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Validate username format
     * 
     * @param string $str
     * @param string $fields
     * @param array $data
     * @return bool
     */
    public function validateUsername(string $str, string $fields, array $data): bool
    {
        // Username should contain only alphanumeric characters, underscores, and hyphens
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $str)) {
            return false;
        }
        
        // Username should not start with a number
        if (preg_match('/^[0-9]/', $str)) {
            return false;
        }
        
        // Username should not be a reserved word
        $reservedWords = [
            'admin', 'administrator', 'root', 'system', 'user', 'guest',
            'test', 'demo', 'api', 'www', 'mail', 'ftp', 'null', 'undefined'
        ];
        
        if (in_array(strtolower($str), $reservedWords)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Check if user exists and is active
     * 
     * @param string $str
     * @param string $fields
     * @param array $data
     * @return bool
     */
    public function validateActiveUser(string $str, string $fields, array $data): bool
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->getUserByUsername($str);
        
        if (!$user) {
            return false;
        }
        
        return $user['status'] === 'Aktif';
    }
    
    /**
     * Check if user has admin privileges
     * 
     * @param string $str
     * @param string $fields
     * @param array $data
     * @return bool
     */
    public function validateAdminUser(string $str, string $fields, array $data): bool
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->getUserByUsername($str);
        
        if (!$user) {
            return false;
        }
        
        return in_array($user['role'], ['Super Admin', 'Admin']);
    }
    
    /**
     * Rate limiting validation (simple implementation)
     * 
     * @param string $str
     * @param string $fields
     * @param array $data
     * @return bool
     */
    public function validateRateLimit(string $str, string $fields, array $data): bool
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        
        $ip = $request->getIPAddress();
        $key = 'login_attempts_' . $ip;
        
        $attempts = $session->get($key) ?? 0;
        $maxAttempts = 5;
        $timeWindow = 15 * 60; // 15 minutes
        
        if ($attempts >= $maxAttempts) {
            $lastAttempt = $session->get($key . '_time') ?? 0;
            if ((time() - $lastAttempt) < $timeWindow) {
                return false;
            } else {
                // Reset attempts after time window
                $session->remove($key);
                $session->remove($key . '_time');
            }
        }
        
        return true;
    }
    
    /**
     * Validate URL with http/https protocol
     * 
     * @param string $str
     * @param string $fields
     * @param array $data
     * @return bool
     */
    public function valid_url_http(string $str, string $fields, array $data): bool
    {
        if (empty($str)) {
            return true; // Empty URLs are valid if the field is optional
        }
        
        // Check if URL has http:// or https:// protocol
        if (!preg_match('/^https?:\/\//i', $str)) {
            // Try to prepend http:// and validate
            $str = 'http://' . $str;
        }
        
        return filter_var($str, FILTER_VALIDATE_URL) !== false;
    }
}