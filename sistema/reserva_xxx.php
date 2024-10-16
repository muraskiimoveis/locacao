<?php
//header("Content-Type: text/html;  charset=ISO-8859-1",true);
//header("Content-Type: text/html;  charset=UTF-8",true);
ini_set('session.cache_expire', 1440); // 1440 Minutos = 1 dia
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
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
<head>
<?php
include("style.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
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
  if (document.form1.dia.value == "")
  {
    alert("Por favor, digite o Dia de Entrada");
    document.form1.dia.focus();
    return (false);
  }
  if (document.form1.mes.value == "")
  {
    alert("Por favor, digite o Mês de Entrada");
    document.form1.mes.focus();
    return (false);
  }
  if (document.form1.ano.value == "")
  {
    alert("Por favor, digite o Ano de Entrada");
    document.form1.ano.focus();
    return (false);
  }
  if (document.form1.dia1.value == "")
  {
    alert("Por favor, digite o Dia de Saída");
    document.form1.dia1.focus();
    return (false);
  }
  if (document.form1.mes1.value == "")
  {
    alert("Por favor, digite o Mês de Saída");
    document.form1.mes1.focus();
    return (false);
  }
  if (document.form1.ano1.value == "")
  {
    alert("Por favor, digite o Ano de Saída");
    document.form1.ano1.focus();
    return (false);
  }

  var data1 = document.form1.ano.value + document.form1.mes.value + document.form1.dia.value;
  var data2 = document.form1.ano1.value + document.form1.mes1.value + document.form1.dia1.value;  
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

## verifica os dias locados e os disponíveis para locacao

$query1 = "SELECT * FROM muraski WHERE cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
$result1 = mysql_query($query1);

if($ano == 0){
$ano = substr ($l_data_ent, 6, 4);
$mes = substr($l_data_ent, 3, 2 );
$dia = substr ($l_data_ent, 0, 2 );
$ano1 = substr ($l_data_sai, 6, 4);
$mes1 = substr($l_data_sai, 3, 2 );
$dia1 = substr ($l_data_sai, 0, 2 );
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
        	$nextmes = $mes;
                $nextano = $ano;
                $nextmesano = "$mes/$ano";
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

if($_GET['dia']){
  $dia = $_GET['dia'];
}else{
  $dia = $_POST['dia'];
}

if($_GET['mes']){
  $mes = $_GET['mes'];
}else{
  $mes = $_POST['mes'];
}

if($_GET['ano']){
  $ano = $_GET['ano'];
}else{
  $ano = $_POST['ano'];
}

if($_GET['dia1']){
  $dia1 = $_GET['dia1'];
}else{
  $dia1 = $_POST['dia1'];
}

if($_GET['mes1']){
  $mes1 = $_GET['mes1'];
}else{
  $mes1 = $_POST['mes1'];
}

if($_GET['ano1']){
  $ano1 = $_GET['ano1'];
}else{
  $ano1 = $_POST['ano1'];
}


$data = mktime(0,0,0, $mes, $dia, $ano);
$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);

$total_dias = round(($data1 - $data)/(24*60*60));
$total_dias = $total_dias + 1;

// AKI a partir de 03/11/2011

if(isset($_GET['passagem'])){
  $passagem ='1';
}else{
  if($B1 == "Atualizar Data"){
    $passagem='1';
  }else{$passagem='0';}
}

// Sem uso a funcao ateh o momento.
//$dias = verifica_dias_locado('7',"-7-10-15-");
function verifica_dias_locado($dias_locado, $conteudo_sel){
  $dias_sel = explode("-", $conteudo_sel);
  $dias_contados   = count($dias_sel);

  for ($i3 = 0; $i3 < $dias_contados; $i3++)
  {
    //echo "Mostra FUNCAO ==> ".$dias_sel[$i3]."<BR>";
 	if($dias_locado == $dias_sel[$i3]){
		return $dias_locado;
	}
  }
}

function quant_dias_alocar($dat1, $dat2){
  return round((strtotime($dat2) -
     strtotime($dat1)) / (24 * 60 * 60), 0)+1;
}

$inicio_alocar = $_GET['mes'].'/'.$_GET['dia'].'/'.$_GET['ano']; // data atual
$fim_alocar = $_GET['mes1'].'/'.$_GET['dia1'].'/'.$_GET['ano1'];  // "11/20/2006"; // data no formato mês/dia/ano
$dias_alocar = quant_dias_alocar($inicio_alocar, $fim_alocar);

// Fim AKI

?>
<div align="center">
  <form method="get" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
  <table border="0" cellspacing="1" width="75%">
    <tr height="50">
      <td colspan=2 class="style1"><p align="center"><b>Reservar Imóvel</b></p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class=style1><b>Período:</b></td>
      <td width="80%" class=style1>
      	<input type="text" name="dia" size="2" class="campo" value="<?php print("$dia"); ?>" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" onkeypress="return validarCampoNumerico(event);" />/<input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes"); ?>" onkeypress="return validarCampoNumerico(event);" />/<input type="text" name="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>" onkeypress="return validarCampoNumerico(event);" /> à <input type="text" name="dia1" value="<?php print("$dia1"); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" onkeypress="return validarCampoNumerico(event);" />/<input type="text" name="mes1" value="<?php print("$mes1"); ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" onkeypress="return validarCampoNumerico(event);" />/<input type="text" name="ano1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano1"); ?>" onkeypress="return validarCampoNumerico(event);" /><b> = <?php print("$total_dias"); ?> diárias</b> Ex.: 10/02/1910 à 20/10/1910</td>
    </tr>
    <tr>
      <td width="100%" colspan=2 class=style7>
      <input type="hidden" value="<?php print("$cod"); ?>" name="cod">
      <input type="submit" value="Atualizar Data" class=campo3 name="B1"><b>OBS.: Deve ser clicado sempre que a data for alterada.</b></td>
    </tr>
    </form>
<?php
/*
selecionando o maior valor entre as diarias do imovel
//
SELECT GREATEST(valor,diaria1,diaria2,carnaval,anonovo,feriado) as maior from muraski where ref = '1032a' and cod_imobiliaria = '3'
//
*/
	$query1 = "select GREATEST(valor,diaria1,diaria2,carnaval,anonovo,feriado) as maior, muraski.* from muraski where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result1 = mysql_query($query1);

	while($not1 = mysql_fetch_array($result1))
	{

// Aki
           //$dias = verifica_dias_locado('7',"-7-10-15-");
           $dias_7 = verifica_dias_locado('7',$not1['dias_plocacao']);
           $dias_10 = verifica_dias_locado('10',$not1['dias_plocacao']);
           $dias_15 = verifica_dias_locado('15',$not1['dias_plocacao']);
           if(($dias_7 == "7") and ($dias_alocar < 7) and $passagem == '1'){
?>
           <script language="javascript">alert("LOCAÇÃO mínima para este IMÓVEL 7 (sete) DIAS! Deseja reservar mesmo assim??");</script>
<?php
           }elseif(($dias_10 == "10") and ($dias_alocar < 10) and $passagem == '1'){
?>
           <script language="javascript">alert("LOCAÇÃO mínima para este IMÓVEL 10 (dez) DIAS! Deseja reservar mesmo assim??");</script>
<?php
           }elseif(($dias_15 == "15") and ($dias_alocar < 15) and $passagem == '1'){
?>
           <script language="javascript">alert("LOCAÇÃO mínima para este IMÓVEL 15 (dez) DIAS! Deseja reservar mesmo assim??");</script>
<?php
           }
           //echo "Variaveis ==> [".$dias_7."] - [".$dias_10."] - [".$dias_15."]"."<BR>";
           //echo "Mostra ==> [".$dias_alocar."] -> 7 [".$dias_7."] -> 10 [".$dias_10."] -> 15 [".$dias_15."]";
// Fim aki
?>
    <tr class="fundoTabela">
      <td width="20%" class=style1><b>Imóvel:</b></td>
      <td width="80%" class=style1>Ref.: <?php print("$not1[ref]"); ?> - <?php print strip_tags($not1[titulo]); ?></td>
    </tr>
<script language="javascript">
function ValidaCampos()
{

  if (document.form3.valor.value == "")
  {
    alert("Por favor, digite o Total Diárias");
    document.form3.valor.focus();
    return (false);
  }
  if (document.form3.qtd_parc.value == "")
  {
    alert("Por favor, digite o Qtd. parcelas");
    document.form3.qtd_parc.focus();
    return (false);
  }
  if (document.form3.qtd_parc.value == "0" || document.form3.qtd_parc.value == "00")
  {
    alert("O campo Qtd. parcelas não pode ser zero(0)");
    document.form3.qtd_parc.focus();
    return (false);
  }

  return true;
}


function ValidaQtd()
{

	if (document.form3.qtd_parc.value == "")
  	{
    	alert("Por favor, digite o Qtd. parcelas");
    	document.form3.qtd_parc.focus();
    	return (false);
  	}
	if (document.form3.qtd_parc.value == "0" || document.form3.qtd_parc.value == "00")
  	{
    	alert("O campo Qtd. parcelas não pode ser zero(0)");
    	document.form3.qtd_parc.focus();
    	return (false);
  	}

	document.form3.action='reserva.php';
	document.form3.muda.value='1';
	document.form3.submit();

return true;

}
</script>
    <form method="post" action="<?php print("$PHP_SELF"); ?>" name="form3" onSubmit="return ValidaCampos();">
    <input type="hidden" name="cod" value="<?php print("$cod"); ?>">
    <input type="hidden" name="dia" value="<?php print("$dia"); ?>">
    <input type="hidden" name="mes" value="<?php print("$mes"); ?>">
    <input type="hidden" name="ano" value="<?php print("$ano"); ?>">
    <input type="hidden" name="dia1" value="<?php print("$dia1"); ?>">
    <input type="hidden" name="mes1" value="<?php print("$mes1"); ?>">
    <input type="hidden" name="ano1" value="<?php print("$ano1"); ?>">

<?php
	if($B1 == "Atualizar Valores" || $_POST['muda']=='1'){


      if($_POST['qtd_parc'] >= 1){

        $dataent = date("d/m/Y", mktime(0, 0, 0, $mes, $dia, $ano));
        $val_dataent = date("Y-m-d", mktime(0, 0, 0, $mes, $dia, $ano));
        $val_diadehj = date("Y-m-d");
        $data_parc = array();
        $val_data_parc = array();
        for ($x1 = 1; $x1 <= $_POST['qtd_parc']; $x1++) {
          $data_parc[$x1] = date("d/m/Y", mktime(0,0,0,$mes_parc[$x1],$dia_parc[$x1],$ano_parc[$x1]));
          $val_data_parc[$x1] = date("Y-m-d", mktime(0,0,0,$mes_parc[$x1],$dia_parc[$x1],$ano_parc[$x1]));
          if($val_data_parc[$x1] > $val_dataent){
            echo "<script>alert('Vcto da Parcela Nr. ".$x1." - <".$data_parc[$x1]."> maior que a Data Inicial da Reserva <".$dataent.">');</script>";
          }elseif($val_data_parc[$x1] < $val_diadehj){
            echo "<script>alert('Vcto da Parcela Nr. ".$x1." - <".$data_parc[$x1]."> Invalida. Menor que a Data de Hoje <".date("d/m/Y").">');</script>";            
          }
        }
      
        //echo "<script>alert('Teste');</script>";
      
      }


	$valor = str_replace(".", "", $valor);
	$valor = str_replace(",", ".", $valor);
	//$l_limpeza = str_replace(".", "", $l_limpeza);
	//$l_limpeza = str_replace(",", ".", $l_limpeza);
	//$l_tv = str_replace(".", "", $l_tv);
	//$l_tv = str_replace(",", ".", $l_tv);
	$total_parc = 0;

	$limpeza = $l_limpeza;
	//$tv = $total_dias * $l_tv;

	if($_POST['l_tv']){
	  	$tv = $_POST['l_tv'];
	}else{
	  	$tv = $total_dias * $not1[tv];
	}
	if($tv==0){
	   $tv = '0';
	}
	$total = ($total_dias * $valor);
	$total_contas = ($total_dias * $valor) + $limpeza;

	}
	else
	{
	$limpeza = $not1[limpeza];
	$tv = $total_dias * $not1[tv];
	if($tv==0){
	   $tv = '0';
	}

// Alterado AKI para o maior valor
// A pedido HUGO e Patricia
// 21/11/2012

// Anterior
/*
	$valor = $not1[valor];
	$total = ($total_dias * $not1[valor]);
	$total_contas = ($total_dias * $not1[valor]) + $limpeza;

*/

	$valor = $not1[maior];
	$total = ($total_dias * $not1[maior]);
	$total_contas = ($total_dias * $not1[maior]) + $limpeza;

	if(!$qtd_parc){
		$qtd_parc = 1;
	}

	}

	$total_temp = 0;
	for ($j = 1; $j <= $qtd_parc; $j++) {
		if($marca[$j] == ok){
			$valor_fixo[$j] .= 1;
			$parc_dif = $parc[$j];
			$total_temp = $total_temp + $parc_dif;
					//echo $total_temp;
		}
	}
	$fixo_cnt = count($valor_fixo);

	$divisor = $qtd_parc - $fixo_cnt;

	if($divisor > 0)
	{
		$valor_parc = ($total_contas - $total_temp) / $divisor;
	}

	$valor = number_format($valor, 2, ',', '.');
	$total_contas_tela = number_format($total_contas, 2, ',', '.');
	if($B1 != "Atualizar Valores"){
		$limpeza = number_format($limpeza, 2, ',', '.');
		$tv = number_format($tv, 2, ',', '.');
	}

?>

    <tr class="fundoTabela">
      <td width="20%" class=style1><b>Total Diárias:</b></td>
      <td width="80%" class=style1> (R$ <input type="text" name="valor" value="<?php print("$valor"); ?>" size="10" class="campo"> x <?php print("$total_dias"); ?>) + R$ <?php print("$limpeza"); ?> = <b>R$ <?php print("$total_contas_tela"); ?></b></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class=style1><b>Qtd. de parcelas:</b></td><input type="hidden" id="muda" name="muda" value="0">
      <td width="80%" class=style1> <input type="text" name="qtd_parc" value="<?php print("$qtd_parc"); ?>" size="2" maxlength="2" class="campo" onKeyPress="return validarCampoNumerico(event);" onChange="ValidaQtd();"></td>
    </tr>
<?php
	if($_POST['muda']=='1'){
		  $qtd_parc = $_POST['qtd_parc'];
		}else{
		  $qtd_parc = $qtd_parc;
		}


	//$parc[1] = $valor_parc;
	$valor_parc = number_format($valor_parc, 2, '.', '');

	for ($j = 1; $j <= $qtd_parc; $j++) {
	if((!$parc[$j]) or ($marca[$j] != "ok")){
		$parc[$j] = $valor_parc;
	}elseif(($parc[1] != $valor_parc) and ($marca[1] != "ok")){
		$parc[1] = $valor_parc;
	}
		$total_parc = $parc[$j] + $total_parc;
		//$total_parc = floor($total_parc);
?>
    <tr class="fundoTabela">
      <td colspan=2><table>
      	<tr>
      		<td class=style1>Parcela <?php print("$j"); ?>:  R$ <input type="text" name="parc[<?php print("$j"); ?>]" value="<?php print("$parc[$j]"); ?>" size="10" class="campo"> <input type="checkbox" name="marca[<?php print("$j"); ?>]" value="ok" <?php if($marca[$j] == "ok"){ echo "checked"; } ?>> Fixa valor Data: <input type="text" name="dia_parc[<?php print("$j"); ?>]" size="2" class="campo" value="<?php print("$dia_parc[$j]"); ?>" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" onkeypress="return validarCampoNumerico(event);" />/<input type="text" name="mes_parc[<?php print("$j"); ?>]" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes_parc[$j]"); ?>" onkeypress="return validarCampoNumerico(event);" />/<input type="text" name="ano_parc[<?php print("$j"); ?>]" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano_parc[$j]"); ?>" onkeypress="return validarCampoNumerico(event);" />
      			<select name="forma[<?php print("$j"); ?>]" class=campo>
<?php
	if($forma[$j] != ""){
?>
<option selected value="<?php print("$forma[$j]"); ?>"><?php print("$forma[$j]"); ?></option>
<?php
	}
?>
      				<option value="Depósito">Depósito</option>
      				<option value="Dinheiro">Dinheiro</option>
      				<option value="Cheque">Cheque</option>
              <option value="Boleto">Boleto</option>
      			</select> <input type="text" name="dados_banco[<?php print("$j"); ?>]" value="<?php if($dados_banco[$j] != ""){ print("$dados_banco[$j]"); }else{ if($dados_banco[$j] == "Boleto"){echo "";}else{"Dados do cheque"; } }?>" size="30" class="campo" onFocus="if(this.value=='Dados do cheque')this.value='';"><br><b>OBS.: Preenchimento Obrigatório.</b></td>
    </tr></table></td>
  </tr>
<?php
	}
?>
<?php
	if($total_parc > $total_contas){
		//echo $total_parc . " - " . $total_contas;
?>
    <tr class="fundoTabela">
      <td width="20%"></td>
      <td width="80%" class=style7><b>A soma das parcelas é maior que o valor total das diárias.</b></td>
    </tr>
<?php
	}elseif($total_parc < $total_contas){
		//echo $total_parc . " - " . $total_contas;
?>
    <tr class="fundoTabela">
      <td width="20%"></td>
      <td width="80%" class=style7><b>A soma das parcelas é menor que o valor total das diárias.</b></td>
    </tr>
<?php
	}
?>
    <tr class="fundoTabela">
      <td width="20%" class=style1><b>Taxa Administrativa:</b></td>
      <td width="80%" class=style1> R$ <input type="text" name="l_limpeza" size="10" class="campo" value="<?php print("$limpeza"); ?>"> <select name="forma_limpeza" class=campo>
<?php
	if($forma_limpeza != ""){
?>
<option selected value="<?php print("$forma_limpeza"); ?>"><?php print("$forma_limpeza"); ?></option>
<?php
	}
?>
      				<option value="Depósito">Depósito</option>
      				<option value="Dinheiro">Dinheiro</option>
      				<option value="Cheque">Cheque</option>
              <option value="Boleto">Boleto</option>
      			</select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class=style1><b>Locação de TV:</b></td>
      <td width="80%" class=style1> R$ <input type="text" name="l_tv" size="10" class="campo" value="<?php print("$tv"); ?>"> <select name="forma_tv" class=campo>
<?php
	if($forma_tv != ""){
?>
<option selected value="<?php print("$forma_tv"); ?>"><?php print("$forma_tv"); ?></option>
<?php
	}
?>
      				<option value="Depósito">Depósito</option>
      				<option value="Dinheiro">Dinheiro</option>
      				<option value="Cheque">Cheque</option>
              <option value="Boleto">Boleto</option>
      			</select></td>
    </tr>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td width="100%" colspan=2 class=style7>
      <input type="submit" value="Atualizar Valores" class="campo3" name="B1"> <b>OBS.: Deve ser clicado sempre que algum dado for alterado.</b></td>
    </tr>
    </form>
<script language="javascript">
function valida_usu()
{
  if (document.formulario.usuario.value == "")
  {
    alert("Por favor, selecione o usuário");
    document.formulario.usuario.focus();
    return false;
  }
  }
</script>
    <form method="post" action="p_reserva.php" name="formulario" id="formulario" onSubmit="return valida_usu();">
    <input type="hidden" name="l_total" value="<?php print("$total"); ?>">
    <input type="hidden" name="l_limpeza" value="<?php print("$limpeza"); ?>">
    <input type="hidden" name="forma_limpeza" value="<?php print("$forma_limpeza"); ?>">
    <input type="hidden" name="l_tv" value="<?php print("$tv"); ?>">
    <input type="hidden" name="forma_tv" value="<?php print("$forma_tv"); ?>">
    <input type="hidden" name="qtd_parc" value="<?php print("$qtd_parc"); ?>">
<?php
	for ($j = 1; $j <= $qtd_parc; $j++) {
?>
    <input type="hidden" name="parc[<?php print("$j"); ?>]" value="<?php print("$parc[$j]"); ?>">
    <input type="hidden" name="dia_parc[<?php print("$j"); ?>]" value="<?php print("$dia_parc[$j]"); ?>">
    <input type="hidden" name="mes_parc[<?php print("$j"); ?>]" value="<?php print("$mes_parc[$j]"); ?>">
    <input type="hidden" name="ano_parc[<?php print("$j"); ?>]" value="<?php print("$ano_parc[$j]"); ?>">
    <input type="hidden" name="forma[<?php print("$j"); ?>]" value="<?php print("$forma[$j]"); ?>">
<?php
	}
?>
    <input type="hidden" name="dia" value="<?php print("$dia"); ?>">
    <input type="hidden" name="mes" value="<?php print("$mes"); ?>">
    <input type="hidden" name="ano" value="<?php print("$ano"); ?>">
    <input type="hidden" name="dia1" value="<?php print("$dia1"); ?>">
    <input type="hidden" name="mes1" value="<?php print("$mes1"); ?>">
    <input type="hidden" name="ano1" value="<?php print("$ano1"); ?>">
    <input type="hidden" name="cod" value="<?php print("$cod"); ?>">
    <tr class="fundoTabela">
      <td width="20%" valign=top class=style1><b>Pagamento:</b></td>
      <td width="80%" class=style1><textarea rows="7" name="l_pagto" cols="80" class="campo"><?php print("$l_pagto"); ?>
<?php

	for ($j = 1; $j <= $qtd_parc; $j++) {

		$parc[$j] = number_format($parc[$j], 2, ',', '.');

		if($forma[$j] == "Dinheiro"){
?>
> R$ <?php print("$parc[$j]"); ?> em dinheiro.
<?php
	}elseif($forma[$j] == "Depósito"){
?>
> Depósito no valor de R$ <?php print("$parc[$j]"); ?> a ser efetuado até dia <?php print("$dia_parc[$j]"); ?>/<?php print("$mes_parc[$j]"); ?>/<?php print("$ano_parc[$j]"); ?> <?=$_SESSION['nome_imobiliaria'] ?>, <?=$_SESSION['banco_imo'] ?> Ag.: <?=$_SESSION['agencia_imo'] ?> C/C.: <?=$_SESSION['conta_imo'] ?>.
<?php
	}elseif($forma[$j] == "Cheque"){
?>
> Cheque <?php print("$dados_banco[$j]"); ?> no valor de R$ <?php print("$parc[$j]"); ?> para dia <?php print("$dia_parc[$j]"); ?>/<?php print("$mes_parc[$j]"); ?>/<?php print("$ano_parc[$j]"); ?>.
<?php
	}elseif($forma[$j] == "Boleto"){
?>
> Boleto <?php print("$dados_banco[$j]"); ?> no valor de R$ <?php print("$parc[$j]"); ?> com vencimento em <?php print("$dia_parc[$j]"); ?>/<?php print("$mes_parc[$j]"); ?>/<?php print("$ano_parc[$j]"); ?>.
<?php
  }
	}
?>
<?php
if(!empty($forma)){
	if ((in_array("Depósito", $forma)) and (in_array("Cheque", $forma))) {

		//echo "Depósito no valor de R$ 100,00 a ser efetuado até dia 10/05/2007 em favor de Muraski Imóveis Ltda, Banco do Brasil Ag.: 2.100-8 C/C.: 44210-0 e Cheque nº 00050 da Ag.: 3733 da C/C.: 10610-2 do banco Itaú no valor de R$ 1.080,00 para dia 01/05/2007. A confirmação da reserva só é realizada após a compensação dos depósitos ou / e cheques.\n";
	}

	if (in_array("Depósito", $forma)) {
		//echo "A confirmação da reserva só é realizada após a compensação dos depósitos.";
	}
}
?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" valign=top class=style1><b>Locatário:</b></td>
      <td width="80%" class=style1>
         <input type="text" name="co_cliente" size="4" class="campo2" readonly>
         <input type="text" name="nome_cliente" size="40" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=formulario&t_cod=4&c_campo=co_cliente&n_campo=nome_cliente', 'janela', 750, 500, 'yes');">
        <br><span class="style7">Se o locatário não está cadastrado <a href="#" onClick="NewWindow('p_insert_clientes.php?novo=S&url=p_insert_clientes.php?novo=S','uprelatorio','800','600','yes');" class=style7><b>clique aqui</b></a>.</span></td>
    </tr>
	<tr class="fundoTabela">
      <td width="20%" class=style1><b>Usuário:</b></td>
      <td width="80%"><input type="text" name="usuario" size="40" class="campo" readonly value="<?php print("$u_nome"); ?>"></td>
    </tr>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td width="100%" colspan=2>
      <input type="hidden" value="<?php print("$not1[cod]"); ?>" name="cod">
      <input type="submit" value="Inserir Reserva" class=campo3 name="B1"></td>
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
