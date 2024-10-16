<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include("style.php");
//include("data.php");
include("conect.php");
?>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">
	<?php
	$senha = addslashes($senha);
	$senha_web = addslashes($senha_web);

	if($acesso_web == "1"){
	
	$query0 = "select * from senha_web where s_senha='$senha_web'";
	$result0 = mysql_query($query0) or die("Não foi possível pesquisar suas informações.");
	$numrows = mysql_num_rows($result0);
	if($numrows > 0){
	
	while($not0 = mysql_fetch_array($result0))
	{
	
	$lib_web = "Sim";
	
	}
	}
	
	}

	if(($lib_web == "Sim") or ($acesso_web != "1")){

	$query0 = "select * from usuarios where u_senha='$senha'";
	$result0 = mysql_query($query0) or die("Não foi possível pesquisar suas informações.");
	$numrows = mysql_num_rows($result0);
	if($numrows > 0){
	
	while($not0 = mysql_fetch_array($result0))
	{
	//$query1 = "insert into login (email, data_hora, senha) 
	//values('$not0[u_email]', current_timestamp, '$senha')";
	//$result1 = mysql_query($query1) or die("Não foi possível inserir suas informações.");
	
	$valid_user = $not0[u_email];
	$u_tipo = $not0[u_tipo];
	$u_nome = $not0[u_nome];
	$u_cod = $not0[u_cod];
	session_register("valid_user");
	session_register("u_tipo");
	session_register("u_nome");
	session_register("u_cod");
	
	}
	}
	
	}	
	
include("topo.php");
?>
</td>
  </tr>
</table>
<?
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo"))){	
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
include("menu.php");
?></td>
  </tr>
</table>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" align="center">
	</td>
  </tr>
  <tr>
    <td align="center" valign="top"><?php
include("meio.php");
?></td>
  </tr>
</table>
<?
//	if($not0[u_tipo] == "cliente"){
?>
<!--Sistema ainda está em desenvolvimento!-->
<?php
/*
	}
	else
	{
*/
?>
<!--Cadastro inválido!-->
<?php
//	}
?>
<table width="900" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
<?php
	}
	else
	{
?>
 <?php
include("entrada.php");
?>
<?php
	}
?>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="900" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
      <?php
include("endereco.php");
?>
    </td>
  </tr>
</table>
</body>
</html>
