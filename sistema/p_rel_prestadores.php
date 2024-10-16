<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
ob_start();
if($_GET['pdf']<>'1'){
include("style.php");
}
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_PRESTADORES");

//Recebe todos os tipos de prestadores e tipos em arrays.
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

if($_GET['pdf']<>'1'){
?>
<html>
<head>
<?
}
#lembrete esse arquivo repete a pesquisa 6 vezes cuidado pra verificar todas

if($_GET['pdf']=='1'){

$html .= '<page><table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;">';

    $logo_imob = $_SESSION['logo_imob'];
    $caminho_logo = "../logos/";
	if (file_exists($caminho_logo.$logo_imob))
	{

	$html .= '<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100">';

	}

$html .='</td>
  </tr>
</table>
';


$data_inicial = $_GET['data_inicial'];
$data_final = $_GET['data_final'];
$tipo_prestador = $_GET['tipo_prestador'];
$prestador = $_GET['prestador'];
$status = $_GET['status'];

    	  $data1 = formataDataParaBd($data_inicial);
    	  $data2 = formataDataParaBd($data_final);
    	  $datai = formataDataDoBd($data1);
    	  $dataf = formataDataDoBd($data2);


  $html .= '<table width="800" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;"><b>Relat&oacute;rio de Prestadores</b></td>
    </tr>
    <tr>
      <td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Per&iacute;odo:</b> '.$datai.' &agrave; '.$dataf.'</td>
    </tr>
    <tr>
      <td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">
      <b>Tipo Prestador:</b>';
if($tipo_prestador <> 'Todos')
{
	$sqlTipoPrestador = "select tp_tipo from tipos_prestadores where tp_cod = '$tipo_prestador'";
	$buscaTipoPrestador = mysql_query($sqlTipoPrestador);
	$colunaTipoPrestador = mysql_fetch_array($buscaTipoPrestador);
	$html .= $colunaTipoPrestador['tp_tipo'];
}
else
{
	$html .= 'Todos';
}
   $html .= '<br>
      <b>Prestador:</b> ';

        //REALIZA BUSCA DO TIPO PRESTADOR SELECIONADO OU TODOS
        if($tipo_prestador <> 'Todos'){
            //REALIZA BUSCA DO PRESTADOR SELECIONADO OU TODOS
	    	if($prestador <> ''){
				$bprestador = mysql_query("SELECT c_nome FROM clientes WHERE c_cod='".$prestador."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
				while($linha = mysql_fetch_array($bprestador)){
		   			$html .= $linha['c_nome'];
				}
			}else{
			  $html .= 'Todos';
			}
		}else{
		  $html .= 'Todos';
		}


	$html .= '<br>
      <b>Status:</b> '; 

        //REALIZA BUSCA DO TIPO PRESTADOR SELECIONADO OU TODOS
        if($status<>''){
           $html .= $status;
		}else{
		  $html .= 'Todos';
		}

	$html .= '</td>
    </tr>';
		  //|1|REALIZA BUSCA POR TODOS OS TIPOS DE PRESTADORES E TODOS OS PRESTADORES E TODOS OS STATUS
		  if($tipo_prestador=='Todos' && $prestador=='' && $status==''){					
					
			$html .= '
				<tr>
       				<td colspan="2" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Im&oacute;vel</b></td>
       				<td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Tipo</b></td>
       				<td width="100" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Prestador</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Data</b></td>
	                <td width="100" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Servi&ccedil;o</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Valor</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Status</b></td>
				</tr>
			';
			
               		$sqlp = "SELECT m.ref, m.finalidade, m.tipo_logradouro, m.end, m.numero, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod)  WHERE co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscap = mysql_query($sqlp) or die ("Erro 120");
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
						
							$html .= '
								<tr>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											$html .= '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    	$html .= '</td><td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['ref'].' - '.$linha['tipo_logradouro'].' '.$linha['end'].', '.$linha['numero'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
									  
                     					if($linha['c_prestador2'] == ""){
			               					$html .= $linha['c_prestador'];
                     					}else{
                        					$t_prestador = explode("--", $linha['c_prestador2']);
                        					$t_prestador = str_replace("-","",$t_prestador);
                        					if (count($t_prestador) > 0) {
            		         					foreach ($t_prestador as $prestadores) {
 		       										$html .= $todos_prestadores[$prestadores][tipo].'<br>';
		                     					}
                        					}
                     					}
							  									  		  
									  
						  $html .= '</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['c_nome'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['data_servico'].'</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['co_desc'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha['co_valor'],2,',','.').'</td>
          					';
							  if($linha['co_status'] == "ok"){
							       $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;">OK</td>';
          					  }else{
								   $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;">'.$linha['co_status'].'</td>';
							  }
							$html .= '
        						</tr>
							';
						$total = $total + $linha['co_valor'];
						}
							

                  	$sqlpen = "SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
						$buscapen = mysql_query($sqlpen) or die ("Erro 171");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}

                  $sqlok = "SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='OK' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
						$buscaok = mysql_query($sqlok) or die ("Erro 177");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}

					//BUSCA DA SOLICITACAO DE SERVICOS
               		$sqlp2 = "SELECT m.ref, m.finalidade,  m.tipo_logradouro, m.end, m.numero, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscap2 = mysql_query($sqlp2) or die ("Erro 184");
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
							
							$html .= '
								<tr>
									<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											$html .= '<img src="images/sem_foto.gif" border="0" width="100" />';
										}
									  
						    	$html .= '</td><td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['ref'].' - '.$linha2['tipo_logradouro'].' '.$linha2['end'].', '.$linha2['numero'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
                     
					 				if($linha2['c_prestador2'] == ""){
			               				$html .= $linha2['c_prestador'];
                     				} else {
                        				$t_prestador = explode("--", $linha2['c_prestador2']);
                        				$t_prestador = str_replace("-","",$t_prestador);
                        				if (count($t_prestador) > 0) {
            		         				foreach ($t_prestador as $prestadores) {
               									$html .= $todos_prestadores[$prestadores][tipo].'<br>';
		                     				}
                        				}
                     				}
							$html .= '</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['c_nome'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['data_servico'].'</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['comentario'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha2['valor_servico'],2,',','.').'</td>
          					';
							  if($linha2['status'] == "ok"){
							       $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;">OK</td>';
          					  }else{
								   $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;">'.$linha2['status'].'</td>';
							  }
								
							$html .= '
        						</tr>
							';
						$total2 = $total2 + $linha2['valor_servico'];
						}		
						
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 242");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}

						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 247");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                		
						$html .= '
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;"><b>Total OK: </b>'.number_format($totais_ok,2,',','.').'</td>
    						</tr>
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;"><b>Total Pendente: </b>'.number_format($totais_pendente,2,',','.').'</td>
    						</tr>
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Total: </b>'.number_format($total_geral,2,',','.').'</td>
    						</tr>
						';
					
					
			//|2|REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E TODOS OS PRESTADORES E TODOS OS STATUS
			}elseif($tipo_prestador<>'Todos' && $prestador=='' && $status==''){
			  			  
			 $html .= '
				<tr>
       				<td colspan="2" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Im&oacute;vel</b></td>
       				<td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Tipo</b></td>
       				<td width="100" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Prestador</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Data</b></td>
	                <td width="100" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Servi&ccedil;o</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Valor</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Status</b></td>
				</tr>

			  ';
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
					$sqlp = "SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscap = mysql_query($sqlp) or die ("Erro 320");
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
							
							$html .= '
								<tr>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											$html .= '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    	$html .= '</td><td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['ref'].' - '.$linha['tipo_logradouro'].' '.$linha['end'].', '.$linha['numero'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
                     
					 				if($linha['c_prestador2'] == ""){
			               				$html .= $linha['c_prestador'];
                     				} else {
                        				$t_prestador = explode("--", $linha['c_prestador2']);
                        				$t_prestador = str_replace("-","",$t_prestador);
                        				if (count($t_prestador) > 0) {
            		         				foreach ($t_prestador as $prestadores) {
               									$html .= $todos_prestadores[$prestadores][tipo].'<br>';
		                     				}
                        				}
                     				}
							$html .= '</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['c_nome'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['data_servico'].'</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['co_desc'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha['co_valor'],2,',','.').'</td>
          					';
							  if($linha['co_status'] == "ok"){
							       $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;">OK</td>';
          					  }else{
								   $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;">'.$linha['co_status'].'</td>';
							  }
									  
							$html .= '
        						</tr>
							';
						$total = $total + $linha['co_valor'];
						}
		
						$sqlpen = "SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
						$buscapen = mysql_query($sqlpen) or die ("Erro 379");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente += $linhapen['co_valor'];
						}
                  		$sqlok = "SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
						$buscaok = mysql_query($sqlok) or die ("Erro 384");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok += $linhaok['co_valor'];
						}
					//BUSCA DA SOLICITACAO DE SERVICOS
               		$sqlp2 = "SELECT m.ref, m.tipo_logradouro, m.end, m.numero, m.finalidade, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscap2 = mysql_query($sqlp2) or die ("Erro 390");
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
							
							$html .= '
								<tr>
									<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											$html .= '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  

						    	$html .= '</td><td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['ref'].' - '.$linha2['tipo_logradouro'].' '.$linha2['end'].', '.$linha2['numero'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
                     
					 				if($linha2['c_prestador2'] == ""){
			               				$html .= $linha2['c_prestador'];
                     				} else {
                        				$t_prestador = explode("--", $linha2['c_prestador2']);
                        				$t_prestador = str_replace("-","",$t_prestador);
                        				if (count($t_prestador) > 0) {
            		         				foreach ($t_prestador as $prestadores) {
               									$html .= $todos_prestadores[$prestadores][tipo].'<br>';
		                     				}
                        				}
                     				}
							$html .= '</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['c_nome'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['data_servico'].'</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['comentario'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha2['valor_servico'],2,',','.').'</td>
          					';
							  if($linha2['status'] == "ok"){
							       $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;">OK</td>';
          					  }else{
								   $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;">'.$linha2['status'].'</td>';
							  }

							$html .= '
        						</tr>
							';
						$total2 = $total2 + $linha2['valor_servico'];
						}

						$sqlpen2 = "SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%')";
						$buscapen2 = mysql_query($sqlpen2) or die ("Erro 449");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}

                  		$sqlok2 = "SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'  AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%')";
						$buscaok2 = mysql_query($sqlok2) or die ("Erro 455");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}

						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                
						$html .= '
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;"><b>Total OK: </b>'.number_format($totais_ok,2,',','.').'</td>
    						</tr>
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;"><b>Total Pendente: </b>'.number_format($totais_pendente,2,',','.').'</td>
    						</tr>
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Total: </b>'.number_format($total_geral,2,',','.').'</td>
    						</tr>
						';
			
			//|3|REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E PRESTADOR SELECIONADO E TODOS OS STATUS
			}elseif($tipo_prestador <> 'Todos' && $prestador<>'' && $status==''){
			  
			  $html .= '<tr>
       				<td colspan="2" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Im&oacute;vel</b></td>
       				<td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Tipo</b></td>
       				<td width="100" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Prestador</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Data</b></td>
	                <td width="100" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Servi&ccedil;o</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Valor</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Status</b></td>
				</tr>
			  ';
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
					$sqlp = "SELECT m.ref, m.finalidade, m.tipo_logradouro, m.end, m.numero, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, c_prestador2, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$prestador."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscap = mysql_query($sqlp) or die ("Erro 457");
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
							
							$html .= '
								<tr>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											$html .= '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    	$html .= '</td><td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['ref'].' - '.$linha['tipo_logradouro'].' '.$linha['end'].', '.$linha['numero'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
                     
					 				if($linha['c_prestador2'] == ""){
			               				$html .= $linha['c_prestador'];
                     				} else {
                        				$t_prestador = explode("--", $linha['c_prestador2']);
                        				$t_prestador = str_replace("-","",$t_prestador);
                        				if (count($t_prestador) > 0) {
            		         				foreach ($t_prestador as $prestadores) {
               									$html .= $todos_prestadores[$prestadores][tipo].'<br>';
		                     				}
                        				}
                     				}
							$html .= '</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['c_nome'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['data_servico'].'</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['co_desc'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha['co_valor'],2,',','.').'</td>
          					';
							  if($linha['co_status'] == "ok"){
							       $html .= '<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;">OK</td>';
          					  }else{
								   $html .= '<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;">'.$linha['co_status'].'</td>';
							  }
					
							$html .= '
        						</tr>
							';
						$total = $total + $linha['co_valor'];
						}
		                
		                $buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$prestador."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 515");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}

						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$prestador."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 520");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}

					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.finalidade,  m.tipo_logradouro, m.end, m.numero, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$prestador."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 526");
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
							
							$html .= '
								<tr>
									<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											$html .= '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    	$html .= '</td><td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['ref'].' - '.$linha2['tipo_logradouro'].' '.$linha2['end'].', '.$linha2['numero'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
                     
					 				if($linha2['c_prestador2'] == ""){
			               				$html .= $linha2['c_prestador'];
                     				} else {
                        				$t_prestador = explode("--", $linha2['c_prestador2']);
                        				$t_prestador = str_replace("-","",$t_prestador);
                        				if (count($t_prestador) > 0) {
            		         				foreach ($t_prestador as $prestadores) {
               									$html .= $todos_prestadores[$prestadores][tipo].'<br>';
		                     				}
                        				}
                     				}
							$html .= '</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['c_nome'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['data_servico'].'</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['comentario'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha2['valor_servico'],2,',','.').'</td>
          					';
							  if($linha2['status'] == "ok"){
							       $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;">OK</td>';
          					  }else{
								   $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;">'.$linha2['status'].'</td>';
							  }
							  
							$html .= '
        						</tr>
							';
						$total2 = $total2 + $linha2['valor_servico'];
						}
		
						$sqlpen2 = "SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$prestador."'";
						$buscapen2 = mysql_query($sqlpen2) or die ("Erro 585");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}

						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$prestador."'") or die ("Erro 590");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}

						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                
						$html .= '
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;"><b>Total OK: </b>'.number_format($totais_ok,2,',','.').'</td>
    						</tr>
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;"><b>Total Pendente: </b>'.number_format($totais_pendente,2,',','.').'</td>
    						</tr>
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Total: </b>'.number_format($total_geral,2,',','.').'</td>
    						</tr>
						';
			  
		  //|4|REALIZA BUSCA POR TODOS OS TIPOS DE PRESTADORES E TODOS OS PRESTADORES E O STATUS SELECIONADO
		  }elseif($tipo_prestador == 'Todos' && $prestador=='' && $status<>''){
					
			$html .= '<tr>
       				<td colspan="2" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Im&oacute;vel</b></td>
       				<td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Tipo</b></td>
       				<td width="100" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Prestador</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Data</b></td>
	                <td width="100" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Servi&ccedil;o</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Valor</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Status</b></td>
				</tr>
			';
				
					$buscap = mysql_query("SELECT m.ref, m.finalidade, m.tipo_logradouro, m.end, m.numero, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_data BETWEEN '$data1' AND '$data2' AND co.co_status='".$status."' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 625");
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
							
							$html .= '
								<tr>
									<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';

										if (file_exists($pasta.$nome_foto1))
										{
											$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											$html .= '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    	$html .= '</td><td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['ref'].' - '.$linha['tipo_logradouro'].' '.$linha['end'].', '.$linha['numero'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
                     
					 				if($linha['c_prestador2'] == ""){
			               				$html .= $linha['c_prestador'];
                     				} else {
                        				$t_prestador = explode("--", $linha['c_prestador2']);
                        				$t_prestador = str_replace("-","",$t_prestador);
                        				if (count($t_prestador) > 0) {
            		         				foreach ($t_prestador as $prestadores) {
               									$html .= $todos_prestadores[$prestadores][tipo].'<br>';
		                     				}
                        				}
                     				}
							$html .= '</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['c_nome'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['data_servico'].'</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['co_desc'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha['co_valor'],2,',','.').'</td>
          					';
							  if($linha['co_status'] == "ok"){
							       $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;">OK</td>';
          					  }else{
								   $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;">'.$linha['co_status'].'</td>';
							  }

							$html .= '
        						</tr>
							';
						$total = $total + $linha['co_valor'];
						}
		
						$$buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 684");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}

						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='OK' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 689");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}
						
					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.finalidade,  m.tipo_logradouro, m.end, m.numero, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.data_servico BETWEEN '$data1' AND '$data2' AND s.status='".$status."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 695");
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
							
							$html .= '
								<tr>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											$html .= '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    	$html .= '</td><td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['ref'].' - '.$linha2['tipo_logradouro'].' '.$linha2['end'].', '.$linha2['numero'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
                     
					 				if($linha2['c_prestador2'] == ""){
			               				$html .= $linha2['c_prestador'];
                     				} else {
                        				$t_prestador = explode("--", $linha2['c_prestador2']);
                        				$t_prestador = str_replace("-","",$t_prestador);
                        				if (count($t_prestador) > 0) {
            		         				foreach ($t_prestador as $prestadores) {
               									$html .= $todos_prestadores[$prestadores][tipo].'<br>';
		                     				}
                        				}
                     				}
							$html .= '</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['c_nome'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['data_servico'].'</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['comentario'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha2['valor_servico'],2,',','.').'</td>
          					';
							  if($linha2['status'] == "ok"){
							       $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;">OK</td>';
          					  }else{
								   $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;">'.$linha2['status'].'</td>';
							  }

							$html .= '
        						</tr>
							';
						$total2 = $total2 + $linha2['valor_servico'];
						}
		
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 753");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}
						
						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 758");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                				

    					if($status=='ok'){
    					$html .= '
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;"><b>Total OK: </b>'.number_format($totais_ok,2,',','.').'</td>
    						</tr>
    					';
    					}else{
    					 $html .= '
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;"><b>Total Pendente: </b>'.number_format($totais_pendente,2,',','.').'</td>
    						</tr>
    					  ';
    					}
    					  $html .= '
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Total: </b>'.number_format($total_geral,2,',','.').'</td>
    						</tr>
						';
					
			//|5|REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E TODOS OS PRESTADORES E O STATUS SELECIONADO
			}elseif($tipo_prestador <> 'Todos' && $prestador=='' && $status<>''){
			  
			$html .= '<tr>
       				<td colspan="2" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Im&oacute;vel</b></td>
       				<td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Tipo</b></td>
       				<td width="100" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Prestador</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Data</b></td>
	                <td width="100" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Servi&ccedil;o</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Valor</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Status</b></td>
				</tr>
			  ';
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
					$buscap = mysql_query("SELECT m.ref, m.finalidade,  m.tipo_logradouro, m.end, m.numero, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_status='".$status."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 801");
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
							
							$html .= '
								<tr>
									<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											$html .= '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    	$html .= '</td><td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['ref'].' - '.$linha['tipo_logradouro'].' '.$linha['end'].', '.$linha['numero'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
                     
					 				if($linha['c_prestador2'] == ""){
			               				$html .= $linha['c_prestador'];
                     				} else {
                        				$t_prestador = explode("--", $linha['c_prestador2']);
                        				$t_prestador = str_replace("-","",$t_prestador);
                        				if (count($t_prestador) > 0) {
            		         				foreach ($t_prestador as $prestadores) {
               									$html .= $todos_prestadores[$prestadores][tipo].'<br>';
		                     				}
                        				}
                     				}
							$html .= '</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['c_nome'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['data_servico'].'</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['co_desc'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha['co_valor'],2,',','.').'</td>
          					';
							  if($linha['co_status'] == "ok"){
							       $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;">OK</td>';
          					  }else{
								   $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;">'.$linha['co_status'].'</td>';
							  }
			
							$html .= '
        						</tr>
							';
						$total = $total + $linha['co_valor'];
						}
		
						$buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 859");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}
						
						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 864");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}
						
					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.finalidade, m.tipo_logradouro, m.end, m.numero, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.status='".$status."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 870");
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
							
							$html .= '
								<tr>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											$html .= '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    	$html .= '</td><td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['ref'].' - '.$linha2['tipo_logradouro'].' '.$linha2['end'].', '.$linha2['numero'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
                     
					 				if($linha2['c_prestador2'] == ""){
			               				$html .= $linha2['c_prestador'];
                     				} else {
                        				$t_prestador = explode("--", $linha2['c_prestador2']);
                        				$t_prestador = str_replace("-","",$t_prestador);
                        				if (count($t_prestador) > 0) {
            		         				foreach ($t_prestador as $prestadores) {
               									$html .= $todos_prestadores[$prestadores][tipo].'<br>';
		                     				}
                        				}
                     				}
							$html .= '</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['c_nome'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['data_servico'].'</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['comentario'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha2['valor_servico'],2,',','.').'</td>
          					';
							  if($linha2['status'] == "ok"){
							       $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;">OK</td>';
          					  }else{
								   $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;">'.$linha2['status'].'</td>';
							  }

							$html .= '
        						</tr>
							';
						$total2 = $total2 + $linha2['valor_servico'];
						}
		
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%')") or die ("Erro 928");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}
						
						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%')") or die ("Erro 933");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;				


    					if($status=='ok'){
    					$html .= '
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;"><b>Total OK: </b>'.number_format($totais_ok,2,',','.').'</td>
    						</tr>
    					';
    					}else{
    					 $html .= '
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;"><b>Total Pendente: </b>'.number_format($totais_pendente,2,',','.').'</td>
    						</tr>
    					  ';
    					}
    					 $html .= '
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Total: </b>'.number_format($total_geral,2,',','.').'</td>
    						</tr>
						';
			
			//|6|REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E PRESTADOR SELECIONADO E O STATUS SELECIONADO
			}elseif($tipo_prestador <> 'Todos' && $prestador<>'' && $status<>''){
			  
			  $html .= '<tr>
       				<td colspan="2" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Im&oacute;vel</b></td>
       				<td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Tipo</b></td>
       				<td width="100" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Prestador</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Data</b></td>
	                <td width="100" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Servi&ccedil;o</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Valor</b></td>
	                <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Status</b></td>
				</tr>

			  ';
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
					$buscap = mysql_query("SELECT m.ref, m.finalidade, m.tipo_logradouro, m.end, m.numero, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$prestador."' AND co.co_status='".$status."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 977");
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
							
							$html .= '
								<tr>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											$html .= '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    	$html .= '</td><td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['ref'].' - '.$linha['tipo_logradouro'].' '.$linha['end'].', '.$linha['numero'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
                     
					 				if($linha['c_prestador2'] == ""){
			               				$html .= $linha['c_prestador'];
                     				} else {
                        				$t_prestador = explode("--", $linha['c_prestador2']);
                        				$t_prestador = str_replace("-","",$t_prestador);
                        				if (count($t_prestador) > 0) {
            		         				foreach ($t_prestador as $prestadores) {
               									$html .= $todos_prestadores[$prestadores][tipo].'<br>';
		                     				}
                        				}
                     				}
							$html .= '</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['c_nome'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['data_servico'].'</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['co_desc'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha['co_valor'],2,',','.').'</td>
          					';
							  if($linha['co_status'] == "ok"){
							       $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;">OK</td>';
          					  }else{
								   $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;">'.$linha['co_status'].'</td>';
							  }
							$html .= '
        						</tr>
							';
						$total = $total + $linha['co_valor'];
						}
		                
		                $buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$prestador."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 1034");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}
						
						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$prestador."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 1039");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}
						
					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.finalidade,  m.tipo_logradouro, m.end, m.numero, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$prestador."' AND s.status='".$status."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 1045");
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
							
							$html .= '
								<tr>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
									 	
										if (file_exists($pasta.$nome_foto1))
										{
											$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    				}
					    				else
										{
											$html .= '<img src="images/sem_foto.gif" border="0" width="100" />';
										} 								  
									  
						    	$html .= '</td><td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['ref'].' - '.$linha2['tipo_logradouro'].' '.$linha2['end'].', '.$linha2['numero'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
                     
					 				if($linha2['c_prestador2'] == ""){
			               				$html .= $linha2['c_prestador'];
                     				} else {
                        				$t_prestador = explode("--", $linha2['c_prestador2']);
                        				$t_prestador = str_replace("-","",$t_prestador);
                        				if (count($t_prestador) > 0) {
            		         				foreach ($t_prestador as $prestadores) {
               									$html .= $todos_prestadores[$prestadores][tipo].'<br>';
		                     				}
                        				}
                     				}
							$html .= '</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['c_nome'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['data_servico'].'</td>
          							<td width="100" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['comentario'].'</td>
          							<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha2['valor_servico'],2,',','.').'</td>
          					';
							  if($linha2['status'] == "ok"){
							       $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;">OK</td>';
          					  }else{
								   $html .= '<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;">'.$linha2['status'].'</td>';
							  }
							$html .= '
        						</tr>
							';
						$total2 = $total2 + $linha2['valor_servico'];
						}
		
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$prestador."'") or die ("Erro 1102");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}

						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$prestador."'") or die ("Erro 1107");

						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                		                
    					if($status=='ok'){
    					$html .= '
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000FF;"><b>Total OK: </b>'.number_format($totais_ok,2,',','.').'</td>
    						</tr>
    					';
    					}else{
    					  $html .= '
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #FF0000;"><b>Total Pendente: </b>'.number_format($totais_pendente,2,',','.').'</td>
    						</tr>
    					  ';
    					}
    					 $html .= '
    						<tr>
      							<td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Total: </b>'.number_format($total_geral,2,',','.').'</td>
    						</tr>
						';

			}	
	$html .= '<tr>
            <td colspan="8" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />www.redebrasileiradeimoveis.com.br</td>
          </tr>			
</table></page>';

echo $html;

	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	$pdf = new HTML2PDF('P','A4','fr');
	$pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$pdf->Output();		

}

if($_GET['pdf']<>'1'){

//VERIFICA SE DATA FOI DIGITADA OU FOI MANTIDA CONFORME BUSCA
/*
if(empty( $_POST['data_inicial']) && empty($_POST['data_final'])){

	$_datai = ("01/" . date( "m/Y" ));
	$_dataf = date("d/m/Y");

	$_POST['data_inicial'] = $_datai;
	$_POST['data_final'] = $_dataf;

}
*/

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
       if(document.form1.tipo_prestador.selectedIndex == 0)
	   {
	        msgErro += "Por favor, selecione o campo Tipo Prestador.\n";
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

function formConta(){

	if(confirm("Deseja realmente confirmar pagamento?")){

   	   document.form1.action='p_rel_prestadores.php';
	   document.form1.acao.value='1';
	   document.form1.buscar.value='1';
   	   document.form1.target= '';
   	   document.form1.submit();
	}
}

function formConta2(){

	if(confirm("Deseja realmente confirmar pagamento?")){

   	   document.form1.action='p_rel_prestadores.php';
	   document.form1.acao2.value='1';
	   document.form1.buscar.value='1';
   	   document.form1.target= '';
   	   document.form1.submit();
	}
}

<!-- Begin
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
var keyCode = (isNN) ? e.which : e.keyCode; 
var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
if(input.value.length >= len && !containsElement(filter,keyCode)) {
input.value = input.value.slice(0, len);
input.form[(getIndex(input)+1) % input.form.length].focus();
}
function containsElement(arr, ele) {
var found = false, index = 0;
while(!found && index < arr.length)
if(arr[index] == ele)
found = true;
else
index++;
return found;
}
function getIndex(input) {
var index = -1, i = 0, found = false;
while (i < input.form.length && index == -1)
if (input.form[i] == input)index = i;
else i++;
return index;
}
return true;
}
//  End -->
</script>
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilo_sistema.css" rel="stylesheet" type="text/css">
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
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/



if($_POST['acao']=='1')
{

   		$i = $_POST['cont'];
  		$c = 0;

		for($j = 0; $j <= $i; $j++)
		{	     
		
     		$datas = "data_status_".$j;
     		$data_atual = formataDataParaBd($_POST[$datas]);
     		$codigos = "co_cod_".$j;
     		$total = $_POST[$codigos];
     		$botoes = "ok_".$j;
     		$botao = $_POST[$botoes];

	    	if($botao)
	    	{
    			$c++;
    			$query4= "update contas set co_status='ok', co_data_status='$data_atual', co_usuario_status='$u_cod' where co_cod='$total' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
				$result4 = mysql_query($query4) or die("Erro 216");
    		} 	
		}

}

if($_POST['acao2']=='1')
{

   		$i2 = $_POST['cont2'];
  		$c2 = 0;

		for($j2 = 0; $j2 <= $i2; $j2++)
		{	     
		
     		$datas2 = "data_pagamento_".$j2;
     		$data_atual2 = formataDataParaBd($_POST[$datas2]);
     		$codigos2 = "id_servico_".$j2;
     		$total2 = $_POST[$codigos2];
     		$botoes2 = "ok_".$j2;
     		$botao2 = $_POST[$botoes2];

	    	if($botao2)
	    	{
    			$c2++;
    			$query42= "update solicitacao_servicos set status='ok', data_pagamento='$data_atual2' where id_servico='$total2' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$result42 = mysql_query($query42) or die("Erro 242");
    		}
		}

}

?>
  <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><div align="center"><b>Relat&oacute;rio de Prestadores </b><br />
        Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar</div></td>
    </tr>
<form method="post" action="" name="form1" id="form1">
<input type="hidden" name="acao" id="acao" value="0">
<input type="hidden" name="acao2" id="acao2" value="0">   
 <tr class="fundoTabela">
      <td wigth="20%"><span class="style1"><b>Per&iacute;odo:</b></span></td>
      <td wigth="80%">
          <input type="text" name="data_inicial" id="data_inicial" size="10" class="campo" maxlenght="10" value="<?= $_POST['data_inicial'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_inicial', '##/##/####', event);" onKeyUp="return autoTab(this, 10, event);" onChange="ValidaData(this.value)">
          <b>&agrave;</b>
          <input type="text" name="data_final" id="data_final" size="10" class="campo" maxlenght="10" value="<?= $_POST['data_final'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_final', '##/##/####', event);" onKeyUp="return autoTab(this, 10, event);" onChange="ValidaData(this.value)">
      </td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Tipo de Prestador:</b></td>
      <td width="80%" class="style1">
        <select name="tipo_prestador" id="tipo_prestador" class="campo" onChange="form1.submit();">
          <option value="">Selecione</option>
          <option value="Todos" <? if($tipo_prestador=='Todos'){ print "SELECTED"; } ?>>Todos</option>
<?
$sql = "SELECT tp_cod, tp_tipo FROM tipos_prestadores ORDER BY tp_tipo";
$rs = mysql_query($sql) or die ("Erro 273");
while ($not = mysql_fetch_assoc($rs)) {
?>
          <option value="<?=$not[tp_cod]?>" <? if($tipo_prestador==$not[tp_cod]){ print "SELECTED='SELECTED'"; } ?>><?=$not[tp_tipo]?></option>
<?
}
?>
        </select> </td>
    </tr>
    <tr class="fundoTabela">
    	<td width="20%" class="style1"><b>Prestador:</b></td>
    	<td width="80%" class="style1">
        <select name="prestador" id="prestador" class="campo">
          <option value="">Selecione</option>
<?
   if ($tipo_prestador <> "" && $tipo_prestador <> "Todos") {
      $pesq_tipo = " AND (c_tipo = 'prestador' OR c_tipo2 LIKE '%-$t_cod-%') ";
      if ($tipo_prestador == 1) {
		   $pesq_prestador = " AND (c_prestador = 'eletricista' OR c_prestador2 like '%-$p_cod-%') ";
      } elseif ($tipo_prestador == 2) {
		   $pesq_prestador = " AND (c_prestador = 'encanador' OR c_prestador2 like '%-$p_cod-%') ";
      } elseif ($tipo_prestador == 3) {
		   $pesq_prestador = " AND (c_prestador = 'diarista' OR c_prestador2 like '%-$p_cod-%') ";
      } elseif ($tipo_prestador == 4) {
		   $pesq_prestador = " AND (c_prestador = 'jardineiro' OR c_prestador2 like '%-$p_cod-%') ";
      } elseif ($tipo_prestador == 5) {
		   $pesq_prestador = " AND (c_prestador = 'piscineiro' OR c_prestador2 like '%-$p_cod-%') ";
      } else {
		   $pesq_prestador = " AND c_prestador2 like '%-$p_cod-%'";
      }
      $query1 = "SELECT c_cod, c_nome
         FROM clientes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $pesq_tipo $pesq_prestador ORDER BY c_nome";
      $prestadores = mysql_query($query1) or die ("Erro 305");
 			while($linha = mysql_fetch_array($prestadores)){
				if ($linha[c_cod]==$prestador) {
					print('<option value="'.$linha[c_cod].'" SELECTED>'.$linha[c_nome].'</option>');
				} else {
					print('<option value="'.$linha[c_cod].'">'.$linha[c_nome].'</option>');
				}
 			}
   }
?>
        </select>
      </td>
    </tr>
    <tr class="fundoTabela">
        <td width="20%" class="style1"><b>Status:</b></td>
    	<td width="80%" class="style1">
    		<select name="status" id="status" class="campo">
				<option value="">Selecione</option>
          		<option value="pendente" <? if($status=='pendente'){ print "SELECTED"; } ?>>Pendente</option>
          		<option value="ok" <? if($status=='ok'){ print "SELECTED"; } ?>>OK</option>
        	</select>
    	</td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="hidden" name="buscar" id="buscar" value="0">
        <input type="button" value="Pesquisar" name="pesquisar" id="pesquisar" class="campo3" onClick="VerificaCampo();"><br /><br />
      </td>
    </tr>
    <?
        //REALIZA BUSCA APÓS PRESSIONAR O BOTAO "PESQUISAR"
    	if($_POST['buscar']=='1'){

    	  $data1 = formataDataParaBd($_POST['data_inicial']);
    	  $data2 = formataDataParaBd($_POST['data_final']);
	?>
<?
//descomentar quanto tiver aprovado
?>	
    <!--tr>
      <td colspan="2"><table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="2" class="style1"><b>Legenda:</b></td>
    </tr>
    <tr>
      <td width="17%"><table width="220">
          <tr>
            <td width="10" valign="middle"><table width="15" border="0" cellpadding="0" cellspacing="1" bgcolor="#e3e3e3">
                <tr>
                  <td bgcolor="#e3e3e3">&nbsp;</td>
                </tr>
            </table></td>
            <td valign="middle" align="left" class="style1">Conta gerada para imobili&aacute;ria </td>
          </tr
      </table></td>
    </tr>
  </table></td>
    </tr-->
    <tr height="50">
      <td colspan="2" class="style1"><p align="center"><b>Per&iacute;odo:</b> <?= $_POST['data_inicial']; ?> &agrave; <?= $_POST['data_final']; ?> <b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">
      <b>Tipo Prestador:</b>
        <?
         if ($tipo_prestador == "Todos") {
		      print "Todos";
         } else {
		      $psql = "SELECT tp_tipo FROM tipos_prestadores WHERE tp_cod = '$tipo_prestador'";
            $prs = mysql_query($psql) or die ("Erro 355");
            $pnot = mysql_fetch_assoc($prs);
            print $pnot[tp_tipo];
         }
		?>
        <br>
      <b>Prestador:</b>
      <?
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
         if ($status == "") {
		      print "Todos";
         } else {
            print $status;
         }
	  ?>
	  </td>
    </tr>

    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <?

		  //|1|REALIZA BUSCA POR TODOS OS TIPOS DE PRESTADORES E TODOS OS PRESTADORES E TODOS OS STATUS
		  if($_POST['tipo_prestador']=='Todos' && $_POST['prestador']=='' && $_POST['status']==''){

			print('
				<tr class="fundoTabelaTitulo">
       				<td width="20%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="26%" class="style1"><b>Status</b></td>
				</tr>

			');

               		$sqlp = "SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc, co.co_despesa FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod)  WHERE co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscap = mysql_query($sqlp) or die ("Erro 1579");
						$k = 1;
						$i = 0;
						while($linha = mysql_fetch_array($buscap)){
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							
							if($linha['co_despesa'] == "Imobiliária"){ 
							  $fundo = '#e3e3e3';
							}
							
							print "
								<tr bgcolor=\"$fundo\">
          							<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          							<td class=\"style1\" nowrap='nowrap'>";

                     if ($linha[c_prestador2] == "") {
			               print $linha[c_prestador];
                     } else {

                        $t_prestador = explode("--", $linha[c_prestador2]);
                        $t_prestador = str_replace("-","",$t_prestador);
                        if (count($t_prestador) > 0) {
            		         foreach ($t_prestador as $prestadores) {
?>
               <img src="<?=$caminho_icones.$todos_prestadores[$prestadores][icone]?>" title="<?=$todos_prestadores[$prestadores][tipo]?>" border=0 />
<?
		                     }
                        }
                     }
                     print "</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					";
							  if($linha['co_status'] == "ok"){
							       print "<td class=\"style6\">OK</td>";
          					  }else{
								   print("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span>
								   <input type=\"hidden\" name=\"co_cod_".$i."\" id=\"co_cod_".$i."\" value=\"".$linha['co_cod']."\">
								   <input type=\"text\" name=\"data_status_".$i."\" id=\"data_status_".$i."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_status_".$i."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i."\" id=\"ok_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formConta()\"></td>");
							  }
							print("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}

                  $sqlpen = "SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
						$buscapen = mysql_query($sqlpen) or die ("Erro 1626");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}

                  $sqlok = "SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='OK' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
						$buscaok = mysql_query($sqlok) or die ("Erro 1631");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}

					//BUSCA DA SOLICITACAO DE SERVICOS
               $sqlp2 = "SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscap2 = mysql_query($sqlp2) or die ("Erro 1639");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if (($k2 % 2) == 1){ $fundo2="$cor6"; }else{ $fundo2="$cor14"; }
							$k2++;
							print "
								<tr bgcolor=\"$fundo2\">
          							<td class=\"style1\">".$linha2['ref']." - ".strip_tags($linha2['titulo'])."</td>
          							<td class=\"style1\" nowrap='nowrap'>";

                     if ($linha2[c_prestador2] == "") {
			               print $linha2[c_prestador];
                     } else {
                        $t_prestador = explode("--", $linha2[c_prestador2]);
                        $t_prestador = str_replace("-","",$t_prestador);
                        if (count($t_prestador) > 0) {
            		         foreach ($t_prestador as $prestadores) {
?>
               <img src="<?=$caminho_icones.$todos_prestadores[$prestadores][icone]?>" title="<?=$todos_prestadores[$prestadores][tipo]?>" border=0 />
<?
		                     }
                        }
                     }
                     print "</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					";
							  if($linha2['status'] == "ok"){
							       print "<td class=\"style6\">OK</td>";
          					  }else{
								   print("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span>
								   <input type=\"hidden\" name=\"id_servico_".$i2."\" id=\"id_servico_".$i2."\" value=\"".$linha2['id_servico']."\">
								   <input type=\"text\" name=\"data_pagamento_".$i2."\" id=\"data_pagamento_".$i2."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha2['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_pagamento_".$i2."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i2."\" id=\"ok_".$i2."\" value=\"OK\" class=\"campo3\" onClick=\"formConta2()\"></td>");
							  }
							print("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}

						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 1684");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}

						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 1689");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                
						print("
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


			//|2|REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E TODOS OS PRESTADORES E TODOS OS STATUS
			}elseif($_POST['tipo_prestador']<>'Todos' && $_POST['prestador']=='' && $_POST['status']==''){
			
			 print('
				<tr class="fundoTabelaTitulo">
       				<td width="20%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="26%" class="style1"><b>Status</b></td>
				</tr>

			  ');
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
               		$sqlp = "SELECT m.ref, m.titulo, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc, co.co_despesa FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscap = mysql_query($sqlp) or die ("Erro 1730");
						$i = 0;
						$k = 1;
						while($linha = mysql_fetch_array($buscap)){
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							
							if($linha['co_despesa'] == "Imobiliária"){ 
							  $fundo = '#e3e3e3';
							}
							
							print "
								<tr bgcolor=\"$fundo\">
          							<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          							<td class=\"style1\" nowrap='nowrap'>";

                     if ($linha[c_prestador2] == "") {
			               print $linha[c_prestador];
                     } else {

                        $t_prestador = explode("--", $linha[c_prestador2]);
                        $t_prestador = str_replace("-","",$t_prestador);
                        if (count($t_prestador) > 0) {
            		         foreach ($t_prestador as $prestadores) {
?>
               <img src="<?=$caminho_icones.$todos_prestadores[$prestadores][icone]?>" title="<?=$todos_prestadores[$prestadores][tipo]?>" border=0 />
<?
		                     }
                        }
                     }
                     print "</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					";
							  if($linha['co_status'] == "ok"){
							       print "<td class=\"style6\">OK</td>";
          					  }else{
								   print("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span>
								   <input type=\"hidden\" name=\"co_cod_".$i."\" id=\"co_cod_".$i."\" value=\"".$linha['co_cod']."\">
								   <input type=\"text\" name=\"data_status_".$i."\" id=\"data_status_".$i."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_status_".$i."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i."\" id=\"ok_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formConta()\"></td>");
							  }
							print("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}

                  	$sqlpen = "SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscapen = mysql_query($sqlpen) or die ("Erro 1777");
					while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente += $linhapen['co_valor'];
					}
                  	
					$sqlok = "SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscaok = mysql_query($sqlok) or die ("Erro 1782");
					while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok += $linhaok['co_valor'];
					}
					//BUSCA DA SOLICITACAO DE SERVICOS
               		$sqlp2 = "SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscap2 = mysql_query($sqlp2) or die ("Erro 1788");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if (($k2 % 2) == 1){ $fundo2="$cor6"; }else{ $fundo2="$cor14"; }
							$k2++;
							print "
								<tr bgcolor=\"$fundo2\">
          							<td class=\"style1\">".$linha2['ref']." - ".strip_tags($linha2['titulo'])."</td>
          							<td class=\"style1\" nowrap='nowrap'>";

                     if ($linha2[c_prestador2] == "") {
			               print $linha2[c_prestador];
                     } else {
                        $t_prestador = explode("--", $linha2[c_prestador2]);
                        $t_prestador = str_replace("-","",$t_prestador);
                        if (count($t_prestador) > 0) {
            		         foreach ($t_prestador as $prestadores) {
?>
               <img src="<?=$caminho_icones.$todos_prestadores[$prestadores][icone]?>" title="<?=$todos_prestadores[$prestadores][tipo]?>" border=0 />
<?
		                     }
                        }
                     }
                     print "</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					";
							  if($linha2['status'] == "ok"){
							       print "<td class=\"style6\">OK</td>";
          					  }else{
								   print("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span>
								   <input type=\"hidden\" name=\"id_servico_".$i2."\" id=\"id_servico_".$i2."\" value=\"".$linha2['id_servico']."\">
								   <input type=\"text\" name=\"data_pagamento_".$i2."\" id=\"data_pagamento_".$i2."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha2['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_pagamento_".$i2."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i2."\" id=\"ok_".$i2."\" value=\"OK\" class=\"campo3\" onClick=\"formConta2()\"></td>");
							  }
							print("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}

                  		$sqlpen2 = "SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%')";
						$buscapen2 = mysql_query($sqlpen2) or die ("Erro 1834");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}

                  		$sqlok2 = "SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'  AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%')";
						$buscaok2 = mysql_query($sqlok2) or die ("Erro 1840");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}

						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;

						print("
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
			}elseif($_POST['tipo_prestador']<>'Todos' && $_POST['prestador']<>'' && $_POST['status']==''){

			  print('
				<tr class="fundoTabelaTitulo">
       				<td width="20%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="26%" class="style1"><b>Status</b></td>
				</tr>

			  ');
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
               		$sqlp = "SELECT m.ref, m.titulo, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, c_prestador2, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc, co.co_despesa FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$_POST['prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$buscap = mysql_query($sqlp) or die ("Erro 1880");
						$i = 0;
						$k = 1;
						while($linha = mysql_fetch_array($buscap)){
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							
							if($linha['co_despesa'] == "Imobiliária"){ 
							  $fundo = '#e3e3e3';
							}
							
							echo "
								<tr bgcolor=\"$fundo\">
          							<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          							<td class=\"style1\" nowrap='nowrap'>";

                     if ($linha[c_prestador2] == "") {
			               print $linha[c_prestador];
                     } else {

                        $t_prestador = explode("--", $linha[c_prestador2]);
                        $t_prestador = str_replace("-","",$t_prestador);
                        if (count($t_prestador) > 0) {
            		         foreach ($t_prestador as $prestadores) {
?>
               <img src="<?=$caminho_icones.$todos_prestadores[$prestadores][icone]?>" title="<?=$todos_prestadores[$prestadores][tipo]?>" border=0 />
<?
		                     }
                        }
                     }
                     print "</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					";
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span>  
								   <input type=\"hidden\" name=\"co_cod_".$i."\" id=\"co_cod_".$i."\" value=\"".$linha['co_cod']."\">
								   <input type=\"text\" name=\"data_status_".$i."\" id=\"data_status_".$i."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_status_".$i."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i."\" id=\"ok_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formConta()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		                
		                $buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$_POST['prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 1926");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}

						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$_POST['prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 1931");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}

					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$_POST['prestador']."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 1937");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if (($k2 % 2) == 1){ $fundo2="$cor6"; }else{ $fundo2="$cor14"; }
							$k2++;
							echo "
								<tr bgcolor=\"$fundo2\">
          							<td class=\"style1\">".$linha2['ref']." - ".strip_tags($linha2['titulo'])."</td>
          							<td class=\"style1\" nowrap='nowrap'>";
          							
                     if ($linha2[c_prestador2] == "") {
			               print $linha2[c_prestador];
                     } else {
                        $t_prestador = explode("--", $linha2[c_prestador2]);
                        $t_prestador = str_replace("-","",$t_prestador);
                        if (count($t_prestador) > 0) {
            		         foreach ($t_prestador as $prestadores) {
?>
               <img src="<?=$caminho_icones.$todos_prestadores[$prestadores][icone]?>" title="<?=$todos_prestadores[$prestadores][tipo]?>" border=0 />
<?
		                     }
                        }
                     }
                     print "</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					";
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span> 
								   <input type=\"hidden\" name=\"id_servico_".$i2."\" id=\"id_servico_".$i2."\" value=\"".$linha2['id_servico']."\">
								   <input type=\"text\" name=\"data_pagamento_".$i2."\" id=\"data_pagamento_".$i2."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha2['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_pagamento_".$i2."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i2."\" id=\"ok_".$i2."\" value=\"OK\" class=\"campo3\" onClick=\"formConta2()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}

                  		$sqlpen2 = "SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$_POST['prestador']."'";
						$buscapen2 = mysql_query($sqlpen2) or die ("Erro 1983");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}

						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$_POST['prestador']."'") or die ("Erro 1988");
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
		  }elseif($_POST['tipo_prestador']=='Todos' && $_POST['prestador']=='' && $_POST['status']<>''){
					
			echo('
				<tr class="fundoTabelaTitulo">
       				<td width="20%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="26%" class="style1"><b>Status</b></td>
				</tr>

			');
				
					$buscap = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc, co.co_despesa FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_data BETWEEN '$data1' AND '$data2' AND co.co_status='".$status."' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2027");
						$i = 0;
						$k = 1;
						while($linha = mysql_fetch_array($buscap)){
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							
							if($linha['co_despesa'] == "Imobiliária"){ 
							  $fundo = '#e3e3e3';
							}

							echo "
								<tr bgcolor=\"$fundo\">
          							<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          							<td class=\"style1\" nowrap='nowrap'>";

                     if ($linha[c_prestador2] == "") {
			               print $linha[c_prestador];
                     } else {

                        $t_prestador = explode("--", $linha[c_prestador2]);
                        $t_prestador = str_replace("-","",$t_prestador);
                        if (count($t_prestador) > 0) {
            		         foreach ($t_prestador as $prestadores) {
?>
               <img src="<?=$caminho_icones.$todos_prestadores[$prestadores][icone]?>" title="<?=$todos_prestadores[$prestadores][tipo]?>" border=0 />
<?
		                     }
                        }
                     }
                     print "</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					";
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span> 
								   <input type=\"hidden\" name=\"co_cod_".$i."\" id=\"co_cod_".$i."\" value=\"".$linha['co_cod']."\">
								   <input type=\"text\" name=\"data_status_".$i."\" id=\"data_status_".$i."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_status_".$i."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i."\" id=\"ok_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formConta()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		
						$buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2074");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}

						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='OK' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2079");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}
						
					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.data_servico BETWEEN '$data1' AND '$data2' AND s.status='".$status."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2085");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if (($k2 % 2) == 1){ $fundo2="$cor6"; }else{ $fundo2="$cor14"; }
							$k2++;
							echo "
								<tr bgcolor=\"$fundo2\">
          							<td class=\"style1\">".$linha2['ref']." - ".strip_tags($linha2['titulo'])."</td>
          							<td class=\"style1\" nowrap='nowrap'>";
                     if ($linha2[c_prestador2] == "") {
			               print $linha2[c_prestador];
                     } else {
                        $t_prestador = explode("--", $linha2[c_prestador2]);
                        $t_prestador = str_replace("-","",$t_prestador);
                        if (count($t_prestador) > 0) {
            		         foreach ($t_prestador as $prestadores) {
?>
               <img src="<?=$caminho_icones.$todos_prestadores[$prestadores][icone]?>" title="<?=$todos_prestadores[$prestadores][tipo]?>" border=0 />
<?
		                     }
                        }
                     }
                     print "</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					";
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span> 
								   <input type=\"hidden\" name=\"id_servico_".$i2."\" id=\"id_servico_".$i2."\" value=\"".$linha2['id_servico']."\">
								   <input type=\"text\" name=\"data_pagamento_".$i2."\" id=\"data_pagamento_".$i2."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha2['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_pagamento_".$i2."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i2."\" id=\"ok_".$i2."\" value=\"OK\" class=\"campo3\" onClick=\"formConta2()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}
		
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2129");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}
						
						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2134");
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
			}elseif($_POST['tipo_prestador']<>'Todos' && $_POST['prestador']=='' && $_POST['status']<>''){
			  
			 echo('
				<tr class="fundoTabelaTitulo">
       				<td width="20%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="26%" class="style1"><b>Status</b></td>
				</tr>
			  ');
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
					$buscap = mysql_query("SELECT m.ref, m.titulo, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc, co.co_despesa FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_status='".$status."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2182");
						$i = 0;
						$k = 1;
						while($linha = mysql_fetch_array($buscap)){
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							
							if($linha['co_despesa'] == "Imobiliária"){ 
							  $fundo = '#e3e3e3';
							}
							
							echo "
								<tr bgcolor=\"$fundo\">
          							<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          							<td class=\"style1\" nowrap='nowrap'>";

                     if ($linha[c_prestador2] == "") {
			               print $linha[c_prestador];
                     } else {

                        $t_prestador = explode("--", $linha[c_prestador2]);
                        $t_prestador = str_replace("-","",$t_prestador);
                        if (count($t_prestador) > 0) {
            		         foreach ($t_prestador as $prestadores) {
?>
               <img src="<?=$caminho_icones.$todos_prestadores[$prestadores][icone]?>" title="<?=$todos_prestadores[$prestadores][tipo]?>" border=0 />
<?
		                     }
                        }
                     }
                     print "</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					";
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span>  
								   <input type=\"hidden\" name=\"co_cod_".$i."\" id=\"co_cod_".$i."\" value=\"".$linha['co_cod']."\">
								   <input type=\"text\" name=\"data_status_".$i."\" id=\"data_status_".$i."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_status_".$i."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i."\" id=\"ok_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formConta()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		
						$buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2228");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}
						
						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2233");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}
						
					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.status='".$status."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 926");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if (($k2 % 2) == 1){ $fundo2="$cor6"; }else{ $fundo2="$cor14"; }
							$k2++;
							echo "
								<tr bgcolor=\"$fundo2\">
          							<td class=\"style1\">".$linha2['ref']." - ".strip_tags($linha2['titulo'])."</td>
          							<td class=\"style1\" nowrap='nowrap'>";

                     if ($linha2[c_prestador2] == "") {
			               print $linha2[c_prestador];
                     } else {
                        $t_prestador = explode("--", $linha2[c_prestador2]);
                        $t_prestador = str_replace("-","",$t_prestador);
                        if (count($t_prestador) > 0) {
            		         foreach ($t_prestador as $prestadores) {
?>
               <img src="<?=$caminho_icones.$todos_prestadores[$prestadores][icone]?>" title="<?=$todos_prestadores[$prestadores][tipo]?>" border=0 />
<?
		                     }
                        }
                     }
                     print "</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					";
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span> 
								   <input type=\"hidden\" name=\"id_servico_".$i2."\" id=\"id_servico_".$i2."\" value=\"".$linha2['id_servico']."\">
								   <input type=\"text\" name=\"data_pagamento_".$i2."\" id=\"data_pagamento_".$i2."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha2['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_pagamento_".$i2."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i2."\" id=\"ok_".$i2."\" value=\"OK\" class=\"campo3\" onClick=\"formConta2()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}
		
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%')") or die ("Erro 956");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}
						
						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%')") or die ("Erro 2289");
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
			}elseif($_POST['tipo_prestador']<>'Todos' && $_POST['prestador']<>'' && $_POST['status']<>''){
			  
			  echo('
				<tr class="fundoTabelaTitulo">
       				<td width="20%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="26%" class="style1"><b>Status</b></td>
				</tr>

			  ');
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
					$buscap = mysql_query("SELECT m.ref, m.titulo, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, c.c_prestador2, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc, co.co_despesa FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$_POST['prestador']."' AND co.co_status='".$status."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2337");
						$i = 0;
						$k = 0;
						while($linha = mysql_fetch_array($buscap)){
							if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
							$k++;
							
							if($linha['co_despesa'] == "Imobiliária"){ 
							  $fundo = '#e3e3e3';
							}
							
							echo "
								<tr class=\"$fundo\">
          							<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          							<td class=\"style1\" nowrap='nowrap'>";

                     if ($linha[c_prestador2] == "") {
			               print $linha[c_prestador];
                     } else {

                        $t_prestador = explode("--", $linha[c_prestador2]);
                        $t_prestador = str_replace("-","",$t_prestador);
                        if (count($t_prestador) > 0) {
            		         foreach ($t_prestador as $prestadores) {
?>
               <img src="<?=$caminho_icones.$todos_prestadores[$prestadores][icone]?>" title="<?=$todos_prestadores[$prestadores][tipo]?>" border=0 />
<?
		                     }
                        }
                     }
                     print "</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					";
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span> 
								   <input type=\"hidden\" name=\"co_cod_".$i."\" id=\"co_cod_".$i."\" value=\"".$linha['co_cod']."\">
								   <input type=\"text\" name=\"data_status_".$i."\" id=\"data_status_".$i."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_status_".$i."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i."\" id=\"ok_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formConta()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		                
		                $buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$_POST['prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2383");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}
						
						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND co.co_cliente='".$_POST['prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2388");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}
						
					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, c.c_prestador2, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$_POST['prestador']."' AND s.status='".$status."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 2394");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if (($k2 % 2) == 1){ $fundo2="$cor6"; }else{ $fundo2="$cor14"; }
							$k2++;
							echo "
								<tr bgcolor=\"$fundo2\">
          							<td class=\"style1\">".$linha2['ref']." - ".strip_tags($linha2['titulo'])."</td>
          							<td class=\"style1\" nowrap='nowrap'>";
#                     .$linha['c_prestador'].
                     if ($linha2[c_prestador2] == "") {
			               print $linha2[c_prestador];
                     } else {
                        $t_prestador = explode("--", $linha2[c_prestador2]);
                        $t_prestador = str_replace("-","",$t_prestador);
                        if (count($t_prestador) > 0) {
            		         foreach ($t_prestador as $prestadores) {
?>
               <img src="<?=$caminho_icones.$todos_prestadores[$prestadores][icone]?>" title="<?=$todos_prestadores[$prestadores][tipo]?>" border=0 />
<?
		                     }
                        }
                     }
                     print "</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					";
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span>
								   <input type=\"hidden\" name=\"id_servico_".$i2."\" id=\"id_servico_".$i2."\" value=\"".$linha2['id_servico']."\">
								   <input type=\"text\" name=\"data_pagamento_".$i2."\" id=\"data_pagamento_".$i2."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha2['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_pagamento_".$i2."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i2."\" id=\"ok_".$i2."\" value=\"OK\" class=\"campo3\" onClick=\"formConta2()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}

						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$_POST['prestador']."'") or die ("Erro 2439");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}

						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (c.c_prestador='".$todos_prestadores[$tipo_prestador]['tipo']."' or c.c_prestador2 LIKE '%-".$tipo_prestador."-%') AND s.cod_prestador='".$_POST['prestador']."'") or die ("Erro 2444");
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
      <input name="cont" id="cont" type="hidden" class="campo" value="<?=$i ?>">
      <input name="cont2" id="cont2" type="hidden" class="campo" value="<?=$i2 ?>">
         <tr>
            <td align="center" colspan="2">
    <form name="form2" id="form2" method="post" action="prestadores_impressao.php"><input type="button" value="Visualizar" name="visualizar" id="visualizar" class="campo3" onClick="MM_openBrWindow('prestadores_impressao.php?data_inicial=<?=$data_inicial ?>&data_final=<?=$data_final ?>&tipo_prestador=<?=$tipo_prestador ?>&prestador=<?=$prestador ?>&status=<?=$status ?>','','scrollbars=yes,resizable=no,width=800,height=600')"></form>
               <form name="form3" id="form3" method="post" action=""><input type="submit" value="Exportar para PDF" name="exportar" id="exportar" class="campo3" onClick="form3.action='p_rel_prestadores.php?pdf=1&data_inicial=<?=$data_inicial ?>&data_final=<?=$data_final ?>&tipo_prestador=<?=$tipo_prestador ?>&prestador=<?=$prestador ?>&status=<?=$status ?>';"></form>
            </td>
         </tr>
  </table>
<?
}
mysql_close($con);

?>
</form>
<?  if(session_is_registered("valid_user")){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("voltar.php"); ?>
    </td>
  </tr>	
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("endereco.php"); ?>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td align="center" class="style1">
    <? include("bruc.php"); ?>
    </td>
  </tr>
</table>
<? } ?>
</body>
</html>
<? } ?>