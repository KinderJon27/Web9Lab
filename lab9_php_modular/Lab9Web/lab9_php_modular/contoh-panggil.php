<?php
// contoh-panggil.php — Bagian E.5: memanggil function dari file helper
require_once __DIR__ . '/helpers.php';

echo formatRupiah(150000);
echo '<br>';
// e() mencegah input diperlakukan sebagai markup atau skrip oleh browser.
echo e('<script>alert("uji")</script>');
