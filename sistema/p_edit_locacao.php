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
<p>
<?php
if($B1 == "Atualizar Locação")
	{
	
	$data_inicio = "$ano-$mes-$dia";
	$data_fim = "$ano1-$mes1-$dia1";
	$l_saldo = $l_total - ($l_desp + $l_comissao);

	$query = "update locacao set l_total='$l_total', 
	l_historico='$l_historico', l_desp='$l_desp', 
	l_pagto='$l_pagto', l_limpeza='$l_limpeza', l_data_ent='$data_inicio', 
	l_data_sai='$data_fim', l_comissao='$l_comissao', l_tv='$l_tv', l_saldo='$l_saldo' 
	where l_cod='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
?>
<p align="center"><font color="#ff0000" size="2" face="Arial">
Você atualizou a locação.</p>
<?php
	}
?>
<?php
	if($edit == "editar"){
	$query2 = "select * from locacao where l_cod = '$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{

if(!IsSet($editar))
	{
?>
<div align="center">
  <center>
  <table width="600" border="0" cellpadding="1" cellspacing="1" bgcolor="#EDEEEE">
  <tr bgcolor="#EDEEEE"><td colspan=2>
<p align="center" class=style1><b>Editar Locação</b></p></td></tr>
<?php
if(verificaFuncao("LOCA_EDIT")){
?>
  <form method="post" action="p_edit_locacao.php">
<?php
	}
?>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Imóvel:</b></td>
      <td width="80%" class=style1>
<?php

	$query4 = "select m.cod, m.ref, t.t_nome from muraski m inner join rebri_tipo t on (m.tipo=t.t_cod) where m.cod='$not2[l_imovel]' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	while($not4 = mysql_fetch_array($result4))
	{
	   $cod = $not4['cod'];
?>
<a target="_blank" href="detalhes.php?cod=<?php print("$not4[cod]"); ?>" class="style1">Ref.:<?php print("$not4[ref]"); ?></a> - <?php print("$not4[t_nome]"); ?>
<?php
	}
?>
</td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Locatário:</b></td>
      <td width="80%" class=style1>
<?php
	$query3 = "select c_nome from clientes where c_cod='$not2[l_cliente]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	$numrows3 = mysql_num_rows($result3);
	while($not3 = mysql_fetch_array($result3))
	{
?>
<?php print("$not3[c_nome]"); ?>
<?php
	}
?>
      </td>
    </tr>
<?php
	$ano = substr ($not2[l_data_ent], 0, 4);
	$mes = substr($not2[l_data_ent], 5, 2 );
	$dia = substr ($not2[l_data_ent], 8, 2 );
	
	$ano1 = substr ($not2[l_data_sai], 0, 4);
	$mes1 = substr($not2[l_data_sai], 5, 2 );
	$dia1 = substr ($not2[l_data_sai], 8, 2 );
	
	$ano2 = substr ($not2[l_data], 0, 4);
	$mes2 = substr($not2[l_data], 5, 2 );
	$dia2 = substr ($not2[l_data], 8, 2 );
?>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Período de:</b></td>
      <td width="80%" class=style1> 
      <input type="text" name="dia" value="<?php print("$dia"); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes" value="<?php print("$mes"); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano" value="<?php print("$ano"); ?>" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);"> <b>à</b> <input type="text" name="dia1" value="<?php print("$dia1"); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes1" value="<?php print("$mes1"); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano1"); ?>"> Ex.: 
    10/10/1910</td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Total:</b></td>
      <td width="80%" class=style1>R$  
      <input type="text" name="l_total" value="<?php print("$not2[l_total]"); ?>" size="10" class="campo"></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Histórico:</b></td>
      <td width="80%" class=style1> <textarea rows="5" class="campo" name="l_historico" cols="36"><?php print("$not2[l_historico]"); ?></textarea></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Despesas:</b></td>
      <td width="80%" class=style1>R$ <input type="text" class=campo size=10 name="l_desp" value="<?php print("$not2[l_desp]"); ?>"></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Pagamento:</b></td>
      <td width="80%" class=style1> <textarea rows="5" class="campo" name="l_pagto" cols="36"><?php print("$not2[l_pagto]"); ?></textarea></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Limpeza:</b></td>
      <td width="80%" class=style1>R$ <input type="text" class=campo size=10 name="l_limpeza" value="<?php print("$not2[l_limpeza]"); ?>"></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Comissão:</b></td>
      <td width="80%" class=style1>R$ <input type="text" class=campo size=10 name="l_comissao" value="<?php print("$not2[l_comissao]"); ?>"></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Saldo:</b></td>
      <td width="80%" class=style1>R$ <?php print("$not2[l_saldo]"); ?></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Data reserva:</b></td>
      <td width="80%" class=style1> <?php print("$dia2/$mes2/$ano2"); ?></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>TV:</b></td>
      <td width="80%" class=style1>R$ <input type="text" class=campo size=10 name="l_tv" value="<?php print("$not2[l_tv]"); ?>"></td>
    </tr>
<?php
if(verificaFuncao("LOCA_EDIT")){
?>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td width="20%">
      <input type="hidden" value="editar" name="edit">
      <input type="hidden" name="l_cod" value="<?php print("$not2[l_cod]"); ?>">
      <input type="submit" value="Atualizar Locação" class=campo3 name="B1"></td>
      <td width="80%" class=style1><b>Obs.: Alteração de valores nesta tela não será gravada no sistema de contas.</td>
    </tr>
<?php
	}
?>
    <tr><td colspan="2">
                  <p align="center">
                  <a href="p_rel_loc.php?cod=<?=$cod?>" class="style1">Relatório de Locações</a></p></td></tr>
</table>
  </form>
  <br>
<?php
	}
	}
	}
//mysql_free_result($result0);
//mysql_free_result($result2);
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