<?php
// modules/user/add.php — form tambah pengguna (rute: user/add).
defined('APP_START') || exit('Akses langsung tidak diizinkan.');

$errors = [];
$nama   = '';
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim((string) ($_POST['nama'] ?? ''));
    $email    = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if (!verifikasiCsrf()) {
        $errors[] = 'Token keamanan tidak valid. Muat ulang halaman lalu coba lagi.';
    }
    if ($nama === '' || mb_strlen($nama) > 100) {
        $errors[] = 'Nama wajib diisi (maksimal 100 karakter).';
    }
    if (!validasiEmail($email) || mb_strlen($email) > 150) {
        $errors[] = 'Format email tidak valid.';
    }
    if (strlen($password) < 6 || strlen($password) > 72) {
        $errors[] = 'Password harus 6 sampai 72 karakter.';
    }

    if (!$errors) {
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO users (nama, email, password) VALUES (:nama, :email, :password)'
            );
            $stmt->execute([
                ':nama'     => $nama,
                ':email'    => $email,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
            setFlash('sukses', 'Pengguna berhasil ditambahkan.');
            redirect('user/list');
        } catch (PDOException $ex) {
            if ((string) $ex->getCode() === '23000') {
                $errors[] = 'Email sudah terdaftar. Gunakan email lain.';
            } else {
                throw $ex;
            }
        }
    }
}
?>
<section>
    <h2>Tambah Pengguna</h2>

<?php if ($errors): ?>
    <div class="alert alert-error" role="alert">
        <ul>
<?php foreach ($errors as $error): ?>
            <li><?= e($error) ?></li>
<?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

    <form method="post" action="<?= e(url('user/add')) ?>">
        <?= csrfField() ?>

        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?= e($nama) ?>" maxlength="100" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" maxlength="150" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" minlength="6" maxlength="72" autocomplete="new-password" required>

        <div class="form-actions">
            <button type="submit">Simpan</button>
            <a href="<?= e(url('user/list')) ?>">Batal</a>
        </div>
    </form>
</section>
