let tableProveedor;

document.addEventListener("DOMContentLoaded", function () {
  //*** MOSTRAR DATOS EN DATATABLE Y TRADUCCIÓN ***//
  tableProveedor = $("#table-proveedor").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: " " + base_url + "Proveedores/getProveedores",
      dataSrc: "",
    },
    columns: [
      { data: "nombre_banco" },
      { data: "consecutivo" },
      { data: "nombre_moneda" },
      { data: "numero_cuenta" },
      { data: "codigo_swift" },
      { data: "options" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
  });
});

// --- CARGAR SELECT PAIS --- //
let comboxPais = document.querySelector("#comboxpais");

//Cargo Todos los paises que tengo en la BD
function cargarPais() {
  $.ajax({
    type: "GET",
    url: base_url + "Pais/mostrarPais",
    success: function (response) {
      //departamentos:Tengo el resultado en objeto
      const Pais = JSON.parse(response);
      // console.log(Pais)

      let template =
        '<option class="form-control" selected disabled>-- Seleccione --</option>';

      Pais.forEach((tipo) => {
        template += `<option class="form-control" value="${tipo.cod_pais}">${tipo.descripcion}</option>`;
      });

      comboxPais.innerHTML = template;
    },
  });
}

//Llamo a la funcion
cargarPais();

// --- CARGAR SELECT FORMA DE PAGO --- //
let comboxPago = document.querySelector("#comboxpago");

//Cargo Todos los paises que tengo en la BD
function cargarPago() {
  $.ajax({
    type: "GET",
    url: base_url + "Pago/mostrarPago",
    success: function (response) {
      //departamentos:Tengo el resultado en objeto
      const Pagos = JSON.parse(response);

      let template =
        '<option class="form-control" selected disabled>-- Seleccione --</option>';

      Pagos.forEach((tipo) => {
        template += `<option class="form-control" value="${tipo.cod_forma_pago}">${tipo.descripcion}</option>`;
      });

      comboxPago.innerHTML = template;
    },
  });
}

//Llamo a la funcion
cargarPago();

// --- CARGAR SELECT BANCOS --- //
let comboxBancos = document.querySelector("#comboxbanco");

//Cargo Todos los paises que tengo en la BD
function cargarBancos() {
  $.ajax({
    type: "GET",
    url: base_url + "Banco/mostrarBanco",
    success: function (response) {
      //departamentos:Tengo el resultado en objeto
      const Bancos = JSON.parse(response);
      //console.log(Bancos)

      let template =
        '<option class="form-control" selected disabled>-- Seleccione --</option>';

      Bancos.forEach((tipo) => {
        template += `<option class="form-control" value="${tipo.cod_bancos}">${tipo.nombre_banco}</option>`;
      });

      comboxBancos.innerHTML = template;
    },
  });
}

//Llamo a la funcion
cargarBancos();

// --- CARGAR SELECT MONEDA --- //
let comboxMoneda = document.querySelector("#comboxMoneda");

//Cargo Todos los paises que tengo en la BD
function cargarMonedas() {
  $.ajax({
    type: "GET",
    url: base_url + "Moneda/mostrarMoneda",
    success: function (response) {
      //departamentos:Tengo el resultado en objeto
      const Moneda = JSON.parse(response);

      let template =
        '<option class="form-control" selected disabled>-- Seleccione --</option>';

      Moneda.forEach((tipo) => {
        template += `<option class="form-control" value="${tipo.cod_moneda}">${tipo.nombre_moneda}</option>`;
      });

      comboxMoneda.innerHTML = template;
    },
  });
}

//Llamo a la funcion
cargarMonedas();

///////////////////////////////////
//*** GUARDAR NUEVO PROVEEDOR ***//
//////////////////////////////////

function obtenerBanco() {}

var miElemento = document.getElementById("proveedor");
let formProveedor = document.querySelector("#formProveedor");

miElemento.addEventListener("click", function (event) {
  let request = new XMLHttpRequest();
  let ajaxUrl = base_url + "Proveedores/setProveedor";
  let formDta = new FormData(formProveedor);
  request.open("POST", ajaxUrl, true);
  request.send(formDta);

  //console.log(request);

  request.onload = function () {
    if (request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        console.log(objData);
        //$("#table-proveedor").DataTable().ajax.reload();
        document.querySelector("#formProveedor").reset();

        //Modal exito Toast aviso parte superior

        /*if(objData.status == true){
           document.querySelector('.accordion-button').className = 'collapsed';
        }*/

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

//let formProveedor = document.querySelector("#formProveedor");

/*formProveedor.addEventListener("submit", function (e) {
  e.preventDefault();

  let intIdProveedor = document.querySelector("#idProveedor").value; //Lo obtengo a la hora que voy a Editar

});*/

///////////////////////////////////
//*** OBTENER CONSECUTIVO ***//
//////////////////////////////////

function obtenerUltimoConsecutivo() {
  // Creamos un objeto XMLHttpRequest
  var xhr = new XMLHttpRequest();

  // Definimos la URL del archivo PHP que obtendrá el último consecutivo
  var url = base_url + "Proveedores/setConsecutivo";

  xhr.open("GET", url, true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var nuevoConsecutivo = parseInt(xhr.responseText);

      document.getElementById("consecutivo").value = nuevoConsecutivo;
    }
  };

  xhr.send();
}

$valor = obtenerUltimoConsecutivo();

///////////////////////////////////
//*** GUARDAR NUEVO BANCO ***//
//////////////////////////////////

function obtenerBanco() {
  var idBanco = document.getElementById("idBanco").value;

  //asigno al input el valor de la funcion
  var consecutivo = document.getElementById("consecutivo").value;

  //consulta
  //console.log(consecutivo);

  var banco = document.getElementById("comboxbanco").value;
  var moneda = document.getElementById("comboxMoneda").value;
  var nCuenta = document.getElementById("ncuenta").value;
  var swift = document.getElementById("swift").value;

  let request = new XMLHttpRequest();
  let ajaxUrl = base_url + "Proveedores/setBanco";

  let formData = new FormData();
  formData.append("idBanco", idBanco);
  formData.append("banco", banco);
  formData.append("consecutivo", consecutivo);
  formData.append("moneda", moneda);
  formData.append("nCuenta", nCuenta);
  formData.append("swift", swift);

  request.open("POST", ajaxUrl, true);
  request.send(formData);

  request.onload = function () {
    if (request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        obtenerUltimoConsecutivo();
        $("#table-proveedor").DataTable().ajax.reload();

        //$("#table-proveedor").order([[0, "desc"]]);

        // Limpiar los campos del formulario
        // Restablece el valor seleccionado estableciendo selectedIndex en -1
        document.getElementById("comboxbanco").selectedIndex = -1;

        // Establece la opción "Seleccione una opción" como seleccionada
        document.getElementById("comboxbanco").options[0].selected = true;

        document.getElementById("comboxMoneda").selectedIndex = -1;

        // Establece la opción "Seleccione una opción" como seleccionada
        document.getElementById("comboxMoneda").options[0].selected = true;

        document.getElementById("ncuenta").value = "";
        document.getElementById("swift").value = "";

        //Modal exito Toast aviso parte superior

        /*if(objData.status == true){
           document.querySelector('.accordion-button').className = 'collapsed';
        }*/

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
}

///////////////////////////////////
//*** GUARDAR NUEVO CONTACTO ***//
//////////////////////////////////

function obtenerContacto() {
  //alert("Hello! I am an alert box!");

  var idContacto = document.getElementById("idContactoProv").value;

  var movil = document.getElementById("movil").value;
  var telefono = document.getElementById("telefono").value;
  var extension = document.getElementById("extension").value;
  var correo = document.getElementById("correo").value;
  var direccion = document.getElementById("direccion").value;

  let request = new XMLHttpRequest();
  let ajaxUrl = base_url + "Proveedores/setContacto";
  let formData = new FormData();

  formData.append("idContacto", idContacto);
  formData.append("movil", movil);
  formData.append("telefono", telefono);
  formData.append("extension", extension);
  formData.append("correo", correo);
  formData.append("direccion", direccion);

  request.open("POST", ajaxUrl, true);
  request.send(formData);

  request.onload = function () {
    if (request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        document.getElementById("movil").value = "";
        document.getElementById("telefono").value = "";
        document.getElementById("extension").value = "";
        document.getElementById("correo").value = "";
        document.getElementById("direccion").value = "";

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
}
///////////////////////////////////
//*** ELIMINAR BANCO ***//
//////////////////////////////////

function fntDelBancoProv(idproveedor) {
  Swal.fire({
    title: "Eliminar banco",
    text: "¿Realmente quiere eliminar datos del banco?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      let request = new XMLHttpRequest();
      let ajaxUrl = base_url + "Proveedores/delBancoProv";
      let strData = "cod_proveedor=" + idproveedor;

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
/*function fntEditBanco(idbanco) {
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
}*/

//*** HACER QUE EL DATATABLE FUNCIONES ***//
$("#table-proveedor").DataTable({
  columnDefs: [{ targets: "_all", className: "text-center" }],
});

//*** MANDAR A LLAMAR AL MODAL: Agregar una nueva marca ***//
function openModal() {
  document.querySelector("#idBanco").value = "";
  document
    .querySelector(".modal-header")
    .classList.replace("bg-pattern-2", "bg-pattern");
  document.querySelector("#titleModal").innerHTML = "Nuevo Banco";
  document
    .querySelector(".modal-header")
    .classList.replace("headerRegister", "bg-pattern-2", "headerEdit");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-info", "btn-primary");
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#formBanco").reset();

  $("#modalBancos").modal("show");
}
