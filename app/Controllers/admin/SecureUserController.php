<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SecureUserController extends BaseController
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
     * Display add user form
     */
    public function addUser()
    {
        // Check if user is logged in and has admin privileges
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        $userRole = $this->session->get('admin_role');
        if (!in_array($userRole, ['Super Admin', 'Admin'])) {
            return redirect()->to(base_url('admin/dashboard'))
                           ->with('error', 'Anda tidak memiliki akses untuk menambah user');
        }

        $data = [
            'title' => 'Tambah User Baru - INLISLite v3.0'
        ];

        return view('admin/users_add', $data);
    }

    /**
     * Store new user with secure password validation
     */
    public function storeSecure()
    {
        // Check authentication and authorization
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        $userRole = $this->session->get('admin_role');
        if (!in_array($userRole, ['Super Admin', 'Admin'])) {
            return redirect()->to(base_url('admin/dashboard'))
                           ->with('error', 'Anda tidak memiliki akses untuk menambah user');
        }

        // Validate CSRF token
        if (!$this->validate(['csrf_token' => 'required'])) {
            return redirect()->back()->with('error', 'Token keamanan tidak valid');
        }

        // Comprehensive validation rules
        $rules = [
            'nama_lengkap' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi',
                    'min_length' => 'Nama lengkap minimal 3 karakter',
                    'max_length' => 'Nama lengkap maksimal 100 karakter'
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[3]|max_length[50]|alpha_numeric_punct|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username wajib diisi',
                    'min_length' => 'Username minimal 3 karakter',
                    'max_length' => 'Username maksimal 50 karakter',
                    'alpha_numeric_punct' => 'Username hanya boleh mengandung huruf, angka, dan tanda baca',
                    'is_unique' => 'Username sudah digunakan'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|max_length[100]|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi',
                    'valid_email' => 'Format email tidak valid',
                    'max_length' => 'Email maksimal 100 karakter',
                    'is_unique' => 'Email sudah digunakan'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[128]',
                'errors' => [
                    'required' => 'Password wajib diisi',
                    'min_length' => 'Password minimal 8 karakter',
                    'max_length' => 'Password maksimal 128 karakter'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi',
                    'matches' => 'Konfirmasi password tidak sama dengan password'
                ]
            ],
            'role' => [
                'rules' => 'required|in_list[Super Admin,Admin,Pustakawan,Staff]',
                'errors' => [
                    'required' => 'Role wajib dipilih',
                    'in_list' => 'Role tidak valid'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[Aktif,Non-Aktif]',
                'errors' => [
                    'required' => 'Status wajib dipilih',
                    'in_list' => 'Status tidak valid'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Data yang dimasukkan tidak valid. Silakan periksa kembali.');
        }

        $password = $this->request->getPost('password');

        // Advanced password strength validation
        $passwordErrors = $this->validatePasswordStrength($password);
        if (!empty($passwordErrors)) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Password tidak memenuhi kriteria keamanan: ' . implode(', ', $passwordErrors));
        }

        try {
            // Hash password securely
            $hashedPassword = $this->hashPassword($password);

            // Prepare user data
            $userData = [
                'nama_lengkap' => trim($this->request->getPost('nama_lengkap')),
                'username' => trim($this->request->getPost('username')),
                'email' => trim($this->request->getPost('email')),
                'password' => $hashedPassword,
                'role' => $this->request->getPost('role'),
                'status' => $this->request->getPost('status'),
                'created_at' => date('Y-m-d'),
                'last_login' => null
            ];

            // Insert user into database
            $builder = $this->db->table('users');
            $result = $builder->insert($userData);

            if ($result) {
                $newUserId = $this->db->insertID();
                
                // Log activity
                $this->logActivity(
                    $this->session->get('admin_user_id'),
                    'create_user',
                    "Created new user: {$userData['username']} ({$userData['nama_lengkap']})"
                );

                // Send notification email (optional)
                $this->sendWelcomeEmail($userData);

                return redirect()->to(base_url('admin/users'))
                               ->with('success', 'User baru berhasil ditambahkan dengan password yang aman');
            } else {
                throw new \Exception('Gagal menyimpan data user');
            }

        } catch (\Exception $e) {
            log_message('error', 'Error creating user: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Validate password strength with comprehensive rules
     */
    private function validatePasswordStrength($password)
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
        
        // Lowercase letter requirement
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password harus mengandung huruf kecil (a-z)';
        }
        
        // Uppercase letter requirement
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password harus mengandung huruf besar (A-Z)';
        }
        
        // Number requirement
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password harus mengandung angka (0-9)';
        }
        
        // Special character requirement
        if (!preg_match('/[@#$%^&*()[\]{}]/', $password)) {
            $errors[] = 'Password harus mengandung karakter khusus (@#$%^&*()[]{}';
        }
        
        // Check for common weak passwords
        $weakPasswords = [
            'password', '123456', '123456789', 'qwerty', 'abc123',
            'password123', 'admin', 'administrator', '12345678',
            'welcome', 'login', 'root', 'toor', 'pass', 'user',
            'guest', 'test', 'demo', 'sample', 'default'
        ];
        
        foreach ($weakPasswords as $weak) {
            if (stripos($password, $weak) !== false) {
                $errors[] = 'Password mengandung kata yang umum dan mudah ditebak';
                break;
            }
        }
        
        // Check for repeated characters (3 or more in a row)
        if (preg_match('/(.)\1{2,}/', $password)) {
            $errors[] = 'Password tidak boleh mengandung karakter berulang berturut-turut';
        }
        
        // Check for sequential characters
        $sequences = ['123', '234', '345', '456', '567', '678', '789', '890',
                     'abc', 'bcd', 'cde', 'def', 'efg', 'fgh', 'ghi', 'hij',
                     'qwe', 'wer', 'ert', 'rty', 'tyu', 'yui', 'uio', 'iop'];
        
        foreach ($sequences as $seq) {
            if (stripos($password, $seq) !== false) {
                $errors[] = 'Password tidak boleh mengandung urutan karakter berturut-turut';
                break;
            }
        }
        
        // Check for keyboard patterns
        $keyboardPatterns = ['qwerty', 'asdf', 'zxcv', '1234', 'abcd'];
        foreach ($keyboardPatterns as $pattern) {
            if (stripos($password, $pattern) !== false) {
                $errors[] = 'Password tidak boleh mengandung pola keyboard yang mudah ditebak';
                break;
            }
        }
        
        // Check if password is too similar to username or email
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        
        if ($username && stripos($password, $username) !== false) {
            $errors[] = 'Password tidak boleh mengandung username';
        }
        
        if ($email) {
            $emailParts = explode('@', $email);
            if (stripos($password, $emailParts[0]) !== false) {
                $errors[] = 'Password tidak boleh mengandung bagian dari email';
            }
        }
        
        return $errors;
    }

    /**
     * Hash password securely using bcrypt
     */
    private function hashPassword($password)
    {
        // Use bcrypt with cost factor 12 for security
        // Cost 12 provides good security while maintaining reasonable performance
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Calculate password strength score (0-5)
     */
    public function calculatePasswordStrength($password)
    {
        $score = 0;
        $length = strlen($password);
        
        // Length scoring
        if ($length >= 8) $score += 1;
        if ($length >= 12) $score += 1;
        if ($length >= 16) $score += 1;
        
        // Character variety scoring
        if (preg_match('/[a-z]/', $password)) $score += 1;
        if (preg_match('/[A-Z]/', $password)) $score += 1;
        if (preg_match('/[0-9]/', $password)) $score += 1;
        if (preg_match('/[@#$%^&*()[\]{}]/', $password)) $score += 1;
        
        // Bonus for multiple special characters
        if (preg_match_all('/[@#$%^&*()[\]{}]/', $password) > 1) $score += 1;
        
        // Penalty for common patterns
        if (preg_match('/(.)\1{2,}/', $password)) $score -= 1;
        if (preg_match('/123|abc|qwe/i', $password)) $score -= 1;
        
        // Penalty for dictionary words
        $weakPasswords = ['password', 'admin', 'login', 'welcome', 'user'];
        foreach ($weakPasswords as $weak) {
            if (stripos($password, $weak) !== false) {
                $score -= 2;
                break;
            }
        }
        
        return max(0, min(5, $score));
    }

    /**
     * AJAX endpoint for real-time password strength checking
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

        $requirements = [
            'length' => strlen($password) >= 8,
            'lowercase' => preg_match('/[a-z]/', $password),
            'uppercase' => preg_match('/[A-Z]/', $password),
            'number' => preg_match('/[0-9]/', $password),
            'special' => preg_match('/[@#$%^&*()[\]{}]/', $password)
        ];

        return $this->response->setJSON([
            'success' => true,
            'strength' => $strength,
            'strength_text' => $strengthLevels[$strength],
            'requirements' => $requirements,
            'errors' => $errors,
            'is_valid' => empty($errors) && $strength >= 3
        ]);
    }

    /**
     * Send welcome email to new user
     */
    private function sendWelcomeEmail($userData)
    {
        try {
            $email = \Config\Services::email();
            
            $email->setFrom('noreply@inlislite.com', 'INLISLite System');
            $email->setTo($userData['email']);
            $email->setSubject('Selamat Datang di INLISLite v3.0');
            
            $message = "
                <h2>Selamat Datang di INLISLite v3.0</h2>
                <p>Halo {$userData['nama_lengkap']},</p>
                <p>Akun Anda telah berhasil dibuat dengan detail berikut:</p>
                <ul>
                    <li><strong>Username:</strong> {$userData['username']}</li>
                    <li><strong>Email:</strong> {$userData['email']}</li>
                    <li><strong>Role:</strong> {$userData['role']}</li>
                    <li><strong>Status:</strong> {$userData['status']}</li>
                </ul>
                <p>Silakan login menggunakan username dan password yang telah diberikan.</p>
                <p>Terima kasih,<br>Tim INLISLite</p>
            ";
            
            $email->setMessage($message);
            $email->send();
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to send welcome email: ' . $e->getMessage());
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
            log_message('error', 'Failed to log activity: ' . $e->getMessage());
        }
    }

    /**
     * Generate secure random password
     */
    public function generateSecurePassword($length = 12)
    {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $special = '@#$%^&*()[]{}';
        
        $password = '';
        
        // Ensure at least one character from each category
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $special[random_int(0, strlen($special) - 1)];
        
        // Fill the rest randomly
        $allChars = $lowercase . $uppercase . $numbers . $special;
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }
        
        // Shuffle the password
        return str_shuffle($password);
    }

    /**
     * AJAX endpoint to generate secure password
     */
    public function generatePassword()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(404);
        }

        $length = $this->request->getPost('length') ?: 12;
        $length = max(8, min(32, (int)$length)); // Ensure length is between 8-32
        
        $password = $this->generateSecurePassword($length);
        $strength = $this->calculatePasswordStrength($password);
        $errors = $this->validatePasswordStrength($password);
        
        return $this->response->setJSON([
            'success' => true,
            'password' => $password,
            'strength' => $strength,
            'is_valid' => empty($errors)
        ]);
    }
}
?>