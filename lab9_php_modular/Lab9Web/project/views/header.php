<?php
// views/header.php — awal dokumen HTML, navigasi, dan area pesan (dipakai bersama semua halaman).
defined('APP_START') || exit('Akses langsung tidak diizinkan.');

$judulTab    = $judulHalaman[$currentRoute] ?? 'Aplikasi PHP Modular';
$sedangLogin = isLoggedIn();
$namaLogin   = $sedangLogin ? (penggunaLogin()['nama'] ?? '') : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judulTab) ?> - Aplikasi PHP Modular</title>
    <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
</head>
<body>
<div class="container">
<header>
    <h1>Aplikasi PHP Modular</h1>
    <p>Modularisasi program, function, template, dan routing</p>
    <nav aria-label="Menu utama">
        <a href="<?= e(url('dashboard')) ?>"<?= atributNavAktif('dashboard') ?>>Dashboard</a>
        <a href="<?= e(url('user/list')) ?>"<?= atributNavAktif(['user/list', 'user/edit', 'user/delete']) ?>>Pengguna</a>
        <a href="<?= e(url('user/add')) ?>"<?= atributNavAktif('user/add') ?>>Tambah Pengguna</a>
        <span class="nav-spacer"></span>
<?php if ($sedangLogin): ?>
        <span class="nav-user">Halo, <?= e($namaLogin) ?></span>
        <form method="post" action="<?= e(url('auth/logout')) ?>" class="nav-form">
            <?= csrfField() ?>
            <button type="submit" class="btn-link">Logout</button>
        </form>
<?php else: ?>
        <a href="<?= e(url('auth/login')) ?>"<?= atributNavAktif('auth/login') ?>>Login</a>
<?php endif; ?>
    </nav>
</header>
<main>
<?php tampilkanFlash(); ?>
