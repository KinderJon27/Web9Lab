<?php
// modules/auth/logout.php — keluar dari aplikasi (rute: auth/logout).
// Hanya diproses lewat POST dengan token CSRF (tombol Logout pada header).
defined('APP_START') || exit('Akses langsung tidak diizinkan.');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifikasiCsrf()) {
    unset($_SESSION['user']);
    session_regenerate_id(true);
    setFlash('sukses', 'Anda sudah logout.');
    redirect('auth/login');
}

redirect('dashboard');
