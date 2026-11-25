<?php
// helpers/functions.php — function umum yang dipakai oleh banyak modul.
// Dimuat satu kali oleh index.php dengan require_once.

/* ------------------------------------------------------------------
 * Format tampilan dan validasi (Latihan 2)
 * ------------------------------------------------------------------ */

function formatRupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// Escaping keluaran ke HTML. Menerima nilai apa pun agar aman dipakai
// pada data hasil query (angka, string, atau null).
function e($nilai): string
{
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

// Mengembalikan NOMINAL potongan harga (bukan harga akhir).
function hitungDiskon(float $harga, float $persen = 10): float
{
    return $harga * ($persen / 100);
}

function validasiEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function ringkasTeks(string $teks, int $batas = 100): string
{
    if (mb_strlen($teks) <= $batas) {
        return $teks;
    }
    return rtrim(mb_substr($teks, 0, $batas)) . '...';
}

function formatTanggal(?string $waktu): string
{
    if ($waktu === null || $waktu === '') {
        return '-';
    }
    $stempel = strtotime($waktu);
    return $stempel === false ? '-' : date('d-m-Y H:i', $stempel);
}

/* ------------------------------------------------------------------
 * URL, aset, dan redirect (routing berbasis parameter ?page=)
 * ------------------------------------------------------------------ */

// Folder tempat index.php berada, dihitung dari URL (mis. "/project" atau "").
function baseUrl(): string
{
    $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
    return ($dir === '/' || $dir === '.') ? '' : rtrim($dir, '/');
}

// Membuat tautan ke sebuah rute, mis. url('user/edit', ['id' => 3])
// => /project/index.php?page=user/edit&id=3
// Hanya dipanggil dengan nama rute dari kode aplikasi, bukan input pengguna.
function url(string $page, array $params = []): string
{
    $query = 'page=' . $page;
    foreach ($params as $kunci => $nilai) {
        $query .= '&' . rawurlencode((string) $kunci) . '=' . rawurlencode((string) $nilai);
    }
    return baseUrl() . '/index.php?' . $query;
}

// Path aset yang konsisten, tetap benar walaupun URL memakai .htaccess.
function asset(string $path): string
{
    return baseUrl() . '/assets/' . ltrim($path, '/');
}

// Alihkan ke rute lain. Buffer dibersihkan agar keluaran HTML yang sudah
// dibuat (header.php) tidak ikut terkirim.
function redirect(string $page, array $params = []): void
{
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    header('Location: ' . url($page, $params));
    exit;
}

// Mengambil id positif dari input; null jika tidak valid.
function ambilId($sumber): ?int
{
    $id = filter_var($sumber, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $id === false ? null : $id;
}

/* ------------------------------------------------------------------
 * Navigasi aktif (Tantangan mandiri 1)
 * ------------------------------------------------------------------ */

// Mengembalikan atribut HTML untuk tautan menu yang sedang dibuka.
// $rute boleh berupa satu nama rute atau daftar rute.
function atributNavAktif($rute): string
{
    global $currentRoute;
    return in_array($currentRoute, (array) $rute, true)
        ? ' class="active" aria-current="page"'
        : '';
}

/* ------------------------------------------------------------------
 * Pesan sukses/gagal (Tantangan mandiri 2)
 * ------------------------------------------------------------------ */

function setFlash(string $tipe, string $pesan): void
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

// Menampilkan pesan satu kali, lalu menghapusnya dari session.
function tampilkanFlash(): void
{
    if (empty($_SESSION['flash'])) {
        return;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    $kelas = $flash['tipe'] === 'sukses' ? 'alert-success' : 'alert-error';
    echo '<div class="alert ' . $kelas . '" role="status">' . e($flash['pesan']) . '</div>';
}

/* ------------------------------------------------------------------
 * Perlindungan CSRF untuk operasi yang mengubah data
 * ------------------------------------------------------------------ */

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

function verifikasiCsrf(): bool
{
    $dikirim = $_POST['csrf_token'] ?? '';
    return is_string($dikirim)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $dikirim);
}

/* ------------------------------------------------------------------
 * Status login (Tantangan mandiri 3)
 * ------------------------------------------------------------------ */

function isLoggedIn(): bool
{
    return !empty($_SESSION['user']);
}

function penggunaLogin(): ?array
{
    return $_SESSION['user'] ?? null;
}
