<?php
// controllers/KategoriController.php

require_once __DIR__ . '/../models/Kategori.php';

class KategoriController {
    private $model;

    public function __construct() {
        $this->model = new Kategori();
    }

    // Tampilkan daftar + handle form
    public function index() {
        $message = '';

        // TAMBAH
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                if ($this->model->create($_POST)) {
                    $message = 'success|Kategori berhasil ditambahkan!';
                } else {
                    $message = 'error|Gagal menambahkan kategori.';
                }
            }
            elseif ($_POST['action'] === 'update') {
                if ($this->model->update($_POST['id'], $_POST)) {
                    $message = 'success|Kategori berhasil diupdate!';
                } else {
                    $message = 'error|Gagal mengupdate kategori.';
                }
            }
            elseif ($_POST['action'] === 'delete') {
                if ($this->model->delete($_POST['id'])) {
                    $message = 'success|Kategori berhasil dihapus!';
                } else {
                    $message = 'error|Gagal menghapus kategori.';
                }
            }
        }

        $data = [
            'title'     => 'Halaman Kategori',
            'kategori'  => $this->model->getAll(),
            'total'     => $this->model->count(),
            'message'   => $message,
        ];

        require_once __DIR__ . '/../views/kategori/index.php';
    }
}
?>
