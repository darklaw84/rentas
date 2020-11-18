<?php


if (!isset($_SESSION['nombreUsr'])) {
    echo "<script>window.setTimeout(function() { window.location = 'login.php' }, 10);</script>";
}
include_once './controllers/PerfilesController.php';
//asignacion de permisos

$perCont = new PerfilesController();

$permisos = $_SESSION['permisos'];

$agregar = false;
$editar = false;
$consultar = false;


foreach ($permisos as $per) {
    if ($per['modulo'] == "Perfiles") {
        if ($per['accion'] == "Agregar") {
            $agregar = true;
        }
        if ($per['accion'] == "Editar") {
            $editar = true;
        }
        if ($per['accion'] == "Consultar") {
            $consultar = true;
        }
    }
}


if (!$consultar) {
    echo "<script>window.setTimeout(function() { window.location = 'index.php' }, 10);</script>";
}

//-----------


$opcion = "";
if (isset($_POST['opcion'])) {
    $opcion = $_POST['opcion'];
}

$nombre = "";
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
}

$idPerfil = "";
if (isset($_POST['idPerfil'])) {
    $idPerfil = $_POST['idPerfil'];
}


$idModuloDisponible = "";
if (isset($_POST['idModuloDisponible'])) {
    $idModuloDisponible = $_POST['idModuloDisponible'];
}


$idModuloAsignado = "";
if (isset($_POST['idModuloAsignado'])) {
    $idModuloAsignado = $_POST['idModuloAsignado'];
}


$idModuloDisponible = "";
if (isset($_POST['idModuloDisponible'])) {
    $idModuloDisponible = $_POST['idModuloDisponible'];
}


$idAccionAsignada = "";
if (isset($_POST['idAccionAsignada'])) {
    $idAccionAsignada = $_POST['idAccionAsignada'];
}


$idAccionDisponible = "";
if (isset($_POST['idAccionDisponible'])) {
    $idAccionDisponible = $_POST['idAccionDisponible'];
}


if ($opcion == "quitarModulo") {
    // si entra aqui mandamos 
    $perCont->quitarModuloPerfil($idPerfil, $idModuloAsignado);
}


if ($opcion == "asignarModulo") {
    $perCont->agregarModuloPerfil($idPerfil, $idModuloDisponible);
    $idModuloAsignado=$idModuloDisponible;
    $idModuloDisponible="";
}


if ($opcion == "quitarAccion") {
    // si entra aqui mandamos 
    $perCont->quitarAccionModuloPerfil($idPerfil, $idModuloAsignado,$idAccionAsignada);
}


if ($opcion == "asignarAccion") {
    $perCont->agregarAccionModuloPerfil($idPerfil, $idModuloAsignado,$idAccionDisponible);
  
}



if ($nombre != "") {
    //quiere decir que debemos de insertar el Perfil
    $idPerfil = $perCont->agregarPerfil($nombre)->valor;
}


$perfiles = $perCont->obtenerPerfiles()->registros;


if ($idPerfil != "") {
    //cargamos sus modulos agregados y los disponibles

    $disponibles = $perCont->obtenerModulosDisponiblesPerfil($idPerfil)->registros;
    $utilizados = $perCont->obtenerModulosPerfil($idPerfil)->registros;


    if (count($utilizados) > 0 && $idModuloAsignado == "") {
        $idModuloAsignado = $utilizados[0]['idModulo'];
    }
    
    $aunEsta=false;
    foreach($utilizados as $uti)
    {
        if($uti['idModulo']==$idModuloAsignado)
        {
            $aunEsta=true;
        }
    }
    if(count($utilizados) > 0 && !$aunEsta)
    {
        $idModuloAsignado = $utilizados[0]['idModulo'];
    }
}


if ($idModuloAsignado != "") {
    //vamos a buscar sus acciones asignadas y sus no asignadas
    $accioneasasignadas = $perCont->obtenerAccionesAsignadas($idPerfil, $idModuloAsignado)->registros;
    $accionesdisponibles = $perCont->obtenerAccionesNoAsignadas($idPerfil, $idModuloAsignado)->registros;
}


?>




<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-users icon-gradient bg-ripe-malin"></i>
                    </div>
                    <div>Perfiles
                        <div class="page-title-subheading">.</div>
                    </div>
                </div>
                <div class="page-title-actions">

                </div>
            </div>
        </div>

        <!-- aqui va el contenido de la página -->
        <div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Administración de Perfiles</h5>
                    <form id="formulario" class="col-md-10 mx-auto" method="post" action="index.php?p=perfiles">
                        <input type="hidden" name="opcion" id="opcion">
                        <div class="form-group mb-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nombre">Nuevo Perfil</label>
                                    <div>
                                        <input type="text" maxlength="50" class="form-control" id="nombre" name="nombre" placeholder="Perfil" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="nombre">&nbsp;</label>
                                    <div>
                                        <?php if ($agregar) { ?>
                                            <button type="submit" class="btn btn-primary">Agregar Perfil</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group mt-4">
                            <label for="apellidos">Perfil</label>
                            <div>
                                <select onchange="this.form.submit()" class="form-control form-control " name="idPerfil" id="idPerfil">
                                    <option value="" <?php if (isset($idPerfil) && $idPerfil == "") {
                                                            echo "selected";
                                                        } ?>>- Selecciona-</option>
                                    <?php foreach ($perfiles as $per) {
                                        if (isset($idPerfil)) {
                                            if ($idPerfil == $per['idPerfil']) {
                                                $verselected = "selected";
                                            } else {
                                                $verselected = "";
                                            }
                                        } else {
                                            $verselected = "";
                                        }
                                        echo '<option value="' . $per['idPerfil'] . '" ' . $verselected
                                            . '  >' . strtoupper($per['perfil']) . '</option>';
                                    } ?>
                                </select> </div>
                        </div>

                        <?php if ($idPerfil != "") { ?>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="apellidos">Módulos Asignados</label>
                                        <div>
                                            <select onchange="this.form.submit()" class="form-control form-control " name="idModuloAsignado" id="idModuloAsignado">

                                                <?php foreach ($utilizados as $per) {
                                                    if (isset($idModuloAsignado)) {
                                                        if ($idModuloAsignado == $per['idModulo']) {
                                                            $verselected = "selected";
                                                        } else {
                                                            $verselected = "";
                                                        }
                                                    } else {
                                                        $verselected = "";
                                                    }
                                                    echo '<option value="' . $per['idModulo'] . '" ' . $verselected
                                                        . '  >' . strtoupper($per['modulo']) . '</option>';
                                                } ?>
                                            </select> </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="nombre">&nbsp;</label>
                                        <div>
                                            <?php if ($editar) { ?>
                                                <button type="button" id="btnQuitarModulo" class="btn btn-primary">Quitar Módulo</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="apellidos">Módulos Disponibles</label>
                                        <div>
                                            <select class="form-control form-control " name="idModuloDisponible" id="idModuloDisponible">

                                                <?php foreach ($disponibles as $per) {
                                                    if (isset($idModuloDisponible)) {
                                                        if ($idModuloDisponible == $per['idModulo']) {
                                                            $verselected = "selected";
                                                        } else {
                                                            $verselected = "";
                                                        }
                                                    } else {
                                                        $verselected = "";
                                                    }
                                                    echo '<option value="' . $per['idModulo'] . '" ' . $verselected
                                                        . '  >' . strtoupper($per['modulo']) . '</option>';
                                                } ?>
                                            </select> </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="nombre">&nbsp;</label>
                                        <div>
                                            <?php if ($editar) { ?>
                                                <button type="button" id="btnAsignarModulo" class="btn btn-primary">Asignar Módulo</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                            </div>



                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="apellidos">Acciones Asignadas</label>
                                        <div>
                                            <select onchange="this.form.submit()" class="form-control form-control " name="idAccionAsignada" id="idAccionAsignada">

                                                <?php if (isset($accioneasasignadas)) {
                                                    foreach ($accioneasasignadas as $per) {
                                                        if (isset($idAccionAsignada)) {
                                                            if ($idAccionAsignada == $per['idAccion']) {
                                                                $verselected = "selected";
                                                            } else {
                                                                $verselected = "";
                                                            }
                                                        } else {
                                                            $verselected = "";
                                                        }
                                                        echo '<option value="' . $per['idAccion'] . '" ' . $verselected
                                                            . '  >' . strtoupper($per['accion']) . '</option>';
                                                    }
                                                } ?>
                                            </select> </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="nombre">&nbsp;</label>
                                        <div>
                                            <?php if ($editar) { ?>
                                                <button type="button" id="btnQuitarAccion" class="btn btn-primary">Quitar Acción</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="apellidos">Acciones Disponibles</label>
                                        <div>
                                            <select class="form-control form-control " name="idAccionDisponible" id="idAccionDisponible">

                                                <?php
                                                if (isset($accionesdisponibles)) {
                                                    foreach ($accionesdisponibles as $per) {
                                                        if (isset($idAccionDisponible)) {
                                                            if ($idAccionDisponible == $per['idAccion']) {
                                                                $verselected = "selected";
                                                            } else {
                                                                $verselected = "";
                                                            }
                                                        } else {
                                                            $verselected = "";
                                                        }
                                                        echo '<option value="' . $per['idAccion'] . '" ' . $verselected
                                                            . '  >' . strtoupper($per['accion']) . '</option>';
                                                    }
                                                } ?>
                                            </select> </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="nombre">&nbsp;</label>
                                        <div>
                                            <?php if ($editar) { ?>
                                                <button type="button" id="btnAsignarAccion" class="btn btn-primary">Asignar Acción</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        <?php
                        }

                        ?>




                    </form>
                </div>
            </div>
        </div>



        <!-- hasta aqui llega-->

    </div>
    <?php include_once('footer.php') ?>
</div>