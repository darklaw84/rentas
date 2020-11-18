<?php

include_once './config/database.php';
include_once './models/UsuariosModel.php';


class UsuariosController
{


    public function __construct()
    {
    }


    function obtenerUsuarios($tipo)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new UsuariosModel($db);
        $respuesta = $clase->obtenerUsuarios($tipo);

        return $respuesta;
    }


    function obtenerInquilinos()
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new UsuariosModel($db);
        $respuesta = $clase->obtenerInquilinos();

        return $respuesta;
    }
   

    function agregarUsuario($usuario,$nombre, $apellidos, $correo, $telefono, $password,$rfc,$idPerfil,$tipoPersona,$factura)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new UsuariosModel($db);
        $respuesta = $clase->agregarUsuario($usuario,$nombre, $apellidos, $correo, $telefono, $password,$rfc,$idPerfil,$tipoPersona,$factura);

        return $respuesta;
    }

    function actualizarUsuario($nombre, $apellidos, $correo, $telefono, $idUsuario,$rfc,$idPerfil,$factura)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new UsuariosModel($db);
        $respuesta = $clase->actualizarUsuario($nombre, $apellidos, $correo, $telefono, $idUsuario,$rfc,$idPerfil,$factura);
        return $respuesta;
    }


    function actualizarPassAdministrador( $idUsuario,$password)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new UsuariosModel($db);
        $respuesta = $clase->actualizarPassAdministrador( $idUsuario,$password);
        return $respuesta;
    }


    


    function actualizarParametro($nombreParametro, $valorParametro)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new UsuariosModel($db);
        $respuesta = $clase->actualizarParametro($nombreParametro, $valorParametro);
        return $respuesta;
    }



    function toggleUsuario($idAdministrador, $activo)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new UsuariosModel($db);
        $respuesta = $clase->toggleUsuario($idAdministrador, $activo);
        return $respuesta;
    }

    function actualizarPassword($idUsuario, $passanterior, $passnuevo)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new UsuariosModel($db);
        $respuesta = $clase->actualizarPassword($idUsuario, $passanterior, $passnuevo);
        return $respuesta;
    }


    function  obtenerValorParametro($nombreParametro)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new UsuariosModel($db);
        $respuesta = $clase-> obtenerValorParametro($nombreParametro);
        return $respuesta;
    }


   
}
