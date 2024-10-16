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

	if($edit == "editar"){
	$query2 = "select * from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{

if(!IsSet($editar))
	{
?>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="600" bgcolor="#DCE0E4">
  <tr bgcolor="#DCE0E4"><td colspan=2>
<p align="center"><font color="#000080" size="2" face="Arial"><b>Editar ou Apagar Imóvel</b></font></p></td></tr>
  <form method="post" action="p_imoveis.php">
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Proprietário:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <select size="1" name="cliente">
<?php
	if($not2[cliente] == ""){
?>
<option selected value="">Selecione o proprietário</option>
<?php
	}
	$query0 = "select c_cod, c_nome from clientes 
	where c_tipo='proprietario' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c_nome, c_cod";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	if($numrows0 > 0){
	while($not0 = mysql_fetch_array($result0))
	{
	if($not2[cliente] == $not0[c_cod]){
	$cliente = $not0[c_cod];
	
	$cadastrado = 1;
?>
<option selected value="<?php print("$not0[c_cod]"); ?>"><?php print("$not0[c_nome]"); ?></option>
<?php
	}
?>
<option value="<?php print("$not0[c_cod]"); ?>"><?php print("$not0[c_nome]"); ?></option>
<?php
	}
	}
?>
        </select></font></td>
    </tr>
<?php
	$ano = substr ($not2[data_inicio], 0, 4);
	$mes = substr($not2[data_inicio], 5, 2 );
	$dia = substr ($not2[data_inicio], 8, 2 );
	
	$ano1 = substr ($not2[data_fim], 0, 4);
	$mes1 = substr($not2[data_fim], 5, 2 );
	$dia1 = substr ($not2[data_fim], 8, 2 );
?>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Contrato de:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> 
      <input type="text" name="dia" value="<?php print("$dia"); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);"><font size="2">/</font><input type="text" name="mes" value="<?php print("$mes"); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);"><font size="2">/</font><input type="text" name="ano" value="<?php print("$ano"); ?>" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);"> <b>à</b> <input type="text" name="dia1" value="<?php print("$dia1"); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);"><font size="2">/</font><input type="text" name="mes1" value="<?php print("$mes1"); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);"><font size="2">/</font><input type="text" name="ano1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano1"); ?>"><i><font size="1">Ex.: 
    10/10/1910</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Dias úteis:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> 
      <input type="text" name="dias" value="<?php print("$not2[dias]"); ?>" size="2" class="campo"<font size="1">Obs.: Apenas para imóveis à venda.</font></td>
    </tr>
<?php
	if($not2[finalidade] == "Locação"){
?>
<?php
	if($cadastrado == 1){
	//$imovel = substr ($not2[ref], 0, 4);
	$imovel = "ref" . $not2[ref];
?>
<script language="JavaScript"> 
function <?php print("$imovel"); ?>()
{
window.open("p_imp_doc.php?cod=<?php print("$not2[cod]"); ?>&imp=2","1",'toolbar=yes,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=0,width=800,height=400');
}
</script>
    <tr bgcolor="#DCE0E4"><td colspan=2>
    <p align="left"><b><a href="javascript:<?php print("$imovel"); ?>();">
    <font color="#000080" size="2" face="Arial">Imprimir Contrato</a></b></font></p></td></tr>
<?php
	}
?>
	<tr bgcolor="#DCE0E4"><td colspan=2>
    <p align="left"><b><a href="p_rel_loc.php?cod=<?php print("$not2[cod]"); ?>">
    <font color="#000080" size="2" face="Arial">Visualizar Relatório de Locações</a></b></font></p></td></tr>
<?php
	}
	else
	{
?>
<?php
	if($cadastrado == 1){
	//$imovel = substr ($not2[ref], 0, 4);
	$imovel1 = "ref1" . $not2[ref];
	$imovel3 = "ref3" . $not2[ref];
?>
<script language="JavaScript"> 
function <?php print("$imovel1"); ?>()
{
window.open("p_imp_doc.php?cod=<?php print("$not2[cod]"); ?>&imp=5","1",'toolbar=yes,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=0,width=800,height=400');
}
</script>
<script language="JavaScript"> 
function <?php print("$imovel3"); ?>()
{
window.open("p_imp_doc.php?cod=<?php print("$not2[cod]"); ?>&imp=4","1",'toolbar=yes,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=0,width=800,height=400');
}
</script>
    <tr bgcolor="#DCE0E4"><td colspan=2>
    <p align="left"><b><a href="javascript:<?php print("$imovel1"); ?>();">
    <font color="#000080" size="2" face="Arial">Imprimir Contrato</a></b></font></p></td></tr>
    <tr bgcolor="#DCE0E4"><td colspan=2>
    <p align="left"><b><a href="javascript:<?php print("$imovel3"); ?>();">
    <font color="#000080" size="2" face="Arial">Imprimir Renovação</a></b></font></p></td></tr>
<?php
	}
	$imovel2 = "ref2" . $not2[ref];
?>
<script language="JavaScript"> 
function <?php print("$imovel2"); ?>()
{
window.open("p_imp_doc.php?cod=<?php print("$not2[cod]"); ?>&imp=7","1",'toolbar=yes,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=0,width=800,height=400');
}
</script>
	<tr bgcolor="#DCE0E4"><td colspan=2>
    <p align="left"><b><a href="p_rel_int.php?cod=<?php print("$not2[cod]"); ?>">
    <font color="#000080" size="2" face="Arial">Visualizar Relatório de Interessados</a></b></font></p></td></tr>
	<tr bgcolor="#DCE0E4"><td colspan=2>
    <p align="left"><b><a href="javascript:<?php print("$imovel2"); ?>();">
    <font color="#000080" size="2" face="Arial">Fazer proposta de Compra</a></b></font></p></td></tr>
<?php
	}
?>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Tipo:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <select name="tipo1">
      <option selected><?php print("$not2[tipo]"); ?>
    <option>Apartamento</option>
    <option>Cobertura</option>
    <option>Comercial</option>
    <option>Residência</option>
    <option>Sobrado</option>
    <option>Terreno</option>
      </select></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Referência:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <input type="text" class="campo" name="ref" size="10" value="<?php print("$not2[ref]"); ?>"></font></td>
    </tr>
   <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Título:</b> </font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <textarea rows="2" class="campo" name="titulo" cols="36"><?php
      $not2[titulo] = stripslashes($not2[titulo]);
      print("$not2[titulo]");
      ?></textarea></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Descrição:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <textarea rows="5" class="campo" name="descricao" cols="36"><?php
      $not2[descricao] = stripslashes($not2[descricao]);
      print("$not2[descricao]");
      ?></textarea></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Metragem:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <input type="text" class="campo" name="metragem" size="10" value="<?php print("$not2[metragem]"); ?>">Exemplo:
        100.00 ou 100</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>N° de
        quartos:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="n_quartos" size="5" value="<?php print("$not2[n_quartos]"); ?>">Exemplo:
        1</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Valor/Diária:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="valor" size="10" value="<?php print("$not2[valor]"); ?>">Exemplo:
        50000.00 ou 50000</font></td>
    </tr>
    <tr>
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Valor Carnaval:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="carnaval" size="10" class="campo" value="<?php print("$not2[carnaval]"); ?>">Exemplo:
        50000.00 ou 50000</font></td>
    </tr>
    <tr>
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Valor Ano Novo:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="anonovo" size="10" class="campo" value="<?php print("$not2[anonovo]"); ?>">Exemplo:
        50000.00 ou 50000</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Diária mínima/Diária máxima:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="diaria1" size="10" class="campo" value="<?php print("$not2[diaria1]"); ?>">/<input type="text" name="diaria2" size="10" class="campo" value="<?php print("$not2[diaria2]"); ?>">Exemplo:
        50000.00 ou 50000</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Taxa Limpeza:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="limpeza" size="10" class="campo" value="<?php print("$not2[limpeza]"); ?>">Exemplo:
        50.00 ou 50</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Especificação:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><select size="1" class="campo" name="especificacao">
    <option selected><?php print("$not2[especificacao]"); ?></option>
    <option>Lançamento</option>
    <option>Novo</option>
    <option>Usado</option>
        </select></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Suítes:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="suites" size="5" value="<?php print("$not2[suites]"); ?>">Exemplo:
        1</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Piscina:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><select size="1" class="campo" name="piscina">
    <option selected><?php print("$not2[piscina]"); ?></option>
    <option>Não</option>
    <option>Sim</option>
        </select></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Permuta:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><select size="1" class="campo" name="permuta">
    <option selected><?php print("$not2[permuta]"); ?></option>
    <option>Sim</option>
    <option>Não</option>
        </select></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>*Texto da Permuta:</b></font><br>
      <font color="#000080" size="1" face="Arial">
      *<i>Preencha esse campo apenas se você escolheu a opção "Sim" no campo Permuta.</i></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <textarea rows="3" class="campo" name="permuta_txt" cols="36"><?php
      $not2[permuta_txt] = stripslashes($not2[permuta_txt]);
      print("$not2[permuta_txt]");
      ?></textarea></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Localização:</b></font></td>
      <td width="80%"><input type="text" name="local" class="campo" size="30" value="<?php print("$not2[local]"); ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Finalidade do Imóvel:</b></font></td>
      <td width="80%"><select size="1" name="finalidade" class="campo">
    <option selected><?php print("$not2[finalidade]"); ?></option>
    <option>Venda</option>
    <option>Locação</option>
        </select></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Matrícula:</b></font></td>
      <td width="80%"><input type="text" name="matricula" size="30" class="campo" value="<?php print("$not2[matricula]"); ?>">
    </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Cidade Mat.:</b></font></td>
      <td width="80%"><select size="1" name="cidade_mat" class="campo">
      <option selected><?php print("$not2[cidade_mat]"); ?></option>
    <option>Guaratuba</option>
    <option>São José dos Pinhais</option>
        </select></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Endereço:</b></font></td>
      <td width="80%"><input type="text" name="end" size="40" class="campo" value="<?php print("$not2[end]"); ?>">
    </td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Averbação:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="averbacao" size="10" class="campo" value="<?php print("$not2[averbacao]"); ?>">Exemplo:
        100.00 ou 100</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Acomodações:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="acomod" size="2" class="campo" value="<?php print("$not2[acomod]"); ?>">Exemplo:
        1 ou 10</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Comissão:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" name="comissao" size="2" class="campo" value="<?php print("$not2[comissao]"); ?>">Exemplo:
        15</font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Distância do mar:</b></font></td>
      <td width="80%"><input type="text" name="dist_mar" size="4" class="campo" value="<?php print("$not2[dist_mar]"); ?>"><select size="1" name="dist_tipo" class="campo">
    <option selected><?php print("$not2[dist_tipo]"); ?></option>
    <option>metros</option>
    <option>quadras</option>
        </select></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 1:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_1" size="30" value="<?php
      $not2[ftxt_1] = stripslashes($not2[ftxt_1]);
      print("$not2[ftxt_1]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 2:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_2" size="30" value="<?php
      $not2[ftxt_2] = stripslashes($not2[ftxt_2]);
      print("$not2[ftxt_2]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 3:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_3" size="30" value="<?php
      $not2[ftxt_3] = stripslashes($not2[ftxt_3]);
      print("$not2[ftxt_3]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 4:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_4" size="30" value="<?php
      $not2[ftxt_4] = stripslashes($not2[ftxt_4]);
      print("$not2[ftxt_4]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 5:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_5" size="30" value="<?php
      $not2[ftxt_5] = stripslashes($not2[ftxt_5]);
      print("$not2[ftxt_5]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 6:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_6" size="30" value="<?php
      $not2[ftxt_6] = stripslashes($not2[ftxt_6]);
      print("$not2[ftxt_6]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 7:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_7" size="30" value="<?php
      $not2[ftxt_7] = stripslashes($not2[ftxt_7]);
      print("$not2[ftxt_7]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 8:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_8" size="30" value="<?php
      $not2[ftxt_8] = stripslashes($not2[ftxt_8]);
      print("$not2[ftxt_8]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 9:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_9" size="30" value="<?php
      $not2[ftxt_9] = stripslashes($not2[ftxt_9]);
      print("$not2[ftxt_9]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 10:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_10" size="30" value="<?php
      $not2[ftxt_10] = stripslashes($not2[ftxt_10]);
      print("$not2[ftxt_10]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 11:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_11" size="30" value="<?php
      $not2[ftxt_11] = stripslashes($not2[ftxt_11]);
      print("$not2[ftxt_11]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 12:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_12" size="30" value="<?php
      $not2[ftxt_12] = stripslashes($not2[ftxt_12]);
      print("$not2[ftxt_12]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 13:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_13" size="30" value="<?php
      $not2[ftxt_13] = stripslashes($not2[ftxt_13]);
      print("$not2[ftxt_13]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 14:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_14" size="30" value="<?php
      $not2[ftxt_14] = stripslashes($not2[ftxt_14]);
      print("$not2[ftxt_14]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 15:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_15" size="30" value="<?php
      $not2[ftxt_15] = stripslashes($not2[ftxt_15]);
      print("$not2[ftxt_15]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 16:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_16" size="30" value="<?php
      $not2[ftxt_16] = stripslashes($not2[ftxt_16]);
      print("$not2[ftxt_16]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 17:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_17" size="30" value="<?php
      $not2[ftxt_17] = stripslashes($not2[ftxt_17]);
      print("$not2[ftxt_17]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 18:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_18" size="30" value="<?php
      $not2[ftxt_18] = stripslashes($not2[ftxt_18]);
      print("$not2[ftxt_18]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 19:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_19" size="30" value="<?php
      $not2[ftxt_19] = stripslashes($not2[ftxt_19]);
      print("$not2[ftxt_19]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Texto da foto 20:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"><input type="text" class="campo" name="ftxt_20" size="30" value="<?php
      $not2[ftxt_20] = stripslashes($not2[ftxt_20]);
      print("$not2[ftxt_20]");
      ?>"></font></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td width="20%"><font color="#035E01" size="2" face="Arial">
      <input type="hidden" value="1" name="editar">
      <input type="hidden" name="cod" value="<?php print("$not2[cod]"); ?>">
      <input type="submit" value="Atualizar Imóvel" class=campo name="B1"></font></td>
      <td width="80%"><input type="submit" value="Apagar Imóvel" class=campo name="B1">&nbsp;<input type="submit" value="Apagar Definitivamente" name="B1" class=campo2></td>
    </tr>
    <tr><td colspan="2"><font face="Arial" size="2" color="#000080">
                  <p align="center">
                  <a href="javascript:history.back()"><< Voltar <<</a></font></p></td></tr>
  </table>
  </form>
  <br>
<?php
	}
	}
	}
/*	
mysql_free_result($result0);
mysql_free_result($result2);
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
<!--Área protegida!-->
<?php
//	}
?>
</body>
</html>