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
<script type="text/javascript" src="funcoes/js.js"></script>
</head>
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

function confirmaExclusao(id, ref)
{
       if(confirm("Tem certeza que deseja excluir?"))
          document.location.href='p_imoveis.php?id_excluir_def=' + id + '&referencia=' + ref;
}

function confirmaExclusao2(id, ref)
{
       if(confirm("Tem certeza que deseja excluir?"))
          document.location.href='p_imoveis.php?id_excluir=' + id + '&referencia=' + ref;
}


</script>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
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
<form  name="form1" id="form1" onSubmit="return valida();" method="post" action="p_imoveis.php">
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
?>
<p>
<?php

	$query2 = "select * from muraski where cod = '".$_GET['cod']."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
	$angariador = $not2[angariador];
	$cod_indicador = $not2[indicador];
	$cod_diarista = $not2[diarista];
	$cod_eletricista = $not2[eletricista];
	$cod_encanador = $not2[encanador];
	$cod_jardineiro = $not2[jardineiro];
	$cod_piscineiro = $not2[piscineiro];
	$contrato = $not2[contrato];
	$disponibilizar = $not2[disponibilizar];
	$disp_rede = $not2[disp_rede];
	$destaque = $not2[destaque];
	$coordenadas = $not2[coordenadas];
	$finalidade = $not2[finalidade];
	$cliente = $not2[cliente];
	$tipo1 = $not2[tipo];
	if($_POST['bcom']!='1'){
		if($not2['comissao_parceria']!=''){
			if($not2['comissao_parceria']!='30' && $not2['comissao_parceria']!='40' && $not2['comissao_parceria']!='50'){
	  			$comissao_parceria = "diferenciado";
	  			$comissao_diferenciado = $not2['comissao_parceria'];
			}else{
	  			$comissao_parceria = $not2['comissao_parceria']; 
			}
		}
	}
	

	if(!empty($not2[dist_tipo])){
	  $dist_mar = $not2[dist_mar];
	  $dist_tipo = $not2[dist_tipo];
	  $opcao = 1;
	}else{
	  $dist_mar1 = $not2[dist_mar];
	  $opcao = 2;
	}
	
	//BUSCA O NOME DO CLIENTE
	$queryC = "select * from clientes where c_cod='$cliente' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultC = mysql_query($queryC);
	while($notC = mysql_fetch_array($resultC))
	{
	   $nome_cliente = $notC[c_nome];
	}
	
	    
	//REALIZA BUSCA DO NOME DO INDICADOR
	$queryI = "select * from clientes where c_cod='$cod_indicador' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultI = mysql_query($queryI);
	while($notI = mysql_fetch_array($resultI))
	{
	   $indicador = $notI[c_nome];
	}
	
	//REALIZA BUSCA DO NOME DA DIARISTA
	$queryD = "select * from clientes where c_cod='$cod_diarista' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultD = mysql_query($queryD);
	while($notD = mysql_fetch_array($resultD))
	{
	   $diarista = $notD[c_nome];
	}
	
	//REALIZA BUSCA DO NOME DO ELETRICISTA
	$queryE = "select * from clientes where c_cod='$cod_eletricista' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultE = mysql_query($queryE);
	while($notE = mysql_fetch_array($resultE))
	{
	   $eletricista = $notE[c_nome];
	}
	
	//REALIZA BUSCA DO NOME DO ENCANADOR
	$queryEN = "select * from clientes where c_cod='$cod_encanador' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultEN = mysql_query($queryEN);
	while($notEN = mysql_fetch_array($resultEN))
	{
	   $encanador = $notEN[c_nome];
	}
	
	//REALIZA BUSCA DO NOME DO JARDINEIRO
	$queryJ = "select * from clientes where c_cod='$cod_jardineiro' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultJ = mysql_query($queryJ);
	while($notJ = mysql_fetch_array($resultJ))
	{
	   $jardineiro = $notJ[c_nome];
	}
	
	//REALIZA BUSCA DO NOME DO PISCINEIRO
	$queryP = "select * from clientes where c_cod='$cod_piscineiro' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultP = mysql_query($queryP);
	while($notP = mysql_fetch_array($resultP))
	{
	   $piscineiro = $notP[c_nome];
	}

    $query20 = "SELECT c.ci_nome FROM rebri_cidades c INNER JOIN muraski m ON (c.ci_cod=m.local) WHERE m.cod='".$not2['cod']."'";
	$result20 = mysql_query($query20);
	while($not20 = mysql_fetch_array($result20)){
	$nlocal = $not20['ci_nome'];
	}
	
	$query30 = "SELECT c.ci_nome FROM rebri_cidades c INNER JOIN muraski m ON (c.ci_cod=m.cidade_mat) WHERE m.cod='".$not2['cod']."'";
	$result30 = mysql_query($query30);
	while($not30 = mysql_fetch_array($result30)){
	$ncidade_mat = $not30['ci_nome'];
	}

?>
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
<div align="center">
  <center>
  <table width="760" border="0" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
  <tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class="style1">
<p align="center" class=style1><b>Editar ou Apagar Imóvel</b></p></td></tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Finalidade:</b></td>
      <td class="style1"><select name="finalidade" id="finalidade" class="campo" onChange="form1.action='p_edit_imoveis.php?cod=<?php echo($cod); ?>&edit=editar';form1.submit();">
         <option value="">Selecione uma op&ccedil;&atilde;o</option>
          <?php
        if($_POST['finalidade']){
        	$bfinalidade = mysql_query("SELECT f_cod, f_nome FROM finalidade WHERE f_cod!='1' AND f_cod!='8' AND f_cod!='7' AND f_cod!='14' AND f_cod!='17' ORDER BY f_cod ASC");
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
 		}else{
 		  if($finalidade=='6'){
		    $bfinalidade = mysql_query("SELECT f_cod, f_nome FROM finalidade WHERE f_cod='6' ORDER BY f_cod ASC");
 			while($linha = mysql_fetch_array($bfinalidade)){
			     echo('<option value="'.$linha[f_cod].'" SELECTED>'.$linha['f_nome'].'</option>'); 
 			}
 		  }else{
		  	$bfinalidade = mysql_query("SELECT f_cod, f_nome FROM finalidade WHERE f_cod!='1' AND f_cod!='8' AND f_cod!='7' AND f_cod!='14' AND f_cod!='17' ORDER BY f_cod ASC");
 			while($linha = mysql_fetch_array($bfinalidade)){
				if($linha[f_cod]==$finalidade){
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
		  }
		}
 	?>
      </select></td>
    </tr>
	<tr bgcolor="#EDEEEE">
      <td width="35%" class=style1><b>Tipo de im&oacute;vel:</b></td>
      <td width="65%" class=style1> <select name="tipo1" id="tipo1" class=campo>
      <?
        if($_POST['tipo1']){
        	$btipo = mysql_query("SELECT t_cod, t_nome FROM rebri_tipo ORDER BY t_nome ASC");
 			while($linha = mysql_fetch_array($btipo)){
				if($linha[t_cod]==$_POST['tipo1']){
 		     		echo('<option value="'.$linha[t_cod].'" SELECTED>'.$linha['t_nome'].'</option>'); 
		   		}else{
		     		echo('<option value="'.$linha[t_cod].'">'.$linha['t_nome'].'</option>'); 
		   		}
			}
		}else{
		  	$btipo = mysql_query("SELECT t_cod, t_nome FROM rebri_tipo ORDER BY t_nome ASC");
 			while($linha = mysql_fetch_array($btipo)){
				if($linha[t_cod]==$tipo1){
 		     		echo('<option value="'.$linha[t_cod].'" SELECTED>'.$linha['t_nome'].'</option>'); 
		   		}else{
		     		echo('<option value="'.$linha[t_cod].'">'.$linha['t_nome'].'</option>'); 
		   		}
			}
		}
      ?>
      </select></td>
    </tr>
	<tr bgcolor="#EDEEEE">
      <td width="35%" class=style1><b>Referência:</b></td>
      <td width="65%" class=style1> <input type="text" class="campo" name="ref" id="ref" size="10" maxlength="10" value="<?php print("$not2[ref]"); ?>" onKeyUp="return autoTab(this, 10, event);"> <a href="p_ref.php" target="_blank" class=style1>Ver referências: usadas e disponíveis</a></td>
    </tr>
   
	
	<tr bgcolor="#EDEEEE">
      <td width="35%" class=style1><b>Proprietário:</b></td>
      <td width="65%" class=style1> <input type="text" name="cliente" size="5" class="campo2" value="<?php print($cliente); ?>" readonly>
           <input type="text" name="nome_cliente" size="60" class="campo" value='<?php print($nome_cliente); ?>' readonly>
           <input type="button" id="selecionar2" name="selecionar2" value="Selecionar" class="campo3" onClick="window.open('p_list_proprietario2.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
	  </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="35%" class=style1><b>Dados do Prop.:</b></td>
      <td width="65%" class=style1> 
      <a href="p_clientes.php?lista=1&c_cod=<?php print("$not2[cliente]"); ?>" class="style1">Clique aqui para visualizar os dados do cliente</a></td>
    </tr>
<?php
	$anoe = substr ($not2[data_inicio], 0, 4);
	$mese = substr($not2[data_inicio], 5, 2 );
	$diae = substr ($not2[data_inicio], 8, 2 );

	$anoe1 = substr ($not2[data_fim], 0, 4);
	$mese1 = substr($not2[data_fim], 5, 2 );
	$diae1 = substr ($not2[data_fim], 8, 2 );

?>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Dias &uacute;teis:</b></td>
      <td class=style1>
        <!--input type="text" name="dias" value="<?php //func_data($data_entrada, $data_saida);  ?>" size="3" class="campo" readonly-->
        <!--input type="text" name="dias" value="<?php //somar_dias_uteis($datai, $diasu);  ?>" size="12" class="campo" readonly-->
        <? // }else{ ?>
        <input type="text" name="dias" id="dias" value="<?php if($_POST['dias']){ print($_POST['dias']); }else{ print($not2[dias]); } ?>" size="3" class="campo">
        <? // } ?>
        Obs.: Apenas para im&oacute;veis &agrave; venda.</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="35%" class=style1><b>Contrato de:</b></td>
      <td width="65%" class=style1> 
      <input type="text" name="diae" id="diae" value="<?php if($_POST['diae']){ print($_POST['diae']); }else{ print($diae); } ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mese" id="mese" value="<?php if($_POST['mese']){ print($_POST['mese']); }else{ print($mese); } ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="anoe" id="anoe" value="<?php if($_POST['anoe']){ print($_POST['anoe']); }else{ print($anoe); } ?>" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);">
	   <input type="hidden" id="acao" name="acao" value="0">
	   <input type="button" value="Calcular data final" name="calcular" id="calcular" class="campo3" onClick="form1.action='p_edit_imoveis.php?cod=<?php echo($cod); ?>&edit=editar';form1.acao.value='1';form1.submit();">
      <b>à</b> 
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

$datai = $_POST['diae']."/".$_POST['mese']."/".$_POST['anoe'];
$diasu = $_POST['dias'];

$data_final = somar_dias_uteis($datai, $diasu);
list($diae1, $mese1, $anoe1) = explode('/', $data_final);

} 
?>  
	  
	  <input type="text" name="diae1" id="diae1" value="<?php print($diae1); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mese1" id="mese1" value="<?php print($mese1); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="anoe1" id="anoe1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print($anoe1); ?>"> Ex.: 
    10/10/1910</td>
    </tr>
    <!--tr bgcolor="#EDEEEE">
      <td class=style1><b>Contrato:</b></td>
      <td class=style1><select size="1" name="contrato" id="contrato" class="campo">
        <option value="">Selecione um contrato</option>
        <?php
        /*
        if($_POST['contrato']){
        	$documentos = mysql_query("select d_cod, d_nome FROM doc WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY d_nome ASC");
 			while($linha = mysql_fetch_array($documentos)){
 		  	$d_nome = substr ($linha[d_nome], 0, 30);
				if($linha[d_cod]==$_POST['contrato']){
					echo('<option value="'.$linha[d_cod].'" title="'.$linha[d_nome].'" SELECTED>'.$d_nome.'...</option>');
				}else{ 			   
					echo('<option value="'.$linha[d_cod].'" title="'.$linha[d_nome].'">'.$d_nome.'...</option>');
				}
         	}
 	  }else{  
        	$documentos = mysql_query("select d_cod, d_nome FROM doc WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY d_nome ASC");
 			while($linha = mysql_fetch_array($documentos)){
 		  	$d_nome = substr ($linha[d_nome], 0, 30);
				if($linha[d_cod]==$contrato){
					echo('<option value="'.$linha[d_cod].'" title="'.$linha[d_nome].'" SELECTED>'.$d_nome.'...</option>');
				}else{ 			   
					echo('<option value="'.$linha[d_cod].'" title="'.$linha[d_nome].'">'.$d_nome.'...</option>');
				}
			}
	  }
      */
 	?>
      </select></td>
    </tr-->
<?php

	if(($not2[finalidade] == "9") or 
	($not2[finalidade] == "10") or 
	($not2[finalidade] == "11") or 
	($not2[finalidade] == "13") or 
	($not2[finalidade] == "12") or 
	($not2[finalidade] == "14") or 
	($not2[finalidade] == "15") or 
	($not2[finalidade] == "16") or 
	($not2[finalidade] == "17")){
?>
<?php
	if($cadastrado == 1){
	//$imovel = substr ($not2[ref], 0, 4);
	$imovel = "ref" . $not2[ref];
?>
<script language="JavaScript"> 
function <?php print("$imovel"); ?>()
{
window.open("p_imp_doc.php?cod=<?php print("$not2[cod]"); ?>&imp=2","1",'toolbar=yes,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=0,width=900,height=400');
}
</script>
   <tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class="style1">
    <p align="left"><b><a href="javascript:<?php print("$imovel"); ?>();" class=style1>Imprimir Contrato</a></b></p></td>
   </tr>
<?php
	}
?>
   <tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class="style1">
    <p align="left"><b><a href="p_rel_loc.php?cod=<?php print("$not2[cod]"); ?>" class=style1>Visualizar Relatório de Locações</a></b></p></td>
  </tr>
  <tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class="style1">
    <p align="left"><b><a href="p_extrato_locacao.php?cod_imovel=<?php print("$not2[cod]"); ?>" target="_blank" class=style1>Extrato de Locações</a></b></p></td>
  </tr>
<?php
	}
	else
	{
?>
<?php
	if($cadastrado == 1){
	//$imovel = substr ($not2[ref], 0, 4);
	$imovel1 = "ref1" . $not2[ref];
	$imovel3 = "ref3" . $not2[ref];
?>
<script language="JavaScript"> 
function <?php print("$imovel1"); ?>()
{
window.open("p_imp_doc.php?cod=<?php print("$not2[cod]"); ?>&imp=5","1",'toolbar=yes,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=0,width=900,height=400');
}
</script>
<script language="JavaScript"> 
function <?php print("$imovel3"); ?>()
{
window.open("p_imp_doc.php?cod=<?php print("$not2[cod]"); ?>&imp=4","1",'toolbar=yes,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=0,width=900,height=400');
}
</script>
    <tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class="style1">
    <p align="left"><b><a href="javascript:<?php print("$imovel1"); ?>();" class=style1>Imprimir Contrato</a></b></p></td></tr>
    <tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class="style1">
    <p align="left"><b><a href="javascript:<?php print("$imovel3"); ?>();" class=style1>Imprimir Renovação</a></b></p></td></tr>
<?php
	}
	$imovel2 = "ref2" . $not2[ref];
?>
<script language="JavaScript"> 
function <?php print("$imovel2"); ?>()
{
window.open("p_imp_doc.php?cod=<?php print("$not2[cod]"); ?>&imp=7","1",'toolbar=yes,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=0,width=900,height=400');
}
</script>
	<tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class="style1">
    <p align="left"><b><a href="p_rel_int.php?cod=<?php print("$not2[cod]"); ?>" class=style1>Visualizar Relatório de Interessados</a></b></p></td></tr>
	<tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class="style1">
    <p align="left"><b><a href="javascript:<?php print("$imovel2"); ?>();" class=style1>Fazer proposta de Compra</a></b></p></td></tr>
<?php
	}
?>
<script language="JavaScript"> 
function <?php print("imovel_bens"); ?>()
{
window.open("p_imp_bens.php?cod=<?php print("$not2[cod]"); ?>&codi=<?=$_SESSION['cod_imobiliaria']?>","1",'toolbar=yes,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=0,width=900,height=400');
}
</script>
    <tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class="style1">
    <p align="left"><b><a href="javascript:<?php print("imovel_bens"); ?>();" class=style1>Imprimir Relação de bens</a></b></p></td></tr>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td colspan=2 class="style1"><b><a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo("$not2[cod]"); ?>';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b></td>
    </tr>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td colspan=2 class="style1"><b><a href="#" onClick="NewWindow('','uprelatorio2','800','600','yes');form1.target='uprelatorio2';form1.action='cadastro_anuncios2.php?cod=<?php echo("$not2[cod]"); ?>';form1.submit();" class=style1>Editar An&uacute;ncios</a></b></td>
    </tr>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td colspan=2 class="style1"><b><a href="p_rel_anuncios.php?cod=<?php print("$not2[cod]"); ?>" class=style1>Visualizar Relat&oacute;rio de An&uacute;ncios </a><a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo("$not2[cod]"); ?>';form1.submit();" class=style1></a></b></td>
    </tr>
<?
		$contagem = mysql_query("SELECT co_status FROM contas WHERE co_imovel='".$not2[cod]."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_tipo!='Despesas Imóvel'");
 		while($linha = mysql_fetch_array($contagem)){
		  if($linha['co_status']=='pendente'){
		      $pendente = count($linha['co_status']);
		  }elseif($linha['co_status']=='ok'){
		      $ok = count($linha['co_status']);	
		  }  
		}
       if($pendente == 0 && $ok > 0){
?>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td colspan=2 class="style1"><b><a href="#" onClick="NewWindow('','uprelatorio','500','250','yes');form1.target='uprelatorio';form1.action='despesas.php?cod=<?php echo("$not2[cod]"); ?>';form1.submit();" class=style1>Despesas do Imóvel</a></b></td>
    </tr>
<? } ?>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b><? if($_POST['finalidade']){ if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ echo("Di&aacute;ria"); }else{ echo("Valor"); } }else{  if($not2[finalidade]=='15' || $not2[finalidade]=='16' || $not2[finalidade]=='17'){ echo("Di&aacute;ria"); }else{ echo("Valor"); } } ?>:</b></td>
      <td class=style1><input type="text" class="campo" name="valor" id="valor" size="10" value="<?php print("$not2[valor]"); ?>">
        Exemplo:
        50000.00 ou 50000</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Valor Oferta:</b></td>
      <td class=style1><input type="text" name="valor_oferta" id="valor_oferta" size="10" class="campo" value="<?php print("$not2[valor_oferta]"); ?>">
        Exemplo:
        50000.00 ou 50000<br>
        <b> Obs.: Ao preencher este valor o im&oacute;vel aparecer&aacute; em destaque</b></td>
    </tr>
<? 
	if($_POST['finalidade']){   
		if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ 
?>
    <tr bgcolor="#EDEEEE">
    <td class=style1><b>Valor Carnaval:</b></td>
      <td class=style1><input type="text" name="carnaval" size="10" class="campo" value="<?php print("$not2[carnaval]"); ?>"> Exemplo:
        50000.00 ou 50000</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Valor Ano Novo:</b></td>
      <td class=style1><input type="text" name="anonovo" size="10" class="campo" value="<?php print("$not2[anonovo]"); ?>"> Exemplo:
        50000.00 ou 50000</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Di&aacute;ria m&iacute;nima/Di&aacute;ria m&aacute;xima:</b></td>
      <td class=style1><input type="text" name="diaria1" id="diaria1" size="10" class="campo" value="<?php print("$not2[diaria1]"); ?>">
        /
          <input type="text" name="diaria2" id="diaria2" size="10" class="campo" value="<?php print("$not2[diaria2]"); ?>">
        Exemplo:
        50000.00 ou 50000</td>
    </tr>
<? 		
		} 
    }else{
		if($not2[finalidade]=='15' || $not2[finalidade]=='16' || $not2[finalidade]=='17'){ 
?>		
		<tr bgcolor="#EDEEEE">
    <td class=style1><b>Valor Carnaval:</b></td>
      <td class=style1><input type="text" name="carnaval" size="10" class="campo" value="<?php print("$not2[carnaval]"); ?>"> Exemplo:
        50000.00 ou 50000</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Valor Ano Novo:</b></td>
      <td class=style1><input type="text" name="anonovo" size="10" class="campo" value="<?php print("$not2[anonovo]"); ?>"> Exemplo:
        50000.00 ou 50000</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Di&aacute;ria m&iacute;nima/Di&aacute;ria m&aacute;xima:</b></td>
      <td class=style1><input type="text" name="diaria1" id="diaria1" size="10" class="campo" value="<?php print("$not2[diaria1]"); ?>">
        /
          <input type="text" name="diaria2" id="diaria2" size="10" class="campo" value="<?php print("$not2[diaria2]"); ?>">
        Exemplo:
        50000.00 ou 50000</td>
    </tr>	
<?		
		}
	}

?>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Comiss&atilde;o Imobili&aacute;ria:</b></td>
      <td class=style1><input type="text" name="comissao" id="comissao" size="2" class="campo" value="<?php print("$not2[comissao]"); ?>">
        Exemplo:
        6 ou 15</td>
    </tr>
     <tr bgcolor="#EDEEEE">
      <td class=style1><b>Endere&ccedil;o:</b></td>
      <td class="style1"><input type="text" name="ende" id="ende" size="60" class="campo" value="<?php print("$not2[end]"); ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class="style1"><b>Estado:</b></td>
      <td class="style1"><select name="im_estado" id="im_estado" onChange="Dados(this.value);" class="campo">
          <option value="0">Selecione o Estado</option>
          <?
        if($_POST['im_estado']){
        	$bestados = mysql_query("SELECT e_cod, e_uf FROM rebri_estados ORDER BY e_uf ASC");
 			while($linha = mysql_fetch_array($bestados)){
				if($linha[e_cod]==$_POST['im_estado']){
			   		echo('<option value="'.$linha[e_cod].'" SELECTED>'.$linha['e_uf'].'</option>'); 
				}else{ 			   
					echo('<option value="'.$linha[e_cod].'">'.$linha['e_uf'].'</option>');
				}
 	
 			}
 		}else{ 		
 		$bestados = mysql_query("SELECT e_cod, e_uf FROM rebri_estados ORDER BY e_uf ASC");
 			while($linha = mysql_fetch_array($bestados)){
				if($linha[e_cod]==$not2['uf']){
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
    if($_POST['finalidade']){
        $contratos = mysql_query("SELECT contrato_venda, contrato_locacao FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
 		while($linha = mysql_fetch_array($contratos)){
            if($_POST['finalidade']=='2' || $_POST['finalidade']=='3' || $_POST['finalidade']=='4' || $_POST['finalidade']=='5' || $_POST['finalidade']=='6' || $_POST['finalidade']=='7'){
			    $contrato = $linha['contrato_venda'];
			}elseif($_POST['finalidade']=='9' || $_POST['finalidade']=='10' || $_POST['finalidade']=='11' || $_POST['finalidade']=='12' || $_POST['finalidade']=='13' || $_POST['finalidade']=='14' || $_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){
			    $contrato = $linha['contrato_locacao'];
			}
         }
    }else{
	     $contrato = $not2['contrato'];
	}
	  ?>
      
      <input type="hidden" name="contrato" id="contrato" value="<?=$contrato ?>">
    
<?
if($_POST['cidade_mat']){
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
}elseif($not2[cidade_mat]){
    $query21 = "SELECT ci_nome FROM rebri_cidades WHERE ci_cod='".$not2[cidade_mat]."'";
	$result21 = mysql_query($query21);
	while($not21 = mysql_fetch_array($result21)){
	if($not2[cidade_mat]){  
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
      <td width="35%" class="style1"><b>Cidade Mat.:</b></td>
      <td width="65%" class="style1"><select name="cidade_mat" id="cidade_mat" class="campo">
<? if($_POST['cidade_mat']){ ?>      
            <?=$selecionar ?>       
			<option id="opcoes2" value="<? echo $cidade_mat; ?>" <?=$status ?>><? echo $ncidade_mat ?></option>
			<?
			if($_POST['cidade_mat']){
				$bcidades = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$_POST['im_estado']."' ORDER BY ci_nome ASC");
 				while($linha = mysql_fetch_array($bcidades)){
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
			}
			?>
<? }else{ ?>
            <?=$selecionar ?>
			<option id="opcoes2" value="<? echo $not2[cidade_mat]; ?>" <?=$status ?>><? echo $ncidade_mat ?></option>
			<?
			if($not2['uf']){
				$bcidades = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$not2['uf']."' ORDER BY ci_nome ASC");
 				while($linha = mysql_fetch_array($bcidades)){
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
			}
			?>
<? } ?>
	     </select></td>
    </tr>
<?
if($_POST['local']){
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
}elseif($not2[local]){
    $query20 = "SELECT ci_nome FROM rebri_cidades WHERE ci_cod='".$not2[local]."'";
	$result20 = mysql_query($query20);
	while($not20 = mysql_fetch_array($result20)){
	if($not2[local]){  
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
      <td width="35%" class="style1"><b>Localização:</b></td>
      <td width="65%" class="style1"><input type="hidden" name="acaoba" id="acaoba" value="0">
	  <select name="local" id="local" class="campo" onChange="form1.action='p_edit_imoveis.php?cod=<?php echo($cod); ?>&edit=editar';form1.acaoba.value='1';form1.submit();">
<? if($_POST['local']){ ?>  
           	<?=$selecionar2 ?>            
			<option id="opcoes" value="<? echo $local ?>" <?=$status2 ?>><? echo $nlocal ?></option>
			<?
			if($_POST['local']){
				$bcidades2 = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$_POST['im_estado']."' ORDER BY ci_nome ASC");
 				while($linha = mysql_fetch_array($bcidades2)){
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
			}
			?>
<? }else{ ?>
            <?=$selecionar2 ?> 
			<option id="opcoes" value="<? echo $not2[local]; ?>" <?=$status2 ?>><? echo $nlocal ?></option>
			<?
			if($not2['uf']){
				$bcidades2 = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$not2['uf']."' ORDER BY ci_nome ASC");
 				while($linha = mysql_fetch_array($bcidades2)){
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
			}
			?>
<? } ?>            
	     </select></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td colspan="2" class=style1>
	  	   <fieldset><legend><b>Bairros</b></legend>
	  <?
	    
	    if($_POST['bairro']){
		  $bairro = implode('-', $_POST['bairro']);
		}else{
		  $bairro = $not2['bairro'];
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

		if($_POST['local']){
			$busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$_POST['local']."' ORDER BY b_nome");
			while($linha = mysql_fetch_array($busca_bairros)){
		?>
			<div class="DivBairros"><input type="checkbox" name="bairro[]" id="bairro" value="<?php echo($linha['b_cod']); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>><?= $linha['b_nome']; ?></div>

		<?
			}
		}else{
		  	$busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$not2['local']."' ORDER BY b_nome");
			while($linha = mysql_fetch_array($busca_bairros)){
		?>
			<div class="DivBairros"><input type="checkbox" name="bairro[]" id="bairro" value="<?php echo($linha['b_cod']); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>><?= $linha['b_nome']; ?></div>

		<?
			}
		}
		?>
	  </fieldset>	  </td>
    </tr>
   <tr bgcolor="#EDEEEE">
      <td width="35%" class=style1><b>Título:</b> </td>
      <td width="65%" class=style1> <textarea rows="2" class="campo" name="titulo" id="titulo" cols="36"><?php
      $not2[titulo] = stripslashes($not2[titulo]);
      print("$not2[titulo]");
      ?></textarea></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="35%" class=style1><b>Descrição:</b></td>
      <td width="65%" class=style1> <textarea rows="5" class="campo" name="descricao" id="descricao" cols="36"><?php
      $not2[descricao] = stripslashes($not2[descricao]);
      print("$not2[descricao]");
      ?></textarea></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Permuta:</b></td>
      <td class=style1><select class="campo" name="permuta" id="permuta">
          <option selected><?php print("$not2[permuta]"); ?></option>
          <option>Sim</option>
          <option>N&atilde;o</option>
      </select></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>*Texto da Permuta:</b><br>
        *Preencha esse campo apenas se voc&ecirc; escolheu a op&ccedil;&atilde;o "Sim" no campo Permuta.</td>
      <td class=style1><textarea rows="3" class="campo" name="permuta_txt" id="permuta_txt" cols="36"><?php $not2[permuta_txt] = stripslashes($not2[permuta_txt]); print("$not2[permuta_txt]"); ?></textarea></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="35%" class=style1><b>&Aacute;rea constru&iacute;da:</b></td>
      <td width="65%" class=style1> <input type="text" class="campo" name="metragem" id="metragem" size="10" value="<?php print("$not2[metragem]"); ?>"> Exemplo:
        100.00 ou 100</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>&Aacute;rea averbada:</b></td>
      <td class=style1><input type="text" name="averbacao" id="averbacao" size="10" class="campo" value="<?php print("$not2[averbacao]"); ?>">
        Exemplo:
        100.00 ou 100</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>&Aacute;rea do terreno: </b></td>
      <td class=style1><input name="area_terreno" type="text" id="area_terreno" size="20" class="campo" value="<?= $not2['area_terreno'] ?>"> Exemplo: 100.00 ou 100</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>N&deg; de
        quartos:</b></td>
      <td class=style1><input type="text" class="campo" name="n_quartos" id="n_quartos" size="5" value="<?php print("$not2[n_quartos]"); ?>">
        Exemplo:
        1</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Sendo su&iacute;te:</b></td>
      <td class=style1><input type="text" class="campo" name="suites" id="suites" size="5" value="<?php print("$not2[suites]"); ?>">
        Exemplo:
        1</td>
    </tr>
<? 
	if($_POST['finalidade']){   
		if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ 
?>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Acomoda&ccedil;&otilde;es:</b></td>
      <td class=style1><input type="text" name="acomod" id="acomod" size="2" class="campo" value="<?php print("$not2[acomod]"); ?>">
        Exemplo:
        1 ou 10</td>
    </tr>
<? 		
		} 
    }else{
		if($not2[finalidade]=='15' || $not2[finalidade]=='16' || $not2[finalidade]=='17'){ 
?>	
	 <tr bgcolor="#EDEEEE">
      <td class=style1><b>Acomoda&ccedil;&otilde;es:</b></td>
      <td class=style1><input type="text" name="acomod" id="acomod" size="2" class="campo" value="<?php print("$not2[acomod]"); ?>">
        Exemplo:
        1 ou 10</td>
    </tr>
<? 
		}
	}
?>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Dist&acirc;ncia do mar:</b></td>
      <td class="style1"><input name="opcao" id="opcao1" type="radio" value="1" <? if($opcao=='1'){ echo "CHECKED"; } ?> OnClick="LimpaCampo();">
        Op&ccedil;&atilde;o 1 -
        <input type="text" name="dist_mar" id="dist_mar" size="4" class="campo" value="<?php print("$dist_mar"); ?>">
        <select name="dist_tipo" id="dist_tipo" class="campo">
          <option <? if($dist_tipo=='metros'){ echo "SELECTED"; } ?>>metros</option>
          <option <? if($dist_tipo=='quadras'){ echo "SELECTED"; } ?>>quadras</option>
        </select>
        <b>ou</b>
        <input name="opcao" id="opcao2" type="radio" value="2" <? if($opcao=='2'){ echo "CHECKED"; } ?> OnClick="LimpaCampo();">
        Op&ccedil;&atilde;o 2 -
        <select size="1" name="dist_mar1" id="dist_mar1" class="campo">
          <option <? if($dist_mar1=='frente para a ba&iacute;a'){ echo "SELECTED"; } ?>>frente para a ba&iacute;a</option>
          <option <? if($dist_mar1=='frente para o mar'){ echo "SELECTED"; } ?>>frente para o mar</option>
        </select>      </td>
    </tr>
   <tr bgcolor="#EDEEEE">
      <td colspan="2" class=style1><fieldset>
        <legend><b>Caracter&iacute;sticas</b></legend>
        <?
	    
	    if($_POST['caracteristica']){
		  $caracteristica = implode('-', $_POST['caracteristica']);
		}else{
		  $caracteristica = $not2['caracteristica'];
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
     <td class="style1"><input type="text" name="matricula" id="matricula" size="30" class="campo" value="<?php print("$not2[matricula]"); ?>">     </td>
   </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Matr&iacute;cula &aacute;gua: </b></td>
      <td class=style1><input name="matricula_agua" type="text" id="matricula_agua" size="20" class="campo" value="<?= $not2['matricula_agua'] ?>">
        <input name="situacao_agua" id="situacao_agua1" type="radio" value="0"  <? if($not2['situacao_luz'] == 0) { echo "checked"; } ?>>
Ligada
<input name="situacao_agua" id="situacao_agua2" type="radio" value="1" <? if($not2['situacao_luz'] == 1) { echo "checked"; } ?>>
Desligada </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Matr&iacute;cula da luz: </b></td>
      <td class=style1><input name="matricula_luz" type="text" id="matricula_luz" class="campo" value="<?= $not2['matricula_luz'] ?>">
        <input name="situacao_luz" id="situacao_luz1" type="radio" value="0" <? if($not2['situacao_luz'] == 0) { echo "checked"; } ?>>
Ligada
<input name="situacao_luz" id="situacao_luz2" type="radio" value="1" <? if($not2['situacao_luz'] == 1) { echo "checked"; } ?>>
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
      <td class="style1"><textarea rows="3" name="chaves" id="chaves" cols="36" class="campo"><?php print("$not2[chaves]"); ?></textarea></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Zelador:</b></td>
      <td class=style1><input type="text" name="zelador" id="zelador" size="40" class="campo" value="<?php print("$not2[zelador]"); ?>"></td>
    </tr>
<? 
	if($_POST['finalidade']){   
		if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ 
?>
    <tr bgcolor="#EDEEEE">
      <td width="35%" class=style1><b>Taxa Limpeza:</b></td>
      <td width="65%" class=style1><input type="text" name="limpeza" id="limpeza" size="10" class="campo" value="<?php print("$not2[limpeza]"); ?>"> Exemplo:
        50.00 ou 50</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Taxa TV:</b></td>
      <td class=style1><input type="text" name="tv" id="tv" size="10" class="campo" value="<?php print("$not2[tv]"); ?>">
        Exemplo:
        50.00 ou 50</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Diarista:</b></td>
      <td class=style1><input type="text" name="co_diarista" id="co_diarista" size="4" class="campo2" value="<?php print("$cod_diarista"); ?>" readonly>
          <input type="text" name="nome_diarista" id="nome_diarista" size="30" class="campo" value="<?php print("$diarista"); ?>" readonly>
          <input type="button" id="selecionar4" name="selecionar4" value="Selecionar" class="campo3" onClick="window.open('p_list_diarista.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_diarista" id="comissao_diarista" size="2" class="campo" value="<?php print("$not2[comissao_diarista]"); ?>">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_diarista], 2, ',', '.')); ?>&prestador=<? echo($cod_diarista); ?>&tipo_prestador=diarista';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--> </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Piscineiro:</b></td>
      <td class=style1><input type="text" name="co_piscineiro" id="co_piscineiro" size="4" class="campo2" value="<?php print("$cod_piscineiro"); ?>" readonly>
          <input type="text" name="nome_piscineiro" id="nome_piscineiro" size="30" class="campo" value="<?php print("$piscineiro"); ?>" readonly>
          <input type="button" id="selecionar5" name="selecionar5" value="Selecionar" class="campo3" onClick="window.open('p_list_piscineiro.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_piscineiro" id="comissao_piscineiro" size="2" class="campo" value="<?php print("$not2[comissao_piscineiro]"); ?>">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_piscineiro], 2, ',', '.')); ?>&prestador=<? echo($cod_piscineiro); ?>&tipo_prestador=piscineiro';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Jardineiro:</b></td>
      <td class=style1><input type="text" name="co_jardineiro" id="co_jardineiro" size="4" class="campo2" value="<?php print("$cod_jardineiro"); ?>" readonly>
          <input type="text" name="nome_jardineiro" id="nome_jardineiro" size="30" class="campo" value="<?php print("$jardineiro"); ?>" readonly>
          <input type="button" id="selecionar6" name="selecionar6" value="Selecionar" class="campo3" onClick="window.open('p_list_jardineiro.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_jardineiro" id="comissao_jardineiro" size="2" class="campo" value="<?php print("$not2[comissao_jardineiro]"); ?>">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_jardineiro], 2, ',', '.')); ?>&prestador=<? echo($cod_jardineiro); ?>&tipo_prestador=jardineiro';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Eletricista:</b></td>
      <td class=style1><input type="text" name="co_eletricista" id="co_eletricista" size="4" class="campo2" value="<?php print("$cod_eletricista"); ?>" readonly>
          <input type="text" name="nome_eletricista" id="nome_eletricista" size="30" class="campo" value="<?php print("$eletricista"); ?>" readonly>
          <input type="button" id="selecionar7" name="selecionar7" value="Selecionar" class="campo3" onClick="window.open('p_list_eletrecista.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_eletricista" id="comissao_eletricista" size="2" class="campo" value="<?php print("$not2[comissao_eletricista]"); ?>">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_eletricista], 2, ',', '.')); ?>&prestador=<? echo($cod_eletricista); ?>&tipo_prestador=eletricista';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Encanador:</b></td>
      <td class=style1><input type="text" name="co_encanador" id="co_encanador" size="4" class="campo2" value="<?php print("$cod_encanador"); ?>" readonly>
          <input type="text" name="nome_encanador" id="nome_encanador" size="30" class="campo" value="<?php print("$encanador"); ?>" readonly>
          <input type="button" id="selecionar8" name="selecionar8" value="Selecionar" class="campo3" onClick="window.open('p_list_encanador.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_encanador" id="comissao_encanador" size="2" class="campo" value="<?php print("$not2[comissao_encanador]"); ?>">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_encanador], 2, ',', '.')); ?>&prestador=<? echo($cod_encanador); ?>&tipo_prestador=encanador';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
<? 		
		} 
    }else{
		if($finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
?>
		    <tr bgcolor="#EDEEEE">
      <td width="35%" class=style1><b>Taxa Limpeza:</b></td>
      <td width="65%" class=style1><input type="text" name="limpeza" id="limpeza" size="10" class="campo" value="<?php print("$not2[limpeza]"); ?>"> Exemplo:
        50.00 ou 50</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Taxa TV:</b></td>
      <td class=style1><input type="text" name="tv" id="tv" size="10" class="campo" value="<?php print("$not2[tv]"); ?>">
        Exemplo:
        50.00 ou 50</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Diarista:</b></td>
      <td class=style1><input type="text" name="co_diarista" id="co_diarista" size="4" class="campo2" value="<?php print("$cod_diarista"); ?>" readonly>
          <input type="text" name="nome_diarista" id="nome_diarista" size="30" class="campo" value="<?php print("$diarista"); ?>" readonly>
          <input type="button" id="selecionar4" name="selecionar4" value="Selecionar" class="campo3" onClick="window.open('p_list_diarista.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_diarista" id="comissao_diarista" size="2" class="campo" value="<?php print("$not2[comissao_diarista]"); ?>">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_diarista], 2, ',', '.')); ?>&prestador=<? echo($cod_diarista); ?>&tipo_prestador=diarista';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--> </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Piscineiro:</b></td>
      <td class=style1><input type="text" name="co_piscineiro" id="co_piscineiro" size="4" class="campo2" value="<?php print("$cod_piscineiro"); ?>" readonly>
          <input type="text" name="nome_piscineiro" id="nome_piscineiro" size="30" class="campo" value="<?php print("$piscineiro"); ?>" readonly>
          <input type="button" id="selecionar5" name="selecionar5" value="Selecionar" class="campo3" onClick="window.open('p_list_piscineiro.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_piscineiro" id="comissao_piscineiro" size="2" class="campo" value="<?php print("$not2[comissao_piscineiro]"); ?>">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_piscineiro], 2, ',', '.')); ?>&prestador=<? echo($cod_piscineiro); ?>&tipo_prestador=piscineiro';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Jardineiro:</b></td>
      <td class=style1><input type="text" name="co_jardineiro" id="co_jardineiro" size="4" class="campo2" value="<?php print("$cod_jardineiro"); ?>" readonly>
          <input type="text" name="nome_jardineiro" id="nome_jardineiro" size="30" class="campo" value="<?php print("$jardineiro"); ?>" readonly>
          <input type="button" id="selecionar6" name="selecionar6" value="Selecionar" class="campo3" onClick="window.open('p_list_jardineiro.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_jardineiro" id="comissao_jardineiro" size="2" class="campo" value="<?php print("$not2[comissao_jardineiro]"); ?>">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_jardineiro], 2, ',', '.')); ?>&prestador=<? echo($cod_jardineiro); ?>&tipo_prestador=jardineiro';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Eletricista:</b></td>
      <td class=style1><input type="text" name="co_eletricista" id="co_eletricista" size="4" class="campo2" value="<?php print("$cod_eletricista"); ?>" readonly>
          <input type="text" name="nome_eletricista" id="nome_eletricista" size="30" class="campo" value="<?php print("$eletricista"); ?>" readonly>
          <input type="button" id="selecionar7" name="selecionar7" value="Selecionar" class="campo3" onClick="window.open('p_list_eletrecista.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_eletricista" id="comissao_eletricista" size="2" class="campo" value="<?php print("$not2[comissao_eletricista]"); ?>">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_eletricista], 2, ',', '.')); ?>&prestador=<? echo($cod_eletricista); ?>&tipo_prestador=eletricista';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Encanador:</b></td>
      <td class=style1><input type="text" name="co_encanador" id="co_encanador" size="4" class="campo2" value="<?php print("$cod_encanador"); ?>" readonly>
          <input type="text" name="nome_encanador" id="nome_encanador" size="30" class="campo" value="<?php print("$encanador"); ?>" readonly>
          <input type="button" id="selecionar8" name="selecionar8" value="Selecionar" class="campo3" onClick="window.open('p_list_encanador.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <b>Valor:</b>
          <input type="text" name="comissao_encanador" id="comissao_encanador" size="2" class="campo" value="<?php print("$not2[comissao_encanador]"); ?>">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_encanador], 2, ',', '.')); ?>&prestador=<? echo($cod_encanador); ?>&tipo_prestador=encanador';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
<? 
		}
	}
?>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Angariador:</b></td>
      <td class=style1><select name="angariador" id="angariador" class=campo>
      <option value="0">Selecione</option>
          <?
		 if (verificaFuncao("USER_IMOV_EDIT")) { // verifica se pode acessar as areas 
            if($_POST['angariador']){
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
					if($linha[u_cod]==$angariador){
						echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
					}else{ 			   
						echo('<option value="'.$linha[u_cod].'">'.$linha[u_email].'</option>');
					}
 				}
			}
 		}else{
 		    if($_POST['angariador']){ 
		    	$angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$_POST['angariador']){
						echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
					}
 				}
 			}else{
			    $angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$angariador){
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
          <? if (verificaFuncao("USER_IMOV_EDIT")) { // verifica se pode acessar as areas ?>
          <b>Comiss&atilde;o:</b>
          <input type="text" name="tipo_anga" id="tipo_anga" size="2" class="campo" value="<? if($_POST['tipo_anga']){ echo($_POST['tipo_anga']); }elseif($not2[tipo_anga]){ echo($not2[tipo_anga]); }else{ echo($comissao_angariador); } ?>">
          <? }else{ ?>
          <input type="hidden" name="tipo_anga" id="tipo_anga" size="2" class="campo" value="<? echo($comissao_angariador); ?>">
          <? } ?>      </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Indicador:</b></td>
      <td class=style1><input type="text" name="co_cliente2" id="co_cliente2" size="4" class="campo2" value="<?php print("$cod_indicador"); ?>" readonly>
          <input type="text" name="nome_cliente2" id="nome_cliente2" size="40" class="campo" value="<?php print("$indicador"); ?>" readonly>
          <input type="button" id="selecionar3" name="selecionar3" value="Selecionar" class="campo3" onClick="window.open('p_list_clientes2.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
          <? if (verificaFuncao("USER_IMOV_EDIT")) { // verifica se pode acessar as areas ?>
		  <b>Comiss&atilde;o:</b>
               <input type="text" name="comissao_indicador" id="comissao_indicador" size="2" class="campo" value="<? if($_POST['comissao_indicador']){ echo($_POST['comissao_indicador']); }elseif($not2[comissao_indicador]){ echo($not2[comissao_indicador]); }else{ echo($comissao_indicador); } ?>">
          <? }else{ ?>
               <input type="text" name="comissao_indicador" id="comissao_indicador" size="2" class="campo" value="<? echo($comissao_indicador); ?>">
          <? } ?>      </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <? if (verificaFuncao("USER_IMOV_EDIT")) { // verifica se pode acessar as areas ?> 
      <td class=style1><b>Comiss&atilde;o Vendedor:</b></td>
      <td class=style1><input type="text" name="comissao_vendedor" id="comissao_vendedor" size="2" class="campo" value="<? if($_POST['comissao_vendedor']){ echo($_POST['comissao_vendedor']); }elseif($not2[comissao_vendedor]){ echo($not2[comissao_vendedor]); }else{ echo($comissao_vendedor); } ?>">
      <? }else{ ?>
        <td class=style1><input type="text" name="comissao_vendedor" id="comissao_vendedor" size="2" class="campo" value="<? echo($comissao_vendedor); ?>">
      <? } ?> 
        Exemplo:
        6 ou 15</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Disponibilizar no site:</b></td>
      <td class="style1"><input name="disponibilizar" type="radio" id="disponibilizar1" value="1" checked <? if($disponibilizar=='1'){ print "CHECKED"; } ?>>
        Sim
        <input name="disponibilizar" id="disponibilizar2" type="radio" value="0"  <? if($disponibilizar=='0'){ print "CHECKED"; } ?>>
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
      <td class="style1"><input type="hidden" name="bcom" value="0">
	  <select name="comissao_parceria" id="comissao_parceria" class="campo" onChange="form1.action='p_edit_imoveis.php?cod=<?php echo($cod); ?>&edit=editar';form1.bcom.value='1';form1.submit();">
          <option value="0" selected>Selecione</option>
          <option value="30" <? if($comissao_parceria=='30'){ echo "SELECTED"; } ?>>30%</option>
		  <option value="40" <? if($comissao_parceria=='40'){ echo "SELECTED"; } ?>>40%</option>
		  <option value="50" <? if($comissao_parceria=='50'){ echo "SELECTED"; } ?>>50%</option>
		  <option value="diferenciado" <? if($comissao_parceria=='diferenciado'){ echo "SELECTED"; } ?>>Diferenciado</option>
        </select>
	<? if($comissao_parceria=='diferenciado'){ ?>
        <input type="text" name="comissao_diferenciado" id="comissao_diferenciado" size="2" class="campo" value="<?=$comissao_diferenciado; ?>"></td>
	<? } ?>
    </tr>
    <?
			
			$result2 = mysql_query("SELECT d_qtd FROM rebri_destaques WHERE d_tipo='Destaques'");
			$row2 = mysql_fetch_array($result2);
			$quantidade = $row2['d_qtd'];
			
			$result3 = mysql_query("SELECT COUNT(cod) as contagemi FROM muraski WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (finalidade='2' OR finalidade='9' OR finalidade='15')");
			while($row3 = mysql_fetch_array($result3)){
	         	$totali = $row3['contagemi'];
	        }
	        
	        $result4 = mysql_query("SELECT COUNT(destaque) as contagemd FROM muraski WHERE destaque='1' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (finalidade='2' OR finalidade='9' OR finalidade='15')");
			while($row4 = mysql_fetch_array($result4)){
	         	$totald = $row4['contagemd'];
	        }
	        	        
            $conta = $totali / $quantidade;
            $resultado = ceil($conta);

    //if($totald >= $quantidade && $not2['destaque']=='0'){
      if($totald > $resultado){
?>
	<tr bgcolor="#EDEEEE">
      <td class=style1><b>Destaque no site:</b></td>
      <td class="style1"><input name="destaque" id="destaque1" type="radio" value="0"  <? if($destaque=='0'){ print "CHECKED"; } ?> checked>
        N&atilde;o</td>
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
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Observa&ccedil;&otilde;es:</b></td>
      <td class=style1><textarea rows="5" class="campo" name="observacoes" id="observacoes" cols="36"><?php $not2[observacoes] = stripslashes($not2[observacoes]); print("$not2[observacoes]"); ?></textarea></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Rela&ccedil;&atilde;o de bens:</b></td>
      <td class=style1><textarea rows="5" class="campo" name="relacao_bens" id="relacao_bens" cols="36"><?php $not2[relacao_bens] = stripslashes($not2[relacao_bens]); print("$not2[relacao_bens]"); ?></textarea></td>
    </tr>
    <!--tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Especificação:</b></td>
      <td width="77%" class=style1><select class="campo" name="especificacao">
    <option selected><?php //print("$not2[especificacao]"); ?></option>
    <option>Lançamento</option>
    <option>Novo</option>
    <option>Semi-Novo</option>
    <option>Usado</option>
        </select></td>
    </tr-->
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Coordenadas:</b><br>
      * Entre no site <a href="http://maps.google.com.br" target="_blank">Google Maps</a> e digite o endere&ccedil;o completo, cidade, estado (Ex: rua teste, 10, curitiba, pr) e depois clicar em &quot;Link&quot; e copiar e colar o codigo HTML nesse campo.Veja <a href="images/exemplo.jpg" target="_blank">aqui</a> o exemplo. </td>
      <td class=style1><textarea rows="3" name="coordenadas" id="coordenadas" cols="40" class="campo"><?=$coordenadas; ?></textarea></td>
    </tr>
    <!--tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Posição X:</b></td>
      <td width="77%" class=style1><input type="text" name="posx" value="<?php //print("$not2[posx]"); ?>" class="campo" size=10></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Posição Y:</b></td>
      <td width="77%" class=style1><input type="text" name="posy" value="<?php //print("$not2[posy]"); ?>" class="campo" size=10></td>
    </tr-->
    <!--tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Piscina:</b></td>
      <td width="77%" class=style1><select class="campo" name="piscina">
    <option selected><?php// print("$not2[piscina]"); ?></option>
    <option>Não</option>
    <option>Sim</option>
        </select></td>
    </tr-->
    <!--tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Localização:</b></td>
      <td width="77%" class="style1"><input type="text" name="local" class="campo" size="30" value="<?php //print("$not2[local]"); ?>"></td>
    </tr--> 
    <!--tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Cidade Mat.:</b></td>
      <td width="77%" class="style1"><select size="1" name="cidade_mat" class="campo">
      <option selected><?php //print("$not2[cidade_mat]"); ?></option>
    <option>Guaratuba</option>
    <option>São José dos Pinhais</option>
        </select></td>
    </tr-->
    <!--tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Tipo Divulgação:</b></td>
      <td width="77%" class=style1><input type="text" name="tipo_div" size="40" class="campo" value="<?php //print("$not2[tipo_div]"); ?>"></td>
    </tr-->
    <!--tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 1:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_1" size="30" value="<?php
      //$not2[ftxt_1] = stripslashes($not2[ftxt_1]); print("$not2[ftxt_1]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 2:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_2" size="30" value="<?php
      //$not2[ftxt_2] = stripslashes($not2[ftxt_2]); print("$not2[ftxt_2]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 3:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_3" size="30" value="<?php
      //$not2[ftxt_3] = stripslashes($not2[ftxt_3]); print("$not2[ftxt_3]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 4:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_4" size="30" value="<?php
      //$not2[ftxt_4] = stripslashes($not2[ftxt_4]); print("$not2[ftxt_4]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 5:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_5" size="30" value="<?php
      //$not2[ftxt_5] = stripslashes($not2[ftxt_5]); print("$not2[ftxt_5]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 6:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_6" size="30" value="<?php
      //$not2[ftxt_6] = stripslashes($not2[ftxt_6]); print("$not2[ftxt_6]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 7:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_7" size="30" value="<?php
      //$not2[ftxt_7] = stripslashes($not2[ftxt_7]); print("$not2[ftxt_7]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 8:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_8" size="30" value="<?php
      //$not2[ftxt_8] = stripslashes($not2[ftxt_8]); print("$not2[ftxt_8]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 9:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_9" size="30" value="<?php
      //$not2[ftxt_9] = stripslashes($not2[ftxt_9]); print("$not2[ftxt_9]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 10:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_10" size="30" value="<?php
      //$not2[ftxt_10] = stripslashes($not2[ftxt_10]); print("$not2[ftxt_10]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 11:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_11" size="30" value="<?php
      //$not2[ftxt_11] = stripslashes($not2[ftxt_11]); print("$not2[ftxt_11]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 12:</b></td>
      <td width="77%" class=style12><input type="text" class="campo" name="ftxt_12" size="30" value="<?php
      //$not2[ftxt_12] = stripslashes($not2[ftxt_12]); print("$not2[ftxt_12]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 13:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_13" size="30" value="<?php
      //$not2[ftxt_13] = stripslashes($not2[ftxt_13]); print("$not2[ftxt_13]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 14:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_14" size="30" value="<?php
      //$not2[ftxt_14] = stripslashes($not2[ftxt_14]); print("$not2[ftxt_14]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 15:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_15" size="30" value="<?php
      //$not2[ftxt_15] = stripslashes($not2[ftxt_15]); print("$not2[ftxt_15]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 16:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_16" size="30" value="<?php
      //$not2[ftxt_16] = stripslashes($not2[ftxt_16]); print("$not2[ftxt_16]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 17:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_17" size="30" value="<?php
      //$not2[ftxt_17] = stripslashes($not2[ftxt_17]); print("$not2[ftxt_17]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 18:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_18" size="30" value="<?php
      //$not2[ftxt_18] = stripslashes($not2[ftxt_18]); print("$not2[ftxt_18]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 19:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_19" size="30" value="<?php
      //$not2[ftxt_19] = stripslashes($not2[ftxt_19]); print("$not2[ftxt_19]");
      ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="23%" class=style1><b>Texto da foto 20:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_20" size="30" value="<?php 
      //$not2[ftxt_20] = stripslashes($not2[ftxt_20]); print("$not2[ftxt_20]");
      ?>"></td>
    </tr-->
    <tr bgcolor="#EDEEEE">
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td colspan="4" class="TdTitulo">&Uacute;ltimas três atualiza&ccedil;&otilde;es </td>
        </tr>
        <tr>
          <td width="15%" class="TdSubTitulo">Data</td>
          <td width="17%" class="TdSubTitulo">Hora</td>
		  <td width="32%" class="TdSubTitulo">Ação</td>
          <td width="36%" class="TdSubTitulo">Usu&aacute;rio</td>
        </tr>
		<?
		$busca_usuarios = mysql_query("SELECT t1.a_cod_user, t1.a_imovel, t1.a_acao, t1.a_data, t1.a_hora, t3.u_nome FROM atualizacoes t1, usuarios t3 WHERE t1.a_cod_user = t3.u_cod and t1.a_imovel = '".$cod."' and t1.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id DESC LIMIT 0,3");
		while($linha = mysql_fetch_array($busca_usuarios)){
		
		$d = explode("-",$linha['a_data']);
		$data = $d[2]."/".$d[1]."/".$d[0];
		
		echo "
			<tr bgcolor=\"#FFFFFF\">
          		<td width=\"15%\" class=\"style1\">".$data."</td>
		        <td width=\"17%\" class=\"style1\">".$linha['a_hora']."</td>
				<td width=\"32%\" class=\"style1\">".$linha['a_acao']."</td>
         		<td width=\"36%\" class=\"style1\">".$linha['u_nome']."</td>
        	</tr>
		";
		}
		?>
		
      </table></td>
    </tr>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td colspan="2">
      <input type="hidden" value="1" name="editar">
      <input type="hidden" name="cod" value="<?php print("$not2[cod]"); ?>">
      <input type="hidden" name="u_cod" value="<?=$u_cod ?>">
      <input type="submit" value="Atualizar Imóvel" class=campo3 name="B1">
      <input type="button" value="Apagar Imóvel" class=campo3 name="B1" onClick="javascript:confirmaExclusao2(<? echo($not2[cod]); ?>,'<?=$not2[ref] ?>')">
      <input type="button" value="Apagar Definitivamente" name="B1" class=campo3 onClick="javascript:confirmaExclusao(<? echo($not2[cod]); ?>,'<?=$not2[ref] ?>')"></td>
    </tr>
    <tr><td colspan="2">
                  <p align="center">
                  <a href="javascript:history.back()" class="style1"><< Voltar <<</a></p></td></tr>
</table>
</form>
  <br>
<?php
	}
/*	
mysql_free_result($result0);
mysql_free_result($result2);
*/
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