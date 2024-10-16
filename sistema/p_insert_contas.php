<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("CONTA_GERAL");
?>
<html>
<head>
<?php
include("style.php");
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
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/	  
?>
 <p align="center" class="style1"><b>Inserir Contas</b><br>
 <a href="p_pesq_contas.php" class="style1">
 Clique para visualizar a relação de contas</a></p>
<?php

if($B1 == "Inserir Conta")
	{
	
	//$c_nome = AddSlashes($c_nome);
	$co_data = "$ano1-$mes1-$dia1";
	
	if(($co_tipo == "") and ($novo_tipo != "")){
		
	$query0 = "select t_nome from tipo_contas where t_nome='$novo_tipo' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	if($numrows0 == 0){
		
	$query1 = "insert into tipo_contas (cod_imobiliaria, t_nome) values('".$_SESSION['cod_imobiliaria']."','$novo_tipo')";
	$result1 = mysql_query($query1) or die("Não foi possível inserir suas informações.(tipo contas)");
	
	}
	
	$co_tipo = $novo_tipo;
	
	}

	for ($j = 1; $j <= $qtd_parc; $j++) {
		if($co_cat == "Pagar"){
			$parc[$j] = -$parc[$j];
		}
		elseif($co_cat == "Receber"){
			$parc[$j] = $parc[$j];
		}
	$query = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
			, co_locacao, co_usuario) 
			values('".$_SESSION['cod_imobiliaria']."','$co_cliente', '$co_cat', '$co_imovel', '$co_desc', '$co_tipo', '$ano_parc[$j]-$mes_parc[$j]-$dia_parc[$j]'
			, '$co_status', '$parc[$j]', '$l_cod', '$co_usuario')";
	$result = mysql_query($query) or die("Não foi possível inserir suas informações.");
	}
?>
<p align="center" class="style1">
Você inseriu uma nova conta.</p>
<?php
//mysql_free_result($result);
	}
?>
 <div align="center">
  <center>
<?php
	if(!IsSet($inserir1))
	{
?>
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
<table width=600 cellpadding="1" cellspacing="1">
<form method="get" action="<?php print("$PHP_SELF"); ?>" name="form1">
    <tr>
      <td colspan=2 class=style1>Preencha a quantidade de parcelas da conta para depois preencher os dados:</b></td>
    </tr>
    <tr>
      <td width="20%" class=style1><b>Qtd. de parcelas:</b></td>
      <td width="80%" class=style1> <input type="text" name="qtd_parc" value="<?php print("$qtd_parc"); ?>" size="2" class="campo"></td>
    </tr>
    <tr>
      <td width="20%">
      <input type="submit" value="Alterar Quantidade" name="B1" class=campo3></td>
      <td width="80%"></td>
    </tr>
</table>
  </form>
<?php
	if($qtd_parc >= 1){
?>
  <form method="post" name="formulario" action="<?php print("$PHP_SELF"); ?>">
  <input type="hidden" name="qtd_parc" value="<?php print("$qtd_parc"); ?>">
  <table width="600" border="0" cellpadding="1" cellspacing="1">
    <tr>
      <td width="20%" class=style1><b>Qtd. de parcelas:</b></td>
      <td width="80%" class=style1><b><?php print("$qtd_parc"); ?></b></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Cliente:</b></td>
      <td width="80%"> <input type="text" name="co_cliente" size="4" class="campo2" readonly> <input type="text" name="nome_cliente" size="40" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo3" onClick="window.open('p_list_clientes.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');" class="style1"></td>
    </tr>
    <tr>
      <td width="20%" class=style1><b>Categoria:</b></td>
      <td width="80%" class=style1> <select size="1" name="co_cat" class="campo">
    <option selected value="Receber">Receber</option>
    <option value="Pagar">Pagar</option>
        </select></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Imóvel:</b></td>
      <td width="80%"> <input type="text" name="co_imovel" size="4" class="campo2" readonly> <input type="text" name="nome_imovel" size="40" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo3" onClick="window.open('p_list_imoveis.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');" class="style1"></td>
    </tr>
    <tr>
      <td width="20%" class=style1><b>Descrição:</b></td>
      <td width="80%" class=style1> <input type="text" name="co_desc" size="40" value="" class="campo"></td>
    </tr>
    <tr>
      <td width="20%" class=style1><b>Tipo:</b></td>
      <td width="80%" class=style1> <select name="co_tipo" class="campo">
        <option selected value="">Novo tipo</option>
<?php
	$query3 = "select * from tipo_contas where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by t_nome";
	$result3 = mysql_query($query3);
	$numrows3 = mysql_num_rows($result3);
	if($numrows3 > 0){
	while($not3 = mysql_fetch_array($result3))
	{
?>
    <option value="<?php print("$not3[t_nome]"); ?>"><?php print("$not3[t_nome]"); ?></option>
<?php
	}
	}
?>
  </select> <input type="text" name="novo_tipo" size="20" class="campo"> <a href="javascript:;" onClick="MM_openBrWindow('p_exc_tipo_contas.php','','scrollbars=yes,resizable=no,width=400,height=200')" class=style1>Excluir Tipo</a></td>
    </tr>
<?php	
	if($B1 == "Atualizar Valores"){
	
	$valor = str_replace(".", "", $valor);
	$valor = str_replace(",", ".", $valor);
	$total_parc = 0;

	$total = $total_dias * $valor;
	$total_contas = $total_dias * $valor;
	
	}
	else
	{
	$valor = $not1[valor];

	if(!$qtd_parc){
		$qtd_parc = 1;
	}
		
	}
	
	$valor_parc = $total / $qtd_parc;
		
	$valor = number_format($valor, 2, ',', '.');
	//$valor_parc = number_format($valor_parc, 2, ',', '.');
	$total = number_format($total, 2, ',', '.');
	
?>
<?php
	for ($j = 1; $j <= $qtd_parc; $j++) {
	if(!$parc[$j]){
		$parc[$j] = $valor_parc;
	}
		$total_parc = $parc[$j] + $total_parc;
?>
    <tr>
      <td colspan=2><table>
      	<tr>
      		<td class=style1>Parcela <?php print("$j"); ?>:  R$ <input type="text" name="parc[<?php print("$j"); ?>]" value="<?php print("$parc[$j]"); ?>" size="10" class="campo"> Data: <input type="text" name="dia_parc[<?php print("$j"); ?>]" size="2" class="campo" value="<?php print("$dia_parc[$j]"); ?>" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes_parc[<?php print("$j"); ?>]" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes_parc[$j]"); ?>">/<input type="text" name="ano_parc[<?php print("$j"); ?>]" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano_parc[$j]"); ?>"> <b>OBS.: Preenchimento Obrigatório.</b></td>
    </tr></table></td>
  </tr>
<?php
	}
?>
    <tr>
      <td width="20%" class=style1><b>Status:</b></td>
      <td width="80%" class=style1> <select size="1" name="co_status" class="campo">
    <option selected value="ok">ok</option>
    <option value="Pendente">Pendente</option>
        </select></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Usuário:</b></td>
      <td width="80%" class=style1> <select size="1" name="co_usuario" class=campo>
<?php
	if($valid_user == ""){
	$co_usuario = "Selecione um usuário";
	}else{
	$co_usuario = $valid_user;
	}
?>
    <option selected value="<?php print("$co_usuario"); ?>"><?php print("$co_usuario"); ?></option>
<?php
	$query0 = "select * from usuarios where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by u_email";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	if($numrows0 > 0){
	while($not0 = mysql_fetch_array($result0))
	{
?>
<option value="<?php print("$not0[u_email]"); ?>"><?php print("$not0[u_email]"); ?></option>
<?php
	}
	}
?>
        </select></td>
    </tr>
    <tr>
      <td width="20%">
      <input type="hidden" value="1" name="inserir2">
      <input type="submit" value="Inserir Conta" name="B1" class=campo3></td>
      <td width="80%"></td>
    </tr>
  </table>
  </form>
<?php
	}//termina if qtd_parc
?>
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
<table width="900" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
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