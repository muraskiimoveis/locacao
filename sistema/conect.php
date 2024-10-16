<?php
$hostname = '172.20.0.42';
$username = 'root';
$password = 'fenix2002';
$db = 'Sistema';

$con = mysql_connect($hostname, $username, $password) or die("  Não consegui comunicar com o Banco de Dados");
$con;
mysql_select_db("$db");



// $link = mysql_connect('172.20.0.7', 'oimenu', 'fenix2002');
// if (!$link) {
//     die('Could not connect: ' . mysql_error());
// }
// echo 'Connected successfully';
// mysql_close($link);

?>
