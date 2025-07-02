<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SecureAuthController extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        helper(['form', 'url']);
    }

    /**
     * Display login page
     */
    public function login()
    {
        // Redirect if already logged in
        if ($this->session->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/dashboard'));
        }

        $data = [
            'title' => 'Login Admin - INLISLite v3.0'
        ];

        return view('admin/auth/secure_login', $data);
    }

    /**
     * Process login authentication
     */
    public function authenticate()
    {
        // CSRF validation is handled automatically by the global CSRF filter
        // No need for manual validation here

        // Validation rules
        $rules = [
            'username' => [
                'rules' => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'Username wajib diisi',
                    'min_length' => 'Username minimal 3 karakter',
                    'max_length' => 'Username maksimal 50 karakter'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi',
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Data yang dimasukkan tidak valid');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $rememberMe = $this->request->getPost('remember_me');

        // Rate limiting check
        if (!$this->checkRateLimit($username)) {
            return redirect()->back()->with('error', 'Terlalu banyak percobaan login. Coba lagi dalam 15 menit.');
        }

        try {
            // Get user from database
            $builder = $this->db->table('users');
            $user = $builder->groupStart()
                           ->where('nama_pengguna', $username)
                           ->orWhere('email', $username)
                           ->groupEnd()
                           ->where('status', 'Aktif')
                           ->get()
                           ->getRowArray();

            if (!$user) {
                $this->logFailedAttempt($username);
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Username atau password salah');
            }

            // Verify password with secure hashing
            if (!$this->verifyPassword($password, $user['kata_sandi'])) {
                $this->logFailedAttempt($username);
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Username atau password salah');
            }

            // Check if user has admin privileges
            if (!in_array($user['role'], ['Super Admin', 'Admin'])) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Anda tidak memiliki akses admin');
            }

            // Successful login
            $this->createUserSession($user, $rememberMe);
            $this->updateLastLogin($user['id']);
            $this->clearFailedAttempts($username);

            // Log successful login
            $this->logActivity($user['id'], 'login', 'User berhasil login');

            return redirect()->to(base_url('admin/dashboard'))
                           ->with('success', 'Selamat datang, ' . $user['nama_lengkap']);

        } catch (\Exception $e) {
            log_message('error', 'Login error: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $userId = $this->session->get('admin_user_id');
        
        if ($userId) {
            $this->logActivity($userId, 'logout', 'User berhasil logout');
        }

        // Destroy session
        $this->session->destroy();

        // Clear remember me cookie if exists
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }

        return redirect()->to(base_url('admin/secure-login'))
                       ->with('success', 'Anda telah berhasil logout');
    }

    /**
     * Verify password with secure hashing
     */
    private function verifyPassword($inputPassword, $hashedPassword)
    {
        // Support both new bcrypt and legacy MD5 passwords
        if (password_verify($inputPassword, $hashedPassword)) {
            return true;
        }

        // Legacy support for MD5 (upgrade to bcrypt on successful login)
        if (md5($inputPassword) === $hashedPassword) {
            // Upgrade to bcrypt
            $newHash = $this->hashPassword($inputPassword);
            $this->updatePasswordHash($hashedPassword, $newHash);
            return true;
        }

        return false;
    }

    /**
     * Hash password securely
     */
    public function hashPassword($password)
    {
        // Use bcrypt with cost factor 12 for security
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Validate password strength
     */
    public function validatePasswordStrength($password)
    {
        $errors = [];
        
        // Minimum length
        if (strlen($password) < 8) {
            $errors[] = 'Password minimal 8 karakter';
        }
        
        // Maximum length for security
        if (strlen($password) > 128) {
            $errors[] = 'Password maksimal 128 karakter';
        }
        
        // Lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password harus mengandung huruf kecil (a-z)';
        }
        
        // Uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password harus mengandung huruf besar (A-Z)';
        }
        
        // Number
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password harus mengandung angka (0-9)';
        }
        
        // Special character
        if (!preg_match('/[@#$%^&*()[\]{}]/', $password)) {
            $errors[] = 'Password harus mengandung karakter khusus (@#$%^&*()[]{}';
        }
        
        // Check for common weak passwords
        $weakPasswords = [
            'password', '123456', '123456789', 'qwerty', 'abc123',
            'password123', 'admin', 'administrator', '12345678',
            'welcome', 'login', 'root', 'toor', 'pass'
        ];
        
        foreach ($weakPasswords as $weak) {
            if (stripos($password, $weak) !== false) {
                $errors[] = 'Password terlalu umum dan mudah ditebak';
                break;
            }
        }
        
        // Check for repeated characters
        if (preg_match('/(.)\1{2,}/', $password)) {
            $errors[] = 'Password tidak boleh mengandung karakter berulang';
        }
        
        // Check for sequential characters
        if (preg_match('/123|abc|qwe/i', $password)) {
            $errors[] = 'Password tidak boleh mengandung urutan karakter';
        }
        
        return $errors;
    }

    /**
     * Calculate password strength score
     */
    public function calculatePasswordStrength($password)
    {
        $score = 0;
        $length = strlen($password);
        
        // Length score
        if ($length >= 8) $score += 1;
        if ($length >= 12) $score += 1;
        if ($length >= 16) $score += 1;
        
        // Character variety
        if (preg_match('/[a-z]/', $password)) $score += 1;
        if (preg_match('/[A-Z]/', $password)) $score += 1;
        if (preg_match('/[0-9]/', $password)) $score += 1;
        if (preg_match('/[@#$%^&*()[\]{}]/', $password)) $score += 1;
        
        // Penalty for common patterns
        if (preg_match('/(.)\1{2,}/', $password)) $score -= 1;
        if (preg_match('/123|abc|qwe/i', $password)) $score -= 1;
        
        // Penalty for dictionary words
        $weakPasswords = ['password', 'admin', 'login', 'welcome'];
        foreach ($weakPasswords as $weak) {
            if (stripos($password, $weak) !== false) {
                $score -= 2;
                break;
            }
        }
        
        return max(0, min(5, $score));
    }

    /**
     * Create user session
     */
    private function createUserSession($user, $rememberMe = false)
    {
        $sessionData = [
            'admin_id' => $user['id'],
            'admin_user_id' => $user['id'],
            'admin_username' => $user['nama_pengguna'],
            'admin_nama_lengkap' => $user['nama_lengkap'],
            'admin_name' => $user['nama_lengkap'],
            'admin_email' => $user['email'],
            'admin_role' => $user['role'],
            'admin_logged_in' => true,
            'login_time' => time(),
            'admin_login_time' => time()
        ];

        $this->session->set($sessionData);

        // Set remember me cookie if requested
        if ($rememberMe) {
            $token = bin2hex(random_bytes(32));
            $expiry = time() + (30 * 24 * 60 * 60); // 30 days
            
            setcookie('remember_token', $token, $expiry, '/', '', true, true);
            
            // Store token in database
            $this->storeRememberToken($user['id'], $token, $expiry);
        }
    }

    /**
     * Update last login timestamp
     */
    private function updateLastLogin($userId)
    {
        $builder = $this->db->table('users');
        $builder->where('id', $userId)
                ->update(['last_login' => date('Y-m-d H:i:s')]);
    }

    /**
     * Rate limiting check
     */
    private function checkRateLimit($username)
    {
        $cacheKey = 'login_attempts_' . md5($username . $this->request->getIPAddress());
        $cache = \Config\Services::cache();
        
        $attempts = $cache->get($cacheKey) ?: 0;
        
        // Allow max 5 attempts per 15 minutes
        return $attempts < 5;
    }

    /**
     * Log failed login attempt
     */
    private function logFailedAttempt($username)
    {
        $cacheKey = 'login_attempts_' . md5($username . $this->request->getIPAddress());
        $cache = \Config\Services::cache();
        
        $attempts = $cache->get($cacheKey) ?: 0;
        $cache->save($cacheKey, $attempts + 1, 900); // 15 minutes
        
        // Log to database
        $this->logActivity(null, 'failed_login', "Failed login attempt for username: {$username}");
    }

    /**
     * Clear failed attempts
     */
    private function clearFailedAttempts($username)
    {
        $cacheKey = 'login_attempts_' . md5($username . $this->request->getIPAddress());
        $cache = \Config\Services::cache();
        $cache->delete($cacheKey);
    }

    /**
     * Store remember me token
     */
    private function storeRememberToken($userId, $token, $expiry)
    {
        try {
            $builder = $this->db->table('user_tokens');
            $builder->insert([
                'user_id' => $userId,
                'token' => hash('sha256', $token),
                'type' => 'remember_me',
                'expires_at' => date('Y-m-d H:i:s', $expiry),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Failed to store remember token: ' . $e->getMessage());
        }
    }

    /**
     * Update password hash for legacy passwords
     */
    private function updatePasswordHash($oldHash, $newHash)
    {
        try {
            $builder = $this->db->table('users');
            $builder->where('kata_sandi', $oldHash)
                    ->update(['kata_sandi' => $newHash]);
        } catch (\Exception $e) {
            log_message('error', 'Failed to update password hash: ' . $e->getMessage());
        }
    }

    /**
     * Log user activity
     */
    private function logActivity($userId, $action, $description)
    {
        try {
            $builder = $this->db->table('activity_logs');
            $builder->insert([
                'user_id' => $userId,
                'action' => $action,
                'description' => $description,
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Create table if not exists
            $this->createActivityLogsTable();
        }
    }

    /**
     * Create activity logs table
     */
    private function createActivityLogsTable()
    {
        $forge = \Config\Database::forge();
        
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'action' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP'
            ]
        ];
        
        $forge->addField($fields);
        $forge->addPrimaryKey('id');
        $forge->addKey('user_id');
        $forge->addKey('action');
        $forge->addKey('created_at');
        
        try {
            $forge->createTable('activity_logs', true);
        } catch (\Exception $e) {
            log_message('error', 'Failed to create activity_logs table: ' . $e->getMessage());
        }
    }

    /**
     * AJAX endpoint for password strength check
     */
    public function checkPasswordStrength()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(404);
        }

        $password = $this->request->getPost('password');
        
        if (!$password) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Password tidak boleh kosong'
            ]);
        }

        $errors = $this->validatePasswordStrength($password);
        $strength = $this->calculatePasswordStrength($password);
        
        $strengthLevels = [
            0 => 'Sangat Lemah',
            1 => 'Lemah', 
            2 => 'Cukup',
            3 => 'Baik',
            4 => 'Kuat',
            5 => 'Sangat Kuat'
        ];

        return $this->response->setJSON([
            'success' => true,
            'strength' => $strength,
            'strength_text' => $strengthLevels[$strength],
            'errors' => $errors,
            'is_valid' => empty($errors) && $strength >= 3
        ]);
    }
}
?>