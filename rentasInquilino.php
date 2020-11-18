<?php

include_once './controllers/PropiedadesController.php';
include_once './utilMail.php';
include_once './generarRecibo.php';

if (!isset($_SESSION['nombreUsr'])) {
    echo "<script>window.setTimeout(function() { window.location = 'login.php' }, 10);</script>";
}
$controller = new PropiedadesController();

$utilMail = new UtilMail();



$permisos = $_SESSION['permisos'];

$agregar = false;
$editar = false;
$consultar = false;
$activar = false;

foreach ($permisos as $per) {
    if ($per['modulo'] == "Rentas Inq") {

        if ($per['accion'] == "Consultar") {
            $consultar = true;
        }
    }
}

if (!$consultar) {
    echo "<script>window.setTimeout(function() { window.location = 'index.php' }, 10);</script>";
}

$idInquilino = $_SESSION['idUsr'];



$idContrato = "";

if (isset($_GET['idContrato'])) {
    $idContrato = $_GET['idContrato'];
}

if (isset($_POST['idContrato'])) {
    $idContrato = $_POST['idContrato'];
}


$pes = "";

if (isset($_GET['pes'])) {
    $pes = $_GET['pes'];
}

if (isset($_POST['pes'])) {
    $pes = $_POST['pes'];
}











$contratos = $controller->obtenerContratosInquilino($idInquilino)->registros;
$vigente = false;
if ($idContrato == "") {
    if (count($contratos) > 0) {
        $idContrato = $contratos[0]['idContrato'];
    }
}

$contrato = $controller->obtenerContrato($idContrato)->registros;





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

$mantenimientos = $controller->obtenerPagosPropiedadContrato($idContrato)->registros;

if (isset($contrato[0])) {

    $respuesta = $controller->obtenerPropiedad($contrato[0]['idPropiedad']);

    if (isset($respuesta->registros[0])) {

        $propiedad = $respuesta->registros[0];




?>




        <div class="app-main__outer">
            <div class="app-main__inner">


                <!-- aqui va el contenido de la página -->
                <div>
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-7">
                                    <label for="idLineaIn">Contratos</label>
                                    <div>
                                        <form method="POST" action="index.php?p=misrentasinq">

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
                                <div class="col-md-5">
                                    <label>&nbsp;</label>
                                    <div>

                                        <?php if ($archivo != "") { ?>
                                            <a href="archivos/<?php echo $archivo ?>"> <img src="imagenes/contrato.png" height="40px"></a>
                                        <?php }


                                        ?>
                                        <a href="imprimirContrato.php?idContrato=<?php echo $idContrato; ?>" target="_blank"><button type="button" title="Imprimir Contrato" class="mb-2 mr-2 btn-icon btn-icon-only btn btn-dark"><i class="pe-7s-print btn-icon-wrapper"> </i></button></a>




                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <?php if ($propiedad['fotografia'] != "") { ?>
                                        <img class="img-fluid" width="100%" src="fotos/<?php echo $propiedad['fotografia'] ?>">
                                    <?php } else { ?>
                                        <img class="img-fluid" width="100%" src="imagenes/casa.png">
                                    <?php } ?>
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


                                                            ?>


                                                        </td>
                                                        <td><?php if ($reg['estatus'] == 1) {

                                                            ?>

                                                                <img src="./imagenes/correcto.png" height="20px">
                                                            <?php
                                                            } ?></td>

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




                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($mantenimientos)) {
                                                foreach ($mantenimientos as $reg) { ?>
                                                    <tr>
                                                        <td><?php echo strtoupper($reg['idContrato']) ?></td>
                                                        <td><?php if ($reg['tipo'] == "E") { ?>
                                                                <img src="imagenes/minus.png" height="25px"><?php } else { ?>
                                                                <img src="imagenes/plus.png" height="25px"><?php } ?></td>
                                                        <td><?php echo strtoupper($reg['monto']) ?></td>

                                                        <td><?php echo strtoupper($reg['fechaPago']) ?></td>
                                                        <td><?php echo strtoupper($reg['usuario']) ?></td>
                                                        <td><?php echo strtoupper($reg['descripcion']) ?></td>
                                                        <td><?php if ($reg['comprobante'] != "") {

                                                            ?>
                                                                <a href="#" data-role="mostrarFoto" data-id="<?php echo $reg['comprobante'] ?>"> <img src="fotos/<?php echo $reg['comprobante']; ?>" height="30px"> </a>
                                                            <?php } ?></td>

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
<?php
    }
}
?>
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