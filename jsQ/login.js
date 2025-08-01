$(document).ready(function () {
  ButtonExis();
});
function ButtonExis() {
  $("#loginbtn").on("click", function () {
    login();
  });
}
function login() {
  var data = $("#formLogin").serializeArray();
  //   console.log(data);
  //di variabel data udah ada data array dari inputan user
  //gimana cara data ini masuk ke controler??????
  //kita kirim data array yang ada variabel data menggunakan ajax di bawah ini
  //jangan lupa karena kita di file dengan ekstensi js maka base url dari ci4 harus dibuatkan,maka kita buatkan dulu base url untuk file js
  //di halaman login.php
  //kita beri nama variabel base urlnya di js BaseUrlJsQ
  $.ajax({
    url: BaseUrlJsQ + "trxlogin",
    type: "POST",
    dataType: "JSON",
    data: $.param(data),
    success: function (response) {
      if (response.status) {
        // jika status true maka masuk di bagian ini
        console.log(response);
      } else {
        // kalau false masuk ke bagian ini

        console.log(response);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      printError(jqXHR, textStatus, errorThrown);
    },
  });
}
