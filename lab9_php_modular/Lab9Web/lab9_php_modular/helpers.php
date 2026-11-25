<?php
// helpers.php — kumpulan function (Bagian E dan Latihan 2)
// Dimuat dengan require_once agar tidak terjadi "Cannot redeclare function".

// ---- E.1 Function tanpa parameter ----
function tampilkanSalam()
{
    echo 'Selamat belajar PHP modular!';
}

// ---- E.2 Function dengan parameter ----
function sapaPengguna($nama)
{
    echo 'Halo, ' . htmlspecialchars($nama, ENT_QUOTES, 'UTF-8');
}

// ---- E.3 Function dengan return ----
function hitungLuasPersegiPanjang($panjang, $lebar)
{
    return $panjang * $lebar;
}

// ---- E.4 Type declaration dan nilai default ----
// Mengembalikan NOMINAL potongan harga (bukan harga akhir).
function hitungDiskon(float $harga, float $persen = 10): float
{
    return $harga * ($persen / 100);
}

// ---- E.5 Function helper ----
function formatRupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function e(string $nilai): string
{
    return htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8');
}

// ---- Latihan function (Bagian E, soal 1-3) ----
function konversiCelsiusKeFahrenheit(float $c): float
{
    return ($c * 9 / 5) + 32;
}

// Predikat berdasarkan rentang nilai (rentang ditetapkan sendiri).
function tentukanStatusNilai(float $nilai): string
{
    if ($nilai >= 85) {
        return 'A (Sangat Baik)';
    }
    if ($nilai >= 70) {
        return 'B (Baik)';
    }
    if ($nilai >= 55) {
        return 'C (Cukup)';
    }
    if ($nilai >= 40) {
        return 'D (Kurang)';
    }
    return 'E (Sangat Kurang)';
}

function hitungTotal(float $harga, int $jumlah): float
{
    return $harga * $jumlah;
}

// ---- Latihan 2: validasiEmail() dan ringkasTeks() ----
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
