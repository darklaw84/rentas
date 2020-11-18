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

foreach ($permisos as $per) {
    if ($per['modulo'] == "Rentas Prop") {
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
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $mensajeEnviar = "El archivo es demasiado grande";
        $uploadOk = 0;
    }



    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk > 0) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $controller->subirComprobanteRenta($idRentaContrato, basename($_FILES["fileToUpload"]["name"]));
        } else {
            $mensajeEnviar = "Hubo un error subiendo el archivo";
        }
    }
}





$rentas = $controller->obtenerMisRentasVencidas($_SESSION['idUsr'])->registros;





?>




<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-cash icon-gradient bg-ripe-malin"></i>
                    </div>
                    <div>Rentas Vencidas / Por Vencer
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
            <div id="divMisRentas" class="col-md-12 mt-3 mb-3" >
                            
                            <table style="width: 100%;" id="misrentas" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th>PROPIEDAD</th>
                                    <th>INQUILINO</th>
                                        <th>FECHA</th>
                                        <th>TIPO</th>
                                        <th>MONTO</th>
                                        <th>COMPROBANTE</th>
                                        <th>ESTATUS</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($rentas)) {
                                        foreach ($rentas as $reg) { ?>
                                            <tr id="<?php echo $reg['idRentaContrato'] ?>">
                                            <td><?php echo strtoupper($reg['nombre']) ?></td>
                                            <td><?php echo strtoupper($reg['inquilino']) ?></td>
                                                <td data-target="fecha"><?php echo strtoupper($reg['fecha']) ?></td>
                                                <td data-target="tipo"><?php if($reg['tipo']=="R"){echo "RENTA";}else {echo "MTTO.";} ?></td>
                                                <td data-target="monto"><?php echo strtoupper($reg['monto']) ?></td>

                                   
                                                <td>
                                                <?php 
                                                     if($reg['comprobante']!="") { ?>
                                                        <a href="#" data-role="mostrarFoto" data-id="<?php echo $reg['comprobante'] ?>"> <img src="fotos/<?php echo $reg['comprobante']; ?>" height="30px"></a>
                                                    <?php } 
                                                    ?>
                                                            <form action="index.php?p=misrentas" method="post" enctype="multipart/form-data">

                                                                <input type="file" type="" onchange="document.getElementById('btnSubirComp<?php echo $reg['idRentaContrato']; ?>').click();" name="fileToUpload" id="fileToUpload" accept="image/x-png,image/gif,image/jpeg">
                                                                <input type="hidden" name="idRentaContrato" id="idRentaContrato" value="<?php echo $reg['idRentaContrato']; ?>">
                                     

                                                                <input type="submit" id="btnSubirComp<?php echo $reg['idRentaContrato']; ?>" style="display: none;" value="Subir" name="submit">
                                                            </form>
                                                       
                                                </td>
                                                <td>
                                                            <a href="#" class="btn btn-primary" data-role="pagoRentaRentas" data-id="<?php echo $reg['idRentaContrato'] ?>">Recibir</a>
                                                       </td>
                                            </tr>
                                    <?php }
                                    } ?>

                                </tbody>
                                <tfoot> <tr> <th colspan="4" style="text-align:right">Total:</th> <th></th> <th></th> <th></th> </tr> </tfoot>
                            </table>
                        </div>
            </div>
        </div>


        <!-- hasta aqui llega-->

    </div>
    <?php include_once('footer.php') ?>
</div>
