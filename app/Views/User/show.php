<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">User Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-4 text-center">
                    <?php if ($user['avatar']): ?>
                        <img src="<?= base_url('/uploads/avatars/' . $user['avatar']) ?>" alt="Avatar" class="rounded-circle" width="120" height="120" style="object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                            <i class="bi bi-person text-white" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Username</label>
                        <p class="form-control-plaintext"><strong><?= $user['username'] ?></strong></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Email</label>
                        <p class="form-control-plaintext"><?= $user['email'] ?></p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Full Name</label>
                    <p class="form-control-plaintext"><?= $user['full_name'] ?></p>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Phone</label>
                        <p class="form-control-plaintext"><?= $user['phone'] ?? '-' ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Role</label>
                        <p class="form-control-plaintext">
                            <span class="badge badge-<?= $user['role'] ?>"><?= strtoupper($user['role']) ?></span>
                        </p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Address</label>
                    <p class="form-control-plaintext"><?= $user['address'] ?? '-' ?></p>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Status</label>
                        <p class="form-control-plaintext">
                            <span class="badge badge-<?= $user['status'] ?>"><?= ucfirst($user['status']) ?></span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Member Since</label>
                        <p class="form-control-plaintext"><?= date('d M Y', strtotime($user['created_at'])) ?></p>
                    </div>
                </div>

                <?php if ($user['last_login']): ?>
                    <div class="mb-3">
                        <label class="form-label text-muted">Last Login</label>
                        <p class="form-control-plaintext"><?= date('d M Y H:i', strtotime($user['last_login'])) ?></p>
                    </div>
                <?php endif; ?>

                <hr>

                <div class="d-grid gap-2 d-sm-flex justify-content-center">
                    <a href="<?= base_url('/user/edit/' . $user['id']) ?>" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="<?= base_url('/user') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>