<?php
// uji-once.php — membedakan include/require dengan include_once/require_once
//
// Hasil yang diharapkan:
// - include_once dipanggil 2x -> pesan.php hanya dimuat SATU kali.
// - include       dipanggil 2x -> pesan.php dimuat DUA kali.
//
// Urutan sengaja begini: include_once menganggap file yang sudah pernah dimuat
// (termasuk lewat include biasa) sebagai "sudah dimuat", jadi bagian include_once
// harus dijalankan lebih dulu.
echo '<strong>Dengan include_once (dipanggil 2x):</strong><br>';
include_once __DIR__ . '/pesan.php';
include_once __DIR__ . '/pesan.php';

echo '<br><strong>Dengan include (dipanggil 2x):</strong><br>';
include __DIR__ . '/pesan.php';
include __DIR__ . '/pesan.php';
