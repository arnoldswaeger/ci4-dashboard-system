# 📊 API Documentation

## Dashboard Controller

### GET /dashboard
**Description**: Display main dashboard
**Auth Required**: Yes
**Role**: All authenticated users

**Response**:
```php
[
    'title' => 'Dashboard',
    'currentUser' => User object,
    'totalUsers' => int,
    'activeUsers' => int,
    'adminUsers' => int,
    'regularUsers' => int,
]
```

### GET /dashboard/statistics
**Description**: Display user statistics
**Auth Required**: Yes
**Role**: Admin only

**Response**:
```php
[
    'title' => 'User Statistics',
    'totalUsers' => int,
    'activeUsers' => int,
    'adminUsers' => int,
    'regularUsers' => int,
]
```

### GET /dashboard/profile
**Description**: Display user profile
**Auth Required**: Yes
**Role**: All authenticated users

**Response**:
```php
[
    'title' => 'Profile',
    'user' => array [
        'id' => int,
        'email' => string,
        'username' => string,
        'full_name' => string,
        'phone' => string,
        'address' => string,
        'role' => string,
        'status' => string,
        'avatar' => string|null,
        'last_login' => datetime,
        'created_at' => datetime,
        'updated_at' => datetime,
    ]
]
```

---

## User Controller

### GET /user
**Description**: List all users with pagination and search
**Auth Required**: Yes
**Role**: Admin only
**Query Parameters**:
- `page` (int, optional): Page number, default 1
- `per_page` (int, optional): Items per page, default 10
- `search` (string, optional): Search by email, username, or full_name

**Response**:
```php
[
    'title' => 'Manajemen User',
    'users' => array of user objects,
    'pager' => Pager object,
    'search' => string,
    'currentUser' => User object,
]
```

**Example Request**:
```
GET /user?page=1&per_page=10&search=admin
```

### GET /user/create
**Description**: Show create user form
**Auth Required**: Yes
**Role**: Admin only

**Response**: HTML form

### POST /user/store
**Description**: Create new user
**Auth Required**: Yes
**Role**: Admin only

**Request Body**:
```json
{
    "email": "newuser@example.com",
    "username": "newuser",
    "full_name": "New User",
    "phone": "081234567890",
    "address": "Jakarta",
    "password": "SecurePassword123",
    "password_confirm": "SecurePassword123",
    "role": "user",
    "status": "active"
}
```

**Validation Rules**:
```php
'email' => 'required|valid_email|is_unique[users.email]',
'username' => 'required|alpha_numeric_punct|min_length[3]|is_unique[users.username]',
'full_name' => 'required|min_length[3]',
'phone' => 'permit_empty|numeric|min_length[10]',
'password' => 'required|min_length[8]',
'password_confirm' => 'required|matches[password]',
'role' => 'required|in_list[admin,user]',
'status' => 'required|in_list[active,inactive]',
```

**Response**: Redirect to /user with success message

**Error Response**: Redirect back with validation errors

### GET /user/edit/:id
**Description**: Show edit user form
**Auth Required**: Yes
**Role**: Admin only
**Parameters**:
- `id` (int): User ID

**Response**: HTML form with user data

**Error Response**: 404 if user not found

### POST /user/update/:id
**Description**: Update user data
**Auth Required**: Yes
**Role**: Admin only
**Parameters**:
- `id` (int): User ID

**Request Body** (password optional):
```json
{
    "email": "updated@example.com",
    "username": "updateduser",
    "full_name": "Updated Name",
    "phone": "081234567890",
    "address": "Jakarta",
    "password": "NewPassword123",
    "password_confirm": "NewPassword123",
    "role": "admin",
    "status": "active"
}
```

**Response**: Redirect to /user with success message

**Error Response**: Redirect back with validation errors

### DELETE /user/delete/:id
**Description**: Delete user (soft delete)
**Auth Required**: Yes
**Role**: Admin only
**Parameters**:
- `id` (int): User ID

**Response**:
```json
{
    "success": true,
    "message": "User berhasil dihapus"
}
```

**Error Responses**:
```json
{
    "success": false,
    "message": "Akses ditolak"
}
```

```json
{
    "success": false,
    "message": "User tidak ditemukan"
}
```

```json
{
    "success": false,
    "message": "Anda tidak dapat menghapus akun sendiri"
}
```

### GET /user/show/:id
**Description**: View user details
**Auth Required**: Yes
**Role**: Admin only
**Parameters**:
- `id` (int): User ID

**Response**: HTML page with user details

**Error Response**: Redirect to /user with error message if not found

---

## Authentication Endpoints (Shield)

### GET /login
**Description**: Show login form
**Auth Required**: No (redirects to dashboard if logged in)

### POST /login
**Description**: Process login
**Auth Required**: No

**Request Body**:
```json
{
    "email": "admin@example.com",
    "password": "Admin123456",
    "remember": true
}
```

**Response**: Redirect to /dashboard on success

**Error Response**: Redirect to /login with error message

### GET /register
**Description**: Show registration form
**Auth Required**: No (redirects to dashboard if logged in)
**Note**: Dapat didisable di .env: `auth.allowRegistration = false`

### POST /register
**Description**: Process registration
**Auth Required**: No

**Request Body**:
```json
{
    "email": "newuser@example.com",
    "username": "newuser",
    "password": "Password123456",
    "password_confirm": "Password123456"
}
```

### POST /logout
**Description**: Process logout
**Auth Required**: Yes
**CSRF Token Required**: Yes

**Request**:
```html
<form action="/logout" method="POST">
    <?= csrf_field() ?>
    <button type="submit">Logout</button>
</form>
```

**Response**: Redirect to /login

---

## HTTP Status Codes

| Code | Meaning |
|------|----------|
| 200 | OK - Request successful |
| 302 | Found - Redirect |
| 400 | Bad Request - Validation error |
| 403 | Forbidden - Access denied |
| 404 | Not Found - Resource not found |
| 500 | Internal Server Error |

---

## Error Handling

### Validation Errors

```php
if (!$validation->withRequest($this->request)->run()) {
    return redirect()->back()->withInput()->with('errors', $validation->getErrors());
}
```

Display di view:
```php
<?php if (isset($errors) && is_array($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
```

### Flash Messages

```php
// Set flash message
return redirect()->to('/dashboard')->with('success', 'User berhasil ditambahkan');
return redirect()->to('/dashboard')->with('error', 'Terjadi kesalahan');

// Display di view
<?php if (session()->has('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>
```

---

## Rate Limiting

Not implemented in this version. Consider adding:

```bash
composer require codeigniter4/shield
```

Then configure in `.env`:
```ini
auth.rateLimit = true
auth.rateLimitAttempts = 5
auth.rateLimitWindow = 3600
```

---

## CORS Headers

Not implemented for web application (only relevant for API).

---

**Last Updated**: 2024
**Version**: 1.0.0