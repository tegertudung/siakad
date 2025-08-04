if (WaktuTerkunci) {
  // Jika WaktuTerkunci tidak null, maka kita akan menghitung mundur
  const hitungmundur = document.getElementById("hitungmundur"); //Buat variabel untuk menunjukan div hitung mundur dihalaman locked
  const kembalikeLogin = document.getElementById("kembaliKeHalamanLogin"); // Buat variabel untuk menunjukan tombol kembali ke halaman login dihalaman locked

  // Menghitung waktu yang tersisa dalam detik
  const timer = setInterval(function () {
    const waktutunggu = Math.round(WaktuTerkunci - new Date().getTime() / 1000);

    if (waktutunggu <= 0) {
      clearInterval(timer);
      hitungmundur.innerHTML = "Anda sudah bisa mencoba login kembali.";
      kembalikeLogin.classList.remove("d-none"); //defaulnya tombol ini disembunyikan, jika sudah waktunya maka tampilkan tombol ini
    } else {
      const menit = Math.floor(waktutunggu / 60);
      const detik = waktutunggu % 60;
      hitungmundur.innerHTML =
        "Sisa waktu: " +
        String(menit).padStart(2, "0") +
        ":" +
        String(detik).padStart(2, "0");
    }
  }, 1000);
}
