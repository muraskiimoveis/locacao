<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_CARACT");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/	  
?>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
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
<br>
<?php
	if(!$from){
		$from = intval($screen * 30);
	}
?>
<?php
if($B1 == "Inserir Característica")
	{
	$c_caracteristica = AddSlashes($c_caracteristica);

	$query = "insert into caracteristicas (cod_imobiliaria, c_caracteristica) values('".$_SESSION['cod_imobiliaria']."','$c_caracteristica')";
	$result = mysql_query($query) or die("Não foi possível inserir suas informações. $query");
	
?>
<p align="center" class="style1">
Você inseriu a caracter&iacute;stica <?php print("$c_caracteristica"); ?>.</p>
<?php
	}
if($B1 == "Apagar Característica")
	{

	$query = "delete from caracteristicas where c_id = '$c_id' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>
<span class="style1">
Você apagou a caracter&iacute;stica <?php print("$c_caracteristica"); ?></span>.
<?php
	}
if($B1 == "Atualizar Característica")
	{
	$c_caracteristica = AddSlashes($c_caracteristica);

	$query = "update caracteristicas set c_caracteristica='$c_caracteristica' where c_id='$c_id' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	//echo $query;
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
?>
<span class="style1">
Você atualizou a caracter&iacute;stica <?php print("$c_caracteristica"); ?></span>.
<?php
	}
	
if($lista == "")
	{

	$query1 = "select * from caracteristicas where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c_caracteristica limit $from, 40";
	//echo $query1;
	$result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table bgcolor="#FFFFFF" border="0" cellspacing="1">
<tr><td bgcolor="#FFFFFF" colspan=4 class="style1">
<p align="center"><b>
<a href="p_insert_caracteristicas.php" class=style1>Cadastrar nova caracter&iacute;stica </a></b>
</td></tr>
<tr><td bgcolor="#<?php print("$cor1"); ?>" colspan=4 class="style1">
<p align="center">
Para alterar ou excluir uma caracter&iacute;stica, clique sobre o nome correspondente a seguir.</b>
</td></tr>
<tr>
<td width=200 bgcolor="#<?php print("$cor6"); ?>" class=style1><b>Código</td>
<td width=200 bgcolor="#<?php print("$cor6"); ?>" class=style1><b>Caracter&iacute;stica</td>
</tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo="$cor6"; }else{ $fundo="$cor14"; }
	$i++;
?>
<tr>
<td bgcolor="#<?php print("$fundo"); ?>" class="style1"><p align="left">
<a href="p_caracteristicas.php?lista=1&c_id=<?php print("$not[c_id]"); ?>" class=style1>
<?php print("$not[c_id]"); ?></a></td>
<td bgcolor="#<?php print("$fundo"); ?>" class="style1">
<p align="left">
<a href="p_caracteristicas.php?lista=1&c_id=<?php print("$not[c_id]"); ?>" class=style1>
<?php print("$not[c_caracteristica]"); ?></a></td>
<?php
	}
	
	$query2 = "select count(c_id) as contador from caracteristicas where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2[contador] / 30);
?>
                  <tr><td colspan="4" bgcolor="#<?php print("$cor1"); ?>" class=style1>
                  <p align="center">
                  Foram encontrados <?php print("$not2[contador]"); ?> caracter&iacute;sticas </td></tr>
                  <tr><td colspan="4" bgcolor="#<?php print("$cor1"); ?>" class=style1>
                  <p align="center">
<?php
	if ($from > 30) {
	//$url1 = "vendas2.php?screen=" . ($screen - 1) . "&tipo=" . $tipo . "&finalidade=" . $finalidade;
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
  	$url2 = $PHP_SELF . "?screen=" . $i;
  	echo "   | <a href=\"$url2\" class=\"style1\">$i</a> |   ";
	}

	if ($from >= $not2[contador]) {
?>
		  Última página da pesquisa
<?php
	}
	else
	{
	$url3 = $PHP_SELF . "?screen=" . ($screen + 1);
?>
                  <a href="<?php print("$url3"); ?>" class="style1">>> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
<?php
	}
?>
</table>
<?php
/*
mysql_free_result($result1);
mysql_free_result($result2);
*/
	}
	else
	{
	$query2 = "select * from caracteristicas 
	where c_id = '$c_id' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{

if(!IsSet($editar))
	{
?>
<p align="center" class=style1><b>Editar ou Apagar caracter&iacute;sticas </b></p>
 <div align="center">
  <center>
  <table border="0" cellspacing="1" width="600">
  <form method="post" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
  <input type="hidden" value="<?php print("$not2[c_id]"); ?>" name="c_id">
    <tr>
      <td width="20%" class=style1><b>Caracter&iacute;stica:</b></td>
      <td width="80%" class=style1> <input type="text" name="c_caracteristica" class="campo" size="40" value="<?php print("$not2[c_caracteristica]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%">
      <input type="hidden" value="1" name="editar">
      <input type="submit" value="Atualizar Característica" name="B1" class=campo3></td>
      <td width="80%"><input type="submit" value="Apagar Característica" name="B1" class=campo></td>
    </tr>
    </form>
  </table>
  </center></div>
<?php
	}
	}
	}
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
</body>
</html>