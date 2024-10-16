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
?>
</head>
<?php
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	($u_tipo == "admin")){
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

	mysql_connect("$hostname", "$username", "$password") or die("Não consegui comunicar com o Banco de Dados");
	mysql_select_db("$db");

if($B1 == "Inserir Usuário")
	{
	$u_nome1 = AddSlashes($u_nome1);
	$u_email = AddSlashes($u_email);
	$u_senha = AddSlashes($u_senha);
	$foto = $_POST['foto'];
	
	$data = date("Y-m-d");
	$hora = date("H-i-s");
	
	$foto = $data."-".$hora;
	
	$query = "insert into usuarios (u_nome, u_email, u_senha, u_tipo, u_foto) 
	values('$u_nome1', '$u_email', '$u_senha', '$u_tipo1', '".$foto."')";
	$result = mysql_query($query) or die("Não foi possível inserir suas informações.");
?>
Você inseriu um novo usuário: <?php print("$u_nome1"); ?> - <?php print("$u_email - $u_tipo"); ?>.
<?php
	}
if($B1 == "Apagar Usuário")
	{

	$query = "delete from usuarios where u_cod = '$u_cod'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>
Você apagou o usuário <?php print("$u_nome"); ?> - <?php print("$u_email - $u_tipo"); ?>.
<?php
	}
if($B1 == "Atualizar Usuário")
	{
	$u_nome1 = AddSlashes($u_nome1);
	$u_email = AddSlashes($u_email);
	$u_senha = AddSlashes($u_senha);

	$query = "update usuarios set u_nome='$u_nome1', u_tipo='$u_tipo1', u_email='$u_email'
	, u_senha='$u_senha' where u_cod='$u_cod'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
?>
Você atualizou o usuário <?php print("$u_nome1"); ?> - <?php print("$u_email - $u_tipo"); ?>.
<?php
	}
	
if($lista == "")
	{
	
	$query1 = "select * from usuarios order by u_nome";
	$result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table bgcolor="#EDEEEE" border="0" cellspacing="1">
<tr><td bgcolor="#ffffff" colspan=4 class="style1">
<p align="center"><b>
<a href="p_insert_usuario.php" class="style1">Cadastrar novo usuário</a></b>
</td></tr>
<tr><td bgcolor="#ffffff" colspan=4 class="style1">
<p align="center">
Para alterar ou excluir um usuário, clique sobre o nome correspondente a seguir.</b>
</td></tr>
<tr bgcolor="#EDEEEE">
<td width=200 class="style1">
<p align="center"><b>Nome do usuário</b></td>
<td width=200 class="style1">
<p align="center"><b>E-mail</b></td>
<td width=200 class="style1">
<p align="center"><b>Função</b></td>
<td width=100 class="style1">
<p align="center"><b>Senha</b></td>
</tr>
<?php
	while($not = mysql_fetch_array($result1))
	{
	
	if($not[u_tipo] == "admin"){
	$u_tipo1 = "Administrador Geral";
	}
	elseif($not[u_tipo] == "func"){
	$u_tipo1 = "Funcionário";
	}
	else
	{
	$u_tipo1 = "Cliente";
	}
?>
<tr>
<td bgcolor="#ffffff" class="style1"><p align="center">
<?php
	if($not[u_email] != "paulo@bruc.com.br"){
?>
<a href="p_usuarios.php?lista=1&u_cod=<?php print("$not[u_cod]"); ?>" class="style1">
<?php
	}
?>
<?php print("$not[u_nome]"); ?></a></td>
<td bgcolor="#ffffff" class="style1">
<p align="center">
<?php
	if($not[u_email] != "paulo@bruc.com.br"){
?>
<a href="p_usuarios.php?lista=1&u_cod=<?php print("$not[u_cod]"); ?>" class="style1">
<?php
	}
?>
<?php print("$not[u_email]"); ?></a></td>
<td bgcolor="#ffffff" class="style1">
<p align="center">
<?php
	if($not[u_email] != "paulo@bruc.com.br"){
?>
<a href="p_usuarios.php?lista=1&u_cod=<?php print("$not[u_cod]"); ?>" class="sytle1">
<?php
	}
?>
<?php print("$u_tipo1"); ?></a></td>
<td bgcolor="#ffffff" class="style1">
<p align="center">
<?php
	if($not[u_email] != "paulo@bruc.com.br"){
?>
<a href="p_usuarios.php?lista=1&u_cod=<?php print("$not[u_cod]"); ?>" class="style1">
<?php
	}
?>

<?php
	if($u_tipo=="admin"){
?>
******
<?php
	}
	else
	{
?>
******
<?php
	}
?>
</a></td>
<?php
	}
	}
	else
	{
	$query2 = "select * from usuarios 
	where u_cod = '$u_cod'";
	$result2 = mysql_query($query2);
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
<p align="center" class="style1"><b>Editar ou Apagar Usuários</b></p>
 <div align="center">
  <center>
  <form method="post" action="<?php print("$PHP_SELF"); ?>">
  <input type="hidden" value="<?php print("$not2[u_cod]"); ?>" name="u_cod">
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td width="20%" class="style1"><b>Nome do usuário:</b></td>
      <td width="80%" class="style1"> <input type="text" class="campo" name="u_nome1" size="40" value="<?php print("$not2[u_nome]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class="style1"><b>E-mail do usuário:</b></td>
      <td width="80%" class="style1"><input type="text" class="campo" name="u_email" size="40" value="<?php print("$not2[u_email]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class="style1"><b>Senha do usuário:</b></td>
      <td width="80%" class="style1"><input type="password" class="campo" name="u_senha" size="6" value="<?php print("$not2[u_senha]"); ?>" maxlength="6" onKeyUp="return autoTab(this, 6, event);">OBS.: 6 dígitos</td>
    </tr>
    <tr>
      <td width="20%" class="style1"><b>Tipo de usuário:</b></td>
      <td width="80%" class="sytle1"><select name="u_tipo1" class="campo">
      <option value="<?php print("$not2[u_tipo]"); ?>"><?php print("$u_tipo1"); ?>
      <option value="admin">Administrador Geral
      <option value="func">Funcionário
      <option value="cliente">Cliente</select></td>
    </tr>
    <tr>
      <td width="20%">
      <input type="hidden" value="1" name="editar">
      <input type="submit" value="Atualizar Usuário" name="B1" class="campo"></td>
      <td width="80%"><input type="submit" value="Apagar Usuário" name="B1" class="campo"></td>
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
	}
	else
	{
?>
<?php
include("login2.php");
?>
<?php
	}
?>
</body>
</html>