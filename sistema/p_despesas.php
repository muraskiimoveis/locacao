<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
//verificaArea("GERAL_DESPESAS");
?>
<html>
<head>
<?php
include("style.php");
?>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="funcoes/js.js"></script>
<body topmargin=0 leftmargin=0 rightmargin=0 onUnload="window.opener.location.reload()">
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
	if (verificaFuncao("USER_DESPESA")) { // verifica se pode acessar as areas 
	$query4= "delete from despesas where de_cod='$de_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível apagar suas informações.");
		}
	}
	elseif($bot == "Atualizar"){
	$query4= "update despesas set de_desc='$de_desc', de_valor='$de_valor'
	, de_data='$ano-$mes-$dia', de_status='$de_status' where de_cod='$de_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	//echo $query4;
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	}
	elseif($bot == "Recebida"){
	$query4= "update despesas set de_status='Recebida' where de_cod='$de_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	//echo $query4;
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	}
	elseif($bot == "Inserir"){
	$query4= "insert into despesas (cod_imobiliaria, de_imovel, de_valor, de_data, de_desc) 
	values('".$_SESSION['cod_imobiliaria']."','$cod', '$de_valor', '$ano-$mes-$dia', '$de_desc')";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	$de_cod = mysql_insert_id();
	}

	}

//if($lista == "1")
	//{
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
<table width=95% border="0" cellpadding="1" cellspacing="1">
<tr height="50">
	<td class="style1" colspan=4><p align="left"><b>Relatório de Despesas extras do imóvel <a href=p_edit_imoveis.php?cod=<?php print("$cod"); ?>&edit=editar> - Ref.: <?php print("$not3[ref]"); ?></a><br />Para alterar ou excluir uma despesa, clique nos botões.</p></td>
</tr>
<?php
	$query2 = "select * from despesas where de_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
?>
<tr height="50">
	<td colspan="6" class="style1" align="center"><b>Despesas com Serviços no imóvel</b></td>
</tr>
<tr class="fundoTabela">
	<td colspan="6" class="style1"><b>Ref.:</b> <?php print("$referencia"); ?> - <?php print("$titulo"); ?></td>
</tr>
<tr>
	<td colspan="6" height="25px">&nbsp;</td>
</tr>

<tr class="fundoTabelaTitulo">
<td width="15%" class="style1"><p align="center"><b>Data</b></p></td>
<td width="55%" class="style1"><p align="center"><b>Descrição</b></p></td>
<td width="15%" class="style1"><p align="center"><b>Valor</b></p></td>
<td width="15%" class="style1"><p align="center"><b>Status</b></p></td>
</tr>
<?php
	$i = 0;

	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	$fundo2 = "96b5c9";

			$ano = substr ($not2[de_data], 0, 4);
		  $mes = substr($not2[de_data], 5, 2 );
		  $dia = substr ($not2[de_data], 8, 2 );
?>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="de_cod" value="<?php print("$not2[de_cod]"); ?>">
<input type="hidden" name="alterar" value="1">
<input type="hidden" name="lista" value="1">
<tr class="<?php print("$fundo"); ?>">
<td class="style1"><p align="left">
<input type="text" name="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia"); ?>"><font size="2">/</font><input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes"); ?>"><font size="2">/</font><input type="text" name="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"></td>
<td bgcolor="#<?php print("$fundo"); ?>">
<input type="text" class="campo4" name="de_desc" size="40" value="<?php print("$not2[de_desc]"); ?>">
</td>
<?php
	if($not2[de_status] == "à receber"){
		$despesas = $despesas + $not2[de_valor];
	}
?>
<td class="style1">
<p align="left">
<input type="text" class="campo4" name="de_valor" size="10" value="<?php print("$not2[de_valor]"); ?>"></td>
<td class="style1">
<p align="left" class="style7"><?php print("$not2[de_status]"); ?></td>
</tr>
<tr class="<?php print("$fundo"); ?>">
<td bgcolor="#<?php print("$fundo2"); ?>">
<p align="left" class="style1">
<? if (verificaFuncao("USER_DESPESA")) { // verifica se pode acessar as areas ?>
<input type="submit" value="Atualizar" class="campo3" name="bot">
<?php
	}
?>
</td>
<td bgcolor="#<?php print("$fundo2"); ?>">
<p align="left" class="style1"><? if (verificaFuncao("USER_DESPESA")) { // verifica se pode acessar as areas ?>
<input type="submit" value="Apagar" class="campo3" name="bot">
<input type="submit" value="Recebida" class="campo3" name="bot">
<?php
	}
	else
	{
?>
Apenas o admistrador pode atualizar ou apagar Despesas!
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
	$desp_total = number_format($despesas, 2, ',', '.');
	$dia = date(d);
	$mes = date(m);
	$ano = date(Y);
?>
<tr class="fundoTabela">
<td class="style1">&nbsp;</td>
<td colspan=3 align=left class="style1"><b>Despesas à receber:<b> R$ <?php print("$desp_total"); ?></td>
</tr>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="alterar" value="1">
<input type="hidden" name="lista" value="1">
<tr>
<td class="fundoTabela"><p align="left">
<input type="text" name="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia"); ?>"><font size="2">/</font><input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes"); ?>"><font size="2">/</font><input type="text" name="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"></td>
<td class="fundoTabela">
<input type="text" class="campo4" name="de_desc" size="40" value="">
</td>
<td class="fundoTabela">
<p align="left">
<input type="text" class="campo4" name="de_valor" size="10" value=""></td>
<td class="fundoTabela">
<p align="left"></td>
</tr><tr>
<td class="fundoTabela">
<p align="left" class="style1">
<input type="submit" value="Inserir" class="campo3" name="bot"></td>
<td class="fundoTabela"></td>
<td class="fundoTabela"></td>
<td class="fundoTabela"></td>
</tr>
</form>
<?php
	
	$query2 = "select count(de_cod) as contador from despesas where de_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2[contador] / 30);
?>
                  <tr class="fundoTabelaTitulo">
                  	<td colspan="4" class="style1"><p align="center"><b>Foram encontrados <?php print("$not2[contador]"); ?> despesas</b></p></td>
                  </tr>
<?php
	}
?>
<?php
	
	$query2 = "select count(de_cod) as contador from despesas where de_imovel='$cod' 
	and de_status='à receber' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
                  <tr class="fundoTabelaTitulo">
                  	<td colspan="4" class="style7"><p align="center"><b>Ainda existem <?php print("$not2[contador]"); ?> despesas à receber.</b></p></td>
                  </tr>
<?php
	}
?>
<?php
	//}
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
