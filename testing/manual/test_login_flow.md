# INLISLite v3 - Login Flow Test Guide

## 🔄 Complete Login Flow

### Step 1: Homepage Access
- **URL**: `http://localhost:8080/`
- **Expected**: Public homepage with modern design
- **Features**: 
  - Hero section with INLISLite v3 branding
  - Features showcase
  - Statistics section
  - Footer with "Admin Login" button

### Step 2: Login Page Access
- **Action**: Click "Admin Login" button in footer
- **URL**: `http://localhost:8080/loginpage`
- **Expected**: Modern login form with:
  - Username and password fields
  - Show/hide password toggle
  - Real-time password strength meter
  - Remember me checkbox
  - Bootstrap 5 responsive design

### Step 3: Login Authentication
- **Action**: Enter credentials and submit
- **Test Credentials**:
  - Username: `admin`
  - Password: `Admin@123`
- **Process**: Form submits to `/loginpage/authenticate`
- **Expected**: Successful authentication

### Step 4: Admin Dashboard Redirect
- **URL**: `http://localhost:8080/admin/dashboard`
- **Expected**: Admin dashboard with:
  - Welcome message with user name
  - Navigation menu
  - Statistics cards
  - Quick actions
  - System information

### Step 5: Logout
- **Action**: Click logout in dropdown menu
- **URL**: `http://localhost:8080/admin/logout`
- **Expected**: Redirect to login page with success message

## 🛠️ Setup Instructions

### 1. Database Setup
Run the test admin creation script:
```bash
php create_test_admin.php
```

This will:
- Create the `users` table if it doesn't exist
- Create test admin user with credentials: `admin` / `Admin@123`
- Create additional test users for different roles

### 2. Server Setup
Make sure your local server is running:
```bash
# If using Laravel Valet, XAMPP, or similar
# Access: http://localhost:8080/

# If using PHP built-in server
php spark serve --port=8080
```

### 3. Test the Flow
1. Open browser and go to `http://localhost:8080/`
2. Scroll to footer and click "Admin Login"
3. Login with `admin` / `Admin@123`
4. Verify you're redirected to admin dashboard
5. Test logout functionality

## 🔐 Security Features Tested

### Password Validation
- ✅ Minimum 8 characters
- ✅ At least one uppercase letter
- ✅ At least one lowercase letter  
- ✅ At least one number
- ✅ At least one special character (@#$%^&*()[]{})
- ✅ Rejects common weak passwords
- ✅ Real-time strength meter

### Authentication Security
- ✅ CSRF protection
- ✅ Password hashing with BCRYPT
- ✅ Session management
- ✅ Role-based access control
- ✅ Rate limiting protection
- ✅ Security logging

### UI/UX Features
- ✅ Responsive Bootstrap 5 design
- ✅ Show/hide password toggle
- ✅ Form validation feedback
- ✅ Loading states
- ✅ Error handling
- ✅ Success messages

## 🧪 Test Cases

### Valid Login Test
```
Username: admin
Password: Admin@123
Expected: Success → Redirect to /admin/dashboard
```

### Invalid Password Test
```
Username: admin
Password: weak123
Expected: Error → "Password does not meet complexity requirements"
```

### Non-Admin User Test
```
Username: staff
Password: Staff@123
Expected: Error → "Access denied. Admin privileges required."
```

### Non-Existent User Test
```
Username: nonexistent
Password: Admin@123
Expected: Error → "Invalid username or password"
```

### CSRF Protection Test
```
Action: Submit form without CSRF token
Expected: Error → "Invalid CSRF token"
```

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database credentials in `create_test_admin.php`
   - Ensure MySQL server is running
   - Verify database exists

2. **404 Error on Routes**
   - Check if routes are properly configured
   - Verify controller namespaces
   - Clear route cache if needed

3. **Login Form Not Submitting**
   - Check CSRF token generation
   - Verify form action URL
   - Check JavaScript console for errors

4. **Redirect Loop**
   - Check AdminAuthFilter configuration
   - Verify session handling
   - Check route filters

5. **Password Strength Meter Not Working**
   - Check JavaScript console for errors
   - Verify Bootstrap and jQuery loading
   - Test with different browsers

### Debug Commands
```bash
# Check routes
php spark routes

# Clear cache
php spark cache:clear

# Check logs
tail -f writable/logs/log-*.log
```

## 📊 Expected Results

After successful setup and testing:

- ✅ Homepage loads at `http://localhost:8080/`
- ✅ Login button in footer works
- ✅ Login form displays correctly
- ✅ Password strength meter functions
- ✅ Valid credentials authenticate successfully
- ✅ Invalid credentials show appropriate errors
- ✅ Admin dashboard loads after login
- ✅ Logout works correctly
- ✅ Protected routes require authentication

## 🎯 Next Steps

Once the login flow is working:

1. **Extend User Management**
   - Add user creation/editing forms
   - Implement user roles and permissions
   - Add user profile management

2. **Enhance Security**
   - Add two-factor authentication
   - Implement password reset functionality
   - Add login attempt monitoring

3. **Improve UX**
   - Add remember me functionality
   - Implement auto-logout warnings
   - Add breadcrumb navigation

4. **Add Core Features**
   - Cataloging module
   - Circulation system
   - Member management
   - Reporting dashboard