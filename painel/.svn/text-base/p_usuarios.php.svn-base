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

if($B1 == "Inserir Usuário")
	{
	$u_email = AddSlashes($u_email);
	$u_senha = md5($u_senha);
	//$u_senha = base64_encode($u_senha);
	$u_nome = $_POST['u_nome'];
	
	$query = "insert into rebri_usuarios (u_email, u_senha, u_tipo, u_nome) 
	values('$u_email', '$u_senha', '$u_tipo1', '$u_nome')";
	$result = mysql_query($query,$con) or die("Não foi possível inserir suas informações.");
?>
<font color="#ff0000" size="2" face="Arial">
Você inseriu um novo usuário: <i><?php print("$u_email - $u_tipo"); ?>.</font>
<?php
	}
if($B1 == "Apagar Usuário")
	{

	$query = "delete from rebri_usuarios where u_cod = '$u_cod'";
	$result = mysql_query($query,$con) or die("Não foi possível apagar suas informações.");
?>
<font color="#ff0000" size="2" face="Arial">
Você apagou o usuário <i><?php print("$u_email - $u_tipo"); ?></i>.</font>
<?php
	}
if($B1 == "Atualizar Usuário")
	{
	$u_email = AddSlashes($u_email);
	$u_senha = md5($u_senha);
	$u_nome = $_POST['u_nome'];
	//$u_senha = base64_encode($u_senha);

	$query = "update rebri_usuarios set u_tipo='$u_tipo1', u_email='$u_email'
	, u_senha='$u_senha', u_nome='$u_nome' where u_cod='$u_cod'";
	$result = mysql_query($query,$con) or die("Não foi possível atualizar suas informações.");
?>
<font color="#ff0000" size="2" face="Arial">
Você atualizou o usuário <i><?php print("$u_email - $u_tipo"); ?></i>.</font>
<?php
	}
	
if($lista == "")
	{

	$query1 = "select * from rebri_usuarios order by u_email";
	$result1 = mysql_query($query1,$con) or die ("erro 73");
?>
<div align="center">
  <center>
<table bgcolor="#<?php print("$barra_lat"); ?>" border="0" cellspacing="1" width=610>
<tr><td bgcolor="#<?php print("$barra_lat"); ?>" colspan=4>
<p align="center"><b>
<a href="p_insert_usuario.php">Cadastrar novo usuário</a></b>
</td></tr>
<tr><td bgcolor="#<?php print("$cor1"); ?>" colspan=4 align="center" class=style7>
Para alterar ou excluir um usuário, clique sobre o nome correspondente a seguir.</b>
</td></tr>
<tr>
<td width=250 bgcolor="#<?php print("$cor6"); ?>" class=style2><b>
<p align="center">Nome</td>
<td width=250 bgcolor="#<?php print("$cor6"); ?>" class=style2><b>
<p align="center">E-mail</td>
<td width=200 bgcolor="#<?php print("$cor6"); ?>" class=style2><b>
<p align="center">Função</td>
<td width=70 bgcolor="#<?php print("$cor6"); ?>" class=style2><b>
<p align="center">Senha</td>
</tr>
<?php
	while($not = mysql_fetch_array($result1))
	{
	
	if($not[u_tipo] == "admin"){
	$u_tipo1 = "Administrador Geral";
	}
	else
	{
	$u_tipo1 = $not[u_tipo];
	}
?>
<tr>
<td bgcolor="#<?php print("$cor1"); ?>" class=style2>
<p align="center">
<?php
	if($not[u_email] != "paulo@bruc.com.br"){
?>
<a href="p_usuarios.php?lista=1&u_cod=<?php print("$not[u_cod]"); ?>" class=style2>
<?php
	}
?>
<?php print("$not[u_nome]"); ?></a></td>
<td bgcolor="#<?php print("$cor1"); ?>" class=style2>
<p align="center">
<?php
	if($not[u_email] != "paulo@bruc.com.br"){
?>
<a href="p_usuarios.php?lista=1&u_cod=<?php print("$not[u_cod]"); ?>" class=style2>
<?php
	}
?>

<?php print("$not[u_email]"); ?></a></td>
<td bgcolor="#<?php print("$cor1"); ?>" class=style2>
<p align="center">
<?php
	if($not[u_email] != "paulo@bruc.com.br"){
?>
<a href="p_usuarios.php?lista=1&u_cod=<?php print("$not[u_cod]"); ?>" class=style2>
<?php
	}
?>

<?php print("$u_tipo1"); ?></a></td>
<td bgcolor="#<?php print("$cor1"); ?>" class=style2>
<p align="center">
<?php
	if($not[u_email] != "paulo@bruc.com.br"){
?>
<a href="p_usuarios.php?lista=1&u_cod=<?php print("$not[u_cod]"); ?>" class=style2>
<?php
	}
?>

******</a></td>
<?php
	}
?>
</tr></table>
<?php
	}
	else
	{
	$query2 = "select * from rebri_usuarios 
	where u_cod = '$u_cod'";
	$result2 = mysql_query($query2,$con) or die ("erro 161");
	while($not2 = mysql_fetch_array($result2))
	{

	if($not2[u_tipo] == "admin"){
	$u_tipo1 = "Administrador Geral";
	}
	elseif($not2[u_tipo] == "func"){
	$u_tipo1 = "Funcionário";
	}
	else
	{
	$u_tipo1 = "Cliente";
	}

if(!IsSet($editar))
	{
?>
<p align="center"><b>Editar ou Apagar Usuários</b></font></p>
 <div align="center">
  <center>
  <form method="post" action="<?php print("$PHP_SELF"); ?>">
  <input type="hidden" value="<?php print("$not2[u_cod]"); ?>" name="u_cod">
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td width="20%" class=style2><b>Nome do usuário:</b></font></td>
      <td width="80%" class=style2> <input type="text" class="campo" name="u_nome" size="40" value="<?php print("$not2[u_nome]"); ?>"></font></td>
    </tr>
    <tr>
      <td width="20%" class=style2><b>E-mail do usuário:</b></font></td>
      <td width="80%" class=style2> <input type="text" class="campo" name="u_email" size="40" value="<?php print("$not2[u_email]"); ?>"></font></td>
    </tr>
    <tr>
      <td width="20%" class=style2><b>Senha do usuário:</b></font></td>
      <td width="80%" class=style2> <input type="password" class="campo" name="u_senha" size="6" value="" maxlength="6" onKeyUp="return autoTab(this, 6, event);">OBS.: 6 dígitos</font></td>
    </tr>
    <tr>
      <td width="20%" class=style2><b>Tipo de usuário:</b></font></td>
      <td width="80%" class=style2> <select name="u_tipo1" class="campo">
      <option value="<?php print("$not2[u_tipo]"); ?>"><?php print("$u_tipo1"); ?>
      <option value="admin">Administrador Geral
      <option value="func">Funcionário
      </select></font></td>
    </tr>
    <tr>
      <td width="20%">
      <input type="hidden" value="1" name="editar">
      <input type="submit" value="Atualizar Usuário" name="B1" class=campo></font></td>
      <td width="80%"><input type="submit" value="Apagar Usuário" name="B1" class=campo></td>
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
mysql_close($con);
?>
<?php
include("carimbo.php");
?>
</td></tr></table>
</body>
</html>