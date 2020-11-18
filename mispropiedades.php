<?php

include_once './controllers/PropiedadesController.php';
if (!isset($_SESSION['nombreUsr'])) {
    echo "<script>window.setTimeout(function() { window.location = 'login.php' }, 10);</script>";
}
$controller = new PropiedadesController();

include_once './controllers/PerfilesController.php';



$permisos = $_SESSION['permisos'];

$agregar = false;
$editar = false;
$consultar = false;
$verTodas = false;

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
        if ($per['accion'] == "Ver Todas") {
            $verTodas = true;
        }
    }
}

$entro = "";
if (isset($_POST['entro'])) {
    $entro = $_POST['entro'];
}

if (isset($_GET['entro'])) {
    $entro = $_GET['entro'];
}

if ($entro != "") {

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $direccion = $_POST['direccion'];
    $renta = $_POST['renta'];
    $target_dir = "fotos/";
    $target_file = $target_dir . basename($_FILES["fotoPropiedadSola"]["name"]);

    $fotografia = $_FILES["fotoPropiedadSola"]["name"];

    $construccion = $_POST['construccion'];
    $numescritura = $_POST['numescritura'];
    $superficie = $_POST['superficie'];
    $fechaescritura = $_POST['fechaescritura'];
    $numNotaria = $_POST['numNotaria'];
    $foliomercantil = $_POST['foliomercantil'];
    $licenciado = $_POST['licenciado'];
    $predial = $_POST['predial'];

    if (isset($_POST['amueblada'])) {
        $amueblada = 1;
    } else {
        $amueblada = 0;
    }

    if ($nombre == "" || $renta == "") {
        $mensajeEnviar = "Todos los campos son obligatorios, por favor verifique";
    } else {
        if ($fotografia != "") {
            move_uploaded_file($_FILES["fotoPropiedadSola"]["tmp_name"], $target_file);
        }


        $respuesta = $controller->agregarPropiedad(
            $nombre,
            $descripcion,
            $direccion,
            $renta,
            $_SESSION['idUsr'],
            $fotografia,
            $superficie,
            $construccion,
            $numescritura,
            $fechaescritura,
            $numNotaria,
            $foliomercantil,
            $licenciado,
            $predial,
            $amueblada
        );

        if (!$respuesta->exito) {
            $mensajeEnviar = $respuesta->mensaje;
        } else {
            $nombre = "";
            $descripcion = "";
            $direccion = "";
            $renta = "";
        }
    }
}



if (isset($_POST['idPropiedad'])) {


    $idPropiedad = $_POST['idPropiedad'];

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
            $controller->subirFotoPropiedad($idPropiedad, basename($_FILES["fileToUpload"]["name"]));
        } else {
            $mensajeEnviar = "Hubo un problema subiendo el archivo";
        }
    }
}




if (isset($_POST['idContrato'])) {


    $idContrato = $_POST['idContrato'];

    $target_dir = "archivos/";
    $target_file = $target_dir . basename($_FILES["fileOtro"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));




    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk > 0) {
        if (move_uploaded_file($_FILES["fileOtro"]["tmp_name"], $target_file)) {
            $controller->subirArchivoContrato($idContrato, basename($_FILES["fileOtro"]["name"]));
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






?>




<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-home icon-gradient bg-ripe-malin"></i>
                    </div>
                    <div>Mis Propiedades
                        <div class="page-title-subheading">.</div>
                    </div>
                </div>
                <div class="page-title-actions">


                    <button <?php if (!$agregar) {
                                echo "disabled";
                            } ?> type="button" data-toggle="collapse" href="#collapseNuevoAdministrador" class="btn btn-primary">Nueva Propiedad</button>


                </div>
            </div>
        </div>

        <!-- aqui va el contenido de la página -->
        <div class="collapse" id="collapseNuevoAdministrador">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Nueva Propiedad</h5>
                    <form id="adminForm" class="col-md-10 mx-auto" method="post" enctype="multipart/form-data" action="index.php?p=mispropiedades">
                        <div class="form-group">
                            <label for="nombre">Nombre Propiedad</label>
                            <div>
                                <input type="text" required maxlength="50" class="form-control" id="nombre" name="nombre" value="<?php if (isset($nombre)) {
                                                                                                                                        echo strtoupper($nombre);
                                                                                                                                    } ?>" placeholder="Nombre" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Descripción</label>
                            <div>
                                <input type="text" required maxlength="255" class="form-control" id="descripcion" name="descripcion" value="<?php if (isset($descripcion)) {
                                                                                                                                                echo strtoupper($descripcion);
                                                                                                                                            } ?>" placeholder="Descripción" />
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-8">
                                <label for="apellidos">Dirección</label>
                                <div>
                                    <input type="text" required maxlength="100" class="form-control" id="direccion" name="direccion" value="<?php if (isset($direccion)) {
                                                                                                                                                echo strtoupper($direccion);
                                                                                                                                            } ?>" placeholder="Dirección" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="nombre">Cuenta Predial</label>
                                <div>
                                    <input type="text" class="form-control" id="predial" name="predial" value="<?php if (isset($predial)) {
                                                                                                                            echo strtoupper($predial);
                                                                                                                        } ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="cargo">$ Renta</label>
                                <div>
                                    <input type="number" required class="form-control" id="renta" name="renta" value="<?php if (isset($renta)) {
                                                                                                                            echo strtoupper($renta);
                                                                                                                        } ?>" placeholder="Renta" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="cargo">Superficie m2</label>
                                <div>
                                    <input type="number" class="form-control" id="superficie" name="superficie" value="<?php if (isset($superficie)) {
                                                                                                                            echo strtoupper($superficie);
                                                                                                                        } ?>" placeholder="Superficie" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="cargo">Construcción m2</label>
                                <div>
                                    <input type="number" class="form-control" id="construccion" name="construccion" value="<?php if (isset($construccion)) {
                                                                                                                                echo strtoupper($construccion);
                                                                                                                            } ?>" placeholder="Construccion" />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="nombre"># Escritura</label>
                                <div>
                                    <input type="text" class="form-control" id="numescritura" name="numescritura" value="<?php if (isset($numescritura)) {
                                                                                                                                echo strtoupper($numescritura);
                                                                                                                            } ?>" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="nombre">Fecha Escritura</label>
                                <div>
                                    <input type="date" class="form-control" id="fechaescritura" name="fechaescritura" value="<?php if (isset($fechaescritura)) {
                                                                                                                                    echo strtoupper($fechaescritura);
                                                                                                                                } ?>" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="nombre"># Notaría</label>
                                <div>
                                    <input type="number" class="form-control" id="numNotaria" name="numNotaria" value="<?php if (isset($numNotaria)) {
                                                                                                                            echo strtoupper($numNotaria);
                                                                                                                        } ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 mt-3">
                            <div class="col-md-4">
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
                                    <input type="text" class="form-control" id="licenciado" name="licenciado" value="<?php if (isset($licenciado)) {
                                                                                                                            echo strtoupper($licenciado);
                                                                                                                        } ?>" />
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="cargo">Foto</label>
                                <div>
                                    <input type="file" type="" name="fotoPropiedadSola" id="fotoPropiedadSola" accept="image/x-png,image/gif,image/jpeg">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="cargo">Amueblada</label>
                                <div>
                                    <input type="checkbox" name="amueblada" id="amueblada" data-toggle="toggle" data-size="small" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
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
        <div class="main-card mb-3 card">
            <div class="card-body">
                <table style="width: 100%;" id="propiedades" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>

                            <th>NOMBRE</th>
                            <th>DESCRIPCIÓN</th>
                            <th>DIRECCIÓN</th>
                            <th>RENTA</th>
                            <th>PAGADA HASTA</th>
                            <th>MONTO</th>



                            <th>ESTATUS</th>



                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registros as $reg) { ?>
                            <tr id="<?php echo $reg['idPropiedad'] ?>">

                                <td data-target="nombre"><?php echo strtoupper($reg['nombre']) ?></td>
                                <td data-target="descripcion"><?php echo strtoupper($reg['descripcion']) ?></td>
                                <td data-target="direccion"><?php echo strtoupper($reg['direccion']) ?></td>
                                <td data-target="renta"><?php echo strtoupper($reg['renta']) ?></td>
                                <td><?php if (count($reg['fechaMaxPago']) > 0) {
                                        echo $reg['fechaMaxPago'][0]['tipo'] . " " . $reg['fechaMaxPago'][0]['fecha'] . " " . $reg['fechaMaxPago'][0]['monto'];
                                    } ?></td>
                                <td>
                                    <table>
                                        <tr>
                                            <td><?php echo "Egresos: " . $reg['totalEgresos']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo "Ingresos: " . $reg['totalIngresos']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo "Total: " . $reg['totalPropiedad']; ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <?php  /*<td>
                                    <?php if ($reg['fotografia'] != "") { ?>
                                        <a href="#" data-role="mostrarFoto" data-id="<?php echo $reg['fotografia'] ?>"> <img src="fotos/<?php echo $reg['fotografia']; ?>" height="40px"></a>
                                    <?php } ?>
                                    <form action="index.php?p=mispropiedades" method="POST" enctype="multipart/form-data">

                                        <input type="file" type="" onchange="document.getElementById('btnSubirFot<?php echo $reg['idPropiedad']; ?>').click();" name="fileToUpload" id="fileToUpload" accept="image/x-png,image/gif,image/jpeg">
                                        <input type="hidden" name="idPropiedad" id="idPropiedad" value="<?php echo $reg['idPropiedad']; ?>">
                                        <input type="submit" id="btnSubirFot<?php echo $reg['idPropiedad']; ?>" style="display: none;" value="Subir" name="submit">
                                    </form>
                                </td>
*/
                                ?>
                                <td><input class="numescritura" type="hidden" value="<?php echo $reg['numescritura'] ?>">
                                    <input class="fechaEscritura" type="hidden" value="<?php echo $reg['fechaEscritura'] ?>">
                                    <input class="licEscritura" type="hidden" value="<?php echo $reg['licEscritura'] ?>">
                                    <input class="numNotaria" type="hidden" value="<?php echo $reg['numNotaria'] ?>">
                                    <input class="predial" type="hidden" value="<?php echo $reg['predial'] ?>">
                                    <input class="folioMercantil" type="hidden" value="<?php echo $reg['folioMercantil'] ?>">
                                    <input class="superficie" type="hidden" value="<?php echo $reg['superficie'] ?>">
                                    <input class="comprende" type="hidden" value="<?php echo $reg['comprende'] ?>">
                                    <input class="amueblada" type="hidden" value="<?php echo $reg['amueblada'] ?>">
                                    <button type="button" data-toggle="popover-custom-content" rel="popover-focus" popover-id="C<?php echo $reg['idPropiedad'] ?>" class="mr-2 mb-2 btn btn-dark">Ver <?php echo count($reg['contratos']); ?> Contratos</button>
                                    <?php if ($consultar) { ?><a href="index.php?p=consultaPropiedad&idPropiedad=<?php echo $reg['idPropiedad'] ?>" class="btn btn-secondary mb-1 ml-1">Consultar </a><?php } ?>


                                    <?php if ($editar) { ?><a href="#" class="btn btn-primary mb-1 ml-1" data-role="updateMisPropiedades" data-id="<?php echo $reg['idPropiedad'] ?>">Actualizar</a><?php } ?>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>

                </table>
            </div>
        </div>




        <?php foreach ($registros as $reg) { ?>
            <div id="popover-content-C<?php echo  $reg['idPropiedad'] ?>" class="d-none">
                <div class="dropdown-menu-header">
                    <div class="dropdown-menu-header-inner bg-primary">
                        <div class="menu-header-image opacity-5" style="background-image: url('assets/images/dropdown-header/abstract2.jpg');"></div>
                        <div class="menu-header-content">
                            <a class="btn btn-warning" href="index.php?p=crearContrato&idPropiedad=<?php echo $reg['idPropiedad'] ?>">Crear Contrato</a>
                            <h5 class="menu-header-title">Contratos</h5>

                        </div>
                    </div>
                </div>
                <table style="width: 100%;" id="componentes" class="table table-hover table-striped table-bordered ">
                    <thead>
                        <tr>
                            <th># Contrato</th>
                            <th>Inquilino</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Renta</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reg['contratos'] as $ins) { ?>
                            <tr>


                                <td><?php echo strtoupper($ins['idContrato']) ?></td>
                                <td><?php echo strtoupper($ins['nombreInquilino']) ?></td>
                                <td><?php echo strtoupper($ins['fechaIni']) ?></td>
                                <td><?php echo strtoupper($ins['fechaFin']) ?></td>
                                <td><?php echo "$ " . number_format($ins['renta'], 2, '.', '') ?></td>
                                <td><?php if ($ins['estatus'] == 1) {
                                        echo "VIGENTE";
                                    } else {
                                        echo "NO VIGENTE";
                                    } ?></td>
                                <td><a href="imprimirContrato.php?idContrato=<?php echo $ins['idContrato']; ?>" target="_blank"><button type="button" class="mb-2 mr-2 btn-icon btn-icon-only btn btn-dark"><i class="pe-7s-print btn-icon-wrapper"> </i></button></a></td>
                                <td> <?php if ($ins['archivo'] != "") { ?>
                                        <a href="archivos/<?php echo $ins['archivo'] ?>"> <img src="imagenes/contrato.png" height="20px"></a>
                                    <?php }
                                        if ($ins['estatus'] == 1) {
                                    ?>
                                        <a href="#" class="btn btn-primary" data-role="subirContrato" data-id="<?php echo $ins['idContrato'] ?>">Subir Contrato </a>
                                    <?php } ?>
                                </td>

                            </tr>
                        <?php } ?>



                    </tbody>

                </table>
            </div>
        <?php } ?>

        <!-- hasta aqui llega-->

    </div>
    <?php include_once('footer.php') ?>
</div>
<script>
    $(document).ready(function() {
        $('#propiedades').DataTable({
            "lengthMenu": [
                [100, 200, -1],
                [100, 200, "Todos"]
            ]
        });
    });
</script>