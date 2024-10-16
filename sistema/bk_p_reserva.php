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
	$query7 = "SELECT * FROM locacao WHERE l_imovel='$cod'
	AND ('$ano-$mes-$dia' BETWEEN l_data_ent AND l_data_sai OR
	'$ano1-$mes1-$dia1' BETWEEN l_data_ent AND l_data_sai) and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	//print $query7;
	$result7 = mysql_query($query7);
	$numrows7 = mysql_num_rows($result7);
	if($numrows7 > 0) {
	#while($not7 = mysql_fetch_array($result7))
	#{
?>
<tr><td colspan=3 align=center class=style1>
O imóvel está locado.
</td></tr>
<?php
	#}//Termina while 7
	}//Termina numrows 7
	else
	{

		$query8 = "SELECT * FROM muraski WHERE cod='$cod'
        	AND ('$ano-$mes-$dia' BETWEEN data_inicio AND data_fim
	        AND '$ano1-$mes1-$dia1' BETWEEN data_inicio AND data_fim) and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		//print $query8;
        	$result8 = mysql_query($query8);
	        $numrows8 = mysql_num_rows($result8);
		if ($numrows8 == 0) {
?>
<tr><td colspan=3 align=center class=style1>
O imóvel não está disponível para locação no período de <?="$dia/$mes/$ano"?> a <?="$dia1/$mes1/$ano1"?>.
</td></tr>
<?php
		} else {

			while($not8 = mysql_fetch_array($result8))
			{

			$l_total = str_replace(".", "", $l_total);
			$l_total = str_replace(",", ".", $l_total);
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
			//print("$co_cliente, $cod, $ano-$mes-$dia, $ano1-$mes1-$dia1, $l_total
			//, $l_pagto, $l_limpeza, $total");

			//Insere os produtos na tabela de Locação
			$query2= "insert into locacao (cod_imobiliaria, l_cliente, l_imovel, l_data_ent, l_data_sai
			, l_total, l_pagto, l_limpeza, l_comissao, l_saldo, l_data, l_tv, l_usuario)
			values('".$_SESSION['cod_imobiliaria']."', '$co_cliente', '$cod', '$ano-$mes-$dia', '$ano1-$mes1-$dia1', '$l_total'
			, '$l_pagto', '$l_limpeza', '$l_comissao', '$saldo', current_date, '$l_tv', '$valid_user')";
			$result2 = mysql_query($query2) or die("Não foi possível atualizar suas informações.(Sessão existente)");
			$l_cod = mysql_insert_id();

			$total = number_format($total, 2, ',', '.');
			$total_dias = number_format($l_total, 2, ',', '.');
			$limpeza = number_format($l_limpeza, 2, ',', '.');
			$tv = number_format($l_tv, 2, ',', '.');

			$query1 = "select * from muraski
			where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result1 = mysql_query($query1);
			while($not1 = mysql_fetch_array($result1))
			{
				$imovel = "Ref.: ". $not1[ref] . " - " . $not1[titulo];
				$proprietario = $not1[cliente];
				$contrato = $not1[contrato];
				$valor_comissao = $not1[comissao] / 100;

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
			, '$co_pendente', '$l_tv', '$l_cod', '$valid_user', '$forma_tv', $data_status)";
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

				$query9 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."', '$co_cliente', 'Receber', '$cod', '$l_pagto', 'Locação', '$ano_parc[$j]-$mes_parc[$j]-$dia_parc[$j]', '$co_pendente', '$parc[$j]', '$l_cod', '$valid_user', '$forma[$j]', $data_status, '$co_fixar')";
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

				$query90 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."','$proprietario', 'Pagar', '$cod', '$l_pagto', 'Locação', '$anop1-$mesp1-$diap1', 'pendente', '$parcelas', '$l_cod', '$valid_user', 'Depósito', $data_status, '$co_fixar')";
				$result90 = mysql_query($query90) or die("Não foi possível atualizar suas informações." . $query90);

				$data_parc2 = $dia1 . "/" . $mes1 . "/" . $ano1;
				$datap2 = dateadd("5",$data_parc2);

				$anop2 = substr ($datap2, 6, 4);
				$mesp2 = substr ($datap2, 3, 2);
				$diap2 = substr ($datap2, 0, 2);

				$query100 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."', '$proprietario', 'Pagar', '$cod', '$l_pagto', 'Locação', '$anop2-$mesp2-$diap2', 'pendente', '$parcelas', '$l_cod', '$valid_user', 'Depósito', $data_status, '$co_fixar')";
				$result100 = mysql_query($query100) or die("Não foi possível atualizar suas informações." . $query100);

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

			    $query10 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_fixar) values('".$_SESSION['cod_imobiliaria']."','$proprietario', 'Pagar', '$cod', '$l_pagto', 'Locação', '$ano4-$mes4-$dia4', 'pendente', '$parc_prop[$j]', '$l_cod', '$valid_user', 'Depósito', $data_status, '$co_fixar')";
				$result10 = mysql_query($query10) or die("Não foi possível atualizar suas informações." . $query10);
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
O imóvel <b><?php print("$imovel"); ?></b> foi reservado para o cliente <b><?php print("$nome"); ?></b> do dia <b><?php print("$dia/$mes/$ano"); ?></b> à <b><?php print("$dia1/$mes1/$ano1"); ?></b>.<br><br>
Valor Total de <b>R$ <?php print("$total"); ?></b>, referente à R$ <?php print("$total_dias"); ?> pelas diárias, R$ <?php print("$l_limpeza"); ?> taxa Administrativa e R$ <?php print("$tv"); ?> pela taxa de locação de TV.<br><br>
<b>Forma de pagamento:</b> <?php print("$l_pagto"); ?><br><br>
<form name="form1" id="form1" method="post" action="">
<a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='p_imp_doc.php?imp=9&cod=<?php print("$cod"); ?>&l_cod=<?php print("$l_cod"); ?>';form1.submit();" class="style1">
<b>Clique aqui para imprimir o contrato de locação.</b></a></span>
</form>
<!--a href="p_imp_doc.php?imp=9&cod=<?php print("$cod"); ?>&l_cod=<?php print("$l_cod"); ?>" class="style1"-->
<!--b>Clique aqui para imprimir o contrato de locação.</b></a></span-->
<?php
			}
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
