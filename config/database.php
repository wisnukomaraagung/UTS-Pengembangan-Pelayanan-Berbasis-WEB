<?php
// ============================================
// config/database.php
// Konfigurasi Koneksi Database - E-Commerce MVC
// ============================================

// Sesuaikan pengaturan ini dengan server Anda
define('DB_HOST', 'localhost');     // Host database (biasanya localhost)
define('DB_USER', 'root');          // Username MySQL (default XAMPP: root)
define('DB_PASS', '');              // Password MySQL (default XAMPP: kosong)
define('DB_NAME', 'ecommerce_mvc'); // Nama database

class Database {
    private static $instance = null;
    private $conn;

    // Constructor: buat koneksi ke MySQL
    private function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Cek apakah koneksi berhasil
        if ($this->conn->connect_error) {
            die("
                <div style='font-family:sans-serif; background:#fff3cd; border:1px solid #ffc107;
                            padding:20px; margin:20px; border-radius:8px;'>
                    <h3 style='color:#856404;'>❌ Koneksi Database Gagal!</h3>
                    <p><strong>Error:</strong> " . $this->conn->connect_error . "</p>
                    <hr>
                    <p><strong>Solusi:</strong></p>
                    <ul>
                        <li>Pastikan MySQL/XAMPP sudah berjalan</li>
                        <li>Cek username &amp; password di <code>config/database.php</code></li>
                        <li>Pastikan database <code>ecommerce_mvc</code> sudah dibuat</li>
                        <li>Import file <code>database.sql</code> di phpMyAdmin</li>
                    </ul>
                </div>
            ");
        }

        // Set encoding UTF-8 agar karakter Indonesia tampil benar
        $this->conn->set_charset("utf8");
    }

    // Singleton Pattern: pastikan hanya ada 1 koneksi
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Ambil objek koneksi
    public function getConnection() {
        return $this->conn;
    }

    // Tutup koneksi (opsional)
    public function closeConnection() {
        $this->conn->close();
        self::$instance = null;
    }
}
?>
