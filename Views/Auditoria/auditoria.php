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
                                        <li class="breadcrumb-item active">Auditoria</li>
                                    </ol>
                                </div>

                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="card">

                                <div class="card-body">
                                    <!-- Tabla de Tipo de usuario -->
                                    <table id="table-auditoria" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>cod_sesion</th>
                                                <th>cod_usuario</th>
                                                <th>Fecha_Inicio_Sesion</th>
                                                <th>Fecha_Fin_Sesion</th>
                                                <th>IPConexion</th>
                                                <th>Navegador</th>
                                                <!--<th>Options</th> = Boton para bloquear ip o crear una lista blanca-->
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