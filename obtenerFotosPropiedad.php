<?php

include_once './controllers/PropiedadesController.php';

$controller = new PropiedadesController();

$idPropiedad=$_POST['idPropiedad'];



$respuesta = $controller->obtenerFotosPropiedad(
  $idPropiedad
);

echo json_encode($respuesta);
