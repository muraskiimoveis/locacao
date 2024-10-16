<?php
ini_set('max_execution_time','90');
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_LOCA");

if($_GET['mostra']){
  $mostra = $_GET['mostra'];
}else{
  $mostra = $_POST['mostra'];
}


?>

<html>
<head>
<?php
include("style.php");

?>
</head>
<body>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<? if($mostra=='S'){ ?>
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
<? } ?>
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
<script language="javascript">
function valida()
{
  if (document.form1.dia3.value == "")
  {
    alert("Por favor, digite o Dia de Entrada");
    document.form1.dia3.focus();
    return (false);
  }
  if (document.form1.mes3.value == "")
  {
    alert("Por favor, digite o Mês de Entrada");
    document.form1.mes3.focus();
    return (false);
  }
  if (document.form1.ano3.value == "")
  {
    alert("Por favor, digite o Ano de Entrada");
    document.form1.ano3.focus();
    return (false);
  }
  if (document.form1.dia4.value == "")
  {
    alert("Por favor, digite o Dia de Saída");
    document.form1.dia4.focus();
    return (false);
  }
  if (document.form1.mes4.value == "")
  {
    alert("Por favor, digite o Mês de Saída");
    document.form1.mes4.focus();
    return (false);
  }
  if (document.form1.ano4.value == "")
  {
    alert("Por favor, digite o Ano de Saída");
    document.form1.ano4.focus();
    return (false);
  }

  var data1 = document.form1.ano3.value + document.form1.mes3.value + document.form1.dia3.value;
  var data2 = document.form1.ano4.value + document.form1.mes4.value + document.form1.dia4.value;
  if (data2 < data1) {
	alert("Data inicial deve ser menor que data final.");
	document.form1.dia3.focus();
	return(false);
  }
    document.form1.action='p_extrato_locacao.php';
    document.form1.buscar.value='1';
    document.form1.submit();
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
<div align="center">
  <center>
<table border="0" cellpadding="1" cellspacing="1" width="95%">
<form method="post" action="<?php print("$PHP_SELF"); ?>" name="form1">
  <input type="hidden" value="<?php print("$cod_imovel"); ?>" name="cod_imovel">
<?php
/*
	if(($dia3 == "") or ($mes3 == "") or ($ano3 == "")){
	$dia3 = date("d");
	$mes3 = date("m");
	$ano3 = date("Y");
	}
*/
?>
	<tr height="50">
		<td colspan=7 class=style1 align="center">
			<b>Extrato de Locação de Locação <!--Diária-->Temporada:</b><br> Preencha o período que você deseja visualizar o relatório e clique em visualizar
		</td>
	</tr>
	<tr class="fundoTabela">
		<td colspan="7" align="center">
			<input type="text" name="dia3" value="<?php print("$dia3"); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes3" value="<?php print("$mes3"); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano3" value="<?php print("$ano3"); ?>" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);"> <b>à</b> <input type="text" name="dia4" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia4"); ?>">/<input type="text" name="mes4" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes4"); ?>">/<input type="text" name="ano4" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano4"); ?>">
		 </td>
	</tr>
	<tr>
		<td align="left">	 
			<input type="hidden" id="buscar" name="buscar" value="0">
		 	<input type="button" name="B1" value="Visualizar" class="campo3" onClick="valida();">
		 </td>
  	</tr>
</form>
<?php
if($_POST['buscar']=='1'){

	$k = 0;

	$query20 = "select contador, cliente from muraski where cod='$cod_imovel' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result20 = mysql_query($query20) or die("Erro 159".mysql_error());
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];
	  $cod_cliente = $not2[cliente];
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}

	$cod_cliente2 = " (";
	for($i3 = 1; $i3 <= $contador; $i3++){
	    if($i3==1){
			$cod_cliente2 .= "c_cod='".$cliente2[$i3-1]."'";
		}else{
		  	$cod_cliente2 .= " or c_cod='".$cliente2[$i3-1]."'";
		}
	}
	$cod_cliente2 .= ")";

	$query0 = "select * from clientes, locacao, muraski where cod=l_imovel and muraski.cliente like '".$cod_cliente."' and $cod_cliente2 and
	l_imovel='$cod_imovel' and (l_data between '$ano3-$mes3-$dia3' and '$ano4-$mes4-$dia4') and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'
    order by locacao.l_imovel, locacao.l_data_ent";
	//echo $query0;
	$result0 = mysql_query($query0) or die("Erro 182".mysql_error());
	$numrows0 = mysql_num_rows($result0);

	$j = 0;

	while($not0 = mysql_fetch_array($result0))
	{
		if (($j % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
		$j++;
		
		$k++;

				$cod = $not0[cod];
				$ref = $not0[ref];
				$titulo = strip_tags($not0[titulo]);
				$cliente = $not0[c_nome];
				$c_cod = $not0[c_cod];
				$co_locacao = $not0[l_cod];
				$anol = substr ($not0[l_data_ent], 0, 4);
		        $mesl = substr($not0[l_data_ent], 5, 2 );
		        $dial = substr ($not0[l_data_ent], 8, 2 );
		        $anol1 = substr ($not0[l_data_sai], 0, 4);
		        $mesl1 = substr($not0[l_data_sai], 5, 2 );
		        $dial1 = substr ($not0[l_data_sai], 8, 2 );
		        $data_ent = "$dial/$mesl/$anol";
		        $data_sai = "$dial1/$mesl1/$anol1";

	            $data = mktime(0,0,0, $mesl, $dial, $anol);
	            $data1 = mktime(0,0,0, $mesl1, $dial1, $anol1);

	            $diarias = round(($data1 - $data)/(24*60*60));
	            $diarias = $diarias + 1;

		        $l_total = $not0[l_total];
		        $diaria = $l_total/$diarias;		        
		        $l_comissao = $not0[l_comissao];
		        $l_saldo = $not0[l_saldo];
		        $diaria_tela = number_format($diaria, 2, ',', '.');
		        $total_tela = number_format($l_total, 2, ',', '.');
		        $comissao_tela = number_format($l_comissao, 2, ',', '.');
		        $saldo_tela = number_format($l_saldo, 2, ',', '.');

	//}
	
	// Pegar dados do inquilino
	$query1 = "select c_cod, c_nome from clientes, locacao where c_cod=l_cliente and
	l_cod='$co_locacao' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result1 = mysql_query($query1) or die("Erro 228".mysql_error());
	$numrows1 = mysql_num_rows($result1);
	while($not1 = mysql_fetch_array($result1))
	{
						$locatario = $not1[c_nome];
						$c_cod2 = $not1[c_cod];
	}
?>
<?php
	if($prop <> $cliente){
	$prop = $cliente;
?>
<tr>
	<td colspan="7"><br /><br /><table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr class="fundoTabela">
			<td class="style1" width="20%"><b>Ref.:</b> <?php print("$ref"); ?></td>
			<td width="40%" class="style1"><b>Imóvel:</b> <?php print("$titulo"); ?></td>
			<td width="40%" class="style1"><b>Prop.:</b> <?php print("$cliente"); ?></td>
		</tr>
	</table></td>
</tr>
<tr>
	<td colspan=7 height=20></td>
</tr>
<?php
	}
?>
<tr class="<?php print("$fundo"); ?>">
	<td colspan=7><table width=100%>
		<tr>
			<td class=style1><?php print("$k"); ?>) <b><?php print("$data_ent"); ?></b> à <b><?php print("$data_sai"); ?></b></td>
			<td class=style6><b><?php print("$diarias"); ?> dias</b></td>
			<td class=style1>Diária: R$ <?php print("$diaria_tela"); ?></td>
		</tr>
	</table></td>
</tr>
<tr class="<?php print("$fundo"); ?>">
	<td colspan=7 class=style6><b>Total Bruto:</b> R$ <?php print("$total_tela"); ?></td>
</tr>
<tr class="<?php print("$fundo"); ?>">
	<td colspan=7 class=style1><b>Comissão:</b> R$ <?php print("$comissao_tela"); ?></td>
</tr>
<?php
	//Mostrar os depósitos a receber do locatário
	$query2 = "select *,(select SUM(co_valor) from contas where co_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Receber' 
	and co_status='pendente') AS saldo 
	from contas where co_locacao='$co_locacao' and co_cliente='$c_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_tipo='Despesas' 
	order by co_cat desc, co_cliente, co_data";
	
	//echo $query2;
	$result2 = mysql_query($query2) or die("Erro 278".mysql_error());
	$numrows2 = mysql_num_rows($result2);
?>
<?php
	$i = 1;
	$total_cred = 0;

	if($numrows2 > 0){
?>
<tr>
	<td colspan=7 class=style7><b>Despesas:</b></td>
</tr>
<?php
	$j = 0;
	while($not2 = mysql_fetch_array($result2))
	{
	$from = $from + 1;
	
	if (($j % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$j++;
	$fundo2 = "EDEEEE";

				$anol = substr ($not2[co_data], 0, 4);
		        $mesl = substr($not2[co_data], 5, 2 );
		        $dial = substr ($not2[co_data], 8, 2 );
		        $anol1 = substr ($not2[co_data_status], 0, 4);
		        $mesl1 = substr($not2[co_data_status], 5, 2 );
		        $dial1 = substr ($not2[co_data_status], 8, 2 );
		   					   			
		        $data = "$dial/$mesl/$anol";
		        $data_status = "$dial1/$mesl1/$anol1";

	$total_cred = $not2[co_valor] + $total_cred;

	$valor_tela = number_format($not2[co_valor], 2, ',', '.');
?>
<tr class="<?php print("$fundo"); ?>">
<td colspan="7">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<td align="left" class="style7" width="50%"><?php print("$not2[co_desc]"); ?></td>
<td align="left" class="style7" width="25%">R$ <?php print("$valor_tela"); ?></td>
<td align="left" class="style7" width="25%"><?php print("$data"); ?></td>
<tr>
</table>
</td>
</tr>
<?php
	}
	$total_cred_tela = number_format($total_cred, 2, ',', '.');
?>
<tr>
	<td colspan=7 class=style7><b>Total de Despesas:</b> R$ <?php print("$total_cred_tela"); ?></td>
</tr>
<?php
	}
?>
<tr>
	<td colspan=7 height=20></td>
</tr>
<tr class="<?php print("$fundo"); ?>">
	<td colspan=7 class=style6><b>Saldo Líquido:</b> R$ <?php print("$saldo_tela"); ?></td>
</tr>
<tr>
	<td colspan=7 height=20></td>
</tr>
<tr class="<?php print("$fundo"); ?>" height="25px">
	<td colspan=7 class=style1 align="left"><b>Depósitos:</b></td>
</tr>
<?php
	//Mostrar os depósitos a fazer pro proprietário
	$query2 = "select *,(select SUM(co_valor) from contas where co_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Pagar' 
	and co_status='pendente') AS saldo 
	from contas where co_locacao='$co_locacao' and co_cliente='$c_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Pagar'
	order by co_cat desc, co_cliente, co_data";
	
	//echo $query2;
	$result2 = mysql_query($query2) or die("Erro 354".mysql_error());
	$numrows2 = mysql_num_rows($result2);
?>
<?php
	$i = 0;
	$saldo_total = 0;
	$saldo = 0;
	$total_deb = 0;
	$total_debp = 0;

	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	$fundo2 = "EDEEEE";

				$anol = substr ($not2[co_data], 0, 4);
		        $mesl = substr($not2[co_data], 5, 2 );
		        $dial = substr ($not2[co_data], 8, 2 );
		        $anol1 = substr ($not2[co_data_status], 0, 4);
		        $mesl1 = substr($not2[co_data_status], 5, 2 );
		        $dial1 = substr ($not2[co_data_status], 8, 2 );
		   				   			
		        $data = "$dial/$mesl/$anol";
		        $data_status = "$dial1/$mesl1/$anol1";
		        
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

	$valor_tela = number_format($not2[co_valor], 2, ',', '.');
	$valor_tela = str_replace("-","","$valor_tela");
?>
<tr class="<?php print("$fundo"); ?>">
<td colspan="7">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<td align="left" class="style6" width="50%"><?php if($not2[co_status] == "ok"){ echo "<b>"; } ?>R$ <?php print("$valor_tela"); ?></td>
<td align="left" class="style6" width="25%"><?php if($not2[co_status] == "ok"){ echo "<b>"; ?><?php print("$data"); ?><?php } ?></td>
<td align="left" class="style6" width="25%"><?php if($not2[co_status] == "pendente"){ ?>à depositar<?php } else { echo "<b>"; ?>depositado<?php } ?></td>
<tr>
</table>
</td>
</tr>
<?php
	}
	$total_deb_tela = number_format($total_deb, 2, ',', '.');
	$total_debp_tela = number_format($total_debp, 2, ',', '.');
?>
<tr>
	<td colspan=7><table width=100%>
		<tr>
			<td class=style1 width=50%>Total depositado: <span class=style6>R$ <?php print("$total_deb_tela"); ?></span></td>
			<td class=style1 width=50%>Total à depositar: <span class=style7>R$ <?php print("$total_debp_tela"); ?></span></td>
</tr>
<tr>
	<td colspan=7 height="20px"></td>
</tr>
<?php
	}
?>
<?php
	}//while0
}
?>
<?   if (($numrows0 == 0) && ($buscar == 1)) { ?>
<tr>
<td>
<BR /><span class='style7'><strong>Não foram encontrados resultados</strong></span>
</td>
</tr>
<?   } ?>



</table>
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
<tr>
<td colspan=11 align=center class=style1><input type="button" name="fechar" id="fechar" class="campo3" value="Fechar Janela" Onclick="window.close();"></td>
</tr>
</table>
<? if($mostra=='S'){ ?>
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
<? } ?>
</body>
</html>
