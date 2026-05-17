<?php
class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $this->conn = new mysqli("host.docker.internal", "root", "", "ecommerce_mvc");
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}

// Backward compatibility: provide $conn variable for procedural code
$conn = Database::getInstance()->getConnection();
?>