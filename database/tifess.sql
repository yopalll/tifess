-- ============================================
-- File SQL untuk Setup Database TIFESS
-- Platform Confess Anonymous untuk Teknologi Informasi
-- ============================================

-- Buat database baru (hapus jika sudah ada)
DROP DATABASE IF EXISTS tifess;
CREATE DATABASE tifess;

-- Gunakan database tifess
USE tifess;

-- ============================================
-- TABEL CONFESS
-- Menyimpan semua confess yang dikirim user
-- ============================================

CREATE TABLE confess (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor VARCHAR(20) UNIQUE NOT NULL,
    isi TEXT NOT NULL,
    kategori VARCHAR(50) DEFAULT NULL,
    status ENUM('pending', 'acc', 'reject') DEFAULT 'pending',
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_nomor (nomor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================
-- TABEL USERS
-- Menyimpan data admin untuk login
-- ============================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('superadmin', 'admin') DEFAULT 'admin',
    is_username_changed BOOLEAN DEFAULT FALSE,
    is_approved BOOLEAN DEFAULT FALSE,
    approved_by INT DEFAULT NULL,
    approved_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================
-- INSERT DATA SAMPLE
-- Admin default dan beberapa confess untuk testing
-- ============================================

-- akun superadmin
-- Username: TF-KOMA-06
-- Password: KEL06PROWEB-KOMA-25
INSERT INTO users (username, password, role, is_approved, created_at) VALUES 
('TF-KOMA-06', '$2y$10$L9QLP8wCd7TIKHQ6X9gOFuIiI3a98w5Z6eu/2tggnCiCpW..VV4ne', 'superadmin', TRUE, NOW());

-- -- Sample confess untuk testing (opsional, bisa dihapus)
-- INSERT INTO confess (nomor, isi, kategori, status, tanggal) VALUES
-- ('CF-00001', '', 'Random', 'acc', NOW()),
-- ('CF-00002', '', 'Crush', 'pending', NOW()),
-- ('CF-00003', '', 'Keluh Kesah', 'pending', NOW()),
-- ('CF-00004', '', 'Teman', 'acc', NOW()),
-- ('CF-00005', '', 'Random', 'reject', NOW());
--  hapus komentar kode diatas kalau mau testing.

-- ============================================
-- TABEL PRODUCTS
-- Menyimpan katalog merchandise yang dijual
-- ============================================

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================
-- TABEL ORDERS
-- Menyimpan data pesanan merchandise
-- ============================================

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    buyer_name VARCHAR(255) NOT NULL,
    buyer_phone VARCHAR(20) NOT NULL,
    buyer_address TEXT,
    product_items TEXT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'sent', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_order_number (order_number),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================
-- INFORMASI DATABASE
-- ============================================

-- Total tabel: 4
-- 1. confess - untuk menyimpan confess
-- 2. users - untuk menyimpan admin
-- 3. products - untuk menyimpan katalog merchandise
-- 4. orders - untuk menyimpan pesanan merchandise

-- Status confess:
-- - pending: Menunggu persetujuan admin
-- - acc: Sudah disetujui, akan muncul di mading
-- - reject: Ditolak admin

-- Kategori confess:
-- - Crush
-- - Keluh Kesah
-- - Teman
-- - Keluarga
-- - Kesehatan
-- - Random

-- ============================================
-- CARA IMPORT
-- ============================================

-- Melalui phpMyAdmin:
-- 1. Buka phpMyAdmin di browser (biasanya http://localhost/phpmyadmin)
-- 2. Klik tab "Import"
-- 3. Pilih file tifess.sql ini
-- 4. Klik "Go"

-- Melalui Command Line:
-- mysql -u root -p < database/tifess.sql

-- Melalui Laragon Terminal:
-- mysql -u root < database/tifess.sql

-- ============================================
-- SETELAH IMPORT
-- ============================================

-- Anda dapat login ke admin panel dengan:
-- Username: TF-KOMA-06
-- Password: KEL06PROWEB-KOMA-25

-- PENTING: Hanya superadmin (MHSW) yang dapat menyetujui admin baru!
-- Admin baru yang mendaftar harus menunggu persetujuan dari MHSW.

-- ============================================
-- QUERY BERGUNA UNTUK DEVELOPMENT
-- ============================================

-- Lihat semua confess:
-- SELECT * FROM confess ORDER BY id DESC;

-- Lihat confess pending:
-- SELECT * FROM confess WHERE status='pending' ORDER BY id DESC;

-- Hitung total confess per status:
-- SELECT status, COUNT(*) as total FROM confess GROUP BY status;

-- Hapus semua confess (HATI-HATI):
-- TRUNCATE TABLE confess;

-- Reset auto increment nomor confess:
-- ALTER TABLE confess AUTO_INCREMENT = 1;
