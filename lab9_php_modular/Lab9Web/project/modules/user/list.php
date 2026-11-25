<?php
// modules/user/list.php — daftar pengguna (rute: user/list).
defined('APP_START') || exit('Akses langsung tidak diizinkan.');

$daftarPengguna = $pdo->query('SELECT id, nama, email, created_at FROM users ORDER BY id DESC')
    ->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <h2>Data Pengguna</h2>
    <p>Daftar pengguna ditampilkan pada bagian ini.</p>
    <p><a class="btn" href="<?= e(url('user/add')) ?>">Tambah Pengguna</a></p>

<?php if (!$daftarPengguna): ?>
    <p class="empty">Belum ada data pengguna.</p>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>No</th><th>Nama</th><th>Email</th><th>Dibuat</th><th>Aksi</th></tr>
            </thead>
            <tbody>
<?php foreach ($daftarPengguna as $no => $p): ?>
                <tr>
                    <td><?= $no + 1 ?></td>
                    <td><?= e(ringkasTeks($p['nama'], 40)) ?></td>
                    <td><?= e($p['email']) ?></td>
                    <td><?= e(formatTanggal($p['created_at'])) ?></td>
                    <td class="aksi">
                        <a href="<?= e(url('user/edit', ['id' => $p['id']])) ?>">Edit</a>
                        <form method="post" action="<?= e(url('user/delete')) ?>" data-confirm="Hapus pengguna ini?">
                            <?= csrfField() ?>
                            <input type="hidden" name="id" value="<?= e($p['id']) ?>">
                            <button type="submit" class="btn-link danger">Hapus</button>
                        </form>
                    </td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
</section>
