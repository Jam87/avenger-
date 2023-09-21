
<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>
    <title><?= $data['page_title']; ?></title>
    <?php MainHead($data); ?>
	
	<style>
		.close_popup{position:absolute; top: 7px; right: 22px; font-size: 33pt; cursor: pointer;}
	</style>	
</head>

<body>


    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ==== Main Headerr ====== -->
        <?php MainHeader($data); ?>

        <!-- ========== App Menu ========== -->
        <?php MainMenu($data); ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Nueva compra</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Compras</a></li>
                                        <li class="breadcrumb-item active">Nueva compra</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row justify-content-center">
                        <div class="col-xxl-9">
                            <div class="card" id="frmCompras">
                                <form class="needs-validation" novalidate id="invoice_form">
									<!-- CARGA IMAGEN DE LOGOTIPO | SI SE BORRA LOS DEMAS PROCESOS JS NO FUNCIONAN -->
                                    <div class="card-body border-bottom border-bottom-dashed p-4" style="display: none !important;">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                
												<div class="profile-user mx-auto  mb-3">
                                                    <input id="profile-img-file-input" type="file" class="profile-img-file-input" />
                                                    <label for="profile-img-file-input" class="d-block" tabindex="0">
                                                        <span class="overflow-hidden border border-dashed d-flex align-items-center justify-content-center rounded" style="height: 60px; width: 256px;">
                                                            <img src="assets/images/logo-dark.png" class="card-logo card-logo-dark user-profile-image img-fluid" alt="logo dark">
                                                            <img src="assets/images/logo-light.png" class="card-logo card-logo-light user-profile-image img-fluid" alt="logo light">
                                                        </span>
                                                    </label>
                                                </div>
												
                                            </div>
                                            <!--end col-->
                                        </div>
                                    </div>
									<!-- CARGA IMAGEN DE LOGOTIPO | SI SE BORRA LOS DEMAS PROCESOS JS NO FUNCIONAN -->
									
                                    <div class="card-body p-4">
                                        <div class="row g-3">
                                            <div class="col-lg-3 col-sm-6">
                                                <label for="txtDocumento">Documento No.</label>
                                                <input type="text" class="form-control bg-light border-0" id="txtDocumento" placeholder="Documento No." value=""/>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label for="date-field">Fecha del documento</label>
                                                    <input type="text" class="form-control bg-light border-0" id="date-field" data-provider="flatpickr" data-time="true" placeholder="Seleccione una fecha">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label for="date-field">Proveedor</label>
                                                    <input id="txtProveedor" name="txtProveedor" type="text" class="form-control bg-light border-0"  placeholder="Seleccione un proveedor" readonly/>
													<input id="hdProveedor" name="hdProveedor" type="hidden" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label for="totalamountInput">Valor Total</label>
                                                    <input type="text" class="form-control bg-light border-0" id="totalamountInput" placeholder="$0.00" readonly />
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
										
										<div class="row g-3">
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label for="txtFormaPago">Froma de Pago</label>
                                                    <input id="txtFormaPago" name="txtFormaPago" type="text" class="form-control bg-light border-0"  placeholder="Forma de pago" readonly/>
													<input id="hdfFormaPago" name="hdProveedor" type="hidden" />
                                                </div>
                                            </div>
											
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label for="txtPais">Pais</label>
                                                    <input id="txtPais" name="txtPais" type="text" class="form-control bg-light border-0"  placeholder="Forma de pago" readonly/>
                                                </div>
                                            </div>
										</div>
                                    </div>
                                    
                                    <div class="card-body p-4">
                                        <div class="table-responsive">
                                            <table id="productos" class="invoice-table table table-borderless table-nowrap mb-0">
                                                <thead class="align-middle">
                                                    <tr class="table-active">
                                                        <th scope="col" style="width: 50px;">#</th>
                                                        <th scope="col">
                                                            Producto
                                                        </th>
                                                        <th scope="col" style="width: 120px;">
                                                            <div class="d-flex currency-select input-light align-items-center">
                                                                Precio
                                                                <select class="form-selectborder-0 bg-light" data-choices data-choices-search-false id="choices-payment-currency" onchange="otherPayment()">
                                                                    <option value="4">($)</option>
                                                                    <option value="1">(C$)</option>
                                                                </select>
                                                            </div>
                                                        </th>
                                                        <th scope="col" style="width: 120px;">Cantidad</th>
                                                        <th scope="col" class="text-end" style="width: 150px;">Total</th>
                                                        <th scope="col" class="text-end" style="width: 105px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="newlink">
                                                    <tr id="1" class="product">
                                                        <th scope="row">1</th>
                                                        <td class="text-start">
                                                            <div class="mb-2">
                                                                <input type="text" class="form-control bg-light border-0 show_productos" placeholder="Seleccionar Producto" readonly />
                                                            </div>
                                                            <input class="rcodigo" value="" type="hidden"/>
                                                        </td>
                                                        <td class="precio">
                                                            <input type="number" class="form-control product-price bg-light border-0 rprecio" step="0.5" min="0" placeholder="0.00" onblur="formatNumber(this, 2); control_fill(this);" onkeypress="formatNumber(this, 2)" onfocus="control_clear(this)" />
                                                        </td>
                                                        <td class="cantidad">
                                                            <input type="number" class="form-control product-price bg-light border-0 rcantidad" step="1" min="0" placeholder="0" onblur="formatNumber(this, 2); control_fill(this);" onkeypress="formatNumber(this, 2)" onfocus="control_clear(this)" />
                                                        </td>
                                                        <td class="text-end">
                                                            <div>
                                                                <input type="text" class="form-control bg-light border-0 product-line-price rtotal" placeholder="$0.00" readonly />
                                                            </div>
                                                        </td>
                                                        <td class="product-removal">
                                                            <a class="btn btn-success btn-borrar">Borrar</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr id="newForm" style="display: none;"><td class="d-none" colspan="5"><p>Add New Form</p></td></tr>
                                                    <tr>
                                                        <td colspan="5">
                                                            <a id="add-Producto" class="btn btn-soft-secondary fw-medium">Nuevo</a>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-top border-top-dashed mt-2">
                                                        <td colspan="3"></td>
                                                        <td colspan="2" class="p-0">
                                                            <table class="table table-borderless table-sm table-nowrap align-middle mb-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">Sub Total</th>
                                                                        <td style="width:150px;">
                                                                            <input type="text" class="form-control bg-light border-0" id="cart-subtotal" placeholder="$0.00" readonly />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Transporte</th>
                                                                        <td>
                                                                            <input type="text" class="form-control bg-light border-0" id="cart-shipping" placeholder="$0.00" value="0.00" onblur="formatNumber(this, 2); control_fill(this);" onkeypress="formatNumber(this, 2)" onfocus="control_clear(this)" />
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="border-top border-top-dashed">
                                                                        <th scope="row">Total</th>
                                                                        <td>
                                                                            <input type="text" class="form-control bg-light border-0" id="cart-total" placeholder="$0.00" readonly />
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <!--end table-->
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!--end table-->
                                        </div>
										
                                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                            <button type="button" class="btn btn-success"><i class="ri-printer-line align-bottom me-1" onClick="Guardar();"></i> Guardar</button>
                                            <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Imprimir</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
							
							<?php include_once("proveedores.php"); ?>
							
							<?php include_once("productos.php"); ?>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
			
			
			

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> Â© J.I.P
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Diseñado & Desarrollado por J.I.P
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->
	
	<input id="current_row" name="current_row" type="hidden" value="" />
	
    <!-- JAVASCRIPT -->
    <?php MainJs($data); ?>
	
    <script>
        $(document).ready(function () {	
			/* MOSTRAR PROVEEDORES */
            $("#txtProveedor").click(function () {
                show_popup();
            });
			
            $(".close").click(function () {
                close_popup();
            });
			
            $("#txtpbuscar").keyup(function () {
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#proveedorTable tbody tr"), function () {
                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
			
			/* MOSTRAR PRODUCTOS */
            $(".show_productos").click(function () {
                var id = $(this).parent("div").parent("td").parent("tr").attr('id');
				$("#current_row").val(id);
				
                show_popup_productos();
            });
			
            $(".close_producto").click(function () {
                close_popup_productos();
            });
			
            $("#txtBuscarProducto").keyup(function () {
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#productosTable tbody tr"), function () {
                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
			
			/* CALCULOS */
            $(".rprecio").keyup(function (e) {
                calcular_detalle(this);
            });
			
            $(".rcantidad").keyup(function (e) {
                calcular_detalle(this);
            });
			
            $("#cart-shipping").keyup(function (e) {
                Totales();
            });
			
			productos();
			
			Load_Proveedores();
			
			Load_Productos()
        });
		
		/* MOSTRAR PROVEEDORES */
        function show_popup() 
		{
            $("#frmProveedor").show(300);
            $("#frmCompras").hide(300);
        }

        function close_popup() 
		{
            $("#frmProveedor").hide(300);
            $("#frmCompras").show(300);
        }
		
        function Load_Proveedores()
        {
            /* ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
            var formData = new FormData();
            formData.append('type', "view_proveedores");

            $.ajax({
                url: "<?= base_url(); ?>Config/services.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                //beforeSend: function (){alert("Iniciando");},
				
                success: function(datos)
                {	
                    var obj = JSON.parse(datos);

                    if (obj.state == "success")
                    {
                        $("#tblProveedores").html(obj.estructura);
                    }
                    else
                    {
                        alert("Ocurrió un error inesperado.");
                    }

                },

                error: function (datos)
                {
                    alert('Se produjo un error al intentar cargar proveedores: ' + datos.responseText);
                }

                //,complete : function(xhr, status){alert("Terinado");}
            });
            /* ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
        }
		
		function selectProveedor(row)
		{
			var codigo = $(row).find("td").eq(0).html();
			var nombre = $(row).find("td").eq(1).html();
			var pais = $(row).find("td").eq(3).html();
			var FormaPago = $(row).find("td").eq(4).html();
			
			$("#hdProveedor").val(codigo);
			$("#txtProveedor").val(nombre);
			$("#txtPais").val(pais);
			$("#txtFormaPago").val(FormaPago);
			
			close_popup();
		}
		
		/* MOSTRAR PRODUCTOS */
        function show_popup_productos() 
		{
            $("#frmProductor").show(300);
            $("#frmCompras").hide(300);
        }

        function close_popup_productos() 
		{
            $("#frmProductor").hide(300);
            $("#frmCompras").show(300);
        }
		
        function Load_Productos()
        {
            /* ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
            var formData = new FormData();
            formData.append('type', "view_productos_compras");

            $.ajax({
                url: "<?= base_url(); ?>Config/services.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                //beforeSend: function (){alert("Iniciando");},
				
                success: function(datos)
                {	
                    var obj = JSON.parse(datos);

                    if (obj.state == "success")
                    {
                        $("#tblProductos").html(obj.estructura);
                    }
                    else
                    {
                        alert("Ocurrió un error inesperado.");
                    }

                },

                error: function (datos)
                {
                    alert('Se produjo un error al intentar cargar productos: ' + datos.responseText);
                }

                //,complete : function(xhr, status){alert("Terinado");}
            });
            /* ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
        }
		
		/* TABLA DE PRODUCTOS */
        function productos()
		{ 
           var tbody = $('#productos #newlink'); 
           var fila_contenido = tbody.find('tr').first().html();
			
           //Agregar fila nueva. 
           $('#add-Producto').click(function(){ 
              var fila_nueva = $('<tr></tr>');
              fila_nueva.append(fila_contenido); 
              tbody.append(fila_nueva); 
			   
              $(".show_productos").click(function () {
				  var id = $(this).parent("div").parent("td").parent("tr").attr('id');
				  $("#current_row").val(id);
				  
                  show_popup_productos();
				  
				  this.off('click');
              });
			   
              $(".rprecio").keyup(function (e) {
                  calcular_detalle(this);
				  
				  this.off('click');
              });

              $(".rcantidad").keyup(function (e) {
                  calcular_detalle(this);
				  
				  this.off('click');
              });
			   
              $('.btn-borrar').click(function(){ 
                 $(this).parent("td").parent("tr").remove();
				  
				  consecutivos();
              });
			   
			  consecutivos();
           });
        }
		
		function selectProducto(row)
		{
			var codigo = $(row).find("td").eq(0).html();
			var nombre = $(row).find("td").eq(2).html();
			
			var rowId = $("#current_row").val();
			$("#" + rowId + " td.text-start input[type=hidden]").val(codigo);
			$("#" + rowId + " td.text-start input[type=text]").val(nombre);
			
			close_popup_productos();
		}
		
		function consecutivos()
		{
			var consecutivo = 1;
			
			$("#productos #newlink tr").each(function (index) {
				
				$(this).children("th").each(function (index2) {
					
					if (index2 == 0)
					{
						$(this).parent("tr").attr("id",consecutivo);
						$(this).html(consecutivo);
						consecutivo += 1;
					}
					
				})
				
			})
		}
		
		/* CALCULO DE PRODUCTOS */
		function calcular_detalle(objeto)
		{
          var row =  $(objeto).parent("td").parent("tr").attr('id');

          var precio = $("#" + row + " .rprecio").val();
          precio = precio.replace(",", "");

          var cantidad = $("#" + row + " .rcantidad").val();
          cantidad = cantidad.replace(",", "");

          var total = parseFloat(precio) * parseFloat(cantidad);

          $("#" + row + " .rtotal").val(total);
			
		  Totales();
		}
		
		function Totales()
		{
			var resultVal = 0.0; 

			$("#productos #newlink tr").each(function(){
              var celdaValor = $(this).find('.rtotal');

              if (parseFloat(celdaValor.val()) > 0)
              {
                  resultVal += parseFloat(celdaValor.val());
              }

			}) //each
			
			resultVal = parseFloat(resultVal, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
			
			$("#cart-subtotal").val(resultVal);
			
			var envio = $("#cart-shipping").val();
			envio = envio.replace(",", "");
			
			var Total = 0;
			
			resultVal = resultVal.replace(",", "");
			
			var Total = parseFloat(resultVal) + parseFloat(envio);
			
			$("#cart-total").val(Total);
			$("#totalamountInput").val(Total);
		}
		
		/* GUARDAR REGISTROS */
		function Guardar()
		{
			if ($("#txtDocumento").val() == "")
			{
				alert("<p>El proceso no puede continuar. <br/> El numero de documento es requerido. <br/><br/></p>");
				return false;
			}
			
			if ($("#date-field").val() == "")
			{
				alert("<p>El proceso no puede continuar. <br/> La fecha es requerida. <br/><br/></p>");
				return false;
			}
			
			if ($("#hdProveedor").val() == "")
			{
				alert("<p>El proceso no puede continuar. <br/> El proveedor es requerido. <br/><br/></p>");
				return false;
			}
			
			if ( !parseFloat($("#cart-total").val()) > 0)
			{
				alert("<p>El proceso no puede continuar. <br/> El monto de la compa debe ser mayor a cero. <br/><br/></p>");
				return false;
			}
			
			// GENERAR DETALLE			
			var array = [];
			var headers = [];
			headers[0] = "codigo";
			headers[1] = "precio";
			headers[2] = "cantidad";
			
			$("#productos #newlink tr").each(function(){
				var arrayItem = {};
				
              	var celCodigo = $(this).find('.rcodigo').val();
			  	var celPrecio = $(this).find('.rprecio').val();
				var celCantidad = $(this).find('.rcantidad').val();
				
				arrayItem[headers[0]] = celCodigo;
				arrayItem[headers[1]] = celPrecio;
				arrayItem[headers[2]] = celCantidad;
				
				array.push(arrayItem);
			}) //each
			
			//console.log(array);
			
			var formData = new FormData();
			formData.append('type', "compra_new");
			formData.append('proveedor', $("#hdProveedor").val());
			formData.append('documento', $("#txtDocumento").val());
			formData.append('Fecha', $("#date-field").val());
			formData.append('Moneda', $("#choices-payment-currency").val());
			formData.append('total', $("#cart-total").val());
			formData.append("detalle", JSON.stringify(array));
			
			$.ajax({
				url: "<?= base_url(); ?>Config/services.php",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(datos)
				{
                    var obj = JSON.parse(datos);

                    if (obj.state == "success")
                    {
                        alert("El proceso a finalizado de forma correcta.");
						//location.reload();
                    }
                    else
                    {
                        alert(obj.mensaje);
                    }

				},

                error: function (datos)
                {
                    alert('Se produjo un error al intentar guardar: ' + datos.mensaje);
                }
			});
		}
		
    </script>
</body>

</html>
