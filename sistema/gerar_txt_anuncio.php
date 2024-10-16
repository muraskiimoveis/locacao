<?
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");

$id_anuncio = $_GET['id_anuncio'];
$exportar = $_GET['exportar'];
$tipo_exportacao = $_POST['tipo_exportacao'];

if($tipo_exportacao=='1'){
	if($exportar=='I'){	  
		$data_hora = date("d_m_Y_H_i_s");
		$arquivo = "anuncios_imoveis_curitiba_".$data_hora.".txt";
	}elseif($exportar=='M'){	  
	 	$data_hora = date("d_m_Y_H_i_s");
		$arquivo = "anuncios_minha_primeira_casa_".$data_hora.".txt"; 
	}
}else{
  	if($exportar=='I'){	 
  		$data_hora = date("d_m_Y_H_i_s");
		$arquivo = "ultimos_anuncios_imoveis_curitiba_".$data_hora.".txt";
	}elseif($exportar=='M'){	  
	  	$data_hora = date("d_m_Y_H_i_s");
		$arquivo = "ultimos_anuncios_minha_primeira_casa_".$data_hora.".txt";
	}
}

header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
header ( "Pragma: no-cache" );
header ( "Content-type: text/plain; name=$arquivo");
header ( "Content-Disposition: attachment; filename=$arquivo"); 
header ( "Content-Description: MID Gera TXT" );


		
		if($exportar=='I'){	  
			  if($tipo_exportacao=='1'){
			  
			  		$busca_codigos = mysql_query("SELECT a.a_imovel, a.a_acao FROM atualizacoes a WHERE a.a_anuncio='".$id_anuncio."' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND a.a_imovel!='' AND (a.a_acao!='Exportou TXT IMOVEIS CURITIBA' AND a.a_acao!='Inserir Imagem' AND a.a_acao!='Apagar Imagem')");
					while($linha2 = mysql_fetch_array($busca_codigos)){  
								  
						$buscaa = mysql_query("SELECT m.cod, t.t_cod, t.t_cod, t.t_nome, m.tipo, m.ref, f.f_nome, m.valor, m.metragem, ci.ci_nome, m.bairro, m.tipo_logradouro, m.end, m.numero, m.cep, m.n_quartos, m.caracteristica, m.observacoes2, m.finalidade, m.apto FROM muraski m INNER JOIN finalidade f ON (m.finalidade=f.f_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_cidades ci ON (m.local=ci.ci_cod) WHERE m.cod='".$linha2['a_imovel']."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linha = mysql_fetch_array($buscaa)){
					  
					  		$conteudo = '"REBRI",'; //campo 1
					  		if($linha['finalidade']=='5' || $linha['finalidade']=='12' || $linha['finalidade']=='16' || $linha['ref']=='x' || $linha2['a_acao']=='Excluiu Anúncio'){
		  						$conteudo .= '"X",'; //campo 2
					  		}elseif($linha2['a_acao']=='Adicionou Anúncio' || $linha2['a_acao']=='Atualizou Anúncio'){
		  						$conteudo .= '"A",'; //campo 2
							}
							$conteudo .= '""'.","; //campo 3
							$conteudo .= '"'.$linha['cod'].'",'; //campo 4
						
							if($linha['t_cod']=='3'){
						  		$tipo_imovel = "CASA RESIDENCIAL";
							}else{
						  		$tipo_imovel = $linha['t_nome'];
							}
						
							$conteudo .= '"'.$tipo_imovel.'",'; //campo 5
							$conteudo .= '"'.$linha['ref'].'",'; //campo 6
							if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
								$conteudo .= '"V",'; //campo 7
							}else{
		  						$conteudo .= '"L",'; //campo 7
							}	
							$conteudo .= '"'.number_format($linha['valor'], 2, ',', '.').'",'; //campo 8
							$conteudo .= '"'.str_replace(".", "," , $linha['metragem']).'",'; //campo 9
							$conteudo .= '"'.$linha['ci_nome'].'",'; //campo 10
		
							$bairro1 = explode("--", $linha['bairro']);
							$bairro2 = str_replace("-","",$bairro1);
		
							foreach ($bairro2 as $k => $bairro) {
        						$bairro2[$k] = "'" . $bairro . "'";
    						}
		
							$b_bairro = mysql_query("SELECT b_nome FROM rebri_bairros WHERE b_cod in (" . implode(',',$bairro2) . ") ORDER BY b_cod LIMIT 1");
							while($linha2 = mysql_fetch_array($b_bairro)){
		   						$conteudo .= '"'.$linha2['b_nome'].'",'; //campo 11
							}
		
							$conteudo .= '"'.$linha['tipo_logradouro'].'",'; //campo 12
							$conteudo .= '"'.str_replace(",", " ", $linha['end']).'",'; //campo 13
							$conteudo .= '"'.$linha['numero'].'",'; //campo 14
							$conteudo .= '"'.$linha['apto'].'",'; //campo 15
							$conteudo .= '"'.formataCEPParaBd($linha['cep']).'"'.","; //campo 16
							$conteudo .= '"'.$linha['n_quartos'].'",'; //campo 17
							
							$b_caracteristica = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE (c_nome LIKE '01 Garagem' OR c_nome LIKE 'Garagem')");
							if(mysql_num_rows($b_caracteristica) > 0){
								while($linha3 = mysql_fetch_array($b_caracteristica)){
		   							$cod_garagem = $linha3['c_cod'];
								}
							}else{
							  	$b_caracteristica = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE c_nome LIKE '2 /+ Garagem'");
								while($linha4 = mysql_fetch_array($b_caracteristica)){
		   							$cod_garagem2 = $linha4['c_cod'];
								}
							}
    						
    						if($cod_garagem <> '' && $cod_garagem2==''){
							  	if(strstr($linha['caracteristica'], '-'.$cod_garagem.'-')){
								    $conteudo .= '"1",'; //campo 18
								}else{
								 	$conteudo .= '"0",'; //campo 18 
								}
							}elseif($cod_garagem == '' && $cod_garagem2<>''){
								if(strstr($linha['caracteristica'], '-'.$cod_garagem2.'-')){
								    $conteudo .= '"2",'; //campo 18
								}else{
								 	$conteudo .= '"0",'; //campo 18 
								}
							}elseif($cod_garagem == '' && $cod_garagem2==''){
							 	$conteudo .= '"0",'; //campo 18 
							}
							
							$conteudo .= '""'.","; //campo 19
							
							$b_cond_fechado = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE (c_nome LIKE 'Cond. Fechado' OR c_nome LIKE 'Condomínio Fechado')");
							while($linha4 = mysql_fetch_array($b_cond_fechado)){
		   						$cod_cond_fechado = $linha4['c_cod'];
							}
							
							if(strstr($linha['caracteristica'], '-'.$cod_cond_fechado.'-')){
							    $conteudo .= '"s",'; //campo 20
							}else{
							 	$conteudo .= '"n",'; //campo 20 
							}
																				
							if($linha['finalidade']=='5'){
								$conteudo .= '"s",'; //campo 21
							}else{
		  						$conteudo .= '"n",'; //canpo 21
							}
							
							$b_mobiliado = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE c_nome LIKE 'Mobiliado'");
							while($linha5 = mysql_fetch_array($b_mobiliado)){
		   						$cod_mobiliado = $linha5['c_cod'];
							}
							
							if(strstr($linha['caracteristica'], '-'.$cod_mobiliado.'-')){
							    $conteudo .= '"s",'; //campo 22
							}else{
							 	$conteudo .= '"n",'; //campo 22 
							}
							
							$linha['observacoes2'] = str_replace("\n","",$linha['observacoes2']);
							$linha['observacoes2'] = str_replace("\\","",$linha['observacoes2']);
							$linha['observacoes2'] = strip_tags($linha['observacoes2']);

							$conteudo .= '"'.$linha['observacoes2'].'",'; //campo 23
							$conteudo .= str_pad('"*"', 1); //campo 24
	
							if(strlen($linha)>1){
								$conteudo .= "\r\n";
							}
		
							echo $conteudo;
						}
					}
			}else{			  	
			  	
				$busca_atualizacao = mysql_query("SELECT a.a_data, a.a_hora FROM atualizacoes a WHERE a.a_anuncio='".$id_anuncio."' AND a.a_acao='Exportou TXT IMOVEIS CURITIBA' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.a_data DESC, a.a_hora DESC LIMIT 1");
				while($linha1 = mysql_fetch_array($busca_atualizacao)){  			  	
			  		$ultima_data = $linha1['a_data'];
			  		$ultima_hora = $linha1['a_hora'];
				}			  	
			  	
					$busca_codigos = mysql_query("SELECT a.a_imovel, a.a_acao FROM atualizacoes a LEFT JOIN imoveis_anuncio ia ON (ia.cod_imovel=a.a_imovel) WHERE ia.id_anuncio='".$id_anuncio."' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND ((a.a_data = '$ultima_data' AND a.a_hora >= '$ultima_hora') OR (a.a_data > '$ultima_data')) AND (a.a_acao!='Exportou TXT IMOVEIS CURITIBA' AND a.a_acao!='Inserir Imagem' AND a.a_acao!='Apagar Imagem')");		 	
					while($linha2 = mysql_fetch_array($busca_codigos)){ 
					  
					  	$buscaa = mysql_query("SELECT m.cod, t.t_cod, t.t_cod, t.t_nome, m.tipo, m.ref, f.f_nome, m.valor, m.metragem, ci.ci_nome, m.bairro, m.tipo_logradouro, m.end, m.numero, m.cep, m.n_quartos, m.caracteristica, m.observacoes2, m.finalidade, m.apto FROM muraski m INNER JOIN finalidade f ON (m.finalidade=f.f_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_cidades ci ON (m.local=ci.ci_cod) WHERE m.cod='".$linha2['a_imovel']."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linha = mysql_fetch_array($buscaa)){			  	
					
							$conteudo = '"REBRI",'; //campo 1
					  		if($linha['finalidade']=='5' || $linha['finalidade']=='12' || $linha['finalidade']=='16' || $linha['ref']=='x' || $linha2['a_acao']=='Excluiu Anúncio' || $linha2['a_acao']=='Apagar Imóvel Definitivamente' || $linha2['a_acao']=='Apagar Imóvel'){
		  						$conteudo .= '"X",'; //campo 2
					  		}elseif($linha2['a_acao']=='Adicionou Anúncio' || $linha2['a_acao']=='Atualizou Anúncio' || $linha2['a_acao']=='Atualizar Imóvel'){
		  						$conteudo .= '"A",'; //campo 2
							}
							$conteudo .= '""'.","; //campo 3
							$conteudo .= '"'.$linha['cod'].'",'; //campo 4
						
							if($linha['t_cod']=='3'){
						  		$tipo_imovel = "CASA RESIDENCIAL";
							}else{
						  		$tipo_imovel = $linha['t_nome'];
							}
						
							$conteudo .= '"'.$tipo_imovel.'",'; //campo 5
							$conteudo .= '"'.$linha['ref'].'",'; //campo 6
							if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
								$conteudo .= '"V",'; //campo 7
							}else{
		  						$conteudo .= '"L",'; //campo 7
							}	
							$conteudo .= '"'.number_format($linha['valor'], 2, ',', '.').'",'; //campo 8
							$conteudo .= '"'.str_replace(".", "," , $linha['metragem']).'",'; //campo 9
							$conteudo .= '"'.$linha['ci_nome'].'",'; //campo 10
		
							$bairro1 = explode("--", $linha['bairro']);
							$bairro2 = str_replace("-","",$bairro1);
		
							foreach ($bairro2 as $k => $bairro) {
        						$bairro2[$k] = "'" . $bairro . "'";
    						}
		
							$b_bairro = mysql_query("SELECT b_nome FROM rebri_bairros WHERE b_cod in (" . implode(',',$bairro2) . ") ORDER BY b_cod LIMIT 1");
							while($linha2=mysql_fetch_array($b_bairro)){
		   						$conteudo .= '"'.$linha2['b_nome'].'",'; //campo 11
							}
		
							$conteudo .= '"'.$linha['tipo_logradouro'].'",'; //campo 12
							$conteudo .= '"'.str_replace(",", " ", $linha['end']).'",'; //campo 13
							$conteudo .= '"'.$linha['numero'].'",'; //campo 14
							$conteudo .= '"'.$linha['apto'].'",'; //campo 15
							$conteudo .= '"'.formataCEPParaBd($linha['cep']).'"'.","; //campo 16
							$conteudo .= '"'.$linha['n_quartos'].'",'; //campo 17
							
							$b_caracteristica = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE (c_nome LIKE '01 Garagem' OR c_nome LIKE 'Garagem')");
							if(mysql_num_rows($b_caracteristica) > 0){
								while($linha3 = mysql_fetch_array($b_caracteristica)){
		   							$cod_garagem = $linha3['c_cod'];
								}
							}else{
							  	$b_caracteristica = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE c_nome LIKE '2 /+ Garagem'");
								while($linha4 = mysql_fetch_array($b_caracteristica)){
		   							$cod_garagem2 = $linha4['c_cod'];
								}
							}
    						
    						if($cod_garagem <> '' && $cod_garagem2==''){
							  	if(strstr($linha['caracteristica'], '-'.$cod_garagem.'-')){
								    $conteudo .= '"1",'; //campo 18
								}else{
								 	$conteudo .= '"0",'; //campo 18 
								}
							}elseif($cod_garagem == '' && $cod_garagem2<>''){
								if(strstr($linha['caracteristica'], '-'.$cod_garagem2.'-')){
								    $conteudo .= '"2",'; //campo 18
								}else{
								 	$conteudo .= '"0",'; //campo 18 
								}
							}elseif($cod_garagem == '' && $cod_garagem2==''){
							 	$conteudo .= '"0",'; //campo 18 
							}
							
							$conteudo .= '""'.","; //campo 19
							
							$b_cond_fechado = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE (c_nome LIKE 'Cond. Fechado' OR c_nome LIKE 'Condomínio Fechado')");
							while($linha4 = mysql_fetch_array($b_cond_fechado)){
		   						$cod_cond_fechado = $linha4['c_cod'];
							}
							
							if(strstr($linha['caracteristica'], '-'.$cod_cond_fechado.'-')){
							    $conteudo .= '"s",'; //campo 20
							}else{
							 	$conteudo .= '"n",'; //campo 20 
							}
																				
							if($linha['finalidade']=='5'){
								$conteudo .= '"s",'; //campo 21
							}else{
		  						$conteudo .= '"n",'; //canpo 21
							}
							
							$b_mobiliado = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE c_nome LIKE 'Mobiliado'");
							while($linha5 = mysql_fetch_array($b_mobiliado)){
		   						$cod_mobiliado = $linha5['c_cod'];
							}
							
							if(strstr($linha['caracteristica'], '-'.$cod_mobiliado.'-')){
							    $conteudo .= '"s",'; //campo 22
							}else{
							 	$conteudo .= '"n",'; //campo 22 
							}
							
							$linha['observacoes2'] = str_replace("\n","",$linha['observacoes2']);
							$linha['observacoes2'] = str_replace("\\","",$linha['observacoes2']);
							$linha['observacoes2'] = strip_tags($linha['observacoes2']);
							
							$conteudo .= '"'.$linha['observacoes2'].'",'; //campo 23
							$conteudo .= str_pad('"*"', 1); //campo 24
	
							if(strlen($linha)>1){
								$conteudo .= "\r\n";
							}
		
							echo $conteudo;
						}
					} 
			 	
			 	$data = date("Y-m-d");
				$hora = date("H:i:s");
			  
			  	mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_anuncio, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$id_anuncio."','Exportou TXT IMOVEIS CURITIBA','".$data."','".$hora."')") or die ("Erro 190 - ".mysql_error());  
			}
		}elseif($exportar=='M'){	  
		  	if($tipo_exportacao=='1'){
			  
			  		$busca_codigos = mysql_query("SELECT a.a_imovel, a.a_acao FROM atualizacoes a WHERE a.a_anuncio='".$id_anuncio."' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND a.a_imovel!='' AND (a.a_acao!='Exportou TXT MINHA CASA' AND a.a_acao!='Inserir Imagem' AND a.a_acao!='Apagar Imagem')");
					while($linha2 = mysql_fetch_array($busca_codigos)){  
								  
						$buscaa = mysql_query("SELECT m.cod, t.t_cod, t.t_cod, t.t_nome, m.tipo, m.ref, f.f_nome, m.valor, m.metragem, ci.ci_nome, e.e_uf, m.bairro, m.tipo_logradouro, m.end, m.numero, m.cep, m.n_quartos, m.caracteristica, m.observacoes2, m.finalidade, m.apto, m.observacoes, m.descricao FROM muraski m INNER JOIN finalidade f ON (m.finalidade=f.f_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_cidades ci ON (m.local=ci.ci_cod) INNER JOIN rebri_estados e ON (m.uf=e.e_cod) WHERE m.cod='".$linha2['a_imovel']."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linha = mysql_fetch_array($buscaa)){
					  
					  		$conteudo = '"V.1.0",'; //campo 1
					  		if($linha['finalidade']=='5' || $linha['finalidade']=='12' || $linha['finalidade']=='16' || $linha['ref']=='x' || $linha2['a_acao']=='Excluiu Anúncio'){
		  						$conteudo .= '"X",'; //campo 2
					  		}elseif($linha2['a_acao']=='Adicionou Anúncio' || $linha2['a_acao']=='Atualizou Anúncio'){
		  						$conteudo .= '"A",'; //campo 2
							}
							$conteudo .= '"'.$_SESSION['nome_imobiliaria'].'",'; //campo 3
							if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
								$conteudo .= '"'.$linha['cod'].'.V",'; //campo 4
							}else{
							  	$conteudo .= '"'.$linha['cod'].'",'; //campo 4
							}
						
							if($linha['t_cod']=='3'){
						  		$tipo_imovel = "CASA RESIDENCIAL";
							}elseif($linha['t_cod']=='4'){
						  		$tipo_imovel = "CONJUNTO COMERCIAL";
							}else{
						  		$tipo_imovel = $linha['t_nome'];
							}
						
							$conteudo .= '"'.$tipo_imovel.'",'; //campo 5
							$conteudo .= '"'.$linha['ref'].'",'; //campo 6
							if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
								$conteudo .= '"V",'; //campo 7
							}else{
		  						$conteudo .= '"L",'; //campo 7
							}	
							$conteudo .= '"'.number_format($linha['valor'], 2, ',', '.').'",'; //campo 8
							$conteudo .= '"'.str_replace(".", "," , $linha['metragem']).'",'; //campo 9
							$conteudo .= '"'.$linha['ci_nome'].'",'; //campo 10
		
							$bairro1 = explode("--", $linha['bairro']);
							$bairro2 = str_replace("-","",$bairro1);
		
							foreach ($bairro2 as $k => $bairro) {
        						$bairro2[$k] = "'" . $bairro . "'";
    						}
		
							$b_bairro = mysql_query("SELECT b_nome FROM rebri_bairros WHERE b_cod in (" . implode(',',$bairro2) . ") ORDER BY b_cod LIMIT 1");
							while($linha2=mysql_fetch_array($b_bairro)){
		   						$conteudo .= '"'.$linha2['b_nome'].'",'; //campo 11
							}
		
							$conteudo .= '"'.$linha['tipo_logradouro'].'",'; //campo 16
							$conteudo .= '"'.str_replace(",", " ", $linha['end']).'",'; //campo 17
							$conteudo .= '"'.$linha['numero'].'",'; //campo 18
							$conteudo .= '"'.$linha['apto'].'",'; //campo 19
							$conteudo .= '"'.formataCEPParaBd($linha['cep']).'"'.","; //campo 20
							$conteudo .= '"'.$linha['e_uf'].'",'; //campo 12
							$conteudo .= '""'.","; //campo 13
							$conteudo .= '""'.","; //campo 14
							$conteudo .= '"'.$linha['n_quartos'].'",'; //campo 15
							
							$b_caracteristica = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE (c_nome LIKE '01 Garagem' OR c_nome LIKE 'Garagem')");
							if(mysql_num_rows($b_caracteristica) > 0){
								while($linha3 = mysql_fetch_array($b_caracteristica)){
		   							$cod_garagem = $linha3['c_cod'];
								}
							}else{
							  	$b_caracteristica = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE c_nome LIKE '2 /+ Garagem'");
								while($linha4 = mysql_fetch_array($b_caracteristica)){
		   							$cod_garagem2 = $linha4['c_cod'];
								}
							}
    						
    						if($cod_garagem <> '' && $cod_garagem2==''){
							  	if(strstr($linha['caracteristica'], '-'.$cod_garagem.'-')){
								    $conteudo .= '"1",'; //campo 21
								}else{
								 	$conteudo .= '"0",'; //campo 21 
								}
							}elseif($cod_garagem == '' && $cod_garagem2<>''){
								if(strstr($linha['caracteristica'], '-'.$cod_garagem2.'-')){
								    $conteudo .= '"2",'; //campo 21
								}else{
								 	$conteudo .= '"0",'; //campo 21 
								}
							}elseif($cod_garagem == '' && $cod_garagem2==''){
							 	$conteudo .= '"0",'; //campo 21 
							}
							
							$b_cond_fechado = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE (c_nome LIKE 'Cond. Fechado' OR c_nome LIKE 'Condomínio Fechado')");
							while($linha4 = mysql_fetch_array($b_cond_fechado)){
		   						$cod_cond_fechado = $linha4['c_cod'];
							}
							
							if(strstr($linha['caracteristica'], '-'.$cod_cond_fechado.'-')){
							    $conteudo .= '"s",'; //campo 22
							}else{
							 	$conteudo .= '"n",'; //campo 22 
							}
							
							if($linha['finalidade']=='5'){
								$conteudo .= '"s",'; //campo 23
							}else{
		  						$conteudo .= '"n",'; //canpo 23
							}
							
							$b_mobiliado = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE c_nome LIKE 'Mobiliado'");
							while($linha5 = mysql_fetch_array($b_mobiliado)){
		   						$cod_mobiliado = $linha5['c_cod'];
							}
							
							if(strstr($linha['caracteristica'], '-'.$cod_mobiliado.'-')){
							    $conteudo .= '"s",'; //campo 24
							}else{
							 	$conteudo .= '"n",'; //campo 24 
							}

							$linha['descricao'] = str_replace("\n"," ",$linha['descricao']);
							$linha['descricao'] = str_replace("\r"," ",$linha['descricao']);
							$linha['descricao'] = str_replace("\t"," ",$linha['descricao']);
							$linha['descricao'] = str_replace("\\"," ",$linha['descricao']);
							$linha['descricao'] = strip_tags($linha['descricao']);
							$conteudo .= '"'.$linha['descricao'].'",'; //campo 25
							$linha['observacoes2'] = str_replace("\n"," ",$linha['observacoes2']);
							$linha['observacoes2'] = str_replace("\r"," ",$linha['observacoes2']);
							$linha['observacoes2'] = str_replace("\t"," ",$linha['observacoes2']);
							$linha['observacoes2'] = str_replace("\\","",$linha['observacoes2']);
							$linha['observacoes2'] = strip_tags($linha['observacoes2']);
							$conteudo .= '"'.$linha['observacoes2'].'",'; //campo 26
							$linha['observacoes'] = str_replace("\n"," ",$linha['observacoes']);
							$linha['observacoes'] = str_replace("\r"," ",$linha['observacoes']);
							$linha['observacoes'] = str_replace("\t"," ",$linha['observacoes']);
							$linha['observacoes'] = str_replace("\\","",$linha['observacoes']);
							$linha['observacoes'] = strip_tags($linha['observacoes']);
							//$conteudo .= '"'.$linha['observacoes'].'"'; //campo 27
							
							if(strlen($linha)>1){
								$conteudo .= "\r\n";
							}
		
							echo $conteudo;
						}
					}
			}elseif($tipo_exportacao=='2'){			  	
			  	
				$busca_atualizacao = mysql_query("SELECT a.a_data, a.a_hora FROM atualizacoes a WHERE a.a_anuncio='".$id_anuncio."' AND a.a_acao='Exportou TXT MINHA CASA' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.a_data DESC, a.a_hora DESC LIMIT 1");
				while($linha1 = mysql_fetch_array($busca_atualizacao)){  			  	
			  		$ultima_data = $linha1['a_data'];
			  		$ultima_hora = $linha1['a_hora'];
				}			  	
			  	
					$busca_codigos = mysql_query("SELECT a.a_imovel, a.a_acao FROM atualizacoes a LEFT JOIN imoveis_anuncio ia ON (ia.cod_imovel=a.a_imovel) WHERE ia.id_anuncio='".$id_anuncio."' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND ((a.a_data = '$ultima_data' AND a.a_hora >= '$ultima_hora') OR (a.a_data > '$ultima_data')) AND (a.a_acao!='Exportou TXT MINHA CASA' AND a.a_acao!='Inserir Imagem' AND a.a_acao!='Apagar Imagem')");		 	
					while($linha2 = mysql_fetch_array($busca_codigos)){ 
					  
					  	$buscaa = mysql_query("SELECT m.cod, t.t_cod, t.t_cod, t.t_nome, m.tipo, m.ref, f.f_nome, m.valor, m.metragem, ci.ci_nome, e.e_uf, m.bairro, m.tipo_logradouro, m.end, m.numero, m.cep, m.n_quartos, m.caracteristica, m.observacoes2, m.finalidade, m.apto, m.observacoes, m.descricao FROM muraski m INNER JOIN finalidade f ON (m.finalidade=f.f_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_cidades ci ON (m.local=ci.ci_cod) INNER JOIN rebri_estados e ON (m.uf=e.e_cod) WHERE m.cod='".$linha2['a_imovel']."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linha = mysql_fetch_array($buscaa)){			  	
					
							$conteudo = '"V.1.0",'; //campo 1
					  		if($linha['finalidade']=='5' || $linha['finalidade']=='12' || $linha['finalidade']=='16' || $linha['ref']=='x' || $linha2['a_acao']=='Excluiu Anúncio'){
		  						$conteudo .= '"X",'; //campo 2
					  		}elseif($linha2['a_acao']=='Adicionou Anúncio' || $linha2['a_acao']=='Atualizou Anúncio'){
		  						$conteudo .= '"A",'; //campo 2
							}
							$conteudo .= '"'.$_SESSION['nome_imobiliaria'].'",'; //campo 3
							if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
								$conteudo .= '"'.$linha['cod'].'.V",'; //campo 4
							}else{
							  	$conteudo .= '"'.$linha['cod'].'",'; //campo 4
							}
						
							if($linha['t_cod']=='3'){
						  		$tipo_imovel = "CASA RESIDENCIAL";
							}elseif($linha['t_cod']=='4'){
						  		$tipo_imovel = "CONJUNTO COMERCIAL";
							}else{
						  		$tipo_imovel = $linha['t_nome'];
							}
						
							$conteudo .= '"'.$tipo_imovel.'",'; //campo 5
							$conteudo .= '"'.$linha['ref'].'",'; //campo 6
							if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
								$conteudo .= '"V",'; //campo 7
							}else{
		  						$conteudo .= '"L",'; //campo 7
							}	
							$conteudo .= '"'.number_format($linha['valor'], 2, ',', '.').'",'; //campo 8
							$conteudo .= '"'.str_replace(".", "," , $linha['metragem']).'",'; //campo 9
							$conteudo .= '"'.$linha['ci_nome'].'",'; //campo 10
		
							$bairro1 = explode("--", $linha['bairro']);
							$bairro2 = str_replace("-","",$bairro1);
		
							foreach ($bairro2 as $k => $bairro) {
        						$bairro2[$k] = "'" . $bairro . "'";
    						}
		
							$b_bairro = mysql_query("SELECT b_nome FROM rebri_bairros WHERE b_cod in (" . implode(',',$bairro2) . ") ORDER BY b_cod LIMIT 1");
							while($linha2=mysql_fetch_array($b_bairro)){
		   						$conteudo .= '"'.$linha2['b_nome'].'",'; //campo 11
							}
		
							$conteudo .= '"'.$linha['tipo_logradouro'].'",'; //campo 16
							$conteudo .= '"'.str_replace(",", " ", $linha['end']).'",'; //campo 17
							$conteudo .= '"'.$linha['numero'].'",'; //campo 18
							$conteudo .= '"'.$linha['apto'].'",'; //campo 19
							$conteudo .= '"'.formataCEPParaBd($linha['cep']).'"'.","; //campo 20
							$conteudo .= '"'.$linha['e_uf'].'",'; //campo 12
							$conteudo .= '""'.","; //campo 13
							$conteudo .= '""'.","; //campo 14
							$conteudo .= '"'.$linha['n_quartos'].'",'; //campo 15
							
							$b_caracteristica = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE (c_nome LIKE '01 Garagem' OR c_nome LIKE 'Garagem')");
							if(mysql_num_rows($b_caracteristica) > 0){
								while($linha3 = mysql_fetch_array($b_caracteristica)){
		   							$cod_garagem = $linha3['c_cod'];
								}
							}else{
							  	$b_caracteristica = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE c_nome LIKE '2 /+ Garagem'");
								while($linha4 = mysql_fetch_array($b_caracteristica)){
		   							$cod_garagem2 = $linha4['c_cod'];
								}
							}
    						
    						if($cod_garagem <> '' && $cod_garagem2==''){
							  	if(strstr($linha['caracteristica'], '-'.$cod_garagem.'-')){
								    $conteudo .= '"1",'; //campo 21
								}else{
								 	$conteudo .= '"0",'; //campo 21 
								}
							}elseif($cod_garagem == '' && $cod_garagem2<>''){
								if(strstr($linha['caracteristica'], '-'.$cod_garagem2.'-')){
								    $conteudo .= '"2",'; //campo 21
								}else{
								 	$conteudo .= '"0",'; //campo 21 
								}
							}elseif($cod_garagem == '' && $cod_garagem2==''){
							 	$conteudo .= '"0",'; //campo 21 
							}
							
							$b_cond_fechado = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE (c_nome LIKE 'Cond. Fechado' OR c_nome LIKE 'Condomínio Fechado')");
							while($linha4 = mysql_fetch_array($b_cond_fechado)){
		   						$cod_cond_fechado = $linha4['c_cod'];
							}
							
							if(strstr($linha['caracteristica'], '-'.$cod_cond_fechado.'-')){
							    $conteudo .= '"s",'; //campo 22
							}else{
							 	$conteudo .= '"n",'; //campo 22 
							}
							
							if($linha['finalidade']=='5'){
								$conteudo .= '"s",'; //campo 23
							}else{
		  						$conteudo .= '"n",'; //canpo 23
							}
							
							$b_mobiliado = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE c_nome LIKE 'Mobiliado'");
							while($linha5 = mysql_fetch_array($b_mobiliado)){
		   						$cod_mobiliado = $linha5['c_cod'];
							}
							
							if(strstr($linha['caracteristica'], '-'.$cod_mobiliado.'-')){
							    $conteudo .= '"s",'; //campo 24
							}else{
							 	$conteudo .= '"n",'; //campo 24 
							}
							
							$linha['descricao'] = str_replace("\n"," ",$linha['descricao']);
							$linha['descricao'] = str_replace("\r"," ",$linha['descricao']);
							$linha['descricao'] = str_replace("\t"," ",$linha['descricao']);
							$linha['descricao'] = str_replace("\\","",$linha['descricao']);
							$linha['descricao'] = strip_tags($linha['descricao']);
							$conteudo .= '"'.$linha['descricao'].'",'; //campo 25
							$linha['observacoes2'] = str_replace("\n"," ",$linha['observacoes2']);
							$linha['observacoes2'] = str_replace("\r"," ",$linha['observacoes2']);
							$linha['observacoes2'] = str_replace("\t"," ",$linha['observacoes2']);
							$linha['observacoes2'] = str_replace("\\","",$linha['observacoes2']);
							$linha['observacoes2'] = strip_tags($linha['observacoes2']);
							$conteudo .= '"'.$linha['observacoes2'].'",'; //campo 26
							$linha['observacoes'] = str_replace("\n"," ",$linha['observacoes']);
							$linha['observacoes'] = str_replace("\r"," ",$linha['observacoes']);
							$linha['observacoes'] = str_replace("\t"," ",$linha['observacoes']);
							$linha['observacoes'] = str_replace("\\","",$linha['observacoes']);
							$linha['observacoes'] = strip_tags($linha['observacoes']);
							//$conteudo .= '"'.$linha['observacoes'].'"'; //campo 27
							
							if(strlen($linha)>1){
								$conteudo .= "\r\n";
							}
		
							echo $conteudo;
						}
					} 
			 	
			 	$data = date("Y-m-d");
				$hora = date("H:i:s");
			  
			  	mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_anuncio, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$id_anuncio."','Exportou TXT MINHA CASA','".$data."','".$hora."')") or die ("Erro 373 - ".mysql_error());  
			  	
			}elseif($tipo_exportacao=='3'){
			  
			  		$busca_codigos = mysql_query("SELECT a.a_imovel, a.a_acao FROM atualizacoes a WHERE a.a_anuncio='".$id_anuncio."' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND a.a_imovel!='' AND (a.a_acao!='Exportou TXT MINHA CASA' AND a.a_acao!='Inserir Imagem' AND a.a_acao!='Apagar Imagem')");
					//while($linha2 = mysql_fetch_array($busca_codigos)){  
								  
						$buscaa = mysql_query("SELECT m.cod, t.t_cod, t.t_cod, t.t_nome, m.tipo, m.ref, f.f_nome, m.valor, m.metragem, ci.ci_nome, e.e_uf, m.bairro, m.tipo_logradouro, m.end, m.numero, m.cep, m.n_quartos, m.caracteristica, m.observacoes2, m.finalidade, m.apto, m.observacoes, m.descricao FROM muraski m INNER JOIN finalidade f ON (m.finalidade=f.f_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_cidades ci ON (m.local=ci.ci_cod) INNER JOIN rebri_estados e ON (m.uf=e.e_cod) WHERE m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linha = mysql_fetch_array($buscaa)){
					  
					  		$conteudo = '"V.1.0",'; //campo 1
					  		if($linha['finalidade']=='5' || $linha['finalidade']=='12' || $linha['finalidade']=='16' || $linha['ref']=='x' || $linha2['a_acao']=='Excluiu Anúncio'){
		  						$conteudo .= '"X",'; //campo 2
					  		}elseif($linha2['a_acao']=='Adicionou Anúncio' || $linha2['a_acao']=='Atualizou Anúncio'){
		  						$conteudo .= '"A",'; //campo 2
							}
							$conteudo .= '"'.$_SESSION['nome_imobiliaria'].'",'; //campo 3
							if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
								$conteudo .= '"'.$linha['cod'].'.V",'; //campo 4
							}else{
							  	$conteudo .= '"'.$linha['cod'].'",'; //campo 4
							}
						
							if($linha['t_cod']=='3'){
						  		$tipo_imovel = "CASA RESIDENCIAL";
							}elseif($linha['t_cod']=='4'){
						  		$tipo_imovel = "CONJUNTO COMERCIAL";
							}else{
						  		$tipo_imovel = $linha['t_nome'];
							}
						
							$conteudo .= '"'.$tipo_imovel.'",'; //campo 5
							$conteudo .= '"'.$linha['ref'].'",'; //campo 6
							if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
								$conteudo .= '"V",'; //campo 7
							}else{
		  						$conteudo .= '"L",'; //campo 7
							}	
							$conteudo .= '"'.number_format($linha['valor'], 2, ',', '.').'",'; //campo 8
							$conteudo .= '"'.str_replace(".", "," , $linha['metragem']).'",'; //campo 9
							$conteudo .= '"'.$linha['ci_nome'].'",'; //campo 10
		
							$bairro1 = explode("--", $linha['bairro']);
							$bairro2 = str_replace("-","",$bairro1);
		
							foreach ($bairro2 as $k => $bairro) {
        						$bairro2[$k] = "'" . $bairro . "'";
    						}
		
							$b_bairro = mysql_query("SELECT b_nome FROM rebri_bairros WHERE b_cod in (" . implode(',',$bairro2) . ") ORDER BY b_cod LIMIT 1");
							while($linha2=mysql_fetch_array($b_bairro)){
		   						$conteudo .= '"'.$linha2['b_nome'].'",'; //campo 11
							}
		
							$conteudo .= '"'.$linha['tipo_logradouro'].'",'; //campo 16
							$conteudo .= '"'.str_replace(",", " ", $linha['end']).'",'; //campo 17
							$conteudo .= '"'.$linha['numero'].'",'; //campo 18
							$conteudo .= '"'.$linha['apto'].'",'; //campo 19
							$conteudo .= '"'.formataCEPParaBd($linha['cep']).'"'.","; //campo 20
							$conteudo .= '"'.$linha['e_uf'].'",'; //campo 12
							$conteudo .= '""'.","; //campo 13
							$conteudo .= '""'.","; //campo 14
							$conteudo .= '"'.$linha['n_quartos'].'",'; //campo 15
							
							$b_caracteristica = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE (c_nome LIKE '01 Garagem' OR c_nome LIKE 'Garagem')");
							if(mysql_num_rows($b_caracteristica) > 0){
								while($linha3 = mysql_fetch_array($b_caracteristica)){
		   							$cod_garagem = $linha3['c_cod'];
								}
							}else{
							  	$b_caracteristica = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE c_nome LIKE '2 /+ Garagem'");
								while($linha4 = mysql_fetch_array($b_caracteristica)){
		   							$cod_garagem2 = $linha4['c_cod'];
								}
							}
    						
    						if($cod_garagem <> '' && $cod_garagem2==''){
							  	if(strstr($linha['caracteristica'], '-'.$cod_garagem.'-')){
								    $conteudo .= '"1",'; //campo 21
								}else{
								 	$conteudo .= '"0",'; //campo 21 
								}
							}elseif($cod_garagem == '' && $cod_garagem2<>''){
								if(strstr($linha['caracteristica'], '-'.$cod_garagem2.'-')){
								    $conteudo .= '"2",'; //campo 21
								}else{
								 	$conteudo .= '"0",'; //campo 21 
								}
							}elseif($cod_garagem == '' && $cod_garagem2==''){
							 	$conteudo .= '"0",'; //campo 21 
							}
							
							$b_cond_fechado = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE (c_nome LIKE 'Cond. Fechado' OR c_nome LIKE 'Condomínio Fechado')");
							while($linha4 = mysql_fetch_array($b_cond_fechado)){
		   						$cod_cond_fechado = $linha4['c_cod'];
							}
							
							if(strstr($linha['caracteristica'], '-'.$cod_cond_fechado.'-')){
							    $conteudo .= '"s",'; //campo 22
							}else{
							 	$conteudo .= '"n",'; //campo 22 
							}
							
							if($linha['finalidade']=='5'){
								$conteudo .= '"s",'; //campo 23
							}else{
		  						$conteudo .= '"n",'; //canpo 23
							}
							
							$b_mobiliado = mysql_query("SELECT c_cod FROM rebri_caracteristicas WHERE c_nome LIKE 'Mobiliado'");
							while($linha5 = mysql_fetch_array($b_mobiliado)){
		   						$cod_mobiliado = $linha5['c_cod'];
							}
							
							if(strstr($linha['caracteristica'], '-'.$cod_mobiliado.'-')){
							    $conteudo .= '"s",'; //campo 24
							}else{
							 	$conteudo .= '"n",'; //campo 24 
							}

							$linha['descricao'] = str_replace("\n"," ",$linha['descricao']);
							$linha['descricao'] = str_replace("\r"," ",$linha['descricao']);
							$linha['descricao'] = str_replace("\t"," ",$linha['descricao']);
							$linha['descricao'] = str_replace("\\"," ",$linha['descricao']);
							$linha['descricao'] = strip_tags($linha['descricao']);
							$conteudo .= '"'.$linha['descricao'].'",'; //campo 25
							$linha['observacoes2'] = str_replace("\n"," ",$linha['observacoes2']);
							$linha['observacoes2'] = str_replace("\r"," ",$linha['observacoes2']);
							$linha['observacoes2'] = str_replace("\t"," ",$linha['observacoes2']);
							$linha['observacoes2'] = str_replace("\\","",$linha['observacoes2']);
							$linha['observacoes2'] = strip_tags($linha['observacoes2']);
							$conteudo .= '"'.$linha['observacoes2'].'",'; //campo 26
							$linha['observacoes'] = str_replace("\n"," ",$linha['observacoes']);
							$linha['observacoes'] = str_replace("\r"," ",$linha['observacoes']);
							$linha['observacoes'] = str_replace("\t"," ",$linha['observacoes']);
							$linha['observacoes'] = str_replace("\\","",$linha['observacoes']);
							$linha['observacoes'] = strip_tags($linha['observacoes']);
							//$conteudo .= '"'.$linha['observacoes'].'"'; //campo 27
							
							if(strlen($linha)>1){
								$conteudo .= "\r\n";
							}
		
							echo $conteudo;
						}
					//}
			}
		}
?>