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

if($B1 == "Atualizar limite")
	{

	$query = "update rebri_destaques set d_qtd='$qtd'	where d_cod='2'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações. $query");
?>
<font color="#ff0000" size="2" face="Verdana">
Você atualizou o texto <i><?php print("$n_nome"); ?></i>.
<?php
	}else{
		$query1 = "select d_qtd from rebri_destaques where d_cod='2'";
		$result1 = mysql_query($query1) or die("Não foi possível atualizar suas informações. $query1");
		while($not1 = mysql_fetch_array($result1))
		{
?>
  <form method="post" action="<?php print("$PHP_SELF"); ?>">
  <table border="0" cellspacing="1" width="95%">
    <tr>
      <td align="left">Limite de fotos para cada imóvel é: <input class=campo type="text" name="qtd" size="3" value="<?php print("$not1[d_qtd]"); ?>"><br><br></td>
    </tr>
    <tr>
      <td align="center"><input class=campo type="submit" value="Atualizar limite" name="B1"></td>
    </tr>
  </table>
  </form>
<?php
}
}
include("carimbo.php");
mysql_close($con);
?>
</td></tr></table>
</body>
</html>