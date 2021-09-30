<?php

include_once './controllers/PropiedadesController.php';
include_once './utilMail.php';
include_once './generarRecibo.php';

if (!isset($_SESSION['nombreUsr'])) {
    echo "<script>window.setTimeout(function() { window.location = 'login.php' }, 10);</script>";
}
$controller = new PropiedadesController();

$utilMail = new UtilMail();

$generarRecibo = new GenerarRecibo();


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

if (isset($_POST['idPropiedadFoto'])) {
    $idPropiedad = $_POST['idPropiedadFoto'];
}

$idContrato = "";

if (isset($_GET['idContrato'])) {
    $idContrato = $_GET['idContrato'];
}

if (isset($_POST['idContrato'])) {
    $idContrato = $_POST['idContrato'];
}

if (isset($_POST['idContratoFoto'])) {
    $idContrato = $_POST['idContratoFoto'];
}


$pes = "";

if (isset($_GET['pes'])) {
    $pes = $_GET['pes'];
}

if (isset($_POST['pes'])) {
    $pes = $_POST['pes'];
}


if (isset($_POST['idRentaContrato'])) {


    $idRentaContrato = $_POST['idRentaContrato'];

    $target_dir = "fotos/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {

            $uploadOk = 1;
        } else {

            $uploadOk = 0;
        }
    }


    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 1000000) {
        $mensajeEnviar = "El archivo es demasiado grande";
        $uploadOk = 0;
    }



    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk > 0) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $controller->subirComprobanteRenta($idRentaContrato, basename($_FILES["fileToUpload"]["name"]));
            /* $idRecibo = $controller->agregarRecibo($idRentaContrato)->valor;

            //tenemos que generar el recibo
            $nombreRecibo = $generarRecibo->generarRecibo($idRecibo);
            $correo = $controller->obtenerCorreoRecibo($idRecibo)->registros[0]['correo'];
            //se manda el correo
            $contenido = $controller->obtenerContenidoCorreoRecibo();
            $utilMail->enviarCorreoPagoRealizado($correo, "Recibo de pago", $contenido, $nombreRecibo);
            */
        } else {
            $mensajeEnviar = "Hubo un error subiendo el archivo";
        }
    }
}






if (isset($_POST['idPago'])) {


    $idPago = $_POST['idPago'];

    $target_dir = "fotos/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {

            $uploadOk = 1;
        } else {

            $uploadOk = 0;
        }
    }



    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 1000000) {
        $mensajeEnviar = "El archivo es demasiado grande";
        $uploadOk = 0;
    }



    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk > 0) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $controller->subirComprobantePago($idPago, basename($_FILES["fileToUpload"]["name"]));
        } else {
            $mensajeEnviar = "Hubo un problema subiendo el archivo";
        }
    }
}





if (isset($_POST['subirContra'])) {


    $idContrato = $_POST['idContrato'];

    $target_dir = "archivos/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));





    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk > 0) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $controller->subirArchivoContrato($idContrato, basename($_FILES["fileToUpload"]["name"]));
        } else {
            $mensajeEnviar = "Hubo un problema subiendo el archivo";
        }
    }
}


if (isset($_POST['subirFoto'])) {




    $target_dir = "fotos/";
    $target_file = $target_dir . basename($_FILES["fileFoto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));





    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk > 0) {
        if (move_uploaded_file($_FILES["fileFoto"]["tmp_name"], $target_file)) {
            $controller->subirFotoPropiedadLista($idPropiedad, basename($_FILES["fileFoto"]["name"]));
        } else {
            $mensajeEnviar = "Hubo un problema subiendo el archivo";
        }
    }
}







$contratos = $controller->obtenerContratosPropiedad($idPropiedad)->registros;
$vigente = false;
if ($idContrato == "") {
    if (count($contratos) > 0) {
        $idContrato = $contratos[0]['idContrato'];
    }
}
$archivo = "";
if ($idContrato != "") {

    $rentas = $controller->obtenerRentasContrato($idContrato)->registros;

    foreach ($contratos as $cont) {
        if ($cont['idContrato'] == $idContrato) {
            if ($cont['estatus'] == 1) {
                $vigente = true;
                $archivo = $cont['archivo'];
            }
        }
    }
}

$mantenimientos = $controller->obtenerPagosPropiedad($idPropiedad)->registros;

$respuesta = $controller->obtenerPropiedad($idPropiedad);
$propiedad = $respuesta->registros[0];




?>




<div class="app-main__outer">
    <div class="app-main__inner">


        <!-- aqui va el contenido de la página -->


        
        <div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <?php if (count($propiedad['fotos']) > 0) { ?>
                                <img class="img-fluid" width="100%" src="fotos/<?php echo $propiedad['fotos'][0]['foto'] ?>">
                            <?php } else { ?>
                                <img class="img-fluid" width="100%" src="imagenes/casa.png">
                            <?php } ?>
                            <form action="index.php?p=consultaPropiedad" method="post" enctype="multipart/form-data">
                                <div id="divFotoProp" class="custom-file mt-2 mb-2">
                                    <input type="file" style="opacity:0;" accept="image/x-png,image/gif,image/jpeg" name="fileFoto" id="fileFoto" lang="es">
                                    <label class="custom-file-label" for="fileFoto">Sel. Foto</label>
                                </div>
                                <input type="hidden" name="idPropiedadFoto" id="idPropiedadFoto" value="<?php echo $idPropiedad; ?>">
                                <input type="hidden" name="idContratoFoto" id="idContratoFoto" value="<?php echo $idContrato; ?>">
                                <input type="hidden" name="subirFoto" value="1">
                                <input type="submit" id="btnSubirFoto" style="display: none;" value="Subir" name="submit">
                            </form>
                            <input type="button" id="btnMostrarFotos" class="btn btn-warning" value="<?php echo count($propiedad['fotos']);  ?> Fotos">
                        </div>
                        <div class="col-md-3">
                            <label for="nombre">Propiedad</label>
                            <div>
                                <input type="text" disabled class="form-control" value="<?php if (isset($propiedad['nombre'])) {
                                                                                            echo strtoupper($propiedad['nombre']);
                                                                                        } ?>" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="nombre">Descripción</label>
                            <div>
                                <textarea disabled rows="1" style="width: 100%;"><?php if (isset($propiedad['descripcion'])) {
                                                                                        echo strtoupper($propiedad['descripcion']);
                                                                                    } ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="nombre">Dirección</label>
                            <div>
                                <textarea disabled rows="1" style="width: 100%;"><?php if (isset($propiedad['direccion'])) {
                                                                                        echo strtoupper($propiedad['direccion']);
                                                                                    } ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <label for="idLineaIn">Contratos</label>
                            <div>
                                <form method="POST" action="index.php?p=consultaPropiedad">
                                    <input type="hidden" name="idPropiedad" id="idPropiedad" value="<?php echo $idPropiedad ?>">
                                    <select class=" form-control selectPerfil" name="idContrato" onchange="this.form.submit()" id="idContrato">

                                        <?php
                                        if (isset($contratos)) {
                                            foreach ($contratos as $uni) {
                                                if (isset($idContrato)) {
                                                    if ($idContrato == $uni['idContrato']) {
                                                        $verselected = "selected";
                                                    } else {
                                                        $verselected = "";
                                                    }
                                                } else {
                                                    $verselected = "";
                                                }
                                                $estatus = "Vigente";
                                                if ($uni['estatus'] == 0) {
                                                    $estatus = "No Vigente";
                                                }
                                                echo '<option value="' . $uni['idContrato'] . '" ' . $verselected
                                                    . ' >' .
                                                    strtoupper("Contrato: " . $uni['idContrato'] . " | Fecha Inicio: " . $uni['fechaIni'] . " |   Fecha Fin: " . $uni['fechaFin'] . " | Estatus:" . $estatus) . '</option>';
                                            }
                                        } ?>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-2">

                            <div>
                                <a class="btn btn-warning mb-2 mr-2" href="index.php?p=crearContrato&idPropiedad=<?php echo $idPropiedad ?>">Nuevo Contrato</a>

                                <?php if ($archivo != "") { ?>
                                    <a target="_blank" href="archivos/<?php echo $archivo ?>"> <img src="imagenes/contrato.png" height="40px"></a>
                                <?php }
                                if ($vigente) { ?>

                                    <a href="imprimirContrato.php?idContrato=<?php echo $idContrato; ?>" target="_blank"><button type="button" title="Imprimir Contrato" class="mb-2 mr-2 btn-icon btn-icon-only btn btn-dark"><i class="pe-7s-print btn-icon-wrapper"> </i></button></a>
                                <?php } ?>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if ($vigente) {
                            ?>


                                <a href="index.php?p=mostrarContrato&idPropiedad=<?php echo $idPropiedad; ?>&idContrato=<?php echo $idContrato; ?>" class="btn btn-secondary mb-2 mr-2">Modificar Datos Contrato</a>


                                <form action="index.php?p=consultaPropiedad" method="post" enctype="multipart/form-data">
                                    <div id="divContrato" class="custom-file">
                                        <input type="file" style="opacity:0;" accept="application/pdf" name="fileToUpload" id="fileToUpload" lang="es">
                                        <label class="custom-file-label" for="fileToUpload">Subir Contrato Firmado</label>
                                    </div>


                                    <input type="hidden" name="idPropiedad" id="idPropiedad" value="<?php echo $idPropiedad; ?>">
                                    <input type="hidden" name="idContrato" id="idContrato" value="<?php echo $idContrato; ?>">
                                    <input type="hidden" name="subirContra" value="1">
                                    <input type="submit" id="btnSubirContra" style="display: none;" value="Subir" name="submit">
                                </form>
                            <?php } ?>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button class="btn <?php if ($pes == "") {
                                                    echo "btn-primary";
                                                } else {
                                                    echo "btn-dark";
                                                } ?>  mr-2" id="btnRentas">Rentas Contrato</button>
                            <button class="btn <?php if ($pes == "") {
                                                    echo "btn-dark";
                                                } else {
                                                    echo "btn-primary";
                                                } ?>" id="btnPagos">Pagos Contrato</button>
                        </div>
                        <div id="divRentasContrato" class="col-md-12 mt-3 mb-3" <?php if ($pes != "") {
                                                                                    echo "style='display:none'";
                                                                                } ?>>
                            <h3>Rentas Contrato</h3>
                            <table style="width: 100%;" id="rentas" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>FECHA DE PAGO </th>
                                        <th>TIPO</th>
                                        <th>MONTO</th>

                                        <th>FECHA PAGADA </th>
                                        <th>MÉTODO PAGO </th>
                                        <th> USUARIO</th>
                                        <th>COMPROBANTE</th>
                                        <th>ESTATUS</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($rentas)) {
                                        foreach ($rentas as $reg) { ?>
                                            <tr id="<?php echo $reg['idRentaContrato'] ?>">
                                                <td data-target="fecha"><?php echo strtoupper($reg['fecha']) ?></td>
                                                <td data-target="tipo"><?php if ($reg['tipo'] == "R") {
                                                                            echo "RENTA";
                                                                        } else {
                                                                            echo "MTTO.";
                                                                        } ?></td>
                                                <td data-target="monto"><?php echo strtoupper($reg['monto']) ?></td>

                                                <td><?php echo strtoupper($reg['fechaPago']) ?></td>
                                                <td><?php echo strtoupper($reg['metodoPago']) ?></td>
                                                <td><?php echo strtoupper($reg['usuario'])  ?></td>
                                                <td>
                                                    <?php
                                                    if ($reg['comprobante'] != "") { ?>
                                                        <a href="#" data-role="mostrarFoto" data-id="<?php echo $reg['comprobante'] ?>"> <img src="fotos/<?php echo $reg['comprobante']; ?>" height="30px"></a>
                                                    <?php }

                                                    if ($vigente) {
                                                    ?>
                                                        <form action="index.php?p=consultaPropiedad" method="post" enctype="multipart/form-data">

                                                            <input type="file" type="" onchange="document.getElementById('btnSubirComp<?php echo $reg['idRentaContrato']; ?>').click();" name="fileToUpload" id="fileToUpload" accept="image/x-png,image/gif,image/jpeg">
                                                            <input type="hidden" name="idRentaContrato" id="idRentaContrato" value="<?php echo $reg['idRentaContrato']; ?>">
                                                            <input type="hidden" name="idPropiedad" id="idPropiedad" value="<?php echo $idPropiedad; ?>">
                                                            <input type="hidden" name="idContrato" id="idContrato" value="<?php echo $idContrato; ?>">

                                                            <input type="submit" id="btnSubirComp<?php echo $reg['idRentaContrato']; ?>" style="display: none;" value="Subir" name="submit">
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                                <td><?php if ($reg['estatus'] == 0) {

                                                        if ($vigente) {

                                                    ?>
                                                            <a href="#" class="btn btn-primary" data-role="pagoRenta" data-id="<?php echo $reg['idRentaContrato'] ?>">Recibir</a>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <a href="#" class="btn btn-danger" data-role="xpagoRenta" data-id="<?php echo $reg['idRentaContrato'] ?>">Cancelar</a>
                                                        <img src="./imagenes/correcto.png" height="20px">
                                                    <?php
                                                    } ?>
                                                </td>

                                            </tr>
                                    <?php }
                                    } ?>

                                </tbody>

                            </table>
                        </div>
                        <div id="divPagosContrato" class="col-md-12 mt-3 mb-3" <?php if ($pes == "") {
                                                                                    echo "style='display: none;'";
                                                                                } ?>>
                            <h3>Pagos Contrato</h3>

                            <div class="row mt-3 mb-3">
                                <div class="col-md-12">
                                    <?php if (count($contratos) > 0) { ?>
                                        <button id="btnAgregarPago" class="btn btn-primary">Agregar Pago</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <table style="width: 100%;" id="pagos" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th># Contrato</th>
                                        <th>Tipo</th>
                                        <th>Monto</th>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Descripción</th>
                                        <th>Comprobante</th>
                                        <th>Eliminar</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($mantenimientos)) {
                                        foreach ($mantenimientos as $reg) { ?>
                                            <tr>
                                                <td><?php echo strtoupper($reg['idContrato']) ?></td>
                                                <td><?php if ($reg['tipo'] == "E") { ?>
                                                        <img src="imagenes/minus.png" height="25px"><?php } else { ?>
                                                        <img src="imagenes/plus.png" height="25px"><?php } ?>
                                                </td>
                                                <td><?php echo strtoupper($reg['monto']) ?></td>

                                                <td><?php echo strtoupper($reg['fechaPago']) ?></td>
                                                <td><?php echo strtoupper($reg['usuario']) ?></td>
                                                <td><?php echo strtoupper($reg['descripcion']) ?></td>
                                                <td><?php if ($reg['comprobante'] == null || $reg['comprobante'] == "") {
                                                        if ($vigente) { ?>
                                                            <form action="index.php?p=consultaPropiedad" method="post" enctype="multipart/form-data">

                                                                <input type="file" onchange="document.getElementById('btnSubirCompP<?php echo $reg['idPago']; ?>').click();" type="" name="fileToUpload" id="fileToUpload" accept="image/x-png,image/gif,image/jpeg">
                                                                <input type="hidden" name="idPago" id="idPago" value="<?php echo $reg['idPago']; ?>">
                                                                <input type="hidden" name="idPropiedad" id="idPropiedad" value="<?php echo $idPropiedad; ?>">
                                                                <input type="hidden" name="idContrato" id="idContrato" value="<?php echo $idContrato; ?>">
                                                                <input type="hidden" name="pes" id="pes" value="pagos">
                                                                <input type="submit" class="btn btn-secondary" id="btnSubirCompP<?php echo $reg['idPago']; ?>" style="display: none;" value="Subir" name="submit">
                                                            </form>
                                                        <?php }
                                                    } else { ?>
                                                        <a href="#" data-role="mostrarFoto" data-id="<?php echo $reg['comprobante'] ?>"> <img src="fotos/<?php echo $reg['comprobante']; ?>" height="30px"> </a>
                                                    <?php } ?>
                                                </td>
                                                <td> <a href="#" class="btn btn-dark" data-role="eliminarPago" data-id="<?php echo $reg['idPago'] ?>">Eliminar</a></td>
                                            </tr>
                                    <?php }
                                    } ?>

                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <!-- hasta aqui llega-->

    </div>
    <?php include_once('footer.php') ?>
</div>

<script>
    $(document).ready(function() {
        $('#rentas').DataTable({
            "lengthMenu": [
                [100, 200, -1],
                [100, 200, "Todos"]
            ]
        });
    });

    $(document).ready(function() {
        $('#pagos').DataTable({
            "lengthMenu": [
                [100, 200, -1],
                [100, 200, "Todos"]
            ]
        });
    });
</script>