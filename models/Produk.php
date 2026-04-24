<?php
// models/Produk.php

require_once __DIR__ . '/../config/database.php';

class Produk {
    private $db;
    private $table = 'produk';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Join dengan kategori dan supplier
    public function getAll() {
        $sql = "SELECT p.*, k.nama_kategori, s.nama_supplier 
                FROM {$this->table} p
                LEFT JOIN kategori k ON p.id_kategori = k.id
                LEFT JOIN supplier s ON p.id_supplier = s.id
                ORDER BY p.id DESC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT p.*, k.nama_kategori, s.nama_supplier 
                FROM {$this->table} p
                LEFT JOIN kategori k ON p.id_kategori = k.id
                LEFT JOIN supplier s ON p.id_supplier = s.id
                WHERE p.id = $id";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    public function create($data) {
        $nama  = $this->db->real_escape_string($data['nama_produk']);
        $harga = (float)$data['harga'];
        $stok  = (int)$data['stok'];
        $id_kat= (int)$data['id_kategori'];
        $id_sup= (int)$data['id_supplier'];
        $desk  = $this->db->real_escape_string($data['deskripsi']);
        $sql   = "INSERT INTO {$this->table} (nama_produk, harga, stok, id_kategori, id_supplier, deskripsi)
                  VALUES ('$nama', $harga, $stok, $id_kat, $id_sup, '$desk')";
        return $this->db->query($sql);
    }

    public function update($id, $data) {
        $id    = (int)$id;
        $nama  = $this->db->real_escape_string($data['nama_produk']);
        $harga = (float)$data['harga'];
        $stok  = (int)$data['stok'];
        $id_kat= (int)$data['id_kategori'];
        $id_sup= (int)$data['id_supplier'];
        $desk  = $this->db->real_escape_string($data['deskripsi']);
        $sql   = "UPDATE {$this->table} 
                  SET nama_produk='$nama', harga=$harga, stok=$stok, 
                      id_kategori=$id_kat, id_supplier=$id_sup, deskripsi='$desk'
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
}
?>
