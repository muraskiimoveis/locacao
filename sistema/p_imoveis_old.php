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
if($B1 == "Apagar Definitivamente")
	{

	$query4 = "select * from muraski where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
	while($not4 = mysql_fetch_array($result4))
	{

	for ($i = 0; $i < 21; $i++) {
	$foto = $not4[ref] . "_" . ($i). ".jpg";
	if (file_exists("/rede/www/html/img_not/$foto"))
	{
	unlink("/rede/www/html/img_not/$foto");
	}
	}

	}
	}
	$query = "delete from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>
<p align="center"><font color="#ff0000" size="2" face="Arial">
Você apagou definitivamente o imóvel Ref.: <i><?php print("$ref"); ?></i>.</font></p>
<?php
	}

if($B1 == "Apagar Imóvel")
	{

	$query4 = "select * from muraski where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
	while($not4 = mysql_fetch_array($result4))
	{

	for ($i = 0; $i < 21; $i++) {
	$foto = $not4[ref] . "_" . ($i). ".jpg";
	if (file_exists("/rede/www/html/img_not/$foto"))
	{
	unlink("/rede/www/html/img_not/$foto");
	}
	}

	}
	}
	$query = "update muraski set ref='x' where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>
<p align="center"><font color="#ff0000" size="2" face="Arial">
Você apagou o imóvel Ref.: <i><?php print("$ref"); ?></i>.</font></p>
<?php
	}
if($B1 == "Atualizar Imóvel")
	{
	
	$titulo = AddSlashes($titulo);
	$desc = AddSlashes($descricao);
	$permuta_txt = AddSlashes($permuta_txt);
	$img_peq = "$ref" . "_peq.jpg";
	$img_1 = "$ref" . "_1.jpg";
	$img_2 = "$ref" . "_2.jpg";
	$img_3 = "$ref" . "_3.jpg";
	$img_4 = "$ref" . "_4.jpg";
	$img_5 = "$ref" . "_5.jpg";
	$img_6 = "$ref" . "_6.jpg";
	$img_7 = "$ref" . "_7.jpg";
	$img_8 = "$ref" . "_8.jpg";
	$img_9 = "$ref" . "_9.jpg";
	$img_10 = "$ref" . "_10.jpg";
	$ftxt_1 = AddSlashes($ftxt_1);
	$ftxt_2 = AddSlashes($ftxt_2);
	$ftxt_3 = AddSlashes($ftxt_3);
	$ftxt_4 = AddSlashes($ftxt_4);
	$ftxt_5 = AddSlashes($ftxt_5);
	$ftxt_6 = AddSlashes($ftxt_6);
	$ftxt_7 = AddSlashes($ftxt_7);
	$ftxt_8 = AddSlashes($ftxt_8);
	$ftxt_9 = AddSlashes($ftxt_9);
	$ftxt_10 = AddSlashes($ftxt_10);
	$ftxt_11 = AddSlashes($ftxt_11);
	$ftxt_12 = AddSlashes($ftxt_12);
	$ftxt_13 = AddSlashes($ftxt_13);
	$ftxt_14 = AddSlashes($ftxt_14);
	$ftxt_15 = AddSlashes($ftxt_15);
	$ftxt_16 = AddSlashes($ftxt_16);
	$ftxt_17 = AddSlashes($ftxt_17);
	$ftxt_18 = AddSlashes($ftxt_18);
	$ftxt_19 = AddSlashes($ftxt_19);
	$ftxt_20 = AddSlashes($ftxt_20);
	$data_inicio = "$ano-$mes-$dia";
	$data_fim = "$ano1-$mes1-$dia1";

	$query = "update muraski set ref='$ref', 
	tipo='$tipo1', metragem='$metragem', 
	n_quartos='$n_quartos', valor='$valor', especificacao='$especificacao', 
	suites='$suites', piscina='$piscina', titulo='$titulo', descricao='$desc'
	, img_peq='$img_peq', img_1='$img_1', img_2='$img_2', img_3='$img_3', img_4='$img_4'
	, img_5='$img_5', img_6='$img_6', img_7='$img_7', img_8='$img_8', img_9='$img_9'
	, img_10='$img_10', local='$local', permuta='$permuta', finalidade='$finalidade'
	, permuta_txt='$permuta_txt', ftxt_1='$ftxt_1', ftxt_2='$ftxt_2' 
	, ftxt_3='$ftxt_3' , ftxt_4='$ftxt_4' , ftxt_5='$ftxt_5' 
	, ftxt_6='$ftxt_6' , ftxt_7='$ftxt_7' , ftxt_8='$ftxt_8' 
	, ftxt_9='$ftxt_9' , ftxt_10='$ftxt_10', ftxt_11='$ftxt_11'
	, ftxt_12='$ftxt_12', ftxt_13='$ftxt_13', ftxt_14='$ftxt_14'
	, ftxt_15='$ftxt_15', ftxt_16='$ftxt_16', ftxt_17='$ftxt_17'
	, ftxt_18='$ftxt_18', ftxt_19='$ftxt_19', ftxt_20='$ftxt_20'
	, cliente='$cliente', matricula='$matricula', cidade_mat='$cidade_mat'
	, end='$end', averbacao='$averbacao', acomod='$acomod'
	, dist_mar='$dist_mar', dist_tipo='$dist_tipo', limpeza='$limpeza'
	, diaria1='$diaria1', diaria2='$diaria2', data_inicio='$data_inicio'
	, data_fim='$data_fim', comissao='$comissao', dias='$dias'
	, carnaval='$carnaval', anonovo='$anonovo' where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
?>
<p align="center"><font color="#ff0000" size="2" face="Arial">
Você atualizou o imóvel Ref.: <i><?php print("$ref"); ?></i>.</font></p>
<?php
	}

	$query1 = "select distinct tipo, finalidade 
	from muraski where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by tipo";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<div align="center">
  <center>
                  <table width="500">
                  <tr><td colspan="3" bgcolor="#DCE0E4">
                  <font face="Arial" size="2" color="#ffffff">
                  <p align="center"><a href="p_pesq_imoveis.php">
                  Pesquisar Imóveis</a></td></tr>
                  <tr><td colspan="3" bgcolor="#000080">
                  <font face="Arial" size="2" color="#ffffff">
                  <p align="center">
                  Estes são os imóveis cadastrados até o momento</td></tr>
                  <tr><td><font face="Arial" size="2" color="#000080">
                  <b>Tipo</b></td><td>
                  <font face="Arial" size="2" color="#000080">
                  <b>Finalidade</b></td><td>
                  <font face="Arial" size="2" color="#ff0000">
                  <b>Quantidade</b></td></tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{

	if (($i % 2) == 1){ $fundo="DCE0E4"; }else{ $fundo="EDEEEE"; }
	$i++;
?>
<tr bgcolor="<?php print("$fundo"); ?>"><td>
<font color="#000080" size="2" face="Arial">
<a href="p_lista_edit.php?tipo1=<?php print("$not[tipo]"); ?>&finalidade=<?php print("$not[finalidade]"); ?>">
<?php print("$not[tipo]"); ?></a></font></td><td>
<font color="#000080" size="2" face="Arial">
<?php print("$not[finalidade]"); ?></td><td>
<font color="#ff0000" size="2" face="Arial">
<?php
	$query2 = "select count(tipo) as q_tipo 
	from muraski where tipo='$not[tipo]' and finalidade='$not[finalidade]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by tipo";
	$result2 = mysql_query($query2);
	
	while($not2 = mysql_fetch_array($result2))
	{
	print("$not2[q_tipo]");
	}
?>
</font></td></tr>
<?php
	}

	$query3 = "select count(cod) as q_cod 
	from muraski where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	
	while($not3 = mysql_fetch_array($result3))
	{
?>
                  <tr><td colspan="3" bgcolor="#000080">
                  <font face="Arial" size="2" color="#ffffff">
                  <p align="center">
                  Total de <b><?php print("$not3[q_cod]"); ?></b> imóveis.</td></tr>
	</table>
	</center>
	</div>
<?php
	}
	}
/*
mysql_free_result($result1);
mysql_free_result($result2);
mysql_free_result($result3);
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