<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("PESQ_ATEND_CLI");
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
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/
?>
<div align="center">
  <center>
  <form method="get" action="p_clientes.php">
  <table width="75%" border="0" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td height="50" width="100%" colspan=2><p align="center" class="style1"><b>Cadastros</b><br>
 Preencha a palavra chave OU data e selecione o campo de pesquisa</p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Palavra Chave:</b></td>
      <td width="70%" class="style1"> <input type="text" class="campo" name="c_nome" id="c_nome" size="40"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Data:</b></td>
      <td width="70%" class="style1">
      <input type="text" name="dia" id="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes" id="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano" id="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print($ano); ?>"> <b>à</b> <input type="text" name="dia1" id="dia1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes1" id="mes1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano1" id="ano1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print($ano); ?>"><br>Ex.: 10/10/1910 à 20/10/1910</td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Campo de pesquisa:</b></td>
      <td width="70%" class="style1"> <select name="campo" id="campo" class="campo">
	  <option value="c_nome">Nome do cliente</option>
      <option value="c_tipo">Tipo de cadastro</option>
      <option value="c_cpf">CPF</option>
      <option value="c_rg">RG</option>
      <option value="c_end">Endereço do cliente</option>
      <option value="c_cidade">Cidade</option>
      <option value="c_email">E-mail</option>
      <option value="c_tel">Telefone</option>
      <option value="c_civil">Estado Civil</option>
      <option value="c_obs">Texto da Obs</option>
      <option value="c_nasc">Data de nascimento</option>
      <option value="c_desde">Data do cadastro</option>
      <!--option value="c_ref">Referência do Imóvel</option-->
      </select></td>
    </tr>
    <tr>
      <td width="100%" colspan=2>
      <input type="hidden" value="1" name="list">
      <input type="hidden" value="" name="lista">
      <input type="submit" value="Pesquisar Cadastros" name="B1" class=campo3></td>
    </tr>
  </table>
  </form>
<p>
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
<script language="javascript">
function VerificaCampo(){
	
var msgErro = '';

	   	if(document.form2.dia2.value!='' && document.form2.mes2.value!='' && document.form2.ano2.value!='' && document.form2.dia3.value!='' && document.form2.mes3.value!='' && document.form2.ano3.value!='')
	   	{
	     	if(document.form2.data_tipo.selectedIndex == 0)
  			{
    			msgErro += "Por favor, selecione o campo Tipo de data.\n"; 
  			}
	   	}
       	if(msgErro != '')
	   	{
	        alert(msgErro);
	        return false;
	   	}
	   	else
	   	{
            document.form2.submit();
	   	}
}
</script>
<div align="center">
  <center>
  <form method="get" action="p_int.php" name="form2">
  <table width="75%" border="0" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
    <tr height="50" bgcolor="#<?php print("$cor1"); ?>">
      <td width="100%" colspan=2><p align="center" class="style1"><b>Atendimentos</b><br>
  Preencha a palavra chave e selecione o campo de pesquisa</p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Palavra Chave:</b></td>
      <td width="70%" class="style1"> <input type="text" class="campo" name="i_nome" size="40"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Campo de pesquisa:</b></td>
      <td width="70%" class="style1"> <select name="campo" class="campo">
      <option value="i_nome">Nome</option>
      <option value="i_obs">Texto da Obs</option>
      <option value="i_tel">Telefone</option>
      <option value="i_status">Status do Atendimento</option>
      <option value="u_email">Corretor</option>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Data:</b></td>
      <td width="70%" class="style1">
      <input type="text" name="dia2" id="dia2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes2" id="mes2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano2" id="ano2" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);"> <b>à</b> <input type="text" name="dia3" id="mes3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes3" id="mes3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano3" id="ano3" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);"><br>Ex.: 10/10/1910 à 20/10/1910</td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Tipo de data:</b></td>
      <td width="70%" class="style1"> <select name="data_tipo" id="data_tipo" class="campo">
      <option value="">Selecione</option>
      <option value="i_data">Data do cadastro</option>
      <option value="i_data_status">Data do <!--último--> atendimento</option>
      </select></td>
    </tr>
    <tr>
      <td width="100%" colspan=2>
      <input type="hidden" value="1" name="list">
      <input type="hidden" value="" name="lista">
      <input type="button" value="Pesquisar Atendimentos" name="B1" class=campo3 Onclick="VerificaCampo();"></td>
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