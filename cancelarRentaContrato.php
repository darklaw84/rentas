<?php 

include_once './controllers/PropiedadesController.php';

$controller = new PropiedadesController();
$idRentaContrato = $_POST['idRentaContrato'] ;


if ($idRentaContrato != "") {
    
    $usuario = $_POST['usuario'] ;
    
   
    
    
    $respuesta = $controller->cancelarPagoRenta($idRentaContrato, $usuario,$idMetodoPago);
    

    if ($respuesta->exito) {
      echo '{"exito":true}';
    }
    else
    {
        echo $respuesta->mensaje;
    }
}



?>