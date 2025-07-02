# INLISLite v3 - Complete Login System Test Guide

## 🚀 Quick Setup

### 1. Database Setup
```bash
# First, create the basic users table and admin user
php create_test_admin.php

# Then, add password reset functionality
php update_database_for_reset.php
```

### 2. Start Server
```bash
# Using PHP built-in server
php spark serve --port=8080

# Or use your local server (XAMPP, Laragon, etc.)
# Access: http://localhost:8080/
```

## 🔄 Complete Login Flow Test

### Step 1: Homepage Access ✅
- **URL**: `http://localhost:8080/`
- **Expected**: Beautiful public homepage with INLISLite v3 branding
- **Action**: Scroll to footer and look for "Admin Login" button

### Step 2: Login Page Access ✅
- **Action**: Click "Admin Login" button in footer
- **URL**: `http://localhost:8080/loginpage`
- **Expected**: Modern login form with:
  - Username/Email field (supports both)
  - Password field with show/hide toggle
  - Real-time password strength meter
  - Remember me checkbox
  - "Forgot your password?" link

### Step 3: Test Login Authentication ✅

#### Valid Admin Login
```
Username/Email: admin
Password: Admin@123
Expected: Success → Redirect to http://localhost:8080/admin/dashboard
```

#### Email Login Test
```
Username/Email: admin@inlislite.local
Password: Admin@123
Expected: Success → Redirect to http://localhost:8080/admin/dashboard
```

#### Invalid Credentials Test
```
Username/Email: admin
Password: wrongpassword
Expected: Error → "Invalid username/email or password"
```

#### Non-Admin User Test
```
Username/Email: staff
Password: Staff@123
Expected: Error → "Access denied. Admin privileges required."
```

### Step 4: Forgot Password Flow ✅

#### Access Forgot Password
- **Action**: Click "Forgot your password?" on login page
- **URL**: `http://localhost:8080/forgot-password`
- **Expected**: Forgot password form

#### Send Reset Link
```
Email: admin@inlislite.local
Expected: Success message + reset link in development mode
```

#### Reset Password
- **Action**: Click the reset link (shown in development mode)
- **URL**: `http://localhost:8080/reset-password/{token}`
- **Expected**: Password reset form with:
  - New password field with strength meter
  - Confirm password field
  - Both fields have show/hide toggle

#### Complete Password Reset
```
New Password: NewAdmin@456
Confirm Password: NewAdmin@456
Expected: Success → Redirect to login with success message
```

#### Test New Password
```
Username/Email: admin
Password: NewAdmin@456
Expected: Success → Login with new password
```

### Step 5: Admin Dashboard ✅
- **URL**: `http://localhost:8080/admin/dashboard`
- **Expected**: Admin dashboard with:
  - Welcome message with user name
  - Navigation menu
  - Statistics cards
  - Quick actions
  - System information

### Step 6: Logout ✅
- **Action**: Click logout in dropdown menu
- **URL**: `http://localhost:8080/admin/logout`
- **Expected**: Redirect to login page with success message

## 🔐 Security Features Testing

### Password Complexity Validation
Test these passwords on login/reset forms:

| Password | Expected Result | Reason |
|----------|----------------|---------|
| `weak123` | ❌ Rejected | No uppercase, no special chars |
| `WeakPassword` | ❌ Rejected | No numbers, no special chars |
| `Admin@123` | ✅ Accepted | Meets all requirements |
| `MySecure#456` | ✅ Accepted | Meets all requirements |
| `admin` | ❌ Rejected | Too weak, common password |
| `password` | ❌ Rejected | Common password |

### Password Strength Meter
Test real-time feedback:
- Type `weak` → Should show "Very Weak" (red)
- Type `Weak123` → Should show "Fair" (blue)
- Type `Strong@123` → Should show "Strong" (green)

### CSRF Protection
- Try submitting forms without CSRF token → Should be rejected
- Normal form submission → Should work fine

### Session Management
- Login → Session created
- Close browser → Session persists (if remember me checked)
- Logout → Session destroyed
- Try accessing `/admin/dashboard` without login → Redirected to login

## 🐛 Troubleshooting

### Common Issues & Solutions

#### 1. "404 Not Found" on `/loginpage`
**Problem**: Routes not loading properly
**Solution**:
```bash
# Check if routes are configured
php spark routes | grep loginpage

# Clear route cache
php spark cache:clear
```

#### 2. "Controller not found" Error
**Problem**: Controller namespace issues
**Solution**: Check that controllers are in correct directories:
- `app/Controllers/Admin/LoginController.php`
- `app/Controllers/Public/PublicController.php`

#### 3. Database Connection Error
**Problem**: Database not configured
**Solution**:
```bash
# Check database configuration
# Update database settings in create_test_admin.php
php create_test_admin.php
```

#### 4. "Class 'App\Controllers\Public\PublicController' not found"
**Problem**: Missing PublicController
**Solution**: Ensure `app/Controllers/Public/PublicController.php` exists

#### 5. Login Form Not Submitting
**Problem**: CSRF or validation issues
**Solution**:
- Check browser console for JavaScript errors
- Verify CSRF token is generated
- Check form action URL

#### 6. Password Reset Link Not Working
**Problem**: Database missing reset token fields
**Solution**:
```bash
php update_database_for_reset.php
```

#### 7. Redirect Loop on Admin Dashboard
**Problem**: AdminAuthFilter configuration
**Solution**: Check filter configuration in `app/Config/Filters.php`

### Debug Commands
```bash
# Check routes
php spark routes

# Clear all cache
php spark cache:clear

# Check logs
tail -f writable/logs/log-*.log

# Test database connection
php create_test_admin.php
```

## 📊 Expected Test Results

After successful setup, you should have:

### ✅ Working Features
- [x] Public homepage loads at `http://localhost:8080/`
- [x] Login button in footer works
- [x] Login page accessible at `/loginpage`
- [x] Username/email login works
- [x] Password strength meter functions
- [x] Show/hide password toggle works
- [x] Valid credentials authenticate successfully
- [x] Invalid credentials show appropriate errors
- [x] Admin dashboard loads after login
- [x] Forgot password form accessible
- [x] Password reset email simulation works
- [x] Password reset form works
- [x] New password can be set
- [x] Logout works correctly
- [x] Protected routes require authentication

### 🔒 Security Features
- [x] CSRF protection enabled
- [x] Password hashing with BCRYPT
- [x] Session-based authentication
- [x] Input validation and sanitization
- [x] Password complexity requirements
- [x] Weak password detection
- [x] Rate limiting protection
- [x] Security logging

### 🎨 UI/UX Features
- [x] Responsive Bootstrap 5 design
- [x] Modern gradient backgrounds
- [x] Smooth animations and transitions
- [x] Form validation feedback
- [x] Loading states
- [x] Error handling
- [x] Success messages
- [x] Mobile-friendly interface

## 📝 Test Accounts

### Admin Accounts (Can Access Admin Panel)
```
Username: admin
Email: admin@inlislite.local
Password: Admin@123
Role: Super Admin
```

### Non-Admin Accounts (Cannot Access Admin Panel)
```
Username: librarian
Email: librarian@inlislite.local
Password: Librarian@123
Role: Pustakawan

Username: staff
Email: staff@inlislite.local
Password: Staff@123
Role: Staff
```

## 🎯 Next Steps

Once the login system is working:

### Immediate Improvements
1. **Email Integration**
   - Set up SMTP for actual password reset emails
   - Add email templates

2. **Enhanced Security**
   - Add two-factor authentication
   - Implement account lockout after failed attempts
   - Add login attempt monitoring

3. **User Experience**
   - Add "Stay logged in" functionality
   - Implement auto-logout warnings
   - Add breadcrumb navigation

### Future Features
1. **User Management**
   - User creation/editing interface
   - Role and permission management
   - User activity logs

2. **Core Library Features**
   - Cataloging module
   - Circulation system
   - Member management
   - Reporting dashboard

## 📞 Support

If you encounter issues:

1. **Check the logs**: `writable/logs/log-*.log`
2. **Verify database**: Run `create_test_admin.php`
3. **Clear cache**: `php spark cache:clear`
4. **Check routes**: `php spark routes`
5. **Test step by step**: Follow this guide exactly

The login system should now be fully functional with both basic authentication and password reset capabilities!