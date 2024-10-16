<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("PESQ_ATEND_CLI");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
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
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/		
?>
<p>
<div align="center">
  <center>
  <form method="get" action="p_int.php">
  <table width="500" border="0" cellpadding="1" cellspacing="1" bgcolor="#EDEEEE">
    <tr bgcolor="#ffffff" class="style1">
      <td width="100%" colspan=2><p align="center"><b>Interessados</b><br>
      Preencha o nome do interessado que deseja pesquisar</font></p></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%" class="style1"><b>Palavra Chave:</b></td>
      <td width="80%" class="style1"><input type="text" class="campo" name="i_nome" size="40"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%" class="style1"><b>Campo de pesquisa:</b></td>
      <td width="80%" class="style1"><select size="1" name="campo" class="campo">
      <option value="i_nome">Nome</option>
      <option value="i_obs">Texto da Obs</option>
      <option value="i_tel">Telefone</option>
      <option value="i_ref">Referência do Imóvel</option>
      </select></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td width="20%">
      <input type="hidden" value="1" name="list">
      <input type="hidden" value="" name="lista">
      <input type="submit" value="Pesquisar Interessado" name="B1" class="campo3"></td>
      <td width="80%"></td>
    </tr>
  </table>
  </form>
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