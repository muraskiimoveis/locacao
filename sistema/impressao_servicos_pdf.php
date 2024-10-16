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
verificaArea("GERAL_LOCA");

$html5 .='<link href="style.css" rel="stylesheet" type="text/css" />';

 $cod = $_GET['cod'];
 $l_cod = $_GET['l_cod'];

	$busca = mysql_query("SELECT ref, titulo FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($busca)){
       $nimovel = $linha['ref']." - ".strip_tags($linha['titulo']);
	} 


$html5 .='<table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td class="style1"><div align="center"><b>Recibo de Servi&ccedil;os</b><br />
      </div></td>
    </tr>
    <tr>
      <td class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td class="style1"><b>Im&oacute;vel:&nbsp; </b> '.$nimovel.'</td>
    </tr> 
    <tr>
      <td><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td width="31%" class="TdSubTitulo"><b>Nome</b></td>
          <td width="17%" class="TdSubTitulo"><b>Data</b></td>
          <td width="13%" class="TdSubTitulo"><b>Valor</b></td>
          <td width="12%" class="TdSubTitulo"><b>Situa&ccedil;&atilde;o</b></td>
          </tr>';
        
		    $busca2 = mysql_query("SELECT id_servico, nome_servico, data_servico, valor_servico, situacao FROM servicos WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND cod_imovel='".$cod."' AND impressao='1' ORDER BY data_servico ASC");
	 			while($linha2 = mysql_fetch_array($busca2)){

      				$html5 .='
	        			<tr>
            				<td class="style1">'.$linha2['nome_servico'].'</td>
							<td class="style1">'.formataDataDoBd($linha2['data_servico']).'</td>
            				<td class="style1">'.number_format($linha2['valor_servico'], 2, ',', '.').'</td>
							<td class="style1">'.$linha2['situacao'].'</td>
            			</tr>
	   				';
    			}
       
$html5 .='</table></td>
    </tr>
	</table>';

$data_hora5 = date("d_m_Y_H_i_s");
$arquivo5 = "servicos_".$data_hora5.".pdf";

require_once("dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($html5);
$dompdf->set_paper('a4', 'landscape');
$dompdf->render();
$dompdf->stream($arquivo5);	
?>