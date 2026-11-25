<?php
// views/footer.php — bagian penutup halaman (dipakai bersama semua halaman).
defined('APP_START') || exit('Akses langsung tidak diizinkan.');
?>
</main>
<footer>
    <p>&copy; <?= date('Y') ?> - Praktikum Pemrograman Web</p>
</footer>
</div>
<script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
