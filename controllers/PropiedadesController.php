<?php

include_once './config/database.php';
include_once './models/PropiedadesModel.php';


class PropiedadesController
{


    public function __construct()
    {
    }


    function obtenerPropiedad($idPropiedad)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerPropiedad($idPropiedad);

        return $respuesta;
    }


    function  obtenerContrato($idContrato)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerContrato($idContrato);

        return $respuesta;
    }





    function obtenerPropiedadesUsuario($idUsuario)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerPropiedadesUsuario($idUsuario);

        return $respuesta;
    }

    function obtenerPropiedades()
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerPropiedades();

        return $respuesta;
    }


    function obtenerMisRentasVencidas($idUsuario)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerMisRentasVencidas($idUsuario);

        return $respuesta;
    }




    function  subirComprobanteRenta($idRentaContrato, $comprobante)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->subirComprobanteRenta($idRentaContrato, $comprobante);

        return $respuesta;
    }


    function  subirComprobantePago($idPago, $comprobante)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->subirComprobantePago($idPago, $comprobante);

        return $respuesta;
    }





    function  agregarPagoContrato($descripcion, $idContrato, $monto, $idPropiedad, $tipo, $usuario)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->agregarPagoContrato($descripcion, $idContrato, $monto, $idPropiedad, $tipo, $usuario);

        return $respuesta;
    }





    function   subirFotoPropiedad($idPropiedad, $fotografia)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->subirFotoPropiedad($idPropiedad, $fotografia);

        return $respuesta;
    }


    function   subirArchivoContrato($idContrato, $archivo)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->subirArchivoContrato($idContrato, $archivo);

        return $respuesta;
    }

    function subirFotoPropiedadLista($idPropiedad, $archivo)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->subirFotoPropiedadLista($idPropiedad, $archivo);

        return $respuesta;
    }


    

    function   obtenerRecibo($idRecibo)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerRecibo($idRecibo);

        return $respuesta;
    }

    function   obtenerCorreoRecibo($idRecibo)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerCorreoRecibo($idRecibo);

        return $respuesta;
    }



    function obtenerContenidoCorreoRecibo()
    {
        return "Recibo de Pago adjunto";
    }
    
    


    function   agregarRecibo($idRentaContrato)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->agregarRecibo(
            $idRentaContrato
        );

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
    )
    {
    $database = new Database();
    $db = $database->getConnection();
    $clase = new PropiedadesModel($db);
    $respuesta = $clase->actualizarContrato(
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
    );

    return $respuesta;
}







    function  agregarContrato(
        $idPropietario,
        $idPropiedad,
        $fechaIni,
        $fechaFin,
        $idInquilino,
        $renta,
        $mantenimiento,
        $diaPago,
        $aval,
        $domicilioArrrendador,
        $numEscrituraArrendatario,
        $fechaEscrituraArrendatario,
        $licenciadoArrendatario,
        $notariaArrendatario,
        $folioMercantilArrendatario,
        $domicilioArrendatario,
        $rfcaval,
        $domicilioInmueble,
        $tipoContrato,
        $domicilioAval
    ) {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->agregarContrato(
            $idPropietario,
            $idPropiedad,
            $fechaIni,
            $fechaFin,
            $idInquilino,
            $renta,
            $mantenimiento,
            $diaPago,
            $aval,
            $domicilioArrrendador,
            $numEscrituraArrendatario,
            $fechaEscrituraArrendatario,
            $licenciadoArrendatario,
            $notariaArrendatario,
            $folioMercantilArrendatario,
            $domicilioArrendatario,
            $rfcaval,
            $domicilioInmueble,
            $tipoContrato,
            $domicilioAval
        );

        return $respuesta;
    }



    function  obtenerPagosPropiedad($idPropiedad)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerPagosPropiedad($idPropiedad);

        return $respuesta;
    }


    function  obtenerPagosPropiedadContrato($idContrato)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerPagosPropiedadContrato($idContrato);

        return $respuesta;
    }



    function  obtenerFotosPropiedad($idPropiedad)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerFotosPropiedad($idPropiedad);

        return $respuesta;
    }



    function obtenerContratosPropiedad($idPropiedad)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerContratosPropiedad($idPropiedad);

        return $respuesta;
    }


    function obtenerContratosInquilino($idInquilino)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerContratosInquilino($idInquilino);

        return $respuesta;
    }



    function obtenerRentasContrato($idContrato)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->obtenerRentasContrato($idContrato);

        return $respuesta;
    }


    function agregarPropiedad(
        $nombre,
        $descripcion,
        $direccion,
        $renta,
        $idPropietario,
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
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->agregarPropiedad(
            $nombre,
            $descripcion,
            $direccion,
            $renta,
            $idPropietario,
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
        );

        return $respuesta;
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
        $numescritura,
        $fechaEscritura,
        $numNotaria,
        $folioMercantil,
        $licEscritura,
        $predial,
        $amueblada
    ) {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->actualizarPropiedad(
            $direccion,
            $descripcion,
            $nombre,
            $renta,
            $fotografia,
            $idPropiedad,
            $superficie,
            $comprende,
            $numescritura,
            $fechaEscritura,
            $numNotaria,
            $folioMercantil,
            $licEscritura,
            $predial,
            $amueblada
        );
        return $respuesta;
    }


    function recibirPagoRenta($idRentaContrato, $usuario,$idMetodoPago)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->recibirPagoRenta($idRentaContrato, $usuario,$idMetodoPago);
        return $respuesta;
    }


    function cancelarPagoRenta($idRentaContrato, $usuario)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->cancelarPagoRenta($idRentaContrato, $usuario);
        return $respuesta;
    }

    function eliminarPago($idPago)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new PropiedadesModel($db);
        $respuesta = $clase->eliminarPago($idPago);
        return $respuesta;
    }
}
