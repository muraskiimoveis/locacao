<?php
/*
Script para remover usuário do chat
Criado em 05/07/2008
Por Hédi Carlos Minin - hediminin@hotmail.com
*/

include('dbconnect.php');
include('settings.php');
include('security.php');

StartSession();
if(!CheckUser()){
	exit();
}

$user  = GetUser();
$id_user = $user['id'];
mysql_query("DELETE FROM bp_users WHERE id=$id_user LIMIT 1");

DestroyUser();

header('Location:index.php');
?>
