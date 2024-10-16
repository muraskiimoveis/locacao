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
	(($_SESSION['u_tipo'] == "admin"))){
*/		
?>
<script>
function valida()
{
  if (formulario.dia2.value == "")
  {
    alert("Por favor, digite o Dia de Entrada");
    formulario.dia2.focus();
    return (false);
  }
  if (formulario.mes2.value == "")
  {
    alert("Por favor, digite o Mês de Entrada");
    formulario.mes2.focus();
    return (false);
  }
  if (formulario.ano2.value == "")
  {
    alert("Por favor, digite o Ano de Entrada");
    formulario.ano2.focus();
    return (false);
  }
  if (formulario.dia3.value == "")
  {
    alert("Por favor, digite o Dia de Saída");
    formulario.dia3.focus();
    return (false);
  }
  if (formulario.mes3.value == "")
  {
    alert("Por favor, digite o Mês de Saída");
    formulario.mes3.focus();
    return (false);
  }
  if (formulario.ano3.value == "")
  {
    alert("Por favor, digite o Ano de Saída");
    formulario.ano3.focus();
    return (false);
  }
  
  var data1 = formulario.ano2.value + formulario.mes2.value + formulario.dia2.value;
  var data2 = formulario.ano3.value + formulario.mes3.value + formulario.dia3.value;	
  if (data2 < data1) {
	alert("Data inicial deve ser menor que data final.");
	formulario.dia.focus();
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
	$ano = date(Y);
?>
<p>
<div align="center">
  <center>
  <form method="get" action="p_lista_contas.php" name="formulario" onSubmit="return valida();">
  <table width="500" border="0" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td width="100%" colspan=2 class=style1><p align="center"><b>Pesquisa de Contas</b><br>
 Preencha os campos do seu interesse e clique em pesquisar.</p></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Período:</b></td>
      <td width="80%" class=style1> 
      <input type="text" name="dia2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano2" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"> <b>à</b> 
      <input type="text" name="dia3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano3" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"><br>Ex.: 
    10/10/1910 à 20/10/1910</td>
    </tr>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td width="100%" colspan=2 class=style1><p align="center">Escolha um dos campos abaixo para filtrar sua pesquisa ou então digite apenas um período de datas para fazer uma pesquisa geral das contas.</td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Cliente:</b></td>
      <td width="80%" class="style1"> <input type="text" name="co_cliente" size="4" class="campo2" readonly> <input type="text" name="nome_cliente" size="40" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo3" onClick="window.open('p_list_clientes.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Imóvel:</b></td>
      <td width="80%" class="style1"> <input type="text" name="co_imovel" size="4" class="campo2" readonly> <input type="text" name="nome_imovel" size="40" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo3" onClick="window.open('p_list_imoveis.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Status:</b></td>
      <td width="80%" class="style1"><select name=co_status class=campo>
      <option value="%%">Selecione um status
      <option value="ok">ok
      <option value="pendente">pendente
      </select></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Usuário:</b></td>
      <td width="80%" class=style1> <select name="co_usuario" class=campo>
<?php
	if($valid_user == ""){
	$co_usuario = "Selecione um usuário";
	}else{
	$co_usuario = $valid_user;
	}
?>
    <option selected value="%%">Selecione um usuário</option>
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
    <tr bgcolor="#<?php print("$cor1"); ?>">
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