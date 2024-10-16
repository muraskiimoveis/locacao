<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
?>
<html>

<head>
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
<?php
include("style.php");
include("conect.php");
include("l_funcoes.php");
?>
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
include("funcoes/funcoes.php");
?>
<p>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin"))){
*/		
?>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function formConta(){

	if(confirm("Deseja Realmente confirmar esta conta?")){

   	   document.form1.acao.value = 1;
	}
}

function formData(){

	if(confirm("Deseja alterar a data novamente?")){

   	   document.form1.acaod.value = 1;
	}
}
function valida()
{
  if (form1.dia2.value == "")
  {
    alert("Por favor, digite o Dia de Entrada");
    form1.dia2.focus();
    return (false);
  }
  if (form1.mes2.value == "")
  {
    alert("Por favor, digite o Mês de Entrada");
    form1.mes2.focus();
    return (false);
  }
  if (form1.ano2.value == "")
  {
    alert("Por favor, digite o Ano de Entrada");
    form1.ano2.focus();
    return (false);
  }
  if (form1.dia3.value == "")
  {
    alert("Por favor, digite o Dia de Saída");
    form1.dia3.focus();
    return (false);
  }
  if (form1.mes3.value == "")
  {
    alert("Por favor, digite o Mês de Saída");
    form1.mes3.focus();
    return (false);
  }
  if (form1.ano3.value == "")
  {
    alert("Por favor, digite o Ano de Saída");
    form1.ano3.focus();
    return (false);
  }
  
  var data1 = form1.ano2.value + form1.mes2.value + form1.dia2.value;
  var data2 = form1.ano3.value + form1.mes3.value + form1.dia3.value;	
  if (data2 < data1) {
	alert("Data inicial deve ser menor que data final.");
	form1.dia.focus();
	return(false);
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
	$url = $REQUEST_URI;
	//echo $url;
	$url = explode("?", $url);
	//$url2 = explode("dia2", $url[1]);
	//$url = str_replace("&","-","$url");
	//$url = str_replace("?","|","$url");
?>
<div align="center">
  <center>
<table bgcolor="#<?php print("$cor1"); ?>" border="0" cellspacing="1" width=770>
<?php

if($_POST['acao']=='1')
{

   		$i = $_POST['i'];
  		$c = 0;

		for($j = 0; $j <= $i; $j++)
		{	     
		
     		$datas = "data_status_".$j;
     		$data_atual = formataDataParaBd($_POST[$datas]);
     		$codigos = "co_cod_".$j;
     		$total = $_POST[$codigos];
     		$botoes = "ok_".$j;
     		$botao = $_POST[$botoes];

	    	if($botao)
	    	{
    			$c++;
    			$query4= "update contas set co_status='ok', co_data_status='$data_atual', co_usuario_status='$valid_user' where co_cod='$total' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
				$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");			
    		} 	
		} 

}

if($_POST['acaod']=='1')
{

   		$i = $_POST['i'];
  		$c = 0;

		for($j = 0; $j <= $i; $j++)
		{	     
		
     		$codigos = "co_cod_".$j;
     		$total = $_POST[$codigos];
     		$botoes = "alterar_data_".$j;
     		$botao = $_POST[$botoes];

	    	if($botao)
	    	{
    			$c++;
    			$query4= "update contas set co_status='pendente', co_usuario_status='$valid_user' where co_cod='$total' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
				$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");			
    		} 	
		} 

}
?>



<form method="post" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
<input type="hidden" name="acao" id="acao" value="0">
<input type="hidden" name="acaod" id="acaod" value="0">
<?php
	if(($dia3 == "") or ($mes3 == "") or ($ano3 == "")){
	$dia3 = date(d);
	$mes3 = date(m);
	$ano3 = date(Y);
	}
	if(($dia2 == "") or ($mes2 == "") or ($ano2 == "")){
	$dia2 = date(d);
	$mes2 = date(m);
	$ano2 = date(Y);
	}
?>
	<tr bgcolor="#<?php print("$cor1"); ?>">
		<td colspan=8 class=style1><b>Relação de depósitos do período:</b> 
		<input type="text" name="dia2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia2"); ?>">/
      <input type="text" name="mes2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes2"); ?>">/
      <input type="text" name="ano2" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano2"); ?>"> <b>à</b> 
      <input type="text" name="dia3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia3"); ?>">/
      <input type="text" name="mes3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes3"); ?>">/
      <input type="text" name="ano3" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano3"); ?>"> <input type="submit" value="Pesquisar" name="B1" class=campo><br>Ex.: 
    10/10/1910 à 20/10/1910</td>
  </tr>
    <tr>
      <td colspan="3" class=style1><b>Banco:</b> <select size="1" name="c_banco1" class="campo">
        <option selected value="%%">Todos</option>
<?php
	$query3 = "select * from bancos where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by b_nome";
	$result3 = mysql_query($query3);
	$numrows3 = mysql_num_rows($result3);
	if($numrows3 > 0){
	while($not3 = mysql_fetch_array($result3))
		{
?>
    		<option value="<?php print("$not3[b_nome]"); ?>"><?php print("$not3[b_nome]"); ?></option>
<?php
		}
	}
?>
  </select></td>
        <td colspan="5" class=style1><b>Status:</b> <select size="1" name="co_status" class="campo">
        <option selected value="%%">Todos</option>
    <option value="ok">Já depositado</option>
    <option value="pendente">Pendente</option>
  </select> <select size="1" name="co_cat" class="campo">
        <option selected value="Pagar">Pagar</option>
    <option value="Receber">Receber</option>
  </select></td>
    </tr>
<tr>
	<td bgcolor="#<?php print("$cor1"); ?>" colspan=7 class=style1 align="left"><b>Relação de depósitos do período: <a class=style1><?php print("$dia2/$mes2/$ano2"); ?> à <?php print("$dia3/$mes3/$ano3"); ?></a></b></td>
</tr>
<tr>
	<td colspan=7 height=50></td>
</tr>
<?php
	if(!$from){
		$from = intval($screen * 10);
	}	
	
	/*
	if($acao == "Confirmar"){
	$data_status = formataDataParaBd($data_status);
	echo '**'.$data_status;
	$query4= "update contas set co_status='ok', co_data_status='$data_status', co_usuario_status='$valid_user' where co_cod='$co_cod'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");	}
	*/
	
	// Pegar dados do imóvel, conta e proprietário
	//if($co_cat == "Pagar"){
	$query0 = "select m.cod, m.titulo, m.ref, c.c_cod, c.c_nome, c.c_banco, c.c_conta, co.co_cod, co.co_valor, co.co_data, co.co_status, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status from clientes c, muraski m, contas co where co.co_imovel=m.cod and c.c_cod=co.co_cliente and (co.co_data>='$ano2-$mes2-$dia2' AND co.co_data<='$ano3-$mes3-$dia3') and c.c_banco like '$c_banco1' and co.co_tipo!='Despesas' and co.co_status like '$co_status' and co_cat='$co_cat' and co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.c_banco, co.co_data, m.ref";
	/*}elseif($co_cat == "Pagar"){
	$query0 = "select cod, titulo, ref, c_cod, c_nome, c_banco, c_conta, co_cod, co_valor, co_data, co_status 
	from clientes, muraski, contas where 
	co_imovel=cod and c_cod=co_cliente and (co_data>='$ano2-$mes2-$dia2' AND 
	co_data<='$ano3-$mes3-$dia3') and c_banco like '$c_banco1' and co_tipo!='Despesas' 
	and co_status like '$co_status' and co_cat='$co_cat' 
	order by c_banco, co_data, ref";
	}*/
	//echo $query0;
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	
	$i = 0;
	
	while($not0 = mysql_fetch_array($result0))
	{
	$query1 = "select c_banco, count(c_banco) as qtd_banco from clientes, muraski, contas where 
	co_imovel=cod and c_cod=co_cliente and (co_data>='$ano2-$mes2-$dia2' AND 
	co_data<='$ano3-$mes3-$dia3') and c_banco like '$not0[c_banco]' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
	group by c_banco order by c_banco";
	$result1 = mysql_query($query1);
	while($not1 = mysql_fetch_array($result1))
	{
		$qtd_banco = $not1[1];
		//echo $qtd_banco;
	}
		
				$cod = $not0['cod'];
				$co_cod = $not0['co_cod'];
				$ref = $not0['ref'];
				$titulo = $not0['titulo'];
				$cliente = $not0['c_nome'];
				$cliente = substr ($cliente, 0, 70);
				if(strlen($cliente) > 69){
					$cliente = $cliente . "...";
				}
				$c_cod = $not0['c_cod'];
				$c_banco = $not0['c_banco'];
				$c_conta = $not0['c_conta'];
				$c_conta = substr ($c_conta, 0, 70);
				if(strlen($c_conta) > 69){
					$c_conta = $c_conta . "...";
				}
				$co_valor = $not0['co_valor'];
				$co_valor = str_replace("-","","$co_valor");
				$ano = substr ($not0['co_data'], 0, 4);
		        $mes = substr($not0['co_data'], 5, 2 );
		        $dia = substr ($not0['co_data'], 8, 2 );
		        $data = "$dia/$mes/$ano";
		        $valor_tela = number_format($co_valor, 2, ',', '.');
		        $valor_tela = str_replace("-","","$valor_tela");
		        $data_status = $not0['data_status'];
		        
	//}
?>
<?php
	if($banco <> $c_banco){
		$banco = $c_banco;
?>
<?php
	if($i > 0){
	$total_tela = number_format($total, 2, ',', '.');
	$total_tela = str_replace("-","","$total_tela");
?>
<tr>
	<td colspan=7 class=style1><b>Total a depositar: <a class=style1>R$ <?php print("$total_tela"); ?></a></b></td>
</tr>
<tr>
	<td colspan=7 height=30></td>
</tr>
<?php
	$total = 0;
	}
?>
<tr>
	<td colspan=7 height=10></td>
</tr>
<tr>
	<td colspan=7 class=style1><b>Banco: <a class=style1><?php print("$c_banco"); ?></a></b></td>
</tr>
<tr>
	<td colspan=7 height=10></td>
</tr>
<?php


 	}
		$i++;
?>
<?php
		$total = $co_valor + $total;
?>
<tr>
<td width="36" align="left" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><a href="p_edit_imoveis.php?cod=<?php print("$cod"); ?>&edit=editar" target="_blank" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><b><?php print("$data"); ?></b></a></td>
<td width="97" align="left" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Ref.: <a href="p_edit_imoveis.php?cod=<?php print("$cod"); ?>&edit=editar" target="_blank" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><b><?php print("$ref"); ?></b></a></td>
<td width="170" align="left" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Prop.: <a href="p_clientes.php?c_cod=<?php print("$c_cod"); ?>&lista=1" target="_blank" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><b><?php print("$cliente"); ?></b></a></td>
<td width="92" align="right" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Valor: <b><span class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">R$</a></b></td>
<td width="47" align="right" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><b><?php print("$valor_tela"); ?></b></td>
<td width="104" align="right" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><span class="style1">
<?php if($not0[co_status] == "ok"){ ?>
<span class="style17"><?php print("$data_status"); ?></span>
<input type="hidden" name="co_cod_<?=$i ?>" id="co_cod_<?=$i ?>" value="<?= $co_cod ?>">
<?php }else{ ?>
<input type="text" name="data_status_<?=$i ?>" id="data_status_<?=$i ?>" size="12" maxlenght="10" class="campo"  value="<?php print("$data_status"); ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_status_<?=$i ?>', '##/##/####', event);">
<input type="hidden" name="co_cod_<?=$i ?>" id="co_cod_<?=$i ?>" value="<?= $co_cod ?>">
<?php } ?>
</span></td>
<td width="202" align="left" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">
<?php

	if($not0[co_status] == "ok"){
?>
<b>OK</b>
<input type="submit" name="alterar_data_<?=$i ?>" id="alterar_data_<?=$i ?>" value="Alterar Data" class="campo" onClick="formData()">
<?php
	}
	else
	{
?>
<!--a href="#" onClick="if (confirm('Deseja Realmente confirmar esta conta?')) { window.location='<? print("$PHP_SELF"); ?>?acao=Confirmar&co_cod=<?php print("$co_cod"); ?>&c_banco1=<?php print("$c_banco1"); ?>&co_status=<?php print("$co_status"); ?>&dia2=<?php print("$dia2"); ?>&mes2=<?php print("$mes2"); ?>&ano2=<?php print("$ano2"); ?>&dia3=<?php print("$dia3"); ?>&mes3=<?php print("$mes3"); ?>&ano3=<?php print("$ano3"); ?>'; }" class="style17">Ok</a-->
<input type="submit" name="ok_<?=$i ?>" id="ok_<?=$i ?>" value="OK" class="campo" onClick="formConta()">
<?php
	}
?></td>
</tr>
<tr>
<td colspan=7 bgcolor="#<?php print("$cor1"); ?>" align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Conta: <b><?php print("$c_conta"); ?></b></td>
</tr>
<tr>
	<td colspan=7 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
</tr>
<tr>
	<td colspan=7 height=10></td>
</tr>
<?php
	}//while0
?>
<?php
	if($i > 0){
	$total_tela = number_format($total, 2, ',', '.');
	$total_tela = str_replace("-","","$total_tela");
?>
<input name="i" id="i" type="hidden" class="campo" value="<?= $i ?>">
<tr>
	<td colspan=7 class=style1><b>Total a depositar: <a class=style1>R$ <?php print("$total_tela"); ?></a></b></td>
</tr>
<tr>
	<td colspan=7 height=30></td>
</tr>
<?php
	$total = 0;
	$i = 0;
	}
?>
</table>
</td></tr></table>
<?php
/*
mysql_free_result($result1);
mysql_free_result($result2);
mysql_free_result($result3);
mysql_free_result($result4);
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
</form>
</html>