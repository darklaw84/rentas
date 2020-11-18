<?php

include_once './controllers/PropiedadesController.php';

$controller = new PropiedadesController();

$idProp = $_POST['idProp'];


if ($idProp != "") {

  $nombre = $_POST['nombre'];
  $descripcion = $_POST['descripcion'];
  $direccion = $_POST['direccion'];
  $renta = $_POST['renta'];
  $fotografia = "";

  $superficie = $_POST['superficie'];
  $predial = $_POST['predial'];
  $comprende = $_POST['comprende'];
  $numescritura = $_POST['numescritura'];
  $fechaEscritura = $_POST['fechaEscritura'];
  $numNotaria = $_POST['numNotaria'];
  $folioMercantil = $_POST['folioMercantil'];
  $licEscritura = $_POST['licEscritura'];
  $amueblada = $_POST['amueblada'];


  $respuesta = $controller->actualizarPropiedad(
    $direccion,
    $descripcion,
    $nombre,
    $renta,
    $fotografia,
    $idProp,
    $superficie,
    $comprende,
    $numescritura,
    $fechaEscritura,
    $numNotaria,
    $folioMercantil,
    $licEscritura,
    $predial,
    $amueblada
  );
  if ($respuesta->exito) {
    echo '{"exito":true}';
  } else {
    echo $respuesta->mensaje;
  }
}
