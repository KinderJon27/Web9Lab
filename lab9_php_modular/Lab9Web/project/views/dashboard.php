<?php
// views/dashboard.php — halaman utama (rute: dashboard).
defined('APP_START') || exit('Akses langsung tidak diizinkan.');

$totalPengguna   = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$penggunaTerbaru = $pdo->query('SELECT id, nama, email, created_at FROM users ORDER BY id DESC LIMIT 5')
    ->fetchAll(PDO::FETCH_ASSOC);

// Data untuk demonstrasi function helper (Latihan 2).
$hargaContoh = 200000;
$potongan    = hitungDiskon($hargaContoh, 15);
?>
<section>
    <h2>Dashboard</h2>
    <p>Halaman ini dimuat oleh router <code>index.php</code> melalui <code>?page=dashboard</code>.
       Header dan footer berasal dari <code>views/</code>, function dari <code>helpers/functions.php</code>,
       dan koneksi database dari <code>config/database.php</code>.</p>

    <div class="stat">
        <strong><?= e($totalPengguna) ?></strong>
        <span>pengguna terdaftar</span>
    </div>

    <h3>Pengguna terbaru</h3>
<?php if (!$penggunaTerbaru): ?>
    <p class="empty">Belum ada pengguna. <a href="<?= e(url('user/add')) ?>">Tambah pengguna pertama</a>.</p>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Nama</th><th>Email</th><th>Dibuat</th></tr>
            </thead>
            <tbody>
<?php foreach ($penggunaTerbaru as $p): ?>
                <tr>
                    <td><?= e(ringkasTeks($p['nama'], 40)) ?></td>
                    <td><?= e($p['email']) ?></td>
                    <td><?= e(formatTanggal($p['created_at'])) ?></td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p><a href="<?= e(url('user/list')) ?>">Lihat semua pengguna</a></p>
<?php endif; ?>

    <h3>Contoh pemakaian function helper</h3>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Pemanggilan</th><th>Hasil</th></tr>
            </thead>
            <tbody>
                <tr><td><code>formatRupiah(1500000)</code></td><td><?= e(formatRupiah(1500000)) ?></td></tr>
                <tr><td><code>hitungDiskon(200000, 15)</code></td><td><?= e(formatRupiah($potongan)) ?> (bayar <?= e(formatRupiah($hargaContoh - $potongan)) ?>)</td></tr>
                <tr><td><code>validasiEmail('rina@example.com')</code></td><td><?= validasiEmail('rina@example.com') ? 'valid' : 'tidak valid' ?></td></tr>
                <tr><td><code>ringkasTeks('Modularisasi program PHP', 12)</code></td><td><?= e(ringkasTeks('Modularisasi program PHP', 12)) ?></td></tr>
            </tbody>
        </table>
    </div>
</section>
