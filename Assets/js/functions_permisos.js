document.addEventListener("DOMContentLoaded", function () {
  //*** MOSTRAR DATOS EN DATATABLE Y TRADUCCIÓN ***//
  tablePermisos = $("#table-permisos").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: " " + base_url + "Permisos/getPermisos",
      dataSrc: "",
    },
    columns: [
      //{ data: "cod_tipo_usuario" },
      { data: "usertype" },
      { data: "activo" },
      { data: "options" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
  });

  //Llamada
  iniciarArbolModulos();
});
/////////////////

/********** ARBOL ************/

let modulos_usuario;
let modulos_sistema;
let idPerfil = 0;

document.addEventListener("DOMContentLoaded", function () {
  let tablePermisos = $("#table-permisos").DataTable(); //Tengo los datos del DataTable
  let selectedElmsIds = [];

  $("#table-permisos").on("click", ".btnSeleccionarPerfil", function () {
    //console.log("Boton seleccionado");

    //Capturo los informacion de cada fila

    var data = tablePermisos.row($(this).parents("tr")).data();

    if ($(this).parents("tr").hasClass("selected")) {
      $(this).parents("tr").removeClass("selected");

      //modulos: Es el div donde se carga los modulos
      //deselect_all = Hace que los check que se hayan marcado
      //en el arbol los quita todo
      $("#modulos").jstree("deselect_all", false);

      //Le remueve todos los options
      $("#select_modulos option").remove();

      //Seleccionado, pero cuando lo desmarque, el id perfil reset 0
      idPerfil = 0;
    } else {
      //Cuando marque un registro, le digo que me asigne el ID del Perfil de acuerdo al REGISTRO que he
      //Seleccionado, pero cuando lo desmarque
      tablePermisos.$("tr.selected").removeClass("selected");
      $(this).parents("tr").addClass("selected");
      idPerfil = data["cod_tipo_usuario"]; //Id tipo usuario

      //Mostrar arbol de modulos del sistema
      $("#card-modulos").css("display", "block");

      let request = new XMLHttpRequest();
      let ajaxUrl = base_url + "Modulos/obtenerModuloPerfil";
      let strData = "id_perfil=" + idPerfil;

      request.open("POST", ajaxUrl, true);
      request.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
      );
      request.send(strData);

      request.onload = function () {
        if (request.status == 200) {
          let objData = JSON.parse(request.responseText);

          modulos_usuario = objData;

          seleccionarModuloPerfil(idPerfil);
        }
      };
    }
  });
});

/* ==========================================================================
        EVENTO QUE SE DISPARA CADA VEZ QUE HAY UN CAMBIO EN EL ARBOL DE MODULOS
      ========================================================================== */
$("#modulos").on("changed.jstree", function (evt, data) {
  //Me sirve para poder ir agregando las opciones o los modulos a mi select

  $("#select_modulos option").remove(); //Quito todos los opcions a mi select

  var selectedElms = $("#modulos").jstree("get_selected", true); //Seleccioname todos los element marcados

  $.each(selectedElms, function () {
    for (let i = 0; i < modulos_sistema.length; i++) {
      if (modulos_sistema[i]["id"] == this.id && modulos_sistema[i]["vista"]) {
        $("#select_modulos").append(
          $("<option>", {
            value: this.id,
            text: this.text,
          })
        );
      }
    }
  });

  if ($("#select_modulos").has("option").length <= 0) {
    $("#select_modulos").append(
      $("<option>", {
        value: 0,
        text: "--No hay modulos seleccionados--",
      })
    );
  }
});

/* =============================================================
   EVENTO PARA MARCAR TODOS LOS CHECKBOX DEL ARBOL DE MODULOS
  ============================================================= */
$("#marcar_modulos").on("click", function () {
  $("#modulos").jstree("select_all");
});

/* =============================================================
   EVENTO PARA DESMARCAR TODOS LOS CHECKBOX DEL ARBOL DE MODULOS
   ============================================================= */
$("#desmarcar_modulos").on("click", function () {
  $("#modulos").jstree("deselect_all", false);
  $("#select_modulos option").remove();

  $("#select_modulos").append(
    $("<option>", {
      value: 0,
      text: "--No hay modulos seleccionados--",
    })
  );
});

/* =============================================================
   REGISTRO EN BASE DE DATOS DE LOS MODULOS ASOCIADOS AL PERFIL 
  ============================================================= */
$("#asignar_modulos").on("click", function () {
  //alert("entro al evento");
  selectedElmsIds = [];
  var selectedElms = $("#modulos").jstree("get_selected", true);

  $.each(selectedElms, function () {
    selectedElmsIds.push(this.id);

    if (this.parent != "#") {
      selectedElmsIds.push(this.parent);
    }
  });

  let modulosSeleccionados = [...new Set(selectedElmsIds)];

  //ID modulo inicio
  let modulo_inicio = $("#select_modulos").val();

  if (idPerfil != 0 && modulosSeleccionados.length > 0) {
    registrarPerfilModulos(modulosSeleccionados, idPerfil, modulo_inicio);
  } else {
    Swal.fire({
      position: "center",
      icon: "warning",
      title: "Debe seleccionar el perfil y módulos a registrar",
      showConfirmButton: false,
      timer: 3000,
    });
  }
});

function iniciarArbolModulos() {
  $.ajax({
    url: base_url + "Modulos/mostrarJstree",
    type: "POST",
    dataType: "json",
    success: function (data) {
      modulos_sistema = data;
      //dataSource = data;
      $("#modulos")
        .jstree({
          core: {
            check_callback: true,
            data: data,
          },
          checkbox: {
            keep_selected_style: false,
          },
          types: {
            default: {
              icon: "bx bx-folder",
            },
            file: {
              icon: "bx bx-folder",
            },
          },
          plugins: ["wholerow", "checkbox", "types", "changed"],
        })
        .bind("loaded.jstree", function (event, data) {
          // you get two params - event & data - check the core docs for a detailed description
          $(this).jstree("open_all");
        });
    },
  });
}

function seleccionarModuloPerfil(idPerfil) {
  $("#modulos").jstree("deselect_all"); //Inicialmente desmaco todo modulos

  //Selecciono los checkbox de ese arbol
  for (let i = 0; i < modulos_sistema.length; i++) {
    //console.log("modulos_sistema[i]['id']", modulos_sistema[i]["id"]);

    if (
      parseInt(modulos_sistema[i]["id"]) ==
        parseInt(modulos_usuario[i]["id"]) &&
      parseInt(modulos_usuario[i]["sel"]) == 1
    ) {
      $("#modulos").jstree("select_node", modulos_sistema[i]["id"]);
    }
  }

  //OCULTAMOS LA OPCION DE MODULOS Y PERFILES PARA EL PERFIL DE ADMINISTRADOR
  if (idPerfil == 1) {
    //SOLO PERFIL ADMINISTRADOR
    $("#modulos").jstree(true).hide_node(38);
  } else {
    $("#modulos").jstree(true).show_all();
  }
}

function registrarPerfilModulos(modulosSeleccionados, idPerfil, modulo_inicio) {
  /**
   * modulosSeleccionados = Es un array que tiene todos ID de los modulos
   * idPerfil = Son los ID del perfil
   * modulo_inicio = ID modulos de inicio
   */

  $.ajax({
    url: base_url + "Perfil/RegistrarPerfilModulo",
    type: "POST",
    data: {
      idModuloSeleccionado: modulosSeleccionados,
      idPerfil: idPerfil,
      modulo_inicio: modulo_inicio,
    },
    dataType: "json",
    success: function (respuesta) {
      if (respuesta > 0) {
        Swal.fire({
          position: "bottom-right",
          toast: "true",
          icon: "success",
          title: "Correcto!",
          text: "Se registro correctamente",
          icon: "success",
          confirmButtonText: "Aceptar",
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
        });

        $("#select_modulos option").remove();
        $("#modulos").jstree("deselect_all", false);

        $("#table-permisos").DataTable().ajax.reload();

        $("#card-modulos").css("display", "none");
      } else {
        Swal.fire({
          position: "top-end",
          toast: "true",
          icon: "warning",
          title: "Error!",
          text: "Error al registrar",
          icon: "warning",
          confirmButtonText: "Aceptar",
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
        });
      }
    },
  });
}

//*** HACER QUE EL DATATABLE FUNCIONES ***//
$("#table-permisos").DataTable();

//*** MANDAR A LLAMAR AL MODAL: Agregar una nueva marca ***//
function openModal() {
  document.querySelector("#idTipo").value = "";
  document
    .querySelector(".modal-header")
    .classList.replace("bg-pattern-2", "bg-pattern");
  document.querySelector("#titleModal").innerHTML = "Nuevo Tipo de usuario";
  document
    .querySelector(".modal-header")
    .classList.replace("headerRegister", "bg-pattern-2", "headerEdit");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-info", "btn-primary");
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#formTipoUsuario").reset();

  $("#modalTipo").modal("show");
}
