<?php

include_once 'RespuestaBD.php';



class PerfilesModel
{

    // database connection and table name
    private $conn;



    public function __construct($db)
    {
        $this->conn = $db;
    }


    function obtenerPerfiles()
    {


        $query = "SELECT  *  FROM  perfiles order by perfil";


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $arreglo = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $registro_item = array(
                    "idPerfil" => $idPerfil,
                    "perfil" => $perfil

                );

                array_push($arreglo, $registro_item);
            }
            $respuesta->mensaje = "";
            $respuesta->exito = true;
            $respuesta->registros = $arreglo;
        } else {
            $respuesta->mensaje = "No se encontraron datos ";
            $respuesta->exito = false;
        }


        return $respuesta;
    }


    function obtenerModulosDisponiblesPerfil($idPerfil)
    {


        $query = "SELECT  * from modulos where idModulo not in 
        (select idModulo from perfil_modulo_accion where idPerfil =" . $idPerfil . ") 
        order by modulo";


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $arreglo = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $registro_item = array(
                    "idModulo" => $idModulo,
                    "modulo" => $modulo

                );

                array_push($arreglo, $registro_item);
            }
            $respuesta->mensaje = "";
            $respuesta->exito = true;
            $respuesta->registros = $arreglo;
        } else {
            $respuesta->mensaje = "No se encontraron datos ";
            $respuesta->exito = false;
        }


        return $respuesta;
    }


    function obtenerAccionesAsignadas($idPerfil, $idModulo)
    {


        $query = " select a.idAccion,a.accion  from perfil_modulo_accion pma
        inner join acciones a on a.idAccion=pma.idAccion where pma.idPerfil =" . $idPerfil . " and pma.idModulo = " . $idModulo . "
        order by a.accion";


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $arreglo = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $registro_item = array(
                    "idAccion" => $idAccion,
                    "accion" => $accion

                );

                array_push($arreglo, $registro_item);
            }
            $respuesta->mensaje = "";
            $respuesta->exito = true;
            $respuesta->registros = $arreglo;
        } else {
            $respuesta->mensaje = "No se encontraron datos ";
            $respuesta->exito = false;
        }


        return $respuesta;
    }



    function obtenerAccionesNoAsignadas($idPerfil, $idModulo)
    {


        $query = " select a.idAccion,a.accion from modulo_acciones ma 
        inner join acciones a on a.idAccion = ma.idAccion 
        where ma.idModulo = " . $idModulo . " and ma.idAccion not in 
        (select idAccion  from perfil_modulo_accion 
         where idPerfil =" . $idPerfil . " and idModulo = " . $idModulo . "
       ) order by a.accion";


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $arreglo = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $registro_item = array(
                    "idAccion" => $idAccion,
                    "accion" => $accion

                );

                array_push($arreglo, $registro_item);
            }
            $respuesta->mensaje = "";
            $respuesta->exito = true;
            $respuesta->registros = $arreglo;
        } else {
            $respuesta->mensaje = "No se encontraron datos ";
            $respuesta->exito = false;
        }


        return $respuesta;
    }


    function obtenerModulosPerfil($idPerfil)
    {


        $query = "select m.idModulo,m.modulo from perfil_modulo_accion pma 
        inner join modulos m on m.idModulo = pma.idModulo where idPerfil =" . $idPerfil . "
        group by m.modulo order by m.modulo";


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $arreglo = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $registro_item = array(
                    "idModulo" => $idModulo,
                    "modulo" => $modulo

                );

                array_push($arreglo, $registro_item);
            }
            $respuesta->mensaje = "";
            $respuesta->exito = true;
            $respuesta->registros = $arreglo;
        } else {
            $respuesta->mensaje = "No se encontraron datos ";
            $respuesta->exito = false;
        }


        return $respuesta;
    }


    function obtenerAccionesModulo($idModulo)
    {


        $query = "select a.idAccion,a.accion from modulo_acciones ma 
        inner join acciones a on a.idAccion = ma.idAccion
        where idModulo=" . $idModulo . "
        
        ";


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $arreglo = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $registro_item = array(
                    "idAccion" => $idAccion,
                    "accion" => $accion

                );

                array_push($arreglo, $registro_item);
            }
            $respuesta->mensaje = "";
            $respuesta->exito = true;
            $respuesta->registros = $arreglo;
        } else {
            $respuesta->mensaje = "No se encontraron datos ";
            $respuesta->exito = false;
        }


        return $respuesta;
    }




    function obtenerPermisosPerfil($idPerfil)
    {


        $query = "select m.modulo,a.accion from perfil_modulo_accion pma  
        inner join acciones a on a.idAccion = pma.idAccion
        inner join modulos m on m.idModulo = pma.idModulo 
        where idPerfil=".$idPerfil;


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $arreglo = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $registro_item = array(
                    "accion" => $accion,
                    "modulo" => $modulo

                );

                array_push($arreglo, $registro_item);
            }
            $respuesta->mensaje = "";
            $respuesta->exito = true;
            $respuesta->registros = $arreglo;
        } else {
            $respuesta->mensaje = "No se encontraron datos ";
            $respuesta->exito = false;
        }


        return $respuesta;
    }








    function actualizarAdministrador($nombre, $apellidos, $correo, $telefono, $idUsuario, $cargo)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found


        // query to insert record
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                nombre=:nombre,apellidos=:apellidos,cargo=:cargo,
                correo=:correo,telefono=:telefono where idUsuario=:idUsuario";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $nombre = htmlspecialchars(strip_tags($nombre));
        $apellidos = htmlspecialchars(strip_tags($apellidos));
        $correo = htmlspecialchars(strip_tags($correo));
        $telefono = htmlspecialchars(strip_tags($telefono));
        $cargo = htmlspecialchars(strip_tags($cargo));



        // bind values
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellidos", $apellidos);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":idUsuario", $idUsuario);
        $stmt->bindParam(":cargo", $cargo);




        // execute query
        if ($stmt->execute()) {
            $respuesta->exito = true;
            $respuesta->mensaje = "";
            return $respuesta;
        } else {
            $respuesta->exito = false;
            $respuesta->mensaje = "Ocurrió un problema actualizando";
            return $respuesta;
        }
    }



    function quitarModuloPerfil($idPerfil, $idModulo)
    {

        $respuesta = new RespuestaBD();


        $query = "delete from perfil_modulo_accion where idPerfil = " . $idPerfil . " and idModulo=" . $idModulo . " ";

        // prepare query
        $stmt = $this->conn->prepare($query);


        // execute query
        if ($stmt->execute()) {
            $respuesta->exito = true;
            $respuesta->mensaje = "";
            return $respuesta;
        } else {
            $respuesta->exito = false;
            $respuesta->mensaje = "Ocurrió un problema actualizando";
            return $respuesta;
        }
    }


    function quitarAccionModuloPerfil($idPerfil, $idModulo,$idAccion)
    {

        $respuesta = new RespuestaBD();


        $query = "delete from perfil_modulo_accion where idPerfil = " . $idPerfil . " 
        and idModulo=" . $idModulo . " 
        and idAccion=" . $idAccion . " ";

        // prepare query
        $stmt = $this->conn->prepare($query);


        // execute query
        if ($stmt->execute()) {
            $respuesta->exito = true;
            $respuesta->mensaje = "";
            return $respuesta;
        } else {
            $respuesta->exito = false;
            $respuesta->mensaje = "Ocurrió un problema actualizando";
            return $respuesta;
        }
    }



    function agregarModuloPerfil($idPerfil, $idModulo)
    {

        $respuesta = new RespuestaBD();

        $acciones = $this->obtenerAccionesModulo($idModulo)->registros;

        foreach ($acciones as $acc) {
            $query = "insert into perfil_modulo_accion (idPerfil,idModulo,idAccion) values (" . $idPerfil . "," . $idModulo . "," . $acc['idAccion'] . ")";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        }


        $respuesta->exito = true;
        $respuesta->mensaje = "";
        return $respuesta;
    }


    function agregarAccionModuloPerfil($idPerfil, $idModulo,$idAccion)
    {

        $respuesta = new RespuestaBD();

        
            $query = "insert into perfil_modulo_accion (idPerfil,idModulo,idAccion)
             values (" . $idPerfil . "," . $idModulo . "," . $idAccion . ")";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        


        $respuesta->exito = true;
        $respuesta->mensaje = "";
        return $respuesta;
    }



    function actualizarParametro($nombreParametro, $valorParametro)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found


        // query to insert record
        $query = "UPDATE
                   parametros
                SET
                valorParametro=:valorParametro where nombreParametro=:nombreParametro";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":valorParametro", $valorParametro);
        $stmt->bindParam(":nombreParametro", $nombreParametro);

        // execute query
        if ($stmt->execute()) {
            $respuesta->exito = true;
            $respuesta->mensaje = "";
            return $respuesta;
        } else {
            $respuesta->exito = false;
            $respuesta->mensaje = "Ocurrió un problema actualizando";
            return $respuesta;
        }
    }




    function actualizarOrganizador(
        $nombre,
        $apellidos,
        $correo,
        $telefono,
        $idEstado,
        $organizacion,
        $idUsuario
    ) {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found


        // query to insert record
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                nombre=:nombre,apellidos=:apellidos,
                correo=:correo,telefono=:telefono,idEstado=:idEstado,organizacion=:organizacion where idUsuario=:idUsuario";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $nombre = htmlspecialchars(strip_tags($nombre));
        $apellidos = htmlspecialchars(strip_tags($apellidos));
        $correo = htmlspecialchars(strip_tags($correo));
        $telefono = htmlspecialchars(strip_tags($telefono));
        $organizacion = htmlspecialchars(strip_tags($organizacion));



        // bind values
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellidos", $apellidos);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":idUsuario", $idUsuario);
        $stmt->bindParam(":idEstado", $idEstado);
        $stmt->bindParam(":organizacion", $organizacion);




        // execute query
        if ($stmt->execute()) {
            $respuesta->exito = true;
            $respuesta->mensaje = "";
            return $respuesta;
        } else {
            $respuesta->exito = false;
            $respuesta->mensaje = "Ocurrió un problema actualizando";
            return $respuesta;
        }
    }


    function agregarPerfil($perfil)
    {

        $respuesta = new RespuestaBD();


        // check if more than 0 record found


        // query to insert record
        $query = "INSERT INTO
                   perfiles
                SET
                perfil=:perfil";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $perfil = htmlspecialchars(strip_tags($perfil));

        // bind values
        $stmt->bindParam(":perfil", $perfil);




        // execute query
        if ($stmt->execute()) {
            $idInsertado = $this->conn->lastInsertId();
            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = $idInsertado;
            return $respuesta;
        }
    }



    function toggleAdministrador($idAdministrador, $activo)
    {

        $respuesta = new RespuestaBD();

        // check if more than 0 record found

        // query to insert record
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    activo=" . $activo . " where idUsuario=" . $idAdministrador;

        // prepare query
        $stmt = $this->conn->prepare($query);




        // execute query
        if ($stmt->execute()) {
            $respuesta->exito = true;
            $respuesta->mensaje = "";
            return $respuesta;
        } else {
            $respuesta->exito = false;
            $respuesta->mensaje = "Ocurrió un problema togglenizando";
            return $respuesta;
        }
    }
}
