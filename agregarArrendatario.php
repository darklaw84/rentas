<?php

include_once './controllers/UsuariosController.php';

$controller = new UsuariosController();

$usuarioInqui = $_POST['usuarioInqui'];
$nombreInqui = $_POST['nombreInqui'];
$correoInqui = $_POST['correoInqui'];
$apellidosInqui = $_POST['apellidosInqui'];
$rfcInqui = $_POST['rfcInqui'];
$telefonoInqui = $_POST['telefonoInqui'];

$banco = $_POST['banco'];
$cuenta = $_POST['cuenta'];
$clabe = $_POST['clabe'];



$respuesta = $controller->agregarUsuario(
  $usuarioInqui,
  $nombreInqui,
  $apellidosInqui,
  $correoInqui,
  $telefonoInqui,
 md5( $usuarioInqui),
  $rfcInqui,
  5,
  1,
  0,$banco,$cuenta,$clabe);

echo json_encode($respuesta);
