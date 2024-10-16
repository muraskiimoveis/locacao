<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("BANCO_GERAL");
//include("regra.php");
		
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<body topmargin=0 leftmargin=0 rightmargin=0>
<br>
<?php

if(($B1 == "Apagar Tipo") and ($co_tipo != ""))
	{
	
	$query = "select * from contas where co_tipo = '$co_tipo' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	
	if($numrows > 0){
?>
<a class=style7>
Este tipo não pode ser apagado, existem contas vinculados a ele!<br></a>
<?php
  }
  else
  {
	$query = "delete from tipo_contas where t_cod = '$t_cod' and  cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>
<a class=style7>
Você apagou o tipo de conta.</a>
<?php
  }
	}
if($lista == "")
	{
		
	if(!$from){
	$from = intval($screen * 30);
	}
	//Início da pesquisa

	$query1 = "select * from tipo_contas where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by t_nome limit $from,30";
	//echo $query1;
	$result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table bgcolor="#<?php print("$cor3"); ?>" border="0" cellspacing="1" width=100%>
<tr><td bgcolor="#<?php print("$cor1"); ?>" align="center" class=style7 colspan=2>
Para excluir um Tipo de conta, clique sobre o nome correspondente a seguir.</td></tr>
<tr>
<td width=200 bgcolor="#<?php print("$cor1"); ?>" align="center"><b>Nome
</td>
<td bgcolor="#<?php print("$cor1"); ?>"></td>
</tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;
		
	if (($i % 2) == 1){ $fundo="$cor6"; }else{ $fundo="$cor1"; }
	$i++;
?>
<tr>
<td bgcolor="<?php print("$fundo"); ?>" align="left" class=style2>
<?php print("$not[t_nome]"); ?></td>
<td bgcolor="<?php print("$fundo"); ?>" align="left">
<a href="p_exc_tipo_contas.php?t_cod=<?php print("$not[t_cod]"); ?>&co_tipo=<?php print("$not[t_nome]"); ?>&B1=Apagar Tipo" class=link8>
Apagar Tipo</a></td>
</tr>
<?php
	}

	$query3 = "select count(t_cod) as contador from tipo_contas where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	
	while($not3 = mysql_fetch_array($result3))
	{
	$pages = ceil($not3[contador] / 30);
?>
                  <tr><td bgcolor="#<?php print("$cor3"); ?>" colspan=2>
                  <p align="center">
                  <i>Foram encontrados <?php print("$not3[contador]"); ?> tipos de contas</i></td></tr>
                  <tr><td bgcolor="#<?php print("$cor1"); ?>" class=style2 colspan=2>
                  <p align="center">
<?php
	if ($from > 30) {
	$url1 = $PHP_SELF . "?screen=" . ($screen - 1);
?>
                  <a href="javascript:history.back()" class=linkp><< Página anterior <<</a><br>
<?php
	}
	else
	{
?>
                  <a href="javascript:history.back()" class=linkp>
                  << Página anterior <<</a><br>
<?php
	}

	for ($j = 0; $j < $pages; $j++) {
  	$url2 = $PHP_SELF . "?screen=" . $j . "&campo=" . $campo . "&chave=" . $chave . "&pesq=" . $pesq;
  	//echo "   | <a href=\"$url2\">$j</a> |   ";
  	if($j == $screen){
  	echo "   | <a href=\"$url2\" class=linkp><b><font color=#ff0000>$j</b></a> |   ";
		}
  	else
  	{
  	echo "   | <a href=\"$url2\" class=linkp>$j</a> |   ";	
  	}
	}
	//echo $not3[contador];
	if ($from >= $not3[contador]) {
?>
		  <br>Última página da pesquisa
<?php
	}
	else
	{
	$url3 = $PHP_SELF . "?screen=" . ($screen + 1) . "&campo=" . $campo . "&chave=" . $chave . "&pesq=" . $pesq;
?>
                  <br><a href="<?php print("$url3"); ?>" class=linkp>>> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
<?php
	}
?>
<tr>
<td colspan=8 align=center class=style2><b>| <a href="javascript:close()" class=style2>Fechar</a> |</td>
</tr>
</table>
<p>
<?php
	}
?>
<?php
mysql_close($con);
?>
<?php
include("carimbo.php");
?>
</body>
</html>