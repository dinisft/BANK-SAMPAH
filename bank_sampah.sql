CREATE DATABASE IF NOT EXISTS bank_sampah;
USE bank_sampah;

-- Tabel users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    saldo INT DEFAULT 0,
    poin INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel setoran
CREATE TABLE setoran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    jenis_sampah ENUM('plastik', 'kertas', 'kaca', 'kaleng', 'organik') NOT NULL,
    berat_kg DECIMAL(5,2) NOT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    status ENUM('pending', 'diterima', 'ditolak') DEFAULT 'pending',
    poin_didapat INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel harga_sampah (untuk info harga)
CREATE TABLE harga_sampah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jenis_sampah VARCHAR(50) UNIQUE NOT NULL,
    harga_per_kg INT NOT NULL
);

-- Tabel penarikan
CREATE TABLE penarikan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    jumlah_poin INT NOT NULL,
    metode ENUM('tunai', 'hadiah') NOT NULL,
    detail VARCHAR(255),
    status ENUM('pending', 'selesai', 'ditolak') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Data awal harga sampah
INSERT INTO harga_sampah (jenis_sampah, harga_per_kg) VALUES
('plastik', 2000),
('kertas', 1500),
('kaca', 1000),
('kaleng', 3000),
('organik', 500);

-- Jadwal (bisa disimpan di file atau tabel, kita simpan di tabel saja agar mudah update)
CREATE TABLE jadwal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hari VARCHAR(20) NOT NULL,
    jam_buka TIME NOT NULL,
    jam_tutup TIME NOT NULL,
    keterangan TEXT
);

INSERT INTO jadwal (hari, jam_buka, jam_tutup, keterangan) VALUES
('Senin', '08:00:00', '11:00:00', 'Buka setor & jemput'),
('Kamis', '08:00:00', '11:00:00', 'Buka setor & jemput');