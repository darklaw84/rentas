<?php

include_once 'RespuestaBD.php';



class UsuariosModel
{

    // database connection and table name
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    function obtenerUsuarios($tipo)
    {

        if ($tipo == "inquilinos") {
            $query = "SELECT  u.*,p.perfil  FROM  usuarios u 
            left join perfiles p on u.idPerfil = p.idPerfil where u.idPerfil=6 order by usuario";
        } else {
            $query = "SELECT  u.*,p.perfil  FROM  usuarios u 
        left join perfiles p on u.idPerfil = p.idPerfil where u.idPerfil<>6 order by usuario";
        }

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
                    "perfil" => $perfil,
                    "correo" => $correo,
                    "nombre" => $nombre,
                    "apellidos" => $apellidos,
                    "rfc" => $rfc,
                    "telefono" => $telefono,
                    "factura" => $factura,
                    "fisica" => $fisica,
                    "activo" => $activo,
                    "banco" => $banco,
                    "cuenta" => $cuenta,
                    "clabe" => $clabe,

                    

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



    function obtenerInquilinos()
    {


        $query = "SELECT  u.*,p.perfil  FROM  usuarios u 
        left join perfiles p on u.idPerfil = p.idPerfil where u.idPerfil = 6 order by usuario";


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
                    "perfil" => $perfil,
                    "correo" => $correo,
                    "nombre" => $nombre,
                    "apellidos" => $apellidos,
                    "rfc" => $rfc,
                    "telefono" => $telefono,
                    "factura" => $factura,
                    "fisica" => $fisica,
                    "activo" => $activo,

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



    





    function obtenerValorParametro($nombreParametro)
    {


        $query = "SELECT  valorParametro from parametros where nombreParametro='" . $nombreParametro . "'";


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $valor = "";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);


                $valor = $valorParametro;
            }
            $respuesta->mensaje = "";
            $respuesta->exito = true;

            $respuesta->valor = $valor;
        } else {
            $respuesta->mensaje = "No se encontraron datos ";
            $respuesta->exito = false;
        }


        return $respuesta;
    }





    function validaExistenciaUsuario($usuario)
    {

        // select all query
        $query = "SELECT  *  FROM   usuarios  where 
        usuario = '" . $usuario . "'";

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


    function validaPasswordAnterior($idUsuario, $passanterior)
    {

        // select all query
        $query = "SELECT  *  FROM   usuarios   where 
        idUsuario = " . $idUsuario . " and password='" . $passanterior . "' ";

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



    function agregarUsuario($usuario, $nombre, $apellidos, $correo, $telefono, $password, 
    $rfc, $idPerfil, $tipoPersona, $factura,$banco,$cuenta,$clabe)
    {

        $respuesta = new RespuestaBD();
        $existe = $this->validaExistenciaUsuario($usuario);


        // check if more than 0 record found
        if (!$existe) {

            // query to insert record
            $query = "INSERT INTO
                   usuarios
                SET usuario=:usuario,rfc=:rfc,idPerfil=:idPerfil,
                nombre=:nombre,apellidos=:apellidos,fisica=:fisica,
                banco=:banco,cuenta=:cuenta,clabe=:clabe,
                correo=:correo,telefono=:telefono, password=:password,activo=1,factura=:factura";




            // prepare query
            $stmt = $this->conn->prepare($query);
            // sanitize
            $nombre = htmlspecialchars(strip_tags($nombre));
            $usuario = htmlspecialchars(strip_tags($usuario));
            $password = htmlspecialchars(strip_tags($password));
            $apellidos = htmlspecialchars(strip_tags($apellidos));
            $correo = htmlspecialchars(strip_tags($correo));
            $telefono = htmlspecialchars(strip_tags($telefono));
            $rfc = htmlspecialchars(strip_tags($rfc));
            $idPerfil = htmlspecialchars(strip_tags($idPerfil));
            $banco = htmlspecialchars(strip_tags($banco));
            $cuenta = htmlspecialchars(strip_tags($cuenta));
            $clabe = htmlspecialchars(strip_tags($clabe));
            // bind values
            $stmt->bindParam(":usuario", $usuario);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":apellidos", $apellidos);
            $stmt->bindParam(":correo", $correo);
            $stmt->bindParam(":telefono", $telefono);
            $stmt->bindParam(":rfc", $rfc);
            $stmt->bindParam(":idPerfil", $idPerfil);
            $stmt->bindParam(":factura", $factura);
            $stmt->bindParam(":fisica", $tipoPersona);

            $stmt->bindParam(":banco", $banco);
            $stmt->bindParam(":cuenta", $cuenta);
            $stmt->bindParam(":clabe", $clabe);



            


            // execute query
            if ($stmt->execute()) {
                $idInsertado = $this->conn->lastInsertId();
                $respuesta->exito = true;
                $respuesta->mensaje = "";
                $respuesta->valor = $idInsertado;
                return $respuesta;
            }
        } else {
            $respuesta->exito = false;
            $respuesta->mensaje = "Ya existe el usuario";

            return $respuesta;
        }
    }


    function actualizarUsuario($nombre, $apellidos, $correo, $telefono, $idUsuario, $rfc,
     $idPerfil, $factura,$banco,$cuenta,$clabe)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found


        // query to insert record
        $query = "UPDATE
                    usuarios
                SET
                nombre=:nombre,apellidos=:apellidos,idPerfil=:idPerfil,rfc=:rfc,
                banco=:banco,cuenta=:cuenta,clabe=:clabe,
                correo=:correo,telefono=:telefono,factura=:factura where idUsuario=:idUsuario";




        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $nombre = htmlspecialchars(strip_tags($nombre));
        $apellidos = htmlspecialchars(strip_tags($apellidos));
        $correo = htmlspecialchars(strip_tags($correo));
        $telefono = htmlspecialchars(strip_tags($telefono));
        $rfc = htmlspecialchars(strip_tags($rfc));

        $banco = htmlspecialchars(strip_tags($banco));
        $cuenta = htmlspecialchars(strip_tags($cuenta));
        $clabe = htmlspecialchars(strip_tags($clabe));



        



        // bind values
        $stmt->bindParam(":banco", $banco);
        $stmt->bindParam(":cuenta", $cuenta);
        $stmt->bindParam(":clabe", $clabe);

        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellidos", $apellidos);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":idUsuario", $idUsuario);
        $stmt->bindParam(":rfc", $rfc);
        $stmt->bindParam(":idPerfil", $idPerfil);
        $stmt->bindParam(":factura", $factura);




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



    function actualizarPassAdministrador($idUsuario, $password)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found


        // query to insert record
        $query = "UPDATE
                  usuarios
                SET
                password=:password where idUsuario=:idUsuario";

        // prepare query
        $stmt = $this->conn->prepare($query);




        // bind values
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":idUsuario", $idUsuario);





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



    function actualizarPassword($idUsuario, $passanterior, $passnuevo)
    {

        $respuesta = new RespuestaBD();

        if ($this->validaPasswordAnterior($idUsuario, $passanterior)) {


            $query = "UPDATE
                    usuarios 
                SET
                password=:password where idUsuario=:idUsuario";

            // prepare query
            $stmt = $this->conn->prepare($query);




            // bind values
            $stmt->bindParam(":password", $passnuevo);

            $stmt->bindParam(":idUsuario", $idUsuario);




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
        } else {
            $respuesta->exito = false;
            $respuesta->mensaje = "La contraseña anterior no coincide";
            return $respuesta;
        }
    }




    function toggleUsuario($idUsuario, $activo)
    {

        $respuesta = new RespuestaBD();

        // check if more than 0 record found

        // query to insert record
        $query = "UPDATE
                   usuarios
                SET
                    activo=" . $activo . " where idUsuario=" . $idUsuario;

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
