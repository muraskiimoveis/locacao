<?php
/*
Script para conex�o com o banco de dados
Criado em 05/07/2008
Por H�di Carlos Minin - hediminin@hotmail.com
*/

$server = '192.168.0.1';
$database = 'Rebri';
$user = 'Rebri';
$pass = 'rebri';

$conn = mysql_connect($server,$user,$pass);
if(!$conn){
	echo 'Falha na conex�o com o banco de dados: '.mysql_error();
	exit();
}elseif(!mysql_select_db($database,$conn)){
	echo 'Falha ao selecionar o banco de dados: '.mysql_error();
	exit();
}
?>
