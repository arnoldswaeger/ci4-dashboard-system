<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - CI4 Dashboard System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #858796;
            --success: #1cc88a;
            --danger: #e74c3c;
            --warning: #f6c23e;
            --info: #17a2b8;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--primary) 10%, #224abe 100%);
            min-height: 100vh;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem;
            border-left: 0.25rem solid transparent;
            transition: all 0.3s ease-in-out;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: #fff;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 1.25rem 1.5rem;
            border-bottom: 0.125rem solid #e3e6f0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .content {
            flex: 1;
            padding: 2rem;
        }

        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
            border-radius: 0.35rem;
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 0.125rem solid #e3e6f0;
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: #495057;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: #224abe;
            border-color: #224abe;
        }

        .badge-admin {
            background-color: var(--danger);
        }

        .badge-user {
            background-color: var(--info);
        }

        .badge-active {
            background-color: var(--success);
        }

        .badge-inactive {
            background-color: var(--secondary);
        }

        .stat-card {
            border-left: 0.25rem solid var(--primary);
        }

        .stat-card.warning {
            border-left-color: var(--warning);
        }

        .stat-card.success {
            border-left-color: var(--success);
        }

        .stat-card.danger {
            border-left-color: var(--danger);
        }

        .stat-icon {
            font-size: 2rem;
            color: var(--primary);
        }

        .stat-card.warning .stat-icon {
            color: var(--warning);
        }

        .stat-card.success .stat-icon {
            color: var(--success);
        }

        .stat-card.danger .stat-icon {
            color: var(--danger);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }

            .main-content {
                margin-left: 0;
            }

            .content {
                padding: 1rem;
            }
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="p-3">
                <h4 class="text-white mb-4">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </h4>
            </div>

            <nav class="nav flex-column">
                <a class="nav-link <?= (current_url() == base_url('/dashboard')) ? 'active' : '' ?>" href="<?= base_url('/dashboard') ?>">
                    <i class="bi bi-house"></i> Home
                </a>

                <?php if (auth()->loggedIn() && auth()->user()->role === 'admin'): ?>
                    <a class="nav-link <?= (strpos(current_url(), '/user') !== false) ? 'active' : '' ?>" href="<?= base_url('/user') ?>">
                        <i class="bi bi-people"></i> Manajemen User
                    </a>
                    <a class="nav-link <?= (strpos(current_url(), '/dashboard/statistics') !== false) ? 'active' : '' ?>" href="<?= base_url('/dashboard/statistics') ?>">
                        <i class="bi bi-bar-chart"></i> Statistik
                    </a>
                <?php endif; ?>

                <a class="nav-link <?= (strpos(current_url(), '/dashboard/profile') !== false) ? 'active' : '' ?>" href="<?= base_url('/dashboard/profile') ?>">
                    <i class="bi bi-person"></i> Profile
                </a>

                <hr class="text-white-50">

                <form action="<?= base_url('/logout') ?>" method="POST" class="d-inline-block w-100">
                    <?= csrf_field() ?>
                    <button type="submit" class="nav-link text-decoration-none" style="border: none; background: none;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content w-100">
            <!-- Topbar -->
            <div class="topbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?= $title ?? 'Dashboard' ?></h5>
                    <?php if (auth()->loggedIn()): ?>
                        <div>
                            <span class="me-3">
                                Welcome, <strong><?= auth()->user()->username ?></strong>
                            </span>
                            <span class="badge badge-admin"><?= strtoupper(auth()->user()->role) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Flash Messages -->
            <div class="content">
                <?php if (session()->has('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <?= session('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> <?= session('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($errors) && is_array($errors)): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <strong>Kesalahan Validasi:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach ($errors as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>