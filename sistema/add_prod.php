<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("ATENDIMENTO_GERAL");

/*
echo "<pre>";
print_r ($_GET);
echo "</pre>";
*/

//echo $B1;
if($B1 == "Inserir Atendimento") {

	$i_nome = AddSlashes($i_nome);
	$i_tel = AddSlashes($i_tel);
	$i_email = AddSlashes($i_email);
	$i_obs = AddSlashes($i_obs);
	$controle = $_POST['controle'];

	$query = "insert into interessados (cod_imobiliaria, i_nome, i_tel, i_email, i_obs, i_ref, i_tipo, i_data
	, i_status, i_data_status, i_corretor, i_libera, i_controle)
	values('".$_SESSION['cod_imobiliaria']."','".$i_nome."', '".$i_tel."', '".$i_email."', '".$i_obs."', '".$i_ref."', '".$i_tipo."', current_timestamp
	, 'Novo', current_timestamp, '".$i_corretor."', 's', '".$controle."')";
	//echo $query;
	$result = mysql_query($query) or die("Não foi possível inserir suas informações.");
	$int_cod = mysql_insert_id();

	//echo $int_cod;

	if(!$sid){
	$sid = session_id();
	}

	session_register("int_cod");
	session_register("i_nome");
	$controle1 = $controle;
	session_register("controle1");

	if($controle == "V")
    {
	  $dataa = "a_data_venda=current_timestamp";
	}
	elseif($controle == "L")
	{
	  $dataa = "a_data_locacao=current_timestamp";
	}
	
	$query1 = "update atendimento set ".$dataa." where a_corretor='".$i_corretor."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result1 = mysql_query($query1) or die("Não foi possível atualizar suas informações.");

	}

    //echo "**".$_SESSION['controle1'];
    if($_GET['controle'] != ""){
    	$controle = $_GET['controle'];
    }
    if($_POST['controle'] != ""){
    	$controle = $_POST['controle'];
    }
    //echo "*".$controle."<br>";
	if (session_is_registered("int_cod") && $_SESSION['controle1'] == $controle) {


	if(session_is_registered("session_id()")){

	if(!$sid){
	$sid = session_id();
	}

	//Procura se o produto já foi inserido no carrinho
	$query6 = "select cod, sid from imoveis_temp where sid='".$sid."' and
	cod='".$cod."' and interessado='".$int_cod."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";

	//echo $query6;
	$result6 = mysql_query($query6);
	$numrows6 = mysql_num_rows($result6);
	if($numrows6 > 0){
	while($not6 = mysql_fetch_array($result6))
	{

	$adicionado = "1";

	//Atualiza produto no carrinho
	//$qtd2 = $not6[p_qtd] + $qtd;
	//$saldo3 = $estoque - $qtd2;
	
	//if($saldo3 >= 0){
	//$query7= "update pedidos_temp set p_qtd='$qtd2' where sid='$sid' and p_cod='$p_cod'";
	//$result7 = mysql_query($query7) or die("Não foi possível atualizar suas informações.(Sessão existente)");
	//}
	}//Termina while 6
	}//Termina numrows 6
	else
	{
	if($qtd > 0){
	
	$adicionado = "1";
	
	//Insere os produtos na tabela temporária
	$query2= "insert into imoveis_temp (sid, cod, cod_imobiliaria, p_data, interessado) 
	values('".$sid."', '".$cod."', '".$_SESSION['cod_imobiliaria']."', current_date, '".$int_cod."')";
	$result2 = mysql_query($query2) or die("Não foi possível atualizar suas informações.(Sessão existente)");
	}
	}
	
	}//Termina aqui se a seção existe
	else
	{
	
	//Insere os produtos na tabela temporária
	if($qtd > 0){
	
	$adicionado = "1";
	
	session_register("session_id()");
	
	if(!$sid){
	$sid = session_id();
	}
	
	$query5= "insert into imoveis_temp (sid, cod, cod_imobiliaria, p_data, interessado) 
	values('".$sid."', '".$cod."', '".$_SESSION['cod_imobiliaria']."', current_date, '".$int_cod."')";
	$result5 = mysql_query($query5) or die("Não foi possível atualizar suas informações.(Com Sessão nova)");
	}
	}
	
	$url = urldecode($url);
	
	header( "location: $url&adicionado=$adicionado\r\n" );
	//echo $url;
	
	//}
	//}//Termina While
	//}//Termina numrows
	}//int_cod
	else
	{

include("style.php");
include("p_insert_atendimento.php");

	}
?>
