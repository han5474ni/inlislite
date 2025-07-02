<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class LoginController extends BaseController
{
    protected $userModel;
    protected $session;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }
    
    /**
     * Display login form
     */
    public function index()
    {
        // If already logged in, redirect to dashboard
        if ($this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/dashboard');
        }
        
        $data = [
            'title' => 'Admin Login - INLISLite v3',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/auth/login', $data);
    }
    
    /**
     * Process login form
     */
    public function authenticate()
    {
        // CSRF validation is handled by the global CSRF filter
        // No need for manual validation here
        
        // Validation rules
        $rules = [
            'username' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Username or Email is required',
                    'min_length' => 'Username or Email must be at least 3 characters',
                    'max_length' => 'Username or Email cannot exceed 255 characters'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 8 characters'
                ]
            ]
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $rememberMe = $this->request->getPost('remember_me');
        
        // Attempt to find user by username or email
        $user = $this->findUserByUsernameOrEmail($username);
        
        if (!$user) {
            // Log failed login attempt
            log_message('warning', 'Failed login attempt for username/email: ' . $username . ' from IP: ' . $this->request->getIPAddress());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid username/email or password');
        }
        
        // Verify password
        if (!password_verify($password, $user['kata_sandi'])) {
            // Log failed login attempt
            log_message('warning', 'Failed login attempt for username/email: ' . $username . ' from IP: ' . $this->request->getIPAddress());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid username/email or password');
        }
        
        // Check if user is active
        if ($user['status'] !== 'Aktif') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Your account is not active. Please contact administrator.');
        }
        
        // Allow all users to access admin panel
        // Role-based restrictions will be handled in individual controllers
        // All authenticated users can access admin area
        
        // Login successful - create session
        $sessionData = [
            'admin_id' => $user['id'],
            'admin_username' => $user['nama_pengguna'],
            'admin_name' => $user['nama_lengkap'],
            'admin_email' => $user['email'],
            'admin_role' => $user['role'],
            'admin_logged_in' => true,
            'login_time' => time()
        ];
        
        $this->session->set($sessionData);
        
        // Update last login time
        $this->userModel->updateLastLogin($user['id']);
        
        // Handle remember me
        if ($rememberMe) {
            $this->setRememberMeCookie($user['id']);
        }
        
        // Log successful login
        log_message('info', 'Successful admin login for username/email: ' . $username . ' from IP: ' . $this->request->getIPAddress());
        
        // Redirect to admin dashboard
        $redirectTo = $this->session->getFlashdata('redirect_to') ?? '/admin/dashboard';
        
        return redirect()->to($redirectTo)->with('success', 'Welcome back, ' . $user['nama_lengkap'] . '!');
    }
    
    /**
     * Logout user
     */
    public function logout()
    {
        // Log logout
        $username = $this->session->get('admin_username');
        if ($username) {
            log_message('info', 'Admin logout for username: ' . $username);
        }
        
        // Remove remember me cookie
        $this->removeRememberMeCookie();
        
        // Destroy session
        $this->session->destroy();
        
        return redirect()->to('/admin/secure-login')->with('success', 'You have been logged out successfully');
    }
    
    /**
     * Display forgot password form
     */
    public function forgotPassword()
    {
        $data = [
            'title' => 'Forgot Password - INLISLite v3',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/auth/forgot_password', $data);
    }
    
    /**
     * Send password reset link
     */
    public function sendResetLink()
    {
        // CSRF validation is handled by the global CSRF filter
        
        $rules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address'
                ]
            ]
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }
        
        $email = $this->request->getPost('email');
        
        // Find user by email
        $user = $this->userModel->getUserByEmail($email);
        
        if (!$user) {
            // Don't reveal if email exists or not for security
            return redirect()->back()->with('success', 'If your email is registered, you will receive a password reset link shortly.');
        }
        
        // Allow password reset for all users (not just admins)
        // Generate reset token
        $resetToken = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Save reset token to database
        $resetData = [
            'reset_token' => password_hash($resetToken, PASSWORD_DEFAULT),
            'reset_token_expires' => $expiry
        ];
        
        $this->userModel->update($user['id'], $resetData);
        
        // Create reset link
        $resetLink = base_url("reset-password/{$resetToken}");
        
        // In production, you would send an actual email here
        log_message('info', "Password reset link for {$email}: {$resetLink}");
        
        // For development, show the link
        if (ENVIRONMENT === 'development') {
            $this->session->setFlashdata('reset_link', $resetLink);
        }
        
        return redirect()->back()->with('success', 'If your email is registered, you will receive a password reset link shortly.');
    }
    
    /**
     * Display password reset form
     */
    public function resetPassword($token)
    {
        // Find user with valid reset token
        $users = $this->userModel->findAll();
        $user = null;
        
        foreach ($users as $u) {
            if (isset($u['reset_token']) && 
                password_verify($token, $u['reset_token']) && 
                strtotime($u['reset_token_expires']) > time()) {
                $user = $u;
                break;
            }
        }
        
        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid or expired reset token.');
        }
        
        $data = [
            'title' => 'Reset Password - INLISLite v3',
            'token' => $token,
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/auth/reset_password', $data);
    }
    
    /**
     * Update password
     */
    public function updatePassword()
    {
        // CSRF validation is handled by the global CSRF filter
        
        $rules = [
            'token' => 'required',
            'password' => [
                'rules' => 'required|min_length[8]|validatePasswordComplexity',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 8 characters',
                    'validatePasswordComplexity' => 'Password does not meet complexity requirements'
                ]
            ],
            'password_confirm' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Password confirmation is required',
                    'matches' => 'Password confirmation does not match'
                ]
            ]
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }
        
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        
        // Check for weak passwords
        if ($this->isWeakPassword($password)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password is too weak. Please use a stronger password.');
        }
        
        // Find user with valid reset token
        $users = $this->userModel->findAll();
        $user = null;
        
        foreach ($users as $u) {
            if (isset($u['reset_token']) && 
                password_verify($token, $u['reset_token']) && 
                strtotime($u['reset_token_expires']) > time()) {
                $user = $u;
                break;
            }
        }
        
        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid or expired reset token.');
        }
        
        // Update password and clear reset token
        $updateData = [
            'kata_sandi' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_token_expires' => null
        ];
        
        $this->userModel->update($user['id'], $updateData);
        
        // Log password reset
        log_message('info', 'Password reset successful for user: ' . $user['nama_pengguna']);
        
        return redirect()->to('/admin/secure-login')->with('success', 'Password has been reset successfully. You can now login with your new password.');
    }
    
    /**
     * Check if password is weak/common
     */
    private function isWeakPassword(string $password): bool
    {
        $weakPasswords = [
            '123456', '123456789', 'qwerty', 'password', 'admin', 'administrator',
            '12345678', '111111', '123123', 'welcome', 'login', 'root',
            'toor', 'pass', '1234', '12345', 'admin123', 'password123',
            'qwerty123', 'abc123', '1q2w3e4r', 'iloveyou', 'welcome123'
        ];
        
        return in_array(strtolower($password), $weakPasswords);
    }
    
    /**
     * Set remember me cookie
     */
    private function setRememberMeCookie(int $userId): void
    {
        $token = bin2hex(random_bytes(32));
        $expiry = time() + (30 * 24 * 60 * 60); // 30 days
        
        setcookie('remember_token', $token, $expiry, '/', '', true, true);
    }
    
    /**
     * Remove remember me cookie
     */
    private function removeRememberMeCookie(): void
    {
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        }
    }
    
    /**
     * AJAX endpoint to check password strength
     */
    public function checkPasswordStrength()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Invalid request']);
        }
        
        $password = $this->request->getPost('password');
        
        if (empty($password)) {
            return $this->response->setJSON([
                'strength' => 0,
                'text' => 'Enter a password',
                'class' => 'text-muted'
            ]);
        }
        
        $score = $this->calculatePasswordStrength($password);
        
        $strengthLevels = [
            0 => ['text' => 'Very Weak', 'class' => 'text-danger'],
            1 => ['text' => 'Weak', 'class' => 'text-warning'],
            2 => ['text' => 'Fair', 'class' => 'text-info'],
            3 => ['text' => 'Good', 'class' => 'text-primary'],
            4 => ['text' => 'Strong', 'class' => 'text-success'],
            5 => ['text' => 'Very Strong', 'class' => 'text-success']
        ];
        
        return $this->response->setJSON([
            'strength' => $score,
            'text' => $strengthLevels[$score]['text'],
            'class' => $strengthLevels[$score]['class'],
            'percentage' => ($score / 5) * 100
        ]);
    }
    
    /**
     * Calculate password strength score
     */
    private function calculatePasswordStrength(string $password): int
    {
        $score = 0;
        
        // Length check
        if (strlen($password) >= 8) $score++;
        if (strlen($password) >= 12) $score++;
        
        // Character variety checks
        if (preg_match('/[a-z]/', $password)) $score++; // lowercase
        if (preg_match('/[A-Z]/', $password)) $score++; // uppercase
        if (preg_match('/[0-9]/', $password)) $score++; // numbers
        if (preg_match('/[@#$%^&*()[\]{}]/', $password)) $score++; // special chars
        
        // Penalty for common patterns
        if ($this->isWeakPassword($password)) $score = max(0, $score - 2);
        if (preg_match('/(.)\1{2,}/', $password)) $score = max(0, $score - 1); // repeated chars
        if (preg_match('/123|abc|qwe/i', $password)) $score = max(0, $score - 1); // sequences
        
        return min(5, max(0, $score - 1)); // Normalize to 0-5 scale
    }
    
    /**
     * Find user by username or email
     */
    private function findUserByUsernameOrEmail($identifier)
    {
        // Try to find by username first
        $user = $this->userModel->getUserByUsername($identifier);
        
        // If not found and identifier looks like email, try email lookup
        if (!$user && filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = $this->userModel->getUserByEmail($identifier);
        }
        
        return $user;
    }
}