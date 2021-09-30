<?php

require_once __DIR__ . '/vendor/autoload.php';


include_once './controllers/PropiedadesController.php';

$controller = new PropiedadesController();
$idContrato = $_GET['idContrato'];

if (isset($idContrato)) {

    $respPro = $controller->obtenerContrato($idContrato)->registros[0];
}


$mpdf = new \Mpdf\Mpdf();
$mpdf->setFooter('{PAGENO}');

$mpdf->WriteHTML($respPro['textoContrato']);

$mpdf->Output();
