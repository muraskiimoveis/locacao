<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
//include("calendario2.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_VEND");
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
<script type="text/javascript" src="funcoes/js.js"></script>  
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

if (($ano == 0) && ($l_data_ent <> "")) {
   $ano = substr ($l_data_ent, 6, 4);
   $mes = substr($l_data_ent, 3, 2 );
   $dia = substr ($l_data_ent, 0, 2 );
   $ano1 = substr ($l_data_sai, 6, 4);
   $mes1 = substr($l_data_sai, 3, 2 );
   $dia1 = substr ($l_data_sai, 0, 2 );
}

while($not1 = mysql_fetch_assoc($result1)) {

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
   $indicadores = $not1['indicador'];

   if($not1[tipo_anga]<>''){

      $com_angariador = $not1[tipo_anga];

   } else {
   	$comissoesa = mysql_query("SELECT comissao_angariador FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");

      while($linhaa = mysql_fetch_array($comissoesa)){
         $com_angariador = $linhaa[comissao_angariador];
      }
   }

   if($not1[comissao_indicador]<>'' && $not1['indicador']<>'0'){
     	$com_indicador = $not1[comissao_indicador];
   } elseif($not1['indicador']<>'0') {
      $comissoesi = mysql_query("SELECT comissao_indicador FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
      while($linhai = mysql_fetch_array($comissoesi)){
         $com_indicador = $linhai[comissao_indicador];
      }
   }

   if($not1[comissao_vendedor]<>''){
      $com_vendedor = $not1[comissao_vendedor];
   } else {
      $comissoesv = mysql_query("SELECT comissao_vendedor FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
      while($linhav = mysql_fetch_array($comissoesv)){
         $com_vendedor = $linhav[comissao_vendedor];
      }
   }

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

   if($numrows3 > 0) {

	   while($not3 = mysql_fetch_array($result3)) {

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

$data = mktime(0,0,0, $mes, $dia, $ano);
$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);

$total_dias = round(($data1 - $data)/(24*60*60));
$total_dias = $total_dias + 1;
?>
<div align="center">
  <center>
  <form method="get" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
  <table border="0" cellspacing="1" width="95%">
    <tr height="50">
      <td width="100%" colspan=2 class="style1"><p align="center"><b>Vender Imóvel</b></p></td>
    </tr>
</form>
<?php
	$query1 = "select * from muraski where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result1 = mysql_query($query1);

	while ($not1 = mysql_fetch_array($result1)) {

      $query10 = "select * from sinal_venda where cod_imovel='$cod' and cod_cliente='$compr' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and s_status='A'";
      $result10 = mysql_query($query10);

      while ($not10 = mysql_fetch_array($result10)) {

         $co_cliente = $not10['cod_cliente'];

         //REALIZA BUSCA DO NOME DO COMPRADOR
         $queryC = "select * from clientes where c_cod='$co_cliente' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
         $resultC = mysql_query($queryC);
         while($notC = mysql_fetch_array($resultC)) {
            $nome_cliente = $notC['c_nome'];
         }

?>
    <tr class="fundoTabela">
      <td width="40%" class=style1><b>Imóvel:</b></td>
      <td width="60%" class=style1><!--a target="_blank" href="detalhes.php?cod=<?php print("$cod"); ?>" class="style1"--> Ref.: <?php print("$not1[ref]"); ?> - <?php echo strip_tags($not1[titulo]); ?><!--/a--></td>
    </tr>
    <form method="post" action="<?php print("$PHP_SELF"); ?>" name="form3">
    <input type="hidden" name="cod" value="<?php print("$cod"); ?>">
    <input type="hidden" name="compr" value="<?php print("$compr"); ?>">
<?php
         if ($B1 == "Atualizar Valores") {

            //$valor = str_replace(".", "", $valor);
            //$valor = str_replace(",", ".", $valor);
            $l_limpeza = str_replace(".", "", $l_limpeza);
            $l_limpeza = str_replace(",", ".", $l_limpeza);
            $l_tv = str_replace(".", "", $l_tv);
            $l_tv = str_replace(",", ".", $l_tv);
            $total_parc = 0;

            $limpeza = $l_limpeza;
            $tv = $total_dias * $l_tv;
            //$total = ($total_dias * $valor);
            //$total = $valor;
            $totais = explode(".00", $valor);
//            $total = $totais[0];
            $total = str_replace(",",".",$_POST[valor]);
            $total_contas = ($total_dias * $valor) + $limpeza;

         } else {

            $limpeza = $not1[limpeza];
            $tv = $total_dias * $not1[tv];
            $valores = explode(".00", $not10[valor_venda]);
            $valor = $valores[0];

            //$total = ($total_dias * $not10[valor_venda]);
            $totais = explode(".00", $not10[valor_venda]);
            $total = $totais[0];
            $total_contas = ($total_dias * $not10[valor_venda]) + $limpeza;

                 if (!$qtd_parc) {
               $qtd_parc = 1;
            }
         }

         $total_temp = 0;

         for ($j = 1; $j <= $qtd_parc; $j++) {
            if($marca[$j] == ok){

               $valor_fixo[$j] .= 1;
               $parc_dif = $parc[$j];
               $total_temp = $total_temp + $parc_dif;

            }
         }

         $fixo_cnt = count($valor_fixo);

         $valor_parc = ($valor - $total_temp) / ($qtd_parc - $fixo_cnt);

	 	 $valor = $valor;
         $total_contas_tela = number_format($total_contas, 2, ',', '.');
         $limpeza = number_format($limpeza, 2, ',', '.');
         $tv = number_format($tv, 2, ',', '.');
         $valores2 = explode(".00", $not10[valor_venda]);
         $valor2 = $valores2[0];
         $com = $not1[comissao];

         $l_comissao = $total * $com/100;
          if ($muda == "1" || $B1 == "Atualizar Valores") {
         	$comissao = $_POST[comissao];
         	$comissao = str_replace(".", "", $comissao);
         	$comissao = str_replace(",", ".", $comissao);
		 }else{
          	$comissao = $l_comissao;
         	$comissao = str_replace(".", "", $comissao);
         	$comissao = str_replace(",", ".", $comissao);
		 }

         if($comissao <> ""){
            $l_comissao = $comissao;
         }

         $valor_vendedor = $comissao * $com_vendedor/100;
         $valor_indicador = $comissao * $com_indicador/100;
         $valor_angariador = $comissao * $com_angariador/100;
		 $comissao = number_format($l_comissao, 2, ',', '.');		 
         
        if($muda == "1" || $B1 == "Atualizar Valores") {
         	  
         	
			if($muda=="1" && $B1 <> "Atualizar Valores"){
			 
				$valor_parc_a = ($valor_angariador / $qtdparc);  
				$valor_parc_v = ($valor_vendedor / $qtdparc); 
				$valor_parc_i = ($valor_indicador / $qtdparc);   
				
			}elseif($muda=="1" && $B1 == "Atualizar Valores"){
			  	
			  	$valor_parc_a = ($valor_angariador / $qtdparc);  
				$valor_parc_v = ($valor_vendedor / $qtdparc); 
				$valor_parc_i = ($valor_indicador / $qtdparc);
						
			}elseif($muda<>"1" && $B1 == "Atualizar Valores"){
			  	
				$valor_parc_a2 = $valor_angariador;  
				$valor_parc_v2 = $valor_vendedor; 
				$valor_parc_i2 = $valor_indicador; 
			
				$total_tempa = 0;

         		for ($j = 1; $j <= $qtdparc; $j++) {
            		if($marcaa[$j] == ok){
               			$valor_fixoa[$j] .= 1;
               			$parc_difa = $parca[$j];
               			$total_tempa = $total_tempa + $parc_difa;
            		}
         		}
         		$fixo_cnta = count($valor_fixoa);         	
         		$valor_parc_a = ($valor_parc_a2 - $total_tempa) / ($qtdparc - $fixo_cnta); 

         		$total_tempv = 0;

         		for ($j = 1; $j <= $qtdparc; $j++) {
            		if($marcav[$j] == ok){
               			$valor_fixov[$j] .= 1;
               			$parc_difv = $parcv[$j];
               			$total_tempv = $total_tempv + $parc_difv;
            		}
         		}
         		$fixo_cntv = count($valor_fixov);
         		$valor_parc_v = ($valor_parc_v2 - $total_tempv) / ($qtdparc - $fixo_cntv); 

				$total_tempi = 0;

         		for ($j = 1; $j <= $qtdparc; $j++) {
            		if($marcai[$j] == ok){
               			$valor_fixoi[$j] .= 1;
               			$parc_difi = $parci[$j];
               			$total_tempi = $total_tempi + $parc_difi;
            		}
         		}
         		$fixo_cnti = count($valor_fixoi);
         		$valor_parc_i = ($valor_parc_i2 - $total_tempi) / ($qtdparc - $fixo_cnti); 	 
   			}
        
		}else{
                    
         	$valor_parc_v = $valor_vendedor;
         	$valor_parc_i = $valor_indicador;
         	$valor_parc_a = $valor_angariador;
		  
		  	if (!$qtdparc) {
               $qtdparc = 1;
            }
            
		}
		
		


?>
    <tr class="fundoTabela">
      <td width="40%" class=style1><b>Total do Imóvel:</b></td>
      <td width="60%" class=style1> R$ <input type="text" name="valor" value="<?php print("$valor"); ?>" size="12" class="campo">
      </td>
    </tr>
	   <tr class="fundoTabela">
      <td width="40%" class=style1><b>Comissão Imobiliária:</b></td>
      <td width="60%" class=style1> <input type="text" name="comissao" value="<?php print("$comissao"); ?>" size="12" class="campo"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="40%" class=style1><b>Qtd. parcelas Comissões:</b></td><input type="hidden" id="muda" name="muda" value="0">
      <td width="60%" class=style1> <input type="text" name="qtdparc" value="<?php print("$qtdparc"); ?>" size="2" class="campo" onKeyPress="return validarCampoNumerico(event);" onChange="form3.action='venda.php';form3.muda.value='1';form3.submit();"></td>
    </tr>
    <tr class="fundoTabela">
      <td colspan="2" class=style1><b>Comissão Angariador:</b></td>
    </tr>
<?php
        if($_POST['muda']=='1' || $B1 == "Atualizar Valores"){
		  $qtdparc = $_POST['qtdparc'];
		}else{
		  $qtdparc = $qtdparc;
		}


        $valor_parc_a = number_format($valor_parc_a, 2, '.', '');

		for ($j = 1; $j <= $qtdparc; $j++) {
			if((!$parca[$j]) or ($marcaa[$j] != "ok")){
				$parca[$j] = $valor_parc_a;
			}elseif(($parca[1] != $valor_parc_a) and ($marcaa[1] != "ok")){
				$parca[1] = $valor_parc_a;
			}
				$total_parc_a = $parca[$j] + $total_parc_a;
		 
		 
		 /*
		 for ($j = 1; $j <= $qtdparc; $j++) {
	        
		 if ($B1 == "Atualizar Valores") {
		    if($comissao_ori <> $comissao){
				$parca[$j] = number_format($valor_parc_a, 2, '.', '');			
			}else{
			  	$parca[$j] = number_format($parca[$j], 2, '.', '');			
			}
		 }else{
		   $parca[$j] = number_format($valor_parc_a, 2, '.', '');
		 }
		 */
			
			/*
			if ((!$parca[$j])) {
               $parca[$j] = $valor_parc_a;
            } elseif(($parca[1] != $valor_parc_a)) {
               $parca[1] = $valor_parc_a;
            }
            */
            
?>
    <tr class="fundoTabela">
      <td colspan=2><table>
      	<tr>
      		<td class=style1>Parcela <?php print("$j"); ?>:  R$ <input type="text" name="parca[<?php print("$j"); ?>]" value="<?php print("$parca[$j]"); ?>" size="10" class="campo"> <input type="checkbox" name="marcaa[<?php print("$j"); ?>]" value="ok" <?php if($marcaa[$j] == "ok"){ echo "checked"; } ?>> Fixa valor
			  Data: <input type="text" name="dia_parca[<?php print("$j"); ?>]" size="2" class="campo" value="<?php print("$dia_parca[$j]"); ?>" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes_parca[<?php print("$j"); ?>]" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes_parca[$j]"); ?>">/<input type="text" name="ano_parca[<?php print("$j"); ?>]" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano_parca[$j]"); ?>">
      		  <select name="formaa[<?php print("$j"); ?>]" class="campo">
<?php
            if ($formaa[$j] != "") {
?>
<option selected value="<?php print("$formaa[$j]"); ?>"><?php print("$formaa[$j]"); ?></option>
<?php
            }
?>
      				<option value="Depósito">Depósito</option>
      				<option value="Dinheiro">Dinheiro</option>
      				<option value="Cheque">Cheque</option>
      			</select>  <input type="text" name="dados_bancoa[<?php print("$j"); ?>]" value="<?php if($dados_bancoa[$j] != ""){ print("$dados_bancoa[$j]"); }else{ print "Dados do cheque"; } ?>" size="30" class="campo" onFocus="if(this.value=='Dados do cheque')this.value='';"><br><b>OBS.: Preenchimento Obrigatório.</b></td>
    	</tr>
	 </table></td>
  </tr>
<?
	 }
?>
	<tr class="fundoTabela">
      <td colspan="2" class=style1><b>Comissão Vendedor:</b></td>
    </tr>
<?php
         if($_POST['muda']=='1' || $B1 == "Atualizar Valores"){
		  $qtdparc = $_POST['qtdparc'];
		}else{
		  $qtdparc = $qtdparc;
		}
         
		$valor_parc_v = number_format($valor_parc_v, 2, '.', '');

		for ($j = 1; $j <= $qtdparc; $j++) {
			if((!$parcv[$j]) or ($marcav[$j] != "ok")){
				$parcv[$j] = $valor_parc_v;
			}elseif(($parcv[1] != $valor_parc_v) and ($marcav[1] != "ok")){
				$parcv[1] = $valor_parc_v;
			}
				$total_parc_v = $parcv[$j] + $total_parc_v;	
         /*
		 for ($j = 1; $j <= $qtdparc; $j++) {
	        
	     if ($B1 == "Atualizar Valores") {
		    $valor_parc_v = number_format($parcv[$j], 2, '.', '');			
		 }else{
		   $valor_parc_v = number_format($valor_parc_v, 2, '.', '');
		 }
		 */
			
			/*
			 if ((!$parcv[$j])) {
               $parcv[$j] = $valor_parc_v;
            } elseif(($parcv[1] != $valor_parc_v)) {
               $parcv[1] = $valor_parc_v;
            }
            */
?>
    <tr class="fundoTabela">
      <td colspan=2><table>
      	<tr>
      		<td class=style1>Parcela <?php print("$j"); ?>:  R$ <input type="text" name="parcv[<?php print("$j"); ?>]" value="<?php print("$parcv[$j]"); ?>" size="10" class="campo"> <input type="checkbox" name="marcav[<?php print("$j"); ?>]" value="ok" <?php if($marcav[$j] == "ok"){ echo "checked"; } ?>> Fixa valor 
			  Data: <input type="text" name="dia_parcv[<?php print("$j"); ?>]" size="2" class="campo" value="<?php print("$dia_parcv[$j]"); ?>" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes_parcv[<?php print("$j"); ?>]" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes_parcv[$j]"); ?>">/<input type="text" name="ano_parcv[<?php print("$j"); ?>]" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano_parcv[$j]"); ?>">
      		  <select name="formav[<?php print("$j"); ?>]" class="campo">
<?php
            if ($formav[$j] != "") {
?>
<option selected value="<?php print("$formav[$j]"); ?>"><?php print("$formav[$j]"); ?></option>
<?php
            }
?>
      				<option value="Depósito">Depósito</option>
      				<option value="Dinheiro">Dinheiro</option>
      				<option value="Cheque">Cheque</option>
      			</select>  <input type="text" name="dados_bancov[<?php print("$j"); ?>]" value="<?php if($dados_bancov[$j] != ""){ print("$dados_bancov[$j]"); }else{ print "Dados do cheque"; } ?>" size="30" class="campo" onFocus="if(this.value=='Dados do cheque')this.value='';"><br><b>OBS.: Preenchimento Obrigatório.</b></td>
    	</tr>
	 </table></td>
  </tr>
<?
	 }
?>  
<? if($indicadores <> '0'){ ?>
	<tr class="fundoTabela">
      <td colspan="2" class=style1><b>Comissão Indicador:</b></td>
    </tr>
<?php
		 if($_POST['muda']=='1' || $B1 == "Atualizar Valores"){
		  $qtdparc = $_POST['qtdparc'];
		}else{
		  $qtdparc = $qtdparc;
		}	
		 
		 $valor_parc_i = number_format($valor_parc_i, 2, '.', '');

		for ($j = 1; $j <= $qtdparc; $j++) {
			if((!$parci[$j]) or ($marcai[$j] != "ok")){
				$parci[$j] = $valor_parc_i;
			}elseif(($parci[1] != $valor_parc_i) and ($marcai[1] != "ok")){
				$parci[1] = $valor_parc_i;
			}
				$total_parc_i = $parci[$j] + $total_parc_i;	
		 
		 /*
		 for ($j = 1; $j <= $qtdparc; $j++) {
		   
		 if ($B1 == "Atualizar Valores") {
		    $valor_parc_i = number_format($parci[$j], 2, '.', '');			
		 }else{
		   $valor_parc_i = number_format($valor_parc_i, 2, '.', '');
		 }
		 */
		   
	     /*
		     if ((!$parci[$j])) {
               $parci[$j] = $valor_parc_i;
            } elseif(($parci[1] != $valor_parc_i)) {
               $parci[1] = $valor_parc_i;
            }
        */
?>
    <tr class="fundoTabela">
      <td colspan=2><table>
      	<tr>
      		<td class=style1>Parcela <?php print("$j"); ?>:  R$ <input type="text" name="parci[<?php print("$j"); ?>]" value="<?php print("$parci[$j]"); ?>" size="10" class="campo"> <input type="checkbox" name="marcai[<?php print("$j"); ?>]" value="ok" <?php if($marcai[$j] == "ok"){ echo "checked"; } ?>> Fixa valor
			  Data: <input type="text" name="dia_parci[<?php print("$j"); ?>]" size="2" class="campo" value="<?php print("$dia_parci[$j]"); ?>" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes_parci[<?php print("$j"); ?>]" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes_parci[$j]"); ?>">/<input type="text" name="ano_parci[<?php print("$j"); ?>]" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano_parci[$j]"); ?>">
      		  <select name="formai[<?php print("$j"); ?>]" class="campo">
<?php
            if ($formai[$j] != "") {
?>
<option selected value="<?php print("$formai[$j]"); ?>"><?php print("$formai[$j]"); ?></option>
<?php
            }
?>
      				<option value="Depósito">Depósito</option>
      				<option value="Dinheiro">Dinheiro</option>
      				<option value="Cheque">Cheque</option>
      			</select>  <input type="text" name="dados_bancoi[<?php print("$j"); ?>]" value="<?php if($dados_bancoi[$j] != ""){ print("$dados_bancoi[$j]"); }else{ print "Dados do cheque"; } ?>" size="30" class="campo" onFocus="if(this.value=='Dados do cheque')this.value='';"><br><b>OBS.: Preenchimento Obrigatório.</b></td>
    	</tr>
	 </table></td>
  </tr>
<?
	 }
}
?>  
	 <!--tr class="fundoTabela">
      <td width="40%" class=style1><b>Comissão Angariador:</b></td>
      <td width="60%" class=style1> <input type="text" name="valora" value="<?php print("$valora"); ?>" size="12" class="campo"></td>
    </tr-->
	 <!--tr class="fundoTabela">
      <td width="40%" class=style1><b>Comissão Indicador:</b></td>
      <td width="60%" class=style1> <input type="text" name="valori" value="<?php print("$valori"); ?>" size="12" class="campo"></td>
    </tr-->
	 <!--tr class="fundoTabela">
      <td width="40%" class=style1><b>Comissão Vendedor:</b></td>
      <td width="60%" class=style1> <input type="text" name="valorv" value="<?php print("$valorv"); ?>" size="12" class="campo"></td>
    </tr-->
    <input type="hidden" name="qtd_parc" value="<?php print("$qtd_parc"); ?>" size="2" class="campo" readonly>
    <!--tr class="fundoTabela">
      <td width="40%" class=style1><b>Qtd. de parcelas:</b></td>
      <td width="60%" class=style1> <input type="text" name="qtd_parc" value="<?php print("$qtd_parc"); ?>" size="2" class="campo"></td>
    </tr-->
<?php
         //$parc[1] = $valor_parc;
         $valor_parc = number_format($valor_parc, 2, '.', '');

         for ($j = 1; $j <= $qtd_parc; $j++) {
	         if ((!$parc[$j]) or ($marca[$j] != "ok")) {
               $parc[$j] = $valor_parc;
            } elseif(($parc[1] != $valor_parc) and ($marca[1] != "ok")) {
               $parc[1] = $valor_parc;
            }
               $total_parc = $parc[$j] + $total_parc;
               //$total_parc = floor($total_parc);
?>
    <!--tr class="fundoTabela">
      <td colspan=2><table>
      	<tr>
      		<td class=style1>Parcela <?php print("$j"); ?>:  R$ <input type="text" name="parc[<?php print("$j"); ?>]" value="<?php print("$parc[$j]"); ?>" size="10" class="campo"> <input type="checkbox" name="marca[<?php print("$j"); ?>]" value="ok" <?php if($marca[$j] == "ok"){ print "checked"; } ?>> Fixa valor Data: <input type="text" name="dia_parc[<?php print("$j"); ?>]" size="2" class="campo" value="<?php print("$dia_parc[$j]"); ?>" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes_parc[<?php print("$j"); ?>]" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes_parc[$j]"); ?>">/<input type="text" name="ano_parc[<?php print("$j"); ?>]" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano_parc[$j]"); ?>">
      			<select name="forma[<?php print("$j"); ?>]" class=campo size=1>
<?php
            if ($forma[$j] != "") {
?>
<option selected value="<?php print("$forma[$j]"); ?>"><?php print("$forma[$j]"); ?></option>
<?php
            }
?>
      				<option value="Depósito">Depósito</option>
      				<option value="Dinheiro">Dinheiro</option>
      				<option value="Cheque">Cheque</option>
      			</select> <input type="text" name="dados_banco[<?php print("$j"); ?>]" value="<?php if($dados_banco[$j] != ""){ print("$dados_banco[$j]"); }else{ print "Dados do cheque"; } ?>" size="30" class="campo" onFocus="if(this.value=='Dados do cheque')this.value='';"><br><b>OBS.: Preenchimento Obrigatório.</b></td>
    </tr></table></td>
  </tr-->

		  <tr class="fundoTabela">
      		<td class=style1><b>Data Venda:</b></td>
			<td class="style1"><input type="text" name="dia_parc[<?php print("$j"); ?>]" size="2" class="campo" value="<?php print("$dia_parc[$j]"); ?>" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes_parc[<?php print("$j"); ?>]" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes_parc[$j]");  ?>">/<input type="text" name="ano_parc[<?php print("$j"); ?>]" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano_parc[$j]"); ?>"> <b>OBS.: Preenchimento Obrigatório.</b></td>
        </tr>
		<!--tr class="fundoTabela">
		  <td class="style1"><b>Forma de pagamento:</b></td>
           <td class="style1"><select name="forma[<?php print("$j"); ?>]" class="campo">
<?php
            if ($forma[$j] != "") {
?>
<option selected value="<?php print("$forma[$j]"); ?>"><?php print("$forma[$j]"); ?></option>
<?php
            }
?>
      				<option value="Depósito">Depósito</option>
      				<option value="Dinheiro">Dinheiro</option>
      				<option value="Cheque">Cheque</option>
      			</select>  <input type="text" name="dados_banco[<?php print("$j"); ?>]" value="<?php if($dados_banco[$j] != ""){ print("$dados_banco[$j]"); }else{ print "Dados do cheque"; } ?>" size="30" class="campo" onFocus="if(this.value=='Dados do cheque')this.value='';"><br><b>OBS.: Preenchimento Obrigatório.</b></td>
    </tr-->
<?php
         }
?>
    <tr>
      <td width="100%" colspan=2 class=style1>
      <input type="submit" value="Atualizar Valores" class=campo3 name="B1"> <b>OBS.: Deve ser clicado sempre que algum dado for alterado.</b></td>
    </tr>
    </form>
<script language="javascript">
function valida_usu()
{
  if (document.formulario.usuario.value == "")
  {
    alert("Por favor, selecione o usuário");
    document.formulario.usuario.focus();
    return (false);
  }
  }
</script>
    <form method="post" action="p_venda.php" name="formulario" id="formulario" onSubmit="return valida_usu();">
    <input type="hidden" name="l_total" value="<?php print("$total"); ?>">
    <input type="hidden" name="l_comissao" value="<?php print("$l_comissao"); ?>">
    <input type="hidden" name="valor_indicador" value="<?php print("$valor_indicador"); ?>">
    <input type="hidden" name="valor_vendedor" value="<?php print("$valor_vendedor"); ?>">
    <input type="hidden" name="valor_angariador" value="<?php print("$valor_angariador"); ?>">
    <input type="hidden" name="qtd_parc" value="<?php print("$qtd_parc"); ?>">
    <input type="hidden" name="qtdparc" value="<?php print("$qtdparc"); ?>">
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
<?php
         for ($j = 1; $j <= $qtdparc; $j++) {
?>
    <input type="hidden" name="parca[<?php print("$j"); ?>]" value="<?php print("$parca[$j]"); ?>">
    <input type="hidden" name="dia_parca[<?php print("$j"); ?>]" value="<?php print("$dia_parca[$j]"); ?>">
    <input type="hidden" name="mes_parca[<?php print("$j"); ?>]" value="<?php print("$mes_parca[$j]"); ?>">
    <input type="hidden" name="ano_parca[<?php print("$j"); ?>]" value="<?php print("$ano_parca[$j]"); ?>">
    <input type="hidden" name="parcv[<?php print("$j"); ?>]" value="<?php print("$parcv[$j]"); ?>">
    <input type="hidden" name="dia_parcv[<?php print("$j"); ?>]" value="<?php print("$dia_parcv[$j]"); ?>">
    <input type="hidden" name="mes_parcv[<?php print("$j"); ?>]" value="<?php print("$mes_parcv[$j]"); ?>">
    <input type="hidden" name="ano_parcv[<?php print("$j"); ?>]" value="<?php print("$ano_parcv[$j]"); ?>">
    <input type="hidden" name="parci[<?php print("$j"); ?>]" value="<?php print("$parci[$j]"); ?>">
    <input type="hidden" name="dia_parci[<?php print("$j"); ?>]" value="<?php print("$dia_parci[$j]"); ?>">
    <input type="hidden" name="mes_parci[<?php print("$j"); ?>]" value="<?php print("$mes_parci[$j]"); ?>">
    <input type="hidden" name="ano_parci[<?php print("$j"); ?>]" value="<?php print("$ano_parci[$j]"); ?>">
    <input type="hidden" name="indicadores" value="<?php print("$indicadores"); ?>">
<?php
         }
?>
    <input type="hidden" name="cod" value="<?php print("$cod"); ?>">
    <tr class="fundoTabela">
      <td width="40%" valign=top class=style1><b>Pagamento:</b></td>
      <td width="60%" class=style1><textarea rows="7" name="l_pagto" cols="80" class="campo"><?php print("$l_pagto"); ?>

<?php

         for ($j = 1; $j <= $qtdparc; $j++) {
           
            $parca[$j] = number_format($parca[$j], 2, ',', '.');

            if ($formaa[$j] == "Dinheiro") {
?>

Angariador: > R$ <?php print("$parca[$j]"); ?> em dinheiro.
<?php
            } elseif ($formaa[$j] == "Depósito") {
?>

Angariador: > Depósito no valor de R$ <?php print("$parca[$j]"); ?> a ser efetuado até dia <?php print("$dia_parca[$j]"); ?>/<?php print("$mes_parca[$j]"); ?>/<?php print("$ano_parca[$j]"); ?> <?=$_SESSION['nome_imobiliaria'] ?>, <?=$_SESSION['banco_imo'] ?> Ag.: <?=$_SESSION['agencia_imo'] ?> C/C.: <?=$_SESSION['conta_imo'] ?>.
<?php
            } elseif($formaa[$j] == "Cheque") {
?>

Angariador: > Cheque <?php print("$dados_bancoa[$j]"); ?> no valor de R$ <?php print("$parca[$j]"); ?> para dia <?php print("$dia_parca[$j]"); ?>/<?php print("$mes_parca[$j]"); ?>/<?php print("$ano_parca[$j]"); ?>.
<?php
            }
		}
        for ($j = 1; $j <= $qtdparc; $j++) {
          
          $parcv[$j] = number_format($parcv[$j], 2, ',', '.');
                
        	if ($formav[$j] == "Dinheiro") {
?>

Vendedor: > R$ <?php print("$parcv[$j]"); ?> em dinheiro.
<?php
            } elseif ($formav[$j] == "Depósito") {
?>

Vendedor: > Depósito no valor de R$ <?php print("$parcv[$j]"); ?> a ser efetuado até dia <?php print("$dia_parcv[$j]"); ?>/<?php print("$mes_parcv[$j]"); ?>/<?php print("$ano_parcv[$j]"); ?> <?=$_SESSION['nome_imobiliaria'] ?>, <?=$_SESSION['banco_imo'] ?> Ag.: <?=$_SESSION['agencia_imo'] ?> C/C.: <?=$_SESSION['conta_imo'] ?>.
<?php
            } elseif($formav[$j] == "Cheque") {
?>

Vendedor: > Cheque <?php print("$dados_bancov[$j]"); ?> no valor de R$ <?php print("$parcv[$j]"); ?> para dia <?php print("$dia_parcv[$j]"); ?>/<?php print("$mes_parcv[$j]"); ?>/<?php print("$ano_parcv[$j]"); ?>.
<?php
            }
        }
        for ($j = 1; $j <= $qtdparc; $j++) {
          
          $parci[$j] = number_format($parci[$j], 2, ',', '.');
          
            if ($formai[$j] == "Dinheiro") {
?>

Indicador: > R$ <?php print("$parci[$j]"); ?> em dinheiro.
<?php
            } elseif ($formai[$j] == "Depósito") {
?>

Indicador: > Depósito no valor de R$ <?php print("$parci[$j]"); ?> a ser efetuado até dia <?php print("$dia_parci[$j]"); ?>/<?php print("$mes_parci[$j]"); ?>/<?php print("$ano_parci[$j]"); ?> <?=$_SESSION['nome_imobiliaria'] ?>, <?=$_SESSION['banco_imo'] ?> Ag.: <?=$_SESSION['agencia_imo'] ?> C/C.: <?=$_SESSION['conta_imo'] ?>.
<?php
            } elseif($formai[$j] == "Cheque") {
?>

Indicador: > Cheque <?php print("$dados_bancoi[$j]"); ?> no valor de R$ <?php print("$parci[$j]"); ?> para dia <?php print("$dia_parci[$j]"); ?>/<?php print("$mes_parci[$j]"); ?>/<?php print("$ano_parci[$j]"); ?>.
<?php
            }
         }
?>
<?php
/*
         if (!empty($forma)) {
            if ((in_array("Depósito", $forma)) and (in_array("Cheque", $forma))) {
               print "Depósito no valor de R$ 100,00 a ser efetuado até dia 10/05/2007 em favor de Muraski Imóveis Ltda, Banco do Brasil Ag.: 2.100-8 C/C.: 44210-0 e Cheque nº 00050 da Ag.: 3733 da C/C.: 10610-2 do banco Itaú no valor de R$ 1.080,00 para dia 01/05/2007. A confirmação da reserva só é realizada após a compensação dos depósitos ou / e cheques.\n";
            }
            if (in_array("Depósito", $forma)) {
               print "A confirmação da reserva só é realizada após a compensação dos depósitos.";
            }
         }
*/
?>
</textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td width="40%" valign=top class=style1><b>Comprador:</b></td>
      <td width="60%" class=style1><input type="text" name="co_cliente" size="4" class="campo2" value="<?=$co_cliente; ?>" readonly> <input type="text" name="nome_cliente" size="40" class="campo" value="<?=$nome_cliente; ?>" readonly></td>
    </tr>
	</tr>
	<tr class="fundoTabela">
      <td width="40%" class=style1><b>Vendedor:</b></td>
      <td width="60%" class="style1"><select name="usuario" id="usuario" class=campo>
        <?
         $vendedores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE u_cod='".$_SESSION['u_cod']."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
         while ($linha = mysql_fetch_array($vendedores)) {
            if($linha[u_cod]==$u_cod){
               print '<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>';
            //} else {
             //  print '<option value="'.$linha[u_cod].'">'.$linha[u_email].'</option>';
            }
         }
		?>
      </select>

	  </td>
    </tr>
    <tr>
      <td width="100%" colspan=2>
      <input type="hidden" value="<?php print("$not1[cod]"); ?>" name="cod">
      <input type="submit" value="Inserir Venda" class=campo3 name="B1"></td>
    </tr>
  </table>
  </form>
<br>
<!--table border="0">
<tr><td valign="top">
<?
/*
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
*/
?>
</td></tr>
</table-->
<?
    } // fche while interior
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
