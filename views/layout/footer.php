
</div><!-- end #main -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Auto-close alert setelah 4 detik
document.querySelectorAll('.alert').forEach(a => {
    setTimeout(() => { a.style.display = 'none'; }, 4000);
});

// Hitung total transaksi otomatis (untuk form transaksi)
function hitungTotal() {
    const harga  = parseFloat(document.getElementById('harga_satuan')?.value) || 0;
    const jumlah = parseInt(document.getElementById('jumlah')?.value) || 0;
    const total  = document.getElementById('total_harga');
    if (total) total.value = harga * jumlah;
}
</script>
</body>
</html>
