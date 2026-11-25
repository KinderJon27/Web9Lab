<?php
// kontak.php — halaman Kontak (Latihan 1) + validasiEmail() dan e() (Latihan 2)
$judul = 'Kontak';
require_once __DIR__ . '/helpers.php';

$errors = [];
$nama = '';
$email = '';
$pesan = '';
$terkirim = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = trim((string) ($_POST['nama'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $pesan = trim((string) ($_POST['pesan'] ?? ''));

    if ($nama === '') {
        $errors[] = 'Nama wajib diisi.';
    }
    if (!validasiEmail($email)) {
        $errors[] = 'Format email tidak valid.';
    }
    if ($pesan === '') {
        $errors[] = 'Pesan wajib diisi.';
    }

    if (!$errors) {
        // Pada latihan ini pesan tidak disimpan; cukup ditampilkan kembali.
        $terkirim = true;
    }
}

require_once __DIR__ . '/header.php';
?>
<section class="content">
    <h2>Halaman Kontak</h2>

<?php if ($terkirim): ?>
    <div class="alert alert-success">
        Terima kasih, <?php echo e($nama); ?>. Pesan Anda sudah kami terima.
    </div>
<?php else: ?>
    <?php if ($errors): ?>
    <div class="alert alert-error">
        <ul>
            <?php foreach ($errors as $error): ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <form method="post" action="kontak.php">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?php echo e($nama); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo e($email); ?>" required>

        <label for="pesan">Pesan</label>
        <textarea id="pesan" name="pesan" rows="4" required><?php echo e($pesan); ?></textarea>

        <button type="submit">Kirim</button>
    </form>
<?php endif; ?>
</section>
<?php require_once __DIR__ . '/footer.php'; ?>
