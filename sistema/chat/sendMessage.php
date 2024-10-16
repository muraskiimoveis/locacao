<?php
/*
Script para envio de mensagens
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

$gmtDate = gmdate("D, d M Y H:i:s"); 

header("Expires: {$gmtDate} GMT"); 
header("Last-Modified: {$gmtDate} GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 
header("Content-Type: text/html; charset=utf-8");
//header("Content-Type: text/html; charset=ISO-8859-1");

$id_send = (int) $_POST['idsend'];
$id_receive = (int) $_POST['idreceive'];
$message = $_POST['message'];
$name = $_POST['name'];

$message = strip_tags($message);

if($message){
	$message = SqlInject($message);
	mysql_query("INSERT INTO bp_messages 
	(id_send,id_receive,name,message,time,lifetime) 
	VALUES 
	('$id_send','$id_receive','$name','$message',NOW(),'$lifeTimeMessage')");


	if($enableLog){
		$date = date('dmY');
		$logTime = date('h:i:s');
	
		$logFile = $id_send.'_'.$id_receive;
		if($id_receive < $id_send){ $logFile = $id_receive.'_'.$id_send; }
		$logFile = $logDir.$date.'_'.$logFile.'.txt';
		
		$logMessage = '['.$logTime.'] '.$name.': '.$message;
		
		$fp = fopen($logFile,'a');
		fwrite($fp,$logMessage."\r\n");
		fclose($fp);
	}
}
?>
