<?php
// index.php — titik masuk aplikasi dan pengatur pemanggilan halaman (router).
// Contoh: http://localhost/project/index.php?page=user/list

define('APP_START', true);

// Buffer keluaran agar redirect (header Location) tetap bisa dikirim
// setelah views/header.php dimuat.
ob_start();
session_start();

// Detail error tidak ditampilkan kepada pengguna; dicatat ke log PHP.
set_exception_handler(function (Throwable $e) {
    error_log($e->getMessage());
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    http_response_code(500);
    echo 'Terjadi kesalahan pada aplikasi. Silakan coba lagi nanti.';
});

require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/config/database.php';

// Whitelist rute: hanya halaman di daftar ini yang boleh dimuat.
$routes = [
    'dashboard'   => __DIR__ . '/views/dashboard.php',
    'user/list'   => __DIR__ . '/modules/user/list.php',
    'user/add'    => __DIR__ . '/modules/user/add.php',
    'user/edit'   => __DIR__ . '/modules/user/edit.php',
    'user/delete' => __DIR__ . '/modules/user/delete.php',
    'auth/login'  => __DIR__ . '/modules/auth/login.php',
    'auth/logout' => __DIR__ . '/modules/auth/logout.php',
];

// Judul tab browser untuk setiap rute.
$judulHalaman = [
    'dashboard'   => 'Dashboard',
    'user/list'   => 'Data Pengguna',
    'user/add'    => 'Tambah Pengguna',
    'user/edit'   => 'Ubah Pengguna',
    'user/delete' => 'Hapus Pengguna',
    'auth/login'  => 'Login',
    'auth/logout' => 'Logout',
    '404'         => 'Halaman Tidak Ditemukan',
];

// Tantangan mandiri 3: ubah menjadi true agar rute di $rutePrivat
// hanya dapat diakses setelah login.
$wajibLogin = false;
$rutePrivat = ['user/add', 'user/edit', 'user/delete'];

$page = $_GET['page'] ?? 'dashboard';

// Input URL tidak pernah dipakai langsung sebagai path file.
if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $currentRoute = '404';
    $contentFile  = __DIR__ . '/views/404.php';
} else {
    $currentRoute = $page;
    $contentFile  = $routes[$page];
}

if ($wajibLogin && in_array($currentRoute, $rutePrivat, true) && !isLoggedIn()) {
    setFlash('gagal', 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.');
    redirect('auth/login');
}

require_once __DIR__ . '/views/header.php';
require $contentFile;
require_once __DIR__ . '/views/footer.php';
