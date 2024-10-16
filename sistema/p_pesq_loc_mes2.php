<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
include("funcoes/funcoes.php");
verificaAcesso();
verificaArea("GERAL_LOCA");
?>
<html>
<head>
<?php
include("style.php");
?>
<script language="javascript">
function LimpaCampo(){

  if(document.getElementById('comp4').value=='frente para o mar' || document.getElementById('comp4').value=='frente para a baía')
  {
	document.form1.dist_mar.disabled = true;
    document.form1.dist_mar.style.background = '#D6D6D6';
  }
  else 
  {	
    document.form1.dist_mar.disabled = false;
    document.form1.dist_mar.style.background = '#FFFFFF'; 
  }
}


function LimpaCampo(){

  if(document.getElementById('comp4').value=='frente para o mar' || document.getElementById('comp4').value=='frente para a baía')
  {
	document.form1.dist_mar.disabled = true;
    document.form1.dist_mar.style.background = '#D6D6D6';
  }
  else 
  {	
    document.form1.dist_mar.disabled = false;
    document.form1.dist_mar.style.background = '#FFFFFF'; 
  }
}

function valida()
{

  if(document.form1.calendario.checked==0){
   
  if (document.form1.dial.value == "")
  {
    alert("Por favor, digite o Dia de Entrada");
    document.form1.dial.focus();
    return (false);
  }
  if (document.form1.mesl.value == "")
  {
    alert("Por favor, digite o Mês de Entrada");
    document.form1.mesl.focus();
    return (false);
  }
  if (document.form1.anol.value == "")
  {
    alert("Por favor, digite o Ano de Entrada");
    document.form1.anol.focus();
    return (false);
  }
  if (document.form1.dial1.value == "")
  {
    alert("Por favor, digite o Dia de Saída");
    document.form1.dial1.focus();
    return (false);
  }
  if (document.form1.mesl1.value == "")
  {
    alert("Por favor, digite o Mês de Saída");
    document.form1.mesl1.focus();
    return (false);
  }
  if (document.form1.anol1.value == "")
  {
    alert("Por favor, digite o Ano de Saída");
    document.form1.anol1.focus();
    return (false);
  }
  
  var data1 = document.form1.anol.value + document.form1.mesl.value + document.form1.dial.value;
  var data2 = document.form1.anol1.value + document.form1.mesl1.value + document.form1.dial1.value;	
  if (data2 < data1) {
	alert("Data inicial deve ser menor que data final.");
	document.form1.dial.focus();
	return(false);
  }
} 
	return(true);
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
<?php
	if(!(session_is_registered("anol")))
	{
	$anol = date(Y);
	if(date(m) > 8){
	$anol1 = $anol + 1;
	}
	else
	{
	$anol1 = $anol;
	}
	}
?>
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
	     <? if($_GET['local']){ ?>
		 opcoes  = 1;
		 idOpcao  = document.getElementById("opcoes");
		 <? }else{ ?>
		 document.forms[0].local.options.length = 1;
		 idOpcao  = document.getElementById("opcoes");
		 <? } ?>
	     ajax.open("POST", "cidades_pesquisa.php", true);
		 ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 ajax.onreadystatechange = function() {
            if(ajax.readyState == 4 ) {
			   if(ajax.responseXML) {
			      processXML(ajax.responseXML);
			   }
			   else {
				   idOpcao.innerHTML = "Selecione o Estado";
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
		 }
	  }
	  else {
		idOpcao.innerHTML = "Selecione o Estado";
	  }	  
   } 
</script>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
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
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/		
?>
<p>
<div align="center">
  <center>
  <form method="get" action="p_lista_loc_mes.php" name="form1" onSubmit="return valida();">
  <table width="700" border="0" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td width="100%" colspan=2 class=style1><p align="center"><b>Imóveis p/ Locação Anual</b><br>
 Preencha os campos do seu interesse e clique em pesquisar.</p></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Per&iacute;odo:</b></td>
      <td class=style1><input type="text" name="dial" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($_GET['dial']){ print($_GET['dial']); }else{ print("$dial"); } ?>">/<input type="text" name="mesl" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($_GET['mesl']){ print($_GET['mesl']); }else{ print("$mesl"); } ?>">/<input type="text" name="anol" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php if($_GET['anol']){ print($_GET['anol']); }else{ print("$anol"); } ?>">
          <b>&agrave;</b>
          <input type="text" name="dial1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($_GET['dial1']){ print($_GET['dial1']); }else{ print("$dial1"); } ?>">/<input type="text" name="mesl1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($_GET['mesl1']){ print($_GET['mesl1']); }else{ print("$mesl1"); } ?>">/<input type="text" name="anol1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php if($_GET['anol1']){ print($_GET['anol1']); }else{ print("$anol1"); } ?>">
        <br>
        Ex.: 
        10/10/1910 &agrave; 20/10/1910</td>
    </tr>
<?php
	session_unregister("dial");
	session_unregister("mesl");
	session_unregister("anol");
	session_unregister("dial1");
	session_unregister("mesl1");
	session_unregister("anol1");
?>	
    <tr bgcolor="#EDEEEE">
      <td class="style1"><b>Busca Per&iacute;odo:</b></td>
      <td class="style1"><input name="calendario" type="checkbox" id="calendario" value="1" <? if($calendario=='1'){ print "CHECKED"; } ?>>
        Neutralizar calend&aacute;rio </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="30%" class=style1><b>Finalidade:</b></td>
      <td width="70%" class=style1> <select name="finalidade" class="campo">
      	 <?php
        
		$bfinalidade = mysql_query("select f_cod, f_nome FROM finalidade WHERE f_nome LIKE 'Locação_%' ORDER BY f_cod ASC");
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
 	?> 
      	
      	
<?php
//include("finalidade.php");
?>
    <!--option value="Vend%" <?// if($finalidade=='Vend%'){ echo "SELECTED"; }?>>Venda_Todos</option>
    <option value="Locação%" <?// if($finalidade=='Locação%'){ echo "SELECTED"; }?>>Locação_Todos</option-->
      </select></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="30%" class=style1><b>Tipo de imóvel:</b></td>
      <td width="70%" class=style1> <select name="tipo1" class="campo">
    <option selected value="%" <? if($tipo1=='%'){ echo "SELECTED"; }?>>Todos</option>
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
      <td width="30%" class=style1><b>Referência:</b></td>
      <td width="70%" class=style1> <input type="text" name="ref" size="10" class="campo" value="<?=$ref; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="30%" class=style1><b>N° de
        quartos:</b></td>
      <td width="70%" class=style1><select name="comp1" class="campo">
    <option selected value="like" <? if($comp1=='like'){ echo "SELECTED"; }?>>Igual a</option>
    <option value=">" <? if($comp1=='>'){ echo "SELECTED"; }?>>Maior que</option>
    <option value="<" <? if($comp1=='<'){ echo "SELECTED"; }?>>Menor que</option>
      </select> <input type="text" name="n_quartos" size="5" class="campo" value="<?=$n_quartos; ?>"> Exemplo:
        1</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="30%" class=style1><b>Valor:</b></td>
      <td width="70%" class=style1><select name="comp2" class="campo">
    <option selected value="like" <? if($comp2=='like'){ echo "SELECTED"; }?>>Igual a</option>
    <option value=">" <? if($comp2=='>'){ echo "SELECTED"; }?>>Maior que</option>
    <option value="<" <? if($comp2=='<'){ echo "SELECTED"; }?>>Menor que</option>
      </select> <input type="text" name="valor" size="10" class="campo" value="<?=$valor; ?>"> Exemplo:
        50000.00 ou 50000</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="30%" class=style1><b>Endereço:</b></td>
      <td width="70%" class="style1"><select name="tipo_logradouro" id="tipo_logradouro" class="campo">
        <option value="">Selecione</option>
        <option value="Alameda" <? if($not2['tipo_logradouro']=='Alameda'){ echo "SELECTED"; } ?>>Alameda</option>
        <option value="Área" <? if($tipo_logradouro=='Área'){ echo "SELECTED"; } ?>>Área</option>
        <option value="Avenida" <? if($tipo_logradouro=='Avenida'){ echo "SELECTED"; } ?>>Avenida</option>
        <option value="Campo" <? if($tipo_logradouro=='Campo'){ echo "SELECTED"; } ?>>Campo</option>
        <option value="Chácara" <? if($tipo_logradouro=='Chácara'){ echo "SELECTED"; } ?>>Chácara</option>
        <option value="Colônia" <? if($tipo_logradouro=='Colônia'){ echo "SELECTED"; } ?>>Colônia</option>
        <option value="Condomínio" <? if($tipo_logradouro=='Condomínio'){ echo "SELECTED"; } ?>>Condomínio</option>
        <option value="Conjunto" <? if($tipo_logradouro=='Conjunto'){ echo "SELECTED"; } ?>>Conjunto</option>
        <option value="Distrito" <? if($tipo_logradouro=='Distrito'){ echo "SELECTED"; } ?>>Distrito</option>
        <option value="Esplanada" <? if($tipo_logradouro=='Esplanada'){ echo "SELECTED"; } ?>>Esplanada</option>
        <option value="Estação" <? if($tipo_logradouro=='Estação'){ echo "SELECTED"; } ?>>Estação</option>
        <option value="Estrada" <? if($tipo_logradouro=='Estrada'){ echo "SELECTED"; } ?>>Estrada</option>
        <option value="Favela" <? if($tipo_logradouro=='Favela'){ echo "SELECTED"; } ?>>Favela</option>
        <option value="Fazenda" <? if($tipo_logradouro=='Fazenda'){ echo "SELECTED"; } ?>>Fazenda</option>
        <option value="Feira" <? if($tipo_logradouro=='Feira'){ echo "SELECTED"; } ?>>Feira</option>
        <option value="Jardim" <? if($tipo_logradouro=='Jardim'){ echo "SELECTED"; } ?>>Jardim</option>
        <option value="Ladeira" <? if($tipo_logradouro=='Ladeira'){ echo "SELECTED"; } ?>>Ladeira</option>
        <option value="Lago" <? if($tipo_logradouro=='Lago'){ echo "SELECTED"; } ?>>Lago</option>
        <option value="Lagoa" <? if($tipo_logradouro=='Lagoa'){ echo "SELECTED"; } ?>>Lagoa</option>
        <option value="Largo" <? if($tipo_logradouro=='Largo'){ echo "SELECTED"; } ?>>Largo</option>
        <option value="Loteamento" <? if($tipo_logradouro=='Loteamento'){ echo "SELECTED"; } ?>>Loteamento</option>
        <option value="Morro" <? if($tipo_logradouro=='Morro'){ echo "SELECTED"; } ?>>Morro</option>
        <option value="Núcleo" <? if($tipo_logradouro=='Núcleo'){ echo "SELECTED"; } ?>>Núcleo</option>
        <option value="Parque" <? if($tipo_logradouro=='Parque'){ echo "SELECTED"; } ?>>Parque</option>
        <option value="Passarela" <? if($tipo_logradouro=='Passarela'){ echo "SELECTED"; } ?>>Passarela</option>
        <option value="Pátio" <? if($tipo_logradouro=='Pátio'){ echo "SELECTED"; } ?>>Pátio</option>
        <option value="Praça" <? if($tipo_logradouro=='Praça'){ echo "SELECTED"; } ?>>Praça</option>
        <option value="Quadra" <? if($tipo_logradouro=='Quadra'){ echo "SELECTED"; } ?>>Quadra</option>
        <option value="Recanto" <? if($tipo_logradouro=='Recanto'){ echo "SELECTED"; } ?>>Recanto</option>
        <option value="Residencial" <? if($tipo_logradouro=='Residencial'){ echo "SELECTED"; } ?>>Residencial</option>
        <option value="Rodovia" <? if($tipo_logradouro=='Rodovia'){ echo "SELECTED"; } ?>>Rodovia</option>
        <option value="Rua" <? if($tipo_logradouro=='Rua'){ echo "SELECTED"; } ?>>Rua</option>
        <option value="Setor" <? if($tipo_logradouro=='Setor'){ echo "SELECTED"; } ?>>Setor</option>
        <option value="Sítio" <? if($tipo_logradouro=='Sítio'){ echo "SELECTED"; } ?>>Sítio</option>
        <option value="Travessa" <? if($tipo_logradouro=='Travessa'){ echo "SELECTED"; } ?>>Travessa</option>
        <option value="Trecho" <? if($tipo_logradouro=='Trecho'){ echo "SELECTED"; } ?>>Trecho</option>
        <option value="Trevo" <? if($tipo_logradouro=='Trevo'){ echo "SELECTED"; } ?>>Trevo</option>
        <option value="Vale" <? if($tipo_logradouro=='Vale'){ echo "SELECTED"; } ?>>Vale</option>
        <option value="Vereda" <? if($tipo_logradouro=='Vereda'){ echo "SELECTED"; } ?>>Vereda</option>
        <option value="Via" <? if($tipo_logradouro=='Via'){ echo "SELECTED"; } ?>>Via</option>
        <option value="Viaduto" <? if($tipo_logradouro=='Viaduto'){ echo "SELECTED"; } ?>>Viaduto</option>
        <option value="Viela" <? if($tipo_logradouro=='Viela'){ echo "SELECTED"; } ?>>Viela</option>
        <option value="Vila" <? if($tipo_logradouro=='Vila'){ echo "SELECTED"; } ?>>Vila</option>
      </select>
      <input type="text" name="end" size="40" class="campo" value="<?=$end; ?>"> 
      N&deg;: 
      <input type="text" name="numero_end" id="numero_end" size="5" class="campo" value="<?=$numero_end; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>CEP:</b></td>
      <td class=style1><input name="cep" type="text" class="campo" id="cep" value="<?=$cep; ?>" size="8" maxlength="8">
Exemplo: 80000000 </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Acomoda&ccedil;&otilde;es:</b></td>
      <td class=style1><select name="comp3" class="campo">
          <option selected value="like" <? if($comp3=='like'){ echo "SELECTED"; }?>>Igual a</option>
          <option value=">" <? if($comp3=='>'){ echo "SELECTED"; }?>>Maior que</option>
          <option value="<" <? if($comp3=='<'){ echo "SELECTED"; }?>>Menor que</option>
        </select>
          <input type="text" name="acomod" size="2" class="campo" value="<?=$acomod; ?>">
         Exemplo:
        1 ou 10</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%" class=style1><b>Distância do mar:</b></td>
      <td width="80%" class=style1><select name="comp4" id="comp4" class="campo" OnClick="LimpaCampo();">
    <option value="">Selecione</option>  
    <option value="=" <? if($comp4=='='){ echo "SELECTED"; }?>>Igual a</option>
    <option value=">" <? if($comp4=='>'){ echo "SELECTED"; }?>>Maior que</option>
    <option value="<" <? if($comp4=='<'){ echo "SELECTED"; }?>>Menor que</option>
    <option value="frente para o mar" <? if($comp4=='frente para o mar'){ echo "SELECTED"; }?>>frente para o mar</option>
    <option value="frente para a baía" <? if($comp4=='frente para a baía'){ echo "SELECTED"; }?>>frente para a baía</option>
      </select> <input type="text" name="dist_mar" size="4" class="campo" value="<?=$dist_mar; ?>"> quadras ou metros</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="30%" class=style1><b>Relação de bens:</b></td>
      <td width="70%" class="style1"><input type="text" name="relacao_bens" size="40" class="campo" value="<?=$relacao_bens; ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class="style1"><b>Estado:</b></td>
      <td class="style1"><select name="im_estado" onChange="Dados(this.value);" class="campo">
        <option value="0">Selecione o Estado</option>
          <?
        if($_SESSION['cod_estadoi'] && empty($_GET['im_estado'])){ 
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
				if($linha[e_cod]==$_GET['im_estado']){
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
if($_SESSION['cod_cidadei'] && empty($_GET['local'])){ 
	  		$status2 = "SELECTED";
	  		$selecionar2 = '<option value="0">Selecione</option>';	
}else{
	$query20 = "SELECT ci_nome FROM rebri_cidades WHERE ci_cod='".$_GET['local']."'";
	$result20 = mysql_query($query20);
	while($not20 = mysql_fetch_array($result20)){
		if($_GET['local']){  
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
      <td class="style1"><b>Localiza&ccedil;&atilde;o:</b></td>
      <td class="style1"><input type="hidden" name="acaob" id="acaob" value="0">
	  <select name="local" class="campo" onChange="form1.action='p_pesq_loc_mes.php';form1.acaob.value='1';form1.submit();">
        <? if($_SESSION['cod_cidadei'] && empty($_GET['local'])){ ?>
			
			<?=$selecionar2 ?>
			<option id="opcoes" value="<? echo $_SESSION['cod_cidadei']; ?>" <?=$status2 ?>><? echo $_SESSION['cidadei'] ?></option>
			<option value="all" <? if($local=='all'){  echo "SELECTED"; } ?>>Todos</option>
			<?  
				$bcidades2 = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$_SESSION['cod_estadoi']."' ORDER BY ci_nome ASC");
 				while($linha = mysql_fetch_array($bcidades2)){
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
			}else{
			?>
			<?=$selecionar2 ?>
			<option id="opcoes" value="<? echo $local; ?>" <?=$status2 ?>><? echo $nlocal ?></option>
			<option value="all" <? if($local=='all'){  echo "SELECTED"; } ?>>Todos</option>
			<?
			if($_GET['local']){
				$bcidades2 = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$_GET['im_estado']."' ORDER BY ci_nome ASC");
 				while($linha = mysql_fetch_array($bcidades2)){
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
			}
			}
		?>
      </select></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Bairros:</b></td>
      <td class="style1"><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <?
          
         if($_GET['bairro']){
		  $bairro = implode('-', $_GET['bairro']);
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
        
        if($_GET['acaob']=='1'){
			$busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$_GET['local']."' ORDER BY b_nome");
			$col = 1;
			while($linha = mysql_fetch_array($busca_bairros)){
		?>
          <td class="style1"><?
	  		if ($col > 3) {
				print "</td></tr><tr><td class=\"style1\">";
				$col = 1;
			}elseif ($col != 1) {
				print "</td><td  class=\"style1\">";
			}
?>
              <input type="checkbox" name="bairro[]" id="bairro" value="<?php echo("-".$linha['b_cod']."-"); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>> <?= $linha['b_nome']; ?>
              <?
			$col++;
			}
		}else{
		  	$busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$_SESSION['cod_cidadei']."' ORDER BY b_nome");
			$col = 1;
			while($linha = mysql_fetch_array($busca_bairros)){
		?>
          <td class="style1"><?
	  		if ($col > 3) {
				print "</td></tr><tr><td class=\"style1\">";
				$col = 1;
			}elseif ($col != 1) {
				print "</td><td  class=\"style1\">";
			}
?>
              <input type="checkbox" name="bairro[]" id="bairro" value="<?php echo("-".$linha['b_cod']."-"); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>> <?= $linha['b_nome']; ?>
              <?
			$col++;
			}
		}
		?>
			</td>
		</tr>
		<tr>
			<td class="style1"><input name="b_bairr" type="checkbox" id="b_bairr1" value="1" <? if($b_bairr=='1'){ print "CHECKED"; } ?>> Todos</td>
        </tr>
      </table></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class=style1><b>Caracter&iacute;sticas:</b></td>
      <td class="style1"><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <?
          
        if($_GET['caracteristica']){
		  $caracteristica = implode('-', $_GET['caracteristica']);
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
		$col2 = 1;
		while($linha = mysql_fetch_array($busca_caracteristicas)){
		?>
          <td class="style1"><?
	  	if ($col2 > 3) {
			print "</td></tr><tr><td class=\"style1\">";
			$col2 = 1;
		} elseif ($col2 != 1) {
			print "</td><td  class=\"style1\">";
		}
?>
              <input type="checkbox" name="caracteristica[]" id="caracteristica" value="<?php echo("-".$linha['c_cod']."-"); ?>" <?php verifica_check2("".$linha['c_cod']."", $caracteristica) ?>><?= $linha['c_nome']; ?>
              <?
		$col2++;
		}
		?>
			</td>
		</tr>
		<tr>
			<td class="style1"><input name="b_caract" type="checkbox" id="b_caract1" value="1" <? if($b_caract=='1'){ print "CHECKED"; } ?>> Todas</td>
        </tr>
      </table></td>
    </tr>
    <!--tr bgcolor="#EDEEEE">
      <td class="style1"><b>Busca Característica:</b></td>
      <td class="style1"><input name="b_caract" type="checkbox" id="b_caract1" value="1" <? if($b_caract=='1'){ print "CHECKED"; } ?>>
        Todas as características selecionadas
        <!--input name="b_caract" id="b_caract2" type="radio" value="2"  <? if($b_caract=='2'){ print "CHECKED"; } ?>>
        Todas--></td>
    </tr-->
    <tr bgcolor="#EDEEEE">
      <td width="100%" colspan=2>
      <input type="hidden" value="1" name="list">
      <input type="hidden" value="" name="lista">
      <input type="submit" value="Pesquisar" name="B1" class=campo3></td>
    </tr>
  </table>
  </form>
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