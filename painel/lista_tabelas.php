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
<?php
$nome = $username;
//$link = mysql_connect("localhost","root","");
$resultado_tabelas = mysql_list_tables($nome);
$qntd_tabelas = @mysql_numrows($resultado_tabelas);
print "Tabelas do Banco <b><i>".$nome."</i></b><ul>";
if($qntd_tabelas == 0){
print "<li>Nenhuma tabela foi encontrada neste banco de bados</li>";
}
for ($i = 0; $i < $qntd_tabelas; $i++)
{
//print "<li><a href='tabela.php?nome=".mysql_tablename($resultado_tabelas, $i)."&bd=".$nome."'>".mysql_tablename($resultado_tabelas, $i)."</a></li>";

print mysql_tablename($resultado_tabelas, $i)."<br>";
}

print "</ul>";
//mysql_close($link);
?>
<?php
include("carimbo.php");
mysql_close($con);
?>
</td></tr></table>
</body>
</html>
