<?php

include_once './controllers/PropiedadesController.php';

$controller = new PropiedadesController();

$idContrato = $_POST['idContrato'];
$rfcaval = $_POST['rfc'];
$domicilioAval = $_POST['domicilio'];
$domicilioInmueble = $_POST['inmueble'];
$numEscrituraArrendatario = $_POST['escritura'];
$fechaEscrituraArrendatario = $_POST['fecha'];
$notariaArrendatario = $_POST['notaria'];
$folioMercantilArrendatario = $_POST['folio'];
$licenciadoArrendatario = $_POST['licenciado'];
$aval = $_POST['nombre'];




$respuesta = $controller->actualizarContrato(
  $aval,
  $numEscrituraArrendatario,
  $fechaEscrituraArrendatario,
  $licenciadoArrendatario,
  $notariaArrendatario,
  $folioMercantilArrendatario,
  $rfcaval,
  $domicilioInmueble,
  $domicilioAval,
  $idContrato
);

echo json_encode($respuesta);
