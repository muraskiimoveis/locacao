<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
?>
<html>
<head>
<?php
include("style.php");
include("conect.php");
include("l_funcoes.php");
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
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/	  
?>
<p>
<?php

if(!$from){
	$from = 0;
}

if($lista == "")
	{

	if($list == ""){
	$query1 = "select cod, ref, tipo, metragem, valor, finalidade 
	from muraski where tipo='$tipo1' and finalidade='$finalidade' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by ref limit $from, 30";
	}else{
	if($campo == "data_fim"){
	$ano = substr ($chave, 6, 4);
	$mes = substr($chave, 3, 2 );
	$dia = substr ($chave, 0, 2 );
	$chave = "$ano-$mes-$dia";
	//print("$chave");
	}
	
	$query1 = "select * from muraski where $campo like '%$chave%' and finalidade='$finalidade' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
	order by ref";
	}
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
?>
<div align="center">
  <center>
                  <table width="500" cellpadding="1" cellspacing="1" bgcolor="#ffffff">
                  <tr><td colspan="4" bgcolor="#000080">
                  <font face="Arial" size="2" color="#ffffff">
                  <p align="right"><b>
                  <i><?php print("$tipo1"); ?></i></b></td></tr>
                  <tr bgcolor="#ffffff"><td><font face="Arial" size="2" color="#000080">
                  <b>Ref.</b></td><td>
                  <font face="Arial" size="2" color="#000080">
                  <b>Metragem</b></td><td>
                  <font face="Arial" size="2" color="#000080">
                  <b>Valor</b></td><td>
                  <font face="Arial" size="2" color="#000080">
                  <b>Finalidade</b></td></tr>
<?php
	if($numrows1 > 0){
?>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;

	$valor = number_format($not[valor], 2, ',', '.');
	
	if (($i % 2) == 1){ $fundo="DCE0E4"; }else{ $fundo="EDEEEE"; }
	$i++;
?>
<tr bgcolor="<?php print("$fundo"); ?>"><td>
<font color="#000080" size="2" face="Arial">
<a href="p_edit_imoveis.php?cod=<?php print("$not[cod]"); ?>&edit=editar"><?php print("$not[ref]"); ?></a></font></td><td>
<font color="#000080" size="2" face="Arial">
<?php print("$not[metragem]"); ?></td><td>
<font color="#000080" size="2" face="Arial">
<?php print("$valor"); ?></td><td>
<font color="#000080" size="2" face="Arial">
<?php print("$not[finalidade]"); ?></font></td></tr>
<?php
	}
	}
	
	if($list == ""){
	$query2 = "select count(cod) as contador 
	from muraski where tipo='$tipo1' and finalidade='$finalidade' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}else{
	$query2 = "select count(cod) as contador 
	from muraski where $campo like '%$chave%' and finalidade='$finalidade' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
                  <tr><td colspan="4" bgcolor="#000080">
                  <font face="Arial" size="2" color="#ffffff">
                  <p align="center">
                  <i>Foram encontrados <?php print("$not2[contador]"); ?> imóveis</i></td></tr>
<?php
	if($from >= $not2[contador]){
?>
                  <tr bgcolor="#ffffff"><td colspan="2">
                  <font face="Arial" size="2" color="#ff0000">
                  <p align="center">
                  <a href="javascript:history.back()">
                  << Página anterior <<</a></td><td colspan="2">
                  <font face="Arial" size="2" color="#ff0000">
                  <p align="center">
                  Última página da pesquisa</td></tr>
<?php
	}
	else
	{
?>
                  <tr bgcolor="#ffffff"><td colspan="2">
                  <font face="Arial" size="2" color="#ff0000">
                  <p align="center">
                  <a href="javascript:history.back()">
                  << Página anterior <<</a></td><td colspan="2">
                  <font face="Arial" size="2" color="#ff0000">
                  <p align="center">
                  <a href="p_lista_edit.php?from=<?php print("$from"); ?>&campo=<?php print("$campo"); ?>&tipo1=<?php print("$tipo1"); ?>&chave=<?php print("$chave"); ?>&finalidade=<?php print("$finalidade"); ?>&list=<?php print("$list"); ?>">
                  >> Próxima página >></a></td></tr>
<?php
	}
?>
	</table>
	</center>
	</div>
<?php
	}
	}
/*
mysql_free_result($result1);
mysql_free_result($result2);
*/
mysql_close($con);
?>
<?php
/*
	}
	else
	{
*/	  
?>
<!--Área protegida!-->
<?php
//	}
?>
</body>
</html>