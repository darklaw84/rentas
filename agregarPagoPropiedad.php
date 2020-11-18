<?php

include_once './controllers/PropiedadesController.php';

$controller = new PropiedadesController();

$idPropiedad = $_POST['idPropiedad'];
if (isset($_POST['idContrato'])) {
  $idContrato = $_POST['idContrato'];
} else {
  $propiedad = $controller->obtenerPropiedad($idPropiedad)->registros[0];
  $contratos = $propiedad['contratos'];
  foreach ($contratos as $contra) {
    if ($contra['estatus'] == 1) {
      $idContrato = $contra['idContrato'];
    }
  }
}

$usuario = $_POST['usuario'];
$monto = $_POST['monto'];
$descripcion = $_POST['descripcion'];
$tipo = $_POST['tipo'];



$respuesta = $controller->agregarPagoContrato(
  $descripcion,
  $idContrato,
  $monto,
  $idPropiedad,
  $tipo,
  $usuario
);
if ($respuesta->exito) {
  echo '{"insertado":' . $respuesta->valor . '}';
} else {
  echo $respuesta->mensaje;
}
