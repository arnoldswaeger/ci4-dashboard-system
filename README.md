# CI4 Dashboard System

Sistem Dashboard lengkap berbasis CodeIgniter 4 dengan fitur MVC, manajemen user CRUD, dan autentikasi Shield.

## 🚀 Fitur Utama

### Dashboard
- **Dashboard Responsive** dengan layout modern menggunakan Bootstrap 5
- **Statistik User** dengan visualisasi data
- **Profile Management** untuk pengguna
- **Quick Info** dashboard menampilkan informasi user

### User Management (Admin Only)
- **List Users** dengan pagination dan search
- **Create User** - tambah user baru
- **Edit User** - ubah data user
- **View User** - lihat detail user
- **Delete User** - hapus user dengan konfirmasi
- **Role Management** - admin dan regular user
- **Status Management** - active dan inactive

### Authentication
- **Shield Authentication** - library autentikasi bawaan CodeIgniter 4
- **Login System** - login dengan email/username
- **Role-Based Access Control** - akses berbeda untuk admin dan user
- **Session Management** - pengelolaan session pengguna
- **Last Login Tracking** - tracking login terakhir pengguna

## 📋 Persyaratan

- PHP >= 7.4 atau PHP 8.0+
- MySQL 5.7+ atau MariaDB
- Composer
- CodeIgniter 4.4+
- CodeIgniter Shield 1.0+

## 🔧 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/arnoldswaeger/ci4-dashboard-system.git
cd ci4-dashboard-system
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = ci4_dashboard
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 4. Jalankan Migration
```bash
php spark migrate
```

### 5. Jalankan Seeder
```bash
php spark db:seed UserSeeder
```

### 6. Jalankan Server
```bash
php spark serve
```

Akses aplikasi di `http://localhost:8080`

## 👥 Akun Default

### Admin
- Email: `admin@example.com`
- Username: `admin`
- Password: `Admin123456`

### User Biasa
- Email: `user@example.com`
- Username: `user123`
- Password: `User123456`

## 📁 Struktur Folder

```
ci4-dashboard-system/
├── app/
│   ├── Controllers/
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   └── Auth/ (Shield)
│   ├── Models/
│   │   └── UserModel.php
│   ├── Views/
│   │   ├── layout/
│   │   │   └── base.php
│   │   ├── Dashboard/
│   │   │   ├── index.php
│   │   │   ├── profile.php
│   │   │   └── statistics.php
│   │   └── User/
│   │       ├── index.php
│   │       ├── create.php
│   │       ├── edit.php
│   │       └── show.php
│   ├── Database/
│   │   ├── Migrations/
│   │   │   └── 2024-01-01-000001_CreateUsersTable.php
│   │   └── Seeds/
│   │       └── UserSeeder.php
│   ├── Filters/
│   │   └── NoAuthFilter.php
│   └── Config/
│       ├── Routes.php
│       ├── Filters.php
│       └── ...
├── public/
├── vendor/
├── .env
├── composer.json
└── README.md
```

## 🔐 Sistem Autentikasi

### Filter Otentikasi

**NoAuthFilter** - Mengarahkan user yang sudah login ke dashboard
```php
$routes->get('login', 'Auth\AuthController::login', ['filter' => 'noauth']);
```

**Auth Filter** - Melindungi halaman yang memerlukan login
```php
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);
```

### Role-Based Access Control

Hanya admin yang dapat mengakses halaman user management:
```php
public function isAdmin()
{
    $user = auth()->user();
    return $user && property_exists($user, 'role') && $user->role === 'admin';
}
```

## 📊 Fitur User Management

### Create User
- Validasi email unique
- Validasi username unique
- Password hashing dengan bcrypt
- Pilih role (admin/user)
- Set status (active/inactive)

### Edit User
- Update semua informasi user
- Optional: ubah password
- Update role dan status
- Validasi unik field

### Delete User
- Soft delete dengan timestamps
- Prevent user menghapus akun sendiri
- Konfirmasi sebelum delete

### View User
- Lihat detail lengkap user
- Last login tracking
- Member since date
- Status dan role badge

## 🎨 UI/UX Features

- **Bootstrap 5** untuk responsive design
- **Bootstrap Icons** untuk ikon
- **Sidebar Navigation** yang dapat di-collapse
- **Flash Messages** untuk feedback
- **Form Validation** real-time
- **Data Pagination** untuk efisiensi
- **Search Functionality** untuk mencari user
- **Status Badges** untuk visual status
- **Responsive Tables** yang mobile-friendly

## 🔄 Routes

### Public Routes
```
GET  /login              - Login page
POST /login              - Process login
GET  /register           - Register page
POST /register           - Process register
POST /logout             - Process logout
```

### Protected Routes (Auth Required)
```
GET  /dashboard          - Dashboard home
GET  /dashboard/statistics  - Statistics (admin only)
GET  /dashboard/profile  - User profile

GET  /user               - List users (admin only)
GET  /user/create        - Create form (admin only)
POST /user/store         - Store user (admin only)
GET  /user/edit/:id      - Edit form (admin only)
POST /user/update/:id    - Update user (admin only)
DELETE /user/delete/:id  - Delete user (admin only)
GET  /user/show/:id      - View user (admin only)
```

## 🗄️ Database Schema

### Users Table
```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(254) UNIQUE NOT NULL,
  username VARCHAR(100) UNIQUE NOT NULL,
  full_name VARCHAR(255) NOT NULL,
  phone VARCHAR(20),
  address TEXT,
  role ENUM('admin', 'user') DEFAULT 'user',
  status ENUM('active', 'inactive') DEFAULT 'active',
  avatar VARCHAR(255),
  password_hash VARCHAR(255) NOT NULL,
  last_login DATETIME,
  created_at DATETIME,
  updated_at DATETIME,
  deleted_at DATETIME
);
```

## 🔒 Security Features

- **Password Hashing** menggunakan bcrypt
- **CSRF Protection** pada semua form
- **SQL Injection Prevention** dengan parameterized queries
- **XSS Protection** dengan output encoding
- **Soft Delete** untuk data recovery
- **Session Management** yang aman
- **Input Validation** yang ketat

## 📝 Validasi Form

### User Creation
- Email: required, valid email, unique
- Username: required, alphanumeric, min 3 chars, unique
- Full Name: required, min 3 chars
- Phone: optional, numeric, min 10 digits
- Password: required, min 8 chars
- Password Confirm: required, match password
- Role: required, in_list[admin,user]
- Status: required, in_list[active,inactive]

## 🚀 Development Tips

### Menambah Field Baru di User
1. Buat migration baru
2. Update UserModel allowedFields
3. Update validation rules
4. Update view files

### Menambah Role Baru
1. Update Users table ENUM
2. Update view badge styling
3. Update controller permission check

### Customize Sidebar
1. Edit `app/Views/layout/base.php`
2. Ubah styling di `<style>` section
3. Tambah/hapus menu items

## 🐛 Troubleshooting

### Database Connection Error
- Pastikan MySQL running
- Check `.env` database settings
- Verifikasi username/password database

### Migration Failed
- Hapus table users jika ada
- Run: `php spark migrate:refresh`
- Run seeder lagi

### Login Error
- Clear browser cache
- Check `.env` database settings
- Verify user data di database

### Permission Denied
- Verify user role di database
- Check filter configuration
- Ensure auth()->loggedIn() return true

## 📚 Resources

- [CodeIgniter 4 Documentation](https://codeigniter.com/user_guide/)
- [CodeIgniter Shield](https://shield.codeigniter.com/)
- [Bootstrap 5](https://getbootstrap.com/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)

## 📄 License

MIT License - Silakan gunakan untuk project pribadi atau komersial.

## 👨‍💻 Author

Arnold Swaeger - [GitHub](https://github.com/arnoldswaeger)

## 🤝 Contributing

Kontribusi sangat diterima! Silakan buat fork dan submit pull request.

---

**Happy Coding! 🎉**