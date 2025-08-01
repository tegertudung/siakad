$(document).ready(function () {
  ButtonExis();
});
function ButtonExis() {
  $("#loginbtn").on("click", function () {
    login();
  });
}
function login() {
  let data = $("#formLogin").serializeArray();
  let csrfName = $('meta[name="csrf-token-name"]').attr("content");
  let csrfHash = $('meta[name="csrf-token-hash"]').attr("content");
  data.push({ name: csrfName, value: csrfHash });
  //   console.log(data);
  //di variabel data udah ada data array dari inputan user
  //gimana cara data ini masuk ke controler??????
  //kita kirim data array yang ada variabel data menggunakan ajax di bawah ini
  //jangan lupa karena kita di file dengan ekstensi js maka base url dari ci4 harus dibuatkan,maka kita buatkan dulu base url untuk file js
  //di halaman login.php
  //kita beri nama variabel base urlnya di js BaseUrlJsQ
  var errorDiv = $("#login-error-message");
  errorDiv.addClass("d-none");

  $.ajax({
    url: BaseUrlJsQ + "trxlogin",
    type: "POST",
    dataType: "JSON",
    data: $.param(data),
    // data response dari controler ditangkap
    success: function (response) {
      if (response.lock_type) {
        window.location.href = response.redirect_url;
        return;
      }
      $('meta[name="csrf-token-hash"]').attr("content", response.csrf_baru);

      if (response.status) {
        window.location.href = response.redirect_url;
      } else {
        let errorMessage = response.message;
        if (response.failed_count) {
          errorMessage +=
            "<br><small>Percobaan gagal: " +
            response.failed_count +
            " kali.</small>";
        }

        errorDiv.html(errorMessage).removeClass("d-none");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      printError(jqXHR, textStatus, errorThrown);
    },
  });
}
