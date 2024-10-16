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
<td width=620 valign=top align=center>

<iframe name="xml" marginwidth="0" marginheight="0" src="http://www.redebrasileiradeimoveis.com.br/sistema/ler_xml.php" topmargin="0" leftmargin="0" scrolling="no" width="600" frameborder="0" height="400"></iframe>

<?php
include("carimbo.php");
?>
</td></tr></table>
</body>
</html>