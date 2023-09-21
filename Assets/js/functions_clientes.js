let tableClientes;

document.addEventListener("DOMContentLoaded", function () {
  //*** MOSTRAR DATOS EN DATATABLE Y TRADUCCIÓN ***//
  tableClientes = $("#table-clientes").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: " " + base_url + "Cliente/getClientes",
      dataSrc: "",
    },

    //nombre_cliente, c.persona_contacto, c.cod_forma_pago, c.exento_impuesto, c.movil, c.email
    columns: [
      { data: "nombre_cliente" },
      { data: "persona_contacto" },
      { data: "descripcion" },
      { data: "exento_impuesto" },
      { data: "movil" },
      { data: "email" },
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
      //console.log(Pais);
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

//*** GUARDAR NUEVO CLIENTE ***//

// Seleccionar el formulario
const formCliente = document.querySelector("#formClientes");

// Escuchar el evento submit del formulario
/*formCliente.addEventListener("submit", function (event) {
  // Prevenir que el formulario se envíe de forma convencional
  event.preventDefault();

  // Obtener los datos del formulario
  const formData = new FormData(formCliente);

  // Realizar la solicitud fetch

  fetch(base_url + "Cliente/setCliente", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      const status = data.status;
      console.log(status);
      const message = data.msg;
      console.log(message);

      if (status) {
        Swal.fire({
          /*title: 'Success!',
          text: data,
          icon: 'success',
          confirmButtonText: 'Ok'*

          position: "top-end",
          toast: "true",
          icon: "success",
          title: "Correcto!",
          text: message,
          icon: "success",
          confirmButtonText: "Aceptar",
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
        });
      } else {
        Swal.fire({
          title: "Error",
          text: message,
          icon: "error",
          confirmButtonText: "OK",
        });
      }

      /*Swal.fire({
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
      });*

      //formCliente.reset();
      // Imprimir la respuesta del servidor
      //console.log(data);
    })
    .catch((error) => {
      // Imprimir cualquier error en la consola
      console.error(error);
    });
});*/

//const formCliente = document.querySelector("#formClientes");

formCliente.addEventListener("submit", function (e) {
  e.preventDefault();

  /*let intIdBanco = document.querySelector("#idBanco").value; //Lo obtengo a la hora que voy a Editar
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
  }*/

  let request = new XMLHttpRequest();
  let ajaxUrl = base_url + "Cliente/setCliente";
  let formDta = new FormData(formCliente);
  request.open("POST", ajaxUrl, true);
  request.send(formDta);

  request.onload = function () {
    if (request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        $("#modalClientes").modal("hide");
        $("#table-clientes").DataTable().ajax.reload();

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

//*** ELIMINAR CLIENTE ***//
function fntDelCliente(idcliente) {
  Swal.fire({
    title: "Eliminar cliente",
    text: "¿Realmente quiere eliminar el cliente?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      let request = new XMLHttpRequest();
      let ajaxUrl = base_url + "Cliente/delCliente";
      let strData = "cod_cliente=" + idcliente;

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
            $("#table-clientes").DataTable().ajax.reload();

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
  var ajaxUrl = base_url + "Banco/getBanco/" + idbanco;
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

////////////////////////

/*$(document).ready(function () {
  var maxField = 10; //Input fields increment limitation
  var addButton = $(".add_button"); //Add button selector
  var wrapper = $(".field_wrapper"); //Input field wrapper
  var fieldHTML = ""; //New input field html
  var x = 1; //Initial field counter is 1
  $(addButton).click(function () {
    //Once add button is clicked
    if (x < maxField) {
      //Check maximum number of input fields
      x++; //Increment field counter
      $(wrapper).append(fieldHTML); // Add field html
    }
  });
  $(wrapper).on("click", ".remove_button", function (e) {
    //Once remove button is clicked
    e.preventDefault();
    $(this).parent("div").remove(); //Remove field html
    x--; //Decrement field counter
  });
});*/

let parameters = [];

//Remover Elemento
function removeElement(event, position) {
  event.target.parentElement.remove();
  delete parameters[position];
}

//Agregar elemento
function addJsonElement(json) {
  parameters.push(json);
  return parameters.length - 1;
}

(function load() {
  const $form = document.getElementById("formClientes");

  const selectCont = document.getElementById("comboxContact").value;
  const descricion = document.getElementById("Descripcion").value;
  const extension = document.getElementById("Extension").value;

  const $divElements = document.getElementById("divElements");
  const $btnSave = document.getElementById("btnSave");
  const $btnAdd = document.getElementById("btnAdd");

  /*const templateElement = (data, position) => {
    return `
            <button class="delete" onclick="removeElement(event, ${position})"></button>
            <strong>Tipo contacto - </strong> ${data} 
        `;
  };*/

  function templateElement(data1, position) {
    return `
    
    <div class="item">
      <div class="row">
      <div class="col-sm-4">
          <div class="formulario__grupo" id="grupo__apellido">                                    
              <select class="form-select mb-3" id="comboxContact" name="comboxContact">
                  <option> --- seleccione ---</option>
                  <option value="Celular-claro"> Celular claro</option>
                  <option value="Celular tigo">Celular tigo</option>
                  <option value="Correo de trabajo">Correo de trabajo</option>
                  <option value="Correo personal">Correo personal</option>
                  <option value="Dirección de casa">Dirección de casa</option>
                  <option value="Dirección de trabajo">Dirección de trabajo</option>
                  <option value="Dirección de segundo trabajo">Dirección de segundo trabajo</option>
                  <option value="Teléfono de casa">Teléfono de casa</option>
                  <option value="Teléfono de trabajo">Teléfono de trabajo</option>
              </select>
          </div>
      </div>
      <div class="col-sm-4">
          <div class="formulario__grupo" id="grupo__nombre">                                          

              <div class="formulario__grupo-input">
                  <input type="text" class="form-border" name="Descripcion" id="Descripcion" placeholder="Teléfono, Correo, Dirección" autocomplete="off">
              </div>

          </div><!-- Fin: nombre -->
      </div>

      <div class="col-sm-4">
          <div class="formulario__grupo" id="grupo__apellido">
      
          </div><!-- Fin: apellido -->
          <div class="input-group">
              <input type="text" class="form-control" name="Extension" id="Extension" placeholder="Digite la extensión">
              <!--<button id="btnAd" type="button" class="btn btn-success">Button</button>-->

              <button type="button" onclick="removeElement(event, ${position})" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      </div>
  </div>

       
           <button type="button" onclick="removeElement(event, ${position})" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         
        `;
  }

  $btnAdd.addEventListener("click", (event) => {
    let index = addJsonElement({
      ComboxContact: $form.comboxContact.value,
      Descripcion: $form.Descripcion.value,
      Extension: $form.Extension.value,
    });

    //var str = "<div>hello world</div>";
    //var elm = document.getElementById("targetID");
    // elm.innerHTML += str;

    //var newElement = document.createElement('div');
    //$div.innerHTML = '<div>Hello World!</div>';
    //ComboxContact.appendChild($div);​​​​​​​​​​​​​​​​

    const $div = document.createElement("div");
    $div.classList.add("notification", "is-link", "is-light", "py-2", "my-1");
    $div.innerHTML = templateElement(
      `${$form.comboxContact.value}`,
      `${$form.Descripcion.value}`,
      `${$form.Extension.value}`,
      index
    );

    /* $div.innerHTML = templateElement(
        `${$form.comboxContact.value} - ${$form.Descripcion.value} - ${$form.Extension.value}`,
        index
      );*/

    $divElements.insertBefore($div, $divElements.firstChild);

    //$form.reset();
  });

  /*$btnSave.addEventListener("click", (event) => {
    parameters = parameters.filter((el) => el != null);

    var data = {
      comboxContact: $("#comboxContact").val(),
      Descripcion: $("#Descripcion").val(),
      Descripcion: $("#Extension").val(),
    };

    $array = json_decode(parameters, true);

    /*foreach($array as $value)
    {
    } *     
    $.ajax({
      //URL para enviar y recibir datos
      url: base_url + "Contacto/setContacto",
      type: "POST",
      dataType: "json",
      data: data,
      success: function (response) {
        alert("funciona bien");
      },
    });

    /*let prueba = JSON.stringify(parameters);
    const $jsonDiv = document.getElementById("jsonDiv");
    $jsonDiv.innerHTML = JSON.stringify(parameters);
    $divElements.innerHTML = "";
    parameters = [];
  });*/
})();

////////////////////////////////
///////////////////////////////

$("#addrow").click(function () {
  var length = $(".sl").length;
  var i = parseInt(length) + parseInt(1);
  var newrow = $("#next").append(
    '<div class="row"><div class="col-sm-1"><label for="Age">Sl No:</label><input type="text" class="form-control sl" name="slno[]" value="' +
      i +
      '" readonly=""></div><div class="col-sm-3"><label for="Student Name">Student Name:</label><input type="text" class="form-control" name="student_name[]" id="st_name' +
      i +
      '" placeholder="Enter Student Name"></div><div class="col-sm-3"><label for="Phone">Phone No*:</label><input type="text" class="form-control" name="phone_no[]" id="pn' +
      i +
      '" placeholder="Enter Phone No"></div><div class="col-sm-1"><label for="Age">Age:</label><input type="text" class="form-control" id="age' +
      i +
      '" name="age[]" placeholder="Enter Age"></div><div class="col-sm-3"><label for="DateofBirth">Date of Birth:</label><input type="date" id="dob' +
      i +
      '" name="date_of_birth[]" class="form-control"/></div><input type="button" class="btnRemove btn-danger" value="Remove"/></div><br>'
  );
});

// Removing event here
$("body").on("click", ".btnRemove", function () {
  $(this).closest("div").remove();
});

//*** HACER QUE EL DATATABLE FUNCIONES ***//
$("#table-clientes").DataTable();

//*** MANDAR A LLAMAR AL MODAL: Agregar una nueva marca ***//
function openModal() {
  // document.querySelector("#idClientes").value = "";
  document
    .querySelector(".modal-header")
    .classList.replace("bg-pattern-2", "bg-pattern");
  document.querySelector("#titleModal").innerHTML = "Nuevo cliente";
  document
    .querySelector(".modal-header")
    .classList.replace("headerRegister", "bg-pattern-2", "headerEdit");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-info", "btn-primary");
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#formClientes").reset();

  $("#modalClientes").modal("show");
}
