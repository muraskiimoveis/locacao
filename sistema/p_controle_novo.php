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
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
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
<div align="center">
  <center>
                  <table width="75%" cellspacing="0" cellpadding="0">
                  <tr height="50">
                  	<td colspan="3" class="style1">
                  		<p align="center"><a href="p_insert_imoveis.php" onClick="window.opener.location.href='p_insert_imoveis.php';window.close();" class="style1"><b>Inserir Imóveis</b></a><br /><a href="p_controle_usado.php?menu=<?=$menu ?>" class="style1"><b>Controle de chaves utilizados</b></a></p>
                  	</td>
                  </tr>
                  <tr class="fundoTabelaTitulo">
                  	<td colspan="3" class="style1" align="center"><b>Estas são os controle de chaves que podem ser usados</b></td>
                  </tr>
<?php
    $j = 0;
    $bcontrole = mysql_query("SELECT controle_chave FROM muraski WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND ref!='x' AND ref!='' AND controle_chave!=0 ORDER BY controle_chave ASC") OR die("erro 1506 - ".mysql_error());
if(mysql_num_rows($bcontrole) > 0){	
	while($linha = mysql_fetch_array($bcontrole)){
	  $contr[] = $linha['controle_chave'];
	}
	  
    $numeros = $contr;
	$i = 1;
	$ok = "n";
	$fim_pesquisa = max($numeros);
	if ($fim_pesquisa > 5000) {
		$fim_pesquisa = 5000;
	}
	while ($ok == "n") {
		if (!in_array($i,$numeros)) {
			$chave_livre[] = $i;
		}
		if ($i == $fim_pesquisa) {
			$ok = "s";
		}
		$i++;
	}  
}
?>

<?
foreach ($chave_livre as $chave) {
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
?>
	<tr class="<?php echo $fundo; ?>">
		<td class="style1"><?php echo $chave; ?><br></td>
	</tr>
<?php } ?>
</table>
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