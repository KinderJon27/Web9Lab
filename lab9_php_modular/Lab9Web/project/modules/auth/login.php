<?php
// modules/auth/login.php — form login (rute: auth/login).
defined('APP_START') || exit('Akses langsung tidak diizinkan.');

if (isLoggedIn()) {
    redirect('dashboard');
}

$errors = [];
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if (!verifikasiCsrf()) {
        $errors[] = 'Token keamanan tidak valid. Muat ulang halaman lalu coba lagi.';
    } elseif (!validasiEmail($email) || $password === '') {
        $errors[] = 'Email dan password wajib diisi dengan benar.';
    } else {
        $stmt = $pdo->prepare('SELECT id, nama, password FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $akun = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($akun && !empty($akun['password']) && password_verify($password, $akun['password'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = ['id' => (int) $akun['id'], 'nama' => $akun['nama']];
            setFlash('sukses', 'Login berhasil. Selamat datang, ' . $akun['nama'] . '.');
            redirect('dashboard');
        }
        // Pesan sama untuk email salah maupun password salah.
        $errors[] = 'Email atau password salah.';
    }
}
?>
<section>
    <h2>Login</h2>

<?php if ($errors): ?>
    <div class="alert alert-error" role="alert">
        <ul>
<?php foreach ($errors as $error): ?>
            <li><?= e($error) ?></li>
<?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

    <form method="post" action="<?= e(url('auth/login')) ?>">
        <?= csrfField() ?>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" autocomplete="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="current-password" required>

        <div class="form-actions">
            <button type="submit">Login</button>
        </div>
    </form>
    <p class="help">Login memakai akun dari data pengguna. Pengguna yang dibuat lewat form Tambah Pengguna
       (atau diberi password baru lewat form Ubah) dapat login.</p>
</section>
