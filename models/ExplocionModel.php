<?php

include_once 'RespuestaBD.php';
include_once 'CotizacionModel.php';





class ExplocionModel
{

    // database connection and table name
    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }


    function obtenerExplocion($idCotizacion, $db, $tc)
    {


        $query = "SELECT  idCotizacionProd,cantidad,clave, descCorta FROM  cotizacion_productos cp 
         inner join productos p  on p.idProducto= cp.idProducto
             where idCotizacionProdPadre is null and vigentePedido=1
             and idCotizacion = " . $idCotizacion;


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();





        $arreglo = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);

            $resInsumos = $this->obtenerInsumosProducto($idCotizacionProd, $cantidad, $db, $tc,true);
            $registro_item = array(
                "descCorta" => $descCorta,
                "clave" => $clave,
                "cantidad" => $cantidad,
                "insumos" => $resInsumos
            );
            array_push($arreglo, $registro_item);
        }



        return $arreglo;
    }




    function obtenerInsumosProducto($idCotizacionProdConsulta, $cantidadProducto, $db, $tc, $primero)
    {

        $arreglo = array();


        $cotModel = new CotizacionModel($db);

        if (!$primero) {

            $resProd = $cotModel->obtenerProductoCotizacion($idCotizacionProdConsulta, $tc, "P");
            $producto = $resProd->registros[0];
            $registro_item = array(
                "cantidad" => 1,
                "clave" => $producto['clave'],
                "unidad" => $producto['unidad'],
                "preciounitario" => $producto['preciounitario'],
                "insumo" => $producto['descCorta'],
                "tipo" => "prod"
            );
            array_push($arreglo, $registro_item);
        }

        //INICIAMOS CON LOS INSUMOS DEL PRODUCTO
        $query = "SELECT  * FROM  cotizacion_producto_insmproc 
             where idCotizacionProd =$idCotizacionProdConsulta ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);
            $existe = false;
            $index = 0;
            foreach ($arreglo as $insumo) {
                if($insumo['clave']=="003165180285")
                {
                    $sumar=0;
                }
                if ($insumo['clave'] == $clave) {
                    $existe = true;
                    $cantidadAnterior = $insumo['cantidad'];
                    $cantidadNueva = $cantidad + $cantidadAnterior;
                    $insumo['cantidad'] = $cantidadNueva;
                    $arreglo[$index] = $insumo;
                    break;
                }
                $index++;
            }
            if (!$existe) {

                $registro_item = array(
                    "cantidad" => $cantidad,
                    "clave" => $clave,
                    "unidad" => $unidad,
                    "preciounitario" => $preciounitario,
                    "insumo" => $insumproc,
                    "tipo" => "insumo"
                );
                array_push($arreglo, $registro_item);
            }
        }


        //HACEMOS LA PARTE RECURSIVA PARA TRAER LOS INSUMOS DE LOS PRODUCTOS HIJOS 

        $query = "select idCotizacionProd,cantidad from cotizacion_productos
         where idCotizacionProdPadre = " . $idCotizacionProdConsulta;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $arregloInterno = $this->obtenerInsumosProducto($idCotizacionProd, $cantidad, $db, $tc, false);
            foreach ($arregloInterno as $insumoInterno) {
                $existe = false;
                $index = 0;
                foreach ($arreglo as $insumo) {
                    if($insumo['clave']=="003165180285")
                    {
                        $sumar=0;
                    }
                    if ($insumo['clave'] == $insumoInterno['clave']) {
                        $existe = true;
                        $cantidadAnterior = $insumo['cantidad'];
                        $cantidadNueva = $insumoInterno['cantidad'] + $cantidadAnterior;
                        $insumo['cantidad'] = $cantidadNueva;
                        $arreglo[$index] = $insumo;
                        break;
                    }
                    $index++;
                }
                if (!$existe) {

                    $registro_item = array(
                        "cantidad" => $insumoInterno['cantidad'],
                        "clave" => $insumoInterno['clave'],
                        "unidad" => $insumoInterno['unidad'],
                        "preciounitario" => $insumoInterno['preciounitario'],
                        "insumo" => $insumoInterno['insumo'],
                        "tipo" => $insumoInterno['tipo']
                    );
                    array_push($arreglo, $registro_item);
                }
            }
        }


        //AL FINAL TENEMOS EL ARREGLO CON TODOS LOS INSUMOS Y POR CADA UNO MULTIPLICAMOS LA CANTIDAD

        $index = 0;
        foreach ($arreglo as $insumo) {
            if($insumo['clave']=="003165180285")
            {
                $sumar=0;
            }

            $cantidadAnterior = $insumo['cantidad'];

            $cantidadNueva = $cantidadProducto * $cantidadAnterior;

            $insumo['cantidad'] = $cantidadNueva;
            $arreglo[$index] = $insumo;

            $index++;
        }


        return $arreglo;
    }

    function obtenerTcCotizacion($idCotizacion)
    {

        $query = "SELECT tc from cotizaciones where idCotizacion=" . $idCotizacion;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $valor = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $valor = $tc;
        }

        return $valor;
    }
}
