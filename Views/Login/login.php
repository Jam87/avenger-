<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>

    <meta charset="utf-8" />
    <title>Jipsafety - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="public/images/favicon.png">


    <!-- Bootstrap Css -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="public/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="public/css/app.min.css" rel="stylesheet" type="text/css" />


</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="index.html" class="d-inline-block auth-logo">
                                    <img src="https://jip.grupopaniagua.com/public/images/logo-login.svg" alt="" height="70">
                                </a>
                            </div>
                            <!--<p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p>-->
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Bienvenido de nuevo !</h5>
                                    <p class="text-muted">Acceder a Jipsafety</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form method="post" class="needs-validation" name="formLogin" id="formLogin" novalidate>

                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Correo Electronico <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="useremail" name="useremail" placeholder="Ingrese su Correo Electronico" required>
                                            <div class="invalid-feedback">
                                                Ingrese su Correo Electronico
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Contraseña</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5" name="userpassword" placeholder="Ingrese su contraseña" id="password-input">
                                            </div>
                                        </div>


                                        <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                            <h5 class="fs-13">La contraseña debe contener:</h5>
                                            <p id="pass-length" class="invalid fs-12 mb-2">Mínimo <b>8 caracteres</b></p>
                                            <p id="pass-lower" class="invalid fs-12 mb-2"><b>1</b> letra <b>minúscula</b> (a-z)</p>
                                            <p id="pass-upper" class="invalid fs-12 mb-2"><b>1</b> letra <b>mayúscula</b> (A-Z)</p>
                                            <p id="pass-number" class="invalid fs-12 mb-0"><b>1</b> <b>número</b> (0-9)</p>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-actual w-100" type="submit">Iniciar sesión</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <!--<script src="public/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/lib/simplebar/simplebar.min.js"></script>
    <script src="public/lib/node-waves/waves.min.js"></script>
    <script src="public/lib/feather-icons/feather.min.js"></script>
    <script src="public/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="public/js/plugins.js"></script>-->

    <!-- particles js -->
    <!--<script src="public/lib/particles.js/particles.js"></script>-->
    <!-- particles app js -->
    <!--<script src="public/js/pages/particles.app.js"></script>-->
    <!-- validation init -->
    <!--<script src="public/js/pages/form-validation.init.js"></script>-->
    <!-- password create init -->
    <!--<script src="public/js/pages/passowrd-create.init.js"></script>-->
    <!-- particles js -->
    <script src="<?= base_url(); ?>public/lib/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="<?= base_url(); ?>public/js/pages/particles.app.js"></script>

    <?php MainJs($data); ?>
</body>

</html>