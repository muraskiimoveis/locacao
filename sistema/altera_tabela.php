<html>

<head>
</head>
<?php
include("conect.php");

	$con = mysql_connect("$hostname", "$username", "$password") or die("N�o consegui comunicar com o Banco de Dados");
	$con;
	mysql_select_db("$db");
?>
<?php
	$query0 = "alter table 'muraski' add 'dias' int(5)";
	$result0 = mysql_query($query0) or die("N�o foi poss�vel alterar tabelas");
?>
</body>
</html>