<?php require_once __DIR__ . '/../layout/header.php'; ?>

<?php
if (!empty($data['message'])) {
    [$type, $msg] = explode('|', $data['message'], 2);
    $alertClass   = ($type === 'success') ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $alertClass alert-dismissible fade show'><i class='fas fa-" . ($type==='success' ? 'check-circle' : 'exclamation-circle') . " me-2'></i>$msg <button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
}
?>

<!-- STAT CARDS -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#c0392b,#e74c3c)">
            <div class="number"><?= $data['total'] ?></div>
            <div class="label"><i class="fas fa-receipt me-1"></i> Total Transaksi</div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#16a085,#1abc9c)">
            <div class="number" style="font-size:1.4rem">Rp <?= number_format($data['pendapatan'],0,',','.') ?></div>
            <div class="label"><i class="fas fa-money-bill me-1"></i> Total Pendapatan (Selesai)</div>
        </div>
    </div>
</div>

<div class="mb-3">
    <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="fas fa-plus me-1"></i> Tambah Transaksi
    </button>
</div>

<div class="card">
    <div class="card-header"><i class="fas fa-receipt me-2"></i>Daftar Transaksi</div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['transaksi'])): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada transaksi</td></tr>
                <?php else: ?>
                    <?php foreach ($data['transaksi'] as $i => $t): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><code><?= htmlspecialchars($t['kode_transaksi']) ?></code></td>
                        <td><?= htmlspecialchars($t['nama_produk'] ?? '-') ?></td>
                        <td><?= $t['jumlah'] ?> pcs</td>
                        <td><strong class="text-success">Rp <?= number_format($t['total_harga'],0,',','.') ?></strong></td>
                        <td><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                        <td>
                            <?php
                                $badge = ['pending'=>'badge-pending','selesai'=>'badge-selesai','batal'=>'badge-batal'];
                                $bc    = $badge[$t['status']] ?? 'bg-secondary';
                            ?>
                            <span class="badge <?= $bc ?>"><?= ucfirst($t['status']) ?></span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                onclick="editTrx(<?= $t['id'] ?>, <?= $t['id_produk'] ?>, <?= $t['jumlah'] ?>, '<?= $t['tanggal'] ?>', '<?= $t['status'] ?>')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $t['id'] ?>">
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

<!-- DATA HARGA PRODUK untuk JS -->
<script>
const hargaProduk = {
    <?php foreach ($data['produk'] as $p): ?>
    <?= $p['id'] ?>: <?= $p['harga'] ?>,
    <?php endforeach; ?>
};
</script>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--primary);color:#fff">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Transaksi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="create">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Produk <span class="text-danger">*</span></label>
                            <select name="id_produk" id="produk_select" class="form-select" required onchange="updateHarga(this, 'harga_tampil', 'jumlah_inp', 'total_harga')">
                                <option value="">-- Pilih Produk --</option>
                                <?php foreach ($data['produk'] as $p): ?>
                                    <option value="<?= $p['id'] ?>">
                                        <?= htmlspecialchars($p['nama_produk']) ?> (Rp <?= number_format($p['harga'],0,',','.') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Harga Satuan</label>
                            <input type="text" id="harga_tampil" class="form-control" readonly placeholder="Otomatis">
                            <input type="hidden" id="harga_satuan" name="harga_satuan">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" id="jumlah_inp" class="form-control" required min="1" value="1"
                                   oninput="hitungTotal()">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Total Harga</label>
                            <input type="number" name="total_harga" id="total_harga" class="form-control" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="selesai">Selesai</option>
                                <option value="batal">Batal</option>
                            </select>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:#f0a500;color:#fff">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Transaksi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Produk</label>
                            <select name="id_produk" id="edit_produk" class="form-select" required
                                    onchange="updateHarga(this, 'edit_harga_tampil', 'edit_jumlah', 'edit_total')">
                                <option value="">-- Pilih Produk --</option>
                                <?php foreach ($data['produk'] as $p): ?>
                                    <option value="<?= $p['id'] ?>">
                                        <?= htmlspecialchars($p['nama_produk']) ?> (Rp <?= number_format($p['harga'],0,',','.') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Harga Satuan</label>
                            <input type="text" id="edit_harga_tampil" class="form-control" readonly>
                            <input type="hidden" id="edit_harga_sat">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Jumlah</label>
                            <input type="number" name="jumlah" id="edit_jumlah" class="form-control" required min="1"
                                   oninput="hitungTotalEdit()">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Total Harga</label>
                            <input type="number" name="total_harga" id="edit_total" class="form-control" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Tanggal</label>
                            <input type="date" name="tanggal" id="edit_tgl" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="selesai">Selesai</option>
                                <option value="batal">Batal</option>
                            </select>
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
function updateHarga(select, hargaId, jumlahId, totalId) {
    const id    = select.value;
    const harga = hargaProduk[id] || 0;
    document.getElementById(hargaId).value = 'Rp ' + harga.toLocaleString('id-ID');
    // Simpan harga di hidden field
    if (hargaId === 'harga_tampil') document.getElementById('harga_satuan').value = harga;
    if (hargaId === 'edit_harga_tampil') document.getElementById('edit_harga_sat').value = harga;
    // Hitung total
    const jumlah = parseInt(document.getElementById(jumlahId).value) || 1;
    document.getElementById(totalId).value = harga * jumlah;
}

function hitungTotal() {
    const harga  = parseFloat(document.getElementById('harga_satuan').value) || 0;
    const jumlah = parseInt(document.getElementById('jumlah_inp').value) || 0;
    document.getElementById('total_harga').value = harga * jumlah;
}

function hitungTotalEdit() {
    const harga  = parseFloat(document.getElementById('edit_harga_sat').value) || 0;
    const jumlah = parseInt(document.getElementById('edit_jumlah').value) || 0;
    document.getElementById('edit_total').value = harga * jumlah;
}

function editTrx(id, id_produk, jumlah, tanggal, status) {
    document.getElementById('edit_id').value     = id;
    document.getElementById('edit_produk').value = id_produk;
    document.getElementById('edit_jumlah').value = jumlah;
    document.getElementById('edit_tgl').value    = tanggal;
    document.getElementById('edit_status').value = status;
    
    // Update harga tampilan
    const harga = hargaProduk[id_produk] || 0;
    document.getElementById('edit_harga_tampil').value = 'Rp ' + harga.toLocaleString('id-ID');
    document.getElementById('edit_harga_sat').value    = harga;
    document.getElementById('edit_total').value        = harga * jumlah;
    
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
