<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">Total Users</p>
                        <h4 class="mb-0"><?= $totalUsers ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">Active Users</p>
                        <h4 class="mb-0"><?= $activeUsers ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">Administrators</p>
                        <h4 class="mb-0"><?= $adminUsers ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">Regular Users</p>
                        <h4 class="mb-0"><?= $regularUsers ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Welcome to Dashboard</h6>
            </div>
            <div class="card-body">
                <p>Halo <strong><?= $currentUser->username ?></strong>, selamat datang di sistem dashboard kami.</p>
                <p>Anda login sebagai <span class="badge badge-<?= $currentUser->role ?>"><?= strtoupper($currentUser->role) ?></span></p>
                
                <?php if ($currentUser->role === 'admin'): ?>
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle"></i> Sebagai administrator, Anda memiliki akses penuh ke semua fitur sistem.
                        <a href="<?= base_url('/user') ?>" class="alert-link">Kelola user sekarang</a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle"></i> Anda dapat melihat dan mengedit profile Anda sendiri.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Quick Info</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted mb-1">Username</label>
                    <p class="mb-0"><?= $currentUser->username ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted mb-1">Email</label>
                    <p class="mb-0"><?= $currentUser->email ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted mb-1">Role</label>
                    <p class="mb-0">
                        <span class="badge badge-<?= $currentUser->role ?>">
                            <?= strtoupper($currentUser->role) ?>
                        </span>
                    </p>
                </div>
                <a href="<?= base_url('/dashboard/profile') ?>" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-person"></i> View Profile
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>