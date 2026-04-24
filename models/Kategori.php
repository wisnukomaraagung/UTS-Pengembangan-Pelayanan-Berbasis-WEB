<?php
// models/Kategori.php

require_once __DIR__ . '/../config/database.php';

class Kategori {
    private $db;
    private $table = 'kategori';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Ambil semua data kategori
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil data berdasarkan ID
    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM {$this->table} WHERE id = $id";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    // Tambah kategori
    public function create($data) {
        $nama = $this->db->real_escape_string($data['nama_kategori']);
        $desk = $this->db->real_escape_string($data['deskripsi']);
        $sql = "INSERT INTO {$this->table} (nama_kategori, deskripsi) VALUES ('$nama', '$desk')";
        return $this->db->query($sql);
    }

    // Update kategori
    public function update($id, $data) {
        $id   = (int)$id;
        $nama = $this->db->real_escape_string($data['nama_kategori']);
        $desk = $this->db->real_escape_string($data['deskripsi']);
        $sql  = "UPDATE {$this->table} SET nama_kategori='$nama', deskripsi='$desk' WHERE id=$id";
        return $this->db->query($sql);
    }

    // Hapus kategori
    public function delete($id) {
        $id  = (int)$id;
        $sql = "DELETE FROM {$this->table} WHERE id=$id";
        return $this->db->query($sql);
    }

    // Hitung total
    public function count() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $result->fetch_assoc()['total'];
    }
}
?>
