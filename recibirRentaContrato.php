<?php 

include_once './controllers/PropiedadesController.php';
include_once './utilMail.php';
include_once './generarRecibo.php';

$controller = new PropiedadesController();
$utilMail = new UtilMail();

$generarRecibo = new GenerarRecibo();
$idRentaContrato = $_POST['idRentaContrato'] ;


if ($idRentaContrato != "") {
    
    $usuario = $_POST['usuario'] ;
    $idMetodoPago = $_POST['metodoPago'] ;
   
    
    
    $respuesta = $controller->recibirPagoRenta($idRentaContrato, $usuario,$idMetodoPago);
    $idRecibo = $controller->agregarRecibo($idRentaContrato)->valor;

            //tenemos que generar el recibo
            $nombreRecibo = $generarRecibo->generarRecibo($idRecibo);
           $correo= $controller->obtenerCorreoRecibo($idRecibo)->registros[0]['correo'];
            //se manda el correo
            $contenido=$controller->obtenerContenidoCorreoRecibo();
            $utilMail->enviarCorreoPagoRealizado($correo,"Recibo de pago",$contenido,$nombreRecibo);
    if ($respuesta->exito) {
      echo '{"exito":true}';
    }
    else
    {
        echo $respuesta->mensaje;
    }
}



?>