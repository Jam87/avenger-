let tableAuditoria;

document.addEventListener("DOMContentLoaded", function () {
  //*** MOSTRAR DATOS EN DATATABLE Y TRADUCCIÓN ***//
  tableAuditoria = $("#table-auditoria").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: " " + base_url + "Auditoria/getAuditoria",
      dataSrc: "",
    },
    columns: [
      { data: "cod_sesion" },
      { data: "cod_usuario" },
      { data: "Fecha_Inicio_Sesion" },
      { data: "Fecha_Fin_Sesion" },
      { data: "IPConexion" },
      { data: "Navegador" },
      //{ data: "options" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
  });
});

//*** HACER QUE EL DATATABLE FUNCIONES ***//
$("#table-auditoria").DataTable();
