<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("DOCS");
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php

if($_GET['idl']){
  $id = $_GET['idl'];
}elseif($_GET['idv']){
  $id = $_GET['idv']; 
}


	$alteracao = mysql_query("SELECT d_nome, d_txt FROM doc WHERE d_id='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($alteracao)){
       $nome = $linha['d_nome'];
       $texto = $linha['d_txt'];
    }

  
?>
<form id="form1" name="form1" method="post" action="">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td class="style1"><p align="center"><b><?=$nome?></b></p></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1" style="text-align: justify; padding: 10px;"><?=$texto ?></td>
    </tr>    
    <tr height="50">
      <td><div align="center"><input id=idPrint type="button" name="fechar"  class="campo3" value="Fechar Janela" Onclick="window.close();"></div></td>
    </tr>
  </table>
<?
mysql_close($con);
/*
	}else{
		include("login2.php");
	}
*/
?>
</form>
</body>
</html>