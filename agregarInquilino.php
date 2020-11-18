<?php

include_once './controllers/UsuariosController.php';

$controller = new UsuariosController();

$usuarioInqui = $_POST['usuarioInqui'];
$nombreInqui = $_POST['nombreInqui'];
$correoInqui = $_POST['correoInqui'];
$apellidosInqui = $_POST['apellidosInqui'];
$rfcInqui = $_POST['rfcInqui'];
$telefonoInqui = $_POST['telefonoInqui'];
$requiereFactura = $_POST['requiereFactura'];
$tipoPersona = $_POST['tipoPersona'];



$respuesta = $controller->agregarUsuario(
  $usuarioInqui,
  $nombreInqui,
  $apellidosInqui,
  $correoInqui,
  $telefonoInqui,
 md5( $usuarioInqui),
  $rfcInqui,
  6,
  $tipoPersona,
  $requiereFactura
);

echo json_encode($respuesta);
