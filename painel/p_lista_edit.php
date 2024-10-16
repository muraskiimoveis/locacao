<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

include("regra.php");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<body topmargin=0 leftmargin=0 rightmargin=0>
<table width=100% height=100%>
<tr><td bgcolor="<?php print("$barra_lat"); ?>" valign=top width=150>
<?php
include("menu_painel.php");
?></td>
<td width=620 valign=top>
<br>
<?php
include("conect.php");
?>
<?php

	if(!$screen){
	$screen = 1;
	}

	if(!$from){
	$from = intval(($screen - 1) * 30);
	}

	$query1 = "select * from rebri_fornecedores, rebri_cat_fornecedor 
	where f_categoria='$f_categoria' and f_categoria=ca_cod 
	order by f_nome 
	limit $from, 30";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<div align="center">
  <center>
                  <table width="600" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
                  <tr><td colspan="6" bgcolor="#<?php print("$cor5"); ?>">
                  <p align="center"><b>
                  <i><?php print("$ca_nome"); ?></i></b></p></td></tr>
                  <tr><td>
                  <b>Empresa</b></td><td>
                  <b>Contato</b></td><td>
                  <b>Doc.</b></td><td>
                  <b>Cidade</b></td><td>
                  <b>Estado</b></td><td>
                  <b>Estatísticas</b></td></tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo="DCE0E4"; }else{ $fundo="EDEEEE"; }
	$i++;
?>
<tr bgcolor="<?php print("$fundo"); ?>"><td width="16%" class=style2>
<a href="p_fornecedores.php?f_cod=<?php print("$not[f_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[f_empresa]"); ?></a></td><td width="16%" class=style2>
<a href="p_fornecedores.php?f_cod=<?php print("$not[f_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[f_nome]"); ?></a></td><td width="16%" class=style2>
<a href="p_fornecedores.php?f_cod=<?php print("$not[f_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[f_doc]"); ?></a></td><td width="16%" class=style2>
<a href="p_fornecedores.php?f_cod=<?php print("$not[f_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[cidade]"); ?></a></td><td width="18%" class=style2>
<a href="p_fornecedores.php?f_cod=<?php print("$not[f_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[estado]"); ?></a></td><td width="18%" class=style2>
<a href="p_stats_fornecedores.php?f_cod=<?php print("$not[f_cod]"); ?>" class=style2>Visualisar</a></td>
</tr>
<?php
	}
	
	$query2 = "select count(f_cod) as contador 
	from fornecedores where f_categoria='$f_categoria'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
	$pages = ceil($not2[contador] / 30);
?>
                  <tr><td colspan="6" bgcolor="#<?php print("$cor5"); ?>">
                  
                  <p align="center">
                  <i>Foram encontrados <?php print("$not2[contador]"); ?> fornecedores</i></td></tr>
                  <tr><td colspan=4 align=center class=style2>
<?php
	if ($from > 30) {
	$url1 = $PHP_SELF . "?screen=" . ($screen - 1) . "&f_categoria=" . $f_categoria . "&f_finalidade=" . $f_finalidade;
?>
                  <a href="javascript:history.back()" class=style2>
                  << Página anterior <<</a>
<?php
	}
	else
	{
?>
                  <a href="javascript:history.back()" class=style2>
                  << Página anterior <<</a>
<?php
	}

	for ($i = 1; $i <= $pages; $i++) {
		if($pesq == ""){
  	$url2 = $PHP_SELF . "?screen=" . $i . "&f_categoria=" . $f_categoria;
		}
		else
		{
  	$url2 = $PHP_SELF . "?screen=" . $i . "&categoria=" . $categoria;
		}
  	if($i == $screen){
  	echo "   | <a href=\"$url2\"><b><font color=#ff0000>$i</b></a> |   ";
	}
  	else
  	{
  	echo "   | <a href=\"$url2\" class=style2>$i</a> |   ";	
  	}
	}

	if ($from >= $not2[contador]) {
?>
		  
		  Última página da pesquisa
<?php
	}
	else
	{
		if($pesq == ""){
  	$url3 = $PHP_SELF . "?screen=" . ($screen + 1) . "&f_categoria=" . $f_categoria;
		}
		else
		{
  	$url3 = $PHP_SELF . "?screen=" . ($screen + 1) . "&categoria=" . $categoria;
		}
?>
                  <a href="<?php print("$url3"); ?>" class=style2>
                  >> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
<?php
	}
?>
	</table>
	</center>
	</div>
<?php
	}
//mysql_close($con);
?>
<?php
include("carimbo.php");
mysql_close($con);
?>
</td></tr></table>
</body>
</html>