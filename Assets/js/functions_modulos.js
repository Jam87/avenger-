let tableModulos;

document.addEventListener("DOMContentLoaded", function () {
  //*** MOSTRAR DATOS EN DATATABLE Y TRADUCCIÓN ***//
  tableModulos = $("#table-modulos").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: " " + base_url + "Modulos/getModulos",
      dataSrc: "",
    },
    columns: [
      { data: "orden" },
      { data: "modulo" },
      { data: "padre_id" },
      { data: "vista" },
      { data: "icon_menu" },
      { data: "options" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
  });

  //iniciarArbolModulos();
});

/*===================================================================*/
//EVENTO QUE GUARDA LOS DATOS DEL MODULO
/*===================================================================*/

//Boton registrar modulos
document
  .querySelector("#btnRegistrarModulo")
  .addEventListener("click", function () {
    fnRegistrarModulo();
  });

//Boton reorganizar modulos
document
  .querySelector("#btnReordenarModulos")
  .addEventListener("click", function () {
    fnOrganizarModulos();
  });

//Boton reiniciar modulos
document.querySelector("#btnReiniciar").addEventListener("click", function () {
  actualizarArbolModulos();
});

/*===================================*/
//FUNCIONES MANTENIMIENTO DE MODULOS
/*===================================*/

// --- REGISTRAR NUEVO MODULO ----//

function fnRegistrarModulo() {
  var forms = document.getElementsByClassName(
    "needs-validation-registro-modulo"
  );

  var validation = Array.prototype.filter.call(forms, function (form) {
    if (form.checkValidity() === true) {
      //console.log("Listo para registrar el producto");

      Swal.fire({
        title: "Está seguro de registrar el modulo",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, deseo registrarlo!",
      }).then((result) => {
        if (result.isConfirmed) {
          let request = new XMLHttpRequest();
          let ajaxUrl = base_url + "Modulos/setModulo";
          let formDta = new FormData(form);
          request.open("POST", ajaxUrl, true);
          request.send(formDta);

          //console.log(request);

          request.onload = function () {
            if (request.status == 200) {
              let objData = JSON.parse(request.responseText);

              if (objData.status) {
                $("#table-modulos").DataTable().ajax.reload();

                document.querySelector("#frm_registro_modulo").reset();
                $(".needs-validation-registro-modulo").removeClass(
                  "was-validated"
                );

                //Modal exito Toast aviso parte superior
              }
            }
          };
        }
      });
    }
  });
}

// --- Cargar mostrar todos los modulos en el arbol --- //

function fnCargarArbolModulos() {
  //base_url + "Banco/setBanco"
  // Modulos/mostrarJstree

  let dataSource;

  $.ajax({
    url: base_url + "Modulos/mostrarJstree",
    type: "POST",
    dataType: "json",
    success: function (data) {
      dataSource = data;
      $("#arbolModulos").jstree({
        core: {
          check_callback: true,
          data: dataSource,
        },
        checkbox: {
          keep_selected_style: true,
        },
        types: {
          default: {
            icon: "bx bx-folder",
          },
          file: {
            icon: "bx bx-folder",
          },
        },
        plugins: ["types", "dnd"],
      });
      /*.bind("loaded.jstree", function (event, data) {
          $(this).jstree("open_all");
        });*/
    },
  });
}

fnCargarArbolModulos();

// --- Actualizar todos los modulos en el arbol --- //

function actualizarArbolModulos() {
  let dataSource;

  $.ajax({
    url: base_url + "Modulos/mostrarJstree",
    type: "POST",
    dataType: "json",
    success: function (data) {
      dataSource = data;

      $("#arbolModulos").jstree(true).settings.core.data = dataSource;
      $("#arbolModulos").jstree(true).refresh();
    },
  });
}

// --- Organizar todos los modulos en el arbol --- //
function fnOrganizarModulos() {
  var array_modulos = [];

  var reg_id, reg_padre_id, reg_orden;

  //Capturo la info del jstree(recupero)
  var v = $("#arbolModulos").jstree(true).get_json("#", {
    flat: true,
  });

  for (i = 0; i < v.length; i++) {
    var z = v[i];

    //asignamos el id, el padre Id y el nombre del modulo
    reg_id = z["id"];
    reg_padre_id = z["parent"];
    reg_orden = i;

    array_modulos[i] = reg_id + ";" + reg_padre_id + ";" + reg_orden;
  }

  //return;

  /*REGISTRAMOS LOS MODULOS CON EL NUEVO ORDENAMIENTO */
  let dataSource;

  $.ajax({
    url: base_url + "Modulos/mostrarJstree",
    type: "POST",
    dataType: "json",
    success: function (data) {
      dataSource = data;
      $("#arbolModulos")
        .jstree({
          core: {
            check_callback: true,
            data: dataSource,
          },
          checkbox: {
            keep_selected_style: true,
          },
          types: {
            default: {
              icon: "bx bx-folder",
            },
            file: {
              icon: "bx bx-folder",
            },
          },
          plugins: ["types", "dnd"],
        })
        .bind("loaded.jstree", function (event, data) {
          $(this).jstree("open_all");
        });
    },
  });
  ///////////////
  $.ajax({
    url: base_url + "Modulos/ReorganizarModulos",
    type: "POST",
    data: {
      modulos: array_modulos,
    },
    dataType: "json",
    success: function (respuesta) {
      if (respuesta > 0) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Se registró correctamente",
          showConfirmButton: false,
          timer: 1500,
        });

        //tbl_modulos.ajax.reload();
        $("#table-modulos").DataTable().ajax.reload();

        //recargamos arbol de modulos - MANTENIMIENTO MODULOS ASIGNADOS A PERFILES
        //actualizarArbolModulosPerfiles(); //ESTE ES PARA QUE TAMBIEN SE ACTUALICE EN ASIGNAR MODULO AL PERFIL
      } else {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Error al registrar",
          showConfirmButton: false,
          timer: 1500,
        });
      }
    },
  });
}

/*----------------------------------------------------------*/

//*** HACER QUE EL DATATABLE FUNCIONES ***//
$("#table-modulos").DataTable();

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
