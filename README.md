# 🌟 INLISLite v3.0 - Sistem Perpustakaan Digital Modern

<div align="center">

![INLISLite Logo](https://img.shields.io/badge/INLISLite-v3.0-blue?style=for-the-badge&logo=star)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.x-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

**Sistem Otomasi Perpustakaan Modern dengan Keamanan Enterprise-Grade**

[📖 Dokumentasi](#-dokumentasi) • [🚀 Quick Start](#-quick-start) • [🎮 Demo](#-demo) • [🔧 Setup](#-setup) • [🧪 Testing](#-testing)

</div>

---

## 📋 **Deskripsi Project**

INLISLite v3.0 adalah sistem otomasi perpustakaan modern yang dibangun dengan CodeIgniter 4, menampilkan:

- 🔐 **Sistem Autentikasi Aman** dengan enkripsi bcrypt dan validasi password kompleks
- 👥 **Manajemen User Lengkap** dengan role-based access control
- 📊 **Dashboard Modern** dengan sidebar responsif dan design yang elegan
- 🛡️ **Keamanan Enterprise-Grade** dengan rate limiting dan activity logging
- 📱 **Responsive Design** yang mobile-friendly
- 🎨 **UI/UX Modern** dengan Bootstrap 5 dan custom styling

## 🏗️ **Struktur Project Terorganisir**

```
📁 inlislite/
├── 📁 app/                    # CodeIgniter 4 Application
├── 📁 public/                 # Web accessible files
├── 📁 docs/                   # 📚 Dokumentasi lengkap
├── 📁 database/               # 🗃️ Database files & migrations
├── 📁 setup/                  # ⚙️ Setup & installation scripts
├── 📁 testing/                # 🧪 Testing files & demos
├── 📁 tools/                  # 🛠️ Development tools
├── 📁 demo/                   # 🎮 Demo files
└── 📁 archive/                # 📦 Legacy files
```

> 📖 **Lihat struktur lengkap**: [PROJECT_STRUCTURE.md](PROJECT_STRUCTURE.md)

## 🚀 **Quick Start**

### **1. Clone Repository**
```bash
git clone <repository-url>
cd inlislite
```

### **2. Install Dependencies**
```bash
composer install
```

### **3. Setup Database**
```bash
# Quick setup (recommended)
php setup/setup_simple.php

# Or full setup wizard
php setup/setup_database.php
```

### **4. Create Admin User**
```bash
php setup/create_test_admin.php
```

### **5. Access Application**
```
🌐 Homepage: http://localhost:8080/
🔐 Admin Login: http://localhost:8080/admin/secure-login
👤 Credentials: admin / password
```

## 📚 **Dokumentasi**

### **📖 Panduan Utama**
- [🔐 Security Features Guide](docs/guides/SECURITY_FEATURES_GUIDE.md) - Fitur keamanan lengkap
- [👥 User Management Guide](docs/guides/USER_MANAGEMENT_GUIDE.md) - Panduan manajemen user
- [🗺️ Project Analysis & Navigation](docs/guides/PROJECT_ANALYSIS_AND_NAVIGATION.md) - Analisis project lengkap

### **🔧 Troubleshooting**
- [🔧 Authentication Fix Guide](docs/guides/AUTHENTICATION_FIX_GUIDE.md) - Perbaikan autentikasi
- [🐛 Login Issues Analysis](docs/guides/LOGIN_ISSUES_ANALYSIS.md) - Analisis masalah login

### **🎨 UI/UX Guides**
- [📱 Sidebar Documentation](docs/guides/NEW_SIDEBAR_DOCUMENTATION.md) - Dokumentasi sidebar
- [📊 Dashboard Structure](docs/guides/DASHBOARD_STRUCTURE.md) - Struktur dashboard

### **📁 Dokumentasi Lengkap**
> 📖 **Semua dokumentasi**: [docs/README.md](docs/README.md)

## 🎮 **Demo**

### **🌐 Online Demo**
- **Navigation Hub**: [demo/main_index.php](demo/main_index.php)
- **Standalone Demo**: [demo/standalone/index.html](demo/standalone/index.html)

### **🧪 Testing Pages**
- **Auth Filter Test**: [testing/manual/test_auth_filter.php](testing/manual/test_auth_filter.php)
- **Dashboard Test**: [testing/manual/test_dashboard_access.php](testing/manual/test_dashboard_access.php)
- **Login System Test**: [testing/manual/test_login_system.php](testing/manual/test_login_system.php)

## ⚙️ **Setup & Installation**

### **🎯 Quick Setup (Recommended)**
```bash
# 1. Setup database dan admin user
php setup/setup_simple.php

# 2. Test login system
php setup/fix_login_issues.php

# 3. Access application
# http://localhost:8080/admin/secure-login
```

### **🔧 Manual Setup**
1. **Database Setup**: [setup/setup_database.php](setup/setup_database.php)
2. **Create Admin**: [setup/create_test_admin.php](setup/create_test_admin.php)
3. **Fix Issues**: [setup/fix_login_issues.php](setup/fix_login_issues.php)

> 📖 **Setup Guide Lengkap**: [setup/README.md](setup/README.md)

## 🧪 **Testing**

### **🔍 Manual Testing**
```bash
# Test authentication system
php testing/manual/test_login_system.php

# Test dashboard access
php testing/manual/test_dashboard_access.php

# Test auth filter
php testing/manual/test_auth_filter.php
```

### **🎮 Demo Testing**
- **CRUD Demo**: [testing/demo/test_crud.html](testing/demo/test_crud.html)
- **Dashboard Demo**: [testing/demo/test_modern_dashboard.html](testing/demo/test_modern_dashboard.html)
- **Document CRUD**: [testing/demo/test_document_crud.html](testing/demo/test_document_crud.html)

> 📖 **Testing Guide**: [testing/README.md](testing/README.md)

## 🛠️ **Tools & Utilities**

### **🗃️ Database Tools**
- **Add User**: [tools/database/add_user.php](tools/database/add_user.php)
- **Update User**: [tools/database/update_user.php](tools/database/update_user.php)
- **Delete User**: [tools/database/delete_user.php](tools/database/delete_user.php)
- **Fetch Users**: [tools/database/fetch_users.php](tools/database/fetch_users.php)

> 📖 **Tools Guide**: [tools/README.md](tools/README.md)

## 🔐 **Fitur Keamanan**

### **🛡️ Authentication System**
- ✅ **Bcrypt Password Hashing** dengan cost factor 12
- ✅ **Rate Limiting** - 5 percobaan per 15 menit
- ✅ **Account Lockout** protection
- ✅ **Session Security** dengan timeout management
- ✅ **CSRF Protection** di semua form
- ✅ **Activity Logging** untuk monitoring

### **🔒 Password Policy**
- ✅ **Minimum 8 karakter**
- ✅ **Huruf besar & kecil** wajib
- ✅ **Angka** wajib
- ✅ **Karakter khusus** wajib (@#$%^&*()[]{}))
- ✅ **Filter password lemah** dan umum
- ✅ **Real-time strength indicator**

### **👥 Role-Based Access**
- 🔴 **Super Admin** - Full access
- 🔵 **Admin** - Administrative access
- 🟢 **Pustakawan** - Library operations
- 🟠 **Staff** - Limited access

## 🎨 **UI/UX Features**

### **📱 Modern Design**
- ✅ **Bootstrap 5** framework
- ✅ **Responsive design** mobile-first
- ✅ **Dark/Light theme** support
- ✅ **Smooth animations** dan transitions
- ✅ **Feather Icons** integration

### **🎯 User Experience**
- ✅ **Collapsible sidebar** dengan toggle
- ✅ **Real-time search** dan filtering
- ✅ **Modal forms** untuk CRUD operations
- ✅ **Toast notifications** untuk feedback
- ✅ **Loading states** untuk async operations

## 📊 **Technical Specifications**

### **🔧 Requirements**
- **PHP**: 8.0 atau lebih tinggi
- **MySQL**: 8.0 atau lebih tinggi
- **Web Server**: Apache/Nginx
- **Composer**: Latest version

### **🏗️ Architecture**
- **Framework**: CodeIgniter 4.x
- **Database**: MySQL dengan InnoDB engine
- **Frontend**: Bootstrap 5 + Custom CSS/JS
- **Security**: Enterprise-grade implementation

### **📦 Dependencies**
```json
{
    "php": "^8.0",
    "codeigniter4/framework": "^4.0",
    "bootstrap": "^5.3",
    "feather-icons": "^4.29"
}
```

## 🤝 **Contributing**

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 **License**

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 **Support**

### **📞 Getting Help**
- 📖 **Documentation**: [docs/README.md](docs/README.md)
- 🔧 **Troubleshooting**: [docs/guides/AUTHENTICATION_FIX_GUIDE.md](docs/guides/AUTHENTICATION_FIX_GUIDE.md)
- 🧪 **Testing**: [testing/README.md](testing/README.md)

### **🐛 Reporting Issues**
1. Check existing documentation
2. Run diagnostic scripts in `/setup/`
3. Create detailed issue report

### **💡 Feature Requests**
- Submit feature requests with detailed use cases
- Include mockups or examples if applicable

---

<div align="center">

**🌟 INLISLite v3.0 - Modern Library Management System**

Made with ❤️ for Indonesian Libraries

[⬆️ Back to Top](#-inlislite-v30---sistem-perpustakaan-digital-modern)

</div>