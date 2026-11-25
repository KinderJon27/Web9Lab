<?php
// uji-include.php — Praktik C.3: menguji include
//
// Langkah pengujian:
// 1. Jalankan file ini saat pesan.php ada  -> semua baris tampil.
// 2. Ubah nama pesan.php sementara (misalnya jadi pesan-x.php), lalu muat ulang.
//    Amati: muncul WARNING, tetapi baris setelah pemanggilan TETAP dijalankan.
// 3. Kembalikan nama file menjadi pesan.php.
echo 'Sebelum pemanggilan<br>';
include __DIR__ . '/pesan.php';
echo 'Sesudah pemanggilan<br>';
