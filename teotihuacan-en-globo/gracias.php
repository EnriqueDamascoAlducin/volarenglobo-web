<?php 

if(!empty($_POST['nombre'])){
  $to = $_POST['mail']; 
   $nombre = $_POST['nombre'];
    $telefono = $_POST['tel'];
  $correo = $_POST['mail'];
  $servicio =  $_POST['servicio'];
  $fecha =  $_POST['fecha'];
  $comentario =  $_POST['mensaje'];
    $subject = "Nuevo prospecto Landing";
  $salto = "\n\n";
    $message = "Nombre:  ".$nombre .$salto ."Telefono:  " . $telefono . $salto. "Email:  " .$correo.$salto ."Servicio:  " .$servicio.$salto."Posible fecha de vuelo:  " .$fecha.$salto."Mensaje: ".$comentario  ;
	//exit();
    //$message2 = "Nombre:  ".$nombre .$salto ."Teléfono:  " . $telefono . $salto. "Email:  " .$correo.$salto ."Servicio:  " .$servicio.$salto."Mensaje: ".$comentario  ;
 // More headers
 $headers .= 'To: <reserva@volarenglobo.com.mx>' . "\r\n";
$headers .= 'From:'.'<'.$correo.'>'. "\r\n";
//Multiple CC can be added, if we need (comma separated);
$headers .= 'Cc: <jcordova86@gmail.com>' . "\r\n";
//Multiple BCC, same as CC above;
$headers .= 'Bcc:<jco_1986@hotmail.com>' . "\r\n";

    mail(null,$subject,$message,$headers);
   // echo "Mail Sent. Thank you " . $first_name . ", we will contact you shortly.";
    // You can also use header('Location: thank_you.php'); to redirect to another page.
   // echo "enviado";
}else{
    echo "No enviado";
    }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Teotihuacan en globo</title>
 <!-- CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="style.css" rel="stylesheet" media="screen">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <script src="js/enviar.js"></script>
</head>
<body>
<!-- Google Code for Lead Landing Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1003568720;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "LniECOvwn20Q0PzE3gM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1003568720/?label=LniECOvwn20Q0PzE3gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<header>
<div class="container">

<div class="row">

<div class="col-md-5 col-md-offset-8">
<img src="images/volarenglobo.png" class="img-responsive text-center">
 </div>
 </div>

<div class="row">

<div class="col-md-5 col-md-offset-6">
<h1>GRACIAS POR <br>
CONTÁCTARNOS</h1>
 <p class="blanco text-center bottom60 sub">Nos comunicaremos contigo a la brevedad.</p>
 </div>
 </div>
 <div class="clearfix"></div>
 <div class="row text-center bottom60">
<div class="col-md-3 col-md-offset-1"><a href="#form" class="cta">APARTA TU LUGAR</a></div>

</div>
</div>
</header>
<br><br>

 <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="http://code.jquery.com/jquery.js"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>