let tableUsuarios;

document.addEventListener("DOMContentLoaded", function () {
  //*** MOSTRAR DATOS EN DATATABLE Y TRADUCCIÓN ***//
  tableUsuarios = $("#table-usuarios").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: " " + base_url + "Usuarios/getUsuarios",
      dataSrc: "",
    },
    columns: [
      { data: "nombre" },
      { data: "telefono" },
      { data: "correo" },
      { data: "usertype" },
      { data: "activo" },
      { data: "options" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
  });
});

// --- CARGAR SELECT TIPO DE USUARIO --- //
let comboxTusario = document.querySelector("#Tusuario");

//Cargo Todos los departamentos que tengo en la BD
function cargarTUsuario() {
  $.ajax({
    type: "GET",
    url: base_url + "Usuarios/obtenerTipoUsuario",
    success: function (response) {
      //departamentos:Tengo el resultado en objeto
      const tipoUsuario = JSON.parse(response);
      let template =
        '<option class="form-control" selected disabled>-- Seleccione --</option>';

      tipoUsuario.forEach((tipo) => {
        template += `<option class="form-control" value="${tipo.cod_tipo_usuario}">${tipo.usertype}</option>`;
      });

      comboxTusario.innerHTML = template;
    },
  });
}

//Llamo a la funcion
cargarTUsuario();

//*** GUARDAR NUEVO TIPO DE USUARIO ***//
//Capturo el formulario
let formUsuario = document.querySelector("#formUsuario");

formUsuario.addEventListener("submit", function (e) {
  e.preventDefault();

  //Capturo data
  /*
      idIntUsuario: Me va a servir para cuando vaya a Editar un usuario
    */

  let idIntUsuario = document.querySelector("#idUsuario");

  let nombre = document.querySelector("#nombre").value;
  let apellido = document.querySelector("#apellido").value;
  let correo = document.querySelector("#correo").value;
  let status = document.querySelector("#lStatus").value;
  let Tusuario = document.querySelector("#Tusuario").value;

  if (
    nombre == "" ||
    apellido == "" ||
    correo == "" ||
    status == "" ||
    Tusuario == ""
  ) {
    Swal.fire({
      position: "top-end",
      toast: "true",
      icon: "warning",
      title: "Error!",
      text: "Los campos nombre y estado no puede esta vacio",
      icon: "warning",
      confirmButtonText: "Aceptar",
      showConfirmButton: false,
      timer: 5000,
      timerProgressBar: true,
    });

    return false;
  }

  let request = new XMLHttpRequest();
  let ajaxUrl = base_url + "Usuarios/setUsuarios";
  let formDta = new FormData(formUsuario);
  request.open("POST", ajaxUrl, true);
  request.send(formDta);

  request.onload = function () {
    if (request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        $("#modalUsuarios").modal("hide");
        $("#table-usuarios").DataTable().ajax.reload();

        //Modal exito Toast aviso parte superior
        Swal.fire({
          position: "top-end",
          toast: "true",
          icon: "success",
          title: "Correcto!",
          text: objData.msg,
          icon: "success",
          confirmButtonText: "Aceptar",
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
        });
      } else {
        //Modal error Toast aviso parte superior
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
      }
    }
  };
});

//*** ELIMINAR TIPO DE USUARIO ***//
function fntDelUsuario(idusuario) {
  Swal.fire({
    title: "Eliminar Usuario",
    text: "¿Realmente quiere eliminar el usuario?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      let request = new XMLHttpRequest();
      let ajaxUrl = base_url + "Usuarios/delUsuario";
      let strData = "cod_usuario=" + idusuario;

      request.open("POST", ajaxUrl, true);
      request.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
      );
      request.send(strData);

      console.log(request);

      request.onload = function () {
        if (request.status == 200) {
          let objData = JSON.parse(request.responseText);

          //objData.status: Valido si es verdadero.
          //Va a mostrar el mensaje
          if (objData.status) {
            $("#table-usuarios").DataTable().ajax.reload();

            //Modal exito Toast aviso parte superior
            Swal.fire({
              position: "top-end",
              toast: "true",
              icon: "success",
              title: "Eliminar!",
              text: objData.msg,
              icon: "success",
              confirmButtonText: "Aceptar",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
            });
          } else {
            //Modal error Toast aviso parte superior

            Swal.fire({
              position: "top-end",
              toast: "true",
              icon: "warning",
              title: "Error!",
              text: objData.msg,
              icon: "warning",
              confirmButtonText: "Aceptar",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
            });
          }
        }
      };
    }
  });
}

//*** EDITAR TIPO DE USUARIO ***//
/**
 * 1.Cambio estilo del modal
 * 2.Traigo los datos
 * 3.Muestro los datos en el modal de acuerdo al ID
 */

function fntEditUsuario(idUsuario) {
  $("#modalUsuarios").modal("show");

  var idusuario = idusuario;

  //Cambio estilos al modal
  document
    .querySelector(".modal-header")
    .classList.replace("bg-pattern", "bg-pattern-2");
  document.querySelector("#titleModal").innerHTML = "Actualizar usuario";
  document
    .querySelector(".modal-header")
    .classList.replace("headerRegister", "headerEdit", "bg-pattern-2");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-primary", "btn-info");
  document.querySelector("#btnText").innerHTML = "Actualizar";
  document.querySelector("#formUsuario").reset();

  var request = (request = new XMLHttpRequest());
  var ajaxUrl = base_url + "Usuarios/getUsuario/" + idUsuario;
  request.open("GET", ajaxUrl, true);
  request.send();

  request.onload = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);

      //Convierto a un objeto el formato .JSON que recibo desde Ajax
      var objData = JSON.parse(request.responseText);

      //status = true
      if (objData.status) {
        //Muestro los datos en modal edit
        document.querySelector("#idUsuario").value = objData.data.cod_usuario;
        document.querySelector("#nombre").value = objData.data.nombre;
        document.querySelector("#apellido").value = objData.data.apellido;
        document.querySelector("#telefono").value = objData.data.telefono;
        document.querySelector("#correo").value = objData.data.correo;
        document.querySelector("#username").value = objData.data.username;
        document.querySelector(".password").value = objData.data.password;
        document.querySelector("#txtDescripcion").value =
          objData.data.direccion;
        document.querySelector("#lStatus").value = objData.data.activo;
        document.querySelector("#Tusuario").value =
          objData.data.cod_tipo_usuario;

        //Renderiza los options: Tipo usuario y Estado
        $("#lStatus").selectpicker("render");
        $("#Tusuario").selectpicker("render");

        //Activo o no
        if (objData.data.activo == 1) {
          var optionSelect =
            '<option value="1" selected class="notBlock">Activo</option>';
        } else {
          var optionSelect =
            '<option value="2" selected class="notBlock">Inactivo</option>';
        }
        var htmlSelect = `${optionSelect}
                              <option value="1">Activo</option>
                              <option value="2">Inactivo</option>
                            `;
        document.querySelector("#lStatus").innerHTML = htmlSelect;

        $("#modalUsuarios").modal("show");
      } else {
        Swal.fire({
          position: "top-end",
          toast: "true",
          icon: "warning",
          title: "Error!",
          text: objData.msg,
          icon: "warning",
          confirmButtonText: "Aceptar",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        });
      }
    }
  };
}

//*** HACER QUE EL DATATABLE FUNCIONES ***//
$("#table-usuarios").DataTable();

//*** MANDAR A LLAMAR AL MODAL: Agregar una nueva marca ***//
function openModal() {
  document.querySelector("#idUsuario").value = "";
  document
    .querySelector(".modal-header")
    .classList.replace("bg-pattern-2", "bg-pattern");
  document.querySelector("#titleModal").innerHTML = "Nuevo usuario";
  document
    .querySelector(".modal-header")
    .classList.replace("headerRegister", "bg-pattern-2", "headerEdit");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-info", "btn-primary");
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#formUsuario").reset();

  $("#modalUsuarios").modal("show");
}
