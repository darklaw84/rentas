<?php

include_once './config/database.php';
include_once './models/CatalogosModel.php';



class CatalogosController
{


    public function __construct()
    {
    }




    function obtenerMetodosPago()
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CatalogosModel($db);
        $respuesta = $clase->obtenerMetodosPago();

        return $respuesta;
    }


   



   
  
}
