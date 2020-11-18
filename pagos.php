<?php

include_once './controllers/PropiedadesController.php';
if (!isset($_SESSION['nombreUsr'])) {
    echo "<script>window.setTimeout(function() { window.location = 'login.php' }, 10);</script>";
}
$controller = new PropiedadesController();

include_once './controllers/PerfilesController.php';

$contPerf = new PerfilesController();

$perfiles = $contPerf->obtenerPerfiles()->registros;

$permisos = $_SESSION['permisos'];

$agregar = false;
$editar = false;
$consultar = false;
$activar = false;
$verTodas = false;

foreach ($permisos as $per) {
    if ($per['modulo'] == "Pagos") {
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
    if ($per['modulo'] == "Mis Propiedades") {

        if ($per['accion'] == "Ver Todas") {
            $verTodas = true;
        }
    }
}

if (!$consultar) {
    echo "<script>window.setTimeout(function() { window.location = 'index.php' }, 10);</script>";
}


if (isset($_POST['idPago'])) {


    $idPago = $_POST['idPago'];

    $target_dir = "fotos/";
    $target_file = $target_dir . basename($_FILES["fileComprobante"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileComprobante"]["tmp_name"]);
        if ($check !== false) {

            $uploadOk = 1;
        } else {

            $uploadOk = 0;
        }
    }



    // Check file size
    if ($_FILES["fileComprobante"]["size"] > 10000000) {
        $mensajeEnviar = "El archivo es demasiado grande";
        $uploadOk = 0;
    }



    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk > 0) {
        if (move_uploaded_file($_FILES["fileComprobante"]["tmp_name"], $target_file)) {
            $controller->subirComprobantePago($idPago, basename($_FILES["fileComprobante"]["name"]));
        } else {
            $mensajeEnviar = "Hubo un problema subiendo el archivo";
        }
    }
}


if ($verTodas) {
    $respuesta = $controller->obtenerPropiedades();
    $registros = $respuesta->registros;
} else {


    $respuesta = $controller->obtenerPropiedadesUsuario($_SESSION['idUsr']);
    $registros = $respuesta->registros;
}

$mantenimientos = array();
foreach ($registros as $pro) {
    $manttos = $controller->obtenerPagosPropiedad($pro['idPropiedad'])->registros;
    $mantenimientos = array_merge($mantenimientos, $manttos);
}



?>




<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-tools icon-gradient bg-ripe-malin"></i>
                    </div>
                    <div>Pagos
                        <div class="page-title-subheading">.</div>
                    </div>
                </div>
                <div class="page-title-actions">

                </div>
            </div>
        </div>

        <!-- aqui va el contenido de la página -->

        <div class="main-card mb-3 card">
            <div class="card-body">

            <div class="row mt-3 mb-3">
                                <div class="col-md-12">
                                    
                                        <button id="btnAgregarPagoPagos" class="btn btn-primary">Agregar Pago</button>
                                    
                                </div>
                            </div>

                <table style="width: 100%;" id="tablapagos" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>FECHA</th>
                            <th>PROPIEDAD</th>
                            <th>INQUILINO</th>
                            <th># CONTRATO</th>
                            <th>TIPO</th>
                            <th>MONTO</th>

                            <th>USUARIO</th>
                            <th>DESCRIPCIÓN</th>
                            <th>COMPROBANTE</th>
                            <th>ELIMINAR</th>



                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($mantenimientos)) {
                            foreach ($mantenimientos as $reg) { ?>
                                <tr>
                                    <td><?php echo strtoupper($reg['fechaPago']) ?></td>
                                    <td><?php echo strtoupper($reg['propiedad']) ?></td>
                                    <td><?php echo strtoupper($reg['inquilino']) ?></td>
                                    <td><?php echo strtoupper($reg['idContrato']) ?></td>
                                    <td><?php if ($reg['tipo'] == "E") { ?>
                                            <img src="imagenes/minus.png" height="25px"><?php } else { ?>
                                            <img src="imagenes/plus.png" height="25px"><?php } ?></td>
                                    <td><?php echo strtoupper($reg['monto']) ?></td>


                                    <td><?php echo strtoupper($reg['usuario']) ?></td>
                                    <td><?php echo strtoupper($reg['descripcion']) ?></td>
                                    <td><?php if ($reg['comprobante'] == null || $reg['comprobante'] == "") {
                                            if ($reg['vigente']) { ?>
                                                <form action="index.php?p=pagos" method="post" enctype="multipart/form-data">
                                                    <div id="divContrato" class="custom-file">
                                                        <input type="file" style="opacity:0;" 
                                                        onchange="document.getElementById('btnSubirCompP<?php echo $reg['idPago']; ?>').click();" 
                                                        name="fileComprobante" id="fileComprobante" lang="es">
                                                        <label class="custom-file-label" for="fileComprobante">Subir Comprobante</label>
                                                    </div>
                                                   
                                                    <input type="hidden" name="idPago" id="idPago" value="<?php echo $reg['idPago']; ?>">


                                                    <input type="hidden" name="pes" id="pes" value="pagos">
                                                    <input type="submit" class="btn btn-secondary" id="btnSubirCompP<?php echo $reg['idPago']; ?>" style="display: none;" value="Subir" name="submit">
                                                </form>
                                            <?php }
                                        } else { ?>
                                            <a href="#" data-role="mostrarFoto" data-id="<?php echo $reg['comprobante'] ?>"> <img src="fotos/<?php echo $reg['comprobante']; ?>" height="30px"> </a>
                                        <?php } ?></td>
                                    <td> <a href="#" class="btn btn-dark" data-role="eliminarPagoPagos" data-id="<?php echo $reg['idPago'] ?>">Eliminar</a></td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" style="text-align:right">Total:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>

                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>


        <!-- hasta aqui llega-->

    </div>
    <?php include_once('footer.php') ?>
</div>