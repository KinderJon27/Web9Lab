// assets/js/app.js — konfirmasi sebelum form dengan atribut data-confirm dikirim
document.addEventListener('submit', function (event) {
    var form = event.target;
    var pesan = form.getAttribute ? form.getAttribute('data-confirm') : null;

    if (pesan && !window.confirm(pesan)) {
        event.preventDefault();
    }
});
