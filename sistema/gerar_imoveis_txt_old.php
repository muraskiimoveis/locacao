<?
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");


$data_hora = date("d_m_Y_H_i_s");
$arquivo = "imoveis_".$data_hora.".txt";

header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
header ( "Pragma: no-cache" );
header ( "Content-type: text/plain; name=$arquivo");
header ( "Content-Disposition: attachment; filename=$arquivo"); 
header ( "Content-Description: MID Gera TXT" );

#ECHO "<pre>";
					$buscaa = mysql_query("SELECT DISTINCT m.cod, t.t_cod, t.t_cod, t.t_nome, m.tipo, m.ref, f.f_nome, m.valor, m.metragem, ci.ci_nome, m.bairro, m.tipo_logradouro, m.end, m.numero, m.cep, m.n_quartos, m.caracteristica, m.observacoes2, m.finalidade, m.carnaval, m.anonovo, m.dist_mar, m.dist_tipo FROM muraski m INNER JOIN finalidade f ON (m.finalidade=f.f_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_cidades ci ON (m.local=ci.ci_cod) WHERE m.ref!='x' AND m.disponibilizar='1' AND m.cod_imobiliaria='3'") or die (mysql_error());
					while($linha = mysql_fetch_array($buscaa)){
					  
					  	$conteudo = '"REBRI"'; //campo 1
					  	if($linha['finalidade']=='5' || $linha['finalidade']=='12' || $linha['finalidade']=='16' || $linha['ref']=='x'){
		  					$conteudo .= ',"X"'; //campo 2
					  	}else{
		  					$conteudo .= ',"A"'; //campo 2
						}
						$conteudo .= ',""'; //campo 3
						$conteudo .= ',"'.$linha['cod'].'"'; //campo 4
						
						if($linha['t_cod']=='3'){
						  $tipo_imovel = "CASA RESIDENCIAL";
						}else{
						  $tipo_imovel = $linha['t_nome'];
						}
						
						$conteudo .= ',"'.$tipo_imovel.'"'; //campo 5
						$conteudo .= ',"'.$linha['ref'].'"'; //campo 6
						if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
							$conteudo .= ',"V"'; //campo 7
							$lista_finalidade = 'venda';
						}elseif($linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14'){
							$conteudo .= ',"L"'; //campo 7
							$lista_finalidade = 'locacao';
						}else{
		  					$conteudo .= ',"T"'; //campo 7
		  					$lista_finalidade = 'locacao';
						}		
						$conteudo .= ',"'.number_format($linha['valor'], 2, ',', '.').'"'; //campo 8
						$conteudo .= ',"'.str_replace(".", "," , $linha['metragem']).'"'; //campo 9
						$conteudo .= ',"'.$linha['ci_nome'].'"'; //campo 10
		
						$bairro1 = explode("--", $linha['bairro']);
						$bairro2 = str_replace("-","",$bairro1);
		
						foreach ($bairro2 as $k => $bairro) {
        					$bairro2[$k] = "'" . $bairro . "'";
    					}
		
						$xconteudo = "";
						$b_bairro = mysql_query("SELECT b_nome FROM rebri_bairros WHERE b_cod in (" . implode(',',$bairro2) . ") ORDER BY b_cod LIMIT 1");
						while($linha2=mysql_fetch_array($b_bairro)){
		   					$xconteudo .= $linha2['b_nome']; 
						}
						$conteudo .= ',"'.$xconteudo; //campo 11
		
						$conteudo .= '","'.$linha['tipo_logradouro']; //campo 12
						$conteudo .= '","'.str_replace(",", " ", $linha['end']); //campo 13
						$conteudo .= '","'.$linha['numero']; //campo 14
						$conteudo .= '","'; //campo 15
						$conteudo .= '","'.formataCEPParaBd($linha['cep']); //campo 16
						$conteudo .= '","'.$linha['n_quartos']; //campo 17
						$conteudo .= '","'; //campo 18
						$conteudo .= '","'; //campo 19
						$conteudo .= '","n"'; //campo 20
						if($linha['finalidade']=='5'){
							$conteudo .= ',"s"'; //campo 21
						}else{
		  					$conteudo .= ',"n"'; //canpo 21
						}
						
						$linha['observacoes2'] = str_replace("\n","<br>",$linha['observacoes2']);
						
						$conteudo .= ',"n'; //campo 22
						$conteudo .= '",'.'"'.$linha['observacoes2'].'"'; //campo 23
						$conteudo .= str_pad(',"*"', 1); //campo 24
						
						if($linha['carnaval'] != "0.00"){
						$carnaval = "Valor do Carnaval: R$ ".$linha['carnaval']." - ";
						}
						if($linha['anonovo'] != "0.00"){
						$ano_novo = "Valor Ano Novo: R$ ".$linha['anonovo']." - ";
						}
						if($linha['dist_mar'] != ""){
						$dist_mar = $linha['dist_mar'];
						$dist_tipo = $linha['dist_tipo'];
						$distancia_mar = "Distância do mar: ".$dist_mar." ".$dist_tipo;
						}
						$observacoes = $carnaval.$ano_novo.$distancia_mar;
						
						$conteudo .= ',"'.$observacoes.'"'; //campo 25
						
						for($i = 1; $i <= 12; $i++){
						  	$caminho = "imobiliarias/murask/".$lista_finalidade."/".$linha['ref']."_".$i.".jpg";
						  	$caminho2 = "http://www.redebrasileiradeimoveis.com.br/imobiliarias/murask/".$lista_finalidade."/".$linha['ref']."_".$i.".jpg";
						  	if(file_exists($caminho)){
								$conteudo .= ',"'.$caminho2.'"'; //campo 26	 
							}else{
							  	$conteudo .= ',""'; //campo 26
							}  
						}
						
	
						if(strlen($linha)>1){
							$conteudo .= "\r\n";
						}
		
						//$result = fputs($saida,$conteudo); 	
						echo $conteudo;
					}
?>