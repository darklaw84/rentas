<?php

include_once './controllers/PropiedadesController.php';
$controller = new PropiedadesController();

if (isset($_GET['idContrato'])) {
    $idContrato = $_GET['idContrato'];
}
if (isset($_POST['idContrato'])) {
    $idContrato = $_POST['idContrato'];
}

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

if ($entro == "1") {
    $controller->actualizarTextoContrato($idContrato, $_POST['tiny']);
}

$contrato = $controller->obtenerContrato($idContrato)->registros[0];

$textoContrato = str_replace("
", "", $contrato['textoContrato']);


?>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <h3>Edición Contrato</h3>
        </div>

        <!-- aqui va el contenido de la página -->
        <form method="POST" action="index.php?p=mostrarContrato">
            <div class="row">
                <div class="col-12">
                <button type="submit" class="mb-2 mr-2 btn btn-success"> Guardar</button>
                <a href="imprimirContrato.php?idContrato=<?php echo $idContrato; ?>" target="_blank"><button type="button" title="Imprimir Contrato" class="mb-2 mr-2 btn-icon btn-icon-only btn btn-dark"><i class="pe-7s-print btn-icon-wrapper"> </i></button></a>
                <a href="index.php?p=consultaPropiedad&idPropiedad=<?php echo $idPropiedad; ?>" ><button type="button" title="Volver a la propiedad" class="mb-2 mr-2 btn btn-danger">Volver</button></a>
                </div>
            </div>

            <input type="hidden" name="entro" value="1">
            <input type="hidden" name="idContrato" value="<?php echo $idContrato; ?>">
            <input type="hidden" name="idPropiedad" value="<?php echo $idPropiedad; ?>">
            <div class="row mt-1">
                <div class="col-12">

                    <div>
                        <textarea name="tiny" id="tiny"></textarea>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>


<script>
    tinymce.init({
        selector: 'textarea#tiny',
        height: 500,
        init_instance_callback: "insert_contents",
    });

    function insert_contents(inst) {
        inst.setContent('<?php echo $textoContrato; ?>');
    }
</script>