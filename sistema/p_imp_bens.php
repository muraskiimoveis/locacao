<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_VEND");
verificaArea("GERAL_LOCA");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
	<style media="print">
		.noprint { display: none }
	</style>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
if ($_GET['codi']) {

   $codi = $_GET['codi'];

} else {

   $codi = $_POST['codi'];

}

if ($codi == $_SESSION['cod_imobiliaria']) {

   $codi = $_SESSION['cod_imobiliaria'];

} else {

   $codi = $codi;

}
/*
$query20 = "select muraski.contador, muraski.cliente from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$codi."'";
$result20 = mysql_query($query20);
$numrows20 = mysql_num_rows($result20);
while ($not2 = mysql_fetch_array($result20)) {

   $contador = $not2[contador];
   $cod_cliente = $not2[cliente];
   $cliente1 = explode("--", $not2[cliente]);
   $cliente2 = str_replace("-","",$cliente1);

}
$cod_cliente2 = " (";

for ($i3 = 1; $i3 <= $contador; $i3++) {

   if ($i3==1) {
      $cod_cliente2 .= "c_cod='".$cliente2[$i3-1]."'";
   } else {
      $cod_cliente2 .= " or c_cod='".$cliente2[$i3-1]."'";
   }
}
$cod_cliente2 .= ")";
*/
$query2 = "select relacao_bens, ref, titulo from muraski where cod = '$cod' and cod_imobiliaria='".$codi."'";

$result2 = mysql_query($query2);
$numrows2 = mysql_num_rows($result2);
if($numrows2 > 0) {
   while ($not2 = mysql_fetch_array($result2)) {
      $relacao_bens = str_replace("\n", "<br>", $not2[relacao_bens]);

      $dia2 = date(d);
      $mes2 = date(m);
      $ano2 = date(Y);
?>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="95%">
  <tr height="50">
    	<td colspan="6">
      		<p align="center" class="style48"><b>Relação de bens do imóvel</b></p>
    	</td>
  </tr>
  <tr class="fundoTabela">
  	<td colspan=2 class=style1 align="left"><b>Relação de bens do imóvel Ref.:</b> <?php print("$not2[ref]"); ?> - <?php print strip_tags($not2[titulo]); ?></td>
  </tr>
  <tr>
  	<td colspan=2 class=style1 align="left"><br /><br /><?php print("$relacao_bens"); ?></td>
  </tr>
  </table>
<?php
	}
}
mysql_close($con);
?>
<?php
/*
	}
	else
	{
*/
?>
<?php
//include("login2.php");
?>
<?php
//	}
?>
<br>
<div class=noprint>
	<tr>
	  <td colspan="2"><div align="center"><span class="stylec">
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	  </span></div></td>
    </tr>
</div>
</body>
</html>