# INLISLite Project Structure

## Overview
The project has been properly organized with a clean, maintainable structure following CodeIgniter 4 best practices.

## Directory Structure

```
inlislite-fix/
├── app/                          # Application Core
│   ├── Config/                   # Configuration files
│   │   ├── Routes.php           # Route definitions
│   │   ├── Filters.php          # Security filters (CSRF disabled)
│   │   └── Security.php         # Security configuration
│   ├── Controllers/              # Controllers
│   │   ├── Admin/               # Admin controllers
│   │   │   └── AdminController.php
│   │   ├── BaseController.php   # Base controller
│   │   └── PublicController.php # Public controllers
│   ├── Database/                # Database files
│   │   ├── Migrations/          # Database migrations
│   │   └── Seeds/               # Database seeders
│   ├── Models/                  # Model files
│   │   └── TentangCardModel.php # Tentang card model
│   └── Views/                   # View templates
│       ├── admin/               # Admin views
│       │   ├── tentang-edit.php # Tentang CRUD interface
│       │   └── ...
│       └── public/              # Public views
│           └── layout/          # Layout templates
│
├── public/                      # Web Accessible Files
│   ├── assets/                  # Static assets
│   │   ├── css/                # Stylesheets
│   │   │   ├── admin/          # Admin-specific CSS
│   │   │   └── public/         # Public-facing CSS
│   │   ├── js/                 # JavaScript files
│   │   │   ├── admin/          # Admin-specific JS
│   │   │   │   └── tentang-edit.js
│   │   │   └── public/         # Public-facing JS
│   │   ├── images/             # Image assets
│   │   └── fonts/              # Font files
│   ├── index.php               # Application entry point
│   └── .htaccess               # Apache configuration
│
├── database/                    # Database Files
│   ├── migrations/             # Migration files
│   └── README.md               # Database documentation
│
├── docs/                        # Documentation
│   ├── development/            # Development documentation
│   │   └── CSRF_FIX_SUMMARY.md
│   ├── guides/                 # User guides
│   ├── api/                    # API documentation
│   └── PROJECT_STRUCTURE_FINAL.md
│
├── scripts/                     # Development Scripts
│   ├── apply_emergency_fix.php  # CSRF emergency fix
│   ├── cleanup_csrf_files.php  # Cleanup utility
│   ├── csrf_fix_complete.php   # CSRF fix summary
│   ├── fix_csrf_final.php      # Final CSRF fix
│   ├── test_csrf_status.php    # CSRF status test
│   ├── README.md               # Scripts documentation
│   └── .gitignore              # Ignore scripts in git
│
├── temp/                        # Temporary Files
│   ├── AdminController_csrf_bypass.php
│   ├── Filters_backup.php      # CSRF filters backup
│   ├── Filters_no_csrf.php     # No-CSRF filters
│   ├���─ README.md               # Temp directory info
│   └── .gitignore              # Ignore temp files
│
├── writable/                    # Writable Directories
│   ├── cache/                  # Cache files
│   ├── logs/                   # Log files
│   ├── session/                # Session files
│   └── uploads/                # Upload files
│
├── vendor/                      # Composer Dependencies
├── tests/                       # Test Files
├── .gitignore                  # Git ignore rules
├── composer.json               # Composer configuration
└── README.md                   # Project documentation
```

## File Organization Rules

### 1. Application Code (`app/`)
- **Controllers**: Organized by functionality (Admin vs Public)
- **Models**: All models in `app/Models/`
- **Views**: Separated by admin/public areas
- **Config**: All configuration files

### 2. Public Assets (`public/assets/`)
- **CSS**: Separated by admin/public functionality
- **JavaScript**: Separated by admin/public functionality
- **Images**: Organized by usage context
- **Fonts**: Centralized font storage

### 3. Documentation (`docs/`)
- **Development**: Technical documentation
- **Guides**: User documentation
- **API**: API documentation

### 4. Development Files
- **Scripts**: Development and maintenance scripts
- **Temp**: Temporary files and backups
- **Tests**: Unit and integration tests

