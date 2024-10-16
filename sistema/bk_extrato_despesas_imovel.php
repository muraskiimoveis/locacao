<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_DEPOSITOS");
?>
<html>

<head>
<?php
include("style.php");
?>
<script language="javascript">
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
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funcoes/js.js"></script>
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
	(($u_tipo == "admin"))){
*/	  
	  
	$url = $REQUEST_URI;
	//echo $url;
	$url = explode("?", $url);
	//$url2 = explode("dia2", $url[1]);
	//$url = str_replace("&","-","$url");
	//$url = str_replace("?","|","$url");
?>
<div align="center">
  <center>
<table bgcolor="#<?php print("$cor1"); ?>" border="0" cellspacing="1">
<?
		if($acao == "Confirmar"){
		
			$query4= "update contas set co_status='ok', co_data_status=current_date
			, co_usuario_status='$valid_user' where co_cod='$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");	
		
		}elseif($acao == "X"){
	
			$query4= "update contas set co_status='pendente', co_data_status=current_date
			, co_usuario_status='$valid_user' where co_cod='$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");	
		
		}

if($_GET['buscad']){
  $buscad = $_GET['buscad'];
}elseif($_POST['buscad']){
  $buscad = $_POST['buscad'];
}
	
if($buscad=='1'){

	$query0 = "select * from clientes c, muraski m, contas co where c.c_cod=m.cliente and co.co_imovel='$codim' and co.co_imovel=m.cod and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	while($not0 = mysql_fetch_array($result0))
	{
						$cod = $not0[cod];
						$cod_imovel = $not0[cod];
						$ref = $not0[ref];
						$titulo = $not0[titulo];
						$cliente = $not0[c_nome];
						$c_cod = $not0[c_cod];
							$ano = substr ($not0[l_data_ent], 0, 4);
		        $mes = substr($not0[l_data_ent], 5, 2 );
		        $dia = substr ($not0[l_data_ent], 8, 2 );
		        $ano1 = substr ($not0[l_data_sai], 0, 4);
		        $mes1 = substr($not0[l_data_sai], 5, 2 );
		        $dia1 = substr ($not0[l_data_sai], 8, 2 );
		        $data_ent = "$dia/$mes/$ano";
		        $data_sai = "$dia1/$mes1/$ano1";
		        $l_total = $not0[l_total];
		        $total_tela = number_format($l_total, 2, ',', '.');
	}	
?>
<tr>
	<td bgcolor="#<?php print("$cor1"); ?>" colspan=7 class=style1 align="left"><b>Extrato de Depósitos</b></td>
</tr>
<tr>
	<td colspan=7><table width=100%>
		<tr>
			<td class=style1>Ref.: <b><?php print("$ref"); ?></b></td>
			<td class=style1>Imóvel: <b><?php print("$titulo"); ?></b></td>
			<td class=style1>Prop.: <a href="p_lista_contas.php?co_cliente=<?php print("$c_cod"); ?>&nome_cliente=<?php print("$cliente"); ?>&co_status=pendente&status=C" target="_blank" class="style1"><b><?php print("$cliente"); ?></b></a></td>
		</tr>
	</table></td>
</tr>
<tr>
	<td colspan=7 height=20></td>
</tr>
<tr>
	<td bgcolor="#<?php print("$cor1"); ?>" colspan=7 class=style1 align="center"><b>Depósitos à receber do Proprietário (Despesas do Imóvel):</b></td>
</tr>
<?php
  
	//Mostrar os depósitos a receber do proprietário
	
	$query2 = "select *,(select SUM(co_valor) from contas where co_imovel='$codim' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Receber' 
	and co_status='pendente' and co_tipo='Despesas Imóvel') AS saldo 
	from contas where co_imovel='$codim'  and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Receber' and co_tipo='Despesas Imóvel' order by co_cat desc, co_cliente, co_data";
				
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
?>
<?php
	$i = 1;
	$saldo_total = 0;
	$saldo = 0;
	$total_cred = 0;
	$total_deb = 0;
	$total_credp = 0;
	$total_debp = 0;

	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo="$cor1"; }else{ $fundo="$cor1"; }
	$i++;
	$fundo2 = "96b5c9";

				$ano = substr ($not2[co_data], 0, 4);
		        $mes = substr($not2[co_data], 5, 2 );
		        $dia = substr ($not2[co_data], 8, 2 );
		        $ano1 = substr ($not2[co_data_status], 0, 4);
		        $mes1 = substr($not2[co_data_status], 5, 2 );
		        $dia1 = substr ($not2[co_data_status], 8, 2 );
		   			
	$data = mktime(0,0,0, $mes, $dia, $ano);
	$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);
	
	$diarias = round(($data1 - $data)/(24*60*60));
	$diarias = $diarias + 1;
	
	$total_dias = $diarias + $total_dias;
		   			
		        $data = "$dia/$mes/$ano";
		        $data_status = "$dia1/$mes1/$ano1";
		        
	if($not2[co_cat] == "Pagar"){
		//$not2[co_valor] = "-" . $not2[co_valor];
		$not2[co_valor] = $not2[co_valor];
		if($not2[co_status] == "ok"){
		$total_deb = $not2[co_valor] + $total_deb;
		}
		else
		{
		$total_debp = $not2[co_valor] + $total_debp;
		}
	}
	else
	{
		if($not2[co_status] == "ok"){
		$total_cred = $not2[co_valor] + $total_cred;
		}
		else
		{
		$total_credp = $not2[co_valor] + $total_credp;
		}
	}
	//$valor_tela = number_format($not2[co_valor], 2, ',', '.');
	$valor_tela = str_replace("-","","$not2[co_valor]");
	
	$total = $total_cred + $total_deb;
	$totalp = $total_credp + $total_debp;
	$saldo_total = $totalp + $total;

	if($i <= 2){
		$saldo = $not2[saldo] + $not2[co_valor];
	}
	else
	{
		$saldo = $saldo + $not2[co_valor];
	}
	$saldo_tela = number_format($saldo, 2, ',', '.');
	$saldo_ant_tela = number_format($not2[saldo], 2, ',', '.');
?>
<?php
	if($i == 0){
?>
<tr>
	<td colspan=7 align=right bgcolor="#<?php print("$fundo"); ?>" class=<?php if($not2[saldo] > 0){ echo "style6"; }else{ echo "style1"; } ?>><b>Saldo Anterior: R$ <?php print("$saldo_ant_tela"); ?></b></td>
</tr>
<?php
	}
?>
<form method="post" id="formdes" name="formdes" action="extrato_despesas_imovel.php?codim=<?=$codim?>&buscad=<?=$buscad?>">
<input type="hidden" name="cliente" value="<?php print("$not2[co_cliente]"); ?>">
<input type="hidden" name="buscad" value="<?php print($buscad); ?>">
<input type="hidden" name="cod_imovel" value="<?php print("$not2[co_imovel]"); ?>">
<input type="hidden" name="co_cod" value="<?php print("$not2[co_cod]"); ?>">
<input type="hidden" name="co_valor" value="<?php print("$not2[co_valor]"); ?>">
<input type="hidden" name="co_forma" value="<?php print("$not2[co_forma]"); ?>">
<input type="hidden" name="co_tipo" value="<?php print("$not2[co_tipo]"); ?>">
<input type="hidden" name="co_data" value="<?php print("$not2[co_data]"); ?>">
<input type="hidden" name="co_cat" value="<?php print("$not2[co_cat]"); ?>">
<tr>
<td bgcolor="#<?php print("$fundo"); ?>" class="<?php if($not2[co_cat] == "Receber"){ echo "style6"; }else{ echo "style1"; } ?>" align="left"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_forma]"); ?></td>
<?php
	//$valor_tela = $not2[co_valor];
?>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Receber"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>R$ <input type="text" name="valor" value="<?php print("$valor_tela"); ?>" size="10" class="campo" <?php if($not2[co_status] == "ok"){ echo "readonly"; } ?>></td>
<td width=70 bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style1"; } ?>"></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Receber"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>para</td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Receber"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$data"); ?> </td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Receber"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_tipo]"); ?></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="right" class="<?php if($not2[co_cat] == "Receber"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>
<?php
	if($not2[co_status] == "ok"){
?>
<?php print("$data_status - $not2[co_status]"); ?> <input type="submit" value="X" class=campo3 name="acao">
<?php
	}
	else
	{
?>
<input type="submit" value="Confirmar" class=campo3 name="acao">
<?php
	}
?>
	</td>
</tr>
</form>
<tr>
	<td colspan=7 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
</tr>
<?php
	}
	$total_tela = number_format($total, 2, ',', '.');
	$totalp_tela = number_format($totalp, 2, ',', '.');
	$saldo_total_tela = number_format($saldo_total, 2, ',', '.');
	$total_cred_tela = number_format($total_cred, 2, ',', '.');
	$total_deb_tela = number_format($total_deb, 2, ',', '.');
	$total_credp_tela = number_format($total_credp, 2, ',', '.');
	$total_debp_tela = number_format($total_debp, 2, ',', '.');
	$total_deb_tela = str_replace("-","","$total_deb_tela");
	$total_debp_tela = str_replace("-","","$total_debp_tela");
?>
<tr>
	<td colspan=7><table width=100%>
		<tr>
			<td class=style1 width=50%>Valor Recebido: <span class=style6>R$ <?php print("$total_cred_tela"); ?></span></td>
			<td class=style1 width=50%>Valor à Receber: <span class=style7>R$ <?php print("$total_credp_tela"); ?></span></td>
</tr></table>
</td>
</tr>
<?php	
	}
}
?>