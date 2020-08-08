<?
session_start();
ini_set("date.timezone", "America/Mexico_City");

include('lib/func.inc.php');
Get_Conn();

if(base64_decode($_GET['LOUT'])){
	
	@mysql_query("UPDATE log_login SET date_logut = NOW() WHERE id_log_login  '".$_SESSION['ids']."' ");
		session_unset();
		session_destroy();
		header("Location: index.php");
		
	}
	$now = time();
	if ($now > $_SESSION['expire']) {
		@mysql_query("UPDATE log_login SET date_logut = NOW() WHERE id_log_login  '".$_SESSION['ids']."' ");
            session_destroy();
			echo"<script>alert('La Sesion Ha expirado, Ingresa de Nuevo'); window.location.href='index.php';</script>";
            
        }



//echo date_default_timezone_get() ;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Formato de Captura Clientes Volar en Globo</title>
<link href="css/stylo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

<script type="text/javascript" src="js/func.js" language="javascript"></script>
<script>
$(document).ready(function(){
	cargar_paises();
	$("#pais").change(function(){dependencia_estado();});
	$("#estado").change(function(){dependencia_ciudad();});
	$("#estado").attr("disabled",true);
	$("#ciudad").attr("disabled",true);
});

function cargar_paises()
{
	$.get("lib/cargar-paises.php", function(resultado){
		if(resultado == false)
		{
			alert("Error");
		}
		else
		{
			$('#pais').append(resultado);			
		}
	});	
}
function dependencia_estado()
{
	var code = $("#pais").val();
	$.get("lib/dependencia-estado.php", { code: code },
		function(resultado)
		{
			if(resultado == false)
			{
				alert("Error");
			}
			else
			{
				$("#estado").attr("disabled",false);
				document.getElementById("estado").options.length=1;
				$('#estado').append(resultado);			
			}
		}

	);
}

function dependencia_ciudad()
{
	var code = $("#estado").val();
	$.get("lib/dependencia-ciudades.php?", { code: code }, function(resultado){
		if(resultado == false)
		{
			alert("Error");
		}
		else
		{
			$("#ciudad").attr("disabled",false);
			document.getElementById("ciudad").options.length=1;
			$('#ciudad').append(resultado);			
		}
	});	
	
}

 function numbers(evt)
      {
        var keyPressed = (evt.which) ? evt.which : event.keyCode
        return !(keyPressed > 31 && (keyPressed < 48 || keyPressed > 57));
      }
	  
	  function subpop(s) {
 addWindow = window.open(s,"cal","width=270,height=190,resizable=0,status=1,menubar=0,scrollbars=0,fullscreen=0,left=200,top=150");

}
function justNumbers(e) {
var keynum = window.event ? window.event.keyCode : e.which;
if ( keynum == 8 ) return true;
return /\d/.test(String.fromCharCode(keynum));
}

$(function(){
 $("#snd_pilots").click(function(){
 var url = "pop.php"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#form_send_pilots").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               $("#respuesta").html(data); // Mostrar la respuestas del script PHP.
           }
         });

    return false; // Evitar ejecutar el submit del formulario.
 });
});
</script>
<script type="text/javascript" src="js/date_time.js"></script>
<style>
body
{
background-image:url('imgs/bg_acua.png');
background-repeat:repeat-y;
background-repeat:repeat;
}

</style>
<style type="text/css">
	.badge1 {
		position:relative;
	}
	.badge1[data-badge]:after {
		content:attr(data-badge);
		position:absolute;
		top:-10px;
		right:-10px;
		font-size:.7em;
		font-family:Verdana, Geneva, sans-serif;
		background:green;
		color:white;
		width:18px;height:18px;
		text-align:center;
		line-height:18px;
		border-radius:50%;
		box-shadow:0 0 1px #333;
	}
    </style>
</head>

<body>

<table width="100%" height="100%">

<tr><td colspan="3" width="100%" align="center">
<? #echo top_foot(); ?>
<? echo superior($_SESSION['USER_ID']); ?>
</td></tr>

<tr><td align="center" width="100" valign="top"><? echo  BuildMenu($_SESSION['USER_ID']); ?></td> 

<!--<td style="background-image:url(imgs/linever.png); background-repeat:repeat-y;" width="5">&nbsp;</td>-->

<td bgcolor="#00FFFF">&nbsp;</td>

 <td  width="90%" valign="top" align="left"> &nbsp; 
<script language='javascript' src="popcalendar.js"></script>
<?
 $i = base64_decode($_GET['i']);
if($i == 1){

	echo CapturaNuevo($idu,$_GET['find_mail']);

}else if($i ==2){	
	
	echo reservas_consulta($_GET['code'],$_GET['in'],$_GET['out'],$i,$_GET['name_cl'],$_GET['mail'],$_GET['tipo_rep'],$iduserlogin);
}else if($i == 7){
	
	echo capturar_pagos($i,$_GET['in'],$_GET['out'],$_GET['code'],$_GET['ncl'],$_GET['mail'],$iduserlogin);

}else if($i == 5){
	
	echo users();

}else if($i == 3){
	
	echo conciliar_pagos($i,$_GET['in'],$_GET['out'],$_GET['code'],$_GET['mail']);

}else if($i == 8){
	
	 echo RelVlo($i,$_GET['in'],$_GET['out'],$_GET['code']);

}else if($i == 4){
	
	/*echo Cofirm_fly($id_r,$id_r);*/
	echo reservas_consulta($_GET['code'],$_GET['in'],$_GET['out'],$i,$_GET['name_cl'],$_GET['mail'],$_GET['tipo_rep'],$iduserlogin);
}else if($i == 9 ){
	
	echo CapIni($i,$t);

}else if($i == 10){
	
/*Reporte de Vuelos por alerta */	
echo "Vuelos Por Alerta <br>";
echo reservas_consulta($code,$in,$out,$i,$nm,$mail,$tipo_rep,$_SESSION['USER_ID']);

}else if($i == 11){
	
/*Reporte de Vuelos por alerta */	
echo "Vuelos Por Alerta confirmados <br>";
echo capturar_pagos($i,$_GET['in'],$_GET['out'],$_GET['code'],$_GET['ncl'],$_GET['mail'],$_SESSION['USER_ID']);

}else if ($i == 12){
	
$sql = mysql_query("SELECT  clave, fecha_anterior,fecha_nueva,coment FROM log_change_dates 
where date(dateadd) = date(now())
and id_user = ".$_SESSION['USER_ID']."
");	

echo"<table width='100%' align='center' bgcolor=\"#FFFFFF\">
	<tr><td colspan='10' align='center' bgcolor=\"#3674B2\" class=\"textNormalBlanco\">Vuelos Reprogramados Hoy</td><td><i>Registros Encontrados $nr</i></td></tr>
	<tr  align='center' bgcolor='#FF6633' class='textNormalBlanco'><td>#</td><td>Codigo</td><td>Fecha de vuelo anterior</td><td>Fecha de Vuelo Nueva</td><td>Comentario</td></tr>";
	
	//<td>".pagos($row[0])."</td>
		$interger = 0;
		while($row = mysql_fetch_array($sql)){
		$interger += 1;
		echo"<tr class=\"textInputsBlack\" align=\"center\">
		<td>$interger</td>
		<td>$row[0]</td>
		<td>$row[1]</td>
		<td>$row[2]</td>
		<td>$row[3]</td>
		</tr>";
		}
		echo"</table>";
}


?>

</td></tr>


</table>







<br />
<table width="100%">
<tr>
<td width="35%" height="30%" bgcolor="#3674B2">&nbsp;</td>

<td width="5%"  height="30%" bgcolor="#FFFF00">&nbsp;</td>
<td width="5%"  height="30%" bgcolor="#FF6633">&nbsp; </td>
<td width="5%" height="30%" bgcolor="#FF0000">&nbsp;</td>
<td width="5%" height="30%" bgcolor="#660000">&nbsp;</td>

<td width="35%" height="30%" bgcolor="#3674B2" align="right" class="formLogin3">Powered by spawneditions.com 2012</td>
</tr>
</table>

</body>
</html>
<?
echo"<input type=\"hidden\" id=\"inputcode\" name=\"inputcode\" >";
//echo"<script>
//alert(document.getElementById('inputcode').value);
/*</script>
 ";*/
?>
<!--<DIV align=center><b><font face="Arial" size="2" color="#0000FF">
<SPAN
id=clock>
<SCRIPT language=JavaScript>
<!-- Begin
var dayarray=new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var montharray=new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
function getthedate(){
	var mydate=new Date()
	var year=mydate.getYear()
	if (year < 1000)
	year+=1900
	var day=mydate.getDay()
	var month=mydate.getMonth()
	var daym=mydate.getDate()
	if (daym<10)
	daym=""+daym
	var hours=mydate.getHours()
	var minutes=mydate.getMinutes()
	var seconds=mydate.getSeconds()
	var dn="AM"
	if (hours>=12)
	dn="PM"
	if (hours>12){
	hours=hours-12
}
{
d = new Date();
Time24H = new Date();
Time24H.setTime(d.getTime() + (d.getTimezoneOffset()*60000) + 3600000);
}
if (hours==0)
hours=12
if (minutes<=9)
minutes="0"+minutes
if (seconds<=9)
seconds="0"+seconds
//change font size here
var cdate=dayarray[day]+" "+daym+" de "+montharray[month]+" de "+year+" &nbsp;&nbsp;&nbsp; "+hours+":"+minutes+":"+seconds+" "+dn+""
if (document.all)
document.all.clock.innerHTML=cdate
else if (document.getElementById)
document.getElementById("clock").innerHTML=cdate;
else
document.write(cdate)
}
if (!document.all&&!document.getElementById)
getthedate()
function goforit(){
if (document.all||document.getElementById)
setInterval("getthedate()",1000)
}
window.onload=goforit
// End 
</SCRIPT>
</SPAN></font></b></DIV>-->