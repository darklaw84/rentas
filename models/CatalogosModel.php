<?php

include_once 'RespuestaBD.php';



class CatalogosModel
{

    // database connection and table name
    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }


    function obtenerMetodosPago()
    {


        $query = "SELECT  * from metodospago  order by idMetodoPago ";


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
                    "idMetodoPago" => $idMetodoPago,
                    "metodoPago" => $metodoPago

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
