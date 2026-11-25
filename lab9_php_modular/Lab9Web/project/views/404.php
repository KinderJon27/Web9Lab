<?php
// views/404.php — ditampilkan router bila nilai page tidak ada pada whitelist.
defined('APP_START') || exit('Akses langsung tidak diizinkan.');
?>
<section>
    <h2>404 - Halaman tidak ditemukan</h2>
    <p>Halaman yang diminta tidak tersedia.</p>
    <a href="<?= e(url('dashboard')) ?>">Kembali ke dashboard</a>
</section>
