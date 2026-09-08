<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
    use ResponseTrait;

    protected $userModel;
    protected $helpers = ['form', 'url', 'security'];

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * List all users (Admin only)
     */
    public function index()
    {
        // Check if user is logged in and is admin
        if (!auth()->loggedIn() || !$this->isAdmin()) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }

        $page = $this->request->getVar('page') ?? 1;
        $perPage = $this->request->getVar('per_page') ?? 10;
        $search = $this->request->getVar('search') ?? '';

        if ($search) {
            $users = $this->userModel
                ->where("email LIKE '%{$search}%'")
                ->orWhere("username LIKE '%{$search}%'")
                ->orWhere("full_name LIKE '%{$search}%'")
                ->paginate($perPage, 'default', $page);
            $pager = $this->userModel->pager;
        } else {
            $users = $this->userModel->getUsers($page, $perPage);
            $pager = $this->userModel->pager;
        }

        $data = [
            'title' => 'Manajemen User',
            'users' => $users,
            'pager' => $pager,
            'search' => $search,
            'currentUser' => auth()->user(),
        ];

        return view('User/index', $data);
    }

    /**
     * Show create user form
     */
    public function create()
    {
        if (!auth()->loggedIn() || !$this->isAdmin()) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Tambah User Baru',
            'currentUser' => auth()->user(),
        ];

        return view('User/create', $data);
    }

    /**
     * Store new user
     */
    public function store()
    {
        if (!auth()->loggedIn() || !$this->isAdmin()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Akses ditolak',
            ]);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|alpha_numeric_punct|min_length[3]|is_unique[users.username]',
            'full_name' => 'required|min_length[3]',
            'phone' => 'permit_empty|numeric|min_length[10]',
            'address' => 'permit_empty',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
            'role' => 'required|in_list[admin,user]',
            'status' => 'required|in_list[active,inactive]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userData = [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
        ];

        if ($this->userModel->createUser($userData)) {
            return redirect()->to('/user')->with('success', 'User berhasil ditambahkan.');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan user.');
    }

    /**
     * Show edit user form
     */
    public function edit($id)
    {
        if (!auth()->loggedIn() || !$this->isAdmin()) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'currentUser' => auth()->user(),
        ];

        return view('User/edit', $data);
    }

    /**
     * Update user
     */
    public function update($id)
    {
        if (!auth()->loggedIn() || !$this->isAdmin()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Akses ditolak',
            ]);
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan.');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'username' => "required|alpha_numeric_punct|min_length[3]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|min_length[3]',
            'phone' => 'permit_empty|numeric|min_length[10]',
            'address' => 'permit_empty',
            'role' => 'required|in_list[admin,user]',
            'status' => 'required|in_list[active,inactive]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $updateData = [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
        ];

        // Update password if provided
        if ($this->request->getPost('password')) {
            $passwordValidation = \Config\Services::validation();
            $passwordValidation->setRules([
                'password' => 'required|min_length[8]',
                'password_confirm' => 'required|matches[password]',
            ]);

            if (!$passwordValidation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $passwordValidation->getErrors());
            }

            $updateData['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($this->userModel->updateUser($id, $updateData)) {
            return redirect()->to('/user')->with('success', 'User berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui user.');
    }

    /**
     * Delete user
     */
    public function delete($id)
    {
        if (!auth()->loggedIn() || !$this->isAdmin()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Akses ditolak',
            ]);
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ]);
        }

        // Prevent deleting yourself
        if ($user['id'] === auth()->user()->id) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun sendiri',
            ]);
        }

        if ($this->userModel->deleteUser($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'User berhasil dihapus',
            ]);
        }

        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Gagal menghapus user',
        ]);
    }

    /**
     * Show user details
     */
    public function show($id)
    {
        if (!auth()->loggedIn() || !$this->isAdmin()) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail User',
            'user' => $user,
            'currentUser' => auth()->user(),
        ];

        return view('User/show', $data);
    }

    /**
     * Check if current user is admin
     */
    protected function isAdmin()
    {
        $user = auth()->user();
        return $user && property_exists($user, 'role') && $user->role === 'admin';
    }
}
