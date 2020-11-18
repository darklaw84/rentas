<?php


include_once './controllers/PropiedadesController.php';
include_once './utils/convertirnumeroletra.php';



require('fpdf.php');

class PDFN extends FPDF
{
    // Page header



    function Header()
    {
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}


class GenerarRecibo
{

    public function __construct()
    {
    }

    function generarRecibo($idRecibo)
    {
        // Instanciation of inherited class

        $controller = new PropiedadesController();
        $letras = new CifrasEnLetras();

       $recibo= $controller->obtenerRecibo($idRecibo)->registros[0];

       $fecha = $recibo['fecha'];
       $monto = $recibo['monto'];
       $fechaPago = $recibo['fechaPago'];
       $nombre = $recibo['nombre'];
       $apellidos = $recibo['apellidos'];
       $direccion = $recibo['direccion'];
       $metodoPago = $recibo['metodoPago'];
       $msjLetras=$letras->convertirPesosEnLetras($monto, 2);

        $tipo = "Mtto.";
       if($recibo['tipo']=="R")
       {
        $tipo = "Renta";
       }

        $bor = 1;
        $pdf = new PDFN();

        $pdf->AliasNbPages();
        $pdf->AddPage('L','A5');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(140, 10, utf8_decode('   '.$recibo['nombreRecibo']), 'T L R', 0);
        $pdf->Cell(2, 10, '', 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 6, 'Recibo de Arrendamiento', 'T L R', 1,'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10,20);
        $pdf->MultiCell(140, 5,utf8_decode( '   '.$recibo['direccionRecibo']), 'L R B');
        $pdf->SetXY(152,16);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 9, '# '.$idRecibo, 'R L B', 1,'C');
        $pdf->SetXY(10,28);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 8, utf8_decode('Recibí de :'), 'T L', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(170, 8, utf8_decode($nombre.' '.$apellidos), 'T B', 0);
        $pdf->Cell(2, 8, '', 'R T', 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 8, utf8_decode('Domicilio del Inmueble :'), 'L', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(145, 8, utf8_decode($direccion), 'B', 0);
        $pdf->Cell(2, 8, '', 'R ', 1);
       
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(90, 8, utf8_decode('Por concepto de '.$tipo.' correspondiente al mes de :'), 'L', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(100, 8, utf8_decode(substr($fecha,0,7)), 'B', 0);
        $pdf->Cell(2, 8, '', 'R ', 1);


        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 8, utf8_decode('La cantidad de :'), 'L', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(160, 8, utf8_decode('$ '.$monto.' '.$msjLetras ), 'B', 0);
        $pdf->Cell(2, 8, '', 'R ', 1);


        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 8, utf8_decode('Método de pago :'), 'L', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(160, 8, utf8_decode($metodoPago), 'B', 0);
        $pdf->Cell(2, 8, '', 'R ', 1);


        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 8, utf8_decode('México D.F. a :'), 'L', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(160, 8, utf8_decode($fechaPago), 'B', 0);
        $pdf->Cell(2, 8, '', 'R ', 1);


        $pdf->Cell(192, 40, '', 'B R L', 1);

        $pdf->Image('./imagenes/icono.jpg',80,83,30,30);

        $nombreRecibo= "Recibo".$idRecibo.".pdf";
        $path = getcwd();
        $pdf->Output($path."\\recibos\\".$nombreRecibo,"F");
        //$pdf->Output();

        return $nombreRecibo;
    }
}
