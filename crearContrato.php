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

$entro = "";
if (isset($_POST['entro'])) {
    $entro = $_POST['entro'];
}


$tipoContrato = "";
if (isset($_POST['tipoContrato'])) {
    $tipoContrato = $_POST['tipoContrato'];
}

$renta = "";
if (isset($_POST['renta'])) {
    $renta = $_POST['renta'];
}


if ($entro == "1") {

    $idArrendatario = $_POST['idArrendatario'];
    $domicilioArrendador = $_POST['domicilioArrendador'];
    $fechaFin = $_POST['fechaFin'];
    $fechaIni = $_POST['fechaIni'];
    $diaPago = $_POST['diaPago'];
    $renta = $_POST['renta'];
    $interesmoratorio = $_POST['interesmoratorio'];
    $incrementoanual = $_POST['incrementoanual'];
    $deposito = $_POST['deposito'];
    $usolocalidad = "";
    if (isset($_POST['usolocalidad'])) {
        $usolocalidad = $_POST['usolocalidad'];
    }
    $idInquilino = $_POST['idInquilino'];
    $dominquilino = $_POST['dominquilino'];
    $nombreaval = "";
    $domicilioaval = "";
    $domicilioInmuebleAval = "";
    if (isset($_POST['nombreaval'])) {
        $nombreaval = $_POST['nombreaval'];
        $domicilioaval = $_POST['domicilioaval'];
        $domicilioInmuebleAval = $_POST['domicilioInmuebleAval'];
    }
    $personas = "";
    if (isset($_POST['personas'])) {
        $personas = $_POST['personas'];
    }


    $valido = true;

    if (!is_numeric($deposito)) {
        $valido = false;
        $mensajeEnviar = "El depósito debe de ser númerico";
    }

    if (!is_numeric($interesmoratorio)) {
        $valido = false;
        $mensajeEnviar = "El interes moratorio debe de ser númerico";
    }

    if (!is_numeric($incrementoanual)) {
        $valido = false;
        $mensajeEnviar = "El incremento anual debe de ser númerico";
    }

    if (!is_numeric($renta)) {
        $valido = false;
        $mensajeEnviar = "La renta debe de ser númerico";
    }

    if (!is_numeric($diaPago)) {
        $valido = false;
        $mensajeEnviar = "El día de pago debe de ser númerico";
    }


    if ($valido) {

        $fIni = strtotime($fechaIni);
        $fFin = strtotime($fechaFin);
        $datediff = $fFin - $fIni;

        $dias = round($datediff / (60 * 60 * 24));

        if ($dias >= 29) {
            if ($diaPago > 0 && $diaPago < 31) {
                $controller->agregarContrato(
                    $idArrendatario,
                    $domicilioArrendador,
                    $fechaFin,
                    $fechaIni,
                    $diaPago,
                    $renta,
                    $interesmoratorio,
                    $incrementoanual,
                    $deposito,
                    $usolocalidad,
                    $idInquilino,
                    $dominquilino,
                    $nombreaval,
                    $domicilioaval,
                    $domicilioInmuebleAval,
                    $tipoContrato,
                    $personas,
                    $idPropiedad
                )->valor;

                echo "<script>window.setTimeout(function() { window.location = 'index.php?p=consultaPropiedad&idPropiedad=" . $idPropiedad . "' }, 10);</script>";
            } else {
                $mensajeEnviar = "El dia de pago debe ser el numero del día del mes entre 1 y 30";
            }
        } else {
            $mensajeEnviar = "Las fechas no pueden ser menores a un mes de diferencia";
        }
    }
}






$respuesta = $controller->obtenerPropiedad($idPropiedad);
$propiedad = $respuesta->registros[0];


$respuesta = $controller->obtenerContratosBase(true, "");
$bases = $respuesta->registros;


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
                                <div class="col-12">
                                    <label for="nombre">Tipo Contrato</label>
                                    <div>
                                        <select required class=" form-control " name="tipoContrato" id="tipoContrato">
                                            <option value="">Seleccione</option>
                                            <?php
                                            if (isset($bases)) {
                                                foreach ($bases as $uni) {
                                                    if (isset($tipoContrato)) {
                                                        if ($tipoContrato == $uni['idContratoBase']) {
                                                            $verselected = "selected";
                                                        } else {
                                                            $verselected = "";
                                                        }
                                                    } else {
                                                        $verselected = "";
                                                    }
                                                    echo '<option value="' . $uni['idContratoBase'] . '" ' . $verselected
                                                        . ' >' .
                                                        $uni['nombre'] . '</option>';
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-1">
                                    <label for="nombre">Propiedad</label>
                                    <div>
                                        <input type="text" disabled class="form-control" value="<?php if (isset($propiedad['nombre'])) {
                                                                                                    echo strtoupper($propiedad['nombre']);
                                                                                                } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6 mt-1">
                                    <label for="nombre">Descripción</label>
                                    <div>
                                        <input type="text" disabled class="form-control" value="<?php if (isset($propiedad['descripcion'])) {
                                                                                                    echo strtoupper($propiedad['descripcion']);
                                                                                                } ?>" />
                                    </div>
                                </div>
                            </div>
                            <div id="datosContrato" style="display: <?php if ($tipoContrato == "") {
                                                                        echo "none";
                                                                    } else {
                                                                        echo "block";
                                                                    } ?>;">
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
                                        <label for="nombre">Domicilio Arrendador</label>
                                        <div>
                                            <input type="text" required class="form-control" id="domicilioArrendador" name="domicilioArrendador" value="<?php if (isset($domicilioArrendador)) {
                                                                                                                                                            echo strtoupper($domicilioArrendador);
                                                                                                                                                        } ?>" />
                                        </div>
                                    </div>
                                </div>
                                <h5 class="card-title">Datos Contrato</h5>
                                <div class="row mt-3">
                                    <div class="col-6  mt-1 ">
                                        <label for="nombre">Fecha Inicio</label>
                                        <div>
                                            <input type="date" required class="form-control" id="fechaIni" name="fechaIni" value="<?php if (isset($fechaIni)) {
                                                                                                                                        echo strtoupper($fechaIni);
                                                                                                                                    } ?>" />
                                        </div>
                                    </div>
                                    <div class="col-6  mt-1">
                                        <label for="nombre">Fecha Fin</label>
                                        <div>
                                            <input type="date" required class="form-control" id="fechaFin" name="fechaFin" value="<?php if (isset($fechaFin)) {
                                                                                                                                        echo strtoupper($fechaFin);
                                                                                                                                    } ?>" />
                                        </div>
                                    </div>


                                    <div class="col-6  mt-1">
                                        <label for="nombre">Renta $</label>
                                        <div>
                                            <input type="text" required class="form-control" id="renta" name="renta" value="<?php if (isset($renta)) {
                                                                                                                                echo strtoupper($renta);
                                                                                                                            } ?>" />
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-1">
                                        <label for="nombre">Día de Pago</label>
                                        <div>
                                            <input type="number" required class="form-control" id="diaPago" name="diaPago" value="<?php if (isset($diaPago)) {
                                                                                                                                        echo strtoupper($diaPago);
                                                                                                                                    } ?>" />
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-4 mt-1">
                                        <label for="nombre">Depósito $</label>
                                        <div>
                                            <input type="text" required maxlength="10" class="form-control" id="deposito" name="deposito" value="<?php if (isset($deposito)) {
                                                                                                                                                        echo strtoupper($deposito);
                                                                                                                                                    } ?>" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 mt-1">
                                        <label for="nombre">% Interes Moratorio</label>
                                        <div>
                                            <input type="text" required maxlength="10" class="form-control" id="interesmoratorio" name="interesmoratorio" value="<?php if (isset($interesmoratorio)) {
                                                                                                                                                                        echo strtoupper($interesmoratorio);
                                                                                                                                                                    } ?>" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 mt-1">
                                        <label for="nombre">% Incremento Anual</label>
                                        <div>
                                            <input type="text" required maxlength="10" class="form-control" id="incrementoanual" name="incrementoanual" value="<?php if (isset($incrementoanual)) {
                                                                                                                                                                    echo strtoupper($incrementoanual);
                                                                                                                                                                } ?>" />
                                        </div>
                                    </div>

                                    <div style="display:  <?php if ($tipoContrato == "1" || $tipoContrato == "2") {
                                                                echo "block";
                                                            } else {
                                                                echo "none";
                                                            } ?>;" id="idUsoLocalidad" class="col-12 mt-1">
                                        <label for="nombre">Uso de la localidad</label>
                                        <div>
                                            <input type="text" required maxlength="500" class="form-control" id="usolocalidad" name="usolocalidad" value="<?php if (isset($usolocalidad)) {
                                                                                                                                                                echo strtoupper($usolocalidad);
                                                                                                                                                            } ?>" />
                                        </div>
                                    </div>



                                </div>

                                <h5 class="card-title mt-2">Datos Inquilino</h5>
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
                                    <div class="col-md-8 mt-1">
                                        <label for="nombre">Domicilio Notificaciones</label>
                                        <div>
                                            <input type="text" required class="form-control" id="dominquilino" name="dominquilino" value="<?php if (isset($dominquilino)) {
                                                                                                                                                echo strtoupper($dominquilino);
                                                                                                                                            } ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <label for="nombre">&nbsp;</label>
                                        <div>
                                            <button type="button" class="btn btn-primary" id="btnLLenarDireccion" onclick="document.getElementById('dominquilino').value='<?php if (isset($propiedad['direccion'])) {
                                                                                                                                                                                echo strtoupper($propiedad['direccion']);
                                                                                                                                                                            } ?>'">La misma que la propiedad rentada</button>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($tipoContrato == "3" || $tipoContrato == "4") { ?>
                                    <div id="idPersonas" class="row mb-3">
                                        <div class="col-12 mt-1">
                                            <label for="nombre">Personas que viven con el</label>
                                            <div>
                                                <input type="text" required maxlength="200" class="form-control" id="personas" name="personas" value="<?php if (isset($personas)) {
                                                                                                                                                            echo strtoupper($personas);
                                                                                                                                                        } ?>" />
                                            </div>
                                        </div>

                                    </div>
                                <?php } ?>


                                <h5 style="display:  <?php if ($tipoContrato == "1" || $tipoContrato == "3") {
                                                            echo "block";
                                                        } else {
                                                            echo "none";
                                                        } ?>;" id="tituloDatosAval" class="card-title">Datos Aval</h5>

                                <div style="display:  <?php if ($tipoContrato == "1" || $tipoContrato == "3") {
                                                            echo "block";
                                                        } else {
                                                            echo "none";
                                                        } ?>;" id="datosAval" class="row mt-3">
                                    <div class="col-md-8">
                                        <label for="nombre">Nombre</label>
                                        <div>
                                            <input type="text" required class="form-control" id="nombreaval" name="nombreaval" value="<?php if (isset($nombreaval)) {
                                                                                                                                            echo strtoupper($nombreaval);
                                                                                                                                        } ?>" />
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-1">
                                        <label for="nombre">Domicilio Aval</label>
                                        <div>
                                            <input type="text" required class="form-control" id="domicilioaval" name="domicilioaval" value="<?php if (isset($domicilioaval)) {
                                                                                                                                                echo strtoupper($domicilioaval);
                                                                                                                                            } ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <label for="nombre">Domicilio Inmueble que Avala</label>
                                        <div>
                                            <input type="text" required class="form-control" id="domicilioInmuebleAval" name="domicilioInmuebleAval" value="<?php if (isset($domicilioInmuebleAval)) {
                                                                                                                                                                echo strtoupper($domicilioInmuebleAval);
                                                                                                                                                            } ?>" />
                                        </div>
                                    </div>


                                </div>




                                <div class="form-group mt-2">
                                    <input type="hidden" name="entro" value="1" />
                                    <button type="submit" class="btn btn-primary" name="signup" value="Sign up">Crear</button>
                                </div>
                            </div>


                        </div>






                    </form>
                </div>
            </div>
        </div>



        <!-- hasta aqui llega-->

    </div>
    <?php include_once('footer.php') ?>
</div>