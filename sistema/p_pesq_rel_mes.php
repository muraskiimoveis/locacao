<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_LOCA");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
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
<script language="javascript">
function valida()
{
  if (document.form1.dia2.value == "")
  {
    alert("Por favor, digite o Dia de Entrada");
    document.form1.dia2.focus();
    return (false);
  }
  if (document.form1.mes2.value == "")
  {
    alert("Por favor, digite o Mês de Entrada");
    document.form1.mes2.focus();
    return (false);
  }
  if (document.form1.ano2.value == "")
  {
    alert("Por favor, digite o Ano de Entrada");
    document.form1.ano2.focus();
    return (false);
  }
  if (document.form1.dia3.value == "")
  {
    alert("Por favor, digite o Dia de Saída");
    document.form1.dia3.focus();
    return (false);
  }
  if (document.form1.mes3.value == "")
  {
    alert("Por favor, digite o Mês de Saída");
    document.form1.mes3.focus();
    return (false);
  }
  if (document.form1.ano3.value == "")
  {
    alert("Por favor, digite o Ano de Saída");
    document.form1.ano3.focus();
    return (false);
  }
  
  var data1 = document.form1.ano2.value + document.form1.mes2.value + document.form1.dia2.value;
  var data2 = document.form1.ano3.value + document.form1.mes3.value + document.form1.dia3.value;	
  if (data2 < data1) {
	alert("Data inicial deve ser menor que data final.");
	document.form1.dia.focus();
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
	//$ano = date(Y);
?>
<div align="center">
  <center>
  <form method="get" action="p_lista_relloc_mes.php" name="form1" onSubmit="return valida();">
  <table width="75%" border="0" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td width="100%" colspan=2 class="style1"><p align="center"><b>Relatórios de Locações <!--Mensais-->Anuais</b><br>
 Preencha os campos do seu interesse e clique em pesquisar.</font></p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Período:</b></td>
      <td width="80%" class="style1">
      <input type="text" name="dia2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/
      <input type="text" name="mes2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/
      <input type="text" name="ano2" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"> <b>à</b> 
      <input type="text" name="dia3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/
      <input type="text" name="mes3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/
      <input type="text" name="ano3" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"><br>Ex.: 
    10/10/1910 à 20/10/1910</td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Campo de pesquisa:</b></td>
      <td width="80%" class="style1"><select name=campo class=campo>
      <option value="locado">Período de utilização
      <option value="reserva">Data da reserva
      </select></td>
    </tr>
	<tr class="fundoTabela">
      <td width="20%" class="style1"><b>Usuário:</b></td>
      <td width="80%" class="style1"><select name="pusuarios" class=campo>
	    <option value="">Selecione</option>
		 <?
            $busuarios = mysql_query("SELECT * FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND u_status='Ativo' ORDER BY u_email ASC");
 			while($linha = mysql_fetch_array($busuarios)){
					echo('<option value="'.$linha[u_cod].'">'.$linha[u_nome].' - '.$linha[u_email].'</option>');
 			}
		?>
        </select>
    <tr>
      <td width="100%" colspan=2>
      <input type="hidden" value="1" name="list">
      <input type="hidden" value="" name="lista">
      <input type="submit" value="Pesquisar" name="B1" class=campo3></td>
    </tr>
  </table>
  </form>
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