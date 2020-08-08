<style type="text/css">
<!--
body {
	margin-top: 200px;
	background-color: #FFF;
}
-->
</style><title>ENVIO REALIZADO</title>
<link href="formato.css" rel="stylesheet" type="text/css" />
<?PHP
$archivo = fopen("formulario.csv" , "w");
if ($archivo) {
//variables que hayamos declarado en la pelicula de flash
$datos="X: $nombre
+ X:,$correo
+ X:,$tipo_vuelo
+ X:,$num_pasajeros
+ X:,$fecha
+ X:,$telefono
+ X:,$servicio1
+ X:,$servicio2
+ X:,$servicio3
+ X:,$servicio4
+ X:,$servicio5
+ X:,$servicio6
+ X:,$servicio7
+ X:,$servicio8
+ X:,$hotel
+ X:,$actividad
+ X:,$mensaje";
fputs ($archivo, $datos);
}
echo $pulsado;
fclose ($archivo);
?>
<?php
include "libmail.php";
$m= new Mail;
//correo desde el que se enviará
$m->From( "ventas@volarenglobo.com.mx" );
//correo al que se enviará. Se puede poner en ambos lugares el mismo correo
$m->To( "ventas@volarenglobo.com.mx" );
//el subject del email, será el email que haya escrito el usuario, salvo que lo cambiemos, pon lo que quieras
$m->Subject( "MENSAJE DESDE SITIO WEB" );
//variables que hayamos declarado en la pelicula de flash
$m->Body( "RESERVACION DESDE SITIO WEB
		 
Nombre:
$nombre
::::::::::::::::::::::::::::::::::::::::::::::
Correo:
$correo
::::::::::::::::::::::::::::::::::::::::::::::
Tipo de Vuelo seleccionado:
$tipo_vuelo
::::::::::::::::::::::::::::::::::::::::::::::
Total de pasajeros:
$num_pasajeros
::::::::::::::::::::::::::::::::::::::::::::::
fecha:
$fecha
::::::::::::::::::::::::::::::::::::::::::::::
Telefono:
$telefono
::::::::::::::::::::::::::::::::::::::::::::::
Servicios:
$servicio1
$servicio2
$servicio3
$servicio4
$servicio5
$servicio6
$servicio7
$servicio8
::::::::::::::::::::::::::::::::::::::::::::::
Hotel:
$hotel
::::::::::::::::::::::::::::::::::::::::::::::
Actividades:
$actividad
::::::::::::::::::::::::::::::::::::::::::::::
Mensaje:
$mensaje
::::::::::::::::::::::::::::::::::::::::::::::" );
//Si queremos que el correo se envíe a más cuentas de correo, quitar las barras de comentario y especificar los correos
//$m->Cc( "info@expoasecem.org");
//$m->Bcc( "aztrall@yahoo.com");
$m->Priority(1) ;
$m->Attach( "formulario.csv", "application/vnd.ms-excel", "attachment" );
$m->Send();
?>
<style type="text/css">
<!--
body,td,th {
	color: #FFF;
}
-->
</style>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="txt_mensaje_enviado">&nbsp;</td>
  </tr>
</table>
