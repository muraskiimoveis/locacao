<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
?>
<?php
include("conect.php");

	if($logoff <> ""){
		session_unregister("u_cod");
		session_unregister("u_nome");
		session_unregister("u_tipo");
		//session_unregister("cnpj");
		session_unregister("valid_user");
		session_unregister("int_cod");
		session_unregister("i_nome");
		//session_unregister("cdxcombr");
	
	header( "location: $url\r\n" );	
	}
	
	if($senha <> ""){

	//$email = addslashes($email);
	$senha = addslashes($senha);
	$senha_web = addslashes($senha_web);

	if($acesso_web == "1"){
	
	$query0 = "select * from senha_web where s_senha='$senha_web'";
	$result0 = mysql_query($query0) or die("Não foi possível pesquisar suas informações.");
	$numrows = mysql_num_rows($result0);
	if($numrows > 0){
	
	while($not0 = mysql_fetch_array($result0))
	{
	
	$lib_web = "Sim";
	
	}
	}
	
	}

	if(($lib_web == "Sim") or ($acesso_web != "1")){

	$query0 = "select * from usuarios where u_senha='$senha'";
	$result0 = mysql_query($query0) or die("Não foi possível pesquisar suas informações.");
	$numrows = mysql_num_rows($result0);
	if($numrows > 0){
	
	while($not0 = mysql_fetch_array($result0))
	{
	//$query1 = "insert into login (email, data_hora, senha) 
	//values('$not0[u_email]', current_timestamp, '$senha')";
	//$result1 = mysql_query($query1) or die("Não foi possível inserir suas informações.");
	
	$u_cod = $not0[u_cod];
	$valid_user = $not0[u_email];
	$u_tipo = $not0[u_tipo];
	$u_nome = $not0[u_nome];
	session_register("u_cod");
	session_register("valid_user");
	session_register("u_tipo");
	session_register("u_nome");
	$sid = session_id();
	
	$url = str_replace("-","&","$url");
	$url = str_replace("|","?","$url");
	
	header( "location: $url\r\n" );
	
	}
	}
	else
	{
	$url = str_replace("-","&","$url");
	$url = str_replace("|","?","$url");
	header( "location: $url\r\n" );	
	}
	
	}
	
	}
?>