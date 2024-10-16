<?php
//$hostname = "192.168.0.1";
$hostname = "localhost";
//$username = "Muraski";
$username = "root";
//$password = "muraski";
$password = "cl@#d1rm#r@sk1";
//$db = "Muraski";
$db = "Sistema";

	$con = mysql_connect("$hostname", "$username", "$password") or die("  Não consegui comunicar com o Banco de Dados");
//        $con = mysql_connect() or die(mysql_errno()."  Não consegui comunicar com o Banco de Dados");	
	$con;
	mysql_select_db("$db");
?>
