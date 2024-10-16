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

	$sql = mysql_query("SELECT observacoes FROM muraski WHERE cod='".$_GET['cod']."' AND cod_imobiliaria='".$codi."'");
	while($linha = mysql_fetch_array($sql)){
		$observacoes = str_replace("\n", "<br>", $linha['observacoes']);
	}
?>
<body>
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
	<tr height="50">
    	<td colspan="6">
      		<p align="center" class="style48"><b>Observa&ccedil;&otilde;es</b></p>
    	</td>
	</tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%" class="style1"><b>Observa&ccedil;&otilde;es:</b></td>
      <td width="80%" class="style1"><?=$observacoes; ?></td>
    </tr>
</table>
<?
mysql_close($con);
?>
</body>
</html>