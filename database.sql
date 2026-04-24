-- ============================================
-- DATABASE: ecommerce_mvc
-- Dibuat untuk tugas PHP MVC E-Commerce
-- ============================================

CREATE DATABASE IF NOT EXISTS ecommerce_mvc;
USE ecommerce_mvc;

-- Tabel Kategori
CREATE TABLE IF NOT EXISTS kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Supplier
CREATE TABLE IF NOT EXISTS supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(20),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Produk
CREATE TABLE IF NOT EXISTS produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(150) NOT NULL,
    harga DECIMAL(15,2) NOT NULL,
    stok INT DEFAULT 0,
    id_kategori INT,
    id_supplier INT,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id) ON DELETE SET NULL,
    FOREIGN KEY (id_supplier) REFERENCES supplier(id) ON DELETE SET NULL
);

-- Tabel Transaksi
CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_transaksi VARCHAR(50) UNIQUE NOT NULL,
    id_produk INT,
    jumlah INT NOT NULL,
    total_harga DECIMAL(15,2) NOT NULL,
    tanggal DATE NOT NULL,
    status ENUM('pending','selesai','batal') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produk) REFERENCES produk(id) ON DELETE SET NULL
);

-- ============================================
-- DATA CONTOH
-- ============================================

INSERT INTO kategori (nama_kategori, deskripsi) VALUES
('Elektronik', 'Produk elektronik dan gadget'),
('Fashion', 'Pakaian dan aksesori'),
('Makanan', 'Produk makanan dan minuman'),
('Olahraga', 'Peralatan olahraga');

INSERT INTO supplier (nama_supplier, alamat, telepon, email) VALUES
('PT Maju Jaya', 'Jl. Sudirman No.10, Jakarta', '021-1234567', 'majujaya@email.com'),
('CV Berkah Mandiri', 'Jl. Gatot Subroto No.5, Bandung', '022-7654321', 'berkah@email.com'),
('UD Sejahtera', 'Jl. Diponegoro No.3, Surabaya', '031-9876543', 'sejahtera@email.com');

INSERT INTO produk (nama_produk, harga, stok, id_kategori, id_supplier, deskripsi) VALUES
('Laptop Asus VivoBook', 8500000, 15, 1, 1, 'Laptop 14 inch, RAM 8GB, SSD 512GB'),
('Smartphone Samsung A54', 4200000, 30, 1, 1, 'HP Android, 128GB, Kamera 50MP'),
('Kaos Polos Premium', 85000, 100, 2, 2, 'Kaos bahan combed 30s'),
('Sepatu Sneakers', 350000, 50, 2, 2, 'Sepatu casual pria/wanita'),
('Kopi Arabica 250gr', 45000, 200, 3, 3, 'Kopi arabica single origin'),
('Dumbbell 5kg', 120000, 40, 4, 3, 'Dumbbell besi chrome');

INSERT INTO transaksi (kode_transaksi, id_produk, jumlah, total_harga, tanggal, status) VALUES
('TRX-20260401-001', 1, 2, 17000000, '2026-04-01', 'selesai'),
('TRX-20260402-002', 3, 5, 425000, '2026-04-02', 'selesai'),
('TRX-20260403-003', 2, 1, 4200000, '2026-04-03', 'pending'),
('TRX-20260410-004', 5, 10, 450000, '2026-04-10', 'selesai'),
('TRX-20260415-005', 4, 3, 1050000, '2026-04-15', 'batal');
