<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'email',
        'username',
        'full_name',
        'phone',
        'address',
        'role',
        'status',
        'avatar',
        'password_hash',
        'last_login',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'email' => [
            'rules' => 'required|valid_email|is_unique[users.email,id,{id}]',
            'errors' => [
                'required' => 'Email harus diisi',
                'valid_email' => 'Email tidak valid',
                'is_unique' => 'Email sudah terdaftar',
            ]
        ],
        'username' => [
            'rules' => 'required|alpha_numeric_punct|min_length[3]|is_unique[users.username,id,{id}]',
            'errors' => [
                'required' => 'Username harus diisi',
                'alpha_numeric_punct' => 'Username hanya boleh berisi huruf, angka, dan simbol',
                'min_length' => 'Username minimal 3 karakter',
                'is_unique' => 'Username sudah terdaftar',
            ]
        ],
        'full_name' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'Nama lengkap harus diisi',
                'min_length' => 'Nama lengkap minimal 3 karakter',
            ]
        ],
        'phone' => [
            'rules' => 'permit_empty|numeric|min_length[10]',
            'errors' => [
                'numeric' => 'Nomor telepon harus berupa angka',
                'min_length' => 'Nomor telepon minimal 10 digit',
            ]
        ],
        'role' => [
            'rules' => 'required|in_list[admin,user]',
            'errors' => [
                'required' => 'Role harus diisi',
                'in_list' => 'Role tidak valid',
            ]
        ],
        'status' => [
            'rules' => 'required|in_list[active,inactive]',
            'errors' => [
                'required' => 'Status harus diisi',
                'in_list' => 'Status tidak valid',
            ]
        ],
    ];

    /**
     * Get all users with pagination
     */
    public function getUsers($page = 1, $perPage = 10)
    {
        return $this->paginate($perPage, 'default', $page);
    }

    /**
     * Get user by email
     */
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Get user by username
     */
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Get user by ID with full details
     */
    public function getUserDetails($id)
    {
        return $this->find($id);
    }

    /**
     * Create new user
     */
    public function createUser($data)
    {
        return $this->insert($data);
    }

    /**
     * Update user
     */
    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        return $this->delete($id);
    }

    /**
     * Get user count
     */
    public function getUserCount()
    {
        return $this->countAllResults();
    }

    /**
     * Get users by role
     */
    public function getUsersByRole($role)
    {
        return $this->where('role', $role)->findAll();
    }

    /**
     * Get active users
     */
    public function getActiveUsers()
    {
        return $this->where('status', 'active')->findAll();
    }

    /**
     * Update last login
     */
    public function updateLastLogin($id)
    {
        return $this->update($id, ['last_login' => date('Y-m-d H:i:s')]);
    }
}
