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
?>
</head>
<?php
include("conect.php");
include("l_funcoes.php");

?>
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
<p>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
		
	if(!$from){
		$from = intval($screen * 30);
	}

	if($alterar == 1){
	if($bot == "Apagar"){
		if(($valid_user == "muraski@muraski.com") or ($valid_user == "paulo@bruc.com.br")){
	$query4= "delete from depositos where d_cod='$d_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível apagar suas informações.");
		}
	}
	elseif($bot == "Atualizar"){
	//$l_comissao = str_replace(".", "", $l_comissao);
	//$l_comissao = str_replace(",", ".", $l_comissao);
	$query4= "update depositos set d_desc='$d_desc', d_valor='$d_valor', d_data='$ano-$mes-$dia' where d_cod='$d_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	//echo $query4;
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	}
	elseif($bot == "Inserir"){
	//$l_comissao = str_replace(".", "", $l_comissao);
	//$l_comissao = str_replace(",", ".", $l_comissao);
	$query4= "insert into depositos (cod_imobiliaria, d_loc, d_desc, d_valor, 
	d_data, d_imovel) 
	values('".$_SESSION['cod_imobiliaria']."','$l_cod', '$d_desc', '$d_valor', '$ano-$mes-$dia', '$cod')";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	}

	}

if($lista == "1")
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
<div align="center">
  <center>
<table bgcolor="#DCE0E4" border="0" cellspacing="1">
<?php
	$query3 = "SELECT * FROM muraski WHERE cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);

	while($not3 = mysql_fetch_array($result3))
	{
?>
<tr><td bgcolor="#EDEEEE" colspan=4><font color="#000000" size="2" face="Arial">
<p align="left"><b>Relatório de Depósitos do imóvel <a href=p_edit_imoveis.php?cod=<?php print("$cod"); ?>&edit=editar>Ref.: <?php print("$not3[ref]"); ?></a></p>
</td></tr>
<?php
	$query6 = "SELECT * FROM depositos WHERE d_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by d_imovel desc limit 1";
	//echo $query6;
	$result6 = mysql_query($query6);

	while($not6 = mysql_fetch_array($result6))
	{
		$saldo_anterior = $not6[d_saldo];
		$saldo_anterior = number_format($saldo_anterior, 2, ',', '.');
?>
<tr><td bgcolor="#EDEEEE" colspan=4><font color="#ff0000" size="2" face="Arial">
<p align="center"><b>Saldo anterior: <?php print("$saldo_anterior"); ?></a></p>
</td></tr>
<?php
	}//termina saldo anterior
?>
<?php
	}

	$query1 = "select * from locacao where l_cod='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
	while($not1 = mysql_fetch_array($result1))
	{
		$saldo_total = $not1[l_saldo];
		$saldo = number_format($saldo_total, 2, ',', '.');
?>
<tr><td bgcolor="#EDEEEE" colspan=4><font color="#000000" size="2" face="Arial">
<p align="left"><b>Saldo Total: R$ <?php print("$saldo_total"); ?></p>
</td></tr>
<?php
	}
	}

	$query2 = "select * from depositos where d_loc='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
?>
<tr><td bgcolor="#ffffff" colspan=7>
<p align="center">
<font color="#ff0000" size="1" face="Arial">
Para alterar ou excluir um depósito, clique nos botões.</b>
</td></tr>
<tr>
<td width=50 bgcolor="#EDEEEE"><font color="#000000" size="2" face="Arial"><b>
<p align="center">Data</td>
<td width=250 bgcolor="#EDEEEE"><font color="#000000" size="2" face="Arial"><b>
<p align="center">Descrição</td>
<td width=50 bgcolor="#EDEEEE"><font color="#000000" size="2" face="Arial"><b>
<p align="center">Depósito</td>
<td width=50 bgcolor="#EDEEEE"><font color="#ff0000" size="2" face="Arial"><b>
<p align="center">Saldo</td>
</tr><tr>
<td width=50 bgcolor="#96b5c9"></td>
<td width=50 bgcolor="#96b5c9"></td>
<td width=50 bgcolor="#96b5c9"></td>
<td width=50 bgcolor="#96b5c9"></td>
</tr>
<?php
	$i = 1;

	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo="EDEEEE"; }else{ $fundo="DCE0E4"; }
	$i++;
	$fundo2 = "96b5c9";

			$ano = substr ($not2[d_data], 0, 4);
		        $mes = substr($not2[d_data], 5, 2 );
		        $dia = substr ($not2[d_data], 8, 2 );
?>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$l_cod"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="d_cod" value="<?php print("$not2[d_cod]"); ?>">
<input type="hidden" name="alterar" value="1">
<input type="hidden" name="lista" value="1">
<tr>
<td bgcolor="#<?php print("$fundo"); ?>"><p align="left">
<input type="text" name="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia"); ?>"><font size="2">/</font><input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes"); ?>"><font size="2">/</font><input type="text" name="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"></td>
<td bgcolor="#<?php print("$fundo"); ?>">
<input type="text" class="campo4" name="d_desc" size="40" value="<?php print("$not2[d_desc]"); ?>">
<?php
	//$saldo_total = str_replace(".", "", $saldo_total);
	//$saldo_total = str_replace(",", ".", $saldo_total);
	$depositos = $depositos + $not2[d_valor];
	$saldo2 = $saldo_total - $depositos;
?>
</td>
<td bgcolor="#<?php print("$fundo"); ?>">
<p align="left">
<input type="text" class="campo4" name="d_valor" size="10" value="<?php print("$not2[d_valor]"); ?>"></td>
<td bgcolor="#<?php print("$fundo"); ?>">
<p align="left">
<font color="#ff0000" size="2" face="Arial">R$ 
<?php print("$saldo2"); ?></td>
</tr><tr>
<td bgcolor="#<?php print("$fundo2"); ?>">
<p align="left">
<font color="#000000" size="2" face="Arial">
<?php
	if(($valid_user == "muraski@muraski.com") or ($valid_user == "paulo@bruc.com.br")){
?>
<input type="submit" value="Atualizar" class="campo" name="bot">
<?php
	}
?>
</td>
<td bgcolor="#<?php print("$fundo2"); ?>">
<p align="left">
<font color="#ffffff" size="2" face="Arial">
<?php
	if(($valid_user == "muraski@muraski.com") or ($valid_user == "paulo@bruc.com.br")){
?>
<input type="submit" value="Apagar" class="campo" name="bot">
<?php
	}
	else
	{
?>
Apenas o Sr. Claudir pode atualizar ou apagar Depósitos!
<?php
	}
?></td>
<td bgcolor="#<?php print("$fundo2"); ?>"></td>
<td bgcolor="#<?php print("$fundo2"); ?>"></td>
</tr>
</form>
<?php
	}
	}
	$saldo_grava = $saldo_total - $depositos;
	$saldo_total = $saldo_total - $depositos;
	$saldo_total = number_format($saldo_total, 2, ',', '.');
	$dia = date(d);
	$mes = date(m);
	$ano = date(Y);
?>
<tr>
<td width=50 bgcolor="#ffffff"><font color="#000000" size="2" face="Arial"><b>
<p align="center"><b></td>
<td colspan=3 bgcolor="#ffffff" align=left><font color="#000000" size="2" face="Arial"><b>
<b>Saldo à receber:<font color="#0000ff" size="2" face="Arial"><b> R$ <?php print("$saldo_total"); ?></td>
</tr>
<?php
	$query5= "update depositos set d_saldo='$saldo_grava' where d_cod='$d_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	//echo $query5;
	$result5 = mysql_query($query5) or die("Não foi possível atualizar suas informações. saldo");
?>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$l_cod"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="alterar" value="1">
<input type="hidden" name="lista" value="1">
<tr>
<td bgcolor="#EDEEEE"><p align="left">
<input type="text" name="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia"); ?>"><font size="2">/</font><input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes"); ?>"><font size="2">/</font><input type="text" name="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"></td>
<td bgcolor="#EDEEEE">
<input type="text" class="campo4" name="d_desc" size="40" value="">
<?php
	//$saldo_total = $saldo_total - $not2[d_valor];
	//$saldo_total = number_format($saldo_total, 2, ',', '.');
?>
</td>
<td bgcolor="#EDEEEE">
<p align="left">
<input type="text" class="campo4" name="d_valor" size="10" value=""></td>
<td bgcolor="#EDEEEE">
<p align="left"></td>
</tr><tr>
<td bgcolor="#EDEEEE">
<p align="left">
<font color="#000000" size="2" face="Arial">
<input type="submit" value="Inserir" class="campo" name="bot"></td>
<td bgcolor="#EDEEEE"></td>
<td bgcolor="#EDEEEE"></td>
<td bgcolor="#EDEEEE"></td>
</tr>
</form>
<?php
	
	$query2 = "select count(d_cod) as contador from depositos where d_loc='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2[contador] / 30);
?>
                  <tr><td colspan="4" bgcolor="#ffffff">
                  <font face="Arial" size="2" color="#000000">
                  <p align="center">
                  <i>Foram encontrados <?php print("$not2[contador]"); ?> depósitos</i></td></tr>
                  <tr><td colspan="4" bgcolor="#ffffff">
                  <font face="Arial" size="2" color="#ff0000">
                  <p align="center">
<?php
	if ($from > 30) {
	$url1 = "$php_self?screen=" . ($screen - 1) . "&cod=" . $cod . "&l_cod=" . $l_cod;
?>
                  <a href="<?php print("$url1"); ?>"><< Página anterior <<</a>
<?php
	}
	else
	{
?>
                  <a href="javascript:history.back()">
                  << Página anterior <<</a>
<?php
	}

	for ($i = 0; $i < $pages; $i++) {
  	$url2 = "$php_self?screen=" . $i . "&cod=" . $cod . "&l_cod=" . $l_cod;
  	echo "   | <a href=\"$url2\">$i</a> |   ";
	}

	if ($from >= $not2[contador]) {
?>
		  Última página da pesquisa
<?php
	}
	else
	{
	$url3 = "$php_self?screen=" . ($screen + 1) . "&&cod=" . $cod . "&l_cod=" . $l_cod;
?>
                  <a href="<?php print("$url3"); ?>">>> Próxima Página >></a>
<?php
	}
	}
?>
                  </td></tr>
<?php
	}
?>
</table>
</td></tr></table>
<?php
//mysql_free_result($result1);
//mysql_free_result($result2);
//mysql_free_result($result3);
	

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

</html>