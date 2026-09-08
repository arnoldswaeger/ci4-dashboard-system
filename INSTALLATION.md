# 🔧 Installation & Setup Guide

## Persyaratan Sistem

### Minimum Requirements
- PHP 7.4+
- MySQL 5.7+ atau MariaDB 10.2+
- Apache/Nginx dengan mod_rewrite
- Composer

### Recommended
- PHP 8.1+
- MySQL 8.0+
- 512MB RAM minimum
- 50MB disk space minimum

## Step-by-Step Installation

### 1. Persiapan

**Pastikan Anda memiliki:**
- Git installed
- PHP CLI installed
- MySQL/MariaDB running
- Composer installed

### 2. Clone Repository

```bash
git clone https://github.com/arnoldswaeger/ci4-dashboard-system.git
cd ci4-dashboard-system
```

### 3. Install PHP Dependencies

```bash
composer install
```

Proses ini akan menginstall:
- CodeIgniter 4
- CodeIgniter Shield
- Semua dependencies yang diperlukan

### 4. Setup Environment File

**Copy .env file:**
```bash
cp .env.example .env
```

**Atau buat manual:**
```bash
echo "CI_ENVIRONMENT = development" > .env
```

### 5. Konfigurasi Database

**Edit file `.env`:**

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'
app.forceGlobalSecureRequests = false

# Database Configuration
database.default.hostname = localhost
database.default.database = ci4_dashboard
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306

# Security
security.tokenRandomize = true
security.csrfProtection = 'session'

# Auth Configuration
auth.views.login = 'Auth\Views\login'
auth.views.register = 'Auth\Views\register'
auth.allowRegistration = false
auth.session.expiresIn = 7200
```

### 6. Buat Database

**Menggunakan MySQL CLI:**
```bash
mysql -u root -p
```

**Di MySQL console:**
```sql
CREATE DATABASE ci4_dashboard CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ci4_dashboard;
EXIT;
```

**Atau menggunakan GUI tool seperti phpMyAdmin**

### 7. Jalankan Migration

```bash
php spark migrate
```

**Output yang diharapkan:**
```
Applying database migrations...

Current version: 0
  Migrating App (0) -> App (1):
    - 2024-01-01-000001_CreateUsersTable.php

Done! Database is up to date!
```

### 8. Jalankan Seeder (Optional)

```bash
php spark db:seed UserSeeder
```

**Output yang diharapkan:**
```
Seeding App\Database\Seeds\UserSeeder...
Done!
```

### 9. Generate App Key (Jika diperlukan)

```bash
php spark key:generate
```

### 10. Set File Permissions

**Di Linux/Mac:**
```bash
chmod -R 755 writable/
chmod -R 755 public/
```

**Di Windows (tidak perlu)**

### 11. Jalankan Development Server

```bash
php spark serve
```

**Output:**
```
CodeIgniter development server started on http://localhost:8080
Press Ctrl-C to quit.
```

### 12. Akses Aplikasi

Buka browser dan akses:
```
http://localhost:8080
```

Anda akan diarahkan ke halaman login.

---

## Troubleshooting Installation

### Error: Database Connection Failed

**Solusi:**
1. Pastikan MySQL running
2. Verifikasi konfigurasi di `.env`
3. Test koneksi:
   ```bash
   php spark db:connect
   ```

### Error: Permission Denied on writable/

**Solusi di Linux/Mac:**
```bash
chmod -R 777 writable/
```

### Error: Class not found

**Solusi:**
```bash
composer dump-autoload
php spark clear:cache
```

### Error: Migration file not found

**Solusi:**
```bash
php spark migrate:rollback
php spark migrate
```

### Error: CSRF Token Mismatch

**Solusi:**
1. Clear browser cache
2. Refresh halaman
3. Pastikan `.env` `security.csrfProtection = 'session'`

---

## Production Deployment

### 1. Update .env

```ini
CI_ENVIRONMENT = production

app.baseURL = 'https://yourdomain.com/'
app.forceGlobalSecureRequests = true

database.default.hostname = your-db-host
database.default.database = your-db-name
database.default.username = your-db-user
database.default.password = your-secure-password
```

### 2. Hide Public Folder (Apache)

**Edit `.htaccess` di root:**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### 3. Optimize Performance

```bash
composer install --optimize-autoloader --no-dev
php spark cache:clear
php spark config:cache
```

### 4. Setup HTTPS

- Gunakan Let's Encrypt gratis SSL
- Update `app.forceGlobalSecureRequests = true`
- Update `app.baseURL` ke https://

### 5. Backup Database

```bash
mysqldump -u root -p ci4_dashboard > backup.sql
```

### 6. Monitor Error Logs

```bash
tail -f writable/logs/log-2024-01-01.log
```

---

## Environment Variables Reference

| Variable | Default | Description |
|----------|---------|-------------|
| CI_ENVIRONMENT | development | development/production/testing |
| app.baseURL | http://localhost:8080/ | Application base URL |
| database.default.hostname | localhost | Database host |
| database.default.database | ci4_dashboard | Database name |
| database.default.username | root | Database user |
| database.default.password | (empty) | Database password |
| auth.allowRegistration | false | Allow user registration |
| auth.session.expiresIn | 7200 | Session timeout (seconds) |

---

## Verification Checklist

- [ ] PHP version >= 7.4
- [ ] MySQL/MariaDB running
- [ ] Dependencies installed with Composer
- [ ] .env file configured
- [ ] Database created
- [ ] Migrations executed
- [ ] Seeders executed (optional)
- [ ] writable/ folder has write permissions
- [ ] Application accessible at localhost:8080
- [ ] Can login with test credentials
- [ ] Dashboard loads without errors

---

## Next Steps

Setelah instalasi berhasil:

1. **Login dengan akun default**
   - Email: admin@example.com
   - Password: Admin123456

2. **Explore aplikasi**
   - Lihat Dashboard
   - Manage Users
   - View Statistics

3. **Customize untuk kebutuhan Anda**
   - Update branding
   - Add custom fields
   - Extend functionality

4. **Backup database**
   - Setup backup schedule
   - Test restore procedure

5. **Setup production**
   - Choose hosting provider
   - Configure domain
   - Setup SSL certificate

---

**Installation complete! Happy coding! 🚀**