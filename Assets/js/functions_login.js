let formLogin = document.querySelector("#formLogin");

formLogin.addEventListener("submit", function (e) {
  e.preventDefault();

  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  var ajaxUrl = base_url + "Login/loginUser";
  var formData = new FormData(formLogin);
  request.open("POST", ajaxUrl, true);
  request.send(formData);

  request.onload = function () {
    if (request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        window.location = base_url + "app";
      } else {
        //Modal exito Toast aviso parte superior
        Swal.fire({
          position: "top-end",
          toast: "true",
          icon: "warning",
          title: "Error!",
          text: objData.msg,
          icon: "warning",
          confirmButtonText: "Aceptar",
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
        });

        document.querySelector("#userpassword").value = "";
      }
    } else {
      //Modal error Toast aviso parte superior

      Swal.fire({
        position: "top-end",
        toast: "true",
        icon: "warning",
        title: "Error!",
        text: "Atención!, Error en el proceso",
        icon: "warning",
        confirmButtonText: "Aceptar",
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
      });
    }
    return false;
  };
});
