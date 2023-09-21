<?php
#Mando a llamar al modal
getModal('bancos', $data);
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
                                        <li class="breadcrumb-item active">banco</li>
                                    </ol>
                                </div>

                            </div>
                        </div>


                        <div class="col-lg-12">


                            <div class="row">

                                <!--FORMULARIO PARA REGISTRO Y EDICION -->
                                <div class="col-md-4">

                                    <div class="card card-gray shadow">

                                        <div class="card-header">

                                            <h3 class="card-title"><i class="fas fa-edit"></i> Registro de Módulos</h3>

                                        </div>

                                        <div class="card-body">

                                            <form method="post" class="needs-validation-registro-modulo" novalidate id="frm_registro_modulo">
                                                <input type="hidden" id="idModulo" name="idModulo" value="">
                                                <div class="row">

                                                    <div class="col-md-12">

                                                        <div class="form-group mb-2">

                                                            <label for="iptModulo" class="m-0 p-0 col-sm-12 col-form-label-sm"><span class="small">Módulo</span><span class="text-danger">*</span></label>

                                                            <div class="input-group  m-0">
                                                                <input type="text" class="form-control form-control-sm" name="iptModulo" id="iptModulo" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" style="background-color:#0C0D07"><i class="bx bx-laptop" style="font-size:1rem; color:#ffffff"></i></span>
                                                                </div>
                                                                <div class="invalid-feedback">Debe ingresar el módulo</div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-2">
                                                            <label for="chkSubMenu" class="m-0 p-0 col-sm-12 col-form-label-sm"><span class="small">¿Tiene submenú?</span></label>
                                                            <div class="input-group m-0">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="chkSubMenu" id="chkSubMenu">
                                                                    <label class="custom-control-label" for="chkSubMenu"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group mb-2">
                                                            <div class="form-group mb-2">
                                                                <label for="iptIdentificador" class="m-0 p-0 col-sm-12 col-form-label-sm"><span class="small">Identificador Único</span></label>
                                                                <div class="input-group m-0">
                                                                    <input type="text" class="form-control form-control-sm" name="iptIdentificador" id="iptIdentificador" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">

                                                        <div class="form-group mb-2">

                                                            <label for="iptVistaModulo" class="m-0 p-0 col-sm-12 col-form-label-sm"><span class="small">Vista PHP</span></label>
                                                            <div class="input-group  m-0">
                                                                <input type="text" class="form-control form-control-sm" name="iptVistaModulo" id="iptVistaModulo">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" style="background-color:#0C0D07"><i class="bx bx-code-alt" style="font-size:1rem; color:#ffffff"></i></span>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-12">

                                                        <div class="form-group mb-2">

                                                            <label for="iptIconoModulo" class="m-0 p-0 col-sm-12 col-form-label-sm"><span class="small">Icono</span><span class="text-danger">*</span></label>
                                                            <div class="input-group  m-0">
                                                                <input type="text" placeholder="<i class='far fa-circle'></i>" name="iptIconoModulo" class="form-control form-control-sm" id="iptIconoModulo">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text bg-gray" id="spn_icono_modulo"><i class="far fa-circle fs-6 text-white"></i></span>
                                                                </div>
                                                                <div class="invalid-feedback">Debe ingresar el ícono del módulo</div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-12">

                                                        <div class="form-group m-0 mt-2">

                                                            <button type="button" class="btn btn-success w-100" id="btnRegistrarModulo">Guardar Módulo</button>

                                                        </div>

                                                    </div>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>
                                <!--/. col-md-3 -->

                                <!--ARBOL DE MODULOS PARA REORGANIZAR -->
                                <div class="col-md-4">

                                    <div class="card card-gray shadow">

                                        <div class="card-header">

                                            <h3 class="card-title"><i class="fas fa-edit"></i> Organizar Módulos</h3>

                                        </div>

                                        <div class="card-body">

                                            <div class="">

                                                <div>Modulos del Sistema</div>

                                                <div class="" id="arbolModulos"></div>

                                            </div>

                                            <hr>


                                            <div class="row">

                                                <div class="col-md-12">

                                                    <div class="text-center">

                                                        <button id="btnReordenarModulos" class="btn btn-success btn-sm" style="width: 100%;">Organizar Módulos</button>

                                                        <button id="btnReiniciar" class="btn btn-sm btn-warning mt-3 " style="width: 100%;">Estado Inicial</button>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <!--/. col-md-3 -->

                            </div>
                            <!--/.row -->
                            <div class="card">
                                <div class="card-header">

                                    <div class="card-body">
                                        <!-- Tabla de Tipo de usuario -->
                                        <table id="table-modulos" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Orden</th>
                                                    <th>Módulo</th>
                                                    <th>Módulo padre</th>
                                                    <th>Vista</th>
                                                    <th>icono</th>
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

        <script>
            document.getElementById('chkSubMenu').addEventListener('change', function() {
                var identificadorContainer = document.getElementById('identificadorContainer');
                var identificadorInput = document.getElementById('iptIdentificador');

                if (this.checked) {
                    var identificador = generateUniqueId();
                    identificadorInput.value = identificador;
                    identificadorContainer.style.display = 'block';
                } else {
                    identificadorInput.value = '';
                    identificadorContainer.style.display = 'none';
                }
            });

            function generateUniqueId() {
                var randomValue = Math.floor(Math.random() * 100);
                return "sub-menu-" + randomValue.toString().padStart(2, '0');
            }
        </script>

        <!-- JAVASCRIPT -->
        <?php MainJs($data); ?>
</body>

</html>