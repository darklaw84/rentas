<?php

include_once 'RespuestaBD.php';
include_once 'CatalogosModel.php';




class CotizacionModel
{

    // database connection and table name
    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }


    function obtenerCotizaciones($tipo)
    {

        if ($tipo == "C") {
            $query = "SELECT  co.*,cl.clave,cl.cliente FROM  cotizaciones co
             inner join clientes cl on co.idCliente = cl.idCliente
             where noaceptada=0 and pedido is null
               order by fecha desc ";
        } else if($tipo=="P") {
            $query = "SELECT  co.*,cl.clave,cl.cliente FROM  cotizaciones co
            inner join clientes cl on co.idCliente = cl.idCliente
            where pedido = 1
              order by fecha desc ";
        } else if($tipo=="N"){
            $query = "SELECT  co.*,cl.clave,cl.cliente FROM  cotizaciones co
            inner join clientes cl on co.idCliente = cl.idCliente
            where  noaceptada=1 
              order by fecha desc ";
        }  else if($tipo=="F"){
            $query = "SELECT  co.*,cl.clave,cl.cliente FROM  cotizaciones co
            inner join clientes cl on co.idCliente = cl.idCliente
            where  pedido=1 
              order by fecha desc ";
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

                $resCotizacion = $this->obtenerCotizacion($idCotizacion, $tipo,false);

                array_push($arreglo, $resCotizacion->registros[0]);
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


    function obtenerProductoCotizacion($idCotizacionProd, $tc,$tipo)
    {


        $query = "SELECT  ip.*,u.unidad ,l.linea FROM  productos ip
        inner join cotizacion_productos cp on cp.idProducto=ip.idProducto
             inner join unidades u on u.idunidad = ip.idUnidad
             left join lineas l on l.idLinea = ip.idLinea
                where cp.idCotizacionProd=" . $idCotizacionProd;


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

                $resInsumos = $this->obtenerInsumosProductoCotizacion($idCotizacionProd);
                $resProductos = $this->obtenerProductosProducto($idCotizacionProd, $tc,$tipo);
                $productos = $resProductos->registros;
                $resCosto = $this->obtenerCostoProductoCotizacion($idCotizacionProd, $tc);
                $costoTotal = $resCosto->valor;
                foreach ($productos as $prod) {

                    $costoTotal += $prod['preciounitario'] * $prod['cantidad'];
                }
                $registro_item = array(
                    "idCotizacionProd" => $idCotizacionProd,
                    "clave" => $clave,
                    "descLarga" => $descLarga,
                    "descCorta" => $descCorta,
                    "idUnidad" => $idUnidad,
                    "idLinea" => $idLinea,
                    "unidad" => $unidad,
                    "linea" => $linea,
                    "preciounitario" => $costoTotal,
                    "moneda" => "MXN",
                    "linea" => $linea,
                    "cantidad" => "1",
                    "insumos" => $resInsumos->registros,
                    "productos" => $resProductos->registros

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


    function obtenerProductosProducto($idCotizacionProd, $tc,$tipo)
    {

        if($tipo=="C")
        {

        $query = "SELECT  idCotizacionProd,cantidad 
        FROM  cotizacion_productos 
                       where idCotizacionProdPadre=" . $idCotizacionProd;
        }
        else
        {
            $query = "SELECT  idCotizacionProd,cantidadPedido as cantidad  
            FROM  cotizacion_productos 
                           where idCotizacionProdPadre=" . $idCotizacionProd;
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
             
                extract($row);

                $resProducto = $this->obtenerProductoCotizacion($idCotizacionProd, $tc,$tipo);
                $producto = $resProducto->registros[0];
                $producto['cantidad'] = $cantidad;


                array_push($arreglo, $producto);
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



    function obtenerInsumosProductoCotizacion($idCotizacionProd)
    {


        $query = "SELECT  proi.*
         FROM  cotizacion_producto_insmproc proi
       
       where proi.idCotizacionProd=" . $idCotizacionProd;


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

                //aqui vamos a ir por sus componentes para agregarlos al arreglo

                $registro_item = array(
                    "idCotizacionProdInsumProc" => $idCotizacionProdInsumProc,
                    "clave" => $clave,
                    "insumproc" => $insumproc,
                    "cantidad" => $cantidad,
                    "unidad" => $unidad,
                    "preciounitario" => $preciounitario,
                    "moneda" => $moneda

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



    function obtenerCotizacion($idCotizacion, $tipo,$conInsumos)
    {


        $query = "SELECT  co.*,cl.clave,cl.cliente,cl.direccion,cl.representante,cl.direccion FROM  cotizaciones co
             inner join clientes cl on co.idCliente = cl.idCliente
               where idCotizacion= " . $idCotizacion;


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
                if ($pedido == null) {
                    $pedido = 0;
                }

                $resProds = $this->obtenerProductosCotizacion($idCotizacion, $tc, "", $tipo,$conInsumos);
                $resKits = $this->obtenerKitsCotizacion($idCotizacion, $tc,$tipo,$conInsumos);

                $totalSCMostrar=0;
                $granTotalMostrar=0;
                $montoTotalMostrar=0;
                if($tipo=="C")
                {
                    $totalSCMostrar=$totalsc;
                    $granTotalMostrar=$grantotal;
                    $montoTotalMostrar=$montototal;
                }
                else
                {
                        foreach($resProds->registros as $prod)
                        {
                           $montoTotalMostrar+= $prod['subtotal'];
                           $totalSCMostrar+= $prod['subtotalsc'];
                        }

                        foreach($resKits->registros as $prod)
                        {
                           $montoTotalMostrar+= $prod['subtotal'];
                           $totalSCMostrar+= $prod['subtotalsc'];
                        }

                        $granTotalMostrar=$totalSCMostrar-($totalSCMostrar*$descuento/100);
                }




                $registro_item = array(
                    "idCotizacion" => $idCotizacion,
                    "cliente" => $cliente,
                    "clave" => $clave,
                    "numCotCliente" => $numCotCliente,
                    "fecha" => $fecha,
                    "montoTotal" => $montoTotalMostrar,
                    "descuento" => $descuento,
                    "grantotal" => $granTotalMostrar,
                    "representante" => $representante,
                    "direccion" => $direccion,
                    "noaceptada" => $noaceptada,
                    "porcentajesc" => $porcentajesc,
                    "directosc" => $directosc,
                    "pedido" => $pedido,
                    "totalsc" => $totalSCMostrar,
                    "tc" => $tc,
                    "productos" => $resProds->registros,
                    "kits" => $resKits->registros

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




    function hacerCopiaCotizacion($idCotizacion,$db)
    {


        $query = "insert into cotizaciones(idcliente,numCotCliente,fecha,montototal,noaceptada,porcentajesc,directosc
        ,totalsc,tc,descuento,observaciones,condiciones,vigencia,formapago,lugarentrega,idRepresentante,grantotal,pedido)
           select idcliente,numCotCliente,fecha,montototal,0,porcentajesc,directosc
        ,totalsc,tc,descuento,observaciones,condiciones,vigencia,formapago,lugarentrega,
        idRepresentante,grantotal,null from cotizaciones where idCotizacion= " . $idCotizacion;


        
        $stmt = $this->conn->prepare($query);

                $stmt->execute();
        $idCotizacionNueva = $this->conn->lastInsertId();

        $query="select idProducto,cantidad,porcentajesc from cotizacion_productos 
        where idCotizacionProdPadre is null and idCotizacionKit is null and idCotizacion=".$idCotizacion;
        
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        
            $arreglo = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                
                extract($row);
               
                $this->agregarProductoCotizacion($idProducto, $idCotizacionNueva, $cantidad,$db, "", false,"", $porcentajesc);

                
            }
          return $idCotizacionNueva; 

    }



   



    function obtenerKitsCotizacion($idCotizacion, $tc,$tipo,$conInsumos)
    {


        if($tipo="C")
        {

        $query = "SELECT ck.idCotizacionKit,ck.idKit, kt.kit,ck.cantidad,kt.clave,ck.porcentajesc FROM  cotizacion_kits ck
             inner join kits kt on kt.idKit = ck.idKit where idCotizacion = " . $idCotizacion . "
             ";
        }
        else
        {
            $query = "SELECT ck.idCotizacionKit,ck.idKit, kt.kit,ck.cantidadPedido as cantidad,kt.clave,ck.porcentajesc
             FROM  cotizacion_kits ck
             inner join kits kt on kt.idKit = ck.idKit where vigentePedido=1 and idCotizacion = " . $idCotizacion . "
             "; 
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
                $resProductos = $this->obtenerProductosCotizacion($idCotizacion, $tc, $idCotizacionKit,$tipo,$conInsumos);
                $productos = $resProductos->registros;
                $preciounitario = 0;
                foreach ($productos as $prod) {
                    $preciounitario += $prod['subtotal'];
                }
                $subtotal = $preciounitario * $cantidad;
                $subtotalsc = $subtotal + ($subtotal * $porcentajesc / 100);
                $registro_item = array(
                    "idCotizacionKit" => $idCotizacionKit,
                    "kit" => $kit,
                    "idKit" => $idKit,
                    "clave" => $clave,
                    "cantidad" => $cantidad,
                    "preciounitario" => $preciounitario,
                    "subtotal" => $subtotal,
                    "subtotalsc" => $subtotalsc,
                    "porcentajesc" => $porcentajesc,
                    "productos" => $productos

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


    function agregarProductoCotizacion(
        $idProducto,
        $idCotizacion,
        $cantidad,
        $db,
        $idCotizacionKit,
        $insertarDetalle,
        $idCotizacionProdPadre,
        $porcentajesc
    ) {

        $this->actualizarPorcentajeSC($porcentajesc, $idCotizacion);

        if ($idCotizacionKit == "") {

            if ($idCotizacionProdPadre == "") {
                $query = "INSERT INTO
        cotizacion_productos
    SET
    idProducto=:idProducto, idCotizacion=:idCotizacion,cantidad=:cantidad,porcentajesc=:porcentajesc";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":idProducto", $idProducto);
                $stmt->bindParam(":idCotizacion", $idCotizacion);
                $stmt->bindParam(":cantidad", $cantidad);
                $stmt->bindParam(":porcentajesc", $porcentajesc);
            } else {
                $query = "INSERT INTO
                cotizacion_productos
            SET
            idProducto=:idProducto, idCotizacion=:idCotizacion,cantidad=:cantidad,
            idCotizacionProdPadre=:idCotizacionProdPadre,porcentajesc=:porcentajesc";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":idProducto", $idProducto);
                $stmt->bindParam(":idCotizacion", $idCotizacion);
                $stmt->bindParam(":cantidad", $cantidad);
                $stmt->bindParam(":idCotizacionProdPadre", $idCotizacionProdPadre);
                $stmt->bindParam(":porcentajesc", $porcentajesc);
            }
        } else {
            $query = "INSERT INTO
            cotizacion_productos
        SET
        idProducto=:idProducto, idCotizacion=:idCotizacion,
        idCotizacionKit=:idCotizacionKit,cantidad=:cantidad,porcentajesc=:porcentajesc";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":idProducto", $idProducto);
            $stmt->bindParam(":idCotizacion", $idCotizacion);
            $stmt->bindParam(":cantidad", $cantidad);
            $stmt->bindParam(":idCotizacionKit", $idCotizacionKit);
            $stmt->bindParam(":porcentajesc", $porcentajesc);
        }
        $stmt->execute();
        $idInsertado = $this->conn->lastInsertId();
        $catModel = new CatalogosModel($db);
        $resProducto = $catModel->obtenerProductosProducto($idProducto, "1");
        $productos = $resProducto->registros;
        foreach ($productos as $prod) {
            $this->agregarProductoCotizacion(
                $prod['idProducto'],
                $idCotizacion,
                $prod['cantidad'],
                $db,
                "",
                $insertarDetalle,
                $idInsertado,
                $porcentajesc
            );
        }



        if ($insertarDetalle) {


            $resProducto = $catModel->obtenerInsumosProducto($idProducto);
            $insumos = $resProducto->registros;

            //por cada insumo insertamos 
            foreach ($insumos as $ins) {
                $this->agregarInsumoProceso(
                    $idInsertado,
                    $idCotizacion,
                    $ins['idProdInsumo'],
                    $ins['clave'],
                    $ins['insumoproc'],
                    $ins['unidad'],
                    $ins['preciounitario'],
                    $ins['moneda'],
                    $ins['cantidad']
                );
            }
        }

        // execute query

    }




    function borrarTodo($idCotizacion)
    {


        $query = "DELETE FROM  cotizacion_productos
                        WHERE idCotizacion=" . $idCotizacion;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $query = "DELETE FROM  cotizacion_kits
        WHERE idCotizacion=" . $idCotizacion;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();


        $query = "DELETE FROM  cotizacion_producto_insmproc
        WHERE idCotizacion=" . $idCotizacion;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }



    function actualizarTotales($totalCotizacion, $totalsc, $idCotizacion, $granTotal)
    {


        $query = "update  cotizaciones set montototal=" . $totalCotizacion . ",
            totalsc=" . $totalsc .  ", grantotal = " . $granTotal . "
                        WHERE idCotizacion=" . $idCotizacion;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }


    function archivarCotizacion($idCotizacion)
    {


        $query = "update  cotizaciones set noaceptada=1 WHERE idCotizacion=" . $idCotizacion;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }


    function eliminarCotizacion($idCotizacion)
    {


        $query = "delete from cotizacion_producto_insmproc where idCotizacionProd in 
        (select idCotizacionProd from cotizacion_productos where idCotizacion = ".$idCotizacion.")";


        $stmt = $this->conn->prepare($query);
        $stmt->execute();


        $query = "delete from cotizacion_productos where idCotizacion = ".$idCotizacion;


        $stmt = $this->conn->prepare($query);
        $stmt->execute();


        $query = "delete from cotizaciones where idCotizacion = ".$idCotizacion;


        $stmt = $this->conn->prepare($query);
        $stmt->execute();


    }


    function actualizarExtras(
        $observaciones,
        $condiciones,
        $vigencia,
        $formapago,
        $idRepresentante,
        $lugarentrega,
        $idCotizacion
        ,$invproveedores,$licitacion,$adjdirecta,$invmercado,$informesrest,$muestras,$fechaentrega
    ) {


        $query = "update  cotizaciones set observaciones=:observaciones,
        condiciones=:condiciones,vigencia=:vigencia,formapago=:formapago,
        invproveedores=:invproveedores,licitacion=:licitacion,adjdirecta=:adjdirecta,
        invmercado=:invmercado,informesrest=:informesrest,muestras=:muestras,
        fechaentrega=:fechaentrega,
        lugarentrega=:lugarentrega,idRepresentante=:idRepresentante  WHERE idCotizacion=" . $idCotizacion;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":observaciones", $observaciones);
        $stmt->bindParam(":condiciones", $condiciones);
        $stmt->bindParam(":vigencia", $vigencia);
        $stmt->bindParam(":formapago", $formapago);
        $stmt->bindParam(":lugarentrega", $lugarentrega);
        $stmt->bindParam(":idRepresentante", $idRepresentante);

        $stmt->bindParam(":invproveedores", $invproveedores);
        $stmt->bindParam(":licitacion", $licitacion);
        $stmt->bindParam(":adjdirecta", $adjdirecta);
        $stmt->bindParam(":invmercado", $invmercado);
        $stmt->bindParam(":informesrest", $informesrest);
        $stmt->bindParam(":muestras", $muestras);
        $stmt->bindParam(":fechaentrega", $fechaentrega);
        $stmt->execute();
    }


    function generarPedido($idCotizacion)
    {


        $query = "update  cotizaciones set pedido=1  WHERE idCotizacion=" . $idCotizacion;
        $stmt = $this->conn->prepare($query);

        $stmt->execute();



        $query = "update  cotizacion_productos set cantidadPedido=cantidad, vigentePedido=1  WHERE idCotizacion=" . $idCotizacion;
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
    }


    function actualizarPorcentajeSC($porcentajesc, $idCotizacion)
    {


        $query = "update  cotizaciones set porcentajesc=" . $porcentajesc . "
              WHERE idCotizacion=" . $idCotizacion;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }



    function eliminarProductoCotizacion($idCotizacionProd)
    {

        //primero borramos los hijos si es que hay
        $query = "delete from cotizacion_productos where idCotizacionProdPadre=" . $idCotizacionProd;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        //luego borramos al papa
        $query = "delete from cotizacion_productos where idCotizacionProd=" . $idCotizacionProd;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }



    function eliminarProductoPedido($idCotizacionProd)
    {

        $query = "update cotizacion_productos set vigentePedido=0 where idCotizacionProd=" . $idCotizacionProd;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

       
    }


    function eliminarKitPedido($idCotizacionKit)
    {

        $query = "update cotizacion_kits set vigentePedido=0 where idCotizacionKit=" . $idCotizacionKit;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
      
    }


    function eliminarKitCotizacion($idCotizacionKit)
    {


        //luego borramos al papa
        $query = "delete from cotizacion_kits where idCotizacionKit=" . $idCotizacionKit;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }

    function actualizarSobreCostoKit($idCotizacionKit, $porcentajesc)
    {


        //luego borramos al papa
        $query = "update cotizacion_kits set porcentajesc=" . $porcentajesc . " where idCotizacionKit=" . $idCotizacionKit;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }


    function actualizarCantidadCotKit($idCotizacionKit, $cantidad)
    {

        $query = "update cotizacion_kits set cantidad=" . $cantidad . " where idCotizacionKit=" . $idCotizacionKit;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }


    function actualizarCantidadKit($idCotizacionKit, $porcentajesc)
    {


        //luego borramos al papa
        $query = "update cotizacion_kits set cantidadPedido=" . $porcentajesc . " where idCotizacionKit=" . $idCotizacionKit;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }


    function actualizarCantidadProducto($idCotizacionProd, $porcentajesc)
    {


        //luego borramos al papa
        $query = "update cotizacion_productos set cantidadPedido=" . $porcentajesc . " where idCotizacionProd=" . $idCotizacionProd;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }


    function actualizarSobreCostoProducto($idCotizacionProd, $porcentajesc)
    {


        //luego borramos al papa
        $query = "update cotizacion_productos set porcentajesc=" . $porcentajesc . " where idCotizacionProd=" . $idCotizacionProd;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }



    function actualizarCantidadCotProducto($idCotizacionProd, $cantidad)
    {


        //luego borramos al papa
        $query = "update cotizacion_productos set cantidad=" . $cantidad . " where idCotizacionProd=" . $idCotizacionProd;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }


    function actualizarHeaders($tc, $porcentajesc, $directosc, $idCotizacion, $descuento)
    {


        $query = "update  cotizaciones set tc=" . $tc . ",
        porcentajesc=" . $porcentajesc . ",
        descuento=" . $descuento . ", directosc=" . $directosc . "
                        WHERE idCotizacion=" . $idCotizacion;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }


    function agregarInsumoProceso(
        $idCotizacionProd,
        $idCotizacion,
        $idInsumoProc,
        $clave,
        $insumproc,
        $unidad,
        $preciounitario,
        $moneda,
        $cantidad
    ) {

        //primero insertamos 
        $query = "INSERT INTO
        cotizacion_producto_insmproc
    SET
    idCotizacionProd=:idCotizacionProd, idCotizacion=:idCotizacion,
    idInsumoProc=:idInsumoProc, clave=:clave,
    insumproc=:insumproc, unidad=:unidad, 
    preciounitario=:preciounitario,moneda=:moneda,cantidad=:cantidad";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idCotizacionProd", $idCotizacionProd);
        $stmt->bindParam(":idCotizacion", $idCotizacion);
        $stmt->bindParam(":idInsumoProc", $idInsumoProc);
        $stmt->bindParam(":clave", $clave);
        $stmt->bindParam(":insumproc", $insumproc);
        $stmt->bindParam(":unidad", $unidad);
        $stmt->bindParam(":preciounitario", $preciounitario);
        $stmt->bindParam(":moneda", $moneda);
        $stmt->bindParam(":cantidad", $cantidad);
        if (!$stmt->execute()) {

            $mensaje = $stmt->errorInfo();
        }
    }





    function agregarKitCotizacion($idKit, $idCotizacion, $cantidad, $db, $insertarDetalle, $porcentajesc,$tc)
    {

        $this->actualizarPorcentajeSC($porcentajesc, $idCotizacion);

        $query = "INSERT INTO
            cotizacion_kits
        SET
        idKit=:idKit, idCotizacion=:idCotizacion,
        cantidad=:cantidad,porcentajesc=:porcentajesc";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idKit", $idKit);
        $stmt->bindParam(":idCotizacion", $idCotizacion);
        $stmt->bindParam(":cantidad", $cantidad);
        $stmt->bindParam(":porcentajesc", $porcentajesc);


        $stmt->execute();
        $idInsertado = $this->conn->lastInsertId();

        $catModel = new CatalogosModel($db);

        $resKit = $catModel->obtenerProductosKit($idKit,$tc);
        $productos = $resKit->registros;

        //por cada insumo insertamos 
        foreach ($productos as $ins) {
            $this->agregarProductoCotizacion(

                $ins['idProducto'],
                $idCotizacion,
                $ins['cantidad'],
                $db,
                $idInsertado,
                $insertarDetalle,
                "",
                $porcentajesc
            );
        }



        // execute query

    }




    function obtenerProductosCotizacion($idCotizacion, $tc, $idCotizacionKit, $tipo,$conInsumos)
    {

        if ($idCotizacionKit == "") {

            if ($tipo == "C") {

                $query = "SELECT cp.idProducto,cp.idCotizacionProd,u.unidad, p.descCorta,cp.cantidad,p.clave,cp.porcentajesc FROM  cotizacion_productos cp
        inner join productos p on p.idProducto = cp.idProducto
        inner join unidades u on u.idUnidad=p.idUnidad
        where cp.idCotizacionKit is null and idCotizacionProdPadre is null and cp.idCotizacion=" . $idCotizacion;
            } else {
                $query = "SELECT cp.idProducto,cp.idCotizacionProd,u.unidad, p.descCorta,cp.cantidadPedido as cantidad ,p.clave,cp.porcentajesc FROM  cotizacion_productos cp
                inner join productos p on p.idProducto = cp.idProducto
                inner join unidades u on u.idUnidad=p.idUnidad
                where cp.idCotizacionKit is null and vigentePedido=1 and idCotizacionProdPadre is null and cp.idCotizacion=" . $idCotizacion;
            }
        } else {
            if ($tipo == "C") {

                $query = "SELECT cp.idProducto,cp.idCotizacionProd,u.unidad, p.descCorta,cp.cantidad,p.clave,cp.porcentajesc FROM  cotizacion_productos cp
        inner join productos p on p.idProducto = cp.idProducto
        inner join unidades u on u.idUnidad=p.idUnidad
        where cp.idCotizacionKit =" . $idCotizacionKit . " and idCotizacionProdPadre is null and cp.idCotizacion=" . $idCotizacion;
            } else {
                $query = "SELECT cp.idProducto,cp.idCotizacionProd,u.unidad, p.descCorta,cp.cantidadPedido as cantidad,p.clave,cp.porcentajesc FROM  cotizacion_productos cp
        inner join productos p on p.idProducto = cp.idProducto
        inner join unidades u on u.idUnidad=p.idUnidad
        where cp.idCotizacionKit =" . $idCotizacionKit . " and vigentePedido=1 and idCotizacionProdPadre is null and cp.idCotizacion=" . $idCotizacion;
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
                $resprecio = $this->obtenerCostoProductoCotizacion($idCotizacionProd, $tc);
                $subtotal = $resprecio->valor;


                $resProductos = $this->obtenerProductosProducto($idCotizacionProd, $tc,$tipo);
                $productos = $resProductos->registros;

                foreach ($productos as $prod) {

                    $subtotal += $prod['preciounitario'] * $prod['cantidad'];
                }
                $subtotalsc = $subtotal + ($subtotal * $porcentajesc / 100);

                $insumos= array();

                if($conInsumos)
                {
                        $resInsumos=$this->obtenerinsumosProducto($idCotizacionProd);
                        $insumos=$resInsumos->registros;
                }


                $registro_item = array(
                    "idCotizacionProd" => $idCotizacionProd,
                    "descCorta" => $descCorta,
                    "clave" => $clave,
                    "porcentajesc" => $porcentajesc,
                    "unidad" => $unidad,
                    "idProducto" => $idProducto,
                    "cantidad" => $cantidad,
                    "preciounitario" => $subtotal,
                    "insumosExplocion" => $insumos,
                    "subtotal" => $subtotal * $cantidad,
                    "productos" => $productos,
                    "subtotalsc" => $subtotalsc * $cantidad

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




    function obtenerExtrasCotizacion($idCotizacion)
    {


        $query = "SELECT c.fechaentrega,c.muestras,c.informesrest,c.invmercado,c.adjdirecta,
        c.invproveedores,c.licitacion,c.observaciones,c.condiciones,c.vigencia,c.formapago,
        c.lugarentrega,c.idRepresentante,concat(r.nombre,' - ',r.apellidos) representante,r.cargo puesto
         from cotizaciones c 
            left join usuarios r on r.idUsuario=c.idRepresentante
        where c.idCotizacion =" . $idCotizacion;



        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $arreglo = array();

            $representantes = $this->obtenerUsuarios()->registros;

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);



                $registro_item = array(
                    "fechaentrega" => $fechaentrega,
                    "muestras" => $muestras,
                    "informesrest" => $informesrest,
                    "invmercado" => $invmercado,
                    "adjdirecta" => $adjdirecta,
                    "invproveedores" => $invproveedores,
                    "licitacion" => $licitacion,
                    "idCotizacion" => $idCotizacion,
                    "observaciones" => $observaciones,
                    "condiciones" => $condiciones,
                    "vigencia" => $vigencia,
                    "formapago" => $formapago,
                    "lugarentrega" => $lugarentrega,
                    "representante" => $representante,
                    "puesto" => $puesto,
                    "idRepresentante" => $idRepresentante,
                    "representantes" => $representantes

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


    function obtenerAdministradores()
    {


        $query = "SELECT  *  FROM   usuarios
             where tipo='A' order by nombre, apellidos";


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
                    "nombre" => $nombre,
                    "apellidos" => $apellidos,
                    "correo" => $correo,
                    "cargo" => $cargo,
                    "telefono" => $telefono,
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


    function obtenerUsuarios()
    {


        $query = "SELECT  *  FROM   usuarios
              order by nombre, apellidos";


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
                    "nombre" => $nombre,
                    "apellidos" => $apellidos,
                    "correo" => $correo,
                    "cargo" => $cargo,
                    "telefono" => $telefono,
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


    function obtenerRepresentantes()
    {


        $query = "SELECT * from representantes ";



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
                    "idRepresentante" => $idRepresentante,
                    "representante" => $representante

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


    function obtenerCostoProductoCotizacion($idCotizacionProd, $tc)
    {


        $query = "SELECT preciounitario,moneda,cantidad from cotizacion_producto_insmproc
         where idCotizacionProd=" . $idCotizacionProd;


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();

        if ($num > 0) {

            $costoArticulo = 0;

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);
                $costoInsumo = 0;
                if ($moneda == "MXN") {
                    $costoInsumo = $preciounitario * $cantidad;
                    $costoArticulo += $costoInsumo;
                } else {
                    $costoInsumo = $preciounitario * $cantidad * $tc;
                    $costoArticulo += $costoInsumo;
                }
            }
            $respuesta->mensaje = "";
            $respuesta->exito = true;
            $respuesta->valor = $costoArticulo;
        } else {
            $respuesta->mensaje = "No se encontraron datos ";
            $respuesta->exito = false;
        }


        return $respuesta;
    }



    function obtenerinsumosProducto($idCotizacionProd)
    {


        $query = "SELECT clave,insumproc,unidad,cantidad from cotizacion_producto_insmproc
         where idCotizacionProd=" . $idCotizacionProd;


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();
        $arreglo = array();
        if ($num > 0) {

            

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);
                $registro_item = array(
                    "clave" => $clave,
                    "unidad" => $unidad,
                    "cantidad" => $cantidad,
                    "insumproc" => $insumproc

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



    function obtenerSiguienteCotizacionCliente($idCliente)
    {


        $query = "select ifnull(max(numcotcliente),0)+1 siguiente 
        from cotizaciones where idCliente=" . $idCliente;


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $respuesta = new RespuestaBD();


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
            $sig = $siguiente;
        }
        $respuesta->mensaje = "";
        $respuesta->exito = true;
        $respuesta->valor = $sig;


        return $respuesta;
    }


    function crearCotizacion($idCliente, $tc)
    {

        $respuesta = new RespuestaBD();

        $res = $this->obtenerSiguienteCotizacionCliente($idCliente);

        $query = "INSERT INTO
                    cotizaciones
                SET
                idCliente=:idCliente, numCotCliente=:numCotCliente, fecha=now(),montoTotal=0,noaceptada='0',
                porcentajesc=0, directosc=0, totalsc=0,descuento=0, tc=:tc";



        // prepare query
        $stmt = $this->conn->prepare($query);


        // bind values
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->bindParam(":numCotCliente", $res->valor);
        $stmt->bindParam(":tc", $tc);




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
}
