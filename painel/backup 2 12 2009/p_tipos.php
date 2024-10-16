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

if($B1 == "Inserir Tipo")
	{

	$t_nome = AddSlashes($t_nome);
	
	$query4 = "select * from rebri_tipo where t_nome='$t_nome'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
		echo "<a class=style7><b>Este tipo já foi cadastrado.</b></a>";
	}else{
	
	$query0 = "insert into rebri_tipo (t_nome) values('$t_nome')";
	//print "$query0";
	$result0 = mysql_query($query0) or die("Não foi possível inserir suas informações.");
?>
<font color="#ff0000" size="2" face="Verdana">
Você inseriu um novo Tipo.
<?php
	}
	}
?>
<?php
if($B1 == "Apagar Tipo")
	{
	$query4 = "select * from muraski where tipo='$t_cod'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
		echo "<a class=style7><b>Este tipo não pode ser apagado pois existem imóveis ligados a ele.</b></a>";
	}else{
			
	$query = "delete from rebri_tipo where t_cod = '$t_cod'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>
<font color="#ff0000" size="2" face="Verdana">
Você apagou o Tipo <i><?php print("$t_nome"); ?></i>.
<?php
	}
	}
if($B1 == "Atualizar Tipo")
	{

	$query = "update rebri_tipo set t_nome='$t_nome' where t_cod='$t_cod'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
?>
<font color="#ff0000" size="2" face="Arial">
Você atualizou o Tipo <i><?php print("$t_nome"); ?></i>.</font>
<?php
	}
	
if($lista == "")
	{
	$query3 = "select * from rebri_tipo order by t_nome asc";
	$result3 = mysql_query($query3);
	$numrows3 = mysql_num_rows($result3);
	if($numrows3 > 0){
?>
<div align="center">
  <center>
<table bgcolor="#<?php print("$cor3"); ?>" border="0" cellspacing="1" width=300>
<tr><td bgcolor="#<?php print("$barra_lat"); ?>">
<p align="center"><b>
<a href="p_insert_tipo.php" class=style2>Cadastrar novo tipo</a></b>
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
<a href="p_tipos.php?lista=1&t_cod=<?php print("$not3[t_cod]"); ?>" class="style2">
<?php print("$not3[t_nome]"); ?></a></td>
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
	$query2 = "select * from rebri_tipo	where t_cod = '$t_cod'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{

if(!IsSet($editar))
	{
?>
<p align="center"><b>Rebri -- Editar ou Apagar Tipos</b></p>
 <div align="center">
  <center>
  <form method="post" action="<?php print("$PHP_SELF"); ?>">
  <input class=campo type="hidden" name="t_cod" value="<?php print("$not2[t_cod]"); ?>">
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td align="left" width="10%"><b>Tipo:</b></td>
      <td align="left" width="90%"> <input class=campo type="text" name="t_nome" size="40" value="<?php print("$not2[t_nome]") ?>"></td>
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
?>
</td></tr></table>
</body>
</html>