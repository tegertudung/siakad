
// Tunggu sampai seluruh dokumen HTML selesai dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Ambil elemen form dengan id 'formRegister'
    var form = document.getElementById('formRegister');
    // Jika form tidak ditemukan, hentikan script
    if (!form) return;

    // Tambahkan event listener untuk event submit pada form
    form.addEventListener('submit', function(e) {
        // Mencegah form submit default (tidak reload halaman)
        e.preventDefault();
        // Ambil seluruh data form dalam bentuk FormData (bisa handle file dan input biasa)
        var formData = new FormData(form);

        // Kirim data form ke server menggunakan fetch API
        // URL tujuan diambil dari attribute action pada form
        fetch(form.action, {
            method: 'POST', // Metode HTTP POST
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Tandai request sebagai AJAX agar server bisa membedakan
            },
            body: formData // Data form yang dikirim
        })
        .then(function(response) {
            // Jika server melakukan redirect (bukan response JSON), langsung arahkan ke URL baru
            if (response.redirected) {
                window.location.href = response.url;
                return;
            }
            // Jika response berupa JSON, parse JSON-nya
            return response.json();
        })
        .then(function(data) {
            if (!data) return;
            // Jika server mengirimkan properti redirect_url, redirect ke URL tersebut
            if (data.redirect_url) {
                window.location.href = data.redirect_url;
                return;
            }
            // Jika status true (berhasil), fallback redirect ke halaman verifikasi OTP
            if (data.status) {
                window.location.href = BaseUrlJsQ + '/register/verify';
            } else {
                // Jika ada error, tampilkan semua pesan error dalam alert
                var msgs = [];
                if (data.errors) {
                    // Loop semua error validasi dan masukkan ke array msgs
                    for (var key in data.errors) {
                        msgs.push(data.errors[key]);
                    }
                } else if (data.message) {
                    // Jika ada pesan error umum
                    msgs.push(data.message);
                }
                // Tampilkan semua pesan error dengan alert
                alert(msgs.join("\n"));
            }
        })
        .catch(function(err) {
            // Jika terjadi error pada fetch (misal server down), tampilkan pesan error
            console.error(err);
            alert('Terjadi kesalahan server.');
        });
    });
});
