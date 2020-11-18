<?php



class UtilMail
{

    /* public $host = "smtp.gmail.com";
   public $username = "pigmalion@fvirtus.mx";
   public $password = "Pigmalion!V2020";
   public  $from = "Pigmalion Virtus <pigmalion@fvirtus.mx> ";
   public $port = "587";
    */
    public $host = "smtp.gmail.com";
    public $username = "darklaw84@gmail.com";
    public $password = "RoadTrip84";
    public  $from = "XaviPruebas <darklaw84@gmail.com> ";
    public $port = "587";

    /* public $host = "mail.drapercode.com";
   public $username = "xavi.gallegos@drapercode.com";
   public $password = "RealMadrid84*";
   public  $from = "XaviPruebas <xavi.gallegos@drapercode.com> ";
   public $port = "26";
*/




    function enviarCorreoVencePago($to,  $asunto, $contenido)
    {
        require_once "Mail.php";



        $subject = $asunto;
        $body = $contenido;



        $headers = array(
            'From' => $this->from,
            'To' => $to,
            'Subject' => $subject,
            'Content-type' => "text/html; charset=iso-8859-1"
        );
        $smtp = Mail::factory(
            'smtp',
            array(
                'host' => $this->host,
                'auth' => true,
                'username' => $this->username,
                'password' => $this->password,
                'port' => $this->port
            )
        );

        $mail = $smtp->send($to, $headers, $body);


        if (PEAR::isError($mail)) {
            return $mail->getMessage();
        } else {
            return "";
        }
    }



    function enviarCorreoPagoRealizado($to,  $asunto, $contenido,$recibo)
    {
        require_once "Mail.php";
        require_once('Mail/mime.php');


        $subject = $asunto;
        $body = $contenido;



        $headers = array(
            'From' => $this->from,
            'To' => $to,
            'Subject' => $subject,
            'Content-type' => "text/html; charset=iso-8859-1"
        );
        $smtp = Mail::factory(
            'smtp',
            array(
                'host' => $this->host,
                'auth' => true,
                'username' => $this->username,
                'password' => $this->password,
                'port' => $this->port
            )
        );

        $mime = new Mail_mime();

        $file = './recibos/'.$recibo;
        $mime->setHTMLBody($body);
        $mime->addAttachment($file, 'application/pdf');
        $body = $mime->get();
        $headers = $mime->headers($headers);

        $mail = $smtp->send($to, $headers, $body);


        if (PEAR::isError($mail)) {
            return $mail->getMessage();
        } else {
            return "";
        }
    }
}
