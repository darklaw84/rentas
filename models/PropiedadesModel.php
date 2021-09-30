<?php

include_once 'RespuestaBD.php';
include_once './utils/convertirnumeroletra.php';



class PropiedadesModel
{

    // database connection and table name
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    function obtenerPropiedadesUsuario($idUsuario)
    {


        $query = "SELECT p.*,u.usuario  FROM  propiedades p  
        inner join usuarios u on u.idUsuario = p.propietario
        where propietario = " . $idUsuario . "
         order by p.nombre";


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

                $contratos = $this->obtenerContratosPropiedad($idPropiedad)->registros;
                $fechaMaxPago = $this->obtenerFechaMaxPago($idPropiedad)->registros;
                $egresos = $this->obtenerEgresos($idPropiedad)->registros;
                $ingresos = $this->obtenerIngresos($idPropiedad)->registros;
                $fotos = $this->obtenerFotosPropiedad($idPropiedad)->registros;

                $totalEgresos = 0;
                foreach ($egresos as $eg) {
                    $totalEgresos = $totalEgresos + $eg['monto'];
                }

                $totalIngresos = 0;
                foreach ($ingresos as $eg) {
                    $totalIngresos = $totalIngresos + $eg['monto'];
                }
                $totalPropiedad = $totalIngresos - $totalEgresos;


                $registro_item = array(
                    "idPropiedad" => $idPropiedad,
                    "nombre" => $nombre,
                    "direccion" => $direccion,
                    "descripcion" => $descripcion,
                    "renta" => $renta,
                    "predial" => $predial,
                    "propietario" => $propietario,
                    "fechaMaxPago" => $fechaMaxPago,
                    "numescritura" => $numescritura,
                    "fechaEscritura" => $fechaEscritura,
                    "licEscritura" => $licEscritura,
                    "numNotaria" => $numNotaria,
                    "folioMercantil" => $folioMercantil,
                    "superficie" => $superficie,
                    "comprende" => $comprende,
                    "amueblada" => $amueblada,
                    "totalEgresos" => $totalEgresos,
                    "totalIngresos" => $totalIngresos,
                    "totalPropiedad" => $totalPropiedad,
                    "fotografia" => $fotografia,
                    "egresos" => $egresos,
                    "ingresos" => $ingresos,
                    "fotos" => $fotos,

                    "contratos" => $contratos

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


    function obtenerPropiedades()
    {


        $query = "SELECT p.*,u.usuario  FROM  propiedades p  
        inner join usuarios u on u.idUsuario = p.propietario
         order by p.nombre";


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

                $contratos = $this->obtenerContratosPropiedad($idPropiedad)->registros;
                $fechaMaxPago = $this->obtenerFechaMaxPago($idPropiedad)->registros;
                $egresos = $this->obtenerEgresos($idPropiedad)->registros;
                $ingresos = $this->obtenerIngresos($idPropiedad)->registros;
                $fotos = $this->obtenerFotosPropiedad($idPropiedad)->registros;

                $totalEgresos = 0;
                foreach ($egresos as $eg) {
                    $totalEgresos = $totalEgresos + $eg['monto'];
                }

                $totalIngresos = 0;
                foreach ($ingresos as $eg) {
                    $totalIngresos = $totalIngresos + $eg['monto'];
                }
                $totalPropiedad = $totalIngresos - $totalEgresos;


                $registro_item = array(
                    "idPropiedad" => $idPropiedad,
                    "nombre" => $nombre,
                    "direccion" => $direccion,
                    "descripcion" => $descripcion,
                    "renta" => $renta,
                    "predial" => $predial,
                    "propietario" => $propietario,
                    "fechaMaxPago" => $fechaMaxPago,
                    "numescritura" => $numescritura,
                    "fechaEscritura" => $fechaEscritura,
                    "licEscritura" => $licEscritura,
                    "numNotaria" => $numNotaria,
                    "folioMercantil" => $folioMercantil,
                    "superficie" => $superficie,
                    "comprende" => $comprende,
                    "amueblada" => $amueblada,
                    "totalEgresos" => $totalEgresos,
                    "totalIngresos" => $totalIngresos,
                    "totalPropiedad" => $totalPropiedad,
                    "fotografia" => $fotografia,
                    "egresos" => $egresos,
                    "ingresos" => $ingresos,
                    "fotos" => $fotos,

                    "contratos" => $contratos

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



    function obtenerRecibo($idRecibo)
    {

        $nombreRecibo = $this->obtenerParametro("nombreRecibo")->registros[0]['valor'];
        $regimenFiscal = $this->obtenerParametro("regimenFiscal")->registros[0]['valor'];
        $direccionRecibo = $this->obtenerParametro("direccionRecibo")->registros[0]['valor'];

        $query = "SELECT rc.*, uinq.nombre, uinq.apellidos, p.direccion,mp.metodoPago from recibos r
        inner join rentascontrato rc on rc.idRentaContrato = r.idRentaContrato
        inner join metodospago mp on mp.idMetodoPago = rc.idMetodoPago
        inner join contratos c on c.idContrato = rc.idContrato
        inner join usuarios uinq on uinq.idUsuario = c.idInquilino 
        inner join propiedades p on p.idPropiedad = c.idPropiedad
         where r.idRecibo = " . $idRecibo . "";


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $arreglo = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                extract($row);


                $registro_item = array(
                    "idRentaContrato" => $idRentaContrato,
                    "fecha" => $fecha,
                    "monto" => $monto,
                    "fechaPago" => $fechaPago,
                    "tipo" => $tipo,
                    "nombre" => $nombre,
                    "apellidos" => $apellidos,
                    "nombreRecibo" => $nombreRecibo,
                    "metodoPago" => $metodoPago,
                    "regimenFiscal" => $regimenFiscal,
                    "direccionRecibo" => $direccionRecibo,
                    "direccion" => $direccion

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



    function obtenerCorreoRecibo($idRecibo)
    {


        $query = "select u.correo from recibos r 
        inner join rentascontrato rc on rc.idRentaContrato= r.idRentaContrato
        inner join contratos c on rc.idContrato=c.idContrato
        inner join usuarios u on u.idUsuario = c.idInquilino
        where r.idRecibo =  " . $idRecibo . "";


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $arreglo = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                extract($row);


                $registro_item = array(
                    "correo" => $correo

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


    function obtenerParametro($parameto)
    {
        $query = "SELECT valor from parametros where nombre = '" . $parameto . "'";
        $stmt = $this->conn->prepare($query);

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
                    "valor" => $valor

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




    function  obtenerContratosBase($activo, $idTipo)
    {


        $query = "SELECT *  FROM  contratosbase ";
        $tieneWhere = false;
        if ($activo) {
            $query = $query . " where activo =1 ";
            $tieneWhere = true;
        }

        if ($idTipo != "") {
            if ($tieneWhere) {
                $query = $query . " and idContratoBase = " . $idTipo;
            } else {
                $query = $query . " where idContratoBase = " . $idTipo;
            }
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
                    "idContratoBase" => $idContratoBase,
                    "nombre" => $nombre,
                    "base" => $base,
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



    function obtenerPropiedad($idPropiedad)
    {


        $query = "SELECT *  FROM  propiedades  where idPropiedad = " . $idPropiedad . " 
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

                $contratos = $this->obtenerContratosPropiedad($idPropiedad)->registros;
                $fotos = $this->obtenerFotosPropiedad($idPropiedad)->registros;
                $registro_item = array(
                    "idPropiedad" => $idPropiedad,
                    "nombre" => $nombre,
                    "direccion" => $direccion,
                    "descripcion" => $descripcion,
                    "renta" => $renta,
                    "propietario" => $propietario,

                    "numescritura" => $numescritura,
                    "fechaEscritura" => $fechaEscritura,
                    "licEscritura" => $licEscritura,
                    "numNotaria" => $numNotaria,
                    "folioMercantil" => $folioMercantil,
                    "superficie" => $superficie,
                    "comprende" => $comprende,
                    "amueblada" => $amueblada,
                    "fotos" => $fotos,
                    "contratos" => $contratos,


                    "fotografia" => $fotografia


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



    function obtenerContrato($idContrato)
    {


        $query = "SELECT c.*,uinq.fisica,
        uinq.nombre nomInq, uinq.apellidos apeInq, uinq.rfc rfcInq,uinq.representantelegal repInq,
        uprop.nombre nomProp, uprop.apellidos apeProp, uprop.rfc rfcProp,uprop.representantelegal repProp  ,
        uprop.cuenta,uprop.banco,uprop.clabe
        FROM  contratos c  
        inner join usuarios uinq on uinq.idUsuario= c.idInquilino
        inner join usuarios uprop on uprop.idUsuario= c.idPropietario
        where c.idContrato = " . $idContrato . " 
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
                    "idContrato" => $idContrato,
                    "fechaIni" => $fechaIni,
                    "idPropiedad" => $idPropiedad,
                    "fechaFin" => $fechaFin,
                    "tipoContrato" => $tipoContrato,
                    "personas" => $personas,
                    "banco" => $banco,
                    "cuenta" => $cuenta,
                    "clabe" => $clabe,
                    "deposito" => $deposito,
                    "textoContrato" => $textoContrato,
                    "renta" => $renta,
                    "aval" => $aval,
                    "domicilioArrendador" => $domicilioArrendador,
                    "domicilioArrendatario" => $domicilioArrendatario,
                    "domicilioAval" => $domicilioAval,
                    "nomInq" => $nomInq,
                    "apeInq" => $apeInq,
                    "rfcInq" => $rfcInq,
                    "repInq" => $repInq,
                    "nomProp" => $nomProp,
                    "apeProp" => $apeProp,
                    "fisica" => $fisica,
                    "rfcProp" => $rfcProp,
                    "domicilioInmueble" => $domicilioInmueble,
                    "repProp" => $repProp


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




    function obtenerContratosPropiedad($idPropiedad)
    {


        $query = "SELECT c.*,ui.nombre nombreInquilino,ui.apellidos apellidoInquilino  FROM  contratos c  
        inner join usuarios ui on ui.idUsuario=c.idInquilino
        where idPropiedad=" . $idPropiedad . " order by fechaCreacion desc 
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
                    "idPropiedad" => $idPropiedad,
                    "idPropietario" => $idPropietario,
                    "idContrato" => $idContrato,
                    "idInquilino" => $idInquilino,
                    "nombreInquilino" => $nombreInquilino,
                    "apellidoInquilino" => $apellidoInquilino,
                    "fechaIni" => $fechaIni,
                    "fechaFin" => $fechaFin,
                    "renta" => $renta,
                    "archivo" => $archivo,

                    "estatus" => $estatus


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





    function obtenerContratosInquilino($idInquilino)
    {


        $query = "SELECT c.*,ui.nombre nombreInquilino,ui.apellidos apellidoInquilino  FROM  contratos c  
        inner join usuarios ui on ui.idUsuario=c.idInquilino
        where idInquilino=" . $idInquilino . " order by fechaCreacion desc 
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
                    "idPropiedad" => $idPropiedad,
                    "idPropietario" => $idPropietario,
                    "idContrato" => $idContrato,
                    "idInquilino" => $idInquilino,
                    "nombreInquilino" => $nombreInquilino,
                    "apellidoInquilino" => $apellidoInquilino,
                    "fechaIni" => $fechaIni,
                    "fechaFin" => $fechaFin,
                    "renta" => $renta,
                    "archivo" => $archivo,
                    "estatus" => $estatus


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



    function obtenerFechaMaxPago($idPropiedad)
    {


        $query = "select rc.fecha,rc.monto,rc.tipo from contratos c inner join rentascontrato rc on rc.idContrato=c.idContrato 
        where c.idPropiedad = " . $idPropiedad . " and c.estatus = 1 
        and fechaPago is not null
        order by rc.fecha desc limit 1
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


                if ($tipo == "R") {
                    $tipo = "RENTA";
                } else {
                    $tipo = "MTTO.";
                }

                $registro_item = array(
                    "fecha" => $fecha,
                    "monto" => $monto,
                    "tipo" => $tipo
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



    function obtenerIngresos($idPropiedad)
    {

        $respuesta = new RespuestaBD();
        $arreglo = array();
        $query = "select rc.fecha,rc.monto,rc.tipo from contratos c 
        inner join rentascontrato rc on rc.idContrato=c.idContrato 
        where c.idPropiedad = " . $idPropiedad . " 
        and rc.fechaPago is not null
       ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            if ($tipo == "R") {
                $tipo = "RENTA";
            } else {
                $tipo = "MTTO.";
            }

            $registro_item = array(
                "fecha" => $fecha,
                "monto" => $monto,
                "descripcion" => $tipo
            );

            array_push($arreglo, $registro_item);
        }


        $query = "select monto,fechaPago,descripcion from pagospropiedad  where tipo='I' and idPropiedad=" . $idPropiedad . "
       ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);


            $registro_item = array(
                "fecha" => $fechaPago,
                "monto" => $monto,
                "descripcion" => $descripcion
            );

            array_push($arreglo, $registro_item);
        }


        $respuesta->mensaje = "";
        $respuesta->exito = true;
        $respuesta->registros = $arreglo;



        return $respuesta;
    }



    function obtenerEgresos($idPropiedad)
    {

        $respuesta = new RespuestaBD();

        $query = "select monto,fechaPago,descripcion from pagospropiedad  where tipo='E' and idPropiedad=" . $idPropiedad . "
       ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $arreglo = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);


            $registro_item = array(
                "fecha" => $fechaPago,
                "monto" => $monto,
                "descripcion" => $descripcion
            );

            array_push($arreglo, $registro_item);
        }


        $respuesta->mensaje = "";
        $respuesta->exito = true;
        $respuesta->registros = $arreglo;



        return $respuesta;
    }







    function obtenerRentasContrato($idContrato)
    {


        $query = "SELECT rc.*,mp.metodoPago from rentascontrato rc 
        left join metodospago mp on mp.idMetodoPago  = rc.idMetodoPago
        where idContrato = " . $idContrato;


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
                    "idRentaContrato" => $idRentaContrato,
                    "fecha" => $fecha,
                    "idContrato" => $idContrato,
                    "monto" => $monto,
                    "tipo" => $tipo,
                    "usuario" => $usuario,
                    "metodoPago" => $metodoPago,
                    "fechaPago" => $fechaPago,
                    "comprobante" => $comprobante,
                    "estatus" => $estatus

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


    function obtenerPagosPropiedad($idPropiedad)
    {


        $query = "SELECT p.*,c.estatus,u.nombre nomInq,u.apellidos apeInq,pr.nombre propiedad from pagospropiedad p
        inner join contratos c on c.idContrato=p.idContrato 
        inner join usuarios u on u.idUsuario = c.idInquilino
        inner join propiedades pr on pr.idPropiedad=p.idPropiedad
        where p.idPropiedad=" . $idPropiedad . " order by p.fechaPago desc";


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
                    "idPago" => $idPago,
                    "monto" => $monto,
                    "fechaPago" => $fechaPago,
                    "usuario" => $usuario,
                    "tipo" => $tipo,
                    "descripcion" => $descripcion,
                    "idPropiedad" => $idPropiedad,
                    "idContrato" => $idContrato,
                    "vigente" => $estatus,
                    "propiedad" => $propiedad,
                    "inquilino" => $nomInq . " " . $apeInq,
                    "comprobante" => $comprobante


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



    function obtenerPagosPropiedadContrato($idContrato)
    {


        $query = "SELECT * from pagospropiedad where idContrato = " . $idContrato . "  order by fechaPago desc";


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
                    "idPago" => $idPago,
                    "monto" => $monto,
                    "fechaPago" => $fechaPago,
                    "usuario" => $usuario,
                    "tipo" => $tipo,
                    "descripcion" => $descripcion,
                    "idPropiedad" => $idPropiedad,
                    "idContrato" => $idContrato,
                    "comprobante" => $comprobante


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


    function obtenerFotosPropiedad($idPropiedad)
    {


        $query = "SELECT * from fotospropiedad where idPropiedad = " . $idPropiedad;


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
                    "idFoto" => $idFoto,
                    "idPropiedad" => $idPropiedad,
                    "foto" => $foto
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


    function obtenerMisRentasVencidas($idUsuario)
    {


        $query = "select r.comprobante,p.nombre,c.idContrato,u.nombre inquilino, r.fecha,r.monto,r.tipo,r.idRentaContrato
         from propiedades p 
        inner join contratos c on p.idPropiedad=c.idPropiedad 
        inner join rentascontrato r on r.idContrato = c.idContrato 
        inner join usuarios u on u.idUsuario = c.idInquilino
        where p.propietario = " . $idUsuario . " and c.estatus = 1
        and r.fecha <= DATE_ADD(now(), INTERVAL 7 DAY)
        and r.estatus = 0";


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
                    "idRentaContrato" => $idRentaContrato,
                    "nombre" => $nombre,
                    "idContrato" => $idContrato,
                    "comprobante" => $comprobante,
                    "inquilino" => $inquilino,
                    "fecha" => $fecha,
                    "monto" => $monto,
                    "tipo" => $tipo


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







    function agregarPropiedad(
        $nombre,
        $descripcion,
        $direccion,
        $renta,
        $propietario,
        $fotografia,
        $superficie,
        $comprende,
        $numEscritura,
        $fechaEscritura,
        $numNotaria,
        $folioMercantil,
        $licEscritura,
        $predial,
        $amueblada
    ) {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found

        // query to insert record
        $query = "INSERT INTO
                   propiedades
                SET direccion=:direccion,descripcion=:descripcion,renta=:renta,
                nombre=:nombre,propietario=:propietario,numEscritura=:numEscritura,
                fechaEscritura=:fechaEscritura,licEscritura=:licEscritura,numNotaria=:numNotaria,
                folioMercantil=:folioMercantil,superficie=:superficie,comprende=:comprende,predial=:predial,
                amueblada=:amueblada,
                fotografia=:fotografia";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $nombre = htmlspecialchars(strip_tags($nombre));
        $direccion = htmlspecialchars(strip_tags($direccion));
        $descripcion = htmlspecialchars(strip_tags($descripcion));
        $renta = htmlspecialchars(strip_tags($renta));
        $propietario = htmlspecialchars(strip_tags($propietario));
        // bind values
        $stmt->bindParam(":numEscritura", $numEscritura);
        if ($fechaEscritura == "") {
            $fecha = date('Y-m-d');
            $stmt->bindParam(":fechaEscritura", $fecha);
        } else {
            $stmt->bindParam(":fechaEscritura", $fechaEscritura);
        }
        $stmt->bindParam(":licEscritura", $licEscritura);
        $stmt->bindParam(":numNotaria", $numNotaria);
        $stmt->bindParam(":folioMercantil", $folioMercantil);
        $stmt->bindParam(":superficie", $superficie);
        $stmt->bindParam(":comprende", $comprende);
        $stmt->bindParam(":amueblada", $amueblada);

        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":renta", $renta);
        $stmt->bindParam(":propietario", $propietario);
        $stmt->bindParam(":fotografia", $fotografia);
        $stmt->bindParam(":predial", $predial);





        // execute query
        if ($stmt->execute()) {
            $idInsertado = $this->conn->lastInsertId();
            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = $idInsertado;
            if ($fotografia != "") {
                $this->subirFotoPropiedadLista($idInsertado, $fotografia);
            }

            return $respuesta;
        }
    }


    function agregarRecibo(
        $idRentaContrato
    ) {

        $respuesta = new RespuestaBD();


        $query = "INSERT INTO
                   recibos
                SET idRentaContrato=:idRentaContrato";

        // prepare query
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":idRentaContrato", $idRentaContrato);

        if ($stmt->execute()) {
            $idInsertado = $this->conn->lastInsertId();
            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = $idInsertado;
            return $respuesta;
        }
    }


    function agregarContrato(
        $idArrendador,
        $domicilioArrendador,
        $fechaFin,
        $fechaIni,
        $diaPago,
        $renta,
        $interesmoratorio,
        $incrementoanual,
        $deposito,
        $usolocalidad,
        $idInquilino,
        $dominquilino,
        $nombreaval,
        $domicilioaval,
        $domicilioInmuebleAval,
        $tipoContrato,
        $personas,
        $idPropiedad
    ) {

        $respuesta = new RespuestaBD();


        $textoContrato = $this->obtenerContratosBase(true, $tipoContrato)->registros[0]['base'];






        $this->ponerNoVigenteContratos($idPropiedad);

        // check if more than 0 record found

        // query to insert record
        $query = "INSERT INTO
                   contratos
                SET 
                idPropietario=:idPropietario,
                idPropiedad=:idPropiedad,
                idInquilino=:idInquilino,
                fechaIni=:fechaIni,
                fechaFin=:fechaFin,
                renta=:renta,
                tipoContrato=:tipoContrato,
                estatus = 1,
                fechaCreacion=now(),
                diaPago=:diaPago,
                aval=:aval,
                usolocalidad=:usolocalidad,
                domicilioInmueble=:domicilioInmueble,
                domicilioArrendador=:domicilioArrendador,
                domicilioArrendatario=:domicilioArrendatario,
                personas=:personas,
                interesmoratorio=:interesmoratorio,
                incrementoanual=:incrementoanual,
                deposito=:deposito,
                domicilioAval=:domicilioAval
                ";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize

        // bind values

        $stmt->bindParam(":domicilioInmueble", $domicilioInmuebleAval);
        $stmt->bindParam(":aval", $nombreaval);
        $stmt->bindParam(":domicilioArrendador", $domicilioArrendador);
        $stmt->bindParam(":domicilioArrendatario", $dominquilino);
        $stmt->bindParam(":domicilioAval", $domicilioaval);
        $stmt->bindParam(":idPropietario", $idArrendador);
        $stmt->bindParam(":idPropiedad", $idPropiedad);
        $stmt->bindParam(":idInquilino", $idInquilino);
        $stmt->bindParam(":fechaIni", $fechaIni);
        $stmt->bindParam(":fechaFin", $fechaFin);
        $stmt->bindParam(":renta", $renta);
        $stmt->bindParam(":usolocalidad", $usolocalidad);
        $stmt->bindParam(":diaPago", $diaPago);
        $stmt->bindParam(":tipoContrato", $tipoContrato);
        $stmt->bindParam(":personas", $personas);
        $stmt->bindParam(":interesmoratorio", $interesmoratorio);
        $stmt->bindParam(":incrementoanual", $incrementoanual);
        $stmt->bindParam(":deposito", $deposito);

        // execute query
        if ($stmt->execute()) {
            $idInsertado = $this->conn->lastInsertId();
            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = $idInsertado;
            $this->agregarRentasContrato($idInsertado, $fechaIni, $fechaFin, $renta, 0, $diaPago);

            $textoContrato = $this->actualizarDatosContrato(
                $textoContrato,
                $idArrendador,
                $domicilioArrendador,
                $diaPago,
                $renta,
                $interesmoratorio,
                $incrementoanual,
                $deposito,
                $usolocalidad,
                $idInquilino,
                $nombreaval,
                $domicilioaval,
                $domicilioInmuebleAval,
                $personas,
                $idPropiedad,
                $idInsertado
            );

            return $respuesta;
        } else {
            $respuesta->exito = false;
            $mensaje = $stmt->errorInfo();
            $respuesta->mensaje = "Ocurrió un problema actualizando";
            return $respuesta;
        }
    }


    function actualizarDatosContrato(
        $textoContrato,
        $idArrendador,
        $domicilioArrendador,
        $diaPago,
        $renta,
        $interesmoratorio,
        $incrementoanual,
        $deposito,
        $usolocalidad,
        $idInquilino,
        $nombreaval,
        $domicilioaval,
        $domicilioInmuebleAval,
        $personas,
        $idPropiedad,
        $idContrato

    ) {
        $letras = new CifrasEnLetras();
        $rentaS = $letras->convertirPesosEnLetras($renta, 2);
        $depositoS = $letras->convertirPesosEnLetras($deposito, 2);
        $propiedad = $this->obtenerPropiedad($idPropiedad)->registros[0];
        $arrendador = $this->obtenerArrendador($idArrendador)->registros[0];
        $inquilino = $this->obtenerArrendador($idInquilino)->registros[0];
        $meses = $this->obtenerMeses($idContrato);

        $fechaContrato = " " . date('d') . " de " . $this->obtenerMes(date('m')) . " del " . date('Y');


        $textoContrato = str_replace("[domiciliopropiedad]", $propiedad['direccion'], $textoContrato);
        $textoContrato = str_replace("[arrendador]", $arrendador['nombre'] . " " . $arrendador['apellidos'], $textoContrato);
        $textoContrato = str_replace("[arrendatario]", $inquilino['nombre'] . " " . $inquilino['apellidos'], $textoContrato);
        $textoContrato = str_replace("[aval]", $nombreaval, $textoContrato);
        $textoContrato = str_replace("[domicilioarrendador]", $domicilioArrendador, $textoContrato);
        $textoContrato = str_replace("[cuentaarrendador]", $arrendador['cuenta'], $textoContrato);
        $textoContrato = str_replace("[bancoarrendador]", $arrendador['banco'], $textoContrato);
        $textoContrato = str_replace("[correoarrendador]", $arrendador['correo'], $textoContrato);
        $textoContrato = str_replace("[incrementoanual]", $incrementoanual . " %", $textoContrato);
        $textoContrato = str_replace("[diapago]", $diaPago, $textoContrato);
        $textoContrato = str_replace("[interesmoratorio]", $interesmoratorio . " %", $textoContrato);
        $textoContrato = str_replace("[usolocalidad]", $usolocalidad, $textoContrato);
        $textoContrato = str_replace("[domicilioinmuebleaval]", $domicilioInmuebleAval, $textoContrato);
        $textoContrato = str_replace("[domicilioaval]", $domicilioaval, $textoContrato);
        $textoContrato = str_replace("[deposito]", $depositoS, $textoContrato);
        $textoContrato = str_replace("[fechaContrato]", $fechaContrato, $textoContrato);
        $textoContrato = str_replace("[renta]", $rentaS, $textoContrato);
        $textoContrato = str_replace("[meses]", $meses, $textoContrato);
        $textoContrato = str_replace("[personas]", $personas, $textoContrato);
        $textoContrato = str_replace("
", "", $textoContrato);

        $query = "UPDATE contratos SET textoContrato = '" . $textoContrato . "' where idContrato=" . $idContrato;

        $stmt = $this->conn->prepare($query);



        if ($stmt->execute()) {
        } else {
            $mensaje = $stmt->errorInfo();
            $hola = "";
        }
    }


    function obtenerMes($mes)
    {
        if ($mes == 1) {
            $mesS = "Enero";
        } else if ($mes == 2) {
            $mesS = "Febrero";
        } else if ($mes == 3) {
            $mesS = "Marzo";
        } else if ($mes == 4) {
            $mesS = "Abril";
        } else if ($mes == 5) {
            $mesS = "Mayo";
        } else if ($mes == 6) {
            $mesS = "Junio";
        } else if ($mes == 7) {
            $mesS = "Julio";
        } else if ($mes == 8) {
            $mesS = "Agosto";
        } else if ($mes == 9) {
            $mesS = "Septiembre";
        } else if ($mes == 10) {
            $mesS = "Octubre";
        } else if ($mes == 11) {
            $mesS = "Novimebre";
        } else if ($mes == 12) {
            $mesS = "Diciembre";
        }

        return $mesS;
    }

    function obtenerMeses($idContrato)
    {


        $query = "SELECT TIMESTAMPDIFF(MONTH, c.fechaIni, c.fechaFin) meses  FROM  contratos c where idContrato =" . $idContrato;

        $cantMeses = 0;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);

            $cantMeses = $meses;
        }



        return $cantMeses;
    }

    function obtenerArrendador($idArrendador)
    {
        $query = "SELECT *  FROM  usuarios where idUsuario =" . $idArrendador;


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $arreglo = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                extract($row);


                $registro_item = array(
                    "apellidos" => $apellidos,
                    "nombre" => $nombre,
                    "banco" => $banco,
                    "cuenta" => $cuenta,
                    "clabe" => $clabe,
                    "correo" => $correo,

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






    function actualizarContrato(
        $aval,
        $numEscrituraArrendatario,
        $fechaEscrituraArrendatario,
        $licenciadoArrendatario,
        $notariaArrendatario,
        $folioMercantilArrendatario,
        $rfcaval,
        $domicilioInmueble,
        $domicilioAval,
        $idContrato
    ) {

        $respuesta = new RespuestaBD();




        // check if more than 0 record found

        // query to insert record
        $query = "UPDATE 
                   contratos
                SET 
               
                
                aval=:aval,
                rfcaval=:rfcaval,
                domicilioInmueble=:domicilioInmueble,
                numEscrituraArrendatario=:numEscrituraArrendatario,
                fechaEscrituraArrendatario=:fechaEscrituraArrendatario,
                licenciadoArrendatario=:licenciadoArrendatario,
                notariaArrendatario=:notariaArrendatario,
                folioMercantilArrendatario=:folioMercantilArrendatario,
                domicilioAval=:domicilioAval where idContrato=:idContrato";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize

        // bind values

        $stmt->bindParam(":domicilioInmueble", $domicilioInmueble);
        $stmt->bindParam(":aval", $aval);

        $stmt->bindParam(":numEscrituraArrendatario", $numEscrituraArrendatario);
        $stmt->bindParam(":fechaEscrituraArrendatario", $fechaEscrituraArrendatario);
        $stmt->bindParam(":licenciadoArrendatario", $licenciadoArrendatario);
        $stmt->bindParam(":notariaArrendatario", $notariaArrendatario);
        $stmt->bindParam(":folioMercantilArrendatario", $folioMercantilArrendatario);
        $stmt->bindParam(":rfcaval", $rfcaval);
        $stmt->bindParam(":domicilioAval", $domicilioAval);
        $stmt->bindParam(":idContrato", $idContrato);



        // execute query
        if ($stmt->execute()) {

            $respuesta->exito = true;
            $respuesta->mensaje = "";


            return $respuesta;
        } else {
            $respuesta->exito = false;
            $mensaje = $stmt->errorInfo();
            $respuesta->mensaje = "Ocurrió un problema actualizando";
            return $respuesta;
        }
    }


    function agregarRentasContrato($idContrato, $fechaIni, $fechaFin, $renta, $mantenimiento, $diaPago)
    {
        // lo primero que hay que hacer es convertir las fechas en dates y solo aumentarle un dia y checar si es el dia que queremos

        $dateIni = strtotime($fechaIni);
        $dateFin = strtotime($fechaFin);

        $estaDentroRango = true;
        while ($estaDentroRango) {
            $diaF = date('d', $dateIni);
            if ($diaF == $diaPago) {
                //tenemos que insertar en la BD
                $this->agregarRentaContrato($dateIni, $idContrato, $renta, "R");
                if ($mantenimiento > 0) {
                    $this->agregarRentaContrato($dateIni, $idContrato, $mantenimiento, "M");
                }
                $dateIni = strtotime(date('Y-m-d', $dateIni) . ' + 1 days');
            } else {
                //sumamos un dia 

                $dateIni = strtotime(date('Y-m-d', $dateIni) . ' + 1 days');
            }

            if ($dateIni == $dateFin) {
                $estaDentroRango = false;
            }
        }
    }


    function agregarRentaContrato($fecha, $idContrato, $monto, $tipo)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found

        // query to insert record
        $query = "INSERT INTO
                   rentascontrato
                SET fecha=:fecha,
                idContrato=:idContrato,monto=:monto,
                estatus=0,tipo=:tipo";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize

        // bind values
        $fechaArreglada = date('Y-m-d', $fecha);
        $stmt->bindParam(":fecha", $fechaArreglada);
        $stmt->bindParam(":idContrato", $idContrato);
        $stmt->bindParam(":monto", $monto);
        $stmt->bindParam(":tipo", $tipo);




        // execute query
        if ($stmt->execute()) {
            $idInsertado = $this->conn->lastInsertId();
            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = $idInsertado;


            return $respuesta;
        } else {
            $respuesta->exito = false;
            $mensaje = $stmt->errorInfo();
            $respuesta->mensaje = "Ocurrió un problema actualizando";
            return $respuesta;
        }
    }



    function agregarPagoContrato($descripcion, $idContrato, $monto, $idPropiedad, $tipo, $usuario)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found

        // query to insert record
        $query = "INSERT INTO
                   pagospropiedad
                SET descripcion=:descripcion,idContrato=:idContrato,monto=:monto,
                idPropiedad=:idPropiedad,tipo=:tipo,usuario=:usuario,fechaPago=now()
                ";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize

        // bind values

        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":idContrato", $idContrato);
        $stmt->bindParam(":monto", $monto);
        $stmt->bindParam(":idPropiedad", $idPropiedad);
        $stmt->bindParam(":tipo", $tipo);
        $stmt->bindParam(":usuario", $usuario);




        // execute query
        if ($stmt->execute()) {
            $idInsertado = $this->conn->lastInsertId();
            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = $idInsertado;


            return $respuesta;
        } else {
            $respuesta->exito = false;
            $mensaje = $stmt->errorInfo();
            $respuesta->mensaje = "Ocurrió un problema actualizando";
            return $respuesta;
        }
    }



    function ponerNoVigenteContratos($idPropiedad)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found

        // query to insert record
        $query = "update contratos set estatus =0 where idPropiedad= " . $idPropiedad;

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize

        // bind values



        // execute query
        if ($stmt->execute()) {

            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = "";


            return $respuesta;
        }
    }


    function subirComprobanteRenta($idRentaContrato, $comprobante)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found

        // query to insert record
        $query = "update rentascontrato set  comprobante ='" . $comprobante . "' 
        where idRentaContrato= " . $idRentaContrato;

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize

        // bind values



        // execute query
        if ($stmt->execute()) {

            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = "";


            return $respuesta;
        }
    }


    function subirComprobantePago($idPago, $comprobante)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found

        // query to insert record
        $query = "update pagospropiedad set comprobante ='" . $comprobante . "' 
        where idPago= " . $idPago;

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize

        // bind values



        // execute query
        if ($stmt->execute()) {

            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = "";


            return $respuesta;
        }
    }


    function actualizarTextoContrato($idContrato, $texto)
    {

        $respuesta = new RespuestaBD();
        $query = "update contratos set textoContrato ='" . $texto . "' 
        where idContrato= " . $idContrato;
        // prepare query
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {

            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = "";


            return $respuesta;
        }
    }


    function subirFotoPropiedad($idPropiedad, $fotografia)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found

        // query to insert record
        $query = "update propiedades set fotografia ='" . $fotografia . "' 
        where idPropiedad= " . $idPropiedad;

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize

        // bind values



        // execute query
        if ($stmt->execute()) {

            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = "";


            return $respuesta;
        }
    }


    function subirArchivoContrato($idContrato, $archivo)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found

        // query to insert record
        $query = "update contratos set archivo ='" . $archivo . "' 
        where idContrato= " . $idContrato;

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize

        // bind values



        // execute query
        if ($stmt->execute()) {

            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = "";


            return $respuesta;
        }
    }



    function subirFotoPropiedadLista($idPropiedad, $archivo)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found

        // query to insert record
        $query = "insert into fotospropiedad (idPropiedad,foto) values (" . $idPropiedad . ",'" . $archivo . "') ";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize

        // bind values



        // execute query
        if ($stmt->execute()) {

            $respuesta->exito = true;
            $respuesta->mensaje = "";
            $respuesta->valor = "";


            return $respuesta;
        }
    }



    function actualizarPropiedad(
        $direccion,
        $descripcion,
        $nombre,
        $renta,
        $fotografia,
        $idPropiedad,
        $superficie,
        $comprende,
        $numEscritura,
        $fechaEscritura,
        $numNotaria,
        $folioMercantil,
        $licEscritura,
        $predial,
        $amueblada
    ) {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found


        // query to insert record
        $query = "UPDATE
                    propiedades
                SET
                nombre=:nombre,direccion=:direccion,descripcion=:descripcion,
                numEscritura=:numEscritura,fechaEscritura=:fechaEscritura,
                licEscritura=:licEscritura,numNotaria=:numNotaria,folioMercantil=:folioMercantil,
                superficie=:superficie,comprende=:comprende,amueblada=:amueblada,predial=:predial,
                renta=:renta,fotografia=:fotografia where idPropiedad=:idPropiedad";




        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $nombre = htmlspecialchars(strip_tags($nombre));
        $direccion = htmlspecialchars(strip_tags($direccion));
        $descripcion = htmlspecialchars(strip_tags($descripcion));
        $renta = htmlspecialchars(strip_tags($renta));
        $fotografia = htmlspecialchars(strip_tags($fotografia));
        $numEscritura = htmlspecialchars(strip_tags($numEscritura));
        $licEscritura = htmlspecialchars(strip_tags($licEscritura));
        $numNotaria = htmlspecialchars(strip_tags($numNotaria));
        $folioMercantil = htmlspecialchars(strip_tags($folioMercantil));



        // bind values
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":renta", $renta);
        $stmt->bindParam(":fotografia", $fotografia);
        $stmt->bindParam(":idPropiedad", $idPropiedad);


        $stmt->bindParam(":numEscritura", $numEscritura);
        $stmt->bindParam(":fechaEscritura", $fechaEscritura);
        $stmt->bindParam(":licEscritura", $licEscritura);
        $stmt->bindParam(":numNotaria", $numNotaria);
        $stmt->bindParam(":folioMercantil", $folioMercantil);
        $stmt->bindParam(":superficie", $superficie);
        $stmt->bindParam(":comprende", $comprende);
        $stmt->bindParam(":predial", $predial);
        $stmt->bindParam(":amueblada", $amueblada);





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


    function recibirPagoRenta($idRentaContrato, $usuario, $idMetodoPago)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found


        // query to insert record
        $query = "UPDATE
                    rentascontrato
                SET
                usuario=:usuario,idMetodoPago=:idMetodoPago,fechaPago=now(),estatus=1 where idRentaContrato=:idRentaContrato";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":usuario", $usuario);
        $stmt->bindParam(":idRentaContrato", $idRentaContrato);
        $stmt->bindParam(":idMetodoPago", $idMetodoPago);


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


    function cancelarPagoRenta($idRentaContrato, $usuario)
    {

        $respuesta = new RespuestaBD();



        // check if more than 0 record found


        // query to insert record
        $query = "UPDATE
                    rentascontrato
                SET
                usuario='',idMetodoPago=NULL,fechaPago=NULL,estatus=0,
                usuarioCancela=:usuarioCancela,fechaCancela=now()
                 where idRentaContrato=:idRentaContrato";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":usuarioCancela", $usuario);
        $stmt->bindParam(":idRentaContrato", $idRentaContrato);



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


    function eliminarPago($idPago)
    {

        $respuesta = new RespuestaBD();


        $query = "delete from pagospropiedad where idPago=" . $idPago;

        $stmt = $this->conn->prepare($query);


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
}
