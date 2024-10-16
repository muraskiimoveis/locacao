<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("REL_INTERESSADOS");
?>
<html>

<head>
<?php
include("style.php");
?>
</head>
<body>
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
<table border="0" cellpadding="1" cellspacing="1" width="75%" align="center">
  <tr>
    <td>
<div align="center">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr height="50">
	<td colspan=4 class="style1"><p align="center"><b>Relatório de Interessados no imóvel</b><br />Para alterar ou excluir um interessado, clique sobre o nome correspondente a seguir.</p></td>
</tr>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/		
?>
<?php
	$hoje = date("Y-m-d");
	//print("$hoje");
	
	if(!$from){
		$from = intval($screen * 10);
	}	

if($lista == "")
	{
?>
<div align="center">
  <center>
<table border="0" cellspacing="1" width="100%">
<?php
	$query3 = "SELECT * FROM muraski WHERE cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);

	while($not3 = mysql_fetch_array($result3))
	{
?>
<tr><td colspan=4 class="fundoTabela style1">
<p align="left"><b>Ref.: <?php print("$not3[ref]"); ?></p>
</td></tr>
<?php
	}

	$query1 = "select it.p_data, it.interessado, i.i_nome, i.i_status, i.i_obs, i.i_cod, im.im_nome, im.im_cod, u.u_nome from imoveis_temp it left join interessados i on i.i_cod=it.interessado 
	left join rebri_imobiliarias im on i.cod_imobiliaria=im.im_cod inner join usuarios u on i.i_corretor=u.u_cod inner join muraski m on it.cod=m.cod where it.cod='$cod' order by it.p_data desc 
	limit $from, 30";
	//echo $query1;
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
?>
<tr class="fundoTabelaTitulo">
<td width=300 class="style1" align="center"><b>Nome</td>
<td width=150 class="style1" align="center"><b>Data/Status</td>
<td width=250 class="style1" align="center"><b>Obs</td>
</tr>
<?php
	$i = 1;

	if($numrows1 > 0){
	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;
	$im_cod = $not['im_cod'];
	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
?>
<tr>
<td class="<?php print("$fundo"); ?> style1" align="left">
<?
if($im_cod<>$_SESSION['cod_imobiliaria']){ 
   echo $not[u_nome]." - ".$not['im_nome'];
}else{
?>
<a href="p_int.php?lista=1&i_cod=<?php print("$not[i_cod]"); ?>&codi=<?=$not['im_cod'] ?>" class="style1">
<?
   echo $not[i_nome];
?>
</a>
<?
}
?>
</td>
<?php
	$anoi = substr ($not[p_data], 0, 4);
	$mesi = substr($not[p_data], 5, 2 );
	$diai = substr ($not[p_data], 8, 2 );
?>
<td align="left" class="<?php print("$fundo"); ?> style1">
<? if($im_cod<>$_SESSION['cod_imobiliaria']){ ?>
<?php print("$diai/$mesi/$anoi - $not[i_status]"); ?>
<? }else{ ?>
<a href="p_int.php?lista=1&i_cod=<?php print("$not[i_cod]"); ?>&codi=<?=$not['im_cod'] ?>" class="style1">
<?php print("$diai/$mesi/$anoi - $not[i_status]"); ?></a>
<? } ?>
</td>
<td align="left" class="<?php print("$fundo"); ?> style1">
<? if($im_cod<>$_SESSION['cod_imobiliaria']){ ?>
<?php
	$i_obs = substr ($not[i_obs], 0, 40);
	
	print("$i_obs");

?>...
<? }else{ ?>
<a href="p_int.php?lista=1&i_cod=<?php print("$not[i_cod]"); ?>&codi=<?=$not['im_cod'] ?>" class="style1">
<?php
	$i_obs = substr ($not[i_obs], 0, 40);
	
	print("$i_obs");

?>...</a>
<? } ?>
</td>
<?php
	}
	}
	
	$query2 = "select count(it.cod) as contador from imoveis_temp it left join interessados i on i.i_cod=it.interessado 
	left join rebri_imobiliarias im on i.cod_imobiliaria=im.im_cod inner join usuarios u on i.i_corretor=u.u_cod inner join muraski m on it.cod=m.cod where it.cod='$cod'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2[contador] / 30);
?>
                  <tr><td colspan="4" class="fundoTabelaTitulo style1">
                  <p align="center"><b>Foram encontrados <?php print("$not2[contador]"); ?> interessados</b></td></tr>
                  <tr><td colspan="4" bgcolor="#<?php print("$cor1"); ?>" class="style1">
                  <p align="center">
<?php
	if ($from > 30) {
	$url1 = "vendas2.php?screen=" . ($screen - 1) . "&tipo=" . $tipo . "&finalidade=" . $finalidade;
?>
                  <a href="javascript:history.back()" class="style1"><< Página anterior <<</a>
<?php
	}
	else
	{
?>
                  <a href="javascript:history.back()" class="style1">
                  << Página anterior <<</a>
<?php
	}

	for ($i = 0; $i < $pages; $i++) {
  	$url2 = "p_rel_int.php?screen=" . $i . "&cod=" . $cod;
  	echo "   | <a href=\"$url2\" class=style1>$i</a> |   ";
	}

	if ($from >= $not2[contador]) {
?>
		  Última página da pesquisa
<?php
	}
	else
	{
	$url3 = "p_rel_int.php?screen=" . ($screen + 1) . "&cod=" . $cod;
?>
                  <a href="<?php print("$url3"); ?>" class="style1">>> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
<?php
	}
	}
?>
</table>
</td></tr></table>
<?php
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
</body>
</html>