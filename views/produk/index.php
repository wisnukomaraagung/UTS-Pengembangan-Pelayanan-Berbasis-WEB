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
        <div class="stat-card" style="background: linear-gradient(135deg,#7b2d8b,#b066c5)">
            <div class="number"><?= $data['total'] ?></div>
            <div class="label"><i class="fas fa-box me-1"></i> Total Produk</div>
        </div>
    </div>
</div>

<div class="mb-3">
    <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="fas fa-plus me-1"></i> Tambah Produk
    </button>
</div>

<div class="card">
    <div class="card-header"><i class="fas fa-box me-2"></i>Daftar Produk</div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Supplier</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['produk'])): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data produk</td></tr>
                <?php else: ?>
                    <?php foreach ($data['produk'] as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <strong><?= htmlspecialchars($p['nama_produk']) ?></strong>
                            <br><small class="text-muted"><?= htmlspecialchars($p['deskripsi']) ?></small>
                        </td>
                        <td><strong class="text-success">Rp <?= number_format($p['harga'],0,',','.') ?></strong></td>
                        <td>
                            <span class="badge <?= $p['stok'] < 10 ? 'bg-danger' : 'bg-success' ?>">
                                <?= $p['stok'] ?> pcs
                            </span>
                        </td>
                        <td><?= htmlspecialchars($p['nama_kategori'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($p['nama_supplier'] ?? '-') ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                onclick="editProduk(<?= $p['id'] ?>, '<?= addslashes($p['nama_produk']) ?>', <?= $p['harga'] ?>, <?= $p['stok'] ?>, <?= $p['id_kategori'] ?>, <?= $p['id_supplier'] ?>, '<?= addslashes($p['deskripsi']) ?>')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--primary);color:#fff">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Produk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="create">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="nama_produk" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga" class="form-control" required min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Stok</label>
                            <input type="number" name="stok" class="form-control" value="0" min="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="id_kategori" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($data['kategori'] as $k): ?>
                                    <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Supplier</label>
                            <select name="id_supplier" class="form-select">
                                <option value="">-- Pilih Supplier --</option>
                                <?php foreach ($data['supplier'] as $s): ?>
                                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama_supplier']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="2"></textarea>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:#f0a500;color:#fff">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Produk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Produk</label>
                            <input type="text" name="nama_produk" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Harga (Rp)</label>
                            <input type="number" name="harga" id="edit_harga" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Stok</label>
                            <input type="number" name="stok" id="edit_stok" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="id_kategori" id="edit_kat" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($data['kategori'] as $k): ?>
                                    <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Supplier</label>
                            <select name="id_supplier" id="edit_sup" class="form-select">
                                <option value="">-- Pilih Supplier --</option>
                                <?php foreach ($data['supplier'] as $s): ?>
                                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama_supplier']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_desk" class="form-control" rows="2"></textarea>
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
function editProduk(id, nama, harga, stok, id_kat, id_sup, desk) {
    document.getElementById('edit_id').value    = id;
    document.getElementById('edit_nama').value  = nama;
    document.getElementById('edit_harga').value = harga;
    document.getElementById('edit_stok').value  = stok;
    document.getElementById('edit_desk').value  = desk;
    document.getElementById('edit_kat').value   = id_kat;
    document.getElementById('edit_sup').value   = id_sup;
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
