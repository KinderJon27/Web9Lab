<?php
// profil.php — halaman Profil (Latihan 1) + ringkasTeks() dan e() (Latihan 2)
$judul = 'Profil';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/header.php';

// TODO: ganti dengan data Anda sendiri.
$profil = [
    'Nama'        => 'Jonatan Firdaus',
    'NIM'         => '312510017',
    'Kelas'       => 'I252A',
    'Mata kuliah' => 'Pemrograman Web',
];
$tentangSaya = 'Mahasiswa yang sedang mempelajari pemrograman web dengan PHP. '
    . 'Pada praktikum ini saya belajar memisahkan program menjadi file template, function, '
    . 'dan modul agar kode lebih mudah dipahami, digunakan kembali, diuji, dan dikembangkan.';
?>
<section class="content">
    <h2>Halaman Profil</h2>
    <table>
<?php foreach ($profil as $label => $isi): ?>
        <tr><th><?php echo e($label); ?></th><td><?php echo e($isi); ?></td></tr>
<?php endforeach; ?>
    </table>

    <h3>Tentang saya (diringkas 80 karakter)</h3>
    <p><?php echo e(ringkasTeks($tentangSaya, 80)); ?></p>
</section>
<?php require_once __DIR__ . '/footer.php'; ?>
