<?php
// about.php — halaman "Tentang" (Bagian D.5)
$judul = 'Tentang';
require_once __DIR__ . '/header.php';
?>
<section class="content">
    <h2>Halaman Tentang</h2>
    <p>Halaman ini memakai <code>header.php</code> dan <code>footer.php</code> yang sama dengan halaman lain.
       Hanya bagian konten ini yang berbeda.</p>

    <h3>Analisis hasil</h3>
    <ul>
        <li>Template digunakan bersama oleh semua halaman.</li>
        <li>Jika navigasi diubah pada <code>header.php</code>, semua halaman ikut berubah.</li>
        <li>Header tidak diletakkan seluruhnya di setiap halaman, sehingga tidak ada kode yang berulang.</li>
        <li><code>require_once</code> dipilih dibanding menyalin kode header ke setiap halaman.</li>
    </ul>
</section>
<?php require_once __DIR__ . '/footer.php'; ?>
