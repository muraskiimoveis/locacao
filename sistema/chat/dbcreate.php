<?php
/*
Script para criação das tabelas do chat
Criado em 05/07/2008
Por Hédi Carlos Minin - hediminin@hotmail.com
*/

include('dbconnect.php');

$sql = "DROP TABLE IF EXISTS bp_users";
mysql_query($sql);

$sql = "CREATE TABLE bp_users(
	id INT AUTO_INCREMENT PRIMARY KEY,
	status INT (1) NOT NULL DEFAULT '1',
	name VARCHAR (50) NOT NULL,
	photo VARCHAR (25) NULL,
	lifetime VARCHAR (25) NOT NULL,
	ip VARCHAR (25) NOT NULL)";
mysql_query($sql);

$sql = "DROP TABLE IF EXISTS bp_messages";
mysql_query($sql);

$sql = "CREATE TABLE bp_messages(
	id INT AUTO_INCREMENT PRIMARY KEY,
	id_send INT NOT NULL,
	id_receive INT NOT NULL,
	name VARCHAR (50) NOT NULL,
	message VARCHAR (255) NOT NULL,
	time TIME NOT NULL,
	lifetime VARCHAR (25) NOT NULL)";
mysql_query($sql);
?>
