<?php
session_cache_expire(1);
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_ANUNC");

if($_GET['url']){
 $url = $_GET['url'];
}else{
 $url = $_POST['url'];
}

if($_GET['data_inicial']){
 $data_inicial = $_GET['data_inicial'];
}else{
 $data_inicial = $_POST['data_inicial'];
}

if($_GET['data_final']){
 $data_final = $_GET['data_final'];
}else{
 $data_final = $_POST['data_final'];
}

if($_GET['cod']){
 $cod = $_GET['cod'];
}else{
 $cod = $_POST['cod'];
}

if($_GET['nome_veiculo']){
 $nome_veiculo = $_GET['nome_veiculo'];
}else{
 $nome_veiculo = $_POST['nome_veiculo'];
}

if($_GET['troca']){
 $troca = $_GET['troca'];
}else{
 $troca = $_POST['troca'];
}

if($_GET['criar']){
 $criar = $_GET['criar'];
}else{
 $criar = $_POST['criar'];
}


if($_GET['novo']=='1'){

unset($_SESSION['a_cod']);
unset($_SESSION['veiculo']);

}


if($_POST['adiciona']=='1'){
  
  	unset($_SESSION['a_cod']);
	unset($_SESSION['veiculo']);
  
	$SQL = "SELECT id_anuncio FROM anuncios WHERE veiculo_anuncio='".$veiculos2."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0)
	{
	  	$busca2 = mysql_query("SELECT id_anuncio FROM anuncios WHERE veiculo_anuncio='".$veiculos2."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY id_anuncio DESC LIMIT 1");
 		while($linha2 = mysql_fetch_array($busca2)){
 			$id = $linha2['id_anuncio'];
 		}
 	}
	
	$a_cod = $id;
	$veiculo = $veiculos2;
	
	session_register("a_cod");
	session_register("veiculo");
	
	$query6 = "SELECT sid FROM anuncios_temp WHERE anuncio='$a_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result6 = mysql_query($query6);
	$numrows6 = mysql_num_rows($result6);
		if($numrows6 > 0){
			while($not6 = mysql_fetch_array($result6))
			{
				$sid = $not6['sid'];
				session_register("sid");
			}
		}
		echo('<script language="javascript">alert("Troca Realizada!");document.location.href="'.urldecode($url2).'";</script>');
}


if($_POST['cadastra']=='1')
{
   		$msgErro = "";
   		
		$data = formataDataParaBd($_POST['data']);
   		if($_POST['veiculo']=='Outros'){
   		   	$veiculo = $_POST['veiculo']." - ".$_POST['qual'];
   		}else{
			$veiculo = $_POST['veiculo'];
		}
   		
   		$SQL = "SELECT id_anuncio FROM anuncios WHERE veiculo_anuncio='".$veiculo."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
		  	$busca2 = mysql_query("SELECT id_anuncio FROM anuncios WHERE veiculo_anuncio='".$veiculo."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY id_anuncio DESC LIMIT 1");
 			while($linha2 = mysql_fetch_array($busca2)){
 				$codigo_anuncio = $linha2['id_anuncio'];
 			}
 		
 			$atualizacao = "UPDATE anuncios SET data_anuncio='".$data."' WHERE id_anuncio='".$codigo_anuncio."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			mysql_query($atualizacao);
		  
		  	$a_cod = $codigo_anuncio;
	
			session_register("a_cod");
	
			$query6 = "SELECT sid FROM anuncios_temp WHERE anuncio='$a_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result6 = mysql_query($query6);
			$numrows6 = mysql_num_rows($result6);
			if($numrows6 > 0){
				while($not6 = mysql_fetch_array($result6))
				{
					$sid = $not6['sid'];
					session_register("sid");
				}
			}
		  	
		  	$data = date("Y-m-d");
			$hora = date("H:i:s");
			$B1 = "Adicionou Anúncio";

			//Insere o usuário que esta fazendo a atualização do imovel
			$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_anuncio, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$codigoi."','".$refi."','".$a_cod."','".$B1."','".$data."','".$hora."')") or die ("Erro 133 - ".mysql_error());
		  
			$msgErro .= "Já existe uma exportação cadastrada com esse tipo de veículo o imóvel será acrescentado a essa exportação já existente";
		}
		
		if($msgErro != "")
		{
	 			echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"".urldecode($url)."\";</script>"; 
		}
		else
		{
			$inserir = "INSERT INTO anuncios (cod_imobiliaria, data_anuncio, veiculo_anuncio) VALUES ('".$_SESSION['cod_imobiliaria']."','".$data."', '".$veiculo."')";   		
			mysql_query($inserir);
			$a_cod = mysql_insert_id();
			
			//$query10 = "INSERT INTO imoveis_anuncio (cod_imovel, cod_imobiliaria, id_anuncio) VALUES ('".$cod."', '".$_SESSION['cod_imobiliaria']."','".$a_cod."')";
   			//if(mysql_query($query10))
			//{
				echo('<script language="javascript">alert("Cadastro efetuado com sucesso!");document.location.href="'.urldecode($url).'";</script>');
   			//}
   			/*
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao cadastrar!");document.location.href="'.$url.'";</script>');
   			}
   			*/
   			
   			
   			if(!$sid){
				$sid = session_id();
			}
	
			session_register("a_cod");
			session_register("veiculo");
					
   		}
}

if($troca<>'S' && $criar<>'S'){

if(session_is_registered("a_cod")){
	
	if(session_is_registered("session_id()")){
	  

	if(!$sid){
		$sid = session_id();
	}

		$query6 = "select a.cod, a.sid, m.ref from anuncios_temp a 
		left join muraski m on (m.cod=a.cod)
		where a.sid='".$sid."' and a.cod='".$cod."' and a.anuncio='".$a_cod."' and a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$result6 = mysql_query($query6);
		$numrows6 = mysql_num_rows($result6);
		if($numrows6 > 0){
			while($not6 = mysql_fetch_array($result6))
			{
				$adicionado = "1";
				$codigoi = $not6['cod'];
				$refi = $not6['ref'];
				$veiculo = $not6['veiculo_anuncio'];
			}
			
		}
		else
		{   
			if($qtd > 0){
			  
		  
				$adicionado = "1";
	
				$query2= "insert into anuncios_temp (sid, cod, cod_imobiliaria, p_data, anuncio) values ('".$sid."', '".$cod."', '".$_SESSION['cod_imobiliaria']."', current_date, '".$a_cod."')";
				$result2 = mysql_query($query2) or die("Não foi possível atualizar suas informações.(Sessão existente)");
				
				
				if($codigoi<>$cod){
					$query11 = "INSERT INTO imoveis_anuncio (cod_imovel, cod_imobiliaria, id_anuncio) VALUES ('".$cod."', '".$_SESSION['cod_imobiliaria']."','".$a_cod."')";
					$result11 = mysql_query($query11) or die("Não foi possível atualizar suas informações. $query11");
					$id_anuncio_codigo = mysql_insert_id();
				}
				
				
			}
		}
	}
	else
	{
	  
		if($qtd > 0){
	
			$adicionado = "1";
			session_register("session_id()");
			session_register("veiculo");
	
		if(!$sid){
			$sid = session_id();
		}

		$query5 = "insert into anuncios_temp (sid, cod, cod_imobiliaria, p_data, anuncio) values ('".$sid."', '".$cod."', '".$_SESSION['cod_imobiliaria']."', current_date, '".$a_cod."')";
		$result5 = mysql_query($query5) or die("Não foi possível atualizar suas informações.(Com Sessão nova) $query5");
		
		$query11 = "INSERT INTO imoveis_anuncio (cod_imovel, cod_imobiliaria, id_anuncio) VALUES ('".$cod."', '".$_SESSION['cod_imobiliaria']."','".$a_cod."')";
		$result11 = mysql_query($query11) or die("Não foi possível atualizar suas informações. $query11");
		$id_anuncio_codigo = mysql_insert_id();
		}
		
	}
	
		$query6 = "select m.cod, m.ref from imoveis_anuncio a 
		left join muraski m on m.cod=a.cod_imovel 
		where a.id_anuncio_imovel='".$id_anuncio_codigo."' and a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$result6 = mysql_query($query6);
		$numrows6 = mysql_num_rows($result6);
		if($numrows6 > 0){
			while($not6 = mysql_fetch_array($result6))
			{
				$codigoi = $not6['cod'];
				$refi = $not6['ref'];
			}
		}
	
	$data = date("Y-m-d");
	$hora = date("H:i:s");
	$B1 = "Adicionou Anúncio";

	//Insere o usuário que esta fazendo a atualização do imovel
	$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_anuncio, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$codigoi."','".$refi."','".$a_cod."','".$B1."','".$data."','".$hora."')") or die ("Erro 133 - ".mysql_error());
	
	$url = urldecode($url);	
	header( "location: $url&adicionado=$adicionado\r\n" );	
	
}
}

if($_GET['rel']){
 $rel = $_GET['rel'];
}else{
 $rel = $_POST['rel'];
}

$url = urldecode($url);	

if($rel=='R'){ 
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">	
<? include("topo.php"); ?>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
include("menu.php");
?></td>
  </tr>
</table>
<? } ?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function VerificaCampo()
{

var msg = '';

       if(document.form1.data.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data.\n";
       }
       if (document.form1.veiculo.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Veículo.\n";
	   }
	   else if(document.form1.veiculo.value=='Outros')
	   {
	    	if(document.form1.qual.value.length==0)
	   		{
		       msg += "Por favor, preencha o campo Qual?\n";
       		}
       }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
            document.form1.cadastra.value='1';
			document.form1.submit();
	   }

}

function VerificaCampo3()
{

var msg = '';

       if (document.form1.veiculos2.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Veículo.\n";
	   }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
            document.form1.adiciona.value='1';
			document.form1.submit();
	   }

}

</script>
</head>
<?
if($troca=='S'){
	$url2 = str_replace("&adicionado=1","",$url);
}
?>


<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
<form id="form1" name="form1" method="post" action="cadastro_anuncios.php">
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
<input type="hidden" name="data_inicial" id="data_inicial" value="<?=$data_inicial ?>">
<input type="hidden" name="data_final" id="data_final" value="<?=$data_final ?>">
<input type="hidden" name="rel" id="rel" value="<?=$rel ?>">
<input type="hidden" name="troca" id="rel" value="<?=$troca ?>">
<input type="hidden" name="criar" id="criar" value="<?=$criar ?>">
<?
	if($troca<>'S'){
?>
<input type="hidden" name="url" id="url" value="<?=$url ?>">
<?
	}else{
?>
<input type="hidden" name="url2" id="url2" value="<?=$url2 ?>">  
<?
	}

 if($troca<>'S'){
?>
  <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><p align="center"><b>Inserir Exportações</b></p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Data:</b></td>
      <td width="80%" class="style1">
        <input type="text" name="data" id="data" size="12" maxlength="10" class="campo" value="<?=date("d/m/Y"); ?>" onKeyPress="return txtBoxFormat(document.form1, 'data', '##/##/####', event);" onChange="ValidaData(this.value)" readonly></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Ve&iacute;culo:</b></td>
      <td class="style1">
        <select name="veiculo" id="veiculo" class="campo">
          <option selected value="">Selecione um ve&iacute;culo</option>
<?
	if($criar<>'S'){
		//$query6 = "select * from rebri_tipo_anuncios WHERE (ta_nome LIKE 'Imóveis Curitiba' OR ta_nome LIKE 'Chave Fácil' OR ta_nome LIKE 'Minha Primeira Casa') order by ta_nome";
        $query6 = "select * from rebri_tipo_anuncios WHERE (ta_nome LIKE 'Imóveis Curitiba' OR ta_nome LIKE 'Chave Fácil') order by ta_nome";
		$result6 = mysql_query($query6);
		$numrows6 = mysql_num_rows($result6);
		if($numrows6 > 0){
			while($not6 = mysql_fetch_array($result6))
			{
?>
          	<option value="<?=$not6[ta_cod]?>" <? if($veiculo==$not6[ta_cod]){ echo "SELECTED"; } ?>><?=$not6[ta_nome]?></option>
<?
			}
		}
	}else{
		$query6 = "select * from rebri_tipo_anuncios WHERE ta_nome='".$nome_veiculo."' order by ta_nome";
		$result6 = mysql_query($query6);
		$numrows6 = mysql_num_rows($result6);
		if($numrows6 > 0){
			while($not6 = mysql_fetch_array($result6))
			{
?>
          	<option value="<?=$not6[ta_cod]?>" SELECTED><?=$not6[ta_nome]?></option>
<?
			}
		}	  
	}
?>
        </select> </td>
    </tr>	
    <tr>
      <td colspan="2">
          <input type="button" name="incluir" id="incluir" class="campo3" value="Incluir" Onclick="VerificaCampo();">
          <input type="hidden" name="cadastra" id="cadastra" value="0">
          <input type="hidden" value="1" name="qtd" id="qtd">
        </td>
    </tr>
	</table>
<?
	}else{
?>
	<table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><p align="center"><b>Troca de Veículo</b></p></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Ve&iacute;culo:</b></td>
      <td class="style1">
        <select name="veiculos2" id="veiculos2" class="campo">
          <option selected value="">Selecione um ve&iacute;culo</option>
<?

	//$query6 = "select * from rebri_tipo_anuncios WHERE ta_nome!='".$nome_veiculo."' AND (ta_nome LIKE 'Imóveis Curitiba' OR ta_nome LIKE 'Chave Fácil' OR ta_nome LIKE 'Minha Primeira Casa') order by ta_nome";
    $query6 = "select * from rebri_tipo_anuncios WHERE ta_nome!='".$nome_veiculo."' AND (ta_nome LIKE 'Imóveis Curitiba' OR ta_nome LIKE 'Chave Fácil') order by ta_nome";
	$result6 = mysql_query($query6);
	$numrows6 = mysql_num_rows($result6);
	if($numrows6 > 0){
		while($not6 = mysql_fetch_array($result6))
		{
?>
          <option value="<?=$not6[ta_cod]?>"><?=$not6[ta_nome]?></option>
<?
		}
	}
?>
        </select> </td>
    </tr>	
    <tr>
      <td colspan="2">
          <input type="button" name="incluir" id="incluir" class="campo3" value="Trocar" Onclick="VerificaCampo3();">
          <input type="hidden" name="adiciona" id="adiciona" value="0">
          <input type="hidden" value="1" name="qtd" id="qtd">
        </td>
    </tr>
	</table>
<?
	}
mysql_close($con);
?>
</form>
<?  if(session_is_registered("valid_user")){ ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("voltar.php"); ?>
    </td>
  </tr>	
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("endereco.php"); ?>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td align="center" class="style1">
    <? include("bruc.php"); ?>
    </td>
  </tr>
</table>
<? } ?>
</body>
</html>