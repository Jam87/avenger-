let tableBancos;

document.addEventListener("DOMContentLoaded", function () {
  //*** MOSTRAR DATOS EN DATATABLE Y TRADUCCIÓN ***//
  tableBancos = $("#table-bancos").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    /*ajax: {
      url: " " + base_url + "//get",
      dataSrc: "",
    },*/
    columns: [
      { data: "cod_color" },
      { data: "cod_presentacion" },
      { data: "cod_talla" },
      { data: "consecutivo" },
      { data: "cod_movimiento" },
      { data: "fecha_documento" },
      { data: "existencia_anterior" },
      { data: "existencia_nuevas" },
      { data: "activo" },
      { data: "options" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
  });
});

/////////////////////////////////
// --- CARGAR SELECT COLOR --- //
////////////////////////////////
let comboxColor = document.querySelector("#comboxColor");

//Cargo Todos los paises que tengo en la BD
function cargarColor() {
  $.ajax({
    type: "GET",
    url: base_url + "Colores/mostrarColor",
    success: function (response) {
      //departamentos:Tengo el resultado en objeto
      const color = JSON.parse(response);

      let template =
        '<option class="form-control" selected disabled>-- Seleccione --</option>';

      color.forEach((tipo) => {
        template += `<option class="form-control" value="${tipo.cod_color}">${tipo.descripcion}</option>`;
      });

      comboxColor.innerHTML = template;
    },
  });
}

//Llamo a la funcion
cargarColor();

///////////////////////////////////////
// --- CARGAR SELECT PRESENTACION--- //
//////////////////////////////////////

let comboxPresent = document.querySelector("#comboxPresent");

//Cargo Todos los paises que tengo en la BD
function cargarPresentacion() {
  $.ajax({
    type: "GET",
    url: base_url + "Presentacion/mostrarPresentacion",
    success: function (response) {
      //departamentos:Tengo el resultado en objeto
      const color = JSON.parse(response);

      let template =
        '<option class="form-control" selected disabled>-- Seleccione --</option>';

      color.forEach((tipo) => {
        template += `<option class="form-control" value="${tipo.cod_color}">${tipo.descripcion}</option>`;
      });

      comboxPresent.innerHTML = template;
    },
  });
}

//Llamo a la funcion
cargarPresentacion();

////////////////////////////////////
// --- CARGAR SELECT TOALLAS --- //
///////////////////////////////////

let comboxToalla = document.querySelector("#comboxTalla");

//Cargo Todos las talla que tengo en la BD
function cargarTalla() {
  $.ajax({
    type: "GET",
    url: base_url + "Kardex/mostrarTalla",
    success: function (response) {
      //departamentos:Tengo el resultado en objeto
      const Tallas = JSON.parse(response);
      // console.log(Pais)

      let template =
        '<option class="form-control" selected disabled>-- Seleccione --</option>';

      Tallas.forEach((tipo) => {
        template += `<option class="form-control" value="${tipo.cod_talla}">${tipo.descripcion}</option>`;
      });

      comboxToalla.innerHTML = template;
    },
  });
}

//Llamo a la funcion
cargarTalla();

////////////////////////////////////
// --- CARGAR SELECT BODEGA --- //
///////////////////////////////////

let comboxBodega = document.querySelector("#comboxBodega");

//Cargo Todos las bodega que tengo en la BD
function cargarBodega() {
  $.ajax({
    type: "GET",
    url: base_url + "Kardex/mostrarBodega",
    success: function (response) {
      //departamentos:Tengo el resultado en objeto
      const Bodegas = JSON.parse(response);
      // console.log(Pais)

      let template =
        '<option class="form-control" selected disabled>-- Seleccione --</option>';

      Bodegas.forEach((tipo) => {
        template += `<option class="form-control" value="${tipo.cod_bodega}">${tipo.nombre_bodega}</option>`;
      });

      comboxBodega.innerHTML = template;
    },
  });
}

//Llamo a la funcion
cargarBodega();

///////////////////////////////////
//*** OBTENER CONSECUTIVO ***//
//////////////////////////////////

function obtenerUltimoConsecutivo() {
  // Creamos un objeto XMLHttpRequest
  var xhr = new XMLHttpRequest();

  // Definimos la URL del archivo PHP que obtendrá el último consecutivo
  var url = base_url + "Kardex/setConsecutivo";

  xhr.open("GET", url, true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var nuevoConsecutivo = parseInt(xhr.responseText);

      document.getElementById("consecutivo").value = nuevoConsecutivo;
    }
  };

  xhr.send();
}

//$valor = obtenerUltimoConsecutivo();
obtenerUltimoConsecutivo();

//*** GUARDAR NUEVO BANCO ***//
let formBanco = document.querySelector("#formBanco");

formBanco.addEventListener("submit", function (e) {
  e.preventDefault();

  let intIdBanco = document.querySelector("#idBanco").value; //Lo obtengo a la hora que voy a Editar
  let nombre = document.querySelector("#txtName").value;
  let listLocal = document.querySelector("#listLocal").value;
  let listStatus = document.querySelector("#listStatus").value;

  if (nombre == "" || listLocal == "" || listStatus == "") {
    //Modal error Toast aviso parte superior
    Swal.fire({
      position: "top-end",
      toast: "true",
      icon: "warning",
      title: "Error!",
      text: "Los campos nombre, estado y nacionalidad no puede esta vacio",
      icon: "warning",
      confirmButtonText: "Aceptar",
      showConfirmButton: false,
      timer: 5000,
      timerProgressBar: true,
    });

    return false;
  }

  let request = new XMLHttpRequest();
  let ajaxUrl = base_url + "/Bancos/setBanco";
  let formDta = new FormData(formBanco);
  request.open("POST", ajaxUrl, true);
  request.send(formDta);

  request.onload = function () {
    if (request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        $("#modalBancos").modal("hide");
        $("#table-bancos").DataTable().ajax.reload();

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
function fntDelBanco(idbanco) {
  Swal.fire({
    title: "Eliminar Tipo",
    text: "¿Realmente quiere eliminar tipo de usuario?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      let request = new XMLHttpRequest();
      let ajaxUrl = base_url + "/Banco/delBanco";
      let strData = "cod_bancos=" + idbanco;

      request.open("POST", ajaxUrl, true);
      request.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
      );
      request.send(strData);

      request.onload = function () {
        if (request.status == 200) {
          let objData = JSON.parse(request.responseText);

          //objData.status: Valido si es verdadero.
          //Va a mostrar el mensaje
          if (objData.status) {
            $("#table-bancos").DataTable().ajax.reload();

            Swal.fire({
              position: "top-end",
              toast: "true",
              icon: "success",
              title: "Eliminar!",
              text: objData.msg,
              icon: "success",
              confirmButtonText: "Aceptar",
              showConfirmButton: false,
              timer: 5000,
              timerProgressBar: true,
            });
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
              timer: 5000,
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
 *
 * 1.Cambio estilo del modal
 * 2.Traigo los datos
 * 3.Muestro los datos en el modal de acuerdo al ID
 */
function fntEditBanco(idbanco) {
  var idbanco = idbanco;

  //Cambio estilos al modal
  document;
  //.querySelector(".modal-header")
  //.classList.replace("bg-pattern", "bg-pattern-2");
  document.querySelector("#titleModal").innerHTML = "Actualizar Banco";
  document
    .querySelector(".modal-header")
    .classList.replace("headerRegister", "headerEdit", "bg-pattern-2");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-primary", "btn-info");
  document.querySelector("#btnText").innerHTML = "Actualizar";
  document.querySelector("#formBanco").reset();

  var request = (request = new XMLHttpRequest());
  var ajaxUrl = base_url + "/Banco/getBanco/" + idbanco;
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
        document.querySelector("#idBanco").value = objData.data.cod_bancos;
        document.querySelector("#txtName").value = objData.data.nombre_banco;
        document.querySelector("#txtDescripcion").value =
          objData.data.nota_banco;
        document.querySelector("#listLocal").value = objData.data.listLocal;
        document.querySelector("#listStatus").value = objData.data.listStatus;

        //Localidad
        if (objData.data.es_local == 1) {
          var optionSelect =
            '<option value="1" selected class="notBlock">Nacional</option>';
        } else {
          var optionSelect =
            '<option value="2" selected class="notBlock">Internacional</option>';
        }
        var htmlSelect = `${optionSelect}
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                              `;
        document.querySelector("#listLocal").innerHTML = htmlSelect;

        //Estado
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
        document.querySelector("#listStatus").innerHTML = htmlSelect;
        $("#modalBancos").modal("show");
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
          timer: 5000,
          timerProgressBar: true,
        });
      }
    }
  };
}

//*** HACER QUE EL DATATABLE FUNCIONES ***//
$("#table-bancos").DataTable();

//*** MANDAR A LLAMAR AL MODAL: Agregar una nueva marca ***//
function openModal() {
  document.querySelector("#idKardex").value = "";
  document
    .querySelector(".modal-header")
    .classList.replace("bg-pattern-2", "bg-pattern");
  document.querySelector("#titleModal").innerHTML = "Movimiento de inventario";
  document
    .querySelector(".modal-header")
    .classList.replace("headerRegister", "bg-pattern-2", "headerEdit");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-info", "btn-primary");
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#formKardex").reset();

  $("#modalKardex").modal("show");
}
