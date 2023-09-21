<?php
#Mando a llamar al modal
getModal('tipoUsuario', $data);
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
                                        <li class="breadcrumb-item active">tipo de usuario</li>
                                    </ol>
                                </div>

                            </div>
                        </div>

                        <!-- TIPO DE USUARIO -->
                        <div class="col-lg-6">
                            <div class="card">

                                <div class="card-body">
                                    <!-- Tabla de Tipo de usuario -->
                                    <table id="table-permisos" class="table table-bordered dt-responsive nowrap table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <!--<th>idPerfil</th>-->
                                                <th>Descripción</th>
                                                <th>Activo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!--2 PARTE-->
                        <div class="col-lg-6">

                            <div class="card card-gray shadow" style="display:none" id="card-modulos">

                                <div class="card-header">

                                    <h3 class="card-title"><i class="fas fa-laptop"></i> Módulos del Sistema</h3>

                                </div>

                                <div class="card-body" id="card-body-modulos">

                                    <div class="row m-2">

                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-outline-success waves-effect waves-light m-0 p-1" id="marcar_modulos">Marcar todo</button>
                                        </div>

                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-outline-danger waves-effect waves-light m-0 p-1" id="desmarcar_modulos">Desmarcar todo</button>
                                        </div>

                                    </div>
                                    <br>

                                    <!-- AQUI SE CARGAN TODOS LOS MODULOS DEL SISTEMA -->
                                    <div id="modulos" class="demo"></div>

                                    <div class="row m-2">

                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label for="exampleSelect1">Seleccione el modulo de inicio:<span class="text-danger">*</span></label>
                                                <select class="form-select mb-3" id="select_modulos" name="listLocal">

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row m-2">

                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-success btn-label waves-effect waves-light" id="asignar_modulos"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>Asignar</button>


                                        </div>

                                    </div>

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