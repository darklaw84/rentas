<?php
include_once './controllers/PerfilesController.php';
include_once './controllers/CatalogosController.php';
include_once './controllers/PropiedadesController.php';

$contPerf = new PerfilesController();


$contcat = new CatalogosController();
$controller = new PropiedadesController();

$perfiles = $contPerf->obtenerPerfiles()->registros;


$metodos = $contcat->obtenerMetodosPago()->registros;


$verTodas = false;

foreach ($permisos as $per) {
    if ($per['modulo'] == "Mis Propiedades") {

        if ($per['accion'] == "Ver Todas") {
            $verTodas = true;
        }
    }
}


if ($verTodas) {
    $respuesta = $controller->obtenerPropiedades();
    $propiedades = $respuesta->registros;
} else {


    $respuesta = $controller->obtenerPropiedadesUsuario($_SESSION['idUsr']);
    $propiedades = $respuesta->registros;
}

?>






<div id="modalActualizarContrato" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Actualizar Contrato</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">
                    <h5 class="card-title">Datos Aval</h5>

                    <div class="row mt-3">
                        <div class="col-md-8">
                            <label for="nombre">Nombre</label>
                            <div>
                                <input type="text" required class="form-control" id="nombreavalAct" name="nombreavalAct" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="nombre">RFC</label>
                            <div>
                                <input type="text" required class="form-control" id="rfcavalAct" name="rfcavalAct" />
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3 mt-3">
                        <div class="col-md-12">
                            <label for="nombre">Domicilio</label>
                            <div>
                                <input type="text" required class="form-control" id="domicilioavalAct" name="domicilioavalAct" />
                            </div>
                        </div>


                    </div>
                    <h5 class="card-title">Datos Inmueble Aval</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nombre">Domicilio Inmueble</label>
                            <div>
                                <input type="text" required class="form-control" id="domicilioInmuebleAct" name="domicilioInmuebleAct" />
                            </div>
                        </div>


                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-6 col-md-4">
                            <label for="nombre"># Escritura</label>
                            <div>
                                <input type="text" required class="form-control" id="numescrituraAct" name="numescrituraAct" />
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <label for="nombre">Fecha Escritura</label>
                            <div>
                                <input type="date" required class="form-control" id="fechaescrituraAct" name="fechaescrituraAct" />
                            </div>
                        </div>
                        <div class=" col-md-4">
                            <label for="nombre"># Notaría</label>
                            <div>
                                <input type="number" required class="form-control" id="numNotariaAct" name="numNotariaAct" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class=" col-md-4">
                            <label for="nombre">Folio Mercantil</label>
                            <div>
                                <input type="text" required class="form-control" id="foliomercantilAct" name="foliomercantilAct" />
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="nombre">Licenciado</label>
                            <div>
                                <input type="text" required class="form-control" id="licenciadoinqAct" name="licenciadoinqAct" />
                            </div>
                        </div>

                    </div>



                    <input type="hidden" id="idContratoAct" />

                </div>

            </div>
            <div class="modal-footer">
                <a href="#" id="actualizarContrato" class="btn btn-primary pull-right">Actualizar</a>
            </div>
        </div>
    </div>
</div>




<div id="modalUsuariosUpdate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Actualizar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">


                    <div id="divFisicaM" class="row">
                        <div class="col-md-6">
                            <label for="nombre">Nombre</label>
                            <div>
                                <input type="text" maxlength="50" class="form-control" id="nombreAdmin" name="nombreAdmin" placeholder="Nombre" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos">Apellidos</label>
                            <div>
                                <input type="text" maxlength="50" class="form-control" id="apellidosAdmin" name="apellidosAdmin" placeholder="Apellidos" />
                            </div>
                        </div>
                    </div>
                    <div id="divMoralM" class="row">
                        <div class="col-md-12">
                            <label for="nombre">Razon Social</label>
                            <div>
                                <input type="text" maxlength="100" class="form-control" id="razonM" name="razonM" placeholder="Razon Social" />
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="rfcAdmin">RFC</label>
                            <div>
                                <input type="text" maxlength="50" class="form-control" id="rfcAdmin" name="rfcAdmin" placeholder="RFC" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="correo">Correo</label>
                            <div>
                                <input type="email" maxlength="100" class="form-control" id="correoAdmin" name="correoAdmin" placeholder="Correo" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="telefono">Teléfono</label>
                            <div>
                                <input type="text" maxlength="15" class="form-control" id="telefonoAdmin" name="telefonoAdmin" placeholder="Teléfono" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="idLineaIn">Perfil</label>
                            <div>
                                <select class=" form-control selectPerfil" name="idPerfilU" id="idPerfilU">

                                    <?php
                                    if (isset($perfiles)) {
                                        foreach ($perfiles as $uni) {
                                            echo '<option value="' . $uni['idPerfil'] . '"  >' .
                                                strtoupper($uni['perfil']) . '</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="rfcAdmin">Requiere Factura</label>
                            <div>
                                <input type="checkbox" name="facturaUs" id="facturaUs">
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>


                    <input type="hidden" id="idAdmin" />

                </div>

            </div>
            <div class="modal-footer">
                <a href="#" id="guardarAdmin" class="btn btn-primary pull-right">Actualizar</a>
            </div>
        </div>
    </div>
</div>



<div id="modalPropiedadesUpdate" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Actualizar Propiedad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">


                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <div>
                            <input type="text" maxlength="50" class="form-control" id="nombrePro" name="nombrePro" placeholder="Nombre" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Descripción</label>
                        <div>
                            <input type="text" maxlength="255" class="form-control" id="descripcionPro" name="descripcionPro" placeholder="Descripción" />
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <label for="rfcAdmin">Dirección</label>
                            <div>
                                <input type="text" maxlength="100" class="form-control" id="direccionPro" name="direccionPro" placeholder="Dirección" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="predialPro">Cuenta Predial</label>
                            <div>
                                <input type="text" maxlength="50" class="form-control" id="predialPro" name="predialPro" placeholder="Predial" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="correo">Renta</label>
                            <div>
                                <input type="number" maxlength="10" class="form-control" id="rentaPro" name="rentaPro" placeholder="Renta" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="cargo">Superficie m2</label>
                            <div>
                                <input type="number" required class="form-control" id="superficiePro" name="superficiePro" placeholder="Superficie" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="cargo">Construcción m2</label>
                            <div>
                                <input type="number" required class="form-control" id="construccionPro" name="construccionPro" placeholder="Construccion" />
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="nombre"># Escritura</label>
                            <div>
                                <input type="text" required class="form-control" id="numescrituraPro" name="numescrituraPro" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="nombre">Fecha Escritura</label>
                            <div>
                                <input type="date" required class="form-control" id="fechaescrituraPro" name="fechaescrituraPro" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="nombre"># Notaría</label>
                            <div>
                                <input type="number" required class="form-control" id="numNotariaPro" name="numNotariaPro" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 mt-3">
                        <div class="col-md-4">
                            <label for="nombre">Folio Mercantil</label>
                            <div>
                                <input type="text" required class="form-control" id="foliomercantilPro" name="foliomercantilPro" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nombre">Licenciado</label>
                            <div>
                                <input type="text" required class="form-control" id="licenciadoPro" name="licenciadoPro" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="cargo">Amueblada</label>
                            <div>
                                <input type="checkbox" name="amuebladaPro" id="amuebladaPro">
                            </div>
                        </div>

                    </div>



                    <input type="hidden" id="idProp" />

                </div>

            </div>
            <div class="modal-footer">
                <a href="#" id="guardarPropiedad" class="btn btn-primary pull-right">Actualizar</a>
            </div>
        </div>
    </div>
</div>





<div id="modalPagoRenta" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Recibir Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">

                    <label id="lblPreguntaRecibir"></label>

                    <input type="hidden" id="idRentaContrato" />

                    <input type="hidden" id="usuarioSesion" value="<?php echo $_SESSION['nombreUsr'] ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="correo">Método Pago</label>
                            <div>
                                <select class=" form-control " name="metodoPago" id="metodoPago">

                                    <?php



                                    if (isset($metodos)) {
                                        foreach ($metodos as $uni) {
                                            echo '<option value="' . $uni['idMetodoPago'] . '"  >' .
                                                strtoupper($uni['metodoPago']) . '</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" id="recibirRentaContrato" class="btn btn-primary pull-right">Recibir</a>
            </div>
        </div>
    </div>
</div>



<div id="modalPagoRentaRentas" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Recibir Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">

                    <label id="lblPreguntaRecibirRentas"></label>

                    <input type="hidden" id="idRentaContratoRentas" />

                    <input type="hidden" id="usuarioSesionRentas" value="<?php echo $_SESSION['nombreUsr'] ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="correo">Método Pago</label>
                            <div>
                                <select class=" form-control " name="metodoPagoRentas" id="metodoPagoRentas">

                                    <?php



                                    if (isset($metodos)) {
                                        foreach ($metodos as $uni) {
                                            echo '<option value="' . $uni['idMetodoPago'] . '"  >' .
                                                strtoupper($uni['metodoPago']) . '</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" id="recibirRentaContratoRentas" class="btn btn-primary pull-right">Recibir</a>
            </div>
        </div>
    </div>
</div>


<div id="modalXPagoRenta" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cancelar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">

                    <label id="lblPreguntaCancelar"></label>

                    <input type="hidden" id="idRentaContrato" />

                    <input type="hidden" id="usuarioSesion" value="<?php echo $_SESSION['nombreUsr'] ?>">


                </div>

            </div>
            <div class="modal-footer">
                <a href="#" id="cancelarRentaContrato" class="btn btn-primary pull-right">Cancelar</a>
            </div>
        </div>
    </div>
</div>




<div id="modalFotosPropiedad" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Fotos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="divFotosPropiedad" class="row">
                </div>

            </div>

        </div>
    </div>
</div>


<div id="modalAgregarPagoPropiedad" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Agregar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">


                    <div class="form-group">
                        <label for="nombre">Tipo</label>
                        <div>
                            <input type="checkbox" name="tipoPago" id="tipoPago" data-toggle="toggle" data-size="large" data-on="Ingreso" data-off="Egreso" data-onstyle="success" data-offstyle="danger">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Monto</label>
                        <div>
                            <input type="number" class="form-control" id="montoPago" name="montoPago" placeholder="$" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rfcAdmin">Descripción</label>
                        <div>
                            <input type="text" maxlength="200" class="form-control" id="descripcionPago" name="descripcionPago" placeholder="Descripción" />
                        </div>
                    </div>



                </div>

            </div>
            <div class="modal-footer">
                <a href="#" id="guardarPago" class="btn btn-primary pull-right">Agregar Pago</a>
            </div>
        </div>
    </div>
</div>




<div id="modalAgregarPagoPropiedadPagos" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Agregar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="correo">Propiedad</label>
                            <div>
                                <select class=" form-control " name="idPropiedadPagos" id="idPropiedadPagos">

                                    <?php



                                    if (isset($propiedades)) {
                                        foreach ($propiedades as $uni) {
                                            echo '<option value="' . $uni['idPropiedad'] . '"  >' .
                                                strtoupper($uni['nombre']) . '</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="nombre">Tipo</label>
                        <div>
                            <input type="checkbox" name="tipoPagoPagos" id="tipoPagoPagos" data-toggle="toggle" data-size="large" data-on="Ingreso" data-off="Egreso" data-onstyle="success" data-offstyle="danger">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Monto</label>
                        <div>
                            <input type="number" class="form-control" id="montoPagoPagos" name="montoPagoPagos" placeholder="$" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rfcAdmin">Descripción</label>
                        <div>
                            <input type="text" maxlength="200" class="form-control" id="descripcionPagoPagos" name="descripcionPagoPagos" placeholder="Descripción" />
                        </div>
                    </div>



                </div>

            </div>
            <div class="modal-footer">
                <a href="#" id="guardarPagoPagos" class="btn btn-primary pull-right">Agregar Pago</a>
            </div>
        </div>
    </div>
</div>


<div id="modalFoto" class="modal fade mensajeError" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" align="center">
                <img id="imagenArchivo" height="300px">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>


<div id="modalSubirContrato" style="position: fixed; left: 0;" class="modal fade right mensajeError" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" align="center">
                <form action="index.php?p=mispropiedades" method="POST" enctype="multipart/form-data">

                    <input type="file" type="" onchange="document.getElementById('btnSubirContra').click();" name="fileOtro" id="fileOtro">
                    <input type="hidden" name="idContrato" id="idContratoSubir">
                    <input type="submit" id="btnSubirContra" style="display: none;" value="Subir" name="submit">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>



<div id="modalAgregarInquilino" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Agregar Inquilino</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="correo">Tipo Persona</label>
                            <div>
                                <select class=" form-control " name="tipoPersonaIn" id="tipoPersonaIn">

                                    <option value="1">Física</option>
                                    <option value="0">Moral</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="correo">Requiere Factura</label>
                            <div>
                                <input type="checkbox" name="facturaIn" id="facturaIn">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre">Usuario</label>
                            <div>
                                <input type="text" required maxlength="50" class="form-control" id="usuarioInqui" name="usuarioInqui" placeholder="Usuario" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="cargo">RFC</label>
                            <div>
                                <input type="text" required maxlength="50" class="form-control" id="rfcInqui" name="rfcInqui" placeholder="RFC" />
                            </div>
                        </div>

                    </div>
                    <div id="divFisicaIn" class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre">Nombre</label>
                            <div>
                                <input type="text" maxlength="50" class="form-control" id="nombreInqui" name="nombreInqui" placeholder="Nombre" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos">Apellidos</label>
                            <div>
                                <input type="text" maxlength="50" class="form-control" id="apellidosInqui" name="apellidosInqui" placeholder="Apellidos" />
                            </div>
                        </div>

                    </div>
                    <div id="divMoralIn" class="row mb-3" style="display: none;">
                        <div class="col-md-12">
                            <label for="nombre">Razon Social</label>
                            <div>
                                <input type="text" maxlength="50" class="form-control" id="razonInqui" name="razonInqui" placeholder="Razon Social" />
                            </div>
                        </div>


                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="correo">Correo</label>
                            <div>
                                <input type="email" required maxlength="100" class="form-control" id="correoInqui" name="correoInqui" placeholder="Correo" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="correo">Teléfono</label>
                            <div>
                                <input type="text" required maxlength="15" class="form-control" id="telefonoInqui" name="telefonoInqui" placeholder="Teléfono" />
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <a href="#" id="guardarInquilino" class="btn btn-primary pull-right">Agregar Inquilino</a>
            </div>
        </div>
    </div>
</div>




<div id="modalAgregarArrendatario" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Agregar Arrendatario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre">Usuario</label>
                            <div>
                                <input type="text" required maxlength="50" class="form-control" id="usuarioArre" name="usuarioArre" placeholder="Usuario" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="cargo">RFC</label>
                            <div>
                                <input type="text" required maxlength="50" class="form-control" id="rfcArre" name="rfcArre" placeholder="RFC" />
                            </div>
                        </div>

                    </div>
                    <div id="divFisicaIn" class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre">Nombre</label>
                            <div>
                                <input type="text" maxlength="50" class="form-control" id="nombreArre" name="nombreArre" placeholder="Nombre" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos">Apellidos</label>
                            <div>
                                <input type="text" maxlength="50" class="form-control" id="apellidosArre" name="apellidosArre" placeholder="Apellidos" />
                            </div>
                        </div>

                    </div>


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="correo">Correo</label>
                            <div>
                                <input type="email" required maxlength="100" class="form-control" id="correoArre" name="correoArre" placeholder="Correo" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="correo">Teléfono</label>
                            <div>
                                <input type="text" required maxlength="15" class="form-control" id="telefonoArre" name="telefonoArre" placeholder="Teléfono" />
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <a href="#" id="guardarArrendatario" class="btn btn-primary pull-right">Agregar Arrendatario</a>
            </div>
        </div>
    </div>
</div>


<div id="modalEliminarPago" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">

                    <label>¿Esta seguro que desea eliminar el pago? </label>

                    <input type="hidden" id="idPagoContrato" />



                </div>

            </div>
            <div class="modal-footer">
                <a href="#" id="eliminarPagoContrato" class="btn btn-primary pull-right">Eliminar</a>
            </div>
        </div>
    </div>
</div>



<div id="modalEliminarPagoPagos" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">

                    <label>¿Esta seguro que desea eliminar el pago? </label>

                    <input type="hidden" id="idPagoContratoPagos" />



                </div>

            </div>
            <div class="modal-footer">
                <a href="#" id="eliminarPagoContratoPagos" class="btn btn-primary pull-right">Eliminar</a>
            </div>
        </div>
    </div>
</div>



<div id="modalMensajeError" class="modal fade mensajeError" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Mensaje</h5>
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