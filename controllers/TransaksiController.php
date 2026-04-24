<?php
// controllers/TransaksiController.php

require_once __DIR__ . '/../models/Transaksi.php';
require_once __DIR__ . '/../models/Produk.php';

class TransaksiController {
    private $model;
    private $produkModel;

    public function __construct() {
        $this->model       = new Transaksi();
        $this->produkModel = new Produk();
    }

    public function index() {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                // Hitung total otomatis
                $produk = $this->produkModel->getById($_POST['id_produk']);
                $_POST['total_harga'] = $produk['harga'] * (int)$_POST['jumlah'];

                if ($this->model->create($_POST)) {
                    $message = 'success|Transaksi berhasil ditambahkan!';
                } else {
                    $message = 'error|Gagal menambahkan transaksi.';
                }
            }
            elseif ($_POST['action'] === 'update') {
                $produk = $this->produkModel->getById($_POST['id_produk']);
                $_POST['total_harga'] = $produk['harga'] * (int)$_POST['jumlah'];

                if ($this->model->update($_POST['id'], $_POST)) {
                    $message = 'success|Transaksi berhasil diupdate!';
                } else {
                    $message = 'error|Gagal mengupdate transaksi.';
                }
            }
            elseif ($_POST['action'] === 'delete') {
                if ($this->model->delete($_POST['id'])) {
                    $message = 'success|Transaksi berhasil dihapus!';
                } else {
                    $message = 'error|Gagal menghapus transaksi.';
                }
            }
        }

        $data = [
            'title'      => 'Halaman Transaksi',
            'transaksi'  => $this->model->getAll(),
            'produk'     => $this->produkModel->getAll(),
            'total'      => $this->model->count(),
            'pendapatan' => $this->model->totalPendapatan(),
            'message'    => $message,
        ];

        require_once __DIR__ . '/../views/transaksi/index.php';
    }
}
?>
