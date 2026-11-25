<?php
// home.php — Bagian D.4 dan Latihan 1 (template multi-halaman) + Latihan 2 (function helper)
$judul = 'Home';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/header.php';

$hargaNormal = 200000;
$potongan10  = hitungDiskon($hargaNormal);       // memakai persen default (10)
$potongan15  = hitungDiskon($hargaNormal, 15);   // persen dikirim sebagai argumen
?>
<section class="content">
    <h2>Halaman Home</h2>
    <p>Ini adalah konten khusus halaman beranda.</p>

    <h3>Contoh pemakaian function helper</h3>
    <table>
        <tr><th>Keterangan</th><th>Nilai</th></tr>
        <tr><td>Harga normal</td><td><?php echo formatRupiah($hargaNormal); ?></td></tr>
        <tr><td>Diskon 10% (default)</td><td><?php echo formatRupiah($potongan10); ?> &rarr; bayar <?php echo formatRupiah($hargaNormal - $potongan10); ?></td></tr>
        <tr><td>Diskon 15%</td><td><?php echo formatRupiah($potongan15); ?> &rarr; bayar <?php echo formatRupiah($hargaNormal - $potongan15); ?></td></tr>
    </table>
</section>
<?php require_once __DIR__ . '/footer.php'; ?>
