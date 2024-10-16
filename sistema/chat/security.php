<?php
/*
Script para manipulaчуo de sessуo
Criado em 05/07/2008
Por Hщdi Carlos Minin - hediminin@hotmail.com
*/

function StartSession(){
	session_start();
}

function RegisterUser($user){
	session_cache_expire(300);
	$_SESSION['chatUser'] = $user;
}

function CheckUser(){
	if(isset($_SESSION['chatUser'])){
		return true;
	}
	return false;
}

function GetUser(){
	if(isset($_SESSION['chatUser'])){
		return $_SESSION['chatUser'];
	}
}

function DestroyUser(){
	unset($_SESSION['chatUser']);
}

function SqlInject($field){
	$field = get_magic_quotes_gpc() == 0 ? addslashes($field) : $field;
	return $field;
}
?>