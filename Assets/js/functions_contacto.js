let tableContacto;

document.addEventListener("DOMContentLoaded", function () {
  //*** MOSTRAR DATOS EN DATATABLE Y TRADUCCIÓN ***//
  tableContacto = $("#table-contacto").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: " " + base_url + "Contacto/getContacto",
      dataSrc: "",
    },
    columns: [
      { data: "descripcion" },
      { data: "es_telefono" },
      { data: "es_correo" },
      { data: "es_url" },
      { data: "activo" },
      { data: "options" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
  });
});

// --- CARGAR SELECT CONTACTO --- //
/* let comboxContacto = document.querySelector("#comboxContacto");

    //Cargo Todos los paises que tengo en la BD
    function cargarContacto() {
      $.ajax({
        type: "GET",
        url: base_url + "/Contacto/mostrarContactos",
        success: function (response) {
          //departamentos:Tengo el resultado en objeto
          const Contacto = JSON.parse(response);
          console.log(Contacto);
          let template =
            '<option class="form-control" selected disabled>-- Seleccione --</option>';
    
            Contacto.forEach((tipo) => {
            template += `<option class="form-control" value="${tipo.descripcion}">${tipo.descripcion}</option>`;
          });
    
          comboxContacto.innerHTML = template;
        },
      });
    }
    
    //Llamo a la funcion
    cargarContacto();
*/
//*** GUARDAR NUEVO CONTACTO ***//
let formContacto = document.querySelector("#formContacto");

formContacto.addEventListener("submit", function (e) {
  e.preventDefault();

  let idContacto = document.querySelector("#idContacto").value; //Lo obtengo a la hora que voy a Editar
  let descripcion = document.querySelector("#descripcion").value;

  if (descripcion == "") {
    //Modal error Toast aviso parte superior
    Swal.fire({
      position: "top-end",
      toast: "true",
      icon: "warning",
      title: "Error!",
      text: "El campo descripción no puede esta vacio",
      icon: "warning",
      confirmButtonText: "Aceptar",
      showConfirmButton: false,
      timer: 5000,
      timerProgressBar: true,
    });

    return false;
  }

  let request = new XMLHttpRequest();
  let ajaxUrl = base_url + "Contacto/setContacto";
  let formDta = new FormData(formContacto);
  request.open("POST", ajaxUrl, true);
  request.send(formDta);

  request.onload = function () {
    if (request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        $("#modalContacto").modal("hide");
        $("#table-contacto").DataTable().ajax.reload();

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

//*** ELIMINAR CONTACTO ***//
function fntDelCont(idcontacto) {
  Swal.fire({
    title: "Eliminar Contacto",
    text: "¿Realmente quiere eliminar el contacto?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      let request = new XMLHttpRequest();
      let ajaxUrl = base_url + "Contacto/delContacto";
      let strData = "cod_contacto=" + idcontacto;

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
            $("#table-contacto").DataTable().ajax.reload();

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

//*** EDITAR CONTACTO ***//
/**
 *
 * 1.Cambio estilo del modal
 * 2.Traigo los datos
 * 3.Muestro los datos en el modal de acuerdo al ID
 */
function fntEditCont(idcontacto) {
  var idcontacto = idcontacto;

  //Cambio estilos al modal
  document
    .querySelector(".modal-header")
    .classList.replace("bg-pattern", "bg-pattern-2");
  document.querySelector("#titleModal").innerHTML = "Actualizar Contacto";
  document
    .querySelector(".modal-header")
    .classList.replace("headerRegister", "headerEdit", "bg-pattern-2");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-primary", "btn-info");
  document.querySelector("#btnText").innerHTML = "Actualizar";
  document.querySelector("#formContacto").reset();

  var request = (request = new XMLHttpRequest());
  var ajaxUrl = base_url + "Contacto/EditContact/" + idcontacto;
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
        document.querySelector("#idContacto").value = objData.data.cod_contacto;
        document.querySelector("#descripcion").value = objData.data.descripcion;
        document.querySelector("#telefono").value = objData.data.es_telefono;
        document.querySelector("#correo").value = objData.data.es_correo;
        document.querySelector("#web").value = objData.data.es_url;
        document.querySelector("#listStatus").value = objData.data.activo;

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
        document.querySelector("#listStatus ").innerHTML = htmlSelect;
        $("#modalContacto").modal("show");
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

/////////////////////////

//const arr = [];

//arr.push("Fourth item", "Fifth item");

//console.log(arr);
//table_id

function create_tr(table_id) {
  let table_body = document.getElementById(table_id);
  first_tr = table_body.firstElementChild;

  //first_tr.push(table_body);

  //console.log(first_tr);

  tr_clone = first_tr.cloneNode(true);

  table_body.append(tr_clone);
  //const element = parameters.push(table_body);

  //console.log(element);

  /*table_body.push(parameters);
  //clean_first_tr(table_body.firstElementChild);*/

  console.log(tr_clone);

  /*first_tr = table_body.firstElementChild
      tr_clone  = first_tr.cloneNode(true);*/
}

function clean_first_tr(firstTr) {
  let children = firstTr.children;

  children = Array.isArray(children) ? children : Object.values(children);

  children.forEach((x) => {
    if (x !== firstTr.lastElementChild) {
      x.firstElementChild.value = "";
    }
  });
}

function remove_tr(This) {
  if (This.closest("tbody").childElementCount == 1) {
    alert("No tiene permiso para borrar");
  } else {
    This.closest("tr").remove();
  }
}

////////////////
//*** HACER QUE EL DATATABLE FUNCIONES ***//
$("#table-contacto").DataTable();

//*** MANDAR A LLAMAR AL MODAL: Agregar una nuevo contacto ***//
function openModal() {
  document.querySelector("#idContacto").value = "";
  document
    .querySelector(".modal-header")
    .classList.replace("bg-pattern-2", "bg-pattern");
  document.querySelector("#titleModal").innerHTML = "Nuevo contacto";
  document
    .querySelector(".modal-header")
    .classList.replace("headerRegister", "bg-pattern-2", "headerEdit");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-info", "btn-primary");
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#formContacto").reset();

  $("#modalContacto").modal("show");
}
