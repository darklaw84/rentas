<?php

include_once './controllers/PropiedadesController.php';
include_once './utilMail.php';

$controller = new PropiedadesController();
$utilMail = new UtilMail();


$utilMail->enviarCorreoVencePago("darklaw84@gmail.com","vence pago", "vence el pinche pago");




