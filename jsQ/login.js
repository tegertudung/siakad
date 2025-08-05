// Dokumen readey di dalam satu file bisa lebih 1 namun saya anjurkan 1 aja dan apapun yang didalam dokumen ready kalau bisa berupa fungsi
// karena dokumen ready itu akan di panggil ketika halaman sudah siap ditampilkan
$(document).ready(function () {
  ButtonExis(); //Panggil fungsi ButtonExis
});

//FUNGSI ButtonExis KITA BUAT UNTUK MENAMPUNG SEMUA BUTTON YANG ADA DI DALAM HALAMAN INI
function ButtonExis() {
  // #1 BUTTON LOGIN`
  $("#loginbtn").on("click", function () {
    login();
  }); //Ketika tombol login di klik maka akan memanggil fungsi login
  // #2 BUTTON REGISTER
}

//FUNGSI LOGIN KITA BUAT UNTUK MELAKUKAN PROSES LOGIN YANG DI TRIGER DENGAN // #1 BUTTON LOGIN
function login() {
  var errorDiv = $("#pesan_error");
  //ada penamaan variabel ada Var, Const dan Let (ket cari di google)
  const data = $("#formLogin").serializeArray(); //serializeArray() digunakan untuk mengirim data form ke server dalam bentuk array
  const csrfName = $('meta[name="csrf-token-name"]').attr("content"); //mengambil nama token csrf dari meta tag
  const csrfHash = $('meta[name="csrf-token-hash"]').attr("content"); //mengambil nilai token csrf dari meta tag
  data.push({ name: csrfName, value: csrfHash }); //menambahkan token csrf ke dalam data yang akan dikirim ke server
  //AJAX REQUEST UNTUK MENGIRIM DATA LOGIN KE SERVER
  errorDiv.addClass("d-none");
  $.ajax({
    url: BaseUrlJsQ + "trxlogin", //URL untuk mengirim data login ke server
    type: "POST", //Metode pengiriman data ke server
    dataType: "JSON", //Tipe data yang diharapkan dari server
    data: $.param(data), //Mengirim data login yang sudah di serialize ke server
    success: function (response) {
      // TAHAP 1
      //MENGATASI RESPONSE DARI FILTER==>
      if (response.Pesan_kirimke_ajax) {
        window.location.href = response.lempar_ke_url;
        return;
      }
      //Kalau dari filter tidak ada pesan maka lanjut ke tahap 2
      // ===================================================>
      // TAHAP 2
      // MENGATASI RESPONSE DARI CONTROLER==>
      $('meta[name="csrf-token-hash"]').attr("content", response.csrf_baru); //Update token csrf di meta tag
      if (response.status) {
        //Jika status berhasil atau ada nilainya atau tidak null
        window.location.href = response.ke_route;
        //arahkan ke dashboard alias login berhasil
      } else {
        //Jika status false atau tidak ada nilainya atau null
        if (response.jumlah_kegagalan) {
          //cek jika jumlah kegagalan ada nilainya atau tidak null maka tampilkan pesan error yang dimodifikasi
          response.pesan +=
            "<br><small>Percobaan gagal: " +
            response.jumlah_kegagalan +
            " kali.</small>";
        }
        //jika jumlah kegagalan null atau tidak ada nilainya maka tampilkan pesan error yang default dari controler
        $("#pesan_error").html(response.pesan).removeClass("d-none");
      }
      // END
    },
    error: function (jqXHR, textStatus, errorThrown) {
      if (
        jqXHR.responseText &&
        (jqXHR.responseText.includes("<!DOCTYPE html>") ||
          jqXHR.responseText.includes("<html>"))
      ) {
        document.open();
        document.write(jqXHR.responseText);
        document.close();
      } else {
        errorDiv
          .html("Terjadi kesalahan. Silakan hubungi administrator.")
          .removeClass("d-none");
      }
    },
  });
}
