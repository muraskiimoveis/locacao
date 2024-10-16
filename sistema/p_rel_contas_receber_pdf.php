<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_DEPOSITOS");

$data_inicial = $_GET['data_inicial'];
$data_final = $_GET['data_final'];
$nome_cliente = $_GET['nome_cliente'];
$cliente = $_GET['cliente'];
$buscar = $_GET['buscar'];

$html4 .='<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">';

$html4 .='<table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="2" class="style1"><div align="center"><b>Relat&oacute;rio Contas a Receber</b></div></td>
    </tr>';
    
        //REALIZA BUSCA APÓS PRESSIONAR O BOTAO "PESQUISAR"
    	if($buscar=='1'){ 
    	  
    	  $data1 = formataDataParaBd($data_inicial);
    	  $data2 = formataDataParaBd($data_final);
    	  
    	if(!empty($nome_cliente)){
	    	$nome_cliente = $nome_cliente; 
		}else{
			$nome_cliente = "Todos";
		} 
	
$html4 .='<tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><b>Per&iacute;odo:&nbsp; </b> '.$data_inicial.' &agrave; '.$data_final.' <b><br>
      </b><b>Propriet&aacute;rio ou Locat&aacute;rio:</b>'.$nome_cliente.'</td>
    </tr>   
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">';
         
  	      if(!empty($cliente)){
				$html4 .='<tr>
          		  <td width="40%" class="TdSubTitulo"><b>Imóvel</b></td>
          		  <td width="15%" class="TdSubTitulo"><b>Data</b></td>
          		  <td width="15%" class="TdSubTitulo"><b>Valor</b></td>
                  <td width="15%" class="TdSubTitulo"><b>Data</b></td>
                  <td width="15%" class="TdSubTitulo"><b>Status</b></td>
        		</tr>
				';
				
				$busca = mysql_query("SELECT DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_conta, m.ref, m.titulo, co.co_valor, co.co_status, co.co_tipo FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_cliente='".$cliente."' AND co.co_cat='Receber' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY co_data ASC");
				while($linha = mysql_fetch_array($busca)){
           				
					$html4 .='<tr>
          				<td class="style1">'.$linha['ref'].' - '.$linha['titulo'].'</td>
                        <td class="style1">'.$linha['data_conta'].'</td>
                        <td class="style1">'.$linha['co_tipo'].'</td>
                        <td class="style1">'.number_format($linha['co_valor'],2,',','.').'</td>
				   ';

				    if($linha['co_status']=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
                      $total_pendente += $linha['co_valor'];
					}elseif($linha['co_status']=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
                      $total_ok += $linha['co_valor'];
					}
          		   $html4 .='</td>
          					<td class="'.$cor.'">'.$statusc.'</td>
        				</tr>
					';
               $total_geral = $total_pendente + $total_ok;
            }

			$html4 .='
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan="2" class="style7"><b>Total Pendente: </b>'.number_format($total_pendente,2,',','.').'</td>
    				</tr>
    				<tr>
      					<td colspan="2" class="style6"><b>Total OK: </b>'.number_format($total_ok,2,',','.').'</td>
    				</tr>
    				<tr>
      					<td colspan="2" class="style1"><b>Total: </b>'.number_format($total_geral,2,',','.').'</td>
    				</tr>
			';
         }else{
            
            $html4 .='<tr>
          			<td width="40%" class="TdSubTitulo"><b>Imóvel</b></td>
                    <td width="20%" class="TdSubTitulo"><b>Proprietário</b></td>
          			<td width="10%" class="TdSubTitulo"><b>Data</b></td>
          			<td width="10%" class="TdSubTitulo"><b>Valor</b></td>
                    <td width="10%" class="TdSubTitulo"><b>Data</b></td>
                    <td width="10%" class="TdSubTitulo"><b>Status</b></td>
        		</tr>
				';
				
				$busca = mysql_query("SELECT DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_conta, m.ref, m.titulo, co.co_valor, co.co_status, co.co_tipo, c.c_nome FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_cat='Receber' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY co_data ASC");
				while($linha = mysql_fetch_array($busca)){
           				
					$html4 .='<tr>
          					<td class="style1">'.$linha['ref'].' - '.$linha['titulo'].'</td>
                        	<td class="style1">'.$linha['c_nome'].'</td>
                        	<td class="style1">'.$linha['data_conta'].'</td>
                        	<td class="style1">'.$linha['co_tipo'].'</td>
                        	<td class="style1">'.number_format($linha['co_valor'],2,',','.').'</td>
				   ';

				    if($linha['co_status']=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
                      $total_pendente += $linha['co_valor'];
					}elseif($linha['co_status']=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
                      $total_ok += $linha['co_valor'];
					}
          		   $html4 .='</td>
          					<td class="'.$cor.'">'.$statusc.'</td>
        				</tr>
					';
               $total_geral = $total_pendente + $total_ok;
            }

			$html4 .='
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan="2" class="style7"><b>Total Pendente: </b>'.number_format($total_pendente,2,',','.').'</td>
    				</tr>
    				<tr>
      					<td colspan="2" class="style6"><b>Total OK: </b>'.number_format($total_ok,2,',','.').'</td>
    				</tr>
    				<tr>
      					<td colspan="2" class="style1"><b>Total: </b>'.number_format($total_geral,2,',','.').'</td>
    				</tr>
			';
         }
$html4 .='</table>';
}

$data_hora4 = date("d_m_Y_H_i_s");
$arquivo4 = "contas_receber_".$data_hora4.".pdf";

require_once("dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($html4);
$dompdf->set_paper('a4', 'landscape');
$dompdf->render();
$dompdf->stream($arquivo4);
?>
