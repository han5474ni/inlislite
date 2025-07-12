# INLISLite Project Structure

## Directory Structure

```
inlislite-fix/
├── app/                          # Application files
│   ├── Config/                   # Configuration files
│   ├── Controllers/              # Controllers
│   │   ├── Admin/               # Admin controllers
│   │   └── Public/              # Public controllers (if any)
│   ├── Database/                # Database files
│   │   ├── Migrations/          # Database migrations
│   │   └── Seeds/               # Database seeders
│   ├── Models/                  # Model files
│   └── Views/                   # View files
│       ├── admin/               # Admin views
│       └── public/              # Public views
│           └── layout/          # Layout templates
├── public/                      # Web accessible files
│   ├── assets/                  # Static assets
│   │   ├── css/                # Stylesheets
│   │   │   ├── admin/          # Admin CSS
│   │   │   └── public/         # Public CSS
│   │   ├── js/                 # JavaScript files
│   │   │   ├── admin/          # Admin JS
│   │   │   └── public/         # Public JS
│   │   ├── images/             # Images
│   │   └── fonts/              # Font files
│   └── index.php               # Entry point
├── writable/                    # Writable directories
│   ├── cache/                  # Cache files
│   ├── logs/                   # Log files
│   ├── session/                # Session files
│   └── uploads/                # Upload files
├── vendor/                      # Composer dependencies
├── docs/                        # Documentation
│   ├── api/                    # API documentation
│   ├── guides/                 # User guides
│   ├── development/            # Development docs
│   └── installation/           # Installation guides
└── database/                    # Database files
    └── migrations/             # Migration files
```

## File Organization Rules

### Controllers
- Admin controllers: `app/Controllers/Admin/`
- Public controllers: `app/Controllers/` (root level)
- Base controller: `app/Controllers/BaseController.php`

### Views
- Admin views: `app/Views/admin/`
- Public views: `app/Views/public/`
- Layout files: `app/Views/public/layout/`

### Assets
- Admin CSS: `public/assets/css/admin/`
- Public CSS: `public/assets/css/public/`
- Admin JS: `public/assets/js/admin/`
- Public JS: `public/assets/js/public/`

### Models
- All models: `app/Models/`
- Follow naming convention: `ModelName.php`

### Database
- Migrations: `app/Database/Migrations/`
- Seeds: `app/Database/Seeds/`

## Clean Code Guidelines

1. **No test files in production**
2. **No temporary files in repository**
3. **Proper file organization by functionality**
4. **Clear separation between admin and public areas**
5. **Consistent naming conventions**
6. **All PHP files should be in app/ directory**
7. **Only static assets in public/ directory**

## Current Status

✅ **Clean Structure Achieved:**
- Test files removed
- Temporary files cleaned up
- Proper directory structure in place
- Documentation organized
- Routes cleaned up

✅ **File Organization:**
- Controllers properly organized
- Views separated by functionality
- Assets organized by type and area
- Models in proper location

✅ **Ready for Production:**
- No development/test files
- Clean codebase
- Proper separation of concerns
- Well-documented structure
