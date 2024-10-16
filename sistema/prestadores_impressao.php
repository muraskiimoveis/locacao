<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_PRESTADORES");
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
<style media="print">
   .noprint { display: none }
</style>
</head>

<body>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><div align="left">
<?
$p_sql = "SELECT * FROM tipos_prestadores";
$p_rs = mysql_query($p_sql) or die ("Erro 30");
while ($p_not = mysql_fetch_assoc($p_rs)) {
   $todos_prestadores[$p_not[tp_cod]]["cod"] = $p_not[tp_cod];
   $todos_prestadores[$p_not[tp_cod]]["tipo"] = $p_not[tp_tipo];
	$todos_prestadores[$p_not[tp_cod]]["icone"] = $p_not[tp_icone];
}
$c_sql = "SELECT * FROM tipos_clientes";
$c_rs = mysql_query($c_sql) or die ("Erro 36");
while ($c_not = mysql_fetch_assoc($c_rs)) {
   $todos_clientes[$c_not[tc_cod]]["cod"] = $c_not[tc_cod];
   $todos_clientes[$c_not[tc_cod]]["tipo"] = $c_not[tc_tipo];
   $todos_clientes[$c_not[tc_cod]]["icone"] = $c_not[tc_icone];
}
$logo_imob = $_SESSION['logo_imob'];
$caminho_logo = "../logos/";
if (file_exists($caminho_logo.$logo_imob))
{
?>
   <img src="<?php print($caminho_logo.$logo_imob); ?>" border="0"></div></td>
<?
}
?>
  </tr>
</table>
<?php
$data_inicial = $_GET['data_inicial'];
$data_final = $_GET['data_final'];
$tipo_prestador = $_GET['tipo_prestador'];
$prestador = $_GET['prestador'];
$status = $_GET['status'];

$data1 = formataDataParaBd($data_inicial);
$data2 = formataDataParaBd($data_final);
?>
<br>
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="2" class="style1" align="center"><b>Relat&oacute;rio de Prestadores</b></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1" align="center"><b>Per&iacute;odo:</b> <?= $data_inicial; ?> &agrave; <?= $data_final; ?></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">
      <b>Tipo Prestador:</b>
<?php
if($tipo_prestador <> 'Todos')
{
   $sqlTipoPrestador = "select tp_tipo from tipos_prestadores where tp_cod = '$tipo_prestador'";
   $buscaTipoPrestador = mysql_query($sqlTipoPrestador) or die ("Erro 80");
   $colunaTipoPrestador = mysql_fetch_array($buscaTipoPrestador);
   print $colunaTipoPrestador['tp_tipo'];
}
else
{
	echo 'Todos';
}
?>
        <br>
      <b>Prestador:</b>
<?
//REALIZA BUSCA DO TIPO PRESTADOR SELECIONADO OU TODOS
if ($tipo_prestador <> 'Todos') {
   //REALIZA BUSCA DO PRESTADOR SELECIONADO OU TODOS
   if($prestador <> ''){
      $bprestador = mysql_query("SELECT c_nome FROM clientes WHERE c_cod='".$prestador."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 96");
      while($linha = mysql_fetch_array($bprestador)){
         print $linha['c_nome'];
      }
   } else {
      echo "Todos";
   }
} else {
   echo "Todos";
}
?>
	  <br>
      <b>Status:</b>
<?
//REALIZA BUSCA DO TIPO PRESTADOR SELECIONADO OU TODOS
if ($status<>'') {
   print $status;
} else {
   print "Todos";
}
?>
	  </td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
<?

//|1|REALIZA BUSCA POR TODOS OS TIPOS DE PRESTADORES E TODOS OS PRESTADORES E TODOS OS STATUS
if($tipo_prestador == 'Todos' && $prestador=='' && $status==''){

   print '
      <tr class="fundoTabelaTitulo">
         <td colspan="2" class="style1"><b>Im&oacute;vel</b></td>
         <td width="10%" class="style1"><b>Tipo</b></td>
         <td width="11%" class="style1"><b>Prestador</b></td>
         <td width="13%" class="style1"><b>Data</b></td>
         <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
         <td width="8%" class="style1"><b>Valor</b></td>
         <td width="16%" class="style1"><b>Status</b></td>
      </tr>
   ';

   $sqlp = "SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc, co.co_despesa FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod)  WHERE co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   $buscap = mysql_query($sqlp) or die ("Erro 142");
   $i = 0;
   $k = 1;
   while($linha = mysql_fetch_array($buscap)){
      if($linha['finalidade']=='8' || $linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14' || $linha['finalidade']=='15' || $linha['finalidade']=='16' || $linha['finalidade']=='17'){
         $pasta_finalidade = "locacao_peq";
      }
      else
      {
         $pasta_finalidade = "venda_peq";
      }
      $pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";

      $nome_foto1 = $linha['ref'] . "_1_peq" . ".jpg";

      	if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
		$k++;
      
      	if($linha['co_despesa'] == "Imobiliária"){ 
			$fundo = '#e3e3e3';
		}

      echo ("
         <tr bgcolor=\"$fundo\">
         <td width=\"7%\" class=\"style1\">
      ");

      if (file_exists($pasta.$nome_foto1))
      {
         echo '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';
      }
      else
      {
         echo '<img src="images/sem_foto.gif" border="0" width="100" />';
      }

      echo "</td><td width=\"36%\" class=\"style1\">" . $linha['ref'] . " - " . $linha['tipo_logradouro'] . " " . $linha['end'] . ", " . $linha['numero'] . "</td>
         <td class=\"style1\">";

      if ($linha[c_prestador2] == "") {
         echo $linha[c_prestador];
      } else {
         $t_prestador = explode("--", $linha[c_prestador2]);
         $t_prestador = str_replace("-","",$t_prestador);
         foreach ($t_prestador as $t_prest) {
            print $todos_prestadores[$t_prest][tipo] . "<br />";
         }
      }
      echo "</td>
         <td class=\"style1\">".$linha['c_nome']." </td>
         <td class=\"style1\">".$linha['data_servico']."</td>
         <td class=\"style1\">".$linha['co_desc']."</td>
         <td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
      ";
      if($linha['co_status'] == "ok"){
         echo "<td class=\"style6\">OK</td>";
      }else{
         echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span></td>");
      }
      echo "</tr>";

      $total = $total + $linha['co_valor'];
      $i++;
   }

   $sqlpen = "SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   $buscapen = mysql_query($sqlpen) or die ("Erro 203");
   while($linhapen = mysql_fetch_array($buscapen)){
      $total_pendente = $total_pendente + $linhapen['co_valor'];
   }

   $sqlok = "SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='OK' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   $buscaok = mysql_query($sqlok) or die ("Erro 209");
   while($linhaok = mysql_fetch_array($buscaok)){
      $total_ok = $total_ok + $linhaok['co_valor'];
   }

	//BUSCA DA SOLICITACAO DE SERVICOS
   $sqlp2 = "SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   $buscap2 = mysql_query($sqlp2) or die ("Erro 1639");
   $i2 = 0;
   $k2 = 1;
   while($linha2 = mysql_fetch_array($buscap2)){
      if ($linha2['finalidade']=='8' || $linha2['finalidade']=='9' || $linha2['finalidade']=='10' || $linha2['finalidade']=='11' || $linha2['finalidade']=='12' || $linha2['finalidade']=='13' || $linha2['finalidade']=='14' || $linha2['finalidade']=='15' || $linha2['finalidade']=='16' || $linha2['finalidade']=='17') {
         $pasta_finalidade = "locacao_peq";
      }
      else
      {
         $pasta_finalidade = "venda_peq";
      }
      $pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
      $nome_foto1 = $linha2['ref'] . "_1_peq" . ".jpg";

      	if (($k2 % 2) == 1){ $fundo2="$cor14"; }else{ $fundo2="$cor6"; }
		$k2++;

      echo "
         <tr bgcolor=\"$fundo2\">
            <td width=\"7%\" class=\"style1\">";

      if (file_exists($pasta.$nome_foto1))
      {
         echo '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';
      }
      else
      {
         echo '<img src="images/sem_foto.gif" border="0" width="100" />';
      }

      echo "</td><td width=\"36%\" class=\"style1\">".$linha2['ref']." - ".$linha2['tipo_logradouro']." ".$linha2['end'].", ".$linha2['numero']."</td>
         <td class=\"style1\">";

      if ($linha2[c_prestador2] == "") {
         echo $linha2[c_prestador];
      } else {
         $t_prestador = explode("--", $linha2[c_prestador2]);
         $t_prestador = str_replace("-","",$t_prestador);
         foreach ($t_prestador as $t_prest) {
            print $todos_prestadores[$t_prest][tipo] . "<br />";
         }
      }

      echo " </td>
         <td class=\"style1\">".$linha2['c_nome']."</td>
         <td class=\"style1\">".$linha2['data_servico']."</td>
         <td class=\"style1\">".$linha2['comentario']."</td>
         <td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
      ";

      if($linha2['status'] == "ok"){
         echo "<td class=\"style6\">OK</td>";
      } else {
         echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span></td>");
      }
      echo "
         </tr>
      ";
      $total2 = $total2 + $linha2['valor_servico'];
      $i2++;
   }

   	$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 278");
	while($linhapen2 = mysql_fetch_array($buscapen2)){
      $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
   }

   	$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 283");
	while($linhaok2 = mysql_fetch_array($buscaok2)){
      $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
   }

   $totais_pendente = $total_pendente + $total_pendente2;
   $totais_ok = $total_ok + $total_ok2;
   $total_geral = $total + $total2;

   echo "
      </table></td>
     </tr>
     <tr>
      <td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($totais_ok,2,',','.')."</td>
     </tr>
     <tr>
      <td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($totais_pendente,2,',','.')."</td>
     </tr>
     <tr>
      <td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
     </tr>
   ";

   //|2|REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E TODOS OS PRESTADORES E TODOS OS STATUS
   } elseif($tipo_prestador <> 'Todos' && $prestador=='' && $status=='') {

      echo'
         <tr class="fundoTabelaTitulo">
            <td colspan="2" class="style1"><b>Im&oacute;vel</b></td>
            <td width="10%" class="style1"><b>Tipo</b></td>
            <td width="11%" class="style1"><b>Prestador</b></td>
            <td width="13%" class="style1"><b>Data</b></td>
            <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
            <td width="8%" class="style1"><b>Valor</b></td>
	         <td width="16%" class="style1"><b>Status</b></td>
         </tr>
      ';
      //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
    $sqlp = "SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc, co.co_despesa FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$buscap = mysql_query($sqlp) or die ("Erro 322");
	$i = 0;
	$k = 1;
	while($linha = mysql_fetch_array($buscap)){
         if($linha['finalidade']=='8' || $linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14' || $linha['finalidade']=='15' || $linha['finalidade']=='16' || $linha['finalidade']=='17'){
            $pasta_finalidade = "locacao_peq";
         }
         else
         {
            $pasta_finalidade = "venda_peq";
         }
         $pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";

         $nome_foto1 = $linha['ref'] . "_1_peq" . ".jpg";

         	if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
			$k++;
         
         if($linha['co_despesa'] == "Imobiliária"){ 
			$fundo = '#e3e3e3';
		}
         
         echo "
            <tr bgcolor=\"$fundo\">
               <td width=\"7%\" class=\"style1\">";

         if (file_exists($pasta.$nome_foto1))
         {
            echo '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';
         }
         else
         {
            echo '<img src="images/sem_foto.gif" border="0" width="100" />';
         }

         echo"</td><td width=\"36%\" class=\"style1\">".$linha['ref']." - ".$linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero']."</td>
            <td class=\"style1\">";


      if ($linha[c_prestador2] == "") {
         echo $linha[c_prestador];
      } else {
         $t_prestador = explode("--", $linha[c_prestador2]);
         $t_prestador = str_replace("-","",$t_prestador);
         foreach ($t_prestador as $t_prest) {
            print $todos_prestadores[$t_prest][tipo] . "<br />";
         }
      }


         echo "</td>
            <td class=\"style1\">".$linha['c_nome']."</td>
            <td class=\"style1\">".$linha['data_servico']."</td>
            <td class=\"style1\">".$linha['co_desc']."</td>
            <td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
         ";
         if($linha['co_status'] == "ok"){
            echo "<td class=\"style6\">OK</td>";
         }else{
            echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span></td>");
         }
         echo("
            </tr>
         ");
         $total = $total + $linha['co_valor'];
         $i++;
      }

      	$sqlpen = "SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$buscapen = mysql_query($sqlpen) or die ("Erro 386");
		while($linhapen = mysql_fetch_array($buscapen)){
         	$total_pendente = $total_pendente + $linhapen['co_valor'];
      	}

      	$sqlok = "SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$buscaok = mysql_query($sqlok) or die ("Erro 392");
		while($linhaok = mysql_fetch_array($buscaok)){
         	$total_ok = $total_ok + $linhaok['co_valor'];
      	}

      //BUSCA DA SOLICITACAO DE SERVICOS
    $sqlp2 = "SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$buscap2 = mysql_query($sqlp2) or die ("Erro 399");
	$i2 = 0;
	$k2 = 1;
	while($linha2 = mysql_fetch_array($buscap2)){
         if($linha2['finalidade']=='8' || $linha2['finalidade']=='9' || $linha2['finalidade']=='10' || $linha2['finalidade']=='11' || $linha2['finalidade']=='12' || $linha2['finalidade']=='13' || $linha2['finalidade']=='14' || $linha2['finalidade']=='15' || $linha2['finalidade']=='16' || $linha2['finalidade']=='17'){
            $pasta_finalidade = "locacao_peq";
         }
         else
         {
            $pasta_finalidade = "venda_peq";
         }
							$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";

							$nome_foto1 = $linha2['ref'] . "_1_peq" . ".jpg";

							if (($k2 % 2) == 1){ $fundo2="$cor14"; }else{ $fundo2="$cor6"; }
							$k2++;
							echo ("
								<tr bgcolor=\"$fundo2\">
          							<td width=\"7%\" class=\"style1\">");

										if (file_exists($pasta.$nome_foto1))
										{
											echo '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';
					    				}
					    				else
										{
											echo '<img src="images/sem_foto.gif" border="0" width="100" />';
										}

						    		echo"</td><td width=\"36%\" class=\"style1\">".$linha2['ref']." - ".$linha2['tipo_logradouro']." ".$linha2['end'].", ".$linha2['numero']."</td>
          							<td class=\"style1\">";

                           if ($linha2[c_prestador2] == "") {
                              echo $linha2[c_prestador];
                           } else {
                              $t_prestador = explode("--", $linha2[c_prestador2]);
                              $t_prestador = str_replace("-","",$t_prestador);
                              foreach ($t_prestador as $t_prest) {
                                 print $todos_prestadores[$t_prest][tipo] . "<br />";
                              }
                           }
                           echo "</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					";
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}
		
						$sqlpen2 = "SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%')";
						$buscapen2 = mysql_query($sqlpen2) or die ("Erro 460");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}

						$sqlok2 = "SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'  AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%')";
						$buscaok2 = mysql_query($sqlok2) or die ("Erro 465");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}

						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                
						echo("
				      		</table></td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($totais_ok,2,',','.')."</td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($totais_pendente,2,',','.')."</td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    						</tr>
						");
			
			//|3|REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E PRESTADOR SELECIONADO E TODOS OS STATUS
			}elseif($tipo_prestador <> 'Todos' && $prestador<>'' && $status==''){
			  
			  echo('
				<tr class="fundoTabelaTitulo">
       				<td colspan="2" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="16%" class="style1"><b>Status</b></td>
				</tr>

			  ');
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
					$sqlp = "SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, c_prestador2, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc, co.co_despesa FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$prestador."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscap = mysql_query($sqlp) or die ("Erro 506");
					$i = 0;
					$k = 1;
					while($linha = mysql_fetch_array($buscap)){
							if($linha['finalidade']=='8' || $linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14' || $linha['finalidade']=='15' || $linha['finalidade']=='16' || $linha['finalidade']=='17'){
								$pasta_finalidade = "locacao_peq";
							}
							else
							{
								$pasta_finalidade = "venda_peq";
							}
							$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";

							$nome_foto1 = $linha['ref'] . "_1_peq" . ".jpg";

							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							
							if($linha['co_despesa'] == "Imobiliária"){ 
								$fundo = '#e3e3e3';
							}
							
							echo ("
								<tr bgcolor=\"$fundo\">
          							<td width=\"7%\" class=\"style1\">");

										if (file_exists($pasta.$nome_foto1))
										{
											echo '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';
					    				}
					    				else
										{
											echo '<img src="images/sem_foto.gif" border="0" width="100" />';
										}

						    		echo"</td><td width=\"36%\" class=\"style1\">".$linha['ref']." - ".$linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero']."</td>
          							<td class=\"style1\">";

      if ($linha[c_prestador2] == "") {
         echo $linha[c_prestador];
      } else {
         $t_prestador = explode("--", $linha[c_prestador2]);
         $t_prestador = str_replace("-","",$t_prestador);
         foreach ($t_prestador as $t_prest) {
            print $todos_prestadores[$t_prest][tipo] . "<br />";
         }
      }

                           echo "</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					";
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}

		                $buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$prestador."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 567");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}

						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$prestador."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 572");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}

					//BUSCA DA SOLICITACAO DE SERVICOS
						$buscap2 = mysql_query("SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$prestador."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 578");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if($linha2['finalidade']=='8' || $linha2['finalidade']=='9' || $linha2['finalidade']=='10' || $linha2['finalidade']=='11' || $linha2['finalidade']=='12' || $linha2['finalidade']=='13' || $linha2['finalidade']=='14' || $linha2['finalidade']=='15' || $linha2['finalidade']=='16' || $linha2['finalidade']=='17'){
								$pasta_finalidade = "locacao_peq";
							}
							else
							{
								$pasta_finalidade = "venda_peq";
							}
							$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";

							$nome_foto1 = $linha2['ref'] . "_1_peq" . ".jpg";

							if (($k2 % 2) == 1){ $fundo2="$cor14"; }else{ $fundo2="$cor6"; }
							$k2++;
							
							echo ("
								<tr bgcolor=\"$fundo2\">
          							<td width=\"7%\" class=\"style1\">");

										if (file_exists($pasta.$nome_foto1))
										{
											echo '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											echo '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  

						    		echo"</td><td width=\"36%\" class=\"style1\">".$linha2['ref']." - ".$linha2['tipo_logradouro']." ".$linha2['end'].", ".$linha2['numero']."</td>
          							<td class=\"style1\">";

                              if ($linha2[c_prestador2] == "") {
                                 echo $linha2[c_prestador];
                              } else {
                                 $t_prestador = explode("--", $linha2[c_prestador2]);
                                 $t_prestador = str_replace("-","",$t_prestador);
                                 foreach ($t_prestador as $t_prest) {
                                    print $todos_prestadores[$t_prest][tipo] . "<br />";
                                 }
                              }

                           echo "</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					";
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}
		
						$sqlpen2 = "SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$prestador."'";
						$buscapen2 = mysql_query($sqlpen2) or die ("Erro 640");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}

						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$prestador."'") or die ("Erro 645");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}

						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                
						echo("
				      		</table></td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($totais_ok,2,',','.')."</td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($totais_pendente,2,',','.')."</td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    						</tr>
						");
			  
		  //|4|REALIZA BUSCA POR TODOS OS TIPOS DE PRESTADORES E TODOS OS PRESTADORES E O STATUS SELECIONADO
		  }elseif($tipo_prestador == 'Todos' && $prestador=='' && $status<>''){

			echo('
				<tr class="fundoTabelaTitulo">
       				<td colspan="2" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="16%" class="style1"><b>Status</b></td>
				</tr>

			');
				
						$buscap = mysql_query("SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc, co.co_despesa FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_data BETWEEN '$data1' AND '$data2' AND co.co_status='".$status."' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 684");
						$i = 0;
						$k = 1;
						while($linha = mysql_fetch_array($buscap)){
							if($linha['finalidade']=='8' || $linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14' || $linha['finalidade']=='15' || $linha['finalidade']=='16' || $linha['finalidade']=='17'){
								$pasta_finalidade = "locacao_peq";
							}
							else
							{
								$pasta_finalidade = "venda_peq";
							}
							$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						
							$nome_foto1 = $linha['ref'] . "_1_peq" . ".jpg";
							
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							
							if($linha['co_despesa'] == "Imobiliária"){ 
								$fundo = '#e3e3e3';
							}
							
							echo ("
								<tr bgcolor=\"$fundo\">
          							<td width=\"7%\" class=\"style1\">");
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											echo '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											echo '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
                           echo"</td><td width=\"36%\" class=\"style1\">".$linha['ref']." - ".$linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero']."</td>
          							<td class=\"style1\">";

      if ($linha[c_prestador2] == "") {
         echo $linha[c_prestador];
      } else {
         $t_prestador = explode("--", $linha[c_prestador2]);
         $t_prestador = str_replace("-","",$t_prestador);
         foreach ($t_prestador as $t_prest) {
            print $todos_prestadores[$t_prest][tipo] . "<br />";
         }
      }

                           echo "</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					";
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		
						$buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 746");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}

						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='OK' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 751");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}

					//BUSCA DA SOLICITACAO DE SERVICOS
						$buscap2 = mysql_query("SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.data_servico BETWEEN '$data1' AND '$data2' AND s.status='".$status."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 757");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if($linha2['finalidade']=='8' || $linha2['finalidade']=='9' || $linha2['finalidade']=='10' || $linha2['finalidade']=='11' || $linha2['finalidade']=='12' || $linha2['finalidade']=='13' || $linha2['finalidade']=='14' || $linha2['finalidade']=='15' || $linha2['finalidade']=='16' || $linha2['finalidade']=='17'){
								$pasta_finalidade = "locacao_peq";
							}
							else
							{
								$pasta_finalidade = "venda_peq";
							}
							$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";

							$nome_foto1 = $linha2['ref'] . "_1_peq" . ".jpg";

							if (($k2 % 2) == 1){ $fundo2="$cor14"; }else{ $fundo2="$cor6"; }
							$k2++;
							echo ("
								<tr bgcolor=\"$fundo2\">
          							<td width=\"7%\" class=\"style1\">");

										if (file_exists($pasta.$nome_foto1))
										{
											echo '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';
					    				}
					    				else
										{
											echo '<img src="images/sem_foto.gif" border="0" width="100" />';
										}

                           echo "</td><td width=\"36%\" class=\"style1\">".$linha2['ref']." - ".$linha2['tipo_logradouro']." ".$linha2['end'].", ".$linha2['numero']."</td>
                              <td class=\"style1\">";


                           if ($linha2[c_prestador2] == "") {
                              echo $linha2[c_prestador];
                           } else {
                              $t_prestador = explode("--", $linha2[c_prestador2]);
                              $t_prestador = str_replace("-","",$t_prestador);
                              foreach ($t_prestador as $t_prest) {
                                 print $todos_prestadores[$t_prest][tipo] . "<br />";
                              }
                           }

                           echo "</td>
                              <td class=\"style1\">".$linha2['c_nome']."</td>
                              <td class=\"style1\">".$linha2['data_servico']."</td>
                              <td class=\"style1\">".$linha2['comentario']."</td>
                              <td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
                           ";
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}

						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 819");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}

						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 824");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}

						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                				
		                
						echo("
				      		</table></td>
    						</tr>
    					");
    					if($status=='ok'){
    					echo("
    						<tr>
      							<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($totais_ok,2,',','.')."</td>
    						</tr>
    					");
    					}else{
    					  echo("
    						<tr>
      							<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($totais_pendente,2,',','.')."</td>
    						</tr>
    					  ");
    					}
    					  echo("
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    						</tr>
						");

			//|5|REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E TODOS OS PRESTADORES E O STATUS SELECIONADO
			}elseif($tipo_prestador <> 'Todos' && $prestador=='' && $status<>''){

			 echo('
				<tr class="fundoTabelaTitulo">
       				<td colspan="2" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="16%" class="style1"><b>Status</b></td>
				</tr>
			  ');
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
						$buscap = mysql_query("SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc, co.co_despesa FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_status='".$status."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 872");
						$i = 0;
						$k = 1;
						while($linha = mysql_fetch_array($buscap)){
							if($linha['finalidade']=='8' || $linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14' || $linha['finalidade']=='15' || $linha['finalidade']=='16' || $linha['finalidade']=='17'){ 
								$pasta_finalidade = "locacao_peq";
							}
							else
							{
								$pasta_finalidade = "venda_peq";
							}
							$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						
							$nome_foto1 = $linha['ref'] . "_1_peq" . ".jpg";
							
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							
							if($linha['co_despesa'] == "Imobiliária"){ 
								$fundo = '#e3e3e3';
							}
							
							echo ("
								<tr bgcolor=\"$fundo\">
          							<td width=\"7%\" class=\"style1\">");
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											echo '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											echo '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    		echo "</td><td width=\"36%\" class=\"style1\">".$linha['ref']." - ".$linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero']."</td>
          							<td class=\"style1\">";

                              if ($linha[c_prestador2] == "") {
                                 echo $linha[c_prestador];
                              } else {
                                 $t_prestador = explode("--", $linha[c_prestador2]);
                                 $t_prestador = str_replace("-","",$t_prestador);
                                 foreach ($t_prestador as $t_prest) {
                                    print $todos_prestadores[$t_prest][tipo] . "<br />";
                                 }
                              }
                           echo "</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					";
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		
						$buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 932");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}
						
						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 937");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}

					//BUSCA DA SOLICITACAO DE SERVICOS
						$buscap2 = mysql_query("SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.status='".$status."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 943");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if($linha2['finalidade']=='8' || $linha2['finalidade']=='9' || $linha2['finalidade']=='10' || $linha2['finalidade']=='11' || $linha2['finalidade']=='12' || $linha2['finalidade']=='13' || $linha2['finalidade']=='14' || $linha2['finalidade']=='15' || $linha2['finalidade']=='16' || $linha2['finalidade']=='17'){
								$pasta_finalidade = "locacao_peq";
							}
							else
							{
								$pasta_finalidade = "venda_peq";
							}
							$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";

							$nome_foto1 = $linha2['ref'] . "_1_peq" . ".jpg";

							if (($k2 % 2) == 1){ $fundo2="$cor14"; }else{ $fundo2="$cor6"; }
							$k2++;
							echo ("
								<tr bgcolor=\"$fundo2\">
          							<td width=\"7%\" class=\"style1\">");

										if (file_exists($pasta.$nome_foto1))
										{
											echo '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';
					    				}
					    				else
										{
											echo '<img src="images/sem_foto.gif" border="0" width="100" />';
										}

						    		echo "</td><td width=\"36%\" class=\"style1\">".$linha2['ref']." - ".$linha2['tipo_logradouro']." ".$linha2['end'].", ".$linha2['numero']."</td>
          							<td class=\"style1\">";


                              if ($linha2[c_prestador2] == "") {
                                 echo $linha2[c_prestador];
                              } else {
                                 $t_prestador = explode("--", $linha2[c_prestador2]);
                                 $t_prestador = str_replace("-","",$t_prestador);
                                 foreach ($t_prestador as $t_prest) {
                                    print $todos_prestadores[$t_prest][tipo] . "<br />";
                                 }
                              }

                           echo "</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					";
                        if ($linha2['status'] == "ok") {
                           echo "<td class=\"style6\">OK</td>";
                        } else {
                           echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span></td>");
                        }
                        echo"
           						</tr>
                        ";
                     $total2 = $total2 + $linha2['valor_servico'];
                     $i2++;
						}

						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%')") or die ("Erro 1005");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}
						
						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%')") or die ("Erro 1010");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;					
		                
						echo("
				      		</table></td>
    						</tr>
    					");
    					if($status=='ok'){
    					echo("
    						<tr>
      							<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($totais_ok,2,',','.')."</td>
    						</tr>
    					");
    					}else{
    					  echo("
    						<tr>
      							<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($totais_pendente,2,',','.')."</td>
    						</tr>
    					  ");
    					}
    					  echo("
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    						</tr>
						");
			
			//|6|REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E PRESTADOR SELECIONADO E O STATUS SELECIONADO
			}elseif($tipo_prestador <> 'Todos' && $prestador<>'' && $status<>''){
			  
			  echo('
				<tr class="fundoTabelaTitulo">
       				<td colspan="2" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="16%" class="style1"><b>Status</b></td>
				</tr>

			  ');
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
						$buscap = mysql_query("SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc, co.co_despesa FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$prestador."' AND co.co_status='".$status."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 1058");
						$i = 0;
						$k = 0;
						while($linha = mysql_fetch_array($buscap)){
							if($linha['finalidade']=='8' || $linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14' || $linha['finalidade']=='15' || $linha['finalidade']=='16' || $linha['finalidade']=='17'){ 
								$pasta_finalidade = "locacao_peq";
							}
							else
							{
								$pasta_finalidade = "venda_peq";
							}
							$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						
							$nome_foto1 = $linha['ref'] . "_1_peq" . ".jpg";
							
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							
							if($linha['co_despesa'] == "Imobiliária"){ 
								$fundo = '#e3e3e3';
							}
							
							echo ("
								<tr bgcolor=\"$fundo\">
          							<td width=\"7%\" class=\"style1\">");
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											echo '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											echo '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    		echo"</td><td width=\"36%\" class=\"style1\">".$linha['ref']." - ".$linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero']."</td>
          							<td class=\"style1\">";

      if ($linha[c_prestador2] == "") {
         echo $linha[c_prestador];
      } else {
         $t_prestador = explode("--", $linha[c_prestador2]);
         $t_prestador = str_replace("-","",$t_prestador);
         foreach ($t_prestador as $t_prest) {
            print $todos_prestadores[$t_prest][tipo] . "<br />";
         }
      }
                            echo  "</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					";
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		                
		                $buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$prestador."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 1118");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}

						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$prestador."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 1123");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}

					//BUSCA DA SOLICITACAO DE SERVICOS
						$buscap2 = mysql_query("SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$prestador."' AND s.status='".$status."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 1129");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if($linha2['finalidade']=='8' || $linha2['finalidade']=='9' || $linha2['finalidade']=='10' || $linha2['finalidade']=='11' || $linha2['finalidade']=='12' || $linha2['finalidade']=='13' || $linha2['finalidade']=='14' || $linha2['finalidade']=='15' || $linha2['finalidade']=='16' || $linha2['finalidade']=='17'){ 
								$pasta_finalidade = "locacao_peq";
							}
							else
							{
								$pasta_finalidade = "venda_peq";
							}
							$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						
							$nome_foto1 = $linha2['ref'] . "_1_peq" . ".jpg";
							
							if (($k2 % 2) == 1){ $fundo2="$cor14"; }else{ $fundo2="$cor6"; }
							$k2++;
							echo ("
								<tr bgcolor=\"$fundo2\">
          							<td width=\"7%\" class=\"style1\">");
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											echo '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											echo '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    		echo"</td><td width=\"36%\" class=\"style1\">".$linha2['ref']." - ".$linha2['tipo_logradouro']." ".$linha2['end'].", ".$linha2['numero']."</td>
          							<td class=\"style1\">";
      if ($linha2[c_prestador2] == "") {
         echo $linha2[c_prestador];
      } else {
         $t_prestador = explode("--", $linha2[c_prestador2]);
         $t_prestador = str_replace("-","",$t_prestador);
         foreach ($t_prestador as $t_prest) {
            print $todos_prestadores[$t_prest][tipo] . "<br />";
         }
      }
                           echo "</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					";
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}
		
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$prestador."'") or die ("Erro 1188");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}

						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$prestador."'") or die ("Erro 1193");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                		                
						echo("
				      		</table></td>
    						</tr>
    					");
    					if($status=='ok'){
    					echo("
    						<tr>
      							<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($totais_ok,2,',','.')."</td>
    						</tr>
    					");
    					}else{
    					  echo("
    						<tr>
      							<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($totais_pendente,2,',','.')."</td>
    						</tr>
    					  ");
    					}
    					  echo("
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    						</tr>
						");
			  
			}	
		?>
	<tr>
	  <td colspan="2" class="style1" align="center"><input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print();"><br /><br /><br />
	  </td>
    </tr>			
  </table>
</table>
<?
mysql_close($con);
?>
</body>
</html>