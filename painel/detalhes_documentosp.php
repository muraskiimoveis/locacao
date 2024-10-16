<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php

if($_GET['idl']){
  $id = $_GET['idl'];
}elseif($_GET['idv']){
  $id = $_GET['idv']; 
}
$cod_imobiliaria = $_GET['cod_imobiliaria'];


	$alteracao = mysql_query("SELECT d_nome, d_txt FROM doc WHERE d_id='".$id."' AND cod_imobiliaria='".$cod_imobiliaria."'");
    while($linha = mysql_fetch_array($alteracao)){
       $nome = $linha['d_nome'];
       $texto = $linha['d_txt'];
    }

  
?>
<form id="form1" name="form1" method="post" action="">
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td width="743" class="style2"><div align="center"><b><?=$nome?></b>
      </div></td>
    </tr>
	<tr>
      <td>&nbsp;</td>
    </tr>	
    <tr>
      <td class="style2"><?=$texto ?></td>
    </tr>
    <tr>
      <td><div align="center"><span class="style1">
        <input id=idPrint type="button" name="fechar" class="campo" value="Fechar Janela" Onclick="window.close();">
      </span></div></td>
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