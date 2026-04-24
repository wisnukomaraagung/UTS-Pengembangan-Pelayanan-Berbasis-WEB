<?php
// index.php - Router Utama MVC
// Semua request masuk ke sini dulu

// Load controller sesuai halaman yang diminta
$page = $_GET['page'] ?? 'kategori'; // Default halaman: kategori

// Whitelist halaman yang diizinkan
$allowedPages = ['kategori', 'produk', 'supplier', 'transaksi'];

if (!in_array($page, $allowedPages)) {
    $page = 'kategori';
}

// Map halaman ke controller
$controllers = [
    'kategori'  => ['file' => 'KategoriController',  'class' => 'KategoriController'],
    'produk'    => ['file' => 'ProdukController',     'class' => 'ProdukController'],
    'supplier'  => ['file' => 'SupplierController',   'class' => 'SupplierController'],
    'transaksi' => ['file' => 'TransaksiController',  'class' => 'TransaksiController'],
];

$ctrl = $controllers[$page];
require_once __DIR__ . '/controllers/' . $ctrl['file'] . '.php';

$controller = new $ctrl['class']();
$controller->index();
?>
