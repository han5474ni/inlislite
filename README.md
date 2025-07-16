# InlisLite - Library Management System

InlisLite is a modern library management system built with CodeIgniter 4 framework, featuring both public and admin interfaces with complete CRUD operations and database synchronization.

## Table of Contents

- [Project Overview](#project-overview)
- [Architecture](#architecture)
- [Backend Structure](#backend-structure)
- [Frontend Structure](#frontend-structure)
- [Installation & Setup](#installation--setup)
- [API Endpoints](#api-endpoints)
- [Database Schema](#database-schema)
- [Features](#features)
- [Development Guidelines](#development-guidelines)
- [Contributing](#contributing)

## Project Overview

InlisLite is a full-stack web application designed to manage library operations with a focus on:
- **Module Management**: Organize library modules and features
- **Dynamic Content**: Database-driven content management
- **User Management**: Admin authentication and user roles
- **Modern UI**: Responsive design with Bootstrap 5
- **API Integration**: RESTful API endpoints for data operations

### Tech Stack

- **Backend**: CodeIgniter 4 (PHP 8.1+)
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Database**: MySQL 8.0+
- **UI Framework**: Bootstrap 5
- **Icons**: Bootstrap Icons
- **Server**: Apache/Nginx

## Architecture

The application follows the MVC (Model-View-Controller) pattern with clear separation between:

```
app/
├── Controllers/
│   ├── Admin/          # Admin interface controllers
│   └── Public/         # Public interface controllers
├── Models/
│   ├── Traits/         # Shared model functionality
│   └── *.php           # Individual model files
├── Views/
│   ├── admin/          # Admin interface views
│   └── public/         # Public interface views
└── Config/             # Configuration files
```

## Backend Structure

### Controllers

#### Admin Controllers
- **AdminController**: Main admin dashboard and authentication
- **FiturController**: Feature and module management
- **UserController**: User management operations

#### Public Controllers
- **PublicController**: Public interface and content display
- **Home**: Landing page and navigation

### Models

#### Core Models
- **FeatureModel**: Handles individual features
- **FiturModel**: Manages features and modules with type distinction
- **ModuleModel**: Handles module operations
- **UserModel**: User authentication and management
- **TentangCardModel**: About/info card management

#### Model Traits
- **ModelTrait**: Shared functionality for timestamps, validation, and formatting

### Key Features of Models

1. **Automatic Timestamps**: Created and updated timestamps
2. **Validation**: Comprehensive validation rules and messages
3. **Formatting**: Data formatting for display (dates, labels, icons)
4. **Sorting**: Automatic sort order management
5. **Search**: Full-text search capabilities
6. **Status Management**: Active/inactive status handling

### Configuration

#### Database Configuration (`app/Config/Database.php`)
```php
public array $default = [
    'DSN'      => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'inlislite',
    'DBDriver' => 'MySQLi',
    'DBPrefix' => '',
    'pConnect' => false,
    'DBDebug'  => true,
    'charset'  => 'utf8',
    'DBCollat' => 'utf8_general_ci',
    'swapPre'  => '',
    'encrypt'  => false,
    'compress' => false,
    'strictOn' => false,
    'failover' => [],
    'port'     => 3306,
    'numberNative' => false,
];
```

#### Routes Configuration (`app/Config/Routes.php`)
```php
// Public routes
$routes->get('/', 'Public\Home::index');
$routes->get('/tentang', 'Public\PublicController::tentang');

// Admin routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'AdminController::index');
    $routes->get('login', 'AdminController::login');
    $routes->post('auth', 'AdminController::auth');
    $routes->get('logout', 'AdminController::logout');
    
    // Feature management
    $routes->get('fitur', 'FiturController::index');
    $routes->get('fitur-edit', 'FiturController::edit');
    
    // API endpoints
    $routes->group('api', function($routes) {
        $routes->get('features', 'FiturController::getFeatures');
        $routes->get('modules', 'FiturController::getModules');
        $routes->post('features', 'FiturController::createFeature');
        $routes->put('features/(:num)', 'FiturController::updateFeature/$1');
        $routes->delete('features/(:num)', 'FiturController::deleteFeature/$1');
    });
});
```

## Frontend Structure

### Views Organization

#### Admin Views (`app/Views/admin/`)
- **layout/**: Master layout templates
- **dashboard.php**: Main admin dashboard
- **fitur.php**: Feature management interface
- **fitur_new.php**: Enhanced feature management UI
- **fitur-edit.php**: Feature editing interface
- **tentang.php**: About page management

#### Public Views (`app/Views/public/`)
- **layout/**: Public layout templates
- **home.php**: Landing page
- **tentang.php**: About page (static)
- **tentang_dynamic.php**: About page (dynamic)

### Assets Organization

#### CSS Files (`public/assets/css/`)
- **admin.css**: Admin interface styling
- **public.css**: Public interface styling
- **fitur.css**: Feature management specific styles

#### JavaScript Files (`public/assets/js/`)
- **admin.js**: Admin interface functionality
- **fitur.js**: Feature management operations
- **fitur-new.js**: Enhanced feature management
- **fitur-edit.js**: Feature editing functionality
- **tentang.js**: About page management

### JavaScript Architecture

#### Modern ES6+ Features
- **Async/Await**: For API calls
- **Fetch API**: For HTTP requests
- **Template Literals**: For dynamic HTML generation
- **Arrow Functions**: For concise syntax
- **Destructuring**: For clean parameter handling

#### Example API Integration
```javascript
// Modern async/await pattern
async function loadFeatures() {
    try {
        const response = await fetch('/admin/api/features');
        const data = await response.json();
        
        if (data.success) {
            renderFeatures(data.data);
        } else {
            showError(data.message);
        }
    } catch (error) {
        console.error('Error loading features:', error);
        showError('Failed to load features');
    }
}

// Dynamic content rendering
function renderFeatures(features) {
    const container = document.getElementById('features-container');
    container.innerHTML = features.map(feature => `
        <div class="feature-card" data-id="${feature.id}">
            <i class="${feature.icon}"></i>
            <h3>${feature.title}</h3>
            <p>${feature.description}</p>
            <span class="status ${feature.status}">${feature.status_label}</span>
        </div>
    `).join('');
}
```

## Installation & Setup

### Prerequisites
- PHP 8.1 or higher
- MySQL 8.0 or higher
- Apache/Nginx web server
- Composer (for dependency management)

### Installation Steps

1. **Clone the repository**
```bash
git clone <repository-url>
cd inlislite
```

2. **Install dependencies**
```bash
composer install
```

3. **Environment Configuration**
```bash
cp env .env
```

Edit `.env` file:
```env
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = inlislite
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

4. **Database Setup**
```sql
CREATE DATABASE inlislite;
USE inlislite;

-- Import database schema
SOURCE database/inlislite.sql;
```

5. **Set Permissions**
```bash
chmod -R 755 writable/
```

6. **Start Development Server**
```bash
php spark serve
```

Access the application at `http://localhost:8080`

### Default Admin Credentials
- **Username**: admin
- **Password**: admin123

## API Endpoints

### Authentication
- `POST /admin/auth` - Admin login
- `GET /admin/logout` - Admin logout

### Features Management
- `GET /admin/api/features` - Get all features
- `POST /admin/api/features` - Create new feature
- `PUT /admin/api/features/{id}` - Update feature
- `DELETE /admin/api/features/{id}` - Delete feature

### Modules Management
- `GET /admin/api/modules` - Get all modules
- `POST /admin/api/modules` - Create new module
- `PUT /admin/api/modules/{id}` - Update module
- `DELETE /admin/api/modules/{id}` - Delete module

### Tentang (About) Cards
- `GET /admin/api/tentang-cards` - Get all about cards
- `POST /admin/api/tentang-cards` - Create new card
- `PUT /admin/api/tentang-cards/{id}` - Update card
- `DELETE /admin/api/tentang-cards/{id}` - Delete card

### API Response Format

#### Success Response
```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {
        "id": 1,
        "title": "Feature Name",
        "description": "Feature description",
        "icon": "bi-star",
        "color": "blue",
        "status": "active",
        "created_at": "2024-01-01 10:00:00",
        "updated_at": "2024-01-01 10:00:00"
    }
}
```

#### Error Response
```json
{
    "success": false,
    "message": "Error message description",
    "errors": {
        "title": ["Title is required"],
        "description": ["Description must be at least 10 characters"]
    }
}
```

## Database Schema

### Core Tables

#### `features` Table
```sql
CREATE TABLE features (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(100) NOT NULL,
    color ENUM('blue', 'green', 'orange', 'purple') NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### `modules` Table
```sql
CREATE TABLE modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(100) NOT NULL,
    color ENUM('blue', 'green', 'orange', 'purple') NOT NULL,
    module_type ENUM('application', 'database', 'utility') NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### `fitur` Table
```sql
CREATE TABLE fitur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(100) NOT NULL,
    color ENUM('blue', 'green', 'orange', 'purple') NOT NULL,
    type ENUM('feature', 'module') NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### `tentang_cards` Table
```sql
CREATE TABLE tentang_cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(100) NOT NULL,
    color ENUM('blue', 'green', 'orange', 'purple') NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### `users` Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    status ENUM('active', 'inactive') DEFAULT 'active',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Features

### Admin Features
- **Dashboard**: Overview of system statistics
- **Feature Management**: Create, read, update, delete features
- **Module Management**: Full CRUD operations for modules
- **User Management**: Admin user management
- **Content Management**: Dynamic content management
- **Search & Filter**: Advanced search capabilities
- **Drag & Drop**: Reorder items with drag and drop
- **Responsive Design**: Mobile-friendly interface

### Public Features
- **Dynamic Content**: Database-driven content display
- **Responsive Design**: Mobile-first approach
- **Modern UI**: Clean and intuitive interface
- **Fast Loading**: Optimized performance

### Technical Features
- **Database Synchronization**: Real-time data sync
- **Input Validation**: Comprehensive validation
- **Error Handling**: Robust error management
- **Security**: CSRF protection and input sanitization
- **Performance**: Optimized queries and caching
- **Logging**: Comprehensive logging system

## Development Guidelines

### Code Style
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Write comprehensive comments
- Implement proper error handling

### Database Operations
- Use prepared statements for all queries
- Implement proper transaction handling
- Add appropriate indexes for performance
- Use soft deletes where appropriate

### Frontend Development
- Use modern JavaScript (ES6+)
- Implement responsive design
- Optimize for performance
- Follow accessibility guidelines

### Security Best Practices
- Validate all user inputs
- Use CSRF protection
- Implement proper authentication
- Sanitize output data
- Use HTTPS in production

### Testing
- Write unit tests for models
- Implement integration tests for APIs
- Test frontend functionality
- Perform security testing

## Contributing

### Development Workflow
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Write tests
5. Submit a pull request

### Code Review Process
- All changes require code review
- Tests must pass
- Documentation must be updated
- Security review for sensitive changes

### Issue Reporting
- Use GitHub issues for bug reports
- Provide detailed reproduction steps
- Include system information
- Attach relevant screenshots

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support and questions:
- Create an issue on GitHub
- Contact the development team
- Check the documentation

---

**InlisLite** - Modern Library Management System
Version 1.0.0 - Built with CodeIgniter 4
