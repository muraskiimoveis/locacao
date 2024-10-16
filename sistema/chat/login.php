<?php
/*
Script para inserir usu�rio do chat
Criado em 05/07/2008
Por H�di Carlos Minin - hediminin@hotmail.com
*/

function CheckField($field){
	$field = strip_tags($field);
	if(eregi("[^a-zA-Z0-9_-]", $field)){ return false; }
	if((substr_count($field,' ')) == (strlen($field))){ return false; }
	if(empty($field)){ return false; }
	return true;
}

$error = false;

//efetua login
if(isset($_POST['Login'])){

	$username = SqlInject($_POST['username']);
	
	if(!CheckField($username)){
		$error = 'Nick deve conter somente letras, n�meros e _';
	}
	
	if(!$error){
		$query = mysql_query("SELECT * FROM bp_users WHERE name='$username' AND lifetime > $time");
		$totalname = mysql_num_rows($query);
		if($totalname > 0){
			$error = 'Este nick j� esta em uso, por favor informe outro';
		}	
	} 
		
	if(!$error){
		$query = mysql_query("SELECT * FROM bp_users WHERE lifetime > $time");
		$totaluser = mysql_num_rows($query);
		if($totaluser > $maxUsers){
			$error = 'Desculpe, o chat est� lotado. Tente novamente mais tarde';
		}
	}
	
	if(!$error){
		//deleta usuarios antigos
		mysql_query("DELETE FROM bp_users WHERE lifetime < $time");
		
		//cadastra usuario
		$ip = $_SERVER['REMOTE_ADDR'];
		$query = mysql_query("INSERT INTO bp_users (status,name,photo,lifetime,ip) VALUES ('1','$username','default.jpg','$lifeTimeUser','$ip')");
		$id_user = mysql_insert_id();
		
		$user = array();
		$user['id'] = $id_user;
		$user['name'] = $username;
		
		StartSession();
		RegisterUser($user);
		
		if($enableLog){
			$date = date('dmY');
			$logTime = date('h:i:s');

			$logFile = $logDir.'/login_'.$date.'.txt';
			
			$logMessage = '['.$logTime.']['.$ip.'] '.$username.' entrou no chat - id '.$id_user;
			
			$fp = fopen($logFile,'a');
			fwrite($fp,$logMessage."\r\n");
			fclose($fp);
		}
		
		header('Location:main.php');
		exit();
	}
}
?>