<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include("style.php");
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_LOCA");

?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
	<style media="print">
		.noprint { display: none }
	</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="4" class="style1"><div align="center"><b>Demostrativo de Contas </b>
      </div></td>
    </tr>
    <tr>
      <td width="167" class="style1">
	  <?
    $logo_imob = $_SESSION['logo_imob'];
    $caminho_logo = "../logos/";
	if (file_exists($caminho_logo.$logo_imob))
	{
?>	
	<img src="<?php print($caminho_logo.$logo_imob); ?>" border="0"></td>
<?
	}
	
	$buscac = mysql_query("SELECT * FROM locacao l INNER JOIN clientes c ON (l.l_cliente=c.c_cod) INNER JOIN muraski m ON (l.l_imovel=m.cod) WHERE l.l_cod='".$l_cod."' AND l.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
	while($linha = mysql_fetch_array($buscac)){
		$cliente = $linha['c_nome'];
		$codigo = $linha['c_cod'];
      $cod_loc = $linha['l_cod'];
		$endereco = $linha['c_end'];
		$periodo = date("m/Y");	
		$cep = $linha['c_cep'];
		$bairro = $linha['c_bairro'];
		$dia = $linha['l_venc_aluguel'];
		$cidade = $linha['c_cidade'];
		$uf = $linha['c_estado'];
		$imovel = $linha['ref']." - ".$linha['titulo'];
		$inicio = formataDataDoBd($linha['l_data_ent']);
		$final = formataDataDoBd($linha['l_data_sai']);
		$proximor = formataDataDoBd($linha['l_proximo_reajuste']);
      $total_debito = $linha['l_comissao'];
	
?>

      <td width="576" colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" class="style1"><b>Cliente: </b><?=$cliente ?></td>
          <td class="style1"><b>Código: </b><?=$codigo ?></td>
        </tr>
        <tr>
          <td colspan="2" class="style1"><b>Endereço: </b><?=$endereco ?></td>
          <td class="style1"><b>Período: </b><?=$periodo ?></td>
        </tr>
        <tr>
          <td class="style1"><b>CEP: </b><?=$cep ?></td>
          <td class="style1"><b>Bairro: </b><?=$bairro ?></td>
          <td class="style1"><b>Dia do Vencimento: </b><?=$dia ?></td>
        </tr>
        <tr>
          <td class="style1"><b>Cidade: </b><?=$cidade ?></td>
          <td colspan="2" class="style1"><b>UF: </b><?=$uf ?></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#EDEEEE">
          <td width="79%" class="style1"><b>Descri&ccedil;&atilde;o de Lan&ccedil;amentos</b></td>
          <td width="21%" class="style1"><b>Valores</b></td>
        </tr>
      </table></td>
    </tr>
    
    <tr>
      <td colspan="4" class="style1"><b>Im&oacute;vel:</b> <?=$imovel ?></td>
    </tr>
    <tr>
      <td colspan="4" class="style1"><b>Inquilino:</b> <?=$cliente ?></td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="style1"><b>In&iacute;cio Contrato:</b> <?=$inicio ?></td>
          <td class="style1"><b>Final Contrato:</b> <?=$final ?></td>
          <td class="style1"><b>Pr&oacute;ximo Reajuste:</b> <?=$proximor ?></td>
        </tr>
      </table></td>
    </tr>
    
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">        
<?
   $mes_s = date("m");
   $ano_s = date("Y");
   $mes = date("m");
   $ano = date("Y");
   if($mes_s=='01'){
      $mes_s = '12';
      $ano_s = $ano_s - 1;
   }else{
      $mes_s = $mes_s - 1;
   }
   if(strlen($mes_s)=='1'){
      $mes_s = "0".$mes_s; 
   }
         
         $baluguel = mysql_query("SELECT * FROM contas WHERE co_locacao='$l_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Receber' AND co_tipo='Locação' AND co_data LIKE '$ano_s-$mes_s-%'");   
		 while($linha4 = mysql_fetch_array($baluguel)){
            $valor_a = $linha4['co_valor'];
            $status_a = $linha4['co_status'];
            $valor_aluguel = number_format($valor_a, 2, ',', '.');
         
           echo('
					<tr>
          				<td width="79%" class="style1">Aluguel do mês '.$mes.'</td>
          				<td width="21%" class="style1">'.$valor_aluguel.'</td>
        			</tr>
				');
         }

         $buscas = mysql_query("SELECT s.valor_servico, s.data_servico, s.nome_servico FROM locacao l LEFT JOIN servicos s ON (s.locacao=l.l_cod) WHERE s.locacao='".$l_cod."' AND s.situacao!='Atrasado' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND s.data_servico like '$ano-$mes-%'");
			while($linha3 = mysql_fetch_array($buscas)){
			  					
				
				$data_servico = explode("-",$linha3['data_servico']);
				$dia_servico = $data_servico[2];
				$mes_servico = $data_servico[1];
				$ano_servico = $data_servico[0];
				$dia_atual = date("d");
				$mes_atual = date("m");
				$ano_atual = date("Y");
			   $nome_servico = $linha3['nome_servico'];	
            $valor_ser = $linha3['valor_servico'];
				$valor_servico = number_format($valor_ser, 2, ',', '.');
				
				echo('
					<tr>
          				<td width="79%" class="style1">'.$nome_servico.'</td>
          				<td width="21%" class="style1">'.$valor_servico.'</td>
        			</tr>
				');	
            
            echo('
					<tr>
          				<td width="79%" class="style1">Comissão da Imobiliaria</td>
          				<td width="21%" class="style1">-'.$total_debito.'</td>
        			</tr>
				');
            
			$total_servico = $valor_a + $valor_ser - $total_debito;				
			}
?>
      </table></td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" class="style7"><div align="right">Total do Imóvel:</div></td>
          <td width="21%" class="style1" bgcolor="#EDEEEE"><? echo(number_format($total_servico, 2, ',', '.')); ?></td>
        </tr>
      </table></td>
    </tr>
<?  
   
   //saldo do aluguel do mês anterior   
   $saldo_alu_ant = mysql_query("SELECT * FROM contas WHERE co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Receber' AND co_tipo='Locação' AND co_status='pendente' AND co_data LIKE '$ano_s-$mes_s-%'");   
   while($linha4 = mysql_fetch_array($saldo_alu_ant)){
      $saldo_aluguel_ant = $linha4['co_valor'];
   }
   
   //saldo dos servicos do mês anterior
   $serv_ant = mysql_query("SELECT * FROM contas WHERE co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Pagar' AND co_tipo='Despesas' AND co_status='pendente' AND co_data LIKE '$ano_s-$mes_s-%'");   
   while($linha4 = mysql_fetch_array($serv_ant)){
      $saldo_serv_ant = $linha4['co_valor'];
   } 
     
   //saldo que tem para o proprietario do mês anterior
   $saldo_propr_ant = mysql_query("SELECT * FROM contas WHERE co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Pagar' AND co_tipo='Locação' AND co_status='pendente' AND co_data LIKE '$ano_s-$mes_s-%'");   
   while($linha5 = mysql_fetch_array($saldo_propr_ant)){      
      $saldo_prop_ant = $linha5['co_valor'];
   } 
   
   //saldo que tem para o proprietario do mês atual
   $saldo_propr_atu = mysql_query("SELECT * FROM contas WHERE co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Pagar' AND co_tipo='Locação' AND co_status='ok' AND co_data LIKE '$ano-$mes-%'");   
   while($linha5 = mysql_fetch_array($saldo_propr_atu)){      
      $saldo_prop_atu = $linha5['co_valor'];
   }
   
   //saldo do aluguel do mês atual
   $saldo_alu_atu = mysql_query("SELECT * FROM contas WHERE co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Receber' AND co_tipo='Locação' AND co_status='ok' AND co_data LIKE '$ano-$mes-%'");   
   while($linha5 = mysql_fetch_array($saldo_alu_atu)){      
      $saldo_aluguel_atu = $linha5['co_valor'];
   } 
    
   //saldo dos servicos do mês atual
   $serv_atu = mysql_query("SELECT * FROM contas WHERE co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Pagar' AND co_tipo='Despesas' AND co_status='ok' AND co_data LIKE '$ano-$mes-%'");   
   while($linha4 = mysql_fetch_array($serv_atu)){
      $saldo_serv_atu = $linha4['co_valor'];
   }
   
   $valor_repassado = $saldo_prop_atu; 
   //$valor_prop = $saldo_prop_atu + $saldo_serv_atu;
   $saldo_anterior = $saldo_aluguel_ant + $saldo_serv_ant + $saldo_prop_ant;
   $total_credito = $saldo_aluguel_atu + $saldo_anterior;
   $total_liquido = $total_credito - $total_debito;
   $saldo_atual = $total_liquido - $valor_repassado;
   
?>    
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#EDEEEE">
          <td><div align="center" class="style1">Saldo Anterior</div></td>
          <td><div align="center" class="style1">Total Cr&eacute;dito</div></td>
          <td><div align="center" class="style1">Total D&eacute;bito</div></td>
          <td><div align="center" class="style1">Total L&iacute;quido</div></td>
          <td><div align="center" class="style1">Valor Repassado</div></td>
          <td><div align="center" class="style1">Saldo Atual</div></td>
        </tr>
        <tr>
          <td class="style1"><div align="center"><? echo(number_format($saldo_anterior, 2, ',', '.')); ?></div></td>
          <td class="style1"><div align="center"><? echo(number_format($total_credito, 2, ',', '.')); ?></div></td>
          <td class="style1"><div align="center"><? echo(number_format($total_debito, 2, ',', '.')); ?></div></td>
          <td class="style1"><div align="center"><? echo(number_format($total_liquido, 2, ',', '.')); ?></div></td>
          <td class="style1"><div align="center"><? echo(number_format($valor_repassado, 2, ',', '.')); ?></div></td>
          <td class="style1"><div align="center"><? echo(number_format($saldo_atual, 2, ',', '.')); ?></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="57%" class="style1"><b>Propriet&aacute;rio(s)</b></td>
          <td width="21%" class="style1"><b>Forma Pagamento</b></td>
          <td width="8%" class="style1">%</td>
          <td width="14%" class="style1"><b>Valor</b></td>
        </tr>
		
<?
$buscapr = mysql_query("SELECT * FROM muraski WHERE cod = '".$linha['cod']."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
while($linha4 = mysql_fetch_array($buscapr)){
	$cliente1 = explode("--", $linha4['cliente']);
	$cliente2 = str_replace("-","",$cliente1);
   $percentual1 = explode("--", $linha4['percentual_prop']);
	$percentual2 = str_replace("-","",$percentual1);
	$contador = $linha4['contador'];
	
	for($i3 = 1; $i3 <= $contador; $i3++){
		$queryC = "select * from clientes where c_cod='".$cliente2[$i3-1]."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$resultC = mysql_query($queryC);
		while($notC = mysql_fetch_array($resultC))
		{
         $tipo_pessoa = $notC['c_tipo_pessoa'];
			echo('<tr>
          		<td class="style1">'.$notC['c_nome'].' - '.$notC['c_cpf'].'</td>
          		<td class="style1">'.$notC['c_conta'].'</td>
          		<td class="style1">'.$percentual2[$i3-1].'</td>
          		<td class="style1">'.number_format($valor_repassado, 2, ',', '.').'</td>
        		</tr>');
		}
	}
}

  if($status_a=='ok'){ 
      $total_aluguel = $total_aluguel + $valor_a;
  }
       
?>		

      </table></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td colspan="4" class="style1"><div align="center"><b>Valores para fins de Imposta de Renda de M&ecirc;s (Carn&ecirc; Le&atilde;o e Mensal&atilde;o)</b></div></td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" class="style1"><div align="left"><b>Aluguel Recebido Pessoa F&iacute;sica:</b></div></td>
          <td width="21%" class="style1"><? if($tipo_pessoa=='F'){ echo(number_format($valor_a, 2, ',', '.')); } ?></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" class="style1"><div align="left"><b>Aluguel Recebido Pessoa Jur&iacute;dica:</b></div></td>
          <td width="21%" class="style1"><? if($tipo_pessoa=='J'){ echo(number_format($valor_a, 2, ',', '.')); } ?></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" class="style1"><div align="left"><b>Total Aluguel Recebido:</b></div></td>
          <td width="21%" class="style1"><? echo(number_format($total_aluguel, 2, ',', '.')); ?></td>
        </tr>
      </table></td>
    </tr>
<?
}
?>
<div class=noprint>	
	<tr>
	  <td colspan="4"><div align="center"><span class="style1">
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()"> 
	    <input id=idPrint type="submit" value="Exportar para PDF" class="campo3 noprint" onClick="form1.action='demonstrativos_pdf.php?l_cod=<?php print($l_cod); ?>';"> 
		<input id=idPrint type="button" name="fechar"  class="campo3 noprint" value="Fechar Janela" Onclick="window.close();">	
	  </span></div></td>
    </tr>
</div>
	</table>
<?
mysql_close($con);
?>
</form>
</body>
</html>