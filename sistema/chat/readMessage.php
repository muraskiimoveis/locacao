<?php
/*
Script para leitura de mensagens recebidas e usuários online
Retorna em formato JSON - www.json.org
Criado em 05/07/2008
Por Hédi Carlos Minin - hediminin@hotmail.com
*/

include('dbconnect.php');
include('settings.php');
include('security.php');

StartSession();
if(!CheckUser()){
	print '{result:[{messages:[]},{users: []},{status:"unregistered"}]}';
	exit();
}

//evitar cache
$gmtDate = gmdate("D, d M Y H:i:s"); 

header("Expires: {$gmtDate} GMT"); 
header("Last-Modified: {$gmtDate} GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 
header("Content-Type: text/html; charset=utf-8");
//header("Content-Type: text/html; charset=ISO-8859-1");

$id_user = (int) $_POST['iduser'];
$cleaUsers = (int) $_POST['clearuser'];

//atualiza tempo usuário
mysql_query("UPDATE bp_users SET lifetime='$lifeTimeUser' WHERE id=$id_user LIMIT 1");

$result = '{result:[{messages:[';

//mensagens
$messages = array();
$query = mysql_query("SELECT * FROM bp_messages WHERE id_receive=$id_user");
while($line = mysql_fetch_array($query)){
	$line['message'] = SqlInject($line['message']);
	$messages[] = '{idsend:'.$line['id_send'].',name:"'.$line['name'].'",message:"'.$line['message'].'"}';	
}
$result .= implode(',',$messages);

$result .= ']},{users: [';

//usuarios online
$users = array();
$query = mysql_query("SELECT * FROM bp_users");
while($line = mysql_fetch_array($query)){	
	$line['name'] = htmlentities($line['name']);
	$users[] = '{id:'.$line['id'].',status:'.$line['status'].',name:"'.$line['name'].'",photo:"'.$line['photo'].'"}';
}
$result .= implode(',',$users);

//status pedido
$result .= ']},{status:"ok"}]}';

//deleta mensagens recebidas
mysql_query("DELETE FROM bp_messages WHERE id_receive=$id_user");

//deleta usuários inativos
if($cleaUsers == 1){
	mysql_query("DELETE FROM bp_users WHERE lifetime < $time LIMIT 1");
}

echo $result;
?>