<?php

include_once './config/database.php';
include_once './models/ExplocionModel.php';


class ExplocionController
{


    public function __construct()
    {
    }




    function obtenerExplocion($idCotizacion)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new ExplocionModel($db);
        $respuesta = $clase->obtenerExplocion($idCotizacion,$db,$this->obtenerTcCotizacion($idCotizacion));

        return $respuesta;
    }


    function obtenerTcCotizacion($idCotizacion)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new ExplocionModel($db);
        $respuesta = $clase->obtenerTcCotizacion($idCotizacion);

        return $respuesta;
    }


    

}
