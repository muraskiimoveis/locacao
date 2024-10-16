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
?>
 <p align="center"><b>Inserir Tipo de Comércio</b><br>
 <a href="p_tipos_comercio.php" class=linkm>
 Clique para visualizar a relação de Tipos Comércio</a></p>
 <div align="center">
  <center>
  <form method="post" action="p_tipos_comercio.php">
  <table border="0" cellspacing="1" width="80%">
    <tr>
      <td align="left" width="10%"><b>Tipo Comércio:</b></td>
      <td align="left" width="90%"> <input class=campo type="text" name="tc_nome" size="40"></td>
    </tr>
    <tr>
      <td align="left" width="10%"></td>
      <td align="left" width="90%"> <input class=campo type="submit" value="Inserir Tipo" name="B1"></td>
    </tr>
  </table>
  </form>
<?php
include("carimbo.php");
mysql_close($con);
?>
</td></tr></table>
</body>
</html>