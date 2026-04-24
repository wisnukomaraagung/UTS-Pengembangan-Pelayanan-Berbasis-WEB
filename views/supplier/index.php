<?php require_once __DIR__ . '/../layout/header.php'; ?>

<?php
if (!empty($data['message'])) {
    [$type, $msg] = explode('|', $data['message'], 2);
    $alertClass   = ($type === 'success') ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $alertClass alert-dismissible fade show'><i class='fas fa-" . ($type==='success' ? 'check-circle' : 'exclamation-circle') . " me-2'></i>$msg <button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
}
?>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg,#2d6a4f,#52b788)">
            <div class="number"><?= $data['total'] ?></div>
            <div class="label"><i class="fas fa-truck me-1"></i> Total Supplier</div>
        </div>
    </div>
</div>

<div class="mb-3">
    <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="fas fa-plus me-1"></i> Tambah Supplier
    </button>
</div>

<div class="card">
    <div class="card-header"><i class="fas fa-truck me-2"></i>Daftar Supplier</div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Supplier</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['supplier'])): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data supplier</td></tr>
                <?php else: ?>
                    <?php foreach ($data['supplier'] as $i => $s): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= htmlspecialchars($s['nama_supplier']) ?></strong></td>
                        <td><?= htmlspecialchars($s['alamat']) ?></td>
                        <td><?= htmlspecialchars($s['telepon']) ?></td>
                        <td><?= htmlspecialchars($s['email']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" 
                                onclick="editSupplier(<?= $s['id'] ?>, '<?= addslashes($s['nama_supplier']) ?>', '<?= addslashes($s['alamat']) ?>', '<?= addslashes($s['telepon']) ?>', '<?= addslashes($s['email']) ?>')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--primary);color:#fff">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Supplier</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="create">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Supplier <span class="text-danger">*</span></label>
                        <input type="text" name="nama_supplier" class="form-control" required placeholder="Contoh: PT Maju Jaya">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Telepon</label>
                            <input type="text" name="telepon" class="form-control" placeholder="08xx-xxxx-xxxx">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="contoh@email.com">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-accent"><i class="fas fa-save me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background:#f0a500;color:#fff">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Supplier</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Supplier</label>
                        <input type="text" name="nama_supplier" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat</label>
                        <textarea name="alamat" id="edit_alamat" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Telepon</label>
                            <input type="text" name="telepon" id="edit_telp" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editSupplier(id, nama, alamat, telp, email) {
    document.getElementById('edit_id').value    = id;
    document.getElementById('edit_nama').value  = nama;
    document.getElementById('edit_alamat').value= alamat;
    document.getElementById('edit_telp').value  = telp;
    document.getElementById('edit_email').value = email;
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
