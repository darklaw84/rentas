<?php

include_once 'RespuestaBD.php';



class LoginModel
{

    // database connection and table name
    private $conn;



    public function __construct($db)
    {
        $this->conn = $db;
    }


    function login($usuario, $password)
    {


        $query = "SELECT  *  FROM  usuarios where usuario = '" . $usuario . "'
         and password= '" . $password . "' ";


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
                    "idUsuario" => $idUsuario,
                    "usuario" => $usuario,
                    "idPerfil" => $idPerfil,
                    "correo" => $correo,
                    "telefono" => $telefono,
                    "nombre" => $nombre,
                    "apellidos" => $apellidos,
                    "rfc" => $rfc,
                    "activo" => $activo


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


    function validaExistencia($correo)
    {

        // select all query
        $query = "SELECT  *  FROM   usuarios  where 
        correo = '" . $correo . "'";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();

        $existe = false;

        if ($num > 0) {

            $existe = true;
        }
        return $existe;
    }


    function registrarOrganizador($nombre, $apellidos, $organizacion, $telefono, $idEstado, $correo, $password)
    {

        $respuesta = new RespuestaBD();
        $existe = $this->validaExistencia($correo);


        // check if more than 0 record found
        if (!$existe) {

            // query to insert record
            $query = "INSERT INTO
                    usuarios
                SET
                nombre=:nombre,apellidos=:apellidos,organizacion=:organizacion,
                telefono=:telefono,idEstado=:idEstado,correo=:correo,password=:password,activo=1,tipo='O'";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $nombre = htmlspecialchars(strip_tags($nombre));
            $apellidos = htmlspecialchars(strip_tags($apellidos));
            $organizacion = htmlspecialchars(strip_tags($organizacion));
            $telefono = htmlspecialchars(strip_tags($telefono));
            $password = htmlspecialchars(strip_tags($password));
            $correo = htmlspecialchars(strip_tags($correo));

            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":apellidos", $apellidos);
            $stmt->bindParam(":organizacion", $organizacion);
            $stmt->bindParam(":telefono", $telefono);
            $stmt->bindParam(":correo", $correo);
            $stmt->bindParam(":idEstado", $idEstado);




            // execute query
            if ($stmt->execute()) {
                $idInsertado = $this->conn->lastInsertId();
                $respuesta->exito = true;
                $respuesta->mensaje = "";
                $respuesta->valor = $idInsertado;
                return $respuesta;
            }
            else
            {
                $respuesta->exito = false;
            $mensaje = $stmt->errorInfo();
            $respuesta->mensaje = "Ocurrió un problema actualizando";
            return $respuesta;
            }
        } else {
            $respuesta->exito = false;
            $respuesta->mensaje = "Ya existe el correo";

            return $respuesta;
        }
    }


    function obtenerEstados($idPais)
    {


        $query = "SELECT  *  FROM   estados where idPais=" . $idPais . " order by estado";


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
                    "idEstado" => $idEstado,
                    "estado" => $estado

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
}
