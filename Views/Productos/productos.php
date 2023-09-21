<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>
    <title><?= $data['page_title']; ?></title>
    <?php MainHead($data); ?>
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" int1egrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
	<style>
        .col-xxl-9 {
          width: 95% !important;
        }

       .card-header a{
		   margin-right: 11px; 
		   cursor: pointer;
		}
		
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
                                <h4 class="mb-sm-0"><?= $data['page_title']; ?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Inventario</a></li>
                                        <li class="breadcrumb-item active"><?= $data['page_title']; ?></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->					
					
					<div id="form-main" class="row justify-content-center">
						<div class="col-xxl-9">
                            <div class="card-header">
                                <a onClick="show_popup();"><i class="fas fa-plus"></i> Agregar Nuevo</a>
								<a><i class="fas fa-edit"></i> Modificara</a>
                            </div>
							
							<div class="card" id="mainForm">
								<h2 style="padding: 22px 0px 0px 22px;">Parametros de Busqueda</h2>
								<div class="card-body p-4">
									<!--Begin Row -->
                                    <div class="row g-3">
                                        <div class="col-lg-3 col-sm-6">
                                            <div>
                                                <label for="date-field">Buscar Productos</label>
                                                <input id="txtBuscarProducto" name="txtBuscarProducto" type="text" class="form-control bg-light border-0"  placeholder="Nombre de Producto" readonly/>
                                            </div>
                                        </div>
                                    </div>
									<!--End Row ---->
								</div>
								
								<div class="card-body">
                                    <div class="table-responsive table-card mb-3">
                                        <table class="table align-middle table-nowrap mb-0 myTable" id="mainTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="sort" data-sort="codigo" scope="col">CODIGO</th>
                                                    <th class="sort" data-sort="documento" scope="col">FAMILIA</th>
                                                    <th class="sort" data-sort="proveedor" scope="col">PRODUCTOS</th>
													<th class="sort" data-sort="proveedor" scope="col">UM</th>
                                                    <th class="sort" data-sort="fecha" scope="col">ALTURA</th>
                                                    <th class="sort" data-sort="valor" scope="col">LARGO</th>
													<th class="sort" data-sort="valor" scope="col">GROSOR</th>
                                                </tr>
												
                                            </thead>
                                            <tbody id="tblProductos" class="list">
                                            </tbody>
                                        </table>
                                    </div>
								</div>
							</div>
							
						</div>
					</div>
					
					<?php include_once("proceso.php"); ?>
				</div>
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
	
    <!-- JAVASCRIPT -->
    <?php MainJs($data); ?>
	
    <script>
        $(document).ready(function () {	
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
			
			Load_Familia();
			Load_Productos();
			Load_Unidad_Medida();
        });
		
        function show_popup() 
		{
            $("#form-registrar").show(300);
            $("#form-main").hide(300);
        }

        function close_popup()
		{
            $("#form-registrar").hide(300);
            $("#form-main").show(300);
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
		
        function Load_Familia()
        {
            /* ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
            var formData = new FormData();
            formData.append('type', "view_familia");

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
                        $("#cmbFamilia").append(obj.estructura);
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
		
        function Load_Unidad_Medida()
        {
            /* ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
            var formData = new FormData();
            formData.append('type', "view_unidad_medida");

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
                        $("#cmbUnidad").append(obj.estructura);
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
    </script>
</body>

</html>
