<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Edit User</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/user/update/' . $user['id']) ?>" method="post" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback" style="display: block;"><?= $errors['email'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username', $user['username']) ?>" required>
                        <?php if (isset($errors['username'])): ?>
                            <div class="invalid-feedback" style="display: block;"><?= $errors['username'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>" id="full_name" name="full_name" value="<?= old('full_name', $user['full_name']) ?>" required>
                        <?php if (isset($errors['full_name'])): ?>
                            <div class="invalid-feedback" style="display: block;"><?= $errors['full_name'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" id="phone" name="phone" value="<?= old('phone', $user['phone']) ?>">
                        <?php if (isset($errors['phone'])): ?>
                            <div class="invalid-feedback" style="display: block;"><?= $errors['phone'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"><?= old('address', $user['address']) ?></textarea>
                    </div>

                    <hr>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Kosongkan field password jika tidak ingin mengubahnya
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="password" name="password">
                        <small class="form-text text-muted">Minimal 8 karakter</small>
                        <?php if (isset($errors['password'])): ?>
                            <div class="invalid-feedback" style="display: block;"><?= $errors['password'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" id="password_confirm" name="password_confirm">
                        <?php if (isset($errors['password_confirm'])): ?>
                            <div class="invalid-feedback" style="display: block;"><?= $errors['password_confirm'] ?></div>
                        <?php endif; ?>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select <?= isset($errors['role']) ? 'is-invalid' : '' ?>" id="role" name="role" required>
                            <option value="admin" <?= old('role', $user['role']) === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="user" <?= old('role', $user['role']) === 'user' ? 'selected' : '' ?>>User</option>
                        </select>
                        <?php if (isset($errors['role'])): ?>
                            <div class="invalid-feedback" style="display: block;"><?= $errors['role'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select <?= isset($errors['status']) ? 'is-invalid' : '' ?>" id="status" name="status" required>
                            <option value="active" <?= old('status', $user['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= old('status', $user['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                        <?php if (isset($errors['status'])): ?>
                            <div class="invalid-feedback" style="display: block;"><?= $errors['status'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid gap-2 d-sm-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update User
                        </button>
                        <a href="<?= base_url('/user') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>