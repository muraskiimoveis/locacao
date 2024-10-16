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
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1"> 
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

if($B1 == "Inserir Tipo")
	{

	$tc_nome = AddSlashes($tc_nome);
	
	$query4 = "select * from rebri_tipo_comercio where tc_nome='$tc_nome'";
	$result4 = mysql_query($query4,$con) or die ("erro 34");
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
		echo "<a class=style7><b>Este tipo de comércio já foi cadastrado.</b></a>";
	}else{

	$query0 = "insert into rebri_tipo_comercio (tc_nome) values('$tc_nome')";
	//print "$query0";
	$result0 = mysql_query($query0,$con) or die("Não foi possível inserir suas informações.");
    mysql_query($query0, $con_site);
    mysql_query($query0, $con_sistema);
?>
<font color="#ff0000" size="2" face="Verdana">
Você inseriu um novo Tipo de Comércio.
<?php
	}
	}
?>
<?php
if($B1 == "Apagar Tipo")
	{
			
	$query = "delete from rebri_tipo_comercio where tc_cod = '$tc_cod'";
	$result = mysql_query($query,$con) or die("Não foi possível apagar suas informações.");
    mysql_query($query, $con_site);
    mysql_query($query, $con_sistema);
?>
<font color="#ff0000" size="2" face="Verdana">
Você apagou o Tipo Comércio <i><?php print("$tc_nome"); ?></i>.
<?php
	
	}
if($B1 == "Atualizar Tipo")
	{

	$query = "update rebri_tipo_comercio set tc_nome='$tc_nome' where tc_cod='$tc_cod'";
	$result = mysql_query($query,$con) or die("Não foi possível atualizar suas informações.");
    mysql_query($query, $con_site);
    mysql_query($query, $con_sistema);
?>
<font color="#ff0000" size="2" face="Arial">
Você atualizou o Tipo Comércio <i><?php print("$tc_nome"); ?></i>.</font>
<?php
	}
	
if($lista == "")
	{
	$query3 = "select * from rebri_tipo_comercio order by tc_nome ASC";
	$result3 = mysql_query($query3,$con) or die ("erro 88");
	$numrows3 = mysql_num_rows($result3);
	if($numrows3 > 0){
?>
<div align="center">
  <center>
<table bgcolor="#<?php print("$cor3"); ?>" border="0" cellspacing="1" width=300>
<tr><td bgcolor="#<?php print("$barra_lat"); ?>">
<p align="center"><b>
<a href="p_insert_tipo_comercio.php" class=style2>Cadastrar novo tipo comércio</a></b>
</td></tr>
<tr><td bgcolor="#ffffff" align="center" class=style7>
Para alterar ou excluir um tipo, clique sobre o nome correspondente a seguir.</b>
</td></tr>
<tr>
<td width=350 bgcolor="#ffffff" align="center" class="style2"><b>Título
</td>
</tr>
<?php
	$i = 1;
	
	while($not3 = mysql_fetch_array($result3))
	{
		if (($i % 2) == 1){ $fundo="$cor6"; }else{ $fundo="ffffff"; }
		$i++;
?>
<tr>
<td bgcolor="<?php print("$fundo"); ?>" align="left">
<a href="p_tipos_comercio.php?lista=1&tc_cod=<?php print("$not3[tc_cod]"); ?>" class="style2">
<?php print("$not3[tc_nome]"); ?></a></td>
</tr>
<?php
	}
?>
</table>
<?php
	}
	}
	else
	{
	$query2 = "select * from rebri_tipo_comercio where tc_cod = '$tc_cod'";
	$result2 = mysql_query($query2,$con) or die ("erro 129");
	while($not2 = mysql_fetch_array($result2))
	{

if(!IsSet($editar))
	{
?>
<p align="center"><b>Rebri -- Editar ou Apagar Tipos Comércio</b></p>
 <div align="center">
  <center>
  <form method="post" action="<?php print("$PHP_SELF"); ?>">
  <input class=campo type="hidden" name="tc_cod" value="<?php print("$not2[tc_cod]"); ?>">
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td align="left" width="10%"><b>Tipo Comércio:</b></td>
      <td align="left" width="90%"> <input class=campo type="text" name="tc_nome" size="40" value="<?php print("$not2[tc_nome]") ?>"></td>
    </tr>
    <tr>
      <td width="10%"> <input class=campo type="hidden" value="1" name="editar"><input class=campo type="submit" value="Atualizar Tipo" name="B1"></td>
      <td width="90%"> <input class=campo type="submit" value="Apagar Tipo" name="B1">
      </td>
    </tr>
  </table>
  </center></div>
  </form>
<?php
	}
	}
	}
?>
<?php
include("carimbo.php");
mysql_close($con);
mysql_close($con_site);
mysql_close($con_sistema);
?>
</td></tr></table>
</body>
</html>