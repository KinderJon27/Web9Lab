<?php
// uji-require.php — Praktik C.3 langkah 5: ulangi percobaan dengan require
//
// Langkah pengujian:
// 1. Jalankan file ini saat pesan.php ada  -> semua baris tampil.
// 2. Ubah nama pesan.php sementara, lalu muat ulang.
//    Amati: muncul FATAL ERROR dan baris setelah pemanggilan TIDAK dijalankan.
// 3. Kembalikan nama file menjadi pesan.php.
echo 'Sebelum pemanggilan<br>';
require __DIR__ . '/pesan.php';
echo 'Sesudah pemanggilan<br>';
