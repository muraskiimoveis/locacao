<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
ob_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
if($_GET['pdf']<>'1'){
include("style.php");
}
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_LOCA");

if($_GET['pdf']=='1'){
   
$l_cod = $_GET['l_cod'];
$buscar = $_GET['buscar'];
$cmes = $_GET['cmes'];
$cano = $_GET['cano'];

if($cmes <> '' && $cano <> ''){
	$periodo = $cmes.'/'.$cano;
}else{
    $cmes = date("m");
    $cano = date("Y");
  	$periodo = $cmes.'/'.$cano;
}

$html2 .= '<table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;"><b>Demostrativo de Contas</b></td>
    </tr>
    <tr>
      <td width="167" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';

    $logo_imob = $_SESSION['logo_imob'];
    $caminho_logo = "../logos/";
	if (file_exists($caminho_logo.$logo_imob))
	{
	
		$html2 .= '<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100"></td>';

	}
	
	$buscac = mysql_query("SELECT * FROM locacao l INNER JOIN clientes c ON (l.l_cliente=c.c_cod) INNER JOIN muraski m ON (l.l_imovel=m.cod) WHERE l.l_cod='".$l_cod."' AND l.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
	while($linha = mysql_fetch_array($buscac)){
		$cliente = $linha['c_nome'];
		$codigo = $linha['c_cod'];
      	$cod_loc = $linha['l_cod'];
		$endereco = $linha['c_end'];
		$cep = $linha['c_cep'];
		$bairro = $linha['c_bairro'];
		$dia = $linha['l_venc_aluguel'];
		$cidade = $linha['c_cidade'];
		$uf = $linha['c_estado'];
		$imovel = $linha['ref']." - ".strip_tags($linha['titulo']);
		$inicio = formataDataDoBd($linha['l_data_ent']);
		$final = formataDataDoBd($linha['l_data_sai']);
		$proximor = formataDataDoBd($linha['l_proximo_reajuste']);
      	$debitol = $linha['l_comissao'];
	
$html2 .= '<td width="576" colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Cliente:</b> '.$cliente.'</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Código:</b> '.$codigo.'</td>
        </tr>
        <tr>
          <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Endereço:</b> '.$endereco.'</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Período:</b> '.$periodo.'</td>
        </tr>
        <tr>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>CEP:</b> '.$cep.'</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Bairro:</b> '.$bairro.'</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Dia do Vencimento:</b> '.$dia.'</td>
        </tr>
        <tr>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Cidade:</b> '.$cidade.'</td>
          <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>UF:</b> '.$uf.'</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#EDEEEE">
          <td width="79%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Descri&ccedil;&atilde;o de Lan&ccedil;amentos</b></td>
          <td width="21%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Valores</b></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Im&oacute;vel:</b> '.$imovel.'</td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Inquilino:</b> '.$cliente.'</td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>In&iacute;cio Contrato:</b> '.$inicio.'</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Final Contrato:</b> '.$final.'</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;"><b>Pr&oacute;ximo Reajuste:</b> '.$proximor.'</td>
        </tr>
      </table></td>
    </tr>   
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">';        

if($buscar=='1'){

   $mes_s = $cmes;
   $ano_s = $cano;
   $mes = $cmes;
   $ano = $cano;
   if($mes_s=='01'){
      $mes_s = '12';
      $ano_s = $ano_s - 1;
   }else{
      $mes_s = $mes_s - 1;
   }
   if(strlen($mes_s)=='1'){
      $mes_s = "0".$mes_s; 
   }
   
}else{
  
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
  
}


         
         $baluguel = mysql_query("SELECT * FROM contas WHERE co_locacao='$l_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Receber' AND co_tipo='Locação' AND co_data LIKE '$ano-$mes-%'");   
		 while($linha4 = mysql_fetch_array($baluguel)){
            $valor_a = $linha4['co_valor'];
            $status_a = $linha4['co_status'];
            $valor_aluguel = number_format($valor_a, 2, ',', '.');
         
           $html2 .= '<tr>
          				<td width="79%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Aluguel do mês '.$mes.'</td>
          				<td width="21%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$valor_aluguel.'</td>
        			</tr>
				';
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
				
				$html2 .= '<tr>
          				<td width="79%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:right;">'.$nome_servico.'</td>
          				<td width="21%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:right;">'.$valor_servico.'</td>
        			</tr>
				';	
            }
            $html2 .= '<tr>
          				<td width="79%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:right;">Comissão da Imobiliaria</td>
          				<td width="21%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:right;">-'.$debitol.'</td>
        			</tr>
				';
            
			$total_servico = $valor_a + $valor_ser - $debitol;				
			

$html2 .= '</table></td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #ff0000;text-align:right">Total do Imóvel:</td>
          <td  bgcolor="#EDEEEE" width="21%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:right;"> '.number_format($total_servico, 2, ',', '.').'</td>
        </tr>
      </table></td>
    </tr>';
  
   
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
      $saldo_prop_ant += $linha5['co_valor'];
   } 
   
   //saldo que tem para o proprietario do mês atual
   $saldo_propr_atu = mysql_query("SELECT * FROM contas WHERE co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Pagar' AND co_tipo='Locação' AND co_status='ok' AND co_data LIKE '$ano-$mes-%'");   
   while($linha5 = mysql_fetch_array($saldo_propr_atu)){      
      $saldo_prop_atu += $linha5['co_valor'];
   }
   
   //saldo do aluguel do mês atual
   $saldo_alu_atu = mysql_query("SELECT * FROM contas WHERE co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Receber' AND co_tipo='Locação' AND co_status='ok' AND co_data LIKE '$ano-$mes-%'");   
   while($linha5 = mysql_fetch_array($saldo_alu_atu)){      
      $saldo_aluguel_atu = $linha5['co_valor'];
      $status_aluguel_atu = $linha5['co_status'];
   } 
    
   //saldo dos servicos do mês atual
   $serv_atu = mysql_query("SELECT * FROM contas WHERE co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Pagar' AND co_tipo='Despesas' AND co_status='ok' AND co_data LIKE '$ano-$mes-%'");   
   while($linha4 = mysql_fetch_array($serv_atu)){
      $saldo_serv_atu = $linha4['co_valor'];
   }
   
   $valor_repassado = $saldo_prop_atu; 
   if($status_aluguel_atu=='ok'){
   	$total_debito = $debitol;
   }
   //$valor_prop = $saldo_prop_atu + $saldo_serv_atu;
   $saldo_anterior = $saldo_aluguel_ant + $saldo_serv_ant + $saldo_prop_ant;
   $total_credito = $saldo_aluguel_atu + $saldo_anterior;
   $total_liquido = $total_credito - $total_debito;
   $saldo_atual = $total_liquido - $valor_repassado;
   if($status_aluguel_atu=='ok'){
   	$total_deb = $total_debito;
   }
   
$html2 .= '<tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#EDEEEE">
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Saldo Anterior</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Total Cr&eacute;dito</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Total D&eacute;bito</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Total L&iacute;quido</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Valor Repassado</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Saldo Atual</td>
        </tr>
        <tr>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">'.number_format($saldo_anterior, 2, ',', '.').'</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">'.number_format($total_credito, 2, ',', '.').'</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">'.number_format($total_deb, 2, ',', '.').'</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">'.number_format($total_liquido, 2, ',', '.').'</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">'.number_format($valor_repassado, 2, ',', '.').'</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">'.number_format($saldo_atual, 2, ',', '.').'</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="57%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Propriet&aacute;rio(s)</b></td>
          <td width="21%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Forma Pagamento</b></td>
          <td width="8%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">%</td>
          <td width="14%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Valor</b></td>
        </tr>';
		
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
			$html2 .= '<tr>
          		<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$notC['c_nome'].' - '.$notC['c_cpf'].'</td>
          		<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$notC['c_conta'].'</td>
          		<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$percentual2[$i3-1].'</td>
          		<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
				  
 			$saldo_propr_atu2 = mysql_query("SELECT * FROM contas WHERE co_cliente='".$cliente2[$i3-1]."' and co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Pagar' AND co_tipo='Locação' AND co_status='ok' AND co_data LIKE '$ano-$mes-%'");   
   			while($linha5 = mysql_fetch_array($saldo_propr_atu2)){      
      			$valor_prop = $linha5['co_valor'];
      			$html2 .= number_format($valor_prop, 2, ',', '.');
   			}	  
				 $html2 .= '</td>
        		</tr>';
		}
	}
}

  if($status_a=='ok'){ 
      $total_aluguel = $total_aluguel + $valor_a;
  }
  
  if($tipo_pessoa=='F'){
    $valor_af = number_format($valor_a, 2, ',', '.');
  }elseif($tipo_pessoa=='J'){
    $valor_aj = number_format($valor_a, 2, ',', '.');
  } 
       
$html2 .= '</table></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center"><b>Valores para fins de Imposta de Renda de M&ecirc;s (Carn&ecirc; Le&atilde;o e Mensal&atilde;o)</b></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left"><b>Aluguel Recebido Pessoa F&iacute;sica:</b></td>
          <td width="21%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$valor_af.'</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left"><b>Aluguel Recebido Pessoa Jur&iacute;dica:</b></td>
          <td width="21%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$valor_aj.'</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left"><b>Total Aluguel Recebido:</b></td>
          <td width="21%" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($total_aluguel, 2, ',', '.').'</td>
        </tr>
      </table></td>
    </tr>';

}
$html2 .= '</table>';

echo $html2;


	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	$pdf = new HTML2PDF('L','A4','fr');
	$pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$pdf->Output();
	
  
}

?>
<? if($_GET['pdf']<>'1'){ ?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
	<style media="print">
		.noprint { display: none }
	</style>
<script language="javascript">
function VerificaCampo()
{

var msg = '';

	   if(document.form1.cano.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Ano do Período.\n";
       }
       else if(document.form1.cano.value.length < 4)
	   {
		       msg += "O ano de período deve ter 4 caracteres (YYYY).\n";
       }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
            document.form1.buscar.value='1';
			document.form1.submit();
	   }

}
</script>	
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="4" class="style1"><p align="center"><b>Demostrativo de Contas </b></p>
      </td>
    </tr>
    <tr>
      <td class="style1">
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
		$cep = $linha['c_cep'];
		$bairro = $linha['c_bairro'];
		$dia = $linha['l_venc_aluguel'];
		$cidade = $linha['c_cidade'];
		$uf = $linha['c_estado'];
		$imovel = $linha['ref']." - ".strip_tags($linha['titulo']);
		$inicio = formataDataDoBd($linha['l_data_ent']);
		$final = formataDataDoBd($linha['l_data_sai']);
		$proximor = formataDataDoBd($linha['l_proximo_reajuste']);
      	$debitol = $linha['l_comissao'];
      	$mes_atual = date("m");
	
?>

      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="fundoTabela" height="25px">
          <td colspan="2" class="style1"><b>Cliente: </b><?=$cliente ?></td>
          <td class="style1"><b>Código: </b><?=$codigo ?></td>
        </tr>
        <tr class="fundoTabela" height="25px">
          <td colspan="2" class="style1"><b>Endereço: </b><?=$endereco ?></td>
          <td class="style1"><b>Período: </b><?//=$periodo ?> 
		  <select name="cmes" id="cmes" class="campo">
		  <option value="01" <? if($_POST['cmes']=='01'){ echo "SELECTED"; }elseif($mes_atual=='01'){ echo "SELECTED"; } ?>>01</option>
          <option value="02" <? if($_POST['cmes']=='02'){ echo "SELECTED"; }elseif($mes_atual=='02'){ echo "SELECTED"; } ?>>02</option>
          <option value="03" <? if($_POST['cmes']=='03'){ echo "SELECTED"; }elseif($mes_atual=='03'){ echo "SELECTED"; } ?>>03</option>
          <option value="04" <? if($_POST['cmes']=='04'){ echo "SELECTED"; }elseif($mes_atual=='04'){ echo "SELECTED"; } ?>>04</option>
          <option value="05" <? if($_POST['cmes']=='05'){ echo "SELECTED"; }elseif($mes_atual=='05'){ echo "SELECTED"; } ?>>05</option>
          <option value="06" <? if($_POST['cmes']=='06'){ echo "SELECTED"; }elseif($mes_atual=='06'){ echo "SELECTED"; } ?>>06</option>
          <option value="07" <? if($_POST['cmes']=='07'){ echo "SELECTED"; }elseif($mes_atual=='07'){ echo "SELECTED"; } ?>>07</option>
          <option value="08" <? if($_POST['cmes']=='08'){ echo "SELECTED"; }elseif($mes_atual=='08'){ echo "SELECTED"; } ?>>08</option>
          <option value="09" <? if($_POST['cmes']=='09'){ echo "SELECTED"; }elseif($mes_atual=='09'){ echo "SELECTED"; } ?>>09</option>
          <option value="10" <? if($_POST['cmes']=='10'){ echo "SELECTED"; }elseif($mes_atual=='10'){ echo "SELECTED"; } ?>>10</option>
          <option value="11" <? if($_POST['cmes']=='11'){ echo "SELECTED"; }elseif($mes_atual=='11'){ echo "SELECTED"; } ?>>11</option>
          <option value="12" <? if($_POST['cmes']=='12'){ echo "SELECTED"; }elseif($mes_atual=='12'){ echo "SELECTED"; } ?>>12</option>
      </select><input type="text" name="cano" id="cano" size="4" maxlength="4" class="campo" value="<? if($_POST['cano']){ echo($_POST['cano']); }else{ echo(date("Y")); } ?>">
		  <input type="hidden" name="buscar" id="buscar" value="0">
		  <span class="noprint">
		  <input type="button" value="Pesquisar" name="pesquisar" id="pesquisar" class="campo3" onClick="VerificaCampo();">
		  </span></td>
        </tr>
        <tr class="fundoTabela" height="25px">
          <td class="style1"><b>CEP: </b><?=$cep ?></td>
          <td class="style1"><b>Bairro: </b><?=$bairro ?></td>
          <td class="style1"><b>Dia do Vencimento: </b><?=$dia ?></td>
        </tr>
        <tr class="fundoTabela" height="25px">
          <td class="style1"><b>Cidade: </b><?=$cidade ?></td>
          <td colspan="2" class="style1"><b>UF: </b><?=$uf ?></td>
          </tr>
      </table></td>
    </tr>
    <tr height="25px">
    	<td colspan="4">&nbsp;</td>
    </tr>     
    <tr class="fundoTabela" height="25px">
      <td colspan="4" class="style1"><b>Im&oacute;vel:</b> <?=$imovel ?></td>
    </tr>
    <tr class="fundoTabela" height="25px">
      <td colspan="4" class="style1"><b>Inquilino:</b> <?=$cliente ?></td>
    </tr>
    <tr class="fundoTabela" height="25px">
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="style1"><b>In&iacute;cio Contrato:</b> <?=$inicio ?></td>
          <td class="style1"><b>Final Contrato:</b> <?=$final ?></td>
          <td class="style1"><b>Pr&oacute;ximo Reajuste:</b> <?=$proximor ?></td>
        </tr>
      </table></td>
    </tr>
    <tr height="25px">
    	<td colspan="4">&nbsp;</td>
    </tr>
    <tr class="fundoTabelaTitulo" height="25px">
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" class="style1"><b>Descri&ccedil;&atilde;o de Lan&ccedil;amentos</b></td>
          <td width="21%" class="style1"><b>Valores</b></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">        
<?
if($_POST['buscar']=='1'){

   $mes_s = $_POST['cmes'];
   $ano_s = $_POST['cano'];
   $mes = $_POST['cmes'];
   $ano = $_POST['cano'];
   if($mes_s=='01'){
      $mes_s = '12';
      $ano_s = $ano_s - 1;
   }else{
      $mes_s = $mes_s - 1;
   }
   if(strlen($mes_s)=='1'){
      $mes_s = "0".$mes_s; 
   }
   
}else{
  
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
  
}

	     $k = 0;
         
         $baluguel = mysql_query("SELECT * FROM contas WHERE co_locacao='$l_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Receber' AND co_tipo='Locação' AND co_data LIKE '$ano-$mes-%'");   
		 while($linha4 = mysql_fetch_array($baluguel)){
            
            if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
			$k++;
            
            $valor_a = $linha4['co_valor'];
            $status_a = $linha4['co_status'];
            $valor_aluguel = number_format($valor_a, 2, ',', '.');
         
           echo "<tr class=\"$fundo\">";
           echo('
          				<td width="79%" class="style1">Aluguel do mês '.$mes.'</td>
          				<td width="21%" class="style1">R$ '.$valor_aluguel.'</td>
        			</tr>
				');
         }

		 $j = 0;
		 
         $buscas = mysql_query("SELECT s.valor_servico, s.data_servico, s.nome_servico FROM locacao l LEFT JOIN servicos s ON (s.locacao=l.l_cod) WHERE s.locacao='".$l_cod."' AND s.situacao!='Atrasado' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND s.data_servico like '$ano-$mes-%'");
			while($linha3 = mysql_fetch_array($buscas)){
			  	
			  	if (($j % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
				$j++;			
				
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
				
				echo "<tr class=\"$fundo\">";
				echo('
          				<td width="79%" class="style1">'.$nome_servico.'</td>
          				<td width="21%" class="style1">R$ '.$valor_servico.'</td>
        			</tr>
				');	
            }
            echo "<tr class=\"$fundo\">";
            echo('
          				<td width="79%" class="style1">Comissão da Imobiliaria</td>
          				<td width="21%" class="style1">R$ <span class="style7">-'.$debitol.'</span></td>
        			</tr>
				');
            
			$total_servico = $valor_a + $valor_ser - $debitol;			
			
			
?>
      </table></td>
    </tr>
    <tr class="fundoTabela" height="25px">
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" class="style1"><div align="right"><b>Total do Imóvel:</b>&nbsp;</div></td>
          <td width="21%" class="style1">R$ <? echo(number_format($total_servico, 2, ',', '.')); ?></td>
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
      $saldo_prop_ant += $linha5['co_valor'];
   } 
   
   //saldo que tem para o proprietario do mês atual
   $saldo_propr_atu = mysql_query("SELECT * FROM contas WHERE co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Pagar' AND co_tipo='Locação' AND co_status='ok' AND co_data LIKE '$ano-$mes-%'");   
   while($linha5 = mysql_fetch_array($saldo_propr_atu)){      
      $saldo_prop_atu += $linha5['co_valor'];
   }
   
   //saldo do aluguel do mês atual
   $saldo_alu_atu = mysql_query("SELECT * FROM contas WHERE co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Receber' AND co_tipo='Locação' AND co_status='ok' AND co_data LIKE '$ano-$mes-%'");   
   while($linha5 = mysql_fetch_array($saldo_alu_atu)){      
      $saldo_aluguel_atu = $linha5['co_valor'];
      $status_aluguel_atu = $linha5['co_status'];
   } 
    
   //saldo dos servicos do mês atual
   $serv_atu = mysql_query("SELECT * FROM contas WHERE co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Pagar' AND co_tipo='Despesas' AND co_status='ok' AND co_data LIKE '$ano-$mes-%'");   
   while($linha4 = mysql_fetch_array($serv_atu)){
      $saldo_serv_atu = $linha4['co_valor'];
   }
   
   $valor_repassado = $saldo_prop_atu; 
   if($status_aluguel_atu=='ok'){
   	$total_debito = $debitol;
   }
   //$valor_prop = $saldo_prop_atu + $saldo_serv_atu;
   $saldo_anterior = $saldo_aluguel_ant + $saldo_serv_ant + $saldo_prop_ant;
   $total_credito = $saldo_aluguel_atu + $saldo_anterior;
   $total_liquido = $total_credito - $total_debito;
   $saldo_atual = $total_liquido - $valor_repassado;
   if($status_aluguel_atu=='ok'){
   	$total_deb = $total_debito;
   }
   
?>  
	<tr height="25px">
    	<td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="fundoTabelaTitulo" height="25px">
          <td><p align="center" class="style1"><b>Saldo Anterior</b></p></td>
          <td><p align="center" class="style1"><b>Total Cr&eacute;dito</b></p></td>
          <td><p align="center" class="style1"><b>Total D&eacute;bito</b></p></td>
          <td><p align="center" class="style1"><b>Total L&iacute;quido</b></p></td>
          <td><p align="center" class="style1"><b>Valor Repassado</b></p></td>
          <td><p align="center" class="style1"><b>Saldo Atual</b></p></td>
        </tr>
        <tr class="fundoTabela" height="25px">
          <td class="style1"><div align="center">R$ <? echo(number_format($saldo_anterior, 2, ',', '.')); ?></div></td>
          <td class="style1"><div align="center">R$ <? echo(number_format($total_credito, 2, ',', '.')); ?></div></td>
          <td class="style1"><div align="center">R$ <? echo(number_format($total_deb, 2, ',', '.')); ?></div></td>
          <td class="style1"><div align="center">R$ <? echo(number_format($total_liquido, 2, ',', '.')); ?></div></td>
          <td class="style1"><div align="center">R$ <? echo(number_format($valor_repassado, 2, ',', '.')); ?></div></td>
          <td class="style1"><div align="center">R$ <? echo(number_format($saldo_atual, 2, ',', '.')); ?></div></td>
        </tr>
      </table></td>
    </tr>
    <tr height="25px">
    	<td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="fundoTabelaTitulo" height="25px">
          <td width="57%" class="style1"><b>Propriet&aacute;rio(s)</b></td>
          <td width="28%" class="style1"><b>Forma Pagamento</b></td>
          <td width="5%" class="style1"><b>%</b></td>
          <td width="10%" class="style1"><b>Valor</b></td>
        </tr>
		
<?
$l = 0;
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
			if (($l % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
				$l++;
			
         $tipo_pessoa = $notC['c_tipo_pessoa'];
		
			echo "<tr class=\"$fundo\">";
			echo('
          		<td class="style1">'.$notC['c_nome'].' - '.$notC['c_cpf'].'</td>
          		<td class="style1">'.$notC['c_conta'].'</td>
          		<td class="style1">'.$percentual2[$i3-1].'</td>
          		<td class="style1">R$ ');
				  
 			$saldo_propr_atu2 = mysql_query("SELECT * FROM contas WHERE co_cliente='".$cliente2[$i3-1]."' and co_locacao='$cod_loc' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_cat='Pagar' AND co_tipo='Locação' AND co_status='ok' AND co_data LIKE '$ano-$mes-%'");   
   			while($linha5 = mysql_fetch_array($saldo_propr_atu2)){      
      			$valor_prop = $linha5['co_valor'];
      			echo number_format($valor_prop, 2, ',', '.');
   			}	  
				 echo('</td>
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
    <tr height="25px">
    	<td colspan="4">&nbsp;</td>
    </tr>
    <tr class="fundoTabelaTitulo" height="25px">
      <td colspan="4" class="style1"><div align="center"><b>Valores para fins de Imposta de Renda de M&ecirc;s (Carn&ecirc; Le&atilde;o e Mensal&atilde;o)</b></div></td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="fundoTabela" height="25px">
          <td width="79%" class="style1"><div align="left"><b>Aluguel Recebido Pessoa F&iacute;sica:</b></div></td>
          <td width="21%" class="style1"><? if($tipo_pessoa=='F'){ echo('R$&nbsp;'.number_format($valor_a, 2, ',', '.')); } ?></td>
        </tr>
      </table></td>
    </tr>
    <tr class="fundoTabela" height="25px">
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" class="style1"><div align="left"><b>Aluguel Recebido Pessoa Jur&iacute;dica:</b></div></td>
          <td width="21%" class="style1"><? if($tipo_pessoa=='J'){ echo('R$&nbsp;'.number_format($valor_a, 2, ',', '.')); } ?></td>
        </tr>
      </table></td>
    </tr>
    <tr class="fundoTabela" height="25px">
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="79%" class="style1"><div align="left"><b>Total Aluguel Recebido:</b></div></td>
          <td width="21%" class="style1"><? echo('R$&nbsp;'.number_format($total_aluguel, 2, ',', '.')); ?></td>
        </tr>
      </table></td>
    </tr>
    <tr height="25px">
    	<td colspan="4">&nbsp;</td>
    </tr>
</form>
<?
}
?>
<div class=noprint>	
	<tr>
	  <td colspan="4"><div align="center"><span class="style1">
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()"> 
	    <input id=idPrint type="button" name="fechar"  class="campo3 noprint" value="Fechar Janela" Onclick="window.close();"><br /><br />	
	    <form name="form2" id="form2" class="noprint" method="post" action="demonstrativos.php"><input id=idPrint type="submit" value="Exportar para PDF" class="campo3 noprint" onClick="form2.action='demonstrativos.php?pdf=1&l_cod=<?php print($l_cod); ?>&buscar=<?php print($buscar); ?>&cmes=<?php print($cmes); ?>&cano=<?php print($cano); ?>';"></form> 
	  </span></div></td>
    </tr>
</div>
	</table>
<?
mysql_close($con);
?>

</body>
</html>
<? } ?>