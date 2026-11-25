<?php
// modules/user/edit.php — form ubah pengguna (rute: user/edit, mis. ?page=user/edit&id=3).
defined('APP_START') || exit('Akses langsung tidak diizinkan.');

$errors   = [];
$id       = ambilId($_GET['id'] ?? null);
$pengguna = null;

if ($id !== null) {
    $stmt = $pdo->prepare('SELECT id, nama, email FROM users WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $pengguna = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

if ($pengguna === null) {
    http_response_code(404);
} else {
    $nama  = $pengguna['nama'];
    $email = $pengguna['email'];

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
        // Password boleh dikosongkan; jika diisi harus 6 sampai 72 karakter.
        if ($password !== '' && (strlen($password) < 6 || strlen($password) > 72)) {
            $errors[] = 'Password baru harus 6 sampai 72 karakter.';
        }

        if (!$errors) {
            try {
                if ($password !== '') {
                    $stmt = $pdo->prepare(
                        'UPDATE users SET nama = :nama, email = :email, password = :password WHERE id = :id'
                    );
                    $stmt->execute([
                        ':nama'     => $nama,
                        ':email'    => $email,
                        ':password' => password_hash($password, PASSWORD_DEFAULT),
                        ':id'       => $id,
                    ]);
                } else {
                    $stmt = $pdo->prepare(
                        'UPDATE users SET nama = :nama, email = :email WHERE id = :id'
                    );
                    $stmt->execute([':nama' => $nama, ':email' => $email, ':id' => $id]);
                }
                setFlash('sukses', 'Data pengguna berhasil diubah.');
                redirect('user/list');
            } catch (PDOException $ex) {
                if ((string) $ex->getCode() === '23000') {
                    $errors[] = 'Email sudah dipakai pengguna lain.';
                } else {
                    throw $ex;
                }
            }
        }
    }
}
?>
<?php if ($pengguna === null): ?>
<section>
    <h2>Pengguna tidak ditemukan</h2>
    <p>Data pengguna yang diminta tidak tersedia.</p>
    <a href="<?= e(url('user/list')) ?>">Kembali ke daftar pengguna</a>
</section>
<?php else: ?>
<section>
    <h2>Ubah Pengguna</h2>

<?php if ($errors): ?>
    <div class="alert alert-error" role="alert">
        <ul>
<?php foreach ($errors as $error): ?>
            <li><?= e($error) ?></li>
<?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

    <form method="post" action="<?= e(url('user/edit', ['id' => $pengguna['id']])) ?>">
        <?= csrfField() ?>

        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?= e($nama) ?>" maxlength="100" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" maxlength="150" required>

        <label for="password">Password baru</label>
        <input type="password" id="password" name="password" maxlength="72" autocomplete="new-password">
        <p class="help">Kosongkan jika password tidak ingin diubah.</p>

        <div class="form-actions">
            <button type="submit">Simpan perubahan</button>
            <a href="<?= e(url('user/list')) ?>">Batal</a>
        </div>
    </form>
</section>
<?php endif; ?>
