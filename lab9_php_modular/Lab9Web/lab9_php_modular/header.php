<?php
// header.php — awal dokumen HTML, judul, dan navigasi (dipakai bersama oleh semua halaman)
// Halaman dapat mengisi $judul sebelum memanggil file ini.
$halamanAktif = basename($_SERVER['SCRIPT_NAME'] ?? '');
$menu = [
    'home.php'             => 'Home',
    'about.php'            => 'Tentang',
    'profil.php'           => 'Profil',
    'kontak.php'           => 'Kontak',
    'latihan-function.php' => 'Function',
];
$judulHalaman = $judul ?? 'Aplikasi PHP Modular';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($judulHalaman, ENT_QUOTES, 'UTF-8'); ?> - Aplikasi PHP Modular</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<header>
    <h1>Aplikasi PHP Modular</h1>
    <p>Contoh pemisahan template dan konten</p>
    <nav>
<?php foreach ($menu as $berkas => $label): ?>
        <a href="<?php echo $berkas; ?>"<?php echo $berkas === $halamanAktif ? ' class="active" aria-current="page"' : ''; ?>><?php echo $label; ?></a>
<?php endforeach; ?>
    </nav>
</header>
<main>
