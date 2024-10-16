<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_VEND");
verificaArea("GERAL_LOCA");
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<?php
if($_GET['codi']){
 $codi = $_GET['codi'];
}else{
 $codi = $_POST['codi'];
}

if($codi == $_SESSION['cod_imobiliaria']){
  $codi = $_SESSION['cod_imobiliaria'];
}else{
  $codi = $codi;
}

	$sql = mysql_query("SELECT comissao_parceria FROM muraski WHERE cod='".$_GET['cod']."' AND cod_imobiliaria='".$codi."'");
	while($linha = mysql_fetch_array($sql)){
		if($linha['comissao_parceria']!='30' && $linha['comissao_parceria']!='40' && $linha['comissao_parceria']!='50'){
		  $comissao_parceria = $linha['comissao_parceria'];
		}else{
		  $comissao_parceria = $linha['comissao_parceria'];
		}
	}
?>
<body>
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
    	<td colspan="6">
      		<p align="center" class="style48"><b>Comissão Parceria</b></p>
    	</td>
	</tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%" class="style1"><b>Comissão Parceria:</b></td>
      <td width="80%" class="style1"><?=$comissao_parceria; ?>%</td>
    </tr>
</table>
<?
mysql_close($con);
?>
</body>
</html>