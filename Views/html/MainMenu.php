<?php
require_once 'Controllers/Usuarios.php';
$MenuObj = json_decode(json_encode($_SESSION['usuario'][0]), false);
$MenuUsuario = Usuarios::obtenerMenuUsuario($MenuObj->cod_usuario);

//dep($_SESSION['usuario']);


#User data object
$UserObj = json_decode(json_encode($_SESSION['usuario'][0]), false);

#Menu User object
$MenuUser = json_decode(json_encode($_SESSION['menu']), false);

# Sub Menu User object
$SubMenuUser = $_SESSION['submenu_actual'];

//dep($SubMenuUser);



/**
 * TRAIGO DATOS EN FORMATO ARRAY
 * 1. Traigo el ID del usuario               = $_SESSION['usuario'][0]
 * 2. Traigo el MENU del que tiene permiso   = $_SESSION['menu']
 */

?>

<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?= base_url(); ?>public/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url(); ?>public/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?= base_url(); ?>public/images/logo-sm.svg" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url(); ?>public/images/logo-light-.svg" alt="" height="50">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <?php foreach ($MenuUser as $menu) : ?>

                    <!--<?php dep($menu); ?>-->
                    <li class="nav-item">

                        <?php if ($menu->vista == "dashboard") : ?>
                            <a class="nav-link" href="<?= base_url() ?><?= $menu->vista ?>" role="button" aria-expanded="false" aria-controls="sidebarApps">
                                <i class="ri-<?= $menu->icon_menu; ?>"></i> <span><?= $menu->modulo; ?></span>
                            </a>
                        <?php else : ?>
                            <a class="nav-link menu-link" href="#<?= $menu->identifier; ?>" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                                <i class="ri-<?= $menu->icon_menu; ?>"></i> <span><?= $menu->modulo; ?></span>
                            </a>

                        <?php endif; ?>


                        <!--SUBMENU-->
                        <?php if (empty($menu->vista)) : ?>

                            <?php $bubMenuUsuario = Usuarios::obtenerSubMenuUsuario($menu->id, $MenuObj->cod_usuario);
                            //dep($bubMenuUsuario);
                            ?>

                            <div class="collapse menu-dropdown" id="<?= $menu->identifier; ?>">
                                <ul class="nav nav-sm flex-column">
                                    <?php foreach ($SubMenuUser as $subMenu) : ?>
                                        <li class="nav-item">
                                            <a href="<?= base_url() ?><?= $subMenu->vista ?>" class="nav-link"><?= $subMenu->modulo; ?> </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>


                        <?php endif; ?>


                    </li>
                <?php endforeach; ?>


                <!--<li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <i class="ri-booklet-line"></i> <span data-key="t-landing">Catálogos Generales</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLanding">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?= base_url(); ?>banco" class="nav-link" data-key="t-one-page">Bancos</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url(); ?>contacto" class="nav-link" data-key="t-nft-landing">Contacto</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url(); ?>pago" class="nav-link" data-key="t-nft-landing">Forma de pago</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url(); ?>moneda" class="nav-link" data-key="t-nft-landing">Moneda</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url(); ?>pais" class="nav-link" data-key="t-nft-landing">Pais</a>
                            </li>
                        </ul>
                    </div>
                </li>-->
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>