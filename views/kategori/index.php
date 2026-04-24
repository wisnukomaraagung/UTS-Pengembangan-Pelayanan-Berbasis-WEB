<?php require_once __DIR__ . '/../layout/header.php'; ?>

<?php
// Tampilkan pesan notifikasi
if (!empty($data['message'])) {
    [$type, $msg] = explode('|', $data['message'], 2);
    $alertClass   = ($type === 'success') ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $alertClass alert-dismissible fade show'><i class='fas fa-" . ($type==='success' ? 'check-circle' : 'exclamation-circle') . " me-2'></i>$msg <button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
}
?>

<!-- STAT -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg,#1e3a5f,#2d6a9f)">
            <div class="number"><?= $data['total'] ?></div>
            <div class="label"><i class="fas fa-tags me-1"></i> Total Kategori</div>
        </div>
    </div>
</div>

<!-- TOMBOL TAMBAH -->
<div class="mb-3">
    <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="fas fa-plus me-1"></i> Tambah Kategori
    </button>
</div>

<!-- TABEL -->
<div class="card">
    <div class="card-header"><i class="fas fa-tags me-2"></i>Daftar Kategori</div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Dibuat</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['kategori'])): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data kategori</td></tr>
                <?php else: ?>
                    <?php foreach ($data['kategori'] as $i => $k): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= htmlspecialchars($k['nama_kategori']) ?></strong></td>
                        <td><?= htmlspecialchars($k['deskripsi']) ?></td>
                        <td><?= date('d/m/Y', strtotime($k['created_at'])) ?></td>
                        <td>
                            <!-- Tombol Edit -->
                            <button class="btn btn-sm btn-warning" 
                                onclick="editKategori(<?= $k['id'] ?>, '<?= addslashes($k['nama_kategori']) ?>', '<?= addslashes($k['deskripsi']) ?>')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <!-- Tombol Hapus -->
                            <form method="POST" style="display:inline" 
                                  onsubmit="return confirm('Yakin hapus kategori ini?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $k['id'] ?>">
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
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="create">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" class="form-control" required placeholder="Contoh: Elektronik">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi kategori..."></textarea>
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
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_desk" class="form-control" rows="3"></textarea>
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
function editKategori(id, nama, desk) {
    document.getElementById('edit_id').value   = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_desk').value = desk;
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
