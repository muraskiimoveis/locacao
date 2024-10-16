<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
include("funcoes/funcoes.php");
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
<script type="text/javascript" src="funcoes/js.js"></script>
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
<table border="0" cellpadding="1" cellspacing="1" width="100%">
  <tr>
    <td>
<div align="center">
<table border="0" cellpadding="1" cellspacing="1" width="75%">
	<tr height="50">
      <td colspan=2 class="style1"><p align="center"><b>Reserva de Imóvel</b></p></td>
    </tr>
</table>
<table border="0" cellpadding="5" cellspacing="10" width="75%" class="fundoTabela">
<?php
//Função de adicionar data
function dateadd($dias,$datahoje = "?") 
{  
 if ($datahoje == "?") 
 { 
  $datahoje = date("d") . "/" . date("m") . "/".date("Y");
 } 

  if (ereg ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $datahoje, $sep))  
  {    
   $dia = $sep[1];    
   $mes = $sep[2];    
   $ano = $sep[3];    
  } 
  else  
  {    
    return "#Erro#";    
  }    

  if ($dias < 0) 
  { 
    $dias = $dias * -1; 
    if($mes == "01" || $mes == "02" || $mes == "04" || $mes == "06" || $mes == "08" || $mes == "09" || $mes == "11"){    
     for ($cont = $dias ; $cont > 0 ; $cont--) 
     {    
     $dia--;    
      if($dia == 00) 
      {   
       $dia = 31;    
       $mes = $mes -1; 
        if($mes == 00) 
        {    
         $mes = 12;    
         $ano = $ano - 1; 
        }    
      }    
     }    
    }    

    if($mes == "05" || $mes == "07" || $mes == "10" || $mes == "12" ) 
    {    
     for ($cont = $dias ; $cont > 0 ; $cont--) 
     {    
      $dia--;    
      if($dia == 00) 
       { 
        $dia = 30;    
        $mes = $mes -1; 
       }    
      }    
    }    

   if($ano % 4 == 0 && $ano%100 != 0) 
   {  
    if($mes == "03") 
     {    
      for ($cont = $dias ; $cont > 0 ; $cont--) 
      {    
        $dia--;    
        if($dia == 00) 
         {  
          $dia = 29;    
          $mes = $mes -1; 
        }    
       }    
     }    
   } 
   else 
   {  
    if($mes == "03" ) 
    {    
      for ($cont = $dias ; $cont > 0 ; $cont--) 
       {    
        $dia--;    
        if($dia == 00) 
         { 
          $dia = 28;    
          $mes = $mes -1; 
         }    
       }    
     }    
   }    
  } 
  else 
  { 
  $i = $dias;    
  for($i = 0;$i<$dias;$i++) 
  {    
    if ($mes == 01 || $mes == 03 || $mes == 05 || $mes == 07 || $mes == 8 || $mes == 10 || $mes == 12) 
    {    
      if($mes == 12 && $dia == 31) 
      {    
        $mes = 01;    
        $ano++;    
        $dia = 00;    
      }    
    if($dia == 31 && $mes != 12) 
    {    
      $mes++;    
      $dia = 00;    
    }    
  } 
  if($mes == 04 || $mes == 06 || $mes == 09 || $mes == 11) 
  {    
    if($dia == 30) 
    {    
      $dia =  00;    
      $mes++;    
    }    
  } 

  if($mes == 02) 
  {    
    if($ano % 4 == 0 && $ano % 100 != 0) 
    { 
      if($dia == 29) 
      {    
        $dia = 00;    
        $mes++;         
      }    
    }    
    else 
    {    
      if($dia == 28) 
      {    
        $dia = 00;    
        $mes++;    
      }    
    }    
  } 
  $dia++;    
  } 
  }  
  if(strlen($dia) == 1){$dia = "0".$dia;}    
  if(strlen($mes) == 1){$mes = "0".$mes;}    
  $nova_data = $dia . "/" . $mes . "/" . $ano ;    
  return $nova_data;    
}//Término da função

	if(session_is_registered("valid_user")){
	
	$hoje = date("Y-m-d");
	
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

        $query3 = "select * from locacao where l_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato!='' order by l_data_ent";

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

				$ndata = $odata1;
				
				$um_dia = 24*60*60;
				$temp = $odata1;
				while ($temp <= $odata2) {
					$locados[] = date('d/m/Y',$temp);
   					$temp += $um_dia;
				}

		        $total_dias = round(($odata2 - $odata1)/(24*60*60));
		        $total_dias = $total_dias + 1;
			}
	}
}

	$entrada = mktime(0,0,0,$mesl,$dial,$anol);
	$saida = mktime(0,0,0,$mesl1,$dial1,$anol1);
		
	$um_dia = 24*60*60;
	$temp = $entrada;
	while ($temp <= $saida) {
		$todosperiodos[] = date('d/m/Y',$temp);
		$temp += $um_dia;
	}
	
	$confirma = 0;
	foreach($todosperiodos as $datalocacao){
	  if(count($locados) > 0){
	  	if(in_array($datalocacao, $locados)){
	  		$confirma++; 
	  	}  
	  }
	}
	if($confirma==0){
	
				$query8 = "SELECT * FROM muraski WHERE cod='$cod'
        	AND ('$anol-$mesl-$dial' BETWEEN data_inicio AND data_fim 
	        AND '$anol1-$mesl1-$dial1' BETWEEN data_inicio AND data_fim) and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		//print $query8;
        	$result8 = mysql_query($query8);
	        $numrows8 = mysql_num_rows($result8);
		if ($numrows8 == 0) {
?>
<tr><td colspan=3 align=center class=style1>
O imóvel não está disponível para locação no período de <? echo("$dial/$mesl/$anol"); ?> a <? echo("$dial1/$mesl1/$anol1"); ?>.
</td></tr>
<tr>
	<td  colspan="3" align="center"><a href="javascript:history.back()" class="style1"><b>Voltar</b></a></td>
</tr>
<?php		
		} else {
		
			while($not8 = mysql_fetch_array($result8))
			{
			$l_comissao = $l_total * $not8[comissao]/100;
			$saldo = $l_total - ($l_comissao);
			$vencimentoc = formataDataParaBd($venc_contrato);
			$ultimor = formataDataParaBd($ultimo_reajuste); 
			$proximor = formataDataParaBd($proximo_reajuste);
		  	$contador = $not8[contador];  
            $valor_comissao = $not8[comissao] / 100;
	  		$cliente1 = explode("--", $not8[cliente]);
	  		$cliente2 = str_replace("-","",$cliente1);
            $proprietario = $cliente2;
            $percentual1 = explode("--", $not8[percentual_prop]);
			$percentual2 = str_replace("-","",$percentual1);
         
            foreach ($cliente2 as $k => $cliente) {
               $cliente2[$k] = "'" . $cliente . "'";
            }
         
         }

			$qstr = "select c_conta from clientes where c_cod in (" . implode(',',$cliente2) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
         $qres = mysql_query($qstr);

         $res = array();
         while ($rw = mysql_fetch_assoc($qres)) {
            array_push($res, $rw);
         }
         
         $contas = array();
         
         foreach ($res as $row) {
            array_push($contas, $row['c_conta']);
         }
         
         $l_pagto = implode(' e ', $contas);
         
         
         $cont = $_GET['cont'];
         $i2 = $cont;
		 $c2 = 0;

		for($j2 = 1; $j2 <= $i2; $j2++)
		{
			$fiadores2 = "fiador_".$j2;
	    	$fiador .= "-".$_GET[$fiadores2]."-";
	    	if($_GET[$fiadores2]==''){
	      		$fiador = ''; 
	      		$cont = '';
	    	}
  		}
        
		     
			//Insere os produtos na tabela de Locação
			$query2 = "insert into locacao (cod_imobiliaria, l_cliente, l_imovel, l_data_ent, l_data_sai
			, l_total,  l_pagto, l_comissao, l_saldo, l_data, l_usuario, l_n_contrato, l_tipo_contrato, l_vigencia, l_venc_contrato, l_venc_aluguel, l_tolerancia, l_bonificacao, l_reajustes, l_indice, l_ultimo_reajuste, l_proximo_reajuste, l_fiador, l_testemunha, l_testemunha2, contadorf) 
			values ('".$_SESSION['cod_imobiliaria']."', '$co_cliente', '$cod', '$anol-$mesl-$dial', '$anol1-$mesl1-$dial1', '$l_total', '$l_pagto', '$l_comissao', '$saldo', current_date, '$u_cod', '$n_contrato', '$tipo_contrato', '$vigencia', '$vencimentoc', '$venc_aluguel', '$tolerancia', '$bonificacao', '$reajustes', '$indice', '$ultimor', '$proximor', '$fiador', '$testemunha', '$testemunha2', '$cont')";
			$result2 = mysql_query($query2) or die("Não foi possível atualizar suas informações. $query2");
			$l_cod = mysql_insert_id();
			
         $dvencimento = mysql_query("SELECT l_venc_aluguel FROM locacao WHERE l_cod='".$l_cod."'");
         while($linha = mysql_fetch_array($dvencimento)){
            $diav = $linha['l_venc_aluguel'];
         }
         
         $datai = formataDataDoBd("$anol-$mesl-$dial");
         $dataf = formataDataDoBd("$anol1-$mesl1-$dial1");
         
         $qtd_contas = retornaDifMeses($datai, $dataf);
         $mesv = $mesl + 1;
         $anov = $anol;
         
		 if(strlen($mesv)=='1'){
      		$mesv = "0".$mesv; 
   		 }
			
      for ($j = 1; $j <= $qtd_contas; $j++) {
      	
        
         $valor_parc = $l_total / $qtd_contas;         
         $data_fatura = $anov."-".$mesv."-".$diav;        
         
         if ($mesv == 12) {
            $mesv = 1;               
            $anov = $anov + 1;
         } else {
            $mesv = $mesv + 1; 
         }
         
         if(strlen($mesv)=='1'){
      		$mesv = "0".$mesv; 
   		 }    
		 //echo $data_fatura."<br>";	    
		                
			//Valor do Inquilino
         $query9 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."', '$co_cliente', 'Receber', '$cod', '$l_pagto', 'Locação', '$data_fatura', 'pendente', '$l_total', '$l_cod', '$u_cod', 'Depósito', current_date, 'no')";
			$result9 = mysql_query($query9) or die("Não foi possível atualizar suas informações." . $query9);
         
			
			//Valor do Proprietário
			$parc_prop = ($l_total - $l_comissao);
										
			for($i3 = 1; $i3 <= $contador; $i3++){
			  
			  	$comissaop = $percentual2[$i3-1];
            $conta = $contas[$i3-1];
				$comissao_prop = $comissaop / 100;
				$valores = ($comissao_prop * $parc_prop); 
            $valor_parc = $valores / $qtd_contas;   
				
				$query90 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."','".$proprietario[$i3-1]."', 'Pagar', '$cod', '$conta', 'Locação', '$data_fatura', 'pendente', '$valores', '$l_cod', '$u_cod', 'Depósito', current_date, 'no')";
				$result90 = mysql_query($query90) or die("Não foi possível atualizar suas informações." . $query90);			
			}
			
      }
			       
			$blocacao = mysql_query("SELECT * FROM servicos WHERE cod_imovel='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
     		if(mysql_num_rows($blocacao) > 0){
				$atualizas = "UPDATE servicos SET locacao='".$l_cod."' WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND cod_imovel='".$cod."'";   		
   			mysql_query($atualizas);
   		}
			$total = number_format($l_total, 2, ',', '.');

			$query3 = "select * from clientes 
			where c_cod='$co_cliente' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result3 = mysql_query($query3);
			while($not3 = mysql_fetch_array($result3))
			{
				$nome = $not3[c_nome];	
			}
?>
<tr>
	<td>
<span class="style1">
O imóvel <b><?php print("$imovel"); ?></b> foi reservado para o cliente <b><?php print("$nome"); ?></b> do dia <b><?php print("$dial/$mesl/$anol"); ?></b> à <b><?php print("$dial1/$mesl1/$anol1"); ?></b>.<br><br>
Valor Total de <b>R$ <?php print("$total"); ?></b><br><br>
<b>Forma de pagamento:</b> <?php print("$l_pagto"); ?><br><br>
<form name="form1" id="form1" method="post" action="">
<?
  	if($tipo_contrato=='Comercial'){
       	$escolha = "11";
  	}else{
    	$escolha = "10";
	}
?>
<a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='p_imp_doc.php?imp=<?php print("$escolha"); ?>&cod=<?php print("$cod"); ?>&l_cod=<?php print("$l_cod"); ?>';form1.submit();" class="style1">
<b>Clique aqui para imprimir o contrato de locação anual.</b></a></span>
</form>
	</td>
</tr>
<!--a href="p_imp_doc.php?imp=9&cod=<?php print("$cod"); ?>&l_cod=<?php print("$l_cod"); ?>" class="style1"-->
<!--b>Clique aqui para imprimir o contrato de locação.</b></a></span-->
<?php			
		}
}else{
?>
<tr>
	<td colspan="3" align="center" class="style1">O imóvel está locado nesse período.</td>
</tr>
<tr>
	<td  colspan="3" align="center"><a href="javascript:history.back()" class="style1"><b>Voltar</b></a></td>
</tr>
<?  
  
}
/*
mysql_free_result($result1);
mysql_free_result($result3);
mysql_free_result($result7);
mysql_free_result($result8);
*/
mysql_close($con);
?>
</td></tr></table>
<?php

	}
	else
	{
	
?>
<?php
include("login2.php");
?>
<?php	
	}
?>
</body>

</html>
