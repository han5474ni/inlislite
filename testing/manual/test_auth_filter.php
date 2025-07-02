<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Authentication Filter - INLISLite v3.0</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .test-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }
        
        .test-title {
            color: #667eea;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .test-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
        }
        
        .test-section h5 {
            color: #495057;
            margin-bottom: 1rem;
        }
        
        .test-link {
            display: block;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            text-decoration: none;
            color: #495057;
            transition: all 0.3s ease;
        }
        
        .test-link:hover {
            background: #e9ecef;
            color: #495057;
            text-decoration: none;
            transform: translateX(5px);
        }
        
        .test-link.protected {
            border-left: 4px solid #dc3545;
        }
        
        .test-link.public {
            border-left: 4px solid #28a745;
        }
        
        .test-link.demo {
            border-left: 4px solid #ffc107;
        }
        
        .status-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: 600;
        }
        
        .status-protected {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        .status-public {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        
        .status-demo {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1 class="test-title">
            <i class="bi bi-shield-check me-2"></i>
            Authentication Filter Test
        </h1>
        
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            <strong>Test Instructions:</strong> Click on the protected links below. They should redirect you to the secure login page instead of showing the admin content directly.
        </div>
        
        <!-- Protected Admin Routes -->
        <div class="test-section">
            <h5>
                <i class="bi bi-lock me-2"></i>
                Protected Admin Routes (Should Redirect to Login)
            </h5>
            
            <a href="/admin/dashboard" class="test-link protected">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</span>
                    <span class="status-badge status-protected">PROTECTED</span>
                </div>
            </a>
            
            <a href="/admin/users" class="test-link protected">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-people me-2"></i>User Management</span>
                    <span class="status-badge status-protected">PROTECTED</span>
                </div>
            </a>
            
            <a href="/admin/users/add-secure" class="test-link protected">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-person-plus me-2"></i>Add Secure User</span>
                    <span class="status-badge status-protected">PROTECTED</span>
                </div>
            </a>
            
            <a href="/dashboard" class="test-link protected">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-house me-2"></i>Legacy Dashboard</span>
                    <span class="status-badge status-protected">PROTECTED</span>
                </div>
            </a>
            
            <a href="/user-management" class="test-link protected">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-people me-2"></i>Legacy User Management</span>
                    <span class="status-badge status-protected">PROTECTED</span>
                </div>
            </a>
            
            <a href="/usermanagement" class="test-link protected">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-gear me-2"></i>User Management (Old)</span>
                    <span class="status-badge status-protected">PROTECTED</span>
                </div>
            </a>
        </div>
        
        <!-- Public Login Routes -->
        <div class="test-section">
            <h5>
                <i class="bi bi-unlock me-2"></i>
                Public Login Routes (Should Work Normally)
            </h5>
            
            <a href="/admin/secure-login" class="test-link public">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-shield-lock me-2"></i>Secure Login (Recommended)</span>
                    <span class="status-badge status-public">PUBLIC</span>
                </div>
            </a>
            
            <a href="/admin/login" class="test-link public">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-key me-2"></i>Standard Login</span>
                    <span class="status-badge status-public">PUBLIC</span>
                </div>
            </a>
            
            <a href="/loginpage" class="test-link public">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-box-arrow-in-right me-2"></i>Legacy Login</span>
                    <span class="status-badge status-public">PUBLIC</span>
                </div>
            </a>
            
            <a href="/admin/forgot-password" class="test-link public">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-question-circle me-2"></i>Forgot Password</span>
                    <span class="status-badge status-public">PUBLIC</span>
                </div>
            </a>
        </div>
        
        <!-- Demo Routes -->
        <div class="test-section">
            <h5>
                <i class="bi bi-play-circle me-2"></i>
                Demo Routes (Public for Testing)
            </h5>
            
            <a href="/modern-dashboard" class="test-link demo">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-layout-sidebar me-2"></i>Modern Dashboard Demo</span>
                    <span class="status-badge status-demo">DEMO</span>
                </div>
            </a>
            
            <a href="/user-management-demo" class="test-link demo">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-people me-2"></i>User Management Demo</span>
                    <span class="status-badge status-demo">DEMO</span>
                </div>
            </a>
        </div>
        
        <!-- Public Pages -->
        <div class="test-section">
            <h5>
                <i class="bi bi-globe me-2"></i>
                Public Pages (Should Work Normally)
            </h5>
            
            <a href="/" class="test-link public">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-house me-2"></i>Homepage</span>
                    <span class="status-badge status-public">PUBLIC</span>
                </div>
            </a>
            
            <a href="/tentang" class="test-link public">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-info-circle me-2"></i>About</span>
                    <span class="status-badge status-public">PUBLIC</span>
                </div>
            </a>
            
            <a href="/panduan" class="test-link public">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-book me-2"></i>Guide</span>
                    <span class="status-badge status-public">PUBLIC</span>
                </div>
            </a>
        </div>
        
        <!-- Test Results -->
        <div class="alert alert-warning">
            <h6><i class="bi bi-exclamation-triangle me-2"></i>Expected Behavior:</h6>
            <ul class="mb-0">
                <li><strong>Protected Routes</strong>: Should redirect to <code>/admin/secure-login</code> with error message</li>
                <li><strong>Public Routes</strong>: Should load normally without redirection</li>
                <li><strong>Demo Routes</strong>: Should load normally (for testing purposes)</li>
                <li><strong>After Login</strong>: Protected routes should be accessible</li>
            </ul>
        </div>
        
        <div class="text-center mt-4">
            <a href="/" class="btn btn-primary">
                <i class="bi bi-house me-2"></i>
                Back to Homepage
            </a>
            <a href="/admin/secure-login" class="btn btn-success">
                <i class="bi bi-shield-lock me-2"></i>
                Go to Secure Login
            </a>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Track clicks for testing
        document.querySelectorAll('.test-link').forEach(link => {
            link.addEventListener('click', function(e) {
                const url = this.href;
                const isProtected = this.classList.contains('protected');
                
                console.log('Testing URL:', url);
                console.log('Should redirect to login:', isProtected);
                
                // Add visual feedback
                this.style.background = '#e3f2fd';
                setTimeout(() => {
                    this.style.background = '';
                }, 1000);
            });
        });
        
        // Check if we came from a redirect
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('redirected') === 'true') {
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show';
            alert.innerHTML = `
                <i class="bi bi-check-circle me-2"></i>
                <strong>Success!</strong> You were redirected here from a protected route.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.test-container').insertBefore(alert, document.querySelector('.test-container').firstChild);
        }
    </script>
</body>
</html>