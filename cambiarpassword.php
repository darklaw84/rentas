<?php 

include_once './controllers/AdministradorController.php';

$controller = new AdministradorController();

$idAdminPass = $_POST['idAdminPass'] ;



    
    $nuevoPassAdmin = $_POST['nuevoPassAdmin'] ;
  
    
    $respuesta = $controller->actualizarPassAdministrador($idAdminPass, md5($nuevoPassAdmin));
    if ($respuesta->exito) {
      echo "aqui puedes mandar un json, pero aqui no lo ocupamos";
    }
    else
    {
        echo $respuesta->mensaje;
    }




?>