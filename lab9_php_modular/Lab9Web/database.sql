-- database.sql — skema dan data contoh Praktikum 9 (PHP Modular)
-- Impor lewat phpMyAdmin (tab Import) atau: mysql -u root < database.sql

CREATE DATABASE IF NOT EXISTS db_latihan
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE db_latihan;

CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nama       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    password   VARCHAR(255) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data contoh. Kolom password sengaja kosong: isi lewat halaman Ubah Pengguna
-- (aplikasi akan menyimpannya dalam bentuk hash) bila ingin mencoba login.
INSERT IGNORE INTO users (nama, email) VALUES
    ('Rina Putri',     'rina@example.com'),
    ('Budi Santoso',   'budi@example.com'),
    ('Sari Wulandari', 'sari@example.com');
