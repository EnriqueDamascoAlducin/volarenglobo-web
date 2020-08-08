<? 
session_start();
?>
<script type="text/javascript" src="js/func.js" language="javascript"></script>
<script>
function numbers(evt)
      {
        var keyPressed = (evt.which) ? evt.which : event.keyCode
        return !(keyPressed > 31 && (keyPressed < 48 || keyPressed > 57));
      }
</script>
<script language='javascript' src="popcalendarAll.js"></script>
<link rel="stylesheet" type="text/css" href="css/stylo.css"/>
<?
include('lib/func.inc.php');
Get_Conn();


$id = $_GET['id'];


//*guarda actualizacion de asociacion*//

if(isset($_POST['ActualizarAsociacion'])){

echo"UPDATE fly_asoc SET id_piloto = '".$_POST['piloto']."', id_globo = '".$_POST['globo']."', editado = 1 
				WHERE id_fly_asoc = '".$_POST['code']."' ";

	@mysql_query("UPDATE fly_asoc SET id_piloto = '".$_POST['piloto']."', id_globo = '".$_POST['globo']."', editado = 1 
				WHERE id_fly_asoc = '".$_POST['code']."' ");

	echo"<script>alert('se ha editado la asociacion del Vuelo VGA ".$_POST['clave']."'); opener.location.reload(); window.close();</script>";
	
}


if(isset($_POST['guardar'])){
	
	//class mail
	require("lib/class.phpmailer.php");
	require("lib/class.smtp.php");	
	
	mysql_query("INSERT INTO pagos (id_reserva, clave, cantidad, id_cuentas_bancarias, id_user, dateAdd,fecha_pago,referencia) 
				VALUES
				('".$_POST['idr']."',
				 '".$_POST['code']."',
				 '".$_POST['cantidad']."',
				 '".$_POST['cuenta']."',
				 '".$_SESSION['USER_ID']."',NOW(),'".$_POST['checkin']."','".$_POST['ref']."' ) ") or die ("erro inset concil".mysql_error());
	
	
	if(!empty($_POST['hora']) or $_POST['hora'] != '00:00:00'){
	
	mysql_query("UPDATE reservas_det SET hora = '".$_POST['hora']."', peso = '".$_POST['peso']."' WHERE clave =  '".$_POST['code']."' ") or die("Erro Update Hr <br>".mysql_error());
	
	
	}
	
	$np = @mysql_result(mysql_query("SELECT concat(nombre,' ',apellidos) FROM reservas
where clave = '".$_POST['code']."' "),0,0);
	
	/*$mailData = "daemon@volarenglobo.com.mx";
	$to      = "contabilidad@volarenglobo.com.mx";
	//$to      = "fcortes@hotelesdemexico.com.mx";
$subject = "Nuevo Pago Capturado Codigo ".$_POST['code']." ";
$message = $revisa;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '.$mailData.' ' . "\r\n" .
'Reply-To: '.$mailData.'' . "\r\n" .
   'X-Mailer: PHP/' . phpversion();
   $error = 'error!!!';
$cols .= " $mail,$name";*/

$str = "<table><tr><td colspan='2' align='center'>Se ha ingresado un pago </td></tr> 
<tr>
<td>Pasajero:</td><td>$np</td></tr>
<td>Codigo:</td><td>".$_POST['code']."</td></tr>
<tr><td>Cantidad:</td><td>".$_POST['cantidad']."</td></tr>
<tr><td>Cuenta:</td><td>". @mysql_result(mysql_query("SELECT clave FROM cuentas_bancarias WHERE i_cuentas_bancarias = ".$_POST['cuenta']." "),0,0)."</td></tr>
<tr><td>Referencia:</td><td>".$_POST['ref']."</td></tr>
<tr><td>Fecha de Pago:</td><td>".$_POST['checkin']."</td>
</tr>

</table>";


$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
//$mail->SMTPSecure = "ssl";
$mail->Host = "mail.volarenglobo.com.mx";
$mail->Port = 587;
 
//Nos autenticamos con nuestras credenciales en el servidor de correo Gmail
$mail->Username = "daemon@volarenglobo.com.mx";
$mail->Password = "Admin002#";
 
//Agregamos la informaci&oacute;n que el correo requiere
$mail->From = "daemon@volarenglobo.com.mx";
$mail->FromName = "daemon@volarenglobo.com.mx";
$mail->Subject = "Nuevo Pago Capturado Codigo ".$_POST['code']." ";
$mail->AltBody = "";
$mail->MsgHTML($str);
//$mail->AddAttachment("adjunto.txt");
$mail->AddAddress("contabilidad@volarenglobo.com.mx", " ");
//$mail->AddAddress("fernando@liondigital.mx","Fernando Cortes");
$mail->AddCC("auxiliar@volarenglobo.com.mx");
$mail->AddBCC("sergio@volarenglobo.com.mx");
//$mail->AddBCC("contabilidad@volarenglobo.com.mx","");
$mail->IsHTML(true);
//$mail->SMTPDebug  = 1;
 
//Enviamos el correo electr&oacute;nico
$mail->Send();


	//mail($to, $subject, $str, $headers);
	
	
	echo"<script>alert('se ha registrado el pago por ".$_POST['cantidad']."'); opener.location.reload(); window.close();</script>";
	
}

if(isset($_POST['ActualizarUsuario'])){
	
	/*echo "usuario".$_POST['usr']."<br>";
	echo "psw".$_POST['psw']."<br>";
	echo "activo".$_POST['activo']."<br>";
	echo "idu".$_POST['idu']."<br>";
	echo "activo".$_POST['activo']."<br>";
	print_r($_POST['menAct']);*/
	
	
	
	if($_POST['activo']){
	
	$activo =1;
	}else{
			$activo =0;
	}
	
	$busca_psw = @mysql_result(mysql_query("SELECT psw FROM usuarios WHERE id_user = '".$_POST['idu']."' "),0,0);
	
	if(strlen($busca_psw) == strlen($_POST['psw'])){
	
	mysql_query("UPDATE usuarios SET  usr = '".$_POST['usr']."' , psw='".$_POST['psw']."', activo = '$activo' 
				,nombre = '".$_POST['name_sing']."'		
				,mail = '".$_POST['mail_sing']."'		
				,oficina = '".$_POST['ofa_sing']."'		
				,movil = '".$_POST['movil_sing']."'		
				,radio = '".$_POST['radio_sing']."'																				
				
				WHERE id_user = '".$_POST['idu']."' ") or die ("erro update usr<br>".mysql_error());
	}else{
		mysql_query("UPDATE usuarios SET  usr = '".$_POST['usr']."' , psw=md5('".$_POST['psw']."'), activo = '$activo' 
				,nombre = '".$_POST['name_sing']."'		
				,mail = '".$_POST['mail_sing']."'		
				,oficina = '".$_POST['ofa_sing']."'		
				,movil = '".$_POST['movil_sing']."'		
				,radio = '".$_POST['radio_sing']."'																				
				
				WHERE id_user = '".$_POST['idu']."' ") or die ("erro update usr<br>".mysql_error());
	}
	$c = mysql_query("SELECT id_menu FROM menu")or die (mysql_error());
		
		while($row = mysql_fetch_array($c)){
		
		$ar[] = $row[0];
		
		}
	
	mysql_query("DELETE FROM user_menu WHERE id_user = '".$_POST['idu']."' ") or die("erro del men usr<br>".mysql_error());
	
	foreach ($ar as $key => $val){
		
			if(in_array($val,$_POST['menAct'])){
			
			mysql_query("INSERT INTO user_menu ( id_menu, id_user, dateAdd, Activo)
										VALUES
										('$val','".$_POST['idu']."',NOW(),1)") or die ("erro insert user men".mysql_error());
			
			
			}else{
			
			mysql_query("INSERT INTO user_menu ( id_menu, id_user, dateAdd, Activo)
										VALUES
										('$val','".$_POST['idu']."',NOW(),0)") or die ("erro insert user men".mysql_error());
			
			}
		
		
		}
		
		echo"<script>alert('Usuario Modificado ');opener.location.reload();
		window.close();</script>";
}


if(isset($_POST['AgregarUsuario'])){
		
		$c = mysql_query("SELECT id_menu FROM menu")or die (mysql_error());
		
		while($row = mysql_fetch_array($c)){
		
		$ar[] = $row[0];
		
		}
		
		if($_POST['activo']){
	
		$act = 1;
		}else{
			
			$act = 0;
		}
		
		mysql_query("INSERT INTO usuarios ( nombre, usr, psw, activo, dateAdd, id_tipo_usr,mail,movil,radio,oficina)
									   VALUES
									   ('".$_POST['name_comp']."','".$_POST['usr']."','".md5($_POST['psw'])."','$act',NOW(),3,
																													 	
'".$_POST['mail_sing']."'			
,'".$_POST['movil_sing']."'		
,'".$_POST['radio_sing']."'		
,'".$_POST['ofa_sing']."'																														 
																													 )")
	or die ("Erro inset new user <br>".mysql_error());
	
	$id_user = mysql_result(mysql_query("SELECT LAST_INSERT_ID() FROM usuarios"),0,0);
	
	
		
		foreach ($ar as $key => $val){
		
			if(in_array($val,$_POST['menAct'])){
			
			mysql_query("INSERT INTO user_menu ( id_menu, id_user, dateAdd, Activo)
										VALUES
										('$val','$id_user',NOW(),1)") or die ("erro insert user men".mysql_error());
			
			
			}else{
			
			mysql_query("INSERT INTO user_menu ( id_menu, id_user, dateAdd, Activo)
										VALUES
										('$val','$id_user',NOW(),0)") or die ("erro insert user men".mysql_error());
			
			}
		
		
		}
		
		echo"<script>alert('el Usuario ".$_POST['name_comp']." se ha ingresado ');opener.location.reload();
		window.close();</script>";


}
/*cambia fecha vuelo*/
if(isset($_POST['CambiarFecha'])){
	
	if($_POST['indef'] == true){
	/*fecha indefinida*/
		mysql_query("INSERT INTO log_change_dates (fecha_anterior, fecha_nueva, id_user, indefinida, definida, 
					clave, cargo_extra, motivo, coment,dateAdd) 
					VALUES ('".$_POST['fecha_actual']."' ,'' ,'".$_SESSION['USER_ID']."', 1, '', '".$_POST['code']."', 
					'".$_POST['cargo']."', '".$_POST['motivo']."' , '".$_POST['coments']."',NOW())
		") or die ("erro in undef <br>".mysql_error());
	
		if($_POST['cargo'] > 0){
			
		}
		
		$code = $_POST['code'];
		$hasta = @mysql_result(mysql_query("select date_add('".$_POST['fecha_actual']."', interval 3 month)"),0,0);
	
		echo"<script>alert('El vuelo $code ha sido actualizado\\nFecha Nueva: Indefinida\\nLa fecha se puede mantener hasta: $hasta');opener.location.reload();
		window.close();</script>";
	
	}else{
		
		/*fecha definida*/
			
			//limite 3 meses
			$hasta = @mysql_result(mysql_query("select date_add('".$_POST['fecha_actual']."', interval 3 month)"),0,0);
		
			if($_POST['checkin_n'] > $hasta){
			
			echo"<script>alert('La fecha nueva no puede ser mayor a 3 meses');</script>";
			
			}else{
			
			$tot_vuelo = mysql_result(mysql_query("SELECT sum((ad*precio_vueloA)+(kid*precio_vueloN)) 
						FROM reservas_det where clave = '".$_POST['code']."'"),0,0);
			$solo_cargo=0;
			
			$code = $_POST['code'];
			
			if($_POST['cargo'] > 0){
				
				
				
				$ndesc = ".".$_POST['cargo']."";
				$solo_cargo = ($tot_vuelo*$ndesc);
				$cargo_ad = (($tot_vuelo*$ndesc)+$tot_vuelo);
				
				mysql_query("UPDATE reserva_totales SET total = '$cargo_ad' 
							WHERE clave ='".$_POST['code']."' ") or die ("erro upd rsv tot<br>".mysql_error());
				
				mysql_query("INSERT INTO log_change_dates 
							(fecha_anterior, fecha_nueva, id_user, indefinida, definida, clave, cargo_extra, motivo, coment,
					 		 total_anterior,cant_cargo,dateAdd) 
							VALUES ('".$_POST['fecha_actual']."' ,'".$_POST['checkin_n']."' ,'".$_SESSION['USER_ID']."', 0, '".
							$_POST['checkin_n']."', '".$_POST['code']."', '".$_POST['cargo']."', '".$_POST['motivo']."' , 
							'".$_POST['coments']."','$tot_vuelo','$solo_cargo',NOW())
							") or die ("erro in undef <br>".mysql_error());
			
				mysql_query("UPDATE reservas_det SET modifico_fecha = 1, fecha_vuelo = '".$_POST['checkin_n']."' 
							WHERE clave = '".$_POST['code']."'") 
							or die("erro act rsv det <br>".mysql_error());
			
			
				echo"<script>alert('El vuelo $code ha sido actualizado\\nFecha Nueva: ".$_POST['checkin_n']."\\nGenero un cargo adicional de :$solo_cargo');opener.location.reload();
			window.close();</script>";
			
			}else{
			
				mysql_query("INSERT INTO log_change_dates 
							(fecha_anterior, fecha_nueva, id_user, indefinida, definida, clave, cargo_extra, motivo, coment,
					 		 total_anterior,cant_cargo,dateAdd) 
							VALUES ('".$_POST['fecha_actual']."' ,'".$_POST['checkin_n']."' ,'".$_SESSION['USER_ID']."', 0, '".
							$_POST['checkin_n']."', '".$_POST['code']."', '".$_POST['cargo']."', '".$_POST['motivo']."' , 
							'".$_POST['coments']."','$tot_vuelo','$solo_cargo',NOW())
							") or die ("erro in undef <br>".mysql_error());
			
				mysql_query("UPDATE reservas_det SET modifico_fecha = 1, fecha_vuelo = '".$_POST['checkin_n']."' 
							WHERE clave = '".$_POST['code']."'") 
							or die("erro act rsv det <br>".mysql_error());
			
			
				echo"<script>alert('El vuelo $code ha sido actualizado\\nFecha Nueva: ".$_POST['checkin_n'].
				"');opener.location.reload();window.close();</script>";
			}
				
			
			
			}
			
		
		
	}
	
}

if($id == 1){

	$code= $_GET['code'];
	
	$id_reserva = $_GET['idr'];
	
	
	
	$sql = mysql_query("SELECT i_cuentas_bancarias,clave from cuentas_bancarias where activo = 1
	") or die ("erro sel cuenta <br>".mysql_error());
	echo"<form method='post' name='cappagos' onsubmit='return RCP(this);'><table align='center' width='100%'>
	<tr><td><img src='imgs/loguito.png'></td><td align='center' bgcolor='#FF6633' class='textNormalBlanco' >Ingresar Pago A Vuelo</td></tr>
	<tr><td colspan='2' align='center'  bgcolor=\"#3674B2\" class=\"textNormalBlanco\" > AR - $code</td></tr>
	<tr class=\"textInputsBlack\" align='left'><td>Cuenta</td><td>
	
	<select name='cuenta' class=\"textInputsBlack\">";
	
		while($row = mysql_fetch_array($sql)){
		
		echo"<option value='$row[0]' >$row[1]</option>";
		
		}
	
	echo"</select>
	
	</td></tr>
	
	<tr class=\"textInputsBlack\" align='left'><td>Cantidad</td><td><input type='text' name='cantidad' class=\"textInputsBlack\" onKeyPress=\"return numbers(event);\" ></tr>
	<tr class=\"textInputsBlack\" align='left'><td>Referencia</td><td><input type='text' name='ref' class=\"textInputsBlack\"></td></tr>
	<tr class=\"textInputsBlack\" align='left'><td>Fecha De Deposito</td><td><input type=\"text\"  class=\"inputs\" name=\"checkin\" id=\"dateArrival\"
	onClick=\"javascript:popUpCalendar(this, form.dateArrival, 'yyyy-mm-dd');\" size=\"10\"  />
    <a HREF=\"#\"  onClick=\"javascript:popUpCalendar(this, form.dateArrival, 'yyyy-mm-dd');\">
    <img SRC=\"imgs/calendar.gif\" WIDTH=\"24\" HEIGHT=\"24\" border=0></a> </tr>
";	

$hora = @mysql_result(mysql_query("SELECT hora FROM reservas_det WHERE clave =$code "),0,0);

if ($hora == "00:00:00" or empty($hora)){
	echo"<tr class=\"textInputsBlack\" align='left'><td>Hora de Vuelo</td><td><input type='text' name='hora' class=\"textInputsBlack\" value='00:00:00' ><i>formato 00:00:00</i></td></tr>
	<tr class=\"textInputsBlack\" align='left'><td>Peso</td><td><input type='text' name='peso' class=\"textInputsBlack\"  ></td></tr>";
}
	echo"
	<tr><td colspan='2' align='center'  bgcolor=\"#3674B2\" class=\"textNormalBlanco\" >Forma Final de Pago</td></tr>
	<tr class=\"textInputsBlack\" align='left'><td>Selecciona</td><td><select name='FFP'>
	<option value='1'>Efectivo</option>
	<option value='2'>Tarjeta de Credito</option>
	<option value='3'>AMEX</option>
	<option value='4'>Deposito</option>
	</select></td></tr>
	
	
	<tr><td colspan='2' align='center'><input type='submit' name='guardar' value='guardar'></td></tr>
	<input type='hidden' value='$code' name='code'><input type='hidden' value='$id_reserva' name='idr'>
	</table></form>
	";
	echo foot();

}else if($id == 2){
	
	/*$name = $_GET['n'];
	$idu = $_GET['idu'];
	
	$sql = mysql_query("SELECT um.id_user_menu,m.nombre ,um.activo FROM user_menu um
inner join menu m on (m.id_menu = um.id_menu)
where id_user = $idu ") or die (mysql_error());
	
	$dataUsr = mysql_query("SELECT usr,activo,psw FROM usuarios
where id_user = $idu ") or die(mysql_error());
	
	echo"<table width='100%' align='center'><form method='POST'>
	
	<tr><td><img src='imgs/loguito.png'></td><td align='center' bgcolor='#FF6633' class='textNormalBlanco' >Consulta usuario $name</td></tr>
	
	<tr class='textInputsBlack'><td>Usuario Activo</td><td>"; 
	
	if(mysql_result($dataUsr,0,1) == 1){
			echo"<input type='checkbox' name='activo' checked='checked'>";
		}else{
			echo"<input type='checkbox' name='activo'>";
		}
	echo"</td></tr>
	
	<tr  class='textInputsBlack'><td>Usuario</td><td><input type='text' name='usr' value='".mysql_result($dataUsr,0,0)."'></td></tr>
	<tr  class='textInputsBlack'><td>Contraseña</td><td><input type='password' value='".mysql_result($dataUsr,0,2)."' name='psw'></td></tr>
	<input type='hidden' name='idu' value='$idu'>
	<tr  class='textInputsBlack'><td>Menu</td><td>Acceso</td></tr>
	";
	
	$ar;
	
	while($row = mysql_fetch_array($sql)){
	
	if($row[1] != 'Salir'){
	echo"<tr  class='textInputsBlack'><td>$row[1]</td><td>";
		if($row[2] == 1){
			echo"<input type='checkbox' name='menus[]' checked='checked'>";
		}else{
			echo"<input type='checkbox' name='menus[]'>";
		}
	echo"</td></tr>";
	}
	
	}
	
	echo"<tr><td colspan='2'>
	
	<input type='submit' name='ActualizarUsuarios'  class='textInputsBlack' value='ActualizarUsuarios' ></td></tr>
	</form>
	</table>";
	echo foot();
	*/
	$n = $_GET['n'];
	$idu = $_GET['idu'];
	
	edit_user($idu,$n);
	
	
	
}else if($id == 3){

$id_pagos = $_GET['idp'];

mysql_query("UPDATE pagos SET conciliado = 1, id_user_concil = ".$_SESSION['USER_ID']." ,dateconcil = NOW() WHERE id_pagos = $id_pagos ") or die (mysql_error());

$clave = @mysql_result(mysql_query("SELECT clave FROM pagos
where id_pagos = $id_pagos
and conciliado = 1 
LIMIT 1"),0,0);

$UpMainData = mysql_query("UPDATE reservas SET conciliado = 1 WHERE clave = $clave") or die ("Erro UpMainData <br>".mysql_error());

$mail_vendedor = @mysql_result(mysql_query("select u.mail FROM usuarios u
inner join reservas r on (r.id_user = u.id_user)
where clave = $clave "),0,0);

$np = @mysql_result(mysql_query("SELECT concat(nombre,' ',apellidos) FROM reservas
where clave = $clave "),0,0);

//class mail
	require("lib/class.phpmailer.php");
	require("lib/class.smtp.php");	
	
	
	
/*$mailData = "daemon@volarenglobo.com.mx";
	$to      = $mail_vendedor;
	//$to      = "fcortes@hotelesdemexico.com.mx";
$subject = "Pago Conciliado Codigo de Vuelo ".$_POST['code']." ";
$message = $revisa;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '.$mailData.' ' . "\r\n" .
'Reply-To: '.$mailData.'' . "\r\n" .
   'X-Mailer: PHP/' . phpversion();
   $error = 'error!!!';
$cols .= " $mail,$name";*/

$GetSql = mysql_query("SELECT clave,cantidad,referencia,fecha_pago,dateconcil FROM pagos
where id_pagos =$id_pagos
and conciliado = 1") or die ("erro mail concil data.<br>".mysql_error());

$str = "<table><tr><td colspan='2' align='center'>Se ha Conciliado un pago al Codigo $clave </td></tr> 
<tr><td>Pasajero:</td><td>$np</td></tr>
<tr>
<td>Codigo:</td><td>".@mysql_result($GetSql,0,0)."</td></tr>
<tr><td>Cantidad:</td><td>".@mysql_result($GetSql,0,1)."</td></tr>
<tr><td>Referencia:</td><td>".@mysql_result($GetSql,0,2)."</td></tr>
<tr><td>Fecha de Pago:</td><td>".@mysql_result($GetSql,0,3)."</td></tr>
<tr><td>Fecha de Conciliacion de Pago:</td><td>".@mysql_result($GetSql,0,4)."</td>
</tr>

</table>";


	$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
//$mail->SMTPSecure = "ssl";
$mail->Host = "mail.volarenglobo.com.mx";
$mail->Port = 587;
 
//Nos autenticamos con nuestras credenciales en el servidor de correo Gmail
$mail->Username = "daemon@volarenglobo.com.mx";
$mail->Password = "Admin002#";
 
//Agregamos la informaci&oacute;n que el correo requiere
$mail->From = "daemon@volarenglobo.com.mx";
$mail->FromName = "daemon@volarenglobo.com.mx";
$mail->Subject = "Pago Conciliado Codigo de Vuelo ".$_POST['code']." ";
$mail->AltBody = "";
$mail->MsgHTML($str);
//$mail->AddAttachment("adjunto.txt");
$mail->AddAddress($mail_vendedor, " ");
//$mail->AddAddress("fernando@liondigital.mx","Fernando Cortes");
$mail->AddCC("auxiliar@volarenglobo.com.mx");
$mail->AddBCC("sergio@volarenglobo.com.mx");
//$mail->AddBCC($mail_vendedor,"");
$mail->IsHTML(true);
//$mail->SMTPDebug  = 1;
 
//Enviamos el correo electr&oacute;nico
$mail->Send();
	//mail($to, $subject, $str, $headers);



echo"<script>opener.location.reload(); window.close();</script>";

}else if($id == 4){

$code= $_GET['code'];
	
	$id_reserva = $_GET['idr'];

$sql = mysql_query("SELECT  cantidad, cb.clave, p.dateAdd, referencia, date(fecha_pago) FROM pagos p
inner join cuentas_bancarias cb on (cb.i_cuentas_bancarias = p.id_cuentas_bancarias)
where p.clave = $code") or die ("Erro sel Pagos <br>".mysql_error());

echo"<table align='center' width='100%'>
	<tr><td><img src='imgs/loguito.png'></td><td align='center' bgcolor='#FF6633' class='textNormalBlanco' colspan='3' >Consulta de Pagos A Vuelo</td></tr>
	<tr><td colspan='4' align='center'  bgcolor=\"#3674B2\" class=\"textNormalBlanco\" > AR - $code</td></tr>
	<tr align='center' bgcolor='#FF6633' class='textNormalBlanco'>
	<td>Fecha de Captura</td>
	<td>Fecha de Pago</td>
	<td>Cantidad - Referencia</td>
	<td>Cuenta</td>
	</tr>";
	
	while($row = mysql_fetch_array($sql)){
		
		echo"<tr class=\"textInputsBlack\" align='center'>
		<td>$row[2]</td>
		<td>$row[4]</td>
		<td>$row[0] - $row[3]</td>
		<td>$row[1]</td>
		</tr>";
		
	}
	
	
	echo"<tr><td colspan='2' align='center'><input type='button' name='Continuar' value='Continuar'></td></tr>
	
	</table>
	";
	echo foot();


}else if($id == 5){
	
	echo AddUser();

}else if($id == 6){
	
	echo Cofirm_fly($_GET['clave'],$id_r,$_SESSION['USER_ID']);

}else if($id == 7){
	
	$code = $_GET['c'];
	
	$sql1 = mysql_query("SELECT r.id_reserva,concat(tel,' / ',cel),fecha_vuelo,
(SELECT concat(tp.clave,' ',tp.nombre) FROM tipos_vuelos tp WHERE tp.id_tipos_vuelos = rd.id_tipos_vuelos),ad,kid,
(SELECT mv.nombre FROM motivo_vuelo mv WHERE mv.id_motivo_vuelo = rd.id_motivo_vuelo),comentarios,rd.id_tipos_vuelos,descuento
 ,rd.id_tipo_tarifa,rd.id_tipos_vuelos FROM reservas r
inner join reservas_det rd on (rd.id_reserva = r.id_reserva)
WHERE r.clave =  $code
") or die("erro sel data mailcoti <br>".mysql_error());

$id_reserva = mysql_result($sql1,0,0);
$tel = mysql_result($sql1,0,1);
$fecha_vuelo = mysql_result($sql1,0,2);
$tipo_vuelo = mysql_result($sql1,0,3);
$ad =mysql_result($sql1,0,4);
$kid = mysql_result($sql1,0,5);
$motivo = mysql_result($sql1,0,6);
$coment = mysql_result($sql1,0,7);
$id_t_v = mysql_result($sql1,0,8);
$desc = mysql_result($sql1,0,9);
$tipo_de_tarifa = mysql_result($sql1,0,10);
$tipo_vuelo_real_id = mysql_result($sql1,0,11);
$textoGeneral = mysql_result(mysql_query("SELECT texto FROM descripcion_vuelos
where id_tipo_vuelo =$id_t_v"),0,0);


if(!empty($ad)){
	
	$total_Ad = mysql_result(mysql_query("SELECT sum(precio_vueloA) FROM reserva_precio
where clave = $code "),0,0);
	
	/*echo mysql_result(mysql_query("SELECT sum(precio_vueloA) FROM reserva_precio
where clave = $code "),0,0);*/
	
	/*for($i=1; $ad>=$i; $i++){
	
	 $total_Ad += mysql_result(mysql_query("SELECT adulto FROM precios_vuelos WHERE $i between pax_in and pax_fin 
								  AND id_tipo_tarifa = $tipo_de_tarifa
	AND id_tipos_vuelo = $tipo_vuelo_real_id "),0,0);

	/*echo mysql_result(mysql_query("SELECT adulto FROM precios_vuelos WHERE $i between pax_in and pax_fin 
								  AND id_tipo_tarifa = $tipo_de_tarifa
	AND id_tipos_vuelo = $tipo_vuelo_real_id "),0,0)."<br>";
	
	/*echo "SELECT adulto FROM precios_vuelos WHERE $i between pax_in and pax_fin 
								  AND id_tipo_tarifa = $tipo_de_tarifa
	AND id_tipos_vuelo = $tipo_vuelo";
	
	}*/
}

if(!empty($kid)){
	
	$total_Ni = mysql_result(mysql_query("SELECT sum(precio_vueloN) FROM reserva_precio
where clave = $code "),0,0);
	
	/*echo mysql_result(mysql_query("SELECT sum(precio_vueloA) FROM reserva_precio
where clave = $code "),0,0);*/
	
	/*for($i=1; $ni>=$i; $i++){
	
	  $total_Ni += mysql_result(mysql_query("SELECT kid FROM precios_vuelos WHERE $i between pax_in and pax_fin 
								  AND id_tipo_tarifa = $tipo_de_tarifa
	AND id_tipos_vuelo = $tipo_vuelo_real_id "),0,0);
	
	}*/
	
}




$totalAdnKid = ($total_Ni+$total_Ad);



$str = "<table aling=\"center\" width=\"450\" bgcolor=\"#DCE6F1\">
<tr><td colspan='2'  bgcolor='#FF6633' class='textNormalBlanco' align='center' >Datos del Vuelo</td></tr>
<tr><td  bgcolor='#FF6633' class='textNormalBlanco' width='150'>Referencia:</td><td class='textInputsBlack'>$code</td></tr>
<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Nombre:</td><td class='textInputsBlack'>$nombre</td></tr>
<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Fecha de Vuelo:</td><td class='textInputsBlack'>$fecha_vuelo</td></tr>
<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Tipo de Vuelo:</td><td class='textInputsBlack'>$tipo_vuelo</td></tr>
<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Adultos:</td><td class='textInputsBlack'>$ad </td></tr>
<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Ni&ntilde;os:</td><td class='textInputsBlack'>$kid </td></tr>
<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Motivo:</td><td class='textInputsBlack'>$motivo</td></tr>
<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Comentarios:</td><td class='textInputsBlack'>$coment</td></tr>";

$sql2 = mysql_query("SELECT id_reserva_hotel,rh.precio,(SELECT h.nombre FROM hoteles h WHERE h.id_hotel = ht.id_hotel),CONCAT(ht.clave,'-',descripcion) FROM reserva_hotel rh
inner join hoteles_tarifas ht on (ht.id_tarifa = rh.id_tarifa)
WHERE rh.clave = $code ") or die ("erro sel hotel mail <br>".mysql_error());

$nr1 = mysql_num_rows($sql2);
if(!empty($nr1)){

$str .= "<tr><td colspan='2'  bgcolor='#FF6633' class='textNormalBlanco' >Hotel ".mysql_result($sql2,0,2)."</td></tr>
	<tr><td class='textInputsBlack'>".mysql_result($sql2,0,3)."</td><td class='textInputsBlack'>$".mysql_result($sql2,0,1)."</td>
	</tr>
	
	";


$totalHotel = mysql_result($sql2,0,1);

}

$sql3 = mysql_query("SELECT id_reservas_prod,p.name,rp.precio,rp.cortesia,rp.clave,rp.cortesia FROM reservas_prod rp
inner join productos p on (p.id_productos = rp.id_productos)
where rp.clave = $code ") or die ("erro data sel reserva prod <br>".mysql_error());

$nr2 = mysql_num_rows($sql3);

if(!empty($nr2)){


$str .= "<tr><td colspan='2'  bgcolor='#FF6633' class='textNormalBlanco'>Servicios</td></tr>";

	while($rw1 = mysql_fetch_array($sql3)){
	
	$str .= "<tr class='textInputsBlack'><td>$rw1[1] </td><td>$$rw1[2]</td></tr>";
	
	$totalProd += $rw1[2];
	
		if($rw1[5] == 1){
		
		$sumCorte += $rw1[2];
		
		}
	
	
	}

}

$sql4 = mysql_query("SELECT descripcion,precio FROM reserva_otros_cargos
where clave = $code ") or die ("erro data sel otroscargos  <br>".mysql_error());

$nr3 = mysql_num_rows($sql4);

if(!empty($nr3)){
	
$str .="<tr><td colspan='2'  bgcolor='#FF6633' class='textNormalBlanco'>Otros Cargos</td></tr>"; 

while($rw = mysql_fetch_array($sql4)){

$str .="<tr class='textInputsBlack'><td>$rw[0] </td><td>$$rw[1]</td></tr>" ;

$totalOtros += $rw[1];

}

}

$totales = ($totalAdnKid+$totalHotel+$totalProd+$totalOtros-$sumCorte);


if($desc > 0 and $desc <= 50){
	
	if(strlen($desc) == 1){
	$ndesc = ".0$desc";	
	}else if(strlen($desc)>1){
	$ndesc = ".$desc";
	}
	
	$ntotal = ($totales-($totales*$ndesc));
	
	$str .="<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Subtotal</td><td class='textInputsBlack'>$".number_format($totales,'2','.',',')."</td></tr>
	
	<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Descuento</td><td class='textInputsBlack'>- $".number_format(($totales*$ndesc),'2','.',',')."</td></tr>";
	
		if($sumCorte > 0){
				
				$str .="<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Cortesias</td><td class='textInputsBlack'>- $".number_format($sumCorte,'2','.',',')."</td></tr>";
				
			$str .="<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Total</td><td class='textInputsBlack'>$".number_format($ntotal,'2','.',',')."</td></tr>
			";
			}else{
				
				$str .="<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Total</td><td class='textInputsBlack'>$".number_format($ntotal,'2','.',',')."</td></tr>";
			}


}elseif($desc == 0) {
	

	if($sumCorte > 0){
			
			$str .="<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Cortesias</td><td class='textInputsBlack'>- $".number_format($sumCorte,'2','.',',')."</td></tr>";
			
		$str .="<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Total</td><td class='textInputsBlack'>$".number_format($totales,'2','.',',')."</td></tr>
		";
		}else{
			
			$str .="<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Total</td><td class='textInputsBlack'>$".number_format($totales,'2','.',',')."</td></tr>";
		}

}else if($desc > 51 ){
	
	$ndesc = $desc;

$ntotal = ($totales-$ndesc);

$str .="<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Subtotal</td><td class='textInputsBlack'>$".number_format($totales,'2','.',',')."</td></tr>

<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Descuento</td><td class='textInputsBlack'>- $".number_format($ndesc,'2','.',',')."</td></tr>";

	if($sumCorte > 0){
			
			$str .="<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Cortesias</td><td class='textInputsBlack'>- $".number_format($sumCorte,'2','.',',')."</td></tr>";
			
		$str .="<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Total</td><td class='textInputsBlack'>$".number_format($ntotal,'2','.',',')."</td></tr>
		";
		}else{
			
			$str .="<tr><td  bgcolor='#FF6633' class='textNormalBlanco'>Total</td><td class='textInputsBlack'>$".number_format($ntotal,'2','.',',')."</td></tr>";
		}
	
}



$str .="</table>";

echo "$str";
	
}else if($id == 8){
	

																													
mysql_query("INSERT INTO fly_asoc VALUES ('','".$_GET['idr']."','".$_GET['clave']."','".$_GET['piloto']."','".$_GET['globo']."', '".$_GET['fv']."',NOW(),1   ) ") or die ("erro insrt flyAsoc <br>".mysql_error());


echo"<script>opener.location.reload(); window.close();</script>";

	
}else if($id == 9){
	/*change dates*/
	
	echo"<form method='post' name='changedate' onsubmit='return CD(this);'>
	<table align='center' width='100%'>
	<tr><td><img src='imgs/loguito.png'></td><td align='center' bgcolor='#FF6633' class='textNormalBlanco' >Cambios de Fecha en Vuelos</td></tr>
	<tr><td colspan='2' align='center'  bgcolor=\"#3674B2\" class=\"textNormalBlanco\" >VGA ".$_GET['c']."</td></tr>
	
	<tr ><td bgcolor='#FF6633' class='textNormalBlanco'>Nombre:</td><td class=\"textInputsBlack\" align='left'>".$_GET['np']."</td></tr>
	<tr ><td bgcolor='#FF6633' class='textNormalBlanco'>Fecha Actual:</td><td class=\"textInputsBlack\" align='left'>".$_GET['d']."</td></tr>
	
	<tr ><td bgcolor='#FF6633' class='textNormalBlanco'>Motivo</td><td class=\"textInputsBlack\" align='left'>
	
	<select name='motivo' class=\"textInputsBlack\">";
	
		
	echo"<option value='1' >Cambio Solicitado Por Cliente</option>
	<option value='2' >Cambio Solicitado Por La Empresa</option>
	";
	echo"</select>
	
	</td></tr>
	
	<tr  ><td  bgcolor='#FF6633' class='textNormalBlanco'>Fecha Tentativa:</td><td class=\"textInputsBlack\" align='left'>Indefinida<input type='checkbox' name='indef' value='1'><br>Definida:<input type=\"text\"  class=\"inputs\" name=\"checkin_n\" id=\"dateArrival\"
	onClick=\"javascript:popUpCalendar(this, changedate.dateArrival, 'yyyy-mm-dd');\" size=\"10\"  />
    <a HREF=\"#\"  onClick=\"javascript:popUpCalendar(this, changedate.dateArrival, 'yyyy-mm-dd');\">
    <img SRC=\"imgs/calendar.gif\" WIDTH=\"24\" HEIGHT=\"24\" border=0></a> </tr>
	
	<tr  ><td bgcolor='#FF6633' class='textNormalBlanco'>En caso de aplicar cargo adicional seleccionar el porcentaje</td><td class=\"textInputsBlack\" align='left'><select name=\"cargo\" />
	<option value='0'>0</option>
	<option value='05'>5%</option>
	<option value='10'>10%</option>
	<option value='15'>15%</option>
	<option value='20'>20%</option>
	<option value='25'>25%</option>
	<option value='30'>30%</option>
	<option value='35'>35%</option>
	
	</select></td></tr>
	
	<tr  ><td bgcolor='#FF6633' class='textNormalBlanco'>Comentarios</td><td class=\"textInputsBlack\" align='left'><textarea cols='30' rows='10' name='coments'></textarea></td></tr>
	
	<tr><td colspan='2' align='center'><input type='submit' name='CambiarFecha' value='CambiarFecha'></td></tr>
	<input type='hidden' value='".$_GET['c']."' name='code'>
	<input type='hidden' value='".$_GET['d']."' name='fecha_actual'>
	</table></form>
	";
	echo foot();

}else if($id == 10){
	/*change asociacion de vuelo*/
	
	//onsubmit='return CD(this);'
	$pilotos = mysql_query("SELECT id_piloto,concat(nombre,' ',apellido) FROM pilotos WHERE activo = 1");
	$globos = mysql_query("SELECT id_globo , concat(nombre,' ',capacidad_kg,'Kg') FROM globos WHERE activo = 1");
	
	
	


	
	$sql = mysql_query("select concat(r.nombre,' ',r.apellidos),rd.fecha_vuelo,sum(rd.ad+rd.kid),rd.peso FROM reservas r 
inner join reservas_det rd on (rd.id_reserva = r.id_reserva)
where r.id_reserva = ".$_GET['idr']." ");

	echo"<form method='post' name='changeasoc'>
	<table align='center' width='100%'>
	<tr><td><img src='imgs/loguito.png'></td><td align='center' bgcolor='#FF6633' class='textNormalBlanco' >Cambios de Asociacion a Vuelos</td></tr>
	<tr><td colspan='2' align='center'  bgcolor=\"#3674B2\" class=\"textNormalBlanco\" >VGA ".$_GET['clave']."</td></tr>
	
	<tr ><td bgcolor='#FF6633' class='textNormalBlanco'>Cliente:</td><td class=\"textInputsBlack\" align='left'>".mysql_result($sql,0,0)."</td></tr>
	<tr ><td bgcolor='#FF6633' class='textNormalBlanco'>Fecha De Vuelo:</td><td class=\"textInputsBlack\" align='left'>".mysql_result($sql,0,1)."</td></tr>
	
	<tr ><td bgcolor='#FF6633' class='textNormalBlanco'>PAX</td><td class=\"textInputsBlack\" align='left'>
	
	".mysql_result($sql,0,2)."</td></tr>
	
	<tr  ><td  bgcolor='#FF6633' class='textNormalBlanco'>Peso</td><td class=\"textInputsBlack\" align='left'>".mysql_result($sql,0,3)." </td></tr>
	
	
	<tr  ><td bgcolor='#FF6633' class='textNormalBlanco'>Piloto</td><td class=\"textInputsBlack\" align='left'><select name='piloto'> ";
	
	while($p = mysql_fetch_array($pilotos)){
		
		echo"<option value='$p[0]'>$p[1]</option>";
		
	}
	 echo"</select></td></tr>
	<tr  ><td bgcolor='#FF6633' class='textNormalBlanco'>Globo</td><td class=\"textInputsBlack\" align='left'>
	<select name=\"globo\">";
	
	while($sp = mysql_fetch_array($globos)){
		
		echo"<option value='$sp[0]'>$sp[1]</option>";
		
	}
	
	echo"</select>
	</td></tr>
	
	<tr><td colspan='2' align='center'><input type='submit' name='ActualizarAsociacion' value='ActualizarAsociacion'></td></tr>
	<input type='hidden' value='".$_GET['idva']."' name='code'>
	<input type='hidden' value='".$_GET['clave']."' name='clave'>
	</table></form>
	";
	
	echo foot();
} 

if(base64_decode($_POST['id']) == 11){
	
	$sql = mysql_query("SELECT r.id_reserva,r.clave,concat(r.nombre,' ',r.apellidos),rd.fecha_vuelo,id_fly_asoc
														   ,(SELECT tp.clave FROM tipos_vuelos tp
						where tp.id_tipos_vuelos =rd.id_tipos_vuelos ),rd.ad,rd.kid,peso
																				   FROM reservas r
						inner join reservas_det rd on (rd.id_reserva = r.id_reserva)
						left join fly_asoc f on (f.clave = r.clave)
						where rd.fecha_vuelo between '".$_POST['in']."' and '".$_POST['out']."' 
						and r.conciliado = 1
						order by rd.fecha_vuelo DESC");
	
	$count_as=0;
	$count_noas=0;
	while($row = mysql_fetch_array($sql)) {
		
		if(empty($row[4])){
			
			$count_noas++;
		}else{
			$count_as++;
		}
	}
	
	if($count_as == $count_noas){
		
		return "Se enviara la informacion a los pilotos";
		
	}else{
		return "Falta informacion no se puede enviar a los pilotos hasta terminar toda la asociacion ";
	}
}

?>
