<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
if($_GET['pdf']<>'1'){
include("style.php");
}
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_DEPOSITOS");

if($_GET['pdf']=='1'){
  
$data_hora = date("d_m_Y_H_i_s");
$arquivo = "contas_receber_".$data_hora.".doc";
  
header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
header ( "Pragma: no-cache" );
header ( "Content-type: application/msword; name=$arquivo");
header ( "Content-Disposition: attachment; filename=$arquivo"); 

$data_inicial = $_GET['data_inicial'];
$data_final = $_GET['data_final'];
$nome_cliente = $_GET['nome_cliente'];
$cliente = $_GET['cliente'];
$buscar = $_GET['buscar'];

/*
$html4 .='<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">';
*/

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

echo $html4;

/*
$data_hora4 = date("d_m_Y_H_i_s");
$arquivo4 = "contas_receber_".$data_hora4.".pdf";

require_once("dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($html4);
$dompdf->set_paper('a4', 'landscape');
$dompdf->render();
$dompdf->stream($arquivo4);
*/

}

?>
<? if($_GET['pdf']<>'1'){ ?>
<html>
<head>
<?

//VERICA SE DATA FOI DIGITADA OU FOI MANTIDA CONFORME BUSCA
if(empty( $_POST['data_inicial']) && empty($_POST['data_final'])){

	$_datai = ("01/" . date( "m/Y" ));
	$_dataf = date("d/m/Y");

	$_POST['data_inicial'] = $_datai;
	$_POST['data_final'] = $_dataf;

}


?>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function setStrMonth(month){
	switch(month){
		case '01' :
			return 'Jan';
		case '02' :
			return 'Feb';
		case '03' :
			return 'Mar';
		case '04' :
			return 'Apr';
		case '05' :
			return 'May';
		case '06' :
			return 'Jun';
		case '07' :
			return 'Jul';
		case '08' :
			return 'Aug';
		case '09' :
			return 'Sep';
		case '10' :
			return 'Oct';
		case '11' :
			return 'Nov';
		case '12' :
			return 'Dec';
		default:
			break;
	}
	
	return false;
}

function VerificaCampo(){

//declara as variaveis
	var datai,dataf,_datai,_dataf,msdatai,msdataf;

//pega valores do campo
	datai = document.getElementById('data_inicial').value;
	dataf = document.getElementById('data_final').value;

//retira a barra
	_datai = datai.split("/");
	_dataf = dataf.split("/");

//transforma a data e milisegundos
	msdatai = Date.parse(setStrMonth(_datai[1])+' '+_datai[0]+', '+_datai[2]);
	msdataf = Date.parse(setStrMonth(_dataf[1])+' '+_dataf[0]+', '+_dataf[2]);

//verifica se data inicial é maior que a final
	if(msdatai > msdataf){
		alert("Data inicial maior que a Data final!");
		return false;
	}
	
var msgErro = '';

	   if(document.form1.data_inicial.value.length==0)
       {
            msgErro += "Por favor, preencha o campo Data Inicial.\n"; 
       }
       if(document.form1.data_final.value.length==0)
       {
            msgErro += "Por favor, preencha o campo Data Final.\n"; 
       }
       if(msgErro != '')
	   {
	        alert(msgErro);
	        return false;
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
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
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

<form id="form1" name="form1" method="post" action="">
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="2" class="style1"><div align="center"><b>Relat&oacute;rio Contas a Receber</b><br />
     Preencha o per&iacute;odo que voc&ecirc; deseja visualizar o relat&oacute;rio e clique em pesquisar.</font></div></td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><span class="style1"><b>Per&iacute;odo:</b>
          <input type="text" name="data_inicial" id="data_inicial" size="12" class="campo" maxlenght="10" value="<?= $_POST['data_inicial'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_inicial', '##/##/####', event);" onChange="ValidaData(this.value)">
          <b>&agrave;</b>
          <input type="text" name="data_final" id="data_final" size="12" class="campo" maxlenght="10" value="<?= $_POST['data_final'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_final', '##/##/####', event);" onChange="ValidaData(this.value)">
      </span></td>
    </tr>
    <tr>
      <td class="style1"><b>Propriet&aacute;rio ou Locat&aacute;rio:</b>
        <input type="text" name="cliente" size="5" class="campo2" value="<?php print($cliente); ?>" readonly>
        <input type="text" name="nome_cliente" size="60" class="campo" value='<?php print($nome_cliente); ?>' readonly>
        <input type="button" id="selecionar2" name="selecionar2" value="Selecionar" class="campo3" onClick="window.open('p_list_prop_loc.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"></td>
  </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="hidden" name="buscar" id="buscar" value="0">
        <input type="button" value="Pesquisar" name="pesquisar" id="pesquisar" class="campo3" onClick="VerificaCampo();">
      </div></td>
    </tr>
    <? 
        //REALIZA BUSCA APÓS PRESSIONAR O BOTAO "PESQUISAR"
    	if($_POST['buscar']=='1'){ 
    	  
    	  $data1 = formataDataParaBd($_POST['data_inicial']);
    	  $data2 = formataDataParaBd($_POST['data_final']);
	?>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><b>Per&iacute;odo:</b> <?= $_POST['data_inicial']; ?> &agrave; <?= $_POST['data_final']; ?> <b><br>
      </b><b>Propriet&aacute;rio ou Locat&aacute;rio:</b> <? if(!empty($_POST['nome_cliente'])){ echo $_POST['nome_cliente']; }else{  echo "Todos"; } ?></td>
    </tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
         <?
  	      if(!empty($_POST['cliente'])){
				echo('
				<tr>
          			<td width="40%" class="TdSubTitulo"><b>Imóvel</b></td>
          			<td width="15%" class="TdSubTitulo"><b>Data</b></td>
          			<td width="15%" class="TdSubTitulo"><b>Valor</b></td>
                  <td width="15%" class="TdSubTitulo"><b>Data</b></td>
                  <td width="15%" class="TdSubTitulo"><b>Status</b></td>
        		</tr>
				');
				
				$busca = mysql_query("SELECT DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_conta, m.ref, m.titulo, co.co_valor, co.co_status, co.co_tipo FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_cliente='".$cliente."' AND co.co_cat='Receber' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY co_data ASC");
				while($linha = mysql_fetch_array($busca)){
           				
					echo ("
						<tr>
          					<td class=\"style1\">".$linha['ref']." - ".$linha['titulo']."</td>
                        <td class=\"style1\">".$linha['data_conta']."</td>
                        <td class=\"style1\">".$linha['co_tipo']."</td>
                        <td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
				   ");

				    if($linha['co_status']=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
                 $total_pendente += $linha['co_valor'];
					}elseif($linha['co_status']=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
                 $total_ok += $linha['co_valor'];
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
					");
               $total_geral = $total_pendente + $total_ok;
            }

			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($total_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($total_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    				</tr>
			");
         }else{
            
            echo('
				<tr>
          			<td width="40%" class="TdSubTitulo"><b>Imóvel</b></td>
                  <td width="20%" class="TdSubTitulo"><b>Proprietário</b></td>
          			<td width="10%" class="TdSubTitulo"><b>Data</b></td>
          			<td width="10%" class="TdSubTitulo"><b>Valor</b></td>
                  <td width="10%" class="TdSubTitulo"><b>Data</b></td>
                  <td width="10%" class="TdSubTitulo"><b>Status</b></td>
        		</tr>
				');
				
				$busca = mysql_query("SELECT DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_conta, m.ref, m.titulo, co.co_valor, co.co_status, co.co_tipo, c.c_nome FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_cat='Receber' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY co_data ASC");
				while($linha = mysql_fetch_array($busca)){
           				
					echo ("
						<tr>
          					<td class=\"style1\">".$linha['ref']." - ".$linha['titulo']."</td>
                        <td class=\"style1\">".$linha['c_nome']."</td>
                        <td class=\"style1\">".$linha['data_conta']."</td>
                        <td class=\"style1\">".$linha['co_tipo']."</td>
                        <td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
				   ");

				    if($linha['co_status']=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
                 $total_pendente += $linha['co_valor'];
					}elseif($linha['co_status']=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
                 $total_ok += $linha['co_valor'];
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
					");
               $total_geral = $total_pendente + $total_ok;
            }

			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($total_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($total_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    				</tr>
			");
         
         }
			
        ?>
</form>        
        <tr>
           <td aling="center" colspan="6"><form name="form3" id="form3" method="post" action="">
             <div align="center">
               <input type="submit" value="Exportar para DOC" name="exportar" id="exportar" class="campo3" onClick="form3.action='p_rel_contas_receber.php?pdf=1&data_inicial=<?=$data_inicial ?>&data_final=<?=$data_final ?>&cliente=<?=$cliente ?>&nome_cliente=<?=$nome_cliente ?>&buscar=<?=$buscar ?>';">
             </div>
           </form></td>
        <tr>
  </table>

<?
}
mysql_close($con);
?>

</body>
</html>
<? } ?>