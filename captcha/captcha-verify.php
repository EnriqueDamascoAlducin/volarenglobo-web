<?php

session_start( ); // allows us to retrieve our key form the session

/* 

First encrypt the key passed by the form, then compare it to the already encrypted key we have stored inside our session variable

*/

if( md5( $_POST[ 'code' ] ) != $_SESSION[ 'key' ] ) {

       echo "You ented the wrong code, please try again!";

} else {
	
	

       echo "Success, you ented the correct code, rock and roll...";
	   $archivo = fopen("formulario.csv" , "w");
if ($archivo) {
//variables que hayamos declarado en la pelicula de flash
$datos="X: $nombre
+ X:,$email
+ X:,$telefono
+ X:,$nosconoce
+ X:,$mensaje";
fputs ($archivo, $datos);
}
echo $pulsado;
fclose ($archivo);

include "libmail.php";
$m= new Mail;
//correo desde el que se enviará
$m->From( "contacto@evolucionweb.com.mx" );
//correo al que se enviará. Se puede poner en ambos lugares el mismo correo
$m->To( "contacto@evolucionweb.com.mx" );
//el subject del email, será el email que haya escrito el usuario, salvo que lo cambiemos, pon lo que quieras
$m->Subject( "MENSAJE DESDE SITIO WEB" );
//variables que hayamos declarado en la pelicula de flash
$m->Body( "MENSAJE WEB - Yujujuiiii
		 
Nombre:
$nombre
::::::::::::::::::::::::::::::::::::::::::::::
Email:
$email
::::::::::::::::::::::::::::::::::::::::::::::
Telefono:
$telefono
::::::::::::::::::::::::::::::::::::::::::::::
Nos conocio en:
$nosconoce
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

}

?>