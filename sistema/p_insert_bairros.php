<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_BAIRRO");
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
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
?>
 <p align="center" class="style1"><b>Inserir Bairros</b><br>
 <a href="p_bairros.php" class="style1">
 Clique para visualizar a relação de bairros</a></p>
  <form method="post" name="form1" onSubmit="return valida();" action="p_bairros.php">
  <table border="0" cellspacing="1" width="600">
    <tr>
      <td width="20%" class=style1><b>Bairro:</b></td>
      <td width="80%" class=style1> <input type="text" name="b_bairro" size="40" class="campo"></td>
    </tr>
    <tr>
      <td width="20%">
      <input type="submit" value="Inserir Bairro" name="B1" class=campo3></td>
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
<!--Área protegida!-->
<?php
//	}
?>
</body>
</html>