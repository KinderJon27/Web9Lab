<?php
// modules/user/delete.php — hapus pengguna (rute: user/delete).
// Penghapusan hanya diproses lewat metode POST dengan token CSRF,
// bukan karena pengguna membuka URL (GET).
defined('APP_START') || exit('Akses langsung tidak diizinkan.');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = ambilId($_POST['id'] ?? null);

    if (!verifikasiCsrf() || $id === null) {
        setFlash('gagal', 'Permintaan hapus tidak valid.');
        redirect('user/list');
    }

    $akun = penggunaLogin();
    if ($akun !== null && (int) $akun['id'] === $id) {
        setFlash('gagal', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        redirect('user/list');
    }

    $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        setFlash('sukses', 'Pengguna berhasil dihapus.');
    } else {
        setFlash('gagal', 'Pengguna tidak ditemukan.');
    }
    redirect('user/list');
}

// Sampai di sini berarti halaman dibuka dengan GET.
http_response_code(405);
header('Allow: POST');
?>
<section>
    <h2>Metode tidak diizinkan</h2>
    <p>Penghapusan data hanya dapat dilakukan melalui tombol Hapus (metode POST), bukan dengan membuka URL.</p>
    <a href="<?= e(url('user/list')) ?>">Kembali ke daftar pengguna</a>
</section>
