<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

include("regra.php");
?>
<html>
<head>
<?php
   include("style.php");
?>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script>
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
</head>
<body topmargin=0 leftmargin=0 rightmargin=0>
<table width=100% height=100%>
<tr><td bgcolor="<?php print("$barra_lat"); ?>" valign=top width=150>
<?php
include("menu_painel.php");
?></td>
<td width=620 valign=top>
<br>
<?php
include("conect.php");
?>
<?
//require_once("conecta.php");
$sql = "SELECT e_cod, e_uf FROM rebri_estados ORDER BY e_uf";
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
		 document.forms[0].im_cidade.options.length = 1;
		 idOpcao  = document.getElementById("opcoes");
	     ajax.open("POST", "cidades_bkup.php", true);
		 ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 ajax.onreadystatechange = function() {
			if(ajax.readyState == 1) {
			   idOpcao.innerHTML = "Aguarde...!";
	        }
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
	        idOpcao.innerHTML = "Selecione uma opção";
			var novo = document.createElement("option");
			    novo.setAttribute("ci_cod", "opcoes");
			    novo.value = codigo;
			    novo.text  = descricao;
				document.forms[0].im_cidade.options.add(novo);
		 }
	  }
	  else {
		idOpcao.innerHTML = "Selecione o Estado";
	  }	  
   }

function VerificaCampo()
{

var msg = '';

	   if(document.formulario.im_nome.value.length==0)
	   {
		       msg += "Por favor, selecione o campo Nome.\n";
       }
	   if(document.formulario.im_n_conselho.value=="")
	   {
		       msg += "Por favor, preencha o campo N° do Creci.\n";
	   }
	   if(document.formulario.im_cnpj.value=="")
	   {
		       msg += "Por favor, preencha o campo CPF ou CPNJ.\n";
	   }
	   if(document.formulario.im_banco.value=="")
	   {
		       msg += "Por favor, preencha o campo Banco.\n";
	   }
	   if(document.formulario.im_agencia.value=="")
	   {
		       msg += "Por favor, preencha o campo Agência.\n";
	   }
	   if(document.formulario.im_conta.value=="")
	   {
		       msg += "Por favor, preencha o campo Conta.\n";
	   }
	   /*
	   else if(!isCNPJ(RemoveMascaraCNPJ(document.formulario.im_cnpj.value)))
       {
	           msg += "CNPJ digitado é inválido!\n";
	   }
	   */
	   if(document.formulario.im_contato.value=="")
	   {
		       msg += "Por favor, preencha o campo Contato.\n";
	   }
	   if(document.formulario.im_resp.value=="")
	   {
		       msg += "Por favor, preencha o campo Nome do Responsável.\n";
	   }
	   if(document.formulario.im_creci_resp.value=="")
	   {
		       msg += "Por favor, preencha o campo N° do Creci Responsável.\n";
	   }
	   if(document.formulario.im_nacionalidade.value=="")
	   {
		       msg += "Por favor, preencha o campo Nacionalidade.\n";
	   }
	   if (document.formulario.im_est_civil.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Estado Civil.\n";
	   }
       if(document.formulario.im_email.value.length==0)
	   {
		       msg += "Por favor, preencha o campo E-mail.\n";
       }
	   else if(!isMail(document.formulario.im_email.value))
	   {
	           msg += "O E-mail digitado é inválido!\n";
	   }
       if(document.formulario.im_senha.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Senha.\n";
       }
       if(document.formulario.im_tel.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Telefone.\n";
       }
       if (document.formulario.im_estado.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Estado.\n";
	   }
	   if (document.formulario.im_cidade.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Cidade.\n";
	   }
	   if(document.formulario.im_end.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Endereço.\n";
       }
	   if (document.formulario.contrato_venda.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Contrato para Venda.\n";
	   }
	   if (document.formulario.contrato_locacao.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Contrato para Locação.\n";
	   }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
			document.formulario.B1.value='Cadastrar';
			document.formulario.submit();
	   }

}

function TravaCampo(){

  if(document.getElementById('end_igual').checked)
  {
    document.formulario.im_end_mapa.disabled = true;
    document.formulario.im_end_mapa.style.background = '#D6D6D6';
  }
  else 
  {
    document.formulario.im_end_mapa.disabled = false;
    document.formulario.im_end_mapa.style.background = '#FFFFFF';
  }
}

function TravaCampo2(){

  if(document.getElementById('end_igual2').checked)
  {
    document.formulario.im_end_mapa2.disabled = true;
    document.formulario.im_end_mapa2.style.background = '#D6D6D6';
  }
  else 
  {
    document.formulario.im_end_mapa2.disabled = false;
    document.formulario.im_end_mapa2.style.background = '#FFFFFF';
  }
}


function TudoIgual(field) {
  var str = field.value, primeiro='';
  for(i = 0; i < str.length; i++)
    if (str.charAt(i)>='0' && str.charAt(i)<='9')
      if (primeiro=='') primeiro = str.charAt(i);
      else if (str.charAt(i) != primeiro) return 0;
  return 1;
}
function Trim(s)
{
 if (s.length == 0)
  return s;

 if (s.length == 1 && s.value == ' ')
  return '';

 var i=0;

 while ( i < s.length && s.substring(i,i+1) == ' ') i++;

 var f = s.length - 1;

 while ( f >= 0 && s.substr(f,f+1) == ' ') f--;

 s = s.substr(i,f+1);

 return s;
}

function Guardar_CPF_CGC(field) {

  document.form1.c_cpf.value = Trim(field.value);

}

function Verifica_CPF_CGC(field) {

  var cpf='', cgc='', digito='', digitoc='', temp='', k=0; i=0, j=0, soma=0, mt=0, dg='';

  field.value = Trim(field.value);
  
  // Compara o CNPJ_CPF antigo com o CNPJ_CPF novo
  
//  if(Trim(document.frmPedido.FormFederalTaxID.value) != field.value) {
//  		
//		document.frmPedido.FormNICHandle.value = "true";		
//		document.frmPedido.FormNICPassword.value = "";
//		document.frmPedido.PasswordRequired.value = "0";	
//		
//		document.frmPedido.NICHandleRequested.value = "0";	
//		document.frmPedido.FormNICHandle.disabled = false;		
//		document.frmPedido.FormNICPassword.disabled = false;		
//		document.frmPedido.FormRegistrant.checked = true;
//
// }
  
  
//  if (field.value.substring(0,2) == '00') {
//        field.value = field.value.substring(1, field.value.length)
//  }

  // Limpa os espacos da variavel
  if (field.value == ' ' || field.value == '  ' || field.value == ''){
	return false;
  } 
  else {
       cpf = field.value;
  }
  if (cpf.length == 19) {
     cpf = cpf.substring(1, cpf.length)
  }
  
  for (i = 0;i < cpf.length; i++) {
	k = i + 1;
	if (isNaN(cpf.substring(i,k))== false){
          temp = temp + cpf.substring(i,k);  	
	}
  }

 if (((cpf.length > 13) && (cpf.length < 19)) && (isNaN(cpf.substring(3,4))==false)){ 
  cgc = temp.substring(0,12);
  digito = temp.substring(12,14);
  mult = '543298765432';
  for (j = 1; j <= 2; j++) {
    soma = 0;
    for (i = 0; i <= 11; i++) {
      k = i + 1;
      soma += parseInt((cgc.substring(i,k)) * (mult.substring(i,k)));
    }
    if (j == 2){
	soma = soma + (2 * digitoc);
    }
    digitoc = ((soma * 10) % 11);
    if (digitoc == 10){
	digitoc = 0;
    }
    dg +=digitoc;
    mult = '654329876543';
  }
  if (dg != digito || TudoIgual(field)) {
    alert('O CPF/CNPJ informado não é válido!');
    field.value = '';
    field.focus();
    return false;
  } 
  else {
    field.value=temp.substring(0,2)+'.'+temp.substring(2,5)+'.'+temp.substring(5,8)+'/'+temp.substring(8,12)+'-'+temp.substring(12,14);
    return true;
  }
 }
 else {
  if (cpf.length < 11) {
	alert( 'Informação inválida.');
	field.value = '';
	field.focus();
	return false;
  }
  if (cpf.length >= 11) {
      
      cpf = temp.substring(0,9);
	digito = temp.substring(9,11);
	for (j = 1; j <= 2; j++) {
	  soma = 0;
	  mt = 2;
	  for (i = 8 + j; i >= 1; i--) {
	    soma += parseInt(cpf.charAt(i-1),10) * mt;
	    mt++;
	  }
	  dg = 11 - (soma % 11);
	  if (dg > 9) {dg = 0};
	  cpf += dg;
	}

	if (digito != cpf.substring(9,11) || TudoIgual(field)) {
	  alert('O CPF/CNPJ informado não é válido!');
	  field.value = '';
	  field.focus();
	  return false;
	  } 
	else {
	  field.value=cpf.substring(0,3)+'.'+cpf.substring(3,6)+'.'+cpf.substring(6,9)+'-'+cpf.substring(9,11);
	  return true;
	}
    }
  } // fim if (cpf.length < 15)

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
<table>
	<tr>
		<td>
 <p align="center"><b>Inserir Imobiliárias</b><br>
 <a href="p_imobiliarias.php" class=linkm>
 Clique para visualizar a relação de Imobiliárias</a></p>
 <div align="center">
  <center>
<?
    if($_POST['end_igual']){
	   $end_igual = $_POST['end_igual'];
	}else{
	   $end_igual = 1;
	}
	
	if($_POST['end_igual2']){
	   $end_igual2 = $_POST['end_igual2'];
	}else{
	   $end_igual2 = 1;
	}
?>
  <form method="post" name="formulario" action="p_imobiliarias.php">
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td width="40%" class=style2>Nome:</td>
      <td width="60%" class=style2> <input type="text" name="im_nome" size="40" class="campo"></td>
    </tr>
	<tr>
      <td width="40%" class=style2>N° do Creci:</td>
      <td width="60%" class=style2> <input type="text" name="im_n_conselho" size="10" class="campo"></td>
    </tr>
	 <tr>
      <td width="40%" class=style2>CPF ou CNPJ:</td>
      <td width="60%" class=style2> <input type="text" name="im_cnpj" size="20" maxlength="20" class="campo" onBlur="javascript:Verifica_CPF_CGC(this);"  onKeyUp="return autoTab(this, 20, event);"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Banco:</td>
      <td width="60%" class=style2> <input type="text" name="im_banco" size="40" class="campo"></td>
    </tr>
     <tr>
      <td width="40%" class=style2>Agência:</td>
      <td width="60%" class=style2> <input type="text" name="im_agencia" size="15" class="campo"></td>
    </tr>
     <tr>
      <td width="40%" class=style2>Conta:</td>
      <td width="60%" class=style2> <input type="text" name="im_conta" size="15" class="campo"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Contato:</td>
      <td width="60%" class=style2> <input type="text" name="im_contato" size="40" class="campo"></td>
    </tr>
	 <tr>
       <td width="40%" class=style2>Nome do Respons&aacute;vel: </td>
       <td width="60%" class=style2><input type="text" name="im_resp" id="im_resp" size="40" class="campo"></td>
     </tr>
     <tr>
       <td width="40%" class=style2>N&deg; do Creci do Respons&aacute;vel: </td>
       <td width="60%" class=style2><input type="text" name="im_creci_resp" size="10" class="campo"></td>
     </tr>
	 <tr>
      <td width="40%" class=style2>Nacionalidade:</td>
      <td width="60%" class=style2> <input type="text" name="im_nacionalidade" size="40" class="campo"></td>
    </tr>
	 <tr>
      <td width="40%" class=style2>Estado Civil:</td>
      <td width="60%" class=style2><select name="im_est_civil" class="campo">
	        <option value="0">Selecione</option>
			<option value="Casado(a)">Casado(a)</option>
			<option value="Divorciado(a)">Divorciado(a)</option>
			<option value="Separado(a)">Separado(a)</option>
			<option value="Solteiro(a)">Solteiro(a)</option>
			<option value="Viúvo(a)">Viúvo(a)</option>
	     </select></td>
    </tr>
    <tr>
      <td width="40%" class=style2>E-mail:</td>
      <td width="60%" class=style2> <input type="text" name="im_email" size="40" class="campo"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Senha:</td>
      <td width="60%" class=style7> <input type="password" name="im_senha" size="6" class="campo" maxlength="6" onKeyUp="return autoTab(this, 6, event);"> Obs.: 6 dígitos</td>
    </tr>
    <tr>
      <td width="40%" class=style2>Telefone:</td>
      <td width="60%" class=style2> <input type="text" name="im_tel" size="20" class="campo"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Celular:</td>
      <td width="60%" class=style2> <input type="text" name="im_cel" size="20" class="campo"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Fax:</td>
      <td width="60%" class=style2> <input type="text" name="im_fax" size="20" class="campo"></td>
    </tr>
  	<tr>
  	<td width="40%" class="style2">
        <p align="left">Estado:</td>
        <td width="60%"><select name="im_estado" onChange="Dados(this.value);" class=campo>
	        <option value="0">Selecione o Estado</option>
		    <? for($i=0; $i<$row; $i++) { ?>
		       <option value="<? echo mysql_result($sql, $i, "e_cod"); ?>">
			   <? echo mysql_result($sql, $i, "e_uf"); ?></option>
		    <? } ?>
	     </select></td>
      </tr> 
    <tr>
      <td width="40%" class="style2">Cidade:</td>
      <td width="60%" colspan=3><select name="im_cidade" class=campo>
            <option id="opcoes" value="0">Selecione o Estado</option>
	     </select></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Endereço:</td>
      <td width="60%" class=style2> <input type="text" name="im_end" size="40" class="campo"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Endere&ccedil;os Id&ecirc;nticos?</td>
      <td width="60%" class="style2"><input name="end_igual" type="checkbox" id="end_igual" value="1" <? if($end_igual=='1'){ print "CHECKED"; } ?> OnClick="TravaCampo();">
        Sim</td>
    </tr>
    <tr>
      <td width="40%" class=style2>Endereço Mapa:</td>
      <td width="60%" class=style2> <input type="text" name="im_end_mapa" size="40" class="campo" <? if($end_igual=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Bairro:</td>
      <td width="60%" class=style2> <input type="text" name="im_bairro" size="40" class="campo"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>CEP:</td>
      <td width="60%" class=style2> <input type="text" name="im_cep" size="8" class="campo" maxlength="8" onKeyUp="return autoTab(this, 8, event);"></td>
    </tr>
	<tr>
      <td width="40%" class=style2>Endereço 2:</td>
      <td width="60%" class=style2> <input type="text" name="im_end2" size="40" class="campo"></td>
    </tr>
     <tr>
      <td width="40%" class=style2>Endere&ccedil;os Id&ecirc;nticos 2?</td>
      <td width="60%" class="style2"><input name="end_igual2" type="checkbox" id="end_igual2" value="1" <? if($end_igual2=='1'){ print "CHECKED"; } ?> OnClick="TravaCampo2();">
        Sim</td>
    </tr>
    <tr>
      <td width="40%" class=style2>Endereço Mapa 2:</td>
      <td width="60%" class=style2> <input type="text" name="im_end_mapa2" size="40" class="campo" <? if($end_igual2=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Bairro do Endereço 2:</td>
      <td width="60%" class=style2> <input type="text" name="im_bairro2" size="40" class="campo"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>CEP do Endereço 2:</td>
      <td width="60%" class=style2> <input type="text" name="im_cep2" size="8" class="campo" maxlength="8" onKeyUp="return autoTab(this, 8, event);"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Telefone do Endereço 2:</td>
      <td width="60%" class=style2> <input type="text" name="im_tel2" size="20" class="campo"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>E-mail do Endereço 2:</td>
      <td width="60%" class=style2> <input type="text" name="im_email2" size="40" class="campo"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Site:</td>
      <td width="60%" class=style2> <input type="text" name="im_site" size="40" class="campo"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Site 2:</td>
      <td width="60%" class=style2> <input type="text" name="im_site2" size="40" class="campo"></td>
    </tr>
	<tr>
      <td width="40%" class=style2>Disponibilizar no site:</td>
      <td width="60%" class=style2><input name="im_disponibilizar" id="im_disponibilizar2" type="radio" value="1" checked  <? if($im_disponibilizar=='1'){ print "CHECKED"; } ?>>
        Sim
        <input name="im_disponibilizar" type="radio" id="im_disponibilizar1" value="0" <? if($im_disponibilizar=='0'){ print "CHECKED"; } ?>>
        N&atilde;o</td>
    </tr>

	<tr>
      <td width="40%" class=style2>Site padrão:</td>
      <td width="60%" class=style2>
			<input name="im_site_padrao" id="im_site_padrao" type="radio" value="S" checked  <? if (($not2[im_site_padrao]=='S') || ($_POST[im_site_padrao]=='S')) { print "CHECKED"; } else { $mostra = 'n'; } ?>> Sim
         <input name="im_site_padrao" type="radio" id="im_site_padrao" value="N" <? if ($mostra == "n") { print "CHECKED"; } ?>> N&atilde;o</td>
   </tr>

	<tr>
      <td width="40%" class=style2>Desativar Imobiliária:</td>
      <td width="60%" class=style2><input name="im_desativar" type="radio" id="im_desativar2" value="1" <? if($im_desativar=='1'){ print "CHECKED"; } ?>>
        Sim
        <input name="im_desativar" id="im_desativar1" type="radio" value="0" checked  <? if($im_desativar=='0'){ print "CHECKED"; } ?>>
        N&atilde;o</td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">*Imagem Grande no Sistema:</td>
      <td width="60%" class=style2> <input type="text" name="im_img" size="20" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo" onClick="window.open('p_img_logo.php?status=g', 'janela', 'height=500,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"><br>
      Obs.: Clique em "Selecionar" e escolha a imagem desejada.</td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">*Imagem Grande no Site:</td>
      <td width="60%" class=style2> <input type="text" name="im_img_med" size="20" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo" onClick="window.open('p_img_logo.php?status=l', 'janela', 'height=500,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"><br>
      Obs.: Clique em "Selecionar" e escolha a imagem desejada.<br><span class="style7"><b>ATENÇÃO:</b> A logo deve estar com o mesmo nome da logo "grande" "NO MOMENTO DE ENVIAR" a(s) logo(s) para que não ocorra problema na exibição da logo na lista de imobiliárias no site.</span></td>
    </tr>
	<tr>
      <td width="40%" class=style2 valign="top">*Imagem Pequena no Site/Sistema:</td>
      <td width="60%" class=style2> <input type="text" name="im_img_peq" size="20" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo" onClick="window.open('p_img_logo.php?status=p', 'janela', 'height=500,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"><br>
      Obs.: Clique em "Selecionar" e escolha a imagem desejada.<br><span class="style7"><b>ATENÇÃO:</b> A logo deve estar com o mesmo nome da logo "grande" "NO MOMENTO DE ENVIAR" a(s) logo(s) para que não ocorra problema na exibição da logo pequena.</span></td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Descrição:</td>
      <td width="60%" class=style2> <textarea name="im_desc" cols="30" rows="5" class="campo"></textarea></td>
    </tr>
	 <tr>
      <td width="40%" class=style2 valign="top">Contrato para Venda: </td>
      <td width="60%" class=style2><select name="contrato_venda" id="contrato_venda" class="campo">
        <option value="">Selecione um contrato</option>
        <?php
        	$documentosv = mysql_query("select dp_cod, dp_nome FROM docs_padrao WHERE (dp_cod='5' OR dp_cod='7') ORDER BY dp_nome ASC");
 			while($linhav = mysql_fetch_array($documentosv)){
 		  	$d_nomev = substr ($linhav[dp_nome], 0, 50);
				if($linhav[dp_cod]==$_POST['contrato_venda']){
					echo('<option value="'.$linhav[dp_cod].'" title="'.$linhav[dp_nome].'" SELECTED>'.$d_nomev.'...</option>');
				}else{
					echo('<option value="'.$linhav[dp_cod].'" title="'.$linhav[dp_nome].'">'.$d_nomev.'...</option>');
				}
 			}
 	?>
      </select></td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Contrato para Loca&ccedil;&atilde;o: </td>
      <td width="60%" class=style2><select name="contrato_locacao" id="contrato_locacao" class="campo">
        <option value="">Selecione um contrato</option>
        <?php
        	$documentosl = mysql_query("select dp_cod, dp_nome FROM docs_padrao WHERE dp_cod='9' ORDER BY dp_nome ASC");
 			while($linhal = mysql_fetch_array($documentosl)){
 		  	$d_nomel = substr ($linhal[dp_nome], 0, 50);
				if($linhal[dp_cod]==$_POST['contrato_locacao']){
					echo('<option value="'.$linhal[dp_cod].'" title="'.$linhal[dp_nome].'" SELECTED>'.$d_nomel.'...</option>');
				}else{
					echo('<option value="'.$linhal[dp_cod].'" title="'.$linhal[dp_nome].'">'.$d_nomel.'...</option>');
				}
 			}
 	?>
      </select></td>
    </tr>

    <tr>
      <td colspan="2" class=style2 valign="top" height=10></td>
    </tr>
    <tr>
      <td colspan="2" class=style2 valign="top"><strong>Dados do Site Padrão:</strong> </td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Titulo Lateral: </td>
      <td width="60%" class=style2><input type="text" size="6" maxlength="6" name="im_site_titulo_lateral" value="" class="campo" /> Ex: "FFFFFF"</td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Título Interno: </td>
      <td width="60%" class=style2><input type="text" size="6" maxlength="6" name="im_site_titulo_interno" value="" class="campo" /> Ex: "FFFFFF"</td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Referência Interna: </td>
      <td width="60%" class=style2><input type="text" size="6" maxlength="6" name="im_site_referencia_interna" value="" class="campo" /> Ex: "FFFFFF"</td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Resumo: </td>
      <td width="60%" class=style2><input type="text" size="6" maxlength="6" name="im_site_resumo" value="" class="campo" /> Ex: "FFFFFF"</td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Rodapé: </td>
      <td width="60%" class=style2><input type="text" size="6" maxlength="6" name="im_site_rodape" value="" class="campo" /> Ex: "FFFFFF"</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">
      <input type="hidden" name="B1" id="B1" value="0">
      <input class=campo type="button" value="Cadastrar" name="Botao" Onclick="VerificaCampo();"></td>
    </tr>
      </form>
     </table></td>
      <td width="30%" valign="top"><table border="0" cellspacing="1" width="100%" bgcolor="#<?php print("$cor3"); ?>">
  		<tr bgcolor="#<?php print("$cor3"); ?>">
  			<td align="center"><b>Últimos Cadastros</b></td>
  		</tr>
  		<tr bgcolor="#<?php print("$cor1"); ?>"><td class=style2>
<?php
	$query4 = "select i.im_cod, i.im_nome, e.e_uf from rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) order by im_cod desc limit 5";
	$result4 = mysql_query($query4);
	//echo $query4;
	while($not4 = mysql_fetch_array($result4))
	{
	$im_estado = $not4[e_uf];
	$im_nome = $not4[im_nome];
	$im_cod = $not4[im_cod];
?>
           <br><a href="p_imobiliarias.php?im_cod=<?php print("$im_cod"); ?>&edit=editar&lista=1" class="style2" align="center"><b><?php print("$im_nome"); ?> - <?php print("$im_estado"); ?></b></a>
<?php
	}
?>
  			<br><br><a href="p_imobiliarias.php" class=linkm><b>Clique aqui</b></a> para visualizar a relação de imobiliárias.</td>
  </tr>
  	</table>
  </td>
</tr>
  	</table>
<?php
include("carimbo.php");
mysql_close($con);
?>
  </td></tr></table>
</body>
</html>