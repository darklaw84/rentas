<?php

session_start();
include_once './controllers/UsuariosController.php';
if (!isset($_SESSION['idUsr'])) {

    echo "<script>window.setTimeout(function() { window.location = 'login.php' }, 10);</script>";
} else {
    if ($_SESSION['idUsr'] == "") {
        echo "<script>window.setTimeout(function() { window.location = 'login.php' }, 10);</script>";
    }
}


$permisos = $_SESSION['permisos'];

$usuarios = false;
$perfiles = false;
$mispropiedades=false;
$misrentasprop=false;
$misrentasinq=false;
$pagos=false;


foreach ($permisos as $per) {
    if ($per['modulo'] == "Usuarios") {
        if ($per['accion'] == "Consultar") {
            $usuarios = true;
        }
    }
    if ($per['modulo'] == "Perfiles") {
        if ($per['accion'] == "Consultar") {
            $perfiles = true;
        }
    }
    if ($per['modulo'] == "Mis Propiedades") {
        if ($per['accion'] == "Consultar") {
            $mispropiedades = true;
        }
    }
    if ($per['modulo'] == "Rentas Prop") {
        if ($per['accion'] == "Consultar") {
            $misrentasprop = true;
        }
    }
    if ($per['modulo'] == "Rentas Inq") {
        if ($per['accion'] == "Consultar") {
            $misrentasinq = true;
        }
    }
    if ($per['modulo'] == "Pagos") {
        if ($per['accion'] == "Consultar") {
            $pagos = true;
        }
    }
}



$p = "";
if (isset($_GET['p'])) {
    $p = $_GET['p'];
}



?>

<!doctype html>
<html lang="en">

<head>
    <link rel="icon" href="./imagenes/icono.jpg" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Rentas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">


    <link href="./main.87c0748b313a1dda75f5.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./assets/scripts/main.87c0748b313a1dda75f5.js"></script>
    <script src="https://cdn.tiny.cloud/1/fr0y1fvm30dkoefvw13l4lz9r1imnesldqfbt3g66bm1ug59/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script src="./js/dataTables.js"></script>

    <script src="./js/usuarios_1.js"></script>
    <script src="./js/perfiles.js"></script>
    <script src="./js/propiedades_1.js"></script>
    <script src="./js/contratos.js"></script>


</head>

<body>

    <div id="modalMensaje" class="modal fade mensajeError" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        <!--Header START-->

        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class=""><img src="./imagenes/icono.jpg" style="height: 30px"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>

                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">

                <div class="app-header-right">
                    <div class="header-dots">



                        <div class="dropdown">
                            <button type="button" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false" class="p-0 btn btn-link dd-chart-btn">
                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <span class="icon-wrapper-bg bg-success"></span>
                                    <i class="pe-7s-user bg"></i>
                                </span>
                            </button>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                                <div class="app-sidebar__inner">
                                    <ul class="vertical-nav-menu">

                                        <li>
                                            <a href="logout.php">
                                                <i class="metismenu-icon pe-7s-right-arrow">
                                                </i>Log out
                                            </a>
                                        </li>
                                        <li>
                                            <a href="index.php?p=cambiarpass">
                                                <i class="metismenu-icon pe-7s-key">
                                                </i>Cambiar Contraseña
                                            </a>
                                        </li>

                                    </ul>
                                </div>


                            </div>
                        </div>
                        <div class="header-btn-lg pr-0">

                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">

                                            <div class="widget-content-left">
                                                <div class="widget-heading"><?php
                                                                            if (isset($_SESSION['nombreUsr'])) {
                                                                                echo $_SESSION['nombreUsr'];
                                                                            }

                                                                            ?>
                                                </div>
                                                <div class="widget-subheading opacity-8 align-items-center">



                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
        <!--Header END-->

        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">Menu</li>


                            <?php if ($usuarios) { ?>
                                <li>
                                    <a href="index.php?p=usuarios">
                                        <i class="lnr-user metismenu-icon">
                                        </i>Usuarios 
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($usuarios) { ?>
                                <li>
                                    <a href="index.php?p=inquilinos">
                                        <i class="lnr-user metismenu-icon">
                                        </i>Inquilinos 
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($perfiles) { ?>
                                <li>
                                    <a href="index.php?p=perfiles">
                                        <i class="pe-7s-users metismenu-icon">
                                        </i>Perfiles
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($mispropiedades) { ?>
                                <li>
                                    <a href="index.php?p=mispropiedades">
                                        <i class="pe-7s-home metismenu-icon">
                                        </i>Mis Propiedades
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($misrentasprop) { ?>
                                <li>
                                    <a href="index.php?p=misrentas">
                                        <i class="pe-7s-cash metismenu-icon">
                                        </i>Mis Rentas
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($pagos) { ?>
                                <li>
                                    <a href="index.php?p=pagos">
                                        <i class="pe-7s-tools metismenu-icon">
                                        </i>Pagos
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (false) { ?>
                                <li>
                                    <a href="index.php?p=misrentasinq">
                                        <i class="pe-7s-folder metismenu-icon">
                                        </i>Mis Rentas Inq
                                    </a>
                                </li>
                            <?php } ?>









                        </ul>
                    </div>
                </div>
            </div>
          <!--  <button class="btn btn-primary" id="btnPruebaCorreo">PruebaCorreo</button> -->

            <!-- aqui va la iclusion de paginas -->
            <?php


            if ($p == 'usuarios') {
                include_once("usuarios.php");
            } else if ($p == 'inquilinos') {
                include_once("usuarios.php");
            } else if ($p == 'cambiarpass') {
                include_once("cambiarpass.php");
            } else if ($p == 'perfiles') {
                include_once("perfiles.php");
            } else if ($p == 'mispropiedades') {
                include_once("mispropiedades.php");
            } else if ($p == 'crearContrato') {
                include_once("crearContrato.php");
            } else if ($p == 'consultaPropiedad') {
                include_once("consultaPropiedad.php");
            } else if ($p == 'misrentas') {
                include_once("misrentas.php");
            } else if ($p == 'misrentasinq') {
                include_once("rentasInquilino.php");
            } else if ($p == 'pagos') {
                include_once("pagos.php");
            } else if ($p == 'mostrarContrato') {
                include_once("mostrarContrato.php");
            }


            ?>



            <!--  hasta aqui -----------------  -->
        </div>
    </div>


    <?php include_once 'modals.php' ?>



    <?php
    if (isset($mensajeEnviar)) {

        if ($mensajeEnviar != "") {
            echo "<script>$(document).ready(function(){
        $('#modalMensaje').find('.modal-body').text('" . $mensajeEnviar . "').end().modal('show');
     });</script>";
        }
    }
    ?>

</body>


</html>