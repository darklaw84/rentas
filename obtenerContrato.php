<?php

include_once './controllers/PropiedadesController.php';

$controller = new PropiedadesController();

$idContrato = $_POST['idContrato'];




$respuesta = $controller->obtenerContrato($idContrato)->registros[0];

echo json_encode($respuesta);
