<?php
// models/Supplier.php

require_once __DIR__ . '/../config/database.php';

class Supplier {
    private $db;
    private $table = 'supplier';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM {$this->table} WHERE id = $id";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    public function create($data) {
        $nama  = $this->db->real_escape_string($data['nama_supplier']);
        $alamat= $this->db->real_escape_string($data['alamat']);
        $telp  = $this->db->real_escape_string($data['telepon']);
        $email = $this->db->real_escape_string($data['email']);
        $sql   = "INSERT INTO {$this->table} (nama_supplier, alamat, telepon, email) 
                  VALUES ('$nama', '$alamat', '$telp', '$email')";
        return $this->db->query($sql);
    }

    public function update($id, $data) {
        $id    = (int)$id;
        $nama  = $this->db->real_escape_string($data['nama_supplier']);
        $alamat= $this->db->real_escape_string($data['alamat']);
        $telp  = $this->db->real_escape_string($data['telepon']);
        $email = $this->db->real_escape_string($data['email']);
        $sql   = "UPDATE {$this->table} 
                  SET nama_supplier='$nama', alamat='$alamat', telepon='$telp', email='$email' 
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
