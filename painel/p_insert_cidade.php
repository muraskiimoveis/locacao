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
 <p align="center"><b>Inserir Cidade</b><br>
 <a href="p_cidades.php" class=style2>
 Clique para visualizar a relação de Cidades</a></p>
 <div align="center">
  <center>
  <form method="post" action="p_cidades.php">
  <table border="0" cellspacing="1" width="80%">
    <tr>
      <td align="left" width="20%"><b>Cidade:</b></td>
      <td align="left" width="80%"> <input class=campo type="text" name="ci_nome" size="40"></td>
    </tr>
    <tr>
      <td align="left" width="20%"><b>Estado:</b></td>
      <td align="left" width="80%"> <select name="ci_estado" class=campo>
<option value="0">Selecione o Estado</option>
<?
//require_once("conecta.php");
$sql = "SELECT e_cod, e_uf, e_nome FROM rebri_estados ORDER BY e_nome";
$sql = mysql_query($sql);
$row = mysql_num_rows($sql); 

	while($not4 = mysql_fetch_array($sql))
	{
?>
		       <option value="<? echo $not4[e_cod]."|".$not4[e_uf]; ?>">
			   <? echo $not4[e_nome]; ?></option>
<?php
	}
?>
	     </select></td>
    </tr>
    <tr>
      <td align="left" width="20%"><b>Cidade litorânea?</b></td>
      <td align="left" width="80%"><input name="ci_litoranea" type="checkbox" id="ci_litoranea" value="1"> Sim</td>
    </tr>
    <tr>
      <td align="left" width="20%"></td>
      <td align="left" width="80%"> <input class=campo type="submit" value="Inserir Cidade" name="B1"></td>
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