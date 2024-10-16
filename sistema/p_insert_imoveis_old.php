<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
?>
<html>
<head>
<?php
include("style.php");
include("conect.php");
include("l_funcoes.php");
?>
</head>
<body>
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
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
?>
<p>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="600" bgcolor="#DCE0E4">
  <tr bgcolor="#DCE0E4"><td colspan=2>
 <p align="center"><font color="Blue" size="2" face="Arial"><b>Inserir Imóveis</b></font><br>
 <font color="#000000" size="2" face="Arial"><a href="p_imoveis.php">
 Clique para visualizar a relação de imóveis</a></font></p></td></tr>
<?php

if($B1 == "Inserir Imóvel")
	{
	
	$titulo = AddSlashes($titulo);
	$desc = AddSlashes($descricao);
	$permuta_txt = AddSlashes($permuta_txt);
	$img_peq = "$ref" . "_peq.jpg";
	$img_1 = "$ref" . "_1.jpg";
	$img_2 = "$ref" . "_2.jpg";
	$img_3 = "$ref" . "_3.jpg";
	$img_4 = "$ref" . "_4.jpg";
	$img_5 = "$ref" . "_5.jpg";
	$img_6 = "$ref" . "_6.jpg";
	$img_7 = "$ref" . "_7.jpg";
	$img_8 = "$ref" . "_8.jpg";
	$img_9 = "$ref" . "_9.jpg";
	$img_10 = "$ref" . "_10.jpg";
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

	$query = "insert into muraski (cod_imobiliaria, ref, tipo, metragem, 
	n_quartos, valor, especificacao, suites, piscina, titulo, 
	descricao, img_peq, img_1, img_2, img_3, img_4, img_5, img_6, 
	img_7, img_8, img_9, img_10, local, permuta, finalidade, permuta_txt, 
	ftxt_1, ftxt_2, ftxt_3, ftxt_4, ftxt_5, ftxt_6, ftxt_7, ftxt_8, 
	ftxt_9, ftxt_10, ftxt_11, ftxt_12, ftxt_13, ftxt_14, ftxt_15
	, ftxt_16, ftxt_17, ftxt_18, ftxt_19, ftxt_20, cliente, matricula, cidade_mat
	, end, averbacao, acomod, dist_mar, dist_tipo, limpeza, diaria1, diaria2
	, data_inicio, data_fim, comissao, dias, carnaval, anonovo) 
	values('".$_SESSION['cod_imobiliaria']."','$ref', '$tipo1', '$metragem', '$n_quartos', 
	'$valor', '$especificacao', '$suites', '$piscina', 
	'$titulo', '$desc', '$img_peq', '$img_1', '$img_2', '$img_3'
	, '$img_4', '$img_5', '$img_6', '$img_7', '$img_8', '$img_9'
	, '$img_10', '$local', '$permuta', '$finalidade', '$permuta_txt', 
	'$ftxt_1', '$ftxt_2', '$ftxt_3', '$ftxt_4', '$ftxt_5', '$ftxt_6', 
	'$ftxt_7', '$ftxt_8', '$ftxt_9', '$ftxt_10', '$ftxt_11', '$ftxt_12'
	, '$ftxt_13', '$ftxt_14', '$ftxt_15', '$ftxt_16', '$ftxt_17'
	, '$ftxt_18', '$ftxt_19', '$ftxt_20', '$cliente', '$matricula', '$cidade_mat'
	, '$end', '$averbacao', '$acomod', '$dist_mar', '$dist_tipo', '$limpeza', '$diaria1'
	, '$diaria2', '$data_inicio', '$data_fim', '$comissao', '$dias', '$carnaval', '$anonovo')";
	$result = mysql_query($query) or die("Não foi possível inserir suas informações.");
?>
<tr bgcolor="#ffffff"><td colspan=2>
<p align="center"><font color="#ff0000" size="2" face="Arial">
Você inseriu o imóvel <b>Ref.:</b> <i><?php print("$ref"); ?></i>.</font></p></td></tr>
<?php
	}
//mysql_free_result($result);
?>
 <div align="center">
  <center>
<?php
	if(!IsSet($inserir1))
	{
?>
<script>
function valida()
{
  if (form1.ref.value == "")
  {
    alert("Por favor, digite Referência");
    form1.ref.focus();
    return (false);
  }
  if (form1.titulo.value == "")
  {
    alert("Por favor, digite o Título");
    form1.titulo.focus();
    return (false);
  }
  if (form1.descricao.value == "")
  {
    alert("Por favor, digite a Descrição");
    form1.descricao.focus();
    return (false);
  }
  if (form1.metragem.value == "")
  {
    alert("Por favor, digite a Metragem");
    form1.metragem.focus();
    return (false);
  }
  if (form1.n_quartos.value == "")
  {
    alert("Por favor, digite o Número de quartos");
    form1.n_quartos.focus();
    return (false);
  }
  if (form1.valor.value == "")
  {
    alert("Por favor, digite o Valor");
    form1.valor.focus();
    return (false);
  }
  if (form1.suites.value == "")
  {
    alert("Por favor, digite o Número de Suítes");
    form1.suites.focus();
    return (false);
  }
  if (form1.local.value == "")
  {
    alert("Por favor, digite a Localização");
    form1.local.focus();
    return (false);
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
  <form method="post" name="form1" onsubmit="return valida();" action="<?php print("$PHP_SELF"); ?>">
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Proprietário:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <select size="1" name="cliente">
<?php
	if($c_cod == ""){
	$c_nome = "Selecione um proprietário";
	}else{
	$c_nome = $c_nome;
	}
?>
    <option selected value="<?php print("$c_cod"); ?>"><?php print("$c_nome"); ?></option>
<?php
	$query0 = "select c_cod, c_nome from clientes 
	where c_tipo='proprietario' where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c_nome, c_cod";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	if($numrows0 > 0){
	while($not0 = mysql_fetch_array($result0))
	{
?>
<option value="<?php print("$not0[c_cod]"); ?>"><?php print("$not0[c_nome]"); ?></option>
<?php
	}
	}
?>
        </select></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Contrato de:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> 
      <input type="text" name="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);"><font size="2">/</font><input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);"><font size="2">/</font><input type="text" name="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);"> <b>à</b> <input type="text" name="dia1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);"><font size="2">/</font><input type="text" name="mes1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);"><font size="2">/</font><input type="text" name="ano1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);"><i><font size="1">Ex.: 
    10/10/1910</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Dias úteis:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> 
      <input type="text" name="dias" size="2" class="campo"<font size="1">Obs.: Apenas para imóveis à venda</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="000080" size="2" face="Arial"><b>Tipo de imóvel:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <select name="tipo1" class="campo">
    <option selected>Apartamento</option>
    <option>Cobertura</option>
    <option>Comercial</option>
    <option>Residência</option>
    <option>Sobrado</option>
    <option>Terreno</option>
      </select></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Referência:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <input type="text" name="ref" size="10" class="campo"></font></td>
    </tr>
   <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Título:</b> </font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <textarea rows="2" name="titulo" cols="36" class="campo"></textarea></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Descrição:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <textarea rows="5" name="descricao" cols="36" class="campo"></textarea></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Metragem:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <input type="text" name="metragem" size="10" class="campo">Exemplo:
        100.00 ou 100</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>N° de
        quartos:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="n_quartos" size="5" class="campo">Exemplo:
        1</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Valor/Diária:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="valor" size="10" class="campo">Exemplo:
        50000.00 ou 50000</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Diária mínima/Diária máxima:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="diaria1" size="10" class="campo">/<input type="text" name="diaria2" size="10" class="campo">Exemplo:
        50000.00 ou 50000</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Carnaval:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="carnaval" size="10" class="campo">Exemplo:
        50000.00 ou 50000</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Ano Novo:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="anonovo" size="10" class="campo">Exemplo:
        50000.00 ou 50000</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Taxa Limpeza:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="limpeza" size="10" class="campo">Exemplo:
        50.00 ou 50</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Especificação:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><select size="1" name="especificacao" class="campo">
    <option selected>Lançamento</option>
    <option>Novo</option>
    <option>Usado</option>
        </select></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Suítes:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="suites" size="5" class="campo">Exemplo:
        1</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Piscina:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><select size="1" name="piscina" class="campo">
    <option selected>Não</option>
    <option>Sim</option>
        </select></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Permuta:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><select size="1" name="permuta" class="campo">
    <option selected>Sim</option>
    <option>Não</option>
        </select></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>*Texto da Permuta:</b></font><br>
      <font color="#000080" size="1" face="Arial">
      *<i>Preencha esse campo apenas se você escolheu a opção "Sim" no campo Permuta.</i></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <textarea rows="3" name="permuta_txt" cols="36" class="campo"></textarea></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Localização:</b></font></td>
      <td width="80%"><input type="text" name="local" size="30" value="Guaratuba" class="campo">
    </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Finalidade do Imóvel:</b></font></td>
      <td width="80%"><select size="1" name="finalidade" class="campo">
    <option>Venda</option>
    <option>Locação</option>
        </select></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Matrícula:</b></font></td>
      <td width="80%"><input type="text" name="matricula" size="30" class="campo">
    </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Cidade Mat.:</b></font></td>
      <td width="80%"><select size="1" name="cidade_mat" class="campo">
    <option>Guaratuba</option>
    <option>São José dos Pinhais</option>
        </select></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Endereço:</b></font></td>
      <td width="80%"><input type="text" name="end" size="40" class="campo">
    </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Averbação:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="averbacao" size="10" class="campo">Exemplo:
        100.00 ou 100</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Acomodações:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="acomod" size="2" class="campo">Exemplo:
        1 ou 10</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Comissão:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="comissao" size="2" class="campo" value="15">Exemplo:
        6 ou 15</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Distância do mar:</b></font></td>
      <td width="80%"><input type="text" name="dist_mar" size="4" class="campo"><select size="1" name="dist_tipo" class="campo">
    <option>metros</option>
    <option>quadras</option>
        </select></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 1:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_1" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 2:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_2" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 3:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_3" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 4:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_4" size="30" class="campo">
        </font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 5:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_5" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 6:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_6" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 7:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_7" size="30" class="campo"></font></td>
    </tr>        
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 8:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_8" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 9:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_9" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 10:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_10" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 11:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_11" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 12:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_12" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 13:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_13" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 14:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_14" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 15:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_15" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 16:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_16" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 17:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_17" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 18:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_18" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 19:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_19" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome da foto 20:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="ftxt_20" size="30" class="campo"></font></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td width="20%"><font color="#035E01" size="2" face="Arial">
      <input type="hidden" value="1" name="inserir2">
      <input type="submit" value="Inserir Imóvel" name="B1" class=campo></font></td>
      <td width="80%"></td>
    </tr>
  </form>
  </table></div></center>
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
</body>
</html>