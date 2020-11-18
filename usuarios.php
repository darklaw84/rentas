<?php

include_once './controllers/UsuariosController.php';
if (!isset($_SESSION['nombreUsr'])) {
    echo "<script>window.setTimeout(function() { window.location = 'login.php' }, 10);</script>";
}
$controller = new UsuariosController();

include_once './controllers/PerfilesController.php';

$contPerf = new PerfilesController();

$perfiles = $contPerf->obtenerPerfiles()->registros;

$permisos = $_SESSION['permisos'];

$agregar = false;
$editar = false;
$consultar = false;
$activar = false;

foreach ($permisos as $per) {
    if ($per['modulo'] == "Usuarios") {
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

$entro = "";
if (isset($_POST['entro'])) {
    $entro = $_POST['entro'];
}

$tipo = "";
if (isset($_POST['p'])) {
    $tipo = $_POST['p'];
}

if (isset($_GET['p'])) {
    $tipo = $_GET['p'];
}

if (isset($_GET['entro'])) {
    $entro = $_GET['entro'];
}

if ($entro != "") {

    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $rfc = $_POST['rfc'];
    $password = $_POST['password'];
    $idPerfil = $_POST['idPerfil'];
    //  $tipoPersona = $_POST['tipoPersona'];
    $tipoPersona = 1;
    if ($nombre == "") {
        $nombre = $_POST['razon'];
    }

    $factura = 0;
    if (isset($_POST['factura'])) {
        $factura = 1;
    }



    if (
        $nombre == "" || $rfc == "" || $correo == "" ||
        $telefono == "" || $password == ""
    ) {
        $mensajeEnviar = "Todos los campos son obligatorios, por favor verifique";
    } else {



        $respuesta = $controller->agregarUsuario(
            $usuario,
            $nombre,
            $apellidos,
            $correo,
            $telefono,
            md5($password),
            $rfc,
            $idPerfil,
            $tipoPersona,
            $factura
        );

        if (!$respuesta->exito) {
            $mensajeEnviar = $respuesta->mensaje;
        } else {
            $nombre = "";
            $apellidos = "";
            $rfc = "";
            $correo = "";
            $telefono = "";
            $password = "";
            $usuario = "";
        }
    }
} else {
    if (isset($_GET['idUsuario'])) {
        $idUsuario = $_GET['idUsuario'];
        $activo = $_GET['activo'];
        if ($idUsuario != "") {
            $controller->toggleUsuario($idUsuario, $activo);
        }
    }
}
$respuesta = $controller->obtenerUsuarios($tipo);
$registros = $respuesta->registros;







?>




<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="lnr-user icon-gradient bg-ripe-malin"></i>
                    </div>
                    <div><?php if ($tipo == "usuarios") {
                                echo "Usuarios";
                            } else {
                                echo "Inquilinos";
                            } ?>
                        <div class="page-title-subheading">.</div>
                    </div>
                </div>
                <div class="page-title-actions">

                    <?php if ($tipo == "usuarios") { ?>
                        <button <?php if (!$agregar) {
                                    echo "disabled";
                                } ?> type="button" data-toggle="collapse" href="#collapseNuevoAdministrador" class="btn btn-primary">Nuevo Usuario</button>


                    <?php } ?> </div>
            </div>
        </div>

        <!-- aqui va el contenido de la página -->
        <div class="collapse" id="collapseNuevoAdministrador">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Nuevo Usuario</h5>
                    <form id="adminForm" class="col-md-10 mx-auto" method="post" action="index.php?p=<?php echo $tipo ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nombre">Usuario</label>
                                <div>
                                    <input type="text" required maxlength="50" class="form-control" id="usuario" name="usuario" value="<?php if (isset($usuario)) {
                                                                                                                                            echo strtoupper($usuario);
                                                                                                                                        } ?>" placeholder="Usuario" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password">Password</label>

                                <div>
                                    <input type="password" required class="form-control" id="password" name="password" placeholder="Password" />
                                </div>
                            </div>
                        </div>
                        <!--  <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="correo">Tipo Persona</label>
                                <div>
                                    <select class=" form-control " name="tipoPersona" id="tipoPersona">

                                        <option <?php if (isset($tipoPersona) && $tipoPersona == "1") {
                                                    echo "selected";
                                                } ?> value="1">Física</option>
                                        <option <?php if (isset($tipoPersona) && $tipoPersona == "0") {
                                                    echo "selected";
                                                } ?> value="0">Moral</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="correo">Requiere Factura</label>
                                <div>
                                    <input type="checkbox" name="factura" id="factura" data-toggle="toggle" data-size="large" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </div>
                        </div>
                                            -->
                        <div id="divFisica" class="row">
                            <div class="col-md-6">
                                <label for="nombre">Nombre</label>
                                <div>
                                    <input type="text" maxlength="50" class="form-control" id="nombre" name="nombre" value="<?php if (isset($nombre)) {
                                                                                                                                echo strtoupper($nombre);
                                                                                                                            } ?>" placeholder="Nombre" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="apellidos">Apellidos</label>
                                <div>
                                    <input type="text" maxlength="50" class="form-control" id="apellidos" name="apellidos" value="<?php if (isset($apellidos)) {
                                                                                                                                        echo strtoupper($apellidos);
                                                                                                                                    } ?>" placeholder="Apellidos" />
                                </div>
                            </div>

                        </div>
                        <div id="divMoral" style="display: none;" class="row">
                            <div class="col-md-12">
                                <label for="nombre">Razon Social</label>
                                <div>
                                    <input type="text" maxlength="100" class="form-control" id="razon" name="razon" value="<?php if (isset($nombre)) {
                                                                                                                                echo strtoupper($nombre);
                                                                                                                            } ?>" placeholder="Razón Social" />
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="correo">Correo</label>
                                <div>
                                    <input type="email" required maxlength="100" class="form-control" id="correo" name="correo" value="<?php if (isset($correo)) {
                                                                                                                                            echo strtoupper($correo);
                                                                                                                                        } ?>" placeholder="Correo" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="correo">Teléfono</label>
                                <div>
                                    <input type="text" required maxlength="15" class="form-control" id="telefono" name="telefono" value="<?php if (isset($telefono)) {
                                                                                                                                                echo strtoupper($telefono);
                                                                                                                                            } ?>" placeholder="Teléfono" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="idLineaIn">Perfil</label>
                                <div>
                                    <select required class=" form-control selectPerfil" name="idPerfil" id="idPerfil">

                                        <?php
                                        if (isset($perfiles)) {
                                            foreach ($perfiles as $uni) {
                                                if (isset($idPerfil)) {
                                                    if ($idPerfil == $uni['idPerfil']) {
                                                        $verselected = "selected";
                                                    } else {
                                                        $verselected = "";
                                                    }
                                                } else {
                                                    $verselected = "";
                                                }
                                                echo '<option value="' . $uni['idPerfil'] . '" ' . $verselected
                                                    . ' >' .
                                                    strtoupper($uni['perfil']) . '</option>';
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="cargo">RFC</label>
                                <div>
                                    <input type="text" required maxlength="50" class="form-control" id="rfc" name="rfc" value="<?php if (isset($rfc)) {
                                                                                                                                    echo strtoupper($rfc);
                                                                                                                                } ?>" placeholder="RFC" />
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
                <table style="width: 100%;" id="usuarios" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>USUARIO</th>
                            <th>PERFIL</th>
                            <th>NOMBRE</th>
                            <th>APELLIDOS</th>
                            <th>RFC</th>
                            <th>CORREO</th>
                            <th>TELÉFONO</th>
                            <th>ACTUALIZAR</th>
                            <th>ACTIVO</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registros as $reg) { ?>
                            <tr id="<?php echo $reg['idUsuario'] ?>">
                                <td data-target="usuario"><?php echo strtoupper($reg['usuario']) ?></td>
                                <td data-target="perfil"><?php echo strtoupper($reg['perfil']) ?></td>
                                <td data-target="nombre"><?php echo strtoupper($reg['nombre']) ?></td>
                                <td data-target="apellidos"><?php echo strtoupper($reg['apellidos']) ?></td>
                                <td data-target="rfc"><?php echo strtoupper($reg['rfc']) ?></td>
                                <td data-target="correo"><?php echo strtoupper($reg['correo']) ?></td>
                                <td data-target="telefono"><?php echo strtoupper($reg['telefono']) ?></td>
                                <td><?php if ($editar) { ?><a href="#" class="btn btn-primary" data-role="updateUsuarios" data-id="<?php echo $reg['idUsuario'] ?>">Actualizar</a><?php } ?></td>
                                <td>
                                    <input class="factura" type="hidden" value="<?php echo $reg['factura'] ?>">
                                    <input class="fisica" type="hidden" value="<?php echo $reg['fisica'] ?>">
                                    <input class="idPerfil" type="hidden" value="<?php echo $reg['idPerfil'] ?>"><?php if ($activar) { ?><a href="index.php?p=<?php echo $tipo; ?>&idUsuario=<?php echo $reg['idUsuario'] ?>&activo=<?php if ($reg['activo'] == 1) {
                                                                                                                                                                                                                                        echo "0";
                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                        echo "1";
                                                                                                                                                                                                                                    } ?>" class="btn btn-primary"><?php if ($reg['activo'] == 1) {
                                                                                                                                                                                                                                                                        echo "Desactivar";
                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                        echo "Activar";
                                                                                                                                                                                                                                                                    } ?></a><?php } ?></td>


                            </tr>
                        <?php } ?>

                    </tbody>

                </table>
            </div>
        </div>


        <!-- hasta aqui llega-->

    </div>
    <?php include_once('footer.php') ?>
</div>
<script>
    $(document).ready(function() {
        $('#usuarios').DataTable({
            "lengthMenu": [
                [100, 200, -1],
                [100, 200, "Todos"]
            ]
        });
    });
</script>