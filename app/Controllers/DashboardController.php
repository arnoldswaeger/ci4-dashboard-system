<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Shield\Traits\Authorizable;

class DashboardController extends BaseController
{
    use Authorizable;

    protected $userModel;
    protected $helpers = ['form', 'url', 'security'];

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Display dashboard
     */
    public function index()
    {
        // Check if user is logged in
        if (!auth()->loggedIn()) {
            return redirect()->to('/login');
        }

        $currentUser = auth()->user();
        $data = [
            'title' => 'Dashboard',
            'currentUser' => $currentUser,
            'totalUsers' => $this->userModel->getUserCount(),
            'activeUsers' => count($this->userModel->getActiveUsers()),
            'adminUsers' => count($this->userModel->getUsersByRole('admin')),
            'regularUsers' => count($this->userModel->getUsersByRole('user')),
        ];

        return view('Dashboard/index', $data);
    }

    /**
     * Display user statistics
     */
    public function statistics()
    {
        // Only admin can access
        if (!$this->hasPermission('admin')) {
            return $this->response->setStatusCode(403)->setBody('Forbidden');
        }

        $data = [
            'title' => 'User Statistics',
            'totalUsers' => $this->userModel->getUserCount(),
            'activeUsers' => count($this->userModel->getActiveUsers()),
            'adminUsers' => count($this->userModel->getUsersByRole('admin')),
            'regularUsers' => count($this->userModel->getUsersByRole('user')),
        ];

        return view('Dashboard/statistics', $data);
    }

    /**
     * Display profile
     */
    public function profile()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/login');
        }

        $currentUser = auth()->user();
        $userDetails = $this->userModel->find($currentUser->id);

        $data = [
            'title' => 'Profile',
            'user' => $userDetails,
        ];

        return view('Dashboard/profile', $data);
    }

    /**
     * Check user permission
     */
    protected function hasPermission($role)
    {
        if (!auth()->loggedIn()) {
            return false;
        }

        $user = auth()->user();
        return $user->role === $role;
    }
}
