<?php
// models/Transaksi.php

require_once __DIR__ . '/../config/database.php';

class Transaksi {
    private $db;
    private $table = 'transaksi';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $sql = "SELECT t.*, p.nama_produk, p.harga
                FROM {$this->table} t
                LEFT JOIN produk p ON t.id_produk = p.id
                ORDER BY t.id DESC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT t.*, p.nama_produk, p.harga
                FROM {$this->table} t
                LEFT JOIN produk p ON t.id_produk = p.id
                WHERE t.id = $id";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    public function create($data) {
        // Generate kode transaksi otomatis
        $kode   = 'TRX-' . date('Ymd') . '-' . str_pad(rand(1,999), 3, '0', STR_PAD_LEFT);
        $id_prod= (int)$data['id_produk'];
        $jumlah = (int)$data['jumlah'];
        $total  = (float)$data['total_harga'];
        $tgl    = $this->db->real_escape_string($data['tanggal']);
        $status = $this->db->real_escape_string($data['status']);
        $sql    = "INSERT INTO {$this->table} (kode_transaksi, id_produk, jumlah, total_harga, tanggal, status)
                   VALUES ('$kode', $id_prod, $jumlah, $total, '$tgl', '$status')";
        return $this->db->query($sql);
    }

    public function update($id, $data) {
        $id     = (int)$id;
        $id_prod= (int)$data['id_produk'];
        $jumlah = (int)$data['jumlah'];
        $total  = (float)$data['total_harga'];
        $tgl    = $this->db->real_escape_string($data['tanggal']);
        $status = $this->db->real_escape_string($data['status']);
        $sql    = "UPDATE {$this->table} 
                   SET id_produk=$id_prod, jumlah=$jumlah, total_harga=$total, 
                       tanggal='$tgl', status='$status'
                   WHERE id=$id";
        return $this->db->query($sql);
    }

    public function delete($id) {
        $id  = (int)$id;
        $sql = "DELETE FROM {$this->table} WHERE id=$id";
        return $this->db->query($sql);
    }

    public function count() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $result->fetch_assoc()['total'];
    }

    public function totalPendapatan() {
        $result = $this->db->query("SELECT SUM(total_harga) as total FROM {$this->table} WHERE status='selesai'");
        return $result->fetch_assoc()['total'] ?? 0;
    }
}
?>
