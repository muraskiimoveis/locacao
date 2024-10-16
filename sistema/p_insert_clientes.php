<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("CLIENT_GERAL");

if($_GET['novo']){
  $novo = $_GET['novo'];
}else{
  $novo = $_POST['novo'];
}

if($_GET['url']){
  $url = $_GET['url'];
}else{
  $url = $_POST['url'];
}

?>
<html>
<head>
<?php
include("style.php");
?>

</head>
<body>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funcoes/js.js"></script>
<? if($novo<>'S'){ ?>
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
<?
}
?>
 <p align="center" class="style1"><b>Inserir Cadastro</b><br><? if($novo<>'S'){ ?><a href="p_clientes.php" class="style1">
 Clique para visualizar a relação de cadastros</a><? } ?></p>
<?php

if($B1 == "Inserir Cadastro")
{
	$c_nome = AddSlashes($_POST['c_nome']);

	// Realiza checagem para evitar que sejam cadastrados clientes com o mesmo nome / rg / cpf
   //Verifica cpf.
   if ($c_cpf <> "" || $c_rg <> "") {
      if ($c_cpf <> "") {
         $pesq_cpf = " OR c_cpf = '$c_cpf' ";
      }
      if ($c_rg <> "") {
   	   $pesq_rg = " OR c_rg = '$c_rg' ";
      }
   	$sqlClientes = "select c_cod from clientes where (lower(c_nome) like '".strtolower($c_nome)."' $pesq_cpf $pesq_rg) AND (c_rg <> '' OR c_cpf <> '') AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";

   	$buscaCliente = mysql_query($sqlClientes);
   	$registros = mysql_num_rows($buscaCliente);
   } else {
      $registros = 0;
   }


	// Já existe um cliente com os mesmos dados informados, não deixa cadastrar o cliente e retorna mensagem
	if($registros > 0)
	{
		echo('<script language="javascript">alert("Há um cliente com o mesmo nome, rg ou cpf cadastrado!");</script>');
	}
	// Começa o cadastro do cliente
	else
	{
		$c_origem = AddSlashes($c_origem);
		$c_end = AddSlashes($c_end);
		$c_bairro = AddSlashes($c_bairro);
		$c_cidade = AddSlashes($c_cidade);

		if($c_estado1 == ""){
			$c_estado = $c_estado2;
		}
		else
		{
			$c_estado = $c_estado1;
		}

		if($c_estado_com1 == ""){
			$c_estado_com = $c_estado_com2;
		}
		else
		{
			$c_estado_com = $c_estado_com1;
		}

		$c_email = AddSlashes($c_email);
		$c_obs = AddSlashes($c_obs);
		$c_conta = AddSlashes($c_conta);
		$c_prof = AddSlashes($c_prof);
		$c_nasc = "$ano-$mes-$dia";
		$c_desde = "$ano1-$mes1-$dia1";

		if(($c_banco == "") and ($novo_banco != ""))
		{
			$query0 = "select b_nome from bancos where b_nome='$novo_banco' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result0 = mysql_query($query0);
			$numrows0 = mysql_num_rows($result0);
			if($numrows0 == 0)
			{
				$query1 = "insert into bancos (cod_imobiliaria, b_nome) values('".$_SESSION['cod_imobiliaria']."','$novo_banco')";
				$result1 = mysql_query($query1) or die("Não foi possível inserir suas informações.(banco contas)");
			}
			$c_banco = $novo_banco;
		}

      $c_prestador2 = "";
      if (count($tipos_prestador) > 0) {
		   foreach ($tipos_prestador as $prestador) {
            $c_prestador2 .= "-".$prestador."-";
		   }
      }
      $c_tipo2 = "";
      if (count($tipos_cliente) > 0) {
		   foreach ($tipos_cliente as $cliente) {
            $c_tipo2 .= "-".$cliente."-";
		   }
      }
		// Realiza a inserção no banco de dados
		$query = "insert into clientes (cod_imobiliaria, c_tipo_pessoa, c_nome, c_cpf, c_rg, c_civil, c_origem
         , c_end, c_bairro, c_cep, c_cidade, c_estado, c_origem_com, c_end_com, c_bairro_com, c_cep_com, c_cidade_com
         , c_estado_com, c_tel, c_cel, c_fax, c_email, c_nasc, c_desde, c_obs, c_conta, c_prof, c_repre, c_repre2
         , c_banco, c_conjuge, c_rg_conjuge, c_cpf_conjuge, c_tel2, c_cel2, c_tel_com, c_fax_com, c_email_com
         , c_prestador2, c_tipo2) values ('".$_SESSION['cod_imobiliaria']."', '$c_tipo_pessoa', '$c_nome', '$c_cpf'
         , '$c_rg', '$c_civil', '$c_origem', '$c_end', '$c_bairro', '$c_cep', '$c_cidade', '$c_estado', '$c_origem_com'
         , '$c_end_com', '$c_bairro_com', '$c_cep_com', '$c_cidade_com', '$c_estado_com', '$c_tel', '$c_cel', '$c_fax'
         , '$c_email', '$c_nasc', '$c_desde', '$c_obs', '$c_conta', '$c_prof', '$c_repre', '$c_repre2', '$c_banco'
         , '$c_conjuge', '$c_rg_conjuge', '$c_cpf_conjuge', '$c_tel2', '$c_cel2', '$c_tel_com',  '$c_fax_com'
         , '$c_email_com', '$c_prestador2','$c_tipo2')";
		$result = mysql_query($query) or die("Não foi possível inserir suas informações.");
		$url = str_replace("&","-","$url");
		$numero_cliente = mysql_insert_id();

/**
		// Realiza a inserção dos tipos na tabela de relacionamento
		if(isset($tipos_cliente) && is_array($tipos_cliente) && !empty($tipos_cliente))
		{
			for($contador = 0; $contador < count($tipos_cliente); $contador++)
			{
				@mysql_query("insert into relacao_cliente_tipo (c_cod, tc_cod) values ('$numero_cliente','$tipos_cliente[$contador]')");
			}
		}

		// Realiza a inserção dos prestadores na tabela de relacionamento
		if(isset($tipos_prestador) && is_array($tipos_prestador) && !empty($tipos_prestador))
		{
			for($contador = 0; $contador < count($tipos_prestador); $contador++)
			{
				@mysql_query("insert into relacao_cliente_prestador (c_cod, tp_cod) values ('$numero_cliente','$tipos_prestador[$contador]')");
			}
		}
/**/
		if($novo=='S')
		{
			echo('<script language="javascript">alert("Você inseriu o cliente '.$c_nome.'!");document.location.href="'.$url.'";</script>');
		}
		else
		{
			echo('<script language="javascript">alert("Você inseriu o cliente '.$c_nome.'!");document.location.href="p_insert_clientes.php";</script>');
		}
	}
}
?>
 <div align="center">
  <center>
<?php
	if(!IsSet($inserir1))
	{
?>
<script language="javascript">
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
    field.style.backgroundColor = '<?=$cor_erro ?>';
    return false;
  } 
  else {
    field.value=temp.substring(0,2)+'.'+temp.substring(2,5)+'.'+temp.substring(5,8)+'/'+temp.substring(8,12)+'-'+temp.substring(12,14);
    field.style.backgroundColor = '<?=$cor1 ?>';
    return true;
  }
 }
 else {
  if (cpf.length < 11) {
	alert( 'CPF inválido.');
	field.value = '';
	field.focus();
	field.style.backgroundColor = '<?=$cor_erro ?>';
	return false;
  }
  else
  {
  	field.style.backgroundColor = '<?=$cor1 ?>'; 
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

function valida()
{
  var msg = "Os seguintes campos obrigatórios não foram preenchidos:\n";
  var confirma = 1;
  if (document.form1.c_tipo_pessoa.selectedIndex == 0)
  {
    msg += "* Tipo de Pessoa\n";
    if (confirma == 1) { document.form1.c_tipo_pessoa.focus(); }
    document.form1.c_tipo_pessoa.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
   	document.form1.c_tipo_pessoa.style.backgroundColor = '<?=$cor1 ?>';
  }

  /* Checa se foi selecionado ao menos um checkbox do tipo de cliente */

  var tipos_checados = document.getElementsByName("tipos_cliente[]");
  var checados = 0;
  for(var i = 0; i < tipos_checados.length; i++)
  {
  	if(tipos_checados[i].checked == false)
  	{
  		checados++;
  	}
  }

  if(checados == tipos_checados.length)
  {
  	 msg += "* Tipo do cliente\n";
//retirado a pedido do fabio da rebri - 26/11/2009 // document.form1.todas.focus();
  	 document.form1.todas.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
   	document.form1.todas.style.backgroundColor = '#EDEEEE';
  }

  /* Checa se foi selecionado ao menos um checkbox do tipo de prestador */
 	if(document.getElementById('tipos_cliente_4').checked == true)
  	{
  		// Checa se ao menos um prestador foi selecionado
  		var tipos_prestador_checados = document.getElementsByName("tipos_prestador[]");
  		var quantidade_checados = 0;
  		for(var j = 0; j < tipos_prestador_checados.length; j++)
  		{
  			if(tipos_prestador_checados[j].checked == false)
  			{
  				quantidade_checados++;
  			}
  		}
  		if(quantidade_checados == tipos_prestador_checados.length)
  		{
         msg += "* Tipo de Prestador\n";
         document.form1.todos_prestadores.style.backgroundColor = '<?=$cor_erro ?>';
         confirma = 0;
  		}
  		else
  		{
   			document.form1.todos_prestadores.style.backgroundColor = '#EDEEEE';
  		}
  	}

  if (document.form1.c_tipo_pessoa.value == "F"){
  	if (document.form1.c_nome.value == "")
	{
    	msg += "* Nome\n";
      document.form1.c_nome.focus();
    	document.form1.c_nome.style.backgroundColor = '<?=$cor_erro ?>';
      confirma = 0;
  	}
  	else
  	{
   		document.form1.c_nome.style.backgroundColor = '<?=$cor1 ?>';
  	}

   if (document.form1.dia.value == "")
   {
    msg += "* Dia do Nascimento\n";
    if (confirma == 1) { document.form1.dia.focus(); }
    document.form1.dia.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
  	 document.form1.dia.style.backgroundColor = '<?=$cor1 ?>';
   }
   if (document.form1.mes.value == "")
   {
    msg += "* Mês do Nascimento\n";
    if (confirma == 1) { document.form1.mes.focus(); }
    document.form1.mes.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
  	 document.form1.mes.style.backgroundColor = '<?=$cor1 ?>';
   }
   if (document.form1.ano.value == "")
   {
    msg += "* Ano do Nascimento\n";
    if (confirma == 1) { document.form1.ano.focus(); }
    document.form1.ano.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
  	document.form1.ano.style.backgroundColor = '<?=$cor1 ?>';
   }
  }else if (document.form1.c_tipo_pessoa.value == "J"){
	if (document.form1.c_nome.value == "")
	{
      msg += "* Razão Social\n";
      document.form1.c_nome.focus();
    	document.form1.c_nome.style.backgroundColor = '<?=$cor_erro ?>';
      confirma = 0;
  	}
  	else
  	{
   		document.form1.c_nome.style.backgroundColor = '<?=$cor1 ?>';
  	}
   if (document.form1.dia1.value == "")
   {
    msg += "* Dia do Nascimento\n";
    if (confirma == 1) { document.form1.dia1.focus(); }
    document.form1.dia1.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
  	 document.form1.dia1.style.backgroundColor = '<?=$cor1 ?>';
   }
   if (document.form1.mes1.value == "")
   {
    msg += "* Mês do Nascimento\n";
    if (confirma == 1) { document.form1.mes1.focus(); }
    document.form1.mes1.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
  	 document.form1.mes1.style.backgroundColor = '<?=$cor1 ?>';
   }
   if (document.form1.ano1.value == "")
   {
    msg += "* Ano do Nascimento\n";
    if (confirma == 1) { document.form1.ano1.focus(); }
    document.form1.ano1.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
  	 document.form1.ano1.style.backgroundColor = '<?=$cor1 ?>';
   }
  }
  if (document.form1.c_tipo_pessoa.value == "F"){
  	if (document.form1.c_origem.value == "")
  	{
    	msg += "* Nacionalidade\n";
      if (confirma == 1) { document.form1.c_origem.focus(); }
    	document.form1.c_origem.style.backgroundColor = '<?=$cor_erro ?>';
      confirma = 0;
  	}
  	else
  	{
   		document.form1.c_origem.style.backgroundColor = '<?=$cor1 ?>';
  	}


/**
  	if (document.form1.c_rg.value == "")
  	{
    	msg += "* RG\n";
      if (confirma == 1) { document.form1.c_rg.focus(); }
    	document.form1.c_rg.style.backgroundColor = '<?=$cor_erro ?>';
      confirma = 0;
  	}
  	else
  	{
   		document.form1.c_rg.style.backgroundColor = '<?=$cor1 ?>';
  	}
   if (document.form1.c_civil.selectedIndex == 0)
   {
    msg += "* Estado Civil\n";
    if (confirma == 1) { document.form1.c_civil.focus(); }
    document.form1.c_civil.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
   	document.form1.c_civil.style.backgroundColor = '<?=$cor1 ?>';
   }
/**/
  }else if (document.form1.c_tipo_pessoa.value == "J"){
/**
    if (document.form1.c_rg.value == "")
    {
      msg += "* Inscrição Estadual\n";
      if (confirma == 1) { document.form1.c_rg.focus(); }
    	document.form1.c_rg.style.backgroundColor = '<?=$cor_erro ?>';
      confirma = 0;
  	}
  	else
  	{
   		document.form1.c_rg.style.backgroundColor = '<?=$cor1 ?>';
  	}
/**/
  }
/**
  if (document.form1.c_end.value == "")
  {
    msg += "* Endereço\n";
    if (confirma == 1) { document.form1.c_end.focus(); }
    document.form1.c_end.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
  	document.form1.c_end.style.backgroundColor = '<?=$cor1 ?>';
  }
  if (document.form1.c_cep.value == "")
  {
    msg += "* CEP\n";
    if (confirma == 1) { document.form1.c_cep.focus(); }
    document.form1.c_cep.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
  	document.form1.c_cep.style.backgroundColor = '<?=$cor1 ?>';
  }
/**/
  if (document.form1.c_cidade.value == "")
  {
    msg += "* Cidade\n";
    if (confirma == 1) { document.form1.c_cidade.focus(); }
    document.form1.c_cidade.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
  	document.form1.c_cidade.style.backgroundColor = '<?=$cor1 ?>';
  }
  if (document.form1.c_estado1.value == "")
  {
    msg += "* Estado\n";
    if (confirma == 1) { document.form1.c_cidade.focus(); }
    document.form1.c_estado1.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
  	document.form1.c_estado1.style.backgroundColor = '<?=$cor1 ?>';
  }
/**
  if (document.form1.c_tel.value == "")
  {
    msg += "* Telefone\n";
    if (confirma == 1) { document.form1.c_tel.focus(); }
    document.form1.c_tel.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
  	document.form1.c_tel.style.backgroundColor = '<?=$cor1 ?>';
  }
/**/

   if (confirma == 0) {
      alert (msg);
     	return false;
   } else {
	   return true;
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
function selecionar_todas(retorno, nome_checar)
{
	var elementos_input = document.getElementsByName(nome_checar);
	if(retorno==true)
	{
  		for(var i = 0; i < elementos_input.length; i++)
  		{
  			if(elementos_input[i].checked == false)
  			{
  				elementos_input[i].checked = true;
  			}
  		}
	}
	else
	{
		for(var i = 0; i < elementos_input.length; i++)
  		{
  			if(elementos_input[i].checked == true)
  			{
  				elementos_input[i].checked = false;
  			}
  		}
	}
}
</script>
  <form method="post" name="form1" onSubmit="return valida();" action="<?php print("$PHP_SELF"); ?>">
  <input type="hidden" name="novo" id="novo" value="<?=$novo ?>">
  <input type="hidden" name="url" id="url" value="<?=$url ?>">
  <div align="center">
  <table border="0" cellspacing="1" width="<? if($novo=='S'){ ?>95%<? }else{ ?>75% <? } ?>">
    <tr>
      <td class="style1 fundoTabela"><b>Tipo de Pessoa:</b></td>
      <td class="style1 fundoTabela"><select name="c_tipo_pessoa" class="campo" onChange="form1.submit();">
        <option selected value="">Selecione</option>
        <option value="F" <? if($c_tipo_pessoa=='F'){ echo "SELECTED"; } ?> SELECTED>Física</option>
        <option value="J" <? if($c_tipo_pessoa=='J'){ echo "SELECTED"; } ?>>Jurídica</option>
      </select></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Tipo:<span class="style7">*</span></b></td>
      <td width="70%" class="style1 fundoTabela">
      
      <table cellspacing="0" cellpadding="0" with="100%">
      	<tr>
      		<td colspan="2" class="style1" height="25px"><input name="todas" <?php if($todas == 'checkbox'){?> checked="ckecked"<?php } ?> type="checkbox" id="todas" value="checkbox" onClick="selecionar_todas(this.checked, 'tipos_cliente[]');form1.submit();"><label class="style1" for="todas" id="checar"><?php if($todas == 'checkbox'){?>Desmarcar<?php }else{ ?>Marcar<?php } ?> todos</label></td>
      	</tr>
      <?php
      // Seleciona os tipos de clientes cadastrados no banco de dados e exibe um checkbox para cada tipo
      $sqlTipos = "select tc_cod, tc_tipo from tipos_clientes";
      $buscaTipos = mysql_query($sqlTipos);
      $cont = 0;
      $i = 0;
      while($colunaTipos = mysql_fetch_array($buscaTipos))
      {
      	if ($cont == 8)
	    {
			$cont = 0;
			print "<tr>";
		}
		?>
			<td height="25px">
				<input type="checkbox"<?php
				if(isset($tipos_cliente))
				{
					 for($contador = 0; $contador < count($tipos_cliente); $contador++)
					 {
					 	if($tipos_cliente[$contador] == $colunaTipos['tc_cod'])
					 	{
					 		?> checked="checked"<?php 
					 	} 
					 } 
				} ?> name="tipos_cliente[]" id="tipos_cliente_<?php echo $i; ?>" value="<?php echo $colunaTipos['tc_cod']; ?>"<?php if($colunaTipos['tc_cod'] == 5){?> onClick="form1.submit();"<?php } ?>>&nbsp;<label for="tipos_cliente_<?php echo $i; ?>" class="style1" style="margin-right:10px;"><?php echo $colunaTipos['tc_tipo']; ?></label>
			</td>
		<?php
      	if ($cont == 8)
		{
			$cont = 0;
			print "</tr><tr>";
		}
		$i++;
	  	$cont++;
	  	}
      ?>
        </table>
        </td>
    </tr>
<? if(isset($tipos_cliente) && in_array(5,$tipos_cliente))
{
?>
<tr>
    <td class="style1 fundoTabela"><b>Tipo de prestador<span class="style7">*</span>:</b></td>
    <td class="style1 fundoTabela">	<table cellspacing="0" cellpadding="0" with="100%">
      	<tr>
      		<td colspan="2" class="style1" height="25px"><input name="todos_prestadores" <?php if($todos_prestadores == 'checkbox'){?> checked="ckecked"<?php } ?> type="checkbox" id="todos_prestadores" value="checkbox" onClick="selecionar_todas(this.checked, 'tipos_prestador[]');form1.submit();"><label class="style1" for="todos_prestadores" id="checar"><?php if($todos_prestadores == 'checkbox'){?>Desmarcar<?php }else{ ?>Marcar<?php } ?> todos</label></td>
      	</tr>
<?php
	  // Seleciona os tipos de prestadores cadastrados no banco de dados e exibe um checkbox para cada tipo
      $sqlTiposPrestadores = "select tp_cod, tp_tipo from tipos_prestadores";
      $buscaTiposPrestadores = mysql_query($sqlTiposPrestadores);
      $contP = 0;
      $j = 0;
      while($colunaTiposPrestadores = mysql_fetch_array($buscaTiposPrestadores))
      {
      	if ($contP == 8)
	    {
			$contP = 0;
			print "<tr>";
		}
		?>
			<td height="25px">
				<input type="checkbox"<?php
				if(isset($tipos_prestador))
				{
					 for($contador = 0; $contador < count($tipos_prestador); $contador++)
					 {
					 	if($tipos_prestador[$contador] == $colunaTiposPrestadores['tp_cod'])
					 	{
					 		?> checked="checked"<?php
					 	}
					 }
				} ?> name="tipos_prestador[]" id="tipos_prestador_<?php echo $j; ?>" value="<?php echo $colunaTiposPrestadores['tp_cod']; ?>">&nbsp;<label for="tipos_prestador_<?php echo $j; ?>" class="style1" style="margin-right:10px;"><?php echo $colunaTiposPrestadores['tp_tipo']; ?></label>
			</td>
		<?php
      	if ($contP == 8)
		{
			$contP = 0;
			print "</tr><tr>";
		}
		$j++;
	  	$contP++;
	  	}
      ?>
        </table>
        </td>
    </tr>
<? } ?>
<? if($_POST['c_tipo_pessoa']=='J'){ ?>
	<tr>
      <td width="30%" class="style1 fundoTabela"><b>Razão Social:<span class="style7">*</span></b></td>
      <td width="70%" class="style1 fundoTabela"> <input type="text" name="c_nome" size="40" value="<?php print("$c_nome"); ?>" class="campo"></td>
    </tr>
<? }else{ ?>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Nome:<span class="style7">*</span></b></td>
      <td width="70%" class="style1 fundoTabela"> <input type="text" name="c_nome" size="40" value="<?php print("$c_nome"); ?>" class="campo"></td>
    </tr>
<?
   }
 ?>
<? if($_POST['c_tipo_pessoa']=='J'){ ?>
	    <tr>
      <td width="30%" class="style1 fundoTabela"><b>CNPJ:</b></td>
      <td width="70%" class="style1 fundoTabela"> <input type="text" size="18" name="c_cpf" class="campo" value="<?php print("$c_cpf"); ?>" onBlur="javascript:Verifica_CPF_CGC(this);" maxlenght="18" onKeyUp="return autoTab(this, 18, event);"></td>
    </tr>
<?
    }else{
?>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>CPF:</b></td>
      <td width="70%" class="style1 fundoTabela"> <input type="text" size="18" name="c_cpf" class="campo" value="<?php print("$c_cpf"); ?>" onBlur="javascript:Verifica_CPF_CGC(this);" maxlenght="18" onKeyUp="return autoTab(this, 18, event);"></td>
    </tr>
<?
   }
?>
<? if($_POST['c_tipo_pessoa']=='J'){ ?>
	<tr>
      <td width="30%" class="style1 fundoTabela"><b>Inscrição Estadual:</b> </td>
      <td width="70%" class="style1 fundoTabela"> <input type="text" name="c_rg" size="20" class="campo" value="<?php print("$c_rg"); ?>"></td>
    </tr>
<?
    }else{
?>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>RG:</b> </td>
      <td width="70%" class="style1 fundoTabela"> <input type="text" name="c_rg" size="20" class="campo" value="<?php print("$c_rg"); ?>"></td>
    </tr>
<?
   }
?>
<? if ($_POST['c_tipo_pessoa']!='J') { ?>
  <tr>
    <td width="30%" class="fundoTabela"><b class="style1">Nascimento:<span class="style7">*</span></b></td>
    <td width="70%" class="style1 fundoTabela">
    <input type="text" name="dia" size="2" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" class="campo" value="<?php print("$dia"); ?>">/<input type="text" class="campo" name="mes" size="2" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes"); ?>">/<input type="text" name="ano" size="4" maxlenght="4" class="campo" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>">
    Ex.: 10/10/1950</td>
  </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Estado civil:</b></td>
      <td width="70%" class="style1 fundoTabela"> <select name="c_civil" class="campo" onChange="form1.submit();">
    <option value="">Selecione</option>
    <option value="Solteiro(a)" <? if($c_civil=='Solteiro(a)'){ echo "SELECTED"; } ?>>Solteiro(a)</option>
    <option value="Casado(a)" <? if($c_civil=='Casado(a)'){ echo "SELECTED"; } ?>>Casado(a)</option>
    <option value="Viúvo(a)" <? if($c_civil=='Viúvo(a)'){ echo "SELECTED"; } ?>>Viúvo(a)</option>
    <option value="Separado(a)" <? if($c_civil=='Separado(a)'){ echo "SELECTED"; } ?>>Separado(a)</option>
    <option value="Divorciado(a)" <? if($c_civil=='Divorciado(a)'){ echo "SELECTED"; } ?>>Divorciado(a)</option>
    <option value="União Estável" <? if($c_civil=='União Estável'){ echo "SELECTED"; } ?>>União Estável</option>
        </select></td>
    </tr>
<?
 	if($_POST['c_civil']=='Casado(a)'){
?>
	<tr>
      <td width="30%" class="style1 fundoTabela"><b>Nome do Cônjuge:</b></td>
      <td width="70%" class="style1 fundoTabela"> <input type="text" name="c_conjuge" size="40" value="<?php print("$c_conjuge"); ?>" class="campo"></td>
    </tr>
	<tr>
      <td width="30%" class="style1 fundoTabela"><b>RG do Cônjuge:</b> </td>
      <td width="70%" class="style1 fundoTabela"> <input type="text" name="c_rg_conjuge" size="20" class="campo" value="<?php print("$c_rg_conjuge"); ?>"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>CPF do Cônjuge:</b></td>
      <td width="70%" class="style1 fundoTabela"> <input type="text" size="18" name="c_cpf_conjuge" class="campo" value="<?php print("$c_cof_conjuge"); ?>" onBlur="javascript:Verifica_CPF_CGC(this);" maxlenght="18" onKeyUp="return autoTab(this, 18, event);"></td>
    </tr>
<? } ?>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Nacionalidade<span class="style7">*</span>:</b></td>
      <td width="70%" class="style1 fundoTabela"> <input type="text" name="c_origem" size="30" value="<?php if($c_origem){ print("$c_origem"); }else { echo "Brasileiro"; } ?>" class="campo"></td>
    </tr>
<? } ?>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Endereço:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" name="c_end" size="40" class="campo" value="<?php print("$c_end"); ?>"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Bairro:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" name="c_bairro" size="30" class="campo" value="<?php print("$c_bairro"); ?>"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>CEP:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" name="c_cep" class="campo" size="8" maxlenght="8" onKeyUp="return autoTab(this, 8, event);" value="<?php print("$c_cep"); ?>"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Cidade:<span class="style7">*</span></b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" name="c_cidade" size="40" class="campo" value="<?php print("$c_cidade"); ?>"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Estado: <span class="style7">*</span></b></td>
      <td width="70%" class="style1 fundoTabela"><select name="c_estado1" class="campo">
                      <option value="">Selecione</option>
                      <option value="AC" <? if($c_estado1=='AC'){ echo "SELECTED"; } ?>>AC</option>
                      <option value="AL" <? if($c_estado1=='AL'){ echo "SELECTED"; } ?>>AL</option>
                      <option value="AM" <? if($c_estado1=='AM'){ echo "SELECTED"; } ?>>AM</option>
                      <option value="AP" <? if($c_estado1=='AP'){ echo "SELECTED"; } ?>>AP</option>
                      <option value="BA" <? if($c_estado1=='BA'){ echo "SELECTED"; } ?>>BA</option>
                      <option value="CE" <? if($c_estado1=='CE'){ echo "SELECTED"; } ?>>CE</option>
                      <option value="ES" <? if($c_estado1=='ES'){ echo "SELECTED"; } ?>>ES</option>
                      <option value="DF" <? if($c_estado1=='DF'){ echo "SELECTED"; } ?>>DF</option>
                      <option value="GO" <? if($c_estado1=='GO'){ echo "SELECTED"; } ?>>GO</option>
                      <option value="MA" <? if($c_estado1=='MA'){ echo "SELECTED"; } ?>>MA</option>
                      <option value="MG" <? if($c_estado1=='MG'){ echo "SELECTED"; } ?>>MG</option>
                      <option value="MS" <? if($c_estado1=='MS'){ echo "SELECTED"; } ?>>MS</option>
                      <option value="MT" <? if($c_estado1=='MT'){ echo "SELECTED"; } ?>>MT</option>
                      <option value="PA" <? if($c_estado1=='PA'){ echo "SELECTED"; } ?>>PA</option>
                      <option value="PB" <? if($c_estado1=='PB'){ echo "SELECTED"; } ?>>PB</option>
                      <option value="PE" <? if($c_estado1=='PE'){ echo "SELECTED"; } ?>>PE</option>
                      <option value="PI" <? if($c_estado1=='PI'){ echo "SELECTED"; } ?>>PI</option>
                      <option value="PR" <? if($c_estado1=='PR'){ echo "SELECTED"; } ?>>PR</option>
                      <option value="RJ" <? if($c_estado1=='RJ'){ echo "SELECTED"; } ?>>RJ</option>
                      <option value="RN" <? if($c_estado1=='RN'){ echo "SELECTED"; } ?>>RN</option>
                      <option value="RO" <? if($c_estado1=='RO'){ echo "SELECTED"; } ?>>RO</option>
                      <option value="RR" <? if($c_estado1=='RR'){ echo "SELECTED"; } ?>>RR</option>
                      <option value="RS" <? if($c_estado1=='RS'){ echo "SELECTED"; } ?>>RS</option>
                      <option value="SC" <? if($c_estado1=='SC'){ echo "SELECTED"; } ?>>SC</option>
                      <option value="SE" <? if($c_estado1=='SE'){ echo "SELECTED"; } ?>>SE</option>
                      <option value="SP" <? if($c_estado1=='SP'){ echo "SELECTED"; } ?>>SP</option>
                      <option value="TO" <? if($c_estado1=='TO'){ echo "SELECTED"; } ?>>TO</option>
                      <option value="">Outro</option></select> Outro: <input type="text" name="c_estado2" size="2" class="campo" value="<?php print("$c_estado2"); ?>">
                      Obs.: Máximo duas letras</td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>País Comercial:</b></td>
      <td width="70%" class="style1 fundoTabela"> <input type="text" name="c_origem_com" size="30" value="<? if($c_origem_com) { print("$c_origem_com"); } else { echo "Brasil"; } ?>" class="campo"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Endereço Comercial:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" name="c_end_com" size="40" class="campo" value="<?php print("$c_end_com"); ?>"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Bairro Comercial:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" name="c_bairro_com" size="30" class="campo" value="<?php print("$c_bairro_com"); ?>"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>CEP Comercial:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" name="c_cep_com" class="campo" size="8" maxlenght="8" onKeyUp="return autoTab(this, 8, event);" value="<?php print("$c_cep_com"); ?>"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Cidade Comercial:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" name="c_cidade_com" size="40" class="campo" value="<?php print("$c_cidade_com"); ?>"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Estado Comercial:</b></td>
      <td width="70%" class="style1 fundoTabela"><select name="c_estado_com1" class="campo">
                      <option value="">Selecione</option>
                      <option value="AC" <? if($c_estado_com1=='AC'){ echo "SELECTED"; } ?>>AC</option>
                      <option value="AL" <? if($c_estado_com1=='AL'){ echo "SELECTED"; } ?>>AL</option>
                      <option value="AM" <? if($c_estado_com1=='AM'){ echo "SELECTED"; } ?>>AM</option>
                      <option value="AP" <? if($c_estado_com1=='AP'){ echo "SELECTED"; } ?>>AP</option>
                      <option value="BA" <? if($c_estado_com1=='BA'){ echo "SELECTED"; } ?>>BA</option>
                      <option value="CE" <? if($c_estado_com1=='CE'){ echo "SELECTED"; } ?>>CE</option>
                      <option value="ES" <? if($c_estado_com1=='ES'){ echo "SELECTED"; } ?>>ES</option>
                      <option value="DF" <? if($c_estado_com1=='DF'){ echo "SELECTED"; } ?>>DF</option>
                      <option value="GO" <? if($c_estado_com1=='GO'){ echo "SELECTED"; } ?>>GO</option>
                      <option value="MA" <? if($c_estado_com1=='MA'){ echo "SELECTED"; } ?>>MA</option>
                      <option value="MG" <? if($c_estado_com1=='MG'){ echo "SELECTED"; } ?>>MG</option>
                      <option value="MS" <? if($c_estado_com1=='MS'){ echo "SELECTED"; } ?>>MS</option>
                      <option value="MT" <? if($c_estado_com1=='MT'){ echo "SELECTED"; } ?>>MT</option>
                      <option value="PA" <? if($c_estado_com1=='PA'){ echo "SELECTED"; } ?>>PA</option>
                      <option value="PB" <? if($c_estado_com1=='PB'){ echo "SELECTED"; } ?>>PB</option>
                      <option value="PE" <? if($c_estado_com1=='PE'){ echo "SELECTED"; } ?>>PE</option>
                      <option value="PI" <? if($c_estado_com1=='PI'){ echo "SELECTED"; } ?>>PI</option>
                      <option value="PR" <? if($c_estado_com1=='PR'){ echo "SELECTED"; } ?>>PR</option>
                      <option value="RJ" <? if($c_estado_com1=='RJ'){ echo "SELECTED"; } ?>>RJ</option>
                      <option value="RN" <? if($c_estado_com1=='RN'){ echo "SELECTED"; } ?>>RN</option>
                      <option value="RO" <? if($c_estado_com1=='RO'){ echo "SELECTED"; } ?>>RO</option>
                      <option value="RR" <? if($c_estado_com1=='RR'){ echo "SELECTED"; } ?>>RR</option>
                      <option value="RS" <? if($c_estado_com1=='RS'){ echo "SELECTED"; } ?>>RS</option>
                      <option value="SC" <? if($c_estado_com1=='SC'){ echo "SELECTED"; } ?>>SC</option>
                      <option value="SE" <? if($c_estado_com1=='SE'){ echo "SELECTED"; } ?>>SE</option>
                      <option value="SP" <? if($c_estado_com1=='SP'){ echo "SELECTED"; } ?>>SP</option>
                      <option value="TO" <? if($c_estado_com1=='TO'){ echo "SELECTED"; } ?>>TO</option>
                      <option value="">Outro</option></select> Outro: <input type="text" name="c_estado_com2" size="2" class="campo" value="<?php print("$c_estado_com2"); ?>">
                      Obs.: Máximo duas letras</td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Telefone:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" class="campo" name="c_tel" size="13" maxlength="13" value="<?php print("$c_tel"); ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Telefone 2:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" class="campo" name="c_tel2" size="13" maxlength="13" value="<?php print("$c_tel2"); ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Telefone Comercial:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" class="campo" name="c_tel_com" size="13" maxlength="13" value="<?php print("$c_tel_com"); ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
<? if($_POST['c_tipo_pessoa']<>'J'){ ?>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Celular:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" class="campo" name="c_cel" size="13" maxlength="13" value="<?php print("$c_cel"); ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Celular 2:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" class="campo" name="c_cel2" size="13" maxlength="13" value="<?php print("$c_cel2"); ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
<? } ?>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Fax:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" class="campo" name="c_fax" size="13" maxlength="13" value="<?php print("$c_fax"); ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Fax Comercial:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" class="campo" name="c_fax_com" size="13" maxlength="13" value="<?php print("$c_fax_com"); ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>E-mail:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" class="campo" name="c_email" size="40" value="<?php print("$c_email"); ?>"></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>E-mail Comercial:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" class="campo" name="c_email_com" size="40" value="<?php print("$c_email_com"); ?>"></td>
    </tr>
<?php
$dia1 = date(d);
$mes1 = date(m);
$ano1 = date(Y);
?>
  <tr>
    <td width="30%" class="style1 fundoTabela"><b>Cliente desde:</b></td>
    <td width="70%" class="style1 fundoTabela">
    <input type="text" name="dia1" size="2" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia1"); ?>" class="campo">/<input type="text" class="campo" name="mes1" size="2" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes1"); ?>">/<input type="text" class="campo" name="ano1" size="4" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano1"); ?>">
    Ex.: 01/01/1987</td>
  </tr>
    <tr>
      <td width="30%" valign="top" class="style1 fundoTabela"><b>Observação:</b></td>
      <td width="70%" class="style1 fundoTabela"><textarea rows="10" name="c_obs" cols="50" class="campo"><?php print("$c_obs"); ?></textarea></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Banco:</b></td>
      <td width="70%" class="style1 fundoTabela"> <select size="1" name="c_banco" class="campo">
        <option value="">Novo banco</option>
<?php
	$bbanco = mysql_query("select b_nome from bancos where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by b_nome");
 	while($linha = mysql_fetch_array($bbanco)){
		if($linha[b_nome]==$_POST['c_banco']){
	   		echo('<option value="'.$linha[b_nome].'" SELECTED>'.$linha['b_nome'].'</option>');
		}else{
			echo('<option value="'.$linha[b_nome].'">'.$linha['b_nome'].'</option>');
		}
	}
?>
  </select> <input type="text" name="novo_banco" size="20" class="campo"> <? if($novo<>'S'){ ?> <a href="#" onClick="NewWindow('p_exc_bancos.php','uprelatorio','500','200','yes');" class=style1><b>Excluir Banco</b></a> <? } ?></td>
    </tr>
    <tr>
      <td width="30%" valign="top" class="style1 fundoTabela"><b>Conta Corrente:</b></td>
      <td width="70%" class="style1 fundoTabela"><textarea rows="2" name="c_conta" cols="40" class="campo"><?php print("$c_conta"); ?></textarea></td>
    </tr>
<? if($_POST['c_tipo_pessoa']<>'J'){ ?>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Profissão:</b></td>
      <td width="70%" class="style1 fundoTabela"><input type="text" name="c_prof" size="30" class="campo" value="<?php print("$c_prof"); ?>"></td>
    </tr>
<?
	}
	if($_POST['c_tipo_pessoa']=='J'){
?>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Representante 1:</b></td>
      <td width="70%" class="style1 fundoTabela"><textarea rows="2" name="c_repre" cols="40" class="campo"><?php print("$c_repre"); ?></textarea></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Representante 2:</b></td>
      <td width="70%" class="style1 fundoTabela"><textarea rows="2" name="c_repre2" cols="40" class="campo"><?php print("$c_repre2"); ?></textarea></td>
    </tr>
<? } ?>
	<tr class="fundoTabela">
      <td colspan="2" class="style1"><b>Campos marcados com <span class="style7">*</span> são de preenchimento obrigatório.</b></td>
    </tr>
    <tr>
      <td width="30%">
      <input type="hidden" value="1" name="inserir2">
      <input type="submit" value="Inserir Cadastro" name="B1" class=campo3></td>
      <td width="70%"></td>
    </tr>
  </table>
  </div>
  </form>
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
<!--Área protegida!-->
<?php
//	}
?>
<?
if($novo<>'S'){
if(session_is_registered("valid_user")){ ?>
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
<? }
} ?>
</body>
</html>