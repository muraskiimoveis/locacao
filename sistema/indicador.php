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
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
</head>
<?php

	$sql = mysql_query("SELECT indicador FROM muraski WHERE cod='".$_GET['cod']."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
	while($linha = mysql_fetch_array($sql)){
		$cod_indicador = $linha['indicador'];
	}
	
	$queryI = mysql_query("SELECT c_nome FROM clientes WHERE c_cod='".$cod_indicador."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
	while($notI = mysql_fetch_array($queryI)){
	   $indicador = $notI[c_nome];
	}
?>
<body>
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
               <td colspan=3 align=center class=style1>
                  <p align="center"><b>Indicação</b></p>
               </td>
            </tr>
    
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Indicador:</b></td>
      <td width="80%" class="style1"><?=$cod_indicador; ?> - <?=$indicador; ?></td>
    </tr>
	</table>
<?
mysql_close($con);
?>
</body>
</html>