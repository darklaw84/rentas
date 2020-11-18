<?php

include_once './config/database.php';
include_once './models/CotizacionModel.php';


class CotizacionesController
{


    public function __construct()
    {
    }




    function crearCotizacion($idCliente, $tc)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->crearCotizacion($idCliente, $tc);

        return $respuesta;
    }



    function obtenerCotizaciones($tipo)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->obtenerCotizaciones($tipo);

        return $respuesta;
    }


    function obtenerCotizacion($idCotizacion,$tipo,$conInsumos)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->obtenerCotizacion($idCotizacion,$tipo,$conInsumos);

        return $respuesta;
    }


    function agregarProductoCotizacion($idProducto, $idCotizacion, $cantidad, $idCotizacionKit, $insertarDetalle, $porcentajesc)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->agregarProductoCotizacion($idProducto, $idCotizacion, $cantidad, $db, $idCotizacionKit, $insertarDetalle, "", $porcentajesc);

        return $respuesta;
    }

    function hacerCopiaCotizacion($idCotizacion)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->hacerCopiaCotizacion($idCotizacion,$db);

        return $respuesta;
    }

    function archivarCotizacion($idCotizacion)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->archivarCotizacion($idCotizacion,$db);

        return $respuesta;
    }


    function eliminarCotizacion($idCotizacion)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->eliminarCotizacion($idCotizacion,$db);

        return $respuesta;
    }


     


    function obtenerExtrasCotizacion($idCotizacion)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->obtenerExtrasCotizacion($idCotizacion);

        return $respuesta;
    }


    function  actualizarExtras($observaciones, $condiciones,$vigencia,$formapago
    ,$idRepresentante,$lugarentrega ,$idCotizacion
    ,$invproveedores,$licitacion,$adjdirecta,$invmercado,$informesrest,$muestras,$fechaentrega)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase-> actualizarExtras($observaciones, $condiciones,$vigencia,$formapago
        ,$idRepresentante,$lugarentrega ,$idCotizacion
        ,$invproveedores,$licitacion,$adjdirecta,$invmercado,$informesrest,$muestras,$fechaentrega);

        return $respuesta;
    }



    function  generarPedido($idCotizacion)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase-> generarPedido($idCotizacion);

        return $respuesta;
    }


   
    function eliminarProductoPedido($idCotizacionProd)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->eliminarProductoPedido($idCotizacionProd);

        return $respuesta;
    }


    function eliminarKitPedido($idCotizacionKit)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->eliminarKitPedido($idCotizacionKit);

        return $respuesta;
    }
    

    function eliminarProductoCotizacion($idCotizacionProd)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->eliminarProductoCotizacion($idCotizacionProd);

        return $respuesta;
    }

    function eliminarKitCotizacion($idCotizacionKit)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->eliminarKitCotizacion($idCotizacionKit);

        return $respuesta;
    }


    function actualizarSobreCostoKit($idCotizacionKit,$porcentajesc)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->actualizarSobreCostoKit($idCotizacionKit,$porcentajesc);

        return $respuesta;
    }



    function actualizarCantidadKit($idCotizacionKit,$porcentajesc)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->actualizarCantidadKit($idCotizacionKit,$porcentajesc);

        return $respuesta;
    }


    function actualizarCantidadCotKit($idCotizacionKit,$cantidad)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->actualizarCantidadCotKit($idCotizacionKit,$cantidad);

        return $respuesta;
    }

    


    function actualizarCantidadProducto($idCotizacionProd,$porcentajesc)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->actualizarCantidadProducto($idCotizacionProd,$porcentajesc);

        return $respuesta;
    }

    
    function actualizarSobreCostoProducto($idCotizacionProd,$porcentajesc)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->actualizarSobreCostoProducto($idCotizacionProd,$porcentajesc);

        return $respuesta;
    }

    function actualizarCantidadCotProducto($idCotizacionProd,$cantidad)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->actualizarCantidadCotProducto($idCotizacionProd,$cantidad);

        return $respuesta;
    }
    
    


    function agregarKitCotizacion($idKit, $idCotizacion, $cantidad, $insertarDetalle, $porcentajesc)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $contAd = new AdministradorController();
        
        $respuesta = $clase->agregarKitCotizacion($idKit, $idCotizacion, $cantidad, $db, $insertarDetalle, $porcentajesc,
        $contAd->obtenerValorParametro("tc")->valor);

        return $respuesta;
    }


    function actualizarHeaders($tc, $porcentajesc, $directosc, $idCotizacion,$descuento)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $respuesta = $clase->actualizarHeaders($tc, $porcentajesc, $directosc, $idCotizacion,$descuento);

        return $respuesta;
    }




    function recalcular($idCotizacion)
    {
        $database = new Database();
        $db = $database->getConnection();
        $clase = new CotizacionModel($db);
        $cotizacion = $clase->obtenerCotizacion($idCotizacion,"C",false);
        $clase->borrarTodo($idCotizacion);
        $kits = $cotizacion->registros[0]['kits'];
        $productos = $cotizacion->registros[0]['productos'];
        $contAd = new AdministradorController();
        foreach ($kits as $kit) {
            $clase->agregarKitCotizacion($kit['idKit'], $idCotizacion, $kit['cantidad'], $db, true, $kit['porcentajesc'],
            $contAd->obtenerValorParametro("tc")->valor);
        }

        foreach ($productos as $prod) {
            $clase->agregarProductoCotizacion(
                $prod['idProducto'],
                $idCotizacion,
                $prod['cantidad'],
                $db,
                "",
                true,
                "",
                $prod['porcentajesc']
            );
        }

        //despues volvemos a consultar // para sacar el total
        $cotizacion = $clase->obtenerCotizacion($idCotizacion,"C",false);
        $kits = $cotizacion->registros[0]['kits'];
        $productos = $cotizacion->registros[0]['productos'];
       
        $directosc = $cotizacion->registros[0]['directosc'];
        $descuento = $cotizacion->registros[0]['descuento'];
        $totalCotizacion = 0;
        $totalsc=0;
        foreach ($kits as $kit) {
            $totalCotizacion += $kit['subtotal'];
            $totalsc += $kit['subtotalsc'];
        }

        foreach ($productos as $prod) {
            $totalCotizacion += $prod['subtotal'];
            $totalsc += $prod['subtotalsc'];
        }
        
       

        if ($directosc > 0) {
            $totalsc += $directosc;
        }
        $grantotal=$totalsc;
        if($descuento!="" && $descuento>0)
        {
            $grantotal=$totalsc-($descuento*$totalsc/100);

        }

        $clase->actualizarTotales($totalCotizacion, $totalsc, $idCotizacion,$grantotal);
    }
}
