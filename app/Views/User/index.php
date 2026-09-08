<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <form method="get" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari user..." value="<?= $search ?>">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Search
            </button>
            <?php if ($search): ?>
                <a href="<?= base_url('/user') ?>" class="btn btn-secondary">
                    <i class="bi bi-x"></i> Clear
                </a>
            <?php endif; ?>
        </form>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?= base_url('/user/create') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add New User
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="mb-0">User Management</h6>
    </div>
    <div class="card-body">
        <?php if (empty($users)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Tidak ada user ditemukan.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Full Name</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><strong><?= $user['username'] ?></strong></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['full_name'] ?></td>
                                <td>
                                    <span class="badge badge-<?= $user['role'] ?>">
                                        <?= strtoupper($user['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $user['status'] ?>">
                                        <?= ucfirst($user['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $user['last_login'] ? date('d M Y H:i', strtotime($user['last_login'])) : '-' ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('/user/show/' . $user['id']) ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= base_url('/user/edit/' . $user['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <?php if ($user['id'] !== $currentUser->id): ?>
                                        <button class="btn btn-sm btn-danger" onclick="deleteUser(<?= $user['id'] ?>)" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($pager): ?>
                <nav class="mt-3">
                    <?= $pager->links() ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
function deleteUser(userId) {
    if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
        fetch(`<?= base_url('/user/delete') ?>/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_token() ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User berhasil dihapus');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>