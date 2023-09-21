<?php
#Mando a llamar al modal
//getModal('bancos', $data);
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?= $data['data-sidebar-size']; ?>" data-sidebar-image="none">

<head>
    <title><?= $data['page_title']; ?></title>
    <?php MainHead($data); ?>
</head>

<body>

    <div id="layout-wrapper">

        <!-- ==== Main Headerr ====== -->
        <?php MainHeader($data); ?>

        <!-- ========== App Menu ========== -->
        <?php MainMenu($data); ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><?= $data['page_name']; ?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $data['page_title']; ?></a></li>
                                        <li class="breadcrumb-item active">proveedores</li>
                                    </ol>
                                </div>

                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="card">

                                <!-- Accordions with Icons -->
                                <div class="accordion custom-accordionwithicon" id="accordionWithicon">

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="accordionwithiconExample2">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_iconExamplecollapse2" aria-expanded="false" aria-controls="accor_iconExamplecollapse2">
                                                <i class="ri-add-circle-line" style="color:#000069; font-weight:bold; font-size:15px; padding-right:1px"></i> <span style="color:#000069; font-weight:bold">AGREGAR PROVEEDOR </span>
                                            </button>
                                        </h2>
                                        <div id="accor_iconExamplecollapse2" class="accordion-collapse collapse" aria-labelledby="accordionwithiconExample2" data-bs-parent="#accordionWithicon">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-xxl-6">

                                                        <div class="card">
                                                            <div class="card-body">


                                                                <!-- Nav tabs -->
                                                                <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-3" role="tablist">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                                                            Datos generales
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                                                            Banco
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
                                                                            Información contacto
                                                                        </a>
                                                                    </li>
                                                                </ul>


                                                                <div class="tab-content text-muted">
                                                                    <div class="tab-pane active" id="home1" role="tabpanel">

                                                                        <!-- Tab panes -->
                                                                        <form method="post" id="formProveedor" name="formProveedor">
                                                                            <input type="hidden" id="idProveedor" name="idProveedor" value="">
                                                                            <div class="d-flex">

                                                                                <div class="flex-grow-1 ms-2">

                                                                                    <input type="hidden" id="idUsuario" name="idUsuario" value="">
                                                                                    <div class="modal-body">
                                                                                        <!--GRUPO 1-->
                                                                                        <div class="form-group">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-4">
                                                                                                    <div class="formulario__grupo" id="grupo__nombre">
                                                                                                        <label for="nombre">Nombre <span class="text-danger">*</span></label>

                                                                                                        <div class="formulario__grupo-input">
                                                                                                            <input type="text" class="form-border" name="nombre" id="nombre" placeholder="Escriba el nombre">
                                                                                                        </div>

                                                                                                    </div><!-- Fin: nombre -->
                                                                                                </div>

                                                                                                <div class="col-sm-4">
                                                                                                    <div class="formulario__grupo" id="grupo__apellido">
                                                                                                        <label for="nombre">Nombre impreso <span class="text-danger">*</span></label>

                                                                                                        <div class="formulario__grupo-input">
                                                                                                            <input type="text" class="form-border" name="nprint" id="nprint" placeholder="Escriba el nombre impreso">
                                                                                                        </div>
                                                                                                    </div><!-- Fin: apellido -->
                                                                                                </div>

                                                                                                <div class="col-sm-4">
                                                                                                    <div class="formulario__grupo" id="grupo__nombre">
                                                                                                        <label for="nombre">Ruc</label>

                                                                                                        <div class="formulario__grupo-input">
                                                                                                            <input type="text" class="form-border" name="ruc" id="ruc" placeholder="Ingrese el ruc">
                                                                                                        </div>

                                                                                                    </div><!-- Fin: telefono -->
                                                                                                </div>
                                                                                            </div>
                                                                                        </div><!-- Fin: grupo1 -->
                                                                                        <br>

                                                                                        <!--GRUPO 2-->
                                                                                        <div class="form-group">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-4">
                                                                                                    <div class="formulario__grupo" id="grupo__nombre">
                                                                                                        <label for="nombre">Persona de contacto <span class="text-danger">*</span></label>

                                                                                                        <div class="formulario__grupo-input">
                                                                                                            <input type="text" class="form-border" name="ncontacto" id="ncontacto" placeholder="Escriba el nombre del contacto">
                                                                                                        </div>

                                                                                                    </div><!-- Fin: nombre -->
                                                                                                </div>

                                                                                                <div class="col-sm-4">
                                                                                                    <div class="formulario__grupo" id="grupo__apellido">
                                                                                                        <div class="formulario__grupo" id="grupo__apellido">
                                                                                                            <label for="nombre">Pais <span class="text-danger">*</span></label>
                                                                                                            <select class="form-select mb-3" id="comboxpais" name="comboxpais">

                                                                                                            </select>
                                                                                                        </div><!-- Fin: password-->

                                                                                                    </div><!-- Fin: apellido -->
                                                                                                </div>
                                                                                                <div class="col-sm-4">
                                                                                                    <div class="formulario__grupo" id="grupo__apellido">
                                                                                                        <div class="formulario__grupo" id="grupo__apellido">
                                                                                                            <label for="nombre">Forma de pago <span class="text-danger">*</span></label>
                                                                                                            <select class="form-select mb-3" id="comboxpago" name="comboxpago">

                                                                                                            </select>
                                                                                                        </div><!-- Fin: password-->

                                                                                                    </div><!-- Fin: apellido -->
                                                                                                </div>

                                                                                            </div>
                                                                                        </div><!-- Fin: grupo1 -->
                                                                                        <br>

                                                                                        <!--GRUPO 3-->
                                                                                        <div class="form-group">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-4">
                                                                                                    <div class="formulario__grupo" id="grupo__nombre">
                                                                                                        <label for="nombre">Estado <span class="text-danger">*</span></label>

                                                                                                        <select class="form-select mb-3" id="lStatus" name="lStatus">
                                                                                                            <option value="1">Activo</option>
                                                                                                            <option value="2">Inactivo</option>
                                                                                                        </select>

                                                                                                    </div><!-- Fin: username -->
                                                                                                </div>

                                                                                            </div>
                                                                                        </div><!-- Fin: grupo4 -->


                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" id="proveedor" class="btn btn-primary"><span id="btnText">Guardar</span></button>
                                                                            </div>
                                                                        </form>

                                                                    </div>

                                                                    <!-- AQUI TERMINA DATOS GENERALES-->

                                                                    <div class="tab-pane" id="profile1" role="tabpanel">
                                                                        <form method="post" id="formBanco">
                                                                            <input type="hidden" id="idBanco" name="idBanco" value="0">
                                                                            <div class="d-flex">

                                                                                <div class="flex-grow-1 ms-2">
                                                                                    <!--GRUPO 1-->
                                                                                    <div class="form-group">
                                                                                        <div class="row">

                                                                                            <br>
                                                                                            <div class="col-sm-4">
                                                                                                <div class="formulario__grupo" id="grupo__apellido">
                                                                                                    <div class="formulario__grupo" id="grupo__apellido">
                                                                                                        <label for="nombre">Banco <span class="text-danger">*</span></label>
                                                                                                        <select class="form-select mb-3" id="comboxbanco">

                                                                                                        </select>
                                                                                                    </div><!-- Fin: password-->

                                                                                                </div><!-- Fin: apellido -->
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <div class="formulario__grupo" id="grupo__nombre">
                                                                                                    <label for="nombre"># Consecutivo <span class="text-danger">*</span></label>

                                                                                                    <div class="formulario__grupo-input"><!-- disabled, readonly -->
                                                                                                        <input type="number" class="form-border" name="consecutivo" id="consecutivo" placeholder="numero consecutivo" disabled>
                                                                                                    </div>


                                                                                                </div><!-- Fin: nombre -->
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <div class="formulario__grupo" id="grupo__apellido">
                                                                                                    <div class="formulario__grupo" id="grupo__apellido">
                                                                                                        <label for="nombre">Moneda <span class="text-danger">*</span></label>
                                                                                                        <select class="form-select mb-3" id="comboxMoneda">

                                                                                                        </select>
                                                                                                    </div><!-- Fin: password-->

                                                                                                </div><!-- Fin: apellido -->
                                                                                            </div>

                                                                                        </div>
                                                                                    </div><!-- Fin: grupo1 -->

                                                                                    <!--GRUPO 2-->
                                                                                    <div class="form-group">
                                                                                        <div class="row">

                                                                                            <div class="col-sm-4">
                                                                                                <div class="formulario__grupo" id="grupo__nombre">
                                                                                                    <label for="nombre"># Cuenta <span class="text-danger">*</span></label>

                                                                                                    <div class="formulario__grupo-input">
                                                                                                        <input type="text" class="form-border" id="ncuenta" placeholder="Escriba # cuenta">
                                                                                                    </div>

                                                                                                </div><!-- Fin: nombre -->
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <div class="formulario__grupo" id="grupo__nombre">
                                                                                                    <label for="nombre">SWIFT <span class="text-danger">*</span></label>

                                                                                                    <div class="formulario__grupo-input">
                                                                                                        <input type="text" class="form-border" id="swift" placeholder="Escriba swift">
                                                                                                    </div>

                                                                                                </div><!-- Fin: nombre -->
                                                                                            </div>

                                                                                        </div>
                                                                                    </div><!-- Fin: grupo1 -->
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-primary" onclick="obtenerBanco()"><span id="btnText">Guardar</span></button>
                                                                            </div>
                                                                        </form>
                                                                    </div>


                                                                    <!--TAB #3-->
                                                                    <div class="tab-pane" id="messages1" role="tabpanel">
                                                                        <form method="post" id="formContacto">
                                                                            <input type="hidden" id="idContactoProv" name="idContactoProv" value="0">

                                                                            <div class="d-flex">

                                                                                <div class="flex-grow-1 ms-2">
                                                                                    <div class="row">
                                                                                        <div class="col-xxl-6">
                                                                                            <div class="form-group">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <label for="movil">Móvil <span class="text-danger">* </span></label>
                                                                                                        <input type="number" class="form-border" name="movil" id="movil" placeholder="Digite el celular" autocomplete="off">
                                                                                                    </div><!--Nombre-->

                                                                                                    <div class="col-sm-4">
                                                                                                        <label for="telefono">Teléfono</label>
                                                                                                        <input type="number" class="form-border" name="telefono" id="telefono" placeholder="Digite el teléfono" autocomplete="off">
                                                                                                    </div><!--Ruc-->

                                                                                                    <div class="col-sm-2">
                                                                                                        <label for="extension">Extensión </label>
                                                                                                        <input type="number" class="form-border" name="extension" id="extension" placeholder="Digite la extensión" autocomplete="off">
                                                                                                    </div><!--Ruc-->
                                                                                                </div>
                                                                                            </div>
                                                                                            <!--GRUPO 1-->
                                                                                            <br>
                                                                                            <div class="form-group">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <label for="correo">Correo <span class="text-danger">*</span></label>
                                                                                                        <input type="email" class="form-border" name="correo" id="correo" placeholder="Escriba el correo" autocomplete="off">
                                                                                                    </div><!--Nombre-->

                                                                                                    <div class="col-sm-6">
                                                                                                        <label for="direccion">Dirección</label>
                                                                                                        <textarea name="direccion" class="form-border" id="direccion" placeholder="Escriba la dirección" cols="80"></textarea>
                                                                                                    </div><!--Ruc-->

                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                        <!--end col-->
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-primary" onclick="obtenerContacto()"><span id="btnText">Guardar</span></button>
                                                                            </div>
                                                                        </form>
                                                                    </div>

                                                                </div>



                                                            </div><!-- end card-body -->
                                                        </div><!-- end card -->
                                                    </div>
                                                    <!--end col-->


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card">

                                <div class="card-body">
                                    <!-- Tabla de Tipo de usuario -->
                                    <table id="table-proveedor" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Banco</th>
                                                <th>Consecutivo</th>
                                                <th>Moneda</th>
                                                <th>Numero cuenta</th>
                                                <th>Codigo swift</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <?php MainFooter($data); ?>
        </div>

    </div>

    <!-- JAVASCRIPT -->
    <?php MainJs($data); ?>
</body>

</html>