<?php
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
</head>
<body>
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
<?php
	if ($screen == "") {
   		$screen = 1;
	}

	$from = ($screen - 1) * 30;
	
	$query1 = "select controle_chave from muraski where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and ref!='x' and ref!='' and controle_chave!=0 order by controle_chave desc limit $from, 30";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<div align="center">
  <center>
                  <table width="75%" cellspacing="0" cellpadding="0">
                  <tr height="50">
                  	<td colspan="4" bgcolor="#<?=$cor1 ?>" class="style1">
                  		<p align="center"><a href="p_insert_imoveis.php" onClick="window.opener.location.href='p_insert_imoveis.php';window.close();" class="style1">
                  		<b>Inserir Imóveis</b></a><br /><a href="p_controle_novo.php?menu=<?=$menu ?>" class="style1">
                  		<b>Controle de chaves não utilizados</b></a>
                  	</td>
                  </tr>
                  <tr class="fundoTabelaTitulo">
                  	<td colspan="4" class="style1" align="center"><b>Estes são os controle de chaves cadastrados até o momento</b></td>
                  </tr>
<?php
	$i = 0;

	while($not = mysql_fetch_array($result1))
	{

	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	
?>
<tr class="<?php print("$fundo"); ?>"><td class="style1" colspan="4">
<?php print("$not[controle_chave]"); ?></td>
</tr>
<?php
	}

	$query3 = "select count(cod) as contador 
	from muraski where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and ref!='x' and ref!='' and controle_chave!=0";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
?>
<?php
	$paginas = $pages = ceil($not3[contador] / 30);
    $pagina = $screen;
    $url = "p_controle_usado.php?menu=".$menu."&screen=";
?>
                  <tr class="fundoTabelaTitulo">
				  	<td colspan="4" class="style1" align="center"><b>Foram encontrados <?php print("$not3[contador]"); ?> controles de chaves</b></td>
				  </tr>
                  <tr>
				  	<td colspan="4" bgcolor="#<?php print("$cor1"); ?>" class="style1" align="center">
						<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_controle_usado.php?menu=<?=$menu ?>&screen=1" class="style7"><? if ($screen > 1) { ?>|Primeira|<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_controle_usado.php?menu=<?=$menu ?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>|Anterior|<? } ?></a></td>
                  				<td class="style1" align="center">
								<?
   									$i = 0;
   									$completa = "";
   									if ($paginas > 9){
      									if ($pagina < 5){
   	   										$inicio = 1;
         									$final = 9;
      									}elseif($pagina > $paginas - 5){
   	   										$inicio = $paginas - 9;
         									$final = $paginas;
      									}else{
   	   										$inicio = $pagina - 4;
         									$final = $pagina + 4;
      									}
   									}else{
	   										$inicio = 1;
      										$final = $paginas;
   									}

   									for ($j = $inicio; $j < ($final+1); $j++){
      									if(($paginas > 9) && (strlen($j)==1)){
		   									$j = "0".$j;
      									}

      									$url2 = $url . $j;

      									if($j == $pagina){
            								print "<a href=\"$url2\" class='style1'>|<b>$j</b>|</a>";
 	   									}else{
     	      								print "<a href=\"$url2\" class='style1'>|$j|</a>";
  	   									}
   									}
								?>
                  				</td>
                  				<td width="10%" class="style1" align="center"><a href="p_controle_usado.php?menu=<?=$menu ?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>|Próxima|<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_controle_usado.php?menu=<?=$menu ?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>|Última|<?}?></a></td>
               				</tr>
   						</table>

<?php
	}
?>

<?php
	}

//mysql_free_result($result1);
//mysql_free_result($result2);
//mysql_free_result($result3);
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
<table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
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