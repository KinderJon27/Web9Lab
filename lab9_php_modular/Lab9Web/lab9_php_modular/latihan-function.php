<?php
// latihan-function.php — rangkuman Bagian E (function) dan Latihan 2
// Seluruh function berada di helpers.php dan dipanggil dari halaman ini serta home.php.
$judul = 'Function';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/header.php';
?>
<section class="content">
    <h2>Latihan Function</h2>

    <h3>1. Function tanpa parameter</h3>
    <p><?php tampilkanSalam(); ?></p>

    <h3>2. Function dengan parameter</h3>
    <p><?php sapaPengguna('Rina'); ?></p>

    <h3>3. Function dengan return</h3>
    <?php $luas = hitungLuasPersegiPanjang(8, 5); ?>
    <p>Luas persegi panjang 8 x 5: <?php echo $luas; ?></p>

    <h3>4. Type declaration dan nilai default</h3>
    <p>Diskon 10% dari Rp 200.000: <?php echo formatRupiah(hitungDiskon(200000)); ?></p>
    <p>Diskon 15% dari Rp 200.000: <?php echo formatRupiah(hitungDiskon(200000, 15)); ?></p>

    <h3>5. Latihan mandiri</h3>
    <table>
        <tr><th>Pemanggilan</th><th>Hasil</th></tr>
        <tr><td><code>konversiCelsiusKeFahrenheit(37)</code></td><td><?php echo konversiCelsiusKeFahrenheit(37); ?> &deg;F</td></tr>
        <tr><td><code>tentukanStatusNilai(78)</code></td><td><?php echo e(tentukanStatusNilai(78)); ?></td></tr>
        <tr><td><code>hitungTotal(15000, 3)</code></td><td><?php echo formatRupiah(hitungTotal(15000, 3)); ?></td></tr>
        <tr><td><code>validasiEmail('rina@example.com')</code></td><td><?php echo validasiEmail('rina@example.com') ? 'valid' : 'tidak valid'; ?></td></tr>
        <tr><td><code>validasiEmail('rina@')</code></td><td><?php echo validasiEmail('rina@') ? 'valid' : 'tidak valid'; ?></td></tr>
        <tr><td><code>ringkasTeks('Pemrograman web dengan PHP modular', 15)</code></td><td><?php echo e(ringkasTeks('Pemrograman web dengan PHP modular', 15)); ?></td></tr>
    </table>

    <h3>6. Escaping dengan e()</h3>
    <p>Input <code>&lt;script&gt;alert("uji")&lt;/script&gt;</code> ditampilkan sebagai teks biasa:
       <?php echo e('<script>alert("uji")</script>'); ?></p>
</section>
<?php require_once __DIR__ . '/footer.php'; ?>
