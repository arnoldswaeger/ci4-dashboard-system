# 🔐 Authentication & Authorization Guide

## Sistem Autentikasi Shield

Aplikasi ini menggunakan CodeIgniter Shield untuk autentikasi dan otorisasi.

### Login Flow

```
User Input Email/Username + Password
        ↓
Validate Credentials
        ↓
  Success? → Create Session + Update Last Login → Redirect to Dashboard
        ↓
      No  → Show Error Message
```

### Access Control

#### Public Access (Tanpa Login)
- Login Page
- Register Page

#### User Access (Setelah Login)
- Dashboard
- Profile
- Statistik (Hanya Admin)

#### Admin Only Access
- User Management (List, Create, Edit, Delete)
- User Statistics
- User Permissions Management

## 🔐 Role-Based Access Control (RBAC)

### Roles

#### Admin
- Akses penuh ke semua fitur
- Dapat membuat, mengedit, menghapus user
- Dapat melihat statistik
- Dapat mengubah role user lain
- Tidak dapat menghapus diri sendiri

#### User (Regular)
- Hanya dapat melihat dashboard
- Hanya dapat melihat profile sendiri
- Tidak dapat mengakses user management
- Tidak dapat melihat statistik

## 🛡️ Security Measures

### Password Security

```php
// Hashing password saat create
$updateData['password_hash'] = password_hash(
    $this->request->getPost('password'), 
    PASSWORD_DEFAULT
);

// Verifying password saat login (Shield handles this)
```

### CSRF Protection

Semua form dilindungi dengan CSRF token:

```html
<form method="post">
    <?= csrf_field() ?>
    <!-- form fields -->
</form>
```

### Session Management

```php
// Cek apakah user login
if (!auth()->loggedIn()) {
    return redirect()->to('/login');
}

// Dapatkan user yang login
$user = auth()->user();
echo $user->email;
echo $user->role;
```

### Input Validation

```php
$validation->setRules([
    'email' => 'required|valid_email|is_unique[users.email]',
    'username' => 'required|alpha_numeric_punct|min_length[3]|is_unique[users.username]',
    'password' => 'required|min_length[8]',
]);

if (!$validation->withRequest($this->request)->run()) {
    return redirect()->back()->withInput()->with('errors', $validation->getErrors());
}
```

## 🔄 Filter Configuration

### NoAuthFilter

Mengarahkan user yang sudah login ke dashboard:

```php
// app/Filters/NoAuthFilter.php
public function before(RequestInterface $request, $arguments = null)
{
    if (auth()->loggedIn()) {
        return redirect()->to('/dashboard');
    }
}
```

Digunakan pada:
- `/login`
- `/register`

### AuthFilter

Memerlukan user untuk login:

```php
// Routes.php
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);
```

Digunakan pada:
- `/dashboard`
- `/user/*`
- `/dashboard/*`

## 📊 Tracking Features

### Last Login

Setiap kali user login, waktu login terakhir diupdate:

```php
public function updateLastLogin($id)
{
    return $this->update($id, ['last_login' => date('Y-m-d H:i:s')]);
}
```

## 🚫 Permission Checks

### Admin Check

```php
protected function isAdmin()
{
    $user = auth()->user();
    return $user && property_exists($user, 'role') && $user->role === 'admin';
}
```

### Usage

```php
if (!auth()->loggedIn() || !$this->isAdmin()) {
    return redirect()->to('/dashboard')->with('error', 'Access Denied');
}
```

## 🔑 Managing User Permissions

### Create Admin

```php
// Di form, set role ke 'admin'
<select name="role">
    <option value="admin">Admin</option>
    <option value="user">User</option>
</select>
```

### Change User Role

```php
// Edit user dan ubah role field
public function update($id)
{
    $updateData = [
        'role' => $this->request->getPost('role'),
        // fields lainnya
    ];
    
    return $this->userModel->updateUser($id, $updateData);
}
```

### Deactivate User

```php
// Update status ke 'inactive'
public function update($id)
{
    $updateData = [
        'status' => $this->request->getPost('status'),
        // fields lainnya
    ];
    
    return $this->userModel->updateUser($id, $updateData);
}
```

## 🚀 Best Practices

1. **Selalu check authentication sebelum akses data pribadi**
   ```php
   if (!auth()->loggedIn()) return redirect()->to('/login');
   ```

2. **Selalu check authorization untuk fitur admin**
   ```php
   if (!$this->isAdmin()) return redirect()->to('/dashboard');
   ```

3. **Gunakan CSRF token pada semua form**
   ```php
   <?= csrf_field() ?>
   ```

4. **Hash password sebelum simpan ke database**
   ```php
   $hash = password_hash($password, PASSWORD_DEFAULT);
   ```

5. **Validate semua input dari user**
   ```php
   if (!$validation->withRequest($this->request)->run()) {
       return redirect()->back()->with('errors', $validation->getErrors());
   }
   ```

6. **Gunakan prepared statements untuk query**
   ```php
   $this->db->query('SELECT * FROM users WHERE id = ?', [$id]);
   ```

7. **Jangan expose sensitive info di view**
   ```php
   <!-- JANGAN lakukan ini -->
   <?= $user['password_hash'] ?>
   ```

## 🔄 Session Handling

### Create Session (pada login)

Shield otomatis membuat session setelah login berhasil.

### Access Session Data

```php
$user = auth()->user();
$user->id;       // User ID
$user->email;    // User Email
$user->username; // Username
$user->role;     // User Role (custom field)
```

### Destroy Session (Logout)

```php
<form action="<?= base_url('/logout') ?>" method="POST">
    <?= csrf_field() ?>
    <button type="submit">Logout</button>
</form>
```

## 📝 Customizing Authentication

### Add Custom Fields ke User

1. Buat migration:
   ```bash
   php spark make:migration AddCustomFieldsToUsers
   ```

2. Update migration file
3. Update UserModel allowedFields
4. Update validation rules
5. Update view files

### Add Custom Roles

1. Update migration ENUM constraint
2. Update isAdmin() check
3. Add new permission checks
4. Update controller logic

---

**Remember: Security is everyone's responsibility! 🔒**