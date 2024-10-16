<?php
ini_set('max_execution_time','90');
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("REL_REF");
?>
<html>
<head>
<?php
include("style.php");

if($_POST['menu']){
  $menu = $_POST['menu'];
}elseif($_GET['menu']){
  $menu = $_GET['menu'];
}

?>
<link rel="stylesheet" type="text/css" href="carregador.css">
<script language="JavaScript" src="carregador.js"></script>
</head>
<body onLoad="__loadEsconde();">
<div id="carregador_pai">
	<div id="carregador">
		<div align="center">Aguarde carregando ...</div>
		<div id="carregador_fundo"><div id="barra_progresso"> </div></div>
	</div>
</div>
<link href="style.css" rel="stylesheet" type="text/css" />
<? if($menu==''){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">	
<? include("topo.php"); ?>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
include("menu.php");
?></td>
  </tr>
</table>
<? } ?>
<p>
<div align="center">
  <center>
                  <table width="500">
                  <tr><td colspan="3" bgcolor="#<?=$cor1 ?>" class="style1">
                  <p align="center"><a href="#" onclick="window.opener.location.href='p_insert_imoveis.php';window.close();" class="style1">
                  <b>Inserir Imóveis</b></a></td></tr>
                  <tr><td align="center"><a href="p_ref.php?menu=<?=$menu ?>" class="style1">
                  <b>Referências utilizadas</b></a></td></tr>
                  <tr><td colspan="3" bgcolor="#<?=$cor3 ?>" class="style1" align="center">
                  Estas são as referências que podem ser usadas</td></tr>
<?php
    $bref = mysql_query("SELECT ref FROM muraski WHERE ref!='x' AND ref!='' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY ref ASC");
	while($linha = mysql_fetch_array($bref)){
	  $refe[] = $linha['ref'];
	}
	  
 	  $numeros = $refe;
	  array_multisort($numeros, SORT_NUMERIC);
	  $intervalo = range(reset($numeros), end($numeros));
      $diferenca = array_diff($intervalo, $numeros);
      $referencias = implode('<br />', $diferenca); 
	  
?>
<tr bgcolor="#f2f2f2"><td class="style1">
<?php print($referencias); ?></td>
</tr></table>
<?
 
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
<?  if(session_is_registered("valid_user")){ ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<? if($menu==''){ ?>
<table width="900" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("voltar.php"); ?>
    </td>
  </tr>	
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("endereco.php"); ?>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td align="center" class="style1">
    <? include("bruc.php"); ?>
    </td>
  </tr>
</table>
<? } ?>
<? } ?>
</body>
</html>