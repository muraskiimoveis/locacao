<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_IMOBILIARIA");
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

<html>
<?php
include("style.php");
?>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="JavaScript">
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
       /*
       if(document.formulario.im_email.value.length==0)
	   {
		       msg += "Por favor, preencha o campo E-mail.\n";
       }
       if(document.formulario.im_senha.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Senha.\n";
       }
       */
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
       if(document.formulario.com_angariador.value.length==0)
	   {
		     msg += "Por favor, preencha o campo Comissão Angariador.\n";
       }
       if(document.formulario.com_vendedor.value.length==0)
	   {
		     msg += "Por favor, preencha o campo Comissão Vendedor.\n";
       }
       if(document.formulario.com_indicador.value.length==0)
	   {
		     msg += "Por favor, preencha o campo Comissão Indicador.\n";
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
	        document.formulario.atualiza.value='1';
			document.formulario.submit();
	   }

}


</script>
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/

	//echo $atualiza;
//Atualizar Imobili&aacute;ria
if($atualiza == "1")
{
	
/*
	$pw_query = "SELECT u_cod FROM usuarios WHERE u_email ='".$im_email."' AND u_senha='".md5($im_senha)."' AND cod_imobiliaria='".$im_cod."'";
	$pw_result = mysql_query($pw_query) or die("N&atilde;o foi possivel inserir suas informa&ccedil;&otilde;es");
	$pw_rows = mysql_num_rows($pw_result);
	if ($pw_rows == 0) {  
*/	  

	$im_senha = base64_encode($im_senha);
	//echo $im_senha;
	
	$nome_imobiliaria = $im_nome;
	$im_estado = $_POST['im_estado'];
	$im_cidade = $_POST['im_cidade'];
	
	// tira os acentos e espa&ccedil;o
	/*
	$im_nome = ereg_replace("[&Aacute;&Agrave;&Acirc;&Atilde;]","A",$im_nome);
	$im_nome = ereg_replace("[&aacute;&agrave;&acirc;&atilde;&ordf;]","a",$im_nome);
	$im_nome = ereg_replace("[&Eacute;&Egrave;&Ecirc;]","E",$im_nome);
	$im_nome = ereg_replace("[&eacute;&egrave;&ecirc;]","e",$im_nome);
	$im_nome = ereg_replace("[&Oacute;&Ograve;&Ocirc;&Otilde;]","O",$im_nome);
	$im_nome = ereg_replace("[&oacute;&ograve;&ocirc;&otilde;&ordm;]","o",$im_nome);
	$im_nome = ereg_replace("[&Uacute;&Ugrave;&Ucirc;]","U",$im_nome);
	$im_nome = ereg_replace("[&uacute;&ugrave;&ucirc;]","u",$im_nome);
	$im_nome = ereg_replace("[&iacute;&igrave;&icirc;]","i",$im_nome);
	$im_nome = ereg_replace("[&Iacute;&Igrave;&Icirc;]","I",$im_nome);
	$im_nome = str_replace("&Ccedil;","C",$im_nome);
	$im_nome = str_replace("&ccedil;","c",$im_nome);
	$im_nome = str_replace(" ","",$im_nome);
	*/
	
	if($nome_imobiliaria <> $_POST['im_nome']){
	// pega o nome da imobili&aacute;ria, deixa em min&uacute;sculas e pega os 6 primeiros caracteres se caso for menor que 6 complementa com 0
	if(strlen($im_nome) < 6){
	    if(strlen($im_nome) == 5){
     		$nome_pasta = strtolower($im_nome."0");  
     	}elseif(strlen($im_nome) == 4){
		   $nome_pasta = strtolower($im_nome."00");  
		}elseif(strlen($im_nome) == 3){
		  $nome_pasta = strtolower($im_nome."000");  
		}elseif(strlen($im_nome) == 2){
		  $nome_pasta = strtolower($im_nome."0000");  
		}elseif(strlen($im_nome) == 1){  
		  $nome_pasta = strtolower($im_nome."00000");  
		}
	}elseif(strlen($im_nome) >= 6){
		$nome_pasta = strtolower(substr($im_nome,0,6));
	}

	// verifica se a pasta j&aacute; existe 
	if (file_exists("../imobiliarias/" . $nome_pasta)) {
   		$cont = 1; // contador de pastas
   
   	// verifica qual a ultima pasta criada e incrementa 1 
   	while (file_exists("../imobiliarias/" . $nome_pasta . $cont)) {
       	$cont++;
   	}
   
   	$nome_pasta .= $cont;
	}
	
	//busca o nome da pasta
	$busca = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$im_cod."'");
    while($linha = mysql_fetch_array($busca)){
         $pasta = $linha['nome_pasta'];
    }
	
	// cria nova pasta 
	$dirp = "../imobiliarias/".$nome_pasta;
	rename("../imobiliarias/".$pasta, $dirp);
	}
	
	$query = "update rebri_imobiliarias set im_nome='$nome_imobiliaria', im_contato='$im_contato', im_resp='$im_resp', im_creci_resp='$im_creci_resp', im_nacionalidade='$im_nacionalidade', im_est_civil='$im_est_civil', im_n_conselho='$im_n_conselho', im_cnpj='$im_cnpj', im_banco='$im_banco', im_agencia='$im_agencia', im_conta='$im_conta'
	, im_fax='$im_fax', im_cel='$im_cel', 
	 im_cidade='$im_cidade', im_estado='$im_estado', im_end='$im_end', im_bairro='$im_bairro'
	, im_cep='$im_cep', im_site='$im_site', im_desc='$im_desc', nome_pasta='$nome_pasta', comissao_angariador='$com_angariador', comissao_vendedor='$com_vendedor', comissao_indicador='$com_indicador', contrato_venda='$contrato_venda', contrato_locacao='$contrato_locacao' where im_cod='$im_cod'";
	$result = mysql_query($query) or die("N&atilde;o foi poss&iacute;vel atualizar suas informa&ccedil;&otilde;es. $query");
	
?>
<p align="center"> Voc&ecirc; atualizou a imobili&aacute;ria <i><?php print("$im_nome"); ?></i>.</p>
<?php
/*
	}else{
	  echo ('<script language="javascript">alert("E-mail e/ou senha j&aacute; cadastrados!");document.location.href="p_imobiliarias.php";</script>');   
	}
*/	
}

	$query2 = "select *, (select ci_nome from rebri_cidades where ci_cod=im_cidade) as cidade_nome from rebri_imobiliarias where im_cod = '".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
	$ano1 = substr ($not2[im_nasc], 0, 4);
	$mes1 = substr($not2[im_nasc], 5, 2 );
	$dia1 = substr ($not2[im_nasc], 8, 2 );
	
	$not2[im_senha] = base64_decode($not2[im_senha]);
	$img = $not2['im_img'];

?>
<script language="JavaScript">
/*
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
	     ajax.open("POST", "cidades.php", true);
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
*/
var req;

function loadXMLDoc(url,valor)
{
    req = null;
    // Procura por um objeto nativo (Mozilla/Safari)
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = processReqChange;
        req.open("GET", url+'?estado='+valor, true);
        req.send(null);
    // Procura por uma versao ActiveX (IE)
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.onreadystatechange = processReqChange;
            req.open("GET", url+'?estado='+valor, true);
            req.send();
        }
    }
}

function processReqChange()
{
    // apenas quando o estado for "completado"
    if (req.readyState == 4) {
        // apenas se o servidor retornar "OK"
        if (req.status == 200) {
            // procura pela div id="atualiza" e insere o conteudo
            // retornado nela, como texto HTML
            document.getElementById('cidades').innerHTML = req.responseText;
        } else {
            alert("Houve um problema ao obter os dados:\n" + req.statusText);
        }
    }
}

function Atualiza(valor)
{
    loadXMLDoc("cidadesi.php",valor);
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
  <form method="post" name="formulario" action="p_imobiliarias.php">
  <input type="hidden" name="editar" value="1">
  <input type="hidden" name="atualiza" id="atualiza" value="0">
  <input type="hidden" value="<?php print($not2[im_cod]); ?>" name="im_cod">
  <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
  	<tr height="50">
      <td colspan="2" class="style1"><p align="center"><b>Dados Imobiliária</b></p></td>
    </tr>
	<tr class="fundoTabela">
      <td width="30%" class=style1>Nome:</td>
      <td width="70%" class=style1><input type="text" name="im_nome" id="im_nome" size="40" class="campo" value="<?php if($_POST['im_nome']){ print($_POST['im_nome']); }else{ print($not2[im_nome]); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1>N° do Creci:</td>
      <td width="70%" class=style1> <input type="text" name="im_n_conselho" size="10" class="campo" value="<?php if($_POST['im_n_conselho']){ print($_POST['im_n_conselho']); }else{ print($not2[im_n_conselho]); } ?>"></td>
    </tr>
	 <tr class="fundoTabela">
      <td width="30%" class=style1>CPF ou CNPJ:</td>
      <td width="70%" class=style1> <input type="text" name="im_cnpj" size="20" maxlength="20" class="campo" value="<?php if($_POST['im_cnpj']){ print($_POST['im_cnpj']); }else{ print($not2[im_cnpj]); } ?>" onBlur="javascript:Verifica_CPF_CGC(this);"  onKeyUp="return autoTab(this, 20, event);"></td>
    </tr>
     <tr class="fundoTabela">
      <td width="30%" class=style1>Banco:</td>
      <td width="70%" class=style1> <input type="text" name="im_banco" size="40" class="campo" value="<?php if($_POST['im_banco']){ print($_POST['im_banco']); }else{ print($not2[im_banco]); } ?>"></td></tr>
     <tr class="fundoTabela">
      <td width="30%" class=style1>Agência:</td>
      <td width="70%" class=style1> <input type="text" name="im_agencia" size="15" class="campo" value="<?php if($_POST['im_agencia']){ print($_POST['im_agencia']); }else{ print($not2[im_agencia]); } ?>"></td></tr>
     <tr class="fundoTabela">
      <td width="30%" class=style1>Conta:</td>
      <td width="70%" class=style1> <input type="text" name="im_conta" size="15" class="campo" value="<?php if($_POST['im_conta']){ print($_POST['im_conta']); }else{ print($not2[im_conta]); } ?>"></td></tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1>Contato:</td>
      <td width="70%" class=style1><input type="text" name="im_contato" id="im_contato" size="40" class="campo" value="<?php if($_POST['im_contato']){ print($_POST['im_contato']); }else{ print($not2[im_contato]); } ?>"></td></tr>
     <tr class="fundoTabela">
       <td class=style1>Nome do Respons&aacute;vel:</td>
       <td class=style1><input type="text" name="im_resp" id="im_resp" size="40" class="campo" value="<?php if($_POST['im_resp']){ print($_POST['im_resp']); }else{ print($not2[im_resp]); } ?>"></td></tr>
     <tr class="fundoTabela">
       <td class=style1>N&deg; do Creci do Respons&aacute;vel:</td>
       <td class=style1><input type="text" name="im_creci_resp" size="10" class="campo" value="<?php if($_POST['im_creci_resp']){ print($_POST['im_creci_resp']); }else{ print($not2[im_creci_resp]); } ?>"></td></tr>
     <tr class="fundoTabela">
      <td width="30%" class=style1>Nacionalidade:</td>
      <td width="70%" class=style1> <input type="text" name="im_nacionalidade" size="40" class="campo" value="<?php if($_POST['im_nacionalidade']){ print($_POST['im_nacionalidade']); }else{ print($not2[im_nacionalidade]); } ?>"></td></tr>
	 <tr class="fundoTabela">
      <td width="30%" class=style1>Estado Civil:</td>
      <td width="70%" class=style1><select name="im_est_civil" class="campo">
	        <option value="0">Selecione</option>
			<option value="Casado(a)" <? if($_POST['im_est_civil']=='Casado(a)'){ print "SELECTED"; }elseif($not2[im_est_civil]=='Casado(a)'){ print "SELECTED"; } ?>>Casado(a)</option>
			<option value="Divorciado(a)" <? if($_POST['im_est_civil']=='Divorciado(a)'){ print "SELECTED"; }elseif($not2[im_est_civil]=='Divorciado(a)'){ print "SELECTED"; } ?>>Divorciado(a)</option>
			<option value="Separado(a)" <? if($_POST['im_est_civil']=='Separado(a)'){ print "SELECTED"; }elseif($not2[im_est_civil]=='Separado(a)'){ print "SELECTED"; } ?>>Separado(a)</option>
			<option value="Solteiro(a)" <? if($_POST['im_est_civil']=='Solteiro(a)'){ print "SELECTED"; }elseif($not2[im_est_civil]=='Solteiro(a)'){ print "SELECTED"; } ?>>Solteiro(a)</option>
			<option value="Viúvo(a)" <? if($_POST['im_est_civil']=='Viúvo(a)'){ print "SELECTED"; }elseif($not2[im_est_civil]=='Viúvo(a)'){ print "SELECTED"; } ?>>Viúvo(a)</option>
	     </select></td>
    </tr>
    <!--tr class="fundoTabela">
      <td width="30%" class=style1>E-mail:</td>
      <td width="70%" class=style1><input type="text" name="im_email" id="im_email" size="40" class="campo" value="<?php //print("$not2[im_email]"); ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1>Senha:</td>
      <td width="70%" class=style7><input type="text" name="im_senha" id="im_senha" size="6" class="campo" maxlength="6" onKeyUp="return autoTab(this, 6, event);" value="<?php// print("$not2[im_senha]"); ?>">
        Obs.: 6 d&iacute;gitos</td>
    </tr-->
    <tr class="fundoTabela">
      <td width="30%" class=style1>Telefone:</td>
      <td width="70%" class=style1><input type="text" name="im_tel" id="im_tel" size="20" class="campo" value="<?php if($_POST['im_tel']){ print($_POST['im_tel']); }else{ print($not2[im_tel]); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1>Celular:</td>
      <td width="70%" class=style1><input type="text" name="im_cel" id="im_cel" size="20" class="campo" value="<?php if($_POST['im_cel']){ print($_POST['im_cel']); }else{ print($not2[im_cel]); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1>Fax:</td>
      <td width="70%" class=style1><input type="text" name="im_fax" id="im_fax" size="20" class="campo" value="<?php if($_POST['im_fax']){ print($_POST['im_fax']); }else{ print($not2[im_fax]); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
  	<td width="30%">
        <p align="left" class="style1">Estado:</td>
        <td width="70%" class="style1"><!--select name="im_estado" id="im_estado" onChange="Dados(this.value);" class=campo>
	        <option value="0">Selecione o Estado</option>
<?
/*
//require_once("conecta.php");
$sql = "SELECT e_cod, e_uf, e_nome FROM rebri_estados ORDER BY e_nome";
$sql = mysql_query($sql);
$row = mysql_num_rows($sql);

	while($not4 = mysql_fetch_array($sql))
	{
*/	  
?>
		    <? //for($i=0; $i<$row; $i++) { ?>
<?php
/*
	if($not4[e_cod] == $not2[im_estado]){
		$estado_atual = $not4[e_nome];
*/		
?>
		       <option selected value="<? //echo $not4[e_cod]; ?>">
			   <? //echo $not4[e_nome]; ?></option>
<?php
/*
	}
	else
	{
*/	  
?>
		       <option value="<? //echo $not4[e_cod]; ?>">
			   <? //echo $not4[e_nome]; ?></option>
<?php
/*
	} 
  }
*/
?> 		    
	     </select-->
        <select name="im_estado" id="im_estado" class="campo" onChange="javascript:Atualiza(this.value);">
        <option value="0">Selecione</option>
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
				if($linha[e_cod]==$not2['im_estado']){
			   		echo('<option value="'.$linha[e_cod].'" SELECTED>'.$linha['e_uf'].'</option>'); 
				}else{ 			   
					echo('<option value="'.$linha[e_cod].'">'.$linha['e_uf'].'</option>');
				}
			} 
		}
		?>
   	</select>		 </td>
      </tr> 
    <tr class="fundoTabela">
      <td width="30%" class="style1">Cidade:</td>
      <td width="70%" class="style1"><div id="cidades"><? if($not2['im_cidade']){  ?>
        	<select name="im_cidade" id="im_cidade" class="campo"> 
   			<option value="0">Selecione</option> 
   		<?
   		if($_POST['im_cidade']){
	    	$bcidades = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades ORDER BY ci_nome ASC");
 	    	while($linha = mysql_fetch_array($bcidades)){
				if($linha[ci_cod]==$_POST['im_cidade']){
			   		echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>');
				}else{ 			   
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
			}
		}else{
		  	$bcidades = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades ORDER BY ci_nome ASC");
 	    	while($linha = mysql_fetch_array($bcidades)){
				if($linha[ci_cod]==$not2['im_cidade']){
			   		echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{ 			   
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
			}
		}
	  ?>
	  </select>
	 <? } ?></div><!--select name="im_cidade" id="im_cidade" class="campo">
			<option id="opcoes" value="<? //echo $not2[im_cidade]; ?>"><? //echo $not2[cidade_nome]; ?></option>
	     </select--></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1>Endere&ccedil;o:</td>
      <td width="70%" class=style1><input type="text" name="im_end" id="im_end" size="40" class="campo" value="<?php if($_POST['im_end']){ print($_POST['im_end']); }else{ print($not2[im_end]); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1>Bairro:</td>
      <td width="70%" class=style1><input type="text" name="im_bairro" id="im_bairro" size="40" class="campo" value="<?php if($_POST['im_bairro']){ print($_POST['im_bairro']); }else{ print($not2[im_bairro]); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1>CEP:</td>
      <td width="70%" class=style1><input type="text" name="im_cep" id="im_cep" size="8" class="campo" maxlength="8" onKeyUp="return autoTab(this, 8, event);" value="<?php if($_POST['im_cep']){ print($_POST['im_cep']); }else{ print($not2[im_cep]); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1>Site:</td>
      <td width="70%" class=style1><input type="text" name="im_site" id="im_site" size="40" class="campo" value="<?php if($_POST['im_site']){ print($_POST['im_site']); }else{ print($not2[im_site]); } ?>"></td>
    </tr>
    <!--tr class="fundoTabela">
      <td width="30%" class=style1 valign="top">*Imagem:</td>
      <td width="70%" class=style1><input type="text" name="im_img" id="im_img" size="20" class="campo" value="<?php print($not2[im_img]); ?>" readonly>
          <input name="button" type="button" class="campo" onClick="NewWindow('p_img_logo.php', 'janela', 750, 500, 'yes');" value="Selecionar">
        <br>
        Obs.: Clique em "Selecionar" e escolha a imagem desejada.</td>
    </tr-->
<?php
	 $caminho_logo_gr = "../logos/";

	if (file_exists($caminho_logo_gr.$not2[im_img]) and $not2[im_img]!='')
	{
?>
    <tr class="fundoTabela">
      <td width="30%" class=style1 valign="top">Imagem Grande no Sistema:</td>
      <td width="70%" class=style1><img src="<? echo($caminho_logo_gr.$not2[im_img]); ?>"></td>
    </tr>
<?php
	}
?>
<?php
	$fotos2 = explode(".",$not2[im_img]);
	$extensao2 = $fotos2[1];
	$nome_foto2 = $fotos2[0]."_med";
 
	$caminho_logo_med = "../logos_med/"; 
   
  	if (file_exists($caminho_logo_med.$nome_foto2.".jpg")){
	    $foto_med_logo = $nome_foto2.".jpg";
	}elseif (file_exists($caminho_logo_med.$nome_foto2.".png")){
  		$foto_med_logo = $nome_foto2.".png";
  	}elseif (file_exists($caminho_logo_med.$nome_foto2.".gif")){
  	  	$foto_med_logo = $nome_foto2.".gif";
  	}

	if (file_exists($caminho_logo_med.$foto_med_logo) and $foto_med_logo!='')
	{
?>
    <tr class="fundoTabela">
      <td width="30%" class=style1 valign="top">Imagem Grande no Site:</td>
      <td width="70%" class=style1><img src="<? echo($caminho_logo_med.$foto_med_logo); ?>"></td>
    </tr>
<?php
	}
?>
<?php

 	$fotos = explode(".",$not2[im_img]);
	$extensao = $fotos[1];
	$nome_foto = $fotos[0]."_peq";
 
	$caminho_logo_pq = "../logos_peq/";
   
  	if (file_exists($caminho_logo_pq.$nome_foto.".jpg")){
	    $foto_peq_logo = $nome_foto.".jpg";
	}elseif (file_exists($caminho_logo_pq.$nome_foto.".png")){
  		$foto_peq_logo = $nome_foto.".png";
  	}elseif (file_exists($caminho_logo_pq.$nome_foto.".gif")){
  	  $foto_peq_logo = $nome_foto.".gif";
  	}

	if (file_exists($caminho_logo_pq.$foto_peq_logo) and $foto_peq_logo!='')
	{
?>
    <tr class="fundoTabela">
      <td width="30%" class=style1 valign="top">Imagem Pequena:</td>
      <td width="70%" class=style1><img src="<? echo($caminho_logo_pq.$foto_peq_logo); ?>"></td>
    </tr>
<?php
	}
?>
    <tr class="fundoTabela">
      <td width="30%" class=style1 valign="top">Descri&ccedil;&atilde;o:</td>
      <td width="70%" class=style1><textarea name="im_desc" id="im_desc" cols="30" rows="5" class="campo"><?php if($_POST['im_desc']){ print($_POST['im_desc']); }else{ print($not2[im_desc]); } ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1 valign="top">Nome da pasta:</td>
      <td width="70%" class=style1><?php print($not2[nome_pasta]); ?></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1 valign="top">Comissão Angariador:</td>
      <td width="70%" class=style1><input type="text" name="com_angariador" id="com_angariador" size="2" class="campo" value="<?php if($_POST['comissao_angariador']){ print($_POST['comissao_angariador']); }else{ print($not2[comissao_angariador]); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1 valign="top">Comissão Vendedor:</td>
      <td width="70%" class=style1><input type="text" name="com_vendedor" id="com_vendedor" size="2" class="campo" value="<?php if($_POST['comissao_vendedor']){ print($_POST['comissao_vendedor']); }else{ print($not2[comissao_vendedor]); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1 valign="top">Comissão Indicador:</td>
      <td width="70%" class=style1><input type="text" name="com_indicador" id="com_indicador" size="2" class="campo" value="<?php if($_POST['comissao_indicador']){ print($_POST['comissao_indicador']); }else{ print($not2[comissao_indicador]); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1 valign="top">Contrato para Venda:</td>
      <td class=style1><select name="contrato_venda" id="contrato_venda" class="campo" onChange="formulario.submit();">
        <option value="">Selecione um contrato</option>
        <?php
        if($_POST['contrato_venda']){
		  	$documentosv = mysql_query("select d_id, d_cod, d_nome FROM doc WHERE d_tipo_contrato='V' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY d_nome ASC");
 			while($linhav = mysql_fetch_array($documentosv)){
 		  	$d_nomev = substr ($linhav[d_nome], 0, 50);
				if($linhav[d_cod]==$_POST['contrato_venda']){
				  	$id_venda = $linhav['d_id'];
					echo('<option value="'.$linhav[d_cod].'" title="'.$linhav[d_nome].'" SELECTED>'.$d_nomev.'...</option>');
				}else{ 			   
					echo('<option value="'.$linhav[d_cod].'" title="'.$linhav[d_nome].'">'.$d_nomev.'...</option>');
				}
 			}	  
		}else{
        	$documentosv = mysql_query("select d_id, d_cod, d_nome FROM doc WHERE d_tipo_contrato='V' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY d_nome ASC");
 			while($linhav = mysql_fetch_array($documentosv)){
 		  	$d_nomev = substr ($linhav[d_nome], 0, 50);
				if($linhav[d_cod]==$not2['contrato_venda']){
				  	$id_venda = $linhav['d_id'];
					echo('<option value="'.$linhav[d_cod].'" title="'.$linhav[d_nome].'" SELECTED>'.$d_nomev.'...</option>');
				}else{ 			   
					echo('<option value="'.$linhav[d_cod].'" title="'.$linhav[d_nome].'">'.$d_nomev.'...</option>');
				}
 			}
 		}
 	?>
      </select>
<a href="javascript:;" onClick="NewWindow('detalhes_documentos.php?idv=<?php print($id_venda); ?>', 'janela', 750, 500, 'yes');" class="style1"> Ver detalhes do contrato selecionado</a>
</td>	  
    </tr>
    <tr class="fundoTabela">
      <td class=style1 valign="top">Contrato para Loca&ccedil;&atilde;o:</td>
      <td class=style1><select name="contrato_locacao" id="contrato_locacao" class="campo" onChange="formulario.submit();">
        <option value="">Selecione um contrato</option>
        <?php
        if($_POST['contrato_locacao']){
		  	$documentosl = mysql_query("select d_id, d_cod, d_nome FROM doc WHERE d_tipo_contrato='L' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY d_nome ASC");
 			while($linhal = mysql_fetch_array($documentosl)){
 		  	$d_nomel = substr ($linhal[d_nome], 0, 50);
				if($linhal[d_cod]==$_POST['contrato_locacao']){
	  	 		  	$id_locacao = $linhal['d_id'];
					echo('<option value="'.$linhal[d_cod].'" title="'.$linhal[d_nome].'" SELECTED>'.$d_nomel.'...</option>');
				}else{ 			   
					echo('<option value="'.$linhal[d_cod].'" title="'.$linhal[d_nome].'">'.$d_nomel.'...</option>');
				}
 			}
		}else{
        	$documentosl = mysql_query("select d_id, d_cod, d_nome FROM doc WHERE d_tipo_contrato='L' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY d_nome ASC");
 			while($linhal = mysql_fetch_array($documentosl)){
 		  	$d_nomel = substr ($linhal[d_nome], 0, 50);
				if($linhal[d_cod]==$not2['contrato_locacao']){
	  	 		  	$id_locacao = $linhal['d_id'];
					echo('<option value="'.$linhal[d_cod].'" title="'.$linhal[d_nome].'" SELECTED>'.$d_nomel.'...</option>');
				}else{ 			   
					echo('<option value="'.$linhal[d_cod].'" title="'.$linhal[d_nome].'">'.$d_nomel.'...</option>');
				}
 			}
 		}
 	?>
      </select>
<a href="javascript:;" onClick="NewWindow('detalhes_documentos.php?idl=<?php print($id_locacao); ?>', 'janela', 750, 500, 'yes');" class="style1"> Ver detalhes do contrato selecionado</a>
</td>	  
    </tr>
    <tr>
      <td colspan="5"><input class=campo3 type="button" value="Atualizar" name="B1" Onclick="VerificaCampo();">
       <? //if (verificaFuncao("GERAL_COMP")) { // verifica se pode acessar as areas ?>
	  <!--input class=campo3 type="submit" value="Computadores" name="inserir" onClick="formulario.action='cadastro_computadores.php?cod_imobiliaria=<?=$_SESSION['cod_imobiliaria']; ?>'"-->
	  <? //} ?></td>
    </tr>
  </table>
</table>
  </form>
<?php
	}
mysql_close($con);
?>
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