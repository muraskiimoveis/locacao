<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

	session_unregister("dia");
	session_unregister("mes");
	session_unregister("ano");
	session_unregister("dia1");
	session_unregister("mes1");
	session_unregister("ano1");

include("conect.php");
include("calendario2.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_LOCA");
?>
<html>
<head>
<?php
include("style.php");
?>
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
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/		
?>
<script language="javascript">
function valida()
{
  if (document.formulario.dial.value == "")
  {
    alert("Por favor, digite o Dia de Entrada");
    document.formulario.dial.focus();
    return (false);
  }
  if (document.formulario.mesl.value == "")
  {
    alert("Por favor, digite o Mês de Entrada");
    document.formulario.mesl.focus();
    return (false);
  }
  if (document.formulario.anol.value == "")
  {
    alert("Por favor, digite o Ano de Entrada");
    document.formulario.anol.focus();
    return (false);
  }
  if (document.formulario.dial1.value == "")
  {
    alert("Por favor, digite o Dia de Saída");
    document.formulario.dial1.focus();
    return (false);
  }
  if (document.formulario.mesl1.value == "")
  {
    alert("Por favor, digite o Mês de Saída");
    document.formulario.mesl1.focus();
    return (false);
  }
  if (document.formulario.anol1.value == "")
  {
    alert("Por favor, digite o Ano de Saída");
    document.formulario.anol1.focus();
    return (false);
  }
  if (document.formulario.valor.value == "")
  {
    alert("Por favor, digite o Valor");
    document.formulario.valor.focus();
    return (false);
  }
  if (document.formulario.n_contrato.value == "")
  {
    alert("Por favor, digite o N° do Contrato");
    document.formulario.n_contrato.focus();
    return (false);
  }
  if (document.formulario.tipo_contrato.selectedIndex == 0)
  {
    alert("Por favor, selecione o Tipo de Contrato");
    document.formulario.tipo_contrato.focus();
    return (false);
  }
  if (document.formulario.vigencia.value == "")
  {
    alert("Por favor, digite a Vigência do Contrato");
    document.formulario.vigencia.focus();
    return (false);
  }
  if (document.formulario.venc_contrato.value == "")
  {
    alert("Por favor, digite o Vencimento do Contrato");
    document.formulario.venc_contrato.focus();
    return (false);
  }
  if (document.formulario.venc_contrato.value == "")
  {
    alert("Por favor, digite o Vencimento do Contrato");
    document.formulario.venc_contrato.focus();
    return (false);
  }
  if (document.formulario.venc_aluguel.value == "")
  {
    alert("Por favor, digite o Vencimento do aluguel");
    document.formulario.venc_aluguel.focus();
    return (false);
  }
  if (document.formulario.venc_contrato.value == "")
  {
    alert("Por favor, digite o Vencimento do Contrato");
    document.formulario.venc_contrato.focus();
    return (false);
  }
  if (document.formulario.tolerancia.value == "")
  {
    alert("Por favor, digite a Tolerância de atraso");
    document.formulario.tolerancia.focus();
    return (false);
  }
  if (document.formulario.bonificacao.value == "")
  {
    alert("Por favor, digite a Bonificação para pagamento em dia");
    document.formulario.bonificacao.focus();
    return (false);
  }
  if (document.formulario.reajustes.value == "")
  {
    alert("Por favor, digite o Reajustes");
    document.formulario.reajustes.focus();
    return (false);
  }
  if (document.formulario.indice.value == "")
  {
    alert("Por favor, digite o Índice de reajustes");
    document.formulario.indice.focus();
    return (false);
  }		
  if (document.formulario.ultimo_reajuste.value == "")
  {
    alert("Por favor, digite o Último reajuste");
    document.formulario.ultimo_reajuste.focus();
    return (false);
  }
  if (document.formulario.proximo_reajuste.value == "")
  {
    alert("Por favor, digite o Próximo reajuste");
    document.formulario.proximo_reajuste.focus();
    return (false);
  }
  if (document.formulario.co_cliente.value == "")
  {
    alert("Por favor, selecione o Locatário");
    document.formulario.nome_cliente.focus();
    return (false);
  }
  if (document.formulario.fiador.value == "")
  {
    alert("Por favor, selecione o Fiador");
    document.formulario.nome_fiador.focus();
    return (false);
  }
  if (document.formulario.testemunha.value == "")
  {
    alert("Por favor, selecione a 1ª Testemunha");
    document.formulario.nome_testemunha.focus();
    return (false);
  }
  if (document.formulario.testemunha2.value == "")
  {
    alert("Por favor, selecione a 2ª Testemunha");
    document.formulario.nome_testemunha2.focus();
    return (false);
  }
  var data1 = formulario.anol.value + formulario.mesl.value + formulario.dial.value;
  var data2 = formulario.anol1.value + formulario.mesl1.value + formulario.dial1.value;	
  if (data2 < data1) {
	alert("Data inicial deve ser menor que data final.");
	document.formulario.dial.focus();
	return(false);
  }
    document.formulario.action='p_reserva_mes.php';
	document.formulario.submit();
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

## verifica os dias locados e os disponíveis para locacao

$query1 = "SELECT * FROM muraski WHERE cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
$result1 = mysql_query($query1);

if($anol == 0){
$anol = substr ($l_data_ent, 6, 4);
$mesl = substr($l_data_ent, 3, 2 );
$dial = substr ($l_data_ent, 0, 2 );
$anol1 = substr ($l_data_sai, 6, 4);
$mesl1 = substr($l_data_sai, 3, 2 );
$dial1 = substr ($l_data_sai, 0, 2 );
}

while($not1 = mysql_fetch_array($result1))
{
	### inicialização de variaveis
        $mes01 = array();
        $mes02 = array();
        $mes03 = array();
        $mes04 = array();
        $mes05 = array();
        $mes06 = array();
        $mes07 = array();
        $mes08 = array();
        $mes09 = array();
        $mes10 = array();
        $mes11 = array();
        $mes12 = array();
        $datapermitida = array();
        $todasdatas = array();

        $pano = substr ($not1[data_inicio], 0, 4);
        $pmes = substr($not1[data_inicio], 5, 2 );
        $pdia = substr ($not1[data_inicio], 8, 2 );
        $pano1 = substr ($not1[data_fim], 0, 4);
        $pmes1 = substr($not1[data_fim], 5, 2 );
        $pdia1 = substr ($not1[data_fim], 8, 2 );
        $pdata_inicio = "$pdia/$pmes/$pano";
        $pdata_fim = "$pdia1/$pmes1/$pano1";

        if (!$nextmesano){
        	$nextmes = $mesl;
                $nextano = $anol;
                $nextmesano = "$mesl/$anol";
        }


        ### monta array com periodo permitido para locacao
        #print "data permitida = $pdata_inicio, $pdata_fim<br>";
        array_push ($datapermitida, $pdata_inicio, $pdata_fim);

        $query3 = "select * from locacao where l_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_data_ent";

	$result3 = mysql_query($query3);
       	$numrows3 = mysql_num_rows($result3);
        if($numrows3 > 0){
	        while($not3 = mysql_fetch_array($result3))
       		{
		        $oano = substr ($not3[l_data_ent], 0, 4);
		        $omes = substr($not3[l_data_ent], 5, 2 );
		        $odia = substr ($not3[l_data_ent], 8, 2 );
		        $oano1 = substr ($not3[l_data_sai], 0, 4);
		        $omes1 = substr($not3[l_data_sai], 5, 2 );
		        $odia1 = substr ($not3[l_data_sai], 8, 2 );
		        $odata_ent = "$odia/$omes/$oano";
		        $odata_sai = "$odia1/$omes1/$oano1";
		        $odata1 = mktime(0,0,0, $omes, $odia, $oano);
			$odata2 = mktime(0,0,0, $omes1, $odia1, $oano1);
		        $total_dias = round(($odata2 - $odata1)/(24*60*60));
		        $total_dias = $total_dias + 1;

		        ## monta array com as datas da locacao
		        array_push (${"todasdatas"},$odata_ent,$odata_sai);
		}
	}
}

if($_GET['dial']){
  $dial = $_GET['dial'];
}else{
  $dial = $_POST['dial'];
}
 
if($_GET['mesl']){
  $mesl = $_GET['mesl'];
}else{
  $mesl = $_POST['mesl'];
}

if($_GET['anol']){
  $anol = $_GET['anol'];
}else{
  $anol = $_POST['anol'];
}

if($_GET['dial1']){
  $dial1 = $_GET['dial1'];
}else{
  $dial1 = $_POST['dial1'];
}
 
if($_GET['mesl1']){
  $mesl1 = $_GET['mesl1'];
}else{
  $mesl1 = $_POST['mesl1'];
}

if($_GET['anol1']){
  $anol1 = $_GET['anol1'];
}else{
  $anol1 = $_POST['anol1'];
}

	$data = mktime(0,0,0, $mesl, $dial, $anol);
	$data1 = mktime(0,0,0, $mesl1, $dial1, $anol1);
	
	$total_dias = round(($data1 - $data)/(24*60*60));
	$total_dias = $total_dias + 1;
?>
<p>
<div align="center">
  <center>
  <form method="get" action="" name="formulario" id="formulario">
    <input type="hidden" name="dial" value="<?php print("$dial"); ?>">
    <input type="hidden" name="mesl" value="<?php print("$mesl"); ?>">
    <input type="hidden" name="anol" value="<?php print("$anol"); ?>">
    <input type="hidden" name="dial1" value="<?php print("$dial1"); ?>">
    <input type="hidden" name="mesl1" value="<?php print("$mesl1"); ?>">
    <input type="hidden" name="anol1" value="<?php print("$anol1"); ?>">
  <table border="0" cellspacing="1" width="800" bgcolor="#<?php print("$cor1"); ?>">
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td width="100%" colspan=2 class="style1"><p align="center"><b>Reservar Imóvel</b></p></td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Período:</b></td>
      <td width="80%" class=style1> 
      	<input type="text" name="dial" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($_GET['dial']){ print($_GET['dial']); }else{ print("$dial"); } ?>">/<input type="text" name="mesl" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($_GET['mesl']){ print($_GET['mesl']); }else{ print("$mesl"); } ?>">/<input type="text" name="anol" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php if($_GET['anol']){ print($_GET['anol']); }else{ print("$anol"); } ?>"> à <input type="text" name="dial1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($_GET['dial1']){ print($_GET['dial1']); }else{ print("$dial1"); } ?>">/<input type="text" name="mesl1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($_GET['mesl1']){ print($_GET['mesl1']); }else{ print("$mesl1"); } ?>">/<input type="text" name="anol1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php if($_GET['anol1']){ print($_GET['anol1']); }else{ print("$anol1"); } ?>"></td>
    </tr>
<?php
	$query1 = "select * from muraski where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result1 = mysql_query($query1);

	while($not1 = mysql_fetch_array($result1))
	{
	
?>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Imóvel:</b></td>
      <td width="80%" class=style1>Ref.: <?php print("$not1[ref] - $not1[titulo]"); ?></td>
    </tr>
<?php	
	$valor = $not1[valor];
	$total = str_replace(".", "", $valor);
	$total = str_replace(",", ".", $valor);
	$valor = number_format($valor, 2, ',', '.');

?>
    <input type="hidden" name="cod" value="<?php print("$cod"); ?>">
    <input type="hidden" name="l_total" value="<?php print("$total"); ?>">
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Valor:</b></td>
      <td width="80%" class=style1><input type="text" name="valor" value="<?php print("$valor"); ?>" size="10" class="campo"></td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>N° do contrato:</b></td>
      <td width="80%"><input type="text" name="n_contrato" size="10" class="campo" value="<?php print("$n_contrato"); ?>"></td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Tipo de contrato:</b></td>
      <td width="80%" class=style1><select name="tipo_contrato" id="tipo_contrato" class="campo">
		  <option value="">Selecione</option>	
          <option value="Residencial" <? if($tipo_contrato=='Residencial'){ print "SELECTED"; } ?>>Residencial</option>
          <option value="Comercial" <? if($tipo_contrato=='Comercial'){ print "SELECTED"; } ?>>Comercial</option>
          <option value="Não Residencial" <? if($tipo_contrato=='Não Residencial'){ print "SELECTED"; } ?>>Não Residencial</option>
          </select></td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Vigência do contrato:</b></td>
      <td width="80%" class=style1><input type="text" name="vigencia" size="2" class="campo" value="<?php print("$vigencia"); ?>"> meses</td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Vencimento do contrato:</b></td>
      <td width="80%" class=style1><input type="text" name="venc_contrato" id="venc_contrato" size="12" maxlength="10" class="campo" value="<?php print("$venc_contrato"); ?>" onKeyPress="return txtBoxFormat(document.formulario, 'venc_contrato', '##/##/####', event);" onChange="ValidaData(this.value)"> Ex.: 10/10/1910</td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Vencimento do aluguel:</b></td>
      <td width="80%" class=style1><input type="text" name="venc_aluguel" size="2" class="campo" value="<?php print("$venc_aluguel"); ?>"> dia (Exemplo: 01 ou 12)</td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Tolerância de atraso:</b></td>
      <td width="80%" class=style1><input type="text" name="tolerancia" size="2" class="campo" value="<?php print("$tolerancia"); ?>"> dias</td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Bonificação para pagamento em dia:</b></td>
      <td width="80%" class=style1><input type="text" name="bonificacao" size="2" class="campo" value="<?php print("$bonificacao"); ?>">% de desconto</td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Reajustes:</b></td>
      <td width="80%" class=style1><input type="text" name="reajustes" size="2" class="campo" value="<?php print("$reajustes"); ?>"> (Periodicidade: 12/18/24/etc)</td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Índice de reajustes:</b></td>
      <td width="80%" class=style1><input type="text" name="indice" size="10" class="campo" value="<?php print("$indice"); ?>"> (I.G.P. M ou outros)</td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Último/Próximo reajuste:</b></td>
      <td width="80%" class=style1><input type="text" name="ultimo_reajuste" id="ultimo_reajuste" size="12" maxlength="10" class="campo" value="<?php print("$ultimo_reajuste"); ?>" onKeyPress="return txtBoxFormat(document.formulario, 'ultimo_reajuste', '##/##/####', event);" onChange="ValidaData(this.value)"> / <input type="text" name="proximo_reajuste" id="proximo_reajuste" size="12" maxlength="10" class="campo" value="<?php print("$proximo_reajuste"); ?>" onKeyPress="return txtBoxFormat(document.formulario, 'proximo_reajuste', '##/##/####', event);" onChange="ValidaData(this.value)"> Ex.: 10/10/1910</td>
    </tr>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" valign=top class=style1><b>Locatário:</b></td>
      <td width="80%" class=style1><input type="text" name="co_cliente" size="4" class="campo2" readonly> <input type="text" name="nome_cliente" size="40" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo3" onClick="window.open('p_list_clientes.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
        <br><span class="style7">Se o locatário não está cadastrado <a target="_blank" href="p_insert_clientes.php" class="style7">clique aqui</a>.</span></td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="30%" class=style1><b>Fiador:</b></td>
      <td width="70%" class=style1><input type="text" name="fiador" size="4" class="campo2" readonly> <input type="text" name="nome_fiador" size="40" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo3" onClick="window.open('p_list_fiador.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">     
      	<br><span class="style7">Se o fiador não está cadastrado <a target="_blank" href="p_insert_clientes.php" class="style7">clique aqui</a>.</span></td>
	  </td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="30%" class=style1><b>Testemunhas:</b></td>
      <td width="70%" class=style1><input type="text" name="testemunha" size="4" class="campo2" readonly> <input type="text" name="nome_testemunha" size="40" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo3" onClick="window.open('p_list_testemunha.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"><br>
		<input type="text" name="testemunha2" size="4" class="campo2" readonly> <input type="text" name="nome_testemunha2" size="40" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo3" onClick="window.open('p_list_testemunha2.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">  
		<br><span class="style7">Se a testemunha não está cadastrada <a target="_blank" href="p_insert_clientes.php" class="style7">clique aqui</a>.</span></td>
    </tr>
	<tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="20%" class=style1><b>Usuário:</b></td>
      <td width="80%"><input type="text" name="usuario" size="40" class="campo" readonly value="<?php print("$u_nome"); ?>"></td>
    </tr>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td width="100%" colspan=2>
      <input type="hidden" value="<?php print("$not1[cod]"); ?>" name="cod">
      <input type="button" value="Inserir Reserva" class=campo3 name="B1" onClick="return valida();"></td>
    </tr>
  </table>
  </form>
<br>
<table border="0">
<tr><td valign="top">
<?
       $col = 1;
        ## mostra calendarios de 12 meses
        for ($df = 1; $df <= 12; $df++) {
                if (strlen($nextmes) == 1) {
                        $nextmes = "0$nextmes";
                }
                if ($col > 3) {
                        print "</td></tr><tr><td valign='top'>";
                        $col = 1;
                } elseif ($col != 1) {
                        print "</td><td valign='top'>";
                }
                ### monta o calendario
                calendario(${"todasdatas"},"$nextmes/$nextano",$datapermitida,0);
                print "<br>";
                $nextmes++;
                if ($nextmes > 12) {
                        $nextmes = 1;
                        $nextano++;
                }
                $col++;
        }

?>
</td></tr>
</table>
<?
	}
/*	
	}
	else
	{
*/		
?>
<!--Área protegida!-->
<?php
	//}
/*	
mysql_free_result($result1);
mysql_free_result($result3);
*/
mysql_close($con);
?>
</body>
</html>
