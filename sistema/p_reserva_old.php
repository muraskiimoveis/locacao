<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
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
<script type="text/javascript" src="funcoes/js.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
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

	$entrada = mktime(0,0,0,$mes,$dia,$ano);
	$saida = mktime(0,0,0,$mes1,$dia1,$ano1);

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

	  	$env = 1;
		$msg = "";

		for ($p = 1; $p <= $_POST['qtd_parc']; $p++) {

		  $dia_parc{$p} = $_POST[dia_parc][$p];
		  $mes_parc{$p} = $_POST[mes_parc][$p];
		  $ano_parc{$p} = $_POST[ano_parc][$p];

		  if($dia_parc{$p}==''){
				$env = 0;
		       $msg .= "
			   		<tr>
					   <td colspan=4 align=center class=style1>Preencha o campo Dia da Parcela ".$p." e clique no botão 'Atualizar Valores'!</td>
				   </tr>
			   ";
		  }elseif($mes_parc{$p}==''){
				$env = 0;
		       $msg .= "
			   		<tr >
					   <td colspan=4 align=center class=style1>Preencha o campo Mês da Parcela ".$p." e clique no botão 'Atualizar Valores'!</td>
				   </tr>
			   ";
		  }elseif($ano_parc{$p}==''){
				$env = 0;
		       $msg .= "
			   		<tr>
					   <td colspan=4 align=center class=style1>Preencha o campo Ano da Parcela ".$p." e clique no botão 'Atualizar Valores'!</td>
				   </tr>
			   ";

		  }

		}
		if($co_cliente==''){
		  	$env = 0;
		       $msg .= "
			   		<tr>
					   <td colspan=4 align=center class=style1>Selecione o campo Locatário!</td>
				   </tr>
			   ";
		}

		if ($env == 1){

		$query8 = "SELECT * FROM muraski WHERE cod='$cod'
        	AND ('$ano-$mes-$dia' BETWEEN data_inicio AND data_fim
	        AND '$ano1-$mes1-$dia1' BETWEEN data_inicio AND data_fim) and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
//print $query8;
        	$result8 = mysql_query($query8);
	        $numrows8 = mysql_num_rows($result8);
		if ($numrows8 == 0) {
?>
<tr>
<td colspan=3 align=center class=style1>
O imóvel não está disponível para locação no período de <?="$dia/$mes/$ano"?> a <?="$dia1/$mes1/$ano1"?>.
</td></tr>
<tr>
	<td  colspan="3" align="center"><a href="javascript:history.back()" class="style1"><b>Voltar</b></a></td>
</tr>
<?php
		} else {

			while($not8 = mysql_fetch_array($result8))
			{

			//$l_total = str_replace(".", "", $l_total);
			//$l_total = str_replace(",", ".", $l_total);
			$l_limpeza = str_replace(".", "", $l_limpeza);
			$l_limpeza = str_replace(",", ".", $l_limpeza);
			$parc_limpeza = $l_limpeza / $qtd_parc;
			$l_tv = str_replace(".", "", $l_tv);
			$l_tv = str_replace(",", ".", $l_tv);
			//$total = $l_total + $l_limpeza + $l_tv;
			$total = $l_total + $l_tv + $l_limpeza;
			$l_comissao = $l_total * $not8[comissao]/100;
			$saldo = $l_total - ($l_comissao);
			//$l_pagto = $l_pagto . " usuário: " . $valid_user;
			//print("$co_cliente, $cod, $ano-$mes-$dia, $ano1-$mes1-$dia1, $l_total, $l_pagto, $l_limpeza, $total");

			//Insere os produtos na tabela de Locação
			$query2= "insert into locacao (cod_imobiliaria, l_cliente, l_imovel, l_data_ent, l_data_sai
			, l_total, l_pagto, l_limpeza, l_comissao, l_saldo, l_data, l_tv, l_usuario)
			values('".$_SESSION['cod_imobiliaria']."', '$co_cliente', '$cod', '$ano-$mes-$dia', '$ano1-$mes1-$dia1', '$l_total'
			, '$l_pagto', '$l_limpeza', '$l_comissao', '$saldo', current_date, '$l_tv', '$u_cod')";
			$result2 = mysql_query($query2) or die("Não foi possível atualizar suas informações.($query2)");
			$l_cod = mysql_insert_id();

			$total = number_format($total, 2, ',', '.');
			$total_dias = number_format($l_total, 2, ',', '.');
			$limpeza = number_format($l_limpeza, 2, ',', '.');
			$tv = number_format($l_tv, 2, ',', '.');

			$query1 = "select * from muraski where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result1 = mysql_query($query1);
			while($not1 = mysql_fetch_array($result1))
			{
			  	$cliente1 = explode("--", $not1[cliente]);
			    $cliente2 = str_replace("-","",$cliente1);
			    $cod_cliente = $not1[cliente];
				$imovel = "Ref.: ". $not1[ref] . " - " . strip_tags($not1[titulo]);
				$proprietario = $cliente2;
				$contrato = $not1[contrato];
				$contador = $not1[contador];
				$valor_comissao = $not1[comissao] / 100;
				$percentual1 = explode("--", $not1[percentual_prop]);
			    $percentual2 = str_replace("-","",$percentual1);

			}

			$contagem = mysql_query("SELECT co_status FROM contas WHERE co_imovel='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_tipo='Locação' ORDER BY co_locacao DESC LIMIT 1");
 			while($linha = mysql_fetch_array($contagem)){
		  		if($linha['co_status']=='pendente'){
		      		$pendente = count($linha['co_status']);
		  		}elseif($linha['co_status']=='ok'){
		      		$ok = count($linha['co_status']);
		  		}
			}

			if($pendente == 0 && $ok > 0){

			  	$cod_cliente2 = " (";
				for($i3 = 1; $i3 <= $contador; $i3++){
	    			if($i3==1){
						$cod_cliente2 .= "c_cod='".$cliente2[$i3-1]."'";
					}else{
		  				$cod_cliente2 .= " or c_cod='".$cliente2[$i3-1]."'";
					}
				}
				$cod_cliente2 .= ")";

				$query4= "update contas set co_locacao='$l_cod' where co_locacao='0' and co_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");

				$query01 = "select * from clientes, locacao, muraski where cod=l_imovel and muraski.cliente='".$cod_cliente."' and $cod_cliente2 and l_cod='$l_cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$result01 = mysql_query($query01);
				while($not01 = mysql_fetch_array($result01))
				{
					$l_total = $not01[l_total];
					$l_comissao = $not01[l_comissao];
				}

				$query10 = "select SUM(c.co_valor) as valor_desp  from contas c INNER JOIN clientes cl ON (c.co_cliente=cl.c_cod) where c.co_locacao='$l_cod' and c.co_tipo='Despesas' and c.co_cod!='$co_cod2' and c.co_cat='Receber' and c.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.co_data";
				$result10 = mysql_query($query10);
				while($not10 = mysql_fetch_array($result10)){
					$total_desp = $not10['valor_desp'];
				}

				$l_saldo = $l_total - ($l_comissao + $total_desp);

				$query46= "update locacao set l_desp='$total_desp', l_saldo='$l_saldo' where l_cod='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$result46 = mysql_query($query46) or die("Não foi possível atualizar suas informações.");

                $query40= "update contas set co_status='ok' where co_locacao='$l_cod' and co_tipo='Despesas' and co_cat='Receber' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		        $result40 = mysql_query($query40) or die("Não foi possível atualizar suas informações.");
			}

			//Cadastro de Parcelas nas contas a receber e à pagar
			/*
			//Taxa de limpeza
			if($l_limpeza > 0){
			if($forma_limpeza != "Depósito"){
				$co_pendente = "ok";
				$data_status = "current_date";
			}
			else
			{
				$co_pendente = "pendente";
				$data_status = "''";
			}
			$query11 = "insert into contas (co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
			, co_locacao, co_usuario, co_forma, co_data_status)
			values('$co_cliente', 'Receber', '$cod', 'Taxa Administrativa', 'Limpeza', current_date
			, '$co_pendente', '$l_limpeza', '$l_cod', '$valid_user', '$forma_limpeza', $data_status)";
			//echo $query11;
			$result11 = mysql_query($query11) or die("Não foi possível atualizar suas informações." . $query11);
			}
			*/

			//Taxa de TV
			if($l_tv > 0){
			if($forma_tv != "Depósito"){
				$co_pendente = "ok";
				$data_status = "current_date";
			}
			else
			{
				$co_pendente = "pendente";
				$data_status = "current_date";
			}
			$query12 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
			, co_locacao, co_usuario, co_forma, co_data_status)
			values('".$_SESSION['cod_imobiliaria']."', '$co_cliente', 'Receber', '$cod', 'Locação de TV', 'TV', current_date
			, '$co_pendente', '$l_tv', '$l_cod', '$u_cod', '$forma_tv', $data_status)";
			//echo $query12;
			$result12 = mysql_query($query12) or die("Não foi possível atualizar suas informações." . $query12);
			}

	for ($j = 1; $j <= $qtd_parc; $j++) {

			//Valor do inquilino
			if($forma[$j] != "Depósito"){
				$co_pendente = "ok";
				$data_status = "current_date";
			}
			else
			{
				$co_pendente = "pendente";
				$data_status = "current_date";
			}

			if($forma[$j] == "Cheque"){
				$co_fixar = "ok";
			}
			else
			{
				$co_fixar = "no";
			}

				$query9 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."', '$co_cliente', 'Receber', '$cod', '$l_pagto', 'Locação', '$ano_parc[$j]-$mes_parc[$j]-$dia_parc[$j]', '$co_pendente', '$parc[$j]', '$l_cod', '$u_cod', '$forma[$j]', $data_status, '$co_fixar')";
				$result9 = mysql_query($query9) or die("Não foi possível atualizar suas informações." . $query9);

			//Valor do Proprietário
			if($qtd_parc==1)
			{
			    $parc_prop[$j] = ($parc[$j] - $parc_limpeza) - (($parc[$j] - $parc_limpeza) * $valor_comissao);

				$parcelas = $parc_prop[$j] / 2;

				$data_parc1 = $dia_parc[$j] . "/" . $mes_parc[$j] . "/" . $ano_parc[$j];
				//echo $data_parc1;
				$datap1 = dateadd("5",$data_parc1);

				//echo $datap1;

				$anop1 = substr ($datap1, 6, 4);
				$mesp1 = substr ($datap1, 3, 2);
				$diap1 = substr ($datap1, 0, 2);

				$data_parc2 = $dia1 . "/" . $mes1 . "/" . $ano1;
				$datap2 = dateadd("5",$data_parc2);

				$anop2 = substr ($datap2, 6, 4);
				$mesp2 = substr ($datap2, 3, 2);
				$diap2 = substr ($datap2, 0, 2);

				for($i3 = 1; $i3 <= $contador; $i3++){

				  	$comissaop = $percentual2[$i3-1];
					$comissao_prop = $comissaop / 100;
					$valores = ($comissao_prop * $parcelas);

					//parcela 1
					$query90 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."','".$proprietario[$i3-1]."', 'Pagar', '$cod', '$l_pagto', 'Locação', '$anop1-$mesp1-$diap1', 'pendente', '$valores', '$l_cod', '$u_cod', 'Depósito', $data_status, '$co_fixar')";
					$result90 = mysql_query($query90) or die("Não foi possível atualizar suas informações." . $query90);
					//parcela 2
					$query100 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."', '".$proprietario[$i3-1]."', 'Pagar', '$cod', '$l_pagto', 'Locação', '$anop2-$mesp2-$diap2', 'pendente', '$valores', '$l_cod', '$u_cod', 'Depósito', $data_status, '$co_fixar')";
					$result100 = mysql_query($query100) or die("Não foi possível atualizar suas informações." . $query100);
				}

			}
			else
			{
			    $parc_prop[$j] = ($parc[$j] - $parc_limpeza) - (($parc[$j] - $parc_limpeza) * $valor_comissao);

			    $data_parc = $dia_parc[$j] . "/" . $mes_parc[$j] . "/" . $ano_parc[$j];
				if($j == $qtd_parc){
					$data_parc = $dia1 . "/" . $mes1 . "/" . $ano1;
				}
				$data_nova = dateadd("5",$data_parc);

				$ano4 = substr ($data_nova, 6, 4);
				$mes4 = substr ($data_nova, 3, 2);
				$dia4 = substr ($data_nova, 0, 2);

			  	for($i3 = 1; $i3 <= $contador; $i3++){

			  	  	$comissaop = $percentual2[$i3-1];
					$comissao_prop = $comissaop / 100;
					$valores = ($comissao_prop * $parc_prop[$j]);

			    	$query10 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."','".$proprietario[$i3-1]."', 'Pagar', '$cod', '$l_pagto', 'Locação', '$ano4-$mes4-$dia4', 'pendente', '$valores', '$l_cod', '$u_cod', 'Depósito', $data_status, '$co_fixar')";
					$result10 = mysql_query($query10) or die("Não foi possível atualizar suas informações." . $query10);
				}
			}
	}

            if($pendente == 0 && $ok > 0){

				$query30 = "select * from contas where co_locacao='$l_cod' and co_cat='Pagar' and co_status='pendente' and co_fixar='no' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by co_data";
				$result30 = mysql_query($query30);

				$x = 1;

				while($not30 = mysql_fetch_array($result30))
				{
				  	$query101 = "select SUM(c.co_valor) as valor_desp from contas c INNER JOIN clientes cl ON (c.co_cliente=cl.c_cod) where c.co_locacao='$l_cod' and c.co_tipo='Despesas' and c.co_cod!='$co_cod2' and c.co_cat='Receber' and c.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.co_data";
					$result101 = mysql_query($query101);
					while($not101 = mysql_fetch_array($result101)){
						$co_valor = $not101['valor_desp'];
					}

					if($saldo == "")
					{
						$saldo = $not30[co_valor] - $co_valor;
						//echo "Saldo: " . $saldo . "<br>";
					}
					else
					{
						if($saldo > 0)
						{
							$saldo = $not30[co_valor] - $co_valor;
						}
						else
						{
							$saldo = $not30[co_valor] + $co_valor;
						}
						//echo "Saldo Registrado: " . $saldo . "<br>";
					}

					if($saldo >= 0){
						$saldo2 = $saldo;
						session_register("saldo2");


						$query22 = "update contas set co_valor='$saldo', co_data_status=current_date where co_cod='$not30[co_cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
						$result22 = mysql_query($query22) or die("Não foi possível atualizar suas informações. $query22");
						//echo $query2;

						$query40 = "update contas set co_status='ok', co_data_status=current_date where co_cod='$codigo_desp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
						$result40 = mysql_query($query40) or die("Não foi possível atualizar suas informações. $query40");

						break;

					}

				}

				if($saldo < 0)
				{
					$saldo3 = str_replace("-","","$saldo");

					$query70= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
					, co_locacao, co_usuario, co_forma, co_data_status, co_usuario_status)
					values('".$_SESSION['cod_imobiliaria']."','$cod_cliente', 'Receber', '$cod', '$co_desc', 'Despesas', '".formataDataParaBd($data_despesa)."', 'pendente', '$saldo3'
					, '$l_cod', '$u_cod', 'Depósito', '".formataDataParaBd($data_despesa)."', '$u_cod')";
					$result70 = mysql_query($query70) or die("Não foi possível atualizar suas informações. $query70");

				}

				session_unregister("saldo2");
			}

			$query3 = "select * from clientes
			where c_cod='$co_cliente' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result3 = mysql_query($query3);
			while($not3 = mysql_fetch_array($result3))
			{
				$nome = $not3[c_nome];
				$codloc = $not3[c_cod];
			}
?>
<tr>
	<td>
<span class="style1" >
O imóvel <b><?php print("$imovel"); ?></b> foi reservado para o cliente <b><?php print("$nome"); ?></b> do dia <b><?php print("$dia/$mes/$ano"); ?></b> à <b><?php print("$dia1/$mes1/$ano1"); ?></b>.<br><br>
Valor Total de <b>R$ <?php print("$total"); ?></b>, referente à R$ <?php print("$total_dias"); ?> pelas diárias, R$ <?php print("$l_limpeza"); ?> taxa Administrativa e R$ <?php print("$tv"); ?> pela taxa de locação de TV.<br><br>
<b>Forma de pagamento:</b> <?php print("$l_pagto"); ?><br><br>
<form name="form1" id="form1" method="post" action="">
<a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='p_imp_doc.php?imp=9&cod=<?php print("$cod"); ?>&l_cod=<?php print("$l_cod"); ?>';form1.submit();" class="style1">
<b>Clique aqui para imprimir o contrato de locação.</b></a></span>
</form><br>
<form name="form2" id="form2" method="post" action="">
<a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form2.target='uprelatorio';form2.action='ficha_inquilinos2.php?cod=<?php print("$cod"); ?>&codloc=<?php print("$codloc"); ?>&l_cod=<?php print("$l_cod"); ?>';form2.submit();" class="style1">
<b>Clique aqui para cadastrar uma ficha de inquilino.</b></a></span>
</form>
<!--a href="p_imp_doc.php?imp=9&cod=<?php print("$cod"); ?>&l_cod=<?php print("$l_cod"); ?>" class="style1"-->
<!--b>Clique aqui para imprimir o contrato de locação.</b></a--></span>
	</td>
</tr>
<?php
			}
		}
	}else{
	   echo $msg."<br>";
	   echo "<tr>
      		<td align=\"center\"><a href=\"javascript:history.back()\" class=\"style1\"><b>Voltar</b></a></td>
    		</tr>";
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
</td></tr></table></div>
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
