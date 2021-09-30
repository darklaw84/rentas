<?php

include_once './controllers/PropiedadesController.php';

$controller = new PropiedadesController();

$idTipo = $_POST['idTipo'];



$respuesta = $controller->obtenerContratosBase(
    $idMarca,
    true
);

echo json_encode($respuesta);
