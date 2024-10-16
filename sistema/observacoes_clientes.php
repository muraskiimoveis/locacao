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
verificaArea("REL_CLIENTES");
verificaArea("CLIENT_GERAL");
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<?php

	$sql = mysql_query("SELECT c_obs FROM clientes WHERE c_cod='".$_GET['cod']."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
	while($linha = mysql_fetch_array($sql)){
		$observacoes = $linha['c_obs'];
	}
?>
<body>
  <table width="450" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td width="141" class="style1"><b>Observa&ccedil;&otilde;es:</b></td>
      <td width="602" class="style1"><?=$observacoes; ?></td>
    </tr>
</table>
<?
mysql_close($con);
?>
</body>
</html>