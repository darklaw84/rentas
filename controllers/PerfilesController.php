<?php

include_once './config/database.php';
include_once './models/PerfilesModel.php';


class PerfilesController
{


    public function __construct()
    {
    }


    function obtenerPermisosPerfil($idPerfil)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PerfilesModel($db);
        $respuesta = $clase->obtenerPermisosPerfil($idPerfil);

        return $respuesta;
    }

    function agregarPerfil($perfil)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PerfilesModel($db);
        $respuesta = $clase->agregarPerfil($perfil);

        return $respuesta;
    }

    function obtenerModulosDisponiblesPerfil($perfil)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PerfilesModel($db);
        $respuesta = $clase->obtenerModulosDisponiblesPerfil($perfil);

        return $respuesta;
    }


    function obtenerAccionesAsignadas($perfil,$idModulo)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PerfilesModel($db);
        $respuesta = $clase->obtenerAccionesAsignadas($perfil,$idModulo);

        return $respuesta;
    }


    function obtenerAccionesNoAsignadas($perfil,$idModulo)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PerfilesModel($db);
        $respuesta = $clase->obtenerAccionesNoAsignadas($perfil,$idModulo);

        return $respuesta;
    }


    function quitarModuloPerfil($perfil,$idModulo)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PerfilesModel($db);
        $respuesta = $clase->quitarModuloPerfil($perfil,$idModulo);

        return $respuesta;
    }

    function quitarAccionModuloPerfil($perfil,$idModulo,$idAccion)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PerfilesModel($db);
        $respuesta = $clase->quitarAccionModuloPerfil($perfil,$idModulo,$idAccion);

        return $respuesta;
    }


    function agregarAccionModuloPerfil($perfil,$idModulo,$idAccion)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PerfilesModel($db);
        $respuesta = $clase->agregarAccionModuloPerfil($perfil,$idModulo,$idAccion);

        return $respuesta;
    }

    

    

    function agregarModuloPerfil($perfil,$idModulo)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PerfilesModel($db);
        $respuesta = $clase->agregarModuloPerfil($perfil,$idModulo);

        return $respuesta;
    }

    function obtenerModulosPerfil($perfil)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PerfilesModel($db);
        $respuesta = $clase->obtenerModulosPerfil($perfil);

        return $respuesta;
    }


    function obtenerPerfiles()
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PerfilesModel($db);
        $respuesta = $clase->obtenerPerfiles();

        return $respuesta;
    }

    

   
}
