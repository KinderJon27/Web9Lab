# Lab9Web — Praktikum 9: PHP Modular

Modularisasi program, function, template, dan routing pada mata kuliah Pemrograman Web.

## Tujuan project

1. Memisahkan program ke dalam file dengan tanggung jawab yang jelas.
2. Membedakan `include`, `require`, `include_once`, dan `require_once`.
3. Membuat template (header dan footer) yang dipakai bersama oleh banyak halaman.
4. Membuat function dengan parameter dan nilai kembalian, lalu memindahkannya ke file helper.
5. Menyusun struktur direktori aplikasi PHP secara modular.
6. Menerapkan routing berdasarkan parameter URL dengan whitelist dan halaman 404.
7. Mengintegrasikan semuanya ke aplikasi CRUD yang memakai database.

## Kebutuhan perangkat

- Web server lokal dengan Apache dan MySQL/MariaDB (XAMPP atau Laragon)
- PHP 7.4 atau lebih baru, dengan ekstensi `pdo_mysql` dan `mbstring` (aktif secara bawaan di XAMPP/Laragon)
- Visual Studio Code atau editor kode sejenis
- Browser

## Cara menjalankan

1. Salin folder `Lab9Web` ke docroot web server (`htdocs` pada XAMPP, `www` pada Laragon).
2. Jalankan Apache dan MySQL.
3. Impor `database.sql` lewat phpMyAdmin (tab Import). Skrip membuat database `db_latihan` dan tabel `users`.
4. Jika kredensial MySQL berbeda, ubah `project/config/database.php`.
5. Buka di browser:
   - Latihan dasar: `http://localhost/Lab9Web/lab9_php_modular/home.php`
   - Aplikasi modular: `http://localhost/Lab9Web/project/index.php`

## Struktur direktori

```
Lab9Web/
├── README.md
├── database.sql
├── lab9_php_modular/            Bagian C, D, E (latihan dasar)
│   ├── pesan.php                file yang dipanggil oleh file uji
│   ├── uji-include.php          uji include (Praktik C.3)
│   ├── uji-require.php          uji require (Praktik C.3, langkah 5)
│   ├── uji-once.php             include_once dibanding include
│   ├── header.php               template: awal HTML + navigasi
│   ├── footer.php               template: penutup halaman
│   ├── home.php  about.php  profil.php  kontak.php
│   ├── helpers.php              seluruh function (Bagian E)
│   ├── contoh-panggil.php       memanggil helper (E.5)
│   ├── latihan-function.php     rangkuman latihan function
│   └── style.css
└── project/                     Bagian F, G, H, I (struktur modular + router + CRUD)
    ├── index.php                titik masuk dan router
    ├── .htaccess                URL ringkas (opsional)
    ├── config/
    │   └── database.php         koneksi PDO
    ├── views/
    │   ├── header.php  footer.php  dashboard.php  404.php
    ├── helpers/
    │   └── functions.php        function umum
    ├── modules/
    │   ├── user/    list.php  add.php  edit.php  delete.php
    │   └── auth/    login.php  logout.php
    └── assets/
        ├── css/style.css
        └── js/app.js
```

## Cara file saling terhubung

```
index.php
 ├─ require_once helpers/functions.php     (function: url, e, csrf, flash, dsb.)
 ├─ require_once config/database.php       (membuat $pdo untuk semua modul)
 ├─ cek $_GET['page'] terhadap whitelist $routes  → tidak terdaftar = 404
 ├─ require_once views/header.php
 ├─ require $contentFile                   (views/dashboard.php atau modules/...)
 └─ require_once views/footer.php
```

Semua modul dijalankan di dalam `index.php`, sehingga memakai `$pdo` dan function helper yang sama
tanpa memuat ulang file.

## Daftar rute

| Rute (`?page=`) | File | Keterangan |
|---|---|---|
| `dashboard` | `views/dashboard.php` | Halaman utama (rute bawaan) |
| `user/list` | `modules/user/list.php` | Daftar pengguna |
| `user/add` | `modules/user/add.php` | Form tambah pengguna |
| `user/edit` | `modules/user/edit.php` | Form ubah pengguna (`&id=...`) |
| `user/delete` | `modules/user/delete.php` | Hapus pengguna (hanya POST) |
| `auth/login` | `modules/auth/login.php` | Login |
| `auth/logout` | `modules/auth/logout.php` | Logout (hanya POST) |
| selain di atas | `views/404.php` | Halaman 404 dengan status HTTP 404 |

## Langkah praktikum

| Bagian modul | Yang dikerjakan | File |
|---|---|---|
| C.3 Praktik include/require | Buat `pesan.php`, uji `include` lalu `require` | `lab9_php_modular/pesan.php`, `uji-include.php`, `uji-require.php`, `uji-once.php` |
| D Template layout | `header.php`, `footer.php`, halaman `home.php` | `lab9_php_modular/` |
| Latihan 1 | Home, Profil, Kontak memakai template yang sama | `home.php`, `profil.php`, `kontak.php` (+ `about.php`) |
| E Function | Function tanpa/dengan parameter, return, default, helper | `helpers.php`, `latihan-function.php`, `contoh-panggil.php` |
| Latihan 2 | `formatRupiah()`, `hitungDiskon()`, `validasiEmail()`, `ringkasTeks()` | `lab9_php_modular/helpers.php`, `project/helpers/functions.php` |
| F Struktur direktori | `config`, `views`, `helpers`, `modules`, `assets` | `project/` |
| G Routing + Latihan 3 | Router whitelist, 7 rute, halaman 404 | `project/index.php`, `project/views/404.php` |
| H URL ringkas (opsional) | Aturan rewrite | `project/.htaccess` |
| I Integrasi + Latihan 4 | CRUD dipindah ke `modules/user`, koneksi ke `config/database.php` | `project/` |

### Langkah integrasi CRUD (bagian I)

1. Salin project CRUD praktikum sebelumnya sebagai project baru.
2. Buat direktori `config`, `views`, `helpers`, `modules`, dan `assets`.
3. Pindahkan koneksi database ke `config/database.php` dan muat dengan `require_once`.
4. Pindahkan header, navigasi, dan footer ke `views/header.php` dan `views/footer.php`.
5. Pindahkan function umum ke `helpers/functions.php`.
6. Kelompokkan halaman CRUD pengguna ke `modules/user/`.
7. Buat `index.php` sebagai router dan daftarkan semua halaman yang boleh diakses.
8. Ubah tautan navigasi dan aksi ke pola `index.php?page=...`.
9. Uji setiap fitur CRUD dan pastikan tampilan konsisten.

### Tantangan mandiri

| Tantangan | Status |
|---|---|
| Menu aktif berdasarkan rute | Selesai: `atributNavAktif()` di `helpers/functions.php` dan `views/header.php` |
| Helper pesan sukses/gagal | Selesai: `setFlash()` dan `tampilkanFlash()` |
| Pembatasan akses (login) | Tersedia: ubah `$wajibLogin = true;` di `project/index.php` |
| URL rewrite `.htaccess` | Selesai: `project/.htaccess` (butuh `mod_rewrite` dan `AllowOverride All`) |

### Catatan keamanan yang diterapkan

- Whitelist rute: nilai `page` tidak pernah dipakai langsung sebagai path file.
- Query memakai prepared statement PDO; keluaran HTML di-escape dengan `e()`.
- Tambah, ubah, dan hapus diproses lewat POST dengan token CSRF; hapus tidak bisa lewat URL (GET).
- Detail error koneksi/aplikasi dicatat ke log PHP dan tidak ditampilkan ke pengguna.

## Pengujian (screenshot yang perlu disertakan)

- [ ] Struktur direktori di VS Code
- [ ] `uji-include.php` dan `uji-require.php` saat `pesan.php` ada dan saat diubah namanya
- [ ] Halaman Home, Tentang, Profil, Kontak dengan template yang sama
- [ ] `latihan-function.php`
- [ ] `index.php`, `?page=user/list`, `?page=user/add`, `?page=user/edit&id=1`
- [ ] `?page=admin/rahasia` dan `?page=` (harus 404)
- [ ] Hasil tambah, ubah, dan hapus pengguna

## Kendala dan cara mengatasinya

> Isi bagian ini dengan kendala yang benar-benar Anda alami. Tabel berikut adalah acuan dari
> bagian K modul (Debugging dan Permasalahan Umum).

| Gejala | Kemungkinan penyebab | Perbaikan |
|---|---|---|
| `Failed opening required` | Path file salah atau file tidak ada | Periksa struktur folder; gunakan `__DIR__` |
| `Cannot redeclare function` | File function dimuat lebih dari sekali | Gunakan `require_once` |
| CSS tidak tampil | Path aset salah karena URL berubah | Gunakan `asset()` yang menghitung path dari `baseUrl()` |
| Selalu 404 dari router | Nilai `page` tidak ada di whitelist | Periksa ejaan parameter dan daftar `$routes` |
| URL rewrite tidak bekerja | `mod_rewrite` atau `AllowOverride` belum aktif | Periksa konfigurasi Apache dan lokasi `.htaccess` |
| Konten tampil ganda | Header/footer dipanggil dari lebih dari satu tempat | Panggil hanya dari `index.php` |
