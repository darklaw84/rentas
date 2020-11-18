<?php

include_once './controllers/PropiedadesController.php';
include_once './controllers/UsuariosController.php';
if (!isset($_SESSION['nombreUsr'])) {
    echo "<script>window.setTimeout(function() { window.location = 'login.php' }, 10);</script>";
}
$controller = new PropiedadesController();

$uController = new UsuariosController();



$permisos = $_SESSION['permisos'];

$agregar = false;
$editar = false;
$consultar = false;
$activar = false;

foreach ($permisos as $per) {
    if ($per['modulo'] == "Mis Propiedades") {
        if ($per['accion'] == "Agregar") {
            $agregar = true;
        }
        if ($per['accion'] == "Editar") {
            $editar = true;
        }
        if ($per['accion'] == "Consultar") {
            $consultar = true;
        }
        if ($per['accion'] == "Activar") {
            $activar = true;
        }
    }
}

if (!$consultar) {
    echo "<script>window.setTimeout(function() { window.location = 'index.php' }, 10);</script>";
}

$idPropiedad = "";
if (isset($_GET['idPropiedad'])) {
    $idPropiedad = $_GET['idPropiedad'];
}

if (isset($_POST['idPropiedad'])) {
    $idPropiedad = $_POST['idPropiedad'];
}

$renta = "";
if (isset($_POST['renta'])) {
    $renta = $_POST['renta'];
}

$diaPago = "";
if (isset($_POST['diaPago'])) {
    $diaPago = $_POST['diaPago'];
}

$mantenimiento = "";
if (isset($_POST['mantenimiento'])) {
    $mantenimiento = $_POST['mantenimiento'];
}

if (isset($_GET['idPropiedad'])) {
    $idPropiedad = $_GET['idPropiedad'];
}


$idInquilino = "";
if (isset($_POST['idInquilino'])) {
    $idInquilino = $_POST['idInquilino'];
}

$fechaIni = "";
if (isset($_POST['fechaIni'])) {
    $fechaIni = $_POST['fechaIni'];
}

$fechaFin = "";
if (isset($_POST['fechaFin'])) {
    $fechaFin = $_POST['fechaFin'];
}

$entro = "";
if (isset($_POST['entro'])) {
    $entro = $_POST['entro'];
}


if ($entro == "1") {


    $domicilioArrendatario = $_POST['domicilioArrendatario'];
    $dominquilino = $_POST['dominquilino'];
    $numescritura = $_POST['numescritura'];
    $fechaescritura = $_POST['fechaescritura'];
    $numNotaria = $_POST['numNotaria'];
    $foliomercantil = $_POST['foliomercantil'];
    $licenciadoinq = $_POST['licenciadoinq'];
    $nombreaval = $_POST['nombreaval'];
    $rfcaval = $_POST['rfcaval'];
    $domicilioaval = $_POST['domicilioaval'];
    $domicilioInmueble = $_POST['domicilioInmueble'];
    $tipoContrato = $_POST['tipoContrato'];
    $idArrendatario = $_POST['idArrendatario'];




    $fIni = strtotime($fechaIni);
    $fFin = strtotime($fechaFin);
    $datediff = $fFin - $fIni;

    $dias = round($datediff / (60 * 60 * 24));

    if ($dias >= 29) {



        if ($diaPago > 0 && $diaPago < 31) {




            $controller->agregarContrato(
                $idArrendatario,
                $idPropiedad,
                $fechaIni,
                $fechaFin,
                $idInquilino,
                $renta,
                $mantenimiento,
                $diaPago,
                $nombreaval,
                $domicilioArrendatario,
                $numescritura,
                $fechaescritura,
                $licenciadoinq,
                $numNotaria,
                $foliomercantil,
                $domicilioArrendatario,
                $rfcaval,
                $domicilioInmueble,
                $tipoContrato,
                $domicilioaval
            )->valor;

            echo "<script>window.setTimeout(function() { window.location = 'index.php?p=consultaPropiedad&idPropiedad=" . $idPropiedad . "' }, 10);</script>";
        } else {
            $mensajeEnviar = "El dia de pago debe ser el numero del día del mes entre 1 y 30";
        }
    } else {
        $mensajeEnviar = "Las fechas no pueden ser menores a un mes de diferencia";
    }
}






$respuesta = $controller->obtenerPropiedad($idPropiedad);
$propiedad = $respuesta->registros[0];


if ($renta == "") {
    $renta = $propiedad['renta'];
}

$inquilinos = $uController->obtenerInquilinos()->registros;



$usuarios = $uController->obtenerUsuarios("usuarios")->registros;




?>




<div class="app-main__outer">
    <div class="app-main__inner">


        <!-- aqui va el contenido de la página -->
        <div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h3>Nuevo Contrato</h3>
                    <form id="adminForm" class="col-md-10 mx-auto" method="post" action="index.php?p=crearContrato">
                        <input type="hidden" name="entro" value="1">
                        <input type="hidden" name="idPropiedad" value="<?php echo $idPropiedad; ?>">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nombre">Propiedad</label>
                                    <div>
                                        <input type="text" disabled class="form-control" value="<?php if (isset($propiedad['nombre'])) {
                                                                                                    echo strtoupper($propiedad['nombre']);
                                                                                                } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="nombre">Descripción</label>
                                    <div>
                                        <input type="text" disabled class="form-control" value="<?php if (isset($propiedad['descripcion'])) {
                                                                                                    echo strtoupper($propiedad['descripcion']);
                                                                                                } ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 mb-5">
                                <div class="col-8 col-md-10">
                                    <label for="nombre">Arrendador</label>
                                    <div>
                                        <select required class=" form-control " name="idArrendatario" id="idArrendatario">

                                            <?php
                                            if (isset($usuarios)) {
                                                foreach ($usuarios as $uni) {
                                                    if (isset($idArrendatario)) {
                                                        if ($idArrendatario == $uni['idUsuario']) {
                                                            $verselected = "selected";
                                                        } else {
                                                            $verselected = "";
                                                        }
                                                    } else {
                                                        $verselected = "";
                                                    }
                                                    echo '<option value="' . $uni['idUsuario'] . '" ' . $verselected
                                                        . ' >' .
                                                        strtoupper($uni['nombre'] . " " . $uni['apellidos']) . '</option>';
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <label for="idLineaIn">&nbsp;</label>
                                    <div>
                                        <button class="btn btn-primary" id="btnAgregarArrendatario">Agregar Arrendador</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="nombre">Domicilio Notificaciones Arrendador</label>
                                    <div>
                                        <input type="text" required class="form-control" id="domicilioArrendatario" name="domicilioArrendatario" value="<?php if (isset($domicilioArrendatario)) {
                                                                                                                                                            echo strtoupper($domicilioArrendatario);
                                                                                                                                                        } ?>" />
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title">Datos Contrato</h5>
                            <div class="row mt-3">
                                <div class="col-6 col-md-4 ">
                                    <label for="nombre">Fecha Inicio</label>
                                    <div>
                                        <input type="date" required class="form-control" id="fechaIni" name="fechaIni" value="<?php if (isset($fechaIni)) {
                                                                                                                                    echo strtoupper($fechaIni);
                                                                                                                                } ?>" />
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="nombre">Fecha Fin</label>
                                    <div>
                                        <input type="date" required class="form-control" id="fechaFin" name="fechaFin" value="<?php if (isset($fechaFin)) {
                                                                                                                                    echo strtoupper($fechaFin);
                                                                                                                                } ?>" />
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="nombre">Tipo</label>
                                    <div>
                                        <select class=" form-control " name="tipoContrato" id="tipoContrato">

                                            <option value="NPF">Normal Persona Física</option>
                                            <option value="NPM">Normal Persona Moral</option>
                                            <option value="AH">Arbitral Habitacional</option>
                                            <option value="AC">Arbitral Comercial</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-3 mb-3">
                                <div class="col-6 col-md-4">
                                    <label for="nombre">Renta</label>
                                    <div>
                                        <input type="number" required class="form-control" id="renta" name="renta" value="<?php if (isset($renta)) {
                                                                                                                                echo strtoupper($renta);
                                                                                                                            } ?>" />
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="nombre">Mantenimiento</label>
                                    <div>
                                        <input type="number" required class="form-control" id="mantenimiento" name="mantenimiento" value="<?php if (isset($mantenimiento)) {
                                                                                                                                                echo strtoupper($mantenimiento);
                                                                                                                                            } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="nombre">Día de Pago</label>
                                    <div>
                                        <input type="number" required class="form-control" id="diaPago" name="diaPago" value="<?php if (isset($diaPago)) {
                                                                                                                                    echo strtoupper($diaPago);
                                                                                                                                } ?>" />
                                    </div>
                                </div>
                            </div>

                            <h5 class="card-title">Datos Inquilino</h5>
                            <div class="row mb-3">
                                <div class="col-8 col-md-10">
                                    <label for="idLineaIn">Inquilino</label>
                                    <div>
                                        <select required class=" form-control selectPerfil" name="idInquilino" id="idInquilino">

                                            <?php
                                            if (isset($inquilinos)) {
                                                foreach ($inquilinos as $uni) {
                                                    if (isset($idInquilino)) {
                                                        if ($idInquilino == $uni['idUsuario']) {
                                                            $verselected = "selected";
                                                        } else {
                                                            $verselected = "";
                                                        }
                                                    } else {
                                                        $verselected = "";
                                                    }
                                                    echo '<option value="' . $uni['idUsuario'] . '" ' . $verselected
                                                        . ' >' .
                                                        strtoupper($uni['nombre'] . " " . $uni['apellidos']) . '</option>';
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <label for="idLineaIn">&nbsp;</label>
                                    <div>
                                        <button class="btn btn-primary" id="btnAgregarInquilino">Agregar Inquilino</button>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-10">
                                    <label for="nombre">Domicilio Notificaciones</label>
                                    <div>
                                        <input type="text" required class="form-control" id="dominquilino" name="dominquilino" value="<?php if (isset($dominquilino)) {
                                                                                                                                            echo strtoupper($dominquilino);
                                                                                                                                        } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="nombre">&nbsp;</label>
                                    <div>
                                        <button type="button" class="btn btn-primary" id="btnLLenarDireccion" onclick="document.getElementById('dominquilino').value='<?php if (isset($propiedad['direccion'])) {
                                                                                                                                                                            echo strtoupper($propiedad['direccion']);
                                                                                                                                                                        } ?>'">La misma</button>
                                    </div>
                                </div>
                            </div>


                            <h5 class="card-title">Datos Aval</h5>

                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <label for="nombre">Nombre</label>
                                    <div>
                                        <input type="text" class="form-control" id="nombreaval" name="nombreaval" value="<?php if (isset($nombreaval)) {
                                                                                                                                echo strtoupper($nombreaval);
                                                                                                                            } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="nombre">RFC</label>
                                    <div>
                                        <input type="text" class="form-control" id="rfcaval" name="rfcaval" value="<?php if (isset($rfcaval)) {
                                                                                                                        echo strtoupper($rfcaval);
                                                                                                                    } ?>" />
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3 mt-3">
                                <div class="col-md-12">
                                    <label for="nombre">Domicilio</label>
                                    <div>
                                        <input type="text" class="form-control" id="domicilioaval" name="domicilioaval" value="<?php if (isset($domicilioaval)) {
                                                                                                                                    echo strtoupper($domicilioaval);
                                                                                                                                } ?>" />
                                    </div>
                                </div>


                            </div>
                            <h5 class="card-title">Datos Inmueble Aval</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="nombre">Domicilio Inmueble</label>
                                    <div>
                                        <input type="text" class="form-control" id="domicilioInmueble" name="domicilioInmueble" value="<?php if (isset($domicilioInmueble)) {
                                                                                                                                            echo strtoupper($domicilioInmueble);
                                                                                                                                        } ?>" />
                                    </div>
                                </div>


                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-6 col-md-4">
                                    <label for="nombre"># Escritura</label>
                                    <div>
                                        <input type="text" class="form-control" id="numescritura" name="numescritura" value="<?php if (isset($numescritura)) {
                                                                                                                                    echo strtoupper($numescritura);
                                                                                                                                } ?>" />
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="nombre">Fecha Escritura</label>
                                    <div>
                                        <input type="date" class="form-control" id="fechaescritura" name="fechaescritura" value="<?php if (isset($fechaescritura)) {
                                                                                                                                        echo strtoupper($fechaescritura);
                                                                                                                                    } ?>" />
                                    </div>
                                </div>
                                <div class=" col-md-4">
                                    <label for="nombre"># Notaría</label>
                                    <div>
                                        <input type="number" class="form-control" id="numNotaria" name="numNotaria" value="<?php if (isset($numNotaria)) {
                                                                                                                                echo strtoupper($numNotaria);
                                                                                                                            } ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class=" col-md-4">
                                    <label for="nombre">Folio Mercantil</label>
                                    <div>
                                        <input type="text" class="form-control" id="foliomercantil" name="foliomercantil" value="<?php if (isset($foliomercantil)) {
                                                                                                                                        echo strtoupper($foliomercantil);
                                                                                                                                    } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label for="nombre">Licenciado</label>
                                    <div>
                                        <input type="text" class="form-control" id="licenciadoinq" name="licenciadoinq" value="<?php if (isset($licenciadoinq)) {
                                                                                                                                    echo strtoupper($licenciadoinq);
                                                                                                                                } ?>" />
                                    </div>
                                </div>

                            </div>
                        </div>





                        <div class="form-group">
                            <input type="hidden" name="entro" value="1" />
                            <button type="submit" class="btn btn-primary" name="signup" value="Sign up">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- hasta aqui llega-->

    </div>
    <?php include_once('footer.php') ?>
</div>