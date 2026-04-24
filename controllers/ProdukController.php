<?php
// controllers/ProdukController.php

require_once __DIR__ . '/../models/Produk.php';
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/Supplier.php';

class ProdukController {
    private $model;
    private $kategoriModel;
    private $supplierModel;

    public function __construct() {
        $this->model         = new Produk();
        $this->kategoriModel = new Kategori();
        $this->supplierModel = new Supplier();
    }

    public function index() {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                if ($this->model->create($_POST)) {
                    $message = 'success|Produk berhasil ditambahkan!';
                } else {
                    $message = 'error|Gagal menambahkan produk.';
                }
            }
            elseif ($_POST['action'] === 'update') {
                if ($this->model->update($_POST['id'], $_POST)) {
                    $message = 'success|Produk berhasil diupdate!';
                } else {
                    $message = 'error|Gagal mengupdate produk.';
                }
            }
            elseif ($_POST['action'] === 'delete') {
                if ($this->model->delete($_POST['id'])) {
                    $message = 'success|Produk berhasil dihapus!';
                } else {
                    $message = 'error|Gagal menghapus produk.';
                }
            }
        }

        $data = [
            'title'     => 'Halaman Produk',
            'produk'    => $this->model->getAll(),
            'kategori'  => $this->kategoriModel->getAll(),
            'supplier'  => $this->supplierModel->getAll(),
            'total'     => $this->model->count(),
            'message'   => $message,
        ];

        require_once __DIR__ . '/../views/produk/index.php';
    }
}
?>
