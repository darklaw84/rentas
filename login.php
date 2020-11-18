<?php
session_start();
include_once './controllers/LoginController.php';
include_once './controllers/PerfilesController.php';

$loginCont = new LoginController();
$perCont = new PerfilesController();

if (isset($_POST['entro'])) {

    $entro = $_POST['entro'];

    if ($entro == "1") {


        $correo = $_POST['correo'];

        $password = $_POST['password'];



        if (

            trim($correo) == "" ||  trim($password) == ""
        ) {
            $mensajeEnviar = "Todos los campos son requeridos, por favor verifique";
        } else {



            $res = $loginCont->login($correo, md5($password));
            if ($res->exito) {
                if ($res->registros[0]['activo'] == "1") {
                    $_SESSION['idUsr'] = $res->registros[0]['idUsuario'];
                    $_SESSION['nombreUsr'] = $res->registros[0]['nombre'];
                    $_SESSION['correoUsr'] = $res->registros[0]['correo'];
                    $_SESSION['idPerfil'] = $res->registros[0]['idPerfil'];

                    $permisos = $perCont->obtenerPermisosPerfil($_SESSION['idPerfil']);
                    $_SESSION['permisos']=$permisos->registros;
                    if($_SESSION['idPerfil']==6)
                    {
                        echo "<script>window.setTimeout(function() { window.location = 'index.php?p=misrentasinq' }, 10);</script>";
                    }
                    else
                    {
                    echo "<script>window.setTimeout(function() { window.location = 'index.php?p=mispropiedades' }, 10);</script>";
                    }
                } else {
                    $mensajeEnviar = "La cuenta no esta activa, contacte al administrador";
                }
            } else {
                $mensajeEnviar = $res->mensaje;
            }
        }
    }
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
    <title>Rogeri </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <link href="./main.87c0748b313a1dda75f5.css" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">

</head>

<body>
    <div id="modalMensaje" class="modal fade mensajeError" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="./imagenes/icono.jpg" style="height: 30px">
                    <h5 class="modal-title" style="padding-left: 20px" id="exampleModalLongTitle">Mensaje</h5>
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
    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="d-none d-lg-block col-lg-4">
                        
                    </div>
                    <div id="wrapper_1" class="h-100 d-flex bg-white justify-content-center align-items-center col-md-8 col-lg-5">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                            <div class=""><a href="index.php"><img src="./imagenes/icono.jpg" style="height: 30px"></a></div>
                            <h3 class="mb-0">
                                <span class="d-block"><strong>Bienvenido de vuelta!</strong> </span></h3>
                            <h7 class="mb-0"> <span>Estamos contentos de verte por aquí, ingresa tus datos.</span></h7>

                            <div class="divider row"></div>
                            <div>
                                <form class="" method="POST" action="login.php">
                                    <input type="hidden" name="entro" value="1">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="correo" class="">Correo<a class="rojo">*</a></label>
                                                <input name="correo" id="correo" placeholder="Usuario" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="examplePassword" class="">Contraseña<a class="rojo">*</a></label>
                                                <input name="password" id="examplePassword" placeholder="Contraseña" type="password" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="position-relative form-check"><input name="check" id="exampleCheck" type="checkbox" class="form-check-input"><label for="exampleCheck" class="form-check-label">Keep me logged in</label></div>-->
                                    <div class="divider row"></div>
                                    <div class="d-flex align-items-center">
                                        <button class="ladda-button mb-2 mr-2 btn btn-primary btn-lg" data-style="expand-right">
                                            <span class="ladda-label">Ingresar
                                            </span>
                                            <span class="ladda-spinner">
                                            </span>
                                        </button>
                                       
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="wrapper_2" class="h-100 d-flex bg-white justify-content-left align-items-center col-md-4 col-lg-3">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="./assets/scripts/main.87c0748b313a1dda75f5.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/metismenu"></script>


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