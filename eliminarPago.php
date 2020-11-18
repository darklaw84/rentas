<?php 

include_once './controllers/PropiedadesController.php';

$controller = new PropiedadesController();

$idPago = $_POST['idPago'] ;


if ($idPago != "") {
    
    
   
    
    
    $respuesta = $controller->eliminarPago($idPago);
    if ($respuesta->exito) {
      echo '{"exito":true}';
    }
    else
    {
        echo $respuesta->mensaje;
    }
}



?>