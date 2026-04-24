<?php
// controllers/SupplierController.php

require_once __DIR__ . '/../models/Supplier.php';

class SupplierController {
    private $model;

    public function __construct() {
        $this->model = new Supplier();
    }

    public function index() {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                if ($this->model->create($_POST)) {
                    $message = 'success|Supplier berhasil ditambahkan!';
                } else {
                    $message = 'error|Gagal menambahkan supplier.';
                }
            }
            elseif ($_POST['action'] === 'update') {
                if ($this->model->update($_POST['id'], $_POST)) {
                    $message = 'success|Supplier berhasil diupdate!';
                } else {
                    $message = 'error|Gagal mengupdate supplier.';
                }
            }
            elseif ($_POST['action'] === 'delete') {
                if ($this->model->delete($_POST['id'])) {
                    $message = 'success|Supplier berhasil dihapus!';
                } else {
                    $message = 'error|Gagal menghapus supplier.';
                }
            }
        }

        $data = [
            'title'    => 'Halaman Supplier',
            'supplier' => $this->model->getAll(),
            'total'    => $this->model->count(),
            'message'  => $message,
        ];

        require_once __DIR__ . '/../views/supplier/index.php';
    }
}
?>
