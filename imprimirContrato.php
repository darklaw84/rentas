<?php

require_once __DIR__ . '/vendor/autoload.php';


include_once './controllers/PropiedadesController.php';
include_once './utils/convertirnumeroletra.php';
$controller = new PropiedadesController();
$idContrato = $_GET['idContrato'];

if (isset($idContrato)) {

    $respPro = $controller->obtenerContrato($idContrato);
    if ($respPro->exito) {
        $idContrato = $respPro->registros[0]['idContrato'];
        $idPropiedad = $respPro->registros[0]['idPropiedad'];
        $fisica = $respPro->registros[0]['fisica'];
        $fechaIni = $respPro->registros[0]['fechaIni'];
        $fechaFin = $respPro->registros[0]['fechaFin'];
        $domicilioInmueble = strtoupper($respPro->registros[0]['domicilioInmueble']);
        $meses = $respPro->registros[0]['meses'];

        $renta = $respPro->registros[0]['renta'];
        $mantenimiento = $respPro->registros[0]['mantenimiento'];
        $diapago = $respPro->registros[0]['diapago'];

        $aval = strtoupper($respPro->registros[0]['aval']);
        $domicilioArrendador = strtoupper($respPro->registros[0]['domicilioArrendador']);

        $numEscrituraArrendatario = $respPro->registros[0]['numEscrituraArrendatario'];
        $fechaEscrituraArrendatario = $respPro->registros[0]['fechaEscrituraArrendatario'];
        $licenciadoArrendatario =strtoupper( $respPro->registros[0]['licenciadoArrendatario']);

        $notariaArrendatario = $respPro->registros[0]['notariaArrendatario'];
        $folioMercantilArrendatario = $respPro->registros[0]['folioMercantilArrendatario'];
        $domicilioArrendatario =strtoupper( $respPro->registros[0]['domicilioArrendatario']);
        $rfcaval = strtoupper($respPro->registros[0]['rfcaval']);
        $domicilioAval =strtoupper( $respPro->registros[0]['domicilioAval']);
        $nomInq =strtoupper( $respPro->registros[0]['nomInq']);
        $apeInq =strtoupper( $respPro->registros[0]['apeInq']);
        $rfcInq =strtoupper( $respPro->registros[0]['rfcInq']);
        $repInq =strtoupper( $respPro->registros[0]['repInq']);
        $nomProp =strtoupper( $respPro->registros[0]['nomProp']);
        $apeProp =strtoupper( $respPro->registros[0]['apeProp']);
        $rfcProp =strtoupper( $respPro->registros[0]['rfcProp']);
        $repProp =strtoupper( $respPro->registros[0]['repProp']);
        $tipoContrato = $respPro->registros[0]['tipoContrato'];
    }


    $respPro = $controller->obtenerPropiedad($idPropiedad);
    if ($respPro->exito) {
        $idPropiedad = $respPro->registros[0]['idPropiedad'];

        $nombre = strtoupper( $respPro->registros[0]['nombre']);
        $direccion =strtoupper( $respPro->registros[0]['direccion']);

        $descripcion = strtoupper($respPro->registros[0]['descripcion']);
        $renta = $respPro->registros[0]['renta'];
        $propietario =strtoupper( $respPro->registros[0]['propietario']);

        $numescritura = $respPro->registros[0]['numescritura'];
        $fechaEscritura = $respPro->registros[0]['fechaEscritura'];

        $licEscritura =strtoupper( $respPro->registros[0]['licEscritura']);
        $numNotaria = $respPro->registros[0]['numNotaria'];
        $folioMercantil = $respPro->registros[0]['folioMercantil'];

        $superficie = $respPro->registros[0]['superficie'];
        $comprende = $respPro->registros[0]['comprende'];
        $amueblada = $respPro->registros[0]['amueblada'];
        $fotografia = $respPro->registros[0]['fotografia'];
    }
}


$amueblado="";

if($amueblada)
{
    $amueblado=" pero no cuenta con ning&uacute;n tipo de mueble ";
}

if($mantenimiento>0)
{
    $textoMant="<p>Adicionalmente al pago de la Renta<strong>, </strong>el ARRENDATARIO se obliga a pagar mensualmente la Cuota de Mantenimiento en favor del ARRENDADOR por la cantidad de <strong>".$mantenimiento."</strong> mensuales (&ldquo;<u>Cuota de Mantenimiento</u>&rdquo;).</p>
    <p><strong>&nbsp;</strong></p>";
    $textoPagoMant=" y el pago de la Cuota de Mantenimiento ";
    $textoCuota=" y la Cuota de Mantenimiento";
    $textoPagoCuota=" y/o pago de la Cuota de Mantenimiento";
    $textoRespectivamente = " y/o Cuota de Mantenimiento, respectivamente";
    $textoEnLaCuota=" y/o en la cuota de mantenimiento ";
}
else{
    $textoMant="";
    $textoPagoMant="";
    $textoCuota="";
    $textoPagoCuota="";
    $textoRespectivamente="";
    $textoEnLaCuota="";
}

$mpdf = new \Mpdf\Mpdf();
$mpdf->setFooter('{PAGENO}');



if($tipoContrato=="NPF")
{
    $mpdf->WriteHTML('<p style="text-align: justify;"><strong>CONTRATO DE ARRENDAMIENTO DE CASA HABITACI&Oacute;N (EN LO SUCESIVO, EL &ldquo;<u>CONTRATO</u>&rdquo;) </strong><strong>QUE CELEBRAN POR UNA PARTE &ldquo;'.$nomProp.' '.$apeProp.'&rdquo;, POR SU PROPIO DERECHO (EN LO SUCESIVO, EL &ldquo;<u>ARR</u><u>ENDADOR</u>&rdquo;), Y POR LA OTRA PARTE &ldquo;'.$nomInq.' '.$apeInq.'&rdquo;, POR SU PROPIO DERECHO (EN LO SUCESIVO, EL &ldquo;<u>ARRENDATARIO</u>&rdquo;), CON LA COMPARECENCIA DE &ldquo;'.$aval.'&rdquo;, POR SU PROPIO DERECHO, A QUIEN EN LO SUCESIVO Y PARA EFECTOS DE ESTE CONTRATO SE LE DENOMINAR&Aacute; EL &ldquo;<u>FIADOR</u>&rdquo;, Y A QUIENES EN SU CONJUNTO SE LES DENOMINAR&Aacute; COMO LAS &ldquo;<u>PARTES</u>&rdquo;, DE CONFORMIDAD CON LAS SIGUIENTES DECLARACIONES Y CL&Aacute;USULAS. </strong></p>
    <p>&nbsp;</p>
    <h2>D E C L A R A CI O N E S</h2>
    <p>&nbsp;</p>
    <ol>
    <li><strong>Declara el ARRENDADOR, por su propio derecho y bajo protesta de decir verdad, que:</strong></li>
    </ol>
    <p style="padding-left: 30px; text-align: justify;"><strong>&nbsp;</strong>a) Es una persona f&iacute;sica, de nacionalidad mexicana, mayor de edad, en pleno ejercicio de sus derechos y que tiene la capacidad jur&iacute;dica, suficiente y bastante para obligarse en los t&eacute;rminos del presente Contrato.</p>
    <p style="padding-left: 30px; text-align: justify;"><strong>&nbsp;</strong>b) Cuenta con el Registro Federal de Contribuyentes n&uacute;mero '.$rfcProp.'.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;c) Para los efectos derivados de este Contrato se&ntilde;ala como su domicilio para recibir y o&iacute;r toda clase de notificaciones y documentos el ubicado en: <strong>'.$domicilioArrendador.'</strong>.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;d) Cuenta con el derecho y la capacidad jur&iacute;dica para otorgar el uso y goce temporal del INMUEBLE ubicado en:<strong> '.$direccion.'</strong> objeto del presente Contrato (en lo sucesivo, el &ldquo;<u>INMUEBLE</u>&rdquo;), el cual tiene una superficie de <strong>'.$superficie.'</strong> metros cuadrados y comprende: <strong>'.$comprende.'</strong>.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;e) Es el leg&iacute;timo propietario del INMUEBLE, lo cual consta en la escritura p&uacute;blica n&uacute;mero <strong>'.$numescritura.'</strong>, de fecha <strong>'.$fechaEscritura.'</strong>, otorgada ante la fe del licenciado <strong>'.$licEscritura.'</strong>, titular de la Notar&iacute;a P&uacute;blica No. <strong>'.$numNotaria.' </strong>de la Ciudad de M&eacute;xico.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;f) Se encuentra en plena posesi&oacute;n y dominio del INMUEBLE objeto del presente Contrato y no tiene impedimento legal ni contractual alguno para otorgarlo en arrendamiento al ARRENDATARIO.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;g) Manifiesta que el INMUEBLE se encuentra en condiciones de ser habitado'.$amueblado.'.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;h) El motivo determinante de su voluntad para celebrar el presente Contrato, es conceder el uso y goce temporal del INMUEBLE pasa uso de casa habitaci&oacute;n en favor del ARRENDATARIO en los t&eacute;rminos y condiciones establecidas en el presente Contrato.</p>
    <p>&nbsp;</p>
    <ol>
    <li><strong>Declara el ARRENDATARIO, por su propio derecho y bajo protesta de decir verdad, que:</strong></li>
    </ol>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;a) Es una persona f&iacute;sica, mayor de edad, en pleno ejercicio de sus derechos y que tiene la capacidad jur&iacute;dica, suficiente y bastante para obligarse en los t&eacute;rminos del presente Contrato.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;b) Cuenta con el Registro Federal de Contribuyentes n&uacute;mero '.$rfcInq.'.</p>
    <p style="padding-left: 30px; text-align: justify;"><strong>&nbsp;</strong>c) Para efectos derivados de este Contrato se&ntilde;ala como su domicilio para recibir y o&iacute;r toda clase de notificaciones y documentos el ubicado en: <strong>'.$domicilioArrendatario.'</strong>.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;d) Tiene inter&eacute;s jur&iacute;dico de recibir en arrendamiento el INMUEBLE, el cual sabe y le consta, que se encuentra en las condiciones necesarias de seguridad e higiene para ser habitado en modalidad de casa habitaci&oacute;n y que cuenta con mobiliario en perfecto estado de uso que se menciona en el inventario que se anexa al presente, por lo que no condicionar&aacute; el pago de rentas a ning&uacute;n tipo de mejora.</p>
    <p style="padding-left: 30px; text-align: justify;"><strong>&nbsp;</strong>e) Los recursos provenientes de su actividad y con los cuales dar&aacute; cumplimiento a lo establecido en este Contrato<strong>,</strong> han sido obtenidos y ser&aacute;n en todo momento obtenidos de fuentes l&iacute;citas, producto de actividades realizadas dentro del marco de la ley, manifestando que en ning&uacute;n caso dichos recursos provendr&aacute;n de actividades il&iacute;citas.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;f) Cuenta con la capacidad econ&oacute;mica y financiera necesaria para celebrar y cumplir con sus obligaciones bajo el presente Contrato.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;g) La informaci&oacute;n proporcionada en el presente Contrato es correcta, ver&iacute;dica y precisa, por lo que desde este momento manifiesta su conformidad en que si durante la vigencia de este Contrato se descubriera que su actividad o bien la informaci&oacute;n que proporcion&oacute; para la celebraci&oacute;n del mismo, es falta o inexacta, se entender&aacute; que actu&oacute; de manera dolosa y de mala fe.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;h) El motivo determinante de su voluntad para celebrar el presente Contrato es que el ARRENDADOR le conceda el uso y goce temporal del INMUEBLE, en los t&eacute;rminos y condiciones establecidas en este Contrato.</p>
    <p><strong>&nbsp;</strong></p>
    <ul>
    <li><strong>Declara el FIADOR, </strong><strong>por su propio derecho y bajo protesta de decir verdad, que:</strong></li>
    </ul>
    <p style="padding-left: 30px; text-align: justify;"><strong>&nbsp;</strong>a) Es una persona f&iacute;sica, de nacionalidad mexicana, con facultades y capacidad suficiente para obligarse en t&eacute;rminos del presente Contrato.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;b) Cuenta con solvencia suficiente y con capacidad econ&oacute;mica para fungir en el presente contrato como FIADOR del ARRENDATARIO, oblig&aacute;ndose en los t&eacute;rminos del mismo.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;c) Se encuentra debidamente inscrita en el Registro Federal de Contribuyentes bajo el n&uacute;mero '.$rfcaval.'.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;d) Para efectos del presente Contrato se&ntilde;ala como su domicilio ubicado en: '.$domicilioAval.'.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;e) Ser propietario del inmueble ubicado: '.$domicilioInmueble.', el cual se describe y consta en la escritura p&uacute;blica n&uacute;mero <strong>'.$numEscrituraArrendatario.'</strong>, de fecha <strong>'.$fechaEscrituraArrendatario.'</strong>, otorgada ante la fe del licenciado <strong>'.$licenciadoArrendatario.'</strong>, titular de la Notar&iacute;a P&uacute;blica No. <strong>'.$notariaArrendatario.' </strong>de la Ciudad de M&eacute;xico; el cual, junto con el resto de su patrimonio, se&ntilde;ala como garant&iacute;a del cabal cumplimiento de sus obligaciones contra&iacute;das en el presente Contrato.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;f) Los recursos con los cuales garantiza el presente Contrato han sido obtenidos de fuentes l&iacute;citas, producto de actividades realizadas dentro del marco de la ley, y no existe conexi&oacute;n alguna entre el origen, procedencia, objetivo o destino de esos recursos o los productos que tales recursos generen con actividades il&iacute;citas.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;g) La informaci&oacute;n proporcionada en el presente Contrato es correcta, ver&iacute;dica y precisa, por lo que desde este momento manifiesta su conformidad en que si durante la vigencia de este Contrato se descubriera que su actividad o bien la informaci&oacute;n que proporcion&oacute; para la celebraci&oacute;n del mismo, es falta o inexacta, se entender&aacute; que actu&oacute; de manera dolosa y de mala fe, por lo que este Contrato ser&aacute; nulo de pleno derecho.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;h) Es su voluntad constituirse como FIADOR del ARRENDATARIO, y por lo tanto responder por el puntual y cabal cumplimiento de las obligaciones que &eacute;ste &uacute;ltimo contrae en el presente instrumento.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <ol>
    <li><strong>Declaran las PARTES, a trav&eacute;s de sus representantes legales y bajo protesta de decir verdad, que:</strong></li>
    </ol>
    <p style="padding-left: 30px; text-align: justify;"><strong>&nbsp;</strong>a) Se reconocen mutua y rec&iacute;procamente la personalidad con la que acuden a la firma del presente Contrato.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;b) En el presente Contrato no existe dolo, error, mala fe o cualquier otro vicio de la voluntad, por lo que expresamente renuncian a invocarlos en cualquier tiempo.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;c) Contrato es el &uacute;nico documento que se vincula jur&iacute;dicamente entre el ARRENDADOR y el ARRENDATARIO y regula sus derechos respecto del INMUEBLE referido, por lo que, al no existir acuerdos accesorios que modifiquen o condicionen dicho Contrato, no tiene m&aacute;s derechos para con el ARRENDADOR que los contemplados en el presente Contrato. En tal virtud, en este acto, el ARRENDATARIO renuncia expresamente a reclamar judicialmente la existencia de acuerdos, convenios o pagos sobre circunstancias ajenas o especiales a las previstas en el presente documento.</p>
    <p style="padding-left: 30px; text-align: justify;">&nbsp;d) Han sido motivos determinantes de su voluntad lo expresado en las declaraciones que anteceden y que por lo tanto convienen en otorgar las siguientes:</p>
    <p style="text-align: justify;">&nbsp;</p>
    <h2>C L &Aacute; U S U L A S</h2>
    <p>&nbsp;</p>
    <p><strong>PRIMERA. OBJETO.</strong></p>
    <p style="text-align: justify;">El ARRENDADOR en este acto concede en arrendamiento al ARRENDATARIO el uso y goce temporal del INMUEBLE, y este &uacute;ltimo a su vez la recibe &uacute;nica y exclusivamente para casa habitaci&oacute;n (&ldquo;<u>Uso Autorizado</u>&rdquo;), en los t&eacute;rminos establecidos en el presente Contrato.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Las Partes acuerdan que el ARRENDATARIO se obliga a destinar el INMUEBLE &uacute;nica y exclusivamente al Uso Autorizado, por lo que no podr&aacute; destinarlo a un uso distinto del aqu&iacute; establecido. Las Partes convienen que, en caso de cualquier cambio en el giro o uso distinto al aqu&iacute; establecido, facultar&aacute; al ARRENDADOR a exigir la rescisi&oacute;n del presente Contrato y se sujetar&aacute; a lo establecido en el presente Contrato y en la legislaci&oacute;n aplicable.</p>
    <p>&nbsp;</p>
    <p><strong>SEGUNDA. RENTA.</strong>&nbsp;</p>
    <p style="text-align: justify;">El ARRENDATARIO pagar&aacute; al ARRENDADOR o a quien sus derechos represente, por concepto de renta por el uso y goce del INMUEBLE, la cantidad mensual de <strong>'.$renta.'</strong> (&ldquo;<u>Renta</u>&rdquo;).</p>
    <p style="text-align: justify;"><strong>&nbsp;</strong></p>
    <p style="text-align: justify;">'.$textoMant.'</p>
    <p style="text-align: justify;">El pago de la Renta'.$textoPagoMant.' se deber&aacute;n cubrir sin necesidad de requerimiento alguno, por mensualidades adelantadas, dentro de los primeros 10 (diez) d&iacute;as naturales de cada mes; si&eacute;ndole forzoso pagar todo el mes y debiendo cubrir de manera &iacute;ntegra la Renta'.$textoCuota.', a&uacute;n cuando s&oacute;lo usare el INMUEBLE por un periodo menor.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Ambas Partes acuerdan que a partir del primer a&ntilde;o de vigencia del presente Contrato, la Renta podr&aacute; ser actualizada por el ARRENDADOR. La Renta actualizada ser&aacute; exigible al ARRENDATARIO a partir de que el ARRENDADOR le notifique de dicha actualizaci&oacute;n por escrito con al menos 20 (veinte) d&iacute;as de anticipaci&oacute;n al mes en el que se pretenda comenzar a cobrar la renta actualizada y no podr&aacute; actualizarse de nuevo hasta que haya transcurrido un a&ntilde;o nuevamente.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Las obligaciones a cargo del ARRENDATARIO del pago de la Renta'.$textoCuota.' iniciar&aacute;n el d&iacute;a <strong>'.$diapago.'</strong>, siendo que para el inicio de dichas obligaciones no se requerir&aacute; de aviso o convenio alguno posterior entre las Partes, sino que iniciar&aacute;n de forma autom&aacute;tica.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Para el caso de que el ARRENDATARIO se atrase en el pago de la Renta'.$textoCuota.', se obliga a pagar a favor del ARRENDADOR intereses moratorios a raz&oacute;n del 6% (seis por ciento) anual, sobre saldos insolutos, por cada d&iacute;a natural de retraso y hasta la liquidaci&oacute;n total del adeudo en cuesti&oacute;n, m&aacute;s el correspondiente Impuesto al Valor Agregado; lo anterior, sin perjuicio del derecho del ARRENDADOR a exigir el pago de dichas cantidades adeudadas y/o el cumplimiento forzoso del presente Contrato.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p><strong>TERCERA. ENTREGA DEL INMUEBLE. </strong></p>
    <p style="text-align: justify;">El ARRENDADOR entregar&aacute; al ARRENDATARIO y &eacute;ste recibir&aacute; la posesi&oacute;n material del INMUEBLE el d&iacute;a de la fecha de firma del presente Contrato, y desde ese entonces el ARRENDATARIO ser&aacute; el &uacute;nico responsable de la existencia, uso y operaci&oacute;n del INMUEBLE.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">El ARRENDATARIO se encuentra obligado a pagar la Renta a partir de la firma del presente Contrato.&nbsp;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">A partir de la fecha de entrega indicada en la presente cl&aacute;usula, el ARRENDATARIO ser&aacute; el &uacute;nico responsable del uso del INMUEBLE, salvo por las obligaciones a cargo del ARRENDADOR estipuladas en este Contrato.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">El ARRENDATARIO acepta recibir el INMUEBLE en el estado en el que se encuentra, en condiciones de higiene y seguridad, suficientes y necesarias para ser habitable, pues cuenta con instalaciones adecuadas de luz, agua y drenaje, por lo cual, acepta recibir el INMUEBLE en buen estado y a su entera satisfacci&oacute;n de conformidad con lo dispuesto en los art&iacute;culos 2412, fracci&oacute;n I y 2443 del C&oacute;digo Civil Federal vigente y su correlativo aplicable del C&oacute;digo Local.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Una vez concluido el presente Contrato, el ARRENDATARIO entregar&aacute; la posesi&oacute;n material del INMUEBLE al ARRENDADOR en el mismo estado en que lo recibi&oacute; a la celebraci&oacute;n de este Contrato. En consecuencia, el ARRENDATARIO se compromete a devolver el INMUEBLE sin m&aacute;s deterioro que el causado por el uso normal y racional del mismo.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p><strong>CUARTA. LUGAR Y FORMA DE PAGO.</strong></p>
    <p style="text-align: justify;">Las Partes convienen que la Renta se pagar&aacute; por el ARRENDATARIO en efectivo en el domicilio del ARRENDADOR se&ntilde;alado en las declaraciones del presente Contrato o mediante transferencia interbancaria a la siguente cuenta bancaria, o en la cuenta bancaria que el ARRENDADOR le informe de tiempo en tiempo al ARRENDADOR:</p>
    <p><strong>&nbsp;</strong></p>
    <p>BENEFICIARIO <strong>_________________________________________________</strong></p>
    <p>BANCO <strong>_________________________________________________</strong></p>
    <p>CUENTA <strong>_________________________________________________</strong></p>
    <p>CLABE <strong>_________________________________________________</strong></p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">En todo caso, el ARRENDADOR emitir&aacute; los recibos por los pagos efectivamente realizados por el ARRENDATARIO.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Por ning&uacute;n concepto y bajo ninguna circunstancia podr&aacute; el ARRENDATARIO retener la Renta. El ARRENDATARIO conviene en que el pago de la Renta ser&aacute; independiente del cumplimiento de cualquier otra obligaci&oacute;n derivada de este Contrato, por lo que no puede ser retenida por ning&uacute;n motivo.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p><strong>QUINTA. VIGENCIA.</strong>&nbsp;</p>
    <p style="text-align: justify;">La vigencia del presente Contrato ser&aacute; de <strong>'.$meses.' </strong>meses forzosos para ambas partes, iniciando su vigencia el d&iacute;a <strong>'.$fechaIni.' </strong>y terminando el d&iacute;a <strong>'.$fechaFin.'</strong> debiendo dar aviso el ARRENDATARIO al ARRENDADOR por escrito con 30 (treinta) d&iacute;as de anticipaci&oacute;n a su vencimiento, si es su deseo continuar con el arrendamiento, reserv&aacute;ndose el ARRENDADOR el derecho de aceptar dicha renovaci&oacute;n, lo cual en todo caso lo har&aacute; mediante la celebraci&oacute;n de un nuevo contrato o mediante la modificaci&oacute;n del presente Contrato y siempre y cuando el ARRENDATARIO haya cumplido en tiempo y forma con el pago total de la Renta pactada, y sean renovadas y actualizadas las garant&iacute;as se&ntilde;aladas en el presente Contrato.</p>
    <p style="text-align: justify;"><strong>&nbsp;</strong></p>
    <p style="text-align: justify;">En caso de que el ARRENDATARIO sea el que desee dar por terminado el presente Contrato, adem&aacute;s del aviso por escrito antes mencionado, autoriza al ARRENDADOR a poner c&eacute;dulas visibles en el exterior del INMUEBLE, ofreci&eacute;ndolo en arrendamiento, as&iacute; como a mostrar el interior del INMUEBLE a las personas que se encuentren interesadas en &eacute;l.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Ambas partes convienen que para el caso de que proceda la renovaci&oacute;n del presente Contrato, la contraprestaci&oacute;n total se incrementar&aacute; con base en la variaci&oacute;n que sufra el &Iacute;ndice Nacional de Precios al Consumidor (en lo sucesivo &ldquo;<u>INPC</u>&rdquo;), que publique la Secretar&iacute;a de Hacienda a trav&eacute;s del Servicio de Administraci&oacute;n Tributaria (o en su caso la entidad correspondiente), en el Diario Oficial de la Federaci&oacute;n, para los doce (12) meses inmediatos anteriores a la fecha en que proceda llevar a cabo el incremento que corresponda, salvo pacto en contrario que conste por escrito.</p>
    <p>&nbsp;</p>
    <p><strong>SEXTA. PENA CONVENCIONAL.</strong>&nbsp;</p>
    <p style="text-align: justify;">Las Partes convienen que para el caso de incumplimiento en el pago de la Renta'.$textoPagoCuota.' en el tiempo y forma estipulados en el presente Contrato, el ARRENDATARIO se obliga a pagar al ARRENDADOR por concepto de pena convencional la cantidad equivalente al <strong>_____ </strong>% sobre el monto de la Renta'.$textoRespectivamente.', aceptando en este acto el ARRENDATARIO que el retraso en el cumplimiento del pago de la renta'.$textoEnLaCuota.' es de su exclusiva responsabilidad, por lo que acepta que si el retraso en el pago excede la fecha pactada, se contin&uacute;en generando dichos intereses hasta su total liquidaci&oacute;n al ARRENDADOR.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Asimismo, las Partes convienen que para cualquier otro incumplimiento a cualquier otra obligaci&oacute;n a cargo del ARRENDATARIO, &eacute;ste se obliga a pagar al ARRENDADOR por concepto de pena convencional, el equivalente al <strong>_____ </strong>% de la Renta por cada uno de los incumplimientos derivados del presente contrato y a cargo del ARRENDATARIO, siempre que no consistan en el incumplimiento a que refiere el primer p&aacute;rrafo de esta cl&aacute;usula.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Cuando el ARRENDATARIO, realice el pago de la Renta por medio de cheque, y &eacute;ste no fuere pagado por la instituci&oacute;n bancaria emisora por cualquier causa, se considerar&aacute; que el pago por concepto de renta correspondiente, no fue recibido por el ARRENDADOR en tiempo y forma, quedando obligado el ARRENDATARIO a cubrir los gastos que dicho il&iacute;cito genere, adem&aacute;s pagar&aacute; el 20% (veinte por ciento) del valor del cheque, as&iacute; como las comisiones vigentes que la instituci&oacute;n bancaria de que se trate haya establecido. Se reserva el ARRENDADOR a recibir salvo buen cobro, el pago de la Renta por medio de cheque.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Si el ARRENDATARIO otorga al ARRENDADOR el importe correspondiente a la Renta en fecha y forma distinta de la estipulada en el presente instrumento, o recibe abonos a cuenta de la misma, no se tendr&aacute; por renovado el contrato en t&eacute;rminos, fechas o forma de pago, por lo que el ARRENDATARIO acepta que dicho pago se aplique primeramente al pago de la pena convencional correspondiente, y el saldo a la Renta mensual de que se trate.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p><strong>S&Eacute;PTIMA. DEP&Oacute;SITO EN GARANT&Iacute;A.</strong>&nbsp;</p>
    <p style="text-align: justify;">El ARRENDATARIO entrega al ARRENDADOR para garantizar el cumplimiento oportuno de las obligaciones establecidas en este Contrato, un dep&oacute;sito en garant&iacute;a, por dicho concepto por un monto equivalente a 2 (dos) meses de Renta, m&aacute;s el Impuesto al Valor Agregado correspondiente (&ldquo;<u>Dep&oacute;sito en Garant&iacute;a</u>&rdquo;).</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Si en alg&uacute;n momento de la vigencia de este Contrato el Dep&oacute;sito en Garant&iacute;a es menor a un monto equivalente a 2 (dos) meses de Renta, el ARRENDATARIO se obliga a entregar al ARRENDADOR cualquier diferencia que as&iacute; resulte para completar el Dep&oacute;sito en Garant&iacute;a dentro de los 10 (diez) d&iacute;as naturales siguientes a la solicitud del ARRENDADOR.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Las Partes acuerdan que el ARRENDADOR a su libre elecci&oacute;n y sin responsabilidad alguna, estar&aacute; facultada para utilizar el monto del Dep&oacute;sito en Garant&iacute;a para pagar a cualquier tercero y a&uacute;n en su favor, cualquier cantidad debida y no pagada por el ARRENDATARIO, incluyendo de forma enunciativa m&aacute;s no limitativa, Renta, tel&eacute;fono, gas, energ&iacute;a el&eacute;ctrica, as&iacute; como cualquier otro servicio y obligaci&oacute;n a cargo de &eacute;ste &uacute;ltimo, para lo cual el ARRENDADOR deber&aacute; notificar al ARRENDATARIO la existencia de dicho adeudo, otorg&aacute;ndole un plazo m&aacute;ximo de 10 (diez) d&iacute;as contados a partir de la fecha de notificaci&oacute;n, para que el ARRENDATARIO realice el pago.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">EL ARRENDATARIO autoriza expresamente al ARRENDADOR a conservar el Dep&oacute;sito en Garant&iacute;a (liber&aacute;ndolo de la obligaci&oacute;n de depositarlo judicialmente) durante un plazo de 60 (sesenta) d&iacute;as posteriores a que haya desocupado y entregado la localidad arrendada a satisfacci&oacute;n del ARRENDADOR. Transcurrido este plazo, el ARRENDADOR devolver&aacute; al ARRENDATARIO el mencionado dep&oacute;sito sin inter&eacute;s ni rendimiento financiero alguno, siempre y cuando &eacute;ste no se hubiere ocupado o no existiere ning&uacute;n saldo pendiente a cargo del ARRENDATARIO por cualquier concepto, pues en dicho caso se aplicar&aacute; el dep&oacute;sito al pago de los saldos pendientes y para el caso que fueren insuficientes, el ARRENDADOR tendr&aacute; derecho expedito para reclamar su pago al FIADOR. A su vez, el ARRENDADOR deber&aacute; devolver el Dep&oacute;sito en Garant&iacute;a siempre y cuando, (i) el INMUEBLE sea entregado en buenas condiciones y solo con el desgaste del uso normal; (ii) no existan pagos pendientes respecto de la Renta y/o cualquier otro concepto u otros servicios; y (iii) no existan da&ntilde;os a las &aacute;reas comunes, ocasionados por el ARRENDATARIO sus visitantes, o cualquier tercero que se relacione con este &uacute;ltimo.</p>
    <p>&nbsp;</p>
    <p><strong>OCTAVA. SERVICIOS.</strong></p>
    <p style="text-align: justify;">A partir de la entrega del INMUEBLE, el ARRENDATARIO se obliga a pagar directa y oportunamente el importe de los servicios que vaya a utilizar por uso del INMUEBLE, tales como: energ&iacute;a el&eacute;ctrica, servicio de agua potable, servicios de telefon&iacute;a, televisi&oacute;n por cable, vigilancia privada, limpieza, gas y/o cualquier otro, y posteriormente har&aacute; entrega al ARRENDADOR de los recibos originales liquidados por tales conceptos, cada 2 meses despu&eacute;s de haber sido pagados, en el entendido de que los servicios se generan de manera bimestral.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">El impuesto predial y cualquier otro impuesto que se cause ser&aacute; cubierto por el ARRENDADOR.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Los servicios con los que cuenta el INMUEBLE son: <strong>___________________________________________________________</strong>.</p>
    <p style="text-align: justify;"><strong>&nbsp;</strong></p>
    <p style="text-align: justify;">Los servicios incluidos en el mantenimiento son: <strong>___________________________________________________________</strong>.</p>
    <p style="text-align: justify;"><strong>&nbsp;</strong></p>
    <p style="text-align: justify;">Todos los asuntos relacionados con los servicios que cuente el INMUEBLE, deber&aacute;n ser comunicados por escrito al ARRENDADOR, o a quien sus derechos represente, dentro del t&eacute;rmino de 10 (diez) d&iacute;as a partir de que el ARRENDATARIO tenga conocimiento de esa situaci&oacute;n, de lo contrario, los da&ntilde;os y perjuicios causados por no haber dado aviso oportuno al ARRENDADOR, correr&aacute;n a cargo del ARRENDATARIO.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Todo servicio adicional que se contrate en el INMUEBLE debe notificarse al ARRENDADOR, as&iacute; como entregar una copia del contrato del servicio y, en caso de la terminaci&oacute;n del presente Contrato, se deber&aacute; entregar el comprobante de cancelaci&oacute;n de cada servicio contratado por el ARRENDATARIO.</p>
    <p><u>&nbsp;</u></p>
    <p><strong>NOVENA. MEJORAS AL INMUEBLE ARRENDADO. </strong>&nbsp;</p>
    <p style="text-align: justify;">El ARRENDATARIO se encuentra obligado a devolver el INMUEBLE en las condiciones en las que lo recibe salvo el desgaste normal y natural por el uso que se les d&eacute;; por lo cual, no podr&aacute; realizar sin el consentimiento y autorizaci&oacute;n por escrito del ARRENDADOR, ning&uacute;n tipo de obra, particularmente, aquellas que modifiquen la estructura del lugar, y tampoco podr&aacute; perforar las paredes, techos y/o en el suelo de este salvo que el ARRENDADOR lo autorice.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Sin perjuicio de poder exigir una indemnizaci&oacute;n por da&ntilde;os y perjuicios, el ARRENDADOR podr&aacute; exigir adem&aacute;s, que el ARRENDATARIO responga las cosas al estado previo a las modificaciones efectuadas sin autorizaci&oacute;n, sin que el ARRENDATARIO pueda reclamar pago alguno.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">A&uacute;n existiendo autorizaci&oacute;n por parte del ARRENDADOR, el ARRENDATARIO ser&aacute; exclusivamente responsable de los da&ntilde;os que puedan llegar ocasionarse con las obras que se realicen. Por lo tanto, todas las mejoras, adecuaciones, obras que realice el ARRENDATARIO por s&iacute; mismo, a&uacute;n contando con autorizaci&oacute;n del ARRENDADOR, correr&aacute;n a cargo y costo del ARRENDATARIO.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">El proyecto de las obras, mejoras y/o adecuaciones deber&aacute; ser sometido, previo a su ejecuci&oacute;n, a la aprobaci&oacute;n del ARRENDADOR.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Las Partes acuerdan que todas las mejoras que se hagan en el INMUEBLE quedar&aacute;n a beneficio del mismo, sin que por esto pueda el ARRENDATARIO exigir precio alguno o compensaci&oacute;n contra el pago de la Renta, en el entendido adem&aacute;s de que el ARRENDATARIO podr&aacute; remover del INMUEBLE todas aquellas adecuaciones, obras y/o mejoras muebles o m&oacute;viles, cuya remoci&oacute;n, separaci&oacute;n y/o desmantelamiento no causen da&ntilde;o alguno al INMUEBLE. Si durante la realizaci&oacute;n de estas adecuaciones, mejoras y/o obras o remoci&oacute;n de las mismas se ocasionan da&ntilde;os, el ARRENDATARIO indemnizar&aacute; al ARRENDADOR o a quien &eacute;ste designe.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">En todo caso, el ARRENDATARIO quedar&aacute; obligado a mantener en paz y a salvo al ARRENDADOR de cualquier reclamaci&oacute;n, procedimiento administrativo, demanda y/o juicio de cualquier naturaleza, incluyendo laboral, fiscal o ambiental y a indemnizar al ARRENDADOR por cualquier da&ntilde;o o p&eacute;rdida que sufra con motivo del incumplimiento del ARRENDATARIO y/o de sus contratistas, subcontratistas, arquitecto y/o director responsable de la obra o cualquier proveedor, a cualquiera de las obligaciones consignadas en esta cl&aacute;usula.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Por otro lado, el ARRENDADOR se encuentra obligado a realizar todas las reparaciones que sean necesarias para conservar el inmueble en buen estado y servir as&iacute; adecuadamente al Uso Autorizado, salvo cuando el deterioro sea imputable al ARRENDATARIO, en cuyo caso &eacute;ste deber&aacute; realizar las reparaciones correspondientes.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">El ARRENDATARIO ser&aacute; responsable de conservar y mantener en buen estado el INMUEBLE, procur&aacute;ndole mantenimiento preventivo y correctivo de manera ordinaria y peri&oacute;dica.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">El ARRENDADOR tendr&aacute; la obligaci&oacute;n de llevar a cabo las reparaciones estructurales del INMUEBLE.</p>
    <p>&nbsp;</p>
    <p><strong>D&Eacute;CIMA. HIGIENE.</strong></p>
    <p style="text-align: justify;">EL ARRENDATARIO deber&aacute; mantener en condiciones higi&eacute;nicas las azoteas, conductos de ca&ntilde;er&iacute;as y drenajes del INMUEBLE as&iacute; como las &aacute;reas comunes que le correspondan, para evitar humedad y goteras; de no hacerlo as&iacute;, cualquier da&ntilde;o ser&aacute; a su costa, ya que el mantenimiento del INMUEBLE materia del presente arrendamiento es su responsabilidad.</p>
    <p>&nbsp;</p>
    <p><strong>D&Eacute;CIMA PRIMERA. DA&Ntilde;OS O FALTANTES.</strong>&nbsp;</p>
    <p style="text-align: justify;">El ARRENDADOR no ser&aacute; responsable de los da&ntilde;os o faltantes sufridos en veh&iacute;culos, bienes muebles o patrimonio del ARRENDATARIO, durante la ocupaci&oacute;n o desocupaci&oacute;n del INMUEBLE, ni durante el tiempo que dure su estancia en el mismo, ya que el ARRENDATARIO queda a cargo de la seguridad del INMUEBLE arrendado a partir de la firma del presente Contrato, por lo que desde este momento el ARRENDADOR le autoriza modificar la combinaci&oacute;n de la(s) cerradura(s) que dan acceso a la localidad arrendada.</p>
    <p>&nbsp;</p>
    <p><strong>D&Eacute;CIMA SEGUNDA. CUIDADO DEL INMUEBLE.</strong>&nbsp;</p>
    <p style="text-align: justify;">El ARRENDATARIO se obliga a no perforar azulejos, pisos, puertas, o colocar muebles que da&ntilde;en los acabados del INMUEBLE, sin previa autorizaci&oacute;n por escrito del ARRENDADOR y a darle el mantenimiento adecuado y oportuno a los muebles que forman parte de las instalaciones del INMUEBLE. Asimismo, en caso de rotura de vidrios, deber&aacute; el ARRENDATARIO reponerlos de inmediato.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">En general, el ARRENDATARIO se obliga a mantener el INMUEBLE arrendado, en las mismas condiciones en las que le fue entregado. EL ARRENDADOR no ser&aacute; responsable de los da&ntilde;os ocasionados a los vecinos y/o a sus bienes, por la falta del mantenimiento antes mencionado.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p><strong>D&Eacute;CIMA TERCERA. OBLIGACIONES ADICIONALES</strong>.</p>
    <p>En adici&oacute;n a las dem&aacute;s obligaciones establecidas en t&eacute;rminos del presente Contrato, el ARRENDATARIO se obliga a:</p>
    <p>&nbsp;</p>
    <ol>
    <li style="text-align: justify;">Facilitar una convivencia pac&iacute;fica con los vecinos, y a dar un uso correcto y adecuado al INMUEBLE.</li>
    <li style="text-align: justify;">Mantener el INMUEBLE en condiciones de aseo adecuadas para su uso.</li>
    <li style="text-align: justify;">Tener especial cuidado de las llaves, pases de acceso y/o controles o dispositivos de acceso al lugar, y en caso de p&eacute;rdida de alguno de estos, deber&aacute; comunicarlo inmediatamente al ARRENDADOR, adem&aacute;s de pagar todos los gastos de que deriven de tal p&eacute;rdida.</li>
    <li style="text-align: justify;">Llevar a cabo todos los actos necesarios para mantener y renovar todos los derechos, permisos, licencias y contratos necesarios para desarrollar las adecuaciones, mejoras y/o obras en el INMUEBLE durante la vigencia del presente Contrato.</li>
    <li style="text-align: justify;">Notificar al ARRENDADOR de manera inmediata sobre cualquier notificaci&oacute;n o emplazamiento respecto de cualquier acci&oacute;n o procedimiento judicial y extrajudicial que afecte o pudiera llegar a afectar el uso del INMUEBLE.</li>
    <li style="text-align: justify;">Notificar al ARRENDADOR en un plazo m&aacute;ximo de 3 (tres) d&iacute;as naturales posteriores sobre cualquier siniestro, aver&iacute;a o desperfecto que se produzca en el INMUEBLE, a&uacute;n cuando no sea aparente.</li>
    <li style="text-align: justify;">No permitir y evitar que cualquier persona introduzca o mantenga sustancias ilegales o materiales peligrosos (como dicho t&eacute;rmino se define en la legislaci&oacute;n mexicana y en las normas oficiales mexicanas aplicables) dentro de la superficie arrendada, as&iacute; como tampoco transportar, almacenar, usar, producir, manufacturar, disponer, o liberar cualquier material peligroso en o alrededor de dichas &aacute;reas.</li>
    <li style="text-align: justify;">En el supuesto que el ARRENDATARIO contratare l&iacute;neas telef&oacute;nicas para el uso del INMUEBLE, los contratos correspondientes deber&aacute;n ser celebrados directamente a nombre y por cuenta del ARRENDATARIO con la compa&ntilde;&iacute;a respectiva.</li>
    <li style="text-align: justify;">Abstenerse de modificar en forma alguna la estructura e instalaciones del INMUEBLE, las fachadas, pasillos y dem&aacute;s &aacute;reas comunes.</li>
    </ol>
    <p>&nbsp;</p>
    <p>En adici&oacute;n a las dem&aacute;s obligaciones establecidas en t&eacute;rminos del presente Contrato, el ARRENDADOR se obliga a:</p>
    <p>&nbsp;</p>
    <ol>
    <li style="text-align: justify;">Entregar el INMUEBLE al ARRENDADOR conforme a lo establecido en el presente Contrato.</li>
    <li style="text-align: justify;">Conservar fachadas, instalaciones comunes y estructura del INMUEBLE buen estado durante la vigencia de este Contrato.</li>
    <li style="text-align: justify;">No estorbar ni menoscabar de manera alguna el uso de las &aacute;reas arrendadas a no ser por causa de reparaciones urgentes e indispensables.</li>
    <li style="text-align: justify;">Garantizar el uso o goce pac&iacute;fico de las &aacute;reas arrendadas durante la vigencia de este Contrato, mientras dicho uso o goce no sea interrumpido por actos de terceros y/o casos de fuerza mayor.</li>
    <li style="text-align: justify;">Responder de los da&ntilde;os y perjuicios que sufra el ARRENDATARIO por los defectos o vicios ocultos de la cosa, anteriores y durante el arrendamiento. El ARRENDADOR responde de los vicios o defectos del INMUEBLE que impidan el uso de ella, aunque &eacute;l no los hubiese conocido o hubiesen sobrevenido en el curso del arrendamiento, sin culpa del ARRENDATARIO, el cual puede pedir la disminuci&oacute;n de la renta o la rescisi&oacute;n del Contrato.</li>
    <li style="text-align: justify;">Corresponde al ARRENDADOR pagar las mejoras hechas por el ARRENDATARIO si en el Contrato, o posteriormente, por escrito, lo autoriz&oacute; para hacerlas y se oblig&oacute; a pagarlas o cuando se trate de mejoras &uacute;tiles o urgentes por causa de fuerza mayor.</li>
    </ol>
    <p>&nbsp;</p>
    <p><strong>D&Eacute;CIMA CUARTA. DESOCUPACI&Oacute;N.</strong>&nbsp;</p>
    <p style="text-align: justify;">Las Partes acuerdan que si al t&eacute;rmino de la vigencia del presente Contrato no hubiere renovaci&oacute;n del mismo, el ARRENDATARIO estar&aacute; obligado a desocupar el INMUEBLE arrendado a m&aacute;s tardar en la fecha de su vencimiento y si por cualquier motivo no lo hiciere, deber&aacute; pagar el doble de la Renta pactada por cada uno de los doce meses siguientes que siga ocup&aacute;ndolo, y el triple de dicha Renta durante cada mes que le siga, hasta la total desocupaci&oacute;n y entrega legal del INMUEBLE materia del presente Contrato, sin que esto implique renovaci&oacute;n o pr&oacute;rroga del mismo y por lo tanto sin perjuicio de la acci&oacute;n jur&iacute;dica que el ARRENDADOR ejerza para exigir dicha desocupaci&oacute;n, renunciando expresamente el ARRENDATARIO al aviso que prev&eacute; el C&oacute;digo Civil vigente para el Distrito Federal. Adicional, dar&aacute; motivo al ARRENDATARIO al pago de da&ntilde;os y perjuicios generados al ARRENDADOR.</p>
    <p style="text-align: justify;"><strong>&nbsp;</strong></p>
    <p style="text-align: justify;">Lo anterior tambi&eacute;n aplica en caso de terminaci&oacute;n del presente Contrato por cualquiera de las causas previstas en este Contrato.&nbsp;</p>
    <p style="text-align: justify;"><strong>&nbsp;</strong></p>
    <p style="text-align: justify;">Aunado a lo anterior, en caso de que el ARRENDATARIO demande judicialmente la desocupaci&oacute;n y entrega del INMUEBLE al ARRENDATARIO, y este resulta condenada, pagar&aacute; los honorarios y gastos que origine el juicio correspondiente, consituy&eacute;ndose deudor solidario de esta obligaci&oacute;n y renunciando ambos a los beneficios de orden y exclusi&oacute;n. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p><strong>D&Eacute;CIMA QUINTA. RESCISI&Oacute;N.</strong></p>
    <p style="text-align: justify;">En adici&oacute;n a las causas de rescisi&oacute;n establecidas en el C&oacute;digo Civil para el Distrito Federal, el ARRENDADOR se encontrar&aacute; facultado para rescindir este Contrato, de forma autom&aacute;tica y sin necesidad de resoluci&oacute;n judicial al respecto, mediante aviso dado por escrito al ARRENDATARIO, operando dicha rescisi&oacute;n de pleno derecho, en el supuesto de que el ARRENDATARIO incurra en cualquiera de los siguientes supuestos:</p>
    <p>&nbsp;</p>
    <ol>
    <li style="text-align: justify;">Si la informaci&oacute;n proporcionada por el ARRENDATARIO para la celebraci&oacute;n de este Contrato no es correcta, ver&iacute;dica y precisa.</li>
    <li style="text-align: justify;">Si el ARRENDATARIO no conserva el INMUEBLE en buenas condiciones de mantenimiento y conservaci&oacute;n con recursos propios.</li>
    <li style="text-align: justify;">Si el ARRENDATARIO variare la forma del INMUEBLE o variare el Uso Autorizado para el que fue arrendado conforme a lo establecido en el presente Contrato, sin autorizaci&oacute;n previa y por escrito del ARRENDADOR.</li>
    <li style="text-align: justify;">Si el INMUEBLE es objeto de perturbaci&oacute;n o cualquier otro acto de terceros que afecte el uso o goce del mismo, la posesi&oacute;n del mismo o bien la propiedad, por error, omisi&oacute;n, negligencia o culpa del ARRENDATARIO.</li>
    <li style="text-align: justify;">En caso de que el ARRENDATARIO dejare de cumplir con el pago de la Renta, no se haya cubierto de manera &iacute;ntegra, o se haya realizado de manera extempor&aacute;nea, durante la vigencia del Contrato.</li>
    <li style="text-align: justify;">Si el ARRENDATARIO subarrienda, cede o negocia en cualquier forma con terceros los derechos que ampara este Contrato, sin la autorizaci&oacute;n previa y por escrito del ARRENDADOR.</li>
    <li style="text-align: justify;">Si el ARRENDATARIO dejare de pagar cualquier cantidad que se adeude por concepto de uso y posesi&oacute;n del INMUEBLE objeto de este Contrato.</li>
    <li style="text-align: justify;">Si el ARRENDATARIO opera o utiliza el INMUEBLE para cualquier uso distinto al Uso Autorizado.</li>
    <li style="text-align: justify;">Si el ARRENDATARIO inicia los trabajos de adecuaciones o realiza obras, alteraciones o modificaciones al INMUEBLE, sin la aprobaci&oacute;n previa y por escrito del ARRENDADOR.</li>
    <li style="text-align: justify;">Si el ARRENDATARIO no responde por incendio en t&eacute;rminos de lo establecido en el C&oacute;digo Civil.</li>
    <li style="text-align: justify;">Si el ARRENDATARIO abandona el INMUEBLE, sin causa justificada, por un periodo que exceda de 60 (sesenta) d&iacute;as naturales.</li>
    <li style="text-align: justify;">Si el ARRENDATARIO incumple con cualquier otra obligaci&oacute;n asumida a su cargo en el presente Contrato.</li>
    </ol>
    <p>&nbsp;</p>
    <p style="text-align: justify;">En caso de que el ARRENDATARIO incurra en cualquiera de las causas de rescisi&oacute;n antes se&ntilde;aladas, el ARRENDADOR le notificar&aacute; por escrito dicho incumplimiento, siendo que el ARRENDATARIO gozar&aacute; de un plazo de 15 (quince) d&iacute;as naturales para subsanar el mismo, con excepci&oacute;n del incumplimiento en el pago de la Renta. En caso de que el incumplimiento de que se trate no sea subsanado dentro del citado plazo de 15 (quince) d&iacute;as naturales, entonces el presente Contrato podr&aacute; ser rescindido por el ARRENDADOR mediante aviso por escrito al ARRENDATARIO, sin necesidad de declaraci&oacute;n judicial al respecto (pacto comisorio expreso).</p>
    <p>&nbsp;</p>
    <p><strong>D&Eacute;CIMA SEXTA. FIADOR</strong><strong>.</strong>&nbsp;</p>
    <p style="text-align: justify;">En garant&iacute;a al cumplimiento de las obligaciones contra&iacute;das en el presente Contrato por parte del ARRENDATARIO, el FIADOR lo firma solidariamente, constituy&eacute;ndose as&iacute; en pagador de todas y cada una de dichas obligaciones, renunciando expresamente a los beneficios de orden y excusi&oacute;n en el presente Contrato; por tanto, el ARRENDADOR est&aacute; en aptitud de demandar el cumplimiento de las obligaciones contra&iacute;das contra el ARRENDATARIO, contra el FIADOR o contra ambos, en una o diversas acciones.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">El FIADOR conviene en que su responsabilidad legal no cesa sino hasta el momento en que el ARRENDADOR se d&eacute; por recibido del INMUEBLE, as&iacute; como&nbsp; del pago total de lo adeudado a su entera satisfacci&oacute;n, a&uacute;n y cuando la vigencia del presente contrato haya concluido.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">El ARRENDADOR podr&aacute; rehusarse a aceptar aquella persona que en su concepto no re&uacute;na los requisitos necesarios para garantizar como FIADOR el debido cumplimiento del presente Contrato.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">El ARRENDATARIO autoriza al FIADOR para que entregue el INMUEBLE cuando &eacute;l por ausencia o negligencia no lo haga.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Si durante la vigencia del presente Contrato el FIADOR fallece, tramite la propiedad o le es embargado el inmueble que ha se&ntilde;alado como base de su garant&iacute;a, el ARRENDATARIO deber&aacute; avisar de inmediato al ARRENDADOR y se&ntilde;alar nuevo FIADOR que tenga capacidad para obligarse y bienes suficientes para garantizar el cumplimiento de este Contrato, ya que en caso contrato el ARRENDADOR podr&aacute; rescindir este Contrato sin necesidad de intervenci&oacute;n judicial.&nbsp;</p>
    <p>&nbsp;</p>
    <p><strong>D&Eacute;CIMA S&Eacute;PTIMA. SINIESTROS Y CLAUSURAS.</strong></p>
    <p style="text-align: justify;">Los da&ntilde;os ocasionados al INMUEBLE, as&iacute; como a los colindantes, por siniestros originados por culpa o negligencia del ARRENDATARIO, de su FIADOR y/o de toda persona que viva o visite por cualquier motivo el INMUEBLE, ser&aacute;n de la exclusiva responsabilidad del ARRENDATARIO, por lo que en caso de detectar alg&uacute;n equipo o instalaci&oacute;n en mal estado durante la ocupaci&oacute;n del mismo, se deber&aacute; dar aviso por escrito al ARRENDADOR, con acuse de recibo, para proceder a la reparaci&oacute;n, por cuenta del ARRENDADOR, siempre y cuando no sea imputable la falla al ARRENDATARIO.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Cuando el INMUEBLE materia del arrendamiento sea clausurado o suspendido en su uso por disposici&oacute;n de autoridad competente y/o por causas imputables al ARRENDATARIO, &eacute;ste se obliga a continuar pagando la Renta pactada en el plazo convenido. El incumplimiento de esta obligaci&oacute;n originar&aacute; el pago de una pena convencional a cargo del ARRENDATARIO en favor del ARRENDADOR seg&uacute;n lo establecido en el presente Contrato.</p>
    <p>&nbsp;</p>
    <p><strong>D&Eacute;CIMA OCTAVA. CESI&Oacute;N DE DERECHOS.</strong>&nbsp;</p>
    <p style="text-align: justify;">Ninguna de las Partes podr&aacute; subarrendar, traspasar o ceder los derechos y obligaciones derivados del presente Contrato a un tercero. &nbsp;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Se conviene adem&aacute;s que no se conceder&aacute; autorizaci&oacute;n al ARRENDATARIO para subarrendar en forma total o parcial a terceros el INMUEBLE, y en caso contrario, ser&aacute; causa inmediata del presente Contrato.</p>
    <p>&nbsp;</p>
    <p><strong>D&Eacute;XIMA NOVENA. CONFIDENCIALIDAD. </strong></p>
    <p style="text-align: justify;">Durante la vigencia del presente Contrato, cualquiera de las Partes podr&aacute; obtener de la otra cierta informaci&oacute;n considerada como confidencial. Las Partes convienen en no divulgar dicha informaci&oacute;n confidencial a ninguna tercera parte, siendo que la parte que reciba la informaci&oacute;n responder&aacute; y ser&aacute; responsable de sus empleados, agentes, y distribuidores que divulguen informaci&oacute;n confidencial derivada de la relaci&oacute;n que se genera por la celebraci&oacute;n de este Contrato. La parte que divulgue indebidamente la informaci&oacute;n indemnizar&aacute; a la otra parte y la mantendr&aacute; a salvo por cualquiera de los da&ntilde;os directamente ocasionados por actos u omisiones realizados. Esta disposici&oacute;n se aplicar&aacute; y obligar&aacute; a las Partes a mantener una relaci&oacute;n confidencial.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Las Partes aceptan tomar por su propia cuenta todas las acciones razonables incluyendo, sin limitaci&oacute;n, procedimientos legales, para imponer el cumplimiento a PARTES a quienes se les divulgue tal informaci&oacute;n mediante contratos escritos de acuerdo a la presente cl&aacute;usula.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Cada una de las PARTES preservar&aacute; la confidencialidad de toda la informaci&oacute;n y los documentos recibidos de la otra parte en relaci&oacute;n con las operaciones contempladas en el presente y no los divulgar&aacute; a ning&uacute;n tercero sin consentimiento previo y por escrito de su contraparte.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Ambas Partes convienen que el presente Contrato es de car&aacute;cter privado y, por lo tanto, se abstendr&aacute;n de comunicar a un tercero su contenido o hacerlo p&uacute;blico, as&iacute; como tampoco podr&aacute;n divulgar, compartir o hacer un mal uso de los datos aportados por las Partes para celebrar el Contrato, no obstante, prevalecer&aacute;n todos los derechos y obligaciones de las Partes, y por tanto podr&aacute;n ejercitarse todas las acciones legales que se deriven del mismo conforme a la legislaci&oacute;n aplicable.</p>
    <p>&nbsp;</p>
    <p><strong>VIG&Eacute;SIMA. EXTINCI&Oacute;N DE DOMINIO. </strong></p>
    <p style="text-align: justify;">En el evento de que el Gobierno Federal y/o de la Ciudad de M&eacute;xico, en ejercicio de la acci&oacute;n de extinci&oacute;n de dominio, afecte el INMUEBLE por causas imputables al ARRENDATARIO, el ARRENDATARIO deber&aacute; cubrirle al ARRENDADOR el valor del mismo, pues expresamente se conviene en este Contrato que el INMUEBLE ser&aacute; destinado al Uso Autorizado se&ntilde;alado en este Contrato. Lo anterior se conviene de conformidad con lo dispuesto en la Ley Nacional de Extinci&oacute;n de Dominio.</p>
    <p>&nbsp;</p>
    <p><strong>VIG&Eacute;SIMA PRIMERA. DERECHO DEL PREFERENCIA. </strong></p>
    <p style="text-align: justify;">En caso de que el ARRENDADOR decida vender el INMUEBLE objeto del presente Contrato, el ARRENDADOR se obliga con el ARRENDATARIO a garantizar el derecho de preferencia para la compra del bien inmueble seg&uacute;n lo dispuesto en el art&iacute;culo 2448 J del C&oacute;digo Civil para el Distrito Federal.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">En caso de que el ARRENDATARIO no ejerza su derecho de preferencia sobre la compra del INMUEBLE, el ARRENDADOR se obliga a garantizar el cumplimiento cabal de los t&eacute;rminos y condiciones establecidos en el presente instrumento por parte del comprador correspondiente por el plazo de vigencia que se establece en este Contrato.</p>
    <p><strong>&nbsp;</strong></p>
    <p><strong>VIG&Eacute;SIMA SEGUNDA. NOTIFICACIONES. </strong></p>
    <p style="text-align: justify;">Para todos los avisos y notificaciones relacionados con el presente Contrato, las Partes acuerdan que deber&aacute;n de realizarse por escrito en los domicilios indicados en las declaraciones del presente Contrato.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Cualquiera de las Partes podr&aacute; modificar su domicilio, siempre que el mismo se encuentre dentro de la Ciudad de M&eacute;xico. Para el caso de que alguna de las Partes modifique su domicilio sin dar previo aviso por escrito a la otra parte, se entender&aacute; que los avisos y notificaciones realizados en el domicilio se&ntilde;alado en la presente cl&aacute;usula son v&aacute;lidos y surtir&aacute;n todos sus efectos.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">Para todo lo relacionado con los avisos y notificaciones que las Partes deban de darse entre s&iacute; respecto del presente Contrato, los mismos forzosamente deber&aacute;n de ser efectuados por escrito en los domicilios se&ntilde;alados en la presente cl&aacute;usula, o en aquellos que las Partes se&ntilde;alen con posterioridad, prevaleciendo el sistema de recepci&oacute;n de dichos avisos y notificaciones, por lo que en todo caso se entender&aacute; que surtir&aacute;n sus efectos a partir de que son recibidos por el destinatario de los mismos y no con anterioridad.</p>
    <p>&nbsp;</p>
    <p><strong>VIG&Eacute;SIMA TERCERA. MODIFICACIONES.</strong>&nbsp;</p>
    <p style="text-align: justify;">Las Partes est&aacute;n de acuerdo en que se efect&uacute;en modificaciones al presente Contrato las cuales deber&aacute;n realizarse por escrito firmadas por ambas partes y formar&aacute;n parte integrante del mismo.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p><strong>VIG&Eacute;SIMA CUARTA. SUPLETORIEDAD. </strong></p>
    <p>Para todo lo no previsto en el presente Contrato le ser&aacute;n aplicables supletoriamente las disposiciones del C&oacute;digo Civil para el Distrito Federal.</p>
    <p>&nbsp;</p>
    <p><strong>VIG&Eacute;SIMA QUINTA. JURISDICCI&Oacute;N.</strong></p>
    <p style="text-align: justify;">Las Partes expresamente convienen en que, para el caso de interpretaci&oacute;n y/o ejecuci&oacute;n del presente Contrato se sometan a la jurisdicci&oacute;n de las Leyes y Tribunales de la Ciudad de M&eacute;xico, renunciando al efecto a cualquier fuero que pudiera corresponderles en raz&oacute;n de su domicilio o ubicaci&oacute;n de sus bienes, presente o futuro.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p>&nbsp;</p>
    <p>LE&Iacute;DO QUE FUE EL PRESENTE INSTRUMENTO, CONSTANTE DE _______ FOJAS &Uacute;TILES Y ENTERADAS QUE FUERON LAS PARTES DE SU CONTENIDO, VALOR Y ALCANCE LEGAL, LO FIRMAN AL MARGEN EN CADA UNA DE SUS HOJAS, CON EXCEPCION DE LA &Uacute;LTIMA, QUE SE FIRMA AL CALCE POR TRIPLICADO, EN <strong> CDMX </strong>EL <strong>'.date("d/m/Y").'</strong>.</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table style="width: 1002px;">
    <tbody>
    <tr>
    <td style="width: 540px;">
    <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &ldquo;EL ARRENDADOR&rdquo;</strong></p>
    <p><strong>&nbsp;</strong></p>
    <p><strong>&nbsp;</strong></p>
    <p><strong>&nbsp;</strong></p>
    <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ________________</strong></p>
    <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Por su propio derecho.</strong></p>
    </td>
    <td style="width: 446px;">
    <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &ldquo;EL ARRENDATARIO&rdquo;</strong></p>
    <p><strong>&nbsp;</strong></p>
    <p><strong>&nbsp;</strong></p>
    <p><strong>&nbsp;</strong></p>
    <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ________________</strong></p>
    <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Por su propio derecho.</strong></p>
    <p><strong>&nbsp;</strong></p>
    </td>
    </tr>
    </tbody>
    </table>
    <p><strong>&nbsp;</strong></p>
    <table style="width: 1001px;">
    <tbody>
    <tr>
    <td style="width: 991px;">
    <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &ldquo;EL FIADOR&rdquo;</strong></p>
    <p><strong>&nbsp;</strong></p>
    <p><strong>&nbsp;</strong></p>
    <p><strong>&nbsp;</strong></p>
    <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _________________</strong></p>
    <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Por su propio derecho.</strong></p>
    <p><strong>&nbsp;</strong></p>
    </td>
    </tr>
    </tbody>
    </table>
    <p>&nbsp;</p>'); 

}
else if($tipoContrato=="NPM")
{
    $mpdf->WriteHTML('<p style="text-align: justify;"><strong>CONTRATO DE ARRENDAMIENTO DE CASA HABITACI&Oacute;N (EN LO SUCESIVO, EL &ldquo;<u>CONTRATO</u>&rdquo;) </strong><strong>QUE CELEBRAN POR UNA PARTE &ldquo;'.$nomProp.' '.$apeProp.'&rdquo;, POR SU PROPIO DERECHO (EN LO SUCESIVO, EL &ldquo;<u>ARR</u><u>ENDADOR</u>&rdquo;), Y POR LA OTRA PARTE &ldquo;'.$nomInq.' '.$apeInq.'&rdquo;, POR SU PROPIO DERECHO (EN LO SUCESIVO, EL &ldquo;<u>ARRENDATARIO</u>&rdquo;), CON LA COMPARECENCIA DE &ldquo;'.$aval.'&rdquo;, POR SU PROPIO DERECHO, A QUIEN EN LO SUCESIVO Y PARA EFECTOS DE ESTE CONTRATO SE LE DENOMINAR&Aacute; EL &ldquo;<u>FIADOR</u>&rdquo;, Y A QUIENES EN SU CONJUNTO SE LES DENOMINAR&Aacute; COMO LAS &ldquo;<u>PARTES</u>&rdquo;, DE CONFORMIDAD CON LAS SIGUIENTES DECLARACIONES Y CL&Aacute;USULAS. </strong></p>
<p>&nbsp;</p>
<h2>D E C L A R A CI O N E S</h2>
<p>&nbsp;</p>
<ol>
<li><strong>Declara el ARRENDADOR, por su propio derecho y bajo protesta de decir verdad, que:</strong></li>
</ol>
<p style="padding-left: 30px; text-align: justify;"><strong>&nbsp;</strong>a) Es una persona f&iacute;sica, de nacionalidad mexicana, mayor de edad, en pleno ejercicio de sus derechos y que tiene la capacidad jur&iacute;dica, suficiente y bastante para obligarse en los t&eacute;rminos del presente Contrato.</p>
<p style="padding-left: 30px; text-align: justify;"><strong>&nbsp;</strong>b) Cuenta con el Registro Federal de Contribuyentes n&uacute;mero '.$rfcProp.'.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;c) Para los efectos derivados de este Contrato se&ntilde;ala como su domicilio para recibir y o&iacute;r toda clase de notificaciones y documentos el ubicado en: <strong>'.$domicilioArrendador.'</strong>.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;d) Cuenta con el derecho y la capacidad jur&iacute;dica para otorgar el uso y goce temporal del INMUEBLE ubicado en:<strong> '.$direccion.'</strong>objeto del presente Contrato (en lo sucesivo, el &ldquo;<u>INMUEBLE</u>&rdquo;), el cual tiene una superficie de <strong>'.$superficie.'</strong> metros cuadrados y comprende: <strong>'.$comprende.'</strong>.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;e) Es el leg&iacute;timo propietario del INMUEBLE, lo cual consta en la escritura p&uacute;blica n&uacute;mero <strong>'.$numescritura.'</strong>, de fecha <strong>'.$fechaEscritura.'</strong>, otorgada ante la fe del licenciado <strong>'.$licEscritura.'</strong>, titular de la Notar&iacute;a P&uacute;blica No. <strong>'.$numNotaria.' </strong>de la Ciudad de M&eacute;xico.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;f) Se encuentra en plena posesi&oacute;n y dominio del INMUEBLE objeto del presente Contrato y no tiene impedimento legal ni contractual alguno para otorgarlo en arrendamiento al ARRENDATARIO.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;g) Manifiesta que el INMUEBLE se encuentra en condiciones de ser habitado'.$amueblado.'.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;h) El motivo determinante de su voluntad para celebrar el presente Contrato, es conceder el uso y goce temporal del INMUEBLE pasa uso de casa habitaci&oacute;n en favor del ARRENDATARIO en los t&eacute;rminos y condiciones establecidas en el presente Contrato.</p>
<p>&nbsp;</p>
<ol>
<li><strong>Declara el ARRENDATARIO, por su propio derecho y bajo protesta de decir verdad, que:</strong></li>
</ol>
<p style="padding-left: 30px; text-align: justify;">&nbsp;a) Es una persona f&iacute;sica, mayor de edad, en pleno ejercicio de sus derechos y que tiene la capacidad jur&iacute;dica, suficiente y bastante para obligarse en los t&eacute;rminos del presente Contrato.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;b) Cuenta con el Registro Federal de Contribuyentes n&uacute;mero '.$rfcInq.'.</p>
<p style="padding-left: 30px; text-align: justify;"><strong>&nbsp;</strong>c) Para efectos derivados de este Contrato se&ntilde;ala como su domicilio para recibir y o&iacute;r toda clase de notificaciones y documentos el ubicado en: <strong>'.$domicilioArrendatario.'</strong>.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;d) Tiene inter&eacute;s jur&iacute;dico de recibir en arrendamiento el INMUEBLE, el cual sabe y le consta, que se encuentra en las condiciones necesarias de seguridad e higiene para ser habitado en modalidad de casa habitaci&oacute;n y que cuenta con mobiliario en perfecto estado de uso que se menciona en el inventario que se anexa al presente, por lo que no condicionar&aacute; el pago de rentas a ning&uacute;n tipo de mejora.</p>
<p style="padding-left: 30px; text-align: justify;"><strong>&nbsp;</strong>e) Los recursos provenientes de su actividad y con los cuales dar&aacute; cumplimiento a lo establecido en este Contrato<strong>,</strong> han sido obtenidos y ser&aacute;n en todo momento obtenidos de fuentes l&iacute;citas, producto de actividades realizadas dentro del marco de la ley, manifestando que en ning&uacute;n caso dichos recursos provendr&aacute;n de actividades il&iacute;citas.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;f) Cuenta con la capacidad econ&oacute;mica y financiera necesaria para celebrar y cumplir con sus obligaciones bajo el presente Contrato.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;g) La informaci&oacute;n proporcionada en el presente Contrato es correcta, ver&iacute;dica y precisa, por lo que desde este momento manifiesta su conformidad en que si durante la vigencia de este Contrato se descubriera que su actividad o bien la informaci&oacute;n que proporcion&oacute; para la celebraci&oacute;n del mismo, es falta o inexacta, se entender&aacute; que actu&oacute; de manera dolosa y de mala fe.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;h) El motivo determinante de su voluntad para celebrar el presente Contrato es que el ARRENDADOR le conceda el uso y goce temporal del INMUEBLE, en los t&eacute;rminos y condiciones establecidas en este Contrato.</p>
<p><strong>&nbsp;</strong></p>
<ul>
<li><strong>Declara el FIADOR, </strong><strong>por su propio derecho y bajo protesta de decir verdad, que:</strong></li>
</ul>
<p style="padding-left: 30px; text-align: justify;"><strong>&nbsp;</strong>a) Es una persona f&iacute;sica, de nacionalidad mexicana, con facultades y capacidad suficiente para obligarse en t&eacute;rminos del presente Contrato.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;b) Cuenta con solvencia suficiente y con capacidad econ&oacute;mica para fungir en el presente contrato como FIADOR del ARRENDATARIO, oblig&aacute;ndose en los t&eacute;rminos del mismo.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;c) Se encuentra debidamente inscrita en el Registro Federal de Contribuyentes bajo el n&uacute;mero '.$rfcaval.'.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;d) Para efectos del presente Contrato se&ntilde;ala como su domicilio ubicado en: '.$domicilioAval.'.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;e) Ser propietario del inmueble ubicado: '.$domicilioInmueble.', el cual se describe y consta en la escritura p&uacute;blica n&uacute;mero <strong>'.$numEscrituraArrendatario.'</strong>, de fecha <strong>'.$fechaEscrituraArrendatario.'</strong>, otorgada ante la fe del licenciado <strong>'.$licenciadoArrendatario.'</strong>, titular de la Notar&iacute;a P&uacute;blica No. <strong>'.$notariaArrendatario.' </strong>de la Ciudad de M&eacute;xico; el cual, junto con el resto de su patrimonio, se&ntilde;ala como garant&iacute;a del cabal cumplimiento de sus obligaciones contra&iacute;das en el presente Contrato.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;f) Los recursos con los cuales garantiza el presente Contrato han sido obtenidos de fuentes l&iacute;citas, producto de actividades realizadas dentro del marco de la ley, y no existe conexi&oacute;n alguna entre el origen, procedencia, objetivo o destino de esos recursos o los productos que tales recursos generen con actividades il&iacute;citas.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;g) La informaci&oacute;n proporcionada en el presente Contrato es correcta, ver&iacute;dica y precisa, por lo que desde este momento manifiesta su conformidad en que si durante la vigencia de este Contrato se descubriera que su actividad o bien la informaci&oacute;n que proporcion&oacute; para la celebraci&oacute;n del mismo, es falta o inexacta, se entender&aacute; que actu&oacute; de manera dolosa y de mala fe, por lo que este Contrato ser&aacute; nulo de pleno derecho.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;h) Es su voluntad constituirse como FIADOR del ARRENDATARIO, y por lo tanto responder por el puntual y cabal cumplimiento de las obligaciones que &eacute;ste &uacute;ltimo contrae en el presente instrumento.</p>
<p style="text-align: justify;">&nbsp;</p>
<ol>
<li><strong>Declaran las PARTES, a trav&eacute;s de sus representantes legales y bajo protesta de decir verdad, que:</strong></li>
</ol>
<p style="padding-left: 30px; text-align: justify;"><strong>&nbsp;</strong>a) Se reconocen mutua y rec&iacute;procamente la personalidad con la que acuden a la firma del presente Contrato.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;b) En el presente Contrato no existe dolo, error, mala fe o cualquier otro vicio de la voluntad, por lo que expresamente renuncian a invocarlos en cualquier tiempo.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;c) Contrato es el &uacute;nico documento que se vincula jur&iacute;dicamente entre el ARRENDADOR y el ARRENDATARIO y regula sus derechos respecto del INMUEBLE referido, por lo que, al no existir acuerdos accesorios que modifiquen o condicionen dicho Contrato, no tiene m&aacute;s derechos para con el ARRENDADOR que los contemplados en el presente Contrato. En tal virtud, en este acto, el ARRENDATARIO renuncia expresamente a reclamar judicialmente la existencia de acuerdos, convenios o pagos sobre circunstancias ajenas o especiales a las previstas en el presente documento.</p>
<p style="padding-left: 30px; text-align: justify;">&nbsp;d) Han sido motivos determinantes de su voluntad lo expresado en las declaraciones que anteceden y que por lo tanto convienen en otorgar las siguientes:</p>
<p style="text-align: justify;">&nbsp;</p>
<h2>C L &Aacute; U S U L A S</h2>
<p>&nbsp;</p>
<p><strong>PRIMERA. OBJETO.</strong></p>
<p style="text-align: justify;">El ARRENDADOR en este acto concede en arrendamiento al ARRENDATARIO el uso y goce temporal del INMUEBLE, y este &uacute;ltimo a su vez la recibe &uacute;nica y exclusivamente para casa habitaci&oacute;n (&ldquo;<u>Uso Autorizado</u>&rdquo;), en los t&eacute;rminos establecidos en el presente Contrato.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Las Partes acuerdan que el ARRENDATARIO se obliga a destinar el INMUEBLE &uacute;nica y exclusivamente al Uso Autorizado, por lo que no podr&aacute; destinarlo a un uso distinto del aqu&iacute; establecido. Las Partes convienen que, en caso de cualquier cambio en el giro o uso distinto al aqu&iacute; establecido, facultar&aacute; al ARRENDADOR a exigir la rescisi&oacute;n del presente Contrato y se sujetar&aacute; a lo establecido en el presente Contrato y en la legislaci&oacute;n aplicable.</p>
<p>&nbsp;</p>
<p><strong>SEGUNDA. RENTA.</strong>&nbsp;</p>
<p style="text-align: justify;">El ARRENDATARIO pagar&aacute; al ARRENDADOR o a quien sus derechos represente, por concepto de renta por el uso y goce del INMUEBLE, la cantidad mensual de <strong>'.$renta.'</strong> (&ldquo;<u>Renta</u>&rdquo;).</p>
<p style="text-align: justify;"><strong>&nbsp;</strong></p>
<p style="text-align: justify;">'.$textoMant.'</p>
<p style="text-align: justify;">El pago de la Renta'.$textoPagoMant.' se deber&aacute;n cubrir sin necesidad de requerimiento alguno, por mensualidades adelantadas, dentro de los primeros 10 (diez) d&iacute;as naturales de cada mes; si&eacute;ndole forzoso pagar todo el mes y debiendo cubrir de manera &iacute;ntegra la Renta'.$textoCuota.', a&uacute;n cuando s&oacute;lo usare el INMUEBLE por un periodo menor.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Ambas Partes acuerdan que a partir del primer a&ntilde;o de vigencia del presente Contrato, la Renta podr&aacute; ser actualizada por el ARRENDADOR. La Renta actualizada ser&aacute; exigible al ARRENDATARIO a partir de que el ARRENDADOR le notifique de dicha actualizaci&oacute;n por escrito con al menos 20 (veinte) d&iacute;as de anticipaci&oacute;n al mes en el que se pretenda comenzar a cobrar la renta actualizada y no podr&aacute; actualizarse de nuevo hasta que haya transcurrido un a&ntilde;o nuevamente.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Las obligaciones a cargo del ARRENDATARIO del pago de la Renta'.$textoCuota.' iniciar&aacute;n el d&iacute;a <strong>'.$diapago.'</strong>, siendo que para el inicio de dichas obligaciones no se requerir&aacute; de aviso o convenio alguno posterior entre las Partes, sino que iniciar&aacute;n de forma autom&aacute;tica.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Para el caso de que el ARRENDATARIO se atrase en el pago de la Renta'.$textoCuota.', se obliga a pagar a favor del ARRENDADOR intereses moratorios a raz&oacute;n del 6% (seis por ciento) anual, sobre saldos insolutos, por cada d&iacute;a natural de retraso y hasta la liquidaci&oacute;n total del adeudo en cuesti&oacute;n, m&aacute;s el correspondiente Impuesto al Valor Agregado; lo anterior, sin perjuicio del derecho del ARRENDADOR a exigir el pago de dichas cantidades adeudadas y/o el cumplimiento forzoso del presente Contrato.</p>
<p style="text-align: justify;">&nbsp;</p>
<p><strong>TERCERA. ENTREGA DEL INMUEBLE. </strong></p>
<p style="text-align: justify;">El ARRENDADOR entregar&aacute; al ARRENDATARIO y &eacute;ste recibir&aacute; la posesi&oacute;n material del INMUEBLE el d&iacute;a de la fecha de firma del presente Contrato, y desde ese entonces el ARRENDATARIO ser&aacute; el &uacute;nico responsable de la existencia, uso y operaci&oacute;n del INMUEBLE.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">El ARRENDATARIO se encuentra obligado a pagar la Renta a partir de la firma del presente Contrato.&nbsp;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">A partir de la fecha de entrega indicada en la presente cl&aacute;usula, el ARRENDATARIO ser&aacute; el &uacute;nico responsable del uso del INMUEBLE, salvo por las obligaciones a cargo del ARRENDADOR estipuladas en este Contrato.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">El ARRENDATARIO acepta recibir el INMUEBLE en el estado en el que se encuentra, en condiciones de higiene y seguridad, suficientes y necesarias para ser habitable, pues cuenta con instalaciones adecuadas de luz, agua y drenaje, por lo cual, acepta recibir el INMUEBLE en buen estado y a su entera satisfacci&oacute;n de conformidad con lo dispuesto en los art&iacute;culos 2412, fracci&oacute;n I y 2443 del C&oacute;digo Civil Federal vigente y su correlativo aplicable del C&oacute;digo Local.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Una vez concluido el presente Contrato, el ARRENDATARIO entregar&aacute; la posesi&oacute;n material del INMUEBLE al ARRENDADOR en el mismo estado en que lo recibi&oacute; a la celebraci&oacute;n de este Contrato. En consecuencia, el ARRENDATARIO se compromete a devolver el INMUEBLE sin m&aacute;s deterioro que el causado por el uso normal y racional del mismo.</p>
<p style="text-align: justify;">&nbsp;</p>
<p><strong>CUARTA. LUGAR Y FORMA DE PAGO.</strong></p>
<p style="text-align: justify;">Las Partes convienen que la Renta se pagar&aacute; por el ARRENDATARIO en efectivo en el domicilio del ARRENDADOR se&ntilde;alado en las declaraciones del presente Contrato o mediante transferencia interbancaria a la siguente cuenta bancaria, o en la cuenta bancaria que el ARRENDADOR le informe de tiempo en tiempo al ARRENDADOR:</p>
<p><strong>&nbsp;</strong></p>
<p>BENEFICIARIO <strong>_________________________________________________</strong></p>
<p>BANCO <strong>_________________________________________________</strong></p>
<p>CUENTA <strong>_________________________________________________</strong></p>
<p>CLABE <strong>_________________________________________________</strong></p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">En todo caso, el ARRENDADOR emitir&aacute; los recibos por los pagos efectivamente realizados por el ARRENDATARIO.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Por ning&uacute;n concepto y bajo ninguna circunstancia podr&aacute; el ARRENDATARIO retener la Renta. El ARRENDATARIO conviene en que el pago de la Renta ser&aacute; independiente del cumplimiento de cualquier otra obligaci&oacute;n derivada de este Contrato, por lo que no puede ser retenida por ning&uacute;n motivo.</p>
<p style="text-align: justify;">&nbsp;</p>
<p><strong>QUINTA. VIGENCIA.</strong>&nbsp;</p>
<p style="text-align: justify;">La vigencia del presente Contrato ser&aacute; de <strong>'.$meses.' </strong>meses forzosos para ambas partes, iniciando su vigencia el d&iacute;a <strong>'.$fechaIni.' </strong>y terminando el d&iacute;a <strong>'.$fechaFin.'</strong> debiendo dar aviso el ARRENDATARIO al ARRENDADOR por escrito con 30 (treinta) d&iacute;as de anticipaci&oacute;n a su vencimiento, si es su deseo continuar con el arrendamiento, reserv&aacute;ndose el ARRENDADOR el derecho de aceptar dicha renovaci&oacute;n, lo cual en todo caso lo har&aacute; mediante la celebraci&oacute;n de un nuevo contrato o mediante la modificaci&oacute;n del presente Contrato y siempre y cuando el ARRENDATARIO haya cumplido en tiempo y forma con el pago total de la Renta pactada, y sean renovadas y actualizadas las garant&iacute;as se&ntilde;aladas en el presente Contrato.</p>
<p style="text-align: justify;"><strong>&nbsp;</strong></p>
<p style="text-align: justify;">En caso de que el ARRENDATARIO sea el que desee dar por terminado el presente Contrato, adem&aacute;s del aviso por escrito antes mencionado, autoriza al ARRENDADOR a poner c&eacute;dulas visibles en el exterior del INMUEBLE, ofreci&eacute;ndolo en arrendamiento, as&iacute; como a mostrar el interior del INMUEBLE a las personas que se encuentren interesadas en &eacute;l.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Ambas partes convienen que para el caso de que proceda la renovaci&oacute;n del presente Contrato, la contraprestaci&oacute;n total se incrementar&aacute; con base en la variaci&oacute;n que sufra el &Iacute;ndice Nacional de Precios al Consumidor (en lo sucesivo &ldquo;<u>INPC</u>&rdquo;), que publique la Secretar&iacute;a de Hacienda a trav&eacute;s del Servicio de Administraci&oacute;n Tributaria (o en su caso la entidad correspondiente), en el Diario Oficial de la Federaci&oacute;n, para los doce (12) meses inmediatos anteriores a la fecha en que proceda llevar a cabo el incremento que corresponda, salvo pacto en contrario que conste por escrito.</p>
<p>&nbsp;</p>
<p><strong>SEXTA. PENA CONVENCIONAL.</strong>&nbsp;</p>
<p style="text-align: justify;">Las Partes convienen que para el caso de incumplimiento en el pago de la Renta'.$textoPagoCuota.' en el tiempo y forma estipulados en el presente Contrato, el ARRENDATARIO se obliga a pagar al ARRENDADOR por concepto de pena convencional la cantidad equivalente al <strong>_____ </strong>% sobre el monto de la Renta'.$textoRespectivamente.', aceptando en este acto el ARRENDATARIO que el retraso en el cumplimiento del pago de la renta'.$textoEnLaCuota.' es de su exclusiva responsabilidad, por lo que acepta que si el retraso en el pago excede la fecha pactada, se contin&uacute;en generando dichos intereses hasta su total liquidaci&oacute;n al ARRENDADOR.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Asimismo, las Partes convienen que para cualquier otro incumplimiento a cualquier otra obligaci&oacute;n a cargo del ARRENDATARIO, &eacute;ste se obliga a pagar al ARRENDADOR por concepto de pena convencional, el equivalente al <strong>_____ </strong>% de la Renta por cada uno de los incumplimientos derivados del presente contrato y a cargo del ARRENDATARIO, siempre que no consistan en el incumplimiento a que refiere el primer p&aacute;rrafo de esta cl&aacute;usula.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Cuando el ARRENDATARIO, realice el pago de la Renta por medio de cheque, y &eacute;ste no fuere pagado por la instituci&oacute;n bancaria emisora por cualquier causa, se considerar&aacute; que el pago por concepto de renta correspondiente, no fue recibido por el ARRENDADOR en tiempo y forma, quedando obligado el ARRENDATARIO a cubrir los gastos que dicho il&iacute;cito genere, adem&aacute;s pagar&aacute; el 20% (veinte por ciento) del valor del cheque, as&iacute; como las comisiones vigentes que la instituci&oacute;n bancaria de que se trate haya establecido. Se reserva el ARRENDADOR a recibir salvo buen cobro, el pago de la Renta por medio de cheque.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Si el ARRENDATARIO otorga al ARRENDADOR el importe correspondiente a la Renta en fecha y forma distinta de la estipulada en el presente instrumento, o recibe abonos a cuenta de la misma, no se tendr&aacute; por renovado el contrato en t&eacute;rminos, fechas o forma de pago, por lo que el ARRENDATARIO acepta que dicho pago se aplique primeramente al pago de la pena convencional correspondiente, y el saldo a la Renta mensual de que se trate.</p>
<p style="text-align: justify;">&nbsp;</p>
<p><strong>S&Eacute;PTIMA. DEP&Oacute;SITO EN GARANT&Iacute;A.</strong>&nbsp;</p>
<p style="text-align: justify;">El ARRENDATARIO entrega al ARRENDADOR para garantizar el cumplimiento oportuno de las obligaciones establecidas en este Contrato, un dep&oacute;sito en garant&iacute;a, por dicho concepto por un monto equivalente a 2 (dos) meses de Renta, m&aacute;s el Impuesto al Valor Agregado correspondiente (&ldquo;<u>Dep&oacute;sito en Garant&iacute;a</u>&rdquo;).</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Si en alg&uacute;n momento de la vigencia de este Contrato el Dep&oacute;sito en Garant&iacute;a es menor a un monto equivalente a 2 (dos) meses de Renta, el ARRENDATARIO se obliga a entregar al ARRENDADOR cualquier diferencia que as&iacute; resulte para completar el Dep&oacute;sito en Garant&iacute;a dentro de los 10 (diez) d&iacute;as naturales siguientes a la solicitud del ARRENDADOR.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Las Partes acuerdan que el ARRENDADOR a su libre elecci&oacute;n y sin responsabilidad alguna, estar&aacute; facultada para utilizar el monto del Dep&oacute;sito en Garant&iacute;a para pagar a cualquier tercero y a&uacute;n en su favor, cualquier cantidad debida y no pagada por el ARRENDATARIO, incluyendo de forma enunciativa m&aacute;s no limitativa, Renta, tel&eacute;fono, gas, energ&iacute;a el&eacute;ctrica, as&iacute; como cualquier otro servicio y obligaci&oacute;n a cargo de &eacute;ste &uacute;ltimo, para lo cual el ARRENDADOR deber&aacute; notificar al ARRENDATARIO la existencia de dicho adeudo, otorg&aacute;ndole un plazo m&aacute;ximo de 10 (diez) d&iacute;as contados a partir de la fecha de notificaci&oacute;n, para que el ARRENDATARIO realice el pago.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">EL ARRENDATARIO autoriza expresamente al ARRENDADOR a conservar el Dep&oacute;sito en Garant&iacute;a (liber&aacute;ndolo de la obligaci&oacute;n de depositarlo judicialmente) durante un plazo de 60 (sesenta) d&iacute;as posteriores a que haya desocupado y entregado la localidad arrendada a satisfacci&oacute;n del ARRENDADOR. Transcurrido este plazo, el ARRENDADOR devolver&aacute; al ARRENDATARIO el mencionado dep&oacute;sito sin inter&eacute;s ni rendimiento financiero alguno, siempre y cuando &eacute;ste no se hubiere ocupado o no existiere ning&uacute;n saldo pendiente a cargo del ARRENDATARIO por cualquier concepto, pues en dicho caso se aplicar&aacute; el dep&oacute;sito al pago de los saldos pendientes y para el caso que fueren insuficientes, el ARRENDADOR tendr&aacute; derecho expedito para reclamar su pago al FIADOR. A su vez, el ARRENDADOR deber&aacute; devolver el Dep&oacute;sito en Garant&iacute;a siempre y cuando, (i) el INMUEBLE sea entregado en buenas condiciones y solo con el desgaste del uso normal; (ii) no existan pagos pendientes respecto de la Renta y/o cualquier otro concepto u otros servicios; y (iii) no existan da&ntilde;os a las &aacute;reas comunes, ocasionados por el ARRENDATARIO sus visitantes, o cualquier tercero que se relacione con este &uacute;ltimo.</p>
<p>&nbsp;</p>
<p><strong>OCTAVA. SERVICIOS.</strong></p>
<p style="text-align: justify;">A partir de la entrega del INMUEBLE, el ARRENDATARIO se obliga a pagar directa y oportunamente el importe de los servicios que vaya a utilizar por uso del INMUEBLE, tales como: energ&iacute;a el&eacute;ctrica, servicio de agua potable, servicios de telefon&iacute;a, televisi&oacute;n por cable, vigilancia privada, limpieza, gas y/o cualquier otro, y posteriormente har&aacute; entrega al ARRENDADOR de los recibos originales liquidados por tales conceptos, cada 2 meses despu&eacute;s de haber sido pagados, en el entendido de que los servicios se generan de manera bimestral.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">El impuesto predial y cualquier otro impuesto que se cause ser&aacute; cubierto por el ARRENDADOR.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Los servicios con los que cuenta el INMUEBLE son: <strong>___________________________________________________________</strong>.</p>
<p style="text-align: justify;"><strong>&nbsp;</strong></p>
<p style="text-align: justify;">Los servicios incluidos en el mantenimiento son: <strong>___________________________________________________________</strong>.</p>
<p style="text-align: justify;"><strong>&nbsp;</strong></p>
<p style="text-align: justify;">Todos los asuntos relacionados con los servicios que cuente el INMUEBLE, deber&aacute;n ser comunicados por escrito al ARRENDADOR, o a quien sus derechos represente, dentro del t&eacute;rmino de 10 (diez) d&iacute;as a partir de que el ARRENDATARIO tenga conocimiento de esa situaci&oacute;n, de lo contrario, los da&ntilde;os y perjuicios causados por no haber dado aviso oportuno al ARRENDADOR, correr&aacute;n a cargo del ARRENDATARIO.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Todo servicio adicional que se contrate en el INMUEBLE debe notificarse al ARRENDADOR, as&iacute; como entregar una copia del contrato del servicio y, en caso de la terminaci&oacute;n del presente Contrato, se deber&aacute; entregar el comprobante de cancelaci&oacute;n de cada servicio contratado por el ARRENDATARIO.</p>
<p><u>&nbsp;</u></p>
<p><strong>NOVENA. MEJORAS AL INMUEBLE ARRENDADO. </strong>&nbsp;</p>
<p style="text-align: justify;">El ARRENDATARIO se encuentra obligado a devolver el INMUEBLE en las condiciones en las que lo recibe salvo el desgaste normal y natural por el uso que se les d&eacute;; por lo cual, no podr&aacute; realizar sin el consentimiento y autorizaci&oacute;n por escrito del ARRENDADOR, ning&uacute;n tipo de obra, particularmente, aquellas que modifiquen la estructura del lugar, y tampoco podr&aacute; perforar las paredes, techos y/o en el suelo de este salvo que el ARRENDADOR lo autorice.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Sin perjuicio de poder exigir una indemnizaci&oacute;n por da&ntilde;os y perjuicios, el ARRENDADOR podr&aacute; exigir adem&aacute;s, que el ARRENDATARIO responga las cosas al estado previo a las modificaciones efectuadas sin autorizaci&oacute;n, sin que el ARRENDATARIO pueda reclamar pago alguno.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">A&uacute;n existiendo autorizaci&oacute;n por parte del ARRENDADOR, el ARRENDATARIO ser&aacute; exclusivamente responsable de los da&ntilde;os que puedan llegar ocasionarse con las obras que se realicen. Por lo tanto, todas las mejoras, adecuaciones, obras que realice el ARRENDATARIO por s&iacute; mismo, a&uacute;n contando con autorizaci&oacute;n del ARRENDADOR, correr&aacute;n a cargo y costo del ARRENDATARIO.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">El proyecto de las obras, mejoras y/o adecuaciones deber&aacute; ser sometido, previo a su ejecuci&oacute;n, a la aprobaci&oacute;n del ARRENDADOR.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Las Partes acuerdan que todas las mejoras que se hagan en el INMUEBLE quedar&aacute;n a beneficio del mismo, sin que por esto pueda el ARRENDATARIO exigir precio alguno o compensaci&oacute;n contra el pago de la Renta, en el entendido adem&aacute;s de que el ARRENDATARIO podr&aacute; remover del INMUEBLE todas aquellas adecuaciones, obras y/o mejoras muebles o m&oacute;viles, cuya remoci&oacute;n, separaci&oacute;n y/o desmantelamiento no causen da&ntilde;o alguno al INMUEBLE. Si durante la realizaci&oacute;n de estas adecuaciones, mejoras y/o obras o remoci&oacute;n de las mismas se ocasionan da&ntilde;os, el ARRENDATARIO indemnizar&aacute; al ARRENDADOR o a quien &eacute;ste designe.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">En todo caso, el ARRENDATARIO quedar&aacute; obligado a mantener en paz y a salvo al ARRENDADOR de cualquier reclamaci&oacute;n, procedimiento administrativo, demanda y/o juicio de cualquier naturaleza, incluyendo laboral, fiscal o ambiental y a indemnizar al ARRENDADOR por cualquier da&ntilde;o o p&eacute;rdida que sufra con motivo del incumplimiento del ARRENDATARIO y/o de sus contratistas, subcontratistas, arquitecto y/o director responsable de la obra o cualquier proveedor, a cualquiera de las obligaciones consignadas en esta cl&aacute;usula.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Por otro lado, el ARRENDADOR se encuentra obligado a realizar todas las reparaciones que sean necesarias para conservar el inmueble en buen estado y servir as&iacute; adecuadamente al Uso Autorizado, salvo cuando el deterioro sea imputable al ARRENDATARIO, en cuyo caso &eacute;ste deber&aacute; realizar las reparaciones correspondientes.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">El ARRENDATARIO ser&aacute; responsable de conservar y mantener en buen estado el INMUEBLE, procur&aacute;ndole mantenimiento preventivo y correctivo de manera ordinaria y peri&oacute;dica.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">El ARRENDADOR tendr&aacute; la obligaci&oacute;n de llevar a cabo las reparaciones estructurales del INMUEBLE.</p>
<p>&nbsp;</p>
<p><strong>D&Eacute;CIMA. HIGIENE.</strong></p>
<p style="text-align: justify;">EL ARRENDATARIO deber&aacute; mantener en condiciones higi&eacute;nicas las azoteas, conductos de ca&ntilde;er&iacute;as y drenajes del INMUEBLE as&iacute; como las &aacute;reas comunes que le correspondan, para evitar humedad y goteras; de no hacerlo as&iacute;, cualquier da&ntilde;o ser&aacute; a su costa, ya que el mantenimiento del INMUEBLE materia del presente arrendamiento es su responsabilidad.</p>
<p>&nbsp;</p>
<p><strong>D&Eacute;CIMA PRIMERA. DA&Ntilde;OS O FALTANTES.</strong>&nbsp;</p>
<p style="text-align: justify;">El ARRENDADOR no ser&aacute; responsable de los da&ntilde;os o faltantes sufridos en veh&iacute;culos, bienes muebles o patrimonio del ARRENDATARIO, durante la ocupaci&oacute;n o desocupaci&oacute;n del INMUEBLE, ni durante el tiempo que dure su estancia en el mismo, ya que el ARRENDATARIO queda a cargo de la seguridad del INMUEBLE arrendado a partir de la firma del presente Contrato, por lo que desde este momento el ARRENDADOR le autoriza modificar la combinaci&oacute;n de la(s) cerradura(s) que dan acceso a la localidad arrendada.</p>
<p>&nbsp;</p>
<p><strong>D&Eacute;CIMA SEGUNDA. CUIDADO DEL INMUEBLE.</strong>&nbsp;</p>
<p style="text-align: justify;">El ARRENDATARIO se obliga a no perforar azulejos, pisos, puertas, o colocar muebles que da&ntilde;en los acabados del INMUEBLE, sin previa autorizaci&oacute;n por escrito del ARRENDADOR y a darle el mantenimiento adecuado y oportuno a los muebles que forman parte de las instalaciones del INMUEBLE. Asimismo, en caso de rotura de vidrios, deber&aacute; el ARRENDATARIO reponerlos de inmediato.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">En general, el ARRENDATARIO se obliga a mantener el INMUEBLE arrendado, en las mismas condiciones en las que le fue entregado. EL ARRENDADOR no ser&aacute; responsable de los da&ntilde;os ocasionados a los vecinos y/o a sus bienes, por la falta del mantenimiento antes mencionado.</p>
<p style="text-align: justify;">&nbsp;</p>
<p><strong>D&Eacute;CIMA TERCERA. OBLIGACIONES ADICIONALES</strong>.</p>
<p>En adici&oacute;n a las dem&aacute;s obligaciones establecidas en t&eacute;rminos del presente Contrato, el ARRENDATARIO se obliga a:</p>
<p>&nbsp;</p>
<ol>
<li style="text-align: justify;">Facilitar una convivencia pac&iacute;fica con los vecinos, y a dar un uso correcto y adecuado al INMUEBLE.</li>
<li style="text-align: justify;">Mantener el INMUEBLE en condiciones de aseo adecuadas para su uso.</li>
<li style="text-align: justify;">Tener especial cuidado de las llaves, pases de acceso y/o controles o dispositivos de acceso al lugar, y en caso de p&eacute;rdida de alguno de estos, deber&aacute; comunicarlo inmediatamente al ARRENDADOR, adem&aacute;s de pagar todos los gastos de que deriven de tal p&eacute;rdida.</li>
<li style="text-align: justify;">Llevar a cabo todos los actos necesarios para mantener y renovar todos los derechos, permisos, licencias y contratos necesarios para desarrollar las adecuaciones, mejoras y/o obras en el INMUEBLE durante la vigencia del presente Contrato.</li>
<li style="text-align: justify;">Notificar al ARRENDADOR de manera inmediata sobre cualquier notificaci&oacute;n o emplazamiento respecto de cualquier acci&oacute;n o procedimiento judicial y extrajudicial que afecte o pudiera llegar a afectar el uso del INMUEBLE.</li>
<li style="text-align: justify;">Notificar al ARRENDADOR en un plazo m&aacute;ximo de 3 (tres) d&iacute;as naturales posteriores sobre cualquier siniestro, aver&iacute;a o desperfecto que se produzca en el INMUEBLE, a&uacute;n cuando no sea aparente.</li>
<li style="text-align: justify;">No permitir y evitar que cualquier persona introduzca o mantenga sustancias ilegales o materiales peligrosos (como dicho t&eacute;rmino se define en la legislaci&oacute;n mexicana y en las normas oficiales mexicanas aplicables) dentro de la superficie arrendada, as&iacute; como tampoco transportar, almacenar, usar, producir, manufacturar, disponer, o liberar cualquier material peligroso en o alrededor de dichas &aacute;reas.</li>
<li style="text-align: justify;">En el supuesto que el ARRENDATARIO contratare l&iacute;neas telef&oacute;nicas para el uso del INMUEBLE, los contratos correspondientes deber&aacute;n ser celebrados directamente a nombre y por cuenta del ARRENDATARIO con la compa&ntilde;&iacute;a respectiva.</li>
<li style="text-align: justify;">Abstenerse de modificar en forma alguna la estructura e instalaciones del INMUEBLE, las fachadas, pasillos y dem&aacute;s &aacute;reas comunes.</li>
</ol>
<p>&nbsp;</p>
<p>En adici&oacute;n a las dem&aacute;s obligaciones establecidas en t&eacute;rminos del presente Contrato, el ARRENDADOR se obliga a:</p>
<p>&nbsp;</p>
<ol>
<li style="text-align: justify;">Entregar el INMUEBLE al ARRENDADOR conforme a lo establecido en el presente Contrato.</li>
<li style="text-align: justify;">Conservar fachadas, instalaciones comunes y estructura del INMUEBLE buen estado durante la vigencia de este Contrato.</li>
<li style="text-align: justify;">No estorbar ni menoscabar de manera alguna el uso de las &aacute;reas arrendadas a no ser por causa de reparaciones urgentes e indispensables.</li>
<li style="text-align: justify;">Garantizar el uso o goce pac&iacute;fico de las &aacute;reas arrendadas durante la vigencia de este Contrato, mientras dicho uso o goce no sea interrumpido por actos de terceros y/o casos de fuerza mayor.</li>
<li style="text-align: justify;">Responder de los da&ntilde;os y perjuicios que sufra el ARRENDATARIO por los defectos o vicios ocultos de la cosa, anteriores y durante el arrendamiento. El ARRENDADOR responde de los vicios o defectos del INMUEBLE que impidan el uso de ella, aunque &eacute;l no los hubiese conocido o hubiesen sobrevenido en el curso del arrendamiento, sin culpa del ARRENDATARIO, el cual puede pedir la disminuci&oacute;n de la renta o la rescisi&oacute;n del Contrato.</li>
<li style="text-align: justify;">Corresponde al ARRENDADOR pagar las mejoras hechas por el ARRENDATARIO si en el Contrato, o posteriormente, por escrito, lo autoriz&oacute; para hacerlas y se oblig&oacute; a pagarlas o cuando se trate de mejoras &uacute;tiles o urgentes por causa de fuerza mayor.</li>
</ol>
<p>&nbsp;</p>
<p><strong>D&Eacute;CIMA CUARTA. DESOCUPACI&Oacute;N.</strong>&nbsp;</p>
<p style="text-align: justify;">Las Partes acuerdan que si al t&eacute;rmino de la vigencia del presente Contrato no hubiere renovaci&oacute;n del mismo, el ARRENDATARIO estar&aacute; obligado a desocupar el INMUEBLE arrendado a m&aacute;s tardar en la fecha de su vencimiento y si por cualquier motivo no lo hiciere, deber&aacute; pagar el doble de la Renta pactada por cada uno de los doce meses siguientes que siga ocup&aacute;ndolo, y el triple de dicha Renta durante cada mes que le siga, hasta la total desocupaci&oacute;n y entrega legal del INMUEBLE materia del presente Contrato, sin que esto implique renovaci&oacute;n o pr&oacute;rroga del mismo y por lo tanto sin perjuicio de la acci&oacute;n jur&iacute;dica que el ARRENDADOR ejerza para exigir dicha desocupaci&oacute;n, renunciando expresamente el ARRENDATARIO al aviso que prev&eacute; el C&oacute;digo Civil vigente para el Distrito Federal. Adicional, dar&aacute; motivo al ARRENDATARIO al pago de da&ntilde;os y perjuicios generados al ARRENDADOR.</p>
<p style="text-align: justify;"><strong>&nbsp;</strong></p>
<p style="text-align: justify;">Lo anterior tambi&eacute;n aplica en caso de terminaci&oacute;n del presente Contrato por cualquiera de las causas previstas en este Contrato.&nbsp;</p>
<p style="text-align: justify;"><strong>&nbsp;</strong></p>
<p style="text-align: justify;">Aunado a lo anterior, en caso de que el ARRENDATARIO demande judicialmente la desocupaci&oacute;n y entrega del INMUEBLE al ARRENDATARIO, y este resulta condenada, pagar&aacute; los honorarios y gastos que origine el juicio correspondiente, consituy&eacute;ndose deudor solidario de esta obligaci&oacute;n y renunciando ambos a los beneficios de orden y exclusi&oacute;n. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p style="text-align: justify;">&nbsp;</p>
<p><strong>D&Eacute;CIMA QUINTA. RESCISI&Oacute;N.</strong></p>
<p style="text-align: justify;">En adici&oacute;n a las causas de rescisi&oacute;n establecidas en el C&oacute;digo Civil para el Distrito Federal, el ARRENDADOR se encontrar&aacute; facultado para rescindir este Contrato, de forma autom&aacute;tica y sin necesidad de resoluci&oacute;n judicial al respecto, mediante aviso dado por escrito al ARRENDATARIO, operando dicha rescisi&oacute;n de pleno derecho, en el supuesto de que el ARRENDATARIO incurra en cualquiera de los siguientes supuestos:</p>
<p>&nbsp;</p>
<ol>
<li style="text-align: justify;">Si la informaci&oacute;n proporcionada por el ARRENDATARIO para la celebraci&oacute;n de este Contrato no es correcta, ver&iacute;dica y precisa.</li>
<li style="text-align: justify;">Si el ARRENDATARIO no conserva el INMUEBLE en buenas condiciones de mantenimiento y conservaci&oacute;n con recursos propios.</li>
<li style="text-align: justify;">Si el ARRENDATARIO variare la forma del INMUEBLE o variare el Uso Autorizado para el que fue arrendado conforme a lo establecido en el presente Contrato, sin autorizaci&oacute;n previa y por escrito del ARRENDADOR.</li>
<li style="text-align: justify;">Si el INMUEBLE es objeto de perturbaci&oacute;n o cualquier otro acto de terceros que afecte el uso o goce del mismo, la posesi&oacute;n del mismo o bien la propiedad, por error, omisi&oacute;n, negligencia o culpa del ARRENDATARIO.</li>
<li style="text-align: justify;">En caso de que el ARRENDATARIO dejare de cumplir con el pago de la Renta, no se haya cubierto de manera &iacute;ntegra, o se haya realizado de manera extempor&aacute;nea, durante la vigencia del Contrato.</li>
<li style="text-align: justify;">Si el ARRENDATARIO subarrienda, cede o negocia en cualquier forma con terceros los derechos que ampara este Contrato, sin la autorizaci&oacute;n previa y por escrito del ARRENDADOR.</li>
<li style="text-align: justify;">Si el ARRENDATARIO dejare de pagar cualquier cantidad que se adeude por concepto de uso y posesi&oacute;n del INMUEBLE objeto de este Contrato.</li>
<li style="text-align: justify;">Si el ARRENDATARIO opera o utiliza el INMUEBLE para cualquier uso distinto al Uso Autorizado.</li>
<li style="text-align: justify;">Si el ARRENDATARIO inicia los trabajos de adecuaciones o realiza obras, alteraciones o modificaciones al INMUEBLE, sin la aprobaci&oacute;n previa y por escrito del ARRENDADOR.</li>
<li style="text-align: justify;">Si el ARRENDATARIO no responde por incendio en t&eacute;rminos de lo establecido en el C&oacute;digo Civil.</li>
<li style="text-align: justify;">Si el ARRENDATARIO abandona el INMUEBLE, sin causa justificada, por un periodo que exceda de 60 (sesenta) d&iacute;as naturales.</li>
<li style="text-align: justify;">Si el ARRENDATARIO incumple con cualquier otra obligaci&oacute;n asumida a su cargo en el presente Contrato.</li>
</ol>
<p>&nbsp;</p>
<p style="text-align: justify;">En caso de que el ARRENDATARIO incurra en cualquiera de las causas de rescisi&oacute;n antes se&ntilde;aladas, el ARRENDADOR le notificar&aacute; por escrito dicho incumplimiento, siendo que el ARRENDATARIO gozar&aacute; de un plazo de 15 (quince) d&iacute;as naturales para subsanar el mismo, con excepci&oacute;n del incumplimiento en el pago de la Renta. En caso de que el incumplimiento de que se trate no sea subsanado dentro del citado plazo de 15 (quince) d&iacute;as naturales, entonces el presente Contrato podr&aacute; ser rescindido por el ARRENDADOR mediante aviso por escrito al ARRENDATARIO, sin necesidad de declaraci&oacute;n judicial al respecto (pacto comisorio expreso).</p>
<p>&nbsp;</p>
<p><strong>D&Eacute;CIMA SEXTA. FIADOR</strong><strong>.</strong>&nbsp;</p>
<p style="text-align: justify;">En garant&iacute;a al cumplimiento de las obligaciones contra&iacute;das en el presente Contrato por parte del ARRENDATARIO, el FIADOR lo firma solidariamente, constituy&eacute;ndose as&iacute; en pagador de todas y cada una de dichas obligaciones, renunciando expresamente a los beneficios de orden y excusi&oacute;n en el presente Contrato; por tanto, el ARRENDADOR est&aacute; en aptitud de demandar el cumplimiento de las obligaciones contra&iacute;das contra el ARRENDATARIO, contra el FIADOR o contra ambos, en una o diversas acciones.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">El FIADOR conviene en que su responsabilidad legal no cesa sino hasta el momento en que el ARRENDADOR se d&eacute; por recibido del INMUEBLE, as&iacute; como&nbsp; del pago total de lo adeudado a su entera satisfacci&oacute;n, a&uacute;n y cuando la vigencia del presente contrato haya concluido.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">El ARRENDADOR podr&aacute; rehusarse a aceptar aquella persona que en su concepto no re&uacute;na los requisitos necesarios para garantizar como FIADOR el debido cumplimiento del presente Contrato.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">El ARRENDATARIO autoriza al FIADOR para que entregue el INMUEBLE cuando &eacute;l por ausencia o negligencia no lo haga.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Si durante la vigencia del presente Contrato el FIADOR fallece, tramite la propiedad o le es embargado el inmueble que ha se&ntilde;alado como base de su garant&iacute;a, el ARRENDATARIO deber&aacute; avisar de inmediato al ARRENDADOR y se&ntilde;alar nuevo FIADOR que tenga capacidad para obligarse y bienes suficientes para garantizar el cumplimiento de este Contrato, ya que en caso contrato el ARRENDADOR podr&aacute; rescindir este Contrato sin necesidad de intervenci&oacute;n judicial.&nbsp;</p>
<p>&nbsp;</p>
<p><strong>D&Eacute;CIMA S&Eacute;PTIMA. SINIESTROS Y CLAUSURAS.</strong></p>
<p style="text-align: justify;">Los da&ntilde;os ocasionados al INMUEBLE, as&iacute; como a los colindantes, por siniestros originados por culpa o negligencia del ARRENDATARIO, de su FIADOR y/o de toda persona que viva o visite por cualquier motivo el INMUEBLE, ser&aacute;n de la exclusiva responsabilidad del ARRENDATARIO, por lo que en caso de detectar alg&uacute;n equipo o instalaci&oacute;n en mal estado durante la ocupaci&oacute;n del mismo, se deber&aacute; dar aviso por escrito al ARRENDADOR, con acuse de recibo, para proceder a la reparaci&oacute;n, por cuenta del ARRENDADOR, siempre y cuando no sea imputable la falla al ARRENDATARIO.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Cuando el INMUEBLE materia del arrendamiento sea clausurado o suspendido en su uso por disposici&oacute;n de autoridad competente y/o por causas imputables al ARRENDATARIO, &eacute;ste se obliga a continuar pagando la Renta pactada en el plazo convenido. El incumplimiento de esta obligaci&oacute;n originar&aacute; el pago de una pena convencional a cargo del ARRENDATARIO en favor del ARRENDADOR seg&uacute;n lo establecido en el presente Contrato.</p>
<p>&nbsp;</p>
<p><strong>D&Eacute;CIMA OCTAVA. CESI&Oacute;N DE DERECHOS.</strong>&nbsp;</p>
<p style="text-align: justify;">Ninguna de las Partes podr&aacute; subarrendar, traspasar o ceder los derechos y obligaciones derivados del presente Contrato a un tercero. &nbsp;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Se conviene adem&aacute;s que no se conceder&aacute; autorizaci&oacute;n al ARRENDATARIO para subarrendar en forma total o parcial a terceros el INMUEBLE, y en caso contrario, ser&aacute; causa inmediata del presente Contrato.</p>
<p>&nbsp;</p>
<p><strong>D&Eacute;XIMA NOVENA. CONFIDENCIALIDAD. </strong></p>
<p style="text-align: justify;">Durante la vigencia del presente Contrato, cualquiera de las Partes podr&aacute; obtener de la otra cierta informaci&oacute;n considerada como confidencial. Las Partes convienen en no divulgar dicha informaci&oacute;n confidencial a ninguna tercera parte, siendo que la parte que reciba la informaci&oacute;n responder&aacute; y ser&aacute; responsable de sus empleados, agentes, y distribuidores que divulguen informaci&oacute;n confidencial derivada de la relaci&oacute;n que se genera por la celebraci&oacute;n de este Contrato. La parte que divulgue indebidamente la informaci&oacute;n indemnizar&aacute; a la otra parte y la mantendr&aacute; a salvo por cualquiera de los da&ntilde;os directamente ocasionados por actos u omisiones realizados. Esta disposici&oacute;n se aplicar&aacute; y obligar&aacute; a las Partes a mantener una relaci&oacute;n confidencial.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Las Partes aceptan tomar por su propia cuenta todas las acciones razonables incluyendo, sin limitaci&oacute;n, procedimientos legales, para imponer el cumplimiento a PARTES a quienes se les divulgue tal informaci&oacute;n mediante contratos escritos de acuerdo a la presente cl&aacute;usula.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Cada una de las PARTES preservar&aacute; la confidencialidad de toda la informaci&oacute;n y los documentos recibidos de la otra parte en relaci&oacute;n con las operaciones contempladas en el presente y no los divulgar&aacute; a ning&uacute;n tercero sin consentimiento previo y por escrito de su contraparte.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Ambas Partes convienen que el presente Contrato es de car&aacute;cter privado y, por lo tanto, se abstendr&aacute;n de comunicar a un tercero su contenido o hacerlo p&uacute;blico, as&iacute; como tampoco podr&aacute;n divulgar, compartir o hacer un mal uso de los datos aportados por las Partes para celebrar el Contrato, no obstante, prevalecer&aacute;n todos los derechos y obligaciones de las Partes, y por tanto podr&aacute;n ejercitarse todas las acciones legales que se deriven del mismo conforme a la legislaci&oacute;n aplicable.</p>
<p>&nbsp;</p>
<p><strong>VIG&Eacute;SIMA. EXTINCI&Oacute;N DE DOMINIO. </strong></p>
<p style="text-align: justify;">En el evento de que el Gobierno Federal y/o de la Ciudad de M&eacute;xico, en ejercicio de la acci&oacute;n de extinci&oacute;n de dominio, afecte el INMUEBLE por causas imputables al ARRENDATARIO, el ARRENDATARIO deber&aacute; cubrirle al ARRENDADOR el valor del mismo, pues expresamente se conviene en este Contrato que el INMUEBLE ser&aacute; destinado al Uso Autorizado se&ntilde;alado en este Contrato. Lo anterior se conviene de conformidad con lo dispuesto en la Ley Nacional de Extinci&oacute;n de Dominio.</p>
<p>&nbsp;</p>
<p><strong>VIG&Eacute;SIMA PRIMERA. DERECHO DEL PREFERENCIA. </strong></p>
<p style="text-align: justify;">En caso de que el ARRENDADOR decida vender el INMUEBLE objeto del presente Contrato, el ARRENDADOR se obliga con el ARRENDATARIO a garantizar el derecho de preferencia para la compra del bien inmueble seg&uacute;n lo dispuesto en el art&iacute;culo 2448 J del C&oacute;digo Civil para el Distrito Federal.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">En caso de que el ARRENDATARIO no ejerza su derecho de preferencia sobre la compra del INMUEBLE, el ARRENDADOR se obliga a garantizar el cumplimiento cabal de los t&eacute;rminos y condiciones establecidos en el presente instrumento por parte del comprador correspondiente por el plazo de vigencia que se establece en este Contrato.</p>
<p><strong>&nbsp;</strong></p>
<p><strong>VIG&Eacute;SIMA SEGUNDA. NOTIFICACIONES. </strong></p>
<p style="text-align: justify;">Para todos los avisos y notificaciones relacionados con el presente Contrato, las Partes acuerdan que deber&aacute;n de realizarse por escrito en los domicilios indicados en las declaraciones del presente Contrato.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Cualquiera de las Partes podr&aacute; modificar su domicilio, siempre que el mismo se encuentre dentro de la Ciudad de M&eacute;xico. Para el caso de que alguna de las Partes modifique su domicilio sin dar previo aviso por escrito a la otra parte, se entender&aacute; que los avisos y notificaciones realizados en el domicilio se&ntilde;alado en la presente cl&aacute;usula son v&aacute;lidos y surtir&aacute;n todos sus efectos.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Para todo lo relacionado con los avisos y notificaciones que las Partes deban de darse entre s&iacute; respecto del presente Contrato, los mismos forzosamente deber&aacute;n de ser efectuados por escrito en los domicilios se&ntilde;alados en la presente cl&aacute;usula, o en aquellos que las Partes se&ntilde;alen con posterioridad, prevaleciendo el sistema de recepci&oacute;n de dichos avisos y notificaciones, por lo que en todo caso se entender&aacute; que surtir&aacute;n sus efectos a partir de que son recibidos por el destinatario de los mismos y no con anterioridad.</p>
<p>&nbsp;</p>
<p><strong>VIG&Eacute;SIMA TERCERA. MODIFICACIONES.</strong>&nbsp;</p>
<p style="text-align: justify;">Las Partes est&aacute;n de acuerdo en que se efect&uacute;en modificaciones al presente Contrato las cuales deber&aacute;n realizarse por escrito firmadas por ambas partes y formar&aacute;n parte integrante del mismo.</p>
<p style="text-align: justify;">&nbsp;</p>
<p><strong>VIG&Eacute;SIMA CUARTA. SUPLETORIEDAD. </strong></p>
<p>Para todo lo no previsto en el presente Contrato le ser&aacute;n aplicables supletoriamente las disposiciones del C&oacute;digo Civil para el Distrito Federal.</p>
<p>&nbsp;</p>
<p><strong>VIG&Eacute;SIMA QUINTA. JURISDICCI&Oacute;N.</strong></p>
<p style="text-align: justify;">Las Partes expresamente convienen en que, para el caso de interpretaci&oacute;n y/o ejecuci&oacute;n del presente Contrato se sometan a la jurisdicci&oacute;n de las Leyes y Tribunales de la Ciudad de M&eacute;xico, renunciando al efecto a cualquier fuero que pudiera corresponderles en raz&oacute;n de su domicilio o ubicaci&oacute;n de sus bienes, presente o futuro.</p>
<p style="text-align: justify;">&nbsp;</p>
<p>&nbsp;</p>
<p>LE&Iacute;DO QUE FUE EL PRESENTE INSTRUMENTO, CONSTANTE DE _______ FOJAS &Uacute;TILES Y ENTERADAS QUE FUERON LAS PARTES DE SU CONTENIDO, VALOR Y ALCANCE LEGAL, LO FIRMAN AL MARGEN EN CADA UNA DE SUS HOJAS, CON EXCEPCION DE LA &Uacute;LTIMA, QUE SE FIRMA AL CALCE POR TRIPLICADO, EN <strong> CDMX </strong>EL <strong>'.date("d/m/Y").'</strong>.</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table style="width: 1002px;">
<tbody>
<tr>
<td style="width: 540px;">
<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &ldquo;EL ARRENDADOR&rdquo;</strong></p>
<p><strong>&nbsp;</strong></p>
<p><strong>&nbsp;</strong></p>
<p><strong>&nbsp;</strong></p>
<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ________________</strong></p>
<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Por su propio derecho.</strong></p>
</td>
<td style="width: 446px;">
<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &ldquo;EL ARRENDATARIO&rdquo;</strong></p>
<p><strong>&nbsp;</strong></p>
<p><strong>&nbsp;</strong></p>
<p><strong>&nbsp;</strong></p>
<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ________________</strong></p>
<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Por su propio derecho.</strong></p>
<p><strong>&nbsp;</strong></p>
</td>
</tr>
</tbody>
</table>
<p><strong>&nbsp;</strong></p>
<table style="width: 1001px;">
<tbody>
<tr>
<td style="width: 991px;">
<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &ldquo;EL FIADOR&rdquo;</strong></p>
<p><strong>&nbsp;</strong></p>
<p><strong>&nbsp;</strong></p>
<p><strong>&nbsp;</strong></p>
<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _________________</strong></p>
<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Por su propio derecho.</strong></p>
<p><strong>&nbsp;</strong></p>
</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>'); } else if($tipoContrato=="AH") { $mpdf->WriteHTML('</p>
<p><strong>IV&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; HABITACIONAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;IV</strong></p>
<p><strong>&nbsp;</strong></p>
<p><strong>&nbsp;</strong></p>
<p>CONTRATO DE ARRENDAMIENTO RESPECTO DE:  RENTA DE INMUEBLE  </p>
<p>QUE CELEBRAN COMO PARTE ARRENDADORA: <strong>'.$nomProp.' '.$apeProp.'</strong></p>
    <p>Y COMO PARTE ARRENDATARIA:<strong> '.$nomInq.' '.$apeInq.'</strong> </p>
    <p>Y COMO PARTE FIADOR (S):<strong> '.$aval.'</strong></p>
<p>&nbsp;</p>
<p><u>&nbsp;</u></p>
<p><strong>QUIENES SE SUJETAN DE COMUN ACUERDO A LAS SIGUIENTES CLAUSULAS:</strong></p>
<p><strong>&nbsp;</strong></p>
<p style="text-align: justify;">PRIMERA.- El arrendataria pagar&aacute; al arrendador o a quien sus derechos represente la cantidad de '.$renta.' por el arrendamiento mensual de la localidad arriba mencionada y que deber&aacute; cubrir en Moneda Nacional&nbsp; mediante mensualidades adelantadas en el Domicilio del arrendador y en los t&eacute;rminos que lo previene el art&iacute;culo 2425 fracci&oacute;n I y 2427 del C&oacute;digo Civil, debi&eacute;ndose cubrir el importe del arrendamiento dentro de los cinco d&iacute;as naturales siguientes a la fecha en que deba cubrirse la renta mensual en forma adelantada.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">SEGUNDA. - Se se&ntilde;ala como domicilio de la parte arrendadora para los efectos de verificar el pago a que se refiere la Cl&aacute;usula anterior '.$domicilioArrendador.'</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">TERCERA. -Para todos los efectos de interpretaci&oacute;n que se desprendan del clausulado de este contrato, referente a las penas convencionales que se pacten por el importe de un mes de renta, se aclara que el monto de la misma, se exigir&aacute; de acuerdo a la renta que se est&aacute; causando al momento de haberse infringido lo pactado en la cl&aacute;usula correspondiente y de acuerdo a los aumentos anuales de renta, convenidos en forma expresa.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">CUARTA. - Convienen expresamente el arrendador, el arrendatario y el Fiador, que todo mes de arrendamiento lo es forzoso y que se pagara integro aun cuando &uacute;nicamente se ocupe la localidad un solo d&iacute;a.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">QUINTA. - Por falta de pago puntual de una sola renta, podr&aacute; el arrendador ejercitar acci&oacute;n de rescisi&oacute;n de contrato de arrendamiento. Y por falta de pago absoluto de uno o m&aacute;s meses de renta, se pacta como pena convencional,&nbsp; por tal supuesto el importe de un mes de renta.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">SEXTA. - Le es expresamente prohibido al arrendatario traspasar, ceder o subarrendar en todo o en parte la localidad arrendada, como lo previene el art&iacute;culo 2480 del C&oacute;digo Civil, y dicha conducta ser&aacute; causa de rescisi&oacute;n de este contrato de arrendamiento, pact&aacute;ndose como pena convencional por el incumplimiento de esta cl&aacute;usula un mes de renta.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">S&Eacute;PTIMA. El t&eacute;rmino del arrendamiento es de '.$meses.' meses. La parte arrendataria renuncia a la pr&oacute;rroga de un a&ntilde;o forzoso del arrendamiento, a que alude el art&iacute;culo 2448-C del C&oacute;digo Civil</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">OCTAVA. - Concluido el t&eacute;rmino forzoso del arrendamiento a que se refiere la cl&aacute;usula que antecede, la renta se incrementar&aacute; a partir del segundo a&ntilde;o del arrendamiento, en un diez por ciento, y seguir&aacute; aumentando en ese porcentaje el monto de la renta cada vez que se venza un a&ntilde;o, en tanto no se firme un nuevo contrato de arrendamiento.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">NOVENA. - Una vez concluido el t&eacute;rmino forzoso de este arrendamiento, el mismo tendr&aacute; el car&aacute;cter de voluntario para los contratantes, y solo podr&aacute; darse por terminado previo aviso que en forma indubitable haga el arrendador al arrendatario para que desocupe en un t&eacute;rmino de diez d&iacute;as renunci&aacute;ndose a los t&eacute;rminos a que alude el art&iacute;culo 2478 del C&oacute;digo Civil.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">DECIMA. - El arrendatario deber&aacute; de cubrir su renta dentro de los primeros cinco d&iacute;as de cada mes en el domicilio indicado en la cl&aacute;usula segunda de este contrato y para el caso de no hacerlo se pacta un inter&eacute;s mensual moratorio del diez por ciento, hasta la total soluci&oacute;n de la mensualidad rent&iacute;stica no cubierta.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">DECIMA PRIMERA. - Para los efectos del art&iacute;culo 2448 &ldquo;H&rdquo; del C&oacute;digo Civil, el arrendatario declara que vivir&aacute;n con &eacute;l las siguientes personas: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..... &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip; &nbsp;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">DECIMA SEGUNDA. - El arrendatario no podr&aacute; sin consentimiento expreso del arrendador y dado por escrito, variar la forma de la localidad arrendada, quedando en beneficio de la finca las mejoras que realice, as&iacute; como las instalaciones sanitarias, de calentadores, de calefacci&oacute;n, de luz y timbres, y de aquellas que puedan ser aprovechadas por el arrendador, renunciado el arrendatario a los art&iacute;culos 2423 y 2424 del C&oacute;digo Civil. El incumplimiento al contenido de esta Cl&aacute;usula ser&aacute; causa de rescisi&oacute;n de contrato de arrendamiento.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">DECIMA TERCERA. - El arrendatario no podr&aacute; hacer uso de la localidad arrendada m&aacute;s que para el de casa habitaci&oacute;n, y en caso de no hacerlo, el arrendador podr&aacute; demandar la rescisi&oacute;n del presente contrato de arrendamiento.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">DECIMA CUARTA. - La parte arrendataria se compromete a vivir en el inmueble arrendador, en forma personal&iacute;sima, conjuntamente con sus familiares y en caso de no habitar personalmente el inmueble arrendador, ello ser&aacute; causa de rescisi&oacute;n de este contrato.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">DECIMO QUINTA. - El arrendatario no podr&aacute; retener la renta en ning&uacute;n caso, ni bajo ning&uacute;n t&iacute;tulo judicial o extrajudicial, ni por falta de composturas, ni por reparaciones que el arrendatario hiciere, sino que la renta la pagara &iacute;ntegramente en la fecha y lugar estipulados en los t&eacute;rminos de los art&iacute;culo 2425, 2426 y 2427 del C&oacute;digo Civil, y renunciando a los beneficios que conceden los art&iacute;culos 2412, 2413, 2414, 2490 y 2491 del C&oacute;digo Civil.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">DECIMO SEXTA. - El arrendatario conviene en que la localidad arrendada, la recibe en buen estado, teniendo todos los servicios sanitarios en perfecto funcionamiento, aceptando lo ordenado por el art&iacute;culo 2444 del C&oacute;digo Civil, siendo de su exclusiva cuenta las reparaciones derivadas del uso normal del inmueble materia del arrendamiento.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">DECIMO S&Eacute;PTIMA.- Los servicios&nbsp; de porter&iacute;a, vigilancia, elevadores y puertas el&eacute;ctricas, que puedan existir constituyen cortes&iacute;a de la parte arrendadora, sin que tal servicio constituya porcentaje alguno sobre el monto de la renta pactada. Y por otro lado ser&aacute; causa de rescisi&oacute;n de contrato de arrendamiento, el hecho de que el arrendatario introduzca a la localidad arrendada perros, gatos, y cualquier tipo de animales.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">DECIMO OCTAVA. - Para seguridad y garant&iacute;a del cumplimiento de todo lo estipulado en el presente contrato, lo firman mancomunada y solidariamente con el arrendatario: '.$aval.', quienes declaran Bajo Protesta de Decir Verdad ser propietario del inmueble que se encuentran libre de grav&aacute;menes, y ubicada en '.$domicilioInmueble.' y se constituye en fiador y principal pagador de todas las obligaciones contenidas y contra&iacute;das por el arrendatario, y as&iacute; mismo dicho fiador declara que su domicilio particular es el ubicado en '.$domicilioAval.' haciendo las renuncias que el arrendatario tiene hechas y renunciando por su parte a los beneficios de orden y excusi&oacute;n contenidos en los art&iacute;culos 2812, 2813, 2814, 2815, 2818, 2820, 2823, 2824, 2826, as&iacute; como los art&iacute;culos 2488, 2844, 2845, 2846, 2847 y 2849 del C&oacute;digo civil, no cesando la responsabilidad del fiador sino hasta cuando el arrendador se d&eacute; por recibido de la localidad y de todo cuanto se le deba por virtud de este contrato, subsistiendo la obligaci&oacute;n del fiador hasta en tanto no se entregue f&iacute;sicamente la localidad en cuesti&oacute;n, y para el caso de que el arrendatario desaparezca, o se encuentre en imposibilidad f&iacute;sica ya sea por ausencia o por enfermedad el fiador podr&aacute; hacer entrega&nbsp; de la localidad respectiva a la parte arrendadora. Finalmente la parte fiadora se obliga a no gravar o a realizar acto de dominio alguno sobre el bien dado en garant&iacute;a, durante la vigencia de este contrato, as&iacute; como a informar a la parte arrendadora en un plazo m&aacute;ximo de tres d&iacute;as, cualquier afectaci&oacute;n que pudiera disminuir la garant&iacute;a otorgada como lo ser&iacute;a entre otros la constituci&oacute;n de un embargo. El incumplimiento a esta cl&aacute;usula genera una pena convencional de un mes de renta, sin perjuicio de la responsabilidad penal derivada, del delito de fraude de acreedores.</p>
<p style="text-align: justify;">DECIMO NOVENA.- El arrendatario ser&aacute; responsable respecto de los adeudos que resulten en el inmueble en cuesti&oacute;n por concepto de servicio de energ&iacute;a el&eacute;ctrica, aun cuando dicho servicio se solicite a nombre de persona diversa y por su parte el fiador se constituye en solidario responsable respecto del arrendatario, en relaci&oacute;n al monto de los adeudos que resulten por el uso de dicho servicio, aun cuando los mismos se encuentren a nombre de persona distinta al arrendatario, siempre que sean servicios que se hayan verificado durante la vigencia de este contrato.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">VIG&Eacute;SIMA.- El arrendatario ser&aacute; responsable respecto de los adeudos que resulten en el inmueble en cuesti&oacute;n por concepto de servicio telef&oacute;nico, aun cuando dicho servicio se solicite a nombre de persona diversa al arrendatario, y por su parte el fiador tambi&eacute;n se constituye en solidario responsable del arrendatario respecto de los adeudos que resulten por el uso de dicho servicio telef&oacute;nico, aun cuando los mismos se encuentren a nombre de persona diversa al arrendatario, siempre que sean servicios que se hayan verificado durante la vigencia de este contrato.&nbsp; As&iacute; mismo, cuando dentro de la vigencia del arrendamiento por causas imputadas al arrendatario se pierda la l&iacute;nea telef&oacute;nica que se encuentra&nbsp; a nombre de la parte arrendadora por falta de pago, ello ser&aacute; causa de rescisi&oacute;n del contrato de arrendamiento.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">VIG&Eacute;SIMA PRIMERA. - Toda vez que el presente contrato tiene una vigencia m&iacute;nima forzosa para los contratantes, para el caso de que el arrendatario abandone la localidad antes del t&eacute;rmino pactado como forzoso, el fiador se hace solidario responsable de las mensualidades de renta que resten a completar el primer a&ntilde;o forzoso del arrendamiento.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">VIG&Eacute;SIMA SEGUNDA.- El arrendatario entregar&aacute; a la firma del presente contrato el importe de:&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip; para garantizar los desperfectos del uso indebido del inmueble dado en arrendamiento, y cantidad que no se entregar&aacute;, en tanto no se entregue al arrendador la orden de desconexi&oacute;n expedida por la Comisi&oacute;n Federal de Electricidad, y cantidad que no debe ser entendida por parte del arrendatario ni del fiador, como mes o meses del arrendamiento y sirviendo el presente contrato como recibo de dicha cantidad.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">VIG&Eacute;SIMO TERCERA. - As&iacute; mismo el arrendatario se compromete a pagar todas las boletas de consumo de agua a partir del primer bimestre de vigencia del presente contrato de arrendamiento, y con la obligaci&oacute;n de entregar la correspondiente boleta de agua pagada a la parte arrendadora, y el incumplimiento a esta obligaci&oacute;n ser&aacute; causa de rescisi&oacute;n de contrato de arrendamiento, y por su parte, la parte fiadora se constituye en solidario y mancomunado responsable de tal obligaci&oacute;n.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">VIG&Eacute;SIMO CUARTA. - &ldquo;ACUERDO ARBITRAL&rdquo;. - Con fundamento en el art&iacute;culo 609 del C&oacute;digo de Procedimientos Civiles, las partes pactan que cualquier conflicto que surja en relaci&oacute;n a este Contrato, se someter&aacute;n a un procedimiento Arbitral, para ser resuelto por el Arbitro que se designa, y al cual se le encomienda la amigable composici&oacute;n y el fallo en conciencia, tal y como lo previene el art&iacute;culo 628 del C&oacute;digo de Procedimientos Civiles para la Ciudad de M&eacute;xico. Dicho procedimiento Arbitral se ajustar&aacute; y regular&aacute; por los siguientes art&iacute;culos:</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">1.- El Tribunal Arbitral operara de manera unitaria por lo que se integrar&aacute; de un &aacute;rbitro designado por las partes de com&uacute;n acuerdo y de un Secretario de Acuerdos que dar&aacute; fe de las actuaciones y a su vez ejercer&aacute; funciones de notificador, siendo facultad del propio Arbitro designar a dicho Secretario de Acuerdos de entre los que sean propuestos por las partes en el presente acuerdo arbitral;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">2.- Los contratantes designan como Arbitro al LIC. RICARDO TORTOLERO PE&Ntilde;A ALFARO, y como Arbitro sustituto&nbsp; por imposibilidad f&iacute;sica o ausencia total en que pudiera incurrir el Arbitro ya nombrado, al Licenciado HORACIO RICARDO IV TORTOLERO Y SERRANO, quien proceder&aacute; a su vez a nombrar Secretario de Acuerdos entre los propuestos o a su libre elecci&oacute;n,&nbsp; y se proponen como Secretarios de Acuerdos a cualquiera de las siguientes personas JOSE RICARDO II TORTOLERO Y SERRANO, MAURICIO RICARDO III TORTOLERO Y SERRANO, HORACIO RICARDO IV TORTOLERO Y SERRANO y ENRIQUETA VERONICA GARRIDO BORRAYO, siendo facultad del &Aacute;rbitro elegir a cualquiera de los propuestos;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">3.- El domicilio del Tribunal Arbitral se ubicar&aacute; en las calles de Reynosa # 59, Colonia Condesa, Alcald&iacute;a Cuauht&eacute;moc, C.P. 06140, en esta Ciudad de M&eacute;xico;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">4.- En el Juicio arbitral no habr&aacute; d&iacute;as ni horas inh&aacute;biles, &uacute;nicamente se se&ntilde;alar&aacute; horario espec&iacute;fico para presentar promociones por las partes;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">5.- Corresponde al &Aacute;rbitro sujetarse a este procedimiento pactado por las partes, de acuerdo al art&iacute;culo 619 segundo p&aacute;rrafo del C&oacute;digo Procesal Civil de la Ciudad de M&eacute;xico, y aplicar supletoriamente las disposiciones&nbsp; del derecho com&uacute;n, dentro del desarrollo del procedimiento pactado, mantener el equilibrio procesal entre las partes, tratar de avenir a las partes a un convenio amistoso, recibir la demanda,&nbsp; promociones, documentos y en su caso aceptar el cargo y decretar la radicaci&oacute;n&nbsp; del Juicio Arbitral;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">6.- Funciones y Obligaciones del Secretario: A) Dar Fe de las actuaciones&nbsp; del procedimiento Arbitral, B) Practicar el emplazamiento al demandado y notificar a las partes los prove&iacute;dos y Laudos con las formalidades establecidas en este procedimiento Arbitral, C) Auxiliar al &Aacute;rbitro en todas sus funciones, D) Expedir copias certificadas de las constancias originales que las partes hayan exhibido en el procedimiento, para entregar a los interesados sus originales, quedando las copias certificadas exclusivamente dentro del expediente y procedimiento arbitral para constancia; E) Deber&aacute; recibir las promociones que presenten las partes y dar cuenta de inmediato al C. Arbitro para su acuerdo, independientemente de que el C. Arbitro podr&aacute; tambi&eacute;n recibir las diversas promociones que presenten las partes,</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">7.- Remuneraci&oacute;n. Por la totalidad del Juicio: Al &Aacute;rbitro le corresponde el equivalente a ciento cincuenta d&iacute;as de salario m&iacute;nimo vigente en la Ciudad de M&eacute;xico y al Secretario de Acuerdos cien d&iacute;as de salario m&iacute;nimo vigente en la Ciudad de M&eacute;xico, honorarios que ser&aacute;n pagados por las partes contendientes por partes iguales, a excepci&oacute;n de que en el Laudo que en su oportunidad se dicte, se condene al pago de dichos honorarios a uno de los litigantes;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">8.- Procedimiento. - El procedimiento se iniciar&aacute; a instancia de cualquiera de las partes, con el escrito de demanda, la que deber&aacute; de reunir los requisitos que marca el C&oacute;digo de Procedimientos Civiles para la Ciudad de M&eacute;xico, y en una sola demanda se acumularan todas las cuestiones que surjan entre las partes.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">9.- Al tener radicada la demanda, el Arbitro elegir&aacute; a cualquiera de los Secretarios propuestos y a continuaci&oacute;n proceder&aacute; a acordar respecto de la admisi&oacute;n de la demanda, se se&ntilde;alar&aacute; lugar del asiento del Tribunal Arbitral y se se&ntilde;alar&aacute; d&iacute;a y hora para la audiencia del Juicio. El emplazamiento lo efectuar&aacute; el Secretario de Acuerdos, como tambi&eacute;n lo podr&aacute; llevar a cabo el C. Arbitro designado, aun cuando el domicilio del demandado este fuera de la Ciudad de M&eacute;xico y se llevar&aacute; a cabo, para el caso de que se demande al arrendatario en el lugar del bien arrendado, y el emplazamiento al fiador se llevar&aacute; a cabo en el domicilio se&ntilde;alado en el contrato de arrendamiento, y para el caso de que el arrendatario&nbsp; sea quien intente la acci&oacute;n se proceder&aacute;&nbsp; a emplazar al arrendador en el domicilio se&ntilde;alado para llevar acabo los pagos de la renta. Las diligencias de emplazamiento se deber&aacute;n entender con el interesado y si no se hallar&eacute; con cualquier familiar, empleado, sirviente o vecino que vivan en el mismo inmueble, y en caso de no haber inquilinos dentro del mismo inmueble, con el vecino m&aacute;s pr&oacute;ximo. El Secretario correr&aacute; traslado con las copias simples exhibidas por el Actor, debiendo cotejarlas y con las copia del auto admisorio de la demanda y aceptaci&oacute;n del cargo de Arbitro y Secretario y siendo &uacute;nicamente la diligencia de emplazamiento la &uacute;nica diligencia que se llevar&aacute; a cabo en el domicilio del demandado, pues las posteriores notificaciones de prove&iacute;dos, Acuerdos y Laudos Definitivos, surtir&aacute;n efectos de notificaci&oacute;n Veinticuatro Horas m&aacute;s tarde de haberse dictado. Los demandados deben ser emplazados por lo menos cinco d&iacute;as naturales antes de la celebraci&oacute;n de la audiencia que se se&ntilde;ale en el auto admisorio de la demanda y los demandados por su parte, podr&aacute;n contestar a m&aacute;s tardar la demanda instaurada en su contra el d&iacute;a de la celebraci&oacute;n de la Audiencia de este procedimiento arbitral, la cual deber&aacute; contestarse solo por escrito.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">10.- Las partes est&aacute;n obligadas a acudir al domicilio designado como asiento o Tribunal del Arbitraje para notificarse de prove&iacute;dos, Acuerdos y Laudos Definitivos. El C. Arbitro y el C. Secretario de Acuerdos podr&aacute;n informar por tel&eacute;fono a las partes el Estado de las actuaciones, sin perjuicio de que las partes acudan al lugar se&ntilde;alado como Tribunal del Arbitraje a imponerse de los autos y corroborar la informaci&oacute;n telef&oacute;nica recibida.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">11.- La parte demandada podr&aacute; ejercitar Acci&oacute;n Reconvencional al contestar su demanda y dicha reconvenci&oacute;n deber&aacute; satisfacer tambi&eacute;n los requisitos de la demanda principal, y la misma deber&aacute; ser contestada por parte de la Actora en la Audiencia del Juicio.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">12.- Ninguna Excepci&oacute;n, ni Incidente suspenden el tr&aacute;mite del Juicio, procedi&eacute;ndose a su resoluci&oacute;n al momento de dictarse Laudo definitivo, con las Excepciones opuestas, se dar&aacute; vista a la parte actora para que manifieste lo que a su derecho m&aacute;s convenga y as&iacute; mismo en caso de reconvenci&oacute;n con las excepciones opuestas se dar&aacute; vista a la actora, siendo optativo para las partes desahogar dichas vistas provenientes de las excepciones opuestas. Los Incidentes de Nulidad de Actuaciones por falta o defecto de citaci&oacute;n o notificaci&oacute;n, se desechar&aacute;n de plano.&nbsp;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">13.- Pruebas. - Todas las que se ofrezcan deber&aacute;n ser desahogadas en una sola audiencia por las partes oferentes y el Arbitro desechar&aacute; aquellas que no re&uacute;nan estos requisitos, trat&aacute;ndose de informes, los mismos deber&aacute;n ser recabados por las partes interesadas, pues la preparaci&oacute;n de las pruebas quedar&aacute; a cargo de las partes, por lo que deber&aacute;n exhibir sus documentos y llevar a sus testigos. -Audiencia.- En la fecha se&ntilde;alada para la celebraci&oacute;n de la Audiencia de este procedimiento arbitral, las partes comparecientes deber&aacute;n identificarse con credencial expedida por Autoridad Competente y&nbsp; podr&aacute;n estar asistidas por Abogado Patrono o Persona de su Confianza. La Audiencia deber&aacute; iniciarse con una etapa conciliatoria en la que el Arbitro trate de avenir a las partes y de no conciliarse las mismas, se proceder&aacute; a proveer sobre la contestaci&oacute;n de demanda, para luego iniciarse el periodo de ofrecimiento de pruebas, admisi&oacute;n y desahogo de las mismas en forma posterior. Las pruebas deber&aacute;n ofrecerse exclusivamente a partir de que se abra el periodo de ofrecimiento de Pruebas, a excepci&oacute;n de la Confesional y prueba pericial que deber&aacute; sujetarse a los t&eacute;rminos que m&aacute;s adelante se se&ntilde;alaran para su ofrecimiento y desahogo;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">14.- Ser&aacute; facultad del &Aacute;rbitro desechar las defensas que no se relacionen con la Litis o resulten innecesarias, y vigilar el desarrollo expedito de la Audiencia, las partes o sus Representantes deber&aacute;n comparecer a la Audiencia del Juicio para el desahogo de la Prueba Confesional, respecto de las posiciones presentadas antes de la Audiencia y calificadas de legales, sin necesidad de notificaci&oacute;n o requerimiento alguno, la absoluci&oacute;n de posiciones podr&aacute; hacerse por el Representante Legal debidamente autorizado y en tal caso quedar&aacute; confeso de aquellas posiciones que diga ignorar, dicha prueba debe de ofrecerse por lo menos cuarenta y ocho horas antes del d&iacute;a y hora de la celebraci&oacute;n de la Audiencia y el Arbitro proceder&aacute; de inmediato a calificar las posiciones de dicha prueba, para que se desahoguen llegado el momento procesal oportuno. Los testigos ser&aacute;n interrogados por ambas partes, las partes&nbsp; que ofrezcan&nbsp; la prueba testimonial, quedar&aacute; a cargo de ellos presentar a sus testigos. El Arbitro rechazar&aacute; las preguntas que no se ajusten a la Litis. Pericial. - El &aacute;rbitro designar&aacute; al perito &uacute;nico e irrenunciable y las partes podr&aacute;n pedir al perito las aclaraciones que estimen necesarias. Esta prueba debe anunciarse con cuarenta y ocho horas de anticipaci&oacute;n a la celebraci&oacute;n de la Audiencia y el oferente deber&aacute; precisar los puntos sobre los que deba versar, el oferente de cualquier prueba pericial deber&aacute; exhibir al momento de anunciar la misma, el importe en efectivo de la cantidad de ciento cincuenta d&iacute;as de salario m&iacute;nimo, para garantizar los honorarios del perito, sin este requisito no se tendr&aacute; por ofrecida tal probanza. Documental.- La prueba documental deber&aacute; exhibirse al momento de su ofrecimiento y en caso de impugnarse por la otra parte la misma, se observar&aacute;n las reglas siguientes: si el documento proviene de un tercero, el que presente el documento al Juicio estar&aacute; obligado a ofrecer las pruebas con las que respalde su valor probatorio, si es la firma de una de las partes la que motiva la impugnaci&oacute;n, dicha parte ofrecer&aacute; la prueba pericial grafol&oacute;gica, grafosc&oacute;pica, o documentoscopica a efecto de esclarecer el origen de las firmas. En este &uacute;nico caso se suspender&aacute; la Audiencia por setenta y dos horas a efecto de que el &aacute;rbitro nombre perito graf&oacute;logo que se encargue de rendir el Dictamen, en esta materia o en la Rama cient&iacute;fica que se ofrezca, las partes podr&aacute;n ofrecer las pruebas complementarias pertinentes, siempre y cu&aacute;ndo puedan desahogarse en la continuaci&oacute;n de la Audiencia. Valoraci&oacute;n de las Pruebas.- El Arbitro gozar&aacute; de las m&aacute;s amplias y prudentes facultades para valorar las pruebas en los t&eacute;rminos de amigable componedor y que en conciencia le otorga el art&iacute;culo 628 del C&oacute;digo de Procedimientos Civiles para la Ciudad de M&eacute;xico. Alegatos.- Desahogadas la pruebas las partes formular&aacute;n sus Alegatos verbales. Laudo. - El Laudo deber&aacute; dictarse a m&aacute;s tardar en los diez d&iacute;as naturales posteriores a la Audiencia con todas las facultades que le conceden los art&iacute;culos 619 y 628 del C&oacute;digo de Procedimientos Civiles para la Ciudad de M&eacute;xico, encomend&aacute;ndosele el fallo en conciencia;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">15.- Los prove&iacute;dos, Acuerdos y Laudos que se pronuncien en el Juicio, ser&aacute;n definitivos y no admiten ning&uacute;n Recurso, en los t&eacute;rminos previstos por el art&iacute;culo 635 del C&oacute;digo Procesal Civil, pues a mayor abundamiento las partes han encomendado al &Aacute;rbitro para el caso de no existir una amigable composici&oacute;n (CONVENIO), el fallo en conciencia al pronunciarse el Laudo definitivo y al resolverse en conciencia no puede existir recurso legal alguno;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">16.- El Arbitro y el Secretario durar&aacute;n en su funci&oacute;n todo el tiempo que sea necesario para la tramitaci&oacute;n del Juicio Arbitral;</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">17.- Las partes convienen que para el caso de ejecuci&oacute;n judicial del Laudo que llegar&eacute; a pronunciarse, el mismo se tramitar&aacute; ante el C. Juez competente de Primer Instancia en Materia Civil de la Ciudad de M&eacute;xico, que se encuentra en turno, y en este caso los contratantes renuncian al fuero de sus domicilios presentes o futuros y se someten al presente acuerdo arbitral con sede en esta Ciudad de M&eacute;xico, aun cuando el inmueble motivo de este arrendamiento pudiera encontrarse en cualquier parte de la Rep&uacute;blica Mexicana, y para el caso de que el inmueble dado en arrendamiento se encuentre fuera de la jurisdicci&oacute;n de la Ciudad de M&eacute;xico, se proceder&aacute; a su ejecuci&oacute;n mediante el exhorto correspondiente que se solicite a las Autoridades Civiles de Primera Instancia en turno de esta Ciudad de M&eacute;xico.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">VIG&Eacute;SIMO QUINTA. - Este Contrato se extiende por triplicado y los contratantes declaran estar debidamente enterados de todas y cada una de las cl&aacute;usulas contenidas en este contrato y que conocen todos y cada uno de los art&iacute;culos que se citan</p>
<p style="text-align: justify;">&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Ciudad de M&eacute;xico&nbsp;a  '.date("d/m/Y").' .</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="padding-left: 100px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ARRENDADOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;ARRENDATARIO</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="padding-left: 100px;">_______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _______________________________&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p><u>&nbsp;</u></p>
<p><u>&nbsp;</u></p>
<p><u>&nbsp;</u></p>
<p style="padding-left: 100px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FIADOR</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="padding-left: 140px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; __________________________</p>');
}
else if ($tipoContrato =="AC")
{
    $mpdf->WriteHTML('<p style="text-align: center;"><strong>IV &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; COMERCIAL &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;IV</strong></p>
    <p><strong>&nbsp;</strong></p>
    <p>CONTRATO DE ARRENDAMIENTO RESPECTO DEL: RENTA DE INMUEBLE </p>
    <p>QUE CELEBRAN COMO PARTE ARRENDADORA: <strong>'.$nomProp.' '.$apeProp.'</strong></p>
    <p>Y COMO PARTE ARRENDATARIA:<strong> '.$nomInq.' '.$apeInq.'</strong> </p>
    <p>Y COMO PARTE FIADOR (S):<strong> '.$aval.'</strong></p>
    <p>&nbsp;</p>
    <p><strong>QUIENES SE SUJETAN DE COMUN ACUERDO A LAS SIGUIENTES CLAUSULAS:</strong></p>
    <p><strong>&nbsp;</strong></p>
    <p style="text-align: justify;">PRIMERA.- El arrendatario pagar&aacute; al arrendador o a quien sus derechos represente la cantidad de: '.$renta.' por el arrendamiento mensual de la localidad arriba mencionada y que deber&aacute; cubrir en Moneda Nacional mediante mensualidades adelantadas en el Despacho o Domicilio del arrendador y en los t&eacute;rminos que lo previene el art&iacute;culo 2425 fracci&oacute;n I y 2427 del C&oacute;digo Civil para la Ciudad de M&eacute;xico, debi&eacute;ndose cubrir el importe del arrendamiento dentro de los cinco d&iacute;as naturales siguientes a la fecha en que deba cubrirse la renta mensual en forma adelantada.</p>
    <p style="text-align: justify;">SEGUNDA. - Se se&ntilde;ala como domicilio de la parte arrendadora para los efectos de verificar el pago a que se refiere la Cl&aacute;usula anterior: '.$domicilioArrendador.'</p>
    <p style="text-align: justify;">TERCERA. -Para todos los efectos de interpretaci&oacute;n que se desprendan del clausulado de este contrato, referente a las penas convencionales que se pacten por el importe de un mes de renta, se aclara que el monto de la misma, se exigir&aacute; de acuerdo a la renta que se est&aacute; causando al momento de haberse infringido lo pactado en la cl&aacute;usula correspondiente y de acuerdo a los aumentos anuales de renta.</p>
    <p style="text-align: justify;">CUARTA.- Convienen expresamente el arrendador, el arrendatario y el Fiador, que todo mes de arrendamiento lo es forzoso y que se pagara integro aun cuando &uacute;nicamente se ocupe la localidad un solo d&iacute;a.</p>
    <p style="text-align: justify;">QUINTA.- Por falta de pago puntual de una sola renta, podr&aacute; el arrendador ejercitar acci&oacute;n de rescisi&oacute;n de contrato de arrendamiento. Y por falta de pago absoluto de uno o m&aacute;s meses de renta, se pacta como pena convencional, el importe de un mes de renta.</p>
    <p style="text-align: justify;">SEXTA.- Le es expresamente prohibido al arrendatario traspasar, ceder o subarrendar en todo o en parte la localidad arrendada, como lo previene el art&iacute;culo 2480 del C&oacute;digo Civil para la Ciudad de M&eacute;xico, y dicha conducta ser&aacute; causa de rescisi&oacute;n de este contrato de arrendamiento, pact&aacute;ndose como pena convencional por el incumplimiento de esta cl&aacute;usula un mes de renta.</p>
    <p>S&Eacute;PTIMA. <strong>El t&eacute;rmino del arrendamiento ser&aacute; de</strong> '.$meses.' meses <strong>forzoso para ambas partes</strong>, a partir de la firma de este contrato.</p>
    <p style="text-align: justify;">OCTAVA.- Concluido el termino forzoso del arrendamiento precisado en la cl&aacute;usula que antecede, la renta se incrementara a partir del primer mes del segundo a&ntilde;o de arrendamiento en un 10%, y seguir&aacute; aumentando en esa proporci&oacute;n cada vez que se venza un a&ntilde;o, en tanto no se firme un nuevo contrato de arrendamiento, y renunciando la parte arrendataria a la pr&oacute;rroga a que aluden los art&iacute;culos 2484,2485, 2486 del C&oacute;digo Civil.</p>
    <p style="text-align: justify;">NOVENA.- Una vez concluido el t&eacute;rmino forzoso de este arrendamiento, el mismo tendr&aacute; el car&aacute;cter de voluntario para los contratantes, y solo podr&aacute; darse por terminado previo aviso que en forma indubitable haga el arrendador al arrendatario para que desocupe en un t&eacute;rmino de diez d&iacute;as renunci&aacute;ndose a los t&eacute;rminos a que alude el art&iacute;culo 2478 del C&oacute;digo Civil.</p>
    <p style="text-align: justify;">DECIMA.- El arrendatario deber&aacute; de cubrir su renta dentro de los primeros cinco d&iacute;as de cada mes en el domicilio indicado en la cl&aacute;usula segunda de este contrato y para el caso de no hacerlo se pacta un inter&eacute;s mensual moratorio del diez por ciento, hasta la total soluci&oacute;n de la mensualidad rent&iacute;stica no cubierta.</p>
    <p style="text-align: justify;">DECIMA PRIMERA.- El arrendatario no podr&aacute; hacer uso de la localidad arrendada m&aacute;s que para el de: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.</p>
    <p style="text-align: justify;">DECIMA SEGUNDA.- El arrendatario no podr&aacute; sin consentimiento expreso del arrendador y dado por escrito, variar la forma de la localidad arrendada, quedando en beneficio de la finca las mejoras que realice, as&iacute; como las instalaciones sanitarias, de calentadores, de calefacci&oacute;n, de luz y timbres, y de aquellas que puedan ser aprovechadas por el arrendador, renunciado el arrendatario a los art&iacute;culos 2423 y 2424 del C&oacute;digo Civil. El incumplimiento al contenido de esta Cl&aacute;usula ser&aacute; causa de rescisi&oacute;n de contrato de arrendamiento.</p>
    <p style="text-align: justify;">DECIMA TERCERA.- El arrendador y el arrendatario pactan con fundamento en el art&iacute;culo 2408 del C&oacute;digo Civil, que ser&aacute; causa de rescisi&oacute;n de contrato de arrendamiento la muerte del arrendador o del arrendatario.</p>
    <p style="text-align: justify;">DECIMA CUARTA.- El arrendatario no podr&aacute; retener la renta en ning&uacute;n caso, ni bajo ning&uacute;n t&iacute;tulo judicial o extrajudicial, ni por falta de composturas, ni por reparaciones que el arrendatario hiciere, sino que la renta la pagara &iacute;ntegramente en la fecha y lugar estipulados en los t&eacute;rminos de los art&iacute;culos 2425, 2426 y 2427 del C&oacute;digo Civil, y renunciando a los beneficios que conceden los art&iacute;culos 2412, 2413, 2414, 2490 y 2491 del C&oacute;digo Civil.</p>
    <p style="text-align: justify;">DECIMO QUINTA.- El arrendatario conviene en que la localidad arrendada, la recibe en buen estado, teniendo todos los servicios sanitarios en perfecto funcionamiento, aceptando lo ordenado por el art&iacute;culo 2444 del C&oacute;digo Civil, siendo de su exclusiva cuenta las reparaciones de dichas instalaciones que sean necesarias.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">DECIMO SEXTA.- La parte arrendataria se obliga en un t&eacute;rmino de&nbsp; treinta&nbsp; d&iacute;as a partir de la firma del presente contrato a contratar un seguro de protecci&oacute;n civil para garantizar los da&ntilde;os materiales de incendio o negligencia en general, que pueda sufrir la localidad arrendada por causas imputables a la parte arrendataria y de no cumplir con la presente obligaci&oacute;n en el t&eacute;rmino se&ntilde;alado ello ser&aacute; causa de rescisi&oacute;n del presente contrato de arrendamiento.</p>
    <p style="text-align: justify;">DECIMO S&Eacute;PTIMA.- Los servicios&nbsp; de porter&iacute;a, vigilancia, elevadores y puerta el&eacute;ctrica, constituyen cortes&iacute;a de la parte arrendadora, sin que tal servicio constituya porcentaje alguno sobre el monto de la renta pactada. Y por otro lado ser&aacute; causa de rescisi&oacute;n de contrato de arrendamiento, el hecho de que el arrendatario introduzca a la localidad arrendada perros, gatos, y cualquier tipo de animales.</p>
    <p style="text-align: justify;">DECIMO OCTAVA. - Para seguridad y garant&iacute;as del cumplimiento de todo lo estipulado en el presente contrato, lo firman mancomunada y solidariamente con el arrendatario: '.$aval.'.</p>
    <p style="text-align: justify;">y quien declara Bajo Protesta de Decir Verdad ser propietario del inmueble que se encuentra libre de grav&aacute;menes, y ubicado en: '.$domicilioInmueble.'</p>
    <p style="text-align: justify;">y se constituye en fiador y principal pagador de todas y cada una de las obligaciones contenidas y contra&iacute;das por el arrendatario, y as&iacute; mismo dichos fiadores declaran que su domicilio particular es el ubicado en: '.$domicilioAval.'</p>
    <p style="text-align: justify;">haciendo las renuncias que el arrendatario tiene hechas y renunciando por su parte a los beneficios de orden y excusi&oacute;n contenidos en los art&iacute;culos 2812, 2813, 2814, 2815, 2818, 2820, 2823, 2824, 2826, as&iacute; como los art&iacute;culos 2488, 2844, 2845, 2846, 2847 y 2849 del C&oacute;digo civil, no cesando la responsabilidad del fiador sino hasta cuando el arrendador se d&eacute; por recibido de la localidad y de todo cuanto se le deba por virtud de este contrato, subsistiendo la obligaci&oacute;n del fiador hasta en tanto no se entregue f&iacute;sicamente la localidad en cuesti&oacute;n, y subsistiendo para el fiador los aumentos de renta pactados en la Cl&aacute;usula octava de este contrato de arrendamiento, y para el caso de que el arrendatario desaparezca, el fiador podr&aacute; hacer entrega&nbsp; de la localidad respectiva a la parte arrendadora.</p>
    <p style="text-align: justify;">DECIMO NOVENA.- El arrendatario ser&aacute; responsable respecto de los adeudos que resulten en el inmueble en cuesti&oacute;n por concepto de servicio de energ&iacute;a el&eacute;ctrica, aun cuando dicho servicio se solicite a nombre de persona diversa y por su parte el fiador se constituye en solidario responsable respecto del arrendatario, en relaci&oacute;n al monto de los adeudos que resulten por el uso de dicho servicio, aun cuando los mismos se encuentren a nombre de persona distinta al arrendatario, siempre que sean servicios que se hayan verificado durante la vigencia de este contrato.</p>
    <p style="text-align: justify;">VIG&Eacute;SIMA.- El arrendatario ser&aacute; responsable respecto de los adeudos que resulten en el inmueble en cuesti&oacute;n por concepto de servicio telef&oacute;nico, aun cuando dicho servicio se solicite a nombre de persona diversa al arrendatario, y por su parte el fiador tambi&eacute;n se constituye en solidario responsable del arrendatario respecto de los adeudos que resulten por el uso de dicho servicio telef&oacute;nico, aun cuando los mismos se encuentren a nombre de persona diversa al arrendatario, siempre que sean servicios que se hayan verificado durante la vigencia de este contrato.&nbsp; As&iacute; mismo, cuando dentro de la vigencia del arrendamiento por causas imputadas al arrendatario se pierda la l&iacute;nea telef&oacute;nica que se encuentra&nbsp; a nombre de la parte arrendadora por falta de pago, ello ser&aacute; causa de rescisi&oacute;n del contrato de arrendamiento.</p>
    <p style="text-align: justify;">VIG&Eacute;SIMA PRIMERA.- Toda vez que el presente contrato tiene una vigencia m&iacute;nima forzosa para los contratantes, para el caso de que el arrendatario abandone la localidad antes del t&eacute;rmino pactado como forzoso, el fiador se hace solidario responsable de las mensualidades de renta que resten a completar el primer a&ntilde;o forzoso del arrendamiento. As&iacute; mismo en caso de que la parte arrendataria se desaparezca por cualquier causa inusitada el Fiador tiene facultades para hacer entrega de la Localidad arrendada a la parte arrendadora.</p>
    <p style="text-align: justify;">VIG&Eacute;SIMA SEGUNDA.- El arrendatario entregar&aacute; a la firma del presente contrato el importe de: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.</p>
    <p style="text-align: justify;">para garantizar los desperfectos del uso indebido del inmueble dado en arrendamiento, y cantidad que no se entregar&aacute;, en tanto no se entregue al arrendador la orden de desconexi&oacute;n expedida por la Comisi&oacute;n Federal de Electricidad, y acredite no tener adeudos por consumo de agua y cantidad que no debe ser entendida por parte del arrendatario ni del fiador, como mes o meses del arrendamiento y sirviendo el presente contrato como recibo de dicha cantidad.</p>
    <p style="text-align: justify;">VIG&Eacute;SIMA TERCERA.- Queda prohibido al arrendatario introducir al inmueble dado en arrendamiento, sustancias o materiales peligrosos que puedan ocasionar explosi&oacute;n o incendio,&nbsp; y&nbsp; la violaci&oacute;n a la presente cl&aacute;usula ser&aacute; causa de rescisi&oacute;n del presente contrato de arrendamiento.</p>
    <p style="text-align: justify;">VIG&Eacute;SIMO CUARTA.-&ldquo;ACUERDO ARBITRAL&rdquo;.- Con fundamento en el art&iacute;culo 609 del C&oacute;digo de Procedimientos Civiles, las partes pactan que cualquier conflicto que surja en relaci&oacute;n a este Contrato, se someter&aacute;n a un procedimiento Arbitral, para ser resuelto por el Arbitro que se designa, y al cual se le encomienda la amigable composici&oacute;n y el fallo en conciencia, tal y como lo previene el&nbsp; art&iacute;culo 628 del C&oacute;digo de Procedimientos Civiles para la Ciudad de M&eacute;xico. Dicho procedimiento Arbitral se ajustar&aacute; y regular&aacute; por los siguientes art&iacute;culos:</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">1.- El Tribunal Arbitral operara de manera unitaria por lo que se integrar&aacute; de un &aacute;rbitro designado por las partes de com&uacute;n acuerdo y de un Secretario de Acuerdos que dar&aacute; fe de las actuaciones y a su vez ejercer&aacute; funciones de notificador, siendo facultad del propio Arbitro designar a dicho Secretario de Acuerdos de entre los que sean propuestos por las partes en el presente acuerdo arbitral;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">2.- Los contratantes designan como Arbitro al LIC. RICARDO TORTOLERO PE&Ntilde;A ALFARO, y como Arbitro sustituto&nbsp; por imposibilidad f&iacute;sica o ausencia total en que pudiera incurrir el Arbitro ya nombrado, al Licenciado HORACIO RICARDO IV TORTOLERO Y SERRANO, quien proceder&aacute; a su vez a nombrar Secretario de Acuerdos entre los propuestos o a su libre elecci&oacute;n,&nbsp; y se proponen como Secretarios de Acuerdos a cualquiera de las siguientes personas JOSE RICARDO II TORTOLERO Y SERRANO, MAURICIO RICARDO III TORTOLERO Y SERRANO, HORACIO RICARDO IV TORTOLERO Y SERRANO y ENRIQUETA VERONICA GARRIDO BORRAYO, siendo facultad del &Aacute;rbitro elegir a cualquiera de los propuestos;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">3.- El domicilio del Tribunal Arbitral se ubicar&aacute; en las calles de Reynosa # 59, Colonia Condesa, Delegaci&oacute;n Cuauht&eacute;moc, C.P. 06140, en esta Ciudad de M&eacute;xico;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">4.- En el Juicio arbitral no habr&aacute; d&iacute;as ni horas inh&aacute;biles, &uacute;nicamente se se&ntilde;alar&aacute; horario espec&iacute;fico para presentar promociones por las partes;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">5.- Corresponde al &Aacute;rbitro sujetarse a este procedimiento pactado por las partes, de acuerdo al art&iacute;culo 619 segundo p&aacute;rrafo del C&oacute;digo Procesal Civil de la Ciudad de M&eacute;xico, y aplicar supletoriamente las disposiciones&nbsp; del derecho com&uacute;n, dentro del desarrollo del procedimiento pactado, mantener el equilibrio procesal entre las partes, tratar de avenir a las partes a un convenio amistoso, recibir la demanda,&nbsp; promociones, documentos y en su caso aceptar el cargo y decretar la radicaci&oacute;n&nbsp; del Juicio Arbitral;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">6.- Funciones y Obligaciones del Secretario: A) Dar Fe de las actuaciones&nbsp; del procedimiento Arbitral, B) Practicar el emplazamiento al demandado y notificar a las partes los prove&iacute;dos y Laudos con las formalidades establecidas en este procedimiento Arbitral, C) Auxiliar al &Aacute;rbitro en todas sus funciones, D) Expedir copias certificadas de las constancias originales que las partes hayan exhibido en el procedimiento, para entregar a los interesados sus originales, quedando las copias certificadas exclusivamente dentro del expediente y procedimiento arbitral para constancia; E) Deber&aacute; recibir las promociones que presenten las partes y dar cuenta de inmediato al C. Arbitro para su acuerdo, independientemente de que el C. Arbitro podr&aacute; tambi&eacute;n recibir las diversas promociones que presenten las partes,</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">7.- Remuneraci&oacute;n. Por la totalidad del Juicio: Al &Aacute;rbitro le corresponde el equivalente a ciento cincuenta d&iacute;as de salario m&iacute;nimo vigente en la Ciudad de M&eacute;xico y al Secretario de Acuerdos cien d&iacute;as de salario m&iacute;nimo vigente en la Ciudad de M&eacute;xico, honorarios que ser&aacute;n pagados por las partes contendientes por partes iguales, a excepci&oacute;n de que en el Laudo que en su oportunidad se dicte, se condene al pago de dichos honorarios a uno de los litigantes;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">8.- Procedimiento. - El procedimiento se iniciar&aacute; a instancia de cualquiera de las partes, con el escrito de demanda, la que deber&aacute; de reunir los requisitos que marca el C&oacute;digo de Procedimientos Civiles para la Ciudad de M&eacute;xico, y en una sola demanda se acumularan todas las cuestiones que surjan entre las partes.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">9.- Al tener radicada la demanda, el Arbitro elegir&aacute; a cualquiera de los Secretarios propuestos y a continuaci&oacute;n proceder&aacute; a acordar respecto de la admisi&oacute;n de la demanda, se se&ntilde;alar&aacute; lugar del asiento del Tribunal Arbitral y se se&ntilde;alar&aacute; d&iacute;a y hora para la audiencia del Juicio. El emplazamiento lo efectuar&aacute; el Secretario de Acuerdos, como tambi&eacute;n lo podr&aacute; llevar a cabo el C. Arbitro designado, aun cuando el domicilio del demandado este fuera de la Ciudad de M&eacute;xico y se llevar&aacute; a cabo, para el caso de que se demande al arrendatario en el lugar del bien arrendado, y el emplazamiento al fiador se llevar&aacute; a cabo en el domicilio se&ntilde;alado en el contrato de arrendamiento, y para el caso de que el arrendatario&nbsp; sea quien intente la acci&oacute;n se proceder&aacute;&nbsp; a emplazar al arrendador en el domicilio se&ntilde;alado para llevar acabo los pagos de la renta. Las diligencias de emplazamiento se deber&aacute;n entender con el interesado y si no se hallar&eacute; con cualquier familiar, empleado, sirviente o vecino que vivan en el mismo inmueble, y en caso de no haber inquilinos dentro del mismo inmueble, con el vecino m&aacute;s pr&oacute;ximo. El Secretario correr&aacute; traslado con las copias simples exhibidas por el Actor, debiendo cotejarlas y con las copia del auto admisorio de la demanda y aceptaci&oacute;n del cargo de Arbitro y Secretario y siendo &uacute;nicamente la diligencia de emplazamiento la &uacute;nica diligencia que se llevar&aacute; a cabo en el domicilio del demandado, pues las posteriores notificaciones de prove&iacute;dos, Acuerdos y Laudos Definitivos, surtir&aacute;n efectos de notificaci&oacute;n Veinticuatro Horas m&aacute;s tarde de haberse dictado. Los demandados deben ser emplazados por lo menos cinco d&iacute;as naturales antes de la celebraci&oacute;n de la audiencia que se se&ntilde;ale en el auto admisorio de la demanda y los demandados por su parte, podr&aacute;n contestar a m&aacute;s tardar la demanda instaurada en su contra el d&iacute;a de la celebraci&oacute;n de la Audiencia de este procedimiento arbitral, la cual deber&aacute; contestarse solo por escrito.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">10.- Las partes est&aacute;n obligadas a acudir al domicilio designado como asiento o Tribunal del Arbitraje para notificarse de prove&iacute;dos, Acuerdos y Laudos Definitivos. El C. Arbitro y el C. Secretario de Acuerdos podr&aacute;n informar por tel&eacute;fono a las partes el Estado de las actuaciones, sin perjuicio de que las partes acudan al lugar se&ntilde;alado como Tribunal del Arbitraje a imponerse de los autos y corroborar la informaci&oacute;n telef&oacute;nica recibida.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">11.- La parte demandada podr&aacute; ejercitar Acci&oacute;n Reconvencional al contestar su demanda y dicha contra demanda deber&aacute; satisfacer tambi&eacute;n los requisitos de la demanda principal, y la misma deber&aacute; ser contestada por parte de la Actora en la Audiencia del Juicio.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">12.- Ninguna Excepci&oacute;n, ni Incidente suspenden el tr&aacute;mite del Juicio, procedi&eacute;ndose a su resoluci&oacute;n al momento de dictarse Laudo definitivo, con las Excepciones opuestas, se dar&aacute; vista a la parte actora para que manifieste lo que a su derecho m&aacute;s convenga y as&iacute; mismo en caso de reconvenci&oacute;n con las excepciones opuestas se dar&aacute; vista a la actora, siendo optativo para las partes desahogar dichas vistas provenientes de las excepciones opuestas. Los Incidentes de Nulidad de Actuaciones por falta o defecto de citaci&oacute;n o notificaci&oacute;n, se desechar&aacute;n de plano.&nbsp;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">13.- Pruebas. - Todas las que se ofrezcan deber&aacute;n ser desahogadas en una sola audiencia por las partes oferentes y el Arbitro desechar&aacute; aquellas que no re&uacute;nan estos requisitos, trat&aacute;ndose de informes, los mismos deber&aacute;n ser recabados por las partes interesadas, pues la preparaci&oacute;n de las pruebas quedar&aacute; a cargo de las partes, por lo que deber&aacute;n exhibir sus documentos y llevar a sus testigos. -Audiencia.- En la fecha se&ntilde;alada para la celebraci&oacute;n de la Audiencia de este procedimiento arbitral, las partes comparecientes deber&aacute;n identificarse con credencial expedida por Autoridad Competente y&nbsp; podr&aacute;n estar asistidas por Abogado Patrono o Persona de su Confianza. La Audiencia deber&aacute; iniciarse con una etapa conciliatoria en la que el Arbitro trate de avenir a las partes y de no conciliarse las mismas, se proceder&aacute; a proveer sobre la contestaci&oacute;n de demanda, para luego iniciarse el periodo de ofrecimiento de pruebas, admisi&oacute;n y desahogo de las mismas en forma posterior. Las pruebas deber&aacute;n ofrecerse exclusivamente a partir de que se abra el periodo de ofrecimiento de Pruebas, a excepci&oacute;n de la Confesional y prueba pericial que deber&aacute; sujetarse a los t&eacute;rminos que m&aacute;s adelante se se&ntilde;alaran para su ofrecimiento y desahogo;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">14.- Ser&aacute; facultad del &Aacute;rbitro desechar las defensas que no se relacionen con la Litis o resulten innecesarias, y vigilar el desarrollo expedito de la Audiencia, las partes o sus Representantes deber&aacute;n comparecer a la Audiencia del Juicio para el desahogo de la Prueba Confesional, respecto de las posiciones presentadas antes de la Audiencia y calificadas de legales, sin necesidad de notificaci&oacute;n o requerimiento alguno, la absoluci&oacute;n de posiciones podr&aacute; hacerse por el Representante Legal debidamente autorizado y en tal caso quedar&aacute; confeso de aquellas posiciones que diga ignorar, dicha prueba debe de ofrecerse por lo menos cuarenta y ocho horas antes del d&iacute;a y hora de la celebraci&oacute;n de la Audiencia y el Arbitro proceder&aacute; de inmediato a calificar las posiciones de dicha prueba, para que se desahoguen llegado el momento procesal oportuno. Los testigos ser&aacute;n interrogados por ambas partes, las partes&nbsp; que ofrezcan&nbsp; la prueba testimonial, quedar&aacute; a cargo de ellos presentar a sus testigos. El Arbitro rechazar&aacute; las preguntas que no se ajusten a la Litis. Pericial. - El &aacute;rbitro designar&aacute; al perito &uacute;nico e irrenunciable y las partes podr&aacute;n pedir al perito las aclaraciones que estimen necesarias. Esta prueba debe anunciarse con cuarenta y ocho horas de anticipaci&oacute;n a la celebraci&oacute;n de la Audiencia y el oferente deber&aacute; precisar los puntos sobre los que deba versar, el oferente de cualquier prueba pericial deber&aacute; exhibir al momento de anunciar la misma, el importe en efectivo de la cantidad de ciento cuarenta d&iacute;as de salario m&iacute;nimo, para garantizar los honorarios del perito, sin este requisito no se tendr&aacute; por ofrecida tal probanza. Documental.- La prueba documental deber&aacute; exhibirse al momento de su ofrecimiento y en caso de impugnarse por la otra parte la misma, se observar&aacute;n las reglas siguientes: si el documento proviene de un tercero, el que presente el documento al Juicio estar&aacute; obligado a ofrecer las pruebas con las que respalde su valor probatorio, si es la firma de una de las partes la que motiva la impugnaci&oacute;n, dicha parte ofrecer&aacute; la prueba pericial grafol&oacute;gica, grafosc&oacute;pica, o documentoscopica a efecto de esclarecer el origen de las firmas. En este &uacute;nico caso se suspender&aacute; la Audiencia por setenta y dos horas a efecto de que el &aacute;rbitro nombre perito graf&oacute;logo que se encargue de rendir el Dictamen, en esta materia o en la Rama cient&iacute;fica que se ofrezca, las partes podr&aacute;n ofrecer las pruebas complementarias pertinentes, siempre y cu&aacute;ndo puedan desahogarse en la continuaci&oacute;n de la Audiencia. Valoraci&oacute;n de las Pruebas.- El Arbitro gozar&aacute; de las m&aacute;s amplias y prudentes facultades para valorar las pruebas en los t&eacute;rminos de amigable componedor y que en conciencia le otorga el art&iacute;culo 628 del C&oacute;digo de Procedimientos Civiles para la Ciudad de M&eacute;xico. Alegatos.- Desahogadas la pruebas las partes formular&aacute;n sus Alegatos verbales. Laudo. - El Laudo deber&aacute; dictarse a m&aacute;s tardar en los diez d&iacute;as naturales posteriores a la Audiencia con todas las facultades que le conceden los art&iacute;culos 619 y 628 del C&oacute;digo de Procedimientos Civiles para la Ciudad de M&eacute;xico, encomend&aacute;ndosele el fallo en conciencia;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">15.- Los prove&iacute;dos, Acuerdos y Laudos que se pronuncien en el Juicio, ser&aacute;n definitivos y no admiten ning&uacute;n Recurso, en los t&eacute;rminos previstos por el art&iacute;culo 635 del C&oacute;digo Procesal Civil, pues a mayor abundamiento las partes han encomendado al &Aacute;rbitro para el caso de no existir una amigable composici&oacute;n (CONVENIO), el fallo en conciencia al pronunciarse el Laudo definitivo y al resolverse en conciencia no puede existir recurso legal alguno;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">16.- El Arbitro y el Secretario durar&aacute;n en su funci&oacute;n todo el tiempo que sea necesario para la tramitaci&oacute;n del Juicio Arbitral;</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p style="text-align: justify;">17.- Las partes convienen que para el caso de ejecuci&oacute;n judicial del Laudo que llegar&eacute; a pronunciarse, el mismo se tramitar&aacute; ante el C. Juez competente de Primer Instancia en Materia Civil de la Ciudad de M&eacute;xico, que se encuentra en turno, y en este caso los contratantes renuncian al fuero de sus domicilios presentes o futuros y se someten al presente acuerdo arbitral con sede en esta Ciudad de M&eacute;xico, aun cuando el inmueble motivo de este arrendamiento pudiera encontrarse en cualquier parte de la Rep&uacute;blica Mexicana, y para el caso de que el inmueble dado en arrendamiento se encuentre fuera de la jurisdicci&oacute;n de la Ciudad de M&eacute;xico, se proceder&aacute; a su ejecuci&oacute;n mediante el exhorto correspondiente que se solicite a las Autoridades Civiles de Primera Instancia en turno de esta Ciudad de M&eacute;xico.</p>
    <p style="text-align: justify;">VIG&Eacute;SIMO QUINTA.- Este Contrato se extiende por triplicado y los contratantes declaran estar debidamente enterados de todas y cada una de las cl&aacute;usulas contenidas en este contrato y que conocen todos y cada uno de los art&iacute;culos que se citan.</p>
    <p style="text-align: justify;">&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>Ciudad de M&eacute;xico&nbsp; a  '.date("d/m/Y").' .</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="padding-left: 100px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ARRENDADOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;ARRENDATARIO</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="padding-left: 100px;">_______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _______________________________&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p><u>&nbsp;</u></p>
<p><u>&nbsp;</u></p>
<p><u>&nbsp;</u></p>
<p style="padding-left: 100px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FIADOR</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="padding-left: 140px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; __________________________</p>');
}
$mpdf->Output();
