<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("IMOV_GERAL");
?>
<html>
<head>
<?php
include("style.php");
?>
<script language="javascript">
function valida()
{
  if (document.form1.finalidade.selectedIndex == 0)
  {
		alert("Por favor, selecione o campo Finalidade");
    	document.form1.finalidade.focus();
    	return (false);
  }
  if (document.form1.ref.value == "")
  {
    	alert("Por favor, preencha o campo Referência");
    	document.form1.ref.focus();
    	return false;
  }
  else
  {
    var er = new RegExp("^[0-9a-z]+$");
    if(er.test(document.form1.ref.value) == false)
	{
  	    alert("Não pode haver espaço nem caractere especial no campo Referência");
    	document.form1.ref.focus();
    	return false;		    
    }
  }
  if (document.form1.cliente.selectedIndex == 0)
  {
		alert("Por favor, selecione o campo Proprietário");
    	document.form1.cliente.focus();
    	return false;
  }
  if (document.form1.finalidade.value == "1" || document.form1.finalidade.value == "2" || document.form1.finalidade.value == "3" || document.form1.finalidade.value == "4" || document.form1.finalidade.value == "5" || document.form1.finalidade.value == "6" || document.form1.finalidade.value == "7")
  {
  	if (document.form1.dias.value == "")
  	{
    	alert("Por favor, preencha o campo Dias úteis");
    	document.form1.dias.focus();
    	return false;
  	}
  }
  if (document.form1.diae.value == "")
  {
    	alert("Por favor, preencha o campo Dia Inicial de Contrato de");
    	document.form1.diae.focus();
    	return false;
  }
  if (document.form1.mese.value == "")
  {
    	alert("Por favor, preencha o campo Mês Inicial de Contrato de");
    	document.form1.mese.focus();
    	return false;
  }
  if (document.form1.anoe.value == "")
  {
    	alert("Por favor, preencha o campo Ano Inicial de Contrato de");
    	document.form1.anoe.focus();
    	return false;
  }
  if (document.form1.diae1.value == "")
  {
    	alert("Por favor, preencha o campo Dia Final de Contrato de");
    	document.form1.diae1.focus();
    	return false;
  }
  if (document.form1.mese1.value == "")
  {
    	alert("Por favor, preencha o campo Mês Final de Contrato de");
    	document.form1.mese1.focus();
    	return false;
  }
  if (document.form1.anoe1.value == "")
  {
    	alert("Por favor, preencha o campo Ano Final de Contrato de");
    	document.form1.anoe1.focus();
    	return false;
  }
  if (document.form1.contrato.selectedIndex == 0)
  {
		alert("Por favor, selecione o campo Contrato");
    	document.form1.contrato.focus();
    	return (false);
  }
  if (document.form1.finalidade.value == "15" || document.form1.finalidade.value == "16" || document.form1.finalidade.value == "17")
  {
  	if (document.form1.valor.value == "")
  	{
    	alert("Por favor, preencha o campo Diária");
    	document.form1.valor.focus();
    	return false;
  	}
  }else{
  	if (document.form1.valor.value == "")
  	{
    	alert("Por favor, preencha o campo Valor");
    	document.form1.valor.focus();
    	return false;
  	}
  }
  if (document.form1.comissao.value == "")
  {
    	alert("Por favor, preencha o campo Comissão Imobiliária");
    	document.form1.comissao.focus();
    	return false;
  }
  if (document.form1.finalidade.value == "15" || document.form1.finalidade.value == "16" || document.form1.finalidade.value == "17")
  {
  	if (document.form1.diaria1.value == "")
  	{
    	alert("Por favor, preencha o campo Diária mínima");
    	document.form1.diaria1.focus();
    	return false;
  	}
  	if (document.form1.diaria2.value == "")
  	{
    	alert("Por favor, preencha o campo Diária máxima");
    	document.form1.diaria2.focus();
    	return false;
  	}
  }
  if (document.form1.ende.value == "")
  {
    	alert("Por favor, preencha o campo Endereço");
    	document.form1.ende.focus();
    	return false;
  }
  if (document.form1.im_estado.selectedIndex == 0)
  {
		alert("Por favor, selecione o campo Estado");
    	document.form1.im_estado.focus();
    	return (false);
  }
  if (document.form1.cidade_mat.selectedIndex == 0)
  {
		alert("Por favor, selecione o campo Cidade Mat.");
    	document.form1.cidade_mat.focus();
    	return (false);
  }
  if (document.form1.local.selectedIndex == 0)
  {
		alert("Por favor, selecione o campo Localização");
    	document.form1.local.focus();
    	return (false);
  }
  if (document.form1.permuta.value == "Sim")
  {
    if (document.form1.permuta_txt.value == "")
  	{
    	alert("Por favor, preencha o campo Texto da Permuta");
    	document.form1.permuta_txt.focus();
    	return false;
  	}
  }
  if (document.form1.n_quartos.value == "")
  {
    	alert("Por favor, preencha o campo N° de quartos");
    	document.form1.n_quartos.focus();
    	return false;
  }
  if (document.form1.suites.value == "")
  {
    	alert("Por favor, preencha o campo Sendo suíte");
    	document.form1.suites.focus();
    	return false;
  }
  if (document.form1.finalidade.value == "15" || document.form1.finalidade.value == "16" || document.form1.finalidade.value == "17")
  {
  	if (document.form1.acomod.value == "")
  	{
    	alert("Por favor, preencha o campo Acomodações");
    	document.form1.acomod.focus();
    	return false;
  	}
  }
  if (document.form1.chaves.value == "")
  {
    	alert("Por favor, preencha o campo Local Chaves");
    	document.form1.chaves.focus();
    	return false;
  }
  if (document.form1.angariador.selectedIndex == 0)
  {
		alert("Por favor, selecione o campo Angariador");
    	document.form1.angariador.focus();
    	return (false);
  }
  if (document.form1.disp_rede.value == "1")
  {
    if (document.form1.comissao_parceria.value == "")
  	{
    	alert("Por favor, preencha o campo Comissão oferecida p/ parceria");
    	document.form1.comissao_parceria.focus();
    	return false;
  	}
  	if (document.form1.comissao_parceria.value == "diferenciado")
	{
	  	if (document.form1.comissao_diferenciado.value == "")
  		{
    		alert("Por favor, preencha o campo Comissão");
    		document.form1.comissao_diferenciado.focus();
    		return false;
  		}
	}
  }
  return true;
}
</script>
</head>
<body onUnload="window.opener.location.reload()">
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and (session_is_registered("u_cod")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/	
?>
<p>
<div align="center">
  <center>
  <table width="760" border="0" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
  <tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class=style1>
 <p align="center"><b>Inserir Imóveis</b><br></p></td></tr>
<?php

if($B1 == "Inserir Imóvel")
	{
	$titulo = AddSlashes(strip_tags($titulo));
	$desc = AddSlashes(strip_tags($descricao));
	$permuta_txt = AddSlashes($permuta_txt);
	$ftxt_1 = AddSlashes($ftxt_1);
	$ftxt_2 = AddSlashes($ftxt_2);
	$ftxt_3 = AddSlashes($ftxt_3);
	$ftxt_4 = AddSlashes($ftxt_4);
	$ftxt_5 = AddSlashes($ftxt_5);
	$ftxt_6 = AddSlashes($ftxt_6);
	$ftxt_7 = AddSlashes($ftxt_7);
	$ftxt_8 = AddSlashes($ftxt_8);
	$ftxt_9 = AddSlashes($ftxt_9);
	$ftxt_10 = AddSlashes($ftxt_10);
	$ftxt_11 = AddSlashes($ftxt_11);
	$ftxt_12 = AddSlashes($ftxt_12);
	$ftxt_13 = AddSlashes($ftxt_13);
	$ftxt_14 = AddSlashes($ftxt_14);
	$ftxt_15 = AddSlashes($ftxt_15);
	$ftxt_16 = AddSlashes($ftxt_16);
	$ftxt_17 = AddSlashes($ftxt_17);
	$ftxt_18 = AddSlashes($ftxt_18);
	$ftxt_19 = AddSlashes($ftxt_19);
	$ftxt_20 = AddSlashes($ftxt_20);
	$data_inicio = "$ano-$mes-$dia";
	$data_fim = "$ano1-$mes1-$dia1";
	
	$area_averbada = $_POST['area_averbada'];
	$area_terreno = $_POST['area_terreno'];
	$matricula_luz = $_POST['matricula_luz'];
	$situacao_luz = $_POST['situacao_luz'];
	$matricula_agua = $_POST['matricula_agua'];
	$situacao_agua = $_POST['situacao_agua'];
	$observacoes = $_POST['observacoes'];
	$uf = $_POST['im_estado'];
	
	 $numero = count($_POST['bairro']);
			
		   for ($i = 0; $i <= ($numero - 1); $i++) 
		   {
			   $j = $i + 1;
			   if($j == $numero){
				$bairro1 .= "-".$bairro[$i]."-";
			   }else{
				$bairro1 .= "-".$bairro[$i] . "-";
			   }			 
		   }
		   
	 $numero2 = count($_POST['caracteristica']);
			
		   for ($i2 = 0; $i2 <= ($numero2 - 1); $i2++) 
		   {
			   $j2 = $i2 + 1;
			   if($j2 == $numero2){
				$caracteristica1 .= "-".$caracteristica[$i2]."-";
			   }else{
				$caracteristica1 .= "-".$caracteristica[$i2] . "-";
			   }			 
		   }
	
	if($opcao=='2'){
	  $dist_mara = $dist_mar1;
	  $dist_tipoa = '';
	}elseif($opcao=='1'){
	  $dist_mara = $dist_mar;
	  $dist_tipoa = $dist_tipo;
	}
	
    if($_POST['comissao_parceria']=='diferenciado'){
	  $comissao_parceria = $comissao_diferenciado;
	}else{
	  $comissao_parceria = $comissao_parceria;  
	}
	
	
   		$SQL = "SELECT ref FROM muraski WHERE ref='".$ref."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Essa referência já está cadastrada favor escolha outra!";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');</script>"; 
		}
		else
		{
	
  	  
		if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ 

			$query = "insert into muraski (cod_imobiliaria, ref, tipo, metragem, area_terreno, matricula_luz, situacao_luz, matricula_agua, situacao_agua, 
			n_quartos, valor, especificacao, suites, caracteristica, piscina, titulo, 
			descricao, uf, local, permuta, finalidade, permuta_txt, 
			ftxt_1, ftxt_2, ftxt_3, ftxt_4, ftxt_5, ftxt_6, ftxt_7, ftxt_8, 
			ftxt_9, ftxt_10, ftxt_11, ftxt_12, ftxt_13, ftxt_14, ftxt_15
			, ftxt_16, ftxt_17, ftxt_18, ftxt_19, ftxt_20, cliente, matricula, cidade_mat
			, bairro, end, averbacao, acomod, dist_mar, dist_tipo, limpeza, diaria1, diaria2
			, data_inicio, data_fim, comissao, dias, contrato, carnaval, anonovo, coordenadas, posx, posy, tv
			, angariador, zelador, tipo_anga, indicador, comissao_indicador, comissao_vendedor, diarista, comissao_diarista, piscineiro, comissao_piscineiro, eletricista, comissao_eletricista, encanador, comissao_encanador, jardineiro, comissao_jardineiro, chaves, controle_chave, tipo_div, valor_oferta, relacao_bens, observacoes, disponibilizar, disp_rede, destaque, comissao_parceria) 
			values('".$_SESSION['cod_imobiliaria']."', '$ref', '$tipo1', '$metragem', '".$area_terreno."', '".$matricula_luz."'
			, '".$situacao_luz."', '".$matricula_agua."', '".$situacao_agua."', '$n_quartos'
			, '$valor', '$especificacao', '$suites', '".$caracteristica1."', '$piscina'
			, '$titulo', '$desc', '$uf', '$local', '$permuta', '$finalidade', '$permuta_txt'
			, '$ftxt_1', '$ftxt_2', '$ftxt_3', '$ftxt_4', '$ftxt_5', '$ftxt_6'
			, '$ftxt_7', '$ftxt_8', '$ftxt_9', '$ftxt_10', '$ftxt_11', '$ftxt_12'
			, '$ftxt_13', '$ftxt_14', '$ftxt_15', '$ftxt_16', '$ftxt_17'
			, '$ftxt_18', '$ftxt_19', '$ftxt_20', '$cliente', '$matricula', '$cidade_mat'
			, '".$bairro1."', '$ende', '$averbacao', '$acomod', '$dist_mara', '$dist_tipoa', '$limpeza', '$diaria1'
			, '$diaria2', '$data_inicio', '$data_fim', '$comissao', '$dias', '$contrato', '$carnaval', '$anonovo'
			, '$coordenadas', '$posx', '$posy', '$tv', '$angariador', '$zelador', '$tipo_anga', '$co_cliente2', '$comissao_indicador', '$comissao_vendedor', '$co_diarista', '$comissao_diarista', '$co_piscineiro', '$comissao_piscineiro', '$co_eletricista', '$comissao_eletricista', '$co_encanador', '$comissao_encanador', '$co_jardineiro', '$comissao_jardineiro', '$chaves', '$controle_chave', '$tipo_div'
			, '$valor_oferta', '$relacao_bens', '".$observacoes."', '".$disponibilizar."', '".$disp_rede."', '".$destaque."', '".$comissao_parceria."')";
			$result = mysql_query($query) or die("Não foi possível inserir suas informações. $query");
			$cod_imovel = mysql_insert_id();
			
			$query10 = "insert into avaliados (cod_imobiliaria, cod_imovel, data, user) 
			values('".$_SESSION['cod_imobiliaria']."', '$cod_imovel', current_date, '".$_SESSION['u_cod']."')";
			$result10 = mysql_query($query10) or die("Não foi possível inserir suas informações. $query10");
			
			
	
		}else{
	
			$query = "insert into muraski (cod_imobiliaria, ref, tipo, metragem, area_terreno, matricula_luz, situacao_luz, matricula_agua, situacao_agua, 
			n_quartos, valor, especificacao, suites, caracteristica, piscina, titulo, 
			descricao, uf, local, permuta, finalidade, permuta_txt, 
			ftxt_1, ftxt_2, ftxt_3, ftxt_4, ftxt_5, ftxt_6, ftxt_7, ftxt_8, 
			ftxt_9, ftxt_10, ftxt_11, ftxt_12, ftxt_13, ftxt_14, ftxt_15
			, ftxt_16, ftxt_17, ftxt_18, ftxt_19, ftxt_20, cliente, matricula, cidade_mat
			, bairro, end, averbacao, dist_mar, dist_tipo 
			, data_inicio, data_fim, comissao, dias, contrato, coordenadas, posx, posy
			, angariador, zelador, tipo_anga, indicador, comissao_indicador, comissao_vendedor, chaves, controle_chave, tipo_div, valor_oferta, relacao_bens, observacoes, disponibilizar, disp_rede, destaque, comissao_parceria) 
			values('".$_SESSION['cod_imobiliaria']."', '$ref', '$tipo1', '$metragem', '".$area_terreno."', '".$matricula_luz."'
			, '".$situacao_luz."', '".$matricula_agua."', '".$situacao_agua."', '$n_quartos'
			, '$valor', '$especificacao', '$suites', '".$caracteristica1."', '$piscina'
			, '$titulo', '$desc', '$uf', '$local', '$permuta', '$finalidade', '$permuta_txt'
			, '$ftxt_1', '$ftxt_2', '$ftxt_3', '$ftxt_4', '$ftxt_5', '$ftxt_6'
			, '$ftxt_7', '$ftxt_8', '$ftxt_9', '$ftxt_10', '$ftxt_11', '$ftxt_12'
			, '$ftxt_13', '$ftxt_14', '$ftxt_15', '$ftxt_16', '$ftxt_17'
			, '$ftxt_18', '$ftxt_19', '$ftxt_20', '$cliente', '$matricula', '$cidade_mat'
			, '".$bairro1."', '$ende', '$averbacao', '$dist_mara', '$dist_tipoa' 
			, '$data_inicio', '$data_fim', '$comissao', '$dias', '$contrato' 
			, '$coordenadas', '$posx', '$posy', '$angariador', '$zelador', '$tipo_anga', '$co_cliente2', '$comissao_indicador', '$comissao_vendedor', '$chaves', '$controle_chave', '$tipo_div'
			, '$valor_oferta', '$relacao_bens', '".$observacoes."', '".$disponibilizar."', '".$disp_rede."', '".$destaque."', '".$comissao_parceria."')";
			$result = mysql_query($query) or die("Não foi possível inserir suas informações. $query");
			$cod_imovel = mysql_insert_id();
			
			$query10 = "insert into avaliados (cod_imobiliaria, cod_imovel, data, user) 
			values('".$_SESSION['cod_imobiliaria']."', '$cod_imovel', current_date, '".$_SESSION['u_cod']."')";
			$result10 = mysql_query($query10) or die("Não foi possível inserir suas informações. $query10");
	
		}

	
	
		echo('<script language="javascript">alert("Você inseriu o imóvel Ref.: '.$ref.'!");window.close();</script>');

	
	/*
	foreach($_POST['predileto'] AS $key => $value){
		echo $value;
	}
	*/
?>
<!--tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class=style1>
<p align="center">
Você inseriu o imóvel <b>Ref.:</b> <?php print("$ref"); ?>.</p></td></tr-->
<?php
    }
	}
//mysql_free_result($result);
?>
 <div align="center">
  <center>
<?php
	if(!IsSet($inserir1))
	{
?>
<script language="javascript">
function LimpaCampo(){

  if(document.getElementById('opcao1').checked){
  
	document.form1.dist_mar.disabled = false;
    document.form1.dist_tipo.disabled = false;
    document.form1.dist_mar.style.background = '#FFFFFF';
    document.form1.dist_tipo.style.background = '#FFFFFF';
	document.form1.dist_mar1.disabled = true;
    document.form1.dist_mar1.style.background = '#D6D6D6';
  }
  else if(document.getElementById('opcao2').checked){

    document.form1.dist_mar.value='';
    document.form1.dist_tipo.selectedIndex='metros';
    document.form1.dist_mar.disabled = true;
    document.form1.dist_tipo.disabled = true;
    document.form1.dist_mar.style.background = '#D6D6D6';
    document.form1.dist_tipo.style.background = '#D6D6D6';
    document.form1.dist_mar1.disabled = false;
    document.form1.dist_mar1.style.background = '#FFFFFF';
  }
}

<!-- Begin
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
var keyCode = (isNN) ? e.which : e.keyCode; 
var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
if(input.value.length >= len && !containsElement(filter,keyCode)) {
input.value = input.value.slice(0, len);
input.form[(getIndex(input)+1) % input.form.length].focus();
}
function containsElement(arr, ele) {
var found = false, index = 0;
while(!found && index < arr.length)
if(arr[index] == ele)
found = true;
else
index++;
return found;
}
function getIndex(input) {
var index = -1, i = 0, found = false;
while (i < input.form.length && index == -1)
if (input.form[i] == input)index = i;
else i++;
return index;
}
return true;
}
//  End -->
</script>
<?
//require_once("conecta.php");
$sql = "SELECT e_cod, e_uf, e_nome FROM rebri_estados ORDER BY e_nome";
$sql = mysql_query($sql);
$row = mysql_num_rows($sql); ?>
<script language="JavaScript">
function Dados(valor) {
	  try {
         ajax = new ActiveXObject("Microsoft.XMLHTTP");
      } 
      catch(e) {
         try {
            ajax = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax = null;
            }
         }
      }
	if(ajax) {
	     <? if($_POST['local']){ ?>
		 opcoes  = 1;
		 idOpcao  = document.getElementById("opcoes");
		 <? }else{ ?>
		 document.forms[0].local.options.length = 1;
		 idOpcao  = document.getElementById("opcoes");
		 <? } ?>
		 <? if($_POST['cidade_mat']){ ?>
		 opcoes2  = 1;
		 idOpcao2  = document.getElementById("opcoes2");
		 <? }else{ ?>
		 document.forms[0].cidade_mat.options.length = 1;
		 idOpcao2 = document.getElementById("opcoes2");
		 <? } ?>
	     ajax.open("POST", "cidades.php", true);
		 ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 ajax.onreadystatechange = function() {
            if(ajax.readyState == 4 ) {
			   if(ajax.responseXML) {
			      processXML(ajax.responseXML);
			   }
			   else {
				   idOpcao.innerHTML = "Selecione o Estado";
				   idOpcao2.innerHTML = "Selecione o Estado";
			   }
            }
         }
	     var params = "estado="+valor;
         ajax.send(params);
      }
   }
   function processXML(obj){
      var dataArray   = obj.getElementsByTagName("cidade");
	  if(dataArray.length > 0) {
         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var novo = document.createElement("option");
			    novo.setAttribute("ci_cod", "opcoes");
			    novo.value = codigo;
			    novo.text  = descricao;
				document.forms[0].local.options.add(novo);
			var novo1 = document.createElement("option");
			    novo1.setAttribute("ci_cod", "opcoes2");
			    novo1.value = codigo;
			    novo1.text  = descricao;
				document.forms[0].cidade_mat.options.add(novo1);
		 }
	  }
	  else {
		idOpcao.innerHTML = "Selecione o Estado";
		idOpcao2.innerHTML = "Selecione o Estado";
	  }	  
   }
</script>
  <form method="post" name="form1" id="form1" onSubmit="return valida();" action="<?php print("$PHP_SELF"); ?>">
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Finalidade:</b></td>
      <td class="style1"><select name="finalidade" id="finalidade" class="campo" onChange="form1.submit();">
          <option value="">Selecione uma op&ccedil;&atilde;o</option>
          <?php
        $bfinalidade = mysql_query("SELECT f_cod, f_nome FROM finalidade WHERE f_cod!='1' AND f_cod!='8' AND f_cod!='6' AND f_cod!='7' AND f_cod!='14' AND f_cod!='17' ORDER BY f_cod ASC");
 		while($linha = mysql_fetch_array($bfinalidade)){
			if($linha[f_cod]==$_POST['finalidade']){
			   if($linha['f_cod']=='2' || $linha['f_cod']=='9' || $linha['f_cod']=='15'){
			     echo('<option value="'.$linha[f_cod].'" SELECTED>'.$linha['f_nome'].'_'.$_SESSION['nome_imobiliaria'].'</option>'); 
			   }else{
			     echo('<option value="'.$linha[f_cod].'" SELECTED>'.$linha['f_nome'].'</option>'); 
			   }
			}else{
			  if($linha['f_cod']=='2' || $linha['f_cod']=='9' || $linha['f_cod']=='15'){
			    echo('<option value="'.$linha[f_cod].'">'.$linha['f_nome'].'_'.$_SESSION['nome_imobiliaria'].'</option>');
			  }else{
			    echo('<option value="'.$linha[f_cod].'">'.$linha['f_nome'].'</option>');
			  } 
			}
 		}
 	?>
      </select></td>
    </tr>
	<tr bgcolor="#EDEEEE">
      <td width="33%" class=style1><b>Tipo de imóvel:</b></td>
      <td width="67%" class=style1> <select name="tipo1" id="tipo1" class="campo">
      <?
    		$btipo = mysql_query("SELECT t_cod, t_nome FROM rebri_tipo ORDER BY t_nome ASC");
 			while($linha = mysql_fetch_array($btipo)){
				if($linha[t_cod]==$tipo1){
 		     		echo('<option value="'.$linha[t_cod].'" SELECTED>'.$linha['t_nome'].'</option>'); 
		   		}else{
		     		echo('<option value="'.$linha[t_cod].'">'.$linha['t_nome'].'</option>'); 
		   		}
			}
		?>
      </select></td>
    </tr>
	<tr bgcolor="#EDEEEE">
      <td width="33%" class=style1><b>Referência:</b></td>
      <td width="67%" class=style1> <input type="text" name="ref" id="ref" size="10" maxlength="10" class="campo" value="<?=$ref; ?>" onKeyUp="return autoTab(this, 10, event);"> </td>
    </tr>
	<tr bgcolor="#EDEEEE">
      <td width="33%" class=style1><b>Proprietário:</b></td>
      <td width="67%" class=style1>
	       <input type="text" name="cliente" size="5" class="campo2" value="<?php print($cliente); ?>" readonly>
           <input type="text" name="nome_cliente" size="60" class="campo" value='<?php print($nome_cliente); ?>' readonly>
           <input type="button" id="selecionar2" name="selecionar2" value="Selecionar" class="campo3" onClick="window.open('p_list_proprietario2.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
	  </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Dias &uacute;teis:</b></td>
      <td width="67%" class=style1>
          <!--input type="text" name="dias" value="<?php //func_data($data_entrada, $data_saida);  ?>" size="3" class="campo" readonly-->
          <? // } ?>
          <input type="text" name="dias" id="dias" value="<?php if($_POST['dias']){ print($_POST['dias']); }else{ print($not2[dias]); } ?>" size="3" class="campo">
          <font size="1">Obs.: Apenas para im&oacute;veis &agrave; venda</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="33%" class=style1><b>Contrato de:</b></td>
      <td width="67%" class=style1> 
      <input type="text" name="dia" id="dia" size="2" class="campo" maxlenght="2" value="<?php if($_POST['dia']){ print($_POST['dia']); } ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes" id="mes" size="2" class="campo" maxlenght="2" value="<?php if($_POST['mes']){ print($_POST['mes']); } ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano" id="ano" size="4" class="campo" maxlenght="4" value="<?php if($_POST['ano']){ print($_POST['ano']); } ?>" onKeyUp="return autoTab(this, 4, event);"> 
  	  <input type="hidden" id="acao" name="acao" value="0">
	  <input type="button" value="Calcular data final" name="calcular" id="calcular" class="campo3" onClick="form1.action='p_insert_imoveis_avaliacao.php';form1.acao.value='1';form1.submit();">
<?php
if($_POST['acao']==1){
/*
include("calculo.php");

$datai = $_POST['dia']."/".$_POST['mes']."/".$_POST['ano'];
$dataf = $_POST['dia1']."/".$_POST['mes1']."/".$_POST['ano1'];

$dlist=explode('/',$datai); // Pegamos a data que veio do formul&aacute;rio e a explodimos, transformando num array
$tlist=explode(':',date('H:i:s',time())); // Pegamos a hora atual com date('H:i:s',time())) e a explodimos, transformando num array
$datahora=mktime($tlist[0],$tlist[1],$tlist[2],$dlist[1],$dlist[0],$dlist[2]); // Transformamos em formato Unix utilizando os dados de ambos os arrays
$data_entrada = $datahora;

$dlist2=explode('/',$dataf); // Pegamos a data que veio do formul&aacute;rio e a explodimos, transformando num array
$tlist2=explode(':',date('H:i:s',time())); // Pegamos a hora atual com date('H:i:s',time())) e a explodimos, transformando num array
$datahora2=mktime($tlist2[0],$tlist2[1],$tlist2[2],$dlist2[1],$dlist2[0],$dlist2[2]); // Transformamos em formato Unix utilizando os dados de ambos os arrays
$data_saida = $datahora2;
*/

include("calculo2.php");

$datai = $_POST['dia']."/".$_POST['mes']."/".$_POST['ano'];
$diasu = $_POST['dias'];

$data_final = somar_dias_uteis($datai, $diasu);
list($dia1, $mes1, $ano1) = explode('/', $data_final);

} 
?>	  
      <b> à</b> <input type="text" name="dia1" id="dia1" size="2" class="campo" maxlenght="2" value="<?php print($dia1); ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes1" id="mes1" size="2" class="campo" maxlenght="2" value="<?php print($mes1); ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano1" id="ano1" size="4" class="campo" maxlenght="4" value="<?php print($ano1); ?>" onKeyUp="return autoTab(this, 4, event);">
	  <font size="1">Ex.: 
    10/10/1910</td>
    </tr>
    
    <!--tr bgcolor="#EDEEEE">
      <td class=style1><b>Contrato:</b></td>
      <td class=style1><select name="contrato" id="contrato" class="campo">
        <option value="">Selecione um contrato</option>
        <?php
        /*
        	$documentos = mysql_query("select d_cod, d_nome FROM doc WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY d_nome ASC");
 			while($linha = mysql_fetch_array($documentos)){
 		  	$d_nome = substr ($linha[d_nome], 0, 30);
				if($linha[d_cod]==$_POST['contrato']){
					echo('<option value="'.$linha[d_cod].'" title="'.$linha[d_nome].'" SELECTED>'.$d_nome.'...</option>');
				}else{ 			   
					echo('<option value="'.$linha[d_cod].'" title="'.$linha[d_nome].'">'.$d_nome.'...</option>');
				}
 			}
 		*/
 	?>
      </select></td>
    </tr-->
    <tr bgcolor="#EDEEEE">
      <td class=style1><b><? if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ echo("Di&aacute;ria"); }else{ echo("Valor"); }?>:</b></td>
      <td class=style1><input type="text" name="valor" id="valor" size="10" class="campo" value="<?=$valor; ?>">
        <? if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){  echo "<span class=\"style7\"><b>Atenção:</b> Colocar o valor total ao invés de colocar somente o valor da diária senão o cálculo na avaliação não irá ser feito corretamente, posteriormente quando for utilizar esse imóvel para locação atualizar o valor da diária</span>";  } ?> Exemplo:
        50000.00 ou 50000</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Valor Oferta:</b></td>
      <td class=style1><input type="text" name="valor_oferta" id="valor_oferta" size="10" class="campo" value="<?=$valor_oferta; ?>">
        Exemplo:
        50000.00 ou 50000<br>
        <b>Obs.: Ao preencher este valor o im&oacute;vel aparecer&aacute; em destaque</b></td>
    </tr>
<? if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ ?>	
    <tr bgcolor="#EDEEEE">
    <td class=style1><b>Valor Carnaval:</b></td>
      <td class=style1><input type="text" name="carnaval" size="10" class="campo" value="<?php print($carnaval); ?>"> Exemplo:
        50000.00 ou 50000</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Valor Ano Novo:</b></td>
      <td class=style1><input type="text" name="anonovo" size="10" class="campo" value="<?php print($anonovo); ?>"> Exemplo:
        50000.00 ou 50000</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Di&aacute;ria m&iacute;nima/Di&aacute;ria m&aacute;xima:</b></td>
      <td class=style1><input type="text" name="diaria1" id="diaria1" size="10" class="campo" value="<?=$diaria1; ?>">
        /
          <input type="text" name="diaria2" id="diaria2" size="10" class="campo" value="<?=$diaria2; ?>">
        Exemplo:
        50000.00 ou 50000</td>
    </tr>
<? } ?>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Comiss&atilde;o Imobili&aacute;ria:</b></td>
      <td class=style1><input type="text" name="comissao" id="comissao" size="2" class="campo" value="<?=$comissao; ?>">
        Exemplo:
        6 ou 15</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Endere&ccedil;o:</b></td>
      <td class="style1"><input type="text" name="ende" id="ende" size="60" class="campo" value="<?=$ende; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class="style1"><b>Estado:</b></td>
      <td><select name="im_estado" id="im_estado" onChange="Dados(this.value);" class="campo">
          <option value="0">Selecione o Estado</option>
          <?
        if($_SESSION['cod_estadoi'] && empty($_POST['im_estado'])){ 
			$bestados = mysql_query("SELECT e_cod, e_uf FROM rebri_estados ORDER BY e_uf ASC");
 			while($linha = mysql_fetch_array($bestados)){
				if($linha[e_cod]==$_SESSION['cod_estadoi']){
			   		echo('<option value="'.$linha[e_cod].'" SELECTED>'.$linha['e_uf'].'</option>'); 
				}else{
					echo('<option value="'.$linha[e_cod].'">'.$linha['e_uf'].'</option>');
				}
 			}
 		}else{
	        $bestados = mysql_query("SELECT e_cod, e_uf FROM rebri_estados ORDER BY e_uf ASC");
 			while($linha = mysql_fetch_array($bestados)){
				if($linha[e_cod]==$_POST['im_estado']){
			   		echo('<option value="'.$linha[e_cod].'" SELECTED>'.$linha['e_uf'].'</option>'); 
				}else{
					echo('<option value="'.$linha[e_cod].'">'.$linha['e_uf'].'</option>');
				}
 			}
		}	
        ?>
      </select></td>
    </tr>
	      <?
        $contratos = mysql_query("SELECT contrato_venda, contrato_locacao FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
 		while($linha = mysql_fetch_array($contratos)){
            if($_POST['finalidade']=='2' || $_POST['finalidade']=='3' || $_POST['finalidade']=='4' || $_POST['finalidade']=='5' || $_POST['finalidade']=='6' || $_POST['finalidade']=='7'){
			    $contrato = $linha['contrato_venda'];
			}elseif($_POST['finalidade']=='9' || $_POST['finalidade']=='10' || $_POST['finalidade']=='11' || $_POST['finalidade']=='12' || $_POST['finalidade']=='13' || $_POST['finalidade']=='14' || $_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){
			    $contrato = $linha['contrato_locacao'];
			}
         }
         
	  ?>
      
      <input type="hidden" name="contrato" id="contrato" value="<?=$contrato ?>">
<?
if($_SESSION['cod_cidadei'] && empty($_POST['cidade_mat'])){ 
	  		$status = "SELECTED";
	  		$selecionar = '<option value="0">Selecione</option>';	
}else{
    $query21 = "SELECT ci_nome FROM rebri_cidades WHERE ci_cod='".$_POST['cidade_mat']."'";
	$result21 = mysql_query($query21);
	while($not21 = mysql_fetch_array($result21)){
     	if($_POST['cidade_mat']){  
	  		$ncidade_mat = $not21['ci_nome'];
	  		$status = "SELECTED";
	  		$selecionar = '<option value="0">Selecione</option>';
	    }else{
	   		$ncidade_mat = $not21['ci_nome'];
	   		$status = "";
		}	
	}
}
?>    
    <tr bgcolor="#EDEEEE">
      <td width="33%" class="style1"><b>Cidade Mat.:</b></td>
      <td width="67%"><select name="cidade_mat" id="cidade_mat" class="campo">
            <? if($_SESSION['cod_cidadei'] && empty($_POST['cidade_mat'])){ ?> 
			
			<?=$selecionar ?>
			<option id="opcoes2" value="<? echo $_SESSION['cod_cidadei']; ?>" <?=$status ?>><? echo $_SESSION['cidadei'] ?></option>
			<?  
			}else{
			?>
			<?=$selecionar ?>
			<option id="opcoes2" value="<? echo $cidade_mat; ?>" <?=$status ?>><? echo $ncidade_mat ?></option>
			<?
			if($_POST['cidade_mat']){
				$bcidades = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$_POST['im_estado']."' ORDER BY ci_nome ASC");
 				while($linha = mysql_fetch_array($bcidades)){
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
			}
			}
			?>
	     </select></td>
    </tr>
<?
if($_SESSION['cod_cidadei'] && empty($_POST['local'])){ 
	  		$status2 = "SELECTED";
	  		$selecionar2 = '<option value="0">Selecione</option>';	
}else{
	$query20 = "SELECT ci_nome FROM rebri_cidades WHERE ci_cod='".$_POST['local']."'";
	$result20 = mysql_query($query20);
	while($not20 = mysql_fetch_array($result20)){
		if($_POST['local']){  
	  		$nlocal = $not20['ci_nome'];
	  		$status2 = "SELECTED";
	  		$selecionar2 = '<option value="0">Selecione</option>';
		}else{
	   		$nlocal = $not20['ci_nome'];
	   		$status2 = "";
		}	
	}
}
?>
	 <tr bgcolor="#EDEEEE">
      <td width="33%" class="style1"><b>Localização:</b></td>
      <td width="67%"><input type="hidden" name="acaob" id="acaob" value="0">
	  <select name="local" id="local" class="campo" onChange="form1.action='p_insert_imoveis_avaliacao.php';form1.acaob.value='1';form1.submit();">
			<? if($_SESSION['cod_cidadei'] && empty($_POST['local'])){ ?>
			
			<?=$selecionar2 ?>
			<option id="opcoes2" value="<? echo $_SESSION['cod_cidadei']; ?>" <?=$status2 ?>><? echo $_SESSION['cidadei'] ?></option>
			<?  
			}else{
			?>
			<?=$selecionar2 ?>
			<option id="opcoes" value="<? echo $local; ?>" <?=$status2 ?>><? echo $nlocal ?></option>
			<?
			if($_POST['local']){
				$bcidades2 = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$_POST['im_estado']."' ORDER BY ci_nome ASC");
 				while($linha = mysql_fetch_array($bcidades2)){
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
			}
			}
			?>
	     </select></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td colspan="2" class=style1>
	  	 <fieldset><legend><b>Bairros</b></legend>

		<?
		
		 if($_POST['bairro']){
		  $bairro = implode('-', $_POST['bairro']);
		 }
		 		
		function verifica_check($campo_select, $select){
			
			$funcoes = explode("-", $select);
			$funcoes_cnt   = count($funcoes);
 
			for ($i = 0; $i < $funcoes_cnt; $i++) 
 			{
				if($campo_select == $funcoes[$i]){
					echo "checked";
   				}
 			}
  		}
        
        if($_POST['acaob']=='1'){
			$busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$_POST['local']."' ORDER BY b_nome");
			while($linha = mysql_fetch_array($busca_bairros)){
		?>
			<div class="DivBairros"><input type="checkbox" name="bairro[]" value="<?php echo($linha['b_cod']); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>> <?= $linha['b_nome']; ?></div>
		<?
			}
		}else{
		  	$busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$_SESSION['cod_cidadei']."' ORDER BY b_nome");
			while($linha = mysql_fetch_array($busca_bairros)){
		?>
			<div class="DivBairros"><input type="checkbox" name="bairro[]" id="bairro" value="<?php echo($linha['b_cod']); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>> <?= $linha['b_nome']; ?></div>
		<?
			}
		}		
		?>
	  </fieldset>	  </td>
      </tr>
   <tr bgcolor="#EDEEEE">
      <td width="33%" class=style1><b>Título:</b> </td>
      <td width="67%" class=style1> <textarea rows="2" name="titulo" id="titulo" cols="36" class="campo"><?=$titulo?></textarea></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="33%" class=style1><b>Descrição:</b></td>
      <td width="67%" class=style1><textarea rows="5" name="descricao" id="descricao" cols="36" class="campo"><?=$descricao; ?></textarea></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Permuta:</b></td>
      <td class=style1><select name="permuta" id="permuta" class="campo">
          <option value="Sim" <? if($permuta=='Sim'){ print "SELECTED"; } ?>>Sim</option>
          <option value="Não" <? if($permuta=='Não'){ print "SELECTED"; } ?>>N&atilde;o</option>
      </select></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>*Texto da Permuta:</b><br>
        *Preencha esse campo apenas se voc&ecirc; escolheu a op&ccedil;&atilde;o "Sim" no campo Permuta.</td>
      <td class=style1><textarea rows="3" name="permuta_txt" id="permuta_txt" cols="36" class="campo"><?=$permuta_txt; ?></textarea></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>&Aacute;rea constru&iacute;da:</b></td>
      <td class=style1><input type="text" name="metragem" id="metragem" size="10" class="campo" value="<?=$metragem; ?>">
        Exemplo:
        100.00 ou 100</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>&Aacute;rea averbada:</b></td>
      <td class=style1><input type="text" name="averbacao" id="averbacao" size="10" class="campo" value="<?=$averbacao; ?>">
        Exemplo:
        100.00 ou 100</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>&Aacute;rea do terreno: </b></td>
      <td class=style1><input name="area_terreno" type="text" id="area_terreno" size="20" class="campo" value="<?=$area_terreno; ?>">
        Exemplo: 100.00 ou 100</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>N&deg; de
        quartos:</b></td>
      <td class=style1><input type="text" name="n_quartos" id="n_quartos" size="5" class="campo" value="<?=$n_quartos; ?>">
        Exemplo:
        1</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Sendo su&iacute;te:</b></td>
      <td class=style1><input type="text" name="suites" id="suites" size="5" class="campo" value="<?=$suites; ?>">
        Exemplo:
        1</td>
    </tr>
<? if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ ?>	
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Acomoda&ccedil;&otilde;es:</b></td>
      <td class=style1><input type="text" name="acomod" id="acomod" size="2" class="campo" value="<?=$acomod; ?>">
        Exemplo:
        1 ou 10</td>
    </tr>
<? } ?>	
	    <input type="hidden" name="combo" id="combo" value="0">
    <tr bgcolor="#EDEEEE">
      <td width="33%" class=style1><b>Distância do mar:</b></td>
      <td width="67%" class="style1">
        <input name="opcao" id="opcao1" type="radio" value="1" <? if($opcao=='1'){ print "CHECKED"; } ?> OnClick="LimpaCampo();">
        Op&ccedil;&atilde;o 1 - 
         <input type="text" name="dist_mar" id="dist_mar" size="4" class="campo" value="<?=$dist_mar; ?>"> 
        <select name="dist_tipo" id="dist_tipo" class="campo">
          <option value="metros" <? if($dist_tipo=='metros'){ print "SELECTED"; } ?>>metros</option>
          <option value="quadras" <? if($dist_tipo=='quadras'){ print "SELECTED"; } ?>>quadras</option>
          </select>
        <b>ou</b> 
        <input name="opcao" id="opcao2" type="radio" value="2"  <? if($opcao=='2'){ print "CHECKED"; } ?> OnClick="LimpaCampo();">
        Op&ccedil;&atilde;o 2 - 
		<select name="dist_mar1" id="dist_mar1" class="campo">
          <option value="frente para a baía" <? if($dist_tipo=='frente para a baía'){ print "SELECTED"; } ?>>frente para a baía</option>
		  <option value="frente para o mar" <? if($dist_tipo=='frente para o mar'){ print "SELECTED"; } ?>>frente para o mar</option>
      </select></td></tr>
    <tr bgcolor="#EDEEEE">
      <td colspan="2" class=style1><fieldset>
        <legend><b>Caracter&iacute;sticas</b></legend>
        <?
		
		 if($_POST['caracteristica']){
		  $caracteristica = implode('-', $_POST['caracteristica']);
		 }
		 		
		function verifica_check2($campo_select2, $select2){
			
			$funcoes2 = explode("-", $select2);
			$funcoes_cnt2   = count($funcoes2);
 
			for ($i2 = 0; $i2 < $funcoes_cnt2; $i2++) 
 			{
				if($campo_select2 == $funcoes2[$i2]){
					echo "checked";
   				}
 			}
  		}

		$busca_caracteristicas = mysql_query("SELECT * FROM rebri_caracteristicas ORDER BY c_nome");
		while($linha = mysql_fetch_array($busca_caracteristicas)){
		?>
        <div class="DivCaracteristicas">
          <input type="checkbox" name="caracteristica[]" id="caracteristica" value="<?php echo($linha['c_cod']); ?>" <?php verifica_check2("".$linha['c_cod']."", $caracteristica) ?>>
          <?= $linha['c_nome']; ?>
        </div>
        <?
		}
		?>
      </fieldset></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Matr&iacute;cula do im&oacute;vel:</b></td>
      <td class="style1"><input type="text" name="matricula" id="matricula" size="30" class="campo" value="<?=$matricula; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Matr&iacute;cula da &aacute;gua: </b></td>
      <td class=style1><input name="matricula_agua" type="text" id="matricula_agua" size="20" class="campo" value="<?=$matricula_agua; ?>">
        <input name="situacao_agua" id="situacao_agua1" type="radio" value="0" <? if($situacao_agua=='0'){ print "CHECKED"; } ?> checked>
Ligada
<input name="situacao_agua" id="situacao_agua2" type="radio" value="1" <? if($situacao_agua=='1'){ print "CHECKED"; } ?>>
Desligada </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Matr&iacute;cula da luz: </b></td>
      <td class=style1><input name="matricula_luz" type="text" id="matricula_luz" class="campo" value="<?=$matricula_luz; ?>"> <input name="situacao_luz" id="situacao_luz1" type="radio" value="0" <? if($situacao_luz=='0'){ print "CHECKED"; } ?> checked>
Ligada
  <input name="situacao_luz" id="situacao_luz2" type="radio" value="1" <? if($situacao_luz=='1'){ print "CHECKED"; } ?>>
Desligada </td>
    </tr>
<?
	
	$busca_controle = mysql_query("SELECT controle_chave FROM muraski WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY controle_chave DESC LIMIT 0,1");
   	if(mysql_num_rows($busca_controle) > 0){
		while($linha = mysql_fetch_array($busca_controle)){
	        $controle_chave = $linha['controle_chave'] + 1;
		}
    }else{
	    $controle_chave = 1;
	}	
?>
    <tr bgcolor="#EDEEEE">
      <td valign=top class=style1><b>Controle Chaves:</b></td>
      <td class="style1"><input type="text" name="controle_chave" id="controle_chave" size="10" class="campo" value="<?=$controle_chave; ?>" readonly></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td valign=top class=style1><b>Local Chaves:</b></td>
      <td class="style1"><textarea rows="3" name="chaves" id="chaves" cols="36" class="campo"><?=$chaves; ?></textarea></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Zelador:</b></td>
      <td class=style1><input type="text" name="zelador" id="zelador" size="40" class="campo" value="<?=$zelador; ?>"></td>
    </tr>
<? if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ ?>		
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Taxa Limpeza:</b></td>
      <td class=style1><input type="text" name="limpeza" id="limpeza" size="10" class="campo" value="<?=$limpeza; ?>">
        Exemplo:
        50.00 ou 50</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Taxa TV:</b></td>
      <td class=style1><input type="text" name="tv" id="tv" size="10" class="campo" value="<?=$tv; ?>">
        Exemplo:
        50.00 ou 50</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Diarista:</b></td>
      <td class=style1><input type="text" name="co_diarista" id="co_diarista" size="4" class="campo2" value="<?=$co_diarista; ?>" readonly>
          <input type="text" name="nome_diarista" id="nome_diarista" size="40" value="<?=$nome_diarista; ?>" class="campo" readonly>
          <input type="button" id="selecionar2" name="selecionar2" value="Selecionar" class="campo3" onClick="window.open('p_list_diarista.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <strong>Valor:</strong>
          <input type="text" name="comissao_diarista" id="comissao_diarista" size="2" class="campo" value="<?=$comissao_diarista; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Piscineiro:</b></td>
      <td class=style1><input type="text" name="co_piscineiro" id="co_piscineiro" size="4" class="campo2" valeue="<?=$co_piscineiro; ?>" readonly>
          <input type="text" name="nome_piscineiro" id="nome_piscineiro" size="40" value="<?=$nome_piscineiro; ?>" class="campo" readonly>
          <input type="button" id="selecionar3" name="selecionar3" value="Selecionar" class="campo3" onClick="window.open('p_list_piscineiro.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_piscineiro" id="comissao_piscineiro" size="2" class="campo" value="<?=$comissao_piscineiro; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Jardineiro:</b></td>
      <td class=style1><input type="text" name="co_jardineiro" id="co_jardineiro" size="4" value="<?=$co_jardineiro; ?>" class="campo2" readonly>
          <input type="text" name="nome_jardineiro" id="nome_jardineiro" size="40" class="campo" value="<?=$nome_jardineiro; ?>" readonly>
          <input type="button" id="selecionar4" name="selecionar4" value="Selecionar" class="campo3" onClick="window.open('p_list_jardineiro.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_jardineiro" id="comissao_jardineiro" size="2" class="campo" value="<?=$comissao_jardineiro; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Eletricista:</b></td>
      <td class=style1><input type="text" name="co_eletricista" id="co_eletricista" size="4" class="campo2" value="<?=$co_eletricista; ?>" readonly>
          <input type="text" name="nome_eletricista" id="nome_eletricista" size="40" class="campo" value="<?=$nome_eletricista; ?>" readonly>
          <input type="button" id="selecionar5" name="selecionar5" value="Selecionar" class="campo3" onClick="window.open('p_list_eletrecista.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_eletricista" id="comissao_eletricista" size="2" class="campo" value="<?=$comissao_eletricista; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Encanador:</b></td>
      <td class=style1><input type="text" name="co_encanador" id="co_encanador" size="4" class="campo2" value="<?=$co_encanador; ?>" readonly>
          <input type="text" name="nome_encanador" id="nome_encanador" size="40" class="campo" value="<?=$nome_encanador; ?>" readonly>
          <input type="button" id="selecionar6" name="selecionar6" value="Selecionar" class="campo3" onClick="window.open('p_list_encanador.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_encanador" id="comissao_encanador" size="2" class="campo" value="<?=$comissao_encanador; ?>"></td>
    </tr>
<? } ?>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Angariador:</b></td>
      <td class=style1><select name="angariador" id="angariador" class=campo>
      <option value="0">Selecione</option>
          <?
		  if (verificaFuncao("USER_IMOV_INSERT")) { // verifica se pode acessar as areas 
            if($_POST['acaob']=='1'){
				$angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$_POST['angariador']){
						echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
					}else{ 			   
						echo('<option value="'.$linha[u_cod].'">'.$linha[u_email].'</option>');
					}
 				}
 			}else{
			    $angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$u_cod){
						echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
					}else{ 			   
						echo('<option value="'.$linha[u_cod].'">'.$linha[u_email].'</option>');
					}
 				}
			}
 		}else{
 		    if($_POST['acaob']=='1'){ 
		    	$angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$_POST['angariador']){
						echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
					}
 				}
 			}else{
			    $angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$u_cod){
						echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
					}
 				}
			}
		}
?>		
        </select>
<?
$comissoesi = mysql_query("SELECT comissao_angariador, comissao_indicador, comissao_vendedor FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
while($linha = mysql_fetch_array($comissoesi)){
   $comissao_angariador = $linha['comissao_angariador'];
   $comissao_indicador = $linha['comissao_indicador'];
   $comissao_vendedor = $linha['comissao_vendedor'];
}
?>
          <? if (verificaFuncao("USER_IMOV_INSERT")) { // verifica se pode acessar as areas ?>
          <b>Comiss&atilde;o:</b>
          <input type="text" name="tipo_anga" id="tipo_anga" size="2" class="campo" value="<? if($_POST['tipo_anga']){ echo($_POST['tipo_anga']); }else{ echo($comissao_angariador); } ?>">
          <? }else{ ?>
          <input type="hidden" name="tipo_anga" id="tipo_anga" size="2" class="campo" value="<? echo($comissao_angariador); ?>">
          <? } ?>      </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Indicador:</b></td>
      <td class=style1><input type="text" name="co_cliente2" id="co_cliente2" size="4" value="<?=$co_cliente2; ?>" class="campo2" readonly>
          <input type="text" name="nome_cliente2" id="nome_cliente2" size="40" class="campo" value="<?=$nome_cliente2; ?>" readonly>
          <input type="button" id="selecionar1" name="selecionar1" value="Selecionar" class="campo3" onClick="window.open('p_list_clientes2.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <? if (verificaFuncao("USER_IMOV_INSERT")) { // verifica se pode acessar as areas ?>
		  <b>Comiss&atilde;o:</b>
          <input type="text" name="comissao_indicador" id="comissao_indicador" size="2" class="campo" value="<? if($_POST['comissao_indicador']){ echo($_POST['comissao_indicador']); }else{ echo($comissao_indicador); } ?>">
          <? }else{ ?>
          <input type="hidden" name="comissao_indicador" id="comissao_indicador" size="2" class="campo" value="<? echo($comissao_indicador); ?>">
           <? } ?></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <? if (verificaFuncao("USER_IMOV_INSERT")) { // verifica se pode acessar as areas ?>
      <td class=style1><b>Comiss&atilde;o Vendedor:</b></td>
      <td class=style1><input type="text" name="comissao_vendedor" id="comissao_vendedor" size="2" class="campo" value="<? if($_POST['comissao_vendedor']){ echo($_POST['comissao_vendedor']); }else{ echo($comissao_vendedor); } ?>">
      <? }else{ ?>
      <td class=style1><input type="hidden" name="comissao_vendedor" id="comissao_vendedor" size="2" class="campo" value="<? echo($comissao_vendedor); ?>">
      <? } ?>
        Exemplo:
        6 ou 15</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Disponibilizar no site:</b></td>
      <td class="style1"><input name="disponibilizar" id="disponibilizar2" type="radio" value="1" checked  <? if($disponibilizar=='1'){ print "CHECKED"; } ?>>
        Sim
        <input name="disponibilizar" type="radio" id="disponibilizar1" value="0" <? if($disponibilizar=='0'){ print "CHECKED"; } ?>>
        N&atilde;o</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Disponibilizar p/ parceria na rede:</b></td>
      <td class="style1"><input name="disp_rede" id="disp_rede2" type="radio" value="1"  <? if($disp_rede=='1'){ print "CHECKED"; } ?> checked>
        Sim
        <input name="disp_rede" type="radio" id="disp_rede1" value="0" <? if($disp_rede=='0'){ print "CHECKED"; } ?>>
        N&atilde;o</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Comiss&atilde;o oferecida p/ parceria:</b></td>
      <td class="style1"><select name="comissao_parceria" id="comissao_parceria" class="campo" onChange="form1.submit();">
          <option value="">Selecione</option>
          <option value="30" <? if($comissao_parceria=='30'){ echo "SELECTED"; } ?>>30%</option>
		  <option value="40" <? if($comissao_parceria=='40'){ echo "SELECTED"; } ?>>40%</option>
		  <option value="50" <? if($comissao_parceria=='50'){ echo "SELECTED"; } ?>>50%</option>
		  <option value="diferenciado" <? if($comissao_parceria=='diferenciado'){ echo "SELECTED"; } ?>>Diferenciado</option>
        </select>
	<? if($_POST['comissao_parceria']=='diferenciado'){ ?>
        <b>Comissão:</b> <input type="text" name="comissao_diferenciado" id="comissao_diferenciado" size="2" class="campo" value="<?=$comissao_diferenciado; ?>"></td>
	<? } ?>
<?
			$result2 = mysql_query("SELECT d_qtd FROM rebri_destaques WHERE d_tipo='Destaques'");
			$row2 = mysql_fetch_array($result2);
			$quantidade = $row2['d_qtd'];
			
			$result3 = mysql_query("SELECT COUNT(destaque) as contagem FROM muraski WHERE destaque='1' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
			while($row3 = mysql_fetch_array($result3)){
	         	$totald = $row3['contagem'];
	        }

      if($totald >= $quantidade){
?>
	<tr bgcolor="#EDEEEE">
      <td class=style1><b>Destaque no site:</b></td>
      <td class="style1"><span class="style7">Seu limite para disponibilizar imóveis em destaque no site já está no máximo. O limite para disponibilizar destaques no site é: <?=$quantidade ?></span></td>
    </tr>
<? 
	}else{
?>
	<tr bgcolor="#EDEEEE">
      <td class=style1><b>Destaque no site:</b></td>
      <td class="style1"><input name="destaque" id="destaque1" type="radio" value="0"  <? if($destaque=='0'){ print "CHECKED"; } ?> checked>
        N&atilde;o
        <input name="destaque" type="radio" id="destaque2" value="1" <? if($destaque=='1'){ print "CHECKED"; } ?>>
        Sim</td>
    </tr>			
<? 
	} 
?>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><strong>Observa&ccedil;&otilde;es:</strong></td>
      <td class=style1><textarea name="observacoes" id="observacoes" cols="36" rows="5" class="campo"><?=$observacoes; ?></textarea></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Rela&ccedil;&atilde;o de Bens:</b></td>
      <td class=style1><textarea rows="5" name="relacao_bens" id="relacao_bens" cols="36" class="campo"><?=$relacao_bens; ?></textarea></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Coordenadas:</b><br>
        * Entre no site <a href="http://maps.google.com.br" target="_blank">Google Maps</a> e digite o endere&ccedil;o completo, cidade, estado (Ex: rua teste, 10, curitiba, pr) e depois clicar em &quot;Link&quot; e copiar e colar o codigo HTML nesse campo. Veja <a href="images/exemplo.jpg" target="_blank">aqui</a> o exemplo. </td>
      <td class=style1><textarea rows="3" name="coordenadas" id="coordenadas" cols="40" class="campo"><?=$coordenadas; ?></textarea></td>
    </tr>
    <!--tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Especificação:</b></td>
      <td width="73%" class=style1><select size="1" name="especificacao" class="campo">
    <option value="Lançamento" <? //if($especificacao=='Lançamento'){ print "SELECTED"; } ?>>Lançamento</option>
    <option value="Novo" <? //if($especificacao=='Novo'){ print "SELECTED"; } ?>>Novo</option>
    <option value="Semi-Novo" <? //if($especificacao=='Semi-Novo'){ print "SELECTED"; } ?>>Semi-Novo</option>
    <option value="Usado" <? //if($especificacao=='Usado'){ print "SELECTED"; } ?>>Usado</option>
        </select></td>
    </tr-->
    <!--tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Posição X:</b></td>
      <td width="73%" class=style1><input type="text" name="posx" value="<?=$posx; ?>" class="campo" size=10></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Posição Y:</b></td>
      <td width="73%" class=style1><input type="text" name="posy" value="<?=$posy; ?>" class="campo" size=10></td>
    </tr-->
    <!--tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Piscina:</b></td>
      <td width="73%" class=style1><select size="1" name="piscina" class="campo">
    <option value="Não" <?// if($piscina=='Não'){ print "SELECTED"; } ?>>Não</option>
    <option value="Sim" <?// if($piscina=='Sim'){ print "SELECTED"; } ?>>Sim</option>
        </select></td>
    </tr-->
    <!--tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Localização:</b></td>
      <td width="73%" class="style1"><input type="text" name="local" size="30" value="<? //if($_POST['local']){ print($_POST['local']); }else{ print "Guaratuba"; } ?>" class="campo">    </td>
    </tr-->
    <!--tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Cidade Mat.:</b></td>
      <td width="73%" class="style1"><select name="cidade_mat" class="campo">
    <option vlaue="Guaratuba" <?// if($cidade_mat=='Guaratuba'){ print "SELECTED"; } ?>>Guaratuba</option>
    <option value="São José dos Pinhais" <?// if($cidade_mat='São José dos Pinhais'){ print "SELECTED"; } ?>>São José dos Pinhais</option>
        </select></td>
    </tr-->
    <!--tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Tipo Divulgação:</b></td>
      <td width="73%" class=style1><input type="text" name="tipo_div" size="40" class="campo" value="<?=$tipo_div; ?>"></td>
    </tr-->
    <!--tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 1:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_1" size="30" class="campo" value="<?=$ftxt_1; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 2:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_2" size="30" class="campo" value="<?//=$ftxt_2; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 3:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_3" size="30" class="campo" value="<?//=$ftxt_3; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 4:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_4" size="30" class="campo" value="<?//=$ftxt_4; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 5:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_5" size="30" class="campo" value="<?//=$ftxt_5; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 6:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_6" size="30" class="campo" value="<?//=$ftxt_6; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 7:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_7" size="30" class="campo" value="<?//=$ftxt_7; ?>"></td>
    </tr>        
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 8:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_8" size="30" class="campo" value="<?//=$ftxt_8; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 9:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_9" size="30" class="campo" value="<?//=$ftxt_9; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 10:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_10" size="30" class="campo" value="<?//=$ftxt_10; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 11:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_11" size="30" class="campo" value="<?//=$ftxt_11; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 12:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_12" size="30" class="campo" value="<?//=$ftxt_12; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 13:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_13" size="30" class="campo" value="<?//=$ftxt_13; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 14:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_14" size="30" class="campo" value="<?//=$ftxt_14; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 15:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_15" size="30" class="campo" value="<?//=$ftxt_15; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 16:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_16" size="30" class="campo" value="<?//=$ftxt_16; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 17:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_17" size="30" class="campo" value="<?//=$ftxt_17; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 18:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_18" size="30" class="campo" value="<?//=$ftxt_18; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 19:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_19" size="30" class="campo" value="<?//=$ftxt_19; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="27%" class=style1><b>Nome da foto 20:</b></td>
      <td width="73%" class=style1><input type="text" name="ftxt_20" size="30" class="campo" value="<?//=$ftxt_20; ?>"></td>
    </tr-->
    <tr bgcolor="#EDEEEE">
      <td width="33%">
      <input type="hidden" value="1" name="inserir2">
      <input type="submit" value="Inserir Imóvel" name="B1" class="campo3"></td>
      <td width="67%"></td>
    </tr>
  </form>
  </table>
</div></center>
<?php
	}
mysql_close($con);
?>
<?php
/*
	}
	else
	{
*/	  
?>
<?php
//include("login2.php");
?>
<?php
//	}
?>
</body>
</html>