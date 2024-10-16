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
verificaArea("GERAL_VEND");
?>
<html>

<head>
<?php
include("style.php");
?>
</head>
<body onUnload="window.opener.location.reload()">
<link href="style.css" rel="stylesheet" type="text/css" />
<p>
<table border="0" cellpadding="1" cellspacing="1" width="770">
  <tr>
    <td>
<div align="center">
<table border="0" cellpadding="1" cellspacing="1" width="700" bgcolor="#<?php print("$cor7"); ?>">
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
	//print("$hoje");

	//$query7 = "SELECT * FROM locacao WHERE l_imovel='$cod'
	//AND (l_data_ent BETWEEN '$ano-$mes-$dia' AND '$ano1-$mes1-$dia1' OR
	//l_data_sai BETWEEN '$ano-$mes-$dia' AND '$ano1-$mes1-$dia1')";
	$query7 = "SELECT * FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) WHERE v.v_imovel='$cod' AND v.v_data='$hoje' AND m.status='0' and v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result7 = mysql_query($query7);
	$numrows7 = mysql_num_rows($result7);
	if($numrows7 > 0) {
	#while($not7 = mysql_fetch_array($result7))
	#{
?>
<tr><td colspan=3 align=center class=style1>
O imóvel está vendido.8
</td></tr>
<?php
	#}//Termina while 7
	}//Termina numrows 7

	else
	{
	    $env = 1;
		$msg = "";

		for ($p = 1; $p <= $_POST['qtd_parc']; $p++) {

		  $dia_parc{$p} = $_POST[dia_parc][$p];
		  $mes_parc{$p} = $_POST[mes_parc][$p];
		  $ano_parc{$p} = $_POST[ano_parc][$p];

		  if($dia_parc{$p}==''){
				$env = 0;
		       /*$msg .= "
			   		<tr>
					   <td colspan=4 align=center class=style1>Preencha o campo Dia da Parcela ".$p." e clique no botão 'Atualizar Valores'!</td>
				   </tr>
			   ";
			   */
			   $msg .= "
			   		<tr>
					   <td colspan=4 align=center class=style1>Preencha o campo Dia da Data e clique no botão 'Atualizar Valores'!</td>
				   </tr>
			   ";
		  }elseif($mes_parc{$p}==''){
				$env = 0;
		       /*$msg .= "
			   		<tr>
					   <td colspan=4 align=center class=style1>Preencha o campo Mês da Parcela ".$p." e clique no botão 'Atualizar Valores'!</td>
				   </tr>
			   ";
			   */
			   $msg .= "
			   		<tr>
					   <td colspan=4 align=center class=style1>Preencha o campo Mês da Data e clique no botão 'Atualizar Valores'!</td>
				   </tr>
			   ";
		  }elseif($ano_parc{$p}==''){
				$env = 0;
		      /*$msg .= "
			   		<tr>
					   <td colspan=4 align=center class=style1>Preencha o campo Ano da Parcela ".$p." e clique no botão 'Atualizar Valores'!</td>
				   </tr>
			   ";
			   */
			  $msg .= "
			   		<tr>
					   <td colspan=4 align=center class=style1>Preencha o campo Ano da Data e clique no botão 'Atualizar Valores'!</td>
				   </tr>
			   ";

		  }

		}
		if ($env == 1){


		    $query8 = "SELECT * FROM muraski WHERE cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
        	$result8 = mysql_query($query8);
	        $numrows8 = mysql_num_rows($result8);
			while($not8 = mysql_fetch_array($result8))
			{

			//$l_total = str_replace(".", "", $l_total);
			//$l_total = str_replace(",", ".", $l_total);
			//$l_limpeza = str_replace(".", "", $l_limpeza);
			//$l_limpeza = str_replace(",", ".", $l_limpeza);
			//$parc_limpeza = $l_limpeza / $qtd_parc;
			//$l_tv = str_replace(".", "", $l_tv);
			//$l_tv = str_replace(",", ".", $l_tv);
			//$total = $l_total + $l_limpeza + $l_tv;
			//$total = $l_total; //+ $l_tv + $l_limpeza;
			//$l_comissao = $l_total * $not8[comissao]/100;
			$saldo = $l_total - ($l_comissao);
			//$l_pagto = $l_pagto . " usuário: " . $valid_user;
			//print("$co_cliente, $cod, $ano-$mes-$dia, $ano1-$mes1-$dia1, $l_total
			//, $l_pagto, $l_limpeza, $total");

			//Insere os produtos na tabela de Locação
			$query2= "insert into vendas (cod_imobiliaria, v_cliente, v_imovel, v_total, v_pagto, v_comissao, v_saldo, v_data, v_usuario) values('".$_SESSION['cod_imobiliaria']."','$co_cliente', '$cod', '$l_total', '$l_pagto', '$l_comissao', '$saldo', current_date, '$u_cod')";
			$result2 = mysql_query($query2) or die("Não foi possível atualizar suas informações.(Sessão existente)");
			$l_cod = mysql_insert_id();

			$total = number_format($l_total, 2, ',', '.');
			//$total_dias = number_format($l_total, 2, ',', '.');
			//$limpeza = number_format($l_limpeza, 2, ',', '.');
			//$tv = number_format($l_tv, 2, ',', '.');

			$query1 = "select * from muraski where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result1 = mysql_query($query1);
			while($not1 = mysql_fetch_array($result1))
			{
				$cliente1 = explode("--", $not1[cliente]);
			    $cliente2 = str_replace("-","",$cliente1);
				$imovel = "Ref.: ". $not1[ref] . " - " . $not1[titulo];
				$proprietario = $cliente2;
				$angariador = $not1[angariador];
				//$comissao_anga = $not1[tipo_anga];
				$indicador = $not1[indicador];
			    //$com_indicador = $not1[comissao_indicador];
				//$com_vendedor = $not1[comissao_vendedor];
				$percentual1 = explode("--", $not1[percentual_prop]);
			    $percentual2 = str_replace("-","",$percentual1);
				$contrato = $not1[contrato];
				$contador = $not1[contador];
			}

			$queryA = "UPDATE muraski SET finalidade='6' WHERE cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$resultA = mysql_query($queryA) or die("Não foi possível atualizar suas informações." . $queryA);

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
			/*
			if($l_tv > 0){
			if($forma_tv != "Depósito"){
				$co_pendente = "ok";
				$data_status = "current_date";
			}
			else
			{
				$co_pendente = "pendente";
				$data_status = "''";
			}
			$query12 = "insert into contas (co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
			, co_locacao, co_usuario, co_forma, co_data_status)
			values('$co_cliente', 'Receber', '$cod', 'Locação de TV', 'TV', current_date
			, '$co_pendente', '$l_tv', '$l_cod', '$valid_user', '$forma_tv', '$data_status')";
			//echo $query12;
			$result12 = mysql_query($query12) or die("Não foi possível atualizar suas informações." . $query12);
			*/
	      // }


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
				$query9 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."','$co_cliente', 'Receber', '$cod', '$l_pagto', 'Venda', '$ano_parc[$j]-$mes_parc[$j]-$dia_parc[$j]', '$co_pendente', '$parc[$j]', '$l_cod', '$u_cod', '$forma[$j]', $data_status, '$co_fixar')";
				$result9 = mysql_query($query9) or die("Não foi possível atualizar suas informações." . $query9);

			//Valor do Proprietário
			if($qtd_parc==1)
			{
			    //$parc_prop[$j] = ($parc[$j] - $parc_limpeza) - (($parc[$j] - $parc_limpeza) * $valor_comissao);

				$parcelas = $saldo / 2;

				//$valor_vendedor = $l_comissao * $com_vendedor/100;
				//$valor_indicador = $l_comissao * $com_indicador/100;
				//$valor_angariador = $l_comissao * $comissao_anga/100;

				$data_parc1 = $dia_parc[$j] . "/" . $mes_parc[$j] . "/" . $ano_parc[$j];
				$datap1 = dateadd("5",$data_parc1);

				$anop1 = substr ($datap1, 6, 4);
				$mesp1 = substr ($datap1, 3, 2);
				$diap1 = substr ($datap1, 0, 2);

				$data_parc2 = $diap1 . "/" . $mesp1 . "/" . $anop1;
				$datap2 = dateadd("30",$data_parc2);

				$anop2 = substr ($datap2, 6, 4);
				$mesp2 = substr ($datap2, 3, 2);
				$diap2 = substr ($datap2, 0, 2);

				for($i3 = 1; $i3 <= $contador; $i3++){

					$comissaop = $percentual2[$i3-1];
					$comissao_prop = $comissaop / 100;
					$valores = ($comissao_prop * $parcelas);

				//parcela 1
				$query90 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."','".$proprietario[$i3-1]."', 'Pagar', '$cod', '$l_pagto', 'Venda', '$anop1-$mesp1-$diap1', 'pendente', '$valores', '$l_cod', '$u_cod', 'Depósito', '$anop1-$mesp1-$diap1', '$co_fixar')";
				$result90 = mysql_query($query90) or die("Não foi possível atualizar suas informações." . $query90);

				//parcela 2
				$query100 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."','".$proprietario[$i3-1]."', 'Pagar', '$cod', '$l_pagto', 'Venda', '$anop2-$mesp2-$diap2', 'pendente', '$valores', '$l_cod', '$u_cod', 'Depósito', '$anop2-$mesp2-$diap2', '$co_fixar')";
				$result100 = mysql_query($query100) or die("Não foi possível atualizar suas informações." . $query100);

				}

				//vendedor
				$queryV = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar, co_tipo_user) values('".$_SESSION['cod_imobiliaria']."','$u_cod', 'Pagar', '$cod', '$l_pagto', 'Venda', '$anop1-$mesp1-$diap1', 'pendente', '$valor_vendedor', '$l_cod', '$u_cod', 'Depósito', '$anop1-$mesp1-$diap1', '$co_fixar','V')";
				$resultV = mysql_query($queryV) or die("Não foi possível atualizar suas informações." . $queryV);

				//indicador
				if($indicador<>'0'){
				$queryI = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar,co_tipo_user) values('".$_SESSION['cod_imobiliaria']."','$indicador', 'Pagar', '$cod', '$l_pagto', 'Venda', '$anop1-$mesp1-$diap1', 'pendente', '$valor_indicador', '$l_cod', '$u_cod', 'Depósito', '$anop1-$mesp1-$diap1', '$co_fixar','I')";
				$resultI = mysql_query($queryI) or die("Não foi possível atualizar suas informações." . $queryI);
				}

				//angariador
				if($angariador<>'0'){
				$queryA = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar, co_tipo_user) values('".$_SESSION['cod_imobiliaria']."','$angariador', 'Pagar', '$cod', '$l_pagto', 'Venda', '$anop1-$mesp1-$diap1', 'pendente', '$valor_angariador', '$l_cod', '$u_cod', 'Depósito', '$anop1-$mesp1-$diap1', '$co_fixar','A')";
				$resultA = mysql_query($queryA) or die("Não foi possível atualizar suas informações." . $queryA);
				}

			}
			else
			{
			    $parc_prop[$j] = ($saldo / $qtd_parc);

				//$valor_vendedor = $l_comissao * $com_vendedor/100;
				//$valor_indicador = $l_comissao * $com_indicador/100;
				//$valor_angariador = $l_comissao * $comissao_anga/100;

			    $data_parc = $dia_parc[$j] . "/" . $mes_parc[$j] . "/" . $ano_parc[$j];
				$data_nova = dateadd("5",$data_parc);

				$ano4 = substr ($data_nova, 6, 4);
				$mes4 = substr ($data_nova, 3, 2);
				$dia4 = substr ($data_nova, 0, 2);

			  	for($i3 = 1; $i3 <= $contador; $i3++){

			  	 	$comissaop = $percentual2[$i3-1];
					$comissao_prop = $comissaop / 100;
					$valores = ($comissao_prop * $parc_prop[$j]);

			    $query10 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."', '".$proprietario[$i3-1]."', 'Pagar', '$cod', '$l_pagto', 'Venda', '$ano4-$mes4-$dia4', 'pendente', '$valores', '$l_cod', '$u_cod', 'Depósito', '$ano4-$mes4-$dia4', '$co_fixar')";
				$result10 = mysql_query($query10) or die("Não foi possível atualizar suas informações." . $query10);

				}

				//vendedor
				$queryV = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar, co_tipo_user) values('".$_SESSION['cod_imobiliaria']."','$u_cod', 'Pagar', '$cod', '$l_pagto', 'Venda', '$ano4-$mes4-$dia4', 'pendente', '$valor_vendedor', '$l_cod', '$u_cod', 'Depósito', '$ano4-$mes4-$dia4', '$co_fixar','V')";
				$resultV = mysql_query($queryV) or die("Não foi possível atualizar suas informações." . $queryV);

				//indicador
				$queryI = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar, co_tipo_user) values('".$_SESSION['cod_imobiliaria']."','$indicador', 'Pagar', '$cod', '$l_pagto', 'Venda', '$ano4-$mes4-$dia4', 'pendente', '$valor_indicador', '$l_cod', '$u_cod', 'Depósito', '$ano4-$mes4-$dia4', '$co_fixar','I')";
				$resultI = mysql_query($queryI) or die("Não foi possível atualizar suas informações." . $queryI);

				//angariador
				$queryA = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar, co_tipo_user) values('".$_SESSION['cod_imobiliaria']."','$angariador', 'Pagar', '$cod', '$l_pagto', 'Venda', '$ano4-$mes4-$dia4', 'pendente', '$valor_angariador', '$l_cod', '$u_cod', 'Depósito', '$ano4-$mes4-$dia4', '$co_fixar','A')";
				$resultA = mysql_query($queryA) or die("Não foi possível atualizar suas informações." . $queryA);
			}
	}


			$query3 = "select * from clientes
			where c_cod='$co_cliente' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result3 = mysql_query($query3);
			while($not3 = mysql_fetch_array($result3))
			{
				$nome = $not3[c_nome];
			}
?>
<span class="style1">
O imóvel <b><?php print("$imovel"); ?></b> foi vendido para o cliente <b><?php print("$nome"); ?></b> no dia <b><?=formataDataDoBd($hoje); ?></b>.<br><br>
Valor Total de <b>R$ <?php print("$total"); ?></b><br><br>
<b>Forma de pagamento:</b> <?php print("$l_pagto"); ?><br><br>
<a href="historico_sinal.php?cod=<?=$cod; ?>&codi=<?=$_SESSION['cod_imobiliaria']; ?>&m=1" class="style1">
<b>Clique aqui para visualizar os sinais de negócio.</b></a></span>
<!--a href="impressao_venda.php?imp=<?php print($contrato); ?>&cod=<?php print("$cod"); ?>&l_cod=<?php print("$l_cod"); ?>" class="style1">
<b>Clique aqui para imprimir o contrato de venda.</b></a></span-->
<?php
			}
		 } else {
			echo $msg."<br>";
			echo "<tr>
      				<td align=\"center\"><a href=\"javascript:history.back()\" class=\"style1\">Voltar</a></td>
    			  </tr>";
		}
	}//Termina numrows7

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
