<?php 

include_once './controllers/UsuariosController.php';

$controller = new UsuariosController();

$idAdmin = $_POST['idAdmin'] ;
$tipo = $_POST['tipo'] ;

if ($idAdmin != "" && $tipo=="update") {
    
    $nombreAdmin = $_POST['nombreAdmin'] ;
    $correoAdmin = $_POST['correoAdmin'] ;
    $rfcAdmin = $_POST['rfcAdmin'] ;
    $telefonoAdmin = $_POST['telefonoAdmin'] ;
    $apellidosAdmin = $_POST['apellidosAdmin'] ;
    $factura = $_POST['factura'] ;
    $idPerfil = $_POST['idPerfil'] ;

    $banco = $_POST['banco'] ;
    $cuenta = $_POST['cuenta'] ;
    $clabe = $_POST['clabe'] ;




    
    $respuesta = $controller->actualizarUsuario($nombreAdmin, $apellidosAdmin,$correoAdmin,
    $telefonoAdmin, $idAdmin,$rfcAdmin,$idPerfil,$factura,$banco,$cuenta,$clabe);
    if ($respuesta->exito) {
      echo '{"exito":true}';
    }
    else
    {
        echo $respuesta->mensaje;
    }
}



?>