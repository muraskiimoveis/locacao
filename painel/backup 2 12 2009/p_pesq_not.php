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
?>
 <p align="center"><b>Pesquisar Notícias e Textos</b><br>
 </p>
 <div align="center">
  <center>
  <table border="0" cellspacing="1" width="600" bgcolor="#<?php print("$barra_lat"); ?>">
    <form method="post" action="p_not.php">
  <tr>
      <td colspan=2 bgcolor="#<?php print("$cor3"); ?>"><b>Pesquisa por palavra chave</b></td>
    </tr>
    <tr>
      <td width="20%" bgcolor="#ffffff"><b>Palavra chave:</b></td>
      <td width="80%" bgcolor="#ffffff"> <input type="text" name="chave" size="30" class=campo> <select name="campo" class=campo>
          <option value="n_nome">Título
          <option value="n_grupo">Grupo
          <option value="n_txt">Texto
          </select></td>
    </tr>
    <tr>
      <td width="20%" bgcolor="#<?php print("$cor3"); ?>">
      <input type="hidden" value="1" name="pesq">
      <input type="submit" value="Pesquisar Texto" name="B1" class=campo></td>
      <td width="80%" bgcolor="#<?php print("$cor3"); ?>"></td>
    </tr>
    </form>
  </table>
<?php
include("carimbo.php");
mysql_close($con);
?>
</td></tr></table>
</body>
</html>