<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">Total Users</p>
                        <h4 class="mb-0"><?= $totalUsers ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">Active Users</p>
                        <h4 class="mb-0"><?= $activeUsers ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">Admin Users</p>
                        <h4 class="mb-0"><?= $adminUsers ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon">
                        <i class="bi bi-person-check-fill"></i>
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
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">User Distribution</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td><strong>Admin Users</strong></td>
                                <td class="text-end"><?= $adminUsers ?></td>
                                <td class="text-end"><?= $totalUsers > 0 ? round(($adminUsers / $totalUsers) * 100, 2) : 0 ?>%</td>
                            </tr>
                            <tr>
                                <td><strong>Regular Users</strong></td>
                                <td class="text-end"><?= $regularUsers ?></td>
                                <td class="text-end"><?= $totalUsers > 0 ? round(($regularUsers / $totalUsers) * 100, 2) : 0 ?>%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Status Distribution</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p class="mb-1">Active Users</p>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: <?= $totalUsers > 0 ? ($activeUsers / $totalUsers * 100) : 0 ?>%"></div>
                    </div>
                    <small class="text-muted"><?= $activeUsers ?> / <?= $totalUsers ?></small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Summary</h6>
            </div>
            <div class="card-body">
                <ul>
                    <li>Total users terdaftar: <strong><?= $totalUsers ?></strong></li>
                    <li>Users yang sedang aktif: <strong><?= $activeUsers ?></strong></li>
                    <li>Persentase user aktif: <strong><?= $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 2) : 0 ?>%</strong></li>
                    <li>Jumlah admin: <strong><?= $adminUsers ?></strong></li>
                    <li>Jumlah user biasa: <strong><?= $regularUsers ?></strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>